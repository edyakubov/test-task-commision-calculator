<?php

namespace src\Services\External;

use GuzzleHttp\Client;

class ExchangeRatesApiService implements ExchangeRateServiceInterface
{
    protected const EXCHANGERATES_API = 'http://api.exchangeratesapi.io/v1/latest';
    private string $apiKey;
    private readonly Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = $_ENV['EXCHANGERATES_API_KEY'] ?? '';
    }

    public function process(): array
    {
        return json_decode($this->makeGetRequest(), true);
    }

    private function makeGetRequest()
    {
        try {
            return $this->client
                ->request('GET', self::EXCHANGERATES_API,
                    ['query' => ['access_key' => $this->apiKey]]
                )
                ->getBody()
                ->getContents();
        } catch (\Exception $e) {
            if ($e->getCode() === 401) {
                throw new \Exception('ExchangeRatesApiService::class, Invalid API key');
            }
            throw new \Exception('ExchangeRatesApiService::class, Error fetching exchange rates: '.$e->getMessage(), $e->getCode());
        }
    }
}