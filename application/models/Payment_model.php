<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payment Model
 * UPCHAR Healthcare SaaS Unified Payment Engine
 */
class Payment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set("Asia/Kolkata");
        $this->_ensure_tables();
    }

    /**
     * Ensure all required payment tables exist (Additive & Non-destructive)
     */
    public function _ensure_tables() {
        // 1. razorpay_orders
        $this->db->query("CREATE TABLE IF NOT EXISTS `razorpay_orders` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `internal_order_ref` varchar(60) NOT NULL,
            `razorpay_order_id` varchar(50) NOT NULL,
            `razorpay_payment_id` varchar(50) DEFAULT NULL,
            `user_id` int(11) NOT NULL,
            `amount` decimal(10,2) NOT NULL,
            `currency` varchar(5) NOT NULL DEFAULT 'INR',
            `purpose` enum('APPOINTMENT','LAB_TEST','MEDICART','WALLET_RECHARGE') NOT NULL,
            `reference_id` varchar(50) DEFAULT NULL,
            `wallet_points_used` decimal(10,2) NOT NULL DEFAULT 0.00,
            `wallet_amount_used` decimal(10,2) NOT NULL DEFAULT 0.00,
            `gateway_amount` decimal(10,2) NOT NULL,
            `signature_verified` tinyint(1) NOT NULL DEFAULT 0,
            `status` enum('CREATED','ATTEMPTED','PAID','FAILED','REFUNDED') NOT NULL DEFAULT 'CREATED',
            `webhook_received_at` datetime DEFAULT NULL,
            `error_reason` varchar(255) DEFAULT NULL,
            `metadata_json` text DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_internal_ref` (`internal_order_ref`),
            KEY `idx_rzp_order` (`razorpay_order_id`),
            KEY `idx_user_orders` (`user_id`, `status`),
            KEY `idx_purpose_ref` (`purpose`, `reference_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 2. payment_webhook_log
        $this->db->query("CREATE TABLE IF NOT EXISTS `payment_webhook_log` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `gateway` enum('RAZORPAY','CCAVENUE','MANUAL') NOT NULL,
            `event_type` varchar(60) NOT NULL,
            `payload` mediumtext NOT NULL,
            `signature_valid` tinyint(1) NOT NULL DEFAULT 0,
            `processed` tinyint(1) NOT NULL DEFAULT 0,
            `processing_notes` text DEFAULT NULL,
            `received_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_processed` (`gateway`, `processed`),
            KEY `idx_event` (`event_type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 3. user_referrals
        $this->db->query("CREATE TABLE IF NOT EXISTS `user_referrals` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `referrer_user_id` int(11) NOT NULL,
            `referee_user_id` int(11) NOT NULL,
            `referral_code` varchar(30) NOT NULL,
            `points_given_referrer` decimal(10,2) NOT NULL DEFAULT 0.00,
            `points_given_referee` decimal(10,2) NOT NULL DEFAULT 0.00,
            `status` enum('PENDING','COMPLETED') NOT NULL DEFAULT 'PENDING',
            `created_at` datetime NOT NULL,
            `completed_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_referrer` (`referrer_user_id`),
            KEY `idx_referee` (`referee_user_id`),
            KEY `idx_referral_code` (`referral_code`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 4. payment_refunds
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

        // 5. facility_payout_accounts
        $this->db->query("CREATE TABLE IF NOT EXISTS `facility_payout_accounts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `facility_type` enum('doctor','hospital','clinic','pathlab') NOT NULL,
            `facility_id` int(11) NOT NULL,
            `account_type` enum('BANK_ACCOUNT','VPA') NOT NULL,
            `account_name` varchar(100) NOT NULL,
            `account_number` varchar(30) DEFAULT NULL,
            `ifsc_code` varchar(15) DEFAULT NULL,
            `bank_name` varchar(100) DEFAULT NULL,
            `vpa` varchar(100) DEFAULT NULL,
            `razorpayx_contact_id` varchar(50) DEFAULT NULL,
            `razorpayx_fund_account_id` varchar(50) DEFAULT NULL,
            `is_verified` tinyint(1) NOT NULL DEFAULT 0,
            `is_active` tinyint(1) NOT NULL DEFAULT 1,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_facility` (`facility_type`, `facility_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 6. payout_batches
        $this->db->query("CREATE TABLE IF NOT EXISTS `payout_batches` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `batch_ref` varchar(50) NOT NULL,
            `batch_date` date NOT NULL,
            `total_facilities` int(11) NOT NULL DEFAULT 0,
            `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
            `successful_payouts` int(11) NOT NULL DEFAULT 0,
            `failed_payouts` int(11) NOT NULL DEFAULT 0,
            `status` enum('DRAFT','PROCESSING','COMPLETED','PARTIAL') NOT NULL DEFAULT 'DRAFT',
            `triggered_by_admin_id` int(11) DEFAULT NULL,
            `notes` text DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `completed_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_batch_ref` (`batch_ref`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 7. financial_ledger (Double-entry immutable audit records)
        $this->db->query("CREATE TABLE IF NOT EXISTS `financial_ledger` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `transaction_ref` varchar(64) NOT NULL,
            `order_id` varchar(60) DEFAULT NULL,
            `payer_type` enum('PATIENT','PLATFORM','TENANT') NOT NULL,
            `payer_id` int(11) NOT NULL,
            `payee_type` enum('PLATFORM','DOCTOR','HOSPITAL','PATHLAB') NOT NULL,
            `payee_id` int(11) NOT NULL,
            `gross_amount` decimal(10,2) NOT NULL,
            `platform_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
            `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
            `net_payout` decimal(10,2) NOT NULL,
            `currency` varchar(3) NOT NULL DEFAULT 'INR',
            `escrow_status` enum('HELD','RELEASED','REFUNDED','DISPUTED') NOT NULL DEFAULT 'HELD',
            `payout_batch_id` varchar(64) DEFAULT NULL,
            `payout_status` enum('UNPROCESSED','QUEUED','PROCESSED','FAILED') NOT NULL DEFAULT 'UNPROCESSED',
            `gateway_payment_id` varchar(100) DEFAULT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_txn_ledger_ref` (`transaction_ref`),
            KEY `idx_payee_payout` (`payee_type`, `payee_id`, `payout_status`),
            KEY `idx_order_ledger` (`order_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    /**
     * Generate unique internal order reference (UPCH-ORD-YYYYMMDD-XXXXX)
     */
    public function generate_order_ref() {
        return 'UPCH-ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    }

    /**
     * Create order record
     */
    public function create_razorpay_order($data) {
        $insert = array(
            'internal_order_ref' => $data['internal_order_ref'],
            'razorpay_order_id'  => $data['razorpay_order_id'],
            'user_id'            => intval($data['user_id']),
            'amount'             => floatval($data['amount']),
            'currency'           => isset($data['currency']) ? $data['currency'] : 'INR',
            'purpose'            => $data['purpose'],
            'reference_id'       => isset($data['reference_id']) ? $data['reference_id'] : null,
            'wallet_points_used' => isset($data['wallet_points_used']) ? floatval($data['wallet_points_used']) : 0.00,
            'wallet_amount_used' => isset($data['wallet_amount_used']) ? floatval($data['wallet_amount_used']) : 0.00,
            'gateway_amount'     => floatval($data['gateway_amount']),
            'signature_verified' => 0,
            'status'             => 'CREATED',
            'metadata_json'      => isset($data['metadata_json']) ? json_encode($data['metadata_json']) : null,
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s')
        );
        $this->db->insert('razorpay_orders', $insert);
        return $this->db->insert_id();
    }

    /**
     * Update order status
     */
    public function update_order_status($internal_ref, $status, $payment_id = null, $extra = array()) {
        $update = array(
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s')
        );
        if ($payment_id) {
            $update['razorpay_payment_id'] = $payment_id;
            $update['signature_verified']  = 1;
        }
        if (isset($extra['error_reason'])) {
            $update['error_reason'] = $extra['error_reason'];
        }
        if (isset($extra['webhook_received_at'])) {
            $update['webhook_received_at'] = $extra['webhook_received_at'];
        }

        $this->db->where('internal_order_ref', $internal_ref);
        return $this->db->update('razorpay_orders', $update);
    }

    /**
     * Get order by internal reference, gateway reference, appointment ref_no, or wallet txn_ref
     */
    public function get_order_by_ref($internal_ref) {
        $internal_ref = trim($internal_ref);
        if (empty($internal_ref)) {
            return null;
        }

        // 1. Direct match on razorpay_orders by internal_order_ref
        $order = $this->db->get_where('razorpay_orders', array('internal_order_ref' => $internal_ref))->row_array();
        if ($order) {
            return $order;
        }

        // 1b. Match razorpay_orders by razorpay_payment_id or razorpay_order_id
        $order = $this->db->where('razorpay_payment_id', $internal_ref)
                          ->or_where('razorpay_order_id', $internal_ref)
                          ->get('razorpay_orders')
                          ->row_array();
        if ($order) {
            return $order;
        }

        // 2. Check if reference is formatted like APPT-123 or APPT_123
        if (stripos($internal_ref, 'APPT-') === 0 || stripos($internal_ref, 'APPT_') === 0) {
            $ref_id = preg_replace('/[^0-9]/', '', $internal_ref);
            if ($ref_id) {
                $order = $this->db->where('purpose', 'APPOINTMENT')
                                  ->where('reference_id', $ref_id)
                                  ->order_by('id', 'DESC')
                                  ->get('razorpay_orders')
                                  ->row_array();
                if ($order) return $order;

                $app = $this->db->get_where('appointment', array('appointment_id' => $ref_id))->row_array();
                if ($app) {
                    return $this->_synthesize_order_from_appointment($app);
                }
            }
        }

        // 3. Check if reference is formatted like LAB-123 or BOOK-123
        if (stripos($internal_ref, 'LAB-') === 0 || stripos($internal_ref, 'BOOK-') === 0) {
            $ref_id = preg_replace('/[^0-9]/', '', $internal_ref);
            if ($ref_id) {
                $order = $this->db->where('purpose', 'LAB_TEST')
                                  ->where('reference_id', $ref_id)
                                  ->order_by('id', 'DESC')
                                  ->get('razorpay_orders')
                                  ->row_array();
                if ($order) return $order;

                $lb = $this->db->get_where('path_book', array('booking_id' => $ref_id))->row_array();
                if ($lb) {
                    return $this->_synthesize_order_from_lab_booking($lb);
                }
            }
        }

        // 4. Check appointment by ref_no (e.g. TXN-UP-... or custom ref)
        $app = $this->db->get_where('appointment', array('ref_no' => $internal_ref))->row_array();
        if ($app) {
            $order = $this->db->where('purpose', 'APPOINTMENT')
                              ->where('reference_id', $app['appointment_id'])
                              ->order_by('id', 'DESC')
                              ->get('razorpay_orders')
                              ->row_array();
            if ($order) return $order;
            return $this->_synthesize_order_from_appointment($app);
        }

        // 5. Check path_book by ref_no
        $lb = $this->db->get_where('path_book', array('ref_no' => $internal_ref))->row_array();
        if ($lb) {
            $order = $this->db->where('purpose', 'LAB_TEST')
                              ->where('reference_id', $lb['booking_id'])
                              ->order_by('id', 'DESC')
                              ->get('razorpay_orders')
                              ->row_array();
            if ($order) return $order;
            return $this->_synthesize_order_from_lab_booking($lb);
        }

        // 6. Check wallet_transactions by txn_ref (e.g. TXN-UP-...)
        $txn = $this->db->get_where('wallet_transactions', array('txn_ref' => $internal_ref))->row_array();
        if ($txn) {
            if ($txn['source'] === 'APPOINTMENT_PAYMENT' && !empty($txn['reference_id'])) {
                $app = $this->db->get_where('appointment', array('appointment_id' => $txn['reference_id']))->row_array();
                if ($app) {
                    $order = $this->db->where('purpose', 'APPOINTMENT')
                                      ->where('reference_id', $app['appointment_id'])
                                      ->order_by('id', 'DESC')
                                      ->get('razorpay_orders')
                                      ->row_array();
                    if ($order) return $order;
                    return $this->_synthesize_order_from_appointment($app, $txn);
                }
            } elseif ($txn['source'] === 'LAB_TEST_PAYMENT' && !empty($txn['reference_id'])) {
                $lb = $this->db->get_where('path_book', array('booking_id' => $txn['reference_id']))->row_array();
                if ($lb) {
                    $order = $this->db->where('purpose', 'LAB_TEST')
                                      ->where('reference_id', $lb['booking_id'])
                                      ->order_by('id', 'DESC')
                                      ->get('razorpay_orders')
                                      ->row_array();
                    if ($order) return $order;
                    return $this->_synthesize_order_from_lab_booking($lb, $txn);
                }
            }

            // General Wallet recharge / debit transaction
            return array(
                'id'                  => $txn['transaction_id'],
                'internal_order_ref'  => $txn['txn_ref'],
                'razorpay_order_id'   => $txn['gateway_txn_id'] ?: $txn['txn_ref'],
                'razorpay_payment_id' => $txn['gateway_txn_id'] ?: $txn['txn_ref'],
                'user_id'             => $txn['user_id'],
                'amount'              => floatval($txn['amount_money']),
                'currency'            => 'INR',
                'purpose'             => ($txn['type'] === 'CREDIT') ? 'WALLET_RECHARGE' : 'WALLET_TRANSACTION',
                'reference_id'        => $txn['reference_id'] ?: $txn['transaction_id'],
                'wallet_points_used'  => ($txn['type'] === 'DEBIT') ? floatval($txn['amount_points']) : 0.00,
                'wallet_amount_used'  => ($txn['type'] === 'DEBIT') ? floatval($txn['amount_money']) : 0.00,
                'gateway_amount'      => ($txn['type'] === 'CREDIT' && $txn['payment_gateway'] !== 'WALLET') ? floatval($txn['amount_money']) : 0.00,
                'signature_verified'  => 1,
                'status'              => ($txn['status'] === 'SUCCESS') ? 'PAID' : 'FAILED',
                'metadata_json'       => json_encode(array('description' => $txn['description'], 'source' => $txn['source'])),
                'created_at'          => $txn['created_at'],
                'updated_at'          => $txn['created_at']
            );
        }

        // 7. Numeric lookup (pure appointment ID or lab booking ID)
        if (is_numeric($internal_ref)) {
            $num_id = intval($internal_ref);
            $app = $this->db->get_where('appointment', array('appointment_id' => $num_id))->row_array();
            if ($app) {
                return $this->_synthesize_order_from_appointment($app);
            }
            $lb = $this->db->get_where('path_book', array('booking_id' => $num_id))->row_array();
            if ($lb) {
                return $this->_synthesize_order_from_lab_booking($lb);
            }
        }

        return null;
    }

    /**
     * Synthesize a standardized order structure from an appointment record
     */
    public function _synthesize_order_from_appointment($app, $txn = null) {
        $amount = floatval(!empty($app['amount']) ? $app['amount'] : (!empty($app['fee']) ? $app['fee'] : 0));
        $is_wallet = ($app['payment_mode'] === 'UPCHAR_POI' || $app['payment_mode'] === 'WALLET');
        $wallet_used = $txn ? floatval($txn['amount_money']) : ($is_wallet ? $amount : 0.00);
        $points_used = $txn ? floatval($txn['amount_points']) : ($is_wallet ? $amount : 0.00);
        $gateway_amt = $is_wallet ? 0.00 : $amount;

        $order_status = 'PAID';
        if ($app['status'] == '2' || $app['appointment_status'] == '2' || $app['payment_status'] === 'REFUNDED') {
            $order_status = 'REFUNDED';
        }

        return array(
            'id'                  => intval($app['appointment_id']),
            'internal_order_ref'  => !empty($app['ref_no']) ? $app['ref_no'] : ('UPCH-APPT-' . $app['appointment_id']),
            'razorpay_order_id'   => !empty($app['ref_no']) ? $app['ref_no'] : '',
            'razorpay_payment_id' => !empty($app['ref_no']) ? $app['ref_no'] : '',
            'user_id'             => intval($app['user_id']),
            'amount'              => $amount,
            'currency'            => 'INR',
            'purpose'             => 'APPOINTMENT',
            'reference_id'        => strval($app['appointment_id']),
            'wallet_points_used'  => $points_used,
            'wallet_amount_used'  => $wallet_used,
            'gateway_amount'      => $gateway_amt,
            'signature_verified'  => 1,
            'status'              => $order_status,
            'metadata_json'       => json_encode(array(
                'payment_mode'     => $app['payment_mode'],
                'doctor_id'        => $app['doctor_id'],
                'appointment_date' => $app['appointment_date']
            )),
            'created_at'          => !empty($app['book_date']) ? $app['book_date'] : (!empty($app['pay_date']) ? $app['pay_date'] : date('Y-m-d H:i:s')),
            'updated_at'          => !empty($app['pay_date']) ? $app['pay_date'] : (!empty($app['book_date']) ? $app['book_date'] : date('Y-m-d H:i:s'))
        );
    }

    /**
     * Synthesize a standardized order structure from a lab booking record
     */
    public function _synthesize_order_from_lab_booking($lb, $txn = null) {
        $amount = floatval(!empty($lb['total_amount']) ? $lb['total_amount'] : (!empty($lb['paid_amount']) ? $lb['paid_amount'] : 0));
        $is_wallet = (isset($lb['payment_method']) && ($lb['payment_method'] === 'WALLET' || $lb['payment_method'] === 'UPCHAR_POINTS'));
        $wallet_used = $txn ? floatval($txn['amount_money']) : ($is_wallet ? $amount : 0.00);
        $points_used = $txn ? floatval($txn['amount_points']) : ($is_wallet ? $amount : 0.00);
        $gateway_amt = $is_wallet ? 0.00 : $amount;

        $order_status = 'PAID';
        if ($lb['status'] == '2' || $lb['order_stage'] === 'CANCELLED' || (isset($lb['payment_status']) && $lb['payment_status'] === 'REFUNDED')) {
            $order_status = 'REFUNDED';
        }

        return array(
            'id'                  => intval($lb['booking_id']),
            'internal_order_ref'  => !empty($lb['ref_no']) ? $lb['ref_no'] : (!empty($lb['booking_ref']) ? $lb['booking_ref'] : ('UPCH-LAB-' . $lb['booking_id'])),
            'razorpay_order_id'   => !empty($lb['ref_no']) ? $lb['ref_no'] : '',
            'razorpay_payment_id' => !empty($lb['ref_no']) ? $lb['ref_no'] : '',
            'user_id'             => intval($lb['user_id']),
            'amount'              => $amount,
            'currency'            => 'INR',
            'purpose'             => 'LAB_TEST',
            'reference_id'        => strval($lb['booking_id']),
            'wallet_points_used'  => $points_used,
            'wallet_amount_used'  => $wallet_used,
            'gateway_amount'      => $gateway_amt,
            'signature_verified'  => 1,
            'status'              => $order_status,
            'metadata_json'       => json_encode(array(
                'pathlab_id'   => $lb['pathlab_id'],
                'booking_date' => $lb['booking_date']
            )),
            'created_at'          => !empty($lb['created_at']) ? $lb['created_at'] : date('Y-m-d H:i:s'),
            'updated_at'          => !empty($lb['updated_at']) ? $lb['updated_at'] : date('Y-m-d H:i:s')
        );
    }

    /**
     * Get order by Razorpay Order ID
     */
    public function get_order_by_razorpay_id($razorpay_order_id) {
        return $this->db->get_where('razorpay_orders', array('razorpay_order_id' => $razorpay_order_id))->row_array();
    }

    /**
     * Get user order history
     */
    public function get_orders_by_user($user_id, $limit = 20, $offset = 0) {
        $this->db->from('razorpay_orders');
        $this->db->where('user_id', intval($user_id));
        $this->db->order_by('id', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    /**
     * Log Webhook Request
     */
    public function log_webhook($gateway, $event_type, $payload, $sig_valid) {
        $data = array(
            'gateway'         => $gateway,
            'event_type'      => $event_type,
            'payload'         => is_string($payload) ? $payload : json_encode($payload),
            'signature_valid' => $sig_valid ? 1 : 0,
            'processed'       => 0,
            'received_at'     => date('Y-m-d H:i:s')
        );
        $this->db->insert('payment_webhook_log', $data);
        return $this->db->insert_id();
    }

    /**
     * Mark webhook processed
     */
    public function mark_webhook_processed($id, $notes = '') {
        $this->db->where('id', intval($id));
        return $this->db->update('payment_webhook_log', array(
            'processed'        => 1,
            'processing_notes' => $notes
        ));
    }

    /**
     * Check if duplicate webhook event has been recorded
     */
    public function is_webhook_duplicate($gateway, $event_type, $payment_id) {
        if (empty($payment_id)) return false;
        $this->db->from('payment_webhook_log');
        $this->db->where('gateway', $gateway);
        $this->db->where('event_type', $event_type);
        $this->db->like('payload', $payment_id);
        $this->db->where('processed', 1);
        return ($this->db->count_all_results() > 0);
    }

    /**
     * Record Entry into Double-Entry Financial Ledger
     */
    public function record_ledger_entry($data) {
        $txn_ref = 'TXN-LEDGER-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        $insert = array(
            'transaction_ref'    => $txn_ref,
            'order_id'           => isset($data['order_id']) ? $data['order_id'] : null,
            'payer_type'         => isset($data['payer_type']) ? $data['payer_type'] : 'PATIENT',
            'payer_id'           => intval($data['payer_id']),
            'payee_type'         => $data['payee_type'], // DOCTOR, HOSPITAL, PATHLAB, PLATFORM
            'payee_id'           => intval($data['payee_id']),
            'gross_amount'       => floatval($data['gross_amount']),
            'platform_fee'       => floatval($data['platform_fee']),
            'tax_amount'         => floatval($data['tax_amount']),
            'net_payout'         => floatval($data['net_payout']),
            'currency'           => 'INR',
            'escrow_status'      => isset($data['escrow_status']) ? $data['escrow_status'] : 'HELD',
            'payout_status'      => 'UNPROCESSED',
            'gateway_payment_id' => isset($data['gateway_payment_id']) ? $data['gateway_payment_id'] : null,
            'created_at'         => date('Y-m-d H:i:s')
        );
        $this->db->insert('financial_ledger', $insert);
        return $txn_ref;
    }

    /**
     * Fetch payment statistics for Admin / Dashboard
     */
    public function get_payment_summary() {
        $today = date('Y-m-d');
        $this_month_start = date('Y-m-01 00:00:00');

        $total_paid = $this->db->select_sum('amount')->where('status', 'PAID')->get('razorpay_orders')->row()->amount ?: 0.00;
        $today_paid = $this->db->select_sum('amount')->where('status', 'PAID')->where('created_at >=', $today . ' 00:00:00')->get('razorpay_orders')->row()->amount ?: 0.00;
        $month_paid = $this->db->select_sum('amount')->where('status', 'PAID')->where('created_at >=', $this_month_start)->get('razorpay_orders')->row()->amount ?: 0.00;

        $total_count = $this->db->where('status', 'PAID')->count_all_results('razorpay_orders');
        $failed_count = $this->db->where('status', 'FAILED')->count_all_results('razorpay_orders');

        return array(
            'total_volume'   => floatval($total_paid),
            'today_volume'   => floatval($today_paid),
            'month_volume'   => floatval($month_paid),
            'success_orders' => $total_count,
            'failed_orders'  => $failed_count,
            'success_rate'   => ($total_count + $failed_count > 0) ? round(($total_count / ($total_count + $failed_count)) * 100, 1) : 100
        );
    }
}
