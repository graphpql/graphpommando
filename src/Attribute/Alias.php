<?php

declare(strict_types = 1);

namespace Graphpommando;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Alias
{
    public function __construct(
        public string $ofField,
    ) {}
}
