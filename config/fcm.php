<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAksvyq54:APA91bHZx5OlEEsErOMOdgfWi1Y8XVJZhQOF_AIjPTtgFChkYmSbILqesx6DeaZxvQXgl08nBWJ1uGWGyBxGSd8uzqrel62tSCZIm-uT6PTV0hhBRCqMKZtLyRm86WIfH0pDRl3oKK6y'),
        'sender_id' => env('FCM_SENDER_ID', '630486903710'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
