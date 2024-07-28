<?php

namespace src\DTO;

class Transaction implements \JsonSerializable
{
    private string $bin;
    private string $amount;
    private string $currency;

    public function __construct($bin, $amount, $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function fromString($row): self
    {
        $data = json_decode($row, true);
        return new self($data['bin'], $data['amount'], $data['currency']);
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'bin' => $this->bin,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
