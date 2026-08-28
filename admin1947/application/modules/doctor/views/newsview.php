<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Medical News & Press Releases</h1>
        <small style="color: #64748b; font-size: 13px;">Manage medical news updates, healthcare announcements, and articles</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/newsreg/viewnews')?>" style="color: #64748b;">News Mgmt</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">View News</li>
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
            <i class="fa fa-newspaper-o" style="color: #00a896;"></i>
            <span>Published Medical News Directory</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-news-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="news-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/newsreg')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Publish New News
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="news-table" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-news" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All on Current Page">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Article Title</th>
                  <th>Published By / Entity</th>
                  <th style="width: 110px; text-align: center;">Status</th>
                  <th style="width: 110px; text-align: center;">Approval</th>
                  <th style="width: 100px; text-align: center;">Date</th>
                  <th style="width: 130px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($news)): foreach($news as $p): 
                  $nid = $p['id'];
                  $title = $p['title'];
                  $entity = !empty($p['name']) ? $p['name'] : (!empty($p['fname']) ? $p['fname'] : 'Upchar Editorial');
                  $isDoctor = empty($p['name']) && !empty($p['fname']);
                  $isActive = ($p['status'] == '1');
                  $isApproved = ($p['approved'] == '1');
                ?>
                  <tr id="row-<?=$nid;?>">
                    <td style="text-align: center; vertical-align: middle;">
                      <input type="checkbox" class="news-checkbox" value="<?=$nid;?>" data-name="<?=htmlspecialchars($title);?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b; vertical-align: middle;"><?=$nid;?></td>
                    <td style="vertical-align: middle;">
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=htmlspecialchars($title);?></strong>
                    </td>
                    <td style="vertical-align: middle;">
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa <?=$isDoctor ? 'fa-user-md' : 'fa-hospital-o';?>"></i> <?=htmlspecialchars($entity);?>
                      </span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/newsreg/newsverify/'.$nid);?>" class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?> action-news-status" data-id="<?=$nid;?>" data-name="<?=htmlspecialchars($title);?>" title="Toggle Status">
                        <i class="fa fa-circle" style="font-size: 7px;"></i>
                        <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/newsreg/newsapprove/'.$nid);?>" class="badge-pill-status <?=$isApproved ? 'badge-status-active' : 'badge-status-inactive';?> action-news-approve" data-id="<?=$nid;?>" data-name="<?=htmlspecialchars($title);?>" title="Toggle Approval">
                        <i class="fa fa-circle" style="font-size: 7px;"></i>
                        <span><?=$isApproved ? 'Approved' : 'Pending';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b; vertical-align: middle;">
                      <?=date('d M Y', strtotime($p['creat_date']));?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <a href="<?=base_url('doctor/newsreg/newsview/'.$nid);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569;" title="Preview Article">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="<?=base_url('doctor/newsreg/newsupdate/'.$nid);?>" class="btn-icon-action btn-action-edit" title="Edit News">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="<?=base_url('doctor/newsreg/deletenews/'.$nid);?>" class="btn-icon-action btn-action-delete delete-news-btn" data-id="<?=$nid;?>" data-name="<?=htmlspecialchars($title);?>" title="Delete News">
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-newspaper-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No medical news articles found.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Single Delete Confirmation Modal -->
<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete News Article</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-news-name" style="color: #1e293b;">this article</strong>? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-delete-news-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div class="modal fade" id="bulkDeleteNewsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 420px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Multiple News Articles</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="bulk-news-count" style="color: #dc2626;">0</strong> selected news articles? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-news-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateNewsBulkState() {
  var checkedBoxes = $('.news-checkbox:checked');
  var count = checkedBoxes.length;
  var total = $('.news-checkbox').length;

  $('#news-selected-count').text(count);
  $('#bulk-news-count').text(count);

  if (count > 0) {
    $('#bulk-delete-news-btn').fadeIn(200);
  } else {
    $('#bulk-delete-news-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-news').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-news').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-news').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-news', function(){
    var isChecked = $(this).prop('checked');
    $('.news-checkbox').prop('checked', isChecked);
    updateNewsBulkState();
  });

  $(document).on('change', '.news-checkbox', function(){
    updateNewsBulkState();
  });

  $(document).on('click', '#bulk-delete-news-btn', function(){
    if ($('.news-checkbox:checked').length === 0) return;
    $('#bulkDeleteNewsModal').modal('show');
  });

  $('#confirm-bulk-delete-news-btn').click(function(){
    var selectedIds = [];
    $('.news-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/newsreg/bulk_delete_news')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteNewsModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#row-' + id).fadeOut(400, function(){
            $(this).remove();
            if ($('#news-table tbody tr').length === 0) {
              $('#news-table tbody').html('<tr><td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-newspaper-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No medical news articles found.</p></td></tr>');
            }
          });
        });

        updateNewsBulkState();
        showToast(res.message || 'Selected news articles deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting news articles.', 'danger');
      }
    });
  });

  // News Approval AJAX
  $(document).on('click', '.action-news-approve', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var newsTitle = $t.data('name') || 'News Article';
    var uri = '<?=base_url('doctor/newsreg/newsapprove')?>';
    
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
          showToast(newsTitle + ' has been approved.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Pending');
          showToast(newsTitle + ' approval status set to Pending.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // News Status AJAX
  $(document).on('click', '.action-news-status', function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var newsTitle = $t.data('name') || 'News Article';
    var uri = '<?=base_url('doctor/newsreg/newsverify')?>';
    
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
          $t.find('span').text('Active');
          showToast(newsTitle + ' is now Active.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Inactive');
          showToast(newsTitle + ' is now Inactive.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        window.location.href = $t.attr('href');
      }
    });
  });

  // Delete Single News
  var activeDeleteNewsId = null;
  $(document).on('click', '.delete-news-btn', function(e){
    e.preventDefault();
    activeDeleteNewsId = $(this).data('id');
    var name = $(this).data('name') || 'this article';
    $('#delete-news-name').text('"' + name + '"');
    $('#deleteNewsModal').modal('show');
  });

  $('#confirm-delete-news-btn').click(function(){
    if(!activeDeleteNewsId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/newsreg/deletenews')?>',
      dataType: 'json',
      data: { id: activeDeleteNewsId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteNewsModal').modal('hide');
        $('#row-' + activeDeleteNewsId).fadeOut(400, function(){
          $(this).remove();
          if ($('#news-table tbody tr').length === 0) {
            $('#news-table tbody').html('<tr><td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;"><i class="fa fa-newspaper-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i><p style="font-size: 14px; font-weight: 500; margin: 0;">No medical news articles found.</p></td></tr>');
          }
          updateNewsBulkState();
        });
        showToast(res.message || 'News article deleted successfully.', 'success');
        activeDeleteNewsId = null;
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url('doctor/newsreg/deletenews/')?>' + activeDeleteNewsId;
      }
    });
  });
});
</script>
