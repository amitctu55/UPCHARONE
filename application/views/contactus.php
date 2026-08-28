<?php $this->load->view("includes/header.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.contact-hero {
    background: linear-gradient(135deg, #043d5b 0%, #00a896 100%);
    color: #ffffff;
    padding: 60px 0 50px 0;
    position: relative;
    overflow: hidden;
}

.contact-hero h1 {
    font-size: 36px;
    font-weight: 800;
    margin: 0 0 12px 0;
    letter-spacing: -0.5px;
    color: #ffffff;
}

.contact-hero p {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.9);
    max-width: 600px;
    margin: 0 auto;
}

.contact-card-box {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    padding: 32px;
    margin-bottom: 30px;
}

.contact-info-card {
    background: #ffffff;
    border: 1px solid var(--upchar-border);
    border-radius: 14px;
    padding: 20px;
    margin-bottom: 16px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    transition: all 0.2s ease;
}

.contact-info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
    border-color: var(--upchar-teal);
}

.contact-icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #f0fdfa;
    color: var(--upchar-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    border: 1px solid #ccfbf1;
}

.form-label-cstm {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.form-input-cstm {
    width: 100%;
    height: 46px;
    border-radius: 10px;
    border: 1px solid var(--upchar-border);
    padding: 10px 14px;
    font-size: 13.5px;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-input-cstm:focus {
    background: #ffffff;
    border-color: var(--upchar-teal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-contact-submit {
    background: var(--upchar-teal);
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    border: none;
    border-radius: 10px;
    padding: 13px 36px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
}

.btn-contact-submit:hover {
    background: var(--upchar-teal-dark);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
    color: #ffffff;
}

.map-container {
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    height: 380px;
}
</style>

<!-- Hero Section -->
<div class="contact-hero text-center">
    <div class="container">
        <h1>Connect with Upchar Healthcare</h1>
        <p>Whether you are a patient seeking assistance, a doctor, or a hospital partner looking to onboard onto our SaaS platform, our team is here 24/7 to help.</p>
    </div>
</div>

<div style="background: #f8fafc; padding: 40px 0 60px 0;">
    <div class="container">

        <!-- Flash Alert -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <div class="row">
            <!-- Left: Contact Form -->
            <div class="col-md-7 col-12">
                <div class="contact-card-box">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
                        <div style="width: 38px; height: 38px; border-radius: 8px; background: #f0fdfa; color: var(--upchar-teal); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">Send Us a Message</h3>
                            <p style="font-size: 12.5px; color: #64748b; margin: 0;">Fill in your details below and our team will get back to you within 24 hours.</p>
                        </div>
                    </div>

                    <form id="contactForm" action="<?=base_url('contactus');?>" method="post">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        <input type="hidden" name="submit" value="1">

                        <div class="row">
                            <div class="col-md-6 col-12" style="margin-bottom: 16px;">
                                <label class="form-label-cstm">Your Full Name *</label>
                                <input type="text" name="name" class="form-input-cstm" placeholder="e.g. Dr. Rajesh Sharma" required>
                            </div>
                            <div class="col-md-6 col-12" style="margin-bottom: 16px;">
                                <label class="form-label-cstm">Contact Mobile Number *</label>
                                <input type="tel" name="mobile" class="form-input-cstm" placeholder="e.g. 9876543210" maxlength="12" required>
                            </div>
                            <div class="col-md-6 col-12" style="margin-bottom: 16px;">
                                <label class="form-label-cstm">Email Address</label>
                                <input type="email" name="email" class="form-input-cstm" placeholder="e.g. rajesh@example.com">
                            </div>
                            <div class="col-md-6 col-12" style="margin-bottom: 16px;">
                                <label class="form-label-cstm">Inquiry Category *</label>
                                <select name="inquiry_type" class="form-input-cstm" required>
                                    <option value="GENERAL">General Inquiry / Information</option>
                                    <option value="DOCTOR_PARTNERSHIP">Doctor Listing &amp; Practice Setup</option>
                                    <option value="HOSPITAL_ONBOARDING">Hospital SaaS &amp; IPD Management</option>
                                    <option value="LAB_PARTNERSHIP">Pathology Lab LIS Integration</option>
                                    <option value="PATIENT_SUPPORT">Patient Appointment &amp; EHR Support</option>
                                    <option value="BILLING">Payment, Escrow &amp; Refunds</option>
                                </select>
                            </div>
                            <div class="col-12" style="margin-bottom: 16px;">
                                <label class="form-label-cstm">Subject</label>
                                <input type="text" name="subject" class="form-input-cstm" placeholder="Brief summary of your inquiry">
                            </div>
                            <div class="col-12" style="margin-bottom: 20px;">
                                <label class="form-label-cstm">Your Message *</label>
                                <textarea name="message" class="form-input-cstm" style="height: 110px; resize: vertical;" placeholder="How can we assist you today?" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-contact-submit" id="btnSubmitContact">
                                    <i class="fa fa-paper-plane"></i> <span>Submit Inquiry</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Contact Info & Support Cards -->
            <div class="col-md-5 col-12">
                <div class="contact-info-card">
                    <div class="contact-icon-circle">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Call Us (24/7 Toll Free)</div>
                        <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 2px;">+91-800-UPCHAR-1 / 1800-123-4567</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Instant emergency assistance &amp; booking support</div>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="contact-icon-circle" style="background: #e0f2fe; color: #0284c7; border-color: #bae6fd;">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Official Email Support</div>
                        <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 2px;">support@upchar.com</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Partners: partner-onboarding@upchar.com</div>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="contact-icon-circle" style="background: #fef3c7; color: #d97706; border-color: #fde68a;">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Corporate Headquarters</div>
                        <div style="font-size: 14px; font-weight: 700; color: #0f172a; margin-top: 2px;">UPCHAR Health Technologies Pvt. Ltd.</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Banaras / Varanasi, Uttar Pradesh, India</div>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="contact-icon-circle" style="background: #ecfdf5; color: #059669; border-color: #a7f3d0;">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Operating Hours</div>
                        <div style="font-size: 14px; font-weight: 700; color: #0f172a; margin-top: 2px;">Emergency &amp; Platform: 24 Hours / 7 Days</div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Partner Enterprise Support: Mon - Sat (9:00 AM - 7:00 PM)</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Google Map Section -->
        <div class="row" style="margin-top: 20px;">
            <div class="col-12">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28862.639365018767!2d82.96246570013585!3d25.276306224000095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x398e322990b81d57%3A0x187c3decd33a8727!2sBanaras+Hindu+University!5e0!3m2!1sen!2sin!4v1562058958658!5m2!1sen!2sin" width="100%" height="380" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('includes/footer.php'); ?>