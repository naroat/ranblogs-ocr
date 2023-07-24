<?php

declare(strict_types=1);

namespace App\Command;

use App\Amqp\Producer\IntegralProducer;
use App\Event\SmsEvent;
use App\Exception\BusinessException;
use App\Exception\ServiceException;
use App\Model\Users;
use App\Package\CompressImg\src\CompressImg;
use App\Package\Lemonsqueezy\src\Lemonsqueezy;
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
use Symfony\Component\Console\Input\InputOption;
use function Taoran\HyperfPackage\Helpers\Password\create_password;
use function Taoran\HyperfPackage\Helpers\set_save_data;

/**
 * @Command
 */
#[Command]
class ResetPassword extends HyperfCommand
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

        parent::__construct('reset:password');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('重置密码');
        $this->addArgument('uid', InputOption::VALUE_REQUIRED, '用户id', null);
        $this->addArgument('password', InputOption::VALUE_REQUIRED, '密码', null);
    }

    public function handle()
    {
        $uid = $this->input->getArgument('uid');
        if ($uid == null) {
            $this->error("请设置用户id");
            return false;
        }

        $password = $this->input->getArgument('password');
        if ($uid == null) {
            $this->error("请设置用户密码");
            return false;
        }

        //检查是否已经注册
        $users = Users::where('id', $uid)->first();
        if (!$users) {
            $this->error("用户不已存在");
            return false;
        }
        //生成密码
        $password = create_password($password, $salt);
        set_save_data($users, [
            'password' => $password,
            'salt' => $salt,
        ]);
        $users->save();

        $this->info("操作成功");
    }
}
