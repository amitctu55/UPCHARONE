<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GST Tax Invoice - {{ $order->order_code }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #F1F5F9;
            color: #0F172A;
            padding: 30px 15px;
        }
        .invoice-box {
            max-width: 800px;
            margin: 0 auto;
            background: #FFF;
            padding: 30px 36px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #E2E8F0;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #08364B;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .invoice-title {
            font-size: 22px;
            font-weight: 900;
            color: #08364B;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .store-details {
            font-size: 13px;
            color: #475569;
            line-height: 1.5;
        }
        .invoice-meta {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 12px 18px;
            margin-bottom: 20px;
        }
        .table-invoice th {
            background: #08364B;
            color: #FFF;
            font-size: 11.5px;
            text-transform: uppercase;
            padding: 8px 12px !important;
        }
        .table-invoice td {
            font-size: 12.5px;
            padding: 9px 12px !important;
        }
        .signature-block {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 20px;
            border-top: 1px dashed #CBD5E1;
        }
        @media print {
            body { background: #FFF; padding: 0; }
            .invoice-box { box-shadow: none; border: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="no-print text-right" style="margin-bottom: 18px;">
        <button onclick="window.print()" class="btn btn-primary" style="background: #08364B; font-weight: 700;">
            <i class="fas fa-print"></i> Print GST Tax Invoice (A4 / Thermal)
        </button>
        <button onclick="window.close()" class="btn btn-default" style="font-weight: 600;">Close</button>
    </div>

    <!-- Header -->
    <div class="invoice-header">
        <div>
            <h1 class="invoice-title">Tax Invoice / Bill of Supply</h1>
            <div class="store-details" style="margin-top: 6px;">
                <strong style="color: #08364B; font-size: 15px;">{{ $pharmacy->fname ?? 'Sanjivani 24x7 Chemist & Druggists' }}</strong><br>
                <span>{{ $pharmacy->street ?? 'Plot 42, Maldahiya Crossing' }}, {{ $pharmacy->city ?? 'Varanasi' }}</span><br>
                <span><strong>Drug License No:</strong> {{ $pharmacy->regd_no ?? 'DL-UP-VNS-21-44589' }} (Form 20/21)</span><br>
                <span><strong>GSTIN:</strong> 09BBACB2233E2Z5 &bull; <strong>Phone:</strong> {{ $pharmacy->mobile ?? '9450223344' }}</span>
            </div>
        </div>
        <div class="text-right">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data={{ urlencode($order->order_code) }}" alt="Order QR Code" style="border: 1px solid #CBD5E1; padding: 4px; border-radius: 6px;">
            <div style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Rider Pickup QR</div>
        </div>
    </div>

    <!-- Meta Details -->
    <div class="row invoice-meta">
        <div class="col-xs-6">
            <span style="font-size: 11px; color: #64748B; font-weight: 700;">PATIENT DETAILS:</span>
            <div style="font-weight: 800; font-size: 14px; color: #08364B;">{{ $order->customer_name ?? 'Patient' }}</div>
            <div style="font-size: 12.5px; color: #475569;">Phone: {{ $order->customer_phone ?? '9839112233' }}</div>
            <div style="font-size: 12px; color: #64748B;">Address: {{ $order->delivery_address ?? 'Varanasi' }}</div>
        </div>
        <div class="col-xs-6 text-right">
            <div><span style="color: #64748B; font-size: 12px;">Invoice / Order Code:</span> <strong style="color: #08364B;">{{ $order->order_code }}</strong></div>
            <div><span style="color: #64748B; font-size: 12px;">Date:</span> <strong>{{ date('d-m-Y H:i', strtotime($order->created_at)) }}</strong></div>
            <div><span style="color: #64748B; font-size: 12px;">Payment Mode:</span> <strong class="text-success">{{ $order->payment_mode ?? 'COD' }}</strong></div>
            <div><span style="color: #64748B; font-size: 12px;">Doorstep Verification OTP:</span> <strong style="font-size: 16px; color: #D97706; letter-spacing: 2px;">{{ $order->delivery_otp }}</strong></div>
        </div>
    </div>

    <!-- Medicines Itemized Table -->
    <table class="table table-bordered table-invoice">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 38%;">Medicine / Salt Composition</th>
                <th style="width: 12%;">HSN</th>
                <th style="width: 12%;">Batch &bull; Exp</th>
                <th style="width: 8%; text-align: center;">Qty</th>
                <th style="width: 12%; text-align: right;">Unit Rate</th>
                <th style="width: 13%; text-align: right;">Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach($items as $idx => $it)
            @php $subtotal += $it->total_price; @endphp
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>
                    <strong>{{ $it->brand_name }}</strong>
                    <div style="font-size: 11px; color: #64748B;">{{ $it->generic_composition }}</div>
                </td>
                <td>{{ $it->hsn_code ?? '3004' }}</td>
                <td>
                    <small>BATCH-26B</small><br>
                    <small style="color: #64748B;">07/28</small>
                </td>
                <td style="text-align: center; font-weight: 700;">{{ $it->quantity }}</td>
                <td style="text-align: right;">₹{{ number_format($it->unit_price, 2) }}</td>
                <td style="text-align: right; font-weight: 800;">₹{{ number_format($it->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals & Statutory Tax Calculations -->
    @php
        $taxable = $subtotal / 1.12;
        $gstAmt = $subtotal - $taxable;
        $cgst = $gstAmt / 2;
        $sgst = $gstAmt / 2;
        $deliveryFee = $order->delivery_fee ?? 40.00;
        $grandTotal = $subtotal + $deliveryFee;
    @endphp
    <div class="row">
        <div class="col-xs-7">
            <div style="font-size: 11.5px; color: #64748B; line-height: 1.6;">
                <strong>Statutory Notes:</strong><br>
                1. Goods once sold will be taken back only as per the Drug Controller rules.<br>
                2. Storage instructions: Store below 25°C in a dry place.<br>
                3. Intermediary technology services provided by UPCHAR.
            </div>
        </div>
        <div class="col-xs-5">
            <table class="table table-condensed text-right" style="font-size: 12.5px;">
                <tr>
                    <td style="border: none;">Item Subtotal:</td>
                    <td style="border: none; font-weight: 700;">₹{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>CGST (6%):</td>
                    <td>₹{{ number_format($cgst, 2) }}</td>
                </tr>
                <tr>
                    <td>SGST (6%):</td>
                    <td>₹{{ number_format($sgst, 2) }}</td>
                </tr>
                <tr>
                    <td>Doorstep Delivery Logistics:</td>
                    <td>₹{{ number_format($deliveryFee, 2) }}</td>
                </tr>
                <tr style="font-size: 16px; font-weight: 900; color: #08364B; background: #F8FAFC;">
                    <td>Grand Total:</td>
                    <td>₹{{ number_format($grandTotal, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Sign-off -->
    <div class="signature-block">
        <div>
            <div style="font-size: 11px; color: #64748B;">Packed under supervision of:</div>
            <div style="font-weight: 700; color: #08364B;">Registered Pharmacist (Reg # UP-PH-88412)</div>
        </div>
        <div class="text-right">
            <div style="height: 40px;"></div>
            <div style="font-size: 12px; font-weight: 800; border-top: 1px solid #08364B; display: inline-block; padding-top: 4px; min-width: 180px;">
                Authorised Chemist Signatory
            </div>
        </div>
    </div>
</div>

</body>
</html>
