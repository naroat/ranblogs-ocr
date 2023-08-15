<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

//必须登录后的中间件验证
$middleware = [
    App\Middleware\JWTAuthMiddleware::class,
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
Router::addGroup('/v1/openapi', function () {
    //通用文字识别（标准版）
    Router::post('/ocr/general/basic', 'App\Controller\Openapi\BaiduController@ocrGeneralBasic');
});