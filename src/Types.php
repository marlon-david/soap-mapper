<?php
namespace SoapMapper;

class Types
{
	public $types = array();

	public $classes = array();

	public function proccessTypes(array $types)
	{
		foreach ($types as $type) {
			preg_match_all('/(\w+) ([a-zA-Z0-9_\[\]]+)/', $type, $matches);

			$temp = array();

			foreach ($matches[1] as $key => $match) {
				if ($match == 'struct') {
					$className = $matches[2][$key];

					unset($matches[1][$key]);
					unset($matches[2][$key]);

					$this->proccessStruct($className, $matches[1], $matches[2]);
					break;
				} else {
					$this->types[$matches[2][$key]] = $match;
				}
			}
		}
	}

	protected function proccessStruct($className, array $types, array $names)
	{
		$params = array();

		foreach ($names as $key => $name) {
			$params[] = array(
				'type' => $types[$key],
				'name' => $name
			);
		}

		$this->classes[$className] = $params;
	}

	public function convert($type, $namespace = '')
	{
		if (isset($this->classes[$type])) {
			return $namespace . $type;
		}

		if (isset($this->types[$type])) {
			$type = $this->types[$type];
		}

		switch ($type) {
			case 'string':
			case 'bool':
			case 'boolean':
			case 'int':
			case 'integer':
				return $type;
				break;

			case 'positiveInteger':
				return 'int';
				break;

			case 'float':
			case 'double':
				return 'float';
				break;

			default:
				return 'mixed';
				break;
		}
	}
}