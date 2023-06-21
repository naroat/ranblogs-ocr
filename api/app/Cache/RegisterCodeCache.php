<?php


namespace App\Cache;


class RegisterCodeCache extends AbstractRedis
{
    public $key = 'SMS_REGISTER_CODE';

    public function getKey($phone)
    {
        return $this->key . ':' . $phone;
    }
}