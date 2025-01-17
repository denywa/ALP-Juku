<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shippingAddress extends Model
{
    use HasFactory;

    protected $table = 'shippingaddress';
    protected $primaryKey = 'shippingAddressID';
    public $incrementing = true;
    protected $fillable = [
        'address',
        'city',
        'pos_code',
        'recipient_name',
        'phone',
    ];

    public function user()
    {
    	return $this->belongsToMany(User::class, 'user_shippingaddress', 'shippingAddressID', 'userID')->withPivot('user_shippingAddressID'); 
    }
}
