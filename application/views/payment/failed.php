<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .payment-failed-wrapper {
        background: #fff1f2;
        padding: 50px 15px 80px;
        min-height: 75vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .failure-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(225, 29, 72, 0.08);
        max-width: 520px;
        width: 100%;
        padding: 40px 30px;
        text-align: center;
        border: 1px solid #ffe4e6;
        margin: 0 auto;
    }

    .failure-icon-wrapper {
        width: 76px;
        height: 76px;
        background: #ffe4e6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        box-shadow: 0 0 0 8px #fff1f2;
    }

    .failure-icon-wrapper i {
        font-size: 36px;
        color: #e11d48;
    }

    .failure-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
    }

    .failure-sub {
        color: #64748b;
        font-size: 14px;
        margin: 0 0 20px;
    }

    .error-alert-box {
        background: #fff1f2;
        border-left: 4px solid #e11d48;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 24px;
        text-align: left;
        color: #9f1239;
        font-size: 13.5px;
        font-weight: 600;
    }

    .btn-failed-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-retry-action {
        background: #e11d48;
        color: #ffffff !important;
        text-decoration: none !important;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14.5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
    }

    .btn-retry-action:hover {
        background: #be123c;
        transform: translateY(-1px);
    }

    .btn-secondary-failed {
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

    .btn-secondary-failed:hover {
        background: #e2e8f0;
    }
</style>

<div class="payment-failed-wrapper">
    <div class="failure-card">
        <div class="failure-icon-wrapper">
            <i class="fa fa-times"></i>
        </div>

        <h1 class="failure-title">Payment Incomplete</h1>
        <p class="failure-sub">The transaction could not be processed. Any debited amount will be auto-refunded by your bank within standard banking timelines.</p>

        <div class="error-alert-box">
            <strong><i class="fa fa-exclamation-circle"></i> Reason:</strong> 
            <?=htmlspecialchars($error_reason ?: 'Payment cancelled or declined by bank.');?>
        </div>

        <div class="btn-failed-group">
            <a href="<?=base_url('payment/checkout?purpose=' . (isset($order['purpose']) ? $order['purpose'] : 'WALLET_RECHARGE') . '&reference_id=' . (isset($order['reference_id']) ? $order['reference_id'] : '') . '&amount=' . (isset($order['amount']) ? $order['amount'] : '100'));?>" class="btn-retry-action">
                <i class="fa fa-refresh"></i> Retry Payment
            </a>
            <a href="<?=base_url();?>" class="btn-secondary-failed">
                <i class="fa fa-home"></i> Return to Homepage
            </a>
        </div>
    </div>
</div>
