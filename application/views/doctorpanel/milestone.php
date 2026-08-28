<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

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

.profile-setup-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.step-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 22px;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
}

.step-card:hover {
    transform: translateY(-2px);
    border-color: var(--upchar-teal);
    box-shadow: 0 8px 18px rgba(0, 168, 150, 0.1);
}

.step-icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.step-btn {
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.btn-teal {
    background: var(--upchar-teal);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
}

.btn-teal:hover {
    background: var(--upchar-teal-dark);
}

.badge-complete {
    background: #dcfce7;
    color: #15803d;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 10px;
}
</style>

<div class="pag_cstm profile-setup-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Hero Welcome Card -->
            <?php 
            $doc_name = $this->session->userdata('drusername') ?: 'Anushka';
            $doc_lname = $this->session->userdata('druserlname') ?: '';
            ?>
            <div style="background: linear-gradient(135deg, #043d5b 0%, #00a896 100%); border-radius: 16px; padding: 28px 32px; color: #ffffff; margin-bottom: 24px; box-shadow: 0 10px 25px -5px rgba(4, 61, 91, 0.2);">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <span class="badge" style="background: rgba(255,255,255,0.2); color: #ffffff; font-size: 11.5px; padding: 4px 10px; margin-bottom: 8px;">
                            <i class="fa fa-check-circle"></i> Practitioner Onboarding &amp; Profile Center
                        </span>
                        <h1 style="font-size: 24px; font-weight: 800; margin: 0 0 6px 0; color: #ffffff;">
                            Profile Setup &amp; Milestone Roadmap
                        </h1>
                        <p style="font-size: 13.5px; color: rgba(255, 255, 255, 0.9); margin: 0;">
                            Welcome Dr. <?=$doc_name;?> <?=$doc_lname;?>. Keep your credentials, consultation fees, and practice locations updated to maximize patient visibility.
                        </p>
                    </div>
                    <div style="background: rgba(255,255,255,0.15); border-radius: 12px; padding: 14px 20px; border: 1px solid rgba(255,255,255,0.2); text-align: center;">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: rgba(255,255,255,0.8);">Profile Strength</div>
                        <div style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 2px 0;">85%</div>
                        <div style="font-size: 11px; color: #a7f3d0; font-weight: 600;"><i class="fa fa-shield"></i> Verified Doctor</div>
                    </div>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <div class="row">
                <!-- Left: 4 Milestone Step Cards -->
                <div class="col-md-8 col-12">
                    
                    <!-- Step 1 -->
                    <div class="step-card">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div class="step-icon-circle" style="background: #e0f2fe; color: #0284c7;">
                                <i class="fa fa-user-md"></i>
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                                    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Step 1: Clinical Profile &amp; Demographics</h4>
                                    <span class="badge-complete"><i class="fa fa-check"></i> Complete</span>
                                </div>
                                <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                                    Doctor name, medical registration council ID, degree qualifications, and primary specializations.
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="<?=base_url('profile_step1');?>" class="step-btn btn-teal">
                                <i class="fa fa-pencil"></i> Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step-card">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div class="step-icon-circle" style="background: #f0fdfa; color: #00a896;">
                                <i class="fa fa-hospital-o"></i>
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                                    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Step 2: Own Clinics &amp; Practice Chambers</h4>
                                    <span class="badge-complete"><i class="fa fa-check"></i> Active</span>
                                </div>
                                <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                                    Private clinic addresses, locality mapping, and clinical establishment verification proof.
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="<?=base_url('manageownclinic');?>" class="step-btn btn-default" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">
                                <i class="fa fa-building-o"></i> Manage Clinics
                            </a>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step-card">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div class="step-icon-circle" style="background: #f5f3ff; color: #7c3aed;">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                                    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Step 3: Schedule &amp; Slot Availability</h4>
                                    <span class="badge-complete"><i class="fa fa-check"></i> Configured</span>
                                </div>
                                <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                                    Set your weekly consulting days, morning/evening session hours, and patient slot intervals.
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="<?=base_url('doctorpanel/datetime');?>" class="step-btn btn-default" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                                <i class="fa fa-calendar"></i> Slot Timings
                            </a>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="step-card">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div class="step-icon-circle" style="background: #fef3c7; color: #d97706;">
                                <i class="fa fa-inr"></i>
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                                    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Step 4: Consultation Fees &amp; Payouts</h4>
                                    <span class="badge-complete"><i class="fa fa-check"></i> Configured</span>
                                </div>
                                <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                                    Configure in-clinic consultation fees, follow-up rates, and bank account for weekly escrow disbursements.
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="<?=base_url('managepractice');?>" class="step-btn btn-default" style="background: #f0fdfa; color: #00a896; border: 1px solid #ccfbf1;">
                                <i class="fa fa-medkit"></i> Manage Fees
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Right: Profile Insights & Quick Actions -->
                <div class="col-md-4 col-12">
                    <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 14px; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); margin-bottom: 20px;">
                        <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 12px 0;">
                            <i class="fa fa-lightbulb-o text-yellow"></i> Profile Impact
                        </h4>
                        <p style="font-size: 12.5px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">
                            Doctors with a complete profile, active chamber photos, and verified qualifications receive <strong>95% more appointment bookings</strong> and rank higher in patient searches.
                        </p>
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 14px;">
                            <a href="<?=base_url('doctorpanel/gallery');?>" class="btn btn-sm btn-default" style="width: 100%; text-align: left; margin-bottom: 8px; font-weight: 600; color: #334155;">
                                <i class="fa fa-picture-o text-aqua"></i> Upload Chamber Photos &rarr;
                            </a>
                            <a href="<?=base_url('doctorpanel/upcharhospital');?>" class="btn btn-sm btn-default" style="width: 100%; text-align: left; margin-bottom: 8px; font-weight: 600; color: #334155;">
                                <i class="fa fa-building-o text-green"></i> Add Affiliated Hospitals &rarr;
                            </a>
                            <a href="<?=base_url('doctorpanel/change_password/');?>" class="btn btn-sm btn-default" style="width: 100%; text-align: left; font-weight: 600; color: #334155;">
                                <i class="fa fa-lock text-yellow"></i> Security &amp; Password &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>