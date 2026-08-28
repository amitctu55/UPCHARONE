<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Admin Users & Staff</h1>
        <small style="color: #64748b; font-size: 13px;">Manage administrator accounts, staff roles, and access credentials</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('users/users/usercreate')?>" style="color: #64748b;">Staff</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Users</li>
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
        <!-- LEFT: Add / Edit User Form (5 Cols) -->
        <div class="col-lg-5 col-md-6">
          <div class="master-card master-sticky-form">
            <div class="master-card-header">
              <h3 class="master-card-title">
                <i class="fa fa-user-plus" style="color: #00a896;"></i>
                <span id="user-form-title">Create Admin User</span>
              </h3>
            </div>

            <form action="<?=base_url('users/usercreate/create')?>" method="post" id="user-admin-form" class="master-card-body">
              <input type="hidden" id="eid" name="eid" value="">

              <div class="form-group" style="margin-bottom: 15px;">
                <label for="username" style="font-weight: 600; font-size: 13px; color: #334155;">Full Name <span style="color: #ef4444;">*</span></label>
                <input type="text" class="form-control" id="username" name="username" placeholder="e.g. John Doe" required style="border-radius: 8px; height: 38px;">
              </div>

              <div class="form-group" style="margin-bottom: 15px;">
                <label for="usermobile" style="font-weight: 600; font-size: 13px; color: #334155;">Mobile Number <span style="color: #ef4444;">*</span></label>
                <input type="text" class="form-control" id="usermobile" name="usermobile" placeholder="10-digit mobile" maxlength="10" required style="border-radius: 8px; height: 38px;">
              </div>

              <div class="form-group" style="margin-bottom: 15px;">
                <label for="useremail" style="font-weight: 600; font-size: 13px; color: #334155;">Email Address <span style="color: #ef4444;">*</span></label>
                <input type="email" class="form-control" id="useremail" name="useremail" placeholder="admin@upchar.com" required style="border-radius: 8px; height: 38px;">
              </div>

              <div class="form-group" style="margin-bottom: 15px;">
                <label for="userdob" style="font-weight: 600; font-size: 13px; color: #334155;">Date of Birth</label>
                <input type="date" class="form-control" id="userdob" name="userdob" style="border-radius: 8px; height: 38px;">
              </div>

              <div class="form-group" style="margin-bottom: 15px;">
                <label for="useraddress" style="font-weight: 600; font-size: 13px; color: #334155;">Address</label>
                <input type="text" class="form-control" id="useraddress" name="useraddress" placeholder="Physical location / department" style="border-radius: 8px; height: 38px;">
              </div>

              <div class="form-group" style="margin-bottom: 15px;">
                <label for="resetpassword" style="font-weight: 600; font-size: 13px; color: #334155;">Login Password <span style="color: #ef4444;">*</span></label>
                <input type="password" class="form-control" id="resetpassword" name="resetpassword" placeholder="Account password" style="border-radius: 8px; height: 38px;">
              </div>

              <div style="display: flex; gap: 10px; justify-content: flex-end; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <button type="reset" id="user-reset-btn" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 8px 18px;">
                  <i class="fa fa-refresh"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 8px; font-weight: 600; padding: 8px 22px;">
                  <i class="fa fa-check"></i> Save User
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- RIGHT: Users List Table (7 Cols) -->
        <div class="col-lg-7 col-md-6">
          <div class="master-card">
            <div class="master-card-header">
              <h3 class="master-card-title">
                <i class="fa fa-users" style="color: #00a896;"></i>
                <span>Admin Staff Directory</span>
              </h3>
            </div>

            <div class="master-card-body" style="padding: 16px 20px;">
              <div class="table-responsive" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                <table class="table table-hover table-striped" style="margin: 0;">
                  <thead>
                    <tr>
                      <th style="width: 50px; text-align: center;">#ID</th>
                      <th>Staff Name</th>
                      <th>Contact Info</th>
                      <th style="width: 100px; text-align: center;">Status</th>
                      <th style="width: 100px; text-align: center;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $staffUsers = $this->db->get_where('login', array('status!='=>'2'))->result_array();
                    if(!empty($staffUsers)): foreach($staffUsers as $val): 
                      $isActive = ($val['status'] == 1);
                    ?>
                      <tr id="row-<?=$val['id'];?>">
                        <td style="text-align: center; font-weight: 600; color: #64748b;"><?=$val['id'];?></td>
                        <td>
                          <strong style="color: #1e293b; font-size: 13.5px;"><?=$val['username'];?></strong>
                        </td>
                        <td>
                          <div style="font-size: 12.5px; color: #334155;"><?=$val['email'];?></div>
                          <div style="font-size: 12px; color: #64748b;"><?=$val['mobile'];?></div>
                        </td>
                        <td style="text-align: center;">
                          <span class="badge-pill-status <?=$isActive ? 'badge-status-active' : 'badge-status-inactive';?>">
                            <i class="fa fa-circle" style="font-size: 6px;"></i>
                            <span><?=$isActive ? 'Active' : 'Inactive';?></span>
                          </span>
                        </td>
                        <td style="text-align: center;">
                          <a href="javascript:void(0);" class="btn-icon-action btn-action-edit edit-user-btn" data-id="<?=$val['id'];?>" data-name="<?=$val['username'];?>" data-mobile="<?=$val['mobile'];?>" data-email="<?=$val['email'];?>" data-address="<?=$val['address'];?>" title="Edit User">
                            <i class="fa fa-pencil"></i>
                          </a>
                          <a href="<?=base_url('users/usercreate/delete/'.$val['id']);?>" onclick="return confirm('Are you sure you want to delete this user?');" class="btn-icon-action btn-action-delete" title="Delete User">
                            <i class="fa fa-trash-o"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; else: ?>
                      <tr>
                        <td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                          <i class="fa fa-users fa-3x" style="margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                          <p style="font-size: 14px; font-weight: 500; margin: 0;">No admin staff records found.</p>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
$(document).ready(function(){
  $('.edit-user-btn').click(function(){
    var id = $(this).data('id');
    var name = $(this).data('name');
    var mobile = $(this).data('mobile');
    var email = $(this).data('email');
    var address = $(this).data('address');

    $('#eid').val(id);
    $('#username').val(name).focus();
    $('#usermobile').val(mobile);
    $('#useremail').val(email);
    $('#useraddress').val(address);
    $('#user-form-title').text('Edit Admin User');

    $('html, body').animate({ scrollTop: $('#user-admin-form').offset().top - 100 }, 300);
  });

  $('#user-reset-btn').click(function(){
    $('#eid').val('');
    $('#username').val('');
    $('#usermobile').val('');
    $('#useremail').val('');
    $('#useraddress').val('');
    $('#resetpassword').val('');
    $('#user-form-title').text('Create Admin User');
  });
});
</script>
