<?php
namespace App\Service;


use App\Package\Lemonsqueezy\src\Lemonsqueezy;

class RechargeService
{
    public function recharge($param)
    {
        $storesId = (string)$param['store_id'];
        $variantId = (string)$param['variant_id'];

        //金额转换成分
        $price = $param['amount'] * 100;

        $lemonsqueezy = new Lemonsqueezy();
        //构建参数
        $buildParam = $lemonsqueezy->buildCheckoutsParams($param['user_id'], $storesId, $variantId, [
            'embed' => $param['embed'] ?? false,
            'price' => $price
        ]);
        //创建结算单
        $data = $lemonsqueezy->checkouts($buildParam);
        return $data;
    }
}