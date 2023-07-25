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
     * 构建结算单参数
     *
     * @param int $userId   用户id
     * @param string $storesId  店铺id
     * @param string $variantId 变体id
     * @param array $option 可选参数
     * @return array
     */
    public function buildCheckoutsParams(int $userId, string $storesId, string $variantId, array $option)
    {
        //构建参数
        $buildParam = [
            'data' => [
                'type' => 'checkouts',
                'attributes' => [
                    'checkout_options' => [
                        'embed' => $option['embed'] ?? false
                    ],
                    'checkout_data' => [
                        'custom' => [
                            'user_id' => (string)$userId,
                        ]
                    ]
                ],
                'relationships' => [
                    'store' => [
                        'data' => [
                            'type' => 'stores',
                            'id' => (string)$storesId
                        ]
                    ],
                    'variant' => [
                        'data' => [
                            'type' => 'variants',
                            'id' => (string)$variantId,
                        ]
                    ]
                ]
            ]
        ];

        if (isset($option['price']) && $option['price'] > 0) {
            //自定义价格，如果是订阅的情况，那么后续订阅都会以这个价格支付
            $buildParam['data']['attributes']['custom_price'] = $option['price'];
        }
        return $buildParam;
    }

    /**
     * 创建结算单
     * 参数文档：https://docs.lemonsqueezy.com/api/checkouts#create-a-checkout
     *
     * @param string $storesId 店铺id
     * @param string $variantId 变体id
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function checkouts($data)
    {
        $uri = "checkouts";;
        $result = Util::httpRequest(self::BASE_URL . $uri, 'post', json_encode($data), [
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