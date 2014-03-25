<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use
	mageekguy\atoum\jsonSchema,
	Atoum\PraspelExtension,
	mageekguy\atoum\instrumentation\stream\cache
;

cache::setCacheDirectory('/tmp');

$runner
	->disableXDebugCodeCoverage()
	->enableInstrumentation()
		->disableMoleInstrumentation()
	->addExtension(new jsonSchema\extension($script))
	->addExtension(new PraspelExtension\Manifest())
;
