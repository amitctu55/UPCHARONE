<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Career extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$date=date('Y-m-d h:i:s');
		$this->load->model(array('careermodel','masters/managementmodel'));
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
	}
	
	public function index()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['career'] 		=  $this->careermodel->get_career($config['limit'],$offset);
		//echo "<pre>"; print_r($data['career']); die;
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Career List';
		$data['module'] 		=  'Career';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		if( $this->input->post('status_action')!='')
		{
			$this->managementmodel->update_status('career','career_id');			
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('career_view',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function delete($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : $this->uri->segment(4));
		if ($del_id) {
			$this->db->where('career_id', $del_id)->delete('career');
			$msg = "Career inquiry deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		}
		redirect(base_url('doctor/career'));
	}

	public function bulk_delete()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $cid) {
				$cid = (int)$cid;
				if ($cid > 0) {
					$this->db->where('career_id', $cid)->delete('career');
					$deleted_count++;
				}
			}
			$msg = "$deleted_count career inquiry(ies) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No career records selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No records selected.</div>");
		}
		redirect(base_url('doctor/career'));
	}

}
