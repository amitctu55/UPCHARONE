<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Patient Appointment History</h1>
        <small style="color: #64748b; font-size: 13px;">Manage complete patient logs, past consultation records, and export reports</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/user')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Patient History</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 15px;">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Toast Notification Container -->
      <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

      <!-- Advanced Filter Card -->
      <div class="master-card" style="margin-bottom: 20px;">
        <div class="master-card-header" style="cursor: pointer;" onclick="$('#filter-collapse-body').slideToggle(200);">
          <h3 class="master-card-title">
            <i class="fa fa-filter" style="color: #00a896;"></i>
            <span>Filter Patient Appointment History</span>
          </h3>
          <i class="fa fa-chevron-down text-muted" style="font-size: 12px;"></i>
        </div>
        <div id="filter-collapse-body" class="master-card-body" style="padding: 18px 20px;">
          <form action="<?=base_url('doctor/appointment/user')?>" method="get" id="search_form">
            <div class="row">
              <div class="col-md-3 col-sm-6 form-group">
                <label style="font-size: 12px; font-weight: 600; color: #475569;">Patient Name</label>
                <input type="text" class="form-control input-sm" name="paient_name" placeholder="Patient name..." value="<?=$this->input->get_post('paient_name');?>" style="border-radius: 6px; height: 34px;">
              </div>
              <div class="col-md-3 col-sm-6 form-group">
                <label style="font-size: 12px; font-weight: 600; color: #475569;">Patient Contact</label>
                <input type="text" class="form-control input-sm" name="paient_phone" placeholder="Phone or mobile..." value="<?=$this->input->get_post('paient_phone');?>" style="border-radius: 6px; height: 34px;">
              </div>
              <div class="col-md-3 col-sm-6 form-group">
                <label style="font-size: 12px; font-weight: 600; color: #475569;">Doctor Name</label>
                <input type="text" class="form-control input-sm" name="doctor_name" placeholder="Doctor name..." value="<?=$this->input->get_post('doctor_name');?>" style="border-radius: 6px; height: 34px;">
              </div>
              <div class="col-md-3 col-sm-6 form-group">
                <label style="font-size: 12px; font-weight: 600; color: #475569;">Hospital / Clinic</label>
                <input type="text" class="form-control input-sm" name="hospital_name" placeholder="Hospital name..." value="<?=$this->input->get_post('hospital_name');?>" style="border-radius: 6px; height: 34px;">
              </div>
            </div>

            <div class="row">
              <div class="col-md-3 col-sm-6 form-group">
                <label style="font-size: 12px; font-weight: 600; color: #475569;">Date From</label>
                <input type="date" class="form-control input-sm" name="date_from" value="<?=$this->input->get_post('date_from');?>" style="border-radius: 6px; height: 34px;">
              </div>
              <div class="col-md-3 col-sm-6 form-group">
                <label style="font-size: 12px; font-weight: 600; color: #475569;">Date To</label>
                <input type="date" class="form-control input-sm" name="date_to" value="<?=$this->input->get_post('date_to');?>" style="border-radius: 6px; height: 34px;">
              </div>
              <div class="col-md-3 col-sm-6 form-group">
                <label style="font-size: 12px; font-weight: 600; color: #475569;">Payment Mode</label>
                <select class="form-control input-sm" name="payment_mode" style="border-radius: 6px; height: 34px;">
                  <option value="">All Payment Modes</option>
                  <option value="ONLINE" <?=$this->input->get_post('payment_mode')=='ONLINE'?'selected':'';?>>Online Payment</option>
                  <option value="COC" <?=$this->input->get_post('payment_mode')=='COC'?'selected':'';?>>Counter / Offline (COC)</option>
                </select>
              </div>
              <div class="col-md-3 col-sm-6 form-group">
                <label style="font-size: 12px; font-weight: 600; color: #475569;">City</label>
                <select class="form-control input-sm" name="city_name" style="border-radius: 6px; height: 34px;">
                  <option value="">All Cities</option>
                  <?php if(!empty($city)): foreach($city as $c): ?>
                    <option value="<?=$c['id'];?>" <?=$this->input->get_post('city_name')==$c['id']?'selected':'';?>><?=$c['name'];?></option>
                  <?php endforeach; endif; ?>
                </select>
              </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
              <a href="<?=base_url('doctor/appointment/user')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600;">
                <i class="fa fa-refresh"></i> Clear Filters
              </a>
              <button type="submit" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896; padding: 6px 18px;">
                <i class="fa fa-search"></i> Apply Filter
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Main Directory Card -->
      <div class="master-card">
        <div class="master-card-header">
          <h3 class="master-card-title">
            <i class="fa fa-list-alt" style="color: #00a896;"></i>
            <span>Appointment Records Directory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-user-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="user-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/appointment/createHistoryExcel?'.http_build_query($_GET))?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600; color: #15803d; border-color: #bbf7d0; background: #f0fdf4;">
              <i class="fa fa-file-excel-o"></i> Excel
            </a>
            <a href="<?=base_url('doctor/appointment/addappointment')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Book New
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="history-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-users" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Date & Time</th>
                  <th>Patient Name</th>
                  <th>Patient Contact</th>
                  <th>Hospital / Facility</th>
                  <th>Doctor</th>
                  <th style="width: 100px; text-align: center;">Payment</th>
                  <th style="width: 100px; text-align: center;">Status</th>
                  <th style="width: 100px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($data)): foreach($data as $p): 
                  $aid = is_object($p) ? $p->appointment_id : $p['appointment_id'];
                  $pname = is_object($p) ? $p->appointment_name : $p['appointment_name'];
                  $adate = is_object($p) ? $p->appointment_date : $p['appointment_date'];
                  $email = is_object($p) ? $p->appointment_email : $p['appointment_email'];
                  $mobile = is_object($p) ? $p->appointment_mobile : $p['appointment_mobile'];
                  $hname = is_object($p) ? $p->name : $p['name'];
                  $dname = is_object($p) ? $p->fname : $p['fname'];
                  $payment = is_object($p) ? $p->payment_status : $p['payment_status'];
                  $appStatus = is_object($p) ? $p->appointment_status : $p['appointment_status'];
                  $isDone = ($appStatus == '1');
                ?>
                  <tr id="row-<?=$aid;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="user-checkbox" value="<?=$aid;?>" data-name="<?=htmlspecialchars($pname);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$aid;?></td>
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-size: 11.5px;">
                        <i class="fa fa-calendar"></i> <?=formatedate($adate);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($pname);?></strong>
                    </td>
                    <td style="vertical-align: middle;">
                      <?php if($mobile): ?><div style="font-size: 12.5px; color: #334155;"><i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($mobile);?></div><?php endif; ?>
                      <?php if($email): ?><div style="font-size: 12px; color: #64748b;"><i class="fa fa-envelope-o text-muted"></i> <?=htmlspecialchars($email);?></div><?php endif; ?>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-hospital-o"></i> <?=htmlspecialchars($hname);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #00a896; font-size: 13px;"><i class="fa fa-user-md"></i> Dr. <?=htmlspecialchars($dname);?></strong>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="label <?=$payment=='PAID'?'label-success':'label-warning';?>" style="font-size: 11px;">
                        <?=htmlspecialchars($payment);?>
                      </span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge-pill-status <?=$isDone?'badge-status-active':'badge-status-inactive';?>">
                        <i class="fa fa-circle" style="font-size: 6px;"></i>
                        <span><?=$isDone?'Completed':'Pending';?></span>
                      </span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/appointment/data?appointment_id='.$aid);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569;" title="View Consultation">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="<?=base_url('doctor/appointment/deletehistory?appointment_id='.$aid);?>" class="btn-icon-action btn-action-delete delete-user-btn" data-id="<?=$aid;?>" data-name="<?=htmlspecialchars($pname);?>" title="Delete Record">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="10" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No appointment history records found.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination Footer -->
          <?php if(!empty($page_links)): ?>
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 18px;">
              <div class="pagination-wrapper">
                <?=$page_links;?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Single Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Appointment Record</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete appointment for <strong id="delete-user-name" style="color: #1e293b;">this patient</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-user-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteUserModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Records</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-user-count" style="color: #dc2626;">0</strong> selected appointment records? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-user-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete Selected
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function showToast(message, type) {
  var bg = (type === 'success') ? '#10b981' : ((type === 'danger') ? '#ef4444' : '#00a896');
  var icon = (type === 'success') ? 'fa-check-circle' : ((type === 'danger') ? 'fa-exclamation-triangle' : 'fa-info-circle');
  var toastId = 'toast-' + Date.now();
  
  var toastHtml = '<div id="' + toastId + '" style="pointer-events: auto; background: #ffffff; color: #1e293b; border-left: 4px solid ' + bg + '; padding: 12px 18px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; min-width: 280px; transition: all 0.3s ease;">' +
    '<i class="fa ' + icon + '" style="color: ' + bg + '; font-size: 16px;"></i>' +
    '<span style="flex-grow: 1;">' + message + '</span>' +
    '<i class="fa fa-times" onclick="$(\'#' + toastId + '\').remove();" style="cursor: pointer; color: #94a3b8; font-size: 12px;"></i>' +
  '</div>';
  
  $('#toast-container').append(toastHtml);
  setTimeout(function(){
    $('#' + toastId).fadeOut(400, function(){ $(this).remove(); });
  }, 4000);
}

function updateUserBulkState() {
  var checkedBoxes = $('.user-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.user-checkbox').length;

  $('#user-selected-count').text(count);
  $('#bulk-user-count').text(count);

  if (count > 0) {
    $('#bulk-delete-user-btn').fadeIn(200);
  } else {
    $('#bulk-delete-user-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-users').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-users').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-users').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-users', function(){
    var isChecked = $(this).prop('checked');
    $('.user-checkbox').prop('checked', isChecked);
    updateUserBulkState();
  });

  $(document).on('change', '.user-checkbox', function(){
    updateUserBulkState();
  });

  $(document).on('click', '#bulk-delete-user-btn', function(){
    if ($('.user-checkbox:checked').length === 0) return;
    $('#bulkDeleteUserModal').modal('show');
  });

  $('#confirm-bulk-delete-user-btn').click(function(){
    var selectedIds = [];
    $('.user-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/appointment/bulk_delete_history')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteUserModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#history-table tbody tr').length === 0) {
              $('#history-table tbody').html('<tr><td colspan="10" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No appointment history records found.</p></td></tr>');
            }
          });
        });

        updateUserBulkState();
        showToast(res.message || 'Selected appointment records deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting appointment records.', 'danger');
      }
    });
  });

  // Delete Single Appointment
  var activeDeleteUserId = null;
  $(document).on('click', '.delete-user-btn', function(e){
    e.preventDefault();
    activeDeleteUserId = $(this).data('id');
    var name = $(this).data('name') || 'this appointment';
    $('#delete-user-name').text('"' + name + '"');
    $('#deleteUserModal').modal('show');
  });

  $('#confirm-delete-user-btn').click(function(){
    if(!activeDeleteUserId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/appointment/deletehistory')?>',
      dataType: 'json',
      data: { id: activeDeleteUserId, appointment_id: activeDeleteUserId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteUserModal').modal('hide');
        $('#row-' + activeDeleteUserId).fadeOut(400, function(){
          $(this).remove();
          if ($('#history-table tbody tr').length === 0) {
            $('#history-table tbody').html('<tr><td colspan="10" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No appointment history records found.</p></td></tr>');
          }
          updateUserBulkState();
        });
        showToast(res.message || 'Appointment record deleted successfully.', 'success');
        activeDeleteUserId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/appointment/deletehistory?appointment_id=')?>' + activeDeleteUserId;
      }
    });
  });
});
</script>
