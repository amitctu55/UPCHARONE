<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deletedoc extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model(array('doctorregmodel', 'doctorviewmodel'));
		$this->load->helper(array('query_string_helper', 'dbquery_helper', 'admin_helper'));
	}

	public function index($id = null)
	{
		$doc_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->post('did') ? $this->input->post('did') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4))));

		if (!$doc_id && $this->uri->segment(3) && is_numeric($this->uri->segment(3))) {
			$doc_id = $this->uri->segment(3);
		}

		if ($doc_id) {
			$this->doctorregmodel->deletedoctor($doc_id);
			$msg = "Doctor record has been deleted successfully.";

			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'Invalid or missing Doctor ID.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'><strong>Error!</strong> Invalid or missing Doctor ID.</div>");
		}

		redirect(base_url('doctor/doctorview'));
	}

	public function deletedoctor($id = null)
	{
		$this->index($id);
	}

	public function doctordelete($id = null)
	{
		$this->index($id);
	}

	public function delete($id = null)
	{
		$this->index($id);
	}
}
