<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Hospitals Directory</h1>
        <small style="color: #64748b; font-size: 13px;">Manage registered multi-specialty hospitals and healthcare centers</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/clinicreg/viewhospital')?>" style="color: #64748b;">Facilities</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Hospitals</li>
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

      <!-- Quick Status Filter KPI Badges -->
      <div class="row" style="margin: 0 -6px 16px;">
        <div class="col-md-4 col-sm-4 col-xs-12" style="padding: 0 6px; margin-bottom: 8px;">
          <a href="<?=base_url('doctor/clinicreg/viewhospital')?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='') ? '#00a896' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-hospital-o"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">All Facilities</div>
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
          <a href="<?=base_url('doctor/clinicreg/viewhospital?status_filter=approved'.($this->input->get_post('type') ? '&type='.$this->input->get_post('type') : '').($this->input->get_post('keyword') ? '&keyword='.$this->input->get_post('keyword') : ''))?>" style="text-decoration: none; display: block;">
            <div style="background: #ffffff; border-radius: 8px; border: 1px solid <?=($this->input->get_post('status_filter')=='approved'||$this->input->get_post('status_filter')=='registered') ? '#10b981' : '#e2e8f0'?>; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: all 0.2s;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                  <i class="fa fa-check-circle"></i>
                </div>
                <div>
                  <div style="font-size: 11px; font-weight: 700; color: #15803d; text-transform: uppercase;">Approved / Verified</div>
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
          <a href="<?=base_url('doctor/clinicreg/viewhospital?status_filter=pending'.($this->input->get_post('type') ? '&type='.$this->input->get_post('type') : '').($this->input->get_post('keyword') ? '&keyword='.$this->input->get_post('keyword') : ''))?>" style="text-decoration: none; display: block;">
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
            <i class="fa fa-hospital-o" style="color: #00a896;"></i>
            <span>Registered Hospitals Directory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-hospital-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="hospital-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/clinicreg/createHospitalExcel?keyword='.$this->input->get_post('keyword').'&type='.$this->input->get_post('type').'&status_filter='.$this->input->get_post('status_filter'))?>" class="btn btn-sm btn-success" style="border-radius: 6px; font-weight: 600; background: #10b981; border-color: #10b981;">
              <i class="fa fa-file-excel-o"></i> Export Excel
            </a>
            <a href="<?=base_url('doctor/clinicreg/add')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Add New Hospital
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter & Search Toolbar -->
          <form action="<?=base_url('doctor/clinicreg/viewhospital')?>" method="get" id="search_form" class="master-toolbar">
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

              <!-- Sector Type Filter -->
              <div style="min-width: 140px;">
                <select class="form-control input-sm" name="type" onchange="$('#search_form').submit();" style="height: 34px; border-radius: 6px;">
                  <option value="">All Sector Types</option>
                  <option value="1" <?=$this->input->get_post('type')=='1' ? 'selected' : '';?>>Private Sector</option>
                  <option value="2" <?=$this->input->get_post('type')=='2' ? 'selected' : '';?>>Government Sector</option>
                </select>
              </div>

              <!-- Hospital Name Search -->
              <div style="width: 220px;">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" class="form-control" name="keyword" placeholder="Hospital name, email, phone..." value="<?=$this->input->get_post('keyword');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>

              <?php if($this->input->get_post('keyword')!='' || $this->input->get_post('type')!='' || $this->input->get_post('status_filter')!=''): ?>
                <a href="<?=base_url('doctor/clinicreg/viewhospital')?>" class="btn btn-sm btn-default" title="Clear Filters" style="height: 34px; line-height: 22px; border-radius: 6px; font-weight: 600;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Active Filter Pill Banner -->
          <?php if($this->input->get_post('status_filter')!=''): 
            $sf = $this->input->get_post('status_filter');
            $sfLabel = ($sf == 'approved' || $sf == 'registered') ? 'Approved & Verified Hospitals' : (($sf == 'pending' || $sf == 'pending_verification') ? 'Pending Verification Hospitals' : ucfirst($sf));
            $sfBg = ($sf == 'approved' || $sf == 'registered') ? '#dcfce7; color: #15803d; border-color: #bbf7d0;' : '#fef3c7; color: #b45309; border-color: #fde68a;';
          ?>
            <div style="margin-bottom: 14px;">
              <span style="background: <?=$sfBg?>; border: 1px solid; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-filter"></i> Filtering: <?=$sfLabel;?>
                <a href="<?=base_url('doctor/clinicreg/viewhospital?keyword='.$this->input->get_post('keyword').'&type='.$this->input->get_post('type'))?>" style="color: inherit; margin-left: 4px; text-decoration: none;" title="Remove status filter">&times;</a>
              </span>
            </div>
          <?php endif; ?>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="hospital-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-hospitals" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Hospital Name</th>
                  <th>Sector & City</th>
                  <th>Contact Info</th>
                  <th style="width: 110px; text-align: center;">Verification</th>
                  <th style="width: 110px; text-align: center;">Approval</th>
                  <th style="width: 100px; text-align: center;">Reg. Date</th>
                  <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($hospital)): foreach($hospital as $val): 
                  $isVerified = ($val['verified'] == 1);
                  $isApproved = ($val['approved'] == 1);
                  $typeLabel = ($val['TYPE'] == '1') ? 'Private' : 'Govt';
                ?>
                  <tr id="row-<?=$val['id'];?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="hospital-checkbox" value="<?=$val['id'];?>" data-name="<?=htmlspecialchars($val['name']);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$val['id'];?></td>
                    <td style="vertical-align: middle;">
                      <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;"><?=$val['name'];?></div>
                      <small style="color: #64748b; font-size: 11px;">HOSP-<?=$val['id'];?></small>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-size: 11px; margin-right: 4px;">
                        <?=$typeLabel;?>
                      </span>
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-map-marker"></i> <?=getCityName($val['city']);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-envelope-o text-muted"></i> <?=$val['email'];?></div>
                      <div style="font-size: 12px; color: #64748b;"><i class="fa fa-phone text-muted"></i> <?=$val['mobile'];?></div>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/clinicreg/hospitalverify/'.$val['id']);?>" class="badge-pill-status <?=$isVerified ? 'badge-status-active' : 'badge-status-inactive';?> action-hosp-verify" data-id="<?=$val['id'];?>" data-name="<?=htmlspecialchars($val['name']);?>" title="Toggle Verification">
                        <i class="fa <?=$isVerified ? 'fa-check-circle' : 'fa-times-circle';?>"></i>
                        <span><?=$isVerified ? 'Verified' : 'Unverified';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/clinicreg/hospitalapprove/'.$val['id']);?>" class="badge-pill-status <?=$isApproved ? 'badge-status-active' : 'badge-status-inactive';?> action-hosp-approve" data-id="<?=$val['id'];?>" data-name="<?=htmlspecialchars($val['name']);?>" title="Toggle Approval">
                        <i class="fa fa-circle" style="font-size: 7px;"></i>
                        <span><?=$isApproved ? 'Approved' : 'Pending';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b; vertical-align: middle;">
                      <?=date('d M Y', strtotime($val['creat_date']));?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/clinicreg/hospitalview/'.$val['id']);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569;" title="View Hospital Details">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="<?=base_url('doctor/clinicreg/updatehospital/'.$val['id']);?>" class="btn-icon-action btn-action-edit" title="Edit Hospital">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="<?=base_url('doctor/clinicreg/viewgallery/'.$val['id']);?>" class="btn-icon-action" style="background: #fef3c7; color: #d97706;" title="Hospital Gallery">
                        <i class="fa fa-picture-o"></i>
                      </a>
                      <a href="<?=base_url('doctor/clinicreg/deletehospital/'.$val['id']);?>" class="btn-icon-action btn-action-delete delete-hosp-btn" data-id="<?=$val['id'];?>" data-name="<?=htmlspecialchars($val['name']);?>" title="Delete Hospital">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-hospital-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No hospital records found.</p>
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
<div class="modal fade" id="deleteHospModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Hospital Record</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-hosp-name" style="color: #1e293b;">this hospital</strong>? This action will remove all practice schedules and media attachments.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-hosp-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteHospModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Hospitals</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-hosp-count" style="color: #dc2626;">0</strong> selected hospital records? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-hosp-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateHospBulkState() {
  var checkedBoxes = $('.hospital-checkbox:checked');
  var count = checkedBoxes.length;
  var totalBoxes = $('.hospital-checkbox').length;

  $('#hospital-selected-count').text(count);
  $('#bulk-hosp-count').text(count);

  if (count > 0) {
    $('#bulk-delete-hospital-btn').fadeIn(200);
  } else {
    $('#bulk-delete-hospital-btn').fadeOut(200);
  }

  if (count > 0 && count === totalBoxes) {
    $('#select-all-hospitals').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < totalBoxes) {
    $('#select-all-hospitals').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-hospitals').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  // Select All Checkbox
  $(document).on('change', '#select-all-hospitals', function(){
    var isChecked = $(this).prop('checked');
    $('.hospital-checkbox').prop('checked', isChecked);
    updateHospBulkState();
  });

  $(document).on('change', '.hospital-checkbox', function(){
    updateHospBulkState();
  });

  // Bulk Delete Button Click
  $(document).on('click', '#bulk-delete-hospital-btn', function(){
    var count = $('.hospital-checkbox:checked').length;
    if (count === 0) {
      showToast('Please select at least one hospital to delete.', 'danger');
      return;
    }
    $('#bulkDeleteHospModal').modal('show');
  });

  // Confirm Bulk Delete Action
  $('#confirm-bulk-delete-hosp-btn').click(function(){
    var selectedIds = [];
    $('.hospital-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/clinicreg/bulk_delete_hospital')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteHospModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#hospital-table tbody tr').length === 0) {
              $('#hospital-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-hospital-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No hospital records found.</p></td></tr>');
            }
          });
        });

        updateHospBulkState();
        showToast(res.message || (selectedIds.length + ' hospitals deleted successfully.'), 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error executing bulk deletion. Please try again.', 'danger');
      }
    });
  });

  // Hospital Approval AJAX
  $(document).on('click', '.action-hosp-approve', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var hospName = $t.data('name') || 'Hospital';
    var uri = '<?=base_url('doctor/clinicreg/hospitalapprove')?>';
    
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
          showToast(hospName + ' has been approved.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Pending');
          showToast(hospName + ' approval status set to Pending.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // Hospital Verification AJAX
  $(document).on('click', '.action-hosp-verify', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var hospName = $t.data('name') || 'Hospital';
    var uri = '<?=base_url('doctor/clinicreg/hospitalverify')?>';
    
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
          showToast(hospName + ' has been verified.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('i').removeClass('fa-check-circle').addClass('fa-times-circle');
          $t.find('span').text('Unverified');
          showToast(hospName + ' verification set to Unverified.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // Delete Modal & AJAX Handler
  var activeDeleteHospId = null;
  $(document).on('click', '.delete-hosp-btn', function(e){
    e.preventDefault();
    activeDeleteHospId = $(this).data('id');
    var name = $(this).data('name') || 'this hospital';
    $('#delete-hosp-name').text('"' + name + '"');
    $('#deleteHospModal').modal('show');
  });

  $('#confirm-delete-hosp-btn').click(function(){
    if(!activeDeleteHospId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/clinicreg/deletehospital')?>',
      dataType: 'json',
      data: { id: activeDeleteHospId, did: activeDeleteHospId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteHospModal').modal('hide');
        $('#row-' + activeDeleteHospId).fadeOut(400, function(){
          $(this).remove();
          if ($('#hospital-table tbody tr').length === 0) {
            $('#hospital-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-hospital-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No hospital records found.</p></td></tr>');
          }
          updateHospBulkState();
        });
        showToast(res.message || 'Hospital deleted successfully.', 'success');
        activeDeleteHospId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/clinicreg/deletehospital/')?>' + activeDeleteHospId;
      }
    });
  });
});
</script>
