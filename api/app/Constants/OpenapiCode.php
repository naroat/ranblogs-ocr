<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
#[Constants]
class OpenapiCode extends AbstractConstants
{
    /**
     * @Message("OCR(标准)")
     */
    const BAIDU_OCR_V1_GENERAL_BASIC = "BaiduController@ocrGeneralBasic";

    /**
     * @Message("音视频提取文本")
     */
    const OPENAI_AUDIO_TRANSCRIPTIONS = "OpenaiController@audioTranscriptions";
}
