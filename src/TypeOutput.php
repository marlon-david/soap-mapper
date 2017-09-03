<?php
namespace SoapMapper;

class TypeOutput
{
	protected $types;

	protected $params;

	protected $output;

	protected $typesNamespace;

	protected $indentation = '    ';

	protected $name;

	public function __construct($name, Types $types)
	{
		$this->name = $name;
		$this->types = $types;
	}

	public function generate()
	{
		$this->output = '<' . '?php' . "\n";

		if ($this->typesNamespace) {
			$this->output .= 'namespace ' . trim($this->typesNamespace, '\\') . ';';
			$this->output .= "\n";
		}

		$this->output .= "\n";

		$this->output .= 'class ' . $this->name . "\n";
		$this->output .= '{' . "\n";

		$this->params = $this->types->classes[$this->name];

		foreach ($this->params as $param) {
			$type = $this->types->convert($param['type'], $this->typesNamespace);

			$this->line('/**');
			$this->line(' * @var ' . $type . ' $' . $param['name']);
			$this->line(' */');
			$this->line('public $' . $param['name'] . ';');
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

	public function setTypesNamespace($typesNamespace)
	{
		$this->typesNamespace = $typesNamespace;
	}
}