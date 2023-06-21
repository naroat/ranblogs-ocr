<?php

return [
    /**
     * Oss
     */
    'oss' => [
        'access_key_id' => env('OSS_ACCESS_KEY_ID', ''),
        'access_key_secret' => env('OSS_ACCESS_KEY_SECRET', ''),
        'endpoint' => env('OSS_ENDPOINT', ''),
        'bucket' => env('OSS_BUCKET', ''),
        'sub_dir' => env('OSS_SUB_DIR', 'default'),
        'bucket_domain' => env('OSS_BUCKET_DOMAIN', ''),
    ]
];
