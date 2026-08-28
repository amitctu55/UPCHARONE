<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Doctor Directory</h1>
        <small style="color: #64748b; font-size: 13px;">Manage registered doctors, verification status, and clinical profiles</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/doctorview')?>" style="color: #64748b;">Doctors</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Directory</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 15px 20px;">
    <div class="container-fluid" style="padding: 0;">
      
      <!-- Flash Alert Messages -->
      <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 15px;" id="flash-msg-wrapper">
          <?=$this->session->flashdata('flashmsg');?>
        </div>
      <?php endif; ?>

      <!-- Toast Notification Container -->
      <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

      <!-- Quick Status Filter KPI Badges -->
      <div class="row" style="margin: 0 -6px 16px;">
        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 0 6px; margin-bottom: 8px;">
          <a href="<?=base_url('doctor/doctorview')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='') ? '#00a896' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-user-md"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">All Doctors</div>
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
          <a href="<?=base_url('doctor/doctorview?status_filter=approved'.($this->input->get_post('city_name') ? '&city_name='.$this->input->get_post('city_name') : '').($this->input->get_post('mobile') ? '&mobile='.$this->input->get_post('mobile') : '').($this->input->get_post('keyword') ? '&keyword='.$this->input->get_post('keyword') : ''))?>" style="text-decoration: none; display: block;">
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
          <a href="<?=base_url('doctor/doctorview?status_filter=pending'.($this->input->get_post('city_name') ? '&city_name='.$this->input->get_post('city_name') : '').($this->input->get_post('mobile') ? '&mobile='.$this->input->get_post('mobile') : '').($this->input->get_post('keyword') ? '&keyword='.$this->input->get_post('keyword') : ''))?>" style="text-decoration: none; display: block;">
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
            <i class="fa fa-user-md" style="color: #00a896;"></i>
            <span>Registered Doctors Directory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/doctorview/createExcel?keyword='.$this->input->get_post('keyword').'&mobile='.$this->input->get_post('mobile').'&city_name='.$this->input->get_post('city_name').'&status_filter='.$this->input->get_post('status_filter'))?>" class="btn btn-sm btn-success" style="border-radius: 6px; font-weight: 600; background: #10b981; border-color: #10b981;">
              <i class="fa fa-file-excel-o"></i> Export Excel
            </a>
            <a href="<?=base_url('doctor/doctorreg')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Add New Doctor
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter & Search Toolbar -->
          <form action="<?=base_url('doctor/doctorview')?>" method="get" id="search_form" class="master-toolbar">
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

              <!-- City Filter Dropdown -->
              <div style="min-width: 150px;">
                <select class="form-control input-sm" name="city_name" onchange="$('#search_form').submit();" style="height: 34px; border-radius: 6px;">
                  <option value="">All Cities</option>
                  <?php if(is_array($city) && !empty($city)): foreach ($city as $val): ?>
                    <option value="<?=$val['id'];?>" <?=$this->input->get_post('city_name')==$val['id'] ? 'selected' : '';?>><?=$val['name'];?></option>
                  <?php endforeach; endif; ?>
                </select>
              </div>

              <!-- Mobile Search -->
              <div style="width: 140px;">
                <input type="text" class="form-control input-sm" name="mobile" placeholder="Search Mobile..." value="<?=$this->input->get_post('mobile');?>" style="height: 34px; border-radius: 6px;">
              </div>

              <!-- Name Search Input -->
              <div style="width: 180px;">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" class="form-control" name="keyword" placeholder="Doctor name..." value="<?=$this->input->get_post('keyword');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>

              <?php if($this->input->get_post('keyword')!='' || $this->input->get_post('mobile')!='' || $this->input->get_post('city_name')!='' || $this->input->get_post('status_filter')!=''): ?>
                <a href="<?=base_url('doctor/doctorview')?>" class="btn btn-sm btn-default" title="Clear Filters" style="height: 34px; line-height: 22px; border-radius: 6px; font-weight: 600;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Active Filter Pill Banner -->
          <?php if($this->input->get_post('status_filter')!=''): 
            $sf = $this->input->get_post('status_filter');
            $sfLabel = ($sf == 'approved' || $sf == 'registered') ? 'Approved & Verified Doctors' : (($sf == 'pending' || $sf == 'pending_verification') ? 'Pending Verification Doctors' : ucfirst($sf));
            $sfBg = ($sf == 'approved' || $sf == 'registered') ? '#dcfce7; color: #15803d; border-color: #bbf7d0;' : '#fef3c7; color: #b45309; border-color: #fde68a;';
          ?>
            <div style="margin-bottom: 14px;">
              <span style="background: <?=$sfBg?>; border: 1px solid; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-filter"></i> Filtering: <?=$sfLabel;?>
                <a href="<?=base_url('doctor/doctorview?keyword='.$this->input->get_post('keyword').'&mobile='.$this->input->get_post('mobile').'&city_name='.$this->input->get_post('city_name'))?>" style="color: inherit; margin-left: 4px; text-decoration: none;" title="Remove status filter">&times;</a>
              </span>
            </div>
          <?php endif; ?>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="doctor-directory-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-doctors" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Doctor Name</th>
                  <th>City</th>
                  <th>Email & Phone</th>
                  <th style="width: 110px; text-align: center;">Verification</th>
                  <th style="width: 110px; text-align: center;">Approval</th>
                  <th style="width: 100px; text-align: center;">Reg. Date</th>
                  <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($doctor)): foreach($doctor as $val): 
                  $isVerified = ($val['verified'] == 1);
                  $isApproved = ($val['approved'] == 1);
                ?>
                  <tr id="row-<?=$val['id'];?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="doctor-checkbox" value="<?=$val['id'];?>" data-name="<?=htmlspecialchars($val['fname']);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$val['id'];?></td>
                    <td style="vertical-align: middle;">
                      <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;"><?=$val['fname'].' '.$val['lname'];?></div>
                      <small style="color: #64748b; font-size: 11px;">ID: DOC-<?=$val['id'];?></small>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-map-marker"></i> <?=getCityName($val['city']);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-envelope-o text-muted"></i> <?=$val['email'];?></div>
                      <div style="font-size: 12px; color: #64748b;"><i class="fa fa-phone text-muted"></i> <?=$val['mobile'];?></div>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/doctorview/verify/'.$val['id']);?>" class="badge-pill-status <?php echo $isVerified ? 'badge-status-active' : 'badge-status-inactive';?> action-verify-btn" data-id="<?php echo $val['id']; ?>" data-name="<?php echo htmlspecialchars($val['fname']); ?>" title="Toggle Verification">
                        <i class="fa <?=$isVerified ? 'fa-check-circle' : 'fa-times-circle';?>"></i>
                        <span><?=$isVerified ? 'Verified' : 'Unverified';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/doctorview/approve/'.$val['id']);?>" class="badge-pill-status <?php echo $isApproved ? 'badge-status-active' : 'badge-status-inactive';?> action-approve-btn" data-id="<?php echo $val['id']; ?>" data-name="<?php echo htmlspecialchars($val['fname']); ?>" title="Toggle Approval">
                        <i class="fa fa-circle" style="font-size: 7px;"></i>
                        <span><?=$isApproved ? 'Approved' : 'Pending';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b; vertical-align: middle;">
                      <?=date('d M Y', strtotime($val['creat_date']));?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/doctorview/viewdoctor/'.$val['id']);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569;" title="View Profile">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="<?=base_url('doctor/doctorview/updatedoctor/'.$val['id']);?>" class="btn-icon-action btn-action-edit" title="Edit Doctor Profile">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="<?=base_url('doctor/doctorview/viewgallery/'.$val['id']);?>" class="btn-icon-action" style="background: #fef3c7; color: #d97706;" title="Media & Document Gallery">
                        <i class="fa fa-picture-o"></i>
                      </a>
                      <a href="<?=base_url('doctor/doctorview/deletedoctor/'.$val['id']);?>" class="btn-icon-action btn-action-delete delete-doctor-btn" data-id="<?=$val['id'];?>" data-name="<?=htmlspecialchars($val['fname']);?>" title="Delete Doctor">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-user-md fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No doctor records matching criteria.</p>
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
<div class="modal fade" id="deleteDoctorModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Doctor Record</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-doc-name" style="color: #1e293b;">this doctor</strong>? This action will permanently remove all associated schedules, degrees, and credentials.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-doc-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Doctors</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-modal-count" style="color: #dc2626;">0</strong> selected doctor records? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateBulkDeleteState() {
  var checkedBoxes = $('.doctor-checkbox:checked');
  var count = checkedBoxes.length;
  var totalBoxes = $('.doctor-checkbox').length;

  $('#selected-count').text(count);
  $('#bulk-modal-count').text(count);

  if (count > 0) {
    $('#bulk-delete-btn').fadeIn(200);
  } else {
    $('#bulk-delete-btn').fadeOut(200);
  }

  if (count > 0 && count === totalBoxes) {
    $('#select-all-doctors').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < totalBoxes) {
    $('#select-all-doctors').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-doctors').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  // Master Select All Checkbox
  $(document).on('change', '#select-all-doctors', function(){
    var isChecked = $(this).prop('checked');
    $('.doctor-checkbox').prop('checked', isChecked);
    updateBulkDeleteState();
  });

  // Individual Row Checkbox Change
  $(document).on('change', '.doctor-checkbox', function(){
    updateBulkDeleteState();
  });

  // Bulk Delete Button Click -> Open Modal
  $(document).on('click', '#bulk-delete-btn', function(){
    var checkedBoxes = $('.doctor-checkbox:checked');
    if (checkedBoxes.length === 0) {
      showToast('Please select at least one doctor to delete.', 'danger');
      return;
    }
    $('#bulkDeleteModal').modal('show');
  });

  // Confirm Bulk Delete Action
  $('#confirm-bulk-delete-btn').click(function(){
    var selectedIds = [];
    $('.doctor-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/doctorview/bulk_delete')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#doctor-directory-table tbody tr').length === 0) {
              $('#doctor-directory-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-user-md fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No doctor records matching criteria.</p></td></tr>');
            }
          });
        });

        updateBulkDeleteState();
        showToast(res.message || (selectedIds.length + ' doctors deleted successfully.'), 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error executing bulk deletion. Please try again.', 'danger');
      }
    });
  });

  // Approve Action Handler
  $(document).on('click', '.action-approve-btn', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var docName = $t.data('name') || 'Doctor';
    var uri = '<?=base_url('doctor/doctorview/approve')?>';
    
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
          showToast(docName + ' has been approved.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Pending');
          showToast(docName + ' approval status set to Pending.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // Verify Action Handler
  $(document).on('click', '.action-verify-btn', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var docName = $t.data('name') || 'Doctor';
    var uri = '<?=base_url('doctor/doctorview/verify')?>';
    
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
          showToast(docName + ' has been verified.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('i').removeClass('fa-check-circle').addClass('fa-times-circle');
          $t.find('span').text('Unverified');
          showToast(docName + ' verification set to Unverified.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // Single Delete Prompt & Confirmation Handler
  var activeDeleteId = null;
  $(document).on('click', '.delete-doctor-btn', function(e){
    e.preventDefault();
    activeDeleteId = $(this).data('id');
    var name = $(this).data('name') || 'this doctor';
    $('#delete-doc-name').text('"' + name + '"');
    $('#deleteDoctorModal').modal('show');
  });

  $('#confirm-delete-doc-btn').click(function(){
    if(!activeDeleteId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');
    
    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/doctorview/deletedoctor')?>',
      dataType: 'json',
      data: { id: activeDeleteId, did: activeDeleteId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteDoctorModal').modal('hide');
        $('#row-' + activeDeleteId).fadeOut(400, function(){
          $(this).remove();
          if ($('#doctor-directory-table tbody tr').length === 0) {
            $('#doctor-directory-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-user-md fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No doctor records matching criteria.</p></td></tr>');
          }
          updateBulkDeleteState();
        });
        showToast(res.message || 'Doctor deleted successfully.', 'success');
        activeDeleteId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/doctorview/deletedoctor/')?>' + activeDeleteId;
      }
    });
  });
});
</script>