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

.news-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Header Card */
.news-header-card {
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

.news-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.news-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-view-news {
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

.btn-view-news:hover {
    background: #e2e8f0;
    color: #0f172a !important;
    transform: translateY(-1px);
}

/* Layout Grid */
.news-layout-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    align-items: start;
}

@media (max-width: 992px) {
    .news-layout-grid {
        grid-template-columns: 1fr;
    }
}

.news-form-card {
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
    height: 110px;
    resize: vertical;
    line-height: 1.5;
}

/* Type Toggle Buttons */
.media-type-toggle {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
}

.media-type-pill {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
    cursor: pointer;
    text-align: center;
    font-weight: 700;
    font-size: 13.5px;
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.media-type-pill:hover {
    border-color: #cbd5e1;
    background: #ffffff;
}

.media-type-pill.active {
    border-color: #00a896;
    background: #f0fdfa;
    color: #0d9488;
}

/* Dropzone & Preview */
.file-dropzone-box {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 26px 20px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
}

.file-dropzone-box:hover, .file-dropzone-box.dragover {
    border-color: #00a896;
    background: #f0fdfa;
}

.file-dropzone-box i.upload-icon {
    font-size: 34px;
    color: #00a896;
    display: block;
    margin-bottom: 8px;
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

/* Video Live Preview */
.video-preview-box {
    display: none;
    margin-top: 14px;
    border-radius: 10px;
    overflow: hidden;
    background: #000000;
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
}

.video-preview-box iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

.btn-publish-news {
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

.btn-publish-news:hover {
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
    <div class="news-page-wrap">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="news-header-card">
            <div>
                <h1>
                    <i class="fa fa-pencil-square-o" style="color: #00a896;"></i>
                    Create Announcement or Press Release
                </h1>
                <p>Broadcast upcoming health checkup camps, OPD specialist schedules, free medical services, or patient bulletins.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/managenews');?>" class="btn-view-news">
                    <i class="fa fa-newspaper-o"></i> View All Announcements
                </a>
            </div>
        </div>

        <div class="news-layout-grid">

            <!-- Main Form Card -->
            <div class="news-form-card">
                <div class="card-header-bar">
                    <i class="fa fa-bullhorn"></i> Announcement Details
                </div>

                <div class="card-body-wrap">
                    <form id="newsPublishForm" action="<?=base_url('hospitalpanel/news');?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        <input type="hidden" name="type" id="newsTypeHidden" value="1">

                        <!-- Headline -->
                        <div class="form-group-field">
                            <label>Announcement Headline / Title <span class="req">*</span></label>
                            <input type="text" class="ctrl-input" name="name" id="newsTitleInput" placeholder="e.g. Free Comprehensive Cardiac Screening Camp on Sunday, 10 AM to 4 PM" required maxlength="150">
                            <span style="font-size: 11.5px; color: #94a3b8; display: block; margin-top: 4px;">Clear and compelling headline for the public event (max 150 characters).</span>
                        </div>

                        <!-- Description -->
                        <div class="form-group-field">
                            <label>Announcement Body / Full Details <span class="req">*</span></label>
                            <textarea class="ctrl-input" name="description" id="newsDescInput" placeholder="Detail the event schedule, participating specialist doctors, test inclusions (e.g. ECG, Blood Sugar, Consultation), registration contact numbers, and venue..." required></textarea>
                            <span style="font-size: 11.5px; color: #94a3b8; display: block; margin-top: 4px;">Explain timings, pre-registration requirements, and venue directions.</span>
                        </div>

                        <!-- Media Format Selection -->
                        <div class="form-group-field">
                            <label>Media Attachment Type <span class="req">*</span></label>
                            <div class="media-type-toggle">
                                <div class="media-type-pill active" id="pillImage" onclick="selectMediaType(1);">
                                    <i class="fa fa-file-image-o"></i> Banner / Poster Image
                                </div>
                                <div class="media-type-pill" id="pillVideo" onclick="selectMediaType(2);">
                                    <i class="fa fa-video-camera"></i> Video URL (YouTube / Vimeo)
                                </div>
                            </div>
                        </div>

                        <!-- Image Section -->
                        <div class="form-group-field" id="imageSection">
                            <label>Upload Event Poster / Banner <span class="req">*</span></label>
                            
                            <div class="file-dropzone-box" id="dropzoneBox" onclick="document.getElementById('newsFileInput').click();">
                                <i class="fa fa-file-image-o upload-icon"></i>
                                <div style="font-weight: 700; color: #0f172a; font-size: 14px;" id="dropzoneText">
                                    Drag &amp; drop banner image, or <span style="color: #00a896; text-decoration: underline;">Browse</span>
                                </div>
                                <span style="font-size: 12px; color: #94a3b8; display: block; margin-top: 4px;">
                                    Supports JPG, PNG, WEBP (Max 10 MB)
                                </span>
                            </div>

                            <input type="file" id="newsFileInput" name="uploadimage" accept="image/jpeg,image/png,image/webp,image/jpg" style="display: none;" onchange="handleFileSelect(this);">

                            <div class="file-preview-wrap" id="filePreviewWrap">
                                <img id="previewImg" class="file-preview-img" src="" alt="Selected Banner">
                                <div class="file-preview-details">
                                    <p class="file-name" id="previewFileName">poster.jpg</p>
                                    <p class="file-meta" id="previewFileMeta">0 KB</p>
                                </div>
                                <button type="button" class="btn-remove-file" onclick="removeSelectedFile();">
                                    <i class="fa fa-times"></i> Remove
                                </button>
                            </div>
                        </div>

                        <!-- Video Section -->
                        <div class="form-group-field" id="videoSection" style="display: none;">
                            <label>Video Stream Link <span class="req">*</span></label>
                            <input type="url" class="ctrl-input" name="video_url" id="videoUrlInput" placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/..." oninput="handleVideoUrlInput(this.value);">
                            <span style="font-size: 11.5px; color: #94a3b8; display: block; margin-top: 4px;">Paste YouTube or Vimeo URL to stream directly on your hospital portal announcement.</span>
                            
                            <div class="video-preview-box" id="videoPreviewBox">
                                <iframe id="videoPreviewFrame" src="" allowfullscreen></iframe>
                            </div>
                        </div>

                        <div style="margin-top: 28px; display: flex; gap: 14px; align-items: center;">
                            <button type="submit" name="submit" id="submitBtn" class="btn-publish-news">
                                <i class="fa fa-paper-plane"></i> Publish Announcement
                            </button>
                            <button type="reset" class="btn-view-news" onclick="resetForm();">
                                Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Guidelines Sidebar -->
            <div class="tips-sidebar-card">
                <h3><i class="fa fa-lightbulb-o" style="color: #f59e0b;"></i> Announcement Ideas</h3>
                <ul class="tips-list">
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Free Health Camps:</strong> Share date, venue, and free tests (Blood pressure, BMI, ECG, sugar test) to attract local footfall.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Visiting Specialists:</strong> Announce days when visiting super-specialist surgeons or oncologists conduct OPD consultations.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>New Departments:</strong> Announce the launch of new dialysis wings, advanced laparoscopy units, or NICU wards.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Video Walkthroughs:</strong> Share YouTube links explaining treatment procedures, patient testimonials, or doctor health talks.</span>
                    </li>
                    <li>
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Instant Patient Visibility:</strong> Published announcements are live on the hospital's dedicated page on the Upchar network.</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
var activeType = 1;

function selectMediaType(type) {
    activeType = type;
    document.getElementById('newsTypeHidden').value = type;

    if (type === 1) {
        document.getElementById('pillImage').classList.add('active');
        document.getElementById('pillVideo').classList.remove('active');
        document.getElementById('imageSection').style.display = 'block';
        document.getElementById('videoSection').style.display = 'none';
        document.getElementById('newsFileInput').required = true;
        document.getElementById('videoUrlInput').required = false;
    } else {
        document.getElementById('pillVideo').classList.add('active');
        document.getElementById('pillImage').classList.remove('active');
        document.getElementById('imageSection').style.display = 'none';
        document.getElementById('videoSection').style.display = 'block';
        document.getElementById('newsFileInput').required = false;
        document.getElementById('videoUrlInput').required = true;
    }
}

// Initial state
selectMediaType(1);

// Drag & Drop
var dropzone = document.getElementById('dropzoneBox');
var fileInput = document.getElementById('newsFileInput');

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

        if (file.size > 10 * 1024 * 1024) {
            alert('Selected banner is larger than 10MB. Please choose an image under 10MB.');
            removeSelectedFile();
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewFileName').innerText = file.name;
            var sizeStr = file.size > 1024 * 1024 ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' : (file.size / 1024).toFixed(1) + ' KB';
            document.getElementById('previewFileMeta').innerText = sizeStr + ' • Ready to publish';
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

function handleVideoUrlInput(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);
    var previewBox = document.getElementById('videoPreviewBox');
    var iframe = document.getElementById('videoPreviewFrame');

    if (match && match[2].length == 11) {
        iframe.src = 'https://www.youtube.com/embed/' + match[2];
        previewBox.style.display = 'block';
    } else {
        var vimeoMatch = url.match(/(?:vimeo)\.com.*(?:videos|video|channels|)\/([\d]+)/i);
        if (vimeoMatch && vimeoMatch[1]) {
            iframe.src = 'https://player.vimeo.com/video/' + vimeoMatch[1];
            previewBox.style.display = 'block';
        } else {
            previewBox.style.display = 'none';
            iframe.src = '';
        }
    }
}

function resetForm() {
    removeSelectedFile();
    document.getElementById('videoPreviewBox').style.display = 'none';
    document.getElementById('videoPreviewFrame').src = '';
    selectMediaType(1);
}

// Loading spinner on submit
document.getElementById('newsPublishForm').addEventListener('submit', function() {
    var btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Publishing...';
    btn.disabled = true;
});
</script>
