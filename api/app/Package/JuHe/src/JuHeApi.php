<?php


namespace App\Package\JuHe\src;


use App\Traits\Util;

class JuHeApi
{
    const BASE_URL_V = "http://v.juhe.cn";
    const BASE_URL_APIS = "http://apis.juhe.cn";

    public function __construct() {}

    /**
     * 新闻头条列表 - https://www.juhe.cn/box/index/id/235
     */
    public function toutiaoIndex($type = 'guonei', $page = 1, $pageSize = 30, $isFilter = 0)
    {
        $uri = '/toutiao/index';
        $key = env('JUHE_TOUTIAO_INDEX_KEY');
        $list = Util::httpRequest(self::BASE_URL_V . $uri, 'post', [
            'type' => $type,
            'page' => $page,
            'page_size' => $pageSize,
            'is_filter' => $isFilter,
            'key' => $key,
        ], [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);
        return $list;
    }

    /**
     * 新闻详情 - https://www.juhe.cn/box/index/id/235
     *
     * @param $uniquekey
     * @return bool|string
     */
    public function toutiaoContent($uniquekey)
    {
        $uri = '/toutiao/content';
        $key = env('JUHE_TOUTIAO_INDEX_KEY');
        $list = Util::httpRequest(self::BASE_URL_V . $uri, 'post', [
            'uniquekey' => $uniquekey,
            'key' => $key,
        ], [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);
        return $list;
    }
}