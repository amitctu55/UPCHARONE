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

        // Render standalone modern login view
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
        $login_identifier = trim($this->input->post('name', TRUE));
        $password_plain = trim($this->input->post('password'));

        if (empty($login_identifier) || empty($password_plain)) {
            $msg = "<div class='alert alert-danger' style='border-radius:6px;'><i class='fa fa-exclamation-triangle'></i> Please enter both username/email/mobile and password.</div>";
            $this->session->set_flashdata('flashmsg', $msg);
            redirect(base_url('login'));
            return;
        }

        $password_hash = md5($password_plain);

        // 1. Check primary admin `login` table by username, email, or mobile
        $this->db->select('*')
                 ->from('login')
                 ->group_start()
                     ->where('username', $login_identifier)
                     ->or_where('email', $login_identifier)
                     ->or_where('mobile', $login_identifier)
                 ->group_end()
                 ->where('status', '1');

        $user = $this->db->get()->row();

        // Verify password (MD5 legacy hash or password_verify bcrypt)
        $authenticated = false;
        if (!empty($user)) {
            if ($user->password === $password_hash || password_verify($password_plain, $user->password)) {
                $authenticated = true;
            }
        }

        // 2. If not found in `login`, check `staff_users` table
        if (!$authenticated && $this->db->table_exists('staff_users')) {
            $this->db->select('*')
                     ->from('staff_users')
                     ->group_start()
                         ->where('email', $login_identifier)
                         ->or_where('phone', $login_identifier)
                         ->or_where('staff_code', $login_identifier)
                     ->group_end()
                     ->where('status', 'active');
            $staff = $this->db->get()->row();
            if (!empty($staff)) {
                if ($staff->password_hash === $password_hash || password_verify($password_plain, $staff->password_hash)) {
                    $authenticated = true;
                    // Adapt staff to user object
                    $user = (object) [
                        'id'       => $staff->id,
                        'username' => $staff->staff_code,
                        'name'     => $staff->name,
                        'password' => $staff->password_hash,
                        'role'     => ($staff->role === 'super_admin' ? '1' : 'A')
                    ];
                }
            }
        }

        if ($authenticated && !empty($user)) {
            // Strictly enforce single session: Flush patient / partner session keys
            $this->session->unset_userdata(array('useremail', 'signupuserid', 'forgotuserid', 'doctor_id', 'hospital_id', 'pathology_id', 'clinic_id'));

            $session_data = array(
                'adminuserid'    => $user->id,
                'userid'         => $user->id,
                'username'       => $user->username,
                'name'           => $user->name ?? $user->username,
                'pwd'            => $user->password,
                'code'           => $user->role,
                'institution_id' => $user->id,
                'active_auth_role' => 'admin',
                'logged_in'      => TRUE
            );

            $this->session->set_userdata($session_data);

            // Issue cryptographically signed admin guard token for /admin1947/* namespace
            $tokenPayload = array(
                'adminuserid' => $user->id,
                'username'    => $user->username,
                'role'        => 'super_admin',
                'time'        => time(),
                'sig'         => hash_hmac('sha256', $user->id . '|' . $user->username . '|super_admin', 'UpcharMasterAdminSecret2026')
            );
            $signedToken = base64_encode(json_encode($tokenPayload));
            @setcookie('upchar_admin_guard', $signedToken, time() + 7200, '/', '', false, true);

            redirect(base_url('masters/dashboard'));
        } else {
            $msg = "<div class='alert alert-danger' style='border-radius:6px;'><i class='fa fa-exclamation-circle'></i> Invalid Username, Email, or Password. Please try again.</div>";
            $this->session->set_flashdata('flashmsg', $msg);
            redirect(base_url('login'));
        }
    }

    /**
     * Admin Signout
     */
    public function logout() {
        $this->session->sess_destroy();

        // Thoroughly clear all admin auth and session cookies across domain variations
        $cookies = array('upchar_admin_guard', 'ci_session', 'ci_admin_session');
        $host = isset($_SERVER['HTTP_HOST']) ? explode(':', $_SERVER['HTTP_HOST'])[0] : '';
        $domains = array('', $host);
        $parts = explode('.', $host);
        if (count($parts) >= 2) {
            $domains[] = '.' . implode('.', array_slice($parts, -2));
        }

        foreach ($cookies as $cname) {
            foreach ($domains as $dom) {
                @setcookie($cname, '', time() - 86400, '/', $dom);
                @setcookie($cname, '', time() - 86400, '/admin1947/', $dom);
                @setcookie($cname, '', time() - 86400, '');
            }
            unset($_COOKIE[$cname]);
        }

        redirect(base_url('login'));
    }

    public function signout() {
        $this->logout();
    }
}
