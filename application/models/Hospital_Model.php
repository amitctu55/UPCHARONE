<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Hospital_Model extends CI_Model 
{	
	function __construct() 
	{
		//parent::__construct();
		if($this->session->userdata('hosuserid'))
		{	
			$this->did = $this->db->where('uid',$this->session->userdata('hosuserid'))->get('hospital')->row()->id;
		}
	}
	
	public function get_appointment($limit='10',$offset='0',$param=array())
	{		
		$userid 			= $this->did;
		$keyword 			= $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
		$doctor_id 			= $this->db->escape_str($this->input->get_post('doctor_id',TRUE));
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$paient_name 		= $this->db->escape_str($this->input->get_post('paient_name',TRUE));
		$paient_phone 		= $this->db->escape_str($this->input->get_post('paient_phone',TRUE));
		$payment_status 	= $this->db->escape_str($this->input->get_post('payment_status',TRUE));
		$appointment_status = $this->db->escape_str($this->input->get_post('appointment_status',TRUE));
		$day_category 		= $this->db->escape_str($this->input->get_post('day_category',TRUE));
		$d_date 			= $this->db->escape_str($this->input->get_post('d',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));	
		
		if($userid!='')
		{
			$this->db->where('institute_id', $userid);   
		}
		if($keyword!='')
		{
			$this->db->where("(appointment.appointment_name LIKE '%".$keyword."%' OR appointment.appointment_mobile LIKE '%".$keyword."%' OR appointment.appointment_id LIKE '%".$keyword."%' OR profile_dr.fname LIKE '%".$keyword."%' OR profile_dr.lname LIKE '%".$keyword."%')");
		}
		if($doctor_id!='')
		{
			$this->db->where('appointment.doctor_id', $doctor_id);
		}
		if($doctor_name!='')
		{
			$this->db->where("(profile_dr.fname LIKE '%".$doctor_name."%' OR profile_dr.lname LIKE '%".$doctor_name."%')");
		}
		if($paient_name!='')
		{
			$this->db->where("(appointment.appointment_name LIKE '%".$paient_name."%')");
		}
		if($paient_phone!='')
		{
			$this->db->where("(appointment.appointment_mobile LIKE '%".$paient_phone."%')");
		}
		if($payment_status!='')
		{
			$this->db->where('appointment.payment_status', $payment_status);
		}
		if($appointment_status!='')
		{
			$this->db->where('appointment.appointment_status', $appointment_status);
		}
		if($d_date!='')
		{
			$this->db->where('appointment.appointment_date', $d_date);
		}
		if($day_category!='')
		{
			$current_date = date('Y-m-d');
			if($day_category=='Today')
			{
				$this->db->where('appointment.appointment_date', $current_date);
			}
			else if($day_category=='Tomorrow')
			{
				$tomorrow = date('Y-m-d', strtotime('+1 day'));
				$this->db->where('appointment.appointment_date', $tomorrow);
			}
			else if($day_category=='ThisWeek')
			{
				$week_end = date('Y-m-d', strtotime('+7 days'));
				$this->db->where('appointment.appointment_date >=', $current_date);
				$this->db->where('appointment.appointment_date <=', $week_end);
			}
			else if($day_category=='Upcomming')
			{
				$this->db->where('appointment.appointment_date >=', $current_date);
			}
			else if($day_category=='Past')
			{
				$this->db->where('appointment.appointment_date <', $current_date);
			}
		}
		if($date_from!='')
		{
			$this->db->where('appointment.appointment_date >=', $date_from);
		}
		if($date_to!='')
		{
			$this->db->where('appointment.appointment_date <=', $date_to);
		}
		$this->db->where('institution_type', 'H'); 
		$this->db->where('appointment.status !=', '0'); 
		$this->db->order_by('appointment.appointment_date','desc');
		$this->db->order_by('appointment.appointment_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS appointment.appointment_id, appointment.appointment_date, appointment.from_timing, appointment.to_timing, appointment.appointment_name as patient_name, appointment.appointment_mobile, appointment.fee, appointment.amount, appointment.doctor_id, appointment.institute_id, appointment.institution_type, appointment.status, appointment.payment_status, appointment.appointment_status, profile_dr.fname, profile_dr.lname, profile_dr.drimage', FALSE);
		$this->db->join('profile_dr','profile_dr.id=appointment.doctor_id', 'left');
		$result = $this->db->get('appointment')->result();
		return $result;
	}
	
	public function get_package($limit='10',$offset='0',$param=array())
	{	
		$package_id		= @$param['package_id'];
		$hospital_id 	= @$param['hospital_id'];
		$keyword 			= $this->db->escape_str($this->input->get('keyword',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));	
		
		if($package_id!='')
		{
			$this->db->where("package_id",$package_id);
		}
		
		if($hospital_id!='')
		{
			$this->db->where("package.hospital_id",$hospital_id);
		}
	    if($keyword!='')
		{
			$this->db->where("(title LIKE '%".$keyword."%' )");
		}
		if($date_from!='')
		{
			$this->db->where('package.creat_date >=', $date_from);
		}
		if($date_to!='')
		{
			$this->db->where('package.creat_date <=', $date_to);
		}
		$this->db->order_by('package_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS package.*,hospital.name',FALSE);
		$this->db->join('hospital','hospital.uid=package.hospital_id','left');
		$result = $this->db->get('package')->result_array();
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
	}
	
	public function get_bed($limit='10',$offset='0',$param=array())
	{	
		$hospital_id 		= @$param['hospital_id'];
		$hospital_bed_id 	= @$param['hospital_bed_id'];
		$keyword 			= $this->db->escape_str($this->input->get('keyword',TRUE));
		$date_from 			= $this->db->escape_str($this->input->get_post('date_from',TRUE));
		$date_to 			= $this->db->escape_str($this->input->get_post('date_to',TRUE));	
		
		if($hospital_id!='')
		{
			$this->db->where("hospital_bed.hospital_id",$hospital_id);
		}
		if($hospital_bed_id!='')
		{
			$this->db->where("hospital_bed.hospital_bed_id",$hospital_bed_id);
		}
	    if($keyword!='')
		{
			$this->db->where("(hospital_bed.bed_type LIKE '%".$keyword."%' )");
		}
		if($date_from!='')
		{
			$this->db->where('hospital_bed.creat_date >=', $date_from);
		}
		if($date_to!='')
		{
			$this->db->where('hospital_bed.creat_date <=', $date_to);
		}
		$this->db->order_by('hospital_bed_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS hospital_bed.*,hospital.name',FALSE);
		$this->db->join('hospital','hospital.id=hospital_bed.hospital_id','left');
		$result = $this->db->get('hospital_bed')->result_array();
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
	}
	
	public function update_status($table,$auto_field='id')
	{	
		$current_controller    = $this->router->fetch_class();
		$action                = $this->input->post('status_action',TRUE);	
	    $arr_ids               = $this->input->post('arr_ids',TRUE);
		//$category_count        = $this->input->post('category_count',TRUE);
		//$product_count         = $this->input->post('product_count',TRUE);	
		
		if(is_array($arr_ids) )
		{	
			$str_ids = implode(',', $arr_ids);
			if($action=='Appointment Done')
			{		
				foreach($arr_ids as $k=>$v )
				{
					$appointmnet	=	$this->get_appointment_details(array('appointment_status'=>'0','payment_status'=>'DONE','appointment_id'=>$v));
					if(is_array($appointmnet) && !empty($appointmnet))
					{
						$appointment_by = $this->session->userdata('hosuserid');
						$data 	= array(
										'appointment_status'	=>'1',
										'appointment_by'		=>$appointment_by,
										'appointment_done_date'	=>date('Y-m-d h:i:s')
										);
						$where = "$auto_field ='$v'";					
						$this->Hospital_Model->safe_update($table,$data,$where,FALSE);											
						$this->session->set_userdata(array('msg_type'=>'success'));
						$this->session->set_flashdata('success','Appointment Done successfully.');
					}
				}
			}
			if($action=='Payment Done')
			{	  
				foreach($arr_ids as $k=>$v )
				{
					$payment	=	$this->get_appointment_details(array('payment_status'=>'UNPAID','appointment_id'=>$v));
					if(is_array($payment) && !empty($payment))
					{
						$data = array('payment_status'=>'DONE');
						$where = "$auto_field ='$v'";					
						$this->Hospital_Model->safe_update($table,$data,$where,FALSE);
						$this->session->set_userdata(array('msg_type'=>'success'));
						$this->session->set_flashdata('success','Payment Done successfully.');
					}
				}	
			}
        }
		redirect($_SERVER['HTTP_REFERER'], '');
	}
	
	public  function get_appointment_details($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{
			$result =  $this->db->get_where('appointment',$page)->row_array();
			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public function safe_update($table,$data=array(),$where='',$debug=FALSE)
	{	 
		if($table!="" && is_array($data) && !empty($data) && $where!="" )
		{
			$qstr = $this->db->update_string($table, $data, $where);
			$this->db->query($qstr);
			if ( $debug )
			{ 
				echo  $this->db->last_query(); 
				
			}
		}
	}
	
	public  function get_doctor_home($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{
			$this->db->select('profile_dr.id,profile_dr.fname,profile_dr.lname,profile_dr.drimage');
			$this->db->order_by('profile_dr.id','RANDOM');
			$this->db->limit(12);
			$this->db->where('hospital.subscription','1');
			$this->db->join('dr_practice','dr_practice.user_id=profile_dr.id','left');
			$this->db->join('hospital','hospital.id=dr_practice.institution_id','left');
			$result =  $this->db->get_where('profile_dr',$page)->result();
			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public  function get_degree($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{
			$result =  $this->db->get_where('master_degree',$page)->result_array();
			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public  function get_specialization($page=array())
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
	
	public function get_doctor($limit='10',$offset='0',$param=array())
	{		
		$userid 			= $this->did;
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$specialization_id  = $this->db->escape_str($this->input->get_post('specialization_id',TRUE));
		$qualification_id   = $this->db->escape_str($this->input->get_post('qualification_id',TRUE));
		if($doctor_name!='')
		{	
			$this->db->where("(fname LIKE '%".$doctor_name."%' )");
		}
		if($userid!='')
		{	
			$this->db->where('institution_id',$userid);
		}
		if($specialization_id!='')
		{	
			$this->db->where('dr_specialization.specialization_id',$specialization_id);
		}
		if($qualification_id!='')
		{	
			$this->db->where('dr_qualifications.qualification_id',$qualification_id);
		}
		$this->db->select('SQL_CALC_FOUND_ROWS profile_dr.*,dr_practice.status as p_status',FALSE);
		$this->db->limit($limit,$offset);
		$this->db->where('type','H');
		$this->db->join('profile_dr','profile_dr.id=dr_practice.user_id');
		$this->db->join('dr_specialization','dr_specialization.user_id=profile_dr.id','left');
		$this->db->join('dr_qualifications','dr_qualifications.user_id=profile_dr.id','left');
		$this->db->group_by('profile_dr.id');
		$result = $this->db->get_where('dr_practice')->result();	
		return $result;
	}
	
	public function get_upchar_doctor($limit='10',$offset='0',$param=array())
	{		
		$userid 			= $this->did;
		$doctor_name 		= $this->db->escape_str($this->input->get_post('doctor_name',TRUE));
		$specialization_id  = $this->db->escape_str($this->input->get_post('specialization_id',TRUE));
		$qualification_id   = $this->db->escape_str($this->input->get_post('qualification_id',TRUE));
		if($doctor_name!='')
		{	
			$this->db->where("(fname LIKE '%".$doctor_name."%' )");
		}
		if($specialization_id!='')
		{	
			$this->db->where('dr_specialization.specialization_id',$specialization_id);
		}
		if($qualification_id!='')
		{	
			$this->db->where('dr_qualifications.qualification_id',$qualification_id);
		}
		$this->db->select('SQL_CALC_FOUND_ROWS profile_dr.*,dr_practice.status as p_status',FALSE);
		$this->db->limit($limit,$offset);
		$this->db->where('approved','1');
		$this->db->where('verified','1');
		$this->db->join('dr_practice','profile_dr.id=dr_practice.user_id AND institution_id=\''.$this->did.'\' AND type=\'H\' ','left');
		$this->db->join('dr_specialization','dr_specialization.user_id=profile_dr.id','left');
		$this->db->join('dr_qualifications','dr_qualifications.user_id=profile_dr.id','left');
		$this->db->group_by('profile_dr.id');
		$result = $this->db->get_where('profile_dr')->result();	
		return $result;
	}
	
	public function addlinkdoctor()
	{
	   $already=$this->input->post('link');
	   $drid=$this->input->post('link2');
	   
	   if($already==1 && $drid!=''){
		   
		   $result=$this->db->where(array('type'=>'H','institution_id'=>$this->did,'user_id'=>$drid))->get('dr_practice');
			$count=$result->num_rows();
			if($count){
				$practiceid=$result->row()->id;
				
				
			}else{
				$udata=array('institution_id'=>$this->did,'user_id'=>$drid,'type'=>'H','status'=>'0');
				$this->db->insert('dr_practice',$udata);
				$practiceid=$this->db->insert_id();
				//email to dr to approve link 
				$data=$this->db->get_where('profile_dr',array('uid'=>$drid))->row();
				$this->load->library('azad_lib');
		 	$body="Request from  abcd hospital for profile approval   ".base_url().'home/securepapproval/'.mybase64_encode($practiceid).'/'.mybase64_encode($drid).'';
			$this->azad_lib->sendMail($data->email,'Request from  abcd hospital for profile approval',$body);
				
			}
	   }else{
		   
		   $email=strtolower(trim($this->input->post('email')));
		
		$mobile=trim($this->input->post('mobile'));
		$countemail=$this->db->where('EMAIL',$email)->count_all_results('hospitallogin');
		$countmobile=$this->db->where('MOBILE',$mobile)->count_all_results('hospitallogin');
		if($countemail > 0  && $email!='')
		{
			$response=array('status'=>'failed','msg'=>'Email Id Already Registered, Reset Your Password if You Forgotten ! ');
		}
		else if($countmobile > 0 && $mobile!='')
		{
			$response=array('status'=>'failed','msg'=>'Mobile No. Already Registered, Reset Your Password if You Forgotten ! ');
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
				
		   
		   $udata=array('email'=>$this->input->post('email'),'mobile'=>$this->input->post('mobile'),'fname'=>$this->input->post('name'),'gender'=>$this->input->post('gender'),'city'=>$this->input->post('city'),'regd_no'=>$this->input->post('regno'),'regd_council'=>$this->input->post('council'),'regd_year'=>$this->input->post('ryear'),'college'=>$this->input->post('college'),'exp'=>$this->input->post('exp'),'year'=>$this->input->post('year'),'user_id'=>$thisid);
			$this->db->insert('profile_dr',$udata);
			
			$drid=$this->db->insert_id();
			$specialisation = $this->input->post('specialisation');
			foreach($specialisation as $s){
				$spldata[]=array('user_id'=>$drid,'specialization_id'=>$s);
			}
			$qualification =$this->input->post('qualification');
			foreach($qualification as $q){
				$qualdata[]=array('user_id'=>$drid,'qualification_id'=>$q);
			}
			$this->db->insert_batch('dr_qualifications',$qualdata);
			$this->db->insert_batch('dr_specialization',$spldata);
			
			$udata=array('institution_id'=>$this->did,'user_id'=>$drid,'type'=>'H','status'=>'0');
			$this->db->insert('dr_practice',$udata);
			$practiceid=$this->db->insert_id();
			//email to dr to claim approve link with login
			$this->load->library('azad_lib');
			$body="Request from  abcd hospital for profile approval <BR>   Login: $mobile / $otp  ".base_url().'home/securepapproval/'.mybase64_encode($practiceid).'/'.mybase64_encode($drid).'';
			$this->azad_lib->sendMail($email,'Request from  abcd hospital for profile approval',$body);
			/* $msg="Dear ".$name[0].", Wecome to Upcharr medical solutions. Your otp is $otp
thank you for being a part of Upchar.";
			sendsms($msg,$mobile); */
			}
		}
	   }
   }
   
   
    public function patient()
   {
    	$id		= $this->uri->segment(2);
		$date	= date('Y-m-d h:i:s');
   		$data	= array('payment_status'=>'DONE',
						'pay_date'		=>$date);
   		$this->db->where('appointment_id',$id)->update('appointment',$data);
  
  		 //redirect('hospitalpanel/patient');

   }
   
   	public function updateprofile(){
		$clinicname=$this->input->post('clinicname');
		$cliniccity=$this->input->post('cliniccity');
		$cliniclocality=$this->input->post('cliniclocality');
		
		$udata=array('name'=>$clinicname,'city'=>$cliniccity,'location'=>$cliniclocality);
			$this->db->where('id',$this->did)->update('hospital',$udata);
			redirect('hospitalpanel/profile_clinicproof');
		}
		
	
	public function profile_clinicproof(){
		
		$uploadimage=$_FILES['images']['name'];
		$extsign = pathinfo($_FILES['images']['name'],PATHINFO_EXTENSION);
		
		if($uploadimage != '') 
		{	
			$rname=rand(1111111,999999999);
			$date=date('Ymd');
			$uploadimage='hospital_proof_pic_'.$rname.$date.'.'.$extsign;
			$config['upload_path']          = $_SERVER['DOCUMENT_ROOT'].'/admin1947/public/assets/upload/';
					$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
					$config['max_size']             = 0;
					$config['quality'] = '50%';
					$config['file_name']  = $uploadimage;
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('images'))
					{
						$error = $this->upload->display_errors();
						echo $flashmsg='<div class="alert alert-danger">
						  <strong>Failed!</strong>'.$error.'
						</div>';
						$this->session->set_flashdata('flashmsg',$flashmsg);
						redirect('hospitalpanel/profile_clinicproof');
						exit();
						
					}else{
						$udata=array('med_reg_proof'=>$uploadimage);
						$this->db->where('id',$this->did)->update('hospital',$udata);
					}
		}
		
		redirect('hospitalpanel/profile_disppic');	
	}
	
	public function profile_disppic(){
		//print_r($_FILES);
		//print_r($_POST);
		$uploadimage=$_FILES['images']['name'];
		$extsign = pathinfo($_FILES['images']['name'],PATHINFO_EXTENSION);
		
		if($uploadimage != '') 
		{	
			$rname=rand(1111111,999999999);
			$date=date('Y-m-d');
			$uploadimage='disp_profile_pic_'.$rname.$date.'.'.$extsign;
			$config['upload_path']          = $_SERVER['DOCUMENT_ROOT'].'/admin1947/public/assets/upload/';
					$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
					$config['max_size']             = 0;
					$config['quality'] = '50%';
					$config['file_name']  = $uploadimage;
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('images'))
					{
						$error = $this->upload->display_errors();
						echo $flashmsg='<div class="alert alert-danger">
						  <strong>Failed!</strong>'.$error.'
						</div>';
						$this->session->set_flashdata('flashmsg',$flashmsg);
						redirect('hospitalpanel/profile_disppic');
						exit();
						
					}else{
						$udata=array('drimage'=>$uploadimage);
						$this->db->where('id',$this->did)->update('hospital',$udata);
					}
		}
		redirect('hospitalpanel/profile_maplocation');	
	}
	
	public function profile_maplocation(){
		$udata=array('email'=>$this->input->post('email'),'mobile'=>$this->input->post('mobile'),'address'=>$this->input->post('address'));
		$this->db->where('id',($this->did))->update('hospital',$udata);
		
		
		redirect('hospitalpanel/profile_clinic_timing');	
	}
	
	public function profile_clinic_timing(){
		
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
		
		$this->db->query("DELETE `timing`,`timing_session` FROM `timing` INNER JOIN `timing_session`  ON timing_session.timing_id=timing.id WHERE user_id='".$this->did."' AND user_type='H';");
		for($key2=0;$key2<$hiddenday;$key2++){
			$mon[$key2]=(@$mon[$key2])? 1 : 0;
			$tue[$key2]=(@$tue[$key2])? 1 : 0;
			$wed[$key2]=(@$wed[$key2])? 1 : 0;
			$thu[$key2]=(@$thu[$key2])? 1 : 0;
			$fri[$key2]=(@$fri[$key2])? 1 : 0;
			$sat[$key2]=(@$sat[$key2])? 1 : 0;
			$sun[$key2]=(@$sun[$key2])? 1 : 0;
			
			if(!$mon[$key2] && !$tue[$key2] && !$wed[$key2] && !$thu[$key2] && !$fri[$key2] && !$sat[$key2] && !$sun[$key2] )
				continue;
			
			$timingdata=array('user_id'=>$this->did,'user_type'=>'H','M'=>$mon[$key2],'T'=>$tue[$key2],	'W'=>$wed[$key2],'TH'=>$thu[$key2],	'F'=>$fri[$key2],	'SA'=>$sat[$key2],	'S'=>$sun[$key2],	'status'=>'1');
			$this->db->insert('timing',$timingdata);
			
			$sessions=$from[$key2];
			$tid= $this->db->insert_id();
			foreach($sessions as $key3=>$value){
				if($from[$key2][$key3]=='' || $from[$key2][$key3]=='')
					continue;
				$sessiondata = array('timing_id'=>$tid,'from_timing'=>$from[$key2][$key3],'to_timing'=>$to[$key2][$key3],'status'=>'1');
				$this->db->insert('timing_session',$sessiondata);
						
			}
				
		}
		redirect('hospital-dashboard');	
			
	}
	
	public function bed_insert($drimage='')
	{	
		$data=array(
					'hospital_id'	=>$this->did,
					'bed_type'		=>$this->input->post('bed_type'),
					'total_bed'		=>$this->input->post('total_bed'),
					'occupied_bed'	=>$this->input->post('occupied_bed'),
					'amount'		=>$this->input->post('amount'),
					'comment'		=>$this->input->post('comment'),
					'status'		=>$this->input->post('status'),
					'creat_date'	=>date('Y-m-d h:i:s')
				   );
			
	    $this->db->insert('hospital_bed',$data);
	    return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function update_bed($hospital_bed_id)
	{
		$data=array(
					'hospital_id'	=>$this->did,
					'bed_type'		=>$this->input->post('bed_type'),
					'total_bed'		=>$this->input->post('total_bed'),
					'occupied_bed'	=>$this->input->post('occupied_bed'),
					'amount'		=>$this->input->post('amount'),
					'comment'		=>$this->input->post('comment'),
					'status'		=>$this->input->post('status'),
					'modified_date'	=>date('Y-m-d h:i:s')
				   );
        $this->db->where('hospital_bed_id',$hospital_bed_id);
		$this->db->update('hospital_bed',$data);
        return 1;
	}
	
	public function package_insert($drimage='')
	{	
		$userid 		=  $this->did;
		$date 			= date('Y-m-d h:i:s');
		$title			= $this->input->post('title');	
		$video_url		= $this->input->post('video_url');
		$amount 		= $this->input->post('amount');
		$status 		= $this->input->post('status');
		$approved 		= 1;
		$description 	= $this->input->post('description');
 
		$data=array(
					'hospital_id'	=>$userid,
					'title'			=>$title,
					'amount'		=>$amount,
					'video_url'		=>$video_url,
					'description'	=>$description,
					'image'			=>$drimage,
					'status'		=>$status,
					'approved'		=>$approved,
					'creat_date'	=>$date
				   );
			
	    $this->db->insert('package',$data);
	    return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function update_package($id,$picture='')
	{
        $date 			=date('Y-m-d h:i:s');
		$title			=$this->input->post('title');	
		$amount			=$this->input->post('amount');	
		$video_url		=$this->input->post('video_url');
		$status 		=$this->input->post('status');
		$approved 		=$this->input->post('approved');
		$description 	=$this->input->post('description');

		$data=array(
					'title'			=>$title,
					'amount'		=>$amount,
					'video_url'		=>$video_url,
					'description'	=>$description,
					'image'			=>$picture,
					'status'		=>$status,
					'approved'		=>$approved,
					'creat_date'	=>$date
				   );
        $this->db->where('package_id',$id);
		$this->db->update('package',$data);
        return 1;
	}
	
	
	public function profile_step1()
	{
		$udata=array('fname'=>$this->input->post('name'),'gender'=>$this->input->post('gender'),'city'=>$this->input->post('city'));
		$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
		
		$this->db->delete('dr_specialization',array('user_id'=>$this->did));
		$specialisation = $this->input->post('specialisation');
			foreach($specialisation as $s){
				$spldata[]=array('user_id'=>$this->did,'specialization_id'=>$s);
			}
		$this->db->insert_batch('dr_specialization',$spldata);
			
		redirect('profile_step2');
		
	}
	
	public function profile_step2(){
		$udata=array('regd_no'=>$this->input->post('regno'),'regd_council'=>$this->input->post('council'),'regd_year'=>$this->input->post('year'));
		$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
		
		
		redirect('profile_step3');
		
	}
	
	public function profile_step3(){
		$udata=array('college'=>$this->input->post('college'),'exp'=>$this->input->post('exp'),'year'=>$this->input->post('year'));
		$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
		
		$this->db->delete('dr_qualifications',array('user_id'=>$this->did));
		$qualification =$this->input->post('qualification');
		foreach($qualification as $q){
			$qualdata[]=array('user_id'=>$this->did,'qualification_id'=>$q);
		}
		$this->db->insert_batch('dr_qualifications',$qualdata);
			
		redirect('profile_drpic');
		
	}
	
	public function profile_drpic(){
		//print_r($_FILES);
		//print_r($_POST);
		$uploadimage=$_FILES['images']['name'];
		$extsign = pathinfo($_FILES['images']['name'],PATHINFO_EXTENSION);
		
		if($uploadimage != '') 
		{	
			$rname=rand(1111111,999999999);
			$date=date('Y-m-d');
			$uploadimage='dr_profile_pic_'.$rname.$date.'.'.$extsign;
			$config['upload_path']          = $_SERVER['DOCUMENT_ROOT'].'/admin1947/public/assets/upload/';
					$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
					$config['max_size']             = 0;
					$config['quality'] = '50%';
					$config['file_name']  = $uploadimage;
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('images'))
					{
						$error = $this->upload->display_errors();
						echo $flashmsg='<div class="alert alert-danger">
						  <strong>Failed!</strong>'.$error.'
						</div>';
						$this->session->set_flashdata('flashmsg',$flashmsg);
						redirect('profile_drpic');
						exit();
						
					}else{
						$udata=array('drimage'=>$uploadimage);
						$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
					}
		}
		redirect('profile_idproof');	
	}
	
	public function profile_idproof(){
		//$udata=array('clinic_type'=>$this->input->post('practicetype'));
		//$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
		
		redirect('profile_regproof');	
	}
	public function profile_regproof(){
		//$udata=array('clinic_type'=>$this->input->post('practicetype'));
		//$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
		
		redirect('managepractice');	
	}
	public function profile_step4(){
		$udata=array('clinic_type'=>$this->input->post('practicetype'));
		$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
		
		redirect('profile_step5');
		
	}
	
	
	
	
	public function addpractice(){
		$clinicname=$this->input->post('clinicname');
		$cliniccity=$this->input->post('cliniccity');
		$cliniclocality=$this->input->post('cliniclocality');
		//search cilinic & suggest if any else save
		$this->db->like('name',$clinicname);
		//$this->db->where('city',$cliniccity);
		//$this->db->where('location',$cliniclocality);
		$clinic = $this->db->get('clinic');
		$suggestedclinic=$clinic->result();
		
		$this->db->like('name',$clinicname);
		//$this->db->where('city',$cliniccity);
		//$this->db->where('location',$cliniclocality);
		$hosp = $this->db->get('hospital');
		$suggestedhospital=$hosp->result();
		
		$countguggestedclinic=$clinic->num_rows();
		$countguggestedhospital=$hosp->num_rows();
		if($countguggestedclinic + $countguggestedhospital){
			return array('C'=>$suggestedclinic,'H'=>$suggestedhospital);
		}else{
			//insert or update on hinnden clinic id value
			//$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
			
			//$udata=array('name'=>$clinicname,'city'=>$cliniccity,'location'=>$cliniclocality);
			//$this->db->insert('clinic',$udata);
			//$clinicid = $this->db->insert_id();
			//$udata2=array('clinic_id'=>$clinicid,'did'=>$this->did,'status'=>'P','date'=>date('Y-m-d H:i:s'));
			//$this->db->insert('clinic_claimed',$udata2);
			
			//redirect('progress_profile2');
			return array();
		}
		
		
	}
	
	public function linkpractice(){
		$hospclinicid=$this->input->post('hospclinicid');
		$exp=explode('-',$hospclinicid);
		$type=$exp[0];
		$institution_id=$exp[1];
		$result=$this->db->where(array('type'=>$type,'institution_id'=>$institution_id,'user_id'=>$this->did))->get('dr_practice');
		$count=$result->num_rows();
		if($count){
			$practiceid=$result->row()->id;
		}else{
			$udata=array('institution_id'=>$institution_id,'user_id'=>$this->did,'type'=>$type);
			$this->db->insert('dr_practice',$udata);
			$practiceid=$this->db->insert_id();
		}
		//$udata=array('clinic_type'=>$this->input->post('practicetype'));
		//$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
		//if already ret id else add and ret id
		
		redirect('profile_consultant_fee/'.mybase64_encode($practiceid));
		
	}
	
	public function profile_consultant_fee()
	{	//echo "<pre>"; print_r($_POST); die;
		$drid=mybase64_decode($this->uri->segment(3));//check if loged in 
		$fee = $this->input->post('fee');
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
		$max_patient = $this->input->post('max_patient');
		$consultation_fee = $this->input->post('consultation_fee');
		//print_r($max_patient); die;
		$hiddenday = $this->input->post('hiddenday');
		
		$pid=$this->db->where(array('type'=>'H','user_id'=>$drid,'institution_id'=>$this->did))->get('dr_practice')->row()->id;;
		
		$this->db->where(array('type'=>'H','user_id'=>$drid,'institution_id'=>$this->did))->set('fee',$fee)->update('dr_practice');
		//$this->db->query("DELETE `timing`,`timing_session` FROM `timing` INNER JOIN `timing_session`  ON timing_session.timing_id=timing.id WHERE user_id='".$drid."' AND user_type='D' AND institution_id='".$this->did."';");
		if($pid)
		$this->db->query("DELETE `timing`,`timing_session` FROM `timing` INNER JOIN `timing_session`  ON timing_session.timing_id=timing.id WHERE user_id='".$drid."' AND practice_id='".$pid."' ;");
		for($key2=0;$key2<$hiddenday;$key2++){
			$mon[$key2]=(@$mon[$key2])? 1 : 0;
			$tue[$key2]=(@$tue[$key2])? 1 : 0;
			$wed[$key2]=(@$wed[$key2])? 1 : 0;
			$thu[$key2]=(@$thu[$key2])? 1 : 0;
			$fri[$key2]=(@$fri[$key2])? 1 : 0;
			$sat[$key2]=(@$sat[$key2])? 1 : 0;
			$sun[$key2]=(@$sun[$key2])? 1 : 0;
			
			if(!$mon[$key2] && !$tue[$key2] && !$wed[$key2] && !$thu[$key2] && !$fri[$key2] && !$sat[$key2] && !$sun[$key2] )
				continue;
			
			$timingdata=array('practice_id'=>$pid,'user_id'=>$drid,'M'=>$mon[$key2],'T'=>$tue[$key2],	'W'=>$wed[$key2],'TH'=>$thu[$key2],	'F'=>$fri[$key2],	'SA'=>$sat[$key2],	'S'=>$sun[$key2],	'status'=>'1');
			$this->db->insert('timing',$timingdata);
			
			$sessions=$from[$key2];
			$tid= $this->db->insert_id();
			foreach($sessions as $key3=>$value)
			{
				if($from[$key2][$key3]=='' || $from[$key2][$key3]=='')
					continue;
				$sessiondata = array('timing_id'=>$tid,'from_timing'=>$from[$key2][$key3],'to_timing'=>$to[$key2][$key3],'max_patient'=>$max_patient[$key2][$key3],'consultation_fee'=>$consultation_fee[$key2][$key3],'status'=>'1');
				$this->db->insert('timing_session',$sessiondata);
						
			}
				
		}
		
		redirect('hospitalpanel/managedoctor');	
	}
	
	public function profile_step6(){
		//$udata=array('clinic_type'=>$this->input->post('practicetype'));
		//$this->db->where('user_id',$this->did)->update('profile_dr',$udata);
		
		redirect('progress_profile2');
		
	}
	
	
	
	public function updateclinic(){
		$clinicid=$this->uri->segment(2);
		$udata=array('name'=>$this->input->post('clinicname'),'city'=>$this->input->post('cliniccity'),'location'=>$this->input->post('cliniclocality'));
		$this->db->where('id',mybase64_decode($clinicid))->update('clinic',$udata);
		
	
		redirect('profile_clinicproof/'.($clinicid));	
		//redirect('profile_clinic_timing/'.($clinicid));	
	}
	
	function change_password($id)
	{
	  
     $query = $this->db->where(['USERID'=>$id])
                    ->get('hospitallogin');
       
        return $query->row();
   
	    
	}

  public function updatePassword($new_password, $id)
  {
       $data = array(
      'PASSWORD'=> $new_password
      );
      return $this->db->where('USERID', $id)
                      ->update('hospitallogin', $data); 
      
  }
	 public function gallery($image)
	    {
	        $date=date('Y-m-d h:i:s');
	        $long=$this->input->post('long');
			$shot=$this->input->post('shot');
			
			$data=array('shot_description'=>$shot,'long_description'=>$long,'image'=>$image,'date'=>$date,'uid'=>$this->did);
			$qq=$this->db->insert('hospitalgallery',$data);
           return $qq;
           $drid= $this->db->insert_id();
		}

		public function add_news($image)
	    {
	        $date=date('Y-m-d h:i:s');
	        $name=$this->input->post('name');
	        $description=$this->input->post('description');
	        $type=$this->input->post('type');
			$video_url=$this->input->post('video_url');
			
			$data=array('title'=>$name,'description'=>$description,'type'=>$type,'video_url'=>$video_url,'creat_date'=>$date,'image'=>$image,'hospital_id'=>$this->did);
			$qq=$this->db->insert('news',$data);
           return $qq;
           $drid= $this->db->insert_id();
		}
	
		public function get_hospital_bed($limit='10',$offset='0',$param=array())
		{		
			$this->db->select('SQL_CALC_FOUND_ROWS hospital_bed.*,hospital.name,hospital.address,master_city.name as city_name',FALSE);
			$this->db->limit($limit,$offset);
			$this->db->where('hospital_bed.status','1');
			$this->db->join('hospital','hospital.id=hospital_bed.hospital_id');
			$this->db->join('master_city','master_city.id=hospital.city','left');
			$this->db->group_by('hospital_bed.hospital_bed_id');
			$result = $this->db->get_where('hospital_bed')->result_array();	
			return $result;
		}
   }