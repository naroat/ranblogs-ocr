<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Traits\LogTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Logger\Logger;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class PayCallbackController extends AbstractController
{

    public function callback()
    {
        $log = LogTrait::get();
        $all = $this->request->all();

        $eventName = $all['meta']['event_name'] ?? '';
        if (!in_array($eventName, ['order_created', 'subscription_payment_success'])) {
            //数据异常或者不属于需要处理的事件
            return false;
        }

        switch ($eventName) {
            case 'order_created':
                break;
            case 'subscription_payment_success':
                break;
        }
    }
}
