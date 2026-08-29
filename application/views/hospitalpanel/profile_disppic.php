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
    grid-template-columns: 1.5fr 1fr;
    gap: 24px;
    max-width: 1100px;
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

.doc-upload-box {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 28px 20px;
    text-align: center;
    background: #f8fafc;
    margin-bottom: 20px;
    transition: all 0.15s ease;
}

.doc-upload-box:hover {
    border-color: #00a896;
    background: #f0fdfa;
}

.doc-upload-box i {
    font-size: 36px;
    color: #00a896;
    margin-bottom: 10px;
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
}

.btn-continue:hover {
    background: #008f80;
    transform: translateY(-1px);
}

.guidelines-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    padding: 24px;
}

.preview-box {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px;
    background: #f8fafc;
    text-align: center;
    margin-top: 16px;
}

.preview-box img {
    max-width: 100%;
    max-height: 220px;
    border-radius: 6px;
    object-fit: contain;
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
                <h1><i class="fa fa-picture-o" style="color: #00a896; margin-right: 8px;"></i> Hospital Display Banner &amp; Photo</h1>
                <p>Upload your hospital entrance, building facade, or reception banner displayed to patients on the Upchar app.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/profile_clinicproof');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Step 2
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
            <a href="<?=base_url('hospitalpanel/profile_disppic');?>" class="profile-nav-tab active">
                <i class="fa fa-picture-o"></i> 3. Display Banner / Photo
            </a>
            <a href="<?=base_url('hospitalpanel/profile_maplocation');?>" class="profile-nav-tab">
                <i class="fa fa-map-marker"></i> 4. Map Location
            </a>
        </div>

        <!-- Form & Guidelines Grid -->
        <div class="setup-grid">
            
            <!-- Left: Upload Form -->
            <div class="setup-card">
                <div class="setup-card-hdr">
                    <h3><i class="fa fa-upload"></i> Upload Hospital Display Photo</h3>
                </div>

                <div class="setup-card-body">
                    <?php echo form_open_multipart("hospitalpanel/profile_disppic", 'id="dispPicForm"');?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        
                        <div class="doc-upload-box">
                            <i class="fa fa-camera"></i>
                            <div style="font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 4px;">
                                Select Hospital Image
                            </div>
                            <p style="font-size: 12px; color: #64748b; margin-bottom: 16px;">
                                Recommended Resolution: 800x500px (JPG, PNG, JPEG, Max 5MB)
                            </p>
                            
                            <input type="file" name="images" id="dispInput" class="form-control" accept="image/*" style="max-width: 340px; margin: 0 auto;" <?=(empty($src) ? 'required' : '');?>>
                        </div>

                        <button type="submit" name="submit" value="1" class="btn-continue">
                            Save &amp; Continue <i class="fa fa-arrow-right"></i>
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Right: Photo Guidelines & Existing Preview -->
            <div class="guidelines-card">
                <h4 style="font-size: 15px; font-weight: 800; color: #043d5b; margin: 0 0 14px 0;">
                    <i class="fa fa-info-circle" style="color: #00a896;"></i> Photo Guidelines
                </h4>

                <ul style="padding-left: 20px; font-size: 13px; color: #475569; line-height: 1.6; margin-bottom: 20px;">
                    <li>High quality photo of the hospital front building or reception.</li>
                    <li>Avoid blurry, dark, or watermarked stock photos.</li>
                    <li>Photos with visible hospital name signage receive 40% higher patient bookings.</li>
                </ul>

                <?php if(!empty($src)): ?>
                    <div class="preview-box">
                        <strong style="font-size: 12px; color: #043d5b; display: block; margin-bottom: 8px;">
                            <i class="fa fa-check-circle" style="color: #10b981;"></i> Current Display Banner
                        </strong>
                        <a href="<?=base_url('admin1947/public/assets/upload/'.$src);?>" target="_blank">
                            <img src="<?=base_url('admin1947/public/assets/upload/'.$src);?>" alt="Hospital Display Preview">
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>