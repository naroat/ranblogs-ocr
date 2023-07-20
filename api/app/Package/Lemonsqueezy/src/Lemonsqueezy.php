<?php


namespace App\Package\Lemonsqueezy\src;


use App\Traits\Util;

class Lemonsqueezy
{
    const BASE_URL = 'https://api.lemonsqueezy.com/v1/';

    /**
     * 创建结算单
     */
    public function checkouts()
    {
        $uri = "checkouts";
        $apiKey = env('LEMON_SQUEEZY_API_KEY');
        $result = Util::httpRequest(self::BASE_URL . $uri, 'post', [
            'custom_price' => '100' //美分
            //'name' => 'test',
            //'description' => 'test desc',
//            'media' => '',
            //'redirect_url' => $pageSize,
            //'receipt_button_text' => $pageSize,
            //'receipt_link_url' => $pageSize,
            //'receipt_thank_you_note' => $isFilter,
//            'enabled_variants' => $key,
        ], [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $apiKey
        ]);
        var_dump($result);exit;
    }
}