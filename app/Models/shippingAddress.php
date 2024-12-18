<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shippingAddress extends Model
{
    use HasFactory;

    protected $table = 'shippingAddresses';
    protected $primaryKey = 'shippingAddressID';
    protected $fillable = [
        'address',
        'city',
        'pos_code',
        'recipient_name',
        'phone',
    ];

    public $timestamps = false;

    public function user_shippingAddress()
    {
    	return $this->hasMany(user_shippingAddress::class, 'shippingAddressID'); 
    }
}
