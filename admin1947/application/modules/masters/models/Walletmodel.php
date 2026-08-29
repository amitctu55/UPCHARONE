<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Walletmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set("Asia/Kolkata");
        $this->_ensure_tables();
    }

    private function _ensure_tables() {
        // user_wallet
        $this->db->query("CREATE TABLE IF NOT EXISTS `user_wallet` (
            `wallet_id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `points_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
            `currency_equivalent` decimal(10,2) NOT NULL DEFAULT 0.00,
            `lifetime_earned` decimal(10,2) NOT NULL DEFAULT 0.00,
            `lifetime_spent` decimal(10,2) NOT NULL DEFAULT 0.00,
            `status` enum('1','2') NOT NULL DEFAULT '1',
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            PRIMARY KEY (`wallet_id`),
            UNIQUE KEY `uk_user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // wallet_transactions
        $this->db->query("CREATE TABLE IF NOT EXISTS `wallet_transactions` (
            `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
            `txn_ref` varchar(50) NOT NULL,
            `user_id` int(11) NOT NULL,
            `type` enum('CREDIT','DEBIT') NOT NULL,
            `amount_points` decimal(10,2) NOT NULL,
            `amount_money` decimal(10,2) NOT NULL DEFAULT 0.00,
            `balance_before` decimal(10,2) NOT NULL DEFAULT 0.00,
            `balance_after` decimal(10,2) NOT NULL DEFAULT 0.00,
            `source` varchar(50) NOT NULL,
            `reference_id` varchar(50) DEFAULT NULL,
            `payment_gateway` varchar(50) DEFAULT 'WALLET',
            `gateway_txn_id` varchar(100) DEFAULT NULL,
            `description` text DEFAULT NULL,
            `status` enum('SUCCESS','PENDING','FAILED') NOT NULL DEFAULT 'SUCCESS',
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`transaction_id`),
            UNIQUE KEY `uk_txn_ref` (`txn_ref`),
            KEY `idx_user_txn` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // points_settings
        $this->db->query("CREATE TABLE IF NOT EXISTS `points_settings` (
            `setting_id` int(11) NOT NULL AUTO_INCREMENT,
            `setting_key` varchar(50) NOT NULL,
            `setting_value` text NOT NULL,
            `description` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`setting_id`),
            UNIQUE KEY `uk_setting_key` (`setting_key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Seed default points_settings if empty
        $c = $this->db->count_all_results('points_settings');
        if ($c == 0) {
            $defaults = array(
                array('setting_key' => 'point_to_inr_ratio', 'setting_value' => '1.00', 'description' => 'Value of 1 Upchar Point in INR (e.g. 1.00 = Rs 1)'),
                array('setting_key' => 'signup_bonus_points', 'setting_value' => '50.00', 'description' => 'Free points awarded to new users upon account registration'),
                array('setting_key' => 'cashback_percentage', 'setting_value' => '5.00', 'description' => 'Cashback percentage in points earned on completed appointments'),
                array('setting_key' => 'min_recharge_amount', 'setting_value' => '100.00', 'description' => 'Minimum wallet recharge amount in INR'),
                array('setting_key' => 'max_redemption_percent', 'setting_value' => '100', 'description' => 'Maximum percentage of bill that can be paid using points (1-100%)')
            );
            $this->db->insert_batch('points_settings', $defaults);
        }
    }

    /**
     * Get or create wallet for a user
     */
    public function get_or_create_wallet($user_id) {
        $user_id = intval($user_id);
        if ($user_id <= 0) return null;

        $wallet = $this->db->get_where('user_wallet', array('user_id' => $user_id))->row_array();
        if (!$wallet) {
            $signup_bonus = floatval($this->get_setting('signup_bonus_points', 50.00));
            $rate = floatval($this->get_setting('point_to_inr_ratio', 1.00));
            $money_val = $signup_bonus * $rate;

            $data = array(
                'user_id'             => $user_id,
                'points_balance'      => $signup_bonus,
                'currency_equivalent' => $money_val,
                'lifetime_earned'     => $signup_bonus,
                'lifetime_spent'      => 0.00,
                'status'              => '1',
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s')
            );
            $this->db->insert('user_wallet', $data);
            $wallet_id = $this->db->insert_id();

            if ($signup_bonus > 0) {
                $txn_ref = 'TXN-UP-BONUS-' . str_pad($user_id, 6, '0', STR_PAD_LEFT);
                $this->db->insert('wallet_transactions', array(
                    'txn_ref'         => $txn_ref,
                    'user_id'         => $user_id,
                    'type'            => 'CREDIT',
                    'amount_points'   => $signup_bonus,
                    'amount_money'    => $money_val,
                    'balance_before'  => 0.00,
                    'balance_after'   => $signup_bonus,
                    'source'          => 'SIGNUP_BONUS',
                    'payment_gateway' => 'WALLET',
                    'description'     => 'Welcome Bonus! Free Upchar Points upon account activation',
                    'status'          => 'SUCCESS',
                    'created_at'      => date('Y-m-d H:i:s')
                ));
            }

            return $this->db->get_where('user_wallet', array('wallet_id' => $wallet_id))->row_array();
        }
        return $wallet;
    }

    /**
     * Get user points balance
     */
    public function get_balance($user_id) {
        $wallet = $this->get_or_create_wallet($user_id);
        return $wallet ? floatval($wallet['points_balance']) : 0.00;
    }

    /**
     * Credit points to user wallet
     */
    public function credit_points($user_id, $points, $source = 'WALLET_RECHARGE', $ref_id = null, $desc = '', $gateway = 'WALLET', $gateway_txn_id = null) {
        $user_id = intval($user_id);
        $points = floatval($points);
        if ($user_id <= 0 || $points <= 0) return false;

        $wallet = $this->get_or_create_wallet($user_id);
        if (!$wallet || $wallet['status'] != '1') return false;

        $balance_before = floatval($wallet['points_balance']);
        $balance_after  = $balance_before + $points;
        $rate           = floatval($this->get_setting('point_to_inr_ratio', 1.00));
        $amount_money   = $points * $rate;
        $currency_eq    = $balance_after * $rate;

        $txn_ref = 'TXN-UP-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

        $this->db->trans_start();

        $this->db->where('user_id', $user_id);
        $this->db->update('user_wallet', array(
            'points_balance'      => $balance_after,
            'currency_equivalent' => $currency_eq,
            'lifetime_earned'     => floatval($wallet['lifetime_earned']) + $points,
            'updated_at'          => date('Y-m-d H:i:s')
        ));

        $this->db->insert('wallet_transactions', array(
            'txn_ref'         => $txn_ref,
            'user_id'         => $user_id,
            'type'            => 'CREDIT',
            'amount_points'   => $points,
            'amount_money'    => $amount_money,
            'balance_before'  => $balance_before,
            'balance_after'   => $balance_after,
            'source'          => $source,
            'reference_id'    => $ref_id,
            'payment_gateway' => $gateway,
            'gateway_txn_id'  => $gateway_txn_id,
            'description'     => $desc ?: 'Upchar Points Credited',
            'status'          => 'SUCCESS',
            'created_at'      => date('Y-m-d H:i:s')
        ));

        $this->db->trans_complete();
        return $this->db->trans_status() ? $txn_ref : false;
    }

    /**
     * Debit points from user wallet (Redemption)
     */
    public function debit_points($user_id, $points, $source = 'APPOINTMENT_PAYMENT', $ref_id = null, $desc = '') {
        $user_id = intval($user_id);
        $points = floatval($points);
        if ($user_id <= 0 || $points <= 0) return false;

        $wallet = $this->get_or_create_wallet($user_id);
        if (!$wallet || $wallet['status'] != '1') return false;

        $balance_before = floatval($wallet['points_balance']);
        if ($balance_before < $points) {
            return false;
        }

        $balance_after  = $balance_before - $points;
        $rate           = floatval($this->get_setting('point_to_inr_ratio', 1.00));
        $amount_money   = $points * $rate;
        $currency_eq    = $balance_after * $rate;

        $txn_ref = 'TXN-UP-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

        $this->db->trans_start();

        $this->db->where('user_id', $user_id);
        $this->db->update('user_wallet', array(
            'points_balance'      => $balance_after,
            'currency_equivalent' => $currency_eq,
            'lifetime_spent'      => floatval($wallet['lifetime_spent']) + $points,
            'updated_at'          => date('Y-m-d H:i:s')
        ));

        $this->db->insert('wallet_transactions', array(
            'txn_ref'         => $txn_ref,
            'user_id'         => $user_id,
            'type'            => 'DEBIT',
            'amount_points'   => $points,
            'amount_money'    => $amount_money,
            'balance_before'  => $balance_before,
            'balance_after'   => $balance_after,
            'source'          => $source,
            'reference_id'    => $ref_id,
            'payment_gateway' => 'WALLET',
            'description'     => $desc ?: 'Upchar Points Redeemed',
            'status'          => 'SUCCESS',
            'created_at'      => date('Y-m-d H:i:s')
        ));

        $this->db->trans_complete();
        return $this->db->trans_status() ? $txn_ref : false;
    }

    /**
     * Get transaction history for user
     */
    public function get_transactions($user_id, $limit = 50, $offset = 0, $type = 'ALL') {
        $this->db->from('wallet_transactions');
        $this->db->where('user_id', intval($user_id));
        if ($type === 'CREDIT' || $type === 'DEBIT') {
            $this->db->where('type', $type);
        }
        $this->db->order_by('transaction_id', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    /**
     * Get global points settings
     */
    public function get_setting($key, $default = '') {
        $row = $this->db->get_where('points_settings', array('setting_key' => $key))->row_array();
        return $row ? $row['setting_value'] : $default;
    }

    /**
     * Update setting
     */
    public function set_setting($key, $value, $desc = null) {
        $data = array('setting_value' => $value);
        if ($desc !== null) $data['description'] = $desc;
        
        $exists = $this->db->get_where('points_settings', array('setting_key' => $key))->row_array();
        if ($exists) {
            $this->db->where('setting_key', $key);
            return $this->db->update('points_settings', $data);
        } else {
            $data['setting_key'] = $key;
            return $this->db->insert('points_settings', $data);
        }
    }
}
