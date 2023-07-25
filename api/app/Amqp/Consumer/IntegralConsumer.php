<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Constants\IntegralLogType;
use App\Model\ApiProduct;
use App\Model\Config;
use App\Model\IntegralLog;
use App\Model\IntegralProduct;
use App\Model\Recharge;
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
use function Taoran\HyperfPackage\Helpers\set_save_data;

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
                    /*
                     * 充值
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

    /**
     * 充值
     *
     * @param $data
     * @return array
     * @throws \Exception
     */
    private  function recharge($data)
    {
        $meta = $data['data']['meta'] ?? [];
        $attributes = $data['data']['data']['attributes'] ?? [];
        if (empty($meta) || empty($attributes)) {
            throw new \Exception("参数异常");
        }

        $dataType = $data['data']['data']['type'] ?? '';
        if ($dataType != 'orders') {
            //收到的返回必须是`orders`类型，这样才能保证$attributes中的很多字段存在
            throw new \Exception('非订单类型');
        }

        //验证用户信息
        $userId = $data['user_id'];
        $user = Users::where('status', 0)->find($userId);
        if (!$user) {
            throw new \Exception("用户异常");
        }

        //验证产品信息
        $integralProduct = IntegralProduct::where('platform_product_id', $attributes['first_order_item']['product_id'])
            ->where('platform_variant_id', $attributes['first_order_item']['variant_id'])
            ->where('status', 1)
            ->first();
        if (!$integralProduct) {
            throw new \Exception('产品不存在');
        }

        //判断是否支付成功
        if ($attributes['status'] != 'paid') {
            throw new \Exception("支付未成功，状态status：" . $attributes['status']);
        }

        //支付的金额
        $amount = $attributes['first_order_item']['price'];

        //产品积分
        $integral = $integralProduct->integral;

        //记录充值信息
        $recharge = new Recharge();
        set_save_data($recharge, [
            'order_no' => $attributes['identifier'],
            'user_id' => $userId,
            'status' => Recharge::STATUS_SUCCESS,
            'amount' => $amount,   //价格单位为分
            'finish_time' => date("Y-m-d H:i:s", time()),
            'recharge_type' => Recharge::RECHARGE_TYPE_INTEGRAL,
            'integral' => $integral,
            'currency' => $attributes['currency'],
            'trade_no' => $attributes['first_order_item']['order_id'],
            'trade_user_id' => $attributes['customer_id'],
            'store_id' => $attributes['store_id'] ?? 0,
        ]);
        $recharge->save();

        //更新用户积分信息
        $beforeIntegral = $user->integral;                              //变动前积分
        $changeIntegral = $integral;                                    //变动积分
        $currentIntegral = $beforeIntegral + $changeIntegral;           //计算当前积分
        $currentIntegral = $currentIntegral < 0 ? 0 : $currentIntegral; //当前积分
        $user->integral = $currentIntegral;
        $user->save();

        $io = 1; //收入
        $type = IntegralLogType::RECHARGE;
        $remark = IntegralLogType::getMessage(IntegralLogType::RECHARGE) . ": {$integral}";
        return [
            $userId, $io, $type, $beforeIntegral, $changeIntegral, $currentIntegral, $remark
        ];
    }
}
