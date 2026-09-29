<?php
defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Class Register
 * 
 * Unified Identity Registration Controller for Upchar Ecosystem.
 */
class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->helper(['url', 'cookie']);
    }

    public function index() {
        if ($this->input->method() === 'post') {
            return $this->submit();
        }
        $this->load->view('sign_up');
    }

    /**
     * Submit Registration
     */
    public function submit() {
        $name     = trim($this->input->post('name') ?: ($this->input->post('fname') . ' ' . $this->input->post('lname')));
        $email    = strtolower(trim($this->input->post('email')));
        $mobile   = trim($this->input->post('mobile'));
        $password = $this->input->post('password');
        $bgroup   = $this->input->post('blood_group') ?: $this->input->post('bgroup');
        $gender   = $this->input->post('gender') ?: 'MALE';

        if (empty($name) || (empty($email) && empty($mobile))) {
            echo json_encode([
                'status'  => 'failed',
                'msg'     => 'Name and either Mobile or Email are required.',
                'matched_existing_profile' => false
            ]);
            return;
        }

        // 1. Check if user already exists in master table
        $existing = null;
        if ($email) {
            $existing = $this->Auth_model->find_master_user($email);
        }
        if (!$existing && $mobile) {
            $existing = $this->Auth_model->find_master_user($mobile);
        }

        if ($existing) {
            echo json_encode([
                'status'                   => 'exists',
                'msg'                      => 'An account with this email/mobile already exists in the Upchar ecosystem. Please log in.',
                'matched_existing_profile' => true,
                'master_user_id'           => (int)$existing['id'],
                'uuid'                     => $existing['uuid'],
                'roles'                    => $existing['roles'],
            ]);
            return;
        }

        // 2. Create Master User
        $masterUser = $this->Auth_model->register_master_user([
            'name'     => $name,
            'email'    => $email,
            'mobile'   => $mobile,
            'password' => $password,
            'status'   => 'Active',
        ]);

        // 3. Link Patient Profile
        $this->Auth_model->link_role_profile($masterUser['id'], 'patient', [
            'blood_group'        => $bgroup,
            'gender'             => $gender,
            'emergency_contacts' => $this->input->post('emergency_contacts') ?: null,
            'allergies'          => $this->input->post('allergies') ?: null,
        ]);

        // 4. Also mirror into legacy userlogin for backward compatibility with old CI modules
        $names = explode(' ', $name, 2);
        $this->db->insert('userlogin', [
            'USERID'   => $masterUser['id'],
            'FNAME'    => $names[0] ?? $name,
            'LNAME'    => $names[1] ?? '',
            'EMAIL'    => $email,
            'MOBILE'   => $mobile,
            'PASSWORD' => md5($password),
            'BGROUP'   => $bgroup,
            'GENDER'   => $gender,
            'STATUS'   => '1',
            'APPROVED' => '1',
        ]);

        // Set session & SSO token
        $this->session->set_userdata([
            'USERID'   => $masterUser['id'],
            'userid'   => $masterUser['id'],
            'username' => $masterUser['name'],
            'name'     => $masterUser['name'],
            'email'    => $masterUser['email'],
            'mobile'   => $masterUser['mobile'],
            'uuid'     => $masterUser['uuid'],
        ]);

        $ssoToken = $this->Auth_model->generate_sso_token($masterUser);
        setcookie('upchar_sso_token', $ssoToken, time() + 604800, '/demo/', '', false, false);

        echo json_encode([
            'status'                   => 'success',
            'msg'                      => 'Registered successfully in the Upchar ecosystem!',
            'matched_existing_profile' => false,
            'master_user_id'           => (int)$masterUser['id'],
            'uuid'                     => $masterUser['uuid'],
            'sso_token'                => $ssoToken,
            'redirect_url'             => base_url('myappointments')
        ]);
    }
}
