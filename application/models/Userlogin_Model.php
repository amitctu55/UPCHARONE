<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Userlogin_Model extends CI_Model {

function __construct() {
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");


	}
    public function profile()
   {
     $userid =$this->session->userdata('userid');
	$udata=array('FNAME'=>$this->input->post('name'),'GENDER'=>$this->input->post('gender'),'EMAIL'=>$this->input->post('email'),'MOBILE'=>$this->input->post('mobile'),'DOB'=>$this->input->post('dob'));
		$this->db->where('userid',$userid)->update('userlogin',$udata);

    redirect('updateprofile');
		
}

public function updateprofile(){
		
	    $userid =$this->session->userdata('userid');
		$uploadimage=$_FILES['file']['name'];
		$extsign = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
		$allowed_exts = array('jpg', 'jpeg', 'png', 'webp');
		
		if (!empty($uploadimage)) 
		{	
			if (!in_array($extsign, $allowed_exts)) {
				$flashmsg = '<div class="alert alert-danger"><strong>Invalid File Type!</strong> Only JPG, PNG, and WEBP images are allowed.</div>';
				$this->session->set_flashdata('flashmsg', $flashmsg);
				redirect('updateprofile');
				return;
			}

			$rname = rand(1111111,999999999);
			$date  = date('Ymd');
			$uploadimage = 'pic_'.$rname.$date.'.'.$extsign;
			$upload_dir = FCPATH . 'admin1947/public/assets/upload/';
			
			if (!is_dir($upload_dir)) {
				@mkdir($upload_dir, 0755, true);
			}

			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|jpeg|png|webp';
			$config['max_size']      = 5120; // 5MB max limit
			$config['file_name']     = $uploadimage;
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('file'))
			{
				$error = $this->upload->display_errors();
				$flashmsg='<div class="alert alert-danger"><strong>Upload Failed!</strong> '.$error.'</div>';
				$this->session->set_flashdata('flashmsg',$flashmsg);
				redirect('updateprofile');
				return;
			} else {
				$udata = array('IMAGE' => $uploadimage);
				$this->db->where('userid', $userid)->update('userlogin', $udata);
				return $uploadimage;
			}
		}
		redirect('profile');	
	}


function change_password($id)
	{
		$query = $this->db->where(['USERID'=>$id])->get('userlogin');
		return $query->row();
	}

  public function updatePassword($new_password, $id)
  {
      $hash = (strlen($new_password) == 60 && strpos($new_password, '$2y$') === 0) ? $new_password : password_hash($new_password, PASSWORD_BCRYPT);
      $data = array('PASSWORD' => $hash);
      return $this->db->where('USERID', $id)->update('userlogin', $data); 
  }

   public function c_count()
   {
   $this->db->select('count(*)');
   $query = $this->db->get('userlogin');
   $cnt = $query->row_array();
   return $cnt['count(*)'];
  }
	

}
    

