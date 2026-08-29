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
   HOSPITAL PANEL UNIFIED LAYOUT & DROPDOWN ALIGNMENT
   ========================================================================== */

/* 1. Header & Topbar Fixed Alignment */
.topbar, .header-navbar {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 60px !important;
    z-index: 1030 !important;
    background: #043d5b !important;
    display: flex !important;
    align-items: center !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
    margin: 0 !important;
    padding: 0 15px !important;
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
    background: #295771 !important;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05) !important;
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

.select2-container--open, .dropdown-menu {
    z-index: 1050 !important;
}

/* Topbar Header elements styling */
.navbar-toggle {
    position: relative;
    float: right;
    padding: 9px 10px;
    margin: 8px 15px 8px 0;
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 4px;
}

.navbar-nav>li>a {
    padding: 6px 12px;
    color: #ffffff;
}

.topmenu {
    font-size: 14px;
    text-transform: uppercase;
    background: #ed3237;
    font-weight: bold;
    color: #ffffff;
    border-radius: 4px;
    margin-right: 3px;
}

.dropdown-menu>li>a {
    display: block;
    padding: 8px 18px;
    clear: both;
    font-weight: 500;
    color: #0f172a;
    background: #ffffff;
    text-decoration: none;
}

.dropdown-menu>li>a:hover {
    background: #f1f5f9;
    color: #00a896;
}

.mynavback {
    background: none;
    margin-bottom: 0;
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
}
</style>
</head>
<body class="sidebar-light fixed-topbar theme-sltl bg-light-dark color-default dashboard">
<!---------------------------------------practice_suggestion_hospital_step6 modal open--------------------------------------------->
<div class="hover_bkgr_fricc" style="display:none;">
    <span class="helper"></span>
    <div>
        <div class="prc_sugg"><p>Claim Clinic</p></div>
		<div class="prce_suge_useranme"><p>Are you sure you want to claim profile named as "Gayatri Nursing Home Pvt. Ltd."?</p></div>
		<div class="prce_suge"><p><b>Note:</b> Request you to provide the proof of clinic ownership to ascertain your credentials.</p></div>
		<a href="#" class="Pra_sug">Cancel</a>
		<a href="#" class="Pra_sug_clai">Claim Clinic</a>
    </div>
</div>
<!---------------------------------------practice_suggestion_hospital_step6 modal close--------------------------------------------->
<div class="hover_bkgr_fricc_practics" style="display:none;">
    <span class="helper"></span>
    <div>
        <div class="prc_sugg"><p></p></div>
		<div class="prce_suge_useranme"></div>
		<div class="prce_suge"><p><b>Note:</b> Request you to provide the proof of clinic ownership to ascertain your credentials.</p></div>
		<a href="#" class="Pra_sug">Cancel</a>
		<a href="#" class="Pra_sug_clai">Claim Clinic</a>
    </div>
</div>
<!---------------------------------------practice_start modal close--------------------------------------------->
<section>
    <!-- BEGIN SIDEBAR -->
    <!-- END SIDEBAR -->
	<div class="main-content">
        <!-- BEGIN TOPBAR -->
        <div class="topbar">
			<div class="header-left">
				<div class="topnav">
					<a class="menutoggle" href="#" data-toggle="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>
				</div>
			</div>
            <h3 style="text-shadow: 0px -4px 3px black;color:white;margin-left:79px;"> <?=$this->session->userdata('hospitalname');?></h3>
			<!-- header-right -->
			<nav class="navbar mynavback">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar" style="background:white;"></span>
							<span class="icon-bar" style="background:white;"></span>
							<span class="icon-bar" style="background:white;"></span>                        
						</button>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<ul class="header-menu nav navbar-nav">
									<?php 
									$this->db->select('drimage');
									$hosuid = $this->session->userdata('hosuserid');
									$this->db->group_start()->where('uid', $hosuid)->or_where('id', $hosuid)->group_end();
									$profileimg = $this->db->get('hospital')->row();
									if($profileimg)
									{
										$profileimg = $profileimg->drimage;
										$profileimg=admin_url()."public/assets/upload/".$profileimg;
									}    
									else
									{
										$profileimg=base_url()."/assets/images/user.jpg";     
									}
									?>
									<li class="dropdown" id="user-header">
										<a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
											<img id="userimgcss" src="<?=$profileimg;?>" alt="user image">
											<span class="username" style="color:white;"><?=$this->session->userdata('hospitalname');?><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
										</a>
										<ul class="dropdown-menu" style="background:none;box-shadow:none;border:none;">
											<li ><a class="menutab" href="<?=base_url();?>hospitalpanel/updateprofile">My Profile </a></li>
											<!-- <li><a class="menutab" href="#"><span>My Medicine Order</span></a></li> -->
											<li><a class="menutab" href="#"><span>My Online Consultation</span></a></li>
											<li><a class="menutab" href="#"><span>My Feedback</span></a></li>
											<li><a class="menutab" href="#"><span>My Payments</span></a></li>
											<li ><a class="menutab" href="<?=base_url();?>hospitalpanel/updateprofile">Update Profile </a></li>
											<li><a class="menutab" href="<?=base_url();?>hospitalpanel/change_password"><span>Change Password</span></a></li>
											<li><a class="menutab" href="#"><span>Setting</span></a></li>
											<li><a class="menutab" href="<?=base_url();?>hospitaluser/logout"><span>Logout</span></a></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
        </div>
		<!-- END TOPBAR -->
		<!-- BEGIN PAGE CONTENT -->

