<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Operations Model
 * Central Diagnostic Lab Sample Handoff & Expense Reimbursement Desk
 */
class Operations_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get Sample Handoffs Roster
     */
    public function get_handoffs($filters = [], $limit = 50, $offset = 0) {
        $this->db->select('h.*, c.name as collector_name, c.phone as collector_phone, c.staff_code as collector_code, s.name as received_by_name, pb.patient_name, pb.patient_mobile');
        $this->db->from('staff_sample_handoffs h');
        $this->db->join('staff_users c', 'c.id = h.collector_id', 'left');
        $this->db->join('staff_users s', 's.id = h.received_by_staff_id', 'left');
        $this->db->join('path_book pb', 'pb.booking_id = h.booking_id', 'left');

        if (!empty($filters['status'])) {
            $this->db->where('h.status', $filters['status']);
        }
        if (!empty($filters['collector_id'])) {
            $this->db->where('h.collector_id', $filters['collector_id']);
        }
        if (!empty($filters['barcode'])) {
            $this->db->like('h.barcode', $filters['barcode']);
        }

        $this->db->order_by('h.id', 'DESC');
        return $this->db->get('', $limit, $offset)->result_array();
    }

    /**
     * Record or Verify Sample Handoff
     */
    public function record_handoff($bookingId, $collectorId, $barcode, $receivedByStaffId, $condition = 'good', $notes = '') {
        $data = [
            'booking_id'           => $bookingId,
            'collector_id'         => $collectorId,
            'received_by_staff_id' => $receivedByStaffId,
            'barcode'              => $barcode,
            'sample_condition'     => $condition,
            'handoff_time'         => date('Y-m-d H:i:s'),
            'status'               => 'verified_received',
            'notes'                => $notes
        ];

        $this->db->insert('staff_sample_handoffs', $data);
        $insertId = $this->db->insert_id();

        // Update path_book status to handed_to_lab
        $this->db->where('booking_id', $bookingId)->update('path_book', [
            'collection_status' => 'handed_to_lab',
            'vial_barcode'      => $barcode
        ]);

        return $insertId;
    }

    /**
     * Get Expense Claims
     */
    public function get_expenses($filters = [], $limit = 50, $offset = 0) {
        $this->db->select('e.*, u.name as employee_name, u.staff_code, u.department, u.role, a.name as approver_name');
        $this->db->from('staff_expense_claims e');
        $this->db->join('staff_users u', 'u.id = e.user_id', 'inner');
        $this->db->join('staff_users a', 'a.id = e.approved_by', 'left');

        if (!empty($filters['user_id'])) {
            $this->db->where('e.user_id', $filters['user_id']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('e.status', $filters['status']);
        }
        if (!empty($filters['category'])) {
            $this->db->where('e.category', $filters['category']);
        }

        $this->db->order_by('e.id', 'DESC');
        return $this->db->get('', $limit, $offset)->result_array();
    }

    /**
     * Submit Expense Claim
     */
    public function submit_expense($userId, $category, $amount, $expenseDate, $description, $receiptProof = null) {
        $data = [
            'user_id'       => $userId,
            'category'      => $category,
            'amount'        => floatval($amount),
            'expense_date'  => $expenseDate,
            'description'   => $description,
            'receipt_proof' => $receiptProof,
            'status'        => 'submitted'
        ];

        $this->db->insert('staff_expense_claims', $data);
        return $this->db->insert_id();
    }

    /**
     * Update Expense Claim Status (Approve / Reject / Reimburse)
     */
    public function update_expense_status($expenseId, $approverId, $status) {
        $updateData = [
            'status'      => $status,
            'approved_by' => $approverId
        ];
        if ($status === 'reimbursed') {
            $updateData['reimbursement_date'] = date('Y-m-d');
        }

        $this->db->where('id', $expenseId)->update('staff_expense_claims', $updateData);
        return $this->db->affected_rows() > 0;
    }
}
