<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
#[Constants]
class ResponseCode extends AbstractConstants
{
    /**
     * @Message("成功")
     */
    const SUCCESS = 200;

    /**
     * 认证失败
     * @Message("请登录");
     */
    const UN_AUTHORIZED = 401;

    /**
     * 请求频繁
     * @Message("请求频繁");
     */
    const  MAX_REQUEST = 429;

    /**
     * 无权限
     * @Message("无权限");
     */
    const  UN_PERMISSION = 1001;

    /**
     * @Message('逻辑异常')
     */
    const LOGIC_ERR = 1002;
}
