<?php $this->load->view("includes/header.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.auth-recovery-wrapper {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 15px;
    background: linear-gradient(135deg, #f8fafc 0%, #f0fdfa 100%);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.auth-recovery-card {
    background: #ffffff;
    width: 100%;
    max-width: 480px;
    border-radius: 20px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
    border: 1px solid var(--upchar-border);
    padding: 36px 32px;
    position: relative;
    overflow: hidden;
}

.auth-recovery-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--upchar-teal) 0%, var(--upchar-navy) 100%);
}

.stepper-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    position: relative;
}

.stepper-line {
    position: absolute;
    top: 16px;
    left: 40px;
    right: 40px;
    height: 2px;
    background: #e2e8f0;
    z-index: 1;
}

.stepper-line-fill {
    height: 100%;
    width: 0%;
    background: var(--upchar-teal);
    transition: width 0.4s ease;
}

.step-node {
    position: relative;
    z-index: 2;
    background: #ffffff;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 2px solid #cbd5e1;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    transition: all 0.3s ease;
}

.step-node.active {
    border-color: var(--upchar-teal);
    background: var(--upchar-teal);
    color: #ffffff;
    box-shadow: 0 0 0 4px rgba(0, 168, 150, 0.18);
}

.step-node.completed {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
    color: var(--upchar-teal);
}

.recovery-header {
    text-align: center;
    margin-bottom: 24px;
}

.recovery-icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #f0fdfa;
    color: var(--upchar-teal);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin-bottom: 12px;
    border: 2px solid #ccfbf1;
}

.recovery-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--upchar-slate);
    margin: 0 0 6px 0;
}

.recovery-subtitle {
    font-size: 13.5px;
    color: var(--upchar-gray);
    line-height: 1.5;
    margin: 0;
}

.form-group-cstm {
    margin-bottom: 18px;
    text-align: left;
}

.form-label-cstm {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}

.form-input-cstm {
    width: 100%;
    height: 46px;
    border-radius: 10px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 14px;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-input-cstm:focus {
    background: #ffffff;
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-primary-cstm {
    width: 100%;
    height: 46px;
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14.5px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
}

.btn-primary-cstm:hover {
    background: var(--upchar-teal-dark);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
    color: #ffffff;
}

.btn-primary-cstm:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.alert-toast {
    padding: 12px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 18px;
    display: none;
    align-items: center;
    gap: 8px;
}

.alert-toast.error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.alert-toast.success {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

.auth-footer-links {
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}

.auth-link {
    color: var(--upchar-teal);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.auth-link:hover {
    color: var(--upchar-teal-dark);
    text-decoration: underline;
}

.otp-box-wrapper {
    display: flex;
    gap: 8px;
    justify-content: center;
    margin-bottom: 20px;
}

.otp-digit-input {
    width: 50px;
    height: 54px;
    border-radius: 10px;
    border: 1px solid var(--upchar-border);
    font-size: 22px;
    font-weight: 800;
    text-align: center;
    color: var(--upchar-slate);
    background: #f8fafc;
    transition: all 0.2s ease;
}

.otp-digit-input:focus {
    background: #ffffff;
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.resend-link-btn {
    background: transparent;
    border: none;
    color: var(--upchar-teal);
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    padding: 0;
}

.resend-link-btn:hover {
    text-decoration: underline;
}

.password-toggle-group {
    position: relative;
}

.password-toggle-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 16px;
}
</style>

<div class="auth-recovery-wrapper">
    <div class="auth-recovery-card">

        <!-- Visual 3-Step Progress Indicator -->
        <div class="stepper-container">
            <div class="stepper-line">
                <div class="stepper-line-fill" id="stepperLineFill"></div>
            </div>
            <div class="step-node active" id="node1">1</div>
            <div class="step-node" id="node2">2</div>
            <div class="step-node" id="node3">3</div>
        </div>

        <!-- Alert Banner -->
        <div class="alert-toast" id="alertToast">
            <i class="fa fa-info-circle" id="alertIcon"></i>
            <span id="alertMsg"></span>
        </div>

        <!-- STEP 1: Enter Registered Mobile / Email -->
        <div id="step1Container">
            <div class="recovery-header">
                <div class="recovery-icon-circle">
                    <i class="fa fa-user-md"></i>
                </div>
                <h2 class="recovery-title">Doctor Password Recovery</h2>
                <p class="recovery-subtitle">
                    Enter your registered mobile number or email address. We'll send a 6-digit verification code to reset your credentials.
                </p>
            </div>

            <form id="drforgotform" action="<?=base_url('Doctoruser/forgotpass');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="form-group-cstm">
                    <label class="form-label-cstm">Registered Mobile / Email ID *</label>
                    <input type="text" name="mobile" class="form-input-cstm" placeholder="e.g. 9876543210 or doctor@clinic.com" required autofocus>
                </div>

                <button type="submit" class="btn-primary-cstm" id="btnSubmitStep1">
                    <span>Send Verification Code</span> <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <!-- STEP 2: Verify 6-Digit OTP -->
        <div id="step2Container" style="display: none;">
            <div class="recovery-header">
                <div class="recovery-icon-circle" style="background: #e0f2fe; color: #0284c7; border-color: #bae6fd;">
                    <i class="fa fa-shield"></i>
                </div>
                <h2 class="recovery-title">Enter Verification Code</h2>
                <p class="recovery-subtitle">
                    A 6-digit OTP has been sent to your registered contact. Enter it below to proceed.
                </p>
            </div>

            <form id="drforgototpform" action="<?=base_url('Doctoruser/verifyforgototp');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="form-group-cstm" style="text-align: center;">
                    <label class="form-label-cstm" style="text-align: center; margin-bottom: 12px;">6-Digit OTP Code *</label>
                    <input type="text" name="otp" id="otpInput" class="form-input-cstm" placeholder="••••••" maxlength="6" style="text-align: center; font-size: 24px; font-weight: 800; letter-spacing: 6px; height: 52px;" required>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 12.5px;">
                    <span style="color: #64748b;">Didn't receive code?</span>
                    <button type="button" class="resend-link-btn drresendfotp" id="btnResendOtp">
                        <i class="fa fa-refresh"></i> Resend OTP
                    </button>
                </div>

                <button type="submit" class="btn-primary-cstm" id="btnSubmitStep2">
                    <span>Verify Code &amp; Continue</span> <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <!-- STEP 3: Set New Password -->
        <div id="step3Container" style="display: none;">
            <div class="recovery-header">
                <div class="recovery-icon-circle" style="background: #fef3c7; color: #d97706; border-color: #fde68a;">
                    <i class="fa fa-key"></i>
                </div>
                <h2 class="recovery-title">Create New Password</h2>
                <p class="recovery-subtitle">
                    Set a strong new password for your Upchar Doctor Partner account.
                </p>
            </div>

            <form id="drforgotnewpassform" action="<?=base_url('Doctoruser/setnewpass');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="form-group-cstm">
                    <label class="form-label-cstm">New Password *</label>
                    <div class="password-toggle-group">
                        <input type="password" name="pass" id="newPasswordInput" class="form-input-cstm" placeholder="Minimum 6 characters" minlength="6" required>
                        <button type="button" class="password-toggle-btn" onclick="togglePassVisibility('newPasswordInput', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group-cstm">
                    <label class="form-label-cstm">Confirm New Password *</label>
                    <div class="password-toggle-group">
                        <input type="password" id="confirmPasswordInput" class="form-input-cstm" placeholder="Re-type new password" minlength="6" required>
                        <button type="button" class="password-toggle-btn" onclick="togglePassVisibility('confirmPasswordInput', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary-cstm" id="btnSubmitStep3">
                    <i class="fa fa-check-circle"></i> <span>Reset Password &amp; Login</span>
                </button>
            </form>
        </div>

        <!-- Card Footer Links -->
        <div class="auth-footer-links">
            <a href="<?=base_url('doctor-login');?>" class="auth-link">
                <i class="fa fa-arrow-left"></i> Back to Doctor Login
            </a>
            <a href="<?=base_url('contactus');?>" class="auth-link" style="color: #64748b;">
                Need help? Contact support
            </a>
        </div>

    </div>
</div>

<?php $this->load->view('includes/footer.php'); ?>

<script>
function showAlert(msg, isError) {
    var toast = $('#alertToast');
    var icon = $('#alertIcon');
    var msgSpan = $('#alertMsg');
    
    toast.removeClass('error success');
    if (isError) {
        toast.addClass('error');
        icon.attr('class', 'fa fa-exclamation-circle');
    } else {
        toast.addClass('success');
        icon.attr('class', 'fa fa-check-circle');
    }
    
    msgSpan.text(msg);
    toast.css('display', 'flex').hide().fadeIn(250);
}

function updateStepper(step) {
    if (step === 2) {
        $('#stepperLineFill').css('width', '50%');
        $('#node1').removeClass('active').addClass('completed').html('<i class="fa fa-check"></i>');
        $('#node2').addClass('active');
    } else if (step === 3) {
        $('#stepperLineFill').css('width', '100%');
        $('#node2').removeClass('active').addClass('completed').html('<i class="fa fa-check"></i>');
        $('#node3').addClass('active');
    }
}

function togglePassVisibility(inputId, btn) {
    var input = document.getElementById(inputId);
    var icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

$(document).ready(function() {
    // Step 1: Send OTP
    $('#drforgotform').submit(function(e) {
        e.preventDefault();
        var myform = $(this);
        var btn = $('#btnSubmitStep1');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending Code...');

        $.ajax({
            type: "POST",
            url: myform.attr('action'),
            data: myform.serialize(),
            success: function(response) {
                try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}
                if (response && response.status === 'success') {
                    showAlert(response.msg || 'Verification code sent to your mobile/email!', false);
                    $('#step1Container').fadeOut(200, function() {
                        $('#step2Container').fadeIn(200);
                        updateStepper(2);
                        $('#otpInput').focus();
                    });
                } else {
                    showAlert(response && response.msg ? response.msg : 'Invalid mobile number or email address', true);
                    btn.prop('disabled', false).html('<span>Send Verification Code</span> <i class="fa fa-arrow-right"></i>');
                }
            },
            error: function(xhr) {
                var err = 'Connection issue. Please try again.';
                try {
                    var parsed = JSON.parse(xhr.responseText);
                    if (parsed && parsed.msg) err = parsed.msg;
                } catch(e) {}
                showAlert(err, true);
                btn.prop('disabled', false).html('<span>Send Verification Code</span> <i class="fa fa-arrow-right"></i>');
            }
        });
    });

    // Step 2: Verify OTP
    $('#drforgototpform').submit(function(e) {
        e.preventDefault();
        var myform = $(this);
        var btn = $('#btnSubmitStep2');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Verifying...');

        $.ajax({
            type: "POST",
            url: myform.attr('action'),
            data: myform.serialize(),
            success: function(response) {
                try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}
                if (response && response.status === 'success') {
                    showAlert('OTP verified successfully! Set your new password.', false);
                    $('#step2Container').fadeOut(200, function() {
                        $('#step3Container').fadeIn(200);
                        updateStepper(3);
                        $('#newPasswordInput').focus();
                    });
                } else {
                    showAlert(response && response.msg ? response.msg : 'Incorrect OTP code. Please check and try again.', true);
                    btn.prop('disabled', false).html('<span>Verify Code &amp; Continue</span> <i class="fa fa-arrow-right"></i>');
                }
            },
            error: function(xhr) {
                var err = 'Verification failed. Please try again.';
                try {
                    var parsed = JSON.parse(xhr.responseText);
                    if (parsed && parsed.msg) err = parsed.msg;
                } catch(e) {}
                showAlert(err, true);
                btn.prop('disabled', false).html('<span>Verify Code &amp; Continue</span> <i class="fa fa-arrow-right"></i>');
            }
        });
    });

    // Step 3: Set New Password
    $('#drforgotnewpassform').submit(function(e) {
        e.preventDefault();
        var p1 = $('#newPasswordInput').val();
        var p2 = $('#confirmPasswordInput').val();

        if (p1 !== p2) {
            showAlert('Passwords do not match. Please ensure both fields match.', true);
            return;
        }

        var myform = $(this);
        var btn = $('#btnSubmitStep3');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating Password...');

        $.ajax({
            type: "POST",
            url: myform.attr('action'),
            data: myform.serialize(),
            success: function(response) {
                try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}
                if (response && response.status === 'success') {
                    showAlert('Password updated successfully! Redirecting to doctor login...', false);
                    setTimeout(function() {
                        window.location = "<?=base_url('doctor-login');?>";
                    }, 1200);
                } else {
                    showAlert(response && response.msg ? response.msg : 'Failed to update password. Please try again.', true);
                    btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> <span>Reset Password &amp; Login</span>');
                }
            },
            error: function(xhr) {
                var err = 'Password update failed. Please try again.';
                try {
                    var parsed = JSON.parse(xhr.responseText);
                    if (parsed && parsed.msg) err = parsed.msg;
                } catch(e) {}
                showAlert(err, true);
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> <span>Reset Password &amp; Login</span>');
            }
        });
    });

    // Resend OTP handler
    $('.drresendfotp').click(function(e) {
        e.preventDefault();
        var link = $(this);
        link.html('<i class="fa fa-spinner fa-spin"></i> Sending...');

        $.ajax({
            type: "POST",
            url: '<?=base_url("Doctoruser/resendforgetotp");?>',
            data: { '<?=$this->security->get_csrf_token_name();?>': '<?=$this->security->get_csrf_hash();?>' },
            success: function(response) {
                try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}
                if (response && response.status === 'success') {
                    showAlert(response.msg || 'A fresh OTP has been sent to your mobile.', false);
                } else {
                    showAlert(response && response.msg ? response.msg : 'Failed to resend OTP.', true);
                }
                link.html('<i class="fa fa-refresh"></i> Resend OTP');
            },
            error: function() {
                showAlert('Could not resend OTP. Please try again.', true);
                link.html('<i class="fa fa-refresh"></i> Resend OTP');
            }
        });
    });
});
</script>