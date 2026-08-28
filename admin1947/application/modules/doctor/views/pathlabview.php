<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Pathology Labs Directory</h1>
        <small style="color: #64748b; font-size: 13px;">Manage diagnostic centers, pathology labs, and test collection network</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/pathlabreg/viewpathology')?>" style="color: #64748b;">Pathology</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Pathlabs</li>
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

      <!-- Quick Status Filter KPI Badges -->
      <div class="row" style="margin: 0 -6px 16px;">
        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 0 6px; margin-bottom: 8px;">
          <a href="<?=base_url('doctor/pathlabreg/viewpathology')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='') ? '#00a896' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-flask"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">All Pathology Labs</div>
                  <div style="font-size: 16px; font-weight: 800; color: #0f172a;"><?=number_format($total_count ?? 0);?></div>
                </div>
              </div>
              <?php if($this->input->get_post('status_filter')==''): ?>
                <span class="badge" style="background: #00a896; font-size: 10px;">Active View</span>
              <?php endif; ?>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 0 6px; margin-bottom: 8px;">
          <a href="<?=base_url('doctor/pathlabreg/viewpathology?status_filter=approved'.($this->input->get_post('keyword') ? '&keyword='.$this->input->get_post('keyword') : ''))?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='approved'||$this->input->get_post('status_filter')=='registered') ? '#10b981' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-check-circle"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #15803d; text-transform: uppercase;">Approved &amp; Verified</div>
                  <div style="font-size: 16px; font-weight: 800; color: #16a34a;"><?=number_format($approved_count ?? 0);?></div>
                </div>
              </div>
              <?php if($this->input->get_post('status_filter')=='approved'||$this->input->get_post('status_filter')=='registered'): ?>
                <span class="badge" style="background: #10b981; font-size: 10px;">Active View</span>
              <?php endif; ?>
            </div>
          </a>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 0 6px; margin-bottom: 8px;">
          <a href="<?=base_url('doctor/pathlabreg/viewpathology?status_filter=pending'.($this->input->get_post('keyword') ? '&keyword='.$this->input->get_post('keyword') : ''))?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='pending'||$this->input->get_post('status_filter')=='pending_verification') ? '#f59e0b' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-clock-o"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #b45309; text-transform: uppercase;">Pending Verification</div>
                  <div style="font-size: 16px; font-weight: 800; color: #d97706;"><?=number_format($pending_count ?? 0);?></div>
                </div>
              </div>
              <?php if($this->input->get_post('status_filter')=='pending'||$this->input->get_post('status_filter')=='pending_verification'): ?>
                <span class="badge" style="background: #f59e0b; font-size: 10px;">Active View</span>
              <?php endif; ?>
            </div>
          </a>
        </div>
      </div>

      <div class="master-card">
        <div class="master-card-header">
          <h3 class="master-card-title">
            <i class="fa fa-flask" style="color: #00a896;"></i>
            <span>Registered Pathology Labs Directory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-pathlab-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="pathlab-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/pathlabreg/index')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Add New Pathlab
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter & Search Toolbar -->
          <form action="<?=base_url('doctor/pathlabreg/viewpathology')?>" method="get" id="search_form" class="master-toolbar">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
              <div style="width: 85px;">
                <?php echo display_record_per_page();?>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
              <!-- Registration / Verification Status Filter -->
              <div style="min-width: 175px;">
                <select class="form-control input-sm" name="status_filter" id="status_filter" onchange="$('#search_form').submit();" style="height: 34px; border-radius: 6px; font-weight: 600;">
                  <option value="">All Registration Status</option>
                  <option value="approved" <?=($this->input->get_post('status_filter')=='approved'||$this->input->get_post('status_filter')=='registered') ? 'selected' : '';?>>&#10003; Approved &amp; Verified</option>
                  <option value="pending" <?=($this->input->get_post('status_filter')=='pending'||$this->input->get_post('status_filter')=='pending_verification') ? 'selected' : '';?>>&#9679; Pending Verification</option>
                  <option value="verified" <?=$this->input->get_post('status_filter')=='verified' ? 'selected' : '';?>>Verified Only</option>
                  <option value="unverified" <?=$this->input->get_post('status_filter')=='unverified' ? 'selected' : '';?>>Unverified Only</option>
                  <option value="pending_approval" <?=$this->input->get_post('status_filter')=='pending_approval' ? 'selected' : '';?>>Pending Approval</option>
                </select>
              </div>

              <!-- Lab Name Search -->
              <div style="width: 220px;">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" class="form-control" name="keyword" placeholder="Search lab name, email, phone..." value="<?=$this->input->get_post('keyword');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>

              <?php if($this->input->get_post('keyword')!='' || $this->input->get_post('status_filter')!=''): ?>
                <a href="<?=base_url('doctor/pathlabreg/viewpathology')?>" class="btn btn-sm btn-default" title="Clear Filters" style="height: 34px; line-height: 22px; border-radius: 6px; font-weight: 600;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Active Filter Pill Banner -->
          <?php if($this->input->get_post('status_filter')!=''): 
            $sf = $this->input->get_post('status_filter');
            $sfLabel = ($sf == 'approved' || $sf == 'registered') ? 'Approved & Verified Pathology Labs' : (($sf == 'pending' || $sf == 'pending_verification') ? 'Pending Verification Pathology Labs' : ucfirst($sf));
            $sfBg = ($sf == 'approved' || $sf == 'registered') ? '#dcfce7; color: #15803d; border-color: #bbf7d0;' : '#fef3c7; color: #b45309; border-color: #fde68a;';
          ?>
            <div style="margin-bottom: 14px;">
              <span style="background: <?=$sfBg?>; border: 1px solid; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-filter"></i> Filtering: <?=$sfLabel;?>
                <a href="<?=base_url('doctor/pathlabreg/viewpathology?keyword='.$this->input->get_post('keyword'))?>" style="color: inherit; margin-left: 4px; text-decoration: none;" title="Remove status filter">&times;</a>
              </span>
            </div>
          <?php endif; ?>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="pathlab-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-pathlabs" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Pathology Lab Name</th>
                  <th>City</th>
                  <th>Contact Info</th>
                  <th style="width: 110px; text-align: center;">Verification</th>
                  <th style="width: 110px; text-align: center;">Approval</th>
                  <th style="width: 100px; text-align: center;">Reg. Date</th>
                  <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($pathlab)): foreach($pathlab as $val): 
                  $id = is_object($val) ? $val->id : $val['id'];
                  $name = is_object($val) ? $val->name : $val['name'];
                  $city = is_object($val) ? $val->city : $val['city'];
                  $email = is_object($val) ? $val->email : $val['email'];
                  $mobile = is_object($val) ? $val->mobile : $val['mobile'];
                  $verified = is_object($val) ? $val->verified : $val['verified'];
                  $approved = is_object($val) ? $val->approved : $val['approved'];
                  $cdate = is_object($val) ? $val->creat_date : $val['creat_date'];

                  $isVerified = ($verified == 1);
                  $isApproved = ($approved == 1);
                ?>
                  <tr id="row-<?=$id;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="pathlab-checkbox" value="<?=$id;?>" data-name="<?=htmlspecialchars($name);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$id;?></td>
                    <td style="vertical-align: middle;">
                      <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;"><?=$name;?></div>
                      <small style="color: #64748b; font-size: 11px;">LAB-<?=$id;?></small>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-map-marker"></i> <?=getCityName($city);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-envelope-o text-muted"></i> <?=$email;?></div>
                      <div style="font-size: 12px; color: #64748b;"><i class="fa fa-phone text-muted"></i> <?=$mobile;?></div>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/pathlabreg/pathlabverify/'.$id);?>" class="badge-pill-status <?=$isVerified ? 'badge-status-active' : 'badge-status-inactive';?> action-lab-verify" data-id="<?=$id;?>" data-name="<?=htmlspecialchars($name);?>" title="Toggle Verification">
                        <i class="fa <?=$isVerified ? 'fa-check-circle' : 'fa-times-circle';?>"></i>
                        <span><?=$isVerified ? 'Verified' : 'Unverified';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/pathlabreg/pathlabapprove/'.$id);?>" class="badge-pill-status <?=$isApproved ? 'badge-status-active' : 'badge-status-inactive';?> action-lab-approve" data-id="<?=$id;?>" data-name="<?=htmlspecialchars($name);?>" title="Toggle Approval">
                        <i class="fa fa-circle" style="font-size: 7px;"></i>
                        <span><?=$isApproved ? 'Approved' : 'Pending';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b; vertical-align: middle;">
                      <?=date('d M Y', strtotime($cdate));?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/pathlabreg/pathlabview/'.$id);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569;" title="View Lab Details">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="<?=base_url('doctor/pathlabreg/pathlabupdate/'.$id);?>" class="btn-icon-action btn-action-edit" title="Edit Pathlab">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="<?=base_url('doctor/pathlabreg/deletepathlab/'.$id);?>" class="btn-icon-action btn-action-delete delete-lab-btn" data-id="<?=$id;?>" data-name="<?=htmlspecialchars($name);?>" title="Delete Pathlab">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No pathology lab records found.</p>
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
<div class="modal fade" id="deleteLabModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Pathology Lab</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-lab-name" style="color: #1e293b;">this lab</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-lab-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteLabModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Pathology Labs</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-lab-count" style="color: #dc2626;">0</strong> selected pathology lab records? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-lab-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateLabBulkState() {
  var checkedBoxes = $('.pathlab-checkbox:checked');
  var count = checkedBoxes.length;
  var totalBoxes = $('.pathlab-checkbox').length;

  $('#pathlab-selected-count').text(count);
  $('#bulk-lab-count').text(count);

  if (count > 0) {
    $('#bulk-delete-pathlab-btn').fadeIn(200);
  } else {
    $('#bulk-delete-pathlab-btn').fadeOut(200);
  }

  if (count > 0 && count === totalBoxes) {
    $('#select-all-pathlabs').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < totalBoxes) {
    $('#select-all-pathlabs').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-pathlabs').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  // Select All Checkbox
  $(document).on('change', '#select-all-pathlabs', function(){
    var isChecked = $(this).prop('checked');
    $('.pathlab-checkbox').prop('checked', isChecked);
    updateLabBulkState();
  });

  $(document).on('change', '.pathlab-checkbox', function(){
    updateLabBulkState();
  });

  // Bulk Delete Button Click
  $(document).on('click', '#bulk-delete-pathlab-btn', function(){
    var count = $('.pathlab-checkbox:checked').length;
    if (count === 0) {
      showToast('Please select at least one pathology lab to delete.', 'danger');
      return;
    }
    $('#bulkDeleteLabModal').modal('show');
  });

  // Confirm Bulk Delete Action
  $('#confirm-bulk-delete-lab-btn').click(function(){
    var selectedIds = [];
    $('.pathlab-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathlabreg/bulk_delete_pathlab')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteLabModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#pathlab-table tbody tr').length === 0) {
              $('#pathlab-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No pathology lab records found.</p></td></tr>');
            }
          });
        });

        updateLabBulkState();
        showToast(res.message || (selectedIds.length + ' pathology labs deleted successfully.'), 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error executing bulk deletion. Please try again.', 'danger');
      }
    });
  });

  // Lab Approval AJAX
  $(document).on('click', '.action-lab-approve', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var labName = $t.data('name') || 'Pathology Lab';
    var uri = '<?=base_url('doctor/pathlabreg/pathlabapprove')?>';
    
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
          showToast(labName + ' has been approved.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Pending');
          showToast(labName + ' approval status set to Pending.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // Lab Verification AJAX
  $(document).on('click', '.action-lab-verify', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var labName = $t.data('name') || 'Pathology Lab';
    var uri = '<?=base_url('doctor/pathlabreg/pathlabverify')?>';
    
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
          $t.find('i').removeClass('fa-times-circle').addClass('fa-check-circle');
          $t.find('span').text('Verified');
          showToast(labName + ' has been verified.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('i').removeClass('fa-check-circle').addClass('fa-times-circle');
          $t.find('span').text('Unverified');
          showToast(labName + ' verification set to Unverified.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // Delete Modal & AJAX Handler
  var activeDeleteLabId = null;
  $(document).on('click', '.delete-lab-btn', function(e){
    e.preventDefault();
    activeDeleteLabId = $(this).data('id');
    var name = $(this).data('name') || 'this lab';
    $('#delete-lab-name').text('"' + name + '"');
    $('#deleteLabModal').modal('show');
  });

  $('#confirm-delete-lab-btn').click(function(){
    if(!activeDeleteLabId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/pathlabreg/deletepathlab')?>',
      dataType: 'json',
      data: { id: activeDeleteLabId, did: activeDeleteLabId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteLabModal').modal('hide');
        $('#row-' + activeDeleteLabId).fadeOut(400, function(){
          $(this).remove();
          if ($('#pathlab-table tbody tr').length === 0) {
            $('#pathlab-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-flask fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No pathology lab records found.</p></td></tr>');
          }
          updateLabBulkState();
        });
        showToast(res.message || 'Pathlab deleted successfully.', 'success');
        activeDeleteLabId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/pathlabreg/deletepathlab/')?>' + activeDeleteLabId;
      }
    });
  });
});
</script>
