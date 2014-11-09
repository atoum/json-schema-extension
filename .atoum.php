<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use
	mageekguy\atoum\jsonSchema,
	Atoum\PraspelExtension
;


$runner
	->addExtension(new jsonSchema\extension($script))
	->addExtension(new PraspelExtension\Manifest())
;
