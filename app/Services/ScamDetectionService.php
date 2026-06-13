<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ScamDetectionService
{
    public function calculateRisk(string $message): array
    {
        $response = Http::withToken(env('HF_API_KEY'))
            ->post('https://router.huggingface.co/v1/chat/completions', [
                'model' => 'deepseek-ai/DeepSeek-V3',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Return only JSON:
                    {
                        "risk_score": 0-100,
                        "category": "phishing | bank scam | lottery scam | other"
                    }'
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ]
            ]);

        $content = $response['choices'][0]['message']['content'] ?? '{}';

        preg_match('/\{.*\}/s', $content, $matches);

        $decoded = json_decode($matches[0] ?? '{}', true);

        return [
            'risk_score' => $decoded['risk_score'] ?? 0,
            'category' => $decoded['category'] ?? 'other',
        ];
    }
}
