<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'subtotal',
        'tax_rate',
        'tax',
        'shipping_charge',
        'shipping_charge_tax',
        'total_amount',
        'paid_at',
        'orderer_name',
        'orderer_name_kana',
        'orderer_prefecture',
        'orderer_city',
        'orderer_address',
        'orderer_tel',
        'payment_method',
        'transaction_id',
        'payment_number',
        'tracking_number',
        'shipping_company',
        'order_date',
        'shipping_date',
        'failure_reason',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
