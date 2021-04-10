<?php

declare(strict_types = 1);

namespace Graphpommando\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
final class Argument
{
    private \Graphpommando\Value\Value $value;

    public function __construct(
        private string $name,
        string $valueClass,
        array $valueArgs,
    )
    {
        $this->value = new $valueClass(...$valueArgs); // ugly hack, waiting for "new" to be allowed in static context
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getValue() : \Graphpommando\Value\Value
    {
        return $this->value;
    }
}
