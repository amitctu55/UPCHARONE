<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pathlabregmodel extends CI_Model{
	
	     
	 
	
	public function traineereginsert($drimage = '', $id_proof = '', $med_reg_proof = '')
	{
		$date = date('Y-m-d H:i:s');
		
		$city = $this->input->post('city');
		$fname = trim($this->input->post('name'));	
		$email = trim($this->input->post('email'));
		$mobile = trim($this->input->post('mobile'));
		$location = trim($this->input->post('location'));
		$address = trim($this->input->post('address'));
		$website = trim($this->input->post('website'));
		$about = trim($this->input->post('about'));
		$commission = $this->input->post('commission_rate') !== null && $this->input->post('commission_rate') !== '' 
			? (float)$this->input->post('commission_rate') : 15.00;
		$nabl = $this->input->post('nabl_accredited') ? 1 : 0;
		$license = trim($this->input->post('license_number') ?? '');

		$rawPwd = trim($this->input->post('password') ?? '');
		if (empty($rawPwd)) {
			$rawPwd = 'Lab@' . rand(10000, 99999);
		}
		$password = md5($rawPwd);

		// Create login account in pathlogin
		$loginData = array(
			'FNAME'      => $fname,
			'EMAIL'      => $email,
			'MOBILE'     => $mobile,
			'PASSWORD'   => $password,
			'STATUS'     => '1',
			'APPROVED'   => '1',
			'REG_DATE'   => $date
		);
		$this->db->insert('pathlogin', $loginData);
		$uid = $this->db->insert_id();

		$data = array(
			'uid'               => $uid ?: 0,
			'name'              => $fname,
			'city'              => $city,
			'drimage'           => $drimage ?: 'dummyhosp.jpg',
			'id_proof'          => $id_proof,
			'med_reg_proof'     => $med_reg_proof,
			'mobile'            => $mobile,
			'email'             => $email,
			'creat_date'        => $date,
			'location'          => $location,
			'address'           => $address,
			'website'           => $website,
			'about'             => $about,
			'commission_rate'   => $commission,
			'nabl_accredited'   => $nabl,
			'license_number'    => $license,
			'raw_password_temp' => $rawPwd,
			'approved'          => '1',
			'verified'          => '1',
			'status'            => '1'
		);
			
		$this->db->insert('pathlab', $data);
		$labId = $this->db->insert_id();

		if ($labId) {
			return array(
				'id'       => $labId,
				'name'     => $fname,
				'email'    => $email,
				'mobile'   => $mobile,
				'password' => $rawPwd,
				'uid'      => $uid
			);
		}
		return false;
	}

	public function reset_lab_credentials($labId, $newPlainPassword = null)
	{
		$lab = $this->db->get_where('pathlab', array('id' => $labId))->row();
		if (!$lab) return false;

		if (empty($newPlainPassword)) {
			$newPlainPassword = 'Lab@' . rand(10000, 99999);
		}
		$md5Pwd = md5($newPlainPassword);

		// Update pathlab
		$this->db->where('id', $labId)->update('pathlab', array('raw_password_temp' => $newPlainPassword));

		// Update pathlogin
		if ($lab->uid > 0) {
			$this->db->where('id', $lab->uid)->update('pathlogin', array('PASSWORD' => $md5Pwd));
		}
		if (!empty($lab->email)) {
			$this->db->where('EMAIL', $lab->email)->update('pathlogin', array('PASSWORD' => $md5Pwd));
		}

		return array(
			'id'       => $labId,
			'email'    => $lab->email,
			'password' => $newPlainPassword
		);
	}

	public function pathlab_duplicacy_check()
	{
		$email = trim($this->input->post('email'));
		$mobile = trim($this->input->post('mobile'));
		if (empty($email) && empty($mobile)) {
			return 'EMPTY';
		}
		$mobile_count = !empty($mobile) ? $this->db->where('mobile', $mobile)->where('status !=', '2')->count_all_results('pathlab') : 0;
		$email_count = !empty($email) ? $this->db->where('email', $email)->where('status !=', '2')->count_all_results('pathlab') : 0;
		
		if($mobile_count == 0 && $email_count == 0)
			return 'OK';
		else if($mobile_count > 0 && $email_count > 0)
			return 'BOTH';
		else if($mobile_count > 0)
			return 'MOBILE';
		else if($email_count > 0)
			return 'EMAIL';
		return 'OK';
	}




    public function updatepathlab($id)
       {
      
             
			$date=date('Y-m-d h:i:s');
			
			$city=$this->input->post('city');
			$fname=$this->input->post('name');	
			$email=$this->input->post('email');
			$mobile=$this->input->post('mobile');
			$location=$this->input->post('location');
			$address=$this->input->post('address');
			$website=$this->input->post('website');
			$about=$this->input->post('about');
			
			
		$data=array('name'=>$fname,'city'=>$city,'mobile'=>$mobile,'email'=>$email,'creat_date'=>$date,'location'=>$location,'address'=>$address,'website'=>$website,'about'=>$about);
			
			$this->db->where('id',$id);
	       $this->db->update('pathlab',$data);

       }

	public function deletepathlab($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('pathlab');
		return ($this->db->affected_rows() > 0) ? true : false;
	}

}