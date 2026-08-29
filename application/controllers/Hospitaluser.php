<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*  error_reporting(E_ALL);
ini_set('display_errors', 1);  */
class Hospitaluser extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->load->model('Hospitaluser_Model');
		//$this->load->library('Sm_lib');
	}
	
	public function index()
	{
		$this->load->view('login',@$data);
	}
	
	public function login()
	{
		$email = strtolower($this->input->post('email'));
		$password = md5($this->input->post('password'));
		//echo "<pre>"; print_r($password); die;
        $login = $this->Hospitaluser_Model->login($email,$password);
		if($login=='SUCCESS'){
			$response=array('status'=>'success','msg'=>'Logged in Successfully');
		}else if($login=='UNVERIFIED'){
			$response=array('status'=>'failed','msg'=>'Your hospital account is pending verification and approval by the Administrator. You cannot login until verified.');
		}else if($login=='OTP'){
			$response=array('status'=>'otp','msg'=>'Please Verify Mobile no');
		}else if($login=='BLOCKED'){
			$response=array('status'=>'failed','msg'=>'User Blocked by Administrator!');
		}else {
			$response=array('status'=>'failed','msg'=>'Incorrect Email or Password');
		}
		echo json_encode($response);
	}
	
	public function verifysignupotp()
	{
		$userid = $this->session->userdata('hossignupuserid');
		$otp = ($this->input->post('otp'));
        $login = $this->Hospitaluser_Model->verifysignupotp($userid,$otp);
		if($login=='SUCCESS'){
			$response=array('status'=>'success','msg'=>'Logged in Successfully');
		}else {
			$response=array('status'=>'failed','msg'=>'Incorrect OTP');
		}
		echo json_encode($response);
	}
	
	
	public function verifyforgototp()
	{
		$userid = $this->session->userdata('hosforgotuserid');
		$otp = trim($this->input->post('otp'));
        $login = $this->Hospitaluser_Model->verifyforgototp($userid, $otp);
		if($login == 'SUCCESS'){
			$response = array('status' => 'success', 'msg' => 'OTP Verified Successfully');
		} else {
			$response = array('status' => 'failed', 'msg' => 'Incorrect OTP code. Please check and try again.');
		}
		echo json_encode($response);
	}
	
	public function resendsignupotp()
	{
		$userid = $this->session->userdata('hossignupuserid');
		$this->db->select('MOBILE');
        $this->db->from('hospitallogin');
        $this->db->where('USERID', $userid);       
        $this->db->limit(1);
        $mobile = $this->db->get()->row('MOBILE');
        $login = $this->Hospitaluser_Model->resendotp($mobile);
		if($login == 'SUCCESS'){
			$response = array('status' => 'success', 'msg' => 'OTP Sent Successfully');
		} else {
			$response = array('status' => 'failed', 'msg' => 'Failed to send OTP');
		}
		echo json_encode($response);
	}
	
	public function resendforgetotp()
	{
		$userid = $this->session->userdata('hosforgotuserid');
		$mobile = '';
		if ($userid) {
			$this->db->select('MOBILE');
			$this->db->from('hospitallogin');
			$this->db->where('USERID', $userid);       
			$this->db->limit(1);
			$mobile = $this->db->get()->row('MOBILE');
		}
        $login = $this->Hospitaluser_Model->resendotp($mobile);
		if($login == 'SUCCESS'){
			$response = array('status' => 'success', 'msg' => 'A fresh OTP has been sent to your mobile.');
		} else {
			$response = array('status' => 'failed', 'msg' => 'Failed to resend OTP. Please re-enter your mobile/email.');
		}
		echo json_encode($response);
	}
	
	public function setnewpass()
	{
		$userid = $this->session->userdata('hosforgotuserid');
        $login = $this->Hospitaluser_Model->changepass($userid);
		if($login == 'SUCCESS'){
			$response = array('status' => 'success', 'msg' => 'Password updated successfully! Redirecting to login...');
		} else if ($login == 'INVALID') {
			$response = array('status' => 'failed', 'msg' => 'Recovery session expired. Please start over.');
		} else {
			$response = array('status' => 'failed', 'msg' => 'Password must be at least 6 characters long.');
		}
		echo json_encode($response);
	}
	
	public function register()
    {
		$response = $this->Hospitaluser_Model->register();
		echo json_encode($response);
	}
	
	public function forgotpass(){
		$mobile = trim($this->input->post('mobile'));
		$login = $this->Hospitaluser_Model->forgotpass($mobile);
		if($login == 'SUCCESS'){
			$response = array('status' => 'success', 'msg' => 'OTP sent to your registered mobile and email.');
		} else if($login == 'INVALID'){
			$response = array('status' => 'failed', 'msg' => 'No hospital found with this registered mobile number or email.');
		} else {
			$response = array('status' => 'failed', 'msg' => 'Account is inactive or blocked. Please contact support.');
		}
		echo json_encode($response);
	}
	
	public function otppass(){
		$mobile = trim($this->input->post('mobile'));
		$login = $this->Hospitaluser_Model->otppass($mobile);
		if($login == 'SUCCESS'){
			$response = array('status' => 'success', 'msg' => 'OTP Sent To Registered Mobile and Email');
		} else if($login == 'INVALID'){
			$response = array('status' => 'invalid', 'msg' => 'Invalid Mobile or Email');
		} else {
			$response = array('status' => 'failed', 'msg' => 'Something went wrong');
		}
		echo json_encode($response);
	}
	
	public function logout()
    {
        $this->session->sess_destroy();
        redirect('/hospital-login');
    }
}