<?php

declare(strict_types = 1);

namespace Graphpommando\Attribute;

/**
 * Class ConstructorPass
 *
 * if property is not scalar, pass scalar value as constructor argument
 * this is useful for \DateTime and other objects which wrap scalar value
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class ConstructorPass
{
    public function __construct() {}
}
