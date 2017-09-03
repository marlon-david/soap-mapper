<?php

$loader = require '../vendor/autoload.php';

/*
	GERAR MAPPER
*/

$mapper = new SoapMapper\SoapMapper('http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl');

$mapper->setClientDir('AWSECommerceService');
$mapper->setTypesDir('AWSECommerceService/Types');
$mapper->setClientNamespace('AWSECommerceService');
$mapper->setTypesNamespace('AWSECommerceService\\Types');
$mapper->setClientName('AWSECommerceService');
// $mapper->setIndentation('tab');
$mapper->setOverwrite(true);

try {
	$mapper->generate();
} catch (Exception $e) {
	echo $e->getMessage();
}

/*
	UTILIZAR MAPPER
*/

$loader->addPsr4('AWSECommerceService\\', __DIR__ . '/AWSECommerceService');

use AWSECommerceService\AWSECommerceService;

try {
	$client = new AWSECommerceService;

	// ...

} catch (Exception $e) {
	echo $e->getMessage();
}