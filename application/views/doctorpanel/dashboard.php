<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<!-- Chart.js for High-Definition Clinical Telemetry & Visualizations -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<style>
:root {
    --adm-navy: #0d1b2a;
    --adm-navy-light: #1b263b;
    --adm-teal: #00a896;
    --adm-teal-dark: #008f80;
    --adm-slate-900: #0f172a;
    --adm-slate-800: #1e293b;
    --adm-slate-700: #334155;
    --adm-slate-600: #475569;
    --adm-slate-100: #f8fafc;
    --adm-border: #e2e8f0;
}

.dashboard-wrapper {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: var(--adm-slate-800);
    padding: 20px 24px;
    background: #f8fafc;
    min-height: 88vh;
}

/* Breadcrumb Header */
.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
}

.content-header h1 {
    color: var(--adm-slate-900) !important;
    font-weight: 800;
    font-size: 22px;
    margin: 0;
    line-height: 1.2;
}

.content-header h1 small {
    color: var(--adm-slate-600) !important;
    font-size: 13px;
    font-weight: 500;
    display: block;
    margin-top: 4px;
}

.breadcrumb-custom {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    color: var(--adm-slate-600);
    list-style: none;
    margin: 0;
    padding: 0;
}

.breadcrumb-custom a {
    color: var(--adm-teal);
    text-decoration: none;
    font-weight: 600;
}

/* Executive Section Banner */
.section-banner {
    background: linear-gradient(135deg, #0d1b2a 0%, #043d5b 55%, #008f80 100%);
    color: #ffffff;
    border-radius: 14px;
    padding: 22px 26px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 10px 25px -5px rgba(13, 27, 42, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.section-banner::after {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.section-banner h2 {
    margin: 0 0 6px 0;
    font-size: 20px;
    font-weight: 800;
    letter-spacing: -0.3px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ffffff;
}

/* 8 Core Metrics Grid */
.dash-metric-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 25px;
}

@media (max-width: 1200px) {
    .dash-metric-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .dash-metric-grid {
        grid-template-columns: 1fr;
    }
}

.dash-metric-link {
    text-decoration: none !important;
    display: flex;
    height: 100%;
    color: inherit;
}

/* Metric Cards */
.dash-metric-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 20px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    margin-bottom: 0;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.dash-metric-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px -2px rgba(0,0,0,0.08);
    border-color: var(--adm-teal);
}

.dash-metric-top {
    display: flex;
    flex-direction: column;
}

.dash-metric-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 12px;
}

.icon-blue { background: #e0f2fe; color: #0284c7; }
.icon-green { background: #dcfce7; color: #16a34a; }
.icon-amber { background: #fef3c7; color: #d97706; }
.icon-purple { background: #f3e8ff; color: #9333ea; }
.icon-red { background: #fee2e2; color: #dc2626; }
.icon-teal { background: #ccfbf1; color: #0d9488; }
.icon-indigo { background: #e0e7ff; color: #4f46e5; }
.icon-rose { background: #ffe4e6; color: #e11d48; }

.dash-metric-num {
    font-size: 24px;
    font-weight: 800;
    color: var(--adm-slate-900);
    line-height: 1.1;
    margin-bottom: 4px;
}

.dash-metric-label {
    font-size: 13px;
    font-weight: 700;
    color: var(--adm-slate-700);
}

.dash-metric-sub {
    font-size: 11.5px;
    color: var(--adm-slate-600);
    margin-top: 10px;
    font-weight: 500;
}

/* Chart & Card Boxes */
.dash-box {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    margin-bottom: 25px;
    overflow: hidden;
}

.dash-box-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--adm-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
}

.dash-box-title {
    font-size: 15px;
    font-weight: 800;
    color: var(--adm-slate-900);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dash-box-body {
    padding: 20px;
}

/* Quick Actions Grid */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

@media (max-width: 600px) {
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
}

.quick-action-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid var(--adm-border);
    color: var(--adm-slate-800);
    text-decoration: none !important;
    transition: all 0.2s;
    margin-bottom: 0;
    height: 100%;
}

.quick-action-card:hover {
    background: #ffffff;
    border-color: var(--adm-teal);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.1);
    color: var(--adm-teal);
    transform: translateX(3px);
}

.quick-action-icon {
    width: 42px;
    height: 42px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

/* Badges */
.badge-status {
    padding: 4px 9px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.badge-paid { background: #dcfce7; color: #15803d; }
.badge-unpaid { background: #fee2e2; color: #991b1b; }
.badge-visited { background: #e0f2fe; color: #0369a1; }
</style>

<div class="pag_cstm dashboard-wrapper">
    <!-- Breadcrumb Header -->
    <div class="content-header">
        <div>
            <h1>
                <i class="fa fa-user-md" style="color: var(--adm-teal);"></i> Clinical Practitioner Workspace
                <small>Doctor Telemetry, Consultations Schedule &amp; Financial Analytics</small>
            </h1>
        </div>
        <ul class="breadcrumb-custom">
            <li><a href="<?=base_url('doctor-dashboard');?>"><i class="fa fa-home"></i> Home</a></li>
            <li><i class="fa fa-angle-right" style="font-size: 11px;"></i></li>
            <li style="color: var(--adm-slate-800); font-weight: 700;">Doctor Dashboard</li>
        </ul>
    </div>

    <!-- Executive Section Banner -->
    <?php 
    $doc_name = $this->session->userdata('drusername') ?: 'Anushka';
    $doc_lname = $this->session->userdata('druserlname') ?: '';
    ?>
    <div class="section-banner">
        <div>
            <h2>
                <i class="fa fa-stethoscope" style="color: #2dd4bf;"></i> 
                Welcome back, Dr. <?=$doc_name;?> <?=$doc_lname;?>
            </h2>
            <div style="font-size: 13px; color: rgba(255, 255, 255, 0.9);">
                <i class="fa fa-clock-o"></i> Live Synchronized: <?=date('d M Y, h:i A');?> &bull; Verified Medical Practitioner
            </div>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="<?=base_url('doctorpanel/datetime');?>" class="btn" style="background: rgba(255,255,255,0.18); color: #ffffff; font-weight: 700; border-radius: 8px; padding: 8px 16px; border: 1px solid rgba(255,255,255,0.3);">
                <i class="fa fa-clock-o"></i> Set Slot Availability
            </a>
            <a href="<?=base_url('doctorpanel/earnings');?>" class="btn" style="background: #ffffff; color: #043d5b; font-weight: 800; border-radius: 8px; padding: 8px 18px; box-shadow: 0 4px 14px rgba(0,0,0,0.15);">
                <i class="fa fa-line-chart"></i> View Financials
            </a>
        </div>
    </div>

    <!-- Flash Alert -->
    <?php if($this->session->flashdata('flashmsg')): ?>
        <?=$this->session->flashdata('flashmsg');?>
    <?php endif; ?>

    <!-- 8 Core Metrics Grid (Auto-responsive & Equal Height) -->
    <div class="dash-metric-grid">
        <!-- 1. Today's Consultations -->
        <a href="<?=base_url('manageappointment');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div class="dash-metric-top">
                    <div class="dash-metric-icon-wrap icon-amber">
                        <i class="fa fa-calendar-check-o"></i>
                    </div>
                    <div class="dash-metric-num"><?=number_format($todayappointment);?></div>
                    <div class="dash-metric-label">Today's Visits</div>
                </div>
                <div class="dash-metric-sub">
                    <span class="label label-warning" style="background: #fef3c7 !important; color: #d97706 !important; border: 1px solid #fde68a; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">
                        <i class="fa fa-calendar"></i> Scheduled for <?=date('d M Y');?>
                    </span>
                </div>
            </div>
        </a>

        <!-- 2. Net Doctor Earnings -->
        <a href="<?=base_url('doctorpanel/earnings');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div class="dash-metric-top">
                    <div class="dash-metric-icon-wrap icon-teal">
                        <i class="fa fa-inr"></i>
                    </div>
                    <div class="dash-metric-num">₹<?=number_format(@$earnings->total_net, 2);?></div>
                    <div class="dash-metric-label">Net Doctor Earnings</div>
                </div>
                <div class="dash-metric-sub">
                    <span class="label label-success" style="background: #dcfce7 !important; color: #16a34a !important; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">
                        <i class="fa fa-check-circle"></i> Minus 10% Platform Fee
                    </span>
                </div>
            </div>
        </a>

        <!-- 3. Total Booked Consultations -->
        <a href="<?=base_url('manageappointment');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div class="dash-metric-top">
                    <div class="dash-metric-icon-wrap icon-blue">
                        <i class="fa fa-stethoscope"></i>
                    </div>
                    <div class="dash-metric-num"><?=number_format($totalappointment);?></div>
                    <div class="dash-metric-label">Total Consultations</div>
                </div>
                <div class="dash-metric-sub" style="display: flex; gap: 6px; flex-wrap: wrap;">
                    <span class="label label-success" style="background: #dcfce7 !important; color: #16a34a !important; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">
                        <i class="fa fa-check"></i> <?=number_format($completed_appointments);?> Visited
                    </span>
                    <span class="label label-info" style="background: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">
                        <i class="fa fa-clock-o"></i> <?=number_format($pending_appointments);?> Upcoming
                    </span>
                </div>
            </div>
        </a>

        <!-- 4. Active Patients -->
        <a href="<?=base_url('manageappointment');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div class="dash-metric-top">
                    <div class="dash-metric-icon-wrap icon-green">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="dash-metric-num"><?=number_format($total_patients);?></div>
                    <div class="dash-metric-label">Unique Patients</div>
                </div>
                <div class="dash-metric-sub">
                    <span class="text-success" style="font-weight: 700;"><i class="fa fa-heartbeat"></i> Lifetime Patient Registry</span>
                </div>
            </div>
        </a>

        <!-- 5. Practice Locations -->
        <a href="<?=base_url('manageownclinic');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div class="dash-metric-top">
                    <div class="dash-metric-icon-wrap icon-purple">
                        <i class="fa fa-hospital-o"></i>
                    </div>
                    <div class="dash-metric-num"><?=intval($total_clinics) + intval($total_hospitals);?></div>
                    <div class="dash-metric-label">Practice Centers</div>
                </div>
                <div class="dash-metric-sub">
                    <span class="text-primary" style="font-weight: 600;"><i class="fa fa-map-marker"></i> <?=$total_clinics;?> Clinics &bull; <?=$total_hospitals;?> Hospitals</span>
                </div>
            </div>
        </a>

        <!-- 6. Video Teleconsultations -->
        <a href="<?=base_url('manageappointment');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div class="dash-metric-top">
                    <div class="dash-metric-icon-wrap icon-indigo">
                        <i class="fa fa-video-camera"></i>
                    </div>
                    <div class="dash-metric-num"><?=number_format($video_appointments);?></div>
                    <div class="dash-metric-label">Digital Consultations</div>
                </div>
                <div class="dash-metric-sub">
                    <span class="text-primary" style="font-weight: 600;"><i class="fa fa-desktop"></i> Secure WebRTC Video Calls</span>
                </div>
            </div>
        </a>

        <!-- 7. Pending Fee Payouts -->
        <a href="<?=base_url('doctorpanel/earnings');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div class="dash-metric-top">
                    <div class="dash-metric-icon-wrap icon-rose">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="dash-metric-num">₹<?=number_format(@$earnings->pending_payout, 2);?></div>
                    <div class="dash-metric-label">Escrow Settlement</div>
                </div>
                <div class="dash-metric-sub">
                    <span class="text-warning" style="font-weight: 700;"><i class="fa fa-clock-o"></i> Weekly Payout Cycle</span>
                </div>
            </div>
        </a>

        <!-- 8. Practitioner Verification -->
        <a href="<?=base_url('profile_step1');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div class="dash-metric-top">
                    <div class="dash-metric-icon-wrap icon-teal">
                        <i class="fa fa-shield"></i>
                    </div>
                    <div class="dash-metric-num" style="font-size: 20px; color: #0d9488;"><i class="fa fa-check-circle"></i> Active</div>
                    <div class="dash-metric-label">Medical Council Status</div>
                </div>
                <div class="dash-metric-sub">
                    <span class="text-success" style="font-weight: 700;"><i class="fa fa-id-card"></i> Verified Practitioner</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Analytics Charts Row (Interactive Chart.js) -->
    <div class="row">
        <!-- Chart 1: Consultation Status Doughnut -->
        <div class="col-md-6 col-xs-12">
            <div class="dash-box">
                <div class="dash-box-header">
                    <h3 class="dash-box-title">
                        <i class="fa fa-pie-chart" style="color: #0284c7;"></i> Consultation Status Distribution
                    </h3>
                </div>
                <div class="dash-box-body">
                    <div style="position: relative; height: 240px;">
                        <canvas id="consultationStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 2: 6-Month Patient Visit Trend -->
        <div class="col-md-6 col-xs-12">
            <div class="dash-box">
                <div class="dash-box-header">
                    <h3 class="dash-box-title">
                        <i class="fa fa-line-chart" style="color: #10b981;"></i> Patient Consultation Trend (Last 6 Months)
                    </h3>
                </div>
                <div class="dash-box-body">
                    <div style="position: relative; height: 240px;">
                        <canvas id="consultationTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Operations & Clinical Tools Grid -->
    <div class="dash-box">
        <div class="dash-box-header">
            <h3 class="dash-box-title">
                <i class="fa fa-bolt" style="color: var(--adm-teal);"></i> Clinical Tools &amp; Management Operations
            </h3>
        </div>
        <div class="dash-box-body">
            <div class="quick-actions-grid">
                <a href="<?=base_url('manageappointment');?>" class="quick-action-card">
                    <div class="quick-action-icon icon-amber"><i class="fa fa-calendar"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;">Manage Appointments</div>
                        <div style="font-size: 11.5px; color: #64748b;">Review scheduled visits &amp; consult queue</div>
                    </div>
                </a>
                <a href="<?=base_url('doctorpanel/earnings');?>" class="quick-action-card">
                    <div class="quick-action-icon icon-teal"><i class="fa fa-line-chart"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;">Financials &amp; Settlements</div>
                        <div style="font-size: 11.5px; color: #64748b;">Escrow ledger &amp; payout statements</div>
                    </div>
                </a>
                <a href="<?=base_url('manageownclinic');?>" class="quick-action-card">
                    <div class="quick-action-icon icon-blue"><i class="fa fa-hospital-o"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;">Own Clinic Setup</div>
                        <div style="font-size: 11.5px; color: #64748b;">Chamber locations &amp; consultation rooms</div>
                    </div>
                </a>
                <a href="<?=base_url('managepractice');?>" class="quick-action-card">
                    <div class="quick-action-icon icon-green"><i class="fa fa-medkit"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;">Manage Practice &amp; Fees</div>
                        <div style="font-size: 11.5px; color: #64748b;">Consultation pricing &amp; patient quotas</div>
                    </div>
                </a>
                <a href="<?=base_url('doctorpanel/datetime');?>" class="quick-action-card">
                    <div class="quick-action-icon icon-purple"><i class="fa fa-clock-o"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;">Working Hours &amp; Schedule</div>
                        <div style="font-size: 11.5px; color: #64748b;">Day-wise slot availability timings</div>
                    </div>
                </a>
                <a href="<?=base_url('doctorpanel/upcharhospital');?>" class="quick-action-card">
                    <div class="quick-action-icon icon-indigo"><i class="fa fa-building-o"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;">Visiting Hospitals</div>
                        <div style="font-size: 11.5px; color: #64748b;">Affiliated medical center branches</div>
                    </div>
                </a>
                <a href="<?=base_url('doctorpanel/managegallery');?>" class="quick-action-card">
                    <div class="quick-action-icon icon-rose"><i class="fa fa-picture-o"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;">Clinical Gallery</div>
                        <div style="font-size: 11.5px; color: #64748b;">Clinic showcase &amp; equipment media</div>
                    </div>
                </a>
                <a href="<?=base_url('doctorpanel/managenews');?>" class="quick-action-card">
                    <div class="quick-action-icon icon-teal"><i class="fa fa-newspaper-o"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;">News &amp; Health Articles</div>
                        <div style="font-size: 11.5px; color: #64748b;">Publish patient guidance &amp; insights</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Appointments Data Table -->
    <div class="dash-box">
        <div class="dash-box-header">
            <div>
                <h3 class="dash-box-title">
                    <i class="fa fa-list" style="color: var(--adm-teal);"></i> Recent &amp; Upcoming Consultations
                </h3>
                <p style="font-size: 12px; color: #64748b; margin: 3px 0 0 0;">Latest bookings across your clinics and visiting hospitals</p>
            </div>
            <a href="<?=base_url('manageappointment');?>" class="btn btn-xs btn-default" style="font-weight: 700; border-radius: 6px; padding: 6px 14px; border: 1px solid #cbd5e1;">
                View All Bookings <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; font-weight: 700;">
                        <th style="padding: 12px 16px;">Appt #</th>
                        <th style="padding: 12px 16px;">Patient Name</th>
                        <th style="padding: 12px 16px;">Contact</th>
                        <th style="padding: 12px 16px;">Visit Date &amp; Slot</th>
                        <th style="padding: 12px 16px;">Type</th>
                        <th style="padding: 12px 16px;">Fee</th>
                        <th style="padding: 12px 16px;">Payment</th>
                        <th style="padding: 12px 16px; text-align: right;">Clinical Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($recent_appointments)): ?>
                        <?php foreach($recent_appointments as $a): ?>
                        <tr>
                            <td style="padding: 12px 16px; font-weight: 700; color: #00a896;">
                                #<?=$a->appointment_id;?>
                            </td>
                            <td style="padding: 12px 16px;">
                                <div style="font-weight: 700; color: #0f172a;">
                                    <?php
                                    $p_name = !empty($a->user_fname) ? trim($a->user_fname.' '.$a->user_lname) : (!empty($a->appointment_name) ? $a->appointment_name : (!empty($a->name) ? $a->name : 'Patient'));
                                    echo htmlspecialchars($p_name);
                                    ?>
                                </div>
                            </td>
                            <td style="padding: 12px 16px; color: #64748b;">
                                <?php
                                $p_mobile = !empty($a->user_mobile) ? $a->user_mobile : (!empty($a->appointment_mobile) ? $a->appointment_mobile : (!empty($a->mobile) ? $a->mobile : 'N/A'));
                                echo htmlspecialchars($p_mobile);
                                ?>
                            </td>
                            <td style="padding: 12px 16px;">
                                <div style="font-weight: 600; color: #1e293b;"><?=date('d M Y', strtotime($a->appointment_date));?></div>
                                <div style="font-size: 11.5px; color: #64748b;"><?=$a->appointment_time;?></div>
                            </td>
                            <td style="padding: 12px 16px;">
                                <?php if(isset($a->appointment_type) && $a->appointment_type == 'video'): ?>
                                    <span class="badge" style="background: #e0e7ff; color: #4338ca; font-size: 11px; padding: 3px 8px; border-radius: 4px;"><i class="fa fa-video-camera"></i> Teleconsult</span>
                                <?php elseif(isset($a->institution_type) && $a->institution_type == 'H'): ?>
                                    <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 11px; padding: 3px 8px; border-radius: 4px;"><i class="fa fa-building-o"></i> Hospital</span>
                                <?php else: ?>
                                    <span class="badge" style="background: #f0fdfa; color: #0f766e; font-size: 11px; padding: 3px 8px; border-radius: 4px;"><i class="fa fa-hospital-o"></i> Clinic</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px 16px; font-weight: 700; color: #0f172a;">
                                <?php 
                                $fee_val = !empty($a->fee) ? $a->fee : (!empty($a->amount) ? $a->amount : (!empty($a->fees) ? $a->fees : 0));
                                ?>
                                ₹<?=number_format($fee_val, 2);?>
                            </td>
                            <td style="padding: 12px 16px;">
                                <?php 
                                $is_paid = (isset($a->payment_status) && in_array(strtoupper($a->payment_status), array('1', 'PAID', 'SUCCESS', 'COMPLETE'))) || (isset($a->pay_status) && ($a->pay_status == '1' || $a->pay_status == 'SUCCESS'));
                                ?>
                                <?php if($is_paid): ?>
                                    <span class="badge-status badge-paid"><i class="fa fa-check"></i> Paid</span>
                                <?php else: ?>
                                    <span class="badge-status badge-unpaid"><i class="fa fa-clock-o"></i> Unpaid</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px 16px; text-align: right; white-space: nowrap;">
                                <?php if (!empty($a->room_id) || (isset($a->appointment_type) && $a->appointment_type == 'video')): ?>
                                <a href="<?=base_url('doctorpanel/videocall/'.($a->room_id ?: 'upchar_consult_'.$a->appointment_id));?>" target="_blank" class="btn btn-xs btn-primary" style="background: #2563eb; border-color: #2563eb; font-weight: 700; border-radius: 4px; padding: 4px 8px; margin-right: 4px;">
                                    <i class="fa fa-video-camera"></i> Join Call
                                </a>
                                <?php endif; ?>
                                <a href="<?=base_url('doctorpanel/prescription/'.$a->appointment_id);?>" class="btn btn-xs btn-default" style="color: #00a896; font-weight: 700; border-radius: 4px; padding: 4px 8px; margin-right: 4px;">
                                    <i class="fa fa-stethoscope"></i> Write Rx
                                </a>
                                <?php if($a->status != '2'): ?>
                                <a href="<?=base_url('doctorpanel/complete_appointment?aid='.$a->appointment_id);?>" onclick="return confirm('Complete consultation visit and queue fee for settlement?');" class="btn btn-xs btn-warning" style="font-weight: 700; color: #ffffff; border-radius: 4px; padding: 4px 8px;">
                                    <i class="fa fa-check"></i> Complete
                                </a>
                                <?php else: ?>
                                <span class="badge-status badge-visited"><i class="fa fa-check-circle"></i> Visited</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="padding: 36px; text-align: center; color: #94a3b8;">
                                <i class="fa fa-calendar-o" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                <div style="font-weight: 600; color: #64748b;">No recent consultations recorded yet</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart Initialization Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Consultation Status Doughnut
    var ctxDoughnut = document.getElementById('consultationStatusChart');
    if (ctxDoughnut) {
        new Chart(ctxDoughnut.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Visited (Completed)', 'Upcoming (Confirmed)', 'Cancelled'],
                datasets: [{
                    data: [
                        <?=intval($completed_appointments);?>,
                        <?=intval($pending_appointments);?>,
                        <?=intval($cancelled_appointments);?>
                    ],
                    backgroundColor: ['#10b981', '#0284c7', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        fontSize: 12,
                        fontColor: '#475569',
                        padding: 14
                    }
                },
                cutoutPercentage: 65
            }
        });
    }

    // 2. Consultation Monthly Trend Line
    var ctxTrend = document.getElementById('consultationTrendChart');
    if (ctxTrend) {
        new Chart(ctxTrend.getContext('2d'), {
            type: 'line',
            data: {
                labels: <?=json_encode($monthly_labels);?>,
                datasets: [{
                    label: 'Booked Consultations',
                    data: <?=json_encode($monthly_data);?>,
                    borderColor: '#00a896',
                    backgroundColor: 'rgba(0, 168, 150, 0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#00a896',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    lineTension: 0.35,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            fontColor: '#64748b',
                            fontSize: 11
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: '#f1f5f9',
                            zeroLineColor: '#e2e8f0'
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            fontColor: '#64748b',
                            fontSize: 11
                        }
                    }]
                }
            }
        });
    }
});
</script>

<?php include ("assets/includes/footer.php"); ?>
