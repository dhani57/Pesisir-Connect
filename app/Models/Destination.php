<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'image',
        'location',
        'description',
        'highlights',
        'rating',
        'reviews',
    ];

    protected $casts = [
        'highlights' => 'array',
        'rating' => 'decimal:1',
        'reviews' => 'integer',
    ];
}
