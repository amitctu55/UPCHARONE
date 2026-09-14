<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="max-width: 720px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
        <a href="<?=base_url('crm/leads');?>" class="btn btn-default" style="font-weight: 700; border-radius: 10px; padding: 8px 16px;">
            <i class="fa fa-arrow-left"></i> Back to Kanban
        </a>
        <div>
            <h2 style="margin: 0; font-size: 20px; font-weight: 800; color: #0f172a;">
                Onboard Healthcare Partner
            </h2>
            <small style="color: #64748b;">Activate partner portal access and finalize referral terms</small>
        </div>
    </div>

    <div style="background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; padding: 28px; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);">
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 16px; margin-bottom: 22px; display: flex; gap: 12px; align-items: flex-start;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: #d1fae5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                <i class="fa fa-trophy"></i>
            </div>
            <div>
                <strong style="color: #065f46; font-size: 14.5px; display: block;">MoU Signed Milestone Achieved</strong>
                <p style="margin: 4px 0 0; color: #047857; font-size: 12.5px; line-height: 1.4;">
                    This provider has signed their partnership agreement. Verifying their account will generate API credentials, patient referral routing, and commission payout terms.
                </p>
            </div>
        </div>

        <form action="<?=base_url('crm/leads');?>" method="get">
            <div style="display: grid; gap: 16px;">
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Facility / Provider Name</label>
                    <input type="text" class="form-control" value="<?=html_escape($lead['facility_name']);?>" readonly style="background: #f8fafc; font-weight: 700; border-radius: 9px; height: 40px; color: #0f172a;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Provider Type</label>
                        <input type="text" class="form-control" value="<?=ucwords(str_replace('_', ' ', $lead['facility_type']));?>" readonly style="background: #f8fafc; border-radius: 9px; height: 40px; font-weight: 600;">
                    </div>
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">City / Region</label>
                        <input type="text" class="form-control" value="<?=html_escape($lead['city']);?>" readonly style="background: #f8fafc; border-radius: 9px; height: 40px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Contact Person</label>
                        <input type="text" class="form-control" value="<?=html_escape($lead['contact_person']);?>" readonly style="background: #f8fafc; border-radius: 9px; height: 40px;">
                    </div>
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Mobile Phone</label>
                        <input type="text" class="form-control" value="<?=html_escape($lead['phone']);?>" readonly style="background: #f8fafc; border-radius: 9px; height: 40px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Custom Revenue Commission (%)</label>
                        <input type="number" class="form-control" value="<?=$lead['commission_pct'];?>" style="border-radius: 9px; height: 40px; font-weight: 700; color: #00a896;">
                    </div>
                    <div>
                        <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">Est. Monthly Revenue (₹)</label>
                        <input type="text" class="form-control" value="₹<?=number_format($lead['est_monthly_revenue'], 2);?>" readonly style="background: #f8fafc; border-radius: 9px; height: 40px; font-weight: 700; color: #15803d;">
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #fff; font-weight: 800; font-size: 14.5px; border-radius: 10px; padding: 12px; border: none; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);">
                        <i class="fa fa-check-circle"></i> Activate Verified Partner Profile
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
