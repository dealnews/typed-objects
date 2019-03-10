<?php
/**
 * @copyright 1997-2018 DealNews.com, Inc.
 * @author    Adam Bjurstrom <abjurstrom@dealnews.com>
 * @version   0.1.1
 */

namespace DealNews\TypedObjects\Tests;


class TypedPropertyTest extends \PHPUnit\Framework\TestCase {

    public function test_construct() {
        $object = new ExampleTypedProperty();
        $this->assertNotEmpty($object->hire_date);
        $this->assertInstanceOf('\DealNews\TypedObjects\Tests\ExampleTypedSubProperty', $object->hire_date);
    }

    /**
     * @expectedException \LogicException
     */
    public function test_bad_property_set() {
        $object      = new ExampleTypedProperty();
        $object->baz = 'foo';
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function test_wrong_value_scalar() {
        $object       = new ExampleTypedProperty();
        $object->name = ['Johnny', 'Johnson'];
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function test_wrong_value_object() {
        $object            = new ExampleTypedProperty();
        $object->hire_date = new \stdClass();
    }

    public function test_filter_value() {
        $object = new ExampleTypedProperty();

        $object->name      = 12345;
        $object->array_a   = new \ArrayObject();
        $object->boolean_a = "true";
        $object->float_a   = "1";
        $object->int_a     = "10";

        $this->assertSame(
            "12345",
            $object->name
        );

        $this->assertSame(
            [],
            $object->array_a
        );

        $this->assertSame(
            true,
            $object->boolean_a
        );

        $this->assertSame(
            1.0,
            $object->float_a
        );

        $this->assertSame(
            10,
            $object->int_a
        );
    }

    public function testUnset() {
        $object       = new ExampleTypedProperty();
        $object->name = 'test';

        $this->assertSame(
            'test',
            $object->name
        );

        unset($object->name);

        $this->assertFalse(isset($object->name));
    }

    public function testToArray() {
        $object       = new ExampleTypedProperty();
        $object->name = 'test';

        $hire_date         = new ExampleTypedSubProperty();
        $hire_date->date   = '1997-01-01';
        $object->hire_date = $hire_date;

        $expected = [
            'name'      => 'test',
            'hire_date' =>
                [
                    'time'                  => null,
                    'date'                  => '1997-01-01',
                    'daylight_savings_time' => null,
                ],
            'position'  => null,
            'array_a'   => null,
            'boolean_a' => null,
            'float_a'   => null,
            'int_a'     => null,
            'parent'    => null,
        ];
        $this->assertEquals($expected, $object->to_array());
    }
}
