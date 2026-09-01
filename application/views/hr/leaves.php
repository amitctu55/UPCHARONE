<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Leave Management &amp; Approvals
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Review employee time-off requests, sick leaves, and vacation balances.
        </p>
    </div>
</div>

<!-- Filters -->
<div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 14px 18px; margin-bottom: 20px; display: flex; gap: 8px;">
    <a href="<?=base_url('hr/leaves');?>" class="btn btn-sm <?=empty($selected_status) ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
        All Applications
    </a>
    <a href="<?=base_url('hr/leaves?status=pending');?>" class="btn btn-sm <?=$selected_status==='pending' ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
        Pending Action
    </a>
    <a href="<?=base_url('hr/leaves?status=approved');?>" class="btn btn-sm <?=$selected_status==='approved' ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
        Approved
    </a>
    <a href="<?=base_url('hr/leaves?status=rejected');?>" class="btn btn-sm <?=$selected_status==='rejected' ? 'btn-primary' : 'btn-default';?>" style="border-radius: 6px; font-weight: 700;">
        Rejected
    </a>
</div>

<!-- Leaves Table -->
<div class="hr-kpi-card" style="padding: 20px;">
    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11.5px; color: #64748b; text-transform: uppercase;">
                    <th>Employee</th>
                    <th>Leave Type &amp; Dates</th>
                    <th>Duration</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($leaves)): ?>
                    <?php foreach ($leaves as $l): 
                        $statusClass = ($l['status'] === 'approved') ? 'label-success' : (($l['status'] === 'rejected') ? 'label-danger' : 'label-warning');
                    ?>
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;"><?=html_escape($l['employee_name']);?></div>
                            <small style="color: #64748b; font-family: monospace;"><?=$l['staff_code'];?> &bull; <?=strtoupper($l['role']);?></small>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0284c7; font-size: 13px; text-transform: capitalize;">
                                <?=html_escape($l['leave_type']);?> Leave
                            </div>
                            <small style="color: #64748b;">
                                <?=date('d M', strtotime($l['start_date']));?> &rarr; <?=date('d M Y', strtotime($l['end_date']));?>
                            </small>
                        </td>
                        <td>
                            <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 12px; padding: 4px 8px;">
                                <?=$l['days_count'];?> Day<?=$l['days_count']>1 ? 's' : '';?>
                            </span>
                        </td>
                        <td style="max-width: 250px; font-size: 12.5px; color: #475569;">
                            <?=html_escape($l['reason']);?>
                        </td>
                        <td>
                            <span class="label <?=$statusClass;?>" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                <?=$l['status'];?>
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <?php if ($l['status'] === 'pending'): ?>
                                <button type="button" class="btn btn-xs btn-success btn-leave-action" data-id="<?=$l['id'];?>" data-status="approved" style="font-weight: 700; border-radius: 6px; padding: 5px 10px;">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                                <button type="button" class="btn btn-xs btn-danger btn-leave-action" data-id="<?=$l['id'];?>" data-status="rejected" style="font-weight: 700; border-radius: 6px; padding: 5px 10px;">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                            <?php else: ?>
                                <small style="color: #94a3b8; font-size: 11.5px;">Reviewed by <?=$l['reviewer_name'] ?: 'HR';?></small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No leave applications found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$('.btn-leave-action').click(function() {
    var leaveId = $(this).data('id');
    var status  = $(this).data('status');
    if (confirm('Confirm ' + status.toUpperCase() + ' for this leave application?')) {
        $.post('<?=base_url("hr/update_leave");?>', { leave_id: leaveId, status: status }, function(res) {
            alert(res.message);
            location.reload();
        }, 'json');
    }
});
</script>
