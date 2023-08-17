<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Constants\ResponseCode;
use App\Service\AuthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

/**
 * 默认身份认证方式：邮件方式
 *
 * Class AuthController
 * @package App\Controller\Api
 */
class AuthController extends AbstractController
{
    /**
     * @Inject()
     * @var AuthService
     */
    private $authService;

    public function login(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['email', ''],
            ['password', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'email' => 'required|email',
                'password' => 'required',
            ], []);

            $list = $this->authService->login($params);

            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage(), ResponseCode::LOGIC_ERR);
        }
    }

    public function register(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            //['nick_name', ''],
            ['email', ''],
            ['code', ''],
            ['password', ''],
            ['password_confirmation', ''],
            ['invite_code', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                //'nick_name' => 'required',
                'email' => 'required|email',
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
            return $this->responseCore->error($e->getMessage(), ResponseCode::LOGIC_ERR);
        }
    }

    /**
     * 注册 - 发送短信验证码
     */
    public function sendRegisterCode()
    {
        $params = $this->verify->requestParams([
            ['email', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'email' => 'required|email',
            ], []);
            $this->authService->sendRegisterCode($params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage(), ResponseCode::LOGIC_ERR);
        }
    }

    /**
     * 修改密码 - 发送短信验证码
     */
    public function sendResetPasswordCode()
    {
        try {
            $email = $this->request->getAttribute('email');
            $this->authService->sendResetPasswordCode($email);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage(), ResponseCode::LOGIC_ERR);
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
            return $this->responseCore->error($e->getMessage(), ResponseCode::LOGIC_ERR);
        }
    }

    /**
     * 忘记密码 - 发送短信验证码
     */
    public function sendForgetPasswordCode()
    {
        $params = $this->verify->requestParams([
            ['email', ''],
        ], $this->request);
        try {
            $this->verify->check($params, [
                'email' => 'required|email',
            ], []);
            $email = $params['email'];
            $this->authService->sendForgetPasswordCode($email);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage(), ResponseCode::LOGIC_ERR);
        }
    }

    /**
     * 忘记密码
     */
    public function forgetPassword()
    {
        $params = $this->verify->requestParams([
            ['email', ''],
            ['code', ''],
            ['password', ''],
            ['password_confirmation', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'email' => 'required|email',
                'code' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ], []);

            $this->authService->forgetPassword($params);

            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage(), ResponseCode::LOGIC_ERR);
        }
    }


    public function logout()
    {
        $this->authService->logout();
        return $this->responseCore->success([]);
    }
}
