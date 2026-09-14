<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Operations Staff Expense Desk View -->
<div class="container-fluid" style="padding: 0;">

    <?php
    $totalCount = count($expenses);
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

    $canManage = in_array($this->session->userdata('staff_role'), ['super_admin', 'hr', 'office_staff']);
    ?>

    <!-- Top Header & Actions -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(16, 185, 129, 0.1); color: #059669; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                <i class="fa fa-credit-card"></i> Petty Cash &amp; Logistics Reimbursements
            </div>
            <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                Staff Expense Desk &amp; Reimbursement Portal
            </h2>
            <p style="color: #64748b; font-size: 13.5px; margin: 6px 0 0 0;">
                Log doorstep phlebotomist fuel, vehicle transport allowances &amp; emergency diagnostic purchases.
            </p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button type="button" class="btn" data-toggle="modal" data-target="#addExpenseModal" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; font-weight: 700; border-radius: 10px; padding: 10px 18px; font-size: 13px; border: none; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa fa-plus-circle"></i> + Submit Expense Claim
            </button>
            <a href="<?= base_url('operations'); ?>" class="btn btn-default" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; font-weight: 600; border-radius: 10px; padding: 10px 16px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-tachometer"></i> Operations Hub
            </a>
        </div>
    </div>

    <!-- Flash Alerts -->
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success" style="border-radius: 12px; font-size: 13.5px; border-left: 5px solid #10b981; background: #f0fdf4; color: #166534; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.1);">
            <i class="fa fa-check-circle" style="color: #10b981; margin-right: 6px;"></i> <?= $this->session->flashdata('success_msg'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger" style="border-radius: 12px; font-size: 13.5px; border-left: 5px solid #ef4444; background: #fef2f2; color: #991b1b; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.1);">
            <i class="fa fa-exclamation-circle" style="color: #ef4444; margin-right: 6px;"></i> <?= $this->session->flashdata('error_msg'); ?>
        </div>
    <?php endif; ?>

    <!-- KPI Metric Cards Grid -->
    <div class="row" style="margin-bottom: 24px;">
        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 12px;">
            <div class="ops-card" style="border-top: 4px solid #f59e0b; border-radius: 14px; padding: 18px 20px; background: #ffffff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <small style="color: #64748b; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Pending Approval</small>
                        <div style="font-size: 26px; font-weight: 800; color: #b45309; margin-top: 4px;">₹<?= number_format($pendingSum); ?></div>
                    </div>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fa fa-clock-o"></i>
                    </div>
                </div>
                <div style="margin-top: 8px; font-size: 11.5px; color: #d97706; font-weight: 600;">
                    <i class="fa fa-file-text-o"></i> <?= $pendingCount; ?> claims awaiting review
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 12px;">
            <div class="ops-card" style="border-top: 4px solid #0284c7; border-radius: 14px; padding: 18px 20px; background: #ffffff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <small style="color: #64748b; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Approved for Payout</small>
                        <div style="font-size: 26px; font-weight: 800; color: #0284c7; margin-top: 4px;">₹<?= number_format($approvedSum); ?></div>
                    </div>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(2, 132, 199, 0.1); color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                </div>
                <div style="margin-top: 8px; font-size: 11.5px; color: #0284c7; font-weight: 600;">
                    <i class="fa fa-bank"></i> <?= $approvedCount; ?> approved claims
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 12px;">
            <div class="ops-card" style="border-top: 4px solid #10b981; border-radius: 14px; padding: 18px 20px; background: #ffffff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <small style="color: #64748b; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Reimbursed to Staff</small>
                        <div style="font-size: 26px; font-weight: 800; color: #15803d; margin-top: 4px;">₹<?= number_format($reimbursedSum); ?></div>
                    </div>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fa fa-money"></i>
                    </div>
                </div>
                <div style="margin-top: 8px; font-size: 11.5px; color: #059669; font-weight: 600;">
                    <i class="fa fa-check-circle"></i> <?= $reimbursedCount; ?> cleared vouchers
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 12px;">
            <div class="ops-card" style="border-top: 4px solid #6366f1; border-radius: 14px; padding: 18px 20px; background: #ffffff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <small style="color: #64748b; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Total Expenses Logged</small>
                        <div style="font-size: 26px; font-weight: 800; color: #4338ca; margin-top: 4px;"><?= $totalCount; ?></div>
                    </div>
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(99, 102, 241, 0.1); color: #6366f1; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fa fa-list-alt"></i>
                    </div>
                </div>
                <div style="margin-top: 8px; font-size: 11.5px; color: #6366f1; font-weight: 600;">
                    <i class="fa fa-shield"></i> All staff submissions
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 16px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="<?= base_url('operations/expenses'); ?>" class="btn btn-sm" style="border-radius: 8px; font-weight: 700; padding: 7px 14px; font-size: 12.5px; <?= empty($this->input->get('status')) ? 'background: #0f172a; color: #ffffff;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;'; ?>">
                All Claims (<?= $totalCount; ?>)
            </a>
            <a href="<?= base_url('operations/expenses?status=submitted'); ?>" class="btn btn-sm" style="border-radius: 8px; font-weight: 700; padding: 7px 14px; font-size: 12.5px; <?= $this->input->get('status') === 'submitted' ? 'background: #f59e0b; color: #ffffff;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;'; ?>">
                <i class="fa fa-clock-o"></i> Pending Review (<?= $pendingCount; ?>)
            </a>
            <a href="<?= base_url('operations/expenses?status=approved'); ?>" class="btn btn-sm" style="border-radius: 8px; font-weight: 700; padding: 7px 14px; font-size: 12.5px; <?= $this->input->get('status') === 'approved' ? 'background: #0284c7; color: #ffffff;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;'; ?>">
                <i class="fa fa-check"></i> Approved (<?= $approvedCount; ?>)
            </a>
            <a href="<?= base_url('operations/expenses?status=reimbursed'); ?>" class="btn btn-sm" style="border-radius: 8px; font-weight: 700; padding: 7px 14px; font-size: 12.5px; <?= $this->input->get('status') === 'reimbursed' ? 'background: #10b981; color: #ffffff;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;'; ?>">
                <i class="fa fa-money"></i> Reimbursed (<?= $reimbursedCount; ?>)
            </a>
            <a href="<?= base_url('operations/expenses?status=rejected'); ?>" class="btn btn-sm" style="border-radius: 8px; font-weight: 700; padding: 7px 14px; font-size: 12.5px; <?= $this->input->get('status') === 'rejected' ? 'background: #ef4444; color: #ffffff;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;'; ?>">
                <i class="fa fa-times"></i> Rejected (<?= $rejectedCount; ?>)
            </a>
        </div>

        <div style="position: relative; min-width: 260px;">
            <i class="fa fa-search" style="position: absolute; left: 12px; top: 11px; color: #94a3b8; font-size: 13px;"></i>
            <input type="text" id="expenseSearchInput" class="form-control" placeholder="Search staff, category, amount..." style="padding-left: 34px; height: 36px; border-radius: 8px; font-size: 12.5px; border: 1px solid #cbd5e1;">
        </div>
    </div>

    <!-- Expense Claims Table Card -->
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04); overflow: hidden;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></div>
                <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
                    Expense Claims &amp; Petty Cash Log
                </h4>
            </div>
            <span style="font-size: 12px; color: #64748b; font-weight: 600;">
                Showing <?= count($expenses); ?> claims
            </span>
        </div>

        <div class="table-responsive">
            <table class="table" id="expensesTable" style="margin: 0; vertical-align: middle;">
                <thead>
                    <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-top: none;">
                        <th style="padding: 14px 20px; font-weight: 800;">Staff Member</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Category</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Amount Claimed</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Expense Date</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Description &amp; Notes</th>
                        <th style="padding: 14px 20px; font-weight: 800;">Claim Status</th>
                        <?php if ($canManage): ?>
                            <th style="padding: 14px 20px; font-weight: 800; text-align: right;">Review Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($expenses)): ?>
                        <?php foreach ($expenses as $ex): 
                            $cat = strtolower($ex['category']);
                            $catBg = '#f1f5f9';
                            $catColor = '#475569';
                            $catIcon = 'fa-tag';

                            if ($cat === 'fuel') {
                                $catBg = '#fef3c7';
                                $catColor = '#b45309';
                                $catIcon = 'fa-motorcycle';
                            } elseif ($cat === 'travel') {
                                $catBg = '#e0f2fe';
                                $catColor = '#0284c7';
                                $catIcon = 'fa-car';
                            } elseif ($cat === 'food') {
                                $catBg = '#ffedd5';
                                $catColor = '#c2410c';
                                $catIcon = 'fa-cutlery';
                            } elseif ($cat === 'medical_supplies') {
                                $catBg = '#f3e8ff';
                                $catColor = '#7e22ce';
                                $catIcon = 'fa-medkit';
                            }

                            $st = $ex['status'];
                            $statusBg = '#fef3c7';
                            $statusColor = '#92400e';
                            $dotColor = '#d97706';

                            if ($st === 'approved') {
                                $statusBg = '#e0f2fe';
                                $statusColor = '#0369a1';
                                $dotColor = '#0284c7';
                            } elseif ($st === 'reimbursed') {
                                $statusBg = '#dcfce7';
                                $statusColor = '#166534';
                                $dotColor = '#16a34a';
                            } elseif ($st === 'rejected') {
                                $statusBg = '#fee2e2';
                                $statusColor = '#991b1b';
                                $dotColor = '#dc2626';
                            }

                            $initials = strtoupper(substr($ex['employee_name'], 0, 1));
                        ?>
                        <tr class="expense-row" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                            <td style="padding: 16px 20px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: 10px; background: #0f172a; color: #ffffff; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <?= $initials; ?>
                                    </div>
                                    <div>
                                        <div style="font-weight: 800; color: #0f172a; font-size: 14px; line-height: 1.3;">
                                            <?= html_escape($ex['employee_name']); ?>
                                        </div>
                                        <span style="font-family: monospace; font-size: 11px; color: #64748b; font-weight: 600;">
                                            <?= html_escape($ex['staff_code']); ?> &bull; <?= strtoupper(html_escape($ex['role'])); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td style="padding: 16px 20px;">
                                <span style="display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; background: <?= $catBg; ?>; color: <?= $catColor; ?>;">
                                    <i class="fa <?= $catIcon; ?>"></i> <?= str_replace('_', ' ', $ex['category']); ?>
                                </span>
                            </td>

                            <td style="padding: 16px 20px;">
                                <strong style="color: #15803d; font-size: 15px; font-weight: 900;">₹<?= number_format($ex['amount'], 2); ?></strong>
                            </td>

                            <td style="padding: 16px 20px; color: #334155; font-size: 13px;">
                                <i class="fa fa-calendar-o" style="color: #94a3b8; margin-right: 4px;"></i>
                                <?= date('d M Y', strtotime($ex['expense_date'])); ?>
                            </td>

                            <td style="padding: 16px 20px; max-width: 260px;">
                                <div style="font-size: 12.5px; color: #334155; line-height: 1.4; background: #f8fafc; padding: 8px 12px; border-radius: 8px; border-left: 3px solid #cbd5e1;">
                                    <?= html_escape($ex['description']); ?>
                                </div>
                            </td>

                            <td style="padding: 16px 20px;">
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: <?= $statusBg; ?>; color: <?= $statusColor; ?>; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: <?= $dotColor; ?>;"></span>
                                    <?= strtoupper($ex['status']); ?>
                                </span>
                            </td>

                            <?php if ($canManage): ?>
                            <td style="padding: 16px 20px; text-align: right;">
                                <?php if ($ex['status'] === 'submitted' || $ex['status'] === 'pending'): ?>
                                    <div style="display: inline-flex; gap: 6px;">
                                        <button type="button" class="btn btn-xs btn-expense-action" data-id="<?= $ex['id']; ?>" data-status="approved" style="background: #10b981; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 5px 10px; font-size: 12px; border: none; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);">
                                            <i class="fa fa-check"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-xs btn-expense-action" data-id="<?= $ex['id']; ?>" data-status="rejected" style="background: #ef4444; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 5px 10px; font-size: 12px; border: none; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                    </div>
                                <?php elseif ($ex['status'] === 'approved'): ?>
                                    <button type="button" class="btn btn-xs btn-expense-action" data-id="<?= $ex['id']; ?>" data-status="reimbursed" style="background: #0284c7; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 5px 12px; font-size: 12px; border: none; box-shadow: 0 2px 4px rgba(2, 132, 199, 0.2);">
                                        <i class="fa fa-money"></i> Mark Reimbursed
                                    </button>
                                <?php else: ?>
                                    <span style="font-size: 11.5px; color: #64748b;">
                                        Processed by <strong><?= html_escape($ex['approver_name'] ?: 'Operations Lead'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= $canManage ? '7' : '6'; ?>" style="text-align: center; color: #94a3b8; padding: 48px 20px;">
                                <i class="fa fa-credit-card" style="font-size: 32px; color: #cbd5e1; display: block; margin-bottom: 12px;"></i>
                                <strong style="font-size: 14px; color: #475569;">No expense claims found</strong>
                                <p style="font-size: 12.5px; color: #94a3b8; margin: 4px 0 0 0;">Click "+ Submit Expense Claim" to submit fuel, travel, or procurement receipts.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Submit Expense Claim -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 18px 24px; border: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 24px;">&times;</button>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(16, 185, 129, 0.2); color: #34d399; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" style="font-weight: 800; font-size: 16px; margin: 0; color: #ffffff;">Submit Staff Expense Voucher</h4>
                        <small style="color: #94a3b8; font-size: 11.5px;">Log reimbursement for field fuel, logistics travel, or medical consumables</small>
                    </div>
                </div>
            </div>

            <form action="<?= base_url('operations/save_expense'); ?>" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-body" style="padding: 24px; background: #ffffff;">
                    <div style="display: grid; gap: 16px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                                    Expense Category <span style="color: #ef4444;">*</span>
                                </label>
                                <select name="category" class="form-control" required style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                                    <option value="fuel">Fuel / Petrol Allowance</option>
                                    <option value="travel">Inter-city / Transit Travel</option>
                                    <option value="food">Meals on Field Duty</option>
                                    <option value="medical_supplies">Medical Consumables / Cotton</option>
                                    <option value="miscellaneous">Miscellaneous Petty Cash</option>
                                </select>
                            </div>

                            <div>
                                <label style="font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                                    Amount in INR (₹) <span style="color: #ef4444;">*</span>
                                </label>
                                <div style="position: relative;">
                                    <span style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-weight: 700;">₹</span>
                                    <input type="number" name="amount" class="form-control" placeholder="0.00" step="0.5" required style="padding-left: 30px; height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 700;">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                                Expense Date <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="date" name="expense_date" class="form-control" value="<?= date('Y-m-d'); ?>" required style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                        </div>

                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
                                Detailed Description &amp; Bill Reference <span style="color: #ef4444;">*</span>
                            </label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Provide bill details, vehicle odometer readings, or clinic visit purpose..." required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 9px 18px; font-size: 13px; border: 1px solid #cbd5e1;">
                        Cancel
                    </button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-weight: 700; border-radius: 8px; padding: 9px 22px; font-size: 13px; border: none; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);">
                        <i class="fa fa-check"></i> Submit Claim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AJAX Action & Search Script -->
<script>
$(document).ready(function() {
    $('.btn-expense-action').click(function() {
        var expenseId = $(this).data('id');
        var status    = $(this).data('status');
        var confirmMsg = 'Confirm ' + status.toUpperCase() + ' for this expense claim?';

        if (confirm(confirmMsg)) {
            var $btn = $(this);
            $btn.prop('disabled', true);
            $.post('<?= base_url("operations/update_expense"); ?>', {
                expense_id: expenseId,
                status: status,
                '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
            }, function(res) {
                alert(res.message);
                location.reload();
            }, 'json').fail(function() {
                alert('An error occurred. Please try again.');
                $btn.prop('disabled', false);
            });
        }
    });

    $('#expenseSearchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#expensesTable tbody tr.expense-row').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
