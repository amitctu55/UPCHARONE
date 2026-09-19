<?php  defined('BASEPATH') OR exit('No direct script access allowed');  
class UserAuth {// extends CI_Controller {  

private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
		$this->CI->load->config('access');
        
    }

	
public function accessCheck()  
    {  
	
		$access_public_module       = (array) $this->CI->config->item('access_public_module');
		$access_public_controller   = (array) $this->CI->config->item('access_public_controller');
		$access_public_action       = (array) $this->CI->config->item('access_public_action');

		$access_admin_module        = (array) $this->CI->config->item('access_admin_module');
		$access_center_module       = (array) $this->CI->config->item('access_center_module');
		$access_subcenter_module    = (array) $this->CI->config->item('access_subcenter_module');
		$access_agency_module       = (array) $this->CI->config->item('access_agency_module');
		
		$access_admin_controller    = (array) $this->CI->config->item('access_admin_controller');
		$access_center_controller   = (array) $this->CI->config->item('access_center_controller');
		$access_subcenter_controller= (array) $this->CI->config->item('access_subcenter_controller');
		$access_agency_controller   = (array) $this->CI->config->item('access_agency_controller');
		
		// Check signed admin guard token to bridge session
		if (empty($this->CI->session->userdata('code'))) {
			$cookieToken = $this->CI->input->cookie('upchar_admin_guard', TRUE);
			if ($cookieToken) {
				$decoded = json_decode(base64_decode($cookieToken), TRUE);
				if (is_array($decoded) && !empty($decoded['adminuserid']) && !empty($decoded['sig'])) {
					$expectedSig = hash_hmac('sha256', $decoded['adminuserid'] . '|' . $decoded['username'] . '|' . $decoded['role'], 'UpcharMasterAdminSecret2026');
					if (hash_equals($expectedSig, $decoded['sig'])) {
						$this->CI->session->set_userdata([
							'adminuserid'      => $decoded['adminuserid'],
							'userid'           => $decoded['adminuserid'],
							'username'         => $decoded['username'],
							'code'             => '1',
							'active_auth_role' => 'admin',
							'logged_in'        => TRUE
						]);
					}
				}
			}
		}

		$usertype = $this->CI->session->userdata('code');
		
		$module     =  $this->CI->router->fetch_module();
		$controller =  $this->CI->router->fetch_class();
		$method     =  $this->CI->router->fetch_method();
		
		$msg="<div class='alert alert-danger'><strong>Access Denied!</strong>You Do not have sufficient previlage to view the requested page.You can Navigate from here.</div>";
		
		if($usertype == ''){
			if(  !in_array($controller,$access_public_controller)  ) {
				$is_ajax = $this->CI->input->is_ajax_request() || (bool)$this->CI->input->post('is_ajax') || (bool)$this->CI->input->get('is_ajax');
				if ($is_ajax) {
					if (ob_get_length()) { @ob_clean(); }
					$this->CI->output
						->set_status_header(401)
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode(array(
							'status' => 0,
							'session_expired' => 1,
							'message' => 'Your session has expired. Please reload the page and log in to continue.'
						)));
					$this->CI->output->_display();
					exit;
				}
				redirect(base_url().'login');
			}
			
			
		}else if($usertype == 'A' || $usertype == '1'){
			
			if( !in_array($controller,$access_admin_controller) && !in_array($controller,$access_public_controller) && !in_array($module,$access_admin_module)  ){
			
				$this->CI->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'masters/dashboard');
			}
			
		}else if($usertype == 'C'){
			
			if( !in_array($controller,$access_center_controller) && !in_array($controller,$access_public_controller)  && !in_array($module,$access_center_module)  ){
				
				$this->CI->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'ccenter/dashboard');
			}
			
		}else if($usertype == 'SC'){
			
			if( !in_array($controller,$access_subcenter_controller) && !in_array($controller,$access_public_controller)  && !in_array($module,$access_subcenter_module)  ){
				
				$this->CI->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'sccenter/dashboard');
			}
			
		}else if($usertype == 'AG'){
			
			if( !in_array($controller,$access_subcenter_controller) && !in_array($controller,$access_public_controller)  && !in_array($module,$access_agency_module)  ){
				
				$this->CI->session->set_flashdata('flashmsg',$msg);
				redirect(base_url().'agency/dashboard');
			}
		}
		

    }  
	
	
}