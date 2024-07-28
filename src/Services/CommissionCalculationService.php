<?php

namespace src\Services;

use src\Services\External\ExchangeRateServiceInterface;
use src\Services\External\TransactionInfoInterface;

class CommissionCalculationService
{
    const COMMISSION_EU = 0.01;
    const COMMISSION_NON_EU = 0.02;

    private TransactionParser $fileParser;
    private CountryChecker $countryChecker;
    private ExchangeRateServiceInterface $exchangeRatesApiService;
    private TransactionInfoInterface $binlistService;
    private string $path;

    public function __construct(
        string                       $path,
        ExchangeRateServiceInterface $exchangeRatesApiService,
        TransactionInfoInterface     $binlistService)
    {
        $this->fileParser = new TransactionParser();
        $this->countryChecker = new CountryChecker();
        $this->exchangeRatesApiService = $exchangeRatesApiService;
        $this->binlistService = $binlistService;
        $this->path = $path;
    }

    public function process(): array
    {
        $result = [];
        $transactions = $this->fileParser->parse($this->path);
        $exchangeRates = $this->exchangeRatesApiService->process();

        foreach ($transactions as $transaction) {

            $binResults = $this->binlistService->process($transaction->getBin());

            $isEu = $this->countryChecker->isEu($binResults['country']['alpha2']);

            $rate = $exchangeRates['rates'][$transaction->getCurrency()];

            if ($transaction->getCurrency() !== 'EUR' && $rate > 0) {
                $amntFixed = $transaction->getAmount() / $rate;
            } else {
                $amntFixed = $transaction->getAmount();
            }
            $result[] = round($amntFixed * ($isEu ? self::COMMISSION_EU : self::COMMISSION_NON_EU), 2);
        }
        return $result;
    }
}