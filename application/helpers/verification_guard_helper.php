<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Reusable Verification Guard Helper for Upchar Healthcare Platform
 * Enforces acquisition onboarding verification across Hospitals, Doctors, Clinics, and Pathlabs.
 */
if (!function_exists('enforce_verification_guard')) {
    /**
     * Enforces verification check on current logged in entity.
     *
     * @param string $entity_type 'hospital' | 'doctor' | 'clinic' | 'pathlab'
     * @param int|string $entity_id Entity primary key or UID
     * @param array $allowed_methods Controller methods exempt from lock (e.g. ['account_pending', 'logout', 'login', 'signup'])
     * @return object|bool Returns entity record if verified, or redirects to account_pending
     */
    function enforce_verification_guard($entity_type = 'hospital', $entity_id = 0, $allowed_methods = array()) {
        $CI =& get_instance();
        
        $current_method = $CI->router->fetch_method();
        $default_exemptions = array('account_pending', 'logout', 'login', 'signup', 'verifymobile', 'forgotpassword');
        $exemptions = array_merge($default_exemptions, $allowed_methods);

        if (in_array($current_method, $exemptions)) {
            return true;
        }

        if (empty($entity_id)) {
            return false;
        }

        $table = 'hospital';
        $id_col = 'id';

        switch (strtolower($entity_type)) {
            case 'doctor':
                $table = 'profile_dr';
                $id_col = 'id';
                break;
            case 'clinic':
                $table = 'clinic';
                $id_col = 'id';
                break;
            case 'pathlab':
            case 'pathology':
                $table = 'pathlab';
                $id_col = 'id';
                break;
            case 'hospital':
            default:
                $table = 'hospital';
                $id_col = 'id';
                break;
        }

        // Query entity record
        $CI->db->group_start();
        $CI->db->where($id_col, $entity_id);
        if ($table == 'hospital' || $table == 'pathlab') {
            $CI->db->or_where('uid', $entity_id);
        }
        $CI->db->group_end();
        
        $entity = $CI->db->get($table)->row();

        if (!$entity) {
            return false;
        }

        // Verification Rule: Must be 'verified' AND is_active == 1
        $is_verified = (isset($entity->verification_status) && $entity->verification_status === 'verified');
        $is_active   = (isset($entity->is_active) && (int)$entity->is_active === 1);

        // Fallback for legacy approved flag if verification_status is not set
        if (!isset($entity->verification_status) && isset($entity->approved) && $entity->approved == '1') {
            $is_verified = true;
            $is_active   = true;
        }

        if (!$is_verified || !$is_active) {
            // Determine redirect route based on entity
            $pending_route = 'hospitalpanel/account_pending';
            if ($entity_type == 'doctor') {
                $pending_route = 'doctorpanel/account_pending';
            } elseif ($entity_type == 'clinic') {
                $pending_route = 'clinicpanel/account_pending';
            } elseif ($entity_type == 'pathlab') {
                $pending_route = 'pathlabpanel/account_pending';
            }

            redirect($pending_route);
            exit();
        }

        return $entity;
    }
}
