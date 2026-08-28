<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<style>
.pathlab-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 25px;
    overflow: hidden;
}
.pathlab-card-header {
    background: linear-gradient(135deg, #1d2a44 0%, #295771 100%);
    color: #ffffff;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pathlab-card-title {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 24px;
}
.path-form-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}
.path-form-control {
    width: 100%;
    height: 42px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 8px 14px;
    font-size: 13.5px;
    color: #1e293b;
    transition: all 0.2s ease;
    background: #ffffff;
}
.path-form-control:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-key" style="color: #00a896;"></i> Change Account Password
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Update your laboratory portal password to keep your patient records secure.</p>
                </div>
            </div>

            <!-- Flash Alert Messages -->
            <?=$this->session->flashdata('msg');?>

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="pathlab-card">
                        <div class="pathlab-card-header">
                            <h3 class="pathlab-card-title">
                                <i class="fa fa-lock"></i> Password Security
                            </h3>
                        </div>
                        <div class="pathlab-card-body">
                            <form method="post" action="">
                                <div class="form-group" style="margin-bottom: 18px;">
                                    <label class="path-form-label">Current Password <span style="color: #ef4444;">*</span></label>
                                    <input type="password" name="password" class="path-form-control" placeholder="••••••••" required>
                                </div>

                                <div class="form-group" style="margin-bottom: 18px;">
                                    <label class="path-form-label">New Password <span style="color: #ef4444;">*</span></label>
                                    <input type="password" name="newpass" class="path-form-control" placeholder="Minimum 6 characters" required minlength="6">
                                </div>

                                <div class="form-group" style="margin-bottom: 22px;">
                                    <label class="path-form-label">Confirm New Password <span style="color: #ef4444;">*</span></label>
                                    <input type="password" name="confpassword" class="path-form-control" placeholder="Re-type new password" required minlength="6">
                                </div>

                                <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 18px;">
                                    <button type="submit" name="change_pass" value="SAVE" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; border-radius: 8px; padding: 10px 28px; width: 100%;">
                                        <i class="fa fa-shield"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>