<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $fillable = ['user_id', 'session_token', 'is_human_mode', 'is_closed'];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'session_id', 'session_token');
    }
}
