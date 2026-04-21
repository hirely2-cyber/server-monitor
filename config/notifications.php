<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email Notifications
    |--------------------------------------------------------------------------
    */

    'email_enabled' => env('NOTIFICATIONS_EMAIL_ENABLED', false),
    'email_recipients' => env('NOTIFICATIONS_EMAIL_RECIPIENTS', ''),

    /*
    |--------------------------------------------------------------------------
    | Slack Notifications
    |--------------------------------------------------------------------------
    */

    'slack_enabled' => env('NOTIFICATIONS_SLACK_ENABLED', false),
    'slack_webhook' => env('NOTIFICATIONS_SLACK_WEBHOOK', ''),

    /*
    |--------------------------------------------------------------------------
    | Telegram Notifications
    |--------------------------------------------------------------------------
    */

    'telegram_enabled' => env('NOTIFICATIONS_TELEGRAM_ENABLED', false),
    'telegram_bot_token' => env('TELEGRAM_BOT_TOKEN', ''),
    'telegram_chat_id' => env('TELEGRAM_CHAT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */

    // Which severity levels to send notifications for
    'notify_on_severity' => ['critical', 'warning'],

    // Notification throttle (minutes) - prevent spam for same issue
    'throttle_minutes' => 30,

];
