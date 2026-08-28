<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          Assigned Pathology Tests
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Manage mapping of diagnostic tests to authorized pathology laboratories</p>
      </div>
      <div style="display: flex; gap: 10px; align-items: center;">
        <button type="button" id="bulk-delete-assign-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
          <i class="fa fa-trash"></i> Delete Selected (<span id="assign-selected-count">0</span>)
        </button>
        <a href="<?=base_url();?>doctor/pathology/add" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; color: #FFFFFF; font-weight: 600; padding: 8px 18px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; font-size: 13px;">
          <i class="fa fa-plus"></i> Assign Test to Lab
        </a>
      </div>
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
            <i class="fa fa-flask" style="color: #00a896;"></i>
            <span>Lab Test Assignments Directory</span>
          </h3>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter Toolbar -->
          <form action="<?=base_url('doctor/pathology/index')?>" method="get" id="search_form" class="master-toolbar">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
              <div style="width: 85px;">
                <?php echo display_record_per_page();?>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
              <div style="width: 260px;">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" class="form-control" name="keyword" placeholder="Search test or lab name..." value="<?=$this->input->get_post('keyword');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>

              <?php if($this->input->get_post('keyword')!=''): ?>
                <a href="<?=base_url('doctor/pathology/index')?>" class="btn btn-sm btn-default" title="Clear Search" style="height: 34px; line-height: 22px; border-radius: 6px;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="assign-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-assigns" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Pathology Laboratory</th>
                  <th>Diagnostic Test Name</th>
                  <th style="width: 110px; text-align: center;">Status</th>
                  <th style="width: 80px; text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($result)): foreach($result as $val): 
                  $aid = $val['id'];
                  $tname = $val['test_name'];
                  $labname = $val['name'];
                  $isActive = ($val['status'] == '1');
                ?>
                  <tr id="row-<?=$aid;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="assign-checkbox" value="<?=$aid;?>" data-name="<?=htmlspecialchars($tname . ' (' . $labname . ')');?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;">#<?=$aid;?></td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #1e293b; font-size: 13.5px;"><i class="fa fa-hospital-o text-muted"></i> <?=htmlspecialchars($labname);?></strong>
                    </td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #00a896; font-size: 13.5px;"><i class="fa fa-flask"></i> <?=htmlspecialchars($tname);?></strong>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?>">
                        <i class="fa fa-circle" style="font-size: 6px;"></i>
                        <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                      </span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/pathology/assign_test_delete?id='.$aid);?>" class="btn-icon-action btn-action-delete delete-assign-btn" data-id="<?=$aid;?>" data-name="<?=htmlspecialchars($tname.' ('.$labname.')');?>" title="Unassign Test">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="6" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No test assignments found.</p>
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
<div class="modal fade" id="deleteAssignModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Unassign Test</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to unassign <strong id="delete-assign-name" style="color: #1e293b;">this test</strong>?
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-assign-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Unassign
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteAssignModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Assignments</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-assign-count" style="color: #dc2626;">0</strong> selected test assignments?
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-assign-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateAssignBulkState() {
  var checkedBoxes = $('.assign-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.assign-checkbox').length;

  $('#assign-selected-count').text(count);
  $('#bulk-assign-count').text(count);

  if (count > 0) {
    $('#bulk-delete-assign-btn').fadeIn(200);
  } else {
    $('#bulk-delete-assign-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-assigns').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-assigns').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-assigns').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-assigns', function(){
    var isChecked = $(this).prop('checked');
    $('.assign-checkbox').prop('checked', isChecked);
    updateAssignBulkState();
  });

  $(document).on('change', '.assign-checkbox', function(){
    updateAssignBulkState();
  });

  $(document).on('click', '#bulk-delete-assign-btn', function(){
    if ($('.assign-checkbox:checked').length === 0) return;
    $('#bulkDeleteAssignModal').modal('show');
  });

  $('#confirm-bulk-delete-assign-btn').click(function(){
    var selectedIds = [];
    $('.assign-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathology/bulk_delete')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteAssignModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#assign-table tbody tr').length === 0) {
              $('#assign-table tbody').html('<tr><td colspan="6" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No test assignments found.</p></td></tr>');
            }
          });
        });

        updateAssignBulkState();
        showToast(res.message || 'Selected assignments deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting test assignments.', 'danger');
      }
    });
  });

  // Delete Single Test Assignment
  var activeDeleteAssignId = null;
  $(document).on('click', '.delete-assign-btn', function(e){
    e.preventDefault();
    activeDeleteAssignId = $(this).data('id');
    var name = $(this).data('name') || 'this test';
    $('#delete-assign-name').text('"' + name + '"');
    $('#deleteAssignModal').modal('show');
  });

  $('#confirm-delete-assign-btn').click(function(){
    if(!activeDeleteAssignId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathology/assign_test_delete')?>',
      dataType: 'json',
      data: { id: activeDeleteAssignId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Unassign');
        $('#deleteAssignModal').modal('hide');
        $('#row-' + activeDeleteAssignId).fadeOut(400, function(){
          $(this).remove();
          if ($('#assign-table tbody tr').length === 0) {
            $('#assign-table tbody').html('<tr><td colspan="6" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No test assignments found.</p></td></tr>');
          }
          updateAssignBulkState();
        });
        showToast(res.message || 'Test assignment removed.', 'success');
        activeDeleteAssignId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Unassign');
        window.location.href = '<?=base_url('doctor/pathology/assign_test_delete?id=')?>' + activeDeleteAssignId;
      }
    });
  });
});
</script>
