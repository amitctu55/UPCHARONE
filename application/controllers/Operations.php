<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Operations Controller
 * Central Lab Sample Handoffs & Staff Expense Reimbursement Desk
 */
class Operations extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Operations_model');
        $this->load->helper(['url', 'form']);
        $this->_check_auth();
    }

    private function _check_auth() {
        // Bridge SSO: If logged into Admin1947, auto-authorize as super_admin
        if ($this->session->userdata('adminuserid') || $this->session->userdata('username')) {
            if (!$this->session->userdata('staff_user_id')) {
                $superAdmin = $this->db->get_where('staff_users', ['role' => 'super_admin', 'status' => 'active'])->row_array();
                if ($superAdmin) {
                    $this->session->set_userdata([
                        'staff_user_id' => $superAdmin['id'],
                        'staff_code'    => $superAdmin['staff_code'],
                        'staff_name'    => $superAdmin['name'],
                        'staff_role'    => 'super_admin',
                        'staff_dept'    => $superAdmin['department']
                    ]);
                }
            }
            return;
        }

        if (!$this->session->userdata('staff_user_id')) {
            $this->session->set_flashdata('error_msg', 'Please login to access Operations Desk.');
            redirect('staff/login');
        }
    }

    /**
     * Operations Overview Dashboard
     */
    public function dashboard() {
        $data['handoffs'] = $this->Operations_model->get_handoffs([], 10);
        $data['expenses'] = $this->Operations_model->get_expenses([], 10);

        $this->load->view('operations/header', $data);
        $this->load->view('operations/dashboard', $data);
        $this->load->view('operations/footer');
    }

    /**
     * Central Lab Sample Handoff Verification Desk
     */
    public function handoffs() {
        $status  = $this->input->get('status', TRUE);
        $barcode = $this->input->get('barcode', TRUE);

        $filters = [];
        if ($status) $filters['status'] = $status;
        if ($barcode) $filters['barcode'] = $barcode;

        $data['handoffs'] = $this->Operations_model->get_handoffs($filters, 50);

        // Fetch pending un-handed field samples from path_book
        $this->db->select('pb.*, pbt.test_name, c.name as collector_name, c.phone as collector_phone');
        $this->db->from('path_book pb');
        $this->db->join('path_book_test pbt', 'pbt.booking_id = pb.booking_id', 'left');
        $this->db->join('staff_users c', 'c.id = pb.assigned_collector_id', 'left');
        $this->db->where('pb.collection_status', 'sample_collected');
        $data['pending_field_samples'] = $this->db->get()->result_array();

        $this->load->view('operations/header', $data);
        $this->load->view('operations/handoffs', $data);
        $this->load->view('operations/footer');
    }

    /**
     * AJAX: Verify Sample Received at Lab
     */
    public function verify_handoff() {
        $bookingId   = intval($this->input->post('booking_id'));
        $collectorId = intval($this->input->post('collector_id'));
        $barcode     = trim($this->input->post('barcode', TRUE));
        $condition   = $this->input->post('condition', TRUE) ?: 'good';
        $staffId     = $this->session->userdata('staff_user_id');

        if (!$bookingId || empty($barcode)) {
            echo json_encode(['status' => 'error', 'message' => 'Valid Booking ID and Barcode required.']);
            return;
        }

        $id = $this->Operations_model->record_handoff($bookingId, $collectorId, $barcode, $staffId, $condition);
        echo json_encode([
            'status'  => 'success',
            'message' => "Sample barcode '{$barcode}' verified and received into Central Diagnostic Lab!",
            'id'      => $id
        ]);
    }

    /**
     * Expense & Reimbursement Desk
     */
    public function expenses() {
        $status   = $this->input->get('status', TRUE);
        $category = $this->input->get('category', TRUE);

        $filters = [];
        if ($status) $filters['status'] = $status;
        if ($category) $filters['category'] = $category;

        // If regular staff/collector, show their own expenses. If super_admin/hr/office_staff, show all.
        $userRole = $this->session->userdata('staff_role');
        if (!in_array($userRole, ['super_admin', 'hr', 'office_staff'])) {
            $filters['user_id'] = $this->session->userdata('staff_user_id');
        }

        $data['expenses'] = $this->Operations_model->get_expenses($filters, 50);

        $this->load->view('operations/header', $data);
        $this->load->view('operations/expenses', $data);
        $this->load->view('operations/footer');
    }

    /**
     * Submit Expense Claim
     */
    public function save_expense() {
        $userId      = $this->session->userdata('staff_user_id');
        $category    = $this->input->post('category', TRUE) ?: 'fuel';
        $amount      = floatval($this->input->post('amount'));
        $expenseDate = $this->input->post('expense_date', TRUE) ?: date('Y-m-d');
        $description = trim($this->input->post('description', TRUE));

        if ($amount <= 0 || empty($description)) {
            $this->session->set_flashdata('error_msg', 'Amount and description are required.');
            redirect('operations/expenses');
            return;
        }

        $id = $this->Operations_model->submit_expense($userId, $category, $amount, $expenseDate, $description);
        $this->session->set_flashdata('success_msg', "Expense claim of ₹{$amount} submitted for approval!");
        redirect('operations/expenses');
    }

    /**
     * AJAX: Approve / Reject / Reimburse Expense
     */
    public function update_expense() {
        $expenseId = intval($this->input->post('expense_id'));
        $status    = $this->input->post('status', TRUE);
        $staffId   = $this->session->userdata('staff_user_id');

        if (!in_array($status, ['approved', 'rejected', 'reimbursed']) || !$expenseId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid action parameters']);
            return;
        }

        $this->Operations_model->update_expense_status($expenseId, $staffId, $status);
        echo json_encode([
            'status'  => 'success',
            'message' => 'Expense claim marked as ' . strtoupper($status) . '!'
        ]);
    }
}
