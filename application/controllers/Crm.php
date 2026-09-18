<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Enterprise CRM Controller - Upchar
 * Healthcare Partner Acquisition, BDE Pipeline, Dynamic Kanban & Client Relations
 */
class Crm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Crm_model');
        $this->load->helper(['url', 'form', 'text']);
        $this->load->library('admin_auth_guard');
        $this->admin_auth_guard->enforce_admin();
    }

    /**
     * Default index redirects to dashboard
     */
    public function index() {
        $this->dashboard();
    }

    /**
     * Enterprise CRM Command Hub (Dashboard)
     */
    public function dashboard() {
        $bdeId = ($this->session->userdata('staff_role') === 'bde') ? $this->session->userdata('staff_user_id') : null;
        
        $data['title']            = 'CRM Command Hub & Partner Growth - Upchar';
        $data['metrics']          = $this->Crm_model->get_bde_metrics($bdeId);
        $data['recent_leads']     = $this->Crm_model->get_leads($bdeId ? ['bde_id' => $bdeId] : [], 12);
        $data['stage_breakdown']  = $this->Crm_model->get_stage_breakdown($bdeId);
        $data['activities']       = $this->Crm_model->get_activities(null, 8);
        $data['followups_due']    = $this->Crm_model->get_followups_due($bdeId);
        $data['followups_radar']  = $this->Crm_model->get_followups_radar($bdeId, 30);
        $data['types_breakdown']  = $this->Crm_model->get_type_breakdown($bdeId);

        $this->load->view('hr/header', $data);
        $this->load->view('crm/dashboard', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Dynamic Kanban Pipeline Board
     */
    public function leads() {
        $bdeId = ($this->session->userdata('staff_role') === 'bde') ? $this->session->userdata('staff_user_id') : null;
        
        $data['title']       = 'Partner Acquisition Kanban Pipeline - Upchar';
        $data['kanban']      = $this->Crm_model->get_kanban_leads($bdeId);
        $data['metrics']     = $this->Crm_model->get_bde_metrics($bdeId);
        $data['followups']   = $this->Crm_model->get_followups_due($bdeId);

        $this->load->view('hr/header', $data);
        $this->load->view('crm/kanban', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Master Partner & Client Directory
     */
    public function contacts() {
        $bdeId = ($this->session->userdata('staff_role') === 'bde') ? $this->session->userdata('staff_user_id') : null;
        
        $filters = [];
        if ($bdeId) $filters['bde_id'] = $bdeId;
        if ($this->input->get('stage')) $filters['stage'] = $this->input->get('stage');
        if ($this->input->get('type')) $filters['facility_type'] = $this->input->get('type');
        if ($this->input->get('priority')) $filters['priority'] = $this->input->get('priority');
        if ($this->input->get('search')) $filters['search'] = $this->input->get('search');

        $data['title']       = 'Partner & Client Directory - Upchar CRM';
        $data['leads']       = $this->Crm_model->get_leads($filters, 200, 0);
        $data['metrics']     = $this->Crm_model->get_bde_metrics($bdeId);
        $data['filters']     = $filters;

        $this->load->view('hr/header', $data);
        $this->load->view('crm/contacts', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Activity Log & Follow-up Scheduler
     */
    public function activities() {
        $bdeId = ($this->session->userdata('staff_role') === 'bde') ? $this->session->userdata('staff_user_id') : null;
        
        $data['title']         = 'CRM Activity Log & Follow-ups - Upchar';
        $data['activities']    = $this->Crm_model->get_activities(null, 100);
        $data['followups_due'] = $this->Crm_model->get_followups_due($bdeId);
        $data['leads_dropdown']= $this->Crm_model->get_leads($bdeId ? ['bde_id' => $bdeId] : [], 100);
        $data['metrics']       = $this->Crm_model->get_bde_metrics($bdeId);

        $this->load->view('hr/header', $data);
        $this->load->view('crm/activities', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Dedicated Follow-up Radar & Action Telemetry Console
     */
    public function radar() {
        $bdeId = ($this->session->userdata('staff_role') === 'bde') ? $this->session->userdata('staff_user_id') : null;
        
        $data['title']          = 'Follow-up Radar & Action Console - Upchar CRM';
        $data['metrics']        = $this->Crm_model->get_bde_metrics($bdeId);
        $data['followups_due']  = $this->Crm_model->get_followups_due($bdeId);
        $data['all_radar']      = $this->Crm_model->get_followups_radar($bdeId, 100);
        $data['leads_dropdown'] = $this->Crm_model->get_leads($bdeId ? ['bde_id' => $bdeId] : [], 100);

        $this->load->view('hr/header', $data);
        $this->load->view('crm/radar', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Save / Add New Partner Lead (AJAX & Form POST support)
     */
    public function save_lead() {
        $isAjax = $this->input->is_ajax_request();
        $bdeId  = $this->session->userdata('staff_user_id') ?: 1;

        $name     = trim($this->input->post('facility_name', TRUE));
        $type     = $this->input->post('facility_type', TRUE) ?: 'clinic';
        $person   = trim($this->input->post('contact_person', TRUE));
        $phone    = trim($this->input->post('phone', TRUE));
        $email    = trim($this->input->post('email', TRUE));
        $city     = trim($this->input->post('city', TRUE)) ?: 'Lucknow';
        $source   = trim($this->input->post('source', TRUE)) ?: 'Direct Visit';
        $priority = $this->input->post('priority', TRUE) ?: 'medium';
        $stage    = $this->input->post('lead_stage', TRUE) ?: 'new';
        $rev      = floatval($this->input->post('est_monthly_revenue') ?: 0);
        $comm     = floatval($this->input->post('commission_pct') ?: 10);
        $followup = $this->input->post('next_followup_date', TRUE);
        $notes    = trim($this->input->post('notes', TRUE));

        if (empty($name) || empty($phone)) {
            if ($isAjax) {
                echo json_encode(['status' => 'error', 'message' => 'Partner facility name and phone number are required.']);
                return;
            }
            $this->session->set_flashdata('error_msg', 'Facility name and contact phone are required.');
            redirect('admin1947/crm/leads');
            return;
        }

        $leadData = [
            'bde_id'              => $bdeId,
            'facility_name'       => $name,
            'facility_type'       => $type,
            'contact_person'      => $person,
            'phone'               => $phone,
            'email'               => $email,
            'city'                => $city,
            'source'              => $source,
            'priority'            => $priority,
            'lead_stage'          => $stage,
            'est_monthly_revenue' => $rev,
            'commission_pct'      => $comm,
            'next_followup_date'  => !empty($followup) ? $followup : null,
            'notes'               => $notes
        ];

        $id = $this->Crm_model->create_lead($leadData);

        // Auto-log initial activity
        $this->Crm_model->log_activity([
            'lead_id'       => $id,
            'staff_id'      => $bdeId,
            'activity_type' => 'note',
            'summary'       => 'Partner Lead Created',
            'notes'         => !empty($notes) ? $notes : "Created by " . $this->session->userdata('staff_name'),
            'followup_date' => !empty($followup) ? $followup : null,
            'status'        => 'completed'
        ]);

        if ($isAjax) {
            echo json_encode([
                'status'  => 'success',
                'lead_id' => $id,
                'message' => "Partner '{$name}' has been successfully registered!"
            ]);
            return;
        }

        $this->session->set_flashdata('success_msg', "Partner '{$name}' added to CRM pipeline!");
        redirect('admin1947/crm/leads');
    }

    /**
     * AJAX: Move Lead Stage with instant real-time response
     */
    public function update_stage() {
        $leadId   = intval($this->input->post('lead_id'));
        $newStage = $this->input->post('stage', TRUE);
        $notes    = trim($this->input->post('notes', TRUE));
        $staffId  = $this->session->userdata('staff_user_id');

        $allowed = ['new', 'contacted', 'meeting_scheduled', 'proposal_sent', 'signed', 'lost'];
        if (!in_array($newStage, $allowed) || !$leadId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid stage or lead parameters.']);
            return;
        }

        $updated = $this->Crm_model->update_stage($leadId, $newStage, $notes, $staffId);

        if ($updated) {
            $stageNames = [
                'new'               => 'New Inquiries',
                'contacted'         => 'Contacted / Pitching',
                'meeting_scheduled' => 'Meeting Fixed',
                'proposal_sent'     => 'Proposal Sent',
                'signed'            => 'MoU Signed Partner',
                'lost'              => 'Cold / Lost'
            ];
            echo json_encode([
                'status'     => 'success',
                'stage'      => $newStage,
                'stage_name' => $stageNames[$newStage] ?? $newStage,
                'message'    => 'Lead moved to ' . ($stageNames[$newStage] ?? $newStage)
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lead could not be updated.']);
        }
    }

    /**
     * AJAX: Log Activity / Follow-up Note
     */
    public function log_activity() {
        $leadId       = intval($this->input->post('lead_id'));
        $actType      = $this->input->post('activity_type', TRUE) ?: 'call';
        $summary      = trim($this->input->post('summary', TRUE));
        $notes        = trim($this->input->post('notes', TRUE));
        $followupDate = $this->input->post('followup_date', TRUE);
        $status       = $this->input->post('status', TRUE) ?: 'completed';
        $staffId      = $this->session->userdata('staff_user_id');

        if (!$leadId || empty($summary)) {
            echo json_encode(['status' => 'error', 'message' => 'Lead selection and summary are required.']);
            return;
        }

        $actId = $this->Crm_model->log_activity([
            'lead_id'       => $leadId,
            'staff_id'      => $staffId,
            'activity_type' => $actType,
            'summary'       => $summary,
            'notes'         => $notes,
            'followup_date' => !empty($followupDate) ? $followupDate : null,
            'status'        => $status
        ]);

        echo json_encode([
            'status'      => 'success',
            'activity_id' => $actId,
            'message'     => 'Activity logged successfully!'
        ]);
    }

    /**
     * AJAX: Fetch single lead info for quick inspection
     */
    public function get_lead_json() {
        $leadId = intval($this->input->get('id'));
        $lead = $this->Crm_model->get_lead_by_id($leadId);
        if (!$lead) {
            echo json_encode(['status' => 'error', 'message' => 'Lead not found.']);
            return;
        }
        $activities = $this->Crm_model->get_activities($leadId, 10);
        echo json_encode([
            'status'     => 'success',
            'lead'       => $lead,
            'activities' => $activities
        ]);
    }

    /**
     * Convert Signed Lead into Registered Healthcare Provider
     */
    public function onboard_partner($leadId) {
        $lead = $this->Crm_model->get_lead_by_id($leadId);
        if (!$lead) {
            redirect('admin1947/crm/leads');
            return;
        }
        $data['title'] = 'Onboard Healthcare Partner - Upchar CRM';
        $data['lead']  = $lead;

        $this->load->view('hr/header', $data);
        $this->load->view('crm/partner_onboard', $data);
        $this->load->view('hr/footer');
    }
}
