<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 正则
 * @Constants
 */
#[Constants]
class REG extends AbstractConstants
{
    /**
     * reg phone
     */
    const PHONE = '/^1[3456789][0-9]{9}$/';

    /**
     * reg emial
     */
    const EMAIL = '/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/';

    /**
     * 身份证15位
     */
    const IDCARD15 = '/^([1-6][1-9]|50)\d{4}\d{2}((0[1-9])|10|11|12)(([0-2][1-9])|10|20|30|31)\d{3}$/';

    /**
     * 身份证18位
     */
    const IDCARD18 = '/^([1-6][1-9]|50)\d{4}(18|19|20)\d{2}((0[1-9])|10|11|12)(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/';
}
