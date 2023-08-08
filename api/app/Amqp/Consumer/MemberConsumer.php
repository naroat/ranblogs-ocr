<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Model\LemonSubscription;
use App\Model\Users;
use App\Service\LemonOrderService;
use App\Service\LemonSubscriptionInvoicesService;
use App\Service\LemonSubscriptionService;
use App\Service\MemberService;
use App\Traits\LogTrait;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @Consumer(exchange="hyperf", routingKey="hyperf", queue="hyperf", name="MemberConsumer", nums=1)
 */
#[Consumer(exchange: 'hyperf', routingKey: 'hyperf', queue: 'hyperf', name: "MemberConsumer", nums: 1)]
class MemberConsumer extends ConsumerMessage
{
    /**
     * @Inject()
     * @var LemonOrderService
     */
    private $orderService;

    /**
     * @Inject()
     * @var LemonSubscriptionService
     */
    private $subscriptionService;

    /**
     * @Inject()
     * @var LemonSubscriptionInvoicesService
     */
    private $subscriptionInvoicesService;

    /**
     * @Inject()
     * @var MemberService
     */
    private $memberService;

    public function consumeMessage($data, AMQPMessage $message): string
    {
        //分布式保证只有一个消费者 推入主消费
        if (env('SER') != 1) return Result::REQUEUE;

        $logger = LogTrait::get('member');

        $logger->info('开始处理会员订单-' . json_encode($data));

        try {
            Db::beginTransaction();
            $this->handle($data, $logger);
            Db::commit();
        } catch (\Exception $e) {
            $logger->error("");
            Db::rollBack();
        }

        return Result::ACK;
    }

    /**
     * 操作
     *
     * @param $data
     * @param $logger
     * @throws \Exception
     */
    public function handle($data, $logger)
    {
        $attributes = $data['data']['data']['attributes'] ?? [];
        if (empty($attributes)) {
            throw new \Exception("参数异常");
        }


        //发起订单 - 支付订单 - 完成订单
        switch ($data['event']) {
            case 'order_create':
                //check
                $dataType = $data['data']['data']['type'] ?? '';
                if ($dataType != 'orders') {
                    //收到的返回必须是`orders`类型，这样才能保证$attributes中的很多字段存在
                    throw new \Exception('非订单对象');
                }

                //验证用户信息
                $userId = $data['user_id'];
                $user = Users::where('status', 0)->find($userId);
                if (!$user) {
                    throw new \Exception("用户异常");
                }

                //创建订单
                $this->orderService->updateOrInsert([
                    'user_id' => $userId,
                    'type' => 1,
                    'order_id' => $data['data']['data']['id']
                ], $attributes);
                break;
            case 'subscription_created':
            case 'subscription_updated':
                //创建订阅；注意创建订阅和创建订单同是同时的，所以该订阅对象单独记录，通过lemonsqueezy的order_id关联
                $dataType = $data['data']['data']['type'] ?? '';
                if ($dataType != 'subscriptions') {
                    throw new \Exception('非订阅对象');
                }

                //更新或新增
                $this->subscriptionService->updateOrInsert([
                    'subscription_id' => $data['data']['data']['id'],
                ], $attributes);
                break;
            case 'subscription_payment_success':
                //订阅支付成功
                $dataType = $data['data']['data']['type'] ?? '';
                if ($dataType != 'subscription-invoices') {
                    throw new \Exception('非订阅发票对象');
                }

                //记录发票
                $this->subscriptionInvoicesService->updateOrInsert([
                    'subscription_invoices_id' => $data['data']['data']['id'],
                ], $attributes);

                //支付成功，发放会员
                if ($attributes['status'] == 'paid') {
                    //获取订阅
                    $subscription = LemonSubscription::where('subscription_id', $attributes['subscription_id'])->first();
                    if (!$subscription) {
                        throw new \Exception('订阅信息不存在');
                    }
                    //处理会员
                    $this->memberService->handleMember($subscription->order_id, $subscription->store_id, $subscription->product_id, $subscription->variant_id);
                }
                break;
        }
    }

}
