<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
// Calculate monthly stats
$totalDays  = count($logs ?? []);
$present    = 0; $late = 0; $absent = 0; $totalHrs = 0;
foreach ($logs ?? [] as $l) {
    if ($l['status'] === 'present') $present++;
    elseif ($l['status'] === 'late') $late++;
    else $absent++;
    $totalHrs += floatval($l['working_hours'] ?? 0);
}
$monthName = date('F Y', mktime(0, 0, 0, intval($month), 10, intval($year)));
?>

<style>
    .history-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .hist-kpi {
        background: #ffffff; border-radius: 14px; padding: 18px 20px;
        border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex; align-items: center; justify-content: space-between;
    }
    .hist-kpi-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }

    .hist-table th { padding: 12px 18px; font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; background: #f8fafc; }
    .hist-table td { padding: 14px 18px; font-size: 13px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .hist-table tbody tr:hover { background: #fafbfc; }

    .status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 800; text-transform: uppercase;
    }
    .pill-present { background: #ecfdf5; color: #059669; }
    .pill-late    { background: #fffbeb; color: #d97706; }
    .pill-absent  { background: #fef2f2; color: #dc2626; }
</style>

<div style="max-width: 1100px; margin: 0 auto;">

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(99,102,241,0.1); color: #6366f1; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                <i class="fa fa-history"></i> Monthly Attendance Log
            </div>
            <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.3px;">
                <?=html_escape(@$user['name'] ?: 'Staff');?> — Attendance History
            </h2>
            <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                Biometric punch log for <strong><?=$monthName;?></strong>
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <!-- Month Navigator -->
            <form method="GET" action="<?=base_url('attendance/history');?>" style="display: inline-flex; align-items: center; gap: 8px;">
                <select name="month" class="form-control form-control-sm" style="border-radius: 8px; font-weight: 600; width: auto;">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?=$m;?>" <?=($m == intval($month)) ? 'selected' : '';?>>
                            <?=date('F', mktime(0,0,0,$m,10));?>
                        </option>
                    <?php endfor; ?>
                </select>
                <select name="year" class="form-control form-control-sm" style="border-radius: 8px; font-weight: 600; width: auto;">
                    <?php for ($y = date('Y'); $y >= date('Y') - 2; $y--): ?>
                        <option value="<?=$y;?>" <?=($y == intval($year)) ? 'selected' : '';?>><?=$y;?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-sm" style="background: #0f172a; color: #fff; font-weight: 700; border-radius: 8px; padding: 5px 14px;">
                    <i class="fa fa-search"></i> Go
                </button>
            </form>
            <a href="<?=base_url('attendance/punch');?>" class="btn btn-sm" style="background: #00a896; color: #fff; font-weight: 700; border: none; border-radius: 10px; padding: 7px 16px; font-size: 13px; box-shadow: 0 4px 12px rgba(0,168,150,0.3);">
                <i class="fa fa-camera"></i> Punch In/Out
            </a>
        </div>
    </div>

    <!-- KPI Summary Strip -->
    <div class="history-grid">
        <div class="hist-kpi">
            <div>
                <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px;">Total Days</div>
                <div style="font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 3px;"><?=$totalDays;?></div>
                <small style="color: #94a3b8; font-size: 11.5px;">Punched this month</small>
            </div>
            <div class="hist-kpi-icon" style="background: #eff6ff; color: #3b82f6;"><i class="fa fa-calendar"></i></div>
        </div>
        <div class="hist-kpi">
            <div>
                <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px;">Present</div>
                <div style="font-size: 28px; font-weight: 800; color: #10b981; margin-top: 3px;"><?=$present;?></div>
                <small style="color: #94a3b8; font-size: 11.5px;">On-time check-ins</small>
            </div>
            <div class="hist-kpi-icon" style="background: #ecfdf5; color: #10b981;"><i class="fa fa-check-circle"></i></div>
        </div>
        <div class="hist-kpi">
            <div>
                <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px;">Late Marks</div>
                <div style="font-size: 28px; font-weight: 800; color: #d97706; margin-top: 3px;"><?=$late;?></div>
                <small style="color: #94a3b8; font-size: 11.5px;">After shift start</small>
            </div>
            <div class="hist-kpi-icon" style="background: #fffbeb; color: #d97706;"><i class="fa fa-clock-o"></i></div>
        </div>
        <div class="hist-kpi">
            <div>
                <div style="font-size: 11.5px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.4px;">Total Hours</div>
                <div style="font-size: 28px; font-weight: 800; color: #6366f1; margin-top: 3px;"><?=number_format($totalHrs, 1);?></div>
                <small style="color: #94a3b8; font-size: 11.5px;">Working hours logged</small>
            </div>
            <div class="hist-kpi-icon" style="background: #eef2ff; color: #6366f1;"><i class="fa fa-bar-chart"></i></div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.03); overflow: hidden;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                <i class="fa fa-id-badge" style="color: #00a896; margin-right: 6px;"></i>
                Punch Log — <?=$monthName;?>
            </h3>
            <span style="background: #f1f5f9; color: #475569; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                <?=$totalDays;?> Records
            </span>
        </div>

        <div class="table-responsive">
            <table class="table hist-table" style="margin: 0;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Working Hours</th>
                        <th>GPS Distance</th>
                        <th style="text-align: right;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $l):
                            $s = $l['status'] ?: 'absent';
                            $pClass = ($s === 'present') ? 'pill-present' : (($s === 'late') ? 'pill-late' : 'pill-absent');
                        ?>
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;">
                                    <?=date('d M Y', strtotime($l['punch_date']));?>
                                </div>
                                <small style="color: #94a3b8;"><?=date('l', strtotime($l['punch_date']));?></small>
                            </td>
                            <td style="font-weight: 700; color: #0284c7;">
                                <?=!empty($l['check_in_time']) ? date('h:i A', strtotime($l['check_in_time'])) : '<span style="color:#94a3b8;">--:--</span>';?>
                            </td>
                            <td style="color: #475569;">
                                <?=!empty($l['check_out_time']) ? date('h:i A', strtotime($l['check_out_time'])) : '<span style="color:#94a3b8;">--</span>';?>
                            </td>
                            <td style="font-weight: 700; color: #334155;">
                                <?=!empty($l['working_hours']) ? $l['working_hours'] . ' hrs' : '--';?>
                            </td>
                            <td style="color: #64748b; font-size: 12.5px;">
                                <?=!empty($l['distance_from_office_km']) ? '<i class="fa fa-map-marker" style="color:#10b981;"></i> ' . number_format(floatval($l['distance_from_office_km']), 2) . ' km' : '--';?>
                            </td>
                            <td style="text-align: right;">
                                <span class="status-pill <?=$pClass;?>">
                                    <?=ucfirst($s);?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 50px; text-align: center; color: #94a3b8;">
                                <i class="fa fa-calendar-o" style="font-size: 40px; display: block; margin-bottom: 12px; opacity: .4;"></i>
                                No attendance records for <?=$monthName;?>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
