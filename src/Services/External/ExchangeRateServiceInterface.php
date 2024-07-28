<?php

namespace src\Services\External;

interface ExchangeRateServiceInterface
{
    public function process(): array;
}