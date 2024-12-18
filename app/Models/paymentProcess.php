<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentProcess extends Model
{
    use HasFactory;

    protected $table = 'paymentprocesses';
    protected $primaryKey = 'paymentProcessID';
    protected $fillable = [
        'orderID',
        'paymentID',
        'total_price',
        'payment_status',
        'payment_date',

    ];

    public $timestamps = false;

    public function orders()
    {
        return $this->belongsTo(Order::class, 'orderID');
    }

    public function payments()
    {
        return $this->belongsTo(Payment::class, 'paymentID');
    }
}
