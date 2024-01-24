<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_variation_id',
        'product_name',
        'variation_name',
        'description',
        'quantity',
        'price',
        'ckc_shot_type',
    ];
}
