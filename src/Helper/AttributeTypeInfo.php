<?php

declare(strict_types = 1);

namespace Graphpommando\Helper;

final class AttributeTypeInfo implements TypeInfo
{
    public function __construct(
        private string $type,
        private bool $nullable,
        private ?self $nested = null,
    ) {}

    public function allowsNull() : bool
    {
        return $this->nullable;
    }

    public function getTypeName() : string
    {
        return $this->type;
    }

    public function getNestedType() : TypeInfo
    {
        return $this->nested
            ?? throw new \RuntimeException();
    }
}
