<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Pathology Categories</h1>
        <small style="color: #64748b; font-size: 13px;">Manage diagnostic test classifications, departments, and panels</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/pathtest/category')?>" style="color: #64748b;">Pathology</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Categories</li>
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
        <!-- LEFT: Add Category Sticky Form (4 Cols) -->
        <div class="col-lg-4 col-md-5">
          <div class="master-card master-sticky-form">
            <div class="master-card-header">
              <h3 class="master-card-title">
                <i class="fa fa-plus-circle" style="color: #00a896;"></i>
                <span>Add Test Category</span>
              </h3>
            </div>
            <form action="<?=base_url('doctor/pathtest/addcategory')?>" method="post" class="master-card-body" style="padding: 20px;">
              <div class="form-group" style="margin-bottom: 20px;">
                <label for="category_name" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  Category Name <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="e.g. Biochemistry, Hematology, Immunology" required style="border-radius: 8px; height: 40px;">
                <small class="text-muted" style="font-size: 11.5px; margin-top: 4px; display: block;">Enter standard diagnostic panel name.</small>
              </div>

              <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <button type="reset" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 8px 18px;">
                  <i class="fa fa-refresh"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 8px 22px; background: #00a896; border-color: #00a896;">
                  <i class="fa fa-check"></i> Add Category
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- RIGHT: Category List Table (8 Cols) -->
        <div class="col-lg-8 col-md-7">
          <div class="master-card">
            <div class="master-card-header">
              <h3 class="master-card-title">
                <i class="fa fa-folder-open-o" style="color: #00a896;"></i>
                <span>Diagnostic Category List</span>
              </h3>
              <button type="button" id="bulk-delete-cat-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
                <i class="fa fa-trash"></i> Delete Selected (<span id="cat-selected-count">0</span>)
              </button>
            </div>

            <div class="master-card-body" style="padding: 16px 20px;">
              <!-- Toolbar -->
              <form action="<?=base_url('doctor/pathtest/category')?>" method="get" id="search_form" class="master-toolbar">
                <div style="display: flex; align-items: center; gap: 8px;">
                  <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
                  <div style="width: 85px;">
                    <?php echo display_record_per_page();?>
                  </div>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; flex-grow: 1; max-width: 380px;">
                  <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="text" class="form-control" name="keyword" placeholder="Search category..." value="<?=$this->input->get_post('keyword');?>" style="border-radius: 6px 0 0 6px; height: 34px;">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary" style="border-radius: 0 6px 6px 0; height: 34px; background: #00a896; border-color: #00a896;">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                  <?php if($this->input->get_post('keyword')!=''): ?>
                    <a href="<?=base_url('doctor/pathtest/category')?>" class="btn btn-sm btn-default" title="Clear Search" style="border-radius: 6px; height: 34px; line-height: 22px;">
                      <i class="fa fa-times text-danger"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </form>

              <!-- Table -->
              <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                <table class="table table-hover table-striped" id="category-table" style="margin: 0;">
                  <thead>
                    <tr>
                      <th style="width: 40px; text-align: center;">
                        <input type="checkbox" id="select-all-cats" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                      </th>
                      <th style="width: 60px; text-align: center;">#ID</th>
                      <th>Category Name</th>
                      <th style="width: 110px; text-align: center;">Status</th>
                      <th style="width: 100px; text-align: center;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($data)): foreach($data as $p): 
                      $catId = is_object($p) ? $p->category_id : $p['category_id'];
                      $catName = is_object($p) ? $p->category_name : $p['category_name'];
                      $catStatus = is_object($p) ? $p->status : $p['status'];
                      $isActive = ($catStatus == '1');
                    ?>
                      <tr id="row-<?=$catId;?>">
                        <td style="text-align: center; vertical-align: middle;">
                          <input type="checkbox" class="cat-checkbox" value="<?=$catId;?>" data-name="<?=htmlspecialchars($catName);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                        </td>
                        <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$catId;?></td>
                        <td style="vertical-align: middle;">
                          <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($catName);?></strong>
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                          <span class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?>">
                            <i class="fa fa-circle" style="font-size: 6px;"></i>
                            <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                          </span>
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                          <a href="<?=base_url('doctor/pathtest/editcategory/'.$catId);?>" class="btn-icon-action btn-action-edit" title="Edit Category">
                            <i class="fa fa-pencil"></i>
                          </a>
                          <a href="<?=base_url('doctor/pathtest/category_delete?category_id='.$catId);?>" class="btn-icon-action btn-action-delete delete-cat-btn" data-id="<?=$catId;?>" data-name="<?=htmlspecialchars($catName);?>" title="Delete Category">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; else: ?>
                      <tr>
                        <td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                          <i class="fa fa-folder-open-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                          <p style="font-size: 14px; font-weight: 500; margin: 0;">No test categories found.</p>
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
<div class="modal fade" id="deleteCatModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Test Category</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-cat-name" style="color: #1e293b;">this category</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-cat-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteCatModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Categories</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-cat-count" style="color: #dc2626;">0</strong> selected category records? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-cat-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateCatBulkState() {
  var checkedBoxes = $('.cat-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.cat-checkbox').length;

  $('#cat-selected-count').text(count);
  $('#bulk-cat-count').text(count);

  if (count > 0) {
    $('#bulk-delete-cat-btn').fadeIn(200);
  } else {
    $('#bulk-delete-cat-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-cats').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-cats').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-cats').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-cats', function(){
    var isChecked = $(this).prop('checked');
    $('.cat-checkbox').prop('checked', isChecked);
    updateCatBulkState();
  });

  $(document).on('change', '.cat-checkbox', function(){
    updateCatBulkState();
  });

  $(document).on('click', '#bulk-delete-cat-btn', function(){
    if ($('.cat-checkbox:checked').length === 0) return;
    $('#bulkDeleteCatModal').modal('show');
  });

  $('#confirm-bulk-delete-cat-btn').click(function(){
    var selectedIds = [];
    $('.cat-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathtest/bulk_delete_category')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteCatModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#category-table tbody tr').length === 0) {
              $('#category-table tbody').html('<tr><td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-folder-open-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No test categories found.</p></td></tr>');
            }
          });
        });

        updateCatBulkState();
        showToast(res.message || 'Selected categories deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting categories.', 'danger');
      }
    });
  });

  // Delete Single Category
  var activeDeleteCatId = null;
  $(document).on('click', '.delete-cat-btn', function(e){
    e.preventDefault();
    activeDeleteCatId = $(this).data('id');
    var name = $(this).data('name') || 'this category';
    $('#delete-cat-name').text('"' + name + '"');
    $('#deleteCatModal').modal('show');
  });

  $('#confirm-delete-cat-btn').click(function(){
    if(!activeDeleteCatId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathtest/category_delete')?>',
      dataType: 'json',
      data: { id: activeDeleteCatId, category_id: activeDeleteCatId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteCatModal').modal('hide');
        $('#row-' + activeDeleteCatId).fadeOut(400, function(){
          $(this).remove();
          if ($('#category-table tbody tr').length === 0) {
            $('#category-table tbody').html('<tr><td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-folder-open-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No test categories found.</p></td></tr>');
          }
          updateCatBulkState();
        });
        showToast(res.message || 'Category deleted successfully.', 'success');
        activeDeleteCatId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/pathtest/category_delete?category_id=')?>' + activeDeleteCatId;
      }
    });
  });
});
</script>
