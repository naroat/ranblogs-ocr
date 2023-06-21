<?php


namespace App\Package\Sms\src\ali;


use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use App\Package\Sms\src\SmsInterface;
use Darabonba\OpenApi\Models\Config;

class AliSms implements SmsInterface
{
    private $endpoint = 'dysmsapi.aliyuncs.com';

    private $signName;

    private $client;

    public function __construct()
    {
        $this->signName = config('sms.sign_name');
        $config = new Config([
            "accessKeyId" => config('sms.access_key'),
            "accessKeySecret" => config('sms.access_key_secret'),
        ]);
        $config->endpoint = $this->endpoint;
        $this->client = new Dysmsapi($config);
    }

    public function send($phone, string $content, $templateCode)
    {
        $smsRequest = new SendSmsRequest([
            'phoneNumbers' => $phone,
            'signName' => $this->signName,
            'templateParam' => $content,
            'templateCode' => $templateCode,
        ]);

        $response = $this->client->sendSmsWithOptions($smsRequest, new RuntimeOptions([]));
        return $response;
    }
}