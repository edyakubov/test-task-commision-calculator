<?php

namespace Tests;

use Faker\Factory;
use Faker\Extension\GeneratorAwareExtensionTrait;
use PHPUnit\Framework\TestCase;
use src\Services\CommissionCalculationService;
use src\Services\External\BinlistService;
use src\Services\External\ExchangeRatesApiService;

class CommissionCalculationServiceTest extends TestCase
{
    use GeneratorAwareExtensionTrait;


    protected function setUp(): void
    {
        parent::setUp();
        $this->generator = Factory::create();
    }

    public function testSucceedProcess()
    {
        $path = 'input.txt';

        // Mock ExchangeRatesApiService
        $exchangeRatesApiService = $this->createMock(ExchangeRatesApiService::class);
        $exchangeRatesApiService->method('process')->willReturn([
            'rates' => [
                'EUR' => 1,
                'USD' => 1.087251,
                'JPY' => 167.148649,
                'GBP'=> 0.845748
            ]
        ]);

        // Mock BinlistService
        $binlistService = $this->createMock(BinlistService::class);
        $binlistService->method('process')->willReturn([
            'country' => [
                'alpha2' => $this->generator->countryCode()
            ]
        ]);

        $service = new CommissionCalculationService($path, $exchangeRatesApiService, $binlistService);
        $result = $service->process();

        $this->assertIsArray($result);
    }
}