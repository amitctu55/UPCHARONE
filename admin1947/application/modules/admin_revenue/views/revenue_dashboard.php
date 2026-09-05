<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-teal-light: #f0fdfa;
    --upchar-navy: #043d5b;
    --upchar-navy-dark: #022b40;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-border: #e2e8f0;
}

.revenue-dash-wrap {
    padding: 18px 20px 30px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #1e293b;
    background: #f8fafc;
    min-height: 88vh;
}

/* Grid Layout for 4 Dashboard Cards */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  margin-bottom: 22px;
}

/* Base Card Styling */
.kpi-card {
  position: relative;
  border-radius: 12px;
  padding: 24px 20px;
  color: #ffffff;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 140px;
  transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  user-select: none;
}
.kpi-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.16);
}
.kpi-card:active {
  transform: scale(0.98);
}
.kpi-card .card-click-hint {
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  opacity: 0;
  transform: translateY(3px);
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 4px;
}
.kpi-card:hover .card-click-hint {
  opacity: 0.95;
  transform: translateY(0);
}

/* Individual Card Color Themes */
.kpi-card.card-dark-blue {
  background: linear-gradient(135deg, #004b6e 0%, #003652 100%);
}

.kpi-card.card-teal {
  background: linear-gradient(135deg, #009688 0%, #00796b 100%);
}

.kpi-card.card-green {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.kpi-card.card-orange {
  background: linear-gradient(135deg, #f57c00 0%, #e65100 100%);
}

/* Large Watermark Icon in Top-Right */
.kpi-card .bg-icon {
  position: absolute;
  right: 15px;
  top: 15px;
  font-size: 70px;
  opacity: 0.15;
  pointer-events: none;
  transition: transform 0.2s ease;
}
.kpi-card:hover .bg-icon {
  transform: scale(1.06);
}

/* Metric Values */
.kpi-card .card-value {
  font-size: 1.95rem;
  font-weight: 800;
  line-height: 1.2;
  letter-spacing: -0.5px;
  margin-bottom: 6px;
}

/* Primary Metric Titles */
.kpi-card .card-title {
  font-size: 0.75rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  opacity: 0.9;
  margin-bottom: 12px;
}

/* Bottom Sub-text / Details Line */
.kpi-card .card-subtitle {
  font-size: 0.82rem;
  font-weight: 500;
  opacity: 0.95;
  display: flex;
  align-items: center;
  gap: 6px;
}

.kpi-card .card-subtitle i {
  font-size: 0.85rem;
}

/* Tab Navigation */
.admin-nav-tabs {
    background: #ffffff;
    padding: 8px 16px 0 16px;
    border-radius: 10px 10px 0 0;
    border-bottom: 2px solid #00a896;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.admin-nav-tabs > li > a {
    font-weight: 700;
    color: #64748b;
    border-radius: 8px 8px 0 0;
    padding: 11px 20px;
    font-size: 13.5px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1px solid transparent;
    border-bottom: none;
    transition: all 0.15s ease;
}
.admin-nav-tabs > li > a:hover {
    color: #043d5b;
    background: #f8fafc;
}
.admin-nav-tabs > li.active > a, 
.admin-nav-tabs > li.active > a:focus, 
.admin-nav-tabs > li.active > a:hover {
    background: #00a896;
    color: #ffffff !important;
    border-color: #00a896;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.25);
}

/* Revenue Card Container */
.revenue-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    padding: 24px;
    margin-bottom: 24px;
}
.revenue-card-hdr {
    font-size: 17px;
    font-weight: 800;
    color: #043d5b;
    margin: 0 0 18px 0;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

/* Filter Strip Card */
.filter-strip-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px 18px;
    margin-bottom: 22px;
}
.filter-flex {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: flex-end;
}
.filter-field {
    flex: 1 1 150px;
}
.filter-field label {
    font-size: 11.5px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 5px;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.filter-field .form-control {
    height: 38px;
    font-size: 13px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    color: #0f172a;
    background: #ffffff;
    box-shadow: none;
    transition: border-color 0.15s ease;
}
.filter-field .form-control:focus {
    border-color: #00a896;
}

/* Data Table Design */
.cstm-txn-tbl {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}
.cstm-txn-tbl thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 13px 12px;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
}
.cstm-txn-tbl tbody td {
    padding: 13px 12px;
    font-size: 13px;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.cstm-txn-tbl tbody tr {
    transition: background 0.15s ease;
}
.cstm-txn-tbl tbody tr:hover {
    background: #f8fafc;
}

/* Badges & Status */
.badge-override {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
    font-size: 10.5px;
    padding: 2px 7px;
    border-radius: 4px;
    font-weight: 700;
    display: inline-block;
    margin-top: 3px;
}
.badge-default-rate {
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #e2e8f0;
    font-size: 10.5px;
    padding: 2px 7px;
    border-radius: 4px;
    display: inline-block;
    margin-top: 3px;
    font-weight: 600;
}

.status-badge-settled {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.status-badge-queued {
    background: #e0f2fe;
    color: #0369a1;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.status-badge-pending {
    background: #fef3c7;
    color: #b45309;
    font-weight: 700;
    font-size: 11.5px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Action Buttons */
.btn-action-settle {
    background: #10b981;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 11.5px;
    padding: 5px 12px;
    border-radius: 6px;
    text-decoration: none !important;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 1px 4px rgba(16, 185, 129, 0.2);
    transition: all 0.15s ease;
}
.btn-action-settle:hover { 
    background: #059669; 
    transform: translateY(-1px);
}

.btn-action-queue {
    background: #0284c7;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 11.5px;
    padding: 5px 10px;
    border-radius: 6px;
    text-decoration: none !important;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
}
.btn-action-queue:hover { 
    background: #0369a1; 
    transform: translateY(-1px);
}

.btn-action-view {
    background: #ffffff;
    color: #334155 !important;
    font-weight: 700;
    font-size: 11.5px;
    padding: 5px 10px;
    border-radius: 6px;
    text-decoration: none !important;
    border: 1px solid #cbd5e1;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-action-view:hover { 
    background: #f1f5f9; 
    border-color: #94a3b8;
}

/* Modern Pagination Bar */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}
.pagination-wrapper .pagination {
    margin: 0;
    display: flex;
    gap: 4px;
    list-style: none;
    padding: 0;
}
.pagination-wrapper .pagination > li > a,
.pagination-wrapper .pagination > li > span {
    color: #475569;
    font-weight: 700;
    font-size: 12.5px;
    border-radius: 8px !important;
    border: 1px solid #cbd5e1;
    padding: 7px 14px;
    text-decoration: none;
    transition: all 0.15s ease;
    display: inline-block;
    background: #ffffff;
}
.pagination-wrapper .pagination > li.active > a,
.pagination-wrapper .pagination > li.active > span {
    background-color: #00a896 !important;
    border-color: #00a896 !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(0, 168, 150, 0.35);
}
.pagination-wrapper .pagination > li > a:hover {
    background-color: #f1f5f9;
    border-color: #94a3b8;
    color: #043d5b;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding: 20px 20px 10px;">
        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">
            <i class="fa fa-line-chart" style="color: #00a896; margin-right: 6px;"></i> Platform Revenue &amp; Commission Management
            <small style="font-size: 13px; color: #64748b; margin-left: 8px;">Upchar Super Admin &amp; Acquisition Console</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('masters/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Revenue &amp; Commissions</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding: 10px 20px;">
        <div class="revenue-dash-wrap">

            <!-- Flash Messages -->
            <?php if($this->session->flashdata('flashmsg')): ?>
                <?=$this->session->flashdata('flashmsg');?>
            <?php endif; ?>

            <!-- Real-Time Top Dynamic KPI Metric Cards (Grid Layout) -->
            <div class="kpi-grid">
                
                <!-- Card 1: Gross Platform Volume -->
                <div class="kpi-card card-dark-blue" onclick="openKpiModal('gross')" title="Click to view Gross Volume Category Breakdown">
                    <i class="fa fa-money bg-icon"></i>
                    <div>
                        <div class="card-value">₹<?=number_format($metrics->gross_platform_volume ?? 0, 2);?></div>
                        <div class="card-title">Gross Platform Volume</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="card-subtitle">
                            <i class="fa fa-user-md"></i>
                            <span><?=$metrics->total_txns ?? 0;?> Clinical Encounters</span>
                        </div>
                        <div class="card-click-hint"><i class="fa fa-pie-chart"></i> Breakdown</div>
                    </div>
                </div>

                <!-- Card 2: Upchar Platform Fees -->
                <div class="kpi-card card-teal" onclick="openKpiModal('fees')" title="Click to view Platform Commission Analysis">
                    <i class="fa fa-percent bg-icon"></i>
                    <div>
                        <div class="card-value">₹<?=number_format($metrics->total_platform_fee_earned ?? 0, 2);?></div>
                        <div class="card-title">Upchar Platform Fees</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="card-subtitle">
                            <i class="fa fa-calendar"></i>
                            <span>Dynamic Rate Commissions</span>
                        </div>
                        <div class="card-click-hint"><i class="fa fa-bar-chart"></i> Analysis</div>
                    </div>
                </div>

                <!-- Card 3: GST Collected -->
                <div class="kpi-card card-green" onclick="openKpiModal('gst')" title="Click to view GST 18% Tax Ledger">
                    <i class="fa fa-shield bg-icon"></i>
                    <div>
                        <div class="card-value">₹<?=number_format($metrics->total_gst_collected ?? 0, 2);?></div>
                        <div class="card-title">GST Collected (18%)</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="card-subtitle">
                            <span>CGST: ₹<?=number_format($metrics->total_cgst ?? 0, 2);?> | SGST: ₹<?=number_format($metrics->total_sgst ?? 0, 2);?></span>
                        </div>
                        <div class="card-click-hint"><i class="fa fa-shield"></i> Tax Details</div>
                    </div>
                </div>

                <!-- Card 4: Pending Settlements -->
                <div class="kpi-card card-orange" onclick="openKpiModal('payouts')" title="Click to view Settlement Pipeline">
                    <i class="fa fa-clock-o bg-icon"></i>
                    <div>
                        <div class="card-value">₹<?=number_format($metrics->total_payouts_pending ?? 0, 2);?></div>
                        <div class="card-title">Pending Settlements</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="card-subtitle">
                            <i class="fa fa-bank"></i>
                            <span>Queued + Pending Facility Payouts</span>
                        </div>
                        <div class="card-click-hint"><i class="fa fa-hourglass-half"></i> Pipeline</div>
                    </div>
                </div>

            </div>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs admin-nav-tabs">
                <li class="<?=($active_tab === 'transactions' ? 'active' : '');?>">
                    <a href="#tab_transactions" data-toggle="tab">
                        <i class="fa fa-exchange"></i> Platform Transactions &amp; Settlements
                    </a>
                </li>
                <li class="<?=($active_tab === 'commissions' ? 'active' : '');?>">
                    <a href="#tab_commissions" data-toggle="tab">
                        <i class="fa fa-percent"></i> Commission Overrides &amp; Rates
                    </a>
                </li>
                <li class="<?=($active_tab === 'invoices' ? 'active' : '');?>">
                    <a href="#tab_invoices" data-toggle="tab">
                        <i class="fa fa-file-text-o"></i> Monthly GST Invoices
                    </a>
                </li>
                <li class="<?=($active_tab === 'settings' ? 'active' : '');?>">
                    <a href="#tab_settings" data-toggle="tab">
                        <i class="fa fa-cog"></i> Global Platform &amp; GST Settings
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                <!-- TAB 1: TRANSACTIONS & SETTLEMENTS -->
                <div class="tab-pane <?=($active_tab === 'transactions' ? 'active' : '');?>" id="tab_transactions">
                    <div class="revenue-card">
                        
                        <!-- Header & Export Action -->
                        <div class="revenue-card-hdr">
                            <div>
                                <span><i class="fa fa-list-alt" style="color: #00a896; margin-right: 6px;"></i> Platform Clinical Encounters &amp; Settlement Ledger</span>
                                <small style="display: block; font-size: 12.5px; color: #64748b; font-weight: 500; margin-top: 3px;">
                                    Track gross patient billing, applied Upchar platform rates, itemized 18% GST, and net hospital bank payouts.
                                </small>
                            </div>
                            <div>
                                <?php
                                $exportQuery = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
                                ?>
                                <a href="<?=base_url('admin_revenue/export_transactions'.$exportQuery);?>" class="btn btn-sm btn-success" style="background: #10b981; border-color: #10b981; font-weight: 700; padding: 7px 16px; border-radius: 8px; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.25);">
                                    <i class="fa fa-file-excel-o"></i> Export to CSV / Excel
                                </a>
                            </div>
                        </div>

                        <!-- Multi-Criteria Dynamic Filter Strip -->
                        <div class="filter-strip-card">
                            <form action="<?=base_url('admin_revenue');?>" method="GET">
                                <input type="hidden" name="tab" value="transactions">
                                <div class="filter-flex">
                                    
                                    <div class="filter-field" style="flex: 2 1 200px;">
                                        <label>Search Keyword</label>
                                        <input type="text" name="search" class="form-control" placeholder="Txn Ref, Patient Name, Mobile, Facility..." value="<?=html_escape($filters['search']);?>">
                                    </div>

                                    <div class="filter-field">
                                        <label>Facility Type</label>
                                        <select name="facility_type" class="form-control">
                                            <option value="all">All Facility Types</option>
                                            <option value="hospital" <?=($filters['facility_type'] === 'hospital' ? 'selected' : '');?>>Hospital</option>
                                            <option value="clinic" <?=($filters['facility_type'] === 'clinic' ? 'selected' : '');?>>Clinic</option>
                                            <option value="pathology" <?=($filters['facility_type'] === 'pathology' ? 'selected' : '');?>>Pathology Lab</option>
                                        </select>
                                    </div>

                                    <div class="filter-field">
                                        <label>Payout Status</label>
                                        <select name="payout_status" class="form-control">
                                            <option value="all">All Payout Statuses</option>
                                            <option value="settled" <?=($filters['payout_status'] === 'settled' ? 'selected' : '');?>>Settled / Transferred</option>
                                            <option value="queued" <?=($filters['payout_status'] === 'queued' ? 'selected' : '');?>>Queued for Batch</option>
                                            <option value="pending" <?=($filters['payout_status'] === 'pending' ? 'selected' : '');?>>Pending Settlement</option>
                                        </select>
                                    </div>

                                    <div class="filter-field">
                                        <label>Date From</label>
                                        <input type="date" name="date_from" class="form-control" value="<?=$filters['date_from'];?>">
                                    </div>

                                    <div class="filter-field">
                                        <label>Date To</label>
                                        <input type="date" name="date_to" class="form-control" value="<?=$filters['date_to'];?>">
                                    </div>

                                    <div class="filter-field" style="flex: 0 0 110px;">
                                        <label>Per Page</label>
                                        <select name="pagesize" class="form-control" onchange="this.form.submit()">
                                            <option value="10" <?=($limit == 10 ? 'selected' : '');?>>10 / page</option>
                                            <option value="15" <?=($limit == 15 ? 'selected' : '');?>>15 / page</option>
                                            <option value="25" <?=($limit == 25 ? 'selected' : '');?>>25 / page</option>
                                            <option value="50" <?=($limit == 50 ? 'selected' : '');?>>50 / page</option>
                                            <option value="100" <?=($limit == 100 ? 'selected' : '');?>>100 / page</option>
                                        </select>
                                    </div>

                                    <div class="filter-field" style="flex: 0 0 160px; display: flex; gap: 6px;">
                                        <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; height: 38px; width: 100%; border-radius: 8px;">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                        <a href="<?=base_url('admin_revenue?tab=transactions');?>" class="btn btn-default" style="height: 38px; border-radius: 8px;" title="Reset Filters">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Granular Transactions Table -->
                        <div class="table-responsive">
                            <table class="table cstm-txn-tbl">
                                <thead>
                                    <tr>
                                        <th>Date &amp; Time</th>
                                        <th>Txn Ref / Encounter</th>
                                        <th>Patient Details</th>
                                        <th>Facility Details</th>
                                        <th style="text-align: right;">Gross Vol (₹)</th>
                                        <th style="text-align: center;">Commission Rate</th>
                                        <th style="text-align: right;">Upchar Share (₹)</th>
                                        <th style="text-align: right;">GST (18%)</th>
                                        <th style="text-align: right;">Net Payout (₹)</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($recent_txns)): ?>
                                        <?php foreach($recent_txns as $t): ?>
                                            <tr>
                                                <!-- Date & Time -->
                                                <td style="white-space: nowrap;">
                                                    <strong style="color: #0f172a; font-size: 13px;"><?=date('d M Y', strtotime($t->created_at));?></strong>
                                                    <small style="display: block; color: #64748b; font-size: 11px;"><?=date('h:i A', strtotime($t->created_at));?></small>
                                                </td>

                                                <!-- Txn Ref / Encounter -->
                                                <td>
                                                    <strong style="color: #043d5b; font-family: monospace; font-size: 13px;"><?=$t->txn_code;?></strong>
                                                    <span class="label label-default" style="display: block; font-size: 10.5px; margin-top: 3px; text-align: left; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                                                        #ENC-<?=$t->encounter_id;?> &bull; <?=$t->category;?>
                                                    </span>
                                                </td>

                                                <!-- Patient Details -->
                                                <td>
                                                    <div style="font-weight: 700; color: #0f172a;"><?=$t->patient_name;?></div>
                                                    <small style="color: #64748b; font-size: 11.5px;">
                                                        #P-<?=$t->patient_id;?> &bull; <?=($t->patient_mobile ?: 'N/A');?>
                                                    </small>
                                                </td>

                                                <!-- Facility Details -->
                                                <td>
                                                    <div style="font-weight: 600; color: #1e293b;"><?=$t->facility_name ?: (ucfirst($t->facility_type).' #'.$t->facility_id);?></div>
                                                    <span class="label label-info" style="font-size: 10.5px; background-color: #e0f2fe !important; color: #0284c7 !important; border: 1px solid #bae6fd; font-weight: 700;">
                                                        <?=strtoupper($t->facility_type);?> #<?=$t->facility_id;?>
                                                    </span>
                                                </td>

                                                <!-- Gross Volume -->
                                                <td style="text-align: right; font-weight: 800; color: #0f172a; font-size: 14px;">
                                                    ₹<?=number_format($t->gross_amount, 2);?>
                                                </td>

                                                <!-- Commission Rate -->
                                                <td style="text-align: center;">
                                                    <span style="font-weight: 800; color: #00a896; font-size: 13.5px;"><?=$t->platform_fee_percent;?>%</span>
                                                    <div>
                                                        <?php if($t->is_custom_rate): ?>
                                                            <span class="badge-override"><i class="fa fa-tag"></i> Custom MOU</span>
                                                        <?php else: ?>
                                                            <span class="badge-default-rate">Default</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>

                                                <!-- Upchar Share -->
                                                <td style="text-align: right; font-weight: 700; color: #00a896;">
                                                    ₹<?=number_format($t->platform_fee_amount, 2);?>
                                                </td>

                                                <!-- GST Breakdown -->
                                                <td style="text-align: right; color: #64748b;">
                                                    <strong style="color: #334155;">₹<?=number_format($t->gst_amount, 2);?></strong>
                                                    <small style="display: block; font-size: 10px; color: #94a3b8;">
                                                        C:₹<?=number_format($t->cgst_amount, 2);?> S:₹<?=number_format($t->sgst_amount, 2);?>
                                                    </small>
                                                </td>

                                                <!-- Net Facility Payout -->
                                                <td style="text-align: right; font-weight: 800; color: #10b981; font-size: 14.5px;">
                                                    ₹<?=number_format($t->net_facility_share, 2);?>
                                                </td>

                                                <!-- Status -->
                                                <td style="text-align: center; white-space: nowrap;">
                                                    <?php if($t->payout_status === 'settled' || $t->payout_status === 'processed'): ?>
                                                        <span class="status-badge-settled">
                                                            <i class="fa fa-check-circle"></i> SETTLED
                                                        </span>
                                                    <?php elseif($t->payout_status === 'queued'): ?>
                                                        <span class="status-badge-queued">
                                                            <i class="fa fa-clock-o"></i> QUEUED
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="status-badge-pending">
                                                            <i class="fa fa-hourglass-half"></i> PENDING
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- Actions -->
                                                <td style="text-align: center; white-space: nowrap;">
                                                    <div style="display: inline-flex; gap: 4px; align-items: center;">
                                                        
                                                        <?php if($t->payout_status !== 'settled' && $t->payout_status !== 'processed'): ?>
                                                            <a href="<?=base_url('admin_revenue/settle_payout/'.$t->txn_id);?>" class="btn-action-settle" onclick="return confirm('Initiate & settle payout of ₹<?=number_format($t->net_facility_share, 2);?> to <?=html_escape($t->facility_name);?>?');" title="Transfer Payout">
                                                                <i class="fa fa-check"></i> Settle
                                                            </a>
                                                            <?php if($t->payout_status !== 'queued'): ?>
                                                                <a href="<?=base_url('admin_revenue/queue_payout/'.$t->txn_id);?>" class="btn-action-queue" title="Queue for Next Batch">
                                                                    <i class="fa fa-clock-o"></i> Queue
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <button type="button" class="btn-action-view" onclick="openTxnDetailsModal(<?=$t->txn_id;?>)" title="View Full Breakdown">
                                                            <i class="fa fa-eye"></i> Details
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="11" style="text-align: center; padding: 45px 20px; color: #94a3b8;">
                                                <i class="fa fa-search fa-3x" style="margin-bottom: 12px; display: block; opacity: 0.4;"></i>
                                                <p style="font-size: 14px; margin: 0; font-weight: 500;">No transactions found matching the selected filter criteria.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer Bar -->
                        <div class="pagination-wrapper">
                            <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                                <?php if($total_txns_count > 0): ?>
                                    Showing <strong style="color: #0f172a;"><?=min($offset + 1, $total_txns_count);?></strong> to <strong style="color: #0f172a;"><?=min($offset + count($recent_txns), $total_txns_count);?></strong> of <strong style="color: #0f172a;"><?=$total_txns_count;?></strong> records
                                <?php else: ?>
                                    Showing 0 records
                                <?php endif; ?>
                            </div>
                            <div>
                                <?php if(!empty($page_links)): ?>
                                    <?=$page_links;?>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- TAB 2: COMMISSION OVERRIDES (ACQUISITION TOOL) -->
                <div class="tab-pane <?=($active_tab === 'commissions' ? 'active' : '');?>" id="tab_commissions">
                    <div class="row">
                        <!-- Left: Add/Edit Override -->
                        <div class="col-md-5">
                            <div class="revenue-card">
                                <div class="revenue-card-hdr">
                                    <span><i class="fa fa-edit" style="color: #00a896; margin-right: 6px;"></i> Configure Facility Commission Override</span>
                                </div>
                                <p style="font-size: 13px; color: #64748b; margin-bottom: 18px; line-height: 1.5;">
                                    Acquisition team tool: Override default platform fees for specific partner hospitals, clinics, or pathology labs with custom contracted rates.
                                </p>

                                <?php echo form_open("admin_revenue/set_custom_commission");?>
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                    
                                    <div class="form-group">
                                        <label style="font-weight: 700; font-size: 12.5px;">Facility Type</label>
                                        <select name="facility_type" id="facTypeSelect" class="form-control" onchange="updateFacilityDropdown()" style="height: 38px; border-radius: 8px;">
                                            <option value="hospital">Hospital</option>
                                            <option value="clinic">Clinic</option>
                                            <option value="pathology">Pathology Center</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="font-weight: 700; font-size: 12.5px;">Select Facility</label>
                                        <select name="facility_id" id="facIdSelect" class="form-control" required style="height: 38px; border-radius: 8px;">
                                            <?php foreach($hospitals as $h): ?>
                                                <option value="<?=$h->id;?>"><?=$h->name;?> (#<?=$h->id;?><?=($h->city ? ' - '.$h->city : '');?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="font-weight: 700; font-size: 12.5px;">Custom Platform Fee Rate (%)</label>
                                        <input type="number" step="0.01" name="platform_fee_percent" class="form-control" placeholder="e.g. 7.50" value="10.00" required style="height: 38px; border-radius: 8px;">
                                        <small style="color: #64748b; font-size: 11.5px; margin-top: 3px; display: block;">Applied to all patient encounter bills generated at this facility.</small>
                                    </div>

                                    <div class="form-group">
                                        <label style="font-weight: 700; font-size: 12.5px;">Contract MOU / Acquisition Notes</label>
                                        <input type="text" name="notes" class="form-control" placeholder="e.g. Q3 High Volume Partnership MOU" style="height: 38px; border-radius: 8px;">
                                    </div>

                                    <div class="form-group" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; margin-bottom: 15px;">
                                        <label style="font-weight: 600; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 8px; margin: 0;">
                                            <input type="checkbox" name="recalculate_facility" value="1" checked style="margin: 0; width: 16px; height: 16px;">
                                            <span>Recalculate valuations on this facility's transactions</span>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; width: 100%; height: 40px; border-radius: 8px; margin-top: 4px; box-shadow: 0 2px 8px rgba(0, 168, 150, 0.3);">
                                        <i class="fa fa-save"></i> Save Commission Override
                                    </button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <!-- Right: Active Overrides Table -->
                        <div class="col-md-7">
                            <div class="revenue-card">
                                <div class="revenue-card-hdr">
                                    <span><i class="fa fa-list" style="color: #00a896; margin-right: 6px;"></i> Active Contracted Commission Overrides</span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" style="margin-bottom: 0;">
                                        <thead>
                                            <tr style="background: #f8fafc;">
                                                <th>Facility Type</th>
                                                <th>Facility ID</th>
                                                <th style="text-align: right;">Custom Rate %</th>
                                                <th>MOU Notes</th>
                                                <th>Updated Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($custom_commissions)): ?>
                                                <?php foreach($custom_commissions as $cc): ?>
                                                    <tr>
                                                        <td><span class="label label-info" style="font-weight: 700;"><?=strtoupper($cc->facility_type);?></span></td>
                                                        <td><strong>#<?=$cc->facility_id;?></strong></td>
                                                        <td style="text-align: right; font-weight: 800; color: #00a896; font-size: 14px;"><?=$cc->platform_fee_percent;?>%</td>
                                                        <td><?=($cc->notes ?: 'Contract Override');?></td>
                                                        <td style="font-size: 12px; color: #64748b;"><?=date('d M Y', strtotime($cc->updated_at));?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center" style="padding: 30px 20px; color: #94a3b8;">
                                                        No custom overrides. All facilities currently use global default <?=number_format($settings->default_platform_fee_percent, 2);?>% rate.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: MONTHLY GST INVOICES -->
                <div class="tab-pane <?=($active_tab === 'invoices' ? 'active' : '');?>" id="tab_invoices">
                    <div class="revenue-card">
                        <div class="revenue-card-hdr">
                            <span><i class="fa fa-file-text-o" style="color: #00a896; margin-right: 6px;"></i> Facility Monthly GST Invoices (SAC 998313)</span>
                            <div>
                                <?php echo form_open("admin_revenue/generate_invoice", 'style="display: inline-flex; gap: 8px; flex-wrap: wrap; align-items: center;"');?>
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                    <select name="facility_type" id="invFacTypeSelect" onchange="updateInvoiceFacilityDropdown()" class="form-control" style="width: 130px; height: 36px; border-radius: 6px;">
                                        <option value="hospital">Hospital</option>
                                        <option value="clinic">Clinic</option>
                                        <option value="pathology">Pathology</option>
                                    </select>
                                    <select name="facility_id" id="invFacIdSelect" class="form-control" style="min-width: 220px; max-width: 320px; height: 36px; border-radius: 6px;" required>
                                        <?php if(!empty($hospitals)): ?>
                                            <?php foreach($hospitals as $h): ?>
                                                <option value="<?=$h->id;?>"><?=$h->name;?> (#<?=$h->id;?><?=($h->city ? ' - '.$h->city : '');?>)</option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <input type="month" name="billing_month" class="form-control" value="<?=date('Y-m');?>" style="width: 150px; height: 36px; border-radius: 6px;">
                                    <button type="submit" class="btn btn-sm btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; height: 36px; border-radius: 6px; padding: 0 16px;">
                                        <i class="fa fa-plus-circle"></i> Generate Tax Invoice
                                    </button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="margin-bottom: 0;">
                                <thead>
                                    <tr style="background: #f8fafc;">
                                        <th>Invoice Number</th>
                                        <th>Facility Details</th>
                                        <th>Billing Month</th>
                                        <th style="text-align: right;">Taxable Platform Fee</th>
                                        <th style="text-align: right;">CGST (9%)</th>
                                        <th style="text-align: right;">SGST (9%)</th>
                                        <th style="text-align: right;">Total Invoice Amount</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($invoices)): ?>
                                        <?php foreach($invoices as $inv): ?>
                                            <tr>
                                                <td><strong style="color: #043d5b;"><?=$inv->invoice_number;?></strong></td>
                                                <td><strong><?=$inv->facility_name;?></strong> (#<?=$inv->facility_id;?>)</td>
                                                <td><span class="badge" style="background: #f1f5f9; color: #334155; font-weight: 700;"><?=date('F Y', strtotime($inv->billing_month . '-01'));?></span></td>
                                                <td style="text-align: right; font-weight: 600;">₹<?=number_format($inv->total_taxable_value, 2);?></td>
                                                <td style="text-align: right; color: #64748b;">₹<?=number_format($inv->cgst_amount, 2);?></td>
                                                <td style="text-align: right; color: #64748b;">₹<?=number_format($inv->sgst_amount, 2);?></td>
                                                <td style="text-align: right; font-weight: 800; color: #043d5b; font-size: 14px;">₹<?=number_format($inv->total_invoice_amount, 2);?></td>
                                                <td style="text-align: center;">
                                                    <a href="<?=base_url('admin_revenue/invoice_view/'.$inv->invoice_id);?>" target="_blank" class="btn btn-xs btn-default" style="background: #043d5b; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 5px 12px;">
                                                        <i class="fa fa-eye"></i> View / Print Invoice
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center" style="padding: 30px 20px; color: #94a3b8;">No invoices generated yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: GLOBAL SETTINGS & VALUATION RECALCULATION ENGINE -->
                <div class="tab-pane <?=($active_tab === 'settings' ? 'active' : '');?>" id="tab_settings">
                    <div class="row">
                        <!-- Left: Settings Form -->
                        <div class="col-md-6">
                            <div class="revenue-card">
                                <div class="revenue-card-hdr">
                                    <span><i class="fa fa-sliders" style="color: #00a896; margin-right: 6px;"></i> Global Platform Fee &amp; GST Configuration</span>
                                </div>

                                <?php echo form_open("admin_revenue/update_settings");?>
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                                    <div class="form-group">
                                        <label style="font-weight: 700; font-size: 13px;">Default Global Platform Fee (%)</label>
                                        <input type="number" step="0.01" name="default_platform_fee_percent" id="inputFeePercent" class="form-control" value="<?=$settings->default_platform_fee_percent;?>" required style="height: 38px; border-radius: 8px;" oninput="updateLiveCalcPreview()">
                                        <small style="color: #64748b; font-size: 12px; margin-top: 3px; display: block;">Applied when no custom facility override is specified.</small>
                                    </div>

                                    <div class="form-group">
                                        <label style="font-weight: 700; font-size: 13px;">GST Percentage (%)</label>
                                        <input type="number" step="0.01" name="gst_percent" id="inputGstPercent" class="form-control" value="<?=$settings->gst_percent;?>" required style="height: 38px; border-radius: 8px;" oninput="updateLiveCalcPreview()">
                                        <small style="color: #64748b; font-size: 12px; margin-top: 3px; display: block;" id="gstSplitHint">
                                            Split into <?=number_format($settings->gst_percent/2, 2);?>% CGST and <?=number_format($settings->gst_percent/2, 2);?>% SGST on platform brokerage fees.
                                        </small>
                                    </div>

                                    <div class="form-group">
                                        <label style="font-weight: 700; font-size: 13px;">Upchar Registered GSTIN</label>
                                        <input type="text" name="upchar_gstin" class="form-control" value="<?=$settings->upchar_gstin;?>" required style="height: 38px; border-radius: 8px;">
                                    </div>

                                    <!-- Recalculation Option -->
                                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px; margin-bottom: 18px;">
                                        <div style="font-weight: 700; font-size: 12.5px; color: #166534; margin-bottom: 6px;">
                                            <i class="fa fa-refresh"></i> Automated Valuation Recalculation
                                        </div>
                                        <p style="font-size: 12px; color: #15803d; margin-bottom: 8px;">
                                            When updating tax or fee percentages, choose which records to recompute:
                                        </p>
                                        <div style="display: flex; flex-direction: column; gap: 6px; font-size: 12.5px; color: #1e293b;">
                                            <label style="font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; margin: 0;">
                                                <input type="radio" name="auto_recalculate" value="all" checked>
                                                <span>Recalculate <strong>ALL</strong> past and pending transactions immediately</span>
                                            </label>
                                            <label style="font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; margin: 0;">
                                                <input type="radio" name="auto_recalculate" value="pending">
                                                <span>Recalculate <strong>PENDING &amp; QUEUED</strong> settlements only</span>
                                            </label>
                                            <label style="font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px; margin: 0; color: #64748b;">
                                                <input type="radio" name="auto_recalculate" value="none">
                                                <span>Do not recalculate past records (apply only to new encounters)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; height: 42px; border-radius: 8px; padding: 0 24px; box-shadow: 0 2px 8px rgba(0, 168, 150, 0.3); width: 100%;">
                                        <i class="fa fa-save"></i> Save Settings &amp; Recompute Valuations
                                    </button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <!-- Right: Live Valuation Math Simulator & Engine -->
                        <div class="col-md-6">
                            <!-- Live Math Preview Card -->
                            <div class="revenue-card" style="border-top: 3px solid #00a896;">
                                <div class="revenue-card-hdr">
                                    <span><i class="fa fa-calculator" style="color: #00a896; margin-right: 6px;"></i> Live Valuation Simulator</span>
                                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700;">Real-Time Preview</span>
                                </div>
                                <p style="font-size: 12.5px; color: #64748b; margin-bottom: 12px;">
                                    Shows the exact dynamic double-entry breakdown on a sample patient clinical bill:
                                </p>

                                <div class="form-group" style="margin-bottom: 14px;">
                                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Sample Patient Bill (₹)</label>
                                    <input type="number" id="simSampleBill" class="form-control" value="10000" style="height: 36px; border-radius: 6px;" oninput="updateLiveCalcPreview()">
                                </div>

                                <table class="table table-bordered sim-val-table" style="font-size: 13.5px; margin-bottom: 0; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden;">
                                    <tr style="background: #f1f5f9; border-bottom: 2px solid #cbd5e1;">
                                        <td style="color: #0f172a; font-weight: 700; padding: 12px 14px;">Gross Patient Bill:</td>
                                        <td style="text-align: right; font-weight: 800; font-size: 15px; color: #0f172a; padding: 12px 14px;" id="simGross">₹10,000.00</td>
                                    </tr>
                                    <tr style="background: #ffffff; border-bottom: 1px solid #e2e8f0;">
                                        <td style="color: #1e293b; font-weight: 600; padding: 10px 14px;">Upchar Platform Commission (<span id="simFeeRate" style="font-weight: 700; color: #0d9488;"><?=$settings->default_platform_fee_percent;?></span>%):</td>
                                        <td style="text-align: right; font-weight: 700; color: #0d9488; font-size: 14px; padding: 10px 14px;" id="simFee">₹1,000.00</td>
                                    </tr>
                                    <tr style="background: #ffffff; border-bottom: 1px solid #e2e8f0;">
                                        <td style="color: #334155; padding: 9px 14px;">Central GST (CGST @ <span id="simCgstRate" style="font-weight: 600; color: #0f172a;"><?=number_format($settings->gst_percent/2, 2);?></span>%):</td>
                                        <td style="text-align: right; color: #1e293b; font-weight: 600; padding: 9px 14px;" id="simCgst">₹90.00</td>
                                    </tr>
                                    <tr style="background: #ffffff; border-bottom: 1px solid #e2e8f0;">
                                        <td style="color: #334155; padding: 9px 14px;">State GST (SGST @ <span id="simSgstRate" style="font-weight: 600; color: #0f172a;"><?=number_format($settings->gst_percent/2, 2);?></span>%):</td>
                                        <td style="text-align: right; color: #1e293b; font-weight: 600; padding: 9px 14px;" id="simSgst">₹90.00</td>
                                    </tr>
                                    <tr style="background: #fee2e2; border-bottom: 2px solid #fca5a5;">
                                        <td style="font-weight: 700; color: #991b1b; padding: 11px 14px;">Total Platform Deductions:</td>
                                        <td style="text-align: right; font-weight: 800; color: #b91c1c; font-size: 14.5px; padding: 11px 14px;" id="simDeduction">-₹1,180.00</td>
                                    </tr>
                                    <tr style="background: #dcfce7;">
                                        <td style="font-weight: 800; color: #166534; font-size: 14px; padding: 12px 14px;">Net Hospital Bank Payout:</td>
                                        <td style="text-align: right; font-weight: 800; color: #15803d; font-size: 16px; padding: 12px 14px;" id="simPayout">₹8,820.00</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Manual One-Click Recalculation Engine -->
                            <div class="revenue-card" style="border-top: 3px solid #f59e0b;">
                                <div class="revenue-card-hdr">
                                    <span><i class="fa fa-bolt" style="color: #f59e0b; margin-right: 6px;"></i> One-Click Database Recalculation Engine</span>
                                </div>
                                <p style="font-size: 12.5px; color: #64748b; margin-bottom: 14px;">
                                    Manually recompute every existing transaction and active ledger row against the current active GST (<?=$settings->gst_percent;?>%) and platform fee structure.
                                </p>

                                <?php echo form_open("admin_revenue/recalculate_valuations");?>
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                    <div style="display: flex; gap: 10px; align-items: center;">
                                        <select name="scope" class="form-control" style="height: 38px; border-radius: 6px;">
                                            <option value="all">Recalculate ALL Encounters</option>
                                            <option value="pending">Recalculate PENDING Encounters Only</option>
                                        </select>
                                        <button type="submit" class="btn btn-warning" onclick="return confirm('Recalculate valuations and tax splits across all selected transactions?');" style="background: #f59e0b; border-color: #f59e0b; color: #ffffff; font-weight: 700; height: 38px; border-radius: 6px; white-space: nowrap; padding: 0 16px;">
                                            <i class="fa fa-refresh"></i> Recalculate Now
                                        </button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="txnDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 560px; margin-top: 60px;">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.18);">
            <div class="modal-header" style="background: #043d5b; color: #ffffff; padding: 18px 22px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.85; font-size: 22px;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 16px;"><i class="fa fa-info-circle" style="color: #22d3ee; margin-right: 6px;"></i> Encounter Financial Breakdown</h4>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div id="txnModalBody">
                    <div style="text-align: center; padding: 25px; color: #64748b;">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                        <p style="margin-top: 8px; font-size: 13px;">Loading encounter details...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 22px; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 700; padding: 6px 18px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- KPI Modal 1: Gross Platform Volume Breakdown -->
<div class="modal fade" id="kpiGrossModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 680px; margin-top: 50px;">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #004b6e 0%, #003652 100%); color: #ffffff; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.85; font-size: 22px;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 17px;"><i class="fa fa-money" style="color: #38bdf8; margin-right: 8px;"></i> Gross Platform Volume &amp; Category Breakdown</h4>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; margin-bottom: 20px;">
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Platform Turnover</div>
                        <div style="font-size: 24px; font-weight: 800; color: #004b6e; margin-top: 2px;">₹<?=number_format($metrics->gross_platform_volume ?? 0, 2);?></div>
                    </div>
                    <div style="text-align: right;">
                        <span class="label label-primary" style="font-size: 13px; padding: 6px 12px; border-radius: 20px; font-weight: 700; background-color: #004b6e;">
                            <?=$metrics->total_txns ?? 0;?> Clinical Encounters
                        </span>
                    </div>
                </div>

                <div style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Revenue by Clinical Service Category</div>
                <div class="table-responsive" style="margin-bottom: 0;">
                    <table class="table table-bordered table-striped" style="font-size: 13px; margin-bottom: 0;">
                        <thead>
                            <tr style="background: #f1f5f9;">
                                <th>Clinical Category</th>
                                <th style="text-align: center;">Encounters</th>
                                <th style="text-align: right;">Gross Billed (₹)</th>
                                <th style="text-align: right;">Upchar Fee (₹)</th>
                                <th style="text-align: right;">Net Facility Share (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($category_breakdown)): ?>
                                <?php foreach($category_breakdown as $cb): ?>
                                    <tr>
                                        <td><strong><?=ucwords(str_replace('_', ' ', $cb->category));?></strong></td>
                                        <td style="text-align: center;"><span class="badge" style="background: #e2e8f0; color: #334155; font-weight: 700;"><?=$cb->total_txns;?></span></td>
                                        <td style="text-align: right; font-weight: 700; color: #0f172a;">₹<?=number_format($cb->gross_amount, 2);?></td>
                                        <td style="text-align: right; color: #00a896; font-weight: 600;">₹<?=number_format($cb->fee_amount, 2);?></td>
                                        <td style="text-align: right; font-weight: 700; color: #10b981;">₹<?=number_format($cb->net_share, 2);?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center" style="padding: 20px; color: #94a3b8;">No transactions found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Close</button>
                <a href="<?=base_url('admin_revenue?tab=transactions#tab_transactions');?>" class="btn btn-primary" style="background: #004b6e; border-color: #004b6e; border-radius: 8px; font-weight: 700;">
                    <i class="fa fa-list-alt"></i> View Full Transactions Ledger
                </a>
            </div>
        </div>
    </div>
</div>

<!-- KPI Modal 2: Upchar Platform Fees Analysis -->
<div class="modal fade" id="kpiFeesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 680px; margin-top: 50px;">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #009688 0%, #00796b 100%); color: #ffffff; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.85; font-size: 22px;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 17px;"><i class="fa fa-percent" style="color: #5eead4; margin-right: 8px;"></i> Upchar Platform Brokerage Fees &amp; Commission Analysis</h4>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div class="row" style="margin-bottom: 16px;">
                    <div class="col-sm-6">
                        <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 10px; padding: 14px 16px;">
                            <div style="font-size: 11.5px; font-weight: 700; color: #0d9488; text-transform: uppercase;">Total Tech Brokerage Earned</div>
                            <div style="font-size: 22px; font-weight: 800; color: #0f766e; margin-top: 2px;">₹<?=number_format($metrics->total_platform_fee_earned ?? 0, 2);?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px;">
                            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Global Standard Fee Rate</div>
                            <div style="font-size: 22px; font-weight: 800; color: #334155; margin-top: 2px;">
                                <?=number_format($settings->default_platform_fee_percent, 2);?>%
                                <small style="font-size: 11.5px; color: #64748b; font-weight: 500;">(<?=count($custom_commissions);?> Custom MOUs)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Top Revenue-Generating Healthcare Partners</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="font-size: 13px; margin-bottom: 0;">
                        <thead>
                            <tr style="background: #f1f5f9;">
                                <th>Facility Name</th>
                                <th>Type</th>
                                <th style="text-align: center;">Encounters</th>
                                <th style="text-align: right;">Gross Vol (₹)</th>
                                <th style="text-align: right;">Upchar Share (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($top_facilities)): ?>
                                <?php foreach($top_facilities as $tf): ?>
                                    <tr>
                                        <td><strong><?=$tf->facility_name;?></strong> <small style="color: #64748b;">(#<?=$tf->facility_id;?>)</small></td>
                                        <td><span class="label label-info" style="font-size: 10px; text-transform: uppercase;"><?=strtoupper($tf->facility_type);?></span></td>
                                        <td style="text-align: center;"><?=$tf->total_txns;?></td>
                                        <td style="text-align: right; font-weight: 600;">₹<?=number_format($tf->gross_amount, 2);?></td>
                                        <td style="text-align: right; font-weight: 800; color: #009688;">₹<?=number_format($tf->fee_amount, 2);?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center" style="padding: 16px;">No facility records available.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Close</button>
                <a href="<?=base_url('admin_revenue?tab=commissions#tab_commissions');?>" class="btn btn-primary" style="background: #009688; border-color: #009688; border-radius: 8px; font-weight: 700;">
                    <i class="fa fa-percent"></i> Manage Commission Overrides
                </a>
            </div>
        </div>
    </div>
</div>

<!-- KPI Modal 3: GST Collected 18% Summary -->
<div class="modal fade" id="kpiGstModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 620px; margin-top: 50px;">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.85; font-size: 22px;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 17px;"><i class="fa fa-shield" style="color: #a7f3d0; margin-right: 8px;"></i> GST Collected (18%) &amp; Statutory Tax Compliance</h4>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 16px 20px; margin-bottom: 20px;">
                    <div style="font-size: 12px; font-weight: 700; color: #15803d; text-transform: uppercase;">Total Goods &amp; Services Tax (18%) Collected</div>
                    <div style="font-size: 26px; font-weight: 800; color: #166534; margin-top: 2px;">₹<?=number_format($metrics->total_gst_collected ?? 0, 2);?></div>
                </div>

                <table class="table table-bordered" style="font-size: 13.5px; margin-bottom: 20px;">
                    <tr>
                        <td><strong>Taxable Base Value (Platform Brokerage):</strong></td>
                        <td style="text-align: right; font-weight: 700;">₹<?=number_format($metrics->total_platform_fee_earned ?? 0, 2);?></td>
                    </tr>
                    <tr>
                        <td>Central GST (CGST @ 9.00%):</td>
                        <td style="text-align: right; color: #15803d; font-weight: 700;">₹<?=number_format($metrics->total_cgst ?? 0, 2);?></td>
                    </tr>
                    <tr>
                        <td>State GST (SGST @ 9.00%):</td>
                        <td style="text-align: right; color: #15803d; font-weight: 700;">₹<?=number_format($metrics->total_sgst ?? 0, 2);?></td>
                    </tr>
                    <tr style="background: #f8fafc; font-size: 14px;">
                        <td><strong>Total Statutory Tax Liability:</strong></td>
                        <td style="text-align: right; font-weight: 800; color: #15803d;">₹<?=number_format($metrics->total_gst_collected ?? 0, 2);?></td>
                    </tr>
                </table>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; font-size: 12px; color: #475569;">
                    <div><strong>SAC Service Classification:</strong> 998313 (Information Technology &amp; Healthcare Platform Facilitation)</div>
                    <div style="margin-top: 3px;"><strong>Upchar GSTIN:</strong> <code style="color: #043d5b; font-weight: 700; font-size: 12px;"><?=$settings->upchar_gstin;?></code></div>
                    <div style="margin-top: 4px; font-size: 11px; color: #64748b;">
                        * Note: GST is charged strictly on Upchar's platform facilitation fees. Direct clinical healthcare services provided by doctors and hospitals to patients remain exempt from GST.
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Close</button>
                <a href="<?=base_url('admin_revenue?tab=invoices#tab_invoices');?>" class="btn btn-success" style="background: #10b981; border-color: #10b981; border-radius: 8px; font-weight: 700;">
                    <i class="fa fa-file-text-o"></i> View Monthly GST Invoices
                </a>
            </div>
        </div>
    </div>
</div>

<!-- KPI Modal 4: Pending Settlements & Payout Queue -->
<div class="modal fade" id="kpiPayoutsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 620px; margin-top: 50px;">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f57c00 0%, #e65100 100%); color: #ffffff; padding: 18px 24px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.85; font-size: 22px;">&times;</button>
                <h4 class="modal-title" style="font-weight: 800; font-size: 17px;"><i class="fa fa-clock-o" style="color: #fed7aa; margin-right: 8px;"></i> Facility Settlement &amp; Banking Payout Pipeline</h4>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 16px 20px; margin-bottom: 20px;">
                    <div style="font-size: 12px; font-weight: 700; color: #b45309; text-transform: uppercase;">Total Outstanding Facility Payouts</div>
                    <div style="font-size: 26px; font-weight: 800; color: #9a3412; margin-top: 2px;">₹<?=number_format($metrics->total_payouts_pending ?? 0, 2);?></div>
                </div>

                <table class="table table-bordered" style="font-size: 13.5px; margin-bottom: 20px;">
                    <tr style="background: #f0fdf4;">
                        <td><i class="fa fa-check-circle" style="color: #16a34a; margin-right: 6px;"></i> <strong>Settled &amp; Transferred to Date:</strong></td>
                        <td style="text-align: right; font-weight: 800; color: #16a34a; font-size: 14px;">₹<?=number_format($metrics->total_payouts_settled ?? 0, 2);?></td>
                    </tr>
                    <tr style="background: #e0f2fe;">
                        <td><i class="fa fa-clock-o" style="color: #0284c7; margin-right: 6px;"></i> <strong>Queued for Next Banking Batch:</strong></td>
                        <td style="text-align: right; font-weight: 800; color: #0284c7; font-size: 14px;">₹<?=number_format($metrics->total_payouts_queued ?? 0, 2);?></td>
                    </tr>
                    <tr style="background: #fef3c7;">
                        <td><i class="fa fa-hourglass-half" style="color: #d97706; margin-right: 6px;"></i> <strong>Pending Admin Clearance:</strong></td>
                        <td style="text-align: right; font-weight: 800; color: #d97706; font-size: 14px;">
                            ₹<?=number_format(max(0, ($metrics->total_payouts_pending ?? 0) - ($metrics->total_payouts_queued ?? 0)), 2);?>
                        </td>
                    </tr>
                </table>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; font-size: 12.5px; color: #475569;">
                    <i class="fa fa-info-circle" style="color: #f57c00; margin-right: 4px;"></i>
                    Click below to immediately open the transactions ledger filtered by <strong>Pending Settlements</strong> and authorize banking transfers.
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Close</button>
                <a href="<?=base_url('admin_revenue?tab=transactions&payout_status=pending#tab_transactions');?>" class="btn btn-warning" style="background: #f57c00; border-color: #f57c00; color: #ffffff; border-radius: 8px; font-weight: 700;">
                    <i class="fa fa-bolt"></i> Filter &amp; Process Pending Settlements
                </a>
            </div>
        </div>
    </div>
</div>

<script>
var hospitalList = <?=json_encode($hospitals);?>;
var clinicList   = <?=json_encode($clinics);?>;
var pathlabList  = <?=json_encode($pathlabs);?>;

function updateFacilityDropdown() {
    var type = $('#facTypeSelect').val();
    var list = (type === 'hospital') ? hospitalList : ((type === 'clinic') ? clinicList : pathlabList);
    var options = '';
    list.forEach(function(item) {
        options += '<option value="' + item.id + '">' + item.name + ' (#' + item.id + (item.city ? ' - ' + item.city : '') + ')</option>';
    });
    $('#facIdSelect').html(options);
}

function updateInvoiceFacilityDropdown() {
    var type = $('#invFacTypeSelect').val();
    var list = (type === 'hospital') ? hospitalList : ((type === 'clinic') ? clinicList : pathlabList);
    var options = '';
    list.forEach(function(item) {
        options += '<option value="' + item.id + '">' + item.name + ' (#' + item.id + (item.city ? ' - ' + item.city : '') + ')</option>';
    });
    $('#invFacIdSelect').html(options);
}

function openKpiModal(type) {
    if (type === 'gross') {
        $('#kpiGrossModal').modal('show');
    } else if (type === 'fees') {
        $('#kpiFeesModal').modal('show');
    } else if (type === 'gst') {
        $('#kpiGstModal').modal('show');
    } else if (type === 'payouts') {
        $('#kpiPayoutsModal').modal('show');
    }
}

function openTxnDetailsModal(txnId) {
    $('#txnDetailsModal').modal('show');
    $('#txnModalBody').html('<div style="text-align: center; padding: 25px; color: #64748b;"><i class="fa fa-spinner fa-spin fa-2x"></i><p style="margin-top: 8px; font-size: 13px;">Loading encounter details...</p></div>');

    $.ajax({
        url: '<?=base_url('admin_revenue/transaction_details_ajax/');?>' + txnId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                var d = res.data;
                var f = res.formatted;
                var html = `
                    <div style="display: flex; justify-content: space-between; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
                        <div>
                            <strong style="font-size: 17px; color: #043d5b; font-family: monospace;">${d.txn_code}</strong>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Encounter: #ENC-${d.encounter_id} &bull; <strong>${d.category}</strong></div>
                        </div>
                        <div style="text-align: right;">
                            <span class="label label-info" style="text-transform: uppercase; font-weight: 700;">${d.facility_type} #${d.facility_id}</span>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">${f.date}</div>
                        </div>
                    </div>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; margin-bottom: 18px;">
                        <div style="font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">PATIENT DETAILS</div>
                        <div style="font-weight: 700; font-size: 14.5px; color: #0f172a;">${d.patient_name} <small style="color: #64748b;">(#P-${d.patient_id})</small></div>
                        <div style="font-size: 12px; color: #475569; margin-top: 3px;">
                            <i class="fa fa-phone" style="color: #00a896; margin-right: 4px;"></i> ${d.patient_mobile || 'N/A'} &nbsp;|&nbsp; 
                            <i class="fa fa-envelope-o" style="color: #00a896; margin-right: 4px;"></i> ${d.patient_email || 'N/A'}
                        </div>
                    </div>

                    <table class="table table-bordered" style="font-size: 13.5px; margin-bottom: 18px; border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1; background: #ffffff;">
                        <tr style="background: #f1f5f9; border-bottom: 2px solid #cbd5e1;">
                            <td style="font-weight: 700; color: #0f172a; padding: 10px 14px;">Gross Encounter Bill Volume:</td>
                            <td style="text-align: right; font-weight: 800; color: #0f172a; font-size: 15px; padding: 10px 14px;">${f.gross}</td>
                        </tr>
                        <tr style="background: #ffffff; border-bottom: 1px solid #e2e8f0;">
                            <td style="color: #1e293b; font-weight: 600; padding: 9px 14px;">Applied Platform Commission (${d.platform_fee_percent}%):</td>
                            <td style="text-align: right; color: #0d9488; font-weight: 700; font-size: 14px; padding: 9px 14px;">${f.fee}</td>
                        </tr>
                        <tr style="background: #ffffff; border-bottom: 1px solid #e2e8f0;">
                            <td style="color: #334155; padding: 9px 14px;">Central GST (CGST @ ${(d.gst_percent ? d.gst_percent/2 : 9).toFixed(2)}%):</td>
                            <td style="text-align: right; color: #1e293b; font-weight: 600; padding: 9px 14px;">${f.cgst}</td>
                        </tr>
                        <tr style="background: #ffffff; border-bottom: 1px solid #e2e8f0;">
                            <td style="color: #334155; padding: 9px 14px;">State GST (SGST @ ${(d.gst_percent ? d.gst_percent/2 : 9).toFixed(2)}%):</td>
                            <td style="text-align: right; color: #1e293b; font-weight: 600; padding: 9px 14px;">${f.sgst}</td>
                        </tr>
                        <tr style="background: #fee2e2; border-bottom: 2px solid #fca5a5;">
                            <td style="font-weight: 700; color: #991b1b; padding: 10px 14px;">Total Platform Deductions:</td>
                            <td style="text-align: right; color: #b91c1c; font-weight: 800; font-size: 14.5px; padding: 10px 14px;">-${f.deduction}</td>
                        </tr>
                        <tr style="background: #dcfce7;">
                            <td style="font-weight: 800; color: #166534; font-size: 14px; padding: 11px 14px;">Net Facility Bank Payout:</td>
                            <td style="text-align: right; font-weight: 800; color: #15803d; font-size: 16px; padding: 11px 14px;">${f.payout}</td>
                        </tr>
                    </table>

                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; color: #475569; background: #f8fafc; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div><strong>Payout Status:</strong> <span class="label label-${d.payout_status === 'settled' ? 'success' : (d.payout_status === 'queued' ? 'primary' : 'warning')}" style="font-weight: 700;">${d.payout_status.toUpperCase()}</span></div>
                        <div><strong>Settlement Timestamp:</strong> <span style="font-weight: 600;">${f.settlement}</span></div>
                    </div>
                `;
                $('#txnModalBody').html(html);
            } else {
                $('#txnModalBody').html('<div class="alert alert-danger">' + res.message + '</div>');
            }
        },
        error: function() {
            $('#txnModalBody').html('<div class="alert alert-danger">Error fetching transaction details.</div>');
        }
    });
}

// Live calculation simulator preview
function updateLiveCalcPreview() {
    var bill = parseFloat($('#simSampleBill').val()) || 10000;
    var feeRate = parseFloat($('#inputFeePercent').val()) || 10;
    var gstRate = parseFloat($('#inputGstPercent').val()) || 18;

    var halfGstRate = gstRate / 2;
    var feeAmt = Math.round((bill * (feeRate / 100)) * 100) / 100;
    var cgstAmt = Math.round((feeAmt * (halfGstRate / 100)) * 100) / 100;
    var sgstAmt = Math.round((feeAmt * (halfGstRate / 100)) * 100) / 100;
    var totalDeduction = Math.round((feeAmt + cgstAmt + sgstAmt) * 100) / 100;
    var netPayout = Math.round((bill - totalDeduction) * 100) / 100;

    $('#simGross').text('₹' + bill.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#simFeeRate').text(feeRate.toFixed(2));
    $('#simFee').text('₹' + feeAmt.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    
    $('#simCgstRate').text(halfGstRate.toFixed(2));
    $('#simCgst').text('₹' + cgstAmt.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    
    $('#simSgstRate').text(halfGstRate.toFixed(2));
    $('#simSgst').text('₹' + sgstAmt.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    
    $('#simDeduction').text('-₹' + totalDeduction.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#simPayout').text('₹' + netPayout.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));

    $('#gstSplitHint').text('Split into ' + halfGstRate.toFixed(2) + '% CGST and ' + halfGstRate.toFixed(2) + '% SGST on platform brokerage fees.');
}

// Auto open tab based on URL hash and persist tab on click
$(document).ready(function() {
    if (window.location.hash) {
        var hash = window.location.hash;
        $('ul.admin-nav-tabs a[href="' + hash + '"]').tab('show');
    }

    $('ul.admin-nav-tabs a').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        if (history.pushState) {
            history.pushState(null, null, target);
        } else {
            location.hash = target;
        }
    });

    updateLiveCalcPreview();
});
</script>
