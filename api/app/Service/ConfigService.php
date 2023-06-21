<?php
namespace App\Service;

use App\Model\Config;
use App\Model\Users;

class ConfigService
{
    /**
     * 根据code获取配置
     *
     * @param $code
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public function getConfigByCode($code)
    {
        $config = Config::where('code', $code)->first();
        if (!$config) {
            $config = null;
        }
        return $config;
    }
}