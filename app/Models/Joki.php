<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joki extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'bio',
        'price_per_hour',
        'available',
        'photo',
    ];
}
