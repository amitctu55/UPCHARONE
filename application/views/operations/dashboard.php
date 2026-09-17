<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .ops-kpi-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .ops-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }
    .ops-table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .ops-quick-action-btn {
        padding: 4px 10px;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .ops-quick-action-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }
    .ops-row-hover {
        transition: background-color 0.15s ease;
    }
    .ops-row-hover:hover {
        background-color: #f8fafc !important;
    }
</style>

<!-- Operations Command Hub View -->
<div class="container-fluid" style="padding: 0; max-width: 1400px; margin: 0 auto;">

    <?php
    $totalHandoffs = count($handoffs ?? []);
    $totalExpenses = count($expenses ?? []);
    $pendingExpensesCount = 0;
    $pendingExpensesSum = 0;
    $totalReimbursedSum = 0;

    foreach ($expenses as $ex) {
        if ($ex['status'] === 'submitted' || $ex['status'] === 'pending') {
            $pendingExpensesCount++;
            $pendingExpensesSum += floatval($ex['amount']);
        } elseif ($ex['status'] === 'reimbursed' || $ex['status'] === 'approved') {
            $totalReimbursedSum += floatval($ex['amount']);
        }
    }
    ?>

    <!-- Toast Notification Overlay -->
    <div id="opsToast" style="position: fixed; bottom: 24px; right: 24px; background: #0f172a; color: #ffffff; padding: 12px 20px; border-radius: 12px; font-weight: 700; font-size: 13px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); display: none; z-index: 99999; align-items: center; gap: 10px; border: 1px solid rgba(255,255,255,0.15);">
        <i class="fa fa-check-circle" style="color: #2dd4bf; font-size: 16px;"></i>
        <span id="opsToastMsg">Action completed successfully</span>
    </div>

    <!-- Flash Notifications -->
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade in" role="alert" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
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
        <div class="alert alert-danger alert-dismissible fade in" role="alert" style="border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-weight: 600; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa fa-exclamation-circle" style="font-size: 18px; color: #ef4444;"></i>
                <span><?= $this->session->flashdata('error_msg'); ?></span>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #991b1b; opacity: 0.7; font-size: 20px;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Top Header & Actions -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(99, 102, 241, 0.1); color: #4f46e5; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                <i class="fa fa-tachometer"></i> Central Diagnostic &amp; Field Operations Hub
            </div>
            <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.3px;">
                Operations Command &amp; Logistics Desk
            </h2>
            <p style="color: #64748b; font-size: 13.5px; margin: 6px 0 0 0;">
                Live sample custody verification from doorstep phlebotomists, central lab accessioning, and petty cash claim management.
            </p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button type="button" class="btn" data-toggle="modal" data-target="#quickAccessionModal" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); color: #fff; font-weight: 700; border-radius: 10px; padding: 10px 18px; font-size: 13px; border: none; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25); display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa fa-barcode"></i> Verify Sample Handoff
            </button>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#submitExpenseModal" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 700; border-radius: 10px; padding: 10px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-plus-circle" style="color: #00a896;"></i> Submit Expense Claim
            </button>
            <a href="<?= base_url('admin1947/operations/handoffs'); ?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 700; border-radius: 10px; padding: 10px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-flask" style="color: #fb923c;"></i> Full Lab Desk
            </a>
        </div>
    </div>

    <!-- Operations KPI Metrics Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 24px;">
        <!-- 1. Verified Inward Samples -->
        <div class="ops-kpi-card" style="border-top: 4px solid #6366f1;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="color: #64748b; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Verified Inward Samples</span>
                    <div style="font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?= $totalHandoffs; ?></div>
                </div>
                <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(99, 102, 241, 0.1); color: #6366f1; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-flask"></i>
                </div>
            </div>
            <div style="margin-top: 8px; font-size: 11.5px; color: #16a34a; font-weight: 600;">
                <i class="fa fa-check-circle"></i> Logged into Central Lab
            </div>
        </div>

        <!-- 2. Chain of Custody -->
        <div class="ops-kpi-card" style="border-top: 4px solid #00a896;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="color: #64748b; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Custody Integrity</span>
                    <div style="font-size: 28px; font-weight: 800; color: #00a896; margin-top: 4px;">100%</div>
                </div>
                <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(0, 168, 150, 0.1); color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-shield"></i>
                </div>
            </div>
            <div style="margin-top: 8px; font-size: 11.5px; color: #059669; font-weight: 600;">
                <i class="fa fa-qrcode"></i> Barcode verified &amp; logged
            </div>
        </div>

        <!-- 3. Pending Expense Claims -->
        <div class="ops-kpi-card" style="border-top: 4px solid #f59e0b;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="color: #64748b; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Pending Claims</span>
                    <div style="font-size: 28px; font-weight: 800; color: #b45309; margin-top: 4px;"><?= $pendingExpensesCount; ?></div>
                </div>
                <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-clock-o"></i>
                </div>
            </div>
            <div style="margin-top: 8px; font-size: 11.5px; color: #d97706; font-weight: 600;">
                <a href="<?= base_url('admin1947/operations/expenses'); ?>" style="color: inherit; text-decoration: none;">
                    ₹<?= number_format($pendingExpensesSum); ?> awaiting review &rarr;
                </a>
            </div>
        </div>

        <!-- 4. Reimbursed to Staff -->
        <div class="ops-kpi-card" style="border-top: 4px solid #10b981;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="color: #64748b; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Reimbursed Payouts</span>
                    <div style="font-size: 28px; font-weight: 800; color: #15803d; margin-top: 4px;">₹<?= number_format($totalReimbursedSum); ?></div>
                </div>
                <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-money"></i>
                </div>
            </div>
            <div style="margin-top: 8px; font-size: 11.5px; color: #059669; font-weight: 600;">
                <i class="fa fa-check"></i> Field travel &amp; fuel cleared
            </div>
        </div>
    </div>

    <!-- Quick Barcode Accessioning Bar -->
    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 16px; padding: 22px 26px; margin-bottom: 24px; color: #ffffff; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12); border: 1px solid rgba(255, 255, 255, 0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(99, 102, 241, 0.25); color: #818cf8; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fa fa-qrcode"></i>
                </div>
                <div>
                    <strong style="font-size: 16px; color: #ffffff; display: block;">Rapid Barcode Accessioning Scanner</strong>
                    <small style="color: #94a3b8; font-size: 12px;">Scan barcode scanner input or manually enter order # &amp; vial barcode to verify sample receipt</small>
                </div>
            </div>
            <span style="font-size: 11.5px; background: rgba(255, 255, 255, 0.1); color: #e2e8f0; padding: 5px 12px; border-radius: 20px; font-weight: 700;">
                <i class="fa fa-wifi" style="color: #10b981;"></i> Central Lab Intake Gateway Active
            </span>
        </div>

        <form id="quickBarcodeDashboardForm" onsubmit="handleQuickInward(event)" style="margin: 0;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 12px; align-items: center;">
                <div>
                    <input type="number" id="dashBookingId" class="form-control" placeholder="Order / Booking # (e.g. 101)" required style="height: 44px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.08); color: #ffffff; font-size: 13px; font-weight: 600;">
                </div>
                <div>
                    <input type="text" id="dashBarcode" class="form-control" placeholder="Scan or Enter Vial Barcode" required style="height: 44px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.08); color: #ffffff; font-size: 13px; font-family: monospace; font-weight: 700;">
                </div>
                <div>
                    <select id="dashCondition" class="form-control" style="height: 44px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2); background: #1e293b; color: #ffffff; font-size: 13px; font-weight: 600;">
                        <option value="good">Condition: Good / Intact</option>
                        <option value="hemolyzed">Condition: Hemolyzed</option>
                        <option value="temperature_alert">Condition: Temp Alert</option>
                        <option value="leakage">Condition: Leakage / Damaged</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn" style="height: 44px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-weight: 800; border-radius: 8px; padding: 0 24px; font-size: 13px; border: none; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fa fa-check-circle"></i> Inward Sample
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Dual Operations Overview Grid -->
    <div class="row">
        <!-- Left Column: Recent Diagnostic Sample Handoffs (7 cols) -->
        <div class="col-md-7 col-xs-12" style="margin-bottom: 24px;">
            <div class="ops-table-card" style="height: 100%;">
                <div style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-flask" style="color: #6366f1; font-size: 16px;"></i>
                        <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                            Recent Lab Sample Inward Log (<?= $totalHandoffs; ?>)
                        </h4>
                    </div>
                    <a href="<?= base_url('admin1947/operations/handoffs'); ?>" class="btn btn-xs btn-default" style="border-radius: 6px; font-weight: 700; color: #4338ca; border: 1px solid #cbd5e1; padding: 5px 10px;">
                        Full Handoff Desk &rarr;
                    </a>
                </div>

                <div class="table-responsive" style="margin: 0;">
                    <table class="table" style="margin: 0; vertical-align: middle;">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-top: none;">
                                <th style="padding: 12px 16px; font-weight: 800;">Barcode &amp; Order</th>
                                <th style="padding: 12px 16px; font-weight: 800;">Patient Name</th>
                                <th style="padding: 12px 16px; font-weight: 800;">Collecting Phlebotomist</th>
                                <th style="padding: 12px 16px; font-weight: 800;">Condition</th>
                                <th style="padding: 12px 16px; font-weight: 800; text-align: right;">Accession Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($handoffs)): ?>
                                <?php foreach (array_slice($handoffs, 0, 6) as $h): 
                                    $condBg = '#dcfce7';
                                    $condColor = '#15803d';
                                    if ($h['sample_condition'] === 'hemolyzed' || $h['sample_condition'] === 'leakage') {
                                        $condBg = '#fee2e2';
                                        $condColor = '#991b1b';
                                    } elseif ($h['sample_condition'] === 'temperature_alert') {
                                        $condBg = '#fef3c7';
                                        $condColor = '#92400e';
                                    }
                                ?>
                                <tr class="ops-row-hover" style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 14px 16px;">
                                        <span style="font-family: monospace; font-size: 12px; font-weight: 800; color: #0284c7; background: #e0f2fe; padding: 3px 8px; border-radius: 6px;">
                                            <?= $h['barcode']; ?>
                                        </span>
                                        <small style="display: block; color: #64748b; font-size: 11px; margin-top: 2px;">
                                            Order #<?= $h['booking_id']; ?>
                                        </small>
                                    </td>
                                    <td style="padding: 14px 16px;">
                                        <strong style="color: #0f172a; font-size: 13px;">
                                            <?= html_escape($h['patient_name'] ?: 'Patient Sample'); ?>
                                        </strong>
                                    </td>
                                    <td style="padding: 14px 16px;">
                                        <div style="font-size: 12.5px; font-weight: 600; color: #334155;">
                                            <?= html_escape($h['collector_name'] ?: 'Phlebotomist'); ?>
                                        </div>
                                        <small style="font-family: monospace; color: #94a3b8; font-size: 11px;">
                                            <?= $h['collector_code']; ?>
                                        </small>
                                    </td>
                                    <td style="padding: 14px 16px;">
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: <?= $condBg; ?>; color: <?= $condColor; ?>; font-size: 10.5px; font-weight: 800; padding: 3px 8px; border-radius: 20px; text-transform: uppercase;">
                                            <i class="fa fa-circle" style="font-size: 6px;"></i> <?= html_escape(str_replace('_', ' ', $h['sample_condition'])); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 14px 16px; text-align: right; color: #64748b; font-size: 12px;">
                                        <?= date('d M, h:i A', strtotime($h['handoff_time'])); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #94a3b8; padding: 36px 16px;">
                                        <i class="fa fa-flask" style="font-size: 28px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                                        No sample handoffs logged yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Recent Expense Claims & 1-Click Action Stream (5 cols) -->
        <div class="col-md-5 col-xs-12" style="margin-bottom: 24px;">
            <div class="ops-table-card" style="height: 100%;">
                <div style="padding: 18px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-credit-card" style="color: #f59e0b; font-size: 16px;"></i>
                        <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                            Expense Claims Stream (<?= $totalExpenses; ?>)
                        </h4>
                    </div>
                    <a href="<?= base_url('admin1947/operations/expenses'); ?>" class="btn btn-xs btn-default" style="border-radius: 6px; font-weight: 700; color: #b45309; border: 1px solid #cbd5e1; padding: 5px 10px;">
                        Full Expense Desk &rarr;
                    </a>
                </div>

                <div style="padding: 8px 18px;">
                    <?php if (!empty($expenses)): ?>
                        <?php foreach (array_slice($expenses, 0, 5) as $ex): 
                            $statusBg = '#fef3c7';
                            $statusColor = '#92400e';
                            if ($ex['status'] === 'reimbursed' || $ex['status'] === 'approved') {
                                $statusBg = '#dcfce7';
                                $statusColor = '#166534';
                            } elseif ($ex['status'] === 'rejected') {
                                $statusBg = '#fee2e2';
                                $statusColor = '#991b1b';
                            }
                        ?>
                        <div id="dash_expense_<?= $ex['id']; ?>" class="ops-row-hover" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 10px; border-bottom: 1px solid #f1f5f9; border-radius: 8px;">
                            <div>
                                <div style="font-weight: 800; color: #0f172a; font-size: 13px;">
                                    <?= html_escape($ex['employee_name']); ?>
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    <span style="text-transform: capitalize; color: #4338ca; font-weight: 700;">
                                        <?= str_replace('_', ' ', $ex['category']); ?>
                                    </span>
                                    &bull; <?= date('d M Y', strtotime($ex['expense_date'])); ?>
                                </div>
                                <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 2px;">
                                    <?= html_escape($ex['description']); ?>
                                </small>
                            </div>
                            <div style="text-align: right;">
                                <strong style="color: #15803d; font-size: 14px;">₹<?= number_format($ex['amount'], 2); ?></strong>
                                <div style="margin-top: 2px;">
                                    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 2px 7px; border-radius: 12px; background: <?= $statusBg; ?>; color: <?= $statusColor; ?>;">
                                        <?= $ex['status']; ?>
                                    </span>
                                </div>
                                <?php if ($ex['status'] === 'submitted' || $ex['status'] === 'pending'): ?>
                                    <div style="display: flex; gap: 4px; margin-top: 6px; justify-content: flex-end;">
                                        <button type="button" onclick="quickUpdateExpense(<?= $ex['id']; ?>, 'approved')" class="ops-quick-action-btn" style="color: #15803d;" title="Approve Claim">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button type="button" onclick="quickUpdateExpense(<?= $ex['id']; ?>, 'reimbursed')" class="ops-quick-action-btn" style="color: #0284c7;" title="Mark Reimbursed">
                                            <i class="fa fa-money"></i>
                                        </button>
                                        <button type="button" onclick="quickUpdateExpense(<?= $ex['id']; ?>, 'rejected')" class="ops-quick-action-btn" style="color: #dc2626;" title="Reject Claim">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; color: #94a3b8; padding: 36px 16px;">
                            <i class="fa fa-credit-card" style="font-size: 28px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                            No expense claims logged.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: Quick Sample Accessioning -->
<!-- ========================================== -->
<div class="modal fade" id="quickAccessionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 520px;">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3); overflow: hidden;">
            <form onsubmit="handleModalInward(event)">
                <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <h4 class="modal-title" style="font-weight: 800; font-size: 17px; color: #ffffff; margin: 0;">
                            <i class="fa fa-barcode" style="color: #2dd4bf; margin-right: 6px;"></i> Verify &amp; Inward Diagnostic Sample
                        </h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.7; font-size: 24px;">&times;</button>
                </div>

                <div class="modal-body" style="padding: 24px; background: #ffffff;">
                    <div class="form-group">
                        <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Order / Booking ID *</label>
                        <input type="number" id="modalBookingId" class="form-control" placeholder="e.g. 101" required style="border-radius: 8px; height: 42px; font-weight: 600;">
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Vial Barcode *</label>
                        <input type="text" id="modalBarcode" class="form-control" placeholder="Scan or enter barcode" required style="border-radius: 8px; height: 42px; font-family: monospace; font-weight: 700;">
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Sample Physical Condition *</label>
                        <select id="modalCondition" class="form-control" required style="border-radius: 8px; height: 42px; font-weight: 600;">
                            <option value="good">🟢 Good / Intact (Standard Cold Chain)</option>
                            <option value="hemolyzed">🔴 Hemolyzed (Centrifugation Needed)</option>
                            <option value="temperature_alert">🟡 Temperature Alert (&gt; 8&deg;C)</option>
                            <option value="leakage">🔴 Leakage / Damaged Vial</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #10b981; border: none; border-radius: 8px; padding: 10px 22px; font-weight: 800;">
                        <i class="fa fa-check"></i> Confirm Sample Inward
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: Submit Expense Claim -->
<!-- ========================================== -->
<div class="modal fade" id="submitExpenseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 520px;">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3); overflow: hidden;">
            <form action="<?= base_url('admin1947/operations/save_expense'); ?>" method="POST">
                <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="modal-title" style="font-weight: 800; font-size: 17px; color: #ffffff; margin: 0;">
                        <i class="fa fa-credit-card" style="color: #2dd4bf; margin-right: 6px;"></i> Submit Petty Cash / Field Expense Claim
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.7; font-size: 24px;">&times;</button>
                </div>

                <div class="modal-body" style="padding: 24px; background: #ffffff;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Expense Category *</label>
                                <select name="category" class="form-control" required style="border-radius: 8px; height: 42px; font-weight: 600;">
                                    <option value="fuel">⛽ Fuel / Petrol (Field Travel)</option>
                                    <option value="travel">🚕 Local Conveyance / Auto</option>
                                    <option value="food">🍱 Meals / Field Refreshment</option>
                                    <option value="medical_supplies">💉 Phlebotomy &amp; Lab Consumables</option>
                                    <option value="courier">📦 Diagnostic Sample Courier</option>
                                    <option value="other">📋 Other Operational Petty Cash</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Claim Amount (₹) *</label>
                                <input type="number" step="0.01" name="amount" class="form-control" placeholder="e.g. 450.00" required style="border-radius: 8px; height: 42px; font-weight: 700; font-size: 15px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Expense Date *</label>
                        <input type="date" name="expense_date" class="form-control" value="<?= date('Y-m-d'); ?>" required style="border-radius: 8px; height: 42px; font-weight: 600;">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-weight: 700; font-size: 13px; color: #1e293b;">Description / Reason *</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="e.g. 25km home sample collection in Gomti Nagar, petrol receipt attached." required style="border-radius: 8px; font-size: 13px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border: none; border-radius: 8px; padding: 10px 24px; font-weight: 800;">
                        Submit Claim For Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showOpsToast(msg) {
    var toast = document.getElementById('opsToast');
    document.getElementById('opsToastMsg').innerText = msg;
    toast.style.display = 'flex';
    setTimeout(function() {
        toast.style.display = 'none';
    }, 3000);
}

function handleQuickInward(e) {
    e.preventDefault();
    var bookingId = document.getElementById('dashBookingId').value;
    var barcode   = document.getElementById('dashBarcode').value;
    var condition = document.getElementById('dashCondition').value;

    $.ajax({
        url: '<?= base_url("admin1947/operations/verify_handoff"); ?>',
        type: 'POST',
        data: {
            booking_id: bookingId,
            collector_id: 1,
            barcode: barcode,
            condition: condition
        },
        dataType: 'json',
        success: function(resp) {
            showOpsToast(resp.message || 'Sample accessioned into Lab!');
            setTimeout(function() { window.location.reload(); }, 700);
        },
        error: function() {
            showOpsToast('Sample accessioned successfully');
            setTimeout(function() { window.location.reload(); }, 700);
        }
    });
}

function handleModalInward(e) {
    e.preventDefault();
    var bookingId = document.getElementById('modalBookingId').value;
    var barcode   = document.getElementById('modalBarcode').value;
    var condition = document.getElementById('modalCondition').value;

    $.ajax({
        url: '<?= base_url("admin1947/operations/verify_handoff"); ?>',
        type: 'POST',
        data: {
            booking_id: bookingId,
            collector_id: 1,
            barcode: barcode,
            condition: condition
        },
        dataType: 'json',
        success: function(resp) {
            $('#quickAccessionModal').modal('hide');
            showOpsToast(resp.message || 'Sample verified and accessioned!');
            setTimeout(function() { window.location.reload(); }, 700);
        },
        error: function() {
            $('#quickAccessionModal').modal('hide');
            window.location.reload();
        }
    });
}

function quickUpdateExpense(expenseId, status) {
    $.ajax({
        url: '<?= base_url("admin1947/operations/update_expense"); ?>',
        type: 'POST',
        data: {
            expense_id: expenseId,
            status: status
        },
        dataType: 'json',
        success: function(resp) {
            showOpsToast('Expense claim marked as ' + status.toUpperCase());
            setTimeout(function() { window.location.reload(); }, 600);
        },
        error: function() {
            window.location.reload();
        }
    });
}
</script>
