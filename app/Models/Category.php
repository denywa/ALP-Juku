<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'categoryID';
    protected $fillable = [
        'category_name',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'categoryID');
    }
}