<?php
namespace App\Service;


use App\Amqp\Producer\MemberProducer;
use App\Model\IntegralProduct;
use App\Model\LemonOrder;
use App\Model\LemonOrderProduct;
use App\Model\LemonSubscription;
use App\Model\MemberProduct;
use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class LemonOrderService
{
    /**
     * 购买积分产品
     *
     * @param $param
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function buyIntegral($param)
    {
        $storesId = $param['store_id'];
        $variantId = $param['variant_id'];

        //验证产品
        $integralProduct = IntegralProduct::where('platform_store_id', $storesId)
            ->where('platform_variant_id', $variantId)
            ->where('status', 1)
            ->first();
        if (!$integralProduct) {
            throw new \Exception("产品未上架");
        }

        //创建结算单
        $data = $this->checkouts($param, $storesId, $variantId);
        return $data;
    }

    /**
     * 购买会员产品
     *
     * @param $param
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function buyMember($param)
    {
        $storesId = $param['store_id'];
        $variantId = $param['variant_id'];

        //验证产品
        $product = MemberProduct::where('platform_store_id', $storesId)
            ->where('platform_variant_id', $variantId)
            ->where('status', 1)
            ->first();
        if (!$product) {
            throw new \Exception("产品未上架");
        }

        //创建结算单
        $data = $this->checkouts($param, $storesId, $variantId);
        return $data;
    }

    /**
     * 创建结算单
     *
     * @param $param
     * @param $storesId
     * @param $variantId
     * @return bool|mixed|string
     * @throws \Exception
     */
    private function checkouts($param, $storesId, $variantId)
    {
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

    /**
     * 创建订单 - 基于lemonsqueezy
     *
     * @param $data
     * @param $attributes   lemonsqueezy订单数据
     * @throws \Exception
     */
    public function updateOrInsert($data, $attributes)
    {
        if (empty($attributes)) {
            throw new \Exception("参数错误");
        }

        if (!isset($data['type'])) {
            throw new \Exception("参数错误");
        }

        if ($attributes['status'] == 'paid') {
            $finishTime = date("Y-m-d H:i:s", time());
        }

        //查询订单是否存在
        $order = LemonOrder::where('order_id', $data['order_id'])->first();
        if (!$order) {
            //新增
            $order = new LemonOrder();
        }

        //order
        set_save_data($order, [
            'user_id' => $data['user_id'],
            'order_id' => $data['order_id'],
            'order_no' => $attributes['identifier'],
            'store_id' => $attributes['store_id'],
            'customer_id' => $attributes['customer_id'],
            'user_name' => $attributes['user_name'],
            'user_email' => $attributes['user_email'],
            'currency' => $attributes['currency'],
            'currency_rate' => $attributes['currency_rate'],
            'subtotal' => $attributes['subtotal'],
            'tax' => $attributes['tax'],
            'total' => $attributes['total'],
            'status' => $attributes['status'],
            'refunded' => $attributes['refunded'],
            'refunded_at' => $attributes['refunded_at'],
            'finish_time' => $finishTime ?? '',
            'type' => $data['type'],
        ]);
        $order->save();

        //order product
        $orderProduct = LemonOrderProduct::where('child_order_id', $attributes['first_order_item']['order_id'])->first();
        if (!$orderProduct) {
            //新增
            $orderProduct = new LemonOrderProduct();
        }
        set_save_data($orderProduct, [
            'order_id' => $data['order_id'],
            'child_order_id' => $attributes['first_order_item']['order_id'],
            'product_id' => $attributes['first_order_item']['product_id'],
            'product_name' => $attributes['first_order_item']['product_name'],
            'variant_id' => $attributes['first_order_item']['variant_id'],
            'variant_name' => $attributes['first_order_item']['variant_name'],
            'price' => $attributes['first_order_item']['price'],
        ]);
        $orderProduct->save();
    }
}