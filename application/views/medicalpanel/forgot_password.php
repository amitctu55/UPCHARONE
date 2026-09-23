<?php $this->load->view("includes/header.php"); ?>

<!-- Google Fonts & FontAwesome -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
:root {
    --brand-teal: #00a896;
    --brand-teal-dark: #008f80;
    --brand-navy: #08364b;
    --brand-navy-dark: #052433;
    --slate-900: #0f172a;
    --slate-800: #1e293b;
    --slate-700: #334155;
    --slate-600: #475569;
    --slate-400: #94a3b8;
    --slate-200: #e2e8f0;
    --slate-100: #f1f5f9;
    --slate-50: #f8fafc;
    --rose-danger: #ef4444;
    --emerald-success: #10b981;
}

body {
    background-color: #f8fafc !important;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* Page Layout Wrapper */
.recovery-page-wrapper {
    min-height: calc(100vh - 140px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 20px;
    background: radial-gradient(circle at 50% 10%, rgba(0, 168, 150, 0.08) 0%, transparent 60%), #f8fafc;
}

/* Central Recovery Card */
.recovery-card {
    width: 100%;
    max-width: 480px;
    background: #ffffff;
    border: 1px solid var(--slate-200);
    border-radius: 20px;
    box-shadow: 0 12px 35px -8px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.03);
    padding: 36px 32px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.recovery-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--brand-teal) 0%, #38bdf8 100%);
}

/* Header Cluster */
.recovery-header {
    text-align: center;
    margin-bottom: 28px;
}

.brand-icon-wrap {
    width: 58px;
    height: 58px;
    border-radius: 16px;
    background: linear-gradient(135deg, rgba(0, 168, 150, 0.12) 0%, rgba(56, 189, 248, 0.15) 100%);
    border: 1px solid rgba(0, 168, 150, 0.25);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: var(--brand-teal);
    margin-bottom: 16px;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.15);
}

.recovery-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--slate-900);
    margin: 0 0 6px 0;
    letter-spacing: -0.4px;
}

.recovery-subtitle {
    font-size: 13.5px;
    color: var(--slate-600);
    margin: 0;
    line-height: 1.5;
}

/* Stepper Progress Bar */
.stepper-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    position: relative;
    padding: 0 10px;
}

.stepper-track {
    position: absolute;
    top: 14px;
    left: 36px;
    right: 36px;
    height: 2px;
    background: var(--slate-200);
    z-index: 1;
}

.stepper-track-fill {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 0%;
    background: var(--brand-teal);
    transition: width 0.3s ease;
}

.step-node {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}

.step-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #ffffff;
    border: 2px solid var(--slate-200);
    color: var(--slate-400);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    transition: all 0.25s ease;
}

.step-node.active .step-circle {
    border-color: var(--brand-teal);
    background: var(--brand-teal);
    color: #ffffff;
    box-shadow: 0 0 0 4px rgba(0, 168, 150, 0.18);
}

.step-node.completed .step-circle {
    border-color: var(--emerald-success);
    background: var(--emerald-success);
    color: #ffffff;
}

.step-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--slate-400);
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.step-node.active .step-label {
    color: var(--slate-800);
}

/* Form Groups & Inputs */
.recovery-form .form-group {
    margin-bottom: 20px;
}

.recovery-form label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--slate-800);
    margin-bottom: 8px;
}

.input-icon-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon-wrapper .input-icon {
    position: absolute;
    left: 14px;
    color: var(--slate-400);
    font-size: 15px;
    pointer-events: none;
    transition: color 0.2s;
}

.recovery-input {
    width: 100% !important;
    height: 48px !important;
    padding: 10px 16px 10px 42px !important;
    font-size: 14px !important;
    color: var(--slate-900) !important;
    background: #ffffff !important;
    border: 1.5px solid var(--slate-200) !important;
    border-radius: 10px !important;
    outline: none !important;
    box-shadow: none !important;
    transition: all 0.2s ease !important;
}

.recovery-input:focus {
    border-color: var(--brand-teal) !important;
    box-shadow: 0 0 0 4px rgba(0, 168, 150, 0.12) !important;
}

.input-icon-wrapper:focus-within .input-icon {
    color: var(--brand-teal);
}

/* Password Toggle Button */
.btn-toggle-pwd {
    position: absolute;
    right: 12px;
    background: none;
    border: none;
    color: var(--slate-400);
    font-size: 15px;
    cursor: pointer;
    padding: 6px;
    outline: none;
}

.btn-toggle-pwd:hover {
    color: var(--slate-700);
}

/* Action Buttons */
.btn-recovery-primary {
    width: 100%;
    height: 48px;
    background: linear-gradient(135deg, var(--brand-teal) 0%, var(--brand-teal-dark) 100%);
    color: #ffffff;
    font-size: 14.5px;
    font-weight: 700;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);
    transition: all 0.2s ease;
}

.btn-recovery-primary:hover:not(:disabled) {
    background: linear-gradient(135deg, #00b8a4 0%, #008f80 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.4);
}

.btn-recovery-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* OTP Resend Ribbon */
.otp-meta-strip {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 14px;
    font-size: 12.5px;
    color: var(--slate-600);
}

.btn-resend-link {
    color: var(--brand-teal);
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}

.btn-resend-link:hover {
    text-decoration: underline;
}

.btn-resend-link:disabled {
    color: var(--slate-400);
    cursor: not-allowed;
    text-decoration: none;
}

/* Inline Dynamic Message Alert */
.alert-feedback {
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 600;
    display: none;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    animation: fadeIn 0.25s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert-feedback.error {
    display: flex;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}

.alert-feedback.success {
    display: flex;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
}

/* Bottom Footer Links */
.recovery-footer {
    text-align: center;
    margin-top: 26px;
    padding-top: 20px;
    border-top: 1px solid var(--slate-200);
}

.recovery-footer a {
    color: var(--brand-teal);
    font-weight: 700;
    font-size: 13.5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.recovery-footer a:hover {
    color: var(--brand-teal-dark);
    text-decoration: underline;
}

/* Support Help Ribbon */
.support-strip {
    margin-top: 16px;
    font-size: 12px;
    color: var(--slate-400);
    text-align: center;
}

.support-strip i {
    color: var(--brand-teal);
    margin-right: 4px;
}
</style>

<div class="recovery-page-wrapper">
    <div class="recovery-card">
        
        <!-- Header Ribbon -->
        <div class="recovery-header">
            <div class="brand-icon-wrap">
                <i class="fa fa-shield-alt"></i>
            </div>
            <h1 class="recovery-title" id="pageMainHeading">Reset Password</h1>
            <p class="recovery-subtitle" id="pageSubHeading">
                Provide your registered mobile number or email ID to receive a secure recovery code.
            </p>
        </div>

        <!-- 3-Step Interactive Progress Stepper -->
        <div class="stepper-bar">
            <div class="stepper-track">
                <div class="stepper-track-fill" id="stepperFill"></div>
            </div>
            <div class="step-node active" id="stepNode1">
                <div class="step-circle">1</div>
                <span class="step-label">Account</span>
            </div>
            <div class="step-node" id="stepNode2">
                <div class="step-circle">2</div>
                <span class="step-label">Verify</span>
            </div>
            <div class="step-node" id="stepNode3">
                <div class="step-circle">3</div>
                <span class="step-label">Password</span>
            </div>
        </div>

        <!-- Inline Status & Feedback Toast -->
        <div class="alert-feedback" id="statusAlertBox">
            <i class="fa fa-circle-exclamation" id="alertIcon"></i>
            <span id="alertMessageText">Something went wrong</span>
        </div>

        <!-- =============================================================
             STEP 1: REQUEST OTP (EMAIL / MOBILE)
             ============================================================= -->
        <form id="drforgotform" action="<?=base_url();?>Medicaluser/forgotpass" method="POST" class="recovery-form">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
            
            <div class="form-group">
                <label for="recovery_identifier">Registered Mobile or Email <span style="color:var(--rose-danger);">*</span></label>
                <div class="input-icon-wrapper">
                    <i class="fa fa-user-circle input-icon"></i>
                    <input type="text" id="recovery_identifier" name="mobile" class="recovery-input" placeholder="e.g. 9876543210 or pharmacy@upchar.com" required autocomplete="username">
                </div>
            </div>

            <button type="submit" class="btn-recovery-primary" id="btnSubmitStep1">
                <span>Send Verification OTP</span>
                <i class="fa fa-arrow-right"></i>
            </button>
        </form>

        <!-- =============================================================
             STEP 2: VERIFY 6-DIGIT OTP
             ============================================================= -->
        <form id="drforgototpform" action="<?=base_url();?>Medicaluser/verifyforgototp" method="POST" class="recovery-form" style="display: none;">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
            
            <div class="form-group">
                <label for="recovery_otp">Enter 6-Digit OTP <span style="color:var(--rose-danger);">*</span></label>
                <div class="input-icon-wrapper">
                    <i class="fa fa-key input-icon"></i>
                    <input type="text" id="recovery_otp" name="otp" class="recovery-input" placeholder="Enter 6-digit OTP code" maxlength="6" pattern="[0-9]{6}" required autocomplete="one-time-code" style="letter-spacing: 4px; font-weight: 700; font-size: 16px;">
                </div>
            </div>

            <button type="submit" class="btn-recovery-primary" id="btnSubmitStep2">
                <span>Verify &amp; Proceed</span>
                <i class="fa fa-check-circle"></i>
            </button>

            <div class="otp-meta-strip">
                <span id="countdownTimerText"><i class="fa fa-clock-o"></i> Resend code in <strong id="secondsLeft">30</strong>s</span>
                <button type="button" class="btn-resend-link drresendfotp" id="btnResendOtp" disabled>
                    <i class="fa fa-refresh"></i> Resend OTP
                </button>
            </div>
        </form>

        <!-- =============================================================
             STEP 3: SET NEW SECURE PASSWORD
             ============================================================= -->
        <form id="drforgotnewpassform" action="<?=base_url();?>Medicaluser/setnewpass" method="POST" class="recovery-form" style="display: none;">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
            
            <div class="form-group">
                <label for="recovery_pass">Create New Password <span style="color:var(--rose-danger);">*</span></label>
                <div class="input-icon-wrapper">
                    <i class="fa fa-lock input-icon"></i>
                    <input type="password" id="recovery_pass" name="pass" class="recovery-input" placeholder="Minimum 6 characters" minlength="6" required autocomplete="new-password">
                    <button type="button" class="btn-toggle-pwd" onclick="togglePassVisibility('recovery_pass', 'iconToggle1')">
                        <i class="fa fa-eye" id="iconToggle1"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="recovery_cpass">Confirm New Password <span style="color:var(--rose-danger);">*</span></label>
                <div class="input-icon-wrapper">
                    <i class="fa fa-lock input-icon"></i>
                    <input type="password" id="recovery_cpass" class="recovery-input" placeholder="Repeat your new password" minlength="6" required autocomplete="new-password">
                    <button type="button" class="btn-toggle-pwd" onclick="togglePassVisibility('recovery_cpass', 'iconToggle2')">
                        <i class="fa fa-eye" id="iconToggle2"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-recovery-primary" id="btnSubmitStep3">
                <span>Update Password &amp; Login</span>
                <i class="fa fa-shield-check"></i>
            </button>
        </form>

        <!-- Footer Back to Login -->
        <div class="recovery-footer">
            <a href="<?=base_url('medical-login');?>">
                <i class="fa fa-arrow-left"></i>
                <span>Remember your password? <strong>Back to Login</strong></span>
            </a>
        </div>

        <div class="support-strip">
            <i class="fa fa-headset"></i> Need help? Upchar Partner Desk: <strong>1800-123-4567</strong>
        </div>

    </div>
</div>

<?php $this->load->view('includes/footer.php'); ?>

<script>
let timerInterval = null;
let resendSeconds = 30;

function showAlert(msg, isSuccess = false) {
    const box = document.getElementById('statusAlertBox');
    const icon = document.getElementById('alertIcon');
    const text = document.getElementById('alertMessageText');

    box.className = 'alert-feedback ' + (isSuccess ? 'success' : 'error');
    icon.className = isSuccess ? 'fa fa-check-circle' : 'fa fa-exclamation-circle';
    text.textContent = msg;
    box.style.display = 'flex';
}

function hideAlert() {
    document.getElementById('statusAlertBox').style.display = 'none';
}

function setStep(stepNumber) {
    hideAlert();
    const fill = document.getElementById('stepperFill');
    const node1 = document.getElementById('stepNode1');
    const node2 = document.getElementById('stepNode2');
    const node3 = document.getElementById('stepNode3');

    const heading = document.getElementById('pageMainHeading');
    const subheading = document.getElementById('pageSubHeading');

    if (stepNumber === 1) {
        fill.style.width = '0%';
        node1.className = 'step-node active';
        node2.className = 'step-node';
        node3.className = 'step-node';
        heading.textContent = 'Reset Password';
        subheading.textContent = 'Provide your registered mobile number or email ID to receive a secure recovery code.';
        $('#drforgotform').show();
        $('#drforgototpform').hide();
        $('#drforgotnewpassform').hide();
    } else if (stepNumber === 2) {
        fill.style.width = '50%';
        node1.className = 'step-node completed';
        node2.className = 'step-node active';
        node3.className = 'step-node';
        heading.textContent = 'Verify Security Code';
        subheading.textContent = 'We sent a 6-digit OTP code to your registered details. Please enter it below.';
        $('#drforgotform').hide();
        $('#drforgototpform').fadeIn(200);
        $('#drforgotnewpassform').hide();
        $('#recovery_otp').focus();
        startResendTimer();
    } else if (stepNumber === 3) {
        fill.style.width = '100%';
        node1.className = 'step-node completed';
        node2.className = 'step-node completed';
        node3.className = 'step-node active';
        heading.textContent = 'Set New Password';
        subheading.textContent = 'Create a secure new password for your UPCHAR Pharmacy account.';
        $('#drforgotform').hide();
        $('#drforgototpform').hide();
        $('#drforgotnewpassform').fadeIn(200);
        $('#recovery_pass').focus();
    }
}

function startResendTimer() {
    clearInterval(timerInterval);
    resendSeconds = 30;
    const btnResend = document.getElementById('btnResendOtp');
    const timerText = document.getElementById('countdownTimerText');
    const secLabel = document.getElementById('secondsLeft');

    btnResend.disabled = true;
    timerText.style.display = 'inline';

    timerInterval = setInterval(() => {
        resendSeconds--;
        secLabel.textContent = resendSeconds;
        if (resendSeconds <= 0) {
            clearInterval(timerInterval);
            btnResend.disabled = false;
            timerText.style.display = 'none';
        }
    }, 1000);
}

function togglePassVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
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

    // Step 1: Submit Mobile/Email
    $('#drforgotform').submit(function(e) {
        e.preventDefault();
        hideAlert();
        const form = $(this);
        const btn = $('#btnSubmitStep1');
        const originalText = btn.html();

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending OTP...');

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                btn.prop('disabled', false).html(originalText);
                try {
                    response = typeof response === 'object' ? response : JSON.parse(response);
                } catch(e) {}

                if (response.status === 'success') {
                    showAlert('OTP Sent Successfully to registered mobile and email.', true);
                    setTimeout(() => {
                        setStep(2);
                    }, 500);
                } else if (response.status === 'invalid') {
                    showAlert(response.msg || 'No pharmacy account found with this Mobile/Email.');
                } else {
                    showAlert(response.msg || 'Unable to send recovery code. Please retry.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html(originalText);
                showAlert('Network error. Please check your connection and retry.');
            }
        });
    });

    // Step 2: Verify OTP
    $('#drforgototpform').submit(function(e) {
        e.preventDefault();
        hideAlert();
        const form = $(this);
        const btn = $('#btnSubmitStep2');
        const originalText = btn.html();

        const otpVal = $('#recovery_otp').val().trim();
        if (otpVal.length !== 6) {
            showAlert('Please enter the complete 6-digit OTP code.');
            return;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Verifying...');

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                btn.prop('disabled', false).html(originalText);
                try {
                    response = typeof response === 'object' ? response : JSON.parse(response);
                } catch(e) {}

                if (response.status === 'success') {
                    showAlert('Security code verified successfully!', true);
                    clearInterval(timerInterval);
                    setTimeout(() => {
                        setStep(3);
                    }, 500);
                } else {
                    showAlert(response.msg || 'Incorrect OTP code. Please check and try again.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html(originalText);
                showAlert('Verification failed due to a network error.');
            }
        });
    });

    // Resend OTP Trigger
    $('.drresendfotp').click(function(e) {
        e.preventDefault();
        const btn = $(this);
        if (btn.is(':disabled')) return;

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Resending...');

        $.ajax({
            type: "POST",
            url: '<?=base_url();?>Medicaluser/resendforgetotp',
            data: {
                '<?=$this->security->get_csrf_token_name();?>': '<?=$this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                try {
                    response = typeof response === 'object' ? response : JSON.parse(response);
                } catch(e) {}

                if (response.status === 'success') {
                    showAlert('A fresh OTP code has been dispatched.', true);
                    startResendTimer();
                } else {
                    showAlert(response.msg || 'Could not resend OTP at this moment.');
                    btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Resend OTP');
                }
            },
            error: function() {
                showAlert('Failed to contact server for OTP resend.');
                btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Resend OTP');
            }
        });
    });

    // Step 3: Set New Password
    $('#drforgotnewpassform').submit(function(e) {
        e.preventDefault();
        hideAlert();
        const pwd = $('#recovery_pass').val();
        const cpwd = $('#recovery_cpass').val();

        if (pwd.length < 6) {
            showAlert('Password must be at least 6 characters in length.');
            return;
        }

        if (pwd !== cpwd) {
            showAlert('Passwords do not match. Please verify both fields.');
            return;
        }

        const form = $(this);
        const btn = $('#btnSubmitStep3');
        const originalText = btn.html();

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating Password...');

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                btn.prop('disabled', false).html(originalText);
                try {
                    response = typeof response === 'object' ? response : JSON.parse(response);
                } catch(e) {}

                if (response.status === 'success') {
                    showAlert('Password reset successfully! Redirecting to login...', true);
                    setTimeout(function() {
                        window.location = "<?=base_url();?>medical-login";
                    }, 1200);
                } else {
                    showAlert(response.msg || 'Password update failed. Please try again.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html(originalText);
                showAlert('Unable to update password. Please retry.');
            }
        });
    });

});
</script>