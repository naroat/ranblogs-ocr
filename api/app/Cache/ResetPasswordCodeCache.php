<?php


namespace App\Cache;


class ResetPasswordCodeCache extends AbstractRedis
{
    public $key = 'SMS_RESET_PASSWORD_CODE';

    public function getKey($phone)
    {
        return $this->key . ':' . $phone;
    }
}