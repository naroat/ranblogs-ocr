<?php

declare(strict_types=1);

namespace App\Command;

use App\Amqp\Producer\IntegralProducer;
use App\Event\SmsEvent;
use App\Exception\BusinessException;
use App\Exception\ServiceException;
use App\Model\IntegralProduct;
use App\Model\MemberProduct;
use App\Package\CompressImg\src\CompressImg;
use App\Package\Email\src\Email;
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

        exit;
        //判断购买什么类型的产品
        $integralProductModel = new IntegralProduct();
        $memberProductModel = new MemberProduct();
        $where = [];
        $where['platform'] = 1;
        $where['platform_store_id'] = 36267;
        $where['platform_product_id'] = 94881;
        $where['platform_variant_id'] = 103673;
        $integralProduct = $integralProductModel->where($where)->first();
        //$memberProduct = $memberProductModel->where($where)->first();
        var_dump($integralProduct);
        exit;
        try {
            $email = new Email();
            $email->send('taoran0796@163.com', 'code', $email->templateCode('123456'));
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }

        exit;
        //fo: qg(hong12); ty-nail(base);

        //7: 1050;
        //e/week: bz6000w; card: 400w; tuan: 500w; gj: 1300w; sum(8200)
        //3000
        var_dump(date('Y-m-d', time() + (3600 * 24 * 9)));
        exit;
        $lemonsqueezy = new Lemonsqueezy();
        print_r($lemonsqueezy->buildCheckoutsParams(1, '1', '1', ['price' => 1]));exit;
        $num = 19.9;
        var_dump(is_int($num));exit;
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
