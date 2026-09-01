<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('User_Model');
        $this->load->model('Wallet_model');
        $this->load->helper(array('url', 'form'));
    }

    /**
     * Check if patient is logged in
     */
    private function _check_auth() {
        $userId = $this->session->userdata('USERID') ?: $this->session->userdata('userid') ?: $this->session->userdata('WEB_UID') ?: $this->session->userdata('user_id');
        if (!$userId) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-warning">Please login to access your Upchar Points Wallet.</div>');
            redirect(base_url('login'));
        }
        return $userId;
    }

    /**
     * User Wallet Dashboard
     */
    public function index() {
        $userId = $this->_check_auth();

        $wallet = $this->Wallet_model->get_or_create_wallet($userId);
        $data['wallet'] = $wallet;
        $data['transactions'] = $this->Wallet_model->get_transactions($userId, 50, 0, 'ALL');
        $data['point_ratio'] = floatval($this->Wallet_model->get_setting('point_to_inr_ratio', 1.00));
        $data['cashback_pct'] = floatval($this->Wallet_model->get_setting('cashback_percentage', 5.00));
        $data['user_data'] = $this->db->get_where('userlogin', array('USERID' => $userId))->row_array();

        $this->load->view('patient_header', $data);
        $this->load->view('wallet/index', $data);
        $this->load->view('patient_footer');
    }

    /**
     * AJAX Balance Check
     */
    public function get_balance_ajax() {
        $userId = $this->session->userdata('USERID') ?: $this->session->userdata('userid') ?: $this->session->userdata('WEB_UID') ?: $this->session->userdata('user_id');
        if (!$userId) {
            echo json_encode(array('status' => 'error', 'message' => 'Unauthenticated', 'balance' => 0.00));
            return;
        }

        $balance = $this->Wallet_model->get_balance($userId);
        $rate = floatval($this->Wallet_model->get_setting('point_to_inr_ratio', 1.00));
        echo json_encode(array(
            'status'        => 'success',
            'points'        => $balance,
            'money_val'     => ($balance * $rate),
            'formatted'     => number_format($balance, 2) . ' Upchar Points'
        ));
    }

    /**
     * Wallet Top-Up / Recharge Initiation
     */
    public function recharge() {
        $userId = $this->_check_auth();

        if (strtolower($this->input->server('REQUEST_METHOD')) !== 'post') {
            redirect(base_url('wallet'));
            return;
        }

        $amount = floatval($this->input->post('amount'));
        $minRecharge = floatval($this->Wallet_model->get_setting('min_recharge_amount', 100.00));

        if ($amount < $minRecharge) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Minimum recharge amount is ₹' . number_format($minRecharge, 2) . '.</div>');
            redirect(base_url('wallet'));
            return;
        }

        $rate = floatval($this->Wallet_model->get_setting('point_to_inr_ratio', 1.00));
        $pointsToAdd = ($rate > 0) ? ($amount / $rate) : $amount;

        $topupRef = 'TOPUP-' . date('YmdHis') . '-' . rand(100, 999);
        redirect(base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=' . $topupRef . '&amount=' . $amount . '&item_name=' . urlencode('Upchar Points Wallet Recharge (' . number_format($pointsToAdd, 0) . ' Pts)')));
    }
}
