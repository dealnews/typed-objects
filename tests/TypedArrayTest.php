<?php

namespace DealNews\TypedObjects\Tests;

/**
 * @copyright 1997-2017 DealNews.com, Inc.
 * @author    Brian Moon <brianm@dealnews.com>
 * @package   TypedObjects
 * @group     unit
 */
class TypedArrayTest extends \PHPUnit\Framework\TestCase {

    public function testMerge() {
        $left     = new ExampleTypedPropertySet();
        $right    = new ExampleTypedPropertySet();
        $expected = new ExampleTypedPropertySet();

        $listing_a       = new ExampleTypedProperty();
        $listing_a->name = 'Testing A';

        $listing_b       = new ExampleTypedProperty();
        $listing_b->name = 'Testing B';

        $listing_c       = new ExampleTypedProperty();
        $listing_c->name = 'Testing C';

        $listing_d       = new ExampleTypedProperty();
        $listing_d->name = 'Testing D';

        $left[8]     = $listing_a;
        $left['foo'] = $listing_b;

        $right[]      = $listing_b;
        $right['foo'] = $listing_d;
        $right[8]     = $listing_c;

        $expected[]      = $listing_a;
        $expected[]      = $listing_b;
        $expected[]      = $listing_c;
        $expected['foo'] = $listing_d;

        $left->merge($right);

        $this->assertCount(4, $left);
        $this->assertEquals($expected, $left);
    }

    public function test_to_array() {
        $object = new ExampleTypedPropertySet();
        $item   = new ExampleTypedProperty();
        $object->append($item);

        $output   = $object->to_array();
        $expected = [
                [
                    'name'      => null,
                    'hire_date' => null,
                    'position'  => null,
                    'array_a'   => null,
                    'boolean_a' => null,
                    'float_a'   => null,
                    'int_a'     => null,
                    'parent'    => null,
                ],
        ];

        $this->assertEquals($expected, $output);
    }
}
