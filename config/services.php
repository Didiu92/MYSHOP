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

    'metals' => [
        'key' => env('METALS_DEV_API_KEY'),
        'currency' => env('METALS_DEV_CURRENCY', 'EUR'),
        'unit' => env('METALS_DEV_UNIT', 'toz'),
        'metals' => env('METALS_DEV_METALS', 'gold,silver,platinum'),
    ],

    'exchange_rates' => [
        'base' => env('EXCHANGE_RATES_BASE', 'EUR'),
        'symbols' => env('EXCHANGE_RATES_SYMBOLS', 'USD,GBP'),
        'endpoint' => env('EXCHANGE_RATES_ENDPOINT', 'https://api.exchangerate.host/latest'),
        'key' => env('EXCHANGE_RATES_KEY'),
    ],

];
