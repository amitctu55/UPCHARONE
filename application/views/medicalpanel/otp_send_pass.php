<?php $this->load->view("includes/header.php"); ?>

<?php
// Look up active signup session or most recent chemist record
$signup_uid = $this->session->userdata('medicalsignupuserid') ?? ($this->session->userdata('medicaluserid') ?? 0);
$chem_user = null;
if ($signup_uid) {
    $chem_user = $this->db->get_where('chemistlogin', array('USERID' => $signup_uid))->row();
    if (!$chem_user) {
        $chem_user = $this->db->get_where('profile_chem', array('user_id' => $signup_uid))->row();
    }
}
if (!$chem_user) {
    // If user lands directly on this page without session, look up most recent unverified chemist for smooth onboarding/testing
    $chem_user = $this->db->order_by('USERID', 'DESC')->limit(1)->get('chemistlogin')->row();
    if ($chem_user) {
        $this->session->set_userdata('medicalsignupuserid', $chem_user->USERID);
    }
}
$rawMobile = $chem_user ? ($chem_user->MOBILE ?? ($chem_user->mobile ?? '')) : '';
$displayMobile = !empty($rawMobile) ? ('+91 ' . substr($rawMobile, 0, 2) . '******' . substr($rawMobile, -2)) : 'your registered mobile';
$currentOtp = $chem_user ? ($chem_user->OTP ?? ($chem_user->otp ?? '')) : '';
?>

<div class="auth-wrapper">
  <div class="auth-card" style="max-width: 480px; margin: 40px auto;">
    
    <!-- Header Icon & Titles -->
    <div class="otp-header-wrapper text-center">
      <div class="otp-icon-circle">
        <i class="fas fa-shield-alt"></i>
      </div>
      <h3 class="auth-title" style="margin-top: 14px; margin-bottom: 6px; font-weight: 800; color: #08364B;">Verify Mobile Number</h3>
      <p class="auth-subtitle" style="font-size: 13.5px; color: #64748B; margin-bottom: 12px; line-height: 1.5;">
        We've sent a 6-digit verification code to<br>
        <strong style="color: #08364B; font-size: 14.5px;"><?=$displayMobile;?></strong>
      </p>

      <?php if (!empty($currentOtp)): ?>
      <div class="demo-otp-banner" style="display: inline-block; background: #e0f2fe; border: 1px dashed #00a8ff; color: #0369a1; padding: 5px 14px; border-radius: 20px; font-size: 12.5px; font-weight: 700; margin-bottom: 16px;">
        <i class="fas fa-key" style="margin-right: 5px;"></i> OTP: <span id="demoOtpDisplay" style="letter-spacing: 1px; font-size: 13.5px; color: #0284c7;"><?=$currentOtp;?></span>
      </div>
      <?php endif; ?>
    </div>

    <!-- Floating In-Card Alert Box -->
    <div id="otpAlert" style="display: none; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 18px;"></div>

    <!-- OTP Form -->
    <form class="auth-form" id="medsignupotpform" action="<?=base_url();?>Medicaluser/verifysignupotp" method="POST">
      <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
      <input type="hidden" name="otp" id="finalOtpInput">
      <input type="hidden" name="userid" value="<?=$signup_uid;?>">

      <!-- 6-Box Segmented OTP Inputs -->
      <div class="otp-boxes-group">
        <input type="text" class="otp-box-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*" autofocus autocomplete="one-time-code">
        <input type="text" class="otp-box-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*">
        <input type="text" class="otp-box-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*">
        <input type="text" class="otp-box-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*">
        <input type="text" class="otp-box-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*">
        <input type="text" class="otp-box-digit" maxlength="1" inputmode="numeric" pattern="[0-9]*">
      </div>

      <button type="submit" class="btn-submit" id="btnVerifyOtp" style="margin-top: 18px; width: 100%;">
        <i class="fas fa-check-circle" style="margin-right: 6px;"></i> Verify &amp; Activate Account
      </button>
    </form>

    <!-- Resend & Alternative Links -->
    <div class="otp-resend-bar text-center" style="margin-top: 22px; padding-top: 18px; border-top: 1px dashed #e2e8f0;">
      <div id="resendCountdownText" style="font-size: 13px; color: #64748B;">
        Didn't receive the code? Resend in <span id="countdownTimer" style="font-weight: 700; color: #08364B;">30s</span>
      </div>
      <button type="button" id="btnResendOtp" class="btn-link-resend" style="display: none; background: none; border: none; color: #00A896; font-weight: 700; font-size: 13.5px; cursor: pointer; text-decoration: underline;">
        <i class="fas fa-redo-alt" style="margin-right: 5px;"></i> Resend OTP via SMS
      </button>

      <div style="margin-top: 14px;">
        <a href="<?=base_url('medical-signup');?>" style="font-size: 12.5px; color: #64748B; text-decoration: none;">
          <i class="fas fa-arrow-left" style="margin-right: 4px;"></i> Wrong details? Back to Signup
        </a>
      </div>
    </div>

  </div>
</div>

<style>
.otp-icon-circle {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #00A896 0%, #08364B 100%);
  color: #ffffff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
  margin: 0 auto;
  box-shadow: 0 4px 14px rgba(0, 168, 150, 0.28);
}
.otp-boxes-group {
  display: flex;
  justify-content: space-between;
  gap: 8px;
  margin: 18px 0 12px;
}
.otp-box-digit {
  width: 54px;
  height: 58px;
  border: 2px solid #CBD5E1;
  border-radius: 10px;
  font-size: 24px;
  font-weight: 800;
  color: #08364B;
  text-align: center;
  background: #F8FAFC;
  outline: none;
  transition: all 0.2s ease-in-out;
}
.otp-box-digit:focus {
  border-color: #00A896;
  background: #FFFFFF;
  box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.18);
  transform: translateY(-2px);
}
@media (max-width: 480px) {
  .otp-box-digit {
    width: 42px;
    height: 48px;
    font-size: 20px;
    gap: 4px;
  }
}
</style>

<?php $this->load->view('includes/footer.php'); ?>

<script>
$(document).ready(function() {
  var digits = $('.otp-box-digit');

  function collectOtp() {
    var val = '';
    digits.each(function() {
      val += $(this).val();
    });
    $('#finalOtpInput').val(val);
    return val;
  }

  // Handle individual digit input and auto-advance
  digits.on('input', function(e) {
    var val = $(this).val().replace(/[^0-9]/g, '');
    $(this).val(val);
    if (val && $(this).next('.otp-box-digit').length) {
      $(this).next('.otp-box-digit').focus();
    }
    collectOtp();
  });

  // Handle backspace navigation
  digits.on('keydown', function(e) {
    if (e.key === 'Backspace' && !$(this).val() && $(this).prev('.otp-box-digit').length) {
      $(this).prev('.otp-box-digit').focus();
    }
  });

  // Handle paste full 6-digit OTP
  digits.first().on('paste', function(e) {
    var pasteData = (e.originalEvent || e).clipboardData.getData('text').trim();
    if (pasteData && pasteData.length === 6 && /^\d+$/.test(pasteData)) {
      e.preventDefault();
      digits.each(function(i) {
        $(this).val(pasteData[i]);
      });
      collectOtp();
      digits.last().focus();
    }
  });

  // Countdown timer for Resend OTP
  var timeLeft = 30;
  var timerInterval = setInterval(function() {
    timeLeft--;
    $('#countdownTimer').text(timeLeft + 's');
    if (timeLeft <= 0) {
      clearInterval(timerInterval);
      $('#resendCountdownText').hide();
      $('#btnResendOtp').fadeIn();
    }
  }, 1000);

  function showAlert(msg, isSuccess) {
    var alertBox = $('#otpAlert');
    alertBox.removeClass('alert-success alert-danger');
    alertBox.css({
      'background': isSuccess ? '#e8f8f0' : '#fee2e2',
      'color': isSuccess ? '#065f46' : '#991b1b',
      'border': isSuccess ? '1px solid #a7f3d0' : '1px solid #fecaca',
      'display': 'block'
    }).html((isSuccess ? '<i class="fas fa-check-circle" style="margin-right:6px;"></i> ' : '<i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i> ') + msg);
  }

  // Handle Form Submission
  $('#medsignupotpform').submit(function(e) {
    e.preventDefault();
    var otpVal = collectOtp();
    if (!otpVal || otpVal.length !== 6) {
      showAlert('Please enter the complete 6-digit OTP code.', false);
      return false;
    }

    var btn = $('#btnVerifyOtp');
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Verifying Code...');

    $.ajax({
      type: "POST",
      url: $(this).attr('action'),
      data: $(this).serialize(),
      success: function(response) {
        try {
          response = (typeof response === 'object') ? response : JSON.parse(response);
        } catch(e) {}

        if (response.status === 'success') {
          showAlert('Account verified successfully! Redirecting to dashboard...', true);
          setTimeout(function() {
            window.location = "<?=base_url();?>medical-dashboard";
          }, 800);
        } else {
          showAlert(response.msg || 'Invalid verification code. Please check and try again.', false);
          btn.prop('disabled', false).html('<i class="fas fa-check-circle" style="margin-right: 6px;"></i> Verify &amp; Activate Account');
        }
      },
      error: function() {
        showAlert('Network or server error during verification. Please try again.', false);
        btn.prop('disabled', false).html('<i class="fas fa-check-circle" style="margin-right: 6px;"></i> Verify &amp; Activate Account');
      }
    });
  });

  // Handle Resend OTP Action
  $('#btnResendOtp').click(function(e) {
    e.preventDefault();
    var resendBtn = $(this);
    resendBtn.prop('disabled', true).text('Sending new OTP...');

    $.ajax({
      type: "POST",
      url: '<?=base_url();?>Medicaluser/resendsignupotp',
      data: {
        '<?=$this->security->get_csrf_token_name();?>': '<?=$this->security->get_csrf_hash();?>',
        'userid': '<?=$signup_uid;?>'
      },
      success: function(response) {
        try {
          response = (typeof response === 'object') ? response : JSON.parse(response);
        } catch(e) {}

        if (response.status === 'success') {
          if (response.otp) {
            $('#demoOtpDisplay').text(response.otp);
          }
          showAlert(response.msg || 'A fresh OTP has been sent via SMS!', true);
          // Restart countdown
          resendBtn.hide().prop('disabled', false).html('<i class="fas fa-redo-alt" style="margin-right: 5px;"></i> Resend OTP via SMS');
          timeLeft = 30;
          $('#countdownTimer').text('30s');
          $('#resendCountdownText').show();
          timerInterval = setInterval(function() {
            timeLeft--;
            $('#countdownTimer').text(timeLeft + 's');
            if (timeLeft <= 0) {
              clearInterval(timerInterval);
              $('#resendCountdownText').hide();
              $('#btnResendOtp').fadeIn();
            }
          }, 1000);
        } else {
          showAlert(response.msg || 'Failed to resend OTP. Please try again.', false);
          resendBtn.prop('disabled', false).html('<i class="fas fa-redo-alt" style="margin-right: 5px;"></i> Resend OTP via SMS');
        }
      },
      error: function() {
        showAlert('Error sending OTP. Please try again.', false);
        resendBtn.prop('disabled', false).html('<i class="fas fa-redo-alt" style="margin-right: 5px;"></i> Resend OTP via SMS');
      }
    });
  });
});
</script>