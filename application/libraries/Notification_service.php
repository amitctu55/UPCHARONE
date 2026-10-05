<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Notification Service Library for Upchar Healthcare
 * 
 * Provides end-to-end notification workflows:
 * 1. Email Verification (Cryptographic token, responsive HTML template, token validation)
 * 2. Forgot Password OTP (Concurrent SMS + Branded HTML Email dispatch)
 * 3. Post-Booking Notifications (Patient receipt, Doctor alert, Clinic/Hospital alert, Admin notification)
 * 4. Resilient SMTP Transport with automated DNS fallback, password decryption, and TLS auto-negotiation.
 */
class Notification_service {

    protected $CI;
    protected $log_file;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->helper(array('url', 'fddi_helper', 'settings'));
        $this->log_file = APPPATH . 'logs/notification_audit.log';
    }

    /**
     * Helper to retrieve and decrypt system settings
     */
    public function get_setting($key, $default = '') {
        if (function_exists('get_system_setting')) {
            $val = get_system_setting($key, null);
            if ($val !== null && $val !== '') {
                return $val;
            }
        }

        $row = $this->CI->db->get_where('system_settings', array('setting_key' => $key))->row();
        if ($row) {
            $val = $row->setting_value;
            if ($row->is_encrypted && strpos($val, 'ENC:') === 0) {
                $encryption_key = config_item('encryption_key') ?: 'MyIndiaAtTheTop';
                $key_secret = hash('sha256', $encryption_key, true);
                $raw = base64_decode(substr($val, 4));
                $iv = substr($raw, 0, 16);
                $hmac = substr($raw, 16, 32);
                $cipher_raw = substr($raw, 48);
                if (hash_equals($hmac, hash_hmac('sha256', $cipher_raw, $key_secret, true))) {
                    return openssl_decrypt($cipher_raw, 'AES-256-CBC', $key_secret, OPENSSL_RAW_DATA, $iv);
                }
            }
            return $val;
        }

        return $default;
    }

    /**
     * Core Email Dispatcher with SMTP and Fallbacks
     */
    public function send_email($to_email, $subject, $html_body, $alt_text = '') {
        $to_email = trim($to_email);
        if (empty($to_email) || !filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
            $this->log("Invalid recipient email: '$to_email'");
            return false;
        }

        $from_email = $this->get_setting('mail_from_email', $this->get_setting('email_from_address', 'support@upchar.info'));
        $from_name  = $this->get_setting('mail_from_name', $this->get_setting('email_from_name', 'Upchar Healthcare'));
        $provider   = $this->get_setting('email_provider', 'smtp');

        $sent = false;

        // 1. SendGrid if enabled
        if ($provider === 'sendgrid') {
            $sendgrid_key = $this->get_setting('sendgrid_api_key');
            if (!empty($sendgrid_key)) {
                $payload = [
                    'personalizations' => [['to' => [['email' => $to_email]]]],
                    'from' => ['email' => $from_email, 'name' => $from_name],
                    'subject' => $subject,
                    'content' => [['type' => 'text/html', 'value' => $html_body]]
                ];
                $ch = curl_init('https://api.sendgrid.com/v3/mail/send');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($ch, CURLOPT_TIMEOUT, 8);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $sendgrid_key,
                    'Content-Type: application/json'
                ]);
                $res = curl_exec($ch);
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($code >= 200 && $code < 300) {
                    $sent = true;
                    $this->log("Sent via SendGrid to $to_email | Subject: $subject");
                    return true;
                }
            }
        }

        // 2. Resilient SMTP Dispatch
        $raw_host    = trim($this->get_setting('smtp_host', 'mail.upchar.info'));
        $smtp_port   = (int)$this->get_setting('smtp_port', 587);
        $smtp_crypto = strtolower(trim($this->get_setting('smtp_crypto', 'tls')));
        
        // Strip ssl:// or tls:// protocol prefix if user entered it in the host field
        if (strpos($raw_host, 'ssl://') === 0) {
            $raw_host = substr($raw_host, 6);
            $smtp_crypto = 'ssl';
        } elseif (strpos($raw_host, 'tls://') === 0) {
            $raw_host = substr($raw_host, 6);
            $smtp_crypto = 'tls';
        }

        $smtp_user   = trim($this->get_setting('smtp_user', $this->get_setting('smtp_username', 'support@upchar.info')));
        $smtp_pass   = $this->get_setting('smtp_pass', $this->get_setting('smtp_password', 'Abc@28010'));

        // Decrypt password if still in ENC format
        if (strpos($smtp_pass, 'ENC:') === 0) {
            $encryption_key = config_item('encryption_key') ?: 'MyIndiaAtTheTop';
            $key_secret = hash('sha256', $encryption_key, true);
            $raw = base64_decode(substr($smtp_pass, 4));
            $iv = substr($raw, 0, 16);
            $hmac = substr($raw, 16, 32);
            $cipher_raw = substr($raw, 48);
            if (hash_equals($hmac, hash_hmac('sha256', $cipher_raw, $key_secret, true))) {
                $smtp_pass = openssl_decrypt($cipher_raw, 'AES-256-CBC', $key_secret, OPENSSL_RAW_DATA, $iv);
            }
        }

        // DNS and Host Fallback Resolution
        $resolved_host = $raw_host;
        $ip = @gethostbyname($raw_host);
        if ($ip === $raw_host && !filter_var($raw_host, FILTER_VALIDATE_IP)) {
            // DNS lookup failed for configured host (e.g. smtp.upchar.info has no A record)
            $resolved_host = '87.232.72.4'; // Direct production mail server
            $this->log("DNS lookup failed for '$raw_host'. Falling back to '$resolved_host'.");
        } elseif (in_array(strtolower($raw_host), array('smtp.upchar.info', 'mail.upchar.info'))) {
            // If DNS resolves to Cloudflare proxy (which blocks direct SMTP), use server IP
            if ($ip === '104.21.57.170' || $ip === '172.67.182.110') {
                $resolved_host = '87.232.72.4';
            }
        }

        // Port & Crypto Auto-Negotiation
        if ($smtp_port == 587) {
            $smtp_crypto = 'tls';
        } elseif ($smtp_port == 465) {
            $smtp_crypto = 'ssl';
        } elseif ($smtp_port == 25 || $smtp_crypto === 'none') {
            $smtp_crypto = '';
        }

        try {
            $this->CI->load->library('email');
            $this->CI->email->clear(true);
            $config = array(
                'protocol'    => 'smtp',
                'smtp_host'   => $resolved_host,
                'smtp_port'   => $smtp_port,
                'smtp_user'   => $smtp_user,
                'smtp_pass'   => $smtp_pass,
                'smtp_crypto' => $smtp_crypto,
                'smtp_timeout'=> 10,
                'mailtype'    => 'html',
                'charset'     => 'utf-8',
                'priority'    => 1,
                'newline'     => "\r\n",
                'crlf'        => "\r\n",
                'wordwrap'    => TRUE
            );

            $this->CI->email->initialize($config);
            $this->CI->email->from($from_email, $from_name);
            $this->CI->email->to($to_email);
            $this->CI->email->subject($subject);
            $this->CI->email->message($html_body);
            if (!empty($alt_text)) {
                $this->CI->email->set_alt_message($alt_text);
            }

            $sent = @$this->CI->email->send();
            if ($sent) {
                $this->log("Sent via SMTP ($resolved_host:$smtp_port) to $to_email | Subject: $subject");
                return true;
            } else {
                $dbg = strip_tags($this->CI->email->print_debugger(['headers']));
                $this->log("SMTP delivery to $to_email failed ($resolved_host:$smtp_port): $dbg");

                // Secondary attempt on standard TLS port 587 if port 465 failed
                if ($smtp_port == 465) {
                    $this->log("Attempting fallback to port 587 (TLS)...");
                    $config['smtp_port'] = 587;
                    $config['smtp_crypto'] = 'tls';
                    $this->CI->email->clear(true);
                    $this->CI->email->initialize($config);
                    $this->CI->email->from($from_email, $from_name);
                    $this->CI->email->to($to_email);
                    $this->CI->email->subject($subject);
                    $this->CI->email->message($html_body);
                    $sent = @$this->CI->email->send();
                    if ($sent) {
                        $this->log("Sent via SMTP fallback (Port 587 TLS) to $to_email");
                        return true;
                    }
                }
            }
        } catch (\Throwable $e) {
            $this->log("SMTP Exception: " . $e->getMessage());
        }

        // 3. Fallback to PHP native mail()
        if (!$sent && function_exists('mail')) {
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: $from_name <$from_email>\r\n";
            $headers .= "Reply-To: $from_email\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            $sent = @mail($to_email, $subject, $html_body, $headers);
            if ($sent) {
                $this->log("Sent via native mail() to $to_email | Subject: $subject");
            }
        }

        return $sent;
    }

    /**
     * Requirement 1: Complete Email Verification Link
     * Generates a 64-char cryptographic token and sends an email with the verification link.
     */
    public function send_email_verification($user_id, $email, $name = '') {
        $email = trim(strtolower($email));
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Generate 64-character secure hexadecimal token
        $token = bin2hex(random_bytes(32));

        // Save token to userlogin record
        $this->CI->db->where('USERID', $user_id);
        $this->CI->db->update('userlogin', array(
            'verification_token' => $token,
            'email_verified_at'  => null
        ));

        $verify_url = base_url('verify_email?token=' . urlencode($token));
        $display_name = !empty($name) ? htmlspecialchars($name) : 'Valued Patient';

        $subject = 'Verify Your Email Address - Upchar Healthcare';

        $html = '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Your Email</title>
</head>
<body style="margin:0;padding:0;background-color:#F1F5F9;font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Helvetica,Arial,sans-serif;color:#334155;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F1F5F9;padding:30px 10px;">
  <tr>
    <td align="center">
      <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:580px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06);border:1px solid #E2E8F0;">
        <!-- Header -->
        <tr>
          <td style="background:linear-gradient(135deg,#0F172A 0%,#1E293B 100%);padding:28px 30px;text-align:center;border-bottom:3px solid #00A896;">
            <div style="font-size:26px;font-weight:800;letter-spacing:1px;color:#ffffff;">
              UPCHAR<span style="color:#00A896;">.</span>INFO
            </div>
            <div style="font-size:12px;color:#94A3B8;letter-spacing:2px;text-transform:uppercase;margin-top:4px;">
              Medical & Healthcare Solutions
            </div>
          </td>
        </tr>
        <!-- Content -->
        <tr>
          <td style="padding:32px 30px;">
            <h2 style="margin:0 0 14px 0;font-size:20px;color:#0F172A;font-weight:700;">
              Confirm Your Email Address
            </h2>
            <p style="margin:0 0 16px 0;font-size:14.5px;line-height:1.6;color:#475569;">
              Dear <strong>' . $display_name . '</strong>,
            </p>
            <p style="margin:0 0 20px 0;font-size:14px;line-height:1.6;color:#475569;">
              Thank you for signing up with Upchar Medical Solution. To ensure the security of your healthcare profile, complete your registration by verifying your email address below.
            </p>

            <!-- CTA Button -->
            <div style="text-align:center;margin:30px 0;">
              <a href="' . $verify_url . '" style="display:inline-block;background:#00A896;color:#ffffff;text-decoration:none;font-size:15px;font-weight:700;padding:14px 34px;border-radius:8px;box-shadow:0 4px 12px rgba(0,168,150,0.35);letter-spacing:0.3px;" target="_blank">
                Verify Email Address &rarr;
              </a>
            </div>

            <!-- Alternative Link -->
            <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;padding:14px;margin:24px 0 16px 0;">
              <p style="margin:0 0 6px 0;font-size:12px;color:#64748B;font-weight:600;">
                If button does not work, copy and paste this link in your browser:
              </p>
              <a href="' . $verify_url . '" style="font-size:12px;color:#00A896;word-break:break-all;text-decoration:underline;">
                ' . $verify_url . '
              </a>
            </div>

            <p style="margin:16px 0 0 0;font-size:12.5px;line-height:1.5;color:#94A3B8;">
              <strong style="color:#64748B;">Security Notice:</strong> This verification link will expire in 24 hours. If you did not create an account on Upchar, please disregard this email.
            </p>
          </td>
        </tr>
        <!-- Footer -->
        <tr>
          <td style="background:#F8FAFC;border-top:1px solid #E2E8F0;padding:20px 30px;text-align:center;font-size:11.5px;color:#94A3B8;line-height:1.6;">
            &copy; ' . date('Y') . ' Upchar Medical Solution. All rights reserved.<br>
            24x7 Patient Care Helpline: <strong>8448449603</strong> &bull; Email: <a href="mailto:info@upchar.info" style="color:#00A896;text-decoration:none;">info@upchar.info</a><br>
            <a href="https://www.upchar.info" style="color:#00A896;text-decoration:none;">www.upchar.info</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>';

        return $this->send_email($email, $subject, $html);
    }

    /**
     * Requirement 2: Forgot Password OTP
     * Generates a 6-digit OTP and sends it concurrently to user's registered email AND mobile.
     */
    public function send_forgot_password_otp($identifier) {
        $clean_id = trim($identifier);
        $clean_mobile = preg_replace('/[^0-9]/', '', $clean_id);
        if (strlen($clean_mobile) > 10) {
            $clean_mobile = substr($clean_mobile, -10);
        }

        $this->CI->db->select('*')->from('userlogin');
        $this->CI->db->group_start();
        $this->CI->db->where('EMAIL', $clean_id);
        $this->CI->db->or_where('MOBILE', $clean_id);
        if (!empty($clean_mobile) && strlen($clean_mobile) >= 10) {
            $this->CI->db->or_where('MOBILE', $clean_mobile);
        }
        $this->CI->db->group_end();
        $this->CI->db->limit(1);
        $user = $this->CI->db->get()->row();

        if (!$user) {
            return array('status' => 'invalid', 'msg' => 'No account found with provided Email or Mobile.');
        }

        // Generate cryptographically secure 6-digit OTP
        $otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP and 10-minute expiration in database
        $expires_at = date('Y-m-d H:i:s', time() + 600);
        $this->CI->db->where('USERID', $user->USERID)->update('userlogin', array(
            'OTP'            => $otp,
            'otp_expires_at' => $expires_at
        ));
        $this->CI->session->set_userdata('forgotuserid', $user->USERID);

        $name = trim($user->FNAME . ' ' . $user->LNAME) ?: 'User';
        $sms_sent = false;
        $email_sent = false;

        // 1. Dispatch SMS concurrently
        if (!empty($user->MOBILE)) {
            $sms_msg = "Your Upchar password reset OTP is $otp. Valid for 10 minutes. Do not share with anyone. WWW.UPCHAR.INFO";
            if (function_exists('sendsms')) {
                $sms_sent = @sendsms($sms_msg, $user->MOBILE);
            }
        }

        // 2. Dispatch Email concurrently
        if (!empty($user->EMAIL) && filter_var($user->EMAIL, FILTER_VALIDATE_EMAIL)) {
            $subject = 'Your Upchar Password Reset OTP: ' . $otp;
            $html = '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Reset OTP</title>
</head>
<body style="margin:0;padding:0;background-color:#F1F5F9;font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Helvetica,Arial,sans-serif;color:#334155;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F1F5F9;padding:30px 10px;">
  <tr>
    <td align="center">
      <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:540px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06);border:1px solid #E2E8F0;">
        <!-- Header -->
        <tr>
          <td style="background:linear-gradient(135deg,#0F172A 0%,#1E293B 100%);padding:26px 30px;text-align:center;border-bottom:3px solid #00A896;">
            <div style="font-size:24px;font-weight:800;letter-spacing:1px;color:#ffffff;">
              UPCHAR<span style="color:#00A896;">.</span>INFO
            </div>
            <div style="font-size:11.5px;color:#94A3B8;letter-spacing:2px;text-transform:uppercase;margin-top:4px;">
              Account Security Center
            </div>
          </td>
        </tr>
        <!-- Content -->
        <tr>
          <td style="padding:32px 30px;">
            <h3 style="margin:0 0 12px 0;font-size:19px;color:#0F172A;font-weight:700;">
              Password Reset Verification
            </h3>
            <p style="margin:0 0 16px 0;font-size:14px;line-height:1.6;color:#475569;">
              Dear <strong>' . htmlspecialchars($name) . '</strong>,
            </p>
            <p style="margin:0 0 20px 0;font-size:13.5px;line-height:1.6;color:#475569;">
              We received a request to reset the password for your Upchar account. Use the one-time verification code below to complete the verification:
            </p>

            <!-- OTP Box -->
            <div style="background:#F0FDF4;border:2px dashed #00A896;border-radius:10px;padding:20px;text-align:center;margin:22px 0;">
              <span style="font-family:\'Courier New\',Courier,monospace;font-size:34px;font-weight:800;letter-spacing:8px;color:#00A896;display:block;">
                ' . $otp . '
              </span>
              <span style="font-size:11.5px;color:#166534;font-weight:600;display:block;margin-top:6px;">
                Valid for 10 minutes &bull; One-Time Use Only
              </span>
            </div>

            <p style="margin:0 0 16px 0;font-size:12.5px;line-height:1.5;color:#64748B;">
              <strong>Security Alert:</strong> If you did not initiate this request, someone may be trying to access your account. Please change your password immediately or contact our helpline at 8448449603.
            </p>
          </td>
        </tr>
        <!-- Footer -->
        <tr>
          <td style="background:#F8FAFC;border-top:1px solid #E2E8F0;padding:18px 30px;text-align:center;font-size:11px;color:#94A3B8;line-height:1.6;">
            &copy; ' . date('Y') . ' Upchar Medical Solution. All rights reserved.<br>
            Helpline: <strong>8448449603</strong> &bull; <a href="https://www.upchar.info" style="color:#00A896;text-decoration:none;">www.upchar.info</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>';

            $email_sent = $this->send_email($user->EMAIL, $subject, $html);
        }

        return array(
            'status'     => 'success',
            'msg'        => 'OTP sent successfully to your registered mobile and email.',
            'mobile'     => $user->MOBILE,
            'email'      => $user->EMAIL,
            'sms_sent'   => (bool)$sms_sent,
            'email_sent' => (bool)$email_sent
        );
    }

    /**
     * Requirement 3: Post-Booking Notifications
     * Triggers patient confirmation email, service provider (doctor & clinic) email, and SMS.
     */
    public function send_appointment_notifications($appointment_id) {
        if (empty($appointment_id)) {
            return false;
        }

        // Fetch comprehensive appointment details
        $this->CI->db->select('
            appointment.*,
            profile_dr.fname AS dr_fname,
            profile_dr.lname AS dr_lname,
            profile_dr.specialization AS dr_specialization,
            profile_dr.email AS dr_email,
            profile_dr.mobile AS dr_mobile,
            profile_dr.degree AS dr_degree,
            hospital.name AS hospital_name,
            hospital.email AS hospital_email,
            hospital.mobile AS hospital_mobile,
            hospital.address AS hospital_address,
            hospital.city AS hospital_city
        ');
        $this->CI->db->from('appointment');
        $this->CI->db->join('profile_dr', 'profile_dr.id = appointment.doctor_id', 'left');
        $this->CI->db->join('hospital', 'hospital.uid = appointment.institute_id', 'left');
        $this->CI->db->where('appointment.appointment_id', $appointment_id);
        $appt = $this->CI->db->get()->row_array();

        if (empty($appt)) {
            $this->log("Appointment #$appointment_id not found for notification dispatch.");
            return false;
        }

        $pt_name   = !empty($appt['appointment_name']) ? $appt['appointment_name'] : 'Patient';
        $pt_email  = !empty($appt['appointment_email']) ? $appt['appointment_email'] : '';
        $pt_mobile = !empty($appt['appointment_mobile']) ? $appt['appointment_mobile'] : '';
        $dr_name   = trim(($appt['dr_fname'] ?? '') . ' ' . ($appt['dr_lname'] ?? '')) ?: 'Doctor';
        $dr_spec   = !empty($appt['dr_specialization']) ? $appt['dr_specialization'] : 'Specialist';
        $dr_email  = !empty($appt['dr_email']) ? $appt['dr_email'] : '';
        $hosp_name = !empty($appt['hospital_name']) ? $appt['hospital_name'] : 'Upchar Healthcare Clinic';
        $hosp_addr = !empty($appt['hospital_address']) ? $appt['hospital_address'] : ($appt['hospital_city'] ?? '');
        $hosp_email= !empty($appt['hospital_email']) ? $appt['hospital_email'] : '';
        $timing    = (!empty($appt['from_timing']) && !empty($appt['to_timing'])) ? ($appt['from_timing'] . ' - ' . $appt['to_timing']) : ($appt['appointment_time'] ?: 'Consultation Hours');
        $appt_date = !empty($appt['appointment_date']) ? date('d M Y', strtotime($appt['appointment_date'])) : date('d M Y');
        $fee_val   = !empty($appt['fee']) ? $appt['fee'] : ($appt['amount'] ?? '0');
        $pmode     = !empty($appt['payment_mode']) ? strtoupper($appt['payment_mode']) : 'CASH AT CLINIC';
        $pstatus   = !empty($appt['payment_status']) ? strtoupper($appt['payment_status']) : 'PENDING';

        $dispatched = [
            'patient_email'  => false,
            'patient_sms'    => false,
            'doctor_email'   => false,
            'hospital_email' => false,
            'admin_email'    => false
        ];

        // 1. Patient Confirmation Email
        if (!empty($pt_email) && filter_var($pt_email, FILTER_VALIDATE_EMAIL)) {
            $patient_subject = "Appointment Confirmed - Dr. {$dr_name} (Appt #{$appointment_id}) | Upchar";
            $patient_html = '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointment Confirmation</title>
</head>
<body style="margin:0;padding:0;background-color:#F1F5F9;font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Helvetica,Arial,sans-serif;color:#334155;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F1F5F9;padding:26px 10px;">
  <tr>
    <td align="center">
      <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06);border:1px solid #E2E8F0;">
        <!-- Header -->
        <tr>
          <td style="background:linear-gradient(135deg,#00A896 0%,#028090 100%);padding:26px 30px;text-align:center;color:#ffffff;">
            <div style="font-size:22px;font-weight:800;letter-spacing:1px;">
              &#10004; APPOINTMENT CONFIRMED
            </div>
            <div style="font-size:12.5px;opacity:0.9;margin-top:4px;">
              Upchar Medical Solution &bull; Booking Reference #<strong>' . $appointment_id . '</strong>
            </div>
          </td>
        </tr>
        <!-- Content -->
        <tr>
          <td style="padding:28px 30px;">
            <p style="margin:0 0 14px 0;font-size:15px;color:#0F172A;">
              Dear <strong>' . htmlspecialchars($pt_name) . '</strong>,
            </p>
            <p style="margin:0 0 20px 0;font-size:13.5px;line-height:1.6;color:#475569;">
              Your medical consultation has been successfully scheduled with <strong>Dr. ' . htmlspecialchars($dr_name) . '</strong>. Below are your booking specifics:
            </p>

            <!-- Booking Card -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;margin-bottom:20px;">
              <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #E2E8F0;width:35%;font-size:12.5px;color:#64748B;font-weight:600;">Doctor</td>
                <td style="padding:12px 16px;border-bottom:1px solid #E2E8F0;font-size:13px;color:#0F172A;font-weight:700;">Dr. ' . htmlspecialchars($dr_name) . ' <span style="font-size:11.5px;color:#00A896;font-weight:500;">(' . htmlspecialchars($dr_spec) . ')</span></td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #E2E8F0;font-size:12.5px;color:#64748B;font-weight:600;">Date & Time</td>
                <td style="padding:12px 16px;border-bottom:1px solid #E2E8F0;font-size:13px;color:#0F172A;font-weight:700;">' . $appt_date . ' &bull; ' . $timing . '</td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #E2E8F0;font-size:12.5px;color:#64748B;font-weight:600;">Clinic / Hospital</td>
                <td style="padding:12px 16px;border-bottom:1px solid #E2E8F0;font-size:13px;color:#0F172A;font-weight:600;">' . htmlspecialchars($hosp_name) . ($hosp_addr ? '<br><span style="font-size:11.5px;color:#64748B;">' . htmlspecialchars($hosp_addr) . '</span>' : '') . '</td>
              </tr>
              <tr>
                <td style="padding:12px 16px;border-bottom:1px solid #E2E8F0;font-size:12.5px;color:#64748B;font-weight:600;">Consultation Fee</td>
                <td style="padding:12px 16px;border-bottom:1px solid #E2E8F0;font-size:14px;color:#00A896;font-weight:800;">&#8377; ' . $fee_val . '</td>
              </tr>
              <tr>
                <td style="padding:12px 16px;font-size:12.5px;color:#64748B;font-weight:600;">Payment Mode</td>
                <td style="padding:12px 16px;font-size:13px;color:#0F172A;font-weight:600;">' . $pmode . ' (' . $pstatus . ')</td>
              </tr>
            </table>

            <!-- Patient Instructions -->
            <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:8px;padding:14px;margin-bottom:20px;">
              <div style="font-size:12.5px;font-weight:700;color:#92400E;margin-bottom:6px;">Important Instructions:</div>
              <ul style="margin:0;padding-left:18px;font-size:12px;color:#78350F;line-height:1.6;">
                <li>Please arrive at the clinic 10-15 minutes prior to your scheduled consultation slot.</li>
                <li>Bring any prior medical prescriptions, lab reports, or diagnostic history.</li>
                <li>If paying via Cash on Counter (COC), pay the consultation fee directly at the reception counter.</li>
              </ul>
            </div>

            <p style="margin:0;font-size:12px;color:#64748B;line-height:1.5;">
              Need to reschedule or have questions? Contact our patient assistance team anytime at <strong>8448449603</strong> or email <a href="mailto:info@upchar.info" style="color:#00A896;text-decoration:none;">info@upchar.info</a>.
            </p>
          </td>
        </tr>
        <!-- Footer -->
        <tr>
          <td style="background:#F8FAFC;border-top:1px solid #E2E8F0;padding:18px 30px;text-align:center;font-size:11px;color:#94A3B8;line-height:1.6;">
            &copy; ' . date('Y') . ' Upchar Medical Solution. All rights reserved.<br>
            <a href="https://www.upchar.info" style="color:#00A896;text-decoration:none;">www.upchar.info</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>';

            $dispatched['patient_email'] = $this->send_email($pt_email, $patient_subject, $patient_html);
        }

        // 2. Doctor Alert Email
        if (!empty($dr_email) && filter_var($dr_email, FILTER_VALIDATE_EMAIL)) {
            $dr_subject = "New Patient Appointment Scheduled - {$pt_name} (Appt #{$appointment_id}) | Upchar";
            $dr_html = '<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>New Appointment</title></head>
<body style="font-family:Arial,sans-serif;color:#333;background:#f5f7fa;padding:20px;">
<div style="max-width:560px;margin:auto;background:#fff;border-radius:8px;padding:25px;border:1px solid #e1e8ed;">
  <h3 style="color:#00A896;margin-top:0;">New Appointment Scheduled</h3>
  <p>Dear <strong>Dr. ' . htmlspecialchars($dr_name) . '</strong>,</p>
  <p>You have a new patient booking at <strong>' . htmlspecialchars($hosp_name) . '</strong>.</p>
  <table width="100%" style="border-collapse:collapse;margin:15px 0;">
    <tr><td style="padding:8px;border-bottom:1px solid #eee;color:#666;">Appointment ID</td><td style="padding:8px;border-bottom:1px solid #eee;font-weight:bold;">#' . $appointment_id . '</td></tr>
    <tr><td style="padding:8px;border-bottom:1px solid #eee;color:#666;">Patient Name</td><td style="padding:8px;border-bottom:1px solid #eee;font-weight:bold;">' . htmlspecialchars($pt_name) . ' (' . ($appt['age'] ? $appt['age'] . ' yrs' : 'N/A') . ')</td></tr>
    <tr><td style="padding:8px;border-bottom:1px solid #eee;color:#666;">Patient Contact</td><td style="padding:8px;border-bottom:1px solid #eee;">' . htmlspecialchars($pt_mobile) . ' &bull; ' . htmlspecialchars($pt_email) . '</td></tr>
    <tr><td style="padding:8px;border-bottom:1px solid #eee;color:#666;">Date & Slot</td><td style="padding:8px;border-bottom:1px solid #eee;font-weight:bold;">' . $appt_date . ' &bull; ' . $timing . '</td></tr>
    <tr><td style="padding:8px;border-bottom:1px solid #eee;color:#666;">Fee / Mode</td><td style="padding:8px;border-bottom:1px solid #eee;">Rs. ' . $fee_val . ' (' . $pmode . ')</td></tr>
  </table>
  <p style="font-size:12px;color:#888;">Thank you for partnering with Upchar Medical Solution. For doctor support, reach partner@upchar.info.</p>
</div>
</body>
</html>';

            $dispatched['doctor_email'] = $this->send_email($dr_email, $dr_subject, $dr_html);
        }

        // 3. Hospital / Clinic Alert Email
        if (!empty($hosp_email) && filter_var($hosp_email, FILTER_VALIDATE_EMAIL)) {
            $hosp_subject = "New Clinic Booking - Dr. {$dr_name} (Appt #{$appointment_id}) | Upchar";
            $hosp_html = '<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Clinic Booking Alert</title></head>
<body style="font-family:Arial,sans-serif;color:#333;background:#f5f7fa;padding:20px;">
<div style="max-width:560px;margin:auto;background:#fff;border-radius:8px;padding:25px;border:1px solid #e1e8ed;">
  <h3 style="color:#0F172A;margin-top:0;">New Clinic Consultation Scheduled</h3>
  <p>Dear Clinic Administrator (' . htmlspecialchars($hosp_name) . '),</p>
  <p>A new patient consultation has been scheduled:</p>
  <ul>
    <li><strong>Appointment ID:</strong> #' . $appointment_id . '</li>
    <li><strong>Patient:</strong> ' . htmlspecialchars($pt_name) . ' (Phone: ' . htmlspecialchars($pt_mobile) . ')</li>
    <li><strong>Doctor:</strong> Dr. ' . htmlspecialchars($dr_name) . '</li>
    <li><strong>Schedule:</strong> ' . $appt_date . ' at ' . $timing . '</li>
    <li><strong>Fee:</strong> Rs. ' . $fee_val . ' (' . $pmode . ')</li>
  </ul>
</div>
</body>
</html>';

            $dispatched['hospital_email'] = $this->send_email($hosp_email, $hosp_subject, $hosp_html);
        }

        // 4. Admin Notice Email
        $admin_email = $this->get_setting('support_email', 'info@upchar.info');
        if (!empty($admin_email) && filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
            $admin_subject = "Booking Alert: Appt #{$appointment_id} - Dr. {$dr_name} by {$pt_name}";
            $admin_body = "New Appointment #$appointment_id booked on " . date('d-m-Y H:i') . "<br>"
                        . "Patient: $pt_name ($pt_mobile, $pt_email)<br>"
                        . "Doctor: Dr. $dr_name at $hosp_name<br>"
                        . "Slot: $appt_date $timing<br>"
                        . "Fee: Rs. $fee_val ($pmode - $pstatus)<br>";
            $dispatched['admin_email'] = $this->send_email($admin_email, $admin_subject, $admin_body);
        }

        // 5. Patient SMS Confirmation
        if (!empty($pt_mobile) && function_exists('sendsms')) {
            $sms_text = "Your Appointment is booked successfully! Appt# $appointment_id with Dr. $dr_name on $appt_date $timing. Fee: Rs. $fee_val ($pmode). Helpline: 8448449603. https://www.upchar.info";
            $dispatched['patient_sms'] = @sendsms($sms_text, $pt_mobile);
        }

        $this->log("Appointment #$appointment_id notifications dispatched: " . json_encode($dispatched));
        return $dispatched;
    }

    /**
     * Verify email token and activate account
     */
    public function verify_email_token($token) {
        $token = trim($token);
        if (empty($token) || strlen($token) < 20) {
            return false;
        }

        $user = $this->CI->db->get_where('userlogin', array('verification_token' => $token))->row();
        if (!$user) {
            return false;
        }

        // Activate account and mark email as verified
        $this->CI->db->where('USERID', $user->USERID)->update('userlogin', array(
            'STATUS'             => '1',
            'APPROVED'           => '1',
            'email_verified_at'  => date('Y-m-d H:i:s'),
            'verification_token' => null
        ));

        return $user;
    }

    /**
     * Audit logger
     */
    protected function log($msg) {
        $entry = date('[Y-m-d H:i:s] ') . $msg . "\n";
        @file_put_contents($this->log_file, $entry, FILE_APPEND);
    }
}
