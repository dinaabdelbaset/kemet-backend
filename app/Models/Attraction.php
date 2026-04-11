<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'nameAr', 'era', 'eraAr', 'location', 'governorate',
        'rating', 'reviews', 'description', 'longDescription', 'image',
        'gallery', 'ticketPrices', 'openingHours', 'bestTime', 'duration',
        'highlights', 'tips'
    ];

    protected $casts = [
        'gallery' => 'array',
        'ticketPrices' => 'array',
        'highlights' => 'array',
        'tips' => 'array',
        'rating' => 'float',
        'reviews' => 'integer',
    ];
}
