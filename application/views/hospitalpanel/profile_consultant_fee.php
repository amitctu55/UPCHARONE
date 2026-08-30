<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<?php
// Resolve doctor name and details
$docName = ($doctor && !empty($doctor->fname)) ? trim($doctor->fname . ' ' . ($doctor->lname ?? '')) : ($this->session->userdata('drusername') ?: 'Specialist');
$docEmail = $doctor->email ?? '';
$docMobile = $doctor->mobile ?? $doctor->regd_no ?? '';
$generalFee = isset($practice->fee) ? floatval($practice->fee) : 0;

// Pre-generate 15-minute interval time options
$timeOptions = '';
$start = strtotime('00:00');
$end = strtotime('23:45');
for ($t = $start; $t <= $end; $t = strtotime('+15 minutes', $t)) {
    $val = date('H:i', $t);
    $text = date('h:i A', $t);
    $timeOptions .= "<option value='{$val}'>{$text}</option>";
}
?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-teal-light: #f0fdfa;
    --upchar-teal-border: #ccfbf1;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.doctor-timing-page {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Header & Breadcrumb Card */
.timing-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 24px;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.timing-header-left h1 {
    font-size: 20px;
    font-weight: 800;
    color: var(--upchar-slate);
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.timing-header-left h1 i {
    color: var(--upchar-teal);
}

.timing-header-left p {
    font-size: 13px;
    color: var(--upchar-gray);
    margin: 0;
}

.btn-header-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 8px;
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: var(--upchar-gray);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.btn-header-back:hover {
    color: var(--upchar-navy);
    border-color: #cbd5e1;
    background: #f1f5f9;
}

/* Doctor Profile Banner Card */
.doctor-hero-card {
    background: linear-gradient(135deg, #043d5b 0%, #0d5c63 100%);
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 24px;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 18px;
    box-shadow: 0 4px 14px rgba(4, 61, 91, 0.15);
}

.doctor-hero-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.doctor-hero-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #2dd4bf;
    flex-shrink: 0;
}

.doctor-hero-details h2 {
    font-size: 18px;
    font-weight: 800;
    margin: 0 0 4px 0;
    color: #ffffff;
}

.doctor-hero-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 12.5px;
    color: #cbd5e1;
}

.doctor-hero-badge {
    background: rgba(45, 212, 191, 0.2);
    color: #5eead4;
    border: 1px solid rgba(45, 212, 191, 0.3);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
}

/* Main Form Card */
.form-panel-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-bottom: 24px;
}

.form-panel-header {
    background: #f8fafc;
    border-bottom: 1px solid var(--upchar-border);
    padding: 16px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.form-panel-header h3 {
    font-size: 15px;
    font-weight: 700;
    color: var(--upchar-slate);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-panel-header h3 i {
    color: var(--upchar-teal);
}

.form-panel-body {
    padding: 24px;
}

/* Form Groups & Controls */
.form-group-custom {
    margin-bottom: 22px;
}

.form-label-custom {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--upchar-slate);
    margin-bottom: 8px;
}

.form-label-custom .required-star {
    color: #ef4444;
}

.fee-input-group {
    display: flex;
    align-items: stretch;
    max-width: 320px;
}

.fee-addon {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-right: none;
    border-radius: 8px 0 0 8px;
    padding: 0 14px;
    display: flex;
    align-items: center;
    color: var(--upchar-navy);
    font-weight: 700;
    font-size: 14px;
}

.fee-input {
    border-radius: 0 8px 8px 0 !important;
    border: 1px solid #cbd5e1 !important;
    padding: 10px 14px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    color: var(--upchar-slate) !important;
    box-shadow: none !important;
}

.fee-input:focus {
    border-color: var(--upchar-teal) !important;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15) !important;
}

/* Day Block Styling */
.day-block-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
    position: relative;
    transition: all 0.2s ease;
}

.day-block-card:hover {
    border-color: #cbd5e1;
}

.day-block-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.day-block-title {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--upchar-navy);
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-remove-day {
    color: #ef4444;
    background: #fef2f2;
    border: 1px solid #fee2e2;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.15s ease;
}

.btn-remove-day:hover {
    background: #fee2e2;
    color: #dc2626;
}

/* Interactive Day Pills */
.days-selector-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
}

.day-pill-checkbox {
    display: none;
}

.day-pill-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 38px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    user-select: none;
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
}

.day-pill-label:hover {
    border-color: var(--upchar-teal);
    color: var(--upchar-teal);
    background: var(--upchar-teal-light);
}

.day-pill-checkbox:checked + .day-pill-label {
    background: var(--upchar-teal);
    border-color: var(--upchar-teal-dark);
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.28);
}

/* Sessions Grid */
.sessions-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.session-item-row {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 14px;
    display: grid;
    grid-template-columns: 1fr 1fr 120px 140px auto;
    gap: 12px;
    align-items: flex-end;
}

@media (max-width: 991px) {
    .session-item-row {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 576px) {
    .session-item-row {
        grid-template-columns: 1fr;
    }
}

.session-field-group label {
    display: block;
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.session-field-group .form-control {
    border-radius: 7px;
    border: 1px solid #cbd5e1;
    height: 38px;
    font-size: 13px;
    color: #1e293b;
    font-weight: 500;
}

.session-field-group .form-control:focus {
    border-color: var(--upchar-teal);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.12);
}

.btn-remove-session {
    background: #ffffff;
    border: 1px solid #fecaca;
    color: #ef4444;
    width: 38px;
    height: 38px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
}

.btn-remove-session:hover {
    background: #fee2e2;
    color: #dc2626;
    border-color: #fca5a5;
}

/* Button Actions */
.btn-outline-teal {
    background: #ffffff;
    border: 1px solid var(--upchar-teal);
    color: var(--upchar-teal);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.15s ease;
    margin-top: 10px;
}

.btn-outline-teal:hover {
    background: var(--upchar-teal-light);
    border-color: var(--upchar-teal-dark);
    color: var(--upchar-teal-dark);
}

.btn-add-day {
    width: 100%;
    background: #ffffff;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 14px;
    color: var(--upchar-navy);
    font-size: 13.5px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 24px;
}

.btn-add-day:hover {
    border-color: var(--upchar-teal);
    color: var(--upchar-teal);
    background: var(--upchar-teal-light);
}

/* Bottom Action Bar */
.form-footer-actions {
    background: #f8fafc;
    border-top: 1px solid var(--upchar-border);
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

.btn-primary-save {
    background: linear-gradient(135deg, #00a896 0%, #008f80 100%);
    border: none;
    color: #ffffff;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.25);
    transition: all 0.15s ease;
}

.btn-primary-save:hover {
    opacity: 0.95;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.35);
}

.btn-secondary-cancel {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: var(--upchar-gray);
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.15s ease;
}

.btn-secondary-cancel:hover {
    background: #f1f5f9;
    color: var(--upchar-slate);
}

/* Side Tips Card */
.tips-sidebar-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-bottom: 24px;
}

.tips-card-banner {
    background: linear-gradient(135deg, #043d5b 0%, #0d5c63 100%);
    padding: 20px;
    color: #ffffff;
}

.tips-card-banner h4 {
    font-size: 15px;
    font-weight: 800;
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tips-card-banner p {
    font-size: 12.5px;
    color: #cbd5e1;
    margin: 0;
    line-height: 1.5;
}

.tips-card-body {
    padding: 20px;
}

.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.tips-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.tips-icon-wrap {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--upchar-teal-light);
    border: 1px solid var(--upchar-teal-border);
    color: var(--upchar-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.tips-text h5 {
    font-size: 13px;
    font-weight: 700;
    color: var(--upchar-slate);
    margin: 0 0 2px 0;
}

.tips-text p {
    font-size: 12px;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}
</style>

<div class="doctor-timing-page">
    <!-- Header / Breadcrumb Card -->
    <div class="timing-header-card">
        <div class="timing-header-left">
            <h1><i class="fa fa-clock-o"></i> Doctor Timing &amp; OPD Setup</h1>
            <p>Configure doctor availability slots, working days, and consultation pricing for OPD appointments.</p>
        </div>
        <div>
            <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="btn-header-back">
                <i class="fa fa-arrow-left"></i> Back to Doctors List
            </a>
        </div>
    </div>

    <!-- Doctor Profile Banner -->
    <div class="doctor-hero-card">
        <div class="doctor-hero-info">
            <div class="doctor-hero-avatar">
                <i class="fa fa-user-md"></i>
            </div>
            <div class="doctor-hero-details">
                <h2>Dr. <?=html_escape($docName);?></h2>
                <div class="doctor-hero-meta">
                    <?php if (!empty($docMobile)): ?>
                        <span><i class="fa fa-phone"></i> <?=html_escape($docMobile);?></span>
                    <?php endif; ?>
                    <?php if (!empty($docEmail)): ?>
                        <span><i class="fa fa-envelope-o"></i> <?=html_escape($docEmail);?></span>
                    <?php endif; ?>
                    <span class="doctor-hero-badge"><i class="fa fa-check-circle"></i> Hospital Consultant</span>
                </div>
            </div>
        </div>
        <div class="hidden-xs">
            <span style="font-size: 12.5px; opacity: 0.85;">Hospital ID: #<?=html_escape($this->did);?></span>
        </div>
    </div>

    <!-- Main Layout Grid -->
    <div class="row">
        <!-- Form Area (Left Column) -->
        <div class="col-lg-8 col-md-12">
            <form action="" method="post" id="doctorTimingForm">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" id="hiddenday" name="hiddenday" value="<?=max(1, intval($timing_count));?>">

                <div class="form-panel-card">
                    <div class="form-panel-header">
                        <h3><i class="fa fa-money"></i> General Consultation Fee</h3>
                    </div>
                    <div class="form-panel-body">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Base OPD Consultation Fee (₹) <span class="required-star">*</span></label>
                            <div class="fee-input-group">
                                <div class="fee-addon">₹</div>
                                <input type="number" step="any" min="0" class="form-control fee-input" name="fee" value="<?=$generalFee;?>" placeholder="e.g. 500" required>
                            </div>
                            <small class="text-muted" style="display:block; margin-top: 6px; font-size: 12px;">This fee is used as the default consultation charge during appointment booking.</small>
                        </div>
                    </div>
                </div>

                <!-- Doctor Operating Hours Card -->
                <div class="form-panel-card">
                    <div class="form-panel-header">
                        <h3><i class="fa fa-calendar-check-o"></i> Doctor's Operating Hours &amp; Sessions</h3>
                    </div>
                    <div class="form-panel-body">
                        <div id="days_wrapper">
                            <?php 
                            if (!empty($timing_count) && !empty($timings)) {
                                foreach ($timings as $key => $timing) {
                                    $sessions = $this->db->get_where('timing_session', array('timing_id' => $timing->id))->result();
                            ?>
                            <div class="day-block-card" id="day_block_<?=$key;?>">
                                <div class="day-block-header">
                                    <div class="day-block-title">
                                        <i class="fa fa-calendar" style="color: #00a896;"></i> Schedule Slot #<?=$key + 1;?>
                                    </div>
                                    <div>
                                        <a href="<?=base_url('hospitalpanel/deletetiming/' . base64_encode($timing->id));?>" class="btn-remove-day" onclick="return confirm('Are you sure you want to delete this timing schedule?');">
                                            <i class="fa fa-trash"></i> Delete Schedule
                                        </a>
                                    </div>
                                </div>

                                <!-- Day Badges -->
                                <label class="form-label-custom">Select Working Days:</label>
                                <div class="days-selector-wrap">
                                    <input type="checkbox" class="day-pill-checkbox" name="mon[<?=$key;?>]" id="mon_<?=$key;?>" value="1" <?=($timing->M) ? 'checked' : '';?>>
                                    <label class="day-pill-label" for="mon_<?=$key;?>">Mo</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="tue[<?=$key;?>]" id="tue_<?=$key;?>" value="1" <?=($timing->T) ? 'checked' : '';?>>
                                    <label class="day-pill-label" for="tue_<?=$key;?>">Tu</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="wed[<?=$key;?>]" id="wed_<?=$key;?>" value="1" <?=($timing->W) ? 'checked' : '';?>>
                                    <label class="day-pill-label" for="wed_<?=$key;?>">We</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="thu[<?=$key;?>]" id="thu_<?=$key;?>" value="1" <?=($timing->TH) ? 'checked' : '';?>>
                                    <label class="day-pill-label" for="thu_<?=$key;?>">Th</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="fri[<?=$key;?>]" id="fri_<?=$key;?>" value="1" <?=($timing->F) ? 'checked' : '';?>>
                                    <label class="day-pill-label" for="fri_<?=$key;?>">Fr</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="sat[<?=$key;?>]" id="sat_<?=$key;?>" value="1" <?=($timing->SA) ? 'checked' : '';?>>
                                    <label class="day-pill-label" for="sat_<?=$key;?>">Sa</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="sun[<?=$key;?>]" id="sun_<?=$key;?>" value="1" <?=($timing->S) ? 'checked' : '';?>>
                                    <label class="day-pill-label" for="sun_<?=$key;?>">Su</label>
                                </div>

                                <!-- Sessions -->
                                <label class="form-label-custom">Daily Timing Sessions:</label>
                                <div class="sessions-container">
                                    <?php 
                                    if (!empty($sessions)) {
                                        foreach ($sessions as $sIndex => $session) {
                                            $fromTime = !empty($session->from_timing) ? date('H:i', strtotime($session->from_timing)) : '';
                                            $toTime   = !empty($session->to_timing) ? date('H:i', strtotime($session->to_timing)) : '';
                                            $maxPat   = !empty($session->max_patient) ? $session->max_patient : 10;
                                            $sessFee  = isset($session->consultation_fee) ? $session->consultation_fee : $generalFee;
                                    ?>
                                    <div class="session-item-row">
                                        <div class="session-field-group">
                                            <label>From Time</label>
                                            <select class="form-control" name="fromtime[<?=$key;?>][]" required>
                                                <option value="">Select From</option>
                                                <?php
                                                $start = strtotime('00:00');
                                                $end = strtotime('23:45');
                                                for ($t = $start; $t <= $end; $t = strtotime('+15 minutes', $t)) {
                                                    $val = date('H:i', $t);
                                                    $text = date('h:i A', $t);
                                                    $sel = ($val == $fromTime) ? 'selected' : '';
                                                    echo "<option value='{$val}' {$sel}>{$text}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="session-field-group">
                                            <label>To Time</label>
                                            <select class="form-control" name="totime[<?=$key;?>][]" required>
                                                <option value="">Select To</option>
                                                <?php
                                                for ($t = $start; $t <= $end; $t = strtotime('+15 minutes', $t)) {
                                                    $val = date('H:i', $t);
                                                    $text = date('h:i A', $t);
                                                    $sel = ($val == $toTime) ? 'selected' : '';
                                                    echo "<option value='{$val}' {$sel}>{$text}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="session-field-group">
                                            <label>Max Patients</label>
                                            <input type="number" min="1" class="form-control" name="max_patient[<?=$key;?>][]" value="<?=$maxPat;?>" placeholder="Limit">
                                        </div>
                                        <div class="session-field-group">
                                            <label>Slot Fee (₹)</label>
                                            <input type="number" step="any" min="0" class="form-control" name="consultation_fee[<?=$key;?>][]" value="<?=$sessFee;?>" placeholder="Fee">
                                        </div>
                                        <div>
                                            <button type="button" class="btn-remove-session remove_session_btn" title="Remove Session">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php 
                                        }
                                    } else { 
                                    ?>
                                    <div class="session-item-row">
                                        <div class="session-field-group">
                                            <label>From Time</label>
                                            <select class="form-control" name="fromtime[<?=$key;?>][]" required>
                                                <option value="">Select From</option>
                                                <?=$timeOptions;?>
                                            </select>
                                        </div>
                                        <div class="session-field-group">
                                            <label>To Time</label>
                                            <select class="form-control" name="totime[<?=$key;?>][]" required>
                                                <option value="">Select To</option>
                                                <?=$timeOptions;?>
                                            </select>
                                        </div>
                                        <div class="session-field-group">
                                            <label>Max Patients</label>
                                            <input type="number" min="1" class="form-control" name="max_patient[<?=$key;?>][]" value="10" placeholder="Limit">
                                        </div>
                                        <div class="session-field-group">
                                            <label>Slot Fee (₹)</label>
                                            <input type="number" step="any" min="0" class="form-control" name="consultation_fee[<?=$key;?>][]" value="<?=$generalFee;?>" placeholder="Fee">
                                        </div>
                                        <div>
                                            <button type="button" class="btn-remove-session remove_session_btn" title="Remove Session">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <button type="button" class="btn-outline-teal addmore_sessions" data-dayblock-id="<?=$key;?>">
                                    <i class="fa fa-plus-circle"></i> Add More Sessions
                                </button>
                            </div>
                            <?php 
                                }
                            } else { 
                                // Default Initial Schedule Block
                            ?>
                            <div class="day-block-card" id="day_block_0">
                                <div class="day-block-header">
                                    <div class="day-block-title">
                                        <i class="fa fa-calendar" style="color: #00a896;"></i> Schedule Slot #1
                                    </div>
                                </div>

                                <!-- Day Badges -->
                                <label class="form-label-custom">Select Working Days:</label>
                                <div class="days-selector-wrap">
                                    <input type="checkbox" class="day-pill-checkbox" name="mon[0]" id="mon_0" value="1" checked>
                                    <label class="day-pill-label" for="mon_0">Mo</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="tue[0]" id="tue_0" value="1" checked>
                                    <label class="day-pill-label" for="tue_0">Tu</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="wed[0]" id="wed_0" value="1" checked>
                                    <label class="day-pill-label" for="wed_0">We</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="thu[0]" id="thu_0" value="1" checked>
                                    <label class="day-pill-label" for="thu_0">Th</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="fri[0]" id="fri_0" value="1" checked>
                                    <label class="day-pill-label" for="fri_0">Fr</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="sat[0]" id="sat_0" value="1" checked>
                                    <label class="day-pill-label" for="sat_0">Sa</label>

                                    <input type="checkbox" class="day-pill-checkbox" name="sun[0]" id="sun_0" value="1">
                                    <label class="day-pill-label" for="sun_0">Su</label>
                                </div>

                                <!-- Sessions -->
                                <label class="form-label-custom">Daily Timing Sessions:</label>
                                <div class="sessions-container">
                                    <div class="session-item-row">
                                        <div class="session-field-group">
                                            <label>From Time</label>
                                            <select class="form-control" name="fromtime[0][]" required>
                                                <option value="">Select From</option>
                                                <?=$timeOptions;?>
                                            </select>
                                        </div>
                                        <div class="session-field-group">
                                            <label>To Time</label>
                                            <select class="form-control" name="totime[0][]" required>
                                                <option value="">Select To</option>
                                                <?=$timeOptions;?>
                                            </select>
                                        </div>
                                        <div class="session-field-group">
                                            <label>Max Patients</label>
                                            <input type="number" min="1" class="form-control" name="max_patient[0][]" value="10" placeholder="Limit">
                                        </div>
                                        <div class="session-field-group">
                                            <label>Slot Fee (₹)</label>
                                            <input type="number" step="any" min="0" class="form-control" name="consultation_fee[0][]" value="<?=$generalFee;?>" placeholder="Fee">
                                        </div>
                                        <div>
                                            <button type="button" class="btn-remove-session remove_session_btn" title="Remove Session">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn-outline-teal addmore_sessions" data-dayblock-id="0">
                                    <i class="fa fa-plus-circle"></i> Add More Sessions
                                </button>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Add Day Block Button -->
                        <button type="button" class="btn-add-day add_tims_day" data-dayblock-id="<?=(!empty($timing_count) && $timing_count > 0) ? ($timing_count - 1) : 0;?>">
                            <i class="fa fa-plus-circle"></i> Add Timing For Remaining Days / Shift
                        </button>
                    </div>

                    <!-- Footer Action Bar -->
                    <div class="form-footer-actions">
                        <a href="<?=base_url('hospitalpanel/managedoctor');?>" class="btn-secondary-cancel">
                            <i class="fa fa-arrow-left"></i> Cancel &amp; Back
                        </a>
                        <button type="submit" name="submit" value="1" class="btn-primary-save">
                            <i class="fa fa-check-circle"></i> Save &amp; Update Timings
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Guidance Sidebar Card (Right Column) -->
        <div class="col-lg-4 col-md-12">
            <div class="tips-sidebar-card">
                <div class="tips-card-banner">
                    <h4><i class="fa fa-users"></i> 2.5M+ Patients on Upchar</h4>
                    <p>Accurate doctor hours ensure higher patient booking conversions and zero OPD confusion.</p>
                </div>
                <div class="tips-card-body">
                    <ul class="tips-list">
                        <li class="tips-item">
                            <div class="tips-icon-wrap"><i class="fa fa-clock-o"></i></div>
                            <div class="tips-text">
                                <h5>Zero-Wait OPD Scheduling</h5>
                                <p>Set realistic session start and end times to streamline walk-in and online appointments.</p>
                            </div>
                        </li>
                        <li class="tips-item">
                            <div class="tips-icon-wrap"><i class="fa fa-calendar"></i></div>
                            <div class="tips-text">
                                <h5>Multi-Shift Support</h5>
                                <p>Use "Add Timing For Remaining Days" to set different morning and evening slots across weekdays and weekends.</p>
                            </div>
                        </li>
                        <li class="tips-item">
                            <div class="tips-icon-wrap"><i class="fa fa-inr"></i></div>
                            <div class="tips-text">
                                <h5>Transparent Consultation Fees</h5>
                                <p>Set standard OPD charges or custom session rates to establish patient trust up front.</p>
                            </div>
                        </li>
                        <li class="tips-item">
                            <div class="tips-icon-wrap"><i class="fa fa-bolt"></i></div>
                            <div class="tips-text">
                                <h5>Instant Portal Sync</h5>
                                <p>Any updates made here are instantly reflected on the Upchar patient search &amp; appointment matrix.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<!-- Dynamic Day and Session Adder Scripts -->
<script>
$(document).ready(function() {
    var timeOptionsHtml = "<?=$timeOptions;?>";

    // 1. Add Timing Block for Remaining Days
    $('body').on('click', '.add_tims_day', function(e) {
        e.preventDefault();
        var dblockid = parseInt($(this).attr('data-dayblock-id')) + 1;
        $(this).attr('data-dayblock-id', dblockid);
        
        var currentDays = parseInt($('#hiddenday').val()) || 1;
        $('#hiddenday').val(currentDays + 1);

        var newBlockHtml = `
        <div class="day-block-card" id="day_block_${dblockid}">
            <div class="day-block-header">
                <div class="day-block-title">
                    <i class="fa fa-calendar" style="color: #00a896;"></i> Schedule Slot #${dblockid + 1}
                </div>
                <div>
                    <button type="button" class="btn-remove-day remove_day_block_btn">
                        <i class="fa fa-trash"></i> Remove Slot
                    </button>
                </div>
            </div>

            <label class="form-label-custom">Select Working Days:</label>
            <div class="days-selector-wrap">
                <input type="checkbox" class="day-pill-checkbox" name="mon[${dblockid}]" id="mon_${dblockid}" value="1">
                <label class="day-pill-label" for="mon_${dblockid}">Mo</label>

                <input type="checkbox" class="day-pill-checkbox" name="tue[${dblockid}]" id="tue_${dblockid}" value="1">
                <label class="day-pill-label" for="tue_${dblockid}">Tu</label>

                <input type="checkbox" class="day-pill-checkbox" name="wed[${dblockid}]" id="wed_${dblockid}" value="1">
                <label class="day-pill-label" for="wed_${dblockid}">We</label>

                <input type="checkbox" class="day-pill-checkbox" name="thu[${dblockid}]" id="thu_${dblockid}" value="1">
                <label class="day-pill-label" for="thu_${dblockid}">Th</label>

                <input type="checkbox" class="day-pill-checkbox" name="fri[${dblockid}]" id="fri_${dblockid}" value="1">
                <label class="day-pill-label" for="fri_${dblockid}">Fr</label>

                <input type="checkbox" class="day-pill-checkbox" name="sat[${dblockid}]" id="sat_${dblockid}" value="1">
                <label class="day-pill-label" for="sat_${dblockid}">Sa</label>

                <input type="checkbox" class="day-pill-checkbox" name="sun[${dblockid}]" id="sun_${dblockid}" value="1">
                <label class="day-pill-label" for="sun_${dblockid}">Su</label>
            </div>

            <label class="form-label-custom">Daily Timing Sessions:</label>
            <div class="sessions-container">
                <div class="session-item-row">
                    <div class="session-field-group">
                        <label>From Time</label>
                        <select class="form-control" name="fromtime[${dblockid}][]" required>
                            <option value="">Select From</option>
                            ${timeOptionsHtml}
                        </select>
                    </div>
                    <div class="session-field-group">
                        <label>To Time</label>
                        <select class="form-control" name="totime[${dblockid}][]" required>
                            <option value="">Select To</option>
                            ${timeOptionsHtml}
                        </select>
                    </div>
                    <div class="session-field-group">
                        <label>Max Patients</label>
                        <input type="number" min="1" class="form-control" name="max_patient[${dblockid}][]" value="10" placeholder="Limit">
                    </div>
                    <div class="session-field-group">
                        <label>Slot Fee (₹)</label>
                        <input type="number" step="any" min="0" class="form-control" name="consultation_fee[${dblockid}][]" value="<?=$generalFee;?>" placeholder="Fee">
                    </div>
                    <div>
                        <button type="button" class="btn-remove-session remove_session_btn" title="Remove Session">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn-outline-teal addmore_sessions" data-dayblock-id="${dblockid}">
                <i class="fa fa-plus-circle"></i> Add More Sessions
            </button>
        </div>
        `;

        $('#days_wrapper').append(newBlockHtml);
    });

    // 2. Add More Sessions inside a Day Block
    $('body').on('click', '.addmore_sessions', function(e) {
        e.preventDefault();
        var dblockid = $(this).attr('data-dayblock-id');
        var $container = $(this).closest('.day-block-card').find('.sessions-container');

        var newSessionHtml = `
        <div class="session-item-row">
            <div class="session-field-group">
                <label>From Time</label>
                <select class="form-control" name="fromtime[${dblockid}][]" required>
                    <option value="">Select From</option>
                    ${timeOptionsHtml}
                </select>
            </div>
            <div class="session-field-group">
                <label>To Time</label>
                <select class="form-control" name="totime[${dblockid}][]" required>
                    <option value="">Select To</option>
                    ${timeOptionsHtml}
                </select>
            </div>
            <div class="session-field-group">
                <label>Max Patients</label>
                <input type="number" min="1" class="form-control" name="max_patient[${dblockid}][]" value="10" placeholder="Limit">
            </div>
            <div class="session-field-group">
                <label>Slot Fee (₹)</label>
                <input type="number" step="any" min="0" class="form-control" name="consultation_fee[${dblockid}][]" value="<?=$generalFee;?>" placeholder="Fee">
            </div>
            <div>
                <button type="button" class="btn-remove-session remove_session_btn" title="Remove Session">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        `;

        $container.append(newSessionHtml);
    });

    // 3. Remove Single Session
    $('body').on('click', '.remove_session_btn', function(e) {
        e.preventDefault();
        var $container = $(this).closest('.sessions-container');
        if ($container.find('.session-item-row').length > 1) {
            $(this).closest('.session-item-row').remove();
        } else {
            alert('A schedule slot must contain at least one session.');
        }
    });

    // 4. Remove Dynamic Day Block
    $('body').on('click', '.remove_day_block_btn', function(e) {
        e.preventDefault();
        $(this).closest('.day-block-card').remove();
    });
});
</script>