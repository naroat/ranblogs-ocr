<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Users;
use App\Model\UserSecret;
use App\Service\UserSecretService;
use App\Service\UserService;
use App\Traits\OpenApi;
use App\Traits\OpenApiTrait;
use App\Traits\SecretKey;
use App\Traits\Util;
use http\Client\Curl\User;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * @Command
 */
#[Command]
class GenSecretKey extends HyperfCommand
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
     * @var UserSecretService
     */
    private $userSecretService;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('gen:secretkey');
    }

    public function configure()
    {
        parent::configure();
        $this->addArgument('uid', InputOption::VALUE_REQUIRED, '用户id', null);
        $this->setDescription('Hyperf Demo Command');
    }

    public function handle()
    {
        $uid = $this->input->getArgument('uid');
        if ($uid == null) {
            $this->error("请设置用户id");
            return false;
        }

        //检查用户是否存在
        $info = Users::where('id', $uid)->first();
        if (!$info) {
            $this->error("用户信息不存在");
            return false;
        }

        //生成secret key
        $secretInfo = $this->userSecretService->genSecretKey($uid);

        $this->line("生成成功： access_key: {$secretInfo['access_key']}; secret_key: {$secretInfo['secret_key']}; token: {$secretInfo['openapi_token']}");
    }
}
