<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.crm-contacts-table {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
}
.crm-table-filter-bar {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}
.crm-badge-stage-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.crm-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #0f172a;
    color: #ffffff;
    padding: 14px 20px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    display: none;
    z-index: 9999;
    font-size: 13.5px;
    font-weight: 600;
    border-left: 4px solid #10b981;
}
</style>

<div class="crm-toast" id="crmContactsToast">
    <i class="fa fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>
    <span id="crmContactsToastMsg">Updated successfully!</span>
</div>

<!-- Page Title & Header Actions -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Partner &amp; Client Directory
        </h1>
        <p style="margin: 0; font-size: 13px; color: #64748b;">
            Comprehensive database of registered hospitals, clinics, diagnostic labs, and medical partners.
        </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="<?=base_url('crm/leads');?>" class="btn" style="background: #ffffff; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; border: 1px solid #cbd5e1;">
            <i class="fa fa-columns" style="color: #f59e0b;"></i> Kanban Pipeline
        </a>
        <button type="button" class="btn" data-toggle="modal" data-target="#registerLeadModal" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 10px; padding: 9px 20px; font-size: 13px; border: none; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);">
            <i class="fa fa-plus-circle" style="color: #2dd4bf;"></i> Add New Partner
        </button>
    </div>
</div>

<!-- Filters & Search Bar -->
<div class="crm-table-filter-bar">
    <form method="get" action="<?=base_url('crm/contacts');?>" style="display: flex; gap: 10px; flex-grow: 1; align-items: center; flex-wrap: wrap; margin: 0;">
        <!-- Search Input -->
        <div style="position: relative; min-width: 240px; flex-grow: 1;">
            <i class="fa fa-search" style="position: absolute; left: 12px; top: 11px; color: #94a3b8;"></i>
            <input type="text" name="search" value="<?=html_escape($filters['search'] ?? '');?>" class="form-control" placeholder="Search by name, contact, phone, city..." style="padding-left: 36px; border-radius: 9px; height: 38px;">
        </div>

        <!-- Facility Type Filter -->
        <select name="type" class="form-control" style="width: 150px; border-radius: 9px; height: 38px; font-weight: 600;">
            <option value="">All Types</option>
            <option value="hospital" <?=($filters['facility_type'] ?? '')=='hospital'?'selected':'';?>>Hospitals</option>
            <option value="clinic" <?=($filters['facility_type'] ?? '')=='clinic'?'selected':'';?>>Clinics</option>
            <option value="diagnostic_lab" <?=($filters['facility_type'] ?? '')=='diagnostic_lab'?'selected':'';?>>Labs</option>
            <option value="pharmacy" <?=($filters['facility_type'] ?? '')=='pharmacy'?'selected':'';?>>Pharmacies</option>
        </select>

        <!-- Stage Filter -->
        <select name="stage" class="form-control" style="width: 160px; border-radius: 9px; height: 38px; font-weight: 600;">
            <option value="">All Stages</option>
            <option value="new" <?=($filters['stage'] ?? '')=='new'?'selected':'';?>>New Inquiry</option>
            <option value="contacted" <?=($filters['stage'] ?? '')=='contacted'?'selected':'';?>>Contacted</option>
            <option value="meeting_scheduled" <?=($filters['stage'] ?? '')=='meeting_scheduled'?'selected':'';?>>Meeting Fixed</option>
            <option value="proposal_sent" <?=($filters['stage'] ?? '')=='proposal_sent'?'selected':'';?>>Proposal Sent</option>
            <option value="signed" <?=($filters['stage'] ?? '')=='signed'?'selected':'';?>>Signed Partner</option>
            <option value="lost" <?=($filters['stage'] ?? '')=='lost'?'selected':'';?>>Cold / Lost</option>
        </select>

        <!-- Priority Filter -->
        <select name="priority" class="form-control" style="width: 140px; border-radius: 9px; height: 38px; font-weight: 600;">
            <option value="">All Priorities</option>
            <option value="urgent" <?=($filters['priority'] ?? '')=='urgent'?'selected':'';?>>Urgent</option>
            <option value="high" <?=($filters['priority'] ?? '')=='high'?'selected':'';?>>High</option>
            <option value="medium" <?=($filters['priority'] ?? '')=='medium'?'selected':'';?>>Medium</option>
            <option value="low" <?=($filters['priority'] ?? '')=='low'?'selected':'';?>>Low</option>
        </select>

        <button type="submit" class="btn btn-default" style="border-radius: 9px; height: 38px; font-weight: 700; padding: 0 16px;">
            <i class="fa fa-filter"></i> Filter
        </button>
        <?php if (!empty($filters)): ?>
        <a href="<?=base_url('crm/contacts');?>" class="btn btn-link" style="color: #ef4444; font-size: 12px; font-weight: 600;">
            Clear
        </a>
        <?php endif; ?>
    </form>
    <div style="font-size: 13px; color: #64748b; font-weight: 600;">
        Total: <strong style="color: #0f172a;"><?=count($leads);?></strong> Partners
    </div>
</div>

<!-- Master Table -->
<div class="crm-contacts-table">
    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 14px 18px; border: none;">Facility &amp; Location</th>
                    <th style="padding: 14px 18px; border: none;">Type</th>
                    <th style="padding: 14px 18px; border: none;">Contact Details</th>
                    <th style="padding: 14px 18px; border: none;">Priority &amp; Source</th>
                    <th style="padding: 14px 18px; border: none;">Est. Revenue</th>
                    <th style="padding: 14px 18px; border: none;">Current Stage</th>
                    <th style="padding: 14px 18px; border: none; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($leads)): ?>
                    <?php foreach ($leads as $l): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <!-- Facility -->
                        <td style="padding: 14px 18px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; flex-shrink: 0;">
                                    <?=strtoupper(substr($l['facility_name'], 0, 1));?>
                                </div>
                                <div>
                                    <strong style="color: #0f172a; font-size: 14px; display: block; line-height: 1.2;">
                                        <?=html_escape($l['facility_name']);?>
                                    </strong>
                                    <div style="font-size: 11.5px; color: #94a3b8; margin-top: 2px;">
                                        <i class="fa fa-map-marker"></i> <?=html_escape($l['city']);?>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Type -->
                        <td style="padding: 14px 18px;">
                            <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11px; text-transform: uppercase; font-weight: 700; padding: 4px 8px;">
                                <?=ucwords(str_replace('_', ' ', $l['facility_type']));?>
                            </span>
                        </td>

                        <!-- Contact -->
                        <td style="padding: 14px 18px;">
                            <strong style="font-size: 13px; color: #0f172a; display: block;">
                                <?=html_escape($l['contact_person']);?>
                            </strong>
                            <div style="font-size: 12px; margin-top: 2px;">
                                <a href="tel:<?=$l['phone'];?>" style="color: #0284c7; text-decoration: none; font-weight: 600;">
                                    <i class="fa fa-phone"></i> <?=$l['phone'];?>
                                </a>
                            </div>
                            <?php if (!empty($l['email'])): ?>
                            <div style="font-size: 11px; color: #94a3b8;">
                                <i class="fa fa-envelope-o"></i> <?=$l['email'];?>
                            </div>
                            <?php endif; ?>
                        </td>

                        <!-- Priority & Source -->
                        <td style="padding: 14px 18px;">
                            <?php
                            $prio = $l['priority'] ?? 'medium';
                            $prioColors = [
                                'urgent' => ['#fee2e2', '#b91c1c'],
                                'high' => ['#ffedd5', '#c2410c'],
                                'medium' => ['#e0f2fe', '#0369a1'],
                                'low' => ['#f1f5f9', '#64748b']
                            ];
                            $pc = $prioColors[$prio] ?? ['#f1f5f9', '#64748b'];
                            ?>
                            <span style="background: <?=$pc[0];?>; color: <?=$pc[1];?>; font-size: 10.5px; font-weight: 800; padding: 3px 8px; border-radius: 5px; text-transform: uppercase;">
                                <?=$prio === 'urgent' ? '🔥 Urgent' : ucfirst($prio);?>
                            </span>
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                                Src: <?=html_escape($l['source'] ?: 'Direct Visit');?>
                            </div>
                        </td>

                        <!-- Revenue -->
                        <td style="padding: 14px 18px;">
                            <strong style="color: #15803d; font-size: 13.5px; display: block;">
                                ₹<?=number_format($l['est_monthly_revenue'], 0);?>/mo
                            </strong>
                            <span style="font-size: 11px; color: #64748b;">
                                <?=$l['commission_pct'];?>% rev share
                            </span>
                        </td>

                        <!-- Stage -->
                        <td style="padding: 14px 18px;">
                            <?php
                            $stageMap = [
                                'new' => ['New Inquiry', '#64748b', '#f1f5f9'],
                                'contacted' => ['Contacted', '#0284c7', '#e0f2fe'],
                                'meeting_scheduled' => ['Meeting Fixed', '#d97706', '#fef3c7'],
                                'proposal_sent' => ['Proposal Sent', '#8b5cf6', '#f3e8ff'],
                                'signed' => ['MoU Signed 🎉', '#10b981', '#d1fae5'],
                                'lost' => ['Cold / Lost', '#ef4444', '#fee2e2']
                            ];
                            $stInfo = $stageMap[$l['lead_stage']] ?? ['New', '#64748b', '#f1f5f9'];
                            ?>
                            <span class="crm-badge-stage-pill" style="background: <?=$stInfo[2];?>; color: <?=$stInfo[1];?>;">
                                <?=$stInfo[0];?>
                            </span>
                            <?php if (!empty($l['next_followup_date'])): ?>
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                                <i class="fa fa-clock-o"></i> Next: <?=$l['next_followup_date'];?>
                            </div>
                            <?php endif; ?>
                        </td>

                        <!-- Actions -->
                        <td style="padding: 14px 18px; text-align: right;">
                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                <button type="button" class="btn btn-xs btn-default btn-open-act-modal" data-id="<?=$l['id'];?>" data-name="<?=html_escape($l['facility_name']);?>" title="Log Call/Follow-up" style="border-radius: 7px; padding: 5px 9px;">
                                    <i class="fa fa-phone" style="color: #00a896;"></i>
                                </button>
                                <?php if ($l['lead_stage'] === 'signed'): ?>
                                <a href="<?=base_url('crm/onboard_partner/' . $l['id']);?>" class="btn btn-xs btn-success" title="Onboard" style="border-radius: 7px; font-weight: 700; padding: 5px 9px;">
                                    <i class="fa fa-plug"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                        <i class="fa fa-users" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                        No partners matched the search criteria.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Quick Log Activity -->
<div class="modal fade" id="contactActModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 16px 20px; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 16px;">
                    <i class="fa fa-phone" style="color: #00a896; margin-right: 6px;"></i> Log Activity for <span id="contactModalTitle" style="color: #2dd4bf;">Partner</span>
                </h4>
            </div>
            <form id="contactActForm">
                <input type="hidden" name="lead_id" id="contactModalLeadId" value="">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="modal-body" style="padding: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Type</label>
                            <select name="activity_type" class="form-control" style="border-radius: 8px;">
                                <option value="call">📞 Phone Call</option>
                                <option value="meeting">🤝 Meeting</option>
                                <option value="site_visit">🏥 Site Visit</option>
                                <option value="whatsapp">💬 WhatsApp</option>
                                <option value="proposal">📄 Proposal</option>
                                <option value="note">📝 Note</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Next Follow-up</label>
                            <input type="date" name="followup_date" class="form-control" value="<?=date('Y-m-d', strtotime('+3 days'));?>" style="border-radius: 8px;">
                        </div>
                    </div>
                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Subject / Summary *</label>
                        <input type="text" name="summary" class="form-control" placeholder="Summary of discussion" required style="border-radius: 8px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Key outcomes, next steps..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 8px; font-weight: 700;">
                        Save Activity
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function showToast(msg) {
        $('#crmContactsToastMsg').text(msg);
        $('#crmContactsToast').fadeIn(200).delay(2500).fadeOut(200);
    }

    $(document).on('click', '.btn-open-act-modal', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#contactModalLeadId').val(id);
        $('#contactModalTitle').text(name);
        $('#contactActModal').modal('show');
    });

    $('#contactActForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("crm/log_activity");?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#contactActModal').modal('hide');
                    $('#contactActForm')[0].reset();
                    showToast(res.message);
                } else {
                    alert(res.message || 'Error saving activity.');
                }
            },
            error: function() {
                alert('Connection error. Please try again.');
            }
        });
    });
});
</script>
