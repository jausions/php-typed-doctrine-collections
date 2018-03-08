<?php

use Abacus11\Doctrine\Collections\Integers;
use PHPUnit\Framework\TestCase;

class IntegersTest extends TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Integers::__construct()
     */
    public function testIntegerCollectionAcceptsOnlyIntegers()
    {
        $collection = new Integers([1, 0, 2]);
        $this->expectException(\TypeError::class);
        $collection[2] = 'Hello world!';
    }
}
