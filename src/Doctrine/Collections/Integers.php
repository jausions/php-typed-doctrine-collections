<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Integers extends CollectionOf
{
    /**
     * Collection of integers
     *
     * Each element of the collection is an integer
     *
     * @param integer[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_INTEGERS, $elements);
    }
}
