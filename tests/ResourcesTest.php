<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Resources;

require_once __DIR__ . '/TestCase.php';

class ResourcesTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Resources::__construct()
     */
    public function testResourceCollectionShouldOnlyAcceptResources()
    {
        $collection = new Resources([fopen(__FILE__, 'rb'), opendir(__DIR__)]);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = 123;
    }
}
