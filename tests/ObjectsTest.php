<?php

use Abacus11\Collections\Doctrine\Objects;
use PHPUnit\Framework\TestCase;

class CollectionOfObjectsTest extends TestCase
{
    /**
     * @covers \Abacus11\Collections\Doctrine\Objects::__construct()
     */
    public function testObjectCollectionAcceptsOnlyObjects()
    {
        $collection = new Objects([new stdClass(), new class {}, function() {}, $this]);
        $this->expectException(\TypeError::class);
        $collection[] = 'text';
    }
}
