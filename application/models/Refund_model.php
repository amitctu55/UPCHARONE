<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Refund Model
 * UPCHAR Healthcare SaaS Refund Engine & Policy Rules
 */
class Refund_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Wallet_model');
        $this->load->model('Payment_model');
        $this->load->library('Razorpay_lib');
        date_default_timezone_set("Asia/Kolkata");
        $this->_ensure_tables();
    }

    private function _ensure_tables() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `payment_refunds` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `refund_ref` varchar(60) NOT NULL,
            `original_order_ref` varchar(60) NOT NULL,
            `razorpay_refund_id` varchar(50) DEFAULT NULL,
            `user_id` int(11) NOT NULL,
            `refund_amount` decimal(10,2) NOT NULL,
            `refund_to` enum('WALLET','GATEWAY') NOT NULL,
            `reason` text DEFAULT NULL,
            `initiated_by` enum('SYSTEM','ADMIN','PATIENT') NOT NULL DEFAULT 'SYSTEM',
            `status` enum('INITIATED','PROCESSING','COMPLETED','FAILED') NOT NULL DEFAULT 'INITIATED',
            `created_at` datetime NOT NULL,
            `completed_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_refund_ref` (`refund_ref`),
            KEY `idx_order_ref` (`original_order_ref`),
            KEY `idx_user_refunds` (`user_id`, `status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    /**
     * Calculate Refund Percentage based on time before appointment
     *
     * @param string $appointment_datetime (Y-m-d H:i:s or Y-m-d)
     * @param bool   $is_doctor_noshow
     * @return int Refund percentage (0 - 100)
     */
    public function calculate_refund_percentage($appointment_datetime, $is_doctor_noshow = false) {
        if ($is_doctor_noshow) {
            return 100; // 100% if doctor cancels or doesn't show
        }

        $app_time = strtotime($appointment_datetime);
        $now      = time();
        $diff_hrs = ($app_time - $now) / 3600;

        if ($diff_hrs >= 24) {
            return 100; // > 24 hours prior: 100% refund
        } else if ($diff_hrs >= 12 && $diff_hrs < 24) {
            return 75;  // 12 to 24 hours prior: 75% refund
        } else if ($diff_hrs > 0 && $diff_hrs < 12) {
            return 50;  // < 12 hours prior: 50% refund
        } else {
            return 0;   // Post-appointment time: 0% refund
        }
    }

    /**
     * Create and Initiate a Refund
     */
    public function create_refund($order_ref, $user_id, $amount, $refund_to = 'WALLET', $reason = '', $initiated_by = 'SYSTEM') {
        $user_id = intval($user_id);
        $amount  = floatval($amount);

        if ($user_id <= 0 || $amount <= 0 || empty($order_ref)) {
            return array('success' => false, 'message' => 'Invalid refund parameters.');
        }

        $refund_ref = 'RFD-UPCH-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));

        $data = array(
            'refund_ref'         => $refund_ref,
            'original_order_ref' => $order_ref,
            'user_id'            => $user_id,
            'refund_amount'      => $amount,
            'refund_to'          => strtoupper($refund_to), // WALLET or GATEWAY
            'reason'             => $reason ?: 'Appointment cancellation refund',
            'initiated_by'       => $initiated_by,
            'status'             => 'INITIATED',
            'created_at'         => date('Y-m-d H:i:s')
        );

        $this->db->insert('payment_refunds', $data);
        $refund_id = $this->db->insert_id();

        // Process instantly if refund_to == WALLET
        if (strtoupper($refund_to) === 'WALLET') {
            $rate = floatval($this->Wallet_model->get_setting('point_to_inr_ratio', 1.00));
            $pointsToCredit = ($rate > 0) ? ($amount / $rate) : $amount;

            $desc = 'Instant Refund for Order ' . $order_ref . ' (' . ($reason ?: 'Cancelled') . ')';
            $credit_txn = $this->Wallet_model->credit_points($user_id, $pointsToCredit, 'REFUND', $refund_ref, $desc, 'WALLET');

            if ($credit_txn) {
                $this->db->where('id', $refund_id)->update('payment_refunds', array(
                    'status'       => 'COMPLETED',
                    'completed_at' => date('Y-m-d H:i:s')
                ));
                return array(
                    'success'    => true,
                    'refund_ref' => $refund_ref,
                    'status'     => 'COMPLETED',
                    'message'    => '₹' . number_format($amount, 2) . ' (' . $pointsToCredit . ' Points) refunded instantly to your Upchar Wallet.'
                );
            }
        } else if (strtoupper($refund_to) === 'GATEWAY') {
            // Find original payment_id
            $order = $this->Payment_model->get_order_by_ref($order_ref);
            if ($order && !empty($order['razorpay_payment_id'])) {
                $rzp_res = $this->razorpay_lib->create_refund($order['razorpay_payment_id'], $amount, array('reason' => $reason));
                if (!empty($rzp_res['success'])) {
                    $rzp_refund_id = isset($rzp_res['data']['id']) ? $rzp_res['data']['id'] : null;
                    $this->db->where('id', $refund_id)->update('payment_refunds', array(
                        'razorpay_refund_id' => $rzp_refund_id,
                        'status'             => 'COMPLETED',
                        'completed_at'       => date('Y-m-d H:i:s')
                    ));
                    return array(
                        'success'    => true,
                        'refund_ref' => $refund_ref,
                        'status'     => 'COMPLETED',
                        'message'    => 'Refund of ₹' . number_format($amount, 2) . ' initiated to your bank account. It will reflect in 5-7 business days.'
                    );
                }
            }
        }

        return array(
            'success'    => true,
            'refund_ref' => $refund_ref,
            'status'     => 'PROCESSING',
            'message'    => 'Refund request submitted for verification.'
        );
    }

    /**
     * Get refund list for Admin
     */
    public function get_refunds($filters = array(), $limit = 20, $offset = 0) {
        $this->db->from('payment_refunds');
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['user_id'])) {
            $this->db->where('user_id', intval($filters['user_id']));
        }
        $this->db->order_by('id', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }
}
