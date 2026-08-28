<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Healthcare News & Announcements</h1>
        <small style="color: #64748b; font-size: 13px;">Manage hospital press releases, health articles, and medical video updates</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/newsreg/viewnews')?>" style="color: #64748b;">News</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">News List</li>
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
      <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

      <div class="master-card">
        <div class="master-card-header">
          <h3 class="master-card-title">
            <i class="fa fa-newspaper-o" style="color: #00a896;"></i>
            <span>Published Medical News</span>
          </h3>
          <div style="display: flex; gap: 8px;">
            <a href="<?=base_url('doctor/newsreg')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Add New Post
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <!-- Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" style="margin: 0;">
              <thead>
                <tr>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Article Title</th>
                  <th>Published By</th>
                  <th style="width: 110px; text-align: center;">Status</th>
                  <th style="width: 110px; text-align: center;">Approval</th>
                  <th style="width: 100px; text-align: center;">Date</th>
                  <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($news)): foreach($news as $p): 
                  $isActive = ($p['status'] == '1');
                  $isApproved = ($p['approved'] == '1');
                  $author = !empty($p['name']) ? $p['name'] : (!empty($p['fname']) ? $p['fname'] : 'Upchar Editorial');
                ?>
                  <tr id="row-<?=$p['id'];?>">
                    <td style="text-align: center; font-weight: 600; color: #64748b;"><?=$p['id'];?></td>
                    <td>
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=$p['title'];?></strong>
                    </td>
                    <td>
                      <span class="label label-default" style="background-color: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0; font-size: 11.5px;">
                        <i class="fa fa-user-circle-o"></i> <?=$author;?>
                      </span>
                    </td>
                    <td style="text-align: center;">
                      <a href="<?=base_url('doctor/newsreg/newsverify/'.$p['id']);?>" class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?> action-news-verify" data-id="<?=$p['id'];?>" data-title="<?=htmlspecialchars($p['title']);?>" title="Toggle Status">
                        <i class="fa fa-circle" style="font-size: 6px;"></i>
                        <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                      </a>
                    </td>
                    <td style="text-align: center;">
                      <a href="<?=base_url('doctor/newsreg/newsapprove/'.$p['id']);?>" class="badge-pill-status <?=$isApproved ? 'badge-status-active' : 'badge-status-inactive';?> action-news-approve" data-id="<?=$p['id'];?>" data-title="<?=htmlspecialchars($p['title']);?>" title="Toggle Approval">
                        <i class="fa fa-check-circle"></i>
                        <span><?=$isApproved ? 'Approved' : 'Pending';?></span>
                      </a>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b;">
                      <?=formatedate($p['creat_date']);?>
                    </td>
                    <td style="text-align: center;">
                      <a href="<?=base_url('doctor/newsreg/newsview/'.$p['id']);?>" class="btn-icon-action" style="background: #f1f5f9; color: #475569;" title="Preview Article">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="<?=base_url('doctor/newsreg/newsupdate/'.$p['id']);?>" class="btn-icon-action btn-action-edit" title="Edit Article">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <button type="button" class="btn-icon-action btn-action-delete delete-news-btn" data-id="<?=$p['id'];?>" data-title="<?=htmlspecialchars($p['title']);?>" title="Delete Article" style="border: none; cursor: pointer;">
                        <i class="fa fa-trash-o"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="7" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-newspaper-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No news articles published yet.</p>
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

<!-- Generic Delete Confirmation Modal -->
<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete News Article</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="delete-news-title" style="color: #1e293b;">this article</strong>? This action cannot be undone.
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

$(document).ready(function(){
  // News Status AJAX
  $('.action-news-verify').click(function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var uri = '<?=base_url()?>doctor/newsreg/newsverify';
    
    $t.css('opacity', '0.5');
    $.ajax({
      type: "post",
      url: uri,
      dataType: 'json',
      data: { did: key },
      success: function(result){
        $t.css('opacity', '1');
        if(result['status'] == 1) {
          $t.removeClass('badge-status-inactive').addClass('badge-status-active');
          $t.find('span').text('Active');
          showToast('News article is now Active.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Inactive');
          showToast('News article status set to Inactive.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        showToast('Error updating status.', 'danger');
      }
    });
  });

  // News Approval AJAX
  $('.action-news-approve').click(function(e){
    e.preventDefault();
    var $t = $(this);
    var key = $t.data('id');
    var uri = '<?=base_url()?>doctor/newsreg/newsapprove';
    
    $t.css('opacity', '0.5');
    $.ajax({
      type: "post",
      url: uri,
      dataType: 'json',
      data: { did: key },
      success: function(result){
        $t.css('opacity', '1');
        if(result['status'] == 1) {
          $t.removeClass('badge-status-inactive').addClass('badge-status-active');
          $t.find('span').text('Approved');
          showToast('News article has been Approved.', 'success');
        } else {
          $t.removeClass('badge-status-active').addClass('badge-status-inactive');
          $t.find('span').text('Pending');
          showToast('News article approval set to Pending.', 'info');
        }
      },
      error: function(){
        $t.css('opacity', '1');
        showToast('Error updating approval.', 'danger');
      }
    });
  });

  // Delete Modal & AJAX Handler
  var activeDeleteNewsId = null;
  $('.delete-news-btn').click(function(e){
    e.preventDefault();
    activeDeleteNewsId = $(this).data('id');
    var title = $(this).data('title') || 'this article';
    $('#delete-news-title').text('"' + title + '"');
    $('#deleteNewsModal').modal('show');
  });

  $('#confirm-delete-news-btn').click(function(){
    if(!activeDeleteNewsId) return;
    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url()?>doctor/newsreg/deletenews',
      dataType: 'json',
      data: { id: activeDeleteNewsId, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete');
        $('#deleteNewsModal').modal('hide');
        $('#row-' + activeDeleteNewsId).fadeOut(400, function(){
          $(this).remove();
        });
        showToast(res.message || 'News article deleted successfully.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete');
        window.location.href = '<?=base_url()?>doctor/newsreg/deletenews/' + activeDeleteNewsId;
      }
    });
  });
});
</script>
