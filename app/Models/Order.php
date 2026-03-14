<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address_id',
        'order_code',
        'status',
        'payment_method',
        'payment_status',
        'shipping_status',
        'subtotal',
        'discount_total',
        'shipping_fee',
        'tax_total',
        'grand_total',
        'customer_note',
        'placed_at',
    ];
}
