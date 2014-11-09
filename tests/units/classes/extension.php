<?php

namespace mageekguy\atoum\jsonSchema\tests\units;

use
	mageekguy\atoum,
	mageekguy\atoum\jsonSchema\extension as testedClass
;

class extension extends atoum\test
{
	public function testClass()
	{
		$this
			->testedClass
				->hasInterface('mageekguy\atoum\extension')
		;
	}

	public function test__construct()
	{
		$this
			->if($script = new atoum\scripts\runner(uniqid()))
			->and($script->setArgumentsParser($parser = new \mock\mageekguy\atoum\script\arguments\parser()))
			->and($configurator = new \mock\mageekguy\atoum\configurator($script))
			->then
				->object($extension = new testedClass())
			->if($this->resetMock($parser))
			->if($extension = new testedClass($configurator))
			->then
				->mock($parser)
					->call('addHandler')->twice()
		;
	}

	public function testSetRunner()
	{
		$this
			->if($extension = new testedClass())
			->and($runner = new atoum\runner())
			->then
				->object($extension->setRunner($runner))->isIdenticalTo($extension)
		;
	}

	public function testSetTest()
	{
		$this
			->if($extension = new testedClass())
			->and($test = new \mock\mageekguy\atoum\test())
			->and($manager = new \mock\mageekguy\atoum\test\assertion\manager())
			->and($test->setAssertionManager($manager))
			->then
				->object($extension->setTest($test))->isIdenticalTo($extension)
				->mock($manager)
					->call('setHandler')->withArguments('json')->once()
				->object($faker = $test->json('{}'))->isInstanceOf('mageekguy\atoum\jsonSchema\asserters\json')
		;
	}
}
