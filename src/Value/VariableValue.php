<?php

declare(strict_types = 1);

namespace Graphpommando\Value;

final class VariableValue implements Value
{
    public function __construct(
        private string $variableName
    ) {}

    public function print() : string
    {
        return '$' . $this->variableName;
    }
}
