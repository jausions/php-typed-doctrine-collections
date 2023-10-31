<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Arrays;

require_once __DIR__ . '/TestCase.php';

class ArraysTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Arrays::__construct()
     */
    public function testArrayCollectionShouldOnlyAcceptArrays()
    {
        $collection = new Arrays([[], [1, 2, 3], ['a', 'b', 'c']]);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = false;
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\Arrays::map()
     */
    public function testArrayCollectionShouldBeMappable()
    {
        $collection = new Arrays([[], [1, 2, 3], ['a', 'b', 'c', 'd']]);
        $mapped = $collection->map(function ($element) {
            return count($element);
        });

        $this->assertEquals([0, 3, 4], $mapped->toArray());
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\Arrays::mapOf()
     */
    public function testArrayCollectionShouldBeMappableWithType()
    {
        $collection = new Arrays([[], [1, 2, 3], ['a', 'b', 'c', 'd']]);
        $mapped = $collection->mapOf(function ($element) {
            return empty($element);
        });

        $this->assertEquals([true, false, false], $mapped->toArray());

        $this->expectException(InvalidArgumentTypeException::class);
        $mapped->set(3, '1');
    }
}
