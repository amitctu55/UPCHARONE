<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Google Fonts & Font Awesome CDN -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --upchar-teal: #0d7a6e;
        --upchar-teal-dark: #095950;
        --upchar-mint: #00a896;
        --upchar-emerald: #10b981;
        --upchar-slate: #0f172a;
        --upchar-muted: #64748b;
        --upchar-light: #f8fafc;
        --upchar-border: #e2e8f0;
    }

    body {
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
        background: #f1f5f9;
        color: #1e293b;
    }

    .order-success-page-wrapper {
        background: linear-gradient(180deg, #ecfdf5 0%, #f1f5f9 260px, #f8fafc 100%);
        padding: 40px 15px 80px;
        min-height: 85vh;
    }

    .order-success-container {
        max-width: 960px;
        margin: 0 auto;
    }

    /* Hero Banner */
    .success-hero-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 35px -5px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(0, 168, 150, 0.08);
        padding: 36px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .success-hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #0d7a6e 0%, #00a896 50%, #10b981 100%);
    }

    .success-badge-pulse {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        box-shadow: 0 0 0 10px rgba(220, 252, 231, 0.5);
        animation: pulseRing 2.4s infinite ease-in-out;
    }

    @keyframes pulseRing {
        0%, 100% { box-shadow: 0 0 0 8px rgba(220, 252, 231, 0.5); transform: scale(1); }
        50% { box-shadow: 0 0 0 16px rgba(220, 252, 231, 0.15); transform: scale(1.03); }
    }

    .success-badge-pulse i {
        font-size: 38px;
        color: #15803d;
    }

    .success-main-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin: 0 0 8px;
    }

    .success-sub-title {
        color: #64748b;
        font-size: 14.5px;
        max-width: 580px;
        margin: 0 auto 20px;
        line-height: 1.5;
    }

    .order-ref-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13.5px;
        color: #334155;
    }

    .order-ref-pill strong {
        color: #0f172a;
        font-family: monospace;
        font-size: 14.5px;
    }

    .copy-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #0d7a6e;
        padding: 0;
        font-size: 13px;
        transition: color 0.2s;
    }
    .copy-btn:hover { color: #095950; }

    /* Journey / Status Tracker */
    .order-tracker-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 22px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .tracker-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 15px 0 5px;
    }

    .tracker-steps::before {
        content: '';
        position: absolute;
        top: 18px;
        left: 40px;
        right: 40px;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }

    .tracker-step-item {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }

    .step-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #cbd5e1;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        margin-bottom: 8px;
        transition: all 0.2s;
    }

    .tracker-step-item.completed .step-icon-circle {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
    }

    .tracker-step-item.active .step-icon-circle {
        background: #0d7a6e;
        border-color: #0d7a6e;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(13, 122, 110, 0.2);
    }

    .step-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        display: block;
    }

    .tracker-step-item.completed .step-label,
    .tracker-step-item.active .step-label {
        color: #0f172a;
        font-weight: 700;
    }

    /* 2 Column Details Grid */
    .success-grid {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 768px) {
        .success-grid {
            grid-template-columns: 1fr;
        }
    }

    .card-panel {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
        margin-bottom: 18px;
    }

    .panel-header h3 {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .panel-header h3 i {
        color: #0d7a6e;
    }

    .item-list-box {
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    .item-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .item-desc-text {
        font-size: 12.5px;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
    }

    .key-val-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        padding: 8px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .key-val-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .key-val-lbl {
        color: #64748b;
    }

    .key-val-data {
        color: #0f172a;
        font-weight: 600;
        text-align: right;
    }

    .amount-grand-row {
        background: linear-gradient(135deg, #0d7a6e 0%, #00a896 100%);
        color: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 18px;
        box-shadow: 0 6px 18px rgba(13, 122, 110, 0.25);
    }

    .amount-grand-lbl {
        font-size: 14px;
        font-weight: 600;
        opacity: 0.95;
    }

    .amount-grand-val {
        font-size: 22px;
        font-weight: 800;
    }

    /* Loyalty Cashback Card */
    .loyalty-reward-card {
        background: #fffbeb;
        border: 1px dashed #f59e0b;
        border-radius: 12px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .loyalty-reward-card i {
        font-size: 24px;
        color: #d97706;
    }

    .loyalty-reward-text h5 {
        margin: 0 0 2px;
        font-size: 14px;
        font-weight: 700;
        color: #92400e;
    }

    .loyalty-reward-text p {
        margin: 0;
        font-size: 12px;
        color: #b45309;
    }

    /* Action Buttons Bar */
    .action-button-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 24px;
    }

    .btn-upchar-primary {
        background: #0d7a6e;
        color: #ffffff !important;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none !important;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(13, 122, 110, 0.25);
    }

    .btn-upchar-primary:hover {
        background: #095950;
        transform: translateY(-2px);
    }

    .btn-upchar-outline {
        background: #ffffff;
        color: #334155 !important;
        border: 1px solid #cbd5e1;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none !important;
        transition: all 0.2s;
    }

    .btn-upchar-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a !important;
        transform: translateY(-1px);
    }

    /* Printable Official Receipt Preview */
    .receipt-preview-toggle-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px 30px;
        margin-top: 30px;
    }

    /* Screen Styles vs Print Styles */
    @media print {
        body {
            background: #ffffff !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Hide all page headers, navbars, footers, and success cards on print */
        header, footer, nav, #header, #footer, .order-success-page-wrapper > *:not(#print-receipt-section),
        .success-hero-card, .order-tracker-card, .success-grid, .action-button-grid, .receipt-preview-toggle-card {
            display: none !important;
        }

        #print-receipt-section {
            display: block !important;
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
            margin: 0 !important;
            padding: 20px !important;
            background: #ffffff !important;
            box-shadow: none !important;
            border: none !important;
        }

        @page {
            margin: 1.2cm;
            size: A4 portrait;
        }
    }
</style>

<?php
    // Pre-calculate variables
    $patient_name   = !empty($booking['patient_name']) ? $booking['patient_name'] : (!empty($appointment['appointment_name']) ? $appointment['appointment_name'] : (trim(($patient['FNAME'] ?? '') . ' ' . ($patient['LNAME'] ?? '')) ?: 'Valued Patient'));
    $patient_mobile = !empty($booking['patient_mobile']) ? $booking['patient_mobile'] : (!empty($appointment['appointment_mobile']) ? $appointment['appointment_mobile'] : ($patient['MOBILE'] ?? ''));
    $patient_email  = !empty($booking['patient_email']) ? $booking['patient_email'] : (!empty($appointment['appointment_email']) ? $appointment['appointment_email'] : ($patient['EMAIL'] ?? ''));
    $patient_addr   = !empty($booking['patient_address']) ? $booking['patient_address'] : 'Online / Recorded on File';

    $total_amount   = floatval($order['amount']);
    $wallet_used    = floatval($order['wallet_amount_used'] > 0 ? $order['wallet_amount_used'] : $order['wallet_points_used']);
    $gateway_paid   = floatval($order['gateway_amount'] > 0 ? $order['gateway_amount'] : ($total_amount - $wallet_used));
    $pay_date       = !empty($order['updated_at']) ? date('d M Y, h:i A', strtotime($order['updated_at'])) : date('d M Y, h:i A', strtotime($order['created_at']));
    $receipt_no     = 'UPCH/REC/' . date('Ym', strtotime($order['created_at'])) . '/' . str_pad($order['id'], 6, '0', STR_PAD_LEFT);
    $cashback_pts   = isset($cashback_pts) ? intval($cashback_pts) : intval(round($total_amount * 0.05));
?>

<div class="order-success-page-wrapper">
    <div class="order-success-container">

        <!-- 1. Celebratory Hero Card -->
        <div class="success-hero-card">
            <div class="success-badge-pulse">
                <i class="fa fa-check"></i>
            </div>

            <h1 class="success-main-title">Payment Confirmed!</h1>
            <p class="success-sub-title">
                Thank you, <strong><?=html_escape($patient_name);?></strong>. Your healthcare booking is confirmed and scheduled with our medical provider network.
            </p>

            <div class="order-ref-pill">
                <span>Order Reference:</span>
                <strong id="orderRefText"><?=htmlspecialchars($order['internal_order_ref']);?></strong>
                <button type="button" class="copy-btn" onclick="copyOrderRef()" title="Copy Order Reference">
                    <i class="fa fa-clone"></i>
                </button>
            </div>
        </div>

        <!-- 2. Interactive Order Fulfillment Tracker -->
        <div class="order-tracker-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #0f172a;">
                    <i class="fa fa-truck" style="color: #0d7a6e;"></i> Booking Fulfillment Journey
                </h4>
                <span style="font-size: 11.5px; background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 999px; font-weight: 700;">
                    STATUS: <?=htmlspecialchars($order['status']);?>
                </span>
            </div>

            <div class="tracker-steps">
                <!-- Step 1 -->
                <div class="tracker-step-item completed">
                    <div class="step-icon-circle"><i class="fa fa-check"></i></div>
                    <span class="step-label">1. Order Placed</span>
                </div>

                <!-- Step 2 -->
                <div class="tracker-step-item <?= (!empty($booking['assigned_collector_id']) || !empty($appointment['appointment_date'])) ? 'completed' : 'active';?>">
                    <div class="step-icon-circle"><i class="fa fa-user-md"></i></div>
                    <span class="step-label"><?= ($order['purpose'] === 'LAB_TEST') ? '2. Collector Assigned' : '2. Doctor Scheduled';?></span>
                </div>

                <!-- Step 3 -->
                <div class="tracker-step-item <?= (!empty($booking['collection_status']) && in_array($booking['collection_status'], ['sample_collected', 'handed_to_lab', 'report_ready'])) ? 'completed' : '';?>">
                    <div class="step-icon-circle"><i class="fa fa-flask"></i></div>
                    <span class="step-label"><?= ($order['purpose'] === 'LAB_TEST') ? '3. Sample in Transit / Lab' : '3. Consultation';?></span>
                </div>

                <!-- Step 4 -->
                <div class="tracker-step-item <?= (!empty($booking['report_file'])) ? 'completed' : '';?>">
                    <div class="step-icon-circle"><i class="fa fa-file-text-o"></i></div>
                    <span class="step-label"><?= ($order['purpose'] === 'LAB_TEST') ? '4. Verified Report' : '4. Prescription';?></span>
                </div>
            </div>
        </div>

        <!-- 3. Details Grid: Patient/Service & Financial Breakdown -->
        <div class="success-grid">

            <!-- Left Panel: Service Details -->
            <div class="card-panel">
                <div class="panel-header">
                    <h3><i class="fa fa-heartbeat"></i> Patient &amp; Service Information</h3>
                    <span style="font-size: 12px; color: #0d7a6e; font-weight: 600;">
                        <?php
                            if ($order['purpose'] === 'LAB_TEST') echo 'Diagnostic Pathology';
                            else if ($order['purpose'] === 'APPOINTMENT') echo 'Doctor Consultation';
                            else if ($order['purpose'] === 'WALLET_RECHARGE') echo 'Upchar Points Recharge';
                            else echo htmlspecialchars($order['purpose']);
                        ?>
                    </span>
                </div>

                <!-- Itemized Service Box -->
                <?php if ($order['purpose'] === 'LAB_TEST' && !empty($tests)): ?>
                    <?php foreach ($tests as $t): ?>
                    <div class="item-list-box">
                        <div class="item-title-row">
                            <span><?=html_escape($t['test_name']);?></span>
                            <span style="color: #0d7a6e;">₹<?=number_format($t['amount'] ?: $total_amount, 2);?></span>
                        </div>
                        <p class="item-desc-text">
                            <strong>Diagnostic Lab:</strong> <?=html_escape($lab['name'] ?? 'Upchar Certified Lab Network');?><br>
                            <strong>Collection Mode:</strong> <?= (!empty($booking['visit_type']) && $booking['visit_type'] === 'HOME_COLLECTION') ? '<span class="label label-info" style="font-size: 10px;">Home Pickup</span>' : '<span class="label label-default" style="font-size: 10px;">Lab Walk-in</span>';?>
                            <?php if (!empty($booking['vial_barcode'])): ?>
                                &nbsp;|&nbsp; <strong>Vial Barcode:</strong> <code><?=htmlspecialchars($booking['vial_barcode']);?></code>
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                <?php elseif ($order['purpose'] === 'APPOINTMENT'): ?>
                    <div class="item-list-box">
                        <div class="item-title-row">
                            <span>Doctor Consultation</span>
                            <span style="color: #0d7a6e;">₹<?=number_format($total_amount, 2);?></span>
                        </div>
                        <p class="item-desc-text">
                            <strong>Doctor:</strong> <?=html_escape(!empty($doctor['fname']) ? 'Dr. ' . $doctor['fname'] . ' ' . $doctor['lname'] : 'Specialist Consultation');?><br>
                            <strong>Facility:</strong> <?=html_escape($institute['name'] ?? 'Upchar Network Hospital / Clinic');?><br>
                            <?php if (!empty($appointment['appointment_date'])): ?>
                                <strong>Date &amp; Slot:</strong> <?=date('d M Y', strtotime($appointment['appointment_date']));?> (<?=$appointment['from_timing'] ?? 'Scheduled Slot';?>)
                            <?php endif; ?>
                        </p>
                    </div>
                <?php else: ?>
                    <div class="item-list-box">
                        <div class="item-title-row">
                            <span><?=htmlspecialchars($order['purpose'] === 'WALLET_RECHARGE' ? 'Upchar Points Wallet Recharge' : $order['purpose']);?></span>
                            <span style="color: #0d7a6e;">₹<?=number_format($total_amount, 2);?></span>
                        </div>
                        <p class="item-desc-text">
                            Ref: <?=htmlspecialchars($order['reference_id'] ?: $order['internal_order_ref']);?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Patient Metadata Details -->
                <div class="key-val-row">
                    <span class="key-val-lbl">Patient Name:</span>
                    <span class="key-val-data"><?=html_escape($patient_name);?></span>
                </div>
                <div class="key-val-row">
                    <span class="key-val-lbl">Mobile Number:</span>
                    <span class="key-val-data"><?=$patient_mobile ?: 'Recorded on File';?></span>
                </div>
                <div class="key-val-row">
                    <span class="key-val-lbl">Email Address:</span>
                    <span class="key-val-data"><?=$patient_email ?: 'Recorded on File';?></span>
                </div>
                <?php if (!empty($booking['time_slot'])): ?>
                <div class="key-val-row">
                    <span class="key-val-lbl">Pickup Time Slot:</span>
                    <span class="key-val-data" style="color: #0d7a6e; font-weight: 700;"><?=htmlspecialchars($booking['time_slot']);?></span>
                </div>
                <?php endif; ?>
                <div class="key-val-row">
                    <span class="key-val-lbl">Service Address:</span>
                    <span class="key-val-data"><?=html_escape($patient_addr);?></span>
                </div>
            </div>

            <!-- Right Panel: Financial & Receipt Breakdown -->
            <div class="card-panel">
                <div class="panel-header">
                    <h3><i class="fa fa-file-text-o"></i> Payment Summary</h3>
                    <span style="font-size: 11px; background: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 6px; font-weight: 700;">PAID IN FULL</span>
                </div>

                <!-- Loyalty / Points Banner -->
                <?php if ($order['purpose'] === 'WALLET_RECHARGE'): ?>
                    <div class="loyalty-reward-card">
                        <i class="fa fa-star"></i>
                        <div class="loyalty-reward-text">
                            <h5>Wallet Recharged Successfully</h5>
                            <p>+<?=number_format($order['amount'], 2);?> Points added to your balance.</p>
                        </div>
                    </div>
                <?php elseif ($cashback_pts > 0): ?>
                    <div class="loyalty-reward-card">
                        <i class="fa fa-gift"></i>
                        <div class="loyalty-reward-text">
                            <h5>+<?=$cashback_pts;?> Upchar Points Credited</h5>
                            <p>Cashback added to your wallet for next booking.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="key-val-row">
                    <span class="key-val-lbl">Receipt Number:</span>
                    <span class="key-val-data"><code><?=$receipt_no;?></code></span>
                </div>
                <div class="key-val-row">
                    <span class="key-val-lbl">Payment Date:</span>
                    <span class="key-val-data"><?=$pay_date;?></span>
                </div>
                <div class="key-val-row">
                    <span class="key-val-lbl">Payment Mode:</span>
                    <span class="key-val-data">
                        <?php if ($wallet_used > 0 && $gateway_paid > 0): ?>
                            Razorpay + Upchar Wallet
                        <?php elseif ($wallet_used > 0): ?>
                            Upchar Wallet Points
                        <?php else: ?>
                            Online Gateway (Razorpay)
                        <?php endif; ?>
                    </span>
                </div>
                <?php if (!empty($order['razorpay_payment_id'])): ?>
                <div class="key-val-row">
                    <span class="key-val-lbl">Transaction Ref:</span>
                    <span class="key-val-data"><code><?=$order['razorpay_payment_id'];?></code></span>
                </div>
                <?php endif; ?>
                <div class="key-val-row">
                    <span class="key-val-lbl">Gross Amount:</span>
                    <span class="key-val-data">₹<?=number_format($total_amount, 2);?></span>
                </div>
                <?php if ($wallet_used > 0): ?>
                <div class="key-val-row" style="color: #b45309;">
                    <span class="key-val-lbl">Points Redeemed:</span>
                    <span class="key-val-data" style="color: #b45309;">- ₹<?=number_format($wallet_used, 2);?></span>
                </div>
                <?php endif; ?>
                <div class="key-val-row">
                    <span class="key-val-lbl">GST (0% - Healthcare Exempt):</span>
                    <span class="key-val-data">₹0.00</span>
                </div>

                <div class="amount-grand-row">
                    <span class="amount-grand-lbl">Total Amount Paid</span>
                    <span class="amount-grand-val">₹<?=number_format($total_amount, 2);?></span>
                </div>

                <div style="font-size: 11.5px; color: #64748b; margin-top: 14px; line-height: 1.4; border-top: 1px dashed #e2e8f0; padding-top: 10px;">
                    <i class="fa fa-shield text-success"></i> <strong>Tax Exemption (Section 80D):</strong> Clinical diagnosis &amp; medical consultation services are exempt from GST under Notification No. 12/2017 Central Tax. Eligible for medical reimbursement claims.
                </div>
            </div>

        </div>

        <!-- 4. Primary Action Navigation Buttons -->
        <div class="action-button-grid">
            <button type="button" onclick="window.print()" class="btn-upchar-primary">
                <i class="fa fa-print"></i> Print Official Tax Receipt
            </button>

            <a href="<?=base_url('payment/receipt/' . $order['internal_order_ref']);?>" target="_blank" class="btn-upchar-outline">
                <i class="fa fa-file-pdf-o" style="color: #e11d48;"></i> View Full Tax Invoice
            </a>

            <?php if ($order['purpose'] === 'LAB_TEST'): ?>
                <a href="<?=base_url('myappointments#diagnostics');?>" class="btn-upchar-outline">
                    <i class="fa fa-flask" style="color: #0d7a6e;"></i> Track Diagnostic Orders
                </a>
            <?php elseif ($order['purpose'] === 'APPOINTMENT'): ?>
                <a href="<?=base_url('myappointments');?>" class="btn-upchar-outline">
                    <i class="fa fa-calendar" style="color: #0d7a6e;"></i> View Appointments
                </a>
            <?php else: ?>
                <a href="<?=base_url('wallet');?>" class="btn-upchar-outline">
                    <i class="fa fa-google-wallet" style="color: #0d7a6e;"></i> View Wallet Balance
                </a>
            <?php endif; ?>

            <a href="<?=base_url();?>" class="btn-upchar-outline">
                <i class="fa fa-home"></i> Home
            </a>
        </div>

    </div>
</div>

<!-- ==================================================== -->
<!-- PRINTABLE OFFICIAL TAX INVOICE & PAYMENT RECEIPT      -->
<!-- (Optimized strictly for window.print() on A4 paper)   -->
<!-- ==================================================== -->
<div id="print-receipt-section" style="display: none; font-family: 'Inter', Arial, sans-serif; background: #ffffff; color: #1e293b;">
    <div style="border-bottom: 2px solid #0d7a6e; padding-bottom: 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0d7a6e; margin: 0 0 4px 0;">
                UPCHAR HEALTHCARE
            </h1>
            <p style="font-size: 11.5px; color: #475569; margin: 0; line-height: 1.4;">
                <strong>Upchar Health Digital Solutions Pvt. Ltd.</strong><br>
                GSTIN: 09AAFCU5510R1Z2 &nbsp;|&nbsp; CIN: U85110UP2020PTC130456<br>
                Corporate HQ: Cyber City, Gomti Nagar, Lucknow, UP - 226010<br>
                Helpline: +91 8448440603 &nbsp;|&nbsp; Email: billing@upchar.info
            </p>
        </div>
        <div style="text-align: right;">
            <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; text-transform: uppercase;">
                TAX INVOICE &amp; RECEIPT
            </h2>
            <span style="display: inline-block; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; font-weight: 800; font-size: 11px; padding: 3px 10px; border-radius: 12px; text-transform: uppercase;">
                Payment Settled
            </span>
        </div>
    </div>

    <!-- Metadata Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px; font-size: 12px;">
        <div>
            <div style="font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px; border-bottom: 1px solid #e2e8f0; padding-bottom: 2px;">
                Transaction &amp; Order Meta
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #64748b;">Receipt Number:</span>
                <span style="font-weight: 700;"><code><?=$receipt_no;?></code></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #64748b;">Order Reference:</span>
                <span style="font-weight: 700;"><code><?=$order['internal_order_ref'];?></code></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #64748b;">Date &amp; Time:</span>
                <span style="font-weight: 600;"><?=$pay_date;?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #64748b;">Payment Method:</span>
                <span style="font-weight: 600;">
                    <?php if ($wallet_used > 0 && $gateway_paid > 0): ?>
                        Razorpay Gateway + Upchar Wallet
                    <?php elseif ($wallet_used > 0): ?>
                        Upchar Points Wallet (100%)
                    <?php else: ?>
                        Online Gateway (Razorpay)
                    <?php endif; ?>
                </span>
            </div>
            <?php if (!empty($order['razorpay_payment_id'])): ?>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #64748b;">Transaction ID:</span>
                <span style="font-weight: 600;"><?=$order['razorpay_payment_id'];?></span>
            </div>
            <?php endif; ?>
        </div>

        <div>
            <div style="font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px; border-bottom: 1px solid #e2e8f0; padding-bottom: 2px;">
                Billed To (Patient Information)
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #64748b;">Patient Name:</span>
                <span style="font-weight: 700;"><?=html_escape($patient_name);?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #64748b;">Mobile:</span>
                <span style="font-weight: 600;"><?=$patient_mobile ?: 'N/A';?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #64748b;">Email:</span>
                <span style="font-weight: 600;"><?=$patient_email ?: 'N/A';?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                <span style="color: #64748b;">Service Category:</span>
                <span style="font-weight: 600;">
                    <?php
                        if ($order['purpose'] === 'LAB_TEST') echo 'Diagnostic Pathology Investigation';
                        else if ($order['purpose'] === 'APPOINTMENT') echo 'Doctor Medical Consultation';
                        else if ($order['purpose'] === 'WALLET_RECHARGE') echo 'Wallet Recharge';
                        else echo htmlspecialchars($order['purpose']);
                    ?>
                </span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #64748b;">Address:</span>
                <span style="font-weight: 600;"><?=html_escape($patient_addr);?></span>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12.5px;">
        <thead>
            <tr style="background: #f1f5f9; border: 1px solid #cbd5e1;">
                <th style="padding: 8px 10px; border: 1px solid #cbd5e1; text-align: center; width: 40px;">#</th>
                <th style="padding: 8px 10px; border: 1px solid #cbd5e1; text-align: left;">Service Description &amp; Details</th>
                <th style="padding: 8px 10px; border: 1px solid #cbd5e1; text-align: center; width: 90px;">SAC</th>
                <th style="padding: 8px 10px; border: 1px solid #cbd5e1; text-align: center; width: 50px;">Qty</th>
                <th style="padding: 8px 10px; border: 1px solid #cbd5e1; text-align: right; width: 100px;">Rate (INR)</th>
                <th style="padding: 8px 10px; border: 1px solid #cbd5e1; text-align: right; width: 100px;">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($order['purpose'] === 'LAB_TEST' && !empty($tests)): ?>
                <?php $sn = 1; foreach ($tests as $t): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;"><?=$sn++;?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        <strong><?=html_escape($t['test_name']);?></strong>
                        <?php if (!empty($t['short_name'])): ?>
                            <span style="color: #64748b;">(<?=html_escape($t['short_name']);?>)</span>
                        <?php endif; ?>
                        <div style="font-size: 11px; color: #0d7a6e; margin-top: 2px;">
                            Lab: <?=html_escape($lab['name'] ?? 'Upchar Certified Lab Network');?>
                            <?php if (!empty($booking['visit_type'])): ?>
                                &nbsp;|&nbsp; <?=($booking['visit_type'] === 'HOME_COLLECTION') ? 'Home Sample Pickup' : 'Lab Walk-in';?>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;">999312</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;">1</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: right;">₹<?=number_format($t['amount'] ?: $total_amount, 2);?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: right;">₹<?=number_format($t['amount'] ?: $total_amount, 2);?></td>
                </tr>
                <?php endforeach; ?>
            <?php elseif ($order['purpose'] === 'APPOINTMENT'): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;">1</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        <strong>Medical Consultation: <?=html_escape(!empty($doctor['fname']) ? 'Dr. ' . $doctor['fname'] . ' ' . $doctor['lname'] : 'Doctor Consultation');?></strong>
                        <div style="font-size: 11px; color: #64748b;">
                            Facility: <?=html_escape($institute['name'] ?? 'Upchar Partner Clinic / Hospital');?>
                        </div>
                        <?php if (!empty($appointment['appointment_date'])): ?>
                            <div style="font-size: 11px; color: #0d7a6e; margin-top: 2px;">
                                Appointment Date: <?=date('d M Y', strtotime($appointment['appointment_date']));?> (<?=$appointment['from_timing'] ?? 'Scheduled Slot';?>)
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;">999311</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;">1</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: right;">₹<?=number_format($total_amount, 2);?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: right;">₹<?=number_format($total_amount, 2);?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;">1</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1;">
                        <strong><?=htmlspecialchars($order['purpose'] === 'WALLET_RECHARGE' ? 'Upchar Health Points Wallet Credit' : $order['purpose']);?></strong>
                        <div style="font-size: 11px; color: #64748b;">Ref: <?=htmlspecialchars($order['reference_id'] ?: $order['internal_order_ref']);?></div>
                    </td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;">999319</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: center;">1</td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: right;">₹<?=number_format($total_amount, 2);?></td>
                    <td style="padding: 10px; border: 1px solid #cbd5e1; text-align: right;">₹<?=number_format($total_amount, 2);?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Totals -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 24px;">
        <div style="flex: 1; background: #fdfefe; border-left: 3px solid #0d7a6e; padding: 10px 14px; font-size: 11px; color: #475569; line-height: 1.4;">
            <strong>Statutory Exemption Notice:</strong><br>
            Healthcare services provided by clinical establishments are <strong>exempt from GST</strong> as per Government of India Notification No. 12/2017 - Central Tax (Rate) dated 28th June 2017 (Entry No. 74). Valid for insurance reimbursement &amp; Tax Deduction under Section 80D.
        </div>

        <div style="width: 280px; font-size: 12.5px;">
            <div style="display: flex; justify-content: space-between; padding: 3px 0;">
                <span style="color: #64748b;">Gross Subtotal:</span>
                <span>₹<?=number_format($total_amount, 2);?></span>
            </div>
            <?php if ($wallet_used > 0): ?>
            <div style="display: flex; justify-content: space-between; padding: 3px 0; color: #b45309; font-weight: 600;">
                <span>Upchar Points Used:</span>
                <span>- ₹<?=number_format($wallet_used, 2);?></span>
            </div>
            <?php endif; ?>
            <div style="display: flex; justify-content: space-between; padding: 3px 0;">
                <span style="color: #64748b;">Online Gateway:</span>
                <span>₹<?=number_format($gateway_paid, 2);?></span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 3px 0;">
                <span style="color: #64748b;">GST (0% Exempt):</span>
                <span>₹0.00</span>
            </div>
            <div style="display: flex; justify-content: space-between; border-top: 2px solid #0f172a; border-bottom: 2px solid #0f172a; padding: 6px 0; margin-top: 4px; font-size: 15px; font-weight: 800; color: #0d7a6e;">
                <span>Total Paid:</span>
                <span>₹<?=number_format($total_amount, 2);?></span>
            </div>
        </div>
    </div>

    <!-- Footer Stamp -->
    <div style="border-top: 1px solid #e2e8f0; padding-top: 14px; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 60px; height: 60px; border: 2px dashed #0d7a6e; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 8.5px; font-weight: 800; color: #0d7a6e; text-align: center; text-transform: uppercase; line-height: 1.1;">
                UPCHAR<br>VERIFIED
            </div>
            <div style="font-size: 10.5px; color: #64748b; line-height: 1.3;">
                <strong>Computer-Generated Tax Receipt</strong><br>
                Issued on <?=date('d M Y, h:i A');?><br>
                Authentication Hash: <code><?=substr(md5($order['internal_order_ref'] . $order['created_at']), 0, 16);?></code>
            </div>
        </div>

        <div style="text-align: right;">
            <div style="font-weight: 700; font-size: 12px; color: #0f172a;">Authorized Signatory</div>
            <div style="font-size: 10.5px; color: #64748b;">Upchar Health Digital Solutions Pvt. Ltd.</div>
        </div>
    </div>
</div>

<script>
function copyOrderRef() {
    var ref = document.getElementById('orderRefText').innerText;
    if (navigator.clipboard) {
        navigator.clipboard.writeText(ref).then(function() {
            alert('Order reference copied: ' + ref);
        });
    } else {
        var tempInput = document.createElement("input");
        tempInput.value = ref;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert('Order reference copied: ' + ref);
    }
}
</script>
