<?php

namespace src\Services;

use src\DTO\Transaction;

class TransactionParser
{
    /**
     * @return array<Transaction>
     */
    public function parse(string $path): array
    {
        $file = file_get_contents($path);
        $records = explode("\n", $file);
        $objects = array_map([Transaction::class, 'fromString'], $records);
        return $objects;
    }
}