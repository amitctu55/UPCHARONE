<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");

        // Auth check
        if (!$this->session->userdata('adminuserid') && !$this->session->userdata('userid') && !$this->session->userdata('username')) {
            redirect(base_url() . 'login');
        }

        $this->load->library('settings_lib');
        $this->load->model('settings_model');
        $this->load->helper(array('settings', 'url', 'form'));
    }

    /**
     * Main Portal View
     */
    public function index($active_tab = 'general') {
        $tab = $this->input->get('tab') ?: $active_tab;
        $allowed_tabs = ['general', 'email', 'sms', 'integrations', 'security', 'audit', 'health'];
        if (!in_array($tab, $allowed_tabs)) {
            $tab = 'general';
        }

        $data['active_tab'] = $tab;
        $data['settings'] = $this->settings_lib->get_all();
        $data['system_health'] = $this->settings_model->get_system_health();

        // Audit logs data if viewing audit tab
        $audit_category = $this->input->get('log_category') ?: 'ALL';
        $audit_search = $this->input->get('search') ?: null;
        $data['audit_category'] = $audit_category;
        $data['audit_search'] = $audit_search;
        $data['audit_logs'] = $this->settings_model->get_audit_logs(100, 0, $audit_category, $audit_search);
        $data['total_audit_count'] = $this->settings_model->get_audit_logs_count($audit_category, $audit_search);

        // Load AdminLTE Layout views
        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('settings_dashboard', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    // Direct tab route shortcuts
    public function general() { $this->index('general'); }
    public function email() { $this->index('email'); }
    public function sms() { $this->index('sms'); }
    public function integrations() { $this->index('integrations'); }
    public function security() { $this->index('security'); }
    public function audit() { $this->index('audit'); }
    public function health() { $this->index('health'); }

    /**
     * Save Configuration Form Submission (AJAX & standard POST)
     */
    public function save() {
        $category = $this->input->post('category', TRUE) ?: 'general';
        $is_ajax = $this->input->is_ajax_request();

        // Admin username and IP
        $admin_user = $this->session->userdata('username') ?: 'SuperAdmin';
        $ip_address = $this->input->ip_address();

        $post_data = $this->input->post(NULL, FALSE); // Keep raw for passwords/special chars
        unset($post_data['category'], $post_data['submit']);

        $uploaded_files = [];

        // Process File Uploads (Logos, Favicon, FCM JSON)
        if (!empty($_FILES)) {
            $upload_path = FCPATH . 'public/uploads/settings/';
            if (!is_dir($upload_path)) {
                @mkdir($upload_path, 0777, true);
            }

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|ico|svg|json';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            foreach ($_FILES as $field_name => $file_info) {
                if (!empty($file_info['name'])) {
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload($field_name)) {
                        $upload_res = $this->upload->data();
                        $uploaded_files[$field_name] = 'public/uploads/settings/' . $upload_res['file_name'];
                    } else {
                        $error_msg = $this->upload->display_errors('', '');
                        if ($is_ajax) {
                            echo json_encode(['status' => 'error', 'message' => "Upload error for {$field_name}: {$error_msg}"]);
                            return;
                        }
                    }
                }
            }
        }

        // Save Category Data via Settings_lib
        $result = $this->settings_lib->save_category($category, $post_data, $uploaded_files, $admin_user, $ip_address);

        if ($is_ajax) {
            echo json_encode([
                'status' => 'success',
                'message' => $result['message'],
                'changed_count' => $result['changed_count'],
                'uploaded_files' => $uploaded_files
            ]);
            return;
        }

        $flash_type = $result['status'] ? 'success' : 'danger';
        $this->session->set_flashdata('flashmsg', "<div class='alert alert-{$flash_type}'><strong>" . ucfirst($flash_type) . "!</strong> {$result['message']}</div>");
        redirect(base_url('settings') . '?tab=' . $category);
    }

    /**
     * Send Test Email Verification
     */
    public function send_test_email() {
        $to_email = trim($this->input->post('test_email', TRUE));
        $provider = $this->input->post('email_provider', TRUE) ?: get_system_setting('email_provider', 'smtp');

        if (empty($to_email) || !filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Please provide a valid recipient email address.']);
            return;
        }

        $from_name = get_system_setting('mail_from_name', 'Upchar Healthcare');
        $from_email = get_system_setting('mail_from_email', 'noreply@upchar.com');
        $subject = "Upchar Gateway Test Email - " . date('d M Y H:i:s');
        $body = "<h2>Upchar Healthcare System Test Email</h2><p>This is a verification test email sent from the Upchar Admin System Settings Portal.</p><p><strong>Provider:</strong> " . strtoupper($provider) . "<br><strong>Timestamp:</strong> " . date('Y-m-d H:i:s T') . "<br><strong>Status:</strong> Gateway is operating properly.</p>";

        $debug_log = '';

        if ($provider === 'sendgrid') {
            $api_key = get_system_setting('sendgrid_api_key');
            if (empty($api_key)) {
                echo json_encode(['status' => 'error', 'message' => 'SendGrid API Key is not configured.']);
                return;
            }

            $payload = [
                'personalizations' => [['to' => [['email' => $to_email]]]],
                'from' => ['email' => $from_email, 'name' => $from_name],
                'subject' => $subject,
                'content' => [['type' => 'text/html', 'value' => $body]]
            ];

            $ch = curl_init('https://api.sendgrid.com/v3/mail/send');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $api_key,
                'Content-Type: application/json'
            ]);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code >= 200 && $http_code < 300) {
                echo json_encode(['status' => 'success', 'message' => "Test email delivered successfully via SendGrid to {$to_email}.", 'debug' => "HTTP {$http_code} Accepted."]);
            } else {
                echo json_encode(['status' => 'error', 'message' => "SendGrid API returned HTTP {$http_code}: {$response}", 'debug' => $response]);
            }
            return;
        }

        // Standard SMTP or Native Mail
        $smtp_host = get_system_setting('smtp_host', 'smtp.gmail.com');
        $smtp_port = get_system_setting('smtp_port', '587');
        $smtp_crypto = get_system_setting('smtp_crypto', 'tls');
        $smtp_user = get_system_setting('smtp_user', '');
        $smtp_pass = get_system_setting('smtp_pass', '');

        $this->load->library('email');
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => $smtp_host,
            'smtp_port' => (int)$smtp_port,
            'smtp_user' => $smtp_user,
            'smtp_pass' => $smtp_pass,
            'smtp_crypto' => $smtp_crypto !== 'none' ? $smtp_crypto : '',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'wordwrap'  => TRUE
        );

        $this->email->initialize($config);
        $this->email->from($from_email, $from_name);
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($body);

        if ($this->email->send()) {
            echo json_encode(['status' => 'success', 'message' => "Test email successfully sent to {$to_email} via SMTP.", 'debug' => $this->email->print_debugger(['headers'])]);
        } else {
            $debug_log = $this->email->print_debugger();
            echo json_encode(['status' => 'error', 'message' => "SMTP delivery failed. Check your host, port, authentication credentials, and firewall settings.", 'debug' => $debug_log]);
        }
    }

    /**
     * Send Test SMS Verification
     */
    public function send_test_sms() {
        $mobile = trim($this->input->post('test_mobile', TRUE));
        $message = trim($this->input->post('test_message', TRUE)) ?: "Upchar Healthcare test SMS verification code: " . rand(100000, 999999);
        $provider = get_system_setting('sms_provider', 'msg91');

        if (empty($mobile) || strlen($mobile) < 10) {
            echo json_encode(['status' => 'error', 'message' => 'Please enter a valid 10-digit mobile number.']);
            return;
        }

        $result_status = 'error';
        $result_msg = '';
        $raw_response = '';

        if ($provider === 'twilio') {
            $sid = get_system_setting('twilio_sid');
            $token = get_system_setting('twilio_token');
            $from = get_system_setting('twilio_from');

            if (empty($sid) || empty($token) || empty($from)) {
                echo json_encode(['status' => 'error', 'message' => 'Twilio credentials (SID, Token, From Number) are incomplete.']);
                return;
            }

            // Format mobile for Twilio (ensure + prefix)
            $to = (strpos($mobile, '+') === 0) ? $mobile : '+91' . preg_replace('/\D/', '', $mobile);

            $ch = curl_init("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_USERPWD, "{$sid}:{$token}");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'From' => $from,
                'To' => $to,
                'Body' => $message
            ]));
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $res_arr = @json_decode($response, true);
            if ($http_code >= 200 && $http_code < 300) {
                $result_status = 'success';
                $result_msg = "Twilio SMS dispatched successfully to {$mobile}. SID: " . ($res_arr['sid'] ?? 'OK');
            } else {
                $result_msg = "Twilio error: " . ($res_arr['message'] ?? $response);
            }
            $raw_response = $response;

        } elseif ($provider === 'fast2sms') {
            $api_key = get_system_setting('fast2sms_api_key');
            if (empty($api_key)) {
                echo json_encode(['status' => 'error', 'message' => 'Fast2SMS API Key is not configured.']);
                return;
            }

            $fields = [
                'sender_id' => get_system_setting('default_sender_id', 'TXTIND'),
                'message' => $message,
                'language' => 'english',
                'route' => 'v3',
                'numbers' => preg_replace('/\D/', '', $mobile),
            ];

            $ch = curl_init('https://www.fast2sms.com/dev/bulkV2');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'authorization: ' . $api_key
            ]);
            $response = curl_exec($ch);
            curl_close($ch);

            $res_arr = @json_decode($response, true);
            if (!empty($res_arr['return'])) {
                $result_status = 'success';
                $result_msg = "Fast2SMS message sent successfully to {$mobile}.";
            } else {
                $result_msg = "Fast2SMS error: " . ($res_arr['message'][0] ?? $response);
            }
            $raw_response = $response;

        } else {
            // Default Msg91
            $auth_key = get_system_setting('msg91_auth_key');
            $sender = get_system_setting('msg91_sender_id', 'UPCARE');
            $template_id = get_system_setting('msg91_dlt_te_id', '1507161519686689997');

            if (empty($auth_key)) {
                // If no custom key, test via standard HTTP bulk gateway endpoint
                $auth_key = '45C6DA05EDD0DC';
            }

            $clean_mobile = preg_replace('/\D/', '', $mobile);
            $url = "http://bulksms.smsroot.com/app/smsapi/index.php?key={$auth_key}&campaign=0&routeid=13&type=text&contacts={$clean_mobile}&senderid={$sender}&msg=" . urlencode($message) . "&template_id={$template_id}";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code == 200 && !empty($response)) {
                $result_status = 'success';
                $result_msg = "SMS sent via Msg91 Gateway to {$clean_mobile}. Response: " . substr($response, 0, 100);
            } else {
                $result_msg = "Gateway connection error (HTTP {$http_code}): {$response}";
            }
            $raw_response = $response;
        }

        echo json_encode([
            'status' => $result_status,
            'message' => $result_msg,
            'provider' => strtoupper($provider),
            'raw_response' => $raw_response
        ]);
    }

    /**
     * Send Test WhatsApp Message
     */
    public function send_test_whatsapp() {
        $mobile = trim($this->input->post('test_mobile', TRUE));
        $message = trim($this->input->post('test_message', TRUE)) ?: "Hello from Upchar Healthcare! This is a test notification from your WhatsApp Business API integration.";
        
        $wa_token = get_system_setting('wa_access_token');
        $wa_phone_id = get_system_setting('wa_phone_number_id');

        if (empty($wa_token) || empty($wa_phone_id)) {
            echo json_encode(['status' => 'error', 'message' => 'WhatsApp Meta Cloud API credentials (Phone Number ID and Access Token) are missing.']);
            return;
        }

        $clean_phone = preg_replace('/\D/', '', $mobile);
        if (strlen($clean_phone) === 10) {
            $clean_phone = '91' . $clean_phone;
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $clean_phone,
            'type' => 'text',
            'text' => ['body' => $message]
        ];

        $ch = curl_init("https://graph.facebook.com/v19.0/{$wa_phone_id}/messages");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $wa_token,
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $res_arr = @json_decode($response, true);
        if ($http_code >= 200 && $http_code < 300) {
            echo json_encode(['status' => 'success', 'message' => "WhatsApp message dispatched successfully to {$clean_phone} via Meta API.", 'raw' => $response]);
        } else {
            echo json_encode(['status' => 'error', 'message' => "WhatsApp API returned error (HTTP {$http_code}): " . ($res_arr['error']['message'] ?? $response), 'raw' => $response]);
        }
    }

    /**
     * Test Third-Party Integration Credentials (ABDM, Razorpay, Google Maps)
     */
    public function test_integration() {
        $type = $this->input->post('type', TRUE);

        if ($type === 'abdm') {
            $client_id = get_system_setting('abdm_client_id');
            $client_secret = get_system_setting('abdm_client_secret');
            $sandbox = get_system_setting('abdm_sandbox_mode', '1');

            if (empty($client_id)) {
                echo json_encode(['status' => 'error', 'message' => 'ABDM Client ID is missing.']);
                return;
            }

            $endpoint = ($sandbox == '1') ? 'https://dev.abdm.gov.in/gateway/v0.5/sessions' : 'https://gateway.abdm.gov.in/v0.5/sessions';
            
            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['clientId' => $client_id, 'clientSecret' => $client_secret]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $res = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code == 200) {
                echo json_encode(['status' => 'success', 'message' => 'ABDM Gateway Authentication Verified Successfully! Access token generated.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => "ABDM verification returned HTTP {$code}. Response: " . substr($res, 0, 150)]);
            }

        } elseif ($type === 'maps') {
            $key = get_system_setting('google_maps_api_key');
            if (empty($key)) {
                echo json_encode(['status' => 'error', 'message' => 'Google Maps API Key is empty.']);
                return;
            }

            $ch = curl_init("https://maps.googleapis.com/maps/api/geocode/json?address=Delhi,India&key=" . urlencode($key));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);
            $data = @json_decode($res, true);

            if (!empty($data['status']) && $data['status'] === 'OK') {
                echo json_encode(['status' => 'success', 'message' => 'Google Maps API Key is valid and Geocoding is active!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Google Maps API returned: ' . ($data['error_message'] ?? ($data['status'] ?? 'Invalid Key'))]);
            }

        } elseif ($type === 'razorpay') {
            $key_id = get_system_setting('razorpay_key_id');
            $key_secret = get_system_setting('razorpay_key_secret');

            if (empty($key_id) || empty($key_secret)) {
                echo json_encode(['status' => 'error', 'message' => 'Razorpay Key ID and Key Secret are required.']);
                return;
            }

            $ch = curl_init('https://api.razorpay.com/v1/payments?count=1');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, "{$key_id}:{$key_secret}");
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $res = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code == 200) {
                echo json_encode(['status' => 'success', 'message' => 'Razorpay API credentials verified successfully!']);
            } else {
                $err = @json_decode($res, true);
                echo json_encode(['status' => 'error', 'message' => 'Razorpay Authentication Failed: ' . ($err['error']['description'] ?? "HTTP {$code}")]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unknown integration type']);
        }
    }

    /**
     * Clear Cache Endpoint
     */
    public function clear_cache() {
        $this->settings_lib->clear_cache();
        echo json_encode(['status' => 'success', 'message' => 'Application settings cache flushed successfully.']);
    }

    /**
     * Download Database SQL Backup
     */
    public function download_db_backup() {
        $backup = $this->settings_model->generate_db_backup();
        $this->load->helper('download');
        force_download('upchar_db_backup_' . date('Ymd_His') . '.sql', $backup);
    }
}
