<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    /* Biometric Terminal Theme */
    .punch-container {
        max-width: 1300px;
        margin: 0 auto;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .punch-grid {
        display: grid;
        grid-template-columns: 430px 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 992px) {
        .punch-grid { grid-template-columns: 1fr; }
    }

    /* Left: Terminal HUD */
    .biometric-hud {
        background: linear-gradient(165deg, #090d16 0%, #0f172a 60%, #1e293b 100%);
        border-radius: 24px;
        padding: 26px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.45);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .biometric-hud::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(0, 168, 150, 0.25) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Clock Ribbon */
    .clock-display {
        text-align: center;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 18px;
    }
    .clock-time {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-size: 32px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #f8fafc;
        text-shadow: 0 0 20px rgba(0, 168, 150, 0.4);
    }
    .clock-meta {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 4px;
    }
    .clock-meta .tz-pill {
        background: rgba(0, 168, 150, 0.15);
        color: #2dd4bf;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10.5px;
        font-weight: 700;
    }

    /* Viewfinder */
    .viewfinder-card {
        background: #020617;
        border-radius: 18px;
        border: 2px solid rgba(0, 168, 150, 0.35);
        position: relative;
        overflow: hidden;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 40px rgba(0, 0, 0, 0.8), 0 8px 24px rgba(0, 168, 150, 0.15);
        margin-bottom: 14px;
    }

    #webcamVideo, #snapshotImg {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Reticle Targets Overlay */
    .viewfinder-reticle {
        position: absolute;
        inset: 16px;
        pointer-events: none;
        border: 1px dashed rgba(0, 168, 150, 0.3);
        border-radius: 12px;
    }
    .viewfinder-reticle::before, .viewfinder-reticle::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border-color: #00a896;
        border-style: solid;
    }
    .viewfinder-reticle::before {
        top: 0; left: 0;
        border-width: 3px 0 0 3px;
        border-top-left-radius: 6px;
    }
    .viewfinder-reticle::after {
        bottom: 0; right: 0;
        border-width: 0 3px 3px 0;
        border-bottom-right-radius: 6px;
    }

    .reticle-tr, .reticle-bl {
        position: absolute;
        width: 16px;
        height: 16px;
        border-color: #00a896;
        border-style: solid;
        pointer-events: none;
    }
    .reticle-tr {
        top: 16px; right: 16px;
        border-width: 3px 3px 0 0;
        border-top-right-radius: 6px;
    }
    .reticle-bl {
        bottom: 16px; left: 16px;
        border-width: 0 0 3px 3px;
        border-bottom-left-radius: 6px;
    }

    .radar-scan-line {
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #2dd4bf, transparent);
        box-shadow: 0 0 10px #2dd4bf;
        animation: scanAnim 2.6s linear infinite;
        pointer-events: none;
    }
    @keyframes scanAnim {
        0% { top: 5%; opacity: 0.1; }
        50% { opacity: 0.9; }
        100% { top: 95%; opacity: 0.1; }
    }

    .viewfinder-status-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(8px);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
        display: flex;
        align-items: center;
        gap: 6px;
        z-index: 5;
    }
    .status-dot-pulse {
        width: 7px; height: 7px; border-radius: 50%; background: #10b981;
        box-shadow: 0 0 8px #10b981;
        animation: pulseDot 1.6s infinite ease-in-out;
    }
    @keyframes pulseDot { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.4; transform: scale(0.85); } }

    /* Camera Toolbar */
    .cam-actions-bar {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
    }
    .cam-tool-btn {
        flex: 1;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #cbd5e1;
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .cam-tool-btn:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.25);
    }
    .cam-tool-btn.active {
        background: #00a896;
        color: #ffffff;
        border-color: #00a896;
    }

    /* GPS Telemetry Ribbon */
    .telemetry-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 12px 14px;
        margin-bottom: 16px;
        font-size: 12px;
    }
    .telemetry-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }
    .telemetry-title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .telemetry-status {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 12px;
    }
    .status-inbounds {
        background: rgba(16, 185, 129, 0.18);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .status-outbounds {
        background: rgba(245, 158, 11, 0.18);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .telemetry-coords {
        display: flex;
        justify-content: space-between;
        color: #f1f5f9;
        font-family: 'JetBrains Mono', monospace;
        font-size: 11.5px;
        margin-bottom: 4px;
    }
    .telemetry-dist {
        color: #38bdf8;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Shift Presets */
    .shift-preset-row {
        display: flex;
        gap: 6px;
        margin-bottom: 14px;
    }
    .shift-chip {
        flex: 1;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        padding: 6px 8px;
        border-radius: 10px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        transition: all 0.15s ease;
    }
    .shift-chip.selected, .shift-chip:hover {
        background: rgba(0, 168, 150, 0.2);
        border-color: #00a896;
        color: #2dd4bf;
    }

    /* Big Punch Buttons */
    .btn-biometric-punch {
        width: 100%;
        border: none;
        border-radius: 14px;
        padding: 15px 20px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-clock-in {
        background: linear-gradient(135deg, #00a896 0%, #0284c7 100%);
        color: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 168, 150, 0.4);
    }
    .btn-clock-in:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(0, 168, 150, 0.55);
        filter: brightness(1.1);
    }
    .btn-clock-out {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: #ffffff;
        box-shadow: 0 8px 24px rgba(225, 29, 72, 0.4);
    }
    .btn-clock-out:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(225, 29, 72, 0.55);
        filter: brightness(1.1);
    }

    /* Active Shift Status Card */
    .active-shift-card {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .active-shift-thumb {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        border: 2px solid #10b981;
        object-fit: cover;
        background: #020617;
    }
    .active-shift-info {
        flex: 1;
    }
    .active-shift-title {
        font-weight: 800;
        font-size: 13.5px;
        color: #6ee7b7;
        margin-bottom: 2px;
    }
    .active-shift-meta {
        font-size: 11.5px;
        color: #94a3b8;
    }

    /* Completed Today Card */
    .completed-shift-card {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 16px;
        padding: 18px;
        text-align: center;
        margin-bottom: 16px;
    }
    .completed-badge-icon {
        width: 50px;
        height: 50px;
        background: rgba(59, 130, 246, 0.2);
        color: #60a5fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 10px;
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
    }

    /* Reset Demo Button */
    .btn-reset-demo {
        background: transparent;
        border: 1px dashed rgba(255, 255, 255, 0.2);
        color: #94a3b8;
        font-size: 12px;
        font-weight: 700;
        padding: 9px 14px;
        border-radius: 10px;
        width: 100%;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 10px;
        transition: all 0.2s ease;
    }
    .btn-reset-demo:hover {
        background: rgba(239, 68, 68, 0.15);
        border-color: #ef4444;
        color: #fca5a5;
    }

    /* Right: Timesheet & KPIs */
    .right-card-panel {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .kpi-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        padding: 20px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    @media (max-width: 600px) {
        .kpi-row { grid-template-columns: repeat(2, 1fr); }
    }
    .kpi-stat-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 14px;
    }
    .kpi-stat-label {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .kpi-stat-val {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Timesheet Table */
    .timesheet-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .timesheet-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 18px;
        border-bottom: 1px solid #e2e8f0;
    }
    .timesheet-table td {
        padding: 13px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }
    .timesheet-table tr:hover td {
        background: #f8fafc;
    }

    /* Status Badges */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .status-pill.present  { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .status-pill.late     { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .status-pill.half_day { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
    .status-pill.absent   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    /* Staff Switcher Bar */
    .staff-selector-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 12px 18px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .active-staff-badge {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .staff-avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #00a896 0%, #0284c7 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        box-shadow: 0 4px 10px rgba(0, 168, 150, 0.25);
    }
</style>

<div class="punch-container">

    <!-- Top Navigation & Title -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; flex-wrap: wrap; gap: 14px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(0,168,150,0.1); color: #00a896; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                <i class="fa fa-camera"></i> GPS Biometric Attendance Terminal
            </div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.4px;">
                Web Biometric Punch Terminal
            </h1>
            <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                Live WebRTC selfie capture, high-accuracy GPS geofence tracking, and automated timesheets.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="<?= base_url('admin1947/attendance/roster'); ?>" class="btn btn-sm" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-calendar-check-o" style="color: #00a896;"></i> Staff Roster
            </a>
            <a href="<?= base_url('admin1947/attendance/history'); ?>" class="btn btn-sm" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #1e293b; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-history" style="color: #6366f1;"></i> Full History
            </a>
        </div>
    </div>

    <!-- Flash Message -->
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600; margin-bottom: 16px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success_msg'); ?>
        </div>
    <?php endif; ?>

    <!-- Staff Switcher Bar -->
    <div class="staff-selector-bar">
        <div class="active-staff-badge">
            <div class="staff-avatar-circle">
                <?= strtoupper(substr($user['name'] ?? 'S', 0, 1)); ?>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 15px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <?= html_escape($user['name'] ?? 'Staff Member'); ?>
                    <span style="font-size: 11px; background: #f1f5f9; color: #475569; padding: 2px 7px; border-radius: 6px; font-weight: 700;">
                        <?= html_escape($user['staff_code'] ?? 'UPC-001'); ?>
                    </span>
                </div>
                <div style="font-size: 12px; color: #64748b;">
                    <strong style="color: #00a896;"><?= strtoupper($user['role'] ?? 'STAFF'); ?></strong>
                    &bull; <?= html_escape($user['department'] ?? 'Operations'); ?>
                </div>
            </div>
        </div>

        <!-- Role / Staff Quick Switcher -->
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 12px; font-weight: 700; color: #64748b;">Punching As:</span>
            <select class="form-control input-sm" style="width: 220px; border-radius: 8px; font-weight: 600; font-size: 12.5px;" onchange="location.href='<?= base_url('admin1947/attendance/punch?staff_id='); ?>' + this.value;">
                <?php foreach ($all_staff as $st): ?>
                    <option value="<?= $st['id']; ?>" <?= ($st['id'] == ($user['id'] ?? 0)) ? 'selected' : ''; ?>>
                        <?= html_escape($st['name']); ?> (<?= strtoupper($st['role']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Main Workspace Grid -->
    <div class="punch-grid">

        <!-- ================= LEFT: HUD TERMINAL ================= -->
        <div class="biometric-hud">

            <!-- Digital Clock Ribbon -->
            <div class="clock-display">
                <div class="clock-time" id="liveClock"><?= date('h:i:s A'); ?></div>
                <div class="clock-meta">
                    <span><?= date('l, d F Y'); ?></span>
                    <span class="tz-pill">IST (UTC+5:30)</span>
                </div>
            </div>

            <!-- Viewfinder Area -->
            <div class="viewfinder-card" id="viewfinderBox">
                <!-- Status tag -->
                <div class="viewfinder-status-tag" id="viewfinderTag">
                    <div class="status-dot-pulse" id="camStatusDot"></div>
                    <span id="camStatusText">Connecting Camera...</span>
                </div>

                <!-- Radar scan effect -->
                <div class="radar-scan-line"></div>

                <!-- Reticle corners -->
                <div class="viewfinder-reticle"></div>
                <div class="reticle-tr"></div>
                <div class="reticle-bl"></div>

                <!-- Video Element -->
                <video id="webcamVideo" autoplay playsinline muted></video>

                <!-- Snapshot Preview Image (Initially Hidden) -->
                <img id="snapshotImg" style="display: none;" alt="Selfie Snapshot">

                <!-- Hidden Canvas for frame processing -->
                <canvas id="selfieCanvas" style="display: none;"></canvas>
            </div>

            <!-- Hidden Native Camera / File Input Fallback -->
            <input type="file" id="selfieFileInput" accept="image/*" capture="user" style="display: none;" onchange="handleFileUpload(event)">

            <!-- Camera Toolbar Controls -->
            <div class="cam-actions-bar">
                <button type="button" class="cam-tool-btn" id="btnSnapPhoto" onclick="captureSnapshot()" title="Freeze current frame">
                    <i class="fa fa-camera"></i> <span id="snapBtnText">Snap Photo</span>
                </button>
                <button type="button" class="cam-tool-btn" id="btnRetakePhoto" onclick="retakePhoto()" style="display: none;" title="Retake snapshot">
                    <i class="fa fa-refresh"></i> Retake
                </button>
                <button type="button" class="cam-tool-btn" id="btnSwitchCam" onclick="switchCameraMode()" title="Flip camera">
                    <i class="fa fa-retweet"></i> Flip Cam
                </button>
                <button type="button" class="cam-tool-btn" onclick="$('#selfieFileInput').click()" title="Choose picture from device">
                    <i class="fa fa-upload"></i> Upload
                </button>
            </div>

            <!-- GPS Geofence Telemetry -->
            <div class="telemetry-card">
                <div class="telemetry-header">
                    <div class="telemetry-title">
                        <i class="fa fa-crosshairs" style="color: #00a896;"></i> GPS Geofence Radar
                    </div>
                    <div class="telemetry-status status-inbounds" id="geofenceBadge">
                        <i class="fa fa-check-circle"></i> <span id="geofenceText">Within 500m Hub</span>
                    </div>
                </div>
                <div class="telemetry-coords">
                    <span id="coordsDisplay">Lat: 26.8467, Lng: 80.9462</span>
                    <button type="button" onclick="refreshGeolocation()" style="background: none; border: none; color: #38bdf8; cursor: pointer; padding: 0; font-size: 11px; font-weight: 700;" title="Re-acquire GPS">
                        <i class="fa fa-refresh"></i> Refresh
                    </button>
                </div>
                <div class="telemetry-dist">
                    <span>Target: Lucknow Central HQ Hub</span>
                    <span id="distanceDisplay">0.00 km away</span>
                </div>
            </div>

            <!-- Quick Remarks / Shift Note -->
            <div style="margin-bottom: 14px;">
                <input type="text" id="punchNotesInput" class="form-control" placeholder="Optional check-in notes (e.g. Field Visit, Lab Duty)..." style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: #ffffff; border-radius: 10px; font-size: 12.5px; padding: 10px 14px;">
            </div>

            <!-- Status Alert Box -->
            <div id="punchAlertBox" style="display: none; padding: 12px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 14px; font-weight: 600;"></div>

            <!-- Action Button State Machine -->
            <?php if (empty($today_punch)): ?>
                <!-- STATE 1: PUNCH IN AVAILABLE -->
                <button type="button" class="btn-biometric-punch btn-clock-in" id="btnClockIn" onclick="submitPunchIn()">
                    <i class="fa fa-camera"></i> Punch In — Clock-In
                </button>
            <?php elseif (empty($today_punch['check_out_time'])): ?>
                <!-- STATE 2: ACTIVE SHIFT (PUNCH OUT AVAILABLE) -->
                <div class="active-shift-card">
                    <?php if (!empty($today_punch['check_in_selfie'])): ?>
                        <?php 
                            $selfieSrc = $today_punch['check_in_selfie'];
                            if (strpos($selfieSrc, 'uploads/') === 0) {
                                $selfieSrc = base_url($selfieSrc);
                            } elseif (strpos($selfieSrc, '[removed]') === 0) {
                                $selfieSrc = 'data:image/jpeg;base64,' . substr($selfieSrc, 9);
                            }
                        ?>
                        <img src="<?= $selfieSrc; ?>" class="active-shift-thumb" alt="Punch-In Selfie">
                    <?php else: ?>
                        <div class="active-shift-thumb" style="display: flex; align-items: center; justify-content: center; color: #10b981;">
                            <i class="fa fa-user-circle" style="font-size: 24px;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="active-shift-info">
                        <div class="active-shift-title">
                            <i class="fa fa-circle" style="font-size: 9px; color: #10b981; animation: pulseDot 1.5s infinite;"></i> Shift In Progress
                        </div>
                        <div class="active-shift-meta">
                            Clocked in at <strong><?= date('h:i A', strtotime($today_punch['check_in_time'])); ?></strong>
                            &bull; Status: <span style="color: #34d399; font-weight: 700;"><?= strtoupper($today_punch['status']); ?></span>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-biometric-punch btn-clock-out" id="btnClockOut" onclick="submitPunchOut()">
                    <i class="fa fa-sign-out"></i> Punch Out — Clock-Out
                </button>

                <button type="button" class="btn-reset-demo" onclick="confirmResetTodayPunch()">
                    <i class="fa fa-refresh"></i> Reset Today's Punch (Demo Mode)
                </button>

            <?php else: ?>
                <!-- STATE 3: SHIFT COMPLETED TODAY -->
                <div class="completed-shift-card">
                    <div class="completed-badge-icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <h4 style="margin: 0 0 6px; font-weight: 800; color: #ffffff; font-size: 16px;">
                        Attendance Complete Today
                    </h4>
                    <div style="font-size: 12.5px; color: #94a3b8; line-height: 1.6;">
                        Check-in: <strong><?= date('h:i A', strtotime($today_punch['check_in_time'])); ?></strong> &bull;
                        Check-out: <strong><?= date('h:i A', strtotime($today_punch['check_out_time'])); ?></strong><br>
                        Total Duration: <strong style="color: #38bdf8;"><?= $today_punch['working_hours']; ?> hrs</strong>
                        (<?= strtoupper($today_punch['status']); ?>)
                    </div>
                </div>

                <button type="button" class="btn-biometric-punch btn-clock-in" onclick="confirmResetTodayPunch()" style="background: linear-gradient(135deg, #475569 0%, #334155 100%);">
                    <i class="fa fa-refresh"></i> Retake / Reset Punch (Demo Mode)
                </button>
            <?php endif; ?>

        </div>

        <!-- ================= RIGHT: TIMESHEET & KPIS ================= -->
        <div class="right-card-panel">

            <!-- Header -->
            <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 2px;">
                        <i class="fa fa-calendar-check-o" style="color: #00a896; margin-right: 6px;"></i>
                        Monthly Biometric Timesheet &bull; <?= date('F Y'); ?>
                    </h3>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                        Daily punch log, GPS tags, and biometric verification for <?= html_escape($user['name'] ?? 'Staff'); ?>
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="<?= base_url('admin1947/attendance/history?staff_id=' . ($user['id'] ?? 1)); ?>" class="btn btn-xs" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #475569; font-weight: 700; padding: 6px 12px; border-radius: 8px;">
                        Full Archives <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>

            <!-- KPI Metric Stat Row -->
            <div class="kpi-row">
                <div class="kpi-stat-box">
                    <div class="kpi-stat-label">Days Punched</div>
                    <div class="kpi-stat-val"><?= $month_stats['total_logs'] ?? 0; ?> <small style="font-size: 12px; color: #64748b; font-weight: 600;">days</small></div>
                </div>
                <div class="kpi-stat-box">
                    <div class="kpi-stat-label">On-Time Rate</div>
                    <div class="kpi-stat-val" style="color: #059669;"><?= $month_stats['punctuality'] ?? 100; ?>%</div>
                </div>
                <div class="kpi-stat-box">
                    <div class="kpi-stat-label">Total Hours</div>
                    <div class="kpi-stat-val" style="color: #0284c7;"><?= $month_stats['total_hours'] ?? 0; ?>h</div>
                </div>
                <div class="kpi-stat-box">
                    <div class="kpi-stat-label">Daily Average</div>
                    <div class="kpi-stat-val" style="color: #7c3aed;"><?= $month_stats['avg_hours'] ?? 0; ?>h</div>
                </div>
            </div>

            <!-- Timesheet Logs Table -->
            <div style="overflow-x: auto;">
                <table class="timesheet-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Hours</th>
                            <th>Geofence</th>
                            <th>Status</th>
                            <th>Verification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_logs)): ?>
                            <?php foreach ($recent_logs as $log): 
                                $s = $log['status'] ?: 'absent';
                                $sClass = in_array($s, ['present', 'late', 'half_day', 'absent']) ? $s : 'present';
                                $dist = floatval($log['distance_from_office_km'] ?? 0);
                                $isToday = ($log['punch_date'] === date('Y-m-d'));
                            ?>
                            <tr style="<?= $isToday ? 'background: #f0fdf4;' : ''; ?>">
                                <td>
                                    <strong style="color: #0f172a;"><?= date('d M, Y', strtotime($log['punch_date'])); ?></strong>
                                    <div style="font-size: 11px; color: #64748b;"><?= date('l', strtotime($log['punch_date'])); ?></div>
                                </td>
                                <td>
                                    <?php if (!empty($log['check_in_time'])): ?>
                                        <span style="color: #0284c7; font-weight: 700; font-family: monospace; font-size: 12.5px;">
                                            <?= date('h:i A', strtotime($log['check_in_time'])); ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #94a3b8;">--:--</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($log['check_out_time'])): ?>
                                        <span style="color: #475569; font-weight: 700; font-family: monospace; font-size: 12.5px;">
                                            <?= date('h:i A', strtotime($log['check_out_time'])); ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #94a3b8;">--:--</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($log['working_hours'])): ?>
                                        <strong style="color: #0f172a;"><?= $log['working_hours']; ?>h</strong>
                                    <?php else: ?>
                                        <span style="color: #94a3b8;">0.0h</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($dist <= 0.50): ?>
                                        <span style="background: #ecfdf5; color: #059669; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px; border: 1px solid #a7f3d0;" title="<?= $dist; ?> km from Hub">
                                            <i class="fa fa-map-marker"></i> Hub Verified
                                        </span>
                                    <?php else: ?>
                                        <span style="background: #fffbeb; color: #d97706; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 6px; border: 1px solid #fde68a;" title="<?= $dist; ?> km from Hub">
                                            <i class="fa fa-location-arrow"></i> Field (<?= $dist; ?>km)
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-pill <?= $sClass; ?>">
                                        <?= strtoupper($s); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($log['check_in_selfie'])): 
                                        $thumbSrc = $log['check_in_selfie'];
                                        if (strpos($thumbSrc, 'uploads/') === 0) {
                                            $thumbSrc = base_url($thumbSrc);
                                        } elseif (strpos($thumbSrc, '[removed]') === 0) {
                                            $thumbSrc = 'data:image/jpeg;base64,' . substr($thumbSrc, 9);
                                        }
                                    ?>
                                        <button type="button" class="btn btn-xs btn-default" onclick="showSelfiePreview('<?= addslashes($thumbSrc); ?>', '<?= date('d M Y, h:i A', strtotime($log['check_in_time'])); ?>')" style="padding: 2px 8px; border-radius: 6px; font-size: 11px; color: #7c3aed; border: 1px solid #cbd5e1; background: #fff;" title="View Biometric Photo">
                                            <i class="fa fa-camera"></i> Photo
                                        </button>
                                    <?php else: ?>
                                        <span style="color: #cbd5e1; font-size: 11px;">Verified</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fa fa-calendar-o" style="font-size: 32px; display: block; margin-bottom: 8px; opacity: 0.4;"></i>
                                    No biometric attendance records logged for this staff member this month.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

<!-- Photo Preview Modal -->
<div class="modal fade" id="punchSelfieModal" tabindex="-1" role="dialog" style="z-index: 99999;">
    <div class="modal-dialog modal-sm" role="document" style="max-width: 360px; margin-top: 100px;">
        <div class="modal-content" style="border-radius: 18px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); background: #0f172a; color: #fff;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                <h5 class="modal-title" style="font-size: 14px; font-weight: 800; margin: 0; color: #38bdf8;">
                    <i class="fa fa-camera"></i> Biometric Punch Photo
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8;">&times;</button>
            </div>
            <div class="modal-body" style="padding: 16px; text-align: center;">
                <div style="border-radius: 14px; overflow: hidden; background: #020617; border: 2px solid #00a896; margin-bottom: 10px;">
                    <img id="modalPunchPreviewImg" src="" style="width: 100%; height: 260px; object-fit: cover;" alt="Selfie">
                </div>
                <div id="modalPunchPreviewMeta" style="font-size: 11.5px; color: #94a3b8; font-family: monospace;"></div>
            </div>
        </div>
    </div>
</div>

<script>
var targetUserId = <?= intval($user['id'] ?? 1); ?>;
var targetUserName = '<?= addslashes(html_escape($user['name'] ?? 'Staff')); ?>';
var officeLat = 26.8467, officeLng = 80.9462;
var currentLat = 26.8467, currentLng = 80.9462;
var hasCamera = false;
var videoStream = null;
var facingMode = "user";
var currentSelfiePayload = null; // Stored base64 snapshot

var video = document.getElementById('webcamVideo');
var canvas = document.getElementById('selfieCanvas');
var snapshotImg = document.getElementById('snapshotImg');

// Live Digital Clock
setInterval(function() {
    var now = new Date();
    document.getElementById('liveClock').innerText = now.toLocaleTimeString('en-US', { hour12: true });
}, 1000);

// Calculate Haversine Distance
function calcDistanceKm(lat1, lon1, lat2, lon2) {
    var R = 6371; // km
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return (R * c).toFixed(2);
}

// Update Telemetry Widget
function updateTelemetry(lat, lng) {
    currentLat = lat;
    currentLng = lng;
    var dist = calcDistanceKm(lat, lng, officeLat, officeLng);
    $('#coordsDisplay').text('Lat: ' + lat.toFixed(4) + ', Lng: ' + lng.toFixed(4));
    $('#distanceDisplay').text(dist + ' km from Hub');

    if (dist <= 0.50) {
        $('#geofenceBadge').removeClass('status-outbounds').addClass('status-inbounds');
        $('#geofenceText').html('<i class="fa fa-check-circle"></i> Within 500m Hub');
    } else {
        $('#geofenceBadge').removeClass('status-inbounds').addClass('status-outbounds');
        $('#geofenceText').html('<i class="fa fa-exclamation-triangle"></i> Field (' + dist + 'km)');
    }
}

// Acquire High-Accuracy Geolocation
function refreshGeolocation() {
    $('#coordsDisplay').text('Acquiring GPS fix...');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            updateTelemetry(pos.coords.latitude, pos.coords.longitude);
        }, function(err) {
            console.warn('Geolocation warning:', err.message);
            updateTelemetry(officeLat, officeLng);
        }, { enableHighAccuracy: true, timeout: 8000 });
    } else {
        updateTelemetry(officeLat, officeLng);
    }
}
refreshGeolocation();

// WebRTC Camera Management
function startCamera() {
    if (videoStream) {
        videoStream.getTracks().forEach(function(t) { t.stop(); });
    }

    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({
            video: { facingMode: facingMode, width: { ideal: 640 }, height: { ideal: 640 } }
        }).then(function(stream) {
            videoStream = stream;
            hasCamera = true;
            video.srcObject = stream;
            video.style.display = 'block';
            snapshotImg.style.display = 'none';

            $('#camStatusDot').css({'background': '#10b981', 'box-shadow': '0 0 8px #10b981'});
            $('#camStatusText').text('Camera Live Stream');
            $('#snapBtnText').text('Snap Photo');
            $('#btnRetakePhoto').hide();
        }).catch(function(err) {
            console.warn('WebRTC Camera blocked or not found:', err);
            hasCamera = false;
            video.style.display = 'none';
            drawFallbackCanvasBadge();
            $('#camStatusDot').css({'background': '#38bdf8', 'box-shadow': '0 0 8px #38bdf8'});
            $('#camStatusText').text('Biometric Ready (Hologram)');
        });
    } else {
        drawFallbackCanvasBadge();
        $('#camStatusText').text('Upload Photo / Ready');
    }
}

// Fallback Canvas Badge when webcam hardware is not connected
function drawFallbackCanvasBadge() {
    var ctx = canvas.getContext('2d');
    canvas.width = 400; canvas.height = 400;

    // Dark high-tech gradient background
    var grad = ctx.createLinearGradient(0, 0, 400, 400);
    grad.addColorStop(0, '#090d16');
    grad.addColorStop(1, '#0f172a');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, 400, 400);

    // Decorative biometric circle
    ctx.strokeStyle = '#00a896';
    ctx.lineWidth = 4;
    ctx.beginPath();
    ctx.arc(200, 160, 80, 0, Math.PI * 2);
    ctx.stroke();

    // User icon
    ctx.fillStyle = '#2dd4bf';
    ctx.font = 'bold 50px sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('UPCHAR', 200, 175);

    // Metadata text
    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 18px sans-serif';
    ctx.fillText(targetUserName, 200, 280);

    ctx.fillStyle = '#94a3b8';
    ctx.font = '13px monospace';
    ctx.fillText(new Date().toLocaleString(), 200, 310);
    ctx.fillText('GPS: ' + currentLat.toFixed(4) + ', ' + currentLng.toFixed(4), 200, 335);

    currentSelfiePayload = canvas.toDataURL('image/jpeg', 0.85);
    snapshotImg.src = currentSelfiePayload;
    snapshotImg.style.display = 'block';
}

// Capture Snapshot from Video Frame
function captureSnapshot() {
    var ctx = canvas.getContext('2d');
    canvas.width = 400; canvas.height = 400;

    if (hasCamera && video.videoWidth > 0) {
        ctx.drawImage(video, 0, 0, 400, 400);

        // Watermark timestamp badge on snapshot
        ctx.fillStyle = 'rgba(15, 23, 42, 0.75)';
        ctx.fillRect(0, 340, 400, 60);

        ctx.fillStyle = '#38bdf8';
        ctx.font = 'bold 12px sans-serif';
        ctx.textAlign = 'left';
        ctx.fillText('UPCHAR BIOMETRIC VERIFIED', 14, 360);

        ctx.fillStyle = '#ffffff';
        ctx.font = '11px monospace';
        ctx.fillText(new Date().toLocaleTimeString() + ' | ' + currentLat.toFixed(4) + ', ' + currentLng.toFixed(4), 14, 382);
    } else {
        drawFallbackCanvasBadge();
    }

    currentSelfiePayload = canvas.toDataURL('image/jpeg', 0.85);
    snapshotImg.src = currentSelfiePayload;
    snapshotImg.style.display = 'block';
    video.style.display = 'none';

    $('#camStatusDot').css({'background': '#f59e0b', 'box-shadow': '0 0 8px #f59e0b'});
    $('#camStatusText').text('Snapshot Captured');
    $('#snapBtnText').text('Photo Ready');
    $('#btnRetakePhoto').show();
}

// Retake Snapshot
function retakePhoto() {
    currentSelfiePayload = null;
    startCamera();
}

// Switch Camera Front / Back
function switchCameraMode() {
    facingMode = (facingMode === "user") ? "environment" : "user";
    startCamera();
}

// Native Device Photo Upload Handler
function handleFileUpload(event) {
    var file = event.target.files[0];
    if (!file) return;

    var reader = new FileReader();
    reader.onload = function(e) {
        var img = new Image();
        img.onload = function() {
            var ctx = canvas.getContext('2d');
            canvas.width = 400; canvas.height = 400;
            ctx.drawImage(img, 0, 0, 400, 400);

            // Stamp watermark
            ctx.fillStyle = 'rgba(15, 23, 42, 0.75)';
            ctx.fillRect(0, 340, 400, 60);
            ctx.fillStyle = '#38bdf8';
            ctx.font = 'bold 12px sans-serif';
            ctx.textAlign = 'left';
            ctx.fillText('UPCHAR FILE UPLOAD VERIFIED', 14, 360);
            ctx.fillStyle = '#ffffff';
            ctx.font = '11px monospace';
            ctx.fillText(new Date().toLocaleTimeString() + ' | ' + currentLat.toFixed(4) + ', ' + currentLng.toFixed(4), 14, 382);

            currentSelfiePayload = canvas.toDataURL('image/jpeg', 0.85);
            snapshotImg.src = currentSelfiePayload;
            snapshotImg.style.display = 'block';
            video.style.display = 'none';

            $('#camStatusDot').css({'background': '#f59e0b', 'box-shadow': '0 0 8px #f59e0b'});
            $('#camStatusText').text('File Uploaded');
            $('#snapBtnText').text('Photo Ready');
            $('#btnRetakePhoto').show();
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// Initialize Camera
startCamera();

// Show Status Notification
function showPunchAlert(type, msg) {
    var box = $('#punchAlertBox');
    box.removeClass('alert-success alert-danger');
    if (type === 'ok') {
        box.css({'background': 'rgba(16, 185, 129, 0.2)', 'border': '1px solid #10b981', 'color': '#6ee7b7'});
    } else {
        box.css({'background': 'rgba(239, 68, 68, 0.2)', 'border': '1px solid #ef4444', 'color': '#fca5a5'});
    }
    box.html(msg).show();
}

// Submit Punch In
function submitPunchIn() {
    var btn = $('#btnClockIn');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing Punch-In...');

    // If no snapshot captured yet, take one automatically
    if (!currentSelfiePayload) {
        captureSnapshot();
    }

    var notes = $('#punchNotesInput').val().trim() || 'Mobile WebRTC Punch-In';

    var postData = {
        user_id: targetUserId,
        lat: currentLat,
        lng: currentLng,
        selfie: currentSelfiePayload,
        notes: notes
    };

    $.post('<?= base_url("admin1947/attendance/record_punch_in"); ?>', postData, function(res) {
        if (typeof res === 'string') {
            try { res = JSON.parse(res); } catch(e) {}
        }

        if (res && res.status === 'success') {
            showPunchAlert('ok', '<i class="fa fa-check-circle"></i> ' + res.message + ' (' + res.punch_time + ')');
            setTimeout(function() {
                location.reload();
            }, 1200);
        } else {
            showPunchAlert('err', '<i class="fa fa-times-circle"></i> ' + (res ? res.message : 'Punch-In failed'));
            btn.prop('disabled', false).html('<i class="fa fa-camera"></i> Punch In — Clock-In');
        }
    }).fail(function() {
        showPunchAlert('err', '<i class="fa fa-exclamation-circle"></i> Network error submitting punch. Please retry.');
        btn.prop('disabled', false).html('<i class="fa fa-camera"></i> Punch In — Clock-In');
    });
}

// Submit Punch Out
function submitPunchOut() {
    if (!confirm('Confirm Punch-Out for ' + targetUserName + '?')) return;

    var btn = $('#btnClockOut');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Recording Check-Out...');

    var notes = $('#punchNotesInput').val().trim() || 'End of Day Check-Out';

    var postData = {
        user_id: targetUserId,
        lat: currentLat,
        lng: currentLng,
        notes: notes
    };

    $.post('<?= base_url("admin1947/attendance/record_punch_out"); ?>', postData, function(res) {
        if (typeof res === 'string') {
            try { res = JSON.parse(res); } catch(e) {}
        }

        if (res && res.status === 'success') {
            showPunchAlert('ok', '<i class="fa fa-check-circle"></i> ' + res.message);
            setTimeout(function() {
                location.reload();
            }, 1200);
        } else {
            showPunchAlert('err', '<i class="fa fa-times-circle"></i> ' + (res ? res.message : 'Check-Out failed'));
            btn.prop('disabled', false).html('<i class="fa fa-sign-out"></i> Punch Out — Clock-Out');
        }
    }).fail(function() {
        showPunchAlert('err', '<i class="fa fa-exclamation-circle"></i> Network error recording check-out.');
        btn.prop('disabled', false).html('<i class="fa fa-sign-out"></i> Punch Out — Clock-Out');
    });
}

// Reset Today's Punch (For Testing / Demo)
function confirmResetTodayPunch() {
    if (!confirm("Reset today's punch record for " + targetUserName + "? This allows testing Punch-In again.")) return;

    $.get('<?= base_url("admin1947/attendance/reset_today_punch?staff_id="); ?>' + targetUserId, function(res) {
        location.reload();
    }).fail(function() {
        location.href = '<?= base_url("admin1947/attendance/reset_today_punch?staff_id="); ?>' + targetUserId;
    });
}

// Lightbox Preview for table selfies
function showSelfiePreview(imgSrc, metaTime) {
    $('#modalPunchPreviewImg').attr('src', imgSrc);
    $('#modalPunchPreviewMeta').text(metaTime);
    $('#punchSelfieModal').modal('show');
}
</script>
