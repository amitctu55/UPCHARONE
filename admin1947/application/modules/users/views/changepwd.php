<div class="content-wrapper">
  <!-- Content Header & Breadcrumbs -->
  <section class="content-header" style="padding: 20px 20px 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;">Change Account Password</h1>
        <small style="color: #64748b; font-size: 13px;">Update your administrative login password credentials</small>
      </div>
      <ol class="breadcrumb" style="position: static; float: none; margin: 0; background: transparent; padding: 0;">
        <li><a href="<?=base_url('masters/dashboard')?>" style="color: #00a896;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('users/changepassword')?>" style="color: #64748b;">Account</a></li>
        <li class="active" style="color: #1e293b; font-weight: 600;">Change Password</li>
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

      <div class="master-card" style="max-width: 520px; margin: 20px auto 40px;">
        <div class="master-card-header" style="background: #f8fafc;">
          <h3 class="master-card-title">
            <i class="fa fa-key" style="color: #00a896;"></i>
            <span>Update Password</span>
          </h3>
        </div>

        <div class="master-card-body" style="padding: 24px;">
          <form class="form-horizontal" method="post" id="changeform">
            <div class="form-group" style="margin-bottom: 18px;">
              <label for="old" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Current Password <span style="color: #ef4444;">*</span></label>
              <input type="password" class="form-control" id="old" placeholder="Enter current password" required style="border-radius: 8px; height: 40px;">
            </div>

            <div class="form-group" style="margin-bottom: 18px;">
              <label for="pwd" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">New Password <span style="color: #ef4444;">*</span></label>
              <input type="password" class="form-control" id="pwd" placeholder="Enter new strong password" required style="border-radius: 8px; height: 40px;">
            </div>

            <div class="form-group" style="margin-bottom: 18px;">
              <label for="cpwd" style="font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Confirm New Password <span style="color: #ef4444;">*</span></label>
              <input type="password" class="form-control" id="cpwd" placeholder="Re-type new password" required style="border-radius: 8px; height: 40px;">
            </div>

            <div id="err" style="color: #ef4444; font-size: 13px; font-weight: 600; margin-bottom: 15px;"></div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; border-top: 1px solid #e2e8f0; padding-top: 18px;">
              <button type="reset" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">
                <i class="fa fa-refresh"></i> Reset
              </button>
              <button type="submit" class="btn btn-primary" id="submit" name="submit" style="background: #00a896; border-color: #00a896; border-radius: 8px; font-weight: 600; padding: 8px 24px;">
                <i class="fa fa-check"></i> Update Password
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
$(document).ready(function(){
  $('#changeform').submit(function(e){
    e.preventDefault();
    var old = $('#old').val();
    var pwd = $('#pwd').val();
    var cpwd = $('#cpwd').val();
    var uri = '<?=base_url()?>users/changepassword/change';

    if(pwd != cpwd) {
      $('#err').text('New Password and Confirm Password do not match!');
      return false;
    }

    $.ajax({
      type: "POST",
      url: uri,
      data: { old: old, pwd: pwd },
      success: function(res) {
        if(res.trim() == '1' || res.indexOf('1') !== -1) {
          alert('Password successfully changed!');
          location.reload();
        } else {
          $('#err').text('Invalid current password! Please verify and try again.');
        }
      },
      error: function(){
        $('#err').text('Error updating password. Please try again.');
      }
    });
  });
});
</script>
