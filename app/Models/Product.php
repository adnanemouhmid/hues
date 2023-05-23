<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable= [
        'name',
        'code',
        'description', 
        'price', 
        'colors', 
        'sizes', 
        'cathegory', 
        'discount', 
    ];
    use HasFactory;
}
