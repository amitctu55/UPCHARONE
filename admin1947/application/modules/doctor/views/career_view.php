<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Career & Job Applications</h1>
        <small style="color: #64748b; font-size: 13px;">Manage job inquiries, candidate resumes, qualifications, and recruitment</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/career')?>" style="color: #64748b;">Enquiry</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Career</li>
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
            <i class="fa fa-briefcase" style="color: #00a896;"></i>
            <span>Received Job Applications</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-career-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="career-selected-count">0</span>)
            </button>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Filter Toolbar -->
          <form action="<?=base_url('doctor/career')?>" method="get" id="search_form" class="master-toolbar">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
              <div style="width: 85px;">
                <?php echo display_record_per_page();?>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
              <div style="width: 250px;">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" class="form-control" name="keyword" placeholder="Search applicant name..." value="<?=$this->input->get_post('keyword');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>

              <?php if($this->input->get_post('keyword')!=''): ?>
                <a href="<?=base_url('doctor/career')?>" class="btn btn-sm btn-default" title="Clear Search" style="height: 34px; line-height: 22px; border-radius: 6px;">
                  <i class="fa fa-times text-danger"></i> Clear
                </a>
              <?php endif; ?>
            </div>
          </form>

          <!-- Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="career-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-careers" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th>Applicant Name</th>
                  <th>Contact Info</th>
                  <th>Applied Designation</th>
                  <th>Qualification</th>
                  <th>Cover Message</th>
                  <th style="width: 90px; text-align: center;">Resume</th>
                  <th style="width: 100px; text-align: center;">Date</th>
                  <th style="width: 80px; text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($career)): foreach($career as $val): 
                  $cid = $val['career_id'];
                  $cname = $val['name'];
                  $hasResume = !empty($val['resume']);
                  $resumeUrl = $hasResume ? base_url('public/assets/document/'.$val['resume']) : '';
                ?>
                  <tr id="row-<?=$cid;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="career-checkbox" value="<?=$cid;?>" data-name="<?=htmlspecialchars($cname);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($cname);?></strong>
                    </td>
                    <td style="vertical-align: middle;">
                      <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-envelope-o text-muted"></i> <?=htmlspecialchars($val['email']);?></div>
                      <div style="font-size: 12px; color: #64748b;"><i class="fa fa-phone text-muted"></i> <?=htmlspecialchars($val['mobile']);?></div>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-info" style="background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-size: 12px;">
                        <?=htmlspecialchars($val['designation']);?>
                      </span>
                    </td>
                    <td style="vertical-align: middle; font-size: 12.5px; color: #475569;">
                      <?=htmlspecialchars($val['qualification']);?>
                    </td>
                    <td style="vertical-align: middle;">
                      <small style="color: #64748b; font-size: 11.5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="<?=htmlspecialchars($val['message']);?>">
                        <?=!empty($val['message']) ? htmlspecialchars($val['message']) : '-';?>
                      </small>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <?php if($hasResume): ?>
                        <a href="<?=$resumeUrl;?>" target="_blank" class="btn btn-xs btn-default" style="border-radius: 4px; font-weight: 600; color: #00a896;" title="View CV">
                          <i class="fa fa-file-pdf-o"></i> View
                        </a>
                      <?php else: ?>
                        <span class="text-muted" style="font-size: 11px;">No CV</span>
                      <?php endif; ?>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b; vertical-align: middle;">
                      <?=date('d M Y', strtotime($val['creat_date']));?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/career/delete/'.$cid);?>" class="btn-icon-action btn-action-delete delete-career-btn" data-id="<?=$cid;?>" data-name="<?=htmlspecialchars($cname);?>" title="Delete Application">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-briefcase fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No job applications found.</p>
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
<div class="modal fade" id="deleteCareerModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Application</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete application by <strong id="delete-career-name" style="color: #1e293b;">this candidate</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-career-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteCareerModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple Applications</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-career-count" style="color: #dc2626;">0</strong> selected job applications? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-career-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateCareerBulkState() {
  var checkedBoxes = $('.career-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.career-checkbox').length;

  $('#career-selected-count').text(count);
  $('#bulk-career-count').text(count);

  if (count > 0) {
    $('#bulk-delete-career-btn').fadeIn(200);
  } else {
    $('#bulk-delete-career-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-careers').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-careers').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-careers').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-careers', function(){
    var isChecked = $(this).prop('checked');
    $('.career-checkbox').prop('checked', isChecked);
    updateCareerBulkState();
  });

  $(document).on('change', '.career-checkbox', function(){
    updateCareerBulkState();
  });

  $(document).on('click', '#bulk-delete-career-btn', function(){
    if ($('.career-checkbox:checked').length === 0) return;
    $('#bulkDeleteCareerModal').modal('show');
  });

  $('#confirm-bulk-delete-career-btn').click(function(){
    var selectedIds = [];
    $('.career-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/career/bulk_delete')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteCareerModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#career-table tbody tr').length === 0) {
              $('#career-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-briefcase fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No job applications found.</p></td></tr>');
            }
          });
        });

        updateCareerBulkState();
        showToast(res.message || 'Selected applications deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting applications.', 'danger');
      }
    });
  });

  // Delete Single Career
  var activeDeleteCareerId = null;
  $(document).on('click', '.delete-career-btn', function(e){
    e.preventDefault();
    activeDeleteCareerId = $(this).data('id');
    var name = $(this).data('name') || 'this application';
    $('#delete-career-name').text('"' + name + '"');
    $('#deleteCareerModal').modal('show');
  });

  $('#confirm-delete-career-btn').click(function(){
    if(!activeDeleteCareerId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/career/delete')?>',
      dataType: 'json',
      data: { id: activeDeleteCareerId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteCareerModal').modal('hide');
        $('#row-' + activeDeleteCareerId).fadeOut(400, function(){
          $(this).remove();
          if ($('#career-table tbody tr').length === 0) {
            $('#career-table tbody').html('<tr><td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-briefcase fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No job applications found.</p></td></tr>');
          }
          updateCareerBulkState();
        });
        showToast(res.message || 'Application deleted successfully.', 'success');
        activeDeleteCareerId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/career/delete/')?>' + activeDeleteCareerId;
      }
    });
  });
});
</script>
