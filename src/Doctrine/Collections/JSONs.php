<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class JSONs extends CollectionOf
{
    /**
     * Collection of JSON strings
     *
     * Each element of the collection is a JSON string
     *
     * @param string[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_JSON_STRINGS, $elements);
    }
}
