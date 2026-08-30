<?php
$seg1 = $this->uri->segment(1);
$seg2 = $this->uri->segment(2);

$isDashboard   = ($seg1 == 'doctor-dashboard' || ($seg1 == 'doctorpanel' && ($seg2 == 'dashboard' || $seg2 == '')));
$isProfile     = ($seg1 == 'doctorpanel' && in_array($seg2, array('updateprofile', 'change_password')));
$isProfileStep = in_array($seg1, array('profile_step1', 'profile_step2', 'profile_step3', 'profile_step4', 'profile_step5', 'profile_step6', 'profile_step7', 'profile_step8', 'profile_step9', 'profile_step10'));
$isClinic      = ($seg1 == 'manageownclinic');
$isPractice    = ($seg1 == 'managepractice');
$isApt         = ($seg1 == 'manageappointment' || ($seg1 == 'doctorpanel' && in_array($seg2, array('manageappointment', 'addappointment', 'viewappointment'))));
$isEarnings    = ($seg1 == 'doctorpanel' && in_array($seg2, array('earnings', 'invoice_view')));
$isGalleryOpen = ($seg1 == 'doctorpanel' && in_array($seg2, array('gallery', 'managegallery')));
$isDateTime    = ($seg1 == 'doctorpanel' && $seg2 == 'datetime');
$isUpcharHosp  = ($seg1 == 'doctorpanel' && $seg2 == 'upcharhospital');
$isNewsOpen    = ($seg1 == 'doctorpanel' && in_array($seg2, array('news', 'managenews')));
?>

<div class="sidebar">
  <div class="logopanel">
    <div class="logopanel"> 		
      <a href="<?=base_url('doctor-dashboard');?>"><img src="<?=base_url();?>images/logo.png" type="image/gif" style="width:42px;margin: 38px 39%;"></a>
    </div>
  </div>
  <div class="sidebar-inner">
    <ul class="nav nav-sidebar">
      <li class="<?=$isDashboard ? 'active' : '';?>"><a href="<?=base_url();?>doctor-dashboard"><i class="fa fa-user-md"></i><span>Dashboard</span></a></li>
      <li class="<?=$isProfile ? 'active' : '';?>"><a href="<?=base_url();?>doctorpanel/updateprofile"><i class="fa fa-pencil-square-o"></i><span>Update Profile</span></a></li>
      <li class="<?=$isProfileStep ? 'active' : '';?>"><a href="<?=base_url();?>profile_step1"><i class="fa fa-id-card-o"></i><span>Manage Profile</span></a></li>
      <li class="<?=$isClinic ? 'active' : '';?>"><a href="<?=base_url();?>manageownclinic"><i class="fa fa-hospital-o" aria-hidden="true"></i><span>Manage Own Clinic</span></a></li>
      <li class="<?=$isPractice ? 'active' : '';?>"><a href="<?=base_url();?>managepractice"><i class="fa fa-medkit" aria-hidden="true"></i><span>Manage Practice</span></a></li>
      <li class="<?=$isApt ? 'active' : '';?>"><a href="<?=base_url();?>manageappointment"><i class="fa fa-calendar" aria-hidden="true"></i><span>Manage Appointment</span></a></li>
      <li class="<?=$isEarnings ? 'active' : '';?>"><a href="<?=base_url();?>doctorpanel/earnings"><i class="fa fa-line-chart" aria-hidden="true"></i><span>Earnings &amp; Payouts</span></a></li>
      
      <!-- Gallery Management Submenu -->
      <li class="nav-parent <?=$isGalleryOpen ? 'active' : '';?>">
        <a href="#"><i class="fa fa-picture-o" aria-hidden="true"></i><span>Gallery Management</span><span class="fa arrow <?=$isGalleryOpen ? 'active' : '';?>"></span></a>
        <ul class="children <?=$isGalleryOpen ? '' : 'collapse';?>" style="<?=$isGalleryOpen ? 'display: block;' : '';?>">
          <li class="<?=($seg2 == 'gallery') ? 'active' : '';?>"><a href="<?=base_url();?>doctorpanel/gallery"><i class="fa fa-cloud-upload" aria-hidden="true"></i><span>Upload Photo</span></a></li>
          <li class="<?=($seg2 == 'managegallery') ? 'active' : '';?>"><a href="<?=base_url();?>doctorpanel/managegallery"><i class="fa fa-th-large" aria-hidden="true"></i><span>Gallery Showcase</span></a></li>
        </ul>
      </li>

      <li class="<?=$isDateTime ? 'active' : '';?>"><a href="<?=base_url();?>doctorpanel/datetime"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Date &amp; Time</span></a></li>
      <li class="<?=$isUpcharHosp ? 'active' : '';?>"><a href="<?=base_url();?>doctorpanel/upcharhospital"><i class="fa fa-building-o" aria-hidden="true"></i><span>Upchar Hospital</span></a></li>

      <!-- News Management Submenu -->
      <li class="nav-parent <?=$isNewsOpen ? 'active' : '';?>">
        <a href="#"><i class="fa fa-newspaper-o" aria-hidden="true"></i><span>News Management</span><span class="fa arrow <?=$isNewsOpen ? 'active' : '';?>"></span></a>
        <ul class="children <?=$isNewsOpen ? '' : 'collapse';?>" style="<?=$isNewsOpen ? 'display: block;' : '';?>">
          <li class="<?=($seg2 == 'news') ? 'active' : '';?>"><a href="<?=base_url();?>doctorpanel/news"><i class="fa fa-plus-square-o" aria-hidden="true"></i><span>Post Article</span></a></li>
          <li class="<?=($seg2 == 'managenews') ? 'active' : '';?>"><a href="<?=base_url();?>doctorpanel/managenews"><i class="fa fa-bullhorn" aria-hidden="true"></i><span>Manage News</span></a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>