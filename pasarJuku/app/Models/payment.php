<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'paymentID';
    public $incrementing = true;
    public $timestamps = false; //false krn tidak butuh timestamp, isinya kategori di set dari awal dan tetap.

    protected $fillable = [
        'payment_type',
    ];
}
