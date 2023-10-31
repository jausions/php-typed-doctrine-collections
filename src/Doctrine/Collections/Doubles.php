<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Doubles extends CollectionOf
{
    /**
     * Collection of doubles
     *
     * Each element of the collection is a double (also known as float in PHP.)
     *
     * @param double[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_DOUBLES, $elements);
    }
}
