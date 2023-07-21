<?php
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

include "../src/CompressImg.php";

use App\Package\CompressImg\src\CompressImg;

//目录或文件
$imgPath = '/disk2/www/ranblogs-ocr/docs/images/';

$comressImg = new CompressImg();

//设置过滤的文件大小; 单位：k
$comressImg->setLimitSize(100);
//        $comressImg->setSavePath($imgPath);
//        $imgSrc = $imgPath . 'WeChat3fe0cb8dfebfd5ba56305b1c8b8b3775.png';
//        $comressImg->compress($imgSrc);
//        exit;
$files = scandir($imgPath);
$comressImg->setSavePath($imgPath);
foreach ($files as $filename) {
    if (strpos($filename, '.') == 0) {
        continue;
    }
    $imgSrc = $imgPath . $filename;
    $comressImg->compress($imgSrc);
}