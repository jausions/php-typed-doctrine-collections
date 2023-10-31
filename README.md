# Typed Doctrine Collections

Type hinting is evolving but PHP still does not currently provide
a way to define the type of the elements of an array (a.k.a. Generics.)

This library is built on top of Doctrine/Collections to enforce type
checking on elements added to a collection. We could also call them
strongly typed arrays.

The aim is to leverage type hinting to help prevent bugs, or, at the very
least, detect them earlier in the development cycle.

For the purpose of this library, the term *type* is used loosely to
refer to built-in PHP types, classes, and even application-domain types.


## Installation

```sh
composer require jausions/php-typed-doctrine-collections
```

In the examples below, the `require 'vendor/autoload.php';` is implied.


## Type Defined by Initial Value

The first element passed to the constructor determines the criteria for
the elements that come after it.

```php
<?php

use Abacus11\Doctrine\Collections\CollectionOf;

$int_array = new CollectionOf([1, 2]);      // Okay
$int_array = new CollectionOf([1, '2']);    // Not okay, second element is of different type
$int_array = new CollectionOf([null, 1]);   // Not okay, first element has no type
```


## Type Defined by a Sample Value

The element validation is done against the type of a sample value.

```php
<?php

use Abacus11\Doctrine\Collections\CollectionOf;

$sample = 1;
$int_array = (new CollectionOf())->setElementTypeLike($sample);

$int_array[] = 2;              // Okay
$int_array[] = true;           // Not okay - throws an exception

class SomeClass {}

$sample = new SomeClass();
$some = (new CollectionOf())->setElementTypeLike($sample);

$some[] = new SomeClass();     // Okay
$some[] = new stdClass();      // Not okay - throws an exception
```

## Type Defined by a Closure

The elements added to the collection can be checked with a closure:

```php
<?php

use Abacus11\Doctrine\Collections\CollectionOf;

// Use the setElementType() method
$positive_int = (new CollectionOf())->setElementType(static function ($value) {
    if (!is_int($value)) {
        return false;
    }
    return ($value >= 0);
});

$positive_int['apples'] = 0;      // Okay
$positive_int['oranges'] = 10;    // Okay
$positive_int['bananas'] = -5;    // Not okay - throws an exception

// Or directly in the constructor
$negative_int = new CollectionOf(
    static function ($value) {
        if (!is_int($value)) {
            return false;
        }
        return ($value <= 0);
    }
);

$negative_int[] = -50;            // Okay
$negative_int[] = 5;              // Not okay - throws an exception
```


## Type Defined by a Class Name

Objects added to the collection can be checked against a class name:

```php
<?php

use Abacus11\Doctrine\Collections\CollectionOf;

class A {}

class B {}

class AA extends A {}

// Use the setElementType() method
$some_a = (new CollectionOf())->setElementType(A::class);

$some_a[] = new A();    // Okay
$some_a[] = new AA();   // Okay
$some_a[] = new B();    // Not okay - throws an exception

// Or directly in the constructor
$some_b = new CollectionOf(B::class);

$some_b[] = new B();    // Okay
$some_b[] = new A();    // Not okay - throws an exception
```


## Built-In Library Types

Apart from a closure or a class name, the `setElementType()` method also
accepts the following values:

- `TypedCollection::OF_ANYTHING`
- `TypedCollection::OF_ARRAYS`
- `TypedCollection::OF_BOOLEANS`
- `TypedCollection::OF_CALLABLES`
- `TypedCollection::OF_CLASSES_AND_INTERFACES`
- `TypedCollection::OF_DOUBLES`
- `TypedCollection::OF_INTEGERS`
- `TypedCollection::OF_JSON`
- `TypedCollection::OF_NUMBERS`
- `TypedCollection::OF_OBJECTS`
- `TypedCollection::OF_PHP_RESOURCES`
- `TypedCollection::OF_STRINGS`

```php
<?php

use Abacus11\Collections\TypedCollection;
use Abacus11\Doctrine\Collections\CollectionOf;

// Use the setElementType() method

$int_array = (new CollectionOf())->setElementType(TypedCollection::OF_INTEGERS);

$int_array[] = 1;      // Okay
$int_array[] = '1';    // Not okay - throws an exception

// Or directly in the constructor

$int_array = new CollectionOf(TypedCollection::OF_INTEGERS);

$int_array[] = 20;     // Okay
$int_array[] = true;   // Not okay - throws an exception
```


## Built-In Collections

Several typed collections are predefined:

- `\Abacus11\Doctrine\Collections\Arrays`
- `\Abacus11\Doctrine\Collections\Booleans`
- `\Abacus11\Doctrine\Collections\Callables`
- `\Abacus11\Doctrine\Collections\Doubles`
- `\Abacus11\Doctrine\Collections\Integers`
- `\Abacus11\Doctrine\Collections\Numbers`
- `\Abacus11\Doctrine\Collections\JSONs`
- `\Abacus11\Doctrine\Collections\Objects`
- `\Abacus11\Doctrine\Collections\Resources`
- `\Abacus11\Doctrine\Collections\Strings`

```php
<?php
$integers = new \Abacus11\Doctrine\Collections\Integers([1, 2, 3, 0, -1]);
```


## Custom Type Collections

You can easily create collections by extending the base class or by
including the trait into your own implementation of the ArrayAccess
interface.

> Remarks:
> 1. We could have type hinted the `enter()` method with the `Car` class instead
>    of the `Vehicle` class.
> 2. I am aware that I mixed the types in the *docBlock* and the signature of
>    the `getCars()` method. It is somewhat more legible and may help your IDE.
>    However, the benefit may vary depending on your editor / IDE, and it may
>    lead to confusion if trying to use some array function that expect a native
>    `array` type.

```php
<?php

use Abacus11\Doctrine\Collections\CollectionOf;

interface Vehicle {}

class Car implements Vehicle
{
    public $make;
    public $model;
    public $color;
    public $license_plate_number;
}

class Submarine implements Vehicle
{
    public $name;
}

class Cars extends CollectionOf
{
    /** @param Car[] $cars */
    public function __construct(array $cars = []) {
        parent::__construct(Car::class, $cars);
        // - or -
        //$this->setElementType(Car::class);
        //parent::__construct($cars);
    }
}

class Parking
{
    /** @var Cars */
    protected $lot;

    public function __construct()
    {
        $this->lot = new Cars([]);
    }

    public function enter(Vehicle $car)
    {
        $this->lot[] = $car;
    }

    /**
     * @return Car[] The collection of cars
     */
    public function getCars(): Cars
    {
        return $this->lot;
    }

    //...
}

$my_car = new Car();
$my_car->model = 'T';
$my_car->make = 'Ford';
$my_car->color = 'Black';
$my_car->license_plate_number = 'MI-01234';

$my_sub = new Submarine();
$my_sub->name = 'Nautilus';

$parking = new Parking();
$parking->enter($my_car);   // Okay
$parking->enter($my_sub);   // Not okay - throws an exception
```
