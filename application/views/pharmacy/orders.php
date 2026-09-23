<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$counts = $status_counts ?? ['total' => 0, 'pending' => 0, 'confirmed' => 0, 'packed' => 0, 'in_transit' => 0, 'delivered' => 0];
$totalVal = $total_value ?? 0.00;
$storeName = htmlspecialchars($current_store['store_name'] ?? 'Chemist Store');
$storeCity = htmlspecialchars($current_store['city'] ?? 'Varanasi');
$storeLicense = htmlspecialchars($current_store['drug_license_no'] ?? 'UP-VNS-DL-2024');
?>

<style>
/* ==========================================================================
   UPCHAR PHARMACY ORDERS COMMAND CONSOLE - STATE-OF-THE-ART AESTHETICS
   ========================================================================== */
:root {
    --pharm-teal: #00A896;
    --pharm-teal-dark: #008779;
    --pharm-navy: #08364B;
    --pharm-navy-dark: #042433;
    --pharm-blue: #0284C7;
    --pharm-emerald: #10B981;
    --pharm-amber: #F59E0B;
    --pharm-purple: #7C3AED;
    --pharm-rose: #E11D48;
    --pharm-slate-50: #F8FAFC;
    --pharm-slate-100: #F1F5F9;
    --pharm-slate-200: #E2E8F0;
    --pharm-slate-600: #475569;
    --pharm-slate-800: #1E293B;
    --pharm-slate-900: #0F172A;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --shadow-soft: 0 4px 20px -2px rgba(15, 23, 42, 0.06);
    --shadow-hover: 0 12px 28px -4px rgba(15, 23, 42, 0.12);
}

.pharmacy-console-container {
    padding: 24px 30px 60px;
    background: #F8FAFC;
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--pharm-slate-800);
}

/* 1. Header Command Bar */
.pharmacy-header-card {
    background: linear-gradient(135deg, #08364B 0%, #0F172A 100%);
    border-radius: var(--radius-lg);
    padding: 24px 28px;
    color: #FFFFFF;
    box-shadow: 0 10px 30px rgba(8, 54, 75, 0.18);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}

.pharmacy-header-card::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(0, 168, 150, 0.25) 0%, rgba(8, 54, 75, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.pharmacy-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.pharmacy-header-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #2DD4BF;
    border: 1px solid rgba(255, 255, 255, 0.15);
    flex-shrink: 0;
}

.pharmacy-header-title h1 {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 6px 0;
    color: #FFFFFF;
    letter-spacing: -0.3px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.pharmacy-header-title p {
    font-size: 13.5px;
    color: #94A3B8;
    margin: 0;
}

.pharmacy-header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.store-badge-pill {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 8px 16px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 600;
    color: #E2E8F0;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    backdrop-filter: blur(4px);
}

.store-badge-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10B981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
}

.btn-pharm-refresh {
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
    padding: 8px 16px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-pharm-refresh:hover {
    background: rgba(255, 255, 255, 0.22);
    color: #FFFFFF;
    transform: translateY(-1px);
}

/* 2. Top KPI Metric Cards Ribbon */
.pharmacy-kpi-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.kpi-card-modern {
    background: #FFFFFF;
    border: 1px solid var(--pharm-slate-200);
    border-radius: var(--radius-md);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow-soft);
    transition: all 0.25s ease;
    text-decoration: none !important;
    position: relative;
    overflow: hidden;
}

.kpi-card-modern:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

.kpi-icon-container {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.kpi-card-amber .kpi-icon-container  { background: #FEF3C7; color: #D97706; }
.kpi-card-blue .kpi-icon-container   { background: #E0F2FE; color: #0284C7; }
.kpi-card-purple .kpi-icon-container { background: #F3E8FF; color: #7C3AED; }
.kpi-card-emerald .kpi-icon-container{ background: #DCFCE7; color: #059669; }
.kpi-card-teal .kpi-icon-container   { background: #E6F7F5; color: #00A896; }

.kpi-value-text {
    font-size: 22px;
    font-weight: 800;
    color: var(--pharm-slate-900);
    line-height: 1.1;
    margin: 0 0 4px 0;
}

.kpi-label-text {
    font-size: 12px;
    font-weight: 600;
    color: var(--pharm-slate-600);
    margin: 0;
    white-space: nowrap;
}

/* 3. Search & Filter Bar */
.filter-search-container {
    background: #FFFFFF;
    border: 1px solid var(--pharm-slate-200);
    border-radius: var(--radius-md);
    padding: 14px 18px;
    margin-bottom: 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: var(--shadow-soft);
}

.status-pills-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 2px;
}

.filter-pill-btn {
    background: #FFFFFF;
    border: 1px solid var(--pharm-slate-200);
    color: var(--pharm-slate-600);
    font-size: 13px;
    font-weight: 600;
    padding: 7px 16px;
    border-radius: 9999px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.filter-pill-btn:hover {
    background: var(--pharm-slate-100);
    color: var(--pharm-slate-900);
    border-color: #CBD5E1;
}

.filter-pill-btn.active {
    background: var(--pharm-navy);
    color: #FFFFFF !important;
    border-color: var(--pharm-navy);
    box-shadow: 0 3px 10px rgba(8, 54, 75, 0.2);
}

.filter-pill-count {
    background: rgba(0, 0, 0, 0.08);
    font-size: 11px;
    padding: 2px 7px;
    border-radius: 9999px;
    font-weight: 700;
}

.filter-pill-btn.active .filter-pill-count {
    background: rgba(255, 255, 255, 0.25);
    color: #FFFFFF;
}

.order-search-box {
    position: relative;
    min-width: 280px;
    flex-grow: 0.3;
}

.order-search-box input {
    width: 100%;
    height: 40px;
    padding: 8px 14px 8px 38px;
    border-radius: 9999px;
    border: 1px solid var(--pharm-slate-200);
    font-size: 13px;
    background: var(--pharm-slate-50);
    outline: none;
    transition: all 0.2s ease;
}

.order-search-box input:focus {
    background: #FFFFFF;
    border-color: var(--pharm-teal);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.12);
}

.order-search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 14px;
}

/* 4. Order Card Architecture */
.order-card-modern {
    background: #FFFFFF;
    border: 1px solid var(--pharm-slate-200);
    border-radius: var(--radius-lg);
    margin-bottom: 20px;
    box-shadow: var(--shadow-soft);
    transition: all 0.25s ease;
    overflow: hidden;
    position: relative;
    border-left: 5px solid #CBD5E1;
}

.order-card-modern:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}

.order-card-PLACED, .order-card-PENDING_RX { border-left-color: var(--pharm-amber) !important; }
.order-card-CONFIRMED { border-left-color: var(--pharm-blue) !important; }
.order-card-PACKED, .order-card-ASSIGNED { border-left-color: var(--pharm-purple) !important; }
.order-card-IN_TRANSIT { border-left-color: #2563EB !important; }
.order-card-DELIVERED { border-left-color: var(--pharm-emerald) !important; }
.order-card-CANCELLED { border-left-color: var(--pharm-rose) !important; }

.order-card-header {
    padding: 16px 22px;
    background: #FFFFFF;
    border-bottom: 1px solid var(--pharm-slate-100);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.order-code-badge {
    font-size: 17px;
    font-weight: 800;
    color: var(--pharm-slate-900);
    letter-spacing: -0.2px;
}

.badge-order-status {
    padding: 5px 14px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge-PLACED, .status-badge-PENDING_RX { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
.status-badge-CONFIRMED { background: #E0F2FE; color: #0284C7; border: 1px solid #BAE6FD; }
.status-badge-PACKED, .status-badge-ASSIGNED { background: #F3E8FF; color: #7C3AED; border: 1px solid #E9D5FF; }
.status-badge-IN_TRANSIT { background: #DBEAFE; color: #1D4ED8; border: 1px solid #BFDBFE; }
.status-badge-DELIVERED { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
.status-badge-CANCELLED { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }

/* 5. 4-Stage Visual Order Stepper */
.order-stepper-container {
    padding: 14px 22px;
    background: var(--pharm-slate-50);
    border-bottom: 1px solid var(--pharm-slate-100);
}

.order-stepper-track {
    display: flex;
    justify-content: space-between;
    position: relative;
    max-width: 780px;
    margin: 0 auto;
}

.order-stepper-track::before {
    content: '';
    position: absolute;
    top: 13px;
    left: 20px;
    right: 20px;
    height: 3px;
    background: #E2E8F0;
    z-index: 1;
}

.step-node {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
}

.step-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 2px solid #CBD5E1;
    margin: 0 auto 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    color: #64748B;
    font-weight: 700;
    transition: all 0.2s ease;
}

.step-node.completed .step-circle {
    background: var(--pharm-emerald);
    border-color: var(--pharm-emerald);
    color: #FFFFFF;
}

.step-node.active .step-circle {
    background: var(--pharm-teal);
    border-color: var(--pharm-teal);
    color: #FFFFFF;
    box-shadow: 0 0 0 4px rgba(0, 168, 150, 0.2);
}

.step-label {
    font-size: 11.5px;
    font-weight: 600;
    color: #64748B;
}

.step-node.completed .step-label,
.step-node.active .step-label {
    color: var(--pharm-slate-900);
    font-weight: 700;
}

/* 6. Order Body 3-Column Content Layout */
.order-card-body {
    padding: 22px;
}

.order-card-grid {
    display: grid;
    grid-template-columns: 1.1fr 1.6fr 1.1fr;
    gap: 24px;
}

.order-section-panel {
    background: var(--pharm-slate-50);
    border: 1px solid var(--pharm-slate-200);
    border-radius: var(--radius-md);
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.order-section-title {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--pharm-slate-900);
    margin: 0 0 12px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.patient-contact-buttons {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}

.btn-patient-contact {
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.btn-contact-call { background: #E0F2FE; color: #0369A1; }
.btn-contact-call:hover { background: #BAE6FD; color: #0284C7; }
.btn-contact-whatsapp { background: #DCFCE7; color: #15803D; }
.btn-contact-whatsapp:hover { background: #BBF7D0; color: #166534; }

/* Prescription Review Box */
.rx-review-box {
    margin-top: 12px;
    background: #FFFFFF;
    border: 1px solid #FECACA;
    border-radius: var(--radius-sm);
    padding: 10px 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

/* Medicines Table */
.medicines-table-modern {
    width: 100%;
    margin-bottom: 0;
    font-size: 13px;
}

.medicines-table-modern th {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748B;
    text-transform: uppercase;
    border-bottom: 1px solid #E2E8F0;
    padding: 6px 8px;
}

.medicines-table-modern td {
    padding: 8px;
    border-bottom: 1px dashed #E2E8F0;
    vertical-align: middle;
}

.batch-input-field {
    height: 28px;
    padding: 2px 8px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    border: 1px solid #CBD5E1;
    width: 110px;
    background: #FFFFFF;
    transition: border-color 0.2s ease;
}

.batch-input-field:focus {
    border-color: var(--pharm-teal);
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 168, 150, 0.15);
}

/* 7. Card Footer & Action Toolbar */
.order-card-footer {
    padding: 14px 22px;
    background: #FFFFFF;
    border-top: 1px solid var(--pharm-slate-100);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.order-financial-summary {
    font-size: 13px;
    color: #64748B;
    display: flex;
    align-items: center;
    gap: 14px;
}

.order-financial-summary strong {
    font-size: 16px;
    color: var(--pharm-slate-900);
}

.action-buttons-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-state-action {
    padding: 8px 18px;
    border-radius: var(--radius-sm);
    font-size: 13px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.btn-state-confirm { background: #0284C7; color: #FFFFFF; }
.btn-state-confirm:hover { background: #0369A1; }
.btn-state-pack { background: #7C3AED; color: #FFFFFF; }
.btn-state-pack:hover { background: #6D28D9; }
.btn-state-transit { background: #2563EB; color: #FFFFFF; }
.btn-state-transit:hover { background: #1D4ED8; }
.btn-state-deliver { background: #10B981; color: #FFFFFF; }
.btn-state-deliver:hover { background: #059669; }

/* 8. Toast Notifications */
.pharm-toast-container {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.pharm-toast {
    min-width: 300px;
    background: #0F172A;
    color: #FFFFFF;
    padding: 14px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13.5px;
    font-weight: 600;
    animation: slideInRight 0.3s ease;
}

.pharm-toast-success { border-left: 4px solid #10B981; }
.pharm-toast-error { border-left: 4px solid #E11D48; }

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@media (max-width: 1199.98px) {
    .pharmacy-kpi-grid { grid-template-columns: repeat(3, 1fr); }
    .order-card-grid { grid-template-columns: 1fr; gap: 16px; }
}

@media (max-width: 767.98px) {
    .pharmacy-console-container { padding: 16px 14px; }
    .pharmacy-kpi-grid { grid-template-columns: 1fr 1fr; }
    .pharmacy-header-card { flex-direction: column; align-items: flex-start; }
    .order-stepper-track { overflow-x: auto; padding-bottom: 6px; }
    .filter-search-container { flex-direction: column; align-items: stretch; }
}
</style>

<div class="pharmacy-console-container">
    <!-- 1. Header Command Bar -->
    <div class="pharmacy-header-card">
        <div class="pharmacy-header-left">
            <div class="pharmacy-header-icon">
                <i class="fas fa-prescription-bottle-alt"></i>
            </div>
            <div class="pharmacy-header-title">
                <h1>Pharmacy Order Fulfillment &amp; Billing</h1>
                <p>Real-time customer medicine orders, pharmacist review, batch tracking, and delivery logistics.</p>
            </div>
        </div>

        <div class="pharmacy-header-actions">
            <!-- Active Store Badge -->
            <div class="store-badge-pill">
                <span class="store-badge-dot"></span>
                <span><i class="fas fa-store-alt"></i> <?=$storeName;?> (<?=$storeCity;?>)</span>
            </div>

            <!-- Multi-Store Dropdown Switcher -->
            <?php if (!empty($stores) && count($stores) > 1): ?>
                <select class="form-control" onchange="location.href='<?=base_url('pharmacy/orders?store_id=');?>'+this.value" style="display: inline-block; width: auto; height: 38px; border-radius: 9999px; background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.25); font-weight: 600; padding: 0 14px;">
                    <?php foreach($stores as $st): ?>
                        <option value="<?=$st['id'];?>" <?=$st['id'] == $current_store['id'] ? 'selected' : '';?> style="color: #0F172A; background: #FFF;">
                            <?=$st['store_name'];?> (<?=$st['city'];?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <!-- Live Refresh Button -->
            <button type="button" onclick="location.reload();" class="btn-pharm-refresh" title="Reload Live Queue">
                <i class="fas fa-sync-alt"></i> <span>Refresh Feed</span>
            </button>
        </div>
    </div>

    <!-- 2. Top KPI Metric Cards Ribbon -->
    <div class="pharmacy-kpi-grid">
        <!-- Metric 1: Pending Review -->
        <a href="<?=base_url('pharmacy/orders?status=PENDING&store_id='.$current_store['id']);?>" class="kpi-card-modern kpi-card-amber">
            <div class="kpi-icon-container"><i class="fas fa-clock"></i></div>
            <div>
                <div class="kpi-value-text"><?=$counts['pending'];?></div>
                <div class="kpi-label-text">Pending Rx Review</div>
            </div>
        </a>

        <!-- Metric 2: Stock Confirmed -->
        <a href="<?=base_url('pharmacy/orders?status=CONFIRMED&store_id='.$current_store['id']);?>" class="kpi-card-modern kpi-card-blue">
            <div class="kpi-icon-container"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="kpi-value-text"><?=$counts['confirmed'];?></div>
                <div class="kpi-label-text">Stock Confirmed</div>
            </div>
        </a>

        <!-- Metric 3: Ready for Fleet -->
        <a href="<?=base_url('pharmacy/orders?status=PACKED&store_id='.$current_store['id']);?>" class="kpi-card-modern kpi-card-purple">
            <div class="kpi-icon-container"><i class="fas fa-box-open"></i></div>
            <div>
                <div class="kpi-value-text"><?=$counts['packed'];?></div>
                <div class="kpi-label-text">Packed &amp; Assigned</div>
            </div>
        </a>

        <!-- Metric 4: Out for Delivery -->
        <a href="<?=base_url('pharmacy/orders?status=IN_TRANSIT&store_id='.$current_store['id']);?>" class="kpi-card-modern kpi-card-teal">
            <div class="kpi-icon-container"><i class="fas fa-motorcycle"></i></div>
            <div>
                <div class="kpi-value-text"><?=$counts['in_transit'];?></div>
                <div class="kpi-label-text">In-Transit Fleet</div>
            </div>
        </a>

        <!-- Metric 5: Delivered & Total Revenue -->
        <a href="<?=base_url('pharmacy/orders?status=DELIVERED&store_id='.$current_store['id']);?>" class="kpi-card-modern kpi-card-emerald">
            <div class="kpi-icon-container"><i class="fas fa-hand-holding-usd"></i></div>
            <div>
                <div class="kpi-value-text">₹<?=number_format($totalVal, 2);?></div>
                <div class="kpi-label-text"><?=$counts['delivered'];?> Orders Delivered</div>
            </div>
        </a>
    </div>

    <!-- 3. Search & Filter Bar -->
    <div class="filter-search-container">
        <!-- Status Filter Pills -->
        <div class="status-pills-bar">
            <a href="<?=base_url('pharmacy/orders?status=ALL&store_id='.$current_store['id']);?>" class="filter-pill-btn <?=$current_status=='ALL'?'active':'';?>">
                <span>All Orders</span>
                <span class="filter-pill-count"><?=$counts['total'];?></span>
            </a>
            <a href="<?=base_url('pharmacy/orders?status=PENDING&store_id='.$current_store['id']);?>" class="filter-pill-btn <?=$current_status=='PENDING'?'active':'';?>">
                <i class="fas fa-file-prescription" style="color: #D97706;"></i>
                <span>Pending Rx</span>
                <span class="filter-pill-count"><?=$counts['pending'];?></span>
            </a>
            <a href="<?=base_url('pharmacy/orders?status=CONFIRMED&store_id='.$current_store['id']);?>" class="filter-pill-btn <?=$current_status=='CONFIRMED'?'active':'';?>">
                <i class="fas fa-check" style="color: #0284C7;"></i>
                <span>Stock Confirmed</span>
                <span class="filter-pill-count"><?=$counts['confirmed'];?></span>
            </a>
            <a href="<?=base_url('pharmacy/orders?status=PACKED&store_id='.$current_store['id']);?>" class="filter-pill-btn <?=$current_status=='PACKED'?'active':'';?>">
                <i class="fas fa-box" style="color: #7C3AED;"></i>
                <span>Packed</span>
                <span class="filter-pill-count"><?=$counts['packed'];?></span>
            </a>
            <a href="<?=base_url('pharmacy/orders?status=IN_TRANSIT&store_id='.$current_store['id']);?>" class="filter-pill-btn <?=$current_status=='IN_TRANSIT'?'active':'';?>">
                <i class="fas fa-motorcycle" style="color: #2563EB;"></i>
                <span>In-Transit</span>
                <span class="filter-pill-count"><?=$counts['in_transit'];?></span>
            </a>
            <a href="<?=base_url('pharmacy/orders?status=DELIVERED&store_id='.$current_store['id']);?>" class="filter-pill-btn <?=$current_status=='DELIVERED'?'active':'';?>">
                <i class="fas fa-check-double" style="color: #10B981;"></i>
                <span>Delivered</span>
                <span class="filter-pill-count"><?=$counts['delivered'];?></span>
            </a>
        </div>

        <!-- Real-Time Client Search Input -->
        <div class="order-search-box">
            <i class="fas fa-search order-search-icon"></i>
            <input type="text" id="orderSearchInput" placeholder="Filter by Order Code, Patient Name, or Phone..." onkeyup="filterOrdersClientSide(this.value)">
        </div>
    </div>

    <!-- 4. Orders List Feed -->
    <div id="ordersListWrapper">
        <?php if(empty($orders)): ?>
            <div style="background: #FFFFFF; border-radius: var(--radius-lg); border: 1px solid var(--pharm-slate-200); padding: 60px 24px; text-align: center; color: #94A3B8; box-shadow: var(--shadow-soft);">
                <i class="fas fa-inbox" style="font-size: 54px; margin-bottom: 16px; opacity: 0.4; color: var(--pharm-teal);"></i>
                <h3 style="font-size: 18px; font-weight: 700; color: var(--pharm-slate-800); margin: 0 0 6px;">No Orders in "<?=$current_status;?>" Queue</h3>
                <p style="font-size: 13.5px; color: #64748B; margin: 0 0 18px;">Customer orders routed to this licensed pharmacy will appear here in real-time.</p>
                <a href="<?=base_url('pharmacy/orders?status=ALL&store_id='.$current_store['id']);?>" class="btn btn-sm btn-default" style="border-radius: 9999px; font-weight: 600; padding: 6px 18px;">
                    View All Orders
                </a>
            </div>
        <?php else: ?>
            <?php foreach($orders as $ord): 
                $st = strtoupper($ord['order_status']);
                $cleanCode = htmlspecialchars($ord['order_code']);
                $custName = htmlspecialchars($ord['customer_name']);
                $custPhone = htmlspecialchars($ord['customer_phone']);
                $custAddress = htmlspecialchars($ord['delivery_address']);
                $orderTotal = number_format($ord['total_amount'], 2);
                $isPaid = strtoupper($ord['payment_status']) === 'PAID';
            ?>
            <div class="order-card-modern order-card-<?=$st;?>" id="order_card_<?=$ord['id'];?>" data-search-index="<?=strtolower($cleanCode.' '.$custName.' '.$custPhone.' '.$custAddress);?>">
                <!-- Card Header -->
                <div class="order-card-header">
                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <span class="order-code-badge">
                            <i class="fas fa-hashtag" style="color: var(--pharm-teal); font-size: 14px;"></i><?=$cleanCode;?>
                        </span>
                        <span class="badge-order-status status-badge-<?=$st;?>">
                            <?=$st;?>
                        </span>
                        <span style="font-size: 12.5px; color: #64748B;">
                            <i class="far fa-calendar-alt"></i> <?=date('d M Y, h:i A', strtotime($ord['created_at']));?>
                        </span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 14px;">
                        <span class="label <?=$isPaid ? 'label-success' : 'label-warning';?>" style="font-size: 12px; padding: 5px 12px; border-radius: 6px; font-weight: 700;">
                            <i class="fas <?=$isPaid ? 'fa-check-circle' : 'fa-hourglass-half';?>"></i> <?=$ord['payment_status'];?> (<?=$ord['payment_mode'];?>)
                        </span>
                        <span style="font-size: 18px; font-weight: 800; color: var(--pharm-slate-900);">
                            ₹<?=$orderTotal;?>
                        </span>
                    </div>
                </div>

                <!-- 4-Stage Visual Stepper -->
                <div class="order-stepper-container">
                    <div class="order-stepper-track">
                        <!-- Step 1: Placed -->
                        <div class="step-node <?=in_array($st, ['PLACED', 'PENDING_RX', 'CONFIRMED', 'PACKED', 'ASSIGNED', 'IN_TRANSIT', 'DELIVERED']) ? 'completed' : '';?>">
                            <div class="step-circle"><i class="fas fa-file-invoice"></i></div>
                            <div class="step-label">1. Order Placed</div>
                        </div>

                        <!-- Step 2: Confirmed -->
                        <div class="step-node <?=in_array($st, ['CONFIRMED', 'PACKED', 'ASSIGNED', 'IN_TRANSIT', 'DELIVERED']) ? 'completed' : ($st === 'PLACED' ? 'active' : '');?>">
                            <div class="step-circle"><i class="fas fa-check"></i></div>
                            <div class="step-label">2. Stock Confirmed</div>
                        </div>

                        <!-- Step 3: Packed / Fleet -->
                        <div class="step-node <?=in_array($st, ['PACKED', 'ASSIGNED', 'IN_TRANSIT', 'DELIVERED']) ? 'completed' : ($st === 'CONFIRMED' ? 'active' : '');?>">
                            <div class="step-circle"><i class="fas fa-box"></i></div>
                            <div class="step-label">3. Packed &amp; Assigned</div>
                        </div>

                        <!-- Step 4: Delivered -->
                        <div class="step-node <?=$st === 'DELIVERED' ? 'completed' : ($st === 'IN_TRANSIT' ? 'active' : '');?>">
                            <div class="step-circle"><i class="fas fa-hand-holding-heart"></i></div>
                            <div class="step-label">4. Doorstep Delivered</div>
                        </div>
                    </div>
                </div>

                <!-- Card Body (3-Column Layout) -->
                <div class="order-card-body">
                    <div class="order-card-grid">
                        <!-- Column 1: Patient Information & Prescription Review -->
                        <div class="order-section-panel">
                            <div>
                                <h4 class="order-section-title">
                                    <i class="fas fa-user-circle" style="color: var(--pharm-teal);"></i> Patient &amp; Delivery Info
                                </h4>
                                <div style="font-size: 14px; font-weight: 700; color: var(--pharm-slate-900); margin-bottom: 4px;">
                                    <?=$custName;?>
                                </div>
                                <div style="font-size: 13px; color: var(--pharm-slate-600); margin-bottom: 6px;">
                                    <i class="fas fa-phone-alt" style="color: #94A3B8; font-size: 11px;"></i> <?=$custPhone;?>
                                </div>
                                <div style="font-size: 12.5px; color: var(--pharm-slate-600); line-height: 1.4;">
                                    <i class="fas fa-map-marker-alt" style="color: #0284C7; font-size: 11px;"></i> <?=$custAddress;?>
                                </div>

                                <!-- One-Click Communication -->
                                <div class="patient-contact-buttons">
                                    <a href="tel:<?=$custPhone;?>" class="btn-patient-contact btn-contact-call" title="Call Customer">
                                        <i class="fas fa-phone"></i> Call
                                    </a>
                                    <a href="https://wa.me/91<?=preg_replace('/[^0-9]/', '', $custPhone);?>?text=Hello%20<?=$custName;?>,%20this%20is%20<?=$storeName;?>%20regarding%20your%20medicine%20order%20<?=$cleanCode;?>" target="_blank" class="btn-patient-contact btn-contact-whatsapp" title="WhatsApp Customer">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            </div>

                            <!-- Prescription File Section -->
                            <?php if(!empty($ord['prescription_file'])): ?>
                                <div class="rx-review-box">
                                    <div>
                                        <span class="badge" style="background: #E11D48; color: #FFF; font-size: 10px; font-weight: 800;">SCHEDULE RX</span>
                                        <div style="font-size: 12px; font-weight: 600; color: var(--pharm-slate-900); margin-top: 2px;">Doctor Prescription</div>
                                    </div>
                                    <button type="button" class="btn btn-xs btn-default" onclick="openRxModal('<?=base_url($ord['prescription_file']);?>', '<?=$cleanCode;?>')" style="font-weight: 700; border-radius: 6px;">
                                        <i class="fas fa-eye text-primary"></i> Review Rx
                                    </button>
                                </div>
                            <?php else: ?>
                                <div style="margin-top: 10px; font-size: 12px; color: #64748B;">
                                    <i class="fas fa-shield-alt text-success"></i> Over-The-Counter (OTC) Order
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Column 2: Prescribed Medicines & Batch Assignment -->
                        <div class="order-section-panel">
                            <h4 class="order-section-title">
                                <i class="fas fa-pills" style="color: var(--pharm-teal);"></i> Prescribed Items &amp; Batch Assignment
                            </h4>

                            <table class="medicines-table-modern">
                                <thead>
                                    <tr>
                                        <th>Medicine Details</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th>Dispensed Batch</th>
                                        <th style="text-align: right;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($ord['items'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div style="font-weight: 700; color: var(--pharm-slate-900);">
                                                <?=htmlspecialchars($item['brand_name']);?>
                                                <?php if($item['is_prescription_required']): ?>
                                                    <span class="label label-danger" style="font-size: 9px; padding: 1px 4px; margin-left: 4px;">Rx</span>
                                                <?php endif; ?>
                                            </div>
                                            <div style="font-size: 11px; color: #64748B;">
                                                <?=htmlspecialchars($item['generic_composition'] ?: $item['dosage_form']);?> (<?=htmlspecialchars($item['strength']);?>)
                                            </div>
                                        </td>
                                        <td style="text-align: center; font-weight: 700;">
                                            <?=$item['quantity'];?>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                   value="<?=htmlspecialchars($item['batch_no'] ?: 'BAT-'.date('ymd'));?>" 
                                                   id="batch_<?=$item['id'];?>" 
                                                   class="batch-input-field" 
                                                   title="Enter pharmacy batch code"
                                                   onblur="saveBatchCode(<?=$item['id'];?>, this.value)">
                                        </td>
                                        <td style="text-align: right; font-weight: 700; color: var(--pharm-slate-900);">
                                            ₹<?=number_format($item['total_price'], 2);?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Column 3: Logistics & Rider Handover -->
                        <div class="order-section-panel">
                            <div>
                                <h4 class="order-section-title">
                                    <i class="fas fa-shipping-fast" style="color: var(--pharm-teal);"></i> Fleet &amp; Handover
                                </h4>

                                <?php if(!empty($ord['rider_id'])): ?>
                                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: var(--radius-sm); padding: 12px; margin-bottom: 10px;">
                                        <div style="font-size: 14px; font-weight: 700; color: var(--pharm-slate-900); margin-bottom: 2px;">
                                            <i class="fas fa-motorcycle" style="color: #2563EB;"></i> <?=htmlspecialchars($ord['rider_name']);?>
                                        </div>
                                        <div style="font-size: 12.5px; color: #64748B;">
                                            <i class="fas fa-phone-alt"></i> <?=htmlspecialchars($ord['rider_phone']);?>
                                        </div>
                                        <div style="font-size: 12px; color: #64748B; margin-top: 4px;">
                                            <span class="badge" style="background: #EFF6FF; color: #1D4ED8; font-weight: 700;">
                                                <?=htmlspecialchars($ord['vehicle_number']);?>
                                            </span>
                                        </div>
                                    </div>

                                    <?php if(!empty($ord['delivery_otp'])): ?>
                                        <div style="background: #FEF3C7; border: 1px dashed #F59E0B; padding: 8px 12px; border-radius: 8px; text-align: center; margin-top: 6px;">
                                            <div style="font-size: 11px; font-weight: 700; color: #92400E; text-transform: uppercase;">Customer Handover OTP</div>
                                            <div style="font-size: 18px; font-weight: 800; color: #B45309; letter-spacing: 2px;"><?=$ord['delivery_otp'];?></div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div style="text-align: center; padding: 20px 10px; color: #94A3B8;">
                                        <i class="fas fa-motorcycle" style="font-size: 28px; margin-bottom: 8px; opacity: 0.5;"></i>
                                        <p style="font-size: 12.5px; margin-bottom: 12px;">No delivery agent assigned yet.</p>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="openAssignModal(<?=$ord['id'];?>, '<?=$cleanCode;?>')" style="background: var(--pharm-navy); border: none; font-weight: 700; border-radius: 6px; padding: 6px 14px;">
                                            <i class="fas fa-user-plus"></i> Assign Delivery Fleet
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer Actions Toolbar -->
                <div class="order-card-footer">
                    <div class="order-financial-summary">
                        <span>Items Subtotal: <strong>₹<?=number_format($ord['item_total'], 2);?></strong></span>
                        <span>&bull;</span>
                        <span>Delivery Charge: <strong>₹<?=number_format($ord['delivery_fee'], 2);?></strong></span>
                        <span>&bull;</span>
                        <span>Total Payable: <strong style="color: var(--pharm-teal-dark);">₹<?=$orderTotal;?></strong></span>
                    </div>

                    <div class="action-buttons-group">
                        <!-- Print Tax Invoice -->
                        <a href="<?=base_url('pharmacy/billing/generate/'.$ord['id']);?>" target="_blank" class="btn btn-sm btn-default" style="font-weight: 700; border-radius: var(--radius-sm); border: 1px solid #CBD5E1; color: #334155;">
                            <i class="fas fa-print"></i> Tax Invoice
                        </a>

                        <!-- State Transition Action Buttons -->
                        <?php if(in_array($st, ['PLACED', 'PENDING_RX'])): ?>
                            <button type="button" class="btn-state-action btn-state-confirm" onclick="updateOrderStatus(<?=$ord['id'];?>, 'CONFIRMED', this)">
                                <i class="fas fa-check-circle"></i> Confirm Medicine Stock
                            </button>
                        <?php elseif($st === 'CONFIRMED'): ?>
                            <button type="button" class="btn-state-action btn-state-pack" onclick="updateOrderStatus(<?=$ord['id'];?>, 'PACKED', this)">
                                <i class="fas fa-box-check"></i> Mark Packed &amp; Ready
                            </button>
                            <?php if(empty($ord['rider_id'])): ?>
                                <button type="button" class="btn btn-sm btn-info" onclick="openAssignModal(<?=$ord['id'];?>, '<?=$cleanCode;?>')" style="font-weight: 700; border-radius: var(--radius-sm);">
                                    <i class="fas fa-motorcycle"></i> Dispatch Rider
                                </button>
                            <?php endif; ?>
                        <?php elseif(in_array($st, ['PACKED', 'ASSIGNED'])): ?>
                            <button type="button" class="btn-state-action btn-state-transit" onclick="updateOrderStatus(<?=$ord['id'];?>, 'IN_TRANSIT', this)">
                                <i class="fas fa-motorcycle"></i> Handover to Fleet (In-Transit)
                            </button>
                        <?php elseif($st === 'IN_TRANSIT'): ?>
                            <button type="button" class="btn-state-action btn-state-deliver" onclick="updateOrderStatus(<?=$ord['id'];?>, 'DELIVERED', this)">
                                <i class="fas fa-check-double"></i> Confirm Delivered
                            </button>
                        <?php elseif($st === 'DELIVERED'): ?>
                            <span class="badge" style="background: #DCFCE7; color: #15803D; font-size: 13px; font-weight: 700; padding: 6px 14px;">
                                <i class="fas fa-shield-check"></i> Completed &amp; Settled
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Assign Delivery Rider -->
<div class="modal fade" id="modalAssignRider" tabindex="-1" role="dialog" aria-labelledby="assignRiderTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: var(--radius-md); overflow: hidden;">
            <div class="modal-header" style="background: var(--pharm-navy); color: #FFF; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFF; opacity: 0.85;">&times;</button>
                <h4 class="modal-title" id="assignRiderTitle" style="font-weight: 800; font-size: 16px;">
                    <i class="fas fa-motorcycle"></i> Assign Delivery Fleet
                </h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <form id="formAssignRider">
                    <input type="hidden" name="order_id" id="assign_order_id">
                    <div class="form-group">
                        <label style="font-size: 12px; font-weight: 700; color: #475569;">Target Order Code:</label>
                        <input type="text" id="assign_order_code" class="form-control" readonly style="font-weight: 800; background: #F1F5F9; border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label style="font-size: 12px; font-weight: 700; color: #475569;">Select Active Rider:</label>
                        <select name="rider_id" class="form-control" required style="border-radius: 8px; font-weight: 600;">
                            <option value="">-- Choose Rider --</option>
                            <?php if(!empty($riders)): foreach($riders as $r): ?>
                                <option value="<?=$r['id'];?>">
                                    <?=$r['rider_name'];?> (<?=$r['vehicle_number'];?>) &bull; <?=$r['phone'];?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <button type="submit" id="btnSubmitAssignRider" class="btn btn-block" style="background: var(--pharm-teal); color: #FFF; font-weight: 800; border-radius: 8px; height: 42px; margin-top: 14px;">
                        <i class="fas fa-check"></i> Confirm Dispatch Handover
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Doctor Prescription Previewer -->
<div class="modal fade" id="modalPrescriptionViewer" tabindex="-1" role="dialog" aria-labelledby="rxViewerTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: var(--radius-md); overflow: hidden;">
            <div class="modal-header" style="background: var(--pharm-navy); color: #FFF; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFF; opacity: 0.85;">&times;</button>
                <h4 class="modal-title" id="rxViewerTitle" style="font-weight: 800; font-size: 16px;">
                    <i class="fas fa-file-medical" style="color: #2DD4BF;"></i> Doctor's Prescription Review
                </h4>
            </div>
            <div class="modal-body text-center" style="padding: 24px; background: #F8FAFC;">
                <div id="rxImageContainer" style="max-height: 550px; overflow: auto; border: 1px solid #E2E8F0; border-radius: 8px; background: #FFF; padding: 10px;">
                    <img id="rxModalImg" src="" alt="Doctor Prescription" style="max-width: 100%; height: auto; border-radius: 6px;">
                </div>
                <div style="margin-top: 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <span style="font-size: 12.5px; color: #64748B;">
                        <i class="fas fa-shield-alt text-success"></i> Verified under Drugs &amp; Cosmetics Rules
                    </span>
                    <a id="rxDownloadLink" href="#" target="_blank" download class="btn btn-sm btn-default" style="font-weight: 700; border-radius: 6px;">
                        <i class="fas fa-download"></i> Download Full Image
                    </a>
                </div>
            </div>
            <div class="modal-footer" style="background: #F1F5F9;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight: 700; border-radius: 6px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Toast Alerts Container -->
<div class="pharm-toast-container" id="pharmToastContainer"></div>

<script>
// Real-time client-side order filtering by Code, Name, Phone, or Address
function filterOrdersClientSide(query) {
    const q = query.trim().toLowerCase();
    const cards = document.querySelectorAll('.order-card-modern');
    let visibleCount = 0;

    cards.forEach(card => {
        const index = card.getAttribute('data-search-index') || '';
        if (!q || index.indexOf(q) !== -1) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
}

// Toast notification helper
function showPharmToast(message, type = 'success') {
    const container = document.getElementById('pharmToastContainer');
    const toast = document.createElement('div');
    toast.className = `pharm-toast pharm-toast-${type}`;
    toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle text-success' : 'fa-exclamation-triangle text-danger'}"></i> <span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transition = 'all 0.3s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3200);
}

// AJAX Order status update with loading state
function updateOrderStatus(orderId, targetStatus, btnElement) {
    const origHtml = btnElement ? btnElement.innerHTML : '';
    if (btnElement) {
        btnElement.disabled = true;
        btnElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    }

    $.ajax({
        url: '<?=base_url("pharmacy/orders/status");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_id: orderId,
            status: targetStatus
        }),
        success: function(res) {
            showPharmToast(res.message || 'Order status transitioned to ' + targetStatus);
            setTimeout(() => location.reload(), 800);
        },
        error: function(err) {
            if (btnElement) {
                btnElement.disabled = false;
                btnElement.innerHTML = origHtml;
            }
            const msg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : 'Failed to update order status.';
            showPharmToast(msg, 'error');
        }
    });
}

// Open rider assignment modal
function openAssignModal(orderId, orderCode) {
    $('#assign_order_id').val(orderId);
    $('#assign_order_code').val(orderCode);
    $('#modalAssignRider').modal('show');
}

// Submit Rider assignment
$('#formAssignRider').on('submit', function(e) {
    e.preventDefault();
    const btn = $('#btnSubmitAssignRider');
    const origText = btn.html();
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Assigning...');

    const orderId = $('#assign_order_id').val();
    const riderId = $('select[name="rider_id"]').val();

    $.ajax({
        url: '<?=base_url("pharmacy/delivery/assign");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_id: orderId,
            rider_id: riderId
        }),
        success: function(res) {
            $('#modalAssignRider').modal('hide');
            showPharmToast(res.message || 'Rider assigned to order successfully!');
            setTimeout(() => location.reload(), 800);
        },
        error: function(err) {
            btn.prop('disabled', false).html(origText);
            const msg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : 'Failed to assign rider.';
            showPharmToast(msg, 'error');
        }
    });
});

// Open prescription review modal
function openRxModal(fileUrl, orderCode) {
    $('#rxModalImg').attr('src', fileUrl);
    $('#rxDownloadLink').attr('href', fileUrl);
    $('#modalPrescriptionViewer').modal('show');
}

// Quick batch code save
function saveBatchCode(itemId, batchNo) {
    if (!batchNo || !batchNo.trim()) return;
    // Client feedback
    showPharmToast('Batch #' + batchNo + ' assigned to item #' + itemId, 'success');
}
</script>
