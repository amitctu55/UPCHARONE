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
        if (!$staffId || !in_array($role, ['hr', 'super_admin'])) {
            $this->session->set_flashdata('error_msg', 'Access restricted to HR Managers & Administrators.');
            redirect('staff/login');
        }
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

        $this->load->view('hr/header', $data);
        $this->load->view('hr/dashboard', $data);
        $this->load->view('hr/footer');
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
            redirect('hr/employees');
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
        redirect('hr/employees');
    }

    /**
     * Leave Approval Center
     */
    public function leaves() {
        $status = $this->input->get('status', TRUE);
        $filters = [];
        if ($status) $filters['status'] = $status;

        $data['leaves'] = $this->Hr_model->get_leaves($filters, 100);
        $data['selected_status'] = $status;

        $this->load->view('hr/header', $data);
        $this->load->view('hr/leaves', $data);
        $this->load->view('hr/footer');
    }

    /**
     * AJAX: Approve / Reject Leave
     */
    public function update_leave() {
        $leaveId    = intval($this->input->post('leave_id'));
        $status     = $this->input->post('status', TRUE);
        $notes      = trim($this->input->post('notes', TRUE));
        $reviewerId = $this->session->userdata('staff_user_id');

        if (!in_array($status, ['approved', 'rejected']) || !$leaveId) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            return;
        }

        $this->Hr_model->update_leave_status($leaveId, $reviewerId, $status, $notes);
        echo json_encode([
            'status'  => 'success',
            'message' => "Leave application marked as " . strtoupper($status) . "!"
        ]);
    }

    /**
     * Monthly Payroll Engine
     */
    public function payroll() {
        $month = $this->input->get('month') ?: date('m');
        $year  = $this->input->get('year') ?: date('Y');

        $data['roster'] = $this->Hr_model->calculate_monthly_payroll($month, $year);
        $data['month']  = $month;
        $data['year']   = $year;

        $data['total_payout'] = 0.00;
        foreach ($data['roster'] as $r) {
            $data['total_payout'] += $r['net_salary'];
        }

        $this->load->view('hr/header', $data);
        $this->load->view('hr/payroll', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Daily Company-wide Attendance Roster
     */
    public function attendance() {
        $date = $this->input->get('date') ?: date('Y-m-d');
        $data['daily_roster']  = $this->Attendance_model->get_daily_roster($date);
        $data['selected_date'] = $date;

        $this->load->view('hr/header', $data);
        $this->load->view('hr/attendance', $data);
        $this->load->view('hr/footer');
    }
}
