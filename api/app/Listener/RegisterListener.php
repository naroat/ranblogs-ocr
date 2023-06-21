<?php

declare(strict_types=1);

namespace App\Listener;

use App\Amqp\Producer\IntegralProducer;
use App\Constants\IntegralLogType;
use App\Event\RegisterEvent;
use App\Model\Config;
use App\Model\IntegralLog;
use App\Service\IntegralLogService;
use Hyperf\Amqp\Producer;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Redis\Redis;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use function Taoran\HyperfPackage\Helpers\set_save_data;

/**
 * @Listener
 */
#[Listener]
class RegisterListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @Inject()
     * @var Redis
     */
    private $redis;

    /**
     * @Inject()
     * @var IntegralLogService
     */
    private $integralLogService;

    /**
     * @Inject()
     * @var Producer
     */
    private $producer;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            RegisterEvent::class,
        ];
    }

    public function process(object $event)
    {
        //注册成功，将验证码失效
        $this->redis->delete($this->resetPasswordCodeCache->getKey($event->users->phone));

        //邀请用户发放积分
        $this->producer->produce(new IntegralProducer(['type' => 2, 'user_id' => $event->userId, 'invite_user_id' => $event->inviteUserId]));
    }
}
