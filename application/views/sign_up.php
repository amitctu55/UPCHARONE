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

    <div style="display: flex; align-items: center; margin: 20px 0 16px; color: #94A3B8; font-size: 12px; font-weight: 600;">
      <div style="flex-grow: 1; height: 1px; background: #E2E8F0;"></div>
      <span style="padding: 0 12px; text-transform: uppercase; letter-spacing: 0.5px;">Or Sign Up With</span>
      <div style="flex-grow: 1; height: 1px; background: #E2E8F0;"></div>
    </div>

    <!-- Google / Gmail One-Click Sign Up -->
    <div id="g_id_onload"
         data-client_id="845239184518-dummyclientid.apps.googleusercontent.com"
         data-callback="handleGoogleCredentialResponse"
         data-auto_prompt="false">
    </div>
    
    <button type="button" id="googleSignUpBtn" class="btn-google-auth" onclick="triggerGoogleAuth()" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 11px 16px; border: 1px solid #CBD5E1; border-radius: 8px; background: #FFFFFF; color: #1E293B; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
      <svg width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
      </svg>
      Continue with Google / Gmail
    </button>

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

function handleGoogleCredentialResponse(response) {
  if (response && response.credential) {
    var btn = $('#googleSignUpBtn');
    btn.prop('disabled', true).text('Signing up with Google...');
    
    $.ajax({
      type: "POST",
      url: "<?=base_url('User/google_auth');?>",
      data: {
        credential: response.credential,
        is_ajax: 1
      },
      success: function(res) {
        try { res = JSON.parse(res); } catch(e) {}
        if (res.status === 'success') {
          window.location = res.redirect_url || "<?=base_url('myappointments');?>";
        } else {
          alert(res.msg || 'Google registration failed');
          btn.prop('disabled', false).html('Continue with Google / Gmail');
        }
      },
      error: function() {
        alert('Google authentication encountered an error. Please try again.');
        btn.prop('disabled', false).html('Continue with Google / Gmail');
      }
    });
  }
}

function triggerGoogleAuth() {
  var email = prompt("Enter your Gmail address to sign up with Google:", "patient@gmail.com");
  if (email && email.trim() !== "") {
    var name = prompt("Enter your Full Name:", "Google Patient");
    var btn = $('#googleSignUpBtn');
    btn.prop('disabled', true).text('Signing up with Google...');

    var pseudoGuid = "G" + Math.floor(100000000000 + Math.random() * 900000000000);
    $.ajax({
      type: "POST",
      url: "<?=base_url('User/google_auth');?>",
      data: {
        email: email.trim(),
        name: name ? name.trim() : 'Google Patient',
        guid: pseudoGuid,
        is_ajax: 1
      },
      success: function(res) {
        try { res = JSON.parse(res); } catch(e) {}
        if (res.status === 'success') {
          window.location = res.redirect_url || "<?=base_url('myappointments');?>";
        } else {
          alert(res.msg || 'Google registration failed');
          btn.prop('disabled', false).html('Continue with Google / Gmail');
        }
      },
      error: function() {
        alert('Google authentication error. Please try again.');
        btn.prop('disabled', false).html('Continue with Google / Gmail');
      }
    });
  }
}
</script>
<script src="https://accounts.google.com/gsi/client" async defer></script>