<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?=base_url();?>images/logo.png" type="image/png" sizes="32x32">
    <title>Doctor Portal | Upchar Healthcare</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/cstm.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/theme.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/responsive.css" rel="stylesheet"> 

    <style>
    :root {
        --upchar-teal: #00a896;
        --upchar-teal-dark: #008f80;
        --upchar-teal-light: #2dd4bf;
        --upchar-navy-dark: #0d1b2a;
        --upchar-card-dark: #1b263b;
        --upchar-slate: #0f172a;
        --upchar-gray: #64748b;
        --upchar-light: #f8fafc;
        --upchar-border: #e2e8f0;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background-color: #f8fafc;
        color: #334155;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    /* 1. Topbar & Brand Logo Header */
    .topbar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        height: 64px !important;
        background: #0d1b2a !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0 24px !important;
        z-index: 1000 !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25) !important;
    }

    .header-left {
        display: flex !important;
        align-items: center !important;
        gap: 16px !important;
    }

    .menu-toggle-btn {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 8px !important;
        width: 38px !important;
        height: 38px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: #ffffff !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        font-size: 16px !important;
    }

    .menu-toggle-btn:hover {
        background: rgba(255, 255, 255, 0.16) !important;
        color: #2dd4bf !important;
    }

    .brand-link {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        text-decoration: none !important;
    }

    .brand-logo-img {
        height: 36px !important;
        width: auto !important;
        object-fit: contain !important;
    }

    .sitenameadjeust {
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
    }

    .sitename {
        font-family: 'Inter', sans-serif !important;
        color: #ffffff !important;
        font-size: 19px !important;
        font-weight: 800 !important;
        margin: 0 !important;
        letter-spacing: 1px !important;
        line-height: 1.1 !important;
    }

    .slowgon {
        font-size: 10px !important;
        font-weight: 600 !important;
        color: #2dd4bf !important;
        margin: 0 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
    }

    /* 2. Profile Dropdown Menu & Pill */
    .header-right {
        display: flex !important;
        align-items: center !important;
    }

    .user-header-wrap {
        position: relative !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .profile-pill-trigger {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        padding: 5px 14px !important;
        border-radius: 30px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        cursor: pointer !important;
    }

    .profile-pill-trigger:hover,
    .profile-pill-trigger:focus {
        background: rgba(255, 255, 255, 0.16) !important;
        border-color: #2dd4bf !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2) !important;
    }

    .profile-avatar-wrap {
        position: relative !important;
        width: 34px !important;
        height: 34px !important;
        border-radius: 50% !important;
        overflow: hidden !important;
        border: 2px solid #2dd4bf !important;
        background: #1b263b !important;
        flex-shrink: 0 !important;
    }

    .profile-avatar-wrap img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }

    .profile-online-badge {
        position: absolute !important;
        bottom: 0 !important;
        right: 0 !important;
        width: 9px !important;
        height: 9px !important;
        background: #10b981 !important;
        border: 2px solid #0d1b2a !important;
        border-radius: 50% !important;
    }

    .profile-text-wrap {
        display: flex !important;
        flex-direction: column !important;
        text-align: left !important;
    }

    .profile-doc-name {
        color: #ffffff !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        line-height: 1.2 !important;
    }

    .profile-doc-role {
        color: #94a3b8 !important;
        font-size: 11px !important;
        font-weight: 500 !important;
    }

    /* Anchored Glassmorphism Dropdown Menu */
    .custom-doc-dropdown {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        margin-top: 8px !important;
        min-width: 270px !important;
        background: #1b263b !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(10px) !important;
        padding: 12px 16px !important;
        z-index: 1050 !important;
        list-style: none !important;
        display: none;
    }

    .dropdown-header-card {
        padding: 0 0 10px 0 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        margin-bottom: 8px !important;
    }

    .custom-doc-dropdown li {
        list-style: none !important;
    }

    .custom-doc-dropdown li a {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 8px 10px !important;
        color: #e2e8f0 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        border-radius: 6px !important;
        transition: all 0.15s ease !important;
        text-decoration: none !important;
    }

    .custom-doc-dropdown li a i {
        width: 18px !important;
        font-size: 14px !important;
        color: #2dd4bf !important;
        text-align: center !important;
    }

    .custom-doc-dropdown li a:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #2dd4bf !important;
        padding-left: 14px !important;
    }

    .custom-doc-dropdown .dropdown-divider {
        height: 1px !important;
        background: rgba(255, 255, 255, 0.1) !important;
        margin: 8px 0 !important;
        padding: 0 !important;
    }

    .custom-doc-dropdown .logout-link a {
        color: #ef4444 !important;
        font-weight: 700 !important;
    }

    .custom-doc-dropdown .logout-link a i {
        color: #ef4444 !important;
    }

    .custom-doc-dropdown .logout-link a:hover {
        background: rgba(239, 68, 68, 0.12) !important;
        color: #f87171 !important;
    }

    /* 3. Dashboard Layout & Flexbox Sidebar Integration */
    .dashboard-layout {
        display: flex !important;
        flex-direction: row !important;
        align-items: stretch !important;
        width: 100% !important;
        min-height: calc(100vh - 64px) !important;
        margin-top: 64px !important;
        padding: 0 !important;
        background: #f8fafc !important;
        position: relative !important;
        box-sizing: border-box !important;
        overflow-x: hidden !important;
    }

    /* Standard Flex item positioning for sidebar (Fixed width, zero float overlay) */
    .dashboard-layout .sidebar,
    .dashboard-layout aside.sidebar,
    aside.sidebar,
    .sidebar,
    .sidebar-wrapper {
        position: -webkit-sticky !important;
        position: sticky !important;
        top: 64px !important;
        left: 0 !important;
        bottom: auto !important;
        right: auto !important;
        width: 260px !important;
        min-width: 260px !important;
        max-width: 260px !important;
        flex: 0 0 260px !important;
        flex-shrink: 0 !important;
        flex-grow: 0 !important;
        height: calc(100vh - 64px) !important;
        max-height: calc(100vh - 64px) !important;
        min-height: calc(100vh - 64px) !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        background: #0d1b2a !important;
        border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.12) !important;
        z-index: 900 !important;
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
        clear: none !important;
        transform: none !important;
        box-sizing: border-box !important;
        transition: width 0.25s ease, min-width 0.25s ease, flex 0.25s ease !important;
        scrollbar-width: thin !important;
        scrollbar-color: rgba(255, 255, 255, 0.2) transparent !important;
    }

    .sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }

    .sidebar-inner {
        padding: 12px 0 !important;
    }

    .sidebar .nav-sidebar {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .sidebar .nav-sidebar > li {
        display: block !important;
        width: 100% !important;
        margin-bottom: 2px !important;
    }

    .sidebar .nav-sidebar > li > a {
        color: #cbd5e1 !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 12px 20px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        width: 100% !important;
        white-space: nowrap !important;
    }

    .sidebar .nav-sidebar > li > a i {
        color: #2dd4bf !important;
        font-size: 15px !important;
        width: 20px !important;
        text-align: center !important;
        flex-shrink: 0 !important;
    }

    .sidebar .nav-sidebar > li > a span {
        color: #f1f5f9 !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
    }

    .sidebar .nav-sidebar > li:hover > a,
    .sidebar .nav-sidebar > li.active > a {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        border-left: 3px solid #2dd4bf !important;
    }

    .sidebar .nav-sidebar > li.active > a i,
    .sidebar .nav-sidebar > li:hover > a i {
        color: #5eead4 !important;
    }

    /* Submenu Accordions */
    .sidebar .nav-sidebar .children,
    .sidebar .submenu {
        background: #09131f !important;
        padding: 6px 0 !important;
        list-style: none !important;
        margin: 0 !important;
    }

    .sidebar .nav-sidebar .children > li > a,
    .sidebar .submenu > li > a {
        color: #94a3b8 !important;
        padding: 9px 20px 9px 48px !important;
        font-size: 12.5px !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        text-decoration: none !important;
        transition: all 0.15s ease !important;
        white-space: nowrap !important;
    }

    .sidebar .nav-sidebar .children > li > a:hover,
    .sidebar .submenu > li > a:hover {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.06) !important;
        padding-left: 52px !important;
    }

    .sidebar .nav-sidebar .children > li.active > a,
    .sidebar .submenu > li.active > a {
        color: #2dd4bf !important;
        background: rgba(45, 212, 191, 0.12) !important;
        font-weight: 700 !important;
        border-left: 3px solid #2dd4bf !important;
        padding-left: 45px !important;
    }

    .sidebar .nav-sidebar .children > li.active > a i,
    .sidebar .submenu > li.active > a i {
        color: #2dd4bf !important;
    }

    .sidebar .arrow-icon, .sidebar .arrow {
        transition: transform 0.2s ease-in-out;
        margin-left: auto !important;
        font-size: 11px;
        color: #64748b;
    }

    /* 4. Fluid Main Content Container (Pushes smoothly to the right, ZERO overlap) */
    .dashboard-layout .main-content, 
    .dashboard-layout #content, 
    .dashboard-layout main.main-content, 
    main.main-content,
    .main-content,
    #content {
        flex: 1 1 auto !important;
        flex-grow: 1 !important;
        flex-shrink: 1 !important;
        min-width: 0 !important;
        width: calc(100% - 260px) !important;
        max-width: calc(100% - 260px) !important;
        display: flex !important;
        flex-direction: column !important;
        background: #f8fafc !important;
        padding: 0 !important;
        margin: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        margin-top: 0 !important;
        overflow-x: hidden !important;
        position: relative !important;
        z-index: 1 !important;
        box-sizing: border-box !important;
        float: none !important;
        transition: width 0.25s ease, max-width 0.25s ease !important;
    }

    .main-content .page-content, 
    .main-content .pag_cstm,
    .page-content,
    .pag_cstm {
        flex: 1 0 auto !important;
        padding: 24px 28px !important;
        margin: 0 !important;
        min-height: calc(100vh - 124px) !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* Force override legacy style.css / theme.css rules */
    body .main-content {
        margin-left: 0 !important;
    }
    body .sidebar .logopanel {
        position: static !important;
        width: 100% !important;
        display: none !important;
    }

    /* ==========================================================
       5. Responsive Media Queries
       ========================================================== */
    
    /* Desktop (>1024px): Standard 260px Persistent Sidebar */
    @media screen and (min-width: 1025px) {
        body.sidebar-collapsed .dashboard-layout .sidebar,
        .dashboard-layout.sidebar-collapsed .sidebar {
            width: 70px !important;
            min-width: 70px !important;
            max-width: 70px !important;
            flex: 0 0 70px !important;
        }

        body.sidebar-collapsed .dashboard-layout .sidebar .nav-sidebar > li > a span,
        body.sidebar-collapsed .dashboard-layout .sidebar .arrow-icon,
        body.sidebar-collapsed .dashboard-layout .sidebar .arrow,
        body.sidebar-collapsed .dashboard-layout .sidebar .children,
        body.sidebar-collapsed .dashboard-layout .sidebar .submenu,
        body.sidebar-collapsed .dashboard-layout .sidebar .sidebar-heading,
        .sidebar-collapsed .sidebar .nav-sidebar > li > a span,
        .sidebar-collapsed .sidebar .arrow-icon,
        .sidebar-collapsed .sidebar .children,
        .sidebar-collapsed .sidebar .submenu,
        .sidebar-collapsed .sidebar .sidebar-heading {
            display: none !important;
        }

        body.sidebar-collapsed .dashboard-layout .sidebar .nav-sidebar > li > a,
        .sidebar-collapsed .sidebar .nav-sidebar > li > a {
            justify-content: center !important;
            padding: 14px 0 !important;
        }

        body.sidebar-collapsed .dashboard-layout .sidebar .nav-sidebar > li > a i,
        .sidebar-collapsed .sidebar .nav-sidebar > li > a i {
            margin: 0 !important;
            font-size: 18px !important;
        }

        body.sidebar-collapsed .dashboard-layout .main-content,
        .dashboard-layout.sidebar-collapsed .main-content {
            width: calc(100% - 70px) !important;
            max-width: calc(100% - 70px) !important;
        }
    }

    /* Tablet (768px - 1024px): Compact 70px Sidebar (Icons Only) */
    @media screen and (min-width: 768px) and (max-width: 1024px) {
        .dashboard-layout .sidebar,
        .dashboard-layout aside.sidebar,
        aside.sidebar,
        .sidebar {
            width: 70px !important;
            min-width: 70px !important;
            max-width: 70px !important;
            flex: 0 0 70px !important;
        }

        .sidebar .nav-sidebar > li > a span,
        .sidebar .arrow-icon,
        .sidebar .arrow,
        .sidebar .children,
        .sidebar .submenu,
        .sidebar .sidebar-heading {
            display: none !important;
        }

        .sidebar .nav-sidebar > li > a {
            justify-content: center !important;
            padding: 14px 0 !important;
        }

        .sidebar .nav-sidebar > li > a i {
            margin: 0 !important;
            font-size: 18px !important;
        }

        .dashboard-layout .main-content,
        .dashboard-layout #content,
        main.main-content,
        .main-content {
            width: calc(100% - 70px) !important;
            max-width: calc(100% - 70px) !important;
        }
    }

    /* Mobile (<768px): Off-Screen Sidebar with Slide-In & Backdrop Blur */
    @media screen and (max-width: 767px) {
        .topbar {
            padding: 0 14px !important;
        }
        .profile-text-wrap {
            display: none !important;
        }
        .sitename {
            font-size: 17px !important;
        }
        .dashboard-layout .sidebar,
        .dashboard-layout aside.sidebar,
        aside.sidebar,
        .sidebar {
            position: fixed !important;
            top: 64px !important;
            left: 0 !important;
            bottom: 0 !important;
            width: 260px !important;
            min-width: 260px !important;
            max-width: 260px !important;
            flex: 0 0 260px !important;
            height: calc(100vh - 64px) !important;
            transform: translateX(-100%) !important;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            z-index: 1050 !important;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.3) !important;
        }
        body.sidebar-show .dashboard-layout .sidebar, 
        .sidebar-show .sidebar,
        aside.sidebar.show {
            transform: translateX(0) !important;
        }
        .dashboard-layout .main-content, 
        .dashboard-layout #content, 
        main.main-content, 
        .main-content {
            width: 100% !important;
            max-width: 100% !important;
        }
        .main-content .page-content,
        .main-content .pag_cstm,
        .pag_cstm {
            padding: 16px 14px !important;
        }
        .sidebar-backdrop {
            position: fixed !important;
            top: 64px !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            background: rgba(0, 0, 0, 0.5) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
            z-index: 1045 !important;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease !important;
        }
        body.sidebar-show .sidebar-backdrop {
            display: block !important;
            opacity: 1 !important;
        }
    }
    </style>
</head>

<body class="sidebar-light fixed-topbar theme-sltl bg-light-dark color-default dashboard">
    <!-- BEGIN TOPBAR (Fixed 100% Width, h-16/64px, #0d1b2a, Z-Index: 1000) -->
    <header class="topbar">
        <!-- Brand Section (Left Flex Container) -->
        <div class="header-left">
            <a class="menu-toggle-btn MENUTOGGLE" href="#" data-toggle="sidebar-collapsed" id="sidebarToggleBtn" title="Toggle Navigation">
                <i class="fa fa-bars"></i>
            </a>
            
            <a href="<?=base_url('doctor-dashboard');?>" class="brand-link">
                <img src="<?=base_url();?>images/logo.png" alt="Upchar Logo" class="brand-logo-img">
                <div class="sitenameadjeust">
                    <h3 class="sitename">UPCHAR</h3>
                    <p class="slowgon">Doctor Partner Workspace</p>            
                </div>
            </a>
        </div>

        <!-- Profile Dropdown (Right Anchored Container) -->
        <div class="header-right">	
            <?php 
            $profileimg = $this->db->select('drimage')->from('profile_dr')->where('user_id', $this->session->userdata('druserid'))->get()->row();
            $img_src = ($profileimg && !empty($profileimg->drimage)) ? admin_url()."public/assets/upload/".$profileimg->drimage : base_url()."assets/images/user.jpg";
            $doc_display_name = $this->session->userdata('drusername') ? 'Dr. ' . $this->session->userdata('drusername') : 'Dr. Anushka';
            ?> 
            <div class="user-header-wrap" id="user-header">
                <a href="#" class="profile-pill-trigger" id="docProfileDropdownTrigger">
                    <div class="profile-avatar-wrap">
                        <img src="<?=$img_src;?>" alt="Doctor Profile">
                        <span class="profile-online-badge"></span>
                    </div>
                    <div class="profile-text-wrap">
                        <span class="profile-doc-name"><?=$doc_display_name;?></span>
                        <span class="profile-doc-role">Clinical Practitioner</span>
                    </div>
                    <i class="fa fa-angle-down" style="color: rgba(255,255,255,0.85); font-size: 12px; margin-left: 2px;"></i>
                </a>
                
                <!-- Anchored Glassmorphism Dropdown Menu Card (Z-Index: 1050) -->
                <ul class="custom-doc-dropdown" id="docProfileDropdownMenu">
                    <li class="dropdown-header-card">
                        <div style="font-weight: 800; color: #ffffff; font-size: 14px;"><?=$doc_display_name;?></div>
                        <div style="font-size: 11.5px; color: #2dd4bf; font-weight: 700; display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                            <i class="fa fa-check-circle"></i> Verified Medical Practitioner
                        </div>
                    </li>
                    
                    <li><a href="<?=base_url('doctor-dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/updateprofile');?>"><i class="fa fa-user-md"></i> <span>Edit Profile</span></a></li>
                    <li><a href="<?=base_url('manageappointment');?>"><i class="fa fa-calendar"></i> <span>Appointments &amp; Visits</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/datetime');?>"><i class="fa fa-clock-o"></i> <span>Schedule &amp; Timings</span></a></li>
                    <li><a href="<?=base_url('manageownclinic');?>"><i class="fa fa-hospital-o"></i> <span>Own Clinic Setup</span></a></li>
                    <li><a href="<?=base_url('managepractice');?>"><i class="fa fa-medkit"></i> <span>Manage Practice</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/earnings');?>"><i class="fa fa-line-chart"></i> <span>Earnings &amp; Payouts</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/upcharhospital');?>"><i class="fa fa-building-o"></i> <span>Affiliated Hospitals</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/gallery');?>"><i class="fa fa-picture-o"></i> <span>Media Gallery</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/news');?>"><i class="fa fa-newspaper-o"></i> <span>News &amp; Articles</span></a></li>
                    
                    <li class="dropdown-divider"></li>
                    <li><a href="<?=base_url('doctorpanel/change_password/');?>"><i class="fa fa-lock" style="color: #f59e0b;"></i> <span>Password &amp; Security</span></a></li>
                    <li class="logout-link"><a href="<?=base_url('doctoruser/logout');?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
                </ul>
            </div>
        </div>
    </header>
    <!-- END TOPBAR -->

    <!-- Mobile Sidebar Dark Backdrop (Blur Filter) -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- BEGIN DASHBOARD LAYOUT (Direct Flexbox Wrapper) -->
    <div class="dashboard-layout">

<script>
document.addEventListener('DOMContentLoaded', function() {
    var trigger = document.getElementById('docProfileDropdownTrigger');
    var menu = document.getElementById('docProfileDropdownMenu');

    if (trigger && menu) {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'block';
            }
        });

        document.addEventListener('click', function(e) {
            if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
    }

    var toggleBtn = document.getElementById('sidebarToggleBtn');
    var backdrop = document.getElementById('sidebarBackdrop');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (window.innerWidth > 1024) {
                document.body.classList.toggle('sidebar-collapsed');
                var dash = document.querySelector('.dashboard-layout');
                if (dash) dash.classList.toggle('sidebar-collapsed');
            } else {
                document.body.classList.toggle('sidebar-show');
                var sb = document.querySelector('.sidebar');
                if (sb) sb.classList.toggle('show');
            }
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', function() {
            document.body.classList.remove('sidebar-show');
            var sb = document.querySelector('.sidebar');
            if (sb) sb.classList.remove('show');
        });
    }
});
</script>