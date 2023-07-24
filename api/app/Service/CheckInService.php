<?php


namespace App\Service;


use App\Amqp\Producer\IntegralProducer;
use App\Cache\RegisterCode;
use App\Constants\IntegralLogType;
use App\Constants\SmsTemplate;
use App\Model\IntegralLog;
use Hyperf\Di\Annotation\Inject;

class CheckInService
{
    /**
     * @Inject()
     * @var \Hyperf\Amqp\Producer
     */
    private $producer;

    public function checkIn($userId)
    {
        //签到的积分流水信息同时也是签到的信息
        if (!$this->isCheckIn($userId)) {
            throw new \Exception('请勿重复签到');
        }
        //签到发放积分
        $this->producer->produce(new IntegralProducer(['type' => IntegralLogType::CHECK_IN, 'user_id' => $userId]));
    }

    /**
     * 是否签到
     */
    public function isCheckIn($userId)
    {
        $time = time();
        $startTime = date('Y-m-d 00:00:00', $time);
        $endTime = date('Y-m-d 23:59:59', $time);
        $count = IntegralLog::where('user_id', $userId)->whereBetween('created_at', [$startTime, $endTime])->count();
        if ($count > 0) {
            //已经签到
            return false;
        }
        //未签到
        return true;
    }
}