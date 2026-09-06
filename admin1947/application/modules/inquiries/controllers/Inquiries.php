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

        $this->load->helper(array('url', 'form', 'query_string_helper', 'dbquery_helper', 'admin_helper', 'fddi_helper'));
    }

    /**
     * Ensure inquiries table exists
     */
    protected function _ensure_table() {
        try {
            if ($this->db && !$this->db->table_exists('inquiries')) {
                $sql = "CREATE TABLE IF NOT EXISTS `inquiries` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `hospital_id` INT(11) NOT NULL DEFAULT 0,
                  `user_name` VARCHAR(255) DEFAULT NULL,
                  `user_email` VARCHAR(255) DEFAULT NULL,
                  `user_phone` VARCHAR(50) DEFAULT NULL,
                  `subject` VARCHAR(255) DEFAULT NULL,
                  `message` TEXT DEFAULT NULL,
                  `reply_message` TEXT DEFAULT NULL,
                  `status` VARCHAR(50) DEFAULT 'pending',
                  `created_at` DATETIME DEFAULT NULL,
                  `updated_at` DATETIME DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `idx_inq_hospital` (`hospital_id`),
                  KEY `idx_inq_status` (`status`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                $this->db->query($sql);
            }
        } catch (Throwable $e) {
            log_message('error', 'Error ensuring inquiries table: ' . $e->getMessage());
        }
    }

    /**
     * Master Hospital Inquiries Log & Management
     */
    public function index() {
        $this->_ensure_table();

        $status      = $this->input->get('status') ?: 'all';
        $hospital_id = intval($this->input->get('hospital_id'));
        $search      = trim($this->input->get('search') ?: '');

        $data['inquiries']     = array();
        $data['total_count']   = 0;
        $data['pending_count'] = 0;
        $data['replied_count'] = 0;
        $data['closed_count']  = 0;
        $data['hospitals']     = array();

        try {
            if ($this->db && $this->db->table_exists('inquiries')) {
                // Build Query with Hospital Join
                $has_hospital = $this->db->table_exists('hospital');
                if ($has_hospital) {
                    $this->db->select('inquiries.*, hospital.name as hospital_name, hospital.mobile as hospital_mobile, hospital.city as hospital_city');
                } else {
                    $this->db->select('inquiries.*, "" as hospital_name, "" as hospital_mobile, "" as hospital_city');
                }
                $this->db->from('inquiries');
                if ($has_hospital) {
                    $this->db->join('hospital', 'hospital.id = inquiries.hospital_id', 'left');
                }

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
                        ->or_like('inquiries.message', $search);
                    if ($has_hospital) {
                        $this->db->or_like('hospital.name', $search);
                    }
                    $this->db->group_end();
                }

                $this->db->order_by('inquiries.id', 'DESC');
                $q = $this->db->get();
                if ($q && is_object($q)) {
                    $data['inquiries'] = $q->result();
                }

                // Overall Global Statistics
                $data['total_count']   = $this->db->count_all_results('inquiries');
                $data['pending_count'] = $this->db->where('status', 'pending')->count_all_results('inquiries');
                $data['replied_count'] = $this->db->where('status', 'replied')->count_all_results('inquiries');
                $data['closed_count']  = $this->db->where('status', 'closed')->count_all_results('inquiries');
            }

            // Hospital list for dropdown
            if ($this->db && $this->db->table_exists('hospital')) {
                $hq = $this->db->select('id, name, city')->order_by('name', 'ASC')->get('hospital');
                if ($hq && is_object($hq)) {
                    $data['hospitals'] = $hq->result();
                }
            }
        } catch (Throwable $e) {
            log_message('error', 'Error fetching inquiries: ' . $e->getMessage());
        }

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
        $this->load->view('inc/table_footer');
    }

    /**
     * Submit or Update Response from Super Admin Console
     */
    public function reply() {
        $this->_ensure_table();
        $id            = intval($this->input->post('inquiry_id'));
        $reply_message = trim($this->input->post('reply_message', TRUE) ?: '');
        $status        = $this->input->post('status') ?: 'replied';

        if ($id > 0 && !empty($reply_message)) {
            if ($this->db && $this->db->table_exists('inquiries')) {
                $this->db->where('id', $id)->update('inquiries', array(
                    'reply_message' => $reply_message,
                    'status'        => $status,
                    'updated_at'    => date('Y-m-d H:i:s')
                ));
            }

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
        $this->_ensure_table();
        $id = intval($id);
        $allowed = array('pending', 'replied', 'closed');
        if (!in_array($new_status, $allowed)) {
            $new_status = 'closed';
        }

        if ($id > 0 && $this->db && $this->db->table_exists('inquiries')) {
            $this->db->where('id', $id)->update('inquiries', array(
                'status'     => $new_status,
                'updated_at' => date('Y-m-d H:i:s')
            ));
        }

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-check-circle'></i> Inquiry #{$id} status updated to <strong>" . ucfirst($new_status) . "</strong>.</div>");
        redirect(base_url('inquiries'));
    }

    /**
     * Delete Inquiry
     */
    public function delete($id = 0) {
        $this->_ensure_table();
        $id = intval($id);
        if ($id > 0 && $this->db && $this->db->table_exists('inquiries')) {
            $this->db->where('id', $id)->delete('inquiries');
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-trash'></i> Inquiry #{$id} deleted successfully.</div>");
        }
        redirect(base_url('inquiries'));
    }
}
