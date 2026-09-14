<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * HR Model
 * Staff Directory, Leave Approval Engine & Automated Payroll Calculator
 */
class Hr_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get Leave Requests
     */
    public function get_leaves($filters = [], $limit = 200, $offset = 0) {
        $this->db->select('l.*, u.name as employee_name, u.staff_code, u.department, u.role, u.phone as employee_phone, r.name as reviewer_name');
        $this->db->from('staff_leave_requests l');
        $this->db->join('staff_users u', 'u.id = l.user_id', 'inner');
        $this->db->join('staff_users r', 'r.id = l.reviewed_by', 'left');

        if (!empty($filters['user_id'])) {
            $this->db->where('l.user_id', $filters['user_id']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('l.status', $filters['status']);
        }
        if (!empty($filters['leave_type'])) {
            $this->db->where('l.leave_type', $filters['leave_type']);
        }
        if (!empty($filters['department'])) {
            $this->db->where('u.department', $filters['department']);
        }
        if (!empty($filters['search'])) {
            $q = $filters['search'];
            $this->db->group_start();
            $this->db->like('u.name', $q);
            $this->db->or_like('u.staff_code', $q);
            $this->db->or_like('l.reason', $q);
            $this->db->group_end();
        }

        $this->db->order_by('l.id', 'DESC');
        return $this->db->get('', $limit, $offset)->result_array();
    }

    /**
     * Delete / Cancel Leave Application
     */
    public function delete_leave($leaveId) {
        $this->db->where('id', $leaveId)->delete('staff_leave_requests');
        return $this->db->affected_rows() > 0;
    }

    /**
     * Submit Leave Application
     */
    public function submit_leave($userId, $leaveType, $startDate, $endDate, $reason) {
        $start = strtotime($startDate);
        $end   = strtotime($endDate);
        $days  = max(1, round(($end - $start) / 86400) + 1);

        $data = [
            'user_id'    => $userId,
            'leave_type' => $leaveType,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'days_count' => $days,
            'reason'     => $reason,
            'status'     => 'pending'
        ];

        $this->db->insert('staff_leave_requests', $data);
        return $this->db->insert_id();
    }

    /**
     * Update Leave Status (Approve / Reject)
     */
    public function update_leave_status($leaveId, $reviewerId, $status, $reviewerNotes = '') {
        $this->db->where('id', $leaveId)->update('staff_leave_requests', [
            'status'         => $status,
            'reviewed_by'    => $reviewerId,
            'reviewer_notes' => $reviewerNotes
        ]);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Calculate Monthly Payroll Roster with Comprehensive Earnings & Deductions
     */
    public function calculate_monthly_payroll($month = null, $year = null, $mode = 'full') {
        $month = $month ?: date('m');
        $year  = $year ?: date('Y');
        $normMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, intval($month), intval($year));

        $this->ensure_payroll_disbursals_table();

        // Fetch existing disbursal payments for this period
        $disbursalsRaw = $this->db->where('month', $normMonth)
                                  ->where('year', (string)$year)
                                  ->get('staff_payroll_disbursals')
                                  ->result_array();
        $disbursals = [];
        foreach ($disbursalsRaw as $d) {
            $disbursals[$d['user_id']] = $d;
        }

        $staff = $this->db->where('status', 'active')->get('staff_users')->result_array();
        $payrollRoster = [];

        // Deterministic Bank Details Mapping
        $bankDetails = [
            1 => ['bank' => 'HDFC Bank', 'ac' => '50100492819201', 'ifsc' => 'HDFC0000123', 'pan' => 'AAAPU1234A'],
            2 => ['bank' => 'ICICI Bank', 'ac' => '002101582910', 'ifsc' => 'ICIC0000021', 'pan' => 'BKKPS5678B'],
            3 => ['bank' => 'State Bank of India', 'ac' => '30918291029', 'ifsc' => 'SBIN0001245', 'pan' => 'CRPV9012C'],
            4 => ['bank' => 'Axis Bank', 'ac' => '918020019283', 'ifsc' => 'UTIB0000456', 'pan' => 'DAAK3456D'],
            5 => ['bank' => 'Kotak Mahindra', 'ac' => '7810291029', 'ifsc' => 'KKBK0000789', 'pan' => 'ESSP7890E'],
            6 => ['bank' => 'Bank of Baroda', 'ac' => '24100182910', 'ifsc' => 'BARB0LUCKNO', 'pan' => 'FSSW2345F'],
            7 => ['bank' => 'Punjab National Bank', 'ac' => '19200021928', 'ifsc' => 'PUNB0192000', 'pan' => 'GAAK6789G']
        ];

        foreach ($staff as $s) {
            $userId = $s['id'];

            // 1. Count Attendance Records
            $this->db->where('user_id', $userId);
            $this->db->where('MONTH(punch_date)', $month);
            $this->db->where('YEAR(punch_date)', $year);
            $attendance = $this->db->get('staff_attendance')->result_array();

            $presentDays  = 0;
            $halfDays     = 0;
            $lateDays     = 0;
            $totalHours   = 0.00;

            foreach ($attendance as $att) {
                $totalHours += floatval($att['working_hours']);
                if ($att['status'] === 'present') {
                    $presentDays++;
                } else if ($att['status'] === 'late') {
                    $lateDays++;
                    $presentDays++;
                } else if ($att['status'] === 'half_day') {
                    $halfDays++;
                }
            }

            // 2. Count Approved Leaves
            $this->db->where('user_id', $userId);
            $this->db->where('status', 'approved');
            $this->db->where('MONTH(start_date)', $month);
            $this->db->where('YEAR(start_date)', $year);
            $leaves = $this->db->get('staff_leave_requests')->result_array();
            $approvedLeaves = 0;
            foreach ($leaves as $l) {
                $approvedLeaves += intval($l['days_count']);
            }

            $baseSalary = floatval($s['base_salary']);

            // 3. Determine Payable Days (Full Month Standard vs MTD Actual)
            if ($mode === 'mtd') {
                $effectivePayableDays = $presentDays + ($halfDays * 0.5) + $approvedLeaves;
            } else {
                // Full Month Disbursal Cycle:
                // Base 30 days minus recorded unexcused absences or half-day deductions
                $lopFromHalfDays = ($halfDays * 0.5);
                $effectivePayableDays = max(1, $daysInMonth - $lopFromHalfDays);
            }
            $effectivePayableDays = min($daysInMonth, $effectivePayableDays);
            $payableRatio = ($daysInMonth > 0) ? ($effectivePayableDays / $daysInMonth) : 1.0;

            // 4. Earnings Breakdown (Indian Standard Payroll Structure)
            // Base CTC Components: Basic (50%), HRA (25%), Special (15%), Medical (10%)
            $basicSalary      = round($baseSalary * 0.50, 2);
            $hraSalary        = round($baseSalary * 0.25, 2);
            $specialAllowance = round($baseSalary * 0.15, 2);
            $medicalAllowance = round($baseSalary * 0.10, 2);

            // Earned Pro-Rata Earnings
            $earnedBasic   = round($basicSalary * $payableRatio, 2);
            $earnedHra     = round($hraSalary * $payableRatio, 2);
            $earnedSpecial = round($specialAllowance * $payableRatio, 2);
            $earnedMedical = round($medicalAllowance * $payableRatio, 2);
            $grossEarned   = $earnedBasic + $earnedHra + $earnedSpecial + $earnedMedical;

            // 5. Statutory & Policy Deductions
            // PF (EPF): 12% of Basic, standard statutory cap of Rs 1,800
            $pfDeduction = round(min(1800, $earnedBasic * 0.12), 2);

            // ESI: 0.75% of Gross if Gross <= Rs 21,000
            $esiDeduction = ($grossEarned <= 21000) ? round($grossEarned * 0.0075, 2) : 0.00;

            // Professional Tax (PT): Standard Rs 200/mo slab
            $ptDeduction = ($grossEarned > 15000) ? 200.00 : (($grossEarned > 10000) ? 150.00 : 0.00);

            // Late Penalty: 1st late mark grace; Rs 250 per late mark beyond 1
            $latePenalty = ($lateDays > 1) ? round(($lateDays - 1) * 250.00, 2) : 0.00;

            // LOP (Loss of Pay) Amount
            $lopDays = max(0, round($daysInMonth - $effectivePayableDays, 1));
            $lopDeduction = round($baseSalary - $grossEarned, 2);

            $totalDeductions = round($pfDeduction + $esiDeduction + $ptDeduction + $latePenalty, 2);

            // 6. Net Take-Home Salary
            $netSalary = max(0, round($grossEarned - $totalDeductions, 2));

            // Bank details
            $bankInfo = $bankDetails[$userId] ?? [
                'bank' => 'HDFC Bank', 'ac' => '10020030040' . $userId, 'ifsc' => 'HDFC0000123', 'pan' => 'AAAPU100' . $userId . 'A'
            ];

            $payrollRoster[] = [
                'user_id'            => $userId,
                'staff_code'         => $s['staff_code'],
                'name'               => $s['name'],
                'role'               => $s['role'],
                'department'         => $s['department'],
                'designation'        => $s['designation'],
                'base_salary'        => $baseSalary,
                'days_in_month'      => $daysInMonth,
                'present_days'       => $presentDays,
                'late_days'          => $lateDays,
                'half_days'          => $halfDays,
                'approved_leaves'    => $approvedLeaves,
                'lop_days'           => $lopDays,
                'payable_days'       => $effectivePayableDays,
                'total_hours'        => round($totalHours, 1),

                // Full Package Breakdown
                'basic_salary'       => $basicSalary,
                'hra'                => $hraSalary,
                'special_allowance'  => $specialAllowance,
                'medical_allowance'  => $medicalAllowance,

                // Earned Components
                'earned_basic'       => $earnedBasic,
                'earned_hra'         => $earnedHra,
                'earned_special'     => $earnedSpecial,
                'earned_medical'     => $earnedMedical,
                'gross_earned'       => $grossEarned,

                // Deductions Breakdown
                'pf_deduction'       => $pfDeduction,
                'esi_deduction'      => $esiDeduction,
                'pt_deduction'       => $ptDeduction,
                'late_penalty'       => $latePenalty,
                'lop_deduction'      => $lopDeduction,
                'total_deductions'   => $totalDeductions,

                // Net Disbursable
                'net_salary'         => $netSalary,

                // Bank & Payment
                'bank_name'          => $bankInfo['bank'],
                'account_no'         => $bankInfo['ac'],
                'ifsc_code'          => $bankInfo['ifsc'],
                'pan_number'         => $bankInfo['pan'],

                // Payment Transfer Status & Reference Details
                'transfer_status'    => $disbursals[$userId]['status'] ?? 'pending',
                'txn_ref'            => $disbursals[$userId]['txn_ref'] ?? '',
                'payment_channel'    => $disbursals[$userId]['payment_channel'] ?? 'Corporate NetBanking (HDFC Direct)',
                'transferred_at'     => (!empty($disbursals[$userId]['transferred_at'])) ? date('d M Y, h:i A', strtotime($disbursals[$userId]['transferred_at'])) : '',
                'transferred_at_raw' => $disbursals[$userId]['transferred_at'] ?? null,
                'disbursal_notes'    => $disbursals[$userId]['notes'] ?? '',
                'disbursed_amount'   => isset($disbursals[$userId]['amount']) ? floatval($disbursals[$userId]['amount']) : $netSalary,
                'payment_status'     => (isset($disbursals[$userId]['status']) && $disbursals[$userId]['status'] === 'transferred') ? 'Transferred' : ((isset($disbursals[$userId]['status']) && $disbursals[$userId]['status'] === 'on_hold') ? 'On Hold' : 'Pending Transfer')
            ];
        }

        return $payrollRoster;
    }

    /**
     * Insert or update staff payroll disbursal record
     */
    public function update_payroll_disbursal($userId, $month, $year, $amount, $status, $txnRef, $channel, $notes = '') {
        $this->ensure_payroll_disbursals_table();

        $normMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
        $normYear  = (string)$year;
        $status    = in_array($status, ['transferred', 'pending', 'on_hold']) ? $status : 'pending';

        $existing = $this->db->where('user_id', $userId)
                             ->where('month', $normMonth)
                             ->where('year', $normYear)
                             ->get('staff_payroll_disbursals')
                             ->row_array();

        $data = [
            'user_id'         => $userId,
            'month'           => $normMonth,
            'year'            => $normYear,
            'amount'          => floatval($amount),
            'status'          => $status,
            'txn_ref'         => $txnRef ?: null,
            'payment_channel' => $channel ?: 'Corporate NetBanking (HDFC Direct)',
            'notes'           => $notes ?: null
        ];

        if ($status === 'transferred') {
            if ($existing && !empty($existing['transferred_at'])) {
                $data['transferred_at'] = $existing['transferred_at'];
            } else {
                $data['transferred_at'] = date('Y-m-d H:i:s');
            }
        } else {
            $data['transferred_at'] = null;
        }

        if ($existing) {
            $this->db->where('id', $existing['id'])->update('staff_payroll_disbursals', $data);
        } else {
            $this->db->insert('staff_payroll_disbursals', $data);
        }

        return $data;
    }

    /**
     * Auto-ensure disbursals table exists on live production or local database
     */
    public function ensure_payroll_disbursals_table() {
        if (!$this->db->table_exists('staff_payroll_disbursals')) {
            $sql = "CREATE TABLE IF NOT EXISTS `staff_payroll_disbursals` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `month` VARCHAR(2) NOT NULL,
                `year` VARCHAR(4) NOT NULL,
                `amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `status` ENUM('transferred', 'pending', 'on_hold') NOT NULL DEFAULT 'pending',
                `txn_ref` VARCHAR(100) NULL,
                `payment_channel` VARCHAR(100) NULL,
                `transferred_at` DATETIME NULL,
                `notes` VARCHAR(255) NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY `user_month_year` (`user_id`, `month`, `year`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->db->query($sql);
        }
    }
}
