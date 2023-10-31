<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Booleans extends CollectionOf
{
    /**
     * Collection of booleans
     *
     * Each element of the collection is a boolean
     *
     * @param boolean[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_BOOLEANS, $elements);
    }
}
