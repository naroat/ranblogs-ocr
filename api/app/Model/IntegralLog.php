<?php

declare (strict_types=1);
namespace App\Model;

/**
 */
class IntegralLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'integral_log';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    //io
    const IO_INCOME = 1;
    const IO_EXPEND = 2;
    public static $ioTran = [
        IO_INCOME => '收入',
        IO_EXPEND => '支出',
    ];

    //type
    const TYPE_USE_INTERFACE = 0;
    const TYPE_CHECK_IN = 1;
    const TYPE_INVITE = 2;
    const TYPE_RECHARGE = 3;
    public static $typeTran = [
        TYPE_USE_INTERFACE => '调用接口',
        TYPE_CHECK_IN => '签到',
        TYPE_INVITE => '邀请用户',
        TYPE_RECHARGE => '充值积分',
    ];
}