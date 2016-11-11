# atoum/json-schema-extension [![Build Status](https://travis-ci.org/atoum/json-schema-extension.svg?branch=master)](https://travis-ci.org/atoum/json-schema-extension)

This extension validates your JSON strings against a JSON-Schema [specification](http://json-schema.org/).

It also checks if a string a valid JSON string.

## Example

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

## Install it

Install extension using [composer](https://getcomposer.org):

```
composer require --dev atoum/json-schema-extension
```

Enable the extension using atoum configuration file:

```php
<?php

// .atoum.php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use mageekguy\atoum\jsonSchema;

$runner->addExtension(new jsonSchema\extension($script));
```

## Links

* [atoum](http://atoum.org)
* [atoum's documentation](http://docs.atoum.org)
* [JSON-Schema specification](http://json-schema.org/)

## License

json-schema-extension is released under the BSD-3-Clause License. See the bundled [LICENSE](LICENSE) file for details.

![atoum](http://atoum.org/images/logo/atoum.png)
