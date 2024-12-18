<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'orderID';
    protected $fillable = [
        'user_shippingAddressID',
        'order_date',
        'order_status',

    ];

    public $timestamps = false;

    public function user_shippingAddresses()
    {
        return $this->belongsto(user_shippingAddress::class, 'user_shippingAddressID'); 
    }

    public function paymentprocesses()
    {
        return $this->hasOne(paymentProcess::class, 'orderID');
    }

    public function orderitems()
    {
        return $this->hasMany(orderItem::class, 'orderID');
    }
}
