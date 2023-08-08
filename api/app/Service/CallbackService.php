<?php
namespace App\Service;


use App\Amqp\Producer\IntegralProducer;
use App\Amqp\Producer\MemberProducer;
use App\Constants\IntegralLogType;
use App\Model\IntegralLog;
use App\Model\IntegralProduct;
use App\Model\MemberProduct;
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
    private $producer;

    public function payCallback($all)
    {
        $eventName = $all['meta']['event_name'] ?? '';
        if (!in_array($eventName, ['order_created', 'subscription_created', 'subscription_payment_success', 'subscription_updated'])) {
            //数据异常或者不属于需要处理的事件
            throw new \Exception("数据异常或者不属于需要处理的事件");
        }

        //获取自定义数据
        $customData = $all['meta']['custom_data'] ?? [];

        //过滤无用户信息的回调
        if (empty($customData['user_id'])) {
            throw new \Exception("用户信息错误");
        }

        //创建订单
        if ($eventName == 'order_created') {
            //单次订单(订阅也会有该该事件，订阅时不能确认是否支付；订阅使用subscription_created即可)

            //判断购买什么类型的产品
            $integralProductModel = new IntegralProduct();
            $memberProductModel = new MemberProduct();
            //获取产品信息
            $where = [];
            $where['platform'] = 1;
            $where['platform_store_id'] = $all['data']['attributes']['store_id'];
            $where['platform_product_id'] = $all['data']['attributes']['first_order_item']['product_id'];
            $where['platform_variant_id'] = $all['data']['attributes']['first_order_item']['variant_id'];
            $integralProduct = $integralProductModel->where($where)->first();
            $memberProduct = $memberProductModel->where($where)->first();
            if ($integralProduct) {
                //积分订单
                $this->producer->produce(new IntegralProducer([
                    'type' => IntegralLog::TYPE_RECHARGE,
                    'user_id' => $customData['user_id'],
                    'data' => $all,
                ]));
            } else if ($memberProduct) {
                //订阅订单
                $this->producer->produce(new MemberProducer([
                    'event' => $eventName,
                    'user_id' => $customData['user_id'],
                    'data' => $all,
                ]));
            } else {
                throw new \Exception('无该产品');
            }
        } else if (in_array($eventName, ['subscription_created', 'subscription_payment_success', 'subscription_updated'])) {
            //订阅会员
            $this->producer->produce(new MemberProducer([
                'event' => $eventName,
                'user_id' => $customData['user_id'],
                'data' => $all,
            ]));
        }
    }
}