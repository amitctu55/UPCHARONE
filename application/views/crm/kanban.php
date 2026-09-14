<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.kanban-board-container {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 24px;
    align-items: flex-start;
    min-height: calc(100vh - 230px);
}
.kanban-board-container::-webkit-scrollbar {
    height: 8px;
}
.kanban-board-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.kanban-col-wrapper {
    background: #f1f5f9;
    border-radius: 16px;
    width: 320px;
    min-width: 320px;
    flex-shrink: 0;
    padding: 16px;
    border: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
}
.kanban-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    position: relative;
}
.kanban-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
}
.kanban-card.overdue-card {
    border-left: 3px solid #ef4444;
}
.kanban-card-type {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
    text-transform: uppercase;
}
.kanban-priority-urgent {
    background: #fee2e2;
    color: #b91c1c;
    font-weight: 800;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 4px;
}
.kanban-priority-high {
    background: #ffedd5;
    color: #c2410c;
    font-weight: 800;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 4px;
}
.kanban-priority-medium {
    background: #e0f2fe;
    color: #0369a1;
    font-weight: 700;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 4px;
}
.kanban-priority-low {
    background: #f1f5f9;
    color: #64748b;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 4px;
}
.kanban-search-input {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 8px 14px 8px 36px;
    font-size: 13px;
    width: 240px;
    outline: none;
    transition: border-color 0.2s;
}
.kanban-search-input:focus {
    border-color: #00a896;
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

<div class="crm-toast" id="crmKanbanToast">
    <i class="fa fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>
    <span id="crmKanbanToastMsg">Stage updated successfully!</span>
</div>

<!-- Header Controls Strip -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Partner Acquisition Pipeline
        </h1>
        <p style="margin: 0; font-size: 13px; color: #64748b;">
            Visual Kanban funnel across 6 milestones. Advance leads with instant stage synchronization.
        </p>
    </div>

    <!-- Live Search & Filter Controls -->
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <!-- In-board live search -->
        <div style="position: relative;">
            <i class="fa fa-search" style="position: absolute; left: 12px; top: 11px; color: #94a3b8;"></i>
            <input type="text" id="kanbanSearchBox" class="kanban-search-input" placeholder="Filter cards by name/city...">
        </div>

        <!-- Filter by Type -->
        <select id="kanbanTypeFilter" class="form-control input-sm" style="height: 36px; border-radius: 10px; border-color: #cbd5e1; font-weight: 700; width: 140px;">
            <option value="all">All Types</option>
            <option value="hospital">Hospitals</option>
            <option value="clinic">Clinics</option>
            <option value="diagnostic_lab">Labs</option>
            <option value="pharmacy">Pharmacies</option>
        </select>

        <button type="button" class="btn" data-toggle="modal" data-target="#registerLeadModal" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 10px; padding: 8px 18px; font-size: 13px; border: none; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);">
            <i class="fa fa-plus-circle" style="color: #2dd4bf;"></i> Add Partner Lead
        </button>
    </div>
</div>

<!-- Kanban Columns Board -->
<div class="kanban-board-container" id="kanbanBoardContainer">
    <?php foreach ($kanban as $stageKey => $col): ?>
    <div class="kanban-col-wrapper" data-col-stage="<?=$stageKey;?>">
        
        <!-- Column Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: <?=$col['badge_color'];?>;"></span>
                <strong style="font-size: 13.5px; color: #0f172a; font-weight: 800;">
                    <?=$col['title'];?>
                </strong>
            </div>
            <span class="badge" style="background: <?=$col['badge_bg'];?>; color: <?=$col['badge_color'];?>; font-weight: 800; font-size: 11.5px; border: 1px solid rgba(0,0,0,0.06);">
                <?=count($col['items']);?>
            </span>
        </div>

        <!-- Column Sub-header: Estimated Revenue Sum -->
        <div style="font-size: 11.5px; color: #64748b; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between;">
            <span>Run-rate Est:</span>
            <strong style="color: #0f172a;">₹<?=number_format($col['total_rev'], 0);?></strong>
        </div>

        <!-- Cards List -->
        <div class="kanban-cards-dropzone" style="display: flex; flex-direction: column;">
            <?php if (!empty($col['items'])): ?>
                <?php foreach ($col['items'] as $item): ?>
                <?php 
                $isOverdue = (!empty($item['next_followup_date']) && $item['next_followup_date'] <= date('Y-m-d') && !in_array($item['lead_stage'], ['signed', 'lost']));
                ?>
                <div class="kanban-card <?=$isOverdue ? 'overdue-card' : '';?>" 
                     id="kCard_<?=$item['id'];?>" 
                     data-id="<?=$item['id'];?>" 
                     data-type="<?=$item['facility_type'];?>" 
                     data-name="<?=strtolower(html_escape($item['facility_name']));?>" 
                     data-city="<?=strtolower(html_escape($item['city']));?>">
                    
                    <!-- Top Type + Priority -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span class="kanban-card-type">
                            <?=ucwords(str_replace('_', ' ', $item['facility_type']));?>
                        </span>
                        <?php
                        $prio = $item['priority'] ?? 'medium';
                        $prioClass = 'kanban-priority-' . $prio;
                        ?>
                        <span class="<?=$prioClass;?>">
                            <?=$prio === 'urgent' ? '🔥 Urgent' : ucfirst($prio);?>
                        </span>
                    </div>

                    <!-- Facility Name -->
                    <strong style="font-size: 14px; color: #0f172a; display: block; line-height: 1.25; margin-bottom: 6px;">
                        <?=html_escape($item['facility_name']);?>
                    </strong>

                    <!-- Contact & Phone -->
                    <div style="font-size: 11.5px; color: #64748b; margin-bottom: 10px;">
                        <i class="fa fa-user-o"></i> <?=html_escape($item['contact_person']);?>
                        <div style="margin-top: 2px;">
                            <i class="fa fa-phone" style="color: #00a896;"></i> 
                            <a href="tel:<?=$item['phone'];?>" style="color: #0284c7; text-decoration: none; font-weight: 600;"><?=$item['phone'];?></a>
                            &bull; <?=html_escape($item['city']);?>
                        </div>
                    </div>

                    <!-- Revenue & Commission Box -->
                    <div style="background: #f8fafc; border-radius: 8px; padding: 8px 10px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 12px; border: 1px solid #f1f5f9;">
                        <div>
                            <span style="font-size: 10.5px; color: #64748b; display: block;">Est. Revenue:</span>
                            <strong style="color: #15803d; font-size: 12.5px;">₹<?=number_format($item['est_monthly_revenue'], 0);?></strong>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 10.5px; color: #64748b; display: block;">Rev Share:</span>
                            <span style="font-weight: 700; color: #0f172a;"><?=$item['commission_pct'];?>%</span>
                        </div>
                    </div>

                    <!-- Follow-up Alert badge if present -->
                    <?php if (!empty($item['next_followup_date'])): ?>
                    <div style="font-size: 11px; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; color: <?=$isOverdue ? '#ef4444' : '#64748b';?>; font-weight: <?=$isOverdue ? '700' : '600';?>;">
                        <i class="fa fa-calendar-check-o"></i>
                        <span>Next Follow-up: <?=$item['next_followup_date'];?></span>
                        <?php if ($isOverdue): ?>
                        <span class="badge" style="background: #fee2e2; color: #ef4444; font-size: 9px; padding: 2px 4px;">DUE</span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Bottom Action Controls -->
                    <div style="display: flex; gap: 6px; align-items: center; margin-top: 6px; border-top: 1px solid #f1f5f9; padding-top: 8px;">
                        <select class="form-control input-sm kanban-stage-selector" data-id="<?=$item['id'];?>" style="font-size: 11px; height: 30px; border-radius: 7px; font-weight: 700; background: #f8fafc; border-color: #cbd5e1; flex-grow: 1;">
                            <option value="new" <?=$item['lead_stage']=='new'?'selected':'';?>>Move &rarr; New Inquiry</option>
                            <option value="contacted" <?=$item['lead_stage']=='contacted'?'selected':'';?>>Move &rarr; Contacted</option>
                            <option value="meeting_scheduled" <?=$item['lead_stage']=='meeting_scheduled'?'selected':'';?>>Move &rarr; Meeting Fixed</option>
                            <option value="proposal_sent" <?=$item['lead_stage']=='proposal_sent'?'selected':'';?>>Move &rarr; Proposal Sent</option>
                            <option value="signed" <?=$item['lead_stage']=='signed'?'selected':'';?>>Move &rarr; Signed Partner 🎉</option>
                            <option value="lost" <?=$item['lead_stage']=='lost'?'selected':'';?>>Move &rarr; Cold / Lost</option>
                        </select>

                        <button type="button" class="btn btn-xs btn-default btn-log-act-modal" data-id="<?=$item['id'];?>" data-name="<?=html_escape($item['facility_name']);?>" title="Log Call/Note" style="border-radius: 7px; height: 30px; width: 32px; padding: 0; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa fa-phone" style="color: #00a896;"></i>
                        </button>

                        <?php if ($item['lead_stage'] === 'signed'): ?>
                        <a href="<?=base_url('crm/onboard_partner/' . $item['id']);?>" class="btn btn-xs btn-success" title="Onboard Partner" style="border-radius: 7px; height: 30px; padding: 5px 8px; font-weight: 700; flex-shrink: 0;">
                            <i class="fa fa-plug"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; color: #94a3b8; font-size: 12px; padding: 24px 0; background: #ffffff; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <i class="fa fa-folder-open-o" style="font-size: 20px; display: block; margin-bottom: 4px; color: #cbd5e1;"></i>
                    No leads in this stage
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal: Add New Lead -->
<div class="modal fade" id="registerLeadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 18px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 20px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 168, 150, 0.25); color: #2dd4bf; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa fa-plus-circle"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" style="font-weight: 800; color: #ffffff; margin: 0; font-size: 17px;">
                            Add Healthcare Partner Lead
                        </h4>
                        <small style="color: #94a3b8; font-size: 12px;">Capture new partner opportunity in the pipeline</small>
                    </div>
                </div>
            </div>

            <form action="<?=base_url('crm/save_lead');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="modal-body" style="padding: 24px;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Facility Name *</label>
                            <input type="text" name="facility_name" class="form-control" placeholder="e.g. Apex Diagnostics &amp; Research" required style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Facility Type *</label>
                            <select name="facility_type" class="form-control" style="border-radius: 9px; height: 40px; font-weight: 600;">
                                <option value="clinic">Clinic / Doctor OPD</option>
                                <option value="hospital">Hospital</option>
                                <option value="diagnostic_lab">Diagnostic Lab</option>
                                <option value="pharmacy">Pharmacy / Chemist</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Contact Person *</label>
                            <input type="text" name="contact_person" class="form-control" placeholder="Dr. / Director Name" required style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Mobile Phone *</label>
                            <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile" required style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">City</label>
                            <input type="text" name="city" class="form-control" value="Lucknow" style="border-radius: 9px; height: 40px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Initial Stage</label>
                            <select name="lead_stage" class="form-control" style="border-radius: 9px; height: 40px;">
                                <option value="new">New Inquiry</option>
                                <option value="contacted">Contacted</option>
                                <option value="meeting_scheduled">Meeting Fixed</option>
                                <option value="proposal_sent">Proposal Sent</option>
                                <option value="signed">Signed Partner</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Est. Monthly Rev (₹)</label>
                            <input type="number" name="est_monthly_revenue" class="form-control" value="50000" style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Priority</label>
                            <select name="priority" class="form-control" style="border-radius: 9px; height: 40px;">
                                <option value="urgent">🔥 Urgent</option>
                                <option value="high">High</option>
                                <option value="medium" selected>Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Opportunity Notes</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Key background, partnership discussion points..." style="border-radius: 9px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 9px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 9px; padding: 9px 24px; border: none;">
                        <i class="fa fa-plus"></i> Add to Pipeline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Quick Log Activity -->
<div class="modal fade" id="kanbanActModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 16px 20px; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 16px;">
                    <i class="fa fa-phone" style="color: #00a896; margin-right: 6px;"></i> Log Activity for <span id="kanbanModalLeadTitle" style="color: #2dd4bf;">Partner</span>
                </h4>
            </div>
            <form id="kanbanActForm">
                <input type="hidden" name="lead_id" id="kanbanModalLeadId" value="">
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
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Next Follow-up Date</label>
                            <input type="date" name="followup_date" class="form-control" value="<?=date('Y-m-d', strtotime('+3 days'));?>" style="border-radius: 8px;">
                        </div>
                    </div>
                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Subject / Summary *</label>
                        <input type="text" name="summary" class="form-control" placeholder="e.g. Discussed MoU legal clauses" required style="border-radius: 8px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Key outcomes, follow-up items..." style="border-radius: 8px;"></textarea>
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
        $('#crmKanbanToastMsg').text(msg);
        $('#crmKanbanToast').fadeIn(200).delay(2500).fadeOut(200);
    }

    // In-board Live Filtering (Search by Name/City + Facility Type)
    function filterCards() {
        var query = $('#kanbanSearchBox').val().toLowerCase().trim();
        var selectedType = $('#kanbanTypeFilter').val();

        $('.kanban-card').each(function() {
            var name = $(this).data('name') || '';
            var city = $(this).data('city') || '';
            var type = $(this).data('type') || '';

            var matchesQuery = (query === '' || name.indexOf(query) !== -1 || city.indexOf(query) !== -1);
            var matchesType = (selectedType === 'all' || type === selectedType);

            if (matchesQuery && matchesType) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('#kanbanSearchBox').on('keyup input', filterCards);
    $('#kanbanTypeFilter').on('change', filterCards);

    // Instant Stage Selector on Card
    $('.kanban-stage-selector').change(function() {
        var $select = $(this);
        var leadId = $select.data('id');
        var newStage = $select.val();
        var csrfName = '<?=$this->security->get_csrf_token_name();?>';
        var csrfHash = '<?=$this->security->get_csrf_hash();?>';

        var postData = { lead_id: leadId, stage: newStage };
        postData[csrfName] = csrfHash;

        $select.prop('disabled', true);
        $.ajax({
            url: '<?=base_url("crm/update_stage");?>',
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function(res) {
                $select.prop('disabled', false);
                if (res.status === 'success') {
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 600);
                } else {
                    alert(res.message || 'Error updating stage.');
                }
            },
            error: function() {
                $select.prop('disabled', false);
                alert('Connection error. Please try again.');
            }
        });
    });

    // Open Activity Modal from Card
    $(document).on('click', '.btn-log-act-modal', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#kanbanModalLeadId').val(id);
        $('#kanbanModalLeadTitle').text(name);
        $('#kanbanActModal').modal('show');
    });

    // Submit Activity form
    $('#kanbanActForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("crm/log_activity");?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#kanbanActModal').modal('hide');
                    $('#kanbanActForm')[0].reset();
                    showToast(res.message);
                } else {
                    alert(res.message || 'Error logging activity.');
                }
            },
            error: function() {
                alert('Connection error. Please try again.');
            }
        });
    });
});
</script>
