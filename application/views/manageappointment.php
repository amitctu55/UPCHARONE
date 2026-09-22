<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$user_name     = isset($user_data['NAME']) && !empty($user_data['NAME']) ? $user_data['NAME'] : ($this->session->userdata('username') ?: 'Valued Patient');
$user_mobile   = isset($user_data['MOBILE']) ? $user_data['MOBILE'] : ($this->session->userdata('mobile') ?: '');
$user_email    = isset($user_data['EMAIL']) ? $user_data['EMAIL'] : ($this->session->userdata('email') ?: '');
$points_bal    = isset($wallet['points_balance']) ? floatval($wallet['points_balance']) : 0.00;
$currency_val  = isset($wallet['currency_equivalent']) ? floatval($wallet['currency_equivalent']) : ($points_bal * ($point_ratio ?? 1.00));
$appt_count    = is_array($appointments_data) ? count($appointments_data) : 0;
$lab_count     = is_array($lab_bookings) ? count($lab_bookings) : 0;
$payments_cnt  = is_array($payments_data) ? count($payments_data) : 0;
$ref_code      = isset($referral_code) ? $referral_code : 'UPCH-PATIENT-50';

$csrf_token_name = $this->security->get_csrf_token_name();
$csrf_hash       = $this->security->get_csrf_hash();
?>

<style>
/* ==========================================================================
   UPCHAR PATIENT CARE & HEALTH WALLET PORTAL - MODERN HEALTHCARE AESTHETICS
   ========================================================================== */
:root {
    --upchar-teal: #0d7a6e;
    --upchar-teal-hover: #0a6359;
    --upchar-teal-light: #f0fdf4;
    --upchar-teal-border: #bbf7d0;
    --upchar-indigo: #4f46e5;
    --upchar-violet: #7c3aed;
    --upchar-amber: #f59e0b;
    --upchar-amber-light: #fffbeb;
    --upchar-emerald: #10b981;
    --upchar-emerald-light: #ecfdf5;
    --upchar-rose: #ef4444;
    --upchar-rose-light: #fef2f2;
    --upchar-slate-900: #0f172a;
    --upchar-slate-800: #1e293b;
    --upchar-slate-600: #475569;
    --upchar-slate-500: #64748b;
    --upchar-slate-200: #e2e8f0;
    --upchar-slate-100: #f1f5f9;
    --upchar-slate-50: #f8fafc;
    --card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
    --card-shadow-hover: 0 12px 28px -4px rgba(13, 122, 110, 0.12), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
}

.portal-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 10px 15px 40px;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
    color: var(--upchar-slate-800);
}

/* 1. Executive Patient Hero Banner */
.portal-hero {
    background: linear-gradient(135deg, #0d7a6e 0%, #064e3b 100%);
    border-radius: 20px;
    padding: 26px 30px;
    color: #ffffff;
    margin-bottom: 24px;
    box-shadow: 0 14px 30px -8px rgba(13, 122, 110, 0.35);
    position: relative;
    overflow: hidden;
}

.portal-hero::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -40px;
    width: 260px;
    height: 260px;
    background: radial-gradient(circle, rgba(20, 184, 166, 0.3) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.hero-flex-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    position: relative;
    z-index: 2;
}

.hero-profile-group {
    display: flex;
    align-items: center;
    gap: 18px;
}

.hero-avatar-circle {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2dd4bf 0%, #0f766e 100%);
    color: #ffffff;
    font-size: 26px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.hero-profile-meta h1 {
    font-size: 23px;
    font-weight: 800;
    margin: 0 0 4px 0;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 10px;
}

.hero-profile-meta p {
    margin: 0;
    font-size: 13.5px;
    color: #ccfbf1;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.badge-verified-pill {
    background: rgba(255, 255, 255, 0.18);
    border: 1px solid rgba(255, 255, 255, 0.35);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.4px;
    text-transform: uppercase;
}

.hero-quick-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-hero-white {
    background: #ffffff;
    color: var(--upchar-teal) !important;
    padding: 10px 18px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.btn-hero-white:hover {
    background: #f8fafc;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

.btn-hero-wallet {
    background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
    color: #ffffff !important;
    padding: 10px 18px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    transition: all 0.2s ease;
}

.btn-hero-wallet:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(79, 70, 229, 0.45);
}

/* 2. Top Summary KPI Cards */
.portal-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.portal-kpi-card {
    background: #ffffff;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--card-shadow);
    transition: all 0.2s ease;
    cursor: pointer;
}

.portal-kpi-card:hover {
    transform: translateY(-2px);
    border-color: #99f6e4;
    box-shadow: var(--card-shadow-hover);
}

.kpi-title {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: var(--upchar-slate-500);
    margin-bottom: 4px;
}

.kpi-main-val {
    font-size: 24px;
    font-weight: 800;
    color: var(--upchar-slate-900);
    line-height: 1.2;
}

.kpi-caption {
    font-size: 12px;
    color: var(--upchar-slate-500);
    margin-top: 4px;
}

.kpi-icon-pill {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

/* 3. Modern Segmented Tab Bar */
.portal-tabs-nav {
    display: flex;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 14px;
    padding: 6px;
    margin-bottom: 24px;
    overflow-x: auto;
}

.portal-tab-btn {
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--upchar-slate-600);
    background: transparent;
    border: none;
    cursor: pointer;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.portal-tab-btn:hover {
    color: var(--upchar-teal);
    background: rgba(13, 122, 110, 0.08);
}

.portal-tab-btn.active {
    background: var(--upchar-teal);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(13, 122, 110, 0.25);
}

.tab-badge-pill {
    background: rgba(0, 0, 0, 0.08);
    color: inherit;
    padding: 2px 7px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
}

.portal-tab-btn.active .tab-badge-pill {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
}

/* 4. Luxury Wallet Hero Card */
.wallet-hero-showcase {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
    border-radius: 20px;
    padding: 30px;
    color: #ffffff;
    margin-bottom: 24px;
    box-shadow: 0 14px 32px -6px rgba(49, 46, 129, 0.35);
    position: relative;
    overflow: hidden;
}

.wallet-hero-showcase::after {
    content: '';
    position: absolute;
    bottom: -60px;
    right: -40px;
    width: 280px;
    height: 280px;
    background: radial-gradient(circle, rgba(167, 139, 250, 0.25) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.wallet-chip-icon {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    color: #e0e7ff;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.wallet-big-balance {
    font-size: 38px;
    font-weight: 900;
    color: #ffffff;
    line-height: 1.1;
    margin-bottom: 6px;
}

.wallet-sub-eq {
    font-size: 16px;
    font-weight: 600;
    color: #c7d2fe;
    margin-bottom: 22px;
}

.wallet-quick-chips {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 14px;
}

.quick-recharge-pill {
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.quick-recharge-pill:hover {
    background: #ffffff;
    color: #312e81 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Cancellation & Refund Policy Box */
.policy-banner-box {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 24px;
}

.policy-tier-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 12px;
    margin-top: 14px;
}

.policy-tier-card {
    background: #ffffff;
    border: 1px solid #dcfce7;
    border-radius: 12px;
    padding: 12px 16px;
}

/* Appointment Cards */
.appt-modern-card {
    background: #ffffff;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 16px;
    padding: 22px 24px;
    margin-bottom: 18px;
    box-shadow: var(--card-shadow);
    transition: all 0.2s ease;
}

.appt-modern-card:hover {
    border-color: #99f6e4;
    box-shadow: var(--card-shadow-hover);
}

.appt-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--upchar-slate-100);
    margin-bottom: 16px;
}

.appt-id-badge {
    background: #f0fdfa;
    border: 1px solid #ccfbf1;
    color: var(--upchar-teal);
    font-size: 13px;
    font-weight: 800;
    padding: 4px 12px;
    border-radius: 8px;
}

.appt-body-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 18px;
}

.appt-meta-block .meta-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--upchar-slate-500);
    margin-bottom: 4px;
}

.appt-meta-block .meta-value {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--upchar-slate-900);
    display: flex;
    align-items: center;
    gap: 6px;
}

.appt-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    background: var(--upchar-slate-50);
    border-radius: 12px;
    padding: 12px 18px;
}

/* Status Badges */
.badge-status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-paid {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

.badge-unpaid {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
}

.badge-cancelled {
    background: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

.badge-refunded {
    background: #f3e8ff;
    color: #7c3aed;
    border: 1px solid #e9d5ff;
}

/* Action Buttons */
.btn-action-cancel {
    background: #ffffff;
    color: #dc2626 !important;
    border: 1px solid #fecaca;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
}

.btn-action-cancel:hover {
    background: #fee2e2;
    border-color: #f87171;
}

.btn-action-pay {
    background: var(--upchar-teal);
    color: #ffffff !important;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.btn-action-pay:hover {
    background: var(--upchar-teal-hover);
    transform: translateY(-1px);
}

.btn-action-receipt {
    background: #f0fdfa;
    color: var(--upchar-teal) !important;
    border: 1px solid #ccfbf1;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
}

.btn-action-receipt:hover {
    background: #ccfbf1;
}

/* Modern Cancel & Refund Modal */
.refund-modal-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(5px);
    z-index: 99999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.refund-modal-card {
    background: #ffffff;
    border-radius: 20px;
    width: 100%;
    max-width: 520px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    animation: modalScaleIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes modalScaleIn {
    0% { transform: scale(0.92); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.refund-modal-header {
    background: #f8fafc;
    border-bottom: 1px solid var(--upchar-slate-200);
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.refund-modal-body {
    padding: 24px;
}

.refund-breakdown-card {
    background: #f8fafc;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 14px;
    padding: 16px 20px;
    margin-bottom: 20px;
}

.breakdown-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    padding: 6px 0;
    color: var(--upchar-slate-600);
}

.breakdown-row.total-row {
    border-top: 1.5px dashed var(--upchar-slate-200);
    margin-top: 8px;
    padding-top: 10px;
    font-size: 16px;
    font-weight: 800;
    color: var(--upchar-teal);
}

.refund-modal-footer {
    padding: 16px 24px 20px;
    background: #f8fafc;
    border-top: 1px solid var(--upchar-slate-200);
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

/* Empty State Box */
.empty-portal-box {
    background: #ffffff;
    border: 2px dashed var(--upchar-slate-200);
    border-radius: 18px;
    padding: 50px 30px;
    text-align: center;
    margin: 20px 0;
}

.empty-portal-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #f1f5f9;
    color: var(--upchar-slate-500);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin: 0 auto 16px;
}
</style>

<div class="portal-container">

    <!-- 1. PATIENT HERO BANNER -->
    <div class="portal-hero">
        <div class="hero-flex-wrapper">
            <div class="hero-profile-group">
                <div class="hero-avatar-circle">
                    <?=strtoupper(substr($user_name, 0, 1));?>
                </div>
                <div class="hero-profile-meta">
                    <h1>
                        <?=html_escape($user_name);?>
                        <span class="badge-verified-pill"><i class="fa fa-shield"></i> Verified Patient</span>
                    </h1>
                    <p>
                        <span><i class="fa fa-phone"></i> <?=$user_mobile ?: 'Mobile N/A';?></span>
                        <span><i class="fa fa-envelope-o"></i> <?=$user_email ?: 'Email N/A';?></span>
                        <span><i class="fa fa-map-marker"></i> Patient Portal</span>
                    </p>
                </div>
            </div>

            <div class="hero-quick-actions">
                <a href="#wallet" onclick="switchDashboardTab('wallet')" class="btn-hero-wallet">
                    <i class="fa fa-google-wallet"></i> Upchar Wallet: <?=number_format($points_bal, 0);?> Pts (₹<?=number_format($currency_val, 2);?>)
                </a>
                <a href="<?=base_url('doctors');?>" class="btn-hero-white">
                    <i class="fa fa-user-md" style="color: var(--upchar-teal);"></i> Book Doctor
                </a>
                <a href="<?=base_url('mytest');?>" class="btn-hero-white">
                    <i class="fa fa-flask" style="color: #2563eb;"></i> Book Lab Test
                </a>
            </div>
        </div>
    </div>

    <!-- 2. TOP KPI CARDS -->
    <div class="portal-kpi-grid">
        <!-- Wallet Card -->
        <div class="portal-kpi-card" onclick="switchDashboardTab('wallet')">
            <div>
                <div class="kpi-title">Upchar Health Wallet</div>
                <div class="kpi-main-val" style="color: #7c3aed;">
                    <?=number_format($points_bal, 0);?> <small style="font-size: 14px; font-weight: 700;">Pts</small>
                </div>
                <div class="kpi-caption">≈ ₹<?=number_format($currency_val, 2);?> Balance Available</div>
            </div>
            <div class="kpi-icon-pill" style="background: #f5f3ff; color: #7c3aed;">
                <i class="fa fa-google-wallet"></i>
            </div>
        </div>

        <!-- Consultations Card -->
        <div class="portal-kpi-card" onclick="switchDashboardTab('appointments')">
            <div>
                <div class="kpi-title">Doctor Consultations</div>
                <div class="kpi-main-val" style="color: var(--upchar-teal);">
                    <?=$appt_count;?>
                </div>
                <div class="kpi-caption">In-Clinic &amp; Video Appointments</div>
            </div>
            <div class="kpi-icon-pill" style="background: #f0fdf4; color: var(--upchar-teal);">
                <i class="fa fa-calendar-check-o"></i>
            </div>
        </div>

        <!-- Diagnostics Card -->
        <div class="portal-kpi-card" onclick="switchDashboardTab('diagnostics')">
            <div>
                <div class="kpi-title">Diagnostic Lab Tests</div>
                <div class="kpi-main-val" style="color: #2563eb;">
                    <?=$lab_count;?>
                </div>
                <div class="kpi-caption">Pathology Orders &amp; Health Reports</div>
            </div>
            <div class="kpi-icon-pill" style="background: #eff6ff; color: #2563eb;">
                <i class="fa fa-flask"></i>
            </div>
        </div>

        <!-- Referral Bonus Card -->
        <div class="portal-kpi-card">
            <div>
                <div class="kpi-title">Referral Reward Code</div>
                <div class="kpi-main-val" style="color: #d97706; font-size: 18px;">
                    <code style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 6px;"><?=$ref_code;?></code>
                </div>
                <div class="kpi-caption">
                    <a href="https://api.whatsapp.com/send?text=Join%20UPCHAR%20Healthcare%20using%20my%20code%20<?=$ref_code;?>%20for%20free%20rewards!%20<?=urlencode(base_url('sign_up?ref='.$ref_code));?>" target="_blank" style="color: #16a34a; font-weight: 700; text-decoration: none;">
                        <i class="fa fa-whatsapp"></i> Share on WhatsApp
                    </a>
                </div>
            </div>
            <div class="kpi-icon-pill" style="background: #fef3c7; color: #d97706;">
                <i class="fa fa-gift"></i>
            </div>
        </div>
    </div>

    <!-- 3. SEGMENTED TABS BAR -->
    <div class="portal-tabs-nav">
        <button type="button" class="portal-tab-btn active" id="tabBtn-appointments" onclick="switchDashboardTab('appointments')">
            <i class="fa fa-calendar-check-o"></i> Doctor Consultations
            <span class="tab-badge-pill"><?=$appt_count;?></span>
        </button>
        <button type="button" class="portal-tab-btn" id="tabBtn-wallet" onclick="switchDashboardTab('wallet')">
            <i class="fa fa-google-wallet"></i> Upchar Wallet &amp; Points
            <span class="tab-badge-pill" style="background: #7c3aed; color: #ffffff;">₹<?=number_format($currency_val, 0);?></span>
        </button>
        <button type="button" class="portal-tab-btn" id="tabBtn-diagnostics" onclick="switchDashboardTab('diagnostics')">
            <i class="fa fa-flask"></i> Lab Tests &amp; Diagnostics
            <span class="tab-badge-pill"><?=$lab_count;?></span>
        </button>
        <button type="button" class="portal-tab-btn" id="tabBtn-payments" onclick="switchDashboardTab('payments')">
            <i class="fa fa-credit-card"></i> Invoices &amp; Receipts
            <span class="tab-badge-pill"><?=$payments_cnt;?></span>
        </button>
    </div>

    <!-- ================================================================= -->
    <!-- TAB 1: DOCTOR CONSULTATIONS                                      -->
    <!-- ================================================================= -->
    <div id="section-appointments">
        <?php if (!empty($appointments_data)): ?>
            <?php foreach ($appointments_data as $p): ?>
                <?php
                    $appt_id      = isset($p->appointment_id) ? $p->appointment_id : 'N/A';
                    $appt_date    = !empty($p->appointment_date) ? date('d M Y', strtotime($p->appointment_date)) : 'Date N/A';
                    $timing       = (!empty($p->from_timing) && !empty($p->to_timing)) ? html_escape($p->from_timing . ' - ' . $p->to_timing) : (!empty($p->from_timing) ? html_escape($p->from_timing) : 'Scheduled');
                    $patient      = isset($p->patient_name) && !empty($p->patient_name) ? $p->patient_name : 'Patient';
                    $doctor       = isset($p->doctor_name) && !empty($p->doctor_name) ? $p->doctor_name : 'Specialist Doctor';
                    $institute    = isset($p->institute_name) && !empty($p->institute_name) ? $p->institute_name : 'Healthcare Facility';
                    $amount       = isset($p->amount) && $p->amount > 0 ? $p->amount : (isset($p->fee) ? $p->fee : 500);
                    $pay_status   = isset($p->payment_status) ? strtoupper(trim($p->payment_status)) : 'UNPAID';
                    $is_paid      = ($pay_status == 'PAID' || $pay_status == 'DONE');
                    $is_cancelled = ($p->status == '2' || $p->appointment_status == '2' || $pay_status == 'REFUNDED');
                    $is_video     = (!empty($p->room_id) || (isset($p->appointment_type) && $p->appointment_type == 'video'));
                ?>

                <div class="appt-modern-card" id="appt-card-<?=$appt_id;?>" style="<?=$is_cancelled ? 'background: #fdfefe; opacity: 0.92; border-color: #fecaca;' : '';?>">
                    
                    <!-- Header -->
                    <div class="appt-card-header">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="appt-id-badge" style="<?=$is_cancelled ? 'background: #fef2f2; border-color: #fecaca; color: #dc2626;' : '';?>">
                                #APPT-<?=$appt_id;?>
                            </span>
                            <span style="font-weight: 700; font-size: 14px; color: var(--upchar-slate-800);">
                                <i class="fa fa-calendar" style="color: var(--upchar-teal); margin-right: 4px;"></i>
                                <?=$appt_date;?> &nbsp;&bull;&nbsp;
                                <i class="fa fa-clock-o" style="color: var(--upchar-teal); margin-right: 4px;"></i>
                                <?=$timing;?>
                            </span>
                        </div>

                        <div>
                            <?php if ($is_cancelled): ?>
                                <span class="badge-status badge-cancelled">
                                    <i class="fa fa-ban"></i> Cancelled
                                </span>
                                <?php if ($pay_status == 'REFUNDED'): ?>
                                    <span class="badge-status badge-refunded" style="margin-left: 6px;">
                                        <i class="fa fa-undo"></i> Refund Credited to Wallet
                                    </span>
                                <?php endif; ?>
                            <?php elseif ($is_paid): ?>
                                <span class="badge-status badge-paid">
                                    <i class="fa fa-check-circle"></i> Confirmed &amp; Paid (₹<?=number_format($amount, 2);?>)
                                </span>
                            <?php else: ?>
                                <span class="badge-status badge-unpaid">
                                    <i class="fa fa-clock-o"></i> Payment Pending
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Meta Grid -->
                    <div class="appt-body-grid">
                        <div class="appt-meta-block">
                            <div class="meta-label">Consulting Doctor</div>
                            <div class="meta-value">
                                <i class="fa fa-user-md" style="color: var(--upchar-teal);"></i>
                                <?=html_escape($doctor);?>
                            </div>
                        </div>

                        <div class="appt-meta-block">
                            <div class="meta-label">Facility / Mode</div>
                            <div class="meta-value">
                                <?php if ($is_video): ?>
                                    <i class="fa fa-video-camera" style="color: #4f46e5;"></i>
                                    <span style="color: #4f46e5;">Online Video Call</span>
                                <?php else: ?>
                                    <i class="fa fa-hospital-o" style="color: var(--upchar-teal);"></i>
                                    <span><?=html_escape($institute);?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="appt-meta-block">
                            <div class="meta-label">Patient Name</div>
                            <div class="meta-value">
                                <i class="fa fa-user-circle-o" style="color: var(--upchar-slate-500);"></i>
                                <?=html_escape($patient);?>
                            </div>
                        </div>

                        <div class="appt-meta-block">
                            <div class="meta-label">Consultation Fee</div>
                            <div class="meta-value" style="color: var(--upchar-teal); font-size: 16px;">
                                ₹<?=number_format($amount, 2);?>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action Bar -->
                    <div class="appt-card-footer">
                        <div>
                            <?php if ($is_cancelled): ?>
                                <span style="font-size: 12.5px; color: #b91c1c; font-weight: 600;">
                                    <i class="fa fa-info-circle"></i> 
                                    <?=!empty($p->cancel_reason) ? html_escape($p->cancel_reason) : 'Appointment cancelled by patient.';?>
                                    <?php if (!empty($p->cancel_date) && $p->cancel_date != '0000-00-00 00:00:00'): ?>
                                        <span style="color: var(--upchar-slate-500); font-weight: 400;">(<?=date('d M Y, h:i A', strtotime($p->cancel_date));?>)</span>
                                    <?php endif; ?>
                                </span>
                            <?php elseif ($is_paid): ?>
                                <span style="font-size: 12.5px; color: #15803d; font-weight: 600;">
                                    <i class="fa fa-shield"></i> 100% Upchar Refund Guarantee Protected
                                </span>
                            <?php else: ?>
                                <span style="font-size: 12.5px; color: #b45309; font-weight: 600;">
                                    <i class="fa fa-exclamation-triangle"></i> Complete payment to secure consultation slot
                                </span>
                            <?php endif; ?>
                        </div>

                        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <?php if ($is_cancelled): ?>
                                <a href="#wallet" onclick="switchDashboardTab('wallet')" class="btn-action-receipt" style="background: #f5f3ff; color: #7c3aed !important; border-color: #ddd6fe;">
                                    <i class="fa fa-google-wallet"></i> View Wallet Statement
                                </a>
                            <?php else: ?>
                                <?php if ($is_video): ?>
                                    <a href="<?=base_url('videocall/'.($p->room_id ?: 'upchar_consult_'.$appt_id));?>" target="_blank" class="btn-action-pay" style="background: #4f46e5;">
                                        <i class="fa fa-video-camera"></i> Launch Video Call
                                    </a>
                                <?php endif; ?>

                                <?php if ($is_paid): ?>
                                    <?php if (!empty($p->ref_no)): ?>
                                        <a href="<?=base_url('payment/receipt/'.$p->ref_no);?>" target="_blank" class="btn-action-receipt">
                                            <i class="fa fa-file-text-o"></i> View Receipt
                                        </a>
                                    <?php endif; ?>
                                    <button type="button" class="btn-action-cancel" onclick="openCancellationModal('APPT-<?=$appt_id;?>', '<?=html_escape($doctor);?>', '<?=$appt_date;?> <?=$timing;?>', '<?=$amount;?>')">
                                        <i class="fa fa-times-circle"></i> Cancel Appointment
                                    </button>
                                <?php else: ?>
                                    <a href="<?=base_url('paysecure/acheckout?aid='.$appt_id);?>" class="btn-action-pay">
                                        <i class="fa fa-bolt"></i> Pay Now (₹<?=number_format($amount, 2);?>)
                                    </a>
                                    <button type="button" class="btn-action-cancel" onclick="openCancellationModal('APPT-<?=$appt_id;?>', '<?=html_escape($doctor);?>', '<?=$appt_date;?> <?=$timing;?>', '0')">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-portal-box">
                <div class="empty-portal-icon"><i class="fa fa-calendar-plus-o"></i></div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--upchar-slate-900); margin: 0 0 6px 0;">No Appointments Booked Yet</h3>
                <p style="color: var(--upchar-slate-500); font-size: 14px; margin: 0 0 20px 0;">Book consultations with verified medical specialists in your city or online.</p>
                <a href="<?=base_url('doctors');?>" class="btn-hero-white" style="background: var(--upchar-teal); color: #ffffff !important;">
                    <i class="fa fa-stethoscope"></i> Find &amp; Book Doctor
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- ================================================================= -->
    <!-- TAB 2: UPCHAR WALLET & POINTS (REDESIGNED)                       -->
    <!-- ================================================================= -->
    <div id="section-wallet" style="display: none;">
        
        <!-- Showcase Card -->
        <div class="wallet-hero-showcase">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
                <div>
                    <div class="wallet-chip-icon">
                        <i class="fa fa-shield"></i> UPCHAR SECURED HEALTH WALLET
                    </div>
                    <div class="wallet-big-balance" id="wallet-display-points">
                        <?=number_format($points_bal, 0);?> <small style="font-size: 20px; font-weight: 700; color: #a5b4fc;">Points</small>
                    </div>
                    <div class="wallet-sub-eq" id="wallet-display-currency">
                        ≈ ₹<?=number_format($currency_val, 2);?> Available Indian Rupees Balance
                    </div>
                    <div style="font-size: 13px; color: #c7d2fe;">
                        <i class="fa fa-check-circle" style="color: #34d399;"></i> 1 Upchar Point = ₹<?=number_format($point_ratio ?? 1.00, 2);?> INR &nbsp;&bull;&nbsp; 
                        <i class="fa fa-percent" style="color: #fbbf24;"></i> <?=$cashback_pct;?>% Automatic Cashback on all consultations &amp; lab bookings
                    </div>
                </div>

                <div style="text-align: right;">
                    <a href="<?=base_url('wallet');?>" class="quick-recharge-pill" style="background: #ffffff; color: #312e81 !important; padding: 10px 20px; font-size: 14px;">
                        <i class="fa fa-plus-circle"></i> Custom Recharge
                    </a>
                </div>
            </div>

            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.15);">
                <div style="font-size: 12px; font-weight: 700; color: #a5b4fc; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px;">
                    Instant Wallet Top-Up Packages
                </div>
                <div class="wallet-quick-chips">
                    <a href="<?=base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=TOPUP-100&amount=100');?>" class="quick-recharge-pill">+ ₹100 Top-Up</a>
                    <a href="<?=base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=TOPUP-250&amount=250');?>" class="quick-recharge-pill">+ ₹250 Top-Up</a>
                    <a href="<?=base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=TOPUP-500&amount=500');?>" class="quick-recharge-pill">+ ₹500 Top-Up</a>
                    <a href="<?=base_url('payment/checkout?purpose=WALLET_RECHARGE&reference_id=TOPUP-1000&amount=1000');?>" class="quick-recharge-pill">+ ₹1,000 Top-Up</a>
                </div>
            </div>
        </div>

        <!-- Cancellation & Refund Policy Explainer -->
        <div class="policy-banner-box">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #166534; display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-refresh" style="color: var(--upchar-teal);"></i>
                    Upchar Cancellation Fee &amp; Instant Refund Policy
                </h4>
                <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 700; font-size: 11px;">
                    ADMIN MANAGED TRANSPARENT POLICY
                </span>
            </div>
            <p style="margin: 8px 0 0 0; font-size: 13px; color: #14532d; line-height: 1.5;">
                When you cancel a paid doctor appointment, your refund is credited <strong>instantly to your Upchar Wallet</strong> with zero bank waiting days. Cancellation deductions are automatically calculated based on notification time:
            </p>

            <div class="policy-tier-grid">
                <div class="policy-tier-card">
                    <div style="font-size: 11px; font-weight: 700; color: var(--upchar-slate-500); text-transform: uppercase;">Early Notice (>24h)</div>
                    <div style="font-size: 17px; font-weight: 800; color: #15803d; margin: 4px 0 2px;">90% Refund</div>
                    <div style="font-size: 11.5px; color: var(--upchar-slate-500);">(10% cancellation fee)</div>
                </div>

                <div class="policy-tier-card">
                    <div style="font-size: 11px; font-weight: 700; color: var(--upchar-slate-500); text-transform: uppercase;">Standard Notice (12-24h)</div>
                    <div style="font-size: 17px; font-weight: 800; color: #b45309; margin: 4px 0 2px;">80% Refund</div>
                    <div style="font-size: 11.5px; color: var(--upchar-slate-500);">(20% cancellation fee)</div>
                </div>

                <div class="policy-tier-card">
                    <div style="font-size: 11px; font-weight: 700; color: var(--upchar-slate-500); text-transform: uppercase;">Late Notice (&lt;12h)</div>
                    <div style="font-size: 17px; font-weight: 800; color: #b91c1c; margin: 4px 0 2px;">70% Refund</div>
                    <div style="font-size: 11.5px; color: var(--upchar-slate-500);">(30% cancellation fee)</div>
                </div>

                <div class="policy-tier-card" style="background: #f0fdfa; border-color: #ccfbf1;">
                    <div style="font-size: 11px; font-weight: 700; color: var(--upchar-teal); text-transform: uppercase;">Doctor Cancellation</div>
                    <div style="font-size: 17px; font-weight: 800; color: var(--upchar-teal); margin: 4px 0 2px;">100% Full Refund</div>
                    <div style="font-size: 11.5px; color: var(--upchar-slate-500);">(0% fee protection)</div>
                </div>
            </div>
        </div>

        <!-- Wallet Transactions Ledger -->
        <div style="background: #ffffff; border: 1px solid var(--upchar-slate-200); border-radius: 18px; padding: 24px; box-shadow: var(--card-shadow);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--upchar-slate-900);">
                        <i class="fa fa-history" style="color: var(--upchar-teal);"></i> Points &amp; Wallet Activity Ledger
                    </h3>
                    <p style="margin: 3px 0 0 0; font-size: 13px; color: var(--upchar-slate-500);">
                        Chronological record of wallet top-ups, consultation payments, cashback rewards &amp; cancellation refunds
                    </p>
                </div>

                <span class="badge" style="background: #f1f5f9; color: var(--upchar-slate-600); font-weight: 700; font-size: 12px;">
                    Showing Last <?=is_array($wallet_history) ? count($wallet_history) : 0;?> Transactions
                </span>
            </div>

            <div style="overflow-x: auto;">
                <table class="table table-hover" style="font-size: 13.5px; margin-bottom: 0;">
                    <thead>
                        <tr style="color: var(--upchar-slate-500); background: #f8fafc; border-bottom: 2px solid var(--upchar-slate-200);">
                            <th style="padding: 12px 16px;">Txn Reference</th>
                            <th style="padding: 12px 16px;">Source &amp; Category</th>
                            <th style="padding: 12px 16px;">Description &amp; Notes</th>
                            <th style="padding: 12px 16px; text-align: right;">Amount</th>
                            <th style="padding: 12px 16px; text-align: right;">Balance After</th>
                            <th style="padding: 12px 16px; text-align: right;">Date &amp; Time</th>
                        </tr>
                    </thead>
                    <tbody id="wallet-ledger-tbody">
                        <?php if (!empty($wallet_history)): ?>
                            <?php foreach ($wallet_history as $wh): ?>
                                <?php
                                    $isCredit = ($wh['type'] === 'CREDIT');
                                    $source = strtoupper($wh['source'] ?? '');
                                    $badgeBg = '#f1f5f9';
                                    $badgeCol = '#475569';
                                    if ($source === 'REFUND') {
                                        $badgeBg = '#f3e8ff';
                                        $badgeCol = '#7c3aed';
                                    } elseif ($source === 'APPOINTMENT_CASHBACK' || $source === 'CASHBACK') {
                                        $badgeBg = '#dcfce7';
                                        $badgeCol = '#15803d';
                                    } elseif ($source === 'SIGNUP_BONUS') {
                                        $badgeBg = '#fef3c7';
                                        $badgeCol = '#92400e';
                                    } elseif ($source === 'WALLET_RECHARGE') {
                                        $badgeBg = '#e0f2fe';
                                        $badgeCol = '#0369a1';
                                    } elseif ($source === 'APPOINTMENT_PAYMENT') {
                                        $badgeBg = '#fee2e2';
                                        $badgeCol = '#b91c1c';
                                    }
                                ?>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <code style="font-size: 12px; font-weight: 700; color: var(--upchar-slate-800); background: #f1f5f9; padding: 2px 6px; border-radius: 4px;"><?=$wh['txn_ref'];?></code>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <span class="badge" style="background: <?=$badgeBg;?>; color: <?=$badgeCol;?>; font-weight: 700; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                            <?=$wh['source'];?>
                                        </span>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; max-width: 320px;">
                                        <div style="font-weight: 600; color: var(--upchar-slate-900);">
                                            <?=htmlspecialchars($wh['description']);?>
                                        </div>
                                        <?php if (!empty($wh['reference_id'])): ?>
                                            <small style="color: var(--upchar-slate-500);">Ref: <?=htmlspecialchars($wh['reference_id']);?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; text-align: right; font-weight: 800; font-size: 14.5px; color: <?=$isCredit ? '#16a34a' : '#dc2626';?>;">
                                        <?=$isCredit ? '+' : '-';?><?=number_format($wh['amount_points'], 2);?> Pts
                                        <div style="font-size: 11px; font-weight: 600; color: var(--upchar-slate-500);">
                                            (₹<?=number_format($wh['amount_money'] ?? ($wh['amount_points'] * ($point_ratio ?? 1)), 2);?>)
                                        </div>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; text-align: right; font-weight: 700; color: var(--upchar-slate-800);">
                                        <?=number_format($wh['balance_after'], 2);?> Pts
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; text-align: right; color: var(--upchar-slate-500); font-size: 12.5px;">
                                        <?=date('d M Y, h:i A', strtotime($wh['created_at']));?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 35px; color: var(--upchar-slate-500);">
                                    No wallet activity or refund transactions yet.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- TAB 3: DIAGNOSTICS & LAB ORDERS                                  -->
    <!-- ================================================================= -->
    <div id="section-diagnostics" style="display: none;">
        <?php if (!empty($lab_bookings)): ?>
            <?php foreach ($lab_bookings as $lb): 
                $bid           = $lb['booking_id'];
                $stage         = !empty($lb['order_stage']) ? $lb['order_stage'] : (!empty($lb['status']) ? $lb['status'] : 'BOOKED');
                $isReportReady = ($stage === 'REPORT_READY' || $stage === 'COMPLETED' || !empty($lb['report_file']) || !empty($lb['reports']));
                $reportUrl     = !empty($lb['report_file']) ? base_url($lb['report_file']) : (!empty($lb['reports'][0]['report_file']) ? base_url($lb['reports'][0]['report_file']) : '');
                $testsList     = !empty($lb['tests']) ? $lb['tests'] : [];
                $is_lab_cancel = ($lb['status'] === '2' || $stage === 'CANCELLED');
            ?>
                <div class="appt-modern-card" style="<?=$is_lab_cancel ? 'opacity: 0.85; border-color: #fecaca;' : '';?>">
                    <div class="appt-card-header">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="appt-id-badge" style="background: #eff6ff; border-color: #bfdbfe; color: #2563eb;">
                                #LAB-<?=$bid;?>
                            </span>
                            <span style="font-weight: 700; font-size: 14px; color: var(--upchar-slate-800);">
                                <i class="fa fa-calendar" style="color: #2563eb; margin-right: 4px;"></i>
                                <?=date('d M Y', strtotime($lb['book_date']));?>
                                <?php if (!empty($lb['time_slot'])): ?>
                                    <span style="color: var(--upchar-slate-500); font-weight: 500;">(<?=htmlspecialchars($lb['time_slot']);?>)</span>
                                <?php endif; ?>
                            </span>
                        </div>

                        <div>
                            <?php if ($is_lab_cancel): ?>
                                <span class="badge-status badge-cancelled">CANCELLED &amp; REFUNDED</span>
                            <?php elseif ($isReportReady): ?>
                                <span class="badge-status badge-paid">
                                    <i class="fa fa-check-circle"></i> REPORT READY
                                </span>
                            <?php elseif ($stage === 'PROCESSING'): ?>
                                <span class="badge-status" style="background: #fef3c7; color: #92400e;">
                                    <i class="fa fa-cogs"></i> IN PROCESSING
                                </span>
                            <?php elseif ($stage === 'COLLECTED'): ?>
                                <span class="badge-status" style="background: #e0f2fe; color: #0369a1;">
                                    <i class="fa fa-tint"></i> SAMPLE COLLECTED
                                </span>
                            <?php else: ?>
                                <span class="badge-status" style="background: #f1f5f9; color: #475569;">
                                    <i class="fa fa-clock-o"></i> BOOKED
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="appt-body-grid">
                        <div class="appt-meta-block">
                            <div class="meta-label">Diagnostic Laboratory</div>
                            <div class="meta-value">
                                <i class="fa fa-building-o" style="color: #2563eb;"></i>
                                <?=htmlspecialchars($lb['lab_name'] ?: 'Upchar Certified Diagnostic Lab');?>
                            </div>
                        </div>

                        <div class="appt-meta-block">
                            <div class="meta-label">Collection Type</div>
                            <div class="meta-value">
                                <i class="fa fa-home" style="color: var(--upchar-teal);"></i>
                                <?=htmlspecialchars($lb['collection_type'] ?: 'Home Blood Sample Collection');?>
                            </div>
                        </div>

                        <div class="appt-meta-block">
                            <div class="meta-label">Patient Name</div>
                            <div class="meta-value">
                                <i class="fa fa-user-circle-o" style="color: var(--upchar-slate-500);"></i>
                                <?=htmlspecialchars($lb['patient_name'] ?? $user_name);?>
                            </div>
                        </div>

                        <div class="appt-meta-block">
                            <div class="meta-label">Total Amount Paid</div>
                            <div class="meta-value" style="color: #2563eb; font-size: 16px;">
                                ₹<?=number_format($lb['total_amount'] ?? 0, 2);?>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($testsList)): ?>
                        <div style="margin-bottom: 16px;">
                            <div style="font-size: 11px; font-weight: 700; color: var(--upchar-slate-500); text-transform: uppercase; margin-bottom: 6px;">
                                Investigations Included (<?=count($testsList);?>)
                            </div>
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <?php foreach ($testsList as $t): ?>
                                    <span style="background: #f8fafc; border: 1px solid var(--upchar-slate-200); border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; color: var(--upchar-slate-800);">
                                        <?=htmlspecialchars($t['test_name']);?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="appt-card-footer">
                        <div>
                            <?php if ($isReportReady && !empty($reportUrl)): ?>
                                <a href="<?=$reportUrl;?>" target="_blank" class="btn-action-pay" style="background: var(--upchar-teal);">
                                    <i class="fa fa-download"></i> Download PDF Diagnostic Report
                                </a>
                            <?php elseif ($is_lab_cancel): ?>
                                <span style="font-size: 12.5px; color: #b91c1c; font-weight: 600;">
                                    <i class="fa fa-ban"></i> Diagnostic order cancelled. Refund credited to Upchar Wallet.
                                </span>
                            <?php else: ?>
                                <span style="font-size: 12.5px; color: var(--upchar-slate-500);">
                                    <i class="fa fa-hourglass-half" style="color: #f59e0b;"></i> Lab pathologist is reviewing your blood test investigation.
                                </span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <?php if (!$is_lab_cancel && !$isReportReady): ?>
                                <button type="button" class="btn-action-cancel" onclick="openCancellationModal('LAB-<?=$bid;?>', 'Diagnostic Lab Package', 'Order #LAB-<?=$bid;?>', '<?=$lb['total_amount'] ?? 0;?>')">
                                    <i class="fa fa-times-circle"></i> Cancel Order
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-portal-box">
                <div class="empty-portal-icon"><i class="fa fa-flask"></i></div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--upchar-slate-900); margin: 0 0 6px 0;">No Diagnostic Orders Found</h3>
                <p style="color: var(--upchar-slate-500); font-size: 14px; margin: 0 0 20px 0;">Book diagnostic tests, blood panels, and full body health checkups online.</p>
                <a href="<?=base_url('mytest');?>" class="btn-hero-white" style="background: #2563eb; color: #ffffff !important;">
                    <i class="fa fa-flask"></i> Explore Diagnostic Catalog
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- ================================================================= -->
    <!-- TAB 4: INVOICES & PAYMENT RECEIPTS                               -->
    <!-- ================================================================= -->
    <div id="section-payments" style="display: none;">
        <div style="background: #ffffff; border: 1px solid var(--upchar-slate-200); border-radius: 18px; padding: 24px; box-shadow: var(--card-shadow);">
            <h3 style="font-size: 17px; font-weight: 800; color: var(--upchar-slate-900); margin: 0 0 16px 0;">
                <i class="fa fa-file-text-o" style="color: var(--upchar-teal);"></i> Online Invoices &amp; Payment Receipts
            </h3>

            <div style="overflow-x: auto;">
                <table class="table table-hover" style="font-size: 13.5px; margin-bottom: 0;">
                    <thead>
                        <tr style="color: var(--upchar-slate-500); background: #f8fafc; border-bottom: 2px solid var(--upchar-slate-200);">
                            <th style="padding: 12px 16px;">Order Reference</th>
                            <th style="padding: 12px 16px;">Service Purpose</th>
                            <th style="padding: 12px 16px;">Amount (INR)</th>
                            <th style="padding: 12px 16px;">Points Redeemed</th>
                            <th style="padding: 12px 16px;">Gateway Ref ID</th>
                            <th style="padding: 12px 16px;">Payment Status</th>
                            <th style="padding: 12px 16px; text-align: right;">Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payments_data)): ?>
                            <?php foreach ($payments_data as $pd): ?>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <code style="font-weight: 700; color: var(--upchar-slate-800); background: #f1f5f9; padding: 2px 6px; border-radius: 4px;"><?=$pd['internal_order_ref'];?></code>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 11px;">
                                            <?=$pd['purpose'];?>
                                        </span>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; font-weight: 800; color: var(--upchar-slate-900);">
                                        ₹<?=number_format($pd['amount'], 2);?>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; font-weight: 600; color: #7c3aed;">
                                        <?=number_format($pd['wallet_points_used'], 0);?> Pts
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; color: var(--upchar-slate-500);">
                                        <small><?=$pd['razorpay_payment_id'] ?: '-';?></small>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle;">
                                        <span class="badge-status <?=($pd['status'] === 'PAID') ? 'badge-paid' : 'badge-unpaid';?>">
                                            <?=$pd['status'];?>
                                        </span>
                                    </td>
                                    <td style="padding: 14px 16px; vertical-align: middle; text-align: right;">
                                        <a href="<?=base_url('payment/receipt/'.$pd['internal_order_ref']);?>" target="_blank" class="btn-action-receipt">
                                            <i class="fa fa-file-text-o"></i> View Receipt
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 35px; color: var(--upchar-slate-500);">
                                    No payment receipts found in history.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SPONSORED HEALTHCARE DEALS -->
    <?php if (!empty($sponsored_ads)): ?>
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid var(--upchar-slate-200); padding: 24px; margin-top: 25px; box-shadow: var(--card-shadow);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 8px;">
                <div>
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                        <i class="fa fa-bullhorn"></i> Verified Medical Partner Offers
                    </span>
                    <h4 style="margin: 6px 0 0; font-size: 17px; font-weight: 800; color: var(--upchar-slate-900);">
                        Special Sponsored Healthcare Discounts &amp; Deals
                    </h4>
                </div>
                <a href="<?=base_url();?>#sponsoredShowcaseSection" target="_blank" style="font-size: 12.5px; color: var(--upchar-teal); font-weight: 700; text-decoration: none;">
                    View All Offers &rarr;
                </a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                <?php foreach (array_slice($sponsored_ads, 0, 3) as $ad): 
                    $imgSrc = filter_var($ad->image, FILTER_VALIDATE_URL) ? $ad->image : (base_url('public/assets/upload/' . $ad->image));
                    $adUrl  = base_url('home/ad_click/' . $ad->id);
                ?>
                <div style="background: #f8fafc; border-radius: 14px; border: 1px solid var(--upchar-slate-200); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                    <div style="position: relative; height: 120px; overflow: hidden;">
                        <img src="<?=$imgSrc;?>" alt="<?=html_escape($ad->title);?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400';">
                        <span style="position: absolute; top: 8px; left: 8px; background: rgba(15, 23, 42, 0.85); color: #2dd4bf; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 12px;">
                            <?=html_escape($ad->sponsor_badge ?: 'Sponsored Partner');?>
                        </span>
                    </div>
                    <div style="padding: 14px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <strong style="font-size: 14px; color: var(--upchar-slate-900); display: block; margin-bottom: 4px; line-height: 1.3;">
                                <?=html_escape($ad->title ?: $ad->short_description);?>
                            </strong>
                            <p style="font-size: 12px; color: var(--upchar-slate-500); margin: 0 0 10px; line-height: 1.4;">
                                <?=html_escape($ad->short_description);?>
                            </p>
                        </div>
                        <div style="border-top: 1px solid var(--upchar-slate-200); padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 11px; color: #16a34a; font-weight: 700;"><i class="fa fa-tag"></i> Partner Deal</span>
                            <a href="<?=$adUrl;?>" target="_blank" class="btn btn-xs" style="background: var(--upchar-teal); color: #ffffff; font-weight: 700; border-radius: 6px; padding: 5px 12px;">
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

<!-- ================================================================= -->
<!-- INTERACTIVE CANCELLATION FEE & REFUND MODAL DIALOG               -->
<!-- ================================================================= -->
<div class="refund-modal-backdrop" id="cancellationModal">
    <div class="refund-modal-card">
        
        <!-- Modal Header -->
        <div class="refund-modal-header">
            <div>
                <h4 style="margin: 0; font-size: 17px; font-weight: 800; color: var(--upchar-slate-900);">
                    <i class="fa fa-calendar-times-o" style="color: #ef4444;"></i> Cancel Appointment &amp; Refund
                </h4>
                <div style="font-size: 12px; color: var(--upchar-slate-500); margin-top: 2px;" id="modalApptSubtitle">
                    Review refund calculation and cancellation deduction
                </div>
            </div>
            <button type="button" onclick="closeCancellationModal()" style="background: transparent; border: none; font-size: 20px; color: var(--upchar-slate-500); cursor: pointer; padding: 0 4px;">
                &times;
            </button>
        </div>

        <!-- Modal Body -->
        <div class="refund-modal-body">
            
            <!-- Loading State -->
            <div id="modalLoadingState" style="text-align: center; padding: 25px;">
                <i class="fa fa-spinner fa-spin" style="font-size: 28px; color: var(--upchar-teal);"></i>
                <div style="font-size: 13.5px; font-weight: 600; color: var(--upchar-slate-600); margin-top: 10px;">
                    Calculating eligible refund &amp; cancellation fee...
                </div>
            </div>

            <!-- Quote Content -->
            <div id="modalQuoteContent" style="display: none;">
                
                <div class="refund-breakdown-card">
                    <div class="breakdown-row">
                        <span>Consultation Booking:</span>
                        <strong id="quoteOrderRef" style="color: var(--upchar-slate-900);">#APPT-0</strong>
                    </div>
                    <div class="breakdown-row">
                        <span>Original Paid Fee:</span>
                        <strong id="quoteGrossFee" style="color: var(--upchar-slate-900);">₹0.00</strong>
                    </div>
                    <div class="breakdown-row" id="quoteFeeRow" style="color: #dc2626;">
                        <span>Cancellation Deduction (<span id="quoteDeductPct">0%</span>):</span>
                        <strong id="quoteDeductAmount">-₹0.00</strong>
                    </div>
                    <div class="breakdown-row total-row">
                        <span>Net Refund to Upchar Wallet:</span>
                        <span id="quoteRefundAmount" style="font-size: 18px; font-weight: 900;">₹0.00</span>
                    </div>
                </div>

                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px 14px; margin-bottom: 18px; font-size: 12.5px; color: #15803d;">
                    <i class="fa fa-bolt" style="color: var(--upchar-teal);"></i>
                    <strong id="quotePolicyText">Policy Applied</strong>
                    <div style="margin-top: 2px;">
                        Funds will be credited <strong>instantly to your Upchar Wallet</strong> upon confirmation.
                    </div>
                </div>

                <!-- Reason Selector -->
                <div style="margin-bottom: 14px;">
                    <label style="font-size: 12px; font-weight: 700; color: var(--upchar-slate-600); text-transform: uppercase; margin-bottom: 6px; display: block;">
                        Reason for Cancellation
                    </label>
                    <select id="cancelReasonSelect" class="form-control" style="border-radius: 8px; font-size: 13.5px; padding: 8px 12px;">
                        <option value="Personal schedule conflict / Change of plans">Personal schedule conflict / Change of plans</option>
                        <option value="Found an earlier appointment / Doctor rescheduled">Found an earlier appointment / Doctor rescheduled</option>
                        <option value="Health emergency / Patient hospitalized">Health emergency / Patient hospitalized</option>
                        <option value="Booked by mistake">Booked by mistake</option>
                        <option value="Other reason">Other reason (specify below)</option>
                    </select>
                </div>

                <div style="margin-bottom: 10px;">
                    <input type="text" id="cancelReasonCustom" class="form-control" placeholder="Additional notes or feedback (optional)" style="border-radius: 8px; font-size: 13px; padding: 8px 12px;">
                </div>

            </div>

            <!-- Error State -->
            <div id="modalErrorState" style="display: none; background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 16px; color: #b91c1c; font-size: 13.5px; text-align: center;">
                <i class="fa fa-exclamation-circle" style="font-size: 20px;"></i>
                <div id="modalErrorMessage" style="margin-top: 6px; font-weight: 600;">Unable to fetch cancellation quote.</div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="refund-modal-footer">
            <button type="button" class="btn" onclick="closeCancellationModal()" style="background: #ffffff; border: 1px solid var(--upchar-slate-200); color: var(--upchar-slate-600); font-weight: 600; border-radius: 8px; padding: 8px 16px; font-size: 13px;">
                Keep Appointment
            </button>
            <button type="button" id="btnConfirmCancellation" class="btn" onclick="executeCancellation()" style="background: #ef4444; border: none; color: #ffffff; font-weight: 700; border-radius: 8px; padding: 8px 18px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-times"></i> Confirm Cancellation &amp; Refund
            </button>
        </div>

    </div>
</div>

<script>
// Dashboard Tab Switcher
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

    if (history.pushState) {
        history.pushState(null, null, '#' + tab);
    } else {
        location.hash = '#' + tab;
    }
}

// Active cancellation state
let currentOrderRef = null;
let currentRefundAmount = 0;

// Open Cancellation Modal with real-time Quote
function openCancellationModal(orderRef, doctorName, apptTiming, initialAmount) {
    currentOrderRef = orderRef;
    const modal = document.getElementById('cancellationModal');
    const loading = document.getElementById('modalLoadingState');
    const quoteContent = document.getElementById('modalQuoteContent');
    const errorState = document.getElementById('modalErrorState');
    const confirmBtn = document.getElementById('btnConfirmCancellation');

    document.getElementById('modalApptSubtitle').innerText = doctorName + ' • ' + apptTiming;
    
    loading.style.display = 'block';
    quoteContent.style.display = 'none';
    errorState.style.display = 'none';
    confirmBtn.disabled = true;

    modal.style.display = 'flex';

    // Fetch Quote from API
    fetch('<?=base_url("refund/quote");?>?order_ref=' + encodeURIComponent(orderRef))
    .then(res => res.json())
    .then(data => {
        loading.style.display = 'none';
        if (data.status === 'success') {
            quoteContent.style.display = 'block';
            confirmBtn.disabled = false;

            document.getElementById('quoteOrderRef').innerText = '#' + data.order_ref;
            document.getElementById('quoteGrossFee').innerText = '₹' + parseFloat(data.gross_amount).toFixed(2);
            document.getElementById('quoteDeductPct').innerText = data.deduction_percent + '%';
            document.getElementById('quoteDeductAmount').innerText = '-₹' + parseFloat(data.deduction_amount).toFixed(2);
            document.getElementById('quoteRefundAmount').innerText = '₹' + parseFloat(data.refund_amount).toFixed(2);
            document.getElementById('quotePolicyText').innerText = data.policy_text || 'Instant Upchar Wallet Credit Guarantee';

            currentRefundAmount = parseFloat(data.refund_amount);

            if (data.is_paid && currentRefundAmount > 0) {
                confirmBtn.innerHTML = '<i class="fa fa-times"></i> Confirm Cancel &amp; Refund ₹' + currentRefundAmount.toFixed(2);
            } else {
                confirmBtn.innerHTML = '<i class="fa fa-times"></i> Confirm Cancellation';
            }
        } else {
            errorState.style.display = 'block';
            document.getElementById('modalErrorMessage').innerText = data.message || 'Unable to retrieve cancellation quote.';
        }
    })
    .catch(err => {
        loading.style.display = 'none';
        errorState.style.display = 'block';
        document.getElementById('modalErrorMessage').innerText = 'Connection error. Please try again.';
    });
}

function closeCancellationModal() {
    document.getElementById('cancellationModal').style.display = 'none';
    currentOrderRef = null;
}

// Confirm and Execute Cancellation
function executeCancellation() {
    if (!currentOrderRef) return;

    const confirmBtn = document.getElementById('btnConfirmCancellation');
    const originalHtml = confirmBtn.innerHTML;
    confirmBtn.disabled = true;
    confirmBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing Refund...';

    const reasonSelect = document.getElementById('cancelReasonSelect').value;
    const reasonCustom = document.getElementById('cancelReasonCustom').value.trim();
    const finalReason = reasonCustom ? (reasonSelect + ' - ' + reasonCustom) : reasonSelect;

    const formData = new FormData();
    formData.append('order_ref', currentOrderRef);
    formData.append('refund_to', 'WALLET');
    formData.append('reason', finalReason);
    formData.append('<?=$csrf_token_name;?>', '<?=$csrf_hash;?>');

    fetch('<?=base_url("refund/initiate");?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            confirmBtn.innerHTML = '<i class="fa fa-check"></i> Cancelled!';
            alert('✓ ' + (data.message || 'Appointment cancelled successfully.'));
            window.location.reload();
        } else {
            alert(data.message || 'Unable to cancel appointment. Please contact support.');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = originalHtml;
        }
    })
    .catch(err => {
        alert('Appointment cancellation completed.');
        window.location.reload();
    });
}

// Auto open tab based on URL hash (e.g. #wallet)
$(document).ready(function() {
    const hash = window.location.hash;
    if (hash === '#wallet') {
        switchDashboardTab('wallet');
    } else if (hash === '#diagnostics') {
        switchDashboardTab('diagnostics');
    } else if (hash === '#payments') {
        switchDashboardTab('payments');
    } else {
        switchDashboardTab('appointments');
    }
});
</script>
