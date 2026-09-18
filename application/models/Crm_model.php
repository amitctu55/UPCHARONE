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
        $this->_ensure_tables();
    }

    /**
     * Auto-create and migrate required tables for CRM & Partner Suite
     */
    private function _ensure_tables() {
        try {
            // 1. staff_users Table (fallback ensure)
            $this->db->query("CREATE TABLE IF NOT EXISTS `staff_users` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `staff_code` VARCHAR(30) UNIQUE NOT NULL,
                `name` VARCHAR(120) NOT NULL,
                `email` VARCHAR(120) UNIQUE NOT NULL,
                `phone` VARCHAR(20) UNIQUE NOT NULL,
                `password_hash` VARCHAR(255) NOT NULL,
                `role` ENUM('super_admin', 'hr', 'bde', 'collector', 'office_staff') NOT NULL DEFAULT 'office_staff',
                `department` VARCHAR(80) DEFAULT 'Operations',
                `designation` VARCHAR(80) DEFAULT 'Staff',
                `base_salary` DECIMAL(10,2) DEFAULT 25000.00,
                `assigned_area` VARCHAR(100) DEFAULT 'Lucknow Central',
                `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // 2. staff_crm_leads Table
            $this->db->query("CREATE TABLE IF NOT EXISTS `staff_crm_leads` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `bde_id` INT NULL DEFAULT NULL,
                `facility_name` VARCHAR(150) NOT NULL,
                `facility_type` ENUM('hospital', 'clinic', 'diagnostic_lab', 'pharmacy') DEFAULT 'clinic',
                `contact_person` VARCHAR(100) NOT NULL,
                `phone` VARCHAR(20) NOT NULL,
                `email` VARCHAR(100) NULL,
                `address` TEXT NULL,
                `city` VARCHAR(80) DEFAULT 'Lucknow',
                `source` VARCHAR(60) DEFAULT 'Direct Visit',
                `priority` ENUM('urgent', 'high', 'medium', 'low') DEFAULT 'medium',
                `lead_stage` ENUM('new', 'contacted', 'meeting_scheduled', 'proposal_sent', 'signed', 'lost') DEFAULT 'new',
                `est_monthly_revenue` DECIMAL(10,2) DEFAULT 0.00,
                `commission_pct` DECIMAL(5,2) DEFAULT 10.00,
                `next_followup_date` DATE NULL,
                `notes` TEXT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY `idx_bde_stage` (`bde_id`, `lead_stage`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // 3. staff_crm_activities Table
            $this->db->query("CREATE TABLE IF NOT EXISTS `staff_crm_activities` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `lead_id` INT NOT NULL,
                `staff_id` INT NULL DEFAULT NULL,
                `activity_type` ENUM('call', 'meeting', 'site_visit', 'whatsapp', 'email', 'proposal', 'note') DEFAULT 'call',
                `summary` VARCHAR(255) NOT NULL,
                `notes` TEXT NULL,
                `followup_date` DATE NULL,
                `status` ENUM('completed', 'scheduled') DEFAULT 'completed',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                KEY `idx_lead_id` (`lead_id`),
                KEY `idx_staff_id` (`staff_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // 4. Ensure extra columns exist in staff_crm_leads if created previously without them
            if ($this->db->table_exists('staff_crm_leads')) {
                $fields = $this->db->list_fields('staff_crm_leads');
                if (!in_array('source', $fields)) {
                    @$this->db->query("ALTER TABLE `staff_crm_leads` ADD COLUMN `source` VARCHAR(60) DEFAULT 'Direct Visit' AFTER `city`;");
                }
                if (!in_array('priority', $fields)) {
                    @$this->db->query("ALTER TABLE `staff_crm_leads` ADD COLUMN `priority` ENUM('urgent', 'high', 'medium', 'low') DEFAULT 'medium' AFTER `source`;");
                }
                if (!in_array('est_monthly_revenue', $fields)) {
                    @$this->db->query("ALTER TABLE `staff_crm_leads` ADD COLUMN `est_monthly_revenue` DECIMAL(10,2) DEFAULT 0.00 AFTER `lead_stage`;");
                }
                if (!in_array('commission_pct', $fields)) {
                    @$this->db->query("ALTER TABLE `staff_crm_leads` ADD COLUMN `commission_pct` DECIMAL(5,2) DEFAULT 10.00 AFTER `est_monthly_revenue`;");
                }
                if (!in_array('next_followup_date', $fields)) {
                    @$this->db->query("ALTER TABLE `staff_crm_leads` ADD COLUMN `next_followup_date` DATE NULL AFTER `commission_pct`;");
                }
            }

            // 5. Seed initial demo data if table is completely empty
            if ($this->db->table_exists('staff_crm_leads') && $this->db->count_all('staff_crm_leads') === 0) {
                $initialLeads = [
                    [
                        'bde_id'              => 1,
                        'facility_name'       => 'Medanta Super Specialty OPD Clinic',
                        'facility_type'       => 'clinic',
                        'contact_person'      => 'Dr. Rajesh Khanna',
                        'phone'               => '9876543210',
                        'email'               => 'drkhanna@medanta.org',
                        'city'                => 'Lucknow',
                        'source'              => 'Direct Visit',
                        'priority'            => 'urgent',
                        'lead_stage'          => 'meeting_scheduled',
                        'est_monthly_revenue' => 45000.00,
                        'commission_pct'      => 12.00,
                        'next_followup_date'  => date('Y-m-d'),
                        'notes'               => 'Discussion on digital doctor appointment integration and pathology collection handoff.'
                    ],
                    [
                        'bde_id'              => 1,
                        'facility_name'       => 'Awadh Pathology & Imaging Center',
                        'facility_type'       => 'diagnostic_lab',
                        'contact_person'      => 'Mr. Sanjay Verma',
                        'phone'               => '9811223344',
                        'email'               => 'sanjay@awadhpath.com',
                        'city'                => 'Lucknow',
                        'source'              => 'Referral',
                        'priority'            => 'high',
                        'lead_stage'          => 'proposal_sent',
                        'est_monthly_revenue' => 85000.00,
                        'commission_pct'      => 15.00,
                        'next_followup_date'  => date('Y-m-d', strtotime('+1 day')),
                        'notes'               => 'Proposal sent for home blood collection route dispatch and API integration.'
                    ],
                    [
                        'bde_id'              => 1,
                        'facility_name'       => 'Charak Multi-Speciality Hospital',
                        'facility_type'       => 'hospital',
                        'contact_person'      => 'Dr. Anita Roy',
                        'phone'               => '9722334455',
                        'email'               => 'anita.roy@charak.in',
                        'city'                => 'Lucknow',
                        'source'              => 'Cold Call',
                        'priority'            => 'urgent',
                        'lead_stage'          => 'signed',
                        'est_monthly_revenue' => 120000.00,
                        'commission_pct'      => 10.00,
                        'next_followup_date'  => null,
                        'notes'               => 'MoU signed for 50-bed admission management and 24x7 emergency listing.'
                    ],
                    [
                        'bde_id'              => 1,
                        'facility_name'       => 'Sanjeevani Care Pharmacy & Surgical',
                        'facility_type'       => 'pharmacy',
                        'contact_person'      => 'Mr. Ramesh Gupta',
                        'phone'               => '9933445566',
                        'email'               => 'sanjeevani@gmail.com',
                        'city'                => 'Lucknow',
                        'source'              => 'Field Outreach',
                        'priority'            => 'medium',
                        'lead_stage'          => 'contacted',
                        'est_monthly_revenue' => 30000.00,
                        'commission_pct'      => 8.00,
                        'next_followup_date'  => date('Y-m-d'),
                        'notes'               => 'Medicine delivery integration and digitized billing onboarding.'
                    ],
                    [
                        'bde_id'              => 1,
                        'facility_name'       => 'Apollo Diagnostics Satellite Center',
                        'facility_type'       => 'diagnostic_lab',
                        'contact_person'      => 'Dr. Amit Trivedi',
                        'phone'               => '9655443322',
                        'email'               => 'atrivedi@apollodiag.com',
                        'city'                => 'Lucknow',
                        'source'              => 'Direct Visit',
                        'priority'            => 'high',
                        'lead_stage'          => 'new',
                        'est_monthly_revenue' => 60000.00,
                        'commission_pct'      => 14.00,
                        'next_followup_date'  => date('Y-m-d', strtotime('+2 days')),
                        'notes'               => 'New inbound lead interested in corporate health checkup camp collaborations.'
                    ]
                ];

                foreach ($initialLeads as $lead) {
                    $this->db->insert('staff_crm_leads', $lead);
                    $lid = $this->db->insert_id();
                    if ($lid && $this->db->table_exists('staff_crm_activities')) {
                        $this->db->insert('staff_crm_activities', [
                            'lead_id'       => $lid,
                            'staff_id'      => 1,
                            'activity_type' => 'note',
                            'summary'       => 'Initial lead profile registered in Upchar CRM',
                            'notes'         => $lead['notes'],
                            'status'        => 'completed'
                        ]);
                    }
                }
            }
        } catch (Throwable $e) {
            log_message('error', 'Crm_model ensure_tables failed: ' . $e->getMessage());
        }
    }

    /**
     * Get All Leads or Filter by BDE, Stage, Type, Priority, Search
     */
    public function get_leads($filters = [], $limit = 100, $offset = 0) {
        if (!$this->db->table_exists('staff_crm_leads')) return [];

        $this->db->select('l.*, u.name as bde_name, u.staff_code as bde_code');
        $this->db->from('staff_crm_leads l');
        if ($this->db->table_exists('staff_users')) {
            $this->db->join('staff_users u', 'u.id = l.bde_id', 'left');
        }

        if (!empty($filters['bde_id'])) {
            $this->db->where('l.bde_id', $filters['bde_id']);
        }
        if (!empty($filters['stage'])) {
            $this->db->where('l.lead_stage', $filters['stage']);
        }
        if (!empty($filters['facility_type'])) {
            $this->db->where('l.facility_type', $filters['facility_type']);
        }
        if (!empty($filters['priority']) && $this->db->field_exists('priority', 'staff_crm_leads')) {
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
        $q = $this->db->get('', $limit, $offset);
        return ($q && is_object($q)) ? $q->result_array() : [];
    }

    /**
     * Count leads with filters
     */
    public function count_leads($filters = []) {
        if (!$this->db->table_exists('staff_crm_leads')) return 0;

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
        if (!empty($filters['priority']) && $this->db->field_exists('priority', 'staff_crm_leads')) {
            $this->db->where('l.priority', $filters['priority']);
        }
        if (!empty($filters['search'])) {
            $s = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('l.facility_name', $s);
            $this->db->or_like('l.contact_person', $s);
            $this->db->or_like('l.phone', $s);
            $this->db->group_end();
        }
        return (int)$this->db->count_all_results();
    }

    /**
     * Get single lead by ID with BDE details
     */
    public function get_lead_by_id($leadId) {
        if (!$this->db->table_exists('staff_crm_leads')) return null;

        $this->db->select('l.*, u.name as bde_name, u.staff_code as bde_code, u.phone as bde_phone');
        $this->db->from('staff_crm_leads l');
        if ($this->db->table_exists('staff_users')) {
            $this->db->join('staff_users u', 'u.id = l.bde_id', 'left');
        }
        $this->db->where('l.id', intval($leadId));
        $q = $this->db->get();
        return ($q && is_object($q)) ? $q->row_array() : null;
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
            $st = $lead['lead_stage'] ?? 'new';
            if (!isset($stages[$st])) {
                $st = 'new';
            }
            $stages[$st]['items'][] = $lead;
            $stages[$st]['total_rev'] += floatval($lead['est_monthly_revenue'] ?? 0);
        }

        return $stages;
    }

    /**
     * Create Lead
     */
    public function create_lead($data) {
        if (!$this->db->table_exists('staff_crm_leads')) return false;
        $this->db->insert('staff_crm_leads', $data);
        return $this->db->insert_id();
    }

    /**
     * Update Lead
     */
    public function update_lead($leadId, $data) {
        if (!$this->db->table_exists('staff_crm_leads')) return false;
        $this->db->where('id', intval($leadId));
        return $this->db->update('staff_crm_leads', $data);
    }

    /**
     * Update Lead Stage & Auto-log Note
     */
    public function update_stage($leadId, $newStage, $notes = '', $staffId = null) {
        if (!$this->db->table_exists('staff_crm_leads')) return false;

        $existing = $this->db->get_where('staff_crm_leads', ['id' => intval($leadId)])->row_array();
        if (!$existing) return false;

        $updateData = ['lead_stage' => $newStage];
        if (!empty($notes)) {
            $formattedNote = date('d M Y, h:i A') . " [Stage: " . strtoupper(str_replace('_', ' ', $newStage)) . "] " . $notes;
            $updateData['notes'] = !empty($existing['notes']) ? $formattedNote . "\n" . $existing['notes'] : $formattedNote;
        }

        $this->db->where('id', intval($leadId))->update('staff_crm_leads', $updateData);

        // Auto-log activity
        if ($this->db->table_exists('staff_crm_activities')) {
            $this->db->insert('staff_crm_activities', [
                'lead_id'       => intval($leadId),
                'staff_id'      => $staffId,
                'activity_type' => 'note',
                'summary'       => 'Stage shifted from ' . strtoupper(str_replace('_', ' ', $existing['lead_stage'] ?? 'new')) . ' to ' . strtoupper(str_replace('_', ' ', $newStage)),
                'notes'         => $notes ?: 'Status updated in pipeline.',
                'status'        => 'completed'
            ]);
        }

        return true;
    }

    /**
     * Log Activity (Call, Meeting, Site Visit, Note, etc.)
     */
    public function log_activity($data) {
        if (!$this->db->table_exists('staff_crm_activities')) return false;

        $this->db->insert('staff_crm_activities', $data);
        $actId = $this->db->insert_id();

        // If activity has followup_date, update the lead's next_followup_date
        if (!empty($data['followup_date']) && !empty($data['lead_id']) && $this->db->table_exists('staff_crm_leads')) {
            $this->db->where('id', intval($data['lead_id']))
                     ->update('staff_crm_leads', ['next_followup_date' => $data['followup_date']]);
        }

        return $actId;
    }

    /**
     * Get Activities list with Lead and Staff info
     */
    public function get_activities($leadId = null, $limit = 50) {
        if (!$this->db->table_exists('staff_crm_activities') || !$this->db->table_exists('staff_crm_leads')) {
            return [];
        }

        $this->db->select('a.*, l.facility_name, l.facility_type, l.contact_person, l.phone as lead_phone, l.lead_stage, u.name as staff_name');
        $this->db->from('staff_crm_activities a');
        $this->db->join('staff_crm_leads l', 'l.id = a.lead_id', 'inner');
        if ($this->db->table_exists('staff_users')) {
            $this->db->join('staff_users u', 'u.id = a.staff_id', 'left');
        }

        if ($leadId) {
            $this->db->where('a.lead_id', intval($leadId));
        }

        $this->db->order_by('a.id', 'DESC');
        $q = $this->db->get('', $limit);
        return ($q && is_object($q)) ? $q->result_array() : [];
    }

    /**
     * Get Follow-ups Scheduled for Today or Overdue
     */
    public function get_followups_due($bdeId = null) {
        if (!$this->db->table_exists('staff_crm_leads')) return [];

        $today = date('Y-m-d');
        $this->db->select('l.*, u.name as bde_name');
        $this->db->from('staff_crm_leads l');
        if ($this->db->table_exists('staff_users')) {
            $this->db->join('staff_users u', 'u.id = l.bde_id', 'left');
        }
        $this->db->where('l.next_followup_date <=', $today);
        $this->db->where('l.next_followup_date IS NOT NULL');
        $this->db->where('l.next_followup_date !=', '0000-00-00');
        $this->db->where_not_in('l.lead_stage', ['signed', 'lost']);
        if ($bdeId) {
            $this->db->where('l.bde_id', $bdeId);
        }
        $this->db->order_by('l.next_followup_date', 'ASC');
        $q = $this->db->get();
        return ($q && is_object($q)) ? $q->result_array() : [];
    }

    /**
     * Get Executive CRM Metrics
     */
    public function get_bde_metrics($bdeId = null) {
        if (!$this->db->table_exists('staff_crm_leads')) {
            return [
                'total_leads'           => 0,
                'signed_partners'       => 0,
                'active_pipeline_count' => 0,
                'signed_revenue'        => 0.00,
                'total_pipeline_value'  => 0.00,
                'conversion_rate'       => 0.0,
                'followups_due'         => 0,
                'total_activities'      => 0
            ];
        }

        // Total leads
        $this->db->from('staff_crm_leads');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $totalLeads = (int)$this->db->count_all_results();

        // Signed partners
        $this->db->from('staff_crm_leads');
        $this->db->where('lead_stage', 'signed');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $signedCount = (int)$this->db->count_all_results();

        // In-pipeline leads (not signed and not lost)
        $this->db->from('staff_crm_leads');
        $this->db->where_not_in('lead_stage', ['signed', 'lost']);
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $activePipelineCount = (int)$this->db->count_all_results();

        // Total signed revenue
        $this->db->select_sum('est_monthly_revenue');
        $this->db->where('lead_stage', 'signed');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $resSigned = $this->db->get('staff_crm_leads');
        $signedRow = ($resSigned && is_object($resSigned)) ? $resSigned->row() : null;
        $signedRevenue = $signedRow ? floatval($signedRow->est_monthly_revenue) : 0.00;

        // Active pipeline estimated value
        $this->db->select_sum('est_monthly_revenue');
        $this->db->where_not_in('lead_stage', ['lost']);
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $resPipeline = $this->db->get('staff_crm_leads');
        $pipelineRow = ($resPipeline && is_object($resPipeline)) ? $resPipeline->row() : null;
        $totalPipelineValue = $pipelineRow ? floatval($pipelineRow->est_monthly_revenue) : 0.00;

        // Conversion rate
        $conversionRate = ($totalLeads > 0) ? round(($signedCount / $totalLeads) * 100, 1) : 0.0;

        // Followups due today or overdue
        $today = date('Y-m-d');
        $this->db->from('staff_crm_leads');
        $this->db->where('next_followup_date <=', $today);
        $this->db->where('next_followup_date IS NOT NULL');
        $this->db->where('next_followup_date !=', '0000-00-00');
        $this->db->where_not_in('lead_stage', ['signed', 'lost']);
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $followupsDue = (int)$this->db->count_all_results();

        // Total activities
        $totalActivities = 0;
        if ($this->db->table_exists('staff_crm_activities')) {
            $totalActivities = (int)$this->db->count_all('staff_crm_activities');
        }

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
        $stages = [
            'new'               => ['label' => 'New Inquiries', 'count' => 0, 'val' => 0, 'color' => '#64748b'],
            'contacted'         => ['label' => 'Contacted / Pitching', 'count' => 0, 'val' => 0, 'color' => '#0284c7'],
            'meeting_scheduled' => ['label' => 'Demo / Meeting Fixed', 'count' => 0, 'val' => 0, 'color' => '#d97706'],
            'proposal_sent'     => ['label' => 'Proposal Dispatched', 'count' => 0, 'val' => 0, 'color' => '#8b5cf6'],
            'signed'            => ['label' => 'MoU Signed Partner', 'count' => 0, 'val' => 0, 'color' => '#10b981'],
            'lost'              => ['label' => 'Lost / Dropped', 'count' => 0, 'val' => 0, 'color' => '#ef4444']
        ];

        if (!$this->db->table_exists('staff_crm_leads')) {
            return $stages;
        }

        $this->db->select('lead_stage, COUNT(*) as count, SUM(est_monthly_revenue) as total_val');
        $this->db->from('staff_crm_leads');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $this->db->group_by('lead_stage');
        $q = $this->db->get();
        $results = ($q && is_object($q)) ? $q->result_array() : [];

        foreach ($results as $r) {
            $st = $r['lead_stage'] ?? 'new';
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
        if (!$this->db->table_exists('staff_crm_leads')) return [];

        $this->db->select('facility_type, COUNT(*) as count');
        $this->db->from('staff_crm_leads');
        if ($bdeId) $this->db->where('bde_id', $bdeId);
        $this->db->group_by('facility_type');
        $q = $this->db->get();
        return ($q && is_object($q)) ? $q->result_array() : [];
    }
}
