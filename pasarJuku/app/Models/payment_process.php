<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_process extends Model
{
    use HasFactory;
    protected $table = 'payment_process';
    protected $primaryKey = 'payment_processID';
    public $incrementing = true;

    protected $fillable = [
        'paymentID',
        'payment_status',
        'total_price',
    ];

    public function payment()
    {
        return $this->belongsTo(payment::class); // one to many
    }
}
