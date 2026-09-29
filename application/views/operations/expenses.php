<?php defined('BASEPATH') OR exit('No direct script access allowed'); $CI = get_instance(); ?>

<style>
    /* Metric KPI Cards */
    .ops-kpi-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 24px;
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
    .ops-kpi-num {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin: 6px 0 4px;
        font-family: var(--font-head);
    }
    .ops-kpi-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    /* Filter Bar */
    .ops-filter-bar {
        background: #ffffff;
        border-radius: 14px;
        padding: 14px 20px;
        border: 1px solid var(--ops-slate-200);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Table */
    .ops-table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--ops-slate-200);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
        overflow: hidden;
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
    .badge-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .badge-approved { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-reimbursed { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .badge-rejected { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-cat { background: #f1f5f9; color: #334155; border-radius: 6px; padding: 3px 8px; font-weight: 600; font-size: 11px; text-transform: uppercase; }
</style>

<?php
$totalCount = count($expenses ?? []);
$pendingCount = 0;
$pendingSum = 0;
$approvedCount = 0;
$approvedSum = 0;
$reimbursedCount = 0;
$reimbursedSum = 0;
$rejectedCount = 0;

foreach ($expenses as $ex) {
    $amt = floatval($ex['amount']);
    $st = $ex['status'];
    if ($st === 'submitted' || $st === 'pending') {
        $pendingCount++;
        $pendingSum += $amt;
    } elseif ($st === 'approved') {
        $approvedCount++;
        $approvedSum += $amt;
    } elseif ($st === 'reimbursed') {
        $reimbursedCount++;
        $reimbursedSum += $amt;
    } elseif ($st === 'rejected') {
        $rejectedCount++;
    }
}

$canManage = in_array($CI->session->userdata('staff_role'), ['super_admin', 'hr', 'office_staff']);
?>

<!-- TOP BANNER -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(16, 185, 129, 0.1); color: #059669; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 8px;">
            <i class="fa fa-credit-card"></i> Petty Cash &amp; Logistics Reimbursements
        </div>
        <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
            Staff Expense Desk &amp; Reimbursement Portal
        </h1>
        <p style="color: #64748b; font-size: 14px; margin: 6px 0 0 0;">
            Review and disburse field phlebotomist petrol allowances, transit tickets &amp; diagnostic consumables.
        </p>
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <button type="button" class="btn" data-toggle="modal" data-target="#addExpenseModal" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-weight: 700; border-radius: 12px; padding: 11px 20px; font-size: 13.5px; border: none; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3); display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa fa-plus-circle"></i> + Submit Expense Claim
        </button>
        <a href="<?= base_url('admin1947/operations'); ?>" class="btn" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 700; border-radius: 12px; padding: 11px 18px; font-size: 13.5px; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa fa-tachometer"></i> Operations Hub
        </a>
    </div>
</div>

<!-- Flash Alerts -->
<?php if ($CI->session->flashdata('success_msg')): ?>
    <div class="alert alert-success" style="border-radius: 12px; font-size: 14px; font-weight: 600; border-left: 5px solid #10b981; background: #ecfdf5; color: #065f46; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1); margin-bottom: 24px;">
        <i class="fa fa-check-circle" style="color: #10b981; margin-right: 6px;"></i> <?= $CI->session->flashdata('success_msg'); ?>
    </div>
<?php endif; ?>
<?php if ($CI->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger" style="border-radius: 12px; font-size: 14px; font-weight: 600; border-left: 5px solid #ef4444; background: #fef2f2; color: #991b1b; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.1); margin-bottom: 24px;">
        <i class="fa fa-exclamation-circle" style="color: #ef4444; margin-right: 6px;"></i> <?= $CI->session->flashdata('error_msg'); ?>
    </div>
<?php endif; ?>

<!-- 4 FINANCIAL KPI CARDS -->
<div class="row" style="margin-bottom: 28px;">
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
        <div class="ops-kpi-card" style="border-left: 4px solid #f59e0b;">
            <div class="ops-kpi-label">Pending Review</div>
            <div class="ops-kpi-num" style="color: #b45309;">₹<?= number_format($pendingSum); ?></div>
            <small style="color: #64748b; font-weight: 600;"><?= $pendingCount; ?> claims awaiting review</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
        <div class="ops-kpi-card" style="border-left: 4px solid #3b82f6;">
            <div class="ops-kpi-label">Approved (Pending Payout)</div>
            <div class="ops-kpi-num" style="color: #1d4ed8;">₹<?= number_format($approvedSum); ?></div>
            <small style="color: #64748b; font-weight: 600;"><?= $approvedCount; ?> claims approved</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
        <div class="ops-kpi-card" style="border-left: 4px solid #10b981;">
            <div class="ops-kpi-label">Reimbursed &amp; Paid</div>
            <div class="ops-kpi-num" style="color: #047857;">₹<?= number_format($reimbursedSum); ?></div>
            <small style="color: #64748b; font-weight: 600;"><?= $reimbursedCount; ?> claims disbursed</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 16px;">
        <div class="ops-kpi-card" style="border-left: 4px solid #6366f1;">
            <div class="ops-kpi-label">Total Claims Audited</div>
            <div class="ops-kpi-num"><?= $totalCount; ?></div>
            <small style="color: #64748b; font-weight: 600;"><?= $rejectedCount; ?> claims rejected</small>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<div class="ops-filter-bar">
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <span style="font-size: 13px; font-weight: 700; color: #475569;"><i class="fa fa-filter"></i> Filters:</span>
        <a href="<?= base_url('admin1947/operations/expenses'); ?>" class="btn btn-xs <?= empty($CI->input->get('status')) ? 'btn-primary' : 'btn-default'; ?>" style="border-radius: 20px; font-weight: 700; padding: 4px 12px;">All Claims</a>
        <a href="<?= base_url('admin1947/operations/expenses?status=submitted'); ?>" class="btn btn-xs <?= ($CI->input->get('status') === 'submitted') ? 'btn-warning' : 'btn-default'; ?>" style="border-radius: 20px; font-weight: 700; padding: 4px 12px;">Pending</a>
        <a href="<?= base_url('admin1947/operations/expenses?status=approved'); ?>" class="btn btn-xs <?= ($CI->input->get('status') === 'approved') ? 'btn-info' : 'btn-default'; ?>" style="border-radius: 20px; font-weight: 700; padding: 4px 12px;">Approved</a>
        <a href="<?= base_url('admin1947/operations/expenses?status=reimbursed'); ?>" class="btn btn-xs <?= ($CI->input->get('status') === 'reimbursed') ? 'btn-success' : 'btn-default'; ?>" style="border-radius: 20px; font-weight: 700; padding: 4px 12px;">Reimbursed</a>
    </div>

    <div style="display: flex; align-items: center; gap: 8px;">
        <small style="color: #64748b; font-weight: 600;">Showing <?= count($expenses); ?> claims</small>
    </div>
</div>

<!-- CLAIMS LEDGER TABLE -->
<div class="ops-table-card">
    <div class="table-responsive">
        <table class="ops-data-table">
            <thead>
                <tr>
                    <th>Claim #</th>
                    <th>Staff Member</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Description / Purpose</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Approver</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($expenses)): ?>
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                        <i class="fa fa-folder-open-o" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px;"></i>
                        <strong style="color: #475569; display: block;">No expense claims found matching filter</strong>
                        <small>Click "+ Submit Expense Claim" to log staff logistics costs.</small>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($expenses as $ex): ?>
                    <tr id="ex-row-<?= $ex['id']; ?>">
                        <td><span style="font-family: monospace; color: #64748b;">#EXP-<?= str_pad($ex['id'], 4, '0', STR_PAD_LEFT); ?></span></td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;"><?= html_escape($ex['employee_name'] ?? 'Staff'); ?></div>
                            <small style="color: #94a3b8; font-size: 11px;"><?= html_escape($ex['department'] ?? 'Logistics'); ?> &bull; <?= html_escape($ex['staff_code'] ?? ''); ?></small>
                        </td>
                        <td><small style="font-weight: 600; color: #475569;"><?= date('d M Y', strtotime($ex['expense_date'])); ?></small></td>
                        <td><span class="badge-cat"><?= html_escape($ex['category']); ?></span></td>
                        <td>
                            <div style="max-width: 260px; font-weight: 500; color: #334155; line-height: 1.4;">
                                <?= html_escape($ex['description']); ?>
                            </div>
                        </td>
                        <td>
                            <strong style="color: #0f172a; font-size: 15px; font-family: var(--font-head);">
                                ₹<?= number_format($ex['amount'], 2); ?>
                            </strong>
                        </td>
                        <td>
                            <?php if ($ex['status'] === 'submitted' || $ex['status'] === 'pending'): ?>
                                <span class="badge-status badge-pending"><i class="fa fa-clock-o"></i> Pending Review</span>
                            <?php elseif ($ex['status'] === 'approved'): ?>
                                <span class="badge-status badge-approved"><i class="fa fa-check"></i> Approved</span>
                            <?php elseif ($ex['status'] === 'reimbursed'): ?>
                                <span class="badge-status badge-reimbursed"><i class="fa fa-check-circle"></i> Paid</span>
                            <?php else: ?>
                                <span class="badge-status badge-rejected"><i class="fa fa-times"></i> <?= html_escape(ucwords($ex['status'])); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small style="color: #64748b;"><?= html_escape($ex['approver_name'] ?? '—'); ?></small>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <?php if ($canManage && ($ex['status'] === 'submitted' || $ex['status'] === 'pending')): ?>
                                <button type="button" class="btn btn-xs btn-success" onclick="updateExpenseStatus(<?= $ex['id']; ?>, 'approved')" style="border-radius: 6px; font-weight: 700; padding: 4px 10px;">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                                <button type="button" class="btn btn-xs btn-danger" onclick="updateExpenseStatus(<?= $ex['id']; ?>, 'rejected')" style="border-radius: 6px; font-weight: 700; padding: 4px 10px;">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                            <?php elseif ($canManage && $ex['status'] === 'approved'): ?>
                                <button type="button" class="btn btn-xs btn-info" onclick="updateExpenseStatus(<?= $ex['id']; ?>, 'reimbursed')" style="border-radius: 6px; font-weight: 700; padding: 4px 10px;">
                                    <i class="fa fa-money"></i> Mark Paid
                                </button>
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

<!-- SUBMIT EXPENSE CLAIM MODAL -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 60px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 100%); color: #ffffff; padding: 20px 24px; border: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-family: var(--font-head); font-size: 18px;">
                    <i class="fa fa-plus-circle" style="color: #10b981; margin-right: 6px;"></i> Submit New Expense Claim
                </h4>
            </div>
            <form action="<?= base_url('admin1947/operations/save_expense'); ?>" method="POST" style="margin: 0;">
                <div class="modal-body" style="padding: 24px;">
                    <div class="row">
                        <div class="col-md-6 col-xs-12" style="margin-bottom: 16px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block;">Expense Category</label>
                            <select name="category" class="form-control" style="height: 44px; border-radius: 10px; border: 1.5px solid #cbd5e1;" required>
                                <option value="fuel">Fuel / Petrol Allowance</option>
                                <option value="transport">Public Transit / Taxi / Auto</option>
                                <option value="vehicle_maintenance">Vehicle Repair &amp; Maintenance</option>
                                <option value="medical_supplies">Emergency Syringes / Vacutainers</option>
                                <option value="refreshments">Staff Food &amp; Refreshments</option>
                                <option value="other">Other Operational Expense</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-xs-12" style="margin-bottom: 16px;">
                            <label style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block;">Claim Amount (₹)</label>
                            <input type="number" step="0.01" name="amount" class="form-control" placeholder="e.g. 450.00" style="height: 44px; border-radius: 10px; border: 1.5px solid #cbd5e1; font-weight: 700; font-size: 15px;" required>
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block;">Date of Expense</label>
                        <input type="date" name="expense_date" class="form-control" value="<?= date('Y-m-d'); ?>" style="height: 44px; border-radius: 10px; border: 1.5px solid #cbd5e1;" required>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; display: block;">Purpose / Item Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe the doorstep visit, route distance, or emergency purchase purpose..." style="border-radius: 10px; border: 1.5px solid #cbd5e1; font-size: 13.5px;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px; font-weight: 700; padding: 9px 18px;">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-weight: 800; border-radius: 10px; padding: 9px 24px; border: none; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                        Submit Claim For Approval
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateExpenseStatus(expenseId, status) {
    if (!confirm("Are you sure you want to mark this claim as " + status.toUpperCase() + "?")) {
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
                alert(resp.message);
                location.reload();
            } else {
                alert(resp.message || "Failed to update expense status.");
            }
        },
        error: function() {
            alert("Network error updating expense claim.");
        }
    });
}
</script>