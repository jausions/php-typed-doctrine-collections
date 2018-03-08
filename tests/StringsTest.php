<?php

use Abacus11\Doctrine\Collections\Strings;
use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Strings::__construct()
     */
    public function testStringCollectionAcceptsOnlyStrings()
    {
        $collection = new Strings(['abc', '']);
        $this->expectException(\TypeError::class);
        $collection[] = true;
    }
}
