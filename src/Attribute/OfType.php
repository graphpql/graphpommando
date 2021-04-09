<?php

declare(strict_types = 1);

namespace Graphpommando;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class OfType
{
    public function __construct(
        public \Graphpommando\Helper\AttributeTypeInfo $ofType,
    ) {}
}
