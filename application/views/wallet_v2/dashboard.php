<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPCHAR Points Wallet & Rewards Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d7a6e;
            --primary-light: #14b8a6;
            --accent-gold: #f59e0b;
            --accent-gold-dark: #b45309;
            --bg-canvas: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --radius-lg: 16px;
            --radius-md: 10px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: var(--text-dark);
            margin: 0;
            padding: 30px 15px;
        }

        .wallet-container {
            max-width: 1050px;
            margin: 0 auto;
        }

        /* Top Hero Card */
        .wallet-hero {
            background: linear-gradient(135deg, #0d7a6e 0%, #064e3b 100%);
            border-radius: var(--radius-lg);
            padding: 32px;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px -10px rgba(13, 122, 110, 0.35);
            margin-bottom: 25px;
        }

        .wallet-hero::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.25) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }

        .hero-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .hero-title {
            font-size: 18px;
            font-weight: 600;
            color: #ccfbf1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-balance-val {
            font-size: 42px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 4px;
            display: flex;
            align-items: baseline;
            gap: 10px;
        }

        .hero-inr-equiv {
            font-size: 16px;
            color: #99f6e4;
            font-weight: 500;
        }

        .hero-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
            margin-top: 25px;
            border-top: 1px solid rgba(255,255,255,0.15);
            padding-top: 20px;
        }

        .hero-stat-item .stat-label {
            font-size: 13px;
            color: #99f6e4;
            margin-bottom: 4px;
        }

        .hero-stat-item .stat-val {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }

        /* 2-Column Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .card-header {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        /* Quick Recharge Buttons */
        .quick-amounts-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }

        .btn-amount {
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            color: var(--primary-dark);
            padding: 10px 8px;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
        }

        .btn-amount:hover, .btn-amount.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        .custom-recharge-input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 15px;
            font-family: inherit;
            box-sizing: border-box;
            margin-bottom: 16px;
        }

        .btn-recharge-submit {
            width: 100%;
            background: linear-gradient(135deg, #1ab5a0 0%, #0d7a6e 100%);
            color: #ffffff;
            border: none;
            padding: 14px;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-recharge-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 122, 110, 0.3);
        }

        /* Referral Card */
        .referral-box {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fde68a;
            border-radius: var(--radius-md);
            padding: 18px;
            text-align: center;
            margin-bottom: 16px;
        }

        .referral-code-display {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #92400e;
            background: #ffffff;
            border: 2px dashed #f59e0b;
            padding: 10px 18px;
            border-radius: 8px;
            display: inline-block;
            margin: 10px 0;
            cursor: pointer;
        }

        .share-btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-share {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-wa {
            background: #25d366;
            color: #ffffff;
        }

        .btn-copy {
            background: #ffffff;
            color: #1e293b;
            border: 1px solid #cbd5e1;
            cursor: pointer;
        }

        /* Transaction List */
        .txn-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .txn-table th {
            text-align: left;
            padding: 12px;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
        }

        .txn-table td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .badge-credit {
            color: #16a34a;
            font-weight: 700;
        }

        .badge-debit {
            color: #dc2626;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="wallet-container">
    <!-- Top Hero Section -->
    <div class="wallet-hero">
        <div class="hero-header">
            <span class="hero-title"><i class="fa-solid fa-wallet"></i> UPCHAR Points Wallet</span>
            <span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                1 Point = ₹<?php echo number_format($point_ratio, 2); ?>
            </span>
        </div>

        <div class="hero-balance-val">
            <span><?php echo number_format($wallet['points_balance'], 2); ?></span>
            <span style="font-size: 20px; color: #fde68a;">Points</span>
        </div>
        <div class="hero-inr-equiv">
            Equivalent Value: <strong>₹<?php echo number_format($wallet['currency_equivalent'], 2); ?></strong>
        </div>

        <div class="hero-stats-grid">
            <div class="hero-stat-item">
                <div class="stat-label">Lifetime Earned</div>
                <div class="stat-val">+<?php echo number_format($wallet['lifetime_earned'], 0); ?> Pts</div>
            </div>
            <div class="hero-stat-item">
                <div class="stat-label">Lifetime Redeemed</div>
                <div class="stat-val">-<?php echo number_format($wallet['lifetime_spent'], 0); ?> Pts</div>
            </div>
            <div class="hero-stat-item">
                <div class="stat-label">Cashback Rate</div>
                <div class="stat-val"><?php echo $cashback_pct; ?>% on All Bookings</div>
            </div>
        </div>
    </div>

    <!-- 2 Column: Recharge + Referral -->
    <div class="dashboard-grid">
        <!-- Quick Recharge -->
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-bolt" style="color: var(--primary);"></i> Instant Wallet Recharge
            </div>
            <form action="<?php echo base_url('payment/checkout'); ?>" method="GET">
                <input type="hidden" name="purpose" value="WALLET_RECHARGE">
                <input type="hidden" name="reference_id" value="RECHARGE-<?php echo time(); ?>">

                <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 8px;">
                    Select Top-Up Amount
                </label>
                <div class="quick-amounts-grid">
                    <div class="btn-amount" onclick="setRechargeAmount(100)">₹100</div>
                    <div class="btn-amount active" onclick="setRechargeAmount(250)">₹250</div>
                    <div class="btn-amount" onclick="setRechargeAmount(500)">₹500</div>
                    <div class="btn-amount" onclick="setRechargeAmount(1000)">₹1,000</div>
                </div>

                <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 6px;">
                    Or Enter Custom Amount (₹)
                </label>
                <input type="number" id="inp-recharge-amount" name="amount" class="custom-recharge-input" value="250" min="100" max="50000" required>

                <button type="submit" class="btn-recharge-submit">
                    <i class="fa-solid fa-credit-card"></i> Proceed to Add Money
                </button>
            </form>
        </div>

        <!-- Refer & Earn -->
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-gift" style="color: var(--accent-gold);"></i> Refer Friends & Earn Points
            </div>
            <div class="referral-box">
                <div style="font-size: 13px; color: #92400e; font-weight: 600;">YOUR EXCLUSIVE REFERRAL CODE</div>
                <div class="referral-code-display" id="ref-code-text" onclick="copyRefCode()" title="Click to copy">
                    <?php echo htmlspecialchars($referral_code ?: 'UPCH-EARN-50'); ?>
                </div>
                <div style="font-size: 12px; color: #92400e; margin-bottom: 12px;">
                    Invite a friend — they get <strong>25 Free Points</strong> and you get <strong>50 Points</strong> on their first consultation!
                </div>
                <div class="share-btn-group">
                    <a href="https://api.whatsapp.com/send?text=Join%20UPCHAR%20Healthcare%20using%20my%20code%20<?php echo $referral_code; ?>%20and%20get%2025%20free%20Upchar%20Points!%20<?php echo urlencode(base_url('sign_up?ref=' . $referral_code)); ?>" target="_blank" class="btn-share btn-wa">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </a>
                    <button type="button" class="btn-share btn-copy" onclick="copyRefCode()">
                        <i class="fa-solid fa-copy"></i> <span id="copy-btn-text">Copy Code</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-clock-rotate-left" style="color: var(--primary);"></i> Transaction Ledger & Statement
        </div>
        <div style="overflow-x: auto;">
            <table class="txn-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Txn Ref</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Points</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td style="color: var(--text-muted);"><?php echo date('d M Y, h:i A', strtotime($t['created_at'])); ?></td>
                            <td><code><?php echo htmlspecialchars($t['txn_ref']); ?></code></td>
                            <td>
                                <span class="<?php echo ($t['type'] === 'CREDIT') ? 'badge-credit' : 'badge-debit'; ?>">
                                    <?php echo ($t['type'] === 'CREDIT') ? '<i class="fa-solid fa-arrow-down"></i> CREDIT' : '<i class="fa-solid fa-arrow-up"></i> DEBIT'; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($t['description']); ?></td>
                            <td class="<?php echo ($t['type'] === 'CREDIT') ? 'badge-credit' : 'badge-debit'; ?>">
                                <?php echo ($t['type'] === 'CREDIT') ? '+' : '-'; ?><?php echo number_format($t['amount_points'], 2); ?> Pts
                            </td>
                            <td style="font-weight: 600;"><?php echo number_format($t['balance_after'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                No transactions recorded yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function setRechargeAmount(amt) {
        document.getElementById('inp-recharge-amount').value = amt;
        document.querySelectorAll('.btn-amount').forEach(el => el.classList.remove('active'));
        event.target.classList.add('active');
    }

    function copyRefCode() {
        const code = document.getElementById('ref-code-text').innerText.trim();
        navigator.clipboard.writeText(code).then(() => {
            document.getElementById('copy-btn-text').innerText = 'Copied!';
            setTimeout(() => {
                document.getElementById('copy-btn-text').innerText = 'Copy Code';
            }, 2000);
        });
    }
</script>

</body>
</html>
