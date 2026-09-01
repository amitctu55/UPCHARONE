<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="max-width: 700px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
        <a href="<?=base_url('crm/leads');?>" class="btn btn-sm btn-default" style="font-weight: 700; border-radius: 8px;">
            <i class="fa fa-arrow-left"></i> Back to Kanban
        </a>
        <h3 style="margin: 0; font-size: 20px; font-weight: 800; color: #0f172a;">
            Onboard Partner to Upchar Platform
        </h3>
    </div>

    <div class="crm-card" style="padding: 28px;">
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 10px; padding: 14px; margin-bottom: 20px;">
            <strong style="color: #065f46; font-size: 14px;"><i class="fa fa-trophy"></i> Signed Lead Milestone</strong>
            <p style="margin: 4px 0 0; color: #047857; font-size: 12.5px;">
                This partner has signed with BDE. Registering will activate their portal profile and establish custom referral revenue sharing.
            </p>
        </div>

        <form action="<?=base_url('crm/leads');?>" method="get">
            <div style="display: grid; gap: 14px;">
                <div>
                    <label style="font-size: 13px; font-weight: 700; color: #334155;">Facility / Provider Name</label>
                    <input type="text" class="form-control" value="<?=html_escape($lead['facility_name']);?>" readonly style="background: #f8fafc; font-weight: 700; border-radius: 8px;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="font-size: 13px; font-weight: 700; color: #334155;">Provider Type</label>
                        <input type="text" class="form-control" value="<?=strtoupper($lead['facility_type']);?>" readonly style="background: #f8fafc; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="font-size: 13px; font-weight: 700; color: #334155;">City Hub</label>
                        <input type="text" class="form-control" value="<?=html_escape($lead['city']);?>" readonly style="background: #f8fafc; border-radius: 8px;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="font-size: 13px; font-weight: 700; color: #334155;">Contact Person</label>
                        <input type="text" class="form-control" value="<?=html_escape($lead['contact_person']);?>" readonly style="background: #f8fafc; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="font-size: 13px; font-weight: 700; color: #334155;">Mobile</label>
                        <input type="text" class="form-control" value="<?=html_escape($lead['phone']);?>" readonly style="background: #f8fafc; border-radius: 8px;">
                    </div>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 700; color: #334155;">Custom Revenue Commission (%)</label>
                    <input type="number" class="form-control" value="<?=$lead['commission_pct'];?>" style="border-radius: 8px; font-weight: 700; color: #00a896;">
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn btn-block" style="background: var(--crm-teal); color: #fff; font-weight: 800; font-size: 15px; border-radius: 10px; padding: 12px;">
                        <i class="fa fa-check-circle"></i> Activate Verified Partner Profile
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
