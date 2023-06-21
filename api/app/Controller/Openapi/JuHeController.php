<?php

declare(strict_types=1);

namespace App\Controller\Openapi;

use App\Package\JuHe\src\JuHeApi;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class JuHeController extends AbstractController
{
    /**
     * @Inject()
     * @var JuHeApi
     */
    private $JuHeService;

    public function toutiaoIndex(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['type', 'guonei'],
            ['page', 1],
            ['page_size', 30],
            ['is_filter', 0],
        ], $this->request);

        try {
            $list = $this->JuHeService->toutiaoIndex($params['type'], $params['page'], $params['page_size'], $params['is_filter']);

            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function toutiaoContent(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['uniquekey', ''],
        ], $this->request);

        try {
            $list = $this->JuHeService->toutiaoContent($params['uniquekey']);

            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
