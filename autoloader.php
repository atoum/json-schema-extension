<?php

namespace mageekguy\atoum\jsonSchema;

use mageekguy\atoum;

$vendorDirectory = __DIR__ . '/vendor';

if (is_dir($vendorDirectory) === false)
{
	$vendorDirectory = __DIR__ . '/../..';
}

atoum\autoloader::get()
	->addNamespaceAlias('atoum\jsonSchema', __NAMESPACE__)
	->addDirectory(__NAMESPACE__, __DIR__ . '/classes')
	->addDirectory('JsonSchema', $vendorDirectory . '/justinrainbow/json-schema/src/JsonSchema')
;

require_once __DIR__ . '/tests/autoloader.php';
