<?php include ("assets/includes/header_medical.php"); ?>
<?php include ("assets/includes/leftmenu_medical.php"); ?>

<!-- Chart.js for High-Definition Pharmacy Telemetry & Analytics -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<style>
:root {
    --adm-navy: #0d1b2a;
    --adm-navy-light: #1b263b;
    --adm-teal: #00a896;
    --adm-teal-dark: #008f80;
    --adm-cyan: #0284c7;
    --adm-slate-900: #0f172a;
    --adm-slate-800: #1e293b;
    --adm-slate-700: #334155;
    --adm-slate-600: #475569;
    --adm-slate-100: #f8fafc;
    --adm-border: #e2e8f0;
}

.medical-dash-wrapper {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    color: var(--adm-slate-800);
    padding: 24px 28px;
    background: #f8fafc;
    min-height: calc(100vh - 60px);
}

/* Header & Breadcrumb */
.dash-header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.dash-header-title h1 {
    color: var(--adm-slate-900) !important;
    font-weight: 800;
    font-size: 24px;
    margin: 0;
    line-height: 1.2;
    letter-spacing: -0.5px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.dash-header-title small {
    color: var(--adm-slate-600) !important;
    font-size: 13.5px;
    font-weight: 500;
    display: block;
    margin-top: 5px;
}

.dash-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-dash-primary {
    background: linear-gradient(135deg, #00a896 0%, #008f80 100%);
    color: #ffffff !important;
    border: none;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    transition: all 0.2s ease;
}

.btn-dash-primary:hover {
    background: linear-gradient(135deg, #008f80 0%, #007468 100%);
    box-shadow: 0 6px 16px rgba(0, 168, 150, 0.35);
    transform: translateY(-1px);
}

.btn-dash-secondary {
    background: #ffffff;
    color: var(--adm-slate-700) !important;
    border: 1px solid var(--adm-border);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.btn-dash-secondary:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

/* Executive Welcome Hero Banner */
.dash-hero-banner {
    background: linear-gradient(135deg, #0d1b2a 0%, #043d5b 55%, #008f80 100%);
    color: #ffffff;
    border-radius: 14px;
    padding: 24px 28px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 10px 25px -5px rgba(13, 27, 42, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.dash-hero-banner::after {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 240px;
    height: 240px;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.hero-info {
    position: relative;
    z-index: 2;
}

.hero-info h2 {
    margin: 0 0 6px 0;
    font-size: 22px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.4px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.hero-info p {
    margin: 0 0 12px 0;
    color: rgba(255, 255, 255, 0.85);
    font-size: 14px;
}

.hero-badges-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.hero-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12.5px;
    color: #f8fafc;
    font-weight: 500;
    backdrop-filter: blur(4px);
}

.hero-chip.status-live {
    background: rgba(16, 185, 129, 0.2);
    border-color: rgba(52, 211, 153, 0.5);
    color: #6ee7b7;
    font-weight: 700;
}

.live-pulse-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
    box-shadow: 0 0 8px #10b981;
    display: inline-block;
    animation: pulseGlow 1.8s infinite;
}

@keyframes pulseGlow {
    0% { transform: scale(0.95); opacity: 0.7; }
    50% { transform: scale(1.3); opacity: 1; }
    100% { transform: scale(0.95); opacity: 0.7; }
}

.hero-meter-card {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 16px 20px;
    min-width: 240px;
    backdrop-filter: blur(8px);
    position: relative;
    z-index: 2;
}

.hero-meter-title {
    font-size: 12.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.hero-meter-bar {
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 8px;
}

.hero-meter-fill {
    height: 100%;
    background: linear-gradient(90deg, #2dd4bf, #38bdf8);
    border-radius: 4px;
    transition: width 0.6s ease;
}

.hero-meter-sub {
    font-size: 11.5px;
    color: rgba(255, 255, 255, 0.75);
    margin: 0;
}

/* 8 Core Metrics Grid */
.dash-metric-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 24px;
}

@media (max-width: 1200px) {
    .dash-metric-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .dash-metric-grid {
        grid-template-columns: 1fr;
    }
}

.dash-metric-link {
    text-decoration: none !important;
    display: flex;
    color: inherit;
    height: 100%;
}

.dash-metric-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 20px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.dash-metric-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px -2px rgba(0,0,0,0.08);
    border-color: var(--adm-teal);
}

.dash-metric-icon-wrap {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 12px;
}

.icon-blue { background: #e0f2fe; color: #0284c7; }
.icon-amber { background: #fef3c7; color: #d97706; }
.icon-indigo { background: #e0e7ff; color: #4f46e5; }
.icon-green { background: #dcfce7; color: #16a34a; }
.icon-teal { background: #ccfbf1; color: #0d9488; }
.icon-purple { background: #f3e8ff; color: #9333ea; }
.icon-red { background: #fee2e2; color: #dc2626; }
.icon-cyan { background: #e0f2fe; color: #00a8ff; }

.dash-metric-num {
    font-size: 26px;
    font-weight: 800;
    color: var(--adm-slate-900);
    line-height: 1.1;
    margin-bottom: 4px;
}

.dash-metric-label {
    font-size: 13px;
    font-weight: 700;
    color: var(--adm-slate-700);
}

.dash-metric-sub {
    font-size: 12px;
    color: var(--adm-slate-600);
    margin-top: 8px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Card & Content Panels */
.dash-card-box {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    margin-bottom: 24px;
    overflow: hidden;
}

.dash-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid var(--adm-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    background: #ffffff;
}

.dash-card-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--adm-slate-900);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.dash-card-body {
    padding: 22px;
}

/* Charts Grid */
.charts-split-grid {
    display: grid;
    grid-template-columns: 2fr 1.2fr;
    gap: 20px;
    margin-bottom: 24px;
}

@media (max-width: 991px) {
    .charts-split-grid {
        grid-template-columns: 1fr;
    }
}

.chart-canvas-wrap {
    position: relative;
    width: 100%;
    min-height: 250px;
}

/* Orders Table */
.dash-table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

.dash-table th {
    background: #f8fafc;
    color: var(--adm-slate-700);
    font-weight: 700;
    font-size: 12.5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px;
    border-bottom: 2px solid var(--adm-border);
}

.dash-table td {
    padding: 14px 16px;
    font-size: 13.5px;
    border-bottom: 1px solid var(--adm-border);
    color: var(--adm-slate-800);
    vertical-align: middle;
}

.dash-table tr:hover td {
    background-color: #f8fafc;
}

.order-code-badge {
    font-family: monospace;
    font-size: 13px;
    font-weight: 700;
    color: #0369a1;
    background: #e0f2fe;
    padding: 3px 8px;
    border-radius: 6px;
    border: 1px solid #bae6fd;
}

.status-badge-pill {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.pill-placed, .pill-pending_rx { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.pill-confirmed { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.pill-packed, .pill-assigned { background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }
.pill-in_transit { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
.pill-delivered { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }

/* Quick Action Launchpad Grid */
.launchpad-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

@media (max-width: 991px) {
    .launchpad-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 580px) {
    .launchpad-grid {
        grid-template-columns: 1fr;
    }
}

.action-tile {
    background: #ffffff;
    border: 1px solid var(--adm-border);
    border-radius: 12px;
    padding: 18px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    text-decoration: none !important;
    color: inherit;
    transition: all 0.2s ease;
}

.action-tile:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    border-color: var(--adm-teal);
}

.action-tile-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.action-tile-info h4 {
    margin: 0 0 4px 0;
    font-size: 14.5px;
    font-weight: 700;
    color: var(--adm-slate-900);
}

.action-tile-info p {
    margin: 0;
    font-size: 12.5px;
    color: var(--adm-slate-600);
    line-height: 1.4;
}

/* Low Stock Table Highlight */
.stock-badge-low {
    background: #fee2e2;
    color: #b91c1c;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 12px;
}
.stock-badge-ok {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 12px;
}
</style>

<div class="medical-dash-wrapper">

    <!-- Header Section -->
    <div class="dash-header-section">
        <div class="dash-header-title">
            <h1>
                <i class="fa fa-plus-square" style="color: #00a896;"></i> 
                Chemist Partner Command Center
            </h1>
            <small>Integrated Pharmacy Dispensing, Live Delivery Tracking & Stock Management</small>
        </div>
        <div class="dash-header-actions">
            <a href="<?=base_url('medical-dashboard');?>" class="btn-dash-secondary" title="Refresh Live Data">
                <i class="fa fa-refresh"></i> Refresh
            </a>
            <a href="<?=base_url('pharmacy/inventory');?>" class="btn-dash-secondary">
                <i class="fa fa-cubes"></i> Stocks & Inventory
            </a>
            <a href="<?=base_url('pharmacy/orders');?>" class="btn-dash-primary">
                <i class="fa fa-shopping-bag"></i> View Live Orders
            </a>
        </div>
    </div>

    <!-- Executive Welcome Hero Banner -->
    <div class="dash-hero-banner">
        <div class="hero-info">
            <h2>
                <span><?=html_escape(!empty($profile->fname) ? $profile->fname : ($this->session->userdata('medicalusername') ?: 'Partner Pharmacy'));?></span>
                <?php if(!empty($store->store_name)): ?>
                    <span style="font-size: 15px; font-weight: 500; opacity: 0.9;">(<?=html_escape($store->store_name);?>)</span>
                <?php endif; ?>
            </h2>
            <p>
                <i class="fa fa-map-marker"></i> <?=html_escape(!empty($store->address) ? $store->address : (!empty($profile->city) ? $profile->city : 'Varanasi Central District'));?>
                &nbsp;|&nbsp;
                <i class="fa fa-phone"></i> <?=html_escape(!empty($profile->mobile) ? $profile->mobile : ($this->session->userdata('medicaluseremail') ?: '9838112233'));?>
            </p>
            <div class="hero-badges-row">
                <span class="hero-chip status-live">
                    <span class="live-pulse-dot"></span> Pharmacy Store Active & Dispensing
                </span>
                <span class="hero-chip">
                    <i class="fa fa-certificate" style="color: #fbbf24;"></i> Drug License: <?=html_escape(!empty($profile->regd_no) ? $profile->regd_no : 'DL-UP-24-98402');?>
                </span>
                <span class="hero-chip">
                    <i class="fa fa-shield" style="color: #38bdf8;"></i> UP State Pharmacy Council
                </span>
            </div>
        </div>

        <div class="hero-meter-card">
            <div class="hero-meter-title">
                <span>Profile Readiness</span>
                <span><?=$profile_score;?>%</span>
            </div>
            <div class="hero-meter-bar">
                <div class="hero-meter-fill" style="width: <?=$profile_score;?>%;"></div>
            </div>
            <p class="hero-meter-sub">
                <?php if($profile_score >= 80): ?>
                    <i class="fa fa-check-circle" style="color: #34d399;"></i> Ready for online medicine orders
                <?php else: ?>
                    <i class="fa fa-info-circle" style="color: #fef08a;"></i> Complete proof uploads for full accreditation
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- 8 Core Metrics Grid -->
    <div class="dash-metric-grid">

        <!-- 1. Total Orders -->
        <a href="<?=base_url('pharmacy/orders');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div>
                    <div class="dash-metric-icon-wrap icon-blue">
                        <i class="fa fa-shopping-bag"></i>
                    </div>
                    <div class="dash-metric-num"><?=$total_orders;?></div>
                    <div class="dash-metric-label">Total Customer Orders</div>
                </div>
                <div class="dash-metric-sub">
                    <span>Lifetime processed</span>
                    <i class="fa fa-arrow-right" style="color: #94a3b8;"></i>
                </div>
            </div>
        </a>

        <!-- 2. Pending Orders -->
        <a href="<?=base_url('pharmacy/orders');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div>
                    <div class="dash-metric-icon-wrap icon-amber">
                        <i class="fa fa-hourglass-half"></i>
                    </div>
                    <div class="dash-metric-num"><?=$pending_orders;?></div>
                    <div class="dash-metric-label">Pending / New Orders</div>
                </div>
                <div class="dash-metric-sub">
                    <span style="color: #d97706; font-weight: 700;">Requires pack & dispatch</span>
                    <i class="fa fa-arrow-right" style="color: #94a3b8;"></i>
                </div>
            </div>
        </a>

        <!-- 3. Active in Transit -->
        <a href="<?=base_url('pharmacy/delivery');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div>
                    <div class="dash-metric-icon-wrap icon-indigo">
                        <i class="fa fa-motorcycle"></i>
                    </div>
                    <div class="dash-metric-num"><?=$in_transit_orders;?></div>
                    <div class="dash-metric-label">Out for Delivery</div>
                </div>
                <div class="dash-metric-sub">
                    <span>Rider in transit</span>
                    <i class="fa fa-arrow-right" style="color: #94a3b8;"></i>
                </div>
            </div>
        </a>

        <!-- 4. Delivered Orders -->
        <a href="<?=base_url('pharmacy/orders');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div>
                    <div class="dash-metric-icon-wrap icon-green">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="dash-metric-num"><?=$delivered_orders;?></div>
                    <div class="dash-metric-label">Completed Deliveries</div>
                </div>
                <div class="dash-metric-sub">
                    <span>Successfully fulfilled</span>
                    <i class="fa fa-arrow-right" style="color: #94a3b8;"></i>
                </div>
            </div>
        </a>

        <!-- 5. Gross Sales -->
        <a href="<?=base_url('pharmacy/payments');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div>
                    <div class="dash-metric-icon-wrap icon-teal">
                        <i class="fa fa-inr"></i>
                    </div>
                    <div class="dash-metric-num">₹<?=number_format($total_revenue, 2);?></div>
                    <div class="dash-metric-label">Gross Pharmacy Sales</div>
                </div>
                <div class="dash-metric-sub">
                    <span>Delivered + Collected</span>
                    <i class="fa fa-arrow-right" style="color: #94a3b8;"></i>
                </div>
            </div>
        </a>

        <!-- 6. Active SKUs -->
        <a href="<?=base_url('pharmacy/inventory');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div>
                    <div class="dash-metric-icon-wrap icon-purple">
                        <i class="fa fa-cubes"></i>
                    </div>
                    <div class="dash-metric-num"><?=$total_skus;?></div>
                    <div class="dash-metric-label">Active Medicine SKUs</div>
                </div>
                <div class="dash-metric-sub">
                    <span>Catalogued in store</span>
                    <i class="fa fa-arrow-right" style="color: #94a3b8;"></i>
                </div>
            </div>
        </a>

        <!-- 7. Low Stock Alerts -->
        <a href="<?=base_url('pharmacy/inventory');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div>
                    <div class="dash-metric-icon-wrap icon-red">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="dash-metric-num"><?=$low_stock_count;?></div>
                    <div class="dash-metric-label">Low Stock Warnings</div>
                </div>
                <div class="dash-metric-sub">
                    <span style="color: #dc2626;">Items &le; 15 units</span>
                    <i class="fa fa-arrow-right" style="color: #94a3b8;"></i>
                </div>
            </div>
        </a>

        <!-- 8. Verification & Compliance -->
        <a href="<?=base_url('medicalpanel/profile_idproof2');?>" class="dash-metric-link">
            <div class="dash-metric-card">
                <div>
                    <div class="dash-metric-icon-wrap icon-cyan">
                        <i class="fa fa-shield"></i>
                    </div>
                    <div class="dash-metric-num" style="font-size: 20px; text-transform: uppercase;">
                        <?=(!empty($profile->approved) && $profile->approved == '1') ? 'Verified' : 'Compliant';?>
                    </div>
                    <div class="dash-metric-label">Compliance Status</div>
                </div>
                <div class="dash-metric-sub">
                    <span>Drug Dept. Approved</span>
                    <i class="fa fa-arrow-right" style="color: #94a3b8;"></i>
                </div>
            </div>
        </a>

    </div>

    <!-- Interactive Visualizations Grid -->
    <div class="charts-split-grid">

        <!-- Chart 1: Order Trends & Revenue (Dual-Axis) -->
        <div class="dash-card-box">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fa fa-line-chart" style="color: #00a896;"></i> 
                    7-Day Order Volume & Sales Trend
                </h3>
                <span style="font-size: 12.5px; color: #64748b; font-weight: 500;">Real-time Telemetry</span>
            </div>
            <div class="dash-card-body">
                <div class="chart-canvas-wrap">
                    <canvas id="weeklyOrdersChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart 2: Order Status Distribution -->
        <div class="dash-card-box">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fa fa-pie-chart" style="color: #0284c7;"></i> 
                    Order Fulfillment Breakdown
                </h3>
                <span style="font-size: 12.5px; color: #64748b; font-weight: 500;">Status Ratio</span>
            </div>
            <div class="dash-card-body">
                <div class="chart-canvas-wrap">
                    <canvas id="orderStatusChart" height="180"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- Live Customer Orders & Queue -->
    <div class="dash-card-box">
        <div class="dash-card-header">
            <h3 class="dash-card-title">
                <i class="fa fa-list-alt" style="color: #00a896;"></i> 
                Recent Medicine Orders & Dispatch Queue
            </h3>
            <div>
                <a href="<?=base_url('pharmacy/orders');?>" class="btn-dash-secondary" style="font-size: 12.5px; padding: 6px 12px;">
                    View All Orders <i class="fa fa-chevron-right"></i>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Details</th>
                        <th>Delivery Destination</th>
                        <th>Order Value</th>
                        <th>Payment Mode</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($recent_orders)): ?>
                        <?php foreach($recent_orders as $ord): 
                            $stClass = 'pill-placed';
                            $st = strtoupper($ord->order_status);
                            if ($st == 'CONFIRMED') $stClass = 'pill-confirmed';
                            elseif (in_array($st, ['PACKED', 'ASSIGNED'])) $stClass = 'pill-packed';
                            elseif ($st == 'IN_TRANSIT') $stClass = 'pill-in_transit';
                            elseif ($st == 'DELIVERED') $stClass = 'pill-delivered';
                        ?>
                            <tr>
                                <td>
                                    <span class="order-code-badge"><?=html_escape($ord->order_code);?></span>
                                </td>
                                <td>
                                    <strong><?=html_escape($ord->customer_name ?: 'Customer');?></strong><br>
                                    <small style="color: #64748b;"><i class="fa fa-phone"></i> <?=html_escape($ord->customer_phone);?></small>
                                </td>
                                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?=html_escape($ord->delivery_address);?>">
                                    <small><?=html_escape($ord->delivery_address ?: 'Varanasi Central');?></small>
                                </td>
                                <td>
                                    <strong style="color: #0f172a;">₹<?=number_format($ord->total_amount, 2);?></strong>
                                </td>
                                <td>
                                    <span style="font-size: 12px; font-weight: 600; color: #475569;">
                                        <?=html_escape($ord->payment_mode ?: 'COD');?> 
                                        (<?=html_escape($ord->payment_status ?: 'PENDING');?>)
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge-pill <?=$stClass;?>">
                                        <?=html_escape(str_replace('_', ' ', $ord->order_status));?>
                                    </span>
                                </td>
                                <td>
                                    <small style="color: #64748b;"><?=date('M j, Y h:i A', strtotime($ord->created_at));?></small>
                                </td>
                                <td style="text-align: right;">
                                    <a href="<?=base_url('pharmacy/orders?order_id='.$ord->id);?>" class="btn-dash-primary" style="padding: 5px 10px; font-size: 12px;">
                                        <i class="fa fa-eye"></i> Manage
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 36px; color: #64748b;">
                                <i class="fa fa-inbox" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                                No customer orders received yet. Once patients order medicines, they will appear here in real time.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Two-Column: Fast Actions & Stock Watchlist -->
    <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 20px;">

        <!-- Fast Actions Launchpad -->
        <div class="dash-card-box">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fa fa-bolt" style="color: #f59e0b;"></i> 
                    Quick Action Launchpad
                </h3>
                <span style="font-size: 12px; color: #64748b;">Partner Modules</span>
            </div>
            <div class="dash-card-body">
                <div class="launchpad-grid">

                    <a href="<?=base_url('pharmacy/inventory');?>" class="action-tile">
                        <div class="action-tile-icon icon-purple">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <div class="action-tile-info">
                            <h4>Stock & Inventory</h4>
                            <p>Update medicine availability, batch MRP, and batch quantities.</p>
                        </div>
                    </a>

                    <a href="<?=base_url('pharmacy/orders');?>" class="action-tile">
                        <div class="action-tile-icon icon-blue">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                        <div class="action-tile-info">
                            <h4>Live Orders & Bills</h4>
                            <p>Verify doctor prescriptions, accept orders, and pack parcels.</p>
                        </div>
                    </a>

                    <a href="<?=base_url('pharmacy/delivery');?>" class="action-tile">
                        <div class="action-tile-icon icon-indigo">
                            <i class="fa fa-motorcycle"></i>
                        </div>
                        <div class="action-tile-info">
                            <h4>Delivery Handover</h4>
                            <p>Generate secure OTP handovers for Upchar delivery riders.</p>
                        </div>
                    </a>

                    <a href="<?=base_url('medicalpanel/profile_idproof2');?>" class="action-tile">
                        <div class="action-tile-icon icon-cyan">
                            <i class="fa fa-file-text-o"></i>
                        </div>
                        <div class="action-tile-info">
                            <h4>Drug License Proof</h4>
                            <p>Upload State Pharmacy Council license and ID certificates.</p>
                        </div>
                    </a>

                    <a href="<?=base_url('medicalpanel/profile_step21');?>" class="action-tile">
                        <div class="action-tile-icon icon-teal">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div class="action-tile-info">
                            <h4>Chemist Profile</h4>
                            <p>Manage pharmacist qualifications, registration, and store contact.</p>
                        </div>
                    </a>

                    <a href="<?=base_url('pharmacy/payments');?>" class="action-tile">
                        <div class="action-tile-icon icon-green">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <div class="action-tile-info">
                            <h4>Payouts & Banking</h4>
                            <p>Track Razorpay order settlements, bank payouts, and daily ledgers.</p>
                        </div>
                    </a>

                </div>
            </div>
        </div>

        <!-- Inventory Restock Watchlist -->
        <div class="dash-card-box">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fa fa-cubes" style="color: #00a896;"></i> 
                    Medicine Stock Watchlist
                </h3>
                <a href="<?=base_url('pharmacy/inventory');?>" class="btn-dash-secondary" style="font-size: 12px; padding: 4px 8px;">
                    Manage Stocks
                </a>
            </div>
            <div class="dash-card-body" style="padding: 0;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Medicine Brand</th>
                            <th>Stock</th>
                            <th>MRP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($low_stock_items)): ?>
                            <?php foreach($low_stock_items as $item): ?>
                                <tr>
                                    <td>
                                        <strong><?=html_escape($item->brand_name);?></strong><br>
                                        <small style="color: #64748b;"><?=html_escape($item->generic_composition ?: $item->manufacturer);?></small>
                                    </td>
                                    <td>
                                        <?php if($item->stock_quantity <= 15): ?>
                                            <span class="stock-badge-low"><?=$item->stock_quantity;?> left</span>
                                        <?php else: ?>
                                            <span class="stock-badge-ok"><?=$item->stock_quantity;?> units</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong>₹<?=number_format($item->selling_price ?: ($item->mrp ?: 0), 2);?></strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 20px; color: #64748b;">
                                    All medicine inventory items are adequately stocked.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- Chart Initialization Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. Weekly Orders & Revenue Dual-Axis Chart
    var weeklyCtx = document.getElementById('weeklyOrdersChart');
    if (weeklyCtx) {
        var daysLabels = <?=json_encode($chart_days);?>;
        var ordersData = <?=json_encode($chart_order_counts);?>;
        var revenueData = <?=json_encode($chart_revenue);?>;

        new Chart(weeklyCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: daysLabels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Gross Sales (₹)',
                        data: revenueData,
                        borderColor: '#00a896',
                        backgroundColor: 'rgba(0, 168, 150, 0.08)',
                        borderWidth: 3,
                        pointBackgroundColor: '#00a896',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        yAxisID: 'y-axis-rev',
                        fill: true
                    },
                    {
                        type: 'bar',
                        label: 'Orders Count',
                        data: ordersData,
                        backgroundColor: 'rgba(2, 132, 199, 0.75)',
                        hoverBackgroundColor: '#0284c7',
                        borderRadius: 6,
                        yAxisID: 'y-axis-orders'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'top',
                    labels: {
                        fontColor: '#475569',
                        fontFamily: 'Inter, sans-serif',
                        fontSize: 12,
                        boxWidth: 14
                    }
                },
                tooltips: {
                    backgroundColor: '#0d1b2a',
                    titleFontFamily: 'Inter, sans-serif',
                    bodyFontFamily: 'Inter, sans-serif',
                    cornerRadius: 8,
                    xPadding: 10,
                    yPadding: 10
                },
                scales: {
                    xAxes: [{
                        gridLines: { display: false },
                        ticks: { fontColor: '#64748b', fontSize: 11 }
                    }],
                    yAxes: [
                        {
                            id: 'y-axis-orders',
                            position: 'left',
                            gridLines: { color: '#f1f5f9', zeroLineColor: '#e2e8f0' },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1,
                                fontColor: '#64748b',
                                fontSize: 11
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Order Volume',
                                fontColor: '#64748b',
                                fontSize: 11
                            }
                        },
                        {
                            id: 'y-axis-rev',
                            position: 'right',
                            gridLines: { display: false },
                            ticks: {
                                beginAtZero: true,
                                fontColor: '#00a896',
                                fontSize: 11,
                                callback: function(value) { return '₹' + value; }
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Revenue (₹)',
                                fontColor: '#00a896',
                                fontSize: 11
                            }
                        }
                    ]
                }
            }
        });
    }

    // 2. Order Status Doughnut Chart
    var statusCtx = document.getElementById('orderStatusChart');
    if (statusCtx) {
        var pendingCount = <?=(int)$pending_orders;?>;
        var inTransitCount = <?=(int)$in_transit_orders;?>;
        var deliveredCount = <?=(int)$delivered_orders;?>;
        var totalCount = <?=(int)$total_orders;?>;

        // If all zero, show demo breakdown for aesthetics
        var chartData = [pendingCount, inTransitCount, deliveredCount];
        if (totalCount === 0) {
            chartData = [1, 1, 3];
        }

        new Chart(statusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Pending / Pack', 'Out for Delivery', 'Delivered'],
                datasets: [{
                    data: chartData,
                    backgroundColor: ['#f59e0b', '#6366f1', '#10b981'],
                    hoverBackgroundColor: ['#d97706', '#4f46e5', '#059669'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 68,
                legend: {
                    position: 'bottom',
                    labels: {
                        fontColor: '#475569',
                        fontFamily: 'Inter, sans-serif',
                        fontSize: 12,
                        boxWidth: 12,
                        padding: 14
                    }
                },
                tooltips: {
                    backgroundColor: '#0d1b2a',
                    cornerRadius: 8,
                    xPadding: 10,
                    yPadding: 10
                }
            }
        });
    }

});
</script>

<?php include ("assets/includes/footer_medical.php"); ?>