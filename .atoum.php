<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoloader.php';

use
	mageekguy\atoum\jsonSchema,
	Atoum\PraspelExtension
;

$runner
	->addExtension(new jsonSchema\extension($script))
	->addExtension(new PraspelExtension\Manifest())
;

$script->noCodeCoverageForNamespaces('mageekguy\atoum\asserters');
$script->noCodeCoverageForClasses('mageekguy\atoum\asserter');
