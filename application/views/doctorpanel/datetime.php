<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<!-- Select2 CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

/* Select2 Modern Upchar Theme & Searchable Dropdown Styling */
.select2-container {
    width: 100% !important;
}

.select2-container--default .select2-selection--single {
    height: 46px !important;
    border: 1px solid var(--upchar-border, #e2e8f0) !important;
    border-radius: 10px !important;
    background-color: #ffffff !important;
    display: flex !important;
    align-items: center !important;
    padding: 0 12px !important;
    transition: all 0.2s ease !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02) !important;
}

.select2-container--default .select2-selection--single:hover {
    border-color: #cbd5e1 !important;
}

.select2-container--default.select2-container--open .select2-selection--single,
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #00a896 !important;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15) !important;
    outline: none !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #1e293b !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    padding-left: 0 !important;
    padding-right: 24px !important;
    line-height: 44px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 44px !important;
    right: 12px !important;
    top: 0 !important;
    display: flex !important;
    align-items: center !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #64748b transparent transparent transparent !important;
    border-width: 6px 5px 0 5px !important;
}

.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #00a896 transparent !important;
    border-width: 0 5px 6px 5px !important;
}

/* Dropdown Menu Container */
.select2-dropdown {
    border: 1px solid #e2e8f0 !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
    overflow: hidden !important;
    background: #ffffff !important;
    z-index: 1060 !important;
    margin-top: 4px !important;
}

/* Search Box Inside Dropdown */
.select2-container--default .select2-search--dropdown {
    padding: 8px 10px !important;
    background: #f8fafc !important;
    border-bottom: 1px solid #f1f5f9 !important;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    height: 38px !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 6px 12px !important;
    font-size: 13px !important;
    outline: none !important;
    background: #ffffff !important;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.04) !important;
}

.select2-container--default .select2-search--dropdown .select2-search__field:focus {
    border-color: #00a896 !important;
    box-shadow: 0 0 0 2px rgba(0, 168, 150, 0.15) !important;
}

/* Result Items */
.select2-container--default .select2-results__option {
    padding: 9px 14px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #334155 !important;
    transition: background 0.15s ease !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #f0fdfa !important;
    color: #008f80 !important;
    font-weight: 700 !important;
}

.select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: #e0f2fe !important;
    color: #0284c7 !important;
    font-weight: 700 !important;
}

.sched-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.sched-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--upchar-border);
    padding: 26px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
}

.day-badge-on {
    background: #00a896;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
}

.day-badge-off {
    background: #f1f5f9;
    color: #94a3b8;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
}

.btn-save-sched {
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 10px;
    padding: 12px 28px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-save-sched:hover {
    background: var(--upchar-teal-dark);
    color: #ffffff;
}

.schedule-card-item {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    padding: 20px;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, border-color 0.2s ease;
}

.schedule-card-item:hover {
    transform: translateY(-2px);
    border-color: var(--upchar-teal);
    box-shadow: 0 8px 20px rgba(0, 168, 150, 0.1);
}

/* Edit Mode Banner */
#editModeBanner {
    display: none;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 18px;
    color: #1e40af;
}

/* Responsive Media Queries */
@media screen and (max-width: 768px) {
    .sched-container {
        padding: 14px 12px;
    }
    .sched-card {
        padding: 18px 14px;
    }
}
</style>

<div class="pag_cstm sched-container">
    <div class="row">
        <div class="col-lg-12">

            <!-- Title Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 14px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-clock-o text-aqua" style="margin-right: 8px;"></i> Schedule Timings &amp; Slot Availability
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Configure your weekly working days, morning/evening session hours, and maximum appointment slots per practice chamber.
                    </p>
                </div>
                <div>
                    <a href="<?=base_url('manageappointment');?>" class="btn btn-default" style="font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-calendar"></i> View Bookings Queue
                    </a>
                </div>
            </div>

            <!-- Flash Alert -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <div class="row">
                <!-- Left: Form to Add/Configure Schedule -->
                <div class="col-md-7 col-xs-12">
                    <div class="sched-card">
                        
                        <!-- Header Bar -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 8px; background: #f0fdfa; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                    <i class="fa fa-calendar-plus-o"></i>
                                </div>
                                <div>
                                    <h3 id="formCardTitle" style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Set Practice Availability</h3>
                                    <p style="font-size: 12px; color: #64748b; margin: 0;">Select your chamber and weekly visiting hours</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-xs btn-default" id="btnResetForm" style="display: none; font-weight: 700; color: #64748b; border-radius: 6px;">
                                <i class="fa fa-undo"></i> Add New Instead
                            </button>
                        </div>

                        <!-- Edit Mode Alert Notice -->
                        <div id="editModeBanner">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <i class="fa fa-info-circle text-primary" style="margin-right: 6px;"></i>
                                    <strong>Editing Schedule:</strong> <span id="editingPracticeName">General Practice</span>
                                </div>
                                <a href="javascript:void(0);" id="btnCancelEdit" style="font-size: 12px; font-weight: 700; color: #2563eb; text-decoration: underline;">
                                    Cancel &amp; Reset
                                </a>
                            </div>
                        </div>

                        <form action="<?=base_url('doctorpanel/datetime');?>" method="post" id="scheduleForm">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="submit" value="1">
                            <input type="hidden" name="timing_id" id="timing_id" value="0">

                            <!-- Select Practice Location -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">
                                    Select Consulting Practice / Chamber *
                                </label>
                                <select name="practice_id" id="practice_id" class="form-control select2-practice" style="width: 100%;" required>
                                    <option value="0" data-fee="500">-- General Practice (All Locations) --</option>
                                    <?php if(!empty($practices)): ?>
                                        <?php foreach($practices as $pr): ?>
                                        <option value="<?=$pr['practice_id'];?>" data-fee="<?=$pr['fee'];?>" data-name="<?=htmlspecialchars($pr['name']);?>">
                                            <?=$pr['type'] == 'H' ? '[Hospital] ' : '[Clinic] ';?><?=htmlspecialchars($pr['name']);?> (₹<?=$pr['fee'];?>)
                                        </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: block;">
                                    Type to search by hospital or clinic name. Saved schedule will load automatically.
                                </span>
                            </div>

                            <!-- Day-Wise Quick Actions Toolbar -->
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; margin-bottom: 18px;">
                                <div>
                                    <span style="font-size: 12.5px; font-weight: 700; color: #0f172a;">Day-Wise OPD Hours &amp; Fees</span>
                                    <span style="display: block; font-size: 11px; color: #64748b;">Configure morning/evening sessions and fees per day</span>
                                </div>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <button type="button" class="btn btn-xs btn-default" id="btnToggleAllDays" style="font-weight: 700; font-size: 11px; border-radius: 6px; color: #475569;" title="Toggle all 7 days on or off">
                                        <i class="fa fa-check-square-o"></i> All Days
                                    </button>
                                    <button type="button" class="btn btn-xs btn-default" id="btnCopyMonday" style="font-weight: 700; font-size: 11px; border-radius: 6px; color: #008f80; border-color: #ccfbf1; background: #f0fdfa;" title="Copy Monday timings and fee to all other days">
                                        <i class="fa fa-clone"></i> Copy Monday to All
                                    </button>
                                </div>
                            </div>

                            <!-- Dynamic Day-By-Day Scheduler List -->
                            <div class="days-scheduler-container">
                                <?php
                                $weekdays = array(
                                    'MON' => array('name' => 'Monday', 'default_on' => true),
                                    'TUE' => array('name' => 'Tuesday', 'default_on' => true),
                                    'WED' => array('name' => 'Wednesday', 'default_on' => true),
                                    'THU' => array('name' => 'Thursday', 'default_on' => true),
                                    'FRI' => array('name' => 'Friday', 'default_on' => true),
                                    'SAT' => array('name' => 'Saturday', 'default_on' => true),
                                    'SUN' => array('name' => 'Sunday', 'default_on' => false)
                                );
                                foreach ($weekdays as $d_code => $d_info):
                                    $is_default_on = $d_info['default_on'];
                                ?>
                                <div class="day-sched-row card" data-day="<?=$d_code;?>" style="border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 14px; overflow: hidden; background: #ffffff;">
                                    <!-- Day Header Bar -->
                                    <div class="day-sched-header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 16px; background: <?=$is_default_on ? '#f8fafc' : '#f1f5f9';?>; border-bottom: 1px solid #e2e8f0;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <input type="checkbox" name="day_sched[<?=$d_code;?>][active]" class="day-active-toggle" id="active_<?=$d_code;?>" value="1" <?=$is_default_on ? 'checked' : '';?> style="width: 17px; height: 17px; cursor: pointer;">
                                            <label for="active_<?=$d_code;?>" style="margin: 0; font-size: 13.5px; font-weight: 800; color: #0f172a; cursor: pointer;">
                                                <?=$d_info['name'];?>
                                            </label>
                                            <span class="day-status-pill badge" style="font-size: 10px; font-weight: 700; background: <?=$is_default_on ? '#dcfce7' : '#e2e8f0';?>; color: <?=$is_default_on ? '#15803d' : '#64748b';?>;">
                                                <?=$is_default_on ? 'Active' : 'Disabled';?>
                                            </span>
                                        </div>

                                        <!-- Custom Fee for this Day -->
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <label style="margin: 0; font-size: 11.5px; font-weight: 700; color: #64748b;">OPD Fee:</label>
                                            <div class="input-group input-group-sm" style="width: 110px;">
                                                <span class="input-group-addon" style="font-weight: 700; background: #f8fafc;">₹</span>
                                                <input type="number" name="day_sched[<?=$d_code;?>][fee]" class="form-control day-fee-input" value="500" min="0" step="50" style="font-weight: 700;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Day Session Inputs (Accordion Body) -->
                                    <div class="day-sched-body" id="body_<?=$d_code;?>" style="padding: 12px 16px; <?=$is_default_on ? '' : 'display: none;';?>">
                                        <!-- Morning Session -->
                                        <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; padding: 10px 12px; margin-bottom: 10px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                                <label style="margin: 0; font-size: 12px; font-weight: 800; color: #92400e; display: flex; align-items: center; gap: 6px;">
                                                    <input type="checkbox" name="day_sched[<?=$d_code;?>][morning_active]" class="sess-toggle m-active" value="1" checked>
                                                    <i class="fa fa-sun-o text-yellow"></i> Morning Session
                                                </label>
                                                <span style="font-size: 11px; color: #b45309; font-weight: 600;">Standard: 09:00 - 13:00</span>
                                            </div>
                                            <div class="row" style="margin-left: -5px; margin-right: -5px;">
                                                <div class="col-xs-4" style="padding-left: 5px; padding-right: 5px;">
                                                    <label style="font-size: 11px; color: #78350f; font-weight: 600; margin-bottom: 3px;">From</label>
                                                    <input type="time" name="day_sched[<?=$d_code;?>][morning_from]" class="form-control input-sm m-from" value="09:00" style="border-radius: 6px;">
                                                </div>
                                                <div class="col-xs-4" style="padding-left: 5px; padding-right: 5px;">
                                                    <label style="font-size: 11px; color: #78350f; font-weight: 600; margin-bottom: 3px;">To</label>
                                                    <input type="time" name="day_sched[<?=$d_code;?>][morning_to]" class="form-control input-sm m-to" value="13:00" style="border-radius: 6px;">
                                                </div>
                                                <div class="col-xs-4" style="padding-left: 5px; padding-right: 5px;">
                                                    <label style="font-size: 11px; color: #78350f; font-weight: 600; margin-bottom: 3px;">Slots/Max</label>
                                                    <input type="number" name="day_sched[<?=$d_code;?>][morning_max]" class="form-control input-sm m-max" value="15" min="1" max="100" style="border-radius: 6px;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Evening Session -->
                                        <div style="background: #faf5ff; border: 1px solid #f3e8ff; border-radius: 8px; padding: 10px 12px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                                <label style="margin: 0; font-size: 12px; font-weight: 800; color: #6b21a8; display: flex; align-items: center; gap: 6px;">
                                                    <input type="checkbox" name="day_sched[<?=$d_code;?>][evening_active]" class="sess-toggle e-active" value="1" checked>
                                                    <i class="fa fa-moon-o" style="color: #9333ea;"></i> Evening Session
                                                </label>
                                                <span style="font-size: 11px; color: #7e22ce; font-weight: 600;">Standard: 17:00 - 21:00</span>
                                            </div>
                                            <div class="row" style="margin-left: -5px; margin-right: -5px;">
                                                <div class="col-xs-4" style="padding-left: 5px; padding-right: 5px;">
                                                    <label style="font-size: 11px; color: #581c87; font-weight: 600; margin-bottom: 3px;">From</label>
                                                    <input type="time" name="day_sched[<?=$d_code;?>][evening_from]" class="form-control input-sm e-from" value="17:00" style="border-radius: 6px;">
                                                </div>
                                                <div class="col-xs-4" style="padding-left: 5px; padding-right: 5px;">
                                                    <label style="font-size: 11px; color: #581c87; font-weight: 600; margin-bottom: 3px;">To</label>
                                                    <input type="time" name="day_sched[<?=$d_code;?>][evening_to]" class="form-control input-sm e-to" value="21:00" style="border-radius: 6px;">
                                                </div>
                                                <div class="col-xs-4" style="padding-left: 5px; padding-right: 5px;">
                                                    <label style="font-size: 11px; color: #581c87; font-weight: 600; margin-bottom: 3px;">Slots/Max</label>
                                                    <input type="number" name="day_sched[<?=$d_code;?>][evening_max]" class="form-control input-sm e-max" value="15" min="1" max="100" style="border-radius: 6px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <button type="submit" id="btnSubmitSchedule" class="btn-save-sched" style="width: 100%; margin-top: 14px; font-weight: 700; height: 48px; border-radius: 10px; background: linear-gradient(135deg, #00a896 0%, #0284c7 100%); color: #ffffff; border: none; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25); cursor: pointer;">
                                <i class="fa fa-check-circle"></i> Save Schedule &amp; Generate Slot Availability
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Active Configured Schedules -->
                <div class="col-md-5 col-xs-12">
                    <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 16px 0;">
                            <i class="fa fa-calendar-check-o text-aqua"></i> Active Practice Schedules
                        </h3>

                        <?php if(!empty($schedules)): ?>
                            <?php foreach($schedules as $s): 
                                $t = $s['timing'];
                            ?>
                            <div class="schedule-card-item" id="sched_card_<?=$t->id;?>">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                                    <div>
                                        <div style="font-size: 14.5px; font-weight: 800; color: #0f172a;">
                                            <i class="fa fa-hospital-o text-aqua" style="margin-right: 4px;"></i> <?=htmlspecialchars($s['inst_name']);?>
                                        </div>
                                        <?php if(!empty($s['inst_address'])): ?>
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                            <i class="fa fa-map-marker text-danger"></i> <?=htmlspecialchars($s['inst_address']);?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div style="display: flex; gap: 4px; align-items: center;">
                                        <button type="button" class="btn btn-xs btn-default btn-edit-schedule" data-timing-id="<?=$t->id;?>" data-practice-id="<?=$t->practice_id;?>" data-name="<?=htmlspecialchars($s['inst_name'], ENT_QUOTES, 'UTF-8');?>" title="Edit this schedule" style="border-radius: 4px; color: #008f80; border-color: #ccfbf1; background: #f0fdfa; font-weight: 700; padding: 3px 8px;">
                                            <i class="fa fa-pencil"></i> Edit
                                        </button>
                                        <a href="<?=base_url('doctorpanel/delete_timing?id='.$t->id);?>" onclick="return confirm('Are you sure you want to delete this practice schedule?');" class="btn btn-xs btn-danger" style="border-radius: 4px; padding: 3px 8px;" title="Delete Schedule">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Days Pill Badges -->
                                <div style="display: flex; gap: 4px; margin-bottom: 12px; flex-wrap: wrap;">
                                    <span class="<?=$t->M ? 'day-badge-on' : 'day-badge-off';?>">M</span>
                                    <span class="<?=$t->T ? 'day-badge-on' : 'day-badge-off';?>">T</span>
                                    <span class="<?=$t->W ? 'day-badge-on' : 'day-badge-off';?>">W</span>
                                    <span class="<?=$t->TH ? 'day-badge-on' : 'day-badge-off';?>">Th</span>
                                    <span class="<?=$t->F ? 'day-badge-on' : 'day-badge-off';?>">F</span>
                                    <span class="<?=$t->SA ? 'day-badge-on' : 'day-badge-off';?>">Sa</span>
                                    <span class="<?=$t->S ? 'day-badge-on' : 'day-badge-off';?>">Su</span>
                                </div>

                                <!-- Sessions & Day-Wise Fees -->
                                <?php if(!empty($s['day_records'])): ?>
                                    <div style="background: #f8fafc; border-radius: 8px; padding: 10px 12px; border: 1px solid #f1f5f9;">
                                        <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">
                                            Day-Wise Hours &amp; Custom Fees
                                        </div>
                                        <?php foreach($s['day_records'] as $dr): ?>
                                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px; margin-bottom: 4px; border-bottom: 1px dashed #e2e8f0; padding-bottom: 3px;">
                                            <span>
                                                <strong style="color: #0f172a; width: 36px; display: inline-block;"><?=$dr->day_of_week;?>:</strong>
                                                <span class="badge" style="font-size: 9.5px; background: <?=$dr->session_type == 'MORNING' ? '#fef3c7' : '#f3e8ff';?>; color: <?=$dr->session_type == 'MORNING' ? '#92400e' : '#6b21a8';?>; font-weight: 700;"><?=ucfirst(strtolower($dr->session_type));?></span>
                                                <span style="color: #334155; margin-left: 4px;"><?=date('h:i A', strtotime($dr->start_time));?> - <?=date('h:i A', strtotime($dr->end_time));?></span>
                                            </span>
                                            <span>
                                                <strong style="color: #008f80;">₹<?=$dr->consultation_fee;?></strong>
                                                <span style="font-size: 10.5px; color: #94a3b8;">(<?=$dr->max_patients;?> max)</span>
                                            </span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php elseif(!empty($s['sessions'])): ?>
                                    <div style="background: #f8fafc; border-radius: 8px; padding: 10px 14px; border: 1px solid #f1f5f9;">
                                        <?php foreach($s['sessions'] as $sess): ?>
                                        <div style="display: flex; justify-content: space-between; font-size: 12.5px; margin-bottom: 4px; color: #334155;">
                                            <span>
                                                <i class="fa fa-clock-o text-muted"></i> <strong><?=$sess->from_timing;?> - <?=$sess->to_timing;?></strong>
                                            </span>
                                            <span style="font-size: 11.5px; color: #00a896; font-weight: 700;">
                                                Max <?=$sess->max_patient;?> Patients
                                            </span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="text-align: center; padding: 30px; color: #94a3b8;">
                                <i class="fa fa-calendar-times-o" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                No active schedules configured yet. Use the form on the left to set up your working hours.
                            </div>
                        <?php endif; ?>
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
// Embedded Saved Practice Schedules Data
window.savedPracticeSchedules = <?=json_encode($schedules);?>;

$(document).ready(function() {

    // 1. Initialize Select2 on Consulting Practice dropdown
    if ($.fn.select2) {
        $('#practice_id').select2({
            placeholder: "Search consulting practice or chamber...",
            allowClear: false,
            width: '100%'
        });
    }

    // 2. Double-Submit Prevention & Basic Validation
    $('#scheduleForm').on('submit', function(e) {
        var activeDaysCount = $('.day-active-toggle:checked').length;
        if (activeDaysCount === 0) {
            e.preventDefault();
            alert('Please select at least one active day to configure your schedule.');
            return false;
        }

        var hasTimeError = false;
        $('.day-sched-row').each(function() {
            var $row = $(this);
            if ($row.find('.day-active-toggle').is(':checked')) {
                var dName = $row.find('label:first').text().trim();
                
                // Morning check
                if ($row.find('.m-active').is(':checked')) {
                    var mFrom = $row.find('.m-from').val();
                    var mTo = $row.find('.m-to').val();
                    if (mFrom && mTo && mTo <= mFrom) {
                        alert(dName + ' Morning Session: "To" time (' + mTo + ') must be later than "From" time (' + mFrom + ').');
                        hasTimeError = true;
                        return false;
                    }
                }
                
                // Evening check
                if ($row.find('.e-active').is(':checked')) {
                    var eFrom = $row.find('.e-from').val();
                    var eTo = $row.find('.e-to').val();
                    if (eFrom && eTo && eTo <= eFrom) {
                        alert(dName + ' Evening Session: "To" time (' + eTo + ') must be later than "From" time (' + eFrom + ').');
                        hasTimeError = true;
                        return false;
                    }
                }
            }
        });

        if (hasTimeError) {
            e.preventDefault();
            return false;
        }

        var $btn = $('#btnSubmitSchedule');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving Schedule & Validating Overlaps...');
    });

    // 3. Toggle Day Card visibility when Active Checkbox changes
    $('.day-active-toggle').on('change', function() {
        var isChecked = $(this).is(':checked');
        var $row = $(this).closest('.day-sched-row');
        var $body = $row.find('.day-sched-body');
        var $pill = $row.find('.day-status-pill');

        if (isChecked) {
            $body.slideDown(150);
            $pill.text('Active').css({'background': '#dcfce7', 'color': '#15803d'});
            $row.find('.day-sched-header').css('background', '#f8fafc');
        } else {
            $body.slideUp(150);
            $pill.text('Disabled').css({'background': '#e2e8f0', 'color': '#64748b'});
            $row.find('.day-sched-header').css('background', '#f1f5f9');
        }
    });

    // 4. "Toggle All Days" Quick Action (Select/Deselect All)
    $('#btnToggleAllDays').on('click', function() {
        var anyUnchecked = $('.day-active-toggle:not(:checked)').length > 0;
        $('.day-active-toggle').prop('checked', anyUnchecked).trigger('change');
    });

    // 5. "Copy Monday to All Days" Quick Action
    $('#btnCopyMonday').on('click', function() {
        var monFee    = $('input[name="day_sched[MON][fee]"]').val();
        var monMFrom  = $('input[name="day_sched[MON][morning_from]"]').val();
        var monMTo    = $('input[name="day_sched[MON][morning_to]"]').val();
        var monMMax   = $('input[name="day_sched[MON][morning_max]"]').val();
        var monMAct   = $('input[name="day_sched[MON][morning_active]"]').is(':checked');

        var monEFrom  = $('input[name="day_sched[MON][evening_from]"]').val();
        var monETo    = $('input[name="day_sched[MON][evening_to]"]').val();
        var monEMax   = $('input[name="day_sched[MON][evening_max]"]').val();
        var monEAct   = $('input[name="day_sched[MON][evening_active]"]').is(':checked');

        var days = ['TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
        days.forEach(function(d) {
            $('input[name="day_sched[' + d + '][fee]"]').val(monFee);
            $('input[name="day_sched[' + d + '][morning_from]"]').val(monMFrom);
            $('input[name="day_sched[' + d + '][morning_to]"]').val(monMTo);
            $('input[name="day_sched[' + d + '][morning_max]"]').val(monMMax);
            $('input[name="day_sched[' + d + '][morning_active]"]').prop('checked', monMAct);

            $('input[name="day_sched[' + d + '][evening_from]"]').val(monEFrom);
            $('input[name="day_sched[' + d + '][evening_to]"]').val(monETo);
            $('input[name="day_sched[' + d + '][evening_max]"]').val(monEMax);
            $('input[name="day_sched[' + d + '][evening_active]"]').prop('checked', monEAct);
        });

        // Flash visual highlight
        $('.day-sched-row:not(:first)').css('box-shadow', '0 0 0 2px #00a896');
        setTimeout(function() {
            $('.day-sched-row:not(:first)').css('box-shadow', 'none');
        }, 700);
    });

    // Helper: Find saved schedule by practice ID
    function findSavedSchedule(practiceId) {
        if (!window.savedPracticeSchedules || !window.savedPracticeSchedules.length) return null;
        for (var i = 0; i < window.savedPracticeSchedules.length; i++) {
            var item = window.savedPracticeSchedules[i];
            if (parseInt(item.timing.practice_id) === parseInt(practiceId)) {
                return item;
            }
        }
        return null;
    }

    // Helper: Load Saved Schedule into Form
    function loadScheduleIntoForm(savedItem) {
        if (!savedItem) return;

        var t = savedItem.timing;
        var pName = savedItem.inst_name || 'Practice';

        $('#timing_id').val(t.id);
        $('#editingPracticeName').text(pName);
        $('#editModeBanner').fadeIn(150);
        $('#btnResetForm').show();
        $('#btnSubmitSchedule').html('<i class="fa fa-refresh"></i> Update Schedule for ' + pName);

        // Day map for flags
        var flagMap = {
            'MON': t.M,
            'TUE': t.T,
            'WED': t.W,
            'THU': t.TH,
            'FRI': t.F,
            'SAT': t.SA,
            'SUN': t.S
        };

        // Reset days state according to flags
        $.each(flagMap, function(dCode, isActive) {
            var $chk = $('#active_' + dCode);
            $chk.prop('checked', parseInt(isActive) === 1).trigger('change');
        });

        // If day_records exist (detailed per-day records)
        if (savedItem.day_records && savedItem.day_records.length > 0) {
            $.each(savedItem.day_records, function(idx, dr) {
                var dCode = dr.day_of_week;
                var $row = $('.day-sched-row[data-day="' + dCode + '"]');
                if ($row.length) {
                    $row.find('.day-fee-input').val(dr.consultation_fee);
                    
                    if (dr.session_type === 'MORNING') {
                        $row.find('.m-active').prop('checked', parseInt(dr.is_active) === 1);
                        if (dr.start_time) $row.find('.m-from').val(dr.start_time.substring(0, 5));
                        if (dr.end_time) $row.find('.m-to').val(dr.end_time.substring(0, 5));
                        if (dr.max_patients) $row.find('.m-max').val(dr.max_patients);
                    } else if (dr.session_type === 'EVENING') {
                        $row.find('.e-active').prop('checked', parseInt(dr.is_active) === 1);
                        if (dr.start_time) $row.find('.e-from').val(dr.start_time.substring(0, 5));
                        if (dr.end_time) $row.find('.e-to').val(dr.end_time.substring(0, 5));
                        if (dr.max_patients) $row.find('.e-max').val(dr.max_patients);
                    }
                }
            });
        }
    }

    // Reset Form to Default State
    function resetScheduleForm() {
        $('#timing_id').val('0');
        $('#editModeBanner').fadeOut(150);
        $('#btnResetForm').hide();
        $('#btnSubmitSchedule').html('<i class="fa fa-check-circle"></i> Save Schedule &amp; Generate Slot Availability');
        
        // Reset default 6 days on, Sunday off
        var defaultOn = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
        $('.day-sched-row').each(function() {
            var dCode = $(this).attr('data-day');
            var isDef = defaultOn.indexOf(dCode) !== -1;
            $(this).find('.day-active-toggle').prop('checked', isDef).trigger('change');
            $(this).find('.m-active').prop('checked', true);
            $(this).find('.e-active').prop('checked', true);
            $(this).find('.m-from').val('09:00');
            $(this).find('.m-to').val('13:00');
            $(this).find('.m-max').val('15');
            $(this).find('.e-from').val('17:00');
            $(this).find('.e-to').val('21:00');
            $(this).find('.e-max').val('15');
        });
        
        var defaultFee = $('#practice_id').find('option:selected').data('fee') || 500;
        $('.day-fee-input').val(defaultFee);
    }

    // 6. Practice Dropdown Change -> Auto-fill Fee or Pre-fill existing schedule
    $('#practice_id').on('change select2:select', function() {
        var pid = $(this).val();
        var saved = findSavedSchedule(pid);
        if (saved) {
            loadScheduleIntoForm(saved);
        } else {
            resetScheduleForm();
            var fee = $(this).find('option:selected').data('fee') || 500;
            $('.day-fee-input').val(fee);
        }
    });

    // 7. Click "Edit" on Schedule Card Item (Right Column)
    $(document).on('click', '.btn-edit-schedule', function(e) {
        e.preventDefault();
        var tid = $(this).attr('data-timing-id');
        var pid = $(this).attr('data-practice-id');
        
        // Select in practice dropdown
        $('#practice_id').val(pid).trigger('change.select2');

        var saved = findSavedSchedule(pid);
        if (saved) {
            loadScheduleIntoForm(saved);
        }

        // Smooth scroll to form
        $('html, body').animate({
            scrollTop: $('.sched-card').offset().top - 80
        }, 300);
    });

    // 8. Cancel Edit / Reset Form Button
    $('#btnCancelEdit, #btnResetForm').on('click', function(e) {
        e.preventDefault();
        resetScheduleForm();
    });

});
</script>