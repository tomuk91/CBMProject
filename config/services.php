<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'unsplash' => [
        'access_key' => env('UNSPLASH_ACCESS_KEY'),
    ],

    'google' => [
        'service_account_json' => env('GOOGLE_SERVICE_ACCOUNT_JSON', storage_path('app/google-credentials.json')),
        'calendar_id' => env('GOOGLE_CALENDAR_ID', 'primary'),
    ],

    'business' => [
        'name' => env('BUSINESS_NAME', 'CBM Auto'),
        'phone' => env('BUSINESS_PHONE', '+36 1 234 5678'),
        'email' => env('BUSINESS_EMAIL', 'info@cbmauto.com'),
        'address' => env('BUSINESS_ADDRESS', '1234 Budapest, Example Street 12'),
        'city' => env('BUSINESS_CITY', 'Budapest'),
        'postal_code' => env('BUSINESS_POSTAL_CODE', '1234'),
        'country' => env('BUSINESS_COUNTRY', 'Hungary'),
        'latitude' => env('BUSINESS_LATITUDE', '47.4979'),
        'longitude' => env('BUSINESS_LONGITUDE', '19.0402'),
        'opening_hours' => [
            'monday' => env('BUSINESS_HOURS_MONDAY', '09:00-17:00'),
            'tuesday' => env('BUSINESS_HOURS_TUESDAY', '09:00-17:00'),
            'wednesday' => env('BUSINESS_HOURS_WEDNESDAY', '09:00-17:00'),
            'thursday' => env('BUSINESS_HOURS_THURSDAY', '09:00-17:00'),
            'friday' => env('BUSINESS_HOURS_FRIDAY', '09:00-17:00'),
            'saturday' => env('BUSINESS_HOURS_SATURDAY', '09:00-13:00'),
            'sunday' => env('BUSINESS_HOURS_SUNDAY', 'Closed'),
        ],
    ],

];
