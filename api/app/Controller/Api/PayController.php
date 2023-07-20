<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use Taoran\HyperfPackage\Core\AbstractController;

class PayController extends AbstractController
{

    public function checkouts()
    {
        $param = $this->verify->requestParams([
            'store_id' => '',
            'variant_id' => ''
        ], $this->request);

        try {
            $this->verify->check($param, [
                'store_id' => 'required',
                'variant_id' => 'required',
            ]);

            $storesId = (string)$param['store_id'];
            $variantId = (string)$param['variant_id'];
            $lm = new Lemonsqueezy();
            $data = $lm->checkouts($storesId, $variantId);
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
