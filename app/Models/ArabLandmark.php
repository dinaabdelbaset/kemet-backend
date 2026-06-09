<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArabLandmark extends Model
{
    protected $table = 'arab_landmarks';

    protected $fillable = [
        'country_id',
        'name_en',
        'name_ar',
        'location_en',
        'location_ar',
        'category',
        'image',
        'description_en',
        'description_ar',
        'latitude',
        'longitude',
        'rating'
    ];

    protected $appends = ['ticket_price'];

    public function getTicketPriceAttribute()
    {
        $nameEn = strtolower($this->name_en);
        $nameAr = $this->name_ar;

        // Check if the landmark is free (mosques, public squares, open mountains/valleys)
        if (
            str_contains($nameEn, 'mosque') || 
            str_contains($nameAr, 'مسجد') || 
            str_contains($nameAr, 'جامع') ||
            str_contains($nameEn, 'square') || 
            str_contains($nameAr, 'ساحة') ||
            str_contains($nameEn, 'pearl') || // Chefchaouen (The Blue Pearl)
            str_contains($nameAr, 'شفاون') ||
            str_contains($nameEn, 'mountain') || // Jebel Akhdar
            str_contains($nameAr, 'جبل')
        ) {
            return 0; // Free entry!
        }

        // Give a realistic ticket price based on the country or ID
        $country = $this->country()->first();
        if ($country) {
            $code = strtoupper($country->code);
            switch ($code) {
                case 'EG': return 250;
                case 'SA': return 100;
                case 'JO': return 20;
                case 'AE': return 120;
                case 'KW': return 10;
                default: return 30;
            }
        }
        return 30;
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(ArabCountry::class, 'country_id');
    }
}
