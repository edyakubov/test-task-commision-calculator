<?php

namespace src\Services\External;

interface TransactionInfoInterface
{
    public function process(int $bin): array;
}