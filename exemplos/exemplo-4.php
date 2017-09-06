<?php

require '../vendor/autoload.php';

$mapper = new SoapMapper\SoapMapper('http://www.jamef.com.br/webservice/JAMW1066.apw?WSDL');

// GERAR AS CLASSES

$mapper->setClientDir('JamefRastreio');
$mapper->setTypesDir('JamefRastreio/Types');
$mapper->setClientNamespace('JamefRastreio');
$mapper->setTypesNamespace('JamefRastreio\\Types');
$mapper->setClientName('JamefRastreio');
$mapper->setIndentation('tab');
$mapper->setOverwrite(true);

try {
	$mapper->generate();
} catch (Exception $e) {
	echo $e->getMessage();
}