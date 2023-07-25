<?php
namespace App\Service;


use App\Model\IntegralProduct;
use App\Package\Lemonsqueezy\src\Lemonsqueezy;

class IntegralOrderService
{
    public function order($param)
    {
        $storesId = $param['store_id'];
        $variantId = $param['variant_id'];

        //金额转换成分
        //$price = $param['amount'] * 100;

        //验证产品
        $integralProduct = IntegralProduct::where('store_id', $storesId)
            ->where('variant_id', $variantId)
            ->where('status', 1)
            ->first();
        if (!$integralProduct) {
            throw new \Exception("产品未上架");
        }

        $lemonsqueezy = new Lemonsqueezy();
        //构建参数
        $buildParam = $lemonsqueezy->buildCheckoutsParams($param['user_id'], $storesId, $variantId, [
            'embed' => $param['embed'] ?? false,
            //'price' => $price
        ]);
        //创建结算单
        $data = $lemonsqueezy->checkouts($buildParam);
        return $data;
    }
}