<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library(array('Form_validation'));		
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
		$this->load->model(array('Userlogin_Model','Hospital_Model','Doctor_Model'));
	}

	public function index($id = null)
	{
		$id = $id ?: ($this->uri->segment(2) ?: $this->uri->segment(3));
		if ($id && is_numeric($id)) {
			$this->_show_doctor($id, false);
		} else {
			redirect('doctors');
		}
	}

	public function book($id = null)
	{
		$id = $id ?: ($this->uri->segment(3) ?: $this->uri->segment(2));
		$this->_show_doctor($id, true);
	}

	public function _remap($method, $params = array())
	{
		if ($method === 'book') {
			return call_user_func_array(array($this, 'book'), $params);
		}

		if (is_numeric($method)) {
			return $this->_show_doctor($method, false);
		}

		if (method_exists($this, $method)) {
			return call_user_func_array(array($this, $method), $params);
		}

		$id = $this->uri->segment(2);
		if (is_numeric($id)) {
			return $this->_show_doctor($id, false);
		}

		redirect('doctors');
	}

	private function _show_doctor($id, $auto_book = false)
	{
		$data['specialization'] = $this->db->order_by('name','asc')->where('status','1')->get('master_specialization')->result();
		$data['cities']         = $this->db->order_by('name','asc')->where('status','1')->get('master_city')->result();
		$data['d']              = $this->db->get_where('profile_dr', array('id' => $id))->row();

		if (empty($data['d'])) {
			$data['d'] = $this->db->limit(1)->get_where('profile_dr', array('approved' => '1', 'verified' => '1'))->row();
		}

		if (empty($data['d'])) {
			redirect('doctors');
			return;
		}

		$data['practs'] = $this->db->where('user_id', $data['d']->id)->where('status', '1')->get('dr_practice')->result();

		if ($auto_book) {
			$data['auto_book'] = true;
			$data['consult_type'] = $this->input->get('type');
		}

		$this->load->view('detail_page', $data);
	}
}

