<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Hospital Packages</h1>
        <small style="color: #64748b; font-size: 13px;">Manage hospital health checkups, surgery packages, and wellness plans</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/package')?>" style="color: #64748b;">Facilities</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Packages</li>
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
            <i class="fa fa-medkit" style="color: #00a896;"></i>
            <span>Health Packages Directory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-pkg-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="pkg-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/package/add')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Add New Package
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter & Search Toolbar -->
          <form action="<?=base_url('doctor/package')?>" method="get" id="search_form" class="master-toolbar">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
              <div style="width: 85px;">
                <?php echo display_record_per_page();?>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
              <div style="width: 250px;">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" class="form-control" name="title" placeholder="Search package title..." value="<?=$this->input->get_post('title');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>

              <?php if($this->input->get_post('title')!=''): ?>
                <a href="<?=base_url('doctor/package')?>" class="btn btn-sm btn-default" title="Clear Search" style="height: 34px; line-height: 22px; border-radius: 6px;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="package-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-packages" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 70px; text-align: center;">Photo</th>
                  <th>Package Title</th>
                  <th>Hospital Name</th>
                  <th style="width: 110px; text-align: center;">Approval</th>
                  <th style="width: 100px; text-align: center;">Date</th>
                  <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $pkgData = !empty($packagelist) ? $packagelist : (!empty($result) ? $result : array());
                if(!empty($pkgData)): foreach($pkgData as $val): 
                  $isApproved = ($val['approved'] == 1);
                  $imgUrl = !empty($val['image']) ? base_url('public/assets/upload/'.$val['image']) : '';
                  $pkgId = !empty($val['package_id']) ? $val['package_id'] : $val['id'];
                ?>
                  <tr id="row-<?=$pkgId;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="package-checkbox" value="<?=$pkgId;?>" data-name="<?=htmlspecialchars($val['title']);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <?php if($imgUrl): ?>
                        <img src="<?=$imgUrl;?>" alt="Package" style="width: 44px; height: 44px; border-radius: 6px; object-fit: cover; border: 1px solid #e2e8f0;">
                      <?php else: ?>
                        <div style="width: 44px; height: 44px; border-radius: 6px; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8;">
                          <i class="fa fa-medkit"></i>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($val['title']);?></div>
                      <small style="color: #64748b; font-size: 11px;">ID: PKG-<?=$pkgId;?></small>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-hospital-o"></i> <?=!empty($val['name']) ? htmlspecialchars($val['name']) : 'General Health';?>
                      </span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/package/approve/'.$pkgId);?>" class="badge-pill-status <?=$isApproved ? 'badge-status-active' : 'badge-status-inactive';?> action-pkg-approve" data-id="<?=$pkgId;?>" data-name="<?=htmlspecialchars($val['title']);?>" title="Toggle Approval">
                        <i class="fa fa-circle" style="font-size: 7px;"></i>
                        <span><?=$isApproved ? 'Approved' : 'Pending';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b; vertical-align: middle;">
                      <?=date('d M Y', strtotime($val['creat_date']));?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/package/update/'.$pkgId);?>" class="btn-icon-action btn-action-edit" title="Edit Package">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="<?=base_url('doctor/package/delete/'.$pkgId);?>" class="btn-icon-action btn-action-delete delete-pkg-btn" data-id="<?=$pkgId;?>" data-name="<?=htmlspecialchars($val['title']);?>" title="Delete Package">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-medkit fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No health packages found.</p>
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
<div class="modal fade" id="deletePackageModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Health Package</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-pkg-name" style="color: #1e293b;">this package</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-pkg-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulkDeletePackageModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Packages</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-pkg-count" style="color: #dc2626;">0</strong> selected packages? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-pkg-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updatePkgBulkState() {
  var checkedBoxes = $('.package-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.package-checkbox').length;

  $('#pkg-selected-count').text(count);
  $('#bulk-pkg-count').text(count);

  if (count > 0) {
    $('#bulk-delete-pkg-btn').fadeIn(200);
  } else {
    $('#bulk-delete-pkg-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-packages').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-packages').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-packages').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-packages', function(){
    var isChecked = $(this).prop('checked');
    $('.package-checkbox').prop('checked', isChecked);
    updatePkgBulkState();
  });

  $(document).on('change', '.package-checkbox', function(){
    updatePkgBulkState();
  });

  $(document).on('click', '#bulk-delete-pkg-btn', function(){
    if ($('.package-checkbox:checked').length === 0) return;
    $('#bulkDeletePackageModal').modal('show');
  });

  $('#confirm-bulk-delete-pkg-btn').click(function(){
    var selectedIds = [];
    $('.package-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/package/bulk_delete')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeletePackageModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#package-table tbody tr').length === 0) {
              $('#package-table tbody').html('<tr><td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-medkit fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No health packages found.</p></td></tr>');
            }
          });
        });

        updatePkgBulkState();
        showToast(res.message || 'Selected packages deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting packages.', 'danger');
      }
    });
  });

  // Package Approval AJAX
  $(document).on('click', '.action-pkg-approve', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var pkgName = $t.data('name') || 'Package';
    var uri = '<?=base_url('doctor/package/approve')?>';
    
    $t.css('opacity', '0.5');
    $.ajax({
      type: "POST",
      url: uri,
      dataType: 'json',
      data: { did: key, id: key },
      success: function(result){
        $t.css('opacity', '1');
        if(result['status'] == 1 || result['status'] == '1') {
          $t.removeClass('badge-status-inactive').addClass('badge-status-active');
          $t.find('span').text('Approved');
          showToast(pkgName + ' has been approved.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Pending');
          showToast(pkgName + ' approval set to Pending.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // Delete Single Package
  var activeDeletePkgId = null;
  $(document).on('click', '.delete-pkg-btn', function(e){
    e.preventDefault();
    activeDeletePkgId = $(this).data('id');
    var name = $(this).data('name') || 'this package';
    $('#delete-pkg-name').text('"' + name + '"');
    $('#deletePackageModal').modal('show');
  });

  $('#confirm-delete-pkg-btn').click(function(){
    if(!activeDeletePkgId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/package/delete')?>',
      dataType: 'json',
      data: { id: activeDeletePkgId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deletePackageModal').modal('hide');
        $('#row-' + activeDeletePkgId).fadeOut(400, function(){
          $(this).remove();
          if ($('#package-table tbody tr').length === 0) {
            $('#package-table tbody').html('<tr><td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-medkit fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No health packages found.</p></td></tr>');
          }
          updatePkgBulkState();
        });
        showToast(res.message || 'Package deleted successfully.', 'success');
        activeDeletePkgId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/package/delete/')?>' + activeDeletePkgId;
      }
    });
  });
});
</script>
