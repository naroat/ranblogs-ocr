<?php
namespace App\Service;

use App\Constants\IntegralLogType;
use App\Model\IntegralLog;
use App\Model\Users;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class IntegralLogService
{
    /**
     * 获取列表
     *
     * @param $params
     * @return \Hyperf\Contract\LengthAwarePaginatorInterface
     */
    public function getList($params)
    {
        //只展示最近3个月数据
        $startTime = '';
        $endTime = '';
        $list = IntegralLog::where('user_id', $params['user_id'])
            ->whereBetween('created_at', [$startTime, $endTime])
            ->where('io', $params['io'])
            ->paginate(20);
        $list->each(function ($item) {
            $item->io_text = IntegralLog::$ioTran[$item->io];
        });
        return $list;
    }

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