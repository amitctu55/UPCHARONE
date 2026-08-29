<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Walletadmin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('walletmodel');
        $this->load->helper(array('query_string_helper', 'dbquery_helper', 'admin_helper'));

        if (!$this->session->userdata('adminuserid') && !$this->session->userdata('userid') && !$this->session->userdata('username')) {
            redirect(base_url() . 'login');
        }
    }

    public function index() {
        $keyword = trim($this->input->get('keyword') ?: '');
        $tab = $this->input->get('tab') ?: 'wallets';

        // Stats
        $data['total_wallets'] = $this->db->count_all_results('user_wallet');
        $data['total_points']  = $this->db->select_sum('points_balance')->get('user_wallet')->row()->points_balance ?: 0;
        $data['total_earned']  = $this->db->select_sum('lifetime_earned')->get('user_wallet')->row()->lifetime_earned ?: 0;
        $data['total_spent']   = $this->db->select_sum('lifetime_spent')->get('user_wallet')->row()->lifetime_spent ?: 0;

        // User Wallets List
        $this->db->select('w.*, u.FNAME, u.LNAME, u.MOBILE, u.EMAIL, u.REG_DATE');
        $this->db->from('user_wallet w');
        $this->db->join('userlogin u', 'u.USERID = w.user_id', 'left');
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('u.FNAME', $keyword);
            $this->db->or_like('u.LNAME', $keyword);
            $this->db->or_like('u.MOBILE', $keyword);
            $this->db->or_like('u.EMAIL', $keyword);
            $this->db->or_like('w.user_id', $keyword);
            $this->db->group_end();
        }
        $this->db->order_by('w.points_balance', 'DESC');
        $this->db->limit(100);
        $data['wallets'] = $this->db->get()->result_array();

        // Recent Global Transactions
        $this->db->select('t.*, u.FNAME, u.LNAME, u.MOBILE');
        $this->db->from('wallet_transactions t');
        $this->db->join('userlogin u', 'u.USERID = t.user_id', 'left');
        $this->db->order_by('t.transaction_id', 'DESC');
        $this->db->limit(100);
        $data['transactions'] = $this->db->get()->result_array();

        // Settings
        $data['settings'] = $this->db->get('points_settings')->result_array();
        $data['keyword'] = $keyword;
        $data['active_tab'] = $tab;

        $data['heading_title'] = 'Upchar Points Master';
        $data['module'] = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('wallet_admin', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Manual Adjustment (Credit or Debit points)
     */
    public function adjust_points() {
        $userId = intval($this->input->post('user_id'));
        $type = $this->input->post('type');
        $points = floatval($this->input->post('points'));
        $note = trim($this->input->post('note') ?: 'Manual admin adjustment');

        if ($userId <= 0 || $points <= 0) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Invalid user ID or points amount.</div>');
            redirect(base_url('masters/walletadmin'));
            return;
        }

        $adminUser = $this->session->userdata('username') ?: 'Admin';
        $desc = $note . " (by $adminUser)";

        if ($type === 'CREDIT') {
            $res = $this->walletmodel->credit_points($userId, $points, 'MANUAL_ADMIN_CREDIT', null, $desc, 'MANUAL');
        } else {
            $res = $this->walletmodel->debit_points($userId, $points, 'MANUAL_ADMIN_DEBIT', null, $desc);
        }

        if ($res) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-success"><strong>Success!</strong> Points ' . strtolower($type) . 'ed successfully. Txn Ref: ' . $res . '</div>');
        } else {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Transaction failed. Please check user balance.</div>');
        }

        redirect(base_url('masters/walletadmin'));
    }

    /**
     * Save Points Settings
     */
    public function save_settings() {
        $settings = $this->input->post('settings');
        if (is_array($settings)) {
            foreach ($settings as $key => $val) {
                $this->walletmodel->set_setting($key, trim($val));
            }
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-success"><strong>Success!</strong> Points settings updated.</div>');
        }
        redirect(base_url('masters/walletadmin?tab=settings'));
    }
}
