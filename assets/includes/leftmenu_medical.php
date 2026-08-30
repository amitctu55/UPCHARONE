<?php
$seg1 = $this->uri->segment(1);
$seg2 = $this->uri->segment(2);

$isDashboard = ($seg1 == 'medical-dashboard' || ($seg1 == 'medicalpanel' && ($seg2 == 'dashboard' || $seg2 == '')));
$isProfile   = ($seg1 == 'medicalpanel' && in_array($seg2, array('updateprofile', 'change_password')));
$isDoc       = ($seg1 == 'medicalpanel' && in_array($seg2, array('managedoctor', 'adddoctor', 'editdoctor')));
$isApt       = ($seg1 == 'medicalpanel' && in_array($seg2, array('manageappointment', 'addappointment', 'viewappointment')));
$isDocList   = ($seg1 == 'medicalpanel' && $seg2 == 'doctorlist');
$isReport    = ($seg1 == 'medicalpanel' && $seg2 == 'report');
$isGallery   = ($seg1 == 'medicalpanel' && in_array($seg2, array('gallery', 'managegallery')));
?>

<div class="sidebar">
  <div class="logopanel">
    <div class="logopanel"> 		
      <a href="<?=base_url('medical-dashboard');?>"><img src="<?=base_url();?>images/logo.png" type="image/gif" style="width:42px;margin: 0px 39%;"></a>
    </div>
  </div>
  <div class="sidebar-inner">
    <ul class="nav nav-sidebar">
      <li class="<?=$isDashboard ? 'active' : '';?>"><a href="<?=base_url();?>medical-dashboard"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
      <li class="<?=$isProfile ? 'active' : '';?>"><a href="<?=base_url();?>medicalpanel/updateprofile"><i class="fa fa-medkit" aria-hidden="true"></i><span>Medical Profile</span></a></li>
      <li class="<?=$isDoc ? 'active' : '';?>"><a href="<?=base_url();?>medicalpanel/managedoctor"><i class="fa fa-user-md" aria-hidden="true"></i><span>Manage Doctors</span></a></li>
      <li class="<?=$isApt ? 'active' : '';?>"><a href="<?=base_url();?>medicalpanel/manageappointment"><i class="fa fa-calendar" aria-hidden="true"></i><span>Manage Appointment</span></a></li>
      <li class="<?=$isDocList ? 'active' : '';?>"><a href="<?=base_url();?>medicalpanel/doctorlist"><i class="fa fa-stethoscope" aria-hidden="true"></i><span>Upchar Doctors</span></a></li>
      <li class="<?=$isReport ? 'active' : '';?>"><a href="<?=base_url();?>medicalpanel/report"><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Report</span></a></li>
      <li class="<?=$isGallery ? 'active' : '';?>"><a href="<?=base_url();?>medicalpanel/gallery"><i class="fa fa-picture-o" aria-hidden="true"></i><span>Gallery</span></a></li>
    </ul>
  </div>
</div>