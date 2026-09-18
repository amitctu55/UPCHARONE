<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * HR Controller
 * Staff Directory, Leave Approval Engine & Automated Payroll Roster
 */
class Hr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Hr_model');
        $this->load->model('Attendance_model');
        $this->load->model('Recruitment_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('admin_auth_guard');
        $this->admin_auth_guard->enforce_admin();
    }

    /**
     * HR Command Dashboard
     */
    public function dashboard() {
        $today = date('Y-m-d');
        $data['all_staff']      = $this->Staff_model->get_all_staff([], 100);
        $data['daily_roster']   = $this->Attendance_model->get_daily_roster($today);
        $data['pending_leaves'] = $this->Hr_model->get_leaves(['status' => 'pending'], 10);
        
        $data['total_staff']   = count($data['all_staff']);
        $data['today_present'] = 0;
        $data['today_late']    = 0;
        foreach ($data['daily_roster'] as $r) {
            if ($r['attendance_status'] === 'present') $data['today_present']++;
            if ($r['attendance_status'] === 'late') $data['today_late']++;
        }

        $data['jobs'] = $this->Recruitment_model->get_all_jobs();

        $this->load->view('hr/header', $data);
        $this->load->view('hr/dashboard', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Staff Directory Alias for /hr/directory
     */
    public function directory() {
        $this->employees();
    }

    /**
     * HR & Recruitment Portal (ATS Workflow)
     */
    public function recruitment() {
        $stage  = $this->input->get('stage', TRUE);
        $jobId  = intval($this->input->get('job_id'));
        $search = trim($this->input->get('search', TRUE));

        // Fetch all job postings
        $jobs = $this->db->order_by('job_id', 'DESC')->get('career_jobs')->result_array();

        // Calculate applicant counts per job
        $jobCounts = [];
        $jobCountsQuery = $this->db->select('job_id, count(*) as total_candidates')->group_by('job_id')->get('career')->result_array();
        foreach ($jobCountsQuery as $jc) {
            $jobCounts[$jc['job_id']] = intval($jc['total_candidates']);
        }
        foreach ($jobs as &$j) {
            $j['candidate_count'] = $jobCounts[$j['job_id']] ?? 0;
        }
        unset($j);
        $data['jobs'] = $jobs;

        // Build query for applicants
        $this->db->select('c.*, cj.title as job_title, cj.department as job_dept, cj.location as job_loc')
                 ->from('career c')
                 ->join('career_jobs cj', 'cj.job_id = c.job_id', 'left')
                 ->order_by('c.career_id', 'DESC');

        if (!empty($stage)) {
            $this->db->where('c.status_stage', $stage);
        }
        if ($jobId > 0) {
            $this->db->where('c.job_id', $jobId);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('c.name', $search);
            $this->db->or_like('c.email', $search);
            $this->db->or_like('c.mobile', $search);
            $this->db->or_like('c.qualification', $search);
            $this->db->or_like('c.designation', $search);
            $this->db->or_like('cj.title', $search);
            $this->db->group_end();
        }

        $data['applicants'] = $this->db->get()->result_array();
        $data['selected_stage']  = $stage;
        $data['selected_job_id'] = $jobId;
        $data['search_keyword']  = $search;

        // Calculate ATS funnel stages
        $totalApps = $this->db->count_all('career');
        $activeJobsCount = $this->db->where('status', 'active')->count_all_results('career_jobs');

        $data['counts'] = [
            'total_jobs'        => count($data['jobs']),
            'active_jobs'       => $activeJobsCount,
            'total_applicants'  => $totalApps,
            'applied'           => $this->db->where('status_stage', 'applied')->or_where('status_stage IS NULL')->count_all_results('career'),
            'screened'          => $this->db->where('status_stage', 'screened')->count_all_results('career'),
            'interview'         => $this->db->where('status_stage', 'interview_scheduled')->count_all_results('career'),
            'offered'           => $this->db->where('status_stage', 'offered')->count_all_results('career'),
            'hired'             => $this->db->where('status_stage', 'hired')->count_all_results('career'),
            'rejected'          => $this->db->where('status_stage', 'rejected')->count_all_results('career'),
        ];

        $this->load->view('hr/header', $data);
        $this->load->view('hr/recruitment', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Post or Update Job Requisition
     */
    public function save_job() {
        $jobId       = intval($this->input->post('job_id'));
        $title       = trim($this->input->post('title', TRUE));
        $department  = trim($this->input->post('department', TRUE)) ?: 'Operations & Admin';
        $jobType     = $this->input->post('job_type', TRUE) ?: 'Full Time';
        $location    = trim($this->input->post('location', TRUE)) ?: 'Gorakhpur, UP';
        $experience  = trim($this->input->post('experience_required', TRUE)) ?: '1-3 Years';
        $openings    = intval($this->input->post('openings') ?: 1);
        $salaryRange = trim($this->input->post('salary_range', TRUE)) ?: 'Best in Industry / Negotiable';
        $description = trim($this->input->post('description', TRUE));
        $requirements= trim($this->input->post('requirements', TRUE));
        $status      = in_array($this->input->post('status'), ['active', 'closed']) ? $this->input->post('status') : 'active';
        $redirectTo  = $this->input->post('redirect_to') ?: 'admin1947/hr/jobs';

        if (empty($title)) {
            $resp = ['status' => 'error', 'message' => 'Job Requisition Title is required.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('admin1947/hr/jobs');
            return;
        }

        $jobData = [
            'title'               => $title,
            'department'          => $department,
            'job_type'            => $jobType,
            'location'            => $location,
            'experience_required' => $experience,
            'openings'            => $openings,
            'salary_range'        => $salaryRange,
            'description'         => $description,
            'requirements'        => $requirements,
            'status'              => $status,
            'updated_at'          => date('Y-m-d H:i:s')
        ];

        if ($jobId > 0) {
            $this->Recruitment_model->update_job($jobId, $jobData);
            $msg = "Job requisition '{$title}' updated successfully!";
        } else {
            $jobData['created_at'] = date('Y-m-d H:i:s');
            $jobId = $this->Recruitment_model->save_job($jobData);
            $msg = "New job requisition '{$title}' created successfully!";
        }

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg, 'job_id' => $jobId]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        redirect('admin1947/hr/jobs');
    }

    /**
     * AJAX / POST / GET: Toggle Job Status (Active / Closed)
     */
    public function toggle_job_status($id = null) {
        $jobId = intval($id ?: ($this->input->post('job_id') ?: ($this->input->get('job_id') ?: ($this->input->post('id') ?: $this->input->get('id')))));
        if ($jobId > 0) {
            $new_status = $this->Recruitment_model->toggle_job_status($jobId);
            $msg = "Job requisition status updated successfully" . ($new_status ? " to " . ucfirst($new_status) : "") . ".";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->get('is_ajax')) {
                echo json_encode(['status' => 'success', 'new_status' => $new_status, 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('success_msg', $msg);
        } else {
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->get('is_ajax')) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid or missing Job ID.']);
                return;
            }
        }
        redirect('admin1947/hr/jobs');
    }

    /**
     * Add Manual Candidate Application (Walk-in / Referral / Offline)
     */
    public function save_candidate() {
        $name          = trim($this->input->post('name', TRUE));
        $email         = strtolower(trim($this->input->post('email', TRUE)));
        $mobile        = trim($this->input->post('mobile', TRUE));
        $jobId         = intval($this->input->post('job_id'));
        $designation   = trim($this->input->post('designation', TRUE));
        $qualification = trim($this->input->post('qualification', TRUE)) ?: 'Graduate';
        $experience    = trim($this->input->post('experience', TRUE)) ?: '1-2 Years';
        $stage         = strtolower(trim($this->input->post('status_stage', TRUE) ?: 'applied'));
        $message       = trim($this->input->post('message', TRUE));

        $redirectTo = $this->input->post('redirect_to') ?: ($jobId ? "admin1947/hr/candidates?job_id={$jobId}" : 'admin1947/hr/candidates');
        $isAjax     = $this->input->is_ajax_request() || $this->input->post('is_ajax') || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

        if (empty($name) || empty($mobile)) {
            $errMsg = 'Candidate Name and Mobile number are required.';
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $errMsg]);
                return;
            }
            $this->session->set_flashdata('error_msg', $errMsg);
            redirect($redirectTo);
            return;
        }

        if ($jobId > 0 && empty($designation)) {
            $j = $this->db->get_where('career_jobs', ['job_id' => $jobId])->row_array();
            if ($j) $designation = $j['title'];
        }
        if (empty($designation)) {
            $designation = 'Candidate / General';
        }

        if (in_array($stage, ['interview', 'interviewing'])) {
            $stage = 'interview_scheduled';
        }
        $validStages = ['applied', 'screened', 'interview_scheduled', 'offered', 'hired', 'rejected'];
        $finalStage = in_array($stage, $validStages) ? $stage : 'applied';

        $this->db->insert('career', [
            'job_id'        => $jobId > 0 ? $jobId : null,
            'name'          => $name,
            'email'         => $email,
            'mobile'        => $mobile,
            'designation'   => $designation,
            'qualification' => $qualification,
            'experience'    => $experience,
            'message'       => $message,
            'resume'        => '',
            'status'        => '1',
            'status_stage'  => $finalStage,
            'creat_date'    => date('Y-m-d')
        ]);

        $candId = $this->db->insert_id();
        if ($candId) {
            $noteBy = $this->session->userdata('staff_name') ?: 'HR Admin';
            $this->db->insert('career_notes', [
                'career_id'     => $candId,
                'note_text'     => 'Fast candidate intake registered to talent pipeline.' . ($message ? " Notes: {$message}" : ''),
                'note_by'       => $noteBy,
                'stage_at_time' => $finalStage,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
        }

        $succMsg = "Candidate '{$name}' successfully added to recruitment pipeline!";

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'       => 'success',
                'message'      => $succMsg,
                'candidate_id' => $candId,
                'redirect'     => $redirectTo
            ]);
            return;
        }

        $this->session->set_flashdata('success_msg', $succMsg);
        redirect($redirectTo);
    }

    /**
     * AJAX: Update Applicant ATS Stage (Alias)
     */
    public function update_applicant_status() {
        return $this->update_candidate_stage();
    }

    public function update_applicant() {
        return $this->update_candidate_stage();
    }


    /**
     * Convert Hired Candidate to Active Staff Employee
     */
    public function onboard_candidate_to_staff() {
        $careerId    = intval($this->input->post('career_id'));
        $role        = $this->input->post('role', TRUE) ?: 'office_staff';
        $department  = trim($this->input->post('department', TRUE)) ?: 'Operations';
        $designation = trim($this->input->post('designation', TRUE)) ?: 'Staff';
        $baseSalary  = floatval($this->input->post('base_salary') ?: 25000);
        $assignedArea= trim($this->input->post('assigned_area', TRUE)) ?: 'Lucknow Central Hub';
        $password    = $this->input->post('password') ?: 'admin@123';

        $candidate = $this->db->get_where('career', ['career_id' => $careerId])->row_array();
        if (!$candidate) {
            $this->session->set_flashdata('error_msg', 'Candidate not found.');
            redirect('admin1947/hr/recruitment');
            return;
        }

        // Create staff record
        $staffId = $this->Staff_model->create_staff([
            'name'          => $candidate['name'],
            'email'         => $candidate['email'],
            'phone'         => $candidate['mobile'],
            'role'          => $role,
            'department'    => $department,
            'designation'   => $designation,
            'base_salary'   => $baseSalary,
            'assigned_area' => $assignedArea,
            'password'      => $password,
            'status'        => 'active'
        ]);

        // Mark applicant as hired
        $this->db->where('career_id', $careerId)->update('career', ['status_stage' => 'hired']);

        $this->session->set_flashdata('success_msg', "Candidate {$candidate['name']} successfully onboarded to active enterprise staff with ID #{$staffId}!");
        redirect('admin1947/hr/directory');
    }

    /**
     * Delete / Archive Applicant
     */
    public function delete_applicant() {
        $careerId = intval($this->input->post('career_id'));
        if ($careerId > 0) {
            $this->db->where('career_id', $careerId)->delete('career');
            $msg = 'Candidate application removed successfully.';
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'success', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('success_msg', $msg);
        }
        redirect('admin1947/hr/recruitment');
    }

    /**
     * Delete Candidate (from candidates pipeline dossier)
     */
    public function delete_candidate() {
        $candidateId = intval($this->input->post('candidate_id') ?: $this->input->post('career_id'));
        if ($candidateId > 0) {
            $this->load->model('Recruitment_model');
            $this->Recruitment_model->delete_candidate($candidateId);
            $msg = 'Candidate application removed successfully.';
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'success', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('success_msg', $msg);
        }
        redirect('admin1947/hr/candidates');
    }

    /**
     * Employee Directory
     */
    public function employees() {
        $role   = $this->input->get('role', TRUE);
        $search = $this->input->get('search', TRUE);

        $filters = [];
        if ($role) $filters['role'] = $role;
        if ($search) $filters['search'] = $search;

        $data['employees'] = $this->Staff_model->get_all_staff($filters, 100);
        $data['selected_role'] = $role;
        $data['jobs'] = $this->Recruitment_model->get_all_jobs();

        $this->load->view('hr/header', $data);
        $this->load->view('hr/employees', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Save / Add Employee
     */
    public function save_employee() {
        $name        = trim($this->input->post('name', TRUE));
        $email       = strtolower(trim($this->input->post('email', TRUE)));
        $phone       = trim($this->input->post('phone', TRUE));
        $role        = $this->input->post('role', TRUE) ?: 'office_staff';
        $department  = trim($this->input->post('department', TRUE)) ?: 'Operations';
        $designation = trim($this->input->post('designation', TRUE)) ?: 'Staff';
        $baseSalary  = floatval($this->input->post('base_salary') ?: 25000);
        $assignedArea= trim($this->input->post('assigned_area', TRUE)) ?: 'Lucknow Central';
        $password    = $this->input->post('password') ?: 'admin@123';

        if (empty($name) || empty($email) || empty($phone)) {
            $this->session->set_flashdata('error_msg', 'Name, email, and phone are required.');
            redirect('admin1947/hr/directory');
            return;
        }

        $id = $this->Staff_model->create_staff([
            'name'          => $name,
            'email'         => $email,
            'phone'         => $phone,
            'role'          => $role,
            'department'    => $department,
            'designation'   => $designation,
            'base_salary'   => $baseSalary,
            'assigned_area' => $assignedArea,
            'password'      => $password,
            'status'        => 'active'
        ]);

        $this->session->set_flashdata('success_msg', "Employee {$name} onboarded successfully with ID #{$id}!");
        redirect('admin1947/hr/directory');
    }

    /**
     * Update Existing Employee (Form or AJAX)
     */
    public function update_employee() {
        $staffId     = intval($this->input->post('staff_id'));
        $name        = trim($this->input->post('name', TRUE));
        $email       = strtolower(trim($this->input->post('email', TRUE)));
        $phone       = trim($this->input->post('phone', TRUE));
        $role        = $this->input->post('role', TRUE);
        $department  = trim($this->input->post('department', TRUE));
        $designation = trim($this->input->post('designation', TRUE));
        $baseSalary  = floatval($this->input->post('base_salary') ?: 0);
        $assignedArea= trim($this->input->post('assigned_area', TRUE));
        $status      = $this->input->post('status', TRUE);

        if (!$staffId || empty($name) || empty($phone)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Staff ID, name, and phone are required.']);
                return;
            }
            $this->session->set_flashdata('error_msg', 'Staff ID, name, and phone are required.');
            redirect('admin1947/hr/directory');
            return;
        }

        $updateData = [
            'name'          => $name,
            'phone'         => $phone,
            'base_salary'   => $baseSalary,
            'department'    => $department ?: 'Operations',
            'designation'   => $designation ?: 'Staff',
            'assigned_area' => $assignedArea ?: 'Lucknow Central'
        ];
        if (!empty($email)) $updateData['email'] = $email;
        if (!empty($role)) $updateData['role'] = $role;
        if (!empty($status)) $updateData['status'] = $status;

        $this->Staff_model->update_staff($staffId, $updateData);

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status'  => 'success',
                'message' => "Employee {$name} updated successfully."
            ]);
            return;
        }

        $this->session->set_flashdata('success_msg', "Employee {$name} updated successfully.");
        redirect('admin1947/hr/directory');
    }

    /**
     * AJAX: Toggle Staff Status (active / inactive)
     */
    public function toggle_staff_status() {
        $staffId = intval($this->input->post('staff_id'));
        $staff   = $this->Staff_model->get_user_by_id($staffId);
        if (!$staff) {
            echo json_encode(['status' => 'error', 'message' => 'Staff member not found.']);
            return;
        }

        $newStatus = ($staff['status'] === 'active') ? 'inactive' : 'active';
        $this->Staff_model->update_staff($staffId, ['status' => $newStatus]);

        echo json_encode([
            'status'     => 'success',
            'new_status' => $newStatus,
            'message'    => "Staff status changed to " . ucfirst($newStatus)
        ]);
    }

    /**
     * Leave Approval Center
     */
    public function leaves() {
        $status    = $this->input->get('status', TRUE);
        $dept      = $this->input->get('dept', TRUE);
        $type      = $this->input->get('type', TRUE);
        $search    = $this->input->get('search', TRUE);

        $filters = [];
        if (!empty($status) && $status !== 'all') $filters['status'] = $status;
        if (!empty($dept) && $dept !== 'all') $filters['department'] = $dept;
        if (!empty($type) && $type !== 'all') $filters['leave_type'] = $type;
        if (!empty($search)) $filters['search'] = $search;

        $data['leaves']           = $this->Hr_model->get_leaves($filters, 250);
        $data['selected_status']  = $status ?: 'all';
        $data['selected_dept']    = $dept ?: 'all';
        $data['selected_type']    = $type ?: 'all';
        $data['search_query']     = $search ?: '';
        $data['all_staff']        = $this->db->where('status', 'active')->order_by('name', 'asc')->get('staff_users')->result_array();

        // Calculate global metrics across all leave requests
        $allLeaves = $this->Hr_model->get_leaves([], 500);
        $metrics = [
            'total'          => count($allLeaves),
            'pending'        => 0,
            'approved'       => 0,
            'rejected'       => 0,
            'total_days'     => 0,
            'sick_days'      => 0,
            'casual_days'    => 0,
            'earned_days'    => 0,
            'emergency_days' => 0
        ];
        foreach ($allLeaves as $l) {
            $days = intval($l['days_count'] ?? 1);
            if ($l['status'] === 'pending')  $metrics['pending']++;
            if ($l['status'] === 'approved') {
                $metrics['approved']++;
                $metrics['total_days'] += $days;
            }
            if ($l['status'] === 'rejected') $metrics['rejected']++;

            $lt = strtolower($l['leave_type'] ?? 'casual');
            if ($lt === 'sick') $metrics['sick_days'] += $days;
            elseif ($lt === 'casual') $metrics['casual_days'] += $days;
            elseif ($lt === 'earned') $metrics['earned_days'] += $days;
            else $metrics['emergency_days'] += $days;
        }
        $data['metrics'] = $metrics;

        $this->load->view('hr/header', $data);
        $this->load->view('hr/leaves', $data);
        $this->load->view('hr/footer');
    }

    /**
     * AJAX / Form: Submit New Leave Application
     */
    public function apply_leave() {
        $userId    = intval($this->input->post('user_id')) ?: $this->session->userdata('staff_user_id');
        $leaveType = $this->input->post('leave_type', TRUE) ?: 'casual';
        $startDate = $this->input->post('start_date', TRUE);
        $endDate   = $this->input->post('end_date', TRUE);
        $reason    = trim($this->input->post('reason', TRUE));

        if (empty($userId) || empty($startDate) || empty($endDate) || empty($reason)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Please fill in all mandatory leave details (Staff, Dates, and Reason).']);
                return;
            }
            $this->session->set_flashdata('error_msg', 'Please fill in all mandatory leave details.');
            redirect('admin1947/hr/leaves');
            return;
        }

        $leaveId = $this->Hr_model->submit_leave($userId, $leaveType, $startDate, $endDate, $reason);

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status'  => 'success',
                'message' => 'Leave application submitted successfully and sent for approval!',
                'id'      => $leaveId
            ]);
            return;
        }

        $this->session->set_flashdata('success_msg', 'Leave application submitted successfully.');
        redirect('admin1947/hr/leaves');
    }

    /**
     * AJAX: Approve / Reject / Reset Leave Application
     */
    public function update_leave() {
        $leaveId    = intval($this->input->post('leave_id'));
        $status     = $this->input->post('status', TRUE);
        $notes      = trim($this->input->post('notes', TRUE));
        $reviewerId = $this->session->userdata('staff_user_id') ?: 1;

        if (!in_array($status, ['approved', 'rejected', 'pending']) || !$leaveId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid leave action or identifier.']);
            return;
        }

        $this->Hr_model->update_leave_status($leaveId, $reviewerId, $status, $notes);
        echo json_encode([
            'status'  => 'success',
            'message' => "Leave application marked as " . strtoupper($status) . " successfully!"
        ]);
    }

    /**
     * AJAX: Delete / Cancel Leave Request
     */
    public function delete_leave() {
        $leaveId = intval($this->input->post('leave_id') ?: $this->input->get('leave_id'));
        if (!$leaveId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid leave identifier.']);
            return;
        }

        $this->Hr_model->delete_leave($leaveId);
        echo json_encode([
            'status'  => 'success',
            'message' => 'Leave application cancelled / deleted successfully.'
        ]);
    }

    /**
     * Monthly Payroll Engine & Disbursal Manager
     */
    public function payroll() {
        $month = $this->input->get('month') ?: date('m');
        $year  = $this->input->get('year') ?: date('Y');
        $mode  = $this->input->get('mode') ?: 'full'; // 'full' (standard monthly disbursal) or 'mtd' (month-to-date accrued)

        $data['roster'] = $this->Hr_model->calculate_monthly_payroll($month, $year, $mode);
        $data['month']  = $month;
        $data['year']   = $year;
        $data['mode']   = $mode;

        $data['total_payout']         = 0.00;
        $data['total_gross']          = 0.00;
        $data['total_deductions_all'] = 0.00;

        foreach ($data['roster'] as $r) {
            $data['total_payout']         += floatval($r['net_salary'] ?? 0);
            $data['total_gross']          += floatval($r['gross_earned'] ?? 0);
            $data['total_deductions_all'] += floatval($r['total_deductions'] ?? 0);
        }

        $this->load->view('hr/header', $data);
        $this->load->view('hr/payroll', $data);
        $this->load->view('hr/footer');
    }

    /**
     * AJAX: Record Disbursal Payment Reference & Transfer Status
     */
    public function process_disbursal() {
        $userId  = intval($this->input->post('user_id'));
        $month   = $this->input->post('month', TRUE) ?: date('m');
        $year    = $this->input->post('year', TRUE) ?: date('Y');
        $amount  = floatval($this->input->post('amount'));
        $status  = trim($this->input->post('status', TRUE) ?: 'transferred');
        $channel = trim($this->input->post('channel', TRUE) ?: 'Corporate NetBanking (HDFC Direct)');
        $notes   = trim($this->input->post('notes', TRUE) ?: '');

        if (!in_array($status, ['transferred', 'pending', 'on_hold'])) {
            $status = 'transferred';
        }

        $txnRef  = trim($this->input->post('txn_ref', TRUE) ?? '');
        if ($status === 'transferred' && empty($txnRef)) {
            $txnRef = 'NEFT-' . date('Ymd') . '-' . rand(1000, 9999);
        } else if ($status === 'pending') {
            $txnRef = '';
        }

        $saved = $this->Hr_model->update_payroll_disbursal($userId, $month, $year, $amount, $status, $txnRef, $channel, $notes);

        $dateFormatted = (!empty($saved['transferred_at'])) ? date('d M Y, h:i A', strtotime($saved['transferred_at'])) : '';

        if ($status === 'transferred') {
            $msg = "Salary transfer of ₹" . number_format($amount, 2) . " marked as TRANSFERRED! UTR/Ref: {$saved['txn_ref']}";
        } else if ($status === 'on_hold') {
            $msg = "Disbursal payment placed ON HOLD for employee.";
        } else {
            $msg = "Payment status marked as PENDING (Not Transferred).";
        }

        echo json_encode([
            'status'           => 'success',
            'message'          => $msg,
            'transfer_status'  => $status,
            'payment_status'   => ($status === 'transferred') ? 'Transferred' : (($status === 'on_hold') ? 'On Hold' : 'Pending Transfer'),
            'txn_ref'          => $saved['txn_ref'] ?? '',
            'channel'          => $saved['payment_channel'],
            'transferred_at'   => $dateFormatted,
            'notes'            => $saved['notes'] ?? '',
            'amount'           => $amount,
            'formatted_amount' => '₹' . number_format($amount, 2)
        ]);
    }

    /**
     * Daily Company-wide Attendance Roster & Staff Spotlight
     */
    public function attendance() {
        $date   = $this->input->get('date') ?: date('Y-m-d');
        $search = trim($this->input->get('search', TRUE) ?? '');

        $data['daily_roster']  = $this->Attendance_model->get_daily_roster($date);
        $data['selected_date'] = $date;
        $data['search']        = $search;
        $data['all_staff']     = $this->db->where('status', 'active')->order_by('name', 'asc')->get('staff_users')->result_array();

        // If a specific staff member is searched, fetch their personal attendance history and details
        $data['searched_staff'] = null;
        $data['staff_history']  = [];
        if (!empty($search)) {
            // Clean up search query (strip parenthesized role if present e.g. "Suresh Patel (Ops)" -> "Suresh Patel")
            $cleanName = preg_replace('/\s*\(.*?\)\s*/', '', $search);
            $cleanName = trim($cleanName);

            $this->db->group_start();
            $this->db->like('name', $cleanName);
            if (!empty($search) && $search !== $cleanName) {
                $this->db->or_like('name', $search);
            }
            $this->db->or_like('staff_code', $cleanName);
            $this->db->or_like('phone', $cleanName);
            $this->db->group_end();
            $matched = $this->db->get('staff_users')->row_array();

            if ($matched) {
                $data['searched_staff'] = $matched;
                $data['staff_history']  = $this->db->where('user_id', $matched['id'])
                    ->order_by('punch_date', 'DESC')
                    ->limit(20)
                    ->get('staff_attendance')
                    ->result_array();

                // Compute individual stats for current month
                $curMonth = date('Y-m');
                $monthPunches = $this->db->where('user_id', $matched['id'])
                    ->like('punch_date', $curMonth, 'after')
                    ->get('staff_attendance')
                    ->result_array();

                $staffStats = [
                    'present'     => 0,
                    'late'        => 0,
                    'half_day'    => 0,
                    'total_hours' => 0.00,
                    'days_logged' => count($monthPunches)
                ];
                foreach ($monthPunches as $mp) {
                    if ($mp['status'] === 'present') $staffStats['present']++;
                    elseif ($mp['status'] === 'late') $staffStats['late']++;
                    elseif ($mp['status'] === 'half_day') $staffStats['half_day']++;
                    $staffStats['total_hours'] += floatval($mp['working_hours']);
                }
                $data['staff_month_stats'] = $staffStats;
            }
        }

        $this->load->view('hr/header', $data);
        $this->load->view('hr/attendance', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Admin: Save or Edit Any Attendance Record Field
     */
    public function save_attendance_record() {
        $userId    = intval($this->input->post('user_id'));
        $punchDate = trim($this->input->post('punch_date', TRUE)) ?: date('Y-m-d');
        $status    = trim($this->input->post('status', TRUE)) ?: 'present';
        
        $checkInTime  = trim($this->input->post('check_in_time', TRUE));
        $checkOutTime = trim($this->input->post('check_out_time', TRUE));
        $hours        = $this->input->post('working_hours');
        $distance     = $this->input->post('distance_from_office_km');
        $checkInLat   = $this->input->post('check_in_lat');
        $checkInLng   = $this->input->post('check_in_lng');
        $checkOutLat  = $this->input->post('check_out_lat');
        $checkOutLng  = $this->input->post('check_out_lng');
        $notes        = trim($this->input->post('notes', TRUE));

        if (!$userId) {
            $resp = ['status' => 'error', 'message' => 'Staff employee ID is required.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('admin1947/attendance/roster?date=' . $punchDate);
            return;
        }

        // Standardize datetime formatting if only time is provided (e.g. 09:30)
        if (!empty($checkInTime) && strlen($checkInTime) <= 8) {
            $checkInTime = $punchDate . ' ' . (strlen($checkInTime) == 5 ? $checkInTime . ':00' : $checkInTime);
        }
        if (!empty($checkOutTime) && strlen($checkOutTime) <= 8) {
            $checkOutTime = $punchDate . ' ' . (strlen($checkOutTime) == 5 ? $checkOutTime . ':00' : $checkOutTime);
        }

        // Auto calculate hours if not explicitly entered but in and out times exist
        if (($hours === '' || $hours === null) && !empty($checkInTime) && !empty($checkOutTime)) {
            $tsIn  = strtotime($checkInTime);
            $tsOut = strtotime($checkOutTime);
            if ($tsOut > $tsIn) {
                $hours = round(($tsOut - $tsIn) / 3600, 2);
            }
        }

        $saveData = [
            'user_id'                 => $userId,
            'punch_date'              => $punchDate,
            'status'                  => in_array($status, ['present', 'late', 'half_day', 'absent', 'on_leave']) ? $status : 'present',
            'check_in_time'           => !empty($checkInTime) ? $checkInTime : null,
            'check_out_time'          => !empty($checkOutTime) ? $checkOutTime : null,
            'working_hours'           => ($hours !== '' && $hours !== null) ? floatval($hours) : 0.00,
            'distance_from_office_km' => ($distance !== '' && $distance !== null) ? floatval($distance) : 0.00,
            'check_in_lat'            => ($checkInLat !== '' && $checkInLat !== null) ? floatval($checkInLat) : 26.8467,
            'check_in_lng'            => ($checkInLng !== '' && $checkInLng !== null) ? floatval($checkInLng) : 80.9462,
            'check_out_lat'           => ($checkOutLat !== '' && $checkOutLat !== null) ? floatval($checkOutLat) : 26.8467,
            'check_out_lng'           => ($checkOutLng !== '' && $checkOutLng !== null) ? floatval($checkOutLng) : 80.9462,
            'notes'                   => $notes
        ];

        $attId = $this->Attendance_model->save_admin_attendance($saveData);

        $msg = "Attendance record for employee #{$userId} saved successfully!";
        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg, 'id' => $attId]);
            return;
        }
        $this->session->set_flashdata('success_msg', $msg);
        redirect('admin1947/attendance/roster?date=' . $punchDate);
    }

    /**
     * Admin: Delete Attendance Record
     */
    public function delete_attendance_record() {
        $attendanceId = intval($this->input->post('attendance_id'));
        $punchDate    = trim($this->input->post('punch_date', TRUE)) ?: date('Y-m-d');

        if ($attendanceId > 0) {
            $this->Attendance_model->delete_attendance($attendanceId);
            $msg = "Attendance record cleared successfully.";
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'success', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('success_msg', $msg);
        }
        redirect('admin1947/attendance/roster?date=' . $punchDate);
    }

    /**
     * Admin: Bulk Mark Attendance for All / Selected Employees
     */
    public function bulk_mark_attendance() {
        $punchDate  = trim($this->input->post('punch_date', TRUE)) ?: date('Y-m-d');
        $bulkStatus = trim($this->input->post('bulk_status', TRUE)) ?: 'present';
        $userIds    = $this->input->post('user_ids'); // array or comma-separated

        if (empty($userIds)) {
            $allStaff = $this->db->where('status', 'active')->get('staff_users')->result_array();
            $userIds = array_column($allStaff, 'id');
        } elseif (is_string($userIds)) {
            $userIds = explode(',', $userIds);
        }

        $count = 0;
        $defaultIn  = ($bulkStatus === 'present' || $bulkStatus === 'late') ? ($punchDate . ' 09:30:00') : null;
        $defaultOut = ($bulkStatus === 'present' || $bulkStatus === 'late') ? ($punchDate . ' 18:30:00') : null;
        $hours      = ($bulkStatus === 'present' || $bulkStatus === 'late') ? 9.00 : 0.00;

        foreach ($userIds as $uid) {
            $uid = intval($uid);
            if ($uid <= 0) continue;

            $this->Attendance_model->save_admin_attendance([
                'user_id'                 => $uid,
                'punch_date'              => $punchDate,
                'status'                  => $bulkStatus,
                'check_in_time'           => $defaultIn,
                'check_out_time'          => $defaultOut,
                'working_hours'           => $hours,
                'distance_from_office_km' => 0.15,
                'notes'                   => 'Bulk marked by HR Administrator'
            ]);
            $count++;
        }

        $msg = "Bulk attendance updated for {$count} staff members as " . strtoupper($bulkStatus) . "!";
        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg, 'count' => $count]);
            return;
        }
        $this->session->set_flashdata('success_msg', $msg);
        redirect('admin1947/attendance/roster?date=' . $punchDate);
    }

    /**
     * 1. Job Requisitions Page (/hr/jobs)
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
     * 2. Candidate Pipeline Page (/hr/candidates/{stage})
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
        $data['jobs'] = $this->Recruitment_model->get_all_jobs();
        $data['selected_job'] = $job_id ? $this->Recruitment_model->get_job_by_id($job_id) : null;
        if (!empty($data['selected_job']) && !empty($data['jobs'])) {
            $found = false;
            foreach ($data['jobs'] as $j) {
                if ($j['job_id'] == $data['selected_job']['job_id']) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                array_unshift($data['jobs'], $data['selected_job']);
            }
        }

        $this->load->view('hr/header', $data);
        $this->load->view('hr/candidates', $data);
        $this->load->view('hr/footer');
    }

    /**
     * 3. Candidate Profile / Dossier Page (/hr/candidate_profile/{id})
     */
    public function candidate_profile($id = null) {
        $id = intval($id);
        if (!$id) {
            $this->session->set_flashdata('error_msg', 'Candidate ID is required.');
            redirect('admin1947/hr/candidates');
            return;
        }

        $data['candidate'] = $this->Recruitment_model->get_candidate_by_id($id);
        if (empty($data['candidate'])) {
            $this->session->set_flashdata('error_msg', 'Candidate dossier not found.');
            redirect('admin1947/hr/candidates');
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
     * Legacy & Action routes forwarding
     */
    public function update_candidate_stage() {
        $candidate_id = intval($this->input->post('career_id') ?: $this->input->post('candidate_id'));
        $target_stage = strtolower(trim($this->input->post('status_stage') ?: $this->input->post('target_stage')));
        $note = trim($this->input->post('stage_note', TRUE));
        $author = $this->session->userdata('staff_name') ?: 'HR Lead';

        $valid = ['applied', 'screened', 'interviewing', 'interview_scheduled', 'interview', 'offered', 'hired', 'rejected'];
        $is_ajax = $this->input->is_ajax_request() 
            || empty($this->input->post('redirect_to')) 
            || $this->input->post('ajax')
            || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

        if (!$candidate_id || !in_array($target_stage, $valid)) {
            $resp = ['status' => 'error', 'message' => 'Invalid candidate ID or target stage: ' . $target_stage];
            if ($is_ajax) {
                header('Content-Type: application/json');
                echo json_encode($resp);
                return;
            }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('admin1947/hr/candidates');
            return;
        }

        // Canonicalize stage name
        if ($target_stage === 'interview') {
            $target_stage = 'interview_scheduled';
        }

        $updated = $this->Recruitment_model->update_candidate_stage($candidate_id, $target_stage, $note, $author);
        if (!$updated) {
            $resp = ['status' => 'error', 'message' => 'Candidate record not found or could not be updated.'];
            if ($is_ajax) {
                header('Content-Type: application/json');
                echo json_encode($resp);
                return;
            }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('admin1947/hr/candidates');
            return;
        }

        $msg = "Candidate advanced to " . ucwords(str_replace('_', ' ', $target_stage)) . " stage.";

        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => 'success', 
                'message' => $msg, 
                'stage'   => $target_stage
            ]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        $redirect_to = $this->input->post('redirect_to') ?: ('admin1947/hr/candidate_profile/' . $candidate_id);
        redirect($redirect_to);
    }

    public function add_candidate_note() {
        $candidate_id = intval($this->input->post('candidate_id'));
        $note_text = trim($this->input->post('note_text', TRUE));
        $author = $this->session->userdata('staff_name') ?: 'HR Lead';
        $stage = trim($this->input->post('stage', TRUE)) ?: 'interviewing';

        if (!$candidate_id || empty($note_text)) {
            $resp = ['status' => 'error', 'message' => 'Note content cannot be empty.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('admin1947/hr/candidate_profile/' . $candidate_id);
            return;
        }

        $this->Recruitment_model->add_candidate_note($candidate_id, $note_text, $author, $stage);
        $msg = "Interview/evaluation note recorded.";

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        redirect('admin1947/hr/candidate_profile/' . $candidate_id);
    }

    public function onboard_candidate() {
        $candidate_id = intval($this->input->post('career_id') ?: $this->input->post('candidate_id'));
        $candidate = $this->Recruitment_model->get_candidate_by_id($candidate_id);

        if (!$candidate) {
            $resp = ['status' => 'error', 'message' => 'Candidate record not found.'];
            if ($this->input->is_ajax_request()) { echo json_encode($resp); return; }
            $this->session->set_flashdata('error_msg', $resp['message']);
            redirect('admin1947/hr/candidates');
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
            redirect('admin1947/hr/candidate_profile/' . $candidate_id);
            return;
        }

        $msg = "Candidate {$name} successfully onboarded into Staff Directory with Employee ID {$empCode}!";

        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => $msg, 'employee_id' => $empCode]);
            return;
        }

        $this->session->set_flashdata('success_msg', $msg);
        redirect('admin1947/hr/candidate_profile/' . $candidate_id);
    }
}

