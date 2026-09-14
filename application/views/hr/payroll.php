<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    /* Payroll Theme */
    .payroll-container {
        max-width: 1400px;
        margin: 0 auto;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .payroll-kpi-banner {
        background: linear-gradient(135deg, #090d16 0%, #0f172a 60%, #1e293b 100%);
        border-radius: 20px;
        padding: 24px 28px;
        margin-bottom: 24px;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 12px 30px -8px rgba(15, 23, 42, 0.35);
        position: relative;
        overflow: hidden;
    }
    .payroll-kpi-banner::after {
        content: '';
        position: absolute;
        bottom: -50px; right: -50px;
        width: 180px; height: 180px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .stat-badge-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        padding: 14px 16px;
        transition: all 0.2s;
    }
    .stat-badge-card:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* Mode Pill Switcher */
    .payroll-mode-toggle {
        display: inline-flex;
        background: #f1f5f9;
        border-radius: 10px;
        padding: 3px;
        border: 1px solid #cbd5e1;
    }
    .mode-pill {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none !important;
        color: #64748b;
        transition: all 0.15s;
    }
    .mode-pill.active {
        background: #0f172a;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.2);
    }

    /* Table Container */
    .payroll-table-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        overflow: hidden;
    }
    .payroll-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .payroll-main-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .payroll-main-table th {
        background: #f8fafc;
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }
    .payroll-main-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .payroll-main-table tr:hover td {
        background: #f8fafc;
    }

    .staff-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .staff-avatar-sq {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.15);
    }
    .staff-name-text {
        font-weight: 800;
        color: #0f172a;
        font-size: 14px;
        line-height: 1.25;
    }
    .staff-role-badge {
        font-family: monospace;
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .btn-view-slip {
        background: #0f172a;
        color: #ffffff;
        font-weight: 700;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.18);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s;
    }
    .btn-view-slip:hover {
        background: #00a896;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);
    }

    /* Modal Payslip */
    .payslip-letterhead {
        border-bottom: 2px solid #00a896;
        padding-bottom: 14px;
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .payslip-ledger-box {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 16px;
    }
    .ledger-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    @media (max-width: 600px) {
        .ledger-grid { grid-template-columns: 1fr; }
    }
    .ledger-col-header {
        background: #f8fafc;
        padding: 10px 14px;
        font-weight: 800;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }
    .ledger-line {
        display: flex;
        justify-content: space-between;
        padding: 8px 14px;
        font-size: 12.5px;
        border-bottom: 1px solid #f1f5f9;
    }
    .ledger-line:last-child {
        border-bottom: none;
    }
    .ledger-line.total-line {
        background: #f8fafc;
        font-weight: 800;
        border-top: 1px solid #e2e8f0;
    }

    .net-salary-highlight {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: #ffffff;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }

    /* Pagination Bar */
    .payroll-pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 24px;
        border-top: 1px solid #f1f5f9;
        background: #ffffff;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Payment Transfer Status Pills */
    .transfer-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10.5px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        line-height: 1.3;
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .transfer-status-pill.pill-transferred {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .transfer-status-pill.pill-pending {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .transfer-status-pill.pill-on-hold {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }

    /* Modal Payment Transfer Ribbon Card */
    .ps-transfer-card {
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 16px;
        transition: all 0.2s ease;
    }
    .ps-transfer-card.state-transferred {
        background: #f0fdf4;
        border: 1.5px solid #86efac;
    }
    .ps-transfer-card.state-pending {
        background: #fffbeb;
        border: 1.5px solid #fde68a;
    }
    .ps-transfer-card.state-on_hold {
        background: #fff1f2;
        border: 1.5px solid #fecdd3;
    }
    .ps-transfer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 8px;
    }
    .ps-transfer-tag {
        font-size: 11.5px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .ps-transfer-card.state-transferred .ps-transfer-tag {
        background: #059669;
        color: #ffffff;
    }
    .ps-transfer-card.state-pending .ps-transfer-tag {
        background: #d97706;
        color: #ffffff;
    }
    .ps-transfer-card.state-on_hold .ps-transfer-tag {
        background: #e11d48;
        color: #ffffff;
    }
    .ps-transfer-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
    @media (max-width: 640px) {
        .ps-transfer-grid {
            grid-template-columns: 1fr;
        }
    }
    .ps-transfer-cell {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
    }
    .ps-transfer-cell small {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
        letter-spacing: 0.3px;
    }
    .ps-transfer-cell div {
        font-size: 12.5px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Modal Transfer Status Editor Form */
    .ps-status-manager {
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        padding: 16px 18px;
        margin-top: 16px;
    }

    /* Toast notification */
    #payrollToast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #0f172a;
        color: #ffffff;
        padding: 14px 20px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        font-size: 13px;
        font-weight: 700;
        z-index: 999999;
        display: none;
        align-items: center;
        gap: 10px;
        border-left: 4px solid #00a896;
    }
</style>

<div class="payroll-container">

    <?php
    $monthTimestamp = mktime(0, 0, 0, intval($month), 10, intval($year));
    $monthName      = date('F Y', $monthTimestamp);
    $totalHeadcount = count($roster);
    $daysInCycle    = !empty($roster) ? $roster[0]['days_in_month'] : cal_days_in_month(CAL_GREGORIAN, intval($month), intval($year));
    $avgPayout      = $totalHeadcount > 0 ? ($total_payout / $totalHeadcount) : 0;
    ?>

    <!-- Top Header & Actions -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(16, 185, 129, 0.1); color: #059669; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                <i class="fa fa-calculator"></i> Automated Compensation &amp; Disbursal Desk
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.4px;">
                Monthly Payroll &amp; Compensation Breakdown
            </h1>
            <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                Calculated dynamically via biometric GPS attendance, approved leaves, statutory EPF/ESI, and professional tax.
            </p>
        </div>

        <!-- Controls Toolbar -->
        <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">

            <!-- Calculation Mode Toggle -->
            <div class="payroll-mode-toggle">
                <a href="<?= base_url("hr/payroll?month={$month}&year={$year}&mode=full"); ?>" class="mode-pill <?= ($mode === 'full') ? 'active' : ''; ?>" title="Full Month Standard Cycle (30 Days)">
                    <i class="fa fa-calendar"></i> Full Month Cycle
                </a>
                <a href="<?= base_url("hr/payroll?month={$month}&year={$year}&mode=mtd"); ?>" class="mode-pill <?= ($mode === 'mtd') ? 'active' : ''; ?>" title="Month-To-Date Accrued (To Current Day)">
                    <i class="fa fa-clock-o"></i> MTD Accrued
                </a>
            </div>

            <!-- Month & Year Selector -->
            <form method="GET" action="<?= base_url('hr/payroll'); ?>" style="display: inline-flex; align-items: center; gap: 6px; margin: 0;">
                <input type="hidden" name="mode" value="<?= html_escape($mode); ?>">
                <select name="month" class="form-control" onchange="this.form.submit()" style="height: 38px; border-radius: 8px; font-size: 13px; font-weight: 700; color: #0f172a; border: 1px solid #cbd5e1;">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= sprintf('%02d', $m); ?>" <?= intval($month) == $m ? 'selected' : ''; ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 10)); ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <select name="year" class="form-control" onchange="this.form.submit()" style="height: 38px; border-radius: 8px; font-size: 13px; font-weight: 700; color: #0f172a; border: 1px solid #cbd5e1;">
                    <?php for ($y = date('Y') - 1; $y <= date('Y') + 1; $y++): ?>
                        <option value="<?= $y; ?>" <?= intval($year) == $y ? 'selected' : ''; ?>>
                            <?= $y; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </form>

            <!-- Export CSV -->
            <button type="button" class="btn btn-default" onclick="exportPayrollCSV()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0284c7; font-weight: 700; border-radius: 10px; padding: 9px 15px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-download"></i> Export CSV
            </button>

            <!-- Print Sheet -->
            <button type="button" class="btn btn-default" onclick="window.print()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 10px; padding: 9px 15px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-print"></i> Print Sheet
            </button>
        </div>
    </div>

    <!-- Executive Financial Summary Banner -->
    <div class="payroll-kpi-banner">
        <div class="row" style="align-items: center;">
            <div class="col-md-5 col-sm-12" style="margin-bottom: 12px;">
                <span style="font-size: 12px; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px;">
                    Total Monthly Disbursal &bull; <?= $monthName; ?>
                </span>
                <div style="font-size: 38px; font-weight: 900; color: #34d399; margin-top: 4px; line-height: 1.1;">
                    ₹<?= number_format($total_payout, 2); ?>
                </div>
                <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 6px;">
                    <i class="fa fa-check-circle" style="color: #2dd4bf;"></i>
                    Mode: <strong><?= ($mode === 'full') ? 'Full Month Standard Disbursal' : 'Month-To-Date Accrued Pro-Rata'; ?></strong>
                </small>
            </div>

            <div class="col-md-7 col-sm-12">
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                    <div class="stat-badge-card">
                        <small style="color: #94a3b8; font-size: 10.5px; font-weight: 700; text-transform: uppercase;">Staff Count</small>
                        <div style="font-size: 20px; font-weight: 800; color: #ffffff; margin-top: 2px;"><?= $totalHeadcount; ?></div>
                        <span style="font-size: 11px; color: #2dd4bf;">Active</span>
                    </div>

                    <div class="stat-badge-card">
                        <small style="color: #94a3b8; font-size: 10.5px; font-weight: 700; text-transform: uppercase;">Gross Earnings</small>
                        <div style="font-size: 20px; font-weight: 800; color: #38bdf8; margin-top: 2px;">₹<?= number_format($total_gross); ?></div>
                        <span style="font-size: 11px; color: #94a3b8;">Before ded.</span>
                    </div>

                    <div class="stat-badge-card">
                        <small style="color: #94a3b8; font-size: 10.5px; font-weight: 700; text-transform: uppercase;">Total Deductions</small>
                        <div style="font-size: 20px; font-weight: 800; color: #f43f5e; margin-top: 2px;">₹<?= number_format($total_deductions_all); ?></div>
                        <span style="font-size: 11px; color: #fda4af;">PF/ESI/PT</span>
                    </div>

                    <div class="stat-badge-card">
                        <small style="color: #94a3b8; font-size: 10.5px; font-weight: 700; text-transform: uppercase;">Days in Cycle</small>
                        <div style="font-size: 20px; font-weight: 800; color: #fbbf24; margin-top: 2px;"><?= $daysInCycle; ?> d</div>
                        <span style="font-size: 11px; color: #94a3b8;">Calendar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payroll Computation Table Card -->
    <div class="payroll-table-card">
        <div class="payroll-card-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></div>
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                    Salary Computation Sheet &bull; <?= $monthName; ?>
                </h3>
            </div>

            <!-- Instant Search -->
            <div style="position: relative; min-width: 280px;">
                <i class="fa fa-search" style="position: absolute; left: 12px; top: 11px; color: #94a3b8; font-size: 13px;"></i>
                <input type="text" id="payrollSearchInput" class="form-control" placeholder="Search staff name, code, designation..." style="padding-left: 34px; height: 38px; border-radius: 10px; font-size: 12.5px; border: 1px solid #cbd5e1;">
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="payroll-main-table" id="payrollTable">
                <thead>
                    <tr>
                        <th>Staff Member</th>
                        <th>Monthly Base CTC</th>
                        <th>Attendance &amp; Paid Days</th>
                        <th>Gross Earnings</th>
                        <th>Statutory Deductions</th>
                        <th>Net Disbursable Salary</th>
                        <th style="text-align: right;">Action / Payslip</th>
                    </tr>
                </thead>
                <tbody id="payrollTbody">
                    <?php if (!empty($roster)): ?>
                        <?php foreach ($roster as $r): 
                            $initials = strtoupper(substr($r['name'], 0, 1));
                            $payableRatio = ($r['days_in_month'] > 0) ? min(100, round(($r['payable_days'] / $r['days_in_month']) * 100)) : 100;
                            $rJson = htmlspecialchars(json_encode($r), ENT_QUOTES, 'UTF-8');
                        ?>
                        <tr class="payroll-row" data-json='<?= $rJson; ?>'>
                            <!-- Staff Member -->
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar-sq">
                                        <?= $initials; ?>
                                    </div>
                                    <div>
                                        <div class="staff-name-text">
                                            <?= html_escape($r['name']); ?>
                                        </div>
                                        <div class="staff-role-badge">
                                            <span style="color: #0284c7; font-weight: 700;"><?= html_escape($r['staff_code']); ?></span>
                                            &bull; <?= strtoupper(html_escape($r['role'])); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Monthly Base CTC -->
                            <td>
                                <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                    ₹<?= number_format($r['base_salary'], 2); ?>
                                </div>
                                <div style="font-size: 11px; color: #64748b;">
                                    Basic: ₹<?= number_format($r['basic_salary']); ?> &bull; HRA: ₹<?= number_format($r['hra']); ?>
                                </div>
                            </td>

                            <!-- Attendance & Days -->
                            <td>
                                <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                    <span style="background: #ecfdf5; color: #059669; font-weight: 800; font-size: 11.5px; padding: 2px 7px; border-radius: 6px;" title="Present days">
                                        <?= $r['present_days']; ?>d Present
                                    </span>
                                    <?php if ($r['late_days'] > 0): ?>
                                        <span style="background: #fffbeb; color: #d97706; font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 6px;" title="Late marks">
                                            <?= $r['late_days']; ?> Late
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($r['half_days'] > 0): ?>
                                        <span style="background: #ffedd5; color: #c2410c; font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 6px;" title="Half days">
                                            <?= $r['half_days']; ?> Half
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($r['approved_leaves'] > 0): ?>
                                        <span style="background: #f1f5f9; color: #475569; font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 6px;" title="Approved paid leaves">
                                            <?= $r['approved_leaves']; ?>d Leave
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div style="margin-top: 4px; font-size: 11.5px; color: #0284c7; font-weight: 700;">
                                    Paid: <?= $r['payable_days']; ?> / <?= $r['days_in_month']; ?> Days (<?= $payableRatio; ?>%)
                                </div>
                            </td>

                            <!-- Gross Earnings -->
                            <td>
                                <strong style="color: #0f172a; font-size: 14px;">
                                    ₹<?= number_format($r['gross_earned'], 2); ?>
                                </strong>
                                <small style="display: block; color: #94a3b8; font-size: 11px;">
                                    pro-rata earned
                                </small>
                            </td>

                            <!-- Statutory Deductions -->
                            <td>
                                <strong style="color: #e11d48; font-size: 13.5px;">
                                    -₹<?= number_format($r['total_deductions'], 2); ?>
                                </strong>
                                <div style="font-size: 11px; color: #64748b;" title="PF: ₹<?= number_format($r['pf_deduction']); ?> | PT: ₹<?= number_format($r['pt_deduction']); ?> | Late: ₹<?= number_format($r['late_penalty']); ?>">
                                    PF: ₹<?= number_format($r['pf_deduction']); ?> &bull; PT: ₹<?= number_format($r['pt_deduction']); ?>
                                </div>
                            </td>

                            <!-- Net Disbursable Salary & Payment Transfer Status -->
                            <td>
                                <div style="font-size: 16px; font-weight: 900; color: #0f172a; line-height: 1.2;">
                                    ₹<?= number_format($r['net_salary'], 2); ?>
                                </div>
                                <div id="rowStatusWrap-<?= $r['user_id']; ?>">
                                    <?php if (($r['transfer_status'] ?? '') === 'transferred'): ?>
                                        <span class="transfer-status-pill pill-transferred" title="Salary payment transferred and verified">
                                            <i class="fa fa-check-circle"></i> Transferred
                                        </span>
                                        <?php if (!empty($r['txn_ref'])): ?>
                                            <div style="font-size: 10px; font-family: monospace; color: #059669; font-weight: 700; margin-top: 2px;">
                                                <?= html_escape($r['txn_ref']); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php elseif (($r['transfer_status'] ?? '') === 'on_hold'): ?>
                                        <span class="transfer-status-pill pill-on-hold" title="Disbursal payment currently on hold">
                                            <i class="fa fa-pause-circle"></i> On Hold
                                        </span>
                                    <?php else: ?>
                                        <span class="transfer-status-pill pill-pending" title="Payment pending bank transfer">
                                            <i class="fa fa-clock-o"></i> Transfer Pending
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Action Button -->
                            <td style="text-align: right; white-space: nowrap;">
                                <button type="button" class="btn-view-slip" onclick="openPayslipModal(this)" title="Open comprehensive salary slip and payment details">
                                    <i class="fa fa-file-text-o"></i> View Breakdown
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 48px 20px;">
                                <i class="fa fa-calculator" style="font-size: 32px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                                <strong style="font-size: 14px; color: #475569;">No payroll calculations available for <?= $monthName; ?></strong>
                                <p style="font-size: 12.5px; color: #94a3b8; margin: 4px 0 0 0;">Check attendance roster records or switch to another month.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Interactive Pagination Controls -->
        <div class="payroll-pagination-bar">
            <div style="font-size: 12.5px; color: #64748b; font-weight: 600;" id="payrollPaginationSummary">
                Showing 1 to <?= count($roster); ?> of <?= count($roster); ?> payroll records
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: #64748b; font-weight: 600; margin-right: 12px;">
                    <span>Rows:</span>
                    <select id="payrollPageSizeSelect" class="form-control input-sm" style="width: 75px; border-radius: 8px; font-size: 12px; height: 30px;" onchange="changePayrollPageSize()">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="all">All</option>
                    </select>
                </div>
                <div id="payrollPaginationButtons" style="display: inline-flex; gap: 4px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL: COMPREHENSIVE SALARY SLIP & BREAKDOWN ================= -->
<div class="modal fade" id="payslipModal" tabindex="-1" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog" role="document" style="max-width: 680px; margin-top: 40px;">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.2);">
            
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center;">
                <h4 class="modal-title" style="font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px; margin: 0; color: #ffffff;">
                    <i class="fa fa-file-text-o" style="color: #2dd4bf;"></i> Employee Compensation Breakdown &amp; Payslip
                </h4>
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
            </div>

            <div class="modal-body" id="printablePayslipContent" style="padding: 24px;">

                <!-- Letterhead -->
                <div class="payslip-letterhead">
                    <div>
                        <h3 style="font-size: 18px; font-weight: 900; color: #0f172a; margin: 0 0 2px;">
                            UPCHAR HEALTHCARE ENTERPRISE
                        </h3>
                        <div style="font-size: 11px; color: #64748b;">
                            Lucknow Central Command &bull; CIN: U85110UP2026PTC109823
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <span style="background: #ecfdf5; color: #059669; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 12px; border: 1px solid #a7f3d0; text-transform: uppercase;">
                            Payslip for <?= $monthName; ?>
                        </span>
                        <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                            Generated on <?= date('d M Y'); ?>
                        </div>
                    </div>
                </div>

                <!-- Payment Transfer Status Hero Banner -->
                <div class="ps-transfer-card state-transferred" id="psTransferCard">
                    <div class="ps-transfer-header">
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <span class="ps-transfer-tag" id="psTransferBadge">
                                <i class="fa fa-check-circle"></i> PAYMENT TRANSFERRED
                            </span>
                            <span id="psTransferSubtext" style="font-size: 12px; font-weight: 700; color: #334155;"></span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-xs" id="btnToggleTransferPanel" onclick="toggleTransferUpdatePanel()" style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 6px; font-weight: 800; font-size: 11px; padding: 4px 10px; color: #0284c7; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <i class="fa fa-pencil"></i> Update Payment Status
                            </button>
                        </div>
                    </div>
                    <div class="ps-transfer-grid">
                        <div class="ps-transfer-cell">
                            <small><i class="fa fa-barcode"></i> Transaction UTR / Ref</small>
                            <div id="psTxnRef" style="font-family: monospace; font-size: 13px;">-</div>
                        </div>
                        <div class="ps-transfer-cell">
                            <small><i class="fa fa-university"></i> Payment Channel / Mode</small>
                            <div id="psChannel">-</div>
                        </div>
                        <div class="ps-transfer-cell">
                            <small><i class="fa fa-clock-o"></i> Transfer Timestamp</small>
                            <div id="psTransferredAt">-</div>
                        </div>
                    </div>
                    <div id="psNotesRow" style="margin-top: 8px; font-size: 12px; color: #475569; display: none; background: #ffffff; padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <strong style="color: #0f172a;"><i class="fa fa-sticky-note-o"></i> Disbursal Remarks:</strong> <span id="psNotesText"></span>
                    </div>
                </div>

                <!-- Staff & Banking Dossier Grid -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; margin-bottom: 16px;">
                    <div class="row">
                        <div class="col-xs-6" style="margin-bottom: 8px;">
                            <small style="font-size: 10.5px; color: #64748b; text-transform: uppercase; font-weight: 700;">Employee Name</small>
                            <div id="psStaffName" style="font-weight: 800; color: #0f172a; font-size: 13.5px;"></div>
                        </div>
                        <div class="col-xs-6" style="margin-bottom: 8px;">
                            <small style="font-size: 10.5px; color: #64748b; text-transform: uppercase; font-weight: 700;">Employee Code / Role</small>
                            <div id="psStaffCode" style="font-weight: 800; color: #0284c7; font-size: 13.5px;"></div>
                        </div>
                        <div class="col-xs-6">
                            <small style="font-size: 10.5px; color: #64748b; text-transform: uppercase; font-weight: 700;">Department / Designation</small>
                            <div id="psDept" style="font-weight: 600; color: #334155; font-size: 12px;"></div>
                        </div>
                        <div class="col-xs-6">
                            <small style="font-size: 10.5px; color: #64748b; text-transform: uppercase; font-weight: 700;">Disbursal Account</small>
                            <div id="psBankAcc" style="font-family: monospace; font-weight: 700; color: #334155; font-size: 12px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Days Metric Strip -->
                <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; margin-bottom: 16px; text-align: center;">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px;">
                        <small style="font-size: 10px; color: #64748b; text-transform: uppercase;">Days in Month</small>
                        <div id="psDaysMonth" style="font-weight: 800; color: #0f172a; font-size: 13px;">30</div>
                    </div>
                    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 6px;">
                        <small style="font-size: 10px; color: #059669; text-transform: uppercase;">Present</small>
                        <div id="psPresentDays" style="font-weight: 800; color: #059669; font-size: 13px;"></div>
                    </div>
                    <div style="background: #e0f2fe; border: 1px solid #bae6fd; border-radius: 8px; padding: 6px;">
                        <small style="font-size: 10px; color: #0284c7; text-transform: uppercase;">Approved Leaves</small>
                        <div id="psLeaves" style="font-weight: 800; color: #0284c7; font-size: 13px;"></div>
                    </div>
                    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 6px;">
                        <small style="font-size: 10px; color: #d97706; text-transform: uppercase;">Half Days</small>
                        <div id="psHalfDays" style="font-weight: 800; color: #d97706; font-size: 13px;"></div>
                    </div>
                    <div style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 6px;">
                        <small style="font-size: 10px; color: #475569; text-transform: uppercase;">Paid Days</small>
                        <div id="psPayableDays" style="font-weight: 800; color: #0f172a; font-size: 13px;"></div>
                    </div>
                </div>

                <!-- Ledger Grid: Earnings vs Deductions -->
                <div class="payslip-ledger-box">
                    <div class="ledger-grid">
                        <!-- LEFT: Earnings -->
                        <div style="border-right: 1px solid #e2e8f0;">
                            <div class="ledger-col-header" style="color: #059669;">
                                <i class="fa fa-plus-circle"></i> Earnings (Allowances)
                            </div>
                            <div class="ledger-line">
                                <span>Basic Salary (50%)</span>
                                <strong id="psEarnedBasic">₹0.00</strong>
                            </div>
                            <div class="ledger-line">
                                <span>House Rent Allowance (HRA)</span>
                                <strong id="psEarnedHra">₹0.00</strong>
                            </div>
                            <div class="ledger-line">
                                <span>Conveyance &amp; Special Allowance</span>
                                <strong id="psEarnedSpecial">₹0.00</strong>
                            </div>
                            <div class="ledger-line">
                                <span>Medical Allowance</span>
                                <strong id="psEarnedMedical">₹0.00</strong>
                            </div>
                            <div class="ledger-line total-line" style="color: #059669;">
                                <span>Total Gross Earnings</span>
                                <span id="psGrossEarned" style="font-size: 13.5px;">₹0.00</span>
                            </div>
                        </div>

                        <!-- RIGHT: Deductions -->
                        <div>
                            <div class="ledger-col-header" style="color: #e11d48;">
                                <i class="fa fa-minus-circle"></i> Statutory &amp; Policy Deductions
                            </div>
                            <div class="ledger-line">
                                <span>Provident Fund (EPF @ 12%)</span>
                                <strong id="psPfDed" style="color: #e11d48;">₹0.00</strong>
                            </div>
                            <div class="ledger-line">
                                <span>Employee State Insurance (ESI)</span>
                                <strong id="psEsiDed" style="color: #e11d48;">₹0.00</strong>
                            </div>
                            <div class="ledger-line">
                                <span>Professional Tax (PT)</span>
                                <strong id="psPtDed" style="color: #e11d48;">₹0.00</strong>
                            </div>
                            <div class="ledger-line">
                                <span>Late Mark Penalty</span>
                                <strong id="psLatePenalty" style="color: #e11d48;">₹0.00</strong>
                            </div>
                            <div class="ledger-line total-line" style="color: #e11d48;">
                                <span>Total Deductions</span>
                                <span id="psTotalDed" style="font-size: 13.5px;">₹0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Net Take-Home Salary Ribbon -->
                <div class="net-salary-highlight">
                    <div>
                        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">
                            Net Disbursable Take-Home Pay
                        </div>
                        <div id="psNetSalaryWords" style="font-size: 11.5px; opacity: 0.9; margin-top: 2px;"></div>
                    </div>
                    <div id="psNetSalaryAmount" style="font-size: 26px; font-weight: 900; letter-spacing: -0.5px;">
                        ₹0.00
                    </div>
                </div>

                <!-- Inline Payment Transfer Status Editor Form (Collapsible) -->
                <div class="ps-status-manager" id="psStatusManager" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                        <strong style="font-size: 13.5px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-sliders" style="color: #00a896;"></i> Update Payment Transfer Status &amp; Bank UTR
                        </strong>
                        <button type="button" class="close" onclick="toggleTransferUpdatePanel(false)" style="font-size: 20px; line-height: 1;">&times;</button>
                    </div>
                    <div class="row">
                        <div class="col-sm-4" style="margin-bottom: 10px;">
                            <label style="font-size: 11px; color: #475569; font-weight: 700; text-transform: uppercase;">Payment Transfer Status</label>
                            <select id="editTransferStatus" class="form-control" style="border-radius: 8px; font-size: 12.5px; font-weight: 700; height: 38px;" onchange="onStatusSelectChanged()">
                                <option value="transferred">🟢 Transferred / Paid</option>
                                <option value="pending">🟡 Pending (Not Transferred)</option>
                                <option value="on_hold">🔴 On Hold (Suspended)</option>
                            </select>
                        </div>
                        <div class="col-sm-4" style="margin-bottom: 10px;">
                            <label style="font-size: 11px; color: #475569; font-weight: 700; text-transform: uppercase;">Payment Channel / Bank</label>
                            <select id="editPaymentChannel" class="form-control" style="border-radius: 8px; font-size: 12px; height: 38px;">
                                <option value="Corporate NetBanking (HDFC Direct)">Corporate NetBanking (HDFC Direct)</option>
                                <option value="Instant IMPS (ICICI Portal)">Instant IMPS (ICICI Portal)</option>
                                <option value="RTGS Real-Time Settlement">RTGS Real-Time Settlement</option>
                                <option value="Corporate Salary NEFT">Corporate Salary NEFT</option>
                                <option value="UPI Business Gateway">UPI Business Gateway</option>
                                <option value="Company Payroll Cheque / Manual">Company Payroll Cheque / Manual</option>
                            </select>
                        </div>
                        <div class="col-sm-4" style="margin-bottom: 10px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <label style="font-size: 11px; color: #475569; font-weight: 700; text-transform: uppercase; margin: 0;">UTR / Transaction Ref</label>
                                <a href="javascript:void(0)" onclick="generateSampleUTR()" style="font-size: 11px; color: #0284c7; font-weight: 700;">Auto UTR</a>
                            </div>
                            <input type="text" id="editTxnRef" class="form-control" placeholder="e.g. NEFT-20260914-9988" style="border-radius: 8px; font-family: monospace; font-size: 12.5px; height: 38px;">
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 10px;">
                            <label style="font-size: 11px; color: #475569; font-weight: 700; text-transform: uppercase;">Disbursal Notes / Remarks</label>
                            <input type="text" id="editDisbursalNotes" class="form-control" placeholder="e.g. Monthly salary payout approved by HR and Accounts Department" style="border-radius: 8px; font-size: 12.5px; height: 38px;">
                        </div>
                    </div>
                    <div style="text-align: right; margin-top: 6px;">
                        <button type="button" class="btn btn-default" onclick="toggleTransferUpdatePanel(false)" style="border-radius: 8px; font-weight: 700; font-size: 12px; margin-right: 6px;">
                            Cancel
                        </button>
                        <button type="button" class="btn" id="btnSaveTransferStatus" onclick="saveDisbursalStatus()" style="background: #00a896; color: #ffffff; font-weight: 800; border-radius: 8px; font-size: 12.5px;">
                            <i class="fa fa-check"></i> Save Transfer Status
                        </button>
                    </div>
                </div>

            </div>

            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" onclick="printPayslipOnly()" style="border-radius: 8px; font-weight: 700; font-size: 12.5px;">
                    <i class="fa fa-print"></i> Print Payslip
                </button>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700; font-size: 12.5px;">Close</button>
                    <button type="button" class="btn" id="btnDisburseModal" onclick="toggleTransferUpdatePanel(true)" style="background: #00a896; color: #ffffff; font-weight: 800; border-radius: 8px; font-size: 12.5px;">
                        <i class="fa fa-credit-card"></i> Update Payment Transfer Status
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Payroll Floating Toast Notification -->
<div id="payrollToast">
    <i class="fa fa-check-circle" style="color: #2dd4bf; font-size: 16px;"></i>
    <span id="payrollToastMsg">Payment transfer status updated successfully!</span>
</div>

<script>
// Format Indian Currency
function formatINR(val) {
    return '₹' + parseFloat(val).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Convert Number to Words (Indian Numbering)
function numberToWordsINR(num) {
    var a = ['', 'One ', 'Two ', 'Three ', 'Four ', 'Five ', 'Six ', 'Seven ', 'Eight ', 'Nine ', 'Ten ', 'Eleven ', 'Twelve ', 'Thirteen ', 'Fourteen ', 'Fifteen ', 'Sixteen ', 'Seventeen ', 'Eighteen ', 'Nineteen '];
    var b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
    var n = ('000000000' + Math.floor(num)).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return '';
    var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
    return str ? (str.trim() + ' Rupees Only') : 'Zero Rupees';
}

var currentActiveRowData = null;

// Render Payment Transfer Status in Modal Hero Banner
function renderModalTransferStatus(data) {
    var card = $('#psTransferCard');
    var badge = $('#psTransferBadge');
    var subtext = $('#psTransferSubtext');
    var txnEl = $('#psTxnRef');
    var chEl = $('#psChannel');
    var timeEl = $('#psTransferredAt');
    var notesRow = $('#psNotesRow');
    var notesText = $('#psNotesText');

    card.removeClass('state-transferred state-pending state-on_hold');

    var status = data.transfer_status || 'pending';
    card.addClass('state-' + status);

    if (status === 'transferred') {
        badge.html('<i class="fa fa-check-circle"></i> PAYMENT TRANSFERRED / DISBURSED');
        subtext.text('Funds successfully credited to employee bank account');
        txnEl.text(data.txn_ref || 'CONFIRMED').css('color', '#059669');
        timeEl.text(data.transferred_at || 'Completed');
    } else if (status === 'on_hold') {
        badge.html('<i class="fa fa-pause-circle"></i> PAYMENT ON HOLD');
        subtext.text('Payout temporarily halted by Management / HR');
        txnEl.text(data.txn_ref || 'Suspended').css('color', '#e11d48');
        timeEl.text('Disbursal Suspended');
    } else {
        badge.html('<i class="fa fa-clock-o"></i> PAYMENT NOT TRANSFERRED (PENDING)');
        subtext.text('Awaiting payroll clearance & bank authorization');
        txnEl.text('Pending Generation').css('color', '#b45309');
        timeEl.text('Pending Authorization');
    }

    chEl.text(data.payment_channel || 'Corporate NetBanking (HDFC Direct)');

    if (data.disbursal_notes && data.disbursal_notes.trim() !== '') {
        notesText.text(data.disbursal_notes);
        notesRow.show();
    } else {
        notesRow.hide();
    }

    // Pre-populate form values
    $('#editTransferStatus').val(status);
    $('#editPaymentChannel').val(data.payment_channel || 'Corporate NetBanking (HDFC Direct)');
    $('#editTxnRef').val(data.txn_ref || '');
    $('#editDisbursalNotes').val(data.disbursal_notes || '');
}

// Toggle Inline Transfer Update Panel
function toggleTransferUpdatePanel(forceShow) {
    var panel = $('#psStatusManager');
    if (forceShow === true) {
        panel.slideDown(200);
        panel[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else if (forceShow === false) {
        panel.slideUp(200);
    } else {
        panel.slideToggle(200);
    }
}

// Auto generate UTR
function generateSampleUTR() {
    var prefix = ($('#editPaymentChannel').val().indexOf('IMPS') > -1) ? 'IMPS-' : 'NEFT-';
    var d = new Date();
    var ymd = d.getFullYear() + String(d.getMonth() + 1).padStart(2, '0') + String(d.getDate()).padStart(2, '0');
    var rnd = Math.floor(1000 + Math.random() * 9000);
    $('#editTxnRef').val(prefix + ymd + '-' + rnd);
}

// When status dropdown changes
function onStatusSelectChanged() {
    var status = $('#editTransferStatus').val();
    if (status === 'transferred' && !$('#editTxnRef').val().trim()) {
        generateSampleUTR();
    } else if (status === 'pending') {
        $('#editTxnRef').val('');
    }
}

// Save Disbursal Transfer Status (AJAX)
function saveDisbursalStatus() {
    if (!currentActiveRowData) return;

    var status  = $('#editTransferStatus').val();
    var txnRef  = $('#editTxnRef').val().trim();
    var channel = $('#editPaymentChannel').val();
    var notes   = $('#editDisbursalNotes').val().trim();

    if (status === 'transferred' && !txnRef) {
        generateSampleUTR();
        txnRef = $('#editTxnRef').val().trim();
    }

    var btn = $('#btnSaveTransferStatus');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    $.post('<?= base_url("hr/process_disbursal"); ?>', {
        user_id: currentActiveRowData.user_id,
        month: '<?= $month; ?>',
        year: '<?= $year; ?>',
        amount: currentActiveRowData.net_salary,
        status: status,
        txn_ref: txnRef,
        channel: channel,
        notes: notes,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
    }, function(res) {
        if (typeof res === 'string') {
            try { res = JSON.parse(res); } catch(e) {}
        }
        btn.prop('disabled', false).html('<i class="fa fa-check"></i> Save Transfer Status');

        // Update in-memory data
        currentActiveRowData.transfer_status  = res.transfer_status;
        currentActiveRowData.payment_status   = res.payment_status;
        currentActiveRowData.txn_ref          = res.txn_ref;
        currentActiveRowData.payment_channel  = res.channel;
        currentActiveRowData.transferred_at   = res.transferred_at;
        currentActiveRowData.disbursal_notes  = res.notes;

        // Update DOM row
        var allRows = $('tr.payroll-row');
        allRows.each(function() {
            var rowObj = $(this);
            var d = rowObj.data('json');
            if (d && d.user_id == currentActiveRowData.user_id) {
                rowObj.data('json', currentActiveRowData);
                rowObj.attr('data-json', JSON.stringify(currentActiveRowData));
                updateRowStatusPill(currentActiveRowData.user_id, currentActiveRowData.transfer_status, currentActiveRowData.txn_ref);
            }
        });

        // Update Modal view
        renderModalTransferStatus(currentActiveRowData);
        $('#psStatusManager').slideUp(200);

        // Show Toast
        showPayrollToast(res.message);
    }).fail(function() {
        btn.prop('disabled', false).html('<i class="fa fa-check"></i> Save Transfer Status');
        alert('Server communication error. Please try again.');
    });
}

// Update Table Row Status Pill
function updateRowStatusPill(userId, status, txnRef) {
    var wrap = $('#rowStatusWrap-' + userId);
    if (!wrap.length) return;

    var html = '';
    if (status === 'transferred') {
        html = '<span class="transfer-status-pill pill-transferred" title="Salary payment transferred and verified"><i class="fa fa-check-circle"></i> Transferred</span>';
        if (txnRef) {
            html += '<div style="font-size: 10px; font-family: monospace; color: #059669; font-weight: 700; margin-top: 2px;">' + $('<div>').text(txnRef).html() + '</div>';
        }
    } else if (status === 'on_hold') {
        html = '<span class="transfer-status-pill pill-on-hold" title="Disbursal payment currently on hold"><i class="fa fa-pause-circle"></i> On Hold</span>';
    } else {
        html = '<span class="transfer-status-pill pill-pending" title="Payment pending bank transfer"><i class="fa fa-clock-o"></i> Transfer Pending</span>';
    }
    wrap.html(html);
}

// Show Toast Notification
function showPayrollToast(msg) {
    var toast = $('#payrollToast');
    $('#payrollToastMsg').text(msg);
    toast.fadeIn(200);
    setTimeout(function() {
        toast.fadeOut(300);
    }, 4500);
}

// Open Payslip Modal
function openPayslipModal(btn) {
    var tr = $(btn).closest('tr.payroll-row');
    var data = tr.data('json');
    currentActiveRowData = data;

    $('#psStaffName').text(data.name);
    $('#psStaffCode').text(data.staff_code + ' • ' + (data.role || '').toUpperCase());
    $('#psDept').text((data.department || 'Operations') + ' / ' + (data.designation || 'Staff'));
    $('#psBankAcc').text(data.bank_name + ' • ' + data.account_no + ' (' + data.ifsc_code + ')');

    $('#psDaysMonth').text(data.days_in_month);
    $('#psPresentDays').text(data.present_days + ' d');
    $('#psLeaves').text(data.approved_leaves + ' d');
    $('#psHalfDays').text(data.half_days + ' d');
    $('#psPayableDays').text(data.payable_days + ' d');

    // Earnings
    $('#psEarnedBasic').text(formatINR(data.earned_basic));
    $('#psEarnedHra').text(formatINR(data.earned_hra));
    $('#psEarnedSpecial').text(formatINR(data.earned_special));
    $('#psEarnedMedical').text(formatINR(data.earned_medical));
    $('#psGrossEarned').text(formatINR(data.gross_earned));

    // Deductions
    $('#psPfDed').text('-' + formatINR(data.pf_deduction));
    $('#psEsiDed').text('-' + formatINR(data.esi_deduction));
    $('#psPtDed').text('-' + formatINR(data.pt_deduction));
    $('#psLatePenalty').text('-' + formatINR(data.late_penalty));
    $('#psTotalDed').text('-' + formatINR(data.total_deductions));

    // Net
    $('#psNetSalaryAmount').text(formatINR(data.net_salary));
    $('#psNetSalaryWords').text(numberToWordsINR(data.net_salary));

    // Payment Transfer Status Hero Banner
    renderModalTransferStatus(data);
    $('#psStatusManager').hide();

    $('#payslipModal').modal('show');
}

// Print Payslip Container
function printPayslipOnly() {
    var content = document.getElementById('printablePayslipContent').innerHTML;
    var printWin = window.open('', '', 'width=800,height=900');
    printWin.document.write('<html><head><title>Payslip - ' + currentActiveRowData.name + '</title>');
    printWin.document.write('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap">');
    printWin.document.write('<style>body{font-family:"Plus Jakarta Sans", sans-serif; padding: 24px; color:#0f172a;} .payslip-letterhead{border-bottom:2px solid #00a896; padding-bottom:14px; margin-bottom:16px; display:flex; justify-content:space-between;} .payslip-ledger-box{border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; margin-bottom:16px;} .ledger-grid{display:grid; grid-template-columns:1fr 1fr;} .ledger-col-header{background:#f8fafc; padding:10px 14px; font-weight:800; font-size:11.5px;} .ledger-line{display:flex; justify-content:space-between; padding:8px 14px; font-size:12px; border-bottom:1px solid #f1f5f9;} .total-line{background:#f8fafc; font-weight:800; border-top:1px solid #e2e8f0;} .net-salary-highlight{background:#059669; color:#fff; border-radius:12px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;} .ps-transfer-card{border-radius:12px; padding:14px 18px; margin-bottom:16px;} .ps-transfer-card.state-transferred{background:#f0fdf4; border:1.5px solid #86efac;} .ps-transfer-card.state-pending{background:#fffbeb; border:1.5px solid #fde68a;} .ps-transfer-card.state-on_hold{background:#fff1f2; border:1.5px solid #fecdd3;} .ps-transfer-header{display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;} .ps-transfer-tag{font-size:11px; font-weight:800; padding:4px 10px; border-radius:20px; display:inline-flex; align-items:center; gap:6px; text-transform:uppercase;} .state-transferred .ps-transfer-tag{background:#059669; color:#fff;} .state-pending .ps-transfer-tag{background:#d97706; color:#fff;} .state-on_hold .ps-transfer-tag{background:#e11d48; color:#fff;} .ps-transfer-grid{display:grid; grid-template-columns:repeat(3, 1fr); gap:10px;} .ps-transfer-cell{background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:8px 12px;} .ps-transfer-cell small{font-size:10px; color:#64748b; font-weight:700; text-transform:uppercase; display:block; margin-bottom:2px;} .ps-transfer-cell div{font-size:12px; font-weight:800; color:#0f172a;} button, .ps-status-manager, #btnToggleTransferPanel { display: none !important; }</style>');
    printWin.document.write('</head><body>');
    printWin.document.write(content);
    printWin.document.write('</body></html>');
    printWin.document.close();
    printWin.focus();
    setTimeout(function() {
        printWin.print();
        printWin.close();
    }, 400);
}

// Pagination Logic
var currentPayrollPage = 1;
var payrollPageSize = 25;

function getActivePayrollRows() {
    var allRows = Array.from(document.querySelectorAll('#payrollTable tbody tr.payroll-row'));
    return allRows.filter(function(r) {
        return r.dataset.matched !== 'false';
    });
}

function renderPayrollPagination() {
    var rows = getActivePayrollRows();
    var total = rows.length;
    var actualSize = (payrollPageSize === 'all') ? total : parseInt(payrollPageSize);
    var totalPages = (payrollPageSize === 'all' || total === 0) ? 1 : Math.ceil(total / actualSize);

    if (currentPayrollPage > totalPages) currentPayrollPage = totalPages;
    if (currentPayrollPage < 1) currentPayrollPage = 1;

    var start = (currentPayrollPage - 1) * actualSize;
    var end   = start + actualSize;

    document.querySelectorAll('#payrollTable tbody tr.payroll-row').forEach(function(r) {
        r.style.display = 'none';
    });

    rows.forEach(function(r, idx) {
        if (payrollPageSize === 'all' || (idx >= start && idx < end)) {
            r.style.display = '';
        }
    });

    var showingStart = (total === 0) ? 0 : start + 1;
    var showingEnd   = (payrollPageSize === 'all' || end > total) ? total : end;
    $('#payrollPaginationSummary').text('Showing ' + showingStart + ' to ' + showingEnd + ' of ' + total + ' payroll records');

    var btnHtml = '';
    if (totalPages > 1) {
        btnHtml += '<button type="button" class="btn btn-xs btn-default" ' + (currentPayrollPage === 1 ? 'disabled' : '') + ' onclick="gotoPayrollPage(' + (currentPayrollPage - 1) + ')" style="border-radius: 6px; font-weight: 700; padding: 4px 8px;"><i class="fa fa-angle-left"></i> Prev</button>';
        for (var p = 1; p <= totalPages; p++) {
            if (totalPages > 7 && Math.abs(p - currentPayrollPage) > 2 && p !== 1 && p !== totalPages) {
                if (p === 2 || p === totalPages - 1) btnHtml += '<span style="padding: 2px 5px; color: #94a3b8;">...</span>';
                continue;
            }
            var isActive = (p === currentPayrollPage);
            btnHtml += '<button type="button" class="btn btn-xs ' + (isActive ? 'btn-primary' : 'btn-default') + '" style="font-weight: 700; border-radius: 6px; min-width: 28px;' + (isActive ? 'background: #00a896; border-color: #00a896; color: #fff;' : '') + '" onclick="gotoPayrollPage(' + p + ')">' + p + '</button>';
        }
        btnHtml += '<button type="button" class="btn btn-xs btn-default" ' + (currentPayrollPage === totalPages ? 'disabled' : '') + ' onclick="gotoPayrollPage(' + (currentPayrollPage + 1) + ')" style="border-radius: 6px; font-weight: 700; padding: 4px 8px;">Next <i class="fa fa-angle-right"></i></button>';
    }
    $('#payrollPaginationButtons').html(btnHtml);
}

function gotoPayrollPage(p) {
    currentPayrollPage = p;
    renderPayrollPagination();
}

function changePayrollPageSize() {
    payrollPageSize = $('#payrollPageSizeSelect').val();
    currentPayrollPage = 1;
    renderPayrollPagination();
}

// Live Search
$(document).ready(function() {
    $('#payrollSearchInput').on('keyup', function() {
        var query = $(this).val().toLowerCase();
        var allRows = document.querySelectorAll('#payrollTable tbody tr.payroll-row');
        allRows.forEach(function(r) {
            var text = r.innerText.toLowerCase();
            r.dataset.matched = (text.indexOf(query) > -1) ? 'true' : 'false';
        });
        currentPayrollPage = 1;
        renderPayrollPagination();
    });

    renderPayrollPagination();
});

// Export CSV
function exportPayrollCSV() {
    var csv = [];
    var rows = document.querySelectorAll("#payrollTable tr");
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
    downloadLink.download = "Payroll_Report_<?= $month; ?>_<?= $year; ?>.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}
</script>
