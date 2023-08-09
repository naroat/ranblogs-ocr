<?php
namespace App\Service;

use App\Model\LemonOrder;
use App\Model\MemberProduct;
use App\Model\Users;

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
        if (!$memberProduct) {
            throw new \Exception("会员产品不存在");
        }

        $order = LemonOrder::where('order_id', $orderId)->first();
        if (!$order) {
            throw new \Exception('订单异常');
        }

        $user = Users::where('status', 0)->find($order->user_id);
        if (!$user) {
            throw new \Exception('用户异常');
        }
        //发放会员
        $user->member_id = $memberProduct->member_id;
        //计算过期时间
        if (empty($user->member_expire_time)) {
            $member_expire_time = time() + ($memberProduct->day * 3600 * 24);
        } else {
            $member_expire_time = $user->member_expire_time + ($memberProduct->day * 3600 * 24);
        }

        $user->member_expire_time = $member_expire_time;
        $user->save();
        return true;
    }
}