<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;

class Resources extends CollectionOf
{
    /**
     * Collection of resources
     *
     * Each element of the collection is a resource
     *
     * @param resource[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(TypedCollection::OF_PHP_RESOURCES, $elements);
    }
}
