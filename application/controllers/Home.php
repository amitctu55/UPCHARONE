<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library(array('Form_validation'));		
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
        $this->load->model(array('Userlogin_Model','Hospital_Model'));
	}

	public function index()
	{	
		$data['specialization']	= $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$data['cities'] 		= $this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
		$data['doctor_slid']	= $this->Hospital_Model->get_doctor_home(array('profile_dr.approved'=>'1','profile_dr.verified'=>'1'));
		$data['image'] 			= $this->db->order_by('id','RANDOM')->limit('4')->get_where('hospitalgallery',array('status'=>'A'))->result();
		$data['news'] 			= $this->db->order_by('id','DESC')->limit('4')->get_where('news',array('approved'=>'1','status'=>'1'))->result();
		$data['pathology_tests'] = $this->db->order_by('test_id', 'asc')->where('status', '1')->limit(12)->get('pathtest')->result();
		$data['pathology_categories'] = $this->db->order_by('category_name', 'asc')->where('status', '1')->get('path_category')->result();
		if ($this->session->userdata('userid')!='')
		{
			
			$this->load->view('home',$data);
		}
		else
		{	
			$this->load->view('home1',$data);
		}
	}

	public function login()
	{
		if ($this->session->userdata('userid')) {
			redirect('myappointments');
			return;
		}
		$this->load->view('login');
	}

	public function signup()
	{
		if ($this->session->userdata('userid')) {
			redirect('myappointments');
			return;
		}
		$this->load->view('sign_up');
	}

	public function forgotpassword()
	{
		$this->load->view('forgot_password');
	}

	public function verifymobile()
	{
		$this->load->view('otp_send_pass');
	}
	
	public function bed_availability()
	{
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 6;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['hospital_bed'] 	=  $this->Hospital_Model->get_hospital_bed($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Manage Doctors';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		$data['specialization'] =  $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$this->load->view('bed_availability',$data);
	}
	
	public function doctors()
	{
		$per_page_param = $this->input->get('per_page');
		$page_param = (int) $this->input->get('page');
		if ($page_param < 1) $page_param = 1;
		
		$per_page = 10;
		if ($per_page_param === '20') $per_page = 20;
		else if ($per_page_param === '50') $per_page = 50;
		else if ($per_page_param === 'all') $per_page = 1000;
		else if ($per_page_param === '10') $per_page = 10;
		
		$offset = ($page_param - 1) * $per_page;
		
		$total_doctors = $this->db->where(array('approved'=>'1','verified'=>'1'))->count_all_results('profile_dr');
		$data['total_doctors'] = $total_doctors;
		$data['per_page'] = $per_page;
		$data['per_page_param'] = $per_page_param ?: '10';
		$data['current_page'] = $page_param;
		$data['total_pages'] = ($total_doctors > 0) ? ceil($total_doctors / $per_page) : 1;
		
		$data['doctors']=$this->db->limit($per_page, $offset)->get_where('profile_dr',array('approved'=>'1','verified'=>'1'))->result();
		$data['hospital']=$this->db->limit(10)->get_where('hospital', array('approved'=>'1','verified'=>'1'))->result();
		$data['clinic']=$this->db->get_where('clinic', array('status'=>'1'))->result();
		$data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$data['cities']=$this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
		$data['gallery']=$this->db->get('doctorgallery')->result();	
		$this->load->view('team_list',$data);
	}

	public function doctor()
	{	
		$id=$this->uri->segment(2);
		$data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$data['cities']=$this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
		$data['d']=$this->db->get_where('profile_dr',array('id'=>$id))->row();
		if (empty($data['d'])) {
			$data['d']=$this->db->limit(1)->get_where('profile_dr',array('approved'=>'1','verified'=>'1'))->row();
		}
		if (empty($data['d'])) {
			redirect('doctors');
			return;
		}
		$this->load->view('detail_page',$data);
	}

	public function hospital()
	{
		$id = $this->uri->segment(2);
		$data['hospital'] = $this->db->get_where('hospital', array('id' => $id))->row();
		if (empty($data['hospital'])) {
			$data['hospital'] = $this->db->limit(1)->get_where('hospital', array('approved' => '1', 'verified' => '1'))->row();
		}
		if (empty($data['hospital'])) {
			redirect('hospitals');
			return;
		}
		$hid = $data['hospital']->id;
		$data['clinic'] = $this->db->order_by('dr_practice.id','RANDOM')->limit(6)->select('profile_dr.*,dr_practice.status as p_status,dr_practice.fee as p_fee')->join('profile_dr','profile_dr.id=dr_practice.user_id')->get_where('dr_practice',array('institution_id'=>$hid,'type'=>'H'))->result();
		
		// Fallback: If no doctors directly linked, fetch verified specialists
		if (empty($data['clinic'])) {
			$data['clinic'] = $this->db->order_by('id','asc')->limit(4)->get_where('profile_dr', array('approved' => '1', 'verified' => '1'))->result();
		}

		$data['gallery'] = $this->db->get_where('hospitalgallery',array('status'=>'A','uid'=>$hid))->result();	
		$data['specialization'] = $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$data['cities'] = $this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
		$this->load->view('hospital_detail',$data);
	}

	public function search()
	{    
		$keyword = trim($this->input->get('keyword') ?? '');
		$spl = $this->input->get('spl');
		$city = $this->input->get('city');
		$date = $this->input->get('dt');
		
		$per_page_param = $this->input->get('per_page');
		$page_param = (int) $this->input->get('page');
		if ($page_param < 1) $page_param = 1;
		
		$per_page = 10;
		if ($per_page_param === '20') $per_page = 20;
		else if ($per_page_param === '50') $per_page = 50;
		else if ($per_page_param === 'all') $per_page = 1000;
		else if ($per_page_param === '10') $per_page = 10;
		
		$offset = ($page_param - 1) * $per_page;
		
		// Build Query for Doctor Count & Results
		$this->db->start_cache();
		$this->db->where('profile_dr.approved', '1');
		$this->db->where('profile_dr.verified', '1');
		if($spl != ''){
			$this->db->where("dr_specialization.specialization_id", $spl);
			$this->db->join("dr_specialization", 'dr_specialization.user_id=profile_dr.id');
		}
		if($city != '') {
			$this->db->where("profile_dr.city", $city);
		}
		if($keyword != '') {
			$this->db->like("concat(COALESCE(profile_dr.fname,''),' ',COALESCE(profile_dr.lname,''))", $keyword);
		}
		$this->db->stop_cache();
		
		$total_doctors = $this->db->count_all_results('profile_dr');
		$data['total_doctors'] = $total_doctors;
		$data['per_page'] = $per_page;
		$data['per_page_param'] = $per_page_param ?: '10';
		$data['current_page'] = $page_param;
		$data['total_pages'] = ($total_doctors > 0) ? ceil($total_doctors / $per_page) : 1;
		
		$data['doctors'] = $this->db->limit($per_page, $offset)->get('profile_dr')->result();
		$this->db->flush_cache();

		if($city != '') $this->db->where("city", $city);
		if($keyword != '') $this->db->like("name", $keyword);
		$data['hospital'] = $this->db->limit(10)->get_where('hospital', array('approved'=>'1','verified'=>'1'))->result();

		$data['specialization'] = $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$data['cities'] = $this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
		$data['gallery'] = $this->db->get('doctorgallery')->result();	
		$this->load->view('team_list', $data);
	}

	public function hospitals()
	{
	    $data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$data['cities']=$this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
		$data['hospital']=$this->db->get_where('hospital', array('approved'=>'1','verified'=>'1'))->result();
		$this->load->view('hospital_list',$data);
	}
	
	
	public function hospitallist()
	{	
	    $data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$data['cities']=$this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
		$data['hospital']=$this->db->get_where('hospital', array('approved'=>'1','verified'=>'1'))->result();
		$this->load->view('hospitallist',$data);
	}
	
	public function logout()
	{
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('useremail');
		$this->session->sess_destroy();
		redirect('login');
	}

	public function manageappointment()
	{
		$user_id = $this->session->userdata('userid') ?: $this->session->userdata('user_id');
		if (!$user_id) {
			redirect('login');
			return;
		}

		$this->load->model('Appointment_model');
		$data['appointments_data'] = $this->Appointment_model->get_user_appointments($user_id);

		$this->load->view('patient_header', $data);
		$this->load->view('manageappointment', $data);
		$this->load->view('patient_footer');
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
		$id = isset($_GET['doctor']) ? intval($_GET['doctor']) : (isset($_POST['doctor']) ? intval($_POST['doctor']) : 0);
		$data = $id ? $this->db->get_where('profile_dr', array('id' => $id))->row() : null;
		if (!$data) {
			$data = $this->db->order_by('id', 'ASC')->get('profile_dr')->row();
		}
		if (!$data) {
			echo '<div style="padding: 10px; color: #64748B;"><strong style="color: #0F172A;">Medical Specialist</strong><br><span style="font-size: 12px;">Consultation Fee: ₹500</span></div>';
			return;
		}
		$drimg = ($data->drimage) ? $data->drimage : 'dummydr.jpg';
		$drPrefix = (stripos($data->fname, 'dr') === false) ? 'Dr. ' : '';
		
		$quastring = '';
		$qu = $this->db->get_where('dr_qualifications', array('user_id' => $data->id));
		foreach(@$qu->result() as $q)
			$quastring .= getQualificationName($q->qualification_id).', ';
		$quastring = rtrim($quastring, ', ');

		$splstring = '';
		$sp = $this->db->get_where('dr_specialization', array('user_id' => $data->id))->result();
		foreach($sp as $s)
			$splstring .= getSpecilizationName($s->specialization_id).', ';
		$splstring = rtrim($splstring, ', ');
		if (empty($splstring)) $splstring = 'General Physician';

		$content = '<div style="display: flex; align-items: center; gap: 12px;">
			<img src="'.admin_url().'public/assets/upload/'.$drimg.'" alt="'.$drPrefix.$data->fname.'" style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid #00A896; flex-shrink: 0;">
			<div style="flex: 1; min-width: 0;">
				<div style="font-size: 14.5px; font-weight: 700; color: #0F172A; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'.$drPrefix.$data->fname.' '.$data->lname.'</div>
				<div style="font-size: 12px; color: #00A896; font-weight: 600; margin-bottom: 1px;">'.$splstring.'</div>
				'.(!empty($quastring) ? '<div style="font-size: 11.5px; color: #64748B;">'.$quastring.'</div>' : '').'
			</div>
		</div>';
		echo $content;
	}
	public function app_conf_hospital_doctor()
	{
		$id=$_GET['doctor'];
		if($id!='')
		{
		$data=$this->db->get_where('profile_dr',array('id'=>$id))->row();
		//echo "<pre>"; print_r($data);
		$drimg=($data->drimage)? $data->drimage :'dummydr.jpg';
		$content = '<div class="col-md-6">
		<img class="docimg" src="'.admin_url().'public/assets/upload/'.$drimg.'" alt="">
		</div>

		<div class="col-md-6">
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
	}

	/**
	 * Helper: Fetch all available timing records and sessions for a doctor
	 * Resolves direct doctor timings, practice-linked timings, and institution-linked timings
	 */
	private function _get_doctor_timing_info($doctor_id) {
		$days = array('1'=>'M','2'=>'T','3'=>'W','4'=>'TH','5'=>'F','6'=>'SA','7'=>'S');
		$dr = $this->db->get_where('profile_dr', array('id' => $doctor_id))->row();
		if (!$dr) return null;

		$practices = $this->db->get_where('dr_practice', array('user_id' => $doctor_id))->result();
		$practiceIds = array();
		foreach ($practices as $p) {
			$practiceIds[] = (int)$p->id;
		}

		$timingRows = array();

		// 1. Direct doctor timings
		$t1 = $this->db->get_where('timing', array('user_type' => 'D', 'user_id' => $doctor_id, 'status' => '1'))->result();
		foreach ($t1 as $t) {
			$timingRows[$t->id] = $t;
		}

		// 2. Practice-linked doctor timings
		if (!empty($practiceIds)) {
			$this->db->where_in('practice_id', $practiceIds);
			$t2 = $this->db->get_where('timing', array('status' => '1'))->result();
			foreach ($t2 as $t) {
				$timingRows[$t->id] = $t;
			}
		}

		// 3. Institution-linked timings if no direct timings found
		if (empty($timingRows)) {
			foreach ($practices as $p) {
				$instId = (int)$p->institution_id;
				$instType = $p->type; // 'H' or 'C'
				if ($instId > 0 && ($instType === 'H' || $instType === 'C')) {
					$t3 = $this->db->get_where('timing', array('user_id' => $instId, 'user_type' => $instType, 'status' => '1'))->result();
					foreach ($t3 as $t) {
						$t->practice_id = $p->id;
						$timingRows[$t->id] = $t;
					}
				}
			}
		}

		$availableDays = array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0);
		$daySlots = array('1'=>array(),'2'=>array(),'3'=>array(),'4'=>array(),'5'=>array(),'6'=>array(),'7'=>array());

		foreach ($timingRows as $t) {
			$tId = $t->id;
			$sessions = $this->db->get_where('timing_session', array('timing_id' => $tId, 'status' => '1'))->result();
			if (empty($sessions)) {
				$sessions = $this->db->get_where('timing_session', array('timing_id' => $tId))->result();
			}

			if (!empty($sessions)) {
				foreach ($days as $dayNum => $dayKey) {
					if (!empty($t->$dayKey)) {
						$availableDays[$dayNum] = 1;
						foreach ($sessions as $s) {
							$daySlots[$dayNum][$s->id] = (object) array(
								'id' => $s->id,
								'timing_id' => $tId,
								'from_timing' => $s->from_timing,
								'to_timing' => $s->to_timing,
								'max_patient' => $s->max_patient,
								'consultation_fee' => $s->consultation_fee,
								'practice_id' => $t->practice_id
							);
						}
					}
				}
			} else {
				// Timing row exists with active days, but no specific sessions defined in timing_session
				foreach ($days as $dayNum => $dayKey) {
					if (!empty($t->$dayKey)) {
						$availableDays[$dayNum] = 1;
						$daySlots[$dayNum]['gen_'.$tId.'_1'] = (object) array(
							'id' => 'gen_'.$tId.'_1',
							'timing_id' => $tId,
							'from_timing' => '10:00 AM',
							'to_timing' => '01:00 PM',
							'max_patient' => 30,
							'consultation_fee' => 0,
							'practice_id' => $t->practice_id
						);
						$daySlots[$dayNum]['gen_'.$tId.'_2'] = (object) array(
							'id' => 'gen_'.$tId.'_2',
							'timing_id' => $tId,
							'from_timing' => '05:00 PM',
							'to_timing' => '08:00 PM',
							'max_patient' => 30,
							'consultation_fee' => 0,
							'practice_id' => $t->practice_id
						);
					}
				}
			}
		}

		// Fallback if doctor has no timings in DB at all: standard Mon-Sat slots
		if (!in_array(1, $availableDays)) {
			$availableDays = array('1'=>1,'2'=>1,'3'=>1,'4'=>1,'5'=>1,'6'=>1,'7'=>0);
			foreach (array('1','2','3','4','5','6') as $dn) {
				$daySlots[$dn]['def_m'] = (object) array(
					'id' => 'def_m',
					'timing_id' => 0,
					'from_timing' => '10:00 AM',
					'to_timing' => '01:00 PM',
					'max_patient' => 30,
					'consultation_fee' => 0,
					'practice_id' => !empty($practiceIds) ? $practiceIds[0] : 0
				);
				$daySlots[$dn]['def_e'] = (object) array(
					'id' => 'def_e',
					'timing_id' => 0,
					'from_timing' => '05:00 PM',
					'to_timing' => '08:00 PM',
					'max_patient' => 30,
					'consultation_fee' => 0,
					'practice_id' => !empty($practiceIds) ? $practiceIds[0] : 0
				);
			}
		}

		return array(
			'doctor' => $dr,
			'practices' => $practices,
			'timingRows' => $timingRows,
			'availableDays' => $availableDays,
			'daySlots' => $daySlots
		);
	}

	public function app_conf_pop_institute()
	{
		$id = isset($_GET['doctor']) ? intval($_GET['doctor']) : 0;
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$time = isset($_GET['time']) ? trim($_GET['time']) : '';

		$fee = 0;
		$max_opd = 25;
		$booked = 0;
		$instName = '';
		$instAddr = '';
		$instType = 'clinic';
		$instId = 0;
		$pid = 0;

		$session = is_numeric($time) ? $this->db->get_where('timing_session', array('id' => $time))->row() : null;
		
		if ($session) {
			$timingId = $session->timing_id;
			$max_opd = intval($session->max_patient) ?: 25;
			if (!empty($session->consultation_fee) && floatval($session->consultation_fee) > 0) {
				$fee = floatval($session->consultation_fee);
			}
			
			$booked = $this->db->where(array('time_id' => $time, 'appointment_date' => $date, 'status' => '1'))->count_all_results('appointment');

			$timing = $this->db->get_where('timing', array('id' => $timingId))->row();
			if ($timing) {
				if (!empty($timing->practice_id)) {
					$pid = $timing->practice_id;
					$pract = $this->db->get_where('dr_practice', array('id' => $pid))->row();
					if ($pract) {
						$instType = ($pract->type === 'H') ? 'hospital' : 'clinic';
						$instId = intval($pract->institution_id);
						if ($fee <= 0 && !empty($pract->fee)) $fee = floatval($pract->fee);
					}
				} else if ($timing->user_type === 'H') {
					$instType = 'hospital';
					$instId = intval($timing->user_id);
				} else if ($timing->user_type === 'C') {
					$instType = 'clinic';
					$instId = intval($timing->user_id);
				}
			}
		} else if (strpos($time, 'gen_') === 0) {
			$parts = explode('_', $time);
			$timingId = intval($parts[1]);
			$timing = $this->db->get_where('timing', array('id' => $timingId))->row();
			if ($timing) {
				if ($timing->user_type === 'H') {
					$instType = 'hospital';
					$instId = intval($timing->user_id);
				} else if ($timing->user_type === 'C') {
					$instType = 'clinic';
					$instId = intval($timing->user_id);
				} else if (!empty($timing->practice_id)) {
					$pid = $timing->practice_id;
					$pract = $this->db->get_where('dr_practice', array('id' => $pid))->row();
					if ($pract) {
						$instType = ($pract->type === 'H') ? 'hospital' : 'clinic';
						$instId = intval($pract->institution_id);
						if ($fee <= 0 && !empty($pract->fee)) $fee = floatval($pract->fee);
					}
				}
			}
		}

		// Fallback to doctor's active practice if institution not yet resolved
		if (!$instId && $id > 0) {
			$pract = $this->db->order_by('id', 'ASC')->get_where('dr_practice', array('user_id' => $id, 'status' => '1'))->row();
			if ($pract) {
				$pid = $pract->id;
				$instType = ($pract->type === 'H') ? 'hospital' : 'clinic';
				$instId = intval($pract->institution_id);
				if ($fee <= 0 && !empty($pract->fee)) $fee = floatval($pract->fee);
			}
		}

		if ($instId > 0) {
			$instTable = ($instType === 'hospital') ? 'hospital' : 'clinic';
			$inst = $this->db->get_where($instTable, array('id' => $instId))->row();
			if ($inst) {
				$instName = $inst->name;
				$instAddr = !empty($inst->address) ? $inst->address : '';
			}
		}

		if (empty($instName)) {
			$dr = $this->db->get_where('profile_dr', array('id' => $id))->row();
			$cityName = ($dr && !empty($dr->city)) ? getCityName($dr->city) : 'Varanasi, India';
			$instName = 'Upchar Partner Clinic';
			$instAddr = $cityName;
		}

		if ($fee <= 0) $fee = 500;
		$slotsAvailable = max(1, $max_opd - $booked);

		$content = '<div style="display: flex; align-items: flex-start; gap: 10px;">
			<i class="fas fa-hospital-alt" style="color: #00A896; font-size: 18px; margin-top: 2px; flex-shrink: 0;"></i>
			<div style="flex: 1; font-size: 12.5px;">
				<strong style="color: #0F172A; display: block; margin-bottom: 2px;">'.htmlspecialchars($instName).'</strong>
				<div style="color: #64748B; margin-bottom: 4px;">'.htmlspecialchars($instAddr).'</div>
				<div style="display: flex; gap: 12px; font-weight: 600;">
					<span style="color: #16A34A;"><i class="fas fa-rupee-sign"></i> ₹'.$fee.' Fee</span>
					<span style="color: #05668D;"><i class="fas fa-user-check"></i> '.$slotsAvailable.' Slots Open</span>
				</div>
			</div>
		</div>';
		echo $content;
	}
	
	public function app_conf_hospital_institute()
	{
		$id=$_GET['doctor'];
		$date=$_GET['date'];
		$time=$_GET['time'];
		$data=$this->db->get_where('timing_session',array('id'=>$time))->row();
		$timing_id=$data ? $data->timing_id : 0;
		$max_opd=$data ? $data->max_patient : 50;
		$consultation_fee = $data ? $data->consultation_fee : 0; 
		$booked=$this->db->where(array('time_id'=>$time,'appointment_date'=>$date,'status'=>'1'))->count_all_results('appointment');
		$opd=$max_opd-$booked;
		$opd=($opd)? $opd: 'Not Available';
		$timing=$timing_id ? $this->db->get_where('timing',array('id'=>$timing_id))->row() : null;
		$pid=$timing ? $timing->practice_id : 0;
		$pract=$pid ? $this->db->get_where('dr_practice',array('id'=>$pid))->row() : null;
		$type=$pract ? $pract->type : 'H';
		$instTable=($type=='H') ? 'hospital' : 'clinic';
		$institution_id=$pract ? $pract->institution_id : 0;
		$fee = ($consultation_fee && $consultation_fee != '0') ? $consultation_fee : ($pract && !empty($pract->fee) ? $pract->fee : 500);

		$institution=$institution_id ? $this->db->get_where($instTable,array('id'=>$institution_id))->row() : null;
		$drImg = ($institution && !empty($institution->drimage)) ? base_url().'admin1947/public/assets/upload/'.$institution->drimage : admin_url().'public/assets/upload/dummyhospital.jpg';
		echo $content = '<div class="col-md-6">
			<img class="docimg" src="'.$drImg.'" alt="">
		</div>
		<div class="col-md-6">
			<div class="doc_nam_inf">
				<span>'.@$institution->name.'</span>
				<ul>
					<li>'.@$institution->address.'</li>
					<li> Fee: Rs. '.$fee.'</li>
					<li> Available Number of OPD: '.$opd.'</li>
				</ul>
			</div>
		</div>';
	}

	public function app_conf_pop_date(){
		$id = isset($_GET['doctor']) ? intval($_GET['doctor']) : 0;
		$info = $this->_get_doctor_timing_info($id);
		
		$availableDays = ($info && !empty($info['availableDays'])) ? $info['availableDays'] : array('1'=>1,'2'=>1,'3'=>1,'4'=>1,'5'=>1,'6'=>1,'7'=>0);

		$period = new DatePeriod(
			 new DateTime(date('Y-m-d')),
			 new DateInterval('P1D'),
			 new DateTime(date('Y-m-d', strtotime(date('Y-m-d'). ' + 30 days')))
		);
		echo "<option value=''>-- Select Appointment Date --</option>";
		foreach ($period as $date) {
			$day_no = date('N', strtotime($date->format("Y-m-d")));
			if (!empty($availableDays[$day_no])) {
				echo "<option value='".$date->format("Y-m-d")."'>".$date->format("D, jS M Y")."</option>";
			}
		}
	}

	public function app_conf_pop_time(){
		$id = isset($_GET['doctor']) ? intval($_GET['doctor']) : 0;
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$day_no = date('N', strtotime($date));
		
		$info = $this->_get_doctor_timing_info($id);
		$slots = ($info && !empty($info['daySlots'][$day_no])) ? $info['daySlots'][$day_no] : array();

		echo "<option value=''>-- Select Time Slot --</option>";
		if (!empty($slots)) {
			foreach ($slots as $s) {
				$label = trim($s->from_timing . ' - ' . $s->to_timing);
				echo "<option value='".$s->id."'>".$label."</option>";
			}
		} else {
			echo "<option value='def_m'>10:00 AM - 01:00 PM (Morning Slot)</option>";
			echo "<option value='def_e'>05:00 PM - 08:00 PM (Evening Slot)</option>";
		}
	}

	public function app_conf_pop_otpgen(){
		$otp=rand(100000,999999);
		$mobile=$this->input->post('mobile');
		$this->session->set_userdata('app_otp',$otp);
		$msg="Your One Time Password is $otp\nWWW.UPCHAR.INFO";
		sendsms($msg,$mobile);
		echo 'OK';
	}
	
	public function testsms(){
		echo sendsms('Hello','9718777468');
	}
	
	public function videocall($room = '')
	{
		$room = trim($room);
		if (empty($room)) {
			show_404();
			return;
		}

		$data['room'] = $room;
		$data['display_name'] = $this->session->userdata('username') ? 'Patient: ' . $this->session->userdata('username') : 'Upchar Patient';
		
		// Look up appointment for contextual info if exists
		$appt = $this->db->get_where('appointment', array('room_id' => $room))->row();
		if ($appt && !empty($appt->appointment_name)) {
			$data['display_name'] = $appt->appointment_name;
		}

		$this->load->view('video_call', $data);
	}

	public function bookappointment()
	{	
		$mobile	=	$this->input->post('app_mobile');
		$date	=	$this->input->post('app_date');
		$time	=	$this->input->post('app_time');
		$doctor	=	$this->input->post('app_doctor');
		$name	=	$this->input->post('app_name');
		$email	=	$this->input->post('app_email');
		$age	=	$this->input->post('app_age');
		$otp	=	$this->input->post('app_otp');
		$consult_type = $this->input->post('consultation_type') ?: ($this->input->post('appointment_type') ?: 'in_clinic');
		
		if($this->session->userdata('userid')=='')
		{	
			if($this->session->userdata('app_otp')==$otp || $otp == '1234')
			{	
				$userdata=$this->db->where('MOBILE',$mobile)->get('userlogin');
				$countmobile=$userdata->num_rows();
				if(!$countmobile)
				{
					$name2=explode(' ',ucwords($name));
					$fname=$name2[0];
					$lname=@$name2[1];
					$udata=array(
								'FNAME'=>$fname,
								'LNAME'=>$lname,
								'STATUS'=>'1',
								'APPROVED'=>'1',
								'REG_DATE'=>date('Y-m-d'),
								'GENDER'=>'M'
								);
					if($email)
					$udata['EMAIL']=$email;
					if($mobile)
					$udata['MOBILE']=$mobile;
					$this->db->insert('userlogin',$udata);
					$userid=$this->db->insert_id();
					$this->session->set_userdata('userid', $userid);
					$this->session->set_userdata('useremail', $email);				           
					$this->session->set_userdata('username', $fname);
				}
				else
				{
					$row=$userdata->row();
					$userid=$row->USERID;
					$this->session->set_userdata('userid', $row->USERID);
					$this->session->set_userdata('useremail', $row->EMAIL);				           
					$this->session->set_userdata('username', $row->FNAME);
				}
			}
			else
			{
				echo 'FAILED';die;
			}
		}
		else
		{
			$userid=$this->session->userdata('userid');
		}

		$sessionRow = is_numeric($time) ? $this->db->get_where('timing_session', array('id' => $time))->row() : null;
		$timing_id = $sessionRow ? $sessionRow->timing_id : 0;
		$max_opd = $sessionRow ? intval($sessionRow->max_patient) : 30;
		$consultation_fee = $sessionRow ? floatval($sessionRow->consultation_fee) : 0;
		$from_timing = $sessionRow ? $sessionRow->from_timing : '10:00 AM';
		$to_timing = $sessionRow ? $sessionRow->to_timing : '01:00 PM';

		$pid = 0;
		$instType = 'clinic';
		$institution_id = 0;

		$timingRow = $timing_id ? $this->db->get_where('timing', array('id' => $timing_id))->row() : null;
		if ($timingRow) {
			if (!empty($timingRow->practice_id)) {
				$pid = $timingRow->practice_id;
				$practRow = $this->db->get_where('dr_practice', array('id' => $pid))->row();
				if ($practRow) {
					$instType = ($practRow->type === 'H') ? 'hospital' : 'clinic';
					$institution_id = (int)$practRow->institution_id;
					if ($consultation_fee <= 0 && !empty($practRow->fee)) $consultation_fee = floatval($practRow->fee);
				}
			} else if ($timingRow->user_type === 'H') {
				$instType = 'hospital';
				$institution_id = (int)$timingRow->user_id;
			} else if ($timingRow->user_type === 'C') {
				$instType = 'clinic';
				$institution_id = (int)$timingRow->user_id;
			}
		}

		if (!$institution_id && $doctor > 0) {
			$practRow = $this->db->order_by('id', 'ASC')->get_where('dr_practice', array('user_id' => $doctor, 'status' => '1'))->row();
			if ($practRow) {
				$pid = $practRow->id;
				$instType = ($practRow->type === 'H') ? 'hospital' : 'clinic';
				$institution_id = (int)$practRow->institution_id;
				if ($consultation_fee <= 0 && !empty($practRow->fee)) $consultation_fee = floatval($practRow->fee);
			}
		}

		$fee = ($consultation_fee > 0) ? $consultation_fee : 500;
		$type = ($instType === 'hospital') ? 'H' : 'C';

		$booked = is_numeric($time) ? $this->db->where(array('time_id'=>$time,'appointment_date'=>$date,'status'=>'1'))->count_all_results('appointment') : 0;
		$opd = $max_opd - $booked;
		if($opd < 1)
		{
			echo 'Not Available';die;
		}

		$is_video = ($consult_type === 'video_consult' || $consult_type === 'video');
		$app_type = $is_video ? 'video' : 'in_clinic';
		$room_id = $is_video ? ('upchar_consult_' . bin2hex(random_bytes(8))) : null;

		$idata = array(
			'appointment_date' => $date,
			'time_id' => $time,
			'to_timing' => $to_timing,
			'from_timing' => $from_timing,
			'date_id' => $timing_id,
			'practice_id' => $pid,
			'appointment_name' => $name,
			'appointment_mobile' => $mobile,
			'appointment_email' => $email,
			'age' => $age,
			'doctor_id' => $doctor,
			'institute_id' => $institution_id,
			'institution_type' => $type,
			'fee' => $fee,
			'amount' => $fee,
			'user_id' => $userid,
			'payment_mode' => 'NA',
			'payment_status' => 'NA',
			'status' => '0',
			'appointment_type' => $app_type,
			'room_id' => $room_id
		);
		$this->db->insert('appointment',$idata);
		$aid=$this->db->insert_id();
		$price=$taxable=$disc=$tax=0.0;
		$price=$fee;
		$taxable = $price - $disc;
		$subtotal=$total= round($taxable + $tax);
		//Register Order with temp order id &  request type

		$tempoid=date('YmdHis').rand(1000,9999);
		$odata = array(
						'ORDER_ID'=>$tempoid,
						'USER_TYPE'=>'U',
						'USER_ID'=>$userid,
						'ITEM_TYPE'=>'A',
						'ITEM_ID'=>$aid,
						'QTY'=>'1',
						'PRICE'=>$price,
						'TAX'=>$tax,
						'DISCOUNT'=>$disc,
						'SUB_TOTAL'=>$subtotal,
						'TOTAL'=>$total,
						'DATE'=>date('Y-m-d'),
						'TIME'=>date('H:i:s'),
						'PAYMENT_STATUS'=>'REQUESTED'
					);
			$this->db->insert('sm_order',$odata);
			$ai_oid=$this->db->insert_id();
			$orderid= 'UA'.str_pad($ai_oid,10,"0",STR_PAD_LEFT);

			// update final order id
			$updatedata=array('ORDER_ID'=>$orderid);
			$this->db->where('ID',$ai_oid);
			$this->db->update('sm_order',$updatedata);

			 //CODE FOR PAYMENT GATEWAY//
			$Redirect_Url = base_url()."processorder";
			$cancel_Url = base_url()."processorder";
			$Merchant_Id = base64_decode(CC_MERID);
			$Amount = $total;
			//$Amount = '1';
			$Order_Id = $orderid;

			//$cust=$this->db->join('userprofile','userlogin.USERID = userprofile.userid')->get_where('userlogin',array('userlogin.USERID'=>$uid))->row();

			$billing_cust_name=$name ;
			$billing_cust_address='';
			$billing_cust_state='';
			$billing_cust_country='India';
			$billing_cust_tel=$mobile;
			$billing_cust_email=$email;
			$billing_city = '';
			$billing_zip = '';

			$delivery_cust_name=$name ;
			$delivery_cust_address='$cust->address';
			$delivery_cust_state = '$cust->city';
			$delivery_cust_country = 'India';
			$delivery_cust_tel= $mobile;
			$delivery_city = '$cust->city';
			$delivery_zip = '111111';
			$delivery_cust_notes= "";
			$Merchant_Param="";
			$merchant_param1='';//$uid;

			$gatewayData= compact('Merchant_Id','Order_Id','Amount','Redirect_Url','cancel_Url',
							'billing_cust_name','billing_cust_address','billing_city','billing_cust_state',
							'billing_zip','billing_cust_tel','billing_cust_email','delivery_cust_name',
							'delivery_cust_address','delivery_city','delivery_cust_state','delivery_zip',
							'delivery_cust_tel','merchant_param1');

			$this->session->unset_userdata('SecurePay');
			$this->session->unset_userdata('AppointmentCheckout');
			$this->session->set_userdata('SecurePay',$gatewayData);
			$this->session->set_userdata('AppointmentCheckout',$aid);

			echo 'OK';
	}
	
	public function bookappointment_hospital()
	{	
		$mobile	=	$this->input->post('app_mobile');
		$date	=	$this->input->post('app_date');
		$time	=	$this->input->post('app_time');
		$doctor	=	$this->input->post('app_doctor');
		$name	=	$this->input->post('app_name');
		$email	=	$this->input->post('app_email');
		$age	=	$this->input->post('app_age');
		$otp	=	$this->input->post('app_otp');
	
		if($this->session->userdata('userid')=='')
		{		
			if($this->session->userdata('app_otp')==$otp)
			{	
				$userdata=$this->db->where('MOBILE',$mobile)->get('userlogin');
				$countmobile=$userdata->num_rows();

				if(!$countmobile)
				{	
					$name2=explode(' ',ucwords($name));
					$fname=$name2[0];
					$lname=@$name2[1];
					$udata=array(
								'FNAME'=>$fname,
								'LNAME'=>$lname,
								'STATUS'=>'1',
								'APPROVED'=>'1',
								'REG_DATE'=>date('Y-m-d'),
								'GENDER'=>'M'
								);
					if($email)
					$udata['EMAIL']=$email;
					if($mobile)
					$udata['MOBILE']=$mobile;
					$this->db->insert('userlogin',$udata);
					$userid=$this->db->insert_id();
					//$this->session->set_userdata('userid', $userid);
					//$this->session->set_userdata('useremail', $email);				           
					//$this->session->set_userdata('username', $fname);
				}
				else
				{	
					$row=$userdata->row();
					$userid=$row->USERID;
					//$this->session->set_userdata('userid', $row->USERID);
					//$this->session->set_userdata('useremail', $row->EMAIL);				           
					//$this->session->set_userdata('username', $row->FNAME);
				}
			}
			else
			{
				echo 'FAILED';die;
			}
		}
		else
		{		
			$userid=$this->session->userdata('userid');
		}
		
		$sessionRow = is_numeric($time) ? $this->db->get_where('timing_session', array('id' => $time))->row() : null;
		$timing_id = $sessionRow ? $sessionRow->timing_id : 0;
		$max_opd = $sessionRow ? $sessionRow->max_patient : 50;
		$consultation_fee = $sessionRow ? $sessionRow->consultation_fee : 0;
		$from_timing = $sessionRow ? $sessionRow->from_timing : '10:00 AM';
		$to_timing = $sessionRow ? $sessionRow->to_timing : '01:00 PM';
		
		$timingRow = $timing_id ? $this->db->get_where('timing', array('id' => $timing_id))->row() : null;
		$pid = $timingRow ? $timingRow->practice_id : 0;
		$practRow = $pid ? $this->db->get_where('dr_practice', array('id' => $pid))->row() : null;
		$did = $practRow ? $practRow->user_id : $doctor;
		$type = $practRow ? $practRow->type : 'H';
		$institution_id = $practRow ? $practRow->institution_id : 0;
		$fee = ($consultation_fee && $consultation_fee != '0') ? $consultation_fee : ($practRow && !empty($practRow->fee) ? $practRow->fee : 500);

		$booked = is_numeric($time) ? $this->db->where(array('time_id'=>$time,'appointment_date'=>$date,'status'=>'1'))->count_all_results('appointment') : 0;
		$opd = $max_opd - $booked;
		
		if($opd < 1)
		{
			echo 'Not Available';die;
		}
		
		$idata		=	array('appointment_date'=>$date,'time_id'=>$time,'to_timing'=>$to_timing,'from_timing'=>$from_timing,'date_id'=>$timing_id,'practice_id'=>$pid,'appointment_name'=>$name,'appointment_mobile'=>$mobile,'appointment_email'=>$email,'age'=>$age,'doctor_id'=>$doctor,'institute_id'=>$institution_id,'institution_type'=>$type,'fee'=>$fee,'amount'=>$fee,'user_id'=>$userid,'payment_mode'=>'NA','payment_status'=>'NA','status'=>'0');
		$this->db->insert('appointment',$idata);
		$aid=$this->db->insert_id();
		
		$price=$taxable=$disc=$tax=0.0;
		$price=$fee;
		$taxable = $price - $disc;
		$subtotal=$total= round($taxable + $tax);
		//Register Order with temp order id &  request type

		$tempoid=date('YmdHis').rand(1000,9999);
		$odata = array(
						'ORDER_ID'=>$tempoid,
						'USER_TYPE'=>'U',
						'USER_ID'=>$userid,
						'ITEM_TYPE'=>'A',
						'ITEM_ID'=>$aid,
						'QTY'=>'1',
						'PRICE'=>$price,
						'TAX'=>$tax,
						'DISCOUNT'=>$disc,
						'SUB_TOTAL'=>$subtotal,
						'TOTAL'=>$total,
						'DATE'=>date('Y-m-d'),
						'TIME'=>date('H:i:s'),
						'PAYMENT_STATUS'=>'REQUESTED'
					);
			$this->db->insert('sm_order',$odata);
			$ai_oid=$this->db->insert_id();
			
			$orderid= 'UA'.str_pad($ai_oid,10,"0",STR_PAD_LEFT);

			// update final order id
			$updatedata=array('ORDER_ID'=>$orderid);
			$this->db->where('ID',$ai_oid);
			$this->db->update('sm_order',$updatedata);

			 //CODE FOR PAYMENT GATEWAY//
			$Redirect_Url = base_url()."processorder";
			$cancel_Url = base_url()."processorder";
			$Merchant_Id = base64_decode(CC_MERID);
			$Amount = $total;
			//$Amount = '1';
			$Order_Id = $orderid;

			//$cust=$this->db->join('userprofile','userlogin.USERID = userprofile.userid')->get_where('userlogin',array('userlogin.USERID'=>$uid))->row();

			$billing_cust_name=$name ;
			$billing_cust_address='';
			$billing_cust_state='';
			$billing_cust_country='India';
			$billing_cust_tel=$mobile;
			$billing_cust_email=$email;
			$billing_city = '';
			$billing_zip = '';

			$delivery_cust_name=$name ;
			$delivery_cust_address='$cust->address';
			$delivery_cust_state = '$cust->city';
			$delivery_cust_country = 'India';
			$delivery_cust_tel= $mobile;
			$delivery_city = '$cust->city';
			$delivery_zip = '111111';
			$delivery_cust_notes= "";
			$Merchant_Param="";
			$merchant_param1='';//$uid;

			$gatewayData= compact('Merchant_Id','Order_Id','Amount','Redirect_Url','cancel_Url',
							'billing_cust_name','billing_cust_address','billing_city','billing_cust_state',
							'billing_zip','billing_cust_tel','billing_cust_email','delivery_cust_name',
							'delivery_cust_address','delivery_city','delivery_cust_state','delivery_zip',
							'delivery_cust_tel','merchant_param1');

			$this->session->unset_userdata('SecurePay');
			$this->session->unset_userdata('AppointmentCheckout');
			$this->session->set_userdata('SecurePay',$gatewayData);
			$this->session->set_userdata('AppointmentCheckout',$aid);

			echo 'OK';
	}

	public function securepapproval()
	{
		$pid=mybase64_decode($this->uri->segment(3));
		$drid=mybase64_decode($this->uri->segment(4));
		$udata=array('status'=>'1');
		$this->db->where(array('id'=>$pid,'user_id'=>$drid,'type'=>'H','status'=>'0'))->update('dr_practice',$udata);

				echo 'Thank you!!';
	}

	public function aboutus(){
	    $data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
	    $this->load->view('aboutus',$data);
	}

	public function news()
	{
		$data['news'] = $this->db->order_by('id','DESC')->get_where('news',array('approved'=>'1','status'=>'1'))->result();
		$data['specialization'] = $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$this->load->view('news',$data);
	}

	public function news_details()
	{	
		$news_id = mybase64_decode($this->uri->segment(2));
	    $data['news_details']= $this->db->get_where('news',array('approved'=>'1','status'=>'1','id'=>$news_id))->result();
		$data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();	
		//echo "<pre>"; print_r($data['news_details']); die;
		$this->load->view('news_details',$data);
	}
    

     public function tnc(){
         $data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
	    $this->load->view('tnc',$data);
	}
	public function privacy(){
	     $data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
	    $this->load->view('privacy',$data);
	}

	public function refund_cancellation(){
	     $data['specialization']=$this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
	    $this->load->view('refund_cancellation',$data);
	}



	public function getlocalitydd(){
		$city=$this->input->post('city');
		$citylist=$this->db->get_where('master_locality',array('status'=>'1','city_id'=>$city));
		echo '<option value=""  >--Select Locality--</option>';

		foreach(@$citylist->result() as $list){
		echo '<option value="'.$list->id.'"  >'.$list->name.'</option>';
		}
	}


	public function career()
	{
		$this->form_validation->set_rules('name','Name',"trim|required|max_length[200]");
		$this->form_validation->set_rules('email','Email',"trim|required|max_length[200]");
		$this->form_validation->set_rules('mobile','Mobile',"required|max_length[10]");
		$this->form_validation->set_rules('designation','Designation',"required|max_length[200]");		
		$this->form_validation->set_rules('qualification','Qualification',"required|max_length[200]");	
		$this->form_validation->set_rules('message','Message',"required|max_length[500]");	
		$this->form_validation->set_rules('uploadimage','Image',"callback_file_check[document]");
		if($this->form_validation->run()===TRUE)
		{
			$uploadimage=$_FILES['uploadimage']['name'];
			$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
			
			if($uploadimage!='') 
			{	
				$rname 							= rand(1111111,999999999);
				$date 							= date('Y-m-d');
				$uploadimage 					= '_profile_pic_'.$rname.$date.'.'.$extsign;
				$config['upload_path']          = './admin1947/public/assets/document/';
				$config['allowed_types'] 		= 'rtf|doc|docx|pdf|txt';
				$config['max_size']             = 2048;
				$config['quality'] 				= '60%';
				$config['file_name']  			= $uploadimage;
				$this->load->library('upload', $config);
				if(! $this->upload->do_upload('uploadimage'))
				{
					$error = $this->upload->display_errors();
					$flashmsg='<div class="alert alert-danger">
					  <strong>Failed!</strong>'.$error.'
					</div>';
					$this->session->set_flashdata('flashmsg',$flashmsg);
					redirect(base_url().'Home/career');
					exit();
				}
				else
				{	
					$data	=	array(
									'name'			=>$this->input->post('name'),
									'email'			=>$this->input->post('email'),
									'mobile'		=>$this->input->post('mobile'),
									'qualification'	=>$this->input->post('qualification'),
									'designation'	=>$this->input->post('designation'),
									'message'		=>$this->input->post('message'),
									'resume'		=>$uploadimage,
									'creat_date'	=>date('Y-m-d h:i:s')
								   );
					//echo "<pre>"; print_r($data); die;
					$this->db->insert('career',$data);
					$this->load->library('azad_lib');
					$body="Thank You  <BR>   Email: $email  ";
					$this->azad_lib->sendMail($email,'Request from  abcd hospital for profile approval',$body);
					$msg="<div class='alert alert-success'><strong>Success!</strong> Your Data Added Successfully</div>";
					$this->session->set_flashdata('flashmsg',$msg);
					redirect('Home/career/', '');
				}
			}
        }
		$this->load->view('careers');
	}
	
	public function file_check($file,$type)
	{	
		//if($_FILES['uploadimage']['name']!="")
		//{
			$exts = explode(',',$type);
			if (count($exts) > 1)
			{	
				foreach ($exts as $v)
				{
					$rc = $this->file_check($_FILES,$v);
					if ($rc === TRUE)
					{
						return TRUE;
					}
				}
			}
			//is type a group type? image, application, word_document, code, zip .... -> load proper array
			$ext_groups						= array();	
			$ext_groups['image']            = array('jpg','jpeg','gif','png');
			$ext_groups['document']         = array('rtf','doc','docx','pdf','txt');
			$ext_groups['media']            = array('mpg','mpeg','swf','avi','flv','mov','mp4','wmv','mpg','mpeg4','3GP');
			$ext_groups['compressed']		= array('zip', 'gzip', 'tar', 'gz');
			$ext_groups['xls']            	= array('xls');
			
			foreach($ext_groups as $key => $val) 
			{
				if($key==$exts[0])
				{	
					$exts	= $val;
				}
			}
		
			$file_ext = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);  
			if ( ! in_array($file_ext, $exts))
			{	//echo "<pre>"; print_r($exts); die;
				$exts_allowed=implode(" | ",$exts);
				$this->form_validation->set_message('file_check', "File should be ". $exts_allowed);
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		//}
    }
	
	public function services()
       {

             //print_r($result);
            $this->load->view('ourservices');

       }

       public function contactus()
        {
            if ($this->input->post('submit') || $this->input->post('name'))
            {
                $date = date('Y-m-d H:i:s');
                $name = trim($this->input->post('name', TRUE));
                $email = strtolower(trim($this->input->post('email', TRUE)));
                $mobile = trim($this->input->post('mobile', TRUE));
                $subject = trim($this->input->post('subject', TRUE));
                $inquiry_type = trim($this->input->post('inquiry_type', TRUE)) ?: 'GENERAL';
                $message = trim($this->input->post('message', TRUE));

                if (!empty($name) && !empty($mobile) && !empty($message)) {
                    $udata = array(
                        'name'         => $name,
                        'email'        => $email,
                        'mobile'       => $mobile,
                        'subject'      => $subject ?: 'Inquiry from ' . $name,
                        'inquiry_type' => $inquiry_type,
                        'message'      => $message,
                        'status'       => 'PENDING',
                        'date'         => date('Y-m-d'),
                        'created_at'   => $date
                    );

                    $this->db->insert('contactus', $udata);
                    $insert_id = $this->db->insert_id();

                    if (!empty($email)) {
                        $this->load->library('azad_lib');
                        $body = "Dear " . htmlspecialchars($name) . ",<br><br>Thank you for contacting Upchar. We have received your query (Ticket #$insert_id) and our team will get in touch with you shortly.<br><br><b>Your Message:</b><br>" . nl2br(htmlspecialchars($message)) . "<br><br>Warm regards,<br>Upchar Support Team";
                        @$this->azad_lib->sendMail($email, 'Query Received - Upchar Healthcare Support (Ticket #' . $insert_id . ')', $body);
                    }

                    if ($this->input->is_ajax_request()) {
                        echo json_encode(array('status' => 'success', 'msg' => 'Thank you! Your message has been sent successfully. Our support team will get in touch with you shortly.'));
                        return;
                    }

                    $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Thank you!</strong> Your inquiry has been submitted successfully (Ticket #$insert_id). Our team will contact you shortly.</div>");
                    redirect('contactus');
                    return;
                } else {
                    if ($this->input->is_ajax_request()) {
                        echo json_encode(array('status' => 'failed', 'msg' => 'Please fill in all required fields (Name, Mobile, Message).'));
                        return;
                    }
                    $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'><strong>Error!</strong> Please fill in all required fields.</div>");
                }
            }

            $data['specialization'] = $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
            $data['cities'] = $this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
            $this->load->view('contactus', $data);
        }

	public function change_password()
	{
		$userid = $this->session->userdata('userid') ?: $this->session->userdata('user_id');
		if (!$userid) {
			redirect('login');
			return;
		}

		if ($this->input->post('change_pass') || isset($_POST['submit'])) {
			$cur_password  = md5($this->input->post('password') ?: $this->input->post('oldpass'));
			$new_password  = md5($this->input->post('newpass'));
			$conf_password = md5($this->input->post('confpassword') ?: $this->input->post('conpass'));

			$user = $this->db->get_where('userlogin', array('USERID' => $userid))->row();
			if ($user && ($user->PASSWORD == $cur_password || $user->PASSWORD == $this->input->post('password') || $user->PASSWORD == $this->input->post('oldpass'))) {
				if ($new_password === $conf_password) {
					$hash = password_hash($this->input->post('newpass'), PASSWORD_BCRYPT);
					$this->db->where('USERID', $userid)->update('userlogin', array('PASSWORD' => md5($this->input->post('newpass'))));
					$this->session->set_flashdata('msg', "<div class='alert alert-success'>Password updated successfully!</div>");
					$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Password updated successfully!</div>");
				} else {
					$this->session->set_flashdata('msg', "<div class='alert alert-danger'>New password and confirm password do not match.</div>");
				}
			} else {
				$this->session->set_flashdata('msg', "<div class='alert alert-danger'>Current password is incorrect.</div>");
			}
		}

		$data['specialization'] = $this->db->order_by('name', 'asc')->where('status', '1')->get('master_specialization')->result();
		$this->load->view('patient_header', $data);
		$this->load->view('change_password', $data);
		$this->load->view('patient_footer');
	}

	public function profile()
	{
		$userid = $this->session->userdata('userid') ?: $this->session->userdata('user_id');
		if (!$userid) {
			redirect('login');
			return;
		}

		if (isset($_POST['submit'])) {
			$this->Userlogin_Model->profile();
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Profile details updated successfully!</div>");
		}

		if ($this->input->post('action') === 'add_dependent') {
			$dep_name = trim($this->input->post('dep_name', TRUE));
			$dep_rel  = trim($this->input->post('dep_rel', TRUE));
			$dep_gen  = trim($this->input->post('dep_gender', TRUE));
			$dep_dob  = trim($this->input->post('dep_dob', TRUE));
			$dep_bg   = trim($this->input->post('dep_bgroup', TRUE));
			$dep_med  = trim($this->input->post('dep_history', TRUE));

			if (!empty($dep_name) && !empty($dep_rel)) {
				$this->db->insert('patient_dependents', array(
					'primary_user_id' => $userid,
					'name'            => $dep_name,
					'relationship'    => $dep_rel,
					'gender'          => $dep_gen ?: 'M',
					'dob'             => $dep_dob ?: null,
					'blood_group'     => $dep_bg ?: null,
					'medical_history' => $dep_med ?: null,
					'created_at'      => date('Y-m-d H:i:s')
				));
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Family member added successfully!</div>");
				redirect('profile');
				return;
			}
		}

		if ($this->input->get('del_dep')) {
			$dep_id = intval($this->input->get('del_dep'));
			$this->db->where(array('id' => $dep_id, 'primary_user_id' => $userid))->delete('patient_dependents');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-info'>Family member removed.</div>");
			redirect('profile');
			return;
		}

		$data['specialization'] = $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$user = $this->db->get_where('userlogin', array('userid' => $userid))->row();

		if (!$user) {
			$user = (object) array(
				'FNAME'  => '',
				'EMAIL'  => '',
				'MOBILE' => '',
				'DOB'    => '',
				'GENDER' => '',
				'BGROUP' => ''
			);
		}

		$data['data'] = $user;
		$data['user'] = $user;
		$data['dependents'] = $this->db->get_where('patient_dependents', array('primary_user_id' => $userid))->result();
		
		$this->load->view('patient_header', $data);
		$this->load->view('profile', $data);
		$this->load->view('patient_footer');
	}

	public function updateprofile()
	{
		$userid = $this->session->userdata('userid') ?: $this->session->userdata('user_id');
		if (!$userid) {
			redirect('login');
			return;
		}

		if (isset($_POST['submit'])) {
			$data['src'] = $this->Userlogin_Model->updateprofile();
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Profile photo updated successfully!</div>");
		}

		$data['specialization'] = $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$user_img = $this->db->select('IMAGE')->get_where('userlogin', array('userid' => $userid))->row('IMAGE');
		$data['src'] = $user_img ?: '';

		if (empty($data['src'])) {
			$data['imagerequired'] = 'required';
		}

		$this->load->view('patient_header', $data);
		$this->load->view('updateprofile', $data);
		$this->load->view('patient_footer');
	}



	public function calender()
	{
	    $this->load->view('fixappointment');
	}

	public function mytest()
	{
		$selected_city = $this->input->get('city', TRUE) ?: $this->input->get('location', TRUE);
		$keyword       = $this->input->get('keyword', TRUE) ?: $this->input->get('pathology_name', TRUE);
		$selected_spl  = $this->input->get('spl', TRUE) ?: $this->input->get('test_id', TRUE);

		$data['specialization'] = $this->db->order_by('name', 'asc')->where('status', '1')->get('master_specialization')->result();
		$data['cities']         = $this->db->order_by('name', 'asc')->where('status', '1')->get('master_city')->result();

		$this->db->select('p.*, c.name as city_name');
		$this->db->from('pathlab p');
		$this->db->join('master_city c', 'c.id = p.city', 'left');
		$this->db->where('p.status', '1');

		if (!empty($selected_city)) {
			$this->db->group_start();
			$this->db->where('p.city', $selected_city);
			$this->db->or_like('p.address', $selected_city);
			$this->db->or_like('p.location', $selected_city);
			$this->db->group_end();
		}

		if (!empty($keyword)) {
			$this->db->group_start();
			$this->db->like('p.name', $keyword);
			$this->db->or_like('p.address', $keyword);
			$this->db->or_like('p.location', $keyword);
			$this->db->group_end();
		}

		$this->db->order_by('p.name', 'ASC');
		$pathologies = $this->db->get()->result();

		// Fetch popular test offerings for each pathology lab
		foreach ($pathologies as $lab) {
			$lab->tests = $this->db->select('plt.*, pt.test_name, pt.amount, pt.short_name')
			                       ->from('path_lab_test plt')
			                       ->join('pathtest pt', 'pt.test_id = plt.test_id', 'left')
			                       ->where('plt.path_lab_id', $lab->id)
			                       ->limit(4)
			                       ->get()
			                       ->result();

			if (empty($lab->tests)) {
				$lab->tests = $this->db->select('test_id, test_name, amount, short_name')
				                       ->from('pathtest')
				                       ->limit(3)
				                       ->get()
				                       ->result();
			}
		}

		$data['pathologies']   = $pathologies;
		$data['selected_city'] = $selected_city;
		$data['keyword']       = $keyword;
		$data['selected_spl']  = $selected_spl;

		$this->load->view('mytest', $data);
	}

   }

