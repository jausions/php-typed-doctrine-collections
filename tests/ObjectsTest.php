<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Objects;

require_once __DIR__ . '/TestCase.php';

class ObjectsTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Objects::__construct()
     */
    public function testObjectCollectionShouldOnlyAcceptObjects()
    {
        $collection = new Objects([new stdClass(), function() {}, $this]);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = 'text';
    }
}
