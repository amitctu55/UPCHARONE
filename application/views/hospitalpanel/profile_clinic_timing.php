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

.timing-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.timing-hdr-card {
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

.timing-hdr-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.timing-hdr-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-back-link {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    color: #475569 !important;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.btn-back-link:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}

/* Nav Tabs */
.profile-nav-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 12px;
    overflow-x: auto;
}

.profile-nav-tab {
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    white-space: nowrap;
    transition: all 0.15s ease;
}

.profile-nav-tab.active {
    background: #043d5b;
    color: #ffffff !important;
    border-color: #043d5b;
}

.profile-nav-tab:hover:not(.active) {
    background: #f1f5f9;
    color: #0f172a;
}

/* 24x7 Quick Preset Banner */
.preset-247-banner {
    background: linear-gradient(135deg, #0f172a 0%, #043d5b 50%, #008f80 100%);
    border-radius: 12px;
    padding: 16px 20px;
    color: #ffffff;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    box-shadow: 0 4px 14px rgba(4, 61, 91, 0.18);
}

.preset-247-info {
    display: flex;
    align-items: center;
    gap: 14px;
}

.preset-247-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #22d3ee;
    flex-shrink: 0;
}

.btn-preset-247 {
    background: #22d3ee;
    color: #0f172a;
    font-weight: 800;
    font-size: 13.5px;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 8px rgba(34, 211, 238, 0.4);
    transition: all 0.15s ease;
}

.btn-preset-247:hover {
    background: #67e8f9;
    transform: translateY(-1px);
}

/* Setup Grid */
.setup-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 24px;
    max-width: 1200px;
}

@media (max-width: 900px) {
    .setup-grid {
        grid-template-columns: 1fr;
    }
}

.setup-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.setup-card-hdr {
    background: linear-gradient(135deg, #043d5b 0%, #008f80 100%);
    padding: 18px 24px;
    color: #ffffff;
}

.setup-card-hdr h3 {
    font-size: 16px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.setup-card-body {
    padding: 26px 28px;
}

/* Day Block Styling */
.day-timing-block {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    position: relative;
    transition: all 0.2s ease;
}

.day-timing-block:hover {
    border-color: #cbd5e1;
}

.day-selector-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 10px 0 16px 0;
}

.day-pill-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 36px;
    border-radius: 8px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    user-select: none;
    transition: all 0.15s ease;
}

.day-pill-checkbox {
    display: none;
}

.day-pill-checkbox:checked + .day-pill-label {
    background: #00a896;
    border-color: #00a896;
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.3);
}

/* Session Rows */
.session-row-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    background: #ffffff;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.session-select {
    flex: 1;
    height: 38px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 13px;
    color: #0f172a;
    background: #ffffff;
}

.btn-remove-session {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 6px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
}

.btn-remove-session:hover {
    background: #fecaca;
}

.btn-add-session {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 12.5px;
    font-weight: 700;
    border: 1px solid #bae6fd;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
    margin-top: 4px;
}

.btn-add-session:hover {
    background: #bae6fd;
}

.btn-add-day-block {
    background: #ffffff;
    border: 2px dashed #00a896;
    color: #00a896;
    font-weight: 800;
    font-size: 13.5px;
    padding: 12px 20px;
    border-radius: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    margin-bottom: 24px;
    transition: all 0.15s ease;
}

.btn-add-day-block:hover {
    background: #f0fdfa;
}

.btn-save-timings {
    background: #00a896;
    color: #ffffff;
    font-weight: 800;
    font-size: 14.5px;
    height: 46px;
    padding: 0 32px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);
    transition: all 0.15s ease;
    width: 100%;
}

.btn-save-timings:hover {
    background: #008f80;
    transform: translateY(-1px);
}

.guidelines-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    padding: 24px;
}

.is-247-active-card {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border: 1px solid #a7f3d0;
    border-radius: 10px;
    padding: 16px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #065f46;
}
</style>

<?php
// Generate time dropdown options
$timeoption = '';
$tStart = strtotime("00:00");
$tEnd   = strtotime("23:45");
$tNow   = $tStart;
while ($tNow <= $tEnd) {
    $val = date("H:i", $tNow);
    $label = date("h:i A", $tNow);
    $timeoption .= "<option value='{$val}'>{$label}</option>";
    $tNow = strtotime('+15 minutes', $tNow);
}

// Check if currently configured as 24x7
$is247Current = false;
if (!empty($timings) && count($timings) == 1) {
    $t = $timings[0];
    if ($t->M && $t->T && $t->W && $t->TH && $t->F && $t->SA && $t->S) {
        $sessions = $this->db->get_where('timing_session', array('timing_id' => $t->id))->result();
        if (count($sessions) == 1) {
            $fromT = date("H:i", strtotime($sessions[0]->from_timing));
            $toT   = date("H:i", strtotime($sessions[0]->to_timing));
            if ($fromT == "00:00" && ($toT == "23:45" || $toT == "23:59")) {
                $is247Current = true;
            }
        }
    }
}
?>

<div class="page-content" style="padding-top: 0;">
    <div class="timing-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="timing-hdr-card">
            <div>
                <h1><i class="fa fa-clock-o" style="color: #00a896; margin-right: 8px;"></i> Hospital Operating Hours &amp; Shifts</h1>
                <p>Configure hospital operational timings, outpatient clinic shifts, or enable 24x7 emergency hospital availability.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/profile_maplocation');?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to Step 4
                </a>
            </div>
        </div>

        <!-- Multi-Step Nav Tabs -->
        <div class="profile-nav-tabs">
            <a href="<?=base_url('hospitalpanel/updateprofile');?>" class="profile-nav-tab">
                <i class="fa fa-hospital-o"></i> 1. Basic Details
            </a>
            <a href="<?=base_url('hospitalpanel/profile_clinicproof');?>" class="profile-nav-tab">
                <i class="fa fa-certificate"></i> 2. Hospital Proof
            </a>
            <a href="<?=base_url('hospitalpanel/profile_disppic');?>" class="profile-nav-tab">
                <i class="fa fa-picture-o"></i> 3. Display Banner / Photo
            </a>
            <a href="<?=base_url('hospitalpanel/profile_maplocation');?>" class="profile-nav-tab">
                <i class="fa fa-map-marker"></i> 4. Map Location &amp; Contacts
            </a>
            <a href="<?=base_url('hospitalpanel/profile_clinic_timing');?>" class="profile-nav-tab active">
                <i class="fa fa-clock-o"></i> 5. Operating Hours (24x7)
            </a>
        </div>

        <!-- 24x7 One-Click Quick Preset Banner -->
        <div class="preset-247-banner">
            <div class="preset-247-info">
                <div class="preset-247-icon">
                    <i class="fa fa-ambulance"></i>
                </div>
                <div>
                    <strong style="font-size: 15px; display: block; margin-bottom: 2px;">24x7 Hospital Emergency &amp; Admissions Mode</strong>
                    <span style="font-size: 12.5px; opacity: 0.9;">Does your hospital admit patients or operate emergency casualty around the clock?</span>
                </div>
            </div>
            <div>
                <button type="button" id="btnSet247" class="btn-preset-247">
                    <i class="fa fa-bolt"></i> Set 24x7 Operations (All Days &amp; Hours)
                </button>
            </div>
        </div>

        <?php if($is247Current): ?>
            <div class="is-247-active-card">
                <i class="fa fa-check-circle" style="font-size: 24px; color: #10b981;"></i>
                <div>
                    <strong style="font-size: 14px; display: block;">24x7 Round-the-Clock Status Active</strong>
                    <span style="font-size: 12.5px;">Your hospital is currently configured as 24 hours open across all 7 days for casualty and patient admissions.</span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form & Guidelines Grid -->
        <div class="setup-grid">
            
            <!-- Left: Timings Form -->
            <div class="setup-card">
                <div class="setup-card-hdr">
                    <h3><i class="fa fa-calendar-check-o"></i> Weekly Operating Schedule</h3>
                </div>

                <div class="setup-card-body">
                    <?php echo form_open("hospitalpanel/profile_clinic_timing", 'id="timingsForm"');?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        <input type="hidden" id="hiddenday" name="hiddenday" value="<?=(@$timing_count > 0 ? $timing_count : 1);?>">

                        <div id="days_wrapper">
                            <?php if(!empty($timings)): ?>
                                <?php foreach($timings as $key => $timing): ?>
                                    <div class="day-timing-block" id="dayblock_<?=$key;?>">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <strong style="font-size: 13.5px; color: #043d5b;">
                                                <i class="fa fa-calendar"></i> Select Days for this Shift:
                                            </strong>
                                            <?php if($key > 0): ?>
                                                <button type="button" class="btn btn-xs btn-danger remove-day-block" data-target="#dayblock_<?=$key;?>" style="border-radius: 4px; padding: 2px 8px;">
                                                    <i class="fa fa-trash"></i> Remove Block
                                                </button>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Days Selector Pills -->
                                        <div class="day-selector-pills">
                                            <input type="checkbox" id="mon_<?=$key;?>" name="mon[<?=$key;?>]" value="1" class="day-pill-checkbox" <?=($timing->M ? 'checked' : '');?>>
                                            <label for="mon_<?=$key;?>" class="day-pill-label">Mon</label>

                                            <input type="checkbox" id="tue_<?=$key;?>" name="tue[<?=$key;?>]" value="1" class="day-pill-checkbox" <?=($timing->T ? 'checked' : '');?>>
                                            <label for="tue_<?=$key;?>" class="day-pill-label">Tue</label>

                                            <input type="checkbox" id="wed_<?=$key;?>" name="wed[<?=$key;?>]" value="1" class="day-pill-checkbox" <?=($timing->W ? 'checked' : '');?>>
                                            <label for="wed_<?=$key;?>" class="day-pill-label">Wed</label>

                                            <input type="checkbox" id="thu_<?=$key;?>" name="thu[<?=$key;?>]" value="1" class="day-pill-checkbox" <?=($timing->TH ? 'checked' : '');?>>
                                            <label for="thu_<?=$key;?>" class="day-pill-label">Thu</label>

                                            <input type="checkbox" id="fri_<?=$key;?>" name="fri[<?=$key;?>]" value="1" class="day-pill-checkbox" <?=($timing->F ? 'checked' : '');?>>
                                            <label for="fri_<?=$key;?>" class="day-pill-label">Fri</label>

                                            <input type="checkbox" id="sat_<?=$key;?>" name="sat[<?=$key;?>]" value="1" class="day-pill-checkbox" <?=($timing->SA ? 'checked' : '');?>>
                                            <label for="sat_<?=$key;?>" class="day-pill-label">Sat</label>

                                            <input type="checkbox" id="sun_<?=$key;?>" name="sun[<?=$key;?>]" value="1" class="day-pill-checkbox" <?=($timing->S ? 'checked' : '');?>>
                                            <label for="sun_<?=$key;?>" class="day-pill-label">Sun</label>
                                        </div>

                                        <!-- Sessions Container -->
                                        <div class="sessions-container" id="sessions_wrap_<?=$key;?>">
                                            <div style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px;">
                                                Shift Hours / Slots:
                                            </div>

                                            <?php 
                                            $sessions = $this->db->get_where('timing_session', array('timing_id' => $timing->id))->result();
                                            if(!empty($sessions)):
                                                foreach($sessions as $sIndex => $session):
                                            ?>
                                                <div class="session-row-item">
                                                    <span style="font-size: 12px; font-weight: 700; color: #64748b;">From:</span>
                                                    <select name="fromtime[<?=$key;?>][]" class="session-select from-select" required>
                                                        <option value="">Start Time</option>
                                                        <?php
                                                        $fromVal = date("H:i", strtotime($session->from_timing));
                                                        $tNow = $tStart;
                                                        while ($tNow <= $tEnd) {
                                                            $val = date("H:i", $tNow);
                                                            $label = date("h:i A", $tNow);
                                                            $sel = ($val == $fromVal) ? 'selected' : '';
                                                            echo "<option value='{$val}' {$sel}>{$label}</option>";
                                                            $tNow = strtotime('+15 minutes', $tNow);
                                                        }
                                                        ?>
                                                    </select>

                                                    <span style="font-size: 12px; font-weight: 700; color: #64748b;">To:</span>
                                                    <select name="totime[<?=$key;?>][]" class="session-select to-select" required>
                                                        <option value="">End Time</option>
                                                        <?php
                                                        $toVal = date("H:i", strtotime($session->to_timing));
                                                        $tNow = $tStart;
                                                        while ($tNow <= $tEnd) {
                                                            $val = date("H:i", $tNow);
                                                            $label = date("h:i A", $tNow);
                                                            $sel = ($val == $toVal) ? 'selected' : '';
                                                            echo "<option value='{$val}' {$sel}>{$label}</option>";
                                                            $tNow = strtotime('+15 minutes', $tNow);
                                                        }
                                                        ?>
                                                    </select>

                                                    <?php if($sIndex > 0): ?>
                                                        <button type="button" class="btn-remove-session" onclick="$(this).closest('.session-row-item').remove();" title="Remove shift">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            <?php 
                                                endforeach;
                                            else:
                                            ?>
                                                <div class="session-row-item">
                                                    <span style="font-size: 12px; font-weight: 700; color: #64748b;">From:</span>
                                                    <select name="fromtime[<?=$key;?>][]" class="session-select from-select" required>
                                                        <option value="">Start Time</option>
                                                        <?=$timeoption;?>
                                                    </select>

                                                    <span style="font-size: 12px; font-weight: 700; color: #64748b;">To:</span>
                                                    <select name="totime[<?=$key;?>][]" class="session-select to-select" required>
                                                        <option value="">End Time</option>
                                                        <?=$timeoption;?>
                                                    </select>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <button type="button" class="btn-add-session addmore_sessions" data-key="<?=$key;?>">
                                            <i class="fa fa-plus"></i> Add Another Shift / Break Session
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Default Single Block -->
                                <div class="day-timing-block" id="dayblock_0">
                                    <strong style="font-size: 13.5px; color: #043d5b; display: block;">
                                        <i class="fa fa-calendar"></i> Select Days for this Shift:
                                    </strong>

                                    <div class="day-selector-pills">
                                        <input type="checkbox" id="mon_0" name="mon[0]" value="1" class="day-pill-checkbox" checked>
                                        <label for="mon_0" class="day-pill-label">Mon</label>

                                        <input type="checkbox" id="tue_0" name="tue[0]" value="1" class="day-pill-checkbox" checked>
                                        <label for="tue_0" class="day-pill-label">Tue</label>

                                        <input type="checkbox" id="wed_0" name="wed[0]" value="1" class="day-pill-checkbox" checked>
                                        <label for="wed_0" class="day-pill-label">Wed</label>

                                        <input type="checkbox" id="thu_0" name="thu[0]" value="1" class="day-pill-checkbox" checked>
                                        <label for="thu_0" class="day-pill-label">Thu</label>

                                        <input type="checkbox" id="fri_0" name="fri[0]" value="1" class="day-pill-checkbox" checked>
                                        <label for="fri_0" class="day-pill-label">Fri</label>

                                        <input type="checkbox" id="sat_0" name="sat[0]" value="1" class="day-pill-checkbox" checked>
                                        <label for="sat_0" class="day-pill-label">Sat</label>

                                        <input type="checkbox" id="sun_0" name="sun[0]" value="1" class="day-pill-checkbox" checked>
                                        <label for="sun_0" class="day-pill-label">Sun</label>
                                    </div>

                                    <div class="sessions-container" id="sessions_wrap_0">
                                        <div style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px;">
                                            Shift Hours:
                                        </div>
                                        <div class="session-row-item">
                                            <span style="font-size: 12px; font-weight: 700; color: #64748b;">From:</span>
                                            <select name="fromtime[0][]" class="session-select from-select" required>
                                                <option value="">Start Time</option>
                                                <?=$timeoption;?>
                                            </select>

                                            <span style="font-size: 12px; font-weight: 700; color: #64748b;">To:</span>
                                            <select name="totime[0][]" class="session-select to-select" required>
                                                <option value="">End Time</option>
                                                <?=$timeoption;?>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="button" class="btn-add-session addmore_sessions" data-key="0">
                                        <i class="fa fa-plus"></i> Add Another Shift / Break Session
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <button type="button" id="btnAddDayBlock" class="btn-add-day-block">
                            <i class="fa fa-plus-circle"></i> Add Separate Timing for Remaining Days (e.g. Weekends / Sunday)
                        </button>

                        <button type="submit" name="submit" value="1" class="btn-save-timings">
                            <i class="fa fa-check-circle"></i> Save Schedule &amp; Go to Dashboard
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Right: Timings Guidelines -->
            <div class="guidelines-card">
                <h4 style="font-size: 15px; font-weight: 800; color: #043d5b; margin: 0 0 14px 0;">
                    <i class="fa fa-ambulance" style="color: #00a896;"></i> 24x7 Operations Support
                </h4>

                <ul style="padding-left: 20px; font-size: 13px; color: #475569; line-height: 1.6; margin-bottom: 20px;">
                    <li><strong>Emergency Casualty:</strong> 24x7 hospital badges receive priority ranking on Upchar emergency search.</li>
                    <li><strong>Round-the-Clock Bed Admissions:</strong> Inpatient bed booking requires active operational status across all 7 days.</li>
                    <li><strong>Custom OPD Hours:</strong> You can set general emergency as 24x7 while individual affiliated doctors maintain their own outpatient consulting slots.</li>
                </ul>

                <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 8px; padding: 14px; font-size: 12px; color: #0f766e; line-height: 1.5;">
                    <i class="fa fa-shield"></i> Clicking <strong>"Set 24x7 Operations"</strong> automatically selects Monday through Sunday from 12:00 AM to 11:45 PM.
                </div>
            </div>

        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<!-- Dynamic Timing JavaScript -->
<script>
$(document).ready(function() {
    var timeOptionsHtml = `<?=$timeoption;?>`;
    var dayBlockCount = parseInt($('#hiddenday').val()) || 1;

    // 1. One-Click 24x7 Preset Button Handler
    $('#btnSet247').on('click', function(e) {
        e.preventDefault();
        
        // Reset to single block
        dayBlockCount = 1;
        $('#hiddenday').val(1);

        var block247Html = `
            <div class="day-timing-block" id="dayblock_0" style="border: 2px solid #00a896; background: #f0fdfa;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong style="font-size: 13.5px; color: #043d5b;">
                        <i class="fa fa-ambulance" style="color: #00a896;"></i> 24x7 Operating Shift (All 7 Days):
                    </strong>
                    <span class="badge" style="background: #00a896; color: #ffffff; padding: 5px 10px; border-radius: 20px; font-weight: 700;">
                        <i class="fa fa-bolt"></i> 24 Hours Open
                    </span>
                </div>

                <div class="day-selector-pills">
                    <input type="checkbox" id="mon_0" name="mon[0]" value="1" class="day-pill-checkbox" checked>
                    <label for="mon_0" class="day-pill-label">Mon</label>

                    <input type="checkbox" id="tue_0" name="tue[0]" value="1" class="day-pill-checkbox" checked>
                    <label for="tue_0" class="day-pill-label">Tue</label>

                    <input type="checkbox" id="wed_0" name="wed[0]" value="1" class="day-pill-checkbox" checked>
                    <label for="wed_0" class="day-pill-label">Wed</label>

                    <input type="checkbox" id="thu_0" name="thu[0]" value="1" class="day-pill-checkbox" checked>
                    <label for="thu_0" class="day-pill-label">Thu</label>

                    <input type="checkbox" id="fri_0" name="fri[0]" value="1" class="day-pill-checkbox" checked>
                    <label for="fri_0" class="day-pill-label">Fri</label>

                    <input type="checkbox" id="sat_0" name="sat[0]" value="1" class="day-pill-checkbox" checked>
                    <label for="sat_0" class="day-pill-label">Sat</label>

                    <input type="checkbox" id="sun_0" name="sun[0]" value="1" class="day-pill-checkbox" checked>
                    <label for="sun_0" class="day-pill-label">Sun</label>
                </div>

                <div class="sessions-container" id="sessions_wrap_0">
                    <div style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px;">
                        Shift Hours (Full Day 24x7):
                    </div>
                    <div class="session-row-item">
                        <span style="font-size: 12px; font-weight: 700; color: #64748b;">From:</span>
                        <select name="fromtime[0][]" class="session-select from-select" required>
                            <option value="00:00" selected>12:00 AM (Midnight)</option>
                            ${timeOptionsHtml}
                        </select>

                        <span style="font-size: 12px; font-weight: 700; color: #64748b;">To:</span>
                        <select name="totime[0][]" class="session-select to-select" required>
                            <option value="23:45" selected>11:45 PM (Full Day)</option>
                            ${timeOptionsHtml}
                        </select>
                    </div>
                </div>

                <button type="button" class="btn-add-session addmore_sessions" data-key="0">
                    <i class="fa fa-plus"></i> Add Another Shift / Break Session
                </button>
            </div>
        `;

        $('#days_wrapper').html(block247Html);

        // Smooth scroll to save button
        $('html, body').animate({
            scrollTop: $('.btn-save-timings').offset().top - 200
        }, 300);
    });

    // 2. Add session inside a day block
    $('body').on('click', '.addmore_sessions', function() {
        var key = $(this).attr('data-key');
        var sessionRow = `
            <div class="session-row-item">
                <span style="font-size: 12px; font-weight: 700; color: #64748b;">From:</span>
                <select name="fromtime[${key}][]" class="session-select from-select" required>
                    <option value="">Start Time</option>
                    ${timeOptionsHtml}
                </select>

                <span style="font-size: 12px; font-weight: 700; color: #64748b;">To:</span>
                <select name="totime[${key}][]" class="session-select to-select" required>
                    <option value="">End Time</option>
                    ${timeOptionsHtml}
                </select>

                <button type="button" class="btn-remove-session" onclick="$(this).closest('.session-row-item').remove();" title="Remove shift">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        `;
        $('#sessions_wrap_' + key).append(sessionRow);
    });

    // 3. Add new day block
    $('#btnAddDayBlock').on('click', function() {
        var nextKey = dayBlockCount;
        dayBlockCount++;
        $('#hiddenday').val(dayBlockCount);

        var newDayBlock = `
            <div class="day-timing-block" id="dayblock_${nextKey}">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong style="font-size: 13.5px; color: #043d5b;">
                        <i class="fa fa-calendar"></i> Select Days for this Shift:
                    </strong>
                    <button type="button" class="btn btn-xs btn-danger remove-day-block" data-target="#dayblock_${nextKey}" style="border-radius: 4px; padding: 2px 8px;">
                        <i class="fa fa-trash"></i> Remove Block
                    </button>
                </div>

                <div class="day-selector-pills">
                    <input type="checkbox" id="mon_${nextKey}" name="mon[${nextKey}]" value="1" class="day-pill-checkbox">
                    <label for="mon_${nextKey}" class="day-pill-label">Mon</label>

                    <input type="checkbox" id="tue_${nextKey}" name="tue[${nextKey}]" value="1" class="day-pill-checkbox">
                    <label for="tue_${nextKey}" class="day-pill-label">Tue</label>

                    <input type="checkbox" id="wed_${nextKey}" name="wed[${nextKey}]" value="1" class="day-pill-checkbox">
                    <label for="wed_${nextKey}" class="day-pill-label">Wed</label>

                    <input type="checkbox" id="thu_${nextKey}" name="thu[${nextKey}]" value="1" class="day-pill-checkbox">
                    <label for="thu_${nextKey}" class="day-pill-label">Thu</label>

                    <input type="checkbox" id="fri_${nextKey}" name="fri[${nextKey}]" value="1" class="day-pill-checkbox">
                    <label for="fri_${nextKey}" class="day-pill-label">Fri</label>

                    <input type="checkbox" id="sat_${nextKey}" name="sat[${nextKey}]" value="1" class="day-pill-checkbox">
                    <label for="sat_${nextKey}" class="day-pill-label">Sat</label>

                    <input type="checkbox" id="sun_${nextKey}" name="sun[${nextKey}]" value="1" class="day-pill-checkbox" checked>
                    <label for="sun_${nextKey}" class="day-pill-label">Sun</label>
                </div>

                <div class="sessions-container" id="sessions_wrap_${nextKey}">
                    <div style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px;">
                        Shift Hours:
                    </div>
                    <div class="session-row-item">
                        <span style="font-size: 12px; font-weight: 700; color: #64748b;">From:</span>
                        <select name="fromtime[${nextKey}][]" class="session-select from-select" required>
                            <option value="">Start Time</option>
                            ${timeOptionsHtml}
                        </select>

                        <span style="font-size: 12px; font-weight: 700; color: #64748b;">To:</span>
                        <select name="totime[${nextKey}][]" class="session-select to-select" required>
                            <option value="">End Time</option>
                            ${timeOptionsHtml}
                        </select>
                    </div>
                </div>

                <button type="button" class="btn-add-session addmore_sessions" data-key="${nextKey}">
                    <i class="fa fa-plus"></i> Add Another Shift / Break Session
                </button>
            </div>
        `;
        $('#days_wrapper').append(newDayBlock);
    });

    // 4. Remove day block
    $('body').on('click', '.remove-day-block', function() {
        var target = $(this).attr('data-target');
        $(target).remove();
    });
});
</script>