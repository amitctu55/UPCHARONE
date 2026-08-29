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
    margin-bottom: 24px;
}

.kpi-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 22px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    position: relative;
    overflow: hidden;
}

.kpi-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
}

.kpi-card.teal::before { background: #00a896; }
.kpi-card.green::before { background: #10b981; }
.kpi-card.amber::before { background: #f59e0b; }
.kpi-card.purple::before { background: #8b5cf6; }

.kpi-title {
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.kpi-value {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 4px;
    line-height: 1.2;
}

.kpi-sub {
    font-size: 12px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Commission Rate Alert Card */
.comm-info-card {
    background: linear-gradient(135deg, #f0fdfa 0%, #e0f2fe 100%);
    border: 1px solid #ccfbf1;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.comm-info-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #0f766e;
    display: flex;
    align-items: center;
    gap: 8px;
}

.comm-badge {
    background: #043d5b;
    color: #ffffff;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
}

/* Tab Navigation */
.revenue-tabs-nav {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 10px;
}

.revenue-tab-btn {
    padding: 9px 20px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 700;
    color: #64748b;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    cursor: pointer;
    transition: all 0.15s ease;
}

.revenue-tab-btn.active {
    background: #043d5b;
    color: #ffffff !important;
    border-color: #043d5b;
}

/* Filter Card */
.filter-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    padding: 18px 20px;
    margin-bottom: 22px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
    align-items: flex-end;
}

.filter-group label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 4px;
}

.filter-control {
    width: 100%;
    height: 38px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    color: #0f172a;
    background: #ffffff;
}

.btn-filter-apply {
    background: #00a896;
    color: #ffffff;
    font-weight: 700;
    font-size: 13px;
    height: 38px;
    padding: 0 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
}

.btn-filter-reset {
    background: #f1f5f9;
    color: #475569;
    font-weight: 700;
    font-size: 13px;
    height: 38px;
    padding: 0 16px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
}

/* Data Table Container */
.table-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--upchar-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-hdr {
    padding: 16px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.table-hdr h3 {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.custom-ledger-tbl {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}

.custom-ledger-tbl thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
    border-bottom: 1px solid #e2e8f0;
    border-top: none;
    white-space: nowrap;
}

.custom-ledger-tbl tbody td {
    padding: 13px 14px;
    font-size: 13px;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.custom-ledger-tbl tbody tr:hover {
    background: #f8fafc;
}

.badge-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 11px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-status.paid, .badge-status.processed {
    background: #dcfce7;
    color: #15803d;
}

.badge-status.pending, .badge-status.unpaid {
    background: #fef3c7;
    color: #b45309;
}
</style>

<div class="page-content" style="padding-top: 0;">
    <div class="earn-page-wrap">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('flashmsg')): ?>
            <?=$this->session->flashdata('flashmsg');?>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="earn-header-card">
            <div>
                <h1><i class="fa fa-line-chart" style="color: #00a896; margin-right: 8px;"></i> Revenue &amp; Financial Settlement Dashboard</h1>
                <p>Track gross billing, Upchar platform deductions, GST invoices, and net bank settlements.</p>
            </div>
            <div class="header-export-actions">
                <?php
                $queryString = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
                ?>
                <a href="<?=base_url('hospitalpanel/export_earnings'.$queryString.(empty($queryString)?'?format=excel':'&format=excel'));?>" class="btn-export-excel">
                    <i class="fa fa-file-excel-o"></i> Export to Excel (.csv)
                </a>
                <a href="<?=base_url('hospitalpanel/export_earnings'.$queryString.(empty($queryString)?'?format=pdf':'&format=pdf'));?>" target="_blank" class="btn-export-pdf">
                    <i class="fa fa-file-pdf-o"></i> Export / Print Statement
                </a>
            </div>
        </div>

        <!-- Commission & GST Structure Bar -->
        <div class="comm-info-card">
            <div class="comm-info-title">
                <i class="fa fa-shield" style="font-size: 18px;"></i>
                <span>Active Facility Platform Fee Rate: <strong><?=number_format($custom_rate, 2);?>%</strong> + <strong>18% GST</strong></span>
            </div>
            <div>
                <span class="comm-badge">
                    <i class="fa fa-calculator"></i> Calculation: Gross - (<?=number_format($custom_rate, 1);?>% Fee + 18% GST) = Net Payout
                </span>
            </div>
        </div>

        <!-- Metric KPI Cards -->
        <div class="kpi-revenue-grid">
            <!-- Gross Revenue -->
            <div class="kpi-card teal">
                <div class="kpi-title">Gross Revenue Billed</div>
                <div class="kpi-value">₹<?=number_format($summary->gross_revenue ?? 0, 2);?></div>
                <div class="kpi-sub">
                    <i class="fa fa-stethoscope"></i> <?=$summary->total_txns ?? 0;?> Clinical Encounters
                </div>
            </div>

            <!-- Net Hospital Share -->
            <div class="kpi-card green">
                <div class="kpi-title">Net Hospital Payout</div>
                <div class="kpi-value" style="color: #10b981;">₹<?=number_format($summary->net_hospital_share ?? 0, 2);?></div>
                <div class="kpi-sub">
                    <i class="fa fa-bank"></i> Total Hospital Net Share
                </div>
            </div>

            <!-- Settled Payouts -->
            <div class="kpi-card purple">
                <div class="kpi-title">Settled &amp; Paid Out</div>
                <div class="kpi-value" style="color: #8b5cf6;">₹<?=number_format($summary->settled_payouts ?? 0, 2);?></div>
                <div class="kpi-sub">
                    <i class="fa fa-check-circle"></i> Transferred to Bank Account
                </div>
            </div>

            <!-- Pending Payouts -->
            <div class="kpi-card amber">
                <div class="kpi-title">Pending Settlement</div>
                <div class="kpi-value" style="color: #d97706;">₹<?=number_format($summary->pending_payouts ?? 0, 2);?></div>
                <div class="kpi-sub">
                    <i class="fa fa-clock-o"></i> Queued for Next Bank Batch
                </div>
            </div>
        </div>

        <!-- Multi-Tab Navigation -->
        <div class="revenue-tabs-nav">
            <button type="button" class="revenue-tab-btn active" id="tabLedgerBtn" onclick="switchRevenueTab('ledger')">
                <i class="fa fa-table"></i> Financial Transactions Ledger
            </button>
            <button type="button" class="revenue-tab-btn" id="tabInvoicesBtn" onclick="switchRevenueTab('invoices')">
                <i class="fa fa-file-text-o"></i> Monthly GST Invoices &amp; ITC Filing
            </button>
        </div>

        <!-- TAB 1: FINANCIAL LEDGER -->
        <div id="ledgerSection">
            <!-- Filter Bar -->
            <div class="filter-card">
                <form action="<?=base_url('hospitalpanel/earnings');?>" method="GET">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label>Search Keyword</label>
                            <input type="text" name="search" class="filter-control" placeholder="Txn ID, Patient, Category..." value="<?=html_escape($this->input->get('search') ?? '');?>">
                        </div>

                        <div class="filter-group">
                            <label>Month</label>
                            <select name="month" class="filter-control">
                                <option value="">All Months</option>
                                <?php for($m=1; $m<=12; $m++): ?>
                                    <option value="<?=sprintf('%02d', $m);?>" <?=($this->input->get('month') == sprintf('%02d', $m)) ? 'selected' : '';?>>
                                        <?=date('F', mktime(0, 0, 0, $m, 1));?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Year</label>
                            <select name="year" class="filter-control">
                                <option value="">All Years</option>
                                <?php for($y=date('Y'); $y>=date('Y')-3; $y--): ?>
                                    <option value="<?=$y;?>" <?=($this->input->get('year') == $y) ? 'selected' : '';?>><?=$y;?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Payout Status</label>
                            <select name="status" class="filter-control">
                                <option value="all">All Payout Statuses</option>
                                <option value="processed" <?=($this->input->get('status') === 'processed') ? 'selected' : '';?>>Settled / Paid</option>
                                <option value="pending" <?=($this->input->get('status') === 'pending') ? 'selected' : '';?>>Pending Settlement</option>
                            </select>
                        </div>

                        <div class="filter-group" style="display: flex; gap: 8px;">
                            <button type="submit" class="btn-filter-apply">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                            <a href="<?=base_url('hospitalpanel/earnings');?>" class="btn-filter-reset">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ledger Table -->
            <div class="table-card">
                <div class="table-hdr">
                    <h3><i class="fa fa-list-alt"></i> Settlement Transactions</h3>
                    <span style="font-size: 13px; color: #64748b; font-weight: 600;">
                        Showing <?=count($transactions);?> records
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table custom-ledger-tbl">
                        <thead>
                            <tr>
                                <th>Transaction Code</th>
                                <th>Category</th>
                                <th>Patient Name</th>
                                <th style="text-align: right;">Gross Bill</th>
                                <th style="text-align: right;">Upchar Fee (<?=$custom_rate;?>%)</th>
                                <th style="text-align: right;">GST (18%)</th>
                                <th style="text-align: right;">Total Deduction</th>
                                <th style="text-align: right;">Net Hospital Share</th>
                                <th style="text-align: center;">Payout Status</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($transactions)): ?>
                                <?php foreach($transactions as $t): ?>
                                    <tr>
                                        <td>
                                            <strong style="color: #043d5b;"><?=$t->txn_code;?></strong>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #e0f2fe; color: #0284c7; font-weight: 700;">
                                                <?=$t->category;?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong style="color: #0f172a;"><?=$t->patient_name;?></strong>
                                        </td>
                                        <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                            ₹<?=number_format($t->gross_amount, 2);?>
                                        </td>
                                        <td style="text-align: right; color: #64748b;">
                                            ₹<?=number_format($t->platform_fee_amount, 2);?>
                                        </td>
                                        <td style="text-align: right; color: #64748b;">
                                            ₹<?=number_format($t->gst_amount, 2);?>
                                        </td>
                                        <td style="text-align: right; color: #ef4444; font-weight: 600;">
                                            -₹<?=number_format($t->total_platform_deduction, 2);?>
                                        </td>
                                        <td style="text-align: right; font-weight: 800; color: #10b981; font-size: 14px;">
                                            ₹<?=number_format($t->net_facility_share, 2);?>
                                        </td>
                                        <td style="text-align: center;">
                                            <span class="badge-status <?=$t->payout_status;?>">
                                                <i class="fa fa-circle" style="font-size: 7px;"></i>
                                                <?=($t->payout_status === 'processed') ? 'Settled' : 'Pending';?>
                                            </span>
                                        </td>
                                        <td style="font-size: 12px; color: #64748b; white-space: nowrap;">
                                            <?=date('d M Y, h:i A', strtotime($t->created_at));?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center" style="padding: 40px; color: #94a3b8;">
                                        <i class="fa fa-inbox" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                                        No financial transactions found for the selected period.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 2: MONTHLY GST INVOICES & ITC -->
        <div id="invoicesSection" style="display: none;">
            
            <div class="earn-header-card" style="margin-bottom: 20px;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #043d5b; margin: 0 0 4px 0;">
                        <i class="fa fa-file-text" style="color: #00a896;"></i> Monthly Tax Invoices for Platform Fees
                    </h3>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                        Download GST Invoices raised by Upchar Health Technologies for Input Tax Credit (ITC) claiming under GST laws.
                    </p>
                </div>
                <div>
                    <?php echo form_open("hospitalpanel/generate_monthly_invoice", 'style="display: inline-flex; gap: 8px; align-items: center;"');?>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        <select name="billing_month" class="form-control" style="height: 38px; width: 140px; border-radius: 8px;">
                            <?php for($i=0; $i<=5; $i++): 
                                $bm = date('Y-m', strtotime("-$i month"));
                            ?>
                                <option value="<?=$bm;?>"><?=date('F Y', strtotime("-$i month"));?></option>
                            <?php endfor; ?>
                        </select>
                        <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; font-weight: 700; height: 38px; border-radius: 8px;">
                            <i class="fa fa-plus-circle"></i> Generate Tax Invoice
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table custom-ledger-tbl">
                        <thead>
                            <tr>
                                <th>Invoice Number</th>
                                <th>Billing Month</th>
                                <th style="text-align: right;">Taxable Platform Fee</th>
                                <th style="text-align: right;">CGST (9%)</th>
                                <th style="text-align: right;">SGST (9%)</th>
                                <th style="text-align: right;">Total Invoice Amount</th>
                                <th>Generated Date</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($invoices)): ?>
                                <?php foreach($invoices as $inv): ?>
                                    <tr>
                                        <td>
                                            <strong style="color: #043d5b;"><?=$inv->invoice_number;?></strong>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #f1f5f9; color: #334155; font-weight: 700;">
                                                <?=date('F Y', strtotime($inv->billing_month . '-01'));?>
                                            </span>
                                        </td>
                                        <td style="text-align: right; font-weight: 600;">
                                            ₹<?=number_format($inv->total_taxable_value, 2);?>
                                        </td>
                                        <td style="text-align: right; color: #64748b;">
                                            ₹<?=number_format($inv->cgst_amount, 2);?>
                                        </td>
                                        <td style="text-align: right; color: #64748b;">
                                            ₹<?=number_format($inv->sgst_amount, 2);?>
                                        </td>
                                        <td style="text-align: right; font-weight: 800; color: #043d5b; font-size: 14px;">
                                            ₹<?=number_format($inv->total_invoice_amount, 2);?>
                                        </td>
                                        <td style="font-size: 12px; color: #64748b;">
                                            <?=date('d-M-Y', strtotime($inv->generated_at));?>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="<?=base_url('hospitalpanel/invoice_view/'.$inv->invoice_id);?>" target="_blank" class="btn btn-sm btn-default" style="background: #043d5b; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 5px 12px;">
                                                <i class="fa fa-eye"></i> View / Print Invoice
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center" style="padding: 40px; color: #94a3b8;">
                                        <i class="fa fa-file-text-o" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                                        No GST Invoices generated yet. Select a month above and click "Generate Tax Invoice".
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

<?php include ("assets/includes/footer_hospital.php"); ?>

<script>
function switchRevenueTab(tab) {
    if (tab === 'ledger') {
        $('#tabLedgerBtn').addClass('active');
        $('#tabInvoicesBtn').removeClass('active');
        $('#ledgerSection').show();
        $('#invoicesSection').hide();
    } else {
        $('#tabInvoicesBtn').addClass('active');
        $('#tabLedgerBtn').removeClass('active');
        $('#invoicesSection').show();
        $('#ledgerSection').hide();
    }
}

// Auto open invoices tab if hash is #invoices
$(document).ready(function() {
    if (window.location.hash === '#invoices') {
        switchRevenueTab('invoices');
    }
});
</script>
