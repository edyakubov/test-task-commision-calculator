<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use src\Services\CommissionCalculationService;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$inputFile = $argv[1] ?? $a_variable ?? null;

if ($inputFile === null) {
    die("Usage: php refactored.php <input_file>\n");
}

$recalculation = new CommissionCalculationService($inputFile, new src\Services\External\ExchangeRatesApiService(), new src\Services\External\BinlistService());

$result = $recalculation->process();

foreach ($result as $value) {
    echo $value;
    print "\n";
}
