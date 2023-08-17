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
        $list = IntegralLog::where('user_id', $params['user_id']);
        if (!empty($params['start_time']) && !empty($params['end_time'])) {
            $list = $list->whereBetween('created_at', [$params['start_time'], $params['end_time']]);
        }
        $list = $list->where('io', $params['io'])->paginate($params['limit']);
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