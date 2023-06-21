<?php
namespace App\Service;

use App\Constants\IntegralLogType;
use App\Model\IntegralLog;
use App\Model\Users;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class IntegralLogService
{
    /**
     * 记录积分流水
     *
     * @param $userId
     * @param $io
     * @param $type
     * @param $beforeIntegral
     * @param $changeIntegral
     * @param $currentIntegral
     * @param $remark
     */
    public function record($userId, $io, $type, $beforeIntegral, $changeIntegral, $currentIntegral, $remark)
    {
        $integralLog = new IntegralLog();
        $saveData = [
            'user_id' => $userId,
            'io' => $io,
            'type' => $type,
            'before_integral' => $beforeIntegral,
            'change_integral' => $changeIntegral,
            'current_integral' => $currentIntegral,
            'remarks' => $remark,
        ];
        set_save_data($integralLog, $saveData);
        $integralLog->save();
    }
}