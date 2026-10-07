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

.profile-page-wrap {
    padding: 26px 30px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Stepper Progress Bar */
.stepper-wrap {
    display: flex;
    justify-content: space-between;
    margin-bottom: 24px;
    position: relative;
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 12px;
    padding: 16px 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.step-item {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
    flex: 1;
}

.step-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 13px;
    flex-shrink: 0;
}

.step-item.active .step-circle {
    background: var(--upchar-teal);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.3);
}

.step-item.completed .step-circle {
    background: #dcfce7;
    color: #15803d;
}

.step-item.pending .step-circle {
    background: #f1f5f9;
    color: #94a3b8;
}

.step-label {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
}

.step-item.pending .step-label {
    color: #94a3b8;
}

.step-sub {
    font-size: 11px;
    color: #64748b;
    display: block;
}

.card-custom {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    overflow: hidden;
}

.form-label-bold {
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.form-control-modern {
    width: 100%;
    height: 44px;
    border-radius: 9px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #ffffff;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-control-modern:focus {
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.gender-box {
    display: flex;
    gap: 14px;
    margin-top: 4px;
}

.gender-label {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: 8px;
    padding: 9px 20px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    transition: all 0.2s;
    user-select: none;
}

.gender-label:hover {
    border-color: var(--upchar-teal);
}

.gender-label input {
    margin: 0;
}

.btn-primary-action {
    background: var(--upchar-teal);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13.5px;
    border-radius: 8px;
    padding: 11px 26px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.22);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-primary-action:hover {
    background: var(--upchar-teal-dark);
}
</style>

<div class="profile-page-wrap">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 20px; gap: 12px;">
                <div>
                    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-user-md text-aqua" style="margin-right: 8px;"></i> Practitioner Verification Onboarding
                    </h1>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Complete clinical profile details to synchronize credentials with the Upchar National Registry.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('doctorpanel/updateprofile');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                        <i class="fa fa-arrow-left"></i> Profile Overview
                    </a>
                </div>
            </div>

            <!-- Multi-Step Roadmap Stepper Bar -->
            <div class="stepper-wrap hidden-xs">
                <div class="step-item active">
                    <div class="step-circle">1</div>
                    <div>
                        <div class="step-label">Basic Profile</div>
                        <span class="step-sub">Personal &amp; Specialization</span>
                    </div>
                </div>
                <div class="step-item pending">
                    <div class="step-circle">2</div>
                    <div>
                        <div class="step-label">Qualifications</div>
                        <span class="step-sub">Degrees &amp; Colleges</span>
                    </div>
                </div>
                <div class="step-item pending">
                    <div class="step-circle">3</div>
                    <div>
                        <div class="step-label">Credentials Proof</div>
                        <span class="step-sub">MCI / SMC Certificate</span>
                    </div>
                </div>
                <div class="step-item pending">
                    <div class="step-circle">4</div>
                    <div>
                        <div class="step-label">Verification</div>
                        <span class="step-sub">Live Badge Activation</span>
                    </div>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <div class="row">
                <!-- Form Box -->
                <div class="col-md-8 col-12">
                    <div class="card-custom">
                        <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                            <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                                <i class="fa fa-id-card-o text-aqua"></i> Step 1: Personal &amp; Clinical Information
                            </h3>
                            <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Enter practitioner name, contact, specialization, and council registration.</p>
                        </div>

                        <div style="padding: 26px 24px;">
                            <form action="" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                                <!-- Doctor Name & Email 2-Column Row -->
                                <div class="row" style="margin-bottom: 18px;">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Doctor Full Name *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-user-md text-muted"></i></span>
                                                <input type="text" name="name" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" value="<?=htmlspecialchars(@$data->fname);?>" placeholder="e.g. Dr. Anushka Sharma" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Official Email Address *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-envelope-o text-muted"></i></span>
                                                <input type="email" name="email" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" value="<?=htmlspecialchars(@$data->email);?>" placeholder="e.g. anushka@hospital.com" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Registration Number & Clinical Experience 2-Column Row -->
                                <div class="row" style="margin-bottom: 18px;">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Medical Council Reg. Number *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-certificate text-muted"></i></span>
                                                <input type="text" name="mci_number" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" value="<?=htmlspecialchars(@$data->mci_number ?: @$data->registration_no);?>" placeholder="e.g. MCI-2018-98421" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Clinical Experience (Years)</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" style="background: #f8fafc; border-color: var(--upchar-border);"><i class="fa fa-history text-muted"></i></span>
                                                <input type="number" name="experience" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" value="<?=htmlspecialchars(@$data->experience ?: 5);?>" min="0" max="60" placeholder="e.g. 8">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Primary Specialization & Base City 2-Column Row -->
                                <div class="row" style="margin-bottom: 18px;">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Primary Clinical Specialization *</label>
                                            <select class="form-control-modern" name="specialisation[]" required>
                                                <option value="">-- Select Specialization --</option>
                                                <?php
                                                $spl_list = $this->db->order_by('name')->get_where('master_specialization', array('status'=>1));
                                                foreach(@$spl_list->result() as $list){
                                                ?>
                                                <option value="<?=$list->id;?>" <?php if(in_array($list->id, (array)@$data_spl)){echo 'selected';} ?>><?=$list->name;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label-bold">Primary Practice City *</label>
                                            <select class="form-control-modern" name="city" required>
                                                <option value="">-- Select City --</option>
                                                <?php
                                                $citylist = $this->db->order_by('name')->get_where('master_city', array('status'=>'1'));
                                                foreach(@$citylist->result() as $list){
                                                ?>
                                                <option value="<?=$list->id;?>" <?php if(@$data->city == $list->id){ echo 'selected';} ?>><?=$list->name;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gender Selection -->
                                <div class="form-group" style="margin-bottom: 24px;">
                                    <label class="form-label-bold">Gender Identity *</label>
                                    <div class="gender-box">
                                        <label class="gender-label">
                                            <input type="radio" name="gender" value="M" <?php if(@$data->gender == 'M' || empty($data->gender)) echo 'checked'; ?>> Male
                                        </label>
                                        <label class="gender-label">
                                            <input type="radio" name="gender" value="F" <?php if(@$data->gender == 'F') echo 'checked'; ?>> Female
                                        </label>
                                        <label class="gender-label">
                                            <input type="radio" name="gender" value="O" <?php if(@$data->gender == 'O') echo 'checked'; ?>> Other
                                        </label>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                                    <a href="<?=base_url('doctorpanel/updateprofile');?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px;">
                                        Cancel
                                    </a>
                                    <button type="submit" name="submit" class="btn-primary-action">
                                        <span>Save &amp; Continue to Qualifications</span> <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Verified Credentials Sidebar -->
                <div class="col-md-4 col-12">
                    <div class="card-custom" style="padding: 24px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                <i class="fa fa-shield"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Practitioner Compliance</h4>
                        </div>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 14px;">
                            Providing your State Medical Council registration unlocks instant appointment booking and prescription generation on Upchar.
                        </p>
                        <div style="background: #f0fdfa; border-radius: 10px; padding: 14px; border: 1px solid #ccfbf1; margin-bottom: 12px;">
                            <div style="font-size: 12px; font-weight: 700; color: #0f766e; margin-bottom: 4px;">
                                <i class="fa fa-check-circle"></i> National Health Stack Ready
                            </div>
                            <div style="font-size: 11.5px; color: #115e59;">Compliant with Ayushman Bharat Digital Mission (ABDM) guidelines.</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>