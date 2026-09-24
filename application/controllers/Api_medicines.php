<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api_medicines Controller
 * RESTful API endpoints for medicine comparison, prescription uploading,
 * pharmacist validation pipeline, and order placement.
 */
class Api_medicines extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Medicine_delivery_model');
        $this->load->helper(['url', 'form']);
        // Ensure uploads directory exists
        $uploadDir = FCPATH . 'uploads/prescriptions';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }
    }

    /**
     * Send structured JSON response
     */
    private function _json_response($data, $statusCode = 200) {
        $this->output
            ->set_status_header($statusCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Step 2: Medicine Inventory & Proximity Comparison API
     * GET /api/v1/medicines/compare
     */
    public function compare() {
        // Support both GET query parameters and POST
        $keyword   = trim($this->input->get('keyword') ?? ($this->input->post('keyword') ?? ''));
        $user_lat  = (float)($this->input->get('user_lat') ?? ($this->input->post('user_lat') ?? 25.3176));
        $user_lng  = (float)($this->input->get('user_lng') ?? ($this->input->post('user_lng') ?? 82.9739));
        $radius_km = (float)($this->input->get('radius_km') ?? ($this->input->post('radius_km') ?? 8.0));
        $doctor_id = $this->input->get('doctor_id') ?? ($this->input->post('doctor_id') ?? null);
        $page      = (int)($this->input->get('page') ?? ($this->input->post('page') ?? 1));
        $limit     = (int)($this->input->get('limit') ?? ($this->input->post('limit') ?? 10));

        // Input sanitation & safety
        if ($radius_km > 50) $radius_km = 50; // Cap search radius at 50km
        if ($limit > 50) $limit = 50;

        try {
            $comparison = $this->Medicine_delivery_model->search_and_compare(
                $keyword,
                $user_lat,
                $user_lng,
                $radius_km,
                $doctor_id,
                $page,
                $limit
            );

            return $this->_json_response([
                'status'  => 'success',
                'message' => 'Pharmacies and medicine inventory fetched successfully.',
                'meta'    => [
                    'query_keyword' => $keyword,
                    'doctor_pinned' => !empty($doctor_id),
                    'total_results' => $comparison['total_records'],
                    'current_page'  => $comparison['current_page'],
                    'total_pages'   => $comparison['total_pages'],
                    'per_page'      => $comparison['per_page']
                ],
                'data' => $comparison['stores']
            ], 200);
        } catch (Throwable $e) {
            return $this->_json_response([
                'status'  => 'error',
                'message' => 'Failed to query medicine availability: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Step 3: Prescription Upload API
     * POST /api/v1/prescriptions/upload
     */
    public function upload_prescription() {
        // Enforce POST
        if ($this->input->method() !== 'post') {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'Only POST requests are permitted for file uploads.'
            ], 405);
        }

        if (empty($_FILES['prescription_file']['name'])) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'No prescription file provided. Please upload a JPG, PNG, or PDF file.'
            ], 400);
        }

        $file = $_FILES['prescription_file'];

        // Size check (max 5MB = 5 * 1024 * 1024 bytes)
        if ($file['size'] > 5242880) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'File exceeds the maximum allowable limit of 5MB.'
            ], 400);
        }

        // Validate MIME type securely
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($detectedMime, $allowedMimes)) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'Invalid file format. Only JPG, PNG, WebP and PDF documents are allowed (detected: ' . $detectedMime . ').'
            ], 400);
        }

        // Generate encrypted/obfuscated unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $hashedName = 'rx_' . hash('sha256', uniqid(mt_rand(), true)) . '.' . strtolower($ext);
        $destination = FCPATH . 'uploads/prescriptions/' . $hashedName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'Failed to save encrypted prescription file to storage.'
            ], 500);
        }

        $userId = $this->session->userdata('userid') ?: 1;
        $fileSizeKb = round($file['size'] / 1024);

        $rxId = $this->Medicine_delivery_model->save_prescription([
            'user_id' => $userId,
            'file_path' => 'uploads/prescriptions/' . $hashedName,
            'original_filename' => basename($file['name']),
            'mime_type' => $detectedMime,
            'file_size_kb' => $fileSizeKb
        ]);

        return $this->_json_response([
            'status' => 'success',
            'message' => 'Prescription uploaded securely. It has been routed to the dispensing pharmacy for pharmacist validation.',
            'data' => [
                'prescription_id' => $rxId,
                'file_name' => $hashedName,
                'file_url'  => base_url('uploads/prescriptions/' . $hashedName),
                'verification_status' => 'PENDING',
                'uploaded_at' => date('Y-m-d H:i:s')
            ]
        ], 201);
    }

    /**
     * Step 3: Pharmacist Verification Webhook / API
     * PUT / POST /api/v1/pharmacy/orders/{id}/verify-rx
     */
    public function verify_prescription($id = null) {
        $orderOrRxId = (int)$id ?: (int)$this->input->post('id');
        if (!$orderOrRxId) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'Missing order or prescription ID.'
            ], 400);
        }

        // Read raw JSON input or POST form data
        $input = json_decode($this->input->raw_input_stream, true) ?: $this->input->post();

        $status = strtoupper(trim($input['status'] ?? ''));
        $pharmacistRegNo = trim($input['pharmacist_reg_no'] ?? '');
        $notes = trim($input['notes'] ?? ($input['rejection_reason'] ?? ''));

        if (!in_array($status, ['APPROVED', 'REJECTED'])) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'Status must be either APPROVED or REJECTED.'
            ], 400);
        }

        if ($status === 'APPROVED' && empty($pharmacistRegNo)) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'Pharmacist Registration Number is mandatory for legal compliance under the Drugs & Cosmetics Act.'
            ], 422);
        }

        if ($status === 'REJECTED' && empty($notes)) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'A valid rejection reason must be specified to notify the patient.'
            ], 422);
        }

        // Determine if ID is order_id or prescription_id
        $rx = $this->db->get_where('order_prescriptions', ['id' => $orderOrRxId])->row();
        if (!$rx) {
            $order = $this->db->get_where('medicine_orders', ['id' => $orderOrRxId])->row();
            if ($order && !empty($order->prescription_id)) {
                $rx = $this->db->get_where('order_prescriptions', ['id' => $order->prescription_id])->row();
            }
        }

        if (!$rx) {
            return $this->_json_response([
                'status' => 'error',
                'message' => 'Prescription record not found for the given reference.'
            ], 404);
        }

        $pharmacistId = (int)($this->session->userdata('staff_user_id') ?: 1);

        $this->Medicine_delivery_model->update_prescription_verification(
            $rx->id,
            $status,
            $pharmacistId,
            $pharmacistRegNo,
            $notes
        );

        // Simulated Instant SMS/Notification dispatch
        $notificationPayload = [
            'recipient_user_id' => $rx->user_id,
            'event' => 'RX_VERIFICATION_' . $status,
            'message' => ($status === 'APPROVED') 
                ? "Your prescription has been approved by Registered Pharmacist ({$pharmacistRegNo}). Your order is now confirmed."
                : "Your prescription was rejected by the partner pharmacy. Reason: {$notes}. Please re-upload a clear doctor prescription.",
            'timestamp' => date('Y-m-d H:i:s')
        ];

        return $this->_json_response([
            'status' => 'success',
            'message' => "Prescription marked as {$status} by pharmacist.",
            'data' => [
                'prescription_id' => $rx->id,
                'verification_status' => $status,
                'pharmacist_reg_no'   => $pharmacistRegNo,
                'notes'               => $notes,
                'patient_alert'       => $notificationPayload
            ]
        ], 200);
    }

    /**
     * Create Order Endpoint (for Checkout & Patient Modal)
     * POST /api/v1/medicines/create-order or /api/order
     */
    public function create_order() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        if (strtoupper($this->input->method()) === 'OPTIONS') {
            return $this->output->set_status_header(200)->_display();
        }

        $rawBody = $this->input->raw_input_stream;
        $input = json_decode($rawBody, true);
        if (empty($input) || !is_array($input)) {
            $input = $this->input->post();
        }
        if (empty($input) || !is_array($input)) {
            $input = [];
        }

        // Support stringified JSON items if submitted via multipart/form-data
        if (!empty($input['items']) && is_string($input['items'])) {
            $decodedItems = json_decode($input['items'], true);
            if (is_array($decodedItems)) {
                $input['items'] = $decodedItems;
            }
        }

        // Support direct root-level medicine_id parameter (1-click order from card)
        if (empty($input['items']) && !empty($input['medicine_id'])) {
            $qty = !empty($input['quantity']) ? max(1, (int)$input['quantity']) : 1;
            $unitPrice = !empty($input['unit_price']) ? (float)$input['unit_price'] : (!empty($input['price']) ? (float)$input['price'] : 30.00);
            $unitMrp = !empty($input['unit_mrp']) ? (float)$input['unit_mrp'] : ($unitPrice * 1.15);
            $totalPrice = !empty($input['total_price']) ? (float)$input['total_price'] : ($unitPrice * $qty);

            $input['items'] = [
                [
                    'medicine_id' => (int)$input['medicine_id'],
                    'quantity'    => $qty,
                    'unit_mrp'    => $unitMrp,
                    'unit_price'  => $unitPrice,
                    'total_price' => $totalPrice
                ]
            ];

            if (empty($input['item_total'])) {
                $input['item_total'] = $totalPrice;
            }
            if (empty($input['total_amount'])) {
                $input['total_amount'] = $totalPrice + (float)($input['delivery_fee'] ?? 40.00);
            }
        }

        if (empty($input['pharmacy_id']) || (int)$input['pharmacy_id'] <= 0) {
            return $this->_json_response(['status' => 'error', 'message' => 'Pharmacy ID is required.'], 400);
        }
        if (empty($input['items']) || !is_array($input['items'])) {
            return $this->_json_response(['status' => 'error', 'message' => 'At least one medicine item is required.'], 400);
        }

        $userId = $this->session->userdata('userid') ?: $this->session->userdata('USERID') ?: 1;
        $custName = !empty($input['customer_name']) ? trim($input['customer_name']) : ($this->session->userdata('username') ?: 'Patient');
        $custPhone = !empty($input['customer_phone']) ? trim($input['customer_phone']) : ($this->session->userdata('mobile') ?: '9839112233');
        $custAddress = !empty($input['delivery_address']) ? trim($input['delivery_address']) : 'Sigra, Varanasi, Uttar Pradesh';

        $orderData = [
            'user_id' => (int)$userId,
            'pharmacy_id' => (int)$input['pharmacy_id'],
            'prescription_id' => !empty($input['prescription_id']) ? (int)$input['prescription_id'] : null,
            'item_total' => (float)($input['item_total'] ?? 0),
            'delivery_fee' => (float)($input['delivery_fee'] ?? 40.00),
            'total_amount' => (float)($input['total_amount'] ?? 0),
            'payment_mode' => $input['payment_mode'] ?? 'COD',
            'customer_name' => $custName,
            'customer_phone' => $custPhone,
            'delivery_address' => $custAddress,
            'delivery_lat' => !empty($input['delivery_lat']) ? (float)$input['delivery_lat'] : 25.3176,
            'delivery_lng' => !empty($input['delivery_lng']) ? (float)$input['delivery_lng'] : 82.9739
        ];

        $result = $this->Medicine_delivery_model->create_order($orderData, $input['items']);

        if (!$result) {
            return $this->_json_response(['status' => 'error', 'message' => 'Failed to create order.'], 500);
        }

        return $this->_json_response([
            'status' => 'success',
            'message' => 'Medicine order placed successfully!',
            'data' => $result
        ], 201);
    }
}
