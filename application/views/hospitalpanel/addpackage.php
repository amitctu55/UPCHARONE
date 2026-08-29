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

.pkgform-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.pkgform-header-card {
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

.pkgform-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.pkgform-header-card p {
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

.pkgform-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 24px;
    max-width: 1100px;
}

@media (max-width: 900px) {
    .pkgform-grid {
        grid-template-columns: 1fr;
    }
}

.pkgform-card {
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
    margin-bottom: 18px;
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
    height: 100px;
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

.btn-save-pkg {
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

.btn-save-pkg:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.4);
}

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
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="pkgform-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="pkgform-header-card">
            <div>
                <h1><i class="fa fa-plus-circle" style="color: #00a896; margin-right: 8px;"></i> Create Health Package</h1>
                <p>Publish a new comprehensive healthcare checkup or surgical package for patients.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/package');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Packages
                </a>
            </div>
        </div>

        <!-- Form & Guidelines Grid -->
        <div class="pkgform-grid">
            
            <!-- Left: Package Form -->
            <div class="pkgform-card">
                <div class="form-header-bar">
                    <h3><i class="fa fa-medkit"></i> Package Specifications</h3>
                </div>

                <div class="form-body-pad">
                    <?php echo form_open_multipart("hospitalpanel/addpackage", 'id="addPackageForm"');?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        
                        <!-- Title -->
                        <div class="input-wrap-group">
                            <label>Package Title / Name <span class="req">*</span></label>
                            <input type="text" name="title" class="form-ctrl-input" placeholder="e.g. Master Executive Health Checkup / Cardiac Screening" value="<?=set_value('title');?>" required>
                            <span style="color: #ef4444; font-size: 12px;"><?=form_error('title');?></span>
                        </div>

                        <!-- Amount -->
                        <div class="input-wrap-group">
                            <label>Package Price / Total Fee (₹) <span class="req">*</span></label>
                            <input type="number" step="0.01" name="amount" class="form-ctrl-input" placeholder="e.g. 2499.00" value="<?=set_value('amount');?>" required>
                            <span style="color: #ef4444; font-size: 12px;"><?=form_error('amount');?></span>
                        </div>

                        <!-- Description -->
                        <div class="input-wrap-group">
                            <label>Included Tests, Consultations &amp; Clinical Details</label>
                            <textarea name="description" class="form-ctrl-textarea" placeholder="List all included diagnostics, blood tests, radiology, doctor consultations, and fasting guidelines..."><?=set_value('description');?></textarea>
                            <span style="color: #ef4444; font-size: 12px;"><?=form_error('description');?></span>
                        </div>

                        <!-- Image Banner -->
                        <div class="input-wrap-group">
                            <label>Package Promotional Banner / Image</label>
                            <input type="file" name="image" class="form-ctrl-input" accept="image/*" style="padding: 6px;">
                            <span style="font-size: 11.5px; color: #64748b; margin-top: 3px; display: block;">Supported formats: JPG, PNG, WEBP (Max: 5MB)</span>
                        </div>

                        <!-- YouTube Video -->
                        <div class="input-wrap-group">
                            <label><i class="fa fa-youtube-play" style="color: #dc2626;"></i> Explainer Video URL (Optional)</label>
                            <input type="url" name="video_url" class="form-ctrl-input" placeholder="https://www.youtube.com/watch?v=..." value="<?=set_value('video_url');?>">
                        </div>

                        <!-- Status -->
                        <div class="input-wrap-group">
                            <label>Publishing Status</label>
                            <select name="status" class="form-ctrl-input">
                                <option value="1" <?=set_value('status', '1')=='1' ? 'selected' : '';?>>Active (Visible to public &amp; patients)</option>
                                <option value="0" <?=set_value('status')=='0' ? 'selected' : '';?>>Draft / Inactive (Hidden)</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-save-pkg">
                            <i class="fa fa-check-circle"></i> Save &amp; Publish Package
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Right: Package Best Practices -->
            <div class="guidelines-card">
                <h4><i class="fa fa-info-circle" style="color: #00a896;"></i> Package Publishing Tips</h4>
                
                <ul class="rule-list">
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Clearly mention <strong>fasting requirements</strong> (e.g. 10-12 hrs fasting for lipid profile &amp; blood sugar).</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>List all individual diagnostic tests included in the bundle so patients understand the total value.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Add physician consultation details (e.g. Includes General Physician &amp; Cardiologist Review).</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span>Keep the pricing transparent with no hidden charges for sample collection or report dispatch.</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>