<?php

$loader = require '../vendor/autoload.php';

$loader->addPsr4('CurrencyConvertor\\', __DIR__ . '/CurrencyConvertor');

use CurrencyConvertor\CurrencyConvertor;
use CurrencyConvertor\Types\ConversionRate;

echo '<pre>';

try {
	$client = new CurrencyConvertor;

	$param = new ConversionRate;
	$param->FromCurrency = 'BRL';
	$param->ToCurrency = 'USD';

	var_dump($client->ConversionRate($param));

} catch (Exception $e) {
	echo $e->getMessage();
}

echo '</pre>';