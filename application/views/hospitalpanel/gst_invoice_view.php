<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GST Tax Invoice - <?=$invoice->invoice_number;?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            padding: 30px 15px;
        }
        .invoice-paper {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 40px;
            border: 1px solid #e2e8f0;
        }
        .invoice-top-actions {
            max-width: 850px;
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-action {
            background: #043d5b;
            color: #ffffff;
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
        }
        .btn-action.print {
            background: #00a896;
        }
        .invoice-hdr {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #043d5b;
            padding-bottom: 24px;
            margin-bottom: 24px;
        }
        .brand-title {
            font-size: 26px;
            font-weight: 800;
            color: #043d5b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .brand-sub {
            font-size: 12.5px;
            color: #64748b;
            margin-top: 4px;
            line-height: 1.5;
        }
        .invoice-meta-box {
            text-align: right;
        }
        .tax-inv-badge {
            background: #f0fdfa;
            color: #00a896;
            border: 1px solid #ccfbf1;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 8px;
        }
        .inv-num {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
        }
        .inv-date {
            font-size: 12.5px;
            color: #64748b;
            margin-top: 3px;
        }
        .parties-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }
        .party-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
        }
        .party-label {
            font-size: 11px;
            font-weight: 800;
            color: #043d5b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .party-name {
            font-size: 14.5px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .party-details {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }
        .inv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .inv-table th {
            background: #043d5b;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 10px 14px;
            text-align: left;
        }
        .inv-table td {
            padding: 12px 14px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #e2e8f0;
        }
        .totals-block {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 28px;
        }
        .totals-table {
            width: 320px;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 12px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        .totals-table tr.grand-total td {
            font-size: 15px;
            font-weight: 800;
            color: #043d5b;
            border-top: 2px solid #043d5b;
            border-bottom: 2px solid #043d5b;
            background: #f8fafc;
        }
        .inv-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 11.5px;
            color: #64748b;
            line-height: 1.5;
        }
        .signatory-box {
            text-align: center;
        }
        .signatory-line {
            width: 180px;
            border-top: 1px dashed #cbd5e1;
            margin-top: 40px;
            padding-top: 6px;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .invoice-top-actions {
                display: none;
            }
            .invoice-paper {
                box-shadow: none;
                border: none;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-top-actions">
        <a href="<?=base_url('hospitalpanel/earnings#invoices');?>" class="btn-action">
            <i class="fa fa-arrow-left"></i> Back to Earnings Dashboard
        </a>
        <button onclick="window.print();" class="btn-action print">
            <i class="fa fa-print"></i> Print / Save as PDF
        </button>
    </div>

    <div class="invoice-paper">
        <!-- Header -->
        <div class="invoice-hdr">
            <div>
                <div class="brand-title">UPCHAR HEALTHCARE</div>
                <div class="brand-sub">
                    <strong><?=$settings->upchar_company_name ?? 'Upchar Health Technologies Pvt Ltd';?></strong><br>
                    <?=$settings->upchar_address ?? 'Plot No. 42, Health City, New Delhi - 110001';?><br>
                    <strong>GSTIN:</strong> <?=$settings->upchar_gstin ?? '07AAAAU1234A1Z5';?><br>
                    <strong>PAN:</strong> AAAAU1234A | <strong>SAC Code:</strong> 998313
                </div>
            </div>
            <div class="invoice-meta-box">
                <div class="tax-inv-badge">TAX INVOICE</div>
                <div class="inv-num"><?=$invoice->invoice_number;?></div>
                <div class="inv-date">Invoice Date: <?=date('d-M-Y', strtotime($invoice->generated_at));?></div>
                <div class="inv-date">Billing Period: <?=date('F Y', strtotime($invoice->billing_month . '-01'));?></div>
            </div>
        </div>

        <!-- Supplier & Recipient Grid -->
        <div class="parties-grid">
            <div class="party-card">
                <div class="party-label">Billed To (Healthcare Facility):</div>
                <div class="party-name"><?=$invoice->facility_name;?></div>
                <div class="party-details">
                    Facility ID: #<?=$invoice->facility_id;?><br>
                    GSTIN / UIN: <?=($invoice->facility_gstin ?: 'Unregistered / Exempt');?><br>
                    Address: <?=($facility->address ?? 'On-file with Upchar Platform');?><br>
                    Contact: <?=($facility->mobile ?? 'N/A');?>
                </div>
            </div>
            <div class="party-card">
                <div class="party-label">Place of Supply &amp; Terms:</div>
                <div class="party-details">
                    <strong>Place of Supply:</strong> Delhi (State Code 07)<br>
                    <strong>Supply Type:</strong> Intra-State (CGST + SGST)<br>
                    <strong>Payment Mode:</strong> Escrow Settlement Adjustment<br>
                    <strong>Service Category:</strong> Software &amp; Platform Brokerage Fees
                </div>
            </div>
        </div>

        <!-- Itemized Table -->
        <table class="inv-table">
            <thead>
                <tr>
                    <th style="width: 8%;">S.No</th>
                    <th style="width: 48%;">Description of Services</th>
                    <th style="width: 14%; text-align: center;">SAC Code</th>
                    <th style="width: 30%; text-align: right;">Taxable Value (INR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <strong>Upchar Health Platform Brokerage &amp; Tech Facilitation Fee</strong><br>
                        <span style="font-size: 11.5px; color: #64748b;">
                            Facilitation of OPD Appointments, Inpatient Admissions &amp; Telehealth for month of <?=date('F Y', strtotime($invoice->billing_month . '-01'));?>
                        </span>
                    </td>
                    <td style="text-align: center;">998313</td>
                    <td style="text-align: right; font-weight: 700;">₹<?=number_format($invoice->total_taxable_value, 2);?></td>
                </tr>
            </tbody>
        </table>

        <!-- Totals Block -->
        <div class="totals-block">
            <table class="totals-table">
                <tr>
                    <td>Total Taxable Value:</td>
                    <td style="text-align: right; font-weight: 600;">₹<?=number_format($invoice->total_taxable_value, 2);?></td>
                </tr>
                <tr>
                    <td>Central GST (CGST @ 9%):</td>
                    <td style="text-align: right; font-weight: 600;">₹<?=number_format($invoice->cgst_amount, 2);?></td>
                </tr>
                <tr>
                    <td>State GST (SGST @ 9%):</td>
                    <td style="text-align: right; font-weight: 600;">₹<?=number_format($invoice->sgst_amount, 2);?></td>
                </tr>
                <?php if($invoice->igst_amount > 0): ?>
                    <tr>
                        <td>Integrated GST (IGST @ 18%):</td>
                        <td style="text-align: right; font-weight: 600;">₹<?=number_format($invoice->igst_amount, 2);?></td>
                    </tr>
                <?php endif; ?>
                <tr class="grand-total">
                    <td>Total Invoice Value:</td>
                    <td style="text-align: right;">₹<?=number_format($invoice->total_invoice_amount, 2);?></td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="inv-footer">
            <div>
                <strong>Terms &amp; Conditions:</strong><br>
                1. This is a computer generated invoice issued in accordance with Section 31 of CGST Act, 2017.<br>
                2. Input Tax Credit (ITC) can be claimed by eligible registered taxpayers.<br>
                3. Queries related to this invoice may be addressed to support@upchar.info.
            </div>
            <div class="signatory-box">
                <div style="font-weight: 800; color: #043d5b;">Upchar Health Technologies Pvt Ltd</div>
                <div class="signatory-line">Authorized Signatory</div>
            </div>
        </div>
    </div>

</body>
</html>
