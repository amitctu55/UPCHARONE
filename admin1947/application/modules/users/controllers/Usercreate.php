<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usercreate extends CI_Controller 
{
	 function __construct() 
	 {
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $date=date('Y-m-d h:i:s');
		 $this->load->model('usercreatemodel');
	}
	 
	public function index()
	{
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('user');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function create()
	{ 
		if(isset($_POST['submit']) || $this->input->post('username')){
			$rawId = $this->input->post('eid');
			$id = (!empty($rawId) && !is_numeric($rawId)) ? base64_decode($rawId) : (int)$rawId;
			
			$username = trim($this->input->post('username'));
			$usermobile = trim($this->input->post('usermobile'));
			$useremail = trim($this->input->post('useremail'));
			$userdob = trim($this->input->post('userdob'));
			$password = $this->input->post('resetpassword');

			$errors = [];
			if (empty($username)) {
				$errors[] = "Full Name is required.";
			}
			if (empty($usermobile) || !preg_match('/^[0-9]{10}$/', $usermobile)) {
				$errors[] = "Mobile Number must be exactly 10 numeric digits.";
			}
			if (empty($useremail) || !filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
				$errors[] = "A valid Email Address is required.";
			}
			if (!empty($userdob)) {
				$dobTime = strtotime($userdob);
				if (!$dobTime || $dobTime > time() || $dobTime < strtotime('1920-01-01')) {
					$errors[] = "Please provide a valid Date of Birth (between 1920 and today).";
				}
			}
			if (empty($id) && empty($password)) {
				$errors[] = "Password is required for creating a new user.";
			}

			if (!empty($errors)) {
				$msg = "<div class='alert alert-danger'><strong>Validation Error:</strong><br>" . implode('<br>', $errors) . "</div>";
				$this->session->set_flashdata('flashmsg', $msg);
				redirect(base_url('users/usercreate'));
				return;
			}

			if(empty($id))
			{
				if($this->usercreatemodel->checkusername())
				{
					if($this->usercreatemodel->usercreateinsert())
					{
						$msg="<div class='alert alert-success'><strong>Success!</strong> Data Inserted Successfully</div>";
						$this->session->set_flashdata('flashmsg',$msg);
					}
					else
					{
						$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
						$this->session->set_flashdata('flashmsg',$msg);
					}
				}
				else
				{
					$msg="<div class='alert alert-danger'><strong>Failed!</strong> Username / Email already exists.</div>";
					$this->session->set_flashdata('flashmsg',$msg);
				}
			}
			else
			{	
				if($this->usercreatemodel->checkusername($id))
				{
					if($this->usercreatemodel->usercreateedit($id))
					{
						$msg="<div class='alert alert-success'><strong>Success!</strong> Data Updated Successfully</div>";
						$this->session->set_flashdata('flashmsg',$msg);
					}
					else{
						$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
						$this->session->set_flashdata('flashmsg',$msg);
					}
				}
				else
				{
					$msg="<div class='alert alert-danger'><strong>Failed!</strong> Username / Email already exists for another account.</div>";
					$this->session->set_flashdata('flashmsg',$msg);
				}
			}
		}
		redirect(base_url().'users/usercreate');
	}
	
	public function fetch()
	{ 
	
		$id=base64_decode($this->input->post('uid'));
		$alldata=array();
		$data=$this->db->get_where('login',array('id'=>$id))->row(); 
		$alldata['id']=base64_encode($data->id);
		$alldata['name']=$data->name;
		$alldata['mobile']=$data->mobile;
		$alldata['email']=$data->email;
		$alldata['dob']=$data->dob;
		$alldata['role']=$data->role;
		$alldata['userid']=$data->username;
		$alldata['active']=$data->status;
		echo json_encode($alldata);
	
	}
	
	public function gettable()
	{
		$getdatas=$this->db->get_where('login',array());
		foreach($getdatas->result() as $getdata)
		{	
			if($getdata->status=='1')
			{
				$active="<p style='color:#6ebd28'>Active</p>";
			}
			else if($getdata->status=='0')
			{
				$active="<p style='color:#f10e0e'>In-Active</p>";
			}
			echo '<tr class="active">
			<td class="tabledata">'.$getdata->id.'</td>
			<td class="tabledata">'.$getdata->name.'</td>
			<td class="tabledata">'.$getdata->address.'</td>
			<td class="tabledata">'.$getdata->mobile.'</td>
			<td class="tabledata">'.$getdata->email.'</td>
			<td class="tabledata">'.$getdata->dob.'</td>
			<td class="tabledata">'.$getdata->username.'</td>
			<td class="tabledata">'.getRoleName($getdata->role).'</td>
			<td class="tabledata">'.$active.'</td>
			<td class="tabledata"><a href="#" style="cursor:pointer" class="select" data-uid="'.base64_encode($getdata->id).'">Select</a></td>
			<td class="tabledata"><a href="#" style="cursor:pointer" class="delete" data-uid="'.$getdata->id.'">Delete</a></td>
		  </tr>';
		}
	}
	
	public function delete()
	{
		$uid = $this->uri->segment('4');
		$success = false;
		if (!empty($uid)) {
			$success = $this->usercreatemodel->usermoddelete($uid);
		}

		// Handle AJAX deletion seamlessly
		if ($this->input->is_ajax_request() || $this->input->get('ajax') == '1') {
			echo ($success ? "Y" : "N");
			return;
		}

		// Handle direct browser link navigation: set flash notification and redirect back
		if ($success) {
			$msg = "<div class='alert alert-success'><strong>Success!</strong> Staff user account deleted successfully.</div>";
		} else {
			$msg = "<div class='alert alert-warning'><strong>Notice:</strong> Staff user record could not be found or has already been removed.</div>";
		}
		$this->session->set_flashdata('flashmsg', $msg);
		redirect(base_url('users/usercreate'));
	}
}
