<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Central Logistics &amp; Operations Desk
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Verify doorstep diagnostic sample handoffs and process staff travel &amp; petty cash reimbursements.
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="<?=base_url('operations/handoffs');?>" class="btn" style="background: var(--ops-indigo); color: #fff; font-weight: 700; border-radius: 8px; padding: 9px 18px; font-size: 13px;">
            <i class="fa fa-barcode"></i> Verify Sample Handoff
        </a>
    </div>
</div>

<!-- Metrics Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="ops-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Verified Handoffs</div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=count($handoffs);?></div>
        <div style="font-size: 12px; color: #16a34a; font-weight: 600; margin-top: 4px;">
            <i class="fa fa-check-circle"></i> Received at Central Lab
        </div>
    </div>

    <div class="ops-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Pending Expense Claims</div>
        <div style="font-size: 26px; font-weight: 800; color: #d97706; margin-top: 4px;"><?=count($expenses);?></div>
        <div style="font-size: 12px; color: #d97706; font-weight: 600; margin-top: 4px;">
            <a href="<?=base_url('operations/expenses');?>" style="color: inherit;">Review Claims &rarr;</a>
        </div>
    </div>
</div>

<!-- Recent Sample Handoffs Table -->
<div class="ops-card" style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">
            <i class="fa fa-flask" style="color: var(--ops-indigo); margin-right: 6px;"></i> Central Diagnostic Lab Sample Inward Log
        </h4>
        <a href="<?=base_url('operations/handoffs');?>" class="btn btn-xs btn-default" style="font-weight: 700; border-radius: 6px;">
            Full Handoff Desk &rarr;
        </a>
    </div>

    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11.5px; color: #64748b; text-transform: uppercase;">
                    <th>Sample Barcode</th>
                    <th>Patient Name</th>
                    <th>Phlebotomist</th>
                    <th>Received Time</th>
                    <th>Condition</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($handoffs)): ?>
                    <?php foreach ($handoffs as $h): ?>
                    <tr>
                        <td>
                            <strong style="font-family: monospace; color: #0284c7; font-size: 14px;"><?=$h['barcode'];?></strong>
                            <small style="display: block; color: #64748b;">Order #<?=$h['booking_id'];?></small>
                        </td>
                        <td style="font-weight: 700; color: #1e293b;">
                            <?=html_escape($h['patient_name'] ?: 'Patient Sample');?>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #334155;"><?=html_escape($h['collector_name'] ?: 'Collector');?></div>
                            <small style="color: #64748b; font-family: monospace;"><?=$h['collector_code'];?></small>
                        </td>
                        <td style="color: #64748b; font-size: 13px;">
                            <?=date('d M, h:i A', strtotime($h['handoff_time']));?>
                        </td>
                        <td>
                            <span class="badge" style="background: #dcfce7; color: #15803d; text-transform: uppercase; font-size: 11px;">
                                <?=html_escape($h['sample_condition']);?>
                            </span>
                        </td>
                        <td>
                            <span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                <?=$h['status'];?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No sample handoffs logged yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
