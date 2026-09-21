<?php
$pageurl1 = $this->uri->segment(1);
$pageurl2 = $this->uri->segment(2);
$pageurl3 = $this->uri->segment(3);

// Keep signed admin bridge token active for seamless navigation into enterprise modules
if ($this->session->userdata('adminuserid') || $this->session->userdata('userid')) {
    $currAid = $this->session->userdata('adminuserid') ?: $this->session->userdata('userid');
    $currUname = $this->session->userdata('username') ?: 'Super Admin';
    $guardPayload = [
        'adminuserid' => $currAid,
        'username'    => $currUname,
        'role'        => 'super_admin',
        'time'        => time(),
        'sig'         => hash_hmac('sha256', $currAid . '|' . $currUname . '|super_admin', 'UpcharMasterAdminSecret2026')
    ];
    @setcookie('upchar_admin_guard', base64_encode(json_encode($guardPayload)), time() + 86400, '/');
    echo '<script>try{document.cookie="upchar_admin_guard=' . base64_encode(json_encode($guardPayload)) . '; path=/; max-age=86400; SameSite=Lax";}catch(e){}</script>';
}

// Pre-calculate notification badges safely
$pending_contact_count = 0;
$pending_hosp_inqs = 0;
$pending_career_count = 0;
try {
    if ($this->db && $this->db->table_exists('contactus')) {
        $pending_contact_count = $this->db->where('status', 'PENDING')->count_all_results('contactus');
    }
    if ($this->db && $this->db->table_exists('inquiries')) {
        $pending_hosp_inqs = $this->db->where('status', 'pending')->count_all_results('inquiries');
    }
    if ($this->db && $this->db->table_exists('career')) {
        $pending_career_count = $this->db->where("status_stage = 'pending' OR status_stage = '' OR status_stage IS NULL", NULL, FALSE)->count_all_results('career');
    }
} catch (Throwable $e) {}
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url();?>public/assets/newpanel/dist/img/user2-160x160.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=$this->session->userdata('username') ?: 'Super Admin'?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      
      <!-- =========================================================
           1. CLINICAL & HEALTHCARE PROVIDERS
           ========================================================= -->
      <li class="header">CLINICAL MANAGEMENT</li>
      
      <!-- Dashboard -->
      <li class="<?php if($pageurl1=='masters' && ($pageurl2=='dashboard' || empty($pageurl2))){ ?>active<?php }?>">
        <a href="<?=base_url('masters/dashboard');?>">
          <i class="fa fa-dashboard" style="color: #38bdf8;"></i> <span>Dashboard</span>
        </a>
      </li>

      <!-- Doctors & Appointments -->
      <?php 
      $is_doctor_active = ($pageurl1 == 'doctor' && in_array($pageurl2, ['doctorview', 'doctorreg', 'appointment', 'doctoredit', 'doctoradd']));
      ?>
      <li class="treeview <?php if($is_doctor_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-user-md" style="color: #0284c7;"></i> <span>Doctor &amp; Appointments</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_doctor_active){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='doctorview'){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/doctorview');?>">
              <i class="fa fa-stethoscope"></i> View Doctors Directory
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && in_array($pageurl2, ['doctorreg', 'doctoradd'])){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/doctorreg');?>">
              <i class="fa fa-user-plus"></i> Register New Doctor
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='appointment' && in_array($pageurl3, ['doctorappointment', 'viewappointment', ''])){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/appointment/doctorappointment');?>">
              <i class="fa fa-calendar-check-o"></i> All Doctor Appointments
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='appointment' && $pageurl3=='todayappointment'){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/appointment/todayappointment');?>">
              <i class="fa fa-clock-o"></i> Today's Appointments
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='appointment' && $pageurl3=='analytics'){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/appointment/analytics');?>">
              <i class="fa fa-bar-chart"></i> Appointment Analytics
            </a>
          </li>
        </ul>
      </li>

      <!-- Hospitals & Clinics -->
      <?php 
      $is_clinic_active = ($pageurl1 == 'clinicreg' || ($pageurl1 == 'doctor' && $pageurl2 == 'clinicreg') || $pageurl1 == 'inquiries');
      ?>
      <li class="treeview <?php if($is_clinic_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-hospital-o" style="color: #00a896;"></i> <span>Clinics &amp; Hospitals</span>
          <span class="pull-right-container">
            <?php if($pending_hosp_inqs > 0): ?>
              <small class="label pull-right bg-yellow"><?=$pending_hosp_inqs;?></small>
            <?php else: ?>
              <i class="fa fa-angle-left pull-right"></i>
            <?php endif; ?>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_clinic_active){ ?> style="display: block;" <?php }?>>
          <li class="<?php if(($pageurl1=='clinicreg' && in_array($pageurl2, ['insert', 'add'])) || ($pageurl1=='doctor' && $pageurl2=='clinicreg' && in_array($pageurl3, ['insert', 'add']))){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/clinicreg/insert');?>">
              <i class="fa fa-plus-circle"></i> Add Clinic / Hospital
            </a>
          </li>
          <li class="<?php if(($pageurl1=='clinicreg' && in_array($pageurl2, ['viewhospital', 'viewclinic', 'hospitalview', 'clinicview', ''])) || ($pageurl1=='doctor' && $pageurl2=='clinicreg' && in_array($pageurl3, ['viewhospital', 'viewclinic', 'hospitalview', 'clinicview', '']))){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/clinicreg/viewhospital');?>">
              <i class="fa fa-list"></i> View Hospitals Directory
            </a>
          </li>
          <li class="<?php if(($pageurl1=='clinicreg' && $pageurl2=='assign_doctor') || ($pageurl1=='doctor' && $pageurl2=='clinicreg' && $pageurl3=='assign_doctor')){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/clinicreg/assign_doctor');?>">
              <i class="fa fa-user-plus"></i> Assign Doctor to Hospital
            </a>
          </li>
          <li class="<?php if(($pageurl1=='clinicreg' && $pageurl2=='hospital_doctor') || ($pageurl1=='doctor' && $pageurl2=='clinicreg' && $pageurl3=='hospital_doctor')){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/clinicreg/hospital_doctor');?>">
              <i class="fa fa-link"></i> Doctor-Hospital Links
            </a>
          </li>
          <li class="<?php if(($pageurl1=='clinicreg' && $pageurl2=='biomedicalmachine') || ($pageurl1=='doctor' && $pageurl2=='clinicreg' && $pageurl3=='biomedicalmachine')){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/clinicreg/biomedicalmachine');?>">
              <i class="fa fa-cogs"></i> Biomedical Equipment
            </a>
          </li>
          <li class="<?php if($pageurl1=='inquiries'){ ?>active<?php }?>">
            <a href="<?=base_url('inquiries');?>">
              <i class="fa fa-comments-o"></i> Hospital Inquiries
              <?php if($pending_hosp_inqs > 0): ?>
                <span class="label label-warning pull-right"><?=$pending_hosp_inqs;?></span>
              <?php endif; ?>
            </a>
          </li>
        </ul>
      </li>

      <!-- Pathology & Diagnostics -->
      <?php 
      $is_pathology_active = ($pageurl1 == 'doctor' && in_array($pageurl2, ['pathology', 'pathologytest', 'pathlabreg']));
      ?>
      <li class="treeview <?php if($is_pathology_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-flask" style="color: #ec4899;"></i> <span>Pathology &amp; Diagnostics</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_pathology_active){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='pathology' && $pageurl3=='dashboard'){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/pathology/dashboard');?>">
              <i class="fa fa-dashboard text-aqua"></i> Pathology Dashboard
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='pathlabreg'){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/pathlabreg/index');?>">
              <i class="fa fa-building text-green"></i> Partner Pathology Labs
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='pathology' && in_array($pageurl3, ['add', 'insert'])){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/pathology/add');?>">
              <i class="fa fa-plus-circle text-yellow"></i> Master Test Creator
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='pathology' && $pageurl3=='assign_test'){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/pathology/assign_test');?>">
              <i class="fa fa-calculator text-primary"></i> Assign Test &amp; Pricing
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='pathology' && in_array($pageurl3, ['index', ''])){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/pathology/index');?>">
              <i class="fa fa-th-list text-purple"></i> Assigned Tests Directory
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='pathology' && in_array($pageurl3, ['custody', 'custody_timeline'])){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/pathology/custody');?>">
              <i class="fa fa-truck text-red"></i> Chain-of-Custody Desk
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='pathology' && $pageurl3=='audit_logs'){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/pathology/audit_logs');?>">
              <i class="fa fa-history text-muted"></i> System Audit Footprints
            </a>
          </li>
        </ul>
      </li>

      <!-- Pharmacy & Delivery Fleet -->
      <?php 
      $is_pharmacy_active = ($pageurl1 == 'pharmacy-fleet' || ($pageurl1 == 'masters' && $pageurl2 == 'pharmacy_fleet'));
      ?>
      <li class="treeview <?php if($is_pharmacy_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-medkit" style="color: #00a8ff;"></i> <span>Pharmacy &amp; Delivery Fleet</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_pharmacy_active){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($is_pharmacy_active && ($this->input->get('tab')=='pharmacy' || empty($this->input->get('tab')))){ ?>active<?php }?>">
            <a href="<?=base_url('masters/pharmacy_fleet?tab=pharmacy');?>">
              <i class="fa fa-plus-square"></i> Partner Pharmacies
            </a>
          </li>
          <li class="<?php if($is_pharmacy_active && $this->input->get('tab')=='fleet'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/pharmacy_fleet?tab=fleet');?>">
              <i class="fa fa-motorcycle"></i> Delivery Fleet &amp; Riders
            </a>
          </li>
          <li class="<?php if($is_pharmacy_active && $this->input->get('tab')=='dispatch'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/pharmacy_fleet?tab=dispatch');?>">
              <i class="fa fa-map-marker"></i> Live Dispatch Grid
            </a>
          </li>
          <li class="<?php if($is_pharmacy_active && $this->input->get('tab')=='settlements'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/pharmacy_fleet?tab=settlements');?>">
              <i class="fa fa-money"></i> Financial Settlements
            </a>
          </li>
        </ul>
      </li>

      <!-- Clinical & Location Masters -->
      <?php 
      $is_masters_active = ($pageurl1 == 'masters' && in_array($pageurl2, ['specilization', 'council', 'degree', 'services', 'city', 'location']));
      ?>
      <li class="treeview <?php if($is_masters_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-tags" style="color: #f59e0b;"></i> <span>Clinical Masters</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_masters_active){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='masters' && $pageurl2=='specilization'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/specilization/index');?>">
              <i class="fa fa-user-md"></i> Specializations
            </a>
          </li>
          <li class="<?php if($pageurl1=='masters' && $pageurl2=='council'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/council/index');?>">
              <i class="fa fa-university"></i> Medical Councils
            </a>
          </li>
          <li class="<?php if($pageurl1=='masters' && $pageurl2=='degree'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/degree/index');?>">
              <i class="fa fa-graduation-cap"></i> Degrees &amp; Qualifications
            </a>
          </li>
          <li class="<?php if($pageurl1=='masters' && $pageurl2=='services'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/services/index');?>">
              <i class="fa fa-stethoscope"></i> Clinical Services
            </a>
          </li>
          <li class="<?php if($pageurl1=='masters' && $pageurl2=='city'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/city/index');?>">
              <i class="fa fa-building-o"></i> Cities Master
            </a>
          </li>
          <li class="<?php if($pageurl1=='masters' && $pageurl2=='location'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/location/index');?>">
              <i class="fa fa-map-marker"></i> Locations &amp; Areas
            </a>
          </li>
        </ul>
      </li>

      <!-- =========================================================
           2. PATIENT RELATIONS & ENGAGEMENT
           ========================================================= -->
      <li class="header">PATIENTS &amp; ENGAGEMENT</li>

      <!-- Patients & Social Logins -->
      <?php 
      $is_user_mgmt_active = ($pageurl1 == 'users' && in_array($pageurl2, ['patient', 'usercreate', 'changepassword', 'userlogincreate']));
      ?>
      <li class="treeview <?php if($is_user_mgmt_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-users" style="color: #a855f7;"></i> <span>Patient &amp; Users</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_user_mgmt_active){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='users' && $pageurl2=='patient'){ ?>active<?php }?>">
            <a href="<?=base_url('users/patient');?>">
              <i class="fa fa-address-book"></i> Patient Dossiers &amp; History
            </a>
          </li>
          <li class="<?php if($pageurl1=='users' && $pageurl2=='userlogincreate' && $pageurl3=='website_users'){ ?>active<?php }?>">
            <a href="<?=base_url('users/userlogincreate/website_users');?>">
              <i class="fa fa-globe"></i> Registered Web Patients
            </a>
          </li>
          <li class="<?php if($pageurl1=='users' && $pageurl2=='userlogincreate' && (in_array($pageurl3, ['gmail_users', 'gmail']) || ($pageurl2=='userlogincreate' && empty($pageurl3)))){ ?>active<?php }?>">
            <a href="<?=base_url('users/userlogincreate/gmail_users');?>">
              <i class="fa fa-google" style="color: #ea4335;"></i> Google / Gmail Users
            </a>
          </li>
          <li class="<?php if($pageurl1=='users' && $pageurl2=='userlogincreate' && $pageurl3=='facebook_users'){ ?>active<?php }?>">
            <a href="<?=base_url('users/userlogincreate/facebook_users');?>">
              <i class="fa fa-facebook-square" style="color: #1877f2;"></i> Facebook Users
            </a>
          </li>
          <li class="<?php if($pageurl1=='users' && $pageurl2=='usercreate'){ ?>active<?php }?>">
            <a href="<?=base_url('users/usercreate');?>">
              <i class="fa fa-user-plus"></i> Create Admin User
            </a>
          </li>
          <li class="<?php if($pageurl1=='users' && $pageurl2=='changepassword'){ ?>active<?php }?>">
            <a href="<?=base_url('users/changepassword');?>">
              <i class="fa fa-key"></i> Change Admin Password
            </a>
          </li>
        </ul>
      </li>

      <!-- Inquiries & Applications -->
      <?php 
      $is_inquiries_active = ($pageurl1 == 'contactus' || ($pageurl1 == 'doctor' && $pageurl2 == 'career'));
      $total_inqs_badge = $pending_contact_count + $pending_career_count;
      ?>
      <li class="treeview <?php if($is_inquiries_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-envelope-o" style="color: #10b981;"></i> <span>Inquiries &amp; Career</span>
          <span class="pull-right-container">
            <?php if($total_inqs_badge > 0): ?>
              <small class="label pull-right bg-green"><?=$total_inqs_badge;?></small>
            <?php else: ?>
              <i class="fa fa-angle-left pull-right"></i>
            <?php endif; ?>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_inquiries_active){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='contactus'){ ?>active<?php }?>">
            <a href="<?=base_url('contactus');?>">
              <i class="fa fa-envelope"></i> Contact Inquiries
              <?php if($pending_contact_count > 0): ?>
                <span class="label label-warning pull-right"><?=$pending_contact_count;?></span>
              <?php endif; ?>
            </a>
          </li>
          <li class="<?php if($pageurl1=='doctor' && $pageurl2=='career'){ ?>active<?php }?>">
            <a href="<?=base_url('doctor/career');?>">
              <i class="fa fa-briefcase"></i> Career Applications
              <?php if($pending_career_count > 0): ?>
                <span class="label label-success pull-right"><?=$pending_career_count;?></span>
              <?php endif; ?>
            </a>
          </li>
        </ul>
      </li>

      <!-- ABDM National Integration -->
      <li class="<?php if($pageurl1=='abdm'){ ?>active<?php }?>">
        <a href="<?=base_url('abdm');?>">
          <i class="fa fa-id-card" style="color: #6366f1;"></i> <span>ABDM Network</span>
        </a>
      </li>

      <!-- Sponsored Ads & Promos -->
      <li class="<?php if($pageurl1=='doctor' && $pageurl2=='clinicreg' && $pageurl3=='advertisment'){ ?>active<?php }?>">
        <a href="<?=base_url('doctor/clinicreg/advertisment');?>">
          <i class="fa fa-bullhorn" style="color: #eab308;"></i> <span>Sponsored Promos</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-yellow">Ads</small>
          </span>
        </a>
      </li>

      <!-- Health News & Media -->
      <li class="<?php if($pageurl1=='doctor' && $pageurl2=='newsreg'){ ?>active<?php }?>">
        <a href="<?=base_url('doctor/newsreg/index');?>">
          <i class="fa fa-newspaper-o" style="color: #14b8a6;"></i> <span>Health News &amp; Media</span>
        </a>
      </li>

      <!-- =========================================================
           3. FINANCE, REVENUE & PAYOUTS
           ========================================================= -->
      <li class="header">FINANCE &amp; SETTLEMENTS</li>

      <!-- Revenue & Commission Module -->
      <li class="treeview <?php if($pageurl1=='admin_revenue'){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-line-chart" style="color: #00a896;"></i> <span>Revenue &amp; Commission</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($pageurl1=='admin_revenue'){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='admin_revenue' && ($this->input->get('tab')=='transactions' || empty($this->input->get('tab')))){ ?>active<?php }?>">
            <a href="<?=base_url('admin_revenue?tab=transactions#tab_transactions');?>">
              <i class="fa fa-exchange"></i> Transactions &amp; Settlements
            </a>
          </li>
          <li class="<?php if($pageurl1=='admin_revenue' && $this->input->get('tab')=='commissions'){ ?>active<?php }?>">
            <a href="<?=base_url('admin_revenue?tab=commissions#tab_commissions');?>">
              <i class="fa fa-percent"></i> Commission Overrides
            </a>
          </li>
          <li class="<?php if($pageurl1=='admin_revenue' && $this->input->get('tab')=='invoices'){ ?>active<?php }?>">
            <a href="<?=base_url('admin_revenue?tab=invoices#tab_invoices');?>">
              <i class="fa fa-file-text-o"></i> Monthly GST Invoices
            </a>
          </li>
          <li class="<?php if($pageurl1=='admin_revenue' && $this->input->get('tab')=='settings'){ ?>active<?php }?>">
            <a href="<?=base_url('admin_revenue?tab=settings#tab_settings');?>">
              <i class="fa fa-sliders"></i> Platform &amp; GST Settings
            </a>
          </li>
        </ul>
      </li>

      <!-- Payment & Settlements -->
      <li class="treeview <?php if($pageurl1=='admin_payment' || $pageurl1=='payout'){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-credit-card" style="color: #10b981;"></i> <span>Payment &amp; Settlements</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($pageurl1=='admin_payment' || $pageurl1=='payout'){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='admin_payment' && ($this->input->get('tab')=='dashboard' || empty($this->input->get('tab')))){ ?>active<?php }?>">
            <a href="<?=base_url('admin_payment?tab=dashboard');?>">
              <i class="fa fa-pie-chart"></i> Gateway Overview
            </a>
          </li>
          <li class="<?php if($pageurl1=='admin_payment' && $this->input->get('tab')=='transactions'){ ?>active<?php }?>">
            <a href="<?=base_url('admin_payment?tab=transactions');?>">
              <i class="fa fa-list-alt"></i> Payment Orders
            </a>
          </li>
          <li class="<?php if($pageurl1=='admin_payment' && $this->input->get('tab')=='wallet_settings'){ ?>active<?php }?>">
            <a href="<?=base_url('admin_payment?tab=wallet_settings');?>">
              <i class="fa fa-gift"></i> Wallet &amp; Points Rules
            </a>
          </li>
          <li class="<?php if($pageurl1=='admin_payment' && $this->input->get('tab')=='payouts'){ ?>active<?php }?>">
            <a href="<?=base_url('admin_payment?tab=payouts');?>">
              <i class="fa fa-bank"></i> RazorpayX Payouts
            </a>
          </li>
          <li class="<?php if($pageurl1=='admin_payment' && $this->input->get('tab')=='refunds'){ ?>active<?php }?>">
            <a href="<?=base_url('admin_payment?tab=refunds');?>">
              <i class="fa fa-undo"></i> Refunds Management
            </a>
          </li>
        </ul>
      </li>

      <!-- Upchar Points Wallet -->
      <li class="<?php if($pageurl1=='masters' && $pageurl2=='walletadmin'){ ?>active<?php }?>">
        <a href="<?=base_url('masters/walletadmin');?>">
          <i class="fa fa-star" style="color: #f59e0b;"></i> <span>Upchar Points Wallet</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-green">Active</small>
          </span>
        </a>
      </li>

      <!-- =========================================================
           4. ENTERPRISE WORKFORCE & OPERATIONS
           ========================================================= -->
      <li class="header">ENTERPRISE WORKFORCE</li>

      <!-- HR & Workforce Operations -->
      <li class="treeview <?php if($pageurl1=='hr' || ($pageurl1=='attendance' && in_array($pageurl2, ['roster', 'attendance', '']))){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-users" style="color: #38bdf8;"></i> <span>HR &amp; Recruitment</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($pageurl1=='hr' || ($pageurl1=='attendance' && in_array($pageurl2, ['roster', 'attendance', '']))){ ?> style="display: block;" <?php }?>>
          <li><a href="<?=base_url('hr/dashboard');?>" target="_blank"><i class="fa fa-tachometer"></i> HR Command Hub</a></li>
          <li><a href="<?=base_url('hr/employees');?>" target="_blank"><i class="fa fa-user-plus"></i> Staff Directory</a></li>
          <li><a href="<?=base_url('hr/attendance');?>" target="_blank"><i class="fa fa-calendar-check-o"></i> Daily Attendance Roster</a></li>
          <li><a href="<?=base_url('hr/leaves');?>" target="_blank"><i class="fa fa-calendar-times-o"></i> Leave Approvals Desk</a></li>
          <li><a href="<?=base_url('hr/payroll');?>" target="_blank"><i class="fa fa-money"></i> Monthly Payroll Engine</a></li>
          <li><a href="<?=base_url('hr/recruitment');?>" target="_blank"><i class="fa fa-briefcase"></i> Candidate ATS &amp; Kanban</a></li>
        </ul>
      </li>

      <!-- Logistics & Field Desk -->
      <li class="treeview <?php if($pageurl1=='collector' || $pageurl1=='operations' || ($pageurl1=='attendance' && $pageurl2=='punch')){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-truck" style="color: #2dd4bf;"></i> <span>Logistics &amp; Field Desk</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($pageurl1=='collector' || $pageurl1=='operations' || ($pageurl1=='attendance' && $pageurl2=='punch')){ ?> style="display: block;" <?php }?>>
          <li><a href="<?=base_url('operations/dashboard');?>" target="_blank"><i class="fa fa-dashboard"></i> Operations Hub</a></li>
          <li><a href="<?=base_url('operations/handoffs');?>" target="_blank"><i class="fa fa-flask"></i> Lab Sample Handoffs</a></li>
          <li><a href="<?=base_url('operations/expenses');?>" target="_blank"><i class="fa fa-credit-card"></i> Expense Claims Desk</a></li>
          <li><a href="<?=base_url('attendance/punch');?>" target="_blank"><i class="fa fa-camera"></i> GPS Attendance Punch</a></li>
          <li><a href="<?=base_url('../collector/dashboard');?>" target="_blank"><i class="fa fa-motorcycle"></i> Collector Pickup Queue</a></li>
        </ul>
      </li>

      <!-- BDE CRM & Leads -->
      <li class="treeview <?php if($pageurl1=='crm'){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-handshake-o" style="color: #f43f5e;"></i> <span>BDE CRM &amp; Leads</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($pageurl1=='crm'){ ?> style="display: block;" <?php }?>>
          <li><a href="<?=base_url('crm/dashboard');?>" target="_blank"><i class="fa fa-tachometer"></i> CRM Command Hub</a></li>
          <li><a href="<?=base_url('crm/leads');?>" target="_blank"><i class="fa fa-columns"></i> Kanban Lead Pipeline</a></li>
          <li><a href="<?=base_url('crm/contacts');?>" target="_blank"><i class="fa fa-address-book"></i> Partner Directory</a></li>
          <li><a href="<?=base_url('crm/activities');?>" target="_blank"><i class="fa fa-phone-square"></i> Activity &amp; Follow-ups</a></li>
        </ul>
      </li>

      <!-- =========================================================
           5. SYSTEM ADMINISTRATION & CONFIGURATION
           ========================================================= -->
      <li class="header">SYSTEM ADMINISTRATION</li>

      <!-- SEO & Meta Tags -->
      <li class="treeview <?php if($pageurl1=='seo'){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-line-chart" style="color: #0d9488;"></i> <span>SEO &amp; Meta Tags</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($pageurl1=='seo'){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='seo' && ($pageurl3=='index' || empty($pageurl3))){ ?>active<?php }?>">
            <a href="<?=base_url('seo/meta/index');?>"><i class="fa fa-dashboard" style="color: #0d9488;"></i> SEO Dashboard &amp; List</a>
          </li>
          <li class="<?php if($pageurl1=='seo' && $pageurl3=='add'){ ?>active<?php }?>">
            <a href="<?=base_url('seo/meta/add');?>"><i class="fa fa-plus-circle" style="color: #10b981;"></i> Add New Meta Tag</a>
          </li>
        </ul>
      </li>

      <!-- System Settings & Role Configuration -->
      <?php 
      $is_settings_active = ($pageurl1 == 'settings' || ($pageurl1 == 'masters' && $pageurl2 == 'sections'));
      $settings_tab = $this->input->get('tab') ?: ($pageurl2 ?: 'general');
      ?>
      <li class="treeview <?php if($is_settings_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="fa fa-cogs" style="color: #64748b;"></i> <span>System Settings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_settings_active){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='settings' && $settings_tab=='general'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=general');?>"><i class="fa fa-globe"></i> General &amp; Branding</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $settings_tab=='email'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=email');?>"><i class="fa fa-envelope-o"></i> Email Gateway</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $settings_tab=='sms'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=sms');?>"><i class="fa fa-commenting-o"></i> SMS &amp; WhatsApp</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $settings_tab=='integrations'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=integrations');?>"><i class="fa fa-plug"></i> Third-Party APIs</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $settings_tab=='security'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=security');?>"><i class="fa fa-lock"></i> Security &amp; Rules</a>
          </li>
          <li class="<?php if($pageurl1=='masters' && $pageurl2=='sections'){ ?>active<?php }?>">
            <a href="<?=base_url('masters/sections');?>"><i class="fa fa-shield"></i> Role &amp; Module Access</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $settings_tab=='audit'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=audit');?>"><i class="fa fa-history"></i> Audit Trail</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $settings_tab=='health'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=health');?>"><i class="fa fa-heartbeat"></i> System Health</a>
          </li>
        </ul>
      </li>

      <!-- =========================================================
           6. ACCOUNT ACTIONS (SIGN OUT)
           ========================================================= -->
      <li class="header" style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.08);">ACCOUNT</li>
      <li>
        <a href="<?=base_url('others/other/signout');?>" style="color: #f87171 !important;">
          <i class="fa fa-sign-out" style="color: #ef4444;"></i> <span>Sign Out</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<style>
/* =========================================================
   AdminLTE Enterprise Sidebar Styles - Clean & Optimized
   ========================================================= */

.main-sidebar {
  font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  background-color: #0f172a !important; /* Premium Slate 900 */
  scrollbar-width: thin;
  scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
}

.main-sidebar .sidebar {
  padding-bottom: 60px !important;
}

/* User Panel */
.user-panel {
  padding: 16px 14px;
  background: rgba(255, 255, 255, 0.03);
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  margin-bottom: 8px;
}
.user-panel > .info > p {
  font-weight: 700;
  font-size: 13.5px;
  color: #f8fafc;
  margin-bottom: 4px;
}

/* Scrollbar Styling */
.main-sidebar::-webkit-scrollbar {
  width: 5px;
}
.main-sidebar::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.2);
}
.main-sidebar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 4px;
}
.main-sidebar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.35);
}

/* Sidebar Headings */
.sidebar-menu .header {
  font-size: 10px !important;
  font-weight: 800 !important;
  letter-spacing: 0.9px;
  text-transform: uppercase;
  padding: 16px 16px 6px 16px !important;
  color: #64748b !important;
  background: transparent !important;
}

/* Navigation Items */
.sidebar-menu > li > a {
  padding: 10px 16px 10px 16px;
  font-size: 13px;
  font-weight: 600;
  color: #94a3b8 !important;
  border-left: 3px solid transparent;
  transition: all 0.15s ease-in-out;
}

.sidebar-menu > li > a:hover,
.sidebar-menu > li.active > a {
  color: #ffffff !important;
  background: rgba(255, 255, 255, 0.06) !important;
  border-left-color: #00a896;
}

/* Submenu / Treeview */
.sidebar-menu .treeview-menu {
  padding: 4px 0 6px 0;
  background: #090e1a !important; /* Darker Slate for Submenu */
}

.sidebar-menu .treeview-menu > li > a {
  padding: 8px 14px 8px 36px;
  font-size: 12.5px;
  font-weight: 500;
  color: #94a3b8 !important;
  transition: all 0.15s ease-in-out;
}

.sidebar-menu .treeview-menu > li > a:hover,
.sidebar-menu .treeview-menu > li.active > a {
  color: #ffffff !important;
  background: rgba(255, 255, 255, 0.04) !important;
  font-weight: 600;
}

.sidebar-menu .treeview-menu > li.active > a i {
  color: #2dd4bf !important;
}

/* Badges */
.sidebar-menu .label {
  border-radius: 6px;
  font-size: 10px;
  font-weight: 700;
  padding: 3px 6px;
}

/* ---------------------------------------------------------
   DESKTOP & TABLET LANDSCAPE (Screen width >= 768px)
   --------------------------------------------------------- */
@media (min-width: 768px) {
  .main-sidebar {
    position: fixed !important;
    top: 50px !important;
    bottom: 0 !important;
    left: 0 !important;
    height: calc(100vh - 50px) !important;
    max-height: calc(100vh - 50px) !important;
    width: 230px !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    padding-top: 0 !important;
    z-index: 820 !important;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
  }

  .content-wrapper {
    margin-left: 230px !important;
    padding-top: 50px !important;
    min-height: 100vh !important;
  }

  .main-header {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    z-index: 830 !important;
  }
  .main-header .navbar {
    margin-left: 230px !important;
  }
  .main-header .logo {
    width: 230px !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    z-index: 840 !important;
  }

  /* Desktop Mini-Sidebar Collapsed Mode */
  body.sidebar-collapse .main-sidebar {
    width: 50px !important;
    overflow: visible !important;
  }
  body.sidebar-collapse .content-wrapper,
  body.sidebar-collapse .main-header .navbar {
    margin-left: 50px !important;
  }
  body.sidebar-collapse .main-header .logo {
    width: 50px !important;
  }
}

/* ---------------------------------------------------------
   MOBILE SCREENS & SMALL TABLETS (Screen width <= 767px)
   --------------------------------------------------------- */
@media (max-width: 767px) {
  .main-sidebar {
    position: fixed !important;
    top: 50px !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 230px !important;
    height: calc(100vh - 50px) !important;
    max-height: calc(100vh - 50px) !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    padding-top: 0 !important;
    z-index: 850 !important;
    transform: translate(-230px, 0) !important;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
  }

  /* When mobile drawer is toggled open */
  body.sidebar-open .main-sidebar {
    transform: translate(0, 0) !important;
    box-shadow: 6px 0 25px rgba(0, 0, 0, 0.4) !important;
  }

  .content-wrapper {
    margin-left: 0 !important;
    padding-top: 50px !important;
    width: 100% !important;
    min-height: 100vh !important;
  }

  .main-header {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    z-index: 830 !important;
  }
  .main-header .navbar {
    margin-left: 0 !important;
  }
  .main-header .logo {
    display: none !important;
  }
}
</style>