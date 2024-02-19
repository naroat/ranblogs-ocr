<?php

declare (strict_types=1);
namespace App\Model;

/**
 */
class ToolCate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tool_cate';

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

    //一对多
    public function tools()
    {
        return $this->hasMany(Tool::class, 'cate_id', 'id');
    }
}