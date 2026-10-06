<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model{
	
	public function insert()
	{
	    $date = date('Y-m-d H:i:s');
	    $fname  = $this->input->post('fname');
	    $lname  = $this->input->post('lname');
	    $pwd    = md5($this->input->post('password'));
	    $email  = $this->input->post('email');
	    $gender = $this->input->post('activeradio');
	    $dob    = $this->input->post('dob');
	    $height = $this->input->post('height');
	    $weight = $this->input->post('weight');
	    $blood  = $this->input->post('blood');
	    $mobile = $this->input->post('mobile');
	    
	    $data = array(
	        'MOBILE'   => $mobile,
	        'FNAME'    => $fname,
	        'LNAME'    => $lname,
	        'PASSWORD' => $pwd,
	        'EMAIL'    => $email,
	        'DOB'      => $dob,
	        'REG_DATE' => $date,
	        'GENDER'   => $gender,
	        'BGROUP'   => $blood,
	        'HEIGHT'   => $height,
	        'WEIGHT'   => $weight,
	        'status'   => '1'
	    );
	   
	    return $this->db->insert('userlogin', $data);
	}

	public function get_users($limit = 10, $offset = 0)
	{
		$keyword = $this->input->get_post('keyword');
		$mobile  = $this->input->get_post('mobile');

		$this->db->select('SQL_CALC_FOUND_ROWS userlogin.*', FALSE);
		$this->db->from('userlogin');
		$this->db->where('status', '1');

		if (!empty($keyword)) {
			$this->db->group_start();
			$this->db->like('FNAME', $keyword);
			$this->db->or_like('LNAME', $keyword);
			$this->db->or_like('EMAIL', $keyword);
			$this->db->group_end();
		}

		if (!empty($mobile)) {
			$this->db->like('MOBILE', $mobile);
		}

		$this->db->order_by('USERID', 'DESC');
		$this->db->limit($limit, $offset);
		
		return $this->db->get()->result();
	}

    public function delete($id)
    {
        $this->db->where('USERID', $id)->delete('userlogin');
    }

    public function bulk_delete($ids)
    {
    	if (is_array($ids) && !empty($ids)) {
    		$this->db->where_in('USERID', $ids)->delete('userlogin');
    		return TRUE;
    	}
    	return FALSE;
    }

    public function reset_password($id, $new_password)
    {
    	$pwd = md5($new_password);
    	$this->db->where('USERID', $id)->update('userlogin', array('PASSWORD' => $pwd));
    	return TRUE;
    }

    /**
     * Unified user and patient creation using CodeIgniter DB transactions
     *
     * @param array $payload Validated POST data
     * @return array Status, generated user ID, and assigned role
     */
    public function create_unified_account($payload)
    {
        $role_type = trim($payload['role_type'] ?? 'patient'); // 'patient', 'website_user', 'staff'
        $email     = trim(strtolower($payload['email'] ?? ''));
        $mobile    = trim(preg_replace('/[^0-9]/', '', $payload['mobile'] ?? ''));
        $password  = trim($payload['password'] ?? '');

        // -------------------------------------------------------------
        // BRANCH A: Administrative Staff (Stored in `login` table)
        // -------------------------------------------------------------
        if ($role_type === 'staff') {
            $username = trim($payload['staff_username'] ?? ($email ?: $mobile));
            
            // Uniqueness check in `login`
            $this->db->group_start();
            $this->db->where('username', $username);
            if (!empty($email)) $this->db->or_where('email', $email);
            $this->db->group_end();
            if ($this->db->count_all_results('login') > 0) {
                return ['status' => 'error', 'message' => 'Staff username or email already exists in admin records.'];
            }

            $staff_role = !empty($payload['staff_role']) ? (int)$payload['staff_role'] : 2; // 1: Admin, 2: Staff
            $staff_data = array(
                'username'   => $username,
                'password'   => md5($password),
                'name'       => trim(($payload['fname'] ?? '') . ' ' . ($payload['lname'] ?? '')),
                'email'      => $email,
                'mobile'     => $mobile,
                'role'       => $staff_role,
                'status'     => '1',
                'permisions' => date('Y-m-d H:i:s')
            );

            $this->db->insert('login', $staff_data);
            $inserted_id = $this->db->insert_id();

            return [
                'status'     => 'success',
                'role'       => 'staff',
                'user_id'    => $inserted_id,
                'email'      => $email,
                'mobile'     => $mobile,
                'name'       => $staff_data['name'],
                'temp_pass'  => $password
            ];
        }

        // -------------------------------------------------------------
        // BRANCH B: Patient or Standard Website User (Stored in `userlogin`)
        // -------------------------------------------------------------
        $this->db->group_start();
        if (!empty($email)) $this->db->where('EMAIL', $email);
        if (!empty($mobile)) $this->db->or_where('MOBILE', $mobile);
        $this->db->group_end();
        if ($this->db->count_all_results('userlogin') > 0) {
            return ['status' => 'error', 'message' => 'A user account with this Email or Mobile already exists.'];
        }

        // Begin Transaction
        $this->db->trans_start();

        $userlogin_data = array(
            'FNAME'      => trim($payload['fname'] ?? ''),
            'LNAME'      => trim($payload['lname'] ?? ''),
            'MOBILE'     => $mobile,
            'EMAIL'      => $email,
            'PASSWORD'   => md5($password),
            'GENDER'     => $payload['gender'] ?? 'Male',
            'DOB'        => !empty($payload['dob']) ? $payload['dob'] : null,
            'BGROUP'     => !empty($payload['blood_group']) ? $payload['blood_group'] : null,
            'HEIGHT'     => !empty($payload['height']) ? $payload['height'] : null,
            'WEIGHT'     => !empty($payload['weight']) ? $payload['weight'] : null,
            'STATUS'     => '1',
            'REG_DATE'   => date('Y-m-d H:i:s')
        );

        $this->db->insert('userlogin', $userlogin_data);
        $user_id = $this->db->insert_id();
        $medical_id = 'UPC-PAT-' . str_pad($user_id, 5, '0', STR_PAD_LEFT);

        // If Clinical Patient, initialize Patient Dossier in `patient_profiles`
        if ($role_type === 'patient') {
            $emergency_contact = '';
            if (!empty($payload['emergency_contact_phone'])) {
                $emergency_contact = trim($payload['emergency_contact_phone']);
                if (!empty($payload['emergency_contact_name'])) {
                    $emergency_contact .= ' (' . trim($payload['emergency_contact_name']) . ')';
                }
            }

            $profile_data = array(
                'user_id'            => $user_id,
                'medical_id'         => $medical_id,
                'emergency_contacts' => $emergency_contact,
                'blood_group'        => $userlogin_data['BGROUP'],
                'dob'                => $userlogin_data['DOB'],
                'gender'             => $userlogin_data['GENDER'],
                'allergies'          => !empty($payload['allergies']) ? trim($payload['allergies']) : 'None recorded',
                'medical_history'    => !empty($payload['medical_history']) ? trim($payload['medical_history']) : 'Initial dossier registered via admin portal.',
                'created_at'         => date('Y-m-d H:i:s')
            );

            if ($this->db->table_exists('patient_profiles')) {
                // Check if profile exists already
                $chk = $this->db->get_where('patient_profiles', array('user_id' => $user_id))->row();
                if ($chk) {
                    $this->db->where('user_id', $user_id)->update('patient_profiles', $profile_data);
                } else {
                    $this->db->insert('patient_profiles', $profile_data);
                }
            }

            // Provision Initial Patient Reward Wallet
            if ($this->db->table_exists('user_wallet')) {
                $chk_w = $this->db->get_where('user_wallet', array('user_id' => $user_id))->row();
                if (!$chk_w) {
                    $this->db->insert('user_wallet', array(
                        'user_id'             => $user_id,
                        'points_balance'      => 50.00,
                        'currency_equivalent' => 50.00,
                        'lifetime_earned'     => 50.00,
                        'status'              => '1',
                        'created_at'          => date('Y-m-d H:i:s')
                    ));
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['status' => 'error', 'message' => 'Database transaction failed while creating the account.'];
        }

        return [
            'status'     => 'success',
            'role'       => $role_type,
            'user_id'    => $user_id,
            'medical_id' => $medical_id,
            'email'      => $email,
            'mobile'     => $mobile,
            'name'       => trim($userlogin_data['FNAME'] . ' ' . $userlogin_data['LNAME']),
            'temp_pass'  => $password
        ];
    }
}
