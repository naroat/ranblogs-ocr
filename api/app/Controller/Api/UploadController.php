<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Taoran\HyperfPackage\Core\AbstractController;
use function Taoran\HyperfPackage\Helpers\get_msectime;
use Taoran\HyperfPackage\Upload\Upload;


class UploadController extends AbstractController
{
    /**
     * @Inject()
     * @var Upload
     */
    protected $upload;

    /**
     * 上传文件
     *
     * @param RequestInterface $request
     * @return mixed
     * @throws \Exception
     */
    public function upload(RequestInterface $request)
    {
        try {
            //接收参数
            $params = $this->verify->requestParams([
                ['type', ""],
            ], $this->request);

            //验证参数
            $this->verify->check(
                $params,
                [
                    "type" => 'required',
                ],
                [
                    "type.required" => "请设置类型！",
                ]
            );

            $upload = new Upload();
            $file = $upload->checkFile();
            $path = $this->updateType($request->input('type') ?? '');
            if (config('upload.drive') == 'aliyun') {
                //alioss
                $finally_path = $upload->toAlioss($file, $path);
            } else {
                //本地
                $finally_path = $upload->toLocal($file, $path);
            }
            return $this->responseCore->success([
                'path' => $finally_path
            ]);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 上传文件by base64
     *
     * @param RequestInterface $request
     * @return mixed
     * @throws \Exception
     */
    public function uploadBase64(RequestInterface $request)
    {
        $upload = new Upload();
        $file_param = $request->all()['file'];
        //生成文件名
        $ext_explode =  explode('.', $file_param['_name']);
        $ext = '.' . $ext_explode[count($ext_explode) - 1];
        $filename = get_msectime() . $ext;
        //上传目标目录
        $path = $this->updateType($request->input('type') ?? '');
        if (config('upload.drive') == 'aliyun') {
            //alioss
            $finally_path = $upload->saveBase64ToAlioss($filename, $file_param['miniurl'], $path);
        } else {
            //本地
            $finally_path = $upload->saveBase64ToLocal($filename, $file_param['miniurl'], $path);
        }
        return $this->responseCore->success([
            'path' => $finally_path
        ]);
    }

    /**
     * 获取路径
     *
     * @param $type
     * @return string
     * @throws \Exception
     */
    public function updateType($type)
    {
        switch ($type) {
            case 'admin_user_headimg':
                $path = 'public/uploads/admin_user/headimg/';
                break;
            case 'article_markdown':
                $path = 'public/uploads/article/markdown/';
                break;
            case 'article_cover':
                $path = 'public/uploads/article/cover/';
                break;
            default:
                throw new \Exception('上传类型错误！');
                break;
        }
        return $path;
    }
}
