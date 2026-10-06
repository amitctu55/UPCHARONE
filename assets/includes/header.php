<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?=base_url();?>images/logo.png" type="image/png" sizes="32x32">
    <title>Doctor EHR Portal | Upchar Healthcare</title>
    
    <!-- Modern Typography: Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/cstm.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/theme.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/responsive.css" rel="stylesheet"> 

    <style>
    :root {
        /* 1. Standardized Text Color Tokens (Strict 8-Color Palette) */
        --text-primary: #0f172a;    /* Headings, high-contrast labels, metric numbers */
        --text-secondary: #475569;  /* Body text, table cells, navigation links */
        --text-muted: #64748b;      /* Helper text, timestamps, captions */
        --text-white: #ffffff;      /* Contrast text on dark/colored containers */
        --text-brand: #0284c7;      /* Primary medical action text, links, accents */
        --text-success: #15803d;    /* Verified status, paid badges, positive states */
        --text-warning: #b45309;    /* Pending review, alert badges, queues */
        --text-danger: #b91c1c;     /* Unpaid status, cancelled, emergency alerts */

        /* 2. Standardized Border Radius Tokens (Strict 4-Step System) */
        --radius-sm: 6px;           /* Badges, tags, small inputs, compact action buttons */
        --radius-md: 8px;           /* Standard buttons, search bar, dropdown items */
        --radius-lg: 12px;          /* Major card containers, modals, executive banners */
        --radius-full: 9999px;      /* Pill badges, round buttons, availability toggles */

        /* 3. Surface & Brand Tokens */
        --upchar-blue: #0284c7;
        --upchar-blue-dark: #0369a1;
        --upchar-blue-light: #e0f2fe;
        --upchar-teal: #00a896;
        --upchar-teal-light: #ccfbf1;
        --upchar-navy: #0d1b2a;
        --upchar-navy-surface: #1b263b;
        --upchar-slate-100: #f1f5f9;
        --upchar-slate-50: #f8fafc;
        --upchar-border: #e2e8f0;
        --upchar-success: #10b981;
        --upchar-warning: #f59e0b;
        --upchar-danger: #ef4444;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background-color: var(--upchar-slate-50);
        color: var(--text-secondary);
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    /* ==========================================================
       1. Topbar & Brand Header (Clean White / Frosted Glass)
       ========================================================== */
    .topbar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        height: 64px !important;
        background: rgba(255, 255, 255, 0.94) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid var(--upchar-border) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0 20px !important;
        z-index: 1000 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04) !important;
    }

    .header-left {
        display: flex !important;
        align-items: center !important;
        gap: 14px !important;
        flex-shrink: 0 !important;
    }

    .menu-toggle-btn {
        background: #f8fafc !important;
        border: 1px solid var(--upchar-border) !important;
        border-radius: var(--radius-md) !important;
        width: 36px !important;
        height: 36px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: var(--text-secondary) !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        font-size: 15px !important;
    }

    .menu-toggle-btn:hover {
        background: var(--upchar-slate-100) !important;
        color: var(--text-brand) !important;
        border-color: #cbd5e1 !important;
    }

    .brand-link {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        text-decoration: none !important;
    }

    .brand-logo-img {
        height: 34px !important;
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
        color: var(--text-primary) !important;
        font-size: 18px !important;
        font-weight: 800 !important;
        margin: 0 !important;
        letter-spacing: 0.5px !important;
        line-height: 1.1 !important;
    }

    /* Usability Heuristic Fix 4: Removed uppercase transformation to improve legibility */
    .slowgon {
        font-size: 12px !important;
        font-weight: 600 !important;
        color: var(--text-brand) !important;
        margin: 0 !important;
        text-transform: none !important;
        letter-spacing: 0.2px !important;
        line-height: 1.2 !important;
    }

    /* Usability Heuristic Fix 5: Ensure font-size is at least 12.5px */
    .header-breadcrumbs-pill {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        background: var(--upchar-slate-100) !important;
        border: 1px solid var(--upchar-border) !important;
        padding: 5px 12px !important;
        border-radius: var(--radius-full) !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        color: var(--text-secondary) !important;
        margin-left: 8px !important;
    }

    .header-breadcrumbs-pill i {
        color: var(--text-brand) !important;
    }

    /* 2. Global Quick-Search Bar (Center) */
    .header-center {
        flex: 1 1 auto !important;
        max-width: 440px !important;
        margin: 0 20px !important;
    }

    .header-search-bar {
        position: relative !important;
        display: flex !important;
        align-items: center !important;
        background: #f8fafc !important;
        border: 1px solid var(--upchar-border) !important;
        border-radius: var(--radius-md) !important;
        padding: 6px 12px !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        width: 100% !important;
    }

    .header-search-bar:hover {
        background: #ffffff !important;
        border-color: var(--text-brand) !important;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.08) !important;
    }

    .header-search-bar i {
        color: var(--text-muted) !important;
        font-size: 13px !important;
        margin-right: 8px !important;
    }

    .header-search-bar input {
        border: none !important;
        background: transparent !important;
        font-size: 12.5px !important;
        color: var(--text-secondary) !important;
        width: 100% !important;
        outline: none !important;
        cursor: pointer !important;
        padding: 0 !important;
    }

    .search-kbd-badge {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: var(--radius-sm) !important;
        padding: 2px 6px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        color: var(--text-muted) !important;
        font-family: inherit !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
        white-space: nowrap !important;
    }

    /* 3. Header Utility Buttons & Profile (Right) */
    .header-right {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        flex-shrink: 0 !important;
    }

    /* Quick Action Button (+ Appointment) */
    .btn-quick-appointment {
        background: var(--upchar-blue) !important;
        color: var(--text-white) !important;
        border: none !important;
        border-radius: var(--radius-md) !important;
        padding: 6px 14px !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.2) !important;
    }

    .btn-quick-appointment:hover {
        background: var(--upchar-blue-dark) !important;
        color: var(--text-white) !important;
        transform: translateY(-1px) !important;
    }

    /* Doctor Availability Switcher */
    .btn-availability-toggle {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        background: #f8fafc !important;
        border: 1px solid var(--upchar-border) !important;
        border-radius: var(--radius-full) !important;
        padding: 5px 12px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: var(--text-secondary) !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
    }

    .btn-availability-toggle:hover {
        background: #ffffff !important;
        border-color: #cbd5e1 !important;
    }

    .avail-dot {
        width: 8px !important;
        height: 8px !important;
        border-radius: 50% !important;
        transition: all 0.2s ease !important;
    }

    .avail-online {
        background: var(--upchar-success) !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
    }

    .avail-away {
        background: #94a3b8 !important;
    }

    /* Notification Bell Dropdown */
    .header-notif-wrap {
        position: relative !important;
    }

    .btn-notif-bell {
        background: #f8fafc !important;
        border: 1px solid var(--upchar-border) !important;
        border-radius: var(--radius-md) !important;
        width: 36px !important;
        height: 36px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: var(--text-secondary) !important;
        cursor: pointer !important;
        position: relative !important;
        transition: all 0.2s ease !important;
    }

    .btn-notif-bell:hover {
        background: var(--upchar-slate-100) !important;
        color: var(--text-brand) !important;
    }

    .notif-badge-count {
        position: absolute !important;
        top: -4px !important;
        right: -4px !important;
        background: var(--upchar-danger) !important;
        color: var(--text-white) !important;
        font-size: 10px !important;
        font-weight: 800 !important;
        border-radius: var(--radius-full) !important;
        padding: 1px 5px !important;
        line-height: 1.2 !important;
        border: 2px solid #ffffff !important;
    }

    .notif-dropdown-card {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        margin-top: 8px !important;
        width: 320px !important;
        background: #ffffff !important;
        border: 1px solid var(--upchar-border) !important;
        border-radius: var(--radius-lg) !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        display: none;
        z-index: 1050 !important;
        overflow: hidden !important;
    }

    .notif-header {
        padding: 12px 16px !important;
        border-bottom: 1px solid var(--upchar-border) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        background: #f8fafc !important;
    }

    .notif-title {
        font-size: 13px !important;
        font-weight: 800 !important;
        color: var(--text-primary) !important;
        margin: 0 !important;
    }

    .notif-list {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        max-height: 280px !important;
        overflow-y: auto !important;
    }

    .notif-item {
        padding: 10px 16px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        display: flex !important;
        gap: 12px !important;
        align-items: flex-start !important;
        transition: background 0.15s ease !important;
        text-decoration: none !important;
        color: inherit !important;
    }

    .notif-item:hover {
        background: #f8fafc !important;
    }

    .notif-item-icon {
        width: 28px !important;
        height: 28px !important;
        border-radius: var(--radius-sm) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 12px !important;
        flex-shrink: 0 !important;
    }

    .notif-item-body {
        font-size: 12px !important;
        line-height: 1.3 !important;
        color: var(--text-secondary) !important;
    }

    .notif-item-time {
        font-size: 11px !important;
        color: var(--text-muted) !important;
        margin-top: 3px !important;
    }

    .notif-footer {
        padding: 10px !important;
        text-align: center !important;
        border-top: 1px solid var(--upchar-border) !important;
        background: #f8fafc !important;
    }

    .notif-footer a {
        font-size: 12px !important;
        font-weight: 700 !important;
        color: var(--text-brand) !important;
        text-decoration: none !important;
    }

    /* 4. Profile Dropdown Menu & Pill */
    .user-header-wrap {
        position: relative !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .profile-pill-trigger {
        display: flex !important;
        align-items: center !important;
        gap: 9px !important;
        background: #f8fafc !important;
        border: 1px solid var(--upchar-border) !important;
        padding: 4px 12px !important;
        border-radius: var(--radius-full) !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        cursor: pointer !important;
    }

    .profile-pill-trigger:hover,
    .profile-pill-trigger:focus {
        background: #ffffff !important;
        border-color: var(--text-brand) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
    }

    .profile-avatar-wrap {
        position: relative !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 50% !important;
        overflow: hidden !important;
        border: 2px solid var(--text-brand) !important;
        background: #f1f5f9 !important;
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
        width: 8px !important;
        height: 8px !important;
        background: var(--upchar-success) !important;
        border: 1.5px solid #ffffff !important;
        border-radius: 50% !important;
    }

    .profile-text-wrap {
        display: flex !important;
        flex-direction: column !important;
        text-align: left !important;
    }

    .profile-doc-name {
        color: var(--text-primary) !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        line-height: 1.2 !important;
    }

    /* Usability Heuristic Fix 6: Ensure font-size is at least 12px */
    .profile-doc-role {
        color: var(--text-muted) !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        line-height: 1.3 !important;
    }

    /* Anchored Dropdown Menu Card */
    .custom-doc-dropdown {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        margin-top: 8px !important;
        min-width: 260px !important;
        background: #ffffff !important;
        border: 1px solid var(--upchar-border) !important;
        border-radius: var(--radius-lg) !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        padding: 10px 12px !important;
        z-index: 1050 !important;
        list-style: none !important;
        display: none;
    }

    .dropdown-header-card {
        padding: 4px 6px 10px 6px !important;
        border-bottom: 1px solid var(--upchar-border) !important;
        margin-bottom: 6px !important;
    }

    .custom-doc-dropdown li {
        list-style: none !important;
    }

    .custom-doc-dropdown li a {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        padding: 7px 10px !important;
        color: var(--text-secondary) !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        border-radius: var(--radius-sm) !important;
        transition: all 0.15s ease !important;
        text-decoration: none !important;
    }

    .custom-doc-dropdown li a i {
        width: 18px !important;
        font-size: 13px !important;
        color: var(--text-brand) !important;
        text-align: center !important;
    }

    .custom-doc-dropdown li a:hover {
        background: #f1f5f9 !important;
        color: var(--text-brand) !important;
        padding-left: 13px !important;
    }

    .custom-doc-dropdown .dropdown-divider {
        height: 1px !important;
        background: var(--upchar-border) !important;
        margin: 6px 0 !important;
        padding: 0 !important;
    }

    .custom-doc-dropdown .logout-link a {
        color: var(--text-danger) !important;
        font-weight: 700 !important;
    }

    .custom-doc-dropdown .logout-link a i {
        color: var(--text-danger) !important;
    }

    .custom-doc-dropdown .logout-link a:hover {
        background: #fee2e2 !important;
        color: var(--text-danger) !important;
    }

    /* ==========================================================
       5. Modern Sleek High-Contrast Sidebar
       ========================================================== */
    .dashboard-layout {
        display: flex !important;
        flex-direction: row !important;
        align-items: stretch !important;
        width: 100% !important;
        min-height: calc(100vh - 64px) !important;
        margin-top: 64px !important;
        padding: 0 !important;
        background: var(--upchar-slate-50) !important;
        position: relative !important;
        box-sizing: border-box !important;
        overflow-x: hidden !important;
    }

    .dashboard-layout .sidebar,
    .dashboard-layout aside.sidebar,
    aside.sidebar,
    .sidebar {
        position: -webkit-sticky !important;
        position: sticky !important;
        top: 64px !important;
        left: 0 !important;
        width: 260px !important;
        min-width: 260px !important;
        max-width: 260px !important;
        flex: 0 0 260px !important;
        flex-shrink: 0 !important;
        height: calc(100vh - 64px) !important;
        max-height: calc(100vh - 64px) !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        background: var(--upchar-navy) !important;
        border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.08) !important;
        z-index: 900 !important;
        margin: 0 !important;
        padding: 0 !important;
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
        border-radius: var(--radius-sm);
    }

    .sidebar-inner {
        padding: 10px 0 30px 0 !important;
    }

    .sidebar-group-title {
        padding: 14px 20px 6px 20px !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.9px !important;
        color: var(--text-muted) !important;
    }

    .sidebar .nav-sidebar {
        list-style: none !important;
        padding: 0 8px !important;
        margin: 0 !important;
    }

    .sidebar .nav-sidebar > li {
        display: block !important;
        width: 100% !important;
        margin-bottom: 2px !important;
    }

    .sidebar .nav-sidebar > li > a {
        color: #cbd5e1 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 9px 14px !important;
        border-radius: var(--radius-md) !important;
        transition: all 0.18s ease !important;
        text-decoration: none !important;
        width: 100% !important;
        white-space: nowrap !important;
        overflow: hidden !important;
    }

    .sidebar .nav-sidebar > li > a i {
        color: #94a3b8 !important;
        font-size: 14px !important;
        width: 20px !important;
        text-align: center !important;
        flex-shrink: 0 !important;
        transition: color 0.18s ease !important;
    }

    .sidebar .nav-sidebar > li > a span {
        color: #e2e8f0 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .sidebar .nav-sidebar > li:hover > a {
        background: rgba(255, 255, 255, 0.08) !important;
        color: var(--text-white) !important;
    }

    .sidebar .nav-sidebar > li:hover > a i {
        color: var(--text-brand) !important;
    }

    /* Active State: Distinct Accent Pill */
    .sidebar .nav-sidebar > li.active > a {
        background: rgba(2, 132, 199, 0.18) !important;
        color: var(--text-white) !important;
        border-left: 3px solid var(--text-brand) !important;
        box-shadow: inset 0 0 12px rgba(2, 132, 199, 0.12) !important;
    }

    .sidebar .nav-sidebar > li.active > a i {
        color: #38bdf8 !important;
    }

    .sidebar .nav-sidebar > li.active > a span {
        color: var(--text-white) !important;
        font-weight: 700 !important;
    }

    .menu-badge-ehr {
        background: var(--text-brand) !important;
        color: var(--text-white) !important;
        font-size: 10px !important;
        font-weight: 800 !important;
        padding: 1px 6px !important;
        border-radius: var(--radius-sm) !important;
        margin-left: auto !important;
        letter-spacing: 0.5px !important;
    }

    /* Submenu Accordions (Strict In-Flow Containment: Overrides Rogue Popout Absolute Styles) */
    .sidebar .nav-sidebar .children,
    .sidebar .submenu,
    .sidebar-inner .nav-sidebar .children,
    .sidebar-inner .nav-sidebar .nav-parent .children,
    .submenu-hover .sidebar .sidebar-inner .nav-sidebar .nav-parent .children,
    .submenu-hover.sidebar-collapsed .sidebar .sidebar-inner .nav-sidebar .children,
    .submenu-hover.sidebar-collapsed .sidebar .sidebar-inner .nav-sidebar .nav-hover .children,
    .submenu-hover .sidebar .sidebar-inner .nav-sidebar .children {
        position: static !important;
        left: auto !important;
        right: auto !important;
        top: auto !important;
        bottom: auto !important;
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        z-index: 1 !important;
        float: none !important;
        background: rgba(0, 0, 0, 0.25) !important;
        padding: 4px 0 !important;
        list-style: none !important;
        margin: 2px 0 4px 0 !important;
        border-radius: var(--radius-sm) !important;
        border-left: 2px solid rgba(2, 132, 199, 0.4) !important;
    }

    .sidebar .nav-sidebar .children > li,
    .sidebar .submenu > li {
        width: 100% !important;
        display: block !important;
        position: static !important;
    }

    .sidebar .nav-sidebar .children > li > a,
    .sidebar .submenu > li > a {
        color: #94a3b8 !important;
        padding: 7px 14px 7px 20px !important;
        font-size: 12px !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        text-decoration: none !important;
        transition: all 0.15s ease !important;
        white-space: nowrap !important;
        border-radius: var(--radius-sm) !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .sidebar .nav-sidebar .children > li > a:hover,
    .sidebar .submenu > li > a:hover {
        color: var(--text-white) !important;
        background: rgba(255, 255, 255, 0.06) !important;
    }

    .sidebar .nav-sidebar .children > li.active > a,
    .sidebar .submenu > li.active > a {
        color: #38bdf8 !important;
        background: rgba(56, 189, 248, 0.12) !important;
        font-weight: 700 !important;
    }

    .sidebar .arrow-icon, .sidebar .arrow {
        transition: transform 0.2s ease-in-out;
        margin-left: auto !important;
        font-size: 11px;
        color: var(--text-muted);
        flex-shrink: 0 !important;
    }

    /* Fluid Main Content Container */
    .dashboard-layout .main-content, 
    .dashboard-layout #content, 
    .main-content,
    #content {
        flex: 1 1 auto !important;
        min-width: 0 !important;
        width: calc(100% - 260px) !important;
        max-width: calc(100% - 260px) !important;
        display: flex !important;
        flex-direction: column !important;
        background: var(--upchar-slate-50) !important;
        padding: 0 !important;
        margin: 0 !important;
        overflow-x: hidden !important;
        position: relative !important;
        z-index: 1 !important;
        box-sizing: border-box !important;
        transition: width 0.25s ease, max-width 0.25s ease !important;
    }

    .main-content .page-content, 
    .main-content .pag_cstm,
    .pag_cstm {
        flex: 1 0 auto !important;
        padding: 20px 24px !important;
        margin: 0 !important;
        min-height: calc(100vh - 124px) !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* Force override legacy */
    body .main-content {
        margin-left: 0 !important;
    }
    body .sidebar .logopanel {
        display: none !important;
    }

    /* ==========================================================
       6. Global Search Modal (Ctrl+K)
       ========================================================== */
    .global-search-modal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background: rgba(15, 23, 42, 0.6) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 2000 !important;
        display: none;
        align-items: flex-start !important;
        justify-content: center !important;
        padding: 80px 20px 20px 20px !important;
    }

    .global-search-dialog {
        background: #ffffff !important;
        border-radius: var(--radius-lg) !important;
        width: 100% !important;
        max-width: 620px !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25) !important;
        border: 1px solid var(--upchar-border) !important;
        overflow: hidden !important;
        animation: searchModalSlide 0.15s ease-out !important;
    }

    @keyframes searchModalSlide {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .global-search-header {
        display: flex !important;
        align-items: center !important;
        padding: 14px 18px !important;
        border-bottom: 1px solid var(--upchar-border) !important;
        gap: 12px !important;
    }

    .global-search-header i {
        color: var(--text-brand) !important;
        font-size: 16px !important;
    }

    .global-search-input {
        border: none !important;
        outline: none !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        color: var(--text-primary) !important;
        width: 100% !important;
        background: transparent !important;
    }

    .global-search-close-btn {
        background: var(--upchar-slate-100) !important;
        border: 1px solid var(--upchar-border) !important;
        border-radius: var(--radius-sm) !important;
        padding: 4px 8px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        color: var(--text-muted) !important;
        cursor: pointer !important;
    }

    .global-search-results {
        max-height: 380px !important;
        overflow-y: auto !important;
        padding: 10px 12px !important;
    }

    .search-group-heading {
        font-size: 11px !important;
        font-weight: 800 !important;
        color: var(--text-muted) !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        padding: 8px 10px 4px 10px !important;
    }

    .search-nav-item {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 10px 12px !important;
        border-radius: var(--radius-md) !important;
        color: var(--text-secondary) !important;
        text-decoration: none !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        transition: all 0.15s ease !important;
    }

    .search-nav-item:hover {
        background: #f1f5f9 !important;
        color: var(--text-brand) !important;
    }

    .search-nav-item i {
        width: 22px !important;
        text-align: center !important;
        font-size: 14px !important;
        color: var(--text-brand) !important;
    }

    .search-nav-badge {
        margin-left: auto !important;
        font-size: 12px !important;
        color: var(--text-muted) !important;
        font-weight: 500 !important;
    }

    .global-search-footer {
        padding: 8px 16px !important;
        background: #f8fafc !important;
        border-top: 1px solid var(--upchar-border) !important;
        display: flex !important;
        justify-content: space-between !important;
        font-size: 12px !important;
        color: var(--text-muted) !important;
    }

    /* Floating Toast Notification */
    .upchar-toast {
        position: fixed !important;
        bottom: 24px !important;
        right: 24px !important;
        background: #0f172a !important;
        color: var(--text-white) !important;
        padding: 12px 18px !important;
        border-radius: var(--radius-md) !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        z-index: 2500 !important;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.25s ease !important;
        pointer-events: none;
    }

    .upchar-toast.show {
        opacity: 1 !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
    }

    /* ==========================================================
       7. Responsive Media Queries
       ========================================================== */
    @media screen and (min-width: 1025px) {
        body.sidebar-collapsed .dashboard-layout .sidebar,
        .dashboard-layout.sidebar-collapsed .sidebar {
            width: 70px !important;
            min-width: 70px !important;
            max-width: 70px !important;
            flex: 0 0 70px !important;
            overflow-x: hidden !important;
        }

        body.sidebar-collapsed .sidebar .nav-sidebar > li > a {
            justify-content: center !important;
            padding: 12px 0 !important;
            gap: 0 !important;
            width: 100% !important;
            text-align: center !important;
        }

        body.sidebar-collapsed .sidebar .nav-sidebar > li > a i {
            margin: 0 !important;
            font-size: 18px !important;
            width: auto !important;
            float: none !important;
        }

        body.sidebar-collapsed .sidebar .nav-sidebar > li > a span,
        body.sidebar-collapsed .sidebar .arrow-icon,
        body.sidebar-collapsed .sidebar .arrow,
        body.sidebar-collapsed .sidebar .sidebar-group-title,
        body.sidebar-collapsed .sidebar .menu-badge-ehr {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            width: 0 !important;
            max-width: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }

        body.sidebar-collapsed .sidebar .children,
        body.sidebar-collapsed .sidebar .submenu,
        body.sidebar-collapsed .sidebar .nav-sidebar .children,
        body.sidebar-collapsed .sidebar .nav-sidebar .submenu,
        body.sidebar-collapsed .submenu-hover .sidebar .children,
        body.sidebar-collapsed .submenu-hover.sidebar-collapsed .sidebar .children,
        body.sidebar-collapsed .submenu-hover.sidebar-collapsed .sidebar .sidebar-inner .nav-sidebar .children,
        body.sidebar-collapsed .submenu-hover.sidebar-collapsed .sidebar .sidebar-inner .nav-sidebar .nav-hover .children {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            width: 0 !important;
            max-width: 0 !important;
            height: 0 !important;
            min-width: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }

        body.sidebar-collapsed .dashboard-layout .main-content,
        .dashboard-layout.sidebar-collapsed .main-content {
            width: calc(100% - 70px) !important;
            max-width: calc(100% - 70px) !important;
        }
    }

    @media screen and (min-width: 768px) and (max-width: 1024px) {
        .dashboard-layout .sidebar,
        aside.sidebar,
        .sidebar {
            width: 70px !important;
            min-width: 70px !important;
            max-width: 70px !important;
            flex: 0 0 70px !important;
            overflow-x: hidden !important;
        }

        .sidebar .nav-sidebar > li > a {
            justify-content: center !important;
            padding: 12px 0 !important;
            gap: 0 !important;
            width: 100% !important;
            text-align: center !important;
        }

        .sidebar .nav-sidebar > li > a i {
            margin: 0 !important;
            font-size: 18px !important;
            width: auto !important;
            float: none !important;
        }

        .sidebar .nav-sidebar > li > a span,
        .sidebar .arrow-icon,
        .sidebar .arrow,
        .sidebar .sidebar-group-title,
        .sidebar .menu-badge-ehr {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            width: 0 !important;
            max-width: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }

        .sidebar .children,
        .sidebar .submenu,
        .sidebar .nav-sidebar .children,
        .sidebar .nav-sidebar .submenu,
        .submenu-hover .sidebar .children,
        .submenu-hover.sidebar-collapsed .sidebar .children {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            width: 0 !important;
            max-width: 0 !important;
            height: 0 !important;
            min-width: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }

        .dashboard-layout .main-content,
        .main-content {
            width: calc(100% - 70px) !important;
            max-width: calc(100% - 70px) !important;
        }
    }

    @media screen and (max-width: 767px) {
        .topbar {
            padding: 0 12px !important;
        }
        .header-breadcrumbs-pill,
        .profile-text-wrap,
        .header-center {
            display: none !important;
        }
        .sitename {
            font-size: 16px !important;
        }
        .dashboard-layout .sidebar,
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
        .main-content {
            width: 100% !important;
            max-width: 100% !important;
        }
        .main-content .page-content,
        .pag_cstm {
            padding: 14px 12px !important;
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
    <!-- BEGIN TOPBAR (Frosted Glass Medical Header) -->
    <header class="topbar">
        <!-- Brand Section (Left Flex Container) -->
        <div class="header-left">
            <a class="menu-toggle-btn MENUTOGGLE" href="#" id="sidebarToggleBtn" title="Toggle Navigation">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
            
            <a href="<?=base_url('doctor-dashboard');?>" class="brand-link">
                <img src="<?=base_url();?>images/logo.png" alt="Upchar Logo" class="brand-logo-img">
                <div class="sitenameadjeust">
                    <span class="sitename">UPCHAR</span>
                    <p class="slowgon">Doctor EHR Portal</p>            
                </div>
            </a>

            <div class="header-breadcrumbs-pill hidden-xs">
                <i class="fa fa-stethoscope" aria-hidden="true"></i>
                <span>Clinical EHR Workspace</span>
            </div>
        </div>

        <!-- Global Search Bar (Center Container) -->
        <div class="header-center hidden-xs">
            <div class="header-search-bar" id="globalSearchTrigger" title="Quick Search (Press Ctrl+K)">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input type="text" placeholder="Search patients, appointments, records..." readonly aria-label="Search patients, appointments, and records">
                <kbd class="search-kbd-badge">Ctrl+K</kbd>
            </div>
        </div>

        <!-- Utility Bar & Profile Dropdown (Right Anchored Container) -->
        <div class="header-right">
            <!-- Mobile Search Icon Button -->
            <button class="btn-notif-bell visible-xs" id="mobileSearchTrigger" title="Search" aria-label="Search">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>

            <!-- Quick Appointment Button -->
            <a href="<?=base_url('manageappointment');?>" class="btn-quick-appointment" title="Quick Appointments">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span class="hidden-xs">Appointment</span>
            </a>

            <!-- Doctor Availability Toggle -->
            <button type="button" class="btn-availability-toggle" id="doctorAvailabilityBtn" title="Click to toggle availability" aria-label="Toggle Clinical Status">
                <span class="avail-dot avail-online" id="availDot"></span>
                <span class="avail-text" id="availText">Available</span>
            </button>

            <!-- Notification Bell -->
            <div class="header-notif-wrap" id="headerNotifWrap">
                <button type="button" class="btn-notif-bell" id="notifBellBtn" title="Clinical Notifications" aria-label="Notifications">
                    <i class="fa fa-bell-o" aria-hidden="true"></i>
                    <span class="notif-badge-count">3</span>
                </button>

                <div class="notif-dropdown-card" id="notifDropdownMenu">
                    <div class="notif-header">
                        <h4 class="notif-title"><i class="fa fa-bell-o" style="color: var(--text-brand);" aria-hidden="true"></i> Notifications</h4>
                        <span style="font-size: 11px; color: var(--text-brand); font-weight: 700;">Live Feed</span>
                    </div>
                    <ul class="notif-list">
                        <li>
                            <a href="<?=base_url('manageappointment');?>" class="notif-item">
                                <div class="notif-item-icon" style="background: var(--upchar-blue-light); color: var(--text-brand);">
                                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <div class="notif-item-body"><strong>New Visit Confirmed:</strong> Consultation appointment scheduled for today.</div>
                                    <div class="notif-item-time"><i class="fa fa-clock-o" aria-hidden="true"></i> 15 mins ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url('doctor-dashboard');?>" class="notif-item">
                                <div class="notif-item-icon" style="background: #e0e7ff; color: #4338ca;">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <div class="notif-item-body"><strong>Teleconsult Room:</strong> Digital consultation room ready for WebRTC video call.</div>
                                    <div class="notif-item-time"><i class="fa fa-clock-o" aria-hidden="true"></i> 45 mins ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?=base_url('diet');?>" class="notif-item">
                                <div class="notif-item-icon" style="background: #dcfce7; color: var(--text-success);">
                                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <div class="notif-item-body"><strong>Diet Tracker Telemetry:</strong> Patient logged meal nutrition intake.</div>
                                    <div class="notif-item-time"><i class="fa fa-clock-o" aria-hidden="true"></i> 2 hours ago</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="notif-footer">
                        <a href="<?=base_url('manageappointment');?>">View All Appointments &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <?php 
            $druserid = $this->session->userdata('druserid');
            $profileimg = $this->db->select('drimage, specialization, degree')->from('profile_dr')->where('user_id', $druserid)->get()->row();
            $img_src = ($profileimg && !empty($profileimg->drimage)) ? admin_url()."public/assets/upload/".$profileimg->drimage : base_url()."assets/images/user.jpg";
            $doc_display_name = $this->session->userdata('drusername') ? 'Dr. ' . $this->session->userdata('drusername') : 'Dr. Anushka';
            $doc_specialty = ($profileimg && !empty($profileimg->specialization)) ? $profileimg->specialization : 'Clinical Practitioner';
            ?> 
            <div class="user-header-wrap" id="user-header">
                <a href="#" class="profile-pill-trigger" id="docProfileDropdownTrigger" aria-label="Doctor Profile Menu">
                    <div class="profile-avatar-wrap">
                        <img src="<?=$img_src;?>" alt="Doctor Profile">
                        <span class="profile-online-badge"></span>
                    </div>
                    <div class="profile-text-wrap">
                        <span class="profile-doc-name"><?=$doc_display_name;?></span>
                        <span class="profile-doc-role"><?=$doc_specialty;?></span>
                    </div>
                    <i class="fa fa-angle-down" style="color: var(--text-muted); font-size: 12px; margin-left: 2px;" aria-hidden="true"></i>
                </a>
                
                <!-- Anchored Dropdown Menu Card -->
                <ul class="custom-doc-dropdown" id="docProfileDropdownMenu">
                    <li class="dropdown-header-card">
                        <div style="font-weight: 800; color: var(--text-primary); font-size: 13.5px;"><?=$doc_display_name;?></div>
                        <div style="font-size: 11px; color: var(--text-brand); font-weight: 700; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                            <i class="fa fa-check-circle" aria-hidden="true"></i> Verified Medical Practitioner
                        </div>
                    </li>
                    
                    <li><a href="<?=base_url('doctor-dashboard');?>"><i class="fa fa-dashboard" aria-hidden="true"></i> <span>Dashboard Overview</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/updateprofile');?>"><i class="fa fa-user-md" aria-hidden="true"></i> <span>Edit Profile</span></a></li>
                    <li><a href="<?=base_url('manageappointment');?>"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <span>Appointments &amp; Queue</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/datetime');?>"><i class="fa fa-clock-o" aria-hidden="true"></i> <span>Working Hours &amp; Slots</span></a></li>
                    <li><a href="<?=base_url('manageownclinic');?>"><i class="fa fa-hospital-o" aria-hidden="true"></i> <span>Own Clinic Setup</span></a></li>
                    <li><a href="<?=base_url('managepractice');?>"><i class="fa fa-medkit" aria-hidden="true"></i> <span>Manage Practice &amp; Fees</span></a></li>
                    <li><a href="<?=base_url('diet');?>"><i class="fa fa-cutlery" style="color: var(--text-success);" aria-hidden="true"></i> <span>Patient Diet Tracker (EHR)</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/earnings');?>"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Earnings &amp; Payouts</span></a></li>
                    <li><a href="<?=base_url('doctorpanel/upcharhospital');?>"><i class="fa fa-building-o" aria-hidden="true"></i> <span>Affiliated Hospitals</span></a></li>
                    
                    <li class="dropdown-divider"></li>
                    <li><a href="<?=base_url('doctorpanel/change_password/');?>"><i class="fa fa-lock" style="color: var(--text-warning);" aria-hidden="true"></i> <span>Password &amp; Security</span></a></li>
                    <li class="logout-link"><a href="<?=base_url('doctoruser/logout');?>"><i class="fa fa-sign-out" aria-hidden="true"></i> <span>Logout Portal</span></a></li>
                </ul>
            </div>
        </div>
    </header>
    <!-- END TOPBAR -->

    <!-- Mobile Sidebar Dark Backdrop (Blur Filter) -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Global Quick Search Modal (Ctrl+K) -->
    <div class="global-search-modal" id="globalSearchModal">
        <div class="global-search-dialog">
            <div class="global-search-header">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input type="text" id="globalSearchModalInput" class="global-search-input" placeholder="Type a command or search feature..." autocomplete="off">
                <button type="button" class="global-search-close-btn" id="closeSearchModalBtn">ESC</button>
            </div>
            <div class="global-search-results" id="globalSearchResults">
                <div class="search-group-heading">Clinical Management</div>
                <a href="<?=base_url('doctor-dashboard');?>" class="search-nav-item">
                    <i class="fa fa-dashboard" aria-hidden="true"></i>
                    <span>Doctor Dashboard &amp; Clinical Overview</span>
                    <span class="search-nav-badge">View</span>
                </a>
                <a href="<?=base_url('manageappointment');?>" class="search-nav-item">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                    <span>Manage Appointments &amp; Patient Consultations</span>
                    <span class="search-nav-badge">Visits</span>
                </a>
                <a href="<?=base_url('doctorpanel/datetime');?>" class="search-nav-item">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    <span>Doctor Working Hours &amp; Slot Availability</span>
                    <span class="search-nav-badge">Schedule</span>
                </a>
                <a href="<?=base_url('manageownclinic');?>" class="search-nav-item">
                    <i class="fa fa-hospital-o" aria-hidden="true"></i>
                    <span>Own Clinic Setup &amp; Chambers</span>
                    <span class="search-nav-badge">Clinic</span>
                </a>
                <a href="<?=base_url('managepractice');?>" class="search-nav-item">
                    <i class="fa fa-medkit" aria-hidden="true"></i>
                    <span>Manage Practice &amp; Consultation Fees</span>
                    <span class="search-nav-badge">Pricing</span>
                </a>

                <div class="search-group-heading">Patient Care &amp; Telemetry</div>
                <a href="<?=base_url('diet');?>" class="search-nav-item">
                    <i class="fa fa-cutlery" style="color: var(--text-success);" aria-hidden="true"></i>
                    <span>Daily Diet &amp; Clinical Nutrition Tracker (EHR)</span>
                    <span class="search-nav-badge">Telemetry</span>
                </a>
                <a href="<?=base_url('doctorpanel/upcharhospital');?>" class="search-nav-item">
                    <i class="fa fa-building-o" aria-hidden="true"></i>
                    <span>Visiting Hospitals &amp; Medical Centers</span>
                    <span class="search-nav-badge">Network</span>
                </a>

                <div class="search-group-heading">Financials &amp; Settings</div>
                <a href="<?=base_url('doctorpanel/earnings');?>" class="search-nav-item">
                    <i class="fa fa-line-chart" aria-hidden="true"></i>
                    <span>Doctor Earnings, Escrow Ledger &amp; Payouts</span>
                    <span class="search-nav-badge">Finance</span>
                </a>
                <a href="<?=base_url('doctorpanel/updateprofile');?>" class="search-nav-item">
                    <i class="fa fa-user-md" aria-hidden="true"></i>
                    <span>Doctor Profile, Qualifications &amp; Bio</span>
                    <span class="search-nav-badge">Profile</span>
                </a>
                <a href="<?=base_url('doctorpanel/change_password');?>" class="search-nav-item">
                    <i class="fa fa-lock" style="color: var(--text-warning);" aria-hidden="true"></i>
                    <span>Password &amp; Security Settings</span>
                    <span class="search-nav-badge">Security</span>
                </a>
            </div>
            <div class="global-search-footer">
                <span>Navigate with <kbd>↑</kbd> <kbd>↓</kbd> &bull; Open with <kbd>Enter</kbd></span>
                <span>Press <kbd>ESC</kbd> to close</span>
            </div>
        </div>
    </div>

    <!-- Floating Toast Notification -->
    <div class="upchar-toast" id="upcharToast">
        <i class="fa fa-check-circle" style="color: var(--text-success); font-size: 15px;" aria-hidden="true"></i>
        <span id="toastMessage">Action completed successfully.</span>
    </div>

    <!-- BEGIN DASHBOARD LAYOUT (Direct Flexbox Wrapper) -->
    <div class="dashboard-layout">

<script>
// Global UI Interactivity Handlers
document.addEventListener('DOMContentLoaded', function() {
    // 1. Toast Notification Helper
    window.showUpcharToast = function(msg) {
        var toast = document.getElementById('upcharToast');
        var msgEl = document.getElementById('toastMessage');
        if (toast && msgEl) {
            msgEl.textContent = msg;
            toast.classList.add('show');
            setTimeout(function() {
                toast.classList.remove('show');
            }, 3000);
        }
    };

    // 2. Profile Dropdown Trigger
    var trigger = document.getElementById('docProfileDropdownTrigger');
    var menu = document.getElementById('docProfileDropdownMenu');
    if (trigger && menu) {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            if (notifMenu) notifMenu.style.display = 'none';
        });

        document.addEventListener('click', function(e) {
            if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
    }

    // 3. Notification Bell Dropdown Trigger
    var notifBtn = document.getElementById('notifBellBtn');
    var notifMenu = document.getElementById('notifDropdownMenu');
    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            notifMenu.style.display = (notifMenu.style.display === 'block') ? 'none' : 'block';
            if (menu) menu.style.display = 'none';
        });

        document.addEventListener('click', function(e) {
            if (!notifBtn.contains(e.target) && !notifMenu.contains(e.target)) {
                notifMenu.style.display = 'none';
            }
        });
    }

    // 4. Doctor Availability Toggle
    var availBtn = document.getElementById('doctorAvailabilityBtn');
    var availDot = document.getElementById('availDot');
    var availText = document.getElementById('availText');
    var isOnline = localStorage.getItem('upchar_doc_online') !== '0';

    function updateAvailUI() {
        if (availDot && availText) {
            if (isOnline) {
                availDot.className = 'avail-dot avail-online';
                availText.textContent = 'Available';
            } else {
                availDot.className = 'avail-dot avail-away';
                availText.textContent = 'Away';
            }
        }
    }
    updateAvailUI();

    if (availBtn) {
        availBtn.addEventListener('click', function(e) {
            e.preventDefault();
            isOnline = !isOnline;
            localStorage.setItem('upchar_doc_online', isOnline ? '1' : '0');
            updateAvailUI();
            window.showUpcharToast(isOnline ? 'Status updated: Available for patient consults' : 'Status updated: Offline / Away');
        });
    }

    // 5. Global Search Modal (Ctrl+K)
    var searchModal = document.getElementById('globalSearchModal');
    var searchInput = document.getElementById('globalSearchModalInput');
    var searchTrigger = document.getElementById('globalSearchTrigger');
    var mobileSearchTrigger = document.getElementById('mobileSearchTrigger');
    var closeSearchBtn = document.getElementById('closeSearchModalBtn');
    var searchResults = document.getElementById('globalSearchResults');

    function openSearchModal() {
        if (searchModal) {
            searchModal.style.display = 'flex';
            if (searchInput) {
                searchInput.value = '';
                filterSearchResults('');
                searchInput.focus();
            }
        }
    }

    function closeSearchModal() {
        if (searchModal) {
            searchModal.style.display = 'none';
        }
    }

    if (searchTrigger) searchTrigger.addEventListener('click', openSearchModal);
    if (mobileSearchTrigger) mobileSearchTrigger.addEventListener('click', openSearchModal);
    if (closeSearchBtn) closeSearchBtn.addEventListener('click', closeSearchModal);

    if (searchModal) {
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) closeSearchModal();
        });
    }

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            openSearchModal();
        } else if (e.key === 'Escape' && searchModal && searchModal.style.display === 'flex') {
            closeSearchModal();
        }
    });

    function filterSearchResults(query) {
        if (!searchResults) return;
        var items = searchResults.querySelectorAll('.search-nav-item');
        var q = query.toLowerCase().trim();
        items.forEach(function(item) {
            var text = item.textContent.toLowerCase();
            item.style.display = (q === '' || text.indexOf(q) !== -1) ? 'flex' : 'none';
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            filterSearchResults(e.target.value);
        });
    }

    // 6. Sidebar Responsive Toggle
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