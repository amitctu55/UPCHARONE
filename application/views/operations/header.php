<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central Operations &amp; Expense Desk - Upchar</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('public/assets/css/bootstrap.min.css');?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        :root {
            --ops-teal: #00a896;
            --ops-indigo: #6366f1;
            --ops-navy: #0f172a;
            --ops-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--ops-bg);
            margin: 0;
            color: #1e293b;
        }

        .ops-layout-wrap {
            display: flex;
            min-height: 100vh;
        }

        .ops-sidebar {
            width: 260px;
            background: #0f172a;
            color: #ffffff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 0;
        }

        .ops-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #94a3b8;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .ops-nav a:hover, .ops-nav a.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
            border-left-color: var(--ops-indigo);
        }

        .ops-main-body {
            flex-grow: 1;
            padding: 28px 32px;
            overflow-x: hidden;
        }

        .ops-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>

<div class="ops-layout-wrap">
    <!-- Sidebar -->
    <aside class="ops-sidebar">
        <div>
            <div style="padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; gap: 10px;">
                <img src="<?=base_url('images/logo.png');?>" alt="Upchar" style="height: 32px;" onerror="this.style.display='none';">
                <div>
                    <strong style="font-size: 16px; color: #ffffff; display: block; line-height: 1.2;">Upchar Operations</strong>
                    <small style="color: #a5b4fc; font-size: 11px;">Central Logistics Desk</small>
                </div>
            </div>

            <div style="padding: 16px 20px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.06);">
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #6366f1; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px;">
                    <?=strtoupper(substr($this->session->userdata('staff_name') ?: 'O', 0, 1));?>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 13.5px; color: #ffffff; line-height: 1.2;">
                        <?=html_escape($this->session->userdata('staff_name') ?: 'Operations Desk');?>
                    </div>
                    <small style="color: #94a3b8; font-size: 11px;">Role: <?=html_escape($this->session->userdata('staff_role') ?: 'Staff');?></small>
                </div>
            </div>

            <nav class="ops-nav" style="margin-top: 14px;">
                <a href="<?=base_url('operations/dashboard');?>" class="<?=($this->uri->segment(2)=='dashboard' || empty($this->uri->segment(2))) ? 'active' : '';?>">
                    <i class="fa fa-tachometer" style="color: #38bdf8;"></i> Desk Overview
                </a>
                <a href="<?=base_url('operations/handoffs');?>" class="<?=($this->uri->segment(2)=='handoffs') ? 'active' : '';?>">
                    <i class="fa fa-flask" style="color: #a5b4fc;"></i> Sample Handoffs
                </a>
                <a href="<?=base_url('operations/expenses');?>" class="<?=($this->uri->segment(2)=='expenses') ? 'active' : '';?>">
                    <i class="fa fa-file-text-o" style="color: #34d399;"></i> Expense Desk
                </a>
                <a href="<?=base_url('attendance/punch');?>">
                    <i class="fa fa-clock-o" style="color: #fcd34d;"></i> Attendance Punch
                </a>
                <a href="<?=base_url('hr/dashboard');?>">
                    <i class="fa fa-users" style="color: #f472b6;"></i> HR Suite
                </a>
                <a href="<?=base_url('staff/logout');?>">
                    <i class="fa fa-sign-out" style="color: #f87171;"></i> Logout
                </a>
            </nav>
        </div>

        <div style="padding: 0 20px; font-size: 11px; color: #64748b;">
            Upchar Operations &copy; <?=date('Y');?>
        </div>
    </aside>

    <!-- Main Content Body -->
    <main class="ops-main-body">
