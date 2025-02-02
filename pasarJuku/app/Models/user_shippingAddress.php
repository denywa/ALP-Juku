<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_shippingAddress extends Model
{
    use HasFactory;

    protected $table = 'user_shippingaddress';
    protected $primaryKey = 'user_shippingAddressID';
    public $incrementing = true;

    protected $fillable = [
        'userID',
        'shippingAddressID',
    ];
    
    //pivot table aslinya dk pake model , tapi karna butuh fk di table order jadi di buat bgni
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(shippingAddress::class, 'shippingAddressID', 'shippingAddressID');
    }

    public function orders()
    {
        return $this->hasMany(order::class, 'user_shippingAddressID', 'user_shippingAddressID'); 
    }
}
