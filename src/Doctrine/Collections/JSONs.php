<?php

namespace Abacus11\Doctrine\Collections;

class JSONs extends CollectionOf
{
    /**
     * Collection of JSON strings
     *
     * Each element of the collection is a JSON string
     *
     * @param string[] $elements
     *
     * @throws \AssertionError
     * @throws \Exception
     * @throws \TypeError
     */
    public function __construct(array $elements = [])
    {
        parent::__construct('json', $elements);
    }
}