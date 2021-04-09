<?php

declare(strict_types = 1);

namespace Graphpommando;

final class QueryBuilder
{
    public function build(Operation $operation) : string
    {
        return $operation->getOperationType()
            . $this->buildVariables($operation->getVariables())
            . $this->buildDirectives($operation->getDirectives())
            . $this->buildEntity($operation->getEntityClass());
    }

    private function buildEntity(string $entityClass) : string
    {
        $reflection = new \ReflectionClass($entityClass);
        $fields = [];

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {

        }

        return '{' . \implode(' ', $fields) . '}';
    }

    private function buildVariables(array $variables) : string
    {

    }

    private function buildDirectives(array $variables) : string
    {

    }
}
