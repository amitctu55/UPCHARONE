<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter FDDI Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Azad Hussain
 */

// ------------------------------------------------------------------------

if ( ! function_exists('getUserId'))
{
	function getUserId(){
		return get_instance()->session->userdata('userid');
	}
}
if ( ! function_exists('getInstitutionId'))
{
	function getInstitutionId(){
		return get_instance()->session->userdata('institution_id');
	}
}

if ( ! function_exists('getUserName'))
{
	function getUserName(){
		return get_instance()->session->userdata('username');
	}
}

if ( ! function_exists('getUserType'))
{
	function getUserType(){
		return get_instance()->session->userdata('code');
	}
}

if ( ! function_exists('getUserIP'))
{
	function getUserIP(){
		return get_instance()->input->ip_address();
	}
}

if ( ! function_exists('getUserAgent'))
{
	function getUserAgent(){
		return get_instance()->input->user_agent();
	}
}

if ( ! function_exists('formateDate'))
{
	
	function formateDate($date){
		return ($date) ? date("d-M-Y", strtotime($date)) : '';
	}
}
if ( ! function_exists('formateTime'))
{
	
	function formateTime($date){
		return ($date) ? date("g:i a", strtotime($date)) : '';
	}
}
if ( ! function_exists('formateDateTime'))
{
	
	function formateDateTime($date){
		return ($date) ? date("d-M-Y g:i a", strtotime($date)) : '';
	}
}
if ( ! function_exists('getFY'))
{
	function getFY($date){
		$d = explode('-',$date);
		$y = $d[0];
		$m = $d[1];
		
		if($m >=4)
			return ($date) ? $y.'-'.($y+1) : '';
		else
			return ($date) ? ($y-1).'-'.$y : ''; 
	}
}


if ( ! function_exists('last_query'))
{
	function last_query(){
		echo get_instance()->db->last_query();
	}
}

/****************************************************/
if ( ! function_exists('getCityName'))
{
	function getCityName($id){
		$res = get_instance()->db->select('name')->get_where('master_city',array('id'=>$id))->row('name');
		return $res;
	}
}
if ( ! function_exists('getlocalityName'))
{ 
	function getlocalityName($id){
		$res = get_instance()->db->select('name')->get_where('master_locality',array('id'=>$id))->row('name');
		return $res;
	}
}

if ( ! function_exists('getQualificationName'))
{
	function getQualificationName($id){
		$res = get_instance()->db->select('name')->get_where('master_degree',array('id'=>$id))->row('name');
		return $res;
	}
}

if ( ! function_exists('getSpecilizationName'))
{
	function getSpecilizationName($id){
		if($id=='')
			return '';
		$res = get_instance()->db->select('name')->get_where('master_specialization',array('id'=>$id))->row('name');
		return $res;
	}
}

if ( ! function_exists('getServicesName'))
{
	function getServicesName($id){
		$res = get_instance()->db->select('name')->get_where('master_services',array('id'=>$id))->row('name');
		return $res;
	}
}

if ( ! function_exists('getDoctorName'))
{
	function getDoctorName($id){
		$res = get_instance()->db->select('fname')->get_where('profile_dr',array('id'=>$id))->row('fname');
		return prefixdr($res);
	}
}

if ( ! function_exists('getInstituteName'))
{
	function getInstituteName($id,$type='H'){
		if($type=='C')
			$table='clinic';
		else
			$table='hospital';
		$res = get_instance()->db->select('name')->get_where($table,array('id'=>$id))->row('name');
		return $res;
	}
}

if ( ! function_exists('admin_url'))
{
	function admin_url(){
		return base_url().'admin1947/';
	}
}

if ( ! function_exists('mybase64_decode'))
{
	function mybase64_decode($id){
		
		$decoded_id = base64_decode(strtr($id,array('.' => '+', '-' => '=', '~' => '/')));
		return $decoded_id;
	}
}

if ( ! function_exists('mybase64_encode'))
{
	function mybase64_encode($id){
		
		$encoded_id  = strtr(base64_encode($id), array('+' => '.', '=' => '-', '/' => '~'));
		return $encoded_id;
	}
}

if ( ! function_exists('prefixdr'))
{
	function prefixdr($name){
		
		$prefix  = (strcasecmp(substr($name,0,2),'Dr'))? 'Dr. ' : '';
		return $prefix.$name;
	}
}


if(!function_exists('sendsms'))
{
	function sendsms($msg,$contacts)
	{	
		$api_key = '45C6DA05EDD0DC';
		//$from = 'UPCHAR';
		$from = 'Upcare';
		$sms_text = urlencode($msg);
		//$api_url = "http://bulksms.smsroot.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;
		$api_url='http://bulksms.smsroot.com/app/smsapi/index.php?key=45C6DA05EDD0DC&campaign=0&routeid=13&type=text&contacts='. $contacts .'&senderid=UPCARE&msg='. urlencode( $msg ) .'&template_id=1507161519686689997';
		//echo "<pre>"; print_r($api_url); die;
		//$response = file_get_contents( $api_url);
		// Step 1
		$cSession = curl_init(); 
		curl_setopt($cSession, CURLOPT_URL, $api_url);
		curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cSession, CURLOPT_HEADER, false); 
		curl_setopt($cSession, CURLOPT_CONNECTTIMEOUT, 3);
		curl_setopt($cSession, CURLOPT_TIMEOUT, 4);
		curl_setopt($cSession, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($cSession);
		curl_close($cSession);
		return $result;
				//return  $response;
	}	
}

if (!function_exists('send_otp_email'))
{
	/**
	 * Send responsive HTML OTP email using system_settings (SMTP / SendGrid / Native Mail)
	 */
	function send_otp_email($to_email, $otp, $patient_name = 'Valued Patient')
	{
		$to_email = trim($to_email);
		if (empty($to_email) || !filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
			return false;
		}

		$display_name = !empty($patient_name) ? htmlspecialchars(trim($patient_name)) : 'Valued Patient';
		$subject = "Your Upchar Verification Code: $otp";

		$message = '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upchar Verification Code</title>
</head>
<body style="margin:0;padding:0;background-color:#F8FAFC;font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Helvetica,Arial,sans-serif;">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F8FAFC;padding:30px 10px;">
  <tr>
    <td align="center">
      <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:520px;background-color:#FFFFFF;border-radius:12px;overflow:hidden;box-shadow:0 4px 18px rgba(0,0,0,0.06);border:1px solid #E2E8F0;">
        <tr>
          <td style="background:linear-gradient(135deg, #00A896 0%, #05668D 100%);padding:24px 20px;text-align:center;">
            <h1 style="color:#FFFFFF;margin:0;font-size:24px;font-weight:800;letter-spacing:1px;">UPCHAR</h1>
            <p style="color:#E6FFFA;margin:4px 0 0 0;font-size:12px;font-weight:500;">Healthcare & Doctor Appointment System</p>
          </td>
        </tr>
        <tr>
          <td style="padding:28px 24px;">
            <h2 style="margin:0 0 10px 0;color:#0F172A;font-size:17px;font-weight:700;">Appointment Verification Code</h2>
            <p style="margin:0 0 18px 0;color:#475569;font-size:13.5px;line-height:1.5;">
              Dear <strong>' . $display_name . '</strong>,<br>
              Your one-time verification code (OTP) for doctor appointment booking on Upchar is:
            </p>
            <div style="background:#F0FDF4;border:2px dashed #00A896;border-radius:10px;padding:18px;text-align:center;margin-bottom:20px;">
              <span style="font-family:\'Courier New\',Courier,monospace;font-size:32px;font-weight:800;letter-spacing:8px;color:#00A896;display:block;">
                ' . $otp . '
              </span>
              <span style="font-size:11.5px;color:#166534;font-weight:600;display:block;margin-top:6px;">
                Valid for 10 minutes &bull; Do not share with anyone
              </span>
            </div>
            <p style="margin:0 0 14px 0;color:#64748B;font-size:12px;line-height:1.5;">
              Enter this 6-digit code in the booking window to verify your contact information and confirm your appointment schedule.
            </p>
            <div style="border-top:1px solid #E2E8F0;padding-top:14px;margin-top:20px;color:#94A3B8;font-size:11px;text-align:center;">
              &copy; ' . date('Y') . ' Upchar Medical Solution. All rights reserved.<br>
              Website: <a href="https://www.upchar.info" style="color:#00A896;text-decoration:none;">www.upchar.info</a>
            </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>';

		$sent = false;
		$CI =& get_instance();

		// Helper to fetch and decrypt system settings
		$get_setting = function($key, $default = '') use ($CI) {
			if (!$CI) return $default;
			if (function_exists('get_system_setting')) {
				return get_system_setting($key, $default);
			}
			if (isset($CI->settings_lib)) {
				return $CI->settings_lib->get($key, $default);
			}
			$row = $CI->db->get_where('system_settings', array('setting_key' => $key))->row();
			if ($row) {
				$val = $row->setting_value;
				if ($row->is_encrypted && strpos($val, 'ENC:') === 0) {
					$key_secret = hash('sha256', 'MyIndiaAtTheTop', true);
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
		};

		$provider   = $get_setting('email_provider', 'smtp');
		$from_email = $get_setting('mail_from_email', 'support@upchar.info');
		$from_name  = $get_setting('mail_from_name', 'Upchar Healthcare');

		// 1. If SendGrid is configured
		if ($provider === 'sendgrid') {
			$sendgrid_key = $get_setting('sendgrid_api_key');
			if (!empty($sendgrid_key)) {
				$payload = [
					'personalizations' => [['to' => [['email' => $to_email]]]],
					'from' => ['email' => $from_email, 'name' => $from_name],
					'subject' => $subject,
					'content' => [['type' => 'text/html', 'value' => $message]]
				];
				$ch = curl_init('https://api.sendgrid.com/v3/mail/send');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
				curl_setopt($ch, CURLOPT_TIMEOUT, 6);
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					'Authorization: Bearer ' . $sendgrid_key,
					'Content-Type: application/json'
				]);
				$res = curl_exec($ch);
				$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if ($code >= 200 && $code < 300) {
					$sent = true;
				}
			}
		}

		// 2. SMTP Delivery via CodeIgniter Email Class
		if (!$sent && $CI) {
			$smtp_host   = $get_setting('smtp_host', 'mail.upchar.info');
			$smtp_port   = (int)$get_setting('smtp_port', 587);
			$smtp_crypto = $get_setting('smtp_crypto', 'tls');
			$smtp_user   = $get_setting('smtp_user', 'support@upchar.info');
			$smtp_pass   = $get_setting('smtp_pass', 'Abc@28010');

			// Standard ports require encryption
			if ($smtp_port == 587) {
				$smtp_crypto = 'tls';
			} else if ($smtp_port == 465) {
				$smtp_crypto = 'ssl';
			} else if ($smtp_crypto === 'none') {
				$smtp_crypto = '';
			}

			try {
				$CI->load->library('email');
				$CI->email->clear(true);
				$email_config = array(
					'protocol'    => 'smtp',
					'smtp_host'   => $smtp_host,
					'smtp_port'   => $smtp_port,
					'smtp_user'   => $smtp_user,
					'smtp_pass'   => $smtp_pass,
					'smtp_crypto' => $smtp_crypto,
					'smtp_timeout'=> 6,
					'mailtype'    => 'html',
					'charset'     => 'utf-8',
					'priority'    => 1,
					'newline'     => "\r\n",
					'crlf'        => "\r\n",
					'wordwrap'    => TRUE
				);

				$CI->email->initialize($email_config);
				$CI->email->from($from_email, $from_name);
				$CI->email->to($to_email);
				$CI->email->subject($subject);
				$CI->email->message($message);

				$sent = @$CI->email->send();
			} catch (Exception $e) {
				log_message('error', 'OTP Email SMTP Exception: ' . $e->getMessage());
			}
		}

		// 3. Fallback to PHP native mail()
		if (!$sent && function_exists('mail')) {
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "From: $from_name <$from_email>\r\n";
			$headers .= "Reply-To: $from_email\r\n";
			$headers .= "X-Mailer: PHP/" . phpversion();
			$sent = @mail($to_email, $subject, $message, $headers);
		}

		// 4. Always record in development log for localhost debugging
		$log_dir = APPPATH . 'logs';
		if (is_dir($log_dir)) {
			$entry = date('[Y-m-d H:i:s]') . " OTP: $otp | TO: $to_email | SENT: " . ($sent ? 'YES' : 'NO') . "\n";
			@file_put_contents($log_dir . '/otp_audit.log', $entry, FILE_APPEND);
		}

		return $sent;
	}
}

if (!function_exists('send_verification_otp'))
{
	/**
	 * Send OTP via Phone (SMS) and Email simultaneously
	 */
	function send_verification_otp($mobile, $otp, $email = '', $name = '')
	{
		$is_local = (isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false)) || (php_sapi_name() === 'cli');
		if ($is_local) {
			// On local dev / demo environment, return immediately without blocking on external SMTP/SMS gateways
			return array(
				'mobile'     => $mobile,
				'email'      => $email,
				'sms_sent'   => true,
				'email_sent' => true
			);
		}

		$msg = "Your Upchar verification code is $otp. Do not share this code with anyone. WWW.UPCHAR.INFO";
		$sms_sent = @sendsms($msg, $mobile);

		$email_sent = false;
		if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_sent = send_otp_email($email, $otp, $name);
		}

		return array(
			'mobile'     => $mobile,
			'email'      => $email,
			'sms_sent'   => $sms_sent,
			'email_sent' => $email_sent
		);
	}
}


