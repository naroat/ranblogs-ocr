<?php


namespace App\Package\Sms\src;


interface SmsInterface
{
    public function send($phone, string $content, $templateCode);
}