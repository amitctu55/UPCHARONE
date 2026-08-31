<?php 
$userlogin=$this->Userlogin_Model->c_count();
?>
<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<!-- Universal Modern Healthcare Footer (#1D2A44) -->
<footer class="upchar-footer">
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<!-- Column 1: Company Info -->
				<div class="col-lg-4 col-md-4 col-sm-12 footer-col">
					<a href="<?=base_url();?>" class="footer-logo">
						<img src="<?=base_url('images/Upchar_footer.png');?>" alt="Upchar Healthcare" class="footer-brand-logo">
					</a>
					<p class="footer-about-text">
						Workboat Media Private Limited (“UPCHAR”) is India’s trusted digital healthcare network connecting patients with verified specialist doctors, accredited hospitals, live bed tracking, diagnostic labs, and 24/7 emergency support.
					</p>
					<div class="footer-badge-pill">
						<i class="fas fa-shield-alt"></i> Verified Healthcare Network
					</div>
				</div>

				<!-- Column 2: Quick Links -->
				<div class="col-lg-2 col-md-2 col-sm-6 footer-col">
					<h4 class="footer-title">Quick Links</h4>
					<ul class="footer-links-list">
						<li><a href="<?=base_url();?>"><i class="fas fa-chevron-right"></i> Home</a></li>
						<li><a href="<?=base_url('doctors');?>"><i class="fas fa-chevron-right"></i> Find Doctors</a></li>
						<li><a href="<?=base_url('hospitals');?>"><i class="fas fa-chevron-right"></i> Hospitals & Clinics</a></li>
						<li><a href="<?=base_url('doctors');?>"><i class="fas fa-chevron-right"></i> Video Consult</a></li>
						<li><a href="<?=base_url('aboutus');?>"><i class="fas fa-chevron-right"></i> About Us</a></li>
						<li><a href="<?=base_url('Home/services');?>"><i class="fas fa-chevron-right"></i> Our Services</a></li>
						<li><a href="https://upcharrnews.blogspot.com/" target="_blank"><i class="fas fa-chevron-right"></i> Health Blog</a></li>
					</ul>
				</div>

				<!-- Column 3: Legal & Trust -->
				<div class="col-lg-3 col-md-3 col-sm-6 footer-col">
					<h4 class="footer-title">Legal & Trust</h4>
					<ul class="footer-links-list">
						<li><a href="<?=base_url('privacy');?>"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
						<li><a href="<?=base_url('tnc');?>"><i class="fas fa-chevron-right"></i> Terms & Conditions</a></li>
						<li><a href="<?=base_url('refund_cancellation');?>"><i class="fas fa-chevron-right"></i> Refund Policy</a></li>
						<li><a href="<?=base_url('doctor-signup');?>"><i class="fas fa-chevron-right"></i> Doctor Onboarding</a></li>
						<li><a href="<?=base_url('hospital-signup');?>"><i class="fas fa-chevron-right"></i> Hospital Registration</a></li>
						<li><a href="<?=base_url('Home/career');?>"><i class="fas fa-chevron-right"></i> Careers & Jobs</a></li>
						<li><a href="<?=base_url('Upchar_Patient.apk');?>"><i class="fas fa-download"></i> Download App</a></li>
					</ul>
				</div>

				<!-- Column 4: Contact & Help -->
				<div class="col-lg-3 col-md-3 col-sm-12 footer-col">
					<h4 class="footer-title">Contact & Help</h4>
					<ul class="footer-contact-list">
						<li class="footer-contact-item">
							<div class="footer-contact-icon"><i class="fas fa-phone-alt"></i></div>
							<div class="footer-contact-info">
								<h6>24/7 Helpline</h6>
								<p><a href="tel:8448440603">844-844-0603</a></p>
							</div>
						</li>
						<li class="footer-contact-item">
							<div class="footer-contact-icon"><i class="fas fa-envelope"></i></div>
							<div class="footer-contact-info">
								<h6>Support Email</h6>
								<p><a href="mailto:hello@upchar.info">hello@upchar.info</a></p>
							</div>
						</li>
						<li class="footer-contact-item">
							<div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
							<div class="footer-contact-info">
								<h6>Registered Office</h6>
								<p>N8/251 A-1-11 Newada, Sundarpur, BHU to DLW Road, Varanasi, UP 221005</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!-- Copyright & Socials Bar -->
	<div class="footer-bottom">
		<div class="container">
			<div class="footer-bottom-flex">
				<p class="footer-copyright">
					&copy; <?=date('Y');?> <strong>Upchar One Place of Healthcare</strong>. All Rights Reserved.
				</p>
				<ul class="footer-social-list">
					<li>
						<span style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: 9999px; padding: 4px 12px; font-size: 11.5px; color: #94A3B8; margin-right: 6px;">
							<i class="fas fa-eye" style="color: #00A896; margin-right: 4px;"></i> Visits: <strong><?=$userlogin;?></strong>
						</span>
					</li>
					<li><a href="https://www.facebook.com/Upchar-online-Medical-solution-2187443094907268/" target="_blank" class="footer-social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
					<li><a href="https://twitter.com/amitkum35423465" target="_blank" class="footer-social-link" title="Twitter"><i class="fab fa-twitter"></i></a></li>
					<li><a href="https://linkedin.com/" target="_blank" class="footer-social-link" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>

<!-- Floating Back-to-Top Button -->
<a href="javascript:void(0);" id="backToTopBtn" class="back-to-top-btn" title="Back to top">
	<i class="fas fa-arrow-up"></i>
</a>
<!--// Footer \\-->
<div class="clearfix"></div>
<!--// Main Wrapper \\-->
<!-- Modal -->
<div class="modal fade searchmodal" id="searchmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
		<div class="modal-body">
			<a href="#" class="careplus-close-btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
			<form>
				<input type="text" value="Type Your Keyword" onblur="if(this.value == '') { this.value ='Type Your Keyword'; }" onfocus="if(this.value =='Type Your Keyword') { this.value = ''; }">
				<input type="submit" value="">
				<i class="fa fa-search"></i>
			</form>
		</div>
    </div>
</div>
<!-- Top-level Book Appointment Modal (Direct Scope of <body>) -->
<div class="modal fade" id="myModal" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<div>
					<h4 class="modal-header-title" id="myModalLabel"><i class="fas fa-calendar-check"></i> Book Appointment</h4>
					<p class="modal-header-subtitle"><i class="fas fa-shield-alt"></i> Verified Consultation &bull; Zero Booking Charges</p>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div>

			<div class="modal-body">
				<!-- Consultation Mode Switcher -->
				<div class="consult-type-switcher">
					<button type="button" class="consult-type-btn active" data-type="in_clinic">
						<i class="fas fa-clinic-medical"></i> In-Person Visit
					</button>
					<button type="button" class="consult-type-btn" data-type="video_consult">
						<i class="fas fa-video"></i> Video Consultation
					</button>
				</div>

				<!-- Doctor & Clinic Mini Preview -->
				<div class="modal-doc-summary-card" id="app_conf_pop_doctor" style="margin-bottom: 10px;">
					<div class="text-center" style="padding: 12px; color: #64748B;">
						<i class="fas fa-spinner fa-spin" style="font-size: 20px; color: #00A896; margin-bottom: 4px;"></i>
						<p style="margin: 0; font-size: 12.5px;">Loading doctor details...</p>
					</div>
				</div>

				<div class="modal-doc-summary-card" id="app_conf_pop_institute" style="margin-bottom: 12px;">
					<div class="text-center" style="padding: 8px; color: #64748B;">
						<p style="margin: 0; font-size: 12px;"><i class="fas fa-map-marker-alt" style="color: #00A896;"></i> Select date & time to view facility</p>
					</div>
				</div>

				<form method="post" action="<?=base_url();?>home/bookappointment" id="app_conf_form">
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
					<input type="hidden" name="consultation_type" id="app_consult_type" value="in_clinic">
					<input value="" type="hidden" id="app_conf_pop_doctorid" name="app_doctor">

					<div class="consult-form-box">
						<div class="row">
							<div class="col-xs-6" style="padding-right: 6px;">
								<label><i class="fas fa-calendar-day" style="color: #00A896;"></i> Date <span style="color: #EF4444;">*</span></label>
								<select class="form-control" name="app_date" id="app_conf_pop_date" required></select>
							</div>
							<div class="col-xs-6" style="padding-left: 6px;">
								<label><i class="fas fa-clock" style="color: #00A896;"></i> Time Slot <span style="color: #EF4444;">*</span></label>
								<select class="form-control" name="app_time" id="app_conf_pop_time" required></select>
							</div>
						</div>

						<label><i class="fas fa-user" style="color: #00A896;"></i> Patient Name <span style="color: #EF4444;">*</span></label>
						<input value="<?=@$userdata['name'];?>" type="text" name="app_name" id="app_conf_name" class="form-control" placeholder="Enter patient's full name" required>

						<label><i class="fas fa-phone-alt" style="color: #00A896;"></i> Mobile Number <span style="color: #EF4444;">*</span></label>
						<input value="<?=@$userdata['mobile'];?>" type="tel" name="app_mobile" id="app_conf_mobile" class="form-control" placeholder="10-digit mobile number" onkeypress="return isNumber(event)" maxlength="10" required>

						<label><i class="fas fa-envelope" style="color: #00A896;"></i> Email Address (Optional)</label>
						<input value="<?=@$userdata['email'];?>" type="email" name="app_email" id="app_conf_email" class="form-control" placeholder="For instant digital prescription & receipt">

						<?php if($this->session->userdata('userid')==''){ ?>
						<div style="display:none;" id="app_conf_otp">
							<label><i class="fas fa-key" style="color: #00A896;"></i> Verification OTP <span style="color: #EF4444;">*</span></label>
							<input value="" type="text" name="app_otp" class="form-control" placeholder="Enter 4-digit OTP" required>
						</div>
						<?php } ?>

						<!-- Dynamic Guidance Text Box -->
						<div id="mode_guidance_box" style="background: #F0FDF4; border: 1px solid #DCFCE7; border-radius: 10px; padding: 10px 12px; margin-bottom: 14px; font-size: 12px; color: #166534; line-height: 1.4;">
							<i class="fas fa-clinic-medical" style="color: #16A34A; margin-right: 6px;"></i>
							<strong>In-Person Visit:</strong> Confirmed direct appointment at clinic. Minimal wait time assured.
						</div>

						<div>
							<?php if($this->session->userdata('userid')==''){ ?>
							<button type="button" id="app_conf_otp_submit" class="btn btn-primary-cta" style="width: 100%; justify-content: center; padding: 12px; font-size: 14.5px; border-radius: 8px;">
								<i class="fas fa-paper-plane"></i> Send Verification OTP
							</button>
							<button type="submit" style="display:none; width: 100%; justify-content: center; padding: 12px; font-size: 14.5px; border-radius: 8px;" id="app_conf_submit" class="btn btn-primary-cta">
								<i class="fas fa-check-circle"></i> Verify & Confirm Appointment
							</button>
							<?php } else { ?>
							<button type="submit" id="app_conf_submit" class="btn btn-primary-cta" style="width: 100%; justify-content: center; padding: 12px; font-size: 14.5px; border-radius: 8px;">
								<i class="fas fa-check-circle"></i> Confirm & Book Appointment
							</button>
							<?php } ?>
						</div>
						<p style="font-size: 11px; color: #94A3B8; margin-top: 8px; text-align: center; margin-bottom: 0;">
							By booking, you agree to Upchar's <a href="<?=base_url('tnc');?>" style="color: #00A896;">Terms of Service</a> & <a href="<?=base_url('privacy');?>" style="color: #00A896;">Privacy Policy</a>.
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// When the document is ready
	$(document).ready(function () {
		$('#example1').datepicker({
			format: "dd/mm/yyyy"
		});

		$('#backToTopBtn').on('click', function(e) {
			e.preventDefault();
			$('html, body').animate({scrollTop: 0}, 400);
		});

		$(window).on('scroll', function() {
			if ($(this).scrollTop() > 300) {
				$('#backToTopBtn').css('display', 'flex').fadeIn(200);
			} else {
				$('#backToTopBtn').fadeOut(200);
			}
		});
	});
</script>
<script>
function isNumber(evt) 
{
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
<script type="text/javascript" src="<?=base_url();?>css/bootstrap-datepicker.js"></script>
<script>
	$('#registrationform').submit(function(e) {
		e.preventDefault(e);
		/* $('button[type=submit], input[type=submit]').prop('disabled',true); */
		var myform=$(this);
    var validation = true;
    var email = $('#email').val();
    var mobile = $('#mobile').val();
    var name = $('#name').val();
    var password = $('#password').val();
    if(email!='' && !isEmail(email)){
      validation=false;
      myalert('Please Enter a Valid Email Address','Invalid');
      return false;
    }
    if(mobile=='' || mobile.length !=10 ){
      validation=false;
      myalert('Please Enter a Valid Mobile Number','Invalid');
      return false;
    }
    if(name=='' || name.length <3 ){
      validation=false;
      myalert('Please Enter your Valid Name','Invalid');
      return false;
    }
    if(password=='' || password.length <8 ){
      validation=false;
      myalert('Please Enter atleast 8 Character Password','Invalid');
      return false;
    }
    if(validation==true){
		$.ajax({
			type: "POST",
			url: myform.attr('action'),
			data: myform.serialize(),
			success: function( response ) {
				response = JSON.parse(response);
				if(response.status=='success'){
					window.location="<?=base_url();?>verifymobile";
				}
				else if(response.status=='failed'){
					myalert(response.msg);
				}else{
					myalert('opps'+response.msg);
				}
				console.log( response );
			}
		});
    }		
	});
	</script>
	<script>
	$('#loginform').submit(function(e) {
		e.preventDefault(e);
		/* $('button[type=submit], input[type=submit]').prop('disabled',true); */
		var myform=$(this);
		$.ajax({
			type: "POST",
			url: myform.attr('action'),
			data: myform.serialize(),
			success: function( response ) {
				response = JSON.parse(response);
				if(response.status=='success'){
				//location.reload();
				window.location="<?=$this->session->userdata('last_page');?>";
				}
				else if(response.status=='otp'){
					window.location="<?=base_url();?>verifymobile";
				}
				else if(response.status=='failed'){
					myalert(response.msg);
				}else{
					myalert('opps'+response.msg);
				}
				console.log( response );
			}
		});
	});

	</script>
	<script>
	$('#forgotform').submit(function(e) {
		e.preventDefault(e);
		var myform=$(this);
		$.ajax({
			type: "POST",
			url: myform.attr('action'),
			data: myform.serialize(),
			success: function( response ) {
				response = JSON.parse(response);
				if(response.status=='success'){
				//window.location="<?=$this->session->userdata('last_page');?>";
				//window.location="<?=base_url();?>verifymobileforgot";
				$('#forgotform').hide();
				$('#forgototpform').show();
				}else{
					myalert('opps'+response.msg);
				}
				console.log( response );
			}
		});
	});

	</script>
	<script>
	$('#signupotpform').submit(function(e) {
		e.preventDefault(e);
		/* $('button[type=submit], input[type=submit]').prop('disabled',true); */
		var myform=$(this);


	//if(validation==true){
		$.ajax({
		type: "POST",
		url: myform.attr('action'),
		data: myform.serialize(),
		success: function( response ) {
			response = JSON.parse(response);
			if(response.status=='success'){
				//window.location="<?=base_url();?>";
				window.location="<?=$this->session->userdata('last_page');?>";
			}else if(response.status=='failed'){
				myalert(response.msg);
			}else{
				myalert('opps'+response.msg);
			}
			console.log( response );
		}
		});
	//}
	});
	$('.resendotp').click(function(e) {
		e.preventDefault(e);
		/* $('button[type=submit], input[type=submit]').prop('disabled',true); */
		//var myform=$(this);
		$.ajax({
		type: "POST",
		url: '<?=base_url();?>user/resendsignupotp',//myform.attr('action'),
		//data: myform.serialize(),
		success: function( response ) {
			response = JSON.parse(response);
			if(response.status=='success'){
				//window.location="<?=base_url();?>";
				myalert(response.msg);
				//window.location="<?=$this->session->userdata('last_page');?>";
			}else if(response.status=='failed'){
				myalert(response.msg);
			}else{
				myalert('opps'+response.msg);
			}
			console.log( response );
		}
		});
	});
	$('.resendfotp').click(function(e) {
		e.preventDefault(e);
		/* $('button[type=submit], input[type=submit]').prop('disabled',true); */
		//var myform=$(this);
		$.ajax({
		type: "POST",
		url: '<?=base_url();?>user/resendforgetotp',//myform.attr('action'),
		//data: myform.serialize(),
		success: function( response ) {
			response = JSON.parse(response);
			if(response.status=='success'){
				//window.location="<?=base_url();?>";
				myalert(response.msg);
				//window.location="<?=$this->session->userdata('last_page');?>";
			}else if(response.status=='failed'){
				myalert(response.msg);
			}else{
				myalert('opps'+response.msg);
			}
			console.log( response );
		}
		});
	});

	$('#forgototpform').submit(function(e) {
		e.preventDefault(e);
		var myform=$(this);
		$.ajax({
		type: "POST",
		url: myform.attr('action'),
		data: myform.serialize(),
		success: function( response ) {
			response = JSON.parse(response);
			if(response.status=='success'){
				//window.location="<?=base_url();?>";
				//window.location="<?=$this->session->userdata('last_page');?>";
				$('#forgototpform').hide();
				$('#forgotnewpassform').show();
			}else if(response.status=='failed'){
				myalert(response.msg);
			}else{
				myalert('opps'+response.msg);
			}
			console.log( response );
		}
		});
	});

	$('#forgotnewpassform').submit(function(e) {
		e.preventDefault(e);
		var myform=$(this);
		$.ajax({
		type: "POST",
		url: myform.attr('action'),
		data: myform.serialize(),
		success: function( response ) {
			response = JSON.parse(response);
			if(response.status=='success'){
				window.location="<?=base_url();?>login";
				//window.location="<?=$this->session->userdata('last_page');?>";
				//$('#forgototpform').hide();
				//$('#forgotnewpassform').show();
			}else if(response.status=='failed'){
				myalert(response.msg);
			}else{
				myalert('opps'+response.msg);
			}
			console.log( response );
		}
		});
	});

	$('body').on('click','.getappointment',function(e) {
		e.preventDefault();
		e.stopPropagation();

		// Ensure all text inputs are enabled and immediately editable
		$('#app_conf_name, #app_conf_mobile, #app_conf_email, #app_conf_pop_date, #app_conf_pop_time').prop('disabled', false).removeAttr('disabled');

		$('#app_conf_pop_doctor').html('<div class="text-center" style="padding: 12px; color: #64748B;"><i class="fas fa-spinner fa-spin" style="font-size: 20px; color: #00A896; margin-bottom: 4px;"></i><p style="margin: 0; font-size: 12.5px;">Loading doctor details...</p></div>');
		$('#app_conf_pop_date').html('<option value="">-- Loading Available Dates --</option>');
		$('#app_conf_pop_time').html('<option value="">-- Select Date First --</option>');
		$('#app_conf_pop_institute').html('<div class="text-center" style="padding: 8px; color: #64748B;"><p style="margin: 0; font-size: 12px;"><i class="fas fa-map-marker-alt" style="color: #00A896;"></i> Select date & time to view facility</p></div>');
		
		$('.consult-type-btn').removeClass('active');
		$('.consult-type-btn[data-type="in_clinic"]').addClass('active');
		$('#app_consult_type').val('in_clinic');
		$('#mode_guidance_box').css({'background': '#F0FDF4', 'border-color': '#DCFCE7', 'color': '#166534'})
			.html('<i class="fas fa-clinic-medical" style="color: #16A34A; margin-right: 6px;"></i><strong>In-Person Visit:</strong> Confirmed direct appointment at clinic. Minimal wait time assured.');

		var did = $(this).attr('data-upchar-did') || $(this).attr('data-did') || $(this).attr('data-id') || $(this).data('did') || $(this).data('id') || $(this).data('upchar-did') || $(this).attr('id') || '';
		
		// Fallback: search closest card or container for doctor ID or profile link
		if (!did || did === '0') {
			did = $(this).closest('.doctor-card, .box_sh_bg, .item, .doc-col-right').find('[data-upchar-did]').not(this).attr('data-upchar-did') || '';
		}
		if (!did || did === '0') {
			var profLink = $(this).closest('.doctor-card, .box_sh_bg, .item, .doc-col-right').find('a[href*="/doctor/"]').attr('href') || '';
			if (profLink) {
				var matches = profLink.match(/\/doctor\/(\d+)/);
				if (matches && matches[1]) {
					did = matches[1];
				}
			}
		}
		$('#app_conf_pop_doctorid').val(did);

		// Guarantee modal opens reliably
		$('#myModal').modal('show');

		try {
			$.ajax({
				type: "GET",
				url: "<?=base_url();?>home/app_conf_pop_doctor?doctor="+did,
				success: function( data ) {
					$('#app_conf_pop_doctor').html(data);
				},
				error: function() {
					$('#app_conf_pop_doctor').html('<div style="padding: 8px 12px; font-size: 13px; color: #0F172A; font-weight: 600;"><i class="fas fa-user-md" style="color: #00A896; margin-right: 6px;"></i>Verified Medical Specialist</div>');
				}
			});

			$.ajax({
				type: "GET",
				url: "<?=base_url();?>home/app_conf_pop_date?doctor="+did,
				success: function( data ) {
					$('#app_conf_pop_date').html(data);
					// If date options exist, auto-select first date and load timings
					var firstDate = $('#app_conf_pop_date option:nth-child(2)').val() || $('#app_conf_pop_date option:first').val();
					if (firstDate) {
						$('#app_conf_pop_date').val(firstDate).trigger('change');
					}
				},
				error: function() {
					$('#app_conf_pop_date').html('<option value="<?=date('Y-m-d');?>"><?=date('D, jS M Y');?></option>').trigger('change');
				}
			});
		} finally {
			$('#app_conf_name, #app_conf_mobile, #app_conf_email').prop('disabled', false).removeAttr('disabled');
		}
	});

	$('body').on('click', '.consult-type-btn', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var type = $(this).attr('data-type');
		$('.consult-type-btn').removeClass('active');
		$(this).addClass('active');
		$('#app_consult_type').val(type);

		if (type === 'video_consult') {
			$('#mode_guidance_box').css({'background': '#EFF6FF', 'border-color': '#DBEAFE', 'color': '#1E40AF'})
				.html('<i class="fas fa-video" style="color: #2563EB; margin-right: 6px;"></i><strong>Online Video Consultation:</strong> Join from mobile or computer via encrypted video link sent to your phone. Instant digital prescription provided.');
			$('#app_conf_pop_institute').html('<div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:14px;color:#1E40AF;font-size:13px;"><i class="fas fa-video" style="color:#2563EB;margin-right:6px;"></i><strong>Online Video Consultation</strong><p style="margin:6px 0 0;font-size:12px;color:#3B82F6;">Consult securely from home via private HD video link. Instant e-prescription included.</p></div>');
		} else {
			$('#mode_guidance_box').css({'background': '#F0FDF4', 'border-color': '#DCFCE7', 'color': '#166534'})
				.html('<i class="fas fa-clinic-medical" style="color: #16A34A; margin-right: 6px;"></i><strong>In-Person Visit:</strong> Confirmed direct appointment at clinic. Minimal wait time assured.');
			var date = $('#app_conf_pop_date').val();
			var did = $('#app_conf_pop_doctorid').val();
			var time = $('#app_conf_pop_time').val();
			if (date && time && did) {
				$.ajax({
					type: "GET",
					url: "<?=base_url();?>home/app_conf_pop_institute?doctor="+did+"&date="+date+"&time="+time,
					success: function(data) {
						$('#app_conf_pop_institute').html(data);
					}
				});
			} else {
				$('#app_conf_pop_institute').html('<div class="text-center" style="padding: 10px; color: #64748B;"><p style="margin: 0; font-size: 13px;"><i class="fas fa-map-marker-alt" style="color: #00A896;"></i> Select date and time to view location</p></div>');
			}
		}

		// Re-trigger date change to refresh time slots for video / in_clinic mode
		var curDate = $('#app_conf_pop_date').val();
		if (curDate) {
			$('#app_conf_pop_date').trigger('change');
		}
	});

	$('body').on('change','#app_conf_pop_date',function(e) {
		var date = $(this).val();
		var did = $('#app_conf_pop_doctorid').val();
		var consultType = $('#app_consult_type').val() || 'in_clinic';

		if (date && did) {
			$.ajax({
				type: "GET",
				url: "<?=base_url();?>home/app_conf_pop_time?doctor="+did+"&date="+date+"&consult_type="+consultType,
				success: function( data ) {
					$('#app_conf_pop_time').html(data);
					var firstTime = $('#app_conf_pop_time option:nth-child(2)').val() || $('#app_conf_pop_time option:first').val();
					if (firstTime) {
						$('#app_conf_pop_time').val(firstTime).trigger('change');
					}
				},
				error: function() {
					$('#app_conf_pop_time').html('<option value="morning_1">09:30 AM - 11:00 AM</option><option value="evening_1">05:00 PM - 06:30 PM</option>').trigger('change');
				}
			});
		}
	});

	$('body').on('change','#app_conf_pop_time',function(e) {
		var date = $('#app_conf_pop_date').val();
		var did = $('#app_conf_pop_doctorid').val();
		var time = $('#app_conf_pop_time').val();
		var consultType = $('#app_consult_type').val();

		if (consultType !== 'video_consult' && date && did && time) {
			$.ajax({
				type: "GET",
				url: "<?=base_url();?>home/app_conf_pop_institute?doctor="+did+"&date="+date+"&time="+time,
				success: function(data) {
					$('#app_conf_pop_institute').html(data);
				}
			});
		}
	});

	$('body').on('click','#app_conf_otp_submit',function(e) {
		e.preventDefault();
		e.stopPropagation();
		var date = $('#app_conf_pop_date').val();
		var did = $('#app_conf_pop_doctorid').val();
		var time = $('#app_conf_pop_time').val();
		var mobile = $('#app_conf_mobile').val();
		var name = $('#app_conf_name').val();
		if(name=='' || mobile=='' || mobile.length<10 || mobile.length>10 || time==''){
			myalert('Please Fill the Form with Valid Details');
		}else{
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>home/app_conf_pop_otpgen",
				data: 'mobile=' + mobile,
				success: function( data ) {
				}
			});
			$('#app_conf_otp').show();
			$('#app_conf_otp_submit').hide();
			$('#app_conf_submit').show();
		}
	});

	$('body').on('submit','#app_conf_form',function(e) 
	{	
		e.preventDefault();
		e.stopPropagation();
		var myform=$(this);
		$.ajax({
			url: myform.attr('action'),
			data: myform.serialize(),
			type: "POST",
			success: function(data) 
			{	  
				if(data=='OK')
				{
					window.location="<?=base_url();?>paysecure/acheckout";
				}
				else if(data=='Not Available')
				{
					$('#myModal').modal('hide');
					myalert('Not available','Not Available');
				}
				else
					myalert('Failed');
			}
		});
	});


	});

	</script>
 <!--<script src="//code.jquery.com/jquery-1.12.4.js"></script>-->
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
  <script type="text/javascript">

        $(function() {
			/* $( "#hint" ).autocomplete({
			  source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ]
			}); */
             $( "#hint" ).autocomplete({
				 minLength: 1,
                source: function( request, response ) {
                    $.ajax({
                        url: "<?=base_url();?>gethint",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function( data ) {
                           response( data );
						   /* response( $.map( data.myData, function( item ) {
								return {
									label: item.label,
									value: item.value
								}
							})); */
                        }
                    });
                }/* ,
				select:	function(event,b){
					event.preventDefault();
					$(this).val(b.item.label);
					$('#city').val(b.item.value);

				} */
            });
			$( "#hintcity" ).autocomplete({
				minLength: 1,
                source: function( request, response ) {
                    $.ajax({
                        url: "<?=base_url();?>gethintcity",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function( data ) {
                           // response( data );
							response( $.map( data, function( item ) {
								return {
									label: item.label,
									value: item.value
								}
							}));
                        }
                    });
                },
				select:	function(event,b){
					event.preventDefault();
					$(this).val(b.item.label);
					$('#city').val(b.item.value);
					/* document.cookie = "mart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
					$('#headermart').html('Market');
					$('#headermartm').html('Market');
					setCookie('city', b.item.value , 2);
					$.ajax({
						url: "http://www.mylomart.com/mylomart/martautofill",
						data: {city: b.item.value},
						success: function( data ) {
							if(data!=''){
							$( ".top-mrkt" ).hide();
							$( ".avlbl-mrkt" ).html(data).fadeIn(200);

							$('#headercity').html(b.item.label);
							$('#headercitym').html(b.item.label);

							}
						}
					}); */
				}


            });
        });

	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
        </script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css"><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script><script>function myalert(content='',title='Alert!'){	$.alert({    title: title,    content: content,});}
<?php
$flashmsg=$this->session->flashdata('flashmsg');
if(is_array($flashmsg) && isset($flashmsg['status']) && $flashmsg['status']!='') {
	echo "myalert('".@$flashmsg['msg']."','".@$flashmsg['status']."')";
}
?>
</script>
  </body>

</html>
