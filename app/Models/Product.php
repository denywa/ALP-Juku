<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'productID';
    protected $fillable = [
        'businessProfileID',
        'name',
        'description',
        'price',
        'stock',
        'categoryID',
    ];

    public $timestamps = false;

    public function businessProfiles()
    {
        return $this->belongsTo(businessProfile::class, 'businessProfileID');
    } 

    public function categories()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }

    public function carts()
    {
        return $this->hasMany(Category::class, 'productID');
    }

    public function orderitems()
    {
        return $this->hasMany(orderItem::class, 'orderItemID');
    }
}
