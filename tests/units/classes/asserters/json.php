<?php

namespace mageekguy\atoum\jsonSchema\tests\units\asserters;

use
	mageekguy\atoum,
	mageekguy\atoum\jsonSchema\asserters\json as testedClass
;

class json extends atoum\test
{
	public function testClass()
	{
		$this
			->given(
				$namespace = 'mageekguy\\atoum\\asserters',
				$className = class_exists($namespace . '\\phpString') ? 'phpString' : 'string'
			)
			->then
				->testedClass->isSubClassOf($namespace . '\\' . $className)
		;
	}

	public function testSetWith()
	{
		$this
			->given(
				$test = $this,
				$string = $this->realdom->regex('/[a-z]+/')
			)
			->if($asserter = new testedClass())
			->then
				->exception(function() use ($asserter, & $value, $test, $string) {
						$asserter->setWith($value = $test->sample($string));
					}
				)
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage(sprintf('%s is not a valid JSON string', $asserter))
		;
	}

	public function testSetWithJsonGrammar($json)
	{
		$this
			->assert($json)
			->if($asserter = new testedClass())
			->then
				->object($asserter->setWith($json))->isIdenticalTo($asserter)
		;
	}

	protected function testSetWithJsonGrammarDataProvider()
	{
		return $this->sampleMany($this->realdom->grammar(__DIR__ . '/../../../resources/json.pp'));
	}

	public function testValidates()
	{
		$this
			->given(
				$test = $this,
				$string = $this->realdom->regex('/[a-z]+/')
			)
			->if($asserter = new testedClass())
			->then
				->exception(function() use ($asserter, $test, $string) {
						$asserter->validates($test->sample($string));
					}
				)
					->isInstanceOf('mageekguy\atoum\exceptions\logic\invalidArgument')
					->hasMessage('Invalid JSON schema')
				->exception(function() use ($asserter) {
						$asserter->validates('{"title": "test", "type": "array"}');
					}
				)
					->isInstanceOf('mageekguy\atoum\exceptions\logic')
					->hasMessage('JSON is undefined')
		;
	}

	public function testValidatesJsonArrayGrammar($json)
	{
		$this
			->assert($json)
			->if($asserter = new testedClass())
			->then
				->object($asserter->setWith($json))->isIdenticalTo($asserter)
				->object($asserter->validates('{"title": "test", "type": "array"}'))->isIdenticalTo($asserter)
		;
	}

	protected function testValidatesJsonArrayGrammarDataProvider()
	{
		return $this->sampleMany($this->realdom->grammar(__DIR__ . '/../../../resources/json/array.pp'));
	}

	public function testNotValidatesJsonArrayGrammar($json)
	{
		$this
			->assert($json)
			->if($asserter = new testedClass())
			->then
				->object($asserter->setWith($json))->isIdenticalTo($asserter)
				->exception(function() use ($asserter) {
						$asserter->validates('{"title": "test", "type": "array"}');
					}
				)
		;
	}

	protected function testNotValidatesJsonArrayGrammarDataProvider()
	{
		return $this->sampleMany($this->realdom->grammar(__DIR__ . '/../../../resources/json/noarray.pp'));
	}
}
