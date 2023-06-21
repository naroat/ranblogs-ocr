<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

//根据配置设置是否需要登录使用的openapi
$baseOpenapiIsLogin = config('base_openapi_is_login');
$noLoginMiddleware = [
    App\Middleware\OpenapiMiddleware::class
];
if ($baseOpenapiIsLogin == 'true') {
    //基础openapi也需要登录后使用
    array_push($noLoginMiddleware, App\Middleware\JWTAuthMiddleware::class,);
}

//必须登录后使用的openapi
$middleware = [
    App\Middleware\JWTAuthMiddleware::class,
    App\Middleware\OpenapiMiddleware::class
];

//openai
Router::addGroup('/v1/openai', function () use ($middleware) {
    //chat completions
    Router::post('/chat/completions', 'App\Controller\Openapi\OpenaiController@chatCompletions');
    //images generations
    Router::post('/images/generations', 'App\Controller\Openapi\OpenaiController@imagesGenerations');
    //audio transcriptions
    Router::post('/audio/transcriptions', 'App\Controller\Openapi\OpenaiController@audioTranscriptions');
}, ['middleware' => $middleware]);

Router::addGroup('/v1/juhe', function () use ($middleware) {
    //新闻头条列表
    Router::post('/toutiao/index', 'App\Controller\Openapi\JuHeController@toutiaoIndex');
    Router::post('/toutiao/content', 'App\Controller\Openapi\JuHeController@toutiaoContent');
}, ['middleware' => $middleware]);

Router::addGroup('/v1/baidu', function () use ($middleware) {
    //通用文字识别（标准版）
    Router::post('/ocr/general/basic', 'App\Controller\Openapi\BaiduController@ocrGeneralBasic');
}, ['middleware' => $noLoginMiddleware]);