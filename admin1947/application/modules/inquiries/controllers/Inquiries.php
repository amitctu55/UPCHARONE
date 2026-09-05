<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiries extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");

        // Auth check for Super Admin
        if (!$this->session->userdata('adminuserid') && !$this->session->userdata('userid') && !$this->session->userdata('username')) {
            redirect(base_url('login'));
        }

        $this->load->helper(array('url', 'form', 'query_string_helper', 'dbquery_helper', 'admin_helper'));
    }

    /**
     * Master Hospital Inquiries Log & Management
     */
    public function index() {
        $status      = $this->input->get('status') ?: 'all';
        $hospital_id = intval($this->input->get('hospital_id'));
        $search      = trim($this->input->get('search') ?: '');

        // Build Query with Hospital Join
        $this->db->select('inquiries.*, hospital.name as hospital_name, hospital.mobile as hospital_mobile, hospital.city as hospital_city');
        $this->db->from('inquiries');
        $this->db->join('hospital', 'hospital.id = inquiries.hospital_id', 'left');

        if ($status !== 'all' && !empty($status)) {
            $this->db->where('inquiries.status', $status);
        }

        if ($hospital_id > 0) {
            $this->db->where('inquiries.hospital_id', $hospital_id);
        }

        if (!empty($search)) {
            $this->db->group_start()
                ->like('inquiries.user_name', $search)
                ->or_like('inquiries.user_phone', $search)
                ->or_like('inquiries.user_email', $search)
                ->or_like('inquiries.subject', $search)
                ->or_like('inquiries.message', $search)
                ->or_like('hospital.name', $search)
            ->group_end();
        }

        $this->db->order_by('inquiries.id', 'DESC');
        $data['inquiries'] = $this->db->get()->result();

        // Overall Global Statistics
        $data['total_count']   = $this->db->count_all_results('inquiries');
        $data['pending_count'] = $this->db->where('status', 'pending')->count_all_results('inquiries');
        $data['replied_count'] = $this->db->where('status', 'replied')->count_all_results('inquiries');
        $data['closed_count']  = $this->db->where('status', 'closed')->count_all_results('inquiries');

        // Hospital list for dropdown
        $data['hospitals'] = $this->db->select('id, name, city')->order_by('name', 'ASC')->get('hospital')->result();

        $data['selected_status']      = $status;
        $data['selected_hospital_id'] = $hospital_id;
        $data['search_keyword']       = $search;

        // Load AdminLTE Layout
        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('inquiries_list', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
    }

    /**
     * Submit or Update Response from Super Admin Console
     */
    public function reply() {
        $id            = intval($this->input->post('inquiry_id'));
        $reply_message = trim($this->input->post('reply_message', TRUE) ?: '');
        $status        = $this->input->post('status') ?: 'replied';

        if ($id > 0 && !empty($reply_message)) {
            $this->db->where('id', $id)->update('inquiries', array(
                'reply_message' => $reply_message,
                'status'        => $status,
                'updated_at'    => date('Y-m-d H:i:s')
            ));

            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-check-circle'></i> Response documented successfully for Inquiry #{$id}!</div>");
        } else {
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-warning' style='border-radius: 8px; margin: 15px 0;'>Please enter a reply message.</div>");
        }

        redirect(base_url('inquiries'));
    }

    /**
     * Update Inquiry Status
     */
    public function update_status($id = 0, $new_status = 'closed') {
        $id = intval($id);
        $allowed = array('pending', 'replied', 'closed');
        if (!in_array($new_status, $allowed)) {
            $new_status = 'closed';
        }

        $this->db->where('id', $id)->update('inquiries', array(
            'status'     => $new_status,
            'updated_at' => date('Y-m-d H:i:s')
        ));

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-check-circle'></i> Inquiry #{$id} status updated to <strong>" . ucfirst($new_status) . "</strong>.</div>");
        redirect(base_url('inquiries'));
    }

    /**
     * Delete Inquiry
     */
    public function delete($id = 0) {
        $id = intval($id);
        if ($id > 0) {
            $this->db->where('id', $id)->delete('inquiries');
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-trash'></i> Inquiry #{$id} deleted successfully.</div>");
        }
        redirect(base_url('inquiries'));
    }
}
