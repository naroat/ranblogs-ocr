<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\ResponseCode;
use App\Model\UserSecret;
use App\Traits\OpenApiTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Hyperf\Redis\Redis;
use Phper666\JwtAuth\Jwt;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OpenapiMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var HttpResponse
     */
    protected $response;

    /**
     * @Inject()
     * @var Jwt
     */
    protected $jwt;

    /**
     * @Inject()
     * @var Redis
     */
    private $redis;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $token = $request->getHeader('OpenapiToken')[0] ?? '';
            $accessKey = $request->getHeader('AccessKey')[0] ?? '';
            if (strlen($token) == 0 || strlen($accessKey) == 0) {
                throw new \Exception('拒绝访问！ERR: 1004');
            }

            $userToken = $this->redis->get('ACCESS_KEY:' . $accessKey);
            if (!$userToken) {
                //数据库获取
                $userSecret = UserSecret::where('access_key', $accessKey)->first();
                if ($userSecret) {
                    $userToken = $userSecret->token;
                } else {
                    throw new \Exception('拒绝访问！ERR: 1003');
                }
            }

            if (strlen($userToken) == 0) {
                throw new \Exception('拒绝访问！ERR: 1002');
            }

            if ($userToken != $token) {
                throw new \Exception('拒绝访问！ERR: 1001');
            }

            $request = $request->withAttribute('AccessKey', $accessKey);
            \Hyperf\Context\Context::set(ServerRequestInterface::class, $request);
            return $handler->handle($request);
        } catch (\Exception $e) {
            return $this->response->json(['code' => ResponseCode::UN_PERMISSION, 'message' => $e->getMessage(), 'data' => []]);
        }
    }
}