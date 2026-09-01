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
    public function get_leaves($filters = [], $limit = 50, $offset = 0) {
        $this->db->select('l.*, u.name as employee_name, u.staff_code, u.department, u.role, r.name as reviewer_name');
        $this->db->from('staff_leave_requests l');
        $this->db->join('staff_users u', 'u.id = l.user_id', 'inner');
        $this->db->join('staff_users r', 'r.id = l.reviewed_by', 'left');

        if (!empty($filters['user_id'])) {
            $this->db->where('l.user_id', $filters['user_id']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('l.status', $filters['status']);
        }
        $this->db->order_by('l.id', 'DESC');
        return $this->db->get('', $limit, $offset)->result_array();
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
     * Calculate Monthly Payroll Roster
     */
    public function calculate_monthly_payroll($month = null, $year = null) {
        $month = $month ?: date('m');
        $year  = $year ?: date('Y');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $staff = $this->db->where('status', 'active')->get('staff_users')->result_array();
        $payrollRoster = [];

        foreach ($staff as $s) {
            $userId = $s['id'];

            // Count Attendance
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

            // Approved Leaves
            $this->db->where('user_id', $userId);
            $this->db->where('status', 'approved');
            $this->db->where('MONTH(start_date)', $month);
            $this->db->where('YEAR(start_date)', $year);
            $leaves = $this->db->get('staff_leave_requests')->result_array();
            $approvedLeaves = 0;
            foreach ($leaves as $l) {
                $approvedLeaves += intval($l['days_count']);
            }

            $effectivePayableDays = $presentDays + ($halfDays * 0.5) + min(2, $approvedLeaves);
            $baseSalary = floatval($s['base_salary']);
            $perDayRate = ($daysInMonth > 0) ? ($baseSalary / $daysInMonth) : 0;
            $netPayable = round($effectivePayableDays * $perDayRate, 2);

            $payrollRoster[] = [
                'user_id'        => $userId,
                'staff_code'     => $s['staff_code'],
                'name'           => $s['name'],
                'role'           => $s['role'],
                'department'     => $s['department'],
                'designation'    => $s['designation'],
                'base_salary'    => $baseSalary,
                'present_days'   => $presentDays,
                'late_days'      => $lateDays,
                'half_days'      => $halfDays,
                'approved_leaves'=> $approvedLeaves,
                'payable_days'   => $effectivePayableDays,
                'total_hours'    => round($totalHours, 1),
                'net_salary'     => $netPayable,
                'days_in_month'  => $daysInMonth
            ];
        }

        return $payrollRoster;
    }
}
