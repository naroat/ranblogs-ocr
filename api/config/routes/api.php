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
    //忘记密码 - 发送验证码
    Router::post('/send/forget/password/code', 'App\Controller\Api\AuthController@sendForgetPasswordCode');
    //忘记密码
    Router::post('/forget/password', 'App\Controller\Api\AuthController@forgetPassword');
    //get tool list
    Router::get('/tools', 'App\Controller\Api\ToolController@index');
    //get tool cate
    Router::get('/tool/cates', 'App\Controller\Api\ToolCateController@index');
    //get tool recommend
    Router::get('/tool/recommends', 'App\Controller\Api\ToolController@randomRecommend');
});

Router::addGroup('/v1', function () {
    Router::post('/test', 'App\Controller\IndexController@index');
    //修改密码 - 发送验证码
    Router::post('/send/reset/password/code', 'App\Controller\Api\AuthController@sendResetPasswordCode');
    //修改密码
    Router::post('/reset/password', 'App\Controller\Api\AuthController@resetPassword');
    //登出
    Router::post('/logout', 'App\Controller\Api\AuthController@logout');
    //签到
    Router::post('/check/in', 'App\Controller\Api\UserController@checkIn');
    //用户信息
    Router::get('/user/info', 'App\Controller\Api\UserController@show');
    //获取积分产品
    Router::get('/integral/product/lists', 'App\Controller\Api\IntegralProductController@index');
    //获取会员产品
    Router::get('/member/product/lists', 'App\Controller\Api\MemberProductController@index');
    //购买积分
    Router::post('/buy/integral', 'App\Controller\Api\OrderController@buyIntegral');
    //购买会员
    Router::post('/buy/member', 'App\Controller\Api\OrderController@buyMember');
    //积分流水列表
    Router::get('/integral/lists', 'App\Controller\Api\IntegralLogController@index');
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