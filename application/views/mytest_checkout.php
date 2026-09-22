<?php include ('includes/header.php'); ?>

<!-- Modern High-Conversion Diagnostic Test Checkout (Tata 1mg / Apollo 24|7 Standard) -->
<style>
/* Page Layout & Theme */
.upchar-checkout-page {
    background-color: #F8FAFC;
    padding: 24px 0 80px;
    font-family: 'Poppins', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #1E293B;
}

/* Stepper & Header Bar */
.checkout-header-bar {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1px solid #E2E8F0;
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.checkout-title-wrap h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.checkout-title-wrap p {
    font-size: 13.5px;
    color: #64748B;
    margin: 0;
}

.checkout-stepper {
    display: flex;
    align-items: center;
    gap: 12px;
}

.step-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #94A3B8;
    padding: 6px 14px;
    border-radius: 9999px;
    background: #F1F5F9;
}

.step-pill.completed {
    background: #E6F4EA;
    color: #16A34A;
}

.step-pill.active {
    background: #F0FDFA;
    color: #00A896;
    border: 1.5px solid #00A896;
    font-weight: 700;
}

.step-divider {
    color: #CBD5E1;
    font-size: 12px;
}

/* Trust Bar */
.trust-strip {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 12px;
    margin-bottom: 24px;
}

.trust-item {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
}

.trust-item-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #F0FDFA;
    color: #00A896;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.trust-item-text {
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    line-height: 1.35;
}

.trust-item-text span {
    display: block;
    font-size: 11px;
    color: #64748B;
    font-weight: 500;
}

/* Modern Card Layout */
.checkout-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    transition: all 0.2s ease;
}

.checkout-card:hover {
    border-color: #CBD5E1;
}

.card-step-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #F1F5F9;
    padding-bottom: 14px;
    margin-bottom: 18px;
}

.card-step-title {
    font-size: 16.5px;
    font-weight: 800;
    color: #0F172A;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-step-title .badge-step-num {
    width: 26px;
    height: 26px;
    background: #00A896;
    color: #FFFFFF;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 800;
}

/* Patient Selector Pills */
.patient-selector-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
    background: #F8FAFC;
    padding: 8px;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
}

.patient-pill-btn {
    border: 1.5px solid #CBD5E1;
    background: #FFFFFF;
    color: #475569;
    font-size: 12.5px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}

.patient-pill-btn:hover {
    background: #F1F5F9;
    color: #0F172A;
}

.patient-pill-btn.active {
    background: #00A896;
    color: #FFFFFF;
    border-color: #00A896;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.25);
}

/* Form Input Enhancements */
.upchar-input-wrap label {
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.upchar-input-wrap .form-control {
    height: 46px;
    border-radius: 10px;
    border: 1.5px solid #E2E8F0;
    padding: 10px 14px;
    font-size: 13.5px;
    color: #0F172A;
    background-color: #FFFFFF;
    transition: all 0.15s ease;
    box-shadow: none !important;
}

.upchar-input-wrap .form-control:focus {
    border-color: #00A896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.12) !important;
}

.upchar-input-wrap textarea.form-control {
    height: auto;
    resize: vertical;
}

/* Choice Cards (Collection Preference & Payment) */
.choice-card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 12px;
    margin-bottom: 16px;
}

.choice-card {
    position: relative;
    border: 1.5px solid #E2E8F0;
    background: #FFFFFF;
    border-radius: 12px;
    padding: 14px 16px;
    cursor: pointer;
    transition: all 0.15s ease;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.choice-card:hover {
    border-color: #94A3B8;
    background: #F8FAFC;
}

.choice-card.selected {
    border-color: #00A896;
    background: #F0FDFA;
    box-shadow: 0 2px 10px rgba(0, 168, 150, 0.1);
}

.choice-card input[type="radio"] {
    margin-top: 3px;
    accent-color: #00A896;
    width: 17px;
    height: 17px;
    cursor: pointer;
}

.choice-card-info {
    flex-grow: 1;
}

.choice-card-info strong {
    font-size: 14px;
    font-weight: 700;
    color: #0F172A;
    display: block;
    margin-bottom: 2px;
}

.choice-card-info p {
    font-size: 12px;
    color: #64748B;
    margin: 0;
    line-height: 1.4;
}

.choice-badge-free {
    background: #DCFCE7;
    color: #16A34A;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 6px;
    display: inline-block;
    margin-top: 4px;
}

/* Fasting Advisory Notice */
.fasting-notice-box {
    background: #FFFBEB;
    border: 1px solid #FDE68A;
    border-radius: 10px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 14px;
}

.fasting-notice-box i {
    color: #D97706;
    font-size: 20px;
    flex-shrink: 0;
}

.fasting-notice-box div {
    font-size: 12.5px;
    color: #92400E;
    line-height: 1.4;
}

/* Schedule Chips */
.date-chips-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.date-chip {
    border: 1.5px solid #E2E8F0;
    background: #FFFFFF;
    padding: 8px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s ease;
    text-align: center;
}

.date-chip:hover {
    border-color: #00A896;
    color: #00A896;
}

.date-chip.active {
    background: #00A896;
    border-color: #00A896;
    color: #FFFFFF;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.25);
}

.slot-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 10px;
}

.slot-card {
    border: 1.5px solid #E2E8F0;
    background: #FFFFFF;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.slot-card:hover {
    border-color: #00A896;
    background: #F8FAFC;
}

.slot-card.active {
    border-color: #00A896;
    background: #F0FDFA;
    color: #00A896;
    font-weight: 700;
}

/* Sticky Order Summary */
.checkout-summary-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 22px 20px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
    position: sticky;
    top: 90px;
}

.summary-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #F1F5F9;
    padding-bottom: 12px;
    margin-bottom: 14px;
}

.summary-header h3 {
    font-size: 16px;
    font-weight: 800;
    color: #0F172A;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.summary-clear-btn {
    background: none;
    border: none;
    color: #EF4444;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 6px;
    transition: background 0.15s ease;
}

.summary-clear-btn:hover {
    background: #FEE2E2;
}

.checkout-items-list {
    max-height: 280px;
    overflow-y: auto;
    padding-right: 4px;
    margin-bottom: 16px;
}

.checkout-item-row {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 10px 12px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    transition: all 0.2s ease;
}

.checkout-item-row:hover {
    border-color: #CBD5E1;
}

.checkout-item-info {
    flex-grow: 1;
}

.checkout-item-name {
    font-size: 13px;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 3px;
    line-height: 1.3;
}

.checkout-item-meta {
    font-size: 11px;
    color: #64748B;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.checkout-item-meta span {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.checkout-item-price-wrap {
    text-align: right;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.checkout-item-price {
    font-size: 14px;
    font-weight: 800;
    color: #00A896;
}

.checkout-item-mrp {
    font-size: 11px;
    color: #94A3B8;
    text-decoration: line-through;
    display: block;
}

.btn-remove-item {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #FFFFFF;
    border: 1px solid #FECACA;
    color: #EF4444;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.15s ease;
}

.btn-remove-item:hover {
    background: #EF4444;
    color: #FFFFFF;
    border-color: #EF4444;
}

/* Price Calculation Box */
.price-breakdown {
    background: #F8FAFC;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 16px;
    border: 1px solid #E2E8F0;
}

.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #475569;
    margin-bottom: 8px;
}

.price-row.discount {
    color: #16A34A;
    font-weight: 600;
}

.price-row.total {
    border-top: 1.5px dashed #CBD5E1;
    padding-top: 10px;
    margin-top: 10px;
    font-size: 15px;
    font-weight: 800;
    color: #0F172A;
}

.price-row.total .grand-amount {
    font-size: 22px;
    font-weight: 900;
    color: #00A896;
}

.savings-banner {
    background: #E6F4EA;
    color: #166534;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 16px;
    border: 1px solid #BBF7D0;
}

/* Primary Booking CTA */
.btn-confirm-checkout {
    width: 100%;
    background: #00A896;
    color: #FFFFFF;
    border: none;
    border-radius: 12px;
    padding: 14px 20px;
    font-size: 15px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35);
    transition: all 0.2s ease;
}

.btn-confirm-checkout:hover {
    background: #008f80;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0, 168, 150, 0.45);
    color: #FFFFFF;
}

.btn-confirm-checkout:disabled {
    background: #94A3B8;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.security-assurance-list {
    margin-top: 16px;
    border-top: 1px solid #F1F5F9;
    padding-top: 14px;
    font-size: 11.5px;
    color: #64748B;
}

.security-assurance-list div {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}

.security-assurance-list i {
    color: #16A34A;
    font-size: 13px;
}

/* Empty State Card */
.empty-checkout-card {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1px solid #E2E8F0;
    padding: 48px 24px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    max-width: 850px;
    margin: 20px auto 40px;
}

.empty-icon-circle {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #F0FDFA;
    color: #00A896;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    margin-bottom: 16px;
}
</style>

<section class="upchar-checkout-page">
    <div class="container">
        
        <!-- Breadcrumbs & Step Indicator Bar -->
        <div class="checkout-header-bar">
            <div class="checkout-title-wrap">
                <h1>
                    <i class="fas fa-shield-alt" style="color: #00A896;"></i> Secure Diagnostic Checkout
                </h1>
                <p>
                    Certified lab booking with doorstep sample pickup &amp; 100% verified digital reports.
                </p>
            </div>

            <!-- Stepper Indicator -->
            <div class="checkout-stepper">
                <div class="step-pill completed">
                    <i class="fas fa-check-circle"></i> 1. Cart Review
                </div>
                <div class="step-divider"><i class="fas fa-chevron-right"></i></div>
                <div class="step-pill active">
                    <i class="fas fa-calendar-check"></i> 2. Patient &amp; Schedule
                </div>
                <div class="step-divider"><i class="fas fa-chevron-right"></i></div>
                <div class="step-pill">
                    <i class="fas fa-receipt"></i> 3. Confirmed
                </div>
            </div>
        </div>

        <!-- Trust Highlights Bar -->
        <div class="trust-strip">
            <div class="trust-item">
                <div class="trust-item-icon"><i class="fas fa-award"></i></div>
                <div class="trust-item-text">
                    NABL &amp; CAP Certified Labs
                    <span>100% accurate, doctor-verified</span>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-item-icon"><i class="fas fa-user-nurse"></i></div>
                <div class="trust-item-text">
                    Free Home Sample Pickup
                    <span>Trained DMLT certified phlebotomists</span>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-item-icon"><i class="fas fa-vial"></i></div>
                <div class="trust-item-text">
                    Barcoded Sealed Vials
                    <span>Zero sample contamination risk</span>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-item-icon"><i class="fas fa-mobile-alt"></i></div>
                <div class="trust-item-text">
                    Reports in 6-24 Hours
                    <span>Instant PDF via WhatsApp &amp; Email</span>
                </div>
            </div>
        </div>

        <?php if($this->session->flashdata('flashmsg')): ?>
            <div style="margin-bottom: 20px;">
                <?=$this->session->flashdata('flashmsg');?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <!-- Empty Cart Handler -->
            <div class="empty-checkout-card">
                <div class="empty-icon-circle">
                    <i class="fas fa-vials"></i>
                </div>
                <h2 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Your Diagnostic Cart is Empty</h2>
                <p style="font-size: 13.5px; color: #64748B; max-width: 500px; margin: 0 auto 24px;">
                    You do not have any lab tests or checkup packages selected yet. Explore our certified tests catalog or pick a popular checkup below:
                </p>

                <a href="<?=base_url('mytest');?>" class="btn" style="background: #00A896; color: #FFFFFF; font-weight: 700; border-radius: 10px; padding: 10px 24px; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 30px;">
                    <i class="fas fa-search"></i> Browse Full Pathology Catalog
                </a>

                <?php if (!empty($popular_tests)): ?>
                    <div style="text-align: left; margin-top: 10px; border-top: 1px solid #F1F5F9; padding-top: 24px;">
                        <h4 style="font-size: 15px; font-weight: 800; color: #0F172A; margin-bottom: 16px;">Popular Preventive Checkups</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px;">
                            <?php foreach ($popular_tests as $pt): ?>
                                <div style="border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px 16px; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                                    <div>
                                        <strong style="font-size: 13px; color: #0F172A; display: block; margin-bottom: 2px;">
                                            <?=html_escape($pt->test_name);?>
                                        </strong>
                                        <span style="font-size: 13px; color: #00A896; font-weight: 800;">₹<?=number_format($pt->amount);?></span>
                                        <span style="font-size: 11px; color: #94A3B8; text-decoration: line-through; margin-left: 4px;">₹<?=round($pt->amount * 1.35);?></span>
                                    </div>
                                    <a href="<?=base_url('mytest/checkout?test_id=' . $pt->test_id);?>" class="btn btn-sm" style="background: #00A896; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 6px 12px; font-size: 12px; text-decoration: none; flex-shrink: 0;">
                                        + Add &amp; Book
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>

        <form action="<?=base_url('mytest/process_payment');?>" method="POST" id="checkoutForm">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

            <div class="row">
                
                <!-- LEFT COLUMN: Patient, Location, Scheduling & Payment -->
                <div class="col-md-8 col-12">
                    
                    <!-- STEP 1: Patient Information -->
                    <div class="checkout-card">
                        <div class="card-step-header">
                            <h2 class="card-step-title">
                                <span class="badge-step-num">1</span> Patient Details
                            </h2>
                            <span style="font-size: 12px; color: #64748B; font-weight: 500;">
                                Required for pathology report generation
                            </span>
                        </div>

                        <!-- Patient Fast Select Pills -->
                        <div class="patient-selector-pills">
                            <button type="button" class="patient-pill-btn active" id="btnSelectSelf" 
                                onclick="fillPatientData('<?=addslashes(html_escape($patient_name ?: @$user->FNAME));?>', '<?=$patient_age ?: 32;?>', '<?=$patient_gender ?: 'Male';?>', '<?=addslashes(html_escape($patient_mobile ?: @$user->MOBILE));?>', '<?=addslashes(html_escape($patient_email ?: @$user->EMAIL));?>', this)">
                                <i class="fas fa-user"></i> Myself (<?=html_escape($patient_name ?: @$user->FNAME);?>)
                            </button>

                            <?php if (!empty($dependents)): ?>
                                <?php foreach ($dependents as $dep): 
                                    $dep_age = 30;
                                    if (!empty($dep->dob)) {
                                        $dob_ts = strtotime($dep->dob);
                                        if ($dob_ts) $dep_age = max(1, date('Y') - date('Y', $dob_ts));
                                    }
                                    $dep_gender = ($dep->gender === 'F') ? 'Female' : 'Male';
                                ?>
                                    <button type="button" class="patient-pill-btn" 
                                        onclick="fillPatientData('<?=addslashes(html_escape($dep->name));?>', '<?=$dep_age;?>', '<?=$dep_gender;?>', '<?=addslashes(html_escape($patient_mobile ?: @$user->MOBILE));?>', '<?=addslashes(html_escape($patient_email ?: @$user->EMAIL));?>', this)">
                                        <i class="fas fa-users"></i> <?=html_escape($dep->name);?> (<?=html_escape($dep->relationship);?>)
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <button type="button" class="patient-pill-btn" onclick="clearPatientData(this)">
                                <i class="fas fa-user-plus"></i> Other Patient
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-12 form-group upchar-input-wrap">
                                <label>
                                    Patient Full Name <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="text" name="patient_name" id="inputPatientName" class="form-control" required placeholder="Full Name as per Aadhaar / ID" value="<?=html_escape($patient_name ?: @$user->FNAME);?>">
                            </div>

                            <div class="col-md-3 col-6 form-group upchar-input-wrap">
                                <label>
                                    Age (Years) <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="number" name="patient_age" id="inputPatientAge" class="form-control" required min="1" max="120" placeholder="e.g. 35" value="<?=$patient_age ?: 32;?>">
                            </div>

                            <div class="col-md-3 col-6 form-group upchar-input-wrap">
                                <label>
                                    Gender <span style="color: #EF4444;">*</span>
                                </label>
                                <select name="patient_gender" id="selectPatientGender" class="form-control">
                                    <option value="Male" <?=$patient_gender==='Male' ? 'selected' : '';?>>Male</option>
                                    <option value="Female" <?=$patient_gender==='Female' ? 'selected' : '';?>>Female</option>
                                    <option value="Other" <?=$patient_gender==='Other' ? 'selected' : '';?>>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-12 form-group upchar-input-wrap">
                                <label>
                                    10-Digit Mobile Number <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="tel" name="patient_mobile" id="inputPatientMobile" class="form-control" required maxlength="10" placeholder="Mobile for phlebotomist call &amp; SMS updates" value="<?=html_escape($patient_mobile ?: @$user->MOBILE);?>">
                            </div>

                            <div class="col-md-6 col-12 form-group upchar-input-wrap">
                                <label>
                                    Email Address (for PDF Report) <span style="color: #EF4444;">*</span>
                                </label>
                                <input type="email" name="patient_email" id="inputPatientEmail" class="form-control" required placeholder="Email for digital lab reports" value="<?=html_escape($patient_email ?: @$user->EMAIL);?>">
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Sample Collection & Scheduling -->
                    <div class="checkout-card">
                        <div class="card-step-header">
                            <h2 class="card-step-title">
                                <span class="badge-step-num">2</span> Sample Collection &amp; Schedule
                            </h2>
                            <span style="font-size: 12px; color: #16A34A; font-weight: 700;">
                                <i class="fas fa-check-circle"></i> Free Doorstep Pickup Included
                            </span>
                        </div>

                        <!-- Collection Mode Cards -->
                        <div class="choice-card-grid">
                            <label class="choice-card selected" id="choiceHomeCollection">
                                <input type="radio" name="visit_type" value="HOME_COLLECTION" checked onchange="toggleVisitType(this.value)">
                                <div class="choice-card-info">
                                    <strong><i class="fas fa-home" style="color: #00A896; margin-right: 4px;"></i> Doorstep Home Pickup</strong>
                                    <p>Trained medical phlebotomist visits your home with sterile vacutainer kit.</p>
                                    <span class="choice-badge-free"><i class="fas fa-gift"></i> 100% FREE Sample Collection</span>
                                </div>
                            </label>

                            <label class="choice-card" id="choiceLabVisit">
                                <input type="radio" name="visit_type" value="VISIT_LAB" onchange="toggleVisitType(this.value)">
                                <div class="choice-card-info">
                                    <strong><i class="fas fa-hospital" style="color: #0284C7; margin-right: 4px;"></i> Diagnostic Center Visit</strong>
                                    <p>Walk-in directly to the partner pathology lab with your booking code.</p>
                                    <span style="font-size: 11px; color: #64748B; font-weight: 600; display: inline-block; margin-top: 4px;">Priority Queue Entry</span>
                                </div>
                            </label>
                        </div>

                        <!-- Home Address Input (Shown when HOME_COLLECTION active) -->
                        <div id="homeAddressContainer" class="form-group upchar-input-wrap" style="margin-bottom: 16px;">
                            <label>
                                Complete Pickup Address <span style="color: #EF4444;">*</span>
                            </label>
                            <textarea name="patient_address" id="patientAddressInput" rows="2" class="form-control" required placeholder="House / Flat No, Building / Apartment Name, Street, Landmark, PIN Code"></textarea>
                            <span style="font-size: 11.5px; color: #64748B; margin-top: 4px; display: block;">
                                <i class="fas fa-info-circle" style="color: #00A896;"></i> Our technician will call you 15-20 minutes before arriving at your address.
                            </span>
                        </div>

                        <!-- Fasting Guidance Notice -->
                        <div class="fasting-notice-box">
                            <i class="fas fa-utensils"></i>
                            <div>
                                <strong>Fasting Guideline Note:</strong> If your booking includes Fasting Blood Sugar (FBS), Lipid Profile, or Full Body Checkup, please observe <strong>10 to 12 hours of overnight fasting</strong>. Drinking plain water is permitted and encouraged.
                            </div>
                        </div>

                        <!-- Date & Time Slot Scheduling -->
                        <div style="margin-top: 20px;">
                            <div class="row">
                                <div class="col-md-5 col-12 form-group upchar-input-wrap">
                                    <label>
                                        Select Appointment Date <span style="color: #EF4444;">*</span>
                                    </label>
                                    
                                    <div class="date-chips-wrap">
                                        <?php 
                                            $tomorrow = date('Y-m-d', strtotime('+1 day'));
                                            $day_after = date('Y-m-d', strtotime('+2 days'));
                                        ?>
                                        <div class="date-chip active" onclick="setDateValue('<?=$tomorrow;?>', this)">
                                            Tomorrow (<?=date('d M', strtotime('+1 day'));?>)
                                        </div>
                                        <div class="date-chip" onclick="setDateValue('<?=$day_after;?>', this)">
                                            <?=date('D, d M', strtotime('+2 days'));?>
                                        </div>
                                    </div>

                                    <input type="date" name="booking_date" id="bookingDateInput" class="form-control" required value="<?=$tomorrow;?>" min="<?=date('Y-m-d');?>">
                                </div>

                                <div class="col-md-7 col-12 form-group upchar-input-wrap">
                                    <label>
                                        Preferred Time Slot <span style="color: #EF4444;">*</span>
                                    </label>
                                    <select name="time_slot" id="timeSlotSelect" class="form-control" required>
                                        <option value="Early Morning (06:30 AM - 08:30 AM)">🌅 Early Morning (06:30 AM - 08:30 AM) - Best for Fasting</option>
                                        <option value="Morning (08:30 AM - 11:30 AM)" selected>☀️ Morning (08:30 AM - 11:30 AM) - Most Popular</option>
                                        <option value="Afternoon (12:00 PM - 03:00 PM)">🌤️ Afternoon (12:00 PM - 03:00 PM)</option>
                                        <option value="Evening (04:00 PM - 07:00 PM)">🌆 Evening (04:00 PM - 07:00 PM)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Optional Doctor Note / Special Instruction -->
                        <div class="form-group upchar-input-wrap" style="margin-bottom: 0;">
                            <label style="font-weight: 600; color: #64748B;">
                                Special Instructions or Landmark Note (Optional)
                            </label>
                            <input type="text" name="notes" class="form-control" placeholder="e.g. Near Community Center gate, please ring doorbell twice">
                        </div>

                    </div>

                    <!-- STEP 3: Payment Method Selection -->
                    <div class="checkout-card">
                        <div class="card-step-header">
                            <h2 class="card-step-title">
                                <span class="badge-step-num">3</span> Payment Method
                            </h2>
                            <span style="font-size: 12px; color: #16A34A; font-weight: 700;">
                                <i class="fas fa-lock"></i> 100% Safe &amp; Secure
                            </span>
                        </div>

                        <!-- Option 1: Pay on Sample Collection (Recommended) -->
                        <label class="choice-card selected" id="payMethodCOD" style="margin-bottom: 12px;">
                            <input type="radio" name="payment_mode" value="COD" checked onchange="togglePaymentMode(this.value)">
                            <div class="choice-card-info">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <strong><i class="fas fa-hand-holding-usd" style="color: #16A34A; margin-right: 4px;"></i> Pay on Sample Collection (Cash or UPI QR at Doorstep)</strong>
                                    <span style="background: #DCFCE7; color: #166534; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Recommended</span>
                                </div>
                                <p>Pay cash or simply scan the visiting phlebotomist's dynamic QR code via Google Pay, PhonePe, or Paytm once your samples are safely drawn.</p>
                            </div>
                        </label>

                        <!-- Option 2: Instant UPI Online -->
                        <label class="choice-card" id="payMethodUPI" style="margin-bottom: 12px;">
                            <input type="radio" name="payment_mode" value="ONLINE_UPI" onchange="togglePaymentMode(this.value)">
                            <div class="choice-card-info">
                                <strong><i class="fas fa-qrcode" style="color: #0284C7; margin-right: 4px;"></i> Instant Online UPI / QR Code</strong>
                                <p>Seamless payment with Google Pay, PhonePe, Paytm, BHIM, or any UPI banking app.</p>
                            </div>
                        </label>

                        <!-- Option 3: Credit/Debit Cards & Net Banking -->
                        <label class="choice-card" id="payMethodCard">
                            <input type="radio" name="payment_mode" value="ONLINE_CARD" onchange="togglePaymentMode(this.value)">
                            <div class="choice-card-info">
                                <strong><i class="fas fa-credit-card" style="color: #7C3AED; margin-right: 4px;"></i> Debit Card, Credit Card &amp; Net Banking</strong>
                                <p>256-bit SSL bank-grade checkout supporting all major Indian banks and card networks (Visa, MasterCard, RuPay).</p>
                            </div>
                        </label>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Sticky Order Summary -->
                <div class="col-md-4 col-12">
                    <div class="checkout-summary-card">
                        
                        <div class="summary-header">
                            <h3>
                                <i class="fas fa-shopping-bag" style="color: #00A896;"></i> Booked Tests (<span id="checkoutCartCount"><?=count($cart);?></span>)
                            </h3>
                            <button type="button" class="summary-clear-btn" onclick="clearCheckoutCart()" title="Remove all tests">
                                <i class="fas fa-trash-alt"></i> Clear All
                            </button>
                        </div>

                        <!-- Test Items List with smooth remove buttons -->
                        <div class="checkout-items-list" id="checkoutItemsList">
                            <?php foreach ($cart as $item): ?>
                                <div class="checkout-item-row" id="checkoutItem_<?=$item['test_id'];?>">
                                    <div class="checkout-item-info">
                                        <div class="checkout-item-name"><?=html_escape($item['test_name']);?></div>
                                        <div class="checkout-item-meta">
                                            <span><i class="fas fa-hospital" style="color: #00A896;"></i> <?=html_escape($item['lab_name']);?></span>
                                            <span><i class="fas fa-vial" style="color: #EF4444;"></i> <?=html_escape($item['sample_type']);?></span>
                                            <span><i class="fas fa-clock" style="color: #0284C7;"></i> <?=html_escape($item['report_time']);?></span>
                                        </div>
                                    </div>
                                    <div class="checkout-item-price-wrap">
                                        <div>
                                            <div class="checkout-item-price">₹<?=number_format($item['amount']);?></div>
                                            <?php if(!empty($item['mrp']) && $item['mrp'] > $item['amount']): ?>
                                                <span class="checkout-item-mrp">₹<?=number_format($item['mrp']);?></span>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn-remove-item btn-remove-checkout-item" data-test-id="<?=$item['test_id'];?>" title="Remove this test">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Coupon / Promo Code Input Card -->
                        <div class="coupon-box" style="background: #FFFFFF; border: 1.5px dashed #CBD5E1; border-radius: 12px; padding: 14px; margin-bottom: 16px;">
                            <div style="font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                                <span><i class="fas fa-tag" style="color: #00A896;"></i> Apply Promo / Coupon Code</span>
                                <span id="labAppliedBadge" style="display:none; background: #DCFCE7; color: #166534; font-size: 11px; padding: 2px 8px; border-radius: 12px; font-weight: 700;">Applied</span>
                            </div>
                            <div style="display: flex; gap: 6px;">
                                <input type="text" id="labCouponInput" name="applied_coupon_code" class="form-control" placeholder="e.g. LABCARE20, HEALTH50" style="text-transform: uppercase; font-weight: 700; font-size: 12.5px; border-radius: 8px; border: 1px solid #CBD5E1; height: 38px;">
                                <button type="button" id="btnApplyLabCoupon" class="btn" style="background: #00A896; color: #FFF; font-weight: 700; font-size: 12.5px; border-radius: 8px; padding: 6px 14px; white-space: nowrap;">Apply</button>
                                <button type="button" id="btnRemoveLabCoupon" class="btn btn-outline-danger" style="display:none; border-radius: 8px; padding: 6px 10px;" title="Remove Coupon"><i class="fas fa-times"></i></button>
                            </div>
                            <div id="labCouponFeedback" style="font-size: 12px; margin-top: 6px; display: none;"></div>

                            <!-- Quick Pick Promo Chips -->
                            <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
                                <span style="font-size: 11px; color: #64748B; font-weight: 600;">Offers:</span>
                                <span class="coupon-chip" onclick="quickApplyLabCoupon('LABCARE20')" style="cursor: pointer; background: #E0F2FE; color: #0369A1; border: 1px solid #BAE6FD; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px;" title="20% Off Pathology">LABCARE20 (20% OFF)</span>
                                <span class="coupon-chip" onclick="quickApplyLabCoupon('HEALTH50')" style="cursor: pointer; background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px;" title="Flat ₹50 Off">HEALTH50 (₹50 OFF)</span>
                                <span class="coupon-chip" onclick="quickApplyLabCoupon('UPCHAR10')" style="cursor: pointer; background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px;" title="10% Off All Services">UPCHAR10 (10% OFF)</span>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="price-breakdown">
                            <div class="price-row">
                                <span>Total Tests M.R.P.:</span>
                                <span id="checkoutTotalMrp" style="text-decoration: line-through; color: #94A3B8;">₹<?=number_format($total_mrp);?></span>
                            </div>

                            <div class="price-row discount">
                                <span>Direct Lab Discount:</span>
                                <span id="checkoutSavings">- ₹<?=number_format($savings);?></span>
                            </div>

                            <div class="price-row discount" id="labCouponDiscountRow" style="display: none; color: #16A34A; font-weight: 700;">
                                <span><i class="fas fa-tag"></i> Coupon Discount (<span id="labCouponCodeLabel"></span>):</span>
                                <span id="labCouponDiscountAmount">- ₹0</span>
                            </div>

                            <div class="price-row">
                                <span>Doorstep Sample Pickup:</span>
                                <span style="color: #16A34A; font-weight: 700;">
                                    <span style="text-decoration: line-through; color: #94A3B8; font-weight: 400; margin-right: 4px;">₹150</span> FREE
                                </span>
                            </div>

                            <div class="price-row">
                                <span>Hygiene &amp; Barcoded Vials:</span>
                                <span style="color: #16A34A; font-weight: 700;">FREE</span>
                            </div>

                            <div class="price-row total">
                                <span>Total Payable:</span>
                                <span class="grand-amount" id="checkoutFinalTotal">₹<?=number_format($final_total);?></span>
                            </div>
                        </div>

                        <!-- Cashback Rewards Box -->
                        <div style="background: #ECFDF5; border: 1px dashed #10B981; border-radius: 10px; padding: 10px 12px; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-coins" style="color: #059669; font-size: 18px;"></i>
                            <div style="font-size: 12px; color: #065F46; line-height: 1.35;">
                                <strong>Earn 5% Cashback in Upchar Wallet Points</strong><br/>
                                Credited upon booking completion for extra savings on future services.
                            </div>
                        </div>

                        <?php if ($savings > 0): ?>
                            <div class="savings-banner" id="checkoutSavingsBanner">
                                <i class="fas fa-tags"></i> You are saving <strong>₹<?=number_format($savings);?></strong> on this booking!
                            </div>
                        <?php endif; ?>

                        <!-- Confirm CTA -->
                        <button type="submit" class="btn-confirm-checkout" id="btnPlaceOrder">
                            <i class="fas fa-lock"></i> Confirm Booking Now <i class="fas fa-arrow-right"></i>
                        </button>

                        <div style="font-size: 11px; text-align: center; color: #64748B; margin-top: 10px;">
                            By clicking Confirm Booking, you agree to Upchar Terms &amp; Medical Conditions.
                        </div>

                        <!-- Security & Verification Badges -->
                        <div class="security-assurance-list">
                            <div>
                                <i class="fas fa-check-circle"></i> 100% Free Sample Pickup by DMLT Specialists
                            </div>
                            <div>
                                <i class="fas fa-check-circle"></i> Digital Reports on WhatsApp, SMS &amp; Email
                            </div>
                            <div>
                                <i class="fas fa-check-circle"></i> Zero Cancellation Charges before sample collection
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>

        <script>
        // Switch between Patient profiles (Myself, Dependents, or Other)
        function fillPatientData(name, age, gender, mobile, email, btn) {
            $('.patient-pill-btn').removeClass('active');
            $(btn).addClass('active');

            $('#inputPatientName').val(name);
            $('#inputPatientAge').val(age);
            $('#selectPatientGender').val(gender);
            $('#inputPatientMobile').val(mobile);
            $('#inputPatientEmail').val(email);
        }

        function clearPatientData(btn) {
            $('.patient-pill-btn').removeClass('active');
            $(btn).addClass('active');

            $('#inputPatientName').val('').focus();
            $('#inputPatientAge').val('');
            $('#selectPatientGender').val('Male');
            $('#inputPatientMobile').val('');
            $('#inputPatientEmail').val('');
        }

        // Toggle Collection Type (Doorstep vs Lab Visit)
        function toggleVisitType(val) {
            if (val === 'HOME_COLLECTION') {
                $('#choiceHomeCollection').addClass('selected');
                $('#choiceLabVisit').removeClass('selected');
                $('#homeAddressContainer').slideDown(200);
                $('#patientAddressInput').prop('required', true);
            } else {
                $('#choiceLabVisit').addClass('selected');
                $('#choiceHomeCollection').removeClass('selected');
                $('#homeAddressContainer').slideUp(200);
                $('#patientAddressInput').prop('required', false);
            }
        }

        // Toggle Payment Mode Card Highlighting
        function togglePaymentMode(val) {
            $('#payMethodCOD, #payMethodUPI, #payMethodCard').removeClass('selected');
            if (val === 'COD') {
                $('#payMethodCOD').addClass('selected');
            } else if (val === 'ONLINE_UPI') {
                $('#payMethodUPI').addClass('selected');
            } else if (val === 'ONLINE_CARD') {
                $('#payMethodCard').addClass('selected');
            }
        }

        // Quick Date Chips Selector
        function setDateValue(dateVal, chip) {
            $('.date-chip').removeClass('active');
            $(chip).addClass('active');
            $('#bookingDateInput').val(dateVal);
        }

        $('#bookingDateInput').on('change', function() {
            var selectedDate = $(this).val();
            $('.date-chip').removeClass('active');
        });

        // Clear Entire Cart
        function clearCheckoutCart() {
            if (confirm('Are you sure you want to remove all tests from your diagnostic booking?')) {
                $.post('<?=base_url("mytest/clear_cart");?>', function() {
                    window.location.reload();
                });
            }
        }

        // AJAX Remove Single Cart Item with Smooth UI Transition
        $(document).on('click', '.btn-remove-checkout-item', function(e) {
            e.preventDefault();
            var btn = $(this);
            var testId = btn.data('test-id');
            var row = $('#checkoutItem_' + testId);

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin" style="font-size: 11px;"></i>');

            $.post('<?=base_url("mytest/remove_from_cart");?>', { test_id: testId }, function(res) {
                if (res.status === 'success') {
                    row.fadeOut(250, function() {
                        $(this).remove();
                        if (res.cart_count > 0) {
                            $('#checkoutCartCount').text(res.cart_count);
                            $('#checkoutTotalMrp').text('₹' + Number(res.total_mrp).toLocaleString());
                            $('#checkoutSavings').text('- ₹' + Number(res.savings).toLocaleString());
                            $('#checkoutFinalTotal').text('₹' + Number(res.subtotal).toLocaleString());

                            if (res.savings > 0) {
                                $('#checkoutSavingsBanner').html('<i class="fas fa-tags"></i> You are saving <strong>₹' + Number(res.savings).toLocaleString() + '</strong> on this booking!').show();
                            } else {
                                $('#checkoutSavingsBanner').hide();
                            }
                        } else {
                            window.location.reload();
                        }
                    });
                } else {
                    window.location.href = '<?=base_url("mytest/checkout?remove=");?>' + testId;
                }
            }, 'json').fail(function() {
                window.location.href = '<?=base_url("mytest/checkout?remove=");?>' + testId;
            });
        });

        // Coupon handling
        let labGrossTotal = <?=json_encode($final_total);?>;
        let labCouponDiscount = 0;

        window.quickApplyLabCoupon = function(code) {
            $('#labCouponInput').val(code);
            $('#btnApplyLabCoupon').trigger('click');
        };

        $('#btnApplyLabCoupon').click(function() {
            const code = $('#labCouponInput').val().trim();
            const fb = $('#labCouponFeedback');
            if (!code) {
                fb.css('color', '#EF4444').text('Please enter a coupon code.').show();
                return;
            }

            const btn = $(this);
            btn.prop('disabled', true).text('Applying...');

            $.ajax({
                url: '<?=base_url("coupon/apply");?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    coupon_code: code,
                    service_type: 'LAB_TEST',
                    amount: labGrossTotal,
                    "<?=$this->security->get_csrf_token_name();?>": "<?=$this->security->get_csrf_hash();?>"
                },
                success: function(resp) {
                    btn.prop('disabled', false).text('Apply');
                    if (resp.status === 'success') {
                        labCouponDiscount = parseFloat(resp.discount_amount) || 0;
                        const newTotal = Math.max(0, labGrossTotal - labCouponDiscount);

                        $('#labAppliedBadge').show();
                        $('#btnRemoveLabCoupon').show();
                        $('#labCouponInput').prop('readonly', true);
                        $('#labCouponCodeLabel').text(resp.coupon_code);
                        $('#labCouponDiscountAmount').text('- ₹' + labCouponDiscount.toLocaleString());
                        $('#labCouponDiscountRow').show();
                        $('#checkoutFinalTotal').text('₹' + newTotal.toLocaleString());
                        fb.css('color', '#16A34A').text(resp.message).show();
                    } else {
                        fb.css('color', '#EF4444').text(resp.message || 'Invalid coupon code.').show();
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Apply');
                    let errText = 'Error validating coupon. Please try again.';
                    try {
                        const parsed = JSON.parse(xhr.responseText);
                        if (parsed && parsed.message) errText = parsed.message;
                    } catch(e) {}
                    fb.css('color', '#EF4444').text(errText).show();
                }
            });
        });

        $('#btnRemoveLabCoupon').click(function() {
            $.post('<?=base_url("coupon/remove");?>', function() {
                labCouponDiscount = 0;
                $('#labCouponInput').prop('readonly', false).val('');
                $('#labAppliedBadge').hide();
                $('#btnRemoveLabCoupon').hide();
                $('#labCouponDiscountRow').hide();
                $('#labCouponFeedback').hide();
                $('#checkoutFinalTotal').text('₹' + labGrossTotal.toLocaleString());
            });
        });

        // Form Submit Loading State
        $('#checkoutForm').on('submit', function() {
            var btn = $('#btnPlaceOrder');
            btn.prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin"></i> Processing Your Booking...');
        });
        </script>

        <?php endif; ?>

    </div>
</section>

<?php include ('includes/footer.php'); ?>
