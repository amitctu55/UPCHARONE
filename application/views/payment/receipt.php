<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - <?=htmlspecialchars($order['internal_order_ref']);?> - UPCHAR</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            padding: 30px 15px;
            font-size: 13px;
            line-height: 1.5;
        }

        .receipt-container {
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            padding: 40px;
            position: relative;
        }

        /* Top Action Bar (hidden in print) */
        .receipt-action-bar {
            max-width: 820px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none !important;
            transition: all 0.2s;
            border: none;
        }

        .btn-print {
            background: #0d7a6e;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(13, 122, 110, 0.25);
        }

        .btn-print:hover {
            background: #095950;
            transform: translateY(-1px);
        }

        .btn-back {
            background: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .btn-back:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        /* Header */
        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0d7a6e;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }

        .company-branding h1 {
            font-size: 26px;
            font-weight: 800;
            color: #0d7a6e;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .company-branding p {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
            line-height: 1.4;
        }

        .invoice-type-tag {
            text-align: right;
        }

        .invoice-type-tag h2 {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .invoice-type-tag .receipt-status-badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 800;
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-top: 6px;
            text-transform: uppercase;
        }

        /* Meta Grid */
        .receipt-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 24px;
        }

        .meta-col h3 {
            font-size: 11.5px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .meta-field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12.5px;
        }

        .meta-field .lbl {
            color: #64748b;
        }

        .meta-field .val {
            font-weight: 600;
            color: #0f172a;
            text-align: right;
        }

        /* Table */
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .receipt-table th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        .receipt-table td {
            padding: 12px 14px;
            border: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Calculation Summary */
        .receipt-summary-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 28px;
        }

        .summary-notes {
            flex: 1;
            background: #fdfefe;
            border-left: 3px solid #0d7a6e;
            padding: 12px 16px;
            font-size: 12px;
            color: #475569;
        }

        .summary-totals {
            width: 320px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 13px;
            color: #475569;
        }

        .total-row.grand-total {
            border-top: 2px solid #0f172a;
            border-bottom: 2px solid #0f172a;
            padding: 10px 0;
            margin-top: 6px;
            font-size: 16px;
            font-weight: 800;
            color: #0d7a6e;
        }

        /* Stamp & Footer */
        .receipt-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stamp-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .seal-circle {
            width: 72px;
            height: 72px;
            border: 2px dashed #0d7a6e;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 9.5px;
            font-weight: 800;
            color: #0d7a6e;
            text-transform: uppercase;
            text-align: center;
            line-height: 1.2;
            transform: rotate(-5deg);
        }

        .seal-circle i {
            font-size: 16px;
            margin-bottom: 2px;
        }

        .signature-box {
            text-align: right;
        }

        .signature-box .auth-sign {
            font-weight: 700;
            font-size: 13px;
            color: #0f172a;
        }

        .signature-box .auth-desig {
            font-size: 11px;
            color: #64748b;
        }

        /* Print Specific Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }

            .receipt-action-bar {
                display: none !important;
            }

            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }

            @page {
                margin: 1.5cm;
                size: A4 portrait;
            }
        }
    </style>
</head>
<body>

    <?php
        // Resolve patient details
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

    <!-- Top Action Bar -->
    <div class="receipt-action-bar">
        <div>
            <a href="<?=base_url('payment/success/' . $order['internal_order_ref']);?>" class="btn-action btn-back">
                <i class="fa fa-arrow-left"></i> Back to Confirmation
            </a>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="button" onclick="window.print()" class="btn-action btn-print">
                <i class="fa fa-print"></i> Print Official Receipt / Save PDF
            </button>
        </div>
    </div>

    <!-- Official Tax Invoice & Receipt Container -->
    <div class="receipt-container">

        <!-- Header -->
        <div class="receipt-header">
            <div class="company-branding">
                <h1>
                    <i class="fa fa-plus-square"></i> UPCHAR HEALTHCARE
                </h1>
                <p>
                    <strong>Upchar Health Digital Solutions Pvt. Ltd.</strong><br>
                    GSTIN: 09AAFCU5510R1Z2 &nbsp;|&nbsp; CIN: U85110UP2020PTC130456<br>
                    Corporate HQ: Cyber City, Gomti Nagar, Lucknow, UP - 226010<br>
                    Helpline: +91 8448440603 &nbsp;|&nbsp; Email: billing@upchar.info
                </p>
            </div>

            <div class="invoice-type-tag">
                <h2>TAX INVOICE &amp; RECEIPT</h2>
                <div class="receipt-status-badge">
                    <i class="fa fa-check-circle"></i> Payment Confirmed
                </div>
            </div>
        </div>

        <!-- Meta Grid -->
        <div class="receipt-meta-grid">
            <!-- Left: Transaction Meta -->
            <div class="meta-col">
                <h3>Invoice &amp; Transaction Details</h3>
                <div class="meta-field">
                    <span class="lbl">Receipt Number:</span>
                    <span class="val"><code><?=$receipt_no;?></code></span>
                </div>
                <div class="meta-field">
                    <span class="lbl">Order Reference:</span>
                    <span class="val"><code><?=$order['internal_order_ref'];?></code></span>
                </div>
                <div class="meta-field">
                    <span class="lbl">Transaction Date:</span>
                    <span class="val"><?=$pay_date;?></span>
                </div>
                <div class="meta-field">
                    <span class="lbl">Payment Method:</span>
                    <span class="val">
                        <?php if ($wallet_used > 0 && $gateway_paid > 0): ?>
                            Razorpay + Upchar Wallet
                        <?php elseif ($wallet_used > 0): ?>
                            Upchar Points Wallet (100%)
                        <?php else: ?>
                            Online Gateway (Razorpay)
                        <?php endif; ?>
                    </span>
                </div>
                <?php if (!empty($order['razorpay_payment_id'])): ?>
                <div class="meta-field">
                    <span class="lbl">Gateway Payment ID:</span>
                    <span class="val"><?=$order['razorpay_payment_id'];?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right: Billed To (Customer) -->
            <div class="meta-col">
                <h3>Billed To (Patient Information)</h3>
                <div class="meta-field">
                    <span class="lbl">Patient Name:</span>
                    <span class="val"><?=html_escape($patient_name);?></span>
                </div>
                <div class="meta-field">
                    <span class="lbl">Mobile Contact:</span>
                    <span class="val"><?=$patient_mobile ?: 'N/A';?></span>
                </div>
                <div class="meta-field">
                    <span class="lbl">Email Address:</span>
                    <span class="val"><?=$patient_email ?: 'N/A';?></span>
                </div>
                <div class="meta-field">
                    <span class="lbl">Address:</span>
                    <span class="val"><?=html_escape($patient_addr);?></span>
                </div>
                <div class="meta-field">
                    <span class="lbl">Service Category:</span>
                    <span class="val">
                        <?php
                            if ($order['purpose'] === 'LAB_TEST') echo 'Diagnostic Pathology Tests';
                            else if ($order['purpose'] === 'APPOINTMENT') echo 'Doctor Medical Consultation';
                            else if ($order['purpose'] === 'WALLET_RECHARGE') echo 'Upchar Points Wallet Recharge';
                            else echo htmlspecialchars($order['purpose']);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Itemized Services Table -->
        <table class="receipt-table">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th>Service Description &amp; Details</th>
                    <th style="width: 100px;" class="text-center">SAC Code</th>
                    <th style="width: 60px;" class="text-center">Qty</th>
                    <th style="width: 110px;" class="text-right">Rate (INR)</th>
                    <th style="width: 110px;" class="text-right">Amount (INR)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($order['purpose'] === 'LAB_TEST' && !empty($tests)): ?>
                    <?php $sn = 1; foreach ($tests as $t): ?>
                    <tr>
                        <td class="text-center"><?=$sn++;?></td>
                        <td>
                            <strong><?=html_escape($t['test_name']);?></strong>
                            <?php if (!empty($t['short_name'])): ?>
                                <div style="font-size: 11.5px; color: #64748b;"><?=html_escape($t['short_name']);?></div>
                            <?php endif; ?>
                            <div style="font-size: 11.5px; color: #0d7a6e; margin-top: 2px;">
                                <i class="fa fa-hospital-o"></i> Lab: <?=html_escape($lab['name'] ?? 'Upchar Certified Lab Network');?>
                                <?php if (!empty($booking['visit_type'])): ?>
                                    &nbsp;|&nbsp; <?=($booking['visit_type'] === 'HOME_COLLECTION') ? 'Home Sample Pickup' : 'Lab Walk-in';?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="text-center">999312</td>
                        <td class="text-center">1</td>
                        <td class="text-right">₹<?=number_format($t['amount'] ?: $total_amount, 2);?></td>
                        <td class="text-right">₹<?=number_format($t['amount'] ?: $total_amount, 2);?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php elseif ($order['purpose'] === 'APPOINTMENT'): ?>
                    <tr>
                        <td class="text-center">1</td>
                        <td>
                            <strong>Medical Consultation: <?=html_escape(!empty($doctor['fname']) ? 'Dr. ' . $doctor['fname'] . ' ' . $doctor['lname'] : 'Doctor Consultation');?></strong>
                            <div style="font-size: 11.5px; color: #64748b;">
                                Facility: <?=html_escape($institute['name'] ?? 'Upchar Partner Clinic / Hospital');?>
                            </div>
                            <?php if (!empty($appointment['appointment_date'])): ?>
                                <div style="font-size: 11.5px; color: #0d7a6e; margin-top: 2px;">
                                    <i class="fa fa-calendar"></i> Appointment Date: <?=date('d M Y', strtotime($appointment['appointment_date']));?> (<?=$appointment['from_timing'] ?? 'Scheduled Slot';?>)
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">999311</td>
                        <td class="text-center">1</td>
                        <td class="text-right">₹<?=number_format($total_amount, 2);?></td>
                        <td class="text-right">₹<?=number_format($total_amount, 2);?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td class="text-center">1</td>
                        <td>
                            <strong><?=htmlspecialchars($order['purpose'] === 'WALLET_RECHARGE' ? 'Upchar Health Points Wallet Credit' : $order['purpose']);?></strong>
                            <div style="font-size: 11.5px; color: #64748b;">Reference: <?=htmlspecialchars($order['reference_id'] ?: $order['internal_order_ref']);?></div>
                        </td>
                        <td class="text-center">999319</td>
                        <td class="text-center">1</td>
                        <td class="text-right">₹<?=number_format($total_amount, 2);?></td>
                        <td class="text-right">₹<?=number_format($total_amount, 2);?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Summary and Totals -->
        <div class="receipt-summary-flex">
            <div class="summary-notes">
                <strong>Tax Exemption &amp; Compliance Notes:</strong><br>
                Healthcare diagnosis and consultation services provided by clinical establishments are <strong>exempt from GST</strong> as per Government of India Notification No. 12/2017 - Central Tax (Rate) dated 28th June 2017 (Entry No. 74).<br><br>
                This receipt is eligible for medical insurance claim reimbursements and income tax exemption under <strong>Section 80D</strong> of the Income Tax Act.
            </div>

            <div class="summary-totals">
                <div class="total-row">
                    <span>Gross Subtotal:</span>
                    <span>₹<?=number_format($total_amount, 2);?></span>
                </div>
                <?php if ($wallet_used > 0): ?>
                <div class="total-row" style="color: #b45309; font-weight: 600;">
                    <span>Upchar Points Redeemed:</span>
                    <span>- ₹<?=number_format($wallet_used, 2);?></span>
                </div>
                <?php endif; ?>
                <div class="total-row">
                    <span>Online Payment Gateway:</span>
                    <span>₹<?=number_format($gateway_paid, 2);?></span>
                </div>
                <div class="total-row">
                    <span>Applicable GST (0%):</span>
                    <span>₹0.00</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total Amount Paid:</span>
                    <span>₹<?=number_format($total_amount, 2);?></span>
                </div>
            </div>
        </div>

        <!-- Footer / Stamps / Disclaimer -->
        <div class="receipt-footer">
            <div class="stamp-box">
                <div class="seal-circle">
                    <i class="fa fa-check"></i>
                    UPCHAR<br>VERIFIED
                </div>
                <div style="font-size: 11px; color: #64748b; line-height: 1.4;">
                    <strong>Computer-Generated Tax Receipt</strong><br>
                    No physical signature required.<br>
                    Issued on <?=date('d M Y, h:i A');?>
                </div>
            </div>

            <div class="signature-box">
                <div class="auth-sign">Authorized Signatory</div>
                <div class="auth-desig">Upchar Health Digital Solutions Pvt. Ltd.</div>
            </div>
        </div>

    </div>

</body>
</html>
