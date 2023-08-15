<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\ListsService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class ListsController extends AbstractController
{
    /**
     * @Inject()
     * @var ListsService
     */
    private $listsService;

    public function index()
    {
        $params = $this->verify->requestParams([
            ['date', ''],
        ], $this->request);
        try {
            $this->verify->check($params, [
                'date' => 'date',
            ], []);
            $params['user_id'] = $this->request->getAttribute('user_id');
            $list = $this->listsService->getList($params);
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->listsService->getOne($id, $params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function store()
    {
        try {
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->listsService->add($params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function update($id)
    {
        $params = $this->verify->requestParams([
            ['content', ''],
        ], $this->request);

        try {
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->listsService->update($id, $params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->listsService->delete($id, $params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
