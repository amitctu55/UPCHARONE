<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Registered Patients Directory</h1>
        <small style="color: #64748b; font-size: 13px;">Manage mobile app users, patient demographics, password credentials, and contact records</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('users/userlogincreate/userview')?>" style="color: #64748b;">Patients</a></li>
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

      <div class="master-card">
        <div class="master-card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
          <h3 class="master-card-title" style="margin: 0;">
            <i class="fa fa-users" style="color: #00a896;"></i>
            <span>Registered Patients List (<?=html_escape(@$total_rows ?: count($userlogin));?>)</span>
          </h3>
          <div style="display: flex; gap: 8px; align-items: center;">
            <button type="button" id="bulk-delete-users-btn" class="btn btn-sm btn-danger" style="display: none; border-radius: 6px; font-weight: 600; background: #dc2626; border-color: #dc2626;">
              <i class="fa fa-trash"></i> Delete Selected (<span id="user-selected-count">0</span>)
            </button>
            <a href="<?=base_url('users/userlogincreate')?>" class="btn btn-sm btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">
              <i class="fa fa-plus"></i> Add New Patient
            </a>
          </div>
        </div>

        <div class="master-card-body" style="padding: 20px;">
          
          <!-- Search & Filter Toolbar -->
          <form action="<?=base_url('users/userlogincreate/userview')?>" method="get" id="search_form" class="master-toolbar" style="margin-bottom: 16px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
              <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 13px; font-weight: 600; color: #475569;">Show:</span>
                <div style="width: 85px;">
                  <?php echo display_record_per_page();?>
                </div>
              </div>

              <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
                <!-- Mobile Search Input -->
                <div style="width: 160px;">
                  <input type="text" class="form-control input-sm" name="mobile" placeholder="Search Mobile..." value="<?=$this->input->get_post('mobile');?>" style="height: 34px; border-radius: 6px;">
                </div>

                <!-- Name / Email Search Input -->
                <div style="width: 220px;">
                  <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="text" class="form-control" name="keyword" placeholder="Search Patient Name / Email..." value="<?=$this->input->get_post('keyword');?>" style="height: 34px; border-radius: 6px 0 0 6px;">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary" style="height: 34px; border-radius: 0 6px 6px 0; background: #00a896; border-color: #00a896;">
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
                  </div>
                </div>

                <?php if($this->input->get_post('keyword')!='' || $this->input->get_post('mobile')!=''): ?>
                  <a href="<?=base_url('users/userlogincreate/userview')?>" class="btn btn-sm btn-default" title="Clear Filters" style="height: 34px; line-height: 22px; border-radius: 6px;">
                    <i class="fa fa-times text-danger"></i> Clear
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </form>

          <!-- Modern Data Table -->
          <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
            <table class="table table-hover table-striped" id="patients-table" style="margin: 0;">
              <thead>
                <tr style="background: #f8fafc; color: #475569;">
                  <th style="width: 40px; text-align: center;">
                    <input type="checkbox" id="select-all-users" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;" title="Select All Patients">
                  </th>
                  <th style="width: 60px; text-align: center;">#ID</th>
                  <th>Patient Name</th>
                  <th>Mobile Number</th>
                  <th>Email Address</th>
                  <th style="width: 110px; text-align: center;">DOB</th>
                  <th style="width: 90px; text-align: center;">Blood Group</th>
                  <th style="width: 120px; text-align: center;">Admin Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($userlogin)): foreach($userlogin as $p): ?>
                  <tr id="row-<?=$p->USERID;?>">
                    <td style="text-align: center;">
                      <input type="checkbox" class="user-checkbox" value="<?=$p->USERID;?>" style="cursor: pointer; width: 16px; height: 16px; accent-color: #00a896;">
                    </td>
                    <td style="text-align: center; font-weight: 600; color: #64748b;"><?=$p->USERID;?></td>
                    <td>
                      <strong style="color: #1e293b; font-size: 13.5px;"><?=html_escape($p->FNAME.' '.$p->LNAME);?></strong>
                      <div style="font-size: 11px; color: #94a3b8;">Gender: <?=html_escape($p->GENDER ?: 'Unspecified');?></div>
                    </td>
                    <td>
                      <div style="font-size: 12.5px; color: #334155;"><i class="fa fa-phone text-muted"></i> <?=html_escape($p->MOBILE);?></div>
                    </td>
                    <td>
                      <div style="font-size: 12.5px; color: #64748b;"><i class="fa fa-envelope-o text-muted"></i> <?=html_escape($p->EMAIL ?: 'N/A');?></div>
                    </td>
                    <td style="text-align: center; font-size: 12px; color: #64748b;">
                      <?=html_escape($p->DOB ?: 'N/A');?>
                    </td>
                    <td style="text-align: center;">
                      <?php if(!empty($p->BGROUP)): ?>
                        <span class="label label-danger" style="background-color: #fee2e2 !important; color: #dc2626 !important; border: 1px solid #fecaca; font-weight: 700; font-size: 11px;">
                          <?=html_escape($p->BGROUP);?>
                        </span>
                      <?php else: ?>
                        <span style="color: #94a3b8; font-size: 12px;">--</span>
                      <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                        <!-- Reset Password Power Button -->
                        <button type="button" onclick="openResetPasswordModal(<?=$p->USERID;?>, '<?=html_escape(addslashes($p->FNAME.' '.$p->LNAME));?>')" class="btn btn-xs btn-warning" style="border-radius: 6px; font-size: 11px; font-weight: 600; padding: 4px 8px; background: #f59e0b; border-color: #f59e0b; color: #ffffff;" title="Reset Patient Password">
                          <i class="fa fa-key"></i> Pass
                        </button>
                        <!-- Single Delete Button -->
                        <a href="<?=base_url('users/userlogincreate/delete?USERID='.$p->USERID);?>" onclick="return confirm('Are you sure you want to delete this patient record?');" class="btn btn-xs btn-danger" style="border-radius: 6px; font-size: 11px; padding: 4px 8px; background: #ef4444; border-color: #ef4444; color: #ffffff;" title="Delete Patient">
                          <i class="fa fa-trash-o"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="8" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                      <i class="fa fa-users fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                      <p style="font-size: 14px; font-weight: 500; margin: 0;">No patient records found matching your filters.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination Bar -->
          <?php if(!empty($page_links)): ?>
            <div style="margin-top: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
              <div style="font-size: 13px; color: #64748b;">
                Showing page results from <strong><?=html_escape(@$total_rows);?></strong> total patient records
              </div>
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

<!-- Admin Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel">
  <div class="modal-dialog modal-sm" role="document" style="margin-top: 100px;">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
      <div class="modal-header" style="background: #00a896; color: #ffffff; padding: 14px 20px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.9;"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="resetPasswordModalLabel" style="font-size: 15px; font-weight: 700;">
          <i class="fa fa-key" style="margin-right: 6px;"></i> Admin Reset Password
        </h4>
      </div>
      <form id="reset-password-form" action="<?=base_url('users/userlogincreate/reset_password');?>" method="post">
        <div class="modal-body" style="padding: 20px;">
          <input type="hidden" name="USERID" id="modal_reset_userid">
          
          <div style="margin-bottom: 12px; font-size: 13px; color: #475569;">
            Resetting password for: <strong id="modal_reset_username" style="color: #0f172a;"></strong> (ID: <span id="modal_reset_userid_display"></span>)
          </div>

          <div class="form-group" style="margin-bottom: 14px;">
            <label style="font-size: 12px; font-weight: 700; color: #334155;">New Password</label>
            <div class="input-group">
              <input type="text" class="form-control" name="new_password" id="modal_new_password" required placeholder="Enter new secret password..." style="height: 38px; border-radius: 6px 0 0 6px;">
              <span class="input-group-btn">
                <button type="button" class="btn btn-default" onclick="generateRandomPassword()" style="height: 38px; border-radius: 0 6px 6px 0;" title="Generate Random Password">
                  <i class="fa fa-magic text-primary"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px; border-top: 1px solid #e2e8f0;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Cancel</button>
          <button type="submit" class="btn btn-primary" style="border-radius: 6px; font-weight: 600; background: #00a896; border-color: #00a896;">Save Password</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Admin Powers JavaScript for Bulk Delete and Password Reset -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const selectAllCheckbox = document.getElementById('select-all-users');
  const userCheckboxes = document.querySelectorAll('.user-checkbox');
  const bulkDeleteBtn = document.getElementById('bulk-delete-users-btn');
  const selectedCountSpan = document.getElementById('user-selected-count');

  function updateBulkDeleteState() {
    const checked = document.querySelectorAll('.user-checkbox:checked');
    const count = checked.length;
    if (selectedCountSpan) selectedCountSpan.textContent = count;
    if (bulkDeleteBtn) {
      bulkDeleteBtn.style.display = count > 0 ? 'inline-block' : 'none';
    }
  }

  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function() {
      userCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
      updateBulkDeleteState();
    });
  }

  userCheckboxes.forEach(cb => {
    cb.addEventListener('change', function() {
      if (!cb.checked && selectAllCheckbox) selectAllCheckbox.checked = false;
      updateBulkDeleteState();
    });
  });

  if (bulkDeleteBtn) {
    bulkDeleteBtn.addEventListener('click', function() {
      const checked = document.querySelectorAll('.user-checkbox:checked');
      const ids = Array.from(checked).map(cb => cb.value);

      if (ids.length === 0) return;

      if (confirm('Are you sure you want to permanently delete ' + ids.length + ' selected patient account(s)?')) {
        const formData = new FormData();
        ids.forEach(id => formData.append('user_ids[]', id));

        fetch('<?=base_url("users/userlogincreate/bulk_delete");?>', {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            ids.forEach(id => {
              const row = document.getElementById('row-' + id);
              if (row) row.remove();
            });
            updateBulkDeleteState();
            alert(data.message);
          } else {
            alert(data.message || 'Error executing bulk deletion.');
          }
        })
        .catch(err => {
          console.error(err);
          alert('Bulk delete request completed. Reloading page...');
          window.location.reload();
        });
      }
    });
  }
});

function openResetPasswordModal(userId, userName) {
  document.getElementById('modal_reset_userid').value = userId;
  document.getElementById('modal_reset_userid_display').textContent = userId;
  document.getElementById('modal_reset_username').textContent = userName;
  document.getElementById('modal_new_password').value = '';
  $('#resetPasswordModal').modal('show');
}

function generateRandomPassword() {
  const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
  let pass = '';
  for (let i = 0; i < 8; i++) {
    pass += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  document.getElementById('modal_new_password').value = pass;
}
</script>
