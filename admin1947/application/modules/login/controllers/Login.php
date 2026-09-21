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
     * Resilient Multi-Format Password Matcher
     * Supports: Plain Text, MD5 (case-insensitive), Bcrypt, SHA1, and Double MD5
     */
    protected function verify_password($input_password, $db_password) {
        if ($input_password === '' || $input_password === null || $db_password === '' || $db_password === null) {
            return false;
        }

        $input_plain = (string) $input_password;
        $db_pass_trimmed = trim((string) $db_password);

        // 1. Direct plain-text match (both trimmed and raw)
        if ($input_plain === $db_password || trim($input_plain) === $db_pass_trimmed) {
            return true;
        }

        // 2. MD5 match (case-insensitive hex comparison)
        $input_md5 = md5($input_plain);
        if (strcasecmp($input_md5, $db_pass_trimmed) === 0) {
            return true;
        }
        $input_md5_trimmed = md5(trim($input_plain));
        if (strcasecmp($input_md5_trimmed, $db_pass_trimmed) === 0) {
            return true;
        }

        // 3. Bcrypt / native PHP password_hash verify
        if (password_verify($input_plain, $db_pass_trimmed) || password_verify(trim($input_plain), $db_pass_trimmed)) {
            return true;
        }

        // 4. SHA1 match (case-insensitive hex comparison)
        $input_sha1 = sha1($input_plain);
        if (strcasecmp($input_sha1, $db_pass_trimmed) === 0 || strcasecmp(sha1(trim($input_plain)), $db_pass_trimmed) === 0) {
            return true;
        }

        // 5. Double MD5 match
        if (strcasecmp(md5($input_md5), $db_pass_trimmed) === 0 || strcasecmp(md5($input_md5_trimmed), $db_pass_trimmed) === 0) {
            return true;
        }

        return false;
    }

    /**
     * Core Login Authentication Processor
     */
    protected function process_login() {
        $login_identifier = trim($this->input->post('name', TRUE));
        $password_plain = $this->input->post('password');

        if (empty($login_identifier) || $password_plain === '' || $password_plain === null) {
            $msg = "<div class='alert alert-danger' style='border-radius:6px;'><i class='fa fa-exclamation-triangle'></i> Please enter both username/email/mobile and password.</div>";
            $this->session->set_flashdata('flashmsg', $msg);
            redirect(base_url('login'));
            return;
        }

        // Clean mobile number variations (e.g. +91, leading 0)
        $digits_only = preg_replace('/[^0-9]/', '', $login_identifier);
        $phone_variants = array();
        if (!empty($digits_only)) {
            $phone_variants[] = $digits_only;
            if (strlen($digits_only) === 12 && substr($digits_only, 0, 2) === '91') {
                $phone_variants[] = substr($digits_only, 2);
            } elseif (strlen($digits_only) === 11 && substr($digits_only, 0, 1) === '0') {
                $phone_variants[] = substr($digits_only, 1);
            } elseif (strlen($digits_only) === 10) {
                $phone_variants[] = '91' . $digits_only;
                $phone_variants[] = '0' . $digits_only;
            }
        }

        $authenticated = false;
        $user = null;
        $matched_inactive = false;

        // 1. Check primary admin `login` table across all matching candidates
        $this->db->select('*')->from('login')->group_start();
        $this->db->where('username', $login_identifier);
        $this->db->or_where('email', $login_identifier);
        $this->db->or_where('mobile', $login_identifier);
        if ($this->db->field_exists('usercode', 'login')) {
            $this->db->or_where('usercode', $login_identifier);
        }
        if ($this->db->field_exists('name', 'login')) {
            $this->db->or_where('name', $login_identifier);
        }
        foreach ($phone_variants as $pv) {
            $this->db->or_where('mobile', $pv);
        }
        $this->db->group_end();

        $candidates = $this->db->get()->result();

        // Also if no candidates found by exact match, try matching on username/email
        if (empty($candidates)) {
            $this->db->select('*')->from('login')->group_start();
            $this->db->like('username', $login_identifier, 'none');
            $this->db->or_like('email', $login_identifier, 'none');
            $this->db->group_end();
            $candidates = $this->db->get()->result();
        }

        if (!empty($candidates)) {
            foreach ($candidates as $cand) {
                if ($this->verify_password($password_plain, $cand->password)) {
                    $cand_status = isset($cand->status) ? (string)$cand->status : '1';
                    if ($cand_status === '0' || strtolower($cand_status) === 'inactive' || strtolower($cand_status) === 'disabled' || $cand_status === '2') {
                        $matched_inactive = true;
                        continue;
                    }

                    $authenticated = true;
                    $user = $cand;

                    // Automatically upgrade plain-text passwords to MD5 hash for security
                    if ($cand->password === $password_plain) {
                        $this->db->where('id', $cand->id)->update('login', array('password' => md5($password_plain)));
                    }
                    break;
                }
            }
        }

        // 2. If not authenticated in `login`, check `staff_users` table
        if (!$authenticated && $this->db->table_exists('staff_users')) {
            $this->db->select('*')->from('staff_users')->group_start();
            $this->db->where('email', $login_identifier);
            $this->db->or_where('phone', $login_identifier);
            $this->db->or_where('staff_code', $login_identifier);
            if ($this->db->field_exists('name', 'staff_users')) {
                $this->db->or_where('name', $login_identifier);
            }
            foreach ($phone_variants as $pv) {
                $this->db->or_where('phone', $pv);
            }
            $this->db->group_end();

            $staffCandidates = $this->db->get()->result();
            if (!empty($staffCandidates)) {
                foreach ($staffCandidates as $st) {
                    $st_pass = isset($st->password_hash) ? $st->password_hash : (isset($st->password) ? $st->password : '');
                    if ($this->verify_password($password_plain, $st_pass)) {
                        $st_status = isset($st->status) ? strtolower((string)$st->status) : 'active';
                        if ($st_status === '0' || $st_status === 'inactive' || $st_status === 'disabled') {
                            $matched_inactive = true;
                            continue;
                        }

                        $authenticated = true;
                        $user = (object) [
                            'id'       => $st->id,
                            'username' => !empty($st->staff_code) ? $st->staff_code : $st->email,
                            'name'     => !empty($st->name) ? $st->name : $st->staff_code,
                            'password' => $st_pass,
                            'role'     => ($st->role === 'super_admin' ? '1' : ($st->role === 'admin' ? 'A' : $st->role))
                        ];

                        if ($st_pass === $password_plain) {
                            $this->db->where('id', $st->id)->update('staff_users', array('password_hash' => md5($password_plain)));
                        }
                        break;
                    }
                }
            }
        }

        // Handle inactive account condition
        if (!$authenticated && $matched_inactive) {
            $msg = "<div class='alert alert-warning' style='border-radius:6px;'><i class='fa fa-user-lock'></i> Your account is currently disabled or inactive. Please contact the administrator.</div>";
            $this->session->set_flashdata('flashmsg', $msg);
            redirect(base_url('login'));
            return;
        }

        if (!$this->db || !$this->db->conn_id) {
            $msg = "<div class='alert alert-danger' style='border-radius:6px;'><i class='fa fa-database'></i> Database connection failed. Please check database configuration.</div>";
            $this->session->set_flashdata('flashmsg', $msg);
            redirect(base_url('login'));
            return;
        }

        if ($authenticated && !empty($user)) {
            // Strictly enforce single session: Flush patient / partner session keys
            $this->session->unset_userdata(array('useremail', 'signupuserid', 'forgotuserid', 'doctor_id', 'hospital_id', 'pathology_id', 'clinic_id'));

            $role_code = !empty($user->role) ? $user->role : '1';
            if ($role_code === 'super_admin') {
                $role_code = '1';
            } elseif ($role_code === 'admin') {
                $role_code = 'A';
            }

            $session_data = array(
                'adminuserid'      => $user->id,
                'userid'           => $user->id,
                'username'         => $user->username,
                'name'             => isset($user->name) && !empty($user->name) ? $user->name : $user->username,
                'pwd'              => $user->password,
                'code'             => $role_code,
                'institution_id'   => $user->id,
                'active_auth_role' => 'admin',
                'logged_in'        => TRUE
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
            $user_exists = (!empty($candidates) || (!empty($staffCandidates) && count($staffCandidates) > 0));
            if ($user_exists) {
                $msg = "<div class='alert alert-danger' style='border-radius:6px;'><i class='fa fa-key'></i> Incorrect password entered for <strong>" . htmlspecialchars($login_identifier) . "</strong>. Please verify your password.</div>";
            } else {
                $msg = "<div class='alert alert-danger' style='border-radius:6px;'><i class='fa fa-user-xmark'></i> No administrator account found matching <strong>" . htmlspecialchars($login_identifier) . "</strong>. Please verify your username, email, or mobile.</div>";
            }
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
