<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Strings extends CollectionOf
{
    /**
     * Collection of strings
     *
     * Each element of the collection is a string
     *
     * @param string[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_STRINGS, $elements);
    }
}
