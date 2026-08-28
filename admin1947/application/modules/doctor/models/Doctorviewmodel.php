<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Doctorviewmodel extends CI_Model
{
	public function updatedoctor($id)
	{
	   $date=date('Y-m-d h:i:s');
		
		$city=$this->input->post('city');
		$fname=$this->input->post('t_fname');
		$lname=$this->input->post('t_lname');
		$gender=$this->input->post('gender');
		$regno=$this->input->post('regno');
		$council=$this->input->post('council');
		$year=$this->input->post('year');
		$exp=$this->input->post('exprience');
		$achievement=$this->input->post('achievement');
		$about=$this->input->post('about');
		$package=$this->input->post('package');
		
		$email=$this->input->post('email');
		$mobile=$this->input->post('mobile');
		$status=$this->input->post('status');
	
	
			
		$data=array('fname'=>$fname,'lname'=>$lname,'gender'=>$gender,'city'=>$city,'regd_no'=>$regno,'regd_council'=>$council,'regd_year'=>$year,'exp'=>$exp,'achievement'=>$achievement,'mobile'=>$mobile,'email'=>$email,'about'=>$about,'subscription'=>$package,'approved'=>'1','verified'=>'1','status'=>$status,'creat_date'=>$date,'created_by'=>getUserId(),'source'=>'A');
		$this->db->where('id');
		$this->db->update('profile_dr',$data);
	}
				
	public function get_doctor($limit='10',$offset='0',$param=array())
	{	
		$id				= @$param['id'];
		$keyword 		= $this->db->escape_str($this->input->get('keyword',TRUE));
		$mobile 		= $this->db->escape_str($this->input->get('mobile',TRUE));
		$city_name 		= $this->db->escape_str($this->input->get('city_name',TRUE));
		$status_filter 	= $this->db->escape_str($this->input->get('status_filter',TRUE));
	
		if($id!='')
		{
			$this->db->where("profile_dr.id",$id);
		}
		
		if($keyword!='')
		{
			$this->db->where("(profile_dr.fname LIKE '%".$keyword."%' OR profile_dr.lname LIKE '%".$keyword."%' OR profile_dr.email LIKE '%".$keyword."%')");
		}
		if($mobile!='')
		{
			$this->db->where("profile_dr.mobile",$mobile);
		}
		if($city_name!='')
		{
			$this->db->where("profile_dr.city",$city_name);
		}
		if($status_filter == 'approved' || $status_filter == 'registered')
		{
			$this->db->where("profile_dr.approved", "1");
			$this->db->where("profile_dr.verified", "1");
		}
		elseif($status_filter == 'pending' || $status_filter == 'pending_verification')
		{
			$this->db->where("(profile_dr.approved = '0' OR profile_dr.verified = '0')");
		}
		elseif($status_filter == 'verified')
		{
			$this->db->where("profile_dr.verified", "1");
		}
		elseif($status_filter == 'unverified')
		{
			$this->db->where("profile_dr.verified", "0");
		}
		elseif($status_filter == 'pending_approval')
		{
			$this->db->where("profile_dr.approved", "0");
		}
		$this->db->order_by('profile_dr.id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS profile_dr.*',FALSE);
		$result = $this->db->get('profile_dr')->result_array();
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
	}
	
	public function get_doctor_list($param=array())
	{	
		$id				= @$param['id'];
		$keyword 		= $this->db->escape_str($this->input->get('keyword',TRUE));
		$mobile 		= $this->db->escape_str($this->input->get('mobile',TRUE));
		$city_name 		= $this->db->escape_str($this->input->get('city_name',TRUE));
		$status_filter 	= $this->db->escape_str($this->input->get('status_filter',TRUE));
	
		if($id!='')
		{
			$this->db->where("profile_dr.id",$id);
		}
		
		if($keyword!='')
		{
			$this->db->where("(profile_dr.fname LIKE '%".$keyword."%' OR profile_dr.lname LIKE '%".$keyword."%' OR profile_dr.email LIKE '%".$keyword."%')");
		}
		if($mobile!='')
		{
			$this->db->where("profile_dr.mobile",$mobile);
		}
		if($city_name!='')
		{
			$this->db->where("profile_dr.city",$city_name);
		}
		if($status_filter == 'approved' || $status_filter == 'registered')
		{
			$this->db->where("profile_dr.approved", "1");
			$this->db->where("profile_dr.verified", "1");
		}
		elseif($status_filter == 'pending' || $status_filter == 'pending_verification')
		{
			$this->db->where("(profile_dr.approved = '0' OR profile_dr.verified = '0')");
		}
		elseif($status_filter == 'verified')
		{
			$this->db->where("profile_dr.verified", "1");
		}
		elseif($status_filter == 'unverified')
		{
			$this->db->where("profile_dr.verified", "0");
		}
		elseif($status_filter == 'pending_approval')
		{
			$this->db->where("profile_dr.approved", "0");
		}
		$this->db->order_by('profile_dr.id','desc');
		$this->db->select('SQL_CALC_FOUND_ROWS profile_dr.*',FALSE);
		$result = $this->db->get('profile_dr')->result_array();
		return $result;
	}

    public function deletedoctor($id)
	{
		$this->load->model('doctorregmodel');
		return $this->doctorregmodel->deletedoctor($id);
	}
}