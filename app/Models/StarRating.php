<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarRating extends Model
{

    protected $fillable= [
        'product',
        'user',
        'star_rating', 
    ];
    use HasFactory;
}
