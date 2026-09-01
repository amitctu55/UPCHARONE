<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-mobile">
    <!-- Back to Queue Header -->
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
        <a href="<?=base_url('collector/dashboard');?>" class="btn btn-sm" style="background: #ffffff; border: 1px solid #cbd5e1; color: #475569; font-weight: 700; border-radius: 8px; padding: 6px 12px;">
            <i class="fa fa-arrow-left"></i> Queue
        </a>
        <h4 style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;">
            Order #<?=$task['booking_id'];?> Pickup
        </h4>
    </div>

    <!-- Live Step Tracker -->
    <?php
    $st = $task['collection_status'] ?: 'assigned';
    $steps = [
        'assigned'         => '1. Assigned',
        'en_route'         => '2. En Route',
        'arrived'          => '3. Arrived',
        'sample_collected' => '4. Collected',
        'handed_to_lab'    => '5. Lab Received'
    ];
    ?>
    <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 16px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
        <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 10px;">
            Pickup Status: <span id="currentStatusBadge" style="color: var(--col-teal);"><?=strtoupper(str_replace('_', ' ', $st));?></span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 4px; text-align: center; font-size: 10px; font-weight: 700;">
            <?php 
            $stKeys = array_keys($steps);
            $currIdx = array_search($st, $stKeys);
            foreach ($stKeys as $idx => $k): 
                $isActive = ($idx <= $currIdx);
            ?>
            <div>
                <div style="height: 6px; border-radius: 3px; background: <?=$isActive ? 'var(--col-teal)' : '#e2e8f0';?>; margin-bottom: 4px;"></div>
                <span style="color: <?=$isActive ? '#0f172a' : '#94a3b8';?>"><?=$idx + 1;?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Quick Status Advance Buttons -->
        <div style="margin-top: 14px; display: flex; flex-wrap: wrap; gap: 8px;">
            <?php if ($st === 'assigned'): ?>
                <button type="button" class="btn btn-sm btn-action-status" data-status="en_route" style="background: #0284c7; color: #fff; font-weight: 700; border-radius: 8px; flex-grow: 1; padding: 9px;">
                    <i class="fa fa-motorcycle"></i> Mark En Route
                </button>
            <?php elseif ($st === 'en_route'): ?>
                <button type="button" class="btn btn-sm btn-action-status" data-status="arrived" style="background: #d97706; color: #fff; font-weight: 700; border-radius: 8px; flex-grow: 1; padding: 9px;">
                    <i class="fa fa-map-marker"></i> Mark Arrived at Patient Home
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Patient Information Card -->
    <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 16px; margin-bottom: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
            <div>
                <h5 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">
                    <?=html_escape($task['patient_name'] ?: 'Patient');?>
                </h5>
                <span style="font-size: 12px; color: #64748b;">
                    Age: <?=$task['patient_age'] ?: 'N/A';?> &bull; Gender: <?=$task['patient_gender'] ?: 'M';?>
                </span>
            </div>
            <a href="tel:<?=$task['patient_mobile'];?>" class="btn btn-sm" style="background: #ecfdf5; border: 1px solid #10b981; color: #047857; font-weight: 700; border-radius: 8px; padding: 6px 14px;">
                <i class="fa fa-phone"></i> Call Patient
            </a>
        </div>

        <div style="background: #f8fafc; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; font-size: 13px;">
            <i class="fa fa-map-marker" style="color: #ef4444; margin-right: 4px;"></i>
            <strong><?=html_escape($task['patient_address'] ?: 'Doorstep Pickup, Lucknow');?></strong>
        </div>

        <a href="https://www.google.com/maps/dir/?api=1&destination=<?=urlencode($task['patient_address'] ?: 'Lucknow');?>" target="_blank" class="btn btn-sm btn-block" style="background: #0284c7; color: #ffffff; font-weight: 700; border-radius: 8px; padding: 10px; text-decoration: none; text-align: center;">
            <i class="fa fa-location-arrow"></i> Launch Google Maps Navigation
        </a>
    </div>

    <!-- Vial Barcode Scanner Section -->
    <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 16px; margin-bottom: 16px;">
        <h5 style="margin: 0 0 10px; font-size: 15px; font-weight: 800; color: #0f172a;">
            <i class="fa fa-barcode" style="color: var(--col-teal); margin-right: 6px;"></i> Link Sample Vial Barcode
        </h5>
        
        <p style="font-size: 12px; color: #64748b; margin-bottom: 12px;">
            Scan or enter the barcode printed on the blood/urine collection vial to bind it with this patient's test order.
        </p>

        <form id="barcodeForm" style="display: flex; gap: 8px; margin-bottom: 12px;">
            <input type="text" id="vialBarcodeVal" class="form-control" value="<?=html_escape($task['vial_barcode']);?>" placeholder="e.g. UPC-BAR-789012" style="border-radius: 8px; font-size: 14px; font-family: monospace; font-weight: 700;" required>
            <button type="submit" class="btn" style="background: var(--col-teal); color: #fff; font-weight: 700; border-radius: 8px; padding: 8px 16px; flex-shrink: 0;">
                <i class="fa fa-link"></i> Link
            </button>
        </form>

        <div id="barcodeMsg" style="display: none; font-size: 12px; padding: 8px 12px; border-radius: 6px;"></div>
    </div>

    <!-- Payment & Final Collection Confirmation -->
    <div style="background: #ffffff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 16px; margin-bottom: 24px;">
        <h5 style="margin: 0 0 8px; font-size: 15px; font-weight: 800; color: #0f172a;">
            <i class="fa fa-money" style="color: #16a34a; margin-right: 6px;"></i> Payment &amp; Sample Complete
        </h5>

        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="font-size: 12px; color: #166534; font-weight: 600;">Total Test Fee:</span>
                <div style="font-size: 20px; font-weight: 800; color: #15803d;">₹<?=number_format($task['amount'], 2);?></div>
            </div>
            <div>
                <span class="badge" style="background: <?=$task['payment_status']=='1' ? '#10b981' : '#f59e0b';?>; padding: 6px 12px; border-radius: 20px; font-size: 11px;">
                    <?=$task['payment_status']=='1' ? 'PAID ONLINE' : 'COLLECTION PENDING';?>
                </span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px;">
            <button type="button" class="btn btn-sm btn-block" onclick="showUpiQR(<?=$task['amount'];?>, <?=$task['booking_id'];?>)" style="background: #eff6ff; border: 1px solid #3b82f6; color: #1d4ed8; font-weight: 700; border-radius: 8px; padding: 10px;">
                <i class="fa fa-qrcode"></i> Instant UPI QR
            </button>
            <button type="button" class="btn btn-sm btn-block btn-collect-pay" data-mode="CASH" data-amount="<?=$task['amount'];?>" style="background: #ecfdf5; border: 1px solid #10b981; color: #047857; font-weight: 700; border-radius: 8px; padding: 10px;">
                <i class="fa fa-money"></i> Cash Collected
            </button>
        </div>

        <button type="button" class="btn btn-block btn-action-status" data-status="sample_collected" style="background: linear-gradient(135deg, #00a896 0%, #0284c7 100%); color: #ffffff; font-weight: 800; font-size: 15px; border-radius: 10px; padding: 12px; box-shadow: 0 4px 12px rgba(0,168,150,0.3);">
            <i class="fa fa-check-circle"></i> Complete &amp; Seal Sample
        </button>
    </div>
</div>

<!-- Modal for Dynamic UPI QR -->
<div class="modal fade" id="upiQrModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 16px; text-align: center; padding: 20px;">
            <h5 style="font-weight: 800; color: #0f172a; margin-top: 0;">Scan to Pay via UPI</h5>
            <p style="color: #64748b; font-size: 12.5px; margin-bottom: 14px;">Pay with GPay, PhonePe, Paytm, or BHIM</p>
            
            <div id="qrImageWrap" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 14px; display: inline-block;">
                <img id="upiQrImg" src="" alt="UPI QR" style="width: 180px; height: 180px;">
            </div>

            <div style="font-size: 18px; font-weight: 800; color: #00a896; margin-bottom: 14px;" id="upiAmountDisplay">
                ₹0.00
            </div>

            <button type="button" class="btn btn-block btn-collect-pay" data-mode="UPI_QR" data-amount="<?=$task['amount'];?>" style="background: #10b981; color: #fff; font-weight: 700; border-radius: 8px; padding: 10px;">
                <i class="fa fa-check"></i> Confirm Payment Received
            </button>
        </div>
    </div>
</div>

<script>
var bookingId = <?=$task['booking_id'];?>;

$('.btn-action-status').click(function() {
    var newSt = $(this).data('status');
    $.post('<?=base_url("collector/update_status");?>', { booking_id: bookingId, status: newSt }, function(res) {
        if (res.status === 'success') {
            alert(res.message);
            location.reload();
        } else {
            alert(res.message || 'Error updating status');
        }
    }, 'json');
});

$('#barcodeForm').submit(function(e) {
    e.preventDefault();
    var code = $('#vialBarcodeVal').val().trim();
    $.post('<?=base_url("collector/scan_barcode");?>', { booking_id: bookingId, barcode: code }, function(res) {
        if (res.status === 'success') {
            $('#barcodeMsg').removeClass('alert-danger').addClass('alert-success').text(res.message).fadeIn();
        } else {
            $('#barcodeMsg').removeClass('alert-success').addClass('alert-danger').text(res.message).fadeIn();
        }
    }, 'json');
});

$('.btn-collect-pay').click(function() {
    var mode = $(this).data('mode');
    var amt  = $(this).data('amount');
    if (confirm('Confirm payment of ₹' + amt + ' received via ' + mode + '?')) {
        $.post('<?=base_url("collector/complete_payment");?>', { booking_id: bookingId, payment_mode: mode, amount: amt }, function(res) {
            alert(res.message);
            location.reload();
        }, 'json');
    }
});

function showUpiQR(amount, orderId) {
    var upiPayload = "upi://pay?pa=upchar@icici&pn=Upchar%20Diagnostics&am=" + encodeURIComponent(amount) + "&tn=Order_" + orderId + "&cu=INR";
    var qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=" + encodeURIComponent(upiPayload);
    $('#upiQrImg').attr('src', qrUrl);
    $('#upiAmountDisplay').text('₹' + Number(amount).toFixed(2));
    $('#upiQrModal').modal('show');
}
</script>
