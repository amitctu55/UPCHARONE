<head>
    <style>
#designforform{
    border-radius: 0px 29px;
    background:white;
    padding: 20px;
    margin-top: 47px;
    box-shadow:0px -2px 8px #173242;
}

.bottomBtns{
    border-radius: 5px;
    letter-spacing: 1px;
    padding: 6px 41px;
    background: #295771; 
    color: white; 
    float:right;
    margin-right:12px;
}
.bottomBtns:hover{
    color:#c0c4c5;
}
    </style>
</head>
<!-- Mirrored from eyecix.com/html/careplus/team-list.html by --->
<?php $this->load->view("includes/header.php"); ?>


<form action='<?=base_url();?>search' method='GET'>
                <div class="box-form">
                      
      
                    <div class="col-sm-2 col-sm-offset-1">
                        <div class="input-group shadow">
                            <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            <input type="text" class="form-control ui-autocomplete-input" name="location" placeholder="Location" id="hintcity" autocomplete="off">
                            <input type="hidden" class="form-control" name="city" id="city">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group shadow">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" id="hint" class="form-control ui-autocomplete-input" name="keyword" placeholder="Search Hospitals/Doctors/Clinics etc" autocomplete="off">
                        </div>
                        
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group shadow">
                            <span class="input-group-addon"><i class="fa fa-user-md"></i></span>
                            <select class="form-control" name="spl">
              <option value="">-Specialization-</option>
                                              <?php foreach($specialization as $s){ ?>
                                <option value='<?=$s->id;?>'><?=$s->name;?></option>
							<?php } ?>
                                               
                            </select>
                        </div>
                        
                    </div>
                    <div class="col-sm-1">
<button class="careplus-booking-btn careplus-bgcolor-two" id="searchBTN"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>




                    <div class="clearfix"></div>
                </div>
                </form>
                
<!--
    <div class="careplus-subheader">
        <div class="careplus-subheader-image">
            <span class="careplus-dark-transparent"></span>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Doctor Panel Forget Password</h1>

                    </div>
                </div>
            </div>
        </div>
        <div class="careplus-breadcrumb">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li><a href="<?=base_url();?>">Homepage</a></li>
                            <li ><a href="<?=base_url('doctor-login');?>">Login</a></li>							
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->

         <div class="container">
            <div class="row">
                <form action='<?=base_url();?>hospitaluser/otppass' method='post' id='drforgotform'>
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <div class="col-sm-6 col-md-offset-3 borders" id="designforform">
                        <div class="box-header"><h4>Upchar Hospital Email / Mobile</h4></div>
                        <div class="label_name">                 
                            <input value="" type="text" name="mobile" class="form-control" placeholder='Enter Registered Email or Mobile' required>
                            <p style="font-size:14px; font-family: 'Inter', sans-serif; color: #64748b; padding: 10px 0;">
                                You will receive an OTP on your registered mobile number.<br> Verify OTP to reset and create your new hospital portal password.
                            </p>

                            <div class="row" style="margin-top: 15px;"> 
                                <button type="submit" class="btn" style="border-radius: 5px; letter-spacing: 1px; padding: 8px 24px; background: #00a896; color: white; float: left;">Send OTP Code</button>
                                <a id="forgetpassworduser" class="bottomBtns" href="<?=base_url('hospital-login');?>" style="background: #043d5b;">Back to Login</a>
                            </div>
                        </div>                 
                    </div>
                </form>
						
                <form id='hsforgototpform' action='<?=base_url();?>hospitaluser/verifyforgototp' method='post' style='display:none;'>
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <div class="col-sm-4 col-md-offset-4 borders" id="designforform">                          
                        <div class="box-header"><h4 style="font-weight:bold;">Enter 6-Digit OTP</h4></div>                           
                        <div class="label_name">                                               
                            <input type="text" name="otp" class="form-control" placeholder="••••••" maxlength="6" style="text-align: center; font-size: 20px; font-weight: 700; letter-spacing: 4px;" required>      
                            <button type="submit" class="btn btn-lg common-btn practo-btn" style="margin-top: 12px !important; color: white; background: #00a896; width: 100%;"> Verify &amp; Continue </button>  
                        </div> 
                        <div style="margin-top: 14px; text-align: right;"> 
                            <a href='javascript:void(0);' class='drresendfotp' style="color: #00a896; font-weight: bold; font-size: 13px;"><i class="fa fa-refresh"></i> Resend OTP</a>
                        </div> 
                    </div>
                </form>
  
                <form id='hsfoegotnewpassform' action='<?=base_url();?>hospitaluser/setnewpass' method='post' style='display:none;'>
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    <div class="col-sm-4 col-md-offset-4 borders" id="designforform">                         
                        <div class="box-header"><h4>Set New Password</h4></div>                            
                        <div class="label_name">                                                
                            <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px;">New Password (Min 6 chars)</label>                                 
                            <input type="password" name="pass" class="form-control" placeholder="Enter new password" minlength="6" required>      
                            <button type="submit" class="btn btn-lg common-btn practo-btn" style="margin-top: 14px !important; background: #00a896; color: #fff; width: 100%;" required> Update Password &amp; Login </button>            
                        </div>                                                                                                    
                    </div>
                </form>
    
  
    
    
      </div>
          </div>

   
	<script>
	$('#drforgotform').submit(function(e) {		
		e.preventDefault();		
		var myform = $(this);		
		$.ajax({			
			type: "POST",			
			url: myform.attr('action'),			
			data: myform.serialize(),			
			success: function(response) {				 
				try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}				
				if (response && response.status === 'success'){
					$('#drforgotform').hide();
					$('#hsforgototpform').show();
				} else {					
					alert(response && response.msg ? response.msg : 'No registered hospital found with this email/mobile.');				
				}			
			},
			error: function() {
				alert('Connection error. Please try again.');
			}		
		});			
	});		
	
	$('#hsforgototpform').submit(function(e) {		
		e.preventDefault();		
		var myform = $(this);		
		$.ajax({			
			type: "POST",			
			url: myform.attr('action'),			
			data: myform.serialize(),			
			success: function(response) {				
				try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}				
				if (response && response.status === 'success'){										
					$('#hsforgototpform').hide();
					$('#hsfoegotnewpassform').show();
				} else {					
					alert(response && response.msg ? response.msg : 'Incorrect OTP. Please check and try again.');									
				}		
			},
			error: function() {
				alert('Verification failed. Please try again.');
			}
		});
	});		
	
	$('#hsfoegotnewpassform').submit(function(e) {		
		e.preventDefault();		
		var myform = $(this);		
		$.ajax({			
			type: "POST",			
			url: myform.attr('action'),			
			data: myform.serialize(),			
			success: function(response) {				
				try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}				
				if (response && response.status === 'success'){										
					alert(response.msg || 'Password updated successfully! Redirecting to login...');
					window.location = "<?=base_url();?>hospital-login";
				} else {					
					alert(response && response.msg ? response.msg : 'Password update failed.');									
				}		
			},
			error: function() {
				alert('Password update failed. Please try again.');
			}
		});
	});		

	$('.drresendfotp').click(function(e) {		
		e.preventDefault();		
		$.ajax({			
			type: "POST",			
			url: '<?=base_url();?>hospitaluser/resendforgetotp',
			data: { '<?=$this->security->get_csrf_token_name();?>': '<?=$this->security->get_csrf_hash();?>' },			
			success: function(response) {				
				try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}				
				if (response && response.status === 'success'){										
					alert(response.msg || 'A fresh OTP has been sent.');
				} else {					
					alert(response && response.msg ? response.msg : 'Failed to resend OTP.');									
				}		
			},
			error: function() {
				alert('Could not resend OTP. Please try again.');
			}
		});
	});		
	</script>