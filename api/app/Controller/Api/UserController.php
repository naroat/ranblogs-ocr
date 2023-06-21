<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Inject()
     * @var UserService
     */
    private $userService;


    public function show()
    {
        try {
            $userId = $this->request->getAttribute('user_id');
            $data = $this->userService->getInfo($userId);
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
