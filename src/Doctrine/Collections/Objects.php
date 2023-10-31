<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Objects extends CollectionOf
{
    /**
     * Collection of objects
     *
     * Each element of the collection is an object
     *
     * @param object[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_OBJECTS, $elements);
    }
}
