<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Callables extends CollectionOf
{
    /**
     * Collection of callables
     *
     * Each element of the collection is a callable
     *
     * @param callable[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_CALLABLES, $elements);
    }
}
