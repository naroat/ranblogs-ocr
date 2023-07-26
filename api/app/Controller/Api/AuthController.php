<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\AuthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class AuthController extends AbstractController
{
    /**
     * @Inject()
     * @var AuthService
     */
    private $authService;

    public function loginPhone(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['phone', ''],
            ['password', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'phone' => 'required|phone',
                'password' => 'required',
            ], []);

            $list = $this->authService->login($params);

            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function registerPhone(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['nick_name', ''],
            ['phone', ''],
            ['code', ''],
            ['password', ''],
            ['password_confirmation', ''],
            ['invite_code', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'nick_name' => 'required',
                'phone' => 'required|phone',
                'code' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'invite_code' => 'between:12,12',
            ], [
                'invite_code.between' => '邀请码无效'
            ]);

            $this->authService->register($params);

            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 注册 - 发送短信验证码
     */
    public function sendRegisterCode()
    {
        $params = $this->verify->requestParams([
            ['phone', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'phone' => 'required|phone',
            ], []);
            $this->authService->sendRegisterCode($params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 修改密码 - 发送短信验证码
     */
    public function sendResetPasswordCode()
    {
        try {
            $phone = $this->request->getAttribute('phone');
            $this->authService->sendResetPasswordCode($phone);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 修改密码
     */
    public function resetPassword()
    {
        $params = $this->verify->requestParams([
            ['code', ''],
            ['password', ''],
            ['password_confirmation', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'code' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ], []);

            $this->authService->resetPassword($params);

            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function logout()
    {
        $this->authService->logout();
        return $this->responseCore->success([]);
    }
}
