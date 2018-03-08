<?php

use Abacus11\Doctrine\Collections\Booleans;
use PHPUnit\Framework\TestCase;

class BooleansTest extends TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Booleans::__construct()
     */
    public function testBooleanCollectionAcceptsOnlyBooleans()
    {
        $collection = new Booleans([false, true, false]);
        $this->expectException(\TypeError::class);
        $collection[1] = 'abc';
    }
}
