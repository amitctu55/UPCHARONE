<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Patient Portal &bull; Upchar Healthcare</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 4.7 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url();?>public/assets/css/bootstrap.min.css">

    <style>
    :root {
        --patient-navy-dark: #090e1a;
        --patient-navy-card: #0f172a;
        --patient-navy-hover: #1e293b;
        --patient-navy-border: #1e293b;
        --upchar-teal: #00a896;
        --upchar-teal-dark: #028072;
        --upchar-teal-glow: rgba(0, 168, 150, 0.25);
        --upchar-mint: #10b981;
        --upchar-amber: #f59e0b;
        --upchar-pink: #ec4899;
        --upchar-blue: #38bdf8;
        --patient-bg: #f8fafc;
        --patient-slate: #1e293b;
        --patient-muted: #64748b;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: var(--patient-bg);
        margin: 0;
        padding: 0;
        color: var(--patient-slate);
        -webkit-font-smoothing: antialiased;
    }

    .patient-dashboard-wrapper {
        display: flex;
        min-height: 100vh;
        position: relative;
    }

    /* ==========================================================
       MODERN LUXURY HEALTHCARE SIDEBAR
       ========================================================== */
    .patient-sidebar {
        width: 280px;
        background: linear-gradient(180deg, #0b132b 0%, #0f172a 45%, #0d1b2a 100%);
        color: #ffffff;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 4px 0 25px rgba(0, 0, 0, 0.08);
        border-right: 1px solid rgba(255, 255, 255, 0.06);
        z-index: 1050;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100vh;
        position: sticky;
        top: 0;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.15) transparent;
    }

    .patient-sidebar::-webkit-scrollbar {
        width: 4px;
    }
    .patient-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 4px;
    }

    /* Brand Header */
    .patient-sidebar-brand {
        padding: 22px 20px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .brand-link {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none !important;
    }

    .brand-logo-badge {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
        box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    }

    .brand-logo-badge img {
        max-height: 28px;
        max-width: 28px;
        object-fit: contain;
    }

    .brand-title-wrap {
        display: flex;
        flex-direction: column;
    }

    .brand-title-wrap .brand-name {
        font-size: 19px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.4px;
        line-height: 1.1;
    }

    .brand-title-wrap .brand-tagline {
        font-size: 10.5px;
        color: var(--upchar-teal);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .sidebar-close-btn {
        display: none;
        background: rgba(255, 255, 255, 0.08);
        border: none;
        color: #94a3b8;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .sidebar-close-btn:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    /* Patient Profile Card inside Sidebar */
    .sidebar-profile-card {
        padding: 16px 18px;
        margin: 16px 14px 10px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        backdrop-filter: blur(8px);
        transition: background 0.2s;
    }

    .sidebar-profile-card:hover {
        background: rgba(255, 255, 255, 0.06);
    }

    .patient-avatar-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #00a896 0%, #0d7a6e 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35);
        border: 2px solid rgba(255, 255, 255, 0.15);
    }

    .patient-meta-details {
        overflow: hidden;
        flex: 1;
    }

    .patient-meta-name {
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }

    .patient-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 999px;
        border: 1px solid rgba(52, 211, 153, 0.25);
    }

    /* Nav Menu Styling */
    .patient-nav-section {
        padding: 6px 12px;
        margin-bottom: 12px;
    }

    .nav-group-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748b;
        padding: 10px 14px 4px;
        display: block;
    }

    .patient-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .patient-nav-item {
        margin-bottom: 3px;
    }

    .patient-nav-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        color: #94a3b8;
        text-decoration: none !important;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.2s ease;
        position: relative;
    }

    .nav-link-content {
        display: flex;
        align-items: center;
        gap: 12px;
        overflow: hidden;
    }

    .nav-icon-wrapper {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #94a3b8;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .nav-label-stack {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .nav-main-title {
        font-size: 13px;
        font-weight: 600;
        color: #cbd5e1;
        line-height: 1.25;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: color 0.2s;
    }

    .nav-sub-desc {
        font-size: 10.5px;
        color: #64748b;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Hover & Active States */
    .patient-nav-link:hover {
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
    }

    .patient-nav-link:hover .nav-icon-wrapper {
        background: rgba(0, 168, 150, 0.18);
        color: var(--upchar-teal);
    }

    .patient-nav-link:hover .nav-main-title {
        color: #ffffff;
    }

    .patient-nav-link.active {
        background: linear-gradient(90deg, rgba(0, 168, 150, 0.18) 0%, rgba(0, 168, 150, 0.06) 100%);
        border: 1px solid rgba(0, 168, 150, 0.3);
        color: #ffffff;
    }

    .patient-nav-link.active .nav-icon-wrapper {
        background: #00a896;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 168, 150, 0.4);
    }

    .patient-nav-link.active .nav-main-title {
        color: #ffffff;
        font-weight: 700;
    }

    .patient-nav-link.active .nav-sub-desc {
        color: #5eead4;
    }

    .patient-nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 6px;
        bottom: 6px;
        width: 4px;
        border-radius: 0 4px 4px 0;
        background: #00a896;
        box-shadow: 0 0 8px #00a896;
    }

    /* Badges */
    .nav-badge-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 999px;
        flex-shrink: 0;
        line-height: 1;
    }

    .badge-cart {
        background: #ec4899;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(236, 72, 153, 0.4);
        animation: pulseCart 2s infinite ease-in-out;
    }

    @keyframes pulseCart {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }

    .badge-points {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    /* Sidebar Bottom Footer */
    .patient-sidebar-footer {
        padding: 16px 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.07);
        background: rgba(0, 0, 0, 0.15);
    }

    .footer-action-links {
        display: flex;
        gap: 8px;
    }

    .btn-sidebar-foot {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.2s;
    }

    .btn-foot-home {
        background: rgba(255, 255, 255, 0.06);
        color: #cbd5e1;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .btn-foot-home:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }

    .btn-foot-logout {
        background: rgba(239, 68, 68, 0.12);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.25);
    }
    .btn-foot-logout:hover {
        background: #ef4444;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* ==========================================================
       MOBILE RESPONSIVENESS & TOPBAR
       ========================================================== */
    .patient-mobile-topbar {
        display: none;
        background: #0f172a;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 12px 16px;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1040;
    }

    .mobile-brand-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none !important;
    }

    .mobile-brand-wrap img {
        height: 28px;
    }

    .mobile-brand-wrap span {
        font-size: 17px;
        font-weight: 800;
        color: #ffffff;
    }

    .mobile-toggle-btn {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #ffffff;
        width: 38px;
        height: 38px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
    }

    .patient-sidebar-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(4px);
        z-index: 1045;
    }

    @media (max-width: 991px) {
        .patient-dashboard-wrapper {
            flex-direction: column;
        }

        .patient-mobile-topbar {
            display: flex;
        }

        .patient-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            transform: translateX(-100%);
            box-shadow: 10px 0 30px rgba(0,0,0,0.4);
        }

        .patient-sidebar.open {
            transform: translateX(0);
        }

        .patient-sidebar-backdrop.active {
            display: block;
        }

        .sidebar-close-btn {
            display: flex;
        }

        .patient-main-content {
            padding: 16px !important;
        }
    }

    /* Main Patient Content Area */
    .patient-main-content {
        flex-grow: 1;
        padding: 30px;
        background-color: var(--patient-bg);
        overflow-x: hidden;
        min-width: 0;
    }
    </style>
</head>
<body>

<?php
    // Resolve patient profile display
    $userId = $this->session->userdata('USERID') ?: $this->session->userdata('userid') ?: $this->session->userdata('WEB_UID') ?: $this->session->userdata('user_id');
    $patient_name = $this->session->userdata('username') ?: 'Patient';

    // If full name is available from DB or object
    if (!empty($userId)) {
        $CI =& get_instance();
        $userRow = $CI->db->select('FNAME, LNAME, MOBILE, EMAIL')->get_where('userlogin', array('USERID' => $userId))->row();
        if ($userRow) {
            $patient_name = trim($userRow->FNAME . ' ' . $userRow->LNAME) ?: $userRow->FNAME ?: $patient_name;
        }
    }

    // Resolve Cart Counters
    $path_cart = $this->session->userdata('path_cart') ?: [];
    $path_count = is_array($path_cart) ? count($path_cart) : 0;
    $medicart = $this->session->userdata('medicart') ?: [];
    $med_count = is_array($medicart) ? count($medicart) : 0;
    $total_cart_items = $path_count + $med_count;

    // Resolve Wallet Balance Preview
    $patient_wallet_points = 0;
    if (!empty($userId)) {
        $CI =& get_instance();
        if (!isset($CI->Wallet_model)) {
            $CI->load->model('Wallet_model');
        }
        if (isset($CI->Wallet_model)) {
            $patient_wallet_points = floatval($CI->Wallet_model->get_balance($userId));
        }
    }

    // Current URI segments for precise active link highlighting
    $seg1 = $this->uri->segment(1);
    $seg2 = $this->uri->segment(2);
?>

<!-- Mobile Top Bar (< 992px) -->
<div class="patient-mobile-topbar">
    <div class="mobile-brand-wrap">
        <img src="<?=base_url('images/logo.png');?>" alt="Upchar Logo" onerror="this.src='https://upchar.info/images/Final_logo23.png';">
        <span>Upchar Patient</span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <?php if($total_cart_items > 0): ?>
            <a href="<?=base_url('mytest/checkout');?>" class="badge-cart" style="text-decoration: none; padding: 5px 10px; border-radius: 999px; font-size: 11px; font-weight: 700;">
                <i class="fa fa-shopping-cart"></i> <?=$total_cart_items;?>
            </a>
        <?php endif; ?>
        <button type="button" class="mobile-toggle-btn" id="openPatientSidebar" aria-label="Toggle Navigation">
            <i class="fa fa-bars"></i>
        </button>
    </div>
</div>

<!-- Backdrop overlay for mobile drawer -->
<div class="patient-sidebar-backdrop" id="patientSidebarBackdrop"></div>

<div class="patient-dashboard-wrapper">

    <!-- ==================================================== -->
    <!-- REDESIGNED LUXURY PATIENT NAVIGATION SIDEBAR         -->
    <!-- ==================================================== -->
    <aside class="patient-sidebar" id="patientSidebarNav">
        <div>
            <!-- 1. Brand Logo Header -->
            <div class="patient-sidebar-brand">
                <a href="<?=base_url();?>" class="brand-link">
                    <div class="brand-logo-badge">
                        <img src="<?=base_url('images/logo.png');?>" alt="Upchar" onerror="this.src='https://upchar.info/images/Final_logo23.png';">
                    </div>
                    <div class="brand-title-wrap">
                        <span class="brand-name">UPCHAR</span>
                        <span class="brand-tagline">Patient Care Hub</span>
                    </div>
                </a>
                <button type="button" class="sidebar-close-btn" id="closePatientSidebar" aria-label="Close Navigation">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <!-- 2. Patient Identity Profile Card -->
            <div class="sidebar-profile-card">
                <div class="patient-avatar-box">
                    <?=strtoupper(substr($patient_name, 0, 1));?>
                </div>
                <div class="patient-meta-details">
                    <div class="patient-meta-name" title="<?=html_escape($patient_name);?>">
                        <?=html_escape($patient_name);?>
                    </div>
                    <span class="patient-status-pill">
                        <i class="fa fa-check-circle"></i> Verified Patient
                    </span>
                </div>
            </div>

            <!-- 3. Navigation Group: CLINICAL CARE & BOOKINGS -->
            <div class="patient-nav-section">
                <span class="nav-group-label">Clinical &amp; Consultations</span>
                <ul class="patient-nav-list">

                    <!-- Work: Consultations, Appointments & Booking Management -->
                    <li class="patient-nav-item">
                        <a href="<?=base_url('myappointments');?>" class="patient-nav-link <?=($seg1 == 'myappointments' || $seg1 == 'myappointents') ? 'active' : '';?>">
                            <div class="nav-link-content">
                                <div class="nav-icon-wrapper" style="color: #38bdf8;">
                                    <i class="fa fa-calendar-check-o"></i>
                                </div>
                                <div class="nav-label-stack">
                                    <span class="nav-main-title">My Appointments &amp; Bookings</span>
                                    <span class="nav-sub-desc">Doctor visits &amp; Lab orders</span>
                                </div>
                            </div>
                        </a>
                    </li>

                    <!-- Work: Find and book certified doctors -->
                    <li class="patient-nav-item">
                        <a href="<?=base_url('doctors');?>" class="patient-nav-link <?=($seg1 == 'doctors') ? 'active' : '';?>">
                            <div class="nav-link-content">
                                <div class="nav-icon-wrapper" style="color: #34d399;">
                                    <i class="fa fa-user-md"></i>
                                </div>
                                <div class="nav-label-stack">
                                    <span class="nav-main-title">Find &amp; Book Doctors</span>
                                    <span class="nav-sub-desc">Specialists &amp; Video Consults</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 4. Navigation Group: DIAGNOSTICS & CART -->
            <div class="patient-nav-section">
                <span class="nav-group-label">Diagnostics &amp; Cart</span>
                <ul class="patient-nav-list">

                    <!-- Work: Browse pathology tests, packages & book sample pickup -->
                    <!-- Diagnostics & Pathology Unified Entry (Catalog, Cart & Checkout merged) -->
                    <li class="patient-nav-item">
                        <a href="<?=base_url('mytest');?>" class="patient-nav-link <?=($seg1 == 'mytest' || $seg1 == 'diagnostic') ? 'active' : '';?>">
                            <div class="nav-link-content">
                                <div class="nav-icon-wrapper" style="color: #00a896;">
                                    <i class="fa fa-flask"></i>
                                </div>
                                <div class="nav-label-stack">
                                    <span class="nav-main-title">Diagnostics &amp; Lab Tests</span>
                                    <span class="nav-sub-desc">Tests, Cart &amp; Home Pickup</span>
                                </div>
                            </div>
                            <?php if(!empty($total_cart_items) && $total_cart_items > 0): ?>
                                <span class="nav-badge-pill badge-cart" id="headerCartBadge">
                                    <?=$total_cart_items;?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 5. Navigation Group: BILLING, REWARDS & PROFILE -->
            <div class="patient-nav-section">
                <span class="nav-group-label">Billing &amp; Medical Records</span>
                <ul class="patient-nav-list">

                    <!-- Work: Upchar Cashback Points, Wallet Balance & Topup -->
                    <li class="patient-nav-item">
                        <a href="<?=base_url('wallet');?>" class="patient-nav-link <?=($seg1 == 'wallet' || $seg1 == 'wallet_v2') ? 'active' : '';?>">
                            <div class="nav-link-content">
                                <div class="nav-icon-wrapper" style="color: #f59e0b;">
                                    <i class="fa fa-google-wallet"></i>
                                </div>
                                <div class="nav-label-stack">
                                    <span class="nav-main-title">Upchar Wallet &amp; Cashback</span>
                                    <span class="nav-sub-desc">Rewards &amp; Instant Balance</span>
                                </div>
                            </div>
                            <span class="nav-badge-pill badge-points">
                                <?=number_format($patient_wallet_points, 0);?> Pts
                            </span>
                        </a>
                    </li>

                    <!-- Work: Invoices, Tax receipts & Payment transactions -->
                    <li class="patient-nav-item">
                        <a href="<?=base_url('payment/history');?>" class="patient-nav-link <?=($seg1 == 'payment') ? 'active' : '';?>">
                            <div class="nav-link-content">
                                <div class="nav-icon-wrapper" style="color: #818cf8;">
                                    <i class="fa fa-file-text-o"></i>
                                </div>
                                <div class="nav-label-stack">
                                    <span class="nav-main-title">Payments &amp; Tax Invoices</span>
                                    <span class="nav-sub-desc">Receipts &amp; 80D Tax proof</span>
                                </div>
                            </div>
                        </a>
                    </li>

                    <!-- Work: Personal vitals, health history, address & dependents -->
                    <li class="patient-nav-item">
                        <a href="<?=base_url('profile');?>" class="patient-nav-link <?=($seg1 == 'profile') ? 'active' : '';?>">
                            <div class="nav-link-content">
                                <div class="nav-icon-wrapper" style="color: #a78bfa;">
                                    <i class="fa fa-user-circle"></i>
                                </div>
                                <div class="nav-label-stack">
                                    <span class="nav-main-title">Patient Profile &amp; Family</span>
                                    <span class="nav-sub-desc">Vitals, BMI &amp; Dependents</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- 6. Bottom Sticky Quick Action Footer -->
        <div class="patient-sidebar-footer">
            <div class="footer-action-links">
                <a href="<?=base_url();?>" class="btn-sidebar-foot btn-foot-home" title="Go to Main Website">
                    <i class="fa fa-home"></i> Home
                </a>
                <a href="<?=base_url('logout');?>" class="btn-sidebar-foot btn-foot-logout" title="Sign out from Upchar Portal">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
            </div>
            <div style="text-align: center; margin-top: 10px; font-size: 10px; color: #475569; letter-spacing: 0.3px;">
                Upchar Healthcare &bull; <?=date('Y');?>
            </div>
        </div>
    </aside>

    <!-- Main Content Body Container Starts -->
    <main class="patient-main-content">
        <?php if($total_cart_items > 0 && ($seg1 != 'mytest' || $seg2 != 'checkout')): ?>
        <!-- Floating Quick Cart Access Banner for Patient -->
        <div style="background: linear-gradient(135deg, #00a896 0%, #0d7a6e 100%); color: #ffffff; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 16px rgba(0,168,150,0.25); flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div>
                    <strong style="font-size: 14px;">You have <?=$total_cart_items;?> diagnostic test<?=$total_cart_items > 1 ? 's' : '';?> in your cart</strong>
                    <div style="font-size: 12px; opacity: 0.9;">Ready to complete your scheduled booking?</div>
                </div>
            </div>
            <a href="<?=base_url('mytest/checkout');?>" class="btn btn-sm" style="background: #ffffff; color: #0d7a6e; font-weight: 700; border-radius: 8px; padding: 7px 18px; text-decoration: none;">
                Proceed to Checkout <i class="fa fa-arrow-right" style="margin-left: 4px;"></i>
            </a>
        </div>
        <?php endif; ?>

<script>
// Responsive Drawer Toggle Logic
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('patientSidebarNav');
    var backdrop = document.getElementById('patientSidebarBackdrop');
    var openBtn = document.getElementById('openPatientSidebar');
    var closeBtn = document.getElementById('closePatientSidebar');

    function openDrawer() {
        if (sidebar) sidebar.classList.add('open');
        if (backdrop) backdrop.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        if (sidebar) sidebar.classList.remove('open');
        if (backdrop) backdrop.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (openBtn) openBtn.addEventListener('click', openDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (backdrop) backdrop.addEventListener('click', closeDrawer);
});
</script>
