<?php
namespace SoapMapper;

class Functions
{
	public $functions = array();

	public function proccessFunctions(array $functions)
	{
		foreach ($functions as $function) {
			preg_match_all('/[ \t\r\n]*[ \t\r\n]?(.+)[ \t\r\n]*\(([^\)]*)\)/', $function, $matches);

			list($returnType, $functionName) = explode(' ', $matches[1][0]);
			list($paramType, $paramName) = explode(' ', $matches[2][0]);

			$this->functions[$functionName] = array(
					'returnType'   => $returnType,
					'functionName' => $functionName,
					'paramType'    => $paramType,
					'paramName'    => $paramName
				);
		}
	}
}