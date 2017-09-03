<?php

require '../vendor/autoload.php';

$mapper = new SoapMapper\SoapMapper('http://www.webservicex.net/globalweather.asmx?WSDL');

// GERAR AS CLASSES

// $mapper->setClientDir('AWSECommerceService');
// $mapper->setTypesDir('AWSECommerceService/Types');
$mapper->setClientNamespace('globalweather');
$mapper->setTypesNamespace('globalweather\\Types');
$mapper->setClientName('globalweather');
$mapper->setIndentation(2);
$mapper->setOverwrite(false);

try {
	$mapper->generate();
} catch (Exception $e) {
	echo $e->getMessage();
}