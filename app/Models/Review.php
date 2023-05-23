<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable= [
        'product',
        'user',
        'review', 
    ];    
    use HasFactory;
}
