<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cart_Model');
        $this->load->model('Coupon_model');
    }

    /**
     * Check if user has active session
     */
    private function _get_user_id() {
        return $this->session->userdata('userid') ?: $this->session->userdata('USERID') ?: $this->session->userdata('user_id') ?: null;
    }

    /**
     * View Cart Page in User Portal
     */
    public function index() {
        $userId = $this->_get_user_id();

        if (!$userId) {
            $this->session->set_userdata('last_page', base_url('cart'));
            $this->session->set_flashdata('login_notice', 'Please login to view your shopping cart.');
            redirect('login');
            return;
        }

        // Process any pending cart item added before login
        $this->Cart_Model->process_pending_cart($userId);

        $appliedCoupon = $this->session->userdata('cart_coupon') ?: null;
        $summary = $this->Cart_Model->get_cart_summary($userId, $appliedCoupon);

        // If coupon became invalid (e.g. subtotal dropped below min), remove it
        if ($appliedCoupon && empty($summary['applied_coupon']['valid'])) {
            $this->session->unset_userdata('cart_coupon');
            $summary = $this->Cart_Model->get_cart_summary($userId, null);
        }

        $userRow = $this->db->get_where('userlogin', ['USERID' => $userId])->row();
        $data['user_profile'] = [
            'name'  => $userRow ? trim(($userRow->FNAME ?? '') . ' ' . ($userRow->LNAME ?? '')) : '',
            'phone' => $userRow ? ($userRow->MOBILE ?? '') : '',
            'email' => $userRow ? ($userRow->EMAIL ?? '') : ''
        ];

        $data['summary'] = $summary;
        $data['cart_items'] = $summary['items'];
        $data['available_coupons'] = $this->Coupon_model->get_available_coupons('MEDICINE', $userId);
        $data['page_title'] = 'My Medicine Cart - Upchar';

        $this->load->view('cart_view', $data);
    }

    /**
     * Alias for view_cart
     */
    public function view_cart() {
        $this->index();
    }

    /**
     * Add Item to Cart (AJAX) with Authentication Enforcement
     */
    public function add_to_cart() {
        $userId = $this->_get_user_id();

        $pharmacyId = intval($this->input->post('pharmacy_id') ?: 1);
        $medicineId = intval($this->input->post('medicine_id'));
        $quantity   = max(1, intval($this->input->post('quantity') ?: 1));
        $unitPrice  = $this->input->post('unit_price') ? floatval($this->input->post('unit_price')) : null;
        $unitMrp    = $this->input->post('unit_mrp') ? floatval($this->input->post('unit_mrp')) : null;
        $brandName  = trim($this->input->post('brand_name') ?: 'Medicine');

        if (!$medicineId) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Invalid medicine item selected.'
            ]);
            return;
        }

        // 1. If user is NOT logged in: prevent addition and instruct client to redirect / open login
        if (!$userId) {
            // Save intended cart item in session so after login it auto-adds to their user cart
            $this->session->set_userdata('pending_cart_item', [
                'pharmacy_id' => $pharmacyId,
                'medicine_id' => $medicineId,
                'quantity'    => $quantity,
                'unit_price'  => $unitPrice,
                'unit_mrp'    => $unitMrp,
                'brand_name'  => $brandName
            ]);

            // Set destination after login to cart or referer
            $returnUrl = $this->input->server('HTTP_REFERER') ?: base_url('medical');
            $this->session->set_userdata('last_page', base_url('cart'));

            echo json_encode([
                'status'        => 'auth_required',
                'redirect_url'  => base_url('login'),
                'message'       => 'Please login or register to add "' . htmlspecialchars($brandName) . '" to your cart.'
            ]);
            return;
        }

        // 2. If user IS logged in: add directly to database cart
        $result = $this->Cart_Model->add_item($userId, $pharmacyId, $medicineId, $quantity, $unitPrice, $unitMrp);
        echo json_encode($result);
    }

    /**
     * Update Quantity for Cart Item (AJAX)
     */
    public function update_quantity() {
        $userId = $this->_get_user_id();
        if (!$userId) {
            echo json_encode(['status' => 'auth_required', 'message' => 'Please login to manage your cart.']);
            return;
        }

        $cartId   = intval($this->input->post('cart_id'));
        $quantity = intval($this->input->post('quantity'));

        $this->Cart_Model->update_quantity($userId, $cartId, $quantity);

        $appliedCoupon = $this->session->userdata('cart_coupon') ?: null;
        $summary = $this->Cart_Model->get_cart_summary($userId, $appliedCoupon);

        echo json_encode([
            'status'     => 'success',
            'message'    => 'Cart updated successfully.',
            'summary'    => $summary,
            'cart_count' => $summary['total_qty']
        ]);
    }

    /**
     * Remove Item from Cart (AJAX)
     */
    public function remove_item() {
        $userId = $this->_get_user_id();
        if (!$userId) {
            echo json_encode(['status' => 'auth_required', 'message' => 'Please login to manage your cart.']);
            return;
        }

        $cartId = intval($this->input->post('cart_id'));
        $this->Cart_Model->remove_item($userId, $cartId);

        $appliedCoupon = $this->session->userdata('cart_coupon') ?: null;
        $summary = $this->Cart_Model->get_cart_summary($userId, $appliedCoupon);

        echo json_encode([
            'status'     => 'success',
            'message'    => 'Item removed from cart.',
            'summary'    => $summary,
            'cart_count' => $summary['total_qty']
        ]);
    }

    /**
     * Apply Discount Coupon Code (AJAX)
     */
    public function apply_coupon() {
        $userId = $this->_get_user_id();
        if (!$userId) {
            echo json_encode(['status' => 'auth_required', 'message' => 'Please login to apply coupons.']);
            return;
        }

        $code = trim($this->input->post('coupon_code'));
        if (empty($code)) {
            echo json_encode(['status' => 'error', 'message' => 'Please enter a coupon code.']);
            return;
        }

        // Get subtotal
        $summary = $this->Cart_Model->get_cart_summary($userId, null);
        if ($summary['subtotal'] <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Your cart is empty.']);
            return;
        }

        $val = $this->Coupon_model->validate_coupon($code, $userId, 'MEDICINE', $summary['subtotal']);

        if (!$val['valid']) {
            $this->session->unset_userdata('cart_coupon');
            echo json_encode([
                'status'  => 'error',
                'message' => $val['message']
            ]);
            return;
        }

        // Store active coupon in session
        $this->session->set_userdata('cart_coupon', $val['coupon_code']);
        $newSummary = $this->Cart_Model->get_cart_summary($userId, $val['coupon_code']);

        echo json_encode([
            'status'          => 'success',
            'message'         => $val['message'],
            'discount_amount' => $val['discount_amount'],
            'coupon_code'     => $val['coupon_code'],
            'summary'         => $newSummary
        ]);
    }

    /**
     * Remove Applied Coupon Code (AJAX)
     */
    public function remove_coupon() {
        $userId = $this->_get_user_id();
        $this->session->unset_userdata('cart_coupon');

        $summary = $userId ? $this->Cart_Model->get_cart_summary($userId, null) : [];

        echo json_encode([
            'status'  => 'success',
            'message' => 'Coupon removed.',
            'summary' => $summary
        ]);
    }

    /**
     * Get Current Cart Item Count (AJAX for Navbar / Medical Store page)
     */
    public function get_count() {
        $userId = $this->_get_user_id();
        $count = $userId ? $this->Cart_Model->get_cart_count($userId) : 0;
        echo json_encode([
            'logged_in'  => (bool)$userId,
            'cart_count' => $count
        ]);
    }

    /**
     * Complete Payment / Doorstep Checkout (AJAX)
     */
    public function checkout() {
        $userId = $this->_get_user_id();
        if (!$userId) {
            echo json_encode([
                'status'       => 'auth_required',
                'redirect_url' => base_url('login'),
                'message'      => 'Please log in to complete your order checkout.'
            ]);
            return;
        }

        $customerName = trim($this->input->post('customer_name') ?: '');
        $customerPhone = trim($this->input->post('customer_phone') ?: '');
        $deliveryAddress = trim($this->input->post('delivery_address') ?: '');
        $paymentMode = strtoupper(trim($this->input->post('payment_mode') ?: 'COD'));

        // Fallbacks from user profile if not provided
        if (empty($customerName) || empty($customerPhone)) {
            $userRow = $this->db->get_where('userlogin', ['USERID' => $userId])->row();
            if ($userRow) {
                if (empty($customerName)) {
                    $customerName = trim(($userRow->FNAME ?? '') . ' ' . ($userRow->LNAME ?? '')) ?: 'Patient';
                }
                if (empty($customerPhone)) {
                    $customerPhone = $userRow->MOBILE ?: '9876543210';
                }
            }
        }

        if (empty($deliveryAddress)) {
            $deliveryAddress = 'Varanasi, Uttar Pradesh';
        }

        $customerData = [
            'customer_name'    => $customerName,
            'customer_phone'   => $customerPhone,
            'delivery_address' => $deliveryAddress,
            'payment_mode'     => in_array($paymentMode, ['ONLINE', 'WALLET', 'COD']) ? $paymentMode : 'COD'
        ];

        $appliedCoupon = $this->session->userdata('cart_coupon') ?: null;
        $result = $this->Cart_Model->create_order_from_cart($userId, $customerData, $appliedCoupon);

        echo json_encode($result);
    }

    /**
     * Live Order Delivery Tracking Page
     */
    public function order($orderId = null) {
        $orderId = intval($orderId);
        if (!$orderId) {
            redirect('cart');
            return;
        }

        $userId = $this->_get_user_id();
        $order = $this->Cart_Model->get_order_details($orderId);

        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found or invalid.');
            redirect('cart');
            return;
        }

        $data['order'] = $order;
        $data['page_title'] = "Order Tracking #{$order->order_code} - Upchar";

        $this->load->view('order_tracking_view', $data);
    }

    /**
     * Get Order Live Status (AJAX Polling)
     */
    public function get_order_status($orderId = null) {
        $orderId = intval($orderId);
        $order = $this->Cart_Model->get_order_details($orderId);

        if (!$order) {
            echo json_encode(['status' => 'error', 'message' => 'Order not found.']);
            return;
        }

        echo json_encode([
            'status'            => 'success',
            'order_id'          => $order->id,
            'order_code'        => $order->order_code,
            'order_status'      => $order->order_status,
            'payment_status'    => $order->payment_status,
            'payment_mode'      => $order->payment_mode,
            'total_amount'      => $order->total_amount,
            'delivery_otp'      => $order->delivery_otp,
            'qr_token'          => $order->qr_token,
            'store_name'        => $order->store_name,
            'store_address'     => $order->store_address,
            'store_phone'       => $order->store_phone,
            'rider_name'        => $order->rider_full_name ?: $order->rider_name ?: 'Rahul Yadav',
            'rider_phone'       => $order->rider_phone ?: '9839001122',
            'vehicle_number'    => $order->vehicle_number ?: 'UP-65-AX-4412',
            'vehicle_type'      => $order->vehicle_type ?: 'Bike',
            'dispatched_at'     => $order->dispatched_at,
            'delivered_at'      => $order->delivered_at,
            'picked_up_at'      => $order->picked_up_at
        ]);
    }

    /**
     * Advance Order Stage (Simulate Store Packing -> Store Pickup -> Out for Delivery)
     */
    public function advance_order_stage() {
        $orderId = intval($this->input->post('order_id'));
        $targetStage = $this->input->post('target_stage') ? strtoupper(trim($this->input->post('target_stage'))) : null;

        if (!$orderId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid order ID.']);
            return;
        }

        $res = $this->Cart_Model->advance_order_stage($orderId, $targetStage);
        echo json_encode($res);
    }

    /**
     * Verify Delivery via 4-Digit OTP (AJAX)
     */
    public function verify_delivery_otp() {
        $orderId = intval($this->input->post('order_id'));
        $otp = trim($this->input->post('otp') ?: $this->input->post('delivery_otp') ?: '');

        if (!$orderId || empty($otp)) {
            echo json_encode(['status' => 'error', 'message' => 'Please provide both order ID and 4-digit OTP.']);
            return;
        }

        $res = $this->Cart_Model->verify_delivery_otp($orderId, $otp);
        echo json_encode($res);
    }

    /**
     * Verify Delivery via QR Code Token (AJAX or Direct Scan Link)
     */
    public function verify_delivery_qr() {
        $orderId = intval($this->input->post('order_id') ?: $this->input->get('order_id'));
        $qrToken = trim($this->input->post('qr_token') ?: $this->input->get('qr_token') ?: '');

        if (!$orderId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid order ID.']);
            return;
        }

        $res = $this->Cart_Model->verify_delivery_qr($orderId, $qrToken);

        // If called directly via browser GET scan link
        if ($this->input->method(TRUE) === 'GET' && !empty($this->input->get('redirect'))) {
            if ($res['status'] === 'success') {
                $this->session->set_flashdata('delivery_success', 'Order #' . $orderId . ' verified and delivered via QR Scan!');
            } else {
                $this->session->set_flashdata('delivery_error', $res['message']);
            }
            redirect('cart/order/' . $orderId);
            return;
        }

        echo json_encode($res);
    }
}

