<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
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
    padding: 28px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
}

.day-checkbox-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
}

.day-checkbox-pill:hover {
    border-color: var(--upchar-teal);
    background: #f0fdfa;
}

.day-checkbox-pill input[type="checkbox"] {
    margin: 0;
    cursor: pointer;
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

.session-box {
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
}

.btn-save-sched {
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 8px;
    padding: 11px 28px;
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
    padding: 22px;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, border-color 0.2s ease;
}

.schedule-card-item:hover {
    transform: translateY(-2px);
    border-color: var(--upchar-teal);
    box-shadow: 0 8px 20px rgba(0, 168, 150, 0.1);
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
                        Configure your weekly working days, morning/evening session hours, and maximum appointment slots per day.
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
                <div class="col-md-7 col-12">
                    <div class="sched-card">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
                            <div style="width: 38px; height: 38px; border-radius: 8px; background: #f0fdfa; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                <i class="fa fa-plus-circle"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Set Practice Availability</h3>
                                <p style="font-size: 12px; color: #64748b; margin: 0;">Select your chamber and weekly visiting hours</p>
                            </div>
                        </div>

                        <form action="<?=base_url('doctorpanel/datetime');?>" method="post">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                            <input type="hidden" name="submit" value="1">

                            <!-- Select Practice Location -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">
                                    Select Consulting Practice / Chamber *
                                </label>
                                <select name="practice_id" class="form-control" style="height: 46px; border-radius: 10px; border-color: var(--upchar-border);" required>
                                    <option value="0">-- General Practice (All Locations) --</option>
                                    <?php if(!empty($practices)): ?>
                                        <?php foreach($practices as $pr): ?>
                                        <option value="<?=$pr['practice_id'];?>">
                                            <?=$pr['type'] == 'H' ? '[Hospital] ' : '[Clinic] ';?><?=htmlspecialchars($pr['name']);?> (₹<?=$pr['fee'];?>)
                                        </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Working Days -->
                            <div class="form-group" style="margin-bottom: 22px;">
                                <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block;">
                                    Weekly Consulting Days *
                                </label>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <label class="day-checkbox-pill"><input type="checkbox" name="days[]" value="M" checked> Mon</label>
                                    <label class="day-checkbox-pill"><input type="checkbox" name="days[]" value="T" checked> Tue</label>
                                    <label class="day-checkbox-pill"><input type="checkbox" name="days[]" value="W" checked> Wed</label>
                                    <label class="day-checkbox-pill"><input type="checkbox" name="days[]" value="TH" checked> Thu</label>
                                    <label class="day-checkbox-pill"><input type="checkbox" name="days[]" value="F" checked> Fri</label>
                                    <label class="day-checkbox-pill"><input type="checkbox" name="days[]" value="SA" checked> Sat</label>
                                    <label class="day-checkbox-pill"><input type="checkbox" name="days[]" value="S"> Sun</label>
                                </div>
                            </div>

                            <!-- Session 1: Morning Hours -->
                            <div class="session-box">
                                <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa fa-sun-o text-yellow"></i> Morning Session Timings
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12" style="margin-bottom: 8px;">
                                        <label style="font-size: 11.5px; font-weight: 700; color: #64748b;">From Time</label>
                                        <input type="time" name="morning_from" class="form-control" value="09:00" style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-4 col-12" style="margin-bottom: 8px;">
                                        <label style="font-size: 11.5px; font-weight: 700; color: #64748b;">To Time</label>
                                        <input type="time" name="morning_to" class="form-control" value="13:00" style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-4 col-12" style="margin-bottom: 8px;">
                                        <label style="font-size: 11.5px; font-weight: 700; color: #64748b;">Max Patients</label>
                                        <input type="number" name="morning_max" class="form-control" value="15" min="1" max="100" style="border-radius: 8px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Session 2: Evening Hours -->
                            <div class="session-box">
                                <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa fa-moon-o text-purple" style="color: #7c3aed;"></i> Evening Session Timings
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12" style="margin-bottom: 8px;">
                                        <label style="font-size: 11.5px; font-weight: 700; color: #64748b;">From Time</label>
                                        <input type="time" name="evening_from" class="form-control" value="17:00" style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-4 col-12" style="margin-bottom: 8px;">
                                        <label style="font-size: 11.5px; font-weight: 700; color: #64748b;">To Time</label>
                                        <input type="time" name="evening_to" class="form-control" value="21:00" style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-4 col-12" style="margin-bottom: 8px;">
                                        <label style="font-size: 11.5px; font-weight: 700; color: #64748b;">Max Patients</label>
                                        <input type="number" name="evening_max" class="form-control" value="15" min="1" max="100" style="border-radius: 8px;">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-save-sched" style="width: 100%; margin-top: 8px;">
                                <i class="fa fa-check"></i> Save Schedule &amp; Generate Slot Availability
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Active Configured Schedules -->
                <div class="col-md-5 col-12">
                    <div style="background: #ffffff; border: 1px solid var(--upchar-border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 24px;">
                        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 16px 0;">
                            <i class="fa fa-calendar-check-o text-aqua"></i> Active Practice Schedules
                        </h3>

                        <?php if(!empty($schedules)): ?>
                            <?php foreach($schedules as $s): 
                                $t = $s['timing'];
                            ?>
                            <div class="schedule-card-item">
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
                                    <a href="<?=base_url('doctorpanel/delete_timing?id='.$t->id);?>" onclick="return confirm('Delete this practice timing?');" class="btn btn-xs btn-danger" style="border-radius: 4px;" title="Delete Schedule">
                                        <i class="fa fa-trash"></i>
                                    </a>
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

                                <!-- Sessions -->
                                <?php if(!empty($s['sessions'])): ?>
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