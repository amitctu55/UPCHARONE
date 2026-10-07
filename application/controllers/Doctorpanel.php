<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctorpanel extends CI_Controller 
{

	function __construct() 
	{
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $this->load->model('Doctor_Model');
		 $this->load->model('Financial_Model');
		 if(!$this->session->userdata('druserid')){
			 $page=$this->uri->segment('1');
			 $excep_array=array('doctor-aindex','doctor-login','doctor-signup','doctor-verifymobile','doctor-forgotpassword','doctor-verifymobileforgot');
			 if (!in_array($page, $excep_array)) {
				if ($this->input->is_ajax_request() || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
					header('Content-Type: application/json');
					echo json_encode(array('status' => 'error', 'message' => 'Your doctor session has expired. Please log in again.'));
					exit;
				}
				redirect('doctor-login');
			}
		 }else{
			 $druserid = $this->session->userdata('druserid');
			 $row = $this->db->where('user_id', $druserid)->or_where('id', $druserid)->get('profile_dr')->row();
			 $this->did = ($row && isset($row->id)) ? $row->id : null;

			 // Verification Check
			 $is_verified = true;
			 $docLog = $this->db->where('USERID', $druserid)->get('doctorlogin')->row();
			 if ($docLog && isset($docLog->APPROVED) && $docLog->APPROVED === '0') {
				 $is_verified = false;
			 }
			 if ($row) {
				 if (isset($row->verification_status) && $row->verification_status === 'rejected') {
					 $is_verified = false;
				 }
				 if (isset($row->status) && $row->status === '0' && (!isset($row->approved) || $row->approved === '0')) {
					 $is_verified = false;
				 }
			 }

			 if (!$is_verified) {
				 $this->session->unset_userdata('druserid');
				 $this->session->unset_userdata('druseremail');
				 $this->session->unset_userdata('drusername');
				 $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger' style='margin: 15px 0; border-radius: 8px;'><i class='fa fa-ban'></i> Your doctor account is pending verification and approval by the administrator. Access denied.</div>");
				 redirect('doctor-login');
				 return;
			 }
		 }
		 
	}
	
	public function index()
	{
		$data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$this->load->view('home1',$data);
	}
	
	public function dashboard()
	{
		$druserid = $this->session->userdata('druserid');
		$data['doctor'] = $this->db->where('id', $this->did)->or_where('user_id', $druserid)->get('profile_dr')->row();
		$userid = $data['doctor'] ? $data['doctor']->id : ($this->did ?: $druserid);

		// Appointments stats
		$data['todayappointment'] = $this->db->where(array('doctor_id' => $userid, 'appointment_date' => date('Y-m-d'), 'status' => '1'))->count_all_results('appointment');
		$data['totalappointment'] = $this->db->where(array('doctor_id' => $userid))->count_all_results('appointment');
		$data['pending_appointments'] = $this->db->where(array('doctor_id' => $userid, 'status' => '1'))->count_all_results('appointment');
		$data['completed_appointments'] = $this->db->where(array('doctor_id' => $userid, 'status' => '2'))->count_all_results('appointment');
		$data['cancelled_appointments'] = $this->db->where(array('doctor_id' => $userid, 'status' => '0'))->count_all_results('appointment');

		// Unique Patients Count
		$patients_res = $this->db->select('COUNT(DISTINCT user_id) as total_patients')->where('doctor_id', $userid)->get('appointment')->row();
		$data['total_patients'] = $patients_res ? intval($patients_res->total_patients) : 0;

		// Video vs In-person (Safely check if column exists)
		$has_appt_type = $this->db->field_exists('appointment_type', 'appointment');
		$data['video_appointments'] = $has_appt_type ? $this->db->where(array('doctor_id' => $userid, 'appointment_type' => 'video'))->count_all_results('appointment') : 0;
		$data['inperson_appointments'] = max(0, $data['totalappointment'] - $data['video_appointments']);

		// Financials
		$data['earnings'] = $this->Financial_Model->get_doctor_earnings($userid);

		// Associated practices & hospitals
		$data['total_clinics'] = $this->db->where(array('user_id' => $userid, 'type' => 'C'))->count_all_results('dr_practice');
		$data['total_hospitals'] = $this->db->where(array('user_id' => $userid, 'type' => 'H'))->count_all_results('dr_practice');

		// 6-Month Monthly Visit Trend Data
		$monthly_labels = array();
		$monthly_data = array();
		for ($i = 5; $i >= 0; $i--) {
			$month_time = strtotime("-$i month");
			$month_key = date('Y-m', $month_time);
			$month_label = date('M Y', $month_time);
			$monthly_labels[] = $month_label;

			$cnt = $this->db->where('doctor_id', $userid)
				->like('appointment_date', $month_key, 'after')
				->count_all_results('appointment');
			$monthly_data[] = $cnt;
		}
		$data['monthly_labels'] = $monthly_labels;
		$data['monthly_data'] = $monthly_data;

		// Recent appointments
		$data['recent_appointments'] = $this->db->select('appointment.*, userlogin.FNAME as user_fname, userlogin.LNAME as user_lname, userlogin.MOBILE as user_mobile')
			->from('appointment')
			->join('userlogin', 'userlogin.USERID = appointment.user_id', 'left')
			->where('appointment.doctor_id', $userid)
			->order_by('appointment.appointment_date', 'DESC')
			->order_by('appointment.appointment_id', 'DESC')
			->limit(15)
			->get()
			->result();

		// Today's appointments list
		$data['today_appointments_list'] = $this->db->select('appointment.*, userlogin.FNAME as user_fname, userlogin.LNAME as user_lname, userlogin.MOBILE as user_mobile')
			->from('appointment')
			->join('userlogin', 'userlogin.USERID = appointment.user_id', 'left')
			->where('appointment.doctor_id', $userid)
			->where('appointment.appointment_date', date('Y-m-d'))
			->order_by('appointment.appointment_time', 'ASC')
			->get()
			->result();

		// Recent patient diet & nutrition logs
		$data['recent_diet_logs'] = array();
		if ($this->db->table_exists('user_diet_logs')) {
			$data['recent_diet_logs'] = $this->db->select('user_diet_logs.*, userlogin.FNAME as user_fname, userlogin.LNAME as user_lname')
				->from('user_diet_logs')
				->join('userlogin', 'userlogin.USERID = user_diet_logs.user_id', 'left')
				->order_by('user_diet_logs.id', 'DESC')
				->limit(5)
				->get()
				->result();
		}

		$this->load->view('doctorpanel/dashboard', $data);
	}

	public function videocall($room = '')
	{
		$room = trim($room);
		if (empty($room)) {
			show_404();
			return;
		}

		$data['room'] = $room;
		$doc_name = $this->session->userdata('drusername') ? 'Dr. ' . $this->session->userdata('drusername') : 'Dr. Anushka';
		$data['display_name'] = $doc_name;

		$this->load->view('video_call', $data);
	}
	
	public function updateprofile()
	{
		$data['data'] = $this->db->get_where('profile_dr', array('id' => $this->did))->row();
		if (!$data['data'] && $this->session->userdata('druserid')) {
			$data['data'] = $this->db->get_where('profile_dr', array('user_id' => $this->session->userdata('druserid')))->row();
		}
		$this->load->view('doctorpanel/milestone', $data);    
	}
	
	public function managedoctor()
	{
		
		$data['clinic']=$this->db->select('profile_dr.*,dr_practice.status as p_status')->join('profile_dr','profile_dr.id=dr_practice.user_id')->get_where('dr_practice',array('institution_id'=>$this->did,'type'=>'H'))->result();	
			
		$this->load->view('doctorpanel/managedoctor',$data);
	}
	
	public function aindex()
	{
		if ($this->session->userdata('userid')) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-info'>You are logged in as a Patient. Please logout to access Doctor Partner Login.</div>");
			redirect('myappointments');
			return;
		}
		if ($this->session->userdata('docuserid')) {
			redirect('doctorpanel/milestone');
			return;
		}
		$this->load->view('doctorpanel/login');
	}
	
	public function login()
	{
		if ($this->session->userdata('userid')) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-info'>You are logged in as a Patient. Please logout to access Doctor Partner Login.</div>");
			redirect('myappointments');
			return;
		}
		if ($this->session->userdata('docuserid')) {
			redirect('doctorpanel/milestone');
			return;
		}
		$this->load->view('doctorpanel/login');
	}
	
	public function signup()
	{
		$this->load->view('doctorpanel/sign_up');
	}
	
	public function forgotpassword()
	{
		$this->load->view('doctorpanel/forgot_password');
	}
	
	public function verifymobile()
	{
		$this->load->view('doctorpanel/otp_send_pass');
	}
	
	/* public function verifymobileforgot()
	{
		$this->load->view('otp_send_pass_forgot');
	} */
	
	
	
	public function progress_profile()
	{
		$this->load->view('doctorpanel/milestone');
	}
	
	public function profile_step1()
	{
		$druserid = $this->session->userdata('druserid');
		if($this->input->post('submit')) {
			$this->Doctor_Model->profile_step1();
		}
		
		$data['data'] = $this->db->where('id', $this->did)->or_where('user_id', $druserid)->get('profile_dr')->row();
		$doc_id = $data['data'] ? $data['data']->id : ($this->did ?: $druserid);

		$data_spl = $this->db->select('specialization_id')->where('user_id', $doc_id)->or_where('user_id', $druserid)->get('dr_specialization')->result_array();
		$data['data_spl'] = array_map (function($value){
					return $value['specialization_id'];
				} , $data_spl);	

		$this->load->view('doctorpanel/profile_step1', $data);
	}
	
	public function profile_step2()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step2();
		$data['data']=$this->db->get_where('profile_dr',array('id'=>$this->did))->row();	
		$this->load->view('doctorpanel/profile_step2',$data);
	}
	
	public function profile_step3()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step3();
		$data['data']=$this->db->get_where('profile_dr',array('id'=>$this->did))->row();	
		$data_qua=$this->db->select('qualification_id')->get_where('dr_qualifications',array('user_id'=>$this->did))->result_array();
		$data['data_qua']= array_map (function($value){
					return $value['qualification_id'];
				} , $data_qua);	
		$this->load->view('doctorpanel/profile_step3',$data);
	}
	
	public function profile_about()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->about();
		$data['data']=$this->db->select('about,short_about')->get_where('profile_dr',array('id'=>$this->did))->row();
		$this->load->view('doctorpanel/about',$data);
	}
	
	
	public function profile_drpic()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_drpic();
		$data['src']=$this->db->select('drimage')->get_where('profile_dr',array('id'=>$this->did))->row('drimage');	
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('doctorpanel/profile_drpic',$data);
	}
	public function profile_idproof()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_idproof();
		
		$data['src']=$this->db->select('id_proof')->get_where('profile_dr',array('id'=>$this->did))->row('id_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('doctorpanel/profile_idproof',$data);
	}
	
	public function mci_proof()
    {
		if(isset($_POST['submit']))
		$this->Doctor_Model->mci_proof();
		
	    $data['src']=$this->db->select('mic_proof')->get_where('profile_dr',array('id'=>$this->did))->row('mic_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		
		$this->load->view('doctorpanel/mci_proof',$data);
	}
	
	public function profile_regproof()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_regproof();
		
		$data['src']=$this->db->select('med_reg_proof')->get_where('profile_dr',array('id'=>$this->did))->row('med_reg_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('doctorpanel/profile_regproof',$data);
	}
	
	public function profile_step4()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step4();
		
		$data['data']=$this->db->get_where('profile_dr',array('id'=>$this->did))->row();	
		$this->load->view('doctorpanel/profile_step4',$data);
	}
	
	
	public function addclinic()
	{
		if(isset($_POST['submit']))
		{
			$data['suggestedclinic'] = $this->Doctor_Model->addclinic();
			$this->load->view('doctorpanel/clinic_sugestion',$data);
		}else
		{
			//select clinic if any one there own clinic 
			//$data['data']=$this->db->get_where('clinic',array('user_id'=>$this->did))->row();	
			$this->load->view('doctorpanel/addclinic',@$data);
		}
	}
	
	
	public function addpractice()
	{
		if(isset($_POST['submit']))
		{
			$return = $this->Doctor_Model->addpractice();
			if(isset($return['C']) OR isset($return['H']))
			{$data['suggestedclinic'] = $return['C'];
			$data['suggestedhospital'] = $return['H'];
			$this->load->view('doctorpanel/practice_sugestion',$data);
			}else{
				$this->load->view('doctorpanel/addpractice',@$data);
			}
		}else
		{
			//select clinic if any one there own clinic 
			//$data['data']=$this->db->get_where('clinic',array('id'=>$this->did))->row();	
			$this->load->view('doctorpanel/addpractice',@$data);
		}
	}
	
	
	public function linkpractice()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->linkpractice();
		
		//$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();	
		//$this->load->view('doctorpanel/profile_step4',$data);
	}
	
	public function profile_step6()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step6();
		
		//$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();	
		//$this->load->view('doctorpanel/profile_step4',$data);
	}
	
	
	public function progress_profile2()
	{
		$this->load->view('doctorpanel/milestone2');
	}
	
	public function profile_clinicproof()
	{
		$clinicid=mybase64_decode( $this->uri->segment(2) );
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_clinicproof();
		$data['src']=$this->db->select('med_reg_proof')->get_where('clinic',array('id'=>$clinicid))->row('med_reg_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('doctorpanel/profile_clinicproof',$data);
	}
	
	public function progress_profile3()
	{
		$this->load->view('doctorpanel/milestone3');
	}
	
	
	public function updateclinic()
	{
		$clinicid=$this->uri->segment(2);
		if(isset($_POST['submit']))
			$this->Doctor_Model->updateclinic();
		$data['data']=$this->db->get_where('clinic',array('id'=>mybase64_decode($clinicid)))->row();	
		$this->load->view('doctorpanel/updateclinic',$data);
	}
	
	public function profile_maplocation()
	{
		$clinicid=$this->uri->segment(2);
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_maplocation();
		$data['data']=$this->db->get_where('clinic',array('id'=>mybase64_decode($clinicid)))->row();	
		$this->load->view('doctorpanel/profile_maplocation',$data);
	}
	
	public function profile_clinic_timing()
	{
		$clinicid=mybase64_decode( $this->uri->segment(2) );//check if loged in 
		
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_clinic_timing();
		
		$timings=$this->db->get_where('timing',array('user_id'=>$clinicid,'user_type'=>'C'));
		$data['timing_count']=$timings->num_rows();
		$data['timings']=$timings->result();
		
		$this->load->view('doctorpanel/profile_clinic_timing',$data);
	}
	
	public function profile_consultant_fee()
	{
		$pid=mybase64_decode( $this->uri->segment(2) );//check if loged in 
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_consultant_fee();
		$data['practice']=$this->db->get_where('dr_practice',array('id'=>$pid))->row();
		$timings=$this->db->get_where('timing',array('practice_id'=>$pid));
		$data['timing_count']=$timings->num_rows();
		$data['timings']=$timings->result();
		//$data['sessions']=$this->db->get_where('timing_session',array('timing_id'=>@$data['timing']->id))->result();
		$this->load->view('doctorpanel/profile_consultant_fee',$data);
	}
	
	public function progress_profile4()
	{
		$this->load->view('doctorpanel/milestone4');
	}
	
	
	public function manageownclinic()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step2();
		$data['data']=$this->db->select('clinic.*,clinic_claimed.status as claim_status')->join('clinic','clinic.id=clinic_claimed.clinic_id')->get_where('clinic_claimed',array('did'=>$this->did))->result();	
		$this->load->view('doctorpanel/manageownclinic',$data);
	}
	
	
	public function managepractice()
	{
		$userid = $this->did;

		if ($this->input->post('update_fee')) {
			$practice_id = intval($this->input->post('practice_id'));
			$new_fee = intval($this->input->post('fee'));
			if ($practice_id > 0) {
				$this->db->where('id', $practice_id)->where('user_id', $userid)->update('dr_practice', array('fee' => $new_fee));
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Consultation fee updated successfully.</div>");
				redirect('managepractice');
				return;
			}
		}

		if ($this->input->post('status_action') != '') {
			$this->Doctor_Model->update_status('dr_practice', 'id');
		}

		$data['clinic'] = $this->db->select('clinic.*, dr_practice.id as practice_id, dr_practice.status as practice_status, dr_practice.fee as practicefee')
			->join('clinic', 'clinic.id=dr_practice.institution_id')
			->get_where('dr_practice', array('dr_practice.user_id' => $userid, 'dr_practice.type' => 'C'))
			->result();

		$data['hospital'] = $this->db->select('hospital.*, dr_practice.id as practice_id, dr_practice.status as practice_status, dr_practice.fee as practicefee')
			->join('hospital', 'hospital.id=dr_practice.institution_id')
			->get_where('dr_practice', array('dr_practice.user_id' => $userid, 'dr_practice.type' => 'H'))
			->result();

		$doc_profile = $this->db->where('id', $userid)->or_where('user_id', $this->session->userdata('druserid'))->get('profile_dr')->row();
		$data['is_video_consult_enabled'] = ($doc_profile && isset($doc_profile->is_video_consult_enabled)) ? (int)$doc_profile->is_video_consult_enabled : 0;

		$this->load->view('doctorpanel/managepractice', $data);
	}

	public function delete_practice($id = null)
	{
		$userid = $this->did;
		$id = intval($id ?: $this->input->get('id'));
		if ($id) {
			$this->db->where('id', $id)->where('user_id', $userid)->delete('dr_practice');
			$this->db->where('practice_id', $id)->where('user_id', $userid)->delete('timing');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Practice location removed from your profile successfully.</div>");
		}
		redirect('managepractice');
	}
	
	public function manageappointment()
	{
		$userid = $this->did;
		$date_filter = $this->input->get('d', TRUE);
		$status_filter = $this->input->get('status', TRUE);
		$search_query = $this->input->get('q', TRUE);

		// Stats
		$data['today_count'] = $this->db->where(array('doctor_id' => $userid, 'appointment_date' => date('Y-m-d'), 'status !=' => '0'))->count_all_results('appointment');
		$data['total_count'] = $this->db->where(array('doctor_id' => $userid, 'status !=' => '0'))->count_all_results('appointment');
		$data['completed_count'] = $this->db->where(array('doctor_id' => $userid, 'status' => '2'))->count_all_results('appointment');
		$data['pending_count'] = $this->db->where(array('doctor_id' => $userid, 'status' => '1'))->count_all_results('appointment');

		// Query appointments
		$this->db->select('appointment.*, userlogin.FNAME as user_fname, userlogin.LNAME as user_lname, userlogin.MOBILE as user_mobile, userlogin.EMAIL as user_email');
		$this->db->from('appointment');
		$this->db->join('userlogin', 'userlogin.USERID = appointment.user_id', 'left');
		$this->db->where('appointment.doctor_id', $userid);

		if (!empty($date_filter)) {
			$this->db->where('appointment.appointment_date', $date_filter);
		}
		if ($status_filter !== null && $status_filter !== '' && $status_filter !== 'ALL') {
			$this->db->where('appointment.status', $status_filter);
		} else {
			$this->db->where('appointment.status !=', '0');
		}
		if (!empty($search_query)) {
			$this->db->group_start();
			$this->db->like('appointment.appointment_name', $search_query);
			$this->db->or_like('appointment.patient_name', $search_query);
			$this->db->or_like('appointment.patient_mobile', $search_query);
			$this->db->or_like('userlogin.FNAME', $search_query);
			$this->db->or_like('userlogin.MOBILE', $search_query);
			$this->db->or_like('appointment.appointment_id', $search_query);
			$this->db->group_end();
		}

		$this->db->order_by('appointment.appointment_date', 'DESC');
		$this->db->order_by('appointment.appointment_id', 'DESC');
		$query = $this->db->get();

		$dataarray = array();
		if ($query->num_rows() > 0) {
			$results = $query->result();
			foreach ($results as $row) {
				$table = ($row->institution_type == 'H') ? 'hospital' : 'clinic';
				$institute = null;
				if (!empty($row->institute_id)) {
					$institute = $this->db->get_where($table, array('id' => $row->institute_id))->row();
				}
				$dataarray[] = array('appointment' => $row, 'institute' => $institute);
			}
		}

		$data['appointments'] = $dataarray;
		$data['selected_date'] = $date_filter;
		$data['selected_status'] = $status_filter ?: 'ALL';
		$data['search_query'] = $search_query;

		$this->load->view('doctorpanel/manageappointment', $data);
	}
	
	
	public function hospitallist()
	{
		$data['hospital']=$this->db->get_where('hospital', array('status'=>'1'))->result();
		$this->load->view('doctorpanel/hospitallist',$data);
	}
	
	 
	
	/*******************************************************************************************/
	public function doctors()
	{
		$this->load->view('team_list');
	}
	
	public function doctor()
	{
		$id=$this->uri->segment(2);
		$data['d']=$this->db->get_where('profile_dr',array('approved'=>'1','verified'=>'1','id'=>$id))->row();
		$this->load->view('detail_page',$data);
	}
	
	public function gethint()
	{
		$q=$_REQUEST["q"]; 
		$sql="SELECT concat(fname,' ',lname) as name FROM `profile_dr` WHERE (fname LIKE '%$q%' or lname LIKE '%$q%' ) AND approved='1' AND verified='1' 
		UNION
		SELECT  name FROM `clinic` WHERE (name LIKE '%$q%'  ) AND status='1' 
		UNION
		SELECT name FROM `hospital` WHERE (name LIKE '%$q%'  ) AND status='1'
		";
		$result =$this->db->query($sql)->result();
		
		$json=array();

		foreach($result as $row) {
		  array_push($json, $row->name);
		}

		echo json_encode($json);
	}
	
	public function gethintcity()
	{
		$q=$_REQUEST["q"]; 
		$sql="SELECT id,name FROM `master_city` WHERE (name LIKE '%$q%'  ) AND status='1'	";
		$result =$this->db->query($sql)->result();
		
		$json=array();

		foreach($result as $row) {
		  array_push($json, array('value'=> $row->id,'label'=> $row->name));
		}

		echo json_encode($json);
	}
	
	
	public function search()
	{
		$keyword = $this->input->get('keyword');
		$spl = $this->input->get('spl');
		$city = $this->input->get('city');
		
		if($spl!=''){
			$this->db->where("specialization_id",$spl);
			$this->db->join("dr_specialization",'dr_specialization.user_id=profile_dr.id');
			$this->db->select("profile_dr.*, dr_specialization.specialization_id");
		}
		if($city!='')
			$this->db->where("city",$city);
		$this->db->like("concat(fname,' ',lname)",$keyword);
		
		$data['doctors']=$this->db->get_where('profile_dr',array('approved'=>'1','verified'=>'1'))->result();
		
		if($city!='')
			$this->db->where("city",$city);
		$this->db->like("name",$keyword);
		$this->db->or_like("tag",$keyword);
		$data['hospital']=$this->db->get_where('hospital', array('status'=>'1'))->result();
		
		if($city!='')
			$this->db->where("city",$city);
		$this->db->like("name",$keyword);
		$this->db->or_like("tag",$keyword);
		$data['clinic']=$this->db->get_where('clinic', array('status'=>'1'))->result();
		
		$this->load->view('team_list',$data);
	}
	
	public function process(){
		$query = $this->input->post('query');
		$qs=explode(';',trim($query));
		foreach ($qs as $q){
			if(trim($q)=='')
				continue;
		$query = $this->db->query($q);
		}
		if($query===true)
			echo $this->db->affected_rows() .' Rows Affected!!<br><a href="'.base_url().'sql">New Query</a><br>';
		else{
			echo $this->db->affected_rows() .' Rows Affected!!<br><a href="'.base_url().'sql">New Query</a><br>';
		echo '<pre>';
		print_r($query->result()); 
	echo '</pre>';
		}
	}
	
	public function app_conf_pop_doctor(){
		$id=$_GET['doctor'];
		$data=$this->db->get_where('profile_dr',array('id'=>$id))->row();
		
		$content = '<div class="col-md-4">    
		<img src="'.admin_url().'public/assets/upload/'.$data->drimage.'" alt="">
		</div>

		<div class="col-md-8">    
		<div class="doc_nam_inf" >';
		
		$content.= ' <span >'.$data->fname.' '.$data->lname.'</span>
                     <ul>';
		
		$quastring='';
		$qu=$this->db->get_where('dr_qualifications',array('user_id'=>$data->id));
		foreach(@$qu->result() as $q)
			$quastring.=getQualificationName($q->qualification_id).', ';
		$quastring=rtrim($quastring,', ');
        $content.= '<li>'.$quastring .'</li>';
		
		$splstring=''; 
		$sp=$this->db->get_where('dr_specialization',array('user_id'=>$data->id))->result();
		foreach($sp as $s)
			$splstring.=getSpecilizationName($s->specialization_id).', ';
		$splstring=rtrim($splstring,', ');
        $content.= '<li><b>'.$splstring.'</b></li>';

        echo  $content.= '</ul></div>
                        </div>';
	}
	
	public function app_conf_pop_institute(){
		$id=$_GET['doctor'];
		$date=$_GET['date'];
		$time=$_GET['time'];
		//$day_no = date('N',strtotime($date));
		//$day=array('1'=>'M','2'=>'T','3'=>'W','4'=>'TH','5'=>'F','6'=>'SA','7'=>'S');
		$data=$this->db->get_where('timing_session',array('id'=>$time))->row();
		$timing_id=$data->timing_id;
		$data=$this->db->get_where('timing',array('id'=>$timing_id))->row();
		$pid=$data->practice_id;
		$data=$this->db->get_where('dr_practice',array('id'=>$pid))->row();
		$did=$data->user_id;
		$type=$data->type;
		if($type=='H')
			$type='hospital';
		else
			$type='clinic';
		$institution_id=$data->institution_id;
		$fee=$data->fee;
		
		$institution=$this->db->get_where($type,array('id'=>$institution_id))->row();
		
		echo $content = '<div class="col-md-4">    
    <img src="images/dentist.png" alt="">
</div>

<div class="col-md-8">    
<div class="doc_nam_inf">
                                <span>'.$institution->name.'</span>
                                <ul>
                                    <li>'.$institution->address.'</li>
                                    <li> Fee: Rs. '.$fee.'</li>

                                </ul>
                            </div>
                        </div>';
	}
	
	public function app_conf_pop_date(){
		$id=$_GET['doctor'];
		$data=$this->db->get_where('timing',array('user_id'=>$id,'user_type'=>'D'))->result();
		//last_query();
		$day=array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0);
		foreach($data as $d){
			if(!$day['1'])
				$day['1']=$d->M;
			if(!$day['2'])
				$day['2']=$d->T;
			if(!$day['3'])
				$day['3']=$d->W;
			if(!$day['4'])
				$day['4']=$d->TH;
			if(!$day['5'])
				$day['5']=$d->F;
			if(!$day['6'])
				$day['6']=$d->SA;
			if(!$day['7'])
				$day['7']=$d->S;
			//echo '='.in_array(0, $day).'=';
			if(!in_array(0, $day))
				break;
		}
		
		$period = new DatePeriod(
			 new DateTime(date('Y-m-d')),
			 new DateInterval('P1D'),
			 new DateTime(date('Y-m-d', strtotime(date('Y-m-d'). ' + 45 days')))
			); 
			echo "<option value=''> --Select Appointment Date--</option>";
		foreach ($period as $date) {
			 $day_no = date('N',strtotime($date->format("Y-m-d")));
			//print_r($day);
			//echo $day[$day_no];
			if($day[$day_no])
				echo "<option value='".$date->format("Y-m-d")."'>".$date->format("jS M Y")."</option>";
			
		}
		
	}
	
	public function app_conf_pop_time(){
		$id=$_GET['doctor'];
		$date=$_GET['date'];
		$day_no = date('N',strtotime($date));
		$day=array('1'=>'M','2'=>'T','3'=>'W','4'=>'TH','5'=>'F','6'=>'SA','7'=>'S');
		$data=$this->db->get_where('timing',array('user_id'=>$id,'user_type'=>'D',$day[$day_no]=>'1'))->result();
		/* //last_query();
		$day=array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0);
		foreach($data as $d){
			if(!$day['1'])
				$day['1']=$d->M;
			if(!$day['2'])
				$day['2']=$d->T;
			if(!$day['3'])
				$day['3']=$d->W;
			if(!$day['4'])
				$day['4']=$d->TH;
			if(!$day['5'])
				$day['5']=$d->F;
			if(!$day['6'])
				$day['6']=$d->SA;
			if(!$day['7'])
				$day['7']=$d->S;
			//echo '='.in_array(0, $day).'=';
			if(!in_array(0, $day))
				break;
		} */
		
		/* $period = new DatePeriod(
			 new DateTime(date('Y-m-d')),
			 new DateInterval('P1D'),
			 new DateTime(date('Y-m-d', strtotime(date('Y-m-d'). ' + 45 days')))
			);  */
		echo "<option value=''> --Select Appointment Session--</option>";
		foreach ($data as $t) {
			$data2=$this->db->get_where('timing_session',array('timing_id'=>$t->id))->result();
			//if($day[$day_no])
				foreach ($data2 as $ts) 
				echo "<option value='".$ts->id."'>".$ts->from_timing.' '.$ts->to_timing.' '."</option>";
			
		}
		
	}
	
	/*

       public function profile()
       {
            $id=$this->input->get('user_id');
           
            $result['profile_dr']=$this->Doctor_Model->display($id);
          
             //print_r($result);
            $this->load->view('doctorpanel/myprofile',$result);
          
       }
       */
       
       
          public function change_password()
          {
              
              
             if($this->input->post('change_pass'))
		{
		$cur_password = md5($this->input->post('password'));
        $new_password = md5($this->input->post('newpass'));
        $conf_password = md5($this->input->post('confpassword'));
        $id=$this->session->userdata('druserid');

        $passwd = $this->Doctor_Model->change_password($id);
        if($passwd->PASSWORD == $cur_password)
        {
            if($new_password == $conf_password)
            {
                if($this->Doctor_Model->updatePassword($new_password, $id))
                {
                    
                   $flashmsg="<div class='alert alert-success'><h4>Password Updated Successfully!</h4></div>";
                    
                    //$flashmsg='Password Updated Successfully!';
						$this->session->set_flashdata('msg',$flashmsg);
                }
                else{
                    $flashmsg="<div class='alert alert-danger'><h4>Failed to Updated Password</h4></div>";
                   
                   // $flashmsg='Failed to Updated Password';
						$this->session->set_flashdata('msg',$flashmsg);
                }
            }
            else{
                 
                 $flashmsg="<div class='alert alert-danger'><h4>Sorry! New Password and Confirm Password not matching</h4></div>";
                //$flashmsg='New Password and Confirm Password not matching';
						$this->session->set_flashdata('msg',$flashmsg);
            }
        }
        else{
           
              $flashmsg="<div class='alert alert-danger'><h4>Sorry! Curent Password is not matching</h4></div>";
              //$flashmsg='Sorry Curent Password is not matching';
						$this->session->set_flashdata('msg',$flashmsg);
       }
     
		} 


				
           $this->load->view('doctorpanel/change_password');
           
       }


public function gallery()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST' || isset($_POST['submit'])) {
			if (!empty($_FILES['uploadimage']['name'])) {
				$extsign = strtolower(pathinfo($_FILES['uploadimage']['name'], PATHINFO_EXTENSION));
				$allowed_exts = array('jpg', 'jpeg', 'png', 'gif');

				if (!in_array($extsign, $allowed_exts)) {
					$flashmsg = '<div class="alert alert-danger"><strong>Failed!</strong> Invalid file format. Only JPG, PNG, and JPEG files are allowed.</div>';
					$this->session->set_flashdata('flashmsg', $flashmsg);
					redirect('doctorpanel/gallery');
					return;
				}

				$rname = rand(1111111, 999999999);
				$date = date('Y-m-d');
				$uploadimage = 'dr_gallery_' . $rname . '_' . $date . '.' . $extsign;

				$config['upload_path']   = './admin1947/public/assets/upload/';
				$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
				$config['max_size']      = 2048;
				$config['file_name']     = $uploadimage;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('uploadimage')) {
					$error = $this->upload->display_errors('', '');
					$flashmsg = '<div class="alert alert-danger"><strong>Failed!</strong> ' . $error . '</div>';
					$this->session->set_flashdata('flashmsg', $flashmsg);
					redirect('doctorpanel/gallery');
					return;
				}

				$upload_data = $this->upload->data();
				$final_filename = !empty($upload_data['file_name']) ? $upload_data['file_name'] : $uploadimage;

				if ($this->Doctor_Model->gallery($final_filename)) {
					$msg = "<div class='alert alert-success'><strong>Success!</strong> Photo added to gallery successfully.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
				} else {
					$msg = "<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong saving to database.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
				}

				redirect('doctorpanel/gallery');
				return;
			} else {
				$this->session->set_flashdata('flashmsg', '<div class="alert alert-warning"><strong>Notice:</strong> Please select an image file to upload.</div>');
				redirect('doctorpanel/gallery');
				return;
			}
		}

		$userid = $this->did;
		$druserid = $this->session->userdata('druserid');
		$data['gallery'] = $this->db->group_start()->where('user_id', $userid)->or_where('user_id', $druserid)->group_end()->order_by('id', 'DESC')->get('doctorgallery')->result_array();
		$this->load->view('doctorpanel/gallery', $data);
	}

	public function managegallery()
	{ 	
		$userid = $this->did;
		$druserid = $this->session->userdata('druserid');
		$data['gallery'] = $this->db->group_start()->where('user_id', $userid)->or_where('user_id', $druserid)->group_end()->order_by('id', 'DESC')->get('doctorgallery')->result_array();	
		
		$this->load->view('doctorpanel/managegallery', $data);
	}

	public function delete_gallery($id = 0)
	{
		$userid   = $this->did;
		$druserid = $this->session->userdata('druserid');
		$id       = intval($id);

		if ($id > 0) {
			$this->db->where('id', $id)
				->group_start()->where('user_id', $userid)->or_where('user_id', $druserid)->group_end()
				->delete('doctorgallery');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Gallery photo deleted successfully.</div>");
		}
		redirect('doctorpanel/managegallery');
	}

	public function datetime()
	{
		$userid = $this->did;

		// Handle Form Submission (Add or Update Timing with Upsert & Overlap Prevention)
		if ($this->input->post('submit')) {
			$practice_id = intval($this->input->post('practice_id'));
			$timing_id   = intval($this->input->post('timing_id'));
			$day_sched   = $this->input->post('day_sched'); // Array from day-wise scheduler

			$day_map = array(
				'MON' => 'M',
				'TUE' => 'T',
				'WED' => 'W',
				'THU' => 'TH',
				'FRI' => 'F',
				'SAT' => 'SA',
				'SUN' => 'S'
			);

			$configured_sessions = array();
			$timing_flags = array('M' => 0, 'T' => 0, 'W' => 0, 'TH' => 0, 'F' => 0, 'SA' => 0, 'S' => 0);

			// Support both new day_sched array and legacy form submission
			if (!empty($day_sched) && is_array($day_sched)) {
				foreach ($day_sched as $d_code => $cfg) {
					if (!empty($cfg['active']) && isset($day_map[$d_code])) {
						$timing_flags[$day_map[$d_code]] = 1;
						$custom_fee = !empty($cfg['fee']) ? floatval($cfg['fee']) : 0.00;

						// Morning Session
						if (!empty($cfg['morning_active']) && !empty($cfg['morning_from']) && !empty($cfg['morning_to'])) {
							$m_start = date('H:i:s', strtotime($cfg['morning_from']));
							$m_end   = date('H:i:s', strtotime($cfg['morning_to']));
							$m_max   = intval($cfg['morning_max'] ?? 15) ?: 15;

							$configured_sessions[] = array(
								'doctor_id'        => $userid,
								'clinic_id'        => $practice_id,
								'day_of_week'      => $d_code,
								'session_type'     => 'MORNING',
								'start_time'       => $m_start,
								'end_time'         => $m_end,
								'consultation_fee' => $custom_fee,
								'max_patients'     => $m_max,
								'is_active'        => 1
							);
						}

						// Evening Session
						if (!empty($cfg['evening_active']) && !empty($cfg['evening_from']) && !empty($cfg['evening_to'])) {
							$e_start = date('H:i:s', strtotime($cfg['evening_from']));
							$e_end   = date('H:i:s', strtotime($cfg['evening_to']));
							$e_max   = intval($cfg['evening_max'] ?? 15) ?: 15;

							$configured_sessions[] = array(
								'doctor_id'        => $userid,
								'clinic_id'        => $practice_id,
								'day_of_week'      => $d_code,
								'session_type'     => 'EVENING',
								'start_time'       => $e_start,
								'end_time'         => $e_end,
								'consultation_fee' => $custom_fee,
								'max_patients'     => $e_max,
								'is_active'        => 1
							);
						}
					}
				}
			} else {
				// Legacy Fallback Handler
				$days = (array)$this->input->post('days');
				$morning_from = $this->input->post('morning_from', TRUE);
				$morning_to   = $this->input->post('morning_to', TRUE);
				$morning_max  = intval($this->input->post('morning_max')) ?: 15;
				$evening_from = $this->input->post('evening_from', TRUE);
				$evening_to   = $this->input->post('evening_to', TRUE);
				$evening_max  = intval($this->input->post('evening_max')) ?: 15;

				foreach ($day_map as $d_code => $d_key) {
					if (in_array($d_key, $days)) {
						$timing_flags[$d_key] = 1;
						if (!empty($morning_from) && !empty($morning_to)) {
							$configured_sessions[] = array(
								'doctor_id'        => $userid,
								'clinic_id'        => $practice_id,
								'day_of_week'      => $d_code,
								'session_type'     => 'MORNING',
								'start_time'       => date('H:i:s', strtotime($morning_from)),
								'end_time'         => date('H:i:s', strtotime($morning_to)),
								'consultation_fee' => 0.00,
								'max_patients'     => $morning_max,
								'is_active'        => 1
							);
						}
						if (!empty($evening_from) && !empty($evening_to)) {
							$configured_sessions[] = array(
								'doctor_id'        => $userid,
								'clinic_id'        => $practice_id,
								'day_of_week'      => $d_code,
								'session_type'     => 'EVENING',
								'start_time'       => date('H:i:s', strtotime($evening_from)),
								'end_time'         => date('H:i:s', strtotime($evening_to)),
								'consultation_fee' => 0.00,
								'max_patients'     => $evening_max,
								'is_active'        => 1
							);
						}
					}
				}
			}

			// 1. Cross-Clinic Schedule Overlap Validation
			if ($this->db->table_exists('doctor_schedules') && !empty($configured_sessions)) {
				foreach ($configured_sessions as $cs) {
					$overlap_query = $this->db->query("
						SELECT ds.*, 
						       IFNULL(c.name, IFNULL(h.name, 'Another Practice Chamber')) as conflict_name
						FROM doctor_schedules ds
						LEFT JOIN dr_practice p ON p.id = ds.clinic_id
						LEFT JOIN clinic c ON (p.type = 'C' AND c.id = p.institution_id)
						LEFT JOIN hospital h ON (p.type = 'H' AND h.id = p.institution_id)
						WHERE ds.doctor_id = ? 
						  AND ds.clinic_id != ? 
						  AND ds.day_of_week = ? 
						  AND ds.is_active = 1
						  AND (? < ds.end_time AND ? > ds.start_time)
						LIMIT 1
					", array($userid, $practice_id, $cs['day_of_week'], $cs['start_time'], $cs['end_time']))->row();

					if ($overlap_query) {
						$day_full = $cs['day_of_week'];
						$this->session->set_flashdata('flashmsg', 
							"<div class='alert alert-danger'><strong><i class='fa fa-exclamation-triangle'></i> Schedule Overlap Detected!</strong> On <strong>{$day_full}</strong>, you already have a scheduled session at <strong>{$overlap_query->conflict_name}</strong> from <strong>" . date('h:i A', strtotime($overlap_query->start_time)) . " to " . date('h:i A', strtotime($overlap_query->end_time)) . "</strong>. A doctor cannot be scheduled in two locations simultaneously. Please adjust your timings.</div>"
						);
						redirect('doctorpanel/datetime');
						return;
					}
				}
			}

			// 2. Upsert Pattern to Prevent Duplicate Practice Records
			// Check if a timing record already exists for this doctor and practice
			$existing_timing = null;
			if ($timing_id > 0) {
				$existing_timing = $this->db->get_where('timing', array('id' => $timing_id, 'user_id' => $userid))->row();
			} else {
				$existing_timing = $this->db->get_where('timing', array('user_id' => $userid, 'practice_id' => $practice_id, 'user_type' => 'D'))->row();
			}

			$timing_data = array_merge(array(
				'user_type'   => 'D',
				'user_id'     => $userid,
				'practice_id' => $practice_id,
				'status'      => '1'
			), $timing_flags);

			if ($existing_timing) {
				$current_timing_id = $existing_timing->id;
				$this->db->where('id', $current_timing_id)->update('timing', $timing_data);
				$this->db->where('timing_id', $current_timing_id)->delete('timing_session');
			} else {
				$this->db->insert('timing', $timing_data);
				$current_timing_id = $this->db->insert_id();
			}

			// 3. Upsert into doctor_schedules table
			if ($this->db->table_exists('doctor_schedules')) {
				$this->db->where('doctor_id', $userid)->where('clinic_id', $practice_id)->delete('doctor_schedules');
				foreach ($configured_sessions as $cs) {
					$this->db->insert('doctor_schedules', $cs);
				}
			}

			// 4. Populate legacy timing_session rows for backward compatibility
			$legacy_sessions_added = array();
			foreach ($configured_sessions as $cs) {
				$sess_key = $cs['start_time'] . '_' . $cs['end_time'];
				if (!isset($legacy_sessions_added[$sess_key])) {
					$this->db->insert('timing_session', array(
						'timing_id'        => $current_timing_id,
						'from_timing'      => date('h:i A', strtotime($cs['start_time'])),
						'to_timing'        => date('h:i A', strtotime($cs['end_time'])),
						'max_patient'      => $cs['max_patients'],
						'consultation_fee' => $cs['consultation_fee'],
						'status'           => 1
					));
					$legacy_sessions_added[$sess_key] = true;
				}
			}

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong><i class='fa fa-check-circle'></i> Success!</strong> Schedule timings and slot availability saved successfully with duplicate prevention.</div>");
			redirect('doctorpanel/datetime');
			return;
		}

		// Fetch Doctor's Practice Locations
		$practices = $this->db->where('user_id', $userid)->where('status', '1')->get('dr_practice')->result();
		$practice_list = array();
		foreach ($practices as $p) {
			$table = ($p->type == 'H') ? 'hospital' : 'clinic';
			$inst = $this->db->get_where($table, array('id' => $p->institution_id))->row();
			$practice_list[] = array(
				'practice_id'   => $p->id,
				'type'          => $p->type,
				'name'          => $inst ? $inst->name : ($p->type == 'H' ? 'Visiting Hospital' : 'Private Clinic'),
				'address'       => $inst ? $inst->address : '',
				'fee'           => $p->fee
			);
		}
		$data['practices'] = $practice_list;

		// Fetch Existing Schedules
		$timings = $this->db->where('user_id', $userid)->where('user_type', 'D')->get('timing')->result();
		$schedules = array();
		foreach ($timings as $t) {
			$sessions = $this->db->where('timing_id', $t->id)->get('timing_session')->result();
			$inst_name = 'General Practice';
			$inst_address = '';
			$inst_fee = 0;
			if ($t->practice_id > 0) {
				$pr = $this->db->get_where('dr_practice', array('id' => $t->practice_id))->row();
				if ($pr) {
					$inst_fee = $pr->fee;
					$table = ($pr->type == 'H') ? 'hospital' : 'clinic';
					$inst = $this->db->get_where($table, array('id' => $pr->institution_id))->row();
					if ($inst) {
						$inst_name = $inst->name;
						$inst_address = $inst->address;
					}
				}
			}

			// Also fetch detailed records from doctor_schedules if available
			$day_records = array();
			if ($this->db->table_exists('doctor_schedules') && $t->practice_id > 0) {
				$day_records = $this->db->where('doctor_id', $userid)
				                        ->where('clinic_id', $t->practice_id)
				                        ->where('is_active', 1)
				                        ->order_by('FIELD(day_of_week, "MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN")', 'ASC')
				                        ->get('doctor_schedules')->result();
			}

			$schedules[] = array(
				'timing'       => $t,
				'sessions'     => $sessions,
				'day_records'  => $day_records,
				'inst_name'    => $inst_name,
				'inst_address' => $inst_address,
				'inst_fee'     => $inst_fee
			);
		}
		$data['schedules'] = $schedules;

		$this->load->view('doctorpanel/datetime', $data);
	}

	public function delete_timing($id = null)
	{
		$userid = $this->did;
		$id = intval($id ?: $this->input->get('id'));
		if ($id) {
			$t = $this->db->get_where('timing', array('id' => $id, 'user_id' => $userid))->row();
			if ($t) {
				if ($this->db->table_exists('doctor_schedules') && $t->practice_id > 0) {
					$this->db->where('doctor_id', $userid)->where('clinic_id', $t->practice_id)->delete('doctor_schedules');
				}
				$this->db->where('id', $id)->where('user_id', $userid)->delete('timing');
				$this->db->where('timing_id', $id)->delete('timing_session');
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong><i class='fa fa-check-circle'></i></strong> Schedule timing removed successfully.</div>");
		}
		redirect('doctorpanel/datetime');
	}

	public function upcharhospital()
	{
		$userid = $this->did;

		// Doctor's Affiliation Status Mapping (from doctor_hospital_links and legacy dr_practice)
		$status_map = array();
		if ($this->db->table_exists('doctor_hospital_links')) {
			$links = $this->db->get_where('doctor_hospital_links', array('doctor_id' => $userid))->result();
			foreach ($links as $l) {
				$status_map[$l->hospital_id] = $l->status;
			}
		}

		// Legacy dr_practice fallback / sync
		$practices = $this->db->get_where('dr_practice', array('user_id' => $userid, 'type' => 'H'))->result();
		foreach ($practices as $p) {
			if (!isset($status_map[$p->institution_id])) {
				$status_map[$p->institution_id] = ($p->status == '1') ? 'verified' : 'pending';
			}
		}
		$data['affiliation_status_map'] = $status_map;

		// Handle Standard (Non-AJAX) Affiliation POST Fallback
		if ($this->input->post('affiliate_hospital')) {
			$hospital_id = intval($this->input->post('hospital_id'));
			$fee = floatval($this->input->post('fee')) ?: 500.00;
			
			if ($hospital_id > 0) {
				if ($this->db->table_exists('doctor_hospital_links')) {
					$existing_link = $this->db->get_where('doctor_hospital_links', array('doctor_id' => $userid, 'hospital_id' => $hospital_id))->row();
					if ($existing_link) {
						$this->db->where('id', $existing_link->id)->update('doctor_hospital_links', array(
							'status' => 'pending',
							'fee' => $fee,
							'updated_at' => date('Y-m-d H:i:s')
						));
					} else {
						$this->db->insert('doctor_hospital_links', array(
							'doctor_id' => $userid,
							'hospital_id' => $hospital_id,
							'status' => 'pending',
							'fee' => $fee,
							'created_at' => date('Y-m-d H:i:s')
						));
					}
				}

				// Sync dr_practice (status = '0' for pending verification)
				$chk = $this->db->where(array('user_id' => $userid, 'institution_id' => $hospital_id, 'type' => 'H'))->get('dr_practice')->row();
				if ($chk) {
					$this->db->where('id', $chk->id)->update('dr_practice', array('status' => '0', 'fee' => $fee));
				} else {
					$this->db->insert('dr_practice', array(
						'user_id'        => $userid,
						'institution_id' => $hospital_id,
						'type'           => 'H',
						'fee'            => $fee,
						'status'         => '0'
					));
				}

				$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning' style='border-radius: 8px;'><strong>Request Sent!</strong> Affiliation request submitted to hospital. Status is currently <strong>Pending Verification</strong>.</div>");
				redirect('doctorpanel/upcharhospital');
				return;
			}
		}

		// Handle Standard (Non-AJAX) Cancel / Unlink POST Fallback
		if ($this->input->post('cancel_affiliation')) {
			$hospital_id = intval($this->input->post('hospital_id'));
			if ($hospital_id > 0) {
				if ($this->db->table_exists('doctor_hospital_links')) {
					$this->db->where(array('doctor_id' => $userid, 'hospital_id' => $hospital_id))->delete('doctor_hospital_links');
				}

				$practice = $this->db->get_where('dr_practice', array('user_id' => $userid, 'institution_id' => $hospital_id, 'type' => 'H'))->row();
				if ($practice) {
					if ($this->db->table_exists('doctor_schedules')) {
						$this->db->where('doctor_id', $userid)->where('clinic_id', $practice->id)->delete('doctor_schedules');
					}
					if ($this->db->table_exists('timing')) {
						$this->db->where('user_id', $userid)->where('practice_id', $practice->id)->delete('timing');
					}
					$this->db->where('id', $practice->id)->delete('dr_practice');
				}

				$this->session->set_flashdata('flashmsg', "<div class='alert alert-info' style='border-radius: 8px;'><strong>Affiliation Cancelled!</strong> Request / link has been removed.</div>");
				redirect('doctorpanel/upcharhospital');
				return;
			}
		}

		// Verified Affiliated Hospitals for this Doctor (only verified status = '1')
		$data['affiliated_hospitals'] = $this->db->select('hospital.*, dr_practice.id as practice_id, dr_practice.fee as practice_fee, dr_practice.status as practice_status')
			->join('hospital', 'hospital.id = dr_practice.institution_id')
			->get_where('dr_practice', array('dr_practice.user_id' => $userid, 'dr_practice.type' => 'H', 'dr_practice.status' => '1'))
			->result();

		$affiliated_ids = array();
		foreach ($data['affiliated_hospitals'] as $ah) {
			$affiliated_ids[] = $ah->id;
		}
		$data['affiliated_ids'] = $affiliated_ids;

		// Calculate Pending Count
		$pending_count = 0;
		foreach ($status_map as $hid => $st) {
			if ($st === 'pending') {
				$pending_count++;
			}
		}
		$data['pending_count'] = $pending_count;

		// Partner Hospitals Directory with Pagination
		$city_filter = $this->input->get('city', TRUE);
		$search_query = $this->input->get('q', TRUE);
		$page = max(1, intval($this->input->get('page')));
		$per_page = 12;
		$offset = ($page - 1) * $per_page;

		// Count Total
		$this->db->where('status', '1');
		if (!empty($city_filter)) {
			$this->db->where('city', $city_filter);
		}
		if (!empty($search_query)) {
			$this->db->group_start();
			$this->db->like('name', $search_query);
			$this->db->or_like('address', $search_query);
			$this->db->group_end();
		}
		$total_rows = $this->db->count_all_results('hospital');

		// Fetch Records for Current Page
		$this->db->where('status', '1');
		if (!empty($city_filter)) {
			$this->db->where('city', $city_filter);
		}
		if (!empty($search_query)) {
			$this->db->group_start();
			$this->db->like('name', $search_query);
			$this->db->or_like('address', $search_query);
			$this->db->group_end();
		}
		$this->db->order_by('name', 'ASC');
		$this->db->limit($per_page, $offset);
		$data['partner_hospitals'] = $this->db->get('hospital')->result();

		$data['cities'] = $this->db->order_by('name', 'ASC')->get_where('master_city', array('status' => '1'))->result();
		$data['selected_city'] = $city_filter;
		$data['search_query'] = $search_query;
		$data['total_hospitals'] = $total_rows;
		$data['current_page'] = $page;
		$data['per_page'] = $per_page;
		$data['total_pages'] = max(1, ceil($total_rows / $per_page));

		$this->load->view('doctorpanel/upcharhospital', $data);
	}

	/**
	 * AJAX Doctor Affiliation Request to Hospital
	 * Creates pending link in doctor_hospital_links and syncs dr_practice (status = 0)
	 */
	public function ajax_affiliate_hospital()
	{
		header('Content-Type: application/json');

		if (!$this->session->userdata('docuserid') && empty($this->did)) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Your doctor session has expired. Please log in again.'
			));
			return;
		}

		$userid = $this->did;
		$hospital_id = intval($this->input->post('hospital_id'));
		$fee = floatval($this->input->post('fee')) ?: 500.00;

		if ($hospital_id <= 0) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Invalid hospital selected.'
			));
			return;
		}

		$hospital = $this->db->get_where('hospital', array('id' => $hospital_id, 'status' => '1'))->row();
		if (!$hospital) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Hospital not found or currently inactive.'
			));
			return;
		}

		// Check existing link in doctor_hospital_links
		$existing_link = null;
		if ($this->db->table_exists('doctor_hospital_links')) {
			$existing_link = $this->db->get_where('doctor_hospital_links', array(
				'doctor_id' => $userid,
				'hospital_id' => $hospital_id
			))->row();
		}

		if ($existing_link && $existing_link->status === 'verified') {
			echo json_encode(array(
				'status' => 'info',
				'link_status' => 'verified',
				'message' => 'You are already affiliated and verified with ' . $hospital->name . '.'
			));
			return;
		}

		if ($existing_link && $existing_link->status === 'pending') {
			$this->db->where('id', $existing_link->id)->update('doctor_hospital_links', array(
				'fee' => $fee,
				'updated_at' => date('Y-m-d H:i:s')
			));
			echo json_encode(array(
				'status' => 'success',
				'link_status' => 'pending',
				'hospital_id' => $hospital_id,
				'hospital_name' => $hospital->name,
				'message' => 'Affiliation request is already pending verification by ' . $hospital->name . '.'
			));
			return;
		}

		// Insert or update doctor_hospital_links with status = 'pending'
		if ($this->db->table_exists('doctor_hospital_links')) {
			if ($existing_link) {
				$this->db->where('id', $existing_link->id)->update('doctor_hospital_links', array(
					'status' => 'pending',
					'fee' => $fee,
					'updated_at' => date('Y-m-d H:i:s')
				));
			} else {
				$this->db->insert('doctor_hospital_links', array(
					'doctor_id' => $userid,
					'hospital_id' => $hospital_id,
					'status' => 'pending',
					'fee' => $fee,
					'created_at' => date('Y-m-d H:i:s')
				));
			}
		}

		// Synchronize legacy dr_practice (status = '0' for pending)
		$chk = $this->db->where(array(
			'user_id' => $userid,
			'institution_id' => $hospital_id,
			'type' => 'H'
		))->get('dr_practice')->row();

		if ($chk) {
			$this->db->where('id', $chk->id)->update('dr_practice', array('status' => '0', 'fee' => $fee));
		} else {
			$this->db->insert('dr_practice', array(
				'user_id'        => $userid,
				'institution_id' => $hospital_id,
				'type'           => 'H',
				'fee'            => $fee,
				'status'         => '0'
			));
		}

		// Add notification for hospital if table exists
		$dr_profile = $this->db->get_where('profile_dr', array('id' => $userid))->row();
		$dr_name = ($dr_profile) ? ('Dr. ' . trim($dr_profile->fname . ' ' . $dr_profile->lname)) : 'A doctor';

		if ($this->db->table_exists('notifications')) {
			$this->db->insert('notifications', array(
				'notify_type' => 'provider',
				'description' => $dr_name . ' has requested affiliation with ' . $hospital->name . '.',
				'status'      => 'active',
				'created_at'  => date('Y-m-d H:i:s')
			));
		}

		// Recount pending & active counts for real-time KPI updates
		$pending_count = 0;
		if ($this->db->table_exists('doctor_hospital_links')) {
			$pending_count = $this->db->where(array('doctor_id' => $userid, 'status' => 'pending'))->count_all_results('doctor_hospital_links');
		} else {
			$pending_count = $this->db->where(array('user_id' => $userid, 'type' => 'H', 'status' => '0'))->count_all_results('dr_practice');
		}
		$active_count = $this->db->where(array('user_id' => $userid, 'type' => 'H', 'status' => '1'))->count_all_results('dr_practice');

		echo json_encode(array(
			'status' => 'success',
			'link_status' => 'pending',
			'hospital_id' => $hospital_id,
			'hospital_name' => $hospital->name,
			'fee' => $fee,
			'pending_count' => $pending_count,
			'active_count' => $active_count,
			'csrf_hash' => $this->security->get_csrf_hash(),
			'message' => 'Affiliation request sent to ' . $hospital->name . '! Status is now Pending Verification.'
		));
	}

	/**
	 * AJAX Cancel Doctor Affiliation Request / Unlink Hospital
	 * Removes doctor_hospital_links and cleans up dr_practice (type = 'H')
	 */
	public function ajax_cancel_affiliation()
	{
		header('Content-Type: application/json');

		if (!$this->session->userdata('docuserid') && empty($this->did)) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Your doctor session has expired. Please log in again.'
			));
			return;
		}

		$userid = $this->did;
		$hospital_id = intval($this->input->post('hospital_id'));

		if ($hospital_id <= 0) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'Invalid hospital selected.'
			));
			return;
		}

		$hospital = $this->db->get_where('hospital', array('id' => $hospital_id))->row();
		$hosp_name = $hospital ? $hospital->name : 'Hospital';

		// 1. Remove from doctor_hospital_links
		if ($this->db->table_exists('doctor_hospital_links')) {
			$this->db->where(array('doctor_id' => $userid, 'hospital_id' => $hospital_id))->delete('doctor_hospital_links');
		}

		// 2. Remove associated dr_practice entry and any linked timings/schedules
		$practice = $this->db->get_where('dr_practice', array('user_id' => $userid, 'institution_id' => $hospital_id, 'type' => 'H'))->row();
		if ($practice) {
			$practice_id = $practice->id;

			// Clean up schedules if table exists
			if ($this->db->table_exists('doctor_schedules')) {
				$this->db->where('doctor_id', $userid)->where('clinic_id', $practice_id)->delete('doctor_schedules');
			}
			// Clean up timing table if exists
			if ($this->db->table_exists('timing')) {
				$this->db->where('user_id', $userid)->where('practice_id', $practice_id)->delete('timing');
			}

			// Delete dr_practice entry
			$this->db->where('id', $practice_id)->delete('dr_practice');
		}

		// 3. Add notification for hospital if table exists
		if ($this->db->table_exists('notifications')) {
			$dr_profile = $this->db->get_where('profile_dr', array('id' => $userid))->row();
			$dr_name = ($dr_profile) ? ('Dr. ' . trim($dr_profile->fname . ' ' . $dr_profile->lname)) : 'A doctor';

			$this->db->insert('notifications', array(
				'notify_type' => 'provider',
				'description' => $dr_name . ' has cancelled affiliation request / unlinked from ' . $hosp_name . '.',
				'status'      => 'active',
				'created_at'  => date('Y-m-d H:i:s')
			));
		}

		// Recount pending & active counts for real-time KPI updates
		$pending_count = 0;
		if ($this->db->table_exists('doctor_hospital_links')) {
			$pending_count = $this->db->where(array('doctor_id' => $userid, 'status' => 'pending'))->count_all_results('doctor_hospital_links');
		} else {
			$pending_count = $this->db->where(array('user_id' => $userid, 'type' => 'H', 'status' => '0'))->count_all_results('dr_practice');
		}
		$active_count = $this->db->where(array('user_id' => $userid, 'type' => 'H', 'status' => '1'))->count_all_results('dr_practice');

		echo json_encode(array(
			'status' => 'success',
			'action' => 'cancelled',
			'hospital_id' => $hospital_id,
			'hospital_name' => $hosp_name,
			'pending_count' => $pending_count,
			'active_count' => $active_count,
			'csrf_hash' => $this->security->get_csrf_hash(),
			'message' => 'Affiliation request for ' . $hosp_name . ' has been cancelled successfully.'
		));
	}

	/**
	 * Non-AJAX Fallback to Cancel Affiliation / Unlink Hospital
	 */
	public function cancel_affiliation($hospital_id = 0)
	{
		$userid = $this->did;
		$hospital_id = intval($hospital_id ?: $this->input->post('hospital_id'));

		if ($hospital_id > 0) {
			if ($this->db->table_exists('doctor_hospital_links')) {
				$this->db->where(array('doctor_id' => $userid, 'hospital_id' => $hospital_id))->delete('doctor_hospital_links');
			}
			$practice = $this->db->get_where('dr_practice', array('user_id' => $userid, 'institution_id' => $hospital_id, 'type' => 'H'))->row();
			if ($practice) {
				if ($this->db->table_exists('doctor_schedules')) {
					$this->db->where('doctor_id', $userid)->where('clinic_id', $practice->id)->delete('doctor_schedules');
				}
				if ($this->db->table_exists('timing')) {
					$this->db->where('user_id', $userid)->where('practice_id', $practice->id)->delete('timing');
				}
				$this->db->where('id', $practice->id)->delete('dr_practice');
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-info' style='border-radius: 8px;'><strong>Affiliation Cancelled!</strong> Request / link has been removed.</div>");
		}
		redirect('doctorpanel/upcharhospital');
	}

	/**
	 * AJAX Get Hospital Profile Details (Contact, Address, Facilities)
	 */
	public function ajax_get_hospital_profile()
	{
		header('Content-Type: application/json');

		$hospital_id = intval($this->input->get_post('hospital_id'));
		if ($hospital_id <= 0) {
			echo json_encode(array('status' => 'error', 'message' => 'Hospital ID missing or invalid.'));
			return;
		}

		$hosp = $this->db->get_where('hospital', array('id' => $hospital_id))->row();
		if (!$hosp) {
			echo json_encode(array('status' => 'error', 'message' => 'Hospital not found.'));
			return;
		}

		// Fetch City Name
		$city_name = '';
		if (!empty($hosp->city)) {
			$crow = $this->db->get_where('master_city', array('id' => $hosp->city))->row();
			if ($crow) $city_name = $crow->name;
		}

		// Fetch Services / Facilities
		$facilities = array();
		if ($this->db->table_exists('instition_services') && $this->db->table_exists('master_services')) {
			$servs = $this->db->select('master_services.name')
				->join('master_services', 'master_services.id = instition_services.services_id')
				->get_where('instition_services', array('institution_id' => $hospital_id, 'institution_type' => 'H'))
				->result();
			foreach ($servs as $s) {
				$facilities[] = $s->name;
			}
		}

		if (empty($facilities) && !empty($hosp->tag)) {
			$tags = array_map('trim', explode(',', $hosp->tag));
			foreach ($tags as $t) {
				if (!empty($t)) $facilities[] = $t;
			}
		}

		// Check current doctor's affiliation status with this hospital
		$current_status = 'none';
		if ($this->db->table_exists('doctor_hospital_links')) {
			$link = $this->db->get_where('doctor_hospital_links', array(
				'doctor_id' => $this->did,
				'hospital_id' => $hospital_id
			))->row();
			if ($link) {
				$current_status = $link->status;
			}
		}
		if ($current_status === 'none') {
			$pract = $this->db->get_where('dr_practice', array(
				'user_id' => $this->did,
				'institution_id' => $hospital_id,
				'type' => 'H'
			))->row();
			if ($pract) {
				$current_status = ($pract->status == '1') ? 'verified' : 'pending';
			}
		}

		$image_url = '';
		if (!empty($hosp->drimage)) {
			$image_url = base_url('uploads/hospital/' . $hosp->drimage);
		}

		echo json_encode(array(
			'status' => 'success',
			'data' => array(
				'id' => $hosp->id,
				'name' => $hosp->name,
				'email' => $hosp->email ?: 'Not publicly listed',
				'mobile' => $hosp->mobile ?: 'Not available',
				'address' => $hosp->address ?: 'Address on file',
				'city' => $city_name,
				'state' => $hosp->state ?: '',
				'pincode' => $hosp->pincode ?: '',
				'website' => $hosp->website ?: '',
				'about' => $hosp->about ?: 'Leading healthcare and medical center dedicated to patient wellness and specialized clinical care.',
				'image' => $image_url,
				'facilities' => $facilities,
				'affiliation_status' => $current_status
			)
		));
	}

	public function managenews()
	{
		$userid = $this->did;
		$data['news'] = $this->db->order_by('id', 'DESC')->get_where('news', array('doctor_id' => $userid))->result_array();
		if (empty($data['news'])) {
			// Show general news if none authored yet
			$data['all_news'] = $this->db->order_by('id', 'DESC')->limit(10)->get('news')->result_array();
		}
		$this->load->view('doctorpanel/managenews', $data);
	}

	public function news()
	{
		$userid = $this->did;

		if ($this->input->post('submit')) {
			$title = trim($this->input->post('name', TRUE) ?: $this->input->post('title', TRUE));
			$description = trim($this->input->post('description', TRUE));
			$type = $this->input->post('type') ?: '1';
			$video_url = trim($this->input->post('video_url', TRUE));
			$uploadimage = '';

			if (!empty($video_url)) {
				// Convert standard youtube watch url to embed url if needed
				if (strpos($video_url, 'watch?v=') !== false) {
					$video_url = str_replace('watch?v=', 'embed/', $video_url);
				}
			}

			if ($type == '1' && !empty($_FILES['uploadimage']['name'])) {
				$extsign = pathinfo($_FILES['uploadimage']['name'], PATHINFO_EXTENSION);
				$rname = rand(1111111, 999999999);
				$uploadimage = 'doc_news_' . $rname . '_' . date('Y-m-d') . '.' . $extsign;

				$upload_path = './admin1947/public/assets/upload/';
				if (!is_dir($upload_path)) {
					@mkdir($upload_path, 0777, true);
				}

				$config['upload_path']   = $upload_path;
				$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG|webp|WEBP';
				$config['max_size']      = 5120;
				$config['file_name']     = $uploadimage;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('uploadimage')) {
					$error = $this->upload->display_errors('', '');
					$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger"><strong>Upload Error:</strong> ' . $error . '</div>');
					redirect('doctorpanel/news');
					return;
				}
			}

			$data_insert = array(
				'title'       => $title,
				'description' => $description,
				'type'        => $type,
				'image'       => $uploadimage,
				'video_url'   => $video_url,
				'doctor_id'   => $userid,
				'approved'    => '1',
				'status'      => '1',
				'creat_date'  => date('Y-m-d H:i:s')
			);

			$this->db->insert('news', $data_insert);
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> Medical article / news published successfully.</div>");
			redirect('doctorpanel/managenews');
			return;
		}

		$this->load->view('doctorpanel/news');
	}

	public function delete_news($id = null)
	{
		$userid = $this->did;
		$id = intval($id ?: $this->input->get('id'));
		if ($id) {
			$this->db->where('id', $id)->where('doctor_id', $userid)->delete('news');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Article removed successfully.</div>");
		}
		redirect('doctorpanel/managenews');
	}

	public function earnings()
	{
		$doctor_id = $this->did;

		if ($this->input->post('save_bank_details')) {
			$bdata = array(
				'bank_name'      => trim($this->input->post('bank_name', TRUE)),
				'account_no'     => trim($this->input->post('account_no', TRUE)),
				'ifsc'           => strtoupper(trim($this->input->post('ifsc', TRUE))),
				'account_holder' => trim($this->input->post('account_holder', TRUE)),
				'upi_id'         => trim($this->input->post('upi_id', TRUE))
			);
			$this->db->where('id', $doctor_id)->update('profile_dr', $bdata);

			// Sync to facility_payout_accounts
			$this->load->model('Payout_model');
			$this->Payout_model->save_facility_payout_account('doctor', $doctor_id, array(
				'account_type'   => 'BANK_ACCOUNT',
				'account_name'   => $bdata['account_holder'],
				'bank_name'      => $bdata['bank_name'],
				'account_number' => $bdata['account_no'],
				'ifsc_code'      => $bdata['ifsc'],
				'vpa'            => $bdata['upi_id'],
				'is_verified'    => 1
			));

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> Bank account and payout settlement details updated successfully.</div>");
			redirect('doctorpanel/earnings?tab=payment');
			return;
		}

		$data['earnings'] = $this->Financial_Model->get_doctor_earnings($doctor_id);
		$data['ledger'] = $this->Financial_Model->get_ledger_history('DOCTOR', $doctor_id, 50);
		$data['doctor'] = $this->db->get_where('profile_dr', array('id' => $doctor_id))->row();
		$data['active_tab'] = $this->input->get('tab', TRUE) ?: 'overview';
		$this->load->view('doctorpanel/earnings', $data);
	}

	public function complete_appointment()
	{
		$aid = intval($this->input->get_post('aid'));
		$appointment = $this->db->get_where('appointment', array('appointment_id' => $aid, 'doctor_id' => $this->did))->row();
		
		if ($appointment) {
			$this->db->where('appointment_id', $aid)->update('appointment', array('status' => '2')); // 2 = Completed
			
			// Find associated sm_order and release escrow
			$order = $this->db->where(array('ITEM_TYPE' => 'A', 'ITEM_ID' => $aid))->get('sm_order')->row();
			if ($order) {
				$this->Financial_Model->release_escrow($order->ORDER_ID);
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Appointment marked completed and consultation fee queued for payout!</div>");
		}
		redirect('doctorpanel/manageappointment');
	}

	public function prescription()
	{
		$aid = intval($this->uri->segment(3) ?: $this->input->get_post('aid'));
		$appointment = $this->db->get_where('appointment', array('appointment_id' => $aid, 'doctor_id' => $this->did))->row();
		
		if (!$appointment) {
			redirect('doctorpanel/manageappointment');
			return;
		}

		if ($this->input->post('submit_prescription')) {
			$symptoms    = trim($this->input->post('symptoms', TRUE));
			$vitals      = trim($this->input->post('vitals', TRUE));
			$diagnosis   = trim($this->input->post('diagnosis', TRUE));
			$plan        = trim($this->input->post('treatment_plan', TRUE));
			$followup    = trim($this->input->post('followup_date', TRUE));
			$meds_raw    = $this->input->post('medications'); // array
			$tests_raw   = $this->input->post('lab_tests'); // array

			$medications_json = is_array($meds_raw) ? json_encode(array_values(array_filter($meds_raw))) : json_encode(array());
			$tests_json = is_array($tests_raw) ? json_encode(array_values(array_filter($tests_raw))) : json_encode(array());

			$rx_data = array(
				'appointment_id'        => $aid,
				'patient_id'            => $appointment->user_id,
				'doctor_id'             => $this->did,
				'hospital_id'           => ($appointment->institution_type == 'H') ? $appointment->institute_id : null,
				'symptoms_subjective'   => $symptoms,
				'examination_objective' => $vitals,
				'diagnosis_assessment'  => $diagnosis ?: 'General Clinical Evaluation',
				'treatment_plan'        => $plan ?: 'Standard care plan',
				'medications_json'      => $medications_json,
				'lab_tests_recommended' => $tests_json,
				'followup_date'         => !empty($followup) ? $followup : null,
				'created_at'            => date('Y-m-d H:i:s')
			);

			$this->db->insert('prescriptions', $rx_data);
			
			// Mark appointment as completed
			$this->db->where('appointment_id', $aid)->update('appointment', array('status' => '2'));
			
			// Release escrow in financial ledger
			$order = $this->db->where(array('ITEM_TYPE' => 'A', 'ITEM_ID' => $aid))->get('sm_order')->row();
			if ($order) {
				$this->Financial_Model->release_escrow($order->ORDER_ID);
			}

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Digital E-Prescription issued successfully!</div>");
			redirect('doctorpanel/manageappointment');
			return;
		}

		$data['appointment'] = $appointment;
		$data['patient'] = $this->db->get_where('userlogin', array('userid' => $appointment->user_id))->row();
		$data['existing_rx'] = $this->db->get_where('prescriptions', array('appointment_id' => $aid))->row();
		$this->load->view('doctorpanel/prescription', $data);
	}

	/**
	 * AJAX Endpoint: Toggle / Update Video Consultation Availability
	 */
	public function update_video_consult_status()
	{
		header('Content-Type: application/json');

		$druserid = $this->session->userdata('druserid');
		if (!$druserid) {
			echo json_encode(array('status' => 'error', 'message' => 'Unauthorized. Please login again.'));
			return;
		}

		$status = $this->input->post('is_video_consult_enabled');
		$status_val = ($status === '1' || $status == 1 || $status === 'true' || $status === true) ? 1 : 0;

		$doctor_id = $this->did ?: $druserid;
		$updated = $this->Doctor_Model->update_video_consult_status($doctor_id, $status_val);

		if ($updated) {
			$msg = ($status_val == 1)
				? 'Video consultation is now ACTIVE. Patients can discover and book online video calls with you.'
				: 'Video consultation has been PAUSED. You are temporarily hidden from the teleconsultation directory.';
			echo json_encode(array(
				'status' => 'success',
				'is_video_consult_enabled' => $status_val,
				'message' => $msg
			));
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'Failed to update video consultation status in database.'));
		}
	}

}
