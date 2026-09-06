<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pathology_model extends CI_Model
{ 
	public function get_assign_test($limit='10',$offset='0',$param=array())
	{	
		try {
			if (!$this->db || !$this->db->table_exists('path_lab_test')) {
				return array();
			}
			$test_id	= @$param['test_id'];
			$keyword 	= $this->db->escape_str($this->input->get('keyword',TRUE));
		
			if($test_id!='')
			{
				$this->db->where("path_lab_test.test_id",$test_id);
			}
			if($keyword!='')
			{
				if ($this->db->table_exists('pathlab')) {
					$this->db->where("(pathlab.name LIKE '%".$keyword."%' )");
				}
			}
			$this->db->order_by('path_lab_test.id','desc');
			$this->db->limit($limit,$offset);
			$this->db->select('SQL_CALC_FOUND_ROWS path_lab_test.*,pathlab.name,pathtest.test_name',FALSE);

			if ($this->db->table_exists('pathtest')) {
				$this->db->join('pathtest','path_lab_test.test_id=pathtest.test_id','left');
			}
			if ($this->db->table_exists('pathlab')) {
				$this->db->join('pathlab','pathlab.id=path_lab_test.path_lab_id','left');
			}
			$q = $this->db->get('path_lab_test');
			$result = ($q && is_object($q)) ? $q->result_array() : array();
			$result = ($limit=='1') ? @$result[0]: $result;	
			return $result ?: array();
		} catch (Throwable $e) {
			return array();
		}
	}
	
	
	
	public function insert_assign_test($test_id = null, $path_lab_id = null, $lab_price = 0, $comment = '')
	{	
		$tid   = $test_id !== null ? $test_id : $this->input->post('test_id');
		$pid   = $path_lab_id !== null ? $path_lab_id : $this->input->post('path_lab_id');
		$price = $lab_price ? $lab_price : (int)$this->input->post('lab_price');
		$comm  = $comment ? $comment : $this->input->post('comment');
		$stat  = $this->input->post('status') !== null ? $this->input->post('status') : '1';

		$data = array(
			'test_id'      => (int)$tid,
			'path_lab_id'  => (int)$pid,
			'lab_price'    => (int)$price,
			'comment'      => $comm,
			'status'       => $stat,
			'created_date' => date('Y-m-d H:i:s'),
			'updated_date' => date('Y-m-d H:i:s')
		);
		$this->db->insert('path_lab_test', $data);
		return $this->db->insert_id();
	}
	
	function assign_test_delete($id)
	{
		$this->db->query("delete from path_lab_test where id='".$id."'");
	}
	
	public  function get_test($page=array())
	{		
		try {
			if ($this->db && $this->db->table_exists('pathtest')) {
				$this->db->select('test_id,test_name');
				if( is_array($page) && !empty($page) ) {
					$q = $this->db->get_where('pathtest',$page);
				} else {
					$q = $this->db->get('pathtest');
				}
				if ($q && is_object($q)) {
					$result = $q->result_array();
					if( is_array($result) && !empty($result) ) {
						return $result;
					}
				}
			}
		} catch (Throwable $e) {}
		return array();
	}
	
	public  function get_pathlab($page=array())
	{		
		try {
			if ($this->db && $this->db->table_exists('pathlab')) {
				$this->db->select('id,name');
				if( is_array($page) && !empty($page) ) {
					$q = $this->db->get_where('pathlab',$page);
				} else {
					$q = $this->db->get('pathlab');
				}
				if ($q && is_object($q)) {
					$result = $q->result_array();
					if( is_array($result) && !empty($result) ) {
						return $result;
					}
				}
			}
		} catch (Throwable $e) {}
		return array();
	}
	
	public function test_insert()
	{
		$data	=	array(
						'category_id'		=>$this->input->post('category_id'),
						'path_id'			=>$this->input->post('path_id'),
						'test_name'			=>$this->input->post('test_name'),
						'short_name'		=>$this->input->post('short_name'),
						'test_type'			=>$this->input->post('test_type'),
						'sub_category'		=>$this->input->post('sub_category'),
						'method'			=>$this->input->post('method'),
						'report_day'		=>$this->input->post('report_day'),
						'charge_category'	=>$this->input->post('charge_category'),
						'code'				=>$this->input->post('code'),
						'amount'			=>$this->input->post('amount'),
						'status'			=>$this->input->post('status'),
						'approved'			=>$this->input->post('approved'),
						'creat_date'		=>date('Y-m-d h:i:s'),
						);
		$this->db->insert('pathtest',$data);
		$test_id = $this->db->insert_id();
		return $test_id;
	}
	
	public function update($test_id)
	{	
		$data	=array(
						'category_id'		=>$this->input->post('category_id'),
						'path_id'			=>$this->input->post('path_id'),
						'test_name'			=>$this->input->post('test_name'),
						'short_name'		=>$this->input->post('short_name'),
						'test_type'			=>$this->input->post('test_type'),
						'sub_category'		=>$this->input->post('sub_category'),
						'method'			=>$this->input->post('method'),
						'report_day'		=>$this->input->post('report_day'),
						'charge_category'	=>$this->input->post('charge_category'),
						'code'				=>$this->input->post('code'),
						'amount'			=>$this->input->post('amount'),
						'status'			=>$this->input->post('status'),
						'approved'			=>$this->input->post('approved'),
						'creat_date'		=>date('Y-m-d h:i:s'),
					);
		$this->db->where('test_id',$test_id);
		$this->db->update('pathtest',$data);
		return $test_id;
	}
	
	public  function get_unit_all($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{
			$this->db->select('unit_id,unit_name');
			$result =  $this->db->get_where('path_unit',$page)->result_array();
			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public function get_path_parameter($limit='10',$offset='0',$param=array())
	{		
		$parameter_id			=   @$param['parameter_id'];
		
		$keyword 		= $this->db->escape_str($this->input->get_post('keyword',TRUE));
		if($parameter_id!='')
		{	
			$this->db->where("path_parameter.parameter_id",$parameter_id);
		}
		if($keyword!='')
		{
			$this->db->where("(parameter_name LIKE '%".$keyword."%' )");
		}
		$this->db->order_by('parameter_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS path_parameter.*,path_unit.unit_name',FALSE);
		$this->db->join('path_unit','path_unit.unit_id=path_parameter.unit_id','left');
		$result = $this->db->get('path_parameter')->result();
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
	}
	
	function parameterrecord($id)
	{
		$this->db->query("delete from path_parameter where parameter_id='".$id."'");
	}
	
	public function parameterinsert()
	{
		$data	=	array(
						'parameter_name'			=>$this->input->post('parameter_name'),
						'reference_range'			=>$this->input->post('reference_range'),
						'unit_id'					=>$this->input->post('unit_id'),
						'description'				=>$this->input->post('description'),
						'creat_date'				=>date('Y-m-d h:i:s'),
						'created_by'				=>getUserId(),
						);
		$this->db->insert('path_parameter',$data);
		$parameter_id = $this->db->insert_id();
		return $parameter_id;
	}
	public function updateparameter($unit_id)
	{	
		$data	=array(
						'parameter_name'			=>$this->input->post('parameter_name'),
						'reference_range'			=>$this->input->post('reference_range'),
						'unit_id'					=>$this->input->post('unit_id'),
						'description'				=>$this->input->post('description'),
						'status'					=>$this->input->post('status'),
						'creat_date'				=>date('Y-m-d h:i:s'),
						'created_by'				=>getUserId(),
					);
		$this->db->where('parameter_id',$parameter_id);
		$this->db->update('path_parameter',$data);
		return $parameter_id;
	}
	
}