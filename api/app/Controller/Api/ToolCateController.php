<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\ToolCateService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class ToolCateController extends AbstractController
{
    /**
     * @Inject()
     * @var ToolCateService
     */
    private $toolCateService;

    public function index()
    {
        try {
            $list = $this->toolCateService->getList();
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
