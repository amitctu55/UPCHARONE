<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Financial Statement - <?=$hospital ? html_escape($hospital->name) : 'Hospital';?></title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
            color: #0f172a;
        }

        .statement-container {
            max-width: 950px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 40px;
            border: 1px solid #e2e8f0;
        }

        /* Print Controls Toolbar */
        .no-print-toolbar {
            max-width: 950px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-print {
            background: #00a896;
            color: #ffffff;
            font-weight: 700;
            font-size: 13.5px;
            padding: 10px 22px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);
            transition: all 0.15s;
        }

        .btn-print:hover {
            background: #008f80;
            transform: translateY(-1px);
        }

        .btn-back {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            font-weight: 600;
            font-size: 13px;
            padding: 9px 18px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Statement Header */
        .statement-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #043d5b;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }

        .hosp-brand h1 {
            font-size: 22px;
            font-weight: 800;
            color: #043d5b;
            margin: 0 0 4px 0;
        }

        .hosp-brand p {
            font-size: 12.5px;
            color: #64748b;
            margin: 0;
        }

        .statement-title-box {
            text-align: right;
        }

        .statement-title-box h2 {
            font-size: 18px;
            font-weight: 800;
            color: #00a896;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .statement-title-box span {
            font-size: 12px;
            color: #64748b;
            display: block;
        }

        /* KPI Summary Strip */
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 28px;
        }

        .summary-col {
            text-align: center;
            border-right: 1px solid #e2e8f0;
        }

        .summary-col:last-child {
            border-right: none;
        }

        .summary-col span {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 4px;
        }

        .summary-col h3 {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        /* Statement Table */
        .statement-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .statement-table th {
            background: #043d5b;
            color: #ffffff;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            text-align: left;
        }

        .statement-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
            color: #334155;
        }

        .statement-table tr:nth-child(even) td {
            background: #f8fafc;
        }

        .text-right {
            text-align: right;
        }

        .badge-paid {
            color: #15803d;
            font-weight: 700;
            font-size: 11px;
        }

        .badge-unpaid {
            color: #b91c1c;
            font-weight: 700;
            font-size: 11px;
        }

        /* Statement Footer */
        .statement-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11.5px;
            color: #94a3b8;
        }

        /* Print Media Rules */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .no-print-toolbar {
                display: none !important;
            }
            .statement-container {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            .statement-table th {
                background: #043d5b !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .summary-strip {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Print Action Controls -->
    <div class="no-print-toolbar">
        <a href="<?=base_url('hospitalpanel/earnings');?>" class="btn-back">
            <i class="fa fa-arrow-left"></i> Back to Revenue Dashboard
        </a>
        <button onclick="window.print();" class="btn-print">
            <i class="fa fa-print"></i> Print / Save as PDF
        </button>
    </div>

    <div class="statement-container">
        
        <!-- Header -->
        <div class="statement-header">
            <div class="hosp-brand">
                <h1><?=html_escape($hospital ? $hospital->name : 'Hospital Clinical Center');?></h1>
                <p><?=html_escape($hospital ? ($hospital->address.' - '.$hospital->city) : 'Upchar Healthcare Network Partner');?></p>
                <p style="margin-top: 3px;">Affiliated with Upchar Healthcare Network</p>
            </div>
            <div class="statement-title-box">
                <h2>Financial Statement</h2>
                <span><strong>Date:</strong> <?=date('d M, Y');?></span>
                <span><strong>Generated:</strong> <?=date('h:i A');?></span>
                <?php if(!empty($filter_desc)): ?>
                    <span style="color: #00a896; font-weight: 700;"><?=trim($filter_desc);?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Summary Strip -->
        <div class="summary-strip">
            <div class="summary-col">
                <span>Total Encounters</span>
                <h3><?=count($transactions);?></h3>
            </div>
            <div class="summary-col">
                <span>Gross Billed</span>
                <h3 style="color: #043d5b;">₹<?=number_format((float)$total_gross, 2);?></h3>
            </div>
            <div class="summary-col">
                <span>Total Settled / Paid</span>
                <h3 style="color: #15803d;">₹<?=number_format((float)$total_paid, 2);?></h3>
            </div>
            <div class="summary-col">
                <span>Pending Collection</span>
                <h3 style="color: #b91c1c;">₹<?=number_format((float)$total_due, 2);?></h3>
            </div>
        </div>

        <!-- Transactions Table -->
        <table class="statement-table">
            <thead>
                <tr>
                    <th>Ref #</th>
                    <th>Date</th>
                    <th>Patient Name</th>
                    <th>Attending Doctor</th>
                    <th>Mode</th>
                    <th class="text-right">Gross (₹)</th>
                    <th class="text-right">Net Share (₹)</th>
                    <th class="text-right">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($transactions)): ?>
                    <?php foreach($transactions as $t): ?>
                        <tr>
                            <td style="font-family: monospace; font-weight: 700; color: #043d5b;"><?=$t->transaction_ref;?></td>
                            <td><?=date('d M Y', strtotime($t->created_at));?></td>
                            <td style="font-weight: 600;"><?=$t->patient_name ?: 'Walk-in Patient';?></td>
                            <td><?=$t->dr_name ?: 'General Clinic';?></td>
                            <td><?=$t->payment_mode ?: 'CASH';?></td>
                            <td class="text-right" style="font-weight: 700;">₹<?=number_format((float)$t->gross_amount, 2);?></td>
                            <td class="text-right" style="font-weight: 700; color: #00a896;">₹<?=number_format((float)$t->net_payout, 2);?></td>
                            <td class="text-right">
                                <?php if($t->payment_status == 'DONE'): ?>
                                    <span class="badge-paid"><i class="fa fa-check"></i> PAID</span>
                                <?php else: ?>
                                    <span class="badge-unpaid"><i class="fa fa-clock-o"></i> UNPAID</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 24px; color: #94a3b8;">
                            No financial records found for the selected timeframe.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="statement-footer">
            <div>
                <span>Official Upchar Healthcare Network Statement • Confidential Hospital Record</span>
            </div>
            <div>
                <span>Page 1 of 1</span>
            </div>
        </div>

    </div>

</body>
</html>
