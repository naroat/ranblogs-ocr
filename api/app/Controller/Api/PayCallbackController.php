<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\PayCallbackService;
use App\Traits\LogTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Logger\Logger;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class PayCallbackController extends AbstractController
{

    /**
     * @Inject()
     * @var PayCallbackService
     */
    private $payCallbackService;

    public function callback()
    {
        $log = LogTrait::get('paycallback');
        $all = $this->request->all();
        $log->info('paycallback::' . json_encode($all));
        exit;
        try {
            $this->payCallbackService->callback($all);
        } catch (\Exception $e) {
            $log->error($e->getMessage());
            return false;
        }
    }

    public function rechargeSuccess()
    {
        //

    }
}
