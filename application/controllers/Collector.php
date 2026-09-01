<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Collector Controller
 * Sample Collector (Phlebotomist) Mobile Field Web App PWA
 */
class Collector extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Attendance_model');
        $this->load->helper(['url', 'form']);
        $this->_check_auth();
    }

    private function _check_auth() {
        $staffId = $this->session->userdata('staff_user_id');
        $role    = $this->session->userdata('staff_role');
        if (!$staffId || !in_array($role, ['collector', 'super_admin'])) {
            $this->session->set_flashdata('error_msg', 'Access restricted to Sample Collectors / Phlebotomists.');
            redirect('staff/login');
        }
    }

    /**
     * Field Tasks Dashboard
     */
    public function dashboard() {
        $staffId = $this->session->userdata('staff_user_id');
        $today   = date('Y-m-d');

        // Fetch Today's Assigned Pickups
        $this->db->select('pb.*, pb.total_amount as amount, pbt.test_name, pbt.short_name, pl.name as lab_name');
        $this->db->from('path_book pb');
        $this->db->join('path_book_test pbt', 'pbt.booking_id = pb.booking_id', 'left');
        $this->db->join('pathlab pl', 'pl.id = pb.pathlab_id', 'left');
        $this->db->group_start();
        $this->db->where('pb.assigned_collector_id', $staffId);
        $this->db->or_where('pb.assigned_collector_id IS NULL');
        $this->db->group_end();
        $this->db->order_by("FIELD(pb.collection_status, 'en_route', 'arrived', 'assigned', 'sample_collected', 'handed_to_lab')", 'ASC', FALSE);
        $this->db->order_by('pb.booking_id', 'DESC');
        $data['tasks'] = $this->db->get()->result_array();

        // Punch status
        $data['today_punch'] = $this->Attendance_model->get_today_punch($staffId, $today);

        // Stats
        $data['total_tasks']     = count($data['tasks']);
        $data['pending_tasks']   = 0;
        $data['completed_tasks'] = 0;
        $data['cash_collected']  = 0.00;

        foreach ($data['tasks'] as $t) {
            if (in_array($t['collection_status'], ['sample_collected', 'handed_to_lab', 'report_ready'])) {
                $data['completed_tasks']++;
                if ($t['payment_collected_mode'] === 'CASH') {
                    $data['cash_collected'] += floatval($t['payment_collected_amount'] ?: $t['amount']);
                }
            } else {
                $data['pending_tasks']++;
            }
        }

        $this->load->view('collector/header', $data);
        $this->load->view('collector/dashboard', $data);
        $this->load->view('collector/footer');
    }

    /**
     * Single Pickup Task Workflow View
     */
    public function pickup($id) {
        $staffId = $this->session->userdata('staff_user_id');

        $this->db->select('pb.*, pb.total_amount as amount, pbt.test_name, pbt.short_name, pl.name as lab_name, pl.address as lab_address');
        $this->db->from('path_book pb');
        $this->db->join('path_book_test pbt', 'pbt.booking_id = pb.booking_id', 'left');
        $this->db->join('pathlab pl', 'pl.id = pb.pathlab_id', 'left');
        $this->db->where('pb.booking_id', $id);
        $task = $this->db->get()->row_array();

        if (!$task) {
            $this->session->set_flashdata('error_msg', 'Booking task not found.');
            redirect('collector/dashboard');
            return;
        }

        // Auto-assign to this collector if unassigned
        if (empty($task['assigned_collector_id'])) {
            $this->db->where('booking_id', $id)->update('path_book', ['assigned_collector_id' => $staffId]);
            $task['assigned_collector_id'] = $staffId;
        }

        $data['task'] = $task;
        $this->load->view('collector/header', $data);
        $this->load->view('collector/pickup_detail', $data);
        $this->load->view('collector/footer');
    }

    /**
     * AJAX: Update Workflow Status
     */
    public function update_status() {
        $bookingId = intval($this->input->post('booking_id'));
        $newStatus = $this->input->post('status', TRUE);
        $staffId   = $this->session->userdata('staff_user_id');

        $allowed = ['assigned', 'en_route', 'arrived', 'sample_collected', 'handed_to_lab'];
        if (!in_array($newStatus, $allowed) || !$bookingId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid status transition.']);
            return;
        }

        $updateData = ['collection_status' => $newStatus];
        if ($newStatus === 'sample_collected') {
            $updateData['collected_at'] = date('Y-m-d H:i:s');
        }

        $this->db->where('booking_id', $bookingId)->update('path_book', $updateData);

        echo json_encode([
            'status'     => 'success',
            'message'    => 'Status advanced to ' . strtoupper(str_replace('_', ' ', $newStatus)),
            'new_status' => $newStatus
        ]);
    }

    /**
     * AJAX: Scan & Bind Vial Barcode
     */
    public function scan_barcode() {
        $bookingId = intval($this->input->post('booking_id'));
        $barcode   = trim($this->input->post('barcode', TRUE));

        if (empty($barcode) || !$bookingId) {
            echo json_encode(['status' => 'error', 'message' => 'Please enter or scan a valid barcode.']);
            return;
        }

        $this->db->where('booking_id', $bookingId)->update('path_book', [
            'vial_barcode' => $barcode
        ]);

        echo json_encode([
            'status'  => 'success',
            'message' => "Sample vial barcode '{$barcode}' linked to order #{$bookingId}!",
            'barcode' => $barcode
        ]);
    }

    /**
     * AJAX: Complete Payment Collection (Cash / UPI)
     */
    public function complete_payment() {
        $bookingId = intval($this->input->post('booking_id'));
        $mode      = $this->input->post('payment_mode', TRUE) ?: 'CASH';
        $amount    = floatval($this->input->post('amount'));

        if (!$bookingId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid Booking ID']);
            return;
        }

        $this->db->where('booking_id', $bookingId)->update('path_book', [
            'payment_status'          => '1',
            'payment_collected_mode'   => $mode,
            'payment_collected_amount' => $amount,
            'collection_status'        => 'sample_collected',
            'collected_at'             => date('Y-m-d H:i:s')
        ]);

        echo json_encode([
            'status'  => 'success',
            'message' => "Payment of ₹{$amount} recorded via {$mode}! Order marked as Sample Collected."
        ]);
    }

    /**
     * AJAX: Generate Dynamic UPI Payment QR Code
     */
    public function generate_qr() {
        $amount    = floatval($this->input->post('amount') ?: $this->input->get('amount') ?: 400);
        $bookingId = intval($this->input->post('booking_id') ?: $this->input->get('booking_id') ?: 1);
        $vpa       = "upcharhealthcare@icici";
        $payName   = "Upchar Healthcare";
        $note      = "Diagnostic Booking #" . $bookingId;

        $upiUri = "upi://pay?pa={$vpa}&pn=" . urlencode($payName) . "&am=" . number_format($amount, 2, '.', '') . "&cu=INR&tn=" . urlencode($note);
        $qrUrl  = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($upiUri);

        echo json_encode([
            'status'  => 'success',
            'upi_uri' => $upiUri,
            'qr_url'  => $qrUrl,
            'amount'  => $amount
        ]);
    }
}
