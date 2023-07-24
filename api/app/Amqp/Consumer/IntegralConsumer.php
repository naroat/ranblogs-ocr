<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Constants\IntegralLogType;
use App\Model\ApiProduct;
use App\Model\Config;
use App\Model\IntegralLog;
use App\Model\Users;
use App\Service\IntegralLogService;
use App\Service\UserService;
use App\Traits\LogTrait;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Logger\Logger;
use Hyperf\Logger\LoggerFactory;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @Consumer(exchange="openapi_integral", routingKey="openapi_integral_queue", queue="openapi_integral_queue", name="IntegralConsumer", nums=1)
*/
#[Consumer(exchange: 'openapi_integral', routingKey: 'openapi_integral_queue', queue: 'openapi_integral_queue', name: "IntegralConsumer", nums: 1)]
class IntegralConsumer extends ConsumerMessage
{
    /**
     * @Inject()
     * @var IntegralLogService
     */
    private $integralLogService;

    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    public function consumeMessage($data, AMQPMessage $message): string
    {
        if (!isset($data['type'])) {
            return Result::ACK;
        }

        $logger = LogTrait::get('integral');

        $logger->info('开始处理积分：' . json_encode($data));

        try {
            Db::beginTransaction();
            switch ($data['type']) {
                case IntegralLogType::USE_INTERFACE:
                    /*
                     * 调用接口扣除积分
                     */
                    list($userId, $io, $type, $beforeIntegral, $changeIntegral, $currentIntegral, $remark) = $this->openapiOrder($data);
                    break;
                case IntegralLogType::CHECK_IN:
                    /*
                     * 签到
                     */
                    list($userId, $io, $type, $beforeIntegral, $changeIntegral, $currentIntegral, $remark) = $this->checkIn($data);
                    break;
                case IntegralLogType::INVITE:
                    /*
                     * 邀请用户
                     */
                    list($userId, $io, $type, $beforeIntegral, $changeIntegral, $currentIntegral, $remark) = $this->invite($data);
                    break;
                case IntegralLogType::RECHARGE:
                    /**
                     * recharge
                     */
                    list($userId, $io, $type, $beforeIntegral, $changeIntegral, $currentIntegral, $remark) = $this->recharge($data);
                    break;
                default:
                    $logger->info('integral type err');
                    break;
            }

            //记录流水
            $this->integralLogService->record(
                $userId,
                $io,
                $type,
                $beforeIntegral,
                $changeIntegral,
                $currentIntegral,
                $remark
            );

            Db::commit();
            $logger->info("结束处理积分");
        } catch (\Exception $e) {
            $logger->error("处理积分失败：[{$data['user_id']}]" . $e->getMessage());
            Db::rollBack();
        }

        return Result::ACK;
    }

    /**
     * 签到
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function checkIn($data)
    {
        $config = Config::where('code', 'check_in_integral')->first();
        if (!$config) {
            throw new \Exception('配置异常');
        }
        if ($config->value == 0) {
            throw new \Exception('无可赠送积分');
        }
        $user = Users::find($data['user_id']);
        $beforeIntegral = $user->integral;
        $changeIntegral = $config->value;
        $currentIntegral = $beforeIntegral + $changeIntegral;
        $user->integral = $currentIntegral;
        $user->save();

        $remark = IntegralLogType::getMessage(IntegralLogType::CHECK_IN);
        $io = 1;
        return [
            $user->id, $io, IntegralLogType::CHECK_IN, $beforeIntegral, $changeIntegral, $currentIntegral, $remark
        ];
    }

    /**
     * 邀请用户
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    private function invite($data)
    {
        $inviteUsers = Users::find($data['inviteUserId']);
        if (!$inviteUsers) {
            throw new \Exception('邀请人无效');
        }
        //获取配置
        $config = Config::where('code', 'invite_integral')->first();
        $inviteIntegral = $config->invite_integral ? (int)$config->invite_integral : 0;
        if ($inviteIntegral == 0) {
            throw new \Exception('无可发放的积分');
        }
        $beforeIntegral = $inviteUsers->integral;
        $changeIntegral = $inviteIntegral;
        $currentIntegral = $inviteUsers->integral + $inviteIntegral;
        $inviteUsers->integral = $currentIntegral;
        $inviteUsers->save();

        //记录流水
        $remark = IntegralLogType::getMessage(IntegralLogType::INVITE) . ':' . $data['user_id'];
        $io = 1;
        $type = IntegralLogType::INVITE;
        $userId = $inviteUsers->id;
        return [
            $userId, $io, $type, $beforeIntegral, $changeIntegral, $currentIntegral, $remark
        ];
    }

    /**
     * openapi订单
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    private function openapiOrder($data)
    {
        $this->userService->checkExecOpenapi($data['user_id'], $data['product'], $openapiInfo);

        $user = Users::find($data['user_id']);
        $beforeIntegral = $user->integral;
        $changeIntegral = $openapiInfo->integral;
        $currentIntegral = $beforeIntegral - $changeIntegral;
        $currentIntegral = $currentIntegral < 0 ? 0 : $currentIntegral;
        $user->integral = $currentIntegral;
        $user->save();

        $remark = IntegralLogType::getMessage(IntegralLogType::USE_INTERFACE) . "{积分{$openapiInfo->integral}; openapi code: $openapiInfo->code}";
        $type = IntegralLogType::USE_INTERFACE;
        $io = 2; //支出
        return [
            $data['user_id'], $io, $type, $beforeIntegral, $changeIntegral, $currentIntegral, $remark
        ];
    }

    private  function recharge($data)
    {
        $meta = $data['data']['meta'] ?? [];
        if (empty($meta)) {
            throw new \Exception('');
        }
        $userId = $meta['user_id'];

        $user = Users::find($userId);


    }
}
