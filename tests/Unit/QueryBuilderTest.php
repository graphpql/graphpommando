<?php

declare(strict_types = 1);

namespace Graphpommando\Tests\Unit;

final class QueryBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testSimple() : void
    {
        $builder = new \Graphpommando\QueryBuilder();
        $operation = new \Graphpommando\DefaultOperation('query', [], [], \Graphpommando\Tests\MainEntity::class);

        self::assertSame(
            'query{fieldInt fieldFloat fieldBool fieldString fieldAliasedString: fieldString subfield{fieldInt} listOfStrings matrixOfStrings listOfSubfields{fieldInt} matrixOfSubfields{fieldInt} fieldWithArgs(arg1: $var1) fieldDateTime fieldNullable}',
            $builder->build($operation),
        );
    }
}
