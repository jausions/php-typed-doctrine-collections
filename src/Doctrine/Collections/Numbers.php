<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Numbers extends CollectionOf
{
    /**
     * Collection of numbers
     *
     * Each element of the collection is a number
     *
     * @param number[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_NUMBERS, $elements);
    }
}
