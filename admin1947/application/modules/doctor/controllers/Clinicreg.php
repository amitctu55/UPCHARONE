<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Clinicreg extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$date=date('Y-m-d h:i:s');
		$this->load->model(array('doctorregmodel','masters/managementmodel'));
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
	}
	
	public function viewhospital()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['approved_count'] = $this->db->where('approved', '1')->where('verified', '1')->where('status !=', '2')->count_all_results('hospital');
		$data['pending_count']  = $this->db->group_start()->where('approved', '0')->or_where('verified', '0')->group_end()->where('status !=', '2')->count_all_results('hospital');
		$data['total_count']    = $this->db->where('status !=', '2')->count_all_results('hospital');
		$data['hospital'] 		=  $this->doctorregmodel->get_hospital($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Hospital List';
		$data['module'] 		=  'Hospital';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		if( $this->input->post('status_action')!='')
		{
			$this->managementmodel->update_status('hospital','premium_id');			
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('hospital_view',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function hospital_doctor()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['doctor'] 		=  $this->doctorregmodel->get_doctor($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Practice List';
		$data['module'] 		=  'Practice';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		if( $this->input->post('status_action')!='')
		{	
			$this->managementmodel->update_status('dr_practice','id');			
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('hospital_doctor_view',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function assign_doctor()
	{
		if ($this->input->post('submit_assign'))
		{
			$doctor_id = (int)$this->input->post('doctor_id');
			$type = ($this->input->post('type') === 'C') ? 'C' : 'H';
			$institution_id = ($type === 'C') ? (int)$this->input->post('clinic_id') : (int)$this->input->post('hospital_id');
			if ($institution_id <= 0) {
				$institution_id = (int)$this->input->post('hospital_id') ?: (int)$this->input->post('clinic_id');
			}
			$fee = (int)$this->input->post('fee');
			
			if ($doctor_id > 0 && $institution_id > 0)
			{
				$existing = $this->db->get_where('dr_practice', array('user_id' => $doctor_id, 'institution_id' => $institution_id, 'type' => $type))->row();
				if ($existing)
				{
					$this->db->where('id', $existing->id)->update('dr_practice', array(
						'fee' => $fee,
						'status' => '1'
					));
					$this->session->set_flashdata('flashmsg', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check-circle"></i> Doctor affiliation updated successfully!</div>');
				}
				else
				{
					$this->db->insert('dr_practice', array(
						'user_id' => $doctor_id,
						'institution_id' => $institution_id,
						'type' => $type,
						'fee' => $fee,
						'status' => '1'
					));
					$this->session->set_flashdata('flashmsg', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check-circle"></i> Doctor successfully affiliated to healthcare facility!</div>');
				}
				redirect(base_url('doctor/clinicreg/assign_doctor'));
				return;
			}
			else
			{
				$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-exclamation-triangle"></i> Please select both a valid doctor and a facility.</div>');
			}
		}

		// Query doctors with joined specialization name
		$data['doctors'] = $this->db->select('pd.id, pd.fname, pd.lname, pd.mobile, pd.city, ms.name as speciality')
			->from('profile_dr pd')
			->join('master_specialization ms', 'ms.id = pd.specialization', 'left')
			->where('pd.status', '1')
			->order_by('pd.fname', 'ASC')
			->get()
			->result_array();

		// Query hospitals and clinics
		$data['hospitals'] = $this->db->select('id, name, city, address')->where('status !=', '2')->order_by('name', 'ASC')->get('hospital')->result_array();
		$data['clinics'] = $this->db->select('id, name, city, address')->where('status !=', '2')->order_by('name', 'ASC')->get('clinic')->result_array();
		
		// Query recent affiliations for real-time overview
		$data['recent_affiliations'] = $this->db->select('dp.id, dp.user_id, dp.type, dp.institution_id, dp.fee, dp.status, pd.fname, pd.lname, ms.name as speciality, pd.mobile as doc_mobile, h.name as hosp_name, h.city as hosp_city, c.name as clinic_name, c.city as clinic_city')
			->from('dr_practice dp')
			->join('profile_dr pd', '(pd.id = dp.user_id OR (pd.user_id = dp.user_id AND dp.user_id != 0))', 'left')
			->join('master_specialization ms', 'ms.id = pd.specialization', 'left')
			->join('hospital h', 'h.id = dp.institution_id AND dp.type = "H"', 'left')
			->join('clinic c', 'c.id = dp.institution_id AND dp.type = "C"', 'left')
			->order_by('dp.id', 'DESC')
			->limit(15)
			->get()
			->result_array();

		$data['heading_title'] = 'Assign Doctor to Hospital / Clinic';
		$data['module'] = 'Affiliation Management';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('assign_doctor_view', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function delete_affiliation($id = 0)
	{
		$id = (int)$id;
		if ($id > 0) {
			$this->db->where('id', $id)->delete('dr_practice');
			$this->session->set_flashdata('flashmsg', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check-circle"></i> Affiliation unlinked successfully.</div>');
		}
		redirect(base_url('doctor/clinicreg/assign_doctor'));
	}
	
	public function doctor_fee_time()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 15;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		
		$practice_id = (int)$this->uri->segment(4);
		$data['practice_id'] = $practice_id;

		// Fetch practice affiliation & doctor details if practice_id is passed
		if ($practice_id > 0) {
			$data['practice_info'] = $this->db->select('dp.id as practice_id, dp.user_id as doctor_id, dp.type as facility_type, dp.institution_id, dp.fee, dp.status, pd.fname, pd.lname, pd.mobile, pd.email, ms.name as speciality, COALESCE(h.name, c.name, "Healthcare Facility") as facility_name, COALESCE(h.city, c.city, pd.city) as facility_city')
				->from('dr_practice dp')
				->join('profile_dr pd', '(pd.id = dp.user_id OR (pd.user_id = dp.user_id AND dp.user_id != 0))', 'left')
				->join('master_specialization ms', 'ms.id = pd.specialization', 'left')
				->join('hospital h', 'h.id = dp.institution_id AND (dp.type = "H" OR dp.type = "" OR dp.type IS NULL)', 'left')
				->join('clinic c', 'c.id = dp.institution_id AND dp.type = "C"', 'left')
				->group_start()
				->where('dp.id', $practice_id)
				->or_where('dp.user_id', $practice_id)
				->group_end()
				->get()
				->row_array();
		} else {
			$data['practice_info'] = null;
		}

		$data['doctor'] 		=  $this->doctorregmodel->get_doctor_fee_time($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Doctor Fee & OPD Timings';
		$data['module'] 		=  'Doctor Fee & Time';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		
		if( $this->input->post('status_action')!='')
		{	
			$this->managementmodel->update_status('dr_practice','id');			
		}

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('hospital_doctor_fee_time_view',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function save_fee_time()
	{
		$practice_id = (int)$this->input->post('practice_id');
		$user_id     = (int)$this->input->post('user_id');
		$fee         = floatval($this->input->post('consultation_fee'));
		$from_time   = trim($this->input->post('from_timing') ?: '09:00 AM');
		$to_time     = trim($this->input->post('to_timing') ?: '01:00 PM');
		$max_patient = (int)$this->input->post('max_patient') ?: 20;

		if ($practice_id <= 0) {
			$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Invalid practice affiliation ID.</div>');
			redirect(base_url('doctor/clinicreg/hospital_doctor'));
			return;
		}

		// Update consultation fee in dr_practice
		$this->db->where('id', $practice_id)->update('dr_practice', array('fee' => $fee));

		// Check if user_id was missing on practice
		if ($user_id > 0) {
			$this->db->where('id', $practice_id)->where('user_id', 0)->update('dr_practice', array('user_id' => $user_id));
		}

		// Prepare Days of Week availability
		$days = array(
			'M'      => $this->input->post('day_m') ? 1 : 0,
			'T'      => $this->input->post('day_t') ? 1 : 0,
			'W'      => $this->input->post('day_w') ? 1 : 0,
			'TH'     => $this->input->post('day_th') ? 1 : 0,
			'F'      => $this->input->post('day_f') ? 1 : 0,
			'SA'     => $this->input->post('day_sa') ? 1 : 0,
			'S'      => $this->input->post('day_s') ? 1 : 0,
			'status' => '1'
		);

		// Check if timing row exists
		$existing_timing = $this->db->get_where('timing', array('practice_id' => $practice_id))->row();
		if ($existing_timing) {
			$timing_id = $existing_timing->id;
			$this->db->where('id', $timing_id)->update('timing', $days);
		} else {
			$days['practice_id'] = $practice_id;
			$days['user_type']   = 'D';
			$days['user_id']     = $user_id;
			$this->db->insert('timing', $days);
			$timing_id = $this->db->insert_id();
		}

		// Check timing_session
		$existing_session = $this->db->get_where('timing_session', array('timing_id' => $timing_id))->row();
		$session_data = array(
			'timing_id'        => $timing_id,
			'from_timing'      => $from_time,
			'to_timing'        => $to_time,
			'max_patient'      => $max_patient,
			'consultation_fee' => (string)$fee,
			'status'           => 1
		);

		if ($existing_session) {
			$this->db->where('id', $existing_session->id)->update('timing_session', $session_data);
		} else {
			$this->db->insert('timing_session', $session_data);
		}

		$this->session->set_flashdata('flashmsg', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check-circle"></i> Doctor fee and OPD schedule updated successfully!</div>');
		redirect(base_url('doctor/clinicreg/doctor_fee_time/' . $practice_id));
	}
	public function createHospitalExcel() 
	{	
		$fileName = 'hospital.xlsx';  
		$doctorData = $this->doctorregmodel->get_hospital_list();
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'City'); 
		$sheet->setCellValue('E1', 'Email');
		$sheet->setCellValue('F1', 'Mobile');
        $sheet->setCellValue('G1', 'Reg. Date');       
        $rows = 2;
        foreach ($doctorData as $val){
			if($val['TYPE']=='1'){ $type ="Private Hospital"; }else{ $type ="Government Hospital"; }
            $sheet->setCellValue('A' . $rows, $val['id']);
            $sheet->setCellValue('B' . $rows, $val['name']);
            $sheet->setCellValue('C' . $rows, $type);
            $sheet->setCellValue('D' . $rows, getCityName($val['city']));
			$sheet->setCellValue('E' . $rows, $val['email']);
			$sheet->setCellValue('F' . $rows, $val['mobile']);
            $sheet->setCellValue('G' . $rows, $val['creat_date']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
		$writer->save("public/assets/export/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."public/assets/export/".$fileName);              
    }    
	
	public function viewclinic()
	{
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['approved_count'] = $this->db->where('approved', '1')->where('verified', '1')->where('status !=', '2')->count_all_results('clinic');
		$data['pending_count']  = $this->db->group_start()->where('approved', '0')->or_where('verified', '0')->group_end()->where('status !=', '2')->count_all_results('clinic');
		$data['total_count']    = $this->db->where('status !=', '2')->count_all_results('clinic');
		$data['clinic'] 		=  $this->doctorregmodel->get_clinic($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Clinic List';
		$data['module'] 		=  'Clinic';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		if( $this->input->post('status_action')!='')
		{
			$this->managementmodel->update_status('clinic','id');			
		}
		
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('clinicview',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	function validate_member($str)
	{	
	   $field_value = $str; //this is redundant, but it's to show you how
	   //the content of the fields gets automatically passed to the method
	   $hospital = $this->doctorregmodel->check_hospital(array('EMAIL'=>$field_value));
	   if(is_array($hospital) && !empty($hospital))
	   {
			$this->form_validation->set_message('validate_member','Email Id is alredy Exist!');
			return FALSE ;
	   }
	   else
	   {
			return TRUE;
	   }
	}

	public function add()
	{	
		$data['heading_title'] 	=  'Hospital / Clinic Add';
		$data['module'] 		=  'Clinic/Hospital';

		$this->form_validation->set_rules('objective','Category','trim|required|max_length[100]');
		$this->form_validation->set_rules('type','Ownership Type','trim|required|max_length[100]');
		$this->form_validation->set_rules('name','Facility Name','trim|required|max_length[255]');
		$this->form_validation->set_rules('website','Website','trim|max_length[100]');
		$this->form_validation->set_rules('state','State','trim|max_length[100]');
		$this->form_validation->set_rules('city','City','trim|required|max_length[100]');
		$this->form_validation->set_rules('location','Location','trim|max_length[100]');
		$this->form_validation->set_rules('address','Address','trim|max_length[255]');
		$this->form_validation->set_rules('pincode','Pincode','trim|max_length[10]');
		$this->form_validation->set_rules('mobile','Mobile No',"trim|numeric|required|max_length[255]|is_unique[hospitallogin.MOBILE='".$this->db->escape_str($this->input->post('mobile'))."' AND status!='2']");
		$this->form_validation->set_rules('email', 'Email Address','trim|required|valid_email|callback_validate_member');
		$this->form_validation->set_rules('password','Password','trim|max_length[50]');
		$this->form_validation->set_rules('about','About','trim|max_length[255]');
		$this->form_validation->set_rules('tags','Tags','trim|max_length[100]');
		$this->form_validation->set_rules('services[]','Services','trim');
		$this->form_validation->set_rules('package','Package','trim|max_length[255]');

		if ($this->form_validation->run() == TRUE)
		{	
			$type = $this->input->post('objective');			
			$typename = ($type == 'C') ? 'clinic' : 'hospital';

			$uploadimage = 'dummyhosp.jpg';
			$uploadimage2 = '';
			$uploadimage3 = '';

			$config['upload_path']   = './public/assets/upload/';
			$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG|pdf|PDF';
			$config['max_size']      = 5120; // 5MB
			$this->load->library('upload', $config);

			// 1. Hospital Profile Image / Logo
			if (!empty($_FILES['uploadimage']['name'])) {
				$ext = pathinfo($_FILES['uploadimage']['name'], PATHINFO_EXTENSION);
				$fname = $typename . '_profile_pic_' . rand(1111111, 999999999) . date('Y-m-d') . '.' . $ext;
				$config['file_name'] = $fname;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('uploadimage')) {
					$uploadimage = $fname;
				}
			}

			// 2. ID Proof
			if (!empty($_FILES['idproof']['name'])) {
				$ext2 = pathinfo($_FILES['idproof']['name'], PATHINFO_EXTENSION);
				$fname2 = $typename . '_id_proof_' . rand(1111111, 999999999) . date('Y-m-d') . '.' . $ext2;
				$config['file_name'] = $fname2;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('idproof')) {
					$uploadimage2 = $fname2;
				}
			}

			// 3. Registration Proof
			if (!empty($_FILES['regproof']['name'])) {
				$ext3 = pathinfo($_FILES['regproof']['name'], PATHINFO_EXTENSION);
				$fname3 = $typename . '_reg_proof_' . rand(1111111, 999999999) . date('Y-m-d') . '.' . $ext3;
				$config['file_name'] = $fname3;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('regproof')) {
					$uploadimage3 = $fname3;
				}
			}

			$institution_id = $this->doctorregmodel->clinicinsert($uploadimage, $uploadimage2, $uploadimage3);
			if ($institution_id) {
				$hosp_name = htmlspecialchars($this->input->post('name'));
				$flashmsg = "<div class='alert alert-success alert-dismissible' style='border-radius: 8px;'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<i class='fa fa-check-circle'></i> <strong>Success!</strong> Healthcare facility <strong>{$hosp_name}</strong> has been onboarded successfully (ID #{$institution_id}).
				</div>";
				$this->session->set_flashdata('flashmsg', $flashmsg);
				redirect(base_url('doctor/clinicreg/viewhospital'));
				return;
			} else {
				$flashmsg = "<div class='alert alert-danger alert-dismissible' style='border-radius: 8px;'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<i class='fa fa-exclamation-triangle'></i> <strong>Error!</strong> Unable to save facility. Please check required fields and try again.
				</div>";
				$this->session->set_flashdata('flashmsg', $flashmsg);
				redirect(base_url('doctor/clinicreg/add'));
				return;
			}
		}

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('clinicreg', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	/***************************************/
	
	public function updatehospital($id = 0)
	{
		if (!$id) {
			$id = $this->uri->segment(4);
		}
		$hospital = $this->db->get_where('hospital', array('id' => $id))->row();
		if (!is_object($hospital) || empty($hospital)) {
			redirect('doctor/clinicreg/viewhospital');
			return;
		}
		
		$hospital_login = $this->db->get_where('hospitallogin', array('USERID' => $hospital->uid))->row();
		if (!is_object($hospital_login) || empty($hospital_login)) {
			$hospital_login = (object)[
				'TYPE' => '1',
				'MOBILE' => $hospital->mobile,
				'EMAIL' => $hospital->email,
				'USERID' => $hospital->uid
			];
		}
		$data['hospital']       = $hospital;
		$data['hospital_login'] = $hospital_login;
		$data['heading_title']  = 'Hospital Update';
		$data['module']         = 'Hospital';
		
		$this->form_validation->set_rules('type','Hospital Type','trim|required|max_length[30]');
		$this->form_validation->set_rules('name','Name','trim|required|max_length[155]');
		$this->form_validation->set_rules('website','Website','trim|max_length[100]');
		$this->form_validation->set_rules('city','City','trim|required|max_length[30]');
		$this->form_validation->set_rules('location','Location','trim|max_length[30]');
		$this->form_validation->set_rules('address','Address','trim|max_length[255]');
		$this->form_validation->set_rules('about','About','trim|max_length[500]');
		
		if ($this->form_validation->run() == TRUE) {
			$config['upload_path']   = './public/assets/upload/';
			$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
			$config['max_size']      = 2048;
			$config['quality']       = '60%';
			$typename                = 'hospital';
			$uploadimage             = $hospital->drimage;
			$unlink_image            = array('source_file' => $hospital->drimage);
			
			if (!empty($_FILES['uploadimage']['name'])) {	
				$uploadimage = $_FILES['uploadimage']['name'];
				$extsign = pathinfo($_FILES['uploadimage']['name'], PATHINFO_EXTENSION);
				$rname = rand(1111111, 999999999);
				$date = date('Y-m-d');
				$uploadimage = $typename . '_profile_pic_' . $rname . $date . '.' . $extsign;
				$config['file_name'] = $uploadimage;
				$this->load->library('upload', $config);
				$this->upload->do_upload('uploadimage');
				removeImage($unlink_image);
			}	
			$uploadimage2 = $hospital->id_proof;
			$unlink_image2 = array('source_file' => $hospital->id_proof);
			if (!empty($_FILES['idproof']['name'])) {
				$uploadimage2 = $_FILES['idproof']['name'];
				$extsign2 = pathinfo($_FILES['idproof']['name'], PATHINFO_EXTENSION);
				$rname = rand(1111111, 999999999);
				$date = date('Y-m-d');
				$uploadimage2 = $typename . '_id_proof_' . $rname . $date . '.' . $extsign2;
				$config['file_name'] = $uploadimage2;
				$this->load->library('upload', $config);
				$this->upload->do_upload('idproof');
				removeImage($unlink_image2);
			}
			
			$uploadimage3 = $hospital->med_reg_proof;
			$unlink_image3 = array('source_file' => $hospital->med_reg_proof);
			if (!empty($_FILES['regproof']['name'])) {
				$uploadimage3 = $_FILES['regproof']['name'];
				$extsign3 = pathinfo($_FILES['regproof']['name'], PATHINFO_EXTENSION);
				$rname = rand(1111111, 999999999);
				$date = date('Y-m-d');
				$uploadimage3 = $typename . '_reg_proof_' . $rname . $date . '.' . $extsign3;
				$config['file_name'] = $uploadimage3;
				$this->load->library('upload', $config);
				$this->upload->do_upload('regproof');
				removeImage($unlink_image3);
			}
			
			if ($this->doctorregmodel->updatehospital($uploadimage, $uploadimage2, $uploadimage3, $id, $hospital->uid)) {
				$msg = "<div class='alert alert-success'><strong>Success!</strong> Hospital Updated Successfully</div>";
				$this->session->set_flashdata('flashmsg', $msg);
				redirect(base_url('doctor/clinicreg/viewhospital'));
			} else {
				$msg = "<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
				$this->session->set_flashdata('flashmsg', $msg);
				redirect(base_url('doctor/clinicreg/updatehospital/' . $id));
			}
		}
		
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('updatehospital', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function viewgallery()
	{

		$data['hosp_gal']=$this->db->select('hospital.id,hospital.name,hospitalgallery.*')->join('hospital','hospital.id=hospitalgallery.uid','left')->get_where('hospitalgallery')->result_array();

		$data['module']='gallery';
		
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('hospital_gallery',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function updategallery()
	{
		$id=$this->uri->segment(4);
		$data['gallery']=$this->db->get_where('hospitalgallery',array('id'=>$id))->row();
		$data['module']='gallery';
		if(!empty($_POST['submit']))
		{
			if(!empty($_FILES['uploadimage']['name']))
			{
                $config['upload_path'] 		= './public/assets/upload/';
                $config['allowed_types'] 	= 'jpg|png|jpeg|JPG|PNG|JPEG';
                $config['max_size']         = 2048;
				$config['quality'] 			= '60%';
                $config['file_name'] 		= $_FILES['uploadimage']['name'];
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('uploadimage'))
                {
                    $uploadData = $this->upload->data();
                    $uploadimage = $uploadData['file_name'];
                }
                else
                {
                    $uploadimage = '';
                }
            }
            else
            {
                $uploadimage = $data['gallery']->image;
            }  
			$this->load->model('doctorregmodel');
			$this->doctorregmodel->updategallery($id,$uploadimage);
			$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
			$this->session->set_flashdata('flashmsg',$msg);	
			redirect('doctor/clinicreg/updategallery/'.$id.'');
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('updatehospital_gallery',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function galleryview($id)
	{    
		$data['hosp_gallery']=$this->db->get_where('hospitalgallery',array('id'=>$id))->row();
		$data['module']='gallery';
		
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('viewhospital_gallery',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	
	}

	public function delete()
	{
		$id=$this->input->get('id');
		$this->load->model('doctorregmodel');
		$this->doctorregmodel->gallerydelete($id);
		redirect(base_url().'doctor/clinicreg/viewgallery');
	}

	/*
	public function deletegallery()
    {
       $id=$this->uri->segment(4);
        $this->load->model('doctorregmodel');
       $this->doctorregmodel->gallerydelete($id);
        redirect(base_url().'doctor/clinicreg/viewgallery');
    } */
	
	public function clinicapprove($id = null)
	{
		$this->approve($id);
	}
	 
	public function clinicverify($id = null)
	{
		$this->verify($id);
	}
	public function verify($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('verified')->get_where('clinic', array('id' => $did))->row();
		$current = $row ? $row->verified : '0';
		if ($current == '1') {
			$this->db->set('verified', '0')->where(array('id' => $did))->update('clinic');
			$status = '0';
			$msg = 'Clinic verification status updated to Unverified.';
		} else {
			$this->db->set('verified', '1')->where(array('id' => $did))->update('clinic');
			$status = '1';
			$msg = 'Clinic has been Verified successfully.';
		}
		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/clinicreg/viewclinic'));
	}

	public function approve($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('approved')->get_where('clinic', array('id' => $did))->row();
		$current = $row ? $row->approved : '0';
		if ($current == '1') {
			$this->db->set('approved', '0')->where(array('id' => $did))->update('clinic');
			$status = '0';
			$msg = 'Clinic approval status updated to Pending.';
		} else {
			$this->db->set('approved', '1')->where(array('id' => $did))->update('clinic');
			$status = '1';
			$msg = 'Clinic has been Approved successfully.';
		}
		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/clinicreg/viewclinic'));
	}
	 
	public function hospitalapprove($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('approved, verified')->get_where('hospital', array('id' => $did))->row();
		$current = $row ? $row->approved : '0';
		$admin_id = $this->session->userdata('adminuserid') ?: 1;
		if ($current == '1') {
			$this->db->set(array(
				'approved'            => '0',
				'verification_status' => 'pending',
				'is_active'           => 0
			))->where(array('id' => $did))->update('hospital');
			$status = '0';
			$msg = 'Hospital approval status updated to Pending.';
		} else {
			$this->db->set(array(
				'approved'             => '1',
				'verified'             => '1',
				'verification_status'  => 'verified',
				'is_active'            => 1,
				'verified_at'          => date('Y-m-d H:i:s'),
				'verified_by_admin_id' => $admin_id
			))->where(array('id' => $did))->update('hospital');
			$status = '1';
			$msg = 'Hospital has been Approved &amp; Verified successfully.';
		}
		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/clinicreg/viewhospital'));
	}
	 
	public function hospitalverify($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$did = (int)$did;

		// Ensure schema columns exist so production never throws SQL 500 error
		if ($this->db->table_exists('hospital')) {
			if (!$this->db->field_exists('verification_status', 'hospital')) {
				@$this->db->query("ALTER TABLE `hospital` ADD `verification_status` ENUM('pending','verified','rejected') DEFAULT 'pending'");
			}
			if (!$this->db->field_exists('is_active', 'hospital')) {
				@$this->db->query("ALTER TABLE `hospital` ADD `is_active` TINYINT(1) DEFAULT 1");
			}
			if (!$this->db->field_exists('verified_at', 'hospital')) {
				@$this->db->query("ALTER TABLE `hospital` ADD `verified_at` DATETIME NULL");
			}
			if (!$this->db->field_exists('verified_by_admin_id', 'hospital')) {
				@$this->db->query("ALTER TABLE `hospital` ADD `verified_by_admin_id` INT(11) NULL");
			}
		}

		// If GET request without explicit action query, display dedicated verification compliance view
		if ($this->input->server('REQUEST_METHOD') === 'GET' && !$this->input->get('action')) {
			$data['hospital'] = $this->db->get_where('hospital', array('id' => $did))->row_array();
			if (empty($data['hospital'])) {
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Hospital record #{$did} was not found.</div>");
				redirect(base_url('doctor/clinicreg/viewhospital'));
				return;
			}
			$data['affiliated_doctors'] = $this->db->select('dp.id as practice_id, dp.fee, dp.status, pd.id as doctor_id, pd.fname, pd.lname, pd.mobile, pd.email, ms.name as speciality')
				->from('dr_practice dp')
				->join('profile_dr pd', '(pd.id = dp.user_id OR (pd.user_id = dp.user_id AND dp.user_id != 0))', 'left')
				->join('master_specialization ms', 'ms.id = pd.specialization', 'left')
				->where('dp.institution_id', $did)
				->where('dp.type', 'H')
				->order_by('dp.id', 'DESC')
				->get()
				->result_array();

			$data['heading_title'] = 'Hospital Verification & Compliance';
			$data['module']        = 'Hospital Verification';

			$this->load->view('inc/topheaderlink');
			$this->load->view('inc/topheader');
			$this->load->view('hospital_verify_view', $data);
			$this->load->view('sidebar');
			$this->load->view('inc/headersetting');
			$this->load->view('inc/footerlink');
			$this->load->view('inc/table_footer');
			return;
		}

		// State toggle action (POST / AJAX / action parameter)
		$target_action = $this->input->post('target_action') ?: ($this->input->get('action') ?: 'toggle');
		$row = $this->db->select('verified, approved')->get_where('hospital', array('id' => $did))->row();
		$current = $row ? $row->verified : '0';
		$admin_id = $this->session->userdata('adminuserid') ?: 1;

		$update_data = array();
		if ($target_action === 'verify' || ($target_action === 'toggle' && $current != '1')) {
			$update_data['verified'] = '1';
			$update_data['approved'] = '1';
			if ($this->db->field_exists('verification_status', 'hospital')) $update_data['verification_status'] = 'verified';
			if ($this->db->field_exists('is_active', 'hospital')) $update_data['is_active'] = 1;
			if ($this->db->field_exists('verified_at', 'hospital')) $update_data['verified_at'] = date('Y-m-d H:i:s');
			if ($this->db->field_exists('verified_by_admin_id', 'hospital')) $update_data['verified_by_admin_id'] = $admin_id;
			$status = '1';
			$msg = 'Hospital has been Verified &amp; Approved successfully.';
		} else {
			$update_data['verified'] = '0';
			if ($this->db->field_exists('verification_status', 'hospital')) $update_data['verification_status'] = 'pending';
			if ($this->db->field_exists('is_active', 'hospital')) $update_data['is_active'] = 0;
			$status = '0';
			$msg = 'Hospital verification status updated to Unverified / Pending.';
		}

		$this->db->where('id', $did)->update('hospital', $update_data);

		if ($this->input->is_ajax_request()) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}

		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		if ($this->input->post('target_action') || $this->input->get('action')) {
			redirect(base_url('doctor/clinicreg/hospitalverify/' . $did));
		} else {
			redirect(base_url('doctor/clinicreg/viewhospital'));
		}
	}
	 
	 
	public function updateclinic($id)
	{
		$data['clinic']=$this->db->get_where('clinic',array('id'=>$id))->row();
		$data['module']='clinic';
		
		if(isset($_POST['submit'])){
			$this->load->model('doctorregmodel');
			$this->doctorregmodel->updateclinic($id);
	 
			$msg="<div class='alert alert-success'><strong>Success!</strong> Clinic Updated Successfully</div>";
			$this->session->set_flashdata('flashmsg',$msg);
			redirect(base_url('doctor/clinicreg/viewclinic'));
		}
		
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('updateclinic',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	 
	public function clinicview($id)
	{
		$data['clinic']=$this->db->get_where('clinic',array('id'=>$id))->row();
		$data['module']='clinic';		     
         // print_r($data);
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('viewclinic',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	 
	 
	
	
	public function hospitalview($id)
	{    
		$data['hospital']=$this->db->get_where('hospital',array('id'=>$id))->row();
		$data['module']='hospital';
		
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('viewhospital',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	
	}

	
	public function delete_clinic($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_clinic();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->post('did') ? $this->input->post('did') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4))));
		if ($del_id) {
			$this->load->model('doctorregmodel');
			$this->doctorregmodel->clinic_delete($del_id);
			$msg = "Clinic record deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id') || $this->input->post('did')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/clinicreg/viewclinic'));   
	}

	public function bulk_delete_clinic()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$this->load->model('doctorregmodel');
			$deleted_count = 0;
			foreach ($ids as $cid) {
				$cid = (int)$cid;
				if ($cid > 0) {
					$this->doctorregmodel->clinic_delete($cid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count clinic record(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No clinics selected for deletion.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No clinics selected for deletion.</div>");
		}
		redirect(base_url('doctor/clinicreg/viewclinic'));
	}
	
	public function deletehospital($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_hospital();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->post('did') ? $this->input->post('did') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4))));
		if ($del_id) {
			$this->load->model('doctorregmodel');
			$this->doctorregmodel->hospitaldelete($del_id);
			$msg = "Hospital record deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id') || $this->input->post('did')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/clinicreg/viewhospital'));   
	}

	public function bulk_delete_hospital()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$this->load->model('doctorregmodel');
			$deleted_count = 0;
			foreach ($ids as $hid) {
				$hid = (int)$hid;
				if ($hid > 0) {
					$this->doctorregmodel->hospitaldelete($hid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count hospital record(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No hospitals selected for deletion.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No hospitals selected for deletion.</div>");
		}
		redirect(base_url('doctor/clinicreg/viewhospital'));
	}

	public function bulk_delete_gallery()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$this->load->model('doctorregmodel');
			$deleted_count = 0;
			foreach ($ids as $gid) {
				$gid = (int)$gid;
				if ($gid > 0) {
					$this->doctorregmodel->gallerydelete($gid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count gallery item(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No gallery items selected for deletion.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No items selected.</div>");
		}
		redirect(base_url('doctor/clinicreg/viewgallery'));
	}  
	
	public function insert()
	{
		if(isset($_POST['submit']))
		{
			$uploadimage='';
			//$id=base64_decode($this->input->post('id'));
			$uploadimage=$_FILES['uploadimage']['name'];
			$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
       
			if($uploadimage != '') 
			{	
				$rname=rand(1111111,999999999);
				$date=date('Y-m-d');
				$uploadimage=$typename.'_profile_pic_'.$rname.$date.'.'.$extsign;
				
				$config['upload_path']          = './public/assets/upload/';
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
					redirect(base_url().'doctor/clinicreg/insert');
					exit();
				}

				if($this->doctorregmodel->gallery($uploadimage)) 
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
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('gallery');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
    }
	
    public function biomedicalmachine()
	{
		if(isset($_POST['submit']))
		{
			$uploadimage='';
			//$id=base64_decode($this->input->post('id'));
			$uploadimage=$_FILES['uploadimage']['name'];
			$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
			if($uploadimage != '') 
			{	
				$rname=rand(1111111,999999999);
				$date=date('Y-m-d');
				$uploadimage=$typename.'_profile_pic_'.$rname.$date.'.'.$extsign;
				
				$config['upload_path']          = './public/assets/upload/';
				$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG|PDF|pdf';
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
					redirect(base_url().'doctor/clinicreg/biomedicalmachine');
					exit();
				}

				if($this->doctorregmodel->biomedicalmachine($uploadimage)) 
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
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('equepment');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

         
    public function advertisment()
	{
		$edit_id = $this->input->get('edit') ? base64_decode($this->input->get('edit')) : null;
		$category_filter = $this->input->get('category');

		if (isset($_POST['submit']))
		{
			$id = $this->input->post('eid') ? base64_decode($this->input->post('eid')) : null;
			$uploadimage = '';

			// Direct Image URL provided
			$direct_image_url = trim($this->input->post('image_url'));
			if (!empty($direct_image_url)) {
				$uploadimage = $direct_image_url;
			}
			// File upload
			elseif (!empty($_FILES['uploadimage']['name']))
			{
				$extsign = pathinfo($_FILES['uploadimage']['name'], PATHINFO_EXTENSION);
				$rname = rand(1111111, 999999999);
				$uploadimage = 'ad_' . $rname . '_' . date('Y-m-d') . '.' . $extsign;

				$config['upload_path']   = './public/assets/upload/';
				$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG|webp|gif';
				$config['max_size']      = 5120;
				$config['file_name']     = $uploadimage;
				$this->load->library('upload', $config);

				if (!is_dir('./public/assets/upload/')) {
					@mkdir('./public/assets/upload/', 0777, true);
				}

				if (!$this->upload->do_upload('uploadimage'))
				{
					$error = $this->upload->display_errors();
					$flashmsg = '<div class="alert alert-danger"><strong>Upload Failed: </strong>' . $error . '</div>';
					$this->session->set_flashdata('flashmsg', $flashmsg);
					redirect(base_url() . 'doctor/clinicreg/advertisment');
					exit();
				}
			}

			if ($this->doctorregmodel->advertisment($uploadimage))
			{
				$msg = "<div class='alert alert-success'><strong>Success!</strong> Sponsored Advertisement saved successfully.</div>";
				$this->session->set_flashdata('flashmsg', $msg);
			}
			else
			{
				$msg = "<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
				$this->session->set_flashdata('flashmsg', $msg);
			}
			redirect(base_url() . 'doctor/clinicreg/advertisment');
			exit();
		}

		$data['advertisements']  = $this->doctorregmodel->get_advertisements($category_filter);
		$data['edit_ad']         = $edit_id ? $this->doctorregmodel->get_advertisement_by_id($edit_id) : null;
		$data['selected_cat']    = $category_filter;
		$data['heading_title']   = 'Sponsored Advertisements & Showcase Master';
		$data['module']          = 'Doctor';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('advertisment', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function advertisement()
	{
		$this->advertisment();
	}

	public function delete_ad($id)
	{
		$this->doctorregmodel->delete_advertisement($id);
		$this->session->set_flashdata('flashmsg', '<div class="alert alert-success">Advertisement deleted successfully.</div>');
		redirect(base_url() . 'doctor/clinicreg/advertisment');
	}

	public function toggle_ad($id)
	{
		$newSt = $this->doctorregmodel->toggle_ad_status($id);
		$this->session->set_flashdata('flashmsg', '<div class="alert alert-info">Advertisement status updated to ' . ($newSt == '1' ? 'ACTIVE' : 'INACTIVE') . '.</div>');
		redirect(base_url() . 'doctor/clinicreg/advertisment');
	}
}
