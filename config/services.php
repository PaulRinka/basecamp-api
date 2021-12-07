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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id' => '481678063567-qjvhtd1hb2joq0dik4a8b3n1d1i0pi8v.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/callback/google',
      ], 

      '37signals' => [
        'client_id' => 'e4801fa21daa08ccc655cf13c6f879abb0f43fbb',
        'client_secret' => '1155ef24356cb99b6ae4cf811b98e242e7789a61',
        'redirect' => 'http://localhost:8000/callback/google/code=12207',
    ],
   
];




