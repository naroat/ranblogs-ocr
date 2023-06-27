<?php


namespace App\Package\OpenAi\src;


use App\Traits\LogTrait;
use GuzzleHttp\Client;
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\Models\ChatCompletions\CreateRequest;

class OpenAi
{
    const BASE_URL = "https://api.openai-proxy.com/v1";    //openai域名
//    const BASE_URL = "https://api.openai.com/v1";    //openai域名
//    const BASE_URL = "https://openai.geekr.cool/v1";   //代理域名

    private $mode = "gpt-3.5-turbo";

    private $openaiClinet;

    public function __construct()
    {
        //$this->openaiClinet = Manager::build(new Client(), New Authentication(env('SECRET_KEY')));
        $this->openaiClinet = new \Tectalic\OpenAi\Client(new Client(), New Authentication(env('SECRET_KEY')), self::BASE_URL);
    }

    /**
     * chat
     *
     * @param $message
     * @return mixed|string
     */
    public function chatCompletions($message)
    {
        try {
            if (strlen($message) == 0) {
                throw new \Exception("请输入内容");
            }
            $res = $this->openaiClinet->chatCompletions()->create(
                new CreateRequest([
                    'model' => $this->mode,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $message,
                        ]
                    ]
                ])
            )->toModel()->toArray();
            return $res;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 生成图片
     *
     * @param $message
     * @return mixed|string
     */
    public function imagesGenerations($message, $n = 1, $size = "256x256")
    {
        try {
            if (strlen($message) == 0) {
                throw new \Exception("请输入内容");
            }
            $res = $this->openaiClinet->imagesGenerations()->create(
                new \Tectalic\OpenAi\Models\ImagesGenerations\CreateRequest([
                    'prompt' => $message,
                    'n' => $n,
                    'size' => $size,
                ])
            )->toModel();
            return $res;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 音频转录为指定语言
     *
     * @param $message
     * @param int $n
     * @param string $size
     * @return mixed|string
     */
    public function audioTranscriptions($file, $language = 'en')
    {
        try {
            if (!is_file($file)) {
                throw new \Exception("请设置文件");
            }
            $res = $this->openaiClinet->audioTranscriptions()->create(
                new \Tectalic\OpenAi\Models\AudioTranscriptions\CreateRequest([
                    'file' => $file,
                    'model' => 'whisper-1',
                    'language' => $language
                ])
            )->toModel();

            //成功后删除本地文件
            @unlink($file);

            return $res;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}