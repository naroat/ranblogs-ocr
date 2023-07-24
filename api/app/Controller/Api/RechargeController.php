<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use App\Service\RechargeService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class RechargeController extends AbstractController
{
    /**
     * @Inject()
     * @var RechargeService
     */
    public $rechargeService;

    public function recharge()
    {
        $param = $this->verify->requestParams([
            ['store_id', ''],
            ['variant_id', ''],
            ['amount', 0]
        ], $this->request);

        try {
            $this->verify->check($param, [
                'store_id' => 'required',
                'variant_id' => 'required',
            ], []);

            //必须是整数
            if (!is_int($param['amount'])) {
                throw new \Exception('参数错误');
            }

            //user_id
            $param['user_id'] = $this->request->getAttribute('user_id');
            $data = $this->rechargeService->recharge($param);
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
