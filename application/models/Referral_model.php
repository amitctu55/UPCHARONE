<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Referral Program Model
 * UPCHAR Healthcare SaaS Referral & Growth Engine
 */
class Referral_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Wallet_model');
        date_default_timezone_set("Asia/Kolkata");
    }

    /**
     * Get or generate unique referral code for a user
     */
    public function get_or_create_code($user_id) {
        $user_id = intval($user_id);
        if ($user_id <= 0) return null;

        // Check if referral code is already stored in user_wallet metadata or profile
        $existing = $this->db->get_where('user_referrals', array('referrer_user_id' => $user_id))->row_array();
        if ($existing && !empty($existing['referral_code'])) {
            return $existing['referral_code'];
        }

        // Generate deterministic unique code based on user_id and name
        $user = $this->db->get_where('userlogin', array('USERID' => $user_id))->row_array();
        $name_part = 'USER';
        if ($user && !empty($user['NAME'])) {
            $cleaned = preg_replace('/[^A-Za-z]/', '', strtoupper($user['NAME']));
            $name_part = substr($cleaned, 0, 4) ?: 'USER';
        }

        $code = 'UPCH-' . $name_part . '-' . str_pad($user_id, 4, '0', STR_PAD_LEFT);

        return $code;
    }

    /**
     * Apply referral code during signup / onboarding
     */
    public function apply_referral_code($referee_user_id, $code) {
        $referee_user_id = intval($referee_user_id);
        $code = strtoupper(trim($code));

        if ($referee_user_id <= 0 || empty($code)) {
            return array('success' => false, 'message' => 'Invalid referral code or user.');
        }

        // Check if referee already applied a code
        $already_applied = $this->db->get_where('user_referrals', array('referee_user_id' => $referee_user_id))->row_array();
        if ($already_applied) {
            return array('success' => false, 'message' => 'You have already used a referral code.');
        }

        // Find referrer by matching generated code pattern
        // Pattern: UPCH-NAME-USERID
        $parts = explode('-', $code);
        $referrer_id = 0;
        if (count($parts) === 3 && is_numeric($parts[2])) {
            $referrer_id = intval($parts[2]);
        }

        // Verify referrer exists in userlogin
        if ($referrer_id <= 0 || $referrer_id === $referee_user_id) {
            return array('success' => false, 'message' => 'Invalid or self-referral code.');
        }

        $referrer = $this->db->get_where('userlogin', array('USERID' => $referrer_id))->row_array();
        if (!$referrer) {
            return array('success' => false, 'message' => 'Referral code not found.');
        }

        // Insert pending referral record
        $insert_data = array(
            'referrer_user_id'      => $referrer_id,
            'referee_user_id'       => $referee_user_id,
            'referral_code'         => $code,
            'points_given_referrer' => 0.00,
            'points_given_referee'  => 0.00,
            'status'                => 'PENDING',
            'created_at'            => date('Y-m-d H:i:s')
        );

        $this->db->insert('user_referrals', $insert_data);

        return array(
            'success' => true,
            'message' => 'Referral code applied! Complete your first appointment to earn bonus points.'
        );
    }

    /**
     * Award referral bonus points on referee's first successful booking
     */
    public function complete_first_booking_reward($referee_user_id) {
        $referee_user_id = intval($referee_user_id);
        if ($referee_user_id <= 0) return false;

        $referral = $this->db->get_where('user_referrals', array(
            'referee_user_id' => $referee_user_id,
            'status'          => 'PENDING'
        ))->row_array();

        if (!$referral) {
            return false;
        }

        $referrer_id   = intval($referral['referrer_user_id']);
        $referrer_pts  = floatval($this->Wallet_model->get_setting('referral_bonus_referrer', 50.00));
        $referee_pts   = floatval($this->Wallet_model->get_setting('referral_bonus_referee', 25.00));

        // Credit referrer
        if ($referrer_pts > 0) {
            $this->Wallet_model->credit_points(
                $referrer_id,
                $referrer_pts,
                'REFERRAL_REWARD',
                $referee_user_id,
                'Referral Bonus for inviting User #' . $referee_user_id,
                'WALLET'
            );
        }

        // Credit referee
        if ($referee_pts > 0) {
            $this->Wallet_model->credit_points(
                $referee_user_id,
                $referee_pts,
                'REFERRAL_WELCOME',
                $referrer_id,
                'Referral Welcome Bonus from Friend #' . $referrer_id,
                'WALLET'
            );
        }

        // Update referral record
        $this->db->where('id', $referral['id']);
        $this->db->update('user_referrals', array(
            'points_given_referrer' => $referrer_pts,
            'points_given_referee'  => $referee_pts,
            'status'                => 'COMPLETED',
            'completed_at'          => date('Y-m-d H:i:s')
        ));

        return true;
    }

    /**
     * Get user's referral summary & statistics
     */
    public function get_stats($user_id) {
        $user_id = intval($user_id);
        $code = $this->get_or_create_code($user_id);

        $total_invites = $this->db->where('referrer_user_id', $user_id)->count_all_results('user_referrals');
        $completed     = $this->db->where('referrer_user_id', $user_id)->where('status', 'COMPLETED')->count_all_results('user_referrals');
        $pending       = $this->db->where('referrer_user_id', $user_id)->where('status', 'PENDING')->count_all_results('user_referrals');

        $total_points_earned = $this->db->select_sum('points_given_referrer')
                                        ->where('referrer_user_id', $user_id)
                                        ->where('status', 'COMPLETED')
                                        ->get('user_referrals')->row()->points_given_referrer ?: 0.00;

        return array(
            'referral_code'       => $code,
            'share_link'          => base_url('sign_up?ref=' . $code),
            'total_invites'       => $total_invites,
            'completed_invites'   => $completed,
            'pending_invites'     => $pending,
            'total_points_earned' => floatval($total_points_earned)
        );
    }
}
