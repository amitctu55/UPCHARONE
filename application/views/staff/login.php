<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff &amp; Enterprise Logistics Portal - Upchar</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('public/assets/css/bootstrap.min.css');?>">

    <style>
        :root {
            --up-teal: #00a896;
            --up-teal-dark: #008f80;
            --up-navy: #0f172a;
            --up-slate: #1e293b;
            --up-card-bg: rgba(30, 41, 59, 0.7);
            --up-border: rgba(255, 255, 255, 0.12);
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0b1120 0%, #0f172a 50%, #1e1b4b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            color: #ffffff;
            margin: 0;
        }

        .staff-login-card {
            background: var(--up-card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--up-border);
            border-radius: 20px;
            padding: 36px 32px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .portal-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 168, 150, 0.15);
            border: 1px solid rgba(0, 168, 150, 0.4);
            color: #2dd4bf;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 18px;
        }

        .form-control-custom {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            color: #ffffff;
            height: 48px;
            padding: 10px 16px;
            font-size: 14px;
            width: 100%;
            transition: all 0.2s;
        }
        .form-control-custom:focus {
            outline: none;
            border-color: var(--up-teal);
            box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.25);
            background: rgba(15, 23, 42, 0.85);
            color: #ffffff;
        }

        .btn-staff-login {
            background: linear-gradient(135deg, #00a896 0%, #0284c7 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            height: 48px;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35);
        }
        .btn-staff-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 168, 150, 0.5);
            color: #ffffff;
        }

        .role-demo-pill {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .role-demo-pill:hover {
            background: rgba(0, 168, 150, 0.2);
            border-color: var(--up-teal);
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="staff-login-card">
    <div style="text-align: center; margin-bottom: 24px;">
        <div class="portal-badge">
            <i class="fa fa-shield"></i> ENTERPRISE WORKFORCE &amp; LOGISTICS
        </div>
        <h2 style="font-size: 24px; font-weight: 800; margin: 0 0 6px; color: #ffffff;">Upchar Staff Portal</h2>
        <p style="color: #94a3b8; font-size: 13.5px; margin: 0;">Sign in to access your role-based operations dashboard</p>
    </div>

    <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; font-size: 13px; border-radius: 8px;">
            <i class="fa fa-exclamation-triangle"></i> <?=$this->session->flashdata('error_msg');?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #6ee7b7; font-size: 13px; border-radius: 8px;">
            <i class="fa fa-check-circle"></i> <?=$this->session->flashdata('success_msg');?>
        </div>
    <?php endif; ?>

    <form action="<?=base_url('staff/authenticate');?>" method="post">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

        <div style="margin-bottom: 18px;">
            <label style="font-size: 12.5px; font-weight: 600; color: #cbd5e1; margin-bottom: 6px; display: block;">
                <i class="fa fa-user" style="color: var(--up-teal); margin-right: 4px;"></i> Staff Code / Email / Mobile
            </label>
            <input type="text" name="identity" class="form-control-custom" placeholder="e.g. UPC-COL-001 or collector@upcharr.com" required autocomplete="username">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="font-size: 12.5px; font-weight: 600; color: #cbd5e1; margin-bottom: 6px; display: block;">
                <i class="fa fa-lock" style="color: var(--up-teal); margin-right: 4px;"></i> Password
            </label>
            <input type="password" name="password" class="form-control-custom" placeholder="Enter your staff password" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn-staff-login">
            <i class="fa fa-sign-in" style="margin-right: 6px;"></i> Secure Portal Login
        </button>
    </form>

    <!-- 1-Click Role Demonstrator Links -->
    <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
        <div style="font-size: 12px; color: #94a3b8; font-weight: 600; margin-bottom: 10px; text-align: center;">
            ⚡ Quick Demo 1-Click Role Access:
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: center;">
            <a href="<?=base_url('staff/demo_login/collector');?>" class="role-demo-pill" title="Phlebotomist Field Web App">
                <i class="fa fa-motorcycle" style="color: #38bdf8;"></i> Phlebotomist PWA
            </a>
            <a href="<?=base_url('staff/demo_login/hr');?>" class="role-demo-pill" title="HR, Leaves & Payroll">
                <i class="fa fa-users" style="color: #f472b6;"></i> HR &amp; Payroll
            </a>
            <a href="<?=base_url('staff/demo_login/bde');?>" class="role-demo-pill" title="BDE CRM Pipeline">
                <i class="fa fa-briefcase" style="color: #fcd34d;"></i> BDE CRM
            </a>
            <a href="<?=base_url('staff/demo_login/office_staff');?>" class="role-demo-pill" title="Sample Handoffs & Expenses">
                <i class="fa fa-flask" style="color: #34d399;"></i> Operations Desk
            </a>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="<?=base_url();?>" style="color: #94a3b8; font-size: 12.5px; text-decoration: none;">
            <i class="fa fa-arrow-left"></i> Back to Upchar Patient Website
        </a>
    </div>
</div>

</body>
</html>
