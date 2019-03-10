<?php

/**
 * Class to enable type checking of object properties
 *
 * @author      Brian Moon <brianm@dealnews.com>
 * @copyright   1997-Present DealNews.com, Inc
 * @package     TypedObjects
 *
 */

namespace DealNews\TypedObjects;

/**
 * Class TypedProperty
 *
 * A child of this class must define the $CONSTRAINTS property which sets what data types are allowed into which properties.
 * This parent class allows you to easily create a strongly typed object.
 *
 * Constraints format is an array of arrays which have a string at the index 'type'.  The string must contain either a possible
 * output of the gettype() function or a valid, fully qualified class name.
 *
 */
abstract class TypedProperty {

    use Traits\FilterType;

    protected const CONSTRAINTS = [];

    /**
     * Getter
     *
     * @param  string $var Property to get
     *
     * @return mixed
     * @throws \LogicException  Thrown when an invalid property
     *                          is asked for
     */
    public function __get($var) {
        $value = null;

        /**
         * The thought process here is that if we have a property that is a typed property also, we would want it available so we can always
         * access it via the -> operator.  If this step wasn't here and you tried to access $foo->bar->baz, and bar was never instantiated
         * we would get a "property of null does not exist".  This saves having to always check for isset or !empty and makes the data
         * structure concrete.  If a data object has a data object as a property, assume it is always created and available.
         */
        if (!$this->__isset($var)) {
            $config = $this::CONSTRAINTS[$var];

            if (
                !empty($config['type'])
                && !ctype_lower($config['type'])
                && class_exists($config['type'])
            ) {
                $this->{$var} = new $config['type']();
            }
        }

        if ($this->__isset($var)) {
            $value = $this->$var;
        }

        return $value;
    }

    /**
     * Setter
     *
     * @param  string $var   Property to set
     * @param  mixed  $value Value to assign to the property
     *
     * @throws \LogicException Thrown when an invalid property is asked for
     * @throws \UnexpectedValueException
     */
    public function __set($var, $value) {

        if ($this->__exists($var)) {

            try {
                $this->{$var} = $this->filter_type($value, $this::CONSTRAINTS[$var]);
            } catch (\UnexpectedValueException $e) {
                throw new \UnexpectedValueException(
                    get_class($this)."::".$var." must be of type ".$this::CONSTRAINTS[$var]["type"].", ".gettype($value)." given."
                );
            }
        }
    }

    /**
     * Responds to isset() and empty()
     *
     * @param  string $var Property to check
     *
     * @return bool
     * @throws \LogicException
     */
    public function __isset($var) {
        return $this->__exists($var, false) && isset($this->$var);
    }

    /**
     * Unsetter
     *
     * @param  string $var Property to unset
     *
     * @throws \LogicException  Thrown when the property name is invalid
     */
    public function __unset($var) {

        if ($this->__exists($var)) {
            unset($this->$var);
        }
    }

    /**
     * Checks if the property is valid property name
     *
     * @param  string  $var             Property to check
     * @param  boolean $throw_exception If true, throw an exception if the property is not valid
     *
     * @return boolean
     * @throws \LogicException           Thrown when an invalid property is asked for
     */
    protected function __exists($var, $throw_exception = true) {

        $exists = (array_key_exists($var, $this::CONSTRAINTS) && property_exists($this, $var));

        if (!$exists && $throw_exception) {
            throw new \LogicException("Unknown property $var requested in ".get_class($this));
        }

        return $exists;
    }

    /**
     * Returns the object as an array
     *
     * @return array
     */
    public function to_array() {

        $output = [];

        foreach ($this::CONSTRAINTS as $key => $constraint) {

            $value = $this->$key;

            if (
                is_object($value) &&
                (
                    $value instanceof TypedProperty ||
                    $value instanceof TypedArray
                )
            ) {
                $output[$key] = $value->to_array();
            } else {
                $output[$key] = $value;
            }
        }

        return $output;
    }
}
