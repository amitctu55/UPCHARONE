<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPCHAR Express Fleet — Rider Delivery Console</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        :root {
            --navy: #08364B;
            --cyan: #00A8FF;
            --green: #10B981;
            --red: #EF4444;
        }
        body {
            background-color: #F1F5F9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding-bottom: 50px;
        }
        .rider-header {
            background: var(--navy);
            color: #FFF;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .rider-card {
            background: #FFF;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            margin-bottom: 16px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .rider-card-header {
            background: #F8FAFC;
            padding: 12px 18px;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .rider-card-body {
            padding: 16px 18px;
        }
        .btn-handoff {
            background: #2563EB;
            color: #FFF;
            border: none;
            font-weight: 700;
            padding: 10px 16px;
            border-radius: 8px;
            width: 100%;
        }
        .btn-otp {
            background: #10B981;
            color: #FFF;
            border: none;
            font-weight: 700;
            padding: 10px 16px;
            border-radius: 8px;
            width: 100%;
        }
        .status-pill {
            font-size: 11px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="rider-header">
    <div>
        <h4 style="margin: 0; font-weight: 800;">
            <i class="fas fa-motorcycle" style="color: var(--cyan);"></i> UPCHAR Rider Field Console
        </h4>
        <small style="color: #94A3B8;">Delivery Fleet & Secure OTP Handover</small>
    </div>
    <div>
        <!-- Switch Rider -->
        <select class="form-control input-sm" onchange="location.href='<?=base_url('delivery/console?rider_id=');?>'+this.value" style="background: #042433; color: #FFF; border: 1px solid #1c6182;">
            <?php foreach($riders as $r): ?>
            <option value="<?=$r['id'];?>" <?=$r['id'] == $current_rider['id'] ? 'selected' : '';?>>
                <?=$r['rider_name'];?> (<?=$r['vehicle_number'];?>) - <?=$r['status'];?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="container" style="max-width: 680px; margin-top: 20px;">
    <!-- Active Rider Profile -->
    <div style="background: #FFF; border-radius: 10px; padding: 14px 18px; border: 1px solid #E2E8F0; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <strong style="font-size: 16px; color: var(--navy);"><?=htmlspecialchars($current_rider['rider_name']);?></strong>
            <div style="font-size: 12.5px; color: #64748B;">
                <i class="fas fa-id-card"></i> Vehicle: <?=htmlspecialchars($current_rider['vehicle_number']);?> &bull; Phone: <?=htmlspecialchars($current_rider['phone']);?>
            </div>
        </div>
        <div>
            <span class="label label-<?=$current_rider['status'] === 'AVAILABLE' ? 'success' : 'warning';?>" style="font-size: 12px; padding: 5px 12px; border-radius: 20px;">
                <?=$current_rider['status'];?>
            </span>
        </div>
    </div>

    <h4 style="font-weight: 800; color: var(--navy); margin-bottom: 14px;">
        <i class="fas fa-tasks"></i> Active Delivery Assignments (<?=count($orders);?>)
    </h4>

    <?php if (empty($orders)): ?>
    <div class="text-center" style="background: #FFF; padding: 40px; border-radius: 12px; border: 1px solid #E2E8F0; color: #64748B;">
        <i class="fas fa-box-open" style="font-size: 40px; color: #CBD5E1; margin-bottom: 12px;"></i>
        <p>No active delivery batches assigned to this rider at the moment.</p>
    </div>
    <?php else: ?>
        <?php foreach($orders as $ord): ?>
        <div class="rider-card">
            <div class="rider-card-header">
                <div>
                    <strong style="font-size: 15px; color: var(--navy);"><?=$ord['order_code'];?></strong>
                </div>
                <div>
                    <span class="status-pill label label-<?=$ord['order_status'] === 'DELIVERED' ? 'success' : ($ord['order_status'] === 'IN_TRANSIT' ? 'primary' : 'default');?>">
                        <?=$ord['order_status'];?>
                    </span>
                </div>
            </div>
            <div class="rider-card-body">
                <div style="margin-bottom: 12px;">
                    <div style="font-size: 12px; font-weight: bold; color: #64748B;">1. PHARMACY PICKUP</div>
                    <div style="font-weight: bold; color: #0F172A;"><?=htmlspecialchars($ord['store_name']);?></div>
                    <div style="font-size: 12px; color: #475569;"><?=htmlspecialchars($ord['store_address']);?></div>
                </div>

                <div style="margin-bottom: 16px;">
                    <div style="font-size: 12px; font-weight: bold; color: #64748B;">2. PATIENT DELIVERY</div>
                    <div style="font-weight: bold; color: #0F172A;"><?=htmlspecialchars($ord['customer_name']);?> &bull; <?=htmlspecialchars($ord['customer_phone']);?></div>
                    <div style="font-size: 12px; color: #475569;"><?=htmlspecialchars($ord['delivery_address']);?></div>
                    <div style="font-size: 13px; font-weight: bold; color: var(--navy); margin-top: 4px;">
                        Collect Amount: ₹<?=number_format($ord['total_amount'], 2);?> (<?=$ord['payment_mode'];?>)
                    </div>
                </div>

                <!-- Action 1: Pickup Handoff -->
                <?php if (in_array($ord['order_status'], ['PACKED', 'ASSIGNED'])): ?>
                <button class="btn-handoff" onclick="confirmChemistHandoff('<?=$ord['order_code'];?>')">
                    <i class="fas fa-qrcode"></i> Scan / Confirm Chemist Sealed Pickup
                </button>
                <?php endif; ?>

                <!-- Action 2: Doorstep OTP Verification -->
                <?php if ($ord['order_status'] === 'IN_TRANSIT'): ?>
                <button class="btn-otp" onclick="openOtpModal('<?=$ord['order_code'];?>', '<?=number_format($ord['total_amount'], 2);?>')">
                    <i class="fas fa-key"></i> Customer Doorstep OTP Handover
                </button>
                <?php endif; ?>

                <?php if ($ord['order_status'] === 'DELIVERED'): ?>
                <div class="alert alert-success" style="margin-bottom: 0; padding: 8px 12px; font-size: 12.5px; text-align: center;">
                    <i class="fas fa-check-circle"></i> Successfully Delivered on <?=date('d M, h:i A', strtotime($ord['delivered_at']));?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal: OTP Input -->
<div class="modal fade" id="otpModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--navy); color: #FFF;">
                <button type="button" class="close" data-dismiss="modal" style="color: #FFF;">&times;</button>
                <h4 class="modal-title"><i class="fas fa-shield-alt"></i> Verify Delivery OTP</h4>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" id="otpOrderCode">
                <p style="font-size: 13px; color: #475569;">
                    Ask the customer for the 4-digit OTP sent to their mobile via SMS upon dispatch.
                </p>
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 12px; color: var(--navy);">
                    Collect Cash: ₹<span id="otpAmount">0.00</span>
                </div>
                <input type="text" id="deliveryOtpInput" class="form-control input-lg text-center" placeholder="4-Digit OTP" maxlength="6" style="font-size: 24px; font-weight: bold; letter-spacing: 6px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitDeliveryOtp()">
                    Verify & Complete Delivery
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmChemistHandoff(orderCode) {
    if (!confirm('Confirm that you have physically received the sealed medicine package from the chemist counter and verified the QR code?')) return;

    $.ajax({
        url: '<?=base_url("api/v1/delivery/chemist-handoff");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_code: orderCode,
            rider_id: <?=$current_rider['id'];?>
        }),
        success: function(resp) {
            alert(resp.message + '\nPatient has been sent the delivery OTP.');
            location.reload();
        },
        error: function(xhr) {
            const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error confirming handoff';
            alert('Error: ' + msg);
        }
    });
}

function openOtpModal(orderCode, amount) {
    $('#otpOrderCode').val(orderCode);
    $('#otpAmount').text(amount);
    $('#deliveryOtpInput').val('');
    $('#otpModal').modal('show');
}

function submitDeliveryOtp() {
    const code = $('#otpOrderCode').val();
    const otp = $('#deliveryOtpInput').val().trim();

    if (!otp || otp.length < 4) {
        alert('Please enter a valid 4-digit OTP.');
        return;
    }

    $.ajax({
        url: '<?=base_url("api/v1/delivery/verify-otp");?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            order_code: code,
            otp: otp,
            rider_id: <?=$current_rider['id'];?>
        }),
        success: function(resp) {
            $('#otpModal').modal('hide');
            alert('🎉 Delivery verified and completed successfully! You are now free for the next delivery.');
            location.reload();
        },
        error: function(xhr) {
            const msg = xhr.responseJSON ? xhr.responseJSON.message : 'OTP Verification failed';
            alert('❌ ' + msg);
        }
    });
}
</script>

</body>
</html>
