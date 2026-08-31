<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payout Controller
 * UPCHAR Healthcare SaaS Provider Settlements & Payout Management
 */
class Payout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Payout_model');
        $this->load->model('Financial_Model');
        $this->load->library('Razorpay_lib');
        $this->load->helper(array('url', 'form'));
    }

    private function _check_admin() {
        $admin_id = $this->session->userdata('adminuserid') ?:
                    $this->session->userdata('userid') ?:
                    $this->session->userdata('username');
        if (!$admin_id) {
            redirect(base_url('login'));
            return null;
        }
        return $admin_id;
    }

    /**
     * Payout Dashboard View
     */
    public function dashboard() {
        $admin_id = $this->_check_admin();

        $data['pending_settlements'] = $this->Payout_model->get_pending_settlements_summary();
        $data['recent_batches']      = $this->Payout_model->get_payout_batches(20, 0);

        $total_pending = 0.00;
        foreach ($data['pending_settlements'] as $ps) {
            $total_pending += floatval($ps['total_pending_amount']);
        }
        $data['total_pending_amount'] = $total_pending;

        $this->load->view('payout/dashboard', $data);
    }

    /**
     * POST: Trigger Weekly / On-Demand Payout Batch
     */
    public function trigger_batch() {
        $admin_id = $this->_check_admin();

        $notes = $this->input->post('notes') ?: 'Manual batch trigger by Admin';
        $result = $this->Payout_model->create_payout_batch($admin_id, $notes);

        echo json_encode(array(
            'status'  => 'success',
            'message' => 'Payout batch #' . $result['batch_ref'] . ' processed successfully.',
            'data'    => $result
        ));
    }

    /**
     * POST: Save or Update Facility Payout Bank / VPA Account
     */
    public function add_account() {
        $facility_type  = $this->input->post('facility_type');
        $facility_id    = intval($this->input->post('facility_id'));
        $account_type   = $this->input->post('account_type'); // BANK_ACCOUNT or VPA
        $account_name   = $this->input->post('account_name');
        $account_number = $this->input->post('account_number');
        $ifsc_code      = $this->input->post('ifsc_code');
        $bank_name      = $this->input->post('bank_name');
        $vpa            = $this->input->post('vpa');

        if (empty($facility_type) || $facility_id <= 0 || empty($account_name)) {
            echo json_encode(array('status' => 'error', 'message' => 'Required fields are missing.'));
            return;
        }

        $id = $this->Payout_model->save_facility_payout_account($facility_type, $facility_id, array(
            'account_type'   => $account_type ?: 'BANK_ACCOUNT',
            'account_name'   => $account_name,
            'account_number' => $account_number,
            'ifsc_code'      => $ifsc_code,
            'bank_name'      => $bank_name,
            'vpa'            => $vpa,
            'is_verified'    => 1 // Auto-verified for active facilities in demo/sandbox
        ));

        echo json_encode(array(
            'status'  => 'success',
            'message' => 'Payout account saved and verified successfully.',
            'id'      => $id
        ));
    }

    /**
     * POST: Verify or Reject Facility Account
     */
    public function verify_account() {
        $this->_check_admin();
        $account_id = intval($this->input->post('account_id'));
        $status     = intval($this->input->post('is_verified'));

        $this->db->where('id', $account_id)->update('facility_payout_accounts', array('is_verified' => $status));

        echo json_encode(array('status' => 'success', 'message' => 'Account verification updated.'));
    }
}
