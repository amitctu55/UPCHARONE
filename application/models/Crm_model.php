<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Enterprise CRM Model - Upchar
 * Partner Acquisition Pipeline, Kanban Stages, Dynamic Funnels & Activity Logging
 */
class Crm_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get All Leads or Filter by BDE, Stage, Type, Priority, Search
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
        if (!empty($filters['priority'])) {
            $this->db->where('l.priority', $filters['priority']);
        }
        if (!empty($filters['city'])) {
            $this->db->like('l.city', $filters['city']);
        }
        if (!empty($filters['search'])) {
            $s = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('l.facility_name', $s);
            $this->db->or_like('l.contact_person', $s);
            $this->db->or_like('l.phone', $s);
            $this->db->or_like('l.city', $s);
            $this->db->or_like('l.email', $s);
            $this->db->group_end();
        }

        $this->db->order_by('l.id', 'DESC');
        return $this->db->get('', $limit, $offset)->result_array();
    }

    /**
     * Count leads with filters
     */
    public function count_leads($filters = []) {
        $this->db->from('staff_crm_leads l');
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
            $s = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('l.facility_name', $s);
            $this->db->or_like('l.contact_person', $s);
            $this->db->or_like('l.phone', $s);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    /**
     * Get single lead by ID with BDE details
     */
    public function get_lead_by_id($leadId) {
        $this->db->select('l.*, u.name as bde_name, u.staff_code as bde_code, u.phone as bde_phone');
        $this->db->from('staff_crm_leads l');
        $this->db->join('staff_users u', 'u.id = l.bde_id', 'left');
        $this->db->where('l.id', intval($leadId));
        return $this->db->get()->row_array();
    }

    /**
     * Get Leads Grouped by Kanban Stages with column sums
     */
    public function get_kanban_leads($bdeId = null) {
        $filters = [];
        if ($bdeId) $filters['bde_id'] = $bdeId;
        $allLeads = $this->get_leads($filters, 300, 0);

        $stages = [
            'new' => [
                'title' => 'New Inquiries',
                'badge_color' => '#64748b',
                'badge_bg' => '#f1f5f9',
                'icon' => 'fa-star-o',
                'total_rev' => 0,
                'items' => []
            ],
            'contacted' => [
                'title' => 'Contacted / Pitching',
                'badge_color' => '#0284c7',
                'badge_bg' => '#e0f2fe',
                'icon' => 'fa-phone',
                'total_rev' => 0,
                'items' => []
            ],
            'meeting_scheduled' => [
                'title' => 'Demo / Meeting Fixed',
                'badge_color' => '#d97706',
                'badge_bg' => '#fef3c7',
                'icon' => 'fa-calendar',
                'total_rev' => 0,
                'items' => []
            ],
            'proposal_sent' => [
                'title' => 'Proposal Sent',
                'badge_color' => '#8b5cf6',
                'badge_bg' => '#f3e8ff',
                'icon' => 'fa-file-text-o',
                'total_rev' => 0,
                'items' => []
            ],
            'signed' => [
                'title' => 'MoU Signed / Active',
                'badge_color' => '#10b981',
                'badge_bg' => '#d1fae5',
                'icon' => 'fa-check-circle',
                'total_rev' => 0,
                'items' => []
            ],
            'lost' => [
                'title' => 'Cold / Lost',
                'badge_color' => '#ef4444',
                'badge_bg' => '#fee2e2',
                'icon' => 'fa-times-circle',
                'total_rev' => 0,
                'items' => []
            ]
        ];

        foreach ($allLeads as $lead) {
            $st = $lead['lead_stage'] ?: 'new';
            if (!isset($stages[$st])) {
                $st = 'new';
            }
            $stages[$st]['items'][] = $lead;
            $stages[$st]['total_rev'] += floatval($lead['est_monthly_revenue']);
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
     * Update Lead
     */
    public function update_lead($leadId, $data) {
        $this->db->where('id', intval($leadId));
        return $this->db->update('staff_crm_leads', $data);
    }

    /**
     * Update Lead Stage & Auto-log Note
     */
    public function update_stage($leadId, $newStage, $notes = '', $staffId = null) {
        $existing = $this->db->get_where('staff_crm_leads', ['id' => intval($leadId)])->row_array();
        if (!$existing) return false;

        $updateData = ['lead_stage' => $newStage];
        if (!empty($notes)) {
            $formattedNote = date('d M Y, h:i A') . " [Stage: " . strtoupper(str_replace('_', ' ', $newStage)) . "] " . $notes;
            $updateData['notes'] = !empty($existing['notes']) ? $formattedNote . "\n" . $existing['notes'] : $formattedNote;
        }

        $this->db->where('id', intval($leadId))->update('staff_crm_leads', $updateData);

        // Auto-log activity
        $this->db->insert('staff_crm_activities', [
            'lead_id' => intval($leadId),
            'staff_id' => $staffId,
            'activity_type' => 'note',
            'summary' => 'Stage shifted from ' . strtoupper(str_replace('_', ' ', $existing['lead_stage'])) . ' to ' . strtoupper(str_replace('_', ' ', $newStage)),
            'notes' => $notes ?: 'Status updated in pipeline.',
            'status' => 'completed'
        ]);

        return true;
    }

    /**
     * Log Activity (Call, Meeting, Site Visit, Note, etc.)
     */
    public function log_activity($data) {
        $this->db->insert('staff_crm_activities', $data);
        $actId = $this->db->insert_id();

        // If activity has followup_date, update the lead's next_followup_date
        if (!empty($data['followup_date']) && !empty($data['lead_id'])) {
            $this->db->where('id', intval($data['lead_id']))
                     ->update('staff_crm_leads', ['next_followup_date' => $data['followup_date']]);
        }

        return $actId;
    }

    /**
     * Get Activities list with Lead and Staff info
     */
    public function get_activities($leadId = null, $limit = 50) {
        $this->db->select('a.*, l.facility_name, l.facility_type, l.contact_person, l.phone as lead_phone, l.lead_stage, u.name as staff_name');
        $this->db->from('staff_crm_activities a');
        $this->db->join('staff_crm_leads l', 'l.id = a.lead_id', 'inner');
        $this->db->join('staff_users u', 'u.id = a.staff_id', 'left');

        if ($leadId) {
            $this->db->where('a.lead_id', intval($leadId));
        }

        $this->db->order_by('a.id', 'DESC');
        return $this->db->get('', $limit)->result_array();
    }

    /**
     * Get Follow-ups Scheduled for Today or Overdue
     */
    public function get_followups_due($bdeId = null) {
        $today = date('Y-m-d');
        $this->db->select('l.*, u.name as bde_name');
        $this->db->from('staff_crm_leads l');
        $this->db->join('staff_users u', 'u.id = l.bde_id', 'left');
        $this->db->where('l.next_followup_date <=', $today);
        $this->db->where_not_in('l.lead_stage', ['signed', 'lost']);
        if ($bdeId) {
            $this->db->where('l.bde_id', $bdeId);
        }
        $this->db->order_by('l.next_followup_date', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Get Executive CRM Metrics
     */
    public function get_bde_metrics($bdeId = null) {
        // Total leads
        $this->db->from('staff_crm_leads');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $totalLeads = $this->db->count_all_results();

        // Signed partners
        $this->db->from('staff_crm_leads');
        $this->db->where('lead_stage', 'signed');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $signedCount = $this->db->count_all_results();

        // In-pipeline leads (not signed and not lost)
        $this->db->from('staff_crm_leads');
        $this->db->where_not_in('lead_stage', ['signed', 'lost']);
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $activePipelineCount = $this->db->count_all_results();

        // Total signed revenue
        $this->db->select_sum('est_monthly_revenue');
        $this->db->where('lead_stage', 'signed');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $resSigned = $this->db->get('staff_crm_leads')->row();
        $signedRevenue = $resSigned ? floatval($resSigned->est_monthly_revenue) : 0.00;

        // Active pipeline estimated value
        $this->db->select_sum('est_monthly_revenue');
        $this->db->where_not_in('lead_stage', ['lost']);
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $resPipeline = $this->db->get('staff_crm_leads')->row();
        $totalPipelineValue = $resPipeline ? floatval($resPipeline->est_monthly_revenue) : 0.00;

        // Conversion rate
        $conversionRate = ($totalLeads > 0) ? round(($signedCount / $totalLeads) * 100, 1) : 0.0;

        // Followups due today or overdue
        $today = date('Y-m-d');
        $this->db->from('staff_crm_leads');
        $this->db->where('next_followup_date <=', $today);
        $this->db->where_not_in('lead_stage', ['signed', 'lost']);
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $followupsDue = $this->db->count_all_results();

        // Total activities
        $totalActivities = $this->db->count_all('staff_crm_activities');

        return [
            'total_leads'           => $totalLeads,
            'signed_partners'       => $signedCount,
            'active_pipeline_count' => $activePipelineCount,
            'signed_revenue'        => $signedRevenue,
            'total_pipeline_value'  => $totalPipelineValue,
            'conversion_rate'       => $conversionRate,
            'followups_due'         => $followupsDue,
            'total_activities'      => $totalActivities
        ];
    }

    /**
     * Get Stage Distribution & Value for Funnel Chart
     */
    public function get_stage_breakdown($bdeId = null) {
        $this->db->select('lead_stage, COUNT(*) as count, SUM(est_monthly_revenue) as total_val');
        $this->db->from('staff_crm_leads');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $this->db->group_by('lead_stage');
        $results = $this->db->get()->result_array();

        $stages = [
            'new'               => ['label' => 'New Inquiries', 'count' => 0, 'val' => 0, 'color' => '#64748b'],
            'contacted'         => ['label' => 'Contacted / Pitching', 'count' => 0, 'val' => 0, 'color' => '#0284c7'],
            'meeting_scheduled' => ['label' => 'Demo / Meeting Fixed', 'count' => 0, 'val' => 0, 'color' => '#d97706'],
            'proposal_sent'     => ['label' => 'Proposal Dispatched', 'count' => 0, 'val' => 0, 'color' => '#8b5cf6'],
            'signed'            => ['label' => 'MoU Signed Partner', 'count' => 0, 'val' => 0, 'color' => '#10b981'],
            'lost'              => ['label' => 'Lost / Dropped', 'count' => 0, 'val' => 0, 'color' => '#ef4444']
        ];

        foreach ($results as $r) {
            $st = $r['lead_stage'];
            if (isset($stages[$st])) {
                $stages[$st]['count'] = intval($r['count']);
                $stages[$st]['val'] = floatval($r['total_val']);
            }
        }

        return $stages;
    }

    /**
     * Get Facility Types Distribution
     */
    public function get_type_breakdown($bdeId = null) {
        $this->db->select('facility_type, COUNT(*) as count');
        $this->db->from('staff_crm_leads');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $this->db->group_by('facility_type');
        return $this->db->get()->result_array();
    }
}
