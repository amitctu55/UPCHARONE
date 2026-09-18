<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Locationmodel extends CI_Model
{
    public function insert()
	{
		$date=date('Y-m-d');
		$city=$this->input->post('city');
		$location=$this->input->post('location');
		$data=array('name'=>$location,'city_id'=>$city,'status'=>'1','date'=>$date);
		$r=$this->db->insert('master_locality',$data);
		return (!$r) ? false : true;
	}
    
	public function edit($id)
	{
		$city=$this->input->post('city');
		$location=$this->input->post('location');
		$this->db->where('id',$id);
		$data=array('name'=>$location,'city_id'=>$city);
		$r=$this->db->update('master_locality',$data);
		return (!$r) ? false : true;
	}
	
	public function delete($uid)
	{
		$this->db->where('id',$uid);
		$r=$this->db->delete('master_locality');
		return (!$r) ? false : true;
	}
	
	public function status($uid)
	{
		$status=$this->db->get_where('master_locality',array('id'=>$uid))->row('status');
		if($status==1)
		{
			$data=array('status'=>0);
			$this->db->where('id',$uid);
			$this->db->update('master_locality',$data);
			echo "Hide";
		}
		else
		{
			$data=array('status'=>1);
			$this->db->where('id',$uid);
			$this->db->update('master_locality',$data);
			echo "Show";
		}
	}
	
	public function get_location($limit='10',$offset='0')
	{	
		$keyword 	= $this->db->escape_str(trim($this->input->get('keyword',TRUE)));
		$city_id 	= $this->db->escape_str(trim($this->input->get('city_id',TRUE)));
		if ($city_id == '') {
			$city_id = $this->db->escape_str(trim($this->input->get('city_name',TRUE)));
		}
		$status 	= $this->input->get('status',TRUE);

		if($keyword!='')
		{
			$this->db->where("(master_locality.name LIKE '%".$keyword."%' OR master_city.name LIKE '%".$keyword."%')");
		}
		if($city_id!='')
		{
			if(is_numeric($city_id)) {
				$this->db->where("master_locality.city_id", $city_id);
			} else {
				$this->db->where("(master_city.name LIKE '%".$city_id."%')");
			}
		}
		if($status !== NULL && $status !== '')
		{
			$this->db->where("master_locality.status", $status);
		}
		$this->db->order_by("master_locality.id","asc");
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS master_locality.*,master_city.name as city_name',FALSE);
		$this->db->join('master_city','master_city.id = master_locality.city_id','left');
		$result = $this->db->get('master_locality')->result_array();
		if (!is_array($result)) {
			return [];
		}
		$result = ($limit=='1') ? @$result[0]: $result;	
		return is_array($result) ? $result : [];
	}
}