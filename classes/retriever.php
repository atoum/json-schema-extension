<?php

namespace mageekguy\atoum\jsonSchema;

use JsonSchema\Uri\Retrievers\UriRetrieverInterface;

class retriever implements UriRetrieverInterface
{
	protected $schema;

	public function __construct($schema)
	{
		$this->schema = $schema;
	}

	public function retrieve($uri)
	{
		return $this->schema;
	}

	public function getContentType()
	{
		return 'application/schema+json';
	}
} 