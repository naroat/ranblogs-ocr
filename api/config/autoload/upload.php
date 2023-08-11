<?php

return [
    //上传驱动 local:本地； aliyun: 阿里云oss
    'drive' => env('UPLOAD_DRIVE', 'local'),
    //最大可上传文件大小
    'upload_max_size' => env('UPLOAD_MAX_SIZE', 20971520),
];
