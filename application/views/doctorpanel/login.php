<?php $this->load->view("includes/header.php"); ?>

<div class="auth-wrapper">
  <div class="auth-card">
    
    <!-- Segmented Tab Switcher -->
    <div class="auth-tabs">
      <a href="<?=base_url('doctor-aindex');?>" class="auth-tab-btn active">Login</a>
      <a href="<?=base_url('doctor-signup');?>" class="auth-tab-btn">Sign up</a>
    </div>

    <!-- Partner Login Form -->
    <form class="auth-form" id="drloginform" action="<?=base_url();?>Doctoruser/login" method="POST">
      <div class="form-group">
        <label for="email">Mobile Number / Email ID <span class="required">*</span></label>
        <input type="text" id="email" name="email" class="form-control" placeholder="doctor@example.com or 10-digit mobile" required>
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
        <a href="<?=base_url('doctor-forgotpassword');?>" class="link-primary" style="font-size: 0.85rem;">Forgot password?</a>
      </div>

      <button type="submit" class="btn-submit" id="login_btn">Login to Dashboard</button>
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
  $('#drloginform').submit(function(e) {
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
          window.location = "<?=base_url();?>doctor-dashboard";
        } else if(response.status === 'otp') {
          window.location = "<?=base_url();?>doctor-verifymobile";
        } else {
          alert(response.msg || 'Incorrect Mobile/Email or Password');
          $('#login_btn').prop('disabled', false).text('Login to Dashboard');
        }
      },
      error: function() {
        alert('Login failed. Please try again.');
        $('#login_btn').prop('disabled', false).text('Login to Dashboard');
      }
    });
  });
});
</script>