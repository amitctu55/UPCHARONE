<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-hover: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.inquiry-dash-container {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.inquiry-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.inquiry-page-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--upchar-slate);
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.inquiry-page-subtitle {
    font-size: 13.5px;
    color: var(--upchar-gray);
    margin: 0;
}

/* Metric Stats Cards */
.inquiry-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.inquiry-stat-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.inquiry-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.inquiry-stat-info h4 {
    font-size: 12.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: var(--upchar-gray);
    margin: 0 0 6px 0;
}

.inquiry-stat-info .stat-number {
    font-size: 26px;
    font-weight: 800;
    color: var(--upchar-slate);
    line-height: 1;
}

.inquiry-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-icon-total { background: #e0f2fe; color: #0284c7; }
.stat-icon-pending { background: #fef3c7; color: #d97706; }
.stat-icon-replied { background: #dcfce7; color: #16a34a; }
.stat-icon-closed { background: #f1f5f9; color: #64748b; }

/* Filter & Search Bar */
.inquiry-filter-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 14px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}

.inquiry-status-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.inquiry-tab-btn {
    padding: 7px 16px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    color: var(--upchar-gray);
    background: #f1f5f9;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.inquiry-tab-btn:hover {
    color: var(--upchar-navy);
    background: #e2e8f0;
}

.inquiry-tab-btn.active {
    background: var(--upchar-navy);
    color: #ffffff;
}

.inquiry-search-form {
    display: flex;
    align-items: center;
    gap: 8px;
}

.inquiry-search-input {
    height: 38px;
    border-radius: 8px;
    border: 1px solid var(--upchar-border);
    padding: 6px 12px;
    font-size: 13px;
    width: 240px;
    outline: none;
}

.inquiry-search-input:focus {
    border-color: var(--upchar-teal);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

/* Master Inquiries Table */
.inquiry-table-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
}

.inquiry-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}

.inquiry-table thead th {
    background: #f8fafc;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 14px 18px;
    border-bottom: 1.5px solid var(--upchar-border);
    border-top: none;
}

.inquiry-table tbody td {
    padding: 16px 18px;
    vertical-align: top;
    border-top: 1px solid var(--upchar-border);
    font-size: 13.5px;
    color: #1e293b;
}

.inquiry-table tbody tr:hover {
    background: #fafbfc;
}

/* Status Badges */
.status-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: capitalize;
}

.badge-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.badge-replied { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.badge-closed  { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

.btn-reply-action {
    background: var(--upchar-teal);
    color: #ffffff !important;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 12.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none !important;
}

.btn-reply-action:hover {
    background: var(--upchar-teal-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0, 168, 150, 0.3);
}

.btn-status-toggle {
    background: transparent;
    border: 1px solid var(--upchar-border);
    color: var(--upchar-gray);
    border-radius: 8px;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
}

.btn-status-toggle:hover {
    background: #f1f5f9;
    color: var(--upchar-slate);
}

.response-box-preview {
    background: #f0fdf4;
    border-left: 3px solid #16a34a;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 12.5px;
    color: #14532d;
    margin-top: 6px;
}
</style>

<div class="inquiry-dash-container">
    <!-- Breadcrumb & Header -->
    <div class="inquiry-page-header">
        <div>
            <h1 class="inquiry-page-title">
                <i class="fa fa-envelope-open-text" style="color: var(--upchar-teal);"></i> Patient &amp; Admission Inquiries
            </h1>
            <p class="inquiry-page-subtitle">
                View, manage, and respond to incoming patient queries submitted through your public hospital profile
            </p>
        </div>
        <div>
            <a href="<?=base_url('hospital/' . $this->did);?>" target="_blank" class="btn btn-default" style="border-radius: 8px; font-weight: 600; font-size: 13px; padding: 8px 16px; border: 1px solid var(--upchar-border);">
                <i class="fa fa-external-link" style="color: var(--upchar-teal); margin-right: 6px;"></i> View Public Profile
            </a>
        </div>
    </div>

    <!-- Flash Notifications -->
    <?php if($this->session->flashdata('flashmsg')): ?>
        <?=$this->session->flashdata('flashmsg');?>
    <?php endif; ?>

    <!-- Summary Metrics -->
    <div class="inquiry-stats-grid">
        <div class="inquiry-stat-card">
            <div class="inquiry-stat-info">
                <h4>Total Inquiries</h4>
                <div class="stat-number"><?=$total_count;?></div>
            </div>
            <div class="inquiry-stat-icon stat-icon-total">
                <i class="fa fa-inbox"></i>
            </div>
        </div>

        <div class="inquiry-stat-card">
            <div class="inquiry-stat-info">
                <h4>Pending Response</h4>
                <div class="stat-number" style="color: #d97706;"><?=$pending_count;?></div>
            </div>
            <div class="inquiry-stat-icon stat-icon-pending">
                <i class="fa fa-clock-o"></i>
            </div>
        </div>

        <div class="inquiry-stat-card">
            <div class="inquiry-stat-info">
                <h4>Replied</h4>
                <div class="stat-number" style="color: #16a34a;"><?=$replied_count;?></div>
            </div>
            <div class="inquiry-stat-icon stat-icon-replied">
                <i class="fa fa-check-circle-o"></i>
            </div>
        </div>

        <div class="inquiry-stat-card">
            <div class="inquiry-stat-info">
                <h4>Closed / Resolved</h4>
                <div class="stat-number" style="color: #64748b;"><?=$closed_count;?></div>
            </div>
            <div class="inquiry-stat-icon stat-icon-closed">
                <i class="fa fa-archive"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="inquiry-filter-card">
        <div class="inquiry-status-tabs">
            <a href="<?=base_url('hospitalpanel/inquiries?status=all' . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : ''));?>" class="inquiry-tab-btn <?=$active_status == 'all' ? 'active' : '';?>">
                All Inquiries (<?=$total_count;?>)
            </a>
            <a href="<?=base_url('hospitalpanel/inquiries?status=pending' . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : ''));?>" class="inquiry-tab-btn <?=$active_status == 'pending' ? 'active' : '';?>">
                Pending (<?=$pending_count;?>)
            </a>
            <a href="<?=base_url('hospitalpanel/inquiries?status=replied' . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : ''));?>" class="inquiry-tab-btn <?=$active_status == 'replied' ? 'active' : '';?>">
                Replied (<?=$replied_count;?>)
            </a>
            <a href="<?=base_url('hospitalpanel/inquiries?status=closed' . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : ''));?>" class="inquiry-tab-btn <?=$active_status == 'closed' ? 'active' : '';?>">
                Closed (<?=$closed_count;?>)
            </a>
        </div>

        <form action="<?=base_url('hospitalpanel/inquiries');?>" method="GET" class="inquiry-search-form">
            <input type="hidden" name="status" value="<?=$active_status;?>">
            <input type="text" name="keyword" value="<?=$keyword;?>" placeholder="Search patient, phone, query..." class="inquiry-search-input">
            <button type="submit" class="btn btn-default" style="height: 38px; border-radius: 8px; border: 1px solid var(--upchar-border);">
                <i class="fa fa-search"></i>
            </button>
            <?php if(!empty($keyword)): ?>
                <a href="<?=base_url('hospitalpanel/inquiries?status=' . $active_status);?>" class="btn btn-default" style="height: 38px; border-radius: 8px; border: 1px solid var(--upchar-border);" title="Clear Search">
                    <i class="fa fa-times"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Master Inquiries Table -->
    <div class="inquiry-table-card">
        <div class="table-responsive">
            <table class="table inquiry-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">Received Date</th>
                        <th style="width: 220px;">Patient / Inquirer</th>
                        <th>Subject &amp; Message</th>
                        <th style="width: 110px;">Status</th>
                        <th style="width: 170px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($inquiries)): foreach($inquiries as $inq): 
                        $statusClass = 'badge-pending';
                        if ($inq->status == 'replied') $statusClass = 'badge-replied';
                        elseif ($inq->status == 'closed') $statusClass = 'badge-closed';
                    ?>
                    <tr>
                        <!-- Received Date -->
                        <td>
                            <strong style="color: var(--upchar-slate); display: block;"><?=date('d M Y', strtotime($inq->created_at));?></strong>
                            <small style="color: var(--upchar-gray); font-size: 11.5px;"><?=date('h:i A', strtotime($inq->created_at));?></small>
                            <span style="display: block; font-size: 11px; color: #94a3b8; margin-top: 4px;">#INQ-<?=$inq->id;?></span>
                        </td>

                        <!-- Patient Info -->
                        <td>
                            <div style="font-weight: 700; color: var(--upchar-slate); font-size: 14px; margin-bottom: 2px;">
                                <?=htmlspecialchars($inq->user_name);?>
                            </div>
                            <div style="font-size: 12.5px; color: var(--upchar-gray); margin-bottom: 2px;">
                                <a href="tel:<?=htmlspecialchars($inq->user_phone);?>" style="color: #0284c7; text-decoration: none;">
                                    <i class="fa fa-phone" style="margin-right: 4px;"></i> <?=htmlspecialchars($inq->user_phone);?>
                                </a>
                            </div>
                            <div style="font-size: 12px; color: var(--upchar-gray);">
                                <a href="mailto:<?=htmlspecialchars($inq->user_email);?>" style="color: #475569; text-decoration: none;">
                                    <i class="fa fa-envelope-o" style="margin-right: 4px;"></i> <?=htmlspecialchars($inq->user_email);?>
                                </a>
                            </div>
                        </td>

                        <!-- Message & Subject -->
                        <td>
                            <div style="font-weight: 700; color: var(--upchar-navy); margin-bottom: 4px;">
                                <i class="fa fa-bookmark-o" style="color: var(--upchar-teal); margin-right: 4px;"></i>
                                <?=htmlspecialchars($inq->subject ?: 'General Hospital Enquiry');?>
                            </div>
                            <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.5; white-space: pre-line;">
                                <?=htmlspecialchars($inq->message);?>
                            </p>

                            <!-- Hospital Response Preview if any -->
                            <?php if(!empty($inq->reply_message)): ?>
                                <div class="response-box-preview">
                                    <strong><i class="fa fa-reply"></i> Hospital Response:</strong><br>
                                    <?=nl2br(htmlspecialchars($inq->reply_message));?>
                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- Status -->
                        <td>
                            <span class="status-badge-pill <?=$statusClass;?>">
                                <i class="fa <?=$inq->status == 'replied' ? 'fa-check' : ($inq->status == 'pending' ? 'fa-hourglass-start' : 'fa-check-square-o');?>"></i>
                                <?=ucfirst($inq->status);?>
                            </span>
                        </td>

                        <!-- Actions -->
                        <td style="text-align: right;">
                            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 6px;">
                                <button type="button" class="btn-reply-action" 
                                    onclick="openReplyModal('<?=$inq->id;?>', '<?=htmlspecialchars(addslashes($inq->user_name));?>', '<?=htmlspecialchars(addslashes($inq->subject ?: 'Hospital Enquiry'));?>', '<?=htmlspecialchars(addslashes(str_replace(array("\r", "\n"), ' ', $inq->message)));?>', '<?=htmlspecialchars(addslashes($inq->reply_message ?? ''));?>', '<?=$inq->status;?>')">
                                    <i class="fa fa-reply"></i> <?=(!empty($inq->reply_message)) ? 'Edit Reply' : 'Send Reply';?>
                                </button>

                                <?php if($inq->status != 'closed'): ?>
                                    <a href="<?=base_url('hospitalpanel/update_inquiry_status/' . $inq->id . '/closed');?>" class="btn-status-toggle" onclick="return confirm('Mark inquiry as closed?');" title="Mark Closed">
                                        <i class="fa fa-archive"></i> Mark Closed
                                    </a>
                                <?php else: ?>
                                    <a href="<?=base_url('hospitalpanel/update_inquiry_status/' . $inq->id . '/pending');?>" class="btn-status-toggle" title="Reopen Inquiry">
                                        <i class="fa fa-undo"></i> Reopen
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px 20px; color: var(--upchar-gray);">
                            <div style="font-size: 38px; color: #cbd5e1; margin-bottom: 12px;">
                                <i class="fa fa-inbox"></i>
                            </div>
                            <h4 style="font-size: 16px; font-weight: 700; color: var(--upchar-slate); margin-bottom: 4px;">No inquiries found</h4>
                            <p style="font-size: 13px; margin: 0;">There are currently no patient inquiries under this category.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Reply to Inquiry -->
<div class="modal fade" id="replyInquiryModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true" style="z-index: 10500;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 520px; margin: 30px auto;">
        <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;">
            <div class="modal-header" style="background: var(--upchar-navy); color: #ffffff; padding: 18px 22px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.8; text-shadow: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="replyModalLabel" style="font-size: 17px; font-weight: 700; margin: 0; color: #ffffff;">
                    <i class="fa fa-reply" style="color: var(--upchar-teal); margin-right: 6px;"></i> Reply to Patient Inquiry
                </h4>
            </div>

            <form action="<?=base_url('hospitalpanel/reply_inquiry');?>" method="POST">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="inquiry_id" id="modal_inquiry_id" value="">

                <div class="modal-body" style="padding: 22px; background: #ffffff;">
                    <!-- Patient Summary Card -->
                    <div style="background: #f8fafc; border: 1px solid var(--upchar-border); border-radius: 8px; padding: 12px 16px; margin-bottom: 18px;">
                        <div style="font-size: 12px; color: var(--upchar-gray);">Patient: <strong id="modal_patient_name" style="color: var(--upchar-slate);"></strong></div>
                        <div style="font-size: 12.5px; color: var(--upchar-navy); font-weight: 700; margin-top: 3px;" id="modal_inquiry_subject"></div>
                        <div style="font-size: 12px; color: #475569; margin-top: 6px; font-style: italic;" id="modal_inquiry_message"></div>
                    </div>

                    <!-- Hospital Response -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 13px; font-weight: 700; color: var(--upchar-slate); margin-bottom: 6px; display: block;">
                            Hospital Reply / Response <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea name="reply_message" id="modal_reply_message" class="form-control" rows="5" placeholder="Type your response to the patient inquiry here..." required style="border-radius: 8px; border: 1.5px solid var(--upchar-border); padding: 10px 14px; font-size: 13.5px;"></textarea>
                    </div>

                    <!-- Status Selection -->
                    <div class="form-group" style="margin-bottom: 8px;">
                        <label style="font-size: 13px; font-weight: 700; color: var(--upchar-slate); margin-bottom: 6px; display: block;">
                            Update Inquiry Status
                        </label>
                        <select name="status" id="modal_inquiry_status" class="form-control" style="height: 40px; border-radius: 8px; border: 1.5px solid var(--upchar-border); font-size: 13px;">
                            <option value="replied">Replied (Active &amp; Response Documented)</option>
                            <option value="closed">Closed (Resolution Finished)</option>
                            <option value="pending">Keep as Pending</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 14px 22px; background: #f8fafc; border-top: 1px solid var(--upchar-border); display: flex; justify-content: flex-end; gap: 8px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-size: 13px; font-weight: 600;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="background: var(--upchar-teal); border-color: var(--upchar-teal); border-radius: 8px; font-size: 13px; font-weight: 700; padding: 8px 20px;">
                        <i class="fa fa-paper-plane" style="margin-right: 4px;"></i> Save &amp; Submit Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openReplyModal(id, patientName, subject, message, existingReply, currentStatus) {
    $('#modal_inquiry_id').val(id);
    $('#modal_patient_name').text(patientName);
    $('#modal_inquiry_subject').text(subject);
    $('#modal_inquiry_message').text('"' + message + '"');
    $('#modal_reply_message').val(existingReply || '');
    if (currentStatus) {
        $('#modal_inquiry_status').val(currentStatus);
    } else {
        $('#modal_inquiry_status').val('replied');
    }
    $('#replyInquiryModal').modal('show');
}
</script>

<?php include ("assets/includes/footer_hospital.php"); ?>
