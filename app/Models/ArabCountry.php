<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArabCountry extends Model
{
    protected $table = 'arab_countries';

    protected $fillable = [
        'name_en',
        'name_ar',
        'code',
        'flag',
        'image',
        'description_en',
        'description_ar'
    ];

    protected $appends = ['currency_code', 'currency_name_ar', 'currency_name_en'];

    public function getCurrencyCodeAttribute()
    {
        $code = strtoupper($this->code);
        $map = [
            'EG' => 'EGP',
            'SA' => 'SAR',
            'JO' => 'JOD',
            'AE' => 'AED',
            'KW' => 'KWD',
            'OM' => 'OMR',
            'QA' => 'QAR',
            'BH' => 'BHD',
        ];
        return $map[$code] ?? 'USD';
    }

    public function getCurrencyNameArAttribute()
    {
        $code = strtoupper($this->code);
        $map = [
            'EG' => 'جنيه مصري',
            'SA' => 'ريال سعودي',
            'JO' => 'دينار أردني',
            'AE' => 'درهم إماراتي',
            'KW' => 'دينار كويتي',
            'OM' => 'ريال عماني',
            'QA' => 'ريال قطري',
            'BH' => 'دينار بحريني',
        ];
        return $map[$code] ?? 'دولار أمريكي';
    }

    public function getCurrencyNameEnAttribute()
    {
        $code = strtoupper($this->code);
        $map = [
            'EG' => 'EGP',
            'SA' => 'SAR',
            'JO' => 'JOD',
            'AE' => 'AED',
            'KW' => 'KWD',
            'OM' => 'OMR',
            'QA' => 'QAR',
            'BH' => 'BHD',
        ];
        return $map[$code] ?? 'USD';
    }

    public function landmarks(): HasMany
    {
        return $this->hasMany(ArabLandmark::class, 'country_id');
    }
}
