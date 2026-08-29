<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
:root {
    --upchar-teal: #00a896;
    --upchar-teal-dark: #008f80;
    --upchar-navy: #043d5b;
    --upchar-slate: #0f172a;
    --upchar-gray: #64748b;
    --upchar-light: #f8fafc;
    --upchar-border: #e2e8f0;
}

.earn-page-wrap {
    padding: 24px 28px;
    background: #f8fafc;
    min-height: 88vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.earn-header-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.earn-header-card h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.earn-header-card p {
    font-size: 13.5px;
    color: #64748b;
    margin: 0;
}

/* Export Buttons */
.header-export-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-export-excel {
    background: #10b981;
    color: #ffffff !important;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: none;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
    transition: all 0.15s ease;
}

.btn-export-excel:hover {
    background: #059669;
    transform: translateY(-1px);
}

.btn-export-pdf {
    background: #043d5b;
    color: #ffffff !important;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: none;
    box-shadow: 0 2px 8px rgba(4, 61, 91, 0.25);
    transition: all 0.15s ease;
}

.btn-export-pdf:hover {
    background: #022b40;
    transform: translateY(-1px);
}

/* KPI Summary Bar */
.kpi-revenue-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.kpi-rev-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.kpi-rev-title {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.kpi-rev-value {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.kpi-rev-sub {
    font-size: 11.5px;
    color: #94a3b8;
    margin: 0;
}

/* Filter Card */
.earn-filter-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 22px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.filter-pills-bar {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.earn-filter-pill {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    background: #f1f5f9;
    text-decoration: none !important;
    transition: all 0.15s ease;
}

.earn-filter-pill:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.earn-filter-pill.active {
    background: #00a896;
    color: #ffffff;
}

.earn-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 14px;
    align-items: flex-end;
}

.filter-item label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 5px;
}

.filter-ctrl {
    width: 100%;
    height: 38px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 13px;
    color: #1e293b;
    background: #ffffff;
}

.filter-ctrl:focus {
    border-color: #00a896;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.15);
}

.btn-filter-submit {
    background: #043d5b;
    color: #ffffff;
    font-weight: 700;
    font-size: 13px;
    height: 38px;
    padding: 0 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
}

.btn-filter-submit:hover {
    background: #022b40;
}

/* Ledger Table */
.earn-ledger-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.earn-ledger-header {
    padding: 16px 20px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.earn-ledger-header h3 {
    font-size: 15px;
    font-weight: 800;
    color: #043d5b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.table-custom-clean {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom-clean thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-custom-clean tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

.table-custom-clean tbody tr:hover td {
    background: #f8fafc;
}

.badge-held { background: #fef3c7; color: #b45309; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 12px; }
.badge-released { background: #dcfce7; color: #15803d; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 12px; }
.badge-processed { background: #d1fae5; color: #065f46; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 12px; }
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="earn-page-wrap">

        <?php 
        $current_period = $this->input->get_post('period');
        $current_month  = $this->input->get_post('month');
        $current_year   = $this->input->get_post('year');
        $current_status = $this->input->get_post('status');
        $current_from   = $this->input->get_post('date_from');
        $current_to     = $this->input->get_post('date_to');
        
        $query_params = http_build_query(array_filter(array(
            'period'    => $current_period,
            'month'     => $current_month,
            'year'      => $current_year,
            'status'    => $current_status,
            'date_from' => $current_from,
            'date_to'   => $current_to
        )));
        ?>

        <!-- Page Header -->
        <div class="earn-header-card">
            <div>
                <h1><i class="fa fa-line-chart" style="color: #00a896; margin-right: 8px;"></i> Hospital Revenue &amp; Financial Ledger</h1>
                <p>Track OPD consultations, IPD billing settlements, and download certified accounting statements.</p>
            </div>
            <div class="header-export-actions">
                <a href="<?=base_url('hospitalpanel/export_earnings?format=excel'.($query_params ? '&'.$query_params : ''));?>" class="btn-export-excel" title="Download Excel Spreadsheet (CSV)">
                    <i class="fa fa-file-excel-o"></i> Export to Excel
                </a>
                <a href="<?=base_url('hospitalpanel/export_earnings?format=pdf'.($query_params ? '&'.$query_params : ''));?>" target="_blank" class="btn-export-pdf" title="Generate Printable PDF Statement">
                    <i class="fa fa-file-pdf-o"></i> Print / PDF Statement
                </a>
            </div>
        </div>

        <!-- KPI Revenue Grid -->
        <div class="kpi-revenue-grid">
            <div class="kpi-rev-card" style="border-left: 4px solid #00a896;">
                <div class="kpi-rev-title">Gross Revenue</div>
                <div class="kpi-rev-value">₹<?=number_format((float)$total_revenue, 2);?></div>
                <p class="kpi-rev-sub">Total billed healthcare services</p>
            </div>

            <div class="kpi-rev-card" style="border-left: 4px solid #10b981;">
                <div class="kpi-rev-title">Settled / Collected</div>
                <div class="kpi-rev-value" style="color: #10b981;">₹<?=number_format((float)$settled_revenue, 2);?></div>
                <p class="kpi-rev-sub">Paid via counter, UPI &amp; bank payouts</p>
            </div>

            <div class="kpi-rev-card" style="border-left: 4px solid #f59e0b;">
                <div class="kpi-rev-title">Pending Collection</div>
                <div class="kpi-rev-value" style="color: #f59e0b;">₹<?=number_format((float)$escrow_revenue, 2);?></div>
                <p class="kpi-rev-sub">Unpaid appointments &amp; running balances</p>
            </div>

            <div class="kpi-rev-card" style="border-left: 4px solid #3b82f6;">
                <div class="kpi-rev-title">Total Encounters</div>
                <div class="kpi-rev-value" style="color: #3b82f6;"><?=$total_txns_count;?></div>
                <p class="kpi-rev-sub">Clinical consultations &amp; visits</p>
            </div>
        </div>

        <!-- Filter & Statement Search Section -->
        <div class="earn-filter-card">
            <!-- Quick Filter Pills -->
            <div class="filter-pills-bar">
                <span style="font-size: 12px; font-weight: 700; color: #64748b; margin-right: 4px; align-self: center;">Quick Periods:</span>
                <a href="<?=base_url('hospitalpanel/earnings');?>" class="earn-filter-pill <?=empty($current_period) && empty($current_month) && empty($current_from) ? 'active' : '';?>">All Time</a>
                <a href="<?=base_url('hospitalpanel/earnings?period=today');?>" class="earn-filter-pill <?=$current_period=='today' ? 'active' : '';?>"><i class="fa fa-calendar-o"></i> Today</a>
                <a href="<?=base_url('hospitalpanel/earnings?period=this_month');?>" class="earn-filter-pill <?=$current_period=='this_month' ? 'active' : '';?>">This Month</a>
                <a href="<?=base_url('hospitalpanel/earnings?period=last_month');?>" class="earn-filter-pill <?=$current_period=='last_month' ? 'active' : '';?>">Last Month</a>
                <a href="<?=base_url('hospitalpanel/earnings?period=this_year');?>" class="earn-filter-pill <?=$current_period=='this_year' ? 'active' : '';?>">This Year (<?=date('Y');?>)</a>
            </div>

            <!-- Detailed Filters Form -->
            <form action="<?=base_url('hospitalpanel/earnings');?>" method="GET">
                <div class="earn-form-grid">
                    
                    <!-- Month -->
                    <div class="filter-item">
                        <label><i class="fa fa-calendar"></i> Month</label>
                        <select name="month" class="filter-ctrl">
                            <option value="">-- All Months --</option>
                            <?php for($m=1; $m<=12; $m++): ?>
                                <option value="<?=$m;?>" <?=$current_month==$m ? 'selected' : '';?>>
                                    <?=date('F', mktime(0,0,0,$m, 1));?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Year -->
                    <div class="filter-item">
                        <label><i class="fa fa-calendar-check-o"></i> Year</label>
                        <select name="year" class="filter-ctrl">
                            <option value="">-- All Years --</option>
                            <?php for($y=date('Y'); $y>=2020; $y--): ?>
                                <option value="<?=$y;?>" <?=$current_year==$y ? 'selected' : '';?>><?=$y;?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="filter-item">
                        <label><i class="fa fa-calendar-o"></i> Date From</label>
                        <input type="date" name="date_from" value="<?=$current_from;?>" class="filter-ctrl">
                    </div>

                    <!-- Date To -->
                    <div class="filter-item">
                        <label><i class="fa fa-calendar-o"></i> Date To</label>
                        <input type="date" name="date_to" value="<?=$current_to;?>" class="filter-ctrl">
                    </div>

                    <!-- Status -->
                    <div class="filter-item">
                        <label><i class="fa fa-check-circle"></i> Collection Status</label>
                        <select name="status" class="filter-ctrl">
                            <option value="">-- All Statuses --</option>
                            <option value="DONE" <?=$current_status=='DONE' ? 'selected' : '';?>>Paid / Collected</option>
                            <option value="UNPAID" <?=$current_status=='UNPAID' ? 'selected' : '';?>>Unpaid / Pending</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="filter-item" style="display: flex; gap: 8px;">
                        <button type="submit" class="btn-filter-submit">
                            <i class="fa fa-filter"></i> Apply
                        </button>
                        <a href="<?=base_url('hospitalpanel/earnings');?>" class="btn-back-link" style="height: 38px; padding: 0 12px; justify-content: center;" title="Reset Filters">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>

        <!-- Ledger Table -->
        <div class="earn-ledger-card">
            <div class="earn-ledger-header">
                <h3><i class="fa fa-book"></i> Financial Settlement Journal</h3>
                <span style="font-size: 12.5px; font-weight: 700; color: #64748b;">Showing <?=count($transactions);?> Recorded Encounters</span>
            </div>

            <div class="table-responsive">
                <table class="table table-custom-clean">
                    <thead>
                        <tr>
                            <th>Transaction Ref</th>
                            <th>Service Category</th>
                            <th>Patient / Encounter</th>
                            <th>Doctor</th>
                            <th>Gross Total</th>
                            <th>Platform Fee</th>
                            <th>Net Hospital Share</th>
                            <th>Payment Status</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($transactions)): ?>
                            <?php foreach($transactions as $t): ?>
                                <tr>
                                    <td style="font-weight: 800; color: #043d5b; font-family: monospace;">
                                        <?=html_escape($t->transaction_ref);?>
                                    </td>
                                    <td>
                                        <span style="font-weight: 700; font-size: 11.5px; padding: 3px 8px; border-radius: 6px; background: #f1f5f9; color: #475569;">
                                            <?=html_escape($t->item_type);?>
                                        </span>
                                    </td>
                                    <td style="font-weight: 600; color: #0f172a;">
                                        <?=html_escape($t->patient_name ?: 'Direct Encounter');?>
                                    </td>
                                    <td style="color: #64748b;">
                                        <?=html_escape($t->dr_name ?: 'General Clinic');?>
                                    </td>
                                    <td style="font-weight: 700; color: #0f172a;">
                                        ₹<?=number_format((float)(isset($t->gross_amount) ? $t->gross_amount : (isset($t->amount) ? $t->amount : 0)), 2);?>
                                    </td>
                                    <td style="color: #ef4444; font-size: 12px;">
                                        -₹<?=number_format((float)(isset($t->platform_fee) ? $t->platform_fee : 0), 2);?>
                                    </td>
                                    <td style="font-weight: 800; color: #00a896; font-size: 13.5px;">
                                        ₹<?=number_format((float)(isset($t->net_payout) ? $t->net_payout : (isset($t->hospital_share) ? $t->hospital_share : 0)), 2);?>
                                    </td>
                                    <td>
                                        <?php if ($t->payment_status == 'DONE'): ?>
                                            <span class="badge-processed"><i class="fa fa-check"></i> PAID (SETTLED)</span>
                                        <?php else: ?>
                                            <span class="badge-held"><i class="fa fa-clock-o"></i> PENDING / UNPAID</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="color: #64748b; font-size: 12px;">
                                        <?=date('d M Y, h:i A', strtotime($t->created_at));?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 50px 20px; color: #94a3b8;">
                                    <i class="fa fa-university" style="font-size: 40px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    <strong style="font-size: 15px; color: #64748b; display: block;">No Settlement Records Recorded</strong>
                                    <span>Financial settlements matching your search filters will appear here.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include ("assets/includes/footer_hospital.php"); ?>
