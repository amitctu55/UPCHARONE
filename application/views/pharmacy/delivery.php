<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$kpi = $kpi ?? ['packed_count' => 0, 'assigned_count' => 0, 'in_transit_count' => 0, 'available_riders' => 0, 'total_riders' => 0];
$storeName = htmlspecialchars($current_store['store_name'] ?? 'Chemist Store');
$storeCity = htmlspecialchars($current_store['city'] ?? 'Varanasi');
$storeLicense = htmlspecialchars($current_store['drug_license_no'] ?? 'UP-VNS-DL-2024');
?>

<style>
/* ==========================================================================
   UPCHAR PHARMACY DELIVERY & FLEET COMMAND CENTER - FULL-STACK LOGISTICS UI
   ========================================================================== */
:root {
    --fleet-teal: #00A896;
    --fleet-teal-dark: #008779;
    --fleet-navy: #08364B;
    --fleet-navy-dark: #042433;
    --fleet-blue: #0284C7;
    --fleet-purple: #7C3AED;
    --fleet-emerald: #10B981;
    --fleet-amber: #F59E0B;
    --fleet-rose: #E11D48;
    --fleet-slate-50: #F8FAFC;
    --fleet-slate-100: #F1F5F9;
    --fleet-slate-200: #E2E8F0;
    --fleet-slate-600: #475569;
    --fleet-slate-800: #1E293B;
    --fleet-slate-900: #0F172A;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --shadow-soft: 0 4px 20px -2px rgba(15, 23, 42, 0.06);
    --shadow-hover: 0 12px 28px -4px rgba(15, 23, 42, 0.12);
}

.delivery-console-container {
    padding: 24px 30px 60px;
    background: #F8FAFC;
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--fleet-slate-800);
}

/* 1. Header Command Bar */
.delivery-header-card {
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

.delivery-header-card::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(2, 132, 199, 0.25) 0%, rgba(8, 54, 75, 0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.delivery-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.delivery-header-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #38BDF8;
    border: 1px solid rgba(255, 255, 255, 0.15);
    flex-shrink: 0;
}

.delivery-header-title h1 {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 6px 0;
    color: #FFFFFF;
    letter-spacing: -0.3px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.delivery-header-title p {
    font-size: 13.5px;
    color: #94A3B8;
    margin: 0;
}

.delivery-header-actions {
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

.btn-delivery-refresh {
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

.btn-delivery-refresh:hover {
    background: rgba(255, 255, 255, 0.22);
    color: #FFFFFF;
    transform: translateY(-1px);
}

/* 2. Fleet & Dispatch KPI Ribbon */
.fleet-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.fleet-kpi-card {
    background: #FFFFFF;
    border: 1px solid var(--fleet-slate-200);
    border-radius: var(--radius-md);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow-soft);
    transition: all 0.25s ease;
    text-decoration: none !important;
}

.fleet-kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

.kpi-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.kpi-card-amber .kpi-icon-box  { background: #FEF3C7; color: #D97706; }
.kpi-card-purple .kpi-icon-box { background: #F3E8FF; color: #7C3AED; }
.kpi-card-blue .kpi-icon-box   { background: #DBEAFE; color: #1D4ED8; }
.kpi-card-emerald .kpi-icon-box{ background: #DCFCE7; color: #059669; }

.kpi-val-text {
    font-size: 24px;
    font-weight: 800;
    color: var(--fleet-slate-900);
    line-height: 1.1;
    margin: 0 0 4px 0;
}

.kpi-lbl-text {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--fleet-slate-600);
    margin: 0;
    white-space: nowrap;
}

/* 3. Filter & Instant Search Toolbar */
.delivery-filter-bar {
    background: #FFFFFF;
    border: 1px solid var(--fleet-slate-200);
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

.delivery-pills-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
}

.delivery-pill-btn {
    background: #FFFFFF;
    border: 1px solid var(--fleet-slate-200);
    color: var(--fleet-slate-600);
    font-size: 13px;
    font-weight: 600;
    padding: 7px 16px;
    border-radius: 9999px;
    cursor: pointer;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.delivery-pill-btn:hover {
    background: var(--fleet-slate-100);
    color: var(--fleet-slate-900);
}

.delivery-pill-btn.active {
    background: var(--fleet-navy);
    color: #FFFFFF !important;
    border-color: var(--fleet-navy);
    box-shadow: 0 3px 10px rgba(8, 54, 75, 0.2);
}

.pill-count-bubble {
    background: rgba(0, 0, 0, 0.08);
    font-size: 11px;
    padding: 2px 7px;
    border-radius: 9999px;
    font-weight: 700;
}

.delivery-pill-btn.active .pill-count-bubble {
    background: rgba(255, 255, 255, 0.25);
    color: #FFFFFF;
}

.delivery-search-box {
    position: relative;
    min-width: 290px;
    flex-grow: 0.3;
}

.delivery-search-box input {
    width: 100%;
    height: 40px;
    padding: 8px 14px 8px 38px;
    border-radius: 9999px;
    border: 1px solid var(--fleet-slate-200);
    font-size: 13px;
    background: var(--fleet-slate-50);
    outline: none;
    transition: all 0.2s ease;
}

.delivery-search-box input:focus {
    background: #FFFFFF;
    border-color: var(--fleet-teal);
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.12);
}

.delivery-search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 14px;
}

/* 4. Split-Screen Layout (8 Cols Main, 4 Cols Sidebar) */
.delivery-layout-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    align-items: flex-start;
}

/* 5. Dispatch Cards */
.dispatch-card-modern {
    background: #FFFFFF;
    border: 1px solid var(--fleet-slate-200);
    border-radius: var(--radius-lg);
    margin-bottom: 20px;
    box-shadow: var(--shadow-soft);
    transition: all 0.25s ease;
    overflow: hidden;
    position: relative;
    border-left: 5px solid #CBD5E1;
}

.dispatch-card-modern:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}

.dispatch-card-PACKED { border-left-color: var(--fleet-amber) !important; }
.dispatch-card-ASSIGNED { border-left-color: var(--fleet-purple) !important; }
.dispatch-card-IN_TRANSIT { border-left-color: #2563EB !important; }

.dispatch-card-header {
    padding: 16px 20px;
    background: #FFFFFF;
    border-bottom: 1px solid var(--fleet-slate-100);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.dispatch-code-badge {
    font-size: 16.5px;
    font-weight: 800;
    color: var(--fleet-slate-900);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.dispatch-status-badge {
    padding: 5px 14px;
    border-radius: 9999px;
    font-size: 11.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-PACKED { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
.badge-ASSIGNED { background: #F3E8FF; color: #7C3AED; border: 1px solid #E9D5FF; }
.badge-IN_TRANSIT { background: #DBEAFE; color: #1D4ED8; border: 1px solid #BFDBFE; }

.dispatch-card-body {
    padding: 20px;
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 20px;
}

.dispatch-info-box {
    background: var(--fleet-slate-50);
    border: 1px solid var(--fleet-slate-200);
    border-radius: var(--radius-md);
    padding: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.dispatch-box-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--fleet-slate-900);
    margin: 0 0 10px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.patient-action-chips {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.btn-chip {
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

.btn-chip-call { background: #E0F2FE; color: #0369A1; }
.btn-chip-call:hover { background: #BAE6FD; }
.btn-chip-whatsapp { background: #DCFCE7; color: #15803D; }
.btn-chip-whatsapp:hover { background: #BBF7D0; }
.btn-chip-maps { background: #FEF3C7; color: #92400E; }
.btn-chip-maps:hover { background: #FDE68A; }

.dispatch-card-footer {
    padding: 14px 20px;
    background: #FFFFFF;
    border-top: 1px solid var(--fleet-slate-100);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

/* 6. Sidebar Fleet Radar & Checklist */
.fleet-sidebar-card {
    background: #FFFFFF;
    border: 1px solid var(--fleet-slate-200);
    border-radius: var(--radius-lg);
    padding: 22px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-soft);
}

.fleet-sidebar-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--fleet-slate-900);
    margin: 0 0 4px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.fleet-rider-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--fleet-slate-100);
}

.fleet-rider-row:last-child {
    border-bottom: none;
}

.rider-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #E0F2FE;
    color: #0284C7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
    flex-shrink: 0;
}

.rider-status-pill {
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}

.rider-status-AVAILABLE { background: #DCFCE7; color: #15803D; }
.rider-status-BUSY { background: #FEF3C7; color: #B45309; }
.rider-status-OFFLINE { background: #F1F5F9; color: #64748B; }

/* Protocol Checklist */
.checklist-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px 0;
    font-size: 12.5px;
    color: var(--fleet-slate-600);
    line-height: 1.45;
}

.checklist-item i {
    color: var(--fleet-emerald);
    margin-top: 3px;
    font-size: 14px;
}

/* Floating Toast Notifications */
.delivery-toast-container {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.delivery-toast {
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

.delivery-toast-success { border-left: 4px solid #10B981; }
.delivery-toast-error { border-left: 4px solid #E11D48; }

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@media (max-width: 1024px) {
    .fleet-kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .delivery-layout-grid { grid-template-columns: 1fr; }
    .dispatch-card-body { grid-template-columns: 1fr; }
}

@media (max-width: 767.98px) {
    .delivery-console-container { padding: 16px 14px; }
    .fleet-kpi-grid { grid-template-columns: 1fr; }
    .delivery-header-card { flex-direction: column; align-items: flex-start; }
    .delivery-filter-bar { flex-direction: column; align-items: stretch; }
}
</style>

<div class="delivery-console-container">
    <!-- 1. Header Command Bar -->
    <div class="delivery-header-card">
        <div class="delivery-header-left">
            <div class="delivery-header-icon">
                <i class="fas fa-truck-loading"></i>
            </div>
            <div class="delivery-header-title">
                <h1>Delivery Logistics &amp; Fleet Handover Desk</h1>
                <p>Assign delivery riders, inspect tamper-proof medicine seals, verify handoffs, and track in-transit orders.</p>
            </div>
        </div>

        <div class="delivery-header-actions">
            <!-- Active Store Badge -->
            <div class="store-badge-pill">
                <span class="store-badge-dot"></span>
                <span><i class="fas fa-store-alt"></i> <?=$storeName;?> (<?=$storeCity;?>)</span>
            </div>

            <!-- Multi-Store Dropdown Switcher -->
            <?php if (!empty($stores) && count($stores) > 1): ?>
                <select class="form-control" onchange="location.href='<?=base_url('pharmacy/delivery?store_id=');?>'+this.value" style="display: inline-block; width: auto; height: 38px; border-radius: 9999px; background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.25); font-weight: 600; padding: 0 14px;">
                    <?php foreach($stores as $st): ?>
                        <option value="<?=$st['id'];?>" <?=$st['id'] == $current_store['id'] ? 'selected' : '';?> style="color: #0F172A; background: #FFF;">
                            <?=$st['store_name'];?> (<?=$st['city'];?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <!-- Live Refresh Button -->
            <button type="button" onclick="location.reload();" class="btn-delivery-refresh" title="Reload Live Fleet Queue">
                <i class="fas fa-sync-alt"></i> <span>Refresh Queue</span>
            </button>
        </div>
    </div>

    <!-- 2. Fleet & Dispatch KPI Ribbon -->
    <div class="fleet-kpi-grid">
        <!-- Metric 1: Ready for Fleet (Packed) -->
        <div class="fleet-kpi-card kpi-card-amber">
            <div class="kpi-icon-box"><i class="fas fa-box"></i></div>
            <div>
                <div class="kpi-val-text"><?=$kpi['packed_count'];?></div>
                <div class="kpi-lbl-text">Packed &bull; Awaiting Rider</div>
            </div>
        </div>

        <!-- Metric 2: Assigned Rider Arriving -->
        <div class="fleet-kpi-card kpi-card-purple">
            <div class="kpi-icon-box"><i class="fas fa-user-check"></i></div>
            <div>
                <div class="kpi-val-text"><?=$kpi['assigned_count'];?></div>
                <div class="kpi-lbl-text">Rider Assigned &bull; Arriving</div>
            </div>
        </div>

        <!-- Metric 3: In-Transit on Road -->
        <div class="fleet-kpi-card kpi-card-blue">
            <div class="kpi-icon-box"><i class="fas fa-motorcycle"></i></div>
            <div>
                <div class="kpi-val-text"><?=$kpi['in_transit_count'];?></div>
                <div class="kpi-lbl-text">In-Transit &bull; On Road</div>
            </div>
        </div>

        <!-- Metric 4: Active Fleet Available -->
        <div class="fleet-kpi-card kpi-card-emerald">
            <div class="kpi-icon-box"><i class="fas fa-signal"></i></div>
            <div>
                <div class="kpi-val-text"><?=$kpi['available_riders'];?> / <?=$kpi['total_riders'];?></div>
                <div class="kpi-lbl-text">Active Fleet Online</div>
            </div>
        </div>
    </div>

    <!-- 3. Filter & Search Toolbar -->
    <div class="delivery-filter-bar">
        <div class="delivery-pills-wrap">
            <button type="button" class="delivery-pill-btn active" onclick="filterByStatus('ALL', this)">
                <span>All Active Dispatches</span>
                <span class="pill-count-bubble"><?=count($handovers);?></span>
            </button>
            <button type="button" class="delivery-pill-btn" onclick="filterByStatus('PACKED', this)">
                <i class="fas fa-box" style="color: #D97706;"></i>
                <span>Need Rider</span>
                <span class="pill-count-bubble"><?=$kpi['packed_count'];?></span>
            </button>
            <button type="button" class="delivery-pill-btn" onclick="filterByStatus('ASSIGNED', this)">
                <i class="fas fa-handshake" style="color: #7C3AED;"></i>
                <span>Handover Ready</span>
                <span class="pill-count-bubble"><?=$kpi['assigned_count'];?></span>
            </button>
            <button type="button" class="delivery-pill-btn" onclick="filterByStatus('IN_TRANSIT', this)">
                <i class="fas fa-motorcycle" style="color: #2563EB;"></i>
                <span>In-Transit</span>
                <span class="pill-count-bubble"><?=$kpi['in_transit_count'];?></span>
            </button>
        </div>

        <!-- Client Search Box -->
        <div class="delivery-search-box">
            <i class="fas fa-search delivery-search-icon"></i>
            <input type="text" id="deliverySearchInput" placeholder="Filter by Order Code, Patient Name, Address, or Rider..." onkeyup="filterDeliveryQueue(this.value)">
        </div>
    </div>

    <!-- 4. Split-Screen Layout (8 Cols Main / 4 Cols Sidebar) -->
    <div class="delivery-layout-grid">
        <!-- Main Column: Active Dispatch & Handover Queue -->
        <div class="delivery-queue-col">
            <div id="dispatchQueueWrapper">
                <?php if(empty($handovers)): ?>
                    <div style="background: #FFFFFF; border-radius: var(--radius-lg); border: 1px solid var(--fleet-slate-200); padding: 60px 24px; text-align: center; color: #94A3B8; box-shadow: var(--shadow-soft);">
                        <i class="fas fa-box-open" style="font-size: 54px; margin-bottom: 16px; opacity: 0.4; color: var(--fleet-teal);"></i>
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--fleet-slate-800); margin: 0 0 6px;">All Dispatches Clear</h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0 0 18px;">When medicine orders are marked "PACKED", they will immediately appear here for delivery fleet assignment.</p>
                        <a href="<?=base_url('pharmacy/orders');?>" class="btn btn-sm btn-primary" style="background: var(--fleet-navy); border: none; font-weight: 700; border-radius: 9999px; padding: 7px 20px;">
                            <i class="fas fa-receipt"></i> Go to Live Orders
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach($handovers as $h): 
                        $st = strtoupper($h['order_status']);
                        $cleanCode = htmlspecialchars($h['order_code']);
                        $custName = htmlspecialchars($h['customer_name']);
                        $custPhone = htmlspecialchars($h['customer_phone']);
                        $custAddress = htmlspecialchars($h['delivery_address']);
                        $orderTotal = number_format($h['total_amount'], 2);
                        $isCod = strtoupper($h['payment_mode']) === 'COD';
                        $riderAssigned = !empty($h['rider_id']);
                        $mapsQuery = urlencode($custAddress . ', ' . $storeCity);
                    ?>
                    <div class="dispatch-card-modern dispatch-card-<?=$st;?>" id="dispatch_card_<?=$h['id'];?>" data-status="<?=$st;?>" data-search-index="<?=strtolower($cleanCode.' '.$custName.' '.$custPhone.' '.$custAddress.' '.($h['rider_name'] ?? ''));?>">
                        <!-- Card Header -->
                        <div class="dispatch-card-header">
                            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                <span class="dispatch-code-badge">
                                    <i class="fas fa-hashtag" style="color: var(--fleet-teal); font-size: 14px;"></i><?=$cleanCode;?>
                                </span>
                                <span class="dispatch-status-badge badge-<?=$st;?>">
                                    <?=$st === 'PACKED' ? 'PACKED &bull; NEED RIDER' : ($st === 'ASSIGNED' ? 'RIDER ASSIGNED' : 'IN-TRANSIT');?>
                                </span>
                                <span style="font-size: 12.5px; color: #64748B;">
                                    <i class="far fa-clock"></i> Placed: <?=date('d M, h:i A', strtotime($h['created_at']));?>
                                </span>
                            </div>

                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span class="badge" style="background: <?=$isCod ? '#FEF3C7' : '#DCFCE7';?>; color: <?=$isCod ? '#B45309' : '#15803D';?>; font-size: 12px; font-weight: 700; padding: 5px 12px; border: 1px solid <?=$isCod ? '#FDE68A' : '#BBF7D0';?>;">
                                    <?=$isCod ? '<i class="fas fa-hand-holding-usd"></i> Collect COD: ₹'.$orderTotal : '<i class="fas fa-check-circle"></i> Prepaid (Online)';?>
                                </span>
                                <strong style="font-size: 17px; color: var(--fleet-slate-900);">₹<?=$orderTotal;?></strong>
                            </div>
                        </div>

                        <!-- Card Body (2 Columns) -->
                        <div class="dispatch-card-body">
                            <!-- Left: Patient & Delivery Address -->
                            <div class="dispatch-info-box">
                                <div>
                                    <h4 class="dispatch-box-title">
                                        <i class="fas fa-user-circle" style="color: var(--fleet-teal);"></i> Patient &amp; Delivery Destination
                                    </h4>
                                    <div style="font-size: 14.5px; font-weight: 700; color: var(--fleet-slate-900); margin-bottom: 2px;">
                                        <?=$custName;?>
                                    </div>
                                    <div style="font-size: 13px; color: var(--fleet-slate-600); margin-bottom: 6px;">
                                        <i class="fas fa-phone-alt" style="font-size: 11px; color: #94A3B8;"></i> <?=$custPhone;?>
                                    </div>
                                    <div style="font-size: 12.5px; color: var(--fleet-slate-600); line-height: 1.45;">
                                        <i class="fas fa-map-marker-alt" style="color: #0284C7; font-size: 12px;"></i> <?=$custAddress;?>
                                    </div>

                                    <!-- Quick Action Chips -->
                                    <div class="patient-action-chips">
                                        <a href="tel:<?=$custPhone;?>" class="btn-chip btn-chip-call" title="Call Customer">
                                            <i class="fas fa-phone"></i> Call
                                        </a>
                                        <a href="https://wa.me/91<?=preg_replace('/[^0-9]/', '', $custPhone);?>?text=Hello%20<?=$custName;?>,%20your%20medicine%20order%20<?=$cleanCode;?>%20from%20<?=$storeName;?>%20is%20being%20prepared%20for%20delivery." target="_blank" class="btn-chip btn-chip-whatsapp" title="WhatsApp Customer">
                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                        </a>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?=$mapsQuery;?>" target="_blank" class="btn-chip btn-chip-maps" title="Open Google Maps Route">
                                            <i class="fas fa-directions"></i> Map Route
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Fleet Rider & Handover Status -->
                            <div class="dispatch-info-box">
                                <div>
                                    <h4 class="dispatch-box-title">
                                        <i class="fas fa-biking" style="color: var(--fleet-teal);"></i> Assigned Delivery Partner
                                    </h4>

                                    <?php if($riderAssigned): ?>
                                        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: var(--radius-sm); padding: 12px; margin-bottom: 8px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                                <strong style="font-size: 14px; color: var(--fleet-slate-900);">
                                                    <i class="fas fa-id-badge" style="color: #0284C7;"></i> <?=htmlspecialchars($h['rider_name']);?>
                                                </strong>
                                                <a href="tel:<?=htmlspecialchars($h['rider_phone']);?>" class="btn btn-xs btn-default" style="font-weight: 700; border-radius: 4px;">
                                                    <i class="fas fa-phone text-primary"></i> Call Rider
                                                </a>
                                            </div>
                                            <div style="font-size: 12px; color: #64748B;">
                                                <i class="fas fa-motorcycle"></i> <?=htmlspecialchars($h['vehicle_type'] ?? 'Motorbike');?> &bull; 
                                                <strong><?=htmlspecialchars($h['vehicle_number']);?></strong>
                                            </div>
                                        </div>

                                        <?php if(!empty($h['delivery_otp'])): ?>
                                            <div style="background: #FEF3C7; border: 1px dashed #F59E0B; border-radius: var(--radius-sm); padding: 8px 12px; text-align: center;">
                                                <span style="font-size: 11px; font-weight: 700; color: #92400E; text-transform: uppercase;">Customer Handover OTP:</span>
                                                <span style="font-size: 16px; font-weight: 800; color: #B45309; letter-spacing: 2px; margin-left: 6px;"><?=$h['delivery_otp'];?></span>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div style="text-align: center; padding: 16px 8px; color: #94A3B8;">
                                            <i class="fas fa-exclamation-circle" style="font-size: 26px; color: var(--fleet-amber); margin-bottom: 6px;"></i>
                                            <p style="font-size: 12.5px; color: #64748B; margin-bottom: 10px;">Package is packed. Assign a delivery agent to initiate doorstep dispatch.</p>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="openAssignModal(<?=$h['id'];?>, '<?=$cleanCode;?>')" style="background: var(--fleet-navy); border: none; font-weight: 700; border-radius: 6px; padding: 6px 16px;">
                                                <i class="fas fa-user-plus"></i> Select Delivery Agent
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Handover Actions -->
                        <div class="dispatch-card-footer">
                            <div style="font-size: 12.5px; color: #64748B;">
                                <i class="fas fa-shield-alt text-success"></i> Tamper-evident pharmacy barcode attached
                            </div>

                            <div style="display: flex; gap: 8px;">
                                <?php if(!$riderAssigned): ?>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="openAssignModal(<?=$h['id'];?>, '<?=$cleanCode;?>')" style="background: var(--fleet-teal); border: none; font-weight: 700; border-radius: 6px; padding: 7px 18px;">
                                        <i class="fas fa-motorcycle"></i> Assign Fleet Rider
                                    </button>
                                <?php elseif($st !== 'IN_TRANSIT'): ?>
                                    <button type="button" class="btn btn-sm btn-success" onclick="confirmHandover(<?=$h['id'];?>, this)" style="background: var(--fleet-emerald); border: none; font-weight: 700; border-radius: 6px; padding: 7px 18px;">
                                        <i class="fas fa-handshake"></i> Confirm Physical Handoff &bull; Dispatch
                                    </button>
                                <?php else: ?>
                                    <span class="badge" style="background: #DCFCE7; color: #15803D; font-size: 12.5px; font-weight: 700; padding: 6px 14px;">
                                        <i class="fas fa-motorcycle"></i> Dispatched &bull; En Route to Doorstep
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar Column: Active Delivery Fleet & Chemist Protocol -->
        <div class="delivery-sidebar-col">
            <!-- Available Delivery Fleet -->
            <div class="fleet-sidebar-card">
                <div class="fleet-sidebar-title">
                    <i class="fas fa-motorcycle" style="color: var(--fleet-teal);"></i>
                    <span>Available Delivery Fleet (<?=count($riders);?>)</span>
                </div>
                <p style="font-size: 12.5px; color: #64748B; margin: 0 0 14px 0;">
                    Certified riders operating within local pharmacy delivery zone.
                </p>

                <div>
                    <?php if(empty($riders)): ?>
                        <p style="color: #94A3B8; font-size: 13px;">No active riders online at the moment.</p>
                    <?php else: ?>
                        <?php foreach($riders as $r): 
                            $rStatus = strtoupper($r['status'] ?? 'AVAILABLE');
                            $rName = htmlspecialchars($r['rider_name']);
                            $rPhone = htmlspecialchars($r['phone']);
                            $rVeh = htmlspecialchars($r['vehicle_number']);
                            $rType = htmlspecialchars($r['vehicle_type'] ?? 'Bike');
                            $initials = strtoupper(substr($rName, 0, 1));
                        ?>
                        <div class="fleet-rider-row">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="rider-avatar"><?=$initials;?></div>
                                <div>
                                    <div style="font-size: 13.5px; font-weight: 700; color: var(--fleet-slate-900);">
                                        <?=$rName;?>
                                    </div>
                                    <div style="font-size: 11.5px; color: #64748B;">
                                        <?=$rType;?> &bull; <strong><?=$rVeh;?></strong>
                                    </div>
                                    <div style="font-size: 11px; color: #94A3B8;">
                                        <i class="fas fa-phone-alt"></i> <?=$rPhone;?>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <span class="rider-status-pill rider-status-<?=$rStatus;?>"><?=$rStatus;?></span>
                                <div style="margin-top: 4px;">
                                    <a href="tel:<?=$rPhone;?>" class="btn btn-xs btn-default" style="font-size: 10.5px; font-weight: 700;" title="Call Rider">
                                        <i class="fas fa-phone"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Chemist Handoff Protocol & Compliance Checklist -->
            <div class="fleet-sidebar-card" style="border-left: 4px solid var(--fleet-navy);">
                <div class="fleet-sidebar-title" style="font-size: 15px;">
                    <i class="fas fa-clipboard-check" style="color: var(--fleet-teal);"></i>
                    <span>Chemist Handoff Protocol</span>
                </div>
                <div style="margin-top: 10px;">
                    <div class="checklist-item">
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Tamper-Evident Bag:</strong> Pack medicines in a securely sealed UPCHAR waterproof pouch.</span>
                    </div>
                    <div class="checklist-item">
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Doctor Rx Verification:</strong> Ensure doctor prescription and printed tax invoice are enclosed inside.</span>
                    </div>
                    <div class="checklist-item">
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Schedule H/H1 Stamp:</strong> Pharmacist registration seal must be stamped on schedule medicines.</span>
                    </div>
                    <div class="checklist-item">
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Vehicle Verification:</strong> Verify the rider's vehicle license plate before handing over packages.</span>
                    </div>
                </div>
            </div>

            <!-- Statutory Intermediary Notice -->
            <div style="padding: 14px; background: #FFFFFF; border: 1px solid var(--fleet-slate-200); border-radius: var(--radius-md); font-size: 11.5px; color: #64748B; line-height: 1.45;">
                <strong>STATUTORY NOTICE:</strong> UPCHAR operates solely as a digital logistics intermediary under the Information Technology Act, 2000. All dispensing, cold-chain integrity, and batch labeling are executed exclusively by licensed partner chemist stores.
            </div>
        </div>
    </div>
</div>

<!-- Modal: Assign Delivery Rider -->
<div class="modal fade" id="modalAssignRider" tabindex="-1" role="dialog" aria-labelledby="assignFleetTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: var(--radius-md); overflow: hidden;">
            <div class="modal-header" style="background: var(--fleet-navy); color: #FFF; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFF; opacity: 0.85;">&times;</button>
                <h4 class="modal-title" id="assignFleetTitle" style="font-weight: 800; font-size: 16px;">
                    <i class="fas fa-motorcycle" style="color: #38BDF8;"></i> Assign Delivery Fleet
                </h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <form id="formAssignRider">
                    <input type="hidden" name="order_id" id="assign_order_id">
                    <div class="form-group">
                        <label style="font-size: 12px; font-weight: 700; color: #475569;">Order Code:</label>
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
                    <button type="submit" id="btnSubmitAssignRider" class="btn btn-block" style="background: var(--fleet-teal); color: #FFF; font-weight: 800; border-radius: 8px; height: 42px; margin-top: 14px;">
                        <i class="fas fa-check"></i> Confirm Fleet Dispatch
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Floating Toast Alerts Container -->
<div class="delivery-toast-container" id="deliveryToastContainer"></div>

<script>
// Filter by status pill (ALL, PACKED, ASSIGNED, IN_TRANSIT)
function filterByStatus(status, btnElement) {
    $('.delivery-pill-btn').removeClass('active');
    $(btnElement).addClass('active');

    const cards = document.querySelectorAll('.dispatch-card-modern');
    cards.forEach(card => {
        const cardStatus = card.getAttribute('data-status') || '';
        if (status === 'ALL' || cardStatus === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Real-time client-side search
function filterDeliveryQueue(query) {
    const q = query.trim().toLowerCase();
    const cards = document.querySelectorAll('.dispatch-card-modern');

    cards.forEach(card => {
        const index = card.getAttribute('data-search-index') || '';
        if (!q || index.indexOf(q) !== -1) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Non-blocking toast alerts
function showDeliveryToast(message, type = 'success') {
    const container = document.getElementById('deliveryToastContainer');
    const toast = document.createElement('div');
    toast.className = `delivery-toast delivery-toast-${type}`;
    toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle text-success' : 'fa-exclamation-triangle text-danger'}"></i> <span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transition = 'all 0.3s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3200);
}

// Modal open helper
function openAssignModal(orderId, orderCode) {
    $('#assign_order_id').val(orderId);
    $('#assign_order_code').val(orderCode);
    $('#modalAssignRider').modal('show');
}

// Submit Rider assignment via AJAX
$('#formAssignRider').on('submit', function(e) {
    e.preventDefault();
    const btn = $('#btnSubmitAssignRider');
    const origHtml = btn.html();
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
            showDeliveryToast(res.message || 'Delivery rider assigned successfully!');
            setTimeout(() => location.reload(), 800);
        },
        error: function(err) {
            btn.prop('disabled', false).html(origHtml);
            const msg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : 'Failed to assign rider.';
            showDeliveryToast(msg, 'error');
        }
    });
});

// Confirm physical handoff and mark in-transit
function confirmHandover(orderId, btnElement) {
    const origHtml = btnElement ? btnElement.innerHTML : '';
    if (btnElement) {
        btnElement.disabled = true;
        btnElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Dispatching...';
    }

    $.ajax({
        url: '<?=base_url("pharmacy/orders/status");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_id: orderId,
            status: 'IN_TRANSIT'
        }),
        success: function(res) {
            showDeliveryToast('Physical handover recorded! Order is now In-Transit.');
            setTimeout(() => location.reload(), 800);
        },
        error: function(err) {
            if (btnElement) {
                btnElement.disabled = false;
                btnElement.innerHTML = origHtml;
            }
            const msg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : 'Failed to confirm handover.';
            showDeliveryToast(msg, 'error');
        }
    });
}
</script>
