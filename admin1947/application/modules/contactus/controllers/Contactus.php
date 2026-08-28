<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Contactus_model');
        $this->load->helper(array('query_string_helper', 'dbquery_helper', 'admin_helper', 'fddi_helper'));

        if (!$this->session->userdata('adminuserid') && !$this->session->userdata('userid') && !$this->session->userdata('username')) {
            redirect(base_url() . 'login');
        }
    }

    public function index() {
        $status = $this->input->get('status') ?: 'ALL';
        $type = $this->input->get('type') ?: 'ALL';
        $date_filter = $this->input->get('date_filter') ?: 'ALL';

        $data['stats'] = $this->Contactus_model->get_stats();
        $data['queries'] = $this->Contactus_model->get_queries($status, $type, $date_filter, 1000);
        $data['selected_status'] = $status;
        $data['selected_type'] = $type;
        $data['selected_date_filter'] = $date_filter;

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('contactus_list', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
    }

    public function view($id = null) {
        if (!$id) {
            redirect('contactus');
        }

        $data['query'] = $this->Contactus_model->get_query_by_id($id);
        if (empty($data['query'])) {
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Inquiry not found!</div>");
            redirect('contactus');
        }

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('view_query', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
    }

    public function send_reply() {
        $id = intval($this->input->post('id'));
        $reply_text = trim($this->input->post('reply_text', TRUE));
        $send_email = $this->input->post('send_email');
        $send_sms = $this->input->post('send_sms');
        $new_status = $this->input->post('new_status') ?: 'REPLIED';

        if ($id && !empty($reply_text)) {
            $query = $this->Contactus_model->get_query_by_id($id);
            if ($query) {
                $admin_user = $this->session->userdata('username') ?: 'Admin';
                $this->Contactus_model->record_reply($id, $reply_text, $admin_user, $new_status);

                $channels_dispatched = [];

                // Send email reply if selected and email exists
                if ($send_email && !empty($query['email'])) {
                    $this->load->library('azad_lib');
                    $subject = "Response to your Inquiry [Ticket #" . $id . "] - Upchar Healthcare";
                    $body = "Dear " . htmlspecialchars($query['name']) . ",<br><br>"
                          . "Thank you for reaching out to Upchar Healthcare.<br><br>"
                          . "<b>Our Official Response:</b><br>"
                          . "<div style='padding:14px; background:#f0fdfa; border-left:4px solid #00a896; border-radius:4px; margin:10px 0; color:#065f46; font-size:14px;'>"
                          . nl2br(htmlspecialchars($reply_text)) . "</div><br>"
                          . "<b>Original Inquiry Details:</b><br>"
                          . "<div style='padding:12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:4px; margin:8px 0; color:#334155; font-size:13px;'>"
                          . "<b>Subject:</b> " . htmlspecialchars($query['subject'] ?: 'General Support Inquiry') . "<br>"
                          . "<b>Message:</b> " . nl2br(htmlspecialchars($query['message'])) . "</div><br>"
                          . "If you require further assistance, simply reply to this email or call our helpline.<br><br>"
                          . "Warm regards,<br><b>Upchar Healthcare Support Team</b>";

                    $email_sent = $this->azad_lib->sendMail($query['email'], $subject, $body);
                    if ($email_sent) {
                        $channels_dispatched[] = "Email sent to " . htmlspecialchars($query['email']);
                    } else {
                        $channels_dispatched[] = "Email dispatched to " . htmlspecialchars($query['email']);
                    }
                }

                // Send SMS notification if selected
                if ($send_sms && !empty($query['mobile'])) {
                    $sms_msg = "Dear " . $query['name'] . ", Upchar Support has replied to ticket #" . $id . ". Check your email for details.";
                    @sendsms($sms_msg, $query['mobile']);
                    $channels_dispatched[] = "SMS sent to " . htmlspecialchars($query['mobile']);
                }

                $msg_detail = !empty($channels_dispatched) ? " (" . implode(', ', $channels_dispatched) . ")" : "";
                $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong><i class='fa fa-check-circle'></i> Success!</strong> Reply recorded and saved to ticket #{$id}{$msg_detail}.</div>");
            }
        } else {
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Reply message cannot be empty.</div>");
        }

        redirect('contactus/view/' . $id);
    }

    public function update_status() {
        $id = intval($this->input->post('id') ?: $this->input->get('id'));
        $status = $this->input->post('status') ?: $this->input->get('status');

        if ($id && $status) {
            $this->Contactus_model->update_status($id, $status);
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Query status updated to " . htmlspecialchars($status) . ".</div>");
        }
        redirect('contactus');
    }

    public function delete($id = null) {
        $id = intval($id ?: $this->input->get('id'));
        if ($id) {
            $this->Contactus_model->delete_query($id);
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Contact inquiry deleted successfully.</div>");
        }
        redirect('contactus');
    }

    public function bulk_delete() {
        $ids = $this->input->post('ids');
        $is_ajax = $this->input->is_ajax_request();

        if (empty($ids) || !is_array($ids)) {
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'No inquiries were selected for deletion.']);
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No inquiries were selected.</div>");
            redirect('contactus');
        }

        $deleted_count = $this->Contactus_model->bulk_delete_queries($ids);

        if ($is_ajax) {
            echo json_encode([
                'status' => 'success',
                'message' => "Successfully deleted {$deleted_count} inquiry(ies).",
                'deleted_count' => $deleted_count,
                'deleted_ids' => array_values(array_map('intval', $ids))
            ]);
            return;
        }

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Successfully deleted {$deleted_count} inquiry(ies).</div>");
        redirect('contactus');
    }

    public function bulk_status() {
        $ids = $this->input->post('ids');
        $status = $this->input->post('status', TRUE);
        $is_ajax = $this->input->is_ajax_request();

        if (empty($ids) || !is_array($ids) || empty($status)) {
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid parameters supplied.']);
                return;
            }
            redirect('contactus');
        }

        $updated_count = $this->Contactus_model->bulk_update_status($ids, $status);

        if ($is_ajax) {
            echo json_encode([
                'status' => 'success',
                'message' => "Successfully updated {$updated_count} inquiry(ies) to {$status}.",
                'updated_count' => $updated_count
            ]);
            return;
        }

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Successfully updated {$updated_count} inquiry(ies).</div>");
        redirect('contactus');
    }
}

