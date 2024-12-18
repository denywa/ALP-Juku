<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = null;
    protected $fillable = [
        'userID',
        'productID',
        'quantity',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'productID');
    }
}