<?php

declare(strict_types=1);

return [
    'default' => [
        //host
        'host' => env('EMAIL_HOST', ''),
        //端口
        'port' => env('EMAIL_PORT', 465),
        //发件人邮箱
        'from' => env('EMAIL_FROM', ''),
        //smtp密码
        'password' => env('EMAIL_PASSWORD', ''),
        //使用安全协议
        'smtp_secure' => env('EMAIL_SMTP_SECURE', 'ssl'),
        //字符集
        'charset' => env('EMAIL_CHARSET', 'UTF-8'),
    ],
];
