<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hospitalpanel extends CI_Controller 
{ 
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$date=date('Y-m-d h:i:s');
		$this->load->model('Hospital_Model');
		$this->load->model('Financial_Model');
		$this->load->library(array('Form_validation'));		
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper','text','url','form','verification_guard'));
		
		if(!$this->session->userdata('hosuserid'))
		{	
			$page=$this->uri->segment('1');
			$excep_array=array('hospital-aindex','hospital-login','hospital-signup','hospital-verifymobile','hospital-forgotpassword','hospital-verifymobileforgot');
			if (!in_array($page, $excep_array)) {
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning' style='margin: 15px 0; border-radius: 8px;'>Please login to access your Hospital Dashboard.</div>");
				redirect('hospital-login');
			}
		}
		else
		{
			$hosuserid = $this->session->userdata('hosuserid');
			$row = $this->db->where('uid', $hosuserid)->or_where('id', $hosuserid)->get('hospital')->row();
			$this->did = ($row && isset($row->id)) ? $row->id : $hosuserid;

			// Module 1: Enforce Acquisition Verification Guard
			enforce_verification_guard('hospital', $this->did, array('account_pending', 'logout', 'support', 'create_ticket', 'ticket_view', 'close_ticket'));
		}
	}
	
	public function account_pending()
	{
		$hosuserid = $this->session->userdata('hosuserid');
		$data['hospital'] = $this->db->where('uid', $hosuserid)->or_where('id', $hosuserid)->get('hospital')->row();
		$this->load->view('hospitalpanel/account_pending', $data);
	}
	
	public function index()
	{
		if ($this->session->userdata('hosuserid')) {
			redirect('hospital-dashboard');
		} else {
			redirect('hospital-login');
		}
	}
	
	public function dashboard()
	{
		$userid = $this->did;
		if (!$this->session->userdata('hospitalname')) {
			$hname = $this->db->where('uid', $this->session->userdata('hosuserid'))->or_where('id', $this->session->userdata('hosuserid'))->get('hospital')->row('name');
			if ($hname) {
				$this->session->set_userdata('hospitalname', $hname);
			}
		}

        $this->db->where('institute_id', $userid);   
        $this->db->where('institution_type', 'H');  
        $this->db->where('status', '1');   
		$this->db->where('appointment_date', date('Y-m-d'));   
        $query = $this->db->get('appointment');
		$data['todayappointment']=$query->num_rows();
         
        $this->db->where('institute_id', $userid);   
        $this->db->where('institution_type', 'H');   
        $this->db->where('status', '1');   
        $query = $this->db->get('appointment');
		$data['totalappointment']=$query->num_rows();
		$query = $this->db->select('profile_dr.*,dr_practice.status as p_status')->join('profile_dr','profile_dr.id=dr_practice.user_id')->get_where('dr_practice',array('institution_id'=>$this->did,'type'=>'H'));	
		$data['totaldoctor']=$query->num_rows();
		$this->load->view('hospitalpanel/milestone',$data);
	}
	
	public function aindex()
	{
		if ($this->session->userdata('userid')) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-info'>You are logged in as a Patient. Please logout to access Hospital Partner Login.</div>");
			redirect('myappointments');
			return;
		}
		if ($this->session->userdata('hospuserid')) {
			redirect('hospitalpanel/milestone');
			return;
		}
		$this->load->view('hospitalpanel/login');
	}
	
	public function login()
	{
		if ($this->session->userdata('userid')) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-info'>You are logged in as a Patient. Please logout to access Hospital Partner Login.</div>");
			redirect('myappointments');
			return;
		}
		if ($this->session->userdata('hospuserid')) {
			redirect('hospitalpanel/milestone');
			return;
		}
		$this->load->view('hospitalpanel/login');
	}
	
	public function signup()
	{
		$this->load->view('hospitalpanel/sign_up');
	}
	
	public function forgotpassword()
	{
		$this->load->view('hospitalpanel/forgot_password');
	}
	
	public function verifymobile()
	{
		$this->load->view('hospitalpanel/otp_send_pass');
	}
	
	/* public function verifymobileforgot()
	{
		$this->load->view('otp_send_pass_forgot');
	} */
	
	public function managedoctor()
	{
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['clinic'] 		=  $this->Hospital_Model->get_doctor($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Manage Doctors';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		$data['specialization']	=	$this->Hospital_Model->get_specialization(array('status'=>1));
		$data['degree']			=	$this->Hospital_Model->get_degree(array('status'=>1));
		$this->load->view('hospitalpanel/managedoctor',$data);
	}
	
	public function doctorlist()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['doctorlist'] 	=  $this->Hospital_Model->get_upchar_doctor($config['limit'],$offset);
		//echo "<pre>"; print_r($data['doctorlist']); die;
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	= 'Upchar Doctors';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		$data['specialization']	=	$this->Hospital_Model->get_specialization(array('status'=>1));
		$data['degree']			=	$this->Hospital_Model->get_degree(array('status'=>1));
		$this->load->view('hospitalpanel/doctorlist',$data);
	}
	
	public function doctordetail()
	{
		$id=$this->uri->segment(2);
		$data['d']=$this->db->get_where('profile_dr',array('approved'=>'1','verified'=>'1','id'=>$id))->row();
		$this->load->view('hospitalpanel/doctor_detail',$data);
	}
	public function report()
	{
		$data['clinic']=$this->db->select('profile_dr.*,dr_practice.status as p_status')->join('profile_dr','profile_dr.id=dr_practice.user_id')->get_where('dr_practice',array('institution_id'=>$this->did,'type'=>'H'))->result();	
		$this->load->view('hospitalpanel/report',$data);
	}

	public function patient()
	{
		$userid = $this->did;
		$id     = $this->uri->segment(3) ? (int) $this->uri->segment(3) : (int) $this->uri->segment(2);
		if (empty($id)) {
			$id = (int) $this->input->get_post('aid');
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$payment_status     = $this->input->post('payment_status');
			$payment_mode       = $this->input->post('payment_mode');
			$appointment_status = $this->input->post('appointment_status');
			$fee                = (float) $this->input->post('fee');

			$update_data = array();
			if (!empty($payment_status)) {
				$update_data['payment_status'] = $payment_status;
				if ($payment_status == 'DONE') {
					$update_data['pay_date'] = date('Y-m-d H:i:s');
				}
			}
			if (!empty($payment_mode)) {
				$update_data['payment_mode'] = $payment_mode;
			}
			if ($appointment_status !== null && $appointment_status !== '') {
				$update_data['appointment_status'] = $appointment_status;
				if ($appointment_status == '1') {
					$update_data['appointment_done_date'] = date('Y-m-d H:i:s');
				}
			}
			if ($fee > 0) {
				$update_data['fee']    = $fee;
				$update_data['amount'] = $fee;
			}

			if (!empty($update_data)) {
				$this->db->where('appointment_id', $id);
				$this->db->where('institute_id', $userid);
				$this->db->update('appointment', $update_data);
			}

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Updated!</strong> Patient encounter details and billing updated successfully.</div>");
			redirect('hospitalpanel/patient/'.$id);
			return;
		}

		$data['p'] = $this->db->select('appointment.*, userlogin.FNAME as u_fname, userlogin.LNAME as u_lname, userlogin.EMAIL as u_email, userlogin.MOBILE as u_mobile, userlogin.GENDER as u_gender, userlogin.DOB, userlogin.BGROUP, userlogin.HEIGHT, userlogin.WEIGHT, userlogin.IMAGE as u_image, profile_dr.fname as dr_fname, profile_dr.lname as dr_lname, profile_dr.drimage, profile_dr.mobile as dr_mobile, profile_dr.email as dr_email, sm_checkout.orderid, sm_checkout.billingaddress, sm_checkout.billingcity, sm_checkout.billingstate, sm_checkout.billingzip, sm_checkout.billingcountry, sm_checkout.paymentmod, sm_checkout.cardname')
			->join('userlogin', 'userlogin.USERID = appointment.user_id', 'left')
			->join('sm_checkout', 'sm_checkout.id = appointment.checkout_id', 'left')
			->join('profile_dr', 'profile_dr.id = appointment.doctor_id', 'left')
			->where('appointment.appointment_id', $id)
			->where('appointment.institute_id', $userid)
			->get('appointment')
			->row();

		if (is_object($data['p']) && !empty($data['p'])) {
			$this->load->view('hospitalpanel/patienthistory', $data);
		} else {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>Appointment #$id not found in your hospital records.</div>");
			redirect('hospitalpanel/manageappointment');
		}
	} 
	public function data()
	{
		$userid      = $this->did;
		$id          = (int) $this->input->get_post('id');
		$filter_date = $this->input->get_post('d');

		$this->db->select('appointment.*, profile_dr.fname, profile_dr.lname, profile_dr.drimage, profile_dr.mobile as dr_mobile, profile_dr.email as dr_email');
		$this->db->join('profile_dr', 'profile_dr.id = appointment.doctor_id', 'left');
		$this->db->where('appointment.doctor_id', $id);
		$this->db->where('appointment.institute_id', $userid);
		$this->db->where('appointment.institution_type', 'H');
		$this->db->where('appointment.status !=', '0');
		if (!empty($filter_date)) {
			$this->db->where('appointment.appointment_date', $filter_date);
		}
		$this->db->order_by('appointment.appointment_date', 'DESC');
		$this->db->order_by('appointment.appointment_id', 'DESC');
		$data['data'] = $this->db->get('appointment')->result();

		$data['doctor']      = $this->db->get_where('profile_dr', array('id' => $id))->row();
		$data['hospital']    = count($data['data']);
		$data['doctor_id']   = $id;
		$data['filter_date'] = $filter_date;

		// Summary Stats for this doctor at this hospital
		$data['total_paid']   = 0;
		$data['total_unpaid'] = 0;
		$data['total_fee']    = 0;
		foreach ($data['data'] as $apt) {
			$fee = (float) $apt->fee;
			if ($apt->payment_status == 'DONE') {
				$data['total_paid']++;
				$data['total_fee'] += $fee;
			} else {
				$data['total_unpaid']++;
			}
		}

		$this->load->view('hospitalpanel/doctorappointment', $data);
	}
	
	
	
	public function manageappointment()
	{
		$userid                 =  $this->did;
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 15;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['appointments'] 	=  $this->Hospital_Model->get_appointment($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	= 'Manage Appointments';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		
		// KPI Stats
		$data['total_count']     = $this->db->where(array('institute_id' => $userid, 'institution_type' => 'H', 'status !=' => '0'))->count_all_results('appointment');
		$data['today_count']     = $this->db->where(array('institute_id' => $userid, 'institution_type' => 'H', 'appointment_date' => date('Y-m-d'), 'status !=' => '0'))->count_all_results('appointment');
		$data['pending_count']   = $this->db->where(array('institute_id' => $userid, 'institution_type' => 'H', 'appointment_status' => '0', 'status !=' => '0'))->count_all_results('appointment');
		$data['completed_count'] = $this->db->where(array('institute_id' => $userid, 'institution_type' => 'H', 'appointment_status' => '1', 'status !=' => '0'))->count_all_results('appointment');
		$data['paid_count']      = $this->db->where(array('institute_id' => $userid, 'institution_type' => 'H', 'payment_status' => 'DONE', 'status !=' => '0'))->count_all_results('appointment');
		$data['unpaid_count']    = $this->db->where(array('institute_id' => $userid, 'institution_type' => 'H', 'payment_status' => 'UNPAID', 'status !=' => '0'))->count_all_results('appointment');

		// Doctors associated with this hospital
		$data['hospital_doctors'] = $this->db->select('profile_dr.id, profile_dr.fname, profile_dr.lname')
			->join('profile_dr', 'profile_dr.id = dr_practice.user_id')
			->get_where('dr_practice', array('institution_id' => $userid, 'type' => 'H'))
			->result();

		if( $this->input->post('status_action')!='')
		{			
			$this->Hospital_Model->update_status('appointment','appointment_id');			
		}
		$this->load->view('hospitalpanel/manageappointment',$data);
	}

	public function complete_appointment()
	{
		$aid = (int) $this->input->get('aid');
		$userid = $this->did;
		if ($aid > 0) {
			$this->db->where(array('appointment_id' => $aid, 'institute_id' => $userid, 'institution_type' => 'H'));
			$this->db->update('appointment', array(
				'appointment_status'    => '1',
				'appointment_by'        => $this->session->userdata('hosuserid'),
				'appointment_done_date' => date('Y-m-d H:i:s')
			));
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Appointment #$aid marked as Completed / Visited.</div>");
		}
		redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'hospitalpanel/manageappointment');
	}

	public function mark_paid()
	{
		$aid = (int) $this->input->get('aid');
		$userid = $this->did;
		if ($aid > 0) {
			$this->db->where(array('appointment_id' => $aid, 'institute_id' => $userid, 'institution_type' => 'H'));
			$this->db->update('appointment', array('payment_status' => 'DONE'));
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Payment for Appointment #$aid marked as Paid.</div>");
		}
		redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'hospitalpanel/manageappointment');
	}
	
	public function package()
	{
		$userid     = $this->did;
		$hosuid     = $this->session->userdata('hosuserid');
		$keyword    = $this->input->get_post('keyword', TRUE);
		$date_from  = $this->input->get_post('date_from', TRUE);
		$date_to    = $this->input->get_post('date_to', TRUE);
		$status     = $this->input->get_post('status');

		$this->db->group_start();
		$this->db->where('hospital_id', $userid);
		if (!empty($hosuid)) {
			$this->db->or_where('hospital_id', $hosuid);
		}
		$this->db->group_end();

		if (!empty($keyword)) {
			$this->db->like('title', $keyword);
		}
		if (!empty($date_from)) {
			$this->db->where('creat_date >=', $date_from);
		}
		if (!empty($date_to)) {
			$this->db->where('creat_date <=', $date_to);
		}
		if ($status !== '' && $status !== null && in_array($status, array('0', '1'))) {
			$this->db->where('status', $status);
		}

		$data['packages']     = $this->db->order_by('package_id', 'DESC')->get('package')->result();
		$data['total_count']  = count($data['packages']);
		$data['active_count'] = $this->db->group_start()->where('hospital_id', $userid)->or_where('hospital_id', $hosuid)->group_end()->where('status', '1')->count_all_results('package');

		$this->load->view('hospitalpanel/managepackage', $data);
	}

	public function addpackage()
	{
		$userid = $this->did;
		if ($this->input->post()) {
			$this->form_validation->set_rules('title', 'Package Title', 'trim|required');
			$this->form_validation->set_rules('amount', 'Package Amount', 'trim|required|numeric');

			if ($this->form_validation->run() === TRUE) {
				$image = '';
				if (!empty($_FILES['image']['name'])) {
					$config['upload_path']   = './admin1947/public/assets/upload/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
					$config['max_size']      = 5120;
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('image')) {
						$upload_data = $this->upload->data();
						$image = $upload_data['file_name'];
					}
				}

				$insert_data = array(
					'hospital_id' => $userid,
					'title'       => trim($this->input->post('title', TRUE)),
					'amount'      => trim($this->input->post('amount', TRUE)),
					'description' => trim($this->input->post('description', TRUE)),
					'video_url'   => trim($this->input->post('video_url', TRUE)),
					'image'       => $image,
					'status'      => $this->input->post('status') !== null ? $this->input->post('status') : '1',
					'approved'    => '1',
					'creat_date'  => date('Y-m-d H:i:s')
				);

				$this->db->insert('package', $insert_data);
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Health Checkup Package created successfully!</div>");
				redirect('hospitalpanel/package');
			}
		}
		$this->load->view('hospitalpanel/addpackage');
	}

	public function editpackage($id = 0)
	{
		$userid = $this->did;
		$id = intval($id);
		$package = $this->db->get_where('package', array('package_id' => $id, 'hospital_id' => $userid))->row_array();

		if (!$package) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Package not found.</div>");
			redirect('hospitalpanel/package');
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('title', 'Package Title', 'trim|required');
			$this->form_validation->set_rules('amount', 'Package Amount', 'trim|required|numeric');

			if ($this->form_validation->run() === TRUE) {
				$image = $package['image'];
				if (!empty($_FILES['image']['name'])) {
					$config['upload_path']   = './admin1947/public/assets/upload/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
					$config['max_size']      = 5120;
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('image')) {
						$upload_data = $this->upload->data();
						$image = $upload_data['file_name'];
					}
				}

				$update_data = array(
					'title'       => trim($this->input->post('title', TRUE)),
					'amount'      => trim($this->input->post('amount', TRUE)),
					'description' => trim($this->input->post('description', TRUE)),
					'video_url'   => trim($this->input->post('video_url', TRUE)),
					'image'       => $image,
					'status'      => $this->input->post('status') !== null ? $this->input->post('status') : $package['status']
				);

				$this->db->where(array('package_id' => $id, 'hospital_id' => $userid))->update('package', $update_data);
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Health Checkup Package updated successfully!</div>");
				redirect('hospitalpanel/package');
			}
		}

		$data['package'] = $package;
		$this->load->view('hospitalpanel/editpackage', $data);
	}

	public function delete_package($id = 0)
	{
		$userid = $this->did;
		$id = intval($id);
		if ($id > 0) {
			$this->db->where(array('package_id' => $id, 'hospital_id' => $userid))->delete('package');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Package deleted successfully.</div>");
		}
		redirect('hospitalpanel/package');
	}
	
	public function bed()
	{
		$userid     = $this->did;
		$hosuid     = $this->session->userdata('hosuserid');
		$keyword    = $this->input->get_post('keyword', TRUE);
		$date_from  = $this->input->get_post('date_from', TRUE);
		$date_to    = $this->input->get_post('date_to', TRUE);
		$status     = $this->input->get_post('status');

		$this->db->group_start();
		$this->db->where('hospital_id', $userid);
		if (!empty($hosuid)) {
			$this->db->or_where('hospital_id', $hosuid);
		}
		$this->db->group_end();

		if (!empty($keyword)) {
			$this->db->like('bed_type', $keyword);
		}
		if (!empty($date_from)) {
			$this->db->where('creat_date >=', $date_from);
		}
		if (!empty($date_to)) {
			$this->db->where('creat_date <=', $date_to);
		}
		if ($status !== '' && $status !== null && in_array($status, array('0', '1'))) {
			$this->db->where('status', $status);
		}

		$beds = $this->db->order_by('hospital_bed_id', 'DESC')->get('hospital_bed')->result();

		$total_capacity = 0;
		$total_occupied = 0;
		foreach ($beds as $b) {
			$total_capacity += (int)$b->total_bed;
			$total_occupied += (int)$b->occupied_bed;
		}

		$data['beds']            = $beds;
		$data['total_capacity']  = $total_capacity;
		$data['total_occupied']  = $total_occupied;
		$data['total_available'] = max(0, $total_capacity - $total_occupied);
		$data['total_types']     = count($beds);

		$this->load->view('hospitalpanel/managebed', $data);
	}
	
	public function addbed()
	{
		$userid = $this->did;
		if ($this->input->post()) {
			$this->form_validation->set_rules('bed_type', 'Bed Type / Category', 'trim|required');
			$this->form_validation->set_rules('total_bed', 'Total Bed Count', 'trim|required|numeric');
			$this->form_validation->set_rules('occupied_bed', 'Occupied Bed Count', 'trim|numeric');
			$this->form_validation->set_rules('amount', 'Daily Room Charge', 'trim|required|numeric');
			
			if ($this->form_validation->run() === TRUE) {
				$insert_data = array(
					'hospital_id'  => $userid,
					'bed_type'     => trim($this->input->post('bed_type', TRUE)),
					'total_bed'    => intval($this->input->post('total_bed')),
					'occupied_bed' => intval($this->input->post('occupied_bed')),
					'amount'       => floatval($this->input->post('amount')),
					'comment'      => trim($this->input->post('comment', TRUE)),
					'status'       => $this->input->post('status') !== null ? $this->input->post('status') : '1',
					'creat_date'   => date('Y-m-d H:i:s'),
					'created_by'   => intval($this->session->userdata('hosuserid'))
				);

				$this->db->insert('hospital_bed', $insert_data);
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Bed / Ward setup category added successfully!</div>");
				redirect('hospitalpanel/bed');
			}
		}
		$this->load->view('hospitalpanel/addbed');
	}
	
	public function editbed($id = 0)
	{
		$userid = $this->did;
		$hosuid = $this->session->userdata('hosuserid');
		$id = intval($id);
		
		$bed = $this->db->where('hospital_bed_id', $id)
			->group_start()->where('hospital_id', $userid)->or_where('hospital_id', $hosuid)->group_end()
			->get('hospital_bed')
			->row_array();

		if (!$bed) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Bed category not found.</div>");
			redirect('hospitalpanel/bed');
		}

		if ($this->input->post()) {
			$this->form_validation->set_rules('bed_type', 'Bed Type / Category', 'trim|required');
			$this->form_validation->set_rules('total_bed', 'Total Bed Count', 'trim|required|numeric');
			$this->form_validation->set_rules('occupied_bed', 'Occupied Bed Count', 'trim|numeric');
			$this->form_validation->set_rules('amount', 'Daily Room Charge', 'trim|required|numeric');
			
			if ($this->form_validation->run() === TRUE) {
				$update_data = array(
					'bed_type'      => trim($this->input->post('bed_type', TRUE)),
					'total_bed'     => intval($this->input->post('total_bed')),
					'occupied_bed'  => intval($this->input->post('occupied_bed')),
					'amount'        => floatval($this->input->post('amount')),
					'comment'       => trim($this->input->post('comment', TRUE)),
					'status'        => $this->input->post('status') !== null ? $this->input->post('status') : $bed['status'],
					'modified_date' => time(),
					'modified_by'   => date('Y-m-d H:i:s')
				);

				$this->db->where('hospital_bed_id', $id)->update('hospital_bed', $update_data);
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Bed category updated successfully!</div>");
				redirect('hospitalpanel/bed');
			}
		}

		$data['bed'] = $bed;
		$data['row'] = $bed;
		$this->load->view('hospitalpanel/editbed', $data);
	}

	public function delete_bed($id = 0)
	{
		$userid = $this->did;
		$hosuid = $this->session->userdata('hosuserid');
		$id = intval($id);
		if ($id > 0) {
			$this->db->where('hospital_bed_id', $id)
				->group_start()->where('hospital_id', $userid)->or_where('hospital_id', $hosuid)->group_end()
				->delete('hospital_bed');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Bed category deleted successfully.</div>");
		}
		redirect('hospitalpanel/bed');
	}
	

	
	public function file_check($file,$type)
	{	
		if($_FILES['uploadimage']['name']!="")
		{
			$exts = explode(',',$type);
			//is $type array? run self recursively
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
			
			foreach ($ext_groups as $key => $val) 
			{
				if($key==$exts[0])
				{	
					$exts	= $val;
				}
			}
			//get file ext
			$file_ext = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);  
			if ( ! in_array($file_ext, $exts))
			{
				$exts_allowed=implode(" | ",$exts);
				$this->form_validation->set_message('file_check', "File should be ". $exts_allowed);
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
    }
	public function addappointment()
	{
		$userid = $this->did;

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$doctor_id          = (int) $this->input->post('doctor_id');
			$appointment_date   = $this->input->post('appointment_date');
			$time_slot          = $this->input->post('time_slot');
			$patient_name       = trim($this->input->post('patient_name'));
			$patient_mobile     = trim($this->input->post('patient_mobile'));
			$patient_email      = trim($this->input->post('patient_email'));
			$patient_gender     = $this->input->post('patient_gender');
			$patient_age        = $this->input->post('patient_age');
			$fee                = (float) $this->input->post('fee');
			$payment_mode       = $this->input->post('payment_mode') ? $this->input->post('payment_mode') : 'CASH';
			$payment_status     = $this->input->post('payment_status') ? $this->input->post('payment_status') : 'DONE';
			$appointment_status = $this->input->post('appointment_status') !== null ? $this->input->post('appointment_status') : '0';

			if (empty($doctor_id) || empty($patient_name) || empty($patient_mobile)) {
				$msg = "Please select a Doctor and provide Patient Name and valid 10-digit Mobile Number.";
				if ($this->input->is_ajax_request()) {
					echo json_encode(array('status' => 'error', 'msg' => $msg));
					return;
				}
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>$msg</div>");
				redirect('hospitalpanel/addappointment');
				return;
			}

			// Ensure user exists in userlogin
			$user_row = $this->db->where('MOBILE', $patient_mobile)->get('userlogin')->row();
			if (!$user_row) {
				$name_parts = explode(' ', ucwords($patient_name), 2);
				$fname = $name_parts[0];
				$lname = isset($name_parts[1]) ? $name_parts[1] : '';

				$final_email = null;
				if (!empty($patient_email)) {
					$email_exists = $this->db->where('EMAIL', $patient_email)->count_all_results('userlogin');
					if ($email_exists == 0) {
						$final_email = $patient_email;
					}
				}

				$new_user = array(
					'FNAME'    => $fname,
					'LNAME'    => $lname,
					'MOBILE'   => $patient_mobile,
					'EMAIL'    => $final_email,
					'GENDER'   => (!empty($patient_gender) && in_array($patient_gender, array('M','F','O'))) ? $patient_gender : 'M',
					'STATUS'   => '1',
					'APPROVED' => '1',
					'REG_DATE' => date('Y-m-d H:i:s')
				);
				$this->db->insert('userlogin', $new_user);
				$patient_userid = $this->db->insert_id();
			} else {
				$patient_userid = $user_row->USERID;
			}

			// Practice & Fee details
			$practRow = $this->db->where(array('user_id' => $doctor_id, 'institution_id' => $userid, 'type' => 'H'))->get('dr_practice')->row();
			$practice_id = $practRow ? $practRow->id : 0;
			if ($fee <= 0 && $practRow && !empty($practRow->fee)) {
				$fee = (float) $practRow->fee;
			}
			if ($fee <= 0) {
				$fee = 500;
			}

			// Parse time slot
			$from_timing = '10:00 AM';
			$to_timing   = '01:00 PM';
			$time_id     = 0;
			$date_id     = 0;

			if (is_numeric($time_slot)) {
				$sessionRow = $this->db->get_where('timing_session', array('id' => $time_slot))->row();
				if ($sessionRow) {
					$time_id     = $sessionRow->id;
					$date_id     = $sessionRow->timing_id;
					$from_timing = $sessionRow->from_timing;
					$to_timing   = $sessionRow->to_timing;
				}
			} elseif (!empty($time_slot)) {
				$parts = explode('-', $time_slot);
				$from_timing = trim($parts[0]);
				$to_timing   = isset($parts[1]) ? trim($parts[1]) : '';
			}

			if (empty($appointment_date)) {
				$appointment_date = date('Y-m-d');
			}

			$insert_data = array(
				'appointment_date'    => $appointment_date,
				'appointment_time'    => $from_timing,
				'from_timing'         => $from_timing,
				'to_timing'           => $to_timing,
				'time_id'             => $time_id,
				'date_id'             => $date_id,
				'practice_id'         => $practice_id,
				'appointment_name'    => $patient_name,
				'appointment_mobile'  => $patient_mobile,
				'appointment_email'   => $patient_email,
				'age'                 => $patient_age,
				'doctor_id'           => $doctor_id,
				'institute_id'        => $userid,
				'institution_type'    => 'H',
				'fee'                 => $fee,
				'amount'              => $fee,
				'user_id'             => $patient_userid,
				'payment_mode'        => $payment_mode,
				'payment_status'      => $payment_status,
				'appointment_status'  => $appointment_status,
				'status'              => '1',
				'appointment_by'      => $this->session->userdata('hosuserid'),
				'book_date'           => date('Y-m-d H:i:s'),
				'pay_date'            => date('Y-m-d H:i:s')
			);

			$this->db->insert('appointment', $insert_data);
			$new_aid = $this->db->insert_id();

			$doc = $this->db->where('id', $doctor_id)->get('profile_dr')->row();
			$doc_name = $doc ? prefixdr($doc->fname).' '.$doc->lname : 'Doctor';

			$success_msg = "OPD Appointment #$new_aid booked successfully for $patient_name with $doc_name.";

			if ($this->input->is_ajax_request()) {
				echo json_encode(array(
					'status'         => 'success',
					'msg'            => $success_msg,
					'appointment_id' => $new_aid,
					'redirect'       => base_url('hospitalpanel/manageappointment')
				));
				return;
			}

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $success_msg</div>");
			redirect('hospitalpanel/manageappointment');
			return;
		}

		$data['doctors'] = $this->db->select('profile_dr.*, dr_practice.fee as practice_fee, dr_practice.id as practice_id')
			->join('dr_practice', 'dr_practice.user_id = profile_dr.id')
			->where(array('dr_practice.institution_id' => $userid, 'dr_practice.type' => 'H'))
			->get('profile_dr')
			->result();
		
		$data['clinic'] = $data['doctors'];
		$data['data']   = $this->db->get_where('hospital', array('id' => $userid))->row();

		$this->load->view('hospitalpanel/addappointment', $data);
	}

	public function get_doctor_fee()
	{
		$drid = (int) $this->input->get_post('doctor_id');
		$userid = $this->did;
		$practRow = $this->db->where(array('user_id' => $drid, 'institution_id' => $userid, 'type' => 'H'))->get('dr_practice')->row();
		$fee = ($practRow && !empty($practRow->fee)) ? $practRow->fee : 500;
		echo json_encode(array('status' => 'success', 'fee' => $fee));
	}


	public function adddoctor()
	{
		if(isset($_POST['submit']))
			$this->Hospital_Model->profile_step1();
		
		$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();			
		/* $data_spl=$this->db->select('specialization_id')->get_where('dr_specialization',array('user_id'=>$this->did))->result_array();
		$data['data_spl']= array_map (function($value){
					return $value['specialization_id'];
				} , $data_spl);	 */	
		$this->load->view('hospitalpanel/adddoctor',$data);
	}
	
	
	
	public function checkdoctor(){
		$key = strtolower($this->input->post('key'));
		$this -> db -> select(' * ');
        //$this -> db -> from('hospitallogin');
        $this -> db -> where('email', $key);        
		$this -> db -> or_where('mobile', $key);
		
		$d=$this->db->get_where('profile_dr',array())->row();
		 if($d){
			$drarray=array();
			$drarray['drid']=$d->id;
			$drarray['gender']=$d->gender;
			$drarray['city']=$d->city;
			$drarray['regd_no']=$d->regd_no;
			$drarray['regd_council']=$d->regd_council;
			$drarray['regd_year']=$d->regd_year;
			$drarray['college']=$d->college;
			$drarray['year']=$d->year;
			$drarray['exp']=$d->exp;
			$drarray['email']=$d->email;
			$drarray['mobile']=$d->mobile;
			$drarray['name']=$d->fname.' '.$d->lname;
			$drarray['image']=admin_url().'public/assets/upload/'.$d->drimage;
			
			
			$quastring=array();
			$qu=$this->db->get_where('dr_qualifications',array('user_id'=>$d->id));
			foreach(@$qu->result() as $q)
				$quastring[]=($q->qualification_id);
			
			$splstring=array(); 
			$sp=$this->db->get_where('dr_specialization',array('user_id'=>$d->id))->result();
			foreach($sp as $s)
				$splstring[]=($s->specialization_id);
			
			$drarray['specialization']=$splstring;			
			$drarray['qualification']=$quastring;			
			$drarray['experience']=$d->exp;
			
			
		 $response=array('status'=>'success','msg'=>'Doctor Detail Successfully Listed','data'=>$drarray);
		 
		echo json_encode($response); 
		
	}else{	
	$response=array('status'=>'failed','msg'=>'');
		echo json_encode($response); 
	}
		
		
	}
	
	public function linkdoctor()
	{
		$already	=$this->input->post('link');
		$drid		=$this->input->post('link2');
		if($already==1 && $drid!='')
		{
			$result=$this->db->where(array('type'=>'H','institution_id'=>$this->did,'user_id'=>$drid))->get('dr_practice');
			$count=$result->num_rows();
			if($count)
			{
				$practiceid=$result->row()->id;
				$response=array('status'=>'Alert','msg'=>'Doctor Profile Already Linked to the Hospital!');
				
			}
			else
			{
				$udata=array('institution_id'=>$this->did,'user_id'=>$drid,'type'=>'H','status'=>'0');
				$this->db->insert('dr_practice',$udata);
				$practiceid=$this->db->insert_id();
				//email to dr to approve link 
				$data=$this->db->get_where('profile_dr',array('id'=>$drid))->row();
				$this->load->library('azad_lib');
				$body="Request from  abcd hospital for profile approval   ".base_url().'home/securepapproval/'.mybase64_encode($practiceid).'/'.mybase64_encode($drid).'';
				$this->azad_lib->sendMail($data->email,'Request from  UPCHAR hospital for profile approval',$body);
				$response=array('status'=>'Success','msg'=>'Doctor Profile Linked to the Hospital Successfully!');
			
			}
	   }
	   else
	   {
			$email			=strtolower(trim($this->input->post('email')));
			$mobile			=trim($this->input->post('mobile'));
			$countemail		=$this->db->where('EMAIL',$email)->count_all_results('hospitallogin');
			$countmobile	=$this->db->where('MOBILE',$mobile)->count_all_results('hospitallogin');
			if($countemail > 0  && $email!='')
			{
				$response=array('status'=>'failed','msg'=>'Email Id Already Registered ! ');
			}
			else if($countmobile > 0 && $mobile!='')
			{
				$response=array('status'=>'failed','msg'=>'Mobile No. Already Registered ! ');
			}
			else if($mobile!='' || $email!='')
			{
				$fullname=$this->input->post('name');
				$name=explode(' ',ucwords($fullname));
				$fname=$name[0];
				$lname=@$name[1];
				$otp=rand(100000,999999);
				$pass=md5($otp);
			
				$udata=array(
							'PASSWORD'=>$pass,
							'FNAME'=>$fname,
							'LNAME'=>$lname,
							'STATUS'=>'0',
							'APPROVED'=>'1',
							'OTP'=>$otp,
							'REG_DATE'=>date('Y-m-d'),
							'GENDER'=>'M'
							); 
				if($email)
				$udata['EMAIL']=$email;
				if($mobile)
				$udata['MOBILE']=$mobile;
				if($this->db->insert('doctorlogin',$udata))
				{   
					$thisid = $this->db->insert_id();
					$udata=array(
								'email'	=>$this->input->post('email'),
								'mobile'=>$this->input->post('mobile'),
								'fname'=>$this->input->post('name'),
								'gender'=>$this->input->post('gender'),
								'city'=>$this->input->post('city'),
								'regd_no'=>$this->input->post('regno'),
								'regd_council'=>$this->input->post('council'),
								'regd_year'=>$this->input->post('ryear'),
								'college'=>$this->input->post('college'),
								'exp'=>$this->input->post('exp'),
								'year'=>$this->input->post('year'),
								'user_id'=>$thisid
								);
					$this->db->insert('profile_dr',$udata);
					$drid=$this->db->insert_id();
					$specialisation = $this->input->post('specialisation');
					foreach($specialisation as $s)
					{
						$spldata[]=array('user_id'=>$drid,'specialization_id'=>$s);
					}
					$qualification =$this->input->post('qualification');
					foreach($qualification as $q)
					{
						$qualdata[]=array('user_id'=>$drid,'qualification_id'=>$q);
					}
					$this->db->insert_batch('dr_qualifications',$qualdata);
					$this->db->insert_batch('dr_specialization',$spldata);
			
					$udata=array(
								'institution_id'=>$this->did,
								'user_id'=>$drid,
								'type'=>'H',
								'status'=>'0'
								);
					$this->db->insert('dr_practice',$udata);
					$practiceid=$this->db->insert_id();
					//email to dr to claim approve link with login
					$this->load->library('azad_lib');
					$body="Request from  abcd hospital for profile approval <BR>   Login: $mobile / $otp  ".base_url().'home/securepapproval/'.mybase64_encode($practiceid).'/'.mybase64_encode($drid).'';
					$this->azad_lib->sendMail($email,'Request from  abcd hospital for profile approval',$body);
					/* $msg="Dear ".$name[0].", Wecome to Upcharr medical solutions. Your otp is $otp
					thank you for being a part of Upchar.";
					sendsms($msg,$mobile); */
					$response=array('status'=>'success','msg'=>'Created new Doctor Profile & Linked Successfully!');
				}
				else
				{
					$response=array('status'=>'failed','msg'=>'Failed to create new Doctor Profile ! ');
				}
			
			}
		}
		// echo json_encode($response);
		$flashmsg=$response;//'Updated Successfully!';
		$this->session->set_flashdata('flashmsg',$flashmsg);
		redirect(base_url().'hospitalpanel/doctorlist');
	}
	
	public function unlinkdoctor()
	{
		$already=$this->input->post('link');
		$drid=$this->input->post('link2');
	   
		if($already==1 && $drid!='')
		{
		   
			$result=$this->db->where(array('type'=>'H','institution_id'=>$this->did,'user_id'=>$drid))->delete('dr_practice');
			if($result)
			{
				$response=array('status'=>'Alert','msg'=>'Doctor Profile UnLinked from the Hospital!');
			}
			else
			{
				 $response=array('status'=>'Opps','msg'=>'Something went wrong');
			}
		}
		else
		{
		   $response=array('status'=>'Opps','msg'=>'Something went wrong');
		}
	    $flashmsg=$response;//'Updated Successfully!';
		$this->session->set_flashdata('flashmsg',$flashmsg);
		redirect(base_url().'hospitalpanel/doctorlist');
	}
	
	public function updatedoctor($encoded_id = null)
	{	
		if (empty($encoded_id)) {
			$encoded_id = $this->uri->segment(3);
		}
		$did = mybase64_decode($encoded_id);

		if ($this->input->post('submit')) {
			$this->Hospital_Model->profile_consultant_fee();
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> Doctor consulting fees and practice timings updated successfully.</div>");
			redirect('hospitalpanel/managedoctor');
			return;
		}

		$doctor = $this->db->where('id', $did)->or_where('user_id', $did)->get('profile_dr')->row();
		$doc_id = $doctor ? $doctor->id : $did;
		$doc_uid = $doctor ? $doctor->user_id : $did;

		$practice = $this->db->where('type', 'H')
			->where('institution_id', $this->did)
			->group_start()->where('user_id', $doc_id)->or_where('user_id', $doc_uid)->group_end()
			->get('dr_practice')
			->row();

		if (!$practice) {
			$practice = (object)[
				'id' => 0,
				'fee' => 0,
				'user_id' => $doc_id,
				'institution_id' => $this->did,
				'status' => 1
			];
		}

		$practice_id = isset($practice->id) ? $practice->id : 0;
		$timings = $this->db->where('practice_id', $practice_id)
			->group_start()->where('user_id', $doc_id)->or_where('user_id', $doc_uid)->group_end()
			->get('timing');

		$data['doctor']       = $doctor;
		$data['practice']     = $practice;
		$data['timing_count'] = $timings->num_rows();
		$data['timings']      = $timings->result();
		$data['did_encoded']  = $encoded_id;

		$this->load->view('hospitalpanel/profile_consultant_fee', $data);
	}

	public function deletetiming($id = '')
	{
		$tid = base64_decode($id);
		if ($tid) {
			$this->db->delete('timing_session', array('timing_id' => $tid));
			$this->db->delete('timing', array('id' => $tid));
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> Timing slot deleted successfully.</div>");
		redirect($_SERVER['HTTP_REFERER'] ?: base_url('hospitalpanel/managedoctor'));
	}

	public function test_mail(){
		$this->load->library('azad_lib');
		
		$body='qwertyuiopsdfghjklxcvbnm,rtyuiocvbndfghjbss fsd fadsfsdfads fsd fs fs f';
		$this->azad_lib->sendMail('azadhussain16@gmail.com','Request from  abcd hospital for profile approval',$body);
	}
	/**************************************************************/
	public function profile_consultant_fee()
	{
		$did=mybase64_decode($this->uri->segment(3));
		
		if(isset($_POST['submit']))
			$this->Hospital_Model->profile_step1();
		
		$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$did))->row();			
		$data_spl=$this->db->select('specialization_id')->get_where('dr_specialization',array('user_id'=>$did))->result_array();
		$data['data_spl']= array_map (function($value){
					return $value['specialization_id'];
				} , $data_spl);		
			
		$data_qua=$this->db->select('qualification_id')->get_where('dr_qualifications',array('user_id'=>$did))->result_array();
		$data['data_qua']= array_map (function($value){
					return $value['qualification_id'];
				} , $data_qua);	
		$this->load->view('hospitalpanel/updatedoctor',$data);
	}
	public function test(){
	   $this->load->library('azad_lib');
			$body='Request from  abcd hospital for profile approval';
			$this->azad_lib->sendMail('azadhussain16@gmail.com','Request from  abcd hospital for profile approval',$body);
   }
	
	public function updateprofile()
	{
		if(isset($_POST['submit']))
			$this->Hospital_Model->updateprofile();
		$data['data']=$this->db->get_where('hospital',array('id'=>($this->did)))->row();	
			$this->load->view('hospitalpanel/updateclinic',@$data);
		
	}
	
	
	public function profile_clinicproof()
	{
		
		if(isset($_POST['submit']))
			$this->Hospital_Model->profile_clinicproof();
		$data['src']=$this->db->select('med_reg_proof')->get_where('hospital',array('id'=>$this->did))->row('med_reg_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('hospitalpanel/profile_clinicproof',@$data);
	}
	
	public function profile_disppic()
	{
		if(isset($_POST['submit']))
			$this->Hospital_Model->profile_disppic();
		$data['src']=$this->db->select('drimage')->get_where('hospital',array('id'=>$this->did))->row('drimage');	
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('hospitalpanel/profile_disppic',$data);
	}
	
	
	public function profile_maplocation()
	{
		if(isset($_POST['submit']))
			$this->Hospital_Model->profile_maplocation();
		$data['data']=$this->db->get_where('hospital',array('id'=>($this->did)))->row();	
		$this->load->view('hospitalpanel/profile_maplocation',$data);
	}
	
	public function profile_clinic_timing()
	{
		if(isset($_POST['submit']))
			$this->Hospital_Model->profile_clinic_timing();
		$timings=$this->db->get_where('timing',array('user_id'=>$this->did,'user_type'=>'H'));
		$data['timing_count']=$timings->num_rows();
		$data['timings']=$timings->result();
		$this->load->view('hospitalpanel/profile_clinic_timing',$data);
	}
	
	
	
	
	
	/******************************************************************/
	public function progress_profile()
	{
		$this->load->view('hospitalpanel/milestone');
	}
	
	public function profile_step1()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step1();
		
		$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();			
		$data_spl=$this->db->select('specialization_id')->get_where('dr_specialization',array('user_id'=>$this->did))->result_array();
		$data['data_spl']= array_map (function($value){
					return $value['specialization_id'];
				} , $data_spl);		
		$this->load->view('hospitalpanel/profile_step1',$data);
	}
	
	public function profile_step2()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step2();
		$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();	
		$this->load->view('hospitalpanel/profile_step2',$data);
	}
	
	public function profile_step3()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step3();
		$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();	
		$data_qua=$this->db->select('qualification_id')->get_where('dr_qualifications',array('user_id'=>$this->did))->result_array();
		$data['data_qua']= array_map (function($value){
					return $value['qualification_id'];
				} , $data_qua);	
		$this->load->view('hospitalpanel/profile_step3',$data);
	}
	
	public function profile_drpic()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_drpic();
		$data['src']=$this->db->select('drimage')->get_where('profile_dr',array('user_id'=>$this->did))->row('drimage');	
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('hospitalpanel/profile_drpic',$data);
	}
	public function profile_idproof()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_idproof();
		
		$data['src']=$this->db->select('id_proof')->get_where('profile_dr',array('user_id'=>$this->did))->row('id_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('hospitalpanel/profile_idproof',$data);
	}
	
	public function profile_regproof()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_regproof();
		
		$data['src']=$this->db->select('med_reg_proof')->get_where('profile_dr',array('user_id'=>$this->did))->row('med_reg_proof');
		if($data['src']=='')
			$data['imagerequired']='required';
		$this->load->view('hospitalpanel/profile_regproof',$data);
	}
	
	public function profile_step4()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step4();
		
		$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();	
		$this->load->view('hospitalpanel/profile_step4',$data);
	}
	
	
	public function addclinic()
	{
		if(isset($_POST['submit']))
		{
			$data['suggestedclinic'] = $this->Doctor_Model->addclinic();
			$this->load->view('hospitalpanel/clinic_sugestion',$data);
		}else
		{
			//select clinic if any one there own clinic 
			//$data['data']=$this->db->get_where('clinic',array('user_id'=>$this->did))->row();	
			$this->load->view('hospitalpanel/addclinic',@$data);
		}
	}
	
	
	public function addpractice()
	{
		if(isset($_POST['submit']))
		{
			$return = $this->Doctor_Model->addpractice();
			$data['suggestedclinic'] = $return['C'];
			$data['suggestedhospital'] = $return['H'];
			$this->load->view('hospitalpanel/practice_sugestion',$data);
		}else
		{
			//select clinic if any one there own clinic 
			//$data['data']=$this->db->get_where('clinic',array('user_id'=>$this->did))->row();	
			$this->load->view('hospitalpanel/addpractice',@$data);
		}
	}
	
	
	public function linkpractice()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->linkpractice();
		
		//$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();	
		//$this->load->view('hospitalpanel/profile_step4',$data);
	}
	
	public function profile_step6()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step6();
		
		//$data['data']=$this->db->get_where('profile_dr',array('user_id'=>$this->did))->row();	
		//$this->load->view('hospitalpanel/profile_step4',$data);
	}
	
	
	public function progress_profile2()
	{
		$this->load->view('hospitalpanel/milestone2');
	}
	
	public function progress_profile3()
	{
		$this->load->view('hospitalpanel/milestone3');
	}
	
	
	public function updateclinic()
	{
		$clinicid=$this->uri->segment(2);
		if(isset($_POST['submit']))
			$this->Doctor_Model->updateclinic();
		$data['data']=$this->db->get_where('clinic',array('id'=>mybase64_decode($clinicid)))->row();	
		$this->load->view('hospitalpanel/updateclinic',$data);
	}
	
	
	
	public function progress_profile4()
	{
		$this->load->view('hospitalpanel/milestone4');
	}
	
	
	public function manageownclinic()
	{
		if(isset($_POST['submit']))
			$this->Doctor_Model->profile_step2();
		$data['data']=$this->db->select('clinic.*,clinic_claimed.status as claim_status')->join('clinic','clinic.id=clinic_claimed.clinic_id')->get_where('clinic_claimed',array('did'=>$this->did))->result();	
		$this->load->view('hospitalpanel/manageownclinic',$data);
	}
	
	
	
	
	
	
	
	
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
	
	public function hospitals()
	{
		$this->load->view('hospital_list');
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
	
	
	      public function doctorid()
	       {
	      
	      $data['clinic']=$this->db->select('profile_dr.*,dr_practice.status as p_status')->join('profile_dr','profile_dr.id=dr_practice.user_id')->get_where('dr_practice',array('institution_id'=>$this->did,'type'=>'H'))->result();	
			

          //print_r($data);
       
	  $this->load->view('hospitalpanel/doctorid',$data);     

		    
		}
   public function change_password()
          {
             
              
             if($this->input->post('change_pass'))
		{
		$cur_password = md5($this->input->post('password'));
        $new_password = md5($this->input->post('newpass'));
        $conf_password = md5($this->input->post('confpassword'));
        $id=$this->session->userdata('hosuserid');

        $passwd = $this->Hospital_Model->change_password($id);
        if($passwd->PASSWORD == $cur_password)
        {
            if($new_password == $conf_password)
            {
                if($this->Hospital_Model->updatePassword($new_password, $id))
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


				
           $this->load->view('hospitalpanel/change_password');
           
       }
	   
	   
	public function gallery()
	{	
		if(isset($_POST['submit']))
		{	
			$uploadimage='';
			//$id=base64_decode($this->input->post('id'));
			$uploadimage=$_FILES['uploadimage']['name'];
			$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
    
			if($uploadimage != '') 
			{	
				$typename = 'type';
				$rname=rand(1111111,999999999);
				$date=date('Y-m-d');
				$uploadimage=$typename.'_profile_pic_'.$rname.$date.'.'.$extsign;
				$config['upload_path']          = './admin1947/public/assets/upload/';
				$config['allowed_types'] 		= 	'jpg|png|jpeg|JPG|PNG|JPEG';
				$config['max_size']             = 2048;
				$config['quality'] 				= '60%';
				$config['file_name']  			= $uploadimage;
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('uploadimage'))
				{
					$error = $this->upload->display_errors();
					$flashmsg='<div class="alert alert-danger">
					<strong>Failed!</strong>'.$error.'
					</div>';
					$this->session->set_flashdata('flashmsg',$flashmsg);
					redirect(base_url().'hospitalpanel/gallery');
					exit();
				}
				if($this->Hospital_Model->gallery($uploadimage)) 
				{
					$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
					$this->session->set_flashdata('flashmsg',$msg);
					
				
				}
				else
				{
					$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
					$this->session->set_flashdata('flashmsg',$msg);
				}
			}
		}
	    $this->load->view('hospitalpanel/gallery');
	}
	
	public function managegallery()
	{ 	
		$hospital_id = $this->did;
		$hosuid      = $this->session->userdata('hosuserid');
		$data['gallery'] = $this->db->group_start()->where('uid', $hospital_id)->or_where('uid', $hosuid)->group_end()->order_by('id', 'DESC')->get('hospitalgallery')->result_array();	
		$this->load->view('hospitalpanel/managegallery', $data);
	}

	public function delete_gallery($id = 0)
	{
		$hospital_id = $this->did;
		$hosuid      = $this->session->userdata('hosuserid');
		$id          = intval($id);

		if ($id > 0) {
			$this->db->where('id', $id)
				->group_start()->where('uid', $hospital_id)->or_where('uid', $hosuid)->group_end()
				->delete('hospitalgallery');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Gallery item deleted successfully.</div>");
		}
		redirect('hospitalpanel/managegallery');
	}

	public function news()
	{
		if(isset($_POST['submit']))
		{
			$uploadimage='';
			$uploadimage=$_FILES['uploadimage']['name'];
			$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
			if($this->input->post('type')==1) 
			{ 
				if($uploadimage != '') 
				{	
					$typename='type';
					$rname=rand(1111111,999999999);
					$date=date('Y-m-d');
					$uploadimage=$typename.'_profile_pic_'.$rname.$date.'.'.$extsign;
					$config['upload_path']          = './admin1947/public/assets/upload/';
					$config['allowed_types'] 		= 	'jpg|png|jpeg|JPG|PNG|JPEG';
					$config['max_size']             = 2048;
					$config['quality'] 				= '60%';
					$config['file_name']  			= $uploadimage;
					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload('uploadimage'))
					{
						$error = $this->upload->display_errors();
						$flashmsg='<div class="alert alert-danger">
						  <strong>Failed!</strong>'.$error.'
						</div>';
						$this->session->set_flashdata('flashmsg',$flashmsg);
						redirect(base_url().'hospitalpanel/news');
						exit();
					}
					if($this->Hospital_Model->add_news($uploadimage)) 
					{
						$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
						$this->session->set_flashdata('flashmsg',$msg);
						redirect(base_url().'hospitalpanel/managenews');
						exit();
					}
					else
					{
						$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
						$this->session->set_flashdata('flashmsg',$msg);
					}
				}
			}
			else if($this->input->post('type')==2)
			{
				if($this->Hospital_Model->add_news()) 
				{
					$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
					$this->session->set_flashdata('flashmsg',$msg);
					redirect(base_url().'hospitalpanel/managenews');
					exit();
				}
				else
				{
					$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
					$this->session->set_flashdata('flashmsg',$msg);
				}
			}
        }           
	    $this->load->view('hospitalpanel/news');
	}

	public function managenews()
	{ 	
		$hospital_id = $this->did;
		$hosuid      = $this->session->userdata('hosuserid');
		$data['news'] = $this->db->group_start()->where('hospital_id', $hospital_id)->or_where('hospital_id', $hosuid)->group_end()->order_by('id', 'DESC')->get('news')->result_array();	
		$this->load->view('hospitalpanel/managenews', $data);
	}

	public function delete_news($id = 0)
	{
		$hospital_id = $this->did;
		$hosuid      = $this->session->userdata('hosuserid');
		$id          = intval($id);

		if ($id > 0) {
			$this->db->where('id', $id)
				->group_start()->where('hospital_id', $hospital_id)->or_where('hospital_id', $hosuid)->group_end()
				->delete('news');
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>News item deleted successfully.</div>");
		}
		redirect('hospitalpanel/managenews');
	}

	   
    public function biomedical()
	{
		$data['data'] = $this->db->get('biomedical')->result();
		$this->load->view('hospitalpanel/biomedical',$data);
	}

	public function bed_matrix()
	{
		$hospital_id = $this->did;
		$hosuid      = $this->session->userdata('hosuserid');
		$data['hospital'] = $this->db->where('id', $hospital_id)->or_where('uid', $hosuid)->get('hospital')->row();
		$data['beds'] = $this->db->group_start()->where('hospital_id', $hospital_id)->or_where('hospital_id', $hosuid)->group_end()->order_by('hospital_bed_id', 'DESC')->get('hospital_bed')->result();
		
		// Summary statistics across all wards
		$total_capacity = 0;
		$total_occupied = 0;
		
		foreach ($data['beds'] as $bed) {
			$total_capacity += (int)$bed->total_bed;
			$total_occupied += (int)$bed->occupied_bed;
		}

		$data['total_beds']        = $total_capacity;
		$data['occupied_beds']     = $total_occupied;
		$data['vacant_beds']       = max(0, $total_capacity - $total_occupied);
		$data['maintenance_beds']  = 0;
		$data['total_types']       = count($data['beds']);

		$this->load->view('hospitalpanel/bed_matrix', $data);
	}

	public function admissions()
	{
		$hospital_id = $this->did;
		$data['admissions'] = $this->db->select('hospital_admissions.*, userlogin.FNAME as patient_fname, userlogin.LNAME as patient_lname, userlogin.MOBILE as patient_mobile, profile_dr.fname as dr_fname, profile_dr.lname as dr_lname, hospital_bed.bed_type, hospital_bed.amount as bed_amount')
			->from('hospital_admissions')
			->join('userlogin', 'userlogin.USERID = hospital_admissions.patient_id', 'left')
			->join('profile_dr', 'profile_dr.id = hospital_admissions.attending_doctor_id', 'left')
			->join('hospital_bed', 'hospital_bed.hospital_bed_id = hospital_admissions.bed_id', 'left')
			->where('hospital_admissions.hospital_id', $hospital_id)
			->order_by('hospital_admissions.id', 'DESC')
			->get()
			->result();

		$data['vacant_beds'] = $this->db->get_where('hospital_bed', array('hospital_id' => $hospital_id, 'status' => '1'))->result();
		$data['doctors'] = $this->db->select('profile_dr.*')
			->from('dr_practice')
			->join('profile_dr', 'profile_dr.id = dr_practice.user_id')
			->where(array('dr_practice.institution_id' => $hospital_id, 'dr_practice.type' => 'H', 'dr_practice.status' => '1'))
			->get()
			->result();

		$this->load->view('hospitalpanel/admissions', $data);
	}

	public function admit_patient()
	{
		$hospital_id               = $this->did;
		$patient_name              = trim($this->input->post('patient_name', TRUE));
		$patient_mobile            = trim($this->input->post('patient_mobile', TRUE));
		$bed_id                    = intval($this->input->post('bed_id'));
		$doctor_id                 = intval($this->input->post('doctor_id'));
		$admission_source          = $this->input->post('admission_source', TRUE) ?: 'SELF_ADMITTED';
		$ambulance_vehicle_no      = trim($this->input->post('ambulance_vehicle_no', TRUE));
		$emergency_driver_contact  = trim($this->input->post('emergency_driver_contact', TRUE));
		$upchar_dispatch_id        = trim($this->input->post('upchar_dispatch_id', TRUE));
		$emergency_contact_person  = trim($this->input->post('emergency_contact_person', TRUE));
		$emergency_contact_phone   = trim($this->input->post('emergency_contact_phone', TRUE));
		$reason                    = trim($this->input->post('reason', TRUE));
		$deposit                   = floatval($this->input->post('deposit_amount'));
		$tpa                       = trim($this->input->post('insurance_tpa', TRUE));
		$claim_no                  = trim($this->input->post('claim_number', TRUE));

		if (!empty($patient_mobile) && !empty($bed_id)) {
			// Find or create userlogin record
			$user = $this->db->get_where('userlogin', array('MOBILE' => $patient_mobile))->row();
			if (!$user) {
				$name_parts = explode(' ', $patient_name, 2);
				$this->db->insert('userlogin', array(
					'FNAME'    => $name_parts[0],
					'LNAME'    => isset($name_parts[1]) ? $name_parts[1] : '',
					'MOBILE'   => $patient_mobile,
					'STATUS'   => '1',
					'APPROVED' => '1',
					'REG_DATE' => date('Y-m-d H:i:s')
				));
				$patient_id = $this->db->insert_id();
			} else {
				$patient_id = $user->USERID;
			}

			$admission_no = 'IPD' . date('Ymd') . rand(100, 999);
			$this->db->insert('hospital_admissions', array(
				'hospital_id'              => $hospital_id,
				'patient_id'               => $patient_id,
				'attending_doctor_id'      => $doctor_id,
				'bed_id'                   => $bed_id,
				'admission_number'         => $admission_no,
				'admission_date'           => date('Y-m-d H:i:s'),
				'admission_reason'         => $reason,
				'admission_source'         => $admission_source,
				'ambulance_vehicle_no'     => $ambulance_vehicle_no,
				'emergency_driver_contact' => $emergency_driver_contact,
				'upchar_dispatch_id'       => $upchar_dispatch_id,
				'emergency_contact_person' => $emergency_contact_person,
				'emergency_contact_phone'  => $emergency_contact_phone,
				'deposit_amount'           => $deposit,
				'current_running_bill'     => $deposit,
				'insurance_tpa_name'       => $tpa,
				'insurance_claim_number'   => $claim_no,
				'status'                   => 'ADMITTED'
			));

			// Update bed occupied count
			$this->db->where('hospital_bed_id', $bed_id)->set('occupied_bed', 'occupied_bed + 1', FALSE)->update('hospital_bed');

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Patient admitted successfully! Admission #$admission_no (Source: ".str_replace('_', ' ', $admission_source).")</div>");
		}
		redirect('hospitalpanel/admissions');
	}

	public function discharge_patient()
	{
		$adm_id = intval($this->input->get_post('adm_id'));
		$hospital_id = $this->did;
		$admission = $this->db->get_where('hospital_admissions', array('id' => $adm_id, 'hospital_id' => $hospital_id))->row();

		if ($admission) {
			$this->db->where('id', $adm_id)->update('hospital_admissions', array(
				'discharge_date' => date('Y-m-d H:i:s'),
				'status'         => 'DISCHARGED'
			));

			// Free up bed count
			$this->db->where('hospital_bed_id', $admission->bed_id)->set('occupied_bed', 'GREATEST(0, CAST(occupied_bed AS SIGNED) - 1)', FALSE)->update('hospital_bed');

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Patient discharged successfully and bed count updated!</div>");
		}
		redirect('hospitalpanel/admissions');
	}

	public function earnings()
	{
		$hospital_id = $this->did;
		$hosuid      = $this->session->userdata('hosuserid');
		
		// 1. Fetch Hospital Record
		$hospital = $this->db->where('id', $hospital_id)->or_where('uid', $hosuid)->get('hospital')->row();
		$data['hospital'] = $hospital;
		$facility_id = ($hospital && isset($hospital->id)) ? $hospital->id : $hospital_id;

		// 2. Fetch Filters
		$filters = array(
			'date'           => trim($this->input->get('date') ?: ''),
			'month'          => trim($this->input->get('month') ?: ''),
			'year'           => trim($this->input->get('year') ?: ''),
			'status'         => trim($this->input->get('status') ?: 'all'),
			'payment_status' => trim($this->input->get('payment_status') ?: 'all'),
			'service_type'   => trim($this->input->get('service_type') ?: 'all'),
			'search'         => trim($this->input->get('search') ?: '')
		);
		$data['filters'] = $filters;

		// 3. Platform Settings & Commission Rate
		$commInfo = $this->Financial_Model->get_facility_commission_rate('hospital', $facility_id);
		$data['custom_rate'] = (float)($commInfo->rate ?? 10.00);
		$data['is_custom']   = $commInfo->is_custom ?? 0;
		$data['comm_notes']  = $commInfo->notes ?? '';
		$data['settings']    = $this->Financial_Model->get_platform_settings();

		// 4. Financial Summary Metrics
		$summary = $this->Financial_Model->get_facility_financial_summary('hospital', $facility_id, $filters);
		$data['summary'] = $summary;
		$data['metrics'] = $summary;

		// 5. Transactions
		$all_txns = $this->Financial_Model->get_facility_transactions('hospital', $facility_id, $filters);
		$data['transactions'] = $all_txns;
		$data['total_rows']   = count($all_txns);

		// 6. GST Invoices for Hospital
		$data['invoices'] = $this->db->where('facility_type', 'hospital')
			->where('facility_id', $facility_id)
			->order_by('invoice_id', 'DESC')
			->get('gst_invoices')
			->result();

		$this->load->view('hospitalpanel/earnings', $data);
	}

	public function export_earnings()
	{
		$hospital_id = $this->did;
		$hosuid      = $this->session->userdata('hosuserid');
		$hospital    = $this->db->where('id', $hospital_id)->or_where('uid', $hosuid)->get('hospital')->row();
		$facility_id = ($hospital && isset($hospital->id)) ? $hospital->id : $hospital_id;
		$hospName    = $hospital ? $hospital->name : 'Hospital';

		$filters = array(
			'date'           => trim($this->input->get('date') ?: ''),
			'month'          => trim($this->input->get('month') ?: ''),
			'year'           => trim($this->input->get('year') ?: ''),
			'status'         => trim($this->input->get('status') ?: 'all'),
			'payment_status' => trim($this->input->get('payment_status') ?: 'all'),
			'service_type'   => trim($this->input->get('service_type') ?: 'all'),
			'search'         => trim($this->input->get('search') ?: '')
		);

		$transactions = $this->Financial_Model->get_facility_transactions('hospital', $facility_id, $filters);
		$summary      = $this->Financial_Model->get_facility_financial_summary('hospital', $facility_id, $filters);

		$filename = "Upchar_" . preg_replace('/[^A-Za-z0-9_]/', '_', $hospName) . "_Revenue_Statement_" . date('Ymd_His') . ".csv";

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

		fputcsv($output, array("UPCHAR HEALTHCARE PLATFORM - REVENUE & SETTLEMENT STATEMENT"));
		fputcsv($output, array("Hospital Name:", $hospName));
		fputcsv($output, array("Generated Date:", date('d-M-Y H:i:s')));
		fputcsv($output, array("Total Encounters:", count($transactions)));
		fputcsv($output, array("Gross Revenue (INR):", number_format($summary->gross_revenue ?? 0, 2)));
		fputcsv($output, array("Upchar Platform Fees (INR):", number_format($summary->total_platform_fee ?? 0, 2)));
		fputcsv($output, array("GST on Fee (18%) (INR):", number_format($summary->total_gst ?? 0, 2)));
		fputcsv($output, array("Total Deductions (INR):", number_format($summary->total_deductions ?? 0, 2)));
		fputcsv($output, array("Net Hospital Payout (INR):", number_format($summary->net_hospital_share ?? 0, 2)));
		fputcsv($output, array("Settled Payouts (INR):", number_format($summary->settled_payouts ?? 0, 2)));
		fputcsv($output, array("Pending Payouts (INR):", number_format($summary->pending_payouts ?? 0, 2)));
		fputcsv($output, array(""));

		fputcsv($output, array(
			'Transaction ID',
			'Category',
			'Patient Name',
			'Patient Mobile',
			'Gross Bill Amount (INR)',
			'Platform Fee %',
			'Platform Fee (INR)',
			'GST 18% (INR)',
			'Total Deduction (INR)',
			'Net Hospital Share (INR)',
			'Payment Status',
			'Payout Status',
			'Settlement Date',
			'Created Date'
		));

		foreach ($transactions as $t) {
			fputcsv($output, array(
				$t->txn_code,
				$t->category,
				$t->patient_name ?: 'Patient',
				$t->patient_mobile ?: '',
				number_format((float)$t->gross_amount, 2, '.', ''),
				$t->platform_fee_percent . '%',
				number_format((float)$t->platform_fee_amount, 2, '.', ''),
				number_format((float)$t->gst_amount, 2, '.', ''),
				number_format((float)$t->total_platform_deduction, 2, '.', ''),
				number_format((float)$t->net_facility_share, 2, '.', ''),
				strtoupper($t->payment_status),
				strtoupper($t->payout_status),
				$t->settlement_date ? date('d-M-Y H:i', strtotime($t->settlement_date)) : 'Pending Settlement',
				date('d-M-Y H:i', strtotime($t->created_at))
			));
		}

		fclose($output);
		exit();
	}

	public function invoice_view($invoice_id = 0)
	{
		$invoice_id = intval($invoice_id);
		$invoice    = $this->Financial_Model->get_invoice_by_id($invoice_id);
		if (!$invoice) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>GST Invoice not found!</div>");
			redirect('hospitalpanel/earnings#invoices');
			return;
		}

		$data['invoice']  = $invoice;
		$data['facility'] = $this->db->where('id', $invoice->facility_id)->get('hospital')->row();
		$data['settings'] = $this->Financial_Model->get_platform_settings();
		$this->load->view('hospitalpanel/gst_invoice_view', $data);
	}

	public function generate_monthly_invoice()
	{
		$hospital_id   = $this->did;
		$hosuid        = $this->session->userdata('hosuserid');
		$hospital      = $this->db->where('id', $hospital_id)->or_where('uid', $hosuid)->get('hospital')->row();
		$facility_id   = ($hospital && isset($hospital->id)) ? $hospital->id : $hospital_id;
		$billing_month = $this->input->post('billing_month', TRUE) ?: date('Y-m');

		$inv_id = $this->Financial_Model->generate_monthly_gst_invoice('hospital', $facility_id, $billing_month);
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><i class='fa fa-check-circle'></i> Tax Invoice for <strong>" . date('F Y', strtotime($billing_month . '-01')) . "</strong> generated successfully!</div>");
		redirect('hospitalpanel/earnings#invoices');
	}

	// ==========================================
	// SUPPORT TICKET & HELPDESK SYSTEM
	// ==========================================

	/**
	 * Support Ticket Listing Page
	 */
	public function support()
	{
		$userid = $this->did;
		$hosuid = $this->session->userdata('hosuserid');
		
		$keyword  = $this->input->get_post('keyword', TRUE);
		$category = $this->input->get_post('category', TRUE);
		$priority = $this->input->get_post('priority', TRUE);
		$status   = $this->input->get_post('status', TRUE);

		$this->db->group_start();
		$this->db->where('hospital_id', $userid);
		if (!empty($hosuid)) {
			$this->db->or_where('hospital_id', $hosuid);
		}
		$this->db->group_end();

		if (!empty($keyword)) {
			$this->db->group_start()
				->like('ticket_code', $keyword)
				->or_like('subject', $keyword)
				->or_like('description', $keyword)
			->group_end();
		}
		if (!empty($category)) {
			$this->db->where('category', $category);
		}
		if (!empty($priority)) {
			$this->db->where('priority', $priority);
		}
		if (!empty($status)) {
			$this->db->where('status', $status);
		}

		$data['tickets'] = $this->db->order_by('ticket_id', 'DESC')->get('support_tickets')->result();

		// Counters
		$all_tickets = $this->db->group_start()->where('hospital_id', $userid)->or_where('hospital_id', $hosuid)->group_end()->get('support_tickets')->result();
		$data['total_count']       = count($all_tickets);
		$data['open_count']        = 0;
		$data['in_progress_count'] = 0;
		$data['resolved_count']    = 0;

		foreach ($all_tickets as $t) {
			if ($t->status == 'Open') $data['open_count']++;
			elseif ($t->status == 'In Progress') $data['in_progress_count']++;
			elseif ($t->status == 'Resolved' || $t->status == 'Closed') $data['resolved_count']++;
		}

		$this->load->view('hospitalpanel/support_tickets', $data);
	}

	/**
	 * Create Ticket Action
	 */
	public function create_ticket()
	{
		$userid = $this->did;
		$hosuid = $this->session->userdata('hosuserid');

		if ($this->input->post()) {
			$this->form_validation->set_rules('category', 'Category', 'trim|required');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|in_list[Low,Medium,High,Urgent]');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('description', 'Detailed Description', 'trim|required');

			if ($this->form_validation->run() === TRUE) {
				// Generate unique ticket code e.g. #TICK-84920
				$ticket_code = '#TICK-' . rand(10000, 99999);
				
				// Handle file upload
				$attachment = null;
				if (!empty($_FILES['attachment']['name'])) {
					$config['upload_path']   = './uploads/support/';
					$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
					$config['max_size']      = 5120; // 5MB
					$config['file_name']     = 'ticket_' . time() . '_' . rand(100, 999);
					
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('attachment')) {
						$upload_data = $this->upload->data();
						$attachment  = $upload_data['file_name'];
					}
				}

				$insert_data = array(
					'ticket_code' => $ticket_code,
					'hospital_id' => $userid,
					'category'    => $this->input->post('category', TRUE),
					'subject'     => $this->input->post('subject', TRUE),
					'description' => $this->input->post('description', TRUE),
					'priority'    => $this->input->post('priority', TRUE),
					'status'      => 'Open',
					'attachment'  => $attachment,
					'created_at'  => date('Y-m-d H:i:s'),
					'updated_at'  => date('Y-m-d H:i:s')
				);

				$this->db->insert('support_tickets', $insert_data);
				$ticket_id = $this->db->insert_id();

				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Support ticket <strong>{$ticket_code}</strong> created successfully. Our team will review and respond shortly.</div>");
				redirect('hospitalpanel/ticket_view/' . $ticket_id);
			} else {
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>" . validation_errors() . "</div>");
			}
		}
		redirect('hospitalpanel/support');
	}

	/**
	 * Ticket View & Reply Thread
	 */
	public function ticket_view($ticket_id = 0)
	{
		$userid = $this->did;
		$hosuid = $this->session->userdata('hosuserid');
		$ticket_id = intval($ticket_id);

		$ticket = $this->db->where('ticket_id', $ticket_id)
			->group_start()->where('hospital_id', $userid)->or_where('hospital_id', $hosuid)->group_end()
			->get('support_tickets')
			->row();

		if (!$ticket) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Support ticket not found or access denied.</div>");
			redirect('hospitalpanel/support');
		}

		// Handle reply submission
		if ($this->input->post('submit_reply')) {
			if ($ticket->status == 'Closed' || $ticket->status == 'Resolved') {
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>Cannot post replies to a closed or resolved ticket.</div>");
				redirect('hospitalpanel/ticket_view/' . $ticket_id);
			}

			$this->form_validation->set_rules('message', 'Reply Message', 'trim|required');
			if ($this->form_validation->run() === TRUE) {
				$attachment = null;
				if (!empty($_FILES['reply_attachment']['name'])) {
					$config['upload_path']   = './uploads/support/';
					$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
					$config['max_size']      = 5120;
					$config['file_name']     = 'reply_' . time() . '_' . rand(100, 999);
					
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('reply_attachment')) {
						$upload_data = $this->upload->data();
						$attachment  = $upload_data['file_name'];
					}
				}

				$reply_data = array(
					'ticket_id'       => $ticket_id,
					'sender_type'     => 'Hospital',
					'sender_id'       => $userid,
					'message'         => $this->input->post('message', TRUE),
					'attachment_path' => $attachment,
					'created_at'      => date('Y-m-d H:i:s')
				);

				$this->db->insert('ticket_replies', $reply_data);

				// Update ticket timestamp and status
				$this->db->where('ticket_id', $ticket_id)->update('support_tickets', array(
					'updated_at' => date('Y-m-d H:i:s'),
					'status'     => ($ticket->status == 'Open') ? 'In Progress' : $ticket->status
				));

				$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Reply sent successfully.</div>");
				redirect('hospitalpanel/ticket_view/' . $ticket_id);
			}
		}

		$data['ticket'] = $ticket;
		$data['hospital'] = $this->db->where('id', $userid)->or_where('uid', $hosuid)->get('hospital')->row();
		$data['replies'] = $this->db->where('ticket_id', $ticket_id)->order_by('reply_id', 'ASC')->get('ticket_replies')->result();

		$this->load->view('hospitalpanel/ticket_thread', $data);
	}

	/**
	 * Mark Ticket as Resolved / Closed
	 */
	public function close_ticket($ticket_id = 0)
	{
		$userid = $this->did;
		$hosuid = $this->session->userdata('hosuserid');
		$ticket_id = intval($ticket_id);

		$ticket = $this->db->where('ticket_id', $ticket_id)
			->group_start()->where('hospital_id', $userid)->or_where('hospital_id', $hosuid)->group_end()
			->get('support_tickets')
			->row();

		if ($ticket) {
			$new_status = $this->input->get('status') == 'Closed' ? 'Closed' : 'Resolved';
			$this->db->where('ticket_id', $ticket_id)->update('support_tickets', array(
				'status'     => $new_status,
				'updated_at' => date('Y-m-d H:i:s')
			));
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Ticket <strong>{$ticket->ticket_code}</strong> has been marked as {$new_status}.</div>");
		}
		redirect('hospitalpanel/ticket_view/' . $ticket_id);
	}
}
