<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include ("includes/header.php"); ?>

<style>
:root {
    --upchar-teal: #0d7a6e;
    --upchar-teal-hover: #095950;
    --upchar-teal-light: #f0fdfa;
    --upchar-teal-border: #ccfbf1;
    --upchar-navy: #043d5b;
    --upchar-text: #0f172a;
    --upchar-muted: #64748b;
    --upchar-border: #e2e8f0;
    --upchar-bg: #f8fafc;
    --radius-lg: 16px;
    --radius-md: 10px;
}

.auth-recovery-page {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 15px 80px;
    background: linear-gradient(135deg, #f8fafc 0%, #f0fdfa 50%, #f1f5f9 100%);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.auth-recovery-card {
    background: #ffffff;
    width: 100%;
    max-width: 490px;
    border-radius: var(--radius-lg);
    box-shadow: 0 10px 35px -5px rgba(13, 122, 110, 0.08), 0 4px 12px -2px rgba(0, 0, 0, 0.04);
    border: 1px solid var(--upchar-border);
    padding: 38px 32px;
    position: relative;
    overflow: hidden;
    margin: 0 auto;
}

.auth-recovery-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #0d7a6e 0%, #14b8a6 50%, #043d5b 100%);
}

/* Stepper */
.recovery-stepper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    margin-bottom: 30px;
    padding: 0 10px;
}

.stepper-progress-track {
    position: absolute;
    top: 17px;
    left: 45px;
    right: 45px;
    height: 3px;
    background: #e2e8f0;
    z-index: 1;
}

.stepper-progress-fill {
    height: 100%;
    width: 0%;
    background: var(--upchar-teal);
    transition: width 0.4s ease;
}

.stepper-node {
    position: relative;
    z-index: 2;
    background: #ffffff;
    width: 36px;
    height: 36px;
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

.stepper-node.active {
    border-color: var(--upchar-teal);
    background: var(--upchar-teal);
    color: #ffffff;
    box-shadow: 0 0 0 5px rgba(13, 122, 110, 0.15);
}

.stepper-node.completed {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
    color: var(--upchar-teal);
}

/* Card Header */
.recovery-header {
    text-align: center;
    margin-bottom: 24px;
}

.recovery-icon-badge {
    width: 54px;
    height: 54px;
    background: #f0fdfa;
    color: var(--upchar-teal);
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 14px;
    border: 1px solid var(--upchar-teal-border);
}

.recovery-header h2 {
    font-size: 22px;
    font-weight: 800;
    color: var(--upchar-text);
    margin: 0 0 6px 0;
    letter-spacing: -0.3px;
}

.recovery-header p {
    color: var(--upchar-muted);
    font-size: 13.5px;
    line-height: 1.45;
    margin: 0;
}

/* Alert Notification Banner */
.recovery-alert {
    display: none;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 20px;
    align-items: flex-start;
    gap: 10px;
    line-height: 1.4;
}

.recovery-alert.show {
    display: flex;
}

.recovery-alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}

.recovery-alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
}

.recovery-alert-warning {
    background: #fefce8;
    border: 1px solid #fef08a;
    color: #854d0e;
}

/* Form Styles */
.recovery-form-group {
    margin-bottom: 20px;
}

.recovery-label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: #334155;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 7px;
}

.input-icon-wrap {
    position: relative;
}

.input-icon-wrap i.input-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 16px;
    transition: color 0.2s;
}

.input-icon-wrap input {
    width: 100%;
    height: 48px;
    padding: 10px 42px 10px 42px;
    border: 1.5px solid #cbd5e1;
    border-radius: var(--radius-md);
    font-size: 14.5px;
    color: var(--upchar-text);
    background: #ffffff;
    transition: all 0.2s ease;
    font-family: inherit;
}

.input-icon-wrap input:focus {
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 4px rgba(13, 122, 110, 0.12);
}

.input-icon-wrap input:focus + i.input-icon {
    color: var(--upchar-teal);
}

.input-icon-wrap .toggle-pwd-btn {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 15px;
    padding: 0;
}

.input-icon-wrap .toggle-pwd-btn:hover {
    color: #334155;
}

/* OTP Boxes */
.otp-boxes-wrapper {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 20px;
}

.otp-box-item {
    width: 48px;
    height: 52px;
    text-align: center;
    font-size: 22px;
    font-weight: 800;
    color: var(--upchar-text);
    border: 1.5px solid #cbd5e1;
    border-radius: var(--radius-md);
    background: #ffffff;
    transition: all 0.2s;
}

.otp-box-item:focus {
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 4px rgba(13, 122, 110, 0.15);
    background: #f0fdfa;
}

/* Resend Countdown */
.resend-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    font-size: 13px;
}

.resend-box .timer-text {
    color: var(--upchar-muted);
}

.resend-box .btn-resend-link {
    color: var(--upchar-teal);
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    display: none;
}

.resend-box .btn-resend-link:hover {
    text-decoration: underline;
}

/* Password Strength Meter */
.pwd-strength-container {
    margin-top: 8px;
    margin-bottom: 16px;
}

.pwd-strength-track {
    height: 4px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
    display: flex;
    gap: 4px;
}

.pwd-strength-bar {
    height: 100%;
    flex: 1;
    background: #e2e8f0;
    border-radius: 4px;
    transition: background 0.3s;
}

.pwd-strength-label {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: var(--upchar-muted);
    margin-top: 4px;
    font-weight: 600;
}

/* Submit Buttons */
.btn-recovery-submit {
    width: 100%;
    height: 48px;
    background: linear-gradient(135deg, #0d7a6e 0%, #085a51 100%);
    color: #ffffff;
    border: none;
    border-radius: var(--radius-md);
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(13, 122, 110, 0.28);
    transition: all 0.2s;
}

.btn-recovery-submit:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(13, 122, 110, 0.35);
}

.btn-recovery-submit:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

/* Footer Links */
.recovery-card-footer {
    text-align: center;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid #f1f5f9;
    font-size: 13.5px;
    color: var(--upchar-muted);
}

.recovery-card-footer a {
    color: var(--upchar-teal);
    font-weight: 700;
    text-decoration: none;
    transition: color 0.2s;
}

.recovery-card-footer a:hover {
    text-decoration: underline;
    color: var(--upchar-teal-hover);
}

/* Success Celebration View */
.success-recovery-view {
    text-align: center;
    padding: 10px 0;
}

.success-check-pulse {
    width: 76px;
    height: 76px;
    background: #dcfce7;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #16a34a;
    font-size: 34px;
    margin-bottom: 20px;
    box-shadow: 0 0 0 10px #f0fdf4;
    animation: scaleIn 0.4s ease;
}

@keyframes scaleIn {
    0% { transform: scale(0.6); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>

<div class="auth-recovery-page">
    <div class="auth-recovery-card">

        <!-- 3-Step Visual Progress Stepper -->
        <div class="recovery-stepper" id="recoveryStepper">
            <div class="stepper-progress-track">
                <div class="stepper-progress-fill" id="stepperFill"></div>
            </div>
            <div class="stepper-node active" id="node1" title="Account Details">1</div>
            <div class="stepper-node" id="node2" title="Verify OTP">2</div>
            <div class="stepper-node" id="node3" title="New Password">3</div>
        </div>

        <!-- Inline Alert Notification -->
        <div class="recovery-alert" id="recoveryAlert">
            <i class="fa fa-exclamation-circle" id="alertIcon" style="margin-top: 2px;"></i>
            <span id="alertMsg">Notice message</span>
        </div>

        <!-- ============================================== -->
        <!-- STEP 1: ACCOUNT IDENTIFIER (Mobile or Email)  -->
        <!-- ============================================== -->
        <div id="stepSection1">
            <div class="recovery-header">
                <div class="recovery-icon-badge">
                    <i class="fa fa-unlock-alt"></i>
                </div>
                <h2>Forgot Password?</h2>
                <p>Enter your registered mobile number or email address to receive an instant verification code.</p>
            </div>

            <form id="formStep1" onsubmit="handleSendOtp(event)">
                <div class="recovery-form-group">
                    <label class="recovery-label" for="inputIdentifier">Registered Mobile / Email</label>
                    <div class="input-icon-wrap">
                        <input type="text" id="inputIdentifier" name="mobile" placeholder="e.g. 9876543210 or name@example.com" autocomplete="username" required autofocus>
                        <i class="fa fa-user-circle input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn-recovery-submit" id="btnSubmitStep1">
                    <span>Send Verification Code</span>
                    <i class="fa fa-arrow-right"></i>
                </button>
            </form>

            <div class="recovery-card-footer">
                Remember your password? <a href="<?=base_url('login');?>"><i class="fa fa-sign-in"></i> Back to Login</a>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- STEP 2: VERIFY 6-DIGIT OTP                     -->
        <!-- ============================================== -->
        <div id="stepSection2" style="display: none;">
            <div class="recovery-header">
                <div class="recovery-icon-badge">
                    <i class="fa fa-shield"></i>
                </div>
                <h2>Verify Security Code</h2>
                <p>We've sent a 6-digit verification code to <strong id="lblContactTarget" style="color: var(--upchar-text);">your contact</strong>. 
                <a href="#" onclick="backToStep1(event)" style="color: var(--upchar-teal); font-weight: 600; text-decoration: underline; font-size: 12px; margin-left: 4px;">Edit</a></p>
            </div>

            <form id="formStep2" onsubmit="handleVerifyOtp(event)">
                <input type="hidden" id="fullOtpValue" name="otp">

                <div class="recovery-form-group">
                    <label class="recovery-label" style="text-align: center; margin-bottom: 12px;">Enter 6-Digit OTP</label>
                    <div class="otp-boxes-wrapper" id="otpBoxes">
                        <input type="text" class="otp-box-item" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="off" required>
                        <input type="text" class="otp-box-item" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="off" required>
                        <input type="text" class="otp-box-item" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="off" required>
                        <input type="text" class="otp-box-item" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="off" required>
                        <input type="text" class="otp-box-item" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="off" required>
                        <input type="text" class="otp-box-item" maxlength="1" inputmode="numeric" pattern="[0-9]*" autocomplete="off" required>
                    </div>
                </div>

                <div class="resend-box">
                    <span class="timer-text" id="timerNotice">
                        <i class="fa fa-clock-o"></i> Resend code in <strong id="resendCountdown">00:59</strong>
                    </span>
                    <a href="#" class="btn-resend-link" id="linkResendOtp" onclick="handleResendOtp(event)">
                        <i class="fa fa-refresh"></i> Resend OTP Code
                    </a>
                </div>

                <button type="submit" class="btn-recovery-submit" id="btnSubmitStep2">
                    <span>Verify Code &amp; Continue</span>
                    <i class="fa fa-arrow-right"></i>
                </button>
            </form>

            <div class="recovery-card-footer">
                Didn't receive code? Check spam or <a href="#" onclick="handleResendOtp(event)">tap to resend</a>.
            </div>
        </div>

        <!-- ============================================== -->
        <!-- STEP 3: CREATE NEW PASSWORD                    -->
        <!-- ============================================== -->
        <div id="stepSection3" style="display: none;">
            <div class="recovery-header">
                <div class="recovery-icon-badge">
                    <i class="fa fa-key"></i>
                </div>
                <h2>Create New Password</h2>
                <p>Choose a strong, secure password for your UPCHAR account.</p>
            </div>

            <form id="formStep3" onsubmit="handleSetNewPassword(event)">
                <div class="recovery-form-group">
                    <label class="recovery-label" for="inputNewPass">New Password</label>
                    <div class="input-icon-wrap">
                        <input type="password" id="inputNewPass" name="pass" placeholder="Create new password (min. 8 chars)" required oninput="checkPasswordStrength(this.value)">
                        <i class="fa fa-lock input-icon"></i>
                        <button type="button" class="toggle-pwd-btn" onclick="togglePasswordVisibility('inputNewPass', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>

                    <!-- Strength Indicator -->
                    <div class="pwd-strength-container">
                        <div class="pwd-strength-track">
                            <div class="pwd-strength-bar" id="strBar1"></div>
                            <div class="pwd-strength-bar" id="strBar2"></div>
                            <div class="pwd-strength-bar" id="strBar3"></div>
                            <div class="pwd-strength-bar" id="strBar4"></div>
                        </div>
                        <div class="pwd-strength-label">
                            <span>Password Strength:</span>
                            <span id="strengthText" style="color: #94a3b8;">Too Short</span>
                        </div>
                    </div>
                </div>

                <div class="recovery-form-group">
                    <label class="recovery-label" for="inputConfirmPass">Confirm New Password</label>
                    <div class="input-icon-wrap">
                        <input type="password" id="inputConfirmPass" placeholder="Re-enter your new password" required oninput="checkPasswordMatch()">
                        <i class="fa fa-check-circle input-icon" id="confirmIcon"></i>
                        <button type="button" class="toggle-pwd-btn" onclick="togglePasswordVisibility('inputConfirmPass', this)">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                    <div id="matchNotice" style="font-size: 11.5px; margin-top: 4px; font-weight: 600; display: none;"></div>
                </div>

                <button type="submit" class="btn-recovery-submit" id="btnSubmitStep3">
                    <span>Update Password &amp; Login</span>
                    <i class="fa fa-check"></i>
                </button>
            </form>

            <div class="recovery-card-footer">
                Back to <a href="<?=base_url('login');?>"><i class="fa fa-sign-in"></i> Sign In</a>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- STEP 4: SUCCESS CONFIRMATION                   -->
        <!-- ============================================== -->
        <div id="stepSection4" style="display: none;">
            <div class="success-recovery-view">
                <div class="success-check-pulse">
                    <i class="fa fa-check"></i>
                </div>
                <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0;">Password Reset Complete!</h2>
                <p style="color: #64748b; font-size: 14px; margin: 0 0 24px 0; line-height: 1.5;">
                    Your UPCHAR account password has been updated securely. You can now log into your account.
                </p>

                <a href="<?=base_url('login');?>" class="btn-recovery-submit" style="text-decoration: none !important;">
                    <span>Continue to Login Now</span>
                    <i class="fa fa-arrow-right"></i>
                </a>

                <p style="font-size: 12px; color: #94a3b8; margin-top: 16px;">
                    Redirecting automatically in <span id="redirectSecs">3</span>s...
                </p>
            </div>
        </div>

    </div>
</div>

<script>
let currentStep = 1;
let resendTimerInterval = null;
let resendSeconds = 60;
let userTargetContact = '';

function showAlert(msg, type = 'error') {
    const alertBox = document.getElementById('recoveryAlert');
    const msgEl    = document.getElementById('alertMsg');
    const iconEl   = document.getElementById('alertIcon');

    alertBox.className = 'recovery-alert show recovery-alert-' + type;
    msgEl.innerHTML    = msg;

    if (type === 'error') {
        iconEl.className = 'fa fa-exclamation-circle';
    } else if (type === 'success') {
        iconEl.className = 'fa fa-check-circle';
    } else {
        iconEl.className = 'fa fa-info-circle';
    }

    alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function hideAlert() {
    const alertBox = document.getElementById('recoveryAlert');
    alertBox.className = 'recovery-alert';
}

function updateStepper(step) {
    currentStep = step;
    const fill  = document.getElementById('stepperFill');
    const n1    = document.getElementById('node1');
    const n2    = document.getElementById('node2');
    const n3    = document.getElementById('node3');

    // Reset nodes
    [n1, n2, n3].forEach(n => n.className = 'stepper-node');

    if (step === 1) {
        fill.style.width = '0%';
        n1.className = 'stepper-node active';
    } else if (step === 2) {
        fill.style.width = '50%';
        n1.className = 'stepper-node completed';
        n1.innerHTML = '<i class="fa fa-check"></i>';
        n2.className = 'stepper-node active';
    } else if (step >= 3) {
        fill.style.width = '100%';
        n1.className = 'stepper-node completed';
        n1.innerHTML = '<i class="fa fa-check"></i>';
        n2.className = 'stepper-node completed';
        n2.innerHTML = '<i class="fa fa-check"></i>';
        n3.className = 'stepper-node active';
    }
}

// ----------------------------------------------------
// STEP 1: SEND OTP
// ----------------------------------------------------
function handleSendOtp(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    hideAlert();

    const input = document.getElementById('inputIdentifier');
    const val   = input.value.trim();

    if (!val) {
        showAlert('Please enter your registered mobile number or email.', 'error');
        return;
    }

    userTargetContact = val;
    const btn = document.getElementById('btnSubmitStep1');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <span>Sending Code...</span>';

    const formData = new FormData();
    formData.append('mobile', val);

    fetch('<?=base_url("User/forgotpass");?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<span>Send Verification Code</span> <i class="fa fa-arrow-right"></i>';

        if (data.status === 'success') {
            document.getElementById('lblContactTarget').innerText = val;
            showAlert(data.msg || 'Verification code sent successfully!', 'success');

            // Switch to Step 2
            document.getElementById('stepSection1').style.display = 'none';
            document.getElementById('stepSection2').style.display = 'block';
            updateStepper(2);
            startResendTimer();
            initOtpBoxes();
        } else {
            showAlert(data.msg || 'Invalid mobile number or email. Please check and try again.', 'error');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<span>Send Verification Code</span> <i class="fa fa-arrow-right"></i>';
        showAlert('Unable to reach verification server. Please try again.', 'error');
    });
}

function backToStep1(e) {
    if (e) e.preventDefault();
    hideAlert();
    clearInterval(resendTimerInterval);
    document.getElementById('stepSection2').style.display = 'none';
    document.getElementById('stepSection3').style.display = 'none';
    document.getElementById('stepSection1').style.display = 'block';
    updateStepper(1);
}

// ----------------------------------------------------
// STEP 2: OTP BOXES & RESEND TIMER
// ----------------------------------------------------
function initOtpBoxes() {
    const boxes = document.querySelectorAll('.otp-box-item');
    boxes.forEach((box, index) => {
        box.value = '';
        box.onkeydown = function(e) {
            if (e.key === 'Backspace' && !box.value && index > 0) {
                boxes[index - 1].focus();
            }
        };
        box.oninput = function() {
            box.value = box.value.replace(/[^0-9]/g, '');
            if (box.value.length >= 1) {
                if (index < boxes.length - 1) {
                    boxes[index + 1].focus();
                }
            }
            syncFullOtp();
        };
        box.onpaste = function(e) {
            e.preventDefault();
            const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
            const cleanDigits = pasteData.replace(/[^0-9]/g, '').slice(0, 6);
            for (let i = 0; i < cleanDigits.length; i++) {
                if (boxes[i]) boxes[i].value = cleanDigits[i];
            }
            if (boxes[cleanDigits.length - 1]) {
                boxes[Math.min(cleanDigits.length, boxes.length - 1)].focus();
            }
            syncFullOtp();
        };
    });

    if (boxes[0]) {
        setTimeout(() => boxes[0].focus(), 200);
    }
}

function syncFullOtp() {
    const boxes = document.querySelectorAll('.otp-box-item');
    let otp = '';
    boxes.forEach(b => otp += b.value);
    document.getElementById('fullOtpValue').value = otp;
}

function startResendTimer() {
    clearInterval(resendTimerInterval);
    resendSeconds = 60;
    const timerEl  = document.getElementById('resendCountdown');
    const noticeEl = document.getElementById('timerNotice');
    const linkEl   = document.getElementById('linkResendOtp');

    noticeEl.style.display = 'inline';
    linkEl.style.display   = 'none';

    resendTimerInterval = setInterval(() => {
        resendSeconds--;
        const mins = Math.floor(resendSeconds / 60);
        const secs = resendSeconds % 60;
        timerEl.innerText = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;

        if (resendSeconds <= 0) {
            clearInterval(resendTimerInterval);
            noticeEl.style.display = 'none';
            linkEl.style.display   = 'inline';
        }
    }, 1000);
}

function handleResendOtp(e) {
    if (e) e.preventDefault();
    hideAlert();

    const link = document.getElementById('linkResendOtp');
    link.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Resending...';

    fetch('<?=base_url("User/resendforgetotp");?>', { method: 'POST' })
    .then(res => res.json())
    .then(data => {
        link.innerHTML = '<i class="fa fa-refresh"></i> Resend OTP Code';
        if (data.status === 'success') {
            showAlert('A fresh verification OTP has been dispatched to your contact.', 'success');
            startResendTimer();
            initOtpBoxes();
        } else {
            showAlert(data.msg || 'Unable to resend OTP at this time.', 'error');
        }
    })
    .catch(err => {
        link.innerHTML = '<i class="fa fa-refresh"></i> Resend OTP Code';
        showAlert('Network error while resending OTP.', 'error');
    });
}

function handleVerifyOtp(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    hideAlert();
    syncFullOtp();

    const otp = document.getElementById('fullOtpValue').value.trim();
    if (otp.length < 6) {
        showAlert('Please enter the full 6-digit verification code.', 'error');
        return;
    }

    const btn = document.getElementById('btnSubmitStep2');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <span>Verifying Code...</span>';

    const formData = new FormData();
    formData.append('otp', otp);

    fetch('<?=base_url("User/verifyforgototp");?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<span>Verify Code &amp; Continue</span> <i class="fa fa-arrow-right"></i>';

        if (data.status === 'success') {
            showAlert('OTP verified successfully! Now set your new password.', 'success');
            clearInterval(resendTimerInterval);

            // Switch to Step 3
            document.getElementById('stepSection2').style.display = 'none';
            document.getElementById('stepSection3').style.display = 'block';
            updateStepper(3);
            document.getElementById('inputNewPass').focus();
        } else {
            showAlert(data.msg || 'Incorrect OTP code. Please verify and try again.', 'error');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<span>Verify Code &amp; Continue</span> <i class="fa fa-arrow-right"></i>';
        showAlert('Verification failed. Please try again.', 'error');
    });
}

// ----------------------------------------------------
// STEP 3: PASSWORD STRENGTH & MATCH
// ----------------------------------------------------
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa fa-eye';
    }
}

function checkPasswordStrength(pass) {
    let score = 0;
    if (pass.length >= 6) score++;
    if (pass.length >= 8) score++;
    if (/[0-9]/.test(pass)) score++;
    if (/[A-Z]/.test(pass) || /[^A-Za-z0-9]/.test(pass)) score++;

    const b1 = document.getElementById('strBar1');
    const b2 = document.getElementById('strBar2');
    const b3 = document.getElementById('strBar3');
    const b4 = document.getElementById('strBar4');
    const lbl = document.getElementById('strengthText');

    [b1, b2, b3, b4].forEach(b => b.style.background = '#e2e8f0');

    if (!pass) {
        lbl.innerText = 'Too Short';
        lbl.style.color = '#94a3b8';
    } else if (score === 1) {
        b1.style.background = '#ef4444';
        lbl.innerText = 'Weak';
        lbl.style.color = '#ef4444';
    } else if (score === 2) {
        b1.style.background = '#f59e0b';
        b2.style.background = '#f59e0b';
        lbl.innerText = 'Fair';
        lbl.style.color = '#f59e0b';
    } else if (score === 3) {
        b1.style.background = '#10b981';
        b2.style.background = '#10b981';
        b3.style.background = '#10b981';
        lbl.innerText = 'Good';
        lbl.style.color = '#10b981';
    } else if (score === 4) {
        b1.style.background = '#0d7a6e';
        b2.style.background = '#0d7a6e';
        b3.style.background = '#0d7a6e';
        b4.style.background = '#0d7a6e';
        lbl.innerText = 'Strong & Secure';
        lbl.style.color = '#0d7a6e';
    }

    checkPasswordMatch();
}

function checkPasswordMatch() {
    const p1 = document.getElementById('inputNewPass').value;
    const p2 = document.getElementById('inputConfirmPass').value;
    const notice = document.getElementById('matchNotice');
    const icon = document.getElementById('confirmIcon');

    if (!p2) {
        notice.style.display = 'none';
        icon.style.color = '#94a3b8';
        return;
    }

    notice.style.display = 'block';
    if (p1 === p2) {
        notice.innerText = 'Passwords match';
        notice.style.color = '#16a34a';
        icon.style.color = '#16a34a';
    } else {
        notice.innerText = 'Passwords do not match';
        notice.style.color = '#dc2626';
        icon.style.color = '#dc2626';
    }
}

function handleSetNewPassword(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    hideAlert();

    const p1 = document.getElementById('inputNewPass').value;
    const p2 = document.getElementById('inputConfirmPass').value;

    if (p1.length < 6) {
        showAlert('Password must be at least 6 characters long.', 'error');
        return;
    }

    if (p1 !== p2) {
        showAlert('Passwords do not match. Please ensure both fields are identical.', 'error');
        return;
    }

    const btn = document.getElementById('btnSubmitStep3');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> <span>Updating Password...</span>';

    const formData = new FormData();
    formData.append('pass', p1);

    fetch('<?=base_url("User/setnewpass");?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<span>Update Password &amp; Login</span> <i class="fa fa-check"></i>';

        if (data.status === 'success') {
            document.getElementById('stepSection3').style.display = 'none';
            document.getElementById('recoveryStepper').style.display = 'none';
            document.getElementById('stepSection4').style.display = 'block';

            let secs = 3;
            const rEl = document.getElementById('redirectSecs');
            const redirInterval = setInterval(() => {
                secs--;
                if (rEl) rEl.innerText = secs;
                if (secs <= 0) {
                    clearInterval(redirInterval);
                    window.location.href = '<?=base_url("login");?>';
                }
            }, 1000);
        } else {
            showAlert(data.msg || 'Unable to update password. Please try again.', 'error');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<span>Update Password &amp; Login</span> <i class="fa fa-check"></i>';
        showAlert('Failed to update password. Please try again.', 'error');
    });
}
</script>

<?php include ('includes/footer.php'); ?>