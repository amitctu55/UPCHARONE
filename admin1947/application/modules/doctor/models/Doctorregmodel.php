<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Doctorregmodel extends CI_Model
{
	public function traineereginsert($drimage,$idproof='',$regproof='')
	{
		$date		=date('Y-m-d h:i:s');
		$city		=$this->input->post('city');
		$fname		=$this->input->post('t_fname');
		$lname		=$this->input->post('t_lname');
		$gender		=$this->input->post('gender');
		$regno		=$this->input->post('regno');
		$council	=$this->input->post('council');
		$year		=$this->input->post('year');
		$exp		=$this->input->post('exprience');
		$achievement=$this->input->post('achievement');
		$about		=$this->input->post('about');
		$package	=$this->input->post('package');
		$email		=$this->input->post('email');
		$mobile		=$this->input->post('mobile');
		$password	=md5($this->input->post('password'));
		$status		=$this->input->post('status');

		$udata=array(
					'FNAME'		=>$fname,
					'LNAME'		=>$lname,
					'PASSWORD'	=>$password,
					'STATUS'	=>'1',
					'APPROVED'	=>'1',
					'REG_DATE'	=>date('Y-m-d'),
					'GENDER'	=>$gender
					); 
			if($email)
			$udata['EMAIL']=$email;
			if($mobile)
			$udata['MOBILE']=$mobile;
			if($this->db->insert('doctorlogin',$udata))
			{
				$thisid = $this->db->insert_id();
				$data	=array('user_id'	=>$thisid,
								'fname'		=>$fname,
								'lname'		=>$lname,
								'gender'	=>$gender,
								'city'		=>$city,
								'regd_no'	=>$regno,
								'regd_council'=>$council,
								'regd_year'	=>$year,
								'exp'		=>$exp,
								'achievement'=>$achievement,
								'id_proof'	=>$idproof,
								'med_reg_proof'=>$regproof,
								'drimage'	=>$drimage,
								'mobile'	=>$mobile,	
								'email'		=>$email,
								'about'		=>$about,
								'subscription'=>$package,
								'approved'	=>'1',
								'verified'	=>'1',
								'status'	=>$status,
								'creat_date'=>$date,
								'created_by'=>getUserId(),
								'source'=>'A');
				$this->db->insert('profile_dr',$data);
				$drid= $this->db->insert_id();
				$qualdata = array();
				$qualification = $this->input->post('qualification');
				if (!empty($qualification) && is_array($qualification)) {
					foreach($qualification as $q)
					{
						if (!empty($q)) {
							$qualdata[] = array('user_id'=>$drid, 'qualification_id'=>$q);
						}
					}
				}
				if (!empty($qualdata)) {
					$this->db->insert_batch('dr_qualifications', $qualdata);
				}

				$spldata = array();
				$specialisation = $this->input->post('specialisation');
				if (!empty($specialisation) && is_array($specialisation)) {
					foreach($specialisation as $s)
					{
						if (!empty($s)) {
							$spldata[] = array('user_id'=>$drid, 'specialization_id'=>$s);
						}
					}
				}
				if (!empty($spldata)) {
					$this->db->insert_batch('dr_specialization', $spldata);
				}
			}
			$practice = $this->input->post('clinic');
			$fees = $this->input->post('fee');
			$practicetype = $this->input->post('objective');
			$mon = $this->input->post('mon');
			$tue = $this->input->post('tue');
			$wed = $this->input->post('wed');
			$thu = $this->input->post('thu');
			$fri = $this->input->post('fri');
			$sat = $this->input->post('sat');
			$sun = $this->input->post('sun');
			
			$from = $this->input->post('fromtime');
			$to = $this->input->post('totime');
			$hiddenday = $this->input->post('hiddenday');
			foreach($practice as $key=>$p){
				if($p=='')
					continue;
				$type=$practicetype[$key];
				$fee=$fees[$key];
				$practicedata=array('user_id'=>$drid,'type'=>$type,'institution_id'=>$p,'fee'=>$fee);
				$this->db->insert('dr_practice',$practicedata);
				$pid= $this->db->insert_id();
				
				$timings=$mon[$key];
				//foreach($timings as $key2=>$value){
				for($key2=0;$key2<$hiddenday[$key];$key2++){
					$mon[$key][$key2]=($mon[$key][$key2])? 1 : 0;
					$tue[$key][$key2]=($tue[$key][$key2])? 1 : 0;
					$wed[$key][$key2]=($wed[$key][$key2])? 1 : 0;
					$thu[$key][$key2]=($thu[$key][$key2])? 1 : 0;
					$fri[$key][$key2]=($fri[$key][$key2])? 1 : 0;
					$sat[$key][$key2]=($sat[$key][$key2])? 1 : 0;
					$sun[$key][$key2]=($sun[$key][$key2])? 1 : 0;
					
					$timingdata=array('practice_id'=>$pid,'user_id'=>$drid,'M'=>$mon[$key][$key2],'T'=>$tue[$key][$key2],	'W'=>$wed[$key][$key2],'TH'=>$thu[$key][$key2],	'F'=>$fri[$key][$key2],	'SA'=>$sat[$key][$key2],	'S'=>$sun[$key][$key2],	'status'=>'1');
					$this->db->insert('timing',$timingdata);
					$sessions=$from[$key][$key2];
					$tid= $this->db->insert_id();
					foreach($sessions as $key3=>$value){
						if($from[$key][$key2][$key3]=='' || $from[$key][$key2][$key3]=='')
							continue;
						$sessiondata = array('timing_id'=>$tid,'from_timing'=>$from[$key][$key2][$key3],'to_timing'=>$to[$key][$key2][$key3],'status'=>'1');
						$this->db->insert('timing_session',$sessiondata);
						
					}
				
				}
			}
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function doctor_duplicacy_check()
	{
		$email=$this->input->post('email');
		$mobile=$this->input->post('mobile');
		$mobile_count = $this->db->where('mobile',$mobile)->count_all_results('profile_dr');
		$email_count = $this->db->where('email',$email)->count_all_results('profile_dr');
		//return 'OK';
		if($mobile_count ==0 && $email_count==0)
			return 'OK';
		else if($mobile_count >0 && $email_count>0)
			return 'BOTH';
		else if($mobile_count ==0)
			return 'MOBILE';
		else if($email_count==0)
			return 'EMAIL';
	}
	public  function check_hospital($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{
			$result =  $this->db->get_where('hospitallogin',$page)->result_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}

		}
	}
	public  function check_doctor($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{
			$result =  $this->db->get_where('doctorlogin',$page)->result_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}

		}
	}
	public function clinic_duplicacy_check($typename)
	{
		$email=$this->input->post('email');
		$mobile=$this->input->post('mobile');
		$mobile_count = $this->db->where('mobile',$mobile)->count_all_results($typename);
		$email_count = $this->db->where('email',$email)->count_all_results($typename);
		//echo "<pre>"; print_r($email_count); die;
		if($mobile_count ==0 && $email_count==0)
			return 'OK';
		else if($mobile_count >0 && $email_count>0)
			return 'BOTH';
		else if($mobile_count >0)
			return 'MOBILE';
		else if($email_count >0)
			return 'EMAIL';
	}
	
	public function clinicinsert($drimage = '', $idproof = '', $regproof = '')
	{
		$date       = date('Y-m-d H:i:s');
		$objective  = $this->input->post('objective', TRUE) ?: 'H';
		$typename   = ($objective == 'C') ? 'clinic' : 'hospital';

		// Self-healing: ensure state and pincode columns exist
		if (!$this->db->field_exists('state', $typename)) {
			@$this->db->query("ALTER TABLE `{$typename}` ADD COLUMN `state` VARCHAR(100) NULL AFTER `city`");
		}
		if (!$this->db->field_exists('pincode', $typename)) {
			@$this->db->query("ALTER TABLE `{$typename}` ADD COLUMN `pincode` VARCHAR(10) NULL AFTER `address`");
		}

		$state      = trim($this->input->post('state', TRUE) ?: '');
		$city       = (int)$this->input->post('city');
		$location   = trim($this->input->post('location', TRUE) ?: '');
		$address    = trim($this->input->post('address', TRUE) ?: '');
		$pincode    = trim($this->input->post('pincode', TRUE) ?: '');
		$name       = trim($this->input->post('name', TRUE) ?: '');
		$tags       = trim($this->input->post('tags', TRUE) ?: '');
		$about      = trim($this->input->post('about', TRUE) ?: '');
		$package    = trim($this->input->post('package', TRUE) ?: '');
		$services   = $this->input->post('services');
		$email      = trim($this->input->post('email', TRUE) ?: '');
		$mobile     = trim($this->input->post('mobile', TRUE) ?: '');
		$password_raw = $this->input->post('password');
		$password   = $password_raw ? md5($password_raw) : md5('Upchar@' . rand(1000, 9999));
		$website    = trim($this->input->post('website', TRUE) ?: '');
		$status     = $this->input->post('status') !== null ? $this->input->post('status') : '1';

		$udata = array(
			'FNAME'      => $name,
			'STATUS'     => '1',
			'APPROVED'   => '1',
			'PASSWORD'   => $password,
			'REG_DATE'   => date('Y-m-d H:i:s'),
			'GENDER'     => 'M'
		); 
		if ($email)  $udata['EMAIL']  = $email;
		if ($mobile) $udata['MOBILE'] = $mobile;

		if ($this->db->insert('hospitallogin', $udata))
		{   
			$thisid = $this->db->insert_id();
			
			$primary_service = (is_array($services) && !empty($services)) ? (int)$services[0] : (int)$services;

			$data = array(
				'name'          => $name,
				'city'          => $city,
				'state'         => $state,
				'location'      => $location,
				'address'       => $address,
				'pincode'       => $pincode,
				'tag'           => $tags,
				'website'       => $website,
				'id_proof'      => $idproof ?: '',
				'med_reg_proof' => $regproof ?: '',
				'drimage'       => $drimage ?: 'dummyhosp.jpg',
				'mobile'        => $mobile,	
				'email'         => $email,
				'about'         => $about,
				'subscription'  => (int)$package,
				'services'      => $primary_service,
				'approved'      => '1',
				'verified'      => '1',
				'status'        => $status,
				'uid'           => $thisid,
				'creat_date'    => $date,
				'created_by'    => (int)getUserId()
			);
			
			$this->db->insert($typename, $data);
			$institution_id = $this->db->insert_id();

			// Store all chosen services in instition_services
			if (is_array($services) && !empty($services))
			{
				$qualdata = array();
				foreach ($services as $q)
				{
					if ((int)$q > 0) {
						$qualdata[] = array(
							'institution_type' => $objective,
							'institution_id'   => $institution_id,
							'services_id'      => (int)$q,
							'status'           => '1'
						);
					}
				}
				if (!empty($qualdata)) {
					$this->db->insert_batch('instition_services', $qualdata);
				}
			}

			// Safe SMS and Email notifications
			if ($mobile) {
				$msg = "Welcome to Upchar, Thanks for joining Upchar Team. WWW.UPCHAR.INFO";
				@sendsms($msg, $mobile);
			}

			if ($email) {
				try {
					$this->load->library('azad_lib');
					$body = "Welcome to Upchar<br>Thanks for joining Upchar Team<br>Email: info@upchar.info";
					@$this->azad_lib->sendMail_admin($email, 'Welcome Upchar Hospital', $body);
				} catch (Throwable $e) {}
			}

			return $institution_id;
		}
		
		return false;	
	}
	
	public function updatedoctor($id)
	{
		$date			=date('Y-m-d h:i:s');
		$city			=$this->input->post('city');
		$fname			=$this->input->post('t_fname');
		$lname			=$this->input->post('t_lname');
		$gender			=$this->input->post('gender');
		$regno			=$this->input->post('regno');
		$council		=$this->input->post('council');
		$year			=$this->input->post('year');
		$exp			=$this->input->post('exprience');
		$achievement	=$this->input->post('achievement');
		$about			=$this->input->post('about');
		$package		=$this->input->post('package');
		
		$email			=$this->input->post('email');
		$mobile			=$this->input->post('mobile');
		$status			=$this->input->post('status');
	
		$data	=array(
						'fname'			=>$fname,
						'lname'			=>$lname,
						'gender'		=>$gender,
						'city'			=>$city,
						'regd_no'		=>$regno,
						'regd_council'	=>$council,
						'regd_year'		=>$year,
						'exp'			=>$exp,
						'achievement'	=>$achievement,
						'mobile'		=>$mobile,
						'email'			=>$email,
						'about'			=>$about,
						'subscription'	=>$package,
						'status'		=>$status,
						'creat_date'	=>$date,
						'created_by'	=>getUserId(),
						'source'		=>'A'
					);
		$this->db->where('id', $id);
		$this->db->update('profile_dr', $data);

		// Sync with doctorlogin table
		$row = $this->db->get_where('profile_dr', array('id' => $id))->row();
		if ($row && !empty($row->user_id)) {
			$login_data = array(
				'FNAME'  => $fname,
				'LNAME'  => $lname,
				'EMAIL'  => $email,
				'MOBILE' => $mobile,
				'GENDER' => $gender
			);
			$this->db->where('USERID', $row->user_id)->update('doctorlogin', $login_data);
		}

		// Update Qualifications if provided
		$qualification = $this->input->post('qualification');
		if (is_array($qualification)) {
			$this->db->where('user_id', $id)->delete('dr_qualifications');
			$qualdata = array();
			foreach ($qualification as $q) {
				if (!empty($q)) {
					$qualdata[] = array('user_id' => $id, 'qualification_id' => $q);
				}
			}
			if (!empty($qualdata)) {
				$this->db->insert_batch('dr_qualifications', $qualdata);
			}
		}

		// Update Specializations if provided
		$specialisation = $this->input->post('specialisation');
		if (is_array($specialisation)) {
			$this->db->where('user_id', $id)->delete('dr_specialization');
			$spldata = array();
			foreach ($specialisation as $s) {
				if (!empty($s)) {
					$spldata[] = array('user_id' => $id, 'specialization_id' => $s);
				}
			}
			if (!empty($spldata)) {
				$this->db->insert_batch('dr_specialization', $spldata);
			}
		}

		return true;
	}
		
	public function get_doctor_fee_time($limit='10', $offset='0', $param=array())
	{	
		$id          = @$param['id'];
		$practice_id = (int)$this->uri->segment(4);
		$keyword     = $this->db->escape_like_str(trim($this->input->get('keyword', TRUE) ?: ''));
	
		if ($id != '') {
			$this->db->where("timing.id", (int)$id);
		}
		if ($practice_id > 0) {
			$this->db->group_start();
			$this->db->where("timing.practice_id", $practice_id);
			$this->db->or_where("dr_practice.id", $practice_id);
			$this->db->or_where("dr_practice.user_id", $practice_id);
			$this->db->group_end();
		}
		if ($keyword != '') {
			$this->db->where("(profile_dr.fname LIKE '%{$keyword}%' OR profile_dr.lname LIKE '%{$keyword}%' OR hospital.name LIKE '%{$keyword}%' OR clinic.name LIKE '%{$keyword}%')");
		}
		$this->db->order_by('timing.id', 'desc');
		$this->db->limit($limit, $offset);
		$this->db->select('SQL_CALC_FOUND_ROWS timing.id as timing_id, timing.practice_id, timing.user_id as timing_user_id, timing.M, timing.T, timing.W, timing.TH, timing.F, timing.SA, timing.S, timing.status as timing_status, timing_session.id as session_id, timing_session.from_timing, timing_session.to_timing, timing_session.max_patient, COALESCE(timing_session.consultation_fee, dr_practice.fee, 0) as consultation_fee, dr_practice.id as practice_id_raw, dr_practice.user_id as doctor_user_id, dr_practice.type as facility_type, profile_dr.id as doctor_id, profile_dr.fname, profile_dr.lname, profile_dr.email, profile_dr.mobile, ms.name as speciality, COALESCE(hospital.name, clinic.name, "Healthcare Facility") as facility_name, COALESCE(hospital.city, clinic.city, profile_dr.city) as city', FALSE);
		$this->db->join('dr_practice', 'dr_practice.id = timing.practice_id', 'left');
		$this->db->join('profile_dr', '(profile_dr.id = dr_practice.user_id OR (profile_dr.user_id = dr_practice.user_id AND dr_practice.user_id != 0))', 'left');
		$this->db->join('master_specialization ms', 'ms.id = profile_dr.specialization', 'left');
		$this->db->join('hospital', 'hospital.id = dr_practice.institution_id AND (dr_practice.type = "H" OR dr_practice.type = "" OR dr_practice.type IS NULL)', 'left');
		$this->db->join('clinic', 'clinic.id = dr_practice.institution_id AND dr_practice.type = "C"', 'left');
		$this->db->join('timing_session', 'timing_session.timing_id = timing.id', 'left');
		$result = $this->db->get('timing')->result_array();
		
		// Fallback: If no timing row exists yet for this practice, retrieve directly from dr_practice
		if (empty($result) && $practice_id > 0) {
			$dr_p = $this->db->select('dr_practice.id as practice_id, dr_practice.id as practice_id_raw, dr_practice.user_id as doctor_user_id, dr_practice.type as facility_type, dr_practice.fee as consultation_fee, dr_practice.status as timing_status, profile_dr.id as doctor_id, profile_dr.fname, profile_dr.lname, profile_dr.email, profile_dr.mobile, ms.name as speciality, COALESCE(hospital.name, clinic.name, "Healthcare Facility") as facility_name, COALESCE(hospital.city, clinic.city, profile_dr.city) as city')
				->from('dr_practice')
				->join('profile_dr', '(profile_dr.id = dr_practice.user_id OR (profile_dr.user_id = dr_practice.user_id AND dr_practice.user_id != 0))', 'left')
				->join('master_specialization ms', 'ms.id = profile_dr.specialization', 'left')
				->join('hospital', 'hospital.id = dr_practice.institution_id AND (dr_practice.type = "H" OR dr_practice.type = "" OR dr_practice.type IS NULL)', 'left')
				->join('clinic', 'clinic.id = dr_practice.institution_id AND dr_practice.type = "C"', 'left')
				->group_start()
				->where('dr_practice.id', $practice_id)
				->or_where('dr_practice.user_id', $practice_id)
				->group_end()
				->get()
				->result_array();
			if (!empty($dr_p)) {
				foreach ($dr_p as &$p_row) {
					$p_row['timing_id']   = 0;
					$p_row['session_id']  = 0;
					$p_row['from_timing'] = '';
					$p_row['to_timing']   = '';
					$p_row['max_patient'] = 20;
					$p_row['M'] = 0; $p_row['T'] = 0; $p_row['W'] = 0; $p_row['TH'] = 0; $p_row['F'] = 0; $p_row['SA'] = 0; $p_row['S'] = 0;
				}
				$result = $dr_p;
			}
		}

		return ($limit == '1') ? (@$result[0] ?: null) : $result;	
	}
	
	public function get_doctor($limit='10', $offset='0', $param=array())
	{	
		$id              = @$param['id'];
		$institution_id  = (int)$this->uri->segment(4);
		$keyword         = $this->db->escape_like_str(trim($this->input->get('keyword', TRUE) ?: ''));
		$type            = $this->input->get('type', TRUE);
	
		if ($id != '') {
			$this->db->where("dr_practice.id", (int)$id);
		}
		if ($institution_id > 0) {
			$this->db->where("dr_practice.institution_id", $institution_id);
		}
		if ($keyword != '') {
			$this->db->where("(profile_dr.fname LIKE '%{$keyword}%' OR profile_dr.lname LIKE '%{$keyword}%' OR profile_dr.mobile LIKE '%{$keyword}%' OR h.name LIKE '%{$keyword}%' OR c.name LIKE '%{$keyword}%')");
		}
		if (!empty($type)) {
			$this->db->where("dr_practice.type", $type);
		}

		$this->db->order_by('dr_practice.id', 'DESC');
		$this->db->limit($limit, $offset);
		$this->db->select('SQL_CALC_FOUND_ROWS dr_practice.*, profile_dr.fname, profile_dr.lname, profile_dr.email, profile_dr.mobile, profile_dr.drimage, ms.name as speciality, COALESCE(h.name, c.name, "Healthcare Facility") as facility_name, COALESCE(h.city, c.city, profile_dr.city) as city', FALSE);
		$this->db->join('profile_dr', '(profile_dr.id = dr_practice.user_id OR (profile_dr.user_id = dr_practice.user_id AND dr_practice.user_id != 0))', 'left');
		$this->db->join('master_specialization ms', 'ms.id = profile_dr.specialization', 'left');
		$this->db->join('hospital h', 'h.id = dr_practice.institution_id AND (dr_practice.type = "H" OR dr_practice.type = "" OR dr_practice.type IS NULL)', 'left');
		$this->db->join('clinic c', 'c.id = dr_practice.institution_id AND dr_practice.type = "C"', 'left');
		
		$result = $this->db->get('dr_practice')->result_array();
		return ($limit == '1') ? (@$result[0] ?: null) : $result;
	}
	
	public function get_hospital($limit = 10, $offset = 0, $param = array())
	{	
		$id				= @$param['id'];
		$keyword 		= $this->db->escape_str($this->input->get('keyword',TRUE));
		$type 			= $this->db->escape_str($this->input->get('type',TRUE));
		$subscription 	= $this->db->escape_str($this->input->get('subscription',TRUE));
		$status_filter 	= $this->db->escape_str($this->input->get('status_filter',TRUE));
	
		if($id != '')
		{
			$this->db->where("hospital.id", $id);
		}
		if($keyword != '')
		{
			$this->db->where("(hospital.name LIKE '%".$keyword."%' OR hospital.email LIKE '%".$keyword."%' OR hospital.mobile LIKE '%".$keyword."%')");
		}
		if($type != '')
		{
			$this->db->where("hospitallogin.TYPE", $type);
		}
		if($subscription != '')
		{
			$this->db->where("hospital.subscription", $subscription);
		}
		if($status_filter == 'approved' || $status_filter == 'registered')
		{
			$this->db->where("hospital.approved", "1");
			$this->db->where("hospital.verified", "1");
		}
		elseif($status_filter == 'pending' || $status_filter == 'pending_verification')
		{
			$this->db->where("(hospital.approved = '0' OR hospital.verified = '0')");
		}
		elseif($status_filter == 'verified')
		{
			$this->db->where("hospital.verified", "1");
		}
		elseif($status_filter == 'unverified')
		{
			$this->db->where("hospital.verified", "0");
		}
		elseif($status_filter == 'pending_approval')
		{
			$this->db->where("hospital.approved", "0");
		}
		$this->db->where("hospital.status !=", "2");
		$this->db->order_by('hospital.id', 'desc');
		$this->db->limit($limit, $offset);
		$this->db->select('SQL_CALC_FOUND_ROWS hospital.*, hospitallogin.TYPE', FALSE);
		$this->db->join('hospitallogin', 'hospitallogin.USERID = hospital.uid', 'left');
		$result = $this->db->get('hospital')->result_array();
		
		$result = ($limit == 1) ? @$result[0] : $result;	
		return $result;
	}
	
	public function get_hospital_list($param = array())
	{	
		$id				= @$param['id'];
		$keyword 		= $this->db->escape_str($this->input->get('keyword',TRUE));
		$type 			= $this->db->escape_str($this->input->get('type',TRUE));
		$status_filter 	= $this->db->escape_str($this->input->get('status_filter',TRUE));
	
		if($id != '')
		{
			$this->db->where("hospital.id", $id);
		}
		
		if($keyword != '')
		{
			$this->db->where("(hospital.name LIKE '%".$keyword."%' OR hospital.email LIKE '%".$keyword."%' OR hospital.mobile LIKE '%".$keyword."%')");
		}
		if($type != '')
		{
			$this->db->where("hospitallogin.TYPE", $type);
		}
		if($status_filter == 'approved' || $status_filter == 'registered')
		{
			$this->db->where("hospital.approved", "1");
			$this->db->where("hospital.verified", "1");
		}
		elseif($status_filter == 'pending' || $status_filter == 'pending_verification')
		{
			$this->db->where("(hospital.approved = '0' OR hospital.verified = '0')");
		}
		elseif($status_filter == 'verified')
		{
			$this->db->where("hospital.verified", "1");
		}
		elseif($status_filter == 'unverified')
		{
			$this->db->where("hospital.verified", "0");
		}
		elseif($status_filter == 'pending_approval')
		{
			$this->db->where("hospital.approved", "0");
		}
		$this->db->where("hospital.status !=", "2");
		$this->db->order_by('hospital.id', 'desc');
		$this->db->select('SQL_CALC_FOUND_ROWS hospital.*, hospitallogin.TYPE', FALSE);
		$this->db->join('hospitallogin', 'hospitallogin.USERID = hospital.uid', 'left');
		$result = $this->db->get('hospital')->result_array();
		return $result;
	}

	/**
	 * Get Single Hospital by ID with Master City & Locality Joins
	 */
	public function get_hospital_by_id($id)
	{
		$this->db->select('hospital.*, mc.name as city_name, ml.name as locality_name', FALSE);
		$this->db->from('hospital');
		$this->db->join('master_city mc', 'mc.id = hospital.city', 'left');
		$this->db->join('master_locality ml', 'ml.id = hospital.location', 'left');
		$this->db->where('hospital.id', (int)$id);
		$row = $this->db->get()->row();
		if ($row) {
			if (empty($row->locality_name) && !empty($row->location) && !is_numeric($row->location)) {
				$row->locality_name = $row->location;
			}
			if (empty($row->city_name) && !empty($row->city) && !is_numeric($row->city)) {
				$row->city_name = $row->city;
			}
		}
		return $row;
	}

	/**
	 * Get Affiliated Doctors for a Given Hospital
	 * Joins dr_practice with profile_dr and master_specialization
	 */
	public function get_hospital_doctors($hospital_id, $hospital_uid = null)
	{
		if (!$this->db->table_exists('dr_practice') || !$this->db->table_exists('profile_dr')) {
			return array();
		}

		$this->db->select('dp.id as practice_id, dp.fee, dp.status as practice_status, dp.is_video_consult_enabled, pd.id as doctor_id, pd.fname, pd.lname, pd.mobile, pd.email, pd.drimage, ms.name as speciality');
		$this->db->from('dr_practice dp');
		$this->db->join('profile_dr pd', '(pd.id = dp.user_id OR pd.user_id = dp.user_id)', 'left');
		$this->db->join('master_specialization ms', 'ms.id = pd.specialization', 'left');
		
		$h_id = (int)$hospital_id;
		$u_id = (int)$hospital_uid;
		if ($u_id > 0) {
			$this->db->where('(dp.institution_id = ' . $h_id . ' OR dp.institution_id = ' . $u_id . ')');
		} else {
			$this->db->where('dp.institution_id', $h_id);
		}

		$this->db->order_by('dp.id', 'DESC');
		$query = $this->db->get();
		return ($query && is_object($query)) ? $query->result_array() : array();
	}

	/**
	 * Get Active Facilities/Services Mapped to a Given Hospital
	 * Queries instition_services joined with master_services, with fallback to hospital.services
	 */
	public function get_hospital_services($hospital_id, $services_field = null)
	{
		$services = array();

		if ($this->db->table_exists('instition_services')) {
			$this->db->select('s.*, ms.name as service_name');
			$this->db->from('instition_services s');
			$this->db->join('master_services ms', 'ms.id = s.services_id', 'left');
			$this->db->where('s.institution_id', (int)$hospital_id);
			$this->db->where('s.institution_type', 'H');
			$this->db->where('s.status', '1');
			$query = $this->db->get();
			if ($query && $query->num_rows() > 0) {
				$services = $query->result_array();
			}
		}

		// Fallback: check hospital.services column if no rows in instition_services
		if (empty($services) && !empty($services_field)) {
			$srv_ids = array_filter(array_map('trim', explode(',', $services_field)));
			if (!empty($srv_ids) && $this->db->table_exists('master_services')) {
				$this->db->select('id as services_id, name as service_name');
				$this->db->from('master_services');
				$this->db->where_in('id', $srv_ids);
				$this->db->where('status', '1');
				$query = $this->db->get();
				if ($query && $query->num_rows() > 0) {
					$services = $query->result_array();
				}
			}
		}

		return $services;
	}
	
	public function get_clinic($limit = 10, $offset = 0, $param = array())
	{	
		$id				= @$param['id'];
		$keyword 		= $this->db->escape_str($this->input->get('keyword',TRUE));
		$status_filter 	= $this->db->escape_str($this->input->get('status_filter',TRUE));
	
		if($id != '')
		{
			$this->db->where("clinic.id", $id);
		}
		
		if($keyword != '')
		{
			$this->db->where("(clinic.name LIKE '%".$keyword."%' OR clinic.email LIKE '%".$keyword."%' OR clinic.mobile LIKE '%".$keyword."%')");
		}
		if($status_filter == 'approved' || $status_filter == 'registered')
		{
			$this->db->where("clinic.approved", "1");
			$this->db->where("clinic.verified", "1");
		}
		elseif($status_filter == 'pending' || $status_filter == 'pending_verification')
		{
			$this->db->where("(clinic.approved = '0' OR clinic.verified = '0')");
		}
		elseif($status_filter == 'verified')
		{
			$this->db->where("clinic.verified", "1");
		}
		elseif($status_filter == 'unverified')
		{
			$this->db->where("clinic.verified", "0");
		}
		elseif($status_filter == 'pending_approval')
		{
			$this->db->where("clinic.approved", "0");
		}
		$this->db->where("clinic.status !=", "2");
		$this->db->order_by('clinic.id', 'desc');
		$this->db->limit($limit, $offset);
		$this->db->select('SQL_CALC_FOUND_ROWS clinic.*', FALSE);
		$result = $this->db->get('clinic')->result_array();
		
		$result = ($limit == 1) ? @$result[0] : $result;	
		return $result;
	}

    public function updatehospital($drimage='', $idproof='', $regproof='', $id='', $user_id='')
    {	
		$date = date('Y-m-d H:i:s');
		$type = $this->input->post('type');
		$existing = $this->db->get_where('hospital', array('id' => $id))->row();

		$name   = ($this->input->post('name') !== null && trim($this->input->post('name')) !== '') ? trim($this->input->post('name')) : ($existing ? $existing->name : '');
		$mobile = ($this->input->post('mobile') !== null && trim($this->input->post('mobile')) !== '') ? trim($this->input->post('mobile')) : ($existing ? $existing->mobile : '');
		$email  = ($this->input->post('email') !== null) ? trim($this->input->post('email')) : ($existing ? $existing->email : '');

		// Update hospitallogin credentials and classification
		if (!empty($user_id)) {
			$login_update = array(
				'TYPE'   => $type,
				'FNAME'  => $name,
				'MOBILE' => $mobile,
				'EMAIL'  => $email,
			);
			if ($this->input->post('status') !== null) {
				$login_update['STATUS'] = ($this->input->post('status') == '1' || $this->input->post('status') == 'A') ? '1' : '0';
			}
			if ($this->input->post('approved') !== null) {
				$login_update['APPROVED'] = ($this->input->post('approved') == '1') ? '1' : '0';
			}
			$this->db->where('USERID', $user_id)->update('hospitallogin', $login_update);
		}

		$data = array(
			'name'                     => $name,
			'mobile'                   => $mobile,
			'email'                    => $email,
			'website'                  => $this->input->post('website'),
			'city'                     => $this->input->post('city'),
			'location'                 => $this->input->post('location'),
			'address'                  => $this->input->post('address'),
			'about'                    => $this->input->post('about'),
			'cancellation_hours'       => ($this->input->post('cancellation_hours') !== null) ? max(0, intval($this->input->post('cancellation_hours'))) : 3,
			'cancellation_policy_text' => $this->input->post('cancellation_policy_text') ? trim($this->input->post('cancellation_policy_text')) : 'Cancellations allowed up to 3 hours prior to consultation slot.',
			'drimage'                  => !empty($drimage) ? $drimage : ($existing && !empty($existing->drimage) ? $existing->drimage : 'dummyhosp.jpg'),
			'id_proof'                 => !empty($idproof) ? $idproof : ($existing ? $existing->id_proof : ''),
			'med_reg_proof'            => !empty($regproof) ? $regproof : ($existing ? $existing->med_reg_proof : ''),
			'modified_date'            => $date,
			'modified_by'              => function_exists('getUserId') ? getUserId() : 1,
		);

		if ($this->input->post('pincode') !== null) {
			$data['pincode'] = $this->input->post('pincode');
		}
		if ($this->input->post('state') !== null) {
			$data['state'] = $this->input->post('state');
		}
		if ($this->input->post('tag') !== null) {
			$data['tag'] = $this->input->post('tag');
		}
		if ($this->input->post('services') !== null) {
			$data['services'] = $this->input->post('services');
		}
		if ($this->input->post('status') !== null) {
			$data['status'] = $this->input->post('status');
		}
		if ($this->input->post('approved') !== null) {
			$data['approved'] = $this->input->post('approved');
		}
		if ($this->input->post('package') !== null) {
			$data['subscription'] = $this->input->post('package');
		}

		$this->db->where('id', $id);
		return $this->db->update('hospital', $data);
    }

    public function updategallery($id,$picture)
	{
		$date=date('Y-m-d h:i:s');
		// $image=$this->input->post('image');
		$shot_description=$this->input->post('shot_description');
		$long_description=$this->input->post('long_description');
		$status=$this->input->post('status');
		//echo "<pre>";print_r($shot_description);die;
		$qq=$this->db->query("update hospitalgallery SET date='$date',shot_description='$shot_description',long_description='$long_description',image= '$picture',status='$status' where id='".$id."'");
		return $qq;
	}

	public function updatedocgallery($id,$picture)
	{
		$date=date('Y-m-d h:i:s');
		$shot_description=$this->input->post('shot_description');
		$long_description=$this->input->post('long_description');
		$status=$this->input->post('status');
		$qq=$this->db->query("update doctorgallery SET date='$date',shot_description='$shot_description',long_description='$long_description',image= '$picture',status='$status' where id='".$id."'");
		//echo "<pre>";print_r($qq);die;
		return $qq;
	}


	public function updateclinic($id)
	{
		$date=date('Y-m-d h:i:s');
		$city=$this->input->post('city');
		$name=$this->input->post('name');
		$location=$this->input->post('location');
		$address=$this->input->post('address');
		$tags=$this->input->post('tags');
		$services=$this->input->post('services');
		$about=$this->input->post('about');
		$email=$this->input->post('email');
		$mobile=$this->input->post('mobile');
		$website=$this->input->post('website');
		$status=$this->input->post('status');
		$qq=$this->db->query("update clinic SET name='$name',creat_date='$date',website='$website',location='$location',address='$address',tag='$tags', about='$about',email='$email', mobile='$mobile',services='$services',city='$city',status='$status' where id='".$id."'");
		return $qq;
    }

    public function gallery($image)
	{
		$date=date('Y-m-d h:i:s');
		$long=$this->input->post('long');
		$shot=$this->input->post('shot');
		//$id=base64_decode($this->input->post('id'));

	   //$image=$this->input->post('uploadimage')
		$data=array('shot_description'=>$shot,'long_description'=>$long,'image'=>$image,'date'=>$date,);
		
		$qq=$this->db->insert('gallery',$data);
	   return $qq;
	   $drid= $this->db->insert_id();
	}

	public function add_appointment()
	{
		
		 //$drid= $this->db->insert_id();
		//$date=date('Y-m-d h:i:s');
		$appointment_name	=$this->input->post('appointment_name');
		$appointment_mobile =$this->input->post('appointment_mobile');
		$institute_id 		=$this->input->post('institute_id');
		$appointment_email  =$this->input->post('appointment_email');
		$amount 			=$this->input->post('amount');
		$doctor_id  		=$this->input->post('doctor_id');
		//echo "<pre>";print_r($appointment_name);die;
		$data=array('appointment_name'=>$appointment_name,'appointment_mobile'=>$appointment_mobile,'institute_id'=>$institute_id,'appointment_email'=>$appointment_email,'amount'=>$amount,'doctor_id'=>$doctor_id);

		$query=$this->db->insert('appointment',$data);
		return $query;
	}
		
	public function biomedicalmachine($image)
	{
		
		 //$drid= $this->db->insert_id();
		$date=date('Y-m-d h:i:s');
		$short=$this->input->post('short');
		$long=$this->input->post('long');
		$price=$this->input->post('price');
		$mrpprice=$this->input->post('mrp_price');
		$discount=$this->input->post('discount');
		$company=$this->input->post('company_name');
		$distributor=$this->input->post('distributor_name');
		$distributor_mobile=$this->input->post('distributor_mobile');
		$distributor_email=$this->input->post('distributor_email');
		$equipment=$this->input->post('equipment');

		$data=array('short_desc'=>$short,'long_desc'=>$long,'price'=>$price,'image'=>$image,'date'=>$date,'company_name'=>$company,'distributor_name'=>$distributor,'mrp_price'=>$mrpprice,'discount_price'=>$discount,'distributor_email'=>$distributor_email,'distributor_mobile'=>$distributor_mobile,'equipment'=>$equipment);
		$query=$this->db->insert('biomedical',$data);
		return $query;
	}
		
	function deleterecord($id)
	{
		$this->db->query("delete from appointment where appointment_id='".$id."'");
	}
      
    function deletehospital($id)
    {
       $this->db->query("delete from appointment where appointment_id='".$id."'");
    }
	
    function deletehistory($id)
    {
       $this->db->query("delete from appointment where appointment_id='".$id."'");
    }
	
    function gallerydelete($id)
    {
       $this->db->query("delete from hospitalgallery where id='".$id."'");
    }

    function gallerydocdelete($id)
    {
        $this->db->query("delete from doctorgallery where id='".$id."'");
    }
 
    public function deletedoctor($id)
    {
        $row = $this->db->get_where('profile_dr', array('id' => $id))->row();
        if ($row) {
            if (!empty($row->user_id)) {
                $this->db->where('USERID', $row->user_id)->delete('doctorlogin');
            }
            $this->db->where('user_id', $id)->delete('dr_qualifications');
            $this->db->where('user_id', $id)->delete('dr_specialization');

            $practices = $this->db->select('id')->get_where('dr_practice', array('user_id' => $id))->result_array();
            if (!empty($practices)) {
                $practice_ids = array();
                foreach ($practices as $p) {
                    $practice_ids[] = $p['id'];
                }
                if (!empty($practice_ids)) {
                    $timings = $this->db->select('id')->where_in('practice_id', $practice_ids)->get('timing')->result_array();
                    if (!empty($timings)) {
                        $timing_ids = array();
                        foreach ($timings as $t) {
                            $timing_ids[] = $t['id'];
                        }
                        if (!empty($timing_ids)) {
                            $this->db->where_in('timing_id', $timing_ids)->delete('timing_session');
                        }
                    }
                    $this->db->where_in('practice_id', $practice_ids)->delete('timing');
                }
            }
            $this->db->where('user_id', $id)->delete('timing');
            $this->db->where('user_id', $id)->delete('dr_practice');
            $this->db->where('user_id', $id)->delete('doctorgallery');
            $this->db->where('id', $id)->delete('profile_dr');
        }
        return true;
    }

    public function doctordelete($id)
    {
        return $this->deletedoctor($id);
    }
     
     
    public function hospitaldelete($id)
    {
		$row = $this->db->get_where('hospital', array('id' => $id))->row();
		if ($row) {
			if (!empty($row->uid)) {
				$this->db->where('USERID', $row->uid)->delete('hospitallogin');
			}
			$this->db->where(array('institution_id' => $id, 'type' => 'H'))->delete('dr_practice');
			$this->db->where('uid', $id)->delete('hospitalgallery');
			$this->db->where('id', $id)->delete('hospital');
		}
		return true;
    }
	
	public function clinic_delete($id)
    {
		$row = $this->db->get_where('clinic', array('id' => $id))->row();
		if ($row) {
			if (!empty($row->uid)) {
				$this->db->where('USERID', $row->uid)->delete('hospitallogin');
			}
			$this->db->where(array('institution_id' => $id, 'type' => 'C'))->delete('dr_practice');
			$this->db->where('id', $id)->delete('clinic');
		}
		return true;
    }

	public function calculate()
	{
		$fee=$this->input->post('fee');
		$per=$this->input->post('per');
		//$rr=$fee*$per;
		$total=($fee * $per)/100;
		//$total=($rr*$per)/100;
		$data=array('fee'=>$fee,'percent'=>$per,'total'=>$total);
		$qq=$this->db->insert('account',$data);
	   return $qq;
	}
  
	private function _ensure_advertisement_schema()
	{
		static $schema_checked = false;
		if ($schema_checked) {
			return;
		}
		$schema_checked = true;

		try {
			if (!$this->db->table_exists('advertisement')) {
				$this->db->query("CREATE TABLE IF NOT EXISTS `advertisement` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `title` varchar(255) DEFAULT NULL,
				  `category` enum('medicine','medical_store','hospital','pathology','equipment','general') DEFAULT 'general',
				  `sponsor_badge` varchar(100) DEFAULT 'Sponsored Partner',
				  `short_description` varchar(300) DEFAULT NULL,
				  `long_description` varchar(500) DEFAULT NULL,
				  `image` varchar(250) DEFAULT NULL,
				  `page` varchar(250) DEFAULT NULL,
				  `link_url` varchar(255) DEFAULT NULL,
				  `placement` varchar(100) DEFAULT 'public_dashboard',
				  `clicks` int(11) DEFAULT '0',
				  `impressions` int(11) DEFAULT '0',
				  `price_paid` decimal(10,2) DEFAULT '0.00',
				  `contact_info` varchar(200) DEFAULT NULL,
				  `status` enum('0','1') DEFAULT '1',
				  `creat_date` datetime DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
			} else {
				if (!$this->db->field_exists('category', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `category` enum('medicine','medical_store','hospital','pathology','equipment','general') DEFAULT 'general' AFTER `title`");
				}
				if (!$this->db->field_exists('sponsor_badge', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `sponsor_badge` varchar(100) DEFAULT 'Sponsored Partner'");
				}
				if (!$this->db->field_exists('short_description', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `short_description` varchar(300) DEFAULT NULL");
				}
				if (!$this->db->field_exists('long_description', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `long_description` varchar(500) DEFAULT NULL");
				}
				if (!$this->db->field_exists('link_url', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `link_url` varchar(255) DEFAULT NULL");
				}
				if (!$this->db->field_exists('placement', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `placement` varchar(100) DEFAULT 'public_dashboard'");
				}
				if (!$this->db->field_exists('clicks', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `clicks` int(11) DEFAULT '0'");
				}
				if (!$this->db->field_exists('impressions', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `impressions` int(11) DEFAULT '0'");
				}
				if (!$this->db->field_exists('price_paid', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `price_paid` decimal(10,2) DEFAULT '0.00'");
				}
				if (!$this->db->field_exists('contact_info', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `contact_info` varchar(200) DEFAULT NULL");
				}
				if (!$this->db->field_exists('status', 'advertisement')) {
					$this->db->query("ALTER TABLE `advertisement` ADD COLUMN `status` enum('0','1') DEFAULT '1'");
				}
			}
		} catch (Throwable $e) {
			log_message('error', 'Error in _ensure_advertisement_schema: ' . $e->getMessage());
		}
	}

	public function get_advertisements($category = null)
	{
		$this->_ensure_advertisement_schema();
		try {
			if (!empty($category) && $this->db->field_exists('category', 'advertisement')) {
				$this->db->where('category', $category);
			}
			$this->db->order_by('id', 'DESC');
			$q = $this->db->get('advertisement');
			return ($q && is_object($q)) ? $q->result() : array();
		} catch (Throwable $e) {
			return array();
		}
	}

	public function get_advertisement_by_id($id)
	{
		$this->_ensure_advertisement_schema();
		try {
			$q = $this->db->get_where('advertisement', array('id' => $id));
			return ($q && is_object($q)) ? $q->row() : null;
		} catch (Throwable $e) {
			return null;
		}
	}

	public function advertisment($image = '')
	{
		$this->_ensure_advertisement_schema();
		$id           = $this->input->post('eid') ? base64_decode($this->input->post('eid')) : null;
		$title        = trim($this->input->post('title') ?: $this->input->post('short'));
		$category     = $this->input->post('category') ?: 'general';
		$sponsor_badge= trim($this->input->post('sponsor_badge') ?: 'Sponsored Partner');
		$short        = trim($this->input->post('short'));
		$long         = trim($this->input->post('long'));
		$page         = trim($this->input->post('page') ?: 'home');
		$link_url     = trim($this->input->post('link_url') ?: $page);
		$placement    = $this->input->post('placement') ?: 'public_dashboard';
		$active       = $this->input->post('activeradio') !== null ? $this->input->post('activeradio') : '1';
		$date         = date('Y-m-d H:i:s');

		$data = array(
			'title'             => $title,
			'category'          => $category,
			'sponsor_badge'     => $sponsor_badge,
			'short_description' => $short,
			'long_description'  => $long,
			'page'              => $page,
			'link_url'          => $link_url,
			'placement'         => $placement,
			'status'            => $active
		);

		if (!empty($image)) {
			$data['image'] = $image;
		}

		if ($id) {
			$this->db->where('id', $id)->update('advertisement', $data);
			return $id;
		} else {
			$data['creat_date'] = $date;
			$this->db->insert('advertisement', $data);
			return $this->db->insert_id();
		}
	}

	public function delete_advertisement($id)
	{
		return $this->db->where('id', $id)->delete('advertisement');
	}

	public function toggle_ad_status($id)
	{
		$ad = $this->get_advertisement_by_id($id);
		if ($ad) {
			$newStatus = ($ad->status == '1') ? '0' : '1';
			$this->db->where('id', $id)->update('advertisement', array('status' => $newStatus));
			return $newStatus;
		}
		return false;
	}

	public function resethospitalpassword($hospital_id, $new_password)
	{
		$hospital = $this->db->get_where('hospital', array('id' => (int)$hospital_id))->row();
		if (!$hospital) {
			return false;
		}

		$hashed = md5($new_password);
		$login_row = null;

		if (!empty($hospital->uid)) {
			$login_row = $this->db->get_where('hospitallogin', array('USERID' => $hospital->uid))->row();
		}
		if (!$login_row && !empty($hospital->email)) {
			$login_row = $this->db->get_where('hospitallogin', array('EMAIL' => $hospital->email))->row();
		}
		if (!$login_row && !empty($hospital->mobile)) {
			$login_row = $this->db->get_where('hospitallogin', array('MOBILE' => $hospital->mobile))->row();
		}

		if ($login_row) {
			$this->db->where('USERID', $login_row->USERID)->update('hospitallogin', array(
				'PASSWORD'    => $hashed,
				'STATUS'      => '1',
				'UPDATE_DATE' => date('Y-m-d')
			));
			if (empty($hospital->uid) || $hospital->uid != $login_row->USERID) {
				$this->db->where('id', $hospital->id)->update('hospital', array('uid' => $login_row->USERID));
			}
			return true;
		} else {
			$new_login = array(
				'EMAIL'       => $hospital->email ?: '',
				'MOBILE'      => $hospital->mobile ?: '',
				'PASSWORD'    => $hashed,
				'FNAME'       => $hospital->name ?: 'Hospital',
				'STATUS'      => '1',
				'APPROVED'    => '1',
				'TYPE'        => '1',
				'REG_DATE'    => date('Y-m-d H:i:s'),
				'UPDATE_DATE' => date('Y-m-d')
			);
			$this->db->insert('hospitallogin', $new_login);
			$new_uid = $this->db->insert_id();
			$this->db->where('id', $hospital->id)->update('hospital', array('uid' => $new_uid));
			return true;
		}
	}
}