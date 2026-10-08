<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<!-- Select2 CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

.form-label-bold {
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.form-control-modern {
    width: 100%;
    height: 44px;
    border-radius: 9px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #ffffff;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-control-modern:focus {
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.input-group-addon-modern {
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-right: none;
    border-radius: 9px 0 0 9px;
    color: #64748b;
    padding: 0 14px;
    display: flex;
    align-items: center;
    justify-content: center;
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

/* Select2 Enhancements for Multi-Select */
.select2-container--default .select2-selection--multiple {
    border: 1px solid var(--upchar-border);
    border-radius: 9px;
    min-height: 44px;
    padding: 3px 6px;
    font-size: 13px;
    transition: all 0.2s ease;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: var(--upchar-teal);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background: #e6f7f5;
    border: 1px solid #b2ece5;
    border-radius: 6px;
    color: var(--upchar-teal-dark);
    font-weight: 700;
    font-size: 12px;
    padding: 3px 8px;
    margin-top: 4px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: var(--upchar-teal-dark);
    margin-right: 5px;
    font-weight: bold;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #dc2626;
}

.select2-dropdown {
    border: 1px solid var(--upchar-border);
    border-radius: 9px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: var(--upchar-teal);
}

/* Quick selection tags */
.quick-tag {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 700;
    background: #f1f5f9;
    color: #475569;
    margin: 2px 3px 2px 0;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
    border: 1px solid #e2e8f0;
}

.quick-tag:hover {
    background: var(--upchar-teal-light);
    color: var(--upchar-teal-dark);
    border-color: #b2ece5;
}

.quick-tag.selected {
    background: var(--upchar-teal);
    color: #ffffff;
    border-color: var(--upchar-teal);
}

/* Live Profile Card Preview */
.doctor-preview-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 12px;
    padding: 18px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    position: relative;
}

.preview-badge-verified {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 10.5px;
    font-weight: 800;
    color: #0284c7;
    background: #e0f2fe;
    padding: 2px 8px;
    border-radius: 12px;
}

.exp-tier-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
}
</style>

<div class="profile-page-wrap">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 0;">

        <!-- Header Title Banner -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 22px; gap: 14px;">
            <div>
                <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">
                    Doctor Onboarding &amp; Verification
                </h1>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">
                    Complete Step 3 to showcase your medical degrees, alma mater, and clinical experience.
                </p>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="<?=base_url('profile_step2');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px; font-size: 13px;">
                    <i class="fa fa-arrow-left"></i> Back to Step 2
                </a>
            </div>
        </div>

        <!-- 4-Step Roadmap Stepper Bar -->
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
                    <div class="step-label">Medical Registration</div>
                    <span class="step-sub">License Verified</span>
                </div>
            </div>
            <!-- Step 3: Active -->
            <div class="step-item active">
                <div class="step-circle">3</div>
                <div>
                    <div class="step-label">Education &amp; Experience</div>
                    <span class="step-sub">Degrees &amp; Alma Mater</span>
                </div>
            </div>
            <!-- Step 4: Pending -->
            <div class="step-item pending">
                <div class="step-circle">4</div>
                <div>
                    <div class="step-label">Doctor Bio &amp; Photo</div>
                    <span class="step-sub">Public Profile</span>
                </div>
            </div>
        </div>

        <!-- Server-Side Flash Alert (Fallback) -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Client-Side AJAX Alert Container -->
        <div id="step3AlertContainer" style="display: none; margin-bottom: 20px;"></div>

        <div class="row">
            <!-- Form Box (Left 8 Cols) -->
            <div class="col-md-8 col-xs-12">
                <div class="card-custom">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: #ffffff;">
                        <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                            <i class="fa fa-graduation-cap" style="color: var(--upchar-teal); margin-right: 6px;"></i> Step 3: Education &amp; Clinical Experience
                        </h3>
                        <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">
                            Provide your medical degrees, graduating institute, and active clinical practice duration.
                        </p>
                    </div>

                    <div style="padding: 26px 24px;">
                        <form id="profileStep3Form" action="<?=base_url('doctorpanel/update_step3');?>" method="post">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" class="csrf-token" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="is_ajax" value="1">

                            <!-- Section A: Medical Qualifications (Multi-Select) -->
                            <div class="form-group" style="margin-bottom: 24px;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                                    <label class="form-label-bold" style="margin-bottom: 0;">
                                        Academic Degrees &amp; Qualifications *
                                    </label>
                                    <span style="font-size: 11.5px; color: var(--upchar-teal); font-weight: 600;">
                                        Select all that apply (e.g. MBBS, MD, DNB)
                                    </span>
                                </div>

                                <select class="form-control-modern" name="qualification[]" id="qualification_select" multiple="multiple" style="width: 100%;" required>
                                    <?php
                                    $active_degrees = isset($degrees) ? $degrees : $this->db->where('status', 1)->order_by('name', 'ASC')->get('master_degree')->result();
                                    $selected_quals = isset($data_qua) && is_array($data_qua) ? $data_qua : array();
                                    foreach(@$active_degrees as $deg):
                                        $is_selected = in_array($deg->id, $selected_quals);
                                    ?>
                                        <option value="<?=$deg->id;?>" <?=$is_selected ? 'selected' : '';?>>
                                            <?=htmlspecialchars(trim($deg->name));?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Quick Select Shortcut Pills -->
                                <div style="margin-top: 8px;">
                                    <span style="font-size: 11px; color: #64748b; font-weight: 600; margin-right: 6px;">
                                        Popular Degrees:
                                    </span>
                                    <?php
                                    $popular = array('MBBS', 'MD', 'MS', 'BDS', 'MDS', 'BAMS', 'BHMS', 'DNB', 'DM', 'MCh');
                                    foreach($popular as $pop):
                                    ?>
                                        <span class="quick-tag" data-degree="<?=$pop;?>">+ <?=$pop;?></span>
                                    <?php endforeach; ?>
                                </div>
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">
                                    Your degrees will be verified against your MCI/NMC state council certificate.
                                </span>
                            </div>

                            <!-- Section B: College / Institute -->
                            <div class="form-group" style="margin-bottom: 22px;">
                                <label class="form-label-bold">College / University / Medical Institute *</label>
                                <div style="display: flex;">
                                    <span class="input-group-addon-modern">
                                        <i class="fa fa-university"></i>
                                    </span>
                                    <input type="text" name="college" id="college_input" class="form-control-modern" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" value="<?=htmlspecialchars(@$data->college);?>" placeholder="e.g. All India Institute of Medical Sciences (AIIMS), New Delhi" required>
                                </div>
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">
                                    Enter the primary medical college where you completed your foundational degree or residency.
                                </span>
                            </div>

                            <!-- Section C: Year of Completion & Clinical Experience (2 Columns) -->
                            <div class="row" style="margin-bottom: 24px;">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label-bold">Year of Completion / Graduation *</label>
                                        <div style="display: flex;">
                                            <span class="input-group-addon-modern">
                                                <i class="fa fa-calendar-check-o"></i>
                                            </span>
                                            <select class="form-control-modern" name="year" id="year_select" style="border-top-left-radius: 0; border-bottom-left-radius: 0;" required>
                                                <option value="">-- Select Year --</option>
                                                <?php 
                                                $curYear = intval(date('Y'));
                                                for($y = $curYear; $y >= 1960; $y--):
                                                    $sel = (@$data->year == $y) ? 'selected' : '';
                                                ?>
                                                    <option value="<?=$y;?>" <?=$sel;?>><?=$y;?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">
                                            Year you earned your primary medical license/degree.
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                            <label class="form-label-bold">Years of Experience *</label>
                                            <span id="expBadgeLive" class="exp-tier-pill" style="display: none;">
                                                <i class="fa fa-stethoscope"></i> <span id="expBadgeText">Practitioner</span>
                                            </span>
                                        </div>
                                        <div style="display: flex;">
                                            <span class="input-group-addon-modern">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            <input type="number" name="exp" id="exp_input" class="form-control-modern" style="border-radius: 0;" min="0" max="75" value="<?=htmlspecialchars(@$data->exp);?>" placeholder="e.g. 10" required>
                                            <span style="background: #f8fafc; border: 1px solid var(--upchar-border); border-left: none; border-radius: 0 9px 9px 0; color: #64748b; padding: 0 14px; display: flex; align-items: center; font-size: 12px; font-weight: 600;">
                                                Years
                                            </span>
                                        </div>
                                        <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">
                                            Total active years since beginning clinical practice.
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Confidentiality & Verification Alert -->
                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 14px 18px; margin-bottom: 26px; display: flex; gap: 14px; align-items: flex-start;">
                                <i class="fa fa-shield" style="font-size: 20px; color: #16a34a; margin-top: 2px;"></i>
                                <div style="font-size: 12.5px; color: #166534; line-height: 1.5;">
                                    <strong>Transparent Academic Profile:</strong>
                                    Accurate qualifications establish patient confidence and increase booking conversion by up to 95%. Your verified degrees will be displayed on your digital prescription headers and public clinic pages.
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 18px; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px;">
                                <a href="<?=base_url('profile_step2');?>" class="btn-secondary-action">
                                    <i class="fa fa-arrow-left"></i> Back to Step 2
                                </a>

                                <button type="submit" id="btnSaveStep3" class="btn-primary-action">
                                    <span>Save &amp; Continue to Bio (Step 4)</span>
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Information Cards (Right 4 Cols) -->
            <div class="col-md-4 col-xs-12">

                <!-- Live Doctor Profile Card Preview -->
                <div class="doctor-preview-card" style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">
                            Public Card Preview
                        </span>
                        <span class="preview-badge-verified">
                            <i class="fa fa-check-circle"></i> Verified Doctor
                        </span>
                    </div>

                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div style="min-width: 0;">
                            <h4 style="font-size: 14.5px; font-weight: 800; color: #0f172a; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Dr. <?=htmlspecialchars($this->session->userdata('drusername') ?: (@$data->fname . ' ' . @$data->lname));?>
                            </h4>
                            <div id="previewDegrees" style="font-size: 12px; color: var(--upchar-teal); font-weight: 700; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Qualifications will appear here
                            </div>
                        </div>
                    </div>

                    <div style="background: #f8fafc; border-radius: 8px; padding: 10px 12px; font-size: 11.5px; color: #475569; line-height: 1.5;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span style="color: #64748b;">Experience:</span>
                            <strong id="previewExp" style="color: #0f172a;"><?=(@$data->exp ? @$data->exp . ' Years' : 'Not specified');?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span style="color: #64748b;">Alma Mater:</span>
                            <strong id="previewCollege" style="color: #0f172a; max-width: 150px; text-align: right; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?=(@$data->college ? htmlspecialchars(@$data->college) : 'Not specified');?>
                            </strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #64748b;">Completion:</span>
                            <strong id="previewYear" style="color: #0f172a;"><?=(@$data->year ? @$data->year : 'Not specified');?></strong>
                        </div>
                    </div>
                </div>

                <!-- Academic Credentialing & Trust Card -->
                <div class="card-custom" style="padding: 22px;">
                    <div style="display: flex; gap: 12px; align-items: flex-start; margin-bottom: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;">
                            <i class="fa fa-certificate"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0;">Why Education Matters</h4>
                            <p style="font-size: 11.5px; color: #64748b; margin: 2px 0 0 0;">Credibility &amp; Patient Trust</p>
                        </div>
                    </div>

                    <p style="font-size: 12px; color: #475569; line-height: 1.6; margin-bottom: 14px;">
                        Studies on Upchar show that patient booking rates correlate directly with documented qualifications and verified years of experience.
                    </p>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 12px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-size: 12px; color: #334155;">
                            <i class="fa fa-check text-success"></i>
                            <span>Displays on e-Prescriptions automatically</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-size: 12px; color: #334155;">
                            <i class="fa fa-check text-success"></i>
                            <span>Search filter by Specialist &amp; Degree</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #334155;">
                            <i class="fa fa-check text-success"></i>
                            <span>Syncs with Hospital &amp; Clinic Rosters</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Help / Support Card -->
                <div class="card-custom" style="padding: 18px 22px; background: #f8fafc;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa fa-question-circle" style="font-size: 20px; color: #64748b;"></i>
                        <div>
                            <h5 style="font-size: 13px; font-weight: 700; color: #0f172a; margin: 0;">Degree Not Listed?</h5>
                            <p style="font-size: 11.5px; color: #64748b; margin: 2px 0 0 0;">
                                Contact our verification team at <a href="mailto:support@upchar.info" style="color: var(--upchar-teal); font-weight: 600;">support@upchar.info</a> to add custom international fellowships or diplomas.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer.php"); ?>

<!-- Select2 JavaScript CDN & Interactive Controller -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    // Initialize Select2 on Medical Degrees Multi-Select
    if ($.fn.select2) {
        var $select = $('#qualification_select').select2({
            placeholder: "Search & select academic degrees (e.g. MBBS, MD, MS, DNB)...",
            allowClear: true,
            width: '100%'
        });

        // Update live preview when degrees selection changes
        function updateDegreePreview() {
            var selectedData = $select.select2('data');
            if (selectedData && selectedData.length > 0) {
                var degNames = selectedData.map(function(item) {
                    return item.text.trim();
                });
                $('#previewDegrees').text(degNames.join(', '));
            } else {
                $('#previewDegrees').text('Select qualifications above');
            }
        }

        $select.on('change', function() {
            updateDegreePreview();
        });

        // Initial preview call
        updateDegreePreview();

        // Quick Tag Click Handler
        $('.quick-tag').on('click', function() {
            var degreeName = $(this).data('degree').toLowerCase();
            var matchedOption = null;

            $('#qualification_select option').each(function() {
                var optText = $(this).text().trim().toLowerCase();
                if (optText === degreeName || optText.indexOf(degreeName) !== -1) {
                    matchedOption = $(this).val();
                    return false; // Break loop
                }
            });

            if (matchedOption) {
                var currentVals = $select.val() || [];
                if (currentVals.indexOf(matchedOption) === -1) {
                    currentVals.push(matchedOption);
                    $select.val(currentVals).trigger('change');
                }
            }
        });
    }

    // Live update for Alma Mater / College
    $('#college_input').on('input', function() {
        var val = $(this).val().trim();
        $('#previewCollege').text(val ? val : 'Not specified');
    });

    // Live update for Completion Year
    $('#year_select').on('change', function() {
        var val = $(this).val();
        $('#previewYear').text(val ? val : 'Not specified');
    });

    // Live update for Experience & Tier Badge
    function updateExpBadge() {
        var exp = parseInt($('#exp_input').val(), 10);
        if (!isNaN(exp) && exp >= 0) {
            $('#previewExp').text(exp + ' Years');
            $('#expBadgeLive').show();

            var tierText = '';
            if (exp < 3) {
                tierText = 'Junior Resident (' + exp + 'y)';
            } else if (exp <= 7) {
                tierText = 'Consultant (' + exp + 'y)';
            } else if (exp <= 15) {
                tierText = 'Senior Consultant (' + exp + 'y)';
            } else {
                tierText = 'Chief Specialist (' + exp + '+y)';
            }
            $('#expBadgeText').text(tierText);
        } else {
            $('#previewExp').text('Not specified');
            $('#expBadgeLive').hide();
        }
    }

    $('#exp_input').on('input', function() {
        updateExpBadge();
    });

    // Initial trigger for experience badge
    updateExpBadge();

    // AJAX Submission Handler
    $('#profileStep3Form').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $btn = $('#btnSaveStep3');
        var $alert = $('#step3AlertContainer');

        // Reset previous validation error highlights
        $('.form-control-modern').css('border-color', '');
        $('.field-error-msg').remove();
        $alert.hide().empty();

        // Button loading state
        var originalBtnHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving Qualifications...');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html(originalBtnHtml);

                // Update CSRF token
                if (res.csrf_hash) {
                    $('.csrf-token').val(res.csrf_hash);
                }

                if (res.status === 'success') {
                    $alert.html(
                        '<div class="alert alert-success alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<i class="fa fa-check-circle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                            res.message +
                            ' <span style="font-size: 12px; font-weight: normal; margin-left: 6px;">Proceeding to Step 4...</span>' +
                        '</div>'
                    ).slideDown(200);

                    // Transition to Step 4 / Bio
                    setTimeout(function() {
                        window.location.href = res.next_step || '<?=base_url("profile_about");?>';
                    }, 1100);
                } else {
                    var errMsg = res.message || 'Please correct the highlighted errors below and try again.';
                    $alert.html(
                        '<div class="alert alert-danger alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<i class="fa fa-exclamation-triangle" style="font-size: 16px; margin-right: 6px;"></i> ' +
                            errMsg +
                        '</div>'
                    ).slideDown(200);

                    if (res.errors) {
                        $.each(res.errors, function(field, errText) {
                            var $input = $('[name="' + field + '"], [name="' + field + '[]"]');
                            if ($input.length) {
                                $input.css('border-color', '#ef4444');
                                $input.closest('.form-group').append(
                                    '<div class="field-error-msg" style="color: #dc2626; font-size: 11.5px; margin-top: 4px; font-weight: 600;">' +
                                        errText +
                                    '</div>'
                                );
                            }
                        });
                    }

                    $('html, body').animate({
                        scrollTop: $alert.offset().top - 80
                    }, 300);
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(originalBtnHtml);
                $alert.html(
                    '<div class="alert alert-danger alert-dismissible" style="border-radius: 10px; font-weight: 600;">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<i class="fa fa-exclamation-triangle" style="font-size: 16px; margin-right: 6px;"></i> A network error occurred while submitting. Please try again.' +
                    '</div>'
                ).slideDown(200);
            }
        });
    });

});
</script>