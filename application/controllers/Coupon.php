<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Coupon_model');
        $this->load->model('Wallet_model');
    }

    /**
     * AJAX Endpoint: Validate & Apply a Coupon Code
     */
    public function apply() {
        header('Content-Type: application/json');

        $userId = $this->session->userdata('USERID') ?: $this->session->userdata('userid') ?: $this->session->userdata('user_id');
        $code = trim($this->input->get_post('coupon_code', TRUE) ?: '');
        $serviceType = trim($this->input->get_post('service_type', TRUE) ?: 'ALL');
        $amount = floatval($this->input->get_post('amount', TRUE) ?: 0);

        if (empty($code)) {
            echo json_encode(['status' => 'error', 'message' => 'Please enter a coupon code.']);
            return;
        }

        if ($amount <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid order amount for coupon application.']);
            return;
        }

        $res = $this->Coupon_model->validate_coupon($code, $userId, $serviceType, $amount);

        if ($res['valid']) {
            // Save applied coupon to session for checkout flow
            $this->session->set_userdata('applied_coupon', [
                'coupon_id'       => $res['coupon_id'],
                'coupon_code'     => $res['coupon_code'],
                'discount_amount' => $res['discount_amount'],
                'service_type'    => $serviceType,
                'applied_at'      => date('Y-m-d H:i:s')
            ]);

            echo json_encode([
                'status'          => 'success',
                'coupon_code'     => $res['coupon_code'],
                'title'           => $res['title'],
                'discount_amount' => $res['discount_amount'],
                'net_amount'      => $res['net_amount'],
                'message'         => $res['message']
            ]);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => $res['message']
            ]);
        }
    }

    /**
     * AJAX Endpoint: Remove applied coupon from session
     */
    public function remove() {
        header('Content-Type: application/json');
        $this->session->unset_userdata('applied_coupon');
        echo json_encode(['status' => 'success', 'message' => 'Coupon removed.']);
    }

    /**
     * AJAX Endpoint: Fetch Available Coupons for a given service
     */
    public function available() {
        header('Content-Type: application/json');
        $userId = $this->session->userdata('USERID') ?: $this->session->userdata('userid') ?: $this->session->userdata('user_id');
        $serviceType = trim($this->input->get_post('service_type', TRUE)) ?: 'ALL';

        $coupons = $this->Coupon_model->get_available_coupons($serviceType, $userId);

        echo json_encode([
            'status'  => 'success',
            'coupons' => $coupons
        ]);
    }
}
