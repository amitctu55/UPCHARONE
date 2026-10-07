<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.password-page-wrap {
    padding: 30px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
}

.security-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    width: 100%;
    max-width: 520px;
    overflow: hidden;
    margin-top: 20px;
}

.security-header {
    background: linear-gradient(135deg, #043d5b 0%, #00a896 100%);
    color: #ffffff;
    padding: 24px;
    text-align: center;
}

.security-icon-circle {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #ffffff;
    margin: 0 auto 12px auto;
}

.form-label-bold {
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.form-control-modern {
    height: 44px;
    border-radius: 9px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #ffffff;
    transition: all 0.2s ease;
}

.form-control-modern:focus {
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-toggle-eye {
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-left: none;
    color: #64748b;
    cursor: pointer;
    transition: color 0.2s;
}

.btn-toggle-eye:hover {
    color: #0f172a;
}

.btn-save-password {
    background: var(--upchar-teal);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 14px;
    border-radius: 9px;
    padding: 12px 24px;
    border: none;
    width: 100%;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-save-password:hover {
    background: var(--upchar-teal-dark);
}
</style>

<div class="password-page-wrap">
    
    <!-- Flash Messages -->
    <div style="width: 100%; max-width: 520px;">
        <?php if($this->session->flashdata('msg')): ?>
            <?=$this->session->flashdata('msg');?>
        <?php endif; ?>
    </div>

    <!-- Centered Security Card -->
    <div class="security-card">
        <div class="security-header">
            <div class="security-icon-circle">
                <i class="fa fa-lock"></i>
            </div>
            <h2 style="font-size: 20px; font-weight: 800; margin: 0 0 6px 0; color: #ffffff;">Security &amp; Password</h2>
            <p style="font-size: 13px; color: rgba(255,255,255,0.85); margin: 0;">
                Update your credentials to safeguard clinical patient records and portal access.
            </p>
        </div>

        <div style="padding: 28px 24px;">
            <form method="post" action="" id="changePasswordForm">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                <!-- Current Password -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label-bold">Current Password *</label>
                    <div class="input-group">
                        <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-key text-muted"></i></span>
                        <input type="password" name="password" id="old_password" class="form-control form-control-modern" style="border-right: none;" placeholder="Enter your current password" required autofocus>
                        <span class="input-group-addon btn-toggle-eye" data-target="#old_password"><i class="fa fa-eye"></i></span>
                    </div>
                </div>

                <!-- New Password -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label-bold">New Password *</label>
                    <div class="input-group">
                        <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-shield text-muted"></i></span>
                        <input type="password" name="newpass" id="new_password" class="form-control form-control-modern" style="border-right: none;" placeholder="Enter strong new password (min. 6 chars)" minlength="6" required>
                        <span class="input-group-addon btn-toggle-eye" data-target="#new_password"><i class="fa fa-eye"></i></span>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label-bold">Confirm New Password *</label>
                    <div class="input-group">
                        <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-check-circle text-muted"></i></span>
                        <input type="password" name="confpassword" id="conf_password" class="form-control form-control-modern" style="border-right: none;" placeholder="Re-enter new password" minlength="6" required>
                        <span class="input-group-addon btn-toggle-eye" data-target="#conf_password"><i class="fa fa-eye"></i></span>
                    </div>
                    <div id="match_feedback" style="font-size: 11.5px; margin-top: 6px; font-weight: 600; display: none;"></div>
                </div>

                <!-- Password Requirements Box -->
                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 12px 14px; margin-bottom: 22px; font-size: 12px; color: #475569;">
                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">Security Best Practices:</div>
                    <ul style="margin: 0; padding-left: 18px; line-height: 1.6;">
                        <li>Use at least 8 characters with a mix of letters, numbers, and symbols.</li>
                        <li>Avoid easily guessable information like your name or birth date.</li>
                    </ul>
                </div>

                <button type="submit" name="change_pass" value="SAVE" id="btnSubmitPassword" class="btn-save-password">
                    <i class="fa fa-check"></i> Update Password
                </button>
            </form>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
$(document).ready(function() {
    // Eye icon toggle password visibility
    $('.btn-toggle-eye').on('click', function() {
        var targetId = $(this).attr('data-target');
        var $input = $(targetId);
        var $icon = $(this).find('i');

        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Real-time password match validation
    $('#conf_password, #new_password').on('keyup', function() {
        var newPass = $('#new_password').val();
        var confPass = $('#conf_password').val();
        var $feedback = $('#match_feedback');

        if (confPass.length === 0) {
            $feedback.hide();
            return;
        }

        if (newPass === confPass) {
            $feedback.css('color', '#15803d').html('<i class="fa fa-check"></i> Passwords match perfectly.').show();
            $('#btnSubmitPassword').prop('disabled', false);
        } else {
            $feedback.css('color', '#b91c1c').html('<i class="fa fa-times-circle"></i> Passwords do not match.').show();
        }
    });

    // Form submit guard
    $('#changePasswordForm').on('submit', function(e) {
        var newPass = $('#new_password').val();
        var confPass = $('#conf_password').val();

        if (newPass !== confPass) {
            e.preventDefault();
            alert('New Password and Confirm Password do not match. Please verify and try again.');
            $('#conf_password').focus();
            return false;
        }
    });
});
</script>