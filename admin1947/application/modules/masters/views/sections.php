<style>
  .master-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
  }
  .master-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .master-card-title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none !important;
    cursor: pointer;
    transition: all 0.2s;
  }
  .badge-status-active {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
  }
  .badge-status-active:hover {
    background: #bbf7d0;
    color: #166534;
  }
  .badge-status-inactive {
    background: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fecaca;
  }
  .badge-status-inactive:hover {
    background: #fecaca;
    color: #991b1b;
  }
  .btn-action-icon {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid transparent;
    transition: all 0.2s;
    text-decoration: none !important;
    font-size: 13px;
  }
  .btn-action-edit {
    background: #e0f2fe;
    color: #0284c7;
    border-color: #bae6fd;
  }
  .btn-action-edit:hover {
    background: #0284c7;
    color: #ffffff;
  }
  .btn-action-delete {
    background: #fee2e2;
    color: #dc2626;
    border-color: #fecaca;
  }
  .btn-action-delete:hover {
    background: #dc2626;
    color: #ffffff;
  }
  .icon-preset-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 11px;
    color: #334155;
    cursor: pointer;
    transition: all 0.15s;
    user-select: none;
  }
  .icon-preset-chip:hover {
    background: #00a896;
    color: #ffffff;
    border-color: #00a896;
  }
  .icon-preview-box {
    width: 44px;
    height: 40px;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #00a896;
    flex-shrink: 0;
  }
</style>

<div class="content-wrapper">
  <!-- Toast Notification Container -->
  <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 4px 0; font-family: 'Inter', sans-serif;">
          <i class="fa fa-folder-open-o" style="color: #00a896;"></i> Master Sidebar Sections
        </h1>
        <p style="margin: 0; color: #64748B; font-size: 13px;">Manage navigation sections, customize font icons, and enable or disable sidebar groupings</p>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; padding: 0; background: transparent; margin: 0;">
        <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="javascript:void(0);">Masters</a></li>
        <li class="active">Sections</li>
      </ol>
    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding: 10px 20px 30px;">
    <?=$this->session->flashdata('flashmsg');?>

    <!-- Two Column Master Grid Layout -->
    <div class="row">
      <!-- Left Column: Add / Edit Section Form -->
      <div class="col-lg-4 col-md-5 col-xs-12" style="margin-bottom: 20px;">
        <div class="master-card" style="position: sticky; top: 20px;">
          <div class="master-card-header">
            <h3 class="master-card-title" id="form-title">
              <i class="fa fa-plus-circle" style="color: #00a896;"></i> <span>Add New Section</span>
            </h3>
            <span id="edit-badge" class="badge" style="background: #0284c7; display: none; font-size: 11px;">Editing Mode</span>
          </div>

          <form action="<?=base_url('masters/sections/create')?>" method="post" id="section_form" style="padding: 20px;">
            <input type="hidden" id="eid" name="eid" value="">

            <div style="display: flex; flex-direction: column; gap: 16px;">
              <!-- Section Name Input -->
              <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                  Section Name <span style="color: #EF4444;">*</span>
                </label>
                <input type="text" class="form-control" id="section_name" name="section" placeholder="e.g., Clinical Core, Doctors..." required style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13.5px; font-weight: 600;">
              </div>

              <!-- FontAwesome Icon Class with Live Preview -->
              <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                  FontAwesome Icon Class <span style="color: #EF4444;">*</span>
                </label>
                <div style="display: flex; gap: 10px; align-items: center;">
                  <div class="icon-preview-box" id="icon-preview" title="Live Icon Preview">
                    <i class="fa fa-folder-open-o" id="preview-i"></i>
                  </div>
                  <input type="text" class="form-control" id="section_icon" name="section_icon" placeholder="fa fa-user-md, fa-hospital-o..." required style="height: 40px; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 13.5px;" value="fa fa-folder-open-o">
                </div>
              </div>

              <!-- Quick FontAwesome Icon Presets -->
              <div>
                <label style="display: block; font-size: 11.5px; font-weight: 600; color: #64748B; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                  Suggested Font Icons:
                </label>
                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-user-md')"><i class="fa fa-user-md"></i> Doctor</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-hospital-o')"><i class="fa fa-hospital-o"></i> Hospital</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-medkit')"><i class="fa fa-medkit"></i> Clinic</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-flask')"><i class="fa fa-flask"></i> Lab</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-calendar-check-o')"><i class="fa fa-calendar-check-o"></i> Appt</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-users')"><i class="fa fa-users"></i> Users</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-pie-chart')"><i class="fa fa-pie-chart"></i> Masters</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-id-card')"><i class="fa fa-id-card"></i> ABDM</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-heartbeat')"><i class="fa fa-heartbeat"></i> Health</span>
                  <span class="icon-preset-chip" onclick="setIcon('fa fa-cog')"><i class="fa fa-cog"></i> Settings</span>
                </div>
              </div>

              <!-- Submit & Cancel Buttons -->
              <div style="display: flex; gap: 10px; margin-top: 8px;">
                <button type="button" id="reset-btn" class="btn" style="flex: 1; background: #F1F5F9; color: #475569; font-weight: 600; padding: 10px; border-radius: 8px; border: 1px solid #CBD5E1;">
                  Reset
                </button>
                <button type="submit" id="submit-btn" name="submit" class="btn" style="flex: 1.5; background: #00a896; color: #FFFFFF; font-weight: 600; padding: 10px; border-radius: 8px; border: none; box-shadow: 0 2px 4px rgba(0,168,150,0.3);">
                  <i class="fa fa-check"></i> <span id="submit-btn-text">Add Section</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Column: Sections Data Table Card -->
      <div class="col-lg-8 col-md-7 col-xs-12">
        <div class="master-card">
          <div class="master-card-header">
            <h3 class="master-card-title">
              <i class="fa fa-list-ul" style="color: #00a896;"></i> <span>Master Sections Directory</span>
            </h3>
            <span style="font-size: 12px; color: #64748b; font-weight: 600;">
              Total: <strong><?=count($sections ?? []);?></strong> Sections
            </span>
          </div>

          <div class="table-responsive" style="padding: 16px 20px;">
            <table class="table table-hover table-striped" id="sections-table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
              <thead>
                <tr style="background: #F8FAFC;">
                  <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; width: 60px; text-align: center;">#ID</th>
                  <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Section Name</th>
                  <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Font / Icon</th>
                  <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: center; width: 140px;">Status</th>
                  <th style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: center; width: 110px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($sections)): ?>
                  <?php foreach($sections as $row): 
                    $status = $row['isStatus'];
                    $isEnabled = ($status == '1');
                    $iconClass = !empty($row['section_icon']) ? $row['section_icon'] : 'fa fa-folder-o';
                    if(strpos($iconClass, 'fa ') === false && strpos($iconClass, 'fa-') !== false) {
                      $iconClass = 'fa ' . $iconClass;
                    }
                  ?>
                  <tr id="section-row-<?=$row['section_id'];?>" style="border-bottom: 1px solid #F1F5F9;">
                    <td style="padding: 12px 14px; font-weight: 600; color: #64748B; text-align: center; font-size: 13px;">
                      <?=$row['section_id'];?>
                    </td>
                    <td style="padding: 12px 14px;">
                      <div style="font-weight: 700; color: #0F172A; font-size: 14px;" id="name-val-<?=$row['section_id'];?>">
                        <?=$row['section_name'];?>
                      </div>
                    </td>
                    <td style="padding: 12px 14px;">
                      <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 32px; height: 32px; border-radius: 6px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                          <i class="<?=$iconClass;?>" id="icon-display-<?=$row['section_id'];?>"></i>
                        </div>
                        <code style="background: #f1f5f9; color: #334155; padding: 2px 6px; border-radius: 4px; font-size: 12px;" id="icon-code-<?=$row['section_id'];?>">
                          <?=$row['section_icon'];?>
                        </code>
                      </div>
                    </td>
                    <td style="padding: 12px 14px; text-align: center;">
                      <a href="javascript:void(0);" class="badge-status <?=$isEnabled ? 'badge-status-active' : 'badge-status-inactive';?> status-toggle-btn" 
                         data-id="<?=$row['section_id'];?>" 
                         data-status="<?=$status;?>"
                         id="status-badge-<?=$row['section_id'];?>"
                         title="Click to Enable / Disable section">
                        <i class="fa <?=$isEnabled ? 'fa-check-circle' : 'fa-ban';?>"></i>
                        <span id="status-text-<?=$row['section_id'];?>"><?=$isEnabled ? 'Enabled (Active)' : 'Disabled';?></span>
                      </a>
                    </td>
                    <td style="padding: 12px 14px; text-align: center;">
                      <div style="display: flex; gap: 6px; justify-content: center;">
                        <a href="javascript:void(0);" class="btn-action-icon btn-action-edit edit-section-btn" 
                           data-id="<?=base64_encode($row['section_id']);?>"
                           data-rawid="<?=$row['section_id'];?>"
                           data-name="<?=htmlspecialchars($row['section_name']);?>"
                           data-icon="<?=htmlspecialchars($row['section_icon']);?>"
                           title="Edit Name &amp; Font Icon">
                          <i class="fa fa-pencil"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn-action-icon btn-action-delete delete-section-btn"
                           data-id="<?=$row['section_id'];?>"
                           data-name="<?=htmlspecialchars($row['section_name']);?>"
                           title="Delete Section">
                          <i class="fa fa-trash-o"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
function setIcon(iconClass) {
  $('#section_icon').val(iconClass).trigger('input');
}

function showToast(message, type = 'success') {
  var bgColor = (type === 'success') ? '#10b981' : ((type === 'info') ? '#0284c7' : '#ef4444');
  var icon = (type === 'success') ? 'fa-check-circle' : ((type === 'info') ? 'fa-info-circle' : 'fa-exclamation-triangle');
  var toast = $(`
    <div style="background: ${bgColor}; color: #ffffff; padding: 12px 18px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 10px; font-size: 13.5px; font-weight: 600; min-width: 280px; opacity: 0; transform: translateY(-10px); transition: all 0.3s ease;">
      <i class="fa ${icon}" style="font-size: 16px;"></i>
      <span>${message}</span>
    </div>
  `);
  $('#toast-container').append(toast);
  setTimeout(function() {
    toast.css({ 'opacity': '1', 'transform': 'translateY(0)' });
  }, 50);
  setTimeout(function() {
    toast.css({ 'opacity': '0', 'transform': 'translateY(-10px)' });
    setTimeout(function() { toast.remove(); }, 300);
  }, 3500);
}

$(document).ready(function() {
  // Live Icon Preview updater
  $('#section_icon').on('input keyup change', function() {
    var val = $(this).val().trim();
    if (!val) {
      val = 'fa fa-folder-open-o';
    }
    if (val.indexOf('fa ') === -1 && val.indexOf('fa-') !== -1) {
      val = 'fa ' + val;
    }
    $('#preview-i').attr('class', val);
  });

  // Edit Section Button Click
  $(document).on('click', '.edit-section-btn', function() {
    var rawId = $(this).attr('data-rawid');
    var encodedId = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    var icon = $(this).attr('data-icon');

    $('#eid').val(encodedId);
    $('#section_name').val(name);
    $('#section_icon').val(icon).trigger('input');

    $('#form-title').html('<i class="fa fa-edit" style="color: #0284c7;"></i> <span>Edit Section #' + rawId + '</span>');
    $('#edit-badge').show();
    $('#submit-btn').css({ 'background': '#0284c7', 'box-shadow': '0 2px 4px rgba(2,132,199,0.3)' });
    $('#submit-btn-text').text('Update Section');

    $('html, body').animate({
      scrollTop: $('#section_form').offset().top - 100
    }, 400);
    $('#section_name').focus();
  });

  // Reset Button
  $('#reset-btn').click(function() {
    $('#eid').val('');
    $('#section_name').val('');
    $('#section_icon').val('fa fa-folder-open-o').trigger('input');
    $('#form-title').html('<i class="fa fa-plus-circle" style="color: #00a896;"></i> <span>Add New Section</span>');
    $('#edit-badge').hide();
    $('#submit-btn').css({ 'background': '#00a896', 'box-shadow': '0 2px 4px rgba(0,168,150,0.3)' });
    $('#submit-btn-text').text('Add Section');
  });

  // AJAX Status Toggle (Enable / Disable)
  $(document).on('click', '.status-toggle-btn', function() {
    var $btn = $(this);
    var uid = $btn.attr('data-id');
    var currentStatus = $btn.attr('data-status');

    $btn.css('opacity', '0.5');

    $.ajax({
      type: "POST",
      url: "<?=base_url('masters/sections/statusupdate')?>",
      data: { uid: uid },
      dataType: "json",
      success: function(resp) {
        $btn.css('opacity', '1');
        var newStatus = resp.new_status;
        $btn.attr('data-status', newStatus);

        if (newStatus == '1') {
          $btn.removeClass('badge-status-inactive').addClass('badge-status-active');
          $btn.find('i').attr('class', 'fa fa-check-circle');
          $('#status-text-' + uid).text('Enabled (Active)');
          showToast('Section enabled and visible in sidebar!', 'success');
        } else {
          $btn.removeClass('badge-status-active').addClass('badge-status-inactive');
          $btn.find('i').attr('class', 'fa fa-ban');
          $('#status-text-' + uid).text('Disabled');
          showToast('Section disabled and hidden from sidebar!', 'info');
        }
      },
      error: function() {
        $btn.css('opacity', '1');
        showToast('Error updating status. Please try again.', 'error');
      }
    });
  });

  // Delete Section with Confirmation
  $(document).on('click', '.delete-section-btn', function() {
    var uid = $(this).attr('data-id');
    var name = $(this).attr('data-name');

    if (confirm("Are you sure you want to delete section '" + name + "'? This cannot be undone.")) {
      $.ajax({
        type: "POST",
        url: "<?=base_url('masters/sections/delete/')?>" + uid,
        success: function(res) {
          $('#section-row-' + uid).fadeOut(300, function() {
            $(this).remove();
          });
          showToast('Section deleted successfully!', 'success');
        },
        error: function() {
          showToast('Failed to delete section.', 'error');
        }
      });
    }
  });
});
</script>
