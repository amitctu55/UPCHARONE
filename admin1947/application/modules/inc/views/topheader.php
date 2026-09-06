<header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url('masters/dashboard');?>" class="logo" style="background-color: #00A896 !important;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Upchar</b></span>
      <!-- logo for regular state and mobile devices -->
     <span class="logo-lg" style="font-size: 14px; font-weight: 700; letter-spacing: 0.2px;">Upchar One Place of Healthcare</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- Notifications: style can be found in dropdown.less -->
        
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=base_url();?>public/assets/newpanel/dist/img/user2-160x160.png" class="user-image" alt="User Image">
              <?php
                $role_name = 'Administrator';
                try {
                    if (function_exists('getRoleName')) {
                        $ret_role = getRoleName($this->session->userdata('code'));
                        if (!empty($ret_role)) {
                            $role_name = $ret_role;
                        }
                    }
                } catch (Throwable $e) {}
              ?>
				<span class="hidden-xs">Logedin as <?=htmlspecialchars($role_name, ENT_QUOTES, 'UTF-8');?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=base_url();?>public/assets/newpanel/dist/img/user2-160x160.png" class="img-circle" alt="User Image">
                <p>
                 <?=htmlspecialchars($this->session->userdata('username') ?: 'Administrator', ENT_QUOTES, 'UTF-8');?>
                  <!--<small>Member since Nov. 2018</small>-->
                </p>
              </li>
              
              <li class="user-footer">
                
                <div class="pull-right">
                  <a href="<?=base_url()?>others/other/signout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <div id="myloader">  <div id="loader"></div></div>