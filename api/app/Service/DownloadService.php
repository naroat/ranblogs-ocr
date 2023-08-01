<?php


namespace App\Service;


use App\Cache\RegisterCode;
use App\Constants\SmsTemplate;
use App\Model\Download;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class DownloadService
{
    public function getList($params)
    {
        $list = Download::where('user_id', $params['user_id']);

        //build where
        if ($params['link'] != '') {
            $list = $list->where('link', 'like', '%' . $params['link'] . '%');
        }

        if ($params['desc'] != '') {
            $list = $list->where('desc', 'like', '%' . $params['desc'] . '%');
        }

        if ($params['status'] != '') {
            $list = $list->where('status', $params['status']);
        }

        $list = $list->paginate(50);
        $list->each(function ($item) {
            $item->statusText = Download::$statusTran[$item->status];
        });
        return $list;
    }

    public function getOne($id, $params)
    {
        $info = Download::where('user_id', $params['user_id'])->find($id);
        $info->statusText = Download::$statusTran[$info->status];
        return $info;
    }

    public function add($params)
    {
        $download = Download::where('link', $params['link'])->first();
        //重复链接验证
        if ($download && $params['re_download'] != 1) {
            throw new \Exception("该下载已存在列表, 是否重复下载");
        }

        //add
        $downloadModel = new Download();
        set_save_data($downloadModel, [
            'user_id' => $params['user_id'],
            'link' => $params['link'],
            'desc' => $params['desc'] ?? '',
            'status' => $downloadModel::STATUS_WAIT,
        ]);
        $downloadModel->save();
    }

    public function update($id, $params)
    {
        $info = Download::where('user_id', $params['user_id'])->find($id);
        if (!$info) {
            throw new \Exception("信息不存在");
        }
        $saveData = [];
        if ($params['desc'] != '') {
            $saveData['desc'] = $params['desc'];
        }

        if ($params['status'] != '') {
            $saveData['status'] = $params['status'];
        }

        if (!empty($saveData)) {
            set_save_data($info, $saveData);
            $info->save();
        }
    }

    public function delete($id, $params)
    {
        $info = Download::where('user_id', $params['user_id'])->find($id);
        if (!$info) {
            throw new \Exception('信息不存在');
        }
        $info->delete();
    }
}