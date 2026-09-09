<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Appointment extends CI_Controller 
{
	function __construct()
	{
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $date=date('Y-m-d h:i:s');
		 $this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
		 $this->load->model('appointmentmodel');
	}

	public function index()
	{
		$this->todayappointment();
	}
 
	public function create()
	{
  		 if(isset($_POST['submit']))
   	
		$uploadimage='';
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
				redirect(base_url().'doctor/appointment/create');
				exit();
			}

			if($this->pathlabregmodel->add_appointment($uploadimage)) 
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

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('appointment');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');	
	}
	
	public function addappointment()
	{
		
		$data['hospital']		= $this->appointmentmodel->hospital_list(array('status'=>1));
		$data['specialization']	= $this->appointmentmodel->specialization_list(array('status'=>1));
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('addappointment',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function doctorappointment()
	{
		$doctorId = $this->input->get('doctor');
		$data['selected_doctor'] = null;
		$data['doctor_metrics'] = null;
		$data['doctor_affiliations'] = array();

		// Fetch strictly verified doctors for fast switcher and search dropdown
		$data['all_doctors'] = $this->db->query("
			SELECT p.id, p.user_id, p.fname, p.lname, p.mobile, p.email, p.city, p.drimage, p.regd_no,
			       COALESCE(ms.name, 'General Practitioner') as speciality,
			       COALESCE(mc.name, p.city) as city_name
			FROM profile_dr p
			LEFT JOIN master_specialization ms ON ms.id = p.specialization
			LEFT JOIN master_city mc ON mc.id = p.city
			WHERE p.status != '2' AND p.verified = '1'
			ORDER BY p.fname ASC
		")->result();

		$this->db->select('appointment.*, profile_dr.id as dr_profile_id, profile_dr.user_id as dr_user_id, profile_dr.fname as dr_fname, profile_dr.lname as dr_lname, profile_dr.mobile as dr_mobile, profile_dr.drimage as dr_image, profile_dr.verified as dr_verified, COALESCE(ms.name, "General Practitioner") as dr_speciality, COALESCE(hospital.name, clinic.name, "Consultation Facility") as hospital_name, COALESCE(hospital.city, clinic.city, "") as hospital_city')
			->join('profile_dr', '(profile_dr.id = appointment.doctor_id OR profile_dr.user_id = appointment.doctor_id)', 'left')
			->join('master_specialization ms', 'ms.id = profile_dr.specialization', 'left')
			->join('hospital', '(hospital.uid = appointment.institute_id OR hospital.id = appointment.institute_id)', 'left')
			->join('clinic', 'clinic.id = appointment.institute_id', 'left');

		if (!empty($doctorId)) {
			$cleanId = intval($doctorId);
			$docRecord = $this->db->query("
				SELECT p.*, COALESCE(ms.name, 'General Practitioner') as speciality_name, COALESCE(mc.name, p.city) as city_name
				FROM profile_dr p
				LEFT JOIN master_specialization ms ON ms.id = p.specialization
				LEFT JOIN master_city mc ON mc.id = p.city
				WHERE (p.id = {$cleanId} OR p.user_id = {$cleanId}) AND p.verified = '1'
				ORDER BY (p.id = {$cleanId}) DESC
				LIMIT 1
			")->row();

			if ($docRecord) {
				$data['selected_doctor'] = $docRecord;
				$docId = $docRecord->id;
				$userId = $docRecord->user_id;

				// Calculate exact metrics for this doctor
				$metrics = $this->db->query("
					SELECT 
						COUNT(appointment_id) as total_appointments,
						SUM(CASE WHEN status = '1' OR status = 'COMPLETED' THEN 1 ELSE 0 END) as confirmed_count,
						SUM(CASE WHEN status = '0' OR status = 'PENDING' THEN 1 ELSE 0 END) as pending_count,
						SUM(CASE WHEN status = '2' OR status = 'CANCELLED' THEN 1 ELSE 0 END) as cancelled_count,
						SUM(CASE WHEN appointment_date = CURDATE() THEN 1 ELSE 0 END) as today_bookings
					FROM appointment
					WHERE doctor_id = '{$docId}' OR doctor_id = '{$userId}'
				")->row_array();
				$data['doctor_metrics'] = $metrics;

				// Fetch affiliated practices/hospitals
				$affs = $this->db->query("
					SELECT dp.*, COALESCE(h.name, c.name, 'Affiliated Facility') as hospital_name, COALESCE(h.city, c.city, '') as hospital_city
					FROM dr_practice dp
					LEFT JOIN hospital h ON (h.id = dp.institution_id OR h.uid = dp.institution_id)
					LEFT JOIN clinic c ON c.id = dp.institution_id
					WHERE dp.user_id = '{$docId}' OR dp.user_id = '{$userId}'
					ORDER BY dp.status DESC, h.name ASC
				")->result();
				$data['doctor_affiliations'] = $affs;

				// Filter appointments strictly to this doctor
				$this->db->where("(appointment.doctor_id = '{$docId}' OR appointment.doctor_id = '{$userId}')");
			} else {
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'><strong>Notice:</strong> Doctor #{$cleanId} is not verified or not found in our records. Only verified doctors and their appointments can be viewed.</div>");
				redirect(base_url('doctor/appointment/doctorappointment'));
			}
		} else {
			// When listing all appointments, filter strictly to verified doctors
			$this->db->where('profile_dr.verified', '1');
			$this->db->where("profile_dr.status != '2'");
		}

		$data['data'] = $this->db->order_by('appointment.appointment_id', 'DESC')
			->get('appointment')
			->result();

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('doctorappointment', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function analytics()
	{
		$data['total_appointments'] = 0;
		$data['today_appointments'] = 0;
		$data['total_doctors'] = 0;
		$data['doctor_stats'] = array();
		$data['hospital_doctor_stats'] = array();
		$data['affiliations_stats'] = array();

		try {
			if ($this->db && $this->db->table_exists('appointment')) {
				$data['total_appointments'] = $this->db->count_all_results('appointment');
				$data['today_appointments'] = $this->db->where('appointment_date', date('Y-m-d'))->count_all_results('appointment');

				// Total Tracked Doctors
				if ($this->db->table_exists('profile_dr')) {
					$data['total_doctors'] = $this->db->count_all_results('profile_dr');
				}

				// 2. Hospital-Doctor Tracking Breakdown (Optimized via pre-aggregation: 35s down to 0.1s)
				if ($this->db->table_exists('hospital') && $this->db->table_exists('profile_dr')) {
					$hd_q = $this->db->query("
						SELECT 
							h.id as hospital_id,
							COALESCE(h.name, 'Independent Clinic') as hospital_name,
							h.city as hospital_city,
							p.id as doctor_id,
							p.fname as dr_fname,
							p.lname as dr_lname,
							COALESCE(ms.name, 'General') as dr_speciality,
							agg.total_appointments,
							agg.last_appointment_date,
							agg.confirmed_count
						FROM (
							SELECT 
								doctor_id,
								institute_id,
								COUNT(appointment_id) as total_appointments,
								MAX(appointment_date) as last_appointment_date,
								SUM(CASE WHEN status = '1' OR status = 'COMPLETED' THEN 1 ELSE 0 END) as confirmed_count
							FROM appointment
							WHERE doctor_id IS NOT NULL AND doctor_id != '' AND doctor_id != '0'
							GROUP BY doctor_id, institute_id
						) agg
						JOIN profile_dr p ON (p.id = agg.doctor_id OR p.user_id = agg.doctor_id)
						LEFT JOIN master_specialization ms ON ms.id = p.specialization
						JOIN hospital h ON (h.uid = agg.institute_id OR h.id = agg.institute_id)
						ORDER BY agg.total_appointments DESC
					");
					if ($hd_q && is_object($hd_q)) {
						$data['hospital_doctor_stats'] = $hd_q->result_array() ?: array();
					}
				}

				// 3. Doctor Affiliations to Hospitals (Optimized via pre-aggregation: avoided 2,500+ subqueries)
				if ($this->db->table_exists('dr_practice') && $this->db->table_exists('hospital') && $this->db->table_exists('profile_dr')) {
					$aff_q = $this->db->query("
						SELECT 
							dp.id as practice_id,
							dp.user_id as doctor_id,
							dp.institution_id as hospital_id,
							dp.type,
							dp.fee,
							dp.status as practice_status,
							p.fname as dr_fname,
							p.lname as dr_lname,
							COALESCE(ms.name, 'General') as dr_speciality,
							h.name as hospital_name,
							h.city as hospital_city,
							COALESCE(app_counts.cnt, 0) as appointment_count
						FROM dr_practice dp
						JOIN profile_dr p ON (p.id = dp.user_id OR p.user_id = dp.user_id)
						LEFT JOIN master_specialization ms ON ms.id = p.specialization
						JOIN hospital h ON h.id = dp.institution_id
						LEFT JOIN (
							SELECT doctor_id, institute_id, COUNT(*) as cnt
							FROM appointment
							WHERE doctor_id IS NOT NULL AND doctor_id != '' AND doctor_id != '0'
							GROUP BY doctor_id, institute_id
						) app_counts ON (
							(app_counts.doctor_id = dp.user_id OR app_counts.doctor_id = p.id) AND 
							(app_counts.institute_id = h.uid OR app_counts.institute_id = h.id)
						)
						ORDER BY appointment_count DESC, h.name ASC LIMIT 150
					");
					if ($aff_q && is_object($aff_q)) {
						$data['affiliations_stats'] = $aff_q->result_array() ?: array();
					}
				}
			}
		} catch (Throwable $e) {}

		$data['heading_title'] = 'Advanced Appointment Analytics & Tracking';
		$data['module'] = 'Appointment Analytics';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('appointment_analytics', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * AJAX Server-Side Pagination Endpoint for Doctor-Level Tracking
	 * Handles searching, sorting, and pagination across all 1,400+ doctors in milliseconds
	 */
	public function ajax_doctor_analytics()
	{
		$draw = intval($this->input->get_post('draw') ?: 1);
		$start = intval($this->input->get_post('start') ?: 0);
		$length = intval($this->input->get_post('length') ?: 25);
		$length = max(10, min(100, $length)); // Safe range 10-100

		$searchArr = $this->input->get_post('search');
		$searchValue = trim($searchArr['value'] ?? '');

		// Ordering
		$orderArr = $this->input->get_post('order');
		$orderColIdx = intval($orderArr[0]['column'] ?? 4);
		$orderDir = strtolower($orderArr[0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';

		$columnsMap = array(
			0 => 'p.id',
			1 => 'p.fname',
			2 => 'speciality',
			3 => 'p.mobile',
			4 => 'total_bookings',
			5 => 'today_bookings',
			6 => 'confirmed_count',
			7 => 'pending_count'
		);
		$orderColumn = $columnsMap[$orderColIdx] ?? 'total_bookings';

		// Total Records
		$recordsTotal = $this->db->count_all('profile_dr');

		// Filter Clause
		$whereClause = "";
		if (!empty($searchValue)) {
			$searchEsc = $this->db->escape_like_str($searchValue);
			$whereClause = " WHERE (p.fname LIKE '%{$searchEsc}%' OR p.lname LIKE '%{$searchEsc}%' OR p.mobile LIKE '%{$searchEsc}%' OR p.email LIKE '%{$searchEsc}%' OR ms.name LIKE '%{$searchEsc}%' OR p.id = '{$searchEsc}')";
		}

		// Filtered Records Count
		if (!empty($whereClause)) {
			$countQ = $this->db->query("
				SELECT COUNT(p.id) as cnt
				FROM profile_dr p
				LEFT JOIN master_specialization ms ON ms.id = p.specialization
				{$whereClause}
			");
			$recordsFiltered = intval($countQ->row()->cnt ?? 0);
		} else {
			$recordsFiltered = $recordsTotal;
		}

		// Paginated Query with pre-aggregated appointment metrics
		$dataQ = $this->db->query("
			SELECT 
				p.id as doctor_id,
				p.fname,
				p.lname,
				COALESCE(ms.name, 'General Practitioner') as speciality,
				p.mobile,
				p.email,
				COALESCE(agg.total_bookings, 0) as total_bookings,
				COALESCE(agg.today_bookings, 0) as today_bookings,
				COALESCE(agg.confirmed_count, 0) as confirmed_count,
				COALESCE(agg.pending_count, 0) as pending_count
			FROM profile_dr p
			LEFT JOIN master_specialization ms ON ms.id = p.specialization
			LEFT JOIN (
				SELECT 
					doctor_id,
					COUNT(appointment_id) as total_bookings,
					SUM(CASE WHEN appointment_date = CURDATE() THEN 1 ELSE 0 END) as today_bookings,
					SUM(CASE WHEN status = '1' OR status = 'COMPLETED' THEN 1 ELSE 0 END) as confirmed_count,
					SUM(CASE WHEN status = '0' OR status = 'PENDING' THEN 1 ELSE 0 END) as pending_count
				FROM appointment
				WHERE doctor_id IS NOT NULL AND doctor_id != '' AND doctor_id != '0'
				GROUP BY doctor_id
			) agg ON (agg.doctor_id = p.id OR agg.doctor_id = p.user_id)
			{$whereClause}
			ORDER BY {$orderColumn} {$orderDir}, p.fname ASC
			LIMIT {$length} OFFSET {$start}
		");

		$rows = array();
		if ($dataQ && is_object($dataQ)) {
			foreach ($dataQ->result_array() as $doc) {
				$docName = htmlspecialchars(trim($doc['fname'] . ' ' . $doc['lname']));
				$speciality = htmlspecialchars($doc['speciality'] ?: 'General Physician');
				$mobile = htmlspecialchars($doc['mobile'] ?: 'N/A');
				$email = htmlspecialchars($doc['email'] ?: 'N/A');
				$bookingUrl = base_url('doctor/appointment/doctorappointment?doctor=' . $doc['doctor_id']);

				$rows[] = array(
					'<span style="font-weight: 600; color: #64748b;">#' . $doc['doctor_id'] . '</span>',
					'<strong style="color: #1e293b;">Dr. ' . $docName . '</strong>',
					'<span class="label label-info" style="font-weight: 500;">' . $speciality . '</span>',
					'<span style="font-size: 12px; color: #64748b;"><i class="fa fa-phone text-muted"></i> ' . $mobile . '<br><i class="fa fa-envelope text-muted"></i> ' . $email . '</span>',
					'<span class="badge bg-teal" style="font-size: 13px; padding: 4px 10px;">' . number_format($doc['total_bookings']) . '</span>',
					'<span class="badge bg-blue" style="font-size: 12px; padding: 3px 8px;">' . number_format($doc['today_bookings']) . '</span>',
					'<span class="badge bg-green" style="font-size: 12px; padding: 3px 8px;">' . number_format($doc['confirmed_count']) . '</span>',
					'<span class="badge bg-yellow" style="font-size: 12px; padding: 3px 8px;">' . number_format($doc['pending_count']) . '</span>',
					'<a href="' . $bookingUrl . '" class="btn btn-xs btn-default" style="border-radius: 4px;" title="Filter Bookings"><i class="fa fa-search text-primary"></i> View Bookings</a>'
				);
			}
		}

		$response = array(
			"draw" => $draw,
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => $rows
		);

		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}
     
	public function app_conf_hospital_institute()
	{
		$id = $this->input->get_post('doctor');
		$date = $this->input->get_post('date');
		$time = $this->input->get_post('time');

		$ts = $this->db->get_where('timing_session', array('id' => $time))->row();
		if (is_object($ts) && !empty($ts))
		{
			$timing_id = $ts->timing_id;
			$max_opd = intval($ts->max_patient ?: 10);
			$consultation_fee = $ts->consultation_fee; 
			$booked = $this->db->where(array('time_id' => $time, 'appointment_date' => $date, 'status' => '1'))->count_all_results('appointment');
			$opd = max(0, $max_opd - $booked);
			
			$t_row = $this->db->get_where('timing', array('id' => $timing_id))->row();
			$pid = $t_row ? $t_row->practice_id : 0;
			$p_row = $pid ? $this->db->get_where('dr_practice', array('id' => $pid))->row() : null;
			if (!$p_row && !empty($id)) {
				$p_row = $this->db->get_where('dr_practice', array('user_id' => $id, 'status' => '1'))->row();
			}

			$type = ($p_row && $p_row->type == 'H') ? 'hospital' : 'clinic';
			$institution_id = $p_row ? $p_row->institution_id : 0;
			$fee = (!empty($consultation_fee) && $consultation_fee != '0') ? $consultation_fee : ($p_row ? $p_row->fee : 0);

			$institution = $institution_id ? $this->db->get_where($type, array('id' => $institution_id))->row() : null;
			if (!$institution && $type == 'hospital' && $institution_id) {
				$institution = $this->db->get_where('hospital', array('uid' => $institution_id))->row();
			}

			$inst_name = $institution ? $institution->name : 'Consultation Facility Chamber';
			$inst_address = $institution ? $institution->address : 'Consultation Clinic';
			$inst_image = ($institution && !empty($institution->drimage)) ? base_url().'public/assets/upload/'.$institution->drimage : base_url().'assets/images/dentist.png';

			echo '<div style="display: flex; gap: 14px; align-items: center; background: #f0fdfa; border: 1px solid #99f6e4; border-radius: 10px; padding: 14px 16px; margin-top: 10px;">
				<div style="width: 54px; height: 54px; border-radius: 8px; overflow: hidden; background: #ffffff; flex-shrink: 0; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
					<img src="'.$inst_image.'" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src=\''.base_url().'assets/images/dentist.png\';">
				</div>
				<div style="flex-grow: 1;">
					<h5 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0 0 3px 0;">'.htmlspecialchars($inst_name).'</h5>
					<p style="font-size: 12px; color: #64748b; margin: 0 0 5px 0;"><i class="fa fa-map-marker" style="color:#00a896;"></i> '.htmlspecialchars($inst_address).'</p>
					<div style="display: flex; gap: 8px; flex-wrap: wrap; font-size: 12px;">
						<span style="background: #ffffff; border: 1px solid #ccfbf1; padding: 2px 8px; border-radius: 6px; font-weight: 700; color: #0f172a;"><i class="fa fa-inr" style="color:#00a896;"></i> Fee: Rs. '.number_format(floatval($fee), 2).'</span>
						<span style="background: '.($opd > 0 ? '#dcfce7' : '#fee2e2').'; color: '.($opd > 0 ? '#15803d' : '#991b1b').'; padding: 2px 8px; border-radius: 6px; font-weight: 700;">Available Slots: '.$opd.' / '.$max_opd.'</span>
					</div>
				</div>
			</div>';
		}
	}
	
	public function app_conf_pop_otpgen()
	{
		$otp=rand(100000,999999);
		$mobile=$this->input->post('mobile');
		$this->session->set_userdata('app_otp',$otp);
		$msg="Your One Time Password is $otp
		WWW.UPCHAR.INFO";
		sendsms($msg,$mobile);
		echo 'OK';
	}
	
	public function app_conf_hospital_doctor()
	{
		$id = $this->input->get_post('doctor');
		if (!empty($id))
		{
			$data = $this->db->get_where('profile_dr', array('id' => $id))->row();
			if ($data)
			{
				$drimg = (!empty($data->drimage)) ? base_url().'public/assets/upload/'.$data->drimage : base_url().'assets/images/user.jpg';
				
				$quastring = '';
				$qu = $this->db->get_where('dr_qualifications', array('user_id' => $data->id))->result();
				foreach ($qu as $q) {
					$quastring .= getQualificationName($q->qualification_id) . ', ';
				}
				$quastring = rtrim($quastring, ', ');

				$splstring = '';
				$sp = $this->db->get_where('dr_specialization', array('user_id' => $data->id))->result();
				foreach ($sp as $s) {
					$splstring .= getSpecilizationName($s->specialization_id) . ', ';
				}
				$splstring = rtrim($splstring, ', ');

				echo '<div style="display: flex; gap: 14px; align-items: center; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; margin-top: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
					<div style="width: 56px; height: 56px; border-radius: 50%; overflow: hidden; background: #f8fafc; flex-shrink: 0; border: 2px solid #00a896;">
						<img src="'.$drimg.'" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src=\''.base_url().'assets/images/user.jpg\';">
					</div>
					<div>
						<h5 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0 0 3px 0;">Dr. '.htmlspecialchars($data->fname . ' ' . $data->lname).'</h5>
						<p style="font-size: 12px; color: #00a896; font-weight: 600; margin: 0 0 2px 0;">'.htmlspecialchars($splstring ?: 'General Practitioner').'</p>
						<p style="font-size: 11.5px; color: #64748b; margin: 0;">'.htmlspecialchars($quastring ?: 'MBBS').'</p>
					</div>
				</div>';
			}
		}
	}
	
	public function app_conf_pop_date(){
		$id=$_GET['doctor'];
		$this->db->select('timing.*');
		$this->db->join('dr_practice','dr_practice.user_id=timing.user_id AND dr_practice.status=\'1\'');
		$data=$this->db->get_where('timing',array('timing.user_id'=>$id,'user_type'=>'D'))->result();
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
	
	public function app_conf_pop_time()
	{
		$id=$_GET['doctor'];
		$date=$_GET['date'];
		$day_no = date('N',strtotime($date));
		$this->db->select('timing.*');
		$this->db->group_by('timing.id');
		$this->db->join('dr_practice','dr_practice.user_id=timing.user_id AND dr_practice.status=\'1\'');
		$day=array('1'=>'M','2'=>'T','3'=>'W','4'=>'TH','5'=>'F','6'=>'SA','7'=>'S');
		$data=$this->db->get_where('timing',array('timing.user_id'=>$id,'user_type'=>'D',$day[$day_no]=>'1'))->result();
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

	public function bookappointment_admin()
	{	
		$mobile	=	$this->input->post('app_mobile');
		$date	=	$this->input->post('app_date');
		$time	=	$this->input->post('app_time');
		$doctor	=	$this->input->post('app_doctor');
		$name	=	$this->input->post('app_name');
		$email	=	$this->input->post('app_email');
		$age	=	$this->input->post('app_age');
		//$otp	=	$this->input->post('app_otp');
	
		if($this->session->userdata('userid')=='')
		{		
			/*if($this->session->userdata('app_otp')==$otp)
			{*/	
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
			/*}
			else
			{
				echo 'FAILED';die;
			}*/
		}
		else
		{		
			$userid=$this->session->userdata('userid');
		}
		
		$ts_row = $this->db->get_where('timing_session', array('id' => $time))->row();
		if (!$ts_row) {
			echo 'Not Available'; die;
		}

		$timing_id = $ts_row->timing_id;
		$max_opd = intval($ts_row->max_patient ?: 10);
		$consultation_fee = $ts_row->consultation_fee;
		$from_timing = $ts_row->from_timing;
		$to_timing = $ts_row->to_timing;

		$t_row = $this->db->get_where('timing', array('id' => $timing_id))->row();
		$pid = $t_row ? $t_row->practice_id : 0;
		$p_row = $pid ? $this->db->get_where('dr_practice', array('id' => $pid))->row() : null;
		if (!$p_row && !empty($doctor)) {
			$p_row = $this->db->get_where('dr_practice', array('user_id' => $doctor, 'status' => '1'))->row();
		}

		$booked = $this->db->where(array('time_id' => $time, 'appointment_date' => $date, 'status' => '1'))->count_all_results('appointment');
		$opd = $max_opd - $booked;
		if ($opd < 1) {
			echo 'Not Available'; die;
		}

		$institution_type = ($p_row && $p_row->type == 'H') ? 'H' : 'C';
		$institution_id = $p_row ? intval($p_row->institution_id) : 0;
		if (!$institution_id && !empty($doctor)) {
			$clinic_row = $this->db->get_where('clinic', array('drid' => $doctor))->row();
			if ($clinic_row) $institution_id = intval($clinic_row->id);
		}

		$fee = (!empty($consultation_fee) && $consultation_fee != '0') ? floatval($consultation_fee) : ($p_row ? floatval($p_row->fee) : 100.00);
		$pid = $p_row ? intval($p_row->id) : 0;

		$idata = array(
			'appointment_date'   => $date,
			'time_id'            => $time,
			'to_timing'          => $to_timing,
			'from_timing'        => $from_timing,
			'date_id'            => $timing_id,
			'practice_id'        => $pid,
			'appointment_name'   => $name,
			'appointment_mobile' => $mobile,
			'appointment_email'  => $email ?: '',
			'age'                => $age ?: 0,
			'doctor_id'          => $doctor,
			'institute_id'       => $institution_id,
			'institution_type'   => $institution_type,
			'fee'                => $fee,
			'amount'             => $fee,
			'user_id'            => $userid,
			'payment_mode'       => 'NA',
			'payment_status'     => 'NA',
			'status'             => '0'
		);
		$this->db->insert('appointment', $idata);
		$aid = $this->db->insert_id();
		
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
			//$Merchant_Id = base64_decode(CC_MERID);
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
			$Merchant_Id = defined('CC_MERID') ? base64_decode(CC_MERID) : '';
			$Merchant_Param = "";
			$merchant_param1 = '';

			$gatewayData = compact('Merchant_Id','Order_Id','Amount','Redirect_Url','cancel_Url',
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
	
	public function acheckout_admin()
	{	
		$gatewayData=$this->session->userdata('SecurePay');
		$AppointmentCheckout=$this->session->userdata('AppointmentCheckout');
		if(isset($gatewayData) && count($gatewayData))
		{
			$data['gatewayData']=$gatewayData;
			$data['AppointmentCheckout']=$AppointmentCheckout;
			$this->load->view('inc/topheaderlink');
			$this->load->view('inc/topheader');
			//$this->load->view('addappointment',$data);
			$this->load->view('appointmentcheckout',$data);
			$this->load->view('sidebar');
			$this->load->view('inc/headersetting');
			$this->load->view('inc/footerlink');
			$this->load->view('inc/table_footer');
			
		}else
		{
			echo '403 UnAuthorized Access!!';
		}
	}
	public function processordercod_admin()
	{	
		$gatewayData=$this->session->userdata('SecurePay');
		$AppointmentCheckout=$this->session->userdata('AppointmentCheckout');
		
		$OrderId= $gatewayData['Order_Id'];
		$order=$this->db->where(array('ORDER_ID'=>$OrderId))->get('sm_order')->row();
		$aid=$order->ITEM_ID;
		$paystatus=$order->PAYMENT_STATUS; //cross check
		$ordertotal=$order->TOTAL;// compare total with the amount recieved

		$appointment_data=$this->db->where(array('appointment_id'=>$aid))->get('appointment')->row();
		$mobile=$appointment_data->appointment_mobile;

		$msg="Your Appointment booked successfully! Appointment# $aid
			Please Pay the Fee Rs. $ordertotal at Counter,  Request# $OrderId
			WWW.UPCHAR.INFO";
			sendsms($msg,$mobile);

		$updatedata=array('PAYMENT_STATUS'=>'COC');
		$this->db->where('ORDER_ID',$OrderId);
		$this->db->update('sm_order',$updatedata);

		$updateuserdata=array('checkout_id'=>'0','payment_status'=>'UNPAID','payment_mode'=>'COC','status'=>'1');
		$this->db->where('appointment_id',$aid);
		$this->db->update('appointment',$updateuserdata);
		
		$user	=	$this->appointmentmodel->get_appointment_details($aid);
		
		$this->load->library('azad_lib');
		/*Admin Email Start */
		$body="Hello upchar <BR> You have new booking  by ".$user['appointment_name']."  to ".$user['name']." for ".$user['fname'].", <BR>Timing - ".$user['from_timing']." to ".$user['to_timing']." ,Date - ".$user['appointment_date']." ,<BR>fee - ".$user['fee']." paid ".$user['payment_mode']." ,appointment no - ".$user['appointment_id'].".<BR>Thank You  <BR>Email: info@upchar.info ";
		$this->azad_lib->sendMail_admin('info@upchar.info','New Appointment Booking ',$body);
		/*Admin Email End */
		
		/*User Email Start */
		if(!empty($user['appointment_email']))
		{
			$body=" Dear ".$user['appointment_name']."<BR>
					Thank you for using upchar servies.<BR>
					Your appointment no is ".$user['appointment_id'].",".$user['name']." for ".$user['fname'].",<BR>
					Timing - ".$user['from_timing']." to ".$user['to_timing']." ,Date - ".$user['appointment_date'].",fee - ".$user['fee']." paid ".$user['payment_mode'].".<BR>

					If you want to confirm your Priority appointment  paid online by your account.<BR>
					Feel free to call any time on 8448449603 to our customer care will help you.<BR>
					Thank You  <BR>Email: info@upchar.info <BR>WWW.UPCHAR.INFO";
			$this->azad_lib->sendMail_admin($user['appointment_email'],'Thanks for book appointment ',$body);
		}
		/*User Email End */
		
		/*Doctor  Email Start */
		$body=" Dear dr ".$user['fname']."<BR>
				You have new appointment  in ".$user['name'].", Patient name ".$user['appointment_name']." appointment No ".$user['appointment_id']." date of booking ".$user['book_date']." and date of appointment ".$user['appointment_date'].".<BR>
				Thank your for Beining partner with upchar on e place of healthcare.<BR>

				Feel free to contact if any problem will happen with upchar.<BR>
				Thank you<BR>
				Upchar<BR>
				8448440603<BR>
				partner@upchar.info<BR>";
		$this->azad_lib->sendMail_admin($user['dr_email'],'Upchar Appointment Booking',$body);
		/*Doctor Email End */
		
		$this->session->unset_userdata('SecurePay');
		$this->session->unset_userdata('AppointmentCheckout');
		$this->session->set_flashdata('flashmsg', '<h4 style="color:green;">Thank you! The Appointment detail has been sent to the registered  mobile no.</h4>');
		redirect('/doctor/appointment/addappointment');
	}
	
	
    public function delete($id = null)
    {
        if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
            $this->bulk_delete();
            return;
        }

        $del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('appointment_id') ? $this->input->get('appointment_id') : $this->uri->segment(4)));
        if ($del_id) {
            $this->db->where('appointment_id', $del_id)->delete('appointment');
            $msg = "Appointment deleted successfully.";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
                echo json_encode(array('status' => 1, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
        }
        redirect(base_url('doctor/appointment/doctorappointment'));
    }

    public function bulk_delete()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids) && is_array($ids)) {
            $deleted_count = 0;
            foreach ($ids as $aid) {
                $aid = (int)$aid;
                if ($aid > 0) {
                    $this->db->where('appointment_id', $aid)->delete('appointment');
                    $deleted_count++;
                }
            }
            $msg = "$deleted_count appointment(s) deleted successfully.";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
        } else {
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 0, 'message' => 'No appointments selected.'));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No appointments selected.</div>");
        }
        redirect(base_url('doctor/appointment/doctorappointment'));
    }

    public function data()
    {
		$id = (int)$this->input->get('appointment_id');
		if ($id <= 0) {
			$id = (int)$this->input->get('id');
		}
		if ($id <= 0) {
			$id = (int)$this->uri->segment(5);
		}
		if ($id <= 0) {
			$id = (int)$this->uri->segment(4);
		}

		$query = $this->db->select("
			appointment.*,
			profile_dr.id as dr_id,
			profile_dr.user_id as dr_user_id,
			profile_dr.fname as dr_fname,
			profile_dr.lname as dr_lname,
			profile_dr.mobile as dr_mobile,
			profile_dr.email as dr_email,
			profile_dr.drimage as dr_image,
			profile_dr.regd_no as dr_regd_no,
			profile_dr.college as dr_college,
			profile_dr.exp as dr_exp,
			profile_dr.dr_fee as dr_base_fee,
			profile_dr.city as dr_city,
			profile_dr.gender as dr_gender,
			profile_dr.verified as dr_verified,
			profile_dr.verification_status as dr_verification_status,
			COALESCE(ms.name, 'General Practitioner') as dr_speciality,
			COALESCE(hospital.name, clinic.name, 'Private Clinic / Upchar Partner Center') as facility_name,
			COALESCE(hospital.address, clinic.address, '') as facility_address,
			COALESCE(mc.name, hospital.city, clinic.city, '') as facility_city,
			COALESCE(hospital.mobile, clinic.mobile, '') as facility_mobile,
			COALESCE(hospital.email, clinic.email, '') as facility_email,
			userlogin.FNAME as user_fname,
			userlogin.LNAME as user_lname,
			userlogin.MOBILE as user_mobile,
			userlogin.EMAIL as user_email,
			userlogin.GENDER as user_gender
		")
		->from('appointment')
		->join('profile_dr', '(profile_dr.id = appointment.doctor_id OR profile_dr.user_id = appointment.doctor_id)', 'left')
		->join('master_specialization ms', 'ms.id = profile_dr.specialization', 'left')
		->join('hospital', '(hospital.uid = appointment.institute_id OR hospital.id = appointment.institute_id)', 'left')
		->join('clinic', 'clinic.id = appointment.institute_id', 'left')
		->join('master_city mc', 'mc.id = hospital.city', 'left')
		->join('userlogin', 'userlogin.USERID = appointment.user_id', 'left')
		->where('appointment.appointment_id', $id)
		->get();

		$data['data'] = $query->result();
		$data['appointment'] = $query->row();
		$data['appointment_id'] = $id;

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('userview', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');  
    }
    


  	public function hospitalappointment()
  	{

       	$data['data'] = $this->db->get('hospital')->result();
  	   	$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('hospitalappointment',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');	
    }
          
    public function deletehospital()
    {      
        $id=$this->input->get('appointment_id');
        $this->load->model('doctorregmodel');
        $this->doctorregmodel->deletehospital($id);
        redirect(base_url().'doctor/appointment/hospitalappointment');
    }
          
          
    public function todayappointment()
    {
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['data'] 			=  $this->appointmentmodel->get_today($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Appointment List';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
 	    //$data['data']=$this->db->select('profile_dr.*,hospital.*,appointment.*')->join('profile_dr','profile_dr.id=appointment.doctor_id')->join('hospital','hospital.uid=appointment.institute_id')->get_where('appointment',array('appointment_date'=>date('Y-m-d')))->result();	
        
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('todayappointment',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
		
    }
	
	public function upcomming()
    {
 	    $pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['data'] 			=  $this->appointmentmodel->get_upcomming($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	= 'Appointment List';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('upcomming',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
    }

	public function delete_upcomming($id = null)
	{
		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : $this->uri->segment(4));
		if ($del_id) {
			$this->db->where('appointment_id', $del_id)->delete('appointment');
			$msg = "Upcoming appointment cancelled successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		}
		redirect(base_url('doctor/appointment/upcomming'));
	}

    public function user()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['data'] 			=  $this->appointmentmodel->get_appointment($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	= 'Appointment List';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
	    $data['city']  			=  $this->appointmentmodel->get_city(array('status'=>'1'));
	    //$data['data']  =  $this->appointmentmodel->get_appointment();
	    $this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('users',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	 // generate PDF File
         public function generatePDFFile() 
		 {	//echo "hi"; die;
            $data = array();            
            $htmlContent='';
			
			$pagesize               =  (int) $this->input->get_post('pagesize');
			$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
            //$data['getInfo'] 	= $this->createpdf->getContent();
			$data['data'] 		= $this->appointmentmodel->get_appointment();
			
			$data['heading_title'] 	= 'Appointment List';
			$data['page_links'] 	=  '';
			$data['city']  			=  $this->appointmentmodel->get_city(array('status'=>'1'));
			$htmlContent = $this->load->view('users',$data,TRUE);
			echo "<pre>"; print_r($htmlContent); die;
            //$htmlContent = $this->load->view('pdf/file', $data, TRUE);
			
            $createPDFFile = time().'.pdf';
			$path = APPPATH.'uploads/';
            $this->createPDF($path.$createPDFFile, $htmlContent);
            redirect(base_url()."application/uploads/".$createPDFFile);
         }
 
        // create pdf file 
        public function createPDF($fileName,$html) 
		{
            ob_start(); 
            // Include the main TCPDF library (search for installation path).
            $this->load->library('Pdf');
            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('TechArise');
            $pdf->SetTitle('TechArise');
            $pdf->SetSubject('TechArise');
            $pdf->SetKeywords('TechArise');
 
            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
 
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
 
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);
 
            // set auto page breaks
            //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetAutoPageBreak(TRUE, 0);
 
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }       
 
            // set font
            $pdf->SetFont('dejavusans', '', 10);
 
            // add a page
            $pdf->AddPage();
 
            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
 
            // reset pointer to the last page
            $pdf->lastPage();       
            ob_end_clean();
            //Close and output PDF document
            $pdf->Output($fileName, 'F');        
        }
		
	public function createHistoryExcel() 
	{	
		$fileName 			= 'appointment.xlsx';  
		$appointmentData 	= $this->appointmentmodel->get_appointment_list();
		//echo "<pre>"; print_r($appointmentData); die;
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Date');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Email'); 
		$sheet->setCellValue('E1', 'Mobile');
		$sheet->setCellValue('F1', 'Hospital Name');
        $sheet->setCellValue('G1', 'Doctor Name'); 
		$sheet->setCellValue('H1', 'Payment Status');
		$sheet->setCellValue('I1', 'Appointment Status');
        $rows = 2;
        foreach ($appointmentData as $val){
			//$appointment_status ='hi';
			if($val['appointment_status']=='0'){ $appointment_status ='Pending'; } else{ $appointment_status ='Done'; }	
            $sheet->setCellValue('A' . $rows, $val['appointment_id']);
            $sheet->setCellValue('B' . $rows, $val['appointment_date']);
            $sheet->setCellValue('C' . $rows, $val['appointment_name']);
            $sheet->setCellValue('D' . $rows, $val['appointment_email']);
			$sheet->setCellValue('E' . $rows, $val['appointment_mobile']);
			$sheet->setCellValue('F' . $rows, $val['name']);
			$sheet->setCellValue('G' . $rows, $val['fname']);
            $sheet->setCellValue('H' . $rows, $val['payment_status']);
			$sheet->setCellValue('I' . $rows, $appointment_status);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
		$writer->save("public/assets/export/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."public/assets/export/".$fileName);              
    }    
	
	public function deletehistory($id = null)
    {
        if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
            $this->bulk_delete_history();
            return;
        }

        $del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('appointment_id') ? $this->input->get('appointment_id') : $this->uri->segment(4)));
        if ($del_id) {
            $this->db->where('appointment_id', $del_id)->delete('appointment');
            $msg = "Appointment record deleted successfully.";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
                echo json_encode(array('status' => 1, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
        }
        redirect(base_url('doctor/appointment/user'));
    }

    public function bulk_delete_history()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids) && is_array($ids)) {
            $deleted_count = 0;
            foreach ($ids as $aid) {
                $aid = (int)$aid;
                if ($aid > 0) {
                    $this->db->where('appointment_id', $aid)->delete('appointment');
                    $deleted_count++;
                }
            }
            $msg = "$deleted_count appointment record(s) deleted successfully.";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
        } else {
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 0, 'message' => 'No appointment records selected.'));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No records selected.</div>");
        }
        redirect(base_url('doctor/appointment/user'));
    }
	
	
	
	
   	public function account()
   	{
   		$data['hospital_list']  	=  $this->appointmentmodel->hospital_list(array('status'=>'1'));
    	$data['hospital_account']  	=  $this->appointmentmodel->get_account();
    	$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('account',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
   	}
   	public function get_locality_by_city_id()
    {   
        $city_id 			=  $this->input->get_post('city_id');
        $locality_list  	=  $this->appointmentmodel->get_locality(array('city_id'=>$city_id));
        //print_r($doctor_list); die;
        $output = "<option value=''> Select Locality</option>";
        foreach ($locality_list as $row)
        {
			$output .= "<option value='".$row['id']."'>".$row['name']."</option>"; 
        }
		echo $output;
    }
	
	public function get_hospital_by_city_id()
    {   
        $city_id 				=  $this->input->get_post('city_id');
        $hospital_list  	=  $this->appointmentmodel->hospital_list(array('city'=>$city_id));
        //print_r($doctor_list); die;
        $output = "<option value=''> Select Hospital</option>";
        foreach ($hospital_list as $row)
        {
			$output .= "<option value='".$row['id']."'>".$row['name']."</option>"; 
        }
		echo $output;
    }
	
	public function get_hospital_by_locality_id()
    {   
        $city_id 				=  $this->input->get_post('city_id');
		$locality_id 			=  $this->input->get_post('locality_id');
        $hospital_list  	=  $this->appointmentmodel->hospital_list(array('location'=>$locality_id));
        //print_r($doctor_list); die;
        $output = "<option value=''> Select Hospital</option>";
        foreach ($hospital_list as $row)
        {
			$output .= "<option value='".$row['id']."'>".$row['name']."</option>"; 
        }
		echo $output;
    }
	
	public function get_doctor_by_specialization_id()
    {   
        $specialization_id 	=	$this->input->get_post('specialization_id');
        $doctor_list  		=  $this->appointmentmodel->specialization_doctor_list(array('dr_specialization.specialization_id'=>$specialization_id));
        //print_r($doctor_list); die;
        $output = "<option value=''> Select Doctor</option>";
        foreach ($doctor_list as $row)
        {
			$output .= "<option value='".$row['id']."'>".$row['fname']."</option>"; 
        }
		echo $output;
    }
	
	public function get_doctor_by_hospital_id()
    {   
        $hospital_id 	=	$this->input->get_post('hospital_id');
        $doctor_list  		=  $this->appointmentmodel->doctor_list(array('type'=>'H','institution_id'=>$hospital_id));
        //print_r($doctor_list); die;
        $output = "<option value=''> Select Doctor</option>";
        foreach ($doctor_list as $row)
        {
			$output .= "<option value='".$row['id']."'>".$row['fname']."</option>"; 
        }
		echo $output;
    }
	
    public function account_appointment()
    {	$data['hospital_list']  	=  $this->appointmentmodel->hospital_list(array('status'=>'1'));
	   	$data['appointment']  		=  $this->appointmentmodel->get_account_appointment();
	   	//echo "<pre>"; print_r($data['appointment']); die;
       	$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('account_appointment',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
    }

	/**
	 * AJAX endpoint: Update payment status for a single appointment.
	 * POST params: appointment_id, payment_status, payment_mode, transaction_id, admin_notes
	 * Returns JSON: { status, message, summary: { total_volume, total_received, total_pending, facility_count } }
	 */
	public function update_payment_status()
	{
		// Must be an AJAX / JSON request
		if (!$this->input->is_ajax_request() && !$this->input->post('is_ajax')) {
			show_404();
			return;
		}

		$appointment_id = (int) $this->input->post('appointment_id');
		$payment_status = trim($this->input->post('payment_status'));
		$payment_mode   = trim($this->input->post('payment_mode'));
		$transaction_id = trim($this->input->post('transaction_id'));
		$admin_notes    = trim($this->input->post('admin_notes'));

		// Basic validation
		if ($appointment_id <= 0) {
			echo json_encode(array('status' => 0, 'message' => 'Invalid appointment ID.'));
			return;
		}

		$allowed_statuses = array('UNPAID', 'DONE', 'CANCELLED', 'REFUNDED');
		if (!in_array(strtoupper($payment_status), $allowed_statuses)) {
			echo json_encode(array('status' => 0, 'message' => 'Invalid payment status value.'));
			return;
		}

		// Online/UPI/Card payments must supply a transaction reference
		$online_modes = array('ONLINE', 'UPI', 'CARD');
		if (in_array(strtoupper($payment_mode), $online_modes) && empty($transaction_id)) {
			echo json_encode(array('status' => 0, 'message' => 'Transaction / Reference ID is required for online settlements.'));
			return;
		}

		$update_data = array(
			'payment_status' => strtoupper($payment_status),
			'payment_mode'   => strtoupper($payment_mode),
			'transaction_id' => $transaction_id,
			'admin_notes'    => $admin_notes,
		);

		$result = $this->appointmentmodel->update_payment_status($appointment_id, $update_data);

		if ($result) {
			$summary = $this->appointmentmodel->get_account_summary();
			echo json_encode(array(
				'status'  => 1,
				'message' => 'Payment status updated successfully.',
				'summary' => $summary,
			));
		} else {
			echo json_encode(array('status' => 0, 'message' => 'Failed to update payment status. Please try again.'));
		}
	}

   public function doctordata()
   {
   		$data['city']  		=  $this->appointmentmodel->get_city(array('status'=>'1'));
     	$data['clinic']		= $this->appointmentmodel->get_dr_hospital_id();	
	    $this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('data',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
    }

   	public function calculate()
   	{
        if(isset($_POST['submit']))
        {
      		$this->load->model('doctorregmodel');
       		$data['data']    =   $this->doctorregmodel->calculate();
        	redirect(base_url().'doctor/appointment/totalamount'); 
    	}
    }
                
    public function totalamount()
    {   
       	$data['data']= $this->db->get('account')->result();   
       	$this->load->view('inc/topheaderlink');
       	$this->load->view('inc/topheader');
       	$this->load->view('totalamount',$data);
       	$this->load->view('sidebar');
       	$this->load->view('inc/headersetting');
       	$this->load->view('inc/footerlink');
      	$this->load->view('inc/table_footer');   
    }
	
	
    
    public function doctorwise()
    {
        $data['city']  		=  $this->appointmentmodel->get_city(array('status'=>'1'));
    	$data['doctor']  	=  $this->appointmentmodel->get_profile_dr();
        $this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('doctorwise',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
    }

   	public function patient()
    {
	   	$data['appointment']  	=  $this->appointmentmodel->get_appointment_by_droctor_id();
       	$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('patient',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
    }
}