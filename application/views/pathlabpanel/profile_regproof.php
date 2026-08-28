<?php include ("assets/includes/header_pathlab.php"); ?>
<?php include ("assets/includes/leftmenu_pathlab.php"); ?>

<style>
.pathlab-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    margin-bottom: 25px;
    overflow: hidden;
}
.pathlab-card-header {
    background: linear-gradient(135deg, #1d2a44 0%, #295771 100%);
    color: #ffffff;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pathlab-card-title {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pathlab-card-body {
    padding: 24px;
}

/* Stepper Progress Bar */
.pathlab-stepper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 24px;
    border: 1px solid #e2e8f0;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.stepper-step {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    font-weight: 600;
    color: #94a3b8;
    position: relative;
}
.stepper-step.completed {
    color: #059669;
}
.stepper-step.active {
    color: #00a896;
}
.stepper-bubble {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    border: 2px solid #cbd5e1;
    transition: all 0.2s ease;
}
.stepper-step.completed .stepper-bubble {
    background: #d1fae5;
    color: #059669;
    border-color: #10b981;
}
.stepper-step.active .stepper-bubble {
    background: #00a896;
    color: #ffffff;
    border-color: #00a896;
    box-shadow: 0 0 0 4px rgba(0, 168, 150, 0.2);
}
.stepper-divider {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
    margin: 0 12px;
}
.stepper-divider.active {
    background: #00a896;
}

/* Upload Dropzone */
.file-upload-dropzone {
    border: 2px dashed #00a896;
    border-radius: 12px;
    background: #f0fdfa;
    padding: 30px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}
.file-upload-dropzone:hover, .file-upload-dropzone.dragover {
    background: #ccfbf1;
    border-color: #028072;
}
.file-upload-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
.upload-icon-circle {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #ffffff;
    color: #00a896;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 12px;
    box-shadow: 0 3px 10px rgba(0, 168, 150, 0.15);
}

.acceptable-list {
    list-style: none;
    padding: 0;
    margin: 16px 0 0 0;
}
.acceptable-list li {
    font-size: 13px;
    color: #475569;
    padding: 5px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.acceptable-list li i {
    color: #10b981;
}

/* Preview Box */
.preview-card-box {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 20px;
    text-align: center;
}
.preview-img-container {
    max-height: 280px;
    overflow: hidden;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}
.preview-img-container img {
    max-height: 260px;
    width: auto;
    object-fit: contain;
}
</style>

<div class="pag_cstm" style="padding: 22px 25px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                        <i class="fa fa-certificate" style="color: #00a896;"></i> Medical / Pathology Registration Proof
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0;">Upload your official state medical council or pathology registration certificate.</p>
                </div>
                <div>
                    <a href="<?=base_url('pathlabpanel/profile_drpic');?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 8px; padding: 8px 18px;">
                        <i class="fa fa-arrow-left"></i> Previous Step
                    </a>
                </div>
            </div>

            <!-- Stepper Progress Bar -->
            <div class="pathlab-stepper hidden-xs">
                <div class="stepper-step completed">
                    <div class="stepper-bubble"><i class="fa fa-check"></i></div>
                    <span>1. Basic Profile</span>
                </div>
                <div class="stepper-divider active"></div>
                <div class="stepper-step completed">
                    <div class="stepper-bubble"><i class="fa fa-check"></i></div>
                    <span>2. Lab Ownership Proof</span>
                </div>
                <div class="stepper-divider active"></div>
                <div class="stepper-step completed">
                    <div class="stepper-bubble"><i class="fa fa-check"></i></div>
                    <span>3. Lab Logo / Pic</span>
                </div>
                <div class="stepper-divider active"></div>
                <div class="stepper-step active">
                    <div class="stepper-bubble">4</div>
                    <span>4. Registration Proof</span>
                </div>
            </div>

            <!-- Flash Message Alerts -->
            <?php 
                $flashmsg = $this->session->flashdata('flashmsg');
                if(!empty($flashmsg)) {
                    echo $flashmsg;
                }
            ?>

            <div class="row">
                <!-- Left Form Column -->
                <div class="col-md-7">
                    <div class="pathlab-card">
                        <div class="pathlab-card-header">
                            <h3 class="pathlab-card-title">
                                <i class="fa fa-cloud-upload"></i> Upload Registration Certificate
                            </h3>
                            <span style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px;">Step 4 of 4</span>
                        </div>
                        <div class="pathlab-card-body">
                            <form action="<?=base_url('pathlabpanel/profile_regproof');?>" method="post" enctype="multipart/form-data">
                                
                                <label class="path-form-label" style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 10px; display: block;">
                                    Select Registration Certificate File <span style="color: #ef4444;">*</span>
                                </label>

                                <!-- Drag & Drop File Upload Box -->
                                <div class="file-upload-dropzone" id="dropzone-box">
                                    <input type="file" name="images" id="regproof_input" class="file-upload-input" accept="image/*,.pdf" <?=(empty($src) ? 'required' : '');?> onchange="handleFilePreview(this)">
                                    <div class="upload-icon-circle">
                                        <i class="fa fa-certificate"></i>
                                    </div>
                                    <h4 style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">
                                        Click here or Drag & Drop certificate to upload
                                    </h4>
                                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                                        Supported formats: JPG, PNG, JPEG, PDF (Max size: 5 MB)
                                    </p>
                                    <div id="file-name-display" style="margin-top: 10px; font-size: 13px; font-weight: 700; color: #00a896; display: none;"></div>
                                </div>

                                <div style="margin-top: 20px; background: #f8fafc; border-radius: 10px; padding: 16px; border: 1px solid #e2e8f0;">
                                    <p style="font-size: 13px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">
                                        <i class="fa fa-info-circle" style="color: #00a896;"></i> Acceptable Medical &amp; Clinical Licenses
                                    </p>
                                    <ul class="acceptable-list">
                                        <li><i class="fa fa-check-circle"></i> State Medical Council Registration Certificate</li>
                                        <li><i class="fa fa-check-circle"></i> National Medical Commission (NMC/MCI) Registration</li>
                                        <li><i class="fa fa-check-circle"></i> Clinical Establishment Act (CEA) Registration License</li>
                                    </ul>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px; pt-3; border-top: 1px solid #e2e8f0; padding-top: 18px;">
                                    <a href="<?=base_url('pathlabpanel/profile_drpic');?>" class="btn btn-default" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; font-weight: 600; border-radius: 8px; padding: 9px 20px;">
                                        <i class="fa fa-arrow-left"></i> Previous Step
                                    </a>
                                    
                                    <button type="submit" name="submit" class="btn" style="background: #00a896; color: #ffffff; font-weight: 700; border-radius: 8px; padding: 9px 24px; box-shadow: 0 3px 10px rgba(0,168,150,0.25);">
                                        Complete Profile <i class="fa fa-check-circle" style="margin-left: 6px;"></i>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Document Preview Column -->
                <div class="col-md-5">
                    <div class="preview-card-box">
                        <div style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 12px; display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <i class="fa fa-file-text-o" style="color: #00a896;"></i> Current Registration Document
                        </div>

                        <div class="preview-img-container" id="preview-container">
                            <?php if(!empty($src)): ?>
                                <img src="<?=base_url('admin1947/public/assets/upload/'.$src);?>" id="preview-image" alt="Medical Registration Certificate">
                            <?php else: ?>
                                <div id="no-preview-placeholder" style="padding: 40px 10px; color: #94a3b8;">
                                    <i class="fa fa-certificate" style="font-size: 42px; margin-bottom: 10px; color: #cbd5e1; display: block;"></i>
                                    <span style="font-size: 13px; font-weight: 600;">No Registration Document Uploaded Yet</span>
                                    <p style="font-size: 11.5px; margin: 4px 0 0 0; color: #94a3b8;">Select a file to preview before saving.</p>
                                </div>
                                <img src="" id="preview-image" alt="Registration Preview" style="display: none;">
                            <?php endif; ?>
                        </div>

                        <?php if(!empty($src)): ?>
                            <div style="margin-top: 12px; display: inline-flex; align-items: center; gap: 6px; background: #d1fae5; color: #065f46; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px;">
                                <i class="fa fa-check-circle"></i> Registration Certificate Saved
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
function handleFilePreview(input) {
    const file = input.files[0];
    const previewImage = document.getElementById('preview-image');
    const placeholder = document.getElementById('no-preview-placeholder');
    const fileNameDisplay = document.getElementById('file-name-display');

    if (file) {
        fileNameDisplay.innerHTML = '<i class="fa fa-paperclip"></i> Selected: ' + file.name;
        fileNameDisplay.style.display = 'block';

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            if (placeholder) {
                placeholder.innerHTML = '<i class="fa fa-file-pdf-o" style="font-size: 48px; color: #ef4444; margin-bottom: 10px; display: block;"></i>' +
                    '<span style="font-size: 13px; font-weight: 700; color: #1e293b;">PDF Certificate Selected</span><br>' +
                    '<small style="color: #64748b;">' + file.name + '</small>';
                placeholder.style.display = 'block';
            }
            previewImage.style.display = 'none';
        }
    }
}
</script>

<?php include ("assets/includes/footer_hospital.php"); ?>
