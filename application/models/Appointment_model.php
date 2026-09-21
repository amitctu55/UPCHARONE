<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_Model {

    public function get_user_appointments($user_id, $user_mobile = null) {
        if (!$user_id) {
            return array();
        }

        if ($user_mobile === null) {
            $user_row = $this->db->select('MOBILE')->where('USERID', $user_id)->get('userlogin')->row();
            $user_mobile = $user_row ? $user_row->MOBILE : '';
        }

        $this->db->select('a.*, a.appointment_name as patient_name, d.fname as doctor_fname, d.lname as doctor_lname');
        $this->db->from('appointment a');
        $this->db->join('profile_dr d', 'd.id = a.doctor_id', 'left');

        // Match by user_id or patient registered mobile so no appointment is missed
        $this->db->group_start();
        $this->db->where('a.user_id', $user_id);
        if (!empty($user_mobile)) {
            $this->db->or_where('a.appointment_mobile', $user_mobile);
        }
        $this->db->group_end();

        // Most recent bookings first
        $this->db->order_by('a.appointment_id', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $results = $query->result();
            foreach ($results as $row) {
                // Determine institute table (clinic or hospital)
                $table = (!empty($row->institution_type) && $row->institution_type == 'C') ? 'clinic' : 'hospital';
                $institute = $this->db->select('name')->where('id', $row->institute_id)->get($table)->row();
                $row->institute_name = $institute ? $institute->name : 'Medical Center';
                
                // Doctor name resolution with fallback
                $doc_name = trim(($row->doctor_fname ?: '') . ' ' . ($row->doctor_lname ?: ''));
                if (empty($doc_name) && !empty($row->doctor_id)) {
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
    }
}
