<?php defined("BASEPATH") OR exit("No direct script access allowed"); ?>

<!-- =========================================================
     UPCHAR AMBULANCE SERVICES - REDESIGNED PREMIUM LANDING
     ========================================================= -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* CSS Variables for Upchar Ambulance Theme */
:root {
    --amb-navy: #0b132b;
    --amb-navy-card: #111e38;
    --amb-navy-border: #1e293b;
    --amb-red: #dc2626;
    --amb-red-dark: #b91c1c;
    --amb-red-light: #fee2e2;
    --amb-red-glow: rgba(220, 38, 38, 0.45);
    --amb-amber: #f59e0b;
    --amb-emerald: #10b981;
    --amb-slate-50: #f8fafc;
    --amb-slate-100: #f1f5f9;
    --amb-slate-200: #e2e8f0;
    --amb-slate-600: #475569;
    --amb-slate-800: #1e293b;
    --amb-font-head: 'Outfit', sans-serif;
    --amb-font-body: 'Plus Jakarta Sans', sans-serif;
}

.amb-module-root {
    font-family: var(--amb-font-body);
    color: var(--amb-slate-800);
    background: #ffffff;
    overflow-x: hidden;
}

.amb-module-root * {
    box-sizing: border-box;
}

.amb-module-root h1, 
.amb-module-root h2, 
.amb-module-root h3, 
.amb-module-root h4, 
.amb-module-root h5, 
.amb-module-root h6 {
    font-family: var(--amb-font-head);
    font-weight: 700;
    letter-spacing: -0.02em;
}

/* TOP EMERGENCY STRIP */
.amb-top-strip {
    background: #991b1b;
    color: #ffffff;
    padding: 10px 0;
    font-size: 13.5px;
    font-weight: 600;
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
}
.amb-top-strip .strip-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.amb-top-strip .live-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 0, 0, 0.25);
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12.5px;
}
.amb-top-strip .live-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #4ade80;
    box-shadow: 0 0 10px #4ade80;
    animation: amb-pulse 1.5s infinite;
}
.amb-top-strip .hotline-link {
    color: #ffffff;
    font-size: 15px;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.15);
    padding: 4px 14px;
    border-radius: 999px;
    transition: all 0.2s;
}
.amb-top-strip .hotline-link:hover {
    background: #ffffff;
    color: var(--amb-red-dark);
}

/* HERO SECTION */
.amb-hero-section {
    position: relative;
    background: radial-gradient(circle at top right, #3b0712 0%, #0b132b 55%, #070d1e 100%);
    color: #ffffff;
    padding: 70px 0 90px;
    overflow: hidden;
}
.amb-hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 15% 20%, rgba(220, 38, 38, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 85% 80%, rgba(245, 158, 11, 0.08) 0%, transparent 45%);
    pointer-events: none;
}
.amb-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(220, 38, 38, 0.2);
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: #fca5a5;
    padding: 6px 18px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 20px;
    backdrop-filter: blur(8px);
}
.amb-hero-title {
    font-size: 3.4rem;
    font-weight: 900;
    line-height: 1.12;
    margin-bottom: 20px;
    color: #ffffff;
}
.amb-hero-title .highlight-red {
    color: #ef4444;
    text-shadow: 0 0 35px rgba(239, 68, 68, 0.5);
}
.amb-hero-subtitle {
    font-size: 1.15rem;
    line-height: 1.6;
    color: #cbd5e1;
    margin-bottom: 35px;
    max-width: 580px;
}
.amb-hero-cta-wrap {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 35px;
}

/* BUTTONS */
.amb-btn-sos {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: #ffffff !important;
    padding: 16px 36px;
    border-radius: 999px;
    font-size: 1.15rem;
    font-weight: 800;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 10px 30px -5px var(--amb-red-glow), 0 0 0 1px rgba(255, 255, 255, 0.2);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
}
.amb-btn-sos:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 18px 40px -5px var(--amb-red-glow);
    color: #ffffff !important;
}
.amb-btn-sos::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 60%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transform: skewX(-25deg);
    animation: amb-shine 3.5s infinite;
}
.amb-btn-secondary {
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff !important;
    border: 1px solid rgba(255, 255, 255, 0.25);
    padding: 16px 32px;
    border-radius: 999px;
    font-size: 1.05rem;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
}
.amb-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.18);
    border-color: #ffffff;
    transform: translateY(-2px);
    color: #ffffff !important;
}
.amb-hero-trust-list {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
    font-size: 13.5px;
    color: #94a3b8;
}
.amb-hero-trust-list span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.amb-hero-trust-list i {
    color: #34d399;
}

/* HERO INTERACTIVE ESTIMATOR CARD */
.amb-estimator-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
    color: var(--amb-slate-800);
}
.amb-estimator-card .card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--amb-slate-200);
}
.amb-estimator-card .card-head h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 800;
    color: #0f172a;
}
.amb-type-pills {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-bottom: 20px;
}
.amb-type-pill {
    padding: 10px 8px;
    border-radius: 12px;
    border: 1.5px solid var(--amb-slate-200);
    background: var(--amb-slate-50);
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
}
.amb-type-pill:hover {
    border-color: var(--amb-red);
    background: #fff5f5;
}
.amb-type-pill.active {
    border-color: var(--amb-red);
    background: #fff1f2;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
}
.amb-type-pill .p-name {
    font-size: 12px;
    font-weight: 700;
    display: block;
    color: #0f172a;
}
.amb-type-pill .p-price {
    font-size: 11px;
    color: var(--amb-red);
    font-weight: 600;
}
.amb-input-group {
    margin-bottom: 14px;
    position: relative;
}
.amb-input-group label {
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 6px;
    display: block;
}
.amb-input-field {
    width: 100%;
    padding: 12px 14px 12px 38px;
    border-radius: 12px;
    border: 1.5px solid var(--amb-slate-200);
    background: var(--amb-slate-50);
    font-size: 14px;
    color: #0f172a;
    transition: all 0.2s ease;
}
.amb-input-field:focus {
    outline: none;
    border-color: var(--amb-red);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
}
.amb-input-icon {
    position: absolute;
    left: 14px;
    bottom: 14px;
    color: #94a3b8;
    font-size: 15px;
}
.amb-estimate-result {
    background: #f8fafc;
    border: 1px dashed var(--amb-slate-200);
    border-radius: 14px;
    padding: 12px 16px;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.amb-estimate-result .rate-box {
    text-align: right;
}
.amb-estimate-result .rate-amt {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--amb-red);
    font-family: var(--amb-font-head);
}
.amb-btn-calc-dispatch {
    width: 100%;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #ffffff !important;
    border: none;
    padding: 14px;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
    text-decoration: none !important;
}
.amb-btn-calc-dispatch:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: #ffffff !important;
    box-shadow: 0 8px 20px -4px var(--amb-red-glow);
}

/* STATS BAR */
.amb-stats-ribbon {
    background: #ffffff;
    border-bottom: 1px solid var(--amb-slate-200);
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    padding: 30px 0;
}
.amb-stat-block {
    text-align: center;
    padding: 10px 15px;
    border-right: 1px solid var(--amb-slate-200);
}
.amb-stat-block:last-child {
    border-right: none;
}
.amb-stat-num {
    font-size: 2.6rem;
    font-weight: 900;
    color: var(--amb-red);
    line-height: 1;
    margin-bottom: 6px;
    font-family: var(--amb-font-head);
}
.amb-stat-label {
    font-size: 13.5px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* SECTION TITLES */
.amb-section-header {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 50px;
}
.amb-badge-soft {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 12px;
    background: var(--amb-red-light);
    color: var(--amb-red-dark);
}
.amb-section-title {
    font-size: 2.4rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 14px;
}
.amb-section-subtitle {
    font-size: 1.05rem;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}

/* FLEET CARDS */
.amb-fleet-section {
    padding: 80px 0;
    background: #fafaf9;
}
.amb-fleet-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid var(--amb-slate-200);
    padding: 28px 24px;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
}
.amb-fleet-card:hover {
    transform: translateY(-6px);
    border-color: #fca5a5;
    box-shadow: 0 20px 35px -10px rgba(220, 38, 38, 0.12), 0 8px 16px -6px rgba(15, 23, 42, 0.04);
}
.amb-fleet-card.featured-card {
    border: 2px solid var(--amb-red);
    box-shadow: 0 10px 30px -5px rgba(220, 38, 38, 0.15);
}
.amb-fleet-badge-top {
    position: absolute;
    top: -12px;
    right: 24px;
    background: linear-gradient(135deg, #dc2626, #991b1b);
    color: #ffffff;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 14px;
    border-radius: 999px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.amb-card-icon-wrap {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: #fee2e2;
    color: var(--amb-red);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin-bottom: 20px;
}
.amb-card-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 8px;
}
.amb-card-desc {
    color: #64748b;
    font-size: 13.5px;
    line-height: 1.55;
    margin-bottom: 18px;
    min-height: 42px;
}
.amb-equipment-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 20px;
}
.amb-equip-tag {
    background: #f1f5f9;
    color: #334155;
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.amb-equip-tag i {
    font-size: 10px;
    color: var(--amb-red);
}
.amb-price-row {
    background: #f8fafc;
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid var(--amb-slate-200);
}
.amb-price-row .base-fare {
    font-size: 12.5px;
    color: #64748b;
    font-weight: 600;
}
.amb-price-row .fare-val {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
    font-family: var(--amb-font-head);
}
.amb-card-btns {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 10px;
}
.amb-card-btn-primary {
    background: var(--amb-navy);
    color: #ffffff !important;
    text-align: center;
    padding: 12px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.amb-card-btn-primary:hover {
    background: var(--amb-red);
    color: #ffffff !important;
}
.amb-card-btn-call {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #fee2e2;
    color: var(--amb-red) !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.amb-card-btn-call:hover {
    background: var(--amb-red);
    color: #ffffff !important;
}

/* HOW IT WORKS */
.amb-workflow-section {
    padding: 85px 0;
    background: #ffffff;
}
.amb-step-card {
    text-align: center;
    padding: 24px 18px;
    position: relative;
}
.amb-step-num {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #0f172a;
    color: #ffffff;
    font-size: 16px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    border: 3px solid #fee2e2;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
.amb-step-icon {
    font-size: 32px;
    color: var(--amb-red);
    margin-bottom: 14px;
}
.amb-step-card h4 {
    font-size: 1.2rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 8px;
}
.amb-step-card p {
    color: #64748b;
    font-size: 13.5px;
    line-height: 1.6;
    margin: 0;
}

/* CAPABILITIES & PREPAREDNESS */
.amb-capabilities-section {
    padding: 80px 0;
    background: radial-gradient(circle at center, #111e38 0%, #0b132b 100%);
    color: #ffffff;
}
.amb-feature-box {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 18px;
    padding: 24px;
    margin-bottom: 24px;
    transition: all 0.2s ease;
    display: flex;
    gap: 18px;
}
.amb-feature-box:hover {
    background: rgba(255, 255, 255, 0.09);
    border-color: rgba(220, 38, 38, 0.4);
    transform: translateY(-2px);
}
.amb-feature-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    background: rgba(220, 38, 38, 0.2);
    color: #fca5a5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.amb-feature-box h4 {
    color: #ffffff;
    font-size: 1.15rem;
    font-weight: 700;
    margin-bottom: 6px;
}
.amb-feature-box p {
    color: #94a3b8;
    font-size: 13.5px;
    line-height: 1.5;
    margin: 0;
}

/* USER BOOKINGS / TRACKER SECTION */
.amb-tracker-section {
    padding: 60px 0;
    background: #f8fafc;
    border-top: 1px solid var(--amb-slate-200);
}
.amb-tracker-box {
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    border: 1px solid var(--amb-slate-200);
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
}

/* FAQ SECTION */
.amb-faq-section {
    padding: 80px 0;
    background: #ffffff;
}
.amb-faq-item {
    border: 1px solid var(--amb-slate-200);
    border-radius: 14px;
    margin-bottom: 12px;
    overflow: hidden;
}
.amb-faq-item summary {
    padding: 18px 22px;
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    cursor: pointer;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    list-style: none;
    transition: background 0.15s ease;
}
.amb-faq-item summary:hover {
    background: #f8fafc;
}
.amb-faq-item summary::-webkit-details-marker {
    display: none;
}
.amb-faq-item summary::after {
    content: '+';
    font-size: 20px;
    font-weight: 700;
    color: var(--amb-red);
}
.amb-faq-item[open] summary::after {
    content: '−';
}
.amb-faq-content {
    padding: 0 22px 18px;
    color: #64748b;
    font-size: 14.5px;
    line-height: 1.6;
}

/* BOTTOM SOS BANNER */
.amb-cta-banner {
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: #ffffff;
    padding: 60px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.amb-cta-banner h2 {
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 12px;
}
.amb-cta-banner p {
    font-size: 1.15rem;
    color: #fee2e2;
    margin-bottom: 30px;
}
.amb-cta-phone-btn {
    background: #ffffff;
    color: var(--amb-red-dark) !important;
    font-size: 1.6rem;
    font-weight: 900;
    padding: 16px 42px;
    border-radius: 999px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease;
}
.amb-cta-phone-btn:hover {
    transform: scale(1.04);
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.3);
}

/* ANIMATIONS */
@keyframes amb-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(1.15); }
}
@keyframes amb-shine {
    0% { left: -100%; }
    20% { left: 200%; }
    100% { left: 200%; }
}

@media (max-width: 991px) {
    .amb-hero-title { font-size: 2.4rem; }
    .amb-stat-block { border-right: none; border-bottom: 1px solid var(--amb-slate-200); margin-bottom: 15px; }
}
</style>

<div class="amb-module-root">

    <!-- 1. TOP EMERGENCY STRIP -->
    <div class="amb-top-strip">
        <div class="container">
            <div class="strip-container">
                <div class="live-pill">
                    <span class="live-dot"></span>
                    <span>24/7 Rapid Ambulance Network Active &bull; Average Arrival &lt; 8 Mins</span>
                </div>
                <div style="display: flex; align-items: center; gap: 14px;">
                    <span class="hidden-xs">Medical Dispatcher Desk:</span>
                    <a href="tel:18002479999" class="hotline-link">
                        <i class="fas fa-phone-alt"></i> 1800-247-9999 (Toll-Free)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. HERO SECTION -->
    <section class="amb-hero-section">
        <div class="container">
            <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                
                <!-- Left Hero Content -->
                <div class="col-md-7 col-xs-12" style="margin-bottom: 40px;">
                    <div class="amb-hero-badge">
                        <i class="fas fa-shield-alt"></i> CERTIFIED EMERGENCY MEDICAL RESPONSE
                    </div>
                    <h1 class="amb-hero-title">
                        Seconds Count.<br>
                        <span class="highlight-red">Minutes Save Lives.</span><br>
                        24/7 Rapid Ambulance
                    </h1>
                    <p class="amb-hero-subtitle">
                        GPS-dispatched Advanced Life Support (ALS), Basic Life Support (BLS), and Neonatal ICUs at your doorstep within minutes. Fully equipped with emergency oxygen, monitors, and trained critical care paramedics.
                    </p>
                    
                    <div class="amb-hero-cta-wrap">
                        <a href="<?= base_url('ambulance/sos') ?>" class="amb-btn-sos">
                            <i class="fas fa-bolt"></i> Book Emergency SOS
                        </a>
                        <a href="<?= base_url('ambulance/book') ?>" class="amb-btn-secondary">
                            <i class="fas fa-calendar-check"></i> Schedule Booking
                        </a>
                        <a href="<?= base_url('ambulance/tracking') ?>" class="amb-btn-secondary" style="border-style: dashed;">
                            <i class="fas fa-map-marked-alt"></i> Track Active Unit
                        </a>
                    </div>

                    <div class="amb-hero-trust-list">
                        <span><i class="fas fa-check-circle"></i> Live GPS Telemetry</span>
                        <span><i class="fas fa-check-circle"></i> Certified Paramedics</span>
                        <span><i class="fas fa-check-circle"></i> Transparent Fare Matrix</span>
                        <span><i class="fas fa-check-circle"></i> Direct ER Prior Handoff</span>
                    </div>
                </div>

                <!-- Right Hero Calculator / Quick Estimator Card -->
                <div class="col-md-5 col-xs-12">
                    <div class="amb-estimator-card">
                        <div class="card-head">
                            <h3><i class="fas fa-calculator" style="color: var(--amb-red); margin-right: 6px;"></i> Quick Fare Estimator</h3>
                            <span style="font-size: 11.5px; background: #fee2e2; color: #b91c1c; padding: 4px 10px; border-radius: 999px; font-weight: 700;">Live Dispatch</span>
                        </div>

                        <!-- Service Selector -->
                        <div class="amb-type-pills">
                            <div class="amb-type-pill active" onclick="selectType(this, 1, 500, 20)">
                                <span class="p-name">BLS Unit</span>
                                <span class="p-price">₹500 Base</span>
                            </div>
                            <div class="amb-type-pill" onclick="selectType(this, 2, 1000, 35)">
                                <span class="p-name">ALS ICU</span>
                                <span class="p-price">₹1000 Base</span>
                            </div>
                            <div class="amb-type-pill" onclick="selectType(this, 3, 300, 15)">
                                <span class="p-name">Patient Van</span>
                                <span class="p-price">₹300 Base</span>
                            </div>
                        </div>

                        <!-- Pickup -->
                        <div class="amb-input-group">
                            <label>Pickup Location</label>
                            <i class="fas fa-map-marker-alt amb-input-icon" style="color: #dc2626;"></i>
                            <input type="text" id="calcPickup" class="amb-input-field" placeholder="Enter pickup address / hospital" value="Current GPS Location">
                        </div>

                        <!-- Dropoff -->
                        <div class="amb-input-group">
                            <label>Hospital / Destination</label>
                            <i class="fas fa-hospital amb-input-icon"></i>
                            <input type="text" id="calcDrop" class="amb-input-field" placeholder="Select destination or nearby hospital" value="Nearest Emergency Hospital">
                        </div>

                        <!-- Distance Slider -->
                        <div class="amb-input-group">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <label style="margin: 0;">Estimated Transit Distance</label>
                                <span id="distDisplay" style="font-size: 13px; font-weight: 800; color: #0f172a;">10 km</span>
                            </div>
                            <input type="range" id="distRange" min="2" max="60" value="10" step="1" style="width: 100%; accent-color: var(--amb-red);" oninput="recalcFare(this.value)">
                        </div>

                        <!-- Estimated Output -->
                        <div class="amb-estimate-result">
                            <div>
                                <small style="color: #64748b; display: block; font-size: 11px; font-weight: 700; text-transform: uppercase;">Estimated Total Fare</small>
                                <span style="font-size: 13px; color: #475569;" id="calcBreakdown">₹500 base + 10km × ₹20</span>
                            </div>
                            <div class="rate-box">
                                <div class="rate-amt" id="calcTotal">₹700</div>
                            </div>
                        </div>

                        <!-- Dispatch Trigger -->
                        <a href="<?= base_url('ambulance/sos') ?>" class="amb-btn-calc-dispatch">
                            <i class="fas fa-ambulance"></i> Request Immediate Ambulance
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. STATS BAR -->
    <div class="amb-stats-ribbon">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <div class="amb-stat-block">
                        <div class="amb-stat-num"><?= number_format($providers ?: 100) ?>+</div>
                        <div class="amb-stat-label">Verified Ambulances</div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="amb-stat-block">
                        <div class="amb-stat-num">&lt; 8m</div>
                        <div class="amb-stat-label">Avg Arrival Time</div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="amb-stat-block">
                        <div class="amb-stat-num">100%</div>
                        <div class="amb-stat-label">Real-Time GPS Tracked</div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="amb-stat-block">
                        <div class="amb-stat-num">24/7</div>
                        <div class="amb-stat-label">Always On Emergency Desk</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. FLEET & SERVICE TIERS -->
    <section class="amb-fleet-section" id="fleetSection">
        <div class="container">
            <div class="amb-section-header">
                <span class="amb-badge-soft">Medical Fleet Categories</span>
                <h2 class="amb-section-title">Specialized Ambulances For Every Medical Need</h2>
                <p class="amb-section-subtitle">
                    From basic medical transit to mobile intensive care units equipped with ventilators and defibrillators, our fleet conforms to national emergency standards.
                </p>
            </div>

            <div class="row" style="display: flex; flex-wrap: wrap;">
                <?php
                $meta = [
                    1 => [
                        'badge' => 'Standard Care',
                        'icon' => 'fa-ambulance',
                        'equip' => ['Oxygen Cylinder', 'First Aid Kit', 'Wheelchair Ramp', 'EMT Attendant', 'Pulse Oximeter'],
                        'is_featured' => false
                    ],
                    2 => [
                        'badge' => 'ICU on Wheels',
                        'icon' => 'fa-heartbeat',
                        'equip' => ['Transport Ventilator', 'Multipara Cardiac Monitor', 'Defibrillator / AED', 'Critical Paramedic', 'Infusion Pumps'],
                        'is_featured' => true
                    ],
                    3 => [
                        'badge' => 'Non-Emergency',
                        'icon' => 'fa-wheelchair',
                        'equip' => ['Foldable Stretcher', 'Dialysis Transfers', 'Hospital Discharge', 'Assisted Boarding'],
                        'is_featured' => false
                    ],
                    4 => [
                        'badge' => 'Infant Care',
                        'icon' => 'fa-baby',
                        'equip' => ['Pediatric Incubator', 'Neonatal Ventilator', 'Radiant Warmer', 'Pediatric EMT'],
                        'is_featured' => false
                    ],
                    5 => [
                        'badge' => 'Mortuary Van',
                        'icon' => 'fa-shield-virus',
                        'equip' => ['Cold Preservation Cabin', 'Dignified Stretcher', 'Sanitized Interior', 'Intercity Transfer'],
                        'is_featured' => false
                    ]
                ];

                if (!empty($service_types)):
                    foreach ($service_types as $st):
                        $sid = (int)$st['id'];
                        $info = $meta[$sid] ?? [
                            'badge' => 'Medical Carrier',
                            'icon' => 'fa-ambulance',
                            'equip' => ['Oxygen Supply', 'Medical Monitor', 'Stretcher'],
                            'is_featured' => false
                        ];
                ?>
                <div class="col-xs-12 col-sm-6 col-md-4" style="margin-bottom: 30px;">
                    <div class="amb-fleet-card <?= $info['is_featured'] ? 'featured-card' : '' ?>">
                        <?php if ($info['is_featured']): ?>
                            <span class="amb-fleet-badge-top">Most Requested for Emergencies</span>
                        <?php endif; ?>

                        <div>
                            <div class="amb-card-icon-wrap">
                                <i class="fas <?= $info['icon'] ?>"></i>
                            </div>
                            <h3 class="amb-card-title"><?= htmlspecialchars($st['name']) ?></h3>
                            <p class="amb-card-desc"><?= htmlspecialchars($st['description'] ?? 'Full medical support ambulance service with GPS dispatching.') ?></p>
                            
                            <div class="amb-equipment-tags">
                                <?php foreach ($info['equip'] as $eq): ?>
                                    <span class="amb-equip-tag"><i class="fas fa-check"></i> <?= htmlspecialchars($eq) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div>
                            <div class="amb-price-row">
                                <div>
                                    <div class="base-fare">Base Fare</div>
                                    <div class="fare-val">₹<?= number_format($st['fixed'], 0) ?></div>
                                </div>
                                <div style="text-align: right;">
                                    <div class="base-fare">Per KM Rate</div>
                                    <div class="fare-val">₹<?= number_format($st['price'], 0) ?>/km</div>
                                </div>
                            </div>

                            <div class="amb-card-btns">
                                <a href="<?= base_url('ambulance/sos') ?>" class="amb-card-btn-primary">
                                    <i class="fas fa-bolt"></i> Book This Ambulance
                                </a>
                                <a href="tel:18002479999" class="amb-card-btn-call" title="Call Dispatcher">
                                    <i class="fas fa-phone-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach; 
                endif; 
                ?>
            </div>
        </div>
    </section>

    <!-- 5. HOW IT WORKS WORKFLOW -->
    <section class="amb-workflow-section">
        <div class="container">
            <div class="amb-section-header">
                <span class="amb-badge-soft">Rapid Response Protocol</span>
                <h2 class="amb-section-title">How Upchar Ambulance Works</h2>
                <p class="amb-section-subtitle">
                    Automated GPS algorithmic matching ensures the closest equipped vehicle is rolling to your location in seconds.
                </p>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="amb-step-card">
                        <div class="amb-step-num">1</div>
                        <div class="amb-step-icon"><i class="fas fa-mobile-alt"></i></div>
                        <h4>1-Click SOS / Hotline</h4>
                        <p>Trigger 1-click GPS SOS online or dial 1800-247-9999 toll-free with immediate priority queuing.</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="amb-step-card">
                        <div class="amb-step-num">2</div>
                        <div class="amb-step-icon"><i class="fas fa-satellite-dish"></i></div>
                        <h4>Automated Dispatch</h4>
                        <p>Our centralized dispatch engine matches the nearest available ICU or BLS ambulance within 30 seconds.</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="amb-step-card">
                        <div class="amb-step-num">3</div>
                        <div class="amb-step-icon"><i class="fas fa-route"></i></div>
                        <h4>Live GPS Tracking</h4>
                        <p>Track the ambulance live on Google Maps with real-time ETA updates and direct paramedic phone connection.</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="amb-step-card">
                        <div class="amb-step-num">4</div>
                        <div class="amb-step-icon"><i class="fas fa-hospital-alt"></i></div>
                        <h4>ER Pre-Arrival Alert</h4>
                        <p>Destination hospital trauma center is notified ahead of time, ensuring immediate bed and ICU handover.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CAPABILITIES & ICU EQUIPMENT -->
    <section class="amb-capabilities-section">
        <div class="container">
            <div class="amb-section-header">
                <span class="amb-badge-soft" style="background: rgba(220,38,38,0.25); color: #fca5a5;">Advanced Emergency Infrastructure</span>
                <h2 class="amb-section-title" style="color: #ffffff;">Clinical Standards That Save Critical Lives</h2>
                <p class="amb-section-subtitle" style="color: #cbd5e1;">
                    Every Upchar emergency vehicle is audited for medical equipment compliance, sanitized sterility, and certified EMT staffing.
                </p>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="amb-feature-box">
                        <div class="amb-feature-icon"><i class="fas fa-lungs"></i></div>
                        <div>
                            <h4>Onboard Oxygen & Ventilator</h4>
                            <p>Continuous central oxygen manifolds, transport ventilators, and dual flowmeters for acute respiratory distress.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="amb-feature-box">
                        <div class="amb-feature-icon"><i class="fas fa-heartbeat"></i></div>
                        <div>
                            <h4>Cardiac Defibrillator & ECG</h4>
                            <p>Biphasic defibrillators, AEDs, and multiparameter cardiac monitors tracking ECG, NIBP, and SpO2 en route.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="amb-feature-box">
                        <div class="amb-feature-icon"><i class="fas fa-user-nurse"></i></div>
                        <div>
                            <h4>Certified Emergency Paramedics</h4>
                            <p>Trained medical personnel qualified in Advanced Cardiac Life Support (ACLS) and Pediatric Advanced Life Support (PALS).</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="amb-feature-box">
                        <div class="amb-feature-icon"><i class="fas fa-syringe"></i></div>
                        <div>
                            <h4>Emergency Drug Resuscitation</h4>
                            <p>Fully stocked emergency medical kit containing life-saving adrenaline, atropine, IV fluids, and analgesics.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="amb-feature-box">
                        <div class="amb-feature-icon"><i class="fas fa-hospital-user"></i></div>
                        <div>
                            <h4>Hospital ER Direct Telemetry</h4>
                            <p>Real-time sharing of vitals with receiving emergency doctors prior to patient arrival at trauma wards.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="amb-feature-box">
                        <div class="amb-feature-icon"><i class="fas fa-credit-card"></i></div>
                        <div>
                            <h4>Cashless & Digital Billing</h4>
                            <p>100% transparent automated invoices with support for digital UPI, cards, and medical insurance reimbursements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TRACKING & USER BOOKING LOOKUP -->
    <section class="amb-tracker-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-xs-12">
                    <div class="amb-tracker-box">
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
                            <div>
                                <h3 style="margin: 0 0 6px; font-weight: 800; color: #0f172a;"><i class="fas fa-search-location" style="color: var(--amb-red); margin-right: 8px;"></i> Track Ambulance In Real-Time</h3>
                                <p style="margin: 0; color: #64748b; font-size: 13.5px;">Already have a booking? Enter your Booking ID to view the driver's live GPS coordinates.</p>
                            </div>
                            <a href="<?= base_url('ambulance/sos') ?>" class="btn" style="background: #fee2e2; color: #b91c1c; font-weight: 700; border-radius: 999px; padding: 6px 16px; font-size: 12.5px;">
                                Need an Ambulance Now?
                            </a>
                        </div>

                        <form action="<?= base_url('ambulance/tracking') ?>" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <input type="text" name="ref" class="form-control" style="flex: 1; min-width: 220px; height: 48px; border-radius: 12px; font-size: 15px; border: 2px solid #e2e8f0;" placeholder="Enter Booking ID (e.g. AMB-824192)" required>
                            <button type="submit" class="btn" style="background: #0f172a; color: #ffffff; font-weight: 700; height: 48px; padding: 0 28px; border-radius: 12px; font-size: 14px;">
                                <i class="fas fa-crosshairs"></i> Track Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. FREQUENTLY ASKED QUESTIONS -->
    <section class="amb-faq-section">
        <div class="container">
            <div class="amb-section-header">
                <span class="amb-badge-soft">Common Inquiries</span>
                <h2 class="amb-section-title">Frequently Asked Questions</h2>
                <p class="amb-section-subtitle">
                    Clear answers to help you navigate medical emergencies with certainty.
                </p>
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-xs-12">
                    <div class="amb-faq-item">
                        <details open>
                            <summary>What is the difference between an ALS and BLS ambulance?</summary>
                            <div class="amb-faq-content">
                                A <strong>Basic Life Support (BLS)</strong> ambulance is designed for non-critical emergencies and transport, equipped with emergency oxygen, basic diagnostic tools, first aid, and an EMT. An <strong>Advanced Life Support (ALS)</strong> ambulance is a mobile Intensive Care Unit (ICU) fitted with transport ventilators, biphasic defibrillators, multipara cardiac monitors, syringe pumps, and an ACLS-certified critical care paramedic.
                            </div>
                        </details>
                    </div>

                    <div class="amb-faq-item">
                        <details>
                            <summary>How quickly will the ambulance reach my location?</summary>
                            <div class="amb-faq-content">
                                Our average dispatch-to-arrival time across urban service zones is under <strong>8 minutes</strong>. Dispatch is fully automated: the nearest active ambulance unit is alerted immediately upon confirmation of your request.
                            </div>
                        </details>
                    </div>

                    <div class="amb-faq-item">
                        <details>
                            <summary>Can I book an ambulance for outstation or intercity transfers?</summary>
                            <div class="amb-faq-content">
                                Yes. Upchar provides long-distance intercity transfers for stable patients, post-surgical discharges, and specialized neonatal transfers across state lines with oxygen manifolds and dedicated medical staff onboard.
                            </div>
                        </details>
                    </div>

                    <div class="amb-faq-item">
                        <details>
                            <summary>What payment modes are accepted?</summary>
                            <div class="amb-faq-content">
                                We accept digital UPI, Google Pay, PhonePe, Paytm, all major credit/debit cards, and cash. You will receive an official digitized receipt with full distance and rate telemetry for health insurance claims.
                            </div>
                        </details>
                    </div>

                    <div class="amb-faq-item">
                        <details>
                            <summary>How can I reach dispatch directly in an extreme emergency?</summary>
                            <div class="amb-faq-content">
                                In an immediate life-threatening crisis, call our 24/7 dedicated Toll-Free Medical Hotline directly at <a href="tel:18002479999" style="color: #dc2626; font-weight: 800;">1800-247-9999</a>. Our dispatchers can initiate vehicle movement while gathering patient details.
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. BOTTOM SOS CALLOUT BANNER -->
    <section class="amb-cta-banner">
        <div class="container">
            <h2>Critical Emergency? Do Not Wait.</h2>
            <p>Our centralized trauma dispatch coordinators and emergency medical technicians are available 24 hours a day, 365 days a year.</p>
            <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
                <a href="tel:18002479999" class="amb-cta-phone-btn">
                    <i class="fas fa-phone-volume"></i> 1800-247-9999
                </a>
                <a href="<?= base_url('ambulance/sos') ?>" class="btn" style="background: rgba(0,0,0,0.3); color: #ffffff; border: 2px solid #ffffff; border-radius: 999px; padding: 16px 36px; font-size: 1.2rem; font-weight: 800; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-bolt"></i> 1-Click Online SOS
                </a>
            </div>
        </div>
    </section>

</div>

<script>
var curBasePrice = 500;
var curKmPrice = 20;

function selectType(el, typeId, base, perKm) {
    document.querySelectorAll('.amb-type-pill').forEach(function(p) {
        p.classList.remove('active');
    });
    el.classList.add('active');
    curBasePrice = base;
    curKmPrice = perKm;
    var dist = document.getElementById('distRange').value;
    recalcFare(dist);
}

function recalcFare(km) {
    km = parseInt(km, 10);
    document.getElementById('distDisplay').textContent = km + " km";
    var total = curBasePrice + (km * curKmPrice);
    document.getElementById('calcBreakdown').textContent = "₹" + curBasePrice + " base + " + km + "km × ₹" + curKmPrice;
    document.getElementById('calcTotal').textContent = "₹" + total.toLocaleString();
}
</script>