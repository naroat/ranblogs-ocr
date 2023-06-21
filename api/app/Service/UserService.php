<?php
namespace App\Service;

use App\Model\ApiProduct;
use App\Model\OpenapiProduct;
use App\Model\Users;
use App\Model\UserSecret;
use App\Traits\OpenApiTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use function Taoran\HyperfPackage\Helpers\orm_sql;

class UserService
{
    /**
     * @Inject()
     * @var Redis
     */
    public $redis;

    public function getInfo($userId)
    {
        $users = Users::select(['id', 'nick_name', 'phone', 'avatar', 'status', 'integral', 'invite_code', 'other_invite_code', 'created_at'])->find($userId);
        if (!$users) {
            throw new \Exception('用户信息异常');
        }
        return $users;
    }

    /**
     * 用户积分或openapi产品配置检测等
     *
     * @param $userId
     * @param $openapiCode
     * @param $openapiinfo
     * @throws \Exception
     */
    public function checkExecOpenapi($userId, $openapiCode, &$openapiinfo)
    {
        $this->checkOpenapiValid($openapiCode);

        $usersExists = Users::where('id', $userId)
            ->where('integral', '>=', $openapiinfo->integral)
            ->exists();
        if (!$usersExists) {
            throw new \Exception('积分不足');
        }
    }

    public function checkOpenapiValid($openapiCode)
    {
        $openapiinfo = OpenapiProduct::where('code', $openapiCode)->first();
        if (!$openapiinfo) {
            throw new \Exception('openapi product error');
        }
    }
}