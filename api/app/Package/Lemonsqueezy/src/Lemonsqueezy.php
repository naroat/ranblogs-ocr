<?php


namespace App\Package\Lemonsqueezy\src;


use App\Traits\Util;

class Lemonsqueezy
{
    const BASE_URL = 'https://api.lemonsqueezy.com/v1/';

    /** @var api key  */
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('LEMON_SQUEEZY_API_KEY');
    }

    /**
     * 获取头设置
     *
     * @return array
     */
    private function getHeader()
    {
        return [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $this->apiKey
        ];
    }

    /**
     * try error
     *
     * @param $result
     * @throws \Exception
     */
    private function tryError($result)
    {
        if (!empty($result['errors'])) {
            throw new \Exception(($result['errors'][0]['title'] ?? '') . ': ' . ($result['errors'][0]['detail'] ?? '处理异常'));
        }
    }

    /**
     * 创建结算单
     *
     * @param string $storesId 店铺id
     * @param string $variantId 变体id
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function checkouts(string $storesId, string $variantId)
    {
        $uri = "checkouts";
        $result = Util::httpRequest(self::BASE_URL . $uri, 'post', json_encode([
            'data' => [
                'type' => $uri,
                'attributes' => [
                    'checkout_options' => [
                        'embed' => 'true'
                    ]
                ],
                'relationships' => [
                    'store' => [
                        'data' => [
                            'type' => 'stores',
                            'id' => $storesId
                        ]
                    ],
                    'variant' => [
                        'data' => [
                            'type' => 'variants',
                            'id' => $variantId,
                        ]
                    ]
                ]
            ]
        ]), [
            'header' => $this->getHeader()
        ]);

        $result = json_decode($result, true);

        //try error
        $this->tryError($result);
        return $result;
    }

    /**
     * 获取指定产品
     *
     * @param $productId 产品id
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function products($productId)
    {
        $uri = "products/{$productId}";
        $result = Util::httpRequest(self::BASE_URL . $uri, 'get', [], [
            'header' => $this->getHeader()
        ]);

        $result = json_decode($result, true);

        //try error
        $this->tryError($result);
        return $result;
    }

    /**
     * 通过产品id获取变体
     *
     * @param $productId
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function variantsByProductId($productId)
    {
        $uri = "variants?filter[product_id]={$productId}";
        $result = Util::httpRequest(self::BASE_URL . $uri, 'get', [], [
            'header' => $this->getHeader()
        ]);

        $result = json_decode($result, true);

        //try error
        $this->tryError($result);
        return $result;
    }
}