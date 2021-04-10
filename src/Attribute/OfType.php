<?php

declare(strict_types = 1);

namespace Graphpommando\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class OfType
{
    private \Graphpommando\Helper\AttributeTypeInfo $ofType;

    public function __construct(string $type, bool $nullable, ?array $nested = null,
    ) {
        $this->ofType = new \Graphpommando\Helper\AttributeTypeInfo($type, $nullable, $nested);
    }

    public function getTypeInfo() : \Graphpommando\Helper\AttributeTypeInfo
    {
        return $this->ofType;
    }
}
