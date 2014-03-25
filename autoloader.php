<?php

namespace mageekguy\atoum\jsonSchema;

use mageekguy\atoum;

atoum\autoloader::get()
	->addNamespaceAlias('atoum\jsonSchema', __NAMESPACE__)
	->addDirectory(__NAMESPACE__, __DIR__ . DIRECTORY_SEPARATOR . 'classes');
;