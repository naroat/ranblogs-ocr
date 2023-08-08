<?php


namespace App\Service;


use App\Cache\RegisterCode;
use App\Constants\SmsTemplate;
use App\Model\MemberProduct;

class MemberProductService
{
    public function getList()
    {
        $list = MemberProduct::where('status', '1')
            ->where('platform', 1)
            ->paginate();

        $list->each(function ($item) {
            $item->price = number_format($item->price / 100, 2);
            $item->old_price = number_format($item->old_price / 100, 2);
        });
        return $list;
    }

    public function getOne($id)
    {
        $info = MemberProduct::where('status', '1')->where('platform', 1)->find($id);
        $info->price = number_format($info->price / 100, 2);
        $info->old_price = number_format($info->old_price / 100, 2);
        return $info;
    }
}