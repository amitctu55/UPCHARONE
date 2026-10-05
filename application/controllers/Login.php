<?php
defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Class Login
 * 
 * Unified Identity and Single Sign-On (SSO) Authentication Controller
 * for Upchar Ecosystem.
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('User_Model');
        $this->load->library('session');
        $this->load->helper(['url', 'cookie']);
    }

    public function index() {
        if ($this->input->method() === 'post') {
            return $this->authenticate();
        }

        // Check if already authenticated via session or SSO cookie
        $ssoCookie = $this->input->cookie('upchar_sso_token');
        if ($ssoCookie) {
            $payload = $this->Auth_model->verify_sso_token($ssoCookie);
            if ($payload && !empty($payload['sub'])) {
                $masterUser = $this->Auth_model->find_master_user($payload['sub']);
                if ($masterUser) {
                    $this->_set_user_session($masterUser);
                    redirect('myappointments');
                    return;
                }
            }
        }

        $this->load->view('login');
    }

    /**
     * Unified Login Authentication
     */
    public function authenticate() {
        $identifier = $this->input->post('email') ?: $this->input->post('username') ?: $this->input->post('mobile');
        $password   = $this->input->post('password');

        if (empty($identifier) || empty($password)) {
            echo json_encode([
                'status'  => 'failed',
                'msg'     => 'Mobile/Email and password are required.',
                'matched_existing_profile' => false
            ]);
            return;
        }

        // 1. Check Master Identity Layer first
        $masterUser = $this->Auth_model->find_master_user($identifier);

        if ($masterUser && $this->Auth_model->verify_master_password($masterUser, $password)) {
            // Check status
            if ($masterUser['status'] === 'Suspended') {
                echo json_encode([
                    'status' => 'failed',
                    'msg'    => 'Account has been suspended. Please contact support.',
                    'matched_existing_profile' => true
                ]);
                return;
            }

            // Set session & cross-app SSO cookie
            $this->_set_user_session($masterUser);
            $ssoToken = $this->Auth_model->generate_sso_token($masterUser);

            // Set cookie across the /demo/ path
            setcookie('upchar_sso_token', $ssoToken, time() + 604800, '/demo/', '', false, false);

            $redirectUrl = $this->session->userdata('last_page') ?: base_url('myappointments');
            $this->session->unset_userdata('last_page');

            $payload = [
                'status'                   => 'success',
                'msg'                      => 'Logged in successfully via Unified Identity',
                'matched_existing_profile' => true,
                'master_user_id'           => (int)$masterUser['id'],
                'uuid'                     => $masterUser['uuid'],
                'name'                     => $masterUser['name'],
                'mobile'                   => $masterUser['mobile'],
                'email'                    => $masterUser['email'],
                'roles'                    => $masterUser['roles'],
                'sso_token'                => $ssoToken,
                'redirect_url'             => $redirectUrl,
            ];
            while (ob_get_level() > 0) { @ob_end_clean(); }
            session_write_close();
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($payload));
            $this->output->_display();
            exit;
        }

        // 2. Fallback to Legacy User_Model check
        $legacyEmail = strtolower($identifier);
        $legacyPass  = md5($password);
        $loginResult = $this->User_Model->login($legacyEmail, $legacyPass);

        if ($loginResult === 'SUCCESS') {
            $legacyUser = $this->db->get_where('userlogin', ['EMAIL' => $legacyEmail])->row_array()
                ?: $this->db->get_where('userlogin', ['MOBILE' => $identifier])->row_array();

            $masterUser = null;
            if ($legacyUser) {
                // Register or update into master identity
                $masterUser = $this->Auth_model->register_master_user([
                    'name'     => trim(($legacyUser['FNAME'] ?? '') . ' ' . ($legacyUser['LNAME'] ?? '')),
                    'email'    => $legacyUser['EMAIL'],
                    'mobile'   => $legacyUser['MOBILE'],
                    'password' => $password,
                ]);
                if ($masterUser) {
                    $this->Auth_model->link_role_profile($masterUser['id'], 'patient', [
                        'blood_group' => $legacyUser['BGROUP'] ?? null,
                        'dob'         => $legacyUser['DOB'] ?? null,
                        'gender'      => $legacyUser['GENDER'] ?? null,
                    ]);
                    $this->_set_user_session($masterUser);
                    $ssoToken = $this->Auth_model->generate_sso_token($masterUser);
                    setcookie('upchar_sso_token', $ssoToken, time() + 604800, '/demo/', '', false, false);
                }
            }

            $payload = [
                'status'                   => 'success',
                'msg'                      => 'Logged in Successfully',
                'matched_existing_profile' => true,
                'master_user_id'           => $masterUser ? (int)$masterUser['id'] : null,
                'redirect_url'             => base_url('myappointments')
            ];
            while (ob_get_level() > 0) { @ob_end_clean(); }
            session_write_close();
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($payload));
            $this->output->_display();
            exit;
        }

        while (ob_get_level() > 0) { @ob_end_clean(); }
        $this->output
            ->set_status_header(401)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'status'                   => 'failed',
                'msg'                      => 'Incorrect Mobile/Email or Password',
                'matched_existing_profile' => false
            ]));
        $this->output->_display();
        exit;
    }

    /**
     * Cross-App Seamless Navigation to Ambulance Portal
     * Redirects with authenticated SSO token
     */
    public function launch_ambulance() {
        $userId = $this->session->userdata('USERID') ?: $this->session->userdata('userid');
        if (!$userId) {
            redirect(base_url('login?redirect=' . urlencode('/demo/upchar-ambulance/')));
            return;
        }

        $masterUser = $this->Auth_model->find_master_user($userId);
        if (!$masterUser) {
            redirect('/demo/upchar-ambulance/');
            return;
        }

        $token = $this->Auth_model->generate_sso_token($masterUser);
        setcookie('upchar_sso_token', $token, time() + 604800, '/demo/', '', false, false);

        redirect('http://localhost/demo/upchar-ambulance/sso/consume?token=' . urlencode($token));
    }

    /**
     * Set CodeIgniter session variables
     */
    private function _set_user_session($masterUser) {
        $this->session->set_userdata([
            'USERID'   => $masterUser['id'],
            'userid'   => $masterUser['id'],
            'WEB_UID'  => $masterUser['id'],
            'username' => $masterUser['name'],
            'name'     => $masterUser['name'],
            'email'    => $masterUser['email'],
            'mobile'   => $masterUser['mobile'],
            'uuid'     => $masterUser['uuid'],
            'status'   => $masterUser['status'],
        ]);
    }

    public function logout() {
        $this->session->sess_destroy();
        setcookie('upchar_sso_token', '', time() - 3600, '/demo/', '', false, false);
        redirect(base_url());
    }
}
