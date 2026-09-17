<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Attendance Controller
 * Mobile Geofenced GPS & Biometric Selfie Punch-in Engine
 */
class Attendance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Attendance_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('admin_auth_guard');
        $this->admin_auth_guard->enforce_admin();
    }

    /**
     * Attendance Roster Desk Forwarder / Alias
     */
    public function roster() {
        $date = $this->input->get('date') ?: date('Y-m-d');
        $search = $this->input->get('search');
        $url = 'hr/attendance?date=' . urlencode($date);
        if ($search !== null && $search !== '') {
            $url .= '&search=' . urlencode($search);
        }
        redirect($url);
    }

    /**
     * Mobile & Web Biometric Punch Terminal Screen
     */
    public function punch() {
        $activeId = intval($this->input->get('staff_id')) ?: $this->session->userdata('staff_user_id');
        $today    = date('Y-m-d');

        $user = $this->Staff_model->get_user_by_id($activeId);
        if (!$user) {
            $user = $this->Staff_model->get_user_by_id($this->session->userdata('staff_user_id'));
            $activeId = $user ? $user['id'] : 1;
        }

        $data['user']        = $user;
        $data['today_punch'] = $this->Attendance_model->get_today_punch($activeId, $today);
        $data['all_staff']   = $this->db->where('status', 'active')->order_by('id', 'asc')->get('staff_users')->result_array();
        $data['recent_logs'] = $this->Attendance_model->get_user_logs($activeId, date('m'), date('Y'));

        // Compute monthly summary statistics
        $totalLogs   = count($data['recent_logs']);
        $onTimeCount = 0;
        $lateCount   = 0;
        $totalHours  = 0.0;
        foreach ($data['recent_logs'] as $log) {
            if ($log['status'] === 'present') {
                $onTimeCount++;
            } elseif ($log['status'] === 'late') {
                $lateCount++;
            }
            $totalHours += floatval($log['working_hours'] ?? 0);
        }

        $data['month_stats'] = [
            'total_logs'   => $totalLogs,
            'on_time_count'=> $onTimeCount,
            'late_count'   => $lateCount,
            'total_hours'  => round($totalHours, 1),
            'avg_hours'    => ($totalLogs > 0) ? round($totalHours / $totalLogs, 1) : 0.0,
            'punctuality'  => ($totalLogs > 0) ? round(($onTimeCount / $totalLogs) * 100) : 100
        ];

        $this->load->view('hr/header', $data);
        $this->load->view('attendance/punch', $data);
        $this->load->view('hr/footer');
    }

    /**
     * Reset Today's Punch (For Testing & Demo)
     */
    public function reset_today_punch() {
        $userId = intval($this->input->get_post('staff_id')) ?: $this->session->userdata('staff_user_id');
        $today  = date('Y-m-d');
        
        $this->db->where(['user_id' => $userId, 'punch_date' => $today])->delete('staff_attendance');
        
        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status'    => 'success', 
                'message'   => "Today's attendance punch reset successfully for staff #{$userId}."
            ]);
            return;
        }

        $this->session->set_flashdata('success_msg', "Today's attendance punch reset successfully.");
        redirect('attendance/punch' . ($userId ? '?staff_id=' . $userId : ''));
    }

    /**
     * AJAX: Submit Punch In
     */
    public function record_punch_in() {
        $userId = intval($this->input->post('user_id')) ?: $this->session->userdata('staff_user_id');
        $lat    = floatval($this->input->post('lat')) ?: 26.8467;
        $lng    = floatval($this->input->post('lng')) ?: 80.9462;
        $notes  = trim($this->input->post('notes', TRUE)) ?: 'Mobile WebRTC Punch';

        // Process selfie: check uploaded file first, then base64 string
        $selfiePath = null;

        // 1. Direct file upload
        if (!empty($_FILES['selfie_file']['name']) && $_FILES['selfie_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = FCPATH . 'uploads/attendance/';
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }
            $ext = strtolower(pathinfo($_FILES['selfie_file']['name'], PATHINFO_EXTENSION)) ?: 'jpg';
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $ext = 'jpg';
            }
            $filename = 'selfie_' . $userId . '_' . date('Ymd_His') . '_' . substr(md5(uniqid()), 0, 6) . '.' . $ext;
            if (move_uploaded_file($_FILES['selfie_file']['tmp_name'], $uploadDir . $filename)) {
                $selfiePath = 'uploads/attendance/' . $filename;
            }
        }

        // 2. Base64 payload from WebRTC / canvas
        if (empty($selfiePath)) {
            $rawSelfie = $this->input->post('selfie');
            if (empty($rawSelfie) && !empty($_POST['selfie'])) {
                $rawSelfie = $_POST['selfie'];
            }

            if (!empty($rawSelfie)) {
                $cleanSelfie = $rawSelfie;
                // Handle CI xss_clean prefix replacement
                if (strpos($cleanSelfie, '[removed]') === 0) {
                    $cleanSelfie = substr($cleanSelfie, 9);
                } elseif (preg_match('/^data:image\/(\w+);base64,/', $cleanSelfie, $m)) {
                    $cleanSelfie = substr($cleanSelfie, strpos($cleanSelfie, ',') + 1);
                }

                $cleanSelfie = str_replace(' ', '+', $cleanSelfie);
                $decoded = base64_decode($cleanSelfie);

                if ($decoded !== false && strlen($decoded) > 100) {
                    $uploadDir = FCPATH . 'uploads/attendance/';
                    if (!is_dir($uploadDir)) {
                        @mkdir($uploadDir, 0777, true);
                    }
                    $filename = 'selfie_' . $userId . '_' . date('Ymd_His') . '_' . substr(md5(uniqid()), 0, 6) . '.jpg';
                    if (@file_put_contents($uploadDir . $filename, $decoded)) {
                        $selfiePath = 'uploads/attendance/' . $filename;
                    }
                }
            }
        }

        // Fallback: if no image saved, keep raw payload or null
        $finalSelfie = $selfiePath ?: null;

        $res = $this->Attendance_model->punch_in($userId, $lat, $lng, $finalSelfie, $notes);
        if ($selfiePath) {
            $res['selfie_url'] = base_url($selfiePath);
        }
        $res['csrf_hash'] = $this->security->get_csrf_hash();

        echo json_encode($res);
    }

    /**
     * AJAX: Submit Punch Out
     */
    public function record_punch_out() {
        $userId = intval($this->input->post('user_id')) ?: $this->session->userdata('staff_user_id');
        $lat    = floatval($this->input->post('lat')) ?: 26.8467;
        $lng    = floatval($this->input->post('lng')) ?: 80.9462;
        $notes  = trim($this->input->post('notes', TRUE)) ?: 'End of Day Check-out';

        $res = $this->Attendance_model->punch_out($userId, $lat, $lng, $notes);
        $res['csrf_hash'] = $this->security->get_csrf_hash();
        echo json_encode($res);
    }

    /**
     * Monthly Punch History
     */
    public function history() {
        $userId = intval($this->input->get('staff_id')) ?: $this->session->userdata('staff_user_id');
        $month  = $this->input->get('month') ?: date('m');
        $year   = $this->input->get('year') ?: date('Y');

        $data['user']      = $this->Staff_model->get_user_by_id($userId);
        $data['all_staff'] = $this->db->where('status', 'active')->order_by('id', 'asc')->get('staff_users')->result_array();
        $data['logs']      = $this->Attendance_model->get_user_logs($userId, $month, $year);
        $data['month']     = $month;
        $data['year']      = $year;

        $this->load->view('hr/header', $data);
        $this->load->view('attendance/history', $data);
        $this->load->view('hr/footer');
    }
}
