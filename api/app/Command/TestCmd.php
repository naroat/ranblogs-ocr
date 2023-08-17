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
        //test02@163.com
        //21218cca77804d2ba1922c33e0151105
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI2NGRkYzQ3OTQ5MGQ0IiwiaWF0IjoxNjkyMjU1MzUzLCJuYmYiOjE2OTIyNTUzNTMsImV4cCI6MTY5Mjg2MDE1MywidXNlcl9pZCI6NTQyODksImVtYWlsIjoidGVzdDAyQDE2My5jb20ifQ.LWQQrwoJkZlSk8hj1uNu9xQIkqbDBTAaIjwcdNtVrKs

        //testing: test001@163.com
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI2NGRkYzg2ZDUyODExIiwiaWF0IjoxNjkyMjU2MzY1LCJuYmYiOjE2OTIyNTYzNjUsImV4cCI6MTY5Mjg2MTE2NSwidXNlcl9pZCI6NTQyOTUsImVtYWlsIjoidGVzdDAwMUAxNjMuY29tIn0.clmHevCjwBOFKCbGUvSng5CSf9ttohHJAPYksKgsfMQ
        var_dump(md5('111111'));
        exit;
        $filetype = mime_content_type('/disk2/www/ranblogs-ocr/api/storage/tmp/2023-08-11/16917385276853.wav');
//        $filetype = explode('/', $filetype);
        var_dump($filetype);
        exit;
        $content = '{
            "results": {
                "channels": [{
                    "alternatives": [{
                        "transcript": "and jessica christina we are so proud you you\'re gonna do great today we\'ll be waiting for you here in a couple hours when you get home i\'m gonna hand you over to stephanie now have a great great eva drew thank you so much and our pleasure working with you this morning and i\'m working on getting that easy hatch open and i can report it\'s opened and s thank drew thank you so much on your dc take your power switches to bat stagger switch throws and expect a warning tone final steps where they begin the space copy check display switch functional tracy how important is this the the guiding it the isn\'t like seems like a lot to remember on your own absolutely take power e b one e two two switches to us o f yeah christina jessica have enough work with their hands and feet and their brain outside that it really helps to have someone like stephanie you power both off connector your from your dc and s the in the pouch kinda the interrupt so not only does stephanie thirty eight am central time a little ahead of schedule about twelve minutes but that gets us started on today\'s historic space walk morgan there wishing the crew luck the made pouch and dc cover closed copy e two",
                        "confidence": 0.97326756
                    }]
                }]
            }
        }';
        $jsonContent = json_decode($content, true);
        var_dump($jsonContent['results']['channels'][0]['alternatives'][0]['transcript']);
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
