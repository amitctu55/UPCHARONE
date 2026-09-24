<?php include('includes/header.php'); ?>

<style>
/* Modern Order Tracking Suite Styles */
.track-page-header {
    background: linear-gradient(135deg, #08364B 0%, #0B4F6C 60%, #0284C7 100%);
    color: #FFFFFF;
    padding: 36px 0 28px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(8, 54, 75, 0.15);
}
.track-header-title {
    font-size: 26px;
    font-weight: 800;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.track-breadcrumb {
    font-size: 13px;
    color: #BAE6FD;
}
.track-breadcrumb a {
    color: #BAE6FD;
    text-decoration: none;
}
.track-breadcrumb a:hover {
    color: #FFFFFF;
    text-decoration: underline;
}

/* Tracking Card */
.tracking-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    padding: 24px;
    margin-bottom: 24px;
}
.tracking-card-title {
    font-size: 17px;
    font-weight: 800;
    color: #08364B;
    margin: 0 0 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Stepper Progress Bar */
.order-stepper {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin: 28px 0 32px;
    padding: 0 10px;
}
.order-stepper::before {
    content: '';
    position: absolute;
    top: 22px;
    left: 40px;
    right: 40px;
    height: 4px;
    background: #E2E8F0;
    z-index: 1;
}
.stepper-progress-fill {
    position: absolute;
    top: 22px;
    left: 40px;
    height: 4px;
    background: linear-gradient(90deg, #10B981, #00A8FF);
    z-index: 1;
    transition: width 0.5s ease;
}
.step-node {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
}
.step-icon-bubble {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 3px solid #CBD5E1;
    margin: 0 auto 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #94A3B8;
    transition: all 0.3s ease;
}
.step-node.completed .step-icon-bubble {
    background: #10B981;
    border-color: #10B981;
    color: #FFFFFF;
    box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
}
.step-node.active .step-icon-bubble {
    background: #00A8FF;
    border-color: #00A8FF;
    color: #FFFFFF;
    box-shadow: 0 0 0 5px rgba(0, 168, 255, 0.25);
    animation: pulse-bubble 2s infinite;
}
@keyframes pulse-bubble {
    0% { box-shadow: 0 0 0 0 rgba(0, 168, 255, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(0, 168, 255, 0); }
    100% { box-shadow: 0 0 0 0 rgba(0, 168, 255, 0); }
}
.step-label {
    font-size: 13px;
    font-weight: 700;
    color: #64748B;
}
.step-node.completed .step-label {
    color: #065F46;
}
.step-node.active .step-label {
    color: #00A8FF;
}
.step-subtext {
    font-size: 11px;
    color: #94A3B8;
    margin-top: 2px;
}

/* Doorstep Verification Cards */
.otp-display-card {
    background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
    border: 2px dashed #F59E0B;
    border-radius: 14px;
    padding: 22px;
    text-align: center;
    margin-bottom: 20px;
    box-shadow: 0 4px 14px rgba(245, 158, 11, 0.15);
}
.otp-digit-box {
    display: inline-flex;
    gap: 10px;
    margin: 12px 0;
}
.otp-single-digit {
    width: 44px;
    height: 52px;
    background: #FFFFFF;
    border: 2px solid #D97706;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 900;
    color: #08364B;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}

.qr-display-card {
    background: #FFFFFF;
    border: 2px solid #00A8FF;
    border-radius: 14px;
    padding: 22px;
    text-align: center;
    margin-bottom: 20px;
    box-shadow: 0 4px 16px rgba(0, 168, 255, 0.12);
}
.qr-code-img {
    width: 170px;
    height: 170px;
    border-radius: 12px;
    border: 3px solid #E0F2FE;
    padding: 6px;
    background: #FFFFFF;
    margin: 10px auto;
    display: block;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

/* Chemist & Rider Info Boxes */
.party-info-box {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 14px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.party-icon {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    background: #08364B;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.party-icon.rider {
    background: #00A8FF;
}

/* Simulation Action Buttons */
.btn-sim-advance {
    background: #08364B;
    color: #FFFFFF;
    border: none;
    font-weight: 700;
    font-size: 12.5px;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
    margin-right: 6px;
    margin-bottom: 6px;
}
.btn-sim-advance:hover {
    background: #00A8FF;
    color: #FFFFFF;
}

/* Confetti overlay */
#deliverySuccessOverlay {
    display: none;
    background: #ECFDF5;
    border: 2px solid #10B981;
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    margin-bottom: 24px;
    animation: fadeIn 0.4s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<!-- Header Banner -->
<div class="track-page-header">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            <div>
                <h1 class="track-header-title">
                    <i class="fas fa-shipping-fast" style="color: #38BDF8;"></i> Live Order &amp; Delivery Tracking
                </h1>
                <div class="track-breadcrumb">
                    <a href="<?=base_url();?>">Home</a> &gt; 
                    <a href="<?=base_url('cart');?>">Cart</a> &gt; 
                    <span>Order #<?=html_escape($order->order_code);?></span>
                </div>
            </div>
            <div>
                <span class="label" id="mainStatusBadge" style="font-size: 15px; padding: 8px 18px; border-radius: 20px; font-weight: 800; background: <?=$order->order_status === 'DELIVERED' ? '#10B981' : '#00A8FF';?>;">
                    <i class="fas <?=$order->order_status === 'DELIVERED' ? 'fa-check-circle' : 'fa-motorcycle';?>"></i> 
                    <span id="mainStatusText"><?=$order->order_status;?></span>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container" style="min-height: 520px; margin-bottom: 60px;">

    <!-- Delivered Success Alert Banner (Shows when order completes) -->
    <div id="deliverySuccessOverlay" style="<?=$order->order_status === 'DELIVERED' ? 'display: block;' : 'display: none;';?>">
        <div style="font-size: 48px; color: #10B981; margin-bottom: 8px;">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 style="margin: 0 0 6px; font-weight: 900; font-size: 24px; color: #065F46;">
            Order Delivered &amp; Completed!
        </h2>
        <p style="font-size: 14.5px; color: #047857; max-width: 600px; margin: 0 auto 14px;">
            The delivery partner verified your doorstep OTP / QR scan. Payment of <strong>&#8377;<?=number_format($order->total_amount, 2);?></strong> has been settled. Thank you for choosing UPCHAR!
        </p>
        <div style="display: flex; justify-content: center; gap: 12px;">
            <a href="<?=base_url('medical');?>" class="btn btn-sm" style="background: #08364B; color: #FFF; font-weight: 700; border-radius: 6px; padding: 7px 18px;">
                <i class="fas fa-pills"></i> Order More Medicines
            </a>
            <button type="button" class="btn btn-sm btn-default" onclick="window.print()" style="font-weight: 700; border-radius: 6px; padding: 7px 18px;">
                <i class="fas fa-print"></i> Print Invoice
            </button>
        </div>
    </div>

    <!-- Live Stepper Progress Tracker -->
    <div class="tracking-card">
        <div class="tracking-card-title">
            <span>Order Progress Timeline</span>
            <small style="font-size: 12px; color: #64748B; font-weight: 600;">
                <i class="fas fa-clock"></i> Placed: <?=date('d M Y, h:i A', strtotime($order->created_at));?>
            </small>
        </div>

        <?php
            // Calculate progress percentage
            $status = $order->order_status;
            $fillPercent = '10%';
            if ($status === 'PACKED' || $status === 'ASSIGNED') $fillPercent = '35%';
            if ($status === 'IN_TRANSIT') $fillPercent = '70%';
            if ($status === 'DELIVERED') $fillPercent = '100%';
        ?>

        <div class="order-stepper">
            <div class="stepper-progress-fill" id="stepperFill" style="width: <?=$fillPercent;?>;"></div>

            <!-- Step 1: Placed -->
            <div class="step-node completed" id="stepNodePlaced">
                <div class="step-icon-bubble"><i class="fas fa-shopping-bag"></i></div>
                <div class="step-label">Order Placed</div>
                <div class="step-subtext">Confirmed &amp; Logged</div>
            </div>

            <!-- Step 2: Store Packed -->
            <div class="step-node <?=in_array($status, ['PACKED', 'ASSIGNED', 'IN_TRANSIT', 'DELIVERED']) ? 'completed' : 'active';?>" id="stepNodePacked">
                <div class="step-icon-bubble"><i class="fas fa-box-open"></i></div>
                <div class="step-label">Pharmacy Packing</div>
                <div class="step-subtext">Chemist Sealed</div>
            </div>

            <!-- Step 3: Rider Store Pickup -->
            <div class="step-node <?=in_array($status, ['IN_TRANSIT', 'DELIVERED']) ? 'completed' : ($status === 'PACKED' || $status === 'ASSIGNED' ? 'active' : '');?>" id="stepNodePickup">
                <div class="step-icon-bubble"><i class="fas fa-store"></i></div>
                <div class="step-label">Rider Store Pickup</div>
                <div class="step-subtext" id="pickupSubtext"><?=$order->picked_up_at ? 'Picked up: ' . date('h:i A', strtotime($order->picked_up_at)) : 'Picked from store';?></div>
            </div>

            <!-- Step 4: Out for Delivery -->
            <div class="step-node <?=$status === 'DELIVERED' ? 'completed' : ($status === 'IN_TRANSIT' ? 'active' : '');?>" id="stepNodeTransit">
                <div class="step-icon-bubble"><i class="fas fa-motorcycle"></i></div>
                <div class="step-label">Out for Delivery</div>
                <div class="step-subtext">Heading to Doorstep</div>
            </div>

            <!-- Step 5: Delivered -->
            <div class="step-node <?=$status === 'DELIVERED' ? 'completed' : '';?>" id="stepNodeDelivered">
                <div class="step-icon-bubble"><i class="fas fa-home"></i></div>
                <div class="step-label">Delivered</div>
                <div class="step-subtext" id="deliveredSubtext"><?=$order->delivered_at ? date('h:i A', strtotime($order->delivered_at)) : 'OTP/QR Verified';?></div>
            </div>
        </div>

        <!-- Simulation Stage Advance Tools (Interactive Tester) -->
        <div style="background: #F1F5F9; border-radius: 10px; padding: 12px 16px; margin-top: 10px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <div style="font-size: 12px; color: #475569; font-weight: 700;">
                <i class="fas fa-cogs" style="color: #0284C7;"></i> Live Simulation Controls:
            </div>
            <div>
                <button type="button" class="btn-sim-advance" onclick="advanceStageAjax('PACKED')" title="Chemist packs medicines">
                    <i class="fas fa-box"></i> 1. Chemist: Pack Order
                </button>
                <button type="button" class="btn-sim-advance" onclick="advanceStageAjax('IN_TRANSIT')" title="Delivery boy arrives at store and picks up order">
                    <i class="fas fa-motorcycle"></i> 2. Rider: Pick Up from Store
                </button>
                <button type="button" class="btn-sim-advance" style="background: #059669;" onclick="openVerificationModal()" title="Verify OTP or QR code">
                    <i class="fas fa-qrcode"></i> 3. Doorstep Handover (OTP/QR)
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Store & Delivery Partner Pickup Info -->
        <div class="col-md-7">
            <!-- 1. Store Pickup Card ("show delevery come pic order from store") -->
            <div class="tracking-card">
                <h3 class="tracking-card-title">
                    <span><i class="fas fa-store" style="color: #0284C7;"></i> Store Pickup Details</span>
                    <span class="badge" style="background: #08364B; font-size: 11px;">VERIFIED CHEMIST</span>
                </h3>

                <!-- Dispensing Chemist -->
                <div class="party-info-box">
                    <div class="party-icon"><i class="fas fa-clinic-medical"></i></div>
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 4px; font-weight: 800; font-size: 15px; color: #08364B;">
                            <?=html_escape(!empty($order->store_name) ? $order->store_name : 'Apex Care Medicos & Chemist');?>
                        </h4>
                        <div style="font-size: 12.5px; color: #475569; line-height: 1.4; margin-bottom: 6px;">
                            <i class="fas fa-map-marker-alt" style="color: #0284C7;"></i> 
                            <?=html_escape(!empty($order->store_address) ? $order->store_address : 'Sigra / Luxa Road, Varanasi');?>
                            (<?=html_escape(!empty($order->store_city) ? $order->store_city : 'Varanasi');?>)
                        </div>
                        <div style="font-size: 12px; color: #059669; font-weight: 700;">
                            <i class="fas fa-phone-alt"></i> Store Contact: <?=html_escape(!empty($order->store_phone) ? $order->store_phone : '0542-224411');?>
                        </div>
                    </div>
                </div>

                <!-- Assigned Delivery Partner (Rider) -->
                <div class="party-info-box" style="background: #F0F9FF; border-color: #BAE6FD;">
                    <div class="party-icon rider"><i class="fas fa-motorcycle"></i></div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #0284C7;">Assigned Delivery Boy</div>
                                <h4 style="margin: 2px 0 4px; font-weight: 800; font-size: 15.5px; color: #08364B;" id="riderDisplayName">
                                    <?=html_escape(!empty($order->rider_full_name) ? $order->rider_full_name : (!empty($order->rider_name) ? $order->rider_name : 'Rahul Yadav'));?>
                                </h4>
                            </div>
                            <a href="tel:<?=html_escape(!empty($order->rider_phone) ? $order->rider_phone : '9839001122');?>" class="btn btn-xs" style="background: #0284C7; color: #FFFFFF; font-weight: 700; border-radius: 6px; padding: 4px 10px;">
                                <i class="fas fa-phone"></i> Call Rider
                            </a>
                        </div>
                        
                        <div style="font-size: 12.5px; color: #334155; margin-bottom: 6px;">
                            <i class="fas fa-id-badge" style="color: #0284C7;"></i> Vehicle: <strong><?=html_escape(!empty($order->vehicle_number) ? $order->vehicle_number : 'UP-65-AX-4412');?></strong> 
                            (<?=html_escape(!empty($order->vehicle_type) ? $order->vehicle_type : 'Bike');?>)
                        </div>

                        <!-- Live Status Message -->
                        <div id="riderStatusBox" style="background: #FFFFFF; border-radius: 8px; padding: 8px 12px; font-size: 12px; color: #0369A1; font-weight: 600; border: 1px solid #BAE6FD;">
                            <?php if ($order->order_status === 'DELIVERED'): ?>
                                <i class="fas fa-check-circle" style="color: #10B981;"></i> Rider completed delivery at your doorstep.
                            <?php elseif ($order->order_status === 'IN_TRANSIT'): ?>
                                <i class="fas fa-motorcycle" style="color: #0284C7;"></i> <strong>Rider came and picked up order from store!</strong> En route to your address.
                            <?php elseif ($order->order_status === 'PACKED' || $order->order_status === 'ASSIGNED'): ?>
                                <i class="fas fa-spinner fa-spin" style="color: #D97706;"></i> <strong>Rider is arriving at store to pick up your order.</strong>
                            <?php else: ?>
                                <i class="fas fa-clock"></i> Chemist is preparing and packing your medicines.
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Destination Address -->
                <div style="border-top: 1px solid #F1F5F9; padding-top: 14px; font-size: 13px; color: #475569;">
                    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748B;">Recipient &amp; Delivery Address</div>
                    <strong style="color: #08364B; font-size: 14px;"><?=html_escape($order->customer_name);?></strong> 
                    &bull; <span style="color: #0284C7; font-weight: 700;"><?=html_escape($order->customer_phone);?></span>
                    <div style="margin-top: 3px;"><?=html_escape($order->delivery_address);?></div>
                </div>
            </div>

            <!-- Ordered Medicines List -->
            <div class="tracking-card">
                <h3 class="tracking-card-title">
                    <span><i class="fas fa-pills" style="color: #0284C7;"></i> Medicines in Order (<?=count($order->items);?>)</span>
                </h3>

                <div style="margin-bottom: 12px;">
                    <?php foreach ($order->items as $it): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #F1F5F9;">
                            <div>
                                <div style="font-weight: 700; font-size: 14px; color: #08364B;">
                                    <?=html_escape($it->brand_name);?>
                                    <span style="font-size: 11px; background: #F1F5F9; color: #475569; padding: 2px 6px; border-radius: 4px;">
                                        Qty: <?=$it->quantity;?>
                                    </span>
                                </div>
                                <div style="font-size: 12px; color: #64748B;">
                                    <?=html_escape($it->generic_composition);?> &bull; Batch: <?=html_escape($it->batch_no);?>
                                </div>
                            </div>
                            <div style="text-align: right; font-weight: 800; font-size: 14px; color: #08364B;">
                                &#8377;<?=number_format($it->total_price, 2);?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 6px;">
                    <span>Items Total</span>
                    <span>&#8377;<?=number_format($order->item_total, 2);?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 8px;">
                    <span>Doorstep Delivery Fee</span>
                    <span><?=$order->delivery_fee > 0 ? '&#8377;' . number_format($order->delivery_fee, 2) : '<span style="color: #059669; font-weight: 700;">FREE</span>';?></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 900; color: #08364B; border-top: 1px solid #E2E8F0; padding-top: 10px;">
                    <span>Grand Total Payable</span>
                    <span style="color: #059669;">&#8377;<?=number_format($order->total_amount, 2);?></span>
                </div>
                <div style="font-size: 12px; color: #64748B; margin-top: 6px; text-align: right;">
                    Payment Mode: <strong><?=html_escape($order->payment_mode);?></strong> &bull; 
                    Status: <span id="paymentStatusBadge" class="label label-<?=$order->payment_status === 'PAID' ? 'success' : 'warning';?>"><?=$order->payment_status;?></span>
                </div>
            </div>
        </div>

        <!-- Right Column: OTP & QR Code Doorstep Verification Suite -->
        <div class="col-md-5">
            <!-- 1. 4-Digit Delivery OTP Card -->
            <div class="otp-display-card">
                <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: #92400E; letter-spacing: 0.5px;">
                    <i class="fas fa-shield-alt"></i> Doorstep Delivery OTP
                </div>
                <div style="font-size: 13px; color: #78350F; margin-top: 4px;">
                    Share this 4-digit code with the delivery partner upon arrival:
                </div>

                <div class="otp-digit-box">
                    <?php 
                        $digits = str_split(str_pad(strval($order->delivery_otp), 4, '0', STR_PAD_LEFT));
                        foreach ($digits as $d): 
                    ?>
                        <div class="otp-single-digit"><?=$d;?></div>
                    <?php endforeach; ?>
                </div>

                <div style="font-size: 11.5px; color: #92400E; line-height: 1.4;">
                    <i class="fas fa-info-circle"></i> Verify package seal intact before sharing this OTP.
                </div>
            </div>

            <!-- 2. Digital QR Code Verification Card -->
            <div class="qr-display-card">
                <div style="font-size: 13px; font-weight: 800; text-transform: uppercase; color: #08364B; letter-spacing: 0.5px;">
                    <i class="fas fa-qrcode" style="color: #00A8FF;"></i> Or Scan QR to Verify Order
                </div>
                <div style="font-size: 12px; color: #64748B; margin-top: 2px;">
                    Delivery boy can scan this code with their phone camera to instantly complete the delivery.
                </div>

                <?php 
                    $qrScanUrl = base_url('cart/verify_qr?order_id=' . $order->id . '&qr_token=' . $order->qr_token . '&redirect=1');
                    $qrImgUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($qrScanUrl);
                ?>
                <img src="<?=$qrImgUrl;?>" alt="Delivery Verification QR" class="qr-code-img" id="deliveryQrImage">

                <div style="margin-top: 8px;">
                    <button type="button" class="btn btn-sm" onclick="simulateQrScan()" style="background: #0284C7; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 7px 16px; font-size: 12.5px;">
                        <i class="fas fa-camera"></i> Simulate Delivery Boy QR Scan
                    </button>
                </div>
            </div>

            <!-- 3. Delivery Boy Handover Form (Enter OTP to Complete) -->
            <div class="tracking-card" style="border-top: 3px solid #10B981;">
                <h3 class="tracking-card-title" style="font-size: 15px;">
                    <span><i class="fas fa-user-check" style="color: #10B981;"></i> Delivery Partner Console</span>
                    <span class="badge" style="background: #10B981;">HANDOVER</span>
                </h3>
                
                <p style="font-size: 12.5px; color: #64748B; margin-bottom: 12px;">
                    When delivery boy reaches your doorstep, he enters your OTP here or scans your QR code to complete the handover.
                </p>

                <div id="otpVerifyFormBlock">
                    <div class="form-group" style="margin-bottom: 10px;">
                        <label style="font-size: 12px; font-weight: 700; color: #334155;">Enter 4-Digit OTP to Complete Order:</label>
                        <div class="input-group">
                            <input type="text" id="inputDeliveryOtp" class="form-control" placeholder="e.g. <?=$order->delivery_otp;?>" maxlength="4" style="font-size: 18px; font-weight: 900; letter-spacing: 4px; text-align: center; height: 44px; border-radius: 8px 0 0 8px;">
                            <span class="input-group-btn">
                                <button type="button" class="btn" id="btnSubmitOtp" onclick="submitOtpVerification()" style="background: #10B981; color: #FFFFFF; font-weight: 800; height: 44px; padding: 0 18px; border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-check"></i> Complete
                                </button>
                            </span>
                        </div>
                    </div>
                    <div id="otpFeedbackAlert" style="display: none; padding: 8px 12px; border-radius: 6px; font-size: 12px; margin-top: 8px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const orderId = <?=intval($order->id);?>;
const expectedOtp = '<?=html_escape($order->delivery_otp);?>';
const qrToken = '<?=html_escape($order->qr_token);?>';

// Submit 4-digit OTP
function submitOtpVerification() {
    const inputOtp = $('#inputDeliveryOtp').val().trim();
    if (!inputOtp || inputOtp.length !== 4) {
        showOtpFeedback('Please enter the complete 4-digit OTP.', 'danger');
        return;
    }

    const $btn = $('#btnSubmitOtp');
    const origText = $btn.html();
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

    $.ajax({
        url: '<?=base_url("cart/verify_otp");?>',
        type: 'POST',
        data: {
            order_id: orderId,
            otp: inputOtp
        },
        dataType: 'json',
        success: function(resp) {
            $btn.prop('disabled', false).html(origText);
            if (resp.status === 'success') {
                showOtpFeedback(resp.message || 'OTP verified successfully!', 'success');
                markOrderDeliveredUI();
            } else {
                showOtpFeedback(resp.message || 'Incorrect OTP code.', 'danger');
            }
        },
        error: function() {
            $btn.prop('disabled', false).html(origText);
            showOtpFeedback('Network error verifying OTP.', 'danger');
        }
    });
}

// 1-Click Simulate QR Scan
function simulateQrScan() {
    if (!confirm('Simulate delivery partner scanning the customer QR Code now?')) {
        return;
    }

    $.ajax({
        url: '<?=base_url("cart/verify_qr");?>',
        type: 'POST',
        data: {
            order_id: orderId,
            qr_token: qrToken
        },
        dataType: 'json',
        success: function(resp) {
            if (resp.status === 'success') {
                showOtpFeedback('QR Code Verified! Order marked DELIVERED.', 'success');
                markOrderDeliveredUI();
            } else {
                showOtpFeedback(resp.message || 'QR verification failed.', 'danger');
            }
        },
        error: function() {
            showOtpFeedback('Network error during QR scan simulation.', 'danger');
        }
    });
}

// Advance Order Stage (Simulate store packing -> rider store pickup)
function advanceStageAjax(targetStage) {
    $.ajax({
        url: '<?=base_url("cart/advance_stage");?>',
        type: 'POST',
        data: {
            order_id: orderId,
            target_stage: targetStage
        },
        dataType: 'json',
        success: function(resp) {
            if (resp.status === 'success') {
                updateTrackingUI(resp.new_status);
            }
        }
    });
}

function showOtpFeedback(msg, type) {
    const $box = $('#otpFeedbackAlert');
    $box.removeClass('alert-success alert-danger')
        .addClass(type === 'success' ? 'alert alert-success' : 'alert alert-danger')
        .html(msg)
        .slideDown(200);
}

function markOrderDeliveredUI() {
    updateTrackingUI('DELIVERED');
    $('#deliverySuccessOverlay').slideDown(400);
    // Smooth scroll to success
    window.scrollTo({ top: 100, behavior: 'smooth' });
}

function updateTrackingUI(status) {
    $('#mainStatusText').text(status);
    
    if (status === 'PACKED' || status === 'ASSIGNED') {
        $('#stepperFill').css('width', '35%');
        $('#stepNodePlaced').addClass('completed');
        $('#stepNodePacked').addClass('completed').removeClass('active');
        $('#stepNodePickup').addClass('active');
        $('#riderStatusBox').html('<i class="fas fa-spinner fa-spin" style="color: #D97706;"></i> <strong>Rider is arriving at store to pick up your order.</strong>');
    } else if (status === 'IN_TRANSIT') {
        $('#stepperFill').css('width', '70%');
        $('#stepNodePlaced, #stepNodePacked, #stepNodePickup').addClass('completed').removeClass('active');
        $('#stepNodeTransit').addClass('active');
        $('#pickupSubtext').text('Picked from store');
        $('#riderStatusBox').html('<i class="fas fa-motorcycle" style="color: #0284C7;"></i> <strong>Rider came and picked up order from store!</strong> En route to your doorstep.');
    } else if (status === 'DELIVERED') {
        $('#stepperFill').css('width', '100%');
        $('#stepNodePlaced, #stepNodePacked, #stepNodePickup, #stepNodeTransit, #stepNodeDelivered').addClass('completed').removeClass('active');
        $('#mainStatusBadge').css('background', '#10B981').html('<i class="fas fa-check-circle"></i> DELIVERED');
        $('#paymentStatusBadge').removeClass('label-warning').addClass('label-success').text('PAID');
        $('#riderStatusBox').html('<i class="fas fa-check-circle" style="color: #10B981;"></i> Rider completed delivery at your doorstep.');
        $('#deliveredSubtext').text('Just Now');
    }
}

function openVerificationModal() {
    $('#inputDeliveryOtp').val(expectedOtp).focus();
}
</script>

<?php include('includes/footer.php'); ?>
