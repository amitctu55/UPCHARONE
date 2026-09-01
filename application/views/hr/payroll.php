<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Automated Payroll &amp; Salary Computation
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Salaries computed automatically based on biometric/geofenced punch attendance and approved leaves.
        </p>
    </div>
    <div>
        <button type="button" class="btn" onclick="window.print()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 700; border-radius: 8px; padding: 8px 16px; font-size: 13px;">
            <i class="fa fa-print"></i> Export / Print Roster
        </button>
    </div>
</div>

<!-- Month Selector Bar -->
<div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
    <div>
        <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Payroll Month</span>
        <h4 style="margin: 2px 0 0; font-weight: 800; color: #0f172a;">
            <?=date('F Y', mktime(0, 0, 0, $month, 10, $year));?>
        </h4>
    </div>

    <div style="display: flex; align-items: center; gap: 18px;">
        <div style="text-align: right;">
            <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Total Monthly Payout</span>
            <div style="font-size: 24px; font-weight: 900; color: #15803d;">
                ₹<?=number_format($total_payout, 2);?>
            </div>
        </div>
    </div>
</div>

<!-- Payroll Table -->
<div class="hr-kpi-card" style="padding: 20px;">
    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11.5px; color: #64748b; text-transform: uppercase;">
                    <th>Staff Member</th>
                    <th>Base Salary</th>
                    <th>Present</th>
                    <th>Late Marks</th>
                    <th>Half Days</th>
                    <th>Leaves</th>
                    <th>Payable Days</th>
                    <th style="text-align: right;">Net Payable Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($roster)): ?>
                    <?php foreach ($roster as $r): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;"><?=html_escape($r['name']);?></div>
                            <small style="color: #64748b; font-family: monospace;"><?=$r['staff_code'];?> &bull; <?=strtoupper($r['role']);?></small>
                        </td>
                        <td>
                            <strong style="color: #334155;">₹<?=number_format($r['base_salary'], 2);?></strong>
                        </td>
                        <td>
                            <span class="badge" style="background: #dcfce7; color: #166534; font-weight: 700;">
                                <?=$r['present_days'];?> d
                            </span>
                        </td>
                        <td>
                            <span style="color: <?=$r['late_days']>0 ? '#d97706' : '#94a3b8';?>; font-weight: 600;">
                                <?=$r['late_days'];?>
                            </span>
                        </td>
                        <td>
                            <span style="color: <?=$r['half_days']>0 ? '#ef4444' : '#94a3b8';?>; font-weight: 600;">
                                <?=$r['half_days'];?>
                            </span>
                        </td>
                        <td>
                            <span class="badge" style="background: #f1f5f9; color: #475569;">
                                <?=$r['approved_leaves'];?> d
                            </span>
                        </td>
                        <td>
                            <strong style="color: #0284c7; font-size: 14px;">
                                <?=$r['payable_days'];?> / <?=$r['days_in_month'];?> d
                            </strong>
                        </td>
                        <td style="text-align: right;">
                            <div style="font-size: 16px; font-weight: 900; color: #15803d;">
                                ₹<?=number_format($r['net_salary'], 2);?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No payroll data available for this period.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
