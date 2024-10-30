<?php

namespace app\components;

use GuzzleHttp\Client;

class GroqApiClient
{
    private $apiEndpoint = 'https://api.groq.io/v1';
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = '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'; // Replace with your actual Groq API key
    }

    public function executeQuery($query)
    {
        $client = new Client(['timeout' => 240]); // Increase to 120 seconds

        $response = $client->post($this->apiEndpoint . '/query', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'query' => $query,
            ],
        ]);

        if ($response->getStatusCode() != 200) {
            throw new \Exception("Error: Unable to fetch data from Groq.");
        }

        return json_decode($response->getBody(), true);
    }
}
