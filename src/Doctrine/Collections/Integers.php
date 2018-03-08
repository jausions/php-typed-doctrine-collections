<?php

namespace Abacus11\Doctrine\Collections;

class Integers extends CollectionOf
{
    /**
     * Collection of integers
     *
     * Each element of the collection is an integer
     *
     * @param integer[] $elements
     *
     * @throws \AssertionError
     * @throws \Exception
     * @throws \TypeError
     */
    public function __construct(array $elements = [])
    {
        parent::__construct('integer', $elements);
    }
}