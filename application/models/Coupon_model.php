<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_schema();
    }

    /**
     * Self-healing migration for coupons & usage tables
     */
    public function ensure_schema() {
        if (!$this->db->table_exists('coupons')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `coupons` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `coupon_code` VARCHAR(50) NOT NULL,
                    `title` VARCHAR(255) NOT NULL,
                    `description` TEXT,
                    `discount_type` ENUM('PERCENTAGE', 'FLAT') NOT NULL DEFAULT 'PERCENTAGE',
                    `discount_value` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                    `max_discount` DECIMAL(10,2) DEFAULT NULL,
                    `min_order_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                    `service_type` VARCHAR(50) NOT NULL DEFAULT 'ALL',
                    `usage_limit` INT(11) DEFAULT NULL,
                    `usage_limit_per_user` INT(11) NOT NULL DEFAULT 1,
                    `valid_from` DATETIME DEFAULT NULL,
                    `valid_to` DATETIME DEFAULT NULL,
                    `status` TINYINT(1) NOT NULL DEFAULT 1,
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `uk_coupon_code` (`coupon_code`),
                    KEY `idx_coupon_status` (`status`, `service_type`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }

        if (!$this->db->table_exists('coupon_usages')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `coupon_usages` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `coupon_id` INT(11) NOT NULL,
                    `user_id` INT(11) NOT NULL,
                    `order_ref` VARCHAR(100) DEFAULT NULL,
                    `service_type` VARCHAR(50) NOT NULL DEFAULT 'ALL',
                    `order_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                    `discount_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                    `used_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_usage_coupon_user` (`coupon_id`, `user_id`),
                    KEY `idx_usage_order` (`order_ref`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }

        // Seed default starter promo coupons if empty
        $count = $this->db->count_all('coupons');
        if ($count == 0) {
            $starter_coupons = [
                [
                    'coupon_code'          => 'UPCHAR10',
                    'title'                => '10% Off All Services',
                    'description'          => 'Enjoy 10% instant discount across OPD consultations, lab tests & pharmacy.',
                    'discount_type'        => 'PERCENTAGE',
                    'discount_value'       => 10.00,
                    'max_discount'         => 150.00,
                    'min_order_amount'     => 100.00,
                    'service_type'         => 'ALL',
                    'usage_limit_per_user' => 5,
                    'status'               => 1,
                    'created_at'           => date('Y-m-d H:i:s')
                ],
                [
                    'coupon_code'          => 'HEALTH50',
                    'title'                => 'Flat ₹50 Cashback & Discount',
                    'description'          => 'Flat ₹50 off on orders & bookings above ₹200.',
                    'discount_type'        => 'FLAT',
                    'discount_value'       => 50.00,
                    'max_discount'         => 50.00,
                    'min_order_amount'     => 200.00,
                    'service_type'         => 'ALL',
                    'usage_limit_per_user' => 3,
                    'status'               => 1,
                    'created_at'           => date('Y-m-d H:i:s')
                ],
                [
                    'coupon_code'          => 'DOC15',
                    'title'                => '15% Off Doctor Consultation',
                    'description'          => 'Get 15% discount on in-clinic and hospital OPD doctor consultations.',
                    'discount_type'        => 'PERCENTAGE',
                    'discount_value'       => 15.00,
                    'max_discount'         => 200.00,
                    'min_order_amount'     => 150.00,
                    'service_type'         => 'APPOINTMENT',
                    'usage_limit_per_user' => 2,
                    'status'               => 1,
                    'created_at'           => date('Y-m-d H:i:s')
                ],
                [
                    'coupon_code'          => 'LABCARE20',
                    'title'                => '20% Off Pathology & Diagnostics',
                    'description'          => 'Special 20% savings on full body checkups & pathology lab tests.',
                    'discount_type'        => 'PERCENTAGE',
                    'discount_value'       => 20.00,
                    'max_discount'         => 350.00,
                    'min_order_amount'     => 250.00,
                    'service_type'         => 'LAB_TEST',
                    'usage_limit_per_user' => 3,
                    'status'               => 1,
                    'created_at'           => date('Y-m-d H:i:s')
                ],
                [
                    'coupon_code'          => 'MED10',
                    'title'                => '10% Off Pharmacy Medicines',
                    'description'          => 'Save 10% on essential medicines and healthcare wellness items.',
                    'discount_type'        => 'PERCENTAGE',
                    'discount_value'       => 10.00,
                    'max_discount'         => 200.00,
                    'min_order_amount'     => 200.00,
                    'service_type'         => 'MEDICINE',
                    'usage_limit_per_user' => 5,
                    'status'               => 1,
                    'created_at'           => date('Y-m-d H:i:s')
                ]
            ];
            $this->db->insert_batch('coupons', $starter_coupons);
        }
    }

    /**
     * Validate a coupon code for given user and service
     * 
     * @param string $code
     * @param int|null $userId
     * @param string $serviceType (ALL, APPOINTMENT, LAB_TEST, MEDICINE)
     * @param float $orderAmount
     * @return array
     */
    public function validate_coupon($code, $userId = null, $serviceType = 'ALL', $orderAmount = 0.00) {
        $code = strtoupper(trim($code));
        if (empty($code)) {
            return ['valid' => false, 'message' => 'Please enter a coupon code.'];
        }

        $coupon = $this->db->get_where('coupons', ['coupon_code' => $code, 'status' => 1])->row();
        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid or expired coupon code: ' . htmlspecialchars($code)];
        }

        // Check date validity
        $now = date('Y-m-d H:i:s');
        if (!empty($coupon->valid_from) && $coupon->valid_from > $now) {
            return ['valid' => false, 'message' => 'This coupon is not active yet.'];
        }
        if (!empty($coupon->valid_to) && $coupon->valid_to < $now) {
            return ['valid' => false, 'message' => 'This coupon code has expired.'];
        }

        // Check service type scope
        $couponService = strtoupper($coupon->service_type);
        $requestService = strtoupper($serviceType);
        if ($couponService !== 'ALL' && $requestService !== 'ALL' && $couponService !== $requestService) {
            $allowedLabel = ($couponService === 'APPOINTMENT') ? 'Doctor Appointments' : (($couponService === 'LAB_TEST') ? 'Diagnostic Lab Tests' : 'Pharmacy Orders');
            return ['valid' => false, 'message' => "Coupon '{$code}' is only valid on {$allowedLabel}."];
        }

        // Check minimum order amount
        $orderAmount = floatval($orderAmount);
        $minAmount = floatval($coupon->min_order_amount);
        if ($orderAmount < $minAmount) {
            return ['valid' => false, 'message' => "Minimum order amount of ₹" . number_format($minAmount, 2) . " required for this coupon."];
        }

        // Check global usage limit
        if (!empty($coupon->usage_limit)) {
            $totalUsed = $this->db->where('coupon_id', $coupon->id)->count_all_results('coupon_usages');
            if ($totalUsed >= $coupon->usage_limit) {
                return ['valid' => false, 'message' => 'This coupon has reached its maximum global usage limit.'];
            }
        }

        // Check per-user usage limit
        if ($userId && !empty($coupon->usage_limit_per_user)) {
            $userUsed = $this->db->where(['coupon_id' => $coupon->id, 'user_id' => $userId])->count_all_results('coupon_usages');
            if ($userUsed >= $coupon->usage_limit_per_user) {
                return ['valid' => false, 'message' => "You have already used this coupon code the maximum allowed number of times ({$coupon->usage_limit_per_user})."];
            }
        }

        // Calculate discount
        $discount = 0.00;
        if ($coupon->discount_type === 'PERCENTAGE') {
            $pct = floatval($coupon->discount_value);
            $rawDiscount = ($orderAmount * $pct) / 100.0;
            if (!empty($coupon->max_discount) && floatval($coupon->max_discount) > 0) {
                $discount = min($rawDiscount, floatval($coupon->max_discount));
            } else {
                $discount = $rawDiscount;
            }
        } else {
            // FLAT discount
            $flat = floatval($coupon->discount_value);
            $discount = min($flat, $orderAmount);
        }

        $discount = round($discount, 2);
        $netPayable = max(0.00, round($orderAmount - $discount, 2));

        return [
            'valid'           => true,
            'coupon'          => $coupon,
            'coupon_id'       => $coupon->id,
            'coupon_code'     => $coupon->coupon_code,
            'discount_amount' => $discount,
            'net_amount'      => $netPayable,
            'title'           => $coupon->title,
            'message'         => "Coupon '{$coupon->coupon_code}' applied! You saved ₹" . number_format($discount, 2) . "."
        ];
    }

    /**
     * Record coupon usage after successful booking or payment
     */
    public function record_usage($couponId, $userId, $orderRef, $serviceType = 'ALL', $orderAmount = 0.00, $discountAmount = 0.00) {
        if (!$couponId || !$userId) return false;

        $data = [
            'coupon_id'       => $couponId,
            'user_id'         => $userId,
            'order_ref'       => $orderRef,
            'service_type'    => $serviceType,
            'order_amount'    => floatval($orderAmount),
            'discount_amount' => floatval($discountAmount),
            'used_at'         => date('Y-m-d H:i:s')
        ];

        return $this->db->insert('coupon_usages', $data);
    }

    /**
     * Get active coupons applicable for a service type
     */
    public function get_available_coupons($serviceType = 'ALL', $userId = null) {
        $this->db->where('status', 1);
        if ($serviceType !== 'ALL') {
            $this->db->group_start()
                     ->where('service_type', 'ALL')
                     ->or_where('service_type', $serviceType)
                     ->group_end();
        }

        $now = date('Y-m-d H:i:s');
        $this->db->group_start()
                 ->where('valid_from IS NULL', null, false)
                 ->or_where('valid_from <=', $now)
                 ->group_end();
        $this->db->group_start()
                 ->where('valid_to IS NULL', null, false)
                 ->or_where('valid_to >=', $now)
                 ->group_end();

        $this->db->order_by('discount_value', 'DESC');
        $coupons = $this->db->get('coupons')->result();

        // Optional filter out coupons user has already exhausted
        if ($userId && !empty($coupons)) {
            $filtered = [];
            foreach ($coupons as $c) {
                if (!empty($c->usage_limit_per_user)) {
                    $used = $this->db->where(['coupon_id' => $c->id, 'user_id' => $userId])->count_all_results('coupon_usages');
                    if ($used >= $c->usage_limit_per_user) {
                        continue;
                    }
                }
                $filtered[] = $c;
            }
            return $filtered;
        }

        return $coupons;
    }
}
