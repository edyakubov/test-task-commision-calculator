<?php

$a_variable = "input.txt";
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/fakerphp/faker/src/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();