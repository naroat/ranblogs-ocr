<?php

declare(strict_types=1);

return [
    /**
     * 驱动
     */
    'drive' => env('SMS_DRIVE', ''),

    /**
     * 签名
     */
    'sign_name' => env('SMS_SIGN_NAME', ''),

    /**
     * access key
     */
    'access_key' => env('SMS_ACCESS_KEY', ''),

    /**
     * access key secret
     */
    'access_key_secret' => env('SMS_ACCESS_KEY_SECRET', ''),

    /**
     * 消息模板
     */
    'templates' => [
        'code' => env('SMS_TEMPLATE_CODE', ''),
    ]
];
