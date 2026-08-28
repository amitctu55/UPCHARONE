<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Doctorview extends CI_Controller 
{

	function __construct() 
	{
		parent::__construct(); 
		$this->load->model(array('doctorviewmodel','appointmentmodel'));
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
	}
	 
	public function index()
	{
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['approved_count'] = $this->db->where('approved', '1')->where('verified', '1')->count_all_results('profile_dr');
		$data['pending_count']  = $this->db->group_start()->where('approved', '0')->or_where('verified', '0')->group_end()->count_all_results('profile_dr');
		$data['total_count']    = $this->db->count_all_results('profile_dr');
		$data['doctor'] 		=  $this->doctorviewmodel->get_doctor($config['limit'],$offset);
		//echo "<pre>"; print_r($data['doctor']); die;
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Doctor List';
		$data['module'] 		=  'Doctor';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		if( $this->input->post('status_action')!='')
		{
			$this->managementmodel->update_status('profile_dr','id');			
		}
		$data['city']  			=  $this->appointmentmodel->get_city(array('status'=>'1'));
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('doctorview',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	
	}
	
	public function createExcel() 
	{
		$fileName = 'doctor.xlsx';  
		$doctorData = $this->doctorviewmodel->get_doctor_list();
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Doctor ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'City');
        $sheet->setCellValue('D1', 'Email');
		$sheet->setCellValue('E1', 'Mobile');
        $sheet->setCellValue('F1', 'Reg. Date');       
        $rows = 2;
        foreach ($doctorData as $val){
            $sheet->setCellValue('A' . $rows, $val['id']);
            $sheet->setCellValue('B' . $rows, $val['fname']);
            $sheet->setCellValue('C' . $rows, getCityName($val['city']));
            $sheet->setCellValue('D' . $rows, $val['email']);
			$sheet->setCellValue('E' . $rows, $val['mobile']);
            $sheet->setCellValue('F' . $rows, $val['creat_date']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
		$writer->save("public/assets/export/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."public/assets/export/".$fileName);              
    }    
	
	public function approve($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($this->input->post('id') ? $this->input->post('id') : ($id ? $id : $this->uri->segment(4)));
		$row = $this->db->select('approved, user_id')->get_where('profile_dr', array('id' => $did))->row();
		$current = $row ? $row->approved : '0';
		if ($current == '1') {
			$this->db->set('approved', '0')->where(array('id' => $did))->update('profile_dr');
			if ($row && !empty($row->user_id)) {
				$this->db->set('APPROVED', '0')->where(array('USERID' => $row->user_id))->update('doctorlogin');
			}
			$status = '0';
			$msg = 'Doctor approval status updated to Pending.';
		} else {
			$this->db->set('approved', '1')->where(array('id' => $did))->update('profile_dr');
			if ($row && !empty($row->user_id)) {
				$this->db->set('APPROVED', '1')->where(array('USERID' => $row->user_id))->update('doctorlogin');
			}
			$status = '1';
			$msg = 'Doctor has been Approved successfully.';
		}

		if ($this->input->is_ajax_request() || $this->input->post('did') || $this->input->post('id')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/doctorview'));
	}

	public function change_approval($id = null)
	{
		$this->approve($id);
	}
	 
	public function verify($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($this->input->post('id') ? $this->input->post('id') : ($id ? $id : $this->uri->segment(4)));
		$row = $this->db->select('verified, user_id')->get_where('profile_dr', array('id' => $did))->row();
		$current = $row ? $row->verified : '0';
		if ($current == '1') {
			$this->db->set('verified', '0')->where(array('id' => $did))->update('profile_dr');
			$status = '0';
			$msg = 'Doctor verification status updated to Unverified.';
		} else {
			$this->db->set('verified', '1')->where(array('id' => $did))->update('profile_dr');
			$status = '1';
			$msg = 'Doctor has been Verified successfully.';
		}

		if ($this->input->is_ajax_request() || $this->input->post('did') || $this->input->post('id')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/doctorview'));
	}

	public function toggle_verification($id = null)
	{
		$this->verify($id);
	}

	public function view($id = null)
	{
		$doc_id = $id ? $id : $this->uri->segment(4);
		$this->viewdoctor($doc_id);
	}

	public function edit($id = null)
	{
		$doc_id = $id ? $id : $this->uri->segment(4);
		$this->updatedoctor($doc_id);
	}
	
	 
    public function viewdoctor($id = null)
    {
    	$doc_id = $id ? $id : $this->uri->segment(4);
    	$data['profile_dr'] = $this->db->get_where('profile_dr', array('id' => $doc_id))->row();
		$data['module'] = 'profile_dr';
		$data_spl = $this->db->select('specialization_id')->get_where('dr_specialization', array('user_id' => $doc_id))->result_array();
		$data['data_spl'] = array_map(function($value){
			return $value['specialization_id'];
		}, $data_spl);		
		
		$data_qual = $this->db->select('qualification_id')->get_where('dr_qualifications', array('user_id' => $doc_id))->result_array();
		$data['data_qual'] = array_map(function($value){
			return $value['qualification_id'];
		}, $data_qual);

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('viewprofile', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
    }

	public function updatedoctor($id = null)
	{ 
		$doc_id = $id ? $id : $this->uri->segment(4);
		$result['profile_dr'] = $this->db->get_where('profile_dr', array('id' => $doc_id))->row();
		$result['module'] = 'profile_dr';

		$data_spl = $this->db->select('specialization_id')->get_where('dr_specialization', array('user_id' => $doc_id))->result_array();
		$result['data_spl'] = array_map(function($value){
			return $value['specialization_id'];
		}, $data_spl);	
		
		$data_qual = $this->db->select('qualification_id')->get_where('dr_qualifications', array('user_id' => $doc_id))->result_array();
		$result['data_qual'] = array_map(function($value){
			return $value['qualification_id'];
		}, $data_qual);

		if (isset($_POST['submit'])) {
			$this->load->model('doctorregmodel');
			$this->doctorregmodel->updatedoctor($doc_id);

			$msg = "<div class='alert alert-success'><strong>Success!</strong> Doctor Updated Successfully</div>";
			$this->session->set_flashdata('flashmsg', $msg);
			redirect(base_url('doctor/doctorview'));
		}
		
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('doctorupdate', $result);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
          
	public function deletedoctor($id = null)
	{
		// If multiple ids are posted, route to bulk_delete
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete();
			return;
		}

		$doc_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->post('did') ? $this->input->post('did') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4))));
		if ($doc_id) {
			$this->load->model('doctorregmodel');
			$this->doctorregmodel->deletedoctor($doc_id);
			$msg = "Doctor record has been deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id') || $this->input->post('did')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/doctorview'));
	}

	public function bulk_delete()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$this->load->model('doctorregmodel');
			$deleted_count = 0;
			foreach ($ids as $doc_id) {
				$doc_id = (int)$doc_id;
				if ($doc_id > 0) {
					$this->doctorregmodel->deletedoctor($doc_id);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count doctor record(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No doctors selected for deletion.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No doctors selected for deletion.</div>");
		}
		redirect(base_url('doctor/doctorview'));
	}

	public function doctordelete($id = null)
	{
		$this->deletedoctor($id);
	}  


	public function duplicate()
	{
		$data['traineeview']=$this->db->order_by('id','DESC')->get_where('fddi_trainee_duplicate');
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('traineeviewduplicate',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function fetchdata()
	{
		$vid=$this->input->post('vid');
		$type=$this->input->post('type');
		$subcenterid=$this->input->post('subcenterid');
		
		/*$this->db->where('fddi_trainee_batch.trainee_id IS NULL');
		$this->db->join('fddi_trainee_batch','fddi_trainee_registration.id = fddi_trainee_batch.trainee_id','left');
		$traineeview=$this->db->order_by('id','DESC')->get_where('fddi_trainee_registration');*/
		
		$alldata=array();
		$counttot=0;
		
		if($type=='dpr')
		{
			$this->db->where('fddi_trainee_batch.trainee_id IS NULL');
			$this->db->join('fddi_trainee_batch','fddi_trainee_registration.id = fddi_trainee_batch.trainee_id','left');
			$traineeview=$this->db->order_by('id','DESC')->get_where('fddi_trainee_registration',array('dpr'=>$vid));
		}
		else if($type=='center')
		{
			$this->db->where('fddi_trainee_batch.trainee_id IS NULL');
			$this->db->join('fddi_trainee_batch','fddi_trainee_registration.id = fddi_trainee_batch.trainee_id','left');
			$traineeview=$this->db->order_by('id','DESC')->get_where('fddi_trainee_registration',array('center'=>$vid));
		}
		else if($type=='subcenter')
		{
			$this->db->where('fddi_trainee_batch.trainee_id IS NULL');
			$this->db->join('fddi_trainee_batch','fddi_trainee_registration.id = fddi_trainee_batch.trainee_id','left');
			$traineeview=$this->db->order_by('id','DESC')->get_where('fddi_trainee_registration',array('subcenter'=>$vid));
		}
		else if($type=='course')
		{
			$this->db->where('fddi_trainee_batch.trainee_id IS NULL');
			$this->db->join('fddi_trainee_batch','fddi_trainee_registration.id = fddi_trainee_batch.trainee_id','left');
			$traineeview=$this->db->order_by('id','DESC')->get_where('fddi_trainee_registration',array('course'=>$vid,'subcenter'=>$subcenterid));
		}
		
		foreach($traineeview->result() as $traineedata){ 
		/* $dpr=$this->db->get_where('dpr_create',array('dpr_id'=>$traineedata->dpr))->row('dpr_name');
		$center=$this->db->get_where('fddi_center',array('id'=>$traineedata->center))->row('center_name');
		$subcenter=$this->db->get_where('fddi_subcenter',array('subcenter_id'=>$traineedata->subcenter))->row('subcenter_name');
		$course=$this->db->get_where('master_course',array('course_id'=>$traineedata->course))->row('course_name');
		 */
			$alldata['table'][]='<tr>
						<td>'.$traineedata->id.'</td>
						<td>'.$traineedata->t_first_name.' '.$traineedata->t_middle_name.' '.$traineedata->t_last_name.'</td>
						<td>'.$traineedata->f_first_name.' '.$traineedata->f_middle_name.' '.$traineedata->f_last_name.' </td>
						<td>'.formateDate($traineedata->dob).'</td>
						<td>'.$traineedata->address.'</td>
						<td>'.$traineedata->aadhar.'</td>
						<td>'.$dpr.'</td>
						<td>'.$center.'</td>
						<td>'.$subcenter.'</td>
						<td>'.$course.'</td>
					  </tr>';
				$counttot++;
		}
		
		
			
			$alldata['counttot']=$counttot;
			if($counttot==0){$alldata['table'][]='<tr>
								<td colspan="9">No result found</td>
							</tr>';}
		echo json_encode($alldata);
	}

    public function viewgallery()
	{

		$data['doc_gal']=$this->db->select('profile_dr.id,profile_dr.fname,doctorgallery.*')->join('profile_dr','profile_dr.id=doctorgallery.user_id','left')->get_where('doctorgallery')->result_array();
		
		$data['module']='gallery';
		

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('doctor_gallery',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function galleryview($id)
	{    
		$data['hosp_gallery']=$this->db->get_where('doctorgallery',array('id'=>$id))->row();
		$data['module']='gallery';
		
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('viewhospital_gallery',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	
	}

	public function updategallery()
	{
		$id=$this->uri->segment(4);
		$data['gallery']=$this->db->get_where('doctorgallery',array('id'=>$id))->row();

		$data['module']='gallery';
		
		if (isset($_POST['submit'])) {
		    
			if(!empty($_FILES['uploadimage']['name']))
			{
                    
                $config['upload_path'] 		= './public/assets/upload/';
                $config['allowed_types'] 	= 'jpg|png|jpeg|JPG|PNG|JPEG';
                $config['max_size']         = 2048;
				$config['quality'] 			= '60%';
                $config['file_name'] 		= $_FILES['uploadimage']['name'];
                
                //Load upload library and initialize configuration
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
                $uploadimage = $data['gallery']->image;
            }  

				$this->load->model('doctorregmodel');
                $this->doctorregmodel->updatedocgallery($id,$uploadimage);
			    $msg="<div class='alert alert-success'><strong>Success!</strong> Data Added Successfully</div>";
			    $this->session->set_flashdata('flashmsg',$msg);	
			    redirect('doctor/doctorview/updategallery/'.$id.'');
				
			}
					
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('updatedoctor_gallery',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function delete()
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_gallery();
			return;
		}

		$id = $this->input->post('id') ? $this->input->post('id') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4));
		if ($id) {
			$this->load->model('doctorregmodel');
			$this->doctorregmodel->gallerydocdelete($id);
			$msg = "Gallery item deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		}
		redirect(base_url().'doctor/doctorview/viewgallery');
	}

	public function bulk_delete_gallery()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$this->load->model('doctorregmodel');
			$deleted_count = 0;
			foreach ($ids as $gid) {
				$gid = (int)$gid;
				if ($gid > 0) {
					$this->doctorregmodel->gallerydocdelete($gid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count doctor gallery item(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No gallery items selected for deletion.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No items selected.</div>");
		}
		redirect(base_url('doctor/doctorview/viewgallery'));
	}
    
  
}
