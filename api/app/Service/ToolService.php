<?php


namespace App\Service;


use App\Model\Download;
use App\Model\Lists;
use App\Model\Tool;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class ToolService
{
    public function getList($params)
    {
        $list = Tool::with('toolCate');

        if (!empty($params['title'])) {
            $list = $list->where('title', 'like', "%{$params['title']}%");
        }

        if (!empty($params['cateId'])) {
            $list = $list->where('cate_id', $params['cateId']);
        }

        $list = $list->get();
        $list->each(function ($item) {
            $item->cate = $item->toolCate->title ?? '';
            unset($item->toolCate);
        });
        return $list;
    }

    public function getRandomRecommend()
    {
        $list = Tool::orderByRaw('RAND()')->limit(10)->get();
        return $list;
    }
}