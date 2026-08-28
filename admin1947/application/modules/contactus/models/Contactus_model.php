<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_stats() {
        $today = date('Y-m-d');
        $stats = array(
            'total'       => $this->db->count_all_results('contactus'),
            'pending'     => $this->db->where('status', 'PENDING')->count_all_results('contactus'),
            'replied'     => $this->db->where('status', 'REPLIED')->count_all_results('contactus'),
            'resolved'    => $this->db->where('status', 'RESOLVED')->count_all_results('contactus'),
            'today_count' => $this->db->where("(DATE(created_at) = '{$today}' OR DATE(date) = '{$today}')", NULL, FALSE)->count_all_results('contactus')
        );
        return $stats;
    }

    public function get_queries($status = null, $type = null, $date_filter = null, $limit = 1000, $offset = 0) {
        $this->db->select('*');
        $this->db->from('contactus');
        
        if (!empty($status) && $status !== 'ALL') {
            if ($status === 'RESOLVED_REPLIED' || $status === 'REPLIED_OR_RESOLVED') {
                $this->db->where_in('status', array('REPLIED', 'RESOLVED'));
            } else {
                $this->db->where('status', $status);
            }
        }
        if (!empty($type) && $type !== 'ALL') {
            $this->db->where('inquiry_type', $type);
        }
        if (!empty($date_filter) && strtoupper($date_filter) === 'TODAY') {
            $today = date('Y-m-d');
            $this->db->where("(DATE(created_at) = '{$today}' OR DATE(date) = '{$today}')", NULL, FALSE);
        }

        $this->db->order_by('id', 'DESC');
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }


    public function get_query_by_id($id) {
        return $this->db->get_where('contactus', array('id' => intval($id)))->row_array();
    }

    public function record_reply($id, $reply_text, $replied_by, $new_status = 'REPLIED') {
        $update_data = array(
            'admin_reply' => $reply_text,
            'replied_by'  => $replied_by,
            'replied_at'  => date('Y-m-d H:i:s'),
            'status'      => $new_status
        );
        $this->db->where('id', intval($id));
        return $this->db->update('contactus', $update_data);
    }

    public function update_status($id, $status) {
        $this->db->where('id', intval($id));
        return $this->db->update('contactus', array('status' => $status));
    }

    public function delete_query($id) {
        $this->db->where('id', intval($id));
        return $this->db->delete('contactus');
    }

    public function bulk_delete_queries(array $ids) {
        $clean_ids = array_filter(array_map('intval', $ids));
        if (empty($clean_ids)) {
            return 0;
        }
        $this->db->where_in('id', $clean_ids);
        $this->db->delete('contactus');
        return $this->db->affected_rows();
    }

    public function bulk_update_status(array $ids, $status) {
        $clean_ids = array_filter(array_map('intval', $ids));
        if (empty($clean_ids)) {
            return 0;
        }
        $this->db->where_in('id', $clean_ids);
        $this->db->update('contactus', array('status' => $status));
        return $this->db->affected_rows();
    }
}

