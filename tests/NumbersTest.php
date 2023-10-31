<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Numbers;

require_once __DIR__ . '/TestCase.php';

class NumbersTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Numbers::__construct()
     */
    public function testNumberCollectionShouldOnlyAcceptNumbers()
    {
        $collection = new Numbers(['123', -876543, 0, 9.876, '-4.5']);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = new stdClass();
    }
}
