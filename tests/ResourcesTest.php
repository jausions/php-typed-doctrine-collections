<?php

use Abacus11\Doctrine\Collections\Resources;
use PHPUnit\Framework\TestCase;

class ResourcesTest extends TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Resources::__construct()
     */
    public function testResourceCollectionAcceptsOnlyResources()
    {
        $collection = new Resources([fopen(__FILE__, 'r'), opendir(__DIR__)]);
        $this->expectException(\TypeError::class);
        $collection[] = 123;
    }
}
