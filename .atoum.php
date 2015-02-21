<?php

use Atoum\PraspelExtension;

$runner
	->addExtension(new PraspelExtension\Manifest())
;

$script->noCodeCoverageForNamespaces('mageekguy\atoum\asserters');
$script->noCodeCoverageForClasses('mageekguy\atoum\asserter');
