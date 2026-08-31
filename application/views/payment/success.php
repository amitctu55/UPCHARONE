<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful — UPCHAR Healthcare</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0fdfa 0%, #f8fafc 100%);
            margin: 0;
            padding: 40px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .success-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(13, 122, 110, 0.15);
            max-width: 520px;
            width: 100%;
            padding: 40px 30px;
            text-align: center;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .success-icon-wrapper {
            width: 80px;
            height: 80px;
            background: #dcfce7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 0 0 10px #f0fdf4;
            animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .success-icon-wrapper i {
            font-size: 38px;
            color: #16a34a;
        }

        @keyframes popIn {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
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

        .details-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
            text-align: left;
            border: 1px solid #e2e8f0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
            border-top: 1px dashed #cbd5e1;
            padding-top: 10px;
            font-weight: 700;
            font-size: 16px;
            color: #0d7a6e;
        }

        .detail-label {
            color: #64748b;
        }

        .detail-value {
            font-weight: 600;
            color: #1e293b;
        }

        .points-earned-banner {
            background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
            border: 1px solid #fcd34d;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 24px;
            color: #92400e;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            flex-direction: column;
        }

        .btn-primary-action {
            background: linear-gradient(135deg, #1ab5a0 0%, #0d7a6e 100%);
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

        .btn-primary-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 122, 110, 0.25);
            color: #ffffff;
        }

        .btn-secondary-action {
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
            transition: all 0.2s ease;
        }

        .btn-secondary-action:hover {
            background: #f1f5f9;
            color: #1e293b;
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-icon-wrapper">
        <i class="fa-solid fa-check"></i>
    </div>

    <h1>Payment Confirmed!</h1>
    <p class="subtitle">Thank you. Your transaction has been securely processed.</p>

    <div class="details-box">
        <div class="detail-row">
            <span class="detail-label">Order Ref:</span>
            <span class="detail-value"><?php echo htmlspecialchars($order['internal_order_ref']); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Service Type:</span>
            <span class="detail-value"><?php echo htmlspecialchars($order['purpose']); ?></span>
        </div>
        <?php if (!empty($order['razorpay_payment_id'])): ?>
        <div class="detail-row">
            <span class="detail-label">Gateway Txn ID:</span>
            <span class="detail-value"><?php echo htmlspecialchars($order['razorpay_payment_id']); ?></span>
        </div>
        <?php endif; ?>
        <?php if ($order['wallet_points_used'] > 0): ?>
        <div class="detail-row">
            <span class="detail-label">Points Redeemed:</span>
            <span class="detail-value"><?php echo number_format($order['wallet_points_used'], 0); ?> Pts</span>
        </div>
        <?php endif; ?>
        <div class="detail-row">
            <span class="detail-label">Total Amount Paid:</span>
            <span class="detail-value">₹<?php echo number_format($order['amount'], 2); ?></span>
        </div>
    </div>

    <?php if ($cashback_pts > 0): ?>
    <div class="points-earned-banner">
        <i class="fa-solid fa-coins fa-bounce" style="color: #d97706;"></i>
        <span>You earned <strong>+<?php echo $cashback_pts; ?> Upchar Points</strong> as cashback!</span>
    </div>
    <?php endif; ?>

    <div class="btn-group">
        <?php if ($order['purpose'] === 'APPOINTMENT'): ?>
            <a href="<?php echo base_url('myappointments'); ?>" class="btn-primary-action">
                <i class="fa-solid fa-calendar-check"></i> View My Appointments
            </a>
        <?php elseif ($order['purpose'] === 'WALLET_RECHARGE'): ?>
            <a href="<?php echo base_url('wallet'); ?>" class="btn-primary-action">
                <i class="fa-solid fa-wallet"></i> View Wallet Dashboard
            </a>
        <?php else: ?>
            <a href="<?php echo base_url('mytest'); ?>" class="btn-primary-action">
                <i class="fa-solid fa-flask"></i> View Pathology Orders
            </a>
        <?php endif; ?>

        <a href="<?php echo base_url(); ?>" class="btn-secondary-action">
            <i class="fa-solid fa-house"></i> Return to Home
        </a>
    </div>
</div>

</body>
</html>
