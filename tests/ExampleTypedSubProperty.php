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
 * @property string  $time
 * @property string  $date
 * @property boolean $daylight_savings_time
 */
class ExampleTypedSubProperty extends TypedProperty {

    protected const CONSTRAINTS = [
        'time'                  => ['type' => 'string'],
        'date'                  => ['type' => 'string'],
        'daylight_savings_time' => ['type' => 'boolean'],
    ];

    protected $time;
    protected $date;
    protected $daylight_savings_time;
}
