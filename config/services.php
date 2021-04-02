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
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_ID', '155118718269858'),
        'client_secret' => env('FACEBOOK_SECRET', '463299ea8735b46e6a9a7d374b546ba9'),
        'redirect' => env('APP_URL') . '/login/facebook/callback'
    ],

    'google' => [
        'key' => 'AIzaSyBvkmSfZ2tgoATkurtr44Ez1nI2beFYw48',
        'client_id' => '698283458674-tf4g5ikpsirdpqe0bnk3qokgv0pt4df9.apps.googleusercontent.com',
        'client_secret' => 'ucmS3QclXcT6wm0fnO-cs4FX',
        'redirect' => env('APP_URL') . '/login/google/callback'
    ]

];
