<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 积分操作枚举类
 *
 * @Constants
 */
#[Constants]
class IntegralLogType extends AbstractConstants
{
    /**
     * @Message("调用接口")
     */
    const USE_INTERFACE = 0;

    /**
     * @Message("签到")
     */
    const CHECK_IN = 1;

    /**
     * @Message("邀请用户)
     */
    const INVITE = 2;

    /**
     * @Message("充值积分")
     */
    const RECHARGE = 3;

    /**
     * @Message("分享")
     */
    const SHARE = 4;
}
