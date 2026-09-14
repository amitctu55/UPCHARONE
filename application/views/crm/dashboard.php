<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
/* Modern CRM Dashboard Styles */
.crm-kpi-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.crm-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px -4px rgba(15, 23, 42, 0.08);
}
.crm-kpi-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.crm-badge-stage {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 8px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.crm-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
}
.crm-funnel-bar {
    height: 10px;
    border-radius: 6px;
    display: flex;
    overflow: hidden;
    background: #e2e8f0;
    margin: 14px 0 10px;
}
.crm-funnel-seg {
    height: 100%;
    transition: width 0.4s ease;
}
.crm-filter-btn {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 9px;
    cursor: pointer;
    transition: all 0.2s;
}
.crm-filter-btn.active, .crm-filter-btn:hover {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.crm-activity-item {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}
.crm-activity-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
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

<div class="crm-toast" id="crmGlobalToast">
    <i class="fa fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>
    <span id="crmGlobalToastMsg">Action completed successfully.</span>
</div>

<!-- Header Action Strip -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; color: #f59e0b; background: #fef3c7; padding: 2px 8px; border-radius: 6px;">
                Growth Engine
            </span>
            <span style="font-size: 12px; color: #94a3b8;">&bull; Healthcare Partner Pipeline</span>
        </div>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
            CRM Command Hub
        </h1>
        <p style="margin: 4px 0 0; font-size: 13.5px; color: #64748b;">
            Real-time provider acquisition metrics, dynamic pipeline velocity, and partner accounts.
        </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="<?=base_url('crm/leads');?>" class="btn" style="background: #ffffff; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 10px 18px; font-size: 13px; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <i class="fa fa-columns" style="color: #f59e0b;"></i> Open Kanban
        </a>
        <a href="<?=base_url('crm/contacts');?>" class="btn" style="background: #ffffff; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 10px 18px; font-size: 13px; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <i class="fa fa-address-book" style="color: #38bdf8;"></i> All Directory
        </a>
        <button type="button" class="btn" data-toggle="modal" data-target="#registerLeadModal" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 10px; padding: 10px 20px; font-size: 13px; border: none; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);">
            <i class="fa fa-plus-circle" style="color: #2dd4bf;"></i> Register Partner Lead
        </button>
    </div>
</div>

<!-- Alerts -->
<?php if ($this->session->flashdata('success_msg')): ?>
<div class="alert alert-success" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600; padding: 12px 18px; margin-bottom: 20px;">
    <i class="fa fa-check-circle"></i> <?=$this->session->flashdata('success_msg');?>
</div>
<?php endif; ?>
<?php if ($this->session->flashdata('error_msg')): ?>
<div class="alert alert-danger" style="border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-weight: 600; padding: 12px 18px; margin-bottom: 20px;">
    <i class="fa fa-exclamation-circle"></i> <?=$this->session->flashdata('error_msg');?>
</div>
<?php endif; ?>

<!-- 4 Executive KPI Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <!-- Total Leads -->
    <div class="crm-kpi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                    Total Inquiries &amp; Leads
                </div>
                <div style="font-size: 30px; font-weight: 800; color: #0f172a; margin-top: 4px; line-height: 1;">
                    <?=$metrics['total_leads'];?>
                </div>
            </div>
            <div class="crm-kpi-icon" style="background: #e0f2fe; color: #0284c7;">
                <i class="fa fa-hospital-o"></i>
            </div>
        </div>
        <div style="margin-top: 14px; font-size: 12px; color: #64748b; display: flex; align-items: center; justify-content: space-between;">
            <span><i class="fa fa-clock-o" style="color: #0284c7;"></i> In-Pipeline: <strong><?=$metrics['active_pipeline_count'];?></strong></span>
            <span style="color: #0284c7; font-weight: 700;">Active Funnel</span>
        </div>
    </div>

    <!-- Signed Partners -->
    <div class="crm-kpi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                    Signed Healthcare Partners
                </div>
                <div style="font-size: 30px; font-weight: 800; color: #15803d; margin-top: 4px; line-height: 1;">
                    <?=$metrics['signed_partners'];?>
                </div>
            </div>
            <div class="crm-kpi-icon" style="background: #dcfce7; color: #15803d;">
                <i class="fa fa-check-circle"></i>
            </div>
        </div>
        <div style="margin-top: 14px; font-size: 12px; color: #64748b; display: flex; align-items: center; justify-content: space-between;">
            <span>Conversion: <strong style="color: #15803d;"><?=$metrics['conversion_rate'];?>%</strong></span>
            <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 800;">MoU Signed</span>
        </div>
    </div>

    <!-- Monthly Revenue & Pipeline Value -->
    <div class="crm-kpi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                    Signed Monthly Run-Rate
                </div>
                <div style="font-size: 28px; font-weight: 800; color: #d97706; margin-top: 4px; line-height: 1;">
                    ₹<?=number_format($metrics['signed_revenue'], 0);?>
                </div>
            </div>
            <div class="crm-kpi-icon" style="background: #fef3c7; color: #d97706;">
                <i class="fa fa-inr"></i>
            </div>
        </div>
        <div style="margin-top: 14px; font-size: 12px; color: #64748b; display: flex; align-items: center; justify-content: space-between;">
            <span>Pipeline: ₹<?=number_format($metrics['total_pipeline_value'], 0);?></span>
            <span style="color: #d97706; font-weight: 700;">Est. Potential</span>
        </div>
    </div>

    <!-- Follow-ups Due Today -->
    <div class="crm-kpi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                    Follow-ups Due Today
                </div>
                <div style="font-size: 30px; font-weight: 800; color: <?=$metrics['followups_due'] > 0 ? '#ef4444' : '#64748b';?>; margin-top: 4px; line-height: 1;">
                    <?=$metrics['followups_due'];?>
                </div>
            </div>
            <div class="crm-kpi-icon" style="background: <?=$metrics['followups_due'] > 0 ? '#fee2e2' : '#f1f5f9';?>; color: <?=$metrics['followups_due'] > 0 ? '#ef4444' : '#64748b';?>;">
                <i class="fa fa-bell-o"></i>
            </div>
        </div>
        <div style="margin-top: 14px; font-size: 12px; color: #64748b; display: flex; align-items: center; justify-content: space-between;">
            <span><i class="fa fa-check-square-o"></i> Activities: <?=$metrics['total_activities'];?></span>
            <span style="color: <?=$metrics['followups_due'] > 0 ? '#ef4444' : '#64748b';?>; font-weight: 700;">
                <?=$metrics['followups_due'] > 0 ? 'Urgent Action' : 'All Clear';?>
            </span>
        </div>
    </div>
</div>

<!-- Dynamic Pipeline Funnel Visual Bar -->
<div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
        <strong style="font-size: 14px; color: #0f172a; font-weight: 800;">
            <i class="fa fa-filter" style="color: #f59e0b; margin-right: 6px;"></i> Dynamic Conversion Funnel Velocity
        </strong>
        <span style="font-size: 12px; color: #64748b;">
            Total Pipeline Volume: <strong><?=$metrics['total_leads'];?> Partners</strong>
        </span>
    </div>

    <!-- Funnel Progress Segments -->
    <div class="crm-funnel-bar">
        <?php foreach ($stage_breakdown as $stKey => $s): ?>
            <?php 
            $pct = ($metrics['total_leads'] > 0) ? round(($s['count'] / $metrics['total_leads']) * 100, 1) : 0;
            if ($pct > 0):
            ?>
            <div class="crm-funnel-seg" style="width: <?=$pct;?>%; background: <?=$s['color'];?>;" title="<?=$s['label'];?>: <?=$s['count'];?> (<?=$pct;?>%)"></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Funnel Breakdown Chips -->
    <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 12px;">
        <?php foreach ($stage_breakdown as $stKey => $s): ?>
        <div style="display: flex; align-items: center; gap: 6px; font-size: 12px;">
            <span style="width: 9px; height: 9px; border-radius: 50%; background: <?=$s['color'];?>;"></span>
            <span style="color: #475569; font-weight: 600;"><?=$s['label'];?>:</span>
            <strong style="color: #0f172a;"><?=$s['count'];?></strong>
            <span style="color: #94a3b8; font-size: 11px;">(₹<?=number_format($s['val'], 0);?>)</span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Main 2-Column Split: Active Leads Table & Real-Time Follow-up / Activity Feed -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    
    <!-- Left: Active Partner Accounts & Lead Funnel Table -->
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h3 style="margin: 0; font-size: 16.5px; font-weight: 800; color: #0f172a;">
                    <i class="fa fa-building-o" style="color: #00a896; margin-right: 6px;"></i> Active Partner Accounts
                </h3>
                <small style="color: #64748b; font-size: 12px;">Instant stage transitions and account telemetry</small>
            </div>
            <!-- Interactive Category Filter Pills -->
            <div style="display: flex; gap: 6px; flex-wrap: wrap;" id="categoryFilterGroup">
                <button type="button" class="crm-filter-btn active" data-type="all">All (<?=count($recent_leads);?>)</button>
                <button type="button" class="crm-filter-btn" data-type="hospital">Hospitals</button>
                <button type="button" class="crm-filter-btn" data-type="clinic">Clinics</button>
                <button type="button" class="crm-filter-btn" data-type="diagnostic_lab">Labs</button>
                <button type="button" class="crm-filter-btn" data-type="pharmacy">Pharmacies</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="crmLeadsTable" style="margin: 0; vertical-align: middle;">
                <thead>
                    <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th style="border: none; padding: 12px 14px;">Healthcare Facility</th>
                        <th style="border: none; padding: 12px 14px;">Type &amp; City</th>
                        <th style="border: none; padding: 12px 14px;">Contact Person</th>
                        <th style="border: none; padding: 12px 14px;">Est. Rev / Comm</th>
                        <th style="border: none; padding: 12px 14px;">Stage (Live Change)</th>
                        <th style="border: none; padding: 12px 14px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_leads)): ?>
                        <?php foreach ($recent_leads as $l): ?>
                        <tr class="crm-lead-row" data-type="<?=$l['facility_type'];?>" id="leadRow_<?=$l['id'];?>" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                            <td style="padding: 14px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; color: #0f172a; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; flex-shrink: 0;">
                                        <?=strtoupper(substr($l['facility_name'], 0, 1));?>
                                    </div>
                                    <div>
                                        <strong style="color: #0f172a; font-size: 13.5px; display: block; line-height: 1.2;">
                                            <?=html_escape($l['facility_name']);?>
                                        </strong>
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                            <i class="fa fa-phone" style="color: #00a896;"></i> 
                                            <a href="tel:<?=$l['phone'];?>" style="color: #64748b; text-decoration: none; font-weight: 600;"><?=$l['phone'];?></a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 14px;">
                                <span class="crm-type-badge">
                                    <?php
                                    $typeIcons = [
                                        'hospital' => 'fa-hospital-o',
                                        'clinic' => 'fa-user-md',
                                        'diagnostic_lab' => 'fa-flask',
                                        'pharmacy' => 'fa-medkit'
                                    ];
                                    $icon = $typeIcons[$l['facility_type']] ?? 'fa-building';
                                    ?>
                                    <i class="fa <?=$icon;?>" style="color: #00a896;"></i>
                                    <?=ucwords(str_replace('_', ' ', $l['facility_type']));?>
                                </span>
                                <div style="font-size: 11.5px; color: #94a3b8; margin-top: 4px;">
                                    <i class="fa fa-map-marker"></i> <?=html_escape($l['city']);?>
                                </div>
                            </td>
                            <td style="padding: 14px;">
                                <div style="font-size: 13px; font-weight: 700; color: #1e293b;">
                                    <?=html_escape($l['contact_person']);?>
                                </div>
                                <?php if (!empty($l['source'])): ?>
                                <small style="font-size: 11px; color: #64748b; display: block; margin-top: 2px;">
                                    Src: <?=$l['source'];?>
                                </small>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 14px;">
                                <strong style="color: #15803d; font-size: 13.5px; display: block;">
                                    ₹<?=number_format($l['est_monthly_revenue'], 0);?>/mo
                                </strong>
                                <span style="font-size: 11px; color: #64748b;">
                                    <?=$l['commission_pct'];?>% rev share
                                </span>
                            </td>
                            <td style="padding: 14px;">
                                <select class="form-control input-sm quick-stage-changer" data-lead-id="<?=$l['id'];?>" style="font-size: 11.5px; font-weight: 700; height: 32px; border-radius: 8px; background: #f8fafc; border-color: #cbd5e1;">
                                    <option value="new" <?=$l['lead_stage']=='new'?'selected':'';?>>New Inquiry</option>
                                    <option value="contacted" <?=$l['lead_stage']=='contacted'?'selected':'';?>>Contacted / Pitch</option>
                                    <option value="meeting_scheduled" <?=$l['lead_stage']=='meeting_scheduled'?'selected':'';?>>Meeting Fixed</option>
                                    <option value="proposal_sent" <?=$l['lead_stage']=='proposal_sent'?'selected':'';?>>Proposal Sent</option>
                                    <option value="signed" <?=$l['lead_stage']=='signed'?'selected':'';?>>Signed Partner 🎉</option>
                                    <option value="lost" <?=$l['lead_stage']=='lost'?'selected':'';?>>Lost / Inactive</option>
                                </select>
                            </td>
                            <td style="padding: 14px; text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <button type="button" class="btn btn-xs btn-default btn-log-quick-act" data-id="<?=$l['id'];?>" data-name="<?=html_escape($l['facility_name']);?>" title="Log Call or Note" style="border-radius: 7px; padding: 5px 9px;">
                                        <i class="fa fa-phone" style="color: #00a896;"></i> Log
                                    </button>
                                    <?php if ($l['lead_stage'] === 'signed'): ?>
                                    <a href="<?=base_url('crm/onboard_partner/' . $l['id']);?>" class="btn btn-xs btn-success" title="Onboard Partner" style="border-radius: 7px; font-weight: 700; padding: 5px 9px;">
                                        <i class="fa fa-plug"></i> Onboard
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 36px 20px; color: #94a3b8;">
                            <i class="fa fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block; color: #cbd5e1;"></i>
                            No partner leads found in this filter.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right: Follow-up Radar & Recent Activity Trail -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        
        <!-- Follow-ups Due Today Widget -->
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #0f172a;">
                    <i class="fa fa-calendar-check-o" style="color: #ef4444; margin-right: 6px;"></i> Follow-up Radar
                </h4>
                <span class="badge" style="background: #fee2e2; color: #ef4444; font-weight: 800;">
                    <?=count($followups_due);?> Due
                </span>
            </div>

            <?php if (!empty($followups_due)): ?>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <?php foreach (array_slice($followups_due, 0, 4) as $f): ?>
                    <div style="background: #f8fafc; border-radius: 10px; padding: 12px; border: 1px solid #e2e8f0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <strong style="font-size: 13px; color: #0f172a; display: block;">
                                    <?=html_escape($f['facility_name']);?>
                                </strong>
                                <span style="font-size: 11px; color: #64748b;">
                                    <?=html_escape($f['contact_person']);?> &bull; <?=$f['phone'];?>
                                </span>
                            </div>
                            <span class="badge" style="background: #fef3c7; color: #d97706; font-size: 10px; text-transform: uppercase;">
                                <?=$f['lead_stage'];?>
                            </span>
                        </div>
                        <div style="margin-top: 8px; display: flex; justify-content: space-between; align-items: center; font-size: 11.5px;">
                            <span style="color: #ef4444; font-weight: 700;">
                                <i class="fa fa-calendar"></i> <?=$f['next_followup_date'];?>
                            </span>
                            <button type="button" class="btn btn-xs btn-primary btn-log-quick-act" data-id="<?=$f['id'];?>" data-name="<?=html_escape($f['facility_name']);?>" style="border-radius: 6px; font-weight: 700;">
                                <i class="fa fa-phone"></i> Call Now
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 24px 10px; color: #94a3b8; font-size: 12.5px;">
                    <i class="fa fa-check-circle" style="color: #10b981; font-size: 24px; display: block; margin-bottom: 6px;"></i>
                    No overdue follow-ups! Pipeline is up to date.
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent CRM Activity Trail -->
        <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #0f172a;">
                    <i class="fa fa-history" style="color: #38bdf8; margin-right: 6px;"></i> Recent Interactions
                </h4>
                <a href="<?=base_url('crm/activities');?>" style="font-size: 11.5px; color: #0284c7; font-weight: 700; text-decoration: none;">
                    View All &rarr;
                </a>
            </div>

            <?php if (!empty($activities)): ?>
                <div style="display: flex; flex-direction: column;">
                    <?php foreach ($activities as $act): ?>
                    <div class="crm-activity-item">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;">
                            <?php
                            $actIcons = [
                                'call' => 'fa-phone',
                                'meeting' => 'fa-users',
                                'site_visit' => 'fa-building',
                                'whatsapp' => 'fa-whatsapp',
                                'email' => 'fa-envelope-o',
                                'proposal' => 'fa-file-text-o',
                                'note' => 'fa-pencil'
                            ];
                            $aIcon = $actIcons[$act['activity_type']] ?? 'fa-comment-o';
                            ?>
                            <i class="fa <?=$aIcon;?>"></i>
                        </div>
                        <div style="flex-grow: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <strong style="font-size: 12.5px; color: #0f172a; line-height: 1.2;">
                                    <?=html_escape($act['facility_name']);?>
                                </strong>
                                <small style="color: #94a3b8; font-size: 10.5px;">
                                    <?=date('d M, H:i', strtotime($act['created_at']));?>
                                </small>
                            </div>
                            <p style="margin: 2px 0 0; font-size: 11.5px; color: #475569; line-height: 1.3;">
                                <?=html_escape($act['summary']);?>
                            </p>
                            <?php if (!empty($act['notes'])): ?>
                            <small style="color: #64748b; font-size: 11px; display: block; margin-top: 2px;">
                                <?=(strlen($act['notes']) > 60 ? substr(html_escape($act['notes']), 0, 60) . '...' : html_escape($act['notes']));?>
                            </small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 24px 10px; color: #94a3b8; font-size: 12px;">
                    No recent activities recorded.
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Modal: Register New Healthcare Partner Lead -->
<div class="modal fade" id="registerLeadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 18px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 20px 24px; border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 168, 150, 0.25); color: #2dd4bf; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa fa-hospital-o"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" style="font-weight: 800; color: #ffffff; margin: 0; font-size: 17px;">
                            Register New Healthcare Partner Lead
                        </h4>
                        <small style="color: #94a3b8; font-size: 12px;">Onboard clinics, hospitals, labs, and pharmacies into Upchar CRM</small>
                    </div>
                </div>
            </div>

            <form id="registerLeadForm" action="<?=base_url('crm/save_lead');?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="modal-body" style="padding: 24px;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Facility / Partner Name *
                            </label>
                            <input type="text" name="facility_name" class="form-control" placeholder="e.g. LifeCare Multi-Speciality Clinic" required style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Facility Type *
                            </label>
                            <select name="facility_type" class="form-control" style="border-radius: 9px; height: 40px; font-weight: 600;">
                                <option value="clinic">Clinic / Doctor OPD</option>
                                <option value="hospital">Hospital</option>
                                <option value="diagnostic_lab">Diagnostic / Pathology Lab</option>
                                <option value="pharmacy">Pharmacy / Chemist</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Key Contact Person *
                            </label>
                            <input type="text" name="contact_person" class="form-control" placeholder="Dr. / Director Name" required style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Mobile Phone *
                            </label>
                            <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile number" required style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Email Address
                            </label>
                            <input type="email" name="email" class="form-control" placeholder="info@partner.com" style="border-radius: 9px; height: 40px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                City / Location
                            </label>
                            <input type="text" name="city" class="form-control" value="Lucknow" style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Lead Source
                            </label>
                            <select name="source" class="form-control" style="border-radius: 9px; height: 40px;">
                                <option value="Direct Visit">Direct Field Visit</option>
                                <option value="Doctor Reference">Doctor Referral</option>
                                <option value="Medical Conference">Medical Conference</option>
                                <option value="Inbound Call">Inbound Call</option>
                                <option value="Website Enquiry">Website Enquiry</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Priority Level
                            </label>
                            <select name="priority" class="form-control" style="border-radius: 9px; height: 40px;">
                                <option value="urgent">🔥 Urgent Priority</option>
                                <option value="high">High Priority</option>
                                <option value="medium" selected>Medium Priority</option>
                                <option value="low">Low Priority</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Pipeline Stage
                            </label>
                            <select name="lead_stage" class="form-control" style="border-radius: 9px; height: 40px;">
                                <option value="new">New Inquiry</option>
                                <option value="contacted">Contacted / Pitching</option>
                                <option value="meeting_scheduled">Meeting / Demo Fixed</option>
                                <option value="proposal_sent">Proposal Sent</option>
                                <option value="signed">MoU Signed</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Est. Monthly Revenue (₹)
                            </label>
                            <input type="number" name="est_monthly_revenue" class="form-control" value="50000" style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Referral / Comm (%)
                            </label>
                            <input type="number" name="commission_pct" class="form-control" value="10" style="border-radius: 9px; height: 40px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Next Follow-up Date
                            </label>
                            <input type="date" name="next_followup_date" class="form-control" value="<?=date('Y-m-d', strtotime('+2 days'));?>" style="border-radius: 9px; height: 40px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Key Notes / Requirements
                            </label>
                            <input type="text" name="notes" class="form-control" placeholder="e.g. Discussed OPD and pathology referral rates" style="border-radius: 9px; height: 40px;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 9px; font-weight: 600; padding: 9px 18px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 9px; padding: 9px 24px; border: none;">
                        <i class="fa fa-check"></i> Register Partner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Quick Log Activity / Call Note -->
<div class="modal fade" id="quickActivityModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 16px 20px; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 16px;">
                    <i class="fa fa-phone" style="color: #00a896; margin-right: 6px;"></i> Log Interaction / Follow-up
                </h4>
            </div>
            <form id="quickActivityForm">
                <input type="hidden" name="lead_id" id="quickActLeadId" value="">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <div class="modal-body" style="padding: 20px;">
                    <div style="background: #f1f5f9; padding: 10px 14px; border-radius: 8px; margin-bottom: 14px;">
                        <span style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700;">Partner:</span>
                        <strong style="display: block; font-size: 14px; color: #0f172a;" id="quickActLeadName">Facility Name</strong>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Interaction Type</label>
                            <select name="activity_type" class="form-control" style="border-radius: 8px;">
                                <option value="call">📞 Phone Call</option>
                                <option value="meeting">🤝 In-Person Meeting</option>
                                <option value="site_visit">🏥 Hospital/Clinic Visit</option>
                                <option value="whatsapp">💬 WhatsApp Chat</option>
                                <option value="email">✉️ Email Update</option>
                                <option value="proposal">📄 Proposal Submitted</option>
                                <option value="note">📝 Internal Note</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Next Follow-up Date</label>
                            <input type="date" name="followup_date" class="form-control" value="<?=date('Y-m-d', strtotime('+3 days'));?>" style="border-radius: 8px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Interaction Summary *</label>
                        <input type="text" name="summary" class="form-control" placeholder="e.g. Called Dr. Saxena to confirm demo slot" required style="border-radius: 8px;">
                    </div>

                    <div>
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Detailed Notes &amp; Next Action</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Key talking points, agreed action items..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; border-radius: 8px; font-weight: 700;">
                        <i class="fa fa-check"></i> Save Interaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function showToast(msg) {
        $('#crmGlobalToastMsg').text(msg);
        $('#crmGlobalToast').fadeIn(200).delay(2500).fadeOut(200);
    }

    // Category Filter Buttons
    $('#categoryFilterGroup .crm-filter-btn').click(function() {
        $('#categoryFilterGroup .crm-filter-btn').removeClass('active');
        $(this).addClass('active');
        var selectedType = $(this).data('type');

        if (selectedType === 'all') {
            $('.crm-lead-row').show();
        } else {
            $('.crm-lead-row').each(function() {
                if ($(this).data('type') === selectedType) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });

    // Live Instant Stage Changer
    $('.quick-stage-changer').change(function() {
        var $select = $(this);
        var leadId = $select.data('lead-id');
        var newStage = $select.val();
        var csrfName = '<?=$this->security->get_csrf_token_name();?>';
        var csrfHash = '<?=$this->security->get_csrf_hash();?>';

        var postData = {
            lead_id: leadId,
            stage: newStage
        };
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
                    $select.css({'border-color': '#10b981', 'background': '#ecfdf5'});
                    setTimeout(function() {
                        $select.css({'border-color': '#cbd5e1', 'background': '#f8fafc'});
                    }, 1200);
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

    // Open Quick Log Activity Modal
    $(document).on('click', '.btn-log-quick-act', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#quickActLeadId').val(id);
        $('#quickActLeadName').text(name);
        $('#quickActivityModal').modal('show');
    });

    // Submit Quick Activity Form via AJAX
    $('#quickActivityForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '<?=base_url("crm/log_activity");?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#quickActivityModal').modal('hide');
                    $('#quickActivityForm')[0].reset();
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                } else {
                    alert(res.message || 'Error logging activity.');
                }
            },
            error: function() {
                alert('Error submitting activity. Please try again.');
            }
        });
    });
});
</script>
