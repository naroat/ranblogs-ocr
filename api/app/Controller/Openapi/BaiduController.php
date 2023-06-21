<?php

declare(strict_types=1);

namespace App\Controller\Openapi;

use App\Amqp\Producer\IntegralProducer;
use App\Constants\OpenapiCode;
use App\Model\OpenapiProduct;
use App\Model\Users;
use App\Package\Baidu\src\AipOcr;
use App\Package\Baidu\src\Constants\OcrErrorCode;
use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Taoran\HyperfPackage\Core\AbstractController;

class BaiduController extends AbstractController
{
    /**
     * @Inject()
     * @var AipOcr
     */
    private $aipOcr;

    /**
     * @Inject()
     * @var \Hyperf\Amqp\Producer
     */
    private $producer;

    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    /**
     * 通用文字识别（标准版）
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function ocrGeneralBasic(RequestInterface $request, ResponseInterface $response)
    {
        $params = $this->verify->requestParams([
            ['language_type', 'CHN_ENG'],
        ], $this->request);

        try {
            $baseOpenapiIsLogin = config('base_openapi_is_login');
            if ($baseOpenapiIsLogin == 'true') {
                $userId = $this->request->getAttribute('user_id');
                //用户积分或openapi产品配置检测等
                $this->userService->checkExecOpenapi($userId, OpenapiCode::BAIDU_OCR_V1_GENERAL_BASIC, $openapiinfo);
            } else {
                //验证api产品是否有效
                $this->userService->checkOpenapiValid(OpenapiCode::BAIDU_OCR_V1_GENERAL_BASIC);
            }

            $file = $request->file('image');
            if ($file == null) {
                throw new \Exception("请上传文件");
            }
            //设置参数
            $options = [
                'language_type' => $params['language_type']
            ];
            //读取文件内容
            $image = file_get_contents($file->getPath() . '/' . $file->getFilename());
            $result = $this->aipOcr->basicGeneral($image, $options);
            if (isset($result['error_code'])) {
                throw new \Exception(OcrErrorCode::ERROR_CODE[$result['error_code']] ?? '请求繁忙,请稍后尝试');
            }
            if ($baseOpenapiIsLogin == 'true') {
                //扣除积分
                $this->producer->produce(new IntegralProducer(['type' => 0, 'user_id' => $userId, 'product' => OpenapiCode::BAIDU_OCR_V1_GENERAL_BASIC]));
            }
            return $this->responseCore->success($result);
        } catch (\Exception $e) {
            return $this->responseCore->error($e->getMessage());
        }
    }

    /**
     * 识别的内容组合成文本
     *
     * @param $wordsResult
     * @return string
     */
    public function BuildContent($wordsResult)
    {
        $content = '';
        foreach ($wordsResult as $v) {
            $content .= $v['words'] . '\n';
        }
        return $content;
    }
}
