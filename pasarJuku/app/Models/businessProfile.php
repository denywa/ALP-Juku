<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class businessProfile extends Model
{
    use HasFactory;

    protected $table = 'businessProfile';
    protected $primaryKey = 'businessProfileID';
    public $incrementing = true;

    protected $fillable = [
        'business_name',
        'business_address',
        'SIUP',
        'bank_account',
        'verified_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // one to one
    }
    
    public function product()
    {
        return $this->hasMany(product::class); // one to many
    }

}
