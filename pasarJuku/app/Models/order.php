<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'orderID';
    public $incrementing = true;

    protected $fillable = [
        'user_shippingAddressID',
        'order_status'
    ];

    public function user_shippingAddress()
    {
        return $this->belongsTo(user_shippingAddress::class, 'user_shippingAddressID', 'user_shippingAddressID');
    }
    public function order_item()
    {
        return $this->hasMany(order_item::class,  'orderID', 'orderID');
    }
}
