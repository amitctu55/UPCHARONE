<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pathtest extends CI_Controller 
{
	function __construct()
	{
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $date=date('Y-m-d h:i:s');
		 $this->load->helper(array('query_string_helper','dbquery_helper','admin_helper','text'));
		 $this->load->model(array('pathtest_model','masters/managementmodel'));
	}
	
	public function category()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['data'] 			=  $this->pathtest_model->get_path_category($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Test Category List';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
	    $this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('path_category',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function category_delete($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_category();
			return;
		}

		$cat_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('category_id') ? $this->input->get('category_id') : $this->uri->segment(4)));
		if ($cat_id) {
			$this->pathtest_model->deleterecord($cat_id);
			$msg = "Category deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/pathtest/category'));
	}

	public function bulk_delete_category()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $cid) {
				$cid = (int)$cid;
				if ($cid > 0) {
					$this->pathtest_model->deleterecord($cid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count category record(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No categories selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No categories selected.</div>");
		}
		redirect(base_url('doctor/pathtest/category'));
	}
	
	public function addcategory()
	{
		$this->form_validation->set_rules('category_name','Category Name','trim|required|max_length[100]');
		if($this->form_validation->run()==TRUE)
		{
			if($this->pathtest_model->categoryinsert()) 
			{
				$msg="<div class='alert alert-success'><strong>Success!</strong> Category Added Successfully </div>";
				$this->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'doctor/pathtest/category');
			}	
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('add_category');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function editcategory()
	{	
		$category_id = $this->uri->segment(4);
		$res	=	$this->pathtest_model->get_path_category(1,0,array('category_id'=>$category_id));
		if(is_object($res)&& !empty($res))
		{
			$this->form_validation->set_rules('category_name','Category Name','trim|required|max_length[100]');
			if($this->form_validation->run()==TRUE)
			{
				if($this->pathtest_model->updatecategory($category_id)) 
				{
					$msg="<div class='alert alert-success'><strong>Success!</strong> Category Updated Successfully </div>";
					$this->session->set_flashdata('flashmsg',$msg);
					redirect(base_url().'doctor/pathtest/category');
				}	
			}
		}
		else
		{
			redirect('doctor/pathtest/category','');
		}
		$data['res']	=	$res;
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('edit_category',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function index()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['result'] 		=  $this->pathtest_model->get_test($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Path Test List';
		$data['module'] 		=  'Path Test';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
		if( $this->input->post('status_action')!='')
		{
			$this->managementmodel->update_status('pathtest','test_id');			
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathtest_list',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function add()
	{
		$this->form_validation->set_rules('path_id','Path Name','trim|required|max_length[100]');
		$this->form_validation->set_rules('category_id','Category Name','trim|required|max_length[100]');
		$this->form_validation->set_rules('test_name','Test Name','trim|required|max_length[100]');
		$this->form_validation->set_rules('short_name','Short Name','trim|required|max_length[100]');
		$this->form_validation->set_rules('test_type','Test Type','trim|required|max_length[100]');
		$this->form_validation->set_rules('sub_category','Sub Category','trim|max_length[100]');
		$this->form_validation->set_rules('method','Method','trim|max_length[100]');
		$this->form_validation->set_rules('report_day','Report Day','trim|max_length[100]');
		$this->form_validation->set_rules('charge_category','Charge Category','trim|required|max_length[100]');
		$this->form_validation->set_rules('code','Code','trim|required|max_length[100]');
		$this->form_validation->set_rules('amount','Amount','trim|required|numeric|max_length[5]');
		if($this->form_validation->run()==TRUE)
		{
			if($this->pathtest_model->test_insert()) 
			{
				$msg="<div class='alert alert-success'><strong>Success!</strong> Test Added Successfully </div>";
				$this->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'doctor/pathtest/index');
			}	
		}
		$data['heading_title'] 	= 'Test Add';
		$data['module'] 		= 'Test Add';
		$data['category']		= $this->pathtest_model->path_category(array('status'=>'1'));
		$data['pathlab']		= $this->pathtest_model->get_pathlab(array('approved'=>'1'));
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('test_add',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function edit()
	{
		$test_id 	= $this->uri->segment(4);
		$res		= $this->pathtest_model->get_test(1,0,array('test_id'=>$test_id));
		
		if(is_array($res) && !empty($res))
		{
			$this->form_validation->set_rules('path_id','Path Name','trim|required|max_length[100]');
			$this->form_validation->set_rules('category_id','Category Name','trim|required|max_length[100]');
			$this->form_validation->set_rules('test_name','Test Name','trim|required|max_length[100]');
			$this->form_validation->set_rules('short_name','Short Name','trim|required|max_length[100]');
			$this->form_validation->set_rules('test_type','Test Type','trim|required|max_length[100]');
			$this->form_validation->set_rules('sub_category','Sub Category','trim|max_length[100]');
			$this->form_validation->set_rules('method','Method','trim|max_length[100]');
			$this->form_validation->set_rules('report_day','Report Day','trim|max_length[100]');
			$this->form_validation->set_rules('charge_category','Charge Category','trim|required|max_length[100]');
			$this->form_validation->set_rules('code','Code','trim|required|max_length[100]');
			$this->form_validation->set_rules('amount','Amount','trim|required|numeric|max_length[5]');
			if($this->form_validation->run()==TRUE)
			{
				if($this->pathtest_model->update($test_id)) 
				{
					$msg="<div class='alert alert-success'><strong>Success!</strong> Test Added Successfully </div>";
					$this->session->set_flashdata('flashmsg',$msg);
					redirect(base_url().'doctor/pathtest/index');
				}	
			}
		}
		else
		{
			redirect(base_url().'doctor/pathtest/index');
		}
		$data['res']			= $res;
		$data['heading_title'] 	= 'Test Edit';
		$data['module'] 		= 'Test Edit ';
		$data['category']		= $this->pathtest_model->path_category(array('status'=>'1'));
		$data['pathlab']		= $this->pathtest_model->get_pathlab(array('approved'=>'1'));
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('test_edit',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function test_parameter()
	{	
		$test_id 				=  $this->uri->segment(4);
		$res					= $this->pathtest_model->get_test(1,0,array('test_id'=>$test_id));
		if(is_array($res) && !empty($res))
		{
			$this->form_validation->set_rules('parameter_id','Parameter','trim|required|max_length[100]');
			$this->form_validation->set_rules('reference_range','Reference Range','trim|required|max_length[100]');
			$this->form_validation->set_rules('unit','Unit','trim|required|max_length[100]');
			if($this->form_validation->run()==TRUE)
			{
				if($this->pathtest_model->insert_test_parameter($test_id)) 
				{
					$msg="<div class='alert alert-success'><strong>Success!</strong> Test Added Successfully </div>";
					$this->session->set_flashdata('flashmsg',$msg);
					redirect(base_url().'doctor/pathtest/test_parameter/'.$test_id.'');
				}	
			
			}
			$pagesize               =  (int) $this->input->get_post('pagesize');
			$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
			$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
			$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
			$param					=	array('test_id'=>$test_id);
			$data['data'] 			=  $this->pathtest_model->get_test_parameter($config['limit'],$offset,$param);
			//echo "<pre>"; print_r($data['data']); die;
			$config['total_rows']   =  get_found_rows();
			$data['test_id']		=  $test_id;
			$data['parameter']		=  $this->pathtest_model->path_parameter_all(array('status'=>'1'));
			$data['heading_title'] 	=  'Test Parameter List';
			$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
			$this->load->view('inc/topheaderlink');
			$this->load->view('inc/topheader');
			$this->load->view('test_parameter',$data);
			$this->load->view('sidebar');
			$this->load->view('inc/headersetting');
			$this->load->view('inc/footerlink');
			$this->load->view('inc/table_footer');
		}
		else
		{
			redirect('doctor/pathtest','');
		}
	}
	public function get_test_parameter()
	{
		$parameter_id 	= $this->input->get_post('parameter_id');
		$parameter 		= $this->pathtest_model->get_paramete_row(array('parameter_id'=>$parameter_id));
		if(is_array($parameter)&& !empty($parameter))
		{
			$parameter 		= $parameter[0];
		}
		echo json_encode($parameter);
	}

	public function test_parameter_delete()
    {
		$test_parameter_id	=	$this->input->get('test_parameter_id');
		$res				= $this->pathtest_model->get_test_parameter(1,0,array('test_parameter_id'=>$test_parameter_id));
		//echo "<pre>"; print_r($res); die;
		$this->pathtest_model->test_parameter_delete($test_parameter_id);
		$msg="<div class='alert alert-success'><strong>Success!</strong> Test Parameter Deleted Successfully </div>";
		$this->session->set_flashdata('flashmsg',$msg);
		redirect(base_url().'doctor/pathtest/test_parameter/'.$res->test_id.'');
    }
	
	public function unit()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['data'] 			=  $this->pathtest_model->get_path_unit($config['limit'],$offset);
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Test Unit List';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
	    $this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('path_unit',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function delete_test($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_test();
			return;
		}

		$test_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('test_id') ? $this->input->get('test_id') : $this->uri->segment(4)));
		if ($test_id) {
			$this->pathtest_model->test_delete($test_id);
			$msg = "Pathology Test deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/pathtest/index'));
	}

	public function bulk_delete_test()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $tid) {
				$tid = (int)$tid;
				if ($tid > 0) {
					$this->pathtest_model->test_delete($tid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count test record(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No tests selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No tests selected.</div>");
		}
		redirect(base_url('doctor/pathtest/index'));
	}

	public function unit_delete($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_unit();
			return;
		}

		$uid = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('unit_id') ? $this->input->get('unit_id') : $this->uri->segment(4)));
		if ($uid) {
			$this->pathtest_model->unitrecord($uid);
			$msg = "Unit deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/pathtest/unit'));
	}

	public function bulk_delete_unit()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $uid) {
				$uid = (int)$uid;
				if ($uid > 0) {
					$this->pathtest_model->unitrecord($uid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count unit(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No units selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No units selected.</div>");
		}
		redirect(base_url('doctor/pathtest/unit'));
	}
	
	public function addunit()
	{
		$this->form_validation->set_rules('unit_name','Unit Name','trim|required|max_length[100]');
		if($this->form_validation->run()==TRUE)
		{
			if($this->pathtest_model->unitinsert()) 
			{
				$msg="<div class='alert alert-success'><strong>Success!</strong> Unit Added Successfully </div>";
				$this->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'doctor/pathtest/unit');
			}	
		}
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('add_unit');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function editunit()
	{	
		$unit_id = $this->uri->segment(4);
		$res	=	$this->pathtest_model->get_path_unit(1,0,array('unit_id'=>$unit_id));
		if(is_object($res)&& !empty($res))
		{
			$this->form_validation->set_rules('unit_name','Unit Name','trim|required|max_length[100]');
			if($this->form_validation->run()==TRUE)
			{
				if($this->pathtest_model->updateunit($unit_id)) 
				{
					$msg="<div class='alert alert-success'><strong>Success!</strong> Unit Updated Successfully </div>";
					$this->session->set_flashdata('flashmsg',$msg);
					redirect(base_url().'doctor/pathtest/unit');
				}	
			}
		}
		else
		{
			redirect('doctor/pathtest/unit','');
		}
		$data['res']	=	$res;
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('edit_unit',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function parameter()
	{	
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']	    =  ( $pagesize > 0 ) ? $pagesize : 10;	
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$data['data'] 			=  $this->pathtest_model->get_path_parameter($config['limit'],$offset);
		//echo "<pre>"; print_r($data['data']); die;
		$config['total_rows']   =  get_found_rows();
		$data['heading_title'] 	=  'Test Parameter List';
		$data['page_links'] 	=  admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset);
	    $this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('path_parameter',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function parameter_delete($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_parameter();
			return;
		}

		$pid = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('parameter_id') ? $this->input->get('parameter_id') : $this->uri->segment(4)));
		if ($pid) {
			$this->pathtest_model->parameterrecord($pid);
			$msg = "Parameter deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/pathtest/parameter'));
	}

	public function bulk_delete_parameter()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $pid) {
				$pid = (int)$pid;
				if ($pid > 0) {
					$this->pathtest_model->parameterrecord($pid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count parameter(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No parameters selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No parameters selected.</div>");
		}
		redirect(base_url('doctor/pathtest/parameter'));
	}
	
	public function addparameter()
	{
		$this->form_validation->set_rules('parameter_name','Parameter Name','trim|required|max_length[100]');
		$this->form_validation->set_rules('reference_range','Reference Range','trim|max_length[100]');
		$this->form_validation->set_rules('unit_id','Unit Id','trim|required|max_length[100]');
		$this->form_validation->set_rules('description','Description','trim|max_length[500]');
		if($this->form_validation->run()==TRUE)
		{	
			if($this->pathtest_model->parameterinsert()) 
			{
				$msg="<div class='alert alert-success'><strong>Success!</strong> Parameter Added Successfully </div>";
				$this->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'doctor/pathtest/parameter');
			}	
		}
		$data['unit']	=	$this->pathtest_model->get_unit_all(array('status'=>'1'));
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('add_parameter',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function editparameter()
	{	
		$parameter_id = $this->uri->segment(4);
		$res	=	$this->pathtest_model->get_path_parameter(1,0,array('parameter_id'=>$parameter_id));
		if(is_object($res)&& !empty($res))
		{
			$this->form_validation->set_rules('parameter_name','Parameter Name','trim|required|max_length[100]');
			$this->form_validation->set_rules('reference_range','Reference Range','trim|max_length[100]');
			$this->form_validation->set_rules('unit_id','Unit Id','trim|required|max_length[100]');
			$this->form_validation->set_rules('description','Description','trim|max_length[500]');
			if($this->form_validation->run()==TRUE)
			{
				if($this->pathtest_model->updateunit($parameter_id)) 
				{
					$msg="<div class='alert alert-success'><strong>Success!</strong> Unit Updated Successfully </div>";
					$this->session->set_flashdata('flashmsg',$msg);
					redirect(base_url().'doctor/pathtest/parameter');
				}	
			}
		}
		else
		{
			redirect('doctor/pathtest/parameter','');
		}
		$data['unit']	=	$this->pathtest_model->get_unit_all(array('status'=>'1'));
		$data['res']	=	$res;
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('edit_parameter',$data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
}