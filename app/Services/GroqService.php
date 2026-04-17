<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY', '');
    }

    /**
     * Send a prompt to Groq with system context and conversation history.
     */
    public function ask(string $prompt, string $systemContext = '', array $history = [])
    {
        $messages = [
            [
                'role' => 'system',
                'content' => $systemContext
            ]
        ];

        // Append chat history (only last 6 messages to save tokens and prevent overload)
        $recentHistory = array_slice($history, -6);
        foreach ($recentHistory as $msg) {
            $messages[] = [
                'role' => isset($msg['role']) ? $msg['role'] : 'user',
                'content' => isset($msg['content']) ? $msg['content'] : ''
            ];
        }

        // Lastly, append the new user prompt
        $messages[] = [
            'role' => 'user',
            'content' => $prompt
        ];

        $payload = [
            'model' => 'llama-3.1-8b-instant',
            'messages' => $messages,
            'temperature' => 0.5,
        ];

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['choices'][0]['message']['content'])) {
                    return $data['choices'][0]['message']['content'];
                }
                return "Groq Structure Error: " . json_encode($data);
            }
            return "Groq Connection Error (HTTP " . $response->status() . "): " . $response->body();
        } catch (\Exception $e) {
            return "System Exception: " . $e->getMessage();
        }
    }
}
