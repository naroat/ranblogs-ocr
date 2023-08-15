<?php

declare (strict_types=1);
namespace App\Model;

/**
 */
class Lists extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lists';

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
     * 关联: users
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function users()
    {
        return $this->hasOne(Users::class, 'id', 'user_id');
    }
}