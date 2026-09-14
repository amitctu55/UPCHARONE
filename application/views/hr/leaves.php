<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    /* Leaves Center Styling */
    .leaves-dashboard {
        max-width: 1400px;
        margin: 0 auto;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* KPI Cards */
    .leave-kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 992px) {
        .leave-kpi-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .leave-kpi-grid { grid-template-columns: 1fr; }
    }

    .leave-kpi-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 20px 22px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }
    .leave-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }
    .leave-kpi-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
    }
    .kpi-amber::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .kpi-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
    .kpi-indigo::before { background: linear-gradient(90deg, #6366f1, #4f46e5); }
    .kpi-rose::before { background: linear-gradient(90deg, #f43f5e, #e11d48); }

    .kpi-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .kpi-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 4px;
    }
    .kpi-value {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .kpi-icon-wrap {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .icon-amber { background: rgba(245, 158, 11, 0.12); color: #d97706; }
    .icon-emerald { background: rgba(16, 185, 129, 0.12); color: #059669; }
    .icon-indigo { background: rgba(99, 102, 241, 0.12); color: #4f46e5; }
    .icon-rose { background: rgba(244, 63, 94, 0.12); color: #e11d48; }

    .kpi-subtext {
        margin-top: 10px;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Filter Toolbar */
    .filter-panel {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);
    }
    .filter-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .status-pills-bar {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .status-pill-btn {
        padding: 7px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
    }
    .status-pill-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .status-pill-btn.active-all {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }
    .status-pill-btn.active-pending {
        background: #f59e0b;
        color: #ffffff;
        border-color: #f59e0b;
    }
    .status-pill-btn.active-approved {
        background: #10b981;
        color: #ffffff;
        border-color: #10b981;
    }
    .status-pill-btn.active-rejected {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    /* Table & Card Container */
    .leaves-table-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        overflow: hidden;
    }
    .leaves-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .leaves-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .leaves-table th {
        background: #f8fafc;
        padding: 13px 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }
    .leaves-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .leaves-table tr:hover td {
        background: #f8fafc;
    }

    /* Staff Pill */
    .staff-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .staff-avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        flex-shrink: 0;
    }
    .staff-name {
        font-weight: 800;
        color: #0f172a;
        font-size: 13.5px;
        margin-bottom: 2px;
    }
    .staff-meta {
        font-size: 11px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Leave Type Badges */
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .type-casual { background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; }
    .type-sick   { background: #ffe4e6; color: #e11d48; border: 1px solid #fecdd3; }
    .type-earned { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .type-emergency { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

    /* Decision Status Pill */
    .decision-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .decision-pending  { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .decision-approved { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .decision-rejected { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

    .pulse-dot-amber {
        width: 7px; height: 7px; border-radius: 50%; background: #f59e0b;
        box-shadow: 0 0 6px #f59e0b; animation: pulseDot 1.5s infinite;
    }
    .dot-green { width: 7px; height: 7px; border-radius: 50%; background: #10b981; }
    .dot-red   { width: 7px; height: 7px; border-radius: 50%; background: #ef4444; }

    @keyframes pulseDot { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.4; transform: scale(0.8); } }

    /* Action Buttons */
    .btn-action-approve {
        background: #10b981;
        color: #ffffff;
        font-weight: 700;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s;
    }
    .btn-action-approve:hover {
        background: #059669;
        transform: translateY(-1px);
    }
    .btn-action-reject {
        background: #ef4444;
        color: #ffffff;
        font-weight: 700;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s;
    }
    .btn-action-reject:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    /* Modal Styling */
    .modal-enterprise .modal-content {
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.18);
        overflow: hidden;
    }
    .modal-enterprise .modal-header {
        background: #0f172a;
        color: #ffffff;
        padding: 18px 24px;
        border-bottom: none;
    }
    .modal-enterprise .modal-body {
        padding: 24px;
    }

    /* Radio Card for Leave Type */
    .leave-type-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }
    @media (max-width: 600px) {
        .leave-type-cards { grid-template-columns: repeat(2, 1fr); }
    }
    .type-radio-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8fafc;
    }
    .type-radio-card:hover {
        border-color: #00a896;
        background: #ffffff;
    }
    .type-radio-card.selected {
        border-color: #00a896;
        background: rgba(0, 168, 150, 0.08);
    }
    .type-radio-card input {
        display: none;
    }

    /* Pagination Bar */
    .leaves-pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 24px;
        border-top: 1px solid #f1f5f9;
        background: #ffffff;
        flex-wrap: wrap;
        gap: 10px;
    }
</style>

<div class="leaves-dashboard">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(99, 102, 241, 0.1); color: #4f46e5; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                <i class="fa fa-calendar-times-o"></i> Workforce Time-Off Desk
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.4px;">
                Leave Applications &amp; Absence Approvals
            </h1>
            <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                Review field staff sick leaves, casual vacations, and automated quota credit for monthly payroll.
            </p>
        </div>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <!-- Apply Leave Trigger -->
            <button type="button" class="btn" onclick="openApplyModal()" style="background: linear-gradient(135deg, #00a896 0%, #0284c7 100%); color: #ffffff; font-weight: 800; border-radius: 12px; padding: 10px 18px; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35); border: none;">
                <i class="fa fa-plus-circle"></i> Apply for Leave
            </button>

            <!-- Export CSV -->
            <button type="button" class="btn btn-default" onclick="exportLeavesCSV()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; font-weight: 700; border-radius: 12px; padding: 10px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-download" style="color: #0284c7;"></i> Export CSV
            </button>

            <!-- Attendance Roster -->
            <a href="<?= base_url('attendance/roster'); ?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; font-weight: 700; border-radius: 12px; padding: 10px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-calendar-check-o" style="color: #10b981;"></i> Roster Desk
            </a>
        </div>
    </div>

    <!-- Flash Alerts -->
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600; margin-bottom: 18px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success_msg'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible" style="border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-weight: 600; margin-bottom: 18px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-exclamation-triangle"></i> <?= $this->session->flashdata('error_msg'); ?>
        </div>
    <?php endif; ?>

    <!-- KPI Metric Cards Grid -->
    <div class="leave-kpi-grid">
        <!-- 1. Pending -->
        <div class="leave-kpi-card kpi-amber">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Pending Decisions</div>
                    <div class="kpi-value" style="color: #d97706;"><?= $metrics['pending'] ?? 0; ?></div>
                </div>
                <div class="kpi-icon-wrap icon-amber">
                    <i class="fa fa-hourglass-half"></i>
                </div>
            </div>
            <div class="kpi-subtext" style="color: #d97706;">
                <span class="pulse-dot-amber"></span> Requires supervisor review
            </div>
        </div>

        <!-- 2. Approved -->
        <div class="leave-kpi-card kpi-emerald">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Approved Leaves</div>
                    <div class="kpi-value" style="color: #059669;"><?= $metrics['approved'] ?? 0; ?></div>
                </div>
                <div class="kpi-icon-wrap icon-emerald">
                    <i class="fa fa-check-circle-o"></i>
                </div>
            </div>
            <div class="kpi-subtext" style="color: #059669;">
                <i class="fa fa-calculator"></i> Credited to salary payroll
            </div>
        </div>

        <!-- 3. Approved Days -->
        <div class="leave-kpi-card kpi-indigo">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Total Days Approved</div>
                    <div class="kpi-value" style="color: #4f46e5;"><?= $metrics['total_days'] ?? 0; ?> <small style="font-size: 14px; font-weight: 600; color: #64748b;">days</small></div>
                </div>
                <div class="kpi-icon-wrap icon-indigo">
                    <i class="fa fa-sun-o"></i>
                </div>
            </div>
            <div class="kpi-subtext" style="color: #4f46e5;">
                <i class="fa fa-users"></i> Across all active staff
            </div>
        </div>

        <!-- 4. Quota Breakdown -->
        <div class="leave-kpi-card kpi-rose">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Type Distribution</div>
                    <div style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 4px; display: flex; flex-wrap: wrap; gap: 6px;">
                        <span style="background: #e0f2fe; color: #0284c7; padding: 2px 7px; border-radius: 6px; font-size: 11px;">CL: <?= $metrics['casual_days'] ?? 0; ?>d</span>
                        <span style="background: #ffe4e6; color: #e11d48; padding: 2px 7px; border-radius: 6px; font-size: 11px;">SL: <?= $metrics['sick_days'] ?? 0; ?>d</span>
                        <span style="background: #dcfce7; color: #15803d; padding: 2px 7px; border-radius: 6px; font-size: 11px;">EL: <?= $metrics['earned_days'] ?? 0; ?>d</span>
                    </div>
                </div>
                <div class="kpi-icon-wrap icon-rose">
                    <i class="fa fa-pie-chart"></i>
                </div>
            </div>
            <div class="kpi-subtext" style="color: #e11d48;">
                <i class="fa fa-ban"></i> <?= $metrics['rejected'] ?? 0; ?> applications declined
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="filter-panel">
        <div class="filter-row">
            <!-- Status Tabs -->
            <div class="status-pills-bar">
                <a href="<?= base_url('hr/leaves?status=all' . ($selected_dept !== 'all' ? '&dept=' . $selected_dept : '') . ($selected_type !== 'all' ? '&type=' . $selected_type : '')); ?>" class="status-pill-btn <?= ($selected_status === 'all') ? 'active-all' : ''; ?>">
                    All (<?= $metrics['total']; ?>)
                </a>
                <a href="<?= base_url('hr/leaves?status=pending' . ($selected_dept !== 'all' ? '&dept=' . $selected_dept : '') . ($selected_type !== 'all' ? '&type=' . $selected_type : '')); ?>" class="status-pill-btn <?= ($selected_status === 'pending') ? 'active-pending' : ''; ?>">
                    <span class="pulse-dot-amber"></span> Pending Review (<?= $metrics['pending']; ?>)
                </a>
                <a href="<?= base_url('hr/leaves?status=approved' . ($selected_dept !== 'all' ? '&dept=' . $selected_dept : '') . ($selected_type !== 'all' ? '&type=' . $selected_type : '')); ?>" class="status-pill-btn <?= ($selected_status === 'approved') ? 'active-approved' : ''; ?>">
                    <i class="fa fa-check-circle"></i> Approved (<?= $metrics['approved']; ?>)
                </a>
                <a href="<?= base_url('hr/leaves?status=rejected' . ($selected_dept !== 'all' ? '&dept=' . $selected_dept : '') . ($selected_type !== 'all' ? '&type=' . $selected_type : '')); ?>" class="status-pill-btn <?= ($selected_status === 'rejected') ? 'active-rejected' : ''; ?>">
                    <i class="fa fa-times-circle"></i> Rejected (<?= $metrics['rejected']; ?>)
                </a>
            </div>

            <!-- Department & Type Selectors -->
            <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                <!-- Department filter -->
                <select id="filterDeptSelect" class="form-control input-sm" style="width: 170px; border-radius: 10px; font-weight: 600; font-size: 12px;" onchange="applyFilters()">
                    <option value="all">All Departments</option>
                    <?php 
                        $depts = ['Central Operations', 'Human Resources', 'Diagnostic Field Logistics', 'Business Development', 'Management', 'doctor'];
                        foreach ($depts as $d):
                    ?>
                        <option value="<?= $d; ?>" <?= ($selected_dept === $d) ? 'selected' : ''; ?>><?= $d; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Leave Type filter -->
                <select id="filterTypeSelect" class="form-control input-sm" style="width: 150px; border-radius: 10px; font-weight: 600; font-size: 12px;" onchange="applyFilters()">
                    <option value="all">All Leave Types</option>
                    <option value="casual" <?= ($selected_type === 'casual') ? 'selected' : ''; ?>>Casual Leave</option>
                    <option value="sick" <?= ($selected_type === 'sick') ? 'selected' : ''; ?>>Sick / Medical</option>
                    <option value="earned" <?= ($selected_type === 'earned') ? 'selected' : ''; ?>>Earned / Privilege</option>
                    <option value="emergency" <?= ($selected_type === 'emergency') ? 'selected' : ''; ?>>Emergency</option>
                </select>

                <!-- Search Input -->
                <div style="position: relative; width: 220px;">
                    <i class="fa fa-search" style="position: absolute; left: 10px; top: 9px; color: #94a3b8; font-size: 12px;"></i>
                    <input type="text" id="leaveTableSearch" class="form-control input-sm" placeholder="Search applicant, reason..." value="<?= html_escape($search_query); ?>" style="padding-left: 28px; border-radius: 10px; font-size: 12px;" onkeyup="filterClientSide()">
                </div>
            </div>
        </div>
    </div>

    <!-- Leaves Roster Table Card -->
    <div class="leaves-table-card">
        <div class="leaves-card-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 10px; height: 10px; border-radius: 50%; background: #00a896;"></div>
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                    Workforce Leave Applications Roster
                </h3>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span id="rosterShowingCount" style="font-size: 12px; font-weight: 600; color: #64748b;">
                    Showing <?= count($leaves); ?> entries
                </span>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="leaves-table" id="leavesMainTable">
                <thead>
                    <tr>
                        <th>Applicant Staff</th>
                        <th>Leave Type</th>
                        <th>Period &amp; Duration</th>
                        <th>Reason for Absence</th>
                        <th>Approval Status</th>
                        <th>Reviewer Audit</th>
                        <th style="text-align: right;">Decision Actions</th>
                    </tr>
                </thead>
                <tbody id="leavesTbody">
                    <?php if (!empty($leaves)): ?>
                        <?php foreach ($leaves as $l): 
                            $st = $l['status'];
                            $type = strtolower($l['leave_type']);
                            $typeClass = 'type-casual';
                            $typeLabel = 'Casual Leave';
                            $typeIcon  = 'fa-umbrella';

                            if ($type === 'sick') {
                                $typeClass = 'type-sick';
                                $typeLabel = 'Sick / Medical';
                                $typeIcon  = 'fa-heartbeat';
                            } elseif ($type === 'earned') {
                                $typeClass = 'type-earned';
                                $typeLabel = 'Earned Leave';
                                $typeIcon  = 'fa-briefcase';
                            } elseif ($type === 'emergency') {
                                $typeClass = 'type-emergency';
                                $typeLabel = 'Emergency';
                                $typeIcon  = 'fa-exclamation-triangle';
                            }

                            $initial = strtoupper(substr($l['employee_name'] ?? 'S', 0, 1));
                        ?>
                        <tr class="leave-row" data-status="<?= $l['status']; ?>" data-dept="<?= html_escape($l['department']); ?>" data-type="<?= $l['leave_type']; ?>">
                            <!-- Applicant Staff -->
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar-sm">
                                        <?= $initial; ?>
                                    </div>
                                    <div>
                                        <div class="staff-name">
                                            <?= html_escape($l['employee_name']); ?>
                                        </div>
                                        <div class="staff-meta">
                                            <span style="font-family: monospace; font-weight: 700; color: #0284c7;"><?= html_escape($l['staff_code']); ?></span>
                                            &bull; <?= html_escape($l['department']); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Leave Type -->
                            <td>
                                <span class="type-badge <?= $typeClass; ?>">
                                    <i class="fa <?= $typeIcon; ?>"></i> <?= $typeLabel; ?>
                                </span>
                            </td>

                            <!-- Period & Duration -->
                            <td>
                                <div style="font-weight: 800; color: #0f172a; font-size: 13px;">
                                    <?= date('d M', strtotime($l['start_date'])); ?> &rarr; <?= date('d M, Y', strtotime($l['end_date'])); ?>
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    <strong style="color: #6366f1;"><?= $l['days_count']; ?> Day<?= $l['days_count'] > 1 ? 's' : ''; ?></strong> Total
                                </div>
                            </td>

                            <!-- Reason for Absence -->
                            <td style="max-width: 260px;">
                                <div style="font-size: 12.5px; color: #334155; line-height: 1.4; background: #f8fafc; padding: 7px 11px; border-radius: 8px; border-left: 3px solid #cbd5e1;" title="<?= html_escape($l['reason']); ?>">
                                    &ldquo;<?= html_escape(mb_strimwidth($l['reason'], 0, 80, '...')); ?>&rdquo;
                                </div>
                            </td>

                            <!-- Approval Status -->
                            <td>
                                <?php if ($st === 'approved'): ?>
                                    <span class="decision-pill decision-approved">
                                        <span class="dot-green"></span> Approved
                                    </span>
                                <?php elseif ($st === 'rejected'): ?>
                                    <span class="decision-pill decision-rejected">
                                        <span class="dot-red"></span> Rejected
                                    </span>
                                <?php else: ?>
                                    <span class="decision-pill decision-pending">
                                        <span class="pulse-dot-amber"></span> Pending Review
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Reviewer Audit -->
                            <td>
                                <?php if (!empty($l['reviewer_name'])): ?>
                                    <div style="font-size: 12px; font-weight: 700; color: #0f172a;">
                                        <?= html_escape($l['reviewer_name']); ?>
                                    </div>
                                    <div style="font-size: 11px; color: #64748b;">
                                        <?= !empty($l['reviewer_notes']) ? html_escape($l['reviewer_notes']) : 'Reviewed & Approved'; ?>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 11.5px; font-style: italic;">Awaiting HR action</span>
                                <?php endif; ?>
                            </td>

                            <!-- Decision Actions -->
                            <td style="text-align: right; white-space: nowrap;">
                                <?php if ($st === 'pending'): ?>
                                    <div style="display: inline-flex; gap: 6px;">
                                        <button type="button" class="btn-action-approve" onclick="openReviewModal(<?= $l['id']; ?>, '<?= html_escape(addslashes($l['employee_name'])); ?>', '<?= html_escape(addslashes($l['reason'])); ?>', 'approved')" title="Approve this application">
                                            <i class="fa fa-check"></i> Approve
                                        </button>
                                        <button type="button" class="btn-action-reject" onclick="openReviewModal(<?= $l['id']; ?>, '<?= html_escape(addslashes($l['employee_name'])); ?>', '<?= html_escape(addslashes($l['reason'])); ?>', 'rejected')" title="Reject this application">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div style="display: inline-flex; gap: 6px;">
                                        <button type="button" class="btn btn-xs btn-default" onclick="openReviewModal(<?= $l['id']; ?>, '<?= html_escape(addslashes($l['employee_name'])); ?>', '<?= html_escape(addslashes($l['reason'])); ?>', '<?= $st; ?>')" style="border-radius: 6px; font-size: 11px; font-weight: 700; padding: 4px 8px; color: #475569;" title="Re-evaluate or adjust decision">
                                            <i class="fa fa-pencil"></i> Edit Decision
                                        </button>
                                        <button type="button" class="btn btn-xs btn-default" onclick="confirmDeleteLeave(<?= $l['id']; ?>, '<?= html_escape(addslashes($l['employee_name'])); ?>')" style="border-radius: 6px; font-size: 11px; font-weight: 700; padding: 4px 8px; color: #ef4444;" title="Cancel leave">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="noRowsTr">
                            <td colspan="7" style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                <i class="fa fa-calendar-times-o" style="font-size: 38px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                <strong style="font-size: 15px; color: #475569;">No leave applications found</strong>
                                <p style="font-size: 12.5px; color: #94a3b8; margin: 4px 0 16px 0;">No employee leaves match the current filter selection.</p>
                                <button type="button" class="btn btn-sm" onclick="openApplyModal()" style="background: #00a896; color: #fff; font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                                    <i class="fa fa-plus-circle"></i> Create First Leave Application
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Interactive Pagination Controls -->
        <div class="leaves-pagination-bar">
            <div style="font-size: 12.5px; color: #64748b; font-weight: 600;" id="paginationSummary">
                Showing 1 to <?= count($leaves); ?> entries
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: #64748b; font-weight: 600; margin-right: 12px;">
                    <span>Rows:</span>
                    <select id="pageSizeSelect" class="form-control input-sm" style="width: 75px; border-radius: 8px; font-size: 12px; height: 30px;" onchange="changePageSize()">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="all">All</option>
                    </select>
                </div>
                <div id="paginationButtons" style="display: inline-flex; gap: 4px;"></div>
            </div>
        </div>
    </div>

</div>

<!-- ================= MODAL 1: APPLY FOR LEAVE ================= -->
<div class="modal fade modal-enterprise" id="applyLeaveModal" tabindex="-1" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog" role="document" style="max-width: 540px; margin-top: 60px;">
        <div class="modal-content">
            <form id="applyLeaveForm" onsubmit="submitApplyLeave(event)">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                    <h4 class="modal-title" style="font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-calendar-plus-o" style="color: #2dd4bf;"></i> Apply for Employee Leave
                    </h4>
                </div>

                <div class="modal-body">
                    <!-- Staff Selection -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">
                            Select Staff Employee <span style="color: #ef4444;">*</span>
                        </label>
                        <select name="user_id" id="modalStaffId" class="form-control" style="border-radius: 10px; font-weight: 600; font-size: 13px;" required>
                            <option value="">-- Choose Staff Member --</option>
                            <?php foreach ($all_staff as $st): ?>
                                <option value="<?= $st['id']; ?>">
                                    <?= html_escape($st['name']); ?> (<?= html_escape($st['staff_code']); ?> &bull; <?= strtoupper($st['role']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Leave Type Radio Cards -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">
                            Leave Classification <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="hidden" name="leave_type" id="modalLeaveTypeVal" value="casual">
                        <div class="leave-type-cards">
                            <div class="type-radio-card selected" onclick="selectTypeCard(this, 'casual')">
                                <i class="fa fa-umbrella" style="color: #0284c7; font-size: 18px; margin-bottom: 4px; display: block;"></i>
                                <strong style="font-size: 12px; color: #0f172a; display: block;">Casual</strong>
                                <small style="font-size: 10px; color: #64748b;">Vacation</small>
                            </div>
                            <div class="type-radio-card" onclick="selectTypeCard(this, 'sick')">
                                <i class="fa fa-heartbeat" style="color: #e11d48; font-size: 18px; margin-bottom: 4px; display: block;"></i>
                                <strong style="font-size: 12px; color: #0f172a; display: block;">Sick</strong>
                                <small style="font-size: 10px; color: #64748b;">Medical</small>
                            </div>
                            <div class="type-radio-card" onclick="selectTypeCard(this, 'earned')">
                                <i class="fa fa-briefcase" style="color: #15803d; font-size: 18px; margin-bottom: 4px; display: block;"></i>
                                <strong style="font-size: 12px; color: #0f172a; display: block;">Earned</strong>
                                <small style="font-size: 10px; color: #64748b;">Privilege</small>
                            </div>
                            <div class="type-radio-card" onclick="selectTypeCard(this, 'emergency')">
                                <i class="fa fa-exclamation-triangle" style="color: #b45309; font-size: 18px; margin-bottom: 4px; display: block;"></i>
                                <strong style="font-size: 12px; color: #0f172a; display: block;">Emergency</strong>
                                <small style="font-size: 10px; color: #64748b;">Urgent</small>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range Selection -->
                    <div class="row" style="margin-bottom: 14px;">
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">
                                Start Date <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="date" name="start_date" id="modalStartDate" class="form-control" value="<?= date('Y-m-d'); ?>" onchange="calcModalDays()" style="border-radius: 10px; font-weight: 600; font-size: 13px;" required>
                        </div>
                        <div class="col-xs-6">
                            <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">
                                End Date <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="date" name="end_date" id="modalEndDate" class="form-control" value="<?= date('Y-m-d'); ?>" onchange="calcModalDays()" style="border-radius: 10px; font-weight: 600; font-size: 13px;" required>
                        </div>
                    </div>

                    <!-- Computed Days Banner -->
                    <div style="background: rgba(0, 168, 150, 0.08); border: 1px solid rgba(0, 168, 150, 0.25); border-radius: 10px; padding: 8px 12px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; font-weight: 700; color: #00a896;">
                            <i class="fa fa-calendar-check-o"></i> Calculated Leave Span:
                        </span>
                        <span id="modalDaysBadge" style="background: #00a896; color: #fff; font-weight: 800; font-size: 11.5px; padding: 2px 10px; border-radius: 12px;">
                            1 Business Day
                        </span>
                    </div>

                    <!-- Reason Textarea -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.4px;">
                            Reason / Remarks <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea name="reason" id="modalReason" class="form-control" rows="3" placeholder="State reason for absence, emergency contact, or coverage plan..." style="border-radius: 10px; font-size: 13px; padding: 10px 12px;" required></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px; font-weight: 700; font-size: 12.5px;">Cancel</button>
                    <button type="submit" id="btnSubmitLeave" class="btn" style="background: #00a896; color: #ffffff; font-weight: 800; border-radius: 10px; font-size: 13px; padding: 8px 20px;">
                        <i class="fa fa-paper-plane"></i> Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL 2: HR DECISION & REVIEW ================= -->
<div class="modal fade modal-enterprise" id="reviewLeaveModal" tabindex="-1" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog" role="document" style="max-width: 480px; margin-top: 80px;">
        <div class="modal-content">
            <form id="reviewLeaveForm" onsubmit="submitReviewDecision(event)">
                <input type="hidden" name="leave_id" id="revLeaveId" value="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="modal-header" style="background: #0f172a;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                    <h4 class="modal-title" style="font-size: 15px; font-weight: 800; color: #ffffff;">
                        <i class="fa fa-gavel" style="color: #f59e0b;"></i> Supervisor Leave Decision
                    </h4>
                </div>

                <div class="modal-body">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; margin-bottom: 18px;">
                        <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Applicant</div>
                        <div id="revStaffName" style="font-weight: 800; font-size: 15px; color: #0f172a; margin-top: 2px;"></div>
                        <div id="revReason" style="font-size: 12px; color: #475569; margin-top: 6px; font-style: italic;"></div>
                    </div>

                    <!-- Decision Toggle -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">
                            Decision Action <span style="color: #ef4444;">*</span>
                        </label>
                        <div style="display: flex; gap: 10px;">
                            <label class="btn btn-default btn-block" style="border-radius: 10px; font-weight: 800; font-size: 13px; text-align: center; padding: 10px; border: 2px solid #a7f3d0; background: #ecfdf5; color: #065f46; cursor: pointer;">
                                <input type="radio" name="status" id="revStatusApprove" value="approved" checked> &nbsp;Approve Leave
                            </label>
                            <label class="btn btn-default btn-block" style="border-radius: 10px; font-weight: 800; font-size: 13px; text-align: center; padding: 10px; border: 2px solid #fecaca; background: #fef2f2; color: #991b1b; cursor: pointer; margin: 0;">
                                <input type="radio" name="status" id="revStatusReject" value="rejected"> &nbsp;Reject Leave
                            </label>
                        </div>
                    </div>

                    <!-- Reviewer Notes -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">
                            Supervisor Remarks / Notes
                        </label>
                        <textarea name="notes" id="revNotes" class="form-control" rows="3" placeholder="e.g. Approved. Shift responsibilities delegated to operations lead..." style="border-radius: 10px; font-size: 12.5px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px; font-weight: 700;">Cancel</button>
                    <button type="submit" id="btnSaveReview" class="btn" style="background: #0f172a; color: #fff; font-weight: 800; border-radius: 10px; padding: 8px 18px;">
                        <i class="fa fa-save"></i> Save Decision
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Filter URL Generator
function applyFilters() {
    var dept = $('#filterDeptSelect').val();
    var type = $('#filterTypeSelect').val();
    var status = '<?= $selected_status; ?>';
    var url = '<?= base_url("hr/leaves"); ?>?status=' + encodeURIComponent(status);
    if (dept !== 'all') url += '&dept=' + encodeURIComponent(dept);
    if (type !== 'all') url += '&type=' + encodeURIComponent(type);
    location.href = url;
}

// Client-Side Search
function filterClientSide() {
    var query = $('#leaveTableSearch').val().toLowerCase();
    var rows = document.querySelectorAll('#leavesTbody tr.leave-row');
    var visibleCount = 0;

    rows.forEach(function(r) {
        var text = r.innerText.toLowerCase();
        if (text.indexOf(query) > -1) {
            r.dataset.matched = 'true';
            visibleCount++;
        } else {
            r.dataset.matched = 'false';
        }
    });

    currentPage = 1;
    renderPagination();
}

// Open Apply Leave Modal
function openApplyModal() {
    $('#applyLeaveForm')[0].reset();
    selectTypeCard(document.querySelector('.type-radio-card'), 'casual');
    calcModalDays();
    $('#applyLeaveModal').modal('show');
}

// Leave Classification Radio Card Switcher
function selectTypeCard(el, typeVal) {
    document.querySelectorAll('.type-radio-card').forEach(function(card) {
        card.classList.remove('selected');
    });
    el.classList.add('selected');
    $('#modalLeaveTypeVal').val(typeVal);
}

// Calculate Days Span
function calcModalDays() {
    var start = new Date($('#modalStartDate').val());
    var end   = new Date($('#modalEndDate').val());
    if (start && end && !isNaN(start.getTime()) && !isNaN(end.getTime())) {
        var diff = Math.round((end - start) / (1000 * 60 * 60 * 24)) + 1;
        if (diff < 1) diff = 1;
        $('#modalDaysBadge').text(diff + ' Day' + (diff > 1 ? 's' : '') + ' Span');
    }
}

// AJAX Submit Apply Leave
function submitApplyLeave(e) {
    e.preventDefault();
    var btn = $('#btnSubmitLeave');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');

    var formData = $('#applyLeaveForm').serialize();

    $.post('<?= base_url("hr/apply_leave"); ?>', formData, function(res) {
        if (typeof res === 'string') {
            try { res = JSON.parse(res); } catch(e) {}
        }
        if (res && res.status === 'success') {
            alert(res.message);
            location.reload();
        } else {
            alert(res ? res.message : 'Error submitting application');
            btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Submit Application');
        }
    }).fail(function() {
        alert('Network error submitting application.');
        btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Submit Application');
    });
}

// Open Review Modal
function openReviewModal(leaveId, name, reason, currentStatus) {
    $('#revLeaveId').val(leaveId);
    $('#revStaffName').text(name);
    $('#revReason').text('“' + reason + '”');
    if (currentStatus === 'rejected') {
        $('#revStatusReject').prop('checked', true);
    } else {
        $('#revStatusApprove').prop('checked', true);
    }
    $('#reviewLeaveModal').modal('show');
}

// AJAX Submit Decision
function submitReviewDecision(e) {
    e.preventDefault();
    var btn = $('#btnSaveReview');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    var formData = $('#reviewLeaveForm').serialize();

    $.post('<?= base_url("hr/update_leave"); ?>', formData, function(res) {
        if (typeof res === 'string') {
            try { res = JSON.parse(res); } catch(e) {}
        }
        if (res && res.status === 'success') {
            alert(res.message);
            location.reload();
        } else {
            alert(res ? res.message : 'Failed to update leave.');
            btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Decision');
        }
    }).fail(function() {
        alert('Server communication error.');
        btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Decision');
    });
}

// Delete Leave Request
function confirmDeleteLeave(leaveId, name) {
    if (!confirm('Are you sure you want to cancel and delete the leave request for ' + name + '?')) return;

    $.post('<?= base_url("hr/delete_leave"); ?>', {
        leave_id: leaveId,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
    }, function(res) {
        location.reload();
    }).fail(function() {
        location.reload();
    });
}

// Client-Side Pagination Logic
var currentPage = 1;
var pageSize = 25;

function getActiveRows() {
    var allRows = Array.from(document.querySelectorAll('#leavesTbody tr.leave-row'));
    return allRows.filter(function(r) {
        return r.dataset.matched !== 'false';
    });
}

function renderPagination() {
    var rows = getActiveRows();
    var total = rows.length;

    var actualSize = (pageSize === 'all') ? total : parseInt(pageSize);
    var totalPages = (pageSize === 'all' || total === 0) ? 1 : Math.ceil(total / actualSize);

    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    var start = (currentPage - 1) * actualSize;
    var end   = start + actualSize;

    // Hide all, show slice
    document.querySelectorAll('#leavesTbody tr.leave-row').forEach(function(r) {
        r.style.display = 'none';
    });

    rows.forEach(function(r, idx) {
        if (pageSize === 'all' || (idx >= start && idx < end)) {
            r.style.display = '';
        }
    });

    // Update info count
    var showingStart = total === 0 ? 0 : start + 1;
    var showingEnd   = (pageSize === 'all' || end > total) ? total : end;
    $('#paginationSummary').text('Showing ' + showingStart + ' to ' + showingEnd + ' of ' + total + ' leave entries');
    $('#rosterShowingCount').text('Showing ' + total + ' entries');

    // Build page buttons
    var btnHtml = '';
    if (totalPages > 1) {
        btnHtml += '<button type="button" class="btn btn-xs btn-default" ' + (currentPage === 1 ? 'disabled' : '') + ' onclick="gotoPage(' + (currentPage - 1) + ')"><i class="fa fa-angle-left"></i> Prev</button>';
        for (var p = 1; p <= totalPages; p++) {
            if (totalPages > 7 && Math.abs(p - currentPage) > 2 && p !== 1 && p !== totalPages) {
                if (p === 2 || p === totalPages - 1) btnHtml += '<span style="padding: 2px 5px; color: #94a3b8;">...</span>';
                continue;
            }
            btnHtml += '<button type="button" class="btn btn-xs ' + (p === currentPage ? 'btn-primary' : 'btn-default') + '" style="font-weight: 700; border-radius: 6px; min-width: 28px;" onclick="gotoPage(' + p + ')">' + p + '</button>';
        }
        btnHtml += '<button type="button" class="btn btn-xs btn-default" ' + (currentPage === totalPages ? 'disabled' : '') + ' onclick="gotoPage(' + (currentPage + 1) + ')">Next <i class="fa fa-angle-right"></i></button>';
    }
    $('#paginationButtons').html(btnHtml);
}

function gotoPage(p) {
    currentPage = p;
    renderPagination();
}

function changePageSize() {
    pageSize = $('#pageSizeSelect').val();
    currentPage = 1;
    renderPagination();
}

// Initial pagination render
$(document).ready(function() {
    renderPagination();
});

// CSV Export
function exportLeavesCSV() {
    var csv = [];
    var rows = document.querySelectorAll("#leavesMainTable tr");
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length - 1; j++) {
            var text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
            row.push('"' + text.replace(/"/g, '""') + '"');
        }
        csv.push(row.join(","));
    }
    var csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
    var downloadLink = document.createElement("a");
    downloadLink.download = "Leaves_Roster_<?= date('Y-m-d'); ?>.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}
</script>
