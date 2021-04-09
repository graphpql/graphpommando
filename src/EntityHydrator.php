<?php

declare(strict_types = 1);

namespace Graphpommando;

final class EntityHydrator
{
    private const SCALAR_TYPES = [
        'string' => 1,
        'int' => 1,
        'float' => 1,
        'bool' => 1,
    ];

    public function hydrate(string $class, string $responseJson) : Entity
    {
        $json = \Infinityloop\Utils\Json::fromString($responseJson)->toNative();

        return $this->recursiveHydrate($class, $json->data);
    }

    private function recursiveHydrate(string $objectClass, \stdClass|array|string|int|float|bool|null $data) : Entity
    {
        $object = new $objectClass();
        $reflection = new \ReflectionClass($objectClass);

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $value = $data->{$property->getName()};

            $object->{$property->getName()} = $this->getAppropriateValue(
                new \Graphpommando\Helper\ReflectionTypeInfo($property),
                $value,
            );
        }

        return $object;
    }

    private function getAppropriateValue(
        \Graphpommando\Helper\TypeInfo $typeInfo,
        \stdClass|array|string|int|float|bool|null $value,
    ) : Entity|array|string|int|float|bool|null
    {
        if ($value === null && $typeInfo->allowsNull()) {
            return null;
        }

        $typeName = $typeInfo->getTypeName();

        if (\is_scalar($value)) {
            if (\array_key_exists($typeName, self::SCALAR_TYPES)) {
                return $value;
            }

            // if property is not scalar, try to pass scalar value as constructor argument
            // useful for \DateTime and other objects which wrap scalar value
            return $typeName($value);
        }

        if (\is_array($value)) {
            $return = [];

            foreach ($value as $item) {
                $return[] = $this->getAppropriateValue($typeInfo->getNestedType(), $item);
            }

            return $return;
        }

        if ($value instanceof \stdClass) {
            // asserts that the type is really an object and not scalar or array
            \assert(\class_exists($typeName));

            return $this->recursiveHydrate($typeName, $value);
        }

        throw new \RuntimeException();
    }
}
