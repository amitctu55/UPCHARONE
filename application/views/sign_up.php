<?php include ("includes/header.php"); ?>

<div class="auth-wrapper">
  <div class="auth-card">
    
    <!-- Segmented Tab Switcher -->
    <div class="auth-tabs">
      <a href="<?=base_url('login');?>" class="auth-tab-btn">Login</a>
      <a href="<?=base_url('signup');?>" class="auth-tab-btn active">Sign up</a>
    </div>

    <!-- Patient Registration Form -->
    <form class="auth-form" id="registrationform" action="<?=base_url();?>User/register" method="POST">
      <div class="form-group">
        <label for="name">Full Name <span class="required">*</span></label>
        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. John Doe" required>
      </div>

      <div class="form-group">
        <label for="email">E-Mail Address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com">
      </div>

      <div class="form-group">
        <label for="mobile">Mobile Number <span class="required">*</span></label>
        <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="+91 9876543210" onkeypress="return isNumber(event)" maxlength="10" required>
      </div>

      <div class="form-group">
        <label for="password">Password <span class="required">*</span></label>
        <div class="password-input-wrapper">
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" pattern="(?=.*\d)(?=.*[a-z]).{6,}" required>
          <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
            <i class="fa fa-eye" id="togglePasswordIcon"></i>
          </button>
        </div>
      </div>

      <div class="form-group checkbox-group">
        <input type="checkbox" id="terms" required>
        <label for="terms" style="margin-bottom: 0; font-weight: normal; cursor: pointer;">
          I agree to the <a href="<?=base_url('tnc');?>" class="link-primary" target="_blank">Terms & Conditions</a>
        </label>
      </div>

      <button type="submit" class="btn-submit" id="sub_button">Create Account</button>
    </form>

  </div>
</div>

<?php include ("includes/footer.php"); ?>

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

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$(document).ready(function() {
  $('#registrationform').submit(function(e) {		
    e.preventDefault();		
    var myform = $(this);	
    var email = $('#email').val();
    var mobile = $('#mobile').val();
    var name = $('#name').val();
    var password = $('#password').val();
    
    if(email && email.indexOf('@') === -1) {
      alert('Please Enter a Valid Email Address');
      return false;
    }
    if(!mobile || mobile.length !== 10) {
      alert('Please Enter a Valid 10-Digit Mobile Number');
      return false;
    }
    if(!name || name.length < 3) {
      alert('Please Enter a Valid Name');
      return false;
    }
    if(!password || password.length < 6) {
      alert('Please Enter at least 6 characters (including a number and a letter)');
      return false;
    }
    
    $('#sub_button').prop('disabled', true).text('Registering...');

    $.ajax({			
      type: "POST",			
      url: myform.attr('action'),			
      data: myform.serialize(),			
      success: function(response) {			
        try {
          response = JSON.parse(response);
        } catch(e) {}
        if(response.status === 'success') {					
          window.location = "<?=base_url();?>verifymobile";				
        } else if(response.status === 'failed') {					
          alert(response.msg);
          $('#sub_button').prop('disabled', false).text('Create Account');
        } else {					
          alert(response.msg || 'Registration submitted');
          $('#sub_button').prop('disabled', false).text('Create Account');
        }		
      },
      error: function() {
        alert('An error occurred during registration. Please try again.');
        $('#sub_button').prop('disabled', false).text('Create Account');
      }		
    });	
  });
});
</script>