<?php
$pageurl1 = $this->uri->segment(1);
$pageurl2 = $this->uri->segment(2);
$pageurl3 = $this->uri->segment(3);
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url();?>public/assets/newpanel/dist/img/user2-160x160.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=$this->session->userdata('username')?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <?php 
    $user_role = $this->db->get_where('rolewise', array('isStatus'=>'1', 'level_id'=>$this->session->userdata('code')))->row_array();
    $module = !empty($user_role['module']) ? explode(',', $user_role['module']) : array();
    $section = $this->db->get_where('master_sections', array('isStatus'=>'1'))->result_array();
    ?>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      
      <!-- Dashboard -->
      <li class="<?php if($pageurl1=='masters' && ($pageurl2=='dashboard' || empty($pageurl2))){ ?>active<?php }?>">
        <a href="<?=base_url('masters/dashboard');?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <!-- ABDM Integration -->
      <li class="<?php if($pageurl1=='abdm'){ ?>active<?php }?>">
        <a href="<?=base_url('abdm');?>">
          <i class="fa fa-id-card"></i> <span>ABDM Management</span>
        </a>
      </li>

      <!-- Contact Inquiries Management -->
      <?php
      $pending_contact_count = $this->db->where('status', 'PENDING')->count_all_results('contactus');
      ?>
      <li class="<?php if($pageurl1=='contactus'){ ?>active<?php }?>">
        <a href="<?=base_url('contactus');?>">
          <i class="fa fa-envelope-o"></i> <span>Contact Inquiries</span>
          <?php if($pending_contact_count > 0): ?>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow"><?=$pending_contact_count;?></small>
            </span>
          <?php endif; ?>
        </a>
      </li>

      <!-- Revenue & Commission Module with Sublinks -->
      <li class="treeview <?php if($pageurl1=='admin_revenue'){ ?> active menu-open <?php }?>">
        <a href="<?=base_url('admin_revenue');?>">
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

      <!-- Payment & Wallet Control Center (Razorpay & Settlements) -->
      <li class="treeview <?php if($pageurl1=='admin_payment' || $pageurl1=='payout'){ ?> active menu-open <?php }?>">
        <a href="<?=base_url('admin_payment');?>">
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

      <!-- System Settings Portal -->
      <li class="treeview <?php if($pageurl1=='settings'){ ?> active menu-open <?php }?>">
        <a href="<?=base_url('settings');?>">
          <i class="fa fa-cogs" style="color: #00a896;"></i> <span>System Settings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($pageurl1=='settings'){ ?> style="display: block;" <?php }?>>
          <li class="<?php if($pageurl1=='settings' && ($pageurl2=='general' || empty($pageurl2))){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=general');?>"><i class="fa fa-globe"></i> General & Branding</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $pageurl2=='email'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=email');?>"><i class="fa fa-envelope-o"></i> Email Gateway</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $pageurl2=='sms'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=sms');?>"><i class="fa fa-commenting-o"></i> SMS & WhatsApp</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $pageurl2=='integrations'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=integrations');?>"><i class="fa fa-plug"></i> Third-Party APIs</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $pageurl2=='security'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=security');?>"><i class="fa fa-lock"></i> Security & Rules</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $pageurl2=='audit'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=audit');?>"><i class="fa fa-history"></i> Audit Trail</a>
          </li>
          <li class="<?php if($pageurl1=='settings' && $pageurl2=='health'){ ?>active<?php }?>">
            <a href="<?=base_url('settings?tab=health');?>"><i class="fa fa-heartbeat"></i> System Health</a>
          </li>
        </ul>
      </li>

      <!-- Upchar Points & Wallet -->
      <li class="<?php if($pageurl1=='masters' && $pageurl2=='walletadmin'){ ?>active<?php }?>">
        <a href="<?=base_url('masters/walletadmin');?>">
          <i class="fa fa-star" style="color: #f59e0b;"></i> <span>Upchar Points Wallet</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-green">Active</small>
          </span>
        </a>
      </li>

      <li class="header">ENTERPRISE MANAGEMENT</li>

      <!-- HR & Staff Management -->
      <li class="treeview <?php if($pageurl1=='hr'){ ?> active menu-open <?php }?>">
        <a href="<?=base_url('../hr/dashboard');?>" target="_blank">
          <i class="fa fa-users" style="color: #38bdf8;"></i> <span>HR &amp; Staff Suite</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?=base_url('../hr/dashboard');?>" target="_blank"><i class="fa fa-tachometer"></i> HR Command Hub</a></li>
          <li><a href="<?=base_url('../hr/employees');?>" target="_blank"><i class="fa fa-user-plus"></i> Staff Directory</a></li>
          <li><a href="<?=base_url('../hr/attendance');?>" target="_blank"><i class="fa fa-calendar-check-o"></i> Daily Attendance Roster</a></li>
          <li><a href="<?=base_url('../hr/leaves');?>" target="_blank"><i class="fa fa-calendar-times-o"></i> Leave Approvals Desk</a></li>
          <li><a href="<?=base_url('../hr/payroll');?>" target="_blank"><i class="fa fa-money"></i> Monthly Payroll Engine</a></li>
        </ul>
      </li>

      <!-- Logistics & Sample Collectors -->
      <li class="treeview <?php if($pageurl1=='collector' || $pageurl1=='operations'){ ?> active menu-open <?php }?>">
        <a href="<?=base_url('../operations/dashboard');?>" target="_blank">
          <i class="fa fa-truck" style="color: #2dd4bf;"></i> <span>Logistics &amp; Field Desk</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?=base_url('../operations/dashboard');?>" target="_blank"><i class="fa fa-dashboard"></i> Operations Hub</a></li>
          <li><a href="<?=base_url('../collector/dashboard');?>" target="_blank"><i class="fa fa-motorcycle"></i> Collector Pickup Queue</a></li>
          <li><a href="<?=base_url('../operations/handoffs');?>" target="_blank"><i class="fa fa-flask"></i> Lab Sample Handoffs</a></li>
          <li><a href="<?=base_url('../operations/expenses');?>" target="_blank"><i class="fa fa-receipt"></i> Expense Claims Desk</a></li>
          <li><a href="<?=base_url('../attendance/punch');?>" target="_blank"><i class="fa fa-camera"></i> GPS Attendance Punch</a></li>
        </ul>
      </li>

      <!-- BDE CRM & Partner Acquisition -->
      <li class="treeview <?php if($pageurl1=='crm'){ ?> active menu-open <?php }?>">
        <a href="<?=base_url('../crm/dashboard');?>" target="_blank">
          <i class="fa fa-handshake-o" style="color: #f43f5e;"></i> <span>BDE CRM &amp; Leads</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?=base_url('../crm/dashboard');?>" target="_blank"><i class="fa fa-line-chart"></i> Revenue Dashboard</a></li>
          <li><a href="<?=base_url('../crm/leads');?>" target="_blank"><i class="fa fa-columns"></i> Kanban Lead Pipeline</a></li>
        </ul>
      </li>

      <!-- Diagnostic Tests & Pathology Master -->
      <li class="treeview <?php if($pageurl1=='doctor' && ($pageurl2=='pathology' || $pageurl2=='pathologytest')){ ?> active menu-open <?php }?>">
        <a href="<?=base_url('doctor/pathology/assign_test');?>">
          <i class="fa fa-heartbeat" style="color: #ec4899;"></i> <span>Pathology &amp; Tests</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?=base_url('doctor/pathology/assign_test');?>"><i class="fa fa-list"></i> Pathology Test Catalog</a></li>
          <li><a href="<?=base_url('doctor/pathology/add');?>"><i class="fa fa-plus-circle"></i> Add Diagnostic Test</a></li>
        </ul>
      </li>

      <!-- Patient & Social User Logins -->
      <li class="treeview <?php if($pageurl1=='users' || $pageurl2=='userlogincreate'){ ?> active menu-open <?php }?>">
        <a href="<?=base_url('users/userlogincreate/gmail_users');?>">
          <i class="fa fa-user-circle" style="color: #6366f1;"></i> <span>Patient Logins</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?=base_url('users/userlogincreate/gmail_users');?>"><i class="fa fa-google" style="color: #ea4335;"></i> Google / Gmail Users</a></li>
          <li><a href="<?=base_url('users/userlogincreate/website_users');?>"><i class="fa fa-globe"></i> Registered Web Users</a></li>
          <li><a href="<?=base_url('users/userlogincreate/facebook_users');?>"><i class="fa fa-facebook-square" style="color: #1877f2;"></i> Facebook Users</a></li>
        </ul>
      </li>

      <!-- Healthcare Sponsored Advertisements -->
      <li class="<?php if($pageurl1=='doctor' && $pageurl2=='clinicreg' && $pageurl3=='advertisment'){ ?>active<?php }?>">
        <a href="<?=base_url('doctor/clinicreg/advertisment');?>">
          <i class="fa fa-bullhorn" style="color: #eab308;"></i> <span>Sponsored Ads Manager</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-yellow">Promos</small>
          </span>
        </a>
      </li>

      <!-- Master Sections with Dropdowns -->
      <?php if(!empty($section)){
        for($i=0; $i<count($section); $i++){ 
          if(!empty($module)) {
            $this->db->where_in('module_id', $module);
          }
          $this->db->where(array('isStatus'=>'1', 'parent_id'=>$section[$i]['section_id']));
          $management = $this->db->get('master_management')->result_array();

          $controllers_in_section = array();
          for($k=0; $k<count($management); $k++) {
            $controllers_in_section[] = $management[$k]['module_controller'];
            $controllers_in_section[] = $management[$k]['module_folder'];
          }

          $is_section_active = in_array($pageurl1, $controllers_in_section) || in_array($pageurl2, $controllers_in_section);

          if(!empty($management)) {
      ?>
      <li class="treeview <?php if($is_section_active){ ?> active menu-open <?php }?>">
        <a href="#">
          <i class="<?php echo $section[$i]['section_icon']; ?>"></i>
          <span><?php echo $section[$i]['section_name']; ?></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if($is_section_active){ ?> style="display: block;" <?php }?>>
          <?php for($j=0; $j<count($management); $j++) { 
            $m_folder = $management[$j]['module_folder'];
            $m_ctrl = $management[$j]['module_controller'];
            $m_act = $management[$j]['module_action'];

            $is_item_active = false;
            if ($m_folder != $m_ctrl) {
              if ($pageurl1 == $m_folder && $pageurl2 == $m_ctrl && ($pageurl3 == $m_act || empty($pageurl3))) {
                $is_item_active = true;
              } elseif ($pageurl2 == $m_ctrl && $pageurl3 == $m_act) {
                $is_item_active = true;
              }
            } else {
              if ($pageurl1 == $m_ctrl && ($pageurl2 == $m_act || empty($pageurl2))) {
                $is_item_active = true;
              }
            }

            $target_url = ($m_folder != $m_ctrl) 
              ? base_url($m_folder.'/'.$m_ctrl.'/'.$m_act)
              : base_url($m_ctrl.'/'.$m_act);
          ?>
          <li class="<?php if($is_item_active){ ?>active<?php }?>">
            <a href="<?=$target_url;?>">
              <i class="<?php echo $management[$j]['module_icon']; ?>"></i> <span><?php echo $management[$j]['module_name']; ?></span>
            </a>
          </li>
          <?php } ?>
        </ul>
      </li>
      <?php } } } ?>

      <!-- Standalone Direct Menu Items (parent_id = 0) -->
      <?php 
      if(!empty($module)) {
        $this->db->where_in('module_id', $module);
      }
      $this->db->where(array('isStatus'=>'1', 'parent_id'=>'0'));
      $direct_management = $this->db->get('master_management')->result_array();

      if(!empty($direct_management)){
        for($j=0; $j<count($direct_management); $j++) {
          $m_folder = $direct_management[$j]['module_folder'];
          $m_ctrl = $direct_management[$j]['module_controller'];
          $m_act = $direct_management[$j]['module_action'];

          // Skip abdm & settings if already rendered as top item
          if ($m_ctrl == 'abdm' || $m_ctrl == 'settings') continue;

          $is_direct_active = false;
          if ($m_folder != $m_ctrl) {
            if ($pageurl1 == $m_folder && $pageurl2 == $m_ctrl) {
              $is_direct_active = true;
            }
          } else {
            if ($pageurl1 == $m_ctrl) {
              $is_direct_active = true;
            }
          }

          $target_url = ($m_folder != $m_ctrl) 
            ? base_url($m_folder.'/'.$m_ctrl.'/'.$m_act)
            : base_url($m_ctrl.'/'.$m_act);
      ?>
      <li class="<?php if($is_direct_active){ ?>active<?php }?>">
        <a href="<?=$target_url;?>">
          <i class="<?php echo $direct_management[$j]['module_icon']; ?>"></i> <span><?php echo $direct_management[$j]['module_name']; ?></span>
        </a>
      </li>
      <?php } } ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<style>
/* =========================================================
   AdminLTE Windows & Cross-Device Responsive Sidebar Styles
   ========================================================= */

.main-sidebar {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  background-color: #222d32 !important;
  scrollbar-width: thin;
  scrollbar-color: rgba(255, 255, 255, 0.25) transparent;
}

.main-sidebar .sidebar {
  padding-bottom: 60px !important;
}

/* Windows WebKit Smooth Scrollbar */
.main-sidebar::-webkit-scrollbar {
  width: 6px;
}
.main-sidebar::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.15);
}
.main-sidebar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.25);
  border-radius: 4px;
}
.main-sidebar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.45);
}

/* Ensure Submenus & Dropdowns Expand Inline Inside Scroll Container */
.sidebar-menu .treeview-menu {
  padding-left: 5px;
  background: #1a2226 !important;
}

.sidebar-menu > li > a {
  padding: 11px 16px 11px 15px;
  font-size: 13px;
  font-weight: 500;
}
.sidebar-menu .treeview-menu > li > a {
  padding: 8px 10px 8px 18px;
  font-size: 12.5px;
}
.sidebar-menu .header {
  font-size: 11px !important;
  font-weight: 700 !important;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  padding: 12px 15px 8px;
  color: #94a3b8 !important;
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
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.08);
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
    display: none !important; /* Mini logo inside navbar */
  }
}
</style>