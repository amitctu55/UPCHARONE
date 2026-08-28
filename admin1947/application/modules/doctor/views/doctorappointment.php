<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Doctor Appointments</h1>
        <small style="color: #64748b; font-size: 13px;">Manage doctor consultation bookings, patient visits, and appointment records</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/appointment/doctorappointment')?>" style="color: #64748b;">Appointments</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Doctor Wise</li>
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

      <div class="master-card">
        <div class="master-card-header">
          <h3 class="master-card-title">
            <i class="fa fa-calendar-check-o" style="color: #00a896;"></i>
            <span>Consultation Appointments List</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-app-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="app-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/appointment/addappointment')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Book Appointment
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="appointment-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-apps" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Patient Name</th>
                  <th>Appointment Date & Time</th>
                  <th>Patient Contact</th>
                  <th>Hospital / Clinic</th>
                  <th>Doctor Name</th>
                  <th style="width: 100px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $appData = !empty($data) ? $data : (!empty($doctorappointment) ? $doctorappointment : array());
                if(!empty($appData)): foreach($appData as $p): 
                  $aid = is_object($p) ? $p->appointment_id : (!empty($p['appointment_id']) ? $p['appointment_id'] : (!empty($p['id']) ? $p['id'] : 0));
                  $pname = is_object($p) ? $p->appointment_name : (!empty($p['appointment_name']) ? $p['appointment_name'] : (!empty($p['name']) ? $p['name'] : 'Patient'));
                  $adate = is_object($p) ? $p->appointment_date : (!empty($p['appointment_date']) ? $p['appointment_date'] : (!empty($p['date']) ? $p['date'] : ''));
                  $time = is_object($p) ? ($p->from_timing . ' - ' . $p->to_timing) : (!empty($p['from_timing']) ? ($p['from_timing'].' - '.$p['to_timing']) : '');
                  $mobile = is_object($p) ? $p->appointment_mobile : (!empty($p['appointment_mobile']) ? $p['appointment_mobile'] : (!empty($p['mobile']) ? $p['mobile'] : ''));
                  $email = is_object($p) ? $p->appointment_email : (!empty($p['appointment_email']) ? $p['appointment_email'] : (!empty($p['email']) ? $p['email'] : ''));
                  $hname = is_object($p) ? (!empty($p->hospital_name) ? $p->hospital_name : (!empty($p->name) ? $p->name : 'General Hospital')) : (!empty($p['hospital_name']) ? $p['hospital_name'] : (!empty($p['name']) ? $p['name'] : 'General Hospital'));
                  $raw_dname = is_object($p) ? (!empty($p->dr_fname) ? ($p->dr_fname . ' ' . $p->dr_lname) : (!empty($p->fname) ? ($p->fname . ' ' . ($p->lname ?? '')) : 'Consulting Doctor')) : (!empty($p['dr_fname']) ? ($p['dr_fname'] . ' ' . ($p['dr_lname'] ?? '')) : (!empty($p['fname']) ? $p['fname'] : 'Consulting Doctor'));
                  $dname = (stripos(trim($raw_dname), 'Dr.') === 0 || stripos(trim($raw_dname), 'Dr ') === 0) ? $raw_dname : ('Dr. ' . $raw_dname);
                ?>
                  <tr id="row-<?=$aid;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="app-checkbox" value="<?=$aid;?>" data-name="<?=htmlspecialchars($pname);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$aid;?></td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($pname);?></strong>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-size: 11.5px;">
                        <i class="fa fa-calendar"></i> <?=formatedate($adate);?> <?=$time ? '('.$time.')' : '';?>
                      </span>
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
                      <strong style="color: #00a896; font-size: 13px;"><i class="fa fa-user-md"></i> <?=htmlspecialchars($dname);?></strong>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/appointment/data?appointment_id='.$aid);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569;" title="View Appointment">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="<?=base_url('doctor/appointment/delete?appointment_id='.$aid);?>" class="btn-icon-action btn-action-delete delete-app-btn" data-id="<?=$aid;?>" data-name="<?=htmlspecialchars($pname);?>" title="Delete Appointment">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No appointment records found.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Single Delete Confirmation Modal -->
<div class="modal fade" id="deleteAppModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Appointment</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete appointment for <strong id="delete-app-name" style="color: #1e293b;">this patient</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-app-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteAppModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Appointments</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-app-count" style="color: #dc2626;">0</strong> selected appointments? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-app-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateAppBulkState() {
  var checkedBoxes = $('.app-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.app-checkbox').length;

  $('#app-selected-count').text(count);
  $('#bulk-app-count').text(count);

  if (count > 0) {
    $('#bulk-delete-app-btn').fadeIn(200);
  } else {
    $('#bulk-delete-app-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-apps').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-apps').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-apps').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-apps', function(){
    var isChecked = $(this).prop('checked');
    $('.app-checkbox').prop('checked', isChecked);
    updateAppBulkState();
  });

  $(document).on('change', '.app-checkbox', function(){
    updateAppBulkState();
  });

  $(document).on('click', '#bulk-delete-app-btn', function(){
    if ($('.app-checkbox:checked').length === 0) return;
    $('#bulkDeleteAppModal').modal('show');
  });

  $('#confirm-bulk-delete-app-btn').click(function(){
    var selectedIds = [];
    $('.app-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/appointment/bulk_delete')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteAppModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#appointment-table tbody tr').length === 0) {
              $('#appointment-table tbody').html('<tr><td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No appointment records found.</p></td></tr>');
            }
          });
        });

        updateAppBulkState();
        showToast(res.message || 'Selected appointments deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting appointments.', 'danger');
      }
    });
  });

  // Delete Single Appointment
  var activeDeleteAppId = null;
  $(document).on('click', '.delete-app-btn', function(e){
    e.preventDefault();
    activeDeleteAppId = $(this).data('id');
    var name = $(this).data('name') || 'this appointment';
    $('#delete-app-name').text('"' + name + '"');
    $('#deleteAppModal').modal('show');
  });

  $('#confirm-delete-app-btn').click(function(){
    if(!activeDeleteAppId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/appointment/delete')?>',
      dataType: 'json',
      data: { id: activeDeleteAppId, appointment_id: activeDeleteAppId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteAppModal').modal('hide');
        $('#row-' + activeDeleteAppId).fadeOut(400, function(){
          $(this).remove();
          if ($('#appointment-table tbody tr').length === 0) {
            $('#appointment-table tbody').html('<tr><td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-calendar-times-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No appointment records found.</p></td></tr>');
          }
          updateAppBulkState();
        });
        showToast(res.message || 'Appointment deleted successfully.', 'success');
        activeDeleteAppId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/appointment/delete?appointment_id=')?>' + activeDeleteAppId;
      }
    });
  });
});
</script>
