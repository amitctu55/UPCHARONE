<?php
$isUserLoggedIn = ($this->session->userdata('userid')!='' || $this->session->userdata('USERID')!='' || $this->session->userdata('user_id')!='');
$currentUserName = $this->session->userdata('username') ?: 'Patient';
if ($isUserLoggedIn){ 
	$userid = $this->session->userdata('userid') ?: $this->session->userdata('USERID') ?: $this->session->userdata('user_id');
	$userdata['id']=$userid;
	$userdata['row']=$this->db->get_where('userlogin',array('USERID'=>$userid))->row();
	if ($userdata['row']) {
		$userdata['email']=$userdata['row']->EMAIL;
		$userdata['mobile']=$userdata['row']->MOBILE;
		$userdata['name']=$userdata['row']->FNAME.' '.$userdata['row']->LNAME;
		$currentUserName = $userdata['row']->FNAME ?: $currentUserName;
	}
}
if(		
		current_url() != base_url().'login' && 
		current_url() != base_url().'signup' && 
		current_url() != base_url().'forgotpassword' && 
		current_url() != base_url().'verifymobile' && 
		
		current_url() != base_url().'doctor-login' && 
		current_url() != base_url().'doctor-signup' && 
		current_url() != base_url().'doctor-forgotpassword' && 
		current_url() != base_url().'doctor-verifymobile' && 
		
		current_url() != base_url().'hospital-login' && 
		current_url() != base_url().'hospital-signup' && 
		current_url() != base_url().'hospital-forgotpassword' && 
		current_url() != base_url().'hospital-verifymobile' 
   ){
	if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'])
		$this->session->set_userdata('last_page', current_url().'?'.$_SERVER['QUERY_STRING']);
	else
		$this->session->set_userdata('last_page', current_url());

}
?>

<header>
	<?php 
	$meta_rec = getMeta();
	if( array_key_exists('dynamic_meta',$meta_rec) && @is_array($meta_array) && !empty($meta_array) )
	{
		if(  array_key_exists('meta_title',$meta_array) && $meta_array['meta_title']!='')
		{
			echo '<title>'.$meta_array['meta_title'].'</title>';
		}
		if( array_key_exists('meta_description',$meta_array) && $meta_array['meta_description']!='')
		{
			echo '<meta name="description" content="'.$meta_array['meta_description'].'" />';
		}
		if( array_key_exists('meta_keyword',$meta_array) && $meta_array['meta_keyword']!='')
		{
		   echo '<meta  name="keywords" content="'.$meta_array['meta_keyword'].'" />';
		}
		
	}else
	{   
	?>
	<title><?php echo $meta_rec['meta_title'];?> </title>
	<meta name="description" content="<?php echo $meta_rec['meta_description'];?>" />
	<meta  name="keywords" content="<?php echo $meta_rec['meta_keyword'];?>" />
	<?php
	}
	?>
  <link rel="icon" href="images/logo.png" type="image/gif" sizes="16x16">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="<?=base_url();?>style_home.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url();?>style_home2.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url();?>media.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/css/landing_modern.css">
</head>

<body>
<header>
  <div class="container">
    <div class="row">
      <aside class="col-md-3 logocont">
        <a href="<?=base_url();?>" class="careplus-logo">
          <img id="upchar_logo" src="<?=base_url();?>images/Final_logo23.png" alt="Upchar Logo">
        </a>
      </aside>
      <aside class="col-md-9" id="HeadMobile">
        <nav class="navbar">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="<?=base_url();?>">
                <span class="glyphicon glyphicon-home iconEffect"></span> Home
              </a>
            </li>

            <?php if (!$isUserLoggedIn): ?>
            <!-- 1. Our Partners (4-Category Dropdown: Hospital, Doctor, Pathology, Pharmacy) - Shown ONLY for Guest / Logged-Out Users -->
            <li class="dropdown partner-dropdown-container">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-handshake iconEffect"></i> Our Partners <span class="caret"></span>
              </a>
              <div class="partner-menu-box">
                <div class="partner-menu-header">
                  <h5><i class="fas fa-hospital-user" style="color: #00A896;"></i> Our Partner Network</h5>
                  <span>Verified Healthcare Providers</span>
                </div>
                <div class="partner-grid">
                  <a href="<?=base_url('hospitals');?>" class="partner-card-link">
                    <div class="partner-card-icon"><i class="fas fa-hospital"></i></div>
                    <div class="partner-card-text">
                      <h6>Hospital</h6>
                      <p>Browse network hospitals & clinics</p>
                    </div>
                  </a>
                  <a href="<?=base_url('doctors');?>" class="partner-card-link">
                    <div class="partner-card-icon"><i class="fas fa-user-md"></i></div>
                    <div class="partner-card-text">
                      <h6>Doctor</h6>
                      <p>Certified specialists & surgeons</p>
                    </div>
                  </a>
                  <a href="<?=base_url('mytest');?>" class="partner-card-link">
                    <div class="partner-card-icon"><i class="fas fa-flask"></i></div>
                    <div class="partner-card-text">
                      <h6>Pathology</h6>
                      <p>Diagnostic labs & sample testing</p>
                    </div>
                  </a>
                  <a href="<?=base_url('medical-signup');?>" class="partner-card-link">
                    <div class="partner-card-icon"><i class="fas fa-pills"></i></div>
                    <div class="partner-card-text">
                      <h6>Pharmacy</h6>
                      <p>Verified chemist & medical stores</p>
                    </div>
                  </a>
                </div>
              </div>
            </li>

            <!-- 2. Become Partner / Login (4 Portal Categories with Login & Join Actions) - Shown ONLY for Guest / Logged-Out Users -->
            <li class="dropdown partner-dropdown-container">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-plus iconEffect"></i> Become Partner / Login <span class="caret"></span>
              </a>
              <div class="partner-menu-box">
                <div class="partner-menu-header">
                  <h5><i class="fas fa-shield-alt" style="color: #00A896;"></i> Partner Access Portal</h5>
                  <span>Onboarding & Account Login</span>
                </div>
                <div class="partner-grid">
                  <div class="partner-login-card">
                    <div class="partner-card-icon"><i class="fas fa-user-md"></i></div>
                    <div class="partner-card-text">
                      <h6>Doctor Portal</h6>
                      <div class="partner-card-actions">
                        <a href="<?=base_url('doctor-aindex');?>" class="partner-btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="<?=base_url('doctor-signup');?>" class="partner-btn-join"><i class="fas fa-plus"></i> Join</a>
                      </div>
                    </div>
                  </div>
                  <div class="partner-login-card">
                    <div class="partner-card-icon"><i class="fas fa-hospital"></i></div>
                    <div class="partner-card-text">
                      <h6>Hospital Portal</h6>
                      <div class="partner-card-actions">
                        <a href="<?=base_url('hospital-aindex');?>" class="partner-btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="<?=base_url('hospital-signup');?>" class="partner-btn-join"><i class="fas fa-plus"></i> Join</a>
                      </div>
                    </div>
                  </div>
                  <div class="partner-login-card">
                    <div class="partner-card-icon"><i class="fas fa-flask"></i></div>
                    <div class="partner-card-text">
                      <h6>Pathology Lab</h6>
                      <div class="partner-card-actions">
                        <a href="<?=base_url('pathlab-login');?>" class="partner-btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="<?=base_url('pathlab-signup');?>" class="partner-btn-join"><i class="fas fa-plus"></i> Join</a>
                      </div>
                    </div>
                  </div>
                  <div class="partner-login-card">
                    <div class="partner-card-icon"><i class="fas fa-pills"></i></div>
                    <div class="partner-card-text">
                      <h6>Pharmacy Store</h6>
                      <div class="partner-card-actions">
                        <a href="<?=base_url('medical-login');?>" class="partner-btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="<?=base_url('medical-signup');?>" class="partner-btn-join"><i class="fas fa-plus"></i> Join</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>

            <li>
              <a href="https://upcharrnews.blogspot.com/" target="_blank"><i class="fas fa-newspaper iconEffect"></i> Blog</a>
            </li>
            <li>
              <a href="<?=base_url('login');?>" class="nav-login-btn"><span class="glyphicon glyphicon-log-in iconEffect"></span> Patient Login</a>
            </li>
            <?php else: ?>
            <!-- Authenticated User Navigation: Clean & Focused on Patient Services -->
            <li>
              <a href="<?=base_url('myappointments');?>"><i class="fas fa-calendar-alt iconEffect"></i> My Appointments</a>
            </li>
            <li>
              <a href="<?=base_url('wallet');?>"><i class="fas fa-wallet iconEffect" style="color: #f59e0b;"></i> Wallet &amp; Points</a>
            </li>
            <li>
              <a href="<?=base_url('profile');?>" style="font-weight: 700; color: #00A896;">
                <i class="fas fa-user-circle"></i> <?=html_escape($currentUserName);?>
              </a>
            </li>
            <li>
              <a href="<?=base_url('Home/logout');?>" class="nav-logout-btn"><span class="glyphicon glyphicon-log-out iconEffect"></span> Logout</a>
            </li>
            <?php endif; ?>
          </ul>
        </nav>
      </aside>
      <img class="mobileIcon" src="<?=base_url();?>images/menu_icon.png" alt="Menu" />
    </div>    
  </div>
</header>

<script> 
$(document).ready(function(){
  $(".mobileIcon").click(function(){
    $(".navbar").slideToggle("slow");
  });
});
</script>