<?php

declare(strict_types = 1);

namespace Graphpommando\Tests\Unit;

final class EntityHydratorTest extends \PHPUnit\Framework\TestCase
{
    public function testSimple() : void
    {
        $hydrator = new \Graphpommando\EntityHydrator();
        $result = $hydrator->hydrate(\Graphpommando\Tests\MainEntity::class, \Infinityloop\Utils\Json::fromNative((object) [
            'data' => [
                'fieldInt' => 1,
                'fieldFloat' => 2.0,
                'fieldBool' => true,
                'fieldString' => '3',
                'fieldAliasedString' => '4',
                'subfield' => ['fieldInt' => 5],
                'listOfStrings' => ['6', '7'],
                'matrixOfStrings' => [['8'], [], ['9', '10']],
                'listOfSubfields' => [['fieldInt' => 11], ['fieldInt' => 12]],
                'matrixOfSubfields' => [[['fieldInt' => 13], ['fieldInt' => 14]], [['fieldInt' => 15]]],
                'fieldWithArgs' => 16,
                'fieldDateTime' => '2021-01-01',
                'fieldNullable' => null,
            ],
        ])->toString());

        self::assertInstanceOf(\Graphpommando\Tests\MainEntity::class, $result);
        \assert($result instanceof \Graphpommando\Tests\MainEntity);
        self::assertSame(1, $result->fieldInt);
        self::assertSame(2.0, $result->fieldFloat);
        self::assertTrue($result->fieldBool);
        self::assertSame('3', $result->fieldString);
        self::assertSame('4', $result->fieldAliasedString);
        self::assertInstanceOf(\Graphpommando\Tests\SubEntity::class, $result->subfield);
        self::assertSame(5, $result->subfield->fieldInt);
        self::assertSame(16, $result->fieldWithArgs);
        self::assertInstanceOf(\DateTime::class, $result->fieldDateTime);
        self::assertSame($result->fieldDateTime->format('Y-m-d'), '2021-01-01');
        self::assertNull($result->fieldNullable);
        self::assertIsArray($result->listOfStrings);

        foreach ($result->listOfStrings as $field) {
            self::assertIsString($field);
        }

        self::assertIsArray($result->listOfSubfields);

        foreach ($result->listOfSubfields as $field) {
            self::assertInstanceOf(\Graphpommando\Tests\SubEntity::class, $field);
        }

        self::assertIsArray($result->matrixOfStrings);

        foreach ($result->matrixOfStrings as $field) {
            self::assertIsArray($field);

            foreach ($field as $subField) {
                self::assertIsString($subField);
            }
        }

        self::assertIsArray($result->matrixOfSubfields);

        foreach ($result->matrixOfSubfields as $field) {
            self::assertIsArray($field);

            foreach ($field as $subField) {
                self::assertInstanceOf(\Graphpommando\Tests\SubEntity::class, $subField);
            }
        }
    }
}
