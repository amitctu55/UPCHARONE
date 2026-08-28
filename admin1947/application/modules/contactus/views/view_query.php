<style>
  :root {
    --adm-teal: #00a896;
    --adm-teal-dark: #008f80;
    --adm-teal-light: #f0fdfa;
    --adm-teal-border: #ccfbf1;
    --adm-slate-900: #0f172a;
    --adm-slate-800: #1e293b;
    --adm-slate-700: #334155;
    --adm-slate-600: #475569;
    --adm-slate-500: #64748b;
    --adm-slate-100: #f8fafc;
    --adm-border: #e2e8f0;
  }

  .ticket-view-wrapper {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--adm-slate-800);
    padding-bottom: 40px;
  }

  /* Header Card */
  .ticket-top-banner {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--adm-border);
    padding: 20px 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
  }

  .ticket-title-group {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .ticket-id-badge {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 14px;
    font-weight: 800;
    padding: 6px 14px;
    border-radius: 8px;
    border: 1px solid #bae6fd;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .ticket-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
  }
  .status-pill-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
  .status-pill-replied { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
  .status-pill-resolved { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
  .status-pill-inprogress { background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }
  .status-pill-closed { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

  /* Card Containers */
  .crm-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 24px;
    transition: all 0.2s ease;
  }

  .crm-card-header {
    padding: 16px 20px;
    background: #ffffff;
    border-bottom: 1px solid var(--adm-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .crm-card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--adm-slate-900);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* Sender Profile Box */
  .sender-avatar-hero {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: linear-gradient(135deg, #00a896 0%, #0284c7 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 800;
    box-shadow: 0 4px 10px rgba(0,168,150,0.25);
    flex-shrink: 0;
  }

  .contact-quick-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.15s ease;
  }
  .link-call { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
  .link-call:hover { background: #dcfce7; color: #14532d; }
  .link-wa { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
  .link-wa:hover { background: #d1fae5; color: #065f46; }
  .link-email { background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
  .link-email:hover { background: #e0f2fe; color: #0c4a6e; }

  /* Message Stream Bubbles */
  .thread-bubble {
    border-radius: 12px;
    padding: 20px;
    position: relative;
    margin-bottom: 20px;
  }
  .thread-bubble-user {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 4px solid var(--adm-teal);
  }
  .thread-bubble-admin {
    background: #f0fdfa;
    border: 1px solid var(--adm-teal-border);
    border-left: 4px solid #10b981;
  }

  /* Form Elements */
  .crm-form-control {
    width: 100%;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    color: var(--adm-slate-900);
    font-size: 13.5px;
    padding: 10px 14px;
    transition: all 0.2s ease;
    background: #ffffff;
  }
  .crm-form-control:focus {
    border-color: var(--adm-teal);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
    outline: none;
  }

  .dispatch-channel-box {
    background: #f8fafc;
    border: 1px solid var(--adm-border);
    border-radius: 8px;
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .channel-checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: var(--adm-slate-800);
    cursor: pointer;
    margin: 0;
    user-select: none;
  }
  .channel-checkbox-label input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: var(--adm-teal);
    cursor: pointer;
  }
</style>

<div class="content-wrapper ticket-view-wrapper">
  <!-- Toast Notification Container -->
  <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

  <!-- Breadcrumbs & Navigation -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Inquiry Ticket #<?=$query['id'];?>
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Review user inquiry submission and dispatch verified staff response</p>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; padding: 0; background: transparent; margin: 0;">
        <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('contactus');?>">Inquiries Directory</a></li>
        <li class="active" style="color: #0F172A; font-weight: 600;">Ticket #<?=$query['id'];?></li>
      </ol>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Top Meta Action Banner -->
    <div class="ticket-top-banner">
      <div class="ticket-title-group">
        <span class="ticket-id-badge">
          <i class="fa fa-ticket"></i> TICKET #<?=$query['id'];?>
        </span>

        <?php 
          $currStatus = strtoupper($query['status'] ?: 'PENDING');
          $pillClass = 'status-pill-pending';
          $statusIcon = 'fa-clock-o';
          if ($currStatus === 'RESOLVED') {
            $pillClass = 'status-pill-resolved';
            $statusIcon = 'fa-check-circle';
          } elseif ($currStatus === 'REPLIED') {
            $pillClass = 'status-pill-replied';
            $statusIcon = 'fa-reply';
          } elseif ($currStatus === 'IN_PROGRESS') {
            $pillClass = 'status-pill-inprogress';
            $statusIcon = 'fa-refresh';
          } elseif ($currStatus === 'CLOSED') {
            $pillClass = 'status-pill-closed';
            $statusIcon = 'fa-archive';
          }
        ?>
        <span class="ticket-status-pill <?=$pillClass;?>">
          <i class="fa <?=$statusIcon;?>"></i> <?=$currStatus;?>
        </span>

        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #f1f5f9; border-radius: 6px; font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase;">
          <i class="fa fa-tag" style="color: #00a896;"></i> <?=htmlspecialchars($query['inquiry_type'] ?: 'GENERAL');?>
        </span>
      </div>

      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('contactus');?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 8px 16px; border: 1px solid #cbd5e1;">
          <i class="fa fa-arrow-left"></i> Back to Inquiries
        </a>
        <?php if(!empty($query['mobile'])): ?>
          <a href="https://wa.me/91<?=preg_replace('/[^0-9]/', '', $query['mobile']);?>" target="_blank" class="contact-quick-link link-wa" style="padding: 8px 14px; font-size: 13px;">
            <i class="fa fa-whatsapp" style="font-size: 15px;"></i> WhatsApp
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Two Column Layout: Sender & History on Left, Reply Console on Right -->
    <div class="row">
      <!-- Left Column: Customer Profile & Conversation Thread -->
      <div class="col-lg-6 col-md-12 col-xs-12">
        
        <!-- 1. Sender Demographics Card -->
        <div class="crm-card">
          <div class="crm-card-header">
            <h3 class="crm-card-title">
              <i class="fa fa-user-circle" style="color: var(--adm-teal);"></i> Sender Demographics
            </h3>
            <span style="font-size: 12px; color: #64748B; font-weight: 500;">
              Received: <?=date('d M Y, h:i A', strtotime($query['created_at'] ?: $query['date']));?>
            </span>
          </div>

          <div style="padding: 20px;">
            <!-- Profile Hero Header -->
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
              <?php 
                $initial = !empty($query['name']) ? strtoupper(substr(trim($query['name']), 0, 1)) : 'U';
              ?>
              <div class="sender-avatar-hero">
                <?=$initial;?>
              </div>
              <div style="flex: 1;">
                <h4 style="margin: 0 0 4px 0; font-size: 17px; font-weight: 700; color: #0F172A;">
                  <?=htmlspecialchars($query['name'] ?: 'Guest User');?>
                </h4>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                  <?php if(!empty($query['mobile'])): ?>
                    <a href="tel:<?=$query['mobile'];?>" class="contact-quick-link link-call">
                      <i class="fa fa-phone"></i> <?=htmlspecialchars($query['mobile']);?>
                    </a>
                  <?php endif; ?>
                  <?php if(!empty($query['email'])): ?>
                    <a href="mailto:<?=$query['email'];?>" class="contact-quick-link link-email">
                      <i class="fa fa-envelope"></i> <?=htmlspecialchars($query['email']);?>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Meta Data Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
              <div style="background: #f8fafc; padding: 12px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <span style="display: block; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Inquiry Category</span>
                <span style="font-size: 13.5px; font-weight: 600; color: #0F172A;"><?=htmlspecialchars($query['inquiry_type'] ?: 'General Support');?></span>
              </div>
              <div style="background: #f8fafc; padding: 12px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <span style="display: block; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Submitted Date</span>
                <span style="font-size: 13.5px; font-weight: 600; color: #0F172A;"><?=date('d M Y', strtotime($query['created_at'] ?: $query['date']));?></span>
              </div>
            </div>
          </div>
        </div>

        <!-- 2. Original User Inquiry Message -->
        <div class="crm-card">
          <div class="crm-card-header" style="background: #f8fafc;">
            <h3 class="crm-card-title">
              <i class="fa fa-commenting" style="color: var(--adm-teal);"></i> Original Inquiry Message
            </h3>
            <span style="font-size: 12px; color: #64748B; font-weight: 600;">
              <i class="fa fa-clock-o"></i> <?=date('h:i A', strtotime($query['created_at'] ?: $query['date']));?>
            </span>
          </div>

          <div style="padding: 20px;">
            <?php if(!empty($query['subject'])): ?>
              <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px dashed #cbd5e1; font-weight: 700; color: #0F172A; font-size: 14.5px;">
                <span style="color: #64748B; font-weight: 600;">Subject:</span> <?=htmlspecialchars($query['subject']);?>
              </div>
            <?php endif; ?>

            <div class="thread-bubble thread-bubble-user" style="margin-bottom: 0;">
              <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12.5px; color: #475569; font-weight: 600;">
                <span><i class="fa fa-user"></i> <?=htmlspecialchars($query['name']);?> wrote:</span>
              </div>
              <div style="font-size: 14px; line-height: 1.6; color: #1E293B; white-space: pre-wrap; word-break: break-word;">
<?=htmlspecialchars($query['message']);?>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. Existing Admin Response History (If already replied) -->
        <?php if(!empty($query['admin_reply'])): ?>
        <div class="crm-card" style="border-color: #a7f3d0;">
          <div class="crm-card-header" style="background: #f0fdf4; border-bottom-color: #bbf7d0;">
            <h3 class="crm-card-title" style="color: #166534;">
              <i class="fa fa-check-circle" style="color: #10b981;"></i> Official Staff Response Dispatched
            </h3>
            <span style="font-size: 12px; color: #15803d; font-weight: 600;">
              By <?=htmlspecialchars($query['replied_by'] ?: 'Admin');?> on <?=date('d M Y, h:i A', strtotime($query['replied_at']));?>
            </span>
          </div>

          <div style="padding: 20px;">
            <div class="thread-bubble thread-bubble-admin" style="margin-bottom: 0;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #ccfbf1;">
                <span style="font-size: 13px; font-weight: 700; color: #065f46;">
                  <i class="fa fa-shield"></i> Upchar Support (<?=htmlspecialchars($query['replied_by']);?>)
                </span>
                <span style="font-size: 11.5px; color: #047857; font-weight: 600;">
                  <i class="fa fa-clock-o"></i> <?=date('d M, h:i A', strtotime($query['replied_at']));?>
                </span>
              </div>
              <div style="font-size: 14px; line-height: 1.6; color: #065f46; white-space: pre-wrap; word-break: break-word;">
<?=htmlspecialchars($query['admin_reply']);?>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>

      </div>

      <!-- Right Column: Interactive Reply & Resolution Console -->
      <div class="col-lg-6 col-md-12 col-xs-12">
        <div class="crm-card" style="position: sticky; top: 20px; border-top: 3px solid var(--adm-teal);">
          <div class="crm-card-header" style="background: #ffffff;">
            <h3 class="crm-card-title">
              <i class="fa fa-reply-all" style="color: var(--adm-teal);"></i> Dispatch Response &amp; Update Status
            </h3>
            <span style="font-size: 11.5px; background: #e0f2fe; color: #0284c7; padding: 3px 8px; border-radius: 4px; font-weight: 700;">
              CRM Action Console
            </span>
          </div>

          <form action="<?=base_url('contactus/send_reply');?>" method="post" id="replyForm">
            <input type="hidden" name="id" value="<?=$query['id'];?>">

            <div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">
              
              <!-- Quick Response Canned Templates -->
              <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                  <i class="fa fa-magic" style="color: var(--adm-teal);"></i> Choose Pre-written Response Template:
                </label>
                <select id="cannedTemplates" class="crm-form-control" onchange="insertTemplate(this.value)" style="height: 40px; font-weight: 500;">
                  <option value="">-- Select quick response template --</option>
                  <option value="Thank you for reaching out to Upchar Healthcare. Our onboarding specialist will contact you shortly to guide you through registration and account setup.">👨‍⚕️ Doctor / Hospital Onboarding Callback</option>
                  <option value="We have received your appointment inquiry. Our patient coordination team is reviewing your schedule request and will confirm your booking slot via SMS/Email shortly.">📅 Patient Appointment Assistance</option>
                  <option value="Thank you for bringing this to our attention. We have escalated your query to our technical operations team for immediate investigation.">⚙️ Support &amp; Technical Escalation</option>
                  <option value="Thank you for contacting Upchar Healthcare. Your inquiry has been fully addressed and resolved. Please let us know if you require any further assistance.">✅ Inquiry Resolution &amp; Closure</option>
                  <option value="Dear User, we attempted to reach you via phone regarding your query. Please let us know the best time to call you back, or reply directly to this email.">📞 Callback Attempt Notice</option>
                </select>
              </div>

              <!-- Admin Response Textarea -->
              <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                  <label style="font-size: 13px; font-weight: 700; color: #334155; margin: 0;">
                    Official Staff Message <span style="color: #EF4444;">*</span>
                  </label>
                  <span id="charCount" style="font-size: 11.5px; color: #64748B; font-weight: 600;"></span>
                </div>
                <textarea id="replyText" name="reply_text" class="crm-form-control" rows="8" placeholder="Type your official response to the customer here..." required style="font-size: 13.5px; line-height: 1.5; resize: vertical;"><?=htmlspecialchars(@$query['admin_reply']);?></textarea>
              </div>

              <!-- Ticket Status Update Selector -->
              <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                  <i class="fa fa-sliders" style="color: #0284c7;"></i> Update Ticket Status To:
                </label>
                <select name="new_status" class="crm-form-control" style="height: 40px; font-weight: 700;">
                  <option value="RESOLVED" <?=$query['status']=='RESOLVED'?'selected':'';?> style="color: #166534; font-weight: 700;">✅ RESOLVED (Query Completed &amp; Satisfied)</option>
                  <option value="REPLIED" <?=$query['status']=='REPLIED'?'selected':'';?> style="color: #075985; font-weight: 700;">💬 REPLIED (Official Response Sent)</option>
                  <option value="IN_PROGRESS" <?=$query['status']=='IN_PROGRESS'?'selected':'';?> style="color: #6d28d9; font-weight: 700;">⏳ IN_PROGRESS (Under Investigation)</option>
                  <option value="CLOSED" <?=$query['status']=='CLOSED'?'selected':'';?> style="color: #475569; font-weight: 700;">📁 CLOSED (Archived Ticket)</option>
                </select>
              </div>

              <!-- Multi-Channel Delivery Options -->
              <div class="dispatch-channel-box">
                <span style="font-size: 12.5px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.4px;">
                  <i class="fa fa-paper-plane" style="color: var(--adm-teal);"></i> Dispatch Channels:
                </span>

                <label class="channel-checkbox-label">
                  <input type="checkbox" name="send_email" value="1" <?=!empty($query['email']) ? 'checked' : 'disabled';?>>
                  <span>
                    <i class="fa fa-envelope" style="color: #0284c7;"></i> 
                    Email response to <strong><?=htmlspecialchars($query['email'] ?: 'No email on record');?></strong>
                  </span>
                </label>

                <label class="channel-checkbox-label">
                  <input type="checkbox" name="send_sms" value="1" <?=!empty($query['mobile']) ? 'checked' : 'disabled';?>>
                  <span>
                    <i class="fa fa-mobile" style="font-size: 17px; color: #10b981;"></i> 
                    SMS confirmation to <strong><?=htmlspecialchars($query['mobile'] ?: 'No phone on record');?></strong>
                  </span>
                </label>
              </div>

              <!-- Submit Buttons -->
              <div style="display: flex; gap: 12px; margin-top: 6px;">
                <button type="reset" class="btn btn-default" style="flex: 1; padding: 12px; border-radius: 8px; font-weight: 600; border: 1px solid #cbd5e1;">
                  Reset Form
                </button>
                <button type="submit" class="btn" style="flex: 2; background: var(--adm-teal); color: #ffffff; padding: 12px; border-radius: 8px; font-weight: 700; border: none; box-shadow: 0 4px 12px rgba(0,168,150,0.3); display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 14px;">
                  <i class="fa fa-paper-plane"></i> Dispatch Response
                </button>
              </div>

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
      if (confirm('Replace the current response message with this selected template?')) {
        txtArea.value = text;
      }
    }
    updateCharCount();
  }
}

function updateCharCount() {
  var len = document.getElementById('replyText').value.length;
  document.getElementById('charCount').innerText = len + ' characters';
}

document.addEventListener('DOMContentLoaded', function() {
  var txt = document.getElementById('replyText');
  if (txt) {
    txt.addEventListener('input', updateCharCount);
    updateCharCount();
  }
});
</script>
