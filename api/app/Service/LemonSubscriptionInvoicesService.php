<?php
namespace App\Service;

use App\Model\LemonSubscription;
use App\Model\LemonSubscriptionInvoices;
use App\Model\Order;
use App\Model\OrderProduct;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class LemonSubscriptionInvoicesService
{
    /**
     * 更新或新增
     *
     * @param $data
     * @param $attributes
     * @return LemonSubscriptionInvoices|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     * @throws \Exception
     */
    public function updateOrInsert($data, $attributes)
    {
        if (empty($attributes) || empty($data['subscription_id'])) {
            throw new \Exception("参数错误");
        }

        //查询订阅是否存在
        $subscriptionInvoices = LemonSubscriptionInvoices::where('subscription_invoices_id', $data['subscription_invoices_id'])->first();
        if (!$subscriptionInvoices) {
            //新增
            $subscriptionInvoices = new LemonSubscriptionInvoices();
        }
        set_save_data($subscriptionInvoices, [
            'subscription_id' => $data['subscription_id'],
            'order_id' => $attributes['order_id'],
            'order_item_id' => $attributes['order_item_id'],
            'customer_id' => $attributes['customer_id'],
            'store_id' => $attributes['store_id'],
            'product_id' => $attributes['product_id'],
            'product_name' => $attributes['product_name'],
            'variant_id' => $attributes['variant_id'],
            'variant_name' => $attributes['variant_name'],
            'user_name' => $attributes['user_name'],
            'user_email' => $attributes['user_email'],
            'card_brand' => $attributes['card_brand'],
            'card_last_four' => $attributes['card_last_four'],
            'status' => $attributes['status'],
            'billing_anchor' => $attributes['billing_anchor'],
        ]);
        $subscriptionInvoices->save();
        return $subscriptionInvoices;
    }
}