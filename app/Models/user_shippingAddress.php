<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_shippingAddress extends Model
{
    use HasFactory;

    protected $table = 'usershippingAddresses';
    protected $primaryKey = 'user_shippingAddressID';
    protected $fillable = [
        'userID',
        'shippingAddressID',
    ];

    public $timestamps = false;

    public function shippingAddresses()
    {
    	return $this->belongsTo(shippingAddress::class, 'shippingAddressID'); 
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_shippingAddressID'); 
    }
}
