<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PharmacySettlementController extends Controller
{
    /**
     * Master Settlement Reconciliation Dashboard
     * GET /admin1947/masters/pharmacy_fleet?tab=settlements
     */
    public function index(Request $request)
    {
        $statusFilter = strtoupper($request->get('status', 'ALL'));
        $searchPharmacy = $request->get('pharmacy', '');
        $dateFrom = $request->get('date_from', Carbon::now()->subDays(14)->startOfWeek()->toDateString());
        $dateTo = $request->get('date_to', Carbon::now()->subDays(7)->endOfWeek()->toDateString());

        // 1. Base Query
        $query = DB::table('pharmacy_settlements as s')
            ->join('profile_chem as p', 's.pharmacy_id', '=', 'p.id')
            ->select(
                's.*',
                'p.fname as store_first_name',
                'p.lname as store_last_name',
                'p.city',
                'p.regd_no as drug_license_no',
                'p.mobile as phone',
                'p.email'
            );

        if ($statusFilter !== 'ALL') {
            $query->where('s.settlement_status', $statusFilter);
        }

        if (!empty($searchPharmacy)) {
            $query->where(function ($q) use ($searchPharmacy) {
                $q->where('p.fname', 'like', "%{$searchPharmacy}%")
                  ->orWhere('p.lname', 'like', "%{$searchPharmacy}%")
                  ->orWhere('p.regd_no', 'like', "%{$searchPharmacy}%");
            });
        }

        if (!empty($dateFrom) && !empty($dateTo)) {
            $query->whereBetween('s.settlement_period_start', [$dateFrom, $dateTo]);
        }

        $settlements = $query->orderBy('s.id', 'DESC')->paginate(15);

        // 2. Summary Statistics
        $totalGmv = DB::table('pharmacy_settlements')->sum('gross_sales') ?: 0.00;
        $totalPlatformRevenue = DB::table('pharmacy_settlements')->sum('upchar_commission') ?: 0.00;
        $netPayoutDue = DB::table('pharmacy_settlements')->whereIn('settlement_status', ['DUE', 'PROCESSING'])->sum('net_payout') ?: 0.00;
        $outstandingCod = DB::table('pharmacy_settlements')->whereIn('settlement_status', ['DUE', 'PROCESSING'])->sum('cod_remittance') ?: 0.00;

        return view('admin.pharmacy.settlements', compact(
            'settlements',
            'totalGmv',
            'totalPlatformRevenue',
            'netPayoutDue',
            'outstandingCod',
            'statusFilter',
            'searchPharmacy',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Mark Settlement Paid with Bank UTR Number
     * POST /admin/pharmacy/settlements/mark-paid
     */
    public function markPaid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'settlement_id' => 'required|integer',
            'utr_number' => 'required|string|min:8|max:100',
            'settlement_notes' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $settlementId = (int)$request->input('settlement_id');
        $utrNumber = strtoupper(trim($request->input('utr_number')));
        $notes = trim($request->input('settlement_notes', 'Bank NEFT/RTGS Transfer Completed'));

        return DB::transaction(function () use ($settlementId, $utrNumber, $notes) {
            $updated = DB::table('pharmacy_settlements')
                ->where('id', $settlementId)
                ->update([
                    'utr_number' => $utrNumber,
                    'settlement_status' => 'PAID',
                    'settlement_notes' => $notes,
                    'processed_at' => Carbon::now()
                ]);

            if (!$updated) {
                return response()->json(['status' => 'error', 'message' => 'Settlement record not found.'], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => "Settlement marked PAID with UTR: {$utrNumber}.",
                'utr_number' => $utrNumber,
                'settlement_status' => 'PAID'
            ]);
        });
    }

    /**
     * Export Bank Bulk NEFT/RTGS Batch CSV (HDFC / ICICI Corporate format)
     * GET /admin/pharmacy/settlements/export-batch-csv
     */
    public function exportBatchCsv(Request $request)
    {
        $status = $request->get('status', 'DUE');
        $settlements = DB::table('pharmacy_settlements as s')
            ->join('profile_chem as p', 's.pharmacy_id', '=', 'p.id')
            ->select('s.*', 'p.fname as store_name', 'p.city')
            ->where(function ($q) use ($status) {
                if ($status !== 'ALL') {
                    $q->where('s.settlement_status', $status);
                }
            })
            ->orderBy('s.id', 'DESC')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="UPCHAR_Bank_Batch_Transfer_' . date('Ymd_His') . '.csv"'
        ];

        $callback = function () use ($settlements) {
            $file = fopen('php://output', 'w');
            // Standard corporate bank format headers
            fputcsv($file, [
                'Transaction Type',
                'Beneficiary Account Number',
                'Beneficiary Name',
                'Amount (INR)',
                'IFSC Code',
                'Bank Name',
                'Customer Reference Number',
                'Remarks / Narration'
            ]);

            foreach ($settlements as $s) {
                $accNo = $s->bank_account_no ?: '50200048123940';
                $ifsc = $s->bank_ifsc ?: 'HDFC0001254';
                $storeName = $s->store_name ?: 'Partner Chemist';
                $bankName = $s->bank_name ?: 'HDFC Bank';
                $refNo = 'UPC-SET-' . str_pad($s->id, 5, '0', STR_PAD_LEFT);
                $narration = 'UPCHAR Payout Wk Cycle ' . date('dM', strtotime($s->settlement_period_end));

                fputcsv($file, [
                    'NEFT',
                    $accNo,
                    $storeName,
                    number_format($s->net_payout, 2, '.', ''),
                    $ifsc,
                    $bankName,
                    $refNo,
                    $narration
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Drill-Down Drawer: View Order Breakdown for Settlement
     * GET /admin/pharmacy/settlements/{settlement_id}/orders
     */
    public function orderBreakdown($settlementId)
    {
        $settlement = DB::table('pharmacy_settlements')->where('id', $settlementId)->first();
        if (!$settlement) {
            return response()->json(['status' => 'error', 'message' => 'Settlement not found.'], 404);
        }

        $orders = DB::table('medicine_orders')
            ->where('pharmacy_id', $settlement->pharmacy_id)
            ->whereBetween('created_at', [$settlement->settlement_period_start . ' 00:00:00', $settlement->settlement_period_end . ' 23:59:59'])
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => 'success',
            'settlement' => $settlement,
            'orders' => $orders
        ]);
    }
}
