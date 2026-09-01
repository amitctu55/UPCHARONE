<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .payment-status-wrapper {
        background: #f8fafc;
        padding: 50px 15px 80px;
        min-height: 75vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .success-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        max-width: 520px;
        width: 100%;
        padding: 40px 30px;
        text-align: center;
        border: 1px solid #e2e8f0;
        margin: 0 auto;
    }

    .success-icon-wrapper {
        width: 76px;
        height: 76px;
        background: #dcfce7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        box-shadow: 0 0 0 8px #f0fdf4;
    }

    .success-icon-wrapper i {
        font-size: 36px;
        color: #16a34a;
    }

    .success-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
    }

    .success-sub {
        color: #64748b;
        font-size: 14px;
        margin: 0 0 24px;
    }

    .order-details-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        text-align: left;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 13.5px;
    }

    .detail-row:last-child {
        margin-bottom: 0;
        padding-top: 10px;
        border-top: 1px dashed #cbd5e1;
        font-weight: 700;
    }

    .detail-label {
        color: #64748b;
    }

    .detail-value {
        color: #0f172a;
        font-weight: 600;
    }

    .points-earned-banner {
        background: #fef3c7;
        border: 1px dashed #f59e0b;
        color: #92400e;
        border-radius: 10px;
        padding: 12px;
        font-size: 13px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .btn-group-stacked {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-primary-action {
        background: #00a896;
        color: #ffffff !important;
        text-decoration: none !important;
        border-radius: 10px;
        padding: 12px 20px;
        font-size: 14.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(0, 168, 150, 0.25);
    }

    .btn-primary-action:hover {
        background: #008f80;
        transform: translateY(-1px);
    }

    .btn-secondary-action {
        background: #f1f5f9;
        color: #334155 !important;
        text-decoration: none !important;
        border-radius: 10px;
        padding: 11px 20px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-secondary-action:hover {
        background: #e2e8f0;
    }
</style>

<div class="payment-status-wrapper">
    <div class="success-card">
        <div class="success-icon-wrapper">
            <i class="fa fa-check"></i>
        </div>

        <h1 class="success-title">Payment Completed!</h1>
        <p class="success-sub">Thank you. Your transaction was confirmed and processed successfully.</p>

        <div class="order-details-box">
            <div class="detail-row">
                <span class="detail-label">Order Reference:</span>
                <span class="detail-value"><?=htmlspecialchars($order['internal_order_ref']);?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Purpose:</span>
                <span class="detail-value"><?=htmlspecialchars($order['purpose']);?></span>
            </div>
            <?php if (!empty($order['razorpay_payment_id'])): ?>
            <div class="detail-row">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value"><?=htmlspecialchars($order['razorpay_payment_id']);?></span>
            </div>
            <?php endif; ?>
            <?php if ($order['wallet_points_used'] > 0): ?>
            <div class="detail-row">
                <span class="detail-label">Points Redeemed:</span>
                <span class="detail-value"><?=number_format($order['wallet_points_used'], 0);?> Pts</span>
            </div>
            <?php endif; ?>
            <div class="detail-row">
                <span class="detail-label">Total Amount:</span>
                <span class="detail-value" style="color: #00a896; font-size: 16px;">₹<?=number_format($order['amount'], 2);?></span>
            </div>
        </div>

        <?php if ($order['purpose'] === 'WALLET_RECHARGE'): ?>
            <div class="points-earned-banner">
                <i class="fa fa-star"></i>
                <span>Your wallet has been credited with <strong>+<?=number_format($order['amount'], 2);?> Upchar Points</strong>!</span>
            </div>
        <?php elseif ($cashback_pts > 0): ?>
            <div class="points-earned-banner">
                <i class="fa fa-gift"></i>
                <span>You earned <strong>+<?=$cashback_pts;?> Upchar Cashback Points</strong>!</span>
            </div>
        <?php endif; ?>

        <div class="btn-group-stacked">
            <?php if ($order['purpose'] === 'APPOINTMENT'): ?>
                <a href="<?=base_url('myappointments');?>" class="btn-primary-action">
                    <i class="fa fa-calendar"></i> View My Appointments
                </a>
            <?php elseif ($order['purpose'] === 'WALLET_RECHARGE'): ?>
                <a href="<?=base_url('wallet');?>" class="btn-primary-action">
                    <i class="fa fa-google-wallet"></i> View Wallet Dashboard
                </a>
            <?php else: ?>
                <a href="<?=base_url('mytest');?>" class="btn-primary-action">
                    <i class="fa fa-flask"></i> View Pathology Orders
                </a>
            <?php endif; ?>

            <a href="<?=base_url();?>" class="btn-secondary-action">
                <i class="fa fa-home"></i> Return to Homepage
            </a>
        </div>
    </div>
</div>
