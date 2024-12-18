<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'reviewID';
    protected $fillable = [
        'userID',
        'orderItemID',
        'rating',
        'comment',

    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function orderitems()
    {
        return $this->belongsTo(orderItem::class, 'orderItemID');
    }

}
