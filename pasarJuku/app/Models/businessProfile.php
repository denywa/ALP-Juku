<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class businessProfile extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = 'businessProfile';
    protected $primaryKey = 'businessProfileID';
    public $incrementing = true;

    protected $fillable = [
        'userID',
        'business_name',
        'business_address',
        'SIUP',
        'bank_account',
        'verified_status'
    ];


        /**
     * SIUP
     *
     * @return Attribute
     */
    protected function SIUP(): Attribute  // Ubah dari image() menjadi SIUP()
    {
        return Attribute::make(
            get: fn($SIUP) => url('/storage/SIUP/' . $SIUP),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID'); // one to one
    }
    
    public function product()
    {
        return $this->hasMany(product::class); // one to many
    }

}
