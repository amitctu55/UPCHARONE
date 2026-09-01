<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            BDE Revenue &amp; Partner Pipeline Overview
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Track your healthcare provider acquisition funnel, clinic registrations, and signed revenue.
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="<?=base_url('crm/leads');?>" class="btn" style="background: var(--crm-amber); color: #fff; font-weight: 700; border-radius: 8px; padding: 9px 18px; font-size: 13px;">
            <i class="fa fa-columns"></i> Open Kanban Board
        </a>
    </div>
</div>

<!-- KPI Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="crm-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Total Pipeline Leads</div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=$metrics['total_leads'];?></div>
        <div style="font-size: 12px; color: #38bdf8; font-weight: 600; margin-top: 4px;">
            <i class="fa fa-building"></i> Hospitals, Clinics &amp; Labs
        </div>
    </div>

    <div class="crm-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Signed Partners</div>
        <div style="font-size: 26px; font-weight: 800; color: #16a34a; margin-top: 4px;"><?=$metrics['signed_partners'];?></div>
        <div style="font-size: 12px; color: #16a34a; font-weight: 600; margin-top: 4px;">
            <i class="fa fa-check-circle"></i> Onboarded to Upchar
        </div>
    </div>

    <div class="crm-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Est. Monthly Revenue</div>
        <div style="font-size: 26px; font-weight: 800; color: #d97706; margin-top: 4px;">
            ₹<?=number_format($metrics['signed_revenue'], 2);?>
        </div>
        <div style="font-size: 12px; color: #d97706; font-weight: 600; margin-top: 4px;">
            <i class="fa fa-line-chart"></i> Active signed accounts
        </div>
    </div>

    <div class="crm-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Conversion Rate</div>
        <div style="font-size: 26px; font-weight: 800; color: #8b5cf6; margin-top: 4px;"><?=$metrics['conversion_rate'];?>%</div>
        <div style="font-size: 12px; color: #8b5cf6; font-weight: 600; margin-top: 4px;">
            Lead to Signed partner
        </div>
    </div>
</div>

<!-- Recent Leads Table -->
<div class="crm-card" style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">
            <i class="fa fa-handshake-o" style="color: var(--crm-amber); margin-right: 6px;"></i> Active Partner Accounts
        </h4>
        <a href="<?=base_url('crm/leads');?>" class="btn btn-xs btn-default" style="font-weight: 700; border-radius: 6px;">
            View All in Kanban &rarr;
        </a>
    </div>

    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11.5px; color: #64748b; text-transform: uppercase;">
                    <th>Facility Name</th>
                    <th>Type &amp; City</th>
                    <th>Contact Person</th>
                    <th>Est. Revenue</th>
                    <th>Current Stage</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recent_leads)): ?>
                    <?php foreach ($recent_leads as $l): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 13.5px;"><?=html_escape($l['facility_name']);?></div>
                            <small style="color: #64748b;"><?=$l['phone'];?></small>
                        </td>
                        <td>
                            <span class="badge" style="background: #f1f5f9; color: #334155; text-transform: uppercase; font-size: 11px;">
                                <?=html_escape($l['facility_type']);?>
                            </span>
                            <small style="display: block; color: #64748b; margin-top: 2px;"><?=$l['city'];?></small>
                        </td>
                        <td style="font-size: 13px; color: #1e293b; font-weight: 600;">
                            <?=html_escape($l['contact_person']);?>
                        </td>
                        <td>
                            <strong style="color: #15803d; font-size: 14px;">₹<?=number_format($l['est_monthly_revenue'], 2);?></strong>
                            <small style="display: block; color: #64748b; font-size: 11px;"><?=$l['commission_pct'];?>% commission</small>
                        </td>
                        <td>
                            <span class="label label-primary" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                <?=str_replace('_', ' ', $l['lead_stage']);?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
