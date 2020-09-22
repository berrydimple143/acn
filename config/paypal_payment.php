<?php

return [
    # Define your application mode here
    'mode' => 'sandbox',
	
	//Live Details
	// 'email' => 'customerservice@4ustralia.com'
	// 'client_id' => env('PAYPAL_CLIENT_ID', 'ARKq1N9xlOqXqQ54asGEhNn6NqZZXdXzVDWq2ceA01kn-WwJzVuo35YR383nqSj_OxZHXFvgwEjgTmfG'),
    // 'client_secret' => env('PAYPAL_CLIENT_SECRET', 'EJzPTHSrC4U1QL5Bpv9_qDM8jl_mwRPoma1Ag4ILqr7VqRJ9Nmc9xOQJlhm3A5DItr-HrmMg8nPzVnMO'),
    // Sandbox Email => 'merchant@australianregionalnetwork.com.au'
	
	# Account credentials from developer portal    
	'account' => [
        'client_id' => env('PAYPAL_CLIENT_ID', 'AQmNvIunVvHfd6w4m0FwFh-MG18pAsXicPfZM96HfvI3TUgYzwJtNEwBY1F9jR4QqL0_nLUnVHFF66Mu'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', 'EEby4ZJtIFJv7Gqhf1dr2LM6hubZXQBZ5GTYOsTd-5XhJ3rhrNjE3AA3sqz0WD6DhWrIDcpn-ZNU-73K'),
    ],

    # Connection Information
    'http' => [
        'connection_time_out' => 30,
        'retry' => 1,
    ],

    # Logging Information
    'log' => [
        'log_enabled' => true,

        # When using a relative path, the log file is created
        # relative to the .php file that is the entry point
        # for this request. You can also provide an absolute
        # path here
        'file_name' => '../PayPal.log',

        # Logging level can be one of FINE, INFO, WARN or ERROR
        # Logging is most verbose in the 'FINE' level and
        # decreases as you proceed towards ERROR
        'log_level' => 'FINE',
    ],
];
