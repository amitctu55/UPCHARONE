<style>
:root {
    --navy: #08364B;
    --navy-dark: #042433;
    --cyan: #00A8FF;
    --green: #10B981;
    --amber: #F59E0B;
    --red: #E63946;
    --card-border: #E2E8F0;
}

.payments-page-wrapper {
    padding: 24px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.payments-page-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.payments-page-title h2 {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px 0;
}

.payments-page-title p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.kpi-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.kpi-card {
    background: #FFFFFF;
    border: 1px solid var(--card-border);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.kpi-val {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1.2;
}
.kpi-lbl {
    font-size: 12.5px;
    color: #64748B;
    font-weight: 600;
    margin-top: 4px;
}
.kpi-icon {
    font-size: 32px;
    opacity: 0.2;
}

.ledger-card {
    background: #FFFFFF;
    border: 1px solid var(--card-border);
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 24px;
    overflow: hidden;
}
.ledger-header {
    background: #F8FAFC;
    padding: 16px 20px;
    border-bottom: 1px solid var(--card-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}
.ledger-header h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: var(--navy);
}

.ledger-table th {
    background: #F8FAFC;
    color: #475569;
    font-weight: 700;
    font-size: 13px;
    padding: 12px;
    border-bottom: 2px solid #E2E8F0;
}
.ledger-table td {
    padding: 12px;
    border-bottom: 1px solid #F1F5F9;
    vertical-align: middle;
    font-size: 13.5px;
}

.legal-footer {
    text-align: center;
    padding: 20px;
    font-size: 12.5px;
    color: #64748B;
    border-top: 1px solid #E2E8F0;
    margin-top: 40px;
    background: #FFFFFF;
    border-radius: 12px;
}
</style>

<div class="payments-page-wrapper">
    <!-- Clean Page Header -->
    <div class="payments-page-header">
        <div class="payments-page-title">
            <h2><i class="fa fa-wallet text-primary me-2" style="color:#0284c7;"></i> Payments & Payout Settlements</h2>
            <p>Track cash-on-delivery reconciliations, online payment receipts, and bank settlements.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700;">
                <i class="fa fa-hospital-o me-1"></i> <?=htmlspecialchars($current_store['store_name'] ?? 'Chemist Store');?>
            </span>
            <?php if (!empty($stores) && count($stores) > 1): ?>
                <select class="form-control input-sm" onchange="location.href='<?=base_url('pharmacy/payments?store_id=');?>'+this.value" style="display:inline-block; width:auto; height:34px; border-radius:8px; border:1px solid #cbd5e1; font-weight:600;">
                    <?php foreach($stores as $st): ?>
                        <option value="<?=$st['id'];?>" <?=$st['id'] == $current_store['id'] ? 'selected' : '';?>>
                            <?=$st['store_name'];?> (<?=$st['city'];?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <button onclick="location.reload();" class="btn btn-sm btn-default" style="border-radius:8px; background:#fff; border:1px solid #cbd5e1; padding:6px 12px;">
                <i class="fa fa-refresh"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Financial Overview KPIs -->
    <div class="kpi-row">
        <div class="kpi-card">
            <div>
                <div class="kpi-val">₹<?=number_format($metrics['total_gross'], 2);?></div>
                <div class="kpi-lbl">Total Gross Orders</div>
            </div>
            <i class="fas fa-coins" style="font-size: 26px; color: var(--navy); opacity: 0.8;"></i>
        </div>
        <div class="kpi-card">
            <div>
                <div class="kpi-val" style="color: var(--green);">₹<?=number_format($metrics['total_paid'], 2);?></div>
                <div class="kpi-lbl">Realized / Paid (<?=number_format($metrics['total_online'], 2);?> Online)</div>
            </div>
            <i class="fas fa-check-double" style="font-size: 26px; color: var(--green); opacity: 0.8;"></i>
        </div>
        <div class="kpi-card">
            <div>
                <div class="kpi-val" style="color: var(--amber);">₹<?=number_format($metrics['total_cod'], 2);?></div>
                <div class="kpi-lbl">Cash on Delivery (COD)</div>
            </div>
            <i class="fas fa-hand-holding-usd" style="font-size: 26px; color: var(--amber); opacity: 0.8;"></i>
        </div>
        <div class="kpi-card">
            <div>
                <div class="kpi-val" style="color: var(--cyan);"><?=$metrics['commission_rate'];?>%</div>
                <div class="kpi-lbl">UPCHAR Platform Commission</div>
            </div>
            <i class="fas fa-percentage" style="font-size: 26px; color: var(--cyan); opacity: 0.8;"></i>
        </div>
    </div>

    <!-- Main Payment Ledger -->
    <div class="card-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <div>
                <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--navy);">
                    <i class="fas fa-receipt" style="color: var(--cyan);"></i> Medicine Order Transactions Ledger
                </h3>
                <p style="margin: 4px 0 0 0; font-size: 13px; color: #64748B;">
                    Real-time payment reconciliation synced with Razorpay webhooks and rider doorstep cash collection.
                </p>
            </div>
            <span class="badge" style="background: #E0F2FE; color: #0369A1; font-size: 13px; padding: 6px 12px;">
                <?=count($transactions);?> Transactions
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover ledger-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Payment Status</th>
                        <th>Fulfillment</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($transactions)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px; color: #94A3B8;">
                                No transactions recorded yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($transactions as $tx): ?>
                        <tr>
                            <td><strong>#<?=htmlspecialchars($tx['order_code']);?></strong></td>
                            <td><?=date('d M Y, h:i A', strtotime($tx['created_at']));?></td>
                            <td>
                                <strong><?=htmlspecialchars($tx['customer_name']);?></strong>
                                <div style="font-size: 11px; color: #64748B;"><?=htmlspecialchars($tx['customer_phone']);?></div>
                            </td>
                            <td><strong>₹<?=number_format($tx['total_amount'], 2);?></strong></td>
                            <td>
                                <span class="badge" style="background: <?=$tx['payment_mode']=='COD'?'#FEF3C7':'#E0F2FE';?>; color: <?=$tx['payment_mode']=='COD'?'#92400E':'#0369A1';?>;">
                                    <?=$tx['payment_mode'];?>
                                </span>
                            </td>
                            <td>
                                <span class="label <?=$tx['payment_status']=='PAID'?'label-success':'label-warning';?>" style="font-size: 11px;">
                                    <?=$tx['payment_status'];?>
                                </span>
                            </td>
                            <td>
                                <span class="label label-default" style="font-size: 11px;"><?=$tx['order_status'];?></span>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?=base_url('pharmacy/billing/generate/'.$tx['id']);?>" target="_blank" class="btn btn-xs btn-default" style="font-weight: 600;">
                                    <i class="fas fa-file-invoice"></i> Invoice
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Settlement Reconciliation History -->
    <div class="card-box">
        <h4 style="margin-top: 0; font-size: 16px; font-weight: 800; color: var(--navy);">
            <i class="fas fa-university" style="color: var(--cyan);"></i> Weekly Bank Settlement Reconciliation
        </h4>
        <p style="font-size: 13px; color: #64748B; margin-bottom: 18px;">
            Net payouts remitted directly to the chemist partner's verified bank account after platform commission deduction.
        </p>

        <div class="table-responsive">
            <table class="table table-hover ledger-table">
                <thead>
                    <tr>
                        <th>Settlement Cycle</th>
                        <th>Gross Order Value</th>
                        <th>UPCHAR Platform Commission</th>
                        <th>Net Chemist Payout</th>
                        <th>Bank UTR / Ref Number</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($settlements)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 24px; color: #94A3B8;">
                                No bank settlements processed yet for this partner chemist. Next cycle reconciles on Sunday.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($settlements as $s): ?>
                        <tr>
                            <td><?=date('d M Y', strtotime($s['settlement_period_start']));?> &ndash; <?=date('d M Y', strtotime($s['settlement_period_end']));?></td>
                            <td>₹<?=number_format($s['gross_sales'], 2);?></td>
                            <td style="color: var(--red);">&ndash; ₹<?=number_format($s['upchar_commission'], 2);?></td>
                            <td><strong style="color: var(--green);">₹<?=number_format($s['net_payout'], 2);?></strong></td>
                            <td><code><?=htmlspecialchars($s['utr_number'] ?: 'Processing...');?></code></td>
                            <td>
                                <span class="label <?=$s['settlement_status']=='PROCESSED'?'label-success':'label-warning';?>">
                                    <?=$s['settlement_status'];?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Legal Compliance Disclaimer -->
<div class="legal-footer">
    <strong>STATUTORY INTERMEDIARY NOTICE:</strong> UPCHAR operates solely as a digital technology and delivery logistics intermediary platform under the Information Technology Act, 2000. All pharmaceutical inventory, storage, packaging, and dispensing are conducted exclusively by licensed partner chemist stores under the Drugs & Cosmetics Act, 1940.
</div>


