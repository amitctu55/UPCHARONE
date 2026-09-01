<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-6 col-12">
        <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">
            <i class="fa fa-calendar-check-o" style="color: #00a896;"></i> Daily Attendance Roster
        </h3>
        <p style="font-size: 13px; color: #64748b; margin: 0;">
            Live GPS punch-in &amp; working hours log for all on-field and in-office staff.
        </p>
    </div>
    <div class="col-md-6 col-12" style="text-align: right;">
        <form method="GET" action="<?=base_url('hr/attendance');?>" style="display: inline-flex; gap: 8px;">
            <input type="date" name="date" class="form-control" value="<?=$selected_date;?>" style="height: 38px; border-radius: 8px; font-size: 13px;">
            <button type="submit" class="btn-hr-primary">
                <i class="fa fa-filter"></i> Filter Date
            </button>
        </form>
    </div>
</div>

<div class="hr-table-card">
    <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">
            Roster for <?=date('D, d M Y', strtotime($selected_date));?> (<?=count($daily_roster);?> Employees)
        </h4>
        <a href="<?=base_url('hr/payroll');?>" style="color: #00a896; font-size: 12.5px; font-weight: 700; text-decoration: none;">
            <i class="fa fa-calculator"></i> View Monthly Payroll &rarr;
        </a>
    </div>

    <table class="table hr-table" style="margin: 0;">
        <thead>
            <tr>
                <th>Staff Code &amp; Name</th>
                <th>Role &amp; Department</th>
                <th>Check-in Time</th>
                <th>Check-out Time</th>
                <th>GPS Geofence</th>
                <th>Total Hours</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($daily_roster)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">
                        No employee records found for this date.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach($daily_roster as $row): ?>
                    <tr>
                        <td>
                            <strong style="color: #0f172a; display: block; font-size: 13.5px;">
                                <?=html_escape($row['name']);?>
                            </strong>
                            <span style="font-size: 11.5px; color: #64748b;">
                                <?=html_escape($row['staff_code']);?> &bull; <?=html_escape($row['phone']);?>
                            </span>
                        </td>
                        <td>
                            <span class="badge-role badge-role-<?=strtolower($row['role']);?>">
                                <?=strtoupper($row['role']);?>
                            </span>
                            <span style="display: block; font-size: 11.5px; color: #64748b; margin-top: 3px;">
                                <?=html_escape($row['department']);?>
                            </span>
                        </td>
                        <td>
                            <?php if(!empty($row['check_in_time'])): ?>
                                <strong style="color: #0f172a;"><?=date('h:i A', strtotime($row['check_in_time']));?></strong>
                            <?php else: ?>
                                <span style="color: #94a3b8;">--:--</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($row['check_out_time'])): ?>
                                <strong style="color: #0f172a;"><?=date('h:i A', strtotime($row['check_out_time']));?></strong>
                            <?php else: ?>
                                <span style="color: #94a3b8;">--:--</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($row['check_in_time'])): ?>
                                <span style="font-size: 12px; font-weight: 600; color: <?=floatval($row['distance_from_office_km']) <= 0.5 ? '#16a34a' : '#d97706';?>;">
                                    <i class="fa fa-map-marker"></i> <?=number_format($row['distance_from_office_km'], 2);?> km from Hub
                                </span>
                            <?php else: ?>
                                <span style="color: #94a3b8;">Not Recorded</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?=floatval($row['working_hours']);?> hrs</strong>
                        </td>
                        <td>
                            <?php
                            $st = $row['attendance_status'] ?: 'absent';
                            $badgeStyle = 'background: #f1f5f9; color: #64748b;';
                            if ($st === 'present') $badgeStyle = 'background: #dcfce7; color: #166534;';
                            elseif ($st === 'late') $badgeStyle = 'background: #fef3c7; color: #92400e;';
                            elseif ($st === 'half_day') $badgeStyle = 'background: #fed7aa; color: #9a3412;';
                            elseif ($st === 'absent') $badgeStyle = 'background: #fee2e2; color: #991b1b;';
                            ?>
                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; <?=$badgeStyle;?>">
                                <?=strtoupper(str_replace('_', ' ', $st));?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
