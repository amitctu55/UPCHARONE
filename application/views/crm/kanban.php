<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Partner Acquisition Kanban Board
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Drag, track, and advance provider leads through pipeline milestones.
        </p>
    </div>
    <div>
        <button type="button" class="btn" data-toggle="modal" data-target="#addLeadModal" style="background: var(--crm-amber); color: #fff; font-weight: 700; border-radius: 8px; padding: 9px 18px; font-size: 13px;">
            <i class="fa fa-plus-circle"></i> Add New Partner Lead
        </button>
    </div>
</div>

<style>
.kanban-board-wrapper {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 24px;
    align-items: flex-start;
}
.kanban-col {
    background: #f1f5f9;
    border-radius: 14px;
    width: 300px;
    min-width: 300px;
    flex-shrink: 0;
    padding: 14px;
    border: 1px solid #e2e8f0;
}
.kanban-card-item {
    background: #ffffff;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    transition: all 0.2s;
}
.kanban-card-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}
</style>

<!-- Kanban Columns Grid -->
<div class="kanban-board-wrapper">
    <?php foreach ($kanban as $stageKey => $col): ?>
    <div class="kanban-col">
        <!-- Column Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: <?=$col['color'];?>;"></span>
                <strong style="font-size: 13.5px; color: #0f172a;"><?=$col['title'];?></strong>
            </div>
            <span class="badge" style="background: #ffffff; color: #475569; font-weight: 800; border: 1px solid #cbd5e1;">
                <?=count($col['items']);?>
            </span>
        </div>

        <!-- Cards List -->
        <?php if (!empty($col['items'])): ?>
            <?php foreach ($col['items'] as $item): ?>
            <div class="kanban-card-item">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                    <strong style="font-size: 14px; color: #0f172a; line-height: 1.2;">
                        <?=html_escape($item['facility_name']);?>
                    </strong>
                    <span class="badge" style="font-size: 10px; background: #e0f2fe; color: #0369a1; text-transform: uppercase;">
                        <?=$item['facility_type'];?>
                    </span>
                </div>

                <div style="font-size: 12px; color: #64748b; margin-bottom: 8px;">
                    <i class="fa fa-user"></i> <?=html_escape($item['contact_person']);?> &bull; <i class="fa fa-phone"></i> <?=$item['phone'];?>
                </div>

                <div style="background: #f8fafc; border-radius: 6px; padding: 8px 10px; margin-bottom: 10px; display: flex; justify-content: space-between; font-size: 12px;">
                    <span style="color: #64748b;">Est. Rev:</span>
                    <strong style="color: #15803d;">₹<?=number_format($item['est_monthly_revenue'], 2);?></strong>
                </div>

                <!-- Stage Mover Dropdown -->
                <div style="display: flex; gap: 6px; align-items: center;">
                    <select class="form-control input-sm stage-mover-select" data-id="<?=$item['id'];?>" style="font-size: 11.5px; height: 30px; border-radius: 6px; font-weight: 600;">
                        <option value="new" <?=$item['lead_stage']=='new'?'selected':'';?>>Move &rarr; New Lead</option>
                        <option value="contacted" <?=$item['lead_stage']=='contacted'?'selected':'';?>>Move &rarr; Contacted</option>
                        <option value="meeting_scheduled" <?=$item['lead_stage']=='meeting_scheduled'?'selected':'';?>>Move &rarr; Meeting Fixed</option>
                        <option value="proposal_sent" <?=$item['lead_stage']=='proposal_sent'?'selected':'';?>>Move &rarr; Proposal Sent</option>
                        <option value="signed" <?=$item['lead_stage']=='signed'?'selected':'';?>>Move &rarr; Partner Signed 🎉</option>
                        <option value="lost" <?=$item['lead_stage']=='lost'?'selected':'';?>>Move &rarr; Lost / Inactive</option>
                    </select>

                    <?php if ($item['lead_stage'] === 'signed'): ?>
                        <a href="<?=base_url('crm/onboard_partner/' . $item['id']);?>" class="btn btn-xs btn-success" title="Onboard to Portal" style="font-weight: 700; border-radius: 6px; padding: 5px 8px; flex-shrink: 0;">
                            <i class="fa fa-user-plus"></i> Onboard
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; color: #94a3b8; font-size: 12px; padding: 20px 0;">
                No leads in this stage
            </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal: Add New Lead -->
<div class="modal fade" id="addLeadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 16px; padding: 10px;">
            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; color: #0f172a;">Add Partner Lead</h4>
            </div>
            <form action="<?=base_url('crm/save_lead');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="modal-body" style="display: grid; gap: 14px;">
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Hospital / Clinic / Lab Name *</label>
                        <input type="text" name="facility_name" class="form-control" placeholder="e.g. CareWell Diagnostic &amp; Multispeciality" required style="border-radius: 8px;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Facility Type *</label>
                            <select name="facility_type" class="form-control" style="border-radius: 8px;">
                                <option value="clinic">Clinic / Doctor OPD</option>
                                <option value="hospital">Hospital</option>
                                <option value="diagnostic_lab">Diagnostic / Pathology Lab</option>
                                <option value="pharmacy">Pharmacy / Chemist</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">City</label>
                            <input type="text" name="city" class="form-control" value="Lucknow" style="border-radius: 8px;">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Contact Person *</label>
                            <input type="text" name="contact_person" class="form-control" placeholder="Dr. / Director Name" required style="border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Mobile Phone *</label>
                            <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile" required style="border-radius: 8px;">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Est. Monthly Revenue (₹)</label>
                            <input type="number" name="est_monthly_revenue" class="form-control" value="50000" style="border-radius: 8px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Referral / Commission (%)</label>
                            <input type="number" name="commission_pct" class="form-control" value="10" style="border-radius: 8px;">
                        </div>
                    </div>
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Notes / Follow-up Details</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Discussed OPD integration, director agreed for demo next Tuesday" style="border-radius: 8px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn" style="background: var(--crm-amber); color: #fff; font-weight: 700; border-radius: 8px;">
                        <i class="fa fa-plus"></i> Add to Pipeline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('.stage-mover-select').change(function() {
    var leadId = $(this).data('id');
    var newSt  = $(this).val();
    $.post('<?=base_url("crm/update_stage");?>', { lead_id: leadId, stage: newSt }, function(res) {
        if (res.status === 'success') {
            location.reload();
        } else {
            alert(res.message || 'Error updating stage');
        }
    }, 'json');
});
</script>
