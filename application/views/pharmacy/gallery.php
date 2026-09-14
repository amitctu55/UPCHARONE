<style>
:root {
    --navy: #043d5b;
    --navy-dark: #022335;
    --cyan: #00a8ff;
    --teal: #0d9488;
    --teal-dark: #0f766e;
    --card-border: #e2e8f0;
    --text-slate: #1e293b;
    --text-muted: #64748b;
}

.gallery-page-wrapper {
    padding: 24px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--text-slate);
}

/* Page Header */
.gallery-page-header {
    background: #ffffff;
    border: 1px solid var(--card-border);
    border-radius: 14px;
    padding: 22px 28px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.gallery-title-area h2 {
    margin: 0 0 6px 0;
    font-size: 22px;
    font-weight: 700;
    color: var(--navy);
    display: flex;
    align-items: center;
    gap: 10px;
}

.gallery-title-area p {
    margin: 0;
    font-size: 13.5px;
    color: var(--text-muted);
}

.gallery-stat-badge {
    background: #f0fdfa;
    border: 1px solid #99f6e4;
    color: var(--teal-dark);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Upload Card */
.gallery-card {
    background: #ffffff;
    border: 1px solid var(--card-border);
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    margin-bottom: 28px;
    overflow: hidden;
}

.gallery-card-header {
    padding: 18px 24px;
    border-bottom: 1px solid var(--card-border);
    background: #fafafa;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.gallery-card-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: var(--navy);
    display: flex;
    align-items: center;
    gap: 10px;
}

.gallery-card-body {
    padding: 24px;
}

/* Form Controls */
.form-group-custom {
    margin-bottom: 20px;
}

.form-label-custom {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}

.form-label-custom span.req {
    color: #ef4444;
    margin-left: 2px;
}

.form-control-custom {
    width: 100%;
    height: 44px;
    padding: 10px 14px;
    font-size: 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background-color: #ffffff;
    color: #1e293b;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-control-custom:focus {
    border-color: #0d9488;
    outline: none;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
}

textarea.form-control-custom {
    height: auto;
    min-height: 85px;
    resize: vertical;
}

/* Modern File Dropzone */
.file-dropzone-wrapper {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    background: #f8fafc;
    padding: 24px;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
}

.file-dropzone-wrapper:hover,
.file-dropzone-wrapper.dragover {
    border-color: #0d9488;
    background: #f0fdfa;
}

.file-dropzone-wrapper input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 10;
}

.dropzone-content i {
    font-size: 34px;
    color: #0d9488;
    margin-bottom: 8px;
}

.dropzone-title {
    font-size: 14.5px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 4px;
}

.dropzone-hint {
    font-size: 12.5px;
    color: #64748b;
}

.file-preview-box {
    margin-top: 14px;
    display: none;
    align-items: center;
    gap: 12px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 14px;
    text-align: left;
}

.file-preview-box img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.file-preview-info {
    flex: 1;
    overflow: hidden;
}

.file-preview-name {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}

.file-preview-size {
    font-size: 11.5px;
    color: #64748b;
}

/* Button Group */
.form-actions-bar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid #f1f5f9;
}

.btn-upload-submit {
    background: #0d9488;
    color: #ffffff;
    border: none;
    padding: 11px 26px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(13, 148, 136, 0.25);
}

.btn-upload-submit:hover {
    background: #0f766e;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(13, 148, 136, 0.35);
}

.btn-upload-reset {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
    padding: 11px 22px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.btn-upload-reset:hover {
    background: #e2e8f0;
    color: #1e293b;
}

/* Gallery Showcase Grid */
.showcase-header {
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.showcase-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: var(--navy);
    display: flex;
    align-items: center;
    gap: 10px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.gallery-item-card {
    background: #ffffff;
    border: 1px solid var(--card-border);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.gallery-item-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
}

.gallery-item-media {
    position: relative;
    width: 100%;
    height: 190px;
    background: #f1f5f9;
    overflow: hidden;
}

.gallery-item-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item-card:hover .gallery-item-media img {
    transform: scale(1.04);
}

.gallery-item-date {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.65);
    color: #ffffff;
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 6px;
    backdrop-filter: blur(4px);
}

.gallery-item-body {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.gallery-item-title {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--navy);
    margin: 0 0 6px 0;
    line-height: 1.3;
}

.gallery-item-desc {
    font-size: 12.5px;
    color: #64748b;
    margin: 0 0 14px 0;
    line-height: 1.45;
    flex: 1;
}

.gallery-item-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}

.btn-delete-photo {
    color: #ef4444;
    background: #fef2f2;
    border: 1px solid #fee2e2;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-delete-photo:hover {
    background: #ef4444;
    color: #ffffff;
    border-color: #ef4444;
    text-decoration: none;
}

.gallery-empty-state {
    text-align: center;
    padding: 48px 20px;
    background: #ffffff;
    border: 1px dashed #cbd5e1;
    border-radius: 12px;
    grid-column: 1 / -1;
}

.gallery-empty-state i {
    font-size: 42px;
    color: #94a3b8;
    margin-bottom: 12px;
}

.gallery-empty-state h4 {
    margin: 0 0 6px 0;
    font-size: 16px;
    font-weight: 600;
    color: #334155;
}

.gallery-empty-state p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

@media (max-width: 768px) {
    .gallery-page-wrapper {
        padding: 16px;
    }
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="gallery-page-wrapper">

    <!-- Flash Messages -->
    <?php if (!empty($flashmsg)): ?>
        <?=$flashmsg;?>
    <?php elseif ($this->session->flashdata('flashmsg')): ?>
        <?=$this->session->flashdata('flashmsg');?>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="gallery-page-header">
        <div class="gallery-title-area">
            <h2><i class="fa fa-picture-o text-cyan" style="color: #0d9488;"></i> Medical &amp; Pharmacy Gallery</h2>
            <p>Upload and showcase photos of your pharmacy storefront, dispensing counter, storage, and verified certifications.</p>
        </div>
        <div>
            <span class="gallery-stat-badge">
                <i class="fa fa-image"></i>
                <span><?=count($gallery ?? []);?> Uploaded Photos</span>
            </span>
        </div>
    </div>

    <!-- Modern Card-Based Upload Form -->
    <div class="gallery-card">
        <div class="gallery-card-header">
            <h3><i class="fa fa-cloud-upload" style="color: #0d9488;"></i> Upload New Gallery Photo</h3>
            <small class="text-muted" style="font-size: 12px;">JPG, PNG, WEBP &bull; Max 5MB</small>
        </div>
        <div class="gallery-card-body">
            <form action="<?=base_url('pharmacy/gallery');?>" method="post" enctype="multipart/form-data" id="galleryUploadForm">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label-custom" for="shot_desc">
                                Short Title / Label <span class="req">*</span>
                            </label>
                            <input type="text" class="form-control-custom" id="shot_desc" name="shot" placeholder="e.g. Front Storefront / Medicine Dispensing Counter" required>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom" for="long_desc">
                                Detailed Description / Caption
                            </label>
                            <textarea class="form-control-custom" id="long_desc" name="long" rows="3" placeholder="Add an informative note or detail regarding this facility or credential..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label-custom">
                                Choose Image File <span class="req">*</span>
                            </label>

                            <div class="file-dropzone-wrapper" id="dropzoneBox">
                                <input type="file" id="uploadimage" name="uploadimage" accept="image/jpeg,image/png,image/webp,image/jpg" required onchange="handleFileSelect(this)">
                                <div class="dropzone-content">
                                    <i class="fa fa-cloud-upload"></i>
                                    <div class="dropzone-title">Click to browse or drag photo here</div>
                                    <div class="dropzone-hint">Supports high-res JPG, PNG, WEBP (Up to 5MB)</div>
                                </div>
                            </div>

                            <div class="file-preview-box" id="filePreviewBox">
                                <img id="previewImg" src="" alt="Selected Preview">
                                <div class="file-preview-info">
                                    <div class="file-preview-name" id="previewFileName">filename.jpg</div>
                                    <div class="file-preview-size" id="previewFileSize">0 KB</div>
                                </div>
                                <button type="button" class="btn btn-sm btn-link text-danger" onclick="clearFileSelection()" title="Remove selection">
                                    <i class="fa fa-times-circle" style="font-size: 16px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions-bar">
                    <button type="submit" name="submit" value="1" class="btn-upload-submit">
                        <i class="fa fa-check"></i> Add Photo to Gallery
                    </button>
                    <button type="reset" class="btn-upload-reset" onclick="clearFileSelection()">
                        <i class="fa fa-refresh"></i> Reset Form
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Gallery Showcase Grid Section -->
    <div class="showcase-header">
        <h3><i class="fa fa-th-large" style="color: #0d9488;"></i> Published Gallery Showcase</h3>
        <span class="text-muted" style="font-size: 13px;">Showing all active photos</span>
    </div>

    <div class="gallery-grid">
        <?php if (!empty($gallery) && count($gallery) > 0): ?>
            <?php foreach ($gallery as $item): ?>
                <?php 
                    $imgUrl = admin_url('public/assets/upload/' . $item->image);
                    $dateFormatted = !empty($item->date) ? date('d M, Y', strtotime($item->date)) : 'Recent';
                    $shortTitle = !empty($item->shot_description) ? $item->shot_description : 'Store Facility Photo';
                    $longDesc = !empty($item->long_description) ? $item->long_description : 'No detailed description provided.';
                ?>
                <div class="gallery-item-card">
                    <div class="gallery-item-media">
                        <img src="<?=$imgUrl;?>" alt="<?=html_escape($shortTitle);?>" onerror="this.src='<?=base_url('images/logo.png');?>'; this.style.objectFit='contain';">
                        <span class="gallery-item-date"><i class="fa fa-clock-o"></i> <?=$dateFormatted;?></span>
                    </div>
                    <div class="gallery-item-body">
                        <h4 class="gallery-item-title"><?=html_escape($shortTitle);?></h4>
                        <p class="gallery-item-desc"><?=html_escape($longDesc);?></p>
                        <div class="gallery-item-actions">
                            <a href="<?=$imgUrl;?>" target="_blank" class="btn btn-xs btn-default" style="font-size:11.5px; border-radius:5px;">
                                <i class="fa fa-expand"></i> View Full
                            </a>
                            <a href="<?=base_url('pharmacy/gallery_delete/' . $item->id);?>" class="btn-delete-photo" onclick="return confirm('Are you sure you want to remove this photo from your gallery?');">
                                <i class="fa fa-trash-o"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="gallery-empty-state">
                <i class="fa fa-picture-o"></i>
                <h4>No Gallery Photos Uploaded Yet</h4>
                <p>Upload high-resolution images of your storefront, counters, and licenses using the form above to build trust with patients and doctors.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewFileName').textContent = file.name;
            document.getElementById('previewFileSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
            document.getElementById('filePreviewBox').style.display = 'flex';
        };

        reader.readAsDataURL(file);
    }
}

function clearFileSelection() {
    var fileInput = document.getElementById('uploadimage');
    if (fileInput) fileInput.value = '';
    var previewBox = document.getElementById('filePreviewBox');
    if (previewBox) previewBox.style.display = 'none';
}
</script>
