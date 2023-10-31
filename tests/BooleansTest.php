<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Booleans;

require_once __DIR__ . '/TestCase.php';

class BooleansTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Booleans::__construct()
     */
    public function testBooleanCollectionShouldOnlyAcceptBooleans()
    {
        $collection = new Booleans([false, true, false]);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection[1] = 'abc';
    }
}
