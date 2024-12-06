<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model 
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'productID';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'categoryID',
    ];


    public function businessProfile()
    {
        return $this->belongsTo(businessProfile::class); // one to many
    }
    public function category()
    {
        return $this->belongsTo(category::class); // one to many
    }
}
