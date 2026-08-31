<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Razorpay & RazorpayX API Library for CodeIgniter 3
 * UPCHAR Healthcare SaaS Platform
 */
class Razorpay_lib {

    protected $ci;
    protected $key_id;
    protected $key_secret;
    protected $webhook_secret;
    protected $razorpayx_key_id;
    protected $razorpayx_key_secret;
    protected $razorpayx_account;
    protected $base_url = 'https://api.razorpay.com/v1';

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->config->load('razorpay', TRUE);

        $this->key_id               = $this->ci->config->item('razorpay_key_id', 'razorpay');
        $this->key_secret           = $this->ci->config->item('razorpay_key_secret', 'razorpay');
        $this->webhook_secret       = $this->ci->config->item('razorpay_webhook_secret', 'razorpay');
        $this->razorpayx_key_id     = $this->ci->config->item('razorpayx_key_id', 'razorpay');
        $this->razorpayx_key_secret = $this->ci->config->item('razorpayx_key_secret', 'razorpay');
        $this->razorpayx_account    = $this->ci->config->item('razorpayx_account_number', 'razorpay');
    }

    public function get_key_id() {
        return $this->key_id;
    }

    /**
     * Create Razorpay Standard Order
     *
     * @param float  $amount_inr Amount in INR (e.g. 500.00)
     * @param string $receipt    Internal unique receipt ref
     * @param array  $notes      Metadata key-value pairs
     * @return array Response array with status and order data
     */
    public function create_order($amount_inr, $receipt, $notes = array()) {
        $amount_paise = (int) round($amount_inr * 100);

        $payload = array(
            'amount'          => $amount_paise,
            'currency'        => 'INR',
            'receipt'         => (string) $receipt,
            'payment_capture' => 1,
            'notes'           => $notes
        );

        return $this->_http_request('POST', '/orders', $payload, $this->key_id, $this->key_secret);
    }

    /**
     * Verify payment signature via HMAC SHA-256
     *
     * @param string $order_id   Razorpay Order ID
     * @param string $payment_id Razorpay Payment ID
     * @param string $signature  Signature returned from frontend
     * @return bool True if valid
     */
    public function verify_signature($order_id, $payment_id, $signature) {
        if (empty($order_id) || empty($payment_id) || empty($signature)) {
            return false;
        }

        $generated_signature = hash_hmac('sha256', $order_id . '|' . $payment_id, $this->key_secret);
        return hash_equals($generated_signature, $signature);
    }

    /**
     * Verify webhook signature via HMAC SHA-256
     *
     * @param string $payload   Raw request body payload
     * @param string $signature Header X-Razorpay-Signature
     * @return bool True if valid
     */
    public function verify_webhook_signature($payload, $signature) {
        if (empty($payload) || empty($signature) || empty($this->webhook_secret)) {
            return false;
        }

        $expected_signature = hash_hmac('sha256', $payload, $this->webhook_secret);
        return hash_equals($expected_signature, $signature);
    }

    /**
     * Fetch payment details from Razorpay
     *
     * @param string $payment_id Razorpay Payment ID
     * @return array
     */
    public function fetch_payment($payment_id) {
        return $this->_http_request('GET', '/payments/' . $payment_id, array(), $this->key_id, $this->key_secret);
    }

    /**
     * Create Refund for a Payment
     *
     * @param string $payment_id Razorpay Payment ID
     * @param float  $amount_inr Amount to refund in INR (optional; null for full refund)
     * @param array  $notes      Refund notes
     * @return array
     */
    public function create_refund($payment_id, $amount_inr = null, $notes = array()) {
        $payload = array('notes' => $notes);
        if ($amount_inr !== null && $amount_inr > 0) {
            $payload['amount'] = (int) round($amount_inr * 100);
        }

        return $this->_http_request('POST', '/payments/' . $payment_id . '/refund', $payload, $this->key_id, $this->key_secret);
    }

    /**
     * RazorpayX: Create a Contact (Doctor / Hospital / Lab)
     *
     * @param string $name
     * @param string $email
     * @param string $contact Mobile number
     * @param string $type    'doctor', 'hospital', 'vendor'
     * @param string $reference_id Facility identifier
     * @return array
     */
    public function create_contact($name, $email, $contact, $type = 'vendor', $reference_id = '') {
        $payload = array(
            'name'         => $name,
            'email'        => $email,
            'contact'      => $contact,
            'type'         => $type,
            'reference_id' => (string) $reference_id
        );

        return $this->_http_request('POST', '/contacts', $payload, $this->razorpayx_key_id, $this->razorpayx_key_secret);
    }

    /**
     * RazorpayX: Create Fund Account (Bank or VPA)
     *
     * @param string $contact_id
     * @param string $account_type 'bank_account' or 'vpa'
     * @param array  $details
     * @return array
     */
    public function create_fund_account($contact_id, $account_type, $details) {
        $payload = array(
            'contact_id'   => $contact_id,
            'account_type' => $account_type
        );

        if ($account_type === 'bank_account') {
            $payload['bank_account'] = array(
                'name'           => $details['name'],
                'ifsc'           => strtoupper(trim($details['ifsc'])),
                'account_number' => trim($details['account_number'])
            );
        } else if ($account_type === 'vpa') {
            $payload['vpa'] = array(
                'address' => trim($details['vpa'])
            );
        }

        return $this->_http_request('POST', '/fund_accounts', $payload, $this->razorpayx_key_id, $this->razorpayx_key_secret);
    }

    /**
     * RazorpayX: Create Direct Payout (Disbursement)
     *
     * @param string $fund_account_id
     * @param float  $amount_inr
     * @param string $purpose         e.g. 'payout', 'salary', 'refund'
     * @param string $narration       e.g. 'UPCHAR Doctor Payout'
     * @param string $mode            'NEFT', 'RTGS', 'IMPS', 'UPI'
     * @param string $reference_id    Internal payout reference
     * @return array
     */
    public function create_payout($fund_account_id, $amount_inr, $purpose = 'payout', $narration = 'UPCHAR Payout', $mode = 'IMPS', $reference_id = '') {
        $amount_paise = (int) round($amount_inr * 100);

        $payload = array(
            'account_number'  => $this->razorpayx_account,
            'fund_account_id' => $fund_account_id,
            'amount'          => $amount_paise,
            'currency'        => 'INR',
            'mode'            => strtoupper($mode),
            'purpose'         => $purpose,
            'queue_if_low_balance' => true,
            'reference_id'    => (string) $reference_id,
            'narration'       => substr($narration, 0, 30)
        );

        return $this->_http_request('POST', '/payouts', $payload, $this->razorpayx_key_id, $this->razorpayx_key_secret);
    }

    /**
     * Generate standard UPI Deeplink Intent
     *
     * @param string $vpa
     * @param float  $amount
     * @param string $name
     * @param string $note
     * @param string $ref_id
     * @return string
     */
    public function get_upi_intent_uri($vpa = 'upcharhealth@icici', $amount = 0.00, $name = 'UPCHAR Healthcare', $note = 'Payment', $ref_id = '') {
        $params = array(
            'pa' => $vpa,
            'pn' => $name,
            'am' => number_format($amount, 2, '.', ''),
            'cu' => 'INR',
            'tn' => substr($note, 0, 80),
            'tr' => $ref_id
        );
        return 'upi://pay?' . http_build_query($params);
    }

    /**
     * Internal cURL Request Handler
     */
    private function _http_request($method, $endpoint, $payload = array(), $auth_user = '', $auth_pass = '') {
        $url = $this->base_url . $endpoint;
        $ch  = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $auth_user . ':' . $auth_pass);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $headers = array('Content-Type: application/json');

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        } else if ($method === 'GET' && !empty($payload)) {
            $url .= '?' . http_build_query($payload);
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response   = curl_exec($ch);
        $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            return array(
                'success'   => false,
                'http_code' => $http_code,
                'error'     => $curl_error,
                'data'      => null
            );
        }

        $decoded = json_decode($response, true);

        return array(
            'success'   => ($http_code >= 200 && $http_code < 300),
            'http_code' => $http_code,
            'data'      => $decoded,
            'raw'       => $response
        );
    }
}
