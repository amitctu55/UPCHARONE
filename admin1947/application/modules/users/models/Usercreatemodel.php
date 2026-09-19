<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usercreatemodel extends CI_Model{
	
	
	
	public function checkusername($exclude_id = null)
	{
			$username = $this->input->post('userid') ?: ($this->input->post('useremail') ?: $this->input->post('username'));
			$this->db->where('username', $username);
			if ($exclude_id) {
				$this->db->where('id !=', $exclude_id);
			}
			$count = $this->db->count_all_results('login');
			return ($count > 0) ? false : true;
	}

	public function usercreateinsert()
	{
			$date = date('Y-m-d H:i:s');
			
			$username = trim($this->input->post('username'));
			$usermobile = trim($this->input->post('usermobile'));
			$userdob = trim($this->input->post('userdob'));
			$activeradio = $this->input->post('activeradio') !== null ? $this->input->post('activeradio') : '1';
			$useraddress = trim($this->input->post('useraddress'));
			$useremail = trim($this->input->post('useremail'));
			$userrole = $this->input->post('userrole') ?: 'staff';
			$userid = $this->input->post('userid') ?: ($useremail ?: $username);
			$pwd = md5($this->input->post('resetpassword'));
			
			$data = array(
						'username'   => $userid,
						'password'   => $pwd,
						'role'       => $userrole,
						'name'       => $username,
						'address'    => $useraddress,
						'dob'        => $userdob,
						'mobile'     => $usermobile,
						'email'      => $useremail,
						'status'     => $activeradio,
						'permisions' => $date
			);
			$this->db->insert('login', $data);
			return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	public function usercreateedit($id)
	{		
			$date = date('Y-m-d H:i:s');
			$username = trim($this->input->post('username'));
			$usermobile = trim($this->input->post('usermobile'));
			$userdob = trim($this->input->post('userdob'));
			$activeradio = $this->input->post('activeradio') !== null ? $this->input->post('activeradio') : '1';
			$useraddress = trim($this->input->post('useraddress'));
			$useremail = trim($this->input->post('useremail'));
			$userrole = $this->input->post('userrole') ?: 'staff';
			$userid = $this->input->post('userid') ?: ($useremail ?: $username);
			
			$pwdtemp = $this->input->post('resetpassword');
			if(empty($pwdtemp))
			{
				$pwd = $this->db->get_where('login', array('id' => $id))->row('password');
			}
			else{
				$pwd = md5($pwdtemp);
			}
			
			$data = array(
							'username'   => $userid,
							'password'   => $pwd,
							'role'       => $userrole,
							'name'       => $username,
							'address'    => $useraddress,
							'dob'        => $userdob,
							'mobile'     => $usermobile,
							'email'      => $useremail,
							'status'     => $activeradio,
							'permisions' => $date
			);
			$this->db->where('id', $id);
			$r = $this->db->update('login', $data);
			return (!$r) ? false : true;
	}
	
	public function usermoddelete($uid)
	{
		$this->db->where('id',$uid);
		$r=$this->db->delete('login');
		return (!$r) ? false : true;
	}
	
	
	
}