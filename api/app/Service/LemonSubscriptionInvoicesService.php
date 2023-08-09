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
        if (empty($attributes) || empty($data['subscription_invoices_id'])) {
            throw new \Exception("参数错误");
        }

        //查询订阅是否存在
        $subscriptionInvoices = LemonSubscriptionInvoices::where('subscription_invoices_id', $data['subscription_invoices_id'])->first();
        if (!$subscriptionInvoices) {
            //新增
            $subscriptionInvoices = new LemonSubscriptionInvoices();
        }
        set_save_data($subscriptionInvoices, [
            'subscription_invoices_id' => $data['subscription_invoices_id'],
            'subscription_id' => $attributes['subscription_id'],
            'store_id' => $attributes['store_id'],
            'billing_reason' => $attributes['billing_reason'],
            'card_brand' => $attributes['card_brand'],
            'card_last_four' => $attributes['card_last_four'],
            'currency' => $attributes['currency'],
            'subtotal' => $attributes['subtotal'],
            'tax' => $attributes['tax'],
            'total' => $attributes['total'],
            'status' => $attributes['status'],
            'refunded' => $attributes['refunded'],
            'refunded_at' => $attributes['refunded_at'],
        ]);
        $subscriptionInvoices->save();
        return $subscriptionInvoices;
    }
}