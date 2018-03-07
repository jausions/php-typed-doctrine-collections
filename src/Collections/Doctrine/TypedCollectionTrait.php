<?php

namespace Abacus11\Collections\Doctrine;

/**
 * Trait to implement constraints on elements of a Doctrine collection
 *
 * @author Philippe Jausions <Philippe.Jausions@11abacus.com>
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
     * @throws \TypeError when the value doesnt match the criteria
     * @throws \AssertionError when the criteria is not set
     */
    public function add($element): bool
    {
        if (!$this->isElementType($element)) {
            throw new \TypeError('The value does not comply with the criteria for the collection.');
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
     * @throws \TypeError when the value doesnt match the criteria
     * @throws \AssertionError when the criteria is not set
     */
    public function set($key, $value): void
    {
        if (!$this->isElementType($value)) {
            throw new \TypeError('The value does not comply with the criteria for the collection.');
        }
        parent::set($key, $value);
    }
}