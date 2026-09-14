<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dedicated Recruitment & ATS Controller
 * Multi-page architecture for Job Requisitions, Candidate Pipeline Tabs, and Dossiers
 */
class Recruitment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Recruitment_model');
        $this->load->model('Staff_model');
        $this->load->helper(['url', 'form']);
        $this->_check_auth();
    }

    private function _check_auth() {
        if (!$this->session->userdata('staff_user_id')) {
            $defaultStaff = $this->db->where('status', 'active')->where_in('role', ['super_admin', 'hr'])->order_by('id', 'asc')->get('staff_users')->row_array();
            if ($defaultStaff) {
                $this->session->set_userdata([
                    'staff_user_id' => $defaultStaff['id'],
                    'staff_code'    => $defaultStaff['staff_code'],
                    'staff_name'    => $defaultStaff['name'],
                    'staff_email'   => $defaultStaff['email'],
                    'staff_role'    => $defaultStaff['role'],
                    'staff_dept'    => $defaultStaff['department']
                ]);
            }
        }

        $staffId = $this->session->userdata('staff_user_id');
        $role    = $this->session->userdata('staff_role');
        if (!$staffId || !in_array($role, ['hr', 'super_admin'])) {
            $this->session->set_flashdata('error_msg', 'Access restricted to HR Managers & Administrators.');
            redirect('staff/login');
        }
    }

    /**
     * Default index redirects to Candidate Pipeline
     */
    public function index() {
        redirect('hr/candidates');
    }

    /**
     * 1. Job Requisitions Page (/hr/jobs or /recruitment/jobs)
     */
    public function jobs() {
        $data['jobs'] = $this->Recruitment_model->get_all_jobs();
        $data['active_count'] = 0;
        $data['total_openings'] = 0;
        $data['total_applicants'] = 0;

        foreach ($data['jobs'] as $j) {
            if ($j['status'] === 'active') {
                $data['active_count']++;
                $data['total_openings'] += intval($j['openings']);
            }
            $data['total_applicants'] += intval($j['total_applicants']);
        }

        $this->load->view('hr/header', $data);
        $this->load->view('hr/jobs', $data);
        $this->load->view('hr/footer');
    }

    /**
     * 2. Candidate Pipeline Page (/hr/candidates/{stage} or /recruitment/candidates/{stage})
     */
    public function candidates($stage = 'all') {
        $stage = strtolower(trim($stage));
        $valid_stages = ['all', 'applied', 'screened', 'interviewing', 'offered', 'hired', 'rejected'];
        if (!in_array($stage, $valid_stages)) {
            $stage = 'all';
        }

        $job_id = $this->input->get('job_id') ? intval($this->input->get('job_id')) : null;
        $search = $this->input->get('q', TRUE);

        $data['current_stage'] = $stage;
        $data['selected_job_id'] = $job_id;
        $data['search_query'] = $search;
        
        $data['stage_counts'] = $this->Recruitment_model->get_stage_counts($job_id);
        $data['candidates'] = $this->Recruitment_model->get_candidates($stage, $job_id, $search);
        $data['jobs'] = $this->Recruitment_model->get_all_jobs('active');

        // If filtered by a single job, get job details
        $data['selected_job'] = $job_id ? $this->Recruitment_model->get_job_by_id($job_id) : null;

        $this->load->view('hr/header', $data);
        $this->load->view('hr/candidates', $data);
        $this->load->view('hr/footer');
    }

    /**
     * 3. Candidate Profile / Dossier Page (/hr/candidate_profile/{id})
     */
    public function profile($id = null) {
        $id = intval($id);
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Candidate ID is required.');
            redirect('hr/candidates');
            return;
        }

        $data['candidate'] = $this->Recruitment_model->get_candidate_by_id($id);
        if (empty($data['candidate'])) {
            $this->session->set_flashdata('error_msg', 'Candidate dossier not found.');
            redirect('hr/candidates');
            return;
        }

        $data['jobs'] = $this->Recruitment_model->get_all_jobs('active');
        $data['staff_roles'] = ['Doctor', 'Nurse', 'Pathology Lab Tech', 'Radiology Tech', 'Pharmacist', 'Receptionist / Front Desk', 'HR Executive', 'Operations Lead', 'Driver / Fleet Support', 'Support Staff'];
        $data['departments'] = ['Clinical Services', 'Diagnostics & Lab', 'Nursing Care', 'Pharmacy', 'Operations & Admin', 'Emergency & Fleet', 'Human Resources', 'Finance & Billing'];

        $this->load->view('hr/header', $data);
        $this->load->view('hr/candidate_profile', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Save / Post New Job Requisition
     */
    public function save_job() {
        $job_id = intval($this->input->post('job_id'));
        $title = trim($this->input->post('title', TRUE));
        $department = trim($this->input->post('department', TRUE)) ?: 'Operations & Admin';
        $job_type = trim($this->input->post('job_type', TRUE)) ?: 'Full Time';
        $location = trim($this->input->post('location', TRUE)) ?: 'Gorakhpur, UP';
        $experience_required = trim($this->input->post('experience_required', TRUE)) ?: '1-3 Years';
        $openings = intval($this->input->post('openings')) ?: 1;
        $salary_range = trim($this->input->post('salary_range', TRUE)) ?: 'Negotiable';
        $description = trim($this->input->post('description', TRUE));
        $requirements = trim($this->input->post('requirements', TRUE));
        $status = in_array($this->input->post('status'), ['active', 'closed']) ? $this->input->post('status') : 'active';

        if (empty($title)) {
            $resp = ['status' => 'error', 'message' => 'Job title is mandatory.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('hr/jobs');
            return;
        }

        $saveData = [
            'title' => $title,
            'department' => $department,
            'job_type' => $job_type,
            'location' => $location,
            'experience_required' => $experience_required,
            'openings' => $openings,
            'salary_range' => $salary_range,
            'description' => $description,
            'requirements' => $requirements,
            'status' => $status
        ];

        if ($job_id > 0) {
            $this->Recruitment_model->update_job($job_id, $saveData);
            $msg = "Job requisition '{$title}' updated successfully.";
        } else {
            $job_id = $this->Recruitment_model->save_job($saveData);
            $msg = "New job requisition '{$title}' posted successfully.";
        }

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg, 'job_id' => $job_id]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        redirect('hr/jobs');
    }

    /**
     * Toggle Job Status (active <-> closed)
     */
    public function toggle_job_status() {
        $job_id = intval($this->input->post('job_id') ?: $this->input->get('job_id'));
        if ($job_id > 0) {
            $this->Recruitment_model->toggle_job_status($job_id);
            $msg = "Requisition status updated.";
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'success', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('success_msg', $msg);
        }
        redirect('hr/jobs');
    }

    /**
     * Save New Candidate
     */
    public function save_candidate() {
        $name = trim($this->input->post('name', TRUE));
        $email = trim($this->input->post('email', TRUE));
        $mobile = trim($this->input->post('mobile', TRUE));
        $job_id = intval($this->input->post('job_id'));
        $designation = trim($this->input->post('designation', TRUE));
        $qualification = trim($this->input->post('qualification', TRUE));
        $experience = trim($this->input->post('experience', TRUE));
        $message = trim($this->input->post('message', TRUE));
        $stage = strtolower(trim($this->input->post('status_stage', TRUE) ?: 'applied'));

        if (empty($name) || empty($mobile)) {
            $resp = ['status' => 'error', 'message' => 'Candidate name and mobile number are required.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('hr/candidates');
            return;
        }

        // Auto assign designation from job if empty
        if (empty($designation) && $job_id > 0) {
            $job = $this->Recruitment_model->get_job_by_id($job_id);
            if ($job) $designation = $job['title'];
        }

        $saveData = [
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'job_id' => $job_id ?: null,
            'designation' => $designation,
            'qualification' => $qualification,
            'experience' => $experience,
            'message' => $message,
            'status' => 1,
            'status_stage' => in_array($stage, ['applied', 'screened', 'interviewing', 'offered', 'hired', 'rejected']) ? $stage : 'applied',
            'creat_date' => date('Y-m-d'),
            'applied_at' => date('Y-m-d H:i:s')
        ];

        $candidate_id = $this->Recruitment_model->save_candidate($saveData);
        $msg = "Candidate {$name} added to pipeline successfully.";

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg, 'candidate_id' => $candidate_id]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        redirect('hr/candidate_profile/' . $candidate_id);
    }

    /**
     * Advance Candidate Stage
     */
    public function update_stage() {
        $candidate_id = intval($this->input->post('career_id') ?: $this->input->post('candidate_id'));
        $target_stage = strtolower(trim($this->input->post('status_stage') ?: $this->input->post('target_stage')));
        $note = trim($this->input->post('stage_note', TRUE));
        $author = $this->session->userdata('staff_name') ?: 'HR Lead';

        $valid = ['applied', 'screened', 'interviewing', 'offered', 'hired', 'rejected'];
        if (!$candidate_id || !in_array($target_stage, $valid)) {
            $resp = ['status' => 'error', 'message' => 'Invalid candidate ID or target stage.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('hr/candidates');
            return;
        }

        $this->Recruitment_model->update_candidate_stage($candidate_id, $target_stage, $note, $author);
        $msg = "Candidate advanced to " . ucfirst($target_stage) . " stage.";

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg, 'stage' => $target_stage]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        $redirect_to = $this->input->post('redirect_to') ?: ('hr/candidate_profile/' . $candidate_id);
        redirect($redirect_to);
    }

    /**
     * Add HR Timeline Note
     */
    public function add_note() {
        $candidate_id = intval($this->input->post('candidate_id'));
        $note_text = trim($this->input->post('note_text', TRUE));
        $author = $this->session->userdata('staff_name') ?: 'HR Lead';
        $stage = trim($this->input->post('stage', TRUE)) ?: 'interviewing';

        if (!$candidate_id || empty($note_text)) {
            $resp = ['status' => 'error', 'message' => 'Note content cannot be empty.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('hr/candidate_profile/' . $candidate_id);
            return;
        }

        $this->Recruitment_model->add_candidate_note($candidate_id, $note_text, $author, $stage);
        $msg = "Interview/evaluation note recorded.";

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        redirect('hr/candidate_profile/' . $candidate_id);
    }

    /**
     * 1-Click Onboard Candidate to Staff Directory
     */
    public function onboard_to_staff() {
        $candidate_id = intval($this->input->post('career_id') ?: $this->input->post('candidate_id'));
        $candidate = $this->Recruitment_model->get_candidate_by_id($candidate_id);

        if (!$candidate) {
            $resp = ['status' => 'error', 'message' => 'Candidate record not found.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('hr/candidates');
            return;
        }

        $name = trim($this->input->post('name', TRUE)) ?: $candidate['name'];
        $empCode = trim($this->input->post('employee_id', TRUE)) ?: ('UP-EMP-' . date('Y') . '-' . rand(100, 999));
        $dept = trim($this->input->post('department', TRUE)) ?: ($candidate['job_department'] ?: 'Operations & Admin');
        $desig = trim($this->input->post('designation', TRUE)) ?: ($candidate['designation'] ?: ($candidate['job_title'] ?: 'Staff'));
        $salary = trim($this->input->post('basic_salary', TRUE)) ?: '25000';
        $doj = trim($this->input->post('date_of_joining', TRUE)) ?: date('Y-m-d');
        $gender = trim($this->input->post('gender', TRUE)) ?: 'Male';
        $workExp = trim($this->input->post('work_exp', TRUE)) ?: ($candidate['experience'] ?: '1 Year');
        $qual = trim($this->input->post('qualification', TRUE)) ?: ($candidate['qualification'] ?: 'Graduate');

        $staffData = [
            'name' => $name,
            'employee_id' => $empCode,
            'department' => $dept,
            'designation' => $desig,
            'qualification' => $qual,
            'work_exp' => $workExp,
            'contact_no' => $candidate['mobile'],
            'email' => $candidate['email'],
            'gender' => $gender,
            'basic_salary' => $salary,
            'date_of_joining' => $doj,
            'is_active' => 1,
            'note' => 'Onboarded directly from Recruitment ATS pipeline.'
        ];

        $res = $this->Recruitment_model->onboard_candidate_to_staff($candidate_id, $staffData);

        if (!$res['status']) {
            if ($this->input->is_ajax_request()) { echo json_encode(['status' => 'error', 'message' => $res['message']]); return; }
            $this->session->set_flashdata('error_msg', $res['message']);
            redirect('hr/candidate_profile/' . $candidate_id);
            return;
        }

        $msg = "Candidate {$name} successfully onboarded into Staff Directory with Employee ID {$empCode}!";

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg, 'employee_id' => $empCode]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        redirect('hr/candidate_profile/' . $candidate_id);
    }

    /**
     * Delete Candidate
     */
    public function delete_candidate() {
        $candidate_id = intval($this->input->post('candidate_id'));
        if ($candidate_id > 0) {
            $this->Recruitment_model->delete_candidate($candidate_id);
            $msg = "Candidate record removed.";
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'success', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('success_msg', $msg);
        }
        redirect('hr/candidates');
    }
}
