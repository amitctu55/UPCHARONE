<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Test Parameters Master</h1>
        <small style="color: #64748b; font-size: 13px;">Manage reference ranges, biological limits, and test parameters</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/pathtest/parameter')?>" style="color: #64748b;">Pathology</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Parameters</li>
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
            <i class="fa fa-sliders" style="color: #00a896;"></i>
            <span>Test Parameters Directory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-param-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="param-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/pathtest/addparameter')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Add Parameter
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter & Search Toolbar -->
          <form action="<?=base_url('doctor/pathtest/parameter')?>" method="get" id="search_form" class="master-toolbar">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
              <div style="width: 85px;">
                <?php echo display_record_per_page();?>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
              <div style="width: 250px;">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" class="form-control" name="keyword" placeholder="Search parameter name..." value="<?=$this->input->get_post('keyword');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>

              <?php if($this->input->get_post('keyword')!=''): ?>
                <a href="<?=base_url('doctor/pathtest/parameter')?>" class="btn btn-sm btn-default" title="Clear Search" style="height: 34px; line-height: 22px; border-radius: 6px;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="param-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-params" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Parameter Name</th>
                  <th>Reference Range</th>
                  <th>Unit</th>
                  <th>Description</th>
                  <th style="width: 110px; text-align: center;">Status</th>
                  <th style="width: 100px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($data)): foreach($data as $p): 
                  $paramId = is_object($p) ? $p->parameter_id : $p['parameter_id'];
                  $paramName = is_object($p) ? $p->parameter_name : $p['parameter_name'];
                  $refRange = is_object($p) ? $p->reference_range : (!empty($p['reference_range']) ? $p['reference_range'] : 'N/A');
                  $unitName = is_object($p) ? $p->unit_name : (!empty($p['unit_name']) ? $p['unit_name'] : '-');
                  $desc = is_object($p) ? $p->description : (!empty($p['description']) ? $p['description'] : '');
                  $paramStatus = is_object($p) ? $p->status : (!empty($p['status']) ? $p['status'] : 1);
                  $isActive = ($paramStatus == '1');
                ?>
                  <tr id="row-<?=$paramId;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="param-checkbox" value="<?=$paramId;?>" data-name="<?=htmlspecialchars($paramName);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$paramId;?></td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($paramName);?></strong>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #334155 !important; border: 1px solid #e2e8f0; font-size: 12px;">
                        <?=htmlspecialchars($refRange);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-size: 11.5px;">
                        <?=htmlspecialchars($unitName);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle;">
                      <small style="color: #64748b; font-size: 11.5px;"><?=character_limiter(strip_tags($desc), 50);?></small>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?>">
                        <i class="fa fa-circle" style="font-size: 6px;"></i>
                        <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                      </span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/pathtest/editparameter/'.$paramId);?>" class="btn-icon-action btn-action-edit" title="Edit Parameter">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="<?=base_url('doctor/pathtest/parameter_delete?parameter_id='.$paramId);?>" class="btn-icon-action btn-action-delete delete-param-btn" data-id="<?=$paramId;?>" data-name="<?=htmlspecialchars($paramName);?>" title="Delete Parameter">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-sliders fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No test parameters found.</p>
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
<div class="modal fade" id="deleteParamModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Test Parameter</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-param-name" style="color: #1e293b;">this parameter</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-param-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteParamModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Parameters</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-param-count" style="color: #dc2626;">0</strong> selected parameter records? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-param-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateParamBulkState() {
  var checkedBoxes = $('.param-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.param-checkbox').length;

  $('#param-selected-count').text(count);
  $('#bulk-param-count').text(count);

  if (count > 0) {
    $('#bulk-delete-param-btn').fadeIn(200);
  } else {
    $('#bulk-delete-param-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-params').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-params').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-params').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-params', function(){
    var isChecked = $(this).prop('checked');
    $('.param-checkbox').prop('checked', isChecked);
    updateParamBulkState();
  });

  $(document).on('change', '.param-checkbox', function(){
    updateParamBulkState();
  });

  $(document).on('click', '#bulk-delete-param-btn', function(){
    if ($('.param-checkbox:checked').length === 0) return;
    $('#bulkDeleteParamModal').modal('show');
  });

  $('#confirm-bulk-delete-param-btn').click(function(){
    var selectedIds = [];
    $('.param-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathtest/bulk_delete_parameter')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteParamModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#param-table tbody tr').length === 0) {
              $('#param-table tbody').html('<tr><td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-sliders fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No test parameters found.</p></td></tr>');
            }
          });
        });

        updateParamBulkState();
        showToast(res.message || 'Selected parameters deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting parameters.', 'danger');
      }
    });
  });

  // Delete Single Parameter
  var activeDeleteParamId = null;
  $(document).on('click', '.delete-param-btn', function(e){
    e.preventDefault();
    activeDeleteParamId = $(this).data('id');
    var name = $(this).data('name') || 'this parameter';
    $('#delete-param-name').text('"' + name + '"');
    $('#deleteParamModal').modal('show');
  });

  $('#confirm-delete-param-btn').click(function(){
    if(!activeDeleteParamId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathtest/parameter_delete')?>',
      dataType: 'json',
      data: { id: activeDeleteParamId, parameter_id: activeDeleteParamId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteParamModal').modal('hide');
        $('#row-' + activeDeleteParamId).fadeOut(400, function(){
          $(this).remove();
          if ($('#param-table tbody tr').length === 0) {
            $('#param-table tbody').html('<tr><td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-sliders fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No test parameters found.</p></td></tr>');
          }
          updateParamBulkState();
        });
        showToast(res.message || 'Parameter deleted successfully.', 'success');
        activeDeleteParamId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/pathtest/parameter_delete?parameter_id=')?>' + activeDeleteParamId;
      }
    });
  });
});
</script>
