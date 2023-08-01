<?php

declare (strict_types=1);
namespace App\Model;

/**
 */
class Download extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'download';

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

    /**
     * 状态
     */
    const STATUS_WAIT = 0;          //等待，排队
    const STATUS_SUCCESS = 1;       //成功
    const STATUS_PROCEED = 2;       //进行
    const STATUS_FAIL = 3;          //失败
    const STATUS_PAUSE = 4;         //暂停
    public static $statusTran = [
        STATUS_WAIT => '等待',
        STATUS_SUCCESS => '完成',
        STATUS_PROCEED => '进行',
        STATUS_FAIL => '失败',
        STATUS_PAUSE => '暂停',
    ];

    /**
     * 关联: users
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function users()
    {
        return $this->hasOne(Users::class, 'id', 'user_id');
    }
}