<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BDE CRM Model
 * Partner Acquisition Pipeline, Kanban Stages & Revenue Metrics
 */
class Crm_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get All Leads or Filter by BDE / Stage
     */
    public function get_leads($filters = [], $limit = 100, $offset = 0) {
        $this->db->select('l.*, u.name as bde_name, u.staff_code as bde_code');
        $this->db->from('staff_crm_leads l');
        $this->db->join('staff_users u', 'u.id = l.bde_id', 'left');

        if (!empty($filters['bde_id'])) {
            $this->db->where('l.bde_id', $filters['bde_id']);
        }
        if (!empty($filters['stage'])) {
            $this->db->where('l.lead_stage', $filters['stage']);
        }
        if (!empty($filters['facility_type'])) {
            $this->db->where('l.facility_type', $filters['facility_type']);
        }
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start();
            $this->db->like('l.facility_name', $s);
            $this->db->or_like('l.contact_person', $s);
            $this->db->or_like('l.phone', $s);
            $this->db->or_like('l.city', $s);
            $this->db->group_end();
        }

        $this->db->order_by('l.id', 'DESC');
        return $this->db->get('', $limit, $offset)->result_array();
    }

    /**
     * Get Leads grouped by Kanban Stages
     */
    public function get_kanban_leads($bdeId = null) {
        $filters = [];
        if ($bdeId) $filters['bde_id'] = $bdeId;
        $allLeads = $this->get_leads($filters, 200, 0);

        $stages = [
            'new'               => ['title' => 'New Leads', 'color' => '#64748b', 'items' => []],
            'contacted'         => ['title' => 'Contacted', 'color' => '#0284c7', 'items' => []],
            'meeting_scheduled' => ['title' => 'Meeting Fixed', 'color' => '#d97706', 'items' => []],
            'proposal_sent'     => ['title' => 'Proposal Sent', 'color' => '#8b5cf6', 'items' => []],
            'signed'            => ['title' => 'Partner Signed 🎉', 'color' => '#10b981', 'items' => []],
            'lost'              => ['title' => 'Lost / Inactive', 'color' => '#ef4444', 'items' => []]
        ];

        foreach ($allLeads as $lead) {
            $st = $lead['lead_stage'] ?: 'new';
            if (isset($stages[$st])) {
                $stages[$st]['items'][] = $lead;
            } else {
                $stages['new']['items'][] = $lead;
            }
        }

        return $stages;
    }

    /**
     * Create Lead
     */
    public function create_lead($data) {
        $this->db->insert('staff_crm_leads', $data);
        return $this->db->insert_id();
    }

    /**
     * Update Lead Stage
     */
    public function update_stage($leadId, $newStage, $notes = '') {
        $data = ['lead_stage' => $newStage];
        if (!empty($notes)) {
            $existing = $this->db->get_where('staff_crm_leads', ['id' => $leadId])->row_array();
            $data['notes'] = ($existing && $existing['notes'] ? $existing['notes'] . " | " : "") . date('d M: ') . $notes;
        }
        $this->db->where('id', $leadId)->update('staff_crm_leads', $data);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Get BDE Revenue & Performance Metrics
     */
    public function get_bde_metrics($bdeId = null) {
        $this->db->from('staff_crm_leads');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $totalLeads = $this->db->count_all_results();

        $this->db->from('staff_crm_leads');
        $this->db->where('lead_stage', 'signed');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $signedCount = $this->db->count_all_results();

        $this->db->select_sum('est_monthly_revenue');
        $this->db->where('lead_stage', 'signed');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $res = $this->db->get('staff_crm_leads')->row();
        $signedRevenue = $res ? floatval($res->est_monthly_revenue) : 0.00;

        $conversionRate = ($totalLeads > 0) ? round(($signedCount / $totalLeads) * 100, 1) : 0.0;

        return [
            'total_leads'     => $totalLeads,
            'signed_partners' => $signedCount,
            'signed_revenue'  => $signedRevenue,
            'conversion_rate' => $conversionRate
        ];
    }
}
