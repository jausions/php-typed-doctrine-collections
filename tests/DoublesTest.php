<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Doubles;

require_once __DIR__ . '/TestCase.php';

class DoublesTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Doubles::__construct()
     */
    public function testDoubleCollectionShouldOnlyAcceptDoubles()
    {
        $collection = new Doubles([1.1, 2.0, -3.45]);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection['xyz'] = 3;
    }
}
