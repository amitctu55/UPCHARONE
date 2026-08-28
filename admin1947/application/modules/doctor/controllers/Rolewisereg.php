<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rolewisereg extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$date=date('Y-m-d h:i:s');
		$this->load->model('Rolewiseregmodel'); 
	}
	 
	public function index()
	{ 
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('rolewisereg');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}



	public function create()
	{
		
		if(isset($_POST['submit']))
		{
			if($this->Rolewiseregmodel->traineereginsert()) 
			{
				$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
				$this->session->set_flashdata('flashmsg',$msg);
				
			
			}
			else{
				$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
				$this->session->set_flashdata('flashmsg',$msg);
			}
     }
		redirect(base_url().'doctor/rolewisereg');
	
	}
	
          
	public function viewrolewise()
	{
		$data['rolewise']=$this->db->get_where('rolewise')->result_array();
		$data['module']='rolewise';
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('rolewiseview',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}


	public function rolewiseapprove()
	{
		$did = $this->input->post('did');
		$row = $this->db->select('isStatus')->get_where('rolewise', array('level_id' => $did))->row();
		$current = $row ? $row->isStatus : '2';
		if ($current == '1') {
			$this->db->set('isStatus', '2')->where(array('level_id' => $did))->update('rolewise');
			$response = array('status' => '0');
		} else {
			$this->db->set('isStatus', '1')->where(array('level_id' => $did))->update('rolewise');
			$response = array('status' => '1');
		}
		echo json_encode($response);
	}
	 
	public function rolewiseverify()
	{
		$did = $this->input->post('did');
		$row = $this->db->select('isStatus')->get_where('rolewise', array('level_id' => $did))->row();
		$current = $row ? $row->isStatus : '2';
		if ($current == '1') {
			$this->db->set('isStatus', '2')->where(array('level_id' => $did))->update('rolewise');
			$response = array('status' => '0');
		} else {
			$this->db->set('isStatus', '1')->where(array('level_id' => $did))->update('rolewise');
			$response = array('status' => '1');
		}
		echo json_encode($response);
	}
	 
	
	
	public function rolewiseview($id)
	{
		redirect(base_url('doctor/rolewisereg/rolewiseupdate/'.$id));
	}


  	public function rolewiseupdate($id)
      	{

			$data['rolewise']=$this->db->get_where('rolewise',array('level_id'=>$id))->row();
			$data['module']='rolewise';

          	if (isset($_POST['submit'])) {
	         	$this->load->model('rolewiseregmodel');
                $this->rolewiseregmodel->updaterolewise($id);
         
				$msg="<div class='alert alert-success'><strong>Success!</strong> Role Updated Successfully</div>";
				$this->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'doctor/rolewisereg/viewrolewise');
	     	}


		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('updaterolewise',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer'); 
	}

	public function deleterole($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_role();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : $this->uri->segment(4));
		if ($del_id) {
			$this->load->model('rolewiseregmodel');
			$this->rolewiseregmodel->roledelete($del_id);
			$msg = "Staff role deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/rolewisereg/viewrolewise'));
	}

	public function bulk_delete_role()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$this->load->model('rolewiseregmodel');
			$deleted_count = 0;
			foreach ($ids as $rid) {
				$rid = (int)$rid;
				if ($rid > 0) {
					$this->rolewiseregmodel->roledelete($rid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count role(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No roles selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No roles selected.</div>");
		}
		redirect(base_url('doctor/rolewisereg/viewrolewise'));
	}

}