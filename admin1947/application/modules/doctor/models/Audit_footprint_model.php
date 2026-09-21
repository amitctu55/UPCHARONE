<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_footprint_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Log an immutable audit footprint
     *
     * @param string $entity_type 'lab', 'test_mapping', 'booking', 'specimen', 'master_test'
     * @param int $entity_id
     * @param string $action 'CREATED', 'UPDATED', 'PRICE_CHANGED', 'STATUS_UPDATED', 'HANDOVER', 'CREDENTIALS_PROVISIONED', 'DELETED'
     * @param mixed $before Array or object of state prior to change
     * @param mixed $after Array or object of state after change
     * @param string $remarks Human readable summary
     * @return int Inserted ID
     */
    public function log_footprint($entity_type, $entity_id, $action, $before = null, $after = null, $remarks = '') {
        $userId = $this->session->userdata('user_id') 
            ? $this->session->userdata('user_id') 
            : ($this->session->userdata('admin_id') ? $this->session->userdata('admin_id') : 1);

        $userRole = $this->session->userdata('role') 
            ? $this->session->userdata('role') 
            : ($this->session->userdata('user_role') ? $this->session->userdata('user_role') : 'super_admin');

        $ip = $this->input->ip_address();
        $userAgent = $this->input->user_agent();

        $data = array(
            'entity_type'    => strtolower(trim($entity_type)),
            'entity_id'      => (int)$entity_id,
            'action'         => strtoupper(trim($action)),
            'user_id'        => (int)$userId,
            'user_role'      => $userRole,
            'ip_address'     => $ip ? $ip : '127.0.0.1',
            'user_agent'     => $userAgent ? substr($userAgent, 0, 500) : 'CLI/Browser',
            'payload_before' => $before ? json_encode($before, JSON_UNESCAPED_UNICODE) : null,
            'payload_after'  => $after ? json_encode($after, JSON_UNESCAPED_UNICODE) : null,
            'remarks'        => $remarks ? substr($remarks, 0, 255) : null,
            'created_at'     => date('Y-m-d H:i:s')
        );

        $this->db->insert('system_audit_footprints', $data);
        return $this->db->insert_id();
    }

    /**
     * Get paginated footprints with optional filters
     */
    public function get_footprints($limit = 50, $offset = 0, $filters = array()) {
        $this->db->from('system_audit_footprints');

        if (!empty($filters['entity_type'])) {
            $this->db->where('entity_type', strtolower($filters['entity_type']));
        }
        if (!empty($filters['entity_id'])) {
            $this->db->where('entity_id', (int)$filters['entity_id']);
        }
        if (!empty($filters['action'])) {
            $this->db->where('action', strtoupper($filters['action']));
        }
        if (!empty($filters['from_date'])) {
            $this->db->where('created_at >=', $filters['from_date'] . ' 00:00:00');
        }
        if (!empty($filters['to_date'])) {
            $this->db->where('created_at <=', $filters['to_date'] . ' 23:59:59');
        }
        if (!empty($filters['keyword'])) {
            $kw = $this->db->escape_str($filters['keyword']);
            $this->db->where("(remarks LIKE '%{$kw}%' OR ip_address LIKE '%{$kw}%' OR user_role LIKE '%{$kw}%')");
        }

        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count total footprints matching filter
     */
    public function count_footprints($filters = array()) {
        $this->db->from('system_audit_footprints');

        if (!empty($filters['entity_type'])) {
            $this->db->where('entity_type', strtolower($filters['entity_type']));
        }
        if (!empty($filters['entity_id'])) {
            $this->db->where('entity_id', (int)$filters['entity_id']);
        }
        if (!empty($filters['action'])) {
            $this->db->where('action', strtoupper($filters['action']));
        }
        if (!empty($filters['from_date'])) {
            $this->db->where('created_at >=', $filters['from_date'] . ' 00:00:00');
        }
        if (!empty($filters['to_date'])) {
            $this->db->where('created_at <=', $filters['to_date'] . ' 23:59:59');
        }
        if (!empty($filters['keyword'])) {
            $kw = $this->db->escape_str($filters['keyword']);
            $this->db->where("(remarks LIKE '%{$kw}%' OR ip_address LIKE '%{$kw}%' OR user_role LIKE '%{$kw}%')");
        }

        return $this->db->count_all_results();
    }
}
