<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-envelope-open-o" style="color: #00a896;"></i> Hospital Inquiries Master Log
      <small>Central super-admin tracking of all patient inquiries submitted to partner hospitals</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Hospital Inquiries</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Flash Alert Message -->
    <?php if($this->session->flashdata('flashmsg')): ?>
      <?=$this->session->flashdata('flashmsg');?>
    <?php endif; ?>

    <!-- Summary Metrics Row -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
          <div class="inner">
            <h3><?=$total_count;?></h3>
            <p>Total Network Inquiries</p>
          </div>
          <div class="icon">
            <i class="fa fa-inbox"></i>
          </div>
          <a href="<?=base_url('inquiries?status=all');?>" class="small-box-footer">
            View All <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
          <div class="inner">
            <h3><?=$pending_count;?></h3>
            <p>Pending Responses</p>
          </div>
          <div class="icon">
            <i class="fa fa-clock-o"></i>
          </div>
          <a href="<?=base_url('inquiries?status=pending');?>" class="small-box-footer">
            Filter Pending <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
          <div class="inner">
            <h3><?=$replied_count;?></h3>
            <p>Replied by Hospitals</p>
          </div>
          <div class="icon">
            <i class="fa fa-check-circle"></i>
          </div>
          <a href="<?=base_url('inquiries?status=replied');?>" class="small-box-footer">
            Filter Replied <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-gray" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
          <div class="inner">
            <h3><?=$closed_count;?></h3>
            <p>Closed Inquiries</p>
          </div>
          <div class="icon">
            <i class="fa fa-archive"></i>
          </div>
          <a href="<?=base_url('inquiries?status=closed');?>" class="small-box-footer">
            Filter Closed <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Master Filter Card -->
    <div class="box box-primary" style="border-radius: 12px; border-top-color: #00a896;">
      <div class="box-body" style="padding: 16px 20px;">
        <form action="<?=base_url('inquiries');?>" method="GET" class="form-inline" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between;">
          <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
            
            <!-- Hospital Filter -->
            <div class="form-group" style="margin: 0;">
              <label style="margin-right: 6px; font-size: 13px; font-weight: 600;">Hospital:</label>
              <select name="hospital_id" class="form-control" style="border-radius: 6px; min-width: 220px; font-size: 13px;">
                <option value="0">All Partner Hospitals</option>
                <?php if(!empty($hospitals)): foreach($hospitals as $h): ?>
                  <option value="<?=$h->id;?>" <?=$selected_hospital_id == $h->id ? 'selected' : '';?>>
                    <?=htmlspecialchars($h->name);?> (<?=htmlspecialchars($h->city ?: 'UP');?>)
                  </option>
                <?php endforeach; endif; ?>
              </select>
            </div>

            <!-- Status Filter -->
            <div class="form-group" style="margin: 0;">
              <label style="margin-right: 6px; font-size: 13px; font-weight: 600;">Status:</label>
              <select name="status" class="form-control" style="border-radius: 6px; font-size: 13px;">
                <option value="all" <?=$selected_status == 'all' ? 'selected' : '';?>>All Statuses</option>
                <option value="pending" <?=$selected_status == 'pending' ? 'selected' : '';?>>Pending Only</option>
                <option value="replied" <?=$selected_status == 'replied' ? 'selected' : '';?>>Replied Only</option>
                <option value="closed" <?=$selected_status == 'closed' ? 'selected' : '';?>>Closed Only</option>
              </select>
            </div>

            <!-- Keyword Search -->
            <div class="form-group" style="margin: 0;">
              <input type="text" name="search" value="<?=htmlspecialchars($search_keyword);?>" placeholder="Search patient, phone, query..." class="form-control" style="border-radius: 6px; min-width: 220px; font-size: 13px;">
            </div>

            <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 6px; font-weight: 600;">
              <i class="fa fa-filter"></i> Apply Filters
            </button>

            <?php if($selected_status != 'all' || $selected_hospital_id > 0 || !empty($search_keyword)): ?>
              <a href="<?=base_url('inquiries');?>" class="btn btn-default" style="border-radius: 6px;" title="Reset Filters">
                <i class="fa fa-refresh"></i> Reset
              </a>
            <?php endif; ?>
          </div>

          <div>
            <span class="label label-info" style="font-size: 13px; padding: 6px 12px; border-radius: 6px;">
              Total Records Found: <?=(!empty($inquiries) && is_array($inquiries)) ? count($inquiries) : 0;?>
            </span>
          </div>
        </form>
      </div>
    </div>

    <!-- Master Inquiries List Table -->
    <div class="box" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
      <div class="box-header with-border" style="padding: 16px 20px;">
        <h3 class="box-title" style="font-weight: 700; font-size: 16px;">
          <i class="fa fa-list-alt" style="color: #00a896; margin-right: 6px;"></i> Inquiry Submissions Log
        </h3>
      </div>

      <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-striped" style="margin: 0;">
          <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
              <th style="width: 70px; padding: 14px 16px;">#ID</th>
              <th style="width: 130px; padding: 14px 16px;">Date</th>
              <th style="width: 220px; padding: 14px 16px;">Target Hospital</th>
              <th style="width: 220px; padding: 14px 16px;">Patient / Inquirer</th>
              <th style="padding: 14px 16px;">Query Details &amp; Message</th>
              <th style="width: 110px; padding: 14px 16px;">Status</th>
              <th style="width: 140px; padding: 14px 16px; text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($inquiries)): foreach($inquiries as $row): 
              $badgeClass = 'label-warning';
              if ($row->status == 'replied') $badgeClass = 'label-success';
              elseif ($row->status == 'closed') $badgeClass = 'label-default';
            ?>
            <tr>
              <!-- ID -->
              <td style="padding: 14px 16px; vertical-align: top;">
                <span class="label label-primary" style="font-size: 11px; background: #043d5b !important;">#<?=$row->id;?></span>
              </td>

              <!-- Date -->
              <td style="padding: 14px 16px; vertical-align: top;">
                <strong style="color: #0f172a; display: block; font-size: 13px;"><?=date('d M Y', strtotime($row->created_at));?></strong>
                <small style="color: #64748b;"><?=date('h:i A', strtotime($row->created_at));?></small>
              </td>

              <!-- Target Hospital -->
              <td style="padding: 14px 16px; vertical-align: top;">
                <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                  <?=htmlspecialchars($row->hospital_name ?: 'Hospital #' . $row->hospital_id);?>
                </div>
                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                  <i class="fa fa-map-marker" style="color: #00a896;"></i> <?=htmlspecialchars($row->hospital_city ?: 'UP, India');?>
                </div>
                <a href="<?=base_url('../hospital/' . $row->hospital_id);?>" target="_blank" style="font-size: 11.5px; color: #0284c7; text-decoration: underline; margin-top: 4px; display: inline-block;">
                  View Profile <i class="fa fa-external-link"></i>
                </a>
              </td>

              <!-- Patient / Inquirer -->
              <td style="padding: 14px 16px; vertical-align: top;">
                <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;">
                  <?=htmlspecialchars($row->user_name);?>
                </div>
                <div style="font-size: 12.5px; margin-top: 2px;">
                  <a href="tel:<?=htmlspecialchars($row->user_phone);?>" style="color: #0284c7;">
                    <i class="fa fa-phone"></i> <?=htmlspecialchars($row->user_phone);?>
                  </a>
                </div>
                <div style="font-size: 12px; color: #64748b;">
                  <a href="mailto:<?=htmlspecialchars($row->user_email);?>" style="color: #475569;">
                    <i class="fa fa-envelope-o"></i> <?=htmlspecialchars($row->user_email);?>
                  </a>
                </div>
              </td>

              <!-- Message & Response -->
              <td style="padding: 14px 16px; vertical-align: top;">
                <div style="font-weight: 700; color: #043d5b; margin-bottom: 4px; font-size: 13px;">
                  <i class="fa fa-tag" style="color: #00a896; margin-right: 4px;"></i> <?=htmlspecialchars($row->subject ?: 'General Hospital Enquiry');?>
                </div>
                <div style="font-size: 13px; color: #334155; line-height: 1.5; white-space: pre-line;">
                  <?=htmlspecialchars($row->message);?>
                </div>

                <?php if(!empty($row->reply_message)): ?>
                  <div style="margin-top: 8px; padding: 8px 12px; background: #f0fdf4; border-left: 3px solid #16a34a; border-radius: 4px; font-size: 12.5px; color: #166534;">
                    <strong><i class="fa fa-reply"></i> Hospital Response:</strong><br>
                    <?=nl2br(htmlspecialchars($row->reply_message));?>
                  </div>
                <?php else: ?>
                  <div style="margin-top: 6px; font-size: 11.5px; color: #94a3b8; font-style: italic;">
                    <i class="fa fa-hourglass-o"></i> No response documented yet
                  </div>
                <?php endif; ?>
              </td>

              <!-- Status -->
              <td style="padding: 14px 16px; vertical-align: top;">
                <span class="label <?=$badgeClass;?>" style="font-size: 12px; padding: 4px 10px; border-radius: 20px; font-weight: 600; text-transform: capitalize;">
                  <?=ucfirst($row->status);?>
                </span>
              </td>

              <!-- Action -->
              <td style="padding: 14px 16px; vertical-align: top; text-align: right;">
                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 5px;">
                  <button type="button" class="btn btn-xs btn-primary" 
                    style="background: #00a896; border-color: #00a896; border-radius: 6px; padding: 5px 10px; font-weight: 600;"
                    onclick="openAdminReplyModal('<?=$row->id;?>', '<?=htmlspecialchars(addslashes($row->hospital_name ?: 'Hospital #' . $row->hospital_id));?>', '<?=htmlspecialchars(addslashes($row->user_name));?>', '<?=htmlspecialchars(addslashes($row->subject ?: 'Enquiry'));?>', '<?=htmlspecialchars(addslashes(str_replace(array("\r", "\n"), ' ', $row->message)));?>', '<?=htmlspecialchars(addslashes(isset($row->reply_message) ? $row->reply_message : ''));?>', '<?=$row->status;?>')">
                    <i class="fa fa-reply"></i> <?=(!empty($row->reply_message)) ? 'Edit Reply' : 'Add Reply';?>
                  </button>

                  <?php if($row->status != 'closed'): ?>
                    <a href="<?=base_url('inquiries/update_status/' . $row->id . '/closed');?>" class="btn btn-xs btn-default" style="border-radius: 6px;" onclick="return confirm('Mark as closed?');" title="Close Inquiry">
                      <i class="fa fa-archive"></i> Close
                    </a>
                  <?php else: ?>
                    <a href="<?=base_url('inquiries/update_status/' . $row->id . '/pending');?>" class="btn btn-xs btn-default" style="border-radius: 6px;" title="Reopen Inquiry">
                      <i class="fa fa-undo"></i> Reopen
                    </a>
                  <?php endif; ?>

                  <a href="<?=base_url('inquiries/delete/' . $row->id);?>" class="btn btn-xs btn-danger" style="border-radius: 6px;" onclick="return confirm('Are you sure you want to delete this inquiry record?');" title="Delete Inquiry">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                <div style="font-size: 38px; color: #cbd5e1; margin-bottom: 10px;">
                  <i class="fa fa-inbox"></i>
                </div>
                <h4>No hospital inquiries found</h4>
                <p>No records match the selected filter criteria.</p>
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </section>
</div>

<!-- Modal: Super Admin Reply / Response Override -->
<div class="modal fade" id="adminReplyModal" tabindex="-1" role="dialog" aria-labelledby="adminReplyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 540px; margin: 30px auto;">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.2);">
      <div class="modal-header" style="background: #1d2a44; color: #ffffff; padding: 16px 20px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.8; text-shadow: none;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="adminReplyModalLabel" style="font-weight: 700; margin: 0; color: #ffffff;">
          <i class="fa fa-reply" style="color: #00a896; margin-right: 6px;"></i> Document Inquiry Response
        </h4>
      </div>

      <form action="<?=base_url('inquiries/reply');?>" method="POST">
        <input type="hidden" name="inquiry_id" id="admin_inquiry_id" value="">

        <div class="modal-body" style="padding: 20px; background: #ffffff;">
          <!-- Inquiry Info Box -->
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 14px; margin-bottom: 16px;">
            <div style="font-size: 12px; color: #64748b;">Hospital: <strong id="admin_hosp_name" style="color: #0f172a;"></strong></div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Patient: <strong id="admin_patient_name" style="color: #0f172a;"></strong></div>
            <div style="font-size: 12.5px; color: #043d5b; font-weight: 700; margin-top: 4px;" id="admin_inq_subject"></div>
            <div style="font-size: 12px; color: #334155; margin-top: 4px; font-style: italic;" id="admin_inq_message"></div>
          </div>

          <!-- Reply Textarea -->
          <div class="form-group">
            <label style="font-weight: 700; color: #1e293b; font-size: 13px;">
              Hospital / Admin Response <span style="color: #ef4444;">*</span>
            </label>
            <textarea name="reply_message" id="admin_reply_message" class="form-control" rows="5" placeholder="Enter the official response communicated to the patient..." required style="border-radius: 8px; font-size: 13.5px;"></textarea>
          </div>

          <!-- Status Dropdown -->
          <div class="form-group">
            <label style="font-weight: 700; color: #1e293b; font-size: 13px;">Inquiry Status</label>
            <select name="status" id="admin_inq_status" class="form-control" style="border-radius: 8px; height: 38px; font-size: 13px;">
              <option value="replied">Replied (Response Communicated)</option>
              <option value="closed">Closed (Issue Finished)</option>
              <option value="pending">Pending</option>
            </select>
          </div>
        </div>

        <div class="modal-footer" style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 8px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px;">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 6px; font-weight: 600;">
            <i class="fa fa-save"></i> Save Response
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openAdminReplyModal(id, hospName, patientName, subject, message, existingReply, currentStatus) {
    $('#admin_inquiry_id').val(id);
    $('#admin_hosp_name').text(hospName);
    $('#admin_patient_name').text(patientName);
    $('#admin_inq_subject').text(subject);
    $('#admin_inq_message').text('"' + message + '"');
    $('#admin_reply_message').val(existingReply || '');
    if (currentStatus) {
        $('#admin_inq_status').val(currentStatus);
    } else {
        $('#admin_inq_status').val('replied');
    }
    $('#adminReplyModal').modal('show');
}
</script>
