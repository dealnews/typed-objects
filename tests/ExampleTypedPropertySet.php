<?php

/**
 * Container for a set of Listing objects
 *
 * @author      Adam Bjurstrom <abjurstrom@dealnews.com>
 * @copyright   1997-Present DealNews.com, Inc
 * @package     Core
 */

namespace DealNews\TypedObjects\Tests;

use DealNews\TypedObjects\TypedArray;

class ExampleTypedPropertySet extends TypedArray {
    protected const REQUIRED_TYPE = [
        'type' => 'DealNews\TypedObjects\Tests\ExampleTypedProperty'
    ];
}
