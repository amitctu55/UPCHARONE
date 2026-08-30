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
			 if (!in_array($page, $excep_array))
				redirect('doctor-login');
		 }else{
			 $druserid = $this->session->userdata('druserid');
			 $row = $this->db->where('user_id', $druserid)->or_where('id', $druserid)->get('profile_dr')->row();
			 $this->did = ($row && isset($row->id)) ? $row->id : null;

			 // Verification Check
			 $is_verified = true;
			 $docLog = $this->db->where('USERID', $druserid)->get('doctorlogin')->row();
			 if ($docLog && $docLog->APPROVED == '0') {
				 $is_verified = false;
			 }
			 if ($row) {
				 if ((isset($row->verification_status) && $row->verification_status !== 'verified') ||
					 (isset($row->approved) && $row->approved == '0') ||
					 (isset($row->status) && $row->status == '0') ||
					 (isset($row->is_active) && (int)$row->is_active === 0)) {
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
		$this->load->view('home',$data);
	}
	
	public function dashboard()
	{
		$druserid = $this->session->userdata('druserid');
		$data['doctor'] = $this->db->where('id', $this->did)->or_where('user_id', $druserid)->get('profile_dr')->row();
		$userid = $data['doctor'] ? $data['doctor']->id : ($this->did ?: $druserid);

		// Appointments stats
		$data['todayappointment'] = $this->db->where(array('doctor_id' => $userid, 'appointment_date' => date('Y-m-d'), 'status' => '1'))->count_all_results('appointment');
		$data['totalappointment'] = $this->db->where(array('doctor_id' => $userid, 'status' => '1'))->count_all_results('appointment');
		$data['completed_appointments'] = $this->db->where(array('doctor_id' => $userid, 'status' => '2'))->count_all_results('appointment');

		// Financials
		$data['earnings'] = $this->Financial_Model->get_doctor_earnings($userid);

		// Associated practices & hospitals
		$data['total_clinics'] = $this->db->where(array('user_id' => $userid, 'type' => 'C'))->count_all_results('dr_practice');
		$data['total_hospitals'] = $this->db->where(array('user_id' => $userid, 'type' => 'H'))->count_all_results('dr_practice');

		// Recent appointments
		$data['recent_appointments'] = $this->db->select('appointment.*, userlogin.FNAME as user_fname, userlogin.LNAME as user_lname, userlogin.MOBILE as user_mobile')
			->from('appointment')
			->join('userlogin', 'userlogin.USERID = appointment.user_id', 'left')
			->where('appointment.doctor_id', $userid)
			->order_by('appointment.appointment_date', 'DESC')
			->order_by('appointment.appointment_id', 'DESC')
			->limit(10)
			->get()
			->result();

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

    if(isset($_POST['submit']))
			$uploadimage='';
		//	$id=base64_decode($this->input->post('id'));
        $uploadimage=$_FILES['uploadimage']['name'];
		$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
       

					if($uploadimage != '') 
				{	
					$rname=rand(1111111,999999999);
					$date=date('Y-m-d');
					$uploadimage=$typename.'_profile_pic_'.$rname.$date.'.'.$extsign;
					
					$config['upload_path']          = './admin1947/public/assets/upload/';
					$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
					$config['max_size']             = 2048;
					$config['quality'] = '60%';
					$config['file_name']  = $uploadimage;
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('uploadimage'))
					{
						$error = $this->upload->display_errors();
						$flashmsg='<div class="alert alert-danger">
						  <strong>Failed!</strong>'.$error.'
						</div>';
						$this->session->set_flashdata('flashmsg',$flashmsg);
						redirect(base_url().'doctorpanel/gallery');
						exit();
					}


					if($this->Doctor_Model->gallery($uploadimage)) 
						{
							$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
							$this->session->set_flashdata('flashmsg',$msg);
							
						
						}
						else{
							$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
							$this->session->set_flashdata('flashmsg',$msg);
						}
						
						}
					
                    
	       $this->load->view('doctorpanel/gallery');
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

		// Handle Form Submission (Add or Update Timing)
		if ($this->input->post('submit')) {
			$practice_id = intval($this->input->post('practice_id'));
			$days = (array)$this->input->post('days');
			$timing_id = intval($this->input->post('timing_id'));

			$timing_data = array(
				'user_type'   => 'D',
				'user_id'     => $userid,
				'practice_id' => $practice_id,
				'M'           => in_array('M', $days) ? 1 : 0,
				'T'           => in_array('T', $days) ? 1 : 0,
				'W'           => in_array('W', $days) ? 1 : 0,
				'TH'          => in_array('TH', $days) ? 1 : 0,
				'F'           => in_array('F', $days) ? 1 : 0,
				'SA'          => in_array('SA', $days) ? 1 : 0,
				'S'           => in_array('S', $days) ? 1 : 0,
				'status'      => '1'
			);

			if ($timing_id > 0) {
				$this->db->where('id', $timing_id)->where('user_id', $userid)->update('timing', $timing_data);
				$current_timing_id = $timing_id;
				$this->db->where('timing_id', $current_timing_id)->delete('timing_session');
			} else {
				$this->db->insert('timing', $timing_data);
				$current_timing_id = $this->db->insert_id();
			}

			// Morning Session
			$morning_from = $this->input->post('morning_from', TRUE);
			$morning_to = $this->input->post('morning_to', TRUE);
			$morning_max = intval($this->input->post('morning_max')) ?: 10;
			if (!empty($morning_from) && !empty($morning_to)) {
				$this->db->insert('timing_session', array(
					'timing_id'   => $current_timing_id,
					'from_timing' => $morning_from,
					'to_timing'   => $morning_to,
					'max_patient' => $morning_max,
					'status'      => 1
				));
			}

			// Evening Session
			$evening_from = $this->input->post('evening_from', TRUE);
			$evening_to = $this->input->post('evening_to', TRUE);
			$evening_max = intval($this->input->post('evening_max')) ?: 10;
			if (!empty($evening_from) && !empty($evening_to)) {
				$this->db->insert('timing_session', array(
					'timing_id'   => $current_timing_id,
					'from_timing' => $evening_from,
					'to_timing'   => $evening_to,
					'max_patient' => $evening_max,
					'status'      => 1
				));
			}

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> Schedule timings and slot availability saved successfully.</div>");
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
			if ($t->practice_id > 0) {
				$pr = $this->db->get_where('dr_practice', array('id' => $t->practice_id))->row();
				if ($pr) {
					$table = ($pr->type == 'H') ? 'hospital' : 'clinic';
					$inst = $this->db->get_where($table, array('id' => $pr->institution_id))->row();
					if ($inst) {
						$inst_name = $inst->name;
						$inst_address = $inst->address;
					}
				}
			}
			$schedules[] = array(
				'timing'       => $t,
				'sessions'     => $sessions,
				'inst_name'    => $inst_name,
				'inst_address' => $inst_address
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
			$this->db->where('id', $id)->where('user_id', $userid)->delete('timing');
			$this->db->where('timing_id', $id)->delete('timing_session');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Schedule timing removed successfully.</div>");
		}
		redirect('doctorpanel/datetime');
	}

	public function upcharhospital()
	{
		$userid = $this->did;

		// Handle Affiliation Action
		if ($this->input->post('affiliate_hospital')) {
			$hospital_id = intval($this->input->post('hospital_id'));
			$fee = intval($this->input->post('fee')) ?: 500;
			
			if ($hospital_id > 0) {
				$chk = $this->db->where(array('user_id' => $userid, 'institution_id' => $hospital_id, 'type' => 'H'))->get('dr_practice')->row();
				if ($chk) {
					$this->db->where('id', $chk->id)->update('dr_practice', array('status' => '1', 'fee' => $fee));
				} else {
					$this->db->insert('dr_practice', array(
						'user_id'        => $userid,
						'institution_id' => $hospital_id,
						'type'           => 'H',
						'fee'            => $fee,
						'status'         => '1'
					));
				}
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> Affiliated hospital linked to your visiting practice profile.</div>");
				redirect('doctorpanel/upcharhospital');
				return;
			}
		}

		// Doctor's Currently Affiliated Hospitals
		$data['affiliated_hospitals'] = $this->db->select('hospital.*, dr_practice.id as practice_id, dr_practice.fee as practice_fee, dr_practice.status as practice_status')
			->join('hospital', 'hospital.id = dr_practice.institution_id')
			->get_where('dr_practice', array('dr_practice.user_id' => $userid, 'dr_practice.type' => 'H'))
			->result();

		$affiliated_ids = array();
		foreach ($data['affiliated_hospitals'] as $ah) {
			$affiliated_ids[] = $ah->id;
		}
		$data['affiliated_ids'] = $affiliated_ids;

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
}
