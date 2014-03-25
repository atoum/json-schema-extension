<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$runner->addExtension(new \mageekguy\atoum\jsonSchema\extension($script));
$runner->addExtension(new Atoum\PraspelExtension\Manifest());
