<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      Azad Hussain
 * @copyright   Copyright (c) 2016, Azad Hussain.
 * @license     
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------


class Azad_lib {
    var $CI;
    public function __construct($params = array())
    {
        $this->CI =& get_instance();

        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');
        $this->CI->load->database();
        
    }

public function sendMail($to,$subject,$body,$variables=array(),$attachment='')
{ 
		$this->CI->load->helper('settings');

		// Handle template substitution if body is a template identifier
		if(strlen($body) < 40 && !strpos($body, ' ')) {
			$templatefile = 'templates/' . $body . '.html';
			if (file_exists($templatefile)) {
				$templatedata = file_get_contents($templatefile);
				foreach($variables as $key => $value) {
					$templatedata = str_replace('!@#'.$key.'#@!', $value, $templatedata);
				}
				$body = $templatedata;
			}
		}

		// Use Notification_service if loaded or load it
		try {
			if (!isset($this->CI->notification_service)) {
				$this->CI->load->library('notification_service');
			}
			return $this->CI->notification_service->send_email($to, $subject, $body);
		} catch (\Throwable $e) {
			log_message('error', 'Azad_lib sendMail fallback error: ' . $e->getMessage());
		}

		$raw_host  = function_exists('get_system_setting') ? get_system_setting('smtp_host', 'mail.upchar.info') : 'mail.upchar.info';
		$port      = function_exists('get_system_setting') ? (int)get_system_setting('smtp_port', '587') : 587;
		$user      = function_exists('get_system_setting') ? get_system_setting('smtp_user', get_system_setting('smtp_username', 'support@upchar.info')) : 'support@upchar.info';
		$pass      = function_exists('get_system_setting') ? get_system_setting('smtp_pass', get_system_setting('smtp_password', 'Abc@28010')) : 'Abc@28010';
		$fromemail = function_exists('get_system_setting') ? get_system_setting('mail_from_email', get_system_setting('email_from_address', 'support@upchar.info')) : 'support@upchar.info';
		$fromname  = function_exists('get_system_setting') ? get_system_setting('mail_from_name', get_system_setting('email_from_name', 'Upchar Medical Solution')) : 'Upchar Medical Solution';

		// Decrypt password if encrypted
		if (strpos($pass, 'ENC:') === 0) {
			$encryption_key = config_item('encryption_key') ?: 'MyIndiaAtTheTop';
			$key_secret = hash('sha256', $encryption_key, true);
			$raw = base64_decode(substr($pass, 4));
			$iv = substr($raw, 0, 16);
			$hmac = substr($raw, 16, 32);
			$cipher_raw = substr($raw, 48);
			if (hash_equals($hmac, hash_hmac('sha256', $cipher_raw, $key_secret, true))) {
				$pass = openssl_decrypt($cipher_raw, 'AES-256-CBC', $key_secret, OPENSSL_RAW_DATA, $iv);
			}
		}

		// DNS fallback
		$host = $raw_host;
		$ip = @gethostbyname($raw_host);
		if ($ip === $raw_host && !filter_var($raw_host, FILTER_VALIDATE_IP)) {
			$host = '87.232.72.4';
		}

		$crypto = ($port == 465) ? 'ssl' : (($port == 587) ? 'tls' : '');

		$config = array(
			'protocol'    => 'smtp',
			'smtp_host'   => $host,
			'smtp_port'   => $port,
			'smtp_user'   => $user,
			'smtp_pass'   => $pass,
			'smtp_crypto' => $crypto,
			'charset'     => 'utf-8',
			'crlf'        => "\r\n",
			'newline'     => "\r\n",
			'mailtype'    => 'html',
			'wordwrap'    => TRUE
		);

		$this->CI->load->library('email');
		$this->CI->email->initialize($config);
		$this->CI->email->from($fromemail, $fromname);
		$this->CI->email->to($to);
		$this->CI->email->subject($subject);
		$this->CI->email->message($body);
		return @$this->CI->email->send();
}	
	


	

public function sendSms($usermobile,$variables,$templateid)
{
	$templatefile='templates/'.$templateid.'.html';
	if (file_exists($templatefile)) 
	{
		$templatedata = file_get_contents($templatefile);
		
		foreach($variables as $key => $value)
		{
			$templatedata = str_replace('<<'.$key.'>>', $value, $templatedata);
		}
		$smstext=$templatedata;
		//$url='http://bulkpush.mytoday.com/BulkSms/SingleMsgApi?feedid='. BIZBOND_FEEDID .'&username='. BIZBOND_UN .'&password='. urlencode( BIZBOND_PASS ).'&To='. $usermobile .'&Text='. urlencode( $smstext ) .'&time=&senderid='. BIZBOND_SENDERID .'';
		$url='http://bulksms.smsroot.com/app/smsapi/index.php?key=45C6DA05EDD0DC&campaign=0&routeid=13&type=text&contacts='. $usermobile .'&senderid=UPCARE&msg='. urlencode( $smstext ) .'&template_id=1507161519686689997';
		//echo "<pre>"; print_r($url); die;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$output = curl_exec($curl);
			
		$myFile='netcore.log';
		$logmsg="\n".'['.date('d-m-Y H:i:s').'] '.$url."\n";
		$fh = fopen($myFile, 'a');
		
		if(curl_errno($curl)) 
		{
		fwrite($fh, $logmsg.'REQUEST SUBMITED '.$output."\n");
		fclose($fh);
		return 'REQUEST FAILED '. curl_error($curl);
		}
		else
		{
			curl_close($curl);
			fwrite($fh, $logmsg.'REQUEST SUBMITED '.$output."\n");
			fclose($fh);
			return 'REQUEST SUBMITED '.$output;
		}
	}
	else{
		fwrite($fh, $logmsg.' INVALID TEMPLATE ID '."\n");
		fclose($fh);
		return 'INVALID TEMPLATE ID';
	}
}

	

public function sendEmail($to,$subject, $variables,$templateid,$cc=true)
{
	$templatefile='templates/'.$templateid.'.html';
	if (file_exists($templatefile)) {
	 	$templatedata = file_get_contents($templatefile);
		
		foreach($variables as $key => $value)
		{
			$templatedata = str_replace('!@#'.$key.'#@!', $value, $templatedata);
		}
		$emailtext=$templatedata;
		
		/*********************/
		
		$data=array();
		$data['subject']= ($subject);                                                                       
		$data['fromname']= ( FALCONIDE_FROM_NAME );                                                             
		$data['api_key'] = FALCONIDE_API_KEY ;
		$data['from'] = FALCONIDE_FROM_EMAIL ;
		$data['content']= ($emailtext);
		$data['recipients']= $to;
		if(ENVIRONMENT == 'production'  && $cc !=false)
		{
			$data['recipients_cc']=  DEV_EMAIL .','. SUPERADMIN_EMAIL ;
		}
		$apiresult = $this->callApi(@$api_type,@$action,$data);
		

		/*********************/
		/* echo $url='https://api.falconide.com/falconapi/web.send.json?data={"api_key":"'. FALCONIDE_API_KEY .'", "email_details":{ "fromname":"'. urlencode( FALCONIDE_FROM_NAME ) .'", "subject":"'. urlencode($subject) .'", "from":"'. urlencode( FALCONIDE_FROM_EMAIL ) .'", "replytoid": "'.urlencode( FALCONIDE_FROM_EMAIL ).'", "tags": "Account Deactivation, Verification", "content":"'. urlencode($emailtext) .'" },"recipients":["'. urlencode($useremail) .'"], "X-APIHEADER": ["ACC123","SE2532"]';
		if(ENVIRONMENT == 'production' )
		$url.=', "recipients_cc": ["'.DEV_EMAIL.'" ,"'.SUPERADMIN_EMAIL.'" ] ';
		$url.='}'; */
		
		/* $curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$output = curl_exec($curl); */
		
		//$url=print_r($data);
			
		$myFile='netcore.log';
		$logmsg="\n\n".'['.date('d-m-Y H:i:s').'] '.$url."\n\n".$apiresult."\n\n";
		$fh = fopen($myFile, 'a');
		
		return $apiresult;
		
		/*if(curl_errno($curl)) 
		{
		fwrite($fh, $logmsg.'REQUEST SUBMITED '.$output."\n\n");
		fclose($fh);
		return 'REQUEST FAILED '. curl_error($curl);
		}
		 else
		{
			curl_close($curl);
			fwrite($fh, $logmsg.'REQUEST SUBMITED '.$output."\n");
			fclose($fh);
			return 'REQUEST SUBMITED '.$output;
		}  */
	}
	else{
		$myFile='netcore.log';
		$logmsg="\n\n".'['.date('d-m-Y H:i:s').'] '.$url."\n\n";
		$fh = fopen($myFile, 'a');
		fwrite($fh, $logmsg.' INVALID TEMPLATE ID '."\n");
		fclose($fh);
		return 'INVALID TEMPLATE ID';
	}
}

function callApi($api_type='', $api_activity='', $api_input='') {
        $data = array();
        $result = $this->http_post_form("https://api.falconide.com/falconapi/web.send.rest", $api_input);
        return $result;
}

function http_post_form($url,$data,$timeout=20) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url); 
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_RANGE,"1-2000000");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
        curl_setopt($ch, CURLOPT_REFERER, @$_SERVER['REQUEST_URI']);
        $result = curl_exec($ch); 
        $result = curl_error($ch) ? curl_error($ch) : $result;
        curl_close($ch);
        return $result;
}



 
}