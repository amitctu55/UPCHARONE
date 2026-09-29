<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$staffName = $CI->session->userdata('staff_name') ?: $CI->session->userdata('username') ?: 'Central Desk';
$staffRole = $CI->session->userdata('staff_role') ?: 'Administrator';
$seg1 = ($CI->uri->segment(1) === 'admin1947') ? $CI->uri->segment(2) : $CI->uri->segment(1);
$seg2 = ($CI->uri->segment(1) === 'admin1947') ? $CI->uri->segment(3) : $CI->uri->segment(2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central Operations &amp; Expense Suite &bull; Upchar Enterprise</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    
    <!-- Modern Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome & Bootstrap Grid -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css');?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        :root {
            --ops-primary: #6366f1;
            --ops-primary-dark: #4f46e5;
            --ops-primary-glow: rgba(99, 102, 241, 0.25);
            --ops-teal: #00a896;
            --ops-teal-dark: #028072;
            --ops-navy: #ffffffff;
            --ops-navy-card: #ffffffff;
            --ops-navy-hover: #ffffffff;
            --ops-border-dark: rgba(255, 255, 255, 0.08);
            --ops-bg: #f8fafc;
            --ops-surface: #ffffff;
            --ops-slate-200: #e2e8f0;
            --ops-slate-300: #cbd5e1;
            --ops-slate-600: #475569;
            --ops-slate-800: #ffffffff;
            --ops-slate-900: #ffffffff;
            --font-head: 'Outfit', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-body: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            font-family: var(--font-body);
            background: var(--ops-bg);
            margin: 0;
            color: #ffffffff;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6, .ops-font-head {
            font-family: var(--font-head);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .ops-layout-wrap {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* SIDEBAR (ENTERPRISE GRADE DARK) */
        .ops-sidebar {
            width: 280px;
            background: linear-gradient(180deg, #ffffffff 0%, #ffffffff 100%);
            color: #ffffff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: sticky;
            top: 0;
            max-height: 100vh;
            overflow-y: auto;
            border-right: 1px solid var(--ops-border-dark);
            z-index: 1050;
            transition: transform 0.3s ease;
        }

        .ops-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .ops-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 4px;
        }

        .ops-sidebar-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid var(--ops-border-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ops-brand-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ops-brand-logo {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
        }

        .ops-brand-title {
            font-size: 15px;
            font-weight: 800;
            color: #ffffff;
            display: block;
            line-height: 1.2;
            font-family: var(--font-head);
        }

        .ops-brand-subtitle {
            color: #818cf8;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .ops-node-badge {
            font-size: 10.5px;
            font-weight: 700;
            color: #34d399;
            background: rgba(16, 185, 129, 0.12);
            padding: 2px 8px;
            border-radius: 999px;
            border: 1px solid rgba(52, 211, 153, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .ops-user-card {
            margin: 14px 16px 8px;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--ops-border-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ops-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #00a896);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            flex-shrink: 0;
        }

        .ops-avatar-online {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid #ffffffff;
        }

        .ops-nav-heading {
            font-size: 10px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 18px 20px 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ops-nav a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 18px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.18s ease;
            border-left: 3px solid transparent;
            margin: 2px 8px;
            border-radius: 8px;
        }

        .ops-nav a .nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ops-nav a .nav-left i {
            width: 16px;
            text-align: center;
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .ops-nav a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(2px);
        }

        .ops-nav a:hover .nav-left i {
            transform: scale(1.15);
        }

        .ops-nav a.active {
            color: #ffffff !important;
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.05) 100%) !important;
            border-left: 3px solid var(--ops-primary);
            font-weight: 700;
        }

        .ops-nav a.active .nav-left i {
            color: #a5b4fc !important;
        }

        .ops-pill-count {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
        }

        .ops-pill-count.pulse {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .ops-sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--ops-border-dark);
            font-size: 11.5px;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* MAIN BODY WRAPPER */
        .ops-main {
            flex-grow: 1;
            min-height: 100vh;
            background: var(--ops-bg);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* SUITE HEADER & NAVIGATION BAR */
        .ops-suite-header {
            background: #ffffff;
            border-bottom: 1px solid var(--ops-slate-200);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
            flex-wrap: wrap;
            gap: 16px;
        }

        .ops-suite-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            color: #475569;
            text-decoration: none !important;
            transition: all 0.15s ease;
            white-space: nowrap;
        }
        .ops-suite-tab:hover {
            color: #0f172a;
            background: rgba(255, 255, 255, 0.8);
        }
        .ops-suite-tab.active {
            background: #0f172a !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }
        .ops-suite-tab.active i {
            color: #ffffff !important;
        }

        /* CONTENT CONTAINER */
        .ops-main-body {
            flex-grow: 1;
            padding: 28px 32px 48px;
            max-width: 1560px;
            width: 100%;
            margin: 0 auto;
        }

        /* MOBILE DRAWER TOGGLE */
        .ops-mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: #0f172a;
            cursor: pointer;
            padding: 6px 10px;
        }

        @media (max-width: 991px) {
            .ops-sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                height: 100vh;
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.3);
            }
            .ops-sidebar.open {
                transform: translateX(280px);
            }
            .ops-mobile-toggle {
                display: block;
            }
            .ops-suite-header {
                padding: 12px 18px;
            }
            .ops-main-body {
                padding: 18px 16px 40px;
            }
        }
    </style>
</head>
<body>

<div class="ops-layout-wrap">

    <!-- SIDEBAR -->
    <aside class="ops-sidebar" id="opsSidebar">
        <div>
            <!-- Header & Brand -->
            <div class="ops-sidebar-brand">
                <div class="ops-brand-meta">
                    <div class="ops-brand-logo">
                        <i class="fa fa-heartbeat"></i>
                    </div>
                    <div>
                        <span class="ops-brand-title">Upchar Enterprise</span>
                        <span class="ops-brand-subtitle">Operations Suite</span>
                    </div>
                </div>
                <span class="ops-node-badge">
                    <i class="fa fa-circle" style="font-size: 6px;"></i> Live
                </span>
            </div>

            <!-- Logged-in Staff Quick Card -->
            <div class="ops-user-card">
                <div class="ops-avatar">
                    <?=strtoupper(substr($staffName, 0, 1));?>
                    <span class="ops-avatar-online"></span>
                </div>
                <div style="flex-grow: 1; min-width: 0;">
                    <div style="font-weight: 700; font-size: 13px; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?=html_escape($staffName);?>
                    </div>
                    <small style="color: #94a3b8; font-size: 11px; display: block;">
                        <?=html_escape(ucwords(str_replace('_', ' ', $staffRole)));?>
                    </small>
                </div>
            </div>

            <!-- SIDEBAR NAVIGATION MENU -->
            <nav class="ops-nav">
                
                <!-- 1. Central Operations -->
                <div class="ops-nav-heading">
                    <span>Central Operations</span>
                    <i class="fa fa-cogs" style="font-size: 10px;"></i>
                </div>
                <a href="<?=base_url('admin1947/operations');?>" class="<?=($seg1=='operations' && (empty($seg2) || $seg2=='dashboard')) ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-tachometer" style="color: #60a5fa;"></i> Operations Hub</span>
                </a>
                <a href="<?=base_url('admin1947/operations/handoffs');?>" class="<?=($seg1=='operations' && $seg2=='handoffs') ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-flask" style="color: #fb923c;"></i> Lab / Shift Handoffs</span>
                </a>
                <a href="<?=base_url('admin1947/operations/expenses');?>" class="<?=($seg1=='operations' && $seg2=='expenses') ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-credit-card" style="color: #4ade80;"></i> Expense Desk</span>
                </a>

                <!-- 2. HR & Recruitment -->
                <div class="ops-nav-heading">
                    <span>HR &amp; Recruitment</span>
                    <i class="fa fa-users" style="font-size: 10px;"></i>
                </div>
                <a href="<?=base_url('admin1947/hr/dashboard');?>" class="<?=($seg1=='hr' && ($seg2=='dashboard' || empty($seg2))) ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-th-large" style="color: #38bdf8;"></i> HR Command Hub</span>
                </a>
                <a href="<?=base_url('admin1947/hr/jobs');?>" class="<?=($seg1=='hr' && $seg2=='jobs') ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-id-badge" style="color: #818cf8;"></i> Job Requisitions</span>
                </a>
                <a href="<?=base_url('admin1947/hr/candidates');?>" class="<?=($seg1=='hr' && in_array($seg2, ['candidates', 'candidate_profile'])) ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-filter" style="color: #ec4899;"></i> Candidate Pipeline</span>
                </a>
                <a href="<?=base_url('admin1947/hr/directory');?>" class="<?=($seg1=='hr' && in_array($seg2, ['directory', 'employees'])) ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-address-book" style="color: #34d399;"></i> Staff Directory</span>
                </a>

                <!-- 3. Time & Payroll -->
                <div class="ops-nav-heading">
                    <span>Time &amp; Payroll</span>
                    <i class="fa fa-clock-o" style="font-size: 10px;"></i>
                </div>
                <a href="<?=base_url('admin1947/attendance/roster');?>" class="<?=(($seg1=='attendance' && $seg2=='roster') || ($seg1=='hr' && $seg2=='attendance')) ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-calendar-check-o" style="color: #f59e0b;"></i> Attendance Roster</span>
                </a>
                <a href="<?=base_url('admin1947/attendance/punch');?>" class="<?=($seg1=='attendance' && in_array($seg2, ['punch', 'history'])) ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-clock-o" style="color: #ec4899;"></i> Web Punch-In / Out</span>
                </a>
                <a href="<?=base_url('admin1947/hr/leaves');?>" class="<?=($seg1=='hr' && $seg2=='leaves') ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-file-text-o" style="color: #a855f7;"></i> Leave Approvals</span>
                </a>
                <a href="<?=base_url('admin1947/hr/payroll');?>" class="<?=($seg1=='hr' && $seg2=='payroll') ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-calculator" style="color: #fcd34d;"></i> Payroll &amp; Salaries</span>
                </a>

                <!-- 4. CRM & Growth -->
                <div class="ops-nav-heading">
                    <span>CRM &amp; Growth</span>
                    <i class="fa fa-line-chart" style="font-size: 10px;"></i>
                </div>
                <a href="<?=base_url('admin1947/crm');?>" class="<?=($seg1=='crm' && (empty($seg2) || $seg2=='dashboard')) ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-line-chart" style="color: #f59e0b;"></i> CRM Command Hub</span>
                </a>
                <a href="<?=base_url('admin1947/crm/leads');?>" class="<?=($seg1=='crm' && $seg2=='leads') ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-columns" style="color: #fbbf24;"></i> Leads &amp; Pipeline</span>
                </a>
                <a href="<?=base_url('admin1947/crm/contacts');?>" class="<?=($seg1=='crm' && $seg2=='contacts') ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-handshake-o" style="color: #38bdf8;"></i> Partner Directory</span>
                </a>
                <a href="<?=base_url('admin1947/crm/activities');?>" class="<?=($seg1=='crm' && $seg2=='activities') ? 'active' : '';?>">
                    <span class="nav-left"><i class="fa fa-phone-square" style="color: #34d399;"></i> Activity &amp; Follow-ups</span>
                </a>

                <!-- 5. Ambulance Module -->
                <div class="ops-nav-heading">
                    <span>Ambulance Network</span>
                    <i class="fa fa-ambulance" style="font-size: 10px; color: #f87171;"></i>
                </div>
                <a href="<?=base_url('ambulance');?>" class="<?=($seg1=='ambulance' && (empty($seg2) || $seg2=='index')) ? 'active' : '';?>" target="_blank">
                    <span class="nav-left"><i class="fa fa-ambulance" style="color: #f87171;"></i> Ambulance Frontend</span>
                    <i class="fa fa-external-link" style="font-size: 10px; color: #64748b;"></i>
                </a>
                <a href="http://localhost/demo/upchar-ambulance/" target="_blank">
                    <span class="nav-left"><i class="fa fa-tachometer" style="color: #fb923c;"></i> Ambulance App Dashboard</span>
                    <i class="fa fa-external-link" style="font-size: 10px; color: #64748b;"></i>
                </a>
                <a href="http://localhost/demo/upchar-ambulance/admin/requests" target="_blank">
                    <span class="nav-left"><i class="fa fa-list" style="color: #34d399;"></i> All Bookings</span>
                    <i class="fa fa-external-link" style="font-size: 10px; color: #64748b;"></i>
                </a>
                <a href="http://localhost/demo/upchar-ambulance/provider" target="_blank">
                    <span class="nav-left"><i class="fa fa-car" style="color: #60a5fa;"></i> Manage Drivers</span>
                    <span class="ops-pill-count">100+</span>
                </a>
                <a href="<?=base_url('ambulance/sos');?>" target="_blank">
                    <span class="nav-left"><i class="fa fa-bolt" style="color: #f43f5e;"></i> SOS Booking Page</span>
                    <span class="ops-pill-count pulse">SOS</span>
                </a>

                <!-- 6. Account & System -->
                <div class="ops-nav-heading">
                    <span>System</span>
                    <i class="fa fa-shield" style="font-size: 10px;"></i>
                </div>
                <a href="<?=base_url('admin1947/');?>">
                    <span class="nav-left"><i class="fa fa-arrow-left" style="color: #94a3b8;"></i> Return Admin Portal</span>
                </a>
                <a href="<?=base_url('admin1947/login/logout');?>">
                    <span class="nav-left"><i class="fa fa-sign-out" style="color: #f87171;"></i> Logout</span>
                </a>
            </nav>
        </div>

        <div class="ops-sidebar-footer">
            <span>Upchar Operations &bull; v3.2</span>
            <span>&copy; <?=date('Y');?></span>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <main class="ops-main">

        <!-- UNIFIED TOP SUITE HEADER -->
        <header class="ops-suite-header">
            <!-- Left Branding & Mobile Trigger -->
            <div style="display: flex; align-items: center; gap: 12px;">
                <button type="button" class="ops-mobile-toggle" onclick="toggleSidebar()">
                    <i class="fa fa-bars"></i>
                </button>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #0f172a 0%, #6366f1 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);">
                        <i class="fa fa-tachometer"></i>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--ops-primary); text-transform: uppercase; letter-spacing: 0.6px; line-height: 1;">
                            Upchar Logistics Platform
                        </div>
                        <strong style="font-size: 17px; font-weight: 800; color: #0f172a; font-family: var(--font-head);">
                            Central Operations Suite
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Right Connected Segmented Tabs -->
            <div style="display: inline-flex; background: #f1f5f9; padding: 4px; border-radius: 12px; border: 1px solid var(--ops-slate-200); gap: 4px; overflow-x: auto; max-width: 100%;">
                <a href="<?=base_url('admin1947/operations');?>" class="ops-suite-tab <?=($seg1=='operations' && (empty($seg2) || $seg2=='dashboard')) ? 'active' : '';?>">
                    <i class="fa fa-tachometer" style="color: #60a5fa;"></i> Operations Hub
                </a>
                <a href="<?=base_url('admin1947/operations/handoffs');?>" class="ops-suite-tab <?=($seg1=='operations' && $seg2=='handoffs') ? 'active' : '';?>">
                    <i class="fa fa-flask" style="color: #fb923c;"></i> Lab / Shift Handoffs
                </a>
                <a href="<?=base_url('admin1947/operations/expenses');?>" class="ops-suite-tab <?=($seg1=='operations' && $seg2=='expenses') ? 'active' : '';?>">
                    <i class="fa fa-credit-card" style="color: #4ade80;"></i> Expense Desk
                </a>
                <a href="<?=base_url('admin1947/attendance/roster');?>" class="ops-suite-tab">
                    <i class="fa fa-calendar-check-o" style="color: #f59e0b;"></i> Attendance Roster
                </a>
                <a href="<?=base_url('admin1947/hr/directory');?>" class="ops-suite-tab">
                    <i class="fa fa-address-book" style="color: #00a896;"></i> Staff Directory
                </a>
            </div>
        </header>

        <div class="ops-main-body">