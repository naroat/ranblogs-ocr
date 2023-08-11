<?php

declare(strict_types=1);

namespace App\Controller\Openapi;

use App\Amqp\Producer\IntegralProducer;
use App\Constants\OpenapiCode;
use App\Model\IntegralLog;
use App\Package\Deepgram\src\Deepgram;
use App\Service\UserService;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;
use Taoran\HyperfPackage\Upload\Upload;

class DeepgramController extends AbstractController
{
    /**
     * @Inject()
     * @var Deepgram
     */
    public $deepgramService;

    /**
     * @Inject()
     * @var Producer
     */
    private $producer;

    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    public function audioTranscriptions(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['url', ''],
            ['language', 'en'],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'url' => 'url',
            ], []);

            //user id
            $userId = $this->request->getAttribute('user_id');
            $code = OpenapiCode::DEEPGRAM_AUDIO_TRANSCRIPTIONS;

            //用户积分或openapi产品配置检测等
            $this->userService->checkExecOpenapi($userId, OpenapiCode::BAIDU_OCR_V1_GENERAL_BASIC, $openapiinfo);

            //接收文件
            $file = $this->request->file('file');

            if (!empty($params['url'])) {
                $finally_path = $params['url'];
            } else if ($file != null) {
                $finally_path = $this->uploadOss($file);
            } else {
                throw new \Exception("请上传文件");
            }

            $list = $this->deepgramService->audioTranscriptions($finally_path, $params['language']);

            //扣除积分
            $this->producer->produce(new IntegralProducer(['type' => IntegralLog::TYPE_USE_INTERFACE, 'user_id' => $userId, 'product' => $code]));

            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            printf($e->getMessage() . "\n");
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 获取路径
     *
     * @param $type
     * @return string
     * @throws \Exception
     */
    public function uploadType($type)
    {
        switch ($type) {
            case 'audio_tran':
                $path = 'public/uploads/audio_tran/';
                break;
            default:
                throw new \Exception('上传类型错误！');
                break;
        }
        return $path;
    }

    /**
     * 上传oss
     *
     * @throws \Exception
     */
    public function uploadOss($file)
    {
        //检查文件大小
        if ($file->getSize() > config('upload.upload_max_size')) {
            throw new \Exception('文件大小不能超过20M!');
        }
        //上传oss
        $upload = new Upload();
        $file = $upload->checkFile();
        $path = $this->uploadType('audio_tran');

        $finally_path = $upload->toAlioss($file, $path);
        return $finally_path;
    }
}
