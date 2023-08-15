<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\DownloadService;
use Hyperf\Di\Annotation\Inject;
use Taoran\HyperfPackage\Core\AbstractController;

class DownloadController extends AbstractController
{

    /**
     * @Inject()
     * @var DownloadService
     */
    private $downloadService;

    public function index()
    {
        $params = $this->verify->requestParams([
            ['link', ''],
            ['desc', ''],
            ['status', ''],
        ], $this->request);
        try {
            $this->verify->check($params, [
                'link' => 'between:0,255',
                'desc' => 'between:0,255',
                'status' => 'in:0,1,2,3,4',
            ], []);
            $params['user_id'] = $this->request->getAttribute('user_id');
            $list = $this->downloadService->getList($params);
            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->downloadService->getOne($id, $params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function store()
    {
        $params = $this->verify->requestParams([
            ['link', ''],
            ['desc', ''],
            ['re_download', 0],    //是否重复下载, 1继续重复下载
        ], $this->request);

        try {
            $this->verify->check($params, [
                'link' => 'required|between:1,255',
                'desc' => 'between:0,255',
                're_download' => 'in:0,1',
            ], []);
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->downloadService->add($params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function update($id)
    {
        $params = $this->verify->requestParams([
            ['desc', ''],
            ['status', ''], //操作： 0排队；4暂停
        ], $this->request);

        try {
            $this->verify->check($params, [
                'desc' => 'between:0,255',
                'handle' => 'in:0,4',
            ], []);
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->downloadService->update($id, $params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $params['user_id'] = $this->request->getAttribute('user_id');
            $this->downloadService->delete($id, $params);
            return $this->responseCore->success([]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
