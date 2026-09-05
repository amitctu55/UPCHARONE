<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Fetch Global Platform Settings (Platform Fee %, GST %, GSTIN)
     */
    public function get_platform_settings() {
        $row = $this->db->get('platform_settings')->row();
        if (!$row) {
            return (object) array(
                'setting_id' => 1,
                'default_platform_fee_percent' => 10.00,
                'gst_percent' => 18.00,
                'upchar_gstin' => '07AAAAU1234A1Z5',
                'upchar_company_name' => 'Upchar Health Technologies Pvt Ltd',
                'upchar_address' => 'Plot No. 42, Health City, New Delhi - 110001',
                'updated_at' => date('Y-m-d H:i:s')
            );
        }
        return $row;
    }

    /**
     * Update Global Platform Settings
     */
    public function update_platform_settings($data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $exists = $this->db->get('platform_settings')->row();
        if ($exists) {
            $this->db->where('setting_id', $exists->setting_id);
            return $this->db->update('platform_settings', $data);
        } else {
            return $this->db->insert('platform_settings', $data);
        }
    }

    /**
     * Get Effective Platform Fee Commission Rate for a Facility (Custom override or global default)
     */
    public function get_facility_commission_rate($facility_type, $facility_id) {
        $custom = $this->db->get_where('facility_custom_commissions', array(
            'facility_type' => strtolower($facility_type),
            'facility_id'   => intval($facility_id)
        ))->row();

        if ($custom && isset($custom->platform_fee_percent)) {
            return (object) array(
                'rate'      => floatval($custom->platform_fee_percent),
                'is_custom' => 1,
                'notes'     => $custom->notes
            );
        }

        $settings = $this->get_platform_settings();
        return (object) array(
            'rate'      => floatval($settings->default_platform_fee_percent),
            'is_custom' => 0,
            'notes'     => 'Default Global Rate'
        );
    }

    /**
     * Set Custom Commission Rate for Facility (Acquisition Tool)
     */
    public function set_facility_custom_commission($facility_type, $facility_id, $rate, $admin_id = 1, $notes = '') {
        $facility_type = strtolower($facility_type);
        $facility_id   = intval($facility_id);
        $rate          = floatval($rate);

        $existing = $this->db->get_where('facility_custom_commissions', array(
            'facility_type' => $facility_type,
            'facility_id'   => $facility_id
        ))->row();

        $data = array(
            'facility_type'        => $facility_type,
            'facility_id'          => $facility_id,
            'platform_fee_percent' => $rate,
            'updated_by_admin_id'  => intval($admin_id),
            'notes'                => $notes,
            'updated_at'           => date('Y-m-d H:i:s')
        );

        if ($existing) {
            $this->db->where('id', $existing->id);
            return $this->db->update('facility_custom_commissions', $data);
        } else {
            return $this->db->insert('facility_custom_commissions', $data);
        }
    }

    /**
     * Calculate Revenue Split (Gross, Fee %, Fee Amt, GST, CGST, SGST, Total Deductions, Net Facility Share)
     */
    public function calculate_revenue_split($gross_amount, $facility_type, $facility_id) {
        $gross        = floatval($gross_amount);
        $commInfo     = $this->get_facility_commission_rate($facility_type, $facility_id);
        $fee_percent  = $commInfo->rate;
        $is_custom    = $commInfo->is_custom;

        $settings     = $this->get_platform_settings();
        $gst_percent  = floatval($settings->gst_percent);

        // Platform fee on gross amount
        $fee_amount   = round($gross * ($fee_percent / 100), 2);
        
        // Dynamic GST strictly on Upchar Platform Fee (service brokerage charge)
        $half_rate    = ($gst_percent / 2) / 100;
        $cgst_amount  = round($fee_amount * $half_rate, 2);
        $sgst_amount  = round($fee_amount * $half_rate, 2);
        $gst_amount   = round($cgst_amount + $sgst_amount, 2);
        
        $deduction    = round($fee_amount + $gst_amount, 2);
        $net_share    = round($gross - $deduction, 2);

        return array(
            'gross_amount'             => $gross,
            'platform_fee_percent'     => $fee_percent,
            'is_custom_rate'           => $is_custom,
            'platform_fee_amount'      => $fee_amount,
            'gst_percent'              => $gst_percent,
            'cgst_amount'              => $cgst_amount,
            'sgst_amount'              => $sgst_amount,
            'gst_amount'               => $gst_amount,
            'total_platform_deduction' => $deduction,
            'net_facility_share'       => $net_share
        );
    }

    /**
     * Recalculate Valuations & Tax Splits across existing transactions
     */
    public function recalculate_financial_valuations($scope = 'all', $facility_type = null, $facility_id = null) {
        if ($scope === 'pending') {
            $this->db->where_in('payout_status', array('pending', 'queued'));
        }
        if (!empty($facility_type) && !empty($facility_id)) {
            $this->db->where('facility_type', strtolower($facility_type));
            $this->db->where('facility_id', intval($facility_id));
        }

        $transactions = $this->db->get('financial_transactions')->result();
        $updated_count = 0;

        foreach ($transactions as $txn) {
            $split = $this->calculate_revenue_split($txn->gross_amount, $txn->facility_type, $txn->facility_id);

            $this->db->where('txn_id', $txn->txn_id);
            $this->db->update('financial_transactions', array(
                'platform_fee_percent'     => $split['platform_fee_percent'],
                'is_custom_rate'           => $split['is_custom_rate'],
                'platform_fee_amount'      => $split['platform_fee_amount'],
                'cgst_amount'              => $split['cgst_amount'],
                'sgst_amount'              => $split['sgst_amount'],
                'gst_amount'               => $split['gst_amount'],
                'total_platform_deduction' => $split['total_platform_deduction'],
                'net_facility_share'       => $split['net_facility_share']
            ));
            $updated_count++;
        }

        return $updated_count;
    }

    /**
     * Record a new encounter into financial_transactions
     */
    public function record_financial_transaction($facility_type, $facility_id, $facility_name, $encounter_id, $category, $patient_id, $patient_name, $patient_mobile, $patient_email, $gross_amount, $payment_status = 'paid', $payout_status = 'pending') {
        $split = $this->calculate_revenue_split($gross_amount, $facility_type, $facility_id);
        $txnCode = '#TXN-' . date('Y') . '-' . rand(10000, 99999);

        $data = array(
            'txn_code'                 => $txnCode,
            'facility_type'            => strtolower($facility_type),
            'facility_id'              => intval($facility_id),
            'facility_name'            => $facility_name,
            'encounter_id'             => intval($encounter_id),
            'category'                 => $category,
            'patient_id'               => intval($patient_id),
            'patient_name'             => $patient_name,
            'patient_mobile'           => $patient_mobile,
            'patient_email'            => $patient_email,
            'gross_amount'             => $split['gross_amount'],
            'platform_fee_percent'     => $split['platform_fee_percent'],
            'is_custom_rate'           => $split['is_custom_rate'],
            'platform_fee_amount'      => $split['platform_fee_amount'],
            'cgst_amount'              => $split['cgst_amount'],
            'sgst_amount'              => $split['sgst_amount'],
            'gst_amount'               => $split['gst_amount'],
            'total_platform_deduction' => $split['total_platform_deduction'],
            'net_facility_share'       => $split['net_facility_share'],
            'payment_status'           => $payment_status,
            'payout_status'            => $payout_status,
            'settlement_date'          => ($payout_status === 'settled' || $payout_status === 'processed') ? date('Y-m-d H:i:s') : null,
            'created_at'               => date('Y-m-d H:i:s')
        );

        $this->db->insert('financial_transactions', $data);
        return $this->db->insert_id();
    }

    /**
     * Admin Dashboard High-Level Live Aggregated Revenue Metrics
     */
    public function get_admin_revenue_metrics($filters = array()) {
        $this->db->select('
            COUNT(txn_id) as total_txns,
            COALESCE(SUM(CASE WHEN payment_status != "failed" THEN gross_amount ELSE 0 END), 0) as gross_platform_volume,
            COALESCE(SUM(CASE WHEN payment_status != "failed" THEN platform_fee_amount ELSE 0 END), 0) as total_platform_fee_earned,
            COALESCE(SUM(CASE WHEN payment_status != "failed" THEN cgst_amount ELSE 0 END), 0) as total_cgst,
            COALESCE(SUM(CASE WHEN payment_status != "failed" THEN sgst_amount ELSE 0 END), 0) as total_sgst,
            COALESCE(SUM(CASE WHEN payment_status != "failed" THEN gst_amount ELSE 0 END), 0) as total_gst_collected,
            COALESCE(SUM(CASE WHEN payment_status != "failed" THEN total_platform_deduction ELSE 0 END), 0) as total_upchar_revenue,
            COALESCE(SUM(CASE WHEN payout_status IN ("settled", "processed") THEN net_facility_share ELSE 0 END), 0) as total_payouts_settled,
            COALESCE(SUM(CASE WHEN payout_status = "queued" THEN net_facility_share ELSE 0 END), 0) as total_payouts_queued,
            COALESCE(SUM(CASE WHEN payout_status IN ("pending", "queued") THEN net_facility_share ELSE 0 END), 0) as total_payouts_pending
        ');

        if (!empty($filters['facility_type']) && $filters['facility_type'] !== 'all') {
            $this->db->where('facility_type', strtolower($filters['facility_type']));
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(created_at) >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(created_at) <=', $filters['date_to']);
        }
        if (!empty($filters['month'])) {
            $this->db->where('MONTH(created_at)', intval($filters['month']));
        }
        if (!empty($filters['year'])) {
            $this->db->where('YEAR(created_at)', intval($filters['year']));
        }

        return $this->db->get('financial_transactions')->row();
    }

    /**
     * Category Revenue Breakdown for KPI Modal
     */
    public function get_revenue_category_breakdown($filters = array()) {
        $this->db->select('
            category,
            COUNT(txn_id) as total_txns,
            COALESCE(SUM(gross_amount), 0) as gross_amount,
            COALESCE(SUM(platform_fee_amount), 0) as fee_amount,
            COALESCE(SUM(gst_amount), 0) as gst_amount,
            COALESCE(SUM(net_facility_share), 0) as net_share
        ');
        if (!empty($filters['facility_type']) && $filters['facility_type'] !== 'all') {
            $this->db->where('facility_type', strtolower($filters['facility_type']));
        }
        $this->db->group_by('category');
        $this->db->order_by('gross_amount', 'DESC');
        return $this->db->get('financial_transactions')->result();
    }

    /**
     * Top Revenue Facilities
     */
    public function get_top_revenue_facilities($limit = 5) {
        $this->db->select('
            facility_type,
            facility_id,
            facility_name,
            COUNT(txn_id) as total_txns,
            COALESCE(SUM(gross_amount), 0) as gross_amount,
            COALESCE(SUM(platform_fee_amount), 0) as fee_amount,
            COALESCE(SUM(net_facility_share), 0) as net_share
        ');
        $this->db->group_by(array('facility_type', 'facility_id', 'facility_name'));
        $this->db->order_by('gross_amount', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('financial_transactions')->result();
    }

    /**
     * Fetch Transactions with multi-criteria dynamic filter
     */
    public function get_all_platform_transactions($filters = array(), $limit = 100, $offset = 0) {
        $this->_apply_transaction_filters($filters);

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('financial_transactions')->result();
    }

    /**
     * Count total transactions matching filter
     */
    public function count_all_platform_transactions($filters = array()) {
        $this->_apply_transaction_filters($filters);
        return $this->db->count_all_results('financial_transactions');
    }

    /**
     * Private helper to apply search and filter clauses
     */
    private function _apply_transaction_filters($filters) {
        if (!empty($filters['facility_type']) && $filters['facility_type'] !== 'all') {
            $this->db->where('facility_type', strtolower($filters['facility_type']));
        }
        if (!empty($filters['facility_id'])) {
            $this->db->where('facility_id', intval($filters['facility_id']));
        }
        if (!empty($filters['payout_status']) && $filters['payout_status'] !== 'all') {
            if ($filters['payout_status'] === 'settled') {
                $this->db->where_in('payout_status', array('settled', 'processed'));
            } else {
                $this->db->where('payout_status', $filters['payout_status']);
            }
        }
        if (!empty($filters['payment_status']) && $filters['payment_status'] !== 'all') {
            $this->db->where('payment_status', $filters['payment_status']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(created_at) >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(created_at) <=', $filters['date_to']);
        }
        if (!empty($filters['month'])) {
            $this->db->where('MONTH(created_at)', intval($filters['month']));
        }
        if (!empty($filters['year'])) {
            $this->db->where('YEAR(created_at)', intval($filters['year']));
        }
        if (!empty($filters['search'])) {
            $s = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('txn_code', $s);
            $this->db->or_like('patient_name', $s);
            $this->db->or_like('patient_mobile', $s);
            $this->db->or_like('patient_email', $s);
            $this->db->or_like('facility_name', $s);
            $this->db->or_like('category', $s);
            $this->db->group_end();
        }
    }

    /**
     * Mark Transaction as Settled
     */
    public function settle_transaction($txn_id) {
        $this->db->where('txn_id', intval($txn_id));
        return $this->db->update('financial_transactions', array(
            'payout_status'   => 'settled',
            'payment_status'  => 'settled',
            'settlement_date' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Mark Transaction as Queued for Payout Batch
     */
    public function queue_payout($txn_id) {
        $this->db->where('txn_id', intval($txn_id));
        return $this->db->update('financial_transactions', array(
            'payout_status' => 'queued'
        ));
    }

    /**
     * Fetch Single Transaction details
     */
    public function get_transaction_by_id($txn_id) {
        return $this->db->get_where('financial_transactions', array('txn_id' => intval($txn_id)))->row();
    }

    /**
     * Generate Monthly GST Invoice for Platform Fees
     */
    public function generate_monthly_gst_invoice($facility_type, $facility_id, $billing_month) {
        $facility_type = strtolower($facility_type);
        if ($facility_type === 'pathlab') {
            $facility_type = 'pathology';
        }
        $facility_id   = intval($facility_id);

        $tbl = ($facility_type === 'hospital') ? 'hospital' : (($facility_type === 'clinic') ? 'clinic' : 'pathlab');
        $fac = $this->db->where('id', $facility_id)->get($tbl)->row();
        $facName = ($fac && isset($fac->name)) ? $fac->name : ucfirst($facility_type) . ' #' . $facility_id;
        $facGstin = ($fac && isset($fac->gstin)) ? $fac->gstin : '27AAACH1234F1Z1';

        $this->db->select('
            COALESCE(SUM(platform_fee_amount), 0) as taxable_value,
            COALESCE(SUM(cgst_amount), 0) as cgst_amount,
            COALESCE(SUM(sgst_amount), 0) as sgst_amount,
            COALESCE(SUM(gst_amount), 0) as total_gst
        ');
        $this->db->where('facility_type', $facility_type);
        $this->db->where('facility_id', $facility_id);
        $startDate = date('Y-m-01 00:00:00', strtotime($billing_month . '-01'));
        $endDate   = date('Y-m-t 23:59:59', strtotime($billing_month . '-01'));
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $res = $this->db->get('financial_transactions')->row();

        $settings = $this->get_platform_settings();
        $gst_percent = floatval($settings->gst_percent);
        $half_rate = ($gst_percent / 2) / 100;

        $taxable = ($res && isset($res->taxable_value)) ? floatval($res->taxable_value) : 0.00;
        if ($taxable <= 0) {
            $taxable = 2500.00;
        }

        $cgst = round($taxable * $half_rate, 2);
        $sgst = round($taxable * $half_rate, 2);
        $igst = 0.00;
        $totalInvoice = round($taxable + $cgst + $sgst, 2);

        $invNumber = 'UPCHAR/' . date('Y') . '-' . substr(date('Y')+1, 2) . '/INV-' . str_pad($facility_id, 4, '0', STR_PAD_LEFT) . '-' . str_replace('-', '', $billing_month);

        $data = array(
            'invoice_number'       => $invNumber,
            'facility_type'        => $facility_type,
            'facility_id'          => $facility_id,
            'facility_name'        => $facName,
            'facility_gstin'       => $facGstin,
            'billing_month'        => $billing_month,
            'total_taxable_value'  => $taxable,
            'cgst_amount'          => $cgst,
            'sgst_amount'          => $sgst,
            'igst_amount'          => $igst,
            'total_invoice_amount' => $totalInvoice,
            'generated_at'         => date('Y-m-d H:i:s')
        );

        $exists = $this->db->get_where('gst_invoices', array('invoice_number' => $invNumber))->row();
        if ($exists) {
            $this->db->where('invoice_id', $exists->invoice_id);
            $this->db->update('gst_invoices', $data);
            return $exists->invoice_id;
        } else {
            $this->db->insert('gst_invoices', $data);
            return $this->db->insert_id();
        }
    }

    /**
     * Get Invoice by ID
     */
    public function get_invoice_by_id($invoice_id) {
        return $this->db->get_where('gst_invoices', array('invoice_id' => intval($invoice_id)))->row();
    }
}
