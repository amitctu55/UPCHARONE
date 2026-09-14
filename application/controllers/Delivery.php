<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Delivery Controller
 * Manages UPCHAR delivery fleet dispatch, chemist package handoff scanning,
 * and secure doorstep OTP handover.
 */
class Delivery extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Medicine_delivery_model');
        $this->load->helper(['url', 'form']);
    }

    private function _json_response($data, $statusCode = 200) {
        $this->output
            ->set_status_header($statusCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Rider Mobile Field Console UI
     * GET /delivery/console
     */
    public function console() {
        $data['riders'] = $this->db->get_where('delivery_riders', ['is_active' => 1])->result_array();
        $currentRiderId = (int)($this->input->get('rider_id') ?: ($data['riders'][0]['id'] ?? 1));
        $data['current_rider'] = $this->db->get_where('delivery_riders', ['id' => $currentRiderId])->row_array();

        // Orders assigned or in-transit for this rider
        $this->db->select('mo.*, ps.store_name, ps.address as store_address, ps.phone as store_phone');
        $this->db->from('medicine_orders mo');
        $this->db->join('pharmacy_stores ps', 'ps.id = mo.pharmacy_id', 'left');
        $this->db->group_start();
        $this->db->where('mo.rider_id', $currentRiderId);
        $this->db->or_where('mo.order_status', 'PACKED');
        $this->db->group_end();
        $this->db->order_by('mo.id', 'DESC');
        $data['orders'] = $this->db->get()->result_array();

        $this->load->view('rider/console', $data);
    }

    /**
     * Chemist Handoff: Rider arrives at pharmacy and scans package QR code
     * POST /api/v1/delivery/chemist-handoff
     */
    public function chemist_handoff() {
        $input = json_decode($this->input->raw_input_stream, true) ?: $this->input->post();

        $orderCode = trim($input['order_code'] ?? '');
        $riderId   = (int)($input['rider_id'] ?? 1);

        if (empty($orderCode)) {
            return $this->_json_response(['status' => 'error', 'message' => 'Order code is required.'], 400);
        }

        $result = $this->Medicine_delivery_model->record_chemist_handoff($orderCode, $riderId);

        if (!$result['status']) {
            return $this->_json_response(['status' => 'error', 'message' => $result['message']], 422);
        }

        return $this->_json_response([
            'status' => 'success',
            'message' => 'Package verified and sealed handoff recorded. Status is now IN_TRANSIT.',
            'data' => [
                'order_code' => $result['order_code'],
                'order_status' => $result['order_status'],
                'delivery_otp' => $result['delivery_otp'],
                'sms_dispatched_to' => $result['customer_phone'],
                'sms_text' => "UPCHAR: Your medicine package is on the way! Please share OTP: {$result['delivery_otp']} with your rider only upon receiving the sealed package."
            ]
        ], 200);
    }

    /**
     * Customer Handover: Verify 4-digit OTP at doorstep
     * POST /api/v1/delivery/verify-otp
     */
    public function verify_otp() {
        $input = json_decode($this->input->raw_input_stream, true) ?: $this->input->post();

        $orderCode = trim($input['order_code'] ?? '');
        $otp       = trim($input['otp'] ?? '');
        $riderId   = (int)($input['rider_id'] ?? 0);

        if (empty($orderCode) || empty($otp)) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'Both Order Code and 4-digit OTP are required.'
            ], 400);
        }

        $result = $this->Medicine_delivery_model->verify_delivery_otp_and_complete($orderCode, $otp, $riderId);

        if (!$result['status']) {
            return $this->_json_response([
                'status' => 'error',
                'message' => $result['message']
            ], 422);
        }

        return $this->_json_response([
            'status' => 'success',
            'message' => $result['message'],
            'data' => [
                'order_code' => $result['order_code'],
                'order_status' => $result['order_status'],
                'delivered_at' => $result['delivered_at'],
                'amount_collected' => $result['amount_collected']
            ]
        ], 200);
    }
}
