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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    'media' => [
        'cloudfront_url' => rtrim((string) env('MEDIA_CLOUDFRONT_URL', ''), '/'),
        'hero_video' => [
            'poster' => env('HERO_VIDEO_POSTER', 'images/landing-fallback.jpg'),
            'hls_manifest' => env('HERO_VIDEO_HLS_MANIFEST'),
            'desktop_mp4' => env('HERO_VIDEO_DESKTOP_MP4', 'video/TFM-desktop.mp4'),
            'mobile_mp4' => env('HERO_VIDEO_MOBILE_MP4', 'video/TFM-mobile.mp4'),
        ],
    ],

];
