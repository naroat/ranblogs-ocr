<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Exception;

use _PHPStan_76800bfb5\React\Http\Message\Response;
use App\Constants\ErrorCode;
use App\Constants\ResponseCode;
use Hyperf\Server\Exception\ServerException;
use OSS\Http\ResponseCore;
use Throwable;

class ServiceException extends ServerException
{
    public function __construct(int $code = 0, string $message = null, Throwable $previous = null)
    {
        if (is_null($message)) {
            $message = ResponseCode::getMessage($code);
        }

        parent::__construct($message, $code, $previous);
    }
}
