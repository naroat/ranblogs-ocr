<?php

declare(strict_types=1);

namespace App\Controller\Openapi;

use App\Package\ALAPI\src\ALAPI;
use App\Traits\NetworkTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class ALAPIController extends AbstractController
{
    /**
     * @Inject()
     * @var ALAPI
     */
    private $ALAPIApi;

    public function ip(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['ip', ''],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'ip' => 'ip'
            ], [
                'ip.ip' => "ip格式错误"
            ]);
            if (empty($params['ip'])) {
                $params['ip'] = NetworkTrait::getClientIp();
            }
            $data = $this->ALAPIApi->ip($params['ip']);
            if (isset($data['code']) && $data['code'] != 200) {
                throw new Exception('请求失败');
            }
            //请求成功
            $detailData = json_decode($data, true);
            return $this->responseCore->success($detailData['data']);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
