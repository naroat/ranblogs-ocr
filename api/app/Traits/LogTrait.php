<?php


namespace App\Traits;


use Hyperf\Di\Annotation\Inject;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class LogTrait
{
    /**
     * 获取日志对象
     *
     * @param string $name
     * @return \Psr\Log\LoggerInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function get($name = 'hyperf')
    {
        return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name);
    }

    /**
     * 调用接口日志记录(db)
     *
     * @param $accessKey
     * @param $requestData
     * @param $errMessage
     */
    public static function apiErrDBLog($accessKey, $requestData, $errMessage)
    {
        $apiLogModle = new \App\Model\ApiLog();
        set_save_data($apiLogModle, [
            'access_key' => $accessKey,
            'classes' => '',
            'desc' => '',
            'request_data' => json_encode($requestData, JSON_UNESCAPED_UNICODE),
            'error' => $errMessage,
            'ip' => Util::getClientIp(),
        ]);
        $apiLogModle->save();
    }
}