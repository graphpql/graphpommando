<?php

declare(strict_types = 1);

namespace Graphpommando;

final class QueryBuilder
{
    public const SCALAR_TYPES = [
        'string' => 1,
        'int' => 1,
        'float' => 1,
        'bool' => 1,
    ];

    public function build(Operation $operation) : string
    {
        return $operation->getOperationType()
            . $this->buildVariableDefinition($operation->getVariables())
            . $this->buildDirectives($operation->getDirectives())
            . $this->buildEntity($operation->getEntityClass());
    }

    private function buildEntity(string $entityClass) : string
    {
        $reflection = new \ReflectionClass($entityClass);
        $fields = [];

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $fields[] = $this->buildFieldName($property)
                . $this->buildArguments($property)
                . $this->buildSelectionSet(new \Graphpommando\Helper\ReflectionTypeInfo($property));
        }

        return '{' . \implode(' ', $fields) . '}';
    }

    private function buildVariableDefinition(array $variables) : string
    {
        if (\count($variables) === 0) {
            return '';
        }

        $return = [];

        foreach ($variables as $variable) {

        }

        return '(' . \implode(', ', $return) . ')';
    }

    private function buildDirectives(array $directives) : string
    {
        if (\count($directives) === 0) {
            return '';
        }

        $return = [];

        foreach ($directives as $directive) {

        }

        return ' ' . \implode(' ', $return) . ' ';
    }

    private function buildFieldName(\ReflectionProperty $property) : string
    {
        $attributes = $property->getAttributes(\Graphpommando\Attribute\Alias::class);

        if (\count($attributes) === 0) {
            return $property->getName();
        }

        return $property->getName() . ': ' . $attributes[0]->newInstance()->ofField;
    }

    private function buildArguments(\ReflectionProperty $property) : string
    {
        $return = [];

        foreach ($property->getAttributes(\Graphpommando\Attribute\Argument::class) as $attribute) {
            $arg = $attribute->newInstance();
            \assert($arg instanceof \Graphpommando\Attribute\Argument);

            $return[] = $arg->getName() . ': ' . $arg->getValue()->print();
        }

        return \count($return) === 0
            ? ''
            : '(' . \implode(', ', $return) . ')';
    }

    private function buildSelectionSet(\Graphpommando\Helper\TypeInfo $typeInfo) : string
    {
        $typeName = $typeInfo->getTypeName();

        if (\array_key_exists($typeName, self::SCALAR_TYPES) || $typeInfo->isConstructorPass()) {
            return '';
        }

        if ($typeName === 'array') {
            return $this->buildSelectionSet($typeInfo->getNestedType());
        }

        return $this->buildEntity($typeName);
    }
}
