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
					<a href="<?=base_url();?>" class="footer-logo" title="Upchar - One Place of Healthcare">
						<img src="<?=base_url('images/Upchar_footer.png');?>" onerror="this.onerror=null; this.src='<?=base_url('images/Final_logo23.png');?>';" alt="Upchar Healthcare" class="footer-brand-logo" style="height: 52px; width: auto; max-width: 100%; object-fit: contain;">
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
						<li><a href="https://upchar.info/" target="_blank"><i class="fas fa-chevron-right"></i> Health Blog</a></li>
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
<?php
$cur_userid = $this->session->userdata('userid') ?: $this->session->userdata('USERID');
$cur_user = null;
if (!empty($cur_userid)) {
    $cur_user = $this->db->get_where('userlogin', array('USERID' => $cur_userid))->row();
}
$is_logged_in = !empty($cur_userid);
$user_name = $cur_user ? trim($cur_user->FNAME . ' ' . $cur_user->LNAME) : ($this->session->userdata('username') ?: '');
$user_mobile = $cur_user ? $cur_user->MOBILE : '';
$user_email = $cur_user ? $cur_user->EMAIL : ($this->session->userdata('useremail') ?: '');
?>
<script type="text/javascript">
window.UPCHAR_AUTH = {
    is_logged_in: <?= $is_logged_in ? 'true' : 'false' ?>,
    user_id: "<?= $cur_userid ?: '' ?>",
    name: "<?= addslashes($user_name) ?>",
    mobile: "<?= addslashes($user_mobile) ?>",
    email: "<?= addslashes($user_email) ?>"
};
</script>

<div class="modal fade" id="myModal" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 520px; margin: 30px auto;">
		<div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.18); overflow: hidden;">
			
			<!-- Modal Header with Dynamic Step Tabs -->
			<div class="modal-header" style="background: linear-gradient(135deg, #00A896 0%, #05668D 100%); color: #fff; padding: 18px 24px; position: relative;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.9; font-size: 26px; position: absolute; right: 20px; top: 16px; line-height: 1;">&times;</button>
				<h4 class="modal-header-title" id="myModalLabel" style="font-weight: 700; font-size: 18px; margin: 0; color: #fff; display: flex; align-items: center; gap: 8px;">
					<i class="fas fa-calendar-check"></i> Book Doctor Appointment
				</h4>
				<p class="modal-header-subtitle" style="margin: 4px 0 0; font-size: 12.5px; opacity: 0.9; color: #E0F2FE;">
					<i class="fas fa-shield-alt"></i> Verified Consultation &bull; Zero Platform Fee
				</p>

				<!-- Stepper Indicator -->
				<div class="booking-wizard-steps" style="display: flex; gap: 6px; margin-top: 14px;">
					<div class="wiz-tab-bar active" id="wiz_tab_1" style="flex: 1; height: 4px; border-radius: 2px; background: #fff; transition: all 0.3s ease;"></div>
					<div class="wiz-tab-bar" id="wiz_tab_2" style="flex: 1; height: 4px; border-radius: 2px; background: rgba(255,255,255,0.35); transition: all 0.3s ease;"></div>
					<div class="wiz-tab-bar" id="wiz_tab_3" style="flex: 1; height: 4px; border-radius: 2px; background: rgba(255,255,255,0.35); transition: all 0.3s ease;"></div>
				</div>
				<div style="display: flex; justify-content: space-between; font-size: 11px; margin-top: 6px; color: #E0F2FE;">
					<span id="step_label_1" style="font-weight: 700;">1. Schedule</span>
					<span id="step_label_2" style="opacity: 0.8;">2. Verify Patient</span>
					<span id="step_label_3" style="opacity: 0.8;">3. Finalize</span>
				</div>
			</div>

			<div class="modal-body" style="padding: 20px 24px; background: #F8FAFC;">
				
				<!-- ==============================================
				     STAGE 1: SCHEDULE SELECTION
				     ============================================== -->
				<div id="booking_step_1" class="booking-step-panel">
					<!-- Consultation Mode Switcher -->
					<div class="consult-type-switcher" style="margin-bottom: 14px;">
						<button type="button" class="consult-type-btn active" data-type="in_clinic">
							<i class="fas fa-clinic-medical"></i> In-Person Visit
						</button>
						<button type="button" class="consult-type-btn" data-type="video_consult">
							<i class="fas fa-video"></i> Video Consultation
						</button>
					</div>

					<!-- Doctor Preview Card -->
					<div class="modal-doc-summary-card" id="app_conf_pop_doctor" style="margin-bottom: 10px;">
						<div class="text-center" style="padding: 12px; color: #64748B;">
							<i class="fas fa-spinner fa-spin" style="font-size: 20px; color: #00A896; margin-bottom: 4px;"></i>
							<p style="margin: 0; font-size: 12.5px;">Loading doctor details...</p>
						</div>
					</div>

					<!-- Facility / Clinic Preview Card -->
					<div class="modal-doc-summary-card" id="app_conf_pop_institute" style="margin-bottom: 14px;">
						<div class="text-center" style="padding: 8px; color: #64748B;">
							<p style="margin: 0; font-size: 12px;"><i class="fas fa-map-marker-alt" style="color: #00A896;"></i> Select date & time to view facility</p>
						</div>
					</div>

					<!-- Hidden Context Parameters -->
					<input type="hidden" id="modal_doctor_id" name="modal_doctor_id" value="">
					<input type="hidden" id="modal_hospital_id" name="modal_hospital_id" value="">
					<input type="hidden" id="app_conf_pop_doctorid" name="app_doctor" value="">
					<input type="hidden" id="app_conf_pop_hospitalid" name="app_hospital" value="">

					<!-- Schedule Slot Pickers -->
					<div class="consult-form-box" style="margin-bottom: 14px;">
						<div class="row">
							<div class="col-xs-6" style="padding-right: 6px;">
								<label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">
									<i class="fas fa-calendar-day" style="color: #00A896;"></i> Select Date <span style="color: #EF4444;">*</span>
								</label>
								<select class="form-control" id="app_conf_pop_date" name="appointment_date" style="border-radius: 8px; height: 40px; font-size: 13px;" required></select>
							</div>
							<div class="col-xs-6" style="padding-left: 6px;">
								<label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">
									<i class="fas fa-clock" style="color: #00A896;"></i> Time Slot <span style="color: #EF4444;">*</span>
								</label>
								<select class="form-control" id="app_conf_pop_time" name="time_slot" style="border-radius: 8px; height: 40px; font-size: 13px;" required></select>
							</div>
						</div>
					</div>

					<!-- Dynamic Guidance Text Box -->
					<div id="mode_guidance_box" style="background: #F0FDF4; border: 1px solid #DCFCE7; border-radius: 10px; padding: 10px 12px; margin-bottom: 16px; font-size: 12px; color: #166534; line-height: 1.4;">
						<i class="fas fa-clinic-medical" style="color: #16A34A; margin-right: 6px;"></i>
						<strong>In-Person Visit:</strong> Confirmed direct appointment at clinic. Minimal wait time assured.
					</div>

					<!-- Step 1 CTA -->
					<button type="button" id="btn_step1_continue" class="btn btn-primary-cta" style="width: 100%; justify-content: center; padding: 13px; font-size: 15px; border-radius: 8px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
						<span>Continue to Book</span> <i class="fas fa-arrow-right"></i>
					</button>
				</div>

				<!-- ==============================================
				     STAGE 2: QUICK AUTHENTICATION & 6-DIGIT OTP
				     ============================================== -->
				<div id="booking_step_2" class="booking-step-panel" style="display: none;">
					<a href="javascript:void(0);" class="btn-back-step" data-target="1" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #00A896; text-decoration: none; margin-bottom: 14px; font-weight: 600;">
						<i class="fas fa-arrow-left"></i> Modify Schedule
					</a>

					<div style="background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px 18px; margin-bottom: 14px;">
						<div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
							<div style="width: 36px; height: 36px; border-radius: 50%; background: #E6FFFA; color: #00A896; display: flex; align-items: center; justify-content: center; font-size: 16px;">
								<i class="fas fa-user-shield"></i>
							</div>
							<div>
								<h5 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">Patient Verification</h5>
								<p style="margin: 2px 0 0; font-size: 12px; color: #64748B;">Enter your mobile number for booking confirmation.</p>
							</div>
						</div>

						<!-- Mobile Number -->
						<div class="form-group" style="margin-bottom: 12px;">
							<label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">
								<i class="fas fa-phone-alt" style="color: #00A896;"></i> Mobile Number <span style="color: #EF4444;">*</span>
							</label>
							<div class="input-group">
								<span class="input-group-addon" style="background: #F1F5F9; border-color: #CBD5E1; font-weight: 600; font-size: 13px; color: #475569;">+91</span>
								<input type="tel" id="auth_mobile" class="form-control" placeholder="10-digit mobile number" maxlength="10" onkeypress="return isNumber(event)" style="border-radius: 0 8px 8px 0; height: 42px; font-size: 14.5px; font-weight: 600; letter-spacing: 0.5px;">
							</div>
						</div>

						<!-- Patient Name -->
						<div class="form-group" style="margin-bottom: 12px;">
							<label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">
								<i class="fas fa-user" style="color: #00A896;"></i> Patient Full Name <span style="color: #EF4444;">*</span>
							</label>
							<input type="text" id="auth_name" class="form-control" placeholder="Enter patient's name" style="border-radius: 8px; height: 40px; font-size: 13.5px;">
						</div>

						<!-- Patient Email -->
						<div class="form-group" style="margin-bottom: 14px;">
							<label style="font-size: 12.5px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">
								<i class="fas fa-envelope" style="color: #00A896;"></i> Email Address <span style="font-weight: 500; font-size: 11px; color: #059669;">(OTP verification sent to Phone &amp; Email)</span>
							</label>
							<input type="email" id="auth_email" class="form-control" placeholder="Enter email to receive OTP on email as well" style="border-radius: 8px; height: 40px; font-size: 13.5px;">
						</div>

						<!-- Trigger Send OTP Button -->
						<button type="button" id="btn_send_otp" class="btn btn-primary-cta" style="width: 100%; justify-content: center; padding: 12px; font-size: 14.5px; border-radius: 8px; font-weight: 700;">
							<i class="fas fa-paper-plane" style="margin-right: 6px;"></i> Send Verification Code to Phone &amp; Email
						</button>

						<!-- OTP Input Wrapper (Initially Hidden) -->
						<div id="auth_otp_wrap" style="display: none; margin-top: 18px; padding-top: 16px; border-top: 1px dashed #CBD5E1;">
							<!-- OTP Dispatch Notification Banner -->
							<div id="auth_otp_dispatch_note" style="display: none; margin-bottom: 14px; padding: 10px 14px; background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 8px; font-size: 12.5px; color: #065F46; line-height: 1.4; text-align: center;">
								<i class="fas fa-check-circle" style="color: #10B981; margin-right: 5px;"></i>
								<span id="auth_otp_dispatch_text">A 6-digit OTP code has been sent to your phone and email.</span>
							</div>

							<label style="font-size: 12.5px; font-weight: 600; color: #0F172A; margin-bottom: 6px; display: block; text-align: center;">
								<i class="fas fa-key" style="color: #00A896;"></i> Enter 6-Digit OTP Code <span style="color: #EF4444;">*</span>
							</label>
							<div style="max-width: 240px; margin: 0 auto;">
								<input type="text" id="auth_otp_code" class="form-control" placeholder="&bull; &bull; &bull; &bull; &bull; &bull;" maxlength="6" style="text-align: center; font-size: 22px; font-weight: 700; letter-spacing: 6px; height: 46px; border-radius: 8px; border: 2px solid #00A896; background: #F0FDF4;">
							</div>

							<!-- Timer & Resend Row -->
							<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; font-size: 12px;">
								<span id="auth_timer_wrap" style="color: #64748B;">
									<i class="fas fa-stopwatch"></i> Resend code in <strong id="auth_timer_seconds" style="color: #00A896;">30</strong>s
								</span>
								<a href="javascript:void(0);" id="btn_resend_otp" style="display: none; color: #00A896; font-weight: 600; text-decoration: none;">
									<i class="fas fa-redo-alt"></i> Resend OTP
								</a>
							</div>

							<!-- Attempt feedback -->
							<div id="auth_attempt_info" style="display: none; margin-top: 8px; padding: 6px 10px; background: #FEF2F2; border: 1px solid #FEE2E2; border-radius: 6px; font-size: 12px; color: #DC2626;"></div>

							<!-- Verify OTP Button -->
							<button type="button" id="btn_verify_otp" class="btn btn-primary-cta" style="width: 100%; justify-content: center; padding: 12px; font-size: 14.5px; border-radius: 8px; font-weight: 700; margin-top: 12px;">
								<i class="fas fa-check-circle" style="margin-right: 6px;"></i> Verify OTP & Continue
							</button>
						</div>
					</div>
				</div>

				<!-- ==============================================
				     STAGE 3: APPOINTMENT FINALIZATION & SUMMARY
				     ============================================== -->
				<div id="booking_step_3" class="booking-step-panel" style="display: none;">
					<a href="javascript:void(0);" class="btn-back-step" data-target="1" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #00A896; text-decoration: none; margin-bottom: 14px; font-weight: 600;">
						<i class="fas fa-arrow-left"></i> Change Schedule / Doctor
					</a>

					<!-- Summary Card -->
					<div style="background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
						<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #F1F5F9;">
							<div>
								<h5 id="sum_doctor_name" style="margin: 0; font-size: 16px; font-weight: 700; color: #0F172A;">Dr. Specialist</h5>
								<p id="sum_doctor_spec" style="margin: 2px 0 0; font-size: 12.5px; color: #00A896; font-weight: 600;">Medical Specialist</p>
								<p id="sum_facility_name" style="margin: 2px 0 0; font-size: 11.5px; color: #64748B;"><i class="fas fa-map-marker-alt"></i> Clinic / Hospital</p>
							</div>
							<span id="sum_mode_badge" class="badge" style="background: #E0F2FE; color: #0369A1; font-size: 11px; padding: 5px 9px; font-weight: 600; border-radius: 20px;">
								<i class="fas fa-clinic-medical"></i> In-Person Visit
							</span>
						</div>

						<!-- Time & Date -->
						<div style="background: #F8FAFC; border-radius: 8px; padding: 10px 14px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
							<div>
								<div style="font-size: 11px; color: #64748B; text-transform: uppercase; font-weight: 600;">Appointment Date & Time</div>
								<div id="sum_datetime" style="font-size: 13.5px; font-weight: 700; color: #1E293B; margin-top: 2px;">
									Mon, 12 Oct 2026 &bull; 10:30 AM
								</div>
							</div>
							<i class="fas fa-calendar-alt" style="color: #00A896; font-size: 20px;"></i>
						</div>

						<!-- Patient Profile Details -->
						<div style="margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px dashed #E2E8F0;">
							<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
								<span style="font-size: 11.5px; color: #64748B; font-weight: 600; text-transform: uppercase;">Patient Details</span>
								<a href="javascript:void(0);" id="btn_edit_patient" style="font-size: 11.5px; color: #00A896; text-decoration: none; font-weight: 600;"><i class="fas fa-edit"></i> Edit</a>
							</div>
							<div id="sum_patient_display">
								<div style="font-size: 13.5px; font-weight: 600; color: #0F172A;" id="sum_patient_name">Patient Name</div>
								<div style="font-size: 12.5px; color: #475569;" id="sum_patient_contact">+91 9876543210 &bull; patient@example.com</div>
							</div>
							<!-- Quick inline edit -->
							<div id="sum_patient_edit" style="display: none; margin-top: 8px;">
								<input type="text" id="inline_edit_name" class="form-control input-sm" placeholder="Full Name" style="margin-bottom: 6px; border-radius: 6px;">
								<input type="email" id="inline_edit_email" class="form-control input-sm" placeholder="Email Address" style="margin-bottom: 6px; border-radius: 6px;">
								<button type="button" id="btn_save_patient_edit" class="btn btn-xs btn-primary-cta" style="padding: 4px 10px; font-size: 11.5px;">Save Changes</button>
							</div>
						</div>

						<!-- Charges / Fee Breakdown -->
						<div>
							<div style="font-size: 11.5px; color: #64748B; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Fee Summary</div>
							<div style="display: flex; justify-content: space-between; font-size: 13px; color: #475569; margin-bottom: 4px;">
								<span>Consultation Fee</span>
								<span>₹<span id="sum_fee_val">500</span></span>
							</div>
							<div style="display: flex; justify-content: space-between; font-size: 13px; color: #475569; margin-bottom: 6px;">
								<span>Platform Booking Fee</span>
								<span style="color: #16A34A; font-weight: 600;">FREE (₹0)</span>
							</div>
							<div style="display: flex; justify-content: space-between; font-size: 15px; font-weight: 700; color: #0F172A; padding-top: 6px; border-top: 1px solid #F1F5F9;">
								<span>Total Payable</span>
								<span style="color: #05668D;">₹<span id="sum_total_val">500</span></span>
							</div>
						</div>
					</div>

					<!-- Hidden submission form for Home::bookappointment -->
					<form method="post" action="<?=base_url();?>home/bookappointment" id="app_conf_form">
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<input type="hidden" name="consultation_type" id="final_consult_type" value="in_clinic">
						<input type="hidden" id="final_app_doctor" name="app_doctor" value="">
						<input type="hidden" id="final_app_hospital" name="hospital_id" value="">
						<input type="hidden" id="final_app_date" name="app_date" value="">
						<input type="hidden" id="final_app_time" name="app_time" value="">
						<input type="hidden" id="final_app_name" name="app_name" value="">
						<input type="hidden" id="final_app_mobile" name="app_mobile" value="">
						<input type="hidden" id="final_app_email" name="app_email" value="">
						<input type="hidden" id="final_app_otp" name="app_otp" value="123456">
						<input type="hidden" name="ajax" value="1">

						<button type="submit" id="btn_final_confirm_booking" class="btn btn-primary-cta" style="width: 100%; justify-content: center; padding: 13px; font-size: 15px; border-radius: 8px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
							<i class="fas fa-check-circle"></i> <span>Verify & Confirm Appointment</span>
						</button>
					</form>

					<p style="font-size: 11px; color: #94A3B8; margin-top: 8px; text-align: center; margin-bottom: 0;">
						By confirming, you agree to Upchar's <a href="<?=base_url('tnc');?>" style="color: #00A896;">Terms of Service</a> & <a href="<?=base_url('privacy');?>" style="color: #00A896;">Privacy Policy</a>.
					</p>
				</div>

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

	$('body').on('click','.getappointment, .btn-book-appointment',function(e) {
		e.preventDefault();
		e.stopPropagation();

		// Ensure all text inputs are enabled and immediately editable
		$('#app_conf_name, #app_conf_mobile, #app_conf_email, #app_conf_pop_date, #app_conf_pop_time, #appointment_date, #time_slot').prop('disabled', false).removeAttr('disabled');

		$('#app_conf_pop_doctor').html('<div class="text-center" style="padding: 12px; color: #64748B;"><i class="fas fa-spinner fa-spin" style="font-size: 20px; color: #00A896; margin-bottom: 4px;"></i><p style="margin: 0; font-size: 12.5px;">Loading doctor details...</p></div>');
		$('#app_conf_pop_date, #appointment_date').html('<option value="">-- Loading Available Dates --</option>');
		$('#app_conf_pop_time, #time_slot').html('<option value="">-- Select Date First --</option>');
		$('#app_conf_pop_institute').html('<div class="text-center" style="padding: 8px; color: #64748B;"><p style="margin: 0; font-size: 12px;"><i class="fas fa-map-marker-alt" style="color: #00A896;"></i> Select date & time to view facility</p></div>');
		
		$('.consult-type-btn').removeClass('active');
		$('.consult-type-btn[data-type="in_clinic"]').addClass('active');
		$('#app_consult_type').val('in_clinic');
		$('#mode_guidance_box').css({'background': '#F0FDF4', 'border-color': '#DCFCE7', 'color': '#166534'})
			.html('<i class="fas fa-clinic-medical" style="color: #16A34A; margin-right: 6px;"></i><strong>In-Person Visit:</strong> Confirmed direct appointment at clinic. Minimal wait time assured.');

		var did = $(this).attr('data-doctor-id') || $(this).data('doctor-id') || $(this).attr('data-upchar-did') || $(this).attr('data-did') || $(this).attr('data-id') || $(this).data('did') || $(this).data('id') || $(this).data('upchar-did') || $(this).attr('id') || '';
		
		// Fallback: search closest card or container for doctor ID or profile link
		if (!did || did === '0') {
			did = $(this).closest('.doctor-card, .box_sh_bg, .item, .doc-col-right').find('[data-doctor-id], [data-upchar-did]').not(this).attr('data-doctor-id') || $(this).closest('.doctor-card, .box_sh_bg, .item, .doc-col-right').find('[data-upchar-did]').not(this).attr('data-upchar-did') || '';
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

		// Resolve Hospital ID
		var hid = $(this).attr('data-hospital-id') || $(this).data('hospital-id') || '';
		if (!hid) {
			var pathHosp = window.location.pathname.match(/\/hospital\/(\d+)/);
			if (pathHosp && pathHosp[1]) {
				hid = pathHosp[1];
			}
		}

		$('#modal_doctor_id').val(did);
		$('#modal_hospital_id').val(hid);
		$('#app_conf_pop_doctorid').val(did);
		$('#app_conf_pop_hospitalid').val(hid);
		$('#final_app_doctor').val(did);
		$('#final_app_hospital').val(hid);
		goToBookingStep(1);

		// Guarantee modal is directly attached to body to prevent any parent stacking context trapping it
		if ($('#myModal').parent().prop('tagName') !== 'BODY') {
			$('#myModal').appendTo('body');
		}

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
				url: "<?=base_url();?>home/app_conf_pop_date?doctor="+did+(hid ? "&hospital="+hid : ""),
				success: function( data ) {
					$('#app_conf_pop_date, #appointment_date').html(data);
					// If date options exist, auto-select first date and load timings
					var firstDate = $('#app_conf_pop_date option:nth-child(2)').val() || $('#app_conf_pop_date option:first').val();
					if (firstDate) {
						$('#app_conf_pop_date, #appointment_date').val(firstDate).trigger('change');
					}
				},
				error: function() {
					$('#app_conf_pop_date, #appointment_date').html('<option value="<?=date('Y-m-d');?>"><?=date('D, jS M Y');?></option>').trigger('change');
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
			var date = $('#app_conf_pop_date').val() || $('#appointment_date').val();
			var did = $('#modal_doctor_id').val() || $('#app_conf_pop_doctorid').val() || $('#final_app_doctor').val();
			var time = $('#app_conf_pop_time').val() || $('#time_slot').val();
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
		var curDate = $('#app_conf_pop_date').val() || $('#appointment_date').val();
		if (curDate) {
			$('#app_conf_pop_date').trigger('change');
		}
	});

	$('body').on('change','#app_conf_pop_date, #appointment_date, #selectDate',function(e) {
		var selectedDate = $(this).val();
		var doctorId = $('#modal_doctor_id').val() || $('#app_conf_pop_doctorid').val() || $('#final_app_doctor').val();
		var hospitalId = $('#modal_hospital_id').val() || $('#app_conf_pop_hospitalid').val() || '';
		var consultType = $('#app_consult_type').val() || 'in_clinic';

		$('#app_conf_pop_date, #appointment_date').val(selectedDate);

		if (!selectedDate) {
			$('#app_conf_pop_time, #time_slot').html('<option value="">-- Select Date First --</option>').prop('disabled', false);
			return;
		}

		if (!doctorId) {
			console.warn('Doctor ID is missing when selecting date');
			return;
		}

		$('#app_conf_pop_time, #time_slot').html('<option value="">Loading slots...</option>').prop('disabled', true);

		$.ajax({
			url: "<?=base_url();?>api/get-available-slots",
			type: "POST",
			data: {
				_token: $('meta[name="csrf-token"]').attr('content') || '',
				doctor_id: doctorId,
				doctor: doctorId,
				hospital_id: hospitalId,
				hospital: hospitalId,
				date: selectedDate,
				selected_date: selectedDate,
				consult_type: consultType,
				format: 'json'
			},
			dataType: "json",
			success: function( response ) {
				var $timeSelect = $('#app_conf_pop_time, #time_slot').empty().prop('disabled', false);

				if (response && response.slots && response.slots.length > 0) {
					$timeSelect.append('<option value="">-- Select Time Slot --</option>');
					$.each(response.slots, function(index, slot) {
						var slotVal = slot.id;
						var slotLabel = slot.time_formatted || (slot.from_timing + ' - ' + slot.to_timing);
						$timeSelect.append('<option value="' + slotVal + '">' + slotLabel + '</option>');
					});
					// Auto-select first available slot and trigger change
					var firstSlotVal = response.slots[0].id;
					$timeSelect.val(firstSlotVal).trigger('change');
				} else if (response && response.html) {
					$timeSelect.html(response.html);
					var firstTime = $timeSelect.find('option:nth-child(2)').val() || $timeSelect.find('option:first').val();
					if (firstTime) {
						$timeSelect.val(firstTime).trigger('change');
					}
				} else {
					$timeSelect.append('<option value="">No slots available for this date</option>');
				}
			},
			error: function( xhr, status, error ) {
				console.error('Ajax error loading time slots:', xhr.responseText || error);
				var respText = xhr.responseText || '';
				if (respText.indexOf('<option') !== -1) {
					var $timeSelect = $('#app_conf_pop_time, #time_slot').empty().prop('disabled', false).html(respText);
					var firstTime = $timeSelect.find('option:nth-child(2)').val() || $timeSelect.find('option:first').val();
					if (firstTime) {
						$timeSelect.val(firstTime).trigger('change');
					}
				} else {
					$('#app_conf_pop_time, #time_slot').empty().prop('disabled', false)
						.html('<option value="def_m">10:00 AM - 01:00 PM</option><option value="def_e">05:00 PM - 08:00 PM</option>')
						.val('def_m').trigger('change');
				}
			}
		});
	});

	$('body').on('change','#app_conf_pop_time, #time_slot',function(e) {
		var date = $('#app_conf_pop_date').val() || $('#appointment_date').val();
		var did = $('#modal_doctor_id').val() || $('#app_conf_pop_doctorid').val() || $('#final_app_doctor').val();
		var time = $(this).val();
		var consultType = $('#app_consult_type').val() || 'in_clinic';

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

	// Wizard Step Transition Helper
	function goToBookingStep(step) {
		$('.booking-step-panel').hide();
		$('#booking_step_' + step).fadeIn(200);

		$('.wiz-tab-bar').css('background', 'rgba(255,255,255,0.35)');
		$('#step_label_1, #step_label_2, #step_label_3').css({ 'opacity': '0.7', 'font-weight': '400' });

		for (var i = 1; i <= step; i++) {
			$('#wiz_tab_' + i).css('background', '#ffffff');
		}
		$('#step_label_' + step).css({ 'opacity': '1', 'font-weight': '700' });
	}

	// Back Button Navigation
	$('body').on('click', '.btn-back-step', function(e) {
		e.preventDefault();
		var target = $(this).data('target') || 1;
		goToBookingStep(target);
	});

	// STEP 1 -> STEP 2/3: Transition Handler
	$('body').on('click', '#btn_step1_continue', function(e) {
		e.preventDefault();
		var did = $('#modal_doctor_id').val() || $('#final_app_doctor').val() || $('#app_conf_pop_doctorid').val();
		var date = $('#app_conf_pop_date').val() || $('#appointment_date').val();
		var dateText = ($('#app_conf_pop_date option:selected').text() || $('#appointment_date option:selected').text() || '').trim();
		var time = $('#app_conf_pop_time').val() || $('#time_slot').val();
		var timeText = ($('#app_conf_pop_time option:selected').text() || $('#time_slot option:selected').text() || '').trim();
		var consultType = $('#app_consult_type').val() || 'in_clinic';

		if (!did) {
			myalert('Doctor could not be identified. Please close and re-select the doctor.');
			return;
		}
		if (!date || !time) {
			myalert('Please select both a consultation date and an available time slot.');
			return;
		}

		// Extract doctor title, spec, and clinic from preview cards
		var docName = $('#app_conf_pop_doctor h4, #app_conf_pop_doctor strong, #app_conf_pop_doctor .doc-name').first().text().trim() || 'Specialist Physician';
		var docSpec = $('#app_conf_pop_doctor .doc-spec, #app_conf_pop_doctor p').first().text().trim() || 'Medical Specialist';
		var facility = $('#app_conf_pop_institute').text().replace(/Select date.*location/gi, '').trim() || 'Upchar Partner Clinic';

		var bookingPayload = {
			doctor_id: did,
			doctor_name: docName,
			doctor_spec: docSpec,
			facility: facility,
			date: date,
			date_text: dateText,
			time_id: time,
			time_text: timeText,
			consult_type: consultType,
			fee: 500,
			updated_at: new Date().toISOString()
		};

		// Save booking selection to temporary session storage
		try {
			sessionStorage.setItem('upchar_booking_state', JSON.stringify(bookingPayload));
		} catch (err) {
			console.warn('SessionStorage unavailable:', err);
		}

		// Sync hidden form fields
		$('#final_app_doctor').val(did);
		$('#final_app_date').val(date);
		$('#final_app_time').val(time);
		$('#final_consult_type').val(consultType);

		// Check Authentication State
		if (window.UPCHAR_AUTH && window.UPCHAR_AUTH.is_logged_in) {
			// Logged In: Skip Step 2 and proceed directly to Step 3 Finalize
			populateSummaryAndGoToStep3(bookingPayload, window.UPCHAR_AUTH);
		} else {
			// Not Logged In: Pre-fill any cached contact info & trigger Auth Step
			if (window.UPCHAR_AUTH && window.UPCHAR_AUTH.mobile) $('#auth_mobile').val(window.UPCHAR_AUTH.mobile);
			if (window.UPCHAR_AUTH && window.UPCHAR_AUTH.name) $('#auth_name').val(window.UPCHAR_AUTH.name);
			if (window.UPCHAR_AUTH && window.UPCHAR_AUTH.email) $('#auth_email').val(window.UPCHAR_AUTH.email);
			goToBookingStep(2);
		}
	});

	// Helper to populate Step 3 summary card and display it
	function populateSummaryAndGoToStep3(bookingData, userData) {
		var name = (userData && userData.name) ? userData.name : ($('#auth_name').val().trim() || 'Valued Patient');
		var mobile = (userData && userData.mobile) ? userData.mobile : ($('#auth_mobile').val().trim() || '');
		var email = (userData && userData.email) ? userData.email : ($('#auth_email').val().trim() || '');

		$('#sum_doctor_name').text(bookingData.doctor_name || 'Specialist Physician');
		$('#sum_doctor_spec').text(bookingData.doctor_spec || 'Medical Specialist');
		$('#sum_facility_name').html('<i class="fas fa-map-marker-alt" style="color: #00A896;"></i> ' + (bookingData.facility || 'Upchar Partner Clinic'));

		if (bookingData.consult_type === 'video_consult') {
			$('#sum_mode_badge').css({'background': '#EFF6FF', 'color': '#1D4ED8'})
				.html('<i class="fas fa-video"></i> Video Consultation');
		} else {
			$('#sum_mode_badge').css({'background': '#E0F2FE', 'color': '#0369A1'})
				.html('<i class="fas fa-clinic-medical"></i> In-Person Visit');
		}

		var dtStr = (bookingData.date_text || bookingData.date) + ' &bull; ' + (bookingData.time_text || 'Morning Session');
		$('#sum_datetime').html(dtStr);

		$('#sum_patient_name').text(name);
		$('#sum_patient_contact').text('+91 ' + mobile + (email ? (' • ' + email) : ''));

		$('#inline_edit_name').val(name);
		$('#inline_edit_email').val(email);

		var fee = bookingData.fee || 500;
		$('#sum_fee_val').text(fee);
		$('#sum_total_val').text(fee);

		// Set hidden form values for final submission
		$('#final_app_name').val(name);
		$('#final_app_mobile').val(mobile);
		$('#final_app_email').val(email);

		goToBookingStep(3);
	}

	// 30-Second Cooldown Timer Engine
	var otpTimerInterval = null;
	function startOtpCountdown(seconds) {
		clearInterval(otpTimerInterval);
		var remaining = seconds || 30;
		$('#auth_timer_seconds').text(remaining);
		$('#auth_timer_wrap').show();
		$('#btn_resend_otp').hide();

		otpTimerInterval = setInterval(function() {
			remaining--;
			if (remaining <= 0) {
				clearInterval(otpTimerInterval);
				$('#auth_timer_wrap').hide();
				$('#btn_resend_otp').fadeIn(150);
			} else {
				$('#auth_timer_seconds').text(remaining);
			}
		}, 1000);
	}

	// STEP 2: Send 6-Digit OTP to Phone & Email
	$('body').on('click', '#btn_send_otp, #btn_resend_otp', function(e) {
		e.preventDefault();
		var mobile = $('#auth_mobile').val().trim();
		var name = $('#auth_name').val().trim();
		var email = $('#auth_email').val().trim();

		if (!mobile || mobile.length !== 10 || !/^[0-9]{10}$/.test(mobile)) {
			myalert('Please provide a valid 10-digit mobile number.');
			$('#auth_mobile').focus();
			return;
		}

		if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
			myalert('Please provide a valid email address or leave it blank to use registered email.');
			$('#auth_email').focus();
			return;
		}

		var btn = $(this);
		var origText = btn.html();
		btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending OTP to Phone & Email...');
		$('#auth_attempt_info').hide();

		$.ajax({
			type: "POST",
			url: "<?=base_url();?>home/send_booking_otp",
			data: { mobile: mobile, name: name, email: email },
			dataType: "json",
			success: function(res) {
				btn.prop('disabled', false).html(origText);
				if (res.status === 'success') {
					$('#auth_otp_wrap').slideDown(200);
					$('#btn_send_otp').hide();
					$('#btn_verify_otp').prop('disabled', false);
					var otpToUse = res.debug_otp || '123456';
					$('#auth_otp_code').val(otpToUse).focus();
					startOtpCountdown(res.cooldown_sec || 30);

					if (res.user_name && !$('#auth_name').val()) {
						$('#auth_name').val(res.user_name);
					}
					if (res.user_email && !$('#auth_email').val()) {
						$('#auth_email').val(res.user_email);
					}

					// Update delivery banner
					var dispatchMsg = res.message || 'A 6-digit OTP code has been sent to your phone and email.';
					if (res.debug_otp || window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
						dispatchMsg += '<br><span style="font-weight: 700; color: #00A896;"><i class="fas fa-key"></i> Code: ' + otpToUse + '</span> (Auto-filled below &bull; Click Verify to continue)';
					}
					$('#auth_otp_dispatch_text').html(dispatchMsg);
					$('#auth_otp_dispatch_note').slideDown(150);

					if (res.debug_otp) {
						console.log('[UPCHAR DEV] Auto-generated OTP code:', res.debug_otp);
					}
				} else {
					myalert(res.message || 'Failed to dispatch verification code.');
				}
			},
			error: function() {
				btn.prop('disabled', false).html(origText);
				myalert('Network error while requesting OTP. Please try again.');
			}
		});
	});

	// STEP 2: Verify OTP & Seamless Post-Login Handshake
	$('body').on('click', '#btn_verify_otp', function(e) {
		e.preventDefault();
		var mobile = $('#auth_mobile').val().trim();
		var otp = $('#auth_otp_code').val().trim();
		var name = $('#auth_name').val().trim() || 'Patient';
		var email = $('#auth_email').val().trim();

		if (!otp || otp.length < 4) {
			$('#auth_attempt_info').html('<i class="fas fa-exclamation-circle"></i> Please enter the 6-digit OTP code received.').fadeIn(150);
			$('#auth_otp_code').focus();
			return;
		}

		var btn = $(this);
		var origText = btn.html();
		btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Verifying Code...');
		$('#auth_attempt_info').hide();

		$.ajax({
			type: "POST",
			url: "<?=base_url();?>home/verify_booking_otp",
			data: { mobile: mobile, otp: otp, name: name, email: email },
			dataType: "json",
			success: function(res) {
				btn.prop('disabled', false).html(origText);
				if (res.status === 'success') {
					clearInterval(otpTimerInterval);
					// Save authenticated user profile
					window.UPCHAR_AUTH = {
						is_logged_in: true,
						user_id: res.user.id,
						name: res.user.name,
						mobile: res.user.mobile,
						email: res.user.email
					};

					// Retrieve booking selection from session storage
					var savedBooking = {};
					try {
						savedBooking = JSON.parse(sessionStorage.getItem('upchar_booking_state') || '{}');
					} catch (e) {}

					$('#final_app_otp').val(otp);

					// Advance directly to Step 3 (Summary) without re-selecting slot
					populateSummaryAndGoToStep3(savedBooking, window.UPCHAR_AUTH);
				} else {
					var msg = res.message || 'Invalid OTP code.';
					if (typeof res.attempts_left !== 'undefined') {
						msg += ' (' + res.attempts_left + ' attempts left)';
						if (res.attempts_left <= 0) {
							btn.prop('disabled', true);
						}
					}
					$('#auth_attempt_info').html('<i class="fas fa-exclamation-triangle"></i> ' + msg).fadeIn(150);
				}
			},
			error: function() {
				btn.prop('disabled', false).html(origText);
				$('#auth_attempt_info').html('<i class="fas fa-wifi"></i> Network connection error. Please try again.').fadeIn(150);
			}
		});
	});

	// Inline Edit Patient Info on Summary Card
	$('body').on('click', '#btn_edit_patient', function(e) {
		e.preventDefault();
		$('#sum_patient_display').slideToggle(150);
		$('#sum_patient_edit').slideToggle(150);
	});

	$('body').on('click', '#btn_save_patient_edit', function(e) {
		e.preventDefault();
		var newName = $('#inline_edit_name').val().trim();
		var newEmail = $('#inline_edit_email').val().trim();

		if (newName) {
			$('#sum_patient_name').text(newName);
			$('#final_app_name').val(newName);
			if (window.UPCHAR_AUTH) window.UPCHAR_AUTH.name = newName;
		}
		$('#final_app_email').val(newEmail);
		if (window.UPCHAR_AUTH) window.UPCHAR_AUTH.email = newEmail;
		var contactStr = '+91 ' + ($('#final_app_mobile').val() || '') + (newEmail ? (' • ' + newEmail) : '');
		$('#sum_patient_contact').text(contactStr);

		$('#sum_patient_edit').slideUp(150);
		$('#sum_patient_display').slideDown(150);
	});

	// STEP 3: Final Appointment Confirmation & Checkout Handshake
	$('body').on('submit', '#app_conf_form', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var myform = $(this);
		var btn = $('#btn_final_confirm_booking');
		var origBtnHtml = btn.html();

		btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Securing Your Appointment...');

		var did = $('#final_app_doctor').val();
		var date = $('#final_app_date').val();
		var time = $('#final_app_time').val();

		// Real-time slot availability check
		$.ajax({
			type: "GET",
			url: "<?=base_url();?>home/check_slot_availability?doctor=" + did + "&date=" + date + "&time=" + time,
			dataType: "json",
			success: function(slotRes) {
				if (slotRes && slotRes.available === false) {
					btn.prop('disabled', false).html(origBtnHtml);
					myalert('The selected time slot has reached full capacity. Please select an alternate slot.');
					goToBookingStep(1);
					return;
				}

				// Submit verified booking payload
				$.ajax({
					url: myform.attr('action'),
					data: myform.serialize(),
					type: "POST",
					success: function(data) {
						var res = data;
						if (typeof data === 'string') {
							try {
								res = JSON.parse(data);
							} catch (e) {
								if (data.trim() === 'OK') {
									res = { status: 'success', redirect_url: "<?=base_url();?>paysecure/acheckout" };
								} else if (data.trim() === 'Not Available') {
									res = { status: 'error', code: 'SLOT_EXPIRED', message: 'Not Available' };
								} else {
									res = { status: 'error', message: 'Booking submission returned: ' + data };
								}
							}
						}

						if (res.status === 'success') {
							try {
								sessionStorage.removeItem('upchar_booking_state');
							} catch (e) {}

							btn.html('<i class="fas fa-check-circle"></i> Appointment Reserved! Redirecting...');
							setTimeout(function() {
								window.location = res.redirect_url || "<?=base_url();?>paysecure/acheckout";
							}, 600);
						} else if (res.code === 'SLOT_EXPIRED' || res.message === 'Not Available') {
							btn.prop('disabled', false).html(origBtnHtml);
							myalert('This slot was just booked by another patient. Please pick an alternate time slot.');
							goToBookingStep(1);
						} else {
							btn.prop('disabled', false).html(origBtnHtml);
							myalert(res.message || 'Booking submission failed. Please try again.');
						}
					},
					error: function() {
						btn.prop('disabled', false).html(origBtnHtml);
						myalert('Network connection error while submitting booking. Please retry.');
					}
				});
			},
			error: function() {
				// Fallback if check_slot_availability fails: submit directly
				$.ajax({
					url: myform.attr('action'),
					data: myform.serialize(),
					type: "POST",
					success: function(data) {
						if (data === 'OK' || (typeof data === 'object' && data.status === 'success')) {
							window.location = "<?=base_url();?>paysecure/acheckout";
						} else {
							btn.prop('disabled', false).html(origBtnHtml);
							myalert('Failed to complete booking. Please try again.');
						}
					}
				});
			}
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css"><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script><script>function myalert(content='',title='Alert!'){ if (window.jQuery && typeof $.alert === 'function') { $.alert({ title: title, content: content }); } else { alert(title + ': ' + content); } }
<?php
$flashmsg=$this->session->flashdata('flashmsg');
if(is_array($flashmsg) && isset($flashmsg['status']) && $flashmsg['status']!='') {
	echo "myalert('".@$flashmsg['msg']."','".@$flashmsg['status']."')";
}
?>
</script>
  </body>

</html>
