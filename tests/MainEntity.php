<?php

declare(strict_types = 1);

namespace Graphpommando\Tests;

final class MainEntity implements \Graphpommando\Entity
{
    public int $fieldInt;
    public float $fieldFloat;
    public bool $fieldBool;
    public string $fieldString;
    #[\Graphpommando\Attribute\Alias('fieldString')]
    public string $fieldAliasedString;
    public SubEntity $subfield;
    #[\Graphpommando\Attribute\OfType('string', false)]
    public array $listOfStrings;
    #[\Graphpommando\Attribute\OfType('array', false, ['string', false])]
    public array $matrixOfStrings;
    #[\Graphpommando\Attribute\OfType(SubEntity::class, false)]
    public array $listOfSubfields;
    #[\Graphpommando\Attribute\OfType('array', false, [SubEntity::class, false])]
    public array $matrixOfSubfields;
    #[\Graphpommando\Attribute\Argument('arg1', \Graphpommando\Value\VariableValue::class, ['var1'])]
    public int $fieldWithArgs;
    #[\Graphpommando\Attribute\ConstructorPass]
    public \DateTime $fieldDateTime;
    public ?int $fieldNullable;
}
