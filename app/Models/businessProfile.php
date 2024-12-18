<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class businessProfile extends Model
{
    use HasFactory;

    protected $table = 'businessProfiles';
    protected $primaryKey = 'businessProfileID';
    protected $fillable = [
        'userID',
        'business_name',
        'business_address',
        'SIUP',
        'bank_account',
        'verified_status',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'businessProfileID');
    }
}
