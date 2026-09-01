<!-- Patient Dashboard Topbar -->
<div class="patient-topbar">
    <div>
        <h2 class="patient-topbar-title">Change Account Password</h2>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13.5px;">
            Update your patient portal security credentials to safeguard your personal health information.
        </p>
    </div>
    <div>
        <a href="<?=base_url('profile');?>" class="btn" style="background: #ffffff; color: #475569; font-weight: 600; border-radius: 8px; padding: 9px 18px; border: 1px solid #cbd5e1; text-decoration: none; font-size: 13px;">
            <i class="fa fa-user" style="margin-right: 6px;"></i> Back to Profile
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if($this->session->flashdata('msg')): ?>
    <div style="margin-bottom: 20px;">
        <?=$this->session->flashdata('msg');?>
    </div>
<?php elseif($this->session->flashdata('flashmsg')): ?>
    <div style="margin-bottom: 20px;">
        <?=$this->session->flashdata('flashmsg');?>
    </div>
<?php endif; ?>

<style>
.password-card-box {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    padding: 32px;
    margin-bottom: 30px;
}

.password-section-heading {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 14px;
}

.password-field-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.password-input-control {
    height: 44px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 14px;
    padding: 10px 14px;
    color: #1e293b;
    background-color: #ffffff;
    transition: all 0.2s ease;
    width: 100%;
}

.password-input-control:focus {
    border-color: var(--upchar-teal);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
    outline: none;
}

.btn-update-password {
    background-color: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    padding: 11px 32px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.3);
}

.btn-update-password:hover {
    background-color: var(--upchar-teal-dark);
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.4);
}
</style>

<div class="row">
    <div class="col-lg-7 col-md-9 col-12 mx-auto">
        <div class="password-card-box">
            
            <div class="password-section-heading">
                <i class="fa fa-lock" style="color: var(--upchar-teal); font-size: 20px;"></i>
                <span>Update Account Password</span>
            </div>

            <form action="" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                
                <!-- Current Password -->
                <div style="margin-bottom: 20px;">
                    <label class="password-field-label">Current / Old Password *</label>
                    <input type="password" name="password" class="password-input-control" placeholder="Enter current password" required autocomplete="current-password">
                </div>

                <!-- New Password -->
                <div style="margin-bottom: 20px;">
                    <label class="password-field-label">New Password *</label>
                    <input type="password" name="newpass" class="password-input-control" placeholder="Minimum 6 characters" required autocomplete="new-password">
                </div>

                <!-- Confirm Password -->
                <div style="margin-bottom: 24px;">
                    <label class="password-field-label">Confirm New Password *</label>
                    <input type="password" name="confpassword" class="password-input-control" placeholder="Re-enter new password" required autocomplete="new-password">
                </div>

                <div style="padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 12px;">
                    <a href="<?=base_url('profile');?>" class="btn" style="background: #ffffff; color: #64748b; border: 1px solid #cbd5e1; font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                        Cancel
                    </a>
                    <button type="submit" name="change_pass" value="1" class="btn-update-password">
                        <i class="fa fa-check-circle" style="margin-right: 6px;"></i> Save New Password
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>