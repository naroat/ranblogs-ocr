<?php

declare(strict_types=1);

namespace App\Controller\Openapi;

use App\Amqp\Producer\IntegralProducer;
use App\Constants\IntegralLogType;
use App\Constants\OpenapiCode;
use App\Model\IntegralLog;
use App\Package\OpenAi\src\OpenAi;
use App\Traits\LogTrait;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class OpenaiController extends AbstractController
{
    /**
     * @Inject()
     * @var OpenAi
     */
    public $openaiService;

    public function chatCompletions(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['message', '']
        ], $this->request);

        try {
            $this->verify->check($params, [
                'message' => 'required'
            ], [
                'message.required' => '消息参数不能为空'
            ]);
            $list = $this->openaiService->chatCompletions($params['message']);

            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            //LogTrait::ApiErrLog($accessKey, $params, $e->getMessage());
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function imagesGenerations(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['prompt', ''],
            ['n', 1],
            ['size', '256x256'],
        ], $this->request);

        try {
            $this->verify->check($params, [
                'prompt' => 'required',
                'n' => 'max:8|min:1',
                'size' => 'in:256x256,512x512,1024x1024',
            ], [
                'prompt.required' => '提示不能为空',
                'n.max' => '生成数量范围为1-8',
                'n.min' => '生成数量范围为1-8',
                'size.in' => '尺寸无效，有效尺寸为：256x256,512x512,1024x1024',
            ]);
            $list = $this->openaiService->imagesGenerations($params['prompt'], $params['n'], $params['size']);

            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    public function audioTranscriptions(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['language', 'en'],
        ], $this->request);

        try {
            //user id
            $userId = $this->request->getAttribute('user_id');
            $code = OpenapiCode::OPENAI_AUDIO_TRANSCRIPTIONS;

            //验证api产品是否有效
            $this->userService->checkOpenapiValid($code);

            $file = $this->request->file('file');
            if ($file == null) {
                throw new \Exception("请上传文件");
            }
            $filename = time() . rand(1000, 9999) . '.' . $file->getExtension();
            $dateText = date('Y-m-d', time());
            $storageTmp = BASE_PATH . "/storage/tmp/{$dateText}/";
            if (!is_dir($storageTmp)) {
                mkdir($storageTmp, 0777, true);
            }
            $filepath = $storageTmp . $filename;
            $file->moveTo($filepath);
            $list = $this->openaiService->audioTranscriptions($filepath, $params['language']);

            //扣除积分
            $this->producer->produce(new IntegralProducer(['type' => IntegralLog::TYPE_USE_INTERFACE, 'user_id' => $userId, 'product' => $code]));

            return $this->responseCore->success($list);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }
}
