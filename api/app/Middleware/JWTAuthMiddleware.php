<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\ResponseCode;
use App\Model\Users;
use App\Model\UserSecret;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Phper666\JwtAuth\Jwt;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JWTAuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var Jwt
     */
    private $jwt;

    /**
     * @Inject
     * @var HttpResponse
     */
    protected $response;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            if (!$this->jwt->checkToken()) {
                throw new \Exception("请登录！ERR: 10010");
            }
            $data = $this->jwt->getParserData();
            $users = Users::find($data['user_id']);
            if (!$users) {
                throw new \Exception("请登录！ERR: 10011");
            }
            if ($users->status == 1) {
                throw new \Exception('账号被禁用！');
            }
            //$request = $request->withAttribute('phone', $data['phone']);
            $request = $request->withAttribute('email', $data['email']);
            $request = $request->withAttribute('user_id', $data['user_id']);
            \Hyperf\Context\Context::set(ServerRequestInterface::class, $request);
            return $handler->handle($request);
        } catch (\Exception $e) {
            return $this->response->json(['code' => ResponseCode::UN_AUTHORIZED, 'message' => $e->getMessage(), 'data' => []]);
        }
    }
}