<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Hospital Media Gallery</h1>
        <small style="color: #64748b; font-size: 13px;">Manage facility photos, infrastructure galleries, and certificates</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('doctor/clinicreg/viewhospital')?>" style="color: #64748b;">Facilities</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Hospital Gallery</li>
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
            <i class="fa fa-picture-o" style="color: #00a896;"></i>
            <span>Hospital Infrastructure & Gallery Media</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-gal-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="gal-selected-count">0</span>)
            </button>
            <a href="<?=base_url('doctor/clinicreg/viewhospital')?>" class="btn btn-sm btn-default" style="border-radius: 6px; font-weight: 600;">
              <i class="fa fa-arrow-left"></i> Back to Hospitals
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          <?php if(!empty($hosp_gal)): ?>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding: 8px 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
              <label style="margin: 0; font-size: 13px; font-weight: 600; color: #475569; display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                <input type="checkbox" id="select-all-gallery" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;"> Select All Media
              </label>
              <span style="font-size: 12px; color: #64748b;">Total: <?=count($hosp_gal);?> photos</span>
            </div>

            <div class="gallery-grid">
              <?php foreach($hosp_gal as $p): 
                $isApproved = ($p['status'] == 'A');
                $imgUrl = !empty($p['image']) ? base_url('public/assets/upload/'.$p['image']) : base_url('public/assets/newpanel/dist/img/default-50x50.gif');
              ?>
                <div class="gallery-card" id="hosp-gal-<?=$p['id'];?>">
                  <div class="gallery-thumb-container">
                    <div style="position: absolute; top: 8px; left: 8px; z-index: 2;">
                      <input type="checkbox" class="gallery-checkbox" value="<?=$p['id'];?>" style="cursor: pointer; width: 18px; height: 18px; accent-color: #00a896; box-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                    </div>
                    <img src="<?=$imgUrl;?>" alt="Hospital Photo" class="gallery-thumb-img" onerror="this.src='<?=base_url('public/assets/newpanel/dist/img/default-50x50.gif');?>'">
                    <div style="position: absolute; top: 8px; right: 8px;">
                      <span class="badge-pill-status <?=$isApproved ? 'badge-status-active' : 'badge-status-inactive';?>" style="box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fa fa-circle" style="font-size: 6px;"></i>
                        <span><?=$isApproved ? 'Approved' : 'Pending';?></span>
                      </span>
                    </div>
                  </div>

                  <div class="gallery-card-body">
                    <h4 class="gallery-card-title" title="<?=htmlspecialchars($p['shot_description']);?>">
                      <?=!empty($p['shot_description']) ? htmlspecialchars($p['shot_description']) : 'Facility Media';?>
                    </h4>
                    <div class="gallery-card-meta">
                      <div><i class="fa fa-hospital-o text-muted"></i> <?=htmlspecialchars($p['name']);?></div>
                      <div><i class="fa fa-calendar text-muted"></i> <?=formatedate($p['date']);?></div>
                    </div>
                    <?php if(!empty($p['long_description'])): ?>
                      <p style="font-size: 12px; color: #475569; margin: 0 0 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <?=htmlspecialchars($p['long_description']);?>
                      </p>
                    <?php endif; ?>

                    <div class="gallery-card-actions">
                      <a href="<?=base_url('doctor/clinicreg/updategallery/'.$p['id']);?>" class="btn btn-xs btn-default" style="border-radius: 4px; font-weight: 600;">
                        <i class="fa fa-pencil text-primary"></i> Edit
                      </a>
                      <button type="button" class="btn btn-xs btn-default delete-gal-btn" data-id="<?=$p['id'];?>" style="border-radius: 4px; font-weight: 600; color: #dc2626;">
                        <i class="fa fa-trash-o"></i> Delete
                      </button>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div style="text-align: center; padding: 40px 20px; color: #94a3b8;">
              <i class="fa fa-picture-o fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
              <p style="font-size: 14px; font-weight: 500; margin: 0;">No hospital gallery photos uploaded yet.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulkDeleteGalModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body" style="padding: 28px 24px; text-align: center;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
          <i class="fa fa-trash-o"></i>
        </div>
        <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 8px;">Delete Media Photos</h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
          Are you sure you want to delete <strong id="gal-modal-count" style="color: #dc2626;">0</strong> selected photo(s)? This action cannot be undone.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
            Cancel
          </button>
          <button type="button" id="confirm-bulk-delete-gal-btn" class="btn btn-danger" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: #dc2626; border-color: #dc2626;">
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

function updateGalBulkState() {
  var count = $('.gallery-checkbox:checked').length;
  var total = $('.gallery-checkbox').length;

  $('#gal-selected-count').text(count);
  $('#gal-modal-count').text(count);

  if (count > 0) {
    $('#bulk-delete-gal-btn').fadeIn(200);
  } else {
    $('#bulk-delete-gal-btn').fadeOut(200);
  }

  if (count > 0 && count === total) {
    $('#select-all-gallery').prop('checked', true).prop('indeterminate', false);
  } else if (count > 0 && count < total) {
    $('#select-all-gallery').prop('checked', false).prop('indeterminate', true);
  } else {
    $('#select-all-gallery').prop('checked', false).prop('indeterminate', false);
  }
}

$(document).ready(function(){
  $(document).on('change', '#select-all-gallery', function(){
    var isChecked = $(this).prop('checked');
    $('.gallery-checkbox').prop('checked', isChecked);
    updateGalBulkState();
  });

  $(document).on('change', '.gallery-checkbox', function(){
    updateGalBulkState();
  });

  $(document).on('click', '#bulk-delete-gal-btn', function(){
    if ($('.gallery-checkbox:checked').length === 0) return;
    $('#bulkDeleteGalModal').modal('show');
  });

  $('#confirm-bulk-delete-gal-btn').click(function(){
    var selectedIds = [];
    $('.gallery-checkbox:checked').each(function(){
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) return;

    var $btn = $(this);
    $btn.prop('disabled', true).text('Deleting...');

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/clinicreg/bulk_delete_gallery')?>',
      dataType: 'json',
      data: { ids: selectedIds, is_ajax: 1 },
      success: function(res){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        $('#bulkDeleteGalModal').modal('hide');

        selectedIds.forEach(function(id){
          $('#hosp-gal-' + id).fadeOut(400, function(){
            $(this).remove();
          });
        });

        updateGalBulkState();
        showToast(res.message || 'Selected gallery items deleted.', 'success');
      },
      error: function(){
        $btn.prop('disabled', false).text('Yes, Delete Selected');
        showToast('Error deleting gallery items.', 'danger');
      }
    });
  });

  $(document).on('click', '.delete-gal-btn', function(e){
    e.preventDefault();
    var gid = $(this).data('id');
    if (!confirm('Are you sure you want to delete this media item?')) return;

    $.ajax({
      type: "POST",
      url: '<?=base_url('doctor/clinicreg/bulk_delete_gallery')?>',
      dataType: 'json',
      data: { ids: [gid], is_ajax: 1 },
      success: function(res){
        $('#hosp-gal-' + gid).fadeOut(400, function(){ $(this).remove(); });
        showToast('Media item deleted successfully.', 'success');
      },
      error: function(){
        window.location.href = '<?=base_url('doctor/clinicreg/delete?id=')?>' + gid;
      }
    });
  });
});
</script>
