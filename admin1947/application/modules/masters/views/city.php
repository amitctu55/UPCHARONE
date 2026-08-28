<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">City Master</h1>
        <small style="color: #64748b; font-size: 13px;">Manage operational cities and healthcare coverage regions</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('masters/city')?>" style="color: #64748b;">Masters</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">City</li>
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

      <div class="row">
        <!-- LEFT COLUMN: Sticky Add / Edit Card (4 Cols) -->
        <div class="col-lg-4 col-md-5">
          <div class="master-card master-sticky-form">
            <div class="master-card-header">
              <h3 class="master-card-title">
                <i class="fa fa-plus-circle" style="color: #00a896;" id="form-icon"></i>
                <span id="form-title">Add City</span>
              </h3>
              <span class="label label-info" id="mode-badge" style="background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd;">New Entry</span>
            </div>

            <form action="<?=base_url('masters/city/create')?>" method="post" id="master-form" class="master-card-body">
              <input type="hidden" id="eid" name="eid" value="">

              <div class="form-group" style="margin-bottom: 20px;">
                <label for="city_name" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                  City Name <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" class="form-control" id="city_name" name="city" 
                       placeholder="e.g. Varanasi, Lucknow, Prayagraj, Gorakhpur" required
                       style="border-radius: 8px; height: 40px;">
                <small class="text-muted" style="font-size: 11.5px; margin-top: 4px; display: block;">Enter operational city or municipality title.</small>
              </div>

              <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <button type="button" id="reset-btn" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 8px 18px;">
                  <i class="fa fa-refresh"></i> Reset
                </button>
                <button type="submit" id="submit-btn" name="submit" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 8px 22px; background: #00a896; border-color: #00a896;">
                  <i class="fa fa-check"></i> <span id="submit-text">Add City</span>
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- RIGHT COLUMN: Search Toolbar & Modern Data Table (8 Cols) -->
        <div class="col-lg-8 col-md-7">
          <div class="master-card">
            <div class="master-card-header">
              <h3 class="master-card-title">
                <i class="fa fa-building" style="color: #00a896;"></i>
                <span>Operational Cities List</span>
              </h3>
              <span style="font-size: 12px; color: #64748b; font-weight: 500;">
                Total Records: <strong><?=(isset($config['total_rows']) ? $config['total_rows'] : count($city));?></strong>
              </span>
            </div>

            <div class="master-card-body" style="padding: 16px 20px;">
              <!-- Search & Records Per Page Toolbar -->
              <form action="<?=base_url('masters/city')?>" method="get" id="search_form" class="master-toolbar">
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                  <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
                  <div style="width: 90px;">
                    <?php echo display_record_per_page();?>
                  </div>
                </div>

                <div style="display: flex; align-items: center; gap: 8px; flex-grow: 1; max-width: 380px;">
                  <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="text" class="form-control" name="keyword" placeholder="Search by city name..." 
                           value="<?=$this->input->get_post('keyword');?>" style="border-radius: 6px 0 0 6px; height: 34px;">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary" style="border-radius: 0 6px 6px 0; height: 34px; background: #00a896; border-color: #00a896;">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                  <?php if($this->input->get_post('keyword')!=''): ?>
                    <a href="<?=base_url('masters/city')?>" class="btn btn-sm btn-default" title="Clear Search" style="border-radius: 6px; height: 34px; line-height: 22px;">
                      <i class="fa fa-times text-danger"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </form>

              <!-- Modern Data Table -->
              <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                <table class="table table-hover table-striped" style="margin: 0;">
                  <thead>
                    <tr>
                      <th style="width: 60px; text-align: center;">#ID</th>
                      <th>City Name</th>
                      <th style="width: 120px; text-align: center;">Status</th>
                      <th style="width: 110px; text-align: center;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($city)): ?>
                      <?php foreach($city as $rowdata): 
                        $status = $rowdata['status'];
                        $isActive = ($status == 1);
                      ?>
                        <tr id="row-<?=$rowdata['id'];?>">
                          <td style="text-align: center; font-weight: 600; color: #64748b;"><?=$rowdata['id'];?></td>
                          <td>
                            <strong style="color: #1e293b; font-size: 13.5px;"><?=$rowdata['name'];?></strong>
                          </td>
                          <td style="text-align: center;">
                            <a href="javascript:void(0);" class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?> status-toggle-btn" 
                               data-id="<?=$rowdata['id'];?>" title="Click to toggle status">
                              <i class="fa fa-circle" style="font-size: 7px;"></i>
                              <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                            </a>
                          </td>
                          <td style="text-align: center;">
                            <a href="javascript:void(0);" class="btn-icon-action btn-action-edit select-edit-btn" 
                               data-id="<?=base64_encode($rowdata['id']);?>" 
                               data-name="<?=htmlspecialchars($rowdata['name']);?>"
                               title="Edit City">
                              <i class="fa fa-pencil"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn-icon-action btn-action-delete delete-prompt-btn" 
                               data-id="<?=$rowdata['id'];?>" 
                               data-name="<?=htmlspecialchars($rowdata['name']);?>"
                               title="Delete City">
                              <i class="fa fa-trash-o"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="4" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                          <i class="fa fa-folder-open-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                          <p style="font-size: 14px; font-weight: 500; margin: 0;">No city records found.</p>
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

<!-- Generic Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Confirm Deletion</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-item-title" style="color: #1e293b;">this city</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery and Interactive Scripting -->
<script>
$(document).ready(function(){
  var deleteId = null;

  // Edit / Populate Form
  $('.select-edit-btn').click(function(){
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');

    $('#eid').val(id);
    $('#city_name').val(name).focus();
    $('#form-title').text('Edit City');
    $('#form-icon').removeClass('fa-plus-circle').addClass('fa-pencil-square-o');
    $('#mode-badge').text('Editing Mode').css({'background-color': '#fef3c7', 'color': '#d97706', 'border-color': '#fde68a'});
    $('#submit-text').text('Update City');

    $('html, body').animate({ scrollTop: $('#master-form').offset().top - 100 }, 300);
  });

  // Reset Form
  $('#reset-btn').click(function(){
    $('#eid').val('');
    $('#city_name').val('');
    $('#form-title').text('Add City');
    $('#form-icon').removeClass('fa-pencil-square-o').addClass('fa-plus-circle');
    $('#mode-badge').text('New Entry').css({'background-color': '#e0f2fe', 'color': '#0284c7', 'border-color': '#bae6fd'});
    $('#submit-text').text('Add City');
  });

  // Status Toggle via AJAX
  $('.status-toggle-btn').click(function(){
    var $btn = $(this);
    var uid = $btn.attr('data-id');
    var uri = '<?=base_url('masters/city/statusupdate')?>';

    $btn.css('opacity', '0.5');
    $.ajax({
      type: 'POST',
      url: uri,
      data: { uid: uid },
      success: function(res) {
        $btn.css('opacity', '1');
        if(res.trim() == 'Show' || res.indexOf('Show') !== -1) {
          $btn.removeClass('badge-status-inactive').addClass('badge-status-active');
          $btn.find('span').text('Active');
        } else {
          $btn.removeClass('badge-status-active').addClass('badge-status-inactive');
          $btn.find('span').text('Inactive');
        }
      },
      error: function() {
        $btn.css('opacity', '1');
        location.reload();
      }
    });
  });

  // Delete Prompt Modal Trigger
  $('.delete-prompt-btn').click(function(){
    deleteId = $(this).attr('data-id');
    var itemName = $(this).attr('data-name');
    $('#delete-item-title').text('"' + itemName + '"');
    $('#deleteConfirmModal').modal('show');
  });

  // Confirm Delete Action
  $('#confirm-delete-btn').click(function(){
    if(!deleteId) return;
    var uri = '<?=base_url('masters/city/delete')?>/' + deleteId;

    $('#confirm-delete-btn').prop('disabled', true).text('Deleting...');
    $.ajax({
      type: 'POST',
      url: uri,
      success: function(res) {
        $('#deleteConfirmModal').modal('hide');
        $('#confirm-delete-btn').prop('disabled', false).text('Yes, Delete');
        if(res.trim() == 'Y') {
          $('#row-' + deleteId).fadeOut(300, function(){ $(this).remove(); });
        } else {
          location.reload();
        }
      },
      error: function() {
        location.reload();
      }
    });
  });
});
</script>
