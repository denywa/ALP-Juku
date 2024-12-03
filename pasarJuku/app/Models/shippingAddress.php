<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shippingAddress extends Model
{
    use HasFactory;

    protected $table = 'shippingAddress';
    protected $primaryKey = 'shippingAddressID';
    public $incrementing = true;
    protected $fillable = [
        'address',
        'city',
        'pos_code',
        'recipient_name',
        'phone',
    ];
}
