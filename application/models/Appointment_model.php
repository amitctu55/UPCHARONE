<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_Model {

    public function get_user_appointments($user_id, $user_mobile = null) {
        if (!$user_id) {
            return array();
        }

        try {
            $userIds = array(intval($user_id));
            $userEmail = '';

            // Check userlogin
            if ($this->db->table_exists('userlogin')) {
                $uRow = $this->db->where('USERID', $user_id)->get('userlogin')->row();
                if ($uRow) {
                    if ($user_mobile === null && !empty($uRow->MOBILE)) {
                        $user_mobile = $uRow->MOBILE;
                    }
                    if (!empty($uRow->EMAIL)) {
                        $userEmail = $uRow->EMAIL;
                        if ($this->db->table_exists('upchar_users')) {
                            $mUser = $this->db->group_start()
                                              ->where('email', $uRow->EMAIL)
                                              ->or_where('mobile', $uRow->MOBILE)
                                              ->group_end()
                                              ->get('upchar_users')->row();
                            if ($mUser) {
                                $userIds[] = intval($mUser->id);
                            }
                        }
                    }
                }
            }

            // Check upchar_users if table exists
            if ($this->db->table_exists('upchar_users')) {
                $mUser = $this->db->where('id', $user_id)->get('upchar_users')->row();
                if ($mUser) {
                    $userIds[] = intval($mUser->id);
                    if ($user_mobile === null && !empty($mUser->mobile)) {
                        $user_mobile = $mUser->mobile;
                    }
                    if (!empty($mUser->email)) {
                        $userEmail = $mUser->email;
                        if ($this->db->table_exists('userlogin')) {
                            $uLegacy = $this->db->group_start()
                                                ->where('EMAIL', $mUser->email)
                                                ->or_where('MOBILE', $mUser->mobile)
                                                ->group_end()
                                                ->get('userlogin')->row();
                            if ($uLegacy) {
                                $userIds[] = intval($uLegacy->USERID);
                            }
                        }
                    }
                }
            }

            $userIds = array_values(array_unique(array_filter($userIds)));

            if (!$this->db->table_exists('appointment')) {
                return array();
            }

            $this->db->select('a.*, a.appointment_name as patient_name, d.fname as doctor_fname, d.lname as doctor_lname');
            $this->db->from('appointment a');
            if ($this->db->table_exists('profile_dr')) {
                $this->db->join('profile_dr d', 'd.id = a.doctor_id', 'left');
            }

            // Match by any linked user_id, mobile, or email
            $this->db->group_start();
            if (!empty($userIds)) {
                $this->db->where_in('a.user_id', $userIds);
            }
            if (!empty($user_mobile)) {
                $cleanMob = substr(preg_replace('/[^0-9]/', '', $user_mobile), -10);
                $this->db->or_where('a.appointment_mobile', $user_mobile);
                if (!empty($cleanMob)) {
                    $this->db->or_like('a.appointment_mobile', $cleanMob);
                }
            }
            if (!empty($userEmail)) {
                $this->db->or_where('a.appointment_email', $userEmail);
            }
            $this->db->group_end();

            $this->db->order_by('a.appointment_id', 'DESC');

            $query = $this->db->get();

            if ($query && $query->num_rows() > 0) {
                $results = $query->result();
                foreach ($results as $row) {
                    // Determine institute table (clinic or hospital)
                    $table = (!empty($row->institution_type) && $row->institution_type == 'C') ? 'clinic' : 'hospital';
                    $institute = null;
                    if ($this->db->table_exists($table)) {
                        $has_col = $this->db->field_exists('cancellation_hours', $table);
                        $select_cols = $has_col ? 'name, cancellation_hours, cancellation_policy_text' : 'name';
                        $institute = $this->db->select($select_cols)->where('id', $row->institute_id)->get($table)->row();
                    }
                    $row->institute_name = $institute ? $institute->name : 'Medical Center';
                    $row->cancellation_hours = ($institute && isset($institute->cancellation_hours) && $institute->cancellation_hours !== null) ? intval($institute->cancellation_hours) : 3;
                    $row->cancellation_policy_text = ($institute && !empty($institute->cancellation_policy_text)) ? $institute->cancellation_policy_text : 'Cancellations allowed up to 3 hours prior to consultation slot.';
                    
                    // Doctor name resolution with fallback
                    $doc_name = trim(($row->doctor_fname ?? '') . ' ' . ($row->doctor_lname ?? ''));
                    if (empty($doc_name) && !empty($row->doctor_id) && $this->db->table_exists('profile_dr')) {
                        $dr_fallback = $this->db->where('id', $row->doctor_id)->or_where('user_id', $row->doctor_id)->get('profile_dr')->row();
                        if ($dr_fallback) {
                            $doc_name = trim(($dr_fallback->fname ?: '') . ' ' . ($dr_fallback->lname ?: ''));
                        }
                    }
                    
                    if (!empty($doc_name)) {
                        $row->doctor_name = (stripos($doc_name, 'Dr.') === 0 || stripos($doc_name, 'Dr ') === 0) ? $doc_name : 'Dr. ' . $doc_name;
                    } else {
                        $row->doctor_name = 'Consultant Doctor';
                    }
                }
                return $results;
            }

            return array();
        } catch (\Throwable $e) {
            log_message('error', 'Appointment_model get_user_appointments error: ' . $e->getMessage());
            return array();
        }
    }
}