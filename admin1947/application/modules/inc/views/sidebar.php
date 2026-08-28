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
@media (min-width: 1200px) and (max-width: 1400px){
  .main-sidebar, .logo {
    width: 180px;
  }
  .content-wrapper, .main-footer {
    margin-left: 180px;
  }
  .container {
    width: 1120px;
  }
}
</style>