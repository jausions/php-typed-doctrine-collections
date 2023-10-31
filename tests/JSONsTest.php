<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\JSONs;

require_once __DIR__ . '/TestCase.php';

class JSONsTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\JSONs::__construct()
     */
    public function testJSONCollectionShouldOnlyAcceptsJSON()
    {
        $collection = new JSONs(['null', '{"key":"value"}']);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection['other'] = function() {};
    }
}
