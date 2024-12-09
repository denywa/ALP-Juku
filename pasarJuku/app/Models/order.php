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
        'order_status'
    ];

    public function user_ShippingAddress()
    {
        return $this->belongsTo(user_ShippingAddress::class);
    }

    public function order_item()
    {
        return $this->hasMany(order_item::class);
    }
}
