<?php


namespace App\Cache;


class RegisterCodeCache extends AbstractRedis
{
    public $key = 'REGISTER_CODE';

    public function getKey($flag)
    {
        return $this->key . ':' . $flag;
    }
}