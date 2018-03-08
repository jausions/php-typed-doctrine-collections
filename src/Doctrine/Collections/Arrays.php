<?php

namespace Abacus11\Doctrine\Collections;

class Arrays extends CollectionOf
{
    /**
     * Collection of arrays
     *
     * Each element of the collection is an array
     *
     * @param array[] $elements
     *
     * @throws \AssertionError
     * @throws \Exception
     * @throws \TypeError
     */
    public function __construct(array $elements = [])
    {
        parent::__construct('array', $elements);
    }
}