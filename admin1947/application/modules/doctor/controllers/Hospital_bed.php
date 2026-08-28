<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hospital_bed extends CI_Controller 
{
	function __construct() 
	{	 	
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$date=date('Y-m-d h:i:s');
		$this->load->model(array('hospital_bed_model','masters/managementmodel'));
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
	}
	
	public function index()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ($pagesize > 0) ? $pagesize : 10;	
		$offset                 =  ($this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['result'] 		=  $this->hospital_bed_model->get_hospital_bed($config['limit'],$offset);
		//echo "<pre>"; print_r($data['result']); die;
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Hospital Bed';
		$data['module'] 		=  'Hospital Bed';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		if( $this->input->post('status_action')!='')
		{
			$this->managementmodel->update_status('hospital_bed','hospital_bed_id');			
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('hospital_bed/hospital_bed_list',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function add()
	{	
		$data['heading_title'] 	=  'Hospital Bed Add';
		$data['module'] 		=  'Hospital Bed';
		$this->form_validation->set_rules('hospital_id','Hospital',"trim|numeric|required|max_length[255]|is_unique[hospital_bed.hospital_id='".$this->db->escape_str($this->input->post('hospital_id'))."' AND status!='2']");
		$this->form_validation->set_rules('bed_type', '"Bed Type"','trim|required|max_length[255]');
		$this->form_validation->set_rules('total_bed','Total Bed','trim|max_length[50]');
		$this->form_validation->set_rules('occupied_bed','Occupied Bed','trim|max_length[255]');
		$this->form_validation->set_rules('comment','Comment','trim|max_length[500]');
		if($this->form_validation->run()==TRUE)
		{	
			if($this->hospital_bed_model->hospital_bed_insert()) 
			{
				$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
				$this->session->set_flashdata('flashmsg',$msg);
				redirect('doctor/hospital_bed/','');
			}
			else
			{
				$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
				$this->session->set_flashdata('flashmsg',$msg);
			}
	
		}
		$data['hospital']		= 	$this->hospital_bed_model->hospital_list(array('status'=>'1','verified'=>'1','approved'=>'1'));
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('hospital_bed/hospital_bed_add',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function update()
	{	
		$hospital_bed_id	=	$this->uri->segment(4);
		$row				=	$this->hospital_bed_model->get_hospital_bed(1,0,array('hospital_bed_id'=>$hospital_bed_id));
		if(is_array($row) && !empty($row))
		{
			$this->form_validation->set_rules('hospital_id','Hospital',"trim|numeric|required|max_length[255]|is_unique[hospital_bed.hospital_id='".$this->db->escape_str($this->input->post('hospital_id'))."' AND hospital_bed_id!='".$hospital_bed_id."' AND status!='2']");
			$this->form_validation->set_rules('bed_type', '"Bed Type"','trim|required|max_length[255]');
			$this->form_validation->set_rules('total_bed','Total Bed','trim|max_length[50]');
			$this->form_validation->set_rules('occupied_bed','Occupied Bed','trim|max_length[255]');
			$this->form_validation->set_rules('comment','Comment','trim|max_length[500]');
			if($this->form_validation->run()==TRUE)
			{
				$this->hospital_bed_model->update_package($hospital_bed_id);
				$msg="<div class='alert alert-success'><strong>Success!</strong> Data Updated Successfully</div>";
				$this->session->set_flashdata('flashmsg',$msg);	
				redirect('doctor/hospital_bed/update/'.$hospital_bed_id.'');	
			}	
			$data['module']			=	'Hospital Bed';
			$data['heading_title']	=	'Hospital Bed Update';
			$data['row']			=	$row;
		}
		else
		{
			redirect('users/hospital_bed/','');
		}
		$data['hospital']		= 	$this->hospital_bed_model->hospital_list(array('status'=>'1','verified'=>'1','approved'=>'1'));
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('hospital_bed/hospital_bed_update',$data);
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
			$this->db->where('hospital_bed_id', $del_id)->delete('hospital_bed');
			$msg = "Hospital bed record deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		}
		redirect(base_url('doctor/hospital_bed'));
	}

	public function bulk_delete()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $bid) {
				$bid = (int)$bid;
				if ($bid > 0) {
					$this->db->where('hospital_bed_id', $bid)->delete('hospital_bed');
					$deleted_count++;
				}
			}
			$msg = "$deleted_count hospital bed record(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No bed records selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No records selected.</div>");
		}
		redirect(base_url('doctor/hospital_bed'));
	}

}