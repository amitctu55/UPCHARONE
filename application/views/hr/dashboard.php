<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="hr-dashboard-content" style="max-width: 1400px; margin: 0 auto;">

    <!-- Flash Alerts -->
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible" style="border-radius: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-weight: 600;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check-circle"></i> <?=$this->session->flashdata('success_msg');?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible" style="border-radius: 12px; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-weight: 600;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-exclamation-circle"></i> <?=$this->session->flashdata('error_msg');?>
        </div>
    <?php endif; ?>

    <!-- Action Toolbar Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.3px;">
                Workforce Command &amp; Operations Center
            </h2>
            <p style="margin: 0; font-size: 13.5px; color: #64748b;">
                Real-time overview of staff attendance, active field shifts, pending leaves, and hiring operations.
            </p>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <a href="<?=base_url('hr/jobs');?>" class="btn" style="background: #ffffff; color: #0f172a; border: 1px solid #cbd5e1; font-weight: 700; border-radius: 10px; padding: 9px 16px; font-size: 13px;">
                <i class="fa fa-plus-circle" style="color: #6366f1; margin-right: 4px;"></i> Post Requisition
            </a>
            <a href="<?=base_url('hr/employees');?>" class="btn" style="background: #00a896; color: #fff; font-weight: 700; border: none; border-radius: 10px; padding: 9px 18px; font-size: 13px; box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);">
                <i class="fa fa-user-plus" style="margin-right: 4px;"></i> Add Employee
            </a>
        </div>
    </div>

    <!-- Executive KPI Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active Staff</span>
                <div style="font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=$total_staff;?></div>
                <small style="color: #3b82f6; font-weight: 600; font-size: 11.5px;">Hospital &amp; Field Staff</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa fa-users"></i>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Today Present</span>
                <div style="font-size: 28px; font-weight: 800; color: #10b981; margin-top: 4px;"><?=$today_present;?></div>
                <small style="color: #10b981; font-weight: 600; font-size: 11.5px;">Punched in geofenced area</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa fa-check-circle"></i>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Late Marks</span>
                <div style="font-size: 28px; font-weight: 800; color: #d97706; margin-top: 4px;"><?=$today_late;?></div>
                <small style="color: #d97706; font-weight: 600; font-size: 11.5px;">Punched after shift start</small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa fa-clock-o"></i>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Pending Leaves</span>
                <div style="font-size: 28px; font-weight: 800; color: #ec4899; margin-top: 4px;"><?=count($pending_leaves ?? []);?></div>
                <small style="color: #ec4899; font-weight: 600; font-size: 11.5px;">
                    <a href="<?=base_url('hr/leaves');?>" style="color: inherit; text-decoration: none;">Review Applications &rarr;</a>
                </small>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #fdf2f8; color: #ec4899; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa fa-file-text-o"></i>
            </div>
        </div>
    </div>

    <!-- Live Attendance Roster Desk -->
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); overflow: hidden; margin-bottom: 24px;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                    <i class="fa fa-id-badge" style="color: #00a896; margin-right: 6px;"></i> Today's Live Attendance Roster
                </h3>
                <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 9999px; font-size: 12px; font-weight: 700;">
                    <?=date('d M Y');?>
                </span>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="<?=base_url('attendance/roster');?>" class="btn btn-sm" style="background: #f8fafc; border: 1px solid #cbd5e1; font-weight: 700; border-radius: 8px; font-size: 12px;">
                    <i class="fa fa-calendar-check-o"></i> Full Roster
                </a>
                <a href="<?=base_url('hr/payroll');?>" class="btn btn-sm" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; font-weight: 700; border-radius: 8px; font-size: 12px;">
                    <i class="fa fa-calculator"></i> Payroll
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom: 0;">
                <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr style="font-size: 11.5px; color: #475569; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th style="padding: 12px 20px;">Staff Member</th>
                        <th style="padding: 12px 16px;">Department</th>
                        <th style="padding: 12px 16px;">Check-in Time</th>
                        <th style="padding: 12px 16px;">Geofence</th>
                        <th style="padding: 12px 16px;">Working Hours</th>
                        <th style="padding: 12px 20px; text-align: right;">Attendance Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($daily_roster)): foreach ($daily_roster as $r): 
                        $hasPunched = !empty($r['check_in_time']);
                        $status = $r['attendance_status'] ?: 'absent';
                        $statusBadge = ($status === 'present') ? '#10b981' : (($status === 'late') ? '#f59e0b' : '#ef4444');
                        $statusBg = ($status === 'present') ? '#ecfdf5' : (($status === 'late') ? '#fffbeb' : '#fef2f2');
                    ?>
                        <tr style="vertical-align: middle;">
                            <td style="padding: 14px 20px;">
                                <div style="font-weight: 700; font-size: 13.5px; color: #0f172a;"><?=html_escape($r['name']);?></div>
                                <small style="color: #64748b; font-family: monospace;"><?=$r['staff_code'];?> &bull; <?=strtoupper($r['role']);?></small>
                            </td>
                            <td style="padding: 14px 16px; color: #334155; font-size: 13px; font-weight: 600;">
                                <?=html_escape($r['department']);?>
                            </td>
                            <td style="padding: 14px 16px;">
                                <?php if ($hasPunched): ?>
                                    <strong style="color: #0284c7; font-size: 13px;"><?=date('h:i A', strtotime($r['check_in_time']));?></strong>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 12px;">--:--</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 14px 16px; font-size: 12.5px; color: #64748b;">
                                <?php if ($hasPunched): ?>
                                    <span style="color: #10b981;"><i class="fa fa-map-marker"></i> <?=number_format(floatval($r['distance_from_office_km']), 2);?> km</span>
                                <?php else: ?>
                                    --
                                <?php endif; ?>
                            </td>
                            <td style="padding: 14px 16px; font-size: 13px; font-weight: 700; color: #334155;">
                                <?=$r['working_hours'] ? number_format($r['working_hours'], 1) . ' hrs' : '-';?>
                            </td>
                            <td style="padding: 14px 20px; text-align: right;">
                                <span style="background: <?=$statusBg;?>; color: <?=$statusBadge;?>; border: 1px solid <?=$statusBadge;?>30; padding: 4px 10px; border-radius: 9999px; font-size: 11.5px; font-weight: 800; text-transform: uppercase;">
                                    <?=html_escape($status);?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="6" style="padding: 30px; text-align: center; color: #94a3b8;">
                                No attendance records logged today yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
