<?php

namespace app\components;

use GuzzleHttp\Client;

class OpenAiClient
{
    private $client;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => \Yii::getAlias('@app/config/cacert.pem/cacert.pem'),
        ]);
        $this->apiKey = 'my_api_key'; // Replace with your actual API key
    }

    public function generateInsight($data)
    {
        $prompt = "Provide a detailed insight based on the following data: " . json_encode($data);

        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an AI that provides insights based on data, in Bahasa Indonesia.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 500,  // Increase tokens for a longer response, default: 150
                'temperature' => 0.7,
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody['choices'][0]['message']['content'] ?? 'No insight generated.';
    }
}
