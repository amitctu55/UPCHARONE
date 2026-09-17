<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.crm-act-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 20px;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
}
.crm-timeline-item {
    display: flex;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid #f1f5f9;
    position: relative;
}
.crm-timeline-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.crm-timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 2px;
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

<div class="crm-toast" id="crmActPageToast">
    <i class="fa fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>
    <span id="crmActPageToastMsg">Activity logged successfully!</span>
</div>

<!-- Page Title -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Activity Log &amp; Follow-up Scheduler
        </h1>
        <p style="margin: 0; font-size: 13px; color: #64748b;">
            Track all touchpoints, call notes, on-site demonstrations, and upcoming partner deadlines.
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="<?=base_url('admin1947/crm/leads');?>" class="btn" style="background: #ffffff; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; border: 1px solid #cbd5e1;">
            <i class="fa fa-columns" style="color: #f59e0b;"></i> Kanban Pipeline
        </a>
    </div>
</div>

<!-- 2-Column Split: Form on Left, Timeline on Right -->
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
    
    <!-- Left: Log New Interaction Form -->
    <div class="crm-act-card" style="height: fit-content;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                <i class="fa fa-pencil-square-o"></i>
            </div>
            <div>
                <strong style="font-size: 15.5px; color: #0f172a; display: block;">Log New Touchpoint</strong>
                <small style="color: #64748b; font-size: 11.5px;">Record calls, meetings or visits</small>
            </div>
        </div>

        <form id="onPageActForm">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
            
            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                    Select Partner / Facility *
                </label>
                <select name="lead_id" class="form-control" required style="border-radius: 9px; height: 38px; font-weight: 600;">
                    <option value="">-- Choose Healthcare Facility --</option>
                    <?php foreach ($leads_dropdown as $ld): ?>
                    <option value="<?=$ld['id'];?>">
                        <?=html_escape($ld['facility_name']);?> (<?=ucfirst($ld['facility_type']);?> - <?=html_escape($ld['city']);?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div>
                    <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Type</label>
                    <select name="activity_type" class="form-control" style="border-radius: 9px; height: 38px;">
                        <option value="call">📞 Phone Call</option>
                        <option value="meeting">🤝 In-Person Meeting</option>
                        <option value="site_visit">🏥 Hospital/Clinic Visit</option>
                        <option value="whatsapp">💬 WhatsApp Chat</option>
                        <option value="email">✉️ Email Update</option>
                        <option value="proposal">📄 Proposal Sent</option>
                        <option value="note">📝 Internal Note</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Next Follow-up</label>
                    <input type="date" name="followup_date" class="form-control" value="<?=date('Y-m-d', strtotime('+3 days'));?>" style="border-radius: 9px; height: 38px;">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                    Interaction Summary *
                </label>
                <input type="text" name="summary" class="form-control" placeholder="e.g. Phone call with Medical Superintendent" required style="border-radius: 9px; height: 38px;">
            </div>

            <div style="margin-bottom: 18px;">
                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                    Discussion Notes &amp; Action Items
                </label>
                <textarea name="notes" class="form-control" rows="4" placeholder="Detailed key outcomes, terms agreed, objections resolved..." style="border-radius: 9px;"></textarea>
            </div>

            <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 9px; height: 42px; border: none; font-size: 13.5px;">
                <i class="fa fa-check"></i> Save Touchpoint
            </button>
        </form>
    </div>

    <!-- Right: Chronological Activity Feed -->
    <div class="crm-act-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
            <div>
                <strong style="font-size: 16px; color: #0f172a;">
                    <i class="fa fa-history" style="color: #00a896; margin-right: 6px;"></i> Audit Trail &amp; Follow-up Stream
                </strong>
                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                    Total logged touchpoints: <strong><?=count($activities);?></strong>
                </div>
            </div>
            
            <div style="display: flex; gap: 6px;" id="actFilterPills">
                <button type="button" class="btn btn-xs btn-default active-act-filter" data-type="all" style="font-weight: 700; border-radius: 6px;">All</button>
                <button type="button" class="btn btn-xs btn-default" data-type="call" style="font-weight: 600; border-radius: 6px;">Calls</button>
                <button type="button" class="btn btn-xs btn-default" data-type="meeting" style="font-weight: 600; border-radius: 6px;">Meetings</button>
                <button type="button" class="btn btn-xs btn-default" data-type="site_visit" style="font-weight: 600; border-radius: 6px;">Visits</button>
                <button type="button" class="btn btn-xs btn-default" data-type="whatsapp" style="font-weight: 600; border-radius: 6px;">WhatsApp</button>
            </div>
        </div>

        <div id="activitiesStream">
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $act): ?>
                <?php
                $typeStyles = [
                    'call' => ['icon' => 'fa-phone', 'bg' => '#e0f2fe', 'color' => '#0284c7'],
                    'meeting' => ['icon' => 'fa-users', 'bg' => '#fef3c7', 'color' => '#d97706'],
                    'site_visit' => ['icon' => 'fa-building', 'bg' => '#dcfce7', 'color' => '#15803d'],
                    'whatsapp' => ['icon' => 'fa-whatsapp', 'bg' => '#ecfdf5', 'color' => '#059669'],
                    'email' => ['icon' => 'fa-envelope-o', 'bg' => '#f3e8ff', 'color' => '#7e22ce'],
                    'proposal' => ['icon' => 'fa-file-text-o', 'bg' => '#fae8ff', 'color' => '#a21caf'],
                    'note' => ['icon' => 'fa-pencil', 'bg' => '#f1f5f9', 'color' => '#475569']
                ];
                $ts = $typeStyles[$act['activity_type']] ?? ['icon' => 'fa-comment-o', 'bg' => '#f1f5f9', 'color' => '#475569'];
                ?>
                <div class="crm-timeline-item act-item-row" data-type="<?=$act['activity_type'];?>">
                    <div class="crm-timeline-icon" style="background: <?=$ts['bg'];?>; color: <?=$ts['color'];?>;">
                        <i class="fa <?=$ts['icon'];?>"></i>
                    </div>
                    <div style="flex-grow: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 6px;">
                            <div>
                                <strong style="font-size: 14px; color: #0f172a;">
                                    <?=html_escape($act['facility_name']);?>
                                </strong>
                                <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 10px; text-transform: uppercase; margin-left: 6px;">
                                    <?=ucwords(str_replace('_', ' ', $act['facility_type']));?>
                                </span>
                            </div>
                            <span style="font-size: 11.5px; color: #94a3b8;">
                                <i class="fa fa-clock-o"></i> <?=date('d M Y, h:i A', strtotime($act['created_at']));?>
                            </span>
                        </div>

                        <div style="font-size: 13px; font-weight: 700; color: #334155; margin-top: 4px;">
                            <?=html_escape($act['summary']);?>
                        </div>

                        <?php if (!empty($act['notes'])): ?>
                        <p style="margin: 6px 0 0; font-size: 12px; color: #64748b; background: #f8fafc; padding: 8px 12px; border-radius: 8px; border: 1px solid #f1f5f9; line-height: 1.4;">
                            <?=nl2br(html_escape($act['notes']));?>
                        </p>
                        <?php endif; ?>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; font-size: 11.5px;">
                            <span style="color: #64748b;">
                                Contact: <strong style="color: #0f172a;"><?=html_escape($act['contact_person']);?></strong> (<?=$act['lead_phone'];?>)
                            </span>
                            <?php if (!empty($act['followup_date'])): ?>
                            <span style="color: #ef4444; font-weight: 700;">
                                <i class="fa fa-calendar-check-o"></i> Next: <?=$act['followup_date'];?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                    <i class="fa fa-comments-o" style="font-size: 32px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                    No activities recorded yet.
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {
    function showToast(msg) {
        $('#crmActPageToastMsg').text(msg);
        $('#crmActPageToast').fadeIn(200).delay(2500).fadeOut(200);
    }

    // Filter timeline by activity type
    $('#actFilterPills button').click(function() {
        $('#actFilterPills button').removeClass('btn-primary').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-primary');
        var selected = $(this).data('type');

        if (selected === 'all') {
            $('.act-item-row').show();
        } else {
            $('.act-item-row').each(function() {
                if ($(this).data('type') === selected) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });

    // Submit On-page Activity form
    $('#onPageActForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?=base_url("admin1947/crm/log_activity");?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    showToast(res.message);
                    setTimeout(function() {
                        location.reload();
                    }, 700);
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
