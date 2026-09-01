<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$user_name     = isset($user_data['NAME']) && !empty($user_data['NAME']) ? $user_data['NAME'] : ($this->session->userdata('username') ?: 'Valued Patient');
$user_mobile   = isset($user_data['MOBILE']) ? $user_data['MOBILE'] : ($this->session->userdata('mobile') ?: '');
$user_email    = isset($user_data['EMAIL']) ? $user_data['EMAIL'] : ($this->session->userdata('email') ?: '');
$points_bal    = isset($wallet['points_balance']) ? floatval($wallet['points_balance']) : 0.00;
$currency_val  = isset($wallet['currency_equivalent']) ? floatval($wallet['currency_equivalent']) : ($points_bal * ($point_ratio ?? 1.00));
$appt_count    = is_array($appointments_data) ? count($appointments_data) : 0;
$lab_count     = is_array($lab_bookings) ? count($lab_bookings) : 0;
$ref_code      = isset($referral_code) ? $referral_code : 'UPCH-PATIENT-50';
?>

<style>
:root {
    --primary-teal: #0d7a6e;
    --primary-teal-light: #14b8a6;
    --primary-teal-dark: #064e3b;
    --accent-gold: #f59e0b;
    --accent-gold-light: #fef3c7;
    --bg-surface: #ffffff;
    --bg-subtle: #f8fafc;
    --text-main: #0f172a;
    --text-muted: #64748b;
    --border-color: #e2e8f0;
    --radius-xl: 18px;
    --radius-lg: 14px;
    --radius-md: 10px;
    --shadow-soft: 0 4px 20px -2px rgba(13, 122, 110, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.04);
    --shadow-hover: 0 12px 30px -4px rgba(13, 122, 110, 0.12), 0 4px 10px -2px rgba(0, 0, 0, 0.06);
}

.patient-dashboard-container {
    max-width: 1180px;
    margin: 0 auto;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Patient Hero Card */
.patient-hero-banner {
    background: linear-gradient(135deg, #0d7a6e 0%, #064e3b 100%);
    border-radius: var(--radius-xl);
    padding: 28px 32px;
    color: #ffffff;
    margin-bottom: 25px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 35px -10px rgba(13, 122, 110, 0.35);
}

.patient-hero-banner::after {
    content: '';
    position: absolute;
    top: -40%;
    right: -10%;
    width: 320px;
    height: 320px;
    background: radial-gradient(circle, rgba(20, 184, 166, 0.25) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.hero-main-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    position: relative;
    z-index: 1;
}

.hero-user-profile {
    display: flex;
    align-items: center;
    gap: 18px;
}

.hero-avatar {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2dd4bf 0%, #0f766e 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 800;
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
}

.hero-user-details h1 {
    font-size: 24px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.hero-user-details p {
    font-size: 13.5px;
    color: #ccfbf1;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.badge-verified-patient {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.35);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.hero-actions-wrap {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-hero-action {
    background: #ffffff;
    color: var(--primary-teal-dark) !important;
    padding: 11px 20px;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 13.5px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    border: none;
}

.btn-hero-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    background: #f0fdfa;
}

.btn-hero-outline {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff !important;
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 11px 18px;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 13.5px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.btn-hero-outline:hover {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
}

/* Quick Stats Bar */
.stats-overview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 16px;
    margin-bottom: 25px;
}

.stat-kpi-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 20px;
    box-shadow: var(--shadow-soft);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
}

.stat-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    border-color: var(--primary-teal-light);
}

.stat-kpi-info .kpi-lbl {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted);
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.stat-kpi-info .kpi-val {
    font-size: 26px;
    font-weight: 800;
    color: var(--text-main);
    line-height: 1.2;
}

.stat-kpi-info .kpi-sub {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 4px;
}

.stat-kpi-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

/* Navigation Tabs */
.dashboard-tabs-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 22px;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 12px;
    overflow-x: auto;
}

.dash-tab-btn {
    padding: 10px 22px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    color: var(--text-muted);
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    cursor: pointer;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.dash-tab-btn:hover {
    color: var(--primary-teal);
    background: #f0fdfa;
    border-color: var(--primary-teal-light);
}

.dash-tab-btn.active {
    background: var(--primary-teal);
    color: #ffffff !important;
    border-color: var(--primary-teal);
    box-shadow: 0 4px 12px rgba(13, 122, 110, 0.25);
}

/* Appointment Cards */
.appt-item-card {
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 22px;
    margin-bottom: 18px;
    box-shadow: var(--shadow-soft);
    transition: all 0.2s ease;
}

.appt-item-card:hover {
    box-shadow: var(--shadow-hover);
    border-color: var(--primary-teal-light);
}

.appt-item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 14px;
    margin-bottom: 16px;
}

.appt-ref-tag {
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    color: var(--primary-teal);
    font-size: 12.5px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 8px;
}

.appt-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 18px;
}

.appt-info-cell .info-label {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 4px;
}

.appt-info-cell .info-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-main);
    display: flex;
    align-items: center;
    gap: 6px;
}

.appt-actions-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    background: #f8fafc;
    border-radius: var(--radius-md);
    padding: 12px 16px;
}

.badge-appt {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-appt-paid { background: #dcfce7; color: #15803d; }
.badge-appt-unpaid { background: #fef3c7; color: #b45309; }
.badge-appt-confirmed { background: #e0f2fe; color: #0369a1; }
.badge-appt-cancelled { background: #fee2e2; color: #b91c1c; }

.btn-appt-video {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #ffffff !important;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
    transition: all 0.2s;
}

.btn-appt-pay {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff !important;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
}

.btn-appt-cancel {
    background: #ffffff;
    color: #dc2626;
    border: 1px solid #fecaca;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-appt-cancel:hover {
    background: #fee2e2;
}

/* Empty State */
.empty-dash-box {
    background: var(--bg-surface);
    border: 2px dashed var(--border-color);
    border-radius: var(--radius-xl);
    padding: 50px 20px;
    text-align: center;
    margin: 20px 0;
}

.empty-dash-icon {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 12px;
}

/* Wallet Box Styling in Tab */
.wallet-tab-card {
    background: #ffffff;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    padding: 24px;
    margin-bottom: 22px;
    box-shadow: var(--shadow-soft);
}

.quick-chip {
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    color: var(--primary-teal);
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13.5px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
}

.quick-chip:hover {
    background: var(--primary-teal);
    color: #ffffff;
}
</style>

<div class="patient-dashboard-container">

    <!-- 1. Patient Hero Banner -->
    <div class="patient-hero-banner">
        <div class="hero-main-flex">
            <div class="hero-user-profile">
                <div class="hero-avatar">
                    <?=strtoupper(substr($user_name, 0, 1));?>
                </div>
                <div class="hero-user-details">
                    <h1>
                        <?=html_escape($user_name);?>
                        <span class="badge-verified-patient"><i class="fa fa-shield"></i> Verified Patient</span>
                    </h1>
                    <p>
                        <span><i class="fa fa-phone"></i> <?=$user_mobile ?: 'Mobile N/A';?></span>
                        <span><i class="fa fa-envelope-o"></i> <?=$user_email ?: 'Email N/A';?></span>
                    </p>
                </div>
            </div>

            <div class="hero-actions-wrap">
                <a href="<?=base_url('doctors');?>" class="btn-hero-action">
                    <i class="fa fa-plus-circle" style="color: var(--primary-teal);"></i> Book Doctor
                </a>
                <a href="<?=base_url('mytest');?>" class="btn-hero-action">
                    <i class="fa fa-flask" style="color: #2563eb;"></i> Book Lab Test
                </a>
                <a href="<?=base_url('wallet');?>" class="btn-hero-outline">
                    <i class="fa fa-google-wallet" style="color: #fde68a;"></i> Wallet (<?=$points_bal;?> Pts)
                </a>
            </div>
        </div>
    </div>

    <!-- 2. KPI Summary Cards -->
    <div class="stats-overview-grid">
        <!-- Upchar Points Wallet -->
        <div class="stat-kpi-card" onclick="switchDashboardTab('wallet')" style="cursor: pointer;">
            <div class="stat-kpi-info">
                <div class="kpi-lbl">Upchar Points Wallet</div>
                <div class="kpi-val" style="color: #d97706;"><?=number_format($points_bal, 0);?> <small style="font-size: 14px;">Pts</small></div>
                <div class="kpi-sub">≈ ₹<?=number_format($currency_val, 2);?> Available Balance</div>
            </div>
            <div class="stat-kpi-icon" style="background: #fef3c7; color: #d97706;">
                <i class="fa fa-google-wallet"></i>
            </div>
        </div>

        <!-- Appointments -->
        <div class="stat-kpi-card" onclick="switchDashboardTab('appointments')" style="cursor: pointer;">
            <div class="stat-kpi-info">
                <div class="kpi-lbl">Doctor Consultations</div>
                <div class="kpi-val" style="color: var(--primary-teal);"><?=$appt_count;?></div>
                <div class="kpi-sub">In-Clinic &amp; Video Appointments</div>
            </div>
            <div class="stat-kpi-icon" style="background: #e6fffa; color: var(--primary-teal);">
                <i class="fa fa-calendar-check-o"></i>
            </div>
        </div>

        <!-- Lab Orders -->
        <div class="stat-kpi-card" onclick="switchDashboardTab('diagnostics')" style="cursor: pointer;">
            <div class="stat-kpi-info">
                <div class="kpi-lbl">Diagnostic Lab Orders</div>
                <div class="kpi-val" style="color: #2563eb;"><?=$lab_count;?></div>
                <div class="kpi-sub">Blood Tests &amp; Health Packages</div>
            </div>
            <div class="stat-kpi-icon" style="background: #eff6ff; color: #2563eb;">
                <i class="fa fa-flask"></i>
            </div>
        </div>

        <!-- Refer & Earn -->
        <div class="stat-kpi-card">
            <div class="stat-kpi-info">
                <div class="kpi-lbl">Refer &amp; Earn Bonus</div>
                <div class="kpi-val" style="font-size: 18px; color: #7c3aed;">
                    <code><?=$ref_code;?></code>
                </div>
                <div class="kpi-sub">
                    <a href="https://api.whatsapp.com/send?text=Join%20UPCHAR%20Healthcare%20using%20my%20code%20<?=$ref_code;?>%20for%20free%20rewards!%20<?=urlencode(base_url('sign_up?ref='.$ref_code));?>" target="_blank" style="color: #25d366; font-weight: 700; text-decoration: none;">
                        <i class="fa fa-whatsapp"></i> Share on WhatsApp
                    </a>
                </div>
            </div>
            <div class="stat-kpi-icon" style="background: #f3e8ff; color: #7c3aed;">
                <i class="fa fa-gift"></i>
            </div>
        </div>
    </div>

    <!-- 3. Navigation Tabs -->
    <div class="dashboard-tabs-bar">
        <button type="button" class="dash-tab-btn active" id="tabBtn-appointments" onclick="switchDashboardTab('appointments')">
            <i class="fa fa-calendar"></i> Doctor Consultations (<?=$appt_count;?>)
        </button>
        <button type="button" class="dash-tab-btn" id="tabBtn-wallet" onclick="switchDashboardTab('wallet')">
            <i class="fa fa-google-wallet"></i> Upchar Wallet &amp; Rewards
        </button>
        <button type="button" class="dash-tab-btn" id="tabBtn-diagnostics" onclick="switchDashboardTab('diagnostics')">
            <i class="fa fa-flask"></i> Diagnostics &amp; Lab Orders (<?=$lab_count;?>)
        </button>
        <button type="button" class="dash-tab-btn" id="tabBtn-payments" onclick="switchDashboardTab('payments')">
            <i class="fa fa-credit-card"></i> Invoices &amp; Payment Receipts
        </button>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: DOCTOR CONSULTATIONS               -->
    <!-- ========================================== -->
    <div id="section-appointments">
        <?php if (!empty($appointments_data)): ?>
            <?php foreach ($appointments_data as $p): ?>
                <?php
                    $appt_id    = isset($p->appointment_id) ? $p->appointment_id : 'N/A';
                    $appt_date  = !empty($p->appointment_date) ? date('d M Y', strtotime($p->appointment_date)) : 'Date N/A';
                    $timing     = (!empty($p->from_timing) && !empty($p->to_timing)) ? html_escape($p->from_timing . ' - ' . $p->to_timing) : 'Scheduled';
                    $patient    = isset($p->patient_name) && !empty($p->patient_name) ? $p->patient_name : 'Patient';
                    $doctor     = isset($p->doctor_name) && !empty($p->doctor_name) ? $p->doctor_name : 'Medical Doctor';
                    $institute  = isset($p->institute_name) && !empty($p->institute_name) ? $p->institute_name : 'Healthcare Clinic';
                    $mobile     = isset($p->appointment_mobile) ? $p->appointment_mobile : 'N/A';
                    $amount     = isset($p->amount) && $p->amount > 0 ? $p->amount : (isset($p->fee) ? $p->fee : 500);
                    $pay_status = isset($p->payment_status) ? strtoupper($p->payment_status) : 'UNPAID';
                    $is_paid    = ($pay_status == 'PAID' || $pay_status == 'DONE');
                    $is_video   = (!empty($p->room_id) || (isset($p->appointment_type) && $p->appointment_type == 'video'));
                ?>

                <div class="appt-item-card">
                    <div class="appt-item-header">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="appt-ref-tag">#APPT-<?=$appt_id;?></span>
                            <span style="font-weight: 700; font-size: 14px; color: var(--text-main);">
                                <i class="fa fa-calendar" style="color: var(--primary-teal); margin-right: 4px;"></i>
                                <?=$appt_date;?> &nbsp;|&nbsp; 
                                <i class="fa fa-clock-o" style="color: var(--primary-teal); margin-right: 2px;"></i>
                                <?=$timing;?>
                            </span>
                        </div>

                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="badge-appt badge-appt-confirmed">
                                <i class="fa fa-check-circle"></i> Confirmed
                            </span>
                            <span class="badge-appt <?=$is_paid ? 'badge-appt-paid' : 'badge-appt-unpaid';?>">
                                <i class="fa fa-credit-card"></i> <?=$is_paid ? 'Paid' : 'Payment Pending';?>
                            </span>
                        </div>
                    </div>

                    <div class="appt-details-grid">
                        <div class="appt-info-cell">
                            <div class="info-label">Doctor / Specialist</div>
                            <div class="info-value">
                                <i class="fa fa-user-md" style="color: var(--primary-teal);"></i>
                                <?=html_escape($doctor);?>
                            </div>
                        </div>

                        <div class="appt-info-cell">
                            <div class="info-label">Consultation Mode</div>
                            <div class="info-value">
                                <?php if ($is_video): ?>
                                    <i class="fa fa-video-camera" style="color: #2563eb;"></i>
                                    <span style="color: #2563eb;">Online Video Call</span>
                                <?php else: ?>
                                    <i class="fa fa-hospital-o" style="color: var(--primary-teal);"></i>
                                    <span><?=html_escape($institute);?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="appt-info-cell">
                            <div class="info-label">Patient Name</div>
                            <div class="info-value">
                                <i class="fa fa-user" style="color: var(--text-muted);"></i>
                                <?=html_escape($patient);?>
                            </div>
                        </div>

                        <div class="appt-info-cell">
                            <div class="info-label">Consultation Fee</div>
                            <div class="info-value" style="color: var(--primary-teal); font-size: 16px;">
                                ₹<?=number_format($amount, 2);?>
                            </div>
                        </div>
                    </div>

                    <div class="appt-actions-footer">
                        <div style="font-size: 13px; color: var(--text-muted);">
                            <?php if ($is_paid): ?>
                                <span style="color: #16a34a; font-weight: 600;"><i class="fa fa-shield"></i> Payment Secured via UPCHAR Gateway</span>
                            <?php else: ?>
                                <span style="color: #d97706; font-weight: 600;"><i class="fa fa-info-circle"></i> Pay online using Points or Gateway</span>
                            <?php endif; ?>
                        </div>

                        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <?php if ($is_video): ?>
                                <a href="<?=base_url('videocall/'.($p->room_id ?: 'upchar_consult_'.$appt_id));?>" target="_blank" class="btn-appt-video">
                                    <i class="fa fa-video-camera"></i> Launch Video Room
                                </a>
                            <?php endif; ?>

                            <?php if (!$is_paid): ?>
                                <a href="<?=base_url('payment/checkout?purpose=APPOINTMENT&reference_id='.$appt_id.'&amount='.$amount.'&item_name='.urlencode('Consultation with '.$doctor));?>" class="btn-appt-pay">
                                    <i class="fa fa-bolt"></i> Pay ₹<?=number_format($amount, 2);?> Now
                                </a>
                            <?php else: ?>
                                <button type="button" class="btn-appt-cancel" onclick="cancelAppointment('<?=$appt_id;?>', '<?=$p->appointment_date;?>')">
                                    <i class="fa fa-times"></i> Cancel &amp; Refund
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-dash-box">
                <div class="empty-dash-icon"><i class="fa fa-calendar-plus-o"></i></div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-main); margin: 0 0 6px 0;">No Upcoming Consultations</h3>
                <p style="color: var(--text-muted); font-size: 14px; margin: 0 0 20px 0;">Book your first doctor appointment or teleconsultation with verified specialists.</p>
                <a href="<?=base_url('doctors');?>" class="btn-hero-action" style="background: var(--primary-teal); color: #ffffff !important;">
                    <i class="fa fa-stethoscope"></i> Find &amp; Book Doctor
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- ========================================== -->
    <!-- TAB 2: WALLET & REWARDS                    -->
    <!-- ========================================== -->
    <div id="section-wallet" style="display: none;">
        <div class="wallet-tab-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 18px; margin-bottom: 20px;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 800; color: var(--text-main); margin: 0 0 4px 0;">
                        <i class="fa fa-google-wallet" style="color: #f59e0b;"></i> Upchar Points Balance &amp; Rewards
                    </h3>
                    <p style="color: var(--text-muted); font-size: 13.5px; margin: 0;">
                        1 Upchar Point = ₹<?=number_format($point_ratio ?? 1.00, 2);?> | Earn <?=$cashback_pct;?>% Cashback on all bookings
                    </p>
                </div>

                <div>
                    <a href="<?=base_url('wallet');?>" class="btn-hero-action" style="background: var(--primary-teal); color: #ffffff !important;">
                        <i class="fa fa-plus"></i> Recharge Wallet
                    </a>
                </div>
            </div>

            <!-- Quick Add Money -->
            <div style="background: #f8fafc; border-radius: var(--radius-md); padding: 18px; margin-bottom: 24px;">
                <div style="font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 10px; text-transform: uppercase;">
                    Quick Wallet Recharge Amounts
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="<?=base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=TOPUP-100&amount=100');?>" class="quick-chip">+ ₹100</a>
                    <a href="<?=base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=TOPUP-250&amount=250');?>" class="quick-chip">+ ₹250</a>
                    <a href="<?=base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=TOPUP-500&amount=500');?>" class="quick-chip">+ ₹500</a>
                    <a href="<?=base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=TOPUP-1000&amount=1000');?>" class="quick-chip">+ ₹1,000</a>
                </div>
            </div>

            <!-- Mini Ledger Statement -->
            <h4 style="font-size: 15px; font-weight: 800; color: var(--text-main); margin-bottom: 14px;">Recent Points Activity</h4>
            <div style="overflow-x: auto;">
                <table class="table table-hover" style="font-size: 13.5px;">
                    <thead>
                        <tr style="color: var(--text-muted);">
                            <th>Txn Ref</th>
                            <th>Description</th>
                            <th>Points</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($wallet_history)): ?>
                            <?php foreach ($wallet_history as $wh): ?>
                            <tr>
                                <td><code><?=$wh['txn_ref'];?></code></td>
                                <td><?=htmlspecialchars($wh['description']);?></td>
                                <td style="font-weight: 700; color: <?=($wh['type'] === 'CREDIT') ? '#16a34a' : '#dc2626';?>;">
                                    <?=($wh['type'] === 'CREDIT') ? '+' : '-';?><?=$wh['amount_points'];?> Pts
                                </td>
                                <td>
                                    <span class="badge" style="background: <?=($wh['type'] === 'CREDIT') ? '#dcfce7' : '#fee2e2';?>; color: <?=($wh['type'] === 'CREDIT') ? '#15803d' : '#b91c1c';?>;">
                                        <?=$wh['type'];?>
                                    </span>
                                </td>
                                <td style="color: var(--text-muted);"><?=date('d M Y, h:i A', strtotime($wh['created_at']));?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 25px; color: var(--text-muted);">No wallet activity yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 3: DIAGNOSTICS & LAB ORDERS            -->
    <!-- ========================================== -->
    <div id="section-diagnostics" style="display: none;">
        <?php if (!empty($lab_bookings)): ?>
            <?php foreach ($lab_bookings as $lb): ?>
                <div class="appt-item-card">
                    <div class="appt-item-header">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="appt-ref-tag" style="background: #eff6ff; color: #2563eb; border-color: #bfdbfe;">
                                #LAB-<?=$lb['booking_id'];?>
                            </span>
                            <span style="font-weight: 700; font-size: 14px;">
                                <i class="fa fa-calendar" style="color: #2563eb; margin-right: 4px;"></i>
                                <?=date('d M Y', strtotime($lb['book_date']));?>
                            </span>
                        </div>
                        <div>
                            <span class="badge-appt badge-appt-confirmed">
                                <i class="fa fa-flask"></i> <?=htmlspecialchars($lb['status'] ?? 'CONFIRMED');?>
                            </span>
                        </div>
                    </div>

                    <div class="appt-details-grid">
                        <div class="appt-info-cell">
                            <div class="info-label">Patient Name</div>
                            <div class="info-value"><?=htmlspecialchars($lb['patient_name'] ?? $user_name);?></div>
                        </div>
                        <div class="appt-info-cell">
                            <div class="info-label">Total Amount</div>
                            <div class="info-value" style="color: #0d7a6e;">₹<?=number_format($lb['total_amount'] ?? 0, 2);?></div>
                        </div>
                        <div class="appt-info-cell">
                            <div class="info-label">Sample Status</div>
                            <div class="info-value"><?=htmlspecialchars($lb['sample_status'] ?? 'Scheduled');?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-dash-box">
                <div class="empty-dash-icon"><i class="fa fa-flask"></i></div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-main); margin: 0 0 6px 0;">No Lab Bookings Recorded</h3>
                <p style="color: var(--text-muted); font-size: 14px; margin: 0 0 20px 0;">Order blood tests, full body health checks, and diagnostic investigations online.</p>
                <a href="<?=base_url('mytest');?>" class="btn-hero-action" style="background: #2563eb; color: #ffffff !important;">
                    <i class="fa fa-flask"></i> Explore Diagnostic Catalog
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- ========================================== -->
    <!-- TAB 4: PAYMENTS & RECEIPTS                 -->
    <!-- ========================================== -->
    <div id="section-payments" style="display: none;">
        <div class="wallet-tab-card">
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text-main); margin: 0 0 16px 0;">
                <i class="fa fa-file-text-o" style="color: var(--primary-teal);"></i> Online Payment History &amp; Receipts
            </h3>

            <div style="overflow-x: auto;">
                <table class="table table-hover" style="font-size: 13.5px;">
                    <thead>
                        <tr style="color: var(--text-muted);">
                            <th>Order Ref</th>
                            <th>Purpose</th>
                            <th>Amount (INR)</th>
                            <th>Points Used</th>
                            <th>Gateway Txn ID</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payments_data)): ?>
                            <?php foreach ($payments_data as $pd): ?>
                            <tr>
                                <td><code><?=$pd['internal_order_ref'];?></code></td>
                                <td><span class="label label-info"><?=$pd['purpose'];?></span></td>
                                <td style="font-weight: 700;">₹<?=number_format($pd['amount'], 2);?></td>
                                <td><?=number_format($pd['wallet_points_used'], 0);?> Pts</td>
                                <td><small><?=$pd['razorpay_payment_id'] ?: '-';?></small></td>
                                <td>
                                    <span class="badge" style="background: <?=($pd['status'] === 'PAID') ? '#dcfce7' : '#fef3c7';?>; color: <?=($pd['status'] === 'PAID') ? '#15803d' : '#b45309';?>;">
                                        <?=$pd['status'];?>
                                    </span>
                                </td>
                                <td style="color: var(--text-muted);"><?=date('d M Y, h:i A', strtotime($pd['created_at']));?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">No online payment records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
    <!-- SPONSORED HEALTHCARE DEALS & PARTNER SHOWCASE -->
    <?php if (!empty($sponsored_ads)): ?>
    <div style="background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--border-color); padding: 24px; margin-top: 25px; box-shadow: var(--shadow-soft);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 8px;">
            <div>
                <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                    <i class="fa fa-bullhorn"></i> Verified Medical Partner Offers
                </span>
                <h4 style="margin: 6px 0 0; font-size: 17px; font-weight: 800; color: var(--text-main);">
                    Special Sponsored Healthcare Discounts &amp; Deals
                </h4>
            </div>
            <a href="<?=base_url();?>#sponsoredShowcaseSection" target="_blank" style="font-size: 12.5px; color: var(--primary-teal); font-weight: 700; text-decoration: none;">
                View All Offers &rarr;
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
            <?php foreach (array_slice($sponsored_ads, 0, 3) as $ad): 
                $imgSrc = filter_var($ad->image, FILTER_VALIDATE_URL) ? $ad->image : (base_url('public/assets/upload/' . $ad->image));
                $adUrl  = base_url('home/ad_click/' . $ad->id);
            ?>
            <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                <div style="position: relative; height: 120px; overflow: hidden;">
                    <img src="<?=$imgSrc;?>" alt="<?=html_escape($ad->title);?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400';">
                    <span style="position: absolute; top: 8px; left: 8px; background: rgba(15, 23, 42, 0.85); color: #2dd4bf; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 12px;">
                        <?=html_escape($ad->sponsor_badge ?: 'Sponsored Partner');?>
                    </span>
                </div>
                <div style="padding: 14px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <strong style="font-size: 14px; color: var(--text-main); display: block; margin-bottom: 4px; line-height: 1.3;">
                            <?=html_escape($ad->title ?: $ad->short_description);?>
                        </strong>
                        <p style="font-size: 12px; color: var(--text-muted); margin: 0 0 10px; line-height: 1.4;">
                            <?=html_escape($ad->short_description);?>
                        </p>
                    </div>
                    <div style="border-top: 1px solid #e2e8f0; padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 11px; color: #16a34a; font-weight: 700;"><i class="fa fa-tag"></i> Partner Offer</span>
                        <a href="<?=$adUrl;?>" target="_blank" class="btn btn-xs" style="background: var(--primary-teal); color: #ffffff; font-weight: 700; border-radius: 6px; padding: 5px 12px;">
                            Claim Offer &rarr;
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
function switchDashboardTab(tab) {
    const tabs = ['appointments', 'wallet', 'diagnostics', 'payments'];
    tabs.forEach(t => {
        const sec = document.getElementById('section-' + t);
        const btn = document.getElementById('tabBtn-' + t);
        if (sec) sec.style.display = (t === tab) ? 'block' : 'none';
        if (btn) {
            if (t === tab) btn.classList.add('active');
            else btn.classList.remove('active');
        }
    });
}

function cancelAppointment(apptId, apptDate) {
    if (!confirm('Are you sure you want to cancel appointment #' + apptId + '? Any refund will be credited instantly to your Upchar Wallet as per cancellation policy.')) {
        return;
    }

    const formData = new FormData();
    formData.append('order_ref', 'APPT-' + apptId);
    formData.append('refund_to', 'WALLET');
    formData.append('reason', 'Patient requested cancellation');

    fetch('<?=base_url("refund/initiate");?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || 'Appointment cancellation initiated.');
        window.location.reload();
    })
    .catch(err => {
        alert('Cancellation submitted.');
        window.location.reload();
    });
}

// Support direct tab links e.g. #tab_wallet
$(document).ready(function() {
    if (window.location.hash === '#wallet') {
        switchDashboardTab('wallet');
    } else if (window.location.hash === '#diagnostics') {
        switchDashboardTab('diagnostics');
    } else if (window.location.hash === '#payments') {
        switchDashboardTab('payments');
    }
});
</script>
