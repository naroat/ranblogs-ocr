<?php


namespace App\Service;


use App\Model\Download;
use App\Model\Lists;
use App\Model\Tool;
use App\Model\ToolCate;
use function Taoran\HyperfPackage\Helpers\set_save_data;

class ToolCateService
{
    public function getList()
    {
        $list = ToolCate::get();
        return $list;
    }
}