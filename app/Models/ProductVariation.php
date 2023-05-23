<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable= [
        'product',
        'color',
        'size', 
        'stock'
    ];
    use HasFactory;
}
