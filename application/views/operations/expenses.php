<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Staff Expense &amp; Reimbursement Desk
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Submit field fuel, vehicle transport, and petty cash expense claims for rapid approval.
        </p>
    </div>
    <div>
        <button type="button" class="btn" data-toggle="modal" data-target="#addExpenseModal" style="background: var(--ops-indigo); color: #fff; font-weight: 700; border-radius: 8px; padding: 9px 18px; font-size: 13px;">
            <i class="fa fa-plus-circle"></i> Submit Expense Claim
        </button>
    </div>
</div>

<!-- Flash Alerts -->
<?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success" style="border-radius: 10px; font-size: 13.5px;">
        <i class="fa fa-check-circle"></i> <?=$this->session->flashdata('success_msg');?>
    </div>
<?php endif; ?>

<!-- Expense Claims Table -->
<div class="ops-card" style="padding: 20px;">
    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11.5px; color: #64748b; text-transform: uppercase;">
                    <th>Staff Member</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Status</th>
                    <?php if (in_array($this->session->userdata('staff_role'), ['super_admin', 'hr', 'office_staff'])): ?>
                        <th style="text-align: right;">Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($expenses)): ?>
                    <?php foreach ($expenses as $ex): 
                        $statusClass = ($ex['status'] === 'reimbursed' || $ex['status'] === 'approved') ? 'label-success' : (($ex['status'] === 'rejected') ? 'label-danger' : 'label-warning');
                    ?>
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;"><?=html_escape($ex['employee_name']);?></div>
                            <small style="color: #64748b; font-family: monospace;"><?=$ex['staff_code'];?> &bull; <?=strtoupper($ex['role']);?></small>
                        </td>
                        <td>
                            <span class="badge" style="background: #e0e7ff; color: #3730a3; text-transform: uppercase; font-size: 11px;">
                                <?=str_replace('_', ' ', $ex['category']);?>
                            </span>
                        </td>
                        <td>
                            <strong style="color: #15803d; font-size: 14px;">₹<?=number_format($ex['amount'], 2);?></strong>
                        </td>
                        <td style="color: #334155; font-size: 13px;">
                            <?=date('d M Y', strtotime($ex['expense_date']));?>
                        </td>
                        <td style="max-width: 250px; font-size: 12.5px; color: #475569;">
                            <?=html_escape($ex['description']);?>
                        </td>
                        <td>
                            <span class="label <?=$statusClass;?>" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                <?=$ex['status'];?>
                            </span>
                        </td>
                        <?php if (in_array($this->session->userdata('staff_role'), ['super_admin', 'hr', 'office_staff'])): ?>
                        <td style="text-align: right;">
                            <?php if ($ex['status'] === 'submitted'): ?>
                                <button type="button" class="btn btn-xs btn-success btn-expense-action" data-id="<?=$ex['id'];?>" data-status="approved" style="font-weight: 700; border-radius: 6px; padding: 4px 8px;">
                                    Approve
                                </button>
                                <button type="button" class="btn btn-xs btn-danger btn-expense-action" data-id="<?=$ex['id'];?>" data-status="rejected" style="font-weight: 700; border-radius: 6px; padding: 4px 8px;">
                                    Reject
                                </button>
                            <?php elseif ($ex['status'] === 'approved'): ?>
                                <button type="button" class="btn btn-xs btn-primary btn-expense-action" data-id="<?=$ex['id'];?>" data-status="reimbursed" style="font-weight: 700; border-radius: 6px; padding: 4px 8px;">
                                    Mark Reimbursed
                                </button>
                            <?php else: ?>
                                <small style="color: #94a3b8; font-size: 11px;">Approved by <?=$ex['approver_name'] ?: 'Ops';?></small>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No expense claims logged.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Submit Expense -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 16px; padding: 10px;">
            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; color: #0f172a;">Submit Expense Claim</h4>
            </div>
            <form action="<?=base_url('operations/save_expense');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="modal-body" style="display: grid; gap: 14px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Category *</label>
                            <select name="category" class="form-control" style="border-radius: 8px;">
                                <option value="fuel">Bike / Vehicle Fuel</option>
                                <option value="transport">Public Transport / Metro</option>
                                <option value="petty_cash">Petty Cash &amp; Supplies</option>
                                <option value="client_entertainment">Client Meeting Refreshment</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Claim Amount (₹) *</label>
                            <input type="number" step="0.01" name="amount" class="form-control" placeholder="e.g. 350.00" required style="border-radius: 8px;">
                        </div>
                    </div>
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Expense Date *</label>
                        <input type="date" name="expense_date" class="form-control" value="<?=date('Y-m-d');?>" required style="border-radius: 8px;">
                    </div>
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Description / Purpose *</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="e.g. Fuel for 8 doorstep sample pickups across Aliganj and Gomti Nagar" required style="border-radius: 8px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn" style="background: var(--ops-indigo); color: #fff; font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-send"></i> Submit Claim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('.btn-expense-action').click(function() {
    var exId   = $(this).data('id');
    var status = $(this).data('status');
    if (confirm('Confirm marking this expense as ' + status.toUpperCase() + '?')) {
        $.post('<?=base_url("operations/update_expense");?>', { expense_id: exId, status: status }, function(res) {
            alert(res.message);
            location.reload();
        }, 'json');
    }
});
</script>
