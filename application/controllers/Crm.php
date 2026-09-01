<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CRM Controller
 * Business Development Executive (BDE) Pipeline & Partner Acquisition CRM
 */
class Crm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Crm_model');
        $this->load->helper(['url', 'form']);
        $this->_check_auth();
    }

    private function _check_auth() {
        // Bridge SSO: If logged into Admin1947, auto-authorize as super_admin
        if ($this->session->userdata('adminuserid') || $this->session->userdata('username')) {
            if (!$this->session->userdata('staff_user_id')) {
                $superAdmin = $this->db->get_where('staff_users', ['role' => 'super_admin', 'status' => 'active'])->row_array();
                if ($superAdmin) {
                    $this->session->set_userdata([
                        'staff_user_id' => $superAdmin['id'],
                        'staff_code'    => $superAdmin['staff_code'],
                        'staff_name'    => $superAdmin['name'],
                        'staff_role'    => 'super_admin',
                        'staff_dept'    => $superAdmin['department']
                    ]);
                }
            }
            return;
        }

        $staffId = $this->session->userdata('staff_user_id');
        $role    = $this->session->userdata('staff_role');
        if (!$staffId || !in_array($role, ['bde', 'super_admin', 'hr'])) {
            $this->session->set_flashdata('error_msg', 'Access restricted to BDE Leads & Administrators.');
            redirect('staff/login');
        }
    }

    /**
     * BDE Revenue & Pipeline Dashboard
     */
    public function dashboard() {
        $bdeId = ($this->session->userdata('staff_role') === 'bde') ? $this->session->userdata('staff_user_id') : null;
        $data['metrics'] = $this->Crm_model->get_bde_metrics($bdeId);
        $data['recent_leads'] = $this->Crm_model->get_leads($bdeId ? ['bde_id' => $bdeId] : [], 10);

        $this->load->view('crm/header', $data);
        $this->load->view('crm/dashboard', $data);
        $this->load->view('crm/footer');
    }

    /**
     * Interactive Kanban Lead Pipeline
     */
    public function leads() {
        $bdeId = ($this->session->userdata('staff_role') === 'bde') ? $this->session->userdata('staff_user_id') : null;
        $data['kanban']  = $this->Crm_model->get_kanban_leads($bdeId);
        $data['metrics'] = $this->Crm_model->get_bde_metrics($bdeId);

        $this->load->view('crm/header', $data);
        $this->load->view('crm/kanban', $data);
        $this->load->view('crm/footer');
    }

    /**
     * Save New Partner Lead
     */
    public function save_lead() {
        $bdeId = $this->session->userdata('staff_user_id');
        $name  = trim($this->input->post('facility_name', TRUE));
        $type  = $this->input->post('facility_type', TRUE) ?: 'clinic';
        $person= trim($this->input->post('contact_person', TRUE));
        $phone = trim($this->input->post('phone', TRUE));
        $email = trim($this->input->post('email', TRUE));
        $city  = trim($this->input->post('city', TRUE)) ?: 'Lucknow';
        $rev   = floatval($this->input->post('est_monthly_revenue') ?: 0);
        $comm  = floatval($this->input->post('commission_pct') ?: 10);
        $notes = trim($this->input->post('notes', TRUE));

        if (empty($name) || empty($phone)) {
            $this->session->set_flashdata('error_msg', 'Facility name and contact phone are required.');
            redirect('crm/leads');
            return;
        }

        $id = $this->Crm_model->create_lead([
            'bde_id'              => $bdeId,
            'facility_name'       => $name,
            'facility_type'       => $type,
            'contact_person'      => $person,
            'phone'               => $phone,
            'email'               => $email,
            'city'                => $city,
            'lead_stage'          => 'new',
            'est_monthly_revenue' => $rev,
            'commission_pct'      => $comm,
            'notes'               => $notes
        ]);

        $this->session->set_flashdata('success_msg', "Lead '{$name}' added to your Kanban pipeline!");
        redirect('crm/leads');
    }

    /**
     * AJAX: Move Lead Stage
     */
    public function update_stage() {
        $leadId   = intval($this->input->post('lead_id'));
        $newStage = $this->input->post('stage', TRUE);
        $notes    = trim($this->input->post('notes', TRUE));

        $allowed = ['new', 'contacted', 'meeting_scheduled', 'proposal_sent', 'signed', 'lost'];
        if (!in_array($newStage, $allowed) || !$leadId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid stage parameter']);
            return;
        }

        $this->Crm_model->update_stage($leadId, $newStage, $notes);
        echo json_encode([
            'status'  => 'success',
            'message' => 'Lead moved to ' . strtoupper(str_replace('_', ' ', $newStage))
        ]);
    }

    /**
     * Convert Signed Lead into Registered Healthcare Provider
     */
    public function onboard_partner($leadId) {
        $lead = $this->db->get_where('staff_crm_leads', ['id' => $leadId])->row_array();
        if (!$lead) {
            redirect('crm/leads');
            return;
        }
        $data['lead'] = $lead;
        $this->load->view('crm/header', $data);
        $this->load->view('crm/partner_onboard', $data);
        $this->load->view('crm/footer');
    }
}
