<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Arrays extends CollectionOf
{
    /**
     * Collection of arrays
     *
     * Each element of the collection is an array
     *
     * @param array[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_ARRAYS, $elements);
    }
}
