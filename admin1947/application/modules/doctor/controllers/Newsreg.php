<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsreg extends CI_Controller 
{

	function __construct() 
	{
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $date=date('Y-m-d h:i:s');
		 $this->load->model('Newsregmodel');
	}
	 
	public function index()
	{
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('newsreg');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function create()
	{ 
		if(isset($_POST['submit']))
		{
		    $uploadimage='';  
	     	$check = $this->Newsregmodel->news_duplicacy_check();	
			if($check !='OK')
			{
				if($check == 'name')
				$emsg='Name Already Exist';
				$msg="<div class='alert alert-danger'><strong>Failed!</strong> $emsg</div>";
				$this->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'doctor/newsreg');
				exit();
			}

			if($this->input->post('type')==2)
			{
				if($this->Newsregmodel->traineereginsert()) 
				{
					$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
					$this->session->set_flashdata('flashmsg',$msg);
				}
				else
				{
					$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
					$this->session->set_flashdata('flashmsg',$msg);
				}
			}
			else if($this->input->post('type')==1)
			{
				$uploadimage=$_FILES['uploadimage']['name'];
				$extsign = pathinfo($_FILES['uploadimage']['name'],PATHINFO_EXTENSION);
				
				if($uploadimage != '') 
				{	
					$rname 							= rand(1111111,999999999);
					$date 							= date('Y-m-d');
					$uploadimage 					= '_profile_pic_'.$rname.$date.'.'.$extsign;
					$config['upload_path']          = './public/assets/upload/';
					$config['allowed_types'] 		= 'jpg|png|jpeg|JPG|PNG|JPEG';
					$config['max_size']             = 2048;
					$config['quality'] 				= '60%';
					$config['file_name']  			= $uploadimage;
					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('uploadimage'))
					{
						$error = $this->upload->display_errors();
						$flashmsg='<div class="alert alert-danger">
						  <strong>Failed!</strong>'.$error.'
						</div>';
						$this->session->set_flashdata('flashmsg',$flashmsg);
						redirect(base_url().'doctor/newsreg');
						exit();
					}
					else
					{
						if($this->Newsregmodel->traineereginsert($uploadimage)) 
						{
							$msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
							$this->session->set_flashdata('flashmsg',$msg);
						}
						else
						{
							$msg="<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
							$this->session->set_flashdata('flashmsg',$msg);
						}
					}
				}
			}
     	}
		redirect(base_url().'doctor/newsreg');
	}
	 
          
    public function viewnews()
	{ 	
		$data['news']=$this->db->select('hospital.id,hospital.name,profile_dr.id,profile_dr.fname,news.*')->join('hospital','hospital.id=news.hospital_id','left')->join('profile_dr','profile_dr.id=news.doctor_id','left')->get_where('news')->result_array();
		$data['module']='News';
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('newsview',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
		
	}


	public function newsapprove($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('approved')->get_where('news', array('id' => $did))->row();
		$current = $row ? $row->approved : '0';
		if ($current == '1') {
			$this->db->set('approved', '0')->where(array('id' => $did))->update('news');
			$status = '0';
			$msg = 'News approval status updated to Pending.';
		} else {
			$this->db->set('approved', '1')->where(array('id' => $did))->update('news');
			$status = '1';
			$msg = 'News has been Approved successfully.';
		}
		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/newsreg/viewnews'));
	}
	 
	public function newsverify($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('status')->get_where('news', array('id' => $did))->row();
		$current = $row ? $row->status : '0';
		if ($current == '1') {
			$this->db->set('status', '0')->where(array('id' => $did))->update('news');
			$status = '0';
			$msg = 'News status updated to Inactive.';
		} else {
			$this->db->set('status', '1')->where(array('id' => $did))->update('news');
			$status = '1';
			$msg = 'News has been Activated successfully.';
		}
		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/newsreg/viewnews'));
	}

	public function deletenews($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_news();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : $this->uri->segment(4));
		if ($del_id) {
			$this->load->model('newsregmodel');
			$this->newsregmodel->newsdelete($del_id);
			$msg = "News article deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/newsreg/viewnews'));
	}

	public function bulk_delete_news()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$this->load->model('newsregmodel');
			$deleted_count = 0;
			foreach ($ids as $nid) {
				$nid = (int)$nid;
				if ($nid > 0) {
					$this->newsregmodel->newsdelete($nid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count news article(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No articles selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No articles selected.</div>");
		}
		redirect(base_url('doctor/newsreg/viewnews'));
	}
	 
	public function newsview($id)
	{
		$data['news'] = $this->db->get_where('news', array('id' => $id))->row();
		$data['module'] = 'news';
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('previewnews', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer'); 
	}

	public function newsupdate()
	{
		$id=$this->uri->segment(4);
		$data['news']=$this->db->select('hospital.name,profile_dr.fname,news.id,news.title,news.description,news.video_url,news.type,news.image,news.approved,news.creat_date,news.status,news.doctor_id,news.hospital_id')->join('hospital','hospital.id=news.hospital_id','left')->join('profile_dr','profile_dr.id=news.doctor_id','left')->get_where('news',array('news.id'=>$id))->row();
		$data['module']='News';
		if(isset($_POST['submit']))
		{
			if(!empty($_FILES['uploadimage']['name']))
			{    
                $config['upload_path'] 		= './public/assets/upload/';
                $config['allowed_types'] 	= 'jpg|png|jpeg|JPG|PNG|JPEG';
                $config['max_size']         = 2048;
				$config['quality'] 			= '60%';
                $config['file_name'] 		= $_FILES['uploadimage']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('uploadimage'))
                {
                    $uploadData = $this->upload->data();
                    $uploadimage = $uploadData['file_name'];
                }
                else
                {
                    $uploadimage = '';
                }
            }
            else
            {
                $uploadimage = $data['news']->image;
            }  
			$this->load->model('newsregmodel');
			$this->newsregmodel->updatenews($id,$uploadimage);
			$msg="<div class='alert alert-success'><strong>Success!</strong> Data Updated Successfully</div>";
			$this->session->set_flashdata('flashmsg',$msg);	
			redirect('doctor/newsreg/newsupdate/'.$id.'');	
		}			
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('updatenews',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
}