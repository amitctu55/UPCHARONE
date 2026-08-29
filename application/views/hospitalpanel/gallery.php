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

.gallery-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.gallery-header-card {
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

.gallery-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.gallery-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.gallery-form-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    max-width: 800px;
}

.card-header-bar {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 18px 24px;
    color: #ffffff;
    font-size: 16px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-body-wrap {
    padding: 28px;
}

.form-group-field {
    margin-bottom: 20px;
}

.form-group-field label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-group-field .ctrl-input {
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

.form-group-field textarea.ctrl-input {
    height: 90px;
    resize: vertical;
}

.form-group-field .ctrl-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.file-dropzone-box {
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    padding: 24px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.15s ease;
}

.file-dropzone-box:hover {
    border-color: #00a896;
    background: #f0fdfa;
}

.btn-submit-media {
    background: #00a896;
    color: #ffffff;
    font-weight: 800;
    font-size: 13.5px;
    padding: 10px 24px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-submit-media:hover {
    background: #008f80;
    transform: translateY(-1px);
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="gallery-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="gallery-header-card">
            <div>
                <h1><i class="fa fa-picture-o" style="color: #00a896; margin-right: 8px;"></i> Hospital Media Gallery</h1>
                <p>Upload infrastructure photos, operation theatre showcases, and ward facilities for patient previews.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/managegallery');?>" class="btn-submit-media" style="background: #043d5b;">
                    <i class="fa fa-th-large"></i> View Gallery List
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="gallery-form-card">
            <div class="card-header-bar">
                <i class="fa fa-cloud-upload"></i> Upload Gallery Image
            </div>

            <div class="card-body-wrap">
                <form action="<?=base_url('hospitalpanel/gallery');?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                    <div class="form-group-field">
                        <label>Short Title / Caption <span style="color: #ef4444;">*</span></label>
                        <input type="text" class="ctrl-input" name="shot" placeholder="e.g. Advanced ICU &amp; Critical Care Unit" required>
                    </div>

                    <div class="form-group-field">
                        <label>Detailed Description <span style="color: #ef4444;">*</span></label>
                        <textarea class="ctrl-input" name="long" placeholder="Describe the facility or equipment shown in this photo..." required></textarea>
                    </div>

                    <div class="form-group-field">
                        <label>Choose High-Resolution Photo <span style="color: #ef4444;">*</span></label>
                        <div class="file-dropzone-box" onclick="$('#fileUploadInput').click();">
                            <i class="fa fa-picture-o" style="font-size: 32px; color: #00a896; margin-bottom: 8px;"></i>
                            <div style="font-weight: 700; color: #334155; font-size: 13.5px;" id="fileChosenText">Click to select image file</div>
                            <span style="font-size: 12px; color: #94a3b8;">Supports JPG, PNG, WEBP (Up to 5MB)</span>
                        </div>
                        <input type="file" id="fileUploadInput" name="uploadimage" style="display: none;" onchange="$('#fileChosenText').text(this.files[0] ? this.files[0].name : 'Click to select image file');" required>
                    </div>

                    <div style="margin-top: 24px; display: flex; gap: 12px;">
                        <button type="submit" name="submit" class="btn-submit-media">
                            <i class="fa fa-plus-circle"></i> Upload to Gallery
                        </button>
                        <button type="reset" class="btn-submit-media" style="background: #f1f5f9; color: #475569; box-shadow: none;">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>