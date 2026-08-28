<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sectionsmodel extends CI_Model 
{
	public function insert()
	{
		$data = array(
			'section_name' => $this->input->post('section'),
			'section_icon' => $this->input->post('section_icon'),
			'show_position'=> '1',
			'isStatus'     => '1',
			'added_date'   => date('Y-m-d H:i:s'),
		);
		$r = $this->db->insert('master_sections', $data);
		return (!$r) ? false : true;
	}
	
	public function edit($id)
	{
		$data = array(
			'section_name' => $this->input->post('section'),
			'section_icon' => $this->input->post('section_icon'),
			'modify_date'  => date('Y-m-d H:i:s'),
		);
		$this->db->where('section_id', $id);
		$r = $this->db->update('master_sections', $data);
		return (!$r) ? false : true;
	}
	
	public function delete($uid)
	{
		$this->db->where('section_id', $uid);
		$r = $this->db->delete('master_sections');
		return (!$r) ? false : true;
	}
	
	public function status($uid)
	{
		$row = $this->db->get_where('master_sections', array('section_id' => $uid))->row();
		if ($row) {
			$newStatus = ($row->isStatus == '1') ? '2' : '1';
			$this->db->where('section_id', $uid);
			$this->db->update('master_sections', array('isStatus' => $newStatus, 'modify_date' => date('Y-m-d H:i:s')));
			return $newStatus;
		}
		return false;
	}
}