<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile - Upchar Enterprise Portal</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('public/assets/css/bootstrap.min.css');?>">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0f172a; color: #f8fafc; margin: 0; padding: 24px; min-height: 100vh; }
        .profile-card { background: #1e293b; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08); padding: 28px; max-width: 650px; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .badge-role { background: #00a896; color: #fff; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; }
        .info-row { display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.06); padding: 12px 0; font-size: 13.5px; }
        .info-label { color: #94a3b8; font-weight: 600; }
        .info-val { color: #f8fafc; font-weight: 700; }
        .btn-portal { background: linear-gradient(135deg, #00a896 0%, #0284c7 100%); color: #fff; font-weight: 700; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>

<div class="profile-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="<?=base_url('staff/dashboard');?>" style="color: #94a3b8; text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left"></i> My Portal
        </a>
        <a href="<?=base_url('staff/logout');?>" style="color: #ef4444; text-decoration: none; font-size: 13px; font-weight: 700;">
            <i class="fa fa-sign-out"></i> Logout
        </a>
    </div>

    <div style="text-align: center; margin-bottom: 24px;">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: #00a896; color: #fff; font-size: 32px; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; box-shadow: 0 4px 15px rgba(0,168,150,0.4);">
            <?=strtoupper(substr($user['name'], 0, 1));?>
        </div>
        <h2 style="font-size: 20px; font-weight: 800; margin: 0 0 6px;"><?=html_escape($user['name']);?></h2>
        <span class="badge-role"><?=strtoupper($user['role']);?></span>
    </div>

    <div style="margin-bottom: 24px;">
        <div class="info-row">
            <span class="info-label">Staff Code</span>
            <span class="info-val"><?=html_escape($user['staff_code']);?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Official Email</span>
            <span class="info-val"><?=html_escape($user['email']);?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone Number</span>
            <span class="info-val"><?=html_escape($user['phone']);?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Department</span>
            <span class="info-val"><?=html_escape($user['department']);?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Designation</span>
            <span class="info-val"><?=html_escape($user['designation']);?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Assigned Hub / Territory</span>
            <span class="info-val"><?=html_escape($user['assigned_area']);?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Account Status</span>
            <span class="info-val" style="color: #34d399;"><?=strtoupper($user['status']);?></span>
        </div>
    </div>

    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
        <a href="<?=base_url('attendance/punch');?>" class="btn-portal">
            <i class="fa fa-camera"></i> Punch Attendance
        </a>
        <a href="<?=base_url('staff/dashboard');?>" class="btn-portal" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);">
            <i class="fa fa-tachometer"></i> Go to Dashboard
        </a>
    </div>
</div>

</body>
</html>
