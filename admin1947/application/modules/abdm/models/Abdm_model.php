<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Abdm_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // ABHA Management
    public function link_abha($user_id, $abha_address = null) {
        // Implementation for linking ABHA ID
        $data = array(
            'user_id' => $user_id,
            'abha_address' => $abha_address,
            'abha_number' => $this->generate_abha_number(),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('abdm_users', $data);
    }

    public function verify_abha($abha_address, $otp) {
        // Implementation for verifying ABHA ID
        $this->db->where('abha_address', $abha_address);
        $this->db->where('status', 'pending');
        $user = $this->db->get('abdm_users')->row_array();

        if ($user) {
            // In a real implementation, you would verify the OTP with ABDM gateway
            // For now, we'll simulate successful verification
            $update_data = array(
                'status' => 'active',
                'verified_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $user['id']);
            return $this->db->update('abdm_users', $update_data);
        }

        return false;
    }

    // Consent Management
    public function give_consent($user_id, $abha_address, $care_context, $purpose, $data_types,
                               $health_facility_ids = array(), $health_professional_ids = array(),
                               $start_date = null, $end_date = null) {
        // Implementation for giving consent
        $data = array(
            'user_id' => $user_id,
            'abha_address' => $abha_address,
            'care_context' => $care_context,
            'purpose' => $purpose,
            'data_types' => json_encode($data_types),
            'health_facility_ids' => json_encode($health_facility_ids),
            'health_professional_ids' => json_encode($health_professional_ids),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => 'active',
            'consent_timestamp' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('abdm_consent', $data);
    }

    public function revoke_consent($consent_id) {
        // Implementation for revoking consent
        $data = array(
            'status' => 'revoked',
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $consent_id);
        return $this->db->update('abdm_consent', $data);
    }

    // HPR Registration
    public function hpr_register($doctor_id, $registration_number, $state_medical_council,
                               $qualifications = array(), $specializations = array()) {
        // Implementation for HPR registration
        $data = array(
            'doctor_id' => $doctor_id,
            'registration_number' => $registration_number,
            'state_medical_council' => $state_medical_council,
            'qualifications' => json_encode($qualifications),
            'specializations' => json_encode($specializations),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('abdm_hpr_registrations', $data);
    }

    public function hpr_status($doctor_id) {
        // Implementation for checking HPR status
        $this->db->where('doctor_id', $doctor_id);
        return $this->db->get('abdm_hpr_registrations')->row_array();
    }

    // HFR Registration
    public function hfr_register($facility_type, $facility_id, $name, $address, $city, $state, $pincode,
                               $contact_person = null, $contact_phone = null, $contact_email = null,
                               $facility_details = array()) {
        // Implementation for HFR registration
        $data = array(
            'facility_type' => $facility_type,
            'facility_id' => $facility_id,
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'pincode' => $pincode,
            'contact_person' => $contact_person,
            'contact_phone' => $contact_phone,
            'contact_email' => $contact_email,
            'facility_details' => json_encode($facility_details),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('abdm_hfr_registrations', $data);
    }

    public function hfr_status($facility_id, $facility_type) {
        // Implementation for checking HFR status
        $this->db->where('facility_id', $facility_id);
        $this->db->where('facility_type', $facility_type);
        return $this->db->get('abdm_hfr_registrations')->row_array();
    }

    // Helper function to generate ABHA number (14 digits)
    private function generate_abha_number() {
        // Generate a 14-digit number (in reality, this would come from ABDM gateway)
        return sprintf('%014d', mt_rand(1, 99999999999999));
    }

    // Dashboard statistics
    public function get_abdm_stats() {
        $stats = array(
            'total_abha_ids' => 0,
            'active_abha_ids' => 0,
            'total_consent_records' => 0,
            'active_consent_records' => 0,
            'total_hpr_registrations' => 0,
            'approved_hpr_registrations' => 0,
            'total_hfr_registrations' => 0,
            'approved_hfr_registrations' => 0,
        );

        if (!$this->db->table_exists('abdm_users')) {
            return $stats;
        }

        // Total ABHA IDs
        $stats['total_abha_ids'] = $this->db->count_all_results('abdm_users');

        // Active ABHA IDs
        $stats['active_abha_ids'] = $this->db->where('status', 'active')->count_all_results('abdm_users');

        // Total consent records
        if ($this->db->table_exists('abdm_consent')) {
            $stats['total_consent_records'] = $this->db->count_all_results('abdm_consent');
            $stats['active_consent_records'] = $this->db->where('status', 'active')->count_all_results('abdm_consent');
        }

        // Total HPR registrations
        if ($this->db->table_exists('abdm_hpr_registrations')) {
            $stats['total_hpr_registrations'] = $this->db->count_all_results('abdm_hpr_registrations');
            $stats['approved_hpr_registrations'] = $this->db->where('status', 'approved')->count_all_results('abdm_hpr_registrations');
        }

        // Total HFR registrations
        if ($this->db->table_exists('abdm_hfr_registrations')) {
            $stats['total_hfr_registrations'] = $this->db->count_all_results('abdm_hfr_registrations');
            $stats['approved_hfr_registrations'] = $this->db->where('status', 'approved')->count_all_results('abdm_hfr_registrations');
        }

        return $stats;
    }
}