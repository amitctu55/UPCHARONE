<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Staff Controller
 * Unified Staff Authentication, Session Security & Portal Router
 */
class Staff extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Attendance_model');
        $this->load->helper(['url', 'form']);
    }

    /**
     * Staff Login Screen
     */
    public function index() {
        $this->login();
    }

    public function login() {
        if ($this->session->userdata('staff_user_id')) {
            $this->_redirect_role($this->session->userdata('staff_role'));
            return;
        }
        $this->load->view('staff/login');
    }

    /**
     * AJAX / POST Staff Authentication
     */
    public function authenticate() {
        $identity = $this->input->post('identity', TRUE);
        $password = $this->input->post('password', TRUE);

        if (empty($identity) || empty($password)) {
            $this->session->set_flashdata('error_msg', 'Please enter email/phone and password.');
            redirect('staff/login');
            return;
        }

        $user = $this->Staff_model->login($identity, $password);
        if ($user) {
            $this->load->helper('custom_helper');
            enforce_single_session_role('staff');

            $sessionData = [
                'staff_user_id'   => $user['id'],
                'staff_code'      => $user['staff_code'],
                'staff_name'      => $user['name'],
                'staff_email'     => $user['email'],
                'staff_phone'     => $user['phone'],
                'staff_role'      => $user['role'],
                'staff_dept'      => $user['department'],
                'staff_designation'=> $user['designation'],
                'staff_logged_in' => TRUE
            ];
            $this->session->set_userdata($sessionData);

            if ($this->input->is_ajax_request()) {
                echo json_encode([
                    'status'   => 'success',
                    'role'     => $user['role'],
                    'redirect' => $this->_get_role_route($user['role'])
                ]);
                return;
            }

            $this->_redirect_role($user['role']);
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid staff credentials or account inactive.']);
                return;
            }
            $this->session->set_flashdata('error_msg', 'Invalid staff code / email or password.');
            redirect('staff/login');
        }
    }

    /**
     * Demo 1-Click Role Switcher (for immediate preview / pair testing)
     */
    public function demo_login($role = 'collector') {
        $user = $this->db->get_where('staff_users', ['role' => $role, 'status' => 'active'])->row_array();
        if ($user) {
            $this->load->helper('custom_helper');
            enforce_single_session_role('staff');

            $sessionData = [
                'staff_user_id'   => $user['id'],
                'staff_code'      => $user['staff_code'],
                'staff_name'      => $user['name'],
                'staff_email'     => $user['email'],
                'staff_phone'     => $user['phone'],
                'staff_role'      => $user['role'],
                'staff_dept'      => $user['department'],
                'staff_designation'=> $user['designation'],
                'staff_logged_in' => TRUE
            ];
            $this->session->set_userdata($sessionData);
            $this->_redirect_role($user['role']);
        } else {
            redirect('staff/login');
        }
    }

    /**
     * Staff Dashboard Hub
     */
    public function dashboard() {
        if (!$this->session->userdata('staff_user_id')) {
            redirect('staff/login');
            return;
        }
        $this->_redirect_role($this->session->userdata('staff_role'));
    }

    /**
     * Staff Profile & Work History
     */
    public function profile() {
        if (!$this->session->userdata('staff_user_id')) {
            redirect('staff/login');
            return;
        }
        $userId = $this->session->userdata('staff_user_id');
        $data['user']        = $this->Staff_model->get_user_by_id($userId);
        $data['today_punch'] = $this->Attendance_model->get_today_punch($userId);
        $data['recent_logs'] = $this->Attendance_model->get_user_logs($userId, date('m'), date('Y'));
        
        $this->load->view('staff/profile', $data);
    }

    /**
     * Staff Logout
     */
    public function logout() {
        $items = ['staff_user_id', 'staff_code', 'staff_name', 'staff_email', 'staff_phone', 'staff_role', 'staff_dept', 'staff_designation', 'staff_logged_in'];
        $this->session->unset_userdata($items);
        $this->session->set_flashdata('success_msg', 'You have been logged out successfully.');
        redirect('staff/login');
    }

    private function _redirect_role($role) {
        redirect($this->_get_role_route($role));
    }

    private function _get_role_route($role) {
        switch ($role) {
            case 'collector':
                return 'collector/dashboard';
            case 'hr':
                return 'hr/dashboard';
            case 'bde':
                return 'crm/dashboard';
            case 'office_staff':
                return 'operations/dashboard';
            case 'super_admin':
            default:
                return 'hr/dashboard';
        }
    }
}
