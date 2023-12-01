<?php


namespace App\Package\ALAPI\src;


use App\Traits\Util;

class ALAPI
{
    const BASE_URL = "https://v2.alapi.cn/api";

    private $token;

    public function __construct() {
        $this->token = env('ALAPI_TOKEN');
    }

    public function ip($ip)
    {
        $uri = '/ip';
        $params = [];
        $params['token'] = $this->token;
        if (!empty($ip)) {
            $params['ip'] = $ip;
        }
        $list = Util::httpRequest(self::BASE_URL . $uri, 'post', $params, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);
        return $list;
    }
}