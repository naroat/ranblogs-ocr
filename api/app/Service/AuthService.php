<?php


namespace App\Service;


use App\Cache\ForgetPasswordCodeCache;
use App\Cache\RegisterCode;
use App\Cache\RegisterCodeCache;
use App\Cache\ResetPasswordCodeCache;
use App\Constants\SmsTemplate;
use App\Event\RegisterEvent;
use App\Model\Users;
use App\Model\UserToken;
use App\Package\Email\src\Email;
use App\Traits\Util;
use Hyperf\Context\Context;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\EventDispatcher;
use Hyperf\Redis\Redis;
use Phper666\JwtAuth\Jwt;
use Psr\Http\Message\ServerRequestInterface;
use function Taoran\HyperfPackage\Helpers\encode_hashids;
use function Taoran\HyperfPackage\Helpers\Password\create_password;
use function Taoran\HyperfPackage\Helpers\Password\eq_password;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class AuthService
{
    /**
     * @Inject()
     * @var Email
     */
    private $email;

    /**
     * @Inject()
     * @var RegisterCodeCache
     */
    private $registerCodeCache;

    /**
     * @Inject()
     * @var ResetPasswordCodeCache
     */
    private $resetPasswordCodeCache;

    /**
     * @Inject()
     * @var ForgetPasswordCodeCache
     */
    private $forgetPasswordCodeCache;

    /**
     * @Inject()
     * @var Jwt
     */
    private $jwt;

    /**
     * @Inject()
     * @var Redis
     */
    private $redis;

    /**
     * @Inject()
     * @var EventDispatcher
     */
    private $event;

    /**
     * @Inject()
     * @var ConfigService
     */
    private $configService;

    /**
     * @Inject()
     * @var UserSecretService
     */
    private $userSecretService;

    public function login($param)
    {
        $users = Users::where('email', $param['email'])
            ->with('userSecret')
            ->first();
        if (!$users) {
            throw new \Exception("用户不存在，请注册后登录");
        }

        if ($users->status == 1) {
            throw new \Exception("用户被禁用");
        }

        if (!eq_password($users->password, $param['password'], $users->salt)) {
            throw new \Exception("账号或密码错误");
        }

        try {
            Db::beginTransaction();

            //update last_login_time
            $users->last_login_time = date("Y-m-d H:i:s", time());
            $users->save();

            //insert user_token
            $token = $this->jwt->getToken([
                'user_id' => $users->id,
                'email' => $users->email,
            ]);
            $userToken = UserToken::where('user_id', $users->id)->first();
            $saveData = [];
            $saveData['token'] = $token;
            if (!$userToken) {
                //新增token
                $userToken = new UserToken();
                $saveData['user_id'] = $users->id;
            }
            set_save_data($userToken, $saveData);
            $userToken->save();

            if (!$users->userSecret) {
                //生成secret key
                $secretInfo = $this->userSecretService->genSecretKey($users->id);
                $access_key = $secretInfo['access_key'];
                $openapi_token = $secretInfo['openapi_token'];
            } else {
                $access_key = $users->userSecret->access_key;
                $openapi_token = $users->userSecret->token;
            }

            Db::commit();

            return [
                'token' => $token,
                'access_key' => $access_key,
                'openapi_token' => $openapi_token,
                'exp_time' => $this->jwt->getTTL(),
            ];
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function register($param)
    {
        //检查邀请码
        $inviteUser = null;
        if ($param['invite_code'] != '') {
            $inviteUser = Users::where('invite_code', $param['invite_code'])->where('status', 0)->first();
            if (!$inviteUser) {
                throw new \Exception('邀请码无效');
            }
        }

        //检查验证码
        $code = $this->redis->get($this->registerCodeCache->getKey($param['email']));
        if ($code != $param['code']) {
            throw new \Exception('验证码错误');
        }

        //检查是否已经注册
        $users = Users::where('email', $param['email'])->first();
        if ($users) {
            throw new \Exception('用户已存在');
        }

        //生成密码
        $password = create_password($param['password'], $salt);

        //生命名称
        $nickName = '用户' . rand(100000, 999999);
        try {
            Db::beginTransaction();
            //入库
            $usersModel = new Users();
            $insertUsers = [
                'nick_name' => $nickName,
                'password' => $password,
                'salt' => $salt,
                'email' => $param['email'],
                'other_invite_code' => $inviteUser->invite_code ?? '',
                'integral' => $this->configService->getConfigByCode('register_integral') ?? 0,
            ];
            set_save_data($usersModel, $insertUsers);
            $usersModel->save();

            //生成邀请码
            $inviteCode = encode_hashids('userid', $usersModel->id);
            $usersModel->invite_code = $inviteCode;
            $usersModel->save();

            //生成secret key
            $this->userSecretService->genSecretKey($usersModel->id);

            Db::commit();
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception($e->getMessage());
        }

        //注册成功后操作
        $this->event->dispatch(new RegisterEvent($usersModel, $inviteUser));
    }

    public function logout()
    {
        $this->jwt->logout();
        return true;
    }

    /**
     * 发送注册验证码
     */
    public function sendRegisterCode($param)
    {
        //检查验证码是否过期
        $code = $this->redis->get($this->registerCodeCache->getKey($param['email']));
        if ($code) {
            throw new \Exception('验证码未过期');
        }

        $users = Users::where('email', $param['email'])->first();
        if ($users && $users->status == 1) {
            throw new \Exception('用户被禁用');
        } else if ($users) {
            throw new \Exception('用户已存在');
        }
        //发送验证码
        $code = Util::getCode();
        if (env('APP_ENV') != 'dev') {
            if (!$this->email->send($param['email'], '注册验证码', $this->email->templateCode($code))) {
                throw new \Exception('邮件发送失败！');
            }
        }

        //记录缓存
        $this->redis->set($this->registerCodeCache->getKey($param['email']), $code, 180);
    }

    /**
     * 根据邮箱修改密码
     *
     * @param $email
     * @param $password
     * @return bool
     * @throws \Exception
     */
    public function updatePasswordByEmail($email, $password)
    {
        //检查是否已经注册
        $users = Users::where('email', $email)->where('status', 0)->first();
        if (!$users) {
            throw new \Exception('用户不存在');
        }

        //生成密码
        $password = create_password($password, $salt);
        set_save_data($users, [
            'password' => $password,
            'salt' => $salt,
        ]);
        $users->save();

        return true;
    }

    /**
     * 发送修改密码验证码
     *
     * @param $email
     * @throws \Exception
     */
    public function sendResetPasswordCode($email)
    {
        $code = $this->redis->get($this->resetPasswordCodeCache->getKey($email));
        if ($code) {
            throw new \Exception('验证码未过期');
        }

        $users = Users::where('email', $email)->where('status', 0)->first();
        if (!$users) {
            throw new \Exception('用户异常！');
        }
        //发送验证码
        $code = Util::getCode();
        if (env('APP_ENV') != 'dev') {
            if (!$this->email->send($email, '修改密码验证码', $this->email->templateCode($code))) {
                throw new \Exception('邮件发送失败！');
            }
        }
        //记录缓存
        $this->redis->set($this->resetPasswordCodeCache->getKey($email), $code, 180);
    }

    /**
     * 修改密码
     *
     * @param $param
     * @return bool
     * @throws \Exception
     */
    public function resetPassword($param)
    {
        $email = Context::get(ServerRequestInterface::class, 'email');
        //检查验证码
        $code = $this->redis->get($this->resetPasswordCodeCache->getKey($email));
        if ($code != $param['code']) {
            throw new \Exception('验证码错误');
        }

        $this->updatePasswordByEmail($email, $param['password']);

        return true;
    }

    /**
     * 发送忘记密码验证码
     *
     * @param $email
     * @throws \Exception
     */
    public function sendForgetPasswordCode($email)
    {
        $code = $this->redis->get($this->forgetPasswordCodeCache->getKey($email));
        if ($code) {
            throw new \Exception('验证码未过期');
        }

        $users = Users::where('email', $email)->where('status', 0)->first();
        if (!$users) {
            throw new \Exception('用户异常！');
        }
        //发送验证码
        $code = Util::getCode();
        if (env('APP_ENV') != 'dev') {
            if (!$this->email->send($email, '忘记密码验证码', $this->email->templateCode($code))) {
                throw new \Exception('邮件发送失败！');
            }
        }
        //记录缓存
        $this->redis->set($this->forgetPasswordCodeCache->getKey($email), $code, 180);
    }

    /**
     * 忘记密码
     *
     * @param $param
     * @return bool
     * @throws \Exception
     */
    public function forgetPassword($param)
    {
        //检查验证码
        $code = $this->redis->get($this->forgetPasswordCodeCache->getKey($param['email']));
        if ($code != $param['code']) {
            throw new \Exception('验证码错误');
        }

        $this->updatePasswordByEmail($param['email'], $param['password']);

        return true;
    }
}