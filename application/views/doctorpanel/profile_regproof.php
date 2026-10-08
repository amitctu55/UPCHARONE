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
    padding: 16px 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    overflow-x: auto;
}

.step-item {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
    flex: 1;
    min-width: 130px;
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
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.35);
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
    font-size: 12.5px;
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

/* Main Card */
.card-custom {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
    overflow: hidden;
}

/* Buttons */
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
    gap: 7px;
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

.btn-outline-action {
    background: #f8fafc;
    color: var(--upchar-teal) !important;
    font-weight: 600;
    font-size: 13px;
    border-radius: 8px;
    padding: 11px 18px;
    border: 1px solid #b2ece5;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-outline-action:hover {
    background: #e6f7f5;
    color: var(--upchar-teal-dark) !important;
}

/* Document Type Selector Chips */
.doc-type-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 22px;
}

.doc-type-pill {
    cursor: pointer;
    border: 1.5px solid #e2e8f0;
    background: #ffffff;
    border-radius: 9px;
    padding: 8px 14px;
    font-size: 12.5px;
    font-weight: 600;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.doc-type-pill:hover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
    color: var(--upchar-teal);
}

.doc-type-pill.active {
    border-color: var(--upchar-teal);
    background: #e6f7f5;
    color: var(--upchar-teal-dark);
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.15);
}

.doc-type-pill input[type="radio"] {
    display: none;
}

/* Dropzone */
.dropzone-box {
    border: 2px dashed #cbd5e1;
    border-radius: 14px;
    background: #f8fafc;
    padding: 34px 20px;
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
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #e6fffa;
    color: var(--upchar-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin: 0 auto 14px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.15);
}

/* Document Preview Box */
.doc-preview-card {
    display: none;
    margin-top: 18px;
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 12px;
    padding: 16px 20px;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
}

.doc-preview-thumb {
    width: 58px;
    height: 58px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #cbd5e1;
}

.doc-pdf-icon {
    width: 58px;
    height: 58px;
    border-radius: 8px;
    background: #fef2f2;
    color: #dc2626;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    border: 1px solid #fee2e2;
}

/* Existing Doc Banner */
.existing-doc-banner {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Right Info Cards */
.info-sidebar-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    margin-bottom: 20px;
}

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
    color: #10b981;
    margin-top: 3px;
    flex-shrink: 0;
}

.guide-item-warn i {
    color: #f59e0b;
    margin-top: 3px;
    flex-shrink: 0;
}

/* Security Trust Badge */
.security-badge {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: 10px;
    padding: 12px 14px;
    margin-top: 16px;
}
</style>

<div class="profile-page-wrap">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto;">

        <!-- Header Title & Subtitle -->
        <div style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h2 style="font-size: 21px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        Medical Practice &amp; License Verification
                    </h2>
                    <p style="font-size: 13px; color: #64748b; margin: 0;">
                        Step 8 of 8 &bull; State Medical Council / Clinical Establishment Proof for Dr. <?=htmlspecialchars($this->session->userdata('drusername') ? $this->session->userdata('drusername') : 'Doctor');?>
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="<?=base_url('doctor-dashboard');?>" class="btn btn-default btn-sm" style="border-radius: 7px; font-weight: 600;">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Stepper Navigation -->
        <div class="stepper-wrap hidden-xs">
            <!-- Step 1 -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Basic Profile</div>
                    <span class="step-sub">Completed</span>
                </div>
            </div>
            <!-- Step 2 -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Registration</div>
                    <span class="step-sub">License Verified</span>
                </div>
            </div>
            <!-- Step 3 -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Qualifications</div>
                    <span class="step-sub">Degrees &amp; Alma Mater</span>
                </div>
            </div>
            <!-- Step 4 -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Bio &amp; Summary</div>
                    <span class="step-sub">Clinical Intro</span>
                </div>
            </div>
            <!-- Step 5 -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Display Photo</div>
                    <span class="step-sub">Profile Avatar</span>
                </div>
            </div>
            <!-- Step 6 -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">Identity Proof</div>
                    <span class="step-sub">Govt Photo ID</span>
                </div>
            </div>
            <!-- Step 7 -->
            <div class="step-item completed">
                <div class="step-circle"><i class="fa fa-check"></i></div>
                <div>
                    <div class="step-label">MCI Proof</div>
                    <span class="step-sub">Council Certificate</span>
                </div>
            </div>
            <!-- Step 8: Active -->
            <div class="step-item active">
                <div class="step-circle">8</div>
                <div>
                    <div class="step-label">Practice Proof</div>
                    <span class="step-sub">Final Step</span>
                </div>
            </div>
        </div>

        <!-- Flash Alert Fallback -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Client Alert Container -->
        <div id="regProofAlertContainer" style="display: none; margin-bottom: 20px;"></div>

        <div class="row">
            <!-- Left Form Box (8 Cols) -->
            <div class="col-md-8 col-xs-12">
                <div class="card-custom">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                            <i class="fa fa-shield" style="color: var(--upchar-teal); margin-right: 6px;"></i> Upload Clinical Registration / Additional Practice Proof
                        </h3>
                        <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">
                            Upload your state clinical registration, postgraduate qualification certificate, or periodic council renewal receipt to complete verification.
                        </p>
                    </div>

                    <div style="padding: 26px 24px;">
                        <form id="profileRegProofForm" action="<?=base_url('doctorpanel/update_regproof');?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" class="csrf-token" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="is_ajax" value="1">

                            <!-- Current Document Status (if on file) -->
                            <?php 
                            $has_existing = !empty($src) && (
                                file_exists('admin1947/public/assets/upload/' . $src) || 
                                file_exists(FCPATH . 'admin1947/public/assets/upload/' . $src)
                            );
                            $existing_ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
                            $existing_url = base_url('admin1947/public/assets/upload/' . $src);
                            ?>

                            <?php if ($has_existing): ?>
                                <div class="existing-doc-banner">
                                    <div style="display: flex; align-items: center; gap: 14px;">
                                        <?php if ($existing_ext === 'pdf'): ?>
                                            <div class="doc-pdf-icon" style="width: 48px; height: 48px; font-size: 22px;">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </div>
                                        <?php else: ?>
                                            <img src="<?=$existing_url;?>" alt="Current Document" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1.5px solid #86efac;">
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-size: 13.5px; font-weight: 700; color: #166534;">
                                                <i class="fa fa-check-circle"></i> Medical Practice Proof Document On File
                                            </div>
                                            <span style="font-size: 11.5px; color: #475569;">
                                                File: <?=htmlspecialchars($src);?> (<?=strtoupper($existing_ext);?>)
                                            </span>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                        <a href="<?=$existing_url;?>" target="_blank" class="btn btn-sm btn-default" style="font-weight: 600; border-radius: 7px; color: #0f172a;">
                                            <i class="fa fa-external-link"></i> View Document
                                        </a>
                                        <a href="<?=base_url('managepractice');?>" class="btn btn-sm btn-success" style="font-weight: 700; border-radius: 7px; background: #16a34a; border: none;">
                                            Proceed to Practice &rarr;
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Document Category Quick-Selector -->
                            <div style="margin-bottom: 16px;">
                                <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block;">
                                    Select Document Category:
                                </label>
                                <div class="doc-type-pills">
                                    <label class="doc-type-pill active">
                                        <input type="radio" name="doc_category" value="State Medical Council" checked>
                                        <i class="fa fa-certificate"></i> State Medical Council Certificate
                                    </label>
                                    <label class="doc-type-pill">
                                        <input type="radio" name="doc_category" value="PG Additional Degree">
                                        <i class="fa fa-graduation-cap"></i> PG / Additional Degree Registration
                                    </label>
                                    <label class="doc-type-pill">
                                        <input type="radio" name="doc_category" value="Clinical Establishment">
                                        <i class="fa fa-hospital-o"></i> Clinical Establishment License
                                    </label>
                                    <label class="doc-type-pill">
                                        <input type="radio" name="doc_category" value="Renewal Receipt">
                                        <i class="fa fa-refresh"></i> Council Renewal / Good Standing
                                    </label>
                                </div>
                            </div>

                            <!-- Interactive Drag & Drop Box -->
                            <div class="dropzone-box" id="regProofDropzone" onclick="document.getElementById('regProofFileInput').click();">
                                <input type="file" name="images" id="regProofFileInput" accept="image/jpeg,image/png,image/webp,application/pdf" style="display: none;">
                                <div class="dropzone-icon">
                                    <i class="fa fa-cloud-upload"></i>
                                </div>
                                <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 6px;">
                                    Click or Drag &amp; Drop Registration Document Here
                                </h4>
                                <p style="font-size: 12.5px; color: #64748b; margin: 0 0 12px;">
                                    Supports PDF, JPG, PNG, and WebP files (Up to 10 MB)
                                </p>
                                <button type="button" class="btn btn-sm btn-default" style="font-weight: 700; border-radius: 7px; color: var(--upchar-teal); border-color: #b2ece5; background: #ffffff;">
                                    <i class="fa fa-folder-open-o"></i> Browse Document
                                </button>
                            </div>

                            <!-- Real-time Selected File Preview Card -->
                            <div class="doc-preview-card" id="regPreviewCard">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <img id="imagePreviewThumb" class="doc-preview-thumb" src="" alt="Selected Document" style="display: none;">
                                    <div id="pdfPreviewIcon" class="doc-pdf-icon" style="display: none;">
                                        <i class="fa fa-file-pdf-o"></i>
                                    </div>
                                    <div>
                                        <div id="selectedFileName" style="font-size: 13.5px; font-weight: 700; color: #0f172a;">
                                            medical-proof.pdf
                                        </div>
                                        <span id="selectedFileSize" style="font-size: 12px; color: #64748b;">
                                            0.0 KB
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-xs btn-default text-danger" id="removeSelectedFileBtn" style="font-weight: 600; border-radius: 6px; border-color: #fca5a5; color: #dc2626;">
                                        <i class="fa fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>

                            <!-- Bottom Action Buttons -->
                            <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                                <div>
                                    <a href="<?=base_url('mci_proof');?>" class="btn-secondary-action">
                                        <i class="fa fa-arrow-left"></i> Back: MCI Proof
                                    </a>
                                </div>

                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <?php if ($has_existing): ?>
                                        <a href="<?=base_url('managepractice');?>" class="btn-outline-action hidden-xs">
                                            Keep Current &amp; Setup Practice &rarr;
                                        </a>
                                    <?php endif; ?>

                                    <button type="submit" id="regProofSubmitBtn" class="btn-primary-action">
                                        <i class="fa fa-check-circle"></i> Complete Verification &amp; Finish <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Verification Guidelines (4 Cols) -->
            <div class="col-md-4 col-xs-12">
                <!-- Trust & Verification Card -->
                <div class="info-sidebar-card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0;">
                                Final Verification Step
                            </h4>
                            <span style="font-size: 11px; color: #64748b;">
                                Practice Authorization &amp; Activation
                            </span>
                        </div>
                    </div>

                    <p style="font-size: 12.5px; color: #475569; line-height: 1.6; margin: 0 0 14px 0;">
                        Upon submitting your practice certificate, your profile will be queued for expedited administrative approval. You may now proceed directly to configure your clinical practice schedule and consultation fees.
                    </p>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 14px;">
                        <h5 style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin: 0 0 10px 0;">
                            What Happens Next:
                        </h5>
                        <div class="guide-item">
                            <i class="fa fa-check-circle"></i>
                            <div><strong>Practice Timings:</strong> Setup your daily consultation slots and OPD hours.</div>
                        </div>
                        <div class="guide-item">
                            <i class="fa fa-check-circle"></i>
                            <div><strong>Consultation Fees:</strong> Set in-clinic and video consultation charges.</div>
                        </div>
                        <div class="guide-item">
                            <i class="fa fa-check-circle"></i>
                            <div><strong>Hospital Affiliation:</strong> Link your profile to visiting hospitals &amp; clinics.</div>
                        </div>
                        <div class="guide-item">
                            <i class="fa fa-check-circle"></i>
                            <div><strong>Live Activation:</strong> Profile badge displayed to 2.5M+ patients on Upchar.</div>
                        </div>
                    </div>
                </div>

                <!-- Security Assurance Card -->
                <div class="info-sidebar-card">
                    <h4 style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin: 0 0 12px 0;">
                        <i class="fa fa-shield" style="color: var(--upchar-teal); margin-right: 6px;"></i> Upchar Medical Trust
                    </h4>

                    <p style="font-size: 12.5px; color: #475569; line-height: 1.5; margin: 0 0 10px 0;">
                        Only verified practitioners receive booking authorizations and digital prescription capabilities. Your credentials safeguard patient well-being and clinical integrity.
                    </p>

                    <div class="security-badge">
                        <i class="fa fa-lock" style="font-size: 20px; color: var(--upchar-teal);"></i>
                        <div style="font-size: 11.5px; color: #475569; line-height: 1.4;">
                            <strong>HIPAA &amp; DISHA Compliant:</strong> Documents are stored in encrypted cloud vaults with strict access protocols.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<script>
$(document).ready(function() {
    var $dropzone    = $('#regProofDropzone');
    var $fileInput   = $('#regProofFileInput');
    var $previewCard = $('#regPreviewCard');
    var $imgThumb    = $('#imagePreviewThumb');
    var $pdfIcon     = $('#pdfPreviewIcon');
    var $fileName    = $('#selectedFileName');
    var $fileSize    = $('#selectedFileSize');
    var $removeBtn   = $('#removeSelectedFileBtn');
    var $form        = $('#profileRegProofForm');
    var $btn         = $('#regProofSubmitBtn');
    var $alert       = $('#regProofAlertContainer');

    // Document Category Pill selector
    $('.doc-type-pill').on('click', function() {
        $('.doc-type-pill').removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Drag and Drop Effects
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
        if (dt && dt.files && dt.files.length) {
            $fileInput[0].files = dt.files;
            handleFileSelection(dt.files[0]);
        }
    });

    $fileInput.on('change', function() {
        if (this.files && this.files[0]) {
            handleFileSelection(this.files[0]);
        }
    });

    function handleFileSelection(file) {
        var validTypes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
        var ext = file.name.split('.').pop().toLowerCase();
        var validExts = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];

        if (validExts.indexOf(ext) === -1) {
            showErrorAlert('Please upload a valid document file: PDF, JPG, PNG, or WebP.');
            resetFileInput();
            return;
        }

        if (file.size > 10 * 1024 * 1024) {
            showErrorAlert('The selected file size exceeds the 10 MB limit. Please compress and re-upload.');
            resetFileInput();
            return;
        }

        $fileName.text(file.name);
        $fileSize.text((file.size / 1024).toFixed(1) + ' KB');

        if (ext === 'pdf') {
            $imgThumb.hide();
            $pdfIcon.show();
            $previewCard.css('display', 'flex');
        } else {
            var reader = new FileReader();
            reader.onload = function(e) {
                $imgThumb.attr('src', e.target.result).show();
                $pdfIcon.hide();
                $previewCard.css('display', 'flex');
            };
            reader.readAsDataURL(file);
        }

        $dropzone.css('border-color', 'var(--upchar-teal)');
    }

    $removeBtn.on('click', function(e) {
        e.stopPropagation();
        resetFileInput();
    });

    function resetFileInput() {
        $fileInput.val('');
        $imgThumb.attr('src', '').hide();
        $pdfIcon.hide();
        $previewCard.hide();
        $dropzone.css('border-color', '#cbd5e1');
    }

    function showErrorAlert(msg) {
        $alert.html(
            '<div class="alert alert-danger alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<i class="fa fa-exclamation-triangle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                msg +
            '</div>'
        ).slideDown(200);

        $('html, body').animate({
            scrollTop: $alert.offset().top - 80
        }, 300);
    }

    // AJAX Submission Handler
    $form.on('submit', function(e) {
        e.preventDefault();

        var fileInputElem = $fileInput[0];
        var hasNewFile = fileInputElem.files && fileInputElem.files.length > 0;
        var hasExistingOnServer = <?=$has_existing ? 'true' : 'false';?>;

        if (!hasNewFile && !hasExistingOnServer) {
            showErrorAlert('Please select your Medical Registration Proof document before proceeding.');
            return false;
        }

        var formData = new FormData(this);
        var origBtnHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Uploading &amp; Finalizing...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(res) {
                $btn.prop('disabled', false).html(origBtnHtml);

                if (res.csrf_hash) {
                    $('.csrf-token').val(res.csrf_hash);
                }

                if (res.status === 'success') {
                    $alert.html(
                        '<div class="alert alert-success alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<i class="fa fa-check-circle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                            res.message +
                            ' <span style="font-size: 12px; font-weight: normal; margin-left: 6px;">Proceeding to Clinical Practice Setup...</span>' +
                        '</div>'
                    ).slideDown(200);

                    setTimeout(function() {
                        window.location.href = res.next_step || '<?=base_url("managepractice");?>';
                    }, 1100);
                } else {
                    var errMsg = res.message || 'Unable to upload document. Please check the file and try again.';
                    showErrorAlert(errMsg);
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(origBtnHtml);
                showErrorAlert('A network or server error occurred during upload. Please verify file format and try again.');
            }
        });
    });

});
</script>
