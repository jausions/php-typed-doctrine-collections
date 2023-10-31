<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Strings;

require_once __DIR__ . '/TestCase.php';

class StringsTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Strings::__construct()
     */
    public function testStringCollectionShouldOnlyAcceptStrings()
    {
        $collection = new Strings(['abc', '']);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = true;
    }
}
