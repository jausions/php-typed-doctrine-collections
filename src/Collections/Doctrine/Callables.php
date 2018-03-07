<?php

namespace Abacus11\Collections\Doctrine;

class Callables extends ArrayOf
{
    /**
     * Collection of callables
     *
     * Each element of the collection is a callable
     *
     * @param callable[] $elements
     *
     * @throws \AssertionError
     * @throws \Exception
     * @throws \TypeError
     */
    public function __construct(array $elements = [])
    {
        parent::__construct('callable', $elements);
    }
}