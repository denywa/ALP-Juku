<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderItem extends Model
{
    use HasFactory;

    protected $table = 'orderitems';
    protected $primaryKey = 'orderItemID';
    protected $fillable = [
        'productID',
        'quantity',
        'orderID',

    ];

    public $timestamps = false;

    public function orders()
    {
        return $this->belongsTo(Order::class, 'orderID');
    }

    public function reviews()
    {
        return $this->hasOne(Review::class, 'orderItemID');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'orderItemID');
    }
}
