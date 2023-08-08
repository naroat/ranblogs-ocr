<?php

declare (strict_types=1);
namespace App\Model;

/**
 */
class Member extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member';
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
}