<?php


namespace App\Package\CompressImg\src;

/**
 * 临时用的图片压缩工具包
 *
 * Class CompressImg
 * @package App\Package\CompressImg\src
 */
class CompressImg
{
    /** @var int 过滤的文件大小； 单位K */
    private $limitSize = 200;

    /** @var int 宽度压缩比例 0.5 = 50%； 1 = 100% */
    private $compressWidth = 0.6;

    /** @var int 高度压缩比例 0.5 = 50%； 1 = 100% */
    private $compressHeight = 0.6;

    /** @var 压缩图片质量； 1 - 9 */
    private $quality = 9;

    /** @var 输出目录 */
    private $savePath;

    /** @var 图片大小 */
    private $imgSize;

    /** @var 图片名称 */
    public $imgName;

    public function __construct()
    {
    }

    /**
     * 设置过滤的文件大小
     *
     * @param $limitSize
     * @throws \Exception
     */
    public function setLimitSize($limitSize) {
        $this->limitSize = $limitSize;
    }

    /**
     * 设置存储路径
     *
     * @param $path
     */
    public function setSavePath($path) {
        $this->savePath = $path;
    }

    private function getImgInfo($imgSrc)
    {
        //获取文件大小
        $this->imgSize = filesize($imgSrc);

        //大小检测
        if ($this->imgSize > 10240000) {
            throw new \Exception('图片大小不能超过10m');
        }

        //文件路径
        $pathinfo = pathinfo($imgSrc);
        $this->imgName = $pathinfo['basename'];
    }

    public function compress($imgSrc)
    {
        //获取图片信息
        $this->getImgInfo($imgSrc);

        //输出路径
        $saveSrc = $this->savePath . $this->imgName;

        if ($this->imgSize > $this->limitSize * 1024) {
            //超过该范围才压缩
            list($width, $height, $type, $attr) = getimagesize($imgSrc);
            $imageinfo = ['width' => $width, 'height' => $height, 'type' => image_type_to_extension($type, false), 'attr' => $attr];
            $newWidth = (int)($imageinfo['width'] * $this->compressWidth);
            $newHeight = (int)($imageinfo['height'] * $this->compressHeight);
            if (in_array($type, [2, 3])) {
                //压缩JPEG，png
                $imageThump = imagecreatetruecolor($newWidth, $newHeight);
                $createFromfunc = "imagecreatefrom" . $imageinfo['type'];
                $image = $createFromfunc($imgSrc);
                imagecopyresampled($imageThump, $image, 0, 0, 0, 0, $newWidth, $newHeight, $imageinfo['width'], $imageinfo['height']);

                $imageFunc = 'image' . $imageinfo['type'];
                $imageFunc($imageThump, $saveSrc, $this->quality);
                imagedestroy($imageThump);
            }
        }
    }
}