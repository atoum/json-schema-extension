# atoum/json-schema-extension [![Build Status](https://travis-ci.org/atoum/json-schema-extension.svg?branch=master)](https://travis-ci.org/atoum/json-schema-extension)

![atoum](http://atoum.org/images/logo/atoum.png)

## Install it

Install extension using [composer](https://getcomposer.org):

```json
{
    "require-dev": {
        "atoum/json-schema-extension": "~1.0"
    },
}

```

Enable the extension using atoum configuration file:

```php
<?php

// .atoum.php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use mageekguy\atoum\jsonSchema;

$extension = new jsonSchema\extension($script);

$extension->addToRunner($runner);
```

## Use it

```php
<?php
namespace jubianchi\example\json;

use atoum;

class foo extends atoum\test
{
    public function testIsJson()
    {
        $this
            ->given($string = '{"foo": "bar"}')
            ->then
                ->json($string)
        ;
    }

    public function testValidatesSchema()
    {
        $this
            ->given($string = '["foo", "bar"]')
            ->then
                ->json($string)->validates('{"title": "test", "type": "array"}')
                ->json($string)->validates('/path/to/json.schema')
        ;
    }
}
```

## License
json-schema-extension is released under the BSD-3-Clause License. See the bundled [LICENSE](LICENSE) file for details.
