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
namespace App\Exception\Handler;

use App\Exception\ServiceException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Taoran\HyperfPackage\Core\Response;
use Throwable;

class ServiceExceptionHandler extends ExceptionHandler
{

    /**
     * @Inject()
     * @var Response
     */
    private $responseCore;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        //组织异常冒泡
        $this->stopPropagation();
        //格式化输出
        $result = $this->responseCore->error($throwable->getMessage(), $throwable->getCode());
        return $response->withStatus($throwable->getCode())
            ->withAddedHeader('content-type', 'application/json')
            ->withBody(new SwooleStream(json_encode($result)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ServiceException;
    }
}
