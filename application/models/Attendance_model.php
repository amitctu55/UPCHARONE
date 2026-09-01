<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Attendance Model
 * Geofenced GPS + Selfie Punch-in and Timesheet Engine
 */
class Attendance_model extends CI_Model {

    // Default Office Geolocation (Lucknow Central Hub)
    private $office_lat = 26.84670000;
    private $office_lng = 80.94620000;
    private $geofence_radius_km = 0.50; // 500 meters

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Calculate Distance between two GPS points using Haversine formula (in KM)
     */
    public function calculate_distance_km($lat1, $lng1, $lat2 = null, $lng2 = null) {
        $lat2 = ($lat2 !== null) ? $lat2 : $this->office_lat;
        $lng2 = ($lng2 !== null) ? $lng2 : $this->office_lng;

        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }

    /**
     * Get Today's Punch Record for a User
     */
    public function get_today_punch($userId, $date = null) {
        $date = $date ?: date('Y-m-d');
        return $this->db->get_where('staff_attendance', [
            'user_id'    => $userId,
            'punch_date' => $date
        ])->row_array();
    }

    /**
     * Record Check-in Punch
     */
    public function punch_in($userId, $lat, $lng, $selfieData = null, $notes = '') {
        $today = date('Y-m-d');
        $now   = date('Y-m-d H:i:s');
        $existing = $this->get_today_punch($userId, $today);

        if ($existing) {
            return ['status' => 'error', 'message' => 'You have already checked in today at ' . date('h:i A', strtotime($existing['check_in_time']))];
        }

        $distance = $this->calculate_distance_km($lat, $lng);

        // Determine status (Late if after 09:45 AM)
        $hour = intval(date('H'));
        $min  = intval(date('i'));
        $status = ($hour > 9 || ($hour == 9 && $min > 45)) ? 'late' : 'present';

        $insertData = [
            'user_id'                 => $userId,
            'punch_date'              => $today,
            'check_in_time'           => $now,
            'check_in_lat'            => $lat,
            'check_in_lng'            => $lng,
            'check_in_selfie'         => $selfieData,
            'distance_from_office_km' => $distance,
            'status'                  => $status,
            'working_hours'           => 0.00,
            'notes'                   => $notes
        ];

        $this->db->insert('staff_attendance', $insertData);
        $insertId = $this->db->insert_id();

        return [
            'status'      => 'success',
            'message'     => 'Punch-in successful! Marked as ' . strtoupper($status),
            'id'          => $insertId,
            'distance_km' => $distance,
            'is_in_bounds'=> ($distance <= $this->geofence_radius_km),
            'punch_time'  => date('h:i A', strtotime($now))
        ];
    }

    /**
     * Record Check-out Punch
     */
    public function punch_out($userId, $lat, $lng, $notes = '') {
        $today = date('Y-m-d');
        $now   = date('Y-m-d H:i:s');
        $punch = $this->get_today_punch($userId, $today);

        if (!$punch) {
            return ['status' => 'error', 'message' => 'No check-in record found for today. Please check in first.'];
        }
        if (!empty($punch['check_out_time'])) {
            return ['status' => 'error', 'message' => 'You have already checked out today at ' . date('h:i A', strtotime($punch['check_out_time']))];
        }

        // Calculate hours
        $checkInTs  = strtotime($punch['check_in_time']);
        $checkOutTs = strtotime($now);
        $diffHours  = round(($checkOutTs - $checkInTs) / 3600, 2);

        $status = $punch['status'];
        if ($diffHours < 4.0 && $status !== 'late') {
            $status = 'half_day';
        }

        $updateData = [
            'check_out_time' => $now,
            'check_out_lat'  => $lat,
            'check_out_lng'  => $lng,
            'working_hours'  => $diffHours,
            'status'         => $status
        ];

        if (!empty($notes)) {
            $updateData['notes'] = ($punch['notes'] ? $punch['notes'] . ' | ' : '') . $notes;
        }

        $this->db->where('id', $punch['id'])->update('staff_attendance', $updateData);

        return [
            'status'        => 'success',
            'message'       => 'Check-out recorded successfully! Total hours: ' . $diffHours . ' hrs',
            'working_hours' => $diffHours,
            'punch_time'    => date('h:i A', strtotime($now))
        ];
    }

    /**
     * Get Attendance Log for a User (Monthly)
     */
    public function get_user_logs($userId, $month = null, $year = null) {
        $month = $month ?: date('m');
        $year  = $year ?: date('Y');

        $this->db->where('user_id', $userId);
        $this->db->where('MONTH(punch_date)', $month);
        $this->db->where('YEAR(punch_date)', $year);
        $this->db->order_by('punch_date', 'DESC');
        return $this->db->get('staff_attendance')->result_array();
    }

    /**
     * Get Roster for All Staff for a specific Date
     */
    public function get_daily_roster($date = null) {
        $date = $date ?: date('Y-m-d');

        $this->db->select('u.id as user_id, u.name, u.staff_code, u.role, u.department, u.phone, a.id as attendance_id, a.check_in_time, a.check_out_time, a.check_in_selfie, a.distance_from_office_km, a.status as attendance_status, a.working_hours');
        $this->db->from('staff_users u');
        $this->db->join('staff_attendance a', "a.user_id = u.id AND a.punch_date = '{$date}'", 'left');
        $this->db->where('u.status', 'active');
        $this->db->order_by('u.role', 'ASC');
        return $this->db->get()->result_array();
    }
}
