<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| ABDM Configuration
| -------------------------------------------------------------------------
| This file contains configuration for the ABDM (Ayushman Bharat Digital Mission)
| integration module.
*/

$config['abdm'] = [

    // Environment: sandbox, staging, production
    'environment' => 'sandbox',

    // API Endpoints (would vary by environment)
    'api_endpoints' => [
        'sandbox' => [
            'base_url' => 'https://sandbox.abdm.gov.in/gateway',
            'abha' => '/abha/api/v1',
            'consent' => '/consent/api/v1',
            'hpr' => '/hpr/api/v1',
            'hfr' => '/hfr/api/v1',
            'hie' => '/hie/api/v1'
        ],
        'production' => [
            'base_url' => 'https://abdm.gov.in/gateway',
            // ... similar structure
        ]
    ],

    // Credentials (should be in environment variables or vault)
    'api_key' => '', // Set via environment variable
    'api_secret' => '', // Set via environment variable

    // Timeout settings
    'timeout' => 30,
    'ssl_verify' => true,

    // UPCHAR specific settings
    'upchar_hpr_id_prefix' => 'UPCHAR-DR',
    'upchar_hfr_id_prefix' => 'UPCHAR-FAC',

    // Consent defaults
    'default_consent_duration_days' => 365,
    'max_consent_duration_days' => 730, // 2 years max

    // Feature flags
    'enable_abha_creation' => true,
    'enable_consent_management' => true,
    'enable_hpr_registration' => true,
    'enable_hfr_registration' => true,
    'enable_hie_integration' => false // Phase 4 feature
];