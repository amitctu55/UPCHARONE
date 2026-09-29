<?php defined('BASEPATH') OR exit('No direct script access allowed'); $CI = get_instance(); ?>

<style>
    /* Metric KPI Cards */
    .ops-kpi-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--ops-slate-200);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
        position: relative;
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .ops-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }
    .ops-kpi-badge {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .ops-kpi-num {
        font-size: 2.1rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin: 8px 0 4px;
        font-family: var(--font-head);
    }
    .ops-kpi-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }
    .ops-kpi-trend {
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 6px;
    }

    /* Modern Table Card */
    .ops-table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--ops-slate-200);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
        overflow: hidden;
        margin-bottom: 24px;
    }
    .ops-table-head {
        padding: 18px 24px;
        background: #ffffff;
        border-bottom: 1px solid var(--ops-slate-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .ops-table-head h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .ops-data-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }
    .ops-data-table th {
        background: #f8fafc;
        padding: 12px 20px;
        font-size: 11.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        border-bottom: 1px solid var(--ops-slate-200);
        white-space: nowrap;
    }
    .ops-data-table td {
        padding: 14px 20px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .ops-data-table tr:hover td {
        background-color: #f8fafc;
    }

    /* Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .badge-good { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .badge-alert { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .badge-info { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    /* Action Buttons */
    .ops-btn-action {
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 700;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none !important;
    }
    .ops-btn-action:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }
</style>

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

<!-- Toast Notification -->
<div id="opsToast" style="position: fixed; bottom: 28px; right: 28px; background: #0f172a; color: #ffffff; padding: 14px 22px; border-radius: 12px; font-weight: 700; font-size: 13.5px; box-shadow: 0 12px 30px rgba(0,0,0,0.3); display: none; z-index: 99999; align-items: center; gap: 10px; border: 1px solid rgba(255,255,255,0.15);">
    <i class="fa fa-check-circle" style="color: #2dd4bf; font-size: 18px;"></i>
    <span id="opsToastMsg">Action completed successfully</span>
</div>

<!-- TOP ACTION & WELCOME BANNER -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
    <div>
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(99, 102, 241, 0.1); color: var(--ops-primary); font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 8px;">
            <i class="fa fa-tachometer"></i> Executive Command Hub
        </div>
        <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
            Central Logistics &amp; Operations Command
        </h1>
        <p style="color: #64748b; font-size: 14px; margin: 6px 0 0 0;">
            Real-time diagnostic chain-of-custody tracking, field phlebotomist specimen handoffs &amp; logistics reimbursement desk.
        </p>
    </div>

    <!-- Quick Action Triggers -->
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="<?= base_url('admin1947/operations/handoffs'); ?>" class="btn" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; font-weight: 700; border-radius: 12px; padding: 11px 18px; font-size: 13px; border: none; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15); display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa fa-barcode" style="color: #818cf8;"></i> + Rapid Inward Sample
        </a>
        <a href="<?= base_url('admin1947/operations/expenses'); ?>" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-weight: 700; border-radius: 12px; padding: 11px 18px; font-size: 13px; border: none; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa fa-plus-circle"></i> + Submit Expense Claim
        </a>
    </div>
</div>

<!-- 4 EXECUTIVE KPI METRICS -->
<div class="row" style="margin-bottom: 28px;">
    <!-- 1. Diagnostic Accessions -->
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
        <div class="ops-kpi-card" style="border-left: 4px solid #6366f1;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="ops-kpi-label">Diagnostic Inward</div>
                    <div class="ops-kpi-num"><?= $totalHandoffs; ?></div>
                    <div class="ops-kpi-trend" style="color: #10b981;">
                        <i class="fa fa-arrow-up"></i> Chain-of-Custody Active
                    </div>
                </div>
                <div class="ops-kpi-badge" style="background: #eef2ff; color: #6366f1;">
                    <i class="fa fa-flask"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Pending Expenses -->
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
        <div class="ops-kpi-card" style="border-left: 4px solid #f59e0b;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="ops-kpi-label">Pending Claims</div>
                    <div class="ops-kpi-num">₹<?= number_format($pendingExpensesSum); ?></div>
                    <div class="ops-kpi-trend" style="color: #b45309;">
                        <i class="fa fa-clock-o"></i> <?= $pendingExpensesCount; ?> claims awaiting review
                    </div>
                </div>
                <div class="ops-kpi-badge" style="background: #fffbeb; color: #f59e0b;">
                    <i class="fa fa-credit-card"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Settled Logistics -->
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
        <div class="ops-kpi-card" style="border-left: 4px solid #10b981;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="ops-kpi-label">Reimbursed Total</div>
                    <div class="ops-kpi-num">₹<?= number_format($totalReimbursedSum); ?></div>
                    <div class="ops-kpi-trend" style="color: #059669;">
                        <i class="fa fa-check-circle"></i> Settled Petty Cash
                    </div>
                </div>
                <div class="ops-kpi-badge" style="background: #ecfdf5; color: #10b981;">
                    <i class="fa fa-check-square-o"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Ambulance Network -->
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
        <div class="ops-kpi-card" style="border-left: 4px solid #ef4444;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="ops-kpi-label">Ambulance Fleet</div>
                    <div class="ops-kpi-num">100+</div>
                    <div class="ops-kpi-trend" style="color: #dc2626;">
                        <i class="fa fa-circle" style="font-size: 8px;"></i> 24/7 Rapid Response
                    </div>
                </div>
                <div class="ops-kpi-badge" style="background: #fee2e2; color: #ef4444;">
                    <i class="fa fa-ambulance"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DUAL WORKBENCH GRIDS -->
<div class="row">
    <!-- LEFT: Recent Diagnostic Sample Handoffs -->
    <div class="col-md-7 col-xs-12">
        <div class="ops-table-card">
            <div class="ops-table-head">
                <h3>
                    <i class="fa fa-flask" style="color: #fb923c;"></i>
                    Recent Central Lab Accessions
                </h3>
                <a href="<?= base_url('admin1947/operations/handoffs'); ?>" class="ops-btn-action">
                    View Accession Roster <i class="fa fa-chevron-right" style="font-size: 9px;"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="ops-data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Sample / Barcode</th>
                            <th>Phlebotomist</th>
                            <th>Condition</th>
                            <th>Received Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($handoffs)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                                    <div style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px;"><i class="fa fa-inbox"></i></div>
                                    <strong style="color: #475569; display: block;">No sample handoffs recorded yet</strong>
                                    <small>Field doorstep samples accessioned into the laboratory will appear here.</small>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($handoffs as $h): ?>
                                <tr>
                                    <td>
                                        <span style="font-family: monospace; font-weight: 700; color: #0f172a;">
                                            #<?= html_escape($h['booking_id']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; font-family: monospace;">
                                            <?= html_escape($h['barcode']); ?>
                                        </div>
                                        <small style="color: #64748b; font-size: 11px;">
                                            <?= html_escape($h['patient_name'] ?? 'Diagnostic Test'); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #334155;">
                                            <?= html_escape($h['collector_name'] ?? 'Field Staff'); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($h['sample_condition'] === 'good'): ?>
                                            <span class="badge-status badge-good"><i class="fa fa-check"></i> Intact</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-alert"><i class="fa fa-warning"></i> <?= html_escape(ucwords($h['sample_condition'])); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small style="color: #64748b;">
                                            <?= date('d M, h:i A', strtotime($h['handoff_time'])); ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- RIGHT: Recent Staff Expense Submissions -->
    <div class="col-md-5 col-xs-12">
        <div class="ops-table-card">
            <div class="ops-table-head">
                <h3>
                    <i class="fa fa-credit-card" style="color: #4ade80;"></i>
                    Staff Reimbursements
                </h3>
                <a href="<?= base_url('admin1947/operations/expenses'); ?>" class="ops-btn-action">
                    Expense Desk <i class="fa fa-chevron-right" style="font-size: 9px;"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="ops-data-table">
                    <thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($expenses)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                                    <div style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px;"><i class="fa fa-check-circle-o"></i></div>
                                    <strong style="color: #475569; display: block;">No expense claims pending</strong>
                                    <small>Staff transport, fuel, and diagnostic purchases will show here.</small>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach (array_slice($expenses, 0, 8) as $ex): ?>
                                <tr id="ex-row-<?= $ex['id']; ?>">
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 13px;">
                                            <?= html_escape($ex['employee_name'] ?? 'Staff'); ?>
                                        </div>
                                        <small style="color: #64748b; font-size: 11px;">
                                            <?= html_escape($ex['description'] ?? ''); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-info">
                                            <?= html_escape(ucwords($ex['category'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong style="color: #0f172a; font-size: 14px;">
                                            ₹<?= number_format($ex['amount']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <?php if ($ex['status'] === 'submitted' || $ex['status'] === 'pending'): ?>
                                            <span class="badge-status badge-pending"><i class="fa fa-clock-o"></i> Pending</span>
                                        <?php elseif ($ex['status'] === 'approved'): ?>
                                            <span class="badge-status badge-good"><i class="fa fa-check"></i> Approved</span>
                                        <?php elseif ($ex['status'] === 'reimbursed'): ?>
                                            <span class="badge-status badge-good"><i class="fa fa-check-circle"></i> Paid</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-alert"><i class="fa fa-times"></i> <?= html_escape($ex['status']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($ex['status'] === 'submitted' || $ex['status'] === 'pending'): ?>
                                            <div style="display: flex; gap: 4px;">
                                                <button type="button" class="btn btn-xs btn-success" onclick="quickUpdateExpense(<?= $ex['id']; ?>, 'approved')" title="Approve Claim" style="border-radius: 6px; padding: 3px 8px;">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger" onclick="quickUpdateExpense(<?= $ex['id']; ?>, 'rejected')" title="Reject Claim" style="border-radius: 6px; padding: 3px 8px;">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <small style="color: #94a3b8;"><i class="fa fa-lock"></i> Settled</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function quickUpdateExpense(expenseId, status) {
    if (!confirm("Are you sure you want to mark this expense claim as " + status.toUpperCase() + "?")) {
        return;
    }
    
    $.ajax({
        url: "<?= base_url('admin1947/operations/update_expense'); ?>",
        type: "POST",
        dataType: "json",
        data: {
            expense_id: expenseId,
            status: status
        },
        success: function(resp) {
            if (resp.status === 'success') {
                showToast(resp.message);
                var row = document.getElementById('ex-row-' + expenseId);
                if (row) {
                    row.style.opacity = '0.4';
                    row.style.pointerEvents = 'none';
                }
                setTimeout(function() { location.reload(); }, 900);
            } else {
                alert(resp.message || "Failed to update expense claim");
            }
        },
        error: function() {
            alert("Network error updating expense claim.");
        }
    });
}

function showToast(msg) {
    var toast = document.getElementById('opsToast');
    var txt = document.getElementById('opsToastMsg');
    if (toast && txt) {
        txt.textContent = msg;
        toast.style.display = 'inline-flex';
        setTimeout(function() { toast.style.display = 'none'; }, 3000);
    }
}
</script>