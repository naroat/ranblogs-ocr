<?php

namespace App\Package\Sms\src;

use App\Package\Sms\src\ali\AliSms;

class Sms
{
    private $client = null;

    private $drive;

    public function __construct()
    {
        $this->drive = config('sms.drive');
        if ($this->drive == 'ali') {
            $this->client = new AliSms();
        }
    }

    public function send($phone, $content, $templateCode)
    {
        if (!$this->client) {
            return false;
        }
        return $this->client->send($phone, $content, $templateCode);
    }
}