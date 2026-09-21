<?php
/**
 * CCAvenue Legacy Request Handler Bridge to Razorpay
 * UPCHAR Healthcare Platform
 * 
 * Automatically intercepts legacy CCAvenue requests and redirects to
 * the active, secure Razorpay Payment Gateway configured in System Settings.
 */

// Determine Base URL dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$script_dir = dirname($_SERVER['SCRIPT_NAME']);
$base_url = rtrim($protocol . $host . $script_dir, '/\\') . '/../';
$base_url = preg_replace('/payment\/..\/$/', '', $base_url);
if (substr($base_url, -1) !== '/') {
    $base_url .= '/';
}

// Check incoming order parameters
$order_id = isset($_POST['order_id']) ? htmlspecialchars(strip_tags($_POST['order_id'])) : (isset($_GET['order_id']) ? htmlspecialchars(strip_tags($_GET['order_id'])) : '');
$amount   = isset($_POST['amount']) ? floatval($_POST['amount']) : (isset($_GET['amount']) ? floatval($_GET['amount']) : 0);

// Target modern checkout destination
$redirect_url = $base_url . 'paysecure/acheckout';
if (!empty($order_id)) {
    // If order_id has appointment format (e.g. UPCH-APPT-630)
    if (preg_match('/(?:APPT-)?(\d+)/i', $order_id, $matches)) {
        $redirect_url = $base_url . 'paysecure/acheckout?aid=' . urlencode($matches[1]);
    }
}

// Perform instant HTTP redirect if headers not sent
if (!headers_sent()) {
    header("Location: " . $redirect_url, true, 302);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecting to Secure Razorpay Gateway | UPCHAR</title>
    <meta http-equiv="refresh" content="1;url=<?=htmlspecialchars($redirect_url);?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #0f172a;
        }
        .gateway-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(13, 122, 110, 0.15), 0 0 0 1px rgba(13, 122, 110, 0.1);
            max-width: 480px;
            width: 100%;
            padding: 40px 32px;
            text-align: center;
            position: relative;
        }
        .spinner-box {
            width: 68px;
            height: 68px;
            margin: 0 auto 24px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .spinner-ring {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid #ccfbf1;
            border-top-color: #0d7a6e;
            animation: spin 0.9s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
        }
        .spinner-icon {
            position: absolute;
            width: 28px;
            height: 28px;
            color: #0d7a6e;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        h2 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
        }
        p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 24px;
        }
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 24px;
        }
        .btn-direct {
            display: inline-block;
            background: #0d7a6e;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(13, 122, 110, 0.3);
            transition: all 0.2s ease;
        }
        .btn-direct:hover {
            background: #0b685e;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="gateway-card">
        <div class="spinner-box">
            <div class="spinner-ring"></div>
            <svg class="spinner-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
        </div>
        <h2>Upgraded to Razorpay Secure Gateway</h2>
        <p>Connecting your session to the official UPCHAR Razorpay Payment Gateway configured in system settings...</p>
        <div class="badge-pill">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            100% Encrypted &bull; RBI &amp; PCI-DSS Compliant
        </div>
        <div>
            <a href="<?=htmlspecialchars($redirect_url);?>" class="btn-direct">Proceed to Razorpay Checkout &rarr;</a>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "<?=addslashes($redirect_url);?>";
        }, 300);
    </script>
</body>
</html>
