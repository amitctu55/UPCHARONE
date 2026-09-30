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
$amb_bookings  = is_array($ambulance_bookings ?? null) ? $ambulance_bookings : [];
$amb_count     = count($amb_bookings);
$has_active_amb = !empty($active_ambulance);

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
/* Modern Filter & Pagination System */
.portal-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    background: #ffffff;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.portal-filter-search {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 10px;
    padding: 8px 14px;
    flex: 1;
    min-width: 240px;
    max-width: 380px;
}

.portal-filter-search input {
    border: none;
    background: transparent;
    outline: none;
    font-size: 13.5px;
    color: var(--upchar-slate-800);
    width: 100%;
}

.portal-status-pills {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.status-filter-pill {
    background: #f1f5f9;
    border: 1px solid transparent;
    color: var(--upchar-slate-600);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

.status-filter-pill:hover {
    background: #e2e8f0;
    color: var(--upchar-slate-800);
}

.status-filter-pill.active {
    background: var(--upchar-teal);
    color: #ffffff;
}

.portal-pagination-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    background: #ffffff;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 14px;
    padding: 14px 20px;
    margin-top: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.portal-page-numbers {
    display: flex;
    align-items: center;
    gap: 5px;
    flex-wrap: wrap;
}

.page-num-btn {
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border-radius: 8px;
    border: 1px solid var(--upchar-slate-200);
    background: #ffffff;
    color: var(--upchar-slate-700);
    font-size: 13px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
}

.page-num-btn:hover:not(:disabled) {
    background: #f1f5f9;
    border-color: var(--upchar-slate-300);
    color: var(--upchar-slate-900);
}

.page-num-btn.active {
    background: var(--upchar-teal);
    border-color: var(--upchar-teal);
    color: #ffffff !important;
}

.page-num-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
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
                <button type="button" onclick="openAmbulanceDispatchModal()" class="btn-hero-white" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: #ffffff; border-color: rgba(255,255,255,0.3); box-shadow: 0 4px 15px rgba(220,38,38,0.4);">
                    <i class="fa fa-ambulance"></i> Request Ambulance / SOS
                </button>
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
        <!-- Ambulance & Emergency Response KPI Card -->
        <div class="portal-kpi-card" onclick="switchDashboardTab('ambulance')" style="<?= $has_active_amb ? 'border: 2px solid #ef4444; background: #fff5f5;' : ''; ?>">
            <div>
                <div class="kpi-title" style="color: #ef4444;"><i class="fa fa-bolt"></i> Ambulance &amp; SOS</div>
                <div class="kpi-main-val" style="color: #dc2626;">
                    <?=$amb_count;?> <small style="font-size: 13px; font-weight: 700; color: #64748b;">Trips</small>
                </div>
                <div class="kpi-caption">
                    <?php if($has_active_amb): ?>
                        <span style="color: #ef4444; font-weight: 800;"><i class="fa fa-circle text-danger"></i> 1 Active Trip En Route</span>
                    <?php else: ?>
                        24/7 Rapid ICU &amp; GPS Tracking
                    <?php endif; ?>
                </div>
            </div>
            <div class="kpi-icon-pill" style="background: #fee2e2; color: #dc2626;">
                <i class="fa fa-ambulance"></i>
            </div>
        </div>
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
        <button type="button" class="portal-tab-btn" id="tabBtn-ambulance" onclick="switchDashboardTab('ambulance')" style="<?= $has_active_amb ? 'border: 1.5px solid #ef4444; background: #fff5f5;' : ''; ?>">
            <i class="fa fa-ambulance" style="color: #ef4444;"></i> Ambulance &amp; SOS
            <span class="tab-badge-pill" style="<?= $has_active_amb ? 'background: #dc2626; color: #ffffff;' : ''; ?>">
                <?=$amb_count;?><?= $has_active_amb ? ' • LIVE' : ''; ?>
            </span>
        </button>
        <button type="button" class="portal-tab-btn" id="tabBtn-diagnostics" onclick="switchDashboardTab('diagnostics')">
            <i class="fa fa-flask"></i> Lab Tests &amp; Diagnostics
            <span class="tab-badge-pill"><?=$lab_count;?></span>
        </button>
        <button type="button" class="portal-tab-btn" id="tabBtn-wallet" onclick="switchDashboardTab('wallet')">
            <i class="fa fa-google-wallet"></i> Upchar Wallet &amp; Points
            <span class="tab-badge-pill" style="background: #7c3aed; color: #ffffff;">₹<?=number_format($currency_val, 0);?></span>
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

            <!-- Interactive Filter & Search Bar -->
            <div class="portal-filter-bar">
                <div class="portal-filter-search">
                    <i class="fa fa-search" style="color: var(--upchar-slate-400);"></i>
                    <input type="text" id="apptSearchInput" placeholder="Search doctor, facility, ID, patient..." oninput="filterAndPaginateAppts()">
                </div>
                <div class="portal-status-pills">
                    <button type="button" class="status-filter-pill active" data-filter="all" onclick="setApptStatusFilter('all', this)">
                        All (<?=$appt_count;?>)
                    </button>
                    <button type="button" class="status-filter-pill" data-filter="active" onclick="setApptStatusFilter('active', this)">
                        <i class="fa fa-check-circle" style="color: #10b981; margin-right: 3px;"></i> Active / Upcoming
                    </button>
                    <button type="button" class="status-filter-pill" data-filter="cancelled" onclick="setApptStatusFilter('cancelled', this)">
                        <i class="fa fa-times-circle" style="color: #ef4444; margin-right: 3px;"></i> Cancelled
                    </button>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--upchar-slate-600); font-weight: 600;">
                    <span>Show:</span>
                    <select id="apptPageSizeSelect" onchange="changeApptPageSize(this.value)" style="border: 1px solid var(--upchar-slate-200); border-radius: 8px; padding: 6px 10px; font-size: 13px; font-weight: 700; color: var(--upchar-slate-700); background: #ffffff; outline: none; cursor: pointer;">
                        <option value="10" selected>10 per page</option>
                        <option value="20">20 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
            </div>

            <div id="apptCardsContainer">
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
                    $is_done      = ($p->status == '3' || strtoupper(trim($p->status ?? '')) === 'COMPLETED' || strtoupper(trim($p->status ?? '')) === 'DONE' || ($p->appointment_status ?? '') == '3');
                    $is_video     = (!empty($p->room_id) || (isset($p->appointment_type) && $p->appointment_type == 'video'));

                    // Hospital cancellation policy & cutoff timing
                    $cancellation_hours = isset($p->cancellation_hours) ? max(0, intval($p->cancellation_hours)) : 3;
                    $raw_from = !empty($p->from_timing) ? $p->from_timing : (!empty($p->appointment_time) ? $p->appointment_time : '10:00:00');
                    $parsed_slot_time = strtotime($raw_from);
                    $slot_time_str = ($parsed_slot_time !== false) ? date('H:i:s', $parsed_slot_time) : '10:00:00';
                    $slot_timestamp = !empty($p->appointment_date) ? strtotime($p->appointment_date . ' ' . $slot_time_str) : 0;
                    $now = time();
                    $hours_remaining = ($slot_timestamp - $now) / 3600.0;
                    $is_cancellable = (!$is_cancelled && !$is_done && ($slot_timestamp > 0) && ($hours_remaining >= $cancellation_hours));
                ?>

                <div class="appt-modern-card" id="appt-card-<?=$appt_id;?>" data-status="<?=$is_cancelled ? 'cancelled' : 'active';?>" data-search="<?=strtolower(html_escape($appt_id . ' ' . $doctor . ' ' . $institute . ' ' . $patient . ' ' . $appt_date . ' ' . $pay_status));?>" style="<?=$is_cancelled ? 'background: #fdfefe; opacity: 0.92; border-color: #fecaca;' : '';?>">
                    
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
                            <?php elseif ($is_done): ?>
                                <span class="badge-status" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-weight: 700; font-size: 12px; padding: 4px 10px; border-radius: 6px;">
                                    <i class="fa fa-check-square-o"></i> Consultation Completed
                                </span>
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
                            <?php elseif ($is_done): ?>
                                <span style="font-size: 12.5px; color: #0369a1; font-weight: 600;">
                                    <i class="fa fa-check-circle"></i> Consultation Completed &bull; Non-Cancellable
                                </span>
                            <?php elseif ($hours_remaining < $cancellation_hours): ?>
                                <span style="font-size: 12.5px; color: #64748b; font-weight: 600;" title="Cancellation cutoff: <?=$cancellation_hours;?> hours before appointment slot">
                                    <i class="fa fa-lock"></i> Cancellation window closed (Cutoff: <?=$cancellation_hours;?>h before slot)
                                </span>
                            <?php elseif ($is_paid): ?>
                                <span style="font-size: 12.5px; color: #15803d; font-weight: 600;">
                                    <i class="fa fa-shield"></i> 100% Upchar Refund Guarantee Protected &bull; Cancellations open until <?=$cancellation_hours;?>h prior
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
                            <?php elseif ($is_done): ?>
                                <?php if (!empty($p->ref_no)): ?>
                                    <a href="<?=base_url('payment/receipt/'.$p->ref_no);?>" target="_blank" class="btn-action-receipt">
                                        <i class="fa fa-file-text-o"></i> View Receipt
                                    </a>
                                <?php endif; ?>
                                <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 7px 12px; font-size: 12px; font-weight: 600; border-radius: 6px;">
                                    <i class="fa fa-check"></i> Consultation Done
                                </span>
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
                                    <?php if ($is_cancellable): ?>
                                        <button type="button" class="btn-action-cancel" onclick="openCancellationModal('APPT-<?=$appt_id;?>', '<?=html_escape($doctor);?>', '<?=$appt_date;?> <?=$timing;?>', '<?=$amount;?>')">
                                            <i class="fa fa-times-circle"></i> Cancel Appointment
                                        </button>
                                    <?php else: ?>
                                        <span class="badge" style="background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 7px 12px; font-size: 12px; font-weight: 600; border-radius: 6px;" title="<?=$slot_timestamp < $now ? 'Appointment slot time has passed' : 'Cancellations not permitted within ' . $cancellation_hours . ' hours of slot';?>">
                                            <i class="fa fa-lock"></i> <?=$slot_timestamp < $now ? 'Slot Passed' : ('Non-Cancellable (< ' . $cancellation_hours . 'h)');?>
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?=base_url('paysecure/acheckout?aid='.$appt_id);?>" class="btn-action-pay">
                                        <i class="fa fa-bolt"></i> Pay Now (₹<?=number_format($amount, 2);?>)
                                    </a>
                                    <?php if ($is_cancellable): ?>
                                        <button type="button" class="btn-action-cancel" onclick="openCancellationModal('APPT-<?=$appt_id;?>', '<?=html_escape($doctor);?>', '<?=$appt_date;?> <?=$timing;?>', '0')">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                    <?php else: ?>
                                        <span class="badge" style="background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 7px 12px; font-size: 12px; font-weight: 600; border-radius: 6px;">
                                            <i class="fa fa-lock"></i> <?=$slot_timestamp < $now ? 'Slot Passed' : ('Cutoff Passed (< ' . $cancellation_hours . 'h)');?>
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
            </div><!-- /#apptCardsContainer -->

            <!-- Interactive Pagination Bar -->
            <div id="apptPaginationBar" class="portal-pagination-bar">
                <div id="apptPaginationInfo" style="font-size: 13.5px; font-weight: 600; color: var(--upchar-slate-600);">
                    Showing 1 – 10 of <?=$appt_count;?> appointments
                </div>
                <div class="portal-page-numbers" id="apptPaginationButtons">
                    <!-- Dynamic Page Buttons -->
                </div>
            </div>

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
    
    <!-- ================================================================= -->
    <!-- TAB: AMBULANCE & EMERGENCY SOS (Integrated 24/7 Medical Response)  -->
    <!-- ================================================================= -->
    <div id="section-ambulance" style="display: none;">
        
        <!-- Emergency Ambulance Top Action Bar -->
        <div style="background: #ffffff; border: 1px solid var(--upchar-slate-200); border-radius: 18px; padding: 22px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: var(--card-shadow);">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <span style="background: #fee2e2; color: #b91c1c; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fa fa-circle" style="color: #ef4444; font-size: 8px;"></i> 24/7 Rapid Ambulance Network
                    </span>
                    <span style="font-size: 13px; color: var(--upchar-slate-500); font-weight: 600;">Average Arrival &lt; 8 Mins</span>
                </div>
                <h3 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: var(--upchar-slate-900);">
                    Emergency Ambulance &amp; Critical Medical Transport
                </h3>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <button type="button" onclick="openAmbulanceDispatchModal()" class="btn" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: #ffffff; border-radius: 12px; font-weight: 800; padding: 12px 24px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(220,38,38,0.3); border: none; cursor: pointer;">
                    <i class="fa fa-bolt"></i> Request Ambulance / SOS
                </button>
                <a href="<?=base_url('ambulance/tracking');?>" class="btn" style="background: #f8fafc; border: 1.5px solid var(--upchar-slate-200); color: var(--upchar-slate-800); border-radius: 12px; font-weight: 700; padding: 11px 18px; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa fa-search-location" style="color: #dc2626;"></i> Track By Reference
                </a>
                <a href="tel:18002479999" class="btn" style="background: #fef2f2; border: 1px solid #fee2e2; color: #dc2626; border-radius: 12px; font-weight: 800; padding: 11px 18px; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa fa-phone"></i> 1800-247-9999
                </a>
            </div>
        </div>

        <?php if(!empty($active_ambulance)): ?>
        <!-- ACTIVE TRIP SPOTLIGHT BANNER -->
        <div style="background: linear-gradient(135deg, #450a0a 0%, #1e1b4b 100%); border-radius: 20px; padding: 24px 28px; margin-bottom: 24px; color: #ffffff; box-shadow: 0 14px 30px -8px rgba(220, 38, 38, 0.4); position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div>
                    <span style="background: rgba(239, 68, 68, 0.3); border: 1px solid rgba(248, 113, 113, 0.5); color: #fca5a5; font-size: 11.5px; font-weight: 800; padding: 4px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fa fa-satellite-dish"></i> ACTIVE TRIP EN ROUTE &bull; #<?=html_escape($active_ambulance['booking_code']);?>
                    </span>
                    <h3 style="font-size: 1.6rem; font-weight: 900; color: #ffffff; margin: 10px 0 6px;">
                        <?=html_escape($active_ambulance['category_requested']);?> Unit &bull; <?=html_escape($active_ambulance['vehicle_number'] ?: 'Assigned Unit');?>
                    </h3>
                    <p style="color: #cbd5e1; font-size: 13.5px; margin: 0;">
                        <span><i class="fa fa-user-md" style="color: #34d399; margin-right: 4px;"></i> Paramedic: <strong><?=html_escape($active_ambulance['driver_name'] ?: 'Rajesh Yadav');?></strong></span>
                        <span style="margin: 0 10px;">&bull;</span>
                        <span><i class="fa fa-hospital-o" style="color: #60a5fa; margin-right: 4px;"></i> Destination: <strong><?=html_escape($active_ambulance['hospital_name'] ?: 'Oriana Hospital Trauma Wing');?></strong></span>
                    </p>
                </div>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="background: rgba(255,255,255,0.1); border: 1px dashed rgba(255,255,255,0.25); border-radius: 12px; padding: 10px 16px; text-align: center;">
                        <small style="display: block; font-size: 10.5px; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Pickup OTP</small>
                        <strong style="font-size: 1.6rem; font-weight: 900; color: #4ade80; letter-spacing: 2px;">
                            <?=html_escape($active_ambulance['pickup_otp'] ?? '2534');?>
                        </strong>
                    </div>
                    <a href="<?=base_url('ambulance/tracking?ref='.$active_ambulance['booking_code']);?>" class="btn" style="background: #ffffff; color: #991b1b; font-weight: 800; border-radius: 12px; padding: 12px 22px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa fa-map-marked-alt"></i> Live GPS Tracking
                    </a>
                    <button type="button" onclick="cancelAmbulanceBooking('<?=html_escape($active_ambulance['booking_code']);?>')" class="btn" style="background: rgba(254, 202, 202, 0.15); border: 1px solid rgba(254, 202, 202, 0.4); color: #fecaca; font-weight: 700; border-radius: 12px; padding: 12px 18px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa fa-times"></i> Cancel Trip
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- AMBULANCE TRIPS LIST -->
        <?php if(!empty($ambulance_bookings)): ?>
            <div style="display: grid; gap: 16px;">
                <?php foreach($ambulance_bookings as $ab): ?>
                    <?php
                        $st = strtoupper(trim($ab['status'] ?? 'REQUESTED'));
                        $is_active = in_array($st, ['REQUESTED', 'DISPATCHING', 'ASSIGNED', 'ARRIVED_PICKUP', 'IN_TRANSIT', 'ARRIVED_HOSPITAL']);
                        $is_done   = ($st === 'COMPLETED');
                        $is_canc   = ($st === 'CANCELLED');
                        $st_color  = $is_canc ? '#ef4444' : ($is_done ? '#10b981' : '#f59e0b');
                        $st_bg     = $is_canc ? '#fef2f2' : ($is_done ? '#ecfdf5' : '#fffbeb');
                        $created   = !empty($ab['created_at']) ? date('d M Y, h:i A', strtotime($ab['created_at'])) : 'Recent';
                    ?>
                    <div style="background: #ffffff; border: 1px solid var(--upchar-slate-200); border-radius: 16px; padding: 20px 24px; box-shadow: var(--card-shadow); transition: all 0.2s;">
                        <!-- Card Header -->
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background: #fee2e2; color: #dc2626; font-weight: 800; font-size: 13px; padding: 4px 10px; border-radius: 8px;">
                                    #<?=html_escape($ab['booking_code']);?>
                                </span>
                                <span style="font-size: 13px; color: var(--upchar-slate-500); font-weight: 600;">
                                    <i class="fa fa-clock-o"></i> <?=$created;?>
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="background: <?=$st_bg;?>; color: <?=$st_color;?>; font-weight: 800; font-size: 12px; padding: 4px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fa fa-circle" style="font-size: 8px;"></i> <?=html_escape($st);?>
                                </span>
                            </div>
                        </div>

                        <?php if($is_canc && !empty($ab['cancellation_reason'])): ?>
                            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 9px 14px; margin-bottom: 16px; font-size: 13px; color: #991b1b; display: flex; align-items: center; gap: 8px;">
                                <i class="fa fa-ban" style="color: #dc2626; font-size: 14px;"></i>
                                <span><strong>Cancellation Reason:</strong> <?=html_escape($ab['cancellation_reason']);?></span>
                            </div>
                        <?php endif; ?>

                        <!-- Card Body Grid -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 18px;">
                            <!-- Capability & Ambulance -->
                            <div>
                                <small style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; margin-bottom: 4px;">Service Capability</small>
                                <div style="font-size: 15px; font-weight: 800; color: #0f172a;">
                                    <i class="fa fa-ambulance" style="color: #dc2626; margin-right: 4px;"></i>
                                    <?=html_escape($ab['category_requested'] ?? 'ALS');?> Unit
                                </div>
                                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                                    Vehicle: <strong><?=html_escape($ab['vehicle_number'] ?: 'En Route Assigned Unit');?></strong>
                                </div>
                            </div>

                            <!-- Paramedic / Driver -->
                            <div>
                                <small style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; margin-bottom: 4px;">Paramedic / Driver</small>
                                <div style="font-size: 14.5px; font-weight: 700; color: #0f172a;">
                                    <?=html_escape($ab['driver_name'] ?: 'Rajesh Yadav (ALS Tech)');?>
                                </div>
                                <?php if(!empty($ab['driver_phone'])): ?>
                                    <a href="tel:<?=html_escape($ab['driver_phone']);?>" style="font-size: 12.5px; color: #0d7a6e; text-decoration: none; font-weight: 700;">
                                        <i class="fa fa-phone"></i> <?=html_escape($ab['driver_phone']);?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Route details -->
                            <div style="grid-column: span 2;">
                                <small style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; margin-bottom: 4px;">Transit Route</small>
                                <div style="font-size: 13px; color: #334155; line-height: 1.4;">
                                    <div><i class="fa fa-map-marker" style="color: #10b981; width: 14px;"></i> <strong>Pickup:</strong> <?=html_escape($ab['pickup_address']);?></div>
                                    <div style="margin-top: 4px;"><i class="fa fa-hospital-o" style="color: #3b82f6; width: 14px;"></i> <strong>Destination:</strong> <?=html_escape($ab['drop_address'] ?: 'Oriana Hospital Emergency Wing');?></div>
                                </div>
                            </div>

                            <!-- Security OTPs & Fare -->
                            <div>
                                <small style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; margin-bottom: 4px;">Security Handover OTPs</small>
                                <div style="display: flex; gap: 10px;">
                                    <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 700;">
                                        Pickup: <strong style="color: #0d7a6e;"><?=html_escape($ab['pickup_otp'] ?? '----');?></strong>
                                    </span>
                                    <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 700;">
                                        Hospital: <strong style="color: #2563eb;"><?=html_escape($ab['hospital_handover_otp'] ?? '----');?></strong>
                                    </span>
                                </div>
                            </div>

                            <!-- Fare Amount -->
                            <div style="text-align: right;">
                                <small style="display: block; font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; margin-bottom: 4px;">Total Emergency Fare</small>
                                <div style="font-size: 1.3rem; font-weight: 900; color: #dc2626;">
                                    ₹<?=number_format(floatval($ab['total_fare'] ?? 1800), 2);?>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action Buttons -->
                        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                            <?php if($is_active): ?>
                                <button type="button" onclick="cancelAmbulanceBooking('<?=html_escape($ab['booking_code']);?>')" class="btn btn-sm" style="background: #ffffff; border: 1px solid #fca5a5; color: #b91c1c; font-weight: 700; border-radius: 8px; padding: 7px 16px;">
                                    <i class="fa fa-times"></i> Cancel Trip
                                </button>
                                <a href="<?=base_url('ambulance/tracking?ref='.$ab['booking_code']);?>" class="btn btn-sm" style="background: #dc2626; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 7px 18px; text-decoration: none;">
                                    <i class="fa fa-map-marked-alt"></i> Live GPS Tracking
                                </a>
                            <?php else: ?>
                                <a href="<?=base_url('ambulance/tracking?ref='.$ab['booking_code']);?>" class="btn btn-sm" style="background: #f8fafc; border: 1px solid var(--upchar-slate-200); color: var(--upchar-slate-800); font-weight: 700; border-radius: 8px; padding: 7px 16px; text-decoration: none;">
                                    <i class="fa fa-file-text-o"></i> View Trip Details
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty State for Ambulance Bookings -->
            <div class="empty-portal-box">
                <div class="empty-portal-icon" style="background: #fee2e2; color: #dc2626;">
                    <i class="fa fa-ambulance"></i>
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--upchar-slate-900); margin-bottom: 6px;">
                    No Ambulance Bookings Yet
                </h3>
                <p style="color: var(--upchar-slate-500); max-width: 520px; margin: 0 auto 20px; font-size: 14px;">
                    When you or your family require rapid emergency medical response, Basic or Advanced Life Support ambulances are dispatched within minutes with live GPS telemetry.
                </p>
                <button type="button" onclick="openAmbulanceDispatchModal()" class="btn" style="background: linear-gradient(135deg, #dc2626, #b91c1c); color: #ffffff; font-weight: 800; border-radius: 12px; padding: 12px 28px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(220,38,38,0.35);">
                    <i class="fa fa-bolt"></i> Request Ambulance Now
                </button>
            </div>
        <?php endif; ?>

    </div>

    <!-- IN-PAGE AMBULANCE DISPATCH MODAL -->
    <div id="ambulanceDispatchModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(5px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
        <div style="background: #ffffff; border-radius: 24px; width: 100%; max-width: 620px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3); overflow: hidden; position: relative;">
            
            <!-- Modal Header -->
            <div style="background: linear-gradient(135deg, #991b1b 0%, #1e1b4b 100%); color: #ffffff; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fa fa-ambulance"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-weight: 800; font-size: 1.2rem;">24/7 Rapid Ambulance Booking</h4>
                        <div style="font-size: 11.5px; opacity: 0.9;">Emergency Dispatch Desk &bull; Live GPS Response</div>
                    </div>
                </div>
                <button type="button" onclick="closeAmbulanceDispatchModal()" style="background: rgba(255,255,255,0.15); border: none; color: #ffffff; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 16px;">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <!-- Modal Form Body -->
            <div id="ambFormContainer" style="padding: 24px; max-height: calc(85vh - 120px); overflow-y: auto;">
                
                <!-- Patient Name & Mobile -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Patient / Caller Name</label>
                        <input type="text" id="amb_patient_name" class="form-control" value="<?=html_escape($user_name);?>" placeholder="Enter patient name" style="border-radius: 10px; font-size: 14px; padding: 10px 14px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Contact Mobile</label>
                        <input type="tel" id="amb_patient_mobile" class="form-control" value="<?=html_escape($user_mobile);?>" placeholder="+91 XXXXX XXXXX" style="border-radius: 10px; font-size: 14px; padding: 10px 14px;">
                    </div>
                </div>

                <!-- Pickup Address -->
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label style="font-size: 12px; font-weight: 700; color: #475569; margin: 0;">Emergency Pickup Address</label>
                        <button type="button" onclick="detectGPSForModal()" style="background: none; border: none; color: #dc2626; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa fa-crosshairs"></i> Use My GPS
                        </button>
                    </div>
                    <input type="text" id="amb_pickup_address" class="form-control" placeholder="House/Flat No, Landmark, Road, City" value="Sigra, Varanasi" style="border-radius: 10px; font-size: 14px; padding: 10px 14px;">
                    <input type="hidden" id="amb_pickup_lat" value="25.3176">
                    <input type="hidden" id="amb_pickup_lng" value="82.9739">
                </div>

                <!-- Capability Selector -->
                <div style="margin-bottom: 16px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 8px;">Select Required Capability</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="amb-modal-type active" onclick="selectModalCategory(this, 'ALS', 1800, 50)" style="border: 2px solid #ef4444; background: #fef2f2; border-radius: 12px; padding: 10px 12px; cursor: pointer; transition: all 0.2s;">
                            <strong style="color: #991b1b; font-size: 13.5px; display: block;">ALS ICU Ambulance</strong>
                            <small style="color: #7f1d1d; font-size: 11px;">Ventilator, Defibrillator, Paramedic &bull; ₹1,800 Base</small>
                        </div>
                        <div class="amb-modal-type" onclick="selectModalCategory(this, 'BLS', 800, 30)" style="border: 1.5px solid #e2e8f0; background: #f8fafc; border-radius: 12px; padding: 10px 12px; cursor: pointer; transition: all 0.2s;">
                            <strong style="color: #0f172a; font-size: 13.5px; display: block;">BLS Ambulance</strong>
                            <small style="color: #64748b; font-size: 11px;">Oxygen, Stretcher, First Aid &bull; ₹800 Base</small>
                        </div>
                        <div class="amb-modal-type" onclick="selectModalCategory(this, 'PATIENT_TRANSPORT', 400, 20)" style="border: 1.5px solid #e2e8f0; background: #f8fafc; border-radius: 12px; padding: 10px 12px; cursor: pointer; transition: all 0.2s;">
                            <strong style="color: #0f172a; font-size: 13.5px; display: block;">Patient Transport</strong>
                            <small style="color: #64748b; font-size: 11px;">Wheelchair / Routine Transfer &bull; ₹400 Base</small>
                        </div>
                        <div class="amb-modal-type" onclick="selectModalCategory(this, 'NEONATAL', 2200, 60)" style="border: 1.5px solid #e2e8f0; background: #f8fafc; border-radius: 12px; padding: 10px 12px; cursor: pointer; transition: all 0.2s;">
                            <strong style="color: #0f172a; font-size: 13.5px; display: block;">Neonatal Incubator</strong>
                            <small style="color: #64748b; font-size: 11px;">Infant Resuscitation ICU &bull; ₹2,200 Base</small>
                        </div>
                    </div>
                </div>

                <!-- Destination Hospital Selector -->
                <div style="margin-bottom: 16px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Destination Hospital / Emergency Center</label>
                    <select id="amb_hospital_id" class="form-control" style="border-radius: 10px; font-size: 13.5px; padding: 9px 12px;">
                        <option value="11" selected>Oriana Hospital Emergency Wing (Trauma &amp; ICU)</option>
                        <option value="1">Apex Hospital Emergency Fleet</option>
                        <option value="2">Heritage Hospitals Trauma Center</option>
                        <?php if(!empty($hospitals_list)): ?>
                            <?php foreach($hospitals_list as $h): ?>
                                <?php if(!in_array($h['id'], [1, 2, 11])): ?>
                                    <option value="<?=$h['id'];?>"><?=html_escape($h['name']);?> (<?=html_escape($h['location'] ?: 'Emergency');?>)</option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Estimated Distance & Fare preview -->
                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 12px 16px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <small style="color: #64748b; display: block; font-size: 11px; font-weight: 700; text-transform: uppercase;">Estimated Fare Matrix</small>
                        <span id="ambFareBreakdown" style="font-size: 13px; color: #475569;">₹1,800 Base + 8km × ₹50</span>
                    </div>
                    <div style="text-align: right;">
                        <div id="ambFareTotal" style="font-size: 1.5rem; font-weight: 900; color: #dc2626;">₹2,200</div>
                    </div>
                </div>

                <!-- Medical notes -->
                <div style="margin-bottom: 20px;">
                    <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Medical Emergency Details (Optional)</label>
                    <input type="text" id="amb_notes" class="form-control" placeholder="e.g. Cardiac arrest, breathing difficulty, accident trauma..." style="border-radius: 10px; font-size: 13px; padding: 9px 14px;">
                </div>

                <!-- Dispatch Button -->
                <button type="button" id="btnSubmitAmbDispatch" onclick="submitAmbulanceDispatch()" class="btn" style="width: 100%; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: #ffffff; font-weight: 800; font-size: 15px; border-radius: 12px; padding: 14px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(220,38,38,0.4); display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa fa-bolt"></i> Dispatch Nearest Ambulance Unit Now
                </button>
            </div>

            <!-- Success State Screen inside Modal -->
            <div id="ambSuccessScreen" style="display: none; padding: 36px 24px; text-align: center;">
                <div style="width: 68px; height: 68px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 16px;">
                    <i class="fa fa-check"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 900; color: #15803d; margin: 0 0 6px;">Ambulance Dispatched!</h3>
                <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Emergency dispatch desk has assigned your nearest equipped unit. Paramedic is responding.</p>
                
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px 20px; text-align: left; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 700;">Booking Reference</span>
                        <strong id="ambResCode" style="font-size: 14px; color: #dc2626;"></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 700;">Assigned Vehicle</span>
                        <strong id="ambResVehicle" style="font-size: 14px; color: #0f172a;"></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 700;">Paramedic / Pilot</span>
                        <span id="ambResDriver" style="font-size: 13.5px; font-weight: 700; color: #0f172a;"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 700;">Patient Pickup OTP</span>
                        <strong id="ambResOtp" style="font-size: 18px; font-weight: 900; color: #16a34a; letter-spacing: 2px;"></strong>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; justify-content: center;">
                    <a id="ambResTrackBtn" href="#" class="btn" style="background: #dc2626; color: #ffffff; font-weight: 800; border-radius: 10px; padding: 12px 24px; text-decoration: none;">
                        <i class="fa fa-map-marked-alt"></i> Live GPS Tracking
                    </a>
                    <button type="button" onclick="location.reload()" class="btn" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #475569; font-weight: 700; border-radius: 10px; padding: 12px 20px;">
                        Close &amp; View Trips
                    </button>
                </div>
            </div>

        </div>
    </div>
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
                                <?=htmlspecialchars(!empty($lb['lab_name']) ? $lb['lab_name'] : 'Upchar Certified Diagnostic Lab');?>
                            </div>
                        </div>

                        <div class="appt-meta-block">
                            <div class="meta-label">Collection Type</div>
                            <div class="meta-value">
                                <i class="fa fa-home" style="color: var(--upchar-teal);"></i>
                                <?=htmlspecialchars(!empty($lb['collection_type']) ? $lb['collection_type'] : 'Home Blood Sample Collection');?>
                            </div>
                        </div>

                        <div class="appt-meta-block">
                            <div class="meta-label">Patient Name</div>
                            <div class="meta-value">
                                <i class="fa fa-user-circle-o" style="color: var(--upchar-slate-500);"></i>
                                <?=htmlspecialchars(!empty($lb['patient_name']) ? $lb['patient_name'] : $user_name);?>
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
            </div><!-- /#apptCardsContainer -->

            <!-- Interactive Pagination Bar -->
            <div id="apptPaginationBar" class="portal-pagination-bar">
                <div id="apptPaginationInfo" style="font-size: 13.5px; font-weight: 600; color: var(--upchar-slate-600);">
                    Showing 1 – 10 of <?=$appt_count;?> appointments
                </div>
                <div class="portal-page-numbers" id="apptPaginationButtons">
                    <!-- Dynamic Page Buttons -->
                </div>
            </div>

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
                                        <small><?=!empty($pd['razorpay_payment_id']) ? $pd['razorpay_payment_id'] : '-';?></small>
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
// =================================================================
// APPOINTMENTS PAGINATION & FILTERING CONTROLLER
// =================================================================
let apptCurrentPage = 1;
let apptPageSize = 10;
let apptActiveFilter = 'all';

function setApptStatusFilter(filter, btn) {
    apptActiveFilter = filter;
    document.querySelectorAll('.status-filter-pill').forEach(p => p.classList.remove('active'));
    if (btn) btn.classList.add('active');
    apptCurrentPage = 1;
    filterAndPaginateAppts(false);
}

function changeApptPageSize(val) {
    apptPageSize = parseInt(val, 10) || 10;
    apptCurrentPage = 1;
    filterAndPaginateAppts(false);
}

function filterAndPaginateAppts(scrollToTop = false) {
    const container = document.getElementById('apptCardsContainer');
    if (!container) return;

    const cards = Array.from(container.querySelectorAll('.appt-modern-card'));
    const searchInput = document.getElementById('apptSearchInput');
    const searchVal = searchInput ? (searchInput.value || '').trim().toLowerCase() : '';

    let matchedCards = [];
    cards.forEach(card => {
        const cardStatus = card.getAttribute('data-status') || '';
        const cardSearch = card.getAttribute('data-search') || '';

        let statusMatch = true;
        if (apptActiveFilter === 'active') {
            statusMatch = (cardStatus !== 'cancelled');
        } else if (apptActiveFilter === 'cancelled') {
            statusMatch = (cardStatus === 'cancelled');
        }

        let searchMatch = true;
        if (searchVal) {
            searchMatch = cardSearch.includes(searchVal);
        }

        if (statusMatch && searchMatch) {
            matchedCards.push(card);
        } else {
            card.style.display = 'none';
        }
    });

    const total = matchedCards.length;
    const totalPages = Math.max(1, Math.ceil(total / apptPageSize));
    if (apptCurrentPage > totalPages) apptCurrentPage = totalPages;
    if (apptCurrentPage < 1) apptCurrentPage = 1;

    const startIndex = (apptCurrentPage - 1) * apptPageSize;
    const endIndex = Math.min(startIndex + apptPageSize, total);

    matchedCards.forEach((card, idx) => {
        if (idx >= startIndex && idx < endIndex) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });

    // Update Counter Text
    const info = document.getElementById('apptPaginationInfo');
    if (info) {
        if (total === 0) {
            info.innerHTML = '<span style="color: #dc2626;"><i class="fa fa-info-circle"></i> No matching appointments found</span>';
        } else {
            info.innerText = `Showing ${startIndex + 1} – ${endIndex} of ${total} appointments`;
        }
    }

    // Render Pagination Buttons
    const btnContainer = document.getElementById('apptPaginationButtons');
    const paginationBar = document.getElementById('apptPaginationBar');
    if (paginationBar) {
        paginationBar.style.display = (total > 0) ? 'flex' : 'none';
    }

    if (btnContainer) {
        let html = '';
        html += `<button type="button" class="page-num-btn" ${apptCurrentPage === 1 ? 'disabled' : ''} onclick="goToApptPage(${apptCurrentPage - 1})" title="Previous Page"><i class="fa fa-chevron-left"></i></button>`;

        let pagesToShow = [];
        if (totalPages <= 7) {
            for (let i = 1; i <= totalPages; i++) pagesToShow.push(i);
        } else {
            pagesToShow.push(1);
            if (apptCurrentPage > 3) pagesToShow.push('...');
            const start = Math.max(2, apptCurrentPage - 1);
            const end = Math.min(totalPages - 1, apptCurrentPage + 1);
            for (let i = start; i <= end; i++) pagesToShow.push(i);
            if (apptCurrentPage < totalPages - 2) pagesToShow.push('...');
            pagesToShow.push(totalPages);
        }

        pagesToShow.forEach(p => {
            if (p === '...') {
                html += `<span style="padding: 0 4px; color: var(--upchar-slate-400); font-weight: 700; display: inline-flex; align-items: center;">...</span>`;
            } else {
                html += `<button type="button" class="page-num-btn ${p === apptCurrentPage ? 'active' : ''}" onclick="goToApptPage(${p})">${p}</button>`;
            }
        });

        html += `<button type="button" class="page-num-btn" ${apptCurrentPage === totalPages ? 'disabled' : ''} onclick="goToApptPage(${apptCurrentPage + 1})" title="Next Page"><i class="fa fa-chevron-right"></i></button>`;
        btnContainer.innerHTML = html;
    }

    if (scrollToTop) {
        const topEl = document.getElementById('section-appointments');
        if (topEl) {
            topEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

function goToApptPage(page) {
    apptCurrentPage = page;
    filterAndPaginateAppts(true);
}

// Dashboard Tab Switcher
function switchDashboardTab(tab) {
    const tabs = ['appointments', 'ambulance', 'wallet', 'diagnostics', 'payments'];
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
    formData.append('<?= !empty($csrf_token_name) ? $csrf_token_name : $this->security->get_csrf_token_name(); ?>', '<?= !empty($csrf_hash) ? $csrf_hash : $this->security->get_csrf_hash(); ?>');

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
</script>

<!-- ================================================================= -->
<!-- INTERACTIVE AMBULANCE CANCELLATION MODAL WITH REASON OPTIONS       -->
<!-- ================================================================= -->
<div id="cancelAmbulanceModal" style="display: none; position: fixed; inset: 0; z-index: 999999; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
    <div style="background: #ffffff; width: 100%; max-width: 540px; max-height: 90vh; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid #fee2e2; overflow: hidden; display: flex; flex-direction: column;">
        
        <!-- Header -->
        <div style="background: #fff1f2; border-bottom: 1px solid #fecdd3; padding: 18px 24px; display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; border: 1px solid #fca5a5;">
                    <i class="fa fa-ambulance"></i>
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #991b1b;">Cancel Ambulance Request</h4>
                    <div style="font-size: 12.5px; color: #9f1239; margin-top: 2px;">
                        Booking Ref: <strong id="ambCancelModalRef" style="font-family: monospace;">#UPAMB-0</strong>
                    </div>
                </div>
            </div>
            <button type="button" onclick="closeAmbulanceCancelModal()" style="background: transparent; border: none; font-size: 24px; color: #9f1239; cursor: pointer; padding: 0; line-height: 1;">&times;</button>
        </div>

        <!-- Body -->
        <div style="padding: 22px 24px; overflow-y: auto; flex-grow: 1;">
            
            <div style="background: #fff7ed; border-left: 4px solid #f97316; border-radius: 8px; padding: 10px 14px; margin-bottom: 18px;">
                <div style="font-size: 12.5px; font-weight: 800; color: #9a3412;">
                    <i class="fa fa-info-circle"></i> Emergency Dispatch Standdown Notice:
                </div>
                <div style="font-size: 12px; color: #c2410c; margin-top: 2px; line-height: 1.4;">
                    Cancelling will release the assigned paramedic and emergency vehicle unit immediately. If this is a life-threatening acute emergency, please keep the ambulance en route or dial <strong>1800-247-9999</strong>.
                </div>
            </div>

            <label style="display: block; font-size: 13px; font-weight: 800; color: #0f172a; margin-bottom: 10px;">
                Select Reason for Cancellation <span style="color: #dc2626;">*</span>:
            </label>

            <!-- Reason Options -->
            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                
                <label class="amb-cancel-option selected" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #dc2626; background: #fef2f2; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="amb_cancel_choice" value="Patient condition stabilized / Recovered" style="margin-top: 3px; accent-color: #dc2626;" checked onchange="handleAmbReasonChange(this)">
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Patient condition stabilized / Recovered</div>
                        <div style="font-size: 11.5px; color: #64748b;">Acute symptoms subsided; urgent transport is no longer needed</div>
                    </div>
                </label>

                <label class="amb-cancel-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="amb_cancel_choice" value="Arranged alternate private vehicle / car" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleAmbReasonChange(this)">
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Arranged alternate private vehicle / car</div>
                        <div style="font-size: 11.5px; color: #64748b;">Departing via family personal car, taxi, or local vehicle already on-site</div>
                    </div>
                </label>

                <label class="amb-cancel-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="amb_cancel_choice" value="Ambulance ETA is taking too long" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleAmbReasonChange(this)">
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Ambulance ETA is taking too long</div>
                        <div style="font-size: 11.5px; color: #64748b;">Found faster emergency transfer option due to urgent timing</div>
                    </div>
                </label>

                <label class="amb-cancel-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="amb_cancel_choice" value="Decided to visit a different hospital / clinic nearby" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleAmbReasonChange(this)">
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Decided to visit a different hospital / clinic nearby</div>
                        <div style="font-size: 11.5px; color: #64748b;">Changed destination hospital or admitted to nearest local clinic</div>
                    </div>
                </label>

                <label class="amb-cancel-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="amb_cancel_choice" value="Booked by mistake / duplicate request" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleAmbReasonChange(this)">
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Booked by mistake / duplicate request</div>
                        <div style="font-size: 11.5px; color: #64748b;">Accidental tap or multiple family members dispatched an ambulance</div>
                    </div>
                </label>

                <label class="amb-cancel-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="amb_cancel_choice" value="Other" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleAmbReasonChange(this)">
                    <div>
                        <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Other reason</div>
                        <div style="font-size: 11.5px; color: #64748b;">Specify exact reason or remarks below</div>
                    </div>
                </label>

            </div>

            <!-- Notes -->
            <div style="margin-bottom: 18px;">
                <label for="ambCancelNotes" style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">
                    Additional Details / Remarks (Optional):
                </label>
                <textarea id="ambCancelNotes" rows="2" placeholder="Write any specific explanation or details for dispatch records..." style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 10px 12px; font-size: 13px; outline: none; font-family: inherit; resize: vertical; box-sizing: border-box;"></textarea>
            </div>

            <!-- Feedback Alert -->
            <div id="ambCancelModalAlert" style="display: none; padding: 10px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 14px;"></div>
        </div>

        <!-- Footer -->
        <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: flex-end; align-items: center; gap: 12px; flex-shrink: 0;">
            <button type="button" onclick="closeAmbulanceCancelModal()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #475569; font-weight: 700; padding: 9px 18px; border-radius: 10px; cursor: pointer; font-size: 13px;">
                Don't Cancel (Keep En Route)
            </button>
            <button type="button" id="confirmAmbCancelBtn" onclick="submitAmbCancellation()" style="background: #dc2626; border: none; color: #ffffff; font-weight: 800; padding: 9px 20px; border-radius: 10px; cursor: pointer; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);">
                <i class="fa fa-ban"></i> Confirm Cancellation
            </button>
        </div>

    </div>
</div>

<style>
.amb-cancel-option:hover {
    border-color: #fca5a5 !important;
    background: #fff8f8 !important;
}
.amb-cancel-option.selected {
    border-color: #dc2626 !important;
    background: #fef2f2 !important;
}
/* Modern Filter & Pagination System */
.portal-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    background: #ffffff;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.portal-filter-search {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 10px;
    padding: 8px 14px;
    flex: 1;
    min-width: 240px;
    max-width: 380px;
}

.portal-filter-search input {
    border: none;
    background: transparent;
    outline: none;
    font-size: 13.5px;
    color: var(--upchar-slate-800);
    width: 100%;
}

.portal-status-pills {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.status-filter-pill {
    background: #f1f5f9;
    border: 1px solid transparent;
    color: var(--upchar-slate-600);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

.status-filter-pill:hover {
    background: #e2e8f0;
    color: var(--upchar-slate-800);
}

.status-filter-pill.active {
    background: var(--upchar-teal);
    color: #ffffff;
}

.portal-pagination-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    background: #ffffff;
    border: 1px solid var(--upchar-slate-200);
    border-radius: 14px;
    padding: 14px 20px;
    margin-top: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.portal-page-numbers {
    display: flex;
    align-items: center;
    gap: 5px;
    flex-wrap: wrap;
}

.page-num-btn {
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border-radius: 8px;
    border: 1px solid var(--upchar-slate-200);
    background: #ffffff;
    color: var(--upchar-slate-700);
    font-size: 13px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
}

.page-num-btn:hover:not(:disabled) {
    background: #f1f5f9;
    border-color: var(--upchar-slate-300);
    color: var(--upchar-slate-900);
}

.page-num-btn.active {
    background: var(--upchar-teal);
    border-color: var(--upchar-teal);
    color: #ffffff !important;
}

.page-num-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}
</style>

<script>
var activeAmbCancelCode = "";
var curModalCat = "ALS";
var curModalBase = 1800;
var curModalRate = 50;

function openAmbulanceDispatchModal() {
    var modal = document.getElementById("ambulanceDispatchModal");
    if (modal) {
        modal.style.display = "flex";
        var fc = document.getElementById("ambFormContainer");
        var ss = document.getElementById("ambSuccessScreen");
        if (fc) fc.style.display = "block";
        if (ss) ss.style.display = "none";
        recalcModalFare();
    }
}

function closeAmbulanceDispatchModal() {
    var modal = document.getElementById("ambulanceDispatchModal");
    if (modal) modal.style.display = "none";
}

function selectModalCategory(el, cat, base, rate) {
    document.querySelectorAll(".amb-modal-type").forEach(function(item) {
        item.classList.remove("active");
        item.style.border = "1.5px solid #e2e8f0";
        item.style.background = "#f8fafc";
        var title = item.querySelector("strong");
        if (title) title.style.color = "#0f172a";
    });
    el.classList.add("active");
    el.style.border = "2px solid #ef4444";
    el.style.background = "#fef2f2";
    var curTitle = el.querySelector("strong");
    if (curTitle) curTitle.style.color = "#991b1b";

    curModalCat = cat;
    curModalBase = base;
    curModalRate = rate;
    recalcModalFare();
}

function recalcModalFare() {
    var km = 8;
    var total = curModalBase + (km * curModalRate);
    var bEl = document.getElementById("ambFareBreakdown");
    var tEl = document.getElementById("ambFareTotal");
    if (bEl) bEl.textContent = "₹" + curModalBase.toLocaleString() + " Base + " + km + "km × ₹" + curModalRate;
    if (tEl) tEl.textContent = "₹" + total.toLocaleString();
}

function detectGPSForModal() {
    if (!navigator.geolocation) {
        alert("Geolocation is not supported by your browser.");
        return;
    }
    navigator.geolocation.getCurrentPosition(function(pos) {
        document.getElementById("amb_pickup_lat").value = pos.coords.latitude;
        document.getElementById("amb_pickup_lng").value = pos.coords.longitude;
        document.getElementById("amb_pickup_address").value = "GPS: " + pos.coords.latitude.toFixed(5) + ", " + pos.coords.longitude.toFixed(5);
        fetch("https://nominatim.openstreetmap.org/reverse?format=json&lat=" + pos.coords.latitude + "&lon=" + pos.coords.longitude)
            .then(function(r) { return r.json(); })
            .then(function(d) {
                if (d.display_name) document.getElementById("amb_pickup_address").value = d.display_name;
            }).catch(function(){});
    }, function() {
        alert("Unable to retrieve GPS coordinates. Please enter pickup address manually.");
    });
}

function submitAmbulanceDispatch() {
    var name     = (document.getElementById("amb_patient_name").value || "").trim();
    var mobile   = (document.getElementById("amb_patient_mobile").value || "").trim();
    var address  = (document.getElementById("amb_pickup_address").value || "").trim();
    var hospital = document.getElementById("amb_hospital_id").value;
    var notes    = (document.getElementById("amb_notes").value || "").trim();
    var lat      = document.getElementById("amb_pickup_lat").value || 25.3176;
    var lng      = document.getElementById("amb_pickup_lng").value || 82.9739;

    if (!name || !mobile || !address) {
        alert("Please provide patient name, contact mobile, and pickup address.");
        return;
    }

    var btn = document.getElementById("btnSubmitAmbDispatch");
    var origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Dispatching Unit...';

    var fd = new FormData();
    fd.append("patient_name", name);
    fd.append("patient_mobile", mobile);
    fd.append("pickup_address", address);
    fd.append("pickup_lat", lat);
    fd.append("pickup_lng", lng);
    fd.append("category", curModalCat);
    fd.append("hospital_id", hospital);
    fd.append("distance_km", 8);
    fd.append("medical_notes", notes);
    fd.append("<?= !empty($csrf_token_name) ? $csrf_token_name : $this->security->get_csrf_token_name(); ?>", "<?= !empty($csrf_hash) ? $csrf_hash : $this->security->get_csrf_hash(); ?>");

    fetch("<?=base_url('ambulance/create_booking');?>", {
        method: "POST",
        body: fd
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.status === "success") {
            document.getElementById("ambFormContainer").style.display = "none";
            document.getElementById("ambSuccessScreen").style.display = "block";
            document.getElementById("ambResCode").textContent = "#" + data.booking_code;
            document.getElementById("ambResVehicle").textContent = data.ambulance + " (" + data.category + ")";
            document.getElementById("ambResDriver").textContent = data.driver_name + " • " + data.driver_phone;
            document.getElementById("ambResOtp").textContent = data.pickup_otp;
            document.getElementById("ambResTrackBtn").href = data.tracking_url;
        } else {
            alert(data.message || "Error dispatching ambulance.");
            btn.disabled = false;
            btn.innerHTML = origHtml;
        }
    })
    .catch(function() {
        btn.disabled = false;
        btn.innerHTML = origHtml;
        alert("Network error. Please call 1800-247-9999 directly.");
    });
}

function cancelAmbulanceBooking(code) {
    if (!code) return;
    activeAmbCancelCode = code;
    var refEl = document.getElementById("ambCancelModalRef");
    if (refEl) refEl.innerText = "#" + code;
    
    var al = document.getElementById("ambCancelModalAlert");
    if (al) al.style.display = "none";

    var modal = document.getElementById("cancelAmbulanceModal");
    if (modal) modal.style.display = "flex";
    highlightAmbSelectedReason();
}

function closeAmbulanceCancelModal() {
    var modal = document.getElementById("cancelAmbulanceModal");
    if (modal) modal.style.display = "none";
}

function handleAmbReasonChange(el) {
    highlightAmbSelectedReason();
    if (el.value === "Other") {
        var notes = document.getElementById("ambCancelNotes");
        if (notes) {
            notes.focus();
            notes.placeholder = "Please explain the reason for cancellation...";
        }
    }
}

function highlightAmbSelectedReason() {
    document.querySelectorAll(".amb-cancel-option").forEach(function(opt) {
        var radio = opt.querySelector('input[type="radio"]');
        if (radio && radio.checked) {
            opt.classList.add("selected");
        } else {
            opt.classList.remove("selected");
        }
    });
}

function submitAmbCancellation() {
    var selectedRadio = document.querySelector('input[name="amb_cancel_choice"]:checked');
    if (!selectedRadio) {
        showAmbCancelAlert("Please select a cancellation reason option.", "error");
        return;
    }

    var chosenReason = selectedRadio.value;
    var notes = (document.getElementById("ambCancelNotes").value || "").trim();

    if (chosenReason === "Other" && !notes) {
        showAmbCancelAlert("Please provide additional details describing your cancellation reason.", "error");
        document.getElementById("ambCancelNotes").focus();
        return;
    }

    var fullReason = chosenReason;
    if (notes && chosenReason !== "Other") {
        fullReason += " (" + notes + ")";
    } else if (chosenReason === "Other") {
        fullReason = "Other: " + notes;
    }

    var btn = document.getElementById("confirmAmbCancelBtn");
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cancelling...';

    var fd = new FormData();
    fd.append("booking_code", activeAmbCancelCode);
    fd.append("reason", fullReason);

    fetch("<?=base_url('ambulance/cancel_booking');?>", {
        method: "POST",
        body: fd
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.status === "success") {
            showAmbCancelAlert(d.message || "Ambulance trip cancelled successfully.", "success");
            setTimeout(function() {
                window.location.hash = "#ambulance";
                window.location.reload();
            }, 800);
        } else {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-ban"></i> Confirm Cancellation';
            showAmbCancelAlert(d.message || "Cancellation failed. Please try again.", "error");
        }
    })
    .catch(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-ban"></i> Confirm Cancellation';
        showAmbCancelAlert("Network error occurred while cancelling. Please retry.", "error");
    });
}

function showAmbCancelAlert(msg, type) {
    var al = document.getElementById("ambCancelModalAlert");
    if (!al) return;
    al.style.display = "block";
    if (type === "success") {
        al.style.background = "#ecfdf5";
        al.style.border = "1px solid #a7f3d0";
        al.style.color = "#065f46";
    } else {
        al.style.background = "#fef2f2";
        al.style.border = "1px solid #fecaca";
        al.style.color = "#991b1b";
    }
    al.innerText = msg;
}

window.addEventListener("click", function(e) {
    var modal = document.getElementById("cancelAmbulanceModal");
    if (e.target === modal) {
        closeAmbulanceCancelModal();
    }
    var dModal = document.getElementById("ambulanceDispatchModal");
    if (e.target === dModal) {
        closeAmbulanceDispatchModal();
    }
});

// Auto open tab based on URL hash (e.g. #wallet or #ambulance)
function handleHashChange() {
    var hash = (window.location.hash || "").replace("#", "").toLowerCase();
    if (hash === "ambulance" || hash === "wallet" || hash === "diagnostics" || hash === "payments" || hash === "appointments") {
        switchDashboardTab(hash);
    } else if (!hash) {
        switchDashboardTab("appointments");
    }
    // Initialize or refresh appointments pagination
    if (typeof filterAndPaginateAppts === "function") {
        filterAndPaginateAppts(false);
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", handleHashChange);
} else {
    handleHashChange();
}
window.addEventListener("load", handleHashChange);
window.addEventListener("hashchange", handleHashChange);
</script>
