<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'categoryID';
    public $incrementing = true;
    public $timestamps = false; //false krn tidak butuh timestamp, isinya kategori di set dari awal dan tetap.

    protected $fillable = [
        'category_name',
    ];
}
