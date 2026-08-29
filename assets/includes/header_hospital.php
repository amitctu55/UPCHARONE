<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="admin-themes-lab">
    <meta name="author" content="themes-lab">
    <title>Hospital Panel | Upchar</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/cstm.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/theme.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/responsive.css" rel="stylesheet"> 
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/font-awesome.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/dummy.css" rel="stylesheet">
	<link href="<?=base_url();?>assets/css/style.css" rel="stylesheet">
<style>
/* ==========================================================================
   HOSPITAL PANEL UNIFIED LAYOUT & MODERN TOPBAR
   ========================================================================== */

/* 1. Header & Topbar Fixed Alignment */
.topbar, .header-navbar {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 60px !important;
    z-index: 1030 !important;
    background: linear-gradient(135deg, #043d5b 0%, #006d64 100%) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.18) !important;
    margin: 0 !important;
    padding: 0 20px !important;
}

/* 2. Sidebar Aligned Under Topbar */
.sidebar {
    position: fixed !important;
    top: 60px !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 250px !important;
    z-index: 1020 !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    -webkit-overflow-scrolling: touch !important;
    scrollbar-width: thin !important;
    scrollbar-color: rgba(255, 255, 255, 0.25) transparent !important;
    background: #043d5b !important;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.08) !important;
}

.sidebar::-webkit-scrollbar {
    width: 5px;
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.25);
    border-radius: 4px;
}

/* 3. Main Content Container beside Sidebar and below Header */
.main-content {
    margin-top: 60px !important;
    margin-left: 250px !important;
    width: calc(100% - 250px) !important;
    min-height: calc(100vh - 60px) !important;
    display: flex !important;
    flex-direction: column !important;
    background: #f8fafc !important;
    padding: 0 !important;
    position: relative !important;
}

.page-content, .pag_cstm {
    flex: 1 0 auto !important;
    padding: 0 !important;
    min-height: calc(100vh - 120px) !important;
}

/* 4. Sticky Footer */
.footer {
    margin-top: auto !important;
    padding: 15px 24px !important;
    background: #ffffff !important;
    border-top: 1px solid #e2e8f0 !important;
    z-index: 1010 !important;
}

/* 5. Prevent Dropdown & Popover Window Clipping */
.card, .panel, .filter-section, .filter-card, .table-card, .pag_cstm_panel, .detail-card, .boxBack, .opd-form-card, .adddoc-form-card {
    overflow: visible !important;
}

.table-responsive {
    overflow-x: auto !important;
    overflow-y: visible !important;
    position: relative !important;
}

/* Topbar Brand & Toggle */
.header-left-wrap {
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-toggle-btn {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
    padding: 7px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
    text-decoration: none !important;
}

.header-toggle-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
}

.header-hospital-title {
    font-size: 16.5px;
    font-weight: 800;
    color: #ffffff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: 0.2px;
    white-space: nowrap;
}

.badge-portal {
    background: rgba(45, 212, 191, 0.2);
    border: 1px solid #2dd4bf;
    color: #2dd4bf;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Topbar Right Actions */
.header-right-wrap {
    display: flex;
    align-items: center;
    gap: 14px;
}

.btn-header-opd {
    background: #00a896;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 12.5px;
    padding: 7px 15px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.15s ease;
}

.btn-header-opd:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.35);
}

/* Modern Profile Dropdown */
.profile-dropdown-container {
    position: relative;
}

.profile-trigger-btn {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    padding: 5px 14px 5px 6px;
    border-radius: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.15s ease;
}

.profile-trigger-btn:hover, .profile-dropdown-container.open .profile-trigger-btn {
    background: rgba(255, 255, 255, 0.22);
    border-color: rgba(255, 255, 255, 0.4);
}

.profile-thumb-img {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #2dd4bf;
    background: #ffffff;
}

.profile-trigger-text {
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
    max-width: 140px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.profile-chevron {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.7);
    margin-left: 2px;
}

/* Dropdown Menu Card */
.profile-dropdown-menu {
    position: absolute;
    top: 50px;
    right: 0;
    width: 250px;
    background: #ffffff !important;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18) !important;
    padding: 8px 0;
    display: none;
    z-index: 1050 !important;
    list-style: none;
    margin: 0;
}

.profile-dropdown-container.open .profile-dropdown-menu,
.profile-dropdown-container:hover .profile-dropdown-menu {
    display: block;
}

.dropdown-user-header {
    padding: 12px 18px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 4px;
}

.dropdown-user-header strong {
    display: block;
    font-size: 13.5px;
    font-weight: 800;
    color: #043d5b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dropdown-user-header span {
    font-size: 11.5px;
    color: #0d9488;
    font-weight: 600;
}

.profile-menu-item {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 10px 18px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #334155 !important;
    text-decoration: none !important;
    background: transparent !important;
    transition: all 0.15s ease !important;
    border-radius: 0 !important;
}

.profile-menu-item i {
    width: 18px;
    font-size: 14px;
    color: #00a896;
    text-align: center;
}

.profile-menu-item:hover {
    background: #f8fafc !important;
    color: #043d5b !important;
    padding-left: 22px !important;
}

.profile-menu-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 6px 0;
}

.profile-menu-logout {
    color: #ef4444 !important;
}

.profile-menu-logout i {
    color: #ef4444 !important;
}

.profile-menu-logout:hover {
    background: #fef2f2 !important;
    color: #dc2626 !important;
}

/* Responsive Breakpoints */
@media screen and (max-width: 991px) {
    .sidebar {
        left: -250px !important;
        transition: left 0.25s ease-in-out !important;
    }
    .sidebar.sidebar-open, .sidebar-condensed .sidebar {
        left: 0 !important;
    }
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }
    .btn-header-opd {
        display: none !important;
    }
}
</style>
</head>
<body class="sidebar-light fixed-topbar theme-sltl bg-light-dark color-default dashboard">

<section>
	<div class="main-content">
        <!-- BEGIN TOPBAR -->
        <header class="topbar">
			<div class="header-left-wrap">
				<a class="header-toggle-btn menutoggle" href="#" data-toggle="sidebar-collapsed" title="Toggle Navigation Sidebar">
                    <i class="fa fa-bars"></i>
				</a>
                <div class="header-hospital-title">
                    <i class="fa fa-hospital-o" style="color: #2dd4bf;"></i>
                    <span><?=html_escape($this->session->userdata('hospitalname') ?: 'Upchar Hospital Portal');?></span>
                    <span class="badge-portal hidden-xs">Hospital Portal</span>
                </div>
			</div>

			<!-- header-right -->
			<div class="header-right-wrap">
                <a href="<?=base_url('hospitalpanel/addappointment');?>" class="btn-header-opd">
                    <i class="fa fa-plus-circle"></i> Walk-in OPD
                </a>

                <?php 
                $this->db->select('drimage');
                $hosuid = $this->session->userdata('hosuserid');
                $this->db->group_start()->where('uid', $hosuid)->or_where('id', $hosuid)->group_end();
                $profileimg = $this->db->get('hospital')->row();
                if($profileimg && !empty($profileimg->drimage)) {
                    $profileimg_url = admin_url()."public/assets/upload/".$profileimg->drimage;
                } else {
                    $profileimg_url = base_url()."assets/images/user.jpg";     
                }
                $hospName = $this->session->userdata('hospitalname') ?: 'Hospital Admin';
                ?>
                
                <!-- Modern Profile Dropdown -->
                <div class="profile-dropdown-container dropdown" id="user-header">
                    <a href="#" class="profile-trigger-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?=$profileimg_url;?>" class="profile-thumb-img" alt="Hospital Profile">
                        <span class="profile-trigger-text hidden-xs"><?=$hospName;?></span>
                        <i class="fa fa-chevron-down profile-chevron"></i>
                    </a>
                    <div class="profile-dropdown-menu dropdown-menu">
                        <div class="dropdown-user-header">
                            <strong><?=$hospName;?></strong>
                            <span><i class="fa fa-check-circle"></i> Administrator</span>
                        </div>
                        <a class="profile-menu-item" href="<?=base_url('hospitalpanel/updateprofile');?>">
                            <i class="fa fa-hospital-o"></i> Hospital Profile
                        </a>
                        <a class="profile-menu-item" href="<?=base_url('hospitalpanel/manageappointment');?>">
                            <i class="fa fa-calendar"></i> OPD Appointments
                        </a>
                        <a class="profile-menu-item" href="<?=base_url('hospitalpanel/managedoctor');?>">
                            <i class="fa fa-user-md"></i> Manage Doctors
                        </a>
                        <a class="profile-menu-item" href="<?=base_url('hospitalpanel/earnings');?>">
                            <i class="fa fa-line-chart"></i> Revenue &amp; Payouts
                        </a>
                        <a class="profile-menu-item" href="<?=base_url('hospitalpanel/change_password');?>">
                            <i class="fa fa-key"></i> Change Password
                        </a>
                        <div class="profile-menu-divider"></div>
                        <a class="profile-menu-item profile-menu-logout" href="<?=base_url('hospitaluser/logout');?>">
                            <i class="fa fa-sign-out"></i> Sign Out
                        </a>
                    </div>
                </div>
			</div>
        </header>
		<!-- END TOPBAR -->
		<!-- BEGIN PAGE CONTENT -->

