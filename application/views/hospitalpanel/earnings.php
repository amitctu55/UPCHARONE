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

.badge-gateway {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 12px;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* KPI Summary Bar */
.kpi-revenue-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
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

        <!-- Page Header -->
        <div class="earn-header-card">
            <div>
                <h1><i class="fa fa-line-chart" style="color: #00a896; margin-right: 8px;"></i> Hospital Revenue &amp; Financial Ledger</h1>
                <p>Consolidated payout journal for IPD admissions, OPD walk-in consultations, and automated platform transfers.</p>
            </div>
            <div>
                <span class="badge-gateway">
                    <i class="fa fa-university"></i> Automated Banking via RazorpayX
                </span>
            </div>
        </div>

        <!-- KPI Revenue Grid -->
        <div class="kpi-revenue-grid">
            <div class="kpi-rev-card" style="border-left: 4px solid #00a896;">
                <div class="kpi-rev-title">Gross Revenue (MTD)</div>
                <div class="kpi-rev-value">₹<?=number_format((float)$total_revenue, 2);?></div>
                <p class="kpi-rev-sub">Total billed healthcare services</p>
            </div>

            <div class="kpi-rev-card" style="border-left: 4px solid #10b981;">
                <div class="kpi-rev-title">Settled Payouts</div>
                <div class="kpi-rev-value" style="color: #10b981;">₹<?=number_format((float)$settled_revenue, 2);?></div>
                <p class="kpi-rev-sub">Transferred to registered bank account</p>
            </div>

            <div class="kpi-rev-card" style="border-left: 4px solid #f59e0b;">
                <div class="kpi-rev-title">Escrow / In-Process</div>
                <div class="kpi-rev-value" style="color: #f59e0b;">₹<?=number_format((float)$escrow_revenue, 2);?></div>
                <p class="kpi-rev-sub">Pending discharge / verification</p>
            </div>

            <div class="kpi-rev-card" style="border-left: 4px solid #3b82f6;">
                <div class="kpi-rev-title">Total Payouts</div>
                <div class="kpi-rev-value" style="color: #3b82f6;">₹<?=number_format((float)$total_payouts, 2);?></div>
                <p class="kpi-rev-sub">All-time lifetime disbursements</p>
            </div>
        </div>

        <!-- Ledger Table -->
        <div class="earn-ledger-card">
            <div class="earn-ledger-header">
                <h3><i class="fa fa-book"></i> Settlement Transaction Journal</h3>
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
                            <th>Escrow / Settlement</th>
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
                                        <?php if ($t->escrow_status == 'HELD'): ?>
                                            <span class="badge-held"><i class="fa fa-clock-o"></i> HELD (ESCROW)</span>
                                        <?php elseif ($t->escrow_status == 'RELEASED'): ?>
                                            <span class="badge-released"><i class="fa fa-check-circle"></i> RELEASED</span>
                                        <?php else: ?>
                                            <span class="badge-processed"><i class="fa fa-check"></i> SETTLED</span>
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
                                    <span>Financial settlements for completed IPD admissions and OPD appointments will be logged here automatically.</span>
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
