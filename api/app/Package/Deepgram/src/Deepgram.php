<?php


namespace App\Package\Deepgram\src;


use GuzzleHttp\Client;

class Deepgram
{
    const BASE_URL = "https://api.deepgram.com/v1";

    private $apiKey;

    private $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('DEEPGRAM_API_KEY', '');
        if (empty($this->apiKey)) {
            throw new \Exception("api key error!");
        }
    }

    public function getHeader()
    {
        return [
            'Authorization' => 'Token ' . $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ];
    }

    /**
     * 音频转录文本
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function audioTranscriptions($file, $language = 'en')
    {
        $url = self::BASE_URL . "/listen?filler_words=false&summarize=v2&language={$language}";

        if (filter_var($file, FILTER_VALIDATE_URL) != false) {
            //url
            $body = sprintf('{"url":"%s"}', $file);
        } else {
            //使用文件的方式有问题，官网的模拟工具也无法成功调用，这里暂留，但主要还是用上传到oss获取链接的方式来使用
            //文件
            $fileContent = file_get_contents($file);
            //获取类型
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $filename = pathinfo($file, PATHINFO_BASENAME);
            $type = mime_content_type($file);
            $type = explode('/', $type)[0] ?? 'audio';
            $body = "data:{$type}/{$ext};name={$filename};base64," . base64_encode($fileContent);
        }

        $response = $this->client->request('POST', $url, [
            'body' => $body,
            'headers' => $this->getHeader(),
        ]);

        $jsonContent = json_decode($response->getBody()->getContents(), true);
        return ['text' => $jsonContent['results']['channels'][0]['alternatives'][0]['transcript'] ?? ''];
    }
}