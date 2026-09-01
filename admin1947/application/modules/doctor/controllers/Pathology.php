<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Pathology extends CI_Controller 
{
	function __construct()
	{
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $date=date('Y-m-d h:i:s');
		 $this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
		 $this->load->model(array('doctor/pathology_model','masters/managementmodel'));
	}
	
	public function index()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['result'] 		=  $this->pathology_model->get_assign_test($config['limit'],$offset);
		//echo "<pre>"; print_r($data['result']); die;
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Path Test List';
		$data['module'] 		=  'Path Test';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		if( $this->input->post('status_action')!='')
		{
			$this->managementmodel->update_status('path_lab_test','id');			
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/assign_test',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function add()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('path_lab_id', 'Pathology Center', 'trim|required|numeric');
		$this->form_validation->set_rules('test_id', 'Diagnostic Test', 'trim|required|numeric');

		if ($this->input->post('submit') && $this->form_validation->run() == TRUE)
		{
			$path_lab_id = (int)$this->input->post('path_lab_id');
			$test_id     = (int)$this->input->post('test_id');

			// Check for duplicate assignment
			$existing = $this->db->get_where('path_lab_test', array(
				'path_lab_id' => $path_lab_id,
				'test_id'     => $test_id
			))->row();

			if ($existing)
			{
				$this->session->set_flashdata('flashmsg', '<div class="alert alert-warning"><strong>Notice:</strong> This diagnostic test is already assigned to the selected pathology laboratory.</div>');
			}
			else
			{
				$inserted_id = $this->pathology_model->insert_assign_test();
				if ($inserted_id) 
				{
					$msg = "<div class='alert alert-success'><strong>Success!</strong> Test assigned to laboratory successfully.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
					redirect(base_url() . 'doctor/pathology/index');
					return;
				}
				else
				{
					$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger"><strong>Error:</strong> Failed to assign test. Please try again.</div>');
				}
			}
		}

		$data['heading_title'] 	= 'Assign Test to Lab';
		$data['module'] 		= 'Pathology Test Assignment';
		$data['test']			= $this->pathology_model->get_test(array('status'=>'1'));
		$data['pathlab']		= $this->pathology_model->get_pathlab(array('approved'=>'1'));
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/assign_test_add', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function assign_test_delete($id = null)
    {
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4)));
		if ($del_id) {
			$this->pathology_model->assign_test_delete($del_id);
			$msg = "Assigned test deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		}
		redirect(base_url('doctor/pathology/index'));
    }

	public function bulk_delete()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $aid) {
				$aid = (int)$aid;
				if ($aid > 0) {
					$this->pathology_model->assign_test_delete($aid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count assigned test(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No tests selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No tests selected.</div>");
		}
		redirect(base_url('doctor/pathology/index'));
	}
}