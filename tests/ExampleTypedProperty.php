<?php
/**
 * @copyright 1997-2017 DealNews.com, Inc.
 * @author    Adam Bjurstrom <abjurstrom@dealnews.com>
 * @version   0.1.1
 */

namespace DealNews\TypedObjects\Tests;

use DealNews\TypedObjects\TypedProperty;

/**
 * Class ExampleTypedProperty
 *
 * @package DealNews\TypedObjects
 *
 * @property string $name
 * @property string $hire_date
 * @property string $position
 * @property array  $array_a
 * @property bool   $boolean_a
 * @property float  $float_a
 * @property int    $int_a
 */
class ExampleTypedProperty extends TypedProperty {

    protected $name;
    protected $hire_date;
    protected $position;
    protected $array_a;
    protected $boolean_a;
    protected $float_a;
    protected $int_a;
    protected $parent;

    protected const CONSTRAINTS = [
        'name'      => [
            'type' => 'string'
        ],
        'hire_date' => [
            'type' => '\DealNews\TypedObjects\Tests\ExampleTypedSubProperty'
        ],
        'parent'    => [
            'type' => '\DealNews\TypedObjects\Tests\ExampleTypedProperty'
        ],
        'position'  => [
            'type' => 'string'
        ],
        'array_a'   => [
            'type' => 'array',
            'constraint' => [
                'type' => '\DealNews\TypedObjects\Tests\ExampleTypedSubProperty'
            ]
        ],
        'boolean_a' => [
            'type' => 'boolean'
        ],
        'float_a'   => [
            'type' => 'double'
        ],
        'int_a'     => [
            'type' => 'integer'
        ],
    ];
}
