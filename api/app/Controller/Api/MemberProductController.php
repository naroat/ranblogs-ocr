<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\DownloadService;
use App\Service\IntegralProductService;
use App\Service\MemberProductService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class MemberProductController extends AbstractController
{

    /**
     * @Inject()
     * @var MemberProductService
     */
    private $memberProductService;

    public function index()
    {
        try {
            $data = $this->memberProductService->getList();
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->memberProductService->getOne($id);
            return $this->responseCore->success($data);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
