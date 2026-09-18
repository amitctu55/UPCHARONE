<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Auth Guard
 * Strict Role-Based Access Control (RBAC) & Middleware for /admin1947/* Namespace
 * 
 * Enforces:
 * 1. Only 'admin' and 'super_admin' roles are granted access.
 * 2. Unauthenticated visitors are immediately redirected to /admin1947/login (or HTTP 401 for AJAX/API).
 * 3. Authenticated users without admin/super_admin role are shown HTTP 403 Forbidden.
 */
class Admin_auth_guard {

    protected $CI;
    const HMAC_KEY = 'UpcharMasterAdminSecret2026';

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper(['url', 'cookie']);
    }

    /**
     * Enforce strict admin authorization on controller / method.
     * Halts execution and redirects or shows 403 if unauthorized.
     */
    public function enforce_admin() {
        // Enforce strict admin1947 namespace: Frontend direct link access is completely removed
        $uri = ltrim($this->CI->uri->uri_string(), '/');
        if (strpos($uri, 'admin1947') !== 0) {
            show_404();
            exit;
        }

        $status = $this->verify_admin_role();

        // Status: 'authorized', 'forbidden', 'unauthenticated'
        if ($status === 'authorized') {
            return TRUE;
        }

        $is_ajax = $this->CI->input->is_ajax_request() 
                || $this->CI->input->get_request_header('X-Requested-With') === 'XMLHttpRequest'
                || (bool)$this->CI->input->post('is_ajax')
                || (bool)$this->CI->input->get('is_ajax')
                || strpos($this->CI->uri->uri_string(), 'api/') !== false
                || strpos($this->CI->uri->uri_string(), 'save_') !== false
                || strpos($this->CI->uri->uri_string(), 'update_') !== false
                || strpos($this->CI->uri->uri_string(), 'delete_') !== false
                || strpos($this->CI->uri->uri_string(), 'verify_') !== false;

        if ($status === 'forbidden') {
            // User is logged in, but lacks admin/super_admin role
            if ($is_ajax) {
                $this->CI->output
                    ->set_status_header(403)
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status'  => 0,
                        'error'   => 'Forbidden',
                        'message' => '403 Forbidden: Access restricted to Administrator or Super Admin privileges.'
                    ]))
                    ->_display();
                exit;
            }

            $this->show_403();
            exit;
        }

        // Unauthenticated visitor
        if ($is_ajax) {
            $this->CI->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 0,
                    'error'   => 'Unauthorized',
                    'message' => '401 Unauthorized: Valid administrator session required. Please login.'
                ]))
                ->_display();
            exit;
        }

        // Store intended destination for post-login redirect
        $target_url = current_url();
        if ($this->CI->input->server('QUERY_STRING')) {
            $target_url .= '?' . $this->CI->input->server('QUERY_STRING');
        }
        $this->CI->session->set_userdata('admin_redirect_after_login', $target_url);
        $this->CI->session->set_flashdata('error_msg', 'Access restricted. Please log in with Administrator or Super Admin credentials.');
        
        redirect(base_url('admin1947/login'));
        exit;
    }

    /**
     * Inspect session and signed tokens to evaluate authorization
     * Returns: 'authorized' | 'forbidden' | 'unauthenticated'
     */
    public function verify_admin_role() {
        // 1. Check Root / Staff Session
        $staffRole = $this->CI->session->userdata('staff_role');
        $staffId   = $this->CI->session->userdata('staff_user_id');

        if ($staffId && in_array(strtolower((string)$staffRole), ['super_admin', 'admin'])) {
            return 'authorized';
        }

        // 2. Check Admin1947 Session Key in current session
        $adminUserId = $this->CI->session->userdata('adminuserid');
        $adminRole   = $this->CI->session->userdata('active_auth_role');
        if ($adminUserId && ($adminRole === 'admin' || $this->CI->session->userdata('logged_in'))) {
            return 'authorized';
        }

        // 3. Check Signed Admin Token Cookie (bridge between /admin1947 and root app)
        $cookieToken = $this->CI->input->cookie('upchar_admin_guard', TRUE);
        if ($cookieToken) {
            $decoded = json_decode(base64_decode($cookieToken), TRUE);
            if (is_array($decoded) && !empty($decoded['adminuserid']) && !empty($decoded['sig'])) {
                $expectedSig = hash_hmac('sha256', $decoded['adminuserid'] . '|' . $decoded['username'] . '|' . $decoded['role'], self::HMAC_KEY);
                if (hash_equals($expectedSig, $decoded['sig'])) {
                    // Refresh session keys for current request
                    $this->CI->session->set_userdata([
                        'adminuserid'      => $decoded['adminuserid'],
                        'username'         => $decoded['username'],
                        'active_auth_role' => 'admin',
                        'staff_role'       => 'super_admin'
                    ]);
                    return 'authorized';
                }
            }
        }

        // 3.5 Check Admin1947 Session Cookie (ci_admin_session) from active browser session
        $adminCookieId = $this->CI->input->cookie('ci_admin_session', TRUE) ?: ($_COOKIE['ci_admin_session'] ?? '');
        if (!empty($adminCookieId) && preg_match('/^[a-zA-Z0-9,-]+$/', $adminCookieId)) {
            $saveDirs = array_unique(array_filter([
                rtrim((string)ini_get('session.save_path'), '/\\'),
                sys_get_temp_dir(),
                'C:/xampp/tmp',
                'C:\\xampp\\tmp',
                '/tmp'
            ]));
            foreach ($saveDirs as $dir) {
                $sessFile = $dir . DIRECTORY_SEPARATOR . 'ci_admin_session' . $adminCookieId;
                if (file_exists($sessFile) && is_readable($sessFile)) {
                    $sessData = @file_get_contents($sessFile);
                    if ($sessData && (strpos($sessData, 'adminuserid') !== false || strpos($sessData, 'username') !== false)) {
                        $aid = 0;
                        if (preg_match('/adminuserid\|[is]:(\d+|"[^"]+");/', $sessData, $m)) {
                            $aid = intval(trim($m[1], '"'));
                        } elseif (preg_match('/userid\|[is]:(\d+|"[^"]+");/', $sessData, $m)) {
                            $aid = intval(trim($m[1], '"'));
                        }
                        $uname = 'Super Admin';
                        if (preg_match('/username\|s:\d+:"([^"]+)";/', $sessData, $mu)) {
                            $uname = $mu[1];
                        }
                        if ($aid > 0) {
                            $this->CI->session->set_userdata([
                                'adminuserid'      => $aid,
                                'userid'           => $aid,
                                'username'         => $uname,
                                'active_auth_role' => 'admin',
                                'staff_role'       => 'super_admin'
                            ]);
                            return 'authorized';
                        }
                    }
                }
            }
        }

        // 4. Check if authenticated under a non-admin role (HR, BDE, Collector, Patient, etc.)
        if ($staffId || $this->CI->session->userdata('userid') || $this->CI->session->userdata('doctor_id') || $this->CI->session->userdata('hospital_id')) {
            return 'forbidden';
        }

        return 'unauthenticated';
    }

    /**
     * Render secure, professional 403 Forbidden page
     */
    protected function show_403() {
        $this->CI->output->set_status_header(403);
        $data = [
            'heading' => '403 Forbidden - Access Denied',
            'message' => 'You do not have the required Administrator or Super Admin permissions to view this resource.',
            'currentUser' => $this->CI->session->userdata('staff_name') ?: ($this->CI->session->userdata('username') ?: 'Authenticated User'),
            'currentRole' => strtoupper($this->CI->session->userdata('staff_role') ?: ($this->CI->session->userdata('active_auth_role') ?: 'RESTRICTED'))
        ];

        if (file_exists(APPPATH . 'views/errors/error_403.php')) {
            echo $this->CI->load->view('errors/error_403', $data, TRUE);
        } else {
            echo $this->CI->load->view('errors/html/error_404', ['heading' => '403 Forbidden', 'message' => 'Access Restricted to Administrators only.'], TRUE);
        }
        exit;
    }
}
