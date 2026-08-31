<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payment Controller
 * UPCHAR Healthcare SaaS Unified Payment & Checkout Gateway
 */
class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Payment_model');
        $this->load->model('Wallet_model');
        $this->load->model('Referral_model');
        $this->load->model('Financial_Model');
        $this->load->library('Razorpay_lib');
        $this->load->helper(array('url', 'form'));
    }

    /**
     * Get Current Authenticated User ID
     */
    private function _get_user_id() {
        return $this->session->userdata('USERID') ?:
               $this->session->userdata('userid') ?:
               $this->session->userdata('WEB_UID') ?:
               $this->session->userdata('user_id');
    }

    /**
     * Dedicated Unified Checkout Page
     */
    public function checkout() {
        $userId = $this->_get_user_id();
        if (!$userId) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-warning">Please login to complete your payment.</div>');
            redirect(base_url('login'));
            return;
        }

        // Support session-based checkout data (e.g. from appointment / lab test booking)
        $securePay = $this->session->userdata('SecurePay');
        $aid       = $this->session->userdata('AppointmentCheckout');

        $purpose      = $this->input->get_post('purpose') ?: ($aid ? 'APPOINTMENT' : 'WALLET_RECHARGE');
        $reference_id = $this->input->get_post('reference_id') ?: $aid;
        $amount       = floatval($this->input->get_post('amount') ?: (isset($securePay['Amount']) ? $securePay['Amount'] : 500.00));
        $item_name    = $this->input->get_post('item_name') ?: (isset($securePay['Service']) ? $securePay['Service'] : 'Doctor OPD Consultation');

        $user_points  = $this->Wallet_model->get_balance($userId);
        $point_ratio  = floatval($this->Wallet_model->get_setting('point_to_inr_ratio', 1.00));
        $cashback_pct = floatval($this->Wallet_model->get_setting('cashback_percentage', 5.00));

        $data['user_id']      = $userId;
        $data['user_data']    = $this->db->get_where('userlogin', array('USERID' => $userId))->row_array();
        $data['purpose']      = $purpose;
        $data['reference_id'] = $reference_id;
        $data['amount']       = $amount;
        $data['item_name']    = $item_name;
        $data['user_points']  = $user_points;
        $data['point_ratio']  = $point_ratio;
        $data['cashback_pct'] = $cashback_pct;
        $data['rzp_key_id']   = $this->razorpay_lib->get_key_id();

        $this->load->view('includes/header', $data);
        $this->load->view('payment/checkout', $data);
        $this->load->view('includes/footer');
    }

    /**
     * AJAX: Create Razorpay Order & Initiate Internal Order Record
     */
    public function create_order() {
        $userId = $this->_get_user_id();
        if (!$userId) {
            echo json_encode(array('status' => 'error', 'message' => 'User not logged in.'));
            return;
        }

        $amount        = floatval($this->input->post('amount'));
        $purpose       = $this->input->post('purpose') ?: 'APPOINTMENT';
        $reference_id  = $this->input->post('reference_id') ?: null;
        $points_to_use = floatval($this->input->post('wallet_points_to_use') ?: 0);

        if ($amount <= 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid order amount.'));
            return;
        }

        $point_ratio = floatval($this->Wallet_model->get_setting('point_to_inr_ratio', 1.00));
        $wallet_discount_inr = 0.00;

        if ($points_to_use > 0) {
            $user_balance = $this->Wallet_model->get_balance($userId);
            if ($user_balance < $points_to_use) {
                echo json_encode(array('status' => 'error', 'message' => 'Insufficient Upchar Points balance.'));
                return;
            }
            $wallet_discount_inr = min($amount, $points_to_use * $point_ratio);
        }

        $gateway_amount = max(0.00, $amount - $wallet_discount_inr);
        $internal_ref   = $this->Payment_model->generate_order_ref();

        $rzp_order_id = null;

        // If paying 100% via Points
        if ($gateway_amount <= 0.00) {
            $rzp_order_id = 'PTS-ONLY-' . time();
            $order_id = $this->Payment_model->create_razorpay_order(array(
                'internal_order_ref' => $internal_ref,
                'razorpay_order_id'  => $rzp_order_id,
                'user_id'            => $userId,
                'amount'             => $amount,
                'currency'           => 'INR',
                'purpose'            => $purpose,
                'reference_id'       => $reference_id,
                'wallet_points_used' => $points_to_use,
                'wallet_amount_used' => $wallet_discount_inr,
                'gateway_amount'     => 0.00
            ));

            echo json_encode(array(
                'status'             => 'points_only',
                'internal_order_ref' => $internal_ref,
                'points_used'        => $points_to_use,
                'redirect_url'       => base_url('payment/process_points_only/' . $internal_ref)
            ));
            return;
        }

        // Call Razorpay API to generate live Order ID
        $notes = array(
            'internal_ref' => $internal_ref,
            'user_id'      => (string)$userId,
            'purpose'      => $purpose,
            'reference_id' => (string)$reference_id
        );

        $rzp_res = $this->razorpay_lib->create_order($gateway_amount, $internal_ref, $notes);

        if (!empty($rzp_res['success']) && isset($rzp_res['data']['id'])) {
            $rzp_order_id = $rzp_res['data']['id'];

            $this->Payment_model->create_razorpay_order(array(
                'internal_order_ref' => $internal_ref,
                'razorpay_order_id'  => $rzp_order_id,
                'user_id'            => $userId,
                'amount'             => $amount,
                'currency'           => 'INR',
                'purpose'            => $purpose,
                'reference_id'       => $reference_id,
                'wallet_points_used' => $points_to_use,
                'wallet_amount_used' => $wallet_discount_inr,
                'gateway_amount'     => $gateway_amount
            ));

            $user_row = $this->db->get_where('userlogin', array('USERID' => $userId))->row_array();

            echo json_encode(array(
                'status'             => 'success',
                'internal_order_ref' => $internal_ref,
                'razorpay_order_id'  => $rzp_order_id,
                'amount_paise'       => (int)round($gateway_amount * 100),
                'amount_inr'         => $gateway_amount,
                'key_id'             => $this->razorpay_lib->get_key_id(),
                'user_name'          => isset($user_row['NAME']) ? $user_row['NAME'] : 'Valued Patient',
                'user_email'         => isset($user_row['EMAIL']) ? $user_row['EMAIL'] : 'patient@upchar.com',
                'user_mobile'        => isset($user_row['MOBILE']) ? $user_row['MOBILE'] : '9999999999'
            ));
        } else {
            $err = isset($rzp_res['error']) ? $rzp_res['error'] : (isset($rzp_res['data']['error']['description']) ? $rzp_res['data']['error']['description'] : 'Gateway order creation failed.');
            echo json_encode(array('status' => 'error', 'message' => $err));
        }
    }

    /**
     * Process 100% Points Payment
     */
    public function process_points_only($internal_ref) {
        $userId = $this->_get_user_id();
        $order = $this->Payment_model->get_order_by_ref($internal_ref);

        if (!$order || $order['user_id'] != $userId) {
            redirect(base_url('payment/failed/' . $internal_ref . '?err=InvalidOrder'));
            return;
        }

        $points_needed = floatval($order['wallet_points_used']);
        $debit_res = $this->Wallet_model->debit_points(
            $userId,
            $points_needed,
            'ORDER_PAYMENT',
            $order['reference_id'],
            'Payment for ' . $order['purpose'] . ' #' . $order['reference_id']
        );

        if ($debit_res) {
            $this->Payment_model->update_order_status($internal_ref, 'PAID', 'PTS-' . $debit_res);
            $this->_fulfill_order($order);
            redirect(base_url('payment/success/' . $internal_ref));
        } else {
            $this->Payment_model->update_order_status($internal_ref, 'FAILED', null, array('error_reason' => 'Points debit failed'));
            redirect(base_url('payment/failed/' . $internal_ref . '?err=InsufficientPoints'));
        }
    }

    /**
     * AJAX: Verify Razorpay Payment Signature & Fulfill Order
     */
    public function verify() {
        $rzp_order_id  = $this->input->post('razorpay_order_id');
        $rzp_pay_id    = $this->input->post('razorpay_payment_id');
        $rzp_signature = $this->input->post('razorpay_signature');
        $internal_ref  = $this->input->post('internal_order_ref');

        if (empty($rzp_order_id) || empty($rzp_pay_id) || empty($rzp_signature)) {
            echo json_encode(array('status' => 'error', 'message' => 'Missing verification parameters.'));
            return;
        }

        $is_valid = $this->razorpay_lib->verify_signature($rzp_order_id, $rzp_pay_id, $rzp_signature);

        if (!$is_valid) {
            $this->Payment_model->update_order_status($internal_ref, 'FAILED', $rzp_pay_id, array('error_reason' => 'Signature verification failed'));
            echo json_encode(array('status' => 'error', 'message' => 'Payment signature verification failed.'));
            return;
        }

        $order = $this->Payment_model->get_order_by_ref($internal_ref);
        if (!$order) {
            $order = $this->Payment_model->get_order_by_razorpay_id($rzp_order_id);
        }

        if (!$order) {
            echo json_encode(array('status' => 'error', 'message' => 'Order not found.'));
            return;
        }

        // Deduct points if hybrid payment
        if ($order['wallet_points_used'] > 0) {
            $this->Wallet_model->debit_points(
                $order['user_id'],
                $order['wallet_points_used'],
                'HYBRID_PAYMENT',
                $order['reference_id'],
                'Partial payment for ' . $order['purpose'] . ' #' . $order['reference_id']
            );
        }

        // Mark Paid
        $this->Payment_model->update_order_status($order['internal_order_ref'], 'PAID', $rzp_pay_id);

        // Fulfill business domain (Appointment / Lab / Wallet Recharge)
        $this->_fulfill_order($order, $rzp_pay_id);

        echo json_encode(array(
            'status'       => 'success',
            'redirect_url' => base_url('payment/success/' . $order['internal_order_ref'])
        ));
    }

    /**
     * Webhook Handler (Asynchronous Gateway Events)
     */
    public function webhook() {
        $payload   = file_get_contents('php://input');
        $signature = isset($_SERVER['HTTP_X_RAZORPAY_SIGNATURE']) ? $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] : '';

        $is_valid  = $this->razorpay_lib->verify_webhook_signature($payload, $signature);
        $data      = json_decode($payload, true);
        $event     = isset($data['event']) ? $data['event'] : 'unknown';

        $log_id = $this->Payment_model->log_webhook('RAZORPAY', $event, $payload, $is_valid);

        if (!$is_valid) {
            $this->Payment_model->mark_webhook_processed($log_id, 'Rejected: Invalid signature');
            http_response_code(200);
            echo json_encode(array('status' => 'ignored'));
            return;
        }

        // Handle Event Types
        if ($event === 'payment.captured') {
            $payment = isset($data['payload']['payment']['entity']) ? $data['payload']['payment']['entity'] : null;
            if ($payment) {
                $order_id = isset($payment['order_id']) ? $payment['order_id'] : '';
                $pay_id   = isset($payment['id']) ? $payment['id'] : '';
                $order    = $this->Payment_model->get_order_by_razorpay_id($order_id);

                if ($order && $order['status'] !== 'PAID') {
                    $this->Payment_model->update_order_status($order['internal_order_ref'], 'PAID', $pay_id, array('webhook_received_at' => date('Y-m-d H:i:s')));
                    $this->_fulfill_order($order, $pay_id);
                    $this->Payment_model->mark_webhook_processed($log_id, 'Payment captured successfully for Order #' . $order['internal_order_ref']);
                }
            }
        } else if ($event === 'payment.failed') {
            $payment = isset($data['payload']['payment']['entity']) ? $data['payload']['payment']['entity'] : null;
            if ($payment) {
                $order_id = isset($payment['order_id']) ? $payment['order_id'] : '';
                $reason   = isset($payment['error_description']) ? $payment['error_description'] : 'Payment failed';
                $order    = $this->Payment_model->get_order_by_razorpay_id($order_id);
                if ($order) {
                    $this->Payment_model->update_order_status($order['internal_order_ref'], 'FAILED', null, array('error_reason' => $reason));
                }
            }
        }

        http_response_code(200);
        echo json_encode(array('status' => 'ok'));
    }

    /**
     * Business Logic Fulfillment after Successful Payment
     */
    private function _fulfill_order($order, $gateway_txn_id = null) {
        $userId  = intval($order['user_id']);
        $purpose = $order['purpose'];
        $ref_id  = $order['reference_id'];
        $amount  = floatval($order['amount']);

        if ($purpose === 'WALLET_RECHARGE') {
            $rate = floatval($this->Wallet_model->get_setting('point_to_inr_ratio', 1.00));
            $pts  = ($rate > 0) ? ($amount / $rate) : $amount;
            $this->Wallet_model->credit_points(
                $userId,
                $pts,
                'WALLET_RECHARGE',
                $order['internal_order_ref'],
                'Wallet Recharge of ₹' . number_format($amount, 2),
                'RAZORPAY',
                $gateway_txn_id
            );
        } else if ($purpose === 'APPOINTMENT' && $ref_id) {
            // Update appointment record
            $this->db->where('appointment_id', $ref_id)->update('appointment', array(
                'payment_status'     => 'PAID',
                'payment_mode'       => 'RAZORPAY',
                'ref_no'             => $order['internal_order_ref'],
                'pay_date'           => date('Y-m-d H:i:s'),
                'appointment_status' => '1',
                'user_id'            => $userId
            ));

            // Award Cashback Points
            $cashback_pct = floatval($this->Wallet_model->get_setting('cashback_percentage', 5.00));
            if ($cashback_pct > 0) {
                $cashback_pts = round(($amount * ($cashback_pct / 100)), 2);
                if ($cashback_pts > 0) {
                    $this->Wallet_model->credit_points(
                        $userId,
                        $cashback_pts,
                        'APPOINTMENT_CASHBACK',
                        $ref_id,
                        'Cashback reward for Appointment #' . $ref_id,
                        'WALLET'
                    );
                }
            }

            // Award Referral Bonus if this is referee's first booking
            $this->Referral_model->complete_first_booking_reward($userId);
        }

        // Clear session checkout tokens if any
        $this->session->unset_userdata('SecurePay');
        $this->session->unset_userdata('AppointmentCheckout');
    }

    /**
     * Payment Success Page
     */
    public function success($order_ref = '') {
        $order = $this->Payment_model->get_order_by_ref($order_ref);
        if (!$order) {
            redirect(base_url());
            return;
        }

        $userId = $order['user_id'];
        $data['order']        = $order;
        $data['user_balance'] = $this->Wallet_model->get_balance($userId);
        $data['cashback_pts'] = round(($order['amount'] * 0.05), 2);

        $this->load->view('includes/header', $data);
        $this->load->view('payment/success', $data);
        $this->load->view('includes/footer');
    }

    /**
     * Payment Failed Page
     */
    public function failed($order_ref = '') {
        $order = $this->Payment_model->get_order_by_ref($order_ref);
        $data['order']        = $order;
        $data['error_reason'] = $this->input->get('err') ?: (isset($order['error_reason']) ? $order['error_reason'] : 'Transaction was not completed.');

        $this->load->view('includes/header', $data);
        $this->load->view('payment/failed', $data);
        $this->load->view('includes/footer');
    }
}
