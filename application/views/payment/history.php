<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Patient Topbar Header -->
<div class="patient-topbar">
    <div>
        <h2 class="patient-topbar-title">Payments, Invoices &amp; Wallet Hub</h2>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13.5px;">
            Track your appointment invoices, diagnostic test receipts, Upchar Points ledger, and instant refunds.
        </p>
    </div>
    <div>
        <a href="<?=base_url('wallet');?>" class="btn" style="background: var(--upchar-teal); color: #ffffff; font-weight: 700; border-radius: 8px; padding: 9px 18px; font-size: 13px; text-decoration: none; box-shadow: 0 4px 10px rgba(0,168,150,0.25);">
            <i class="fa fa-google-wallet" style="margin-right: 6px;"></i> Top-Up Points
        </a>
    </div>
</div>

<!-- Flash Alert Messages -->
<?php if($this->session->flashdata('flashmsg')): ?>
    <div style="margin-bottom: 20px;">
        <?=$this->session->flashdata('flashmsg');?>
    </div>
<?php endif; ?>

<style>
    /* Metric Cards Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .metric-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .metric-lbl {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Referral Widget Box */
    .referral-widget-box {
        background: linear-gradient(135deg, #1d2a44 0%, #0f172a 100%);
        border-radius: 14px;
        padding: 22px 24px;
        color: #ffffff;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .referral-code-badge {
        background: rgba(255, 255, 255, 0.15);
        border: 1px dashed rgba(255, 255, 255, 0.4);
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 17px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #fcd34d;
        cursor: pointer;
    }

    /* Tabs Component */
    .hub-tabs-nav {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 20px;
        overflow-x: auto;
    }

    .hub-tab-btn {
        padding: 11px 20px;
        font-size: 14px;
        font-weight: 700;
        color: #64748b;
        border: none;
        background: transparent;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .hub-tab-btn:hover, .hub-tab-btn.active {
        color: var(--upchar-teal);
        border-bottom-color: var(--upchar-teal);
    }

    .hub-tab-content {
        display: none;
    }
    .hub-tab-content.active {
        display: block;
    }

    /* Card & Table */
    .hub-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        padding: 22px;
        margin-bottom: 25px;
    }

    .hub-table-wrap {
        overflow-x: auto;
    }

    .hub-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .hub-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .hub-table td {
        padding: 14px 16px;
        font-size: 13.5px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .hub-table tr:hover td {
        background: #f8fafc;
    }

    /* Badges */
    .badge-status {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-paid { background: #dcfce7; color: #15803d; }
    .badge-created { background: #fef3c7; color: #b45309; }
    .badge-failed { background: #fee2e2; color: #b91c1c; }
    .badge-refunded { background: #e0f2fe; color: #0369a1; }
</style>

<!-- Metric Cards Grid -->
<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon" style="background: #f0fdfa; color: var(--upchar-teal);">
            <i class="fa fa-star"></i>
        </div>
        <div>
            <div class="metric-val"><?=number_format(isset($wallet['points_balance']) ? $wallet['points_balance'] : 0, 2);?></div>
            <div class="metric-lbl">Available Points (₹<?=number_format(isset($wallet['currency_equivalent']) ? $wallet['currency_equivalent'] : 0, 2);?>)</div>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-icon" style="background: #ecfdf5; color: #10b981;">
            <i class="fa fa-credit-card"></i>
        </div>
        <div>
            <div class="metric-val"><?=count($orders);?></div>
            <div class="metric-lbl">Total Orders &amp; Invoices</div>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-icon" style="background: #fef3c7; color: #f59e0b;">
            <i class="fa fa-gift"></i>
        </div>
        <div>
            <div class="metric-val">+<?=number_format(isset($wallet['lifetime_earned']) ? $wallet['lifetime_earned'] : 0, 2);?></div>
            <div class="metric-lbl">Lifetime Points Earned</div>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-icon" style="background: #e0f2fe; color: #0284c7;">
            <i class="fa fa-users"></i>
        </div>
        <div>
            <div class="metric-val"><?=isset($referral_stats['total_invites']) ? $referral_stats['total_invites'] : 0;?></div>
            <div class="metric-lbl">Friends Referred (+<?=isset($referral_stats['total_points_earned']) ? $referral_stats['total_points_earned'] : 0;?> Pts)</div>
        </div>
    </div>
</div>

<!-- Referral Code Banner -->
<div class="referral-widget-box">
    <div>
        <h3 style="margin: 0 0 4px; font-size: 16px; font-weight: 800; color: #ffffff;">
            <i class="fa fa-bullhorn" style="color: #f59e0b; margin-right: 6px;"></i> Invite Friends &amp; Earn Free Upchar Points
        </h3>
        <p style="margin: 0; font-size: 13px; color: #94a3b8;">
            Share your unique code. When your friend signs up and books their first appointment, you both get reward points!
        </p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <span class="referral-code-badge" id="refCodeText" onclick="copyRefCode()" title="Click to copy">
            <?=isset($referral_stats['referral_code']) ? $referral_stats['referral_code'] : 'UPCH-0000';?>
        </span>
        <button type="button" class="btn btn-sm btn-outline-light" onclick="copyRefCode()" style="border-radius: 6px; font-weight: 700; border: 1px solid rgba(255,255,255,0.4); color: #ffffff; background: transparent; padding: 7px 14px;">
            <i class="fa fa-copy"></i> Copy
        </button>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="hub-tabs-nav">
    <button class="hub-tab-btn active" id="btn-tab-orders" onclick="switchHubTab('tab-orders', this)">
        <i class="fa fa-file-text-o"></i> Orders &amp; Invoices (<?=count($orders);?>)
    </button>
    <button class="hub-tab-btn" id="btn-tab-ledger" onclick="switchHubTab('tab-ledger', this)">
        <i class="fa fa-history"></i> Points Ledger (<?=count($transactions);?>)
    </button>
    <button class="hub-tab-btn" id="btn-tab-refunds" onclick="switchHubTab('tab-refunds', this)">
        <i class="fa fa-undo"></i> Refunds (<?=count($refunds);?>)
    </button>
</div>

<!-- Tab 1: Orders & Invoices -->
<div class="hub-tab-content active" id="tab-orders">
    <div class="hub-card">
        <div class="hub-table-wrap">
            <table class="hub-table">
                <thead>
                    <tr>
                        <th>Order Ref &amp; Date</th>
                        <th>Purpose / Service</th>
                        <th>Gross Amount</th>
                        <th>Payment Split</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $o): 
                            $st = $o['status'];
                            $badgeClass = ($st === 'PAID') ? 'badge-paid' : (($st === 'FAILED') ? 'badge-failed' : (($st === 'REFUNDED') ? 'badge-refunded' : 'badge-created'));
                        ?>
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                    <?=$o['internal_order_ref'];?>
                                </div>
                                <small style="color: #64748b;">
                                    <?=date('d M Y, h:i A', strtotime($o['created_at']));?>
                                </small>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">
                                    <?=htmlspecialchars($o['purpose']);?>
                                </div>
                                <?php if (!empty($o['reference_id'])): ?>
                                    <small style="color: #0284c7;">Ref #<?=htmlspecialchars($o['reference_id']);?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong style="color: #0f172a; font-size: 14px;">₹<?=number_format($o['amount'], 2);?></strong>
                            </td>
                            <td>
                                <div style="font-size: 12.5px;">
                                    <?php if ($o['wallet_points_used'] > 0): ?>
                                        <span style="color: #d97706; font-weight: 600;">-<?=number_format($o['wallet_points_used'], 0);?> Pts</span> + 
                                    <?php endif; ?>
                                    <span style="color: #00a896; font-weight: 600;">₹<?=number_format($o['gateway_amount'], 2);?> Online</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-status <?=$badgeClass;?>">
                                    <i class="fa <?=$st === 'PAID' ? 'fa-check-circle' : ($st === 'FAILED' ? 'fa-times-circle' : 'fa-clock-o');?>"></i>
                                    <?=$st;?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <?php if ($st === 'PAID'): ?>
                                    <a href="<?=base_url('payment/success/' . $o['internal_order_ref']);?>" class="btn btn-xs btn-default" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1; padding: 4px 10px;">
                                        <i class="fa fa-file-text-o"></i> Receipt
                                    </a>
                                <?php else: ?>
                                    <a href="<?=base_url('payment/checkout?purpose=' . $o['purpose'] . '&reference_id=' . $o['reference_id'] . '&amount=' . $o['amount']);?>" class="btn btn-xs" style="background: var(--upchar-teal); color: #ffffff; font-weight: 600; border-radius: 6px; padding: 4px 10px; text-decoration: none;">
                                        Pay Now
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                <i class="fa fa-credit-card" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                No payment orders recorded yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab 2: Points Ledger -->
<div class="hub-tab-content" id="tab-ledger">
    <div class="hub-card">
        <div class="hub-table-wrap">
            <table class="hub-table">
                <thead>
                    <tr>
                        <th>Date &amp; Ref</th>
                        <th>Description / Source</th>
                        <th>Type</th>
                        <th style="text-align: right;">Points Delta</th>
                        <th style="text-align: right;">Balance After</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $txn): 
                            $isCredit = ($txn['type'] === 'CREDIT');
                        ?>
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">
                                    <?=date('d M Y', strtotime($txn['created_at']));?>
                                </div>
                                <small style="color: #64748b; font-family: monospace;">
                                    <?=$txn['txn_ref'];?>
                                </small>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">
                                    <?=htmlspecialchars($txn['description'] ?: $txn['source']);?>
                                </div>
                                <?php if (!empty($txn['reference_id'])): ?>
                                    <small style="color: #0284c7;">Ref #<?=htmlspecialchars($txn['reference_id']);?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="<?=$isCredit ? 'badge-status badge-paid' : 'badge-status badge-failed';?>">
                                    <?=$txn['type'];?>
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 800; font-size: 14px; color: <?=$isCredit ? '#15803d' : '#b91c1c';?>;">
                                <?=$isCredit ? '+' : '-';?><?=number_format($txn['amount_points'], 2);?>
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #334155;">
                                <?=number_format($txn['balance_after'], 2);?> Pts
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                <i class="fa fa-star-o" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                No point transactions recorded yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab 3: Refunds -->
<div class="hub-tab-content" id="tab-refunds">
    <div class="hub-card">
        <div class="hub-table-wrap">
            <table class="hub-table">
                <thead>
                    <tr>
                        <th>Refund Ref &amp; Date</th>
                        <th>Original Order</th>
                        <th>Amount</th>
                        <th>Destination</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($refunds)): ?>
                        <?php foreach ($refunds as $r): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;"><?=$r['refund_ref'];?></div>
                                <small style="color: #64748b;"><?=date('d M Y, h:i A', strtotime($r['created_at']));?></small>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;"><?=$r['original_order_ref'];?></div>
                                <small style="color: #64748b;"><?=htmlspecialchars($r['reason']);?></small>
                            </td>
                            <td>
                                <strong style="color: #15803d; font-size: 14px;">₹<?=number_format($r['refund_amount'], 2);?></strong>
                            </td>
                            <td>
                                <span class="badge-status badge-paid"><?=$r['refund_to'];?></span>
                            </td>
                            <td>
                                <span class="badge-status badge-paid"><?=$r['status'];?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                <i class="fa fa-smile-o" style="font-size: 32px; display: block; margin-bottom: 8px; color: #00a896;"></i>
                                No refund requests recorded.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function switchHubTab(tabId, btn) {
    document.querySelectorAll('.hub-tab-content').forEach(function(el) {
        el.classList.remove('active');
    });
    document.querySelectorAll('.hub-tab-btn').forEach(function(el) {
        el.classList.remove('active');
    });
    var target = document.getElementById(tabId);
    if (target) target.classList.add('active');
    if (btn) btn.classList.add('active');
}

function copyRefCode() {
    var code = document.getElementById('refCodeText').innerText.trim();
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(code).then(function() {
            alert('Referral code "' + code + '" copied to clipboard!');
        }).catch(function() {
            prompt('Copy your referral code:', code);
        });
    } else {
        prompt('Copy your referral code:', code);
    }
}
</script>
