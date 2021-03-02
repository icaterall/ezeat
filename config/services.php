<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'pusher' => [
        'app_id' => env('PUSHER_APP_ID'),
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'cluster' => env('CLUSTER'),
        
    ],

   'kiple' => [
        'ApiKey' => env('KIPLE_API'),
        'username' => env('KIPLE_USERNAME'),
        'url' => env('KIPLE_URL'),
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

  'googlekey' => [
    'ApiKey' => env('GOOGLE_KEY'),
     ], 


'stripe' => [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
     ],


 'razer' => [
    'id' => env('RAZER_ID'),
    'key' => env('RAZER_KEY'),
    'secret' => env('RAZER_SECRET'),
    'url' => env('RAZER_URL'),
     ],    

'smsapi' => [
    'ApiKey' => env('SMS_KEY'),
     ],



'facebook' => [
    'client_id' => env('FB_KEY'),
    'client_secret' => env('FB_SECRET'),
    'redirect' => 'https://icaterall.com/callback',
     ],
   
   'fcm' => [
        'key' => env('FCM'),
    ]

];
