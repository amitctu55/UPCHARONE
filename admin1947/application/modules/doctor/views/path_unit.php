<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: gap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Pathology Measurement Units</h1>
        <small style="color: #64748b; font-size: 13px;">Manage diagnostic test measurement units and reporting formats</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/pathtest/unit')?>" style="color: #64748b;">Pathology</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Units</li>
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

      <div class="row">
        <!-- LEFT: Add Unit Sticky Form (4 Cols) -->
        <div class="col-lg-4 col-md-5">
          <div class="master-card master-sticky-form">
            <div class="master-card-header">
              <h3 class="master-card-title">
                <i class="fa fa-plus-circle" style="color: #00a896;"></i>
                <span>Add Measurement Unit</span>
              </h3>
            </div>
            <form action="<?=base_url('doctor/pathtest/addunit')?>" method="post" class="master-card-body" style="padding: 20px;">
              <div class="form-group" style="margin-bottom: 20px;">
                <label for="unit_name" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  Unit Name / Symbol <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="e.g. mg/dL, g/dL, mmol/L, %" required style="border-radius: 8px; height: 40px;">
                <small class="text-muted" style="font-size: 11.5px; margin-top: 4px; display: block;">Enter standard laboratory metric unit.</small>
              </div>

              <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <button type="reset" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 8px 18px;">
                  <i class="fa fa-refresh"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 8px 22px; background: #00a896; border-color: #00a896;">
                  <i class="fa fa-check"></i> Add Unit
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- RIGHT: Units List Table (8 Cols) -->
        <div class="col-lg-8 col-md-7">
          <div class="master-card">
            <div class="master-card-header">
              <h3 class="master-card-title">
                <i class="fa fa-balance-scale" style="color: #00a896;"></i>
                <span>Lab Units Directory</span>
              </h3>
              <button type="button" id="bulk-delete-unit-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
                <i class="fa fa-trash"></i> Delete Selected (<span id="unit-selected-count">0</span>)
              </button>
            </div>

            <div class="master-card-body" style="padding: 16px 20px;">
              <!-- Toolbar -->
              <form action="<?=base_url('doctor/pathtest/unit')?>" method="get" id="search_form" class="master-toolbar">
                <div style="display: flex; align-items: center; gap: 8px;">
                  <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
                  <div style="width: 85px;">
                    <?php echo display_record_per_page();?>
                  </div>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1; max-width: 380px;">
                  <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="text" class="form-control" name="keyword" placeholder="Search unit symbol..." value="<?=$this->input->get_post('keyword');?>" style="border-radius: 6px 0 0 6px; height: 34px;">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary" style="border-radius: 0 6px 6px 0; height: 34px; background: #00a896; border-color: #00a896;">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                  <?php if($this->input->get_post('keyword')!=''): ?>
                    <a href="<?=base_url('doctor/pathtest/unit')?>" class="btn btn-sm btn-default" title="Clear Search" style="border-radius: 6px; height: 34px; line-height: 22px;">
                      <i class="fa fa-times text-danger"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </form>

              <!-- Table -->
              <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                <table class="table table-hover table-striped" id="unit-table" style="margin: 0;">
                  <thead>
                    <tr>
                      <th style="width: 40px; text-align: center;">
                        <input type="checkbox" id="select-all-units" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                      </th>
                      <th style="width: 60px; text-align: center;">#ID</th>
                      <th>Unit Name / Symbol</th>
                      <th style="width: 110px; text-align: center;">Status</th>
                      <th style="width: 100px; text-align: center;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($data)): foreach($data as $p): 
                      $unitId = is_object($p) ? $p->unit_id : $p['unit_id'];
                      $unitName = is_object($p) ? $p->unit_name : $p['unit_name'];
                      $unitStatus = is_object($p) ? $p->status : $p['status'];
                      $isActive = ($unitStatus == '1');
                    ?>
                      <tr id="row-<?=$unitId;?>">
                        <td style="text-align: center; vertical-align: middle;">
                          <input type="checkbox" class="unit-checkbox" value="<?=$unitId;?>" data-name="<?=htmlspecialchars($unitName);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                        </td>
                        <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$unitId;?></td>
                        <td style="vertical-align: middle;">
                          <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($unitName);?></strong>
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                          <span class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?>">
                            <i class="fa fa-circle" style="font-size: 6px;"></i>
                            <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                          </span>
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                          <a href="<?=base_url('doctor/pathtest/editunit/'.$unitId);?>" class="btn-icon-action btn-action-edit" title="Edit Unit">
                            <i class="fa fa-pencil"></i>
                          </a>
                          <a href="<?=base_url('doctor/pathtest/unit_delete?unit_id='.$unitId);?>" class="btn-icon-action btn-action-delete delete-unit-btn" data-id="<?=$unitId;?>" data-name="<?=htmlspecialchars($unitName);?>" title="Delete Unit">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; else: ?>
                      <tr>
                        <td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                          <i class="fa fa-balance-scale fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                          <p style="font-size: 14px; font-weight: 500; margin: 0;">No measurement units found.</p>
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
      </div>

    </div>
  </section>
</div>

<!-- Single Delete Confirmation Modal -->
<div class="modal fade" id="deleteUnitModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Measurement Unit</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-unit-name" style="color: #1e293b;">this unit</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-unit-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteUnitModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Units</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-unit-count" style="color: #dc2626;">0</strong> selected unit records? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-unit-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateUnitBulkState() {
  var checkedBoxes = $('.unit-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.unit-checkbox').length;

  $('#unit-selected-count').text(count);
  $('#bulk-unit-count').text(count);

  if (count > 0) {
    $('#bulk-delete-unit-btn').fadeIn(200);
  } else {
    $('#bulk-delete-unit-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-units').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-units').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-units').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-units', function(){
    var isChecked = $(this).prop('checked');
    $('.unit-checkbox').prop('checked', isChecked);
    updateUnitBulkState();
  });

  $(document).on('change', '.unit-checkbox', function(){
    updateUnitBulkState();
  });

  $(document).on('click', '#bulk-delete-unit-btn', function(){
    if ($('.unit-checkbox:checked').length === 0) return;
    $('#bulkDeleteUnitModal').modal('show');
  });

  $('#confirm-bulk-delete-unit-btn').click(function(){
    var selectedIds = [];
    $('.unit-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathtest/bulk_delete_unit')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteUnitModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#unit-table tbody tr').length === 0) {
              $('#unit-table tbody').html('<tr><td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-balance-scale fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No measurement units found.</p></td></tr>');
            }
          });
        });

        updateUnitBulkState();
        showToast(res.message || 'Selected units deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting units.', 'danger');
      }
    });
  });

  // Delete Single Unit
  var activeDeleteUnitId = null;
  $(document).on('click', '.delete-unit-btn', function(e){
    e.preventDefault();
    activeDeleteUnitId = $(this).data('id');
    var name = $(this).data('name') || 'this unit';
    $('#delete-unit-name').text('"' + name + '"');
    $('#deleteUnitModal').modal('show');
  });

  $('#confirm-delete-unit-btn').click(function(){
    if(!activeDeleteUnitId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathtest/unit_delete')?>',
      dataType: 'json',
      data: { id: activeDeleteUnitId, unit_id: activeDeleteUnitId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteUnitModal').modal('hide');
        $('#row-' + activeDeleteUnitId).fadeOut(400, function(){
          $(this).remove();
          if ($('#unit-table tbody tr').length === 0) {
            $('#unit-table tbody').html('<tr><td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-balance-scale fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No measurement units found.</p></td></tr>');
          }
          updateUnitBulkState();
        });
        showToast(res.message || 'Unit deleted successfully.', 'success');
        activeDeleteUnitId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/pathtest/unit_delete?unit_id=')?>' + activeDeleteUnitId;
      }
    });
  });
});
</script>
