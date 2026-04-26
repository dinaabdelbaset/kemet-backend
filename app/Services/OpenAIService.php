<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY', '');
    }

    public function ask(string $prompt, string $systemContext = '', array $history = [])
    {
        $messages = [
            [
                'role' => 'system',
                'content' => $systemContext
            ]
        ];

        // Append chat history
        $recentHistory = array_slice($history, -8);
        foreach ($recentHistory as $msg) {
            $messages[] = [
                'role' => isset($msg['role']) ? $msg['role'] : 'user',
                'content' => isset($msg['content']) ? $msg['content'] : ''
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $prompt
        ];

        $payload = [
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
            'temperature' => 0.7,
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
                return "OpenAI Structure Error: " . json_encode($data);
            }
            return "OpenAI Error (HTTP " . $response->status() . "): " . $response->body();
        } catch (\Exception $e) {
            return "System Exception: " . $e->getMessage();
        }
    }
}
