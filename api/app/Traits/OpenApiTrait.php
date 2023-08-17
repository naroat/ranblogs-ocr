<?php


namespace App\Traits;


use function Taoran\HyperfPackage\Helpers\get_msectime;

class OpenApiTrait
{
    /**
     * 生成secretKey
     *
     * @param $userId
     * @return array
     */
    public static function genKey($userId)
    {
        $defaultStr = get_msectime() . rand(1000, 9999);
        return [
            'access_key' => substr(md5($userId . rand(1000, 9999)), 8, 16),
            'secret_key' => sha1($userId . $defaultStr),
        ];
    }

    /**
     * 生成token
     *
     * @param $accessKey
     * @param $secretKey
     * @return string
     */
    public static function genToken($accessKey, $secretKey)
    {
        return base64_encode(md5($accessKey . env('APP_NAME') . $secretKey . time()));
    }
}