<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Userlogin_Model extends CI_Model {

function __construct() {
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");


	}
    public function profile($userid = null)
    {
        // 1. Resolve user id from argument, POST, or session keys
        if (empty($userid)) {
            $userid = intval($this->input->post('userid')) 
                   ?: ($this->session->userdata('userid') ?: $this->session->userdata('user_id') ?: $this->session->userdata('USERID'));
        }
        $useremail = $this->session->userdata('useremail');
        $username  = $this->session->userdata('username');

        // Resolve valid userlogin record
        $targetUser = null;
        if (!empty($userid)) {
            $targetUser = $this->db->get_where('userlogin', array('USERID' => $userid))->row();
        }
        if (!$targetUser && !empty($useremail)) {
            $targetUser = $this->db->get_where('userlogin', array('EMAIL' => $useremail))->row();
            if ($targetUser) {
                $userid = $targetUser->USERID;
                $this->session->set_userdata('userid', $userid);
            }
        }
        if (!$targetUser && !empty($username)) {
            $targetUser = $this->db->group_start()
                ->where('EMAIL', $username)
                ->or_where('MOBILE', $username)
                ->or_where('FNAME', $username)
                ->group_end()
                ->get('userlogin')->row();
            if ($targetUser) {
                $userid = $targetUser->USERID;
                $this->session->set_userdata('userid', $userid);
            }
        }
        if (!$targetUser && $this->session->userdata('adminuserid')) {
            $adminRow = $this->db->get_where('login', array('id' => $this->session->userdata('adminuserid')))->row();
            if ($adminRow && !empty($adminRow->email)) {
                $targetUser = $this->db->get_where('userlogin', array('EMAIL' => $adminRow->email))->row();
                if ($targetUser) {
                    $userid = $targetUser->USERID;
                    $this->session->set_userdata('userid', $userid);
                }
            }
        }

        if (!$targetUser && empty($userid)) {
            return array('status' => 'error', 'message' => 'Unable to identify patient account. Please login again.');
        }

        // Process Form Inputs
        $fullName = trim($this->input->post('name', TRUE));
        $email    = trim($this->input->post('email', TRUE));
        $mobile   = trim($this->input->post('mobile', TRUE));
        $gender   = trim($this->input->post('gender', TRUE));
        $dob      = trim($this->input->post('dob', TRUE));
        $bgroup   = trim($this->input->post('bgroup', TRUE));
        $height   = $this->input->post('height', TRUE) !== null ? trim($this->input->post('height', TRUE)) : null;
        $weight   = $this->input->post('weight', TRUE) !== null ? trim($this->input->post('weight', TRUE)) : null;

        // Intelligent Name Splitting for FNAME & LNAME
        $fname = $fullName;
        $lname = '';
        if (!empty($fullName)) {
            $parts = preg_split('/\s+/', $fullName, 2);
            $fname = $parts[0];
            $lname = isset($parts[1]) ? $parts[1] : '';
        }

        // Validate Mobile format & duplicates if provided
        $cleanMobile = null;
        if (!empty($mobile)) {
            $cleanMobile = preg_replace('/[^0-9]/', '', $mobile);
            if (strlen($cleanMobile) == 12 && substr($cleanMobile, 0, 2) === '91') {
                $cleanMobile = substr($cleanMobile, 2);
            }
            if (strlen($cleanMobile) < 10) {
                return array('status' => 'error', 'message' => 'Please provide a valid 10-digit mobile number.');
            }
            // Check collision with another user
            if (!empty($userid)) {
                $dupMob = $this->db->group_start()
                    ->where('MOBILE', $cleanMobile)
                    ->or_where('MOBILE', $mobile)
                    ->group_end()
                    ->where('USERID !=', $userid)
                    ->get('userlogin')->row();
                if ($dupMob) {
                    return array('status' => 'error', 'message' => 'Mobile number ' . html_escape($cleanMobile) . ' is already registered with another account.');
                }
            }
        }

        // Validate Email format & duplicates if provided
        $cleanEmail = null;
        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return array('status' => 'error', 'message' => 'Please enter a valid email address.');
            }
            $cleanEmail = strtolower($email);
            if (!empty($userid)) {
                $dupEmail = $this->db->where('LOWER(EMAIL)', $cleanEmail)
                    ->where('USERID !=', $userid)
                    ->get('userlogin')->row();
                if ($dupEmail) {
                    return array('status' => 'error', 'message' => 'Email address ' . html_escape($email) . ' is already registered with another account.');
                }
            }
        }

        // Construct Database Array
        $udata = array(
            'FNAME'       => !empty($fname) ? $fname : ($targetUser ? $targetUser->FNAME : ''),
            'LNAME'       => !empty($lname) ? $lname : ($targetUser && empty($fullName) ? $targetUser->LNAME : ''),
            'GENDER'      => !empty($gender) ? $gender : null,
            'EMAIL'       => !empty($cleanEmail) ? $cleanEmail : null,
            'MOBILE'      => !empty($cleanMobile) ? $cleanMobile : null,
            'DOB'         => !empty($dob) ? $dob : null,
            'BGROUP'      => !empty($bgroup) ? $bgroup : null,
            'UPDATE_DATE' => date('Y-m-d')
        );

        if ($height !== null) {
            $udata['HEIGHT'] = !empty($height) ? $height : null;
        }
        if ($weight !== null) {
            $udata['WEIGHT'] = !empty($weight) ? $weight : null;
        }

        // Execute Update or Provision
        if ($targetUser && !empty($userid)) {
            $this->db->where('USERID', $userid)->update('userlogin', $udata);
        } else {
            // Auto-provision patient record if none exists yet
            $udata['STATUS']   = '1';
            $udata['APPROVED'] = '1';
            $udata['REG_DATE'] = date('Y-m-d H:i:s');
            $this->db->insert('userlogin', $udata);
            $userid = $this->db->insert_id();
        }

        // Synchronize Session
        $this->session->set_userdata('userid', $userid);
        $this->session->set_userdata('user_id', $userid);
        $this->session->set_userdata('USERID', $userid);
        $fullNameDisplay = trim($udata['FNAME'] . ' ' . $udata['LNAME']);
        if (!empty($fullNameDisplay)) {
            $this->session->set_userdata('username', $fullNameDisplay);
        }
        if (!empty($cleanEmail)) {
            $this->session->set_userdata('useremail', $cleanEmail);
        }
        if (!empty($cleanMobile)) {
            $this->session->set_userdata('mobile', $cleanMobile);
        }

        return array(
            'status'       => 'success', 
            'message'      => 'Profile details updated successfully!',
            'user'         => $udata,
            'display_name' => $fullNameDisplay
        );
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
    

