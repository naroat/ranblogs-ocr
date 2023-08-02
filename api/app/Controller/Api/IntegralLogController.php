<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Constants\ResponseCode;
use App\Service\IntegralLogService;
use App\Service\RechargeService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class IntegralLogController extends AbstractController
{
    /**
     * @Inject()
     * @var IntegralLogService
     */
    public $integralLogService;

    public function index()
    {
        $params = $this->verify->requestParams([
            ['io', 1]
        ], $this->request);

        try {
            //1收入，2支出
            $this->verify->check($params, [
                'io' => 'required|in:1,2',
            ], []);
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->integralLogService->getList($params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage(), ResponseCode::LOGIC_ERR);
        }
    }
}
