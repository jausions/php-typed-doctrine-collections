<?php

namespace Abacus11\Collections\Doctrine;

class Objects extends ArrayOf
{
    /**
     * Collection of objects
     *
     * Each element of the collection is an object
     *
     * @param object[] $elements
     *
     * @throws \AssertionError
     * @throws \Exception
     * @throws \TypeError
     */
    public function __construct(array $elements = [])
    {
        parent::__construct('object', $elements);
    }
}