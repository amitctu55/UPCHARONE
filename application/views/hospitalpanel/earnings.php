<?php include ("assets/includes/header_hospital.php"); ?>
<?php include ("assets/includes/leftmenu_hospital.php"); ?>

<style>
.kpi-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 20px;
}
.kpi-title {
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}
.kpi-value {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}
.kpi-sub {
    font-size: 11.5px;
    color: #94a3b8;
    margin-top: 4px;
}
.badge-escrow {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
}
.badge-held { background: #fef3c7; color: #b45309; }
.badge-released { background: #dcfce7; color: #15803d; }
.badge-processed { background: #d1fae5; color: #065f46; }
</style>

<div class="pag_cstm" style="padding: 24px; background: #f8fafc; min-height: 85vh;">
    <div class="row">
        <div class="col-lg-12">
            
            <!-- Page Title -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 24px; gap: 12px;">
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                        <i class="fa fa-line-chart" style="color: #00a896; margin-right: 8px;"></i> Hospital Revenue &amp; Financial Settlements
                    </h2>
                    <p style="color: #64748b; font-size: 13.5px; margin: 0;">
                        Consolidated ledger for inpatient admissions, OPD consultations, and platform payouts.
                    </p>
                </div>
                <div>
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 12.5px; padding: 6px 14px; border-radius: 20px; font-weight: 700;">
                        <i class="fa fa-university"></i> Settled via RazorpayX
                    </span>
                </div>
            </div>

            <!-- KPI Row -->
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="kpi-card" style="border-left: 4px solid #00a896;">
                        <div class="kpi-title">Gross Revenue Processed</div>
                        <div class="kpi-value" style="color: #00a896;">₹<?=number_format(@$earnings->total_gross, 2);?></div>
                        <div class="kpi-sub">Total transactions: <?=intval(@$earnings->total_txns);?></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="kpi-card" style="border-left: 4px solid #3b82f6;">
                        <div class="kpi-title">Net Hospital Payouts</div>
                        <div class="kpi-value" style="color: #3b82f6;">₹<?=number_format(@$earnings->total_net, 2);?></div>
                        <div class="kpi-sub">Minus platform SaaS processing fee</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="kpi-card" style="border-left: 4px solid #10b981;">
                        <div class="kpi-title">Settled to Hospital Account</div>
                        <div class="kpi-value" style="color: #10b981;">₹<?=number_format(@$earnings->settled_payout, 2);?></div>
                        <div class="kpi-sub">Directly transferred to bank account</div>
                    </div>
                </div>
            </div>

            <!-- Ledger Table Box -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <div style="padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 0;">
                        <i class="fa fa-list-alt" style="color: #00a896;"></i> Hospital Financial Ledger
                    </h3>
                    <span style="font-size: 12px; color: #64748b;">Showing recent entries</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                        <thead>
                            <tr style="background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 1px solid #e2e8f0;">
                                <th style="padding: 12px 16px;">Txn Reference</th>
                                <th style="padding: 12px 16px;">Order ID</th>
                                <th style="padding: 12px 16px;">Gross Amount</th>
                                <th style="padding: 12px 16px;">Platform Fee (5%)</th>
                                <th style="padding: 12px 16px;">Net Payout</th>
                                <th style="padding: 12px 16px;">Escrow Status</th>
                                <th style="padding: 12px 16px;">Payout Status</th>
                                <th style="padding: 12px 16px;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ledger)): ?>
                                <?php foreach ($ledger as $row): ?>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 600; color: #0f172a; font-family: monospace;">
                                        <?=html_escape($row->transaction_ref);?>
                                    </td>
                                    <td style="padding: 12px 16px; color: #64748b;">
                                        <?=html_escape($row->order_id ?: 'N/A');?>
                                    </td>
                                    <td style="padding: 12px 16px; font-weight: 600; color: #0f172a;">
                                        ₹<?=number_format($row->gross_amount, 2);?>
                                    </td>
                                    <td style="padding: 12px 16px; color: #ef4444;">
                                        -₹<?=number_format($row->platform_fee, 2);?>
                                    </td>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #00a896;">
                                        ₹<?=number_format($row->net_payout, 2);?>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <?php if ($row->escrow_status == 'HELD'): ?>
                                            <span class="badge-escrow badge-held"><i class="fa fa-lock"></i> HELD</span>
                                        <?php else: ?>
                                            <span class="badge-escrow badge-released"><i class="fa fa-check"></i> RELEASED</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <?php if ($row->payout_status == 'PROCESSED'): ?>
                                            <span class="badge-escrow badge-processed"><i class="fa fa-check-circle"></i> SETTLED</span>
                                        <?php else: ?>
                                            <span class="badge-escrow badge-held">UNPROCESSED</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 12px 16px; color: #64748b;">
                                        <?=date('d M Y, h:i A', strtotime($row->created_at));?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="padding: 30px; text-align: center; color: #64748b;">
                                        <i class="fa fa-info-circle" style="font-size: 20px; color: #94a3b8; margin-bottom: 6px; display: block;"></i>
                                        No hospital ledger transactions recorded yet.
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
