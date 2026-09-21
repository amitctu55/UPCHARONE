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
        <a href="<?=base_url('mytest/checkout');?>" style="background: var(--up-teal); color: #ffffff; text-decoration: none !important; width: 100%; justify-content: space-between; display: flex; align-items: center; padding: 12px 18px; font-weight: 800; font-size: 14px; border-radius: 8px; box-shadow: 0 4px 14px rgba(0,168,150,0.3);">
            <span>Proceed to Checkout</span>
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

    // Quick Book Trigger Buttons
    $(document).on('click', '.btn-open-quick-book', function(e) {
        e.preventDefault();
        var testId = $(this).data('test-id');
        var testName = $(this).data('test-name');
        var labId = $(this).data('lab-id');
        var labName = $(this).data('lab-name');
        var amount = $(this).data('amount');
        openQuickBookModal(testId, testName, labId, labName, amount);
    });

    // Quick Book Submission
    $('#instantQuickBookForm').on('submit', function(e) {
        e.preventDefault();
        var btn = $('#btnSubmitQuickBook');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.post('<?=base_url("mytest/quick_book");?>', $(this).serialize(), function(res) {
            btn.prop('disabled', false).html('<i class="fas fa-check"></i> Confirm Booking');
            if (res.status === 'success') {
                $('#qbMsgBox').css({'display': 'block', 'background': '#ecfdf5', 'color': '#065f46', 'border': '1px solid #a7f3d0'})
                              .html('<i class="fas fa-check-circle"></i> ' + res.message);
                setTimeout(function() {
                    if (res.redirect_url) {
                        window.location.href = res.redirect_url;
                    } else {
                        closeQuickBookModal();
                    }
                }, 1000);
            } else {
                $('#qbMsgBox').css({'display': 'block', 'background': '#fef2f2', 'color': '#991b1b', 'border': '1px solid #fecaca'})
                              .html('<i class="fas fa-exclamation-triangle"></i> ' + (res.message || 'Error processing booking.'));
            }
        }, 'json').fail(function() {
            btn.prop('disabled', false).html('<i class="fas fa-check"></i> Confirm Booking');
            $('#qbMsgBox').css({'display': 'block', 'background': '#fef2f2', 'color': '#991b1b', 'border': '1px solid #fecaca'})
                          .html('<i class="fas fa-exclamation-triangle"></i> Network connection error. Please retry.');
        });
    });

    // Floating Cart Toggle
    $('#floatingCartBtn').on('click', function() {
        refreshCartDrawer();
        $('#cartOverlay').fadeIn(200);
        $('#cartDrawer').css('right', '0');
    });

    $('#btnCloseDrawer, #cartOverlay').on('click', function() {
        $('#cartDrawer').css('right', '-420px');
        $('#cartOverlay').fadeOut(200);
    });

    // Cart Toggle (Add / Remove)
    $(document).on('click', '.btn-cart-toggle', function(e) {
        e.preventDefault();
        var btn = $(this);
        var testId = btn.data('test-id');

        if (btn.hasClass('in-cart')) {
            $.post('<?=base_url("mytest/remove_from_cart");?>', { test_id: testId }, function(res) {
                btn.removeClass('in-cart').html('<i class="fas fa-shopping-cart"></i> Add to Cart');
                updateCartUI(res);
            }, 'json');
        } else {
            btn.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
            $.post('<?=base_url("mytest/add_to_cart");?>', { test_id: testId }, function(res) {
                if (res.status === 'success') {
                    btn.addClass('in-cart').html('<i class="fas fa-check"></i> Added in Cart');
                    updateCartUI(res);
                    refreshCartDrawer();
                    $('#cartOverlay').fadeIn(200);
                    $('#cartDrawer').css('right', '0');
                }
            }, 'json');
        }
    });

    // Remove from Drawer
    $(document).on('click', '.btn-drawer-remove', function() {
        var testId = $(this).data('test-id');
        $.post('<?=base_url("mytest/remove_from_cart");?>', { test_id: testId }, function(res) {
            $('.btn-cart-toggle[data-test-id="' + testId + '"]').removeClass('in-cart').html('<i class="fas fa-shopping-cart"></i> Add to Cart');
            updateCartUI(res);
            refreshCartDrawer();
        }, 'json');
    });

    function updateCartUI(res) {
        if (res.cart_count > 0) {
            $('.cart-total-items').text(res.cart_count);
            $('.cart-total-amount').text(Number(res.subtotal).toLocaleString());
            $('#floatingCartBtn').fadeIn(200);
        } else {
            $('#floatingCartBtn').fadeOut(200);
            $('#cartDrawer').css('right', '-420px');
            $('#cartOverlay').fadeOut(200);
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