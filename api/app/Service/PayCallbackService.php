<?php
namespace App\Service;


use App\Amqp\Producer\IntegralProducer;
use App\Constants\IntegralLogType;
use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;

class PayCallbackService
{
    /**
     * @Inject()
     * @var Producer
     */
    private $preducer;

    public function callback()
    {
        $eventName = $all['meta']['event_name'] ?? '';
        if (!in_array($eventName, ['order_created', 'order_refunded'])) {
            //数据异常或者不属于需要处理的事件
            return false;
        }

        //过滤无用户信息的回调
        $userId = $all['meta']['user_id'];
        if (empty($userId)) {
            return false;
        }

        switch ($eventName) {
            case 'order_created':
                //普通订单
                $this->preducer->produce(new IntegralProducer(['type' => IntegralLogType::RECHARGE, 'user_id' => $userId]));
                break;
            case 'order_refunded':
                //部分或全部退款
                break;
        }
    }
}