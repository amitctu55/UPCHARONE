<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('includes/header'); ?>

<!-- Razorpay Standard Checkout SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
    :root {
        --upchar-teal: #00a896;
        --upchar-teal-dark: #0d7a6e;
        --upchar-teal-light: #f0fdfa;
        --upchar-navy: #1d2a44;
        --upchar-slate-900: #0f172a;
        --upchar-slate-800: #1e293b;
        --upchar-slate-600: #475569;
        --upchar-slate-500: #64748b;
        --upchar-slate-100: #f8fafc;
        --upchar-border: #e2e8f0;
        --upchar-success: #10b981;
        --upchar-gold: #f59e0b;
        --upchar-gold-light: #fef3c7;
    }

    .appt-checkout-wrapper {
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 36px 0 65px;
        min-height: 80vh;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: var(--upchar-slate-900);
    }

    /* Breadcrumbs */
    .checkout-breadcrumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: var(--upchar-slate-500);
        margin-bottom: 22px;
    }
    .checkout-breadcrumbs a {
        color: var(--upchar-teal-dark);
        text-decoration: none;
        font-weight: 600;
    }
    .checkout-breadcrumbs a:hover {
        text-decoration: underline;
    }
    .checkout-breadcrumbs span.sep {
        color: #cbd5e1;
    }

    /* Header Banner */
    .checkout-page-header {
        margin-bottom: 28px;
    }
    .checkout-page-header h1 {
        font-size: 26px;
        font-weight: 800;
        color: var(--upchar-navy);
        margin: 0 0 6px;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .checkout-page-header p {
        font-size: 14.5px;
        color: var(--upchar-slate-500);
        margin: 0;
    }
    .badge-sec-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e6fffa;
        color: var(--upchar-teal-dark);
        border: 1px solid #b2f5ea;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
    }

    /* Cards */
    .checkout-box {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--upchar-border);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        padding: 24px;
        margin-bottom: 24px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .checkout-box-title {
        font-size: 16.5px;
        font-weight: 800;
        color: var(--upchar-navy);
        margin: 0 0 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1.5px solid #f1f5f9;
        padding-bottom: 12px;
    }
    .checkout-box-title i {
        color: var(--upchar-teal);
        font-size: 18px;
    }

    /* Doctor Profile Card */
    .dr-profile-layout {
        display: flex;
        gap: 18px;
        align-items: center;
    }
    .dr-avatar-frame {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #f0fdfa;
        border: 2px solid #ccfbf1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .dr-avatar-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .dr-avatar-frame i {
        font-size: 32px;
        color: var(--upchar-teal);
    }
    .dr-profile-meta h3 {
        font-size: 18px;
        font-weight: 800;
        color: var(--upchar-slate-900);
        margin: 0 0 4px;
        text-transform: capitalize;
    }
    .dr-spec-badge {
        display: inline-block;
        background: #f1f5f9;
        color: var(--upchar-teal-dark);
        font-size: 12.5px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
        margin-bottom: 6px;
    }
    .dr-hospital-name {
        font-size: 13.5px;
        color: var(--upchar-slate-600);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Appointment Info Grid */
    .appt-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #edf2f7;
        margin-top: 18px;
    }
    .appt-meta-item .meta-label {
        font-size: 11.5px;
        font-weight: 700;
        color: var(--upchar-slate-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .appt-meta-item .meta-val {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--upchar-slate-900);
    }
    .appt-meta-item .meta-val.highlight {
        color: var(--upchar-teal-dark);
    }

    /* Instructions & Policy */
    .appt-policy-pill {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 14px;
        font-size: 13px;
        color: #166534;
        margin-top: 16px;
    }
    .appt-policy-pill i {
        font-size: 18px;
        color: #16a34a;
        margin-top: 2px;
    }

    /* Order Summary Card */
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 14px;
    }
    .summary-item .label {
        color: var(--upchar-slate-600);
        font-weight: 500;
    }
    .summary-item .val {
        font-weight: 700;
        color: var(--upchar-slate-900);
    }
    .summary-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 14px 0;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 16px;
        font-weight: 800;
        color: var(--upchar-navy);
        padding-top: 4px;
    }
    .summary-total .total-amount {
        font-size: 24px;
        color: var(--upchar-teal-dark);
    }

    /* Upchar Points Wallet Section */
    .points-redeem-card {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
    }
    .points-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .points-header-left {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 800;
        color: #92400e;
        font-size: 14.5px;
    }
    .points-badge {
        background: #f59e0b;
        color: #ffffff;
        font-size: 12px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 20px;
    }
    .points-balance-text {
        font-size: 13px;
        color: #78350f;
        margin-bottom: 12px;
    }

    /* Payment Methods Choice */
    .payment-method-tile {
        border: 2px solid var(--upchar-border);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        background: #ffffff;
    }
    .payment-method-tile:hover {
        border-color: var(--upchar-teal);
        background: #f0fdfa;
    }
    .payment-method-tile.selected {
        border-color: var(--upchar-teal);
        background: #f0fdfa;
        box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
    }
    .payment-method-tile input[type="radio"] {
        margin-top: 4px;
        width: 18px;
        height: 18px;
        accent-color: var(--upchar-teal);
        cursor: pointer;
    }
    .pm-info {
        flex: 1;
    }
    .pm-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--upchar-slate-900);
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .pm-desc {
        font-size: 13px;
        color: var(--upchar-slate-500);
        line-height: 1.4;
        margin-bottom: 8px;
    }
    .pm-logos {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }
    .pm-logos span {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        color: var(--upchar-slate-600);
    }

    /* Action Buttons */
    .btn-checkout-primary {
        background: linear-gradient(135deg, var(--upchar-teal) 0%, var(--upchar-teal-dark) 100%);
        color: #ffffff;
        border: none;
        width: 100%;
        padding: 15px 24px;
        font-size: 16px;
        font-weight: 800;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(13, 122, 110, 0.35);
        transition: all 0.2s ease;
    }
    .btn-checkout-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(13, 122, 110, 0.45);
        color: #ffffff;
    }
    .btn-checkout-primary:disabled {
        background: #94a3b8;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    .btn-checkout-coc {
        background: #ffffff;
        color: var(--upchar-navy);
        border: 2px solid var(--upchar-navy);
        width: 100%;
        padding: 14px 24px;
        font-size: 15px;
        font-weight: 800;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s ease;
        margin-top: 10px;
    }
    .btn-checkout-coc:hover {
        background: #f8fafc;
        color: var(--upchar-navy);
    }

    .btn-points-pay {
        background: #f59e0b;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 800;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }
    .btn-points-pay:hover {
        background: #d97706;
        color: #ffffff;
    }

    /* Trust & Security Badges */
    .trust-footer-strip {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin-top: 18px;
        color: var(--upchar-slate-500);
        font-size: 12.5px;
        flex-wrap: wrap;
    }
    .trust-footer-strip span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Alert Banner */
    .checkout-alert-box {
        padding: 14px 18px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
        display: none;
    }
    .checkout-alert-box.alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .checkout-alert-box.alert-success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    @media (max-width: 768px) {
        .appt-meta-grid {
            grid-template-columns: 1fr;
        }
        .dr-profile-layout {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="appt-checkout-wrapper">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <div class="checkout-breadcrumbs">
            <a href="<?=base_url();?>"><i class="fa fa-home"></i> Home</a>
            <span class="sep">/</span>
            <a href="<?=base_url('myappointents');?>">My Appointments</a>
            <span class="sep">/</span>
            <span>Appointment Checkout</span>
        </div>

        <!-- Header -->
        <div class="checkout-page-header">
            <h1>
                <span>Doctor Appointment Checkout</span>
                <span class="badge-sec-pill"><i class="fa fa-shield"></i> 100% Secure &amp; Verified</span>
            </h1>
            <p>Verify consultation details, apply Upchar Points, and select your preferred payment mode.</p>
        </div>

        <!-- In-Page Alert Message -->
        <div id="checkoutAlert" class="checkout-alert-box alert-danger"></div>

        <?php if($this->session->flashdata('flashmsg')): ?>
            <div style="margin-bottom: 20px;"><?=$this->session->flashdata('flashmsg');?></div>
        <?php endif; ?>

        <?php
            $fee = floatval($appointment_data ? $appointment_data->fee : ($gatewayData['Amount'] ?? 100.00));
            $drName = !empty($doctor_data->name) ? $doctor_data->name : (!empty($appointment_data->doctor_id) ? getDoctorName($appointment_data->doctor_id) : 'Consultant Doctor');
            $drSpec = !empty($doctor_data->specialization) ? $doctor_data->specialization : (!empty($doctor_data->degree) ? $doctor_data->degree : 'General OPD Specialist');
            $hospName = !empty($hospital_data->name) ? $hospital_data->name : (!empty($appointment_data->institute_id) ? getInstituteName($appointment_data->institute_id, $appointment_data->institution_type) : 'Upchar Healthcare Clinic');
            $hospAddr = !empty($hospital_data->address) ? $hospital_data->address : 'Consultation Center';
            $drPhoto = !empty($doctor_data->image) ? (strpos($doctor_data->image, 'http') === 0 ? $doctor_data->image : base_url('public/assets/upload/' . $doctor_data->image)) : '';
            $apptDate = !empty($appointment_data->appointment_date) ? date('d M Y, l', strtotime($appointment_data->appointment_date)) : date('d M Y, l');
            $timing = (!empty($appointment_data->from_timing) && !empty($appointment_data->to_timing)) ? ($appointment_data->from_timing . ' - ' . $appointment_data->to_timing) : 'Scheduled OPD Slot';
        ?>

        <div class="row">
            <!-- Left Column: Doctor & Appointment Details -->
            <div class="col-md-7">
                
                <!-- Doctor Card -->
                <div class="checkout-box">
                    <div class="checkout-box-title">
                        <i class="fa fa-user-md"></i> Consulting Doctor &amp; Facility
                    </div>
                    <div class="dr-profile-layout">
                        <div class="dr-avatar-frame">
                            <?php if(!empty($drPhoto)): ?>
                                <img src="<?=$drPhoto;?>" alt="<?=htmlspecialchars($drName);?>" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fa fa-user-md" style="display: none;"></i>
                            <?php else: ?>
                                <i class="fa fa-user-md"></i>
                            <?php endif; ?>
                        </div>
                        <div class="dr-profile-meta">
                            <h3><?=((stripos($drName, 'Dr.') === 0 || stripos($drName, 'Dr ') === 0) ? '' : 'Dr. ') . htmlspecialchars($drName);?></h3>
                            <span class="dr-spec-badge"><i class="fa fa-stethoscope"></i> <?=htmlspecialchars($drSpec);?></span>
                            <p class="dr-hospital-name"><i class="fa fa-hospital-o" style="color: var(--upchar-teal);"></i> <?=htmlspecialchars($hospName);?></p>
                            <div style="font-size: 12.5px; color: var(--upchar-slate-500); margin-top: 4px;">
                                <i class="fa fa-map-marker" style="color: #ef4444;"></i> <?=htmlspecialchars($hospAddr);?>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details Grid -->
                    <div class="appt-meta-grid">
                        <div class="appt-meta-item">
                            <div class="meta-label">Booking Reference</div>
                            <div class="meta-val highlight">#<?=$AppointmentCheckout;?></div>
                        </div>
                        <div class="appt-meta-item">
                            <div class="meta-label">Consultation Mode</div>
                            <div class="meta-val"><i class="fa fa-building-o"></i> In-Clinic OPD Visit</div>
                        </div>
                        <div class="appt-meta-item">
                            <div class="meta-label">Consultation Date</div>
                            <div class="meta-val"><?=$apptDate;?></div>
                        </div>
                        <div class="appt-meta-item">
                            <div class="meta-label">Scheduled Time Slot</div>
                            <div class="meta-val"><?=$timing;?></div>
                        </div>
                        <div class="appt-meta-item">
                            <div class="meta-label">Patient Name</div>
                            <div class="meta-val"><?=htmlspecialchars($appointment_data->appointment_name);?></div>
                        </div>
                        <div class="appt-meta-item">
                            <div class="meta-label">Patient Contact</div>
                            <div class="meta-val"><?=htmlspecialchars($appointment_data->appointment_mobile);?></div>
                        </div>
                    </div>

                    <!-- Policy Info -->
                    <div class="appt-policy-pill">
                        <i class="fa fa-check-circle"></i>
                        <div>
                            <strong>Free Rescheduling &amp; 100% Cancellation Policy</strong><br/>
                            Cancel or reschedule up to 2 hours before the appointment with instant 100% refund credited directly to your Upchar Wallet.
                        </div>
                    </div>
                </div>

                <!-- Patient Instructions -->
                <div class="checkout-box">
                    <div class="checkout-box-title">
                        <i class="fa fa-info-circle"></i> OPD Visit Guidelines
                    </div>
                    <ul style="margin: 0; padding-left: 20px; font-size: 13.5px; color: var(--upchar-slate-600); line-height: 1.6;">
                        <li>Please arrive 10-15 minutes before your scheduled appointment slot for vitals checkup.</li>
                        <li>Carry any relevant previous medical history, prescriptions, or laboratory diagnostic reports.</li>
                        <li>Present the SMS confirmation or invoice receipt at the clinic reception counter.</li>
                    </ul>
                </div>

            </div>

            <!-- Right Column: Order Summary, Points & Payment -->
            <div class="col-md-5">
                
                <!-- Fee Summary Card -->
                <div class="checkout-box">
                    <div class="checkout-box-title">
                        <i class="fa fa-receipt"></i> Payment Breakdown
                    </div>

                    <div class="summary-item">
                        <span class="label">Doctor Consultation Fee</span>
                        <span class="val">₹<?=number_format($fee, 2);?></span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Platform Booking Fee</span>
                        <span class="val" style="color: var(--upchar-success); font-weight: 700;">FREE (₹0.00)</span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Healthcare GST (Notification No. 12/2017)</span>
                        <span class="val" style="color: var(--upchar-slate-500);">₹0.00 (Exempt)</span>
                    </div>

                    <!-- Promo / Coupon Code Box -->
                    <div class="coupon-box" style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 14px; margin-bottom: 16px;">
                        <div style="font-size: 13.5px; font-weight: 700; color: var(--upchar-slate-900); margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fa fa-tag" style="color: var(--upchar-teal);"></i> Apply Coupon Code</span>
                            <span id="appliedCouponBadge" style="display:none; background: #dcfce7; color: #166534; font-size: 11px; padding: 2px 8px; border-radius: 12px; font-weight: 700;">Applied</span>
                        </div>
                        <div class="input-group" style="display: flex; gap: 6px;">
                            <input type="text" id="inputCouponCode" class="form-control" placeholder="Enter code (e.g. DOC15, HEALTH50)" style="text-transform: uppercase; font-weight: 700; font-size: 13px; border-radius: 8px; border: 1px solid #cbd5e1;">
                            <button type="button" id="btnApplyCoupon" class="btn" style="background: var(--upchar-teal); color: #fff; font-weight: 700; font-size: 13px; border-radius: 8px; padding: 6px 14px;">Apply</button>
                            <button type="button" id="btnRemoveCoupon" class="btn btn-outline-danger" style="display:none; border-radius: 8px; font-size: 12px; padding: 6px 10px;" title="Remove Coupon"><i class="fa fa-times"></i></button>
                        </div>
                        <div id="couponFeedback" style="font-size: 12px; margin-top: 6px; display: none;"></div>
                        
                        <!-- Quick Pick Coupons -->
                        <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
                            <span style="font-size: 11px; color: #64748b; font-weight: 600;">Offers:</span>
                            <span class="coupon-pill" onclick="quickApplyCoupon('DOC15')" style="cursor: pointer; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px;" title="15% Off Doctor Consultations">DOC15 (15% OFF)</span>
                            <span class="coupon-pill" onclick="quickApplyCoupon('HEALTH50')" style="cursor: pointer; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px;" title="Flat ₹50 Off">HEALTH50 (₹50 OFF)</span>
                            <span class="coupon-pill" onclick="quickApplyCoupon('UPCHAR10')" style="cursor: pointer; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px;" title="10% Off All Services">UPCHAR10 (10% OFF)</span>
                        </div>
                    </div>

                    <div id="couponDiscountRow" class="summary-item" style="display: none; color: #16a34a;">
                        <span class="label" style="color: #16a34a; font-weight: 700;"><i class="fa fa-tag"></i> Coupon Discount (<span id="couponCodeLabel"></span>)</span>
                        <span class="val" id="couponDiscountVal">-₹0.00</span>
                    </div>

                    <!-- Upchar Points Wallet Box -->
                    <div class="points-redeem-card">
                        <div class="points-header">
                            <div class="points-header-left">
                                <i class="fa fa-star" style="color: #f59e0b;"></i> Upchar Wallet Points
                            </div>
                            <span class="points-badge"><?=number_format($user_points, 2);?> Pts</span>
                        </div>
                        <div class="points-balance-text">
                            Available Balance: <strong><?=number_format($user_points, 2);?> Points</strong> (Worth ₹<?=number_format($user_points, 2);?>)
                        </div>

                        <?php if($user_points >= $fee): ?>
                            <div style="margin-top: 10px;">
                                <a href="<?=base_url('paysecure/pay_via_points');?>" class="btn-points-pay" style="width: 100%; justify-content: center; padding: 10px;">
                                    <i class="fa fa-bolt"></i> 1-Click Pay ₹<?=number_format($fee, 2);?> with Points
                                </a>
                            </div>
                        <?php elseif($user_points > 0): ?>
                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                <input type="checkbox" id="usePointsToggle" style="width: 16px; height: 16px; accent-color: var(--upchar-teal);">
                                <label for="usePointsToggle" style="font-size: 13px; font-weight: 700; color: #92400e; margin: 0; cursor: pointer;">
                                    Redeem <?=number_format($user_points, 2);?> Points (Save ₹<?=number_format($user_points, 2);?>)
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div id="pointsDiscountRow" class="summary-item" style="display: none; color: #b45309;">
                        <span class="label" style="color: #b45309; font-weight: 700;"><i class="fa fa-star"></i> Points Redeemed</span>
                        <span class="val" id="pointsDiscountVal">-₹0.00</span>
                    </div>

                    <!-- Cashback Rewards Banner -->
                    <?php 
                        $cashbackRate = !empty($cashback_pct) ? $cashback_pct : 5.00;
                        $estimatedCashback = round(($fee * $cashbackRate) / 100, 2);
                    ?>
                    <div class="cashback-banner" style="background: #ecfdf5; border: 1px dashed #10b981; border-radius: 10px; padding: 12px 14px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                        <div style="width: 34px; height: 34px; border-radius: 50%; background: #d1fae5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                            <i class="fa fa-gift"></i>
                        </div>
                        <div style="font-size: 12.5px; color: #065f46; line-height: 1.4;">
                            <strong>Earn <?=number_format($cashbackRate, 0);?>% Cashback (~₹<?=number_format($estimatedCashback, 2);?>)</strong><br/>
                            Credited straight to your Upchar Points Wallet on consultation completion.
                        </div>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-total">
                        <span>Total Payable Amount</span>
                        <span class="total-amount" id="finalPayableAmt">₹<?=number_format($fee, 2);?></span>
                    </div>
                </div>

                <!-- Payment Methods Card -->
                <div class="checkout-box">
                    <div class="checkout-box-title">
                        <i class="fa fa-credit-card"></i> Choose Payment Method
                    </div>

                    <!-- Option 1: Razorpay Gateway -->
                    <label class="payment-method-tile selected" id="tileRazorpay">
                        <input type="radio" name="payment_mode" id="modeRazorpay" value="RAZORPAY" checked>
                        <div class="pm-info">
                            <div class="pm-title">
                                <span>Online Payment Gateway (Razorpay)</span>
                                <span style="background: #e6fffa; color: var(--upchar-teal-dark); font-size: 11px; padding: 2px 7px; border-radius: 4px; font-weight: 800;">RECOMMENDED</span>
                            </div>
                            <div class="pm-desc">Instant online confirmation via UPI, Cards, Net Banking &amp; Wallets.</div>
                            <div class="pm-logos">
                                <span><i class="fa fa-mobile-phone"></i> UPI (GPay/PhonePe)</span>
                                <span><i class="fa fa-credit-card"></i> Cards (Visa/MC/RuPay)</span>
                                <span><i class="fa fa-university"></i> Net Banking</span>
                            </div>
                        </div>
                    </label>

                    <!-- Option 2: Pay on Counter -->
                    <label class="payment-method-tile" id="tileCoc">
                        <input type="radio" name="payment_mode" id="modeCoc" value="COC">
                        <div class="pm-info">
                            <div class="pm-title">
                                <span>Pay at Clinic Counter (COC)</span>
                            </div>
                            <div class="pm-desc">Pay cash or card at the hospital/clinic desk during your appointment.</div>
                        </div>
                    </label>

                    <!-- Submit Buttons Container -->
                    <div style="margin-top: 20px;">
                        <button type="button" id="btnPayRazorpay" class="btn-checkout-primary">
                            <i class="fa fa-lock"></i> <span id="btnPayText">Pay ₹<?=number_format($fee, 2);?> via Razorpay</span>
                        </button>

                        <button type="button" id="btnPayCoc" class="btn-checkout-coc" style="display: none;">
                            <i class="fa fa-hospital-o"></i> Confirm &amp; Pay at Counter
                        </button>
                    </div>

                    <!-- Trust Strip -->
                    <div class="trust-footer-strip">
                        <span><i class="fa fa-lock" style="color: var(--upchar-teal);"></i> 256-bit SSL</span>
                        <span>&bull;</span>
                        <span><i class="fa fa-shield" style="color: var(--upchar-teal);"></i> PCI-DSS Level 1</span>
                        <span>&bull;</span>
                        <span><i class="fa fa-bank" style="color: var(--upchar-teal);"></i> RBI Regulated</span>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {
    const grossFee = <?=json_encode($fee);?>;
    const userPoints = <?=json_encode($user_points);?>;
    const apptId = <?=json_encode($AppointmentCheckout);?>;
    const rzpKeyId = <?=json_encode($rzp_key_id);?>;
    const patientName = <?=json_encode($appointment_data->appointment_name);?>;
    const patientEmail = <?=json_encode($appointment_data->appointment_email);?>;
    const patientMobile = <?=json_encode($appointment_data->appointment_mobile);?>;

    let pointsToUse = 0;
    let couponDiscount = 0;
    let appliedCouponCode = '';
    let netPayable = grossFee;

    function recalculateTotal() {
        if ($('#usePointsToggle').is(':checked')) {
            const remainingFee = Math.max(0, grossFee - couponDiscount);
            pointsToUse = Math.min(userPoints, remainingFee);
            $('#pointsDiscountRow').show();
            $('#pointsDiscountVal').text('-₹' + pointsToUse.toFixed(2));
        } else {
            pointsToUse = 0;
            $('#pointsDiscountRow').hide();
        }

        netPayable = Math.max(0, grossFee - couponDiscount - pointsToUse);
        $('#finalPayableAmt').text('₹' + netPayable.toFixed(2));
        $('#btnPayText').text('Pay ₹' + netPayable.toFixed(2) + ' via Razorpay');
    }

    function showAlert(msg, isSuccess) {
        const el = $('#checkoutAlert');
        el.removeClass('alert-danger alert-success');
        el.addClass(isSuccess ? 'alert-success' : 'alert-danger');
        el.html(msg).fadeIn();
        $('html, body').animate({ scrollTop: el.offset().top - 100 }, 300);
    }

    function hideAlert() {
        $('#checkoutAlert').hide();
    }

    // Quick Apply Coupon
    window.quickApplyCoupon = function(code) {
        $('#inputCouponCode').val(code);
        $('#btnApplyCoupon').trigger('click');
    };

    // Apply Coupon via AJAX
    $('#btnApplyCoupon').click(function() {
        const code = $('#inputCouponCode').val().trim();
        const fb = $('#couponFeedback');
        if (!code) {
            fb.css('color', '#dc2626').text('Please enter a coupon code.').show();
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).text('Applying...');

        $.ajax({
            url: "<?=base_url('coupon/apply');?>",
            type: "POST",
            dataType: "json",
            data: {
                coupon_code: code,
                service_type: 'APPOINTMENT',
                amount: grossFee,
                "<?=$this->security->get_csrf_token_name();?>": "<?=$this->security->get_csrf_hash();?>"
            },
            success: function(resp) {
                btn.prop('disabled', false).text('Apply');
                if (resp.status === 'success') {
                    couponDiscount = parseFloat(resp.discount_amount) || 0;
                    appliedCouponCode = resp.coupon_code;

                    $('#appliedCouponBadge').show();
                    $('#btnRemoveCoupon').show();
                    $('#inputCouponCode').prop('readonly', true);
                    $('#couponCodeLabel').text(resp.coupon_code);
                    $('#couponDiscountVal').text('-₹' + couponDiscount.toFixed(2));
                    $('#couponDiscountRow').show();
                    fb.css('color', '#16a34a').text(resp.message).show();

                    recalculateTotal();
                } else {
                    fb.css('color', '#dc2626').text(resp.message || 'Invalid coupon code.').show();
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Apply');
                let errText = 'Error validating coupon. Please try again.';
                try {
                    const parsed = JSON.parse(xhr.responseText);
                    if (parsed && parsed.message) errText = parsed.message;
                } catch(e) {}
                fb.css('color', '#dc2626').text(errText).show();
            }
        });
    });

    // Remove Coupon
    $('#btnRemoveCoupon').click(function() {
        $.post("<?=base_url('coupon/remove');?>", function() {
            couponDiscount = 0;
            appliedCouponCode = '';
            $('#inputCouponCode').prop('readonly', false).val('');
            $('#appliedCouponBadge').hide();
            $('#btnRemoveCoupon').hide();
            $('#couponDiscountRow').hide();
            $('#couponFeedback').hide();
            recalculateTotal();
        });
    });

    // Toggle Payment Method Tiles
    $('input[name="payment_mode"]').change(function() {
        const selected = $(this).val();
        $('.payment-method-tile').removeClass('selected');
        if (selected === 'RAZORPAY') {
            $('#tileRazorpay').addClass('selected');
            $('#btnPayRazorpay').show();
            $('#btnPayCoc').hide();
        } else {
            $('#tileCoc').addClass('selected');
            $('#btnPayRazorpay').hide();
            $('#btnPayCoc').show();
        }
    });

    // Points Redemption Checkbox
    $('#usePointsToggle').change(function() {
        recalculateTotal();
    });

    // Pay on Counter Trigger
    $('#btnPayCoc').click(function() {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing Confirmation...');
        window.location.href = "<?=base_url('paysecure/processordercod');?>";
    });

    // Pay via Razorpay Trigger
    $('#btnPayRazorpay').click(function(e) {
        e.preventDefault();
        hideAlert();

        const btn = $(this);
        const originalHtml = btn.html();

        if (netPayable <= 0) {
            // If covered 100%, route directly to points payment
            window.location.href = "<?=base_url('paysecure/pay_via_points');?>";
            return;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Initializing Razorpay...');

        // Call backend to create Razorpay Order
        $.ajax({
            url: "<?=base_url('paysecure/initiate_razorpay');?>",
            type: "POST",
            dataType: "json",
            data: {
                appointment_id: apptId,
                wallet_points_to_use: pointsToUse,
                coupon_code: appliedCouponCode
            },
            success: function(resp) {
                if (resp.status === 'points_only') {
                    window.location.href = resp.redirect_url;
                    return;
                }

                if (resp.status !== 'success') {
                    showAlert(resp.message || 'Unable to initiate payment with Razorpay.', false);
                    btn.prop('disabled', false).html(originalHtml);
                    return;
                }

                // Razorpay Order created successfully
                const rzpOrderId = resp.razorpay_order_id;
                const internalRef = resp.internal_order_ref;
                const activeKey = resp.key_id || rzpKeyId;

                // Configure Razorpay Checkout Options
                const options = {
                    key: activeKey,
                    amount: resp.amount_paise,
                    currency: "INR",
                    name: "UPCHAR Health",
                    description: "Doctor OPD Consultation #" + apptId,
                    image: "<?=base_url('assets/images/logo.png');?>",
                    order_id: rzpOrderId,
                    prefill: {
                        name: resp.user_name || patientName,
                        email: resp.user_email || patientEmail,
                        contact: resp.user_mobile || patientMobile
                    },
                    theme: {
                        color: "#00a896"
                    },
                    modal: {
                        ondismiss: function() {
                            btn.prop('disabled', false).html(originalHtml);
                        }
                    },
                    handler: function(paymentResponse) {
                        btn.html('<i class="fa fa-spinner fa-spin"></i> Verifying Payment...');

                        // Send tokens to backend for verification and fulfillment
                        $.ajax({
                            url: "<?=base_url('paysecure/verify_razorpay');?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                razorpay_order_id: paymentResponse.razorpay_order_id,
                                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                razorpay_signature: paymentResponse.razorpay_signature,
                                internal_order_ref: internalRef
                            },
                            success: function(verifyResp) {
                                if (verifyResp.status === 'success') {
                                    showAlert('Payment successful! Redirecting to your official Tax Invoice...', true);
                                    window.location.href = verifyResp.redirect_url;
                                } else {
                                    showAlert(verifyResp.message || 'Payment verification failed.', false);
                                    btn.prop('disabled', false).html(originalHtml);
                                }
                            },
                            error: function() {
                                showAlert('Verification communication error. Please check My Appointments.', false);
                                btn.prop('disabled', false).html(originalHtml);
                            }
                        });
                    }
                };

                // Open Razorpay Standard Checkout
                try {
                    const rzpInstance = new Razorpay(options);
                    rzpInstance.on('payment.failed', function(response) {
                        showAlert('Payment Failed: ' + (response.error.description || 'Transaction cancelled by user.'), false);
                        btn.prop('disabled', false).html(originalHtml);
                    });
                    rzpInstance.open();
                } catch (ex) {
                    console.error('Razorpay SDK error:', ex);
                    showAlert('Failed to open Razorpay modal: ' + ex.message, false);
                    btn.prop('disabled', false).html(originalHtml);
                }
            },
            error: function(xhr, status, err) {
                console.error('AJAX Error:', xhr.responseText);
                showAlert('Failed to connect to payment server. Please try again.', false);
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });
});
</script>

<?php $this->load->view('includes/footer'); ?>