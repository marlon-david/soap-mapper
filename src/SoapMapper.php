<?php
namespace SoapMapper;

use Exception;
use SoapClient;

class SoapMapper
{
	protected $soap;

	protected $url;

	protected $clientName;

	protected $clientDir;

	protected $typesDir;

	protected $clientNamespace;

	protected $typesNamespace;

	protected $indentation = 4;

	protected $overwrite = false;

	public function __construct($url = '')
	{
		$this->url = $url;
	}

	protected function loadSoapClient()
	{
		if (!$this->url) {
			throw new Exception('URL não informada');
		}

		if (!$this->soap) {
			$this->soap = new SoapClient($this->url, array('exceptions' => 1));
		}
	}

	public function generate()
	{
		if (empty($this->clientName)) {
			throw new Exception('Por favor, informe o clientName');
		}

		if (empty($this->clientDir)) {
			$this->clientDir = $this->clientName;
		}

		if (empty($this->typesDir)) {
			$this->typesDir = rtrim($this->clientDir, '/') . '/Types';
		}

		if (!is_dir($this->clientDir)) {
			throw new Exception('clientDir não é um diretório válido');
		}

		if (!is_dir($this->typesDir)) {
			throw new Exception('typesDir não é um diretório válido');
		}

		$this->loadSoapClient();

		$types = new Types();
		$types->proccessTypes($this->soap->__getTypes());

		$functions = new Functions();
		$functions->proccessFunctions($this->soap->__getFunctions());

		if ($this->clientNamespace) {
			$this->clientNamespace = trim($this->clientNamespace, '\\') . '\\';
		}

		if ($this->typesNamespace) {
			$this->typesNamespace = trim($this->typesNamespace, '\\') . '\\';
		}

		switch ($this->indentation) {
			case 'tab':
				$indentation = "\t";
				break;

			case 2:
				$indentation = '  ';
				break;

			case 4:
				$indentation = '    ';
				break;

			default:
				$indentation = '    ';
				break;
		}

		$client = new ClientOutput($this->clientName, $types, $functions);
		$client->setIndentation($indentation);
		$client->setUrl($this->url);
		$client->setClientNamespace($this->clientNamespace);
		$client->setTypesNamespace($this->typesNamespace);

		$this->clientDir = rtrim($this->clientDir, '/') . '/';

		$file = $this->clientDir . $this->clientName . '.php';

		if (!file_exists($file) || $this->overwrite) {
			$h = fopen($file, 'w');
			fwrite($h, $client->generate());
			fclose($h);
		}

		$typeOutput = new TypeOutput('', $types);
		$typeOutput->setIndentation($indentation);
		$typeOutput->setTypesNamespace($this->typesNamespace);

		$this->typesDir = rtrim($this->typesDir, '/') . '/';

		foreach ($types->classes as $class => $params) {
			$typeOutput->setName($class);

			$file = $this->typesDir . $class . '.php';

			if (!file_exists($file) || $this->overwrite) {
				$h = fopen($file, 'w');
				fwrite($h, $typeOutput->generate());
				fclose($h);
			}
		}
	}

	public function setClientName($clientName)
	{
		$this->clientName = $clientName;
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function setTypesDir($typesDir)
	{
		$this->typesDir = $typesDir;
	}

	public function setClientDir($clientDir)
	{
		$this->clientDir = $clientDir;
	}

	public function setTypesNamespace($typesNamespace)
	{
		$this->typesNamespace = $typesNamespace;
	}

	public function setClientNamespace($clientNamespace)
	{
		$this->clientNamespace = $clientNamespace;
	}

	public function setIndentation($indentation)
	{
		$this->indentation = $indentation;
	}

	public function setOverwrite($overwrite)
	{
		$this->overwrite = $overwrite;
	}
}