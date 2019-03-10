<?php

/**
 * @author      Brian Moon <brianm@dealnews.com>
 * @copyright   1997-Present DealNews.com, Inc
 * @package     TypedObjects
 */

namespace DealNews\TypedObjects;

/**
 * Class TypedArray
 *
 * A child of this class must declare one type of variable.  Then, any item placed into a child object must match that required type.
 *
 * @package DealNews\Core
 */
abstract class TypedArray extends \ArrayObject {

    use Traits\FilterType;

    protected const REQUIRED_TYPE = [];

    public function __construct() {
        // don't allow access to the parent constructor's parameters
        parent::__construct();
    }

    /**
     * Part of the ArrayObject requirements and allows for array access of this object.
     *
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    public function append($value) {
        $value = $this->filter_type($value, $this::REQUIRED_TYPE);
        parent::append($value);
    }

    /**
     * Part of the ArrayObject requirements and allows for array access of this object.
     *
     * @param mixed $values
     *
     * @return bool
     * @throws \UnexpectedValueException
     */
    public function exchangeArray($values) {

        foreach ($values as $k => $value) {
            $values[$k] = $this->filter_type($value, $this::REQUIRED_TYPE);
        }

        parent::exchangeArray($values);

        return true;
    }

    /**
     * Part of the ArrayObject requirements and allows for array access of this object.
     *
     * @param mixed $index
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    public function offsetSet($index, $value) {

        $value = $this->filter_type($value, $this::REQUIRED_TYPE);
        parent::offsetSet($index, $value);
    }

    /**
     * Takes another TypedArray and tries to merge the data with the same rules as array_merge.
     *
     * Specifically:
     *      "If the input arrays have the same string keys, then the [input] value for that key will overwrite the [current] one.
     *      If, however, the arrays contain numeric keys, the later value will not overwrite the original value, but will be appended."
     *
     * @param TypedArray $input
     *
     * @throws \UnexpectedValueException
     */
    public function merge(TypedArray $input) {

        $this->exchangeArray(
            array_merge(
                $this->getArrayCopy(),
                $input->getArrayCopy()
            )
        );
    }

    public function to_array() {
        $output = $this->getArrayCopy();

        foreach ($output as $key => $value) {

            if (is_object($value) && method_exists($value, 'to_array')) {
                $output[$key] = $value->to_array();
            } else {
                $output[$key] = $value;
            }
        }

        return $output;
    }
}
