<?php

namespace Abacus11\Doctrine\Collections;

use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Collections\Exception\TypeNotSetException;

/**
 * Trait to implement constraints on elements of a Doctrine collection
 *
 * @see \Doctrine\Common\Collections\Collection
 */
trait TypedCollectionTrait
{
    use \Abacus11\Collections\TypedCollectionTrait;

    /**
     * Adds an element at the end of the collection.
     *
     * @param mixed $element The element to add.
     *
     * @return bool Always TRUE.
     *
     * @throws InvalidArgumentTypeException when the value does not match the criterion of the collection
     * @throws TypeNotSetException when the criterion is not set
     */
    public function add($element)
    {
        if (!$this->isElementType($element)) {
            throw new InvalidArgumentTypeException('The value does not comply with the criterion for the collection.');
        }
        return parent::add($element);
    }

    /**
     * Sets an element in the collection at the specified key/index.
     *
     * @param string|int $key The key/index of the element to set.
     * @param mixed $value The element to set.
     *
     * @return void
     *
     * @throws InvalidArgumentTypeException when the value does not match the criterion of the collection
     * @throws TypeNotSetException when the criterion is not set
     */
    public function set($key, $value)
    {
        if (!$this->isElementType($value)) {
            throw new InvalidArgumentTypeException('The value does not comply with the criterion for the collection.');
        }
        parent::set($key, $value);
    }
}
