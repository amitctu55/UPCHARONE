<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?=base_url();?>images/logo.png" type="image/png" sizes="32x32">
    <title>Upchar Teleconsultation - Encrypted HD Video Consultation</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; }
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f172a;
            color: #ffffff;
        }

        #video-container {
            width: 100vw;
            height: calc(100vh - 60px);
            margin-top: 60px;
            background: #0b0f19;
        }

        .tele-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(135deg, #043d5b 0%, #008f80 70%, #00a896 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
        }

        .tele-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tele-logo {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #ffffff;
            margin: 0;
        }

        .tele-pill {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tele-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-tele-exit {
            background: #ef4444;
            color: #ffffff;
            border: none;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-tele-exit:hover {
            background: #dc2626;
            color: #ffffff;
            text-decoration: none;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 8px #10b981;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        @media (max-width: 600px) {
            .tele-header { padding: 0 10px; }
            .tele-pill { font-size: 11px; padding: 3px 8px; }
            .tele-logo { font-size: 16px; }
        }
    </style>

    <!-- Jitsi Meet External WebRTC API -->
    <script src="https://meet.jit.si/external_api.js"></script>
</head>
<body>

    <header class="tele-header">
        <div class="tele-brand">
            <h1 class="tele-logo">UPCHAR</h1>
            <div class="tele-pill">
                <span class="live-dot"></span>
                <i class="fa fa-lock"></i> 256-Bit Encrypted Teleconsultation
            </div>
        </div>

        <div class="tele-actions">
            <?php 
            $backUrl = base_url('myappointments');
            if ($this->session->userdata('druserid')) {
                $backUrl = base_url('doctor-dashboard');
            }
            ?>
            <a href="<?=$backUrl;?>" class="btn-tele-exit">
                <i class="fa fa-phone-square"></i> Leave Consultation
            </a>
        </div>
    </header>

    <div id="video-container"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const domain = "meet.jit.si";
            const roomName = "<?=htmlspecialchars($room);?>";
            const userDisplayName = "<?=htmlspecialchars($display_name ?? 'Upchar Patient/Doctor');?>";

            const options = {
                roomName: roomName,
                width: "100%",
                height: "100%",
                parentNode: document.querySelector('#video-container'),
                userInfo: {
                    displayName: userDisplayName
                },
                configOverwrite: {
                    startWithAudioMuted: false,
                    startWithVideoMuted: false,
                    prejoinPageEnabled: false,
                    disableDeepLinking: true
                },
                interfaceConfigOverwrite: {
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_WATERMARK_FOR_GUESTS: false,
                    SHOW_BRAND_WATERMARK: false,
                    DEFAULT_REMOTE_DISPLAY_NAME: "Consultant / Patient",
                    TOOLBAR_BUTTONS: [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'hangup', 'chat', 'raisehand',
                        'videoquality', 'tileview', 'mute-everyone', 'security'
                    ]
                }
            };

            const api = new JitsiMeetExternalAPI(domain, options);

            // Redirect user when call ends
            api.addEventListener('videoConferenceLeft', function() {
                window.location.href = "<?=$backUrl;?>";
            });
        });
    </script>

</body>
</html>
