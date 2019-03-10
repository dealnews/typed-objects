<?php

namespace DealNews\TypedObjects\Traits;

/**
 * Common trait for filtering types
 *
 * Detailed Class Description
 *
 * @author      Brian Moon <brianm@dealnews.com>
 * @copyright   1997-Present DealNews.com, Inc
 * @package     SomePackage
 */

trait FilterType {

    protected function filter_type($value, array $type) {

        $constraints = \DealNews\Constraints\Constraint::init();

        try {
            $new_value = $constraints->check($value, $type);
        } catch (\DealNews\Constraints\ConstraintException $e) {
            throw new \UnexpectedValueException(
                get_class($this)." only accepts values that are of type ".$type["type"].", ".
                (is_object($value) ? get_class($value) : gettype($value))." given."
            );
        }

        return $new_value;
    }
}
