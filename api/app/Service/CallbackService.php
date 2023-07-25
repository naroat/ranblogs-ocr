<?php
namespace App\Service;


use App\Amqp\Producer\IntegralProducer;
use App\Constants\IntegralLogType;
use App\Model\Users;
use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;

class CallbackService
{
    /**
     * @Inject()
     * @var Producer
     */
    private $preducer;

    public function payCallback($all)
    {
        $eventName = $all['meta']['event_name'] ?? '';
        if (!in_array($eventName, ['order_created', 'order_refunded'])) {
            //数据异常或者不属于需要处理的事件
            throw new \Exception("数据异常或者不属于需要处理的事件");
        }

        //获取自定义数据
        $customData = $all['meta']['custom_data'] ?? [];

        //过滤无用户信息的回调
        if (empty($customData['user_id'])) {
            throw new \Exception("用户信息错误");
        }

        switch ($eventName) {
            case 'order_created':
                //普通订单
                $this->preducer->produce(new IntegralProducer([
                    'type' => IntegralLogType::RECHARGE,
                    'user_id' => $customData['user_id'],
                    'data' => $all,
                ]));
                break;
            case 'order_refunded':
                //部分或全部退款
                break;
        }
    }
}