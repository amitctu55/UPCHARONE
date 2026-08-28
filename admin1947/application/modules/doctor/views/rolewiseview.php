<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Roles & Permissions Directory
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Manage staff role definitions, sub-module assignments, and status</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <button type="button" id="bulk-delete-role-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
          <i class="fa fa-trash"></i> Delete Selected (<span id="role-selected-count">0</span>)
        </button>
        <a href="<?=base_url()?>doctor/rolewisereg/index" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; color: #FFFFFF; font-weight: 600; padding: 8px 18px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-plus"></i> Add New Role
        </a>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?php if($this->session->flashdata('flashmsg')): ?>
      <div style="margin-bottom: 15px;">
        <?=$this->session->flashdata('flashmsg');?>
      </div>
    <?php endif; ?>

    <!-- Toast Notification Container -->
    <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

    <!-- Table Card -->
    <div class="master-card">
      <div class="master-card-header">
        <h3 class="master-card-title">
          <i class="fa fa-shield" style="color: #00a896;"></i>
          <span>System Staff Roles</span>
        </h3>
      </div>

      <div class="master-card-body" style="padding: 20px;">
        <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
          <table class="table table-hover table-striped" id="role-table" style="margin: 0;">
            <thead>
              <tr>
                <th style="width: 40px; text-align: center;">
                  <input type="checkbox" id="select-all-roles" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                </th>
                <th style="width: 60px; text-align: center;">#ID</th>
                <th>Role Title</th>
                <th>Module Access Permissions</th>
                <th style="width: 120px; text-align: center;">Created Date</th>
                <th style="width: 110px; text-align: center;">Status</th>
                <th style="width: 130px; text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(!empty($rolewise)) {
                foreach($rolewise as $p) {
                  $modules = explode(',', $p['module']);
                  $isActive = ($p['isStatus'] == 1);
                  $rid = $p['level_id'];
                ?>
                <tr id="row-<?=$rid;?>">
                  <td style="text-align: center; vertical-align: middle;">
                    <?php if($p['type'] != '1'): ?>
                      <input type="checkbox" class="role-checkbox" value="<?=$rid;?>" data-name="<?=htmlspecialchars($p['level_name']);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    <?php else: ?>
                      <span class="text-muted" title="System Protected Role">-</span>
                    <?php endif; ?>
                  </td>
                  <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">
                    #<?=$rid;?>
                  </td>
                  <td style="vertical-align: middle;">
                    <strong style="color: #1e293b; font-size: 14px;"><?=htmlspecialchars($p['level_name']);?></strong>
                  </td>
                  <td style="vertical-align: middle;">
                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                      <?php 
                      for($i=0; $i<count($modules); $i++) {
                        $mname = getModuleName($modules[$i]);
                        if(!empty($mname)) { ?>
                          <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11px;">
                            <?=$mname;?>
                          </span>
                      <?php } } ?>
                    </div>
                  </td>
                  <td style="text-align: center; font-size: 12px; color: #64748b; vertical-align: middle;">
                    <?=formatedate($p['added_date']);?>
                  </td>
                  <td style="text-align: center; vertical-align: middle;">
                    <a href="<?=base_url('doctor/rolewisereg/rolewiseapprove/'.$rid);?>" class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?> action-role-status" data-id="<?=$rid;?>" data-name="<?=htmlspecialchars($p['level_name']);?>" title="Toggle Status">
                      <i class="fa fa-circle" style="font-size: 6px;"></i>
                      <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                    </a>
                  </td>
                  <td style="text-align: center; vertical-align: middle;">
                    <a href="<?=base_url()?>doctor/rolewisereg/rolewiseupdate/<?=$rid;?>" class="btn-icon-action btn-action-edit" title="Edit Role">
                      <i class="fa fa-pencil"></i>
                    </a>
                    <?php if($p['type'] != '1') { ?>
                      <button type="button" class="btn-icon-action btn-action-delete delete-role-btn" data-id="<?=$rid;?>" data-name="<?=htmlspecialchars($p['level_name']);?>" title="Delete Role" style="border: none; cursor: pointer;">
                        <i class="fa fa-trash-o"></i>
                      </button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } } else { ?>
                <tr>
                  <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                    <i class="fa fa-shield fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                    <p style="font-size: 14px; font-weight: 500; margin: 0;">No staff roles defined.</p>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Single Delete Confirmation Modal -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Staff Role</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete role <strong id="delete-role-name" style="color: #1e293b;">this role</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-role-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Roles</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-role-count" style="color: #dc2626;">0</strong> selected staff roles? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-role-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateRoleBulkState() {
  var checkedBoxes = $('.role-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.role-checkbox').length;

  $('#role-selected-count').text(count);
  $('#bulk-role-count').text(count);

  if (count > 0) {
    $('#bulk-delete-role-btn').fadeIn(200);
  } else {
    $('#bulk-delete-role-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-roles').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-roles').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-roles').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-roles', function(){
    var isChecked = $(this).prop('checked');
    $('.role-checkbox').prop('checked', isChecked);
    updateRoleBulkState();
  });

  $(document).on('change', '.role-checkbox', function(){
    updateRoleBulkState();
  });

  $(document).on('click', '#bulk-delete-role-btn', function(){
    if ($('.role-checkbox:checked').length === 0) return;
    $('#bulkDeleteRoleModal').modal('show');
  });

  $('#confirm-bulk-delete-role-btn').click(function(){
    var selectedIds = [];
    $('.role-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/rolewisereg/bulk_delete_role')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteRoleModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#role-table tbody tr').length === 0) {
              $('#role-table tbody').html('<tr><td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-shield fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No staff roles defined.</p></td></tr>');
            }
          });
        });

        updateRoleBulkState();
        showToast(res.message || 'Selected roles deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting roles.', 'danger');
      }
    });
  });

  // Role Status Toggle AJAX
  $(document).on('click', '.action-role-status', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var roleName = $t.data('name') || 'Role';
    var uri = '<?=base_url('doctor/rolewisereg/rolewiseapprove')?>';
    
    $t.css('opacity', '0.5');
    $.ajax({
      type: "POST",
      url: uri,
      dataType: 'json',
      data: { did: key },
      success: function(result){
        $t.css('opacity', '1');
        if(result['status'] == 1 || result['status'] == '1') {
          $t.removeClass('badge-status-inactive').addClass('badge-status-active');
          $t.find('span').text('Active');
          showToast(roleName + ' is now Active.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Inactive');
          showToast(roleName + ' is now Inactive.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        showToast('Error updating role status.', 'danger');
      }
    });
  });

  // Delete Single Role
  var activeDeleteRoleId = null;
  $(document).on('click', '.delete-role-btn', function(e){
    e.preventDefault();
    activeDeleteRoleId = $(this).data('id');
    var name = $(this).data('name') || 'this role';
    $('#delete-role-name').text('"' + name + '"');
    $('#deleteRoleModal').modal('show');
  });

  $('#confirm-delete-role-btn').click(function(){
    if(!activeDeleteRoleId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/rolewisereg/deleterole')?>',
      dataType: 'json',
      data: { id: activeDeleteRoleId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteRoleModal').modal('hide');
        $('#row-' + activeDeleteRoleId).fadeOut(400, function(){
          $(this).remove();
          if ($('#role-table tbody tr').length === 0) {
            $('#role-table tbody').html('<tr><td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-shield fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No staff roles defined.</p></td></tr>');
          }
          updateRoleBulkState();
        });
        showToast(res.message || 'Staff role deleted successfully.', 'success');
        activeDeleteRoleId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/rolewisereg/deleterole/')?>' + activeDeleteRoleId;
      }
    });
  });
});
</script>
