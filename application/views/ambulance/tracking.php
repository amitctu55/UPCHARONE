<?php defined("BASEPATH") OR exit("No direct script access allowed"); ?>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<!-- Leaflet CSS & JS for Interactive Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
.tracking-wrapper {
    background: #f8fafc;
    min-height: calc(100vh - 120px);
    padding: 40px 15px 60px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #0f172a;
}
.tracking-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 36px 32px;
    max-width: 860px;
    margin: 0 auto;
    box-shadow: 0 20px 45px -15px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.8);
}
.tracking-header {
    text-align: center;
    margin-bottom: 26px;
}
.tracking-icon-circle {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    background: #fee2e2;
    color: #dc2626;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 12px;
}
.tracking-header h2 {
    font-family: 'Outfit', sans-serif;
    font-size: 2.1rem;
    font-weight: 900;
    color: #0f172a;
    margin: 0 0 6px;
}
.tracking-header p {
    color: #64748b;
    font-size: 14.5px;
    margin: 0;
}
.tracking-search-bar {
    display: flex;
    gap: 10px;
    max-width: 500px;
    margin: 0 auto 24px;
}
.tracking-input {
    flex-grow: 1;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 18px;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    background: #f8fafc;
    transition: all 0.2s ease;
}
.tracking-input:focus {
    border-color: #dc2626;
    background: #ffffff;
    outline: none;
    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
}
.btn-track-search {
    background: #0f172a;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-size: 14.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-track-search:hover {
    background: #dc2626;
}

/* Trip Stepper */
.trip-stepper {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 28px;
}
.trip-stepper::before {
    content: '';
    position: absolute;
    top: 18px;
    left: 40px;
    right: 40px;
    height: 4px;
    background: #e2e8f0;
    z-index: 1;
}
.step-node {
    position: relative;
    z-index: 2;
    text-align: center;
    width: 25%;
}
.step-dot {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #94a3b8;
    border: 3px solid #ffffff;
    box-shadow: 0 0 0 2px #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 800;
    margin: 0 auto 8px;
    transition: all 0.2s;
}
.step-node.active .step-dot {
    background: #dc2626;
    color: #ffffff;
    box-shadow: 0 0 0 2px #dc2626, 0 4px 12px rgba(220, 38, 38, 0.4);
}
.step-node.completed .step-dot {
    background: #10b981;
    color: #ffffff;
    box-shadow: 0 0 0 2px #10b981;
}
.step-title {
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
}
.step-node.active .step-title {
    color: #dc2626;
    font-weight: 800;
}

/* Map Frame */
#ambMap {
    height: 360px;
    width: 100%;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
    margin-bottom: 24px;
}

/* Driver / Paramedic Card */
.driver-card-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}
.driver-avatar-circle {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: linear-gradient(135deg, #0d7a6e 0%, #064e3b 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 800;
}
</style>

<div class="tracking-wrapper">
  <div class="container">
    <div class="tracking-card">
      
      <!-- Header -->
      <div class="tracking-header">
        <div class="tracking-icon-circle">
          <i class="fas fa-satellite-dish fa-spin"></i>
        </div>
        <h2>Live Ambulance GPS Telemetry</h2>
        <p>Real-time vehicle positioning, estimated arrival time, and hospital triage handoff.</p>
      </div>

      <!-- Quick Search Bar -->
      <form method="GET" action="<?=base_url('ambulance/tracking');?>" class="tracking-search-bar">
        <input type="text" name="ref" class="tracking-input" id="trackingRefInput" placeholder="Enter Booking Code (e.g. UPAMB-2026-...)" value="<?=htmlspecialchars($ref ?? '');?>">
        <button type="submit" class="btn-track-search">
          <i class="fas fa-search-location"></i> Track
        </button>
      </form>

      <?php if(!empty($booking)): ?>
        <?php
            $bStatus = strtoupper(trim($booking['status'] ?? 'REQUESTED'));
            $is_assigned = in_array($bStatus, ['ASSIGNED', 'ARRIVED_PICKUP', 'IN_TRANSIT', 'ARRIVED_HOSPITAL', 'COMPLETED']);
            $is_enroute  = in_array($bStatus, ['IN_TRANSIT', 'ARRIVED_HOSPITAL', 'COMPLETED']);
            $is_done     = ($bStatus === 'COMPLETED');
            $is_canc     = ($bStatus === 'CANCELLED');
            $pickupLat   = floatval($booking['pickup_latitude'] ?? 25.3176);
            $pickupLng   = floatval($booking['pickup_longitude'] ?? 82.9739);
            $dropLat     = floatval($booking['drop_latitude'] ?? 25.2818);
            $dropLng     = floatval($booking['drop_longitude'] ?? 82.9984);
            $ambLat      = floatval($booking['amb_lat'] ?? ($pickupLat + 0.005));
            $ambLng      = floatval($booking['amb_lng'] ?? ($pickupLng + 0.003));
        ?>

        <!-- Trip Status Banner -->
        <div style="background: <?=$is_canc ? '#fef2f2' : ($is_done ? '#ecfdf5' : '#fff7ed');?>; border: 1.5px solid <?=$is_canc ? '#fecaca' : ($is_done ? '#a7f3d0' : '#fed7aa');?>; border-radius: 16px; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="background: <?=$is_canc ? '#dc2626' : ($is_done ? '#10b981' : '#ea580c');?>; color: #ffffff; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 999px; text-transform: uppercase;">
                    <i class="fas fa-circle" style="font-size: 8px;"></i> <?=$bStatus;?>
                </span>
                <div>
                    <strong style="color: #0f172a; font-size: 15px;">Booking Ref: #<?=htmlspecialchars($booking['booking_code']);?></strong>
                    <div style="font-size: 12px; color: #64748b;"><?=htmlspecialchars($booking['category_requested'] ?? 'ALS');?> Emergency Response Unit</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 16px;">
                <div>
                    <small style="color: #64748b; display: block; font-size: 11px; text-transform: uppercase; font-weight: 700;">Est. Arrival</small>
                    <strong style="color: #dc2626; font-size: 17px;"><?=max(4, intval($booking['estimated_duration_mins'] ?? 8));?> Mins</strong>
                </div>
                <div>
                    <small style="color: #64748b; display: block; font-size: 11px; text-transform: uppercase; font-weight: 700;">Total Fare</small>
                    <strong style="color: #0f172a; font-size: 17px;">₹<?=number_format(floatval($booking['total_fare'] ?? 1800), 2);?></strong>
                </div>
            </div>
        </div>

        <?php if($is_canc): ?>
        <!-- Prominent Cancellation Status & Reason Box -->
        <div style="background: #fff5f5; border: 1.5px solid #fecaca; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 16px; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.05);">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; border: 1px solid #fca5a5;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div style="flex-grow: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #991b1b;">
                        Ambulance Request Has Been Cancelled
                    </h4>
                    <span style="font-size: 12px; color: #b91c1c; font-weight: 600;">
                        Cancelled: <?=date('d M Y, h:i A', strtotime($booking['updated_at'] ?? 'now'));?>
                    </span>
                </div>
                <div style="margin-top: 8px; font-size: 14px; color: #7f1d1d;">
                    <strong>Cancellation Reason:</strong>
                    <span style="background: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #fecaca; font-weight: 700; color: #991b1b; display: inline-block; margin-left: 6px;">
                        <?=htmlspecialchars($booking['cancellation_reason'] ?: 'Cancelled upon patient request.');?>
                    </span>
                </div>
                <p style="margin: 8px 0 14px; font-size: 12.5px; color: #991b1b; line-height: 1.4;">
                    The emergency dispatch standing order and assigned ambulance have been released. If urgent medical assistance is still required, you can re-book an emergency unit below.
                </p>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="<?=base_url('ambulance/sos');?>" class="btn btn-sm" style="background: #dc2626; color: #ffffff; font-weight: 800; border-radius: 8px; padding: 8px 18px; text-decoration: none;">
                        <i class="fas fa-bolt"></i> Re-book Emergency Ambulance
                    </a>
                    <a href="<?=base_url('myappointments#ambulance');?>" class="btn btn-sm" style="background: #0f172a; color: #ffffff; font-weight: 700; border-radius: 8px; padding: 8px 16px; text-decoration: none;">
                        <i class="fas fa-list"></i> My Account Trips
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- 4-Step Trip Progress Stepper -->
        <div class="trip-stepper">
            <div class="step-node <?=!$is_canc ? 'completed' : '';?>">
                <div class="step-dot"><i class="fas fa-check"></i></div>
                <div class="step-title">Requested</div>
            </div>
            <div class="step-node <?=$is_assigned ? ($is_enroute ? 'completed' : 'active') : '';?>">
                <div class="step-dot"><?=($is_enroute ? '<i class="fas fa-check"></i>' : '2');?></div>
                <div class="step-title">Unit Assigned</div>
            </div>
            <div class="step-node <?=$is_enroute ? ($is_done ? 'completed' : 'active') : '';?>">
                <div class="step-dot"><?=($is_done ? '<i class="fas fa-check"></i>' : '3');?></div>
                <div class="step-title">En Route / Transit</div>
            </div>
            <div class="step-node <?=$is_done ? 'completed' : '';?>">
                <div class="step-dot"><?=($is_done ? '<i class="fas fa-check"></i>' : '4');?></div>
                <div class="step-title">Hospital Handover</div>
            </div>
        </div>

        <!-- Interactive GPS Map -->
        <div id="ambMap"></div>

        <!-- Paramedic & Security Handover Box -->
        <div class="driver-card-box">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div class="driver-avatar-circle">
                    <i class="fas fa-ambulance"></i>
                </div>
                <div>
                    <small style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #0d7a6e;">Assigned Ambulance &bull; <?=htmlspecialchars($booking['vehicle_number'] ?: 'UP 65 BT 1100');?></small>
                    <div style="font-size: 16px; font-weight: 800; color: #0f172a;">
                        <?=htmlspecialchars($booking['driver_name'] ?: 'Rajesh Yadav (ALS Paramedic)');?>
                    </div>
                    <?php if(!empty($booking['driver_phone'])): ?>
                        <a href="tel:<?=htmlspecialchars($booking['driver_phone']);?>" style="color: #2563eb; font-weight: 700; font-size: 13px; text-decoration: none;">
                            <i class="fas fa-phone-alt"></i> <?=htmlspecialchars($booking['driver_phone']);?> (Call Pilot)
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- OTP Badges -->
            <div style="display: flex; gap: 14px;">
                <div style="background: #ffffff; border: 1.5px dashed #10b981; border-radius: 12px; padding: 10px 18px; text-align: center;">
                    <small style="display: block; font-size: 10.5px; text-transform: uppercase; color: #059669; font-weight: 800;">Pickup OTP</small>
                    <strong style="font-size: 1.5rem; font-weight: 900; color: #059669; letter-spacing: 2px;">
                        <?=htmlspecialchars($booking['pickup_otp'] ?? '2534');?>
                    </strong>
                </div>
                <div style="background: #ffffff; border: 1.5px dashed #3b82f6; border-radius: 12px; padding: 10px 18px; text-align: center;">
                    <small style="display: block; font-size: 10.5px; text-transform: uppercase; color: #2563eb; font-weight: 800;">Hospital OTP</small>
                    <strong style="font-size: 1.5rem; font-weight: 900; color: #2563eb; letter-spacing: 2px;">
                        <?=htmlspecialchars($booking['hospital_handover_otp'] ?? '7990');?>
                    </strong>
                </div>
            </div>
        </div>

        <!-- Route Details -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px;">
            <div style="margin-bottom: 10px;">
                <span style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 800;">Emergency Pickup Location</span>
                <div style="font-size: 14px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                    <i class="fas fa-map-marker-alt" style="color: #10b981; margin-right: 6px;"></i>
                    <?=htmlspecialchars($booking['pickup_address']);?>
                </div>
            </div>
            <div>
                <span style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 800;">Destination Hospital Emergency Center</span>
                <div style="font-size: 14px; font-weight: 700; color: #0f172a; margin-top: 2px;">
                    <i class="fas fa-hospital" style="color: #3b82f6; margin-right: 6px;"></i>
                    <?=htmlspecialchars($booking['drop_address'] ?: 'Oriana Hospital Emergency Wing');?>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 30px;">
            <a href="<?=base_url('myappointments#ambulance');?>" class="btn" style="background: #f1f5f9; color: #475569; font-weight: 700; border-radius: 10px; padding: 10px 20px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> My Ambulance Trips
            </a>
            <div style="display: flex; gap: 10px; align-items: center;">
                <?php if(!$is_done && !$is_canc): ?>
                    <button type="button" onclick="openCancelModal('<?=htmlspecialchars($booking['booking_code']);?>')" class="btn" style="background: #fee2e2; border: 1px solid #fecaca; color: #b91c1c; font-weight: 700; border-radius: 10px; padding: 10px 18px; cursor: pointer;">
                        <i class="fas fa-times"></i> Cancel Trip
                    </button>
                <?php elseif($is_canc): ?>
                    <span style="background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; font-weight: 700; border-radius: 10px; padding: 8px 16px; display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px;">
                        <i class="fas fa-ban"></i> Cancelled
                    </span>
                    <a href="<?=base_url('ambulance/sos');?>" class="btn" style="background: #dc2626; color: #ffffff; font-weight: 800; border-radius: 10px; padding: 9px 18px; text-decoration: none;">
                        <i class="fas fa-bolt"></i> Re-book
                    </a>
                <?php endif; ?>
                <a href="tel:18002479999" class="btn" style="background: #0f172a; color: #ffffff; font-weight: 800; border-radius: 10px; padding: 10px 22px; text-decoration: none;">
                    <i class="fas fa-phone-alt"></i> Medical Dispatcher
                </a>
            </div>
        </div>

        <!-- CANCEL AMBULANCE TRIP MODAL WITH REASON OPTIONS -->
        <div id="cancelTripModal" style="display: none; position: fixed; inset: 0; z-index: 999999; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
            <div style="background: #ffffff; width: 100%; max-width: 540px; max-height: 90vh; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid #fee2e2; overflow: hidden; display: flex; flex-direction: column;">
                
                <!-- Modal Header -->
                <div style="background: #fff1f2; border-bottom: 1px solid #fecdd3; padding: 18px 24px; display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex-shrink: 0;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; border: 1px solid #fca5a5;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #991b1b;">Cancel Ambulance Request</h3>
                            <div style="font-size: 12.5px; color: #9f1239; margin-top: 2px;">
                                Booking Ref: <strong id="cancelModalRef" style="font-family: monospace;">#<?=htmlspecialchars($booking['booking_code'] ?? '');?></strong>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="closeCancelModal()" style="background: transparent; border: none; font-size: 24px; color: #9f1239; cursor: pointer; padding: 0; line-height: 1;">&times;</button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div style="padding: 22px 24px; overflow-y: auto; flex-grow: 1;">
                    
                    <!-- Emergency Callout Notice -->
                    <div style="background: #fff7ed; border-left: 4px solid #f97316; border-radius: 8px; padding: 10px 14px; margin-bottom: 18px;">
                        <div style="font-size: 12.5px; font-weight: 800; color: #9a3412;">
                            <i class="fas fa-ambulance"></i> Emergency Dispatch Notice:
                        </div>
                        <div style="font-size: 12px; color: #c2410c; margin-top: 2px; line-height: 1.4;">
                            Confirming will recall the assigned paramedic and vehicle unit. If this is a life-threatening critical emergency, please keep the unit en route or call <strong>1800-247-9999</strong> immediately.
                        </div>
                    </div>

                    <label style="display: block; font-size: 13px; font-weight: 800; color: #0f172a; margin-bottom: 10px;">
                        Select Reason for Cancellation <span style="color: #dc2626;">*</span>:
                    </label>

                    <!-- Reason Options (Interactive Radio Cards) -->
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                        
                        <label class="cancel-reason-option selected" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #dc2626; background: #fef2f2; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="cancel_reason_choice" value="Patient condition stabilized / Recovered" style="margin-top: 3px; accent-color: #dc2626;" checked onchange="handleReasonChange(this)">
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Patient condition stabilized / Recovered</div>
                                <div style="font-size: 11.5px; color: #64748b;">Acute symptoms subsided; urgent transport is no longer needed</div>
                            </div>
                        </label>

                        <label class="cancel-reason-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="cancel_reason_choice" value="Arranged alternate private vehicle / car" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleReasonChange(this)">
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Arranged alternate private vehicle / car</div>
                                <div style="font-size: 11.5px; color: #64748b;">Departing via family personal car, taxi, or local vehicle already on-site</div>
                            </div>
                        </label>

                        <label class="cancel-reason-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="cancel_reason_choice" value="Ambulance ETA is taking too long" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleReasonChange(this)">
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Ambulance ETA is taking too long</div>
                                <div style="font-size: 11.5px; color: #64748b;">Found faster emergency transfer option due to urgent timing</div>
                            </div>
                        </label>

                        <label class="cancel-reason-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="cancel_reason_choice" value="Decided to visit a different hospital / clinic nearby" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleReasonChange(this)">
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Decided to visit a different hospital / clinic nearby</div>
                                <div style="font-size: 11.5px; color: #64748b;">Changed destination hospital or admitted to nearest local clinic</div>
                            </div>
                        </label>

                        <label class="cancel-reason-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="cancel_reason_choice" value="Booked by mistake / duplicate request" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleReasonChange(this)">
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Booked by mistake / duplicate request</div>
                                <div style="font-size: 11.5px; color: #64748b;">Accidental tap or multiple family members dispatched an ambulance</div>
                            </div>
                        </label>

                        <label class="cancel-reason-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="cancel_reason_choice" value="Other" style="margin-top: 3px; accent-color: #dc2626;" onchange="handleReasonChange(this)">
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Other reason</div>
                                <div style="font-size: 11.5px; color: #64748b;">Specify exact reason or remarks below</div>
                            </div>
                        </label>

                    </div>

                    <!-- Additional Details Textarea -->
                    <div style="margin-bottom: 18px;">
                        <label for="cancelAdditionalNotes" style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">
                            Additional Details / Remarks (Optional):
                        </label>
                        <textarea id="cancelAdditionalNotes" rows="2" placeholder="Write any specific explanation or details for dispatch records..." style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 10px 12px; font-size: 13px; outline: none; font-family: inherit; resize: vertical; box-sizing: border-box;"></textarea>
                    </div>

                    <!-- Feedback Alert -->
                    <div id="cancelModalAlert" style="display: none; padding: 10px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 14px;"></div>
                </div>

                <!-- Modal Footer -->
                <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; justify-content: flex-end; align-items: center; gap: 12px; flex-shrink: 0;">
                    <button type="button" onclick="closeCancelModal()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #475569; font-weight: 700; padding: 9px 18px; border-radius: 10px; cursor: pointer; font-size: 13px;">
                        Don't Cancel (Keep En Route)
                    </button>
                    <button type="button" id="confirmCancelBtn" onclick="submitTripCancellation()" style="background: #dc2626; border: none; color: #ffffff; font-weight: 800; padding: 9px 20px; border-radius: 10px; cursor: pointer; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);">
                        <i class="fas fa-ban"></i> Confirm Cancellation
                    </button>
                </div>

            </div>
        </div>

        <style>
        .cancel-reason-option:hover {
            border-color: #fca5a5 !important;
            background: #fff8f8 !important;
        }
        .cancel-reason-option.selected {
            border-color: #dc2626 !important;
            background: #fef2f2 !important;
        }
        </style>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var pickup = [<?=$pickupLat;?>, <?=$pickupLng;?>];
            var drop   = [<?=$dropLat;?>, <?=$dropLng;?>];
            var amb    = [<?=$ambLat;?>, <?=$ambLng;?>];

            var map = L.map('ambMap').setView(amb, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Pickup Marker
            L.marker(pickup).addTo(map).bindPopup("<b>Patient Pickup:</b><br><?=addslashes(html_escape($booking['pickup_address']));?>").openPopup();

            // Ambulance Marker
            var ambIcon = L.divIcon({
                className: 'custom-amb-pin',
                html: '<div style="background:#dc2626; color:#ffffff; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 0 15px rgba(220,38,38,0.7); font-size:16px; border:2px solid #ffffff;"><i class="fas fa-ambulance"></i></div>',
                iconSize: [34, 34],
                iconAnchor: [17, 17]
            });
            var ambMarker = L.marker(amb, {icon: ambIcon}).addTo(map).bindPopup("<b>En Route Ambulance Unit:</b><br><?=addslashes(html_escape($booking['vehicle_number'] ?: 'Unit'));?>");

            // Hospital Marker
            var hospIcon = L.divIcon({
                className: 'custom-hosp-pin',
                html: '<div style="background:#2563eb; color:#ffffff; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 0 15px rgba(37,99,235,0.7); font-size:16px; border:2px solid #ffffff;"><i class="fas fa-hospital"></i></div>',
                iconSize: [34, 34],
                iconAnchor: [17, 17]
            });
            L.marker(drop, {icon: hospIcon}).addTo(map).bindPopup("<b>Destination Hospital:</b><br><?=addslashes(html_escape($booking['drop_address'] ?: 'Oriana Hospital'));?>");

            // Route Polyline
            var latlngs = [amb, pickup, drop];
            var polyline = L.polyline(latlngs, {color: '<?=$is_canc ? "#94a3b8" : "#dc2626";?>', weight: 4, dashArray: '6, 8'}).addTo(map);
            map.fitBounds(polyline.getBounds().pad(0.2));
            setTimeout(function() {
                map.invalidateSize();
            }, 250);

            <?php if(!$is_canc && !$is_done): ?>
            // Auto-refresh telemetry every 8 seconds
            var telemetryInterval = setInterval(function() {
                fetch('<?=base_url("ambulance/tracking_api");?>?ref=<?=urlencode($booking["booking_code"]);?>')
                .then(r => r.json())
                .then(d => {
                    if (d.status === 'success') {
                        if (d.trip_status === 'CANCELLED' || d.trip_status === 'COMPLETED') {
                            clearInterval(telemetryInterval);
                            location.reload();
                            return;
                        }
                        if (d.current_coords) {
                            ambMarker.setLatLng([d.current_coords.lat, d.current_coords.lng]);
                        }
                    }
                }).catch(()=>{});
            }, 8000);
            <?php endif; ?>
        });

        var currentCancelCode = '<?=htmlspecialchars($booking['booking_code'] ?? '');?>';

        function openCancelModal(code) {
            if (code) currentCancelCode = code;
            var refEl = document.getElementById('cancelModalRef');
            if (refEl) refEl.innerText = '#' + currentCancelCode;
            
            var al = document.getElementById('cancelModalAlert');
            if (al) al.style.display = 'none';

            var modal = document.getElementById('cancelTripModal');
            if (modal) modal.style.display = 'flex';
            highlightSelectedReason();
        }

        function closeCancelModal() {
            var modal = document.getElementById('cancelTripModal');
            if (modal) modal.style.display = 'none';
        }

        function handleReasonChange(el) {
            highlightSelectedReason();
            if (el.value === 'Other') {
                var notes = document.getElementById('cancelAdditionalNotes');
                if (notes) {
                    notes.focus();
                    notes.placeholder = "Please explain the reason for cancellation...";
                }
            }
        }

        function highlightSelectedReason() {
            document.querySelectorAll('.cancel-reason-option').forEach(function(opt) {
                var radio = opt.querySelector('input[type="radio"]');
                if (radio && radio.checked) {
                    opt.classList.add('selected');
                } else {
                    opt.classList.remove('selected');
                }
            });
        }

        function submitTripCancellation() {
            var selectedRadio = document.querySelector('input[name="cancel_reason_choice"]:checked');
            if (!selectedRadio) {
                showCancelAlert('Please select a cancellation reason option.', 'error');
                return;
            }

            var chosenReason = selectedRadio.value;
            var notes = (document.getElementById('cancelAdditionalNotes').value || '').trim();

            if (chosenReason === 'Other' && !notes) {
                showCancelAlert('Please provide additional details describing your cancellation reason.', 'error');
                document.getElementById('cancelAdditionalNotes').focus();
                return;
            }

            var fullReason = chosenReason;
            if (notes && chosenReason !== 'Other') {
                fullReason += " (" + notes + ")";
            } else if (chosenReason === 'Other') {
                fullReason = "Other: " + notes;
            }

            var btn = document.getElementById('confirmCancelBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cancelling...';

            var fd = new FormData();
            fd.append('booking_code', currentCancelCode);
            fd.append('reason', fullReason);
            fd.append('<?=$this->security->get_csrf_token_name();?>', '<?=$this->security->get_csrf_hash();?>');

            fetch('<?=base_url("ambulance/cancel_booking");?>', {
                method: 'POST',
                body: fd
            })
            .then(function(r) { return r.json(); })
            .then(function(d) {
                if (d.status === 'success') {
                    showCancelAlert(d.message || 'Ambulance trip cancelled successfully.', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 800);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-ban"></i> Confirm Cancellation';
                    showCancelAlert(d.message || 'Cancellation failed. Please try again.', 'error');
                }
            })
            .catch(function(err) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-ban"></i> Confirm Cancellation';
                showCancelAlert('Network error occurred while cancelling. Please retry.', 'error');
            });
        }

        function showCancelAlert(msg, type) {
            var al = document.getElementById('cancelModalAlert');
            if (!al) return;
            al.style.display = 'block';
            if (type === 'success') {
                al.style.background = '#ecfdf5';
                al.style.border = '1px solid #a7f3d0';
                al.style.color = '#065f46';
            } else {
                al.style.background = '#fef2f2';
                al.style.border = '1px solid #fecaca';
                al.style.color = '#991b1b';
            }
            al.innerText = msg;
        }

        // Close on backdrop click
        window.addEventListener('click', function(e) {
            var modal = document.getElementById('cancelTripModal');
            if (e.target === modal) {
                closeCancelModal();
            }
        });
        </script>
      <?php else: ?>
        <!-- No Trip Selected / Search Prompt -->
        <div style="text-align: center; padding: 40px 20px; background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 18px; margin-bottom: 24px;">
            <div style="font-size: 40px; color: #94a3b8; margin-bottom: 12px;">
                <i class="fas fa-search-location"></i>
            </div>
            <h4 style="font-weight: 800; font-size: 1.25rem; color: #0f172a; margin-bottom: 6px;">No Active Booking Loaded</h4>
            <p style="color: #64748b; font-size: 14px; max-width: 480px; margin: 0 auto 20px;">
                Please enter your Emergency Booking Reference (e.g. <code>UPAMB-2026-XXXXXX</code>) above to view live GPS tracking, or access your trips from the Patient Care Hub.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <a href="<?=base_url('ambulance/sos');?>" class="btn" style="background: #dc2626; color: #ffffff; font-weight: 800; border-radius: 10px; padding: 10px 22px; text-decoration: none;">
                    <i class="fas fa-bolt"></i> Book Ambulance Now
                </a>
                <a href="<?=base_url('myappointments#ambulance');?>" class="btn" style="background: #0f172a; color: #ffffff; font-weight: 700; border-radius: 10px; padding: 10px 20px; text-decoration: none;">
                    My Account Trips
                </a>
            </div>
        </div>
      <?php endif; ?>

      <!-- 24/7 Hotline Footer Card -->
      <div class="help-card" style="background: #fef2f2; border: 1px solid #fee2e2; border-radius: 18px; padding: 22px; text-align: center; margin-top: 24px;">
        <div style="font-size: 24px; color: #dc2626; margin-bottom: 6px;">
          <i class="fas fa-headset"></i>
        </div>
        <h4 style="font-weight: 800; color: #991b1b; margin-bottom: 4px;">Need Central Dispatcher Assistance?</h4>
        <p style="color: #7f1d1d; font-size: 13.5px; margin-bottom: 10px;">Our medical emergency dispatch team is standing by 24 hours a day, 7 days a week.</p>
        <a href="tel:18002479999" style="font-size: 1.6rem; font-weight: 900; color: #dc2626; text-decoration: none !important; display: inline-flex; align-items: center; gap: 8px;">
          <i class="fas fa-phone-alt"></i> 1800-247-9999 (Toll-Free)
        </a>
      </div>

    </div>
  </div>
</div>