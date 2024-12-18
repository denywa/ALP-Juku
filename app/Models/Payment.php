<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'paymentID';
    protected $fillable = [
        'payment_type',

    ];

    public $timestamps = false;

    public function paymentprocesses()
    {
        return $this->hasOne(paymentProcess::class, 'paymentID');
    }
}
