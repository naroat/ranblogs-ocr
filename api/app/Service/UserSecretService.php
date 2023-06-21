<?php
namespace App\Service;

use App\Model\ApiProduct;
use App\Model\OpenapiProduct;
use App\Model\Users;
use App\Model\UserSecret;
use App\Traits\OpenApiTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

class UserSecretService
{
    /**
     * @Inject()
     * @var Redis
     */
    public $redis;

    /**
     * 生成secret key
     *
     * @param $userId
     * @throws \Exception
     */
    public function genSecretKey($userId)
    {
        //生成key
        $keys = OpenApiTrait::genKey($userId);
        if (strlen($keys['access_key']) == 0 || strlen($keys['secret_key']) == 0) {
            throw new \Exception('密钥生成失败!');
        }
        //生成token
        $token = OpenApiTrait::genToken($keys['access_key'], $keys['secret_key']);
        //入库
        UserSecret::where('user_id', $userId)->delete();
        UserSecret::insert([
            'user_id' => $userId,
            'access_key' => $keys['access_key'],
            'secret_key' => $keys['secret_key'],
            'token' => $token
        ]);

        //记录到redis中
        $this->redis->set("ACCESS_KEY:" . $keys['access_key'], $token, 86400);
        return [
            'access_key' => $keys['access_key'],
            'secret_key' => $keys['secret_key'],
            'openapi_token' => $token,
        ];
    }
}