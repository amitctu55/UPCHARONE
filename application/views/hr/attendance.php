<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Leaflet.js for Interactive Geofence Map Modal -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    /* ===================================================
       UPCHAR ENTERPRISE WORKFORCE ATTENDANCE ROSTER STYLES
       =================================================== */
    :root {
        --hr-teal: #00a896;
        --hr-teal-dark: #028071;
        --hr-teal-light: #e6fffa;
        --hr-navy: #0f172a;
        --hr-slate: #1e293b;
        --hr-border: #e2e8f0;
        --hr-card-bg: #ffffff;
    }

    .roster-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        transition: all 0.2s ease;
    }

    .roster-kpi-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .roster-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    }
    .roster-kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    .roster-kpi-card.kpi-green::before { background: linear-gradient(90deg, #10b981, #059669); }
    .roster-kpi-card.kpi-amber::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .roster-kpi-card.kpi-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
    .roster-kpi-card.kpi-rose::before { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .roster-kpi-card.kpi-sky::before { background: linear-gradient(90deg, #0284c7, #0369a1); }

    /* Spotlight Card */
    .staff-spotlight-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f2b38 100%);
        border-radius: 18px;
        color: #ffffff;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }
    .staff-spotlight-card::after {
        content: '';
        position: absolute;
        right: -60px;
        bottom: -60px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(0, 168, 150, 0.25) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .spotlight-metric-pill {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        padding: 10px 16px;
        display: flex;
        flex-direction: column;
        min-width: 110px;
    }

    /* Tabs & Filter Chips */
    .role-filter-tab {
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
        padding: 8px 16px;
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .role-filter-tab:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .role-filter-tab.active {
        background: #0f172a !important;
        color: #ffffff !important;
        border-color: #0f172a !important;
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.2);
    }

    .status-filter-chip {
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        padding: 5px 13px;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid transparent;
        background: #f1f5f9;
        color: #475569;
    }
    .status-filter-chip:hover {
        transform: translateY(-1px);
    }
    .status-filter-chip.active {
        background: #0f172a !important;
        color: #ffffff !important;
        border-color: #0f172a !important;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.25);
    }

    /* Table Rows */
    .roster-row {
        transition: background-color 0.15s ease;
    }
    .roster-row:hover {
        background-color: #f8fafc !important;
    }
    .roster-row.highlight-searched {
        background-color: #f0fdfa !important;
        border-left: 4px solid #00a896;
    }

    /* Quick Punch Button */
    .quick-punch-btn {
        padding: 3px 8px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    .quick-punch-btn:hover {
        background: #00a896;
        color: #ffffff;
        border-color: #00a896;
        box-shadow: 0 2px 6px rgba(0, 168, 150, 0.3);
    }

    /* Live Pulse Dot */
    .live-pulse-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse-green 1.8s infinite;
    }
    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 7px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Quick Status Select Dropdown */
    .quick-status-select {
        height: 32px;
        font-size: 11.5px;
        font-weight: 800;
        border-radius: 20px;
        padding: 2px 10px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        width: 142px;
        display: inline-block;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        outline: none;
        transition: all 0.2s ease;
    }
    .quick-status-select:focus {
        box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.2);
    }

    /* Admin Action Button Styling */
    .admin-action-btn {
        padding: 5px 11px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 1px solid transparent;
    }
    .admin-action-btn.btn-edit {
        background: #f0fdfa;
        color: #00a896;
        border-color: #ccfbf1;
    }
    .admin-action-btn.btn-edit:hover {
        background: #00a896;
        color: #ffffff;
        border-color: #00a896;
        box-shadow: 0 3px 10px rgba(0, 168, 150, 0.3);
    }
    .admin-action-btn.btn-map {
        background: #f0f9ff;
        color: #0284c7;
        border-color: #bae6fd;
        padding: 5px 8px;
    }
    .admin-action-btn.btn-map:hover {
        background: #0284c7;
        color: #ffffff;
    }
    .admin-action-btn.btn-del {
        background: #ffffff;
        color: #ef4444;
        border-color: #fecaca;
        padding: 5px 8px;
    }
    .admin-action-btn.btn-del:hover {
        background: #ef4444;
        color: #ffffff;
    }

    /* Pagination Controls Styling */
    .roster-pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 24px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-num-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        background: #ffffff;
        color: #475569;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .page-num-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .page-num-btn.active {
        background: #0f172a !important;
        color: #ffffff !important;
        border-color: #0f172a !important;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.2);
    }
    .page-nav-btn {
        height: 32px;
        padding: 0 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        background: #ffffff;
        color: #475569;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }
    .page-nav-btn:hover:not(.disabled) {
        background: #f8fafc;
        color: #0f172a;
    }
    .page-nav-btn.disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    /* Modal Styling */
    .upchar-modal-content {
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.35);
        overflow: hidden;
        background: #ffffff;
    }
    .upchar-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 20px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-tab-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .modal-tab-btn.active {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }
    .modal-preset-chip {
        padding: 3px 9px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 6px;
        background: #f0fdfa;
        color: #00a896;
        border: 1px solid #ccfbf1;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .modal-preset-chip:hover {
        background: #00a896;
        color: #ffffff;
    }

    #leafletMapContainer {
        height: 420px;
        width: 100%;
    }

    @media print {
        .hr-sidebar, .hr-topbar, .hr-suite-nav, .no-print, .btn, form, #rosterToast, .roster-pagination-bar {
            display: none !important;
        }
        .hr-main-content {
            padding: 0 !important;
            margin: 0 !important;
        }
        .roster-card {
            border: 1px solid #cbd5e1 !important;
            box-shadow: none !important;
        }
    }
</style>

<div class="hr-attendance-container" style="max-width: 1420px; margin: 0 auto; padding-bottom: 50px;">

    <?php
    // Calculate Attendance Statistics for Selected Date
    $totalScheduled   = count($daily_roster ?? []);
    $presentCount     = 0;
    $lateCount        = 0;
    $halfDayCount     = 0;
    $absentCount      = 0;
    $onLeaveCount     = 0;
    $totalHoursLogged = 0.00;

    foreach ($daily_roster as $row) {
        $st = !empty($row['attendance_status']) ? $row['attendance_status'] : 'absent';
        if ($st === 'present') {
            $presentCount++;
        } elseif ($st === 'late') {
            $lateCount++;
        } elseif ($st === 'half_day') {
            $halfDayCount++;
        } elseif ($st === 'on_leave') {
            $onLeaveCount++;
        } else {
            $absentCount++;
        }

        $totalHoursLogged += floatval($row['working_hours'] ?? 0);
    }

    $attendedCount  = $presentCount + $lateCount + $halfDayCount;
    $attendanceRate = $totalScheduled > 0 ? round(($attendedCount / $totalScheduled) * 100, 1) : 0;
    $avgHours       = $attendedCount > 0 ? round($totalHoursLogged / $attendedCount, 1) : 0.0;

    $yesterdayDate  = date('Y-m-d', strtotime($selected_date . ' -1 day'));
    $tomorrowDate   = date('Y-m-d', strtotime($selected_date . ' +1 day'));
    $todayDate      = date('Y-m-d');
    $isToday        = ($selected_date === $todayDate);
    ?>

    <!-- Toast Notification Overlay -->
    <div id="rosterToast" style="position: fixed; bottom: 24px; right: 24px; background: #0f172a; color: #ffffff; padding: 12px 20px; border-radius: 12px; font-weight: 700; font-size: 13px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); display: none; z-index: 99999; align-items: center; gap: 10px; border: 1px solid rgba(255,255,255,0.15);">
        <i class="fa fa-check-circle" style="color: #2dd4bf; font-size: 16px;"></i>
        <span id="rosterToastMsg">Attendance updated successfully</span>
    </div>

    <!-- Flash Notifications -->
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade in no-print" role="alert" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa fa-check-circle" style="font-size: 18px; color: #10b981;"></i>
                <span><?= $this->session->flashdata('success_msg'); ?></span>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #065f46; opacity: 0.7; font-size: 20px;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible fade in no-print" role="alert" style="border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-weight: 600; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa fa-exclamation-circle" style="font-size: 18px; color: #ef4444;"></i>
                <span><?= $this->session->flashdata('error_msg'); ?></span>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #991b1b; opacity: 0.7; font-size: 20px;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Action Toolbar Header & Date Switcher -->
    <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">
                    Daily Workforce Attendance Roster
                </h2>
                <span style="background: #e0f2fe; color: #0369a1; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                    <?php if ($isToday): ?><span class="live-pulse-dot"></span><?php endif; ?>
                    <?= date('l, d M Y', strtotime($selected_date)); ?>
                </span>
                <?php if (!empty($search)): ?>
                    <span style="background: #f0fdfa; color: #0f766e; border: 1px solid #99f6e4; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 12px;">
                        <i class="fa fa-filter"></i> Filter: <?= html_escape($search); ?>
                    </span>
                <?php endif; ?>
            </div>
            <p style="margin: 4px 0 0; font-size: 13.5px; color: #64748b;">
                Live GPS geofenced telemetry, biometric check-ins, shift progress, and administrative override desk.
            </p>
        </div>

        <!-- Quick Date Switchers & Action Buttons -->
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <!-- Date Navigation Buttons -->
            <div class="btn-group" style="box-shadow: 0 2px 6px rgba(0,0,0,0.04); border-radius: 10px; overflow: hidden; background: #ffffff; border: 1px solid #cbd5e1;">
                <a href="<?= base_url('admin1947/attendance/roster?date=' . $yesterdayDate . (!empty($search) ? '&search=' . urlencode($search) : '')); ?>" class="btn btn-sm" style="font-weight: 700; padding: 8px 14px; font-size: 12.5px; <?= ($selected_date === $yesterdayDate) ? 'background: #0f172a; color: #ffffff;' : 'background: #ffffff; color: #475569;'; ?>" title="Previous Day">
                    <i class="fa fa-chevron-left"></i> Yesterday
                </a>
                <a href="<?= base_url('admin1947/attendance/roster?date=' . $todayDate . (!empty($search) ? '&search=' . urlencode($search) : '')); ?>" class="btn btn-sm" style="font-weight: 700; padding: 8px 14px; font-size: 12.5px; <?= ($selected_date === $todayDate) ? 'background: #0f172a; color: #ffffff;' : 'background: #ffffff; color: #475569;'; ?>">
                    <i class="fa fa-dot-circle-o" style="color: #10b981;"></i> Today
                </a>
                <a href="<?= base_url('admin1947/attendance/roster?date=' . $tomorrowDate . (!empty($search) ? '&search=' . urlencode($search) : '')); ?>" class="btn btn-sm" style="font-weight: 700; padding: 8px 14px; font-size: 12.5px; <?= ($selected_date === $tomorrowDate) ? 'background: #0f172a; color: #ffffff;' : 'background: #ffffff; color: #475569;'; ?>" title="Next Day">
                    Tomorrow <i class="fa fa-chevron-right"></i>
                </a>
            </div>

            <!-- Date Picker Form -->
            <form method="GET" action="<?= base_url('admin1947/attendance/roster'); ?>" style="display: inline-flex; align-items: center; margin: 0;">
                <?php if (!empty($search)): ?>
                    <input type="hidden" name="search" value="<?= html_escape($search); ?>">
                <?php endif; ?>
                <div style="position: relative;">
                    <i class="fa fa-calendar" style="position: absolute; left: 12px; top: 11px; color: #94a3b8; font-size: 13px;"></i>
                    <input type="date" name="date" class="form-control" value="<?= $selected_date; ?>" onchange="this.form.submit()" style="padding-left: 34px; height: 38px; border-radius: 10px; font-size: 13px; font-weight: 600; color: #0f172a; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                </div>
            </form>

            <!-- Manual Record Button (Opens Redesigned Modal) -->
            <button type="button" class="btn btn-primary" onclick="openCreateModal()" style="background: #00a896; color: #ffffff; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; border: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);">
                <i class="fa fa-plus-circle"></i> Manual Record
            </button>

            <!-- Bulk Mark Button -->
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#bulkMarkModal" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 15px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-check-square-o" style="color: #00a896;"></i> Bulk Mark
            </button>

            <!-- Web Punch Link -->
            <a href="<?= base_url('admin1947/attendance/punch'); ?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 14px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;" title="Launch Mobile/Web Punch Terminal">
                <i class="fa fa-tablet" style="color: #7c3aed;"></i> Punch Terminal
            </a>

            <!-- Export CSV -->
            <button type="button" onclick="exportRosterCSV()" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #475569; font-weight: 700; border-radius: 10px; padding: 9px 13px; font-size: 13px;" title="Export Roster to CSV">
                <i class="fa fa-download"></i> CSV
            </button>

            <!-- Print Roster -->
            <button type="button" onclick="window.print()" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #475569; font-weight: 700; border-radius: 10px; padding: 9px 13px; font-size: 13px;" title="Print Attendance Roster">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- DEDICATED STAFF ATTENDANCE SPOTLIGHT & HISTORY BANNER    -->
    <!-- Displayed when a staff member is searched via URL / Query -->
    <!-- ========================================================= -->
    <?php if (!empty($searched_staff)): 
        $spStaff = $searched_staff;
        $spInitial = strtoupper(substr($spStaff['name'] ?? 'S', 0, 1));
        $spStats = $staff_month_stats ?? ['present' => 0, 'late' => 0, 'half_day' => 0, 'total_hours' => 0.0, 'days_logged' => 0];

        $todayRecord = null;
        foreach ($daily_roster as $dr) {
            if (intval($dr['user_id']) === intval($spStaff['id'])) {
                $todayRecord = $dr;
                break;
            }
        }

        $todayStatus = !empty($todayRecord['attendance_status']) ? $todayRecord['attendance_status'] : 'absent';
        $todayHasCheckIn = !empty($todayRecord['check_in_time']);
        $todayHasCheckOut = !empty($todayRecord['check_out_time']);
        $todayHours = floatval($todayRecord['working_hours'] ?? 0);
    ?>
        <div class="staff-spotlight-card no-print">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                
                <!-- Left: Profile & Today's Attendance Status -->
                <div style="display: flex; align-items: center; gap: 18px; flex-wrap: wrap;">
                    <div style="width: 68px; height: 68px; border-radius: 16px; background: linear-gradient(135deg, #00a896 0%, #0284c7 100%); color: #ffffff; font-size: 28px; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 168, 150, 0.4); border: 2px solid rgba(255,255,255,0.2);">
                        <?= $spInitial; ?>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <h3 style="font-size: 20px; font-weight: 800; color: #ffffff; margin: 0;">
                                <?= html_escape($spStaff['name']); ?>
                            </h3>
                            <span style="background: rgba(45, 212, 191, 0.2); color: #2dd4bf; border: 1px solid rgba(45, 212, 191, 0.4); font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px; text-transform: uppercase;">
                                <?= strtoupper($spStaff['role']); ?>
                            </span>
                            <span style="background: rgba(255, 255, 255, 0.1); color: #94a3b8; font-family: monospace; font-size: 11px; padding: 2px 8px; border-radius: 6px;">
                                <?= $spStaff['staff_code']; ?>
                            </span>
                        </div>
                        <div style="font-size: 13px; color: #94a3b8; margin-top: 4px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                            <span><i class="fa fa-building-o" style="color: #2dd4bf;"></i> <?= html_escape($spStaff['department'] ?? 'Operations'); ?></span>
                            <?php if (!empty($spStaff['phone'])): ?>
                                <span><i class="fa fa-phone" style="color: #2dd4bf;"></i> +91 <?= $spStaff['phone']; ?></span>
                            <?php endif; ?>
                            <?php if (!empty($spStaff['email'])): ?>
                                <span><i class="fa fa-envelope-o" style="color: #2dd4bf;"></i> <?= $spStaff['email']; ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Today's Status Badge on Selected Date -->
                        <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <span style="font-size: 11px; font-weight: 800; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.5px;">Status on <?= date('d M Y', strtotime($selected_date)); ?>:</span>
                            <?php if ($todayStatus === 'present'): ?>
                                <span style="background: #10b981; color: #ffffff; font-weight: 800; font-size: 11.5px; padding: 3px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-check-circle"></i> PRESENT ON-DUTY
                                </span>
                            <?php elseif ($todayStatus === 'late'): ?>
                                <span style="background: #f59e0b; color: #ffffff; font-weight: 800; font-size: 11.5px; padding: 3px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-clock-o"></i> LATE PUNCH-IN
                                </span>
                            <?php elseif ($todayStatus === 'half_day'): ?>
                                <span style="background: #ea580c; color: #ffffff; font-weight: 800; font-size: 11.5px; padding: 3px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-adjust"></i> HALF DAY
                                </span>
                            <?php elseif ($todayStatus === 'on_leave'): ?>
                                <span style="background: #8b5cf6; color: #ffffff; font-weight: 800; font-size: 11.5px; padding: 3px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-file-text-o"></i> APPROVED LEAVE
                                </span>
                            <?php else: ?>
                                <span style="background: #ef4444; color: #ffffff; font-weight: 800; font-size: 11.5px; padding: 3px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-times-circle"></i> ABSENT / NO PUNCH RECORDED
                                </span>
                            <?php endif; ?>

                            <?php if ($todayHasCheckIn): ?>
                                <span style="font-size: 12px; color: #2dd4bf; font-weight: 700;">
                                    In: <?= date('h:i A', strtotime($todayRecord['check_in_time'])); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($todayHasCheckOut): ?>
                                <span style="font-size: 12px; color: #94a3b8; font-weight: 700;">
                                    Out: <?= date('h:i A', strtotime($todayRecord['check_out_time'])); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($todayHours > 0): ?>
                                <span style="background: rgba(255,255,255,0.15); color: #ffffff; font-weight: 800; font-size: 11px; padding: 2px 8px; border-radius: 6px;">
                                    <?= number_format($todayHours, 1); ?> hrs
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right: Action Buttons & Clear Spotlight -->
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <?php if ($todayRecord): ?>
                        <button type="button" class="btn btn-sm" onclick="openEditModal(<?= htmlspecialchars(json_encode($todayRecord), ENT_QUOTES, 'UTF-8'); ?>)" style="background: rgba(255,255,255,0.15); color: #ffffff; border: 1px solid rgba(255,255,255,0.25); font-weight: 700; border-radius: 8px; padding: 7px 14px;">
                            <i class="fa fa-pencil"></i> Edit Today's Punch
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-sm" onclick="openCreateModalForStaff(<?= $spStaff['id']; ?>)" style="background: #00a896; color: #ffffff; border: none; font-weight: 700; border-radius: 8px; padding: 7px 14px;">
                            <i class="fa fa-plus-circle"></i> Add Punch for <?= html_escape($spStaff['name']); ?>
                        </button>
                    <?php endif; ?>

                    <a href="<?= base_url('admin1947/hr/directory?search=' . urlencode($spStaff['name'])); ?>" class="btn btn-sm" style="background: rgba(255,255,255,0.1); color: #ffffff; border: 1px solid rgba(255,255,255,0.2); font-weight: 700; border-radius: 8px; padding: 7px 14px;" title="View Staff Profile in Directory">
                        <i class="fa fa-id-card-o"></i> Directory Profile
                    </a>

                    <a href="<?= base_url('admin1947/attendance/roster?date=' . $selected_date); ?>" class="btn btn-sm" style="background: #ffffff; color: #0f172a; font-weight: 800; border-radius: 8px; padding: 7px 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" title="Clear Search and View Entire Roster">
                        <i class="fa fa-times-circle" style="color: #ef4444;"></i> Show All Roster
                    </a>
                </div>
            </div>

            <!-- Spotlight Month Statistics Pills -->
            <div style="display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap; padding-top: 18px; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                <div class="spotlight-metric-pill">
                    <span style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Days Logged</span>
                    <span style="font-size: 20px; font-weight: 800; color: #ffffff;"><?= $spStats['days_logged']; ?></span>
                    <small style="color: #2dd4bf; font-size: 10px; font-weight: 600;"><?= date('F Y'); ?></small>
                </div>
                <div class="spotlight-metric-pill">
                    <span style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Present Days</span>
                    <span style="font-size: 20px; font-weight: 800; color: #10b981;"><?= $spStats['present']; ?></span>
                    <small style="color: #a7f3d0; font-size: 10px; font-weight: 600;">Full shifts</small>
                </div>
                <div class="spotlight-metric-pill">
                    <span style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Late Marks</span>
                    <span style="font-size: 20px; font-weight: 800; color: #f59e0b;"><?= $spStats['late']; ?></span>
                    <small style="color: #fde68a; font-size: 10px; font-weight: 600;">Post 09:45 AM</small>
                </div>
                <div class="spotlight-metric-pill">
                    <span style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Half Days</span>
                    <span style="font-size: 20px; font-weight: 800; color: #fb923c;"><?= $spStats['half_day']; ?></span>
                    <small style="color: #fed7aa; font-size: 10px; font-weight: 600;">Partial shift</small>
                </div>
                <div class="spotlight-metric-pill">
                    <span style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Total Hours</span>
                    <span style="font-size: 20px; font-weight: 800; color: #38bdf8;"><?= number_format($spStats['total_hours'], 1); ?>h</span>
                    <small style="color: #bae6fd; font-size: 10px; font-weight: 600;">
                        Avg <?= $spStats['days_logged'] > 0 ? number_format($spStats['total_hours'] / $spStats['days_logged'], 1) : '0'; ?>h / day
                    </small>
                </div>

                <!-- Recent Punch Logs Expand / Toggle Button -->
                <div style="margin-left: auto; display: flex; align-items: flex-end;">
                    <button type="button" class="btn btn-sm" onclick="$('#staffHistoryDrawer').slideToggle(200)" style="background: rgba(255,255,255,0.12); color: #ffffff; border: 1px solid rgba(255,255,255,0.2); font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                        <i class="fa fa-history" style="color: #2dd4bf;"></i> View Recent Punch History (<?= count($staff_history ?? []); ?> Logs) <i class="fa fa-angle-down"></i>
                    </button>
                </div>
            </div>

            <!-- Collapsible Recent Punch History Drawer -->
            <div id="staffHistoryDrawer" style="display: none; margin-top: 18px; padding-top: 16px; border-top: 1px dashed rgba(255, 255, 255, 0.15);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h5 style="margin: 0; font-size: 13px; font-weight: 800; color: #2dd4bf; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fa fa-calendar-check-o"></i> Recent 20 Punch Logs for <?= html_escape($spStaff['name']); ?>
                    </h5>
                    <small style="color: #94a3b8; font-size: 11px;">Click any row or edit button to adjust punch record</small>
                </div>

                <?php if (empty($staff_history)): ?>
                    <div style="text-align: center; padding: 20px; color: #94a3b8; font-size: 12.5px;">
                        No previous attendance punches recorded for this staff member.
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto; background: rgba(0, 0, 0, 0.2); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.08);">
                        <table class="table" style="margin: 0; color: #e2e8f0; font-size: 12px;">
                            <thead>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 10.5px; color: #94a3b8; text-transform: uppercase;">
                                    <th>Punch Date</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Hours</th>
                                    <th>Geofence</th>
                                    <th>Status</th>
                                    <th>Notes / Remarks</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staff_history as $h): 
                                    $hStatus = $h['status'] ?? 'absent';
                                    $badgeColor = '#10b981';
                                    if ($hStatus === 'late') $badgeColor = '#f59e0b';
                                    elseif ($hStatus === 'half_day') $badgeColor = '#ea580c';
                                    elseif ($hStatus === 'on_leave') $badgeColor = '#8b5cf6';
                                    elseif ($hStatus === 'absent') $badgeColor = '#ef4444';
                                ?>
                                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                        <td style="font-weight: 700; color: #ffffff;">
                                            <?= date('D, d M Y', strtotime($h['punch_date'])); ?>
                                            <?php if ($h['punch_date'] === $selected_date): ?>
                                                <span style="color: #2dd4bf; font-size: 10px; margin-left: 4px;">(Current)</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= !empty($h['check_in_time']) ? '<span style="color: #38bdf8;"><i class="fa fa-sign-in"></i> ' . date('h:i A', strtotime($h['check_in_time'])) . '</span>' : '--:--'; ?>
                                        </td>
                                        <td>
                                            <?= !empty($h['check_out_time']) ? '<span style="color: #cbd5e1;"><i class="fa fa-sign-out"></i> ' . date('h:i A', strtotime($h['check_out_time'])) . '</span>' : '--:--'; ?>
                                        </td>
                                        <td style="font-weight: 700;">
                                            <?= floatval($h['working_hours']) > 0 ? number_format($h['working_hours'], 1) . 'h' : '--'; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($h['distance_from_office_km'])): ?>
                                                <span style="color: <?= floatval($h['distance_from_office_km']) <= 0.5 ? '#10b981' : '#f59e0b'; ?>; font-weight: 600;">
                                                    <?= number_format(floatval($h['distance_from_office_km']), 2); ?> km
                                                </span>
                                            <?php else: ?>
                                                <span style="color: #64748b;">--</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span style="background: <?= $badgeColor; ?>; color: #ffffff; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                                                <?= str_replace('_', ' ', $hStatus); ?>
                                            </span>
                                        </td>
                                        <td style="color: #94a3b8; font-size: 11.5px; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?= html_escape($h['notes'] ?? '--'); ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="<?= base_url('admin1947/attendance/roster?date=' . $h['punch_date'] . '&search=' . urlencode($spStaff['name'])); ?>" class="btn btn-xs" style="background: rgba(255,255,255,0.15); color: #ffffff; font-size: 10.5px; padding: 2px 8px; border-radius: 4px;" title="Jump to this date in roster">
                                                <i class="fa fa-eye"></i> View Day
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- KPI Summary Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 22px;">
        <!-- 1. Present -->
        <div class="roster-kpi-card kpi-green">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Present On-Duty</span>
                <span style="background: #dcfce7; color: #166534; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">
                    <?= $totalScheduled > 0 ? round(($presentCount / $totalScheduled) * 100) : 0; ?>%
                </span>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: #15803d; margin-top: 4px;"><?= $presentCount; ?></div>
            <small style="color: #16a34a; font-size: 11.5px; font-weight: 600;"><i class="fa fa-check-circle"></i> On-time compliant</small>
        </div>

        <!-- 2. Late -->
        <div class="roster-kpi-card kpi-amber">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Late Marks</span>
                <span style="background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">Post Grace</span>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: #b45309; margin-top: 4px;"><?= $lateCount; ?></div>
            <small style="color: #d97706; font-size: 11.5px; font-weight: 600;"><i class="fa fa-clock-o"></i> After 09:45 AM</small>
        </div>

        <!-- 3. Half Day / Leave -->
        <div class="roster-kpi-card kpi-purple">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Half Day / Leave</span>
                <span style="background: #f5f3ff; color: #6d28d9; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">Approved</span>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: #6d28d9; margin-top: 4px;"><?= $halfDayCount + $onLeaveCount; ?></div>
            <small style="color: #7c3aed; font-size: 11.5px; font-weight: 600;"><?= $halfDayCount; ?> Half-day, <?= $onLeaveCount; ?> Leave</small>
        </div>

        <!-- 4. Absent -->
        <div class="roster-kpi-card kpi-rose">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Absent Staff</span>
                <span style="background: #fee2e2; color: #991b1b; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">No Punch</span>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: #dc2626; margin-top: 4px;"><?= $absentCount; ?></div>
            <small style="color: #ef4444; font-size: 11.5px; font-weight: 600;"><i class="fa fa-times-circle"></i> Unaccounted shifts</small>
        </div>

        <!-- 5. Hours & Compliance Rate -->
        <div class="roster-kpi-card kpi-sky">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Attendance Rate</span>
                <span style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">
                    Avg <?= $avgHours; ?>h / staff
                </span>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: #0284c7; margin-top: 4px;"><?= $attendanceRate; ?>%</div>
            <div style="width: 100%; height: 5px; background: #e2e8f0; border-radius: 4px; margin-top: 8px; overflow: hidden;">
                <div style="width: <?= min(100, $attendanceRate); ?>%; height: 100%; background: <?= $attendanceRate >= 80 ? '#10b981' : ($attendanceRate >= 50 ? '#f59e0b' : '#ef4444'); ?>; border-radius: 4px;"></div>
            </div>
        </div>
    </div>

    <!-- Multi-Facet Filters & Table Card -->
    <div class="roster-card" style="overflow: hidden; margin-bottom: 30px;">
        
        <!-- Filter Toolbar -->
        <div class="no-print" style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #ffffff; display: flex; flex-direction: column; gap: 14px;">
            
            <!-- Row 1: Role Tabs & Live Search -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <!-- Role Filter Tabs -->
                <div class="btn-group" id="roleFilterGroup" style="display: inline-flex; flex-wrap: wrap; gap: 6px;">
                    <button type="button" class="role-filter-tab active" data-role="all">
                        All Staff (<?= $totalScheduled; ?>)
                    </button>
                    <button type="button" class="role-filter-tab" data-role="collector">
                        <i class="fa fa-tint" style="color: #0284c7;"></i> Phlebotomists
                    </button>
                    <button type="button" class="role-filter-tab" data-role="bde">
                        <i class="fa fa-line-chart" style="color: #7c3aed;"></i> BDEs
                    </button>
                    <button type="button" class="role-filter-tab" data-role="hr">
                        <i class="fa fa-users" style="color: #00a896;"></i> HR &amp; Admin
                    </button>
                    <button type="button" class="role-filter-tab" data-role="office_staff">
                        <i class="fa fa-building" style="color: #475569;"></i> Operations
                    </button>
                </div>

                <!-- Live Instant Search with Clear Button -->
                <div style="position: relative; min-width: 300px; flex-grow: 1; max-width: 420px;">
                    <i class="fa fa-search" style="position: absolute; left: 14px; top: 12px; color: #94a3b8; font-size: 13px;"></i>
                    <input type="text" 
                           id="rosterSearchInput" 
                           value="<?= html_escape($search); ?>" 
                           onkeyup="filterRosterTable()" 
                           class="form-control" 
                           placeholder="Search staff name, code, phone, notes..." 
                           style="padding-left: 38px; padding-right: 32px; height: 40px; border-radius: 10px; font-size: 13px; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    
                    <button type="button" id="clearSearchBtn" onclick="clearSearchFilter()" style="position: absolute; right: 10px; top: 10px; border: none; background: transparent; color: #94a3b8; cursor: pointer; font-size: 14px; <?= empty($search) ? 'display: none;' : ''; ?>" title="Clear Search Filter">
                        <i class="fa fa-times-circle"></i>
                    </button>
                </div>
            </div>

            <!-- Row 2: Status Chips & Geofence Filter & Per-Page Controls -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; padding-top: 12px; border-top: 1px dashed #f1f5f9;">
                <!-- Status Filter Chips -->
                <div style="display: inline-flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-right: 4px;">Status:</span>
                    <button type="button" class="status-filter-chip active" data-status="all">
                        All (<?= $totalScheduled; ?>)
                    </button>
                    <button type="button" class="status-filter-chip" data-status="present" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                        🟢 Present (<?= $presentCount; ?>)
                    </button>
                    <button type="button" class="status-filter-chip" data-status="late" style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a;">
                        🟡 Late (<?= $lateCount; ?>)
                    </button>
                    <button type="button" class="status-filter-chip" data-status="half_day" style="background: #fff7ed; color: #9a3412; border: 1px solid #fed7aa;">
                        🟠 Half Day (<?= $halfDayCount; ?>)
                    </button>
                    <button type="button" class="status-filter-chip" data-status="on_leave" style="background: #f5f3ff; color: #5b21b6; border: 1px solid #ddd6fe;">
                        🟣 On Leave (<?= $onLeaveCount; ?>)
                    </button>
                    <button type="button" class="status-filter-chip" data-status="absent" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca;">
                        🔴 Absent (<?= $absentCount; ?>)
                    </button>
                </div>

                <!-- Geofence & Page Size Filter -->
                <div style="display: inline-flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <div style="display: inline-flex; align-items: center; gap: 6px;">
                        <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Geofence:</span>
                        <select id="geofenceFilter" onchange="filterRosterTable()" class="form-control" style="height: 34px; padding: 4px 10px; font-size: 12px; font-weight: 600; border-radius: 8px; border: 1px solid #cbd5e1; width: auto;">
                            <option value="all">All Ranges</option>
                            <option value="hub">Hub (&le; 0.5 km)</option>
                            <option value="perimeter">Field (&gt; 0.5 km)</option>
                            <option value="unrecorded">Not Recorded</option>
                        </select>
                    </div>

                    <div style="display: inline-flex; align-items: center; gap: 6px;">
                        <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Rows:</span>
                        <select id="pageSizeFilter" onchange="changePageSize(this.value)" class="form-control" style="height: 34px; padding: 4px 8px; font-size: 12px; font-weight: 700; border-radius: 8px; border: 1px solid #cbd5e1; width: auto;">
                            <option value="10" selected>10 / page</option>
                            <option value="25">25 / page</option>
                            <option value="50">50 / page</option>
                            <option value="all">View All</option>
                        </select>
                    </div>

                    <span id="filteredStaffCount" style="font-size: 11.5px; font-weight: 700; color: #64748b; background: #f8fafc; padding: 5px 10px; border-radius: 6px; border: 1px solid #e2e8f0;">
                        Showing <strong><?= $totalScheduled; ?></strong> employees
                    </span>
                </div>
            </div>
        </div>

        <!-- Roster Data Table -->
        <div class="table-responsive" style="margin: 0;">
            <table class="table table-hover" id="rosterTable" style="margin: 0; vertical-align: middle;">
                <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr style="font-size: 11px; color: #475569; text-transform: uppercase; letter-spacing: 0.6px;">
                        <th style="padding: 14px 22px; font-weight: 800;">Staff Member</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Role &amp; Department</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Check-In</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Check-Out</th>
                        <th style="padding: 14px 16px; font-weight: 800;">GPS &amp; Geofence</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Shift Progress</th>
                        <th style="padding: 14px 16px; font-weight: 800; text-align: center;">Quick Status</th>
                        <th class="no-print" style="padding: 14px 22px; font-weight: 800; text-align: right;">Admin Actions</th>
                    </tr>
                </thead>
                <tbody id="rosterTableBody">
                    <?php if (empty($daily_roster)): ?>
                        <tr id="emptyRow">
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 60px 20px;">
                                <i class="fa fa-calendar-times-o" style="font-size: 42px; color: #cbd5e1; display: block; margin-bottom: 14px;"></i>
                                <strong style="font-size: 16px; color: #334155;">No staff attendance records found for <?= date('d M Y', strtotime($selected_date)); ?></strong>
                                <p style="font-size: 13.5px; color: #94a3b8; margin: 6px 0 18px 0;">Create manual punches or switch to another date.</p>
                                <button type="button" class="btn btn-sm btn-primary" onclick="openCreateModal()" style="background: #00a896; border: none; font-weight: 700; border-radius: 8px; padding: 9px 20px;">
                                    <i class="fa fa-plus-circle"></i> Create First Punch Record
                                </button>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $roleMap = [
                            'super_admin'  => ['label' => 'Super Admin', 'bg' => '#f1f5f9', 'text' => '#0f172a', 'icon' => 'fa-shield'],
                            'admin'        => ['label' => 'Administrator', 'bg' => '#f1f5f9', 'text' => '#0f172a', 'icon' => 'fa-shield'],
                            'collector'    => ['label' => 'Phlebotomist', 'bg' => '#e0f2fe', 'text' => '#0369a1', 'icon' => 'fa-tint'],
                            'bde'          => ['label' => 'BDE Officer', 'bg' => '#f5f3ff', 'text' => '#6d28d9', 'icon' => 'fa-line-chart'],
                            'hr'           => ['label' => 'HR Specialist', 'bg' => '#f0fdfa', 'text' => '#0f766e', 'icon' => 'fa-users'],
                            'office_staff' => ['label' => 'Operations Officer', 'bg' => '#fef3c7', 'text' => '#92400e', 'icon' => 'fa-building'],
                        ];

                        foreach ($daily_roster as $row): 
                            $st = !empty($row['attendance_status']) ? $row['attendance_status'] : 'absent';
                            $statusBg    = '#fee2e2';
                            $statusColor = '#991b1b';

                            if ($st === 'present') {
                                $statusBg    = '#dcfce7';
                                $statusColor = '#166534';
                            } elseif ($st === 'late') {
                                $statusBg    = '#fef3c7';
                                $statusColor = '#92400e';
                            } elseif ($st === 'half_day') {
                                $statusBg    = '#ffedd5';
                                $statusColor = '#9a3412';
                            } elseif ($st === 'on_leave') {
                                $statusBg    = '#f3e8ff';
                                $statusColor = '#6b21a8';
                            }

                            $hasCheckIn  = !empty($row['check_in_time']);
                            $hasCheckOut = !empty($row['check_out_time']);
                            $distance    = floatval($row['distance_from_office_km'] ?? 0);
                            $role        = strtolower($row['role'] ?? 'office_staff');
                            $rMeta       = $roleMap[$role] ?? ['label' => ucwords(str_replace('_', ' ', $role)), 'bg' => '#f1f5f9', 'text' => '#475569', 'icon' => 'fa-user'];

                            $initial = strtoupper(substr($row['name'] ?? 'S', 0, 1));
                            $avatarColors = ['#00a896', '#0284c7', '#7c3aed', '#ec4899', '#f59e0b', '#10b981'];
                            $avatarBg = $avatarColors[abs(crc32($row['name'] ?? '')) % count($avatarColors)];

                            $isSearchedMatch = !empty($searched_staff) && (intval($row['user_id']) === intval($searched_staff['id']));
                        ?>
                            <tr class="roster-row <?= $isSearchedMatch ? 'highlight-searched' : ''; ?>" 
                                id="row_user_<?= $row['user_id']; ?>"
                                data-name="<?= strtolower(html_escape($row['name'])); ?>"
                                data-code="<?= strtolower(html_escape($row['staff_code'])); ?>"
                                data-phone="<?= html_escape($row['phone'] ?? ''); ?>"
                                data-role="<?= $role; ?>"
                                data-dept="<?= strtolower(html_escape($row['department'] ?? '')); ?>"
                                data-status="<?= $st; ?>"
                                data-distance="<?= $distance; ?>"
                                data-has-checkin="<?= $hasCheckIn ? '1' : '0'; ?>"
                                style="vertical-align: middle;">
                                
                                <!-- Staff Member -->
                                <td style="padding: 12px 22px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 38px; height: 38px; border-radius: 10px; background: <?= $avatarBg; ?>; color: #ffffff; font-weight: 800; font-size: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                            <?= $initial; ?>
                                        </div>
                                        <div>
                                            <a href="<?= base_url('admin1947/attendance/roster?date=' . $selected_date . '&search=' . urlencode($row['name'])); ?>" style="font-size: 13.5px; font-weight: 800; color: #0f172a; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;" title="View staff attendance spotlight">
                                                <?= html_escape($row['name']); ?>
                                                <?php if ($isSearchedMatch): ?>
                                                    <span style="color: #00a896; font-size: 11px;" title="Currently Spotlighted"><i class="fa fa-star"></i></span>
                                                <?php endif; ?>
                                            </a>
                                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 2px;">
                                                <span style="color: #475569; font-family: monospace; font-size: 11px; background: #f1f5f9; padding: 1px 6px; border-radius: 4px; font-weight: 600;">
                                                    <?= $row['staff_code']; ?>
                                                </span>
                                                <?php if (!empty($row['phone'])): ?>
                                                    <span style="color: #64748b; font-size: 11px;">
                                                        <i class="fa fa-phone" style="font-size: 10px; color: #94a3b8;"></i> <?= $row['phone']; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role & Department -->
                                <td style="padding: 12px 16px;">
                                    <span style="font-size: 11px; font-weight: 700; color: <?= $rMeta['text']; ?>; background: <?= $rMeta['bg']; ?>; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa <?= $rMeta['icon']; ?>" style="font-size: 10px;"></i> <?= $rMeta['label']; ?>
                                    </span>
                                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                                        <i class="fa fa-building-o" style="font-size: 10.5px; color: #94a3b8;"></i> <?= html_escape($row['department'] ?? 'Operations'); ?>
                                    </div>
                                </td>

                                <!-- Check In -->
                                <td style="padding: 12px 16px;">
                                    <?php if ($hasCheckIn): 
                                        $inHour   = date('H:i', strtotime($row['check_in_time']));
                                        $isOnTime = ($inHour <= '09:45');
                                    ?>
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <strong style="color: #0284c7; font-size: 13px; font-family: monospace;">
                                                <i class="fa fa-sign-in" style="margin-right: 2px;"></i> <?= date('h:i A', strtotime($row['check_in_time'])); ?>
                                            </strong>
                                            <?php if ($isOnTime): ?>
                                                <span style="background: #dcfce7; color: #166534; font-size: 9.5px; font-weight: 700; padding: 1px 5px; border-radius: 4px;">On-Time</span>
                                            <?php else: ?>
                                                <span style="background: #fef3c7; color: #92400e; font-size: 9.5px; font-weight: 700; padding: 1px 5px; border-radius: 4px;">Late</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-print" style="display: flex; gap: 4px; align-items: center;">
                                            <button type="button" onclick="quickClockIn(<?= $row['user_id']; ?>, '09:30:00')" class="quick-punch-btn" title="Quick punch-in at 09:30 AM">
                                                <i class="fa fa-plus"></i> 09:30
                                            </button>
                                            <button type="button" onclick="quickClockIn(<?= $row['user_id']; ?>, 'now')" class="quick-punch-btn" title="Quick punch-in at current time">
                                                Now
                                            </button>
                                        </div>
                                        <span class="only-print" style="color: #cbd5e1; font-size: 12px; font-family: monospace;">--:--</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Check Out -->
                                <td style="padding: 12px 16px;">
                                    <?php if ($hasCheckOut): ?>
                                        <strong style="color: #334155; font-size: 13px; font-family: monospace;">
                                            <i class="fa fa-sign-out" style="margin-right: 2px; color: #64748b;"></i> <?= date('h:i A', strtotime($row['check_out_time'])); ?>
                                        </strong>
                                    <?php elseif ($hasCheckIn): ?>
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <span style="background: #e0f2fe; color: #0369a1; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                                <span class="live-pulse-dot" style="width: 5px; height: 5px;"></span> In Progress
                                            </span>
                                            <div class="no-print" style="display: inline-flex; gap: 3px;">
                                                <button type="button" onclick="quickClockOut(<?= $row['user_id']; ?>, '18:30:00')" class="quick-punch-btn" title="Quick punch-out at 06:30 PM">
                                                    <i class="fa fa-check"></i> 18:30
                                                </button>
                                                <button type="button" onclick="quickClockOut(<?= $row['user_id']; ?>, 'now')" class="quick-punch-btn" title="Quick punch-out at current time">
                                                    Now
                                                </button>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: #cbd5e1; font-size: 12px; font-family: monospace;">--:--</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Geofence Distance & Location Map / Selfie Trigger -->
                                <td style="padding: 12px 16px;">
                                    <?php if ($hasCheckIn): 
                                        $coordsText = number_format(floatval($row['check_in_lat'] ?: 26.8467), 4) . ', ' . number_format(floatval($row['check_in_lng'] ?: 80.9462), 4);
                                    ?>
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <?php if ($distance <= 0.5): ?>
                                                <span style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;" title="GPS: <?= $coordsText; ?>">
                                                    <i class="fa fa-shield" style="color: #16a34a;"></i> Hub Verified (<?= number_format($distance, 2); ?> km)
                                                </span>
                                            <?php else: ?>
                                                <span style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;" title="GPS: <?= $coordsText; ?>">
                                                    <i class="fa fa-map-marker" style="color: #d97706;"></i> Field (<?= number_format($distance, 2); ?> km)
                                                </span>
                                            <?php endif; ?>

                                            <!-- Interactive Map Modal Trigger -->
                                            <button type="button" class="btn btn-xs btn-default no-print" onclick="openMapModal(<?= floatval($row['check_in_lat'] ?: 26.8467); ?>, <?= floatval($row['check_in_lng'] ?: 80.9462); ?>, '<?= html_escape(addslashes($row['name'])); ?>', '<?= number_format($distance, 2); ?> km', '<?= date('h:i A', strtotime($row['check_in_time'])); ?>')" style="padding: 2px 7px; border-radius: 6px; font-size: 11px; border: 1px solid #cbd5e1; color: #0284c7; background: #ffffff;" title="View Live GPS Map Radar">
                                                <i class="fa fa-map"></i>
                                            </button>

                                            <!-- Biometric Selfie / Photo Trigger if available -->
                                            <?php if (!empty($row['check_in_selfie'])): ?>
                                                <button type="button" class="btn btn-xs btn-default no-print" onclick="openSelfieModal('<?= $row['check_in_selfie']; ?>', '<?= html_escape(addslashes($row['name'])); ?>', '<?= date('h:i A', strtotime($row['check_in_time'])); ?>')" style="padding: 2px 7px; border-radius: 6px; font-size: 11px; border: 1px solid #cbd5e1; color: #7c3aed; background: #ffffff;" title="View Biometric WebRTC Selfie">
                                                    <i class="fa fa-camera"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: #cbd5e1; font-size: 12px;">--</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Shift Hours Progress -->
                                <td style="padding: 12px 16px;">
                                    <div style="display: flex; align-items: baseline; gap: 4px;">
                                        <strong style="font-size: 13px; color: #0f172a; font-family: monospace;">
                                            <?= floatval($row['working_hours'] ?? 0) > 0 ? number_format($row['working_hours'], 1) . 'h' : '--'; ?>
                                        </strong>
                                        <small style="color: #94a3b8; font-size: 11px;">/ 9.0h</small>
                                    </div>
                                    <?php if (floatval($row['working_hours'] ?? 0) > 0): ?>
                                        <div style="width: 76px; height: 5px; background: #e2e8f0; border-radius: 4px; margin-top: 4px; overflow: hidden;">
                                            <div style="width: <?= min(100, round((floatval($row['working_hours']) / 9) * 100)); ?>%; height: 100%; background: <?= floatval($row['working_hours']) >= 8 ? '#10b981' : (floatval($row['working_hours']) >= 4 ? '#f59e0b' : '#ef4444'); ?>; border-radius: 4px;"></div>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Quick Status: Intuitive 1-Click Dropdown Option -->
                                <td style="padding: 12px 16px; text-align: center;">
                                    <select class="quick-status-select" 
                                            id="status_select_<?= $row['user_id']; ?>"
                                            onchange="quickSaveStatus(<?= $row['user_id']; ?>, this.value)"
                                            style="background: <?= $statusBg; ?>; color: <?= $statusColor; ?>; border-color: <?= $statusColor; ?>40;">
                                        <option value="present" <?= ($st === 'present') ? 'selected' : ''; ?>>🟢 Present</option>
                                        <option value="late" <?= ($st === 'late') ? 'selected' : ''; ?>>🟡 Late</option>
                                        <option value="half_day" <?= ($st === 'half_day') ? 'selected' : ''; ?>>🟠 Half Day</option>
                                        <option value="on_leave" <?= ($st === 'on_leave') ? 'selected' : ''; ?>>🟣 On Leave</option>
                                        <option value="absent" <?= ($st === 'absent') ? 'selected' : ''; ?>>🔴 Absent</option>
                                    </select>
                                </td>

                                <!-- Admin Override Controls -->
                                <td class="no-print" style="padding: 12px 22px; text-align: right;">
                                    <div style="display: inline-flex; align-items: center; gap: 5px;">
                                        <!-- Edit Modal Trigger -->
                                        <button type="button" class="btn btn-sm admin-action-btn btn-edit" onclick="openEditModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)" title="Open Full Edit Popup">
                                            <i class="fa fa-pencil"></i> Edit
                                        </button>

                                        <!-- Radar Trigger -->
                                        <?php if ($hasCheckIn): ?>
                                            <button type="button" class="btn btn-sm admin-action-btn btn-map" onclick="openMapModal(<?= floatval($row['check_in_lat'] ?: 26.8467); ?>, <?= floatval($row['check_in_lng'] ?: 80.9462); ?>, '<?= html_escape(addslashes($row['name'])); ?>', '<?= number_format($distance, 2); ?> km', '<?= date('h:i A', strtotime($row['check_in_time'])); ?>')" title="Open GPS Radar Popup">
                                                <i class="fa fa-map-marker"></i>
                                            </button>
                                        <?php endif; ?>

                                        <!-- Clear Record Button -->
                                        <?php if (!empty($row['attendance_id'])): ?>
                                            <button type="button" class="btn btn-sm admin-action-btn btn-del" onclick="confirmDeleteRecord(<?= $row['attendance_id']; ?>, '<?= html_escape(addslashes($row['name'])); ?>')" title="Clear Punch Record">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- ========================================== -->
        <!-- TABLE FOOTER: PAGINATION CONTROLS BAR      -->
        <!-- ========================================== -->
        <div class="roster-pagination-bar no-print">
            <div id="paginationInfoText" style="font-size: 12.5px; font-weight: 700; color: #64748b;">
                Showing 1-10 of <?= $totalScheduled; ?> employees
            </div>
            
            <div id="paginationButtons" style="display: inline-flex; align-items: center; gap: 4px;">
                <!-- Dynamically rendered via renderPagination() -->
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- REDESIGNED MODAL 1: ADMIN GEOFENCE & PUNCH OVERRIDE POPUP -->
<!-- ========================================================= -->
<div class="modal fade" id="attendanceRecordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 840px;">
        <div class="modal-content upchar-modal-content">
            <form action="<?= base_url('admin1947/attendance/save_record'); ?>" method="POST" id="attendanceForm">
                <input type="hidden" name="punch_date" id="modal_punch_date" value="<?= $selected_date; ?>">
                
                <div class="upchar-modal-header">
                    <div>
                        <div style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.6px; color: #2dd4bf; font-weight: 800; margin-bottom: 2px;">
                            ADMIN GEOFENCE &amp; PUNCH OVERRIDE
                        </div>
                        <h4 class="modal-title" id="modalTitle" style="font-weight: 800; font-size: 19px; color: #ffffff; margin: 0;">
                            <i class="fa fa-sliders" style="color: #2dd4bf; margin-right: 6px;"></i> Edit Attendance Record
                        </h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 26px; line-height: 1;">&times;</button>
                </div>

                <!-- Modal Sub-Tabs for Clean Form Segmentation -->
                <div style="background: #f8fafc; padding: 12px 28px; border-bottom: 1px solid #e2e8f0; display: flex; gap: 8px;">
                    <button type="button" class="modal-tab-btn active" id="tabBtn_shift" onclick="switchModalTab('shift')">
                        <i class="fa fa-clock-o"></i> Shift &amp; Timings
                    </button>
                    <button type="button" class="modal-tab-btn" id="tabBtn_geo" onclick="switchModalTab('geo')">
                        <i class="fa fa-map-marker"></i> GPS &amp; Geofence
                    </button>
                    <button type="button" class="modal-tab-btn" id="tabBtn_notes" onclick="switchModalTab('notes')">
                        <i class="fa fa-pencil-square-o"></i> Administrative Notes
                    </button>
                </div>

                <div class="modal-body" style="padding: 26px 28px; background: #ffffff;">
                    
                    <!-- TAB 1: Shift & Timings -->
                    <div id="modalTab_shift">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Staff Member *</label>
                                    <select name="user_id" id="modal_user_id" class="form-control" required style="border-radius: 10px; height: 44px; font-weight: 600; border: 1px solid #cbd5e1;">
                                        <option value="">-- Select Staff Employee --</option>
                                        <?php if (!empty($all_staff)): foreach ($all_staff as $s): ?>
                                            <option value="<?= $s['id']; ?>">
                                                <?= html_escape($s['name']); ?> (<?= $s['staff_code']; ?> - <?= strtoupper($s['role']); ?>)
                                            </option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Attendance Status *</label>
                                    <select name="status" id="modal_status" class="form-control" required style="border-radius: 10px; height: 44px; font-weight: 700; border: 1px solid #cbd5e1;">
                                        <option value="present">🟢 Present (Full Day Shift)</option>
                                        <option value="late">🟡 Late Punch-In (Post Grace)</option>
                                        <option value="half_day">🟠 Half Day Shift</option>
                                        <option value="on_leave">🟣 On Approved Leave</option>
                                        <option value="absent">🔴 Absent (No Punch)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Check-In & Check-Out Timings with 1-Click Preset Shortcuts -->
                        <div class="row" style="margin-top: 6px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                        <label style="font-weight: 700; font-size: 13px; color: #1e293b; margin: 0;">Check-In Time</label>
                                        <div style="display: flex; gap: 4px;">
                                            <button type="button" class="modal-preset-chip" onclick="setModalTime('modal_check_in_time', '09:30')">09:30 AM</button>
                                            <button type="button" class="modal-preset-chip" onclick="setModalTimeNow('modal_check_in_time')">Now</button>
                                        </div>
                                    </div>
                                    <input type="time" name="check_in_time" id="modal_check_in_time" class="form-control" onchange="calculateHours()" style="border-radius: 10px; height: 44px; font-weight: 700; font-family: monospace; font-size: 14px; border: 1px solid #cbd5e1;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                        <label style="font-weight: 700; font-size: 13px; color: #1e293b; margin: 0;">Check-Out Time</label>
                                        <div style="display: flex; gap: 4px;">
                                            <button type="button" class="modal-preset-chip" onclick="setModalTime('modal_check_out_time', '18:30')">06:30 PM</button>
                                            <button type="button" class="modal-preset-chip" onclick="setModalTimeNow('modal_check_out_time')">Now</button>
                                        </div>
                                    </div>
                                    <input type="time" name="check_out_time" id="modal_check_out_time" class="form-control" onchange="calculateHours()" style="border-radius: 10px; height: 44px; font-weight: 700; font-family: monospace; font-size: 14px; border: 1px solid #cbd5e1;">
                                </div>
                            </div>
                        </div>

                        <!-- Logged Hours -->
                        <div class="form-group" style="margin-top: 6px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b; margin: 0;">Logged Working Hours</label>
                                <span style="font-size: 11px; color: #64748b;">Standard shift: 9.0 hours</span>
                            </div>
                            <div style="position: relative;">
                                <input type="number" step="0.1" name="working_hours" id="modal_working_hours" class="form-control" placeholder="e.g. 9.0" style="border-radius: 10px; height: 44px; font-weight: 800; font-size: 15px; border: 1px solid #cbd5e1; padding-right: 40px;">
                                <span style="position: absolute; right: 14px; top: 11px; font-weight: 700; color: #94a3b8;">hrs</span>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: GPS & Geofence -->
                    <div id="modalTab_geo" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                        <label style="font-weight: 700; font-size: 13px; color: #1e293b; margin: 0;">Geofence Radius from Central Hub (km)</label>
                                        <div style="display: flex; gap: 6px;">
                                            <button type="button" class="modal-preset-chip" onclick="document.getElementById('modal_distance_from_office_km').value = '0.15'">Hub (0.15 km)</button>
                                            <button type="button" class="modal-preset-chip" onclick="document.getElementById('modal_distance_from_office_km').value = '2.50'">Field (2.5 km)</button>
                                        </div>
                                    </div>
                                    <input type="number" step="0.01" name="distance_from_office_km" id="modal_distance_from_office_km" class="form-control" placeholder="e.g. 0.15" style="border-radius: 10px; height: 44px; font-weight: 700; border: 1px solid #cbd5e1;">
                                    <small style="color: #64748b; font-size: 11.5px; margin-top: 4px; display: block;">
                                        Values &le; 0.50 km will display as <span style="color: #166534; font-weight: 700;">Hub Verified</span>, while &gt; 0.50 km will display as <span style="color: #b45309; font-weight: 700;">Field Perimeter</span>.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Check-In GPS Latitude</label>
                                    <input type="number" step="0.000001" name="check_in_lat" id="modal_check_in_lat" class="form-control" value="26.846700" style="border-radius: 10px; height: 44px; font-family: monospace; font-size: 13px; border: 1px solid #cbd5e1;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Check-In GPS Longitude</label>
                                    <input type="number" step="0.000001" name="check_in_lng" id="modal_check_in_lng" class="form-control" value="80.946200" style="border-radius: 10px; height: 44px; font-family: monospace; font-size: 13px; border: 1px solid #cbd5e1;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: Administrative Notes -->
                    <div id="modalTab_notes" style="display: none;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Administrative Notes / Override Justification</label>
                            <textarea name="notes" id="modal_notes" class="form-control" rows="4" placeholder="e.g. Field visit verified by Ops Lead; manual punch approved after biometric camera sync..." style="border-radius: 10px; font-size: 13px; border: 1px solid #cbd5e1; padding: 12px;"></textarea>
                            <small style="color: #94a3b8; font-size: 11px; margin-top: 6px; display: block;">
                                Stored in audit logs for payroll reconciliation and compliance auditing.
                            </small>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 18px 28px; display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px; font-weight: 700; padding: 9px 20px;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border: none; border-radius: 10px; padding: 10px 26px; font-weight: 800; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);">
                        <i class="fa fa-save"></i> Save Attendance Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- REDESIGNED MODAL 2: BULK MARK ATTENDANCE POPUP           -->
<!-- ========================================================= -->
<div class="modal fade" id="bulkMarkModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 520px;">
        <div class="modal-content upchar-modal-content">
            <form action="<?= base_url('admin1947/attendance/bulk_mark'); ?>" method="POST">
                <input type="hidden" name="punch_date" value="<?= $selected_date; ?>">

                <div class="upchar-modal-header">
                    <div>
                        <div style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.6px; color: #2dd4bf; font-weight: 800; margin-bottom: 2px;">
                            COMPANY-WIDE SHIFT OVERRIDE
                        </div>
                        <h4 class="modal-title" style="font-weight: 800; font-size: 18px; color: #ffffff; margin: 0;">
                            <i class="fa fa-check-square-o" style="color: #2dd4bf; margin-right: 6px;"></i> Bulk Mark Attendance
                        </h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 26px;">&times;</button>
                </div>

                <div class="modal-body" style="padding: 26px; background: #ffffff;">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa fa-users" style="font-size: 24px; color: #00a896;"></i>
                        <div>
                            <div style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                                <?= $totalScheduled; ?> Active Staff Employees
                            </div>
                            <small style="color: #64748b;">Target Date: <?= date('l, d M Y', strtotime($selected_date)); ?></small>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-weight: 700; font-size: 13px; color: #1e293b; margin-bottom: 8px;">Select Bulk Action *</label>
                        <select name="bulk_status" class="form-control" required style="border-radius: 10px; height: 46px; font-weight: 700; font-size: 13.5px; border: 1px solid #cbd5e1;">
                            <option value="present">🟢 Mark All Present (09:30 AM - 06:30 PM &bull; 9.0h)</option>
                            <option value="late">🟡 Mark All Late (10:15 AM - 06:30 PM &bull; 8.25h)</option>
                            <option value="absent">🔴 Mark All Absent (Clear All Punches for Selected Date)</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px; font-weight: 700;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border: none; border-radius: 10px; padding: 10px 24px; font-weight: 800;">
                        Confirm Bulk Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- REDESIGNED MODAL 3: LIVE GPS GEOFENCE MAP RADAR POPUP     -->
<!-- ========================================================= -->
<div class="modal fade" id="geofenceMapModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 820px;">
        <div class="modal-content upchar-modal-content">
            <div class="upchar-modal-header">
                <div>
                    <div style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.6px; color: #2dd4bf; font-weight: 800; margin-bottom: 2px;">
                        SATELLITE TELEMETRY RADAR
                    </div>
                    <h4 class="modal-title" style="font-weight: 800; font-size: 18px; color: #ffffff; margin: 0;">
                        <i class="fa fa-crosshairs" style="color: #2dd4bf; margin-right: 6px;"></i> GPS Geofence Radar: <span id="mapModalStaffName" style="color: #2dd4bf;">Staff Member</span>
                    </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 26px;">&times;</button>
            </div>

            <!-- Radar Meta Ribbon -->
            <div style="background: #0f172a; color: #94a3b8; padding: 8px 24px; font-size: 12px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <span id="mapModalMeta"><i class="fa fa-info-circle"></i> Coordinates &amp; Distance</span>
                <span style="color: #10b981; font-weight: 700;"><span class="live-pulse-dot" style="width: 6px; height: 6px;"></span> Geofence Active (500m Hub Radius)</span>
            </div>

            <div class="modal-body" style="padding: 0;">
                <div id="leafletMapContainer"></div>
            </div>

            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; color: #64748b;">
                    <i class="fa fa-shield" style="color: #10b981;"></i> Green circular boundary marks authorized Lucknow Primary Hub perimeter.
                </span>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700;">Close Radar</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- REDESIGNED MODAL 4: BIOMETRIC SELFIE VERIFICATION POPUP   -->
<!-- ========================================================= -->
<div class="modal fade" id="selfieViewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 460px;">
        <div class="modal-content upchar-modal-content">
            <div class="upchar-modal-header">
                <div>
                    <div style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.6px; color: #2dd4bf; font-weight: 800; margin-bottom: 2px;">
                        WEBRTC FACIAL RECOGNITION
                    </div>
                    <h4 class="modal-title" style="font-weight: 800; font-size: 17px; color: #ffffff; margin: 0;">
                        <i class="fa fa-camera" style="color: #2dd4bf; margin-right: 6px;"></i> Biometric Punch Photo
                    </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 26px;">&times;</button>
            </div>
            
            <div class="modal-body" style="padding: 24px; text-align: center; background: #0f172a;">
                <div style="position: relative; display: inline-block;">
                    <img id="selfieModalImg" src="" alt="Punch Selfie" style="max-width: 100%; border-radius: 14px; box-shadow: 0 12px 32px rgba(0,0,0,0.5); border: 2px solid #2dd4bf;">
                    <div style="position: absolute; bottom: 12px; right: 12px; background: rgba(15,23,42,0.85); backdrop-filter: blur(6px); color: #2dd4bf; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid rgba(45,212,191,0.4);">
                        <i class="fa fa-check-shield"></i> VERIFIED
                    </div>
                </div>
                <div style="margin-top: 16px; color: #ffffff;">
                    <strong id="selfieModalName" style="font-size: 16px; display: block;">Staff Member</strong>
                    <small id="selfieModalTime" style="color: #94a3b8; font-size: 12.5px;">Biometric punch verified</small>
                </div>
            </div>

            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 20px;">
                <button type="button" class="btn btn-default btn-block" data-dismiss="modal" style="border-radius: 10px; font-weight: 700;">Dismiss Photo</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- FORM: Hidden Delete Record                -->
<!-- ========================================== -->
<form id="deleteAttendanceForm" action="<?= base_url('admin1947/attendance/delete_record'); ?>" method="POST" style="display: none;">
    <input type="hidden" name="attendance_id" id="delete_attendance_id" value="">
    <input type="hidden" name="punch_date" value="<?= $selected_date; ?>">
</form>

<script>
// Filter and Pagination state variables
var activeRole = 'all';
var activeStatus = 'all';
var leafletMapInstance = null;
var currentPage = 1;
var pageSize = 10;
var filteredRows = [];

$(document).ready(function() {
    // Role Tab Click Handlers
    $('.role-filter-tab').on('click', function() {
        $('.role-filter-tab').removeClass('active');
        $(this).addClass('active');
        activeRole = $(this).data('role');
        filterRosterTable();
    });

    // Status Chip Click Handlers
    $('.status-filter-chip').on('click', function() {
        $('.status-filter-chip').removeClass('active');
        $(this).addClass('active');
        activeStatus = $(this).data('status');
        filterRosterTable();
    });

    // Initialize filter and pagination on page load
    filterRosterTable();
});

function clearSearchFilter() {
    $('#rosterSearchInput').val('');
    $('#clearSearchBtn').hide();
    filterRosterTable();
}

function filterRosterTable() {
    var rawSearch = document.getElementById('rosterSearchInput').value;
    var search = rawSearch.toLowerCase().trim();

    // Toggle clear button
    var clearBtn = document.getElementById('clearSearchBtn');
    if (clearBtn) {
        clearBtn.style.display = search ? 'block' : 'none';
    }

    var cleanSearch = search.replace(/\s*\(.*?\)\s*/g, '').trim();
    var geofence = document.getElementById('geofenceFilter').value;
    var allRows = Array.from(document.querySelectorAll('.roster-row'));

    filteredRows = allRows.filter(function(row) {
        var name = (row.getAttribute('data-name') || '').toLowerCase();
        var code = (row.getAttribute('data-code') || '').toLowerCase();
        var phone = (row.getAttribute('data-phone') || '').toLowerCase();
        var role = row.getAttribute('data-role') || '';
        var status = row.getAttribute('data-status') || '';
        var distance = parseFloat(row.getAttribute('data-distance')) || 0;
        var hasCheckIn = row.getAttribute('data-has-checkin') === '1';

        var matchSearch = !search || 
                          name.includes(search) || 
                          name.includes(cleanSearch) || 
                          code.includes(search) || 
                          code.includes(cleanSearch) || 
                          phone.includes(search);

        var matchRole = (activeRole === 'all') || 
                        (role === activeRole) || 
                        (activeRole === 'hr' && (role === 'hr' || role === 'super_admin' || role === 'admin')) ||
                        (activeRole === 'office_staff' && (role === 'office_staff' || role === 'super_admin'));

        var matchStatus = (activeStatus === 'all') || (status === activeStatus);

        var matchGeofence = true;
        if (geofence === 'hub') {
            matchGeofence = hasCheckIn && distance <= 0.5;
        } else if (geofence === 'perimeter') {
            matchGeofence = hasCheckIn && distance > 0.5;
        } else if (geofence === 'unrecorded') {
            matchGeofence = !hasCheckIn;
        }

        return matchSearch && matchRole && matchStatus && matchGeofence;
    });

    currentPage = 1;
    renderPagination();
}

function renderPagination() {
    var total = filteredRows.length;
    var allRows = document.querySelectorAll('.roster-row');
    allRows.forEach(function(r) { r.style.display = 'none'; });

    var totalPages = (pageSize === 'all') ? 1 : Math.ceil(total / pageSize);
    if (totalPages < 1) totalPages = 1;
    if (currentPage > totalPages) currentPage = totalPages;

    var startIdx = (pageSize === 'all') ? 0 : (currentPage - 1) * pageSize;
    var endIdx   = (pageSize === 'all') ? total : Math.min(startIdx + pageSize, total);

    for (var i = startIdx; i < endIdx; i++) {
        if (filteredRows[i]) {
            filteredRows[i].style.display = '';
        }
    }

    // Update Counter Labels
    var countText = (total === 0) ? 'Showing 0 employees' : 'Showing ' + (startIdx + 1) + '-' + endIdx + ' of ' + total + ' employees';
    $('#paginationInfoText').text(countText);
    $('#filteredStaffCount').html('Showing <strong>' + total + '</strong> employees');

    // Build Page Navigation Buttons
    var html = '';
    html += '<button type="button" class="page-nav-btn ' + (currentPage === 1 ? 'disabled' : '') + '" onclick="goToPage(1)" title="First Page"><i class="fa fa-angle-double-left"></i></button>';
    html += '<button type="button" class="page-nav-btn ' + (currentPage === 1 ? 'disabled' : '') + '" onclick="goToPage(' + (currentPage - 1) + ')" title="Previous Page"><i class="fa fa-angle-left"></i> Prev</button>';

    var startP = Math.max(1, currentPage - 2);
    var endP = Math.min(totalPages, startP + 4);
    if (endP - startP < 4) {
        startP = Math.max(1, endP - 4);
    }

    for (var p = startP; p <= endP; p++) {
        html += '<button type="button" class="page-num-btn ' + (p === currentPage ? 'active' : '') + '" onclick="goToPage(' + p + ')">' + p + '</button>';
    }

    html += '<button type="button" class="page-nav-btn ' + (currentPage === totalPages ? 'disabled' : '') + '" onclick="goToPage(' + (currentPage + 1) + ')" title="Next Page">Next <i class="fa fa-angle-right"></i></button>';
    html += '<button type="button" class="page-nav-btn ' + (currentPage === totalPages ? 'disabled' : '') + '" onclick="goToPage(' + totalPages + ')" title="Last Page"><i class="fa fa-angle-double-right"></i></button>';

    $('#paginationButtons').html(html);
}

function goToPage(page) {
    var totalPages = (pageSize === 'all') ? 1 : Math.ceil(filteredRows.length / pageSize);
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderPagination();
}

function changePageSize(newSize) {
    pageSize = (newSize === 'all') ? 'all' : parseInt(newSize, 10);
    currentPage = 1;
    renderPagination();
}

function switchModalTab(tabId) {
    $('.modal-tab-btn').removeClass('active');
    $('#tabBtn_' + tabId).addClass('active');

    $('#modalTab_shift').hide();
    $('#modalTab_geo').hide();
    $('#modalTab_notes').hide();

    $('#modalTab_' + tabId).show();
}

function setModalTime(inputId, timeStr) {
    document.getElementById(inputId).value = timeStr;
    calculateHours();
}

function setModalTimeNow(inputId) {
    var now = new Date();
    var h = String(now.getHours()).padStart(2, '0');
    var m = String(now.getMinutes()).padStart(2, '0');
    document.getElementById(inputId).value = h + ':' + m;
    calculateHours();
}

function openCreateModal() {
    switchModalTab('shift');
    document.getElementById('modalTitle').innerHTML = '<i class="fa fa-plus-circle" style="color: #2dd4bf; margin-right: 6px;"></i> Create Attendance Record';
    document.getElementById('attendanceForm').reset();
    document.getElementById('modal_punch_date').value = '<?= $selected_date; ?>';
    document.getElementById('modal_status').value = 'present';
    document.getElementById('modal_check_in_time').value = '09:30';
    document.getElementById('modal_check_out_time').value = '18:30';
    document.getElementById('modal_working_hours').value = '9.0';
    document.getElementById('modal_distance_from_office_km').value = '0.15';
    $('#attendanceRecordModal').modal('show');
}

function openCreateModalForStaff(staffId) {
    openCreateModal();
    document.getElementById('modal_user_id').value = staffId;
}

function openEditModal(record) {
    switchModalTab('shift');
    document.getElementById('modalTitle').innerHTML = '<i class="fa fa-sliders" style="color: #2dd4bf; margin-right: 6px;"></i> Edit Record: ' + record.name;
    document.getElementById('modal_user_id').value = record.user_id;
    document.getElementById('modal_punch_date').value = record.punch_date || '<?= $selected_date; ?>';
    document.getElementById('modal_status').value = record.attendance_status || record.status || 'present';
    
    // Format check-in time HH:mm
    if (record.check_in_time) {
        var inTime = record.check_in_time.split(' ')[1] || record.check_in_time;
        document.getElementById('modal_check_in_time').value = inTime.substring(0, 5);
    } else {
        document.getElementById('modal_check_in_time').value = '';
    }

    // Format check-out time HH:mm
    if (record.check_out_time) {
        var outTime = record.check_out_time.split(' ')[1] || record.check_out_time;
        document.getElementById('modal_check_out_time').value = outTime.substring(0, 5);
    } else {
        document.getElementById('modal_check_out_time').value = '';
    }

    document.getElementById('modal_working_hours').value = record.working_hours || '';
    document.getElementById('modal_distance_from_office_km').value = record.distance_from_office_km || '0.15';
    document.getElementById('modal_check_in_lat').value = record.check_in_lat || '26.846700';
    document.getElementById('modal_check_in_lng').value = record.check_in_lng || '80.946200';
    document.getElementById('modal_notes').value = record.notes || '';

    $('#attendanceRecordModal').modal('show');
}

function calculateHours() {
    var inVal = document.getElementById('modal_check_in_time').value;
    var outVal = document.getElementById('modal_check_out_time').value;
    if (inVal && outVal) {
        var inParts = inVal.split(':');
        var outParts = outVal.split(':');
        var inMins = parseInt(inParts[0], 10) * 60 + parseInt(inParts[1], 10);
        var outMins = parseInt(outParts[0], 10) * 60 + parseInt(outParts[1], 10);
        if (outMins > inMins) {
            var diffHours = ((outMins - inMins) / 60).toFixed(1);
            document.getElementById('modal_working_hours').value = diffHours;
        }
    }
}

function quickClockIn(userId, timeChoice) {
    var inTime = (timeChoice === 'now') ? new Date().toTimeString().split(' ')[0] : '09:30:00';
    $.ajax({
        url: '<?= base_url("admin1947/attendance/save_record"); ?>',
        type: 'POST',
        data: {
            user_id: userId,
            punch_date: '<?= $selected_date; ?>',
            status: 'present',
            check_in_time: inTime,
            distance_from_office_km: 0.15,
            notes: 'Clocked in via Admin 1-Click Action'
        },
        dataType: 'json',
        success: function(resp) {
            showRosterToast('Staff clocked in at ' + inTime.substring(0, 5));
            setTimeout(function() { window.location.reload(); }, 600);
        },
        error: function() { window.location.reload(); }
    });
}

function quickClockOut(userId, timeChoice) {
    var outTime = (timeChoice === 'now') ? new Date().toTimeString().split(' ')[0] : '18:30:00';
    $.ajax({
        url: '<?= base_url("admin1947/attendance/save_record"); ?>',
        type: 'POST',
        data: {
            user_id: userId,
            punch_date: '<?= $selected_date; ?>',
            check_out_time: outTime,
            notes: 'Clocked out via Admin 1-Click Action'
        },
        dataType: 'json',
        success: function(resp) {
            showRosterToast('Staff clocked out at ' + outTime.substring(0, 5));
            setTimeout(function() { window.location.reload(); }, 600);
        },
        error: function() { window.location.reload(); }
    });
}

function quickSaveStatus(userId, status) {
    var inTime  = (status === 'present' || status === 'late') ? '09:30:00' : (status === 'half_day' ? '09:30:00' : null);
    var outTime = (status === 'present' || status === 'late') ? '18:30:00' : (status === 'half_day' ? '14:00:00' : null);
    var hours   = (status === 'present' || status === 'late') ? 9.0 : (status === 'half_day' ? 4.5 : 0.0);

    // Update select colors immediately on client
    var sel = document.getElementById('status_select_' + userId);
    if (sel) {
        if (status === 'present') { sel.style.background = '#dcfce7'; sel.style.color = '#166534'; }
        else if (status === 'late') { sel.style.background = '#fef3c7'; sel.style.color = '#92400e'; }
        else if (status === 'half_day') { sel.style.background = '#ffedd5'; sel.style.color = '#9a3412'; }
        else if (status === 'on_leave') { sel.style.background = '#f3e8ff'; sel.style.color = '#6b21a8'; }
        else { sel.style.background = '#fee2e2'; sel.style.color = '#991b1b'; }
    }

    $.ajax({
        url: '<?= base_url("admin1947/attendance/save_record"); ?>',
        type: 'POST',
        data: {
            user_id: userId,
            punch_date: '<?= $selected_date; ?>',
            status: status,
            check_in_time: inTime,
            check_out_time: outTime,
            working_hours: hours,
            notes: 'Quick status update via Table Dropdown'
        },
        dataType: 'json',
        success: function(resp) {
            showRosterToast('Status updated to ' + status.toUpperCase());
            setTimeout(function() {
                window.location.reload();
            }, 600);
        },
        error: function() {
            window.location.reload();
        }
    });
}

function confirmDeleteRecord(attendanceId, name) {
    if (confirm('Are you sure you want to clear attendance punch record for ' + name + '?')) {
        document.getElementById('delete_attendance_id').value = attendanceId;
        document.getElementById('deleteAttendanceForm').submit();
    }
}

function showRosterToast(msg) {
    var toast = document.getElementById('rosterToast');
    document.getElementById('rosterToastMsg').innerText = msg;
    toast.style.display = 'flex';
    setTimeout(function() {
        toast.style.display = 'none';
    }, 3000);
}

function openMapModal(lat, lng, name, dist, time) {
    document.getElementById('mapModalStaffName').innerText = name;
    document.getElementById('mapModalMeta').innerHTML = '<i class="fa fa-map-marker"></i> Punched at ' + time + ' &bull; ' + dist + ' from Hub &bull; ' + lat.toFixed(4) + ', ' + lng.toFixed(4);
    $('#geofenceMapModal').modal('show');

    setTimeout(function() {
        if (leafletMapInstance) {
            leafletMapInstance.remove();
        }
        leafletMapInstance = L.map('leafletMapContainer').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(leafletMapInstance);

        // Office Central Hub Marker (Lucknow)
        var hubMarker = L.marker([26.8467, 80.9462]).addTo(leafletMapInstance)
            .bindPopup('<b>Upchar Central Hub</b><br>Primary Office Geofence').openPopup();

        // 500m Authorized Radius Circle
        L.circle([26.8467, 80.9462], {
            color: '#10b981',
            fillColor: '#a7f3d0',
            fillOpacity: 0.25,
            radius: 500
        }).addTo(leafletMapInstance);

        // Staff Check-in Marker
        if (lat !== 26.8467 || lng !== 80.9462) {
            L.marker([lat, lng]).addTo(leafletMapInstance)
                .bindPopup('<b>' + name + '</b><br>Punch In: ' + time + ' (' + dist + ')');
        }
    }, 300);
}

function openSelfieModal(imgSrc, name, time) {
    var finalSrc = imgSrc || '';
    if (finalSrc.indexOf('[removed]') === 0) {
        finalSrc = 'data:image/jpeg;base64,' + finalSrc.substring(9);
    } else if (finalSrc.indexOf('uploads/') === 0) {
        finalSrc = '<?= base_url(); ?>' + finalSrc;
    }
    document.getElementById('selfieModalImg').src = finalSrc;
    document.getElementById('selfieModalName').innerText = name;
    document.getElementById('selfieModalTime').innerText = 'Biometric WebRTC Punch Verified at ' + time;
    $('#selfieViewModal').modal('show');
}

function exportRosterCSV() {
    var csv = [];
    var rows = document.querySelectorAll("#rosterTable tr");
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length - 1; j++) {
            var text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
            row.push('"' + text + '"');
        }
        csv.push(row.join(","));
    }
    var csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
    var downloadLink = document.createElement("a");
    downloadLink.download = "Attendance_Roster_<?= $selected_date; ?>.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}
</script>
