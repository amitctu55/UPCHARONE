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

.profile-setup-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.profile-hdr-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.profile-hdr-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.profile-hdr-card p {
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

/* Nav Tabs */
.profile-nav-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 12px;
    overflow-x: auto;
}

.profile-nav-tab {
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    white-space: nowrap;
    transition: all 0.15s ease;
}

.profile-nav-tab.active {
    background: #043d5b;
    color: #ffffff !important;
    border-color: #043d5b;
}

.profile-nav-tab:hover:not(.active) {
    background: #f1f5f9;
    color: #0f172a;
}

/* Setup Grid */
.setup-grid {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 24px;
    max-width: 1150px;
}

@media (max-width: 900px) {
    .setup-grid {
        grid-template-columns: 1fr;
    }
}

.setup-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.setup-card-hdr {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 18px 24px;
    color: #ffffff;
}

.setup-card-hdr h3 {
    font-size: 16px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.setup-card-body {
    padding: 26px 28px;
}

.form-group-item {
    margin-bottom: 18px;
}

.form-group-item label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-ctrl-input {
    width: 100%;
    height: 42px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.15s ease;
}

.form-ctrl-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.form-ctrl-textarea {
    width: 100%;
    height: 85px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    resize: vertical;
    transition: all 0.15s ease;
}

.form-ctrl-textarea:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-continue {
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
    margin-top: 8px;
}

.btn-continue:hover {
    background: #008f80;
    transform: translateY(-1px);
}

.map-preview-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    padding: 24px;
}

.map-embed-frame {
    width: 100%;
    height: 280px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 14px;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="profile-setup-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="profile-hdr-card">
            <div>
                <h1><i class="fa fa-map-marker" style="color: #00a896; margin-right: 8px;"></i> Hospital Contact &amp; Map Coordinates</h1>
                <p>Manage reception emergency phone lines, official communications email, and Google Maps navigation pin.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/profile_disppic');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Step 3
                </a>
            </div>
        </div>

        <!-- Multi-Step Nav Tabs -->
        <div class="profile-nav-tabs">
            <a href="<?=base_url('hospitalpanel/updateprofile');?>" class="profile-nav-tab">
                <i class="fa fa-hospital-o"></i> 1. Basic Details
            </a>
            <a href="<?=base_url('hospitalpanel/profile_clinicproof');?>" class="profile-nav-tab">
                <i class="fa fa-certificate"></i> 2. Hospital Proof
            </a>
            <a href="<?=base_url('hospitalpanel/profile_disppic');?>" class="profile-nav-tab">
                <i class="fa fa-picture-o"></i> 3. Display Banner / Photo
            </a>
            <a href="<?=base_url('hospitalpanel/profile_maplocation');?>" class="profile-nav-tab active">
                <i class="fa fa-map-marker"></i> 4. Map Location &amp; Contacts
            </a>
            <a href="<?=base_url('hospitalpanel/profile_clinic_timing');?>" class="profile-nav-tab">
                <i class="fa fa-clock-o"></i> 5. Operating Hours
            </a>
        </div>

        <!-- Form & Map Grid -->
        <div class="setup-grid">
            
            <!-- Left: Contact Details Form -->
            <div class="setup-card">
                <div class="setup-card-hdr">
                    <h3><i class="fa fa-phone"></i> Emergency &amp; Physical Address</h3>
                </div>

                <div class="setup-card-body">
                    <?php echo form_open("hospitalpanel/profile_maplocation", 'id="mapForm"');?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        
                        <!-- Phone Number -->
                        <div class="form-group-item">
                            <label>Reception / Emergency Helpline Phone <span style="color: #ef4444;">*</span></label>
                            <input type="tel" name="mobile" class="form-ctrl-input" placeholder="e.g. +91 9876543210" value="<?=html_escape($data->mobile ?? '');?>" required>
                            <span style="font-size: 11.5px; color: #64748b; margin-top: 3px; display: block;">
                                <i class="fa fa-info-circle"></i> Inpatient ambulance dispatch and patient inquiries will connect to this number.
                            </span>
                        </div>

                        <!-- Email Address -->
                        <div class="form-group-item">
                            <label>Official Hospital Communication Email <span style="color: #ef4444;">*</span></label>
                            <input type="email" name="email" class="form-ctrl-input" placeholder="e.g. contact@cityhospital.com" value="<?=html_escape($data->email ?? '');?>" required>
                        </div>

                        <!-- Street Address -->
                        <div class="form-group-item">
                            <label>Physical Street Address &amp; Landmark <span style="color: #ef4444;">*</span></label>
                            <textarea name="address" class="form-ctrl-textarea" placeholder="Complete hospital street address, building/plot number, nearby landmark, and PIN code..." required><?=html_escape($data->address ?? '');?></textarea>
                        </div>

                        <button type="submit" name="submit" value="1" class="btn-continue">
                            Save &amp; Continue to Operating Hours <i class="fa fa-arrow-right"></i>
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Right: Interactive Map Location Pin -->
            <div class="map-preview-card">
                <h4 style="font-size: 15px; font-weight: 800; color: #043d5b; margin: 0 0 8px 0;">
                    <i class="fa fa-crosshairs" style="color: #00a896;"></i> Google Maps Navigation Pin
                </h4>
                <p style="font-size: 12.5px; color: #64748b; margin: 0 0 14px 0;">
                    Patients use GPS navigation from the Upchar App to reach your emergency and OPD entry gates.
                </p>

                <div class="map-embed-frame">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13998.64059657685!2d77.26558771700856!3d28.699811139920246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfc139c6f8aab%3A0x409d254e45870ea3!2sYamuna+Vihar%2C+Shahdara%2C+Delhi%2C+110053!5e0!3m2!1sen!2sin!4v1537967067552" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen></iframe>
                </div>

                <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 8px; padding: 12px 14px; margin-top: 16px; font-size: 12px; color: #0f766e; line-height: 1.5;">
                    <i class="fa fa-shield"></i> Changes saved here will update on patient appointment slips and Google Directions immediately.
                </div>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>