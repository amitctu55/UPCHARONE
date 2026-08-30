<?php
$seg1 = $this->uri->segment(1);
$seg2 = $this->uri->segment(2);

$isDashboard   = ($seg1 == 'hospital-dashboard' || ($seg1 == 'hospitalpanel' && ($seg2 == 'dashboard' || $seg2 == '')));
$isProfile     = ($seg1 == 'hospitalpanel' && in_array($seg2, array('updateprofile', 'change_password')));
$isDoc         = ($seg1 == 'hospitalpanel' && in_array($seg2, array('managedoctor', 'adddoctor', 'editdoctor')));
$isApt         = ($seg1 == 'hospitalpanel' && in_array($seg2, array('manageappointment', 'addappointment', 'viewappointment')));
$isDocList     = ($seg1 == 'hospitalpanel' && $seg2 == 'doctorlist');
$isReport      = ($seg1 == 'hospitalpanel' && $seg2 == 'report');
$isGalleryOpen = ($seg1 == 'hospitalpanel' && in_array($seg2, array('gallery', 'managegallery')));
$isBiomed      = ($seg1 == 'hospitalpanel' && $seg2 == 'biomedical');
$isNewsOpen    = ($seg1 == 'hospitalpanel' && in_array($seg2, array('news', 'managenews')));
$isBedMatrix   = ($seg1 == 'hospitalpanel' && $seg2 == 'bed_matrix');
$isAdmissions  = ($seg1 == 'hospitalpanel' && in_array($seg2, array('admissions', 'add_admission')));
$isEarnings    = ($seg1 == 'hospitalpanel' && in_array($seg2, array('earnings', 'invoice_view')));
$isPackage     = ($seg1 == 'hospitalpanel' && $seg2 == 'package');
$isBed         = ($seg1 == 'hospitalpanel' && in_array($seg2, array('bed', 'addbed', 'editbed')));
$isSupport     = ($seg1 == 'hospitalpanel' && in_array($seg2, array('support', 'create_ticket', 'ticket_view')));
?>

<aside class="sidebar">
  <div class="logopanel">
    <div class="logopanel"> 		
      <a href="<?=base_url('hospital-dashboard');?>"><img src="<?=base_url();?>images/logo.png" type="image/gif" style="width:42px;margin: 22px auto;display:block;"></a>
    </div>
  </div>
  <div class="sidebar-inner">
    <ul class="nav nav-sidebar">
      <li class="<?=$isDashboard ? 'active' : '';?>"><a href="<?=base_url();?>hospital-dashboard"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
      <li class="<?=$isProfile ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/updateprofile"><i class="fa fa-hospital-o" aria-hidden="true"></i><span>Hospital Profile</span></a></li>
      <li class="<?=$isDoc ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/managedoctor"><i class="fa fa-user-md" aria-hidden="true"></i><span>Manage Doctors</span></a></li>
      <li class="<?=$isApt ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/manageappointment"><i class="fa fa-calendar" aria-hidden="true"></i><span>Manage Appointment</span></a></li>
      <li class="<?=$isDocList ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/doctorlist"><i class="fa fa-stethoscope" aria-hidden="true"></i><span>Upchar Doctors</span></a></li>
      <li class="<?=$isReport ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/report"><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Report</span></a></li>
      
      <!-- Gallery Management Submenu -->
      <li class="nav-item has-submenu nav-parent <?=$isGalleryOpen ? 'active' : '';?>">
        <a class="nav-link submenu-toggle" href="javascript:void(0);">
          <i class="fa fa-picture-o" aria-hidden="true"></i>
          <span>Gallery Management</span>
          <i class="fa fa-chevron-right arrow-icon arrow pull-right float-end <?=$isGalleryOpen ? 'active' : '';?>" style="<?=$isGalleryOpen ? 'transform: rotate(90deg);' : '';?>"></i>
        </a>
        <ul class="submenu children list-unstyled ms-3 <?=$isGalleryOpen ? 'show' : 'collapse';?>" style="<?=$isGalleryOpen ? 'display: block;' : '';?>">
          <li class="<?=($seg2 == 'gallery') ? 'active' : '';?>"><a class="nav-link" href="<?=base_url();?>hospitalpanel/gallery"><i class="fa fa-cloud-upload" aria-hidden="true"></i><span>Upload Photo</span></a></li>
          <li class="<?=($seg2 == 'managegallery') ? 'active' : '';?>"><a class="nav-link" href="<?=base_url();?>hospitalpanel/managegallery"><i class="fa fa-th-large" aria-hidden="true"></i><span>Gallery Showcase</span></a></li>
        </ul>
      </li>

      <li class="<?=$isBiomed ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/biomedical"><i class="fa fa-cogs" aria-hidden="true"></i><span>Biomedical Equipment</span></a></li>

      <!-- News Management Submenu -->
      <li class="nav-item has-submenu nav-parent <?=$isNewsOpen ? 'active' : '';?>">
        <a class="nav-link submenu-toggle" href="javascript:void(0);">
          <i class="fa fa-newspaper-o" aria-hidden="true"></i>
          <span>News Management</span>
          <i class="fa fa-chevron-right arrow-icon arrow pull-right float-end <?=$isNewsOpen ? 'active' : '';?>" style="<?=$isNewsOpen ? 'transform: rotate(90deg);' : '';?>"></i>
        </a>
        <ul class="submenu children list-unstyled ms-3 <?=$isNewsOpen ? 'show' : 'collapse';?>" style="<?=$isNewsOpen ? 'display: block;' : '';?>">
          <li class="<?=($seg2 == 'news') ? 'active' : '';?>"><a class="nav-link" href="<?=base_url();?>hospitalpanel/news"><i class="fa fa-plus-square-o" aria-hidden="true"></i><span>Post Announcement</span></a></li>
          <li class="<?=($seg2 == 'managenews') ? 'active' : '';?>"><a class="nav-link" href="<?=base_url();?>hospitalpanel/managenews"><i class="fa fa-bullhorn" aria-hidden="true"></i><span>News &amp; Updates</span></a></li>
        </ul>
      </li>

      <li class="<?=$isBedMatrix ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/bed_matrix"><i class="fa fa-bed" aria-hidden="true"></i><span>Bed Matrix (Live IPD)</span></a></li>
      <li class="<?=$isAdmissions ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/admissions"><i class="fa fa-user-plus" aria-hidden="true"></i><span>Inpatient Admissions</span></a></li>
      <li class="<?=$isEarnings ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/earnings"><i class="fa fa-line-chart" aria-hidden="true"></i><span>Revenue &amp; Payouts</span></a></li>
      <li class="<?=$isPackage ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/package"><i class="fa fa-heartbeat" aria-hidden="true"></i><span>Package Appointment</span></a></li>
      <li class="<?=$isBed ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/bed"><i class="fa fa-sliders" aria-hidden="true"></i><span>Manage Bed Setup</span></a></li>
      <li class="<?=$isSupport ? 'active' : '';?>"><a href="<?=base_url();?>hospitalpanel/support"><i class="fa fa-life-ring" aria-hidden="true"></i><span>Support &amp; Helpdesk</span></a></li>
    </ul>
  </div>
</aside>

<!-- BEGIN MAIN CONTENT (Direct Flexbox Child) -->
<main class="main-content" id="content">