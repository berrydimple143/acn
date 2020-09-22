<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => 'live', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'username'    => env('PAYPAL_SANDBOX_API_USERNAME', 'merchant_api1.australianregionalnetwork.com'),
        'password'    => env('PAYPAL_SANDBOX_API_PASSWORD', '7EJLDUBNDJJYMGEH'),
        'secret'      => env('PAYPAL_SANDBOX_API_SECRET', 'EEby4ZJtIFJv7Gqhf1dr2LM6hubZXQBZ5GTYOsTd-5XhJ3rhrNjE3AA3sqz0WD6DhWrIDcpn-ZNU-73K'),
        'certificate' => env('PAYPAL_SANDBOX_API_CERTIFICATE', 'A3ejB8ILKLcnXEmI9gnSbvIApl3WAGSN567.ANE72Z33PVBLyy58MACN'),
        'app_id'      => 'AQmNvIunVvHfd6w4m0FwFh-MG18pAsXicPfZM96HfvI3TUgYzwJtNEwBY1F9jR4QqL0_nLUnVHFF66Mu',
    ],
    'live' => [
        'username'    => env('PAYPAL_LIVE_API_USERNAME', 'customerservice_api1.4ustralia.com'),
        'password'    => env('PAYPAL_LIVE_API_PASSWORD', 'FMG3S9UN97SFNGVA'),
        'secret'      => env('PAYPAL_LIVE_API_SECRET', 'EJzPTHSrC4U1QL5Bpv9_qDM8jl_mwRPoma1Ag4ILqr7VqRJ9Nmc9xOQJlhm3A5DItr-HrmMg8nPzVnMO'),
        'certificate' => env('PAYPAL_LIVE_API_CERTIFICATE', 'ACr3xh0ZiooNB4A8OjGvS.hzs9EYA20Hspl-vxGDUW5TjAhyMisFSIyN'),
        'app_id'      => 'ARKq1N9xlOqXqQ54asGEhNn6NqZZXdXzVDWq2ceA01kn-WwJzVuo35YR383nqSj_OxZHXFvgwEjgTmfG',
    ],

    'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => 'AUD',
    'billing_type'   => 'MerchantInitiatedBilling',
    'notify_url'     => 'https://login.ausreg.net/manage/paypal/ipn',
    'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => true, // Validate SSL when creating api client.
];
