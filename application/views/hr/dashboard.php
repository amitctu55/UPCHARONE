<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            Workforce Command &amp; Attendance Dashboard
        </h2>
        <p style="margin: 0; font-size: 13.5px; color: #64748b;">
            Real-time staff geofenced attendance logs, active phlebotomists, and leave requests.
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="<?=base_url('hr/employees');?>" class="btn" style="background: var(--hr-teal); color: #fff; font-weight: 700; border-radius: 8px; padding: 9px 18px; font-size: 13px;">
            <i class="fa fa-user-plus"></i> Add Employee
        </a>
    </div>
</div>

<!-- Flash Alerts -->
<?php if ($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success" style="border-radius: 10px; font-size: 13.5px;">
        <i class="fa fa-check-circle"></i> <?=$this->session->flashdata('success_msg');?>
    </div>
<?php endif; ?>

<!-- KPI Metrics Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="hr-kpi-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Total Active Staff</div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?=$total_staff;?></div>
        <div style="font-size: 12px; color: #38bdf8; font-weight: 600; margin-top: 4px;">
            <i class="fa fa-users"></i> Across all departments
        </div>
    </div>

    <div class="hr-kpi-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Today Present</div>
        <div style="font-size: 26px; font-weight: 800; color: #16a34a; margin-top: 4px;"><?=$today_present;?></div>
        <div style="font-size: 12px; color: #16a34a; font-weight: 600; margin-top: 4px;">
            <i class="fa fa-check"></i> On time punches
        </div>
    </div>

    <div class="hr-kpi-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Late Marks Today</div>
        <div style="font-size: 26px; font-weight: 800; color: #d97706; margin-top: 4px;"><?=$today_late;?></div>
        <div style="font-size: 12px; color: #d97706; font-weight: 600; margin-top: 4px;">
            <i class="fa fa-clock-o"></i> Punched after 09:45 AM
        </div>
    </div>

    <div class="hr-kpi-card">
        <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Pending Leaves</div>
        <div style="font-size: 26px; font-weight: 800; color: #ec4899; margin-top: 4px;"><?=count($pending_leaves);?></div>
        <div style="font-size: 12px; color: #ec4899; font-weight: 600; margin-top: 4px;">
            <a href="<?=base_url('hr/leaves');?>" style="color: inherit;">Review Applications &rarr;</a>
        </div>
    </div>
</div>

<!-- Daily Attendance Roster Table -->
<div class="hr-kpi-card" style="padding: 24px; margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">
            <i class="fa fa-id-badge" style="color: var(--hr-teal); margin-right: 6px;"></i> Today's Live Attendance Roster (<?=date('d M Y');?>)
        </h4>
        <a href="<?=base_url('hr/payroll');?>" class="btn btn-xs btn-default" style="font-weight: 700; border-radius: 6px;">
            <i class="fa fa-calculator"></i> View Monthly Payroll
        </a>
    </div>

    <div class="table-responsive">
        <table class="table" style="margin: 0; vertical-align: middle;">
            <thead>
                <tr style="background: #f8fafc; font-size: 11.5px; color: #64748b; text-transform: uppercase;">
                    <th>Staff Name &amp; Role</th>
                    <th>Department</th>
                    <th>Check-in Time</th>
                    <th>Geofence Distance</th>
                    <th>Working Hours</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daily_roster)): ?>
                    <?php foreach ($daily_roster as $r): 
                        $hasPunched = !empty($r['check_in_time']);
                        $status = $r['attendance_status'] ?: 'absent';
                        $statusBadge = ($status === 'present') ? 'label-success' : (($status === 'late') ? 'label-warning' : 'label-danger');
                    ?>
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;"><?=html_escape($r['name']);?></div>
                            <small style="color: #64748b; font-family: monospace;"><?=$r['staff_code'];?> &bull; <?=strtoupper($r['role']);?></small>
                        </td>
                        <td style="color: #334155; font-size: 13px;"><?=html_escape($r['department']);?></td>
                        <td>
                            <?php if ($hasPunched): ?>
                                <strong style="color: #0284c7;"><?=date('h:i A', strtotime($r['check_in_time']));?></strong>
                            <?php else: ?>
                                <span style="color: #94a3b8;">--</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($hasPunched): ?>
                                <span style="font-size: 12px; font-weight: 600; color: <?=$r['distance_from_office_km'] <= 0.50 ? '#16a34a' : '#d97706';?>;">
                                    <i class="fa fa-map-marker"></i> <?=$r['distance_from_office_km'];?> km
                                </span>
                            <?php else: ?>
                                <span style="color: #94a3b8;">--</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight: 700; color: #1e293b;">
                            <?=$r['working_hours'] ? ($r['working_hours'] . ' hrs') : ($hasPunched ? 'In Progress' : '--');?>
                        </td>
                        <td>
                            <span class="label <?=$statusBadge;?>" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                <?=$status;?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
