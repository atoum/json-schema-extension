<?php

use mageekguy\atoum;
use mageekguy\atoum\scripts;

if (defined('mageekguy\atoum\scripts\runner') === true && version_compare(constant('mageekguy\atoum\version'), '2.9.0-beta', '>=') === true) {
    scripts\runner::addConfigurationCallable(function(atoum\configurator $script, atoum\runner $runner) {
        $extension = new atoum\jsonSchema\extension($script);

        $extension->addToRunner($runner);
    });
}
