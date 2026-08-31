<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Razorpay & RazorpayX Payment Configuration
|--------------------------------------------------------------------------
| UPCHAR Healthcare SaaS Unified Payment Integration
*/

// Set mode: 'test' for sandbox development, 'live' for production
$config['razorpay_mode']            = 'test';

// Razorpay Standard Payment Gateway Keys (Customer Collections)
$config['razorpay_key_id']          = 'rzp_test_5n4h9wU539eZ1m'; // Default sandbox key (replace with live credentials in production)
$config['razorpay_key_secret']      = '9M5s3R9tT4yU1vW8xZ0qAaBb';

// Razorpay Webhook Secret (configured in Razorpay Dashboard -> Webhooks)
$config['razorpay_webhook_secret']  = 'upchar_secure_webhook_secret_2026';

// RazorpayX Payouts API Credentials (for Doctor, Hospital & Lab automated disbursements)
$config['razorpayx_key_id']         = 'rzp_test_x_payout_key_upchar';
$config['razorpayx_key_secret']     = 'x_secret_upchar_payout_2026';
$config['razorpayx_account_number'] = '2323230045678901'; // Virtual account number

// Business Merchant Details for Checkout branding
$config['merchant_name']            = 'UPCHAR Health';
$config['merchant_description']     = 'Healthcare & Diagnostics Services';
$config['merchant_theme_color']     = '#0d7a6e';
$config['merchant_logo_url']        = 'images/logo.png';

// Currency & Locale
$config['currency']                 = 'INR';
$config['country_code']             = 'IN';
