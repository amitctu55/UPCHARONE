<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR &amp; Staff Management Portal - Upchar</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('public/assets/css/bootstrap.min.css');?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        :root {
            --hr-teal: #00a896;
            --hr-navy: #0f172a;
            --hr-slate: #1e293b;
            --hr-bg: #f8fafc;
            --hr-pink: #ec4899;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--hr-bg);
            margin: 0;
            color: #1e293b;
        }

        .hr-layout-wrap {
            display: flex;
            min-height: 100vh;
        }

        .hr-sidebar {
            width: 260px;
            background: #0f172a;
            color: #ffffff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 0;
        }

        .hr-nav a {
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
        .hr-nav a:hover, .hr-nav a.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
            border-left-color: var(--hr-teal);
        }

        .hr-main-body {
            flex-grow: 1;
            padding: 28px 32px;
            overflow-x: hidden;
        }

        .hr-kpi-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>

<div class="hr-layout-wrap">
    <!-- Sidebar -->
    <aside class="hr-sidebar">
        <div>
            <div style="padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; gap: 10px;">
                <img src="<?=base_url('images/logo.png');?>" alt="Upchar" style="height: 32px;" onerror="this.style.display='none';">
                <div>
                    <strong style="font-size: 16px; color: #ffffff; display: block; line-height: 1.2;">Upchar HR</strong>
                    <small style="color: #2dd4bf; font-size: 11px;">Staff &amp; Payroll Suite</small>
                </div>
            </div>

            <div style="padding: 16px 20px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.06);">
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #ec4899; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px;">
                    <?=strtoupper(substr($this->session->userdata('staff_name') ?: 'H', 0, 1));?>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 13.5px; color: #ffffff; line-height: 1.2;">
                        <?=html_escape($this->session->userdata('staff_name') ?: 'HR Lead');?>
                    </div>
                    <small style="color: #94a3b8; font-size: 11px;"><?=html_escape($this->session->userdata('staff_role') ?: 'HR Manager');?></small>
                </div>
            </div>

            <nav class="hr-nav" style="margin-top: 14px;">
                <a href="<?=base_url('hr/dashboard');?>" class="<?=($this->uri->segment(2)=='dashboard' || empty($this->uri->segment(2))) ? 'active' : '';?>">
                    <i class="fa fa-th-large" style="color: #38bdf8;"></i> HR Dashboard
                </a>
                <a href="<?=base_url('hr/employees');?>" class="<?=($this->uri->segment(2)=='employees') ? 'active' : '';?>">
                    <i class="fa fa-users" style="color: #34d399;"></i> Employee Directory
                </a>
                <a href="<?=base_url('hr/leaves');?>" class="<?=($this->uri->segment(2)=='leaves') ? 'active' : '';?>">
                    <i class="fa fa-calendar-check-o" style="color: #f472b6;"></i> Leave Management
                </a>
                <a href="<?=base_url('hr/payroll');?>" class="<?=($this->uri->segment(2)=='payroll') ? 'active' : '';?>">
                    <i class="fa fa-calculator" style="color: #fcd34d;"></i> Payroll &amp; Salaries
                </a>
                <a href="<?=base_url('crm/dashboard');?>">
                    <i class="fa fa-briefcase" style="color: #a78bfa;"></i> BDE CRM Portal
                </a>
                <a href="<?=base_url('operations/dashboard');?>">
                    <i class="fa fa-flask" style="color: #fb923c;"></i> Central Operations
                </a>
                <a href="<?=base_url('staff/logout');?>">
                    <i class="fa fa-sign-out" style="color: #f87171;"></i> Logout
                </a>
            </nav>
        </div>

        <div style="padding: 0 20px; font-size: 11px; color: #64748b;">
            Upchar Workforce Engine &copy; <?=date('Y');?>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="hr-main-body">
