<?php

declare (strict_types=1);
namespace App\Model;

use function Taoran\HyperfPackage\Helpers\set_save_data;

/**
 */
class LemonSubscriptionInvoices extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lemon_subscription_invoices';
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