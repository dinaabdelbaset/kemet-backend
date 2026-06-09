<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HajjUmrahPackage extends Model
{
    use HasFactory;

    protected $table = 'hajj_umrah_packages';

    protected $fillable = [
        'name_en', 'name_ar', 'price', 
        'hotel_makkah_en', 'hotel_makkah_ar', 
        'hotel_madinah_en', 'hotel_madinah_ar', 
        'hotel_makkah_id', 'hotel_madinah_id', 
        'flight_id', 'transportation_id',
        'duration_days', 'description_en', 'description_ar', 
        'image', 'features_en', 'features_ar'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'features_en' => 'array',
        'features_ar' => 'array',
        'hotel_makkah_id' => 'integer',
        'hotel_madinah_id' => 'integer',
        'flight_id' => 'integer',
        'transportation_id' => 'integer',
    ];

    public function hotelMakkah()
    {
        return $this->belongsTo(Hotel::class, 'hotel_makkah_id');
    }

    public function hotelMadinah()
    {
        return $this->belongsTo(Hotel::class, 'hotel_madinah_id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function transportation()
    {
        return $this->belongsTo(Transportation::class, 'transportation_id');
    }
}
