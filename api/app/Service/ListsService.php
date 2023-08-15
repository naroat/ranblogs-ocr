<?php


namespace App\Service;


use App\Model\Download;
use App\Model\Lists;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class ListsService
{
    public function getList($params)
    {
        $list = Lists::where('user_id', $params['user_id']);
        $list = $list->paginate(10);
        return $list;
    }

    public function getOne($id, $params)
    {
        $info = Lists::where('user_id', $params['user_id'])->find($id);
        return $info;
    }

    public function add($params)
    {
        $downloadModel = new Lists();
        set_save_data($downloadModel, [
            'user_id' => $params['user_id'],
        ]);
        $downloadModel->save();
    }

    public function update($id, $params)
    {
        $info = Lists::where('user_id', $params['user_id'])->find($id);
        if (!$info) {
            throw new \Exception("清单不存在");
        }
        $saveData = [];
        $saveData['content'] = $params['content'];

        if (!empty($saveData)) {
            set_save_data($info, $saveData);
            $info->save();
        }
    }

    public function delete($id, $params)
    {
        $info = Lists::where('user_id', $params['user_id'])->find($id);
        if (!$info) {
            throw new \Exception('清单不存在');
        }
        $info->delete();
    }
}