<?php


namespace App\Service;


use App\Cache\RegisterCode;
use App\Cache\RegisterCodeCache;
use App\Cache\ResetPasswordCodeCache;
use App\Constants\SmsTemplate;
use App\Event\RegisterEvent;
use App\Model\Users;
use App\Model\UserSecret;
use App\Model\UserToken;
use App\Package\Sms\src\Sms;
use App\Traits\Util;
use Hyperf\Context\Context;
use Hyperf\Database\Model\Register;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\EventDispatcher;
use Hyperf\Redis\Redis;
use Phper666\JwtAuth\Jwt;
use function Taoran\HyperfPackage\Helpers\encode_hashids;
use function Taoran\HyperfPackage\Helpers\Password\create_password;
use function Taoran\HyperfPackage\Helpers\Password\eq_password;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class AuthService
{
    /**
     * @Inject()
     * @var Sms
     */
    private $sms;

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
        $users = Users::where('phone', $param['phone'])
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
                'phone' => $users->phone,
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
        $code = $this->redis->get($this->registerCodeCache->getKey($param['phone']));
        if ($code != $param['code']) {
            throw new \Exception('验证码错误');
        }

        //检查是否已经注册
        $users = Users::where('phone', $param['phone'])->first();
        if ($users) {
            throw new \Exception('用户已存在');
        }

        //生成密码
        $password = create_password($param['password'], $salt);

        try {
            Db::beginTransaction();
            //入库
            $usersModel = new Users();
            $insertUsers = [
                'nick_name' => $param['nick_name'],
                'password' => $password,
                'salt' => $salt,
                'phone' => $param['phone'],
                'other_invite_code' => $inviteUser->invite_code,
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
        $this->event->dispatch(new RegisterEvent($usersModel->id, $inviteUser->id));
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
        $code = $this->redis->get($this->registerCodeCache->getKey($param['phone']));
        if ($code) {
            throw new \Exception('验证码未过期');
        }

        $users = Users::where('phone', $param['phone'])->first();
        if ($users && $users->status == 1) {
            throw new \Exception('用户被禁用');
        } else if ($users) {
            throw new \Exception('用户已存在');
        }
        //发送验证码
        $code = Util::getCode();
        if (env('APP_ENV') != 'dev') {
            $response = $this->sms->send($param['phone'], json_encode(['code' => $code]), config('sms.templates.code'));
            if (!$response || $response->body->code != 'OK') {
                throw new \Exception('发送失败');
            }
        }

        //记录缓存
        $this->redis->set($this->registerCodeCache->getKey($param['phone']), $code, 60);
    }

    /**
     * 发送修改密码验证码
     * @param $param
     */
    public function sendResetPasswordCode($phone)
    {
        $code = $this->redis->get($this->resetPasswordCodeCache->getKey($phone));
        if ($code) {
            throw new \Exception('验证码未过期');
        }

        $users = Users::where('phone', $phone)->first();
        if (!$users) {
            throw new \Exception('用户异常！');
        }
        //发送验证码
        $code = Util::getCode();
        $response = $this->sms->send($phone, json_encode(['code' => $code]), config('sms.templates.code'));
        if (!$response || $response->body->code != 'OK') {
            throw new \Exception('发送失败');
        }

        //记录缓存
        $this->redis->set($this->resetPasswordCodeCache->getKey($phone), $code, 60);
    }

    public function resetPassword($param)
    {
        $phone = Context::get('phone');
        //检查验证码
        $code = $this->redis->get($this->resetPasswordCodeCache->getKey($phone));
        if ($code != $param['code']) {
            throw new \Exception('验证码错误');
        }

        //检查是否已经注册
        $users = Users::where('phone', $param['phone'])->first();
        if (!$users) {
            throw new \Exception('用户不已存在');
        }

        //生成密码
        $password = create_password($param['password'], $salt);
        set_save_data($users, [
            'password' => $password,
            'salt' => $salt,
        ]);
        $users->save();

        return true;
    }
}