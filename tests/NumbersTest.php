<?php

use Abacus11\Doctrine\Collections\Numbers;
use PHPUnit\Framework\TestCase;

class NumbersTest extends TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Numbers::__construct()
     */
    public function testNumberCollectionAcceptsOnlyNumbers()
    {
        $collection = new Numbers(['123', -876543, 0, 9.876, '-4.5']);
        $this->expectException(\TypeError::class);
        $collection[] = new stdClass();
    }
}
