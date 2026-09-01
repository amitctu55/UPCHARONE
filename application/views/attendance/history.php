<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance History - Upchar</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('public/assets/css/bootstrap.min.css');?>">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            color: #0f172a;
            margin: 0;
            padding: 24px 16px;
        }
        .history-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            max-width: 700px;
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .log-table th {
            background: #f8fafc;
            font-size: 11.5px;
            color: #64748b;
            text-transform: uppercase;
            padding: 10px;
        }
        .log-table td {
            padding: 12px 10px;
            font-size: 13px;
            border-bottom: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

<div class="history-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <a href="<?=base_url('attendance/punch');?>" style="font-size: 12.5px; color: #00a896; text-decoration: none; font-weight: 700;">
                <i class="fa fa-arrow-left"></i> Back to Punch
            </a>
            <h4 style="margin: 6px 0 0; font-size: 18px; font-weight: 800; color: #0f172a;">
                Monthly Attendance Log
            </h4>
        </div>
        <div>
            <span class="badge" style="background: #00a896; padding: 6px 12px; font-size: 12px;">
                <?=date('F Y', mktime(0, 0, 0, $month, 10, $year));?>
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table log-table" style="margin: 0;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                    <th>Working Hrs</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $l): 
                        $badgeClass = ($l['status'] === 'present') ? 'success' : (($l['status'] === 'late') ? 'warning' : 'danger');
                    ?>
                    <tr>
                        <td style="font-weight: 700; color: #1e293b;">
                            <?=date('d M Y, D', strtotime($l['punch_date']));?>
                        </td>
                        <td style="color: #0284c7; font-weight: 600;">
                            <?=date('h:i A', strtotime($l['check_in_time']));?>
                        </td>
                        <td style="color: #64748b;">
                            <?=$l['check_out_time'] ? date('h:i A', strtotime($l['check_out_time'])) : '--';?>
                        </td>
                        <td style="font-weight: 700;">
                            <?=$l['working_hours'] ? ($l['working_hours'] . ' hrs') : '--';?>
                        </td>
                        <td>
                            <span class="label label-<?=$badgeClass;?>" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                <?=$l['status'];?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No attendance punches recorded for this month.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
