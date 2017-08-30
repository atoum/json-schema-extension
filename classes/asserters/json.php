<?php

namespace mageekguy\atoum\jsonSchema\asserters;

use JsonSchema;
use JsonSchema\Exception;
use mageekguy\atoum\asserters;
use mageekguy\atoum\exceptions;
use mageekguy\atoum\jsonSchema\retriever;

if (class_exists('mageekguy\atoum\asserters\phpString'))
{
	class stringAsserter extends asserters\phpString {}
}
else
{
	class stringAsserter extends asserters\string {}
}

if (class_exists('mageekguy\atoum\asserters\phpObject'))
{
	class objectAsserter extends asserters\phpObject {}
}
else
{
	class objectAsserter extends asserters\object {}
}

class json extends stringAsserter
{
	protected $innerAsserter;
	protected $data;

	function __get($name)
	{
		return $this->valueIsSet()->innerAsserter->$name;
	}

	public function __call($method, $arguments)
	{
		return call_user_func_array(array($this->valueIsSet()->innerAsserter, $method), $arguments);
	}

	public function setWith($value, $label = null, $charlist = null, $checkType = true)
	{
		parent::setWith($value, $label, $charlist, $checkType);

		if (self::isJson($value) === false)
		{
			$this->fail(sprintf($this->getLocale()->_('%s is not a valid JSON string'), $this));
		}

		$this->data = json_decode($value);

		switch (true)
		{
			case is_array($this->data):
				$this->innerAsserter = new asserters\phpArray($this->getGenerator());
				break;

			case is_object($this->data):
				$this->innerAsserter = new objectAsserter($this->getGenerator());
				break;

			default:
				$this->innerAsserter = new asserters\variable($this->getGenerator());
		}

		$this->innerAsserter->setWith($this->data);

		return $this;
	}

	public function validates($schema)
	{
		$schemaIsFile = true;
		$referencesRoot = null;
		$retriever = new JsonSchema\Uri\UriRetriever();

		if (is_file($schema) === false)
		{

			$retriever->setUriRetriever(new retriever($schema));
			$schemaIsFile = false;
			$schema = @json_decode($schema);
		}
		else
		{
			$referencesRoot = dirname($schema);
			$schema = $retriever->retrieve($schema);
		}

		if ($schema === null) {
			throw new exceptions\logic\invalidArgument('Invalid JSON schema');
		}

		if ($schemaIsFile === true)
		{
			$resolver = new JsonSchema\JsonStorage($retriever);
			$resolver->resolve($schema, 'file://' . $referencesRoot);
		}

		$validator = new JsonSchema\Validator();
		$validator->check($this->valueIsSet()->data, $schema);

		if ($validator->isValid() === true)
		{
			$this->pass();
		}
		else
		{
			$violations = $validator->getErrors();
			$count = sizeof($violations);
			$message = sprintf($this->getLocale()->__('JSON does not validate schema. Found %d violation:', 'JSON does not validate schema. Found %d violations:', $count), $count);

			foreach ($validator->getErrors() as $index => $error)
			{
				$message .= PHP_EOL . sprintf('[%d] %s: %s', $index + 1, $error['property'], $error['message']);
			}

			$this->fail($message);
		}

		return $this;
	}


	protected function valueIsSet($message = 'JSON is undefined')
	{
		return parent::valueIsSet($message);
	}

	protected static function isJson($value)
	{
		$decoded = @json_decode($value);

		return (
			error_get_last() === null &&
			($decoded !== null || strtolower(trim($value)) === 'null')
		);
	}
}
