<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Upchar</title>
    <link rel="icon" href="<?=base_url();?>images/logo.png" type="image/png">
    
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url();?>public/assets/css/bootstrap.min.css">

    <style>
    :root {
        --upchar-teal: #00a896;
        --upchar-teal-dark: #028072;
        --upchar-navy: #1d2a44;
        --upchar-slate: #1e293b;
        --upchar-bg: #f8fafc;
        --upchar-border: #e2e8f0;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--upchar-bg);
        margin: 0;
        padding: 0;
        color: var(--upchar-slate);
    }

    .patient-dashboard-wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* Patient Sidebar Navigation */
    .patient-sidebar {
        width: 260px;
        background: #1d2a44;
        color: #ffffff;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 24px 0;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    }

    .patient-brand {
        padding: 0 24px 20px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .patient-brand img {
        height: 36px;
    }

    .patient-brand span {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.5px;
    }

    .patient-profile-card {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .patient-avatar-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--upchar-teal);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }

    .patient-profile-info {
        overflow: hidden;
    }

    .patient-profile-name {
        font-size: 14.5px;
        font-weight: 700;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .patient-profile-role {
        font-size: 12px;
        color: #94a3b8;
    }

    .patient-nav-menu {
        list-style: none;
        padding: 16px 12px;
        margin: 0;
    }

    .patient-nav-menu li {
        margin-bottom: 4px;
    }

    .patient-nav-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 16px;
        color: #cbd5e1;
        text-decoration: none !important;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .patient-nav-menu a:hover,
    .patient-nav-menu a.active {
        background: var(--upchar-teal);
        color: #ffffff;
    }

    .patient-nav-menu a i {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }

    /* Main Patient Content Area */
    .patient-main-content {
        flex-grow: 1;
        padding: 30px;
        background-color: var(--upchar-bg);
        overflow-x: hidden;
    }

    /* Header Navbar Top Bar */
    .patient-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .patient-topbar-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    </style>
</head>
<body>

<div class="patient-dashboard-wrapper">
    <!-- Sidebar Navigation -->
    <aside class="patient-sidebar">
        <div>
            <div class="patient-brand">
                <a href="<?=base_url();?>" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                    <img src="<?=base_url('images/logo.png');?>" alt="Upchar Logo" onerror="this.style.display='none';">
                    <span>Upchar</span>
                </a>
            </div>

            <div class="patient-profile-card">
                <div class="patient-avatar-circle">
                    <?=strtoupper(substr($this->session->userdata('username') ?: 'P', 0, 1));?>
                </div>
                <div class="patient-profile-info">
                    <div class="patient-profile-name">
                        <?=html_escape($this->session->userdata('username') ?: 'Patient Portal');?>
                    </div>
                    <div class="patient-profile-role">Verified Patient</div>
                </div>
            </div>

            <ul class="patient-nav-menu">
                <li>
                    <a href="<?=base_url('myappointments');?>" class="<?=($this->uri->segment(1) == 'myappointments' || $this->uri->segment(1) == 'myappointents') ? 'active' : '';?>">
                        <i class="fa fa-calendar"></i> Appointments
                    </a>
                </li>
                <li>
                    <a href="<?=base_url('profile');?>" class="<?=($this->uri->segment(1) == 'profile') ? 'active' : '';?>">
                        <i class="fa fa-id-card"></i> Medical Records &amp; Profile
                    </a>
                </li>
                <li>
                    <a href="<?=base_url('mytest');?>" class="<?=($this->uri->segment(1) == 'mytest' || $this->uri->segment(1) == 'diagnostic') ? 'active' : '';?>">
                        <i class="fa fa-flask"></i> Lab Tests &amp; Diagnostics
                    </a>
                </li>
                <li>
                    <a href="<?=base_url('doctors');?>" class="<?=($this->uri->segment(1) == 'doctors') ? 'active' : '';?>">
                        <i class="fa fa-user-md"></i> Doctor Consultations
                    </a>
                </li>
                <li>
                    <a href="<?=base_url('logout');?>">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <div style="padding: 0 24px; font-size: 11px; color: #64748b;">
            Upchar Healthcare Platform &copy; <?=date('Y');?>
        </div>
    </aside>

    <!-- Main Content Body Container Starts -->
    <main class="patient-main-content">
