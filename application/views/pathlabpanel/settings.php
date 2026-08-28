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
    flex-wrap: wrap;
    gap: 10px;
}
.pathlab-card-title {
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 24px;
}
.setting-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
    border-bottom: 1px solid #f1f5f9;
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-cog" style="color: #00a896;"></i> Diagnostic Laboratory Settings
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Configure laboratory notifications, doorstep sample pickup preferences, and account security.</p>
                </div>
            </div>

            <div class="pathlab-card">
                <div class="pathlab-card-header">
                    <h3 class="pathlab-card-title">
                        <i class="fa fa-sliders"></i> Operational Preferences
                    </h3>
                </div>
                <div class="pathlab-card-body">
                    <div class="setting-row">
                        <div>
                            <strong style="font-size: 14px; color: #1e293b; display: block;">Home Sample Collection Service</strong>
                            <span style="font-size: 12.5px; color: #64748b;">Accept doorstep blood and diagnostic sample pickup requests from patients</span>
                        </div>
                        <div>
                            <span class="label label-success" style="padding: 6px 14px; border-radius: 20px; font-size: 11.5px;">Active / Enabled</span>
                        </div>
                    </div>

                    <div class="setting-row">
                        <div>
                            <strong style="font-size: 14px; color: #1e293b; display: block;">SMS & WhatsApp Notifications</strong>
                            <span style="font-size: 12.5px; color: #64748b;">Receive instant alerts on your registered mobile when a patient books tests</span>
                        </div>
                        <div>
                            <span class="label label-success" style="padding: 6px 14px; border-radius: 20px; font-size: 11.5px;">Active / Enabled</span>
                        </div>
                    </div>

                    <div class="setting-row">
                        <div>
                            <strong style="font-size: 14px; color: #1e293b; display: block;">Laboratory Center Timing & Shifts</strong>
                            <span style="font-size: 12.5px; color: #64748b;">Configure opening and closing hours for sample walk-ins</span>
                        </div>
                        <div>
                            <a href="<?=base_url('pathlabpanel/profile_clinic_timing');?>" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 6px;">
                                Manage Shifts <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="setting-row" style="border-bottom: none;">
                        <div>
                            <strong style="font-size: 14px; color: #1e293b; display: block;">Account Security & Password</strong>
                            <span style="font-size: 12.5px; color: #64748b;">Update your administrative login password</span>
                        </div>
                        <div>
                            <a href="<?=base_url('pathlabpanel/change_password');?>" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 600; border-radius: 6px;">
                                Change Password <i class="fa fa-key"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
