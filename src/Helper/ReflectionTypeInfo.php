<?php

declare(strict_types = 1);

namespace Graphpommando\Helper;

final class ReflectionTypeInfo implements TypeInfo
{
    public function __construct(
        private \ReflectionProperty $reflectionProperty,
    ) {}

    public function allowsNull() : bool
    {
        return $this->reflectionProperty->getType()->allowsNull();
    }

    public function getTypeName() : string
    {
        return $this->reflectionProperty->getType()->getName();
    }

    public function getNestedType() : TypeInfo
    {
        $attributes = $this->reflectionProperty->getAttributes(\Graphpommando\OfType::class);

        return \count($attributes) === 1
            ? $attributes[0]->newInstance()->typeInfo
            : throw new \RuntimeException();
    }
}
