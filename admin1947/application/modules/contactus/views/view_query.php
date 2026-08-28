<style>
  :root {
    --adm-navy: #1d2a44;
    --adm-teal: #00a896;
    --adm-slate-900: #0f172a;
    --adm-slate-800: #1e293b;
    --adm-slate-700: #334155;
    --adm-slate-600: #475569;
    --adm-slate-100: #f1f5f9;
    --adm-border: #cbd5e1;
  }

  .view-query-wrapper {
    font-family: 'Inter', sans-serif;
    color: var(--adm-slate-800);
  }

  .content-header h1 {
    color: var(--adm-slate-900) !important;
    font-weight: 700;
    font-size: 22px;
  }
  .content-header h1 small {
    color: var(--adm-slate-600) !important;
    font-size: 13px;
  }

  .query-box {
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    margin-bottom: 25px;
  }

  .query-box-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--adm-border);
    background: #ffffff;
    border-radius: 10px 10px 0 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .query-box-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--adm-slate-900);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .demographics-table th {
    background: #f8fafc !important;
    color: var(--adm-slate-900) !important;
    font-weight: 700 !important;
    width: 140px;
    font-size: 13px;
    border-color: #e2e8f0 !important;
  }

  .demographics-table td {
    color: var(--adm-slate-800) !important;
    font-size: 13.5px;
    border-color: #e2e8f0 !important;
  }

  .form-control-modern {
    border-radius: 6px;
    border: 1px solid var(--adm-border);
    color: var(--adm-slate-900);
    font-size: 13.5px;
    padding: 8px 12px;
  }
  .form-control-modern:focus {
    border-color: var(--adm-teal);
    box-shadow: 0 0 0 2px rgba(0, 168, 150, 0.2);
  }

  .badge-high-contrast {
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 4px;
    display: inline-block;
  }
  .badge-status-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
  .badge-status-replied { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
  .badge-status-resolved { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
  .badge-status-closed { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
</style>

<div class="content-wrapper view-query-wrapper">
    <section class="content-header" style="padding-top: 15px;">
        <h1>
            <i class="fa fa-envelope-open-o" style="color: var(--adm-teal);"></i> Query Ticket #<?=$query['id'];?> Details
            <small>Review sender message and dispatch official admin response</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?=base_url('contactus');?>">Contact Us</a></li>
            <li class="active" style="color: var(--adm-slate-800); font-weight: 600;">Ticket #<?=$query['id'];?></li>
        </ol>
    </section>

    <section class="content">
        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <div class="row">
            <!-- Left Column: Inquiry Details & History -->
            <div class="col-md-6 col-12">
                <!-- Sender Info Box -->
                <div class="query-box">
                    <div class="query-box-header">
                        <h3 class="query-box-title"><i class="fa fa-user" style="color: var(--adm-teal);"></i> Sender Demographics</h3>
                        <div>
                            <?php if($query['status'] == 'PENDING'): ?>
                                <span class="badge-high-contrast badge-status-pending"><i class="fa fa-clock-o"></i> PENDING</span>
                            <?php elseif($query['status'] == 'REPLIED'): ?>
                                <span class="badge-high-contrast badge-status-replied"><i class="fa fa-reply"></i> REPLIED</span>
                            <?php elseif($query['status'] == 'RESOLVED'): ?>
                                <span class="badge-high-contrast badge-status-resolved"><i class="fa fa-check"></i> RESOLVED</span>
                            <?php else: ?>
                                <span class="badge-high-contrast badge-status-closed"><?=$query['status'];?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="box-body" style="padding: 0;">
                        <table class="table table-bordered demographics-table" style="margin-bottom: 0;">
                            <tr>
                                <th>Full Name</th>
                                <td style="font-weight: 700; font-size: 14px;"><?=htmlspecialchars($query['name']);?></td>
                            </tr>
                            <tr>
                                <th>Contact Mobile</th>
                                <td>
                                    <a href="tel:<?=$query['mobile'];?>" style="font-weight: 700; color: #008f80;">
                                        <i class="fa fa-phone"></i> <?=htmlspecialchars($query['mobile']);?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td>
                                    <?php if(!empty($query['email'])): ?>
                                    <a href="mailto:<?=$query['email'];?>" style="color: #0284c7; font-weight: 600;">
                                        <i class="fa fa-envelope"></i> <?=htmlspecialchars($query['email']);?>
                                    </a>
                                    <?php else: ?>
                                    <span class="text-muted">Not provided</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>
                                    <span class="label label-primary" style="font-size: 12px; font-weight: 600;"><?=htmlspecialchars($query['inquiry_type'] ?: 'GENERAL');?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Received On</th>
                                <td style="color: #475569; font-weight: 500;">
                                    <i class="fa fa-calendar"></i> <?=date('d M Y, h:i A', strtotime($query['created_at'] ?: $query['date']));?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Original Message Box -->
                <div class="query-box" style="border-top: 3px solid var(--adm-teal);">
                    <div class="query-box-header" style="background: #f8fafc;">
                        <h3 class="query-box-title">
                            <i class="fa fa-commenting-o" style="color: var(--adm-teal);"></i> Original Inquiry Message
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 20px;">
                        <?php if(!empty($query['subject'])): ?>
                        <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 8px;">
                            Subject: <?=htmlspecialchars($query['subject']);?>
                        </div>
                        <?php endif; ?>
                        <div style="font-size: 14px; line-height: 1.6; color: #1e293b; white-space: pre-wrap; background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
<?=htmlspecialchars($query['message']);?>
                        </div>
                    </div>
                </div>

                <!-- Prior Admin Reply (if exists) -->
                <?php if(!empty($query['admin_reply'])): ?>
                <div class="query-box" style="border-top: 3px solid #10b981;">
                    <div class="query-box-header" style="background: #ecfdf5;">
                        <h3 class="query-box-title" style="color: #065f46;">
                            <i class="fa fa-check-circle text-green"></i> Previous Response Dispatched
                        </h3>
                        <span style="font-size: 12px; color: #047857; font-weight: 600;">
                            By <?=htmlspecialchars($query['replied_by']);?> on <?=date('d M Y, h:i A', strtotime($query['replied_at']));?>
                        </span>
                    </div>
                    <div class="box-body" style="background: #f0fdfa; padding: 18px;">
                        <div style="font-size: 13.5px; line-height: 1.6; color: #065f46; white-space: pre-wrap;">
<?=htmlspecialchars($query['admin_reply']);?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Dispatch Reply Form -->
            <div class="col-md-6 col-12">
                <div class="query-box" style="border-top: 3px solid #0284c7;">
                    <div class="query-box-header">
                        <h3 class="query-box-title"><i class="fa fa-reply" style="color: #0284c7;"></i> Compose &amp; Send Reply</h3>
                    </div>
                    <form action="<?=base_url('contactus/send_reply');?>" method="post">
                        <input type="hidden" name="id" value="<?=$query['id'];?>">

                        <div class="box-body" style="padding: 20px;">
                            <!-- Quick Template Picker -->
                            <div class="form-group">
                                <label style="font-size: 13px; font-weight: 700; color: #0f172a;">Quick Response Templates (Optional):</label>
                                <select id="cannedTemplates" class="form-control form-control-modern" onchange="insertTemplate(this.value)">
                                    <option value="">-- Choose a pre-written template --</option>
                                    <option value="Thank you for reaching out to Upchar Healthcare. Our partner onboarding specialist will call you today to schedule a walkthrough of our SaaS platform and assist with your registration.">Doctor / Hospital Onboarding Callback</option>
                                    <option value="We have reviewed your request regarding appointment booking. Our patient care representative is looking into your case and will confirm your slot shortly.">Patient Care &amp; Booking Support</option>
                                    <option value="Thank you for your feedback. We have escalated this query to our technical operations team for prompt resolution.">General Support Escalation</option>
                                    <option value="Your query has been fully resolved. If you require any further assistance, please feel free to reply to this message or call our toll-free helpline.">Resolution &amp; Closure</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="font-size: 13px; font-weight: 700; color: #0f172a;">Admin Response Message *</label>
                                <textarea id="replyText" name="reply_text" class="form-control form-control-modern" rows="7" placeholder="Type your official response to the user here..." required><?=htmlspecialchars(@$query['admin_reply']);?></textarea>
                            </div>

                            <div class="form-group">
                                <label style="font-size: 13px; font-weight: 700; color: #0f172a;">Update Inquiry Status To:</label>
                                <select name="new_status" class="form-control form-control-modern">
                                    <option value="REPLIED" <?=$query['status']=='REPLIED'?'selected':'';?>>REPLIED (Response Sent)</option>
                                    <option value="RESOLVED" <?=$query['status']=='RESOLVED'?'selected':'';?>>RESOLVED (Query Satisfied &amp; Done)</option>
                                    <option value="CLOSED" <?=$query['status']=='CLOSED'?'selected':'';?>>CLOSED (Archived)</option>
                                    <option value="IN_PROGRESS" <?=$query['status']=='IN_PROGRESS'?'selected':'';?>>IN_PROGRESS (Under Investigation)</option>
                                </select>
                            </div>

                            <div style="background: #f8fafc; border: 1px solid var(--adm-border); border-radius: 8px; padding: 14px; margin-top: 16px;">
                                <div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                                    <i class="fa fa-paper-plane" style="color: var(--adm-teal);"></i> Dispatch Channels:
                                </div>
                                <div class="checkbox" style="margin-top: 4px; margin-bottom: 8px;">
                                    <label style="font-size: 13px; font-weight: 600; color: #1e293b;">
                                        <input type="checkbox" name="send_email" value="1" <?=!empty($query['email']) ? 'checked' : 'disabled';?>> 
                                        Send Email reply to <strong><?=htmlspecialchars($query['email'] ?: 'No email provided');?></strong>
                                    </label>
                                </div>
                                <div class="checkbox" style="margin-top: 0; margin-bottom: 0;">
                                    <label style="font-size: 13px; font-weight: 600; color: #1e293b;">
                                        <input type="checkbox" name="send_sms" value="1" <?=!empty($query['mobile']) ? 'checked' : 'disabled';?>> 
                                        Send SMS notification to <strong><?=htmlspecialchars($query['mobile']);?></strong>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer" style="padding: 16px 20px; background: #f8fafc; border-radius: 0 0 10px 10px; border-top: 1px solid var(--adm-border); display: flex; justify-content: space-between; align-items: center;">
                            <a href="<?=base_url('contactus');?>" class="btn btn-default" style="font-weight: 600;">
                                <i class="fa fa-arrow-left"></i> Back to Inquiries
                            </a>
                            <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; padding: 8px 24px;">
                                <i class="fa fa-paper-plane"></i> Dispatch Response
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function insertTemplate(text) {
    if (text) {
        var txtArea = document.getElementById('replyText');
        if (txtArea.value.trim() === '') {
            txtArea.value = text;
        } else {
            if (confirm('Replace current text with chosen template?')) {
                txtArea.value = text;
            }
        }
    }
}
</script>
