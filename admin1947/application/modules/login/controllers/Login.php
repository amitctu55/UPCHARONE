<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
    }

    /**
     * Main Login Page & Form Handler
     */
    public function index() {
        // If already authenticated, redirect to dashboard
        if ($this->session->userdata('adminuserid') || $this->session->userdata('userid')) {
            redirect(base_url('masters/dashboard'));
            return;
        }

        // If POST request received on index, process authentication
        if ($this->input->server('REQUEST_METHOD') === 'POST' || $this->input->post('name')) {
            $this->process_login();
            return;
        }

        // Render login view
        $this->load->view('inc/topheaderlink');
        $this->load->view('mlogin');
    }

    /**
     * Auth alias methods for /login/auth, /login/login, and /login/login/login
     */
    public function auth() {
        if ($this->input->server('REQUEST_METHOD') === 'POST' || $this->input->post('name')) {
            $this->process_login();
        } else {
            $this->index();
        }
    }

    public function login() {
        if ($this->input->server('REQUEST_METHOD') === 'POST' || $this->input->post('name')) {
            $this->process_login();
        } else {
            $this->index();
        }
    }

    /**
     * Core Login Authentication Processor
     */
    protected function process_login() {
        $username = trim($this->input->post('name', TRUE));
        $password_plain = $this->input->post('password');

        if (empty($username) || empty($password_plain)) {
            $msg = "<div class='alert alert-danger' style='border-radius:6px;'><i class='fa fa-exclamation-triangle'></i> Please enter both username and password.</div>";
            $this->session->set_flashdata('flashmsg', $msg);
            redirect(base_url('login'));
            return;
        }

        $password_hash = md5($password_plain);

        $this->db->select('*')
                 ->from('login')
                 ->where('username', $username)
                 ->where('password', $password_hash)
                 ->where('status', '1');

        $query = $this->db->get()->row();

        if (!empty($query)) {
            // Strictly enforce single session: Flush patient / partner session keys and patient cookies
            $this->session->unset_userdata(array('useremail', 'signupuserid', 'forgotuserid', 'doctor_id', 'hospital_id', 'pathology_id', 'clinic_id'));
            @setcookie('ci_session', '', time() - 3600, '/');

            $session_data = array(
                'adminuserid'    => $query->id,
                'userid'         => $query->id,
                'username'       => $query->username,
                'name'           => $query->name ?? $query->username,
                'pwd'            => $query->password,
                'code'           => $query->role,
                'institution_id' => $query->id,
                'active_auth_role' => 'admin',
                'logged_in'      => TRUE
            );

            $this->session->set_userdata($session_data);
            redirect(base_url('masters/dashboard'));
        } else {
            $msg = "<div class='alert alert-danger' style='border-radius:6px;'><i class='fa fa-exclamation-circle'></i> Invalid Username or Password. Please try again.</div>";
            $this->session->set_flashdata('flashmsg', $msg);
            redirect(base_url('login'));
        }
    }

    /**
     * Admin Signout
     */
    public function logout() {
        $this->session->sess_destroy();
        @setcookie('ci_admin_session', '', time() - 3600, '/');
        redirect(base_url('login'));
    }

    public function signout() {
        $this->logout();
    }
}
