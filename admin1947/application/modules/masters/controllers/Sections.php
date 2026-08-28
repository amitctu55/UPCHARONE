<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sections extends CI_Controller  
{
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
		$this->load->model('sectionsmodel');
		if(!$this->session->userdata('userid') && !$this->session->userdata('username'))
		{
			redirect(base_url().'login');
		}
	}

	public function index()
	{
		$this->db->order_by('section_id', 'asc');
		$data['sections'] = $this->db->get('master_sections')->result_array();
		$data['heading_title'] = 'Master Sections';
		$data['module'] = 'Masters';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('sections', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function create()
	{
		if(isset($_POST['submit']) || $this->input->post('section') != ''){
			$id = base64_decode($this->input->post('eid'));
			$section_name = trim($this->input->post('section'));

			if(empty($id))
			{
				$count = $this->db->where('section_name', $section_name)->count_all_results('master_sections');
				if($count > 0)
				{
					$msg = "<div class='alert alert-danger'><strong>Failed!</strong> This section name already exists.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
					redirect(base_url().'masters/sections');
					exit();
				}
				if($this->sectionsmodel->insert())
				{
					$msg = "<div class='alert alert-success'><strong>Success!</strong> Section created successfully.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
				}
				else {
					$msg = "<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
				}
			}
			else
			{
				$count = $this->db->where('section_name', $section_name)->where_not_in('section_id', $id)->count_all_results('master_sections');
				if($count > 0)
				{
					$msg = "<div class='alert alert-danger'><strong>Failed!</strong> This section name already exists.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
					redirect(base_url().'masters/sections');
					exit();
				}
				if($this->sectionsmodel->edit($id))
				{
					$msg = "<div class='alert alert-success'><strong>Success!</strong> Section updated successfully.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
				}
				else {
					$msg = "<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
				}
			}
		}
		redirect(base_url().'masters/sections');
	}

	public function statusupdate()
	{
		$uid = $this->input->post('uid');
		$res = $this->sectionsmodel->status($uid);
		if ($this->input->is_ajax_request()) {
			echo json_encode(array('status' => 'success', 'new_status' => $res));
			return;
		}
		echo $res;
	}
	
	public function delete()
	{
		$uid = $this->uri->segment('4');
		if($this->sectionsmodel->delete($uid))
		{
			if ($this->input->is_ajax_request()) {
				echo json_encode(array('status' => 'success'));
				return;
			}
			echo "Y";
		}
	}
}
