<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Amqp\Producer\IntegralProducer;
use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use App\Service\CallbackService;
use App\Service\PayCallbackService;
use App\Traits\LogTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Logger\Logger;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class CallbackController extends AbstractController
{

    /**
     * @Inject()
     * @var CallbackService
     */
    private $callbackService;


    /**
     * lemonsqueezy 支付和订阅回调
     *
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function payCallback()
    {
        $all = $this->request->all();

        $log = LogTrait::get('paycallback');
        $log->info('paycallback::' . json_encode($all));

        $payload   = file_get_contents('php://input');

        $lemonsqueezy = new Lemonsqueezy();
        $signature = $this->request->header('X-Signature');
        if (!$lemonsqueezy->signatureCheck($payload, $signature)) {
            //签名错误
            $log->error('paycallback::签名错误');
            return false;
        }

        try {
            $this->callbackService->payCallback($all);
        } catch (\Exception $e) {
            $log->error($e->getMessage());
            return false;
        }
    }
}
