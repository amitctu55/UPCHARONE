<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pathlabreg extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$date=date('Y-m-d h:i:s');
		$this->load->model('Pathlabregmodel');
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper','text'));
	}
	 
	public function index()
	{
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathlabreg');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}



	public function create()
	{
		
		if(isset($_POST['submit'])){
			    
			    $uploadimage='';
             
             $check = $this->Pathlabregmodel->pathlab_duplicacy_check();
			if($check !='OK')
			{
				if($check == 'MOBILE')
					$emsg='Mobile Already Exist';
				else if($check == 'EMAIL')
					$emsg='Email Already Exist';
				else if($check == 'BOTH')
					$emsg='Email and Mobile Already Exist';
				
				$msg="<div class='alert alert-danger'><strong>Failed!</strong> $emsg</div>";
				$this->session->set_flashdata('flashmsg',$msg);
				
				redirect(base_url().'doctor/pathlabreg');
				exit();
			}
			else
			{

				$uploadimage=$_FILES['uploadimage']['name'];
				$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
				
				$uploadimage2=$_FILES['idproof']['name'];
				$extsign2 = pathinfo($_FILES['idproof']['name'],PATHINFO_EXTENSION);
				
				$uploadimage3=$_FILES['regproof']['name'];
				$extsign3 = pathinfo($_FILES['regproof']['name'],PATHINFO_EXTENSION);
				
				if($uploadimage != '') 
				{	
					$rname=rand(1111111,999999999);
					$date=date('Y-m-d');
					$uploadimage=$typename.'_profile_pic_'.$rname.$date.'.'.$extsign;
					$rname=rand(1111111,999999999);
					$uploadimage2=$typename.'_id_proof_'.$rname.$date.'.'.$extsign2;
					$rname=rand(1111111,999999999);
					$uploadimage3=$typename.'_reg_proof_'.$rname.$date.'.'.$extsign3;
					
					$config['upload_path']          = './public/assets/upload/';
					$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
					$config['max_size']             = 2048;
					$config['quality'] = '60%';
					$config['file_name']  = $uploadimage;
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('uploadimage'))
					{
						$error = $this->upload->display_errors();
						$flashmsg='<div class="alert alert-danger">
						  <strong>Failed!</strong>'.$error.'
						</div>';
						$this->session->set_flashdata('flashmsg',$flashmsg);
						redirect(base_url().'doctor/pathlabreg');
						exit();
						
					}
					else{
						
					$config['file_name']  = $uploadimage2;
					$this->load->library('upload', $config);
					$this->upload->do_upload('idproof');
					
					$config['file_name']  = $uploadimage3;
					$this->load->library('upload', $config);
					$this->upload->do_upload('regproof');
					
						
						if($this->Pathlabregmodel->traineereginsert($uploadimage,$uploadimage2,$uploadimage3)) 
						{
							$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
							$this->session->set_flashdata('flashmsg',$msg);
							
						
						}
						else{
							$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
							$this->session->set_flashdata('flashmsg',$msg);
						}
						
						
						}
					
				}
				
			
		}
	
     }
		redirect(base_url().'doctor/pathlabreg');
	
	}
	
          
	public function viewpathology()
	{
		$keyword       = $this->db->escape_str($this->input->get('keyword', TRUE));
		$status_filter = $this->db->escape_str($this->input->get('status_filter', TRUE));

		if ($keyword != '') {
			$this->db->where("(pathlab.name LIKE '%".$keyword."%' OR pathlab.email LIKE '%".$keyword."%' OR pathlab.mobile LIKE '%".$keyword."%')");
		}
		if ($status_filter == 'approved' || $status_filter == 'registered') {
			$this->db->where('pathlab.approved', '1');
			$this->db->where('pathlab.verified', '1');
		} elseif ($status_filter == 'pending' || $status_filter == 'pending_verification') {
			$this->db->where("(pathlab.approved = '0' OR pathlab.verified = '0')");
		} elseif ($status_filter == 'verified') {
			$this->db->where('pathlab.verified', '1');
		} elseif ($status_filter == 'unverified') {
			$this->db->where('pathlab.verified', '0');
		} elseif ($status_filter == 'pending_approval') {
			$this->db->where('pathlab.approved', '0');
		}
		$this->db->where('pathlab.status !=', '2');
		$this->db->order_by('pathlab.id', 'desc');
		$data['pathlab'] = $this->db->get('pathlab')->result();
		$data['module']  = 'pathlab';

		$data['approved_count'] = $this->db->where('approved', '1')->where('verified', '1')->where('status !=', '2')->count_all_results('pathlab');
		$data['pending_count']  = $this->db->group_start()->where('approved', '0')->or_where('verified', '0')->group_end()->where('status !=', '2')->count_all_results('pathlab');
		$data['total_count']    = $this->db->where('status !=', '2')->count_all_results('pathlab');

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathlabview', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}


	public function pathlabapprove($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('approved')->get_where('pathlab', array('id' => $did))->row();
		$current = $row ? $row->approved : '0';
		if ($current == '1') {
			$this->db->set('approved', '0')->where(array('id' => $did))->update('pathlab');
			$status = '0';
			$msg = 'Pathology Lab approval status updated to Pending.';
		} else {
			$this->db->set('approved', '1')->where(array('id' => $did))->update('pathlab');
			$status = '1';
			$msg = 'Pathology Lab has been Approved successfully.';
		}
		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/pathlabreg/viewpathology'));
	}
	 
	public function pathlabverify($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('verified')->get_where('pathlab', array('id' => $did))->row();
		$current = $row ? $row->verified : '0';
		if ($current == '1') {
			$this->db->set('verified', '0')->where(array('id' => $did))->update('pathlab');
			$status = '0';
			$msg = 'Pathology Lab verification status updated to Unverified.';
		} else {
			$this->db->set('verified', '1')->where(array('id' => $did))->update('pathlab');
			$status = '1';
			$msg = 'Pathology Lab has been Verified successfully.';
		}
		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/pathlabreg/viewpathology'));
	}
	 
	
	
	 public function pathlabview($id)
	 {
		$pathlab = $this->db->get_where('pathlab', array('id' => $id))->row();
		if (!$pathlab) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Pathology Lab not found!</div>");
			redirect(base_url('doctor/pathlabreg/viewpathology'));
			return;
		}

		$data['pathlab'] = $pathlab;
		$data['module']  = 'pathlab';
		$data['tests']   = $this->db->get_where('path_lab_test', array('path_lab_id' => $id))->result();

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathlabview_profile', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}


  public function pathlabupdate($id)
	      {

		$data['pathlab']=$this->db->get_where('pathlab',array('id'=>$id))->row();
		$data['module']='pathlab';
	


		if (isset($_POST['submit'])) {
			$this->load->model('pathlabregmodel');
			$this->pathlabregmodel->updatepathlab($id);

			$msg = "<div class='alert alert-success'><strong>Success!</strong> Pathology Lab Updated Successfully</div>";
			$this->session->set_flashdata('flashmsg', $msg);
			redirect(base_url('doctor/pathlabreg/viewpathology'));
		}


         // print_r($data);

 
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('updatepathlab',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	
      
	}

	public function deletepathlab($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_pathlab();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4)));
		if ($del_id) {
			$this->Pathlabregmodel->deletepathlab($del_id);
			$msg = "Pathology Lab record deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/pathlabreg/viewpathology'));
	}

	public function bulk_delete_pathlab()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $lid) {
				$lid = (int)$lid;
				if ($lid > 0) {
					$this->Pathlabregmodel->deletepathlab($lid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count pathology lab record(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No pathlabs selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No labs selected.</div>");
		}
		redirect(base_url('doctor/pathlabreg/viewpathology'));
	}

}