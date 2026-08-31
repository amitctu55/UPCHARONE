<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Super Admin Payment & Revenue Management Module
 * UPCHAR Healthcare Platform
 */
class Admin_payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");

        // Super Admin Auth Check
        if (!$this->session->userdata('adminuserid') && !$this->session->userdata('userid') && !$this->session->userdata('username')) {
            redirect(base_url('login'));
        }

        $this->load->model('Payment_model');
        $this->load->model('Wallet_model');
        $this->load->model('Payout_model');
        $this->load->model('Refund_model');
        $this->load->model('Financial_Model');
        $this->load->helper(array('url', 'form', 'query_string_helper', 'dbquery_helper', 'admin_helper'));
    }

    /**
     * Unified Admin Payment Portal Hub
     */
    public function index($tab = 'dashboard') {
        $active_tab = $this->input->get('tab') ?: $tab;
        $data['active_tab'] = $active_tab;

        // Payment Summary
        $data['payment_summary'] = $this->Payment_model->get_payment_summary();

        // Wallet Settings
        $data['point_ratio']        = floatval($this->Wallet_model->get_setting('point_to_inr_ratio', 1.00));
        $data['signup_bonus']       = floatval($this->Wallet_model->get_setting('signup_bonus_points', 50.00));
        $data['cashback_pct']       = floatval($this->Wallet_model->get_setting('cashback_percentage', 5.00));
        $data['min_recharge']       = floatval($this->Wallet_model->get_setting('min_recharge_amount', 100.00));
        $data['referral_referrer']  = floatval($this->Wallet_model->get_setting('referral_bonus_referrer', 50.00));
        $data['referral_referee']   = floatval($this->Wallet_model->get_setting('referral_bonus_referee', 25.00));

        // Orders list
        $data['orders'] = $this->db->order_by('id', 'DESC')->limit(100)->get('razorpay_orders')->result_array();

        // Refunds list
        $data['refunds'] = $this->Refund_model->get_refunds(array(), 50, 0);

        // Pending Settlements
        $data['pending_settlements'] = $this->Payout_model->get_pending_settlements_summary();

        // Historical Batches
        $data['payout_batches'] = $this->Payout_model->get_payout_batches(20, 0);

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('dashboard', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * POST: Save Wallet Points & Reward Configurations
     */
    public function save_wallet_settings() {
        $point_ratio       = floatval($this->input->post('point_to_inr_ratio'));
        $signup_bonus      = floatval($this->input->post('signup_bonus_points'));
        $cashback_pct      = floatval($this->input->post('cashback_percentage'));
        $min_recharge      = floatval($this->input->post('min_recharge_amount'));
        $referral_referrer = floatval($this->input->post('referral_bonus_referrer'));
        $referral_referee  = floatval($this->input->post('referral_bonus_referee'));

        if ($point_ratio > 0) {
            $this->Wallet_model->set_setting('point_to_inr_ratio', $point_ratio, 'Value of 1 Point in INR');
        }
        $this->Wallet_model->set_setting('signup_bonus_points', $signup_bonus, 'Signup bonus points awarded to new users');
        $this->Wallet_model->set_setting('cashback_percentage', $cashback_pct, 'Cashback % in points earned on orders');
        $this->Wallet_model->set_setting('min_recharge_amount', $min_recharge, 'Minimum wallet recharge amount in INR');
        $this->Wallet_model->set_setting('referral_bonus_referrer', $referral_referrer, 'Points for referrer');
        $this->Wallet_model->set_setting('referral_bonus_referee', $referral_referee, 'Points for referee');

        $this->session->set_flashdata('flashmsg', '<div class="alert alert-success">Upchar Wallet & Reward configurations updated successfully!</div>');
        redirect(base_url('admin_payment?tab=wallet_settings'));
    }

    /**
     * Export Orders to CSV
     */
    public function export_orders() {
        $orders = $this->db->order_by('id', 'DESC')->get('razorpay_orders')->result_array();
        $filename = "upchar_payment_orders_" . date('Ymd_His') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, array(
            'Order ID', 'Internal Ref', 'Gateway Order ID', 'Gateway Payment ID',
            'User ID', 'Purpose', 'Ref ID', 'Gross Amount (INR)', 'Points Used',
            'Gateway Paid (INR)', 'Status', 'Date'
        ));

        foreach ($orders as $o) {
            fputcsv($output, array(
                $o['id'],
                $o['internal_order_ref'],
                $o['razorpay_order_id'],
                $o['razorpay_payment_id'],
                $o['user_id'],
                $o['purpose'],
                $o['reference_id'],
                $o['amount'],
                $o['wallet_points_used'],
                $o['gateway_amount'],
                $o['status'],
                $o['created_at']
            ));
        }
        fclose($output);
        exit;
    }
}
