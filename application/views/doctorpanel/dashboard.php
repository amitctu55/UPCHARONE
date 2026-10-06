<?php include ("assets/includes/header.php"); ?>
<?php include ("assets/includes/leftmenu.php"); ?>

<!-- Chart.js 2.9.4 CDN for Clinical Telemetry Visualizations -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<style>
/* ==========================================================
   Design Tokens & Usability Heuristics Standardization
   ========================================================== */
.ehr-dashboard-container {
    padding: 20px 24px 40px 24px;
    background-color: var(--upchar-slate-50);
    min-height: calc(100vh - 64px);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: var(--text-secondary);
}

/* Usability Fix 8: Semantic Accessible Page Title (H1) */
.page-title-bar {
    margin-bottom: 16px;
}

.page-main-heading {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    line-height: 1.2;
}

.page-main-heading i {
    color: var(--text-brand);
}

.page-heading-sub {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-muted);
}

/* Secondary Sub-Navigation Toolbar */
.subnav-toolbar {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: var(--radius-lg);
    padding: 10px 16px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.subnav-tabs {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.subnav-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 14px;
    border-radius: var(--radius-md);
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-secondary);
    text-decoration: none !important;
    background: transparent;
    border: 1px solid transparent;
    transition: all 0.18s ease;
    cursor: pointer;
}

.subnav-tab-btn:hover {
    background: var(--upchar-slate-100);
    color: var(--text-primary);
}

.subnav-tab-btn.active {
    background: var(--upchar-blue-light);
    color: var(--text-brand);
    border-color: #bae6fd;
    font-weight: 700;
}

.subnav-badge {
    background: #e2e8f0;
    color: var(--text-secondary);
    font-size: 12px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: var(--radius-sm);
}

.subnav-tab-btn.active .subnav-badge {
    background: var(--text-brand);
    color: var(--text-white);
}

.subnav-right-tools {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.date-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-muted);
    background: var(--upchar-slate-100);
    padding: 6px 12px;
    border-radius: var(--radius-full);
    border: 1px solid var(--upchar-border);
}

/* Executive Section Banner */
.executive-banner {
    background: linear-gradient(135deg, #0d1b2a 0%, #034b75 60%, #008f80 100%);
    border-radius: var(--radius-lg);
    padding: 22px 26px;
    margin-bottom: 24px;
    color: var(--text-white);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 25px -4px rgba(13, 27, 42, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.12);
}

.executive-banner::before {
    content: '';
    position: absolute;
    right: -30px;
    top: -40px;
    width: 240px;
    height: 240px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.banner-title-area h2 {
    margin: 0 0 6px 0;
    font-size: 20px;
    font-weight: 800;
    color: var(--text-white);
    display: flex;
    align-items: center;
    gap: 10px;
}

.banner-meta {
    font-size: 12.5px;
    color: rgba(255, 255, 255, 0.85);
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.banner-badge-verified {
    background: rgba(45, 212, 191, 0.2);
    border: 1px solid #2dd4bf;
    color: #2dd4bf;
    font-size: 12px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: var(--radius-full);
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.banner-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
}

/* Standardized Button System (Usability Fix 3) */
.btn-ehr-primary {
    background: var(--upchar-blue);
    color: var(--text-white) !important;
    font-weight: 600;
    font-size: 12.5px;
    padding: 8px 16px;
    border-radius: var(--radius-md);
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: none;
    box-shadow: 0 2px 6px rgba(2, 132, 199, 0.2);
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-ehr-primary:hover {
    background: var(--upchar-blue-dark);
    transform: translateY(-1px);
}

.btn-ehr-secondary {
    background: rgba(255, 255, 255, 0.15);
    color: var(--text-white) !important;
    border: 1px solid rgba(255, 255, 255, 0.3);
    font-weight: 600;
    font-size: 12.5px;
    padding: 8px 16px;
    border-radius: var(--radius-md);
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-ehr-secondary:hover {
    background: rgba(255, 255, 255, 0.25);
}

/* 5 Metrics Summary Cards Grid */
.metrics-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

@media (max-width: 1280px) {
    .metrics-row {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 900px) {
    .metrics-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .metrics-row {
        grid-template-columns: 1fr;
    }
}

.metric-card-link {
    text-decoration: none !important;
    color: inherit;
    display: flex;
    height: 100%;
}

.metric-card {
    background: #ffffff;
    border-radius: var(--radius-lg);
    padding: 16px 18px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    position: relative;
    overflow: hidden;
}

.metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    border-color: var(--text-brand);
}

.metric-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 10px;
}

.metric-icon-wrap {
    width: 42px;
    height: 42px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.metric-trend-pill {
    font-size: 12px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: var(--radius-sm);
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.trend-amber { background: #fef3c7; color: var(--text-warning); }
.trend-green { background: #dcfce7; color: var(--text-success); }
.trend-blue  { background: #e0f2fe; color: var(--text-brand); }
.trend-teal  { background: #ccfbf1; color: var(--text-brand); }
.trend-indigo{ background: #e0e7ff; color: var(--text-brand); }

.metric-num {
    font-size: 24px;
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1.1;
    margin-bottom: 4px;
}

.metric-label {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-secondary);
}

.metric-footer {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #f1f5f9;
}

/* Main Dashboard 2-Column Layout */
.dashboard-grid-layout {
    display: grid;
    grid-template-columns: 8fr 4fr;
    gap: 24px;
    align-items: start;
}

@media (max-width: 1024px) {
    .dashboard-grid-layout {
        grid-template-columns: 1fr;
    }
}

/* Card Box Containers */
.ehr-card {
    background: #ffffff;
    border-radius: var(--radius-lg);
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    margin-bottom: 24px;
    overflow: hidden;
}

.ehr-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--upchar-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    background: #ffffff;
}

.ehr-card-title {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ehr-card-body {
    padding: 20px;
}

/* Filter Controls in Table Header */
.table-filter-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}

.table-search-input {
    background: #f8fafc;
    border: 1px solid var(--upchar-border);
    border-radius: var(--radius-md);
    padding: 6px 12px;
    font-size: 12.5px;
    color: var(--text-secondary);
    outline: none;
    min-width: 240px;
    transition: all 0.2s ease;
}

.table-search-input:focus {
    background: #ffffff;
    border-color: var(--text-brand);
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
}

.status-filter-pills {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.filter-pill {
    border: 1px solid var(--upchar-border);
    background: #ffffff;
    padding: 5px 12px;
    border-radius: var(--radius-sm);
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.15s ease;
}

.filter-pill:hover,
.filter-pill.active {
    background: var(--upchar-slate-100);
    color: var(--text-primary);
    border-color: #cbd5e1;
}

.filter-pill.active {
    background: var(--upchar-blue);
    color: var(--text-white);
    border-color: var(--upchar-blue);
}

/* High-Legibility Consultation Table */
.ehr-table {
    width: 100%;
    margin-bottom: 0;
    font-size: 12.5px;
    border-collapse: separate;
    border-spacing: 0;
}

.ehr-table thead th {
    background: #f8fafc;
    color: var(--text-secondary);
    font-weight: 700;
    padding: 11px 14px;
    border-bottom: 1px solid var(--upchar-border);
    white-space: nowrap;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
}

.ehr-table tbody td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.ehr-table tbody tr:hover {
    background-color: #f8fafc;
}

/* Patient Avatar & Details */
.patient-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.patient-avatar-circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #e0f2fe;
    color: var(--text-brand);
    font-size: 12.5px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid #bae6fd;
}

.patient-name-text {
    font-weight: 700;
    color: var(--text-primary);
    font-size: 13px;
    line-height: 1.2;
}

.patient-sub-text {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 2px;
}

/* Status Badges */
.badge-ehr {
    padding: 3px 8px;
    border-radius: var(--radius-sm);
    font-size: 12px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
}

.badge-ehr-confirmed { background: #e0f2fe; color: var(--text-brand); }
.badge-ehr-completed { background: #dcfce7; color: var(--text-success); }
.badge-ehr-cancelled { background: #fee2e2; color: var(--text-danger); }
.badge-ehr-video     { background: #e0e7ff; color: var(--text-brand); }
.badge-ehr-clinic    { background: #f0fdfa; color: var(--text-brand); }

/* Usability Fix 7: Standardize button font-size >= 12.5px */
.btn-table-action {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: var(--radius-sm);
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.15s ease;
    border: 1px solid transparent;
    cursor: pointer;
}

.btn-action-video {
    background: var(--upchar-blue);
    color: var(--text-white) !important;
}
.btn-action-video:hover {
    background: var(--upchar-blue-dark);
}

.btn-action-rx {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: var(--text-secondary) !important;
}
.btn-action-rx:hover {
    background: #e2e8f0;
    color: var(--text-primary) !important;
}

.btn-action-complete {
    background: #fef3c7;
    border-color: #fde68a;
    color: var(--text-warning) !important;
}
.btn-action-complete:hover {
    background: #fde68a;
}

/* Side Panel Widgets */
.teleconsult-room-widget {
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
    color: var(--text-white);
    border-radius: var(--radius-lg);
    padding: 18px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 14px rgba(2, 132, 199, 0.2);
}

.teleconsult-widget-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.pulse-dot {
    width: 8px;
    height: 8px;
    background: #2dd4bf;
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.3);
    animation: pulseAnim 2s infinite;
}

@keyframes pulseAnim {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.5); }
    70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(45, 212, 191, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(45, 212, 191, 0); }
}

.diet-log-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
}

.diet-log-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.diet-icon-pill {
    width: 34px;
    height: 34px;
    border-radius: var(--radius-md);
    background: #dcfce7;
    color: var(--text-success);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.scratchpad-textarea {
    width: 100%;
    min-height: 110px;
    border: 1px solid var(--upchar-border);
    border-radius: var(--radius-md);
    padding: 10px 12px;
    font-size: 12.5px;
    font-family: inherit;
    color: var(--text-secondary);
    resize: vertical;
    outline: none;
    background: #f8fafc;
    transition: all 0.2s ease;
}

.scratchpad-textarea:focus {
    background: #ffffff;
    border-color: var(--text-brand);
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.08);
}
</style>

<div class="ehr-dashboard-container pag_cstm">
    <!-- Usability Heuristic Fix 8: Semantic H1 Page Heading -->
    <header class="page-title-bar">
        <h1 class="page-main-heading">
            <i class="fa fa-stethoscope" aria-hidden="true"></i>
            Doctor EHR Portal
            <span class="page-heading-sub">&bull; Clinical Practitioner Workspace</span>
        </h1>
    </header>

    <!-- 1. Secondary Sub-Navigation Toolbar -->
    <nav class="subnav-toolbar" aria-label="Dashboard Sub-sections">
        <div class="subnav-tabs">
            <button type="button" class="subnav-tab-btn active" onclick="switchDashboardTab('overview', this)">
                <i class="fa fa-th-large" aria-hidden="true"></i>
                <span>Overview &amp; Telemetry</span>
            </button>
            <button type="button" class="subnav-tab-btn" onclick="switchDashboardTab('today', this)">
                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                <span>Today's Schedule</span>
                <span class="subnav-badge"><?=isset($today_appointments_list) ? count($today_appointments_list) : $todayappointment;?></span>
            </button>
            <button type="button" class="subnav-tab-btn" onclick="switchDashboardTab('pending', this)">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span>Pending Review</span>
                <span class="subnav-badge"><?=$pending_appointments;?></span>
            </button>
            <a href="<?=base_url('diet');?>" class="subnav-tab-btn">
                <i class="fa fa-cutlery" style="color: var(--text-success);" aria-hidden="true"></i>
                <span>Diet Tracker EHR</span>
                <span class="subnav-badge" style="background: var(--text-success); color: #fff;">LIVE</span>
            </a>
            <a href="<?=base_url('manageownclinic');?>" class="subnav-tab-btn">
                <i class="fa fa-hospital-o" aria-hidden="true"></i>
                <span>Practice Chambers</span>
            </a>
            <a href="<?=base_url('doctorpanel/earnings');?>" class="subnav-tab-btn">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
                <span>Earnings &amp; Reports</span>
            </a>
        </div>

        <div class="subnav-right-tools">
            <div class="date-pill">
                <i class="fa fa-calendar" style="color: var(--text-brand);" aria-hidden="true"></i>
                <span><?=date('l, d M Y');?></span>
            </div>
            <a href="<?=base_url('doctorpanel/datetime');?>" class="btn-ehr-primary" style="padding: 7px 14px;">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span>Set Slot Timings</span>
            </a>
        </div>
    </nav>

    <!-- 2. Executive Section Banner -->
    <?php 
    $doc_name = $this->session->userdata('drusername') ?: 'Anushka';
    $doc_lname = $this->session->userdata('druserlname') ?: '';
    $dr_room_id = 'upchar_teleconsult_'.(isset($doctor->id) ? $doctor->id : ($this->session->userdata('druserid') ?: 'dr_default'));
    ?>
    <section class="executive-banner" aria-label="Practitioner Status">
        <div class="banner-title-area">
            <h2>
                <i class="fa fa-user-md" style="color: #2dd4bf;" aria-hidden="true"></i>
                Dr. <?=$doc_name;?> <?=$doc_lname;?>
            </h2>
            <div class="banner-meta">
                <span class="banner-badge-verified">
                    <i class="fa fa-check-circle" aria-hidden="true"></i> Verified Medical Practitioner
                </span>
                <span><i class="fa fa-clock-o" aria-hidden="true"></i> Telemetry Synced: <?=date('h:i A');?></span>
                <span>&bull;</span>
                <span><i class="fa fa-map-marker" aria-hidden="true"></i> <?=$total_clinics;?> Chambers &bull; <?=$total_hospitals;?> Visiting Hospitals</span>
            </div>
        </div>
        <div class="banner-actions">
            <a href="<?=base_url('doctorpanel/videocall/'.$dr_room_id);?>" target="_blank" class="btn-ehr-secondary" title="Open Virtual Consultation Room">
                <i class="fa fa-video-camera" style="color: #2dd4bf;" aria-hidden="true"></i>
                <span>Launch Teleconsult Room</span>
            </a>
            <a href="<?=base_url('manageappointment');?>" class="btn-ehr-primary" title="View Patient Appointments" style="background: #ffffff; color: var(--text-primary) !important;">
                <i class="fa fa-calendar-check-o" style="color: var(--text-brand);" aria-hidden="true"></i>
                <span>Consultation Queue</span>
            </a>
        </div>
    </section>

    <!-- Flash Alert -->
    <?php if($this->session->flashdata('flashmsg')): ?>
        <div style="margin-bottom: 20px;">
            <?=$this->session->flashdata('flashmsg');?>
        </div>
    <?php endif; ?>

    <!-- 3. Metrics Summary Row (5 Modern Cards) -->
    <div class="metrics-row">
        <!-- 1. Today's Consultations -->
        <a href="<?=base_url('manageappointment');?>" class="metric-card-link" aria-label="Today's scheduled visits: <?=number_format($todayappointment);?>">
            <div class="metric-card">
                <div class="metric-card-top">
                    <div class="metric-icon-wrap" style="background: #fef3c7; color: var(--text-warning);">
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                    </div>
                    <span class="metric-trend-pill trend-amber">
                        <i class="fa fa-calendar" aria-hidden="true"></i> Today
                    </span>
                </div>
                <div>
                    <div class="metric-num"><?=number_format($todayappointment);?></div>
                    <div class="metric-label">Today's Visits</div>
                </div>
                <div class="metric-footer">
                    <span>Scheduled for <?=date('d M Y');?></span>
                </div>
            </div>
        </a>

        <!-- 2. Unique Patients -->
        <a href="<?=base_url('manageappointment');?>" class="metric-card-link" aria-label="Unique registered patients: <?=number_format($total_patients);?>">
            <div class="metric-card">
                <div class="metric-card-top">
                    <div class="metric-icon-wrap" style="background: #dcfce7; color: var(--text-success);">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <span class="metric-trend-pill trend-green">
                        <i class="fa fa-heartbeat" aria-hidden="true"></i> Registry
                    </span>
                </div>
                <div>
                    <div class="metric-num"><?=number_format($total_patients);?></div>
                    <div class="metric-label">Unique Patients</div>
                </div>
                <div class="metric-footer">
                    <span>Lifetime Registered Patients</span>
                </div>
            </div>
        </a>

        <!-- 3. Pending Consultations -->
        <a href="<?=base_url('manageappointment');?>" class="metric-card-link" aria-label="Pending consultation reviews: <?=number_format($pending_appointments);?>">
            <div class="metric-card">
                <div class="metric-card-top">
                    <div class="metric-icon-wrap" style="background: #e0f2fe; color: var(--text-brand);">
                        <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                    </div>
                    <span class="metric-trend-pill trend-blue">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> Queue
                    </span>
                </div>
                <div>
                    <div class="metric-num"><?=number_format($pending_appointments);?></div>
                    <div class="metric-label">Pending Reviews</div>
                </div>
                <div class="metric-footer">
                    <span>Awaiting Doctor Visit Completion</span>
                </div>
            </div>
        </a>

        <!-- 4. Completed Visits -->
        <a href="<?=base_url('manageappointment');?>" class="metric-card-link" aria-label="Completed consultation visits: <?=number_format($completed_appointments);?>">
            <div class="metric-card">
                <div class="metric-card-top">
                    <div class="metric-icon-wrap" style="background: #ccfbf1; color: var(--text-brand);">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                    </div>
                    <span class="metric-trend-pill trend-teal">
                        <i class="fa fa-stethoscope" aria-hidden="true"></i> Visited
                    </span>
                </div>
                <div>
                    <div class="metric-num"><?=number_format($completed_appointments);?></div>
                    <div class="metric-label">Completed Consults</div>
                </div>
                <div class="metric-footer">
                    <span>Successfully Closed Visits</span>
                </div>
            </div>
        </a>

        <!-- 5. Net Doctor Earnings -->
        <a href="<?=base_url('doctorpanel/earnings');?>" class="metric-card-link" aria-label="Net doctor earnings: ₹<?=number_format(@$earnings->total_net, 2);?>">
            <div class="metric-card">
                <div class="metric-card-top">
                    <div class="metric-icon-wrap" style="background: #e0e7ff; color: var(--text-brand);">
                        <i class="fa fa-inr" aria-hidden="true"></i>
                    </div>
                    <span class="metric-trend-pill trend-indigo">
                        <i class="fa fa-line-chart" aria-hidden="true"></i> Net
                    </span>
                </div>
                <div>
                    <div class="metric-num">₹<?=number_format(@$earnings->total_net, 2);?></div>
                    <div class="metric-label">Net Doctor Earnings</div>
                </div>
                <div class="metric-footer">
                    <span>Pending Escrow: ₹<?=number_format(@$earnings->pending_payout, 2);?></span>
                </div>
            </div>
        </a>
    </div>

    <!-- 4. Main Content Dashboard Grid (8 cols Main Area / 4 cols Side Panel) -->
    <div class="dashboard-grid-layout">
        <!-- PRIMARY VIEW (Left Column - 8 cols) -->
        <div class="primary-column">
            <!-- Consultations Table Card -->
            <div class="ehr-card">
                <div class="ehr-card-header">
                    <div>
                        <h3 class="ehr-card-title">
                            <i class="fa fa-calendar-check-o" style="color: var(--text-brand);" aria-hidden="true"></i>
                            <span id="tableTitleText">Consultation Appointments &amp; Queue</span>
                        </h3>
                        <p style="font-size: 12px; color: var(--text-muted); margin: 3px 0 0 0;">Interactive patient visit queue with instant actions</p>
                    </div>
                    <a href="<?=base_url('manageappointment');?>" class="btn-table-action btn-action-rx">
                        <span>View All (<?=number_format($totalappointment);?>)</span>
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="ehr-card-body" style="padding-bottom: 8px;">
                    <!-- Filter Toolbar -->
                    <div class="table-filter-bar">
                        <input type="text" id="patientFilterInput" class="table-search-input" placeholder="Search patient name, phone, or appointment #..." aria-label="Filter patient appointments">
                        
                        <div class="status-filter-pills" role="toolbar" aria-label="Table status filters">
                            <button type="button" class="filter-pill active" onclick="filterTableStatus('all', this)">All (<?=count($recent_appointments);?>)</button>
                            <button type="button" class="filter-pill" onclick="filterTableStatus('confirmed', this)">Upcoming</button>
                            <button type="button" class="filter-pill" onclick="filterTableStatus('completed', this)">Visited</button>
                            <button type="button" class="filter-pill" onclick="filterTableStatus('video', this)">Teleconsult</button>
                        </div>
                    </div>

                    <!-- Appointments Table -->
                    <div class="table-responsive">
                        <table class="ehr-table" id="appointmentsTable">
                            <thead>
                                <tr>
                                    <th>Appt #</th>
                                    <th>Patient Details</th>
                                    <th>Visit Date &amp; Slot</th>
                                    <th>Type</th>
                                    <th>Fee &amp; Payment</th>
                                    <th style="text-align: right;">Clinical Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($recent_appointments)): ?>
                                    <?php foreach($recent_appointments as $a): 
                                        $p_name = !empty($a->user_fname) ? trim($a->user_fname.' '.$a->user_lname) : (!empty($a->appointment_name) ? $a->appointment_name : (!empty($a->name) ? $a->name : 'Patient'));
                                        $p_initials = strtoupper(substr($p_name, 0, 1));
                                        $p_mobile = !empty($a->user_mobile) ? $a->user_mobile : (!empty($a->appointment_mobile) ? $a->appointment_mobile : (!empty($a->mobile) ? $a->mobile : 'N/A'));
                                        $is_video = (isset($a->appointment_type) && $a->appointment_type == 'video');
                                        $fee_val = !empty($a->fee) ? $a->fee : (!empty($a->amount) ? $a->amount : (!empty($a->fees) ? $a->fees : 0));
                                        $is_paid = (isset($a->payment_status) && in_array(strtoupper($a->payment_status), array('1', 'PAID', 'SUCCESS', 'COMPLETE'))) || (isset($a->pay_status) && ($a->pay_status == '1' || $a->pay_status == 'SUCCESS'));
                                        $row_status = ($a->status == '2') ? 'completed' : (($a->status == '0') ? 'cancelled' : 'confirmed');
                                    ?>
                                    <tr class="appt-row" data-status="<?=$row_status;?>" data-type="<?=$is_video ? 'video' : 'clinic';?>" data-search="<?=strtolower($p_name.' '.$p_mobile.' #'.$a->appointment_id);?>">
                                        <td style="font-weight: 700; color: var(--text-brand);">
                                            #<?=$a->appointment_id;?>
                                        </td>
                                        <td>
                                            <div class="patient-cell">
                                                <div class="patient-avatar-circle" aria-hidden="true"><?=$p_initials;?></div>
                                                <div>
                                                    <div class="patient-name-text"><?=htmlspecialchars($p_name);?></div>
                                                    <div class="patient-sub-text"><i class="fa fa-phone" aria-hidden="true"></i> <?=htmlspecialchars($p_mobile);?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600; color: var(--text-primary);"><?=date('d M Y', strtotime($a->appointment_date));?></div>
                                            <div style="font-size: 12px; color: var(--text-muted);"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$a->appointment_time;?></div>
                                        </td>
                                        <td>
                                            <?php if($is_video): ?>
                                                <span class="badge-ehr badge-ehr-video"><i class="fa fa-video-camera" aria-hidden="true"></i> Teleconsult</span>
                                            <?php elseif(isset($a->institution_type) && $a->institution_type == 'H'): ?>
                                                <span class="badge-ehr badge-ehr-clinic"><i class="fa fa-building-o" aria-hidden="true"></i> Hospital</span>
                                            <?php else: ?>
                                                <span class="badge-ehr badge-ehr-clinic"><i class="fa fa-hospital-o" aria-hidden="true"></i> Clinic</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: var(--text-primary);">₹<?=number_format($fee_val, 2);?></div>
                                            <?php if($is_paid): ?>
                                                <span style="font-size: 12px; color: var(--text-success); font-weight: 700;"><i class="fa fa-check-circle" aria-hidden="true"></i> Paid</span>
                                            <?php else: ?>
                                                <span style="font-size: 12px; color: var(--text-danger); font-weight: 700;"><i class="fa fa-clock-o" aria-hidden="true"></i> Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: right; white-space: nowrap;">
                                            <?php if ($is_video || !empty($a->room_id)): ?>
                                                <a href="<?=base_url('doctorpanel/videocall/'.($a->room_id ?: 'upchar_consult_'.$a->appointment_id));?>" target="_blank" class="btn-table-action btn-action-video" title="Launch WebRTC Video Consultation">
                                                    <i class="fa fa-video-camera" aria-hidden="true"></i> Call
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?=base_url('doctorpanel/prescription/'.$a->appointment_id);?>" class="btn-table-action btn-action-rx" title="Write Clinical Prescription">
                                                <i class="fa fa-stethoscope" aria-hidden="true"></i> Rx
                                            </a>
                                            <?php if($a->status != '2'): ?>
                                                <a href="<?=base_url('doctorpanel/complete_appointment?aid='.$a->appointment_id);?>" onclick="return confirm('Complete consultation visit and mark completed?');" class="btn-table-action btn-action-complete" title="Mark Visited &amp; Complete">
                                                    <i class="fa fa-check" aria-hidden="true"></i> Complete
                                                </a>
                                            <?php else: ?>
                                                <span class="badge-ehr badge-ehr-completed"><i class="fa fa-check-circle" aria-hidden="true"></i> Visited</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                                            <i class="fa fa-calendar-o" style="font-size: 36px; display: block; margin-bottom: 10px; color: #cbd5e1;" aria-hidden="true"></i>
                                            <div style="font-weight: 700; color: var(--text-primary);">No consultations currently in queue</div>
                                            <div style="font-size: 12.5px; margin-top: 4px;">New patient bookings will appear here instantly.</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Analytics Visualizations Row (Interactive Chart.js) -->
            <div class="row" style="margin-left: -12px; margin-right: -12px;">
                <!-- Chart 1: 6-Month Patient Visit Trend -->
                <div class="col-md-7 col-xs-12" style="padding: 0 12px;">
                    <div class="ehr-card">
                        <div class="ehr-card-header">
                            <h3 class="ehr-card-title">
                                <i class="fa fa-line-chart" style="color: var(--text-brand);" aria-hidden="true"></i>
                                6-Month Patient Consultation Trend
                            </h3>
                        </div>
                        <div class="ehr-card-body">
                            <div style="position: relative; height: 230px;">
                                <canvas id="consultationTrendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Consultation Status Distribution -->
                <div class="col-md-5 col-xs-12" style="padding: 0 12px;">
                    <div class="ehr-card">
                        <div class="ehr-card-header">
                            <h3 class="ehr-card-title">
                                <i class="fa fa-pie-chart" style="color: var(--text-brand);" aria-hidden="true"></i>
                                Visit Distribution
                            </h3>
                        </div>
                        <div class="ehr-card-body">
                            <div style="position: relative; height: 230px;">
                                <canvas id="consultationStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECONDARY VIEW (Right Side Panel - 4 cols) -->
        <div class="secondary-column">
            <!-- 1. WebRTC Teleconsult Room Card -->
            <div class="teleconsult-room-widget">
                <div class="teleconsult-widget-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span class="pulse-dot" aria-hidden="true"></span>
                        <strong style="font-size: 13.5px;">Virtual Consult Room</strong>
                    </div>
                    <span style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: var(--radius-sm);">WebRTC 1080p</span>
                </div>
                <p style="font-size: 12.5px; color: rgba(255,255,255,0.92); margin-bottom: 14px;">
                    Instantly conduct live audio/video consultations with connected patients.
                </p>
                <div style="display: flex; gap: 8px;">
                    <a href="<?=base_url('doctorpanel/videocall/'.$dr_room_id);?>" target="_blank" class="btn-ehr-primary" style="flex: 1; text-align: center; justify-content: center; background: #ffffff; color: var(--text-primary) !important;">
                        <i class="fa fa-video-camera" style="color: var(--text-brand);" aria-hidden="true"></i> Launch Room
                    </a>
                    <button type="button" onclick="copyTeleconsultLink('<?=base_url('doctorpanel/videocall/'.$dr_room_id);?>')" class="btn-ehr-secondary" title="Copy Video Room Link">
                        <i class="fa fa-clipboard" aria-hidden="true"></i> Copy Link
                    </button>
                </div>
            </div>

            <!-- 2. Live Patient Clinical Diet Tracker Widget -->
            <div class="ehr-card">
                <div class="ehr-card-header">
                    <div>
                        <h4 class="ehr-card-title" style="font-size: 13.5px;">
                            <i class="fa fa-cutlery" style="color: var(--text-success);" aria-hidden="true"></i>
                            Patient Diet &amp; Nutrition (EHR)
                        </h4>
                        <span style="font-size: 12px; color: var(--text-muted);">Live intake logged by patients</span>
                    </div>
                    <a href="<?=base_url('diet');?>" class="btn-table-action btn-action-rx" style="padding: 4px 10px;">
                        Open Tracker &rarr;
                    </a>
                </div>
                <div class="ehr-card-body" style="padding: 14px 18px;">
                    <?php if(!empty($recent_diet_logs)): ?>
                        <?php foreach($recent_diet_logs as $dl): 
                            $patient_diet_name = !empty($dl->user_fname) ? trim($dl->user_fname.' '.$dl->user_lname) : 'Registered Patient';
                        ?>
                        <div class="diet-log-item">
                            <div class="diet-icon-pill" aria-hidden="true">
                                <i class="fa fa-apple"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <?php 
                                    $item_name = !empty($dl->food_name) ? $dl->food_name : (!empty($dl->food_item_name) ? $dl->food_item_name : 'Meal Item');
                                    $p_val = isset($dl->protein) ? $dl->protein : (isset($dl->protein_g) ? $dl->protein_g : 0);
                                    $c_val = isset($dl->carbs) ? $dl->carbs : (isset($dl->carbs_g) ? $dl->carbs_g : 0);
                                    $f_val = isset($dl->fats) ? $dl->fats : (isset($dl->fat_g) ? $dl->fat_g : 0);
                                    ?>
                                    <strong style="font-size: 12.5px; color: var(--text-primary);"><?=htmlspecialchars($item_name);?></strong>
                                    <span class="badge" style="background: #e0f2fe; color: var(--text-brand); font-size: 12px;"><?=ucfirst($dl->meal_category);?></span>
                                </div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">
                                    Patient: <?=htmlspecialchars($patient_diet_name);?> &bull; <?=number_format($dl->calories, 0);?> kcal
                                </div>
                                <div style="font-size: 12px; color: var(--text-secondary); margin-top: 2px;">
                                    P: <?=number_format($p_val, 1);?>g &bull; C: <?=number_format($c_val, 1);?>g &bull; F: <?=number_format($f_val, 1);?>g
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; padding: 20px 0; color: var(--text-muted);">
                            <i class="fa fa-cutlery" style="font-size: 24px; color: #cbd5e1; margin-bottom: 6px;" aria-hidden="true"></i>
                            <div style="font-size: 12.5px; font-weight: 600;">No nutrition logs recorded yet today</div>
                            <div style="font-size: 12px; margin-top: 2px;">Patient meal logs will stream here in real-time.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 3. Doctor's Clinical Scratchpad / Quick Notes -->
            <div class="ehr-card">
                <div class="ehr-card-header">
                    <h4 class="ehr-card-title" style="font-size: 13.5px;">
                        <i class="fa fa-pencil-square-o" style="color: var(--text-warning);" aria-hidden="true"></i>
                        Clinical Quick Notes &amp; Scratchpad
                    </h4>
                    <span id="scratchpadStatus" style="font-size: 12px; color: var(--text-success); font-weight: 700;">
                        <i class="fa fa-check" aria-hidden="true"></i> Saved locally
                    </span>
                </div>
                <div class="ehr-card-body" style="padding: 14px 18px;">
                    <textarea id="doctorScratchpad" class="scratchpad-textarea" placeholder="Jot down quick patient observations, medicine reminders, or clinical follow-ups (auto-saved)..." aria-label="Clinical quick notes"></textarea>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                        <span style="font-size: 12px; color: var(--text-muted);">Auto-saved to your browser</span>
                        <button type="button" onclick="clearScratchpad()" style="background: none; border: none; font-size: 12px; color: var(--text-muted); cursor: pointer; padding: 0;">
                            <i class="fa fa-trash-o" aria-hidden="true"></i> Clear
                        </button>
                    </div>
                </div>
            </div>

            <!-- 4. Practice Chambers Quick Glance (Usability Fix 7: font-size >= 12.5px) -->
            <div class="ehr-card">
                <div class="ehr-card-header">
                    <h4 class="ehr-card-title" style="font-size: 13.5px;">
                        <i class="fa fa-hospital-o" style="color: var(--text-brand);" aria-hidden="true"></i>
                        Practice Chambers &amp; Hospitals
                    </h4>
                    <a href="<?=base_url('manageownclinic');?>" style="font-size: 12px; font-weight: 700; color: var(--text-brand); text-decoration: none;">
                        Setup &rarr;
                    </a>
                </div>
                <div class="ehr-card-body" style="padding: 14px 18px;">
                    <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                        <div style="flex: 1; background: #f8fafc; border: 1px solid var(--upchar-border); border-radius: var(--radius-md); padding: 10px; text-align: center;">
                            <div style="font-size: 18px; font-weight: 800; color: var(--text-primary);"><?=$total_clinics;?></div>
                            <div style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Own Clinics</div>
                        </div>
                        <div style="flex: 1; background: #f8fafc; border: 1px solid var(--upchar-border); border-radius: var(--radius-md); padding: 10px; text-align: center;">
                            <div style="font-size: 18px; font-weight: 800; color: var(--text-primary);"><?=$total_hospitals;?></div>
                            <div style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Hospitals</div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="<?=base_url('manageownclinic');?>" class="btn-table-action btn-action-rx" style="justify-content: center; padding: 7px 12px;">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Clinic Chamber
                        </a>
                        <a href="<?=base_url('managepractice');?>" class="btn-table-action btn-action-rx" style="justify-content: center; padding: 7px 12px;">
                            <i class="fa fa-cog" aria-hidden="true"></i> Configure Consultation Fees
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Interactive Scripts -->
<script>
// 1. Copy Video Room Link Helper
function copyTeleconsultLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
            if (window.showUpcharToast) window.showUpcharToast('Teleconsult room link copied to clipboard!');
        });
    } else {
        var tempInput = document.createElement("input");
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        if (window.showUpcharToast) window.showUpcharToast('Teleconsult room link copied to clipboard!');
    }
}

// 2. Doctor Scratchpad Persistence
var pad = document.getElementById('doctorScratchpad');
var padStatus = document.getElementById('scratchpadStatus');

if (pad) {
    var savedNotes = localStorage.getItem('upchar_doctor_scratchpad');
    if (savedNotes) pad.value = savedNotes;

    var saveTimeout;
    pad.addEventListener('input', function() {
        if (padStatus) padStatus.innerHTML = '<i class="fa fa-refresh fa-spin" aria-hidden="true"></i> Saving...';
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(function() {
            localStorage.setItem('upchar_doctor_scratchpad', pad.value);
            if (padStatus) padStatus.innerHTML = '<i class="fa fa-check" aria-hidden="true"></i> Saved locally';
        }, 500);
    });
}

function clearScratchpad() {
    if (confirm('Clear your scratchpad notes?')) {
        if (pad) pad.value = '';
        localStorage.removeItem('upchar_doctor_scratchpad');
        if (padStatus) padStatus.innerHTML = '<i class="fa fa-check" aria-hidden="true"></i> Cleared';
    }
}

// 3. Appointments Table Live Search & Filter
var searchInput = document.getElementById('patientFilterInput');
var currentFilterStatus = 'all';

function runTableFilter() {
    var q = searchInput ? searchInput.value.toLowerCase().trim() : '';
    var rows = document.querySelectorAll('.appt-row');
    
    rows.forEach(function(row) {
        var rowText = row.getAttribute('data-search') || '';
        var rowStatus = row.getAttribute('data-status') || '';
        var rowType = row.getAttribute('data-type') || '';

        var matchesSearch = (q === '' || rowText.indexOf(q) !== -1);
        var matchesStatus = true;

        if (currentFilterStatus === 'confirmed') matchesStatus = (rowStatus === 'confirmed');
        else if (currentFilterStatus === 'completed') matchesStatus = (rowStatus === 'completed');
        else if (currentFilterStatus === 'video') matchesStatus = (rowType === 'video');

        if (matchesSearch && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

if (searchInput) {
    searchInput.addEventListener('input', runTableFilter);
}

function filterTableStatus(status, btn) {
    currentFilterStatus = status;
    var pills = document.querySelectorAll('.filter-pill');
    pills.forEach(function(p) { p.classList.remove('active'); });
    if (btn) btn.classList.add('active');
    runTableFilter();
}

// 4. Secondary Subnav Tab Switcher
function switchDashboardTab(tab, btn) {
    var tabBtns = document.querySelectorAll('.subnav-tab-btn');
    tabBtns.forEach(function(b) { b.classList.remove('active'); });
    if (btn) btn.classList.add('active');

    var titleEl = document.getElementById('tableTitleText');

    if (tab === 'today') {
        if (titleEl) titleEl.textContent = "Today's Scheduled Consultations";
        var todayDateStr = "<?=date('d M Y');?>";
        if (searchInput) {
            searchInput.value = todayDateStr;
            runTableFilter();
        }
    } else if (tab === 'pending') {
        if (titleEl) titleEl.textContent = "Pending Doctor Reviews & Consultations";
        filterTableStatus('confirmed', null);
    } else {
        if (titleEl) titleEl.textContent = "Consultation Appointments & Queue";
        if (searchInput) searchInput.value = '';
        filterTableStatus('all', null);
    }
}

// 5. Chart.js High-Definition Visualizations
document.addEventListener('DOMContentLoaded', function() {
    // 5a. Consultation Status Doughnut
    var ctxDoughnut = document.getElementById('consultationStatusChart');
    if (ctxDoughnut) {
        new Chart(ctxDoughnut.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Visited (Closed)', 'Upcoming (Queue)', 'Cancelled'],
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
                        boxWidth: 10,
                        fontSize: 12,
                        fontColor: '#475569',
                        padding: 12
                    }
                },
                cutoutPercentage: 68
            }
        });
    }

    // 5b. 6-Month Monthly Consultation Trend Line
    var ctxTrend = document.getElementById('consultationTrendChart');
    if (ctxTrend) {
        new Chart(ctxTrend.getContext('2d'), {
            type: 'line',
            data: {
                labels: <?=json_encode($monthly_labels);?>,
                datasets: [{
                    label: 'Patient Consultations',
                    data: <?=json_encode($monthly_data);?>,
                    borderColor: '#0284c7',
                    backgroundColor: 'rgba(2, 132, 199, 0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#0284c7',
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
                            fontSize: 12
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
                            fontSize: 12
                        }
                    }]
                }
            }
        });
    }
});
</script>

<?php include ("assets/includes/footer.php"); ?>
