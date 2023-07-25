<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Amqp\Producer\IntegralProducer;
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

    public function payCallback()
    {
        $log = LogTrait::get('paycallback');
        $all = $this->request->all();
        $log->info('paycallback::' . json_encode($all));

        try {
            $this->callbackService->payCallback($all);
        } catch (\Exception $e) {
            $log->error($e->getMessage());
            return false;
        }
    }
}
