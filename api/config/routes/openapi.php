<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

//根据配置设置是否需要登录使用的openapi; 开启后不需要登录的接口将需要登录才能使用
$baseOpenapiIsLogin = config('base_openapi_is_login');

//不需要登录时的中间件验证
$noLoginMiddleware = [
    App\Middleware\OpenapiMiddleware::class
];

if ($baseOpenapiIsLogin == 'true') {
    //基础openapi也需要登录后使用
    array_push($noLoginMiddleware, App\Middleware\JWTAuthMiddleware::class,);
}

//必须登录后的中间件验证
$middleware = [
    App\Middleware\JWTAuthMiddleware::class,
    App\Middleware\OpenapiMiddleware::class
];

//no free
Router::addGroup('/v1/openapi', function () use ($middleware) {
    /** openai */
    //chat completions
    Router::post('/chat/completions', 'App\Controller\Openapi\OpenaiController@chatCompletions');
    //images generations
    Router::post('/images/generations', 'App\Controller\Openapi\OpenaiController@imagesGenerations');
    //audio transcriptions
    //Router::post('/audio/transcriptions', 'App\Controller\Openapi\OpenaiController@audioTranscriptions');

    /** juhe */
    //新闻头条列表
    Router::post('/toutiao/index', 'App\Controller\Openapi\JuHeController@toutiaoIndex');
    Router::post('/toutiao/content', 'App\Controller\Openapi\JuHeController@toutiaoContent');

    /** deepgram */
    //audio transcriptions
    Router::post('/audio/transcriptions', 'App\Controller\Openapi\DeepgramController@audioTranscriptions');
}, ['middleware' => $middleware]);

//free
Router::addGroup('/v1/openapi', function () use ($middleware) {
    //通用文字识别（标准版）
    Router::post('/ocr/general/basic', 'App\Controller\Openapi\BaiduController@ocrGeneralBasic');
}, ['middleware' => $noLoginMiddleware]);