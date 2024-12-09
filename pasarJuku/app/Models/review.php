<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    protected $table = 'shippingAddress';
    protected $primaryKey = 'shippingAddressID';
    public $incrementing = true;

    protected $fillable = [
        'shippingAddressID',
        'order_itemID',
        'rating',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
