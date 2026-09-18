<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Degreemodel extends CI_Model{
	
	
	
	public function insert()
	{
		$date=date('Y-m-d h:i:s');
		$eduname=$this->input->post('degree');
		$data=array('name'=>$eduname);
		$r=$this->db->insert('master_degree',$data);
		return (!$r) ? false : true;
	}
	
	public function edit($id)
	{
		$eduname=$this->input->post('degree');
		$data=array('name'=>$eduname);
		$this->db->where('id',$id);
		$r=$this->db->update('master_degree',$data);
		return (!$r) ? false : true;
	}
	
	public function delete($uid)
	{
		$this->db->where('id',$uid);
		$r=$this->db->delete('master_degree');
		return (!$r) ? false : true;
	}
	
	public function status($uid)
	{
		$status=$this->db->get_where('master_degree',array('id'=>$uid))->row('status');
		if($status==1)
		{
			$data=array('status'=>0);
			$this->db->where('id',$uid);
			$this->db->update('master_degree',$data);
			echo "Hide";
		}
		else{
			$data=array('status'=>1);
			$this->db->where('id',$uid);
			$this->db->update('master_degree',$data);
			echo "Show";
		}
		
	}
	
	public function get_degree($limit='10',$offset='0')
	{	
		$keyword 	= $this->db->escape_str(trim($this->input->get('keyword',TRUE)));
		$status 	= $this->input->get('status',TRUE);
		
		if($keyword!='')
		{
			$this->db->where("(master_degree.name LIKE '%".$keyword."%' )");
		}
		if($status !== NULL && $status !== '')
		{
			$this->db->where("master_degree.status", $status);
		}
		$this->db->order_by('master_degree.id','asc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS *',FALSE);
		$result = $this->db->get('master_degree')->result_array();
		if (!is_array($result)) {
			return [];
		}
		$result = ($limit=='1') ? @$result[0]: $result;	
		return is_array($result) ? $result : [];
	}

}