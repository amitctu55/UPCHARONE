<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.thread-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.thread-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.thread-header-card h1 {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 6px 0;
}

.btn-back-link {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: #475569 !important;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-back-link:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}

.btn-resolve-ticket {
    background: #10b981;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 12.5px;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-resolve-ticket:hover {
    background: #059669;
}

.thread-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}

@media (max-width: 900px) {
    .thread-grid {
        grid-template-columns: 1fr;
    }
}

/* Original Issue Card */
.issue-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
}

.issue-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}

.sender-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #e0f2fe;
    color: #0369a1;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.admin-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #043d5b;
    color: #ffffff;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.msg-bubble {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 20px;
    margin-bottom: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.msg-bubble.admin-msg {
    border-left: 4px solid #00a896;
    background: #f0fdfa;
}

.msg-bubble.hospital-msg {
    border-left: 4px solid #043d5b;
    background: #ffffff;
}

.reply-box-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 22px 24px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
}

.btn-send-reply {
    background: #00a896;
    color: #ffffff;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px 24px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-send-reply:hover {
    background: #008f80;
}

/* Badges */
.badge-p-low { background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px; }
.badge-p-medium { background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px; }
.badge-p-high { background: #fef3c7; color: #b45309; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px; }
.badge-p-urgent { background: #fee2e2; color: #b91c1c; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 11px; }

.badge-s-open { background: #fef9c3; color: #854d0e; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 11.5px; }
.badge-s-inprogress { background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 11.5px; }
.badge-s-resolved { background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 11.5px; }
.badge-s-closed { background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 11.5px; }
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="thread-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <?php 
        $is_closed = ($ticket->status == 'Closed' || $ticket->status == 'Resolved');
        $p_class = 'badge-p-medium';
        if ($ticket->priority == 'Low') $p_class = 'badge-p-low';
        elseif ($ticket->priority == 'High') $p_class = 'badge-p-high';
        elseif ($ticket->priority == 'Urgent') $p_class = 'badge-p-urgent';

        $s_class = 'badge-s-open';
        if ($ticket->status == 'In Progress') $s_class = 'badge-s-inprogress';
        elseif ($ticket->status == 'Resolved') $s_class = 'badge-s-resolved';
        elseif ($ticket->status == 'Closed') $s_class = 'badge-s-closed';
        ?>

        <!-- Header Card -->
        <div class="thread-header-card">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <span style="font-weight: 800; font-size: 16px; color: #00a896;"><?=html_escape($ticket->ticket_code);?></span>
                    <span class="<?=$s_class;?>"><i class="fa fa-circle" style="font-size: 8px;"></i> <?=html_escape($ticket->status);?></span>
                    <span class="<?=$p_class;?>"><?=html_escape($ticket->priority);?> Priority</span>
                </div>
                <h1><?=html_escape($ticket->subject);?></h1>
                <span style="font-size: 12.5px; color: #64748b;">
                    Category: <strong><?=html_escape($ticket->category);?></strong> &bull; Created On <?=date('d M Y, h:i A', strtotime($ticket->created_at));?>
                </span>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="<?=base_url('hospitalpanel/support');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Tickets
                </a>

                <?php if(!$is_closed): ?>
                    <a href="<?=base_url('hospitalpanel/close_ticket/'.$ticket->ticket_id.'?status=Resolved');?>" onclick="return confirm('Are you sure you want to mark this support ticket as Resolved?');" class="btn-resolve-ticket">
                        <i class="fa fa-check-circle"></i> Mark as Resolved
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="thread-grid">
            
            <!-- Left: Message Thread & Replies -->
            <div>
                
                <!-- Original Ticket Description -->
                <div class="issue-card">
                    <div class="issue-card-header">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="sender-avatar">
                                <i class="fa fa-hospital-o"></i>
                            </div>
                            <div>
                                <strong style="font-size: 14px; color: #043d5b; display: block;">
                                    <?=html_escape($hospital->name ?? 'Hospital Staff');?> (Author)
                                </strong>
                                <span style="font-size: 11.5px; color: #64748b;">
                                    <?=date('d M Y, h:i A', strtotime($ticket->created_at));?>
                                </span>
                            </div>
                        </div>
                        <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 4px; font-weight: 700;">
                            Original Query
                        </span>
                    </div>

                    <div style="font-size: 13.5px; color: #334155; line-height: 1.6; white-space: pre-wrap; margin-bottom: 14px;">
                        <?=html_escape($ticket->description);?>
                    </div>

                    <?php if(!empty($ticket->attachment)): ?>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; display: inline-flex; align-items: center; gap: 10px;">
                            <i class="fa fa-paperclip" style="color: #64748b; font-size: 16px;"></i>
                            <div>
                                <span style="font-size: 12px; font-weight: 700; color: #0f172a; display: block;">Attached Document</span>
                                <a href="<?=base_url('uploads/support/'.$ticket->attachment);?>" target="_blank" style="font-size: 11.5px; color: #00a896; font-weight: 700;">
                                    View / Download File <i class="fa fa-external-link"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Conversation Replies Timeline -->
                <?php if(!empty($replies)): ?>
                    <h3 style="font-size: 15px; font-weight: 800; color: #043d5b; margin: 24px 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-comments"></i> Discussion &amp; Resolution History (<?=count($replies);?>)
                    </h3>

                    <?php foreach($replies as $r): 
                        $is_admin = ($r->sender_type == 'Admin');
                    ?>
                        <div class="msg-bubble <?=$is_admin ? 'admin-msg' : 'hospital-msg';?>">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <?php if($is_admin): ?>
                                        <div class="admin-avatar">
                                            <i class="fa fa-shield"></i>
                                        </div>
                                        <div>
                                            <strong style="font-size: 13.5px; color: #00a896; display: block;">
                                                Upchar Central Admin Support
                                            </strong>
                                            <span style="font-size: 11px; color: #64748b;">
                                                <?=date('d M Y, h:i A', strtotime($r->created_at));?>
                                            </span>
                                        </div>
                                    <?php else: ?>
                                        <div class="sender-avatar">
                                            <i class="fa fa-hospital-o"></i>
                                        </div>
                                        <div>
                                            <strong style="font-size: 13.5px; color: #043d5b; display: block;">
                                                <?=html_escape($hospital->name ?? 'Hospital Staff');?>
                                            </strong>
                                            <span style="font-size: 11px; color: #64748b;">
                                                <?=date('d M Y, h:i A', strtotime($r->created_at));?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <span style="font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 4px; <?=$is_admin ? 'background: #ccfbf1; color: #0f766e;' : 'background: #f1f5f9; color: #475569;';?>">
                                    <?=$is_admin ? 'ADMIN RESPONSE' : 'HOSPITAL REPLY';?>
                                </span>
                            </div>

                            <div style="font-size: 13px; color: #334155; line-height: 1.6; white-space: pre-wrap; padding-left: 52px;">
                                <?=html_escape($r->message);?>
                            </div>

                            <?php if(!empty($r->attachment_path)): ?>
                                <div style="margin-top: 10px; margin-left: 52px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 6px 12px; display: inline-flex; align-items: center; gap: 8px;">
                                    <i class="fa fa-paperclip" style="color: #64748b;"></i>
                                    <a href="<?=base_url('uploads/support/'.$r->attachment_path);?>" target="_blank" style="font-size: 11.5px; color: #00a896; font-weight: 700;">
                                        Attachment Download <i class="fa fa-download"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Reply Box / Form -->
                <div class="reply-box-card">
                    <h4 style="font-size: 15px; font-weight: 800; color: #043d5b; margin: 0 0 14px 0; display: flex; align-items: center; gap: 6px;">
                        <i class="fa fa-reply"></i> Post a Reply
                    </h4>

                    <?php if($is_closed): ?>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; text-align: center; color: #64748b;">
                            <i class="fa fa-lock" style="font-size: 20px; color: #94a3b8; display: block; margin-bottom: 6px;"></i>
                            <strong style="color: #334155; font-size: 14px; display: block;">This Ticket is <?=html_escape($ticket->status);?></strong>
                            <span style="font-size: 12px;">Further replies are locked. If you require additional assistance, please create a new support ticket.</span>
                        </div>
                    <?php else: ?>
                        <?php echo form_open_multipart("hospitalpanel/ticket_view/".$ticket->ticket_id, 'id="replyForm"');?>
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                            
                            <div style="margin-bottom: 14px;">
                                <textarea name="message" rows="4" class="form-control" placeholder="Type your message or clarification here..." style="border-radius: 8px; border-color: #cbd5e1; font-size: 13.5px;" required></textarea>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <label style="margin: 0; cursor: pointer; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 14px; font-size: 12px; font-weight: 700; color: #475569; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fa fa-paperclip"></i> Attach File
                                        <input type="file" name="reply_attachment" accept="image/*,.pdf,.doc,.docx" style="display: none;" onchange="$('#fileNameDisplay').text(this.files[0] ? this.files[0].name : '');">
                                    </label>
                                    <span id="fileNameDisplay" style="font-size: 11.5px; color: #64748b;"></span>
                                </div>

                                <button type="submit" name="submit_reply" value="1" class="btn-send-reply">
                                    <i class="fa fa-paper-plane"></i> Send Reply
                                </button>
                            </div>
                        <?php echo form_close(); ?>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Right: Ticket Information & Metadata -->
            <div>
                <div style="background: #ffffff; border-radius: 14px; border: 1px solid var(--upchar-border); padding: 22px 24px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);">
                    <h4 style="font-size: 15px; font-weight: 800; color: #043d5b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-info-circle"></i> Ticket Details
                    </h4>

                    <div style="margin-bottom: 12px; font-size: 13px; color: #475569; display: flex; justify-content: space-between;">
                        <span>Ticket Code:</span>
                        <strong style="color: #0f172a;"><?=html_escape($ticket->ticket_code);?></strong>
                    </div>

                    <div style="margin-bottom: 12px; font-size: 13px; color: #475569; display: flex; justify-content: space-between;">
                        <span>Category:</span>
                        <strong style="color: #0f172a;"><?=html_escape($ticket->category);?></strong>
                    </div>

                    <div style="margin-bottom: 12px; font-size: 13px; color: #475569; display: flex; justify-content: space-between;">
                        <span>Priority:</span>
                        <span class="<?=$p_class;?>"><?=html_escape($ticket->priority);?></span>
                    </div>

                    <div style="margin-bottom: 12px; font-size: 13px; color: #475569; display: flex; justify-content: space-between;">
                        <span>Status:</span>
                        <span class="<?=$s_class;?>"><?=html_escape($ticket->status);?></span>
                    </div>

                    <div style="margin-bottom: 12px; font-size: 13px; color: #475569; display: flex; justify-content: space-between;">
                        <span>Created:</span>
                        <span style="color: #0f172a;"><?=date('d M Y, h:i A', strtotime($ticket->created_at));?></span>
                    </div>

                    <div style="margin-bottom: 16px; font-size: 13px; color: #475569; display: flex; justify-content: space-between;">
                        <span>Last Activity:</span>
                        <span style="color: #0f172a;"><?=date('d M Y, h:i A', strtotime($ticket->updated_at));?></span>
                    </div>

                    <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 8px; padding: 12px 14px; font-size: 12px; color: #0f766e; line-height: 1.5;">
                        <i class="fa fa-clock-o"></i> <strong>SLA Response Time:</strong> Upchar technical &amp; billing desk typically reviews urgent inquiries within 2-4 business hours.
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
