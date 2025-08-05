<?php
namespace SmartPriceAdvisorBundle\Service;

use GuzzleHttp\Client;

class GPTPricingAdvisor
{
    private Client $client;
    private string $apiKey;

    public function __construct(string $openAiKey)
    {
        $this->apiKey = $openAiKey;
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
        ]);
    }

    public function getAdvice(array $productData): array
    {
        $prompt = $this->buildPrompt($productData);

        try {
            $response = $this->client->post('chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a pricing advisor for an e-commerce company.'],
                        ['role' => 'user', 'content' => $prompt],
                    ]
                ]
            ]);
        } catch (\Throwable $e) {
            return ['response' => 'Error contacting GPT service'];
        }

        $data = json_decode($response->getBody()->getContents(), true);

        if (!is_array($data) || empty($data['choices'][0]['message']['content'])) {
            return ['response' => 'Invalid response from GPT'];
        }

        return [
            'response' => $data['choices'][0]['message']['content']
        ];
    }

    private function buildPrompt(array $data): string
    {
        return <<<EOD
We sell this product:
- Brand: {$data['brand']}
- Model: {$data['model']}
- UPC: {$data['upc']}
- Category: {$data['category']}
- Our current price: \${$data['price']}

What are the current competitor prices in North America for this model (Amazon, Guitar Center, Sweetwater, Long & McQuade, etc.)? The prices must be current. Do not make anything up or hallucinate the pricing data.

Please return:
- A list of 3–5 competitors, their prices (in CAD), and a brief availability status.
- A recommended competitive price for our store (in CAD).
- A short rationale for the recommendation.
EOD;
    }
}
