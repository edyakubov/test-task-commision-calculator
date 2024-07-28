<?php

namespace src\Services\External;

use GuzzleHttp\Client;

class BinlistService implements TransactionInfoInterface
{
    private const BINLIST_API = 'https://lookup.binlist.net/';
    private Client $client;
    private null $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = null;
    }

    public function process(int $bin): array
    {
        return json_decode($this->makeGetRequest($bin), true);
    }


    private function makeGetRequest(int $bin): string
    {
        try {
            return $this->client
                ->request('GET', self::BINLIST_API . $bin,
                    ['query' => ['access_key' => $this->apiKey]]
                )
                ->getBody()
                ->getContents();
        } catch (\Exception $e) {
            throw new \Exception('Error fetching exchange rates:' . $e->getMessage(), $e->getCode());
        }
    }
}