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

/* Page Header */
.gallery-header-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 22px 26px;
    margin-bottom: 24px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
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
    display: flex;
    align-items: center;
    gap: 10px;
}

.gallery-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-view-gallery {
    background: #f1f5f9;
    color: #334155 !important;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px 18px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.btn-view-gallery:hover {
    background: #e2e8f0;
    color: #0f172a !important;
    transform: translateY(-1px);
}

/* Form Layout Grid */
.gallery-layout-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    align-items: start;
}

@media (max-width: 992px) {
    .gallery-layout-grid {
        grid-template-columns: 1fr;
    }
}

.gallery-form-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.card-header-bar {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 18px 24px;
    color: #ffffff;
    font-size: 16px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-body-wrap {
    padding: 28px;
}

.form-group-field {
    margin-bottom: 22px;
}

.form-group-field label {
    display: block;
    font-size: 13.5px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

.form-group-field label span.req {
    color: #ef4444;
}

.ctrl-input {
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.15s ease;
    box-sizing: border-box;
}

.ctrl-input:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

textarea.ctrl-input {
    height: 100px;
    resize: vertical;
    line-height: 1.5;
}

/* Live Drag & Drop Zone */
.file-dropzone-box {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 28px 20px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.file-dropzone-box:hover, .file-dropzone-box.dragover {
    border-color: #00a896;
    background: #f0fdfa;
}

.file-dropzone-box i.upload-icon {
    font-size: 36px;
    color: #00a896;
    display: block;
    margin-bottom: 10px;
}

.file-preview-wrap {
    display: none;
    margin-top: 14px;
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 10px;
    padding: 12px 16px;
    align-items: center;
    gap: 14px;
}

.file-preview-img {
    width: 70px;
    height: 70px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #e2e8f0;
}

.file-preview-details {
    flex: 1;
    text-align: left;
}

.file-preview-details .file-name {
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 3px 0;
    word-break: break-all;
}

.file-preview-details .file-meta {
    font-size: 12px;
    color: #64748b;
    margin: 0;
}

.btn-remove-file {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.15s ease;
}

.btn-remove-file:hover {
    background: #dc2626;
    color: #ffffff;
}

.btn-submit-media {
    background: linear-gradient(135deg, #00a896 0%, #008f80 100%);
    color: #ffffff;
    font-weight: 800;
    font-size: 14px;
    padding: 12px 28px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
}

.btn-submit-media:hover {
    background: linear-gradient(135deg, #008f80 0%, #00776b 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
}

/* Tips Card */
.tips-sidebar-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
}

.tips-sidebar-card h3 {
    font-size: 16px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 14px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tips-list li {
    font-size: 13px;
    color: #475569;
    line-height: 1.5;
    margin-bottom: 12px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.tips-list li i {
    color: #00a896;
    margin-top: 3px;
    font-size: 14px;
    flex-shrink: 0;
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
                <h1>
                    <i class="fa fa-cloud-upload" style="color: #00a896;"></i>
                    Upload Hospital Media
                </h1>
                <p>Add high-resolution photography showcasing your clinical departments, diagnostic infrastructure, and patient rooms.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/managegallery');?>" class="btn-view-gallery">
                    <i class="fa fa-th-large"></i> View All Photos
                </a>
            </div>
        </div>

        <div class="gallery-layout-grid">

            <!-- Main Form Card -->
            <div class="gallery-form-card">
                <div class="card-header-bar">
                    <i class="fa fa-picture-o"></i> Facility Photo Details
                </div>

                <div class="card-body-wrap">
                    <form id="galleryUploadForm" action="<?=base_url('hospitalpanel/gallery');?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                        <div class="form-group-field">
                            <label>Short Title / Caption <span class="req">*</span></label>
                            <input type="text" class="ctrl-input" name="shot" id="captionInput" placeholder="e.g. Advanced ICU & Critical Care Unit" required maxlength="120">
                            <span style="font-size: 11.5px; color: #94a3b8; display: block; margin-top: 4px;">Brief headline displayed under the photo (max 120 characters).</span>
                        </div>

                        <div class="form-group-field">
                            <label>Detailed Description <span class="req">*</span></label>
                            <textarea class="ctrl-input" name="long" id="descInput" placeholder="Describe the technology, bed capacity, clinical capabilities, or key equipment shown in this photo..." required></textarea>
                            <span style="font-size: 11.5px; color: #94a3b8; display: block; margin-top: 4px;">Clear description to assist patients looking for specific treatment facilities.</span>
                        </div>

                        <div class="form-group-field">
                            <label>Select Photo <span class="req">*</span></label>

                            <!-- Dropzone Box -->
                            <div class="file-dropzone-box" id="dropzoneBox" onclick="document.getElementById('fileUploadInput').click();">
                                <i class="fa fa-cloud-upload upload-icon"></i>
                                <div style="font-weight: 700; color: #0f172a; font-size: 14px;" id="dropzoneText">
                                    Drag &amp; drop your image here, or <span style="color: #00a896; text-decoration: underline;">Browse</span>
                                </div>
                                <span style="font-size: 12px; color: #94a3b8; display: block; margin-top: 4px;">
                                    Supports JPG, PNG, WEBP (Max 10 MB)
                                </span>
                            </div>

                            <input type="file" id="fileUploadInput" name="uploadimage" accept="image/jpeg,image/png,image/webp,image/jpg" style="display: none;" required onchange="handleFileSelect(this);">

                            <!-- File Preview Container -->
                            <div class="file-preview-wrap" id="filePreviewWrap">
                                <img id="previewImg" class="file-preview-img" src="" alt="Selected Preview">
                                <div class="file-preview-details">
                                    <p class="file-name" id="previewFileName">filename.jpg</p>
                                    <p class="file-meta" id="previewFileMeta">0 KB</p>
                                </div>
                                <button type="button" class="btn-remove-file" onclick="removeSelectedFile();">
                                    <i class="fa fa-times"></i> Remove
                                </button>
                            </div>
                        </div>

                        <div style="margin-top: 28px; display: flex; gap: 14px; align-items: center;">
                            <button type="submit" name="submit" id="submitBtn" class="btn-submit-media">
                                <i class="fa fa-upload"></i> Upload to Gallery
                            </button>
                            <button type="reset" class="btn-view-gallery" onclick="removeSelectedFile();">
                                Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Guidelines Sidebar -->
            <div class="tips-sidebar-card">
                <h3><i class="fa fa-lightbulb-o" style="color: #f59e0b;"></i> Photography Guidelines</h3>
                <ul class="tips-list">
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Well-Lit Facilities:</strong> Capture rooms in bright, natural or clinical light showing clean environments.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Specialized Equipment:</strong> Include photos of MRI, CT scanners, modular operation theatres, and cardiac catheterization labs.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Patient Privacy:</strong> Ensure patient faces and confidential medical files are blurred or absent.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>High Resolution:</strong> Landscape orientation (16:9 or 4:3) with minimum 1280x720 pixels works best on patient displays.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Instant Sync:</strong> Once uploaded, this photo is immediately linked with your hospital profile page on the public Upchar portal.</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
var dropzone = document.getElementById('dropzoneBox');
var fileInput = document.getElementById('fileUploadInput');

// Drag & Drop event handlers
['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.add('dragover');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.remove('dragover');
    }, false);
});

dropzone.addEventListener('drop', function(e) {
    var dt = e.dataTransfer;
    var files = dt.files;
    if (files.length) {
        fileInput.files = files;
        handleFileSelect(fileInput);
    }
}, false);

function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];

        // Max 10MB
        if (file.size > 10 * 1024 * 1024) {
            alert('The selected image is larger than 10MB. Please choose an image under 10MB.');
            removeSelectedFile();
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewFileName').innerText = file.name;
            var sizeStr = file.size > 1024 * 1024 ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' : (file.size / 1024).toFixed(1) + ' KB';
            document.getElementById('previewFileMeta').innerText = sizeStr + ' • Ready to upload';
            document.getElementById('filePreviewWrap').style.display = 'flex';
            document.getElementById('dropzoneBox').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

function removeSelectedFile() {
    fileInput.value = '';
    document.getElementById('previewImg').src = '';
    document.getElementById('filePreviewWrap').style.display = 'none';
    document.getElementById('dropzoneBox').style.display = 'block';
}

// Loading state on submit
document.getElementById('galleryUploadForm').addEventListener('submit', function() {
    var btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading...';
    btn.disabled = true;
});
</script>
