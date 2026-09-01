<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*  error_reporting(E_ALL);
ini_set('display_errors', 1);  */
class User extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->load->model('User_Model');
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
        $login = $this->User_Model->login($email,$password);
		if($login=='SUCCESS'){
			$last_page = $this->session->userdata('last_page');
			$this->session->unset_userdata('last_page');
			$redirect_url = $last_page ?: base_url('myappointments');
			$response=array('status'=>'success','msg'=>'Logged in Successfully', 'redirect_url' => $redirect_url);
		}else if($login=='UNVERIFIED'){
			$response=array('status'=>'failed','msg'=>'Your account is pending verification and approval by the Administrator. You cannot login until approved.');
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
		$userid = $this->session->userdata('signupuserid');
		$otp = ($this->input->post('otp'));
        $login = $this->User_Model->verifysignupotp($userid,$otp);
		if($login=='SUCCESS'){
			$response=array('status'=>'success','msg'=>'Logged in Successfully');
		}else {
			$response=array('status'=>'failed','msg'=>'Incorrect OTP');
		}
		echo json_encode($response);
	}
	
	
	public function verifyforgototp()
	{
		$userid = $this->session->userdata('forgotuserid');
		$otp = ($this->input->post('otp'));
        $login = $this->User_Model->verifyforgototp($userid,$otp);
		if($login=='SUCCESS'){
			$response=array('status'=>'success','msg'=>'Logged in Successfully');
		}else {
			$response=array('status'=>'failed','msg'=>'Incorrect OTP');
		}
		echo json_encode($response);
	}
	
	public function resendsignupotp()
	{
		$userid = $this->session->userdata('signupuserid');
		//$otp = ($this->input->post('otp'));
		$this -> db -> select(' MOBILE ');
        $this -> db -> from('userlogin');
        $this -> db -> where('USERID', $userid);       
        $this -> db -> limit(1);
        $mobile = $this -> db -> get()->row('MOBILE');
        $login = $this->User_Model->resendotp($mobile);
		if($login=='SUCCESS'){
			$response=array('status'=>'success','msg'=>'OTP Sent Successfully');
		}else {
			$response=array('status'=>'failed','msg'=>'Failed to send OTP');
		}
		echo json_encode($response);
	}
	
	public function resendforgetotp()
	{
		$userid = $this->session->userdata('forgotuserid');
		//$otp = ($this->input->post('otp'));
		$this -> db -> select(' MOBILE ');
        $this -> db -> from('userlogin');
        $this -> db -> where('USERID', $userid);       
        $this -> db -> limit(1);
        $mobile = $this -> db -> get()->row('MOBILE');
        $login = $this->User_Model->resendotp($mobile);
		if($login=='SUCCESS'){
			$response=array('status'=>'success','msg'=>'OTP Sent Successfully');
		}else {
			$response=array('status'=>'failed','msg'=>'Failed to send OTP');
		}
		echo json_encode($response);
	}
	
	public function setnewpass()
	{
		$userid = $this->session->userdata('forgotuserid');
		//$otp = ($this->input->post('otp'));
        $login = $this->User_Model->changepass($userid);
		if($login=='SUCCESS'){
			$response=array('status'=>'success','msg'=>'Logged in Successfully');
		}else {
			$response=array('status'=>'failed','msg'=>'Failed');
		}
		echo json_encode($response);
	}
	
	
	public function register()
    {
		$response = $this->User_Model->register();
		echo json_encode($response);
	}
	
	public function forgotpass(){
		$mobile =$this->input->post('mobile');
		$login = $this->User_Model->forgotpass($mobile);
		//print_r($login); 
		if($login=='SUCCESS'){
			$response=array('status'=>'success','msg'=>'OTP Sent To Registered Mobile and Email');
		}else if($login=='INVALID'){
			$response=array('status'=>'invalid','msg'=>'Invalid Mobile or Email');
		}else if($login=='FAILED'){
			$response=array('status'=>'failed','msg'=>'Something went wrong');
		}else {
			$response=array('status'=>'failed','msg'=>'Something went wrong');
		}
		echo json_encode($response);
	}
	
	public function google_auth()
	{
		$credential = $this->input->post('credential');
		$googleData = array();

		// If Google JWT token provided (from Google Identity Services)
		if (!empty($credential)) {
			$parts = explode('.', $credential);
			if (count($parts) === 3) {
				$payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
				if (!empty($payload['sub'])) {
					$googleData = array(
						'guid'    => $payload['sub'],
						'email'   => @$payload['email'],
						'fname'   => @$payload['given_name'] ?: @$payload['name'],
						'lname'   => @$payload['family_name'] ?: '',
						'picture' => @$payload['picture']
					);
				}
			}
		}

		// Fallback to direct POST payload
		if (empty($googleData['guid'])) {
			$googleData = array(
				'guid'    => $this->input->post('guid') ?: $this->input->post('google_id'),
				'email'   => $this->input->post('email'),
				'fname'   => $this->input->post('name') ?: $this->input->post('fname'),
				'picture' => $this->input->post('image') ?: $this->input->post('picture')
			);
		}

		if (!empty($googleData['guid']) || !empty($googleData['email'])) {
			$user = $this->User_Model->google_auth_sync($googleData);
			if ($user) {
				$last_page = $this->session->userdata('last_page');
				$this->session->unset_userdata('last_page');
				$redirect_url = $last_page ?: base_url('myappointments');

				if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
					echo json_encode(array('status' => 'success', 'msg' => 'Google Login Successful', 'redirect_url' => $redirect_url));
					return;
				}
				redirect($redirect_url);
				return;
			}
		}

		if ($this->input->is_ajax_request()) {
			echo json_encode(array('status' => 'failed', 'msg' => 'Unable to authenticate with Google. Please try again.'));
			return;
		}
		$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Google authentication failed. Please try again.</div>');
		redirect(base_url('login'));
	}

	public function google_login()
	{
		$this->google_auth();
	}

	public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}