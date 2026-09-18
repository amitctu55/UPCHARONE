<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
/* ==========================================================================
   CRM COMMAND HUB - REFINED EXECUTIVE DESIGN SYSTEM
   ========================================================================== */
.crm-container {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #0f172a;
}

/* KPI Summary Cards */
.crm-stat-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 22px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.04);
    position: relative;
    overflow: hidden;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.crm-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.09);
    border-color: #cbd5e1;
}
.crm-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.crm-stat-value {
    font-size: 32px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
    letter-spacing: -0.5px;
    margin: 8px 0 6px;
}

/* Interactive Funnel Ribbon */
.crm-funnel-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 22px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
}
.crm-funnel-bar {
    height: 12px;
    border-radius: 8px;
    display: flex;
    overflow: hidden;
    background: #f1f5f9;
    margin: 16px 0 16px;
    border: 1px solid #e2e8f0;
}
.crm-funnel-seg {
    height: 100%;
    transition: width 0.4s ease;
    cursor: pointer;
}
.crm-stage-chip-btn {
    flex: 1 1 140px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px 14px;
    cursor: pointer;
    transition: all 0.2s;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.crm-stage-chip-btn:hover, .crm-stage-chip-btn.active {
    background: #0f172a;
    border-color: #0f172a;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.12);
}
.crm-stage-chip-btn.active strong, .crm-stage-chip-btn.active span, .crm-stage-chip-btn:hover strong, .crm-stage-chip-btn:hover span {
    color: #ffffff !important;
}

/* Operational Section Cards */
.crm-widget-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 22px;
    box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.04);
    display: flex;
    flex-direction: column;
}
.crm-widget-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}
.crm-radar-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 14px 16px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}
.crm-radar-item:hover {
    background: #ffffff;
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
}

/* Full Width Table Component */
.crm-table-box {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.04);
    overflow: hidden;
    margin-bottom: 30px;
}
.crm-table-toolbar {
    padding: 18px 22px;
    background: #ffffff;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
}
.crm-filter-pill {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    padding: 7px 14px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.crm-filter-pill.active, .crm-filter-pill:hover {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.crm-badge-facility {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 8px;
}
.crm-stage-select {
    font-size: 12px;
    font-weight: 700;
    height: 34px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    padding: 4px 8px;
    outline: none;
    transition: all 0.2s;
}
.crm-stage-select:focus {
    border-color: #00a896;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

/* Toast Message */
.crm-live-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #0f172a;
    color: #ffffff;
    padding: 14px 22px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    display: none;
    z-index: 99999;
    font-size: 13.5px;
    font-weight: 600;
    border-left: 4px solid #10b981;
}
</style>

<div class="crm-container">
    <!-- Live Floating Toast -->
    <div class="crm-live-toast" id="crmGlobalToast">
        <i class="fa fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>
        <span id="crmGlobalToastMsg">Action completed successfully.</span>
    </div>

    <!-- ========================================================================= -->
    <!-- 1. TOP HEADER ACTION STRIP                                                -->
    <!-- ========================================================================= -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; background: #ffffff; padding: 20px 24px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; color: #d97706; background: #fef3c7; padding: 3px 8px; border-radius: 6px;">
                    <i class="fa fa-bolt"></i> Healthcare Growth Engine
                </span>
                <span style="font-size: 12px; color: #94a3b8;">&bull; BDE &amp; Partner Telemetry</span>
            </div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                CRM Command Hub &amp; Growth Pipeline
            </h1>
            <p style="margin: 4px 0 0; font-size: 13px; color: #64748b;">
                Accelerate healthcare provider acquisition, monitor live deal velocity, and manage client partnerships.
            </p>
        </div>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="<?=base_url('admin1947/crm/leads');?>" class="btn" style="background: #f8fafc; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.04);">
                <i class="fa fa-columns" style="color: #f59e0b; margin-right: 4px;"></i> Visual Kanban
            </a>
            <a href="<?=base_url('admin1947/crm/contacts');?>" class="btn" style="background: #f8fafc; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; border: 1px solid #cbd5e1; box-shadow: 0 1px 2px rgba(0,0,0,0.04);">
                <i class="fa fa-address-book" style="color: #38bdf8; margin-right: 4px;"></i> Full Directory
            </a>
            <button type="button" class="btn" data-toggle="modal" data-target="#registerLeadModal" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 10px; padding: 9px 20px; font-size: 13px; border: none; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.25);">
                <i class="fa fa-plus-circle" style="color: #2dd4bf; margin-right: 4px;"></i> Register Partner Lead
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600; padding: 12px 18px; margin-bottom: 22px;">
        <i class="fa fa-check-circle" style="margin-right: 6px;"></i> <?=$this->session->flashdata('success_msg');?>
    </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error_msg')): ?>
    <div class="alert alert-danger" style="border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-weight: 600; padding: 12px 18px; margin-bottom: 22px;">
        <i class="fa fa-exclamation-circle" style="margin-right: 6px;"></i> <?=$this->session->flashdata('error_msg');?>
    </div>
    <?php endif; ?>

    <!-- ========================================================================= -->
    <!-- 2. EXECUTIVE KPI CARDS (4 Columns)                                        -->
    <!-- ========================================================================= -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 24px;">
        <!-- Card 1: Total Leads & Funnel -->
        <div class="crm-stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        Total Provider Inquiries
                    </span>
                    <div class="crm-stat-value"><?=$metrics['total_leads'];?></div>
                </div>
                <div class="crm-stat-icon" style="background: #e0f2fe; color: #0284c7;">
                    <i class="fa fa-hospital-o"></i>
                </div>
            </div>
            <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #64748b; display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fa fa-filter" style="color: #0284c7;"></i> In-Pipeline: <strong style="color: #0f172a;"><?=$metrics['active_pipeline_count'];?></strong></span>
                <span style="color: #0284c7; font-weight: 700; background: #f0f9ff; padding: 2px 8px; border-radius: 6px;">Active Funnel</span>
            </div>
        </div>

        <!-- Card 2: Signed Partners & Conversion -->
        <div class="crm-stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        Signed Network Partners
                    </span>
                    <div class="crm-stat-value" style="color: #15803d;"><?=$metrics['signed_partners'];?></div>
                </div>
                <div class="crm-stat-icon" style="background: #dcfce7; color: #15803d;">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>
            <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #64748b; display: flex; align-items: center; justify-content: space-between;">
                <span>Conversion: <strong style="color: #15803d;"><?=$metrics['conversion_rate'];?>%</strong></span>
                <span style="background: #dcfce7; color: #15803d; font-weight: 800; font-size: 11px; padding: 2px 8px; border-radius: 6px;">MoU Signed</span>
            </div>
        </div>

        <!-- Card 3: Signed MRR & Total Value -->
        <div class="crm-stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        Signed Monthly Run-Rate
                    </span>
                    <div class="crm-stat-value" style="color: #d97706; font-size: 28px;">
                        ₹<?=number_format($metrics['signed_revenue'], 0);?>
                    </div>
                </div>
                <div class="crm-stat-icon" style="background: #fef3c7; color: #d97706;">
                    <i class="fa fa-inr"></i>
                </div>
            </div>
            <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #64748b; display: flex; align-items: center; justify-content: space-between;">
                <span>Pipeline Potential: <strong style="color: #0f172a;">₹<?=number_format($metrics['total_pipeline_value'], 0);?></strong></span>
                <span style="color: #d97706; font-weight: 700; background: #fffbeb; padding: 2px 8px; border-radius: 6px;">Contract Value</span>
            </div>
        </div>

        <!-- Card 4: Action Radar & Activities -->
        <div class="crm-stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        Follow-ups Due Today
                    </span>
                    <div class="crm-stat-value" style="color: <?=$metrics['followups_due'] > 0 ? '#ef4444' : '#10b981';?>;">
                        <?=$metrics['followups_due'];?>
                    </div>
                </div>
                <div class="crm-stat-icon" style="background: <?=$metrics['followups_due'] > 0 ? '#fee2e2' : '#ecfdf5';?>; color: <?=$metrics['followups_due'] > 0 ? '#ef4444' : '#10b981';?>;">
                    <i class="fa fa-bell-o"></i>
                </div>
            </div>
            <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #64748b; display: flex; align-items: center; justify-content: space-between;">
                <span>Activities Logged: <strong style="color: #0f172a;"><?=$metrics['total_activities'];?></strong></span>
                <span style="font-weight: 800; font-size: 11px; padding: 2px 8px; border-radius: 6px; background: <?=$metrics['followups_due'] > 0 ? '#fee2e2' : '#ecfdf5';?>; color: <?=$metrics['followups_due'] > 0 ? '#ef4444' : '#10b981';?>;">
                    <?=$metrics['followups_due'] > 0 ? 'Urgent Action' : 'All Cleared';?>
                </span>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. INTERACTIVE CONVERSION FUNNEL & STAGE SELECTOR                         -->
    <!-- ========================================================================= -->
    <div class="crm-funnel-card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div>
                <strong style="font-size: 14.5px; color: #0f172a; font-weight: 800;">
                    <i class="fa fa-filter" style="color: #f59e0b; margin-right: 6px;"></i> Partner Pipeline Velocity &amp; Stage Velocity
                </strong>
                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                    Click any pipeline stage below to instantly filter the partner directory
                </div>
            </div>
            <div style="font-size: 12px; color: #64748b; background: #f8fafc; padding: 4px 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                Total Pipeline: <strong style="color: #0f172a;"><?=$metrics['total_leads'];?> Partners</strong>
            </div>
        </div>

        <!-- Conversion Funnel Multi-segment Progress Bar -->
        <div class="crm-funnel-bar">
            <?php foreach ($stage_breakdown as $stKey => $s): ?>
                <?php 
                $pct = ($metrics['total_leads'] > 0) ? round(($s['count'] / $metrics['total_leads']) * 100, 1) : 0;
                if ($pct > 0):
                ?>
                <div class="crm-funnel-seg" style="width: <?=$pct;?>%; background: <?=$s['color'];?>;" title="<?=$s['label'];?>: <?=$s['count'];?> (<?=$pct;?>%)" onclick="filterByStage('<?=$stKey;?>')"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- 6 Interactive Stage Filter Tiles -->
        <div style="display: flex; flex-wrap: wrap; gap: 10px;" id="funnelStageTiles">
            <div class="crm-stage-chip-btn active" data-stage="all" onclick="filterByStage('all')">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b;">All Stages</span>
                    <strong style="font-size: 15px; color: #0f172a;"><?=$metrics['total_leads'];?></strong>
                </div>
                <span style="font-size: 11px; color: #94a3b8;">Total Leads</span>
            </div>

            <?php foreach ($stage_breakdown as $stKey => $s): ?>
            <div class="crm-stage-chip-btn" data-stage="<?=$stKey;?>" onclick="filterByStage('<?=$stKey;?>')">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 11.5px; font-weight: 700; color: #334155; display: flex; align-items: center; gap: 6px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: <?=$s['color'];?>;"></span>
                        <?=$s['label'];?>
                    </span>
                    <strong style="font-size: 15px; color: #0f172a;"><?=$s['count'];?></strong>
                </div>
                <span style="font-size: 11px; color: #64748b;">
                    ₹<?=number_format($s['val'], 0);?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 4. OPERATIONAL COMMAND SPLIT: FOLLOW-UPS RADAR & NETWORK MIX             -->
    <!-- ========================================================================= -->
    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 20px; margin-bottom: 24px;">
        
        <!-- Left: Follow-ups Due Radar (Action Oriented) -->
        <div class="crm-widget-card">
            <div class="crm-widget-header">
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">
                        <i class="fa fa-calendar-check-o" style="color: #ef4444; margin-right: 6px;"></i> Immediate Follow-up Radar
                    </h3>
                    <small style="color: #64748b; font-size: 12px;">Scheduled provider calls, demos, and pending contract renewals</small>
                </div>
                <span class="badge" style="background: <?=count($followups_due) > 0 ? '#fee2e2' : '#ecfdf5';?>; color: <?=count($followups_due) > 0 ? '#ef4444' : '#10b981';?>; font-weight: 800; padding: 6px 12px; font-size: 11.5px; border-radius: 8px;">
                    <?=count($followups_due);?> Due
                </span>
            </div>

            <?php if (!empty($followups_due)): ?>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <?php foreach (array_slice($followups_due, 0, 4) as $f): ?>
                    <div class="crm-radar-item">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                            <div>
                                <strong style="font-size: 14px; color: #0f172a; display: block;">
                                    <?=html_escape($f['facility_name']);?>
                                </strong>
                                <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                    <i class="fa fa-user-circle-o"></i> <?=html_escape($f['contact_person']);?> &bull; 
                                    <i class="fa fa-map-marker"></i> <?=html_escape($f['city']);?>
                                </div>
                            </div>
                            <span class="badge" style="background: #fef3c7; color: #d97706; font-size: 10px; font-weight: 800; text-transform: uppercase;">
                                <?=str_replace('_', ' ', $f['lead_stage']);?>
                            </span>
                        </div>

                        <?php if (!empty($f['notes'])): ?>
                        <div style="font-size: 11.5px; color: #475569; background: #ffffff; padding: 6px 10px; border-radius: 6px; border: 1px dashed #cbd5e1; margin-top: 8px;">
                            <i class="fa fa-comment-o" style="color: #94a3b8;"></i> <?=html_escape(substr($f['notes'], 0, 110));?><?=(strlen($f['notes']) > 110 ? '...' : '');?>
                        </div>
                        <?php endif; ?>

                        <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                            <span style="color: #ef4444; font-weight: 700;">
                                <i class="fa fa-clock-o"></i> Due: <?=date('d M Y', strtotime($f['next_followup_date']));?>
                            </span>
                            <div style="display: flex; gap: 6px;">
                                <a href="tel:<?=$f['phone'];?>" class="btn btn-xs btn-default" style="border-radius: 7px; font-weight: 700; color: #0284c7;" title="Direct Call">
                                    <i class="fa fa-phone"></i> <?=$f['phone'];?>
                                </a>
                                <a href="https://wa.me/91<?=$f['phone'];?>" target="_blank" class="btn btn-xs btn-default" style="border-radius: 7px; font-weight: 700; color: #16a34a;" title="WhatsApp">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                                <button type="button" class="btn btn-xs btn-primary btn-log-quick-act" data-id="<?=$f['id'];?>" data-name="<?=html_escape($f['facility_name']);?>" style="border-radius: 7px; font-weight: 700; background: #00a896; border-color: #00a896;">
                                    <i class="fa fa-check"></i> Log
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px 16px; color: #94a3b8;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 12px;">
                        <i class="fa fa-check"></i>
                    </div>
                    <strong style="font-size: 14px; color: #0f172a; display: block;">All Caught Up!</strong>
                    <span style="font-size: 12.5px;">No overdue or pending follow-ups required today.</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Network Diversity & Recent Interactions -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Provider Network Distribution Breakdown -->
            <div class="crm-widget-card" style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <h4 style="margin: 0; font-size: 14.5px; font-weight: 800; color: #0f172a;">
                        <i class="fa fa-pie-chart" style="color: #6366f1; margin-right: 6px;"></i> Healthcare Network Diversity
                    </h4>
                    <span style="font-size: 11.5px; color: #64748b;">By Provider Category</span>
                </div>

                <?php
                $typesMeta = [
                    'hospital'       => ['label' => 'Hospitals & Medical Centers', 'color' => '#3b82f6', 'icon' => 'fa-hospital-o'],
                    'clinic'         => ['label' => 'Clinics & Specialist OPDs',   'color' => '#10b981', 'icon' => 'fa-user-md'],
                    'diagnostic_lab' => ['label' => 'Diagnostic & Pathology Labs', 'color' => '#8b5cf6', 'icon' => 'fa-flask'],
                    'pharmacy'       => ['label' => 'Pharmacies & Chemists',       'color' => '#f59e0b', 'icon' => 'fa-medkit']
                ];
                $typeCounts = [];
                if (!empty($types_breakdown)) {
                    foreach ($types_breakdown as $tb) {
                        $typeCounts[$tb['facility_type']] = intval($tb['count']);
                    }
                }
                ?>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <?php foreach ($typesMeta as $tKey => $tInfo): 
                        $cnt = $typeCounts[$tKey] ?? 0;
                        $pct = ($metrics['total_leads'] > 0) ? round(($cnt / $metrics['total_leads']) * 100) : 0;
                    ?>
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px;">
                            <span style="font-weight: 700; color: #334155;">
                                <i class="fa <?=$tInfo['icon'];?>" style="color: <?=$tInfo['color'];?>; width: 16px;"></i> <?=$tInfo['label'];?>
                            </span>
                            <span style="font-weight: 800; color: #0f172a;">
                                <?=$cnt;?> <small style="color: #94a3b8; font-weight: 600;">(<?=$pct;?>%)</small>
                            </span>
                        </div>
                        <div style="height: 6px; border-radius: 4px; background: #f1f5f9; overflow: hidden;">
                            <div style="height: 100%; width: <?=$pct;?>%; background: <?=$tInfo['color'];?>; border-radius: 4px;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Recent Interactions Stream -->
            <div class="crm-widget-card" style="padding: 20px; flex-grow: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <h4 style="margin: 0; font-size: 14.5px; font-weight: 800; color: #0f172a;">
                        <i class="fa fa-history" style="color: #0284c7; margin-right: 6px;"></i> Recent Interaction Feed
                    </h4>
                    <a href="<?=base_url('admin1947/crm/activities');?>" style="font-size: 11.5px; color: #0284c7; font-weight: 700; text-decoration: none;">
                        All Logs &rarr;
                    </a>
                </div>

                <?php if (!empty($activities)): ?>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php foreach (array_slice($activities, 0, 3) as $act): ?>
                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <div style="width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; color: #00a896; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; margin-top: 2px;">
                                <?php
                                $actIcons = [
                                    'call' => 'fa-phone', 'meeting' => 'fa-users', 'site_visit' => 'fa-building',
                                    'whatsapp' => 'fa-whatsapp', 'email' => 'fa-envelope-o', 'proposal' => 'fa-file-text-o', 'note' => 'fa-pencil'
                                ];
                                ?>
                                <i class="fa <?=$actIcons[$act['activity_type']] ?? 'fa-comment-o';?>"></i>
                            </div>
                            <div style="flex-grow: 1; min-width: 0;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                    <strong style="font-size: 12.5px; color: #0f172a; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                        <?=html_escape($act['facility_name']);?>
                                    </strong>
                                    <small style="color: #94a3b8; font-size: 10.5px; flex-shrink: 0; margin-left: 6px;">
                                        <?=date('d M, H:i', strtotime($act['created_at']));?>
                                    </small>
                                </div>
                                <p style="margin: 2px 0 0; font-size: 11.5px; color: #475569; line-height: 1.3;">
                                    <?=html_escape($act['summary']);?>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 24px 10px; color: #94a3b8; font-size: 12px;">
                        No recent interaction history recorded.
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 5. FULL-WIDTH HEALTHCARE PARTNER DIRECTORY & ACTIVE PIPELINE TABLE         -->
    <!-- ========================================================================= -->
    <div class="crm-table-box">
        <!-- Interactive Table Controls Toolbar -->
        <div class="crm-table-toolbar">
            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <div>
                    <h3 style="margin: 0; font-size: 16.5px; font-weight: 800; color: #0f172a;">
                        <i class="fa fa-building" style="color: #00a896; margin-right: 6px;"></i> Healthcare Partner Accounts
                    </h3>
                    <small style="color: #64748b; font-size: 12px;">
                        Showing <span id="visibleLeadsCount"><?=count($recent_leads);?></span> of <?=count($recent_leads);?> active partner records
                    </small>
                </div>
            </div>

            <!-- Category Filter Buttons Group -->
            <div style="display: flex; gap: 6px; flex-wrap: wrap;" id="categoryFilterGroup">
                <button type="button" class="crm-filter-pill active" data-type="all">
                    <i class="fa fa-th"></i> All Facilities
                </button>
                <button type="button" class="crm-filter-pill" data-type="hospital">
                    <i class="fa fa-hospital-o" style="color: #3b82f6;"></i> Hospitals
                </button>
                <button type="button" class="crm-filter-pill" data-type="clinic">
                    <i class="fa fa-user-md" style="color: #10b981;"></i> Clinics
                </button>
                <button type="button" class="crm-filter-pill" data-type="diagnostic_lab">
                    <i class="fa fa-flask" style="color: #8b5cf6;"></i> Labs
                </button>
                <button type="button" class="crm-filter-pill" data-type="pharmacy">
                    <i class="fa fa-medkit" style="color: #f59e0b;"></i> Pharmacies
                </button>
            </div>

            <!-- Live Search and Stage Dropdown Filter -->
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <div style="position: relative; width: 230px;">
                    <i class="fa fa-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8; font-size: 13px;"></i>
                    <input type="text" id="partnerQuickSearch" class="form-control" placeholder="Search partner, city, contact..." style="padding-left: 34px; height: 36px; border-radius: 9px; font-size: 12px; border: 1px solid #cbd5e1;">
                </div>

                <select id="stageFilterDropdown" class="form-control" style="width: 150px; height: 36px; border-radius: 9px; font-size: 12px; font-weight: 700; border: 1px solid #cbd5e1;">
                    <option value="all">All Stages</option>
                    <option value="new">New Inquiries</option>
                    <option value="contacted">Contacted</option>
                    <option value="meeting_scheduled">Meeting Fixed</option>
                    <option value="proposal_sent">Proposal Sent</option>
                    <option value="signed">Signed Partner 🎉</option>
                    <option value="lost">Lost / Dropped</option>
                </select>
            </div>
        </div>

        <!-- The Responsive Data Table -->
        <div class="table-responsive" style="margin: 0; border: none;">
            <table class="table" id="crmLeadsTable" style="margin: 0; vertical-align: middle; font-size: 13px;">
                <thead>
                    <tr style="background: #f8fafc; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; border-top: none;">
                        <th style="padding: 14px 18px; font-weight: 800;">Healthcare Facility</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Facility Type &amp; City</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Key Contact &amp; Connect</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Deal Economics</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Next Follow-up</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Pipeline Stage</th>
                        <th style="padding: 14px 18px; font-weight: 800; text-align: right;">Quick Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_leads)): foreach ($recent_leads as $l): 
                        $fType = $l['facility_type'] ?? 'clinic';
                        $badgeBg = '#f1f5f9'; $badgeColor = '#475569'; $typeIcon = 'fa-building';
                        if ($fType === 'hospital') { $badgeBg = '#eff6ff'; $badgeColor = '#2563eb'; $typeIcon = 'fa-hospital-o'; }
                        elseif ($fType === 'clinic') { $badgeBg = '#ecfdf5'; $badgeColor = '#059669'; $typeIcon = 'fa-user-md'; }
                        elseif ($fType === 'diagnostic_lab') { $badgeBg = '#f5f3ff'; $badgeColor = '#7c3aed'; $typeIcon = 'fa-flask'; }
                        elseif ($fType === 'pharmacy') { $badgeBg = '#fffbeb'; $badgeColor = '#d97706'; $typeIcon = 'fa-medkit'; }

                        $isDue = !empty($l['next_followup_date']) && $l['next_followup_date'] <= date('Y-m-d') && !in_array($l['lead_stage'], ['signed', 'lost']);
                        $searchText = strtolower($l['facility_name'] . ' ' . $l['contact_person'] . ' ' . $l['phone'] . ' ' . ($l['city'] ?? '') . ' ' . ($l['notes'] ?? ''));
                    ?>
                    <tr class="crm-lead-row" 
                        id="leadRow_<?=$l['id'];?>"
                        data-type="<?=$fType;?>"
                        data-stage="<?=$l['lead_stage'];?>"
                        data-search="<?=$searchText;?>"
                        style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                        
                        <!-- Facility Identity -->
                        <td style="padding: 14px 18px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 38px; height: 38px; border-radius: 12px; background: <?=$badgeBg;?>; color: <?=$badgeColor;?>; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                                    <i class="fa <?=$typeIcon;?>"></i>
                                </div>
                                <div>
                                    <strong style="color: #0f172a; font-size: 13.5px; display: block; line-height: 1.25;">
                                        <?=html_escape($l['facility_name']);?>
                                    </strong>
                                    <?php if (!empty($l['source'])): ?>
                                    <small style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">
                                        Source: <?=html_escape($l['source']);?>
                                    </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <!-- Facility Type & Location -->
                        <td style="padding: 14px 16px;">
                            <span class="crm-badge-facility" style="background: <?=$badgeBg;?>; color: <?=$badgeColor;?>;">
                                <i class="fa <?=$typeIcon;?>"></i> <?=ucwords(str_replace('_', ' ', $fType));?>
                            </span>
                            <div style="font-size: 12px; color: #64748b; margin-top: 4px; font-weight: 600;">
                                <i class="fa fa-map-marker" style="color: #94a3b8;"></i> <?=html_escape($l['city'] ?: 'Lucknow, UP');?>
                            </div>
                        </td>

                        <!-- Contact & Comms Links -->
                        <td style="padding: 14px 16px;">
                            <strong style="font-size: 13px; color: #1e293b; display: block;">
                                <?=html_escape($l['contact_person']);?>
                            </strong>
                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                                <a href="tel:<?=$l['phone'];?>" style="font-size: 12px; color: #0284c7; text-decoration: none; font-weight: 700;">
                                    <i class="fa fa-phone"></i> <?=$l['phone'];?>
                                </a>
                                <a href="https://wa.me/91<?=$l['phone'];?>" target="_blank" style="color: #16a34a; font-size: 13px;" title="Chat on WhatsApp">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </div>
                        </td>

                        <!-- Deal Economics -->
                        <td style="padding: 14px 16px;">
                            <strong style="color: #15803d; font-size: 14px; display: block; line-height: 1.2;">
                                ₹<?=number_format($l['est_monthly_revenue'], 0);?><small style="font-size: 11px; color: #64748b; font-weight: normal;">/mo</small>
                            </strong>
                            <div style="font-size: 11px; color: #64748b; margin-top: 3px;">
                                <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 700; font-size: 10px;">
                                    <?=$l['commission_pct'];?>% rev share
                                </span>
                            </div>
                        </td>

                        <!-- Follow-up Status -->
                        <td style="padding: 14px 16px;">
                            <?php if (!empty($l['next_followup_date']) && $l['next_followup_date'] != '0000-00-00'): ?>
                                <div style="font-weight: 700; font-size: 12px; color: <?=$isDue ? '#ef4444' : '#334155';?>;">
                                    <i class="fa fa-calendar-check-o"></i> <?=date('d M Y', strtotime($l['next_followup_date']));?>
                                </div>
                                <?php if ($isDue): ?>
                                    <span class="badge" style="background: #fee2e2; color: #ef4444; font-size: 10px; font-weight: 800; margin-top: 3px;">
                                        Due Today
                                    </span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span style="font-size: 12px; color: #94a3b8;">--</span>
                            <?php endif; ?>
                        </td>

                        <!-- Live Pipeline Stage Changer -->
                        <td style="padding: 14px 16px;">
                            <select class="form-control crm-stage-select quick-stage-changer" data-lead-id="<?=$l['id'];?>">
                                <option value="new" <?=$l['lead_stage']=='new'?'selected':'';?>>📥 New Inquiry</option>
                                <option value="contacted" <?=$l['lead_stage']=='contacted'?'selected':'';?>>📞 Contacted / Pitch</option>
                                <option value="meeting_scheduled" <?=$l['lead_stage']=='meeting_scheduled'?'selected':'';?>>🗓️ Meeting Fixed</option>
                                <option value="proposal_sent" <?=$l['lead_stage']=='proposal_sent'?'selected':'';?>>📄 Proposal Sent</option>
                                <option value="signed" <?=$l['lead_stage']=='signed'?'selected':'';?>>🏆 Signed Partner 🎉</option>
                                <option value="lost" <?=$l['lead_stage']=='lost'?'selected':'';?>>❌ Lost / Dropped</option>
                            </select>
                        </td>

                        <!-- Quick Actions -->
                        <td style="padding: 14px 18px; text-align: right; white-space: nowrap;">
                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                <button type="button" class="btn btn-xs btn-default btn-log-quick-act" data-id="<?=$l['id'];?>" data-name="<?=html_escape($l['facility_name']);?>" title="Log Call or Update" style="border-radius: 8px; font-weight: 700; padding: 6px 10px;">
                                    <i class="fa fa-pencil" style="color: #00a896;"></i> Log
                                </button>
                                <?php if ($l['lead_stage'] === 'signed'): ?>
                                <a href="<?=base_url('admin1947/crm/onboard_partner/' . $l['id']);?>" class="btn btn-xs btn-success" title="Onboard into Enterprise Platform" style="border-radius: 8px; font-weight: 700; padding: 6px 12px; background: #00a896; border-color: #00a896; box-shadow: 0 2px 6px rgba(0, 168, 150, 0.3);">
                                    <i class="fa fa-plug"></i> Onboard
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr id="emptyTableNotice">
                        <td colspan="7" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                            <i class="fa fa-inbox" style="font-size: 36px; margin-bottom: 12px; display: block; color: #cbd5e1;"></i>
                            <strong style="font-size: 15px; color: #0f172a; display: block;">No Partner Records Found</strong>
                            <span style="font-size: 13px;">Register a new healthcare lead or adjust your filter options.</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: REGISTER NEW HEALTHCARE PARTNER LEAD                               -->
<!-- ========================================================================= -->
<div class="modal fade" id="registerLeadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 18px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; padding: 20px 24px; border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 24px; margin-top: -3px;">&times;</button>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(0, 168, 150, 0.25); color: #2dd4bf; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa fa-hospital-o"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" style="font-weight: 800; color: #ffffff; margin: 0; font-size: 17px;">
                            Register New Healthcare Partner Lead
                        </h4>
                        <small style="color: #94a3b8; font-size: 12px;">Intake clinics, hospitals, labs, and pharmacies into Upchar CRM</small>
                    </div>
                </div>
            </div>

            <form id="registerLeadForm" action="<?=base_url('admin1947/crm/save_lead');?>" method="post">
                <?php if (isset($this->security)): ?>
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <?php endif; ?>

                <div class="modal-body" style="padding: 24px; background: #ffffff;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Facility / Partner Name <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" name="facility_name" class="form-control" placeholder="e.g. Medanta Super Specialty OPD Clinic" required style="border-radius: 9px; height: 42px; font-weight: 600;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Facility Type <span style="color: #ef4444;">*</span>
                            </label>
                            <select name="facility_type" class="form-control" style="border-radius: 9px; height: 42px; font-weight: 600;">
                                <option value="clinic">Clinic / Doctor OPD</option>
                                <option value="hospital">Hospital / Nursing Home</option>
                                <option value="diagnostic_lab">Diagnostic / Pathology Lab</option>
                                <option value="pharmacy">Pharmacy / Chemist</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Key Contact Person <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" name="contact_person" class="form-control" placeholder="Dr. / Director Name" required style="border-radius: 9px; height: 42px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Mobile Phone Number <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="tel" name="phone" class="form-control" placeholder="10-digit phone" required style="border-radius: 9px; height: 42px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Email Address
                            </label>
                            <input type="email" name="email" class="form-control" placeholder="doctor@partner.com" style="border-radius: 9px; height: 42px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                City / Operating Base
                            </label>
                            <input type="text" name="city" class="form-control" value="Lucknow" style="border-radius: 9px; height: 42px; font-weight: 600;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Lead Source
                            </label>
                            <select name="source" class="form-control" style="border-radius: 9px; height: 42px;">
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
                            <select name="priority" class="form-control" style="border-radius: 9px; height: 42px; font-weight: 700;">
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
                                Initial Pipeline Stage
                            </label>
                            <select name="lead_stage" class="form-control" style="border-radius: 9px; height: 42px; font-weight: 600;">
                                <option value="new">1. New Inquiry</option>
                                <option value="contacted">2. Contacted / Pitching</option>
                                <option value="meeting_scheduled">3. Meeting / Demo Fixed</option>
                                <option value="proposal_sent">4. Proposal Sent</option>
                                <option value="signed">5. MoU Signed</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Est. Monthly Revenue (₹)
                            </label>
                            <input type="number" name="est_monthly_revenue" class="form-control" value="50000" style="border-radius: 9px; height: 42px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Referral / Comm (%)
                            </label>
                            <input type="number" name="commission_pct" class="form-control" value="10" style="border-radius: 9px; height: 42px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Scheduled Follow-up Date
                            </label>
                            <input type="date" name="next_followup_date" class="form-control" value="<?=date('Y-m-d', strtotime('+2 days'));?>" style="border-radius: 9px; height: 42px;">
                        </div>
                        <div>
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                Initial Pitch Remarks &amp; Needs
                            </label>
                            <input type="text" name="notes" class="form-control" placeholder="e.g. Interested in home sample collection and doctor appointment booking integration" style="border-radius: 9px; height: 42px;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 9px; font-weight: 600; padding: 9px 18px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 9px; padding: 9px 24px; border: none; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);">
                        <i class="fa fa-check"></i> Register Partner Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: QUICK LOG INTERACTION / CALL NOTE                                  -->
<!-- ========================================================================= -->
<div class="modal fade" id="quickActivityModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 500px;">
        <div class="modal-content" style="border-radius: 18px; border: 1px solid #e2e8f0; box-shadow: 0 20px 40px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 18px 22px; border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8; font-size: 24px; margin-top: -3px;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 16px; margin: 0;">
                    <i class="fa fa-phone" style="color: #00a896; margin-right: 6px;"></i> Log Partner Interaction
                </h4>
            </div>
            <form id="quickActivityForm">
                <input type="hidden" name="lead_id" id="quickActLeadId" value="">
                <?php if (isset($this->security)): ?>
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <?php endif; ?>

                <div class="modal-body" style="padding: 22px; background: #ffffff;">
                    <div style="background: #f8fafc; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                        <span style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Partner Account</span>
                        <strong style="display: block; font-size: 14.5px; color: #0f172a; margin-top: 2px;" id="quickActLeadName">Facility Name</strong>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Interaction Type</label>
                            <select name="activity_type" class="form-control" style="border-radius: 8px; height: 38px; font-weight: 600;">
                                <option value="call">📞 Phone Call</option>
                                <option value="meeting">🤝 In-Person Meeting</option>
                                <option value="site_visit">🏥 Facility Site Visit</option>
                                <option value="whatsapp">💬 WhatsApp Message</option>
                                <option value="email">✉️ Email Update</option>
                                <option value="proposal">📄 Proposal Submitted</option>
                                <option value="note">📝 Internal Note</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12px; font-weight: 700; color: #334155;">Next Follow-up Date</label>
                            <input type="date" name="followup_date" class="form-control" value="<?=date('Y-m-d', strtotime('+3 days'));?>" style="border-radius: 8px; height: 38px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Summary Headline *</label>
                        <input type="text" name="summary" class="form-control" placeholder="e.g. Discussed diagnostic referral tie-up" required style="border-radius: 8px; height: 38px;">
                    </div>

                    <div>
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Detailed Notes &amp; Next Action</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Key talking points, agreements, and deliverables..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 14px 22px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 8px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn" style="background: #00a896; color: #ffffff; border-radius: 8px; font-weight: 700; padding: 8px 20px; border: none;">
                        <i class="fa fa-check"></i> Save Interaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT: FILTERING, SEARCH, LIVE STAGE CHANGER & INTERACTION MODAL     -->
<!-- ========================================================================= -->
<script>
var activeCategory = 'all';
var activeStage = 'all';

function showToast(msg) {
    $('#crmGlobalToastMsg').text(msg);
    $('#crmGlobalToast').fadeIn(200).delay(2600).fadeOut(250);
}

// Stage Filter click handler (from ribbon tiles)
function filterByStage(stageKey) {
    activeStage = stageKey;
    $('#stageFilterDropdown').val(stageKey);

    $('#funnelStageTiles .crm-stage-chip-btn').removeClass('active');
    $('#funnelStageTiles .crm-stage-chip-btn[data-stage="' + stageKey + '"]').addClass('active');

    applyCombinedFilters();
}

// Main filter execution engine
function applyCombinedFilters() {
    var search = $('#partnerQuickSearch').val().toLowerCase().trim();
    var visibleCount = 0;

    $('.crm-lead-row').each(function() {
        var $r = $(this);
        var type = $r.data('type');
        var stage = $r.data('stage');
        var text = $r.data('search') || '';

        var matchCategory = (activeCategory === 'all' || type === activeCategory);
        var matchStage = (activeStage === 'all' || stage === activeStage);
        var matchSearch = (search === '' || text.indexOf(search) > -1);

        if (matchCategory && matchStage && matchSearch) {
            $r.show();
            visibleCount++;
        } else {
            $r.hide();
        }
    });

    $('#visibleLeadsCount').text(visibleCount);

    if (visibleCount === 0) {
        if (!$('#dynamicEmptyRow').length) {
            $('#crmLeadsTable tbody').append('<tr id="dynamicEmptyRow"><td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;"><i class="fa fa-search" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>No matching partner records found for active filters.</td></tr>');
        }
    } else {
        $('#dynamicEmptyRow').remove();
    }
}

$(document).ready(function() {
    // 1. Category Pill Click Handler
    $('#categoryFilterGroup .crm-filter-pill').click(function() {
        $('#categoryFilterGroup .crm-filter-pill').removeClass('active');
        $(this).addClass('active');
        activeCategory = $(this).data('type');
        applyCombinedFilters();
    });

    // 2. Stage Filter Dropdown Change
    $('#stageFilterDropdown').change(function() {
        filterByStage($(this).val());
    });

    // 3. Search Box Keyup
    $('#partnerQuickSearch').on('keyup', function() {
        applyCombinedFilters();
    });

    // 4. Live Instant Stage Selector
    $(document).on('change', '.quick-stage-changer', function() {
        var $select = $(this);
        var leadId = $select.data('lead-id');
        var newStage = $select.val();
        var csrfName = '<?=$this->security ? $this->security->get_csrf_token_name() : "csrf_test_name";?>';
        var csrfHash = '<?=$this->security ? $this->security->get_csrf_hash() : "";?>';

        var postData = {
            lead_id: leadId,
            stage: newStage
        };
        if (csrfHash) postData[csrfName] = csrfHash;

        $select.prop('disabled', true);
        $.ajax({
            url: '<?=base_url("admin1947/crm/update_stage");?>',
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function(res) {
                $select.prop('disabled', false);
                if (res.status === 'success') {
                    showToast(res.message);
                    $select.closest('tr').data('stage', newStage);
                    $select.css({'border-color': '#10b981', 'background': '#ecfdf5'});
                    setTimeout(function() {
                        $select.css({'border-color': '#cbd5e1', 'background': '#f8fafc'});
                    }, 1400);
                } else {
                    alert(res.message || 'Error updating stage.');
                }
            },
            error: function(xhr) {
                $select.prop('disabled', false);
                alert('Server error updating stage.');
            }
        });
    });

    // 5. Open Quick Log Activity Modal
    $(document).on('click', '.btn-log-quick-act', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#quickActLeadId').val(id);
        $('#quickActLeadName').text(name);
        $('#quickActivityModal').modal('show');
    });

    // 6. Submit Quick Activity Form via AJAX
    $('#quickActivityForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '<?=base_url("admin1947/crm/log_activity");?>',
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
            error: function(xhr) {
                alert('Error submitting interaction.');
            }
        });
    });
});
</script>
