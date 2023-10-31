<?php

use Abacus11\Collections\Exception\CannotChangeTypeException;
use Abacus11\Collections\Exception\InvalidArgumentTypeException;
use Abacus11\Collections\Exception\InvalidSampleException;
use Abacus11\Collections\Exception\TypeNotSetException;
use Abacus11\Doctrine\Collections\CollectionOf;
use Doctrine\Common\Collections\ArrayCollection;
use Faker\Factory;

require_once __DIR__ . '/TestCase.php';

class SomeTestClass {}

class SomeTestClassExtended extends SomeTestClass {}

/**
 * Test cases for Abacus11\Collections\Doctrine\CollectionOf class
 */
class CollectionOfTest extends \TestCase
{
    /**
     * Provides a list of matching type / value pairs
     *
     * @return array
     */
    public static function basicTypedElementsProvider()
    {
        $faker = Factory::create();

        return [
            ['array', $faker->words],
            ['boolean', $faker->boolean],
            ['callable', $faker->randomElement([
                function() {},
                function($a) {return $a;},
                'strtolower',
                [__CLASS__, __FUNCTION__],
            ])],
            ['double', $faker->randomFloat()],
            ['integer', $faker->numberBetween(-2147483646)],
            ['number', $faker->randomElement([
                $faker->numberBetween(-2147483646),
                $faker->randomFloat(),
                $faker->numerify('########'),
                $faker->numerify('#####.###'),
                $faker->numerify('-#####'),
                $faker->numerify('-#####.##'),
            ])],
            ['object', new stdClass()],
            ['resource', fopen(__FILE__, 'rb')],
            ['string', $faker->words(3, true)],
            [SomeTestClass::class, new SomeTestClass()],
            [SomeTestClass::class, new SomeTestClassExtended()],
        ];
    }

    /**
     * Provides a list of mismatched collection type / value type / value triplets
     *
     * @return array
     */
    public static function mismatchedBasicTypedElementsProvider()
    {
        $faker = Factory::create();

        // Type => alias types
        $aliases = [
            'array' => ['array', 'array_callback'],
            'bool' => ['bool', 'boolean'],
            'boolean' => ['bool', 'boolean'],
            'callable' => ['closure', 'function', 'callable', 'callback', 'string_callable', 'array_callback'],
            'callback' => ['closure', 'function', 'callable', 'callback', 'string_callable', 'array_callback'],
            'closure' => ['closure', 'function', 'callable', 'callback', 'string_callable', 'array_callback'],
            'double' => ['float', 'double'],
            'float' => ['float', 'double'],
            'function' => ['closure', 'function', 'callable', 'callback', 'string_callable', 'array_callback'],
            'int' => ['int', 'integer'],
            'integer' => ['int', 'integer'],
            'json' => ['json', 'string_number', 'string_callable'],
            'number' => ['int', 'integer', 'float', 'double', 'number', 'string_number'],
            'object' => ['object', 'closure', 'function', 'callable', 'callback'],
            'string' => ['string', 'text', 'string_number', 'json', 'string_callable'],
            'text' => ['string', 'text', 'string_number', 'json', 'string_callable'],
        ];

        $values = [
            'array' => $faker->words,
            'boolean' => $faker->boolean,
            'callable' => $faker->randomElement([
                ['array_callback', [__CLASS__, __FUNCTION__]],
                ['callable', function() {}],
                ['callable', function($a) {return $a;}],
                ['string_callable', 'strtolower'],
            ]),
            'double' => $faker->randomFloat(),
            'integer' => $faker->numberBetween(-2147483646),
            'json' => '{ "key": "value" }',
            'number' => $faker->randomElement([
                ['double', $faker->randomFloat()],
                ['integer', $faker->numberBetween(-2147483646)],
                ['string_number', $faker->numerify('######')],
                ['string_number', $faker->numerify('##.###')],
                ['string_number', $faker->numerify('-#####')],
                ['string_number', $faker->numerify('-##.##')],
            ]),
            'object' => new stdClass(),
            'string' => $faker->words(3, true),
        ];

        $data = [];
        foreach (array_keys($values) as $collection_type) {
            foreach ($values as $data_type => $value) {
                if ($data_type === 'number' || $data_type === 'callable') {
                    $data_type = $value[0];
                    $value = $value[1];
                }
                if (!in_array($data_type, $aliases[$collection_type])) {
                    $data[] = [$collection_type, $data_type, $value];
                }
            }
        }

        return $data;
    }

    /**
     * Provides a list of matching type / sample value / value triplets
     *
     * @return array
     */
    public static function sampleTypedElementsProvider()
    {
        $faker = Factory::create();

        return [
            ['array', $faker->words, $faker->words],
            ['array', [], $faker->words],
            ['boolean', true, $faker->boolean],
            ['boolean', false, $faker->boolean],
            ['callback', function() {}, function($a) {return $a;}],
            ['callback', function() {}, [__CLASS__, __FUNCTION__]],
            ['callback', function($a) { return $a; }, 'strtolower'],
            ['double', $faker->randomFloat(), $faker->randomFloat()],
            ['double', 0.0, $faker->randomFloat()],
            ['integer', $faker->numberBetween(-2147483646), $faker->numberBetween(-2147483646)],
            ['integer', 0, $faker->numberBetween(-2147483646)],
            ['object', new stdClass(), (object) []],
            ['object', new SomeTestClass(), new SomeTestClass()],
            ['resource', fopen(__FILE__, 'rb'), opendir(__DIR__)],
            ['string', $faker->words(3, true), $faker->words(3, true)],
            ['string', '', $faker->words(3, true)],
        ];
    }

    /**
     * Provides a list of mismatching sample type / sample / value type / value quads
     *
     * @return array
     */
    public static function mismatchedSampleTypedElementsProvider()
    {
        $faker = Factory::create();

        $samples = [
            'array' => $faker->words,
            'boolean' => $faker->boolean,
            'callback' => function() {},
            'double' => $faker->randomFloat(),
            'integer' => $faker->numberBetween(-2147483646),
            'object' => (object) [],
            'resource' => fopen(__FILE__, 'rb'),
            'string' => $faker->words(3, true),
        ];

        $values = [
            'array' => $faker->words,
            'boolean' => $faker->boolean,
            'callback' => $faker->randomElement([
                ['object', function() {}],
                ['array', [__CLASS__, __FUNCTION__]],
                ['string', 'strtoupper'],
            ]),
            'double' => $faker->randomFloat(),
            'integer' => $faker->numberBetween(-2147483646),
            'object' => (object) [],
            'resource' => opendir(__DIR__),
            'string' => $faker->words(3, true),
        ];

        $data = [];

        foreach ($samples as $sample_type => $sample) {
            foreach ($values as $value_type => $value) {
                if ($sample_type === $value_type) {
                    continue;
                }
                if ($value_type === 'callback') {
                    $value_type = $value[0];
                    $value = $value[1];
                }
                if ($sample_type != $value_type) {
                    $data[] = [$sample_type, $sample, $value_type, $value];
                }
            }
        }

        return $data;
    }

    /**
     * Provides a list of valid JSON
     *
     * @return array
     */
    public static function validJSONEncodedValuesProvider()
    {
        $faker = Factory::create();

        $object = new stdClass();
        $object->prop_1 = $faker->words;
        $object->prop_2 = $faker->date;
        $object->prop_3 = new stdClass();

        return [
            ['null'],
            ['true'],
            ['false'],
            [json_encode(new stdClass())],
            [json_encode($faker->words)],
            [json_encode($object)],
            [json_encode($faker->randomNumber())],
            [json_encode($faker->randomFloat())],
        ];
    }

    /**
     * Provides a list of invalid JSON
     *
     * @return array
     */
    public static function invalidJSONEncodedValuesProvider()
    {
        return [
            ['unquoted text'],
            ['{ "key": "<div style="color:yellow;">some text</div>" }'],
            ['{ key: \'value\' }'],
            ['{ key: ["value", .5, 
	{ "test": 56, 
	\'test2\': [true, null] }
	]
}'],
        ];
    }

    /**
     * @param string $type
     * @param mixed $value
     *
     * @dataProvider basicTypedElementsProvider
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::isElementType()
     */
    public function testValueShouldBeValidForSameTypeCollection($type, $value)
    {
        $collection = (new CollectionOf())->setElementType($type);
        $this->assertTrue($collection->isElementType($value));
    }

    /**
     * @param string $type
     * @param mixed $value
     *
     * @dataProvider mismatchedBasicTypedElementsProvider
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::isElementType()
     */
    public function testValueShouldNotBeValidForMismatchedTypeCollection($type, $type_element, $value)
    {
        $collection = (new CollectionOf())->setElementType($type);
        $this->assertFalse($collection->isElementType($value));
    }

    /**
     * @param string $type
     * @param mixed $value
     *
     * @dataProvider basicTypedElementsProvider
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::add()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::add()
     */
    public function testAddingValueToSameTypeCollectionShouldBePossible($type, $value)
    {
        $collection = (new CollectionOf())->setElementType($type);
        $collection[] = $value;
        $this->assertEquals($value, $collection->first());
    }

    /**
     * @param mixed $value
     *
     * @dataProvider validJSONEncodedValuesProvider
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::add()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::add()
     */
    public function testAddingValidJSONToJSONCollectionShouldBePossible($value)
    {
        $collection = (new CollectionOf())->setElementType('json');
        $collection[] = $value;
        $this->assertEquals($value, $collection->first());
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidJSONEncodedValuesProvider
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::add()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::add()
     */
    public function testAddingInvalidJSONToJSONCollectionShouldNotBePossible($value)
    {
        $collection = (new CollectionOf())->setElementType('json');

        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = $value;
    }

    /**
     * @param $type_collection
     * @param $type_element
     * @param mixed $element
     *
     * @dataProvider mismatchedBasicTypedElementsProvider
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::add()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::add()
     */
    public function testAddWrongBasicTypeToCollectionShouldNotBePossible($type_collection, $type_element, $element)
    {
        $collection = (new CollectionOf())->setElementType($type_collection);

        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = $element;
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::add()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::add()
     */
    public function testAddingElementToNonTypedCollectionShouldNotBePossible()
    {
        $collection = new CollectionOf();

        $this->expectException(TypeNotSetException::class);
        $collection[] = true;
    }

    /**
     * @param string $type
     * @param mixed $value
     *
     * @dataProvider basicTypedElementsProvider
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::set()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::set()
     */
    public function testSettingValueAtIndexInSameTypeCollectionShouldBePossible($type, $value)
    {
        $collection = (new CollectionOf())->setElementType($type);
        $collection['abc'] = $value;
        $this->assertEquals($value, $collection->first());
    }

    /**
     * @param mixed $value
     *
     * @dataProvider validJSONEncodedValuesProvider
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::set()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::set()
     */
    public function testSettingValidJSONAtIndexInJSONCollectionShouldBePossible($value)
    {
        $collection = (new CollectionOf())->setElementType('json');
        $collection['xyz'] = $value;
        $this->assertEquals($value, $collection->first());
    }

    /**
     * @param mixed $value
     *
     * @dataProvider invalidJSONEncodedValuesProvider
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::set()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::set()
     */
    public function testSettingInvalidJSONAtIndexInJSONCollectionShouldNotBePossible($value)
    {
        $collection = (new CollectionOf())->setElementType('json');

        $this->expectException(InvalidArgumentTypeException::class);
        $collection[123] = $value;
    }

    /**
     * @param $type_collection
     * @param $type_element
     * @param mixed $element
     *
     * @dataProvider mismatchedBasicTypedElementsProvider
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::set()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::set()
     */
    public function testSettingWrongBasicTypeAtIndexInCollectionShouldNotBePossible($type_collection, $type_element, $element)
    {
        $collection = new CollectionOf();
        $collection->setElementType($type_collection);

        $this->expectException(InvalidArgumentTypeException::class);
        $collection['456'] = $element;
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\TypedCollectionTrait::set()
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::set()
     */
    public function testSettingElementAtIndexInNonConfiguredCollectionShouldNotBePossible()
    {
        $collection = new CollectionOf();

        $this->expectException(TypeNotSetException::class);
        $collection[0] = true;
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::setElementType()
     */
    public function testChangingTheTypeOfNonEmptyCollectionShouldNotBePossible()
    {
        $collection = new CollectionOf();
        $collection->setElementType('string');
        $faker = Factory::create();
        $collection[] = $faker->word;

        $this->expectException(CannotChangeTypeException::class);
        $collection->setElementType('bool');
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::setElementType()
     */
    public function testChangingTheTypeOfTypedCollectionShouldNotBePossible()
    {
        $collection = new CollectionOf();
        $collection->setElementType('string');

        $this->expectException(CannotChangeTypeException::class);
        $collection->setElementType('bool');
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::setElementTypeLike()
     */
    public function testUsingNullAsSampleTypeShouldNotBePossible()
    {
        $this->expectException(InvalidSampleException::class);
        (new CollectionOf())->setElementTypeLike(null);
    }

    /**
     * @param string $type
     * @param mixed $sample
     * @param mixed $value
     *
     * @dataProvider sampleTypedElementsProvider
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::setElementTypeLike()
     */
    public function testAddingValidValueToLikeElementTypeCollectionShouldBePossible($type, $sample, $value)
    {
        $collection = new CollectionOf();
        $collection->setElementTypeLike($sample)
            ->add($value);
        $this->assertEquals($value, $collection->first());
    }

    /**
     * @param string $sample_type
     * @param mixed $sample
     * @param string $value_type
     * @param mixed $value
     *
     * @dataProvider mismatchedSampleTypedElementsProvider
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::setElementTypeLike()
     */
    public function testAddingInvalidValueToLikeElementTypeCollectionShouldNotBePossible($sample_type, $sample, $value_type, $value)
    {
        $collection = (new CollectionOf())->setElementTypeLike($sample);

        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = $value;
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::__construct()
     */
    public function testFirstElementShouldBlockFollowingWrongInitialValues()
    {
        $this->expectException(InvalidArgumentTypeException::class);
        new CollectionOf([1, '2', false, 2.5]);
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::__construct()
     */
    public function testFirstElementShouldSetTheTypeOfCollection()
    {
        $collection = new CollectionOf([1]);

        $this->expectException(InvalidArgumentTypeException::class);
        $collection[] = 'xyz';
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::__construct()
     */
    public function testFirstElementShouldLetPassFollowingValidInitialValues()
    {
        $collection = new CollectionOf([0, 1, 2, 3, 4]);
        $this->assertEquals($collection[4], 4);
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::__construct()
     */
    public function testInitializingCollectionWithNullValueShouldNotBePossible()
    {
        $this->expectException(InvalidSampleException::class);
        new CollectionOf([null, 'abc']);
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::__construct()
     */
    public function testInitializingCollectionWithNullTypeShouldNotBePossible()
    {
        $this->expectException(InvalidArgumentException::class);
        new CollectionOf(null, ['abc', 'xyz']);
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::__construct()
     */
    public function testInitializingCollectionWithNullSingleArgumentShouldNotBePossible()
    {
        $this->expectException(InvalidArgumentException::class);
        new CollectionOf(null);
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::map()
     */
    public function testMapShouldReturnANewUntypedCollection()
    {
        $collection = new CollectionOf('string', ['abc', 'vwxyz']);
        $mapped = $collection->map(function($value) {
            return strlen($value);
        });
        $this->assertNotInstanceOf(CollectionOf::class, $mapped);
        $this->assertInstanceOf(ArrayCollection::class, $mapped);
        $this->assertEquals([3, 5], $mapped->toArray());
    }

    /**
     * @covers \Abacus11\Doctrine\Collections\CollectionOf::mapOf()
     */
    public function testTypedMapShouldReturnANewTypedCollection()
    {
        $collection = new CollectionOf('string', ['abc', 'uvwxyz']);
        $mapped = $collection->mapOf(function($value) {
            return strlen($value);
        });
        $this->assertInstanceOf(CollectionOf::class, $mapped);
        $this->assertEquals([3, 6], $mapped->toArray());

        $this->expectException(InvalidArgumentTypeException::class);
        $mapped[] = 'efghij';
    }
}
