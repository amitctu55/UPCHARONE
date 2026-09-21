<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .payment-status-wrapper {
        background: #f8fafc;
        padding: 50px 15px 80px;
        min-height: 75vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .success-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        max-width: 520px;
        width: 100%;
        padding: 40px 30px;
        text-align: center;
        border: 1px solid #e2e8f0;
        margin: 0 auto;
    }

    .success-icon-wrapper {
        width: 76px;
        height: 76px;
        background: #dcfce7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        box-shadow: 0 0 0 8px #f0fdf4;
    }

    .success-icon-wrapper i {
        font-size: 36px;
        color: #16a34a;
    }

    .success-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
    }

    .success-sub {
        color: #64748b;
        font-size: 14px;
        margin: 0 0 24px;
    }

    .order-details-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        text-align: left;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 13.5px;
    }

    .detail-row:last-child {
        margin-bottom: 0;
        padding-top: 10px;
        border-top: 1px dashed #cbd5e1;
        font-weight: 700;
    }

    .detail-label {
        color: #64748b;
    }

    .detail-value {
        color: #0f172a;
        font-weight: 600;
    }

    .points-earned-banner {
        background: #fef3c7;
        border: 1px dashed #f59e0b;
        color: #92400e;
        border-radius: 10px;
        padding: 12px;
        font-size: 13px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .btn-group-stacked {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-primary-action {
        background: #00a896;
        color: #ffffff !important;
        text-decoration: none !important;
        border-radius: 10px;
        padding: 12px 20px;
        font-size: 14.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    }

    .btn-primary-action:hover {
        background: #008f80;
        transform: translateY(-1px);
    }

    .btn-secondary-action {
        background: #f1f5f9;
        color: #334155 !important;
        text-decoration: none !important;
        border-radius: 10px;
        padding: 11px 20px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-secondary-action:hover {
        background: #e2e8f0;
    }
</style>

<div class="payment-status-wrapper">
    <div class="success-card">
        <div class="success-icon-wrapper">
            <i class="fa fa-check"></i>
        </div>

        <h1 class="success-title">Payment Completed!</h1>
        <p class="success-sub">Thank you. Your transaction was confirmed and processed successfully.</p>

        <div class="order-details-box">
            <div class="detail-row">
                <span class="detail-label">Order Reference:</span>
                <span class="detail-value"><?=htmlspecialchars($order['internal_order_ref']);?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Purpose:</span>
                <span class="detail-value"><?=htmlspecialchars($order['purpose']);?></span>
            </div>
            <?php if (!empty($order['razorpay_payment_id'])): ?>
            <div class="detail-row">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value"><?=htmlspecialchars($order['razorpay_payment_id']);?></span>
            </div>
            <?php endif; ?>
            <?php if ($order['wallet_points_used'] > 0): ?>
            <div class="detail-row">
                <span class="detail-label">Points Redeemed:</span>
                <span class="detail-value"><?=number_format($order['wallet_points_used'], 0);?> Pts</span>
            </div>
            <?php endif; ?>
            <div class="detail-row">
                <span class="detail-label">Total Amount:</span>
                <span class="detail-value" style="color: #00a896; font-size: 16px;">₹<?=number_format($order['amount'], 2);?></span>
            </div>
        </div>

        <?php if ($order['purpose'] === 'WALLET_RECHARGE'): ?>
            <div class="points-earned-banner">
                <i class="fa fa-star"></i>
                <span>Your wallet has been credited with <strong>+<?=number_format($order['amount'], 2);?> Upchar Points</strong>!</span>
            </div>
        <?php elseif ($cashback_pts > 0): ?>
            <div class="points-earned-banner">
                <i class="fa fa-gift"></i>
                <span>You earned <strong>+<?=$cashback_pts;?> Upchar Cashback Points</strong>!</span>
            </div>
        <?php endif; ?>

        <div class="btn-group-stacked">
            <button type="button" onclick="window.print()" class="btn-primary-action" style="background: #0d7a6e; border: none; cursor: pointer;">
                <i class="fa fa-print"></i> Print Official Payment Receipt
            </button>

            <a href="<?=base_url('payment/receipt/' . $order['internal_order_ref']);?>" target="_blank" class="btn-secondary-action">
                <i class="fa fa-file-text-o"></i> View &amp; Download Full Tax Invoice
            </a>

            <?php if ($order['purpose'] === 'APPOINTMENT'): ?>
                <a href="<?=base_url('myappointments');?>" class="btn-secondary-action">
                    <i class="fa fa-calendar"></i> View Doctor Appointments
                </a>
            <?php elseif ($order['purpose'] === 'WALLET_RECHARGE'): ?>
                <a href="<?=base_url('wallet');?>" class="btn-secondary-action">
                    <i class="fa fa-google-wallet"></i> View Wallet Dashboard
                </a>
            <?php else: ?>
                <a href="<?=base_url('myappointments#diagnostics');?>" class="btn-secondary-action">
                    <i class="fa fa-flask"></i> View Diagnostics Orders
                </a>
            <?php endif; ?>

            <a href="<?=base_url();?>" class="btn-secondary-action">
                <i class="fa fa-home"></i> Return to Homepage
            </a>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- PRINTABLE OFFICIAL TAX INVOICE & PAYMENT RECEIPT      -->
<!-- (Optimized for window.print() on standard A4 paper)  -->
<!-- ==================================================== -->
<?php
    $patient_name   = !empty($booking['patient_name']) ? $booking['patient_name'] : (!empty($appointment['appointment_name']) ? $appointment['appointment_name'] : (trim(($patient['FNAME'] ?? '') . ' ' . ($patient['LNAME'] ?? '')) ?: 'Valued Patient'));
    $patient_mobile = !empty($booking['patient_mobile']) ? $booking['patient_mobile'] : (!empty($appointment['appointment_mobile']) ? $appointment['appointment_mobile'] : ($patient['MOBILE'] ?? ''));
    $patient_email  = !empty($booking['patient_email']) ? $booking['patient_email'] : (!empty($appointment['appointment_email']) ? $appointment['appointment_email'] : ($patient['EMAIL'] ?? ''));
    $patient_addr   = !empty($booking['patient_address']) ? $booking['patient_address'] : 'Online / Recorded on File';

    $total_amount   = floatval($order['amount']);
    $wallet_used    = floatval($order['wallet_amount_used'] > 0 ? $order['wallet_amount_used'] : $order['wallet_points_used']);
    $gateway_paid   = floatval($order['gateway_amount'] > 0 ? $order['gateway_amount'] : ($total_amount - $wallet_used));
    $pay_date       = !empty($order['updated_at']) ? date('d M Y, h:i A', strtotime($order['updated_at'])) : date('d M Y, h:i A', strtotime($order['created_at']));
    $receipt_no     = 'UPCH/REC/' . date('Ym', strtotime($order['created_at'])) . '/' . str_pad($order['id'], 6, '0', STR_PAD_LEFT);
?>

<div id="print-receipt-section" class="print-only-container">
    <div style="border-bottom: 2px solid #0d7a6e; padding-bottom: 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0d7a6e; margin: 0 0 4px 0;">
                <i class="fa fa-plus-square"></i> UPCHAR HEALTHCARE
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
                <i class="fa fa-check-circle"></i> Payment Settled
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
                            <div style="font-size: 11px; color: #64748b;"><?=html_escape($t['short_name']);?></div>
                        <?php endif; ?>
                        <div style="font-size: 11px; color: #0d7a6e; margin-top: 2px;">
                            Lab: <?=html_escape($lab['name'] ?? 'Upchar Certified Diagnostic Partner');?>
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
                        <strong>Doctor Consultation: <?=html_escape(!empty($doctor['fname']) ? 'Dr. ' . $doctor['fname'] . ' ' . $doctor['lname'] : 'Doctor Consultation');?></strong>
                        <div style="font-size: 11px; color: #64748b;">
                            Facility: <?=html_escape($institute['name'] ?? 'Upchar Partner Clinic / Hospital');?>
                        </div>
                        <?php if (!empty($appointment['appointment_date'])): ?>
                            <div style="font-size: 11px; color: #0d7a6e; margin-top: 2px;">
                                Date: <?=date('d M Y', strtotime($appointment['appointment_date']));?> (<?=$appointment['from_timing'] ?? 'Scheduled Slot';?>)
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
                <i class="fa fa-check" style="font-size: 14px; margin-bottom: 2px;"></i>
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

<style>
/* Hide the receipt on screen if desirable, or show preview with print styles */
@media screen {
    .print-only-container {
        max-width: 820px;
        margin: 40px auto 0;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }
}

@media print {
    /* Hide everything on page except the receipt */
    body * {
        visibility: hidden;
    }

    #print-receipt-section,
    #print-receipt-section * {
        visibility: visible;
    }

    #print-receipt-section {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        background: #ffffff !important;
        box-shadow: none !important;
        border: none !important;
    }

    header, footer, .payment-status-wrapper, .navbar, #header, #footer {
        display: none !important;
    }

    @page {
        margin: 1.2cm;
        size: A4 portrait;
    }
}
</style>

