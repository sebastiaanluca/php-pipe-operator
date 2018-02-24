<?php

use SebastiaanLuca\PipeOperator\Item;

if (! function_exists('take')) {
    /**
     * Create a new piped item from a given value.
     *
     * @param mixed $value The value you want to process.
     * @param string $identifier The identifier to replace the value with in method calls that
     *     don't take the value as first parameter.
     *
     * @return \SebastiaanLuca\PipeOperator\Item
     */
    function take($value, $identifier = '$$') : Item
    {
        return new Item($value, $identifier);
    }
}
