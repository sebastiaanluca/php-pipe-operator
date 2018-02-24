<?php

use SebastiaanLuca\PipeOperator\Item;

if (! function_exists('take')) {
    /**
     * Create a new piped item from a given value.
     *
     * @param mixed $value
     *
     * @return \SebastiaanLuca\PipeOperator\Item
     */
    function take($value) : Item
    {
        return new Item($value);
    }
}
