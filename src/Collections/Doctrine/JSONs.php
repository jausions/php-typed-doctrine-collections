<?php

namespace Abacus11\Collections\Doctrine;

class JSONs extends ArrayOf
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