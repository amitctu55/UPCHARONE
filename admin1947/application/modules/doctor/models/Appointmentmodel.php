<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Appointmentmodel extends CI_Model
{ 
	public function get_appointment($limit='10',$offset='0',$param=array())
	{		
		$appointment_id 	= $this->db->escape_str($this->input->get_post('appointment_id',TRUE));
		$hospital_email 	= $this->db->escape_str($this->input->get_post('hospital_email',TRUE));
		$hospital_phone 	= $this->db->escape_str($this->input->get_post('hospital_phone',TRUE));
		$hospital_name 		= $this->db->escape_str($this->input->get_post('hospital_name',TRUE));
		$paient_name 		= $this->db->escape_str($this->input->get_post('paient_name',TRUE));
		$paient_phone 		= $this->db->escape_str($this->input->get_post('paient_phone',TRUE));
		$appointment_email 	= $this->db->escape_str($this->input->get_post('appointment_email',TRUE));
		$payment_mode 		= $this->db->escape_str($this->input->get_post('payment_mode',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));	
		$time_from 			= $this->db->escape_str($this->input->get_post('time_from',TRUE));
		$time_to 			= $this->db->escape_str($this->input->get_post('time_to',TRUE));
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$city_name 			= $this->db->escape_str($this->input->get_post('city_name',TRUE));
				
	    if($appointment_id!='')
		{
			$this->db->where("appointment_id","$appointment_id");
		}
		if($hospital_email!='')
		{
			$this->db->where("email","$hospital_email");
		}
		if($hospital_phone!='')
		{
			$this->db->where("mobile","$hospital_phone");
		}
		if($hospital_name!='')
		{
			$this->db->where("(name LIKE '%".$hospital_name."%' )");
		}
		if($paient_name!='')
		{
			$this->db->where("(appointment_name LIKE '%".$paient_name."%' )");
		}
		if($paient_phone!='')
		{
			$this->db->where("(appointment_mobile LIKE '%".$paient_phone."%' )");
		}
		if($appointment_email!='')
		{
			$this->db->where("(appointment_email LIKE '%".$appointment_email."%' )");
		}
		if($payment_mode!='')
		{
			$this->db->where("payment_mode","$payment_mode");
		}
		if($date_from!='')
		{
			$this->db->where('appointment_date >=', $date_from);
		}
		if($date_to!='')
		{
			$this->db->where('appointment_date <=', $date_to);
		}
		if($time_from!='')
		{	
			$this->db->where('from_timing <=', $time_from);
		}
		if($time_to!='')
		{	
			$this->db->where('to_timing >=', $time_to);
		}
		if($doctor_name!='')
		{
			$this->db->where("(fname LIKE '%".$doctor_name."%' )");
		}
		if($city_name!='')
		{
			$this->db->where("hospital.city","$city_name");
		}
		$this->db->order_by('appointment_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS profile_dr.*,hospital.*,appointment.*',FALSE);
		$this->db->join('profile_dr','profile_dr.id=appointment.doctor_id','left');
		$this->db->join('hospital','hospital.id=appointment.institute_id','left');
		$result = $this->db->get('appointment')->result();
		return $result;
	}
	
	public function get_appointment_list($param=array())
	{		
		$appointment_id 	= $this->db->escape_str($this->input->get_post('appointment_id',TRUE));
		$hospital_email 	= $this->db->escape_str($this->input->get_post('hospital_email',TRUE));
		$hospital_phone 	= $this->db->escape_str($this->input->get_post('hospital_phone',TRUE));
		$hospital_name 		= $this->db->escape_str($this->input->get_post('hospital_name',TRUE));
		$paient_name 		= $this->db->escape_str($this->input->get_post('paient_name',TRUE));
		$paient_phone 		= $this->db->escape_str($this->input->get_post('paient_phone',TRUE));
		$appointment_email 	= $this->db->escape_str($this->input->get_post('appointment_email',TRUE));
		$payment_mode 		= $this->db->escape_str($this->input->get_post('payment_mode',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));	
		$time_from 			= $this->db->escape_str($this->input->get_post('time_from',TRUE));
		$time_to 			= $this->db->escape_str($this->input->get_post('time_to',TRUE));
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$city_name 			= $this->db->escape_str($this->input->get_post('city_name',TRUE));
				
	    if($appointment_id!='')
		{
			$this->db->where("appointment_id","$appointment_id");
		}
		if($hospital_email!='')
		{
			$this->db->where("email","$hospital_email");
		}
		if($hospital_phone!='')
		{
			$this->db->where("mobile","$hospital_phone");
		}
		if($hospital_name!='')
		{
			$this->db->where("(name LIKE '%".$hospital_name."%' )");
		}
		if($paient_name!='')
		{
			$this->db->where("(appointment_name LIKE '%".$paient_name."%' )");
		}
		if($paient_phone!='')
		{
			$this->db->where("(appointment_mobile LIKE '%".$paient_phone."%' )");
		}
		if($appointment_email!='')
		{
			$this->db->where("(appointment_email LIKE '%".$appointment_email."%' )");
		}
		if($payment_mode!='')
		{
			$this->db->where("payment_mode","$payment_mode");
		}
		if($date_from!='')
		{
			$this->db->where('appointment_date >=', $date_from);
		}
		if($date_to!='')
		{
			$this->db->where('appointment_date <=', $date_to);
		}
		if($time_from!='')
		{	
			$this->db->where('from_timing <=', $time_from);
		}
		if($time_to!='')
		{	
			$this->db->where('to_timing >=', $time_to);
		}
		if($doctor_name!='')
		{
			$this->db->where("(fname LIKE '%".$doctor_name."%' )");
		}
		if($city_name!='')
		{
			$this->db->where("hospital.city","$city_name");
		}
		$this->db->order_by('appointment_id','desc');
		//$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS profile_dr.*,hospital.*,appointment.*',FALSE);
		$this->db->join('profile_dr','profile_dr.id=appointment.doctor_id');
		$this->db->join('hospital','hospital.id=appointment.institute_id');
		$result = $this->db->get('appointment')->result_array();
		return $result;
	}
	
	public function get_upcomming($limit='10',$offset='0',$param=array())
	{		
		$hospital_name 		= $this->db->escape_str($this->input->get_post('hospital_name',TRUE));
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$paient_name 		= $this->db->escape_str($this->input->get_post('paient_name',TRUE));
		$paient_phone 		= $this->db->escape_str($this->input->get_post('paient_phone',TRUE));
		$appointment_id 	= $this->db->escape_str($this->input->get_post('appointment_id',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));	
		
		if($hospital_name!='')
		{
			$this->db->where("(name LIKE '%".$hospital_name."%' )");
		}
		if($doctor_name!='')
		{
			$this->db->where("(fname LIKE '%".$doctor_name."%' )");
		}
		if($paient_name!='')
		{
			$this->db->where("(appointment_name LIKE '%".$paient_name."%' )");
		}
		if($paient_phone!='')
		{
			$this->db->where("(appointment_mobile LIKE '%".$paient_phone."%' )");
		}
		if($appointment_id!='')
		{
			$this->db->where("appointment_id","$appointment_id");
		}
		if($date_from!='')
		{
			$this->db->where('appointment_date >=', $date_from);
		}
		if($date_to!='')
		{
			$this->db->where('appointment_date <=', $date_to);
		}
		$this->db->where("appointment.appointment_date>",date('Y-m-d'));
		$this->db->order_by('appointment_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS appointment.*,hospital.*,profile_dr.*',FALSE);
		$this->db->join('profile_dr','profile_dr.id=appointment.doctor_id','left');
		$this->db->join('hospital','hospital.id=appointment.institute_id','left');
		$result = $this->db->get('appointment')->result();
		return $result;
	}
	
	public function get_today($limit='10',$offset='0',$param=array())
	{		
		$hospital_name 		= $this->db->escape_str($this->input->get_post('hospital_name',TRUE));
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$paient_name 		= $this->db->escape_str($this->input->get_post('paient_name',TRUE));
		$paient_phone 		= $this->db->escape_str($this->input->get_post('paient_phone',TRUE));
		$appointment_id 	= $this->db->escape_str($this->input->get_post('appointment_id',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));	
		
		if($hospital_name!='')
		{
			$this->db->where("(name LIKE '%".$hospital_name."%' )");
		}
		if($doctor_name!='')
		{
			$this->db->where("(fname LIKE '%".$doctor_name."%' )");
		}
		if($paient_name!='')
		{
			$this->db->where("(appointment_name LIKE '%".$paient_name."%' )");
		}
		if($paient_phone!='')
		{
			$this->db->where("(appointment_mobile LIKE '%".$paient_phone."%' )");
		}
		if($appointment_id!='')
		{
			$this->db->where("appointment_id","$appointment_id");
		}
		if($date_from!='')
		{
			$this->db->where('appointment_date >=', $date_from);
		}
		if($date_to!='')
		{
			$this->db->where('appointment_date <=', $date_to);
		}
		$this->db->where("appointment.appointment_date",date('Y-m-d'));
		$this->db->order_by('appointment_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS appointment.*,hospital.*,profile_dr.*',FALSE);
		$this->db->join('profile_dr','profile_dr.id=appointment.doctor_id','left');
		$this->db->join('hospital','hospital.id=appointment.institute_id','left');
		$result = $this->db->get('appointment')->result();
		return $result;
	}
	
	public function get_appointment_details($appointment_id)
	{				
	    if($appointment_id!='')
		{
			$this->db->where("appointment_id",$appointment_id);
		}
		$this->db->select('profile_dr.fname,profile_dr.email as dr_email,hospital.name,appointment.*');
		$this->db->join('profile_dr','profile_dr.id=appointment.doctor_id');
		$this->db->join('hospital','hospital.id=appointment.institute_id');
		$result = $this->db->get('appointment')->row_array();
		return $result;
	}
	
	public function get_hospital()
	{		
		$hospital_email 	= $this->db->escape_str($this->input->get_post('hospital_email',TRUE));
		$hospital_phone 	= $this->db->escape_str($this->input->get_post('hospital_phone',TRUE));
		$hospital_name 		= $this->db->escape_str($this->input->get_post('hospital_name',TRUE));
		$city_name 			= $this->db->escape_str($this->input->get_post('city_name',TRUE));
				
		if($hospital_email!='')
		{
			$this->db->where("email","$hospital_email");
		}
		if($hospital_phone!='')
		{
			$this->db->where("mobile","$hospital_phone");
		}
		if($hospital_name!='')
		{
			$this->db->where("(name LIKE '%".$hospital_name."%' )");
		}
		if($city_name!='')
		{
			$this->db->where("hospital.city","$city_name");
		}
		else
		{
		  $this->db->order_by('uid','asc');
		}
		$this->db->select('hospital.*');
		$result = $this->db->get('hospital')->result();
		return $result;
	}

	public function get_account()
	{		 
		$hospital_name 		= $this->db->escape_str($this->input->get_post('hospital_name',TRUE));
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$payment_mode 		= $this->db->escape_str($this->input->get_post('payment_mode',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));
		$session_from 		= $this->db->escape_str($this->input->get_post('session_from',TRUE));
		$session_to 		= $this->db->escape_str($this->input->get_post('session_to',TRUE));
				
		if(!empty($hospital_name))
		{
			$this->db->where("(appointment.institute_id = '".$hospital_name."' OR hospital.id = '".$hospital_name."' OR hospital.uid = '".$hospital_name."')");
		}
		if(!empty($doctor_name))
		{
			$this->db->where("appointment.doctor_id", $doctor_name);
		}
		if(!empty($payment_mode))
		{
			$this->db->where("appointment.payment_mode", $payment_mode);
		}
		if(!empty($date_from))
		{
			$this->db->where('(appointment.appointment_date >= "'.$date_from.'" OR appointment.book_date >= "'.$date_from.' 00:00:00")');
		}
		if(!empty($date_to))
		{
			$this->db->where('(appointment.appointment_date <= "'.$date_to.'" OR appointment.book_date <= "'.$date_to.' 23:59:59")');
		}
		if(!empty($session_from))
		{	
			$this->db->where('appointment.book_date >=', $session_from);
		}
		if(!empty($session_to))
		{	
			$this->db->where('appointment.book_date <=', $session_to);
		}
		
		$this->db->select('appointment.institute_id, COUNT(appointment.appointment_id) as count, SUM(COALESCE(appointment.amount, appointment.fee, 0)) as total, SUM(CASE WHEN appointment.payment_status = "DONE" THEN COALESCE(appointment.amount, appointment.fee, 0) ELSE 0 END) as received_amount, appointment.payment_status, COALESCE(hospital.name, "Direct / Clinic Booking") as hospital_name, COALESCE(master_city.name, "General") as city_name');
		$this->db->group_by("appointment.institute_id");
		$this->db->order_by("total", "DESC");
		$this->db->join('hospital', '(hospital.uid = appointment.institute_id OR hospital.id = appointment.institute_id)', 'left');
		$this->db->join('master_city', 'master_city.id = hospital.city', 'left');
		$result = $this->db->get('appointment')->result();
		return $result;
	}

	public function get_account_appointment()
	{		 
		$hospital_name 		= $this->db->escape_str($this->input->get_post('hospital_name',TRUE));
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$payment_mode 		= $this->db->escape_str($this->input->get_post('payment_mode',TRUE));
		$payment_status 	= $this->db->escape_str($this->input->get_post('payment_status',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));
		$session_from 		= $this->db->escape_str($this->input->get_post('session_from',TRUE));
		$session_to 		= $this->db->escape_str($this->input->get_post('session_to',TRUE));
				
		if(!empty($hospital_name))
		{
			$this->db->where("(appointment.institute_id = '".$hospital_name."' OR hospital.id = '".$hospital_name."' OR hospital.uid = '".$hospital_name."')");
		}
		if(!empty($doctor_name))
		{
			$this->db->where("appointment.doctor_id", $doctor_name);
		}
		if(!empty($payment_mode))
		{
			$this->db->where("appointment.payment_mode", $payment_mode);
		}
		if(!empty($payment_status))
		{
			$this->db->where("appointment.payment_status", $payment_status);
		}
		if(!empty($date_from))
		{
			$this->db->where('(appointment.appointment_date >= "'.$date_from.'" OR appointment.book_date >= "'.$date_from.' 00:00:00")');
		}
		if(!empty($date_to))
		{
			$this->db->where('(appointment.appointment_date <= "'.$date_to.'" OR appointment.book_date <= "'.$date_to.' 23:59:59")');
		}
		if(!empty($session_from))
		{	
			$this->db->where('appointment.book_date >=', $session_from);
		}
		if(!empty($session_to))
		{	
			$this->db->where('appointment.book_date <=', $session_to);
		}
		
		$this->db->order_by('appointment.appointment_id', 'DESC');
		$this->db->select('appointment.*, COALESCE(hospital.name, "Direct / Clinic Booking") as hospital_name, profile_dr.fname as dr_fname, profile_dr.lname as dr_lname, profile_dr.mobile as dr_mobile, master_city.name as city_name');
		$this->db->join('hospital', '(hospital.uid = appointment.institute_id OR hospital.id = appointment.institute_id)', 'left');
		$this->db->join('profile_dr', 'profile_dr.id = appointment.doctor_id', 'left');
		$this->db->join('master_city', 'master_city.id = hospital.city', 'left');
		$result = $this->db->get('appointment')->result();
		return $result;
	}

	/**
	 * Update payment status, mode, transaction ID, and admin notes for an appointment.
	 * Called via AJAX from the Edit Payment modal on account_appointment view.
	 *
	 * @param  int   $appointment_id
	 * @param  array $data  Keys: payment_status, payment_mode, transaction_id, admin_notes
	 * @return bool
	 */
	public function update_payment_status($appointment_id, $data = array())
	{
		$appointment_id = (int) $appointment_id;
		if ($appointment_id <= 0 || empty($data)) {
			return false;
		}

		$allowed = array('payment_status', 'payment_mode', 'transaction_id', 'admin_notes');
		$update  = array();
		foreach ($allowed as $field) {
			if (array_key_exists($field, $data)) {
				$update[$field] = $data[$field];
			}
		}

		if (empty($update)) {
			return false;
		}

		// Stamp pay_date when marking as DONE/settled
		if (!empty($update['payment_status']) && strtoupper($update['payment_status']) === 'DONE') {
			$update['pay_date'] = date('Y-m-d H:i:s');
		}

		$this->db->where('appointment_id', $appointment_id);
		return $this->db->update('appointment', $update);
	}

	/**
	 * Return aggregate KPI summary across all appointments.
	 * Used to refresh dashboard totals after an AJAX payment-status edit.
	 *
	 * @return array  { total_volume, total_received, total_pending, facility_count }
	 */
	public function get_account_summary()
	{
		$this->db->select(
			'SUM(COALESCE(amount, fee, 0)) as total_volume,
			 SUM(CASE WHEN payment_status = "DONE" THEN COALESCE(amount, fee, 0) ELSE 0 END) as total_received,
			 COUNT(DISTINCT institute_id) as facility_count',
			FALSE
		);
		$row = $this->db->get('appointment')->row_array();
		$total_volume   = (float)  ($row['total_volume']   ?? 0);
		$total_received = (float)  ($row['total_received'] ?? 0);
		$facility_count = (int)    ($row['facility_count'] ?? 0);
		return array(
			'total_volume'   => $total_volume,
			'total_received' => $total_received,
			'total_pending'  => max(0, $total_volume - $total_received),
			'facility_count' => $facility_count,
		);
	}
	
	public function get_profile_dr()
	{		
		$doctor_email 	= $this->db->escape_str($this->input->get_post('doctor_email',TRUE));
		$doctor_phone 	= $this->db->escape_str($this->input->get_post('doctor_phone',TRUE));
		$doctor_name 	= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$city_name 		= $this->db->escape_str($this->input->get_post('city_name',TRUE));
				
		if(!empty($doctor_email))
		{
			$this->db->where("(profile_dr.email LIKE '%".$doctor_email."%')");
		}
		if(!empty($doctor_phone))
		{
			$this->db->where("(profile_dr.mobile LIKE '%".$doctor_phone."%')");
		}
		if(!empty($doctor_name))
		{
			$this->db->where("(profile_dr.fname LIKE '%".$doctor_name."%' OR profile_dr.lname LIKE '%".$doctor_name."%')");
		}
		if(!empty($city_name))
		{
			$this->db->where("profile_dr.city", $city_name);
		}
		$this->db->where("profile_dr.status !=", "2");
		$this->db->order_by('profile_dr.id', 'DESC');
		$this->db->select("profile_dr.*, master_city.name as city_name, (SELECT COUNT(*) FROM appointment WHERE appointment.doctor_id = profile_dr.id) as total_appointments", FALSE);
		$this->db->join('master_city', 'master_city.id = profile_dr.city', 'left');
		$result = $this->db->get('profile_dr')->result();
		return $result;
	}

	public function get_dr_hospital_id()
	{	
		$hospital_id 		=$this->uri->segment(4);	
		$doctor_email 		= $this->db->escape_str($this->input->get_post('doctor_email',TRUE));
		$doctor_phone 		= $this->db->escape_str($this->input->get_post('doctor_phone',TRUE));
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$city_name 			= $this->db->escape_str($this->input->get_post('city_name',TRUE));
				
		if($doctor_email!='')
		{
			$this->db->where("email","$doctor_email");
		}
		if($doctor_phone!='')
		{
			$this->db->where("mobile","$doctor_phone");
		}
		if($doctor_name!='')
		{
			$this->db->where("(fname LIKE '%".$doctor_name."%' )");
		}
		if($city_name!='')
		{
			$this->db->where("city","$city_name");
		}
		else
		{
		  $this->db->order_by('user_id','asc');
		}

   		$this->db->select('profile_dr.*,dr_practice.status as p_status');
   		$this->db->join('profile_dr','profile_dr.id=dr_practice.user_id');
   		$result = $this->db->get_where('dr_practice',array('institution_id'=>$hospital_id,'type'=>'H'))->result();
		return $result;
	}

	public function get_appointment_by_droctor_id($doc_id = 0)
	{		
		$doctor_id 			= ($doc_id > 0) ? $doc_id : (int) $this->uri->segment(4);
		$paient_name 		= $this->db->escape_str($this->input->get_post('paient_name',TRUE));
		$paient_phone 		= $this->db->escape_str($this->input->get_post('paient_phone',TRUE));
		$appointment_email 	= $this->db->escape_str($this->input->get_post('appointment_email',TRUE));
		$payment_mode 		= $this->db->escape_str($this->input->get_post('payment_mode',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));	
		$session_from 		= $this->db->escape_str($this->input->get_post('session_from',TRUE));
		$session_to 		= $this->db->escape_str($this->input->get_post('session_to',TRUE));

		if(!empty($paient_name))
		{
			$this->db->where("(appointment.appointment_name LIKE '%".$paient_name."%')");
		}
		if(!empty($paient_phone))
		{
			$this->db->where("(appointment.appointment_mobile LIKE '%".$paient_phone."%')");
		}
		if(!empty($appointment_email))
		{
			$this->db->where("(appointment.appointment_email LIKE '%".$appointment_email."%')");
		}		
		if(!empty($payment_mode))
		{
			$this->db->where("appointment.payment_mode", $payment_mode);
		}
		if(!empty($date_from))
		{
			$this->db->where('appointment.appointment_date >=', $date_from);
		}
		if(!empty($date_to))
		{
			$this->db->where('appointment.appointment_date <=', $date_to);
		}
		if(!empty($doctor_id))
		{
			$this->db->where("appointment.doctor_id", $doctor_id);
		}
		$this->db->order_by('appointment.appointment_id', 'DESC');
		$this->db->select('appointment.*, hospital.name as hospital_name, profile_dr.fname as dr_fname, profile_dr.lname as dr_lname, profile_dr.mobile as dr_mobile');
		$this->db->join('hospital', '(hospital.uid = appointment.institute_id OR hospital.id = appointment.institute_id)', 'left');
		$this->db->join('profile_dr', 'profile_dr.id = appointment.doctor_id', 'left');
		$result = $this->db->get('appointment')->result();
		return $result;
	}

	public  function get_city($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{	
			$this->db->select('id,name');
			$result =  $this->db->get_where('master_city',$page)->result_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public  function get_locality($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{	
			$this->db->select('id,city_id,name');
			$result =  $this->db->get_where('master_locality',$page)->result_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}

	public  function hospital_list($page=array())
	{
		if( is_array($page) && !empty($page) )
		{	
			$this->db->select('id,name');
			$result =  $this->db->get_where('hospital',$page)->result_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public  function specialization_list($page=array())
	{
		if( is_array($page) && !empty($page) )
		{	
			$this->db->select('id,name');
			$result =  $this->db->get_where('master_specialization',$page)->result_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public  function specialization_doctor_list($page=array())
	{
		if( is_array($page) && !empty($page) )
		{	
			$this->db->select('profile_dr.id,profile_dr.fname');
			$this->db->join('profile_dr','profile_dr.id=dr_specialization.user_id');
   			$result = $this->db->get_where('dr_specialization',$page)->result_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public  function doctor_list($page=array())
	{
		if( is_array($page) && !empty($page) )
		{	
			$this->db->select('profile_dr.id,profile_dr.fname');
			$this->db->join('profile_dr','profile_dr.id=dr_practice.user_id');
   			$result = $this->db->get_where('dr_practice',$page)->result_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}

	function get_monthly_totals($theYear = '', $theMonth = '', $payment_mode = '')
	{	
		$this->db->select("SUM(COALESCE(amount, fee, 0)) as TotalAmount", false);
		$this->db->from('appointment');
		if ($payment_mode != '') 
		{	
			$this->db->where("payment_mode", $payment_mode);
		}
		if ($theYear != '') 
		{	
			$this->db->where("YEAR(COALESCE(NULLIF(pay_date, '0000-00-00 00:00:00'), NULLIF(book_date, '0000-00-00 00:00:00'), appointment_date)) = '" . $theYear . "'", NULL, FALSE);
		}
		if ($theMonth != '')
		{	
			$this->db->where("MONTH(COALESCE(NULLIF(pay_date, '0000-00-00 00:00:00'), NULLIF(book_date, '0000-00-00 00:00:00'), appointment_date)) = '" . $theMonth . "'", NULL, FALSE);
		}
		$query = $this->db->get();
		return $query->result_array();
	}
}