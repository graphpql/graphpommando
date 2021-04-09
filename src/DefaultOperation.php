<?php

declare(strict_types = 1);

namespace Graphpommando;

final class DefaultOperation implements Operation
{
    public function __construct(
        private string $operationType,
        private array $variables,
        private array $directives,
        private string $entityClass,
    ) {}

    public function getOperationType() : string
    {
        return $this->operationType;
    }

    public function getVariables() : array
    {
        return $this->variables;
    }

    public function getDirectives() : array
    {
        return $this->directives;
    }

    public function getEntityClass() : string
    {
        return $this->entityClass;
    }
}
