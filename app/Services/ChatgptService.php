<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ChatgptService
{
    protected string $model = 'gpt-3.5-turbo-instruct';
    protected int $maxToken = 4000;
    protected float $temperature = 0.6;

    public function __construct()
    {
        $this->api = config('services.openai.api');
        $this->token = config('services.openai.token');
    }
    
    public function generateVideoScript(string $prompt): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json'
        ];
        $data = [
            'model' => $this->model,
            'prompt' => $prompt,
            'max_tokens' => $this->maxToken,
            'temperature' => $this->temperature,
            'n' => 1
        ];

        $this->checkModeration($prompt, $headers);

        return Http::withHeaders($headers)
            ->post($this->api.'/v1/completions', $data)
            ->throw()
            ->json();
    }

    public function checkModeration(string $prompt, array $headers): void
    {
        $data = [
            'input' => $prompt
        ];

        $moderation = Http::withHeaders($headers)
            ->post($this->api.'/v1/moderations', $data)
            ->throw()
            ->json();

        if($moderation['results'][0]['flagged'] == true) {
            $categories = $moderation['results'][0]['categories'];
            $flagged = '';

            foreach($categories as $category) {
                if ($categories[$category] == true){
                    $flagged .= $category + ' ';
                }
            }

            throw new Exception("Your idea was flagged as {$flagged}. kindly adjust it and regenerate.", 1);
        }
    }
}