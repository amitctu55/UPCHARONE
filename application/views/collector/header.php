<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Phlebotomist Field App - Upchar</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('public/assets/css/bootstrap.min.css');?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        :root {
            --col-teal: #00a896;
            --col-teal-dark: #028072;
            --col-navy: #0f172a;
            --col-slate: #1e293b;
            --col-bg: #f1f5f9;
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background-color: var(--col-bg);
            color: #1e293b;
            margin: 0;
            padding-bottom: 75px;
        }

        /* Top Mobile App Bar */
        .collector-appbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .collector-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--col-teal);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
        }

        /* Bottom Fixed Navigation Bar */
        .collector-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-around;
            padding: 8px 0;
            z-index: 1000;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }

        .col-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #64748b;
            text-decoration: none !important;
            font-size: 11px;
            font-weight: 600;
            gap: 3px;
        }
        .col-nav-item i { font-size: 18px; }
        .col-nav-item.active, .col-nav-item:hover {
            color: var(--col-teal);
        }

        .container-mobile {
            padding: 16px;
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<header class="collector-appbar">
    <div style="display: flex; align-items: center; gap: 10px;">
        <div class="collector-avatar">
            <?=strtoupper(substr($this->session->userdata('staff_name') ?: 'P', 0, 1));?>
        </div>
        <div>
            <div style="font-weight: 800; font-size: 14.5px; line-height: 1.2;">
                <?=html_escape($this->session->userdata('staff_name') ?: 'Phlebotomist');?>
            </div>
            <small style="color: #2dd4bf; font-size: 11px; font-weight: 600;">
                <i class="fa fa-map-marker"></i> <?=html_escape($this->session->userdata('staff_code') ?: 'Collector');?>
            </small>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <a href="<?=base_url('attendance/punch');?>" class="btn btn-xs" style="background: rgba(45, 212, 191, 0.2); border: 1px solid #2dd4bf; color: #2dd4bf; font-weight: 700; border-radius: 6px; padding: 5px 10px;">
            <i class="fa fa-clock-o"></i> Punch
        </a>
        <a href="<?=base_url('staff/logout');?>" class="btn btn-xs" style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; font-weight: 700; border-radius: 6px; padding: 5px 10px;">
            <i class="fa fa-sign-out"></i>
        </a>
    </div>
</header>
