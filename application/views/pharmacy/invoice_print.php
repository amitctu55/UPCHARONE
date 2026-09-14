<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chemist Tax Invoice & Packing Slip — <?=$order['order_code'];?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #111;
            margin: 0;
            padding: 20px;
            background: #FFF;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 24px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #08364B;
            padding-bottom: 12px;
        }
        .pharmacy-title {
            font-size: 20px;
            font-weight: bold;
            color: #08364B;
            margin: 0 0 4px;
        }
        .meta-info {
            font-size: 12px;
            color: #444;
            line-height: 1.4;
        }
        .invoice-tag {
            background: #08364B;
            color: #FFF;
            padding: 4px 10px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 6px;
        }
        .section-table {
            width: 100%;
            margin-bottom: 16px;
        }
        .section-table td {
            vertical-align: top;
            padding: 4px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th, .items-table td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }
        .items-table th {
            background: #F1F5F9;
            color: #08364B;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals-table {
            width: 320px;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #eee;
        }
        .qr-section {
            border: 1px dashed #08364B;
            padding: 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 16px;
            background: #F8FAFC;
        }
        .legal-disclaimer {
            margin-top: 30px;
            padding: 12px;
            background: #F8FAFC;
            border-top: 2px solid #00A8FF;
            font-size: 11.5px;
            color: #555;
            text-align: center;
            line-height: 1.5;
        }
        @media print {
            body { padding: 0; }
            .invoice-box { border: none; box-shadow: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="background: #08364B; color: #FFF; border: none; padding: 8px 18px; border-radius: 4px; font-weight: bold; cursor: pointer;">
            🖨️ Print Packing Slip & Invoice
        </button>
    </div>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="width: 65%;">
                <h1 class="pharmacy-title"><?=htmlspecialchars($order['store_name']);?></h1>
                <div class="meta-info">
                    <strong>Retail Drug License No:</strong> <?=htmlspecialchars($order['drug_license_no']);?><br>
                    <strong>GSTIN:</strong> <?=htmlspecialchars($order['gstin']);?><br>
                    <strong>Address:</strong> <?=htmlspecialchars($order['store_address']);?><br>
                    <strong>Contact Phone:</strong> <?=htmlspecialchars($order['store_phone']);?>
                </div>
            </td>
            <td style="width: 35%; text-align: right; vertical-align: top;">
                <div class="invoice-tag">TAX INVOICE / PACKING SLIP</div>
                <div class="meta-info">
                    <strong>Invoice / Order No:</strong> <?=$order['order_code'];?><br>
                    <strong>Date:</strong> <?=date('d-M-Y h:i A', strtotime($order['created_at']));?><br>
                    <strong>Payment Mode:</strong> <?=$order['payment_mode'];?> (<?=$order['payment_status'];?>)
                </div>
            </td>
        </tr>
    </table>

    <!-- Customer & Logistics Details -->
    <table class="section-table">
        <tr>
            <td style="width: 50%;">
                <strong>Billed & Delivered To:</strong><br>
                <?=htmlspecialchars($order['customer_name']);?><br>
                Phone: <?=htmlspecialchars($order['customer_phone']);?><br>
                Address: <?=htmlspecialchars($order['delivery_address']);?>
            </td>
            <td style="width: 50%;">
                <strong>Logistics & Chain-of-Custody:</strong><br>
                Delivery Partner: <strong>UPCHAR Express Fleet</strong><br>
                Assigned Rider: <?=(!empty($order['rider_name'])) ? htmlspecialchars($order['rider_name']) . ' (' . $order['rider_phone'] . ')' : 'Pending Dispatch';?><br>
                Package Status: <strong><?=$order['order_status'];?></strong>
            </td>
        </tr>
    </table>

    <!-- Itemized Medicine Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 35%;">Item Description (Salt / Composition)</th>
                <th style="width: 15%;">Batch No.</th>
                <th style="width: 12%;">Expiry</th>
                <th style="width: 8%;" class="text-center">Qty</th>
                <th style="width: 12%;" class="text-right">Rate (₹)</th>
                <th style="width: 13%;" class="text-right">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $subtotal = 0;
            $i = 1;
            foreach ($order['items'] as $item): 
                $subtotal += $item['total_price'];
            ?>
            <tr>
                <td><?=$i++;?></td>
                <td>
                    <strong><?=htmlspecialchars($item['brand_name']);?></strong><br>
                    <small style="color: #666;"><?=htmlspecialchars($item['generic_composition']);?> (<?=$item['dosage_form'];?>)</small>
                </td>
                <td><?=htmlspecialchars($item['batch_no'] ?: 'BATCH-01');?></td>
                <td><?=(!empty($item['expiry_date'])) ? date('m/Y', strtotime($item['expiry_date'])) : '12/2027';?></td>
                <td class="text-center"><?=$item['quantity'];?></td>
                <td class="text-right"><?=number_format($item['unit_price'], 2);?></td>
                <td class="text-right"><?=number_format($item['total_price'], 2);?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Totals Breakdown -->
    <table class="totals-table">
        <tr>
            <td>Items Subtotal:</td>
            <td class="text-right">₹<?=number_format($order['item_total'] > 0 ? $order['item_total'] : $subtotal, 2);?></td>
        </tr>
        <tr>
            <td>Estimated GST (Included 12%):</td>
            <td class="text-right">₹<?=number_format(($order['item_total'] > 0 ? $order['item_total'] : $subtotal) * 0.107, 2);?></td>
        </tr>
        <tr>
            <td>UPCHAR Delivery Logistics:</td>
            <td class="text-right">₹<?=number_format($order['delivery_fee'], 2);?></td>
        </tr>
        <tr style="font-weight: bold; font-size: 15px; background: #F1F5F9;">
            <td>Total Invoice Value:</td>
            <td class="text-right">₹<?=number_format($order['total_amount'], 2);?></td>
        </tr>
    </table>

    <!-- Rider Pickup QR Code Section -->
    <div style="margin-top: 24px;">
        <div class="qr-section">
            <?php
            $qrData = urlencode("UPCHAR:ORDER:{$order['order_code']}:PHARM:{$order['pharmacy_id']}");
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=110x110&data={$qrData}";
            ?>
            <img src="<?=$qrUrl;?>" alt="Pickup QR Code" style="width: 100px; height: 100px; border: 1px solid #ccc; padding: 2px;">
            <div>
                <strong style="color: #08364B; font-size: 13.5px;">Rider Pickup & Chain-of-Custody Verification</strong>
                <p style="margin: 4px 0; font-size: 12px; color: #555;">
                    The UPCHAR delivery rider must scan this QR code upon collecting the package from the chemist counter.
                    Ensure the tamper-evident package seal is intact.
                </p>
                <span style="font-size: 12px; font-weight: bold; color: #08364B;">Pickup Code: <?=$order['order_code'];?></span>
            </div>
        </div>
    </div>

    <!-- Mandatory Regulatory Disclaimer -->
    <div class="legal-disclaimer">
        <strong>Statutory Healthcare Compliance:</strong><br>
        Dispensed and billed exclusively by <strong><?=htmlspecialchars($order['store_name']);?></strong>. 
        All medicines are verified by a registered pharmacist under the Drugs and Cosmetics Act, 1940. 
        UPCHAR acts solely as a technology intermediary & delivery logistics partner and does not sell or distribute drugs directly.
    </div>
</div>

</body>
</html>
