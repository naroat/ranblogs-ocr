<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

$middleware = [
    \App\Middleware\JWTAuthMiddleware::class
];

//test
Router::addRoute(['GET', 'POST', 'PUT', 'DELETE'], '/test', 'App\Controller\IndexController@index');

Router::addGroup('/v1', function () {
    //注册 - 发送短信验证码
    Router::post('/send/register/code', 'App\Controller\Api\AuthController@sendRegisterCode');
    //注册
    Router::post('/register', 'App\Controller\Api\AuthController@register');
    //登录
    Router::post('/login', 'App\Controller\Api\AuthController@login');
});

Router::addGroup('/v1', function () {
    Router::post('/test', 'App\Controller\IndexController@index');
    //修改密码 - 发送短信验证码
    Router::post('/send/reset/password/code', 'App\Controller\Api\AuthController@sendResetPasswordCode');
    //登出
    Router::post('/logout', 'App\Controller\Api\AuthController@logout');
    //签到
    Router::post('/check/in', 'App\Controller\Api\CheckInController@CheckIn');
    //用户信息
    Router::post('/users', 'App\Controller\Api\UserController@show');
}, ['middleware' => $middleware]);

//pay
Router::addGroup('/v1/pay', function () use ($middleware) {
    //创建结算单
    Router::post('/checkouts', 'App\Controller\Api\PayController@checkouts');
    //回调
    Router::post('/callback', 'App\Controller\Api\PayCallbackController@callback');
});