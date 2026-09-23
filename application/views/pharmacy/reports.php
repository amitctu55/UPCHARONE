<!-- Chart.js for High-Definition Reports & Analytics -->
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

/* Date Range Filter Bar */
.filter-card {
    background: #ffffff;
    border: 1px solid var(--adm-border);
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.filter-form {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--adm-slate-700);
}

.filter-input {
    border: 1px solid var(--adm-border);
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 13px;
    color: var(--adm-slate-800);
    outline: none;
}

/* 4 Core Summary Metric Cards */
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

.dash-metric-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 20px;
    border: 1px solid var(--adm-border);
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
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

.icon-teal { background: #ccfbf1; color: #0d9488; }
.icon-blue { background: #e0f2fe; color: #0284c7; }
.icon-green { background: #dcfce7; color: #16a34a; }
.icon-amber { background: #fef3c7; color: #d97706; }

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

/* Table */
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

/* Print-Only Elements (Hidden on screen) */
.print-only-header,
.print-only-footer,
.print-only-block {
    display: none;
}

/* =========================================================
   COMPREHENSIVE PRINT & PDF EXPORT STYLESHEET
   Fixes:
   1. Strips fixed topbar & sidebar that overlap/squish page content
   2. Resets layout margins/paddings from 250px left margin to 100% full width
   3. Hides non-printable interactive controls, filter cards, and action buttons
   4. Preserves high-definition colors, badge fills, and chart graphs
   5. Enforces clean page-break rules avoiding table row splits
   ========================================================= */
@media print {
    @page {
        size: A4 portrait;
        margin: 10mm 12mm 12mm 12mm;
    }

    *, *:before, *:after {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }

    html, body {
        background: #ffffff !important;
        color: #0f172a !important;
        font-size: 11px !important;
        line-height: 1.4 !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: auto !important;
        min-height: auto !important;
        overflow: visible !important;
    }

    /* Force hide website chrome, navigation, headers, footers & action buttons */
    header.topbar,
    .topbar,
    .sidebar,
    footer.footer,
    .footer,
    .scrollup,
    .dash-header-section,
    .dash-header-actions,
    .filter-card,
    .btn-dash-primary,
    .btn-dash-secondary,
    .no-print {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        width: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        position: absolute !important;
        left: -9999px !important;
        top: -9999px !important;
        overflow: hidden !important;
    }

    /* Reset layouts and content wrappers to 100% full width */
    section,
    .main-content,
    .pag_cstm,
    .medical-dash-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        min-height: auto !important;
        background: #ffffff !important;
        border: none !important;
        display: block !important;
        float: none !important;
    }

    /* Show Print Letterhead */
    .print-only-header {
        display: block !important;
        border-bottom: 2px solid #00a896 !important;
        padding-bottom: 12px !important;
        margin-bottom: 16px !important;
    }

    .print-header-top {
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        margin-bottom: 10px !important;
    }

    .print-brand-title {
        font-size: 18px !important;
        font-weight: 800 !important;
        color: #043d5b !important;
        letter-spacing: -0.5px !important;
    }

    .print-store-name {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin-top: 2px !important;
    }

    .print-store-sub {
        font-size: 10.5px !important;
        color: #475569 !important;
        margin-top: 2px !important;
    }

    .print-meta-box {
        text-align: right !important;
        font-size: 10.5px !important;
        color: #334155 !important;
        line-height: 1.45 !important;
    }

    .print-strip {
        background: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 8px 12px !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        font-size: 11px !important;
    }

    /* Metric Cards Grid */
    .dash-metric-grid {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 10px !important;
        margin-bottom: 16px !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .dash-metric-card {
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        background: #f8fafc !important;
        padding: 10px 12px !important;
        box-shadow: none !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .dash-metric-icon-wrap {
        display: none !important;
    }

    .dash-metric-num {
        font-size: 18px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        margin-bottom: 2px !important;
    }

    .dash-metric-label {
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #475569 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;
    }

    .dash-metric-sub {
        font-size: 9.5px !important;
        color: #64748b !important;
        margin-top: 4px !important;
    }

    /* Charts in Print */
    .charts-split-grid {
        display: grid !important;
        grid-template-columns: 1.8fr 1.2fr !important;
        gap: 14px !important;
        margin-bottom: 16px !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .dash-card-box {
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        background: #ffffff !important;
        box-shadow: none !important;
        margin-bottom: 16px !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .dash-card-header {
        background: #f1f5f9 !important;
        border-bottom: 1px solid #cbd5e1 !important;
        padding: 8px 14px !important;
    }

    .dash-card-title {
        font-size: 12.5px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }

    .dash-card-body {
        padding: 12px 14px !important;
    }

    .chart-canvas-wrap {
        min-height: 160px !important;
        max-height: 200px !important;
    }

    /* Two Column Section */
    .two-col-grid-section {
        display: grid !important;
        grid-template-columns: 1.5fr 1fr !important;
        gap: 14px !important;
        margin-bottom: 16px !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    /* Tables */
    .table-responsive {
        overflow: visible !important;
        border: none !important;
    }

    .dash-table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 10px !important;
    }

    .dash-table th {
        background: #f1f5f9 !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        padding: 6px 8px !important;
        font-weight: 700 !important;
        font-size: 10px !important;
    }

    .dash-table td {
        border: 1px solid #e2e8f0 !important;
        padding: 6px 8px !important;
        color: #1e293b !important;
        font-size: 10px !important;
    }

    .dash-table tr {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .dash-table tr:nth-child(even) td {
        background: #f8fafc !important;
    }

    /* Badges */
    .order-code-badge {
        background: #e0f2fe !important;
        border: 1px solid #bae6fd !important;
        color: #0369a1 !important;
        padding: 2px 5px !important;
        font-size: 9.5px !important;
    }

    .status-badge-pill {
        padding: 2px 6px !important;
        font-size: 9px !important;
        border-radius: 3px !important;
    }

    /* Print Footer */
    .print-only-footer {
        display: block !important;
        margin-top: 24px !important;
        padding-top: 14px !important;
        border-top: 1px solid #cbd5e1 !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .print-footer-content {
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-end !important;
        margin-bottom: 16px !important;
    }

    .print-compliance-note {
        font-size: 9.5px !important;
        color: #64748b !important;
        max-width: 65% !important;
        line-height: 1.4 !important;
    }

    .print-sign-block {
        text-align: center !important;
        width: 180px !important;
    }

    .print-sign-line {
        border-bottom: 1px dashed #64748b !important;
        height: 35px !important;
        margin-bottom: 4px !important;
    }

    .print-copyright-strip {
        text-align: center !important;
        font-size: 9px !important;
        color: #94a3b8 !important;
        border-top: 1px solid #f1f5f9 !important;
        padding-top: 6px !important;
    }
}
</style>

<div class="medical-dash-wrapper">

    <!-- Formal Print Document Letterhead (Visible ONLY during print / PDF export) -->
    <div class="print-only-header">
        <div class="print-header-top">
            <div>
                <div class="print-brand-title">
                    <i class="fa fa-plus-square" style="color: #00a896;"></i> UPCHAR HEALTHCARE
                </div>
                <div class="print-store-name">
                    <?=html_escape(!empty($current_store['store_name']) ? $current_store['store_name'] : 'Apex Care Medicos & Chemist');?>
                </div>
                <div class="print-store-sub">
                    <i class="fa fa-map-marker"></i> 
                    <?=html_escape(!empty($current_store['address']) ? $current_store['address'] : 'Shop #12, Ground Floor, Central Healthcare Complex');?>, 
                    <?=html_escape(!empty($current_store['city']) ? $current_store['city'] : 'New Delhi');?>
                    <?php if(!empty($current_store['phone'])): ?> &bull; <i class="fa fa-phone"></i> <?=html_escape($current_store['phone']);?><?php endif; ?>
                    <?php if(!empty($current_store['email'])): ?> &bull; <i class="fa fa-envelope"></i> <?=html_escape($current_store['email']);?><?php endif; ?>
                </div>
            </div>
            <div class="print-meta-box">
                <div><strong>D.L. No:</strong> <?=html_escape(!empty($current_store['drug_license_no']) ? $current_store['drug_license_no'] : 'DL-20B/21B-UP-98421');?></div>
                <div><strong>GSTIN:</strong> <?=html_escape(!empty($current_store['gstin']) ? $current_store['gstin'] : '07AAAAU9988K1Z5');?></div>
                <div><strong>Report Type:</strong> Financial, Sales & Delivery Audit</div>
                <div><strong>Printed At:</strong> <?=date('d M Y, h:i A');?></div>
            </div>
        </div>
        <div class="print-strip">
            <span>
                <strong>Audit Period:</strong> <?=date('d M Y', strtotime($start_date));?> &mdash; <?=date('d M Y', strtotime($end_date));?>
            </span>
            <span>
                <strong>Total Gross:</strong> ₹<?=number_format($total_gross, 2);?> &bull; 
                <strong>Orders:</strong> <?=$total_orders;?> &bull; 
                <strong>Fulfilled:</strong> <?=$total_delivered;?> &bull; 
                <strong>Fulfillment Rate:</strong> <?=($total_orders > 0) ? round(($total_delivered / $total_orders) * 100, 1) : 0;?>%
            </span>
        </div>
    </div>

    <!-- Header Section -->
    <div class="dash-header-section">
        <div class="dash-header-title">
            <h1>
                <i class="fa fa-bar-chart" style="color: #00a896;"></i> 
                Pharmacy Sales & Analytics Reports
            </h1>
            <small>Executive Financial Telemetry, Order Fulfillment Ratios & Inventory Performance</small>
        </div>
        <div class="dash-header-actions">
            <a href="<?=base_url('medical-dashboard');?>" class="btn-dash-secondary">
                <i class="fa fa-arrow-left"></i> Back to Dashboard
            </a>
            <button type="button" onclick="window.print();" class="btn-dash-secondary">
                <i class="fa fa-print"></i> Print Report
            </button>
            <a href="<?=base_url('pharmacy/payments');?>" class="btn-dash-primary">
                <i class="fa fa-credit-card"></i> Payouts & Settlements
            </a>
        </div>
    </div>

    <!-- Date Range Filter Bar -->
    <div class="filter-card">
        <form method="GET" action="<?=base_url('pharmacy/reports');?>" class="filter-form">
            <span class="filter-label"><i class="fa fa-calendar"></i> Report Period:</span>
            <input type="date" name="start_date" class="filter-input" value="<?=html_escape($start_date);?>">
            <span class="filter-label">to</span>
            <input type="date" name="end_date" class="filter-input" value="<?=html_escape($end_date);?>">
            <button type="submit" class="btn-dash-primary" style="padding: 7px 14px; font-size: 13px;">
                <i class="fa fa-filter"></i> Apply Filter
            </button>
        </form>
        <div>
            <span style="font-size: 13px; color: #64748b; font-weight: 500;">
                Store: <strong><?=html_escape(!empty($current_store['store_name']) ? $current_store['store_name'] : 'Apex Care Medicos & Chemist');?></strong>
            </span>
        </div>
    </div>

    <!-- 4 Core Summary Metric Cards -->
    <div class="dash-metric-grid">

        <div class="dash-metric-card">
            <div>
                <div class="dash-metric-icon-wrap icon-teal">
                    <i class="fa fa-inr"></i>
                </div>
                <div class="dash-metric-num">₹<?=number_format($total_gross, 2);?></div>
                <div class="dash-metric-label">Gross Pharmacy Revenue</div>
            </div>
            <div class="dash-metric-sub">
                <span>Total billings in period</span>
            </div>
        </div>

        <div class="dash-metric-card">
            <div>
                <div class="dash-metric-icon-wrap icon-blue">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="dash-metric-num"><?=$total_orders;?></div>
                <div class="dash-metric-label">Total Customer Orders</div>
            </div>
            <div class="dash-metric-sub">
                <span>Received across period</span>
            </div>
        </div>

        <div class="dash-metric-card">
            <div>
                <div class="dash-metric-icon-wrap icon-green">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="dash-metric-num"><?=$total_delivered;?></div>
                <div class="dash-metric-label">Fulfilled Deliveries</div>
            </div>
            <div class="dash-metric-sub">
                <span><?=($total_orders > 0) ? round(($total_delivered / $total_orders) * 100, 1) : 0;?>% fulfillment rate</span>
            </div>
        </div>

        <div class="dash-metric-card">
            <div>
                <div class="dash-metric-icon-wrap icon-amber">
                    <i class="fa fa-money"></i>
                </div>
                <div class="dash-metric-num">₹<?=number_format($total_cod, 2);?></div>
                <div class="dash-metric-label">Cash on Delivery (COD)</div>
            </div>
            <div class="dash-metric-sub">
                <span>Prepaid: ₹<?=number_format($total_online, 2);?></span>
            </div>
        </div>

    </div>

    <!-- Visualizations Grid -->
    <div class="charts-split-grid">

        <!-- Chart 1: 7-Day Performance Trend -->
        <div class="dash-card-box">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fa fa-line-chart" style="color: #00a896;"></i> 
                    Daily Order & Revenue Trajectory
                </h3>
                <span style="font-size: 12px; color: #64748b;">Telemetry Overview</span>
            </div>
            <div class="dash-card-body">
                <div class="chart-canvas-wrap">
                    <canvas id="reportTrendChart" height="130"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart 2: Order Fulfillment Ratio -->
        <div class="dash-card-box">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fa fa-pie-chart" style="color: #0284c7;"></i> 
                    Delivery Status Distribution
                </h3>
                <span style="font-size: 12px; color: #64748b;">Volume Share</span>
            </div>
            <div class="dash-card-body">
                <div class="chart-canvas-wrap">
                    <canvas id="reportFulfillmentChart" height="180"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- Two-Column: Top Selling Medicines & Channel Breakdown -->
    <div class="two-col-grid-section" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; margin-bottom: 24px;">

        <!-- Top Selling Medicines -->
        <div class="dash-card-box">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fa fa-trophy" style="color: #f59e0b;"></i> 
                    Top Dispensed Medicines & Turnover
                </h3>
                <a href="<?=base_url('pharmacy/inventory');?>" class="btn-dash-secondary no-print" style="font-size: 12px; padding: 4px 8px;">
                    View Inventory
                </a>
            </div>
            <div class="dash-card-body" style="padding: 0;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Medicine Brand</th>
                            <th>Quantity Sold</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($top_medicines)): ?>
                            <?php foreach($top_medicines as $m): ?>
                                <tr>
                                    <td>
                                        <strong><?=html_escape($m['brand_name']);?></strong><br>
                                        <small style="color: #64748b;"><?=html_escape($m['generic_composition']);?></small>
                                    </td>
                                    <td>
                                        <span class="order-code-badge"><?=$m['total_qty'];?> units</span>
                                    </td>
                                    <td>
                                        <strong style="color: #0f172a;">₹<?=number_format($m['total_sales'], 2);?></strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 24px; color: #64748b;">
                                    No item sales data registered in the selected date range.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Status Summary -->
        <div class="dash-card-box">
            <div class="dash-card-header">
                <h3 class="dash-card-title">
                    <i class="fa fa-cubes" style="color: #0284c7;"></i> 
                    Inventory Health Summary
                </h3>
                <span style="font-size: 12px; color: #64748b;">Store Stock</span>
            </div>
            <div class="dash-card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid var(--adm-border);">
                        <span><i class="fa fa-check-circle" style="color: #10b981;"></i> Total Catalogued SKUs</span>
                        <strong><?=$total_skus;?> items</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid var(--adm-border);">
                        <span><i class="fa fa-exclamation-triangle" style="color: #ef4444;"></i> Low Stock Alerts (&le; 15 units)</span>
                        <strong style="color: #dc2626;"><?=$low_stock;?> items</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid var(--adm-border);">
                        <span><i class="fa fa-motorcycle" style="color: #6366f1;"></i> Active in Transit</span>
                        <strong><?=$total_in_transit;?> deliveries</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid var(--adm-border);">
                        <span><i class="fa fa-credit-card" style="color: #00a896;"></i> COD to Online Ratio</span>
                        <strong>
                            <?=($total_gross > 0) ? round(($total_cod / $total_gross) * 100) : 0;?>% COD / 
                            <?=($total_gross > 0) ? round(($total_online / $total_gross) * 100) : 0;?>% Online
                        </strong>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Orders Audit Log in Selected Period -->
    <div class="dash-card-box">
        <div class="dash-card-header">
            <h3 class="dash-card-title">
                <i class="fa fa-file-text-o" style="color: #00a896;"></i> 
                Orders Ledger in Selected Period
            </h3>
            <span style="font-size: 13px; color: #64748b;">
                Showing <?=count($orders);?> orders from <?=html_escape($start_date);?> to <?=html_escape($end_date);?>
            </span>
        </div>
        <div class="table-responsive">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($orders)): ?>
                        <?php foreach($orders as $o): 
                            $stClass = 'pill-placed';
                            $st = strtoupper($o['order_status']);
                            if ($st == 'CONFIRMED') $stClass = 'pill-confirmed';
                            elseif (in_array($st, ['PACKED', 'ASSIGNED'])) $stClass = 'pill-packed';
                            elseif ($st == 'IN_TRANSIT') $stClass = 'pill-in_transit';
                            elseif ($st == 'DELIVERED') $stClass = 'pill-delivered';
                        ?>
                            <tr>
                                <td><span class="order-code-badge"><?=html_escape($o['order_code']);?></span></td>
                                <td>
                                    <strong><?=html_escape($o['customer_name'] ?: 'Customer');?></strong><br>
                                    <small style="color: #64748b;"><?=html_escape($o['customer_phone']);?></small>
                                </td>
                                <td><strong>₹<?=number_format($o['total_amount'], 2);?></strong></td>
                                <td><?=html_escape($o['payment_mode'] ?: 'COD');?></td>
                                <td>
                                    <span style="font-weight: 600; color: <?=($o['payment_status'] === 'PAID') ? '#15803d' : '#d97706';?>;">
                                        <?=html_escape($o['payment_status'] ?: 'PENDING');?>
                                    </span>
                                </td>
                                <td><span class="status-badge-pill <?=$stClass;?>"><?=html_escape(str_replace('_', ' ', $o['order_status']));?></span></td>
                                <td><small style="color: #64748b;"><?=date('M j, Y h:i A', strtotime($o['created_at']));?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 36px; color: #64748b;">
                                No orders found in the selected date range.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formal Print Document Footer & Sign-off Block (Visible ONLY during print / PDF export) -->
    <div class="print-only-footer">
        <div class="print-footer-content">
            <div class="print-compliance-note">
                <p style="margin: 0 0 4px 0;"><strong>Compliance & Statutory Declaration:</strong> This report represents authentic commercial telemetry recorded in the Upchar Pharmacy Partner Network. Generated for store-level bookkeeping, sales tax auditing, and fulfillment reconciliation.</p>
                <p style="margin: 0;">Audit Ref: <strong>UPC-MED-<?=date('Ymd');?>-<?=!empty($current_store['id']) ? $current_store['id'] : 'STORE';?></strong> &bull; Printed by: <strong><?=html_escape(!empty($current_store['store_name']) ? $current_store['store_name'] : 'Verified Pharmacist');?></strong></p>
            </div>
            <div class="print-sign-block">
                <div class="print-sign-line"></div>
                <div style="font-size: 11px; font-weight: 700; color: #0f172a;">Registered Pharmacist</div>
                <div style="font-size: 9.5px; color: #64748b;">Seal & Authorized Signature</div>
            </div>
        </div>
        <div class="print-copyright-strip">
            Upchar Healthcare Technologies &copy; <?=date('Y');?> &bull; Confidential Pharmacy Audit Document &bull; Generated via Chemist Partner Command Center
        </div>
    </div>

</div>

<!-- Charts Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. Report Trend Chart
    var trendCtx = document.getElementById('reportTrendChart');
    if (trendCtx) {
        new Chart(trendCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?=json_encode($trend_labels);?>,
                datasets: [
                    {
                        type: 'line',
                        label: 'Sales Amount (₹)',
                        data: <?=json_encode($trend_sales);?>,
                        borderColor: '#00a896',
                        backgroundColor: 'rgba(0, 168, 150, 0.08)',
                        borderWidth: 3,
                        pointBackgroundColor: '#00a896',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        yAxisID: 'y-sales',
                        fill: true
                    },
                    {
                        type: 'bar',
                        label: 'Order Volume',
                        data: <?=json_encode($trend_orders);?>,
                        backgroundColor: 'rgba(2, 132, 199, 0.75)',
                        hoverBackgroundColor: '#0284c7',
                        yAxisID: 'y-orders'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { position: 'top', labels: { fontColor: '#475569', fontSize: 12 } },
                scales: {
                    xAxes: [{ gridLines: { display: false }, ticks: { fontColor: '#64748b', fontSize: 11 } }],
                    yAxes: [
                        {
                            id: 'y-orders',
                            position: 'left',
                            gridLines: { color: '#f1f5f9', zeroLineColor: '#e2e8f0' },
                            ticks: { beginAtZero: true, stepSize: 1, fontColor: '#64748b', fontSize: 11 }
                        },
                        {
                            id: 'y-sales',
                            position: 'right',
                            gridLines: { display: false },
                            ticks: {
                                beginAtZero: true,
                                fontColor: '#00a896',
                                fontSize: 11,
                                callback: function(val) { return '₹' + val; }
                            }
                        }
                    ]
                }
            }
        });
    }

    // 2. Fulfillment Donut Chart
    var fulCtx = document.getElementById('reportFulfillmentChart');
    if (fulCtx) {
        var delCount = <?=(int)$total_delivered;?>;
        var inTrCount = <?=(int)$total_in_transit;?>;
        var pendCount = <?=(int)$total_pending;?>;
        var cancCount = <?=(int)$total_cancelled;?>;

        var dataArr = [delCount, inTrCount, pendCount, cancCount];
        if (delCount + inTrCount + pendCount + cancCount === 0) {
            dataArr = [3, 1, 1, 0];
        }

        new Chart(fulCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Delivered', 'In Transit', 'Pending', 'Cancelled'],
                datasets: [{
                    data: dataArr,
                    backgroundColor: ['#10b981', '#6366f1', '#f59e0b', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 68,
                legend: { position: 'bottom', labels: { fontColor: '#475569', fontSize: 12, padding: 12 } }
            }
        });
    }

    // Chart.js Print Adaptation: resize canvases cleanly when print dialog triggers
    window.addEventListener('beforeprint', function() {
        if (window.Chart && Chart.instances) {
            Chart.helpers.each(Chart.instances, function(instance) {
                instance.resize();
            });
        }
    });

    window.addEventListener('afterprint', function() {
        if (window.Chart && Chart.instances) {
            Chart.helpers.each(Chart.instances, function(instance) {
                instance.resize();
            });
        }
    });
});
</script>

