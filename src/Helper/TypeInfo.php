<?php

declare(strict_types = 1);

namespace Graphpommando\Helper;

interface TypeInfo
{
    public function allowsNull() : bool;

    public function getTypeName() : string;

    public function getNestedType() : TypeInfo;
}
