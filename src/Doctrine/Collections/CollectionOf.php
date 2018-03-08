<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\TypedCollection;
use Doctrine\Common\Collections\ArrayCollection;

class CollectionOf extends ArrayCollection implements TypedCollection
{
    use TypedCollectionTrait;

    /**
     * Initialize the array-like collection
     *
     * Without any arguments:
     * <code>
     * new CollectionOf();       // Type is undefined
     * </code>
     *
     * With a type:
     * <code>
     * new CollectionOf('integer');
     * new CollectionOf('integer', []);
     * new CollectionOf('integer', [1, 2, 3]);
     * </code>
     *
     * With an initial array:
     * <code>
     * new CollectionOf([]);     // Type is undefined
     * new CollectionOf([1, 2, 3]);
     * </code>
     *
     * With a closure:
     * <code>
     * new CollectionOf(function($i) {return is_integer($i);});
     * new CollectionOf(function($i) {return is_integer($i);}, [1, 2, 3]);
     * </code>
     *
     * @param array|string|\Closure $definition
     *
     * @throws \AssertionError
     * @throws \Exception
     * @throws \TypeError
     *
     * @see CollectionOf::setElementType()
     * @see CollectionOf::setElementTypeLike()
     */
    public function __construct(...$definition)
    {
        switch (count($definition)) {
            case 0:
                $type = null;
                $elements = [];
                break;
            case 1:
                if (is_array($definition[0])) {
                    $type = null;
                    $elements = $definition[0];
                    if (!is_array($elements)) {
                        throw new \InvalidArgumentException('Argument must be an array');
                    }
                } else {
                    $type = $definition[0];
                    $elements = [];
                    if ($type === null) {
                        throw new \InvalidArgumentException('Argument cannot be NULL');
                    }
                }
                break;
            case 2:
                $type = $definition[0];
                $elements = $definition[1];
                if ($type === null) {
                    throw new \InvalidArgumentException('First argument cannot be NULL');
                }
                if (!is_array($elements)) {
                    throw new \InvalidArgumentException('Second argument must be an array');
                }
                break;
            default:
                throw new \InvalidArgumentException('Too many arguments');
        }
        if ($type !== null && !$this->isElementTypeSet()) {
            $this->setElementType($type);
        }
        if (!empty($elements)) {
            // Use the first element as type
            if (!$this->isElementTypeSet()) {
                $this->setElementTypeLike(reset($elements));
            }
            foreach ($elements as $i => $element) {
                if (!$this->isElementType($element)) {
                    throw new \TypeError('Value at position `'.$i.'` does not comply with the criteria for the collection');
                }
            }
        }
        parent::__construct($elements);
    }
}