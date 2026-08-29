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

.appt-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Page Header */
.appt-header-card {
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

.appt-title-group h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.appt-title-group p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

.btn-add-appt {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    padding: 9px 18px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 2px 6px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
}

.btn-add-appt:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.35);
}

/* KPI Summary Cards */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.kpi-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 18px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    text-decoration: none !important;
    color: inherit;
}

.kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
}

.kpi-text h3 {
    font-size: 24px;
    font-weight: 800;
    margin: 0 0 2px 0;
    color: #0f172a;
}

.kpi-text span {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.kpi-badge-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.kpi-teal { background: #ccfbf1; color: #0d9488; }
.kpi-amber { background: #fef3c7; color: #d97706; }
.kpi-blue { background: #e0f2fe; color: #0284c7; }
.kpi-green { background: #dcfce7; color: #16a34a; }
.kpi-red { background: #fee2e2; color: #dc2626; }

/* Filter Card */
.filter-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}

.filter-pill {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12.5px;
    font-weight: 600;
    color: #475569;
    background: #f1f5f9;
    text-decoration: none !important;
    transition: all 0.15s ease;
    border: 1px solid transparent;
}

.filter-pill:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.filter-pill.active {
    background: #00a896;
    color: #ffffff;
    border-color: #008f80;
}

.filter-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
    align-items: flex-end;
}

.filter-field label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 5px;
}

.filter-field input,
.filter-field select {
    width: 100%;
    height: 38px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    color: #1e293b;
    background: #ffffff;
    transition: border-color 0.15s ease;
}

.filter-field input:focus,
.filter-field select:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.filter-actions {
    display: flex;
    gap: 8px;
}

.btn-filter-search {
    background: #043d5b;
    color: #ffffff;
    font-weight: 700;
    font-size: 13px;
    height: 38px;
    padding: 0 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex: 1;
    justify-content: center;
    transition: background 0.15s;
}

.btn-filter-search:hover {
    background: #022b40;
}

.btn-filter-reset {
    background: #f1f5f9;
    color: #64748b;
    font-weight: 600;
    font-size: 13px;
    height: 38px;
    padding: 0 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
    transition: all 0.15s;
}

.btn-filter-reset:hover {
    background: #e2e8f0;
    color: #0f172a;
}

/* Appointments Data Table Card */
.table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-responsive {
    margin: 0;
    border: none;
}

.custom-appt-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.custom-appt-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}

.custom-appt-table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

.custom-appt-table tbody tr:hover td {
    background: #f8fafc;
}

/* Patient & Doctor Sub-Blocks */
.patient-profile-block {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.patient-name-text {
    font-weight: 700;
    color: #0f172a;
    font-size: 13.5px;
}

.patient-phone-link {
    font-size: 12px;
    color: #00a896;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-weight: 600;
}

.patient-phone-link:hover {
    text-decoration: underline !important;
}

.doctor-profile-block {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.doctor-name-text {
    font-weight: 700;
    color: #043d5b;
    font-size: 13px;
    text-decoration: none !important;
}

.doctor-qual-text {
    font-size: 11.5px;
    color: #64748b;
}

/* Schedule Time Badge */
.schedule-date-text {
    font-weight: 700;
    color: #1e293b;
    font-size: 13px;
}

.schedule-slot-pill {
    display: inline-block;
    background: #f1f5f9;
    color: #475569;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    margin-top: 3px;
}

/* Status Badges */
.badge-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
}

.badge-paid { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.badge-unpaid { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
.badge-done { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
.badge-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

/* Quick Action Buttons */
.action-btn-group {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: nowrap;
}

.btn-action-sm {
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
    border: none;
    cursor: pointer;
}

.btn-action-done {
    background: #dcfce7;
    color: #15803d !important;
    border: 1px solid #bbf7d0;
}
.btn-action-done:hover {
    background: #16a34a;
    color: #ffffff !important;
}

.btn-action-pay {
    background: #fef3c7;
    color: #b45309 !important;
    border: 1px solid #fde68a;
}
.btn-action-pay:hover {
    background: #d97706;
    color: #ffffff !important;
}

.btn-action-view {
    background: #f1f5f9;
    color: #475569 !important;
    border: 1px solid #e2e8f0;
}
.btn-action-view:hover {
    background: #043d5b;
    color: #ffffff !important;
}

/* Bulk Toolbar & Footer */
.table-footer-bar {
    padding: 16px 20px;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
}

.bulk-actions-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-bulk-submit {
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    transition: all 0.15s ease;
}

.btn-bulk-paid {
    background: #00a896;
    color: #ffffff;
}
.btn-bulk-paid:hover {
    background: #008f80;
}

.btn-bulk-done {
    background: #043d5b;
    color: #ffffff;
}
.btn-bulk-done:hover {
    background: #022b40;
}

/* Pagination container */
.pagination-wrap ul {
    margin: 0;
    padding: 0;
    display: flex;
    gap: 4px;
    list-style: none;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="appt-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="appt-header-card">
            <div class="appt-title-group">
                <h1>Manage Hospital Appointments</h1>
                <p>Monitor patient registrations, doctor schedules, payments, and consultation statuses.</p>
            </div>
            <div>
                <a href="<?=base_url('hospitalpanel/addappointment');?>" class="btn-add-appt">
                    <i class="fa fa-plus-circle"></i> Create Walk-in / New Appointment
                </a>
            </div>
        </div>

        <!-- KPI Summary Cards -->
        <div class="kpi-grid">
            <a href="<?=base_url('hospitalpanel/manageappointment');?>" class="kpi-card">
                <div class="kpi-text">
                    <h3><?=$total_count;?></h3>
                    <span>Total Bookings</span>
                </div>
                <div class="kpi-badge-icon kpi-teal">
                    <i class="fa fa-calendar-check-o"></i>
                </div>
            </a>

            <a href="<?=base_url('hospitalpanel/manageappointment?day_category=Today');?>" class="kpi-card">
                <div class="kpi-text">
                    <h3><?=$today_count;?></h3>
                    <span>Today's Visits</span>
                </div>
                <div class="kpi-badge-icon kpi-amber">
                    <i class="fa fa-clock-o"></i>
                </div>
            </a>

            <a href="<?=base_url('hospitalpanel/manageappointment?appointment_status=0');?>" class="kpi-card">
                <div class="kpi-text">
                    <h3><?=$pending_count;?></h3>
                    <span>Pending / In Queue</span>
                </div>
                <div class="kpi-badge-icon kpi-blue">
                    <i class="fa fa-hourglass-half"></i>
                </div>
            </a>

            <a href="<?=base_url('hospitalpanel/manageappointment?appointment_status=1');?>" class="kpi-card">
                <div class="kpi-text">
                    <h3><?=$completed_count;?></h3>
                    <span>Completed / Visited</span>
                </div>
                <div class="kpi-badge-icon kpi-green">
                    <i class="fa fa-check-circle"></i>
                </div>
            </a>

            <a href="<?=base_url('hospitalpanel/manageappointment?payment_status=UNPAID');?>" class="kpi-card">
                <div class="kpi-text">
                    <h3><?=$unpaid_count;?></h3>
                    <span>Unpaid Fees</span>
                </div>
                <div class="kpi-badge-icon kpi-red">
                    <i class="fa fa-exclamation-circle"></i>
                </div>
            </a>
        </div>

        <!-- Filter & Search Section -->
        <div class="filter-card">
            <?php 
            $curr_day = $this->input->get_post('day_category');
            $curr_d = $this->input->get_post('d');
            if($curr_d == date('Y-m-d')) { $curr_day = 'Today'; }
            ?>
            <!-- Quick Filter Pills -->
            <div class="filter-pills">
                <span style="font-size: 12px; font-weight: 700; color: #64748b; margin-right: 4px; align-self: center;">Quick Filter:</span>
                <a href="<?=base_url('hospitalpanel/manageappointment');?>" class="filter-pill <?=empty($curr_day) && empty($this->input->get_post('date_from')) && empty($this->input->get_post('appointment_status')) && empty($this->input->get_post('payment_status')) ? 'active' : '';?>">All Dates</a>
                <a href="<?=base_url('hospitalpanel/manageappointment?day_category=Today');?>" class="filter-pill <?=$curr_day=='Today' ? 'active' : '';?>"><i class="fa fa-calendar-o"></i> Today</a>
                <a href="<?=base_url('hospitalpanel/manageappointment?day_category=Tomorrow');?>" class="filter-pill <?=$curr_day=='Tomorrow' ? 'active' : '';?>">Tomorrow</a>
                <a href="<?=base_url('hospitalpanel/manageappointment?day_category=ThisWeek');?>" class="filter-pill <?=$curr_day=='ThisWeek' ? 'active' : '';?>">Next 7 Days</a>
                <a href="<?=base_url('hospitalpanel/manageappointment?day_category=Upcomming');?>" class="filter-pill <?=$curr_day=='Upcomming' ? 'active' : '';?>">All Upcoming</a>
                <a href="<?=base_url('hospitalpanel/manageappointment?day_category=Past');?>" class="filter-pill <?=$curr_day=='Past' ? 'active' : '';?>">Past Visits</a>
            </div>

            <!-- Advanced Form Filters -->
            <?php echo form_open("hospitalpanel/manageappointment/", 'class="form-horizontal" id="search_form" method="get"'); ?>
                <div class="filter-form-grid">
                    
                    <!-- Keyword Search -->
                    <div class="filter-field" style="grid-column: span 2;">
                        <label><i class="fa fa-search"></i> Search Patient / Mobile / Appt ID</label>
                        <input type="text" name="keyword" value="<?php echo html_escape($this->input->get_post('keyword')); ?>" placeholder="e.g. John Doe, 9876543210, #1042">
                    </div>

                    <!-- Doctor Dropdown -->
                    <div class="filter-field">
                        <label><i class="fa fa-user-md"></i> Assigned Doctor</label>
                        <select name="doctor_id">
                            <option value="">All Hospital Doctors</option>
                            <?php if(!empty($hospital_doctors)): ?>
                                <?php foreach($hospital_doctors as $doc): ?>
                                    <option value="<?=$doc->id;?>" <?=$this->input->get_post('doctor_id')==$doc->id ? 'selected' : '';?>>
                                        <?=prefixdr($doc->fname).' '.$doc->lname;?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Payment Status -->
                    <div class="filter-field">
                        <label><i class="fa fa-credit-card"></i> Payment Status</label>
                        <select name="payment_status">
                            <option value="">All Payment Statuses</option>
                            <option value="DONE" <?=$this->input->get_post('payment_status')=='DONE' ? 'selected' : '';?>>Paid</option>
                            <option value="UNPAID" <?=$this->input->get_post('payment_status')=='UNPAID' ? 'selected' : '';?>>Unpaid</option>
                        </select>
                    </div>

                    <!-- Appointment Status -->
                    <div class="filter-field">
                        <label><i class="fa fa-check-square-o"></i> Visit Status</label>
                        <select name="appointment_status">
                            <option value="">All Visit Statuses</option>
                            <option value="0" <?=$this->input->get_post('appointment_status')==='0' ? 'selected' : '';?>>Pending / In Queue</option>
                            <option value="1" <?=$this->input->get_post('appointment_status')==='1' ? 'selected' : '';?>>Completed / Visited</option>
                        </select>
                    </div>

                    <!-- From Date -->
                    <div class="filter-field">
                        <label><i class="fa fa-calendar"></i> From Date</label>
                        <input type="date" name="date_from" value="<?php echo html_escape($this->input->get_post('date_from')); ?>">
                    </div>

                    <!-- To Date -->
                    <div class="filter-field">
                        <label><i class="fa fa-calendar"></i> To Date</label>
                        <input type="date" name="date_to" value="<?php echo html_escape($this->input->get_post('date_to')); ?>">
                    </div>

                    <!-- Filter Action Buttons -->
                    <div class="filter-field filter-actions">
                        <button type="submit" class="btn-filter-search">
                            <i class="fa fa-filter"></i> Apply Filters
                        </button>
                        <a href="<?=base_url('hospitalpanel/manageappointment');?>" class="btn-filter-reset" title="Reset All Filters">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>

                </div>
            <?php echo form_close(); ?>
        </div>

        <!-- Appointment Data Table -->
        <div class="table-card">
            <?php 
            $att = array('class' => 'form-horizontal', 'id' => 'bulk_action_form');
            echo form_open("hospitalpanel/manageappointment/", $att); 
            ?>
            <div class="table-responsive">
                <table class="table custom-appt-table">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="checkall" onClick="check_uncheck_checkbox(this.checked);" style="cursor: pointer;">
                            </th>
                            <th>Appt #</th>
                            <th>Patient Information</th>
                            <th>Attending Doctor</th>
                            <th>Schedule &amp; Slot</th>
                            <th>Fee</th>
                            <th>Payment</th>
                            <th>Visit Status</th>
                            <th style="text-align: right;">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($appointments)): ?>
                            <?php foreach($appointments as $p): ?>
                                <tr>
                                    <!-- Checkbox -->
                                    <td style="text-align: center;">
                                        <input type="checkbox" name="arr_ids[]" value="<?=$p->appointment_id;?>" class="appt-checkbox" style="cursor: pointer;">
                                    </td>

                                    <!-- Appointment ID -->
                                    <td>
                                        <span style="font-weight: 800; color: #043d5b; font-size: 13px;">#<?=$p->appointment_id;?></span>
                                    </td>

                                    <!-- Patient Info -->
                                    <td>
                                        <div class="patient-profile-block">
                                            <span class="patient-name-text">
                                                <?=!empty($p->patient_name) ? html_escape($p->patient_name) : 'Walk-in Patient';?>
                                            </span>
                                            <?php if(!empty($p->appointment_mobile)): ?>
                                                <a href="tel:<?=$p->appointment_mobile;?>" class="patient-phone-link">
                                                    <i class="fa fa-phone"></i> <?=$p->appointment_mobile;?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Doctor Info -->
                                    <td>
                                        <div class="doctor-profile-block">
                                            <a href="<?=base_url('doctor/'.$p->doctor_id);?>" target="_blank" class="doctor-name-text">
                                                <i class="fa fa-user-md" style="color: #00a896;"></i> 
                                                <?=prefixdr($p->fname).' '.$p->lname;?>
                                            </a>
                                            <?php if(!empty($p->qualification)): ?>
                                                <span class="doctor-qual-text"><?=$p->qualification;?></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Schedule & Slot -->
                                    <td>
                                        <div class="schedule-date-text">
                                            <i class="fa fa-calendar-o" style="color: #64748b; font-size: 12px;"></i>
                                            <?=date('d M, Y', strtotime($p->appointment_date));?>
                                        </div>
                                        <?php if(!empty($p->from_timing)): ?>
                                            <span class="schedule-slot-pill">
                                                <i class="fa fa-clock-o"></i> <?=$p->from_timing;?> - <?=$p->to_timing;?>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Fee -->
                                    <td>
                                        <span style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                            ₹<?=number_format($p->amount > 0 ? $p->amount : $p->fee);?>
                                        </span>
                                    </td>

                                    <!-- Payment Status -->
                                    <td>
                                        <?php if($p->payment_status == 'DONE'): ?>
                                            <span class="badge-status badge-paid"><i class="fa fa-check"></i> Paid</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-unpaid"><i class="fa fa-clock-o"></i> Unpaid</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Appointment Status -->
                                    <td>
                                        <?php if($p->appointment_status == '1'): ?>
                                            <span class="badge-status badge-done"><i class="fa fa-check-circle"></i> Visited / Done</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-pending"><i class="fa fa-hourglass-start"></i> In Queue</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Action Buttons -->
                                    <td style="text-align: right;">
                                        <div class="action-btn-group" style="justify-content: flex-end;">
                                            
                                            <!-- Complete visit action -->
                                            <?php if($p->appointment_status != '1'): ?>
                                                <a href="<?=base_url('hospitalpanel/complete_appointment?aid='.$p->appointment_id);?>" onclick="return confirm('Mark Appointment #<?=$p->appointment_id;?> as Visited/Completed?');" class="btn-action-sm btn-action-done" title="Mark Patient Visit Complete">
                                                    <i class="fa fa-check"></i> Visited
                                                </a>
                                            <?php endif; ?>

                                            <!-- Mark paid action -->
                                            <?php if($p->payment_status != 'DONE'): ?>
                                                <a href="<?=base_url('hospitalpanel/mark_paid?aid='.$p->appointment_id);?>" onclick="return confirm('Confirm fee payment collection for Appointment #<?=$p->appointment_id;?>?');" class="btn-action-sm btn-action-pay" title="Mark Fee as Paid">
                                                    <i class="fa fa-money"></i> Pay
                                                </a>
                                            <?php endif; ?>

                                            <!-- View / Patient History -->
                                            <a href="<?=base_url('hospitalpanel/patient/'.$p->appointment_id);?>" class="btn-action-sm btn-action-view" title="View Patient Details / Clinical History">
                                                <i class="fa fa-eye"></i> Details
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                    <i class="fa fa-calendar-times-o" style="font-size: 38px; display: block; margin-bottom: 10px; color: #cbd5e1;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Appointments Found</strong>
                                    <span>Try clearing your search filters or create a new appointment booking.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer: Bulk Operations & Pagination -->
            <div class="table-footer-bar">
                <div class="bulk-actions-wrap">
                    <span style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-right: 4px;">With Selected:</span>
                    <input name="status_action" type="submit" value="Payment Done" class="btn-bulk-submit btn-bulk-paid" onClick="return validcheckstatus('arr_ids[]','Payment Done','Record');">
                    <input name="status_action" type="submit" value="Appointment Done" class="btn-bulk-submit btn-bulk-done" onClick="return validcheckstatus('arr_ids[]','Appointment Done','Record');">
                </div>
                
                <div class="pagination-wrap">
                    <?php echo $page_links; ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
function check_uncheck_checkbox(isChecked) {
    $('.appt-checkbox').prop('checked', isChecked);
}

function validcheckstatus(name, action, text) {
    var anyChecked = false;
    $('input[name="' + name + '"]').each(function() {
        if ($(this).prop('checked')) {
            anyChecked = true;
            return false;
        }
    });

    if (!anyChecked) {
        alert("Please select at least one " + text + " to mark as " + action + ".");
        return false;
    }
    return confirm("Are you sure you want to mark the selected appointments as " + action + "?");
}
</script>
