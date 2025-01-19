<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'reviewID';
    public $incrementing = true;

    protected $fillable = [
        'userID',
        'order_itemID',
        'rating',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID'); 
    }

    public function order_item()
    {
        return $this->belongsTo(order_item::class, 'order_itemID', 'order_itemID'); 
    }
}
