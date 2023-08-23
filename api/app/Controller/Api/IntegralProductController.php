<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\IntegralProductService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class IntegralProductController extends AbstractController
{

    /**
     * @Inject()
     * @var IntegralProductService
     */
    private $integralProductService;

    public function index()
    {
        try {
            //$params['user_id'] = $this->request->getAttribute('user_id');
            $data = $this->integralProductService->getList();
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->integralProductService->getOne($id);
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
