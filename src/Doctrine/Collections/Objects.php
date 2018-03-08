<?php

namespace Abacus11\Doctrine\Collections;

class Objects extends CollectionOf
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