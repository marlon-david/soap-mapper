<?php

require '../vendor/autoload.php';

$mapper = new SoapMapper\SoapMapper('http://www.webservicex.net/CurrencyConvertor.asmx?WSDL');

$mapper->setClientDir('CurrencyConvertor'); // Pasta para a classe principal

$mapper->setTypesDir('CurrencyConvertor/Types'); // Pasta para as classes de retornos e parâmetros

$mapper->setClientNamespace('CurrencyConvertor'); // Namespace para a classe principal

$mapper->setTypesNamespace('CurrencyConvertor\\Types'); // Namespace para as classes retorno/parâmetro

$mapper->setClientName('CurrencyConvertor'); // Nome da classe principal

$mapper->setIndentation('tab'); // Identação (default: 4 [espaços]): 2 | 4 | 'tab'

$mapper->setOverwrite(true); // substituir arquivos existentes?

try {
	$mapper->generate(); // Gerar arquivos
} catch (Exception $e) {
	echo $e->getMessage();
}