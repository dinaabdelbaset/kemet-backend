<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bazaar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'location', 'image', 'description', 'specialty',
        'status', 'action_type', 'rejection_reason'
    ];

    protected $casts = [
        'specialty' => 'array',
    ];
}
