<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    use HasFactory;
    protected $table = 'order_items';
    protected $primaryKey = 'order_itemID';
    public $incrementing = true;

    protected $fillable = [
        'productID',
        'quantity',
        'orderID',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderID', 'orderID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }   

    public function review()
    {
        return $this->hasOne(review::class, 'order_itemID', 'order_itemID');
    }

}
