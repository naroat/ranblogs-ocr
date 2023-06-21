<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\CheckInService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class CheckInController extends AbstractController
{
    /**
     * @Inject()
     * @var CheckInService
     */
    private $checkInService;

    /**
     * 签到
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function checkIn(RequestInterface $request, ResponseInterface $response)
    {
        try {
            $userId = $this->request->getAttribute('user_id');
            $this->checkInService->checkIn($userId);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
