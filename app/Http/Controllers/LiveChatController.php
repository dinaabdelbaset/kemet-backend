<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiveChatController extends Controller
{
    public function getActiveSessions()
    {
        $sessions = \App\Models\ChatSession::where('is_human_mode', true)
                        ->where('is_closed', false)
                        ->orderBy('updated_at', 'desc')
                        ->get();
        return response()->json($sessions);
    }

    public function getSessionMessages($sessionToken)
    {
        $messages = \App\Models\ChatMessage::where('session_id', $sessionToken)
                        ->orderBy('created_at', 'asc')
                        ->get()
                        ->map(function($msg) {
                            $sender = 'bot';
                            if ($msg->role === 'user') $sender = 'user';
                            if ($msg->role === 'admin') $sender = 'admin';
            
                            return [
                                'id' => $msg->id,
                                'sender' => $sender,
                                'text' => $msg->content,
                                'created_at' => $msg->created_at
                            ];
                        });
        return response()->json($messages);
    }

    public function replyToSession(Request $request, $sessionToken)
    {
        $request->validate(['message' => 'required|string']);

        $session = \App\Models\ChatSession::where('session_token', $sessionToken)->firstOrFail();
        
        $msg = \App\Models\ChatMessage::create([
            'session_id' => $sessionToken,
            'user_id' => null,
            'role' => 'admin',
            'content' => $request->message
        ]);

        $session->touch();

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function closeSession($sessionToken)
    {
        $session = \App\Models\ChatSession::where('session_token', $sessionToken)->firstOrFail();
        $session->update([
            'is_human_mode' => false,
            'is_closed' => true
        ]);
        
        \App\Models\ChatMessage::create([
            'session_id' => $sessionToken,
            'user_id' => null,
            'role' => 'admin',
            'content' => 'تم إنهاء المحادثة. شكراً لتواصلك معنا.'
        ]);

        return response()->json(['success' => true]);
    }
}
