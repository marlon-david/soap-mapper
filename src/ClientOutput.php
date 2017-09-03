<?php
namespace SoapMapper;

class ClientOutput
{
	public $types;

	public $functions;

	protected $output;

	protected $clientNamespace;

	protected $typesNamespace;

	protected $indentation = '    ';

	protected $name;

	protected $url;

	public function __construct($name, Types $types, Functions $functions)
	{
		$this->name = $name;
		$this->types = $types;
		$this->functions = $functions;
	}

	public function generate()
	{
		if ($this->typesNamespace) {
			$this->typesNamespace = '\\' . $this->typesNamespace;
		}

		$this->output = '<' . '?php' . "\n";

		if ($this->clientNamespace) {
			$this->output .= 'namespace ' . trim($this->clientNamespace, '\\') . ';';
			$this->output .= "\n";
		}

		$this->output .= "\n";
		$this->output .= 'class ' . $this->name . "\n";
		$this->output .= '{' . "\n";

		$this->line('protected $url = \'' . $this->url . '\';');
		$this->output .= "\n";

		$this->line('protected $soap;');
		$this->output .= "\n";

		$this->line('public function __construct()');
		$this->line('{');
		$this->line('$this->soap = new \SoapClient($this->url, array(', 2);
		$this->line('\'exceptions\' => 1,', 3);

		if ($this->types->classes) {
			$this->line('\'classmap\' => array(', 3);

			foreach ($this->types->classes as $class => $params) {
				$this->line('\'' . $class . '\' => \'' . addslashes($this->typesNamespace . $class) . '\',', 4);
			}

			$this->line(')', 3);
		}

		$this->line('));', 2);
		$this->line('}');
		$this->output .= "\n";

		foreach ($this->functions->functions as $function) {
			$returnType = $this->types->convert($function['returnType'], $this->typesNamespace);
			$paramType = $this->types->convert($function['paramType'], $this->typesNamespace);

			$this->line('/**');
			$this->line(' * ' . $function['functionName']);
			$this->line(' *');
			$this->line(' * @param ' . $paramType . ' ' . $function['paramName']);
			$this->line(' *');
			$this->line(' * @throws \\SoapFault');
			$this->line(' *');
			$this->line(' * @return ' . $returnType);
			$this->line(' */');
			$this->line('public function ' . $function['functionName'] . '(' . $function['paramName'] . ')');
			$this->line('{');
			$this->line('return $this->soap->__soapCall(\'' . $function['functionName'] . '\', (array)' . $function['paramName'] . ');', 2);
			$this->line('}');
			$this->output .= "\n";
		}

		$this->output .= '}' . "\n";

		return $this->output;
	}

	protected function line($str, $indent = 1)
	{
		for ($i = 1; $i <= $indent; $i++) {
			$str = $this->indentation . $str;
		}

		$this->output .= $str . "\n";
	}

	public function getOutput()
	{
		return $output;
	}

	public function setIndentation($indentation)
	{
		$this->indentation = $indentation;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function setTypesNamespace($typesNamespace)
	{
		$this->typesNamespace = $typesNamespace;
	}

	public function setClientNamespace($clientNamespace)
	{
		$this->clientNamespace = $clientNamespace;
	}
}