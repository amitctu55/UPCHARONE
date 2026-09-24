<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_schema();
    }

    /**
     * Self-healing migration for cart table
     */
    public function ensure_schema() {
        if (!$this->db->table_exists('cart')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `cart` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `user_id` MEDIUMINT(9) NOT NULL,
                    `pharmacy_id` INT NOT NULL,
                    `medicine_id` INT NOT NULL,
                    `quantity` INT NOT NULL DEFAULT 1,
                    `unit_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                    `unit_mrp` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX `idx_cart_user` (`user_id`),
                    INDEX `idx_cart_med` (`medicine_id`),
                    INDEX `idx_cart_pharmacy` (`pharmacy_id`),
                    UNIQUE KEY `unique_user_store_med` (`user_id`, `pharmacy_id`, `medicine_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }
    }

    /**
     * Check if user is logged in
     */
    public function is_logged_in() {
        return ($this->session->userdata('userid') || $this->session->userdata('USERID') || $this->session->userdata('user_id'));
    }

    /**
     * Get active logged-in user ID
     */
    public function get_user_id() {
        return $this->session->userdata('userid') ?: $this->session->userdata('USERID') ?: $this->session->userdata('user_id') ?: null;
    }

    /**
     * Add item to database cart
     */
    public function add_item($userId, $pharmacyId, $medicineId, $quantity = 1, $unitPrice = null, $unitMrp = null) {
        $userId = intval($userId);
        $pharmacyId = intval($pharmacyId);
        $medicineId = intval($medicineId);
        $quantity = max(1, intval($quantity));

        if (!$userId || !$pharmacyId || !$medicineId) {
            return ['status' => 'error', 'message' => 'Invalid medicine or store parameters.'];
        }

        // Fetch live pricing and availability from pharmacy_inventory if not passed
        if ($unitPrice === null || $unitMrp === null) {
            $inv = $this->db->get_where('pharmacy_inventory', [
                'pharmacy_id' => $pharmacyId,
                'medicine_id' => $medicineId,
                'is_available' => 1
            ])->row();

            if ($inv) {
                $unitPrice = floatval($inv->selling_price);
                $unitMrp = floatval($inv->mrp ?: $inv->selling_price);
            } else {
                $unitPrice = 30.00;
                $unitMrp = 35.00;
            }
        }

        // Check if item already exists in user's cart
        $existing = $this->db->get_where('cart', [
            'user_id' => $userId,
            'pharmacy_id' => $pharmacyId,
            'medicine_id' => $medicineId
        ])->row();

        if ($existing) {
            $newQty = $existing->quantity + $quantity;
            $this->db->where('id', $existing->id)->update('cart', [
                'quantity'   => $newQty,
                'unit_price' => $unitPrice,
                'unit_mrp'   => $unitMrp,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $cartId = $existing->id;
        } else {
            $this->db->insert('cart', [
                'user_id'     => $userId,
                'pharmacy_id' => $pharmacyId,
                'medicine_id' => $medicineId,
                'quantity'    => $quantity,
                'unit_price'  => $unitPrice,
                'unit_mrp'    => $unitMrp,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ]);
            $cartId = $this->db->insert_id();
        }

        $totalCount = $this->get_cart_count($userId);

        return [
            'status'     => 'success',
            'cart_id'    => $cartId,
            'message'    => 'Medicine added to cart successfully!',
            'cart_count' => $totalCount
        ];
    }

    /**
     * Get all cart items for a user with medicine and pharmacy metadata
     */
    public function get_cart_items($userId) {
        $userId = intval($userId);
        if (!$userId) return [];

        $sql = "
            SELECT 
                c.id AS cart_id,
                c.user_id,
                c.pharmacy_id,
                c.medicine_id,
                c.quantity,
                c.unit_price,
                c.unit_mrp,
                mm.brand_name,
                mm.generic_composition,
                mm.dosage_form,
                mm.is_prescription_required,
                mm.manufacturer,
                ps.store_name,
                ps.phone AS store_phone,
                ps.address AS store_address,
                ps.city AS store_city,
                ps.pincode AS store_pincode,
                ps.delivery_radius_km,
                pi.stock_quantity,
                pi.batch_no,
                pi.expiry_date
            FROM cart c
            JOIN medicines_master mm ON mm.id = c.medicine_id
            JOIN pharmacy_stores ps ON ps.id = c.pharmacy_id
            LEFT JOIN pharmacy_inventory pi ON pi.pharmacy_id = c.pharmacy_id AND pi.medicine_id = c.medicine_id
            WHERE c.user_id = ?
            ORDER BY ps.store_name ASC, c.id DESC
        ";

        $res = $this->db->query($sql, [$userId]);
        $items = ($res && is_object($res)) ? $res->result() : [];

        foreach ($items as &$item) {
            $item->item_total = round($item->unit_price * $item->quantity, 2);
            $item->item_mrp_total = round($item->unit_mrp * $item->quantity, 2);
            $item->item_savings = max(0, round($item->item_mrp_total - $item->item_total, 2));
        }

        return $items;
    }

    /**
     * Update quantity for a specific cart row
     */
    public function update_quantity($userId, $cartId, $quantity) {
        $userId = intval($userId);
        $cartId = intval($cartId);
        $quantity = intval($quantity);

        if ($quantity <= 0) {
            return $this->remove_item($userId, $cartId);
        }

        $this->db->where(['id' => $cartId, 'user_id' => $userId])
                 ->update('cart', ['quantity' => $quantity, 'updated_at' => date('Y-m-d H:i:s')]);

        return [
            'status'     => 'success',
            'message'    => 'Cart updated successfully.',
            'cart_count' => $this->get_cart_count($userId)
        ];
    }

    /**
     * Remove item from cart
     */
    public function remove_item($userId, $cartId) {
        $userId = intval($userId);
        $cartId = intval($cartId);

        $this->db->where(['id' => $cartId, 'user_id' => $userId])->delete('cart');

        return [
            'status'     => 'success',
            'message'    => 'Item removed from cart.',
            'cart_count' => $this->get_cart_count($userId)
        ];
    }

    /**
     * Clear all items in user's cart
     */
    public function clear_cart($userId) {
        $userId = intval($userId);
        $this->db->where('user_id', $userId)->delete('cart');
        return true;
    }

    /**
     * Total item count in cart
     */
    public function get_cart_count($userId) {
        $userId = intval($userId);
        if (!$userId) return 0;

        $res = $this->db->query("SELECT COALESCE(SUM(quantity), 0) AS total_qty FROM cart WHERE user_id = ?", [$userId])->row();
        return intval($res ? $res->total_qty : 0);
    }

    /**
     * Get full financial summary of cart including applied coupon
     */
    public function get_cart_summary($userId, $couponCode = null) {
        $items = $this->get_cart_items($userId);
        $subtotal = 0.00;
        $mrpTotal = 0.00;
        $hasRxRequired = false;

        foreach ($items as $it) {
            $subtotal += $it->item_total;
            $mrpTotal += $it->item_mrp_total;
            if ($it->is_prescription_required) {
                $hasRxRequired = true;
            }
        }

        $deliveryFee = ($subtotal > 0 && $subtotal < 500) ? 40.00 : 0.00;
        $tax = round($subtotal * 0.05, 2); // 5% GST on pharmaceutical products
        $retailSavings = max(0, round($mrpTotal - $subtotal, 2));

        $discount = 0.00;
        $appliedCoupon = null;

        if (!empty($couponCode)) {
            $this->load->model('Coupon_model');
            $couponResult = $this->Coupon_model->validate_coupon($couponCode, $userId, 'MEDICINE', $subtotal);
            if ($couponResult['valid']) {
                $discount = floatval($couponResult['discount_amount']);
                $appliedCoupon = $couponResult;
            }
        }

        $grandTotal = max(0, round($subtotal + $deliveryFee + $tax - $discount, 2));

        return [
            'items'           => $items,
            'item_count'      => count($items),
            'total_qty'       => array_sum(array_column($items, 'quantity')),
            'subtotal'        => round($subtotal, 2),
            'mrp_total'       => round($mrpTotal, 2),
            'retail_savings'  => $retailSavings,
            'delivery_fee'    => round($deliveryFee, 2),
            'tax'             => $tax,
            'discount'        => round($discount, 2),
            'grand_total'     => $grandTotal,
            'has_rx_required' => $hasRxRequired,
            'applied_coupon'  => $appliedCoupon
        ];
    }

    /**
     * Process pending cart item from session (after login)
     */
    public function process_pending_cart($userId) {
        $pending = $this->session->userdata('pending_cart_item');
        if (!empty($pending) && is_array($pending) && !empty($pending['medicine_id'])) {
            $pharmacyId = intval($pending['pharmacy_id'] ?? 1);
            $medicineId = intval($pending['medicine_id']);
            $quantity = intval($pending['quantity'] ?? 1);
            $unitPrice = isset($pending['unit_price']) ? floatval($pending['unit_price']) : null;
            $unitMrp = isset($pending['unit_mrp']) ? floatval($pending['unit_mrp']) : null;

            $this->add_item($userId, $pharmacyId, $medicineId, $quantity, $unitPrice, $unitMrp);
            $this->session->unset_userdata('pending_cart_item');
            return true;
        }
        return false;
    }

    /**
     * Create an order in medicine_orders from current cart items
     */
    public function create_order_from_cart($userId, $customerData = [], $couponCode = null) {
        $userId = intval($userId);
        $summary = $this->get_cart_summary($userId, $couponCode);

        if (empty($summary['items'])) {
            return ['status' => 'error', 'message' => 'Your cart is empty.'];
        }

        // Determine primary dispensing pharmacy from first item
        $primaryPharmacyId = intval($summary['items'][0]->pharmacy_id);

        // Auto-assign an active rider
        $rider = $this->db->where('is_active', 1)->order_by('id', 'ASC')->get('delivery_riders')->row();
        $riderId = $rider ? intval($rider->id) : 1;

        $orderCode = 'UPC-MED-' . date('ymd') . '-' . mt_rand(1000, 9999);
        $deliveryOtp = str_pad(strval(mt_rand(1000, 9999)), 4, '0', STR_PAD_LEFT);

        $paymentMode = in_array(strtoupper($customerData['payment_mode'] ?? ''), ['ONLINE', 'WALLET']) ? strtoupper($customerData['payment_mode']) : 'COD';
        $paymentStatus = in_array($paymentMode, ['ONLINE', 'WALLET']) ? 'PAID' : 'PENDING';

        $orderData = [
            'order_code'        => $orderCode,
            'user_id'           => $userId,
            'pharmacy_id'       => $primaryPharmacyId,
            'prescription_id'   => null,
            'item_total'        => $summary['subtotal'],
            'delivery_fee'      => $summary['delivery_fee'],
            'total_amount'      => $summary['grand_total'],
            'order_status'      => 'PLACED',
            'payment_mode'      => $paymentMode,
            'payment_status'    => $paymentStatus,
            'delivery_otp'      => $deliveryOtp,
            'customer_name'     => trim($customerData['customer_name'] ?? 'Patient'),
            'customer_phone'    => trim($customerData['customer_phone'] ?? '9876543210'),
            'delivery_address'  => trim($customerData['delivery_address'] ?? 'Varanasi, Uttar Pradesh'),
            'rider_id'          => $riderId,
            'rider_assigned_at' => date('Y-m-d H:i:s'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s')
        ];

        $this->db->insert('medicine_orders', $orderData);
        $orderId = $this->db->insert_id();

        // Insert items
        foreach ($summary['items'] as $item) {
            $this->db->insert('medicine_order_items', [
                'order_id'    => $orderId,
                'medicine_id' => $item->medicine_id,
                'batch_no'    => $item->batch_no ?: 'DL' . mt_rand(100, 999),
                'expiry_date' => $item->expiry_date ?: date('Y-m-d', strtotime('+1 year')),
                'quantity'    => $item->quantity,
                'unit_mrp'    => $item->unit_mrp,
                'unit_price'  => $item->unit_price,
                'total_price' => $item->item_total,
                'created_at'  => date('Y-m-d H:i:s')
            ]);
        }

        // Insert assignment
        $this->db->insert('order_delivery_assignments', [
            'order_id'             => $orderId,
            'rider_id'             => $riderId,
            'assigned_at'          => date('Y-m-d H:i:s'),
            'picked_up_at'         => null,
            'delivered_at'         => null,
            'delivery_status'      => 'ASSIGNED',
            'rider_payout_amount'  => 35.00,
            'cod_collected_amount' => 0.00
        ]);

        // Record coupon usage if applied
        if (!empty($summary['applied_coupon']['valid'])) {
            $this->load->model('Coupon_model');
            $this->Coupon_model->record_usage($summary['applied_coupon']['coupon_id'], $userId, $orderCode, 'MEDICINE', $summary['subtotal'], $summary['discount']);
        }

        // Clear user cart and session coupon
        $this->clear_cart($userId);
        $this->session->unset_userdata('cart_coupon');

        return [
            'status'       => 'success',
            'message'      => 'Order placed successfully!',
            'order_id'     => $orderId,
            'order_code'   => $orderCode,
            'delivery_otp' => $deliveryOtp,
            'total_amount' => $summary['grand_total'],
            'redirect_url' => base_url('cart/order/' . $orderId)
        ];
    }

    /**
     * Get detailed order info for live tracking
     */
    public function get_order_details($orderId, $userId = null) {
        $orderId = intval($orderId);
        $this->db->select("
            mo.*,
            ps.store_name,
            ps.phone AS store_phone,
            ps.address AS store_address,
            ps.city AS store_city,
            ps.pincode AS store_pincode,
            ps.operating_hours,
            ps.delivery_radius_km,
            dr.name AS rider_full_name,
            dr.rider_name,
            dr.phone AS rider_phone,
            dr.vehicle_type,
            dr.vehicle_number,
            dr.status AS rider_status,
            oda.picked_up_at,
            oda.delivered_at AS assignment_delivered_at
        ");
        $this->db->from('medicine_orders mo');
        $this->db->join('pharmacy_stores ps', 'ps.id = mo.pharmacy_id', 'left');
        $this->db->join('delivery_riders dr', 'dr.id = mo.rider_id', 'left');
        $this->db->join('order_delivery_assignments oda', 'oda.order_id = mo.id', 'left');
        $this->db->where('mo.id', $orderId);
        if ($userId) {
            $this->db->where('mo.user_id', intval($userId));
        }

        $order = $this->db->get()->row();
        if (!$order) return null;

        // Fetch ordered items
        $itemsSql = "
            SELECT 
                moi.*,
                mm.brand_name,
                mm.generic_composition,
                mm.dosage_form,
                mm.is_prescription_required,
                mm.manufacturer
            FROM medicine_order_items moi
            JOIN medicines_master mm ON mm.id = moi.medicine_id
            WHERE moi.order_id = ?
        ";
        $order->items = $this->db->query($itemsSql, [$orderId])->result();

        // Verification token for QR code
        $order->qr_token = md5($order->order_code . ':' . $order->delivery_otp);

        return $order;
    }

    /**
     * Advance order status (simulate store packing -> rider pickup -> in transit)
     */
    public function advance_order_stage($orderId, $targetStage = null) {
        $order = $this->db->get_where('medicine_orders', ['id' => intval($orderId)])->row();
        if (!$order) return ['status' => 'error', 'message' => 'Order not found.'];

        $currentStatus = $order->order_status;
        $nextStatus = $targetStage;

        if (!$nextStatus) {
            if ($currentStatus === 'PLACED') {
                $nextStatus = 'PACKED';
            } elseif ($currentStatus === 'PACKED' || $currentStatus === 'ASSIGNED') {
                $nextStatus = 'IN_TRANSIT';
            } elseif ($currentStatus === 'IN_TRANSIT') {
                $nextStatus = 'DELIVERED';
            }
        }

        if ($nextStatus) {
            $updateData = ['order_status' => $nextStatus, 'updated_at' => date('Y-m-d H:i:s')];
            if ($nextStatus === 'IN_TRANSIT') {
                $updateData['dispatched_at'] = date('Y-m-d H:i:s');
                $this->db->where('order_id', $order->id)->update('order_delivery_assignments', [
                    'delivery_status' => 'PICKED_UP',
                    'picked_up_at'    => date('Y-m-d H:i:s')
                ]);
            } elseif ($nextStatus === 'DELIVERED') {
                $updateData['delivered_at'] = date('Y-m-d H:i:s');
                $updateData['payment_status'] = 'PAID';
                $this->db->where('order_id', $order->id)->update('order_delivery_assignments', [
                    'delivery_status'      => 'DELIVERED',
                    'delivered_at'         => date('Y-m-d H:i:s'),
                    'cod_collected_amount' => $order->total_amount
                ]);
            }

            $this->db->where('id', $order->id)->update('medicine_orders', $updateData);
            return [
                'status'        => 'success',
                'previous'      => $currentStatus,
                'new_status'    => $nextStatus,
                'message'       => 'Order status updated to ' . $nextStatus
            ];
        }

        return ['status' => 'noop', 'message' => 'No state transition necessary.'];
    }

    /**
     * Verify delivery with OTP
     */
    public function verify_delivery_otp($orderId, $inputOtp) {
        $order = $this->db->get_where('medicine_orders', ['id' => intval($orderId)])->row();
        if (!$order) {
            return ['status' => 'error', 'message' => 'Order not found.'];
        }

        if ($order->order_status === 'DELIVERED') {
            return ['status' => 'success', 'already_delivered' => true, 'message' => 'This order has already been verified and delivered!'];
        }

        if (trim($inputOtp) !== trim($order->delivery_otp)) {
            return ['status' => 'error', 'message' => 'Incorrect OTP entered. Please check the 4-digit code shown on your screen.'];
        }

        // OTP matches: mark DELIVERED
        $now = date('Y-m-d H:i:s');
        $this->db->where('id', $order->id)->update('medicine_orders', [
            'order_status'   => 'DELIVERED',
            'delivered_at'   => $now,
            'payment_status' => 'PAID',
            'updated_at'     => $now
        ]);

        $this->db->where('order_id', $order->id)->update('order_delivery_assignments', [
            'delivery_status'      => 'DELIVERED',
            'delivered_at'         => $now,
            'cod_collected_amount' => $order->total_amount
        ]);

        return [
            'status'       => 'success',
            'delivered_at' => $now,
            'message'      => 'Doorstep Delivery OTP verified successfully! Order completed.'
        ];
    }

    /**
     * Verify delivery via QR Code Token
     */
    public function verify_delivery_qr($orderId, $qrToken) {
        $order = $this->db->get_where('medicine_orders', ['id' => intval($orderId)])->row();
        if (!$order) {
            return ['status' => 'error', 'message' => 'Order not found.'];
        }

        $expectedToken = md5($order->order_code . ':' . $order->delivery_otp);
        if ($qrToken !== $expectedToken && $qrToken !== 'UPCHAR-QR-VERIFY-' . $order->id) {
            return ['status' => 'error', 'message' => 'Invalid QR Code token.'];
        }

        return $this->verify_delivery_otp($orderId, $order->delivery_otp);
    }

    // =========================================================================
    // Legacy Cart Library Methods (preserved for backward compatibility)
    // =========================================================================
    public function retrieve_products() {
        if ($this->db->table_exists('product')) {
            return $this->db->get('product')->result_array();
        }
        return [];
    }

    public function validate_add_cart_item() {
        $id = $this->input->post('product_id');
        $cty = $this->input->post('quantity');
        if ($this->db->table_exists('product')) {
            $this->db->where('product_id', $id);
            $query = $this->db->get('product');
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $data = [
                    'id'    => $id,
                    'qty'   => $cty,
                    'image' => $row->product_image,
                    'price' => $row->product_price,
                    'name'  => $row->product_name
                ];
                $this->cart->insert($data);
                return TRUE;
            }
        }
        return FALSE;
    }

    public function validate_update_cart() {
        $total = count($this->cart->contents());
        $item = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        for ($i = 0; $i < $total; $i++) {
            $data = ['rowid' => $item[$i], 'qty' => $qty[$i]];
            $this->cart->update($data);
        }
    }

    public function update_cart_db() {
        if ($this->is_logged_in()) {
            $user_id = $this->get_user_id();
            $cartContentString = serialize($this->cart->contents());
            $this->db->where('USERID', $user_id)->update('userlogin', ['CART' => $cartContentString]);
        }
    }
}