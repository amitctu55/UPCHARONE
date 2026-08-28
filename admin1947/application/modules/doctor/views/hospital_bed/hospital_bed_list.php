<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Hospital Bed Availability</h1>
        <small style="color: #64748b; font-size: 13px;">Monitor real-time ward capacity, ICU, and emergency bed counts</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/hospital_bed')?>" style="color: #64748b;">Facilities</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Hospital Bed</li>
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

      <!-- Toast Container -->
      <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

      <div class="master-card">
        <div class="master-card-header">
          <h3 class="master-card-title">
            <i class="fa fa-bed" style="color: #00a896;"></i>
            <span>Hospital Bed Inventory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-bed-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="bed-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/hospital_bed/add')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Add Bed Inventory
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter Toolbar -->
          <form action="<?=base_url('doctor/hospital_bed')?>" method="get" id="search_form" class="master-toolbar">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
              <div style="width: 85px;">
                <?php echo display_record_per_page();?>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
              <div style="width: 250px;">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" class="form-control" name="title" placeholder="Search bed type..." value="<?=$this->input->get_post('title');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>

              <?php if($this->input->get_post('title')!=''): ?>
                <a href="<?=base_url('doctor/hospital_bed')?>" class="btn btn-sm btn-default" title="Clear Search" style="height: 34px; line-height: 22px; border-radius: 6px;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="bed-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-beds" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th>Hospital Name</th>
                  <th>Bed Category / Type</th>
                  <th style="width: 100px; text-align: center;">Total Beds</th>
                  <th style="width: 110px; text-align: center;">Occupied</th>
                  <th style="width: 110px; text-align: center;">Available</th>
                  <th>Comments / Ward Info</th>
                  <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $bedData = !empty($result) ? $result : (!empty($hospital_bed) ? $hospital_bed : array());
                if(!empty($bedData)): foreach($bedData as $val): 
                  $bedId = !empty($val['hospital_bed_id']) ? $val['hospital_bed_id'] : $val['id'];
                  $available = max(0, intval($val['total_bed']) - intval($val['occupied_bed']));
                ?>
                  <tr id="row-<?=$bedId;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="bed-checkbox" value="<?=$bedId;?>" data-name="<?=htmlspecialchars($val['bed_type']);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;"><?=!empty($val['hospital_name']) ? htmlspecialchars($val['hospital_name']) : (!empty($val['name']) ? htmlspecialchars($val['name']) : 'General Hospital');?></div>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-size: 12px;">
                        <i class="fa fa-bed"></i> <?=htmlspecialchars($val['bed_type']);?>
                      </span>
                    </td>
                    <td style="text-align: center; font-weight: 700; color: #1e293b; vertical-align: middle;">
                      <?=$val['total_bed'];?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge" style="background-color: #ef4444; font-weight: 600;"><?=$val['occupied_bed'];?></span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <span class="badge" style="background-color: #10b981; font-weight: 600;"><?=$available;?></span>
                    </td>
                    <td style="font-size: 12.5px; color: #64748b; vertical-align: middle;">
                      <?=!empty($val['comment']) ? htmlspecialchars($val['comment']) : '-';?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/hospital_bed/update/'.$bedId);?>" class="btn-icon-action btn-action-edit" title="Edit Bed Info">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="<?=base_url('doctor/hospital_bed/delete/'.$bedId);?>" class="btn-icon-action btn-action-delete delete-bed-btn" data-id="<?=$bedId;?>" data-name="<?=htmlspecialchars($val['bed_type']);?>" title="Delete Bed Record">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-bed fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No hospital bed inventory records found.</p>
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

<!-- Single Delete Modal -->
<div class="modal fade" id="deleteBedModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Bed Inventory</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-bed-name" style="color: #1e293b;">this bed record</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-bed-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulkDeleteBedModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Bed Records</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-bed-count" style="color: #dc2626;">0</strong> selected bed inventory records? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-bed-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateBedBulkState() {
  var checkedBoxes = $('.bed-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.bed-checkbox').length;

  $('#bed-selected-count').text(count);
  $('#bulk-bed-count').text(count);

  if (count > 0) {
    $('#bulk-delete-bed-btn').fadeIn(200);
  } else {
    $('#bulk-delete-bed-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-beds').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-beds').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-beds').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-beds', function(){
    var isChecked = $(this).prop('checked');
    $('.bed-checkbox').prop('checked', isChecked);
    updateBedBulkState();
  });

  $(document).on('change', '.bed-checkbox', function(){
    updateBedBulkState();
  });

  $(document).on('click', '#bulk-delete-bed-btn', function(){
    if ($('.bed-checkbox:checked').length === 0) return;
    $('#bulkDeleteBedModal').modal('show');
  });

  $('#confirm-bulk-delete-bed-btn').click(function(){
    var selectedIds = [];
    $('.bed-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/hospital_bed/bulk_delete')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteBedModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#bed-table tbody tr').length === 0) {
              $('#bed-table tbody').html('<tr><td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-bed fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No hospital bed inventory records found.</p></td></tr>');
            }
          });
        });

        updateBedBulkState();
        showToast(res.message || 'Selected bed records deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting bed records.', 'danger');
      }
    });
  });

  // Delete Single Bed Record
  var activeDeleteBedId = null;
  $(document).on('click', '.delete-bed-btn', function(e){
    e.preventDefault();
    activeDeleteBedId = $(this).data('id');
    var name = $(this).data('name') || 'this bed record';
    $('#delete-bed-name').text('"' + name + '"');
    $('#deleteBedModal').modal('show');
  });

  $('#confirm-delete-bed-btn').click(function(){
    if(!activeDeleteBedId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/hospital_bed/delete')?>',
      dataType: 'json',
      data: { id: activeDeleteBedId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteBedModal').modal('hide');
        $('#row-' + activeDeleteBedId).fadeOut(400, function(){
          $(this).remove();
          if ($('#bed-table tbody tr').length === 0) {
            $('#bed-table tbody').html('<tr><td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-bed fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No hospital bed inventory records found.</p></td></tr>');
          }
          updateBedBulkState();
        });
        showToast(res.message || 'Bed record deleted successfully.', 'success');
        activeDeleteBedId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/hospital_bed/delete/')?>' + activeDeleteBedId;
      }
    });
  });
});
</script>
