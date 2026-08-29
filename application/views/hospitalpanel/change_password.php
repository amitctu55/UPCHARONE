<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.chgpass-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Page Header */
.chgpass-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.chgpass-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.chgpass-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-back-link {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: #475569 !important;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-back-link:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}

/* 2-Column Grid Layout */
.chgpass-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 24px;
    max-width: 1050px;
}

@media (max-width: 900px) {
    .chgpass-grid {
        grid-template-columns: 1fr;
    }
}

/* Form Card */
.chgpass-form-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.form-header-bar {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 18px 24px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-header-bar h3 {
    font-size: 16px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-body-pad {
    padding: 26px 28px;
}

.input-wrap-group {
    margin-bottom: 20px;
}

.input-wrap-group label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.input-wrap-group label .req {
    color: #ef4444;
}

.pwd-field-container {
    position: relative;
}

.form-ctrl-pwd {
    width: 100%;
    height: 44px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 42px 8px 14px;
    font-size: 14px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.15s ease;
}

.form-ctrl-pwd:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.pwd-toggle-icon {
    position: absolute;
    right: 14px;
    top: 13px;
    color: #94a3b8;
    cursor: pointer;
    font-size: 15px;
    transition: color 0.15s;
}

.pwd-toggle-icon:hover {
    color: #043d5b;
}

/* Submit Button */
.btn-save-pwd {
    background: #00a896;
    color: #ffffff;
    font-weight: 800;
    font-size: 14px;
    height: 44px;
    padding: 0 28px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);
    transition: all 0.15s ease;
    width: 100%;
    margin-top: 10px;
}

.btn-save-pwd:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.4);
}

/* Sidebar Guidelines Card */
.guidelines-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    padding: 24px;
}

.guidelines-card h4 {
    font-size: 15px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 14px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.rule-list {
    list-style: none;
    padding: 0;
    margin: 0 0 20px 0;
}

.rule-list li {
    font-size: 13px;
    color: #475569;
    margin-bottom: 12px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    line-height: 1.5;
}

.rule-list li i {
    color: #00a896;
    margin-top: 3px;
    font-size: 14px;
}

.security-tip-box {
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    border-radius: 10px;
    padding: 14px 16px;
    font-size: 12.5px;
    color: #0d9488;
    line-height: 1.5;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="chgpass-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('msg')): ?>
            <?=$this->session->flashdata('msg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="chgpass-header-card">
            <div>
                <h1><i class="fa fa-key" style="color: #00a896; margin-right: 8px;"></i> Change Password</h1>
                <p>Manage your hospital administrative credentials and login password.</p>
            </div>
            <div>
                <a href="<?=base_url('hospital-dashboard');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <!-- 2-Column Form & Guidelines Grid -->
        <div class="chgpass-grid">
            
            <!-- Left Card: Form -->
            <div class="chgpass-form-card">
                <div class="form-header-bar">
                    <h3><i class="fa fa-lock"></i> Update Account Password</h3>
                    <span style="font-size: 12px; opacity: 0.9;"><i class="fa fa-shield"></i> 256-bit Encrypted</span>
                </div>

                <div class="form-body-pad">
                    <form method="POST" action="<?=base_url('hospitalpanel/change_password');?>" id="changePasswordForm">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        
                        <!-- Old Password -->
                        <div class="input-wrap-group">
                            <label>Current / Old Password <span class="req">*</span></label>
                            <div class="pwd-field-container">
                                <input type="password" name="password" id="oldPassword" class="form-ctrl-pwd" placeholder="Enter current password" required>
                                <i class="fa fa-eye-slash pwd-toggle-icon" onclick="togglePasswordVisibility('oldPassword', this)"></i>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="input-wrap-group">
                            <label>New Password <span class="req">*</span></label>
                            <div class="pwd-field-container">
                                <input type="password" name="newpass" id="newPassword" class="form-ctrl-pwd" placeholder="Enter new password (min 6 characters)" minlength="6" required>
                                <i class="fa fa-eye-slash pwd-toggle-icon" onclick="togglePasswordVisibility('newPassword', this)"></i>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="input-wrap-group">
                            <label>Confirm New Password <span class="req">*</span></label>
                            <div class="pwd-field-container">
                                <input type="password" name="confpassword" id="confPassword" class="form-ctrl-pwd" placeholder="Re-enter new password" minlength="6" required>
                                <i class="fa fa-eye-slash pwd-toggle-icon" onclick="togglePasswordVisibility('confPassword', this)"></i>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" value="SAVE" name="change_pass" class="btn-save-pwd" id="btnSubmitPassword">
                            <i class="fa fa-check-circle"></i> Save &amp; Update Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Card: Security Recommendations -->
            <div class="guidelines-card">
                <h4><i class="fa fa-shield" style="color: #00a896;"></i> Password Best Practices</h4>
                
                <ul class="rule-list">
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Use at least <strong>6 to 12 characters</strong> with a combination of uppercase, lowercase, numbers, and symbols.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Avoid using obvious personal details, hospital phone numbers, or common dictionary words.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Never share your administrative credentials with unauthorized personnel or third-party contractors.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Change your administrative password periodically (every 90 days recommended) to keep patient and billing records secure.</span>
                    </li>
                </ul>

                <div class="security-tip-box">
                    <i class="fa fa-info-circle"></i> <strong>Note:</strong> After changing your password, your active session remains verified. Make sure to log out from shared reception workstations when not in use.
                </div>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
function togglePasswordVisibility(inputId, iconElem) {
    var input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        iconElem.classList.remove("fa-eye-slash");
        iconElem.classList.add("fa-eye");
    } else {
        input.type = "password";
        iconElem.classList.remove("fa-eye");
        iconElem.classList.add("fa-eye-slash");
    }
}

$(document).ready(function() {
    $('#changePasswordForm').on('submit', function(e) {
        var newPass = $('#newPassword').val();
        var confPass = $('#confPassword').val();

        if (newPass !== confPass) {
            e.preventDefault();
            alert("New Password and Confirm Password do not match. Please verify.");
            $('#confPassword').focus();
            return false;
        }

        if (newPass.length < 6) {
            e.preventDefault();
            alert("New password must be at least 6 characters long.");
            $('#newPassword').focus();
            return false;
        }

        $('#btnSubmitPassword').html('<i class="fa fa-spinner fa-spin"></i> Updating Password...').prop('disabled', true);
    });
});
</script>