<?php

declare(strict_types=1);

namespace App\Command;

use App\Amqp\Producer\IntegralProducer;
use App\Event\SmsEvent;
use App\Exception\BusinessException;
use App\Exception\ServiceException;
use App\Package\CompressImg\src\CompressImg;
use App\Package\ScanFile\src\ScanFile;
use App\Service\UserService;
use App\Traits\LogTrait;
use App\Traits\OpenApi;
use App\Traits\OpenApiTrait;
use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\EventDispatcher;
use Hyperf\Redis\Redis;
use Psr\Container\ContainerInterface;

/**
 * @Command
 */
#[Command]
class TestCmd extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

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
     * @var UserService
     */
    private $userService;

    /**
     * @Inject()
     * @var \Hyperf\Amqp\Producer
     */
    private $producer;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('test:cmd');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf Demo Command');
    }

    public function handle()
    {
        $baseOpenapiIsLogin = config('base_openapi_is_login');
        $openMiddleware = [
            App\Middleware\OpenapiMiddleware::class
        ];
        if ($baseOpenapiIsLogin == 'true') {
            array_push($openMiddleware, App\Middleware\JWTAuthMiddleware::class);
        }
        var_dump($openMiddleware);exit;

        //var_dump(config("is_login"));exit;
    }
}
