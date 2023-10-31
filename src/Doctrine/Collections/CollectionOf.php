<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
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
     * new CollectionOf(function($i) { return is_integer($i); });
     * new CollectionOf(function($i) { return is_integer($i); }, [1, 2, 3]);
     * </code>
     *
     * @param array|string|\Closure $definition
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
                } else {
                    $type = $definition[0];
                    $elements = [];
                    if ($type === null) {
                        throw new \InvalidArgumentException('Argument cannot be NULL');
                    }
                }
                break;
            case 2:
                list($type, $elements) = $definition;
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
                    throw new InvalidArgumentTypeException('Value at position `'.$i.'` does not comply with the criterion for the collection');
                }
            }
        }
        parent::__construct($elements);
    }

    /**
     * {@inheritDoc}
     */
    public function map(\Closure $func)
    {
        return new parent(array_map($func, $this->toArray()));
    }

    /**
     * Applies the given function to each element in the collection and returns
     * a new typed collection with the elements returned by the function.
     *
     * @psalm-param Closure(T):U $func
     *
     * @return CollectionOf<U>
     * @psalm-return CollectionOf<TKey, U>
     *
     * @psalm-template U
     */
    public function mapOf(\Closure $func)
    {
        return new self(array_map($func, $this->toArray()));
    }
}
