<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use GuzzleHttp\Client;

class ChatbotController extends Controller
{
    private $client;
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        // Initialize Guzzle client
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'verify' => \Yii::getAlias('@app/config/cacert.pem/cacert.pem'),
            'headers' => [
                'Authorization' => 'Bearer ' . 'my_api_key',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function actionAskAsli()
    {
        // Log the raw body for debugging purposes
        Yii::debug("Raw request body: " . Yii::$app->request->getRawBody(), __METHOD__);

        // Parse JSON manually if needed
        $rawData = json_decode(Yii::$app->request->getRawBody(), true);
        $question = $rawData['question'] ?? '';

        $responseText = 'Sorry, I could not generate a response.';

        if ($question) {
            try {
                $response = $this->client->post('chat/completions', [
                    'json' => [
                        'model' => 'gpt-4',
                        'messages' => [
                            ['role' => 'user', 'content' => $question]
                        ],
                        'max_tokens' => 100,
                        'temperature' => 0.7,
                    ],
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                if (isset($data['choices'][0]['message']['content'])) {
                    $responseText = $data['choices'][0]['message']['content'];
                } else {
                    $responseText = "Unexpected API response structure: " . json_encode($data);
                }
            } catch (\Exception $e) {
                $responseText = "API request failed: " . $e->getMessage();
            }
        } else {
            $responseText = "No question provided";
        }

        return $this->asJson(['response' => trim($responseText)]);
    }

    public function actionAsk()
    {
        // Log the raw body for debugging purposes
        Yii::debug("Raw request body: " . Yii::$app->request->getRawBody(), __METHOD__);

        // Parse JSON manually if needed
        $rawData = json_decode(Yii::$app->request->getRawBody(), true);
        $question = $rawData['question'] ?? '';

        $responseText = 'Sorry, I could not generate a response.';

        if ($question) {
            if (stripos($question, 'tes') !== false) {
                $responseText = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
            } else {
                // Otherwise, proceed with the OpenAI API request
                // ...
            }
        } else {
            $responseText = "No question provided";
        }

        return $this->asJson(['response' => trim($responseText)]);
    }
}
