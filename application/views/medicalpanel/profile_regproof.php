<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include ("assets/includes/header_medical.php"); ?>
<?php include ("assets/includes/leftmenu_medical.php"); ?>

<style>
.kyc-container {
    padding: 24px;
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: #1e293b;
}

.kyc-header-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 22px 26px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.kyc-header-title h2 {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.kyc-header-title p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.step-indicator-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 6px 14px;
    border-radius: 30px;
}

.step-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
}

.step-item.active {
    color: #00a8ff;
}

.step-item.completed {
    color: #10b981;
}

.step-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
}

.step-item.active .step-circle {
    background: #00a8ff;
    color: #ffffff;
}

.step-item.completed .step-circle {
    background: #10b981;
    color: #ffffff;
}

.kyc-panel-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-bottom: 24px;
}

.dropzone-upload-box {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 32px 20px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.dropzone-upload-box:hover {
    border-color: #00a8ff;
    background: #f0f9ff;
}

.upload-icon-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #e0f2fe;
    color: #0284c7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin: 0 auto 14px;
}

.preview-container {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
}

.preview-image {
    max-height: 240px;
    max-width: 100%;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
</style>

<div class="kyc-container">

    <!-- Top Header & Step Progress -->
    <div class="kyc-header-card">
        <div class="kyc-header-title">
            <h2>
                <i class="fa fa-certificate" style="color: #10b981;"></i> Retail Drug License &amp; Council Registration
            </h2>
            <p>Step 2 of 2: State Pharmacy Council Registration &amp; Form 20/21 Retail Drug License Proof</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator-bar">
            <div class="step-item completed">
                <span class="step-circle"><i class="fa fa-check"></i></span>
                <span>Identity Proof</span>
            </div>
            <i class="fa fa-angle-right" style="color: #cbd5e1;"></i>
            <div class="step-item active">
                <span class="step-circle">2</span>
                <span>Drug License</span>
            </div>
            <i class="fa fa-angle-right" style="color: #cbd5e1;"></i>
            <div class="step-item">
                <span class="step-circle"><i class="fa fa-clock-o"></i></span>
                <span>Verification</span>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('flashmsg')): ?>
        <?= $this->session->flashdata('flashmsg'); ?>
    <?php endif; ?>

    <!-- Main Upload Grid -->
    <div class="row">
        <div class="col-md-7">
            <div class="kyc-panel-card" style="padding: 24px;">
                <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 6px;">
                    Upload Retail Drug License Document
                </h4>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">
                    Please upload a clear scan or photograph of your Store Drug License Certificate (Form 20 / 21) issued by the State Food &amp; Drug Authority.
                </p>

                <form action="<?= base_url('medicalpanel/profile_regproof2'); ?>" method="post" enctype="multipart/form-data" id="drugLicenseForm">
                    <div class="dropzone-upload-box" onclick="$('#regProofInput').trigger('click');">
                        <div class="upload-icon-circle" style="background: #ecfdf5; color: #059669;">
                            <i class="fa fa-medkit"></i>
                        </div>
                        <h5 style="font-weight: 700; color: #0f172a; margin: 0 0 6px; font-size: 15px;">
                            Click to select Drug License or drag &amp; drop
                        </h5>
                        <p style="font-size: 12px; color: #64748b; margin: 0 0 10px;">
                            Supports JPG, PNG, JPEG or PDF (Maximum size: 10 MB)
                        </p>
                        <span class="badge" style="background: #e2e8f0; color: #475569; font-weight: 600; font-size: 11px; padding: 4px 10px;">
                            Browse Local Device
                        </span>
                        <input type="file" name="images" id="regProofInput" accept=".jpg,.jpeg,.png,.pdf" style="display: none;" onchange="handleRegFileSelect(this);" required>
                    </div>

                    <!-- Selected file info strip -->
                    <div id="fileSelectedStrip" style="display: none; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 10px 14px; margin-top: 14px; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-file-text-o text-success" style="font-size: 16px;"></i>
                            <span id="selectedFileName" style="font-weight: 600; font-size: 13px; color: #065f46;">drug_license.pdf</span>
                        </div>
                        <span class="badge" style="background: #10b981; color: #fff;">Ready to Upload</span>
                    </div>

                    <!-- Live Preview Area -->
                    <div id="imageLivePreview" style="display: none; margin-top: 16px; text-align: center;">
                        <p style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 6px;">NEW LICENSE PREVIEW:</p>
                        <img id="previewImgTag" src="" style="max-height: 220px; max-width: 100%; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 28px; padding-top: 20px; border-top: 1px solid #e2e8f0; flex-wrap: wrap; gap: 10px;">
                        <a href="<?= base_url('medicalpanel/profile_idproof2'); ?>" class="btn btn-default" style="font-weight: 600; border-radius: 8px; padding: 9px 18px; font-size: 13px;">
                            <i class="fa fa-arrow-left"></i> Back to Step 1
                        </a>
                        <button type="submit" name="submit" value="1" class="btn btn-success" style="background: #10b981; border: none; font-weight: 700; border-radius: 8px; padding: 9px 24px; font-size: 13px;">
                            <i class="fa fa-check-circle"></i> Complete KYC &amp; Submit &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: Existing Document & Guidelines -->
        <div class="col-md-5">

            <!-- Current Document Card -->
            <div class="kyc-panel-card" style="padding: 22px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <strong style="font-size: 14px; color: #0f172a;">Current Drug License Proof</strong>
                    <?php if (!empty($src)): ?>
                        <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 700; font-size: 11px;">
                            <i class="fa fa-check-circle"></i> License Uploaded
                        </span>
                    <?php else: ?>
                        <span class="badge" style="background: #fef3c7; color: #b45309; font-weight: 700; font-size: 11px;">
                            <i class="fa fa-clock-o"></i> Pending Upload
                        </span>
                    <?php endif; ?>
                </div>

                <div class="preview-container">
                    <?php if (!empty($src)): ?>
                        <?php 
                        $fileExt = strtolower(pathinfo($src, PATHINFO_EXTENSION));
                        $fileUrl = base_url('admin1947/public/assets/upload/' . $src);
                        ?>
                        <?php if ($fileExt === 'pdf'): ?>
                            <div style="padding: 30px 10px;">
                                <i class="fa fa-file-pdf-o" style="font-size: 54px; color: #ef4444; margin-bottom: 12px;"></i>
                                <div style="font-weight: 700; font-size: 13px; color: #0f172a; word-break: break-all;"><?= htmlspecialchars($src); ?></div>
                                <a href="<?= $fileUrl; ?>" target="_blank" class="btn btn-xs btn-primary" style="margin-top: 10px; border-radius: 4px; font-weight: bold;">
                                    <i class="fa fa-external-link"></i> Open PDF License
                                </a>
                            </div>
                        <?php else: ?>
                            <img src="<?= $fileUrl; ?>" class="preview-image" alt="Store Drug License" onerror="this.onerror=null; this.src='<?=base_url('images/no-image.png');?>';">
                            <div style="margin-top: 10px;">
                                <a href="<?= $fileUrl; ?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600; border-radius: 4px;">
                                    <i class="fa fa-search-plus"></i> View Full Resolution
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="padding: 36px 14px; color: #94a3b8;">
                            <i class="fa fa-certificate" style="font-size: 42px; margin-bottom: 10px; display: block;"></i>
                            <p style="margin: 0; font-size: 13px; font-weight: 600;">No Drug License uploaded yet.</p>
                            <small style="color: #64748b;">Upload your Form 20 or 21 Retail Drug License to activate online pharmacy order dispatch.</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mandatory Statutory Requirement Notice -->
            <div class="kyc-panel-card" style="padding: 20px;">
                <strong style="font-size: 13.5px; color: #0f172a; display: block; margin-bottom: 10px;">
                    <i class="fa fa-shield text-success"></i> Regulatory Compliance Notice
                </strong>
                <p style="font-size: 12px; color: #475569; margin: 0 0 10px; line-height: 1.6;">
                    In compliance with the <strong>Drugs and Cosmetics Act, 1940</strong> and <strong>Pharmacy Act, 1948</strong>, all medicine dispensations via UPCHAR must originate from verified chemist outlets managed by a registered pharmacist.
                </p>
                <ul style="padding-left: 20px; font-size: 12px; color: #64748b; margin: 0; line-height: 1.8;">
                    <li>Form 20 (Allopathic drugs retail license)</li>
                    <li>Form 21 (Specified Schedule C &amp; C(1) retail license)</li>
                    <li>State Pharmacy Council Registration Certificate</li>
                </ul>
            </div>

        </div>
    </div>

</div>

<script>
function handleRegFileSelect(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        $('#selectedFileName').text(file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)');
        $('#fileSelectedStrip').css('display', 'flex');

        if (file.type.match('image.*')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImgTag').attr('src', e.target.result);
                $('#imageLivePreview').slideDown();
            }
            reader.readAsDataURL(file);
        } else {
            $('#imageLivePreview').slideUp();
        }
    }
}
</script>

<?php include ("assets/includes/footer_medical.php"); ?>
