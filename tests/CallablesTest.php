<?php

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Doctrine\Collections\Callables;

require_once __DIR__ . '/TestCase.php';

class CallablesTest extends \TestCase
{
    /**
     * @covers \Abacus11\Doctrine\Collections\Callables::__construct()
     */
    public function testCallableCollectionShouldOnlyAcceptCallables()
    {
        $collection = new Callables([function() {}, [$this, __FUNCTION__], 'ucfirst']);
        $this->expectException(InvalidArgumentTypeException::class);
        $collection['abc'] = 3.1415;
    }
}
