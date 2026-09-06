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

	private function _ensure_tables()
	{
		try {
			if ($this->db) {
				if (!$this->db->table_exists('path_lab_test')) {
					$this->db->query("CREATE TABLE IF NOT EXISTS `path_lab_test` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`test_id` int(11) DEFAULT 0,
						`path_lab_id` int(11) DEFAULT 0,
						`lab_price` decimal(10,2) DEFAULT 0.00,
						`comment` text DEFAULT NULL,
						`status` varchar(10) DEFAULT '1',
						`created_date` datetime DEFAULT NULL,
						`updated_date` datetime DEFAULT NULL,
						PRIMARY KEY (`id`),
						KEY `test_id` (`test_id`),
						KEY `path_lab_id` (`path_lab_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
				}
				if (!$this->db->table_exists('pathtest')) {
					$this->db->query("CREATE TABLE IF NOT EXISTS `pathtest` (
						`test_id` int(11) NOT NULL AUTO_INCREMENT,
						`test_name` varchar(255) DEFAULT '',
						`short_name` varchar(100) DEFAULT '',
						`method` varchar(255) DEFAULT '',
						`amount` decimal(10,2) DEFAULT 0.00,
						`status` varchar(10) DEFAULT '1',
						PRIMARY KEY (`test_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
				}
				if (!$this->db->table_exists('pathlab')) {
					$this->db->query("CREATE TABLE IF NOT EXISTS `pathlab` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`name` varchar(255) DEFAULT '',
						`email` varchar(150) DEFAULT '',
						`mobile` varchar(20) DEFAULT '',
						`address` text DEFAULT NULL,
						`city` varchar(100) DEFAULT '',
						`approved` varchar(10) DEFAULT '1',
						`status` varchar(10) DEFAULT '1',
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
				}
			}
		} catch (Throwable $e) {}
	}
	
	public function index()
	{	
		$this->_ensure_tables();
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  function_exists('current_url_query_string') ? current_url_query_string(array('filter'=>'result'),array('per_page')) : current_url();
		$data['result'] 		=  $this->pathology_model->get_assign_test($config['limit'],$offset);
		$config['total_rows']   =  function_exists('get_found_rows') ? get_found_rows() : (is_array($data['result']) ? count($data['result']) : 0);
		$data['heading_title'] 	=  'Path Test List';
		$data['module'] 		=  'Path Test';
		$data['page_links'] 	=  function_exists('admin_pagination') ? admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset) : '';
		if( $this->input->post('status_action')!='')
		{
			try {
				if ($this->db && $this->db->table_exists('path_lab_test')) {
					$this->managementmodel->update_status('path_lab_test','id');			
				}
			} catch (Throwable $e) {}
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/assign_test',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function assign_test()
	{
		$this->index();
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