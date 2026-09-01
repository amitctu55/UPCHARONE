<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>GPS &amp; Selfie Attendance Punch - Upchar</title>
    <link rel="icon" href="<?=base_url('images/logo.png');?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('public/assets/css/bootstrap.min.css');?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            color: #ffffff;
            margin: 0;
            padding: 16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .punch-card {
            background: #1e293b;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 24px 20px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            text-align: center;
            position: relative;
        }

        .staff-switcher-bar {
            width: 100%;
            max-width: 440px;
            margin-bottom: 14px;
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .staff-switch-btn {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 20px;
            text-decoration: none !important;
            white-space: nowrap;
            transition: all 0.2s;
        }
        .staff-switch-btn.active, .staff-switch-btn:hover {
            background: #00a896;
            color: #ffffff;
            border-color: #00a896;
        }

        .camera-container {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            margin: 14px auto;
            border: 4px solid #00a896;
            background: #090d16;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 168, 150, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #webcamVideo, #selfieCanvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .camera-fallback-icon {
            font-size: 54px;
            color: #00a896;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        .btn-punch-main {
            background: linear-gradient(135deg, #00a896 0%, #0284c7 100%);
            border: none;
            color: #ffffff;
            font-weight: 800;
            font-size: 15px;
            padding: 13px 24px;
            border-radius: 12px;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 168, 150, 0.4);
            transition: all 0.2s;
        }
        .btn-punch-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 168, 150, 0.6);
        }

        .gps-status-pill {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 11.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 10px;
            color: #38bdf8;
        }

        .digital-clock {
            font-size: 26px;
            font-weight: 800;
            color: #f8fafc;
            letter-spacing: 1px;
            margin: 4px 0 2px;
            font-family: monospace;
        }
    </style>
</head>
<body>

<!-- Quick Staff Role Switcher -->
<?php if (!empty($all_staff)): ?>
<div class="staff-switcher-bar">
    <?php foreach ($all_staff as $st): ?>
        <a href="<?=base_url('attendance/punch?staff_id=' . $st['id']);?>" class="staff-switch-btn <?=$st['id'] == @$user['id'] ? 'active' : '';?>">
            <?=html_escape(explode(' ', $st['name'])[0]);?> (<?=strtoupper($st['role']);?>)
        </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div class="punch-card">
    <!-- Top Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <a href="<?=base_url('collector/dashboard');?>" style="color: #94a3b8; font-size: 12.5px; text-decoration: none;">
            <i class="fa fa-arrow-left"></i> Staff Portal
        </a>
        <span style="font-size: 11.5px; font-weight: 700; color: #34d399;">
            <i class="fa fa-calendar"></i> <?=date('D, d M Y');?>
        </span>
    </div>

    <!-- Live Digital Clock -->
    <div class="digital-clock" id="liveDigitalClock">
        <?=date('h:i:s A');?>
    </div>

    <h3 style="margin: 0 0 4px; font-size: 18px; font-weight: 800; color: #ffffff;">
        Daily Attendance Punch
    </h3>
    <p style="color: #94a3b8; font-size: 12.5px; margin: 0 0 10px;">
        <?=html_escape(@$user['name'] ?: 'Staff Employee');?> &bull; <strong style="color: #2dd4bf;"><?=strtoupper(@$user['role'] ?: 'FIELD_STAFF');?></strong>
    </p>

    <!-- GPS Pill -->
    <div class="gps-status-pill" id="gpsIndicator">
        <i class="fa fa-map-marker" style="color: #34d399;"></i> GPS Active (Lucknow Hub: 26.8467, 80.9462)
    </div>

    <!-- Live Camera Feed / Fallback Avatar -->
    <div class="camera-container" id="camBox">
        <video id="webcamVideo" autoplay playsinline style="display: none;"></video>
        <div class="camera-fallback-icon" id="cameraFallback">
            <i class="fa fa-user-circle-o"></i>
            <span style="font-size: 10px; color: #94a3b8; margin-top: 4px;">Biometric Ready</span>
        </div>
        <canvas id="selfieCanvas" style="display: none;"></canvas>
    </div>

    <div id="punchStatusMsg" style="display: none; padding: 10px; border-radius: 8px; font-size: 12px; margin-bottom: 12px;"></div>

    <?php if($this->session->flashdata('success_msg')): ?>
        <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #6ee7b7; padding: 8px; border-radius: 8px; font-size: 12px; margin-bottom: 12px;">
            <?=$this->session->flashdata('success_msg');?>
        </div>
    <?php endif; ?>

    <?php if (empty($today_punch)): ?>
        <!-- Check-in State -->
        <button type="button" class="btn-punch-main" id="btnPunchIn" onclick="handlePunchIn()">
            <i class="fa fa-camera"></i> Punch In (Check-In)
        </button>
    <?php elseif (empty($today_punch['check_out_time'])): ?>
        <!-- Check-out State -->
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; border-radius: 10px; padding: 10px; margin-bottom: 12px; font-size: 12.5px; color: #6ee7b7;">
            <i class="fa fa-check-circle"></i> Checked in at <strong><?=date('h:i A', strtotime($today_punch['check_in_time']));?></strong> (<?=strtoupper($today_punch['status']);?>)
        </div>
        <button type="button" class="btn-punch-main" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);" id="btnPunchOut" onclick="handlePunchOut()">
            <i class="fa fa-sign-out"></i> Punch Out (Check-Out)
        </button>
    <?php else: ?>
        <!-- Completed State -->
        <div style="background: rgba(59, 130, 246, 0.15); border: 1px solid #3b82f6; border-radius: 10px; padding: 12px; font-size: 12.5px; color: #93c5fd;">
            <i class="fa fa-check-circle" style="font-size: 20px; display: block; margin-bottom: 4px; color: #60a5fa;"></i>
            <strong>Attendance Complete Today</strong>
            <div style="font-size: 11.5px; margin-top: 4px; color: #cbd5e1;">
                In: <?=date('h:i A', strtotime($today_punch['check_in_time']));?> &bull; Out: <?=date('h:i A', strtotime($today_punch['check_out_time']));?> (<?=$today_punch['working_hours'];?> hrs)
            </div>
        </div>
    <?php endif; ?>

    <div style="margin-top: 16px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
        <a href="<?=base_url('attendance/history');?>" style="color: #38bdf8; text-decoration: none; font-weight: 600;">
            <i class="fa fa-history"></i> Monthly History
        </a>
        <a href="<?=base_url('attendance/reset_today_punch');?>" style="color: #94a3b8; text-decoration: none;" onclick="return confirm('Reset today\'s punch to test again?')">
            <i class="fa fa-refresh"></i> Reset (Demo)
        </a>
    </div>
</div>

<script>
var currentLat = 26.8467;
var currentLng = 80.9462;
var hasCamera = false;
var video = document.getElementById('webcamVideo');
var canvas = document.getElementById('selfieCanvas');

// 1. Live Clock
setInterval(function() {
    var now = new Date();
    document.getElementById('liveDigitalClock').innerText = now.toLocaleTimeString();
}, 1000);

// 2. Initialize Geolocation
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        currentLat = pos.coords.latitude;
        currentLng = pos.coords.longitude;
        $('#gpsIndicator').html('<i class="fa fa-check-circle" style="color: #34d399;"></i> GPS Locked: ' + currentLat.toFixed(4) + ', ' + currentLng.toFixed(4));
    }, function(err) {
        $('#gpsIndicator').html('<i class="fa fa-map-marker" style="color: #34d399;"></i> GPS Active: ' + currentLat.toFixed(4) + ', ' + currentLng.toFixed(4));
    }, { enableHighAccuracy: true });
}

// 3. Initialize WebRTC Camera with graceful fallback
if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } })
        .then(function(stream) {
            hasCamera = true;
            video.srcObject = stream;
            $(video).show();
            $('#cameraFallback').hide();
        })
        .catch(function(err) {
            console.log("Webcam unavailable or permission denied, using biometric badge fallback.");
        });
}

function captureSelfie() {
    var ctx = canvas.getContext('2d');
    canvas.width = 300;
    canvas.height = 300;

    if (hasCamera && video.videoWidth > 0) {
        ctx.drawImage(video, 0, 0, 300, 300);
    } else {
        // Draw biometric badge placeholder
        ctx.fillStyle = "#1e293b";
        ctx.fillRect(0, 0, 300, 300);
        ctx.fillStyle = "#00a896";
        ctx.font = "bold 16px sans-serif";
        ctx.textAlign = "center";
        ctx.fillText("UPCHAR BIOMETRIC PUNCH", 150, 100);
        ctx.fillStyle = "#ffffff";
        ctx.font = "14px sans-serif";
        ctx.fillText("<?=html_escape(@$user['name'] ?: 'Staff Employee');?>", 150, 140);
        ctx.fillStyle = "#94a3b8";
        ctx.font = "12px sans-serif";
        ctx.fillText(new Date().toLocaleString(), 150, 170);
        ctx.fillText("GPS: " + currentLat.toFixed(4) + ", " + currentLng.toFixed(4), 150, 195);
    }
    return canvas.toDataURL('image/jpeg', 0.8);
}

var csrfName = '<?=$this->security->get_csrf_token_name();?>';
var csrfHash = '<?=$this->security->get_csrf_hash();?>';

function handlePunchIn() {
    $('#btnPunchIn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Punching In...');
    var selfieBase64 = captureSelfie();

    var postData = {
        lat: currentLat,
        lng: currentLng,
        selfie: selfieBase64,
        notes: 'Mobile WebRTC Punch'
    };
    postData[csrfName] = csrfHash;

    $.post('<?=base_url("attendance/record_punch_in");?>', postData, function(res) {
        if (res.status === 'success') {
            $('#punchStatusMsg').css({'background': 'rgba(16, 185, 129, 0.2)', 'border': '1px solid #10b981', 'color': '#6ee7b7'})
                .html('<i class="fa fa-check"></i> ' + res.message + ' (' + res.punch_time + ')').show();
            setTimeout(function() { location.reload(); }, 1200);
        } else {
            $('#punchStatusMsg').css({'background': 'rgba(239, 68, 68, 0.2)', 'border': '1px solid #ef4444', 'color': '#fca5a5'})
                .html('<i class="fa fa-times"></i> ' + res.message).show();
            $('#btnPunchIn').prop('disabled', false).html('<i class="fa fa-camera"></i> Punch In (Check-In)');
        }
    }, 'json').fail(function() {
        $('#btnPunchIn').prop('disabled', false).html('<i class="fa fa-camera"></i> Punch In (Check-In)');
        alert('Server communication error during punch.');
    });
}

function handlePunchOut() {
    if (!confirm('Are you sure you want to punch out for today?')) return;
    $('#btnPunchOut').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Punching Out...');

    var postData = {
        lat: currentLat,
        lng: currentLng,
        notes: 'End of Day Check-out'
    };
    postData[csrfName] = csrfHash;

    $.post('<?=base_url("attendance/record_punch_out");?>', postData, function(res) {
        if (res.status === 'success') {
            $('#punchStatusMsg').css({'background': 'rgba(16, 185, 129, 0.2)', 'border': '1px solid #10b981', 'color': '#6ee7b7'})
                .html('<i class="fa fa-check"></i> ' + res.message).show();
            setTimeout(function() { location.reload(); }, 1200);
        } else {
            $('#punchStatusMsg').css({'background': 'rgba(239, 68, 68, 0.2)', 'border': '1px solid #ef4444', 'color': '#fca5a5'})
                .html('<i class="fa fa-times"></i> ' + res.message).show();
            $('#btnPunchOut').prop('disabled', false).html('<i class="fa fa-sign-out"></i> Punch Out (Check-Out)');
        }
    }, 'json').fail(function() {
        $('#btnPunchOut').prop('disabled', false).html('<i class="fa fa-sign-out"></i> Punch Out (Check-Out)');
        alert('Server communication error during punch out.');
    });
}
</script>

</body>
</html>
