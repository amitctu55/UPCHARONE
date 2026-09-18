<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
/* ==========================================================================
   FOLLOW-UP RADAR & ACTION CONSOLE STYLES
   ========================================================================== */
.crm-radar-container {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #0f172a;
}
.crm-radar-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 20px;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}
.crm-radar-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.08);
    border-color: #cbd5e1;
}
.crm-radar-card.is-overdue {
    border-left: 4px solid #ef4444;
}
.crm-radar-card.is-today {
    border-left: 4px solid #f59e0b;
}
.crm-radar-card.is-upcoming {
    border-left: 4px solid #3b82f6;
}
.crm-radar-filter-pill {
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
.crm-radar-filter-pill.active, .crm-radar-filter-pill:hover {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.crm-toast {
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

<div class="crm-radar-container">
    <!-- Floating Toast -->
    <div class="crm-toast" id="radarToast">
        <i class="fa fa-check-circle" style="color: #10b981; margin-right: 8px;"></i>
        <span id="radarToastMsg">Action completed successfully.</span>
    </div>

    <!-- Header Action Strip -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; background: #ffffff; padding: 20px 24px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; color: #dc2626; background: #fee2e2; padding: 3px 8px; border-radius: 6px;">
                    <i class="fa fa-crosshairs"></i> Operational Radar
                </span>
                <span style="font-size: 12px; color: #94a3b8;">&bull; Time-Sensitive Action Console</span>
            </div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                Follow-up Radar &amp; Scheduled Touchpoints
            </h1>
            <p style="margin: 4px 0 0; font-size: 13px; color: #64748b;">
                Never lose a healthcare provider deal. Monitor overdue contacts, urgent meetings, and scheduled partner milestones.
            </p>
        </div>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="<?=base_url('admin1947/crm');?>" class="btn" style="background: #f8fafc; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; border: 1px solid #cbd5e1;">
                <i class="fa fa-line-chart" style="color: #f59e0b; margin-right: 4px;"></i> CRM Dashboard
            </a>
            <a href="<?=base_url('admin1947/crm/leads');?>" class="btn" style="background: #f8fafc; color: #0f172a; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px; border: 1px solid #cbd5e1;">
                <i class="fa fa-columns" style="color: #38bdf8; margin-right: 4px;"></i> Kanban Board
            </a>
            <button type="button" class="btn" data-toggle="modal" data-target="#registerLeadModal" style="background: linear-gradient(135deg, #0f172a 0%, #00a896 100%); color: #ffffff; font-weight: 700; border-radius: 10px; padding: 9px 20px; font-size: 13px; border: none; box-shadow: 0 4px 14px rgba(0, 168, 150, 0.25);">
                <i class="fa fa-plus-circle" style="color: #2dd4bf; margin-right: 4px;"></i> Register Partner Lead
            </button>
        </div>
    </div>

    <!-- Metric Badges Row -->
    <?php
    $today = date('Y-m-d');
    $overdueCount = 0;
    $dueTodayCount = 0;
    $upcomingCount = 0;
    if (!empty($all_radar)) {
        foreach ($all_radar as $r) {
            $fDate = $r['next_followup_date'];
            if ($fDate < $today) $overdueCount++;
            elseif ($fDate === $today) $dueTodayCount++;
            else $upcomingCount++;
        }
    }
    ?>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: #ffffff; border-radius: 16px; padding: 18px 20px; border: 1px solid #e2e8f0; border-left: 5px solid #ef4444; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
            <span style="font-size: 11px; font-weight: 800; color: #ef4444; text-transform: uppercase;">Overdue Action Items</span>
            <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=$overdueCount;?></div>
            <small style="color: #64748b; font-size: 11.5px;">Requires urgent field call or visit</small>
        </div>
        <div style="background: #ffffff; border-radius: 16px; padding: 18px 20px; border: 1px solid #e2e8f0; border-left: 5px solid #f59e0b; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
            <span style="font-size: 11px; font-weight: 800; color: #d97706; text-transform: uppercase;">Scheduled Due Today</span>
            <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=$dueTodayCount;?></div>
            <small style="color: #64748b; font-size: 11.5px;">Follow-up due by end of day</small>
        </div>
        <div style="background: #ffffff; border-radius: 16px; padding: 18px 20px; border: 1px solid #e2e8f0; border-left: 5px solid #3b82f6; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
            <span style="font-size: 11px; font-weight: 800; color: #2563eb; text-transform: uppercase;">Upcoming This Week</span>
            <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=$upcomingCount;?></div>
            <small style="color: #64748b; font-size: 11.5px;">Advance pipeline touchpoints</small>
        </div>
        <div style="background: #ffffff; border-radius: 16px; padding: 18px 20px; border: 1px solid #e2e8f0; border-left: 5px solid #10b981; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
            <span style="font-size: 11px; font-weight: 800; color: #059669; text-transform: uppercase;">Total Radar Watchlist</span>
            <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=count($all_radar);?></div>
            <small style="color: #64748b; font-size: 11.5px;">Active provider accounts tracked</small>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 16px 20px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap;" id="radarUrgencyGroup">
            <button type="button" class="crm-radar-filter-pill active" data-urgency="all">
                All Radar Items (<?=count($all_radar);?>)
            </button>
            <button type="button" class="crm-radar-filter-pill" data-urgency="overdue">
                <i class="fa fa-exclamation-circle" style="color: #ef4444;"></i> Overdue (<?=$overdueCount;?>)
            </button>
            <button type="button" class="crm-radar-filter-pill" data-urgency="today">
                <i class="fa fa-clock-o" style="color: #f59e0b;"></i> Due Today (<?=$dueTodayCount;?>)
            </button>
            <button type="button" class="crm-radar-filter-pill" data-urgency="upcoming">
                <i class="fa fa-calendar" style="color: #3b82f6;"></i> Upcoming (<?=$upcomingCount;?>)
            </button>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <div style="position: relative; width: 260px;">
                <i class="fa fa-search" style="position: absolute; left: 12px; top: 11px; color: #94a3b8; font-size: 13px;"></i>
                <input type="text" id="radarQuickSearch" class="form-control" placeholder="Search partner, contact, city..." style="padding-left: 34px; height: 38px; border-radius: 9px; font-size: 12.5px; border: 1px solid #cbd5e1;">
            </div>
        </div>
    </div>

    <!-- Grid of Radar Telemetry Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 18px; margin-bottom: 30px;" id="radarGridContainer">
        <?php if (!empty($all_radar)): foreach ($all_radar as $r): 
            $fDate = $r['next_followup_date'];
            $urgencyType = 'upcoming';
            $urgencyLabel = 'Upcoming';
            $urgencyBg = '#eff6ff';
            $urgencyColor = '#2563eb';

            if ($fDate < $today) {
                $urgencyType = 'overdue';
                $diffDays = round((strtotime($today) - strtotime($fDate)) / 86400);
                $urgencyLabel = '🔥 Overdue (' . $diffDays . 'd)';
                $urgencyBg = '#fee2e2';
                $urgencyColor = '#ef4444';
            } elseif ($fDate === $today) {
                $urgencyType = 'today';
                $urgencyLabel = '⚡ Due Today';
                $urgencyBg = '#fef3c7';
                $urgencyColor = '#d97706';
            } else {
                $diffDays = round((strtotime($fDate) - strtotime($today)) / 86400);
                $urgencyLabel = '🗓️ in ' . $diffDays . ' day' . ($diffDays > 1 ? 's' : '');
            }

            $fType = $r['facility_type'] ?? 'clinic';
            $badgeBg = '#eff6ff'; $badgeColor = '#2563eb'; $typeIcon = 'fa-building';
            if ($fType === 'hospital') { $badgeBg = '#eff6ff'; $badgeColor = '#2563eb'; $typeIcon = 'fa-hospital-o'; }
            elseif ($fType === 'clinic') { $badgeBg = '#ecfdf5'; $badgeColor = '#059669'; $typeIcon = 'fa-user-md'; }
            elseif ($fType === 'diagnostic_lab') { $badgeBg = '#f5f3ff'; $badgeColor = '#7c3aed'; $typeIcon = 'fa-flask'; }
            elseif ($fType === 'pharmacy') { $badgeBg = '#fffbeb'; $badgeColor = '#d97706'; $typeIcon = 'fa-medkit'; }

            $searchStr = strtolower($r['facility_name'] . ' ' . $r['contact_person'] . ' ' . $r['phone'] . ' ' . ($r['city'] ?? '') . ' ' . ($r['notes'] ?? ''));
        ?>
        <div class="crm-radar-card is-<?=$urgencyType;?> radar-item-card" 
             data-urgency="<?=$urgencyType;?>" 
             data-search="<?=$searchStr;?>">
            
            <div>
                <!-- Top Row: Urgency Pill + Facility Type Badge -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="background: <?=$urgencyBg;?>; color: <?=$urgencyColor;?>; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px;">
                        <?=$urgencyLabel;?>
                    </span>
                    <span style="background: <?=$badgeBg;?>; color: <?=$badgeColor;?>; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 8px; display: inline-flex; align-items: center; gap: 5px;">
                        <i class="fa <?=$typeIcon;?>"></i> <?=ucwords(str_replace('_', ' ', $fType));?>
                    </span>
                </div>

                <!-- Facility Title -->
                <h4 style="font-size: 15.5px; font-weight: 800; color: #0f172a; margin: 0 0 6px; line-height: 1.3;">
                    <?=html_escape($r['facility_name']);?>
                </h4>

                <!-- Contact Person & Location -->
                <div style="font-size: 12.5px; color: #475569; margin-bottom: 12px;">
                    <span style="font-weight: 700; color: #1e293b;">
                        <i class="fa fa-user-circle-o" style="color: #64748b;"></i> <?=html_escape($r['contact_person']);?>
                    </span>
                    <span style="color: #94a3b8; margin: 0 4px;">&bull;</span>
                    <span><i class="fa fa-map-marker" style="color: #94a3b8;"></i> <?=html_escape($r['city'] ?: 'Lucknow, UP');?></span>
                </div>

                <!-- Deal Economics & Stage -->
                <div style="background: #f8fafc; border-radius: 10px; padding: 10px 12px; border: 1px solid #e2e8f0; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <small style="font-size: 10.5px; color: #64748b; text-transform: uppercase; font-weight: 700;">Est. Monthly Rev</small>
                        <div style="font-size: 14.5px; font-weight: 800; color: #15803d;">
                            ₹<?=number_format($r['est_monthly_revenue'], 0);?>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <small style="font-size: 10.5px; color: #64748b; text-transform: uppercase; font-weight: 700;">Current Stage</small>
                        <div>
                            <span class="badge" style="background: #0f172a; color: #ffffff; font-size: 10.5px; font-weight: 700; text-transform: uppercase;">
                                <?=str_replace('_', ' ', $r['lead_stage']);?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Note Preview -->
                <?php if (!empty($r['notes'])): ?>
                <div style="font-size: 11.5px; color: #64748b; line-height: 1.35; margin-bottom: 14px; background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 8px 10px;">
                    <i class="fa fa-comment-o" style="color: #94a3b8;"></i> <?=html_escape(substr($r['notes'], 0, 100));?><?=(strlen($r['notes']) > 100 ? '...' : '');?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Footer Date & Action Buttons -->
            <div style="border-top: 1px solid #f1f5f9; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; margin-top: 6px;">
                <span style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                    <i class="fa fa-calendar-check-o"></i> <?=date('d M Y', strtotime($r['next_followup_date']));?>
                </span>

                <div style="display: flex; gap: 6px;">
                    <a href="tel:<?=$r['phone'];?>" class="btn btn-xs btn-default" style="border-radius: 7px; font-weight: 700; color: #0284c7; padding: 5px 9px;" title="Direct Call">
                        <i class="fa fa-phone"></i>
                    </a>
                    <a href="https://wa.me/91<?=$r['phone'];?>" target="_blank" class="btn btn-xs btn-default" style="border-radius: 7px; font-weight: 700; color: #16a34a; padding: 5px 9px;" title="WhatsApp">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                    <button type="button" class="btn btn-xs btn-primary btn-log-quick-act" data-id="<?=$r['id'];?>" data-name="<?=html_escape($r['facility_name']);?>" style="border-radius: 7px; font-weight: 700; background: #00a896; border-color: #00a896; padding: 5px 12px;">
                        <i class="fa fa-check"></i> Log
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; color: #94a3b8;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 14px;">
                <i class="fa fa-check"></i>
            </div>
            <strong style="font-size: 16px; color: #0f172a; display: block;">All Caught Up!</strong>
            <span style="font-size: 13px;">No overdue or pending follow-up touchpoints required right now.</span>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Log Interaction Modal Shared -->
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

<script>
var activeUrgency = 'all';

function showToast(msg) {
    $('#radarToastMsg').text(msg);
    $('#radarToast').fadeIn(200).delay(2600).fadeOut(250);
}

function filterRadarCards() {
    var search = $('#radarQuickSearch').val().toLowerCase().trim();
    var visible = 0;

    $('.radar-item-card').each(function() {
        var $c = $(this);
        var urgency = $c.data('urgency');
        var text = $c.data('search') || '';

        var matchUrgency = (activeUrgency === 'all' || urgency === activeUrgency);
        var matchSearch = (search === '' || text.indexOf(search) > -1);

        if (matchUrgency && matchSearch) {
            $c.show();
            visible++;
        } else {
            $c.hide();
        }
    });

    if (visible === 0) {
        if (!$('#dynamicRadarEmpty').length) {
            $('#radarGridContainer').append('<div id="dynamicRadarEmpty" style="grid-column: 1 / -1; text-align: center; padding: 50px 20px; color: #94a3b8;"><i class="fa fa-search" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>No matching follow-up radar items found for selected filter.</div>');
        }
    } else {
        $('#dynamicRadarEmpty').remove();
    }
}

$(document).ready(function() {
    $('#radarUrgencyGroup .crm-radar-filter-pill').click(function() {
        $('#radarUrgencyGroup .crm-radar-filter-pill').removeClass('active');
        $(this).addClass('active');
        activeUrgency = $(this).data('urgency');
        filterRadarCards();
    });

    $('#radarQuickSearch').on('keyup', function() {
        filterRadarCards();
    });

    $(document).on('click', '.btn-log-quick-act', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#quickActLeadId').val(id);
        $('#quickActLeadName').text(name);
        $('#quickActivityModal').modal('show');
    });

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
