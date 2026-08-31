<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPCHAR Secure Payment Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d7a6e;
            --primary-light: #14b8a6;
            --primary-dark: #064e3b;
            --accent-gold: #f59e0b;
            --accent-gold-light: #fef3c7;
            --bg-canvas: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --success: #10b981;
            --radius-lg: 16px;
            --radius-md: 10px;
            --shadow-card: 0 10px 30px -5px rgba(13, 122, 110, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
            --shadow-glow: 0 0 25px rgba(20, 184, 166, 0.25);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0fdfa 0%, #f8fafc 50%, #e6fffa 100%);
            color: var(--text-dark);
            margin: 0;
            padding: 40px 15px;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .checkout-wrapper {
            max-width: 960px;
            margin: 0 auto;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .checkout-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .checkout-header p {
            color: var(--text-muted);
            margin: 0;
            font-size: 15px;
        }

        .badge-secure {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e6fffa;
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
            border: 1px solid #b2f5ea;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        @media (max-width: 768px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            padding: 26px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 12px;
        }

        .card-title i {
            color: var(--primary);
        }

        /* Order Summary Styles */
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
            font-size: 15px;
        }

        .summary-item .label {
            color: var(--text-muted);
        }

        .summary-item .value {
            font-weight: 600;
            color: var(--text-dark);
        }

        .summary-total {
            border-top: 2px dashed var(--border-color);
            padding-top: 16px;
            margin-top: 16px;
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .summary-total .label {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .summary-total .value {
            font-size: 26px;
            font-weight: 800;
            color: var(--primary);
        }

        /* Upchar Wallet Points Box */
        .wallet-box {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fde68a;
            border-radius: var(--radius-md);
            padding: 16px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
        }

        .wallet-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .wallet-box-title {
            font-size: 15px;
            font-weight: 700;
            color: #92400e;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .wallet-balance-tag {
            font-size: 14px;
            font-weight: 700;
            color: #b45309;
            background: #ffffff;
            padding: 3px 10px;
            border-radius: 12px;
            border: 1px solid #fcd34d;
        }

        .points-slider-container {
            margin-top: 12px;
        }

        .points-slider {
            width: 100%;
            height: 6px;
            border-radius: 5px;
            background: #fde68a;
            outline: none;
            accent-color: var(--accent-gold);
            cursor: pointer;
        }

        .points-usage-label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #92400e;
            margin-top: 6px;
            font-weight: 500;
        }

        /* Payment Method Options */
        .payment-methods-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }

        .method-card {
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .method-card:hover {
            border-color: var(--primary-light);
            background: #f0fdfa;
        }

        .method-card.active {
            border-color: var(--primary);
            background: #f0fdfa;
            box-shadow: 0 0 0 1px var(--primary);
        }

        .method-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #e6fffa;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .method-card.active .method-icon {
            background: var(--primary);
            color: #ffffff;
        }

        .method-info {
            flex-grow: 1;
        }

        .method-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .method-desc {
            font-size: 13px;
            color: var(--text-muted);
        }

        .method-radio {
            accent-color: var(--primary);
            transform: scale(1.2);
        }

        /* CTA Button */
        .btn-pay {
            width: 100%;
            background: linear-gradient(135deg, #1ab5a0 0%, #0d7a6e 100%);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-md);
            padding: 16px 20px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(13, 122, 110, 0.25);
        }

        .btn-pay:hover {
            background: linear-gradient(135deg, #14b8a6 0%, #064e3b 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 122, 110, 0.35);
        }

        .btn-pay:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .cashback-badge {
            background: #ecfdf5;
            border: 1px dashed #059669;
            color: #047857;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            margin-top: 16px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 24px;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
        }

        .trust-badges span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        #error-alert {
            display: none;
            background: #fee2e2;
            border: 1px solid #f87171;
            color: #b91c1c;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            margin-bottom: 16px;
            font-size: 14px;
        }
    </style>
    <!-- Razorpay Standard Checkout SDK -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>

<div class="checkout-wrapper">
    <div class="checkout-header">
        <h1><i class="fa-solid fa-shield-halved"></i> UPCHAR Express Checkout</h1>
        <p>Complete your booking securely via UPI, Cards, Net Banking or Upchar Points</p>
        <div class="badge-secure"><i class="fa-solid fa-lock"></i> 256-Bit SSL Encrypted Payment</div>
    </div>

    <div id="error-alert"></div>

    <div class="checkout-grid">
        <!-- Left: Order Summary & Points Slider -->
        <div class="card">
            <h2 class="card-title"><i class="fa-solid fa-file-invoice"></i> Order Summary</h2>

            <div class="summary-item">
                <span class="label">Service / Item:</span>
                <span class="value"><?php echo htmlspecialchars($item_name); ?></span>
            </div>

            <div class="summary-item">
                <span class="label">Booking Ref:</span>
                <span class="value">#<?php echo htmlspecialchars($reference_id ?: 'UPCH-' . rand(1000, 9999)); ?></span>
            </div>

            <div class="summary-item">
                <span class="label">Patient Name:</span>
                <span class="value"><?php echo htmlspecialchars(isset($user_data['NAME']) ? $user_data['NAME'] : 'Valued Patient'); ?></span>
            </div>

            <div class="summary-item">
                <span class="label">Gross Bill Amount:</span>
                <span class="value">₹<?php echo number_format($amount, 2); ?></span>
            </div>

            <!-- Upchar Points Redemption Widget -->
            <div class="wallet-box">
                <div class="wallet-box-header">
                    <span class="wallet-box-title">
                        <i class="fa-solid fa-coins" style="color: var(--accent-gold);"></i> Redeem Upchar Points
                    </span>
                    <span class="wallet-balance-tag">
                        Available: <strong id="lbl-avail-points"><?php echo number_format($user_points, 0); ?></strong> Pts
                    </span>
                </div>

                <?php if ($user_points > 0): ?>
                    <?php 
                        $max_points_applicable = min($user_points, $amount / $point_ratio);
                    ?>
                    <div class="points-slider-container">
                        <input type="range" id="points-slider" class="points-slider" 
                               min="0" max="<?php echo (int)$max_points_applicable; ?>" value="0" step="1" 
                               oninput="updatePointsUsage(this.value)">
                        <div class="points-usage-label">
                            <span>Using: <strong id="lbl-points-used">0</strong> Pts</span>
                            <span>Points Discount: <strong id="lbl-points-discount">₹0.00</strong></span>
                        </div>
                    </div>
                <?php else: ?>
                    <div style="font-size: 12px; color: #92400e;">
                        No points currently in wallet. Earn <?php echo $cashback_pct; ?>% cashback points on this order!
                    </div>
                <?php endif; ?>
            </div>

            <div class="summary-item" id="row-points-deduction" style="display: none; color: #059669;">
                <span class="label">Upchar Points Applied:</span>
                <span class="value" id="val-points-applied">- ₹0.00</span>
            </div>

            <div class="summary-total">
                <span class="label">Net Payable Amount:</span>
                <span class="value" id="val-net-payable">₹<?php echo number_format($amount, 2); ?></span>
            </div>

            <div class="cashback-badge">
                <i class="fa-solid fa-gift"></i>
                <span>You will earn <strong><?php echo round($amount * ($cashback_pct / 100), 0); ?> Upchar Cashback Points</strong> after payment!</span>
            </div>
        </div>

        <!-- Right: Payment Method & Action Trigger -->
        <div class="card">
            <h2 class="card-title"><i class="fa-solid fa-credit-card"></i> Select Payment Method</h2>

            <div class="payment-methods-grid">
                <!-- Method 1: Razorpay Gateway (UPI, Cards, Net Banking) -->
                <div class="method-card active" id="method-card-gateway" onclick="selectMethod('GATEWAY')">
                    <div class="method-icon"><i class="fa-solid fa-qrcode"></i></div>
                    <div class="method-info">
                        <div class="method-title">Razorpay Standard Gateway</div>
                        <div class="method-desc">UPI (GPay, PhonePe, Paytm), Credit/Debit Card, Net Banking</div>
                    </div>
                    <input type="radio" name="pay_mode" id="rb-gateway" value="GATEWAY" class="method-radio" checked>
                </div>

                <!-- Method 2: 100% Upchar Wallet Points (Active only if full points used) -->
                <div class="method-card" id="method-card-points" onclick="selectMethod('POINTS')" style="<?php echo ($user_points * $point_ratio < $amount) ? 'opacity: 0.5;' : ''; ?>">
                    <div class="method-icon" style="background: #fffbeb; color: var(--accent-gold);"><i class="fa-solid fa-wallet"></i></div>
                    <div class="method-info">
                        <div class="method-title">100% Upchar Points</div>
                        <div class="method-desc">Instant confirmation with zero gateway fees</div>
                    </div>
                    <input type="radio" name="pay_mode" id="rb-points" value="POINTS" class="method-radio" <?php echo ($user_points * $point_ratio < $amount) ? 'disabled' : ''; ?>>
                </div>
            </div>

            <button type="button" id="btn-submit-pay" class="btn-pay" onclick="handlePayAction()">
                <i class="fa-solid fa-lock"></i> <span id="btn-pay-text">Pay ₹<?php echo number_format($amount, 2); ?> Securely</span>
            </button>

            <div class="trust-badges">
                <span><i class="fa-solid fa-shield-check" style="color: var(--success);"></i> RBI Authorized</span>
                <span><i class="fa-solid fa-bolt" style="color: var(--accent-gold);"></i> Instant Confirmation</span>
                <span><i class="fa-solid fa-rotate-left" style="color: var(--primary);"></i> 100% Refund Guarantee</span>
            </div>
        </div>
    </div>
</div>

<script>
    const totalGrossAmount = <?php echo floatval($amount); ?>;
    const userMaxPoints    = <?php echo floatval($user_points); ?>;
    const pointRatio       = <?php echo floatval($point_ratio); ?>;
    const orderPurpose     = '<?php echo addslashes($purpose); ?>';
    const referenceId      = '<?php echo addslashes($reference_id); ?>';

    let pointsUsed = 0;
    let netPayable = totalGrossAmount;
    let selectedMode = 'GATEWAY';

    function updatePointsUsage(val) {
        pointsUsed = parseFloat(val) || 0;
        const discount = pointsUsed * pointRatio;
        netPayable = Math.max(0, totalGrossAmount - discount);

        document.getElementById('lbl-points-used').innerText = pointsUsed;
        document.getElementById('lbl-points-discount').innerText = '₹' + discount.toFixed(2);
        document.getElementById('val-net-payable').innerText = '₹' + netPayable.toFixed(2);

        const deductionRow = document.getElementById('row-points-deduction');
        if (pointsUsed > 0) {
            deductionRow.style.display = 'flex';
            document.getElementById('val-points-applied').innerText = '- ₹' + discount.toFixed(2);
        } else {
            deductionRow.style.display = 'none';
        }

        // Auto-switch payment mode if 100% points
        if (netPayable === 0) {
            selectMethod('POINTS');
        } else {
            selectMethod('GATEWAY');
        }

        document.getElementById('btn-pay-text').innerText = (netPayable === 0) 
            ? 'Pay with ' + pointsUsed + ' Upchar Points' 
            : 'Pay ₹' + netPayable.toFixed(2) + ' Securely';
    }

    function selectMethod(mode) {
        selectedMode = mode;
        if (mode === 'GATEWAY') {
            document.getElementById('method-card-gateway').classList.add('active');
            document.getElementById('method-card-points').classList.remove('active');
            document.getElementById('rb-gateway').checked = true;
        } else {
            document.getElementById('method-card-points').classList.add('active');
            document.getElementById('method-card-gateway').classList.remove('active');
            document.getElementById('rb-points').checked = true;
        }
    }

    function showError(msg) {
        const alertBox = document.getElementById('error-alert');
        alertBox.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + msg;
        alertBox.style.display = 'block';
    }

    function handlePayAction() {
        const btn = document.getElementById('btn-submit-pay');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Initializing Secure Gateway...';

        const formData = new FormData();
        formData.append('amount', totalGrossAmount);
        formData.append('purpose', orderPurpose);
        formData.append('reference_id', referenceId);
        formData.append('wallet_points_to_use', pointsUsed);

        fetch('<?php echo base_url("payment/create_order"); ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'points_only') {
                window.location.href = data.redirect_url;
            } else if (data.status === 'success') {
                // Trigger Razorpay Modal
                const options = {
                    key: data.key_id,
                    amount: data.amount_paise,
                    currency: 'INR',
                    name: 'UPCHAR Healthcare',
                    description: 'Payment for ' + orderPurpose + ' #' + referenceId,
                    order_id: data.razorpay_order_id,
                    image: '<?php echo base_url("images/logo.png"); ?>',
                    prefill: {
                        name: data.user_name,
                        email: data.user_email,
                        contact: data.user_mobile
                    },
                    theme: {
                        color: '#0d7a6e'
                    },
                    handler: function(response) {
                        // Verify on server
                        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Verifying Payment...';
                        const verifyData = new FormData();
                        verifyData.append('razorpay_order_id', response.razorpay_order_id);
                        verifyData.append('razorpay_payment_id', response.razorpay_payment_id);
                        verifyData.append('razorpay_signature', response.razorpay_signature);
                        verifyData.append('internal_order_ref', data.internal_order_ref);

                        fetch('<?php echo base_url("payment/verify"); ?>', {
                            method: 'POST',
                            body: verifyData
                        })
                        .then(r => r.json())
                        .then(v => {
                            if (v.status === 'success') {
                                window.location.href = v.redirect_url;
                            } else {
                                showError(v.message || 'Verification failed.');
                                btn.disabled = false;
                                btn.innerHTML = '<i class="fa-solid fa-lock"></i> Retry Payment';
                            }
                        })
                        .catch(err => {
                            showError('Network error during verification.');
                            btn.disabled = false;
                        });
                    },
                    modal: {
                        ondismiss: function() {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fa-solid fa-lock"></i> Pay ₹' + netPayable.toFixed(2) + ' Securely';
                        }
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            } else {
                showError(data.message || 'Unable to initialize order.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock"></i> Pay Securely';
            }
        })
        .catch(err => {
            showError('Server communication error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-lock"></i> Pay Securely';
        });
    }
</script>

</body>
</html>
