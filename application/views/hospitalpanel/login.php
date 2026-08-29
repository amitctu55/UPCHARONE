<?php $this->load->view("includes/header.php"); ?>

<div class="auth-wrapper">
  <div class="auth-card">
    
    <!-- Segmented Tab Switcher -->
    <div class="auth-tabs">
      <a href="<?=base_url('hospital-login');?>" class="auth-tab-btn active">Login</a>
      <a href="<?=base_url('hospital-signup');?>" class="auth-tab-btn">Sign up</a>
    </div>

    <?=$this->session->flashdata('flashmsg');?>

    <!-- Hospital Login Form -->
    <form class="auth-form" id="hosloginform" action="<?=base_url();?>hospitaluser/login" method="POST">
      <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
      <div class="form-group">
        <label for="email">Mobile Number / Email ID <span class="required">*</span></label>
        <input type="text" id="email" name="email" class="form-control" placeholder="hospital@example.com or 10-digit mobile" required>
      </div>

      <div class="form-group">
        <label for="password">Password <span class="required">*</span></label>
        <div class="password-input-wrapper">
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
          <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
            <i class="fa fa-eye" id="togglePasswordIcon"></i>
          </button>
        </div>
      </div>

      <div style="display: flex; justify-content: flex-end; margin-bottom: 14px;">
        <a href="<?=base_url('hospital-forgotpassword');?>" class="link-primary" style="font-size: 0.85rem;">Forgot password?</a>
      </div>

      <button type="submit" class="btn-submit" id="login_btn">Login to Hospital Dashboard</button>
    </form>

  </div>
</div>

<?php $this->load->view('includes/footer.php'); ?>

<script>
function togglePasswordVisibility() {
  var pwd = document.getElementById("password");
  var icon = document.getElementById("togglePasswordIcon");
  if (pwd.type === "password") {
    pwd.type = "text";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
  } else {
    pwd.type = "password";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
  }
}

$(document).ready(function() {
  $('#hosloginform').submit(function(e) {
    e.preventDefault();
    var myform = $(this);
    $('#login_btn').prop('disabled', true).text('Logging in...');

    $.ajax({
      type: "POST",
      url: myform.attr('action'),
      data: myform.serialize(),
      success: function(response) {
        try {
          response = JSON.parse(response);
        } catch(e) {}
        if(response.status === 'success') {
          window.location = "<?=base_url();?>hospital-dashboard";
        } else if(response.status === 'otp') {
          window.location = "<?=base_url();?>hospital-verifymobile";
        } else {
          alert(response.msg || 'Incorrect Mobile/Email or Password');
          $('#login_btn').prop('disabled', false).text('Login to Hospital Dashboard');
        }
      },
      error: function() {
        alert('Login failed. Please try again.');
        $('#login_btn').prop('disabled', false).text('Login to Hospital Dashboard');
      }
    });
  });
});
</script>