<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Integers;

require_once __DIR__ . '/TestCase.php';

class IntegersTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Integers::__construct()
     */
    public function testIntegerCollectionShouldOnlyAcceptIntegers()
    {
        $collection = new Integers([1, 0, 2]);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection[2] = 'Hello world!';
    }
}
