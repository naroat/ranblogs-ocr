<?php


namespace App\Cache;


use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

abstract class AbstractRedis
{
    /**
     * @Inject()
     * @var Redis
     */
    protected $redis;
}