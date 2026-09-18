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
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css');?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
            width: 270px;
            background: #0f172a;
            color: #ffffff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 0;
            position: sticky;
            top: 0;
            max-height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .ops-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .ops-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }

        .ops-nav-heading {
            font-size: 10.5px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 16px 20px 6px;
        }

        .ops-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: #94a3b8;
            font-size: 13px;
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
            padding: 24px 32px 40px;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .ops-suite-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            color: #475569;
            text-decoration: none !important;
            transition: all 0.15s ease;
            white-space: nowrap;
        }
        .ops-suite-tab:hover {
            color: #0f172a;
            background: rgba(255, 255, 255, 0.7);
        }
        .ops-suite-tab.active {
            background: #0f172a !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.15);
        }

        .ops-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .ops-kpi-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 18px 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .ops-kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
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
                    <strong style="font-size: 15px; color: #ffffff; display: block; line-height: 1.2;">Upchar Enterprise</strong>
                    <small style="color: #a5b4fc; font-size: 11px;">Operations &amp; Logistics</small>
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

            <?php
            $seg1 = ($this->uri->segment(1) === 'admin1947') ? $this->uri->segment(2) : $this->uri->segment(1);
            $seg2 = ($this->uri->segment(1) === 'admin1947') ? $this->uri->segment(3) : $this->uri->segment(2);
            ?>
            <nav class="ops-nav" style="margin-top: 10px;">
                <div class="ops-nav-heading">Central Operations</div>
                <a href="<?=base_url('admin1947/operations');?>" class="<?=($seg1=='operations' && (empty($seg2) || $seg2=='dashboard')) ? 'active' : '';?>">
                    <i class="fa fa-tachometer" style="color: #60a5fa;"></i> Operations Hub
                </a>
                <a href="<?=base_url('admin1947/operations/handoffs');?>" class="<?=($seg1=='operations' && $seg2=='handoffs') ? 'active' : '';?>">
                    <i class="fa fa-flask" style="color: #fb923c;"></i> Lab / Shift Handoffs
                </a>
                <a href="<?=base_url('admin1947/operations/expenses');?>" class="<?=($seg1=='operations' && $seg2=='expenses') ? 'active' : '';?>">
                    <i class="fa fa-credit-card" style="color: #4ade80;"></i> Expense Desk
                </a>

                <div class="ops-nav-heading">HR &amp; Recruitment</div>
                <a href="<?=base_url('admin1947/hr/dashboard');?>" class="<?=($seg1=='hr' && ($seg2=='dashboard' || empty($seg2))) ? 'active' : '';?>">
                    <i class="fa fa-th-large" style="color: #38bdf8;"></i> HR Command Hub
                </a>
                <a href="<?=base_url('admin1947/hr/jobs');?>" class="<?=($seg1=='hr' && $seg2=='jobs') ? 'active' : '';?>">
                    <i class="fa fa-id-badge" style="color: #6366f1;"></i> Job Requisitions
                </a>
                <a href="<?=base_url('admin1947/hr/candidates');?>" class="<?=($seg1=='hr' && in_array($seg2, ['candidates', 'candidate_profile'])) ? 'active' : '';?>">
                    <i class="fa fa-filter" style="color: #ec4899;"></i> Candidate Pipeline
                </a>
                <a href="<?=base_url('admin1947/hr/directory');?>" class="<?=($seg1=='hr' && in_array($seg2, ['directory', 'employees'])) ? 'active' : '';?>">
                    <i class="fa fa-users" style="color: #34d399;"></i> Staff Directory
                </a>

                <div class="ops-nav-heading">Time &amp; Payroll</div>
                <a href="<?=base_url('admin1947/attendance/roster');?>" class="<?=(($seg1=='attendance' && $seg2=='roster') || ($seg1=='hr' && $seg2=='attendance')) ? 'active' : '';?>">
                    <i class="fa fa-calendar-check-o" style="color: #f59e0b;"></i> Attendance Roster
                </a>
                <a href="<?=base_url('admin1947/attendance/punch');?>" class="<?=($seg1=='attendance' && in_array($seg2, ['punch', 'history'])) ? 'active' : '';?>">
                    <i class="fa fa-clock-o" style="color: #ec4899;"></i> Web Punch-In / Out
                </a>
                <a href="<?=base_url('admin1947/hr/leaves');?>" class="<?=($seg1=='hr' && $seg2=='leaves') ? 'active' : '';?>">
                    <i class="fa fa-file-text-o" style="color: #a855f7;"></i> Leave Approvals
                </a>
                <a href="<?=base_url('admin1947/hr/payroll');?>" class="<?=($seg1=='hr' && $seg2=='payroll') ? 'active' : '';?>">
                    <i class="fa fa-calculator" style="color: #fcd34d;"></i> Payroll &amp; Salaries
                </a>

                <div class="ops-nav-heading">CRM &amp; Growth</div>
                <a href="<?=base_url('admin1947/crm');?>" class="<?=($seg1=='crm' && (empty($seg2) || $seg2=='dashboard')) ? 'active' : '';?>">
                    <i class="fa fa-line-chart" style="color: #f59e0b;"></i> CRM Command Hub
                </a>
                <a href="<?=base_url('admin1947/crm/leads');?>" class="<?=($seg1=='crm' && $seg2=='leads') ? 'active' : '';?>">
                    <i class="fa fa-columns" style="color: #fbbf24;"></i> Leads &amp; Pipeline
                </a>
                <a href="<?=base_url('admin1947/crm/contacts');?>" class="<?=($seg1=='crm' && $seg2=='contacts') ? 'active' : '';?>">
                    <i class="fa fa-address-book" style="color: #38bdf8;"></i> Partner Directory
                </a>
                <a href="<?=base_url('admin1947/crm/activities');?>" class="<?=($seg1=='crm' && $seg2=='activities') ? 'active' : '';?>">
                    <i class="fa fa-phone-square" style="color: #34d399;"></i> Activity &amp; Follow-ups
                </a>

                <div class="ops-nav-heading">Account</div>
                <a href="<?=base_url('admin1947/login/logout');?>">
                    <i class="fa fa-sign-out" style="color: #f87171;"></i> Logout
                </a>
            </nav>
        </div>

        <div class="ops-sidebar-footer">
            Upchar Operations &copy; <?=date('Y');?>
        </div>
    </aside>

    <!-- Main Content Container -->
    <main class="ops-main">
        <!-- Unified Central Operations & Logistics Suite Segmented Header Navigation -->
        <div class="ops-suite-header">
            <!-- Left Branding & Indicator -->
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #0f172a 0%, #6366f1 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 17px; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.25);">
                    <i class="fa fa-tachometer"></i>
                </div>
                <div>
                    <div style="font-size: 10.5px; font-weight: 800; color: #6366f1; text-transform: uppercase; letter-spacing: 0.6px; line-height: 1;">
                        Upchar Enterprise Logistics
                    </div>
                    <strong style="font-size: 15.5px; font-weight: 800; color: #0f172a;">
                        Central Operations &amp; Expense Suite
                    </strong>
                </div>
            </div>

            <!-- Right Connected Segmented Pills -->
            <div style="display: inline-flex; background: #f1f5f9; padding: 4px; border-radius: 12px; border: 1px solid #e2e8f0; gap: 4px; overflow-x: auto; max-width: 100%;">
                <a href="<?=base_url('admin1947/operations');?>" class="ops-suite-tab <?=($seg1=='operations' && (empty($seg2) || $seg2=='dashboard')) ? 'active' : '';?>">
                    <i class="fa fa-tachometer" style="color: #60a5fa;"></i> Operations Hub
                </a>
                <a href="<?=base_url('admin1947/operations/handoffs');?>" class="ops-suite-tab <?=($seg1=='operations' && $seg2=='handoffs') ? 'active' : '';?>">
                    <i class="fa fa-flask" style="color: #fb923c;"></i> Lab Sample Handoffs
                </a>
                <a href="<?=base_url('admin1947/operations/expenses');?>" class="ops-suite-tab <?=($seg1=='operations' && $seg2=='expenses') ? 'active' : '';?>">
                    <i class="fa fa-credit-card" style="color: #4ade80;"></i> Expense Desk
                </a>
                <a href="<?=base_url('admin1947/attendance/roster');?>" class="ops-suite-tab">
                    <i class="fa fa-calendar-check-o" style="color: #f59e0b;"></i> Attendance Roster
                </a>
                <a href="<?=base_url('admin1947/hr/directory');?>" class="ops-suite-tab">
                    <i class="fa fa-users" style="color: #00a896;"></i> Staff Directory
                </a>
            </div>
        </div>
