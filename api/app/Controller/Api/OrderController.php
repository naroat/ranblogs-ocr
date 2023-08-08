<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use App\Service\IntegralOrderService;
use App\Service\LemonOrderService;
use App\Service\MemberOrderService;
use App\Service\OrderService;
use App\Service\RechargeService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class OrderController extends AbstractController
{
    /**
     * @Inject()
     * @var LemonOrderService
     */
    public $lemonOrderService;

    public function buyIntegral()
    {
        $param = $this->verify->requestParams([
            ['store_id', ''],
            ['variant_id', ''],
        ], $this->request);

        try {
            $this->verify->check($param, [
                'store_id' => 'required',
                'variant_id' => 'required',
            ], []);

            //user_id
            $param['user_id'] = $this->request->getAttribute('user_id');
            $data = $this->lemonOrderService->buyIntegral($param);
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function buyMember()
    {
        $param = $this->verify->requestParams([
            ['store_id', ''],
            ['variant_id', ''],
        ], $this->request);

        try {
            $this->verify->check($param, [
                'store_id' => 'required',
                'variant_id' => 'required',
            ], []);

            //user_id
            $param['user_id'] = $this->request->getAttribute('user_id');
            $data = $this->lemonOrderService->buyMember($param);
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
