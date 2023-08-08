<?php
namespace App\Service;


use App\Amqp\Producer\MemberProducer;
use App\Model\IntegralProduct;
use App\Model\LemonOrder;
use App\Model\LemonOrderProduct;
use App\Model\LemonSubscription;
use App\Model\MemberProduct;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\Users;
use App\Package\Contract\OrderInterface;
use App\Package\Lemonsqueezy\src\Lemonsqueezy;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class MemberService
{
    /**
     * 会员处理
     */
    public function handleMember($orderId, $storeId, $productId, $variantId)
    {
        $memberProduct = MemberProduct::where('platform', 1)
            ->where('platform_store_id', $storeId)
            ->where('platform_product_id', $productId)
            ->where('platform_variant_id', $variantId)
            ->first();

        $order = LemonOrder::where('order_id', $orderId)->first();
        if ($order) {
            throw new \Exception('订单异常');
        }

        $user = Users::where('status', 0)->find($order->user_id);
        if ($userId) {
            throw new \Exception('用户异常');
        }
        //发放会员
        $user->member_id = $memberProduct->member_id;
        //计算过期时间
        if (empty($user->member_expire_time)) {
            $member_expire_time = date('Y-m-d H:i:s', time() + ($memberProduct->day * 3600));
        } else {
            //
            $member_expire_time = date('Y-m-d H:i:s', strtotime($user->member_expire_time) + ($memberProduct->day * 3600));
        }
        $user->member_expire_time = $member_expire_time;
        $user->save();
        return true;
    }
}