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
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
	$meta_rec = getMeta();
	if( (isset($meta_array) && is_array($meta_array) && !empty($meta_array)) || (isset($page_title) && !empty($page_title)) )
	{
		$display_title = !empty($page_title) ? $page_title : (!empty($meta_array['meta_title']) ? $meta_array['meta_title'] : $meta_rec['meta_title']);
		$display_desc = !empty($meta_description) ? $meta_description : (!empty($meta_array['meta_description']) ? $meta_array['meta_description'] : $meta_rec['meta_description']);
		echo '<title>'.htmlspecialchars($display_title).'</title>' . "\n";
		echo '<meta name="description" content="'.htmlspecialchars($display_desc).'" />' . "\n";
		if( isset($meta_array['meta_keyword']) && $meta_array['meta_keyword']!='')
		{
		   echo '<meta name="keywords" content="'.$meta_array['meta_keyword'].'" />' . "\n";
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
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
                <i class="fas fa-home iconEffect"></i> Home
              </a>
            </li>
            <!-- Partner List Dropdown (Doctors, Hospitals, Medicines, Lab Tests, 108 SOS) -->
            <li class="dropdown partner-dropdown-container">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="true" aria-expanded="false" style="text-transform: none !important; letter-spacing: normal !important;">
                <i class="fas fa-list-ul iconEffect" style="color: #00A896;"></i> Partner List <span class="caret"></span>
              </a>
              <div class="partner-menu-box">
                <div class="partner-menu-header">
                  <h5><i class="fas fa-hospital-user" style="color: #00A896;"></i> Healthcare Partner List</h5>
                  <span>Verified Medical Services</span>
                </div>
                <div class="partner-grid">
                  <a href="<?=base_url('doctors');?>" class="partner-card-link">
                    <div class="partner-card-icon" style="color: #00A896; background: #CCFBF1;"><i class="fas fa-user-md"></i></div>
                    <div class="partner-card-text">
                      <h6>Doctors</h6>
                      <p>Certified specialists &amp; surgeons</p>
                    </div>
                  </a>
                  <a href="<?=base_url('hospitals');?>" class="partner-card-link">
                    <div class="partner-card-icon" style="color: #0284C7; background: #E0F2FE;"><i class="fas fa-hospital"></i></div>
                    <div class="partner-card-text">
                      <h6>Hospitals</h6>
                      <p>Browse network hospitals &amp; clinics</p>
                    </div>
                  </a>
                  <a href="<?=base_url('medical');?>" class="partner-card-link">
                    <div class="partner-card-icon" style="color: #10B981; background: #D1FAE5;"><i class="fas fa-pills"></i></div>
                    <div class="partner-card-text">
                      <h6>Medicines</h6>
                      <p>Verified chemists &amp; pharmacies</p>
                    </div>
                  </a>
                  <a href="<?=base_url('mytest');?>" class="partner-card-link">
                    <div class="partner-card-icon" style="color: #7C3AED; background: #EDE9FE;"><i class="fas fa-flask"></i></div>
                    <div class="partner-card-text">
                      <h6>Lab Tests</h6>
                      <p>Diagnostic labs &amp; doorstep tests</p>
                    </div>
                  </a>
                  <a href="tel:108" class="partner-card-link" style="grid-column: span 2; background: #FFF1F2; border-color: #FECDD3;">
                    <div class="partner-card-icon" style="color: #E63946; background: #FFE4E6;"><i class="fas fa-ambulance"></i></div>
                    <div class="partner-card-text">
                      <h6 style="color: #9F1239;"><i class="fas fa-phone-alt"></i> 108 SOS Ambulance</h6>
                      <p style="color: #E11D48;">Emergency response helpline 24/7</p>
                    </div>
                  </a>
                </div>
              </div>
            </li>

            <?php if (!$isUserLoggedIn): ?>
            <!-- Partner Access Portal (Doctor, Hospital, Lab, Pharmacy Onboarding & Login) -->
            <li class="dropdown partner-dropdown-container">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="true" aria-expanded="false" style="text-transform: none !important; letter-spacing: normal !important;">
                <i class="fas fa-handshake iconEffect"></i>Partners Portal <span class="caret"></span>
              </a>
              <div class="partner-menu-box">
                <div class="partner-menu-header">
                  <h5><i class="fas fa-shield-alt" style="color: #00A896;"></i> Partner Access Portal</h5>
                  <span>Onboarding & Account Login</span>
                </div>
                <div class="partner-grid">
                  <div class="partner-login-card">
                    <div class="partner-card-icon" style="color: #00A896; background: #CCFBF1;"><i class="fas fa-user-md"></i></div>
                    <div class="partner-card-text">
                      <h6>Doctor Portal</h6>
                      <div class="partner-card-actions">
                        <a href="<?=base_url('doctor-aindex');?>" class="partner-btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="<?=base_url('doctor-signup');?>" class="partner-btn-join"><i class="fas fa-plus"></i> Join</a>
                      </div>
                    </div>
                  </div>
                  <div class="partner-login-card">
                    <div class="partner-card-icon" style="color: #0284C7; background: #E0F2FE;"><i class="fas fa-hospital"></i></div>
                    <div class="partner-card-text">
                      <h6>Hospital Portal</h6>
                      <div class="partner-card-actions">
                        <a href="<?=base_url('hospital-aindex');?>" class="partner-btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="<?=base_url('hospital-signup');?>" class="partner-btn-join"><i class="fas fa-plus"></i> Join</a>
                      </div>
                    </div>
                  </div>
                  <div class="partner-login-card">
                    <div class="partner-card-icon" style="color: #7C3AED; background: #EDE9FE;"><i class="fas fa-flask"></i></div>
                    <div class="partner-card-text">
                      <h6>Pathology Lab</h6>
                      <div class="partner-card-actions">
                        <a href="<?=base_url('pathlab-login');?>" class="partner-btn-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="<?=base_url('pathlab-signup');?>" class="partner-btn-join"><i class="fas fa-plus"></i> Join</a>
                      </div>
                    </div>
                  </div>
                  <div class="partner-login-card">
                    <div class="partner-card-icon" style="color: #10B981; background: #D1FAE5;"><i class="fas fa-pills"></i></div>
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

            <li class="<?= ((isset($active_menu) && $active_menu === 'blog') || (isset($active_tab) && $active_tab === 'blog')) ? 'active' : '' ?>">
              <a class="nav-link <?= ((isset($active_menu) && $active_menu === 'blog') || (isset($active_tab) && $active_tab === 'blog')) ? 'active text-primary fw-bold' : '' ?>" href="<?=base_url('blog');?>"><i class="fas fa-newspaper iconEffect"></i> Blog</a>
            </li>
            <li>
              <a href="<?=base_url('cart');?>" title="Medicine Cart" style="position: relative;">
                <i class="fas fa-shopping-cart iconEffect" style="color: #00A896;"></i> Cart
                <span class="badge" id="navCartBadge" style="background: #E11D48; color: #fff; font-size: 10px; margin-left: 2px; vertical-align: top; border-radius: 10px; padding: 2px 6px; display: inline-block;">0</span>
              </a>
            </li>
            <li>
              <a href="<?=base_url('login');?>" class="nav-login-btn"><i class="fas fa-sign-in-alt iconEffect"></i> Patient Login</a>
            </li>
            <?php else: ?>
            <!-- Authenticated User Navigation: Clean & Focused on Patient Services -->
            <li class="<?= ((isset($active_menu) && $active_menu === 'blog') || (isset($active_tab) && $active_tab === 'blog')) ? 'active' : '' ?>">
              <a class="nav-link <?= ((isset($active_menu) && $active_menu === 'blog') || (isset($active_tab) && $active_tab === 'blog')) ? 'active text-primary fw-bold' : '' ?>" href="<?=base_url('blog');?>"><i class="fas fa-newspaper iconEffect"></i> Blog</a>
            </li>
            <li>
              <a href="<?=base_url('cart');?>" title="Medicine Cart" style="position: relative;">
                <i class="fas fa-shopping-cart iconEffect" style="color: #00A896;"></i> Cart
                <span class="badge" id="navCartBadgeAuth" style="background: #E11D48; color: #fff; font-size: 10px; margin-left: 2px; vertical-align: top; border-radius: 10px; padding: 2px 6px; display: inline-block;">0</span>
              </a>
            </li>
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

  // Live Cart Counter fetch
  $.ajax({
    url: '<?=base_url("cart/get_count");?>',
    type: 'GET',
    dataType: 'json',
    success: function(res) {
      if (res && res.cart_count > 0) {
        $('#navCartBadge, #navCartBadgeAuth').text(res.cart_count).show();
      } else {
        $('#navCartBadge, #navCartBadgeAuth').text('0');
      }
    }
  });
});
</script>