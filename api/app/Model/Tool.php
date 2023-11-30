<?php

declare (strict_types=1);
namespace App\Model;

/**
 */
class Tool extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tool';

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
     * 关联tool cate
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function toolCate()
    {
        return $this->hasOne(ToolCate::class, 'id', 'cate_id');
    }
}