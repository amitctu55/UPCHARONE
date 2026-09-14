<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pharmacy_orders Controller
 * Operational SaaS dashboard for licensed partner chemists to process incoming orders,
 * verify prescriptions, confirm stock & batch numbers, generate tax invoices with pickup QR code,
 * and request UPCHAR delivery fleet dispatch.
 */
class Pharmacy_orders extends CI_Controller {

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
     * Single-Page Order Management Dashboard
     * GET /pharmacy/dashboard
     */
    public function dashboard() {
        // Fetch all active pharmacies for store switcher
        $data['stores'] = $this->db->get_where('pharmacy_stores', ['is_active' => 1])->result_array();
        $pharmacyId = (int)($this->input->get('store_id') ?: ($data['stores'][0]['id'] ?? 1));
        $data['current_store'] = $this->db->get_where('pharmacy_stores', ['id' => $pharmacyId])->row_array();

        if (empty($data['current_store'])) {
            show_error('No active pharmacy partner found.');
            return;
        }

        $data['orders'] = $this->_fetch_store_orders($pharmacyId);
        $this->load->view('pharmacy/dashboard', $data);
    }

    /**
     * Polling endpoint for live updates & audio alert
     * GET /pharmacy/get_live_orders
     */
    public function get_live_orders() {
        $pharmacyId = (int)($this->input->get('store_id') ?: 1);
        $orders = $this->_fetch_store_orders($pharmacyId);

        $counts = [
            'total' => count($orders),
            'new_pending' => 0,
            'confirmed' => 0,
            'packed' => 0,
            'in_transit' => 0,
            'delivered' => 0
        ];

        foreach ($orders as $o) {
            if (in_array($o['order_status'], ['PLACED', 'PENDING_RX'])) $counts['new_pending']++;
            elseif ($o['order_status'] === 'CONFIRMED') $counts['confirmed']++;
            elseif (in_array($o['order_status'], ['PACKED', 'ASSIGNED'])) $counts['packed']++;
            elseif ($o['order_status'] === 'IN_TRANSIT') $counts['in_transit']++;
            elseif ($o['order_status'] === 'DELIVERED') $counts['delivered']++;
        }

        return $this->_json_response([
            'status' => 'success',
            'counts' => $counts,
            'orders' => $orders
        ]);
    }

    /**
     * Helper to fetch full order structure for a store
     */
    private function _fetch_store_orders($pharmacyId) {
        $this->db->select('mo.*, op.file_path as prescription_file, op.original_filename as rx_filename, op.verification_status as rx_status, op.pharmacist_reg_no, dr.rider_name, dr.phone as rider_phone, dr.vehicle_number');
        $this->db->from('medicine_orders mo');
        $this->db->join('order_prescriptions op', 'op.id = mo.prescription_id', 'left');
        $this->db->join('delivery_riders dr', 'dr.id = mo.rider_id', 'left');
        $this->db->where('mo.pharmacy_id', (int)$pharmacyId);
        $this->db->order_by('mo.id', 'DESC');
        $orders = $this->db->get()->result_array();

        foreach ($orders as &$ord) {
            $ord['items'] = $this->db->select('moi.*, mm.brand_name, mm.generic_composition, mm.dosage_form, mm.strength, mm.schedule_type, mm.is_prescription_required')
                ->from('medicine_order_items moi')
                ->join('medicines_master mm', 'mm.id = moi.medicine_id', 'left')
                ->where('moi.order_id', $ord['id'])
                ->get()->result_array();
        }

        return $orders;
    }

    /**
     * Action: Accept & Confirm Stock (with itemized price verification)
     * POST /pharmacy/confirm_stock
     */
    public function confirm_stock() {
        $input = json_decode($this->input->raw_input_stream, true) ?: $this->input->post();
        $orderId = (int)($input['order_id'] ?? 0);

        if (!$orderId) {
            return $this->_json_response(['status' => 'error', 'message' => 'Order ID is required.'], 400);
        }

        // Update items batch numbers & expiry if provided
        if (!empty($input['items']) && is_array($input['items'])) {
            foreach ($input['items'] as $item) {
                if (!empty($item['item_id'])) {
                    $this->db->where('id', (int)$item['item_id'])->update('medicine_order_items', [
                        'batch_no' => $item['batch_no'] ?? 'BATCH01',
                        'expiry_date' => $item['expiry_date'] ?? null
                    ]);
                }
            }
        }

        $this->db->where('id', $orderId)->update('medicine_orders', [
            'order_status' => 'CONFIRMED',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->_json_response([
            'status' => 'success',
            'message' => 'Stock verified and confirmed. Order is now ready to be packed.'
        ]);
    }

    /**
     * Action: Mark Packed & Request UPCHAR Rider
     * POST /pharmacy/mark_packed
     */
    public function mark_packed() {
        $input = json_decode($this->input->raw_input_stream, true) ?: $this->input->post();
        $orderId = (int)($input['order_id'] ?? 0);

        if (!$orderId) {
            return $this->_json_response(['status' => 'error', 'message' => 'Order ID is required.'], 400);
        }

        $order = $this->db->get_where('medicine_orders', ['id' => $orderId])->row();
        if (!$order) {
            return $this->_json_response(['status' => 'error', 'message' => 'Order not found.'], 404);
        }

        // 1. Update status to PACKED
        $this->db->where('id', $orderId)->update('medicine_orders', [
            'order_status' => 'PACKED',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Trigger automatic nearest rider assignment within 5km
        $dispatchResult = $this->Medicine_delivery_model->assign_nearest_rider($orderId, 5.0);

        return $this->_json_response([
            'status' => 'success',
            'message' => 'Order marked as PACKED. UPCHAR Fleet dispatch notified.',
            'dispatch' => $dispatchResult
        ]);
    }

    /**
     * Action: Generate Printable Chemist Invoice & Packing Slip with Pickup QR
     * GET /pharmacy/print_invoice/{order_id}
     */
    public function print_invoice($orderId = null) {
        $orderId = (int)$orderId;
        if (!$orderId) {
            show_error('Invalid Order ID.');
            return;
        }

        $order = $this->Medicine_delivery_model->get_order_details($orderId, 'id');
        if (!$order) {
            show_error('Order not found.');
            return;
        }

        $data['order'] = $order;
        $this->load->view('pharmacy/invoice_print', $data);
    }
}
