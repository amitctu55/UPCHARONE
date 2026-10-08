<?php
$seg1 = $this->uri->segment(1);
$seg2 = $this->uri->segment(2);

$isDashboard   = ($seg1 == 'doctor-dashboard' || ($seg1 == 'doctorpanel' && ($seg2 == 'dashboard' || $seg2 == '')));
$isProfile     = ($seg1 == 'doctorpanel' && $seg2 == 'updateprofile');
$isSecurity    = ($seg1 == 'doctorpanel' && $seg2 == 'change_password');
$isProfileStep = in_array($seg1, array('profile_step1', 'profile_step2', 'profile_step3', 'profile_step4', 'profile_step5', 'profile_step6', 'profile_step7', 'profile_step8', 'profile_step9', 'profile_step10', 'profile_about', 'profile_drpic', 'profile_idproof', 'mci_proof', 'profile_regproof'));
$isClinic      = ($seg1 == 'manageownclinic');
$isPractice    = ($seg1 == 'managepractice');
$isApt         = ($seg1 == 'manageappointment' || ($seg1 == 'doctorpanel' && in_array($seg2, array('manageappointment', 'addappointment', 'viewappointment', 'prescription'))));
$isDiet        = ($seg1 == 'diet');
$isEarnings    = ($seg1 == 'doctorpanel' && in_array($seg2, array('earnings', 'invoice_view')));
$isGalleryOpen = ($seg1 == 'doctorpanel' && in_array($seg2, array('gallery', 'managegallery')));
$isDateTime    = ($seg1 == 'doctorpanel' && $seg2 == 'datetime');
$isUpcharHosp  = ($seg1 == 'doctorpanel' && $seg2 == 'upcharhospital');
$isNewsOpen    = ($seg1 == 'doctorpanel' && in_array($seg2, array('news', 'managenews')));
?>

<aside class="sidebar">
  <div class="sidebar-inner">
    
    <!-- 1. Main Workspace -->
    <div class="sidebar-group-title">Main Workspace</div>
    <ul class="nav nav-sidebar">
      <li class="<?=$isDashboard ? 'active' : '';?>">
        <a href="<?=base_url('doctor-dashboard');?>" title="Main Dashboard">
          <i class="fa fa-th-large"></i><span>Dashboard</span>
        </a>
      </li>
    </ul>

    <!-- 2. Schedule & Timings -->
    <div class="sidebar-group-title">Schedule &amp; Timings</div>
    <ul class="nav nav-sidebar">
      <li class="<?=$isDateTime ? 'active' : '';?>">
        <a href="<?=base_url('doctorpanel/datetime');?>" title="Clinical Practice Timings & Slots">
          <i class="fa fa-clock-o"></i><span>Clinical Practice</span>
        </a>
      </li>
      <li class="<?=$isApt ? 'active' : '';?>">
        <a href="<?=base_url('manageappointment');?>" title="Patient Appointments & OPD Queue">
          <i class="fa fa-calendar-check-o"></i><span>Appointments &amp; Queue</span>
        </a>
      </li>
    </ul>

    <!-- 3. Manage Own Clinic -->
    <div class="sidebar-group-title">Manage Own Clinic</div>
    <ul class="nav nav-sidebar">
      <li class="<?=$isClinic ? 'active' : '';?>">
        <a href="<?=base_url('manageownclinic');?>" title="Manage Private Clinics & Chambers">
          <i class="fa fa-hospital-o"></i><span>Own Clinic Chambers</span>
        </a>
      </li>
      <li class="<?=$isPractice ? 'active' : '';?>">
        <a href="<?=base_url('managepractice');?>" title="Practice Setup & Consultation Fees">
          <i class="fa fa-medkit"></i><span>Practice Setup &amp; Fees</span>
        </a>
      </li>
    </ul>

    <!-- 4. Visiting Hospitals -->
    <div class="sidebar-group-title">Visiting Hospitals</div>
    <ul class="nav nav-sidebar">
      <li class="<?=$isUpcharHosp ? 'active' : '';?>">
        <a href="<?=base_url('doctorpanel/upcharhospital');?>" title="Affiliated Hospitals & Partner Network">
          <i class="fa fa-building-o"></i><span>Affiliated Hospitals</span>
        </a>
      </li>
      <li class="<?=$isDiet ? 'active' : '';?>">
        <a href="<?=base_url('diet');?>" title="Patient Care, Diet & Nutrition Telemetry">
          <i class="fa fa-cutlery" style="color: #2dd4bf;"></i>
          <span>Diet Tracker</span>
          <span class="menu-badge-ehr">EHR</span>
        </a>
      </li>
    </ul>

    <!-- 5. Financials & Media -->
    <div class="sidebar-group-title">Financials &amp; Media</div>
    <ul class="nav nav-sidebar">
      <li class="<?=$isEarnings ? 'active' : '';?>">
        <a href="<?=base_url('doctorpanel/earnings');?>" title="Escrow Ledger & Payouts">
          <i class="fa fa-line-chart"></i><span>Earnings &amp; Payouts</span>
        </a>
      </li>
      
      <!-- Media Gallery Submenu -->
      <li class="nav-item has-submenu nav-parent <?=$isGalleryOpen ? 'active' : '';?>">
        <a href="#" class="submenu-toggle" title="Media Gallery">
          <i class="fa fa-picture-o"></i><span>Media Gallery</span>
          <i class="fa fa-angle-right arrow-icon" style="<?=$isGalleryOpen ? 'transform: rotate(90deg);' : '';?>"></i>
        </a>
        <ul class="children submenu <?=$isGalleryOpen ? '' : 'collapse';?>" style="<?=$isGalleryOpen ? 'display: block;' : 'display: none;';?>">
          <li class="<?=($seg2 == 'gallery') ? 'active' : '';?>">
            <a href="<?=base_url('doctorpanel/gallery');?>"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></a>
          </li>
          <li class="<?=($seg2 == 'managegallery') ? 'active' : '';?>">
            <a href="<?=base_url('doctorpanel/managegallery');?>"><i class="fa fa-th-large"></i><span>Gallery Showcase</span></a>
          </li>
        </ul>
      </li>

      <!-- Health Articles Submenu -->
      <li class="nav-item has-submenu nav-parent <?=$isNewsOpen ? 'active' : '';?>">
        <a href="#" class="submenu-toggle" title="Health Articles & Updates">
          <i class="fa fa-newspaper-o"></i><span>Health Articles</span>
          <i class="fa fa-angle-right arrow-icon" style="<?=$isNewsOpen ? 'transform: rotate(90deg);' : '';?>"></i>
        </a>
        <ul class="children submenu <?=$isNewsOpen ? '' : 'collapse';?>" style="<?=$isNewsOpen ? 'display: block;' : 'display: none;';?>">
          <li class="<?=($seg2 == 'news') ? 'active' : '';?>">
            <a href="<?=base_url('doctorpanel/news');?>"><i class="fa fa-plus-square-o"></i><span>Post Article</span></a>
          </li>
          <li class="<?=($seg2 == 'managenews') ? 'active' : '';?>">
            <a href="<?=base_url('doctorpanel/managenews');?>"><i class="fa fa-bullhorn"></i><span>Manage Articles</span></a>
          </li>
        </ul>
      </li>
    </ul>

    <!-- 6. Settings & Profile -->
    <div class="sidebar-group-title">Settings &amp; Profile</div>
    <ul class="nav nav-sidebar">
      <li class="<?=$isProfile ? 'active' : '';?>">
        <a href="<?=base_url('doctorpanel/updateprofile');?>" title="Doctor Profile & Bio">
          <i class="fa fa-user-md"></i><span>Doctor Profile</span>
        </a>
      </li>
      <li class="<?=$isProfileStep ? 'active' : '';?>">
        <a href="<?=base_url('profile_step1');?>" title="Medical Registration & Verification Steps">
          <i class="fa fa-id-card-o"></i><span>Verification Steps</span>
        </a>
      </li>
      <li class="<?=$isSecurity ? 'active' : '';?>">
        <a href="<?=base_url('doctorpanel/change_password');?>" title="Security & Change Password">
          <i class="fa fa-lock" style="color: #f59e0b;"></i><span>Security &amp; Password</span>
        </a>
      </li>
      <li>
        <a href="<?=base_url('doctoruser/logout');?>" title="Sign Out of Doctor Portal" style="color: #f87171;">
          <i class="fa fa-sign-out" style="color: #ef4444;"></i><span style="color: #fca5a5;">Logout Portal</span>
        </a>
      </li>
    </ul>

  </div>
</aside>

<!-- BEGIN MAIN CONTENT (Direct Side-by-Side Flex Child, Z-Index: 1) -->
<main class="main-content" id="content">