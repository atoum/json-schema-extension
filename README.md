# atoum/json-schema-extension

![atoum](http://downloads.atoum.org/images/logo.png)

## Install it

Install extension using [composer](https://getcomposer.org):

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/jubianchi/atoum"
        },
        {
            "type": "vcs",
            "url": "https://github.com/jubianchi/json-schema-extension"
        }
    ],
    "require-dev": {
        "atoum/atoum": "dev-extension",
        "atoum/bdd-extension": "dev-master"
    },
}

```

Enable the extension using atoum configuration file:

```php
<?php

// .atoum.php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use mageekguy\atoum\jsonSchema;

$runner->addExtension(new jsonSchema\extension($script));
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
