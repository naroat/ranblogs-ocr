<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

$middleware = [
    \App\Middleware\JWTAuthMiddleware::class
];

//test
Router::addRoute(['GET', 'POST', 'PUT', 'DELETE'], '/test', 'App\Controller\IndexController@index');

Router::addGroup('/v1', function () {
    //注册 - 发送验证码
    Router::post('/send/register/code', 'App\Controller\Api\AuthController@sendRegisterCode');
    //注册
    Router::post('/register', 'App\Controller\Api\AuthController@register');
    //登录
    Router::post('/login', 'App\Controller\Api\AuthController@login');
    //忘记密码
    Router::post('/forget', 'App\Controller\Api\AuthController@login');
});

Router::addGroup('/v1', function () {
    Router::post('/test', 'App\Controller\IndexController@index');
    //修改密码 - 发送验证码
    Router::post('/send/reset/password/code', 'App\Controller\Api\AuthController@sendResetPasswordCode');
    //修改密码

    //登出
    Router::post('/logout', 'App\Controller\Api\AuthController@logout');
    //签到
    Router::post('/check/in', 'App\Controller\Api\UserController@checkIn');
    //分享
    Router::post('/share', 'App\Controller\Api\UserController@share');
    //用户信息
    Router::get('/user/info', 'App\Controller\Api\UserController@show');
    //购买积分
    Router::post('/buy/integral', 'App\Controller\Api\IntegralOrderController@buyIntegral');
    //download - curd
    Router::post('/download/lists', 'App\Controller\Api\DownloadController@index');
    Router::post('/download/show/{id}', 'App\Controller\Api\DownloadController@show');
    Router::post('/download/add', 'App\Controller\Api\DownloadController@store');
    Router::post('/download/update/{id}', 'App\Controller\Api\DownloadController@update');
    Router::post('/download/delete/{id}', 'App\Controller\Api\DownloadController@destroy');
}, ['middleware' => $middleware]);

//pay
Router::addGroup('/v1/pay', function () use ($middleware) {
    //获取产品
//    Router::post('/products', 'App\Controller\Api\PayController@checkouts');
    //获取变体
//    Router::post('/variants', 'App\Controller\Api\PayController@checkouts');
    //回调
    Router::post('/callback', 'App\Controller\Api\CallbackController@payCallback');
});