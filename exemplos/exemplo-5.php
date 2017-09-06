<?php

require '../vendor/autoload.php';

$mapper = new SoapMapper\SoapMapper('http://www.jamef.com.br/webservice/JAMW0520.apw?WSDL');

// GERAR AS CLASSES

$mapper->setClientDir('Jamef');
$mapper->setTypesDir('Jamef/Types');
$mapper->setClientNamespace('Jamef');
$mapper->setTypesNamespace('Jamef\\Types');
$mapper->setClientName('Jamef');
$mapper->setIndentation('tab');
$mapper->setOverwrite(true);

try {
	$mapper->generate();
} catch (Exception $e) {
	echo $e->getMessage();
}