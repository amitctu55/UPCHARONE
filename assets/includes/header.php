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
        --upchar-navy: #043d5b;
        --upchar-slate: #0f172a;
        --upchar-gray: #64748b;
        --upchar-light: #f8fafc;
        --upchar-border: #e2e8f0;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background-color: #f8fafc;
        color: #334155;
    }

    /* Topbar Layout with Flexbox */
    .topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 62px;
        background: linear-gradient(135deg, #043d5b 0%, #008f80 70%, #00a896 100%) !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        z-index: 1030;
        box-shadow: 0 2px 10px rgba(4, 61, 91, 0.2);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .sitenameadjeust {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .sitename {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: #ffffff;
        font-size: 20px;
        font-weight: 800;
        margin: 0;
        letter-spacing: 1px;
    }

    .slowgon {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Header Profile Pill */
    .profile-pill-trigger {
        display: flex !important;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 6px 14px !important;
        border-radius: 30px !important;
        transition: all 0.2s ease;
        text-decoration: none !important;
        cursor: pointer;
    }

    .profile-pill-trigger:hover,
    .profile-pill-trigger:focus {
        background: rgba(255, 255, 255, 0.25) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar-wrap {
        position: relative;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #ffffff;
        background: #ffffff;
    }

    .profile-avatar-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-online-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 9px;
        height: 9px;
        background: #10b981;
        border: 2px solid #ffffff;
        border-radius: 50%;
    }

    .profile-text-wrap {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .profile-doc-name {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.2;
    }

    .profile-doc-role {
        color: rgba(255, 255, 255, 0.8);
        font-size: 11px;
        font-weight: 500;
    }

    /* Custom Floating Dropdown Menu */
    .custom-doc-dropdown {
        min-width: 270px;
        border-radius: 14px !important;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.2) !important;
        border: 1px solid #e2e8f0 !important;
        padding: 8px 0 !important;
        background: #ffffff !important;
        z-index: 999999 !important;
        top: 115% !important;
        right: 0 !important;
        left: auto !important;
    }

    .dropdown-header-card {
        padding: 12px 18px 10px 18px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 6px;
    }

    .custom-doc-dropdown li a {
        display: flex !important;
        align-items: center;
        gap: 12px;
        padding: 9px 18px !important;
        color: #334155 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        transition: all 0.15s ease;
    }

    .custom-doc-dropdown li a i {
        width: 18px;
        font-size: 15px;
        color: #00a896;
        text-align: center;
    }

    .custom-doc-dropdown li a:hover {
        background: #f0fdfa !important;
        color: #00a896 !important;
        padding-left: 22px !important;
    }

    .custom-doc-dropdown .dropdown-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 6px 0;
        padding: 0;
    }

    /* Cleaner Dropdown & Logout Link */
    .custom-doc-dropdown .logout-link a {
        color: #ef4444 !important;
        font-weight: 700 !important;
    }

    .custom-doc-dropdown .logout-link a i {
        color: #ef4444 !important;
    }

    .custom-doc-dropdown .logout-link a:hover {
        background: #fef2f2 !important;
        color: #dc2626 !important;
    }

    /* Mobile Breakpoint Standardized Layout */
    .mobile-menu-toggle {
        display: none;
        background: transparent;
        border: none;
        color: #ffffff;
        font-size: 22px;
        cursor: pointer;
        padding: 6px 10px;
    }

    @media screen and (max-width: 768px) {
        .topbar {
            padding: 0 12px;
        }
        .profile-text-wrap {
            display: none;
        }
        .sitename {
            font-size: 18px;
        }
        .mobile-menu-toggle {
            display: block;
        }
    }
    </style>
</head>

<body class="sidebar-light fixed-topbar theme-sltl bg-light-dark color-default dashboard">
    <section>
        <div class="main-content" style="padding-top: 62px;">
            <!-- BEGIN TOPBAR -->
            <div class="topbar">
                <div class="header-left">
                    <div class="topnav">
                        <a class="MENUTOGGLE" href="#" data-toggle="sidebar-collapsed">
                            <span class="menu__handle"><span>Menu</span></span>
                        </a>
                    </div>
                    <div class="sitenameadjeust">
                        <h3 class="sitename">UPCHAR</h3>
                        <p class="slowgon">Doctor Partner Workspace</p>            
                    </div>
                </div>

                <div class="header-right">	
                    <?php 
                    $profileimg = $this->db->select('drimage')->from('profile_dr')->where('user_id', $this->session->userdata('druserid'))->get()->row();
                    $img_src = ($profileimg && !empty($profileimg->drimage)) ? admin_url()."public/assets/upload/".$profileimg->drimage : base_url()."assets/images/user.jpg";
                    $doc_display_name = $this->session->userdata('drusername') ? 'Dr. ' . $this->session->userdata('drusername') : 'Dr. Anushka';
                    ?> 
                    <ul class="header-menu nav navbar-nav" id="desktopview" style="margin: 0;">
                        <!-- BEGIN USER DROPDOWN -->
                        <li class="dropdown" id="user-header">
                            <a href="#" class="dropdown-toggle profile-pill-trigger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="docProfileDropdownTrigger">
                                <div class="profile-avatar-wrap">
                                    <img src="<?=$img_src;?>" alt="Doctor Profile">
                                    <span class="profile-online-badge"></span>
                                </div>
                                <div class="profile-text-wrap">
                                    <span class="profile-doc-name"><?=$doc_display_name;?></span>
                                    <span class="profile-doc-role">Clinical Practitioner</span>
                                </div>
                                <i class="fa fa-angle-down" style="color: rgba(255,255,255,0.85); font-size: 13px; margin-left: 2px;"></i>
                            </a>
                            
                            <ul class="dropdown-menu custom-doc-dropdown" id="docProfileDropdownMenu">
                                <!-- Header inside dropdown -->
                                <li class="dropdown-header-card">
                                    <div style="font-weight: 800; color: #0f172a; font-size: 14px;"><?=$doc_display_name;?></div>
                                    <div style="font-size: 11.5px; color: #00a896; font-weight: 700; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
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
                        </li>
                        <!-- END USER DROPDOWN -->
                    </ul>
                </div>
            </div>
            <!-- END TOPBAR -->

<script>
$(document).ready(function() {
    $('#docProfileDropdownTrigger').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var menu = $(this).siblings('#docProfileDropdownMenu');
        $('.dropdown-menu').not(menu).hide();
        menu.toggle();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#user-header').length) {
            $('#docProfileDropdownMenu').hide();
        }
    });
});
</script>