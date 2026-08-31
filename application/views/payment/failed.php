<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed — UPCHAR Healthcare</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fff1f2 0%, #f8fafc 100%);
            margin: 0;
            padding: 40px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .failure-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(225, 29, 72, 0.15);
            max-width: 520px;
            width: 100%;
            padding: 40px 30px;
            text-align: center;
            border: 1px solid #ffe4e6;
        }

        .failure-icon-wrapper {
            width: 80px;
            height: 80px;
            background: #ffe4e6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 0 0 10px #fff1f2;
        }

        .failure-icon-wrapper i {
            font-size: 38px;
            color: #e11d48;
        }

        h1 {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 8px;
        }

        p.subtitle {
            color: #64748b;
            font-size: 15px;
            margin: 0 0 24px;
        }

        .error-alert-box {
            background: #fff1f2;
            border-left: 4px solid #e11d48;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 24px;
            text-align: left;
            color: #9f1239;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            flex-direction: column;
        }

        .btn-retry {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-retry:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(225, 29, 72, 0.25);
            color: #ffffff;
        }

        .btn-secondary {
            background: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
    </style>
</head>
<body>

<div class="failure-card">
    <div class="failure-icon-wrapper">
        <i class="fa-solid fa-xmark"></i>
    </div>

    <h1>Payment Incomplete</h1>
    <p class="subtitle">The transaction could not be processed. Any amount debited will be refunded automatically by your bank.</p>

    <div class="error-alert-box">
        <strong><i class="fa-solid fa-circle-exclamation"></i> Reason:</strong> 
        <?php echo htmlspecialchars($error_reason ?: 'Payment cancelled or declined by bank.'); ?>
    </div>

    <div class="btn-group">
        <a href="<?php echo base_url('payment/checkout?purpose=' . (isset($order['purpose']) ? $order['purpose'] : 'APPOINTMENT') . '&reference_id=' . (isset($order['reference_id']) ? $order['reference_id'] : '') . '&amount=' . (isset($order['amount']) ? $order['amount'] : '500')); ?>" class="btn-retry">
            <i class="fa-solid fa-rotate-right"></i> Try Again
        </a>
        <a href="<?php echo base_url(); ?>" class="btn-secondary">
            <i class="fa-solid fa-house"></i> Return to Homepage
        </a>
    </div>
</div>

</body>
</html>
