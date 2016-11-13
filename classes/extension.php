<?php

namespace mageekguy\atoum\jsonSchema;

use mageekguy\atoum;
use mageekguy\atoum\observable;
use mageekguy\atoum\runner;
use mageekguy\atoum\test;

class extension implements atoum\extension
{
	public function __construct(atoum\configurator $configurator = null)
	{
		if ($configurator)
		{
			$parser = $configurator->getScript()->getArgumentsParser();

			$handler = function($script, $argument, $values) {
				$script->getRunner()->addTestsFromDirectory(dirname(__DIR__) . '/tests/units/classes');
			};

			$parser
				->addHandler($handler, array('--test-ext'))
				->addHandler($handler, array('--test-it'))
			;
		}
	}

	public function addToRunner(runner $runner)
	{
		$runner->addExtension($this);

		return $this;
	}

	public function setRunner(runner $runner)
	{
		return $this;
	}

	public function setTest(test $test)
	{
		$asserter = null;

		$test->getAssertionManager()
			->setHandler(
				'json',
				function($json, $depth = null, $options = null) use ($test, & $asserter) {
					if ($asserter === null)
					{
						$asserter = new atoum\jsonSchema\asserters\json($test->getAsserterGenerator());
					}

					return $asserter->setWith($json, $depth, $options);
				}
			)
		;

		return $this;
	}

	public function handleEvent($event, observable $observable) {}
} 
