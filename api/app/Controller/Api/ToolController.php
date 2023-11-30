<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\ToolService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class ToolController extends AbstractController
{
    /**
     * @Inject()
     * @var ToolService
     */
    private $toolService;

    public function index()
    {
        $params = $this->verify->requestParams([
            ['title', ''],
            ['cateId', ''],
        ], $this->request);
        try {
            $this->verify->check($params, [
                'cateId' => 'integer'
            ], []);
            $list = $this->toolService->getList($params);
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
