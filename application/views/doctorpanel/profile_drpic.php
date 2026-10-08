<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-teal-light: #e6f7f5;
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
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.32);
    transform: translateY(-1px);
}

.btn-secondary-action {
    background: #ffffff;
    color: #475569 !important;
    font-weight: 600;
    font-size: 13.5px;
    border-radius: 8px;
    padding: 11px 20px;
    border: 1px solid var(--upchar-border);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-secondary-action:hover {
    background: #f8fafc;
    color: #1e293b !important;
}

/* Upload Dropzone */
.dropzone-box {
    border: 2px dashed #cbd5e1;
    border-radius: 14px;
    background: #f8fafc;
    padding: 36px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.dropzone-box:hover, .dropzone-box.dragover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
}

.dropzone-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #e6fffa;
    color: var(--upchar-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto 16px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.15);
}

/* Image Preview Container */
.preview-img-container {
    display: none;
    text-align: center;
    margin-top: 14px;
    padding: 16px;
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 12px;
}

.preview-thumb {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e2e8f0;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

/* Sidebar Live Profile Preview */
.live-preview-box {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    text-align: center;
}

.live-avatar-wrap {
    position: relative;
    width: 110px;
    height: 110px;
    margin: 0 auto 14px;
}

.live-avatar-img {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--upchar-teal);
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.2);
}

.live-verified-badge {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 28px;
    height: 28px;
    background: #0284c7;
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    border: 2px solid #ffffff;
}

/* Guidelines checklist */
.guide-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 12px;
    font-size: 12.5px;
    color: #334155;
    line-height: 1.5;
}
.guide-item i {
    font-size: 14px;
    color: #16a34a;
    margin-top: 2px;
    flex-shrink: 0;
}
</style>

<div class="profile-page-wrap">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 0;">

        <!-- Header Title Banner -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 22px; gap: 14px;">
            <div>
                <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">
                    Professional Display Photograph
                </h1>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">
                    A clean, professional display photo builds patient connection and increases appointment bookings by 4x.
                </p>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="<?=base_url('profile_about');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                    <i class="fa fa-arrow-left"></i> Back to Step 4
                </a>
            </div>
        </div>

        <!-- 5-Step Roadmap Stepper Bar -->
        <div class="stepper-wrap hidden-xs">
            <!-- Step 1: Completed -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Basic Profile</div>
                    <span class="step-sub">Completed</span>
                </div>
            </div>
            <!-- Step 2: Completed -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Registration</div>
                    <span class="step-sub">License Verified</span>
                </div>
            </div>
            <!-- Step 3: Completed -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Qualifications</div>
                    <span class="step-sub">Degrees &amp; Alma Mater</span>
                </div>
            </div>
            <!-- Step 4: Completed -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Bio &amp; Summary</div>
                    <span class="step-sub">Clinical Intro</span>
                </div>
            </div>
            <!-- Step 5: Active -->
            <div class="step-item active">
                <div class="step-circle">5</div>
                <div>
                    <div class="step-label">Display Photo</div>
                    <span class="step-sub">Profile Avatar</span>
                </div>
            </div>
        </div>

        <!-- Server-Side Flash Alert (Fallback) -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Client-Side AJAX Alert Container -->
        <div id="drpicAlertContainer" style="display: none; margin-bottom: 20px;"></div>

        <div class="row">
            <!-- Form Box (Left 8 Cols) -->
            <div class="col-md-8 col-xs-12">
                <div class="card-custom">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                            <i class="fa fa-camera" style="color: var(--upchar-teal); margin-right: 6px;"></i> Step 5: Upload Doctor Display Photo
                        </h3>
                        <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">
                            Upload your passport-style headshot or clinical portrait. Supported formats: JPG, PNG, WebP (Max 5MB).
                        </p>
                    </div>

                    <div style="padding: 26px 24px;">
                        <form id="profileDrpicForm" action="<?=base_url('doctorpanel/update_drpic');?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" class="csrf-token" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="is_ajax" value="1">

                            <!-- Current Uploaded Photo Status -->
                            <?php 
                            $has_existing = !empty($src) && (
                                file_exists('admin1947/public/assets/upload/' . $src) || 
                                file_exists(FCPATH . 'admin1947/public/assets/upload/' . $src)
                            );
                            $existing_url = $has_existing 
                                ? base_url('admin1947/public/assets/upload/' . $src) 
                                : base_url('assets/images/dummydr.jpg');
                            ?>

                            <?php if ($has_existing): ?>
                                <div style="display: flex; align-items: center; gap: 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 18px; margin-bottom: 22px;">
                                    <img src="<?=$existing_url;?>" alt="Current Photo" style="width: 54px; height: 54px; border-radius: 50%; object-fit: cover; border: 2px solid #16a34a;">
                                    <div>
                                        <div style="font-size: 13px; font-weight: 700; color: #166534;">
                                            <i class="fa fa-check-circle"></i> Current Profile Photo Uploaded
                                        </div>
                                        <span style="font-size: 11.5px; color: #475569;">
                                            File: <?=htmlspecialchars($src);?> &bull; You may upload a new photo below to replace it, or proceed.
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Interactive Drag & Drop Box -->
                            <div class="dropzone-box" id="drpicDropzone" onclick="document.getElementById('drImageInput').click();">
                                <input type="file" name="images" id="drImageInput" accept="image/jpeg,image/png,image/webp" style="display: none;">
                                <div class="dropzone-icon">
                                    <i class="fa fa-cloud-upload"></i>
                                </div>
                                <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 6px;">
                                    Click or Drag &amp; Drop Photo Here
                                </h4>
                                <p style="font-size: 12.5px; color: #64748b; margin: 0 0 10px;">
                                    Supports JPG, PNG, and WebP (Up to 5 MB)
                                </p>
                                <button type="button" class="btn btn-sm btn-default" style="font-weight: 700; border-radius: 7px; color: var(--upchar-teal); border-color: #b2ece5; background: #ffffff;">
                                    <i class="fa fa-folder-open-o"></i> Browse Files
                                </button>
                            </div>

                            <!-- Live Client-Side Image Selection Preview -->
                            <div id="selectedImagePreview" class="preview-img-container">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                    <span style="font-size: 12px; font-weight: 800; color: #0f172a;">
                                        <i class="fa fa-eye text-teal"></i> Selected Image Preview
                                    </span>
                                    <button type="button" class="btn btn-xs btn-default" onclick="clearSelectedImage();" style="color: #ef4444; border-color: #fca5a5;">
                                        <i class="fa fa-trash"></i> Remove
                                    </button>
                                </div>
                                <img id="previewImgElement" class="preview-thumb" src="#" alt="Preview">
                                <div id="previewFileInfo" style="margin-top: 10px; font-size: 12px; font-weight: 600; color: #475569;"></div>
                            </div>

                            <!-- Transparency & Quality Alert -->
                            <div style="background: #f8fafc; border: 1px solid var(--upchar-border); border-radius: 10px; padding: 14px 18px; margin-top: 22px; margin-bottom: 24px; display: flex; gap: 14px; align-items: flex-start;">
                                <i class="fa fa-shield" style="font-size: 20px; color: var(--upchar-teal); margin-top: 2px;"></i>
                                <div style="font-size: 12px; color: #475569; line-height: 1.5;">
                                    <strong>Patient Trust Guarantee:</strong>
                                    Display photos are automatically optimized for crisp rendering on retina displays and mobile apps. Images are watermarked in public preview caches to protect practitioner likeness.
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 18px; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px;">
                                <a href="<?=base_url('profile_about');?>" class="btn-secondary-action">
                                    <i class="fa fa-arrow-left"></i> Back to Step 4 (Bio)
                                </a>

                                <button type="submit" id="btnUploadDrPic" class="btn-primary-action">
                                    <span id="btnUploadText"><?= $has_existing ? 'Save & Continue to ID Proofs' : 'Upload & Continue to ID Proofs'; ?></span>
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Information Cards (Right 4 Cols) -->
            <div class="col-md-4 col-xs-12">

                <!-- Live Doctor Badge Simulation -->
                <div class="live-preview-box" style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">
                            Public Card Simulation
                        </span>
                        <span style="font-size: 10.5px; font-weight: 800; color: #0284c7; background: #e0f2fe; padding: 2px 8px; border-radius: 12px;">
                            Patient View
                        </span>
                    </div>

                    <div class="live-avatar-wrap">
                        <img id="liveSidebarAvatar" src="<?=$existing_url;?>" alt="Doctor Avatar" class="live-avatar-img">
                        <div class="live-verified-badge" title="Verified Practitioner">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>

                    <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 2px;">
                        Dr. <?=htmlspecialchars($this->session->userdata('drusername') ?: (@$data->fname . ' ' . @$data->lname));?>
                    </h4>
                    <p style="font-size: 12px; color: var(--upchar-teal); font-weight: 700; margin: 0 0 10px;">
                        Verified Medical Specialist
                    </p>

                    <div style="background: #f8fafc; border-radius: 8px; padding: 10px 12px; font-size: 11.5px; color: #64748b; line-height: 1.5;">
                        <i class="fa fa-mobile-phone fa-lg"></i> Appears in Upchar search results, patient appointment confirmation cards, and digital Rx headers.
                    </div>
                </div>

                <!-- Guidelines Card -->
                <div class="card-custom" style="padding: 22px; margin-bottom: 20px;">
                    <div style="display: flex; gap: 12px; align-items: flex-start; margin-bottom: 14px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #e6fffa; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;">
                            <i class="fa fa-check-square-o"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0;">Photo Standards</h4>
                            <p style="font-size: 11.5px; color: #64748b; margin: 2px 0 0 0;">Tips for a professional presence</p>
                        </div>
                    </div>

                    <div class="guide-item">
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Professional Attire:</strong> Wear a formal clinic coat, apron, or professional business attire.</span>
                    </div>
                    <div class="guide-item">
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Clean Background:</strong> Solid white, light grey, or clinical office backgrounds work best.</span>
                    </div>
                    <div class="guide-item">
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Frontal Portrait:</strong> Look straight at the camera with a warm, welcoming expression.</span>
                    </div>
                    <div class="guide-item">
                        <i class="fa fa-check-circle"></i>
                        <span><strong>Avoid Group Shots:</strong> Ensure you are the sole person in the frame; avoid heavy filters or sunglasses.</span>
                    </div>
                </div>

                <!-- Engagement Stat Card -->
                <div class="card-custom" style="padding: 18px 22px; background: linear-gradient(135deg, #043d5b 0%, #00a896 100%); color: #ffffff;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fa fa-line-chart" style="font-size: 26px; color: #a7f3d0;"></i>
                        <div>
                            <div style="font-size: 18px; font-weight: 800;">4x Higher Bookings</div>
                            <p style="font-size: 11.5px; margin: 2px 0 0 0; opacity: 0.9;">
                                Healthcare profiles with verified photos receive significantly higher patient engagement on Upchar.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
var hasExistingPhoto = <?= $has_existing ? 'true' : 'false'; ?>;

// Clear Selected Local Image
function clearSelectedImage() {
    $('#drImageInput').val('');
    $('#selectedImagePreview').slideUp(200);
    $('#drpicDropzone').slideDown(200);
    var defaultUrl = "<?= $has_existing ? $existing_url : base_url('assets/images/dummydr.jpg'); ?>";
    $('#liveSidebarAvatar').attr('src', defaultUrl);
    if (hasExistingPhoto) {
        $('#btnUploadText').text('Save & Continue to ID Proofs');
    } else {
        $('#btnUploadText').text('Upload & Continue to ID Proofs');
    }
}

// Handle File Selection
function handleFileSelect(file) {
    if (!file) return;

    var validTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (validTypes.indexOf(file.type) === -1) {
        alert('Please choose a valid JPG, PNG, or WebP image file.');
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        alert('The selected file exceeds 5 MB. Please choose a smaller file.');
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var dataUrl = e.target.result;
        $('#previewImgElement').attr('src', dataUrl);
        $('#liveSidebarAvatar').attr('src', dataUrl);
        var sizeKb = Math.round(file.size / 1024);
        $('#previewFileInfo').html(
            '<span style="color:#0f172a; font-weight:700;">' + file.name + '</span> (' + sizeKb + ' KB)'
        );
        $('#drpicDropzone').slideUp(150);
        $('#selectedImagePreview').slideDown(200);
        $('#btnUploadText').text('Upload & Continue to ID Proofs');
    };
    reader.readAsDataURL(file);
}

$(document).ready(function() {

    // File input change
    $('#drImageInput').on('change', function(e) {
        if (this.files && this.files[0]) {
            handleFileSelect(this.files[0]);
        }
    });

    // Drag and Drop Effects
    var $dropzone = $('#drpicDropzone');
    $dropzone.on('dragover dragenter', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $dropzone.addClass('dragover');
    });

    $dropzone.on('dragleave dragend drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $dropzone.removeClass('dragover');
    });

    $dropzone.on('drop', function(e) {
        var dt = e.originalEvent.dataTransfer;
        if (dt && dt.files && dt.files[0]) {
            $('#drImageInput')[0].files = dt.files;
            handleFileSelect(dt.files[0]);
        }
    });

    // AJAX Form Submission
    $('#profileDrpicForm').on('submit', function(e) {
        e.preventDefault();

        var form = this;
        var formData = new FormData(form);
        var $btn = $('#btnUploadDrPic');
        var $alert = $('#drpicAlertContainer');

        $alert.hide().empty();

        // Button loading state
        var origHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Uploading Photo...');

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);

                if (res.csrf_hash) {
                    $('.csrf-token').val(res.csrf_hash);
                }

                if (res.status === 'success') {
                    if (res.image_url) {
                        $('#liveSidebarAvatar').attr('src', res.image_url);
                    }

                    $alert.html(
                        '<div class="alert alert-success alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<i class="fa fa-check-circle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                            res.message +
                            ' <span style="font-size: 12px; font-weight: normal; margin-left: 6px;">Proceeding to Step 6...</span>' +
                        '</div>'
                    ).slideDown(200);

                    setTimeout(function() {
                        window.location.href = res.next_step || '<?=base_url("profile_idproof");?>';
                    }, 1100);
                } else {
                    var errMsg = res.message || 'Unable to upload photo. Please try again.';
                    $alert.html(
                        '<div class="alert alert-danger alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<i class="fa fa-exclamation-triangle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                            errMsg +
                        '</div>'
                    ).slideDown(200);

                    $('html, body').animate({
                        scrollTop: $alert.offset().top - 80
                    }, 300);
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(origHtml);
                $alert.html(
                    '<div class="alert alert-danger alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<i class="fa fa-exclamation-triangle" style="font-size: 16px; margin-right: 6px;"></i> A network error occurred while uploading. Please check file size and try again.' +
                    '</div>'
                ).slideDown(200);
            }
        });
    });

});
</script>