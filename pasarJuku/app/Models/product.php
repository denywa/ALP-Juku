<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'productID';
    public $incrementing = true;
    protected $fillable = [
        'businessProfileID',
        'name',
        'description',
        'price',
        'unit',
        'stock',
        'image',
        'categoryID',
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => url('/storage/product-image/' . $image),
        );
    }

    public function businessProfile()
    {
        return $this->belongsTo(businessProfile::class, 'businessProfileID'); // one to many
    }
    public function category()
    {
        return $this->belongsTo(category::class); // one to many
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'cart');
    }

    public function order_item()
    {
        return $this->hasMany(order_item::class);
    }

    // app/Models/Product.php
    public function users()
    {
        return $this->belongsToMany(User::class, 'cart', 'productID', 'userID')->withPivot('quantity','total_price')->withTimestamps();
    }
}
