<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pathology Partner Portal | Upchar Healthcare</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/cstm.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/theme.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/responsive.css" rel="stylesheet"> 

    <style>
    :root {
        --upchar-primary: #00a896;
        --upchar-primary-dark: #028072;
        --upchar-navy: #1d2a44;
        --upchar-navy-dark: #141e32;
        --upchar-sidebar-bg: #1e293b;
        --upchar-sidebar-hover: #334155;
        --upchar-border: #e2e8f0;
        --upchar-text-dark: #0f172a;
        --upchar-text-muted: #64748b;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        background-color: #f8fafc;
        margin: 0;
        padding: 0;
        color: #334155;
    }

    /* Master Top Bar */
    .pathlab-topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 64px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        z-index: 1030;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .sidebar-toggle-btn {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #1e293b;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none !important;
    }

    .sidebar-toggle-btn:hover {
        background: #e2e8f0;
        color: var(--upchar-primary);
    }

    .brand-logo-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none !important;
    }

    .brand-logo-img {
        height: 36px;
        width: auto;
    }

    .brand-text-block {
        display: flex;
        flex-direction: column;
    }

    .brand-title {
        font-size: 18px;
        font-weight: 800;
        color: #00a896;
        letter-spacing: 0.5px;
        line-height: 1.1;
        margin: 0;
    }

    .brand-tagline {
        font-size: 11px;
        font-weight: 500;
        color: #64748b;
        letter-spacing: 0.2px;
        margin: 0;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    /* User Profile Dropdown */
    .user-profile-menu {
        position: relative;
    }

    .user-profile-trigger {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px;
        border-radius: 30px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none !important;
    }

    .user-profile-trigger:hover, .user-profile-menu.open .user-profile-trigger {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .user-avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #00a896;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
    }

    .user-name-text {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        max-width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-dropdown-card {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 230px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 8px 0;
        z-index: 1050;
        display: none;
    }

    .user-profile-menu.open .user-dropdown-card {
        display: block;
        animation: fadeInSlide 0.2s ease forwards;
    }

    @keyframes fadeInSlide {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-user-header {
        padding: 10px 16px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 4px;
    }

    .dropdown-user-header strong {
        display: block;
        font-size: 13.5px;
        color: #0f172a;
    }

    .dropdown-user-header small {
        color: #64748b;
        font-size: 11.5px;
    }

    .user-dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 16px;
        color: #334155 !important;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none !important;
        transition: all 0.15s ease;
    }

    .user-dropdown-item:hover {
        background: #f0fdfa;
        color: #00a896 !important;
    }

    .user-dropdown-item i {
        font-size: 14px;
        width: 18px;
        text-align: center;
        color: #64748b;
    }

    .user-dropdown-item:hover i {
        color: #00a896;
    }

    .dropdown-divider-line {
        height: 1px;
        background: #f1f5f9;
        margin: 6px 0;
    }

    /* Master Layout Grid */
    .pathlab-layout {
        display: flex;
        margin-top: 64px;
        min-height: calc(100vh - 64px);
    }

    .pathlab-sidebar {
        width: 240px;
        background: #1e293b;
        flex-shrink: 0;
        position: fixed;
        top: 64px;
        bottom: 0;
        left: 0;
        overflow-y: auto;
        z-index: 1020;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pathlab-main-viewport {
        flex: 1;
        margin-left: 240px;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: #f8fafc;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Sidebar collapsed mode */
    body.sidebar-collapsed .pathlab-sidebar {
        transform: translateX(-240px);
    }

    body.sidebar-collapsed .pathlab-main-viewport {
        margin-left: 0;
    }

    /* Mobile Backdrop */
    .sidebar-mobile-backdrop {
        position: fixed;
        top: 64px;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(2px);
        z-index: 1015;
        display: none;
    }

    @media (max-width: 991px) {
        .pathlab-sidebar {
            transform: translateX(-240px);
        }
        .pathlab-main-viewport {
            margin-left: 0;
        }
        body.sidebar-open .pathlab-sidebar {
            transform: translateX(0);
        }
        body.sidebar-open .sidebar-mobile-backdrop {
            display: block;
        }
    }
    </style>
</head>

<body>
    <!-- Top Navigation Header -->
    <header class="pathlab-topbar">
        <div class="topbar-left">
            <button type="button" class="sidebar-toggle-btn" id="sidebar-toggle-btn" title="Toggle Navigation Sidebar">
                <i class="fa fa-bars"></i>
            </button>

            <a href="<?=base_url('pathlab-dashboard');?>" class="brand-logo-wrap">
                <img src="<?=base_url('images/logo.png');?>" alt="Upchar Logo" class="brand-logo-img" onerror="this.style.display='none'">
                <div class="brand-text-block">
                    <h3 class="brand-title">UPCHAR</h3>
                    <p class="brand-tagline">One Place For Healthcare</p>
                </div>
            </a>
        </div>

        <div class="topbar-right">
            <!-- Quick Action: Book Test Button -->
            <a href="<?=base_url('pathlabpanel/book_test');?>" class="btn btn-sm hidden-xs" style="background: #00a896; color: #ffffff; font-weight: 600; border-radius: 6px; padding: 6px 14px; text-decoration: none;">
                <i class="fa fa-plus-circle"></i> Book Test
            </a>

            <!-- User Profile Dropdown -->
            <?php 
                $activeUsername = $this->session->userdata('pathusername') ?: 'Pathology Partner';
                $initial = strtoupper(substr($activeUsername, 0, 1));
            ?>
            <div class="user-profile-menu" id="user-profile-menu">
                <a href="javascript:void(0);" class="user-profile-trigger" id="user-profile-btn">
                    <div class="user-avatar-circle"><?=$initial;?></div>
                    <span class="user-name-text"><?=htmlspecialchars($activeUsername);?></span>
                    <i class="fa fa-chevron-down" style="font-size: 11px; color: #64748b;"></i>
                </a>

                <div class="user-dropdown-card" id="user-dropdown-card">
                    <div class="dropdown-user-header">
                        <strong><?=htmlspecialchars($activeUsername);?></strong>
                        <small>Pathology Diagnostic Center</small>
                    </div>

                    <a href="<?=base_url('pathlabpanel/updateprofile');?>" class="user-dropdown-item">
                        <i class="fa fa-user-circle"></i> My Profile
                    </a>
                    <a href="<?=base_url('pathlabpanel/pathtest');?>" class="user-dropdown-item">
                        <i class="fa fa-flask"></i> Manage Tests
                    </a>
                    <a href="<?=base_url('pathlabpanel/payments');?>" class="user-dropdown-item">
                        <i class="fa fa-credit-card"></i> My Payments
                    </a>
                    <a href="<?=base_url('pathlabpanel/updateprofile');?>" class="user-dropdown-item">
                        <i class="fa fa-edit"></i> View / Update Profile
                    </a>
                    <a href="<?=base_url('pathlabpanel/change_password');?>" class="user-dropdown-item">
                        <i class="fa fa-key"></i> Change Password
                    </a>
                    <a href="<?=base_url('pathlabpanel/settings');?>" class="user-dropdown-item">
                        <i class="fa fa-sliders"></i> Settings
                    </a>

                    <div class="dropdown-divider-line"></div>

                    <a href="<?=base_url('pathlabuser/logout');?>" class="user-dropdown-item" style="color: #ef4444 !important;">
                        <i class="fa fa-sign-out" style="color: #ef4444;"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="sidebar-mobile-backdrop" id="sidebar-mobile-backdrop"></div>

    <div class="pathlab-layout">