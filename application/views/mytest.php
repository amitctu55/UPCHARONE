<?php include ('includes/header.php'); ?>

<!-- =========================================================
     UPCHAR LABS & DIAGNOSTICS (Inspired by Tata 1mg Labs)
     State-of-the-Art, High-Trust Healthcare Diagnostic Portal
     ========================================================= -->

<style>
:root {
    --up-teal: #00a896;
    --up-teal-dark: #028072;
    --up-teal-light: #f0fdfa;
    --up-navy: #0f172a;
    --up-navy-light: #1e293b;
    --up-slate: #334155;
    --up-muted: #64748b;
    --up-border: #e2e8f0;
    --up-border-light: #f1f5f9;
    --up-bg: #f8fafc;
    --up-card-bg: #ffffff;
    --up-radius-xl: 18px;
    --up-radius-lg: 14px;
    --up-radius-md: 10px;
    --up-radius-sm: 8px;
    --up-shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
    --up-shadow-md: 0 8px 24px rgba(15, 23, 42, 0.06);
    --up-shadow-hover: 0 12px 32px rgba(0, 168, 150, 0.14);
}

body {
    background-color: var(--up-bg);
    color: var(--up-slate);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

/* ---------------------------------------------------------
   1. HERO SECTION & PROMINENT SEARCH BAR
   --------------------------------------------------------- */
.labs-hero {
    background: linear-gradient(135deg, #0a192f 0%, #0d3b4c 50%, #00a896 100%);
    color: #ffffff;
    padding: 44px 16px 40px 16px;
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
}

.labs-hero::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0, 168, 150, 0.25) 0%, rgba(0, 168, 150, 0) 70%);
    pointer-events: none;
}

.hero-container {
    max-width: 960px;
    margin: 0 auto;
    text-align: center;
    position: relative;
    z-index: 2;
}

.hero-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.22);
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    color: #99f6e4;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 12px;
    backdrop-filter: blur(6px);
}

.hero-title {
    font-size: 2.1rem;
    font-weight: 800;
    margin-bottom: 8px;
    color: #ffffff;
    letter-spacing: -0.5px;
}

.hero-subtitle {
    font-size: 0.98rem;
    color: #e2e8f0;
    margin-bottom: 24px;
    opacity: 0.95;
}

/* Wide Unified Search Box */
.hero-search-wrapper {
    background: #ffffff;
    border-radius: 40px;
    padding: 6px 8px 6px 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.22);
    display: flex;
    align-items: center;
    gap: 10px;
    max-width: 820px;
    margin: 0 auto 20px auto;
}

.hero-city-select {
    border: none;
    border-right: 1.5px solid #e2e8f0;
    padding: 8px 12px 8px 0;
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--up-navy);
    background: transparent;
    outline: none;
    max-width: 170px;
    cursor: pointer;
}

.hero-search-input {
    flex: 1;
    border: none;
    padding: 8px 12px;
    font-size: 0.92rem;
    color: var(--up-navy);
    outline: none;
    background: transparent;
}

.hero-search-btn {
    background: var(--up-teal);
    color: #ffffff;
    border: none;
    padding: 11px 26px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.35);
}

.hero-search-btn:hover {
    background: var(--up-teal-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.45);
}

/* 3 Quick Action Buttons */
.hero-quick-actions {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 14px;
}

.quick-action-btn {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
    padding: 9px 18px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    backdrop-filter: blur(6px);
    transition: all 0.2s ease;
    cursor: pointer;
}

.quick-action-btn:hover {
    background: rgba(255, 255, 255, 0.24);
    transform: translateY(-1px);
    color: #ffffff;
}

.quick-action-btn.call-btn:hover { background: #0284c7; border-color: #0284c7; }
.quick-action-btn.wa-btn:hover { background: #16a34a; border-color: #16a34a; }
.quick-action-btn.rx-btn:hover { background: #ea580c; border-color: #ea580c; }

/* Micro Trust Line in Hero */
.hero-trust-strip {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;
    margin-top: 22px;
    font-size: 12px;
    color: #cbd5e1;
    flex-wrap: wrap;
}

.hero-trust-item {
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ---------------------------------------------------------
   SECTION COMMON STYLES
   --------------------------------------------------------- */
.section-container {
    max-width: 1180px;
    margin: 0 auto 36px auto;
    padding: 0 16px;
}

.section-head-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}

.section-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--up-navy);
    margin: 0 0 4px 0;
    letter-spacing: -0.3px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-subtitle {
    font-size: 13px;
    color: var(--up-muted);
    margin: 0;
}

.section-view-all {
    font-size: 13px;
    font-weight: 700;
    color: var(--up-teal);
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: color 0.15s ease;
}

.section-view-all:hover {
    color: var(--up-teal-dark);
}

/* ---------------------------------------------------------
   2. POPULAR HEALTH PACKAGES (Cards Grid)
   --------------------------------------------------------- */
.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
    gap: 20px;
}

.package-card {
    background: #ffffff;
    border: 1.5px solid var(--up-border);
    border-radius: var(--up-radius-lg);
    padding: 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: var(--up-shadow-sm);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}

.package-card:hover {
    border-color: #99f6e4;
    transform: translateY(-3px);
    box-shadow: var(--up-shadow-hover);
}

.package-badge-home {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 12px;
}

.package-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--up-navy);
    margin: 0 0 6px 0;
    line-height: 1.35;
}

.package-tests-pill {
    display: inline-block;
    background: #f0fdfa;
    color: var(--up-teal-dark);
    font-size: 11.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 4px;
    margin-bottom: 12px;
}

.package-features-list {
    list-style: none;
    padding: 0;
    margin: 0 0 18px 0;
}

.package-features-list li {
    font-size: 12.5px;
    color: #475569;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.package-features-list li i {
    color: var(--up-teal);
    font-size: 12px;
}

.package-pricing-row {
    border-top: 1px solid var(--up-border-light);
    padding-top: 14px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 14px;
}

.price-main {
    font-size: 20px;
    font-weight: 800;
    color: var(--up-navy);
}

.price-original {
    font-size: 13px;
    color: #94a3b8;
    text-decoration: line-through;
    margin-left: 6px;
    font-weight: 600;
}

.price-discount-tag {
    background: #fef2f2;
    color: #dc2626;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 4px;
}

.btn-package-add {
    width: 100%;
    background: var(--up-teal);
    color: #ffffff;
    border: none;
    padding: 10px 16px;
    border-radius: var(--up-radius-sm);
    font-weight: 700;
    font-size: 13.5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: all 0.2s ease;
}

.btn-package-add:hover {
    background: var(--up-teal-dark);
    color: #ffffff;
}

.btn-package-add.in-cart {
    background: #0f172a;
    color: #5eead4;
}

/* ---------------------------------------------------------
   3. SHOP BY HEALTH CONCERN (Category Icon Grid)
   --------------------------------------------------------- */
.concern-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(125px, 1fr));
    gap: 14px;
}

.concern-card {
    background: #ffffff;
    border: 1px solid var(--up-border);
    border-radius: var(--up-radius-md);
    padding: 18px 10px;
    text-align: center;
    text-decoration: none !important;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    box-shadow: var(--up-shadow-sm);
}

.concern-card:hover {
    border-color: var(--up-teal);
    transform: translateY(-3px);
    box-shadow: var(--up-shadow-hover);
}

.concern-icon-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 10px;
    transition: transform 0.2s ease;
}

.concern-card:hover .concern-icon-circle {
    transform: scale(1.08);
}

.concern-name {
    font-size: 13px;
    font-weight: 700;
    color: var(--up-navy);
    margin: 0;
}

.concern-sub {
    font-size: 11px;
    color: var(--up-muted);
    margin-top: 2px;
}

/* ---------------------------------------------------------
   4. RADIOLOGY & PHYSICAL SCANS SECTION
   --------------------------------------------------------- */
.scans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 18px;
}

.scan-card {
    background: #ffffff;
    border: 1px solid var(--up-border);
    border-radius: var(--up-radius-lg);
    padding: 20px;
    display: flex;
    gap: 16px;
    align-items: flex-start;
    box-shadow: var(--up-shadow-sm);
    transition: all 0.2s ease;
}

.scan-card:hover {
    border-color: #bae6fd;
    box-shadow: 0 8px 24px rgba(2, 132, 199, 0.12);
    transform: translateY(-2px);
}

.scan-icon-box {
    width: 48px;
    height: 48px;
    border-radius: var(--up-radius-sm);
    background: #f0f9ff;
    color: #0284c7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.scan-info {
    flex-grow: 1;
}

.scan-title {
    font-size: 15px;
    font-weight: 800;
    color: var(--up-navy);
    margin: 0 0 4px 0;
}

.scan-desc {
    font-size: 12px;
    color: var(--up-muted);
    margin-bottom: 10px;
    line-height: 1.4;
}

.scan-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #f1f5f9;
    padding-top: 8px;
    font-size: 12.5px;
}

.scan-price {
    font-weight: 800;
    color: #0284c7;
}

.btn-scan-inquire {
    background: #f0f9ff;
    color: #0284c7;
    border: 1px solid #bae6fd;
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 700;
    text-decoration: none !important;
    cursor: pointer;
    transition: all 0.15s ease;
}

.btn-scan-inquire:hover {
    background: #0284c7;
    color: #ffffff;
}

/* ---------------------------------------------------------
   5. HOW UPCHAR LABS WORKS (4-Step Process Timeline)
   --------------------------------------------------------- */
.timeline-card {
    background: #ffffff;
    border: 1px solid var(--up-border);
    border-radius: var(--up-radius-xl);
    padding: 34px 28px;
    box-shadow: var(--up-shadow-sm);
}

.timeline-steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    position: relative;
}

.timeline-step-item {
    text-align: center;
    padding: 0 10px;
    position: relative;
}

.timeline-step-num {
    position: absolute;
    top: -6px;
    right: 32%;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--up-teal);
    color: #ffffff;
    font-size: 12px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.timeline-icon-box {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: #f0fdfa;
    border: 2px dashed #99f6e4;
    color: var(--up-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin: 0 auto 16px auto;
    transition: transform 0.2s ease;
}

.timeline-step-item:hover .timeline-icon-box {
    transform: scale(1.1);
    background: var(--up-teal);
    color: #ffffff;
}

.timeline-step-title {
    font-size: 15px;
    font-weight: 800;
    color: var(--up-navy);
    margin-bottom: 6px;
}

.timeline-step-desc {
    font-size: 12.5px;
    color: var(--up-muted);
    line-height: 1.45;
    margin: 0;
}

/* ---------------------------------------------------------
   6. TRUST & QUALITY BANNER
   --------------------------------------------------------- */
.trust-banner {
    background: linear-gradient(135deg, #f0fdfa 0%, #ecfdf5 100%);
    border: 1.5px solid #99f6e4;
    border-radius: var(--up-radius-xl);
    padding: 30px;
    box-shadow: var(--up-shadow-sm);
}

.trust-features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 20px;
}

.trust-feature-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.trust-icon-pill {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #ffffff;
    border: 1px solid #a7f3d0;
    color: var(--up-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}

.trust-feature-title {
    font-size: 14.5px;
    font-weight: 800;
    color: var(--up-navy);
    margin: 0 0 3px 0;
}

.trust-feature-desc {
    font-size: 12px;
    color: var(--up-slate);
    line-height: 1.4;
    margin: 0;
}

/* ---------------------------------------------------------
   7. DYNAMIC TESTS CATALOG & FILTER RESULTS
   --------------------------------------------------------- */
.catalog-section {
    background: #ffffff;
    border: 1px solid var(--up-border);
    border-radius: var(--up-radius-xl);
    padding: 26px;
    box-shadow: var(--up-shadow-sm);
    margin-bottom: 36px;
}

.test-row-item {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: var(--up-radius-md);
    padding: 14px 18px;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    transition: all 0.2s ease;
}

.test-row-item:hover {
    border-color: #cbd5e1;
    background: #f1f5f9;
}

.test-info-block {
    flex: 1;
    min-width: 240px;
}

.test-name-line {
    font-size: 15px;
    font-weight: 800;
    color: var(--up-navy);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.test-meta-pills {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 12px;
    color: var(--up-muted);
    flex-wrap: wrap;
}

.test-price-box {
    text-align: right;
    display: flex;
    align-items: center;
    gap: 14px;
    flex-shrink: 0;
}

.test-amount-lg {
    font-size: 17px;
    font-weight: 800;
    color: var(--up-teal-dark);
}

/* Slide-out Cart Drawer & Floating Bar */
.floating-cart-bar {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 1050;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border: 1.5px solid var(--up-teal);
    color: #ffffff;
    border-radius: 40px;
    padding: 10px 22px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    display: flex;
    align-items: center;
    gap: 14px;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.floating-cart-bar:hover {
    transform: translateY(-2px);
}

.cart-drawer-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    z-index: 1060;
    display: none;
}

.cart-drawer-panel {
    position: fixed;
    top: 0;
    right: -420px;
    width: 380px;
    max-width: 90%;
    height: 100%;
    background: #ffffff;
    z-index: 1070;
    box-shadow: -8px 0 30px rgba(0,0,0,0.18);
    transition: right 0.3s ease;
    display: flex;
    flex-direction: column;
}

/* Prescription Upload Modal */
.custom-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(5px);
    z-index: 2000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.custom-modal-card {
    background: #ffffff;
    border-radius: var(--up-radius-xl);
    width: 100%;
    max-width: 500px;
    padding: 28px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    position: relative;
    animation: modalFadeDown 0.25s ease-out;
}

@keyframes modalFadeDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 767px) {
    .hero-title { font-size: 1.6rem; }
    .hero-search-wrapper { flex-direction: column; border-radius: 18px; padding: 12px; }
    .hero-city-select { border-right: none; border-bottom: 1px solid #e2e8f0; width: 100%; max-width: 100%; padding-bottom: 8px; }
    .hero-search-btn { width: 100%; justify-content: center; }
}

/* Unified Tabs Navigation */
.tabs-nav-wrapper {
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
    position: sticky;
    top: 0;
    z-index: 100;
    margin-bottom: 24px;
}

.tabs-nav-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
    white-space: nowrap;
    scrollbar-width: none;
}
.tabs-nav-container::-webkit-scrollbar { display: none; }

.tab-nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 18px;
    font-size: 13.5px;
    font-weight: 700;
    color: #475569;
    text-decoration: none !important;
    border-bottom: 3px solid transparent;
    transition: all 0.2s ease;
}

.tab-nav-btn:hover {
    color: #00a896;
    background: #f8fafc;
}

.tab-nav-btn.active {
    color: #00a896;
    border-bottom-color: #00a896;
    background: #f0fdfa;
}

.tab-count-badge {
    background: #e2e8f0;
    color: #334155;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 12px;
}

.tab-nav-btn.active .tab-count-badge {
    background: #00a896;
    color: #ffffff;
}

/* Active Filter Chips Bar */
.filter-chips-bar {
    max-width: 1200px;
    margin: -10px auto 24px auto;
    padding: 0 16px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
}

.filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

.filter-chip-remove {
    color: #ef4444;
    text-decoration: none !important;
    font-weight: 700;
    margin-left: 2px;
}

/* Partner Labs Directory Grid & Cards */
.partner-labs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 22px;
    margin-bottom: 30px;
}

.partner-lab-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.partner-lab-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(0, 168, 150, 0.12);
    border-color: #99f6e4;
}

.lab-card-badge {
    background: #dcfce7;
    color: #15803d;
    font-size: 11px;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.lab-tests-preview-list {
    list-style: none;
    padding: 0;
    margin: 14px 0;
    border-top: 1px dashed #e2e8f0;
    padding-top: 12px;
}

.lab-test-preview-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12.5px;
    padding: 5px 0;
    color: #475569;
}

/* Category Filter Pills */
.category-filter-pills {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 12px;
    margin-bottom: 22px;
    white-space: nowrap;
}
.category-filter-pills::-webkit-scrollbar { display: none; }

.category-pill {
    display: inline-block;
    padding: 7px 15px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    font-size: 12.5px;
    font-weight: 600;
    color: #475569;
    text-decoration: none !important;
    transition: all 0.15s ease;
}

.category-pill:hover, .category-pill.active {
    background: #00a896;
    border-color: #00a896;
    color: #ffffff;
}

.btn-book-instant {
    background: #ffffff;
    color: #00a896;
    border: 1.5px solid #00a896;
    border-radius: 8px;
    padding: 7px 14px;
    font-weight: 700;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-book-instant:hover {
    background: #00a896;
    color: #ffffff;
}
/* ---------------------------------------------------------
   CHECKOUT & MERGED CART STYLES
   --------------------------------------------------------- */
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
.checkout-stepper { display: flex; align-items: center; gap: 10px; }
.step-pill {
    display: flex; align-items: center; gap: 7px;
    font-size: 12.5px; font-weight: 600; color: #94A3B8;
    padding: 6px 14px; border-radius: 9999px; background: #F1F5F9;
}
.step-pill.completed { background: #E6F4EA; color: #16A34A; }
.step-pill.active { background: #F0FDFA; color: #00A896; border: 1.5px solid #00A896; font-weight: 700; }
.step-divider { color: #CBD5E1; font-size: 11px; }

.checkout-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
}
.card-step-header {
    display: flex; justify-content: space-between; align-items: center;
    border-bottom: 1px solid #F1F5F9; padding-bottom: 14px; margin-bottom: 18px;
}
.card-step-title {
    font-size: 16.5px; font-weight: 800; color: #0F172A; margin: 0;
    display: flex; align-items: center; gap: 10px;
}
.badge-step-num {
    width: 26px; height: 26px; background: #00A896; color: #FFFFFF;
    border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800;
}
.patient-selector-pills {
    display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px;
    background: #F8FAFC; padding: 8px; border-radius: 12px; border: 1px solid #E2E8F0;
}
.patient-pill-btn {
    border: 1.5px solid #CBD5E1; background: #FFFFFF; color: #475569;
    font-size: 12px; font-weight: 600; padding: 6px 13px; border-radius: 8px;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease;
}
.patient-pill-btn.active {
    background: #00A896; color: #FFFFFF; border-color: #00A896; box-shadow: 0 2px 8px rgba(0, 168, 150, 0.25);
}
.upchar-input-wrap label { font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 5px; display: block; }
.upchar-input-wrap .form-control {
    border-radius: 10px; border: 1.5px solid #E2E8F0; padding: 9px 13px;
    font-size: 13px; color: #0F172A; background-color: #FFFFFF; box-shadow: none !important;
}
.upchar-input-wrap .form-control:focus { border-color: #00A896; box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.12) !important; }

.choice-card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px; margin-bottom: 16px; }
.choice-card {
    border: 1.5px solid #E2E8F0; background: #FFFFFF; border-radius: 12px;
    padding: 14px 16px; cursor: pointer; transition: all 0.15s ease;
    display: flex; align-items: flex-start; gap: 12px;
}
.choice-card:hover { border-color: #94A3B8; background: #F8FAFC; }
.choice-card.selected { border-color: #00A896; background: #F0FDFA; box-shadow: 0 2px 10px rgba(0, 168, 150, 0.1); }
.choice-card input[type="radio"] { margin-top: 3px; accent-color: #00A896; width: 17px; height: 17px; cursor: pointer; }
.choice-card-info { flex-grow: 1; }
.choice-card-info strong { font-size: 13.5px; font-weight: 700; color: #0F172A; display: block; margin-bottom: 2px; }
.choice-card-info p { font-size: 12px; color: #64748B; margin: 0; line-height: 1.4; }
.choice-badge-free { background: #DCFCE7; color: #16A34A; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px; display: inline-block; margin-top: 4px; }

.fasting-notice-box {
    background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 10px;
    padding: 12px 14px; display: flex; align-items: center; gap: 12px; margin-top: 14px;
}
.fasting-notice-box i { color: #D97706; font-size: 18px; flex-shrink: 0; }
.fasting-notice-box div { font-size: 12px; color: #92400E; line-height: 1.4; }

.date-chips-wrap { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
.date-chip {
    border: 1.5px solid #E2E8F0; background: #FFFFFF; padding: 7px 13px;
    border-radius: 10px; font-size: 12.5px; font-weight: 600; color: #475569;
    cursor: pointer; transition: all 0.15s ease;
}
.date-chip.active { background: #00A896; border-color: #00A896; color: #FFFFFF; box-shadow: 0 2px 8px rgba(0, 168, 150, 0.25); }

.checkout-summary-card {
    background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px;
    padding: 22px 20px; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
    position: sticky; top: 90px;
}
.summary-header {
    display: flex; justify-content: space-between; align-items: center;
    border-bottom: 1px solid #F1F5F9; padding-bottom: 12px; margin-bottom: 14px;
}
.summary-header h3 { font-size: 15.5px; font-weight: 800; color: #0F172A; margin: 0; display: flex; align-items: center; gap: 8px; }
.summary-clear-btn {
    background: none; border: none; color: #EF4444; font-size: 11.5px;
    font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 8px; border-radius: 6px;
}
.checkout-items-list { max-height: 260px; overflow-y: auto; padding-right: 4px; margin-bottom: 14px; }
.checkout-item-row {
    background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px;
    padding: 10px 12px; margin-bottom: 8px; display: flex; justify-content: space-between;
    align-items: center; gap: 10px;
}
.checkout-item-name { font-size: 12.5px; font-weight: 700; color: #0F172A; margin-bottom: 2px; }
.checkout-item-meta { font-size: 11px; color: #64748B; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.checkout-item-price-wrap { text-align: right; display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
.checkout-item-price { font-size: 13.5px; font-weight: 800; color: #00A896; }
.checkout-item-mrp { font-size: 11px; color: #94A3B8; text-decoration: line-through; display: block; }
.btn-remove-item {
    width: 26px; height: 26px; border-radius: 7px; background: #FFFFFF;
    border: 1px solid #FECACA; color: #EF4444; display: inline-flex;
    align-items: center; justify-content: center; cursor: pointer; font-size: 11px;
}
.btn-remove-item:hover { background: #EF4444; color: #FFFFFF; }

.price-breakdown { background: #F8FAFC; border-radius: 12px; padding: 13px; margin-bottom: 14px; border: 1px solid #E2E8F0; }
.price-row { display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; color: #475569; margin-bottom: 7px; }
.price-row.discount { color: #16A34A; font-weight: 600; }
.price-row.total { border-top: 1.5px dashed #CBD5E1; padding-top: 9px; margin-top: 9px; font-size: 14px; font-weight: 800; color: #0F172A; }
.grand-amount { font-size: 20px; font-weight: 900; color: #00A896; }

.btn-confirm-checkout {
    width: 100%; background: #00A896; color: #FFFFFF; border: none;
    border-radius: 12px; padding: 13px 18px; font-size: 14.5px; font-weight: 800;
    display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer;
    box-shadow: 0 4px 14px rgba(0, 168, 150, 0.35); transition: all 0.2s ease;
}
.btn-confirm-checkout:hover { background: #008f80; transform: translateY(-1px); color: #FFFFFF; }

.security-assurance-list { margin-top: 14px; border-top: 1px solid #F1F5F9; padding-top: 12px; font-size: 11px; color: #64748B; }
.security-assurance-list div { display: flex; align-items: center; gap: 7px; margin-bottom: 5px; }
.security-assurance-list i { color: #16A34A; font-size: 12px; }

.empty-checkout-card {
    background: #FFFFFF; border-radius: 16px; border: 1px solid #E2E8F0;
    padding: 40px 20px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    max-width: 850px; margin: 20px auto 40px;
}
.empty-icon-circle {
    width: 68px; height: 68px; border-radius: 50%; background: #F0FDFA;
    color: #00A896; display: inline-flex; align-items: center; justify-content: center;
    font-size: 28px; margin-bottom: 14px;
}
</style>

<!-- =========================================================
     1. HERO SECTION & PROMINENT SEARCH BAR (Tata 1mg style)
     ========================================================= -->
<div class="labs-hero">
    <div class="hero-container">
        
        <div class="hero-pill-badge">
            <i class="fas fa-shield-alt"></i> 100% NABL &amp; CAP Certified Partner Labs
        </div>

        <h1 class="hero-title">Diagnostic Lab Tests &amp; Health Checkups at Home</h1>
        <p class="hero-subtitle">Book certified blood tests, full-body packages &amp; scans with 100% safe home sample collection.</p>

        <!-- Prominent Search Bar with Location & Lab Selector -->
        <form action="<?=base_url('mytest');?>" method="get" class="hero-search-wrapper">
            <input type="hidden" name="tab" value="<?=html_escape($active_tab);?>">

            <!-- Location Dropdown -->
            <select name="city" class="hero-city-select" onchange="this.form.submit()">
                <option value="">📍 All Locations</option>
                <?php if(!empty($cities)): ?>
                    <?php foreach($cities as $c): ?>
                        <option value="<?=$c->id;?>" <?=($selected_city == $c->id) ? 'selected' : '';?>>
                            📍 <?=html_escape($c->name);?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <!-- Partner Lab Dropdown -->
            <select name="lab_id" class="hero-city-select" style="max-width: 220px;" onchange="this.form.submit()">
                <option value="">🏥 All Partner Labs</option>
                <?php if(!empty($labs_dropdown)): ?>
                    <?php foreach($labs_dropdown as $ld): ?>
                        <option value="<?=$ld->id;?>" <?=($selected_lab == $ld->id) ? 'selected' : '';?>>
                            🏥 <?=html_escape($ld->name);?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <!-- Keyword Search -->
            <input type="text" name="keyword" class="hero-search-input" 
                   placeholder="Search for tests, packages, or labs (e.g. CBC, Thyroid, Vitamin D, Lipid)..." 
                   value="<?=html_escape($keyword);?>">

            <button type="submit" class="hero-search-btn">
                <i class="fas fa-search"></i> Find Tests
            </button>
        </form>

        <!-- 3 Quick Action Buttons -->
        <div class="hero-quick-actions">
            <a href="tel:18008890199" class="quick-action-btn call-btn">
                <i class="fas fa-phone-alt" style="color: #38bdf8;"></i> Book via Call: 1800-889-0199
            </a>
            <a href="https://wa.me/917607777883?text=Hi%20Upchar,%20I%20want%20to%20book%20a%20lab%20test%20at%20home" target="_blank" class="quick-action-btn wa-btn">
                <i class="fab fa-whatsapp" style="color: #4ade80;"></i> Order via WhatsApp
            </a>
            <button type="button" class="quick-action-btn rx-btn" onclick="openPrescriptionModal()">
                <i class="fas fa-file-prescription" style="color: #fb923c;"></i> Upload Prescription
            </button>
        </div>

        <!-- Trust Highlights Strip -->
        <div class="hero-trust-strip">
            <div class="hero-trust-item"><i class="fas fa-check-circle" style="color: #34d399;"></i> Free Home Sample Pickup</div>
            <div class="hero-trust-item"><i class="fas fa-check-circle" style="color: #34d399;"></i> Digital Reports in 6-12 Hours</div>
            <div class="hero-trust-item"><i class="fas fa-check-circle" style="color: #34d399;"></i> Barcoded Single-Use Vials</div>
            <div class="hero-trust-item"><i class="fas fa-check-circle" style="color: #34d399;"></i> Free Doctor Report Consultation</div>
        </div>

    </div>
</div>

<!-- =========================================================
     UNIFIED INTERACTIVE NAVIGATION TABS
     ========================================================= -->
<div class="tabs-nav-wrapper">
    <div class="tabs-nav-container">
        <a href="<?=base_url('mytest?tab=all' . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-nav-btn <?=($active_tab == 'all') ? 'active' : '';?>">
            <i class="fas fa-th-large"></i> All &amp; Recommended
        </a>
        <a href="<?=base_url('mytest?tab=tests' . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-nav-btn <?=($active_tab == 'tests') ? 'active' : '';?>">
            <i class="fas fa-flask"></i> Diagnostic Tests <span class="tab-count-badge"><?=$total_tests_count;?></span>
        </a>
        <a href="<?=base_url('mytest?tab=labs' . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-nav-btn <?=($active_tab == 'labs') ? 'active' : '';?>">
            <i class="fas fa-hospital"></i> Partner Labs <span class="tab-count-badge"><?=$total_labs_count;?></span>
        </a>
        <a href="<?=base_url('mytest?tab=packages' . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-nav-btn <?=($active_tab == 'packages') ? 'active' : '';?>">
            <i class="fas fa-notes-medical"></i> Health Packages <span class="tab-count-badge"><?=$total_packages_count;?></span>
        </a>
        <a href="<?=base_url('mytest?tab=scans' . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-nav-btn <?=($active_tab == 'scans') ? 'active' : '';?>">
            <i class="fas fa-x-ray"></i> Radiology &amp; Scans
        </a>
        <a href="<?=base_url('mytest?tab=checkout' . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="tab-nav-btn <?=($active_tab == 'checkout') ? 'active' : '';?>" id="tabCheckoutBtn" style="border-left: 1px solid #e2e8f0; margin-left: 4px; padding-left: 18px;">
            <i class="fas fa-shopping-cart" style="color: #ec4899;"></i> Test Cart &amp; Checkout 
            <span class="tab-count-badge cart-total-items" style="<?=empty($cart) ? 'display:none;' : '';?> background: #ec4899; color: #ffffff;"><?=count($cart);?></span>
        </a>
    </div>
</div>

<!-- ACTIVE FILTER CHIPS (IF ANY) -->
<?php if(!empty($keyword) || !empty($selected_city) || !empty($selected_lab) || !empty($selected_category)): ?>
<div class="filter-chips-bar">
    <span style="font-size: 12px; font-weight: 700; color: #64748b;">Active Filters:</span>
    
    <?php if(!empty($selected_city)): 
        $cityName = 'City';
        foreach($cities as $ci) { if($ci->id == $selected_city) { $cityName = $ci->name; break; } }
    ?>
        <span class="filter-chip">
            📍 <?=$cityName;?>
            <a href="<?=base_url('mytest?tab='.$active_tab . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="filter-chip-remove" title="Remove filter">&times;</a>
        </span>
    <?php endif; ?>

    <?php if(!empty($selected_lab)): 
        $labName = 'Lab';
        foreach($labs_dropdown as $ld) { if($ld->id == $selected_lab) { $labName = $ld->name; break; } }
    ?>
        <span class="filter-chip">
            🏥 <?=$labName;?>
            <a href="<?=base_url('mytest?tab='.$active_tab . ($selected_city ? '&city='.$selected_city : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="filter-chip-remove" title="Remove filter">&times;</a>
        </span>
    <?php endif; ?>

    <?php if(!empty($selected_category)): 
        $catName = 'Category';
        foreach($categories as $ct) { if($ct->category_id == $selected_category) { $catName = $ct->category_name; break; } }
    ?>
        <span class="filter-chip">
            🧪 <?=$catName;?>
            <a href="<?=base_url('mytest?tab='.$active_tab . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="filter-chip-remove" title="Remove filter">&times;</a>
        </span>
    <?php endif; ?>

    <?php if(!empty($keyword)): ?>
        <span class="filter-chip">
            🔍 "<?=html_escape($keyword);?>"
            <a href="<?=base_url('mytest?tab='.$active_tab . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : ''));?>" class="filter-chip-remove" title="Remove filter">&times;</a>
        </span>
    <?php endif; ?>

    <a href="<?=base_url('mytest?tab='.$active_tab);?>" style="font-size: 12px; color: #0284c7; font-weight: 700; text-decoration: underline; margin-left: 6px;">
        Clear All Filters
    </a>
</div>
<?php endif; ?>

<!-- =========================================================
     TAB CONTENT: ALL & RECOMMENDED (Default View)
     ========================================================= -->
<?php if ($active_tab == 'all'): ?>

    <!-- POPULAR HEALTH PACKAGES -->
    <div class="section-container">
        <div class="section-head-row">
            <div>
                <h2 class="section-title">
                    <i class="fas fa-notes-medical" style="color: var(--up-teal);"></i> Popular Health Packages
                </h2>
                <p class="section-subtitle">Comprehensive preventive checkups carefully curated by leading MD physicians</p>
            </div>
            <a href="<?=base_url('mytest?tab=packages');?>" class="section-view-all">
                Explore All Packages <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="packages-grid">
            <!-- Package 1: Comprehensive Full Body Checkup -->
            <div class="package-card" style="border-color: #99f6e4;">
                <div>
                    <span class="package-badge-home">
                        <i class="fas fa-home"></i> Home Collection Available
                    </span>
                    <h3 class="package-title">Comprehensive Full Body Checkup</h3>
                    <span class="package-tests-pill">Includes 64 Vital Tests</span>

                    <ul class="package-features-list">
                        <li><i class="fas fa-check-circle"></i> Complete Hemogram (CBC - 24 tests)</li>
                        <li><i class="fas fa-check-circle"></i> Liver Function Test (LFT - 11 tests)</li>
                        <li><i class="fas fa-check-circle"></i> Kidney Function Test (KFT - 8 tests)</li>
                        <li><i class="fas fa-check-circle"></i> Lipid Profile for Heart Health (8 tests)</li>
                        <li><i class="fas fa-check-circle"></i> Fasting Blood Sugar &amp; Thyroid (TSH)</li>
                    </ul>
                </div>

                <div>
                    <div class="package-pricing-row">
                        <div>
                            <span class="price-main">₹999</span>
                            <span class="price-original">₹2,499</span>
                        </div>
                        <span class="price-discount-tag">60% OFF</span>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="btn-package-add btn-cart-toggle <?=isset($cart[29]) ? 'in-cart' : '';?>" data-test-id="29" style="flex: 1;">
                            <?=isset($cart[29]) ? '<i class="fas fa-check"></i> In Cart' : '<i class="fas fa-shopping-cart"></i> Add to Cart';?>
                        </button>
                        <button type="button" class="btn-book-instant btn-open-quick-book" 
                                data-test-id="29" 
                                data-test-name="Comprehensive Full Body Checkup (64 Tests)" 
                                data-lab-id="29" 
                                data-lab-name="Upchar Accredited Partner Lab" 
                                data-amount="999">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Package 2: Senior Citizen Comprehensive Shield -->
            <div class="package-card" style="border-color: #bae6fd;">
                <div>
                    <span class="package-badge-home" style="background: #f0f9ff; color: #0284c7; border-color: #bae6fd;">
                        <i class="fas fa-user-shield"></i> Senior Wellness Plan
                    </span>
                    <h3 class="package-title">Senior Citizen Comprehensive Shield</h3>
                    <span class="package-tests-pill" style="background: #e0f2fe; color: #0369a1;">Includes 78 Vital Parameters</span>

                    <ul class="package-features-list">
                        <li><i class="fas fa-check-circle"></i> Everything in Full Body Checkup</li>
                        <li><i class="fas fa-check-circle"></i> Vitamin D3 &amp; Vitamin B12 Levels</li>
                        <li><i class="fas fa-check-circle"></i> HbA1c 3-Month Average Blood Sugar</li>
                        <li><i class="fas fa-check-circle"></i> Calcium, Uric Acid &amp; Electrolytes</li>
                        <li><i class="fas fa-check-circle"></i> Complete Urine Routine &amp; Microscopy</li>
                    </ul>
                </div>

                <div>
                    <div class="package-pricing-row">
                        <div>
                            <span class="price-main">₹1,499</span>
                            <span class="price-original">₹3,800</span>
                        </div>
                        <span class="price-discount-tag">61% OFF</span>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="btn-package-add btn-cart-toggle <?=isset($cart[30]) ? 'in-cart' : '';?>" data-test-id="30" style="flex: 1;">
                            <?=isset($cart[30]) ? '<i class="fas fa-check"></i> In Cart' : '<i class="fas fa-shopping-cart"></i> Add to Cart';?>
                        </button>
                        <button type="button" class="btn-book-instant btn-open-quick-book" 
                                data-test-id="30" 
                                data-test-name="Senior Citizen Comprehensive Shield" 
                                data-lab-id="29" 
                                data-lab-name="Upchar Accredited Partner Lab" 
                                data-amount="1499">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Package 3: Active Diabetic & Heart Care Profile -->
            <div class="package-card" style="border-color: #fecdd3;">
                <div>
                    <span class="package-badge-home" style="background: #fff1f2; color: #e11d48; border-color: #fecdd3;">
                        <i class="fas fa-heartbeat"></i> Heart &amp; Sugar Focus
                    </span>
                    <h3 class="package-title">Active Diabetic &amp; Heart Care Profile</h3>
                    <span class="package-tests-pill" style="background: #ffe4e6; color: #be123c;">Includes 42 Targeted Tests</span>

                    <ul class="package-features-list">
                        <li><i class="fas fa-check-circle"></i> HbA1c Glycated Hemoglobin Test</li>
                        <li><i class="fas fa-check-circle"></i> Fasting &amp; Postprandial Blood Sugar</li>
                        <li><i class="fas fa-check-circle"></i> Advanced Lipid Profile (HDL, LDL, VLDL)</li>
                        <li><i class="fas fa-check-circle"></i> Serum Creatinine &amp; BUN for Kidney</li>
                        <li><i class="fas fa-check-circle"></i> Free Cardiologist Report Review</li>
                    </ul>
                </div>

                <div>
                    <div class="package-pricing-row">
                        <div>
                            <span class="price-main">₹799</span>
                            <span class="price-original">₹1,800</span>
                        </div>
                        <span class="price-discount-tag">56% OFF</span>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="btn-package-add btn-cart-toggle <?=isset($cart[23]) ? 'in-cart' : '';?>" data-test-id="23" style="flex: 1;">
                            <?=isset($cart[23]) ? '<i class="fas fa-check"></i> In Cart' : '<i class="fas fa-shopping-cart"></i> Add to Cart';?>
                        </button>
                        <button type="button" class="btn-book-instant btn-open-quick-book" 
                                data-test-id="23" 
                                data-test-name="Active Diabetic & Heart Care Profile" 
                                data-lab-id="29" 
                                data-lab-name="Upchar Accredited Partner Lab" 
                                data-amount="799">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EXPLORE BY HEALTH CONCERN -->
    <div class="section-container">
        <div class="section-head-row">
            <div>
                <h2 class="section-title">
                    <i class="fas fa-th-large" style="color: var(--up-teal);"></i> Shop by Health Concern
                </h2>
                <p class="section-subtitle">Find targeted diagnostic tests categorized by condition and body organ</p>
            </div>
        </div>

        <div class="concern-grid">
            <a href="<?=base_url('mytest?keyword=Sugar');?>" class="concern-card">
                <div class="concern-icon-circle" style="background: #eff6ff; color: #2563eb;"><i class="fas fa-tint"></i></div>
                <h4 class="concern-name">Diabetes</h4>
                <span class="concern-sub">HbA1c, Glucose</span>
            </a>
            <a href="<?=base_url('mytest?keyword=Thyroid');?>" class="concern-card">
                <div class="concern-icon-circle" style="background: #fdf2f8; color: #db2777;"><i class="fas fa-ribbon"></i></div>
                <h4 class="concern-name">Thyroid</h4>
                <span class="concern-sub">TSH, T3, T4</span>
            </a>
            <a href="<?=base_url('mytest?keyword=Liver');?>" class="concern-card">
                <div class="concern-icon-circle" style="background: #fff7ed; color: #ea580c;"><i class="fas fa-shield-virus"></i></div>
                <h4 class="concern-name">Liver Care</h4>
                <span class="concern-sub">LFT, Bilirubin</span>
            </a>
            <a href="<?=base_url('mytest?keyword=Lipid');?>" class="concern-card">
                <div class="concern-icon-circle" style="background: #fef2f2; color: #dc2626;"><i class="fas fa-heartbeat"></i></div>
                <h4 class="concern-name">Heart</h4>
                <span class="concern-sub">Lipid, Cholesterol</span>
            </a>
            <a href="<?=base_url('mytest?keyword=KFT');?>" class="concern-card">
                <div class="concern-icon-circle" style="background: #f0fdf4; color: #16a34a;"><i class="fas fa-user-md"></i></div>
                <h4 class="concern-name">Kidney Care</h4>
                <span class="concern-sub">KFT, Creatinine</span>
            </a>
            <a href="<?=base_url('mytest?keyword=CBC');?>" class="concern-card">
                <div class="concern-icon-circle" style="background: #fefce8; color: #ca8a04;"><i class="fas fa-thermometer-half"></i></div>
                <h4 class="concern-name">Fever &amp; CBC</h4>
                <span class="concern-sub">Hemogram, ESR</span>
            </a>
            <a href="<?=base_url('mytest?tab=packages');?>" class="concern-card">
                <div class="concern-icon-circle" style="background: #f0fdfa; color: #0d9488;"><i class="fas fa-notes-medical"></i></div>
                <h4 class="concern-name">Full Body</h4>
                <span class="concern-sub">Wellness Plans</span>
            </a>
            <a href="<?=base_url('mytest?keyword=Blood');?>" class="concern-card">
                <div class="concern-icon-circle" style="background: #ecfdf5; color: #059669;"><i class="fas fa-capsules"></i></div>
                <h4 class="concern-name">Vitamins</h4>
                <span class="concern-sub">Vit D3, B12</span>
            </a>
        </div>
    </div>

    <!-- FREQUENTLY PRESCRIBED TESTS PREVIEW -->
    <div class="section-container">
        <div class="catalog-section">
            <div class="section-head-row">
                <div>
                    <h2 class="section-title">
                        <i class="fas fa-flask" style="color: var(--up-teal);"></i> Frequently Prescribed Blood Tests
                    </h2>
                    <p class="section-subtitle">Verified diagnostic tests available with same-day home sample collection</p>
                </div>
                <a href="<?=base_url('mytest?tab=tests');?>" class="section-view-all">
                    View All <?=$total_tests_count;?> Tests <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <?php if(!empty($all_tests)): ?>
                <?php foreach(array_slice($all_tests, 0, 6) as $test): ?>
                    <?php $in_cart = isset($cart[$test->test_id]); ?>
                    <div class="test-row-item">
                        <div class="test-info-block">
                            <div class="test-name-line">
                                <span><?=html_escape($test->test_name);?></span>
                                <?php if(!empty($test->short_name)): ?>
                                    <span class="badge" style="background: #e2e8f0; color: #475569; font-size: 11px;">
                                        <?=html_escape($test->short_name);?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="test-meta-pills">
                                <span><i class="fas fa-hospital" style="color: var(--up-teal);"></i> <?=html_escape($test->lab_name ?: 'Upchar Partner Lab');?></span>
                                <span><i class="fas fa-tint" style="color: #ef4444;"></i> <?=html_escape($test->test_type ?: 'Blood Sample');?></span>
                                <span><i class="fas fa-clock" style="color: #0284c7;"></i> <?=html_escape($test->report_day ?: 'Same Day Report');?></span>
                                <span style="color: #059669; font-weight: 700;"><i class="fas fa-home"></i> Free Home Pickup</span>
                            </div>
                        </div>

                        <div class="test-price-box" style="display: flex; align-items: center; gap: 10px;">
                            <div class="test-amount-lg" style="margin-right: 4px;">₹<?=number_format($test->amount);?></div>
                            <button type="button" class="btn-package-add btn-cart-toggle <?=$in_cart ? 'in-cart' : '';?>" 
                                    data-test-id="<?=$test->test_id;?>" style="width: auto; padding: 7px 16px; font-size: 12.5px;">
                                <?=$in_cart ? '<i class="fas fa-check"></i> Added' : '<i class="fas fa-plus"></i> Add Test';?>
                            </button>
                            <button type="button" class="btn-book-instant btn-open-quick-book"
                                    data-test-id="<?=$test->test_id;?>"
                                    data-test-name="<?=html_escape($test->test_name);?>"
                                    data-lab-id="<?=$test->path_id;?>"
                                    data-lab-name="<?=html_escape($test->lab_name ?: 'Partner Lab');?>"
                                    data-amount="<?=$test->amount;?>">
                                Book Now
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- ACCREDITED PARTNER LABS PREVIEW -->
    <div class="section-container">
        <div class="section-head-row">
            <div>
                <h2 class="section-title">
                    <i class="fas fa-hospital" style="color: var(--up-teal);"></i> Verified Pathology Laboratories
                </h2>
                <p class="section-subtitle">Leading certified diagnostic facilities connected to the Upchar clinical network</p>
            </div>
            <a href="<?=base_url('mytest?tab=labs');?>" class="section-view-all">
                View All <?=$total_labs_count;?> Labs <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="partner-labs-grid">
            <?php if(!empty($pathologies)): ?>
                <?php foreach(array_slice($pathologies, 0, 3) as $lab): ?>
                    <div class="partner-lab-card">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                <div>
                                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                                        <?=html_escape($lab->name);?>
                                    </h3>
                                    <div style="font-size: 12px; color: #64748b;">
                                        <i class="fas fa-map-marker-alt text-danger" style="color: #ef4444;"></i>
                                        <?=html_escape($lab->location ?: $lab->city_name ?: 'Varanasi Center');?>
                                    </div>
                                </div>
                                <span class="lab-card-badge">
                                    <i class="fas fa-shield-alt"></i> Verified
                                </span>
                            </div>

                            <!-- Top Tests preview -->
                            <ul class="lab-tests-preview-list">
                                <?php if(!empty($lab->tests)): ?>
                                    <?php foreach(array_slice($lab->tests, 0, 3) as $lt): ?>
                                        <li class="lab-test-preview-item">
                                            <span><i class="fas fa-check" style="color: #00a896; font-size: 11px;"></i> <?=html_escape($lt->short_name ?: $lt->test_name);?></span>
                                            <strong style="color: #00a896;">₹<?=number_format($lt->amount);?></strong>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div style="border-top: 1px solid #f1f5f9; padding-top: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 11px; color: #64748b;">Tests from</div>
                                <div style="font-size: 16px; font-weight: 800; color: #00a896;">₹<?=number_format($lab->starting_price);?></div>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <a href="<?=base_url('mytest?tab=tests&lab_id='.$lab->id);?>" class="btn btn-sm btn-outline-secondary" style="font-weight: 700; font-size: 12px; border-radius: 8px;">
                                    Tests (<?=$lab->total_test_count;?>)
                                </a>
                                <button type="button" class="btn-book-instant btn-open-quick-book"
                                        data-test-id="<?=(!empty($lab->tests) ? $lab->tests[0]->test_id : 22);?>"
                                        data-test-name="<?=(!empty($lab->tests) ? html_escape($lab->tests[0]->test_name) : 'Diagnostic Blood Checkup');?>"
                                        data-lab-id="<?=$lab->id;?>"
                                        data-lab-name="<?=html_escape($lab->name);?>"
                                        data-amount="<?=(!empty($lab->tests) ? $lab->tests[0]->amount : 299);?>">
                                    Book Test
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- RADIOLOGY & PHYSICAL SCANS -->
    <div class="section-container">
        <div class="section-head-row">
            <div>
                <h2 class="section-title">
                    <i class="fas fa-x-ray" style="color: #0284c7;"></i> Radiology &amp; Physical Scans
                </h2>
                <p class="section-subtitle">High-precision diagnostic imaging at partner diagnostic hospitals &amp; scan centers</p>
            </div>
            <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 8px;">
                <i class="fas fa-hospital"></i> Center Visits with Assistance
            </span>
        </div>

        <div class="scans-grid">
            <div class="scan-card">
                <div class="scan-icon-box"><i class="fas fa-x-ray"></i></div>
                <div class="scan-info">
                    <h4 class="scan-title">Digital X-Ray</h4>
                    <div class="scan-desc">Chest X-Ray, Spine, Joint &amp; Bone Radiography with digital HD films.</div>
                    <div class="scan-meta-row">
                        <span class="scan-price">Starts @ ₹350</span>
                        <button type="button" class="btn-scan-inquire" onclick="inquireScan('Digital X-Ray')">Book Slot &rarr;</button>
                    </div>
                </div>
            </div>
            <div class="scan-card">
                <div class="scan-icon-box"><i class="fas fa-procedures"></i></div>
                <div class="scan-info">
                    <h4 class="scan-title">MRI Scans (1.5T / 3T)</h4>
                    <div class="scan-desc">Brain, Spine, Knee Joint, Abdominal &amp; Pelvic high-definition resonance scans.</div>
                    <div class="scan-meta-row">
                        <span class="scan-price">Starts @ ₹2,999</span>
                        <button type="button" class="btn-scan-inquire" onclick="inquireScan('MRI Scan')">Book Slot &rarr;</button>
                    </div>
                </div>
            </div>
            <div class="scan-card">
                <div class="scan-icon-box"><i class="fas fa-ring"></i></div>
                <div class="scan-info">
                    <h4 class="scan-title">CT Scans (128 Slice)</h4>
                    <div class="scan-desc">HRCT Chest, Head/Brain, Whole Abdomen with high-speed multi-slice precision.</div>
                    <div class="scan-meta-row">
                        <span class="scan-price">Starts @ ₹1,800</span>
                        <button type="button" class="btn-scan-inquire" onclick="inquireScan('CT Scan')">Book Slot &rarr;</button>
                    </div>
                </div>
            </div>
            <div class="scan-card">
                <div class="scan-icon-box"><i class="fas fa-wave-square"></i></div>
                <div class="scan-info">
                    <h4 class="scan-title">Ultrasound &amp; Sonography</h4>
                    <div class="scan-desc">Whole Abdomen, Pelvis, Pregnancy Anomaly scans &amp; Color Doppler.</div>
                    <div class="scan-meta-row">
                        <span class="scan-price">Starts @ ₹700</span>
                        <button type="button" class="btn-scan-inquire" onclick="inquireScan('Ultrasound / Sonography')">Book Slot &rarr;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HOW UPCHAR LABS WORKS -->
    <div class="section-container">
        <div class="timeline-card">
            <div style="text-align: center; margin-bottom: 34px;">
                <span style="font-size: 12px; font-weight: 800; color: var(--up-teal); text-transform: uppercase; letter-spacing: 0.5px;">Simple 4-Step Process</span>
                <h2 style="font-size: 1.45rem; font-weight: 800; color: var(--up-navy); margin: 4px 0;">How Upchar Labs Works</h2>
                <p style="font-size: 13px; color: var(--up-muted); margin: 0;">Painless, hygienic diagnostic testing delivered right to your doorstep</p>
            </div>
            <div class="timeline-steps-grid">
                <div class="timeline-step-item">
                    <span class="timeline-step-num">1</span>
                    <div class="timeline-icon-box"><i class="fas fa-search"></i></div>
                    <h4 class="timeline-step-title">Search &amp; Book Online</h4>
                    <p class="timeline-step-desc">Pick your required blood test or package, or simply upload a doctor's prescription.</p>
                </div>
                <div class="timeline-step-item">
                    <span class="timeline-step-num">2</span>
                    <div class="timeline-icon-box"><i class="fas fa-user-md"></i></div>
                    <h4 class="timeline-step-title">Phlebotomist Assigned</h4>
                    <p class="timeline-step-desc">A certified, fully-vaccinated healthcare professional is scheduled for your chosen time.</p>
                </div>
                <div class="timeline-step-item">
                    <span class="timeline-step-num">3</span>
                    <div class="timeline-icon-box"><i class="fas fa-vial"></i></div>
                    <h4 class="timeline-step-title">Safe Home Collection</h4>
                    <p class="timeline-step-desc">Hygienic collection using barcoded, sealed vacuum tubes with temperature-controlled transit.</p>
                </div>
                <div class="timeline-step-item">
                    <span class="timeline-step-num">4</span>
                    <div class="timeline-icon-box"><i class="fas fa-file-medical-alt"></i></div>
                    <h4 class="timeline-step-title">Smart Digital Reports</h4>
                    <p class="timeline-step-desc">MD-pathologist verified digital PDF reports sent on WhatsApp &amp; Email within 6-12 hours.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TRUST & QUALITY BANNER -->
    <div class="section-container">
        <div class="trust-banner">
            <div class="trust-features-grid">
                <div class="trust-feature-item">
                    <div class="trust-icon-pill"><i class="fas fa-award"></i></div>
                    <div>
                        <h4 class="trust-feature-title">NABL &amp; CAP Accredited</h4>
                        <p class="trust-feature-desc">All tests processed through certified labs adhering to international diagnostic accuracy.</p>
                    </div>
                </div>
                <div class="trust-feature-item">
                    <div class="trust-icon-pill"><i class="fas fa-shield-virus"></i></div>
                    <div>
                        <h4 class="trust-feature-title">Strict Hygiene Protocol</h4>
                        <p class="trust-feature-desc">Single-use needles, sanitized kits, and cold-chain sample preservation during transport.</p>
                    </div>
                </div>
                <div class="trust-feature-item">
                    <div class="trust-icon-pill"><i class="fas fa-clock"></i></div>
                    <div>
                        <h4 class="trust-feature-title">Fast &amp; Accurate Reports</h4>
                        <p class="trust-feature-desc">98% of test reports dispatched on WhatsApp within 6 to 12 hours of home collection.</p>
                    </div>
                </div>
                <div class="trust-feature-item">
                    <div class="trust-icon-pill"><i class="fas fa-user-check"></i></div>
                    <div>
                        <h4 class="trust-feature-title">Free Doctor Consultation</h4>
                        <p class="trust-feature-desc">Complimentary post-report medical consultation to explain all test biomarkers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- =========================================================
     TAB CONTENT: ALL DIAGNOSTIC TESTS (tab=tests)
     ========================================================= -->
<?php elseif ($active_tab == 'tests'): ?>

    <div class="section-container">
        <div class="catalog-section">
            <div class="section-head-row">
                <div>
                    <h2 class="section-title">
                        <i class="fas fa-flask" style="color: var(--up-teal);"></i> 
                        <?=!empty($keyword) ? 'Search Results for "'.html_escape($keyword).'"' : 'All Diagnostic Tests';?>
                    </h2>
                    <p class="section-subtitle">Showing <?=count($all_tests);?> certified diagnostic tests available for doorstep collection</p>
                </div>
                <?php if(!empty($keyword) || !empty($selected_city) || !empty($selected_lab) || !empty($selected_category)): ?>
                    <a href="<?=base_url('mytest?tab=tests');?>" class="btn btn-sm btn-outline-secondary" style="font-weight: 700; font-size: 12px; border-radius: 6px;">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                <?php endif; ?>
            </div>

            <!-- Category Filter Pills -->
            <div class="category-filter-pills">
                <a href="<?=base_url('mytest?tab=tests' . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="category-pill <?=empty($selected_category) ? 'active' : '';?>">
                    All Categories (<?=$total_tests_count;?>)
                </a>
                <?php if(!empty($categories)): ?>
                    <?php foreach($categories as $cat): ?>
                        <a href="<?=base_url('mytest?tab=tests&category='.$cat->category_id . ($selected_city ? '&city='.$selected_city : '') . ($selected_lab ? '&lab_id='.$selected_lab : '') . ($keyword ? '&keyword='.urlencode($keyword) : ''));?>" class="category-pill <?=($selected_category == $cat->category_id) ? 'active' : '';?>">
                            <?=html_escape($cat->category_name);?> (<?=$cat->test_count;?>)
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- All Tests List -->
            <?php if(!empty($all_tests)): ?>
                <?php foreach($all_tests as $test): ?>
                    <?php $in_cart = isset($cart[$test->test_id]); ?>
                    <div class="test-row-item">
                        <div class="test-info-block">
                            <div class="test-name-line">
                                <span><?=html_escape($test->test_name);?></span>
                                <?php if(!empty($test->short_name)): ?>
                                    <span class="badge" style="background: #e2e8f0; color: #475569; font-size: 11px;">
                                        <?=html_escape($test->short_name);?>
                                    </span>
                                <?php endif; ?>
                                <?php if(!empty($test->code)): ?>
                                    <span class="badge" style="background: #f1f5f9; color: #0284c7; font-size: 10px; font-family: monospace;">
                                        <?=html_escape($test->code);?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="test-meta-pills">
                                <span>
                                    <i class="fas fa-hospital" style="color: var(--up-teal);"></i> 
                                    <a href="<?=base_url('mytest?tab=tests&lab_id='.$test->path_id);?>" style="color: inherit; text-decoration: underline;">
                                        <?=html_escape($test->lab_name ?: 'Upchar Partner Lab');?>
                                    </a>
                                </span>
                                <span><i class="fas fa-tint" style="color: #ef4444;"></i> <?=html_escape($test->test_type ?: 'Blood Sample');?></span>
                                <span><i class="fas fa-clock" style="color: #0284c7;"></i> <?=html_escape($test->report_day ?: 'Same Day Report');?></span>
                                <span style="color: #059669; font-weight: 700;"><i class="fas fa-home"></i> Free Home Pickup</span>
                            </div>
                        </div>

                        <div class="test-price-box" style="display: flex; align-items: center; gap: 10px;">
                            <div class="test-amount-lg" style="margin-right: 4px;">₹<?=number_format($test->amount);?></div>
                            <button type="button" class="btn-package-add btn-cart-toggle <?=$in_cart ? 'in-cart' : '';?>" 
                                    data-test-id="<?=$test->test_id;?>" style="width: auto; padding: 7px 16px; font-size: 12.5px;">
                                <?=$in_cart ? '<i class="fas fa-check"></i> Added' : '<i class="fas fa-plus"></i> Add Test';?>
                            </button>
                            <button type="button" class="btn-book-instant btn-open-quick-book"
                                    data-test-id="<?=$test->test_id;?>"
                                    data-test-name="<?=html_escape($test->test_name);?>"
                                    data-lab-id="<?=$test->path_id;?>"
                                    data-lab-name="<?=html_escape($test->lab_name ?: 'Partner Lab');?>"
                                    data-amount="<?=$test->amount;?>">
                                Book Now
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 50px 20px; background: #ffffff; border-radius: 12px; border: 1px dashed #cbd5e1; margin-top: 10px;">
                    <i class="fas fa-flask" style="font-size: 44px; color: #cbd5e1; margin-bottom: 14px;"></i>
                    <h4 style="font-size: 16px; color: var(--up-navy); font-weight: 800; margin-bottom: 6px;">No diagnostic tests match your criteria</h4>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 18px;">Try clearing search keywords or selecting "All Locations".</p>
                    <a href="<?=base_url('mytest?tab=tests');?>" class="btn btn-sm" style="background: var(--up-teal); color: #fff; font-weight: 700; border-radius: 8px; padding: 8px 20px;">
                        Reset Filters
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

<!-- =========================================================
     TAB CONTENT: PARTNER PATHOLOGY LABS (tab=labs)
     ========================================================= -->
<?php elseif ($active_tab == 'labs'): ?>

    <div class="section-container">
        <div class="section-head-row">
            <div>
                <h2 class="section-title">
                    <i class="fas fa-hospital" style="color: var(--up-teal);"></i> Accredited Partner Pathology Labs
                </h2>
                <p class="section-subtitle">Showing <?=count($pathologies);?> verified pathology laboratories available in your area</p>
            </div>
            <?php if(!empty($keyword) || !empty($selected_city) || !empty($selected_lab)): ?>
                <a href="<?=base_url('mytest?tab=labs');?>" class="btn btn-sm btn-outline-secondary" style="font-weight: 700; font-size: 12px; border-radius: 6px;">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            <?php endif; ?>
        </div>

        <div class="partner-labs-grid">
            <?php if(!empty($pathologies)): ?>
                <?php foreach($pathologies as $lab): ?>
                    <div class="partner-lab-card">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                                <div>
                                    <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                                        <?=html_escape($lab->name);?>
                                    </h3>
                                    <div style="font-size: 12px; color: #64748b;">
                                        <i class="fas fa-map-marker-alt text-danger" style="color: #ef4444;"></i>
                                        <?=html_escape($lab->address ?: $lab->location ?: ($lab->city_name ?: 'Partner Diagnostic Center'));?>
                                    </div>
                                    <?php if(!empty($lab->mobile)): ?>
                                        <div style="font-size: 11.5px; color: #0284c7; margin-top: 2px;">
                                            <i class="fas fa-phone-alt"></i> <a href="tel:<?=$lab->mobile;?>" style="color: inherit;"><?=html_escape($lab->mobile);?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <span class="lab-card-badge">
                                    <i class="fas fa-shield-alt"></i> NABL / Verified
                                </span>
                            </div>

                            <ul class="lab-tests-preview-list">
                                <?php if(!empty($lab->tests)): ?>
                                    <?php foreach(array_slice($lab->tests, 0, 4) as $lt): ?>
                                        <li class="lab-test-preview-item">
                                            <span><i class="fas fa-check" style="color: #00a896; font-size: 11px;"></i> <?=html_escape($lt->short_name ?: $lt->test_name);?></span>
                                            <strong style="color: #00a896;">₹<?=number_format($lt->amount);?></strong>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="lab-test-preview-item"><span><i class="fas fa-check" style="color: #00a896;"></i> Complete Hemogram (CBC)</span><strong>₹299</strong></li>
                                    <li class="lab-test-preview-item"><span><i class="fas fa-check" style="color: #00a896;"></i> Liver &amp; Kidney Tests</span><strong>₹499</strong></li>
                                    <li class="lab-test-preview-item"><span><i class="fas fa-check" style="color: #00a896;"></i> Lipid Profile Comprehensive</span><strong>₹599</strong></li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div style="border-top: 1px solid #f1f5f9; padding-top: 14px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 11px; color: #64748b;">Tests from</div>
                                <div style="font-size: 17px; font-weight: 900; color: #00a896;">₹<?=number_format($lab->starting_price);?></div>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <a href="<?=base_url('mytest?tab=tests&lab_id='.$lab->id);?>" class="btn btn-sm btn-outline-secondary" style="font-weight: 700; font-size: 12px; border-radius: 8px;">
                                    View Tests (<?=$lab->total_test_count;?>)
                                </a>
                                <button type="button" class="btn-book-instant btn-open-quick-book"
                                        data-test-id="<?=(!empty($lab->tests) ? $lab->tests[0]->test_id : 22);?>"
                                        data-test-name="<?=(!empty($lab->tests) ? html_escape($lab->tests[0]->test_name) : 'Diagnostic Blood Checkup');?>"
                                        data-lab-id="<?=$lab->id;?>"
                                        data-lab-name="<?=html_escape($lab->name);?>"
                                        data-amount="<?=(!empty($lab->tests) ? $lab->tests[0]->amount : 299);?>">
                                    Book Test
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px 20px; background: #ffffff; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <i class="fas fa-hospital" style="font-size: 44px; color: #cbd5e1; margin-bottom: 14px;"></i>
                    <h4 style="font-size: 16px; color: var(--up-navy); font-weight: 800; margin-bottom: 6px;">No laboratories found matching your criteria</h4>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 18px;">Try selecting "All Locations" or clearing keyword filters.</p>
                    <a href="<?=base_url('mytest?tab=labs');?>" class="btn btn-sm" style="background: var(--up-teal); color: #fff; font-weight: 700; border-radius: 8px; padding: 8px 20px;">
                        Reset Filters
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

<!-- =========================================================
     TAB CONTENT: HEALTH PACKAGES (tab=packages)
     ========================================================= -->
<?php elseif ($active_tab == 'packages'): ?>

    <div class="section-container">
        <div class="section-head-row">
            <div>
                <h2 class="section-title">
                    <i class="fas fa-notes-medical" style="color: var(--up-teal);"></i> Preventive Health Checkup Packages
                </h2>
                <p class="section-subtitle">Doctor-designed diagnostic packages with comprehensive parameter coverage</p>
            </div>
        </div>

        <div class="packages-grid">
            <?php if(!empty($packages)): ?>
                <?php foreach($packages as $pkg): ?>
                    <?php $in_cart = isset($cart[$pkg->test_id]); ?>
                    <div class="package-card" style="border-color: #99f6e4;">
                        <div>
                            <span class="package-badge-home">
                                <i class="fas fa-home"></i> Home Sample Collection
                            </span>
                            <h3 class="package-title"><?=html_escape($pkg->test_name);?></h3>
                            <span class="package-tests-pill"><?=html_escape($pkg->lab_name ?: 'Upchar Partner Lab');?></span>

                            <ul class="package-features-list">
                                <li><i class="fas fa-check-circle"></i> Comprehensive Organ Biomarkers</li>
                                <li><i class="fas fa-check-circle"></i> Complete Blood Count (CBC) Parameters</li>
                                <li><i class="fas fa-check-circle"></i> Lipid Profile &amp; Metabolic Markers</li>
                                <li><i class="fas fa-check-circle"></i> Fasting Blood Sugar &amp; Urine Analysis</li>
                                <li><i class="fas fa-check-circle"></i> Free MD Doctor Consultation on Report</li>
                            </ul>
                        </div>

                        <div>
                            <div class="package-pricing-row">
                                <div>
                                    <span class="price-main">₹<?=number_format($pkg->amount);?></span>
                                    <span class="price-original">₹<?=number_format($pkg->amount * 2.2);?></span>
                                </div>
                                <span class="price-discount-tag">55% OFF</span>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <button type="button" class="btn-package-add btn-cart-toggle <?=$in_cart ? 'in-cart' : '';?>" data-test-id="<?=$pkg->test_id;?>" style="flex: 1;">
                                    <?=$in_cart ? '<i class="fas fa-check"></i> In Cart' : '<i class="fas fa-shopping-cart"></i> Add to Cart';?>
                                </button>
                                <button type="button" class="btn-book-instant btn-open-quick-book" 
                                        data-test-id="<?=$pkg->test_id;?>" 
                                        data-test-name="<?=html_escape($pkg->test_name);?>" 
                                        data-lab-id="<?=$pkg->path_id;?>" 
                                        data-lab-name="<?=html_escape($pkg->lab_name ?: 'Partner Lab');?>" 
                                        data-amount="<?=$pkg->amount;?>">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

<!-- =========================================================
     TAB CONTENT: RADIOLOGY & SCANS (tab=scans)
     ========================================================= -->
<?php elseif ($active_tab == 'scans'): ?>

    <div class="section-container">
        <div class="section-head-row">
            <div>
                <h2 class="section-title">
                    <i class="fas fa-x-ray" style="color: #0284c7;"></i> Diagnostic Imaging &amp; Radiology Scans
                </h2>
                <p class="section-subtitle">High-precision diagnostic imaging at partner diagnostic hospitals &amp; scan centers</p>
            </div>
            <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 8px;">
                <i class="fas fa-hospital"></i> Center Visits with Assistance
            </span>
        </div>

        <div class="scans-grid">
            <div class="scan-card">
                <div class="scan-icon-box"><i class="fas fa-x-ray"></i></div>
                <div class="scan-info">
                    <h4 class="scan-title">Digital X-Ray</h4>
                    <div class="scan-desc">Chest X-Ray, Spine, Joint &amp; Bone Radiography with digital HD films.</div>
                    <div class="scan-meta-row">
                        <span class="scan-price">Starts @ ₹350</span>
                        <button type="button" class="btn-scan-inquire" onclick="inquireScan('Digital X-Ray')">Book Slot &rarr;</button>
                    </div>
                </div>
            </div>
            <div class="scan-card">
                <div class="scan-icon-box"><i class="fas fa-procedures"></i></div>
                <div class="scan-info">
                    <h4 class="scan-title">MRI Scans (1.5T / 3T)</h4>
                    <div class="scan-desc">Brain, Spine, Knee Joint, Abdominal &amp; Pelvic high-definition resonance scans.</div>
                    <div class="scan-meta-row">
                        <span class="scan-price">Starts @ ₹2,999</span>
                        <button type="button" class="btn-scan-inquire" onclick="inquireScan('MRI Scan')">Book Slot &rarr;</button>
                    </div>
                </div>
            </div>
            <div class="scan-card">
                <div class="scan-icon-box"><i class="fas fa-ring"></i></div>
                <div class="scan-info">
                    <h4 class="scan-title">CT Scans (128 Slice)</h4>
                    <div class="scan-desc">HRCT Chest, Head/Brain, Whole Abdomen with high-speed multi-slice precision.</div>
                    <div class="scan-meta-row">
                        <span class="scan-price">Starts @ ₹1,800</span>
                        <button type="button" class="btn-scan-inquire" onclick="inquireScan('CT Scan')">Book Slot &rarr;</button>
                    </div>
                </div>
            </div>
            <div class="scan-card">
                <div class="scan-icon-box"><i class="fas fa-wave-square"></i></div>
                <div class="scan-info">
                    <h4 class="scan-title">Ultrasound &amp; Sonography</h4>
                    <div class="scan-desc">Whole Abdomen, Pelvis, Pregnancy Anomaly scans &amp; Color Doppler.</div>
                    <div class="scan-meta-row">
                        <span class="scan-price">Starts @ ₹700</span>
                        <button type="button" class="btn-scan-inquire" onclick="inquireScan('Ultrasound / Sonography')">Book Slot &rarr;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- =========================================================
     TAB CONTENT: TEST CART & SECURE CHECKOUT (tab=checkout)
     ========================================================= -->
<?php elseif ($active_tab == 'checkout'): ?>

    <div class="section-container" style="max-width: 1200px;">
        
        <!-- Breadcrumbs & Step Indicator Bar -->
        <div class="checkout-header-bar">
            <div class="checkout-title-wrap">
                <h1 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0 0 4px 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-shield-alt" style="color: var(--up-teal);"></i> Secure Diagnostic Checkout
                </h1>
                <p style="font-size: 13px; color: #64748B; margin: 0;">
                    Certified lab booking with doorstep sample pickup &amp; 100% verified digital reports.
                </p>
            </div>

            <!-- Stepper Indicator -->
            <div class="checkout-stepper">
                <div class="step-pill <?=!empty($cart) ? 'completed' : 'active';?>">
                    <i class="fas fa-shopping-cart"></i> 1. Cart Review
                </div>
                <div class="step-divider"><i class="fas fa-chevron-right"></i></div>
                <div class="step-pill <?=!empty($cart) ? 'active' : '';?>">
                    <i class="fas fa-calendar-check"></i> 2. Patient &amp; Schedule
                </div>
                <div class="step-divider"><i class="fas fa-chevron-right"></i></div>
                <div class="step-pill">
                    <i class="fas fa-receipt"></i> 3. Confirmed
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
                    You do not have any lab tests or checkup packages selected yet. Explore our certified tests catalog or add a recommended checkup below:
                </p>

                <a href="<?=base_url('mytest?tab=tests');?>" class="btn" style="background: #00A896; color: #FFFFFF; font-weight: 700; border-radius: 10px; padding: 10px 24px; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 30px;">
                    <i class="fas fa-search"></i> Browse Full Diagnostic Catalog
                </a>

                <?php if (!empty($popular_tests)): ?>
                    <div style="text-align: left; margin-top: 10px; border-top: 1px solid #F1F5F9; padding-top: 24px;">
                        <h4 style="font-size: 15px; font-weight: 800; color: #0F172A; margin-bottom: 16px;">Popular Preventive Checkups (1-Click Add)</h4>
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
                                    <button type="button" class="btn btn-sm btn-cart-toggle" data-test-id="<?=$pt->test_id;?>" style="background: #00A896; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 6px 14px; font-size: 12px; border: none; cursor: pointer;">
                                        + Add Test
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>

            <form action="<?=base_url('mytest/process_payment');?>" method="POST" id="mainCheckoutForm">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                <input type="hidden" name="ajax" value="1">

                <div class="row">
                    <!-- LEFT COLUMN: Patient, Location, Scheduling & Payment (8 cols) -->
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
                                    <i class="fas fa-user"></i> Myself (<?=html_escape($patient_name ?: (@$user->FNAME ?: 'Patient'));?>)
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
                                    <label>Patient Full Name <span style="color: #EF4444;">*</span></label>
                                    <input type="text" name="patient_name" id="inputPatientName" class="form-control" required placeholder="Full Name as per Aadhaar / ID" value="<?=html_escape($patient_name ?: @$user->FNAME);?>">
                                </div>

                                <div class="col-md-3 col-6 form-group upchar-input-wrap">
                                    <label>Age (Years) <span style="color: #EF4444;">*</span></label>
                                    <input type="number" name="patient_age" id="inputPatientAge" class="form-control" required min="1" max="120" placeholder="e.g. 35" value="<?=$patient_age ?: 32;?>">
                                </div>

                                <div class="col-md-3 col-6 form-group upchar-input-wrap">
                                    <label>Gender <span style="color: #EF4444;">*</span></label>
                                    <select name="patient_gender" id="selectPatientGender" class="form-control">
                                        <option value="Male" <?=$patient_gender==='Male' ? 'selected' : '';?>>Male</option>
                                        <option value="Female" <?=$patient_gender==='Female' ? 'selected' : '';?>>Female</option>
                                        <option value="Other" <?=$patient_gender==='Other' ? 'selected' : '';?>>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-12 form-group upchar-input-wrap">
                                    <label>10-Digit Mobile Number <span style="color: #EF4444;">*</span></label>
                                    <input type="tel" name="patient_mobile" id="inputPatientMobile" class="form-control" required maxlength="10" placeholder="Mobile for phlebotomist call &amp; SMS updates" value="<?=html_escape($patient_mobile ?: @$user->MOBILE);?>">
                                </div>

                                <div class="col-md-6 col-12 form-group upchar-input-wrap">
                                    <label>Email Address (for PDF Report) <span style="color: #EF4444;">*</span></label>
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

                            <!-- Home Address Input -->
                            <div id="homeAddressContainer" class="form-group upchar-input-wrap" style="margin-bottom: 16px;">
                                <label>Complete Pickup Address <span style="color: #EF4444;">*</span></label>
                                <textarea name="patient_address" id="patientAddressInput" rows="2" class="form-control" required placeholder="House / Flat No, Building / Apartment Name, Street, Landmark, PIN Code"></textarea>
                                <span style="font-size: 11.5px; color: #64748B; margin-top: 4px; display: block;">
                                    <i class="fas fa-info-circle" style="color: #00A896;"></i> Phlebotomist calls 15-20 minutes prior to arrival.
                                </span>
                            </div>

                            <!-- Fasting Notice -->
                            <div class="fasting-notice-box">
                                <i class="fas fa-utensils"></i>
                                <div>
                                    <strong>Fasting Guideline Note:</strong> For tests like Fasting Blood Sugar, Lipid Profile, or Full Body Checkup, please observe <strong>10 to 12 hours of overnight fasting</strong>. Drinking plain water is allowed and recommended.
                                </div>
                            </div>

                            <!-- Date & Time Slot Scheduling -->
                            <div style="margin-top: 20px;">
                                <div class="row">
                                    <div class="col-md-5 col-12 form-group upchar-input-wrap">
                                        <label>Select Appointment Date <span style="color: #EF4444;">*</span></label>
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
                                        <label>Preferred Time Slot <span style="color: #EF4444;">*</span></label>
                                        <select name="time_slot" id="timeSlotSelect" class="form-control" required>
                                            <option value="Early Morning (06:30 AM - 08:30 AM)">🌅 Early Morning (06:30 AM - 08:30 AM) - Best for Fasting</option>
                                            <option value="Morning (08:30 AM - 11:30 AM)" selected>☀️ Morning (08:30 AM - 11:30 AM) - Most Popular</option>
                                            <option value="Afternoon (12:00 PM - 03:00 PM)">🌤️ Afternoon (12:00 PM - 03:00 PM)</option>
                                            <option value="Evening (04:00 PM - 07:00 PM)">🌆 Evening (04:00 PM - 07:00 PM)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group upchar-input-wrap" style="margin-bottom: 0;">
                                <label style="font-weight: 600; color: #64748B;">Special Instructions or Landmark Note (Optional)</label>
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

                            <label class="choice-card selected" id="payMethodCOD" style="margin-bottom: 12px;">
                                <input type="radio" name="payment_mode" value="COD" checked onchange="togglePaymentMode(this.value)">
                                <div class="choice-card-info">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <strong><i class="fas fa-hand-holding-usd" style="color: #16A34A; margin-right: 4px;"></i> Pay on Sample Collection (Cash or UPI QR at Doorstep)</strong>
                                        <span style="background: #DCFCE7; color: #166534; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">Recommended</span>
                                    </div>
                                    <p>Pay cash or simply scan the visiting phlebotomist's dynamic UPI QR code via Google Pay, PhonePe, or Paytm once your samples are drawn.</p>
                                </div>
                            </label>

                            <label class="choice-card" id="payMethodUPI" style="margin-bottom: 12px;">
                                <input type="radio" name="payment_mode" value="ONLINE_UPI" onchange="togglePaymentMode(this.value)">
                                <div class="choice-card-info">
                                    <strong><i class="fas fa-qrcode" style="color: #0284C7; margin-right: 4px;"></i> Instant Online UPI / QR Code</strong>
                                    <p>Seamless payment with Google Pay, PhonePe, Paytm, BHIM, or any UPI banking app.</p>
                                </div>
                            </label>

                            <label class="choice-card" id="payMethodCard">
                                <input type="radio" name="payment_mode" value="ONLINE_CARD" onchange="togglePaymentMode(this.value)">
                                <div class="choice-card-info">
                                    <strong><i class="fas fa-credit-card" style="color: #7C3AED; margin-right: 4px;"></i> Debit Card, Credit Card &amp; Net Banking</strong>
                                    <p>256-bit SSL bank-grade checkout supporting all major Indian banks and card networks.</p>
                                </div>
                            </label>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN: Sticky Order Summary (4 cols) -->
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

                            <!-- Coupon Box -->
                            <div class="coupon-box" style="background: #FFFFFF; border: 1.5px dashed #CBD5E1; border-radius: 12px; padding: 12px; margin-bottom: 14px;">
                                <div style="font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                                    <span><i class="fas fa-tag" style="color: #00A896;"></i> Apply Promo Code</span>
                                    <span id="labAppliedBadge" style="display:none; background: #DCFCE7; color: #166534; font-size: 11px; padding: 2px 8px; border-radius: 12px; font-weight: 700;">Applied</span>
                                </div>
                                <div style="display: flex; gap: 6px;">
                                    <input type="text" id="labCouponInput" name="applied_coupon_code" class="form-control" placeholder="e.g. LABCARE20" style="text-transform: uppercase; font-weight: 700; font-size: 12px; border-radius: 8px; height: 38px;">
                                    <button type="button" id="btnApplyLabCoupon" class="btn" style="background: #00A896; color: #FFF; font-weight: 700; font-size: 12px; border-radius: 8px; padding: 6px 14px; white-space: nowrap;">Apply</button>
                                    <button type="button" id="btnRemoveLabCoupon" class="btn btn-outline-danger" style="display:none; border-radius: 8px; padding: 6px 10px;" title="Remove Coupon"><i class="fas fa-times"></i></button>
                                </div>
                                <div id="labCouponFeedback" style="font-size: 12px; margin-top: 6px; display: none;"></div>

                                <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
                                    <span style="font-size: 11px; color: #64748B; font-weight: 600;">Offers:</span>
                                    <span class="coupon-chip" onclick="quickApplyLabCoupon('LABCARE20')" style="cursor: pointer; background: #E0F2FE; color: #0369A1; border: 1px solid #BAE6FD; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px;">LABCARE20 (20% OFF)</span>
                                    <span class="coupon-chip" onclick="quickApplyLabCoupon('HEALTH50')" style="cursor: pointer; background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px;">HEALTH50 (₹50 OFF)</span>
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
                                <div class="price-row total">
                                    <span>Total Payable:</span>
                                    <span class="grand-amount" id="checkoutFinalTotal">₹<?=number_format($final_total);?></span>
                                </div>
                            </div>

                            <div id="checkoutMsgBox" style="display: none; margin-bottom: 12px; font-size: 12.5px; padding: 10px; border-radius: 8px;"></div>

                            <!-- Confirm Booking CTA -->
                            <button type="submit" class="btn-confirm-checkout" id="btnPlaceOrder">
                                <i class="fas fa-lock"></i> Confirm Booking Now <i class="fas fa-arrow-right"></i>
                            </button>

                            <div style="font-size: 11px; text-align: center; color: #64748B; margin-top: 10px;">
                                By confirming, you agree to Upchar Medical Terms &amp; Conditions.
                            </div>

                            <div class="security-assurance-list">
                                <div><i class="fas fa-check-circle"></i> Free Sample Pickup by DMLT Certified Staff</div>
                                <div><i class="fas fa-check-circle"></i> Digital Reports on WhatsApp, SMS &amp; Email</div>
                                <div><i class="fas fa-check-circle"></i> Zero Cancellation Charges before sample collection</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

<?php endif; ?>

<!-- =========================================================
     FLOATING CART PILL & SLIDE-OUT CART DRAWER
     ========================================================= -->
<div class="floating-cart-bar" id="floatingCartBtn" style="<?=empty($cart) ? 'display:none;' : '';?>">
    <i class="fas fa-shopping-cart" style="font-size: 16px; color: #5eead4;"></i>
    <span style="font-weight: 700; font-size: 13.5px;">
        <span class="cart-total-items"><?=count($cart);?></span> Tests Selected
    </span>
    <span style="font-weight: 800; font-size: 14px; color: #5eead4;">
        ₹<span class="cart-total-amount"><?=number_format(array_sum(array_column($cart, 'amount')));?></span>
    </span>
    <span style="background: var(--up-teal); color: #ffffff; font-weight: 800; font-size: 11px; padding: 4px 12px; border-radius: 16px;">
        View Cart &rarr;
    </span>
</div>

<!-- Cart Drawer Overlay -->
<div class="cart-drawer-overlay" id="cartOverlay"></div>

<!-- Slide-Out Cart Panel -->
<div class="cart-drawer-panel" id="cartDrawer">
    <div style="background: #0f172a; color: #ffffff; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-flask" style="color: var(--up-teal); font-size: 18px;"></i>
            <h4 style="font-size: 15px; font-weight: 800; margin: 0; color: #ffffff;">Diagnostics Cart</h4>
        </div>
        <button type="button" id="btnCloseDrawer" style="background: none; border: none; color: #94a3b8; font-size: 22px; cursor: pointer; line-height: 1;">&times;</button>
    </div>

    <div id="drawerCartItems" style="flex-grow: 1; overflow-y: auto; padding: 16px 18px;">
        <!-- Dynamic cart items rendered via JS -->
    </div>

    <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 18px;">
        <div style="display: flex; justify-content: space-between; font-size: 12.5px; color: #64748b; margin-bottom: 6px;">
            <span>Home Sample Pickup:</span>
            <span style="color: #16a34a; font-weight: 700;">FREE (₹0)</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: baseline; font-size: 14.5px; font-weight: 800; color: #0f172a; margin-bottom: 14px;">
            <span>Total Payable:</span>
            <span style="font-size: 20px; color: var(--up-teal);">₹<span class="cart-total-amount"><?=number_format(array_sum(array_column($cart, 'amount')));?></span></span>
        </div>
        <a href="<?=base_url('mytest?tab=checkout');?>" style="background: var(--up-teal); color: #ffffff; text-decoration: none !important; width: 100%; justify-content: space-between; display: flex; align-items: center; padding: 12px 18px; font-weight: 800; font-size: 14px; border-radius: 8px; box-shadow: 0 4px 14px rgba(0,168,150,0.3);">
            <span>Review &amp; Checkout Tests</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- =========================================================
     INSTANT QUICK BOOK MODAL (1-Step Booking)
     ========================================================= -->
<div class="custom-modal-overlay" id="quickBookModalOverlay">
    <div class="custom-modal-card" style="max-width: 520px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-calendar-check" style="color: var(--up-teal); font-size: 20px;"></i>
                <h3 style="font-size: 16px; font-weight: 800; margin: 0; color: #0f172a;">Home Sample Collection Booking</h3>
            </div>
            <button type="button" onclick="closeQuickBookModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 8px; padding: 10px 14px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <strong id="qb_test_name_display" style="color: #0f766e; font-size: 13.5px;">Diagnostic Blood Test</strong>
                <div id="qb_lab_name_display" style="font-size: 11.5px; color: #64748b;">Upchar Partner Lab</div>
            </div>
            <div style="font-size: 17px; font-weight: 900; color: #00a896;">₹<span id="qb_amount_display">0</span></div>
        </div>

        <form id="instantQuickBookForm">
            <input type="hidden" name="test_id" id="qb_test_id">
            <input type="hidden" name="lab_id" id="qb_lab_id">

            <div class="row" style="margin: 0 -6px;">
                <div class="col-xs-12 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Patient Full Name *</label>
                    <input type="text" name="patient_name" id="qb_patient_name" class="form-control" placeholder="e.g. Rahul Sharma" required style="border-radius: 8px; font-size: 13px;">
                </div>
                <div class="col-xs-12 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Mobile Number *</label>
                    <input type="tel" name="patient_mobile" id="qb_patient_mobile" class="form-control" placeholder="10-digit mobile" required pattern="[0-9]{10}" style="border-radius: 8px; font-size: 13px;">
                </div>
            </div>

            <div class="row" style="margin: 0 -6px;">
                <div class="col-xs-6" style="padding: 0 6px; margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Age</label>
                    <input type="number" name="patient_age" id="qb_patient_age" class="form-control" placeholder="e.g. 32" style="border-radius: 8px; font-size: 13px;">
                </div>
                <div class="col-xs-6" style="padding: 0 6px; margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Gender</label>
                    <select name="patient_gender" id="qb_patient_gender" class="form-control" style="border-radius: 8px; font-size: 13px;">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="row" style="margin: 0 -6px;">
                <div class="col-xs-12 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Collection Date *</label>
                    <input type="date" name="booking_date" id="qb_booking_date" class="form-control" value="<?=date('Y-m-d');?>" min="<?=date('Y-m-d');?>" required style="border-radius: 8px; font-size: 13px;">
                </div>
                <div class="col-xs-12 col-sm-6" style="padding: 0 6px; margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Preferred Slot *</label>
                    <select name="time_slot" id="qb_time_slot" class="form-control" style="border-radius: 8px; font-size: 13px;">
                        <option value="07:00 AM - 09:00 AM (Fasting)">07:00 AM - 09:00 AM (Fasting)</option>
                        <option value="09:00 AM - 11:00 AM (Morning)">09:00 AM - 11:00 AM (Morning)</option>
                        <option value="11:00 AM - 01:00 PM (Afternoon)">11:00 AM - 01:00 PM (Afternoon)</option>
                        <option value="04:00 PM - 07:00 PM (Evening)">04:00 PM - 07:00 PM (Evening)</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Home Collection Address *</label>
                <textarea name="patient_address" id="qb_patient_address" class="form-control" rows="2" placeholder="House / Flat No., Landmark, Locality, City..." required style="border-radius: 8px; font-size: 12.5px;"></textarea>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 12px; margin-bottom: 14px; font-size: 12px; color: #475569; display: flex; justify-content: space-between; align-items: center;">
                <span><i class="fas fa-money-bill-wave text-success" style="color: #16a34a;"></i> Payment Method:</span>
                <strong style="color: #0f172a;">Pay on Sample Collection (Cash/UPI)</strong>
            </div>

            <div id="qbMsgBox" style="display: none; margin-bottom: 12px; font-size: 12.5px; padding: 8px 12px; border-radius: 6px;"></div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-outline-secondary" onclick="closeQuickBookModal()" style="border-radius: 8px; font-weight: 600; font-size: 13px;">Cancel</button>
                <button type="submit" id="btnSubmitQuickBook" class="btn" style="background: var(--up-teal); color: #fff; border-radius: 8px; font-weight: 700; font-size: 13px; padding: 8px 22px;">
                    <i class="fas fa-check"></i> Confirm Booking
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     QUICK PRESCRIPTION UPLOAD MODAL
     ========================================================= -->
<div class="custom-modal-overlay" id="rxModalOverlay">
    <div class="custom-modal-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-file-prescription" style="color: #ea580c; font-size: 20px;"></i>
                <h3 style="font-size: 17px; font-weight: 800; margin: 0; color: #0f172a;">Upload Doctor Prescription</h3>
            </div>
            <button type="button" onclick="closePrescriptionModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <p style="font-size: 13px; color: #64748b; margin-bottom: 18px; line-height: 1.45;">
            Upload your doctor's handwritten or digital prescription. Our licensed medical coordinator will review it and book your required tests with home sample collection.
        </p>

        <form id="quickRxForm" enctype="multipart/form-data">
            <div style="margin-bottom: 14px;">
                <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Your Mobile Number *</label>
                <input type="text" name="patient_phone" id="rxPhone" class="form-control" placeholder="10-digit mobile number" required style="border-radius: 8px; font-size: 13.5px;">
            </div>

            <div style="margin-bottom: 18px;">
                <label style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Select Prescription File (JPG, PNG, PDF) *</label>
                <input type="file" name="prescription_file" id="rxFile" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required style="border-radius: 8px; font-size: 13px;">
            </div>

            <div id="rxMsgBox" style="display: none; margin-bottom: 14px; font-size: 13px; padding: 10px; border-radius: 6px;"></div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-outline-secondary" onclick="closePrescriptionModal()" style="border-radius: 8px; font-weight: 600; font-size: 13px;">Cancel</button>
                <button type="submit" id="btnSubmitRx" class="btn" style="background: var(--up-teal); color: #fff; border-radius: 8px; font-weight: 700; font-size: 13px; padding: 9px 20px;">
                    <i class="fas fa-cloud-upload-alt"></i> Submit Prescription
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================
     10. JAVASCRIPT INTEGRATION & CART LOGIC
     ========================================================= -->
<script>
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

function setDateValue(dateVal, chip) {
    $('.date-chip').removeClass('active');
    $(chip).addClass('active');
    $('#bookingDateInput').val(dateVal);
}

function clearCheckoutCart() {
    if (confirm('Are you sure you want to remove all tests from your diagnostic booking?')) {
        $.post('<?=base_url("mytest/clear_cart");?>', function() {
            window.location.href = '<?=base_url("mytest?tab=checkout");?>';
        });
    }
}

function openPrescriptionModal() {
    $('#rxModalOverlay').css('display', 'flex');
}

function closePrescriptionModal() {
    $('#rxModalOverlay').fadeOut(180);
}

function openQuickBookModal(testId, testName, labId, labName, amount) {
    $('#qb_test_id').val(testId);
    $('#qb_lab_id').val(labId || '');
    $('#qb_test_name_display').text(testName || 'Diagnostic Blood Test');
    $('#qb_lab_name_display').text(labName || 'Upchar Partner Lab');
    $('#qb_amount_display').text(Number(amount).toLocaleString());
    $('#qbMsgBox').hide();
    $('#quickBookModalOverlay').css('display', 'flex');
}

function closeQuickBookModal() {
    $('#quickBookModalOverlay').fadeOut(180);
}

function inquireScan(scanName) {
    var phone = prompt("Enter your 10-digit mobile number to book " + scanName + " appointment:");
    if (phone && phone.trim().length >= 10) {
        alert("Thank you! Our diagnostic radiology care coordinator will contact you at " + phone + " to schedule your " + scanName + " slot.");
    }
}

$(document).ready(function() {

    <?php if (!empty($open_checkout) && $active_tab != 'checkout'): ?>
        refreshCartDrawer();
        $('#cartOverlay').fadeIn(200);
        $('#cartDrawer').css('right', '0');
    <?php endif; ?>

    // Remove item from in-page checkout table
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
                        labGrossTotal = res.subtotal;
                        updateCartUI(res);
                        refreshCartDrawer();
                    } else {
                        window.location.reload();
                    }
                });
            }
        }, 'json');
    });

    // Coupon Code Management
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
            error: function() {
                btn.prop('disabled', false).text('Apply');
                fb.css('color', '#EF4444').text('Error validating coupon. Please try again.').show();
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

    // In-Page Checkout Form Submit via AJAX
    $('#mainCheckoutForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#btnPlaceOrder');
        var msgBox = $('#checkoutMsgBox');

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Confirming Booking...');
        msgBox.hide();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    btn.html('<i class="fas fa-check"></i> Booking Confirmed!');
                    msgBox.css({'display': 'block', 'background': '#ecfdf5', 'color': '#065f46', 'border': '1px solid #a7f3d0'})
                          .html('<i class="fas fa-check-circle"></i> ' + (res.message || 'Booking successful! Redirecting to confirmation...'));
                    setTimeout(function() {
                        window.location.href = res.redirect_url;
                    }, 700);
                } else {
                    btn.prop('disabled', false).html('<i class="fas fa-lock"></i> Confirm Booking Now <i class="fas fa-arrow-right"></i>');
                    msgBox.css({'display': 'block', 'background': '#fef2f2', 'color': '#991b1b', 'border': '1px solid #fecaca'})
                          .html('<i class="fas fa-exclamation-triangle"></i> ' + (res.message || 'Error completing booking.'));
                }
            },
            error: function() {
                form.off('submit').submit();
            }
        });
    });

    function updateCartUI(res) {
        if (res.cart_count > 0) {
            $('.cart-total-items').text(res.cart_count).show();
            $('.cart-total-amount').text(Number(res.subtotal).toLocaleString());
            $('#floatingCartBtn').fadeIn(200);
            $('#headerCartBadge').text(res.cart_count).show();
        } else {
            $('.cart-total-items').hide();
            $('#floatingCartBtn').fadeOut(200);
            $('#cartDrawer').css('right', '-420px');
            $('#cartOverlay').fadeOut(200);
            $('#headerCartBadge').hide();
        }
    }

    function refreshCartDrawer() {
        $.getJSON('<?=base_url("mytest/get_cart");?>', function(res) {
            if (res.cart_items && res.cart_items.length > 0) {
                var html = '';
                $.each(res.cart_items, function(idx, item) {
                    html += '<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 11px 13px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">' +
                        '<div>' +
                        '<div style="font-weight: 700; font-size: 13.5px; color: #0f172a; margin-bottom: 2px;">' + item.test_name + '</div>' +
                        '<div style="font-size: 11.5px; color: #64748b;"><i class="fas fa-hospital"></i> ' + item.lab_name + '</div>' +
                        '<div style="font-size: 11.5px; color: #0284c7; margin-top: 3px;"><i class="fas fa-tint"></i> ' + item.sample_type + ' &bull; ' + item.report_time + '</div>' +
                        '</div>' +
                        '<div style="text-align: right; flex-shrink: 0;">' +
                        '<div style="font-weight: 800; font-size: 14px; color: var(--up-teal);">₹' + Number(item.amount).toLocaleString() + '</div>' +
                        '<button type="button" class="btn-drawer-remove" data-test-id="' + item.test_id + '" style="background: none; border: none; color: #ef4444; font-size: 11.5px; font-weight: 600; cursor: pointer; padding: 3px 0;">&times; Remove</button>' +
                        '</div>' +
                        '</div>';
                });
                $('#drawerCartItems').html(html);
                $('.cart-total-amount').text(Number(res.subtotal).toLocaleString());
            } else {
                $('#drawerCartItems').html('<div style="text-align:center; padding: 40px 10px; color:#94a3b8;"><i class="fas fa-shopping-cart" style="font-size: 34px; margin-bottom:10px;"></i><p style="font-size:13.5px;">Your test cart is empty.</p></div>');
            }
        });
    }

    // Prescription Submit Handler
    $('#quickRxForm').on('submit', function(e) {
        e.preventDefault();
        var phone = $('#rxPhone').val();
        var file = $('#rxFile')[0].files[0];
        if (!file || !phone) return;

        var btn = $('#btnSubmitRx');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');

        var formData = new FormData(this);
        $.ajax({
            url: '<?=base_url("api/v1/prescriptions/upload");?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fas fa-cloud-upload-alt"></i> Submit Prescription');
                $('#rxMsgBox').css({'display': 'block', 'background': '#ecfdf5', 'color': '#065f46', 'border': '1px solid #a7f3d0'})
                              .html('<i class="fas fa-check-circle"></i> Prescription uploaded successfully! Our lab coordinator will call you shortly.');
                setTimeout(function() {
                    closePrescriptionModal();
                    $('#rxMsgBox').hide();
                    $('#quickRxForm')[0].reset();
                }, 3000);
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fas fa-cloud-upload-alt"></i> Submit Prescription');
                $('#rxMsgBox').css({'display': 'block', 'background': '#ecfdf5', 'color': '#065f46', 'border': '1px solid #a7f3d0'})
                              .html('<i class="fas fa-check-circle"></i> Prescription received! Our healthcare team will contact ' + phone + ' within 15 minutes.');
                setTimeout(function() {
                    closePrescriptionModal();
                    $('#rxMsgBox').hide();
                    $('#quickRxForm')[0].reset();
                }, 3000);
            }
        });
    });

});
</script>

<?php include ('includes/footer.php'); ?>