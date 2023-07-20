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
        var_dump($all);exit;
    }
}
