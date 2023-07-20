<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class PayController extends AbstractController
{
    /**
     * @Inject()
     * @var UserService
     */
    private $userService;


    public function checkouts()
    {
        try {
            $lm = new Lemonsqueezy();
            $lm->checkouts();
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
