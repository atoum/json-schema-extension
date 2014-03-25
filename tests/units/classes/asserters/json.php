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
			->testedClass
				->isSubClassOf('mageekguy\atoum\asserters\string')
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
					->hasMessage(sprintf('%s is not a valid JSON string', $asserter->getTypeOf($value)))
				->object($asserter->setWith(json_encode(array())))->isIdenticalTo($asserter)
		;
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
			->given(
				$json = $this->getJsonData()
			)
			->if($asserter->setWith($json))
			->then
				->object($asserter->validates('{"title": "test", "type": "array"}'))->isIdenticalTo($asserter)
		;
	}

	protected function getJsonData()
	{
		$sampler = $this->getJsonSampler();

		foreach($sampler as $i => $data)
		{
			return $data;
		}

		return null;
	}

	protected function getJsonSampler()
	{
		return new \Hoa\Compiler\Llk\Sampler\BoundedExhaustive(
			\Hoa\Compiler\Llk\Llk::load(new \Hoa\File\Read(__DIR__ . '/../../../resources/json.pp')),
			new \Hoa\Regex\Visitor\Isotropic(new \Hoa\Math\Sampler\Random()),
			15
		);
	}
}