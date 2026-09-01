<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Razorpay Standard Checkout SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
    :root {
        --checkout-teal: #00a896;
        --checkout-teal-dark: #008f80;
        --checkout-teal-light: #f0fdfa;
        --checkout-navy: #1d2a44;
        --checkout-gold: #f59e0b;
        --checkout-gold-light: #fef3c7;
        --checkout-slate-900: #0f172a;
        --checkout-slate-800: #1e293b;
        --checkout-slate-600: #475569;
        --checkout-slate-100: #f8fafc;
        --checkout-border: #e2e8f0;
        --checkout-success: #10b981;
    }

    .unified-checkout-section {
        background: #f8fafc;
        padding: 35px 0 60px;
        min-height: 80vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .checkout-header-block {
        text-align: center;
        margin-bottom: 28px;
    }

    .checkout-header-block h1 {
        font-size: 26px;
        font-weight: 800;
        color: var(--checkout-navy);
        margin: 0 0 6px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .checkout-header-block p {
        color: var(--checkout-slate-600);
        margin: 0;
        font-size: 14.5px;
    }

    .badge-secure-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e6fffa;
        color: var(--checkout-teal-dark);
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 700;
        margin-top: 10px;
        border: 1px solid #b2f5ea;
    }

    .checkout-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid var(--checkout-border);
        margin-bottom: 20px;
    }

    .checkout-card-title {
        font-size: 17px;
        font-weight: 800;
        color: var(--checkout-slate-900);
        margin: 0 0 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 12px;
    }

    /* Order Summary Styles */
    .summary-line-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .summary-line-item .label {
        color: var(--checkout-slate-600);
        font-weight: 500;
    }

    .summary-line-item .value {
        font-weight: 700;
        color: var(--checkout-slate-900);
    }

    .summary-total-box {
        border-top: 2px dashed var(--checkout-border);
        padding-top: 14px;
        margin-top: 14px;
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .summary-total-box .label {
        font-size: 16px;
        font-weight: 800;
        color: var(--checkout-slate-900);
    }

    .summary-total-box .value {
        font-size: 24px;
        font-weight: 900;
        color: var(--checkout-teal);
    }

    /* Upchar Wallet Points Box */
    .wallet-points-redemption-box {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid #fde68a;
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 18px;
    }

    .wallet-box-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .wallet-box-title {
        font-size: 14px;
        font-weight: 700;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .wallet-balance-tag {
        font-size: 13px;
        font-weight: 700;
        color: #b45309;
        background: #ffffff;
        padding: 2px 8px;
        border-radius: 12px;
        border: 1px solid #fcd34d;
    }

    .points-slider {
        width: 100%;
        height: 6px;
        border-radius: 5px;
        background: #fde68a;
        outline: none;
        accent-color: var(--checkout-teal);
    }

    .points-usage-label {
        display: flex;
        justify-content: space-between;
        margin-top: 6px;
        font-size: 12.5px;
        font-weight: 600;
        color: #92400e;
    }

    .cashback-banner-box {
        background: #ecfdf5;
        border: 1px dashed #059669;
        color: #047857;
        padding: 10px 14px;
        border-radius: 8px;
        margin-top: 14px;
        font-size: 12.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Payment Methods */
    .pay-methods-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .pay-method-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 10px;
        border: 2px solid var(--checkout-border);
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pay-method-item:hover, .pay-method-item.active {
        border-color: var(--checkout-teal);
        background: #f0fdfa;
    }

    .pay-method-icon {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #f1f5f9;
        color: var(--checkout-teal);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .pay-method-item.active .pay-method-icon {
        background: var(--checkout-teal);
        color: #ffffff;
    }

    .pay-method-info {
        flex-grow: 1;
    }

    .pay-method-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--checkout-slate-900);
    }

    .pay-method-desc {
        font-size: 12px;
        color: var(--checkout-slate-600);
    }

    .btn-checkout-submit {
        background: var(--checkout-teal);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-size: 16px;
        font-weight: 800;
        width: 100%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(0, 168, 150, 0.3);
        transition: all 0.2s;
    }

    .btn-checkout-submit:hover {
        background: var(--checkout-teal-dark);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(0, 168, 150, 0.4);
    }

    .btn-checkout-submit:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    #checkout-error-alert {
        display: none;
        background: #fee2e2;
        border: 1px solid #f87171;
        color: #b91c1c;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: 13.5px;
        font-weight: 600;
    }
</style>

<div class="unified-checkout-section">
    <div class="container">
        
        <div class="checkout-header-block">
            <h1><i class="fa fa-shield" style="color: var(--checkout-teal);"></i> UPCHAR Secure Express Checkout</h1>
            <p>Complete your booking securely via UPI, Cards, Net Banking or Upchar Points</p>
            <div class="badge-secure-pill"><i class="fa fa-lock"></i> 256-Bit SSL Encrypted Healthcare Payment</div>
        </div>

        <div id="checkout-error-alert"></div>

        <div class="row">
            <!-- Left Column: Order Summary & Points -->
            <div class="col-md-6 col-sm-12">
                <div class="checkout-card">
                    <h2 class="checkout-card-title">
                        <i class="fa fa-file-text-o" style="color: var(--checkout-teal);"></i> Order Summary
                    </h2>

                    <div class="summary-line-item">
                        <span class="label">Service / Item:</span>
                        <span class="value"><?=htmlspecialchars($item_name);?></span>
                    </div>

                    <div class="summary-line-item">
                        <span class="label">Booking Ref:</span>
                        <span class="value">#<?=htmlspecialchars($reference_id ?: 'UPCH-' . rand(1000, 9999));?></span>
                    </div>

                    <div class="summary-line-item">
                        <span class="label">Patient Name:</span>
                        <span class="value"><?=htmlspecialchars(isset($user_data['NAME']) ? $user_data['NAME'] : 'Valued Patient');?></span>
                    </div>

                    <div class="summary-line-item">
                        <span class="label">Gross Amount:</span>
                        <span class="value">₹<?=number_format($amount, 2);?></span>
                    </div>

                    <?php if ($purpose !== 'WALLET_RECHARGE'): ?>
                        <!-- Upchar Points Redemption Widget for Appointments / Lab tests -->
                        <div class="wallet-points-redemption-box">
                            <div class="wallet-box-top">
                                <span class="wallet-box-title">
                                    <i class="fa fa-star" style="color: var(--checkout-gold);"></i> Redeem Upchar Points
                                </span>
                                <span class="wallet-balance-tag">
                                    Available: <strong id="lbl-avail-points"><?=number_format($user_points, 0);?></strong> Pts
                                </span>
                            </div>

                            <?php if ($user_points > 0): ?>
                                <?php 
                                    $max_points_applicable = min($user_points, ($point_ratio > 0 ? $amount / $point_ratio : $amount));
                                ?>
                                <div>
                                    <input type="range" id="points-slider" class="points-slider" 
                                           min="0" max="<?=(int)$max_points_applicable;?>" value="0" step="1" 
                                           oninput="updatePointsUsage(this.value)">
                                    <div class="points-usage-label">
                                        <span>Using: <strong id="lbl-points-used">0</strong> Pts</span>
                                        <span>Points Discount: <strong id="lbl-points-discount">₹0.00</strong></span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div style="font-size: 12px; color: #92400e;">
                                    No points in wallet. Earn <?=$cashback_pct;?>% cashback points on this booking!
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="summary-line-item" id="row-points-deduction" style="display: none; color: #059669;">
                            <span class="label">Upchar Points Applied:</span>
                            <span class="value" id="val-points-applied">- ₹0.00</span>
                        </div>
                    <?php endif; ?>

                    <div class="summary-total-box">
                        <span class="label">Net Payable Amount:</span>
                        <span class="value" id="val-net-payable">₹<?=number_format($amount, 2);?></span>
                    </div>

                    <?php if ($purpose === 'WALLET_RECHARGE'): ?>
                        <div class="cashback-banner-box">
                            <i class="fa fa-plus-circle" style="font-size: 18px; color: var(--checkout-teal);"></i>
                            <span>You will receive <strong><?=number_format($amount * ($point_ratio > 0 ? (1 / $point_ratio) : 1), 0);?> Upchar Points</strong> in your wallet instantly upon successful payment!</span>
                        </div>
                    <?php else: ?>
                        <div class="cashback-banner-box">
                            <i class="fa fa-gift" style="font-size: 18px; color: var(--checkout-teal);"></i>
                            <span>You will earn <strong><?=round($amount * ($cashback_pct / 100), 0);?> Upchar Cashback Points</strong> after completing this booking!</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column: Payment Method Selection & Checkout Trigger -->
            <div class="col-md-6 col-sm-12">
                <div class="checkout-card">
                    <h2 class="checkout-card-title">
                        <i class="fa fa-credit-card" style="color: var(--checkout-teal);"></i> Select Payment Method
                    </h2>

                    <div class="pay-methods-list">
                        <!-- Method 1: Razorpay Gateway (UPI, Cards, Net Banking) -->
                        <div class="pay-method-item active" id="method-card-gateway" onclick="selectMethod('GATEWAY')">
                            <div class="pay-method-icon"><i class="fa fa-qrcode"></i></div>
                            <div class="pay-method-info">
                                <div class="pay-method-title">Online Payment Gateway (Razorpay)</div>
                                <div class="pay-method-desc">UPI (GPay, PhonePe, Paytm), Cards &amp; Net Banking</div>
                            </div>
                            <input type="radio" name="pay_mode" id="rb-gateway" value="GATEWAY" checked style="accent-color: var(--checkout-teal);">
                        </div>

                        <?php if ($purpose !== 'WALLET_RECHARGE'): ?>
                        <!-- Method 2: 100% Upchar Wallet Points -->
                        <div class="pay-method-item" id="method-card-points" onclick="selectMethod('POINTS')" style="<?=($user_points * $point_ratio < $amount) ? 'opacity: 0.5;' : '';?>">
                            <div class="pay-method-icon" style="color: var(--checkout-gold);"><i class="fa fa-star"></i></div>
                            <div class="pay-method-info">
                                <div class="pay-method-title">100% Upchar Points</div>
                                <div class="pay-method-desc">Instant 1-Click zero-OTP checkout with wallet balance</div>
                            </div>
                            <input type="radio" name="pay_mode" id="rb-points" value="POINTS" <?=($user_points * $point_ratio < $amount) ? 'disabled' : '';?> style="accent-color: var(--checkout-teal);">
                        </div>
                        <?php endif; ?>
                    </div>

                    <button type="button" id="btn-submit-pay" class="btn-checkout-submit" onclick="handlePayAction()">
                        <i class="fa fa-lock"></i> <span id="btn-pay-text">Pay ₹<?=number_format($amount, 2);?> Securely</span>
                    </button>

                    <div style="display: flex; justify-content: space-around; margin-top: 20px; font-size: 11.5px; color: #64748b;">
                        <span><i class="fa fa-check-circle" style="color: var(--checkout-teal);"></i> RBI Authorized</span>
                        <span><i class="fa fa-bolt" style="color: var(--checkout-gold);"></i> Instant Credit</span>
                        <span><i class="fa fa-refresh" style="color: #0284c7;"></i> 100% Refund Guarantee</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const totalGrossAmount = <?=floatval($amount);?>;
    const userMaxPoints    = <?=floatval($user_points);?>;
    const pointRatio       = <?=floatval($point_ratio);?>;
    const orderPurpose     = '<?=addslashes($purpose);?>';
    const referenceId      = '<?=addslashes($reference_id);?>';
    const csrfName         = '<?=$this->security->get_csrf_token_name();?>';
    const csrfHash         = '<?=$this->security->get_csrf_hash();?>';

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
        if (pointsUsed > 0 && deductionRow) {
            deductionRow.style.display = 'flex';
            document.getElementById('val-points-applied').innerText = '- ₹' + discount.toFixed(2);
        } else if (deductionRow) {
            deductionRow.style.display = 'none';
        }

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
        const gwCard = document.getElementById('method-card-gateway');
        const ptCard = document.getElementById('method-card-points');
        const rbGw   = document.getElementById('rb-gateway');
        const rbPt   = document.getElementById('rb-points');

        if (mode === 'GATEWAY') {
            if (gwCard) gwCard.classList.add('active');
            if (ptCard) ptCard.classList.remove('active');
            if (rbGw) rbGw.checked = true;
        } else {
            if (ptCard) ptCard.classList.add('active');
            if (gwCard) gwCard.classList.remove('active');
            if (rbPt) rbPt.checked = true;
        }
    }

    function showCheckoutError(msg) {
        const alertBox = document.getElementById('checkout-error-alert');
        alertBox.innerHTML = '<i class="fa fa-exclamation-circle"></i> ' + msg;
        alertBox.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function handlePayAction() {
        const btn = document.getElementById('btn-submit-pay');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Initializing Payment Gateway...';

        const formData = new FormData();
        formData.append('amount', totalGrossAmount);
        formData.append('purpose', orderPurpose);
        formData.append('reference_id', referenceId);
        formData.append('wallet_points_to_use', pointsUsed);
        formData.append(csrfName, csrfHash);

        fetch('<?=base_url("payment/create_order");?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'points_only') {
                window.location.href = data.redirect_url;
            } else if (data.status === 'success') {
                // If local test mock order ID
                if (data.razorpay_order_id.startsWith('order_mock_')) {
                    // Automatically simulate success in test environment
                    const verifyData = new FormData();
                    verifyData.append('razorpay_order_id', data.razorpay_order_id);
                    verifyData.append('razorpay_payment_id', 'pay_mock_' + Math.random().toString(36).substring(2, 12));
                    verifyData.append('razorpay_signature', 'mock_signature_verified');
                    verifyData.append('internal_order_ref', data.internal_order_ref);
                    verifyData.append(csrfName, csrfHash);

                    fetch('<?=base_url("payment/verify");?>', {
                        method: 'POST',
                        body: verifyData
                    })
                    .then(r => r.json())
                    .then(v => {
                        if (v.status === 'success') {
                            window.location.href = v.redirect_url;
                        } else {
                            showCheckoutError(v.message || 'Verification failed.');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fa fa-lock"></i> Retry Payment';
                        }
                    });
                    return;
                }

                // Standard Live Razorpay Modal
                const options = {
                    key: data.key_id,
                    amount: data.amount_paise,
                    currency: 'INR',
                    name: 'UPCHAR Healthcare',
                    description: 'Payment for ' + orderPurpose + ' #' + referenceId,
                    order_id: data.razorpay_order_id,
                    image: '<?=base_url("images/logo.png");?>',
                    prefill: {
                        name: data.user_name,
                        email: data.user_email,
                        contact: data.user_mobile
                    },
                    theme: {
                        color: '#00a896'
                    },
                    handler: function(response) {
                        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Verifying Payment...';
                        const verifyData = new FormData();
                        verifyData.append('razorpay_order_id', response.razorpay_order_id);
                        verifyData.append('razorpay_payment_id', response.razorpay_payment_id);
                        verifyData.append('razorpay_signature', response.razorpay_signature);
                        verifyData.append('internal_order_ref', data.internal_order_ref);
                        verifyData.append(csrfName, csrfHash);

                        fetch('<?=base_url("payment/verify");?>', {
                            method: 'POST',
                            body: verifyData
                        })
                        .then(r => r.json())
                        .then(v => {
                            if (v.status === 'success') {
                                window.location.href = v.redirect_url;
                            } else {
                                showCheckoutError(v.message || 'Verification failed.');
                                btn.disabled = false;
                                btn.innerHTML = '<i class="fa fa-lock"></i> Retry Payment';
                            }
                        })
                        .catch(err => {
                            showCheckoutError('Network error during verification.');
                            btn.disabled = false;
                        });
                    },
                    modal: {
                        ondismiss: function() {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fa fa-lock"></i> Pay ₹' + netPayable.toFixed(2) + ' Securely';
                        }
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            } else {
                showCheckoutError(data.message || 'Unable to initialize order.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-lock"></i> Pay Securely';
            }
        })
        .catch(err => {
            showCheckoutError('Server communication error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-lock"></i> Pay Securely';
        });
    }
</script>
